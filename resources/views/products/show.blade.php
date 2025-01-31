@extends('layouts.app')

@section('title', $product->name)

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="max-w-6xl mx-auto">
            <div class="mb-6 flex justify-between items-center">
                <a href="{{ route('products.index') }}" class="text-blue-600 hover:text-blue-800">
                    &larr; Back to Products
                </a>
                <div class="space-x-4">
                    <a href="{{ route('products.edit', $product) }}"
                        class="px-4 py-2 bg-yellow-500 text-white rounded hover:bg-yellow-600">
                        Edit Product
                    </a>
                </div>
            </div>
            <div class="bg-white rounded-lg shadow-lg p-6">
                @if ($product->images->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                        @foreach ($product->images as $image)
                            <div class="relative group">
                                <img src="{{ asset('storage/' . $image->image_path) }}" alt="Product Image"
                                    class="w-full h-64 object-cover rounded-lg shadow-md">
                                <form action="{{ route('product-images.destroy', $image) }}" method="POST"
                                    class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white rounded-full p-1 hover:bg-red-600"
                                        onclick="return confirm('Are you sure you want to delete this image?')">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="bg-gray-100 rounded-lg p-8 text-center mb-8">
                        <span class="text-gray-500">No images available for this product</span>
                    </div>
                @endif
                <div class="space-y-4">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $product->name }}</h1>
                    <div class="flex items-center space-x-4">
                        <span class="text-2xl font-bold text-blue-600">
                            ${{ number_format($product->price, 2) }}
                        </span>
                        <form method="POST" action="{{ route('products.toggleStatus', $product) }}">
                            @csrf
                            @method('PATCH')
                            <select name="active" onchange="this.form.submit()"
                                class="px-3 py-1 text-sm rounded-full border border-gray-300 bg-white">
                                <option value="1" {{ $product->active ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$product->active ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </form>

                    </div>
                    @if ($product->description)
                        <div class="prose max-w-none">
                            <h3 class="text-lg font-semibold text-gray-900">Description</h3>
                            <p class="text-gray-600">{{ $product->description }}</p>
                        </div>
                    @endif
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500">Category</h4>
                            <p class="mt-1 text-gray-900">
                                {{ $product->category->name ?? 'Uncategorized' }}
                            </p>
                        </div>
                        @if ($product->options->count() > 0)
                            <div>
                                <h4 class="text-sm font-medium text-gray-500">Options</h4>
                                <ul class="mt-1 list-disc list-inside">
                                    @foreach ($product->options as $option)
                                        <li class="text-gray-900">{{ $option->name }}</li>
                                        <li class="text-gray-900">Price: ${{ $option->additional_price }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <h3>Total Cost: ${{ number_format($product->total_cost, 2) }}</h3>
                    <ul class="mb-4">
                        @foreach ($product->inventoryItems as $item)
                            <li class="text-gray-700">{{ $item->name }} - {{ $item->pivot->quantity_used }}
                                {{ $item->usage_unit }}
                                ({{ number_format(($item->pivot->quantity_used / $item->conversion_factor) * $item->cost_per_unit, 2) }}
                                $)</li>
                        @endforeach
                    </ul>
                    <form method="POST" action="{{ route('products.addInventoryItem', $product) }}">
                        @csrf
                        <div class="flex gap-4">
                            <select name="inventory_item_id" class="border rounded px-3 py-2">
                                <option value="">Select Inventory Item</option>
                                @foreach ($availableInventoryItems as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }} ({{ $item->storage_unit }})
                                    </option>
                                @endforeach
                            </select>
                            <input type="number" name="quantity_used" step="0.01" placeholder="Quantity" required
                                class="border rounded px-3 py-2">
                            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Add</button>
                        </div>
                    </form>

                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-500">
                            Created: {{ $product->created_at->format('M d, Y H:i') }}
                            <br>
                            Last Updated: {{ $product->updated_at->format('M d, Y H:i') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
