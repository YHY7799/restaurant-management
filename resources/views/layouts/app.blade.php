<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    @stack('scripts')
</head>

<body class="bg-gray-100" x-data="{ sidebarOpen: false }">
    <div class="flex">
        <!-- Desktop Sidebar -->
        <div class="hidden lg:block">
            @include('layouts.sidebar')
        </div>

        <!-- Main Content Area -->
        <div class="flex-1 flex flex-col relative">
            <!-- Search Form in Top Left -->
            <div class="w-full p-4 bg-white shadow-sm relative">
                <form id="searchForm" class="flex items-center space-x-2">
                    <div class="relative w-full">
                        <input id="searchInput"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none"
                            type="search" name="query" placeholder="Search" aria-label="Search"
                            autocomplete="on" />
                        <div id="searchResults"
                            class="hidden absolute z-50 w-full mt-2 bg-white rounded-lg shadow-lg border border-gray-200 max-h-96 overflow-y-auto">
                        </div>
                    </div>
                </form>
            </div>

            <!-- Main Content Area -->
            <div class="flex-1 flex flex-col">


                <!-- Mobile Menu Button -->
                <button @click="sidebarOpen = true"
                    class="lg:hidden fixed bottom-4 right-4 p-3 bg-gray-800 text-white rounded-full shadow-lg z-50">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

                <!-- Mobile Sidebar -->
                <div class="lg:hidden fixed inset-0 z-40" x-show="sidebarOpen" @click.away="sidebarOpen = false">
                    <div class="absolute inset-0 bg-black/50"></div>
                    <div class="relative bg-gray-800 w-64 min-h-screen p-4">
                        @include('layouts.sidebar')
                    </div>
                </div>

                <!-- Main Content -->
                <main class="flex-1 p-6 lg:p-8">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
    </div>

    <script>
        // Add debounce function to limit API calls
        function debounce(func, timeout = 300) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => {
                    func.apply(this, args);
                }, timeout);
            };
        }

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        const searchResults = document.getElementById('searchResults');

        const performSearch = debounce(async (query) => {
            console.log('Search query:', query);

            if (query.length < 2) {
                searchResults.classList.add('hidden');
                return;
            }

            try {
                const response = await fetch(`/search?query=${encodeURIComponent(query)}`);
                console.log('API Response:', response);

                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }

                const results = await response.json();
                console.log('Parsed Results:', results);

                searchResults.innerHTML = '';

                if (
                    results.products.length === 0 &&
                    results.categories.length === 0 &&
                    results.customers.length === 0 &&
                    results.orders.length === 0
                ) {
                    searchResults.innerHTML = `
                <div class="p-4 text-gray-500">No results found for "${query}"</div>
            `;
                } else {
                    let html = '';

                    // Display Products
                    if (results.products.length > 0) {
                        html +=
                        `<div class="p-2 text-sm font-semibold text-gray-500 bg-gray-50">Products</div>`;
                        results.products.forEach(product => {
                            html += `
                        <a href="/products/${product.id}" class="flex items-center p-3 hover:bg-gray-50 border-b border-gray-100">
                            <div class="ml-4">
                                <div class="text-gray-900 font-medium">${product.name}</div>
                                <div class="text-sm text-gray-500">${product.category.name}</div>
                            </div>
                        </a>
                    `;
                        });
                    }

                    // Display Categories
                    if (results.categories.length > 0) {
                        html +=
                            `<div class="p-2 text-sm font-semibold text-gray-500 bg-gray-50">Categories</div>`;
                        results.categories.forEach(category => {
                            html += `
                        <a href="/menu/${category.slug}" class="flex items-center p-3 hover:bg-gray-50 border-b border-gray-100">
                            <div class="ml-4">
                                <div class="text-gray-900 font-medium">${category.name}</div>
                            </div>
                        </a>
                    `;
                        });
                    }

                    // Display Customers
                    if (results.customers.length > 0) {
                        html +=
                            `<div class="p-2 text-sm font-semibold text-gray-500 bg-gray-50">Customers</div>`;
                        results.customers.forEach(customer => {
                            html += `
                        <a href="/customers/${customer.id}" class="flex items-center p-3 hover:bg-gray-50 border-b border-gray-100">
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-gray-900 font-medium">${customer.name}</div>
                                <div class="text-sm text-gray-500">${customer.phone}</div>
                            </div>
                        </a>
                    `;
                        });
                    }

                    // Display Orders
                    if (results.orders.length > 0) {
                        html += `<div class="p-2 text-sm font-semibold text-gray-500 bg-gray-50">Orders</div>`;
                        results.orders.forEach(order => {
                            html += `
                        <a href="/orders/${order.id}" class="flex items-center p-3 hover:bg-gray-50 border-b border-gray-100">
                            <div class="w-12 h-12 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <div class="text-gray-900 font-medium">Order #${order.order_number}</div>
                                <div class="text-sm text-gray-500">${order.customer?.name || 'No Customer'}</div>
                            </div>
                        </a>
                    `;
                        });
                    }

                    searchResults.innerHTML = html;
                }

                searchResults.classList.remove('hidden');
            } catch (error) {
                console.error('Search error:', error);
                searchResults.innerHTML = `
            <div class="p-4 text-red-500">Error: ${error.message}</div>
        `;
                searchResults.classList.remove('hidden');
            }
        });

        // Event listeners
        searchInput.addEventListener('input', (e) => {
            performSearch(e.target.value.trim());
        });

        // Close search results when clicking outside
        document.addEventListener('click', (e) => {
            if (!e.target.closest('#searchForm')) {
                searchResults.classList.add('hidden');
            }
        });
    </script>

    @livewireScripts
</body>

</html>
