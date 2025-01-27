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

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                    Item Name
                </label>
                <input type="text" name="name" id="name"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                    value="{{ old('name', $item->name ?? '') }}"
                    required>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="description">
                    Description
                </label>
                <textarea name="description" id="description" rows="3"
                    class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">{{ old('description', $item->description ?? '') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="cost_per_unit">
                        Cost Per Unit ($)
                    </label>
                    <input type="number" step="0.01" name="cost_per_unit" id="cost_per_unit"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ old('cost_per_unit', $item->cost_per_unit ?? '') }}"
                        required>
                </div>

                <div>
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="stock_quantity">
                        Stock Quantity
                    </label>
                    <input type="number" name="stock_quantity" id="stock_quantity"
                        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400"
                        value="{{ old('stock_quantity', $item->stock_quantity ?? 0) }}"
                        required>
                </div>
            </div>

            <div class="flex justify-end">
                <a href="{{ route('inventory.index') }}" 
                    class="mr-2 bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded-lg">
                    Cancel
                </a>
                <button type="submit" 
                    class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg">
                    {{ $buttonText }}
                </button>
            </div>
        </form>
    </div>
</div>