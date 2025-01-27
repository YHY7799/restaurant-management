{{-- resources/views/test.blade.php --}}
@extends('layouts.app')

@section('title', 'Test Tailwind')

@section('content')
<div class="p-6 max-w-sm mx-auto bg-white rounded-xl shadow-md space-y-4">
    <h1 class="text-2xl font-bold text-gray-800">Hello, Tailwind CSS!</h1>
    <p class="text-gray-900">If you see this styled, Tailwind is working.</p>
</div>
@endsection
