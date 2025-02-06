<aside class="w-64 min-h-screen bg-gray-800 text-gray-100 overflow-y-auto transition-all duration-300">
    <div class="p-4">
        <!-- Logo -->
        <div class="flex items-center space-x-2 mb-8">
            <svg class="w-8 h-8 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
            <span class="text-xl font-bold">Sytles</span>
        </div>

        <div class="left-0 right-0 p-4 border-t border-gray-700">
            <div class="flex items-center space-x-3">
                <div class="w-8 h-8 rounded-full bg-gray-600 flex items-center justify-center">
                    <span class="text-sm">JD</span>
                </div>
                <div>
                    <p class="text-sm font-medium">Yahaya Ismail</p>
                    <p class="text-xs text-gray-400">Administrator</p>
                </div>
            </div>
        </div>

        <!-- Navigation Menu -->
        <nav class="space-y-2">
            <a href="{{ route('orders.index') }}"
                class="flex items-center space-x-2 px-4 py-2 rounded-lg 
                  {{ request()->routeIs('options.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                <span>Orders</span>
            </a>

            <a href="{{ route('products.index') }}"
                class="flex items-center space-x-2 px-4 py-2 rounded-lg 
                      {{ request()->routeIs('products.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                </svg>
                <span>Products</span>
            </a>

            <a href="{{ route('categories.index') }}"
                class="flex items-center space-x-2 px-4 py-2 rounded-lg 
                      {{ request()->routeIs('categories.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span>Categories</span>
            </a>

            <a href="{{ route('options.index') }}"
                class="flex items-center space-x-2 px-4 py-2 rounded-lg 
                      {{ request()->routeIs('options.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
                <span>Options</span>
            </a>

            <a href="{{ route('inventory.index') }}"
                class="flex items-center space-x-2 px-4 py-2 rounded-lg 
                      {{ request()->routeIs('inventory.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                </svg>
                <span>Inventory</span>
            </a>

            <a href="{{ route('customer.menu') }}"
                class="flex items-center space-x-2 px-4 py-2 rounded-lg 
                      {{ request()->routeIs('menu.*') ? 'bg-gray-700' : 'hover:bg-gray-700' }}">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h5" />
                </svg>
                <span>Menu</span>
            </a>
        </nav>
    </div>
</aside>
