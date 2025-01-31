@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <div class="bg-white shadow-md rounded-lg p-6">
        <!-- Order Header -->
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Order Details</h1>
            <a href="{{ route('orders.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                create order
            </a>
        </div>

        <!-- Order Table -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 border-b">
                    <tr>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Order Number</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Customer</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Status</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Total Amount</th>
                        <th class="px-4 py-2 text-left text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $order->order_number }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">{{ $order->customer ? $order->customer->name : 'Guest Customer' }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700 capitalize">{{ $order->status }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">${{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700">
                                <a href="{{ route('orders.show', $order->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
