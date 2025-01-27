@extends('layouts.app')

@section('content')
@include('inventory.form', [
    'title' => 'Edit Inventory Item',
    'buttonText' => 'Update Item',
    'action' => route('inventory.update', $item->id),
    'method' => 'PUT',
    'item' => $item
])
@endsection