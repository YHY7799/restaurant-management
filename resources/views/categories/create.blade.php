@extends('layouts.app')

@section('title', 'Create Category')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-2xl font-bold mb-4">Create Category</h1>
    <form action="{{ route('categories.store') }}" method="POST">
      @csrf
      <div class="mb-4">
        <label for="name" class="block text-sm font-medium text-gray-700">Category Name</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" required 
               class="mt-1 p-2 w-full border rounded-md shadow-sm focus:border-blue-500 focus:outline-none" />
      </div>
      <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Create Category</button>
    </form>
  </div>
@endsection
