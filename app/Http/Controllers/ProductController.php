<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use App\Models\InventoryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with(['category', 'images', 'options'])->get();
        return view('products.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'sometimes|file|mimes:jpg,jpeg,png,gif,webp|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // Create the product
            $product = Product::create($validated);

            // Handle image uploads
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');

                    // Use the relationship to create images
                    $product->images()->create([
                        'image_path' => $path
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors('Error creating product: ' . $e->getMessage());
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
        $product->load('images'); // Eager load images
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
{
    $product->load('images');
    $categories = Category::all();
    $inventoryItems = InventoryItem::all(); // Get inventory items
    
    return view('products.edit', compact('product', 'categories', 'inventoryItems'));
}

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        // Update the product
        $product->update($validated);

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path
                ]);
            }
        }

        $inventoryItems = [];
        foreach ($request->input('inventory_items', []) as $itemId) {
            $inventoryItems[$itemId] = ['quantity' => $request->input('quantities.' . $itemId, 1)];
        }
        $product->inventoryItems()->sync($inventoryItems);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete associated images (handled by model events)
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
