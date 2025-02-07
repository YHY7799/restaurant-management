@extends('layouts.app')

@section('title', 'Menu')

@section('content')
    <!-- Categories Navigation -->
    <div class="bg-white shadow-md py-4">
        <div class="container mx-auto px-4 sm:px-6">
            <div class="flex space-x-4 overflow-x-auto">
                <a href="{{ route('customer.menu') }}" class="px-4 py-2 text-gray-700 hover:bg-gray-200 rounded whitespace-nowrap">
                    All
                </a>
                @foreach ($categories as $category)
                    <a href="{{ route('customer.menu', ['category' => $category->id]) }}"
                        class="px-4 py-2 text-gray-700 hover:bg-gray-200 rounded whitespace-nowrap">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Cart Button -->
    <div class="fixed top-4 right-4 z-50">
        <a href="{{ route('customer.cart.view') }}"
            class="bg-blue-600 text-white px-4 py-2 rounded-full shadow-lg hover:bg-blue-700 text-sm sm:text-base">
            Cart ({{ Cart::count() }})
        </a>
    </div>

    <!-- Products Grid -->
    <div class="container mx-auto px-4 sm:px-6 py-8">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @if ($products->count() > 0)
                @foreach ($products as $product)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        <!-- Product Image -->
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}"
                            alt="{{ $product->name }}" class="w-full h-48 sm:h-32 object-cover">

                        <!-- Product Details -->
                        <div class="p-4 sm:p-6">
                            <h2 class="text-lg sm:text-xl font-semibold text-gray-800">{{ $product->name }}</h2>
                            <p class="text-gray-600 mt-2 text-sm sm:text-base">{{ $product->description }}</p>
                            <p class="text-gray-800 font-bold mt-2 text-sm sm:text-base">${{ $product->price }}</p>

                            <!-- Add to Cart Form -->
                            <form action="{{ route('customer.cart.add') }}" method="POST" class="mt-4">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="flex items-center">
                                    <input type="number" name="quantity" value="1" min="1"
                                        class="w-16 px-3 py-2 border rounded-md text-sm sm:text-base">
                                    <button type="submit"
                                        class="ml-4 px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-sm sm:text-base">
                                        Add to Cart
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-gray-600 text-sm sm:text-base">No products available.</p>
            @endif
        </div>
    </div>
@endsection