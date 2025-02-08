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
                            @foreach ($cart as $productId => $item)
                                <tr class="border-b">
                                    <td class="px-4 py-4 text-sm">{{ $item['name'] }}</td>
                                    <td class="px-4 py-4 text-sm">
                                        <form action="{{ route('customer.cart.update') }}" method="POST" class="flex items-center">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $productId }}">
                                            <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 px-2 py-1 border rounded-md text-sm">
                                            <button type="submit" class="ml-2 px-3 py-1 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm">Update</button>
                                        </form>
                                    </td>
                                    <td class="px-4 py-4 text-sm">${{ $item['price'] }}</td>
                                    <td class="px-4 py-4 text-sm">${{ $item['price'] * $item['quantity'] }}</td>
                                    <td class="px-4 py-4">
                                        <form action="{{ route('customer.cart.remove') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="product_id" value="{{ $productId }}">
                                            <button type="submit" class="px-3 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 text-sm">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Total Price and Order Submission Form -->
            <div class="mt-6">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Summary</h2>
                    <div class="space-y-4">
                        <!-- Total Price -->
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-semibold text-gray-800">Total:</span>
                            <span class="text-lg font-bold text-gray-800">${{ Cart::total() }}</span>
                        </div>

                        <!-- Order Submission Form -->
                        <form action="{{ route('customer.order.submit') }}" method="POST">
                            @csrf
                            <!-- Customer Name -->
                            <input type="text" name="name" placeholder="Your Name" class="w-full px-4 py-2 border rounded-md text-sm">

                            <!-- Customer Phone (Optional) -->
                            <input type="text" name="phone" placeholder="Your Phone Number" class="w-full px-4 py-2 border rounded-md text-sm">

                            <!-- Submit Button -->
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 text-sm">
                                Submit Order
                            </button>
                            @if (session('error'))
                                <div class="text-red-600 text-sm">{{ session('error') }}</div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        @else
            <p class="text-gray-600 text-center">Your cart is empty.</p>
        @endif
    </div>
@endsection