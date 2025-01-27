@extends('layouts.app')

@section('title', 'Edit Category')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Edit Category</h1>
    <form action="{{ route('categories.update', $category) }}" method="POST">
      @csrf
      @method('PUT')
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
        <input type="text" id="name" name="name" value="{{ old('name', $category->name) }}" required 
               class="mt-1 p-2 w-full border rounded-md shadow-sm focus:border-blue-500 focus:outline-none" />
      </div>
      <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Update Category</button>
    </form>
  </div>
@endsection
