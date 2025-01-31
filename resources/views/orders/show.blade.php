@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <!-- Order Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Order Details</h1>
            <a href="{{ route('orders.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                Back to Orders
            </a>
        </div>

        <!-- Order Information -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div>
                <h2 class="text-lg font-semibold text-gray-700">Order Number</h2>
                <p class="text-gray-600">{{ $order->order_number }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-700">Customer</h2>
                <p class="text-gray-600">
                    {{ $order->customer ? $order->customer->name : 'Guest Customer' }}
                </p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-700">Status</h2>
                <p class="text-gray-600 capitalize">{{ $order->status }}</p>
            </div>
            <div>
                <h2 class="text-lg font-semibold text-gray-700">Total Amount</h2>
                <p class="text-gray-600">${{ number_format($order->total_amount, 2) }}</p>
            </div>
        </div>

        <!-- Order Items Table -->
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Order Items</h2>
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Product</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Quantity</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Price</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr class="border-b border-gray-200 hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $item->product->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">${{ number_format($item->price, 2) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">${{ number_format($item->quantity * $item->price, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Order Actions -->
        <div class="flex justify-end space-x-4">
            <form action="{{ route('orders.update-status', $order->id) }}" method="POST">
                @csrf
                @method('PUT')
                <select name="status" class="px-4 py-2 border rounded" onchange="this.form.submit()">
                    <option value="initialized" {{ $order->status === 'initialized' ? 'selected' : '' }}>Initialized</option>
                    <option value="preparing" {{ $order->status === 'preparing' ? 'selected' : '' }}>Preparing</option>
                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="paid" {{ $order->status === 'paid' ? 'selected' : '' }}>Paid</option>
                </select>
            </form>
        </div>
    </div>
</div>
@endsection
