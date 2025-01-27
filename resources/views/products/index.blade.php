@extends('layouts.app')

@section('title', 'Test Tailwind')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold mb-6">Products</h1>
    <a href="{{ route('products.create') }}" class="inline-block bg-blue-600 text-white px-6 py-2 rounded-md shadow-md hover:bg-blue-500 mb-4">Add Product</a>
    <table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
        <thead>
            <tr class="bg-gray-100 border-b">
                <th class="text-sm font-medium text-left px-6 py-4 text-gray-800">Image</th>
                <th class="text-sm font-medium text-left px-6 py-4 text-gray-800">Name</th>
                <th class="text-sm font-medium text-left px-6 py-4 text-gray-800">Price</th>
                <th class="text-sm font-medium text-left px-6 py-4 text-gray-800">Category</th>
                <th class="text-sm font-medium text-left px-6 py-4 text-gray-800">Status</th>
                <th class="text-sm font-medium text-left px-6 py-4 text-gray-800">Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr class="border-b hover:bg-gray-50 transition-colors cursor-pointer" 
                onclick="window.location='{{ route('products.show', $product) }}'">
                <!-- Image Column -->
                <td class="px-6 py-4" onclick="event.stopPropagation()">
                    @if($product->images->first())
                    <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" 
                         alt="{{ $product->name }}"
                         class="w-16 h-16 object-cover rounded shadow-md">
                    @else
                    <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                        <span class="text-gray-500 text-xs">No Image</span>
                    </div>
                    @endif
                </td>
                
                <!-- Name Column -->
                <td class="text-base text-gray-700 px-6 py-4 font-medium">
                    {{ $product->name }}
                </td>
                
                <!-- Price Column -->
                <td class="text-base text-gray-700 px-6 py-4">
                    ${{ number_format($product->price, 2) }}
                </td>
                
                <!-- Category Column -->
                <td class="text-base text-gray-700 px-6 py-4">
                    {{ $product->category->name ?? 'N/A' }}
                </td>
                
                <!-- Status Column -->
                <td class="px-6 py-4">
                    <span class="px-3 py-1 text-sm rounded-full 
                              {{ $product->active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $product->active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                
                <!-- Actions Column (not clickable) -->
                <td class="px-6 py-4 space-x-4" onclick="event.stopPropagation()">
                    <a href="{{ route('products.edit', $product) }}" 
                       class="text-yellow-600 hover:text-yellow-500 transition-colors">
                        Edit
                    </a>
                    <form action="{{ route('products.destroy', $product) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" 
                                class="text-red-600 hover:text-red-500 transition-colors"
                                onclick="return confirm('Are you sure you want to delete this product?')">
                            Delete
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Add hover effect styling -->
<style>
    tr:not(:hover) .hover\:visible {
        visibility: hidden;
    }
    tr:hover .hover\:visible {
        visibility: visible;
    }
</style>
@endsection