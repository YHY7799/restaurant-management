@extends('layouts.app')

@section('content')
@include('inventory.form', [
    'title' => 'Add New Inventory Item',
    'buttonText' => 'Create Item',
    'action' => route('inventory.store')
])
@endsection