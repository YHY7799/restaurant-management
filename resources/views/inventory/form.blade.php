<div class="container mx-auto px-4 py-8">
    <div class="max-w-2xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">{{ $title }}</h2>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 p-4 mb-4">
                <div class="flex">
                    <div class="text-red-400">⚠️</div>
                    <div class="ml-3">
                        @foreach ($errors->all() as $error)
                            <p class="text-sm text-red-700">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <form method="POST" action="{{ $action }}">
            @csrf
            @isset($method)
                @method($method)
            @endisset

            <!-- General Information -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">General Information</h3>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">Item Name</label>
                    <input type="text" name="name" id="name"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ old('name', $item->name ?? '') }}" required>
                </div>

                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="description">Description</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description', $item->description ?? '') }}</textarea>
                </div>
            </div>

            <!-- Measurement & Cost Details -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Measurement & Cost Details</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="storage_unit">
                            Storage Unit
                        </label>
                        <select name="storage_unit" id="storage_unit"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required>
                            <option value="">Select Unit</option>
                            @foreach(['kg', 'g', 'lb', 'pieces', 'liters', 'ml', 'units'] as $unit)
                                <option value="{{ $unit }}" {{ old('storage_unit', $item->storage_unit ?? '') == $unit ? 'selected' : '' }}>
                                    {{ ucfirst($unit) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="usage_unit">
                            Usage Unit
                        </label>
                        <select name="usage_unit" id="usage_unit"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                            required>
                            <option value="">Select Unit</option>
                            @foreach(['g', 'kg', 'ml', 'liters', 'pieces', 'units'] as $unit)
                                <option value="{{ $unit }}" {{ old('usage_unit', $item->usage_unit ?? '') == $unit ? 'selected' : '' }}>
                                    {{ ucfirst($unit) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="conversion_factor">
                            Conversion Factor <span class="text-gray-500 text-xs">(1 storage unit = X usage units)</span>
                        </label>
                        <input type="number" step="0.0001" name="conversion_factor" id="conversion_factor"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                            value="{{ old('conversion_factor', $item->conversion_factor ?? 1) }}" 
                            min="0.0001" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="cost_per_unit">
                            Cost Per Storage Unit ($)
                        </label>
                        <input type="number" step="0.0001" name="cost_per_unit" id="cost_per_unit"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                            value="{{ old('cost_per_unit', $item->cost_per_unit ?? '') }}" required>
                    </div>
                </div>
            </div>

            <!-- Stock Management -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Stock Management</h3>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="stock_quantity">
                            Stock Quantity ({{ $item->storage_unit ?? 'storage units' }})
                        </label>
                        <input type="number" step="0.0001" name="stock_quantity" id="stock_quantity"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                            value="{{ old('stock_quantity', $item->stock_quantity ?? 0) }}" required>
                    </div>

                    <div>
                        <label class="block text-gray-700 text-sm font-bold mb-2" for="min_stock">
                            Minimum Stock Level ({{ $item->storage_unit ?? 'storage units' }})
                        </label>
                        <input type="number" step="0.0001" name="min_stock" id="min_stock"
                            class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                            value="{{ old('min_stock', $item->min_stock ?? '') }}">
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end">
                <a href="{{ route('inventory.index') }}"
                    class="mr-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg shadow-sm transition">
                    Cancel
                </a>
                <button type="submit"
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg shadow-sm transition">
                    {{ $buttonText }}
                </button>
            </div>
        </form>
    </div>
</div>
