@extends('layouts.app')

@section('title', 'Create Option')

@section('content')
<div class="container">
    <h1>Create Option</h1>
    <form action="{{ route('options.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Option Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        </div>

        <div class="mb-3">
            <label for="additional_price" class="form-label">Additional Price</label>
            <input type="number" class="form-control" id="additional_price" name="additional_price" step="0.01" value="{{ old('additional_price') }}" required>
        </div>

        <div class="mb-3">
            <label for="product_id" class="form-label">Product</label>
            <select class="form-control" id="product_id" name="product_id" required>
                <option value="" disabled selected>Select a product</option>
                @foreach($products as $product)
                    <option value="{{ $product->id }}" {{ old('product_id') == $product->id ? 'selected' : '' }}>
                        {{ $product->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Create Option</button>
    </form>
</div>
@endsection
