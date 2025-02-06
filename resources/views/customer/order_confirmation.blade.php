@extends('layouts.app')

@section('title', 'Order Confirmation')

@section('content')
    <div class="bg-white rounded-lg shadow-md p-6 text-center">
        <h1 class="text-2xl font-bold text-gray-800 mb-4">Thank you for your order!</h1>
        <p class="text-gray-600">Your order has been placed successfully.</p>
        <a href="{{ route('customer.menu') }}" class="mt-6 inline-block px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700">
            Back to Menu
        </a>
    </div>
@endsection