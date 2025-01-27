@extends('layouts.app')

@section('title', 'Categories')

@section('content')
<div class="container mx-auto px-4 max-w-4xl py-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800 mb-4 sm:mb-0">Categories</h1>
        <a href="{{ route('categories.create') }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition-all duration-200 transform hover:scale-105">
            Add Category
        </a>
    </div>

    @if($categories->isEmpty())
        <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
            <p class="text-gray-600">No categories found. Start by adding a new category!</p>
        </div>
    @else
        <ul class="space-y-4">
            @foreach($categories as $category)
                <li class="flex flex-col sm:flex-row justify-between items-start sm:items-center bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200 border border-gray-100">
                    <span class="text-gray-700 font-medium text-lg mb-2 sm:mb-0">{{ $category->name }}</span>
                    <div class="flex space-x-3">
                        <a href="{{ route('categories.edit', $category) }}" 
                           class="text-yellow-600 hover:text-yellow-500 mr-4">
                            Edit
                        </a>
                        <form action="{{ route('categories.destroy', $category) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-600 hover:text-red-500 mr-4"
                                    onclick="return confirm('Are you sure you want to delete this category?')">
                                Delete
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>
@endsection