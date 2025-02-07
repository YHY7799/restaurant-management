@extends('layouts.app')

@section('title', 'Cart')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-8">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Your Cart</h1>

        @if (Cart::count() > 0)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <!-- Make the table responsive -->
                <div class="overflow-x-auto">
                    <table class="w-full min-w-[600px]">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Product</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Quantity</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Price</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Total</th>
                                <th class="px-4 py-3 text-left text-sm font-medium text-gray-600">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach (Cart::content() as $productId => $item)
                                <tr class="border-b">
                                    <td class="px-4 py-4 text-sm">{{ $item['name'] }}</td>
                                    <td class="px-4 py-4 text-sm">{{ $item['quantity'] }}</td>
                                    <td class="px-4 py-4 text-sm">${{ $item['price'] }}</td>
                                    <td class="px-4 py-4 text-sm">${{ $item['price'] * $item['quantity'] }}</td>
                                    <td class="px-4 py-4">
                                        <form action="{{ route('customer.cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $productId }}">
                                            <button type="submit"
                                                class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">
                                                Remove
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Order Submission Form -->
            <div class="mt-6">
                <form action="{{ route('customer.order.submit') }}" method="POST">
                    @csrf
                    <div class="bg-white rounded-lg shadow-md p-6">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Details</h2>
                        <div class="space-y-4">
                            <!-- Customer Name -->
                            <input type="text" name="name" placeholder="Your Name"
                                class="w-full px-4 py-2 border rounded-md text-sm">

                            <!-- Customer Phone (Optional) -->
                            <input type="text" name="phone" placeholder="Your Phone Number"
                                class="w-full px-4 py-2 border rounded-md text-sm">

                            <!-- Submit Button -->
                            <button type="submit"
                                class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                                Submit Order
                            </button>
                            @if (session('error'))
                                <div class="text-red-600 text-sm">{{ session('error') }}</div>
                            @endif
                        </div>
                    </div>
                </form>
            </div>
        @else
            <p class="text-gray-600 text-center">Your cart is empty.</p>
        @endif
    </div>
@endsection
