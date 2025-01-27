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

            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <input type="text" name="name" id="name"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
                    value="{{ old('name', $product->name) }}" required>
            </div>

            <div class="mb-4">
                <label for="price" class="block text-sm font-medium text-gray-700">Price</label>
                <input type="number" name="price" id="price"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
                    step="0.01" value="{{ old('price', $product->price) }}" required>
            </div>

            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" id="description"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600"
                    rows="4">{{ old('description', $product->description) }}</textarea>
            </div>

            <div class="mb-4">
                <label for="images" class="block text-gray-700 text-sm font-bold mb-2">Product Images</label>
                <input type="file" name="images[]" id="images" multiple
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline">
                @error('images.*')
                    <span class="text-red-500 text-xs italic">{{ $message }}</span>
                @enderror
            </div>

            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Inventory Items</label>
                    
                    <!-- Searchable Dropdown -->
                    <select name="inventory_items[]" 
                            id="inventorySearch" 
                            class="w-full"
                            multiple
                            placeholder="Search and add inventory items...">
                        @foreach($inventoryItems as $item)
                            <option value="{{ $item->id }}" 
                                {{ $product->inventoryItems->contains($item->id) ? 'selected' : '' }}
                                data-quantity="{{ $product->inventoryItems->find($item->id)->pivot->quantity ?? 1 }}">
                                {{ $item->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            
                <!-- Selected Items List -->
                <div id="selectedItems" class="space-y-2">
                    @foreach($product->inventoryItems as $item)
                        <div class="flex items-center gap-3 selected-item" data-id="{{ $item->id }}">
                            <span class="flex-1">{{ $item->name }}</span>
                            <input type="number" 
                                   name="quantities[{{ $item->id }}]"
                                   value="{{ $item->pivot->quantity }}"
                                   min="1" 
                                   class="w-20 px-2 py-1 border rounded"
                                   placeholder="Qty">
                            <button type="button" 
                                    class="text-red-500 hover:text-red-700 remove-item"
                                    title="Remove item">
                                ✕
                            </button>
                        </div>
                    @endforeach
                </div>
            </div>
            
            @push('scripts')
            <script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
            <link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
            
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Initialize Tom Select
                new TomSelect('#inventorySearch', {
                    plugins: ['remove_button'],
                    create: false,
                    searchField: 'text',
                    render: {
                        option: function(data, escape) {
                            return `<div>${escape(data.text)}</div>`;
                        }
                    },
                    onItemAdd: function(value, item) {
                        const quantity = item.dataset.quantity || 1;
                        addItemToList(value, item.textContent, quantity);
                    },
                    onItemRemove: function(value) {
                        document.querySelector(`.selected-item[data-id="${value}"]`).remove();
                    }
                });
            
                // Add existing items on load
                document.querySelectorAll('#inventorySearch option[selected]').forEach(option => {
                    const quantity = option.dataset.quantity || 1;
                    addItemToList(option.value, option.textContent, quantity);
                });
            
                // Handle manual removal
                document.getElementById('selectedItems').addEventListener('click', function(e) {
                    if(e.target.classList.contains('remove-item')) {
                        const itemId = e.target.closest('.selected-item').dataset.id;
                        const ts = document.querySelector('#inventorySearch').tomselect;
                        ts.removeItem(itemId);
                        e.target.closest('.selected-item').remove();
                    }
                });
            
                function addItemToList(id, name, quantity) {
                    if(document.querySelector(`.selected-item[data-id="${id}"]`)) return;
            
                    const div = document.createElement('div');
                    div.className = 'flex items-center gap-3 selected-item';
                    div.dataset.id = id;
                    div.innerHTML = `
                        <span class="flex-1">${name}</span>
                        <input type="number" 
                               name="quantities[${id}]"
                               value="${quantity}"
                               min="1" 
                               class="w-20 px-2 py-1 border rounded"
                               placeholder="Qty">
                        <button type="button" 
                                class="text-red-500 hover:text-red-700 remove-item"
                                title="Remove item">
                            ✕
                        </button>
                    `;
                    document.getElementById('selectedItems').appendChild(div);
                }
            });
            </script>
            <style>
            .ts-control {
                padding: 8px 12px;
                border-radius: 6px;
                border: 1px solid #e5e7eb;
            }
            </style>
            @endpush

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

            <div class="mb-4">
                <label for="active" class="block text-sm font-medium text-gray-700">Active</label>
                <select name="active" id="active"
                    class="mt-1 block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-600">
                    <option value="1" {{ old('active', $product->active) == 1 ? 'selected' : '' }}>Yes</option>
                    <option value="0" {{ old('active', $product->active) == 0 ? 'selected' : '' }}>No</option>
                </select>
            </div>

            <div class="flex space-x-4">
                <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-md shadow-md hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-600">Update</button>
                <a href="{{ route('products.index') }}"
                    class="px-6 py-2 bg-gray-600 text-white rounded-md shadow-md hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-600">Cancel</a>
            </div>
        </form>
    </div>
@endsection
