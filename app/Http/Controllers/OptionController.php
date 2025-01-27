<?php

namespace App\Http\Controllers;

use App\Models\Option;
use App\Models\Product;
use Illuminate\Http\Request;

class OptionController extends Controller
{
    public function index()
    {
        $options = Option::with('product')->get();
        return view('options.index', compact('options'));
    }

    public function create()
    {
        $products = Product::all();
        return view('options.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'additional_price' => 'required|numeric',
            'product_id' => 'required|exists:products,id',
        ]);

        Option::create($request->all());

        return redirect()->route('options.index')->with('success', 'Option created successfully.');
    }

    public function show(Option $option)
    {
        return view('options.show', compact('option'));
    }

    public function edit(Option $option)
    {
        $products = Product::all();
        return view('options.edit', compact('option', 'products'));
    }

    public function update(Request $request, Option $option)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'additional_price' => 'required|numeric',
            'product_id' => 'required|exists:products,id',
        ]);

        $option->update($request->all());

        return redirect()->route('options.index')->with('success', 'Option updated successfully.');
    }

    public function destroy(Option $option)
    {
        $option->delete();

        return redirect()->route('options.index')->with('success', 'Option deleted successfully.');
    }
}
