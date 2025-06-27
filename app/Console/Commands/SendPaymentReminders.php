<?php
// app/Console/Commands/SendPaymentReminders.php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use App\Mail\PaymentReminderMail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;

class SendPaymentReminders extends Command
{
    protected $signature = 'payment:send-reminders';
    protected $description = 'Send payment reminder emails for pending payments';

    public function handle()
    {
        try {
            $this->info('Starting payment reminder check...');

            $pendingPayments = Payment::where('status', 'pending')
                ->where('created_at', '<=', Carbon::now()->subMinutes(10))
                ->get();

            $emailsSent = 0;
            $errors = 0;

            foreach ($pendingPayments as $payment) {
                try {
                    // Get order details
                    $order = DB::table('order_master')
                        ->where('order_id', $payment->order_id)
                        ->first();

                    if (!$order) {
                        $this->warn("Order not found for payment ID: {$payment->id}");
                        continue;
                    }

                    // Check if reminder already sent or if it's too soon to send another
                    if ($order->payment_reminder_sent && 
                        $order->payment_reminder_sent_at && 
                        Carbon::parse($order->payment_reminder_sent_at)->diffInHours(now()) < 24) {
                        continue; // Skip if reminder sent in last 24 hours
                    }

                    // Get customer details
                    $customer = DB::table('customers')
                        ->where('id', $order->customer_id)
                        ->first();

                    if (!$customer) {
                        $this->warn("Customer not found for order ID: {$order->order_id}");
                        continue;
                    }

                    // Get order details
                    $orderDetails = DB::table('order_details')
                        ->leftJoin('products', 'order_details.product_id', '=', 'products.id')
                        ->where('order_details.order_id', $order->order_id)
                        ->select(
                            'order_details.*',
                            'products.product_name'
                        )
                        ->get();

                    // Generate new payment link
                    $paymentLink = $this->generatePaymentLink($order);

                    if ($paymentLink) {
                        // Send reminder email
                        Mail::to($customer->billing_email)
                            ->send(new PaymentReminderMail($order, $customer, $orderDetails, $paymentLink));

                        // Update order to mark reminder as sent
                        DB::table('order_master')
                            ->where('order_id', $order->order_id)
                            ->update([
                                'payment_reminder_sent' => 1,
                                'payment_reminder_sent_at' => now()
                            ]);

                        $emailsSent++;
                        $this->info("Reminder sent for Order #{$order->order_number} to {$customer->billing_email}");

                        Log::info('Payment reminder sent via cron', [
                            'order_id' => $order->order_id,
                            'order_number' => $order->order_number,
                            'customer_email' => $customer->billing_email,
                            'payment_id' => $payment->id
                        ]);
                    } else {
                        $this->error("Failed to generate payment link for Order #{$order->order_number}");
                        $errors++;
                    }

                } catch (\Exception $e) {
                    $this->error("Error processing payment ID {$payment->id}: " . $e->getMessage());
                    Log::error('Payment reminder cron error', [
                        'payment_id' => $payment->id,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    $errors++;
                }
            }

            $this->info("Payment reminder check completed. Emails sent: {$emailsSent}, Errors: {$errors}");

        } catch (\Exception $e) {
            $this->error('Payment reminder cron failed: ' . $e->getMessage());
            Log::error('Payment reminder cron failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
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
                // Update payment record with new transaction ID
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
            Log::error('Failed to generate payment link in cron: ' . $e->getMessage());
        }

        return null;
    }
}