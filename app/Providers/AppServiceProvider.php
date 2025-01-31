<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use Livewire\Livewire;
use App\Livewire\CreateOrder;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register the search-select component
        // Blade::component('search-select', \App\View\Components\SearchSelect::class);
        Livewire::component('create-order', CreateOrder::class);
        
    }
}