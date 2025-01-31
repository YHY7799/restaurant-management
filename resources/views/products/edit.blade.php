@extends('layouts.app')

@section('title', 'Edit Product')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <h1 class="text-3xl font-bold mb-6">Edit Product</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-6">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('products.update', $product) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Product Name -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
                    value="{{ old('name', $product->name) }}" required>
            </div>

            <!-- Price -->
            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" name="price" id="price"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
                    step="0.01" value="{{ old('price', $product->price) }}" required>
            </div>

            <!-- Inventory Items -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Inventory Items</h3>
                <div class="relative">
                    <!-- Search Input -->
                    <input type="text" id="inventory-search"
                        class="mb-4 w-full px-4 py-2 border rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
                        placeholder="Search inventory items..." />

                    <!-- Inventory List -->
                    <ul id="inventory-list" class="max-h-64 overflow-auto border rounded shadow-lg p-2 bg-white">
                        @foreach ($inventoryItems as $inventoryItem)
                            <li class="flex justify-between items-center p-2 hover:bg-gray-100 cursor-pointer">
                                <label>
                                    <input type="checkbox" name="inventory_items[]" value="{{ $inventoryItem->id }}"
                                        class="inventory-checkbox"
                                        {{ $product->inventoryItems->contains($inventoryItem->id) ? 'checked' : '' }}>
                                    {{ $inventoryItem->name }}
                                </label>

                                <!-- Quantity Input (Hidden by Default) -->
                                <input type="number" name="quantities[{{ $inventoryItem->id }}]"
                                    value="{{ $product->inventoryItems->find($inventoryItem->id)->pivot->quantity ?? '' }}"
                                    min="1"
                                    class="quantity-input border rounded px-2 py-1 w-20 {{ $product->inventoryItems->contains($inventoryItem->id) ? '' : 'hidden' }}"
                                    placeholder="Qty">
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Category -->
            <div class="mb-4">
                <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
                <select name="category_id" id="category_id"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
                    required>
                    <option value="" disabled>Select a category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Buttons -->
            <div class="flex space-x-4">
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600">Update</button>
                <a href="{{ route('products.index') }}"
                    class="px-6 py-2 bg-gray-600 text-white rounded-md shadow-md hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-600">Cancel</a>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('inventory-search');
            const inventoryList = document.getElementById('inventory-list');
            const checkboxes = document.querySelectorAll('.inventory-checkbox');

            // Filter inventory items based on search input
            searchInput.addEventListener('input', function () {
                const query = this.value.toLowerCase();
                document.querySelectorAll('#inventory-list li').forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(query) ? '' : 'none';
                });
            });

            // Show/hide quantity input based on checkbox state
            checkboxes.forEach(checkbox => {
                checkbox.addEventListener('change', function () {
                    const quantityInput = this.closest('li').querySelector('.quantity-input');
                    if (this.checked) {
                        quantityInput.classList.remove('hidden');
                        quantityInput.focus();
                    } else {
                        quantityInput.classList.add('hidden');
                        quantityInput.value = '';
                    }
                });
            });
        });
    </script>
@endsection
