@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-4 text-gray-800">{{ $item->name }}</h2>
        
        <div class="space-y-4">
            <div>
                <label class="text-sm font-medium text-gray-600">Description:</label>
                <p class="mt-1 text-gray-900">{{ $item->description ?? 'N/A' }}</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-600">Cost Per Unit:</label>
                    <p class="mt-1 text-gray-900">${{ number_format($item->cost_per_unit, 2) }}</p>
                </div>

                <div>
                    <label class="text-sm font-medium text-gray-600">Stock Quantity:</label>
                    <p class="mt-1">
                        <span class="px-2 py-1 text-sm font-semibold rounded-full 
                            {{ $item->stock_quantity > 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                            {{ $item->stock_quantity }}
                        </span>
                    </p>
                </div>
            </div>

            @if($item->products->count() > 0)
            <div>
                <label class="text-sm font-medium text-gray-600">Used in Products:</label>
                <ul class="mt-1 list-disc list-inside">
                    @foreach($item->products as $product)
                    <li class="text-gray-900">
                        {{ $product->name }} ({{ $product->pivot->quantity }} units)
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('inventory.index') }}" 
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg">
                Back to Inventory
            </a>
        </div>
    </div>
</div>
@endsection