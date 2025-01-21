@extends('frontend.layouts.app')

@section('title', 'About | Celergen')
@section('header', 'About | Celergen')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="text-center">
            
            
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Payment Successful!</h2>
            
            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            
            <p class="text-gray-600 mb-6">
                Thank you for your order. We'll send you a confirmation email with your order details shortly.
            </p>
            
            <div class="space-y-4">
               
                
                <div class="text-sm text-gray-500 mt-4">
                    <p>Order reference will be sent to your email</p>
                    <p>For any questions, please contact our support team</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection