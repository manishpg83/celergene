<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\UserOrderConfirmation;
use App\Models\Payment;
use App\Models\User;
use App\Mail\PaymentReminderMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            notyf()->error('Webhook processing failed');
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
            notyf()->error('Error updating order status');
        }
    }

    public function success(Request $request)
    {
        try {
            $provider = new PayPalClient;
            $provider->getAccessToken();

            $token = $request->query('token');
            if (! $token) {
                \Log::error('PayPal token not found in request', ['request' => $request->all()]);
                throw new \Exception('PayPal token not found in request');
            }
            $paymentSource = $request->query('payment_source');
            $isAlipay = ($paymentSource === 'alipay');

            if ($isAlipay) {
                $response = $provider->showOrderDetails($token);
            } else {
                $response = $provider->capturePaymentOrder($token);
            }

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

                    notyf()->success('Your payment has been processed successfully!');
                    return redirect()->route('order.success');
                } else {
                    \Log::error('No Payment record found for token', ['token' => $token]);
                }
            } else {
                \Log::error('PayPal payment not completed', ['response' => $response, 'token' => $token]);
            }

            throw new \Exception('Payment verification failed');
        } catch (\Exception $e) {
            \Log::error('Exception in PayPal success', ['error' => $e->getMessage()]);
            notyf()->error('There was an error processing your payment. Please contact support.');
            return redirect()->route('checkout.error');
        }
    }

    public function cancel(Request $request)
    {
        try {
            $token = $request->query('token');
            if ($token) {
                $payment = Payment::where('transaction_id', $token)->first();

                if ($payment) {
                    $payment->update(['status' => 'cancelled']);

                    DB::table('order_master')
                        ->where('order_id', $payment->order_id)
                        ->update([
                            'order_status' => 'Cancelled',
                            'updated_at' => now(),
                        ]);

                    $order = DB::table('order_master')
                        ->where('order_id', $payment->order_id)
                        ->first();

                    if ($order && !$payment->payment_mail_sent) {
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

                            if ($paymentLink) {
                                Mail::to($customer->billing_email)
                                    ->send(new PaymentReminderMail($order, $customer, $orderDetails, $paymentLink));

                                $payment->update(['payment_mail_sent' => 1]);
                            }
                        }
                    }
                }
            }

            notyf()->info('Payment was cancelled. We\'ve sent you an email with payment details to complete your purchase later.');
            return redirect()->route('home');
        } catch (\Exception $e) {
            \Log::error('Exception in generatePaymentLink', ['error' => $e->getMessage()]);
            notyf()->error('Something went wrong. Please try again.');
            return redirect()->route('home');
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
                    'return_url' => route('payment.success'),
                    'cancel_url' => route('payment.cancel'),
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
            \Log::error('Exception in generatePaymentLink', ['error' => $e->getMessage()]);
            notyf()->error('Failed to generate payment link');
        }

        return null;
    }
}
