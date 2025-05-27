@extends('frontend.layouts.app')

@section('title', 'About | Celergen')
@section('header', 'About | Celergen')

@section('content')
<div class="container mx-auto px-4 py-16">
    <div class="max-w-lg mx-auto bg-white rounded-lg shadow-md p-6 my-20">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-gray-800 mb-4">Thank You for Your Order</h2>

            @if(session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <p class="text-gray-600 mb-4">
                Your order confirmation has been sent to your email.
            </p>
            <p class="text-gray-600 mb-4">
                If you have any questions or need assistance, feel free to contact us at <a href="mailto:marketing@celergenswiss.com" class="text-blue-600 underline">marketing@celergenswiss.com</a>.
            </p>
            <p class="text-gray-600 mb-4">
                We appreciate your trust in us and look forward to serving you.
            </p>
        </div>
    </div>
</div>
@endsection