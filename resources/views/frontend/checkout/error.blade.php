@extends('frontend.layouts.app')

@section('title', 'About | Celergen')
@section('header', 'About | Celergen')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Payment Error!</h2>
            <p class="text-gray-600 mb-6">
                Oops! Something went wrong with your payment.
            </p>
            @if(session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif
            <p class="text-gray-600 mb-6">
                We encountered an issue processing your payment. Don't worry - no charges have been made to your account.
            </p>

            <div class="space-y-4">
                <p>
                    <a href="{{ route('checkout') }}" class="inline-block bg-blue-500 hover:bg-blue-600 font-semibold px-6 py-2 rounded">Try Again</a>
                </p>
            </div>
            <div class="text-sm text-gray-500">
                <p>If you continue to experience issues, please check below options:</p>
                <ul class="mt-2">
                    <li>Check your payment details</li>
                    <li>Ensure you have sufficient funds</li>
                    <li>Contact our support team</li>
                </ul>
            </div>
            <p>&nbsp;</p>
        </div>
    </div>
</div>
@endsection
