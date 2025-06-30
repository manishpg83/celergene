<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\UserOrderConfirmation;
use App\Models\Payment;
use App\Models\User;
use App\Mail\PaymentReminderMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalWebhookController extends Controller
{
    public function handle(Request $request)
    {
        try {
            $webhookData = $request->all();

            if (! isset($webhookData['resource']['id'])) {
                throw new \Exception('Transaction ID not found in webhook data');
            }

            $transactionId = $webhookData['resource']['id'];
            $status = $webhookData['resource']['status'] ?? null;
            $eventType = $webhookData['event_type'] ?? null;

            $payment = Payment::where('transaction_id', $transactionId)->first();

            if (! $payment) {
                throw new \Exception("Payment not found for transaction: {$transactionId}");
            }

            switch ($eventType) {
                case 'PAYMENT.CAPTURE.COMPLETED':
                    $payment->status = 'completed';
                    $payment->payment_date = now();
                    $this->updateOrder($payment->order_id, 'Paid');
                    break;

                case 'PAYMENT.CAPTURE.DENIED':
                    $payment->status = 'failed';
                    $this->updateOrder($payment->order_id, 'Cancelled');
                    break;

                case 'PAYMENT.CAPTURE.PENDING':
                    $payment->status = 'pending';
                    $this->updateOrder($payment->order_id, 'Pending');
                    break;

                case 'PAYMENT.CAPTURE.REFUNDED':
                    $payment->status = 'refunded';
                    $this->updateOrder($payment->order_id, 'Cancelled');
                    break;
            }

            $payment->save();

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            Log::error('PayPal Webhook Error: ' . $e->getMessage(), [
                'webhook_data' => $webhookData ?? null,
                'trace' => $e->getTraceAsString(),
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'Webhook processing failed',
            ], 500);
        }
    }

    private function updateOrder($orderId, $status)
    {
        try {
            DB::table('order_master')
                ->where('order_id', $orderId)
                ->update([
                    'order_status' => $status,
                    'updated_at' => now(),
                ]);
        } catch (\Exception $e) {
            Log::error('Error updating order status: ' . $e->getMessage(), [
                'order_id' => $orderId,
                'status' => $status,
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    public function success(Request $request)
    {
        try {
            $provider = new PayPalClient;
            $provider->getAccessToken();

            $token = $request->query('token');
            if (! $token) {
                throw new \Exception('PayPal token not found in request');
            }

            $response = $provider->capturePaymentOrder($token);

            if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                $payment = Payment::where('transaction_id', $token)->first();

                if ($payment) {
                    $payment->update([
                        'status' => 'completed',
                        'payment_response' => json_encode($response),
                        'payment_date' => now(),
                    ]);

                    $this->updateOrder($payment->order_id, 'Paid');

                    $order = DB::table('order_master')
                        ->where('order_id', $payment->order_id)
                        ->first();
                    $customer = DB::table('customers')
                        ->where('id', $order->customer_id)
                        ->first();

                    $user = User::find($customer->user_id);

                    $billingAddress = implode(', ', array_filter([
                        $customer->billing_address,
                        $customer->billing_city,
                        $customer->billing_state,
                        $customer->billing_postal_code,
                        $customer->billing_country
                    ]));

                    if ($order->use_billing_as_shipping) {
                        $shippingName = trim($customer->billing_fname . ' ' . $customer->billing_lname);
                        $shippingCompany = $customer->billing_company_name;
                        $shippingPhone = $customer->billing_phone;
                    } else {
                        $addressIndex = 1;
                        $shippingAddress1 = implode(', ', array_filter([
                            $customer->shipping_address_1,
                            $customer->shipping_city_1,
                            $customer->shipping_state_1,
                            $customer->shipping_postal_code_1,
                            $customer->shipping_country_1
                        ]));

                        $shippingAddress2 = implode(', ', array_filter([
                            $customer->shipping_address_2,
                            $customer->shipping_city_2,
                            $customer->shipping_state_2,
                            $customer->shipping_postal_code_2,
                            $customer->shipping_country_2
                        ]));

                        if ($order->shipping_address === $shippingAddress2) {
                            $addressIndex = 2;
                        }

                        $shippingName = trim($customer->{"shipping_address_receiver_name_{$addressIndex}"} . ' ' . $customer->{"shipping_address_receiver_lname_{$addressIndex}"});
                        $shippingCompany = $customer->{"shipping_company_name_{$addressIndex}"};
                        $shippingPhone = $customer->{"shipping_phone_{$addressIndex}"};
                    }

                    $shippingAddress = $order->shipping_address;
                    $orderNumber = $order->order_id;
                    $orderId = $order->order_id;

                    Mail::to($user->email)->send(new UserOrderConfirmation(
                        $orderNumber,
                        $user,
                        $billingAddress,
                        $shippingAddress,
                        $orderId,
                        $shippingName,
                        $shippingCompany,
                        $shippingPhone
                    ));

                    session()->forget('cart');

                    return redirect()->route('order.success')
                        ->with('success', 'Your payment has been processed successfully!');
                }
            }

            throw new \Exception('Payment verification failed');
        } catch (\Exception $e) {
            Log::error('PayPal Success Callback Error: ' . $e->getMessage(), [
                'token' => $token ?? null,
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('checkout.error')
                ->with('error', 'There was an error processing your payment. Please contact support.');
        }
    }

    public function cancel(Request $request)
    {
        try {
            $token = $request->query('token');
            if ($token) {
                Payment::where('transaction_id', $token)
                    ->update(['status' => 'cancelled']);

                $payment = Payment::where('transaction_id', $token)->first();
                if ($payment) {
                    DB::table('order_master')
                        ->where('order_id', $payment->order_id)
                        ->update([
                            'order_status' => 'Cancelled',
                            'updated_at' => now(),
                        ]);

                    $order = DB::table('order_master')
                        ->where('order_id', $payment->order_id)
                        ->first();

                    if ($order && !$order->payment_reminder_sent) {
                        $customer = DB::table('customers')
                            ->where('id', $order->customer_id)
                            ->first();

                        $orderDetails = DB::table('order_details')
                            ->leftJoin('products', 'order_details.product_id', '=', 'products.id')
                            ->where('order_details.order_id', $order->order_id)
                            ->select(
                                'order_details.*',
                                'products.product_name'
                            )
                            ->get();

                        if ($customer) {
                            $paymentLink = $this->generatePaymentLink($order);

                            Mail::to($customer->billing_email)
                                ->send(new PaymentReminderMail($order, $customer, $orderDetails, $paymentLink));

                            DB::table('order_master')
                                ->where('order_id', $order->order_id)
                                ->update([
                                    'payment_reminder_sent' => 1,
                                    'payment_reminder_sent_at' => now()
                                ]);

                            Log::info('Payment reminder sent', [
                                'order_id' => $order->order_id,
                                'order_number' => $order->order_number,
                                'customer_email' => $customer->billing_email
                            ]);
                        }
                    }
                }
            }

            return redirect()->route('home')
                ->with('info', 'Payment was cancelled. We\'ve sent you an email with payment details to complete your purchase later.');
        } catch (\Exception $e) {
            Log::error('PayPal cancel error: ' . $e->getMessage());
            return redirect()->route('home')
                ->with('error', 'Something went wrong. Please try again.');
        }
    }

    private function generatePaymentLink($order)
    {
        try {
            $provider = new PayPalClient;
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
            Log::error('Failed to generate payment link: ' . $e->getMessage());
        }

        return null;
    }
}
