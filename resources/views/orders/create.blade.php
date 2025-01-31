@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h1 class="text-2xl font-bold text-gray-800">Order Details</h1>
    <a href="{{ route('orders.index') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
        Back to Orders
    </a>
</div>
    <div class="container mx-auto p-6">
        @livewire('create-order')
    </div>
@endsection
