<?php

namespace App\Console\Commands;

use App\Mail\PaymentReminderMail;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPaymentReminders extends Command
{
    protected $signature = 'payment:send-reminders';
    protected $description = 'Send payment reminder emails for pending payments';

    public function handle()
    {
        try {
            $this->info('Starting payment reminder check...');

            $allPendingPayments = Payment::where('status', 'pending')
                ->where('payment_mail_sent', 0)
                ->get();

            $this->info("Total pending payments (no time filter): {$allPendingPayments->count()}");

            $currentTimeFilterPayments = Payment::where('status', 'pending')
                ->where('created_at', '<=', Carbon::now()->subMinutes(5))
                ->where('created_at', '>=', Carbon::now()->subMinutes(6))
                ->where('payment_mail_sent', 0)
                ->get();

            $this->info("Payments with 5-6 minute time filter: {$currentTimeFilterPayments->count()}");

            $startTime = Carbon::now()->subMinutes(6);
            $endTime = Carbon::now()->subMinutes(5);
            $this->info("Looking for payments between: {$startTime} and {$endTime}");

            $pendingPayments = Payment::where('status', 'pending')
                ->where('created_at', '<=', Carbon::now()->subMinutes(1)) 
                ->where('payment_mail_sent', 0)
                ->get();

            $this->info("Found {$pendingPayments->count()} pending payments to process");

            $emailsSent = 0;
            $errors = 0;

            foreach ($pendingPayments as $payment) {
                try {
                    $order = DB::table('order_master')
                        ->where('order_id', $payment->order_id)
                        ->first();

                    if (!$order) {
                        $this->warn("Order not found for payment ID: {$payment->id}");
                        continue;
                    }

                    $customer = DB::table('customers')
                        ->where('id', $order->customer_id)
                        ->first();

                    if (!$customer) {
                        $this->warn("Customer not found for order ID: {$order->order_id}");
                        continue;
                    }

                    $orderDetails = DB::table('order_details')
                        ->leftJoin('products', 'order_details.product_id', '=', 'products.id')
                        ->where('order_details.order_id', $order->order_id)
                        ->select(
                            'order_details.*',
                            'products.product_name'
                        )
                        ->get();

                    $paymentLink = $this->generatePaymentLink($order);

                    if ($paymentLink) {
                        Mail::to($customer->billing_email)
                            ->send(new PaymentReminderMail($order, $customer, $orderDetails, $paymentLink));

                        $payment->update(['payment_mail_sent' => 1]);

                        $emailsSent++;
                        $this->info("Reminder sent for Payment ID #{$payment->id}, Order #{$order->order_id} to {$customer->billing_email}");
                    } else {
                        $this->error("Failed to generate payment link for Payment ID #{$payment->id}, Order #{$order->order_id}");
                        $errors++;
                    }
                } catch (\Exception $e) {
                    $this->error("Error processing payment ID {$payment->id}: " . $e->getMessage());
                    $errors++;
                }
            }

            $this->info("Payment reminder check completed. Emails sent: {$emailsSent}, Errors: {$errors}");
        } catch (\Exception $e) {
            $this->error('Payment reminder cron failed: ' . $e->getMessage());
        }
    }

    private function generatePaymentLink($order)
    {
        try {
            $provider = new \Srmklive\PayPal\Services\PayPal;
            $provider->getAccessToken();

            $paypalOrder = [
                'intent' => 'CAPTURE',
                'application_context' => [
                    'return_url' => route('paypal.success'),
                    'cancel_url' => route('paypal.cancel'),
                ],
                'purchase_units' => [
                    [
                        'reference_id' => $order->order_number,
                        'amount' => [
                            'currency_code' => config('paypal.currency', 'USD'),
                            'value' => number_format($order->total, 2, '.', ''),
                        ],
                        'description' => "Order #{$order->order_number}",
                    ]
                ]
            ];

            $response = $provider->createOrder($paypalOrder);

            if (isset($response['id']) && $response['id']) {
                Payment::where('order_id', $order->order_id)
                    ->update([
                        'transaction_id' => $response['id'],
                        'status' => 'pending',
                        'updated_at' => now()
                    ]);

                $approveLink = collect($response['links'])
                    ->firstWhere('rel', 'approve')['href'] ?? null;

                return $approveLink;
            }
        } catch (\Exception $e) {
            notyf()->error('Failed to generate payment link');
        }

        return null;
    }
}
