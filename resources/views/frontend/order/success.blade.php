@extends('frontend.layouts.app')

@section('title', 'About | Celergen')
@section('header', 'About | Celergen')

@section('content')
<div class="container mx-auto px-4 py-8">
    <p>&nbsp;</p>
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-6">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Thank you for placing your order!!</h2>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            <p class="text-gray-600 mb-6">
            We truly appreciate your support and trust in us. Your order has been received and is being processed.
            </p>
            <p class="text-gray-600 mb-6"><strong>Order number:</strong>   #ORD - 000038</p>
            <p class="text-gray-600 mb-6">
                A confirmation email has been sent to your inbox with all the details. If you have any questions, feel free to contact our support team.
            </p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
            <p>&nbsp;</p>
        </div>
    </div>
</div>
@endsection
