<div>
    <!-- Category Navigation -->
    <div class="flex space-x-4 mb-4 overflow-x-auto">
        @foreach($categories as $category)
            <button wire:click="selectCategory({{ $category->id }})"
                class="px-4 py-2 text-sm font-medium rounded-lg border transition-all 
                {{ $selectedCategory === $category->id ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700' }}">
                {{ $category->name }}
            </button>
        @endforeach
    </div>
    
    <!-- Product List -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        @foreach($products as $product)
            <div class="border rounded-lg p-4 bg-white shadow hover:shadow-md transition cursor-pointer" 
                 wire:click="addToOrder({{ $product->id }})">
                <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                <p class="text-gray-600">${{ number_format($product->price, 2) }}</p>
            </div>
        @endforeach
    </div>
    
    <!-- Order Summary -->
    <div class="mt-6 bg-white p-4 rounded-lg shadow">
        <h2 class="text-xl font-bold mb-4">Current Order</h2>
        <ul>
            @foreach($orderItems as $index => $item)
                <li class="flex justify-between items-center py-2 border-b">
                    <span>{{ $item['name'] }} x{{ $item['quantity'] }}</span>
                    <input type="number" min="1" wire:model="orderItems.{{ $index }}.quantity" 
                           class="w-16 text-center border rounded" />
                    <span>${{ number_format($item['quantity'] * $item['price'], 2) }}</span>
                    <button wire:click="removeItem({{ $index }})" class="text-red-500">&times;</button>
                </li>
            @endforeach
        </ul>
        <div class="flex justify-between mt-4">
            <span class="font-bold">Total:</span>
            <span class="font-bold">${{ number_format(collect($orderItems)->sum(fn($item) => $item['quantity'] * $item['price']), 2) }}</span>
        </div>
        
        <div class="flex space-x-4 mt-4">
            <div class="flex space-x-4 mt-4">
                <button wire:click="saveOrder" class="bg-green-500 text-white px-4 py-2 rounded">Send Order</button>
                <button wire:click="voidOrder" class="bg-red-500 text-white px-4 py-2 rounded">Void Order</button>
            </div>
            
        </div>
    </div>

    @if (session()->has('message'))
        <div class="mt-4 p-2 bg-green-100 text-green-800 rounded">
            {{ session('message') }}
        </div>
    @endif
</div>
