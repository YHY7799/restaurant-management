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

        <!-- Mobile Menu Button -->
        <button @click="sidebarOpen = true"
            class="lg:hidden fixed bottom-4 right-4 p-3 bg-gray-800 text-white rounded-full shadow-lg z-50">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
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
        <main class="flex-1 min-h-screen p-6 lg:p-8">
            @yield('content')
        </main>
    </div>

    @livewireScripts
</body>

</html>
