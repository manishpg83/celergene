<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Mail\UserOrderConfirmation;
use App\Models\Payment;
use App\Models\User;
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
            Log::info('PayPal Webhook Received:', ['data' => $webhookData]);

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
            Log::error('PayPal Webhook Error: '.$e->getMessage(), [
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

            Log::info('Order status updated successfully', [
                'order_id' => $orderId,
                'new_status' => $status,
            ]);
        } catch (\Exception $e) {
            Log::error('Error updating order status: '.$e->getMessage(), [
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
            Log::info('PayPal Payment Capture Response:', ['response' => $response]);
    
            if (isset($response['status']) && $response['status'] === 'COMPLETED') {
                $payment = Payment::where('transaction_id', $token)->first();
    
                if ($payment) {
                    $payment->update([
                        'status' => 'completed',
                        'payment_response' => json_encode($response),
                    ]);
    
                    $order = DB::table('order_master')
                        ->where('order_id', $payment->order_id)
                        ->first();
    
                    DB::table('order_master')
                        ->where('order_id', $payment->order_id)
                        ->update([
                            'order_status' => 'Paid',
                            'updated_at' => now(),
                        ]);
    
                    $customer = DB::table('customers')
                        ->where('id', $order->customer_id)
                        ->first();
    
                    $user = User::find($customer->user_id);
    
                    $billingAddress = implode(', ', array_filter([
                        $customer->billing_address,
                        $customer->billing_address_2,
                        $customer->billing_city,
                        $customer->billing_state,
                        $customer->billing_postal_code,
                        $customer->billing_country
                    ]));
    
                    $shippingAddress = $order->shipping_address;
    
                    $orderNumber = $order->order_number;
    
                    $orderId = $order->order_id;
    
                    Mail::to($user->email)->send(new UserOrderConfirmation(
                        $orderNumber, 
                        $user, 
                        $billingAddress,
                        $shippingAddress,
                        $orderId
                    ));
    
                    session()->forget('cart');
    
                    return redirect()->route('order.success')
                        ->with('success', 'Your payment has been processed successfully!');
                }
            }
    
            throw new \Exception('Payment verification failed');
        } catch (\Exception $e) {
            Log::error('PayPal Success Callback Error: '.$e->getMessage(), [
                'token' => $token ?? null,
                'trace' => $e->getTraceAsString(),
            ]);
    
            return redirect()->route('checkout.error')
                ->with('error', 'There was an error processing your payment. Please contact support.');
        }
    }

    public function cancel(Request $request)
    {
        Log::info('PayPal Payment Cancelled:', ['request' => $request->all()]);

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
            }
        }

        return redirect()->route('checkout')
            ->with('warning', 'Your payment was cancelled. Please try again.');
    }
}
