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
        $product->load('images', 'inventoryItems');
        $availableInventoryItems = InventoryItem::all();

        return view('products.show', compact('product', 'availableInventoryItems'));
    }

    public function addInventoryItem(Request $request, Product $product)
{
    $request->validate([
        'inventory_item_id' => 'required|exists:inventory_items,id',
        'quantity_used' => 'required|numeric|min:0.0001',
    ]);

    // Attach the inventory item to the product
    $product->inventoryItems()->attach($request->inventory_item_id, [
        'quantity_used' => $request->quantity_used,
    ]);

    return redirect()->route('products.show', $product)->with('success', 'Inventory item added successfully!');
}

public function toggleStatus(Product $product, Request $request)
{
    $request->validate([
        'active' => 'required|boolean',
    ]);

    $product->update(['active' => $request->active]);

    return redirect()->back()->with('success', 'Product status updated successfully.');
}



    public function edit(Product $product)
    {
        $product->load('images', 'inventoryItems');
        $categories = Category::all();
        $inventoryItems = InventoryItem::all(); // Get all inventory items

        // Fetch selected inventory items and their quantities
        $selectedInventoryItems = $product->inventoryItems->map(function ($item) {
            return [
                'id' => $item->id,
                'name' => $item->name,
                'stock_quantity' => $item->stock_quantity,
                'storage_unit' => $item->storage_unit,
                'usage_unit' => $item->usage_unit,
                'conversion_factor' => $item->conversion_factor,
            ];
        });

        // Fetch quantities from the pivot table
        $quantities = $product->inventoryItems->pluck('pivot.quantity', 'id');

        return view('products.edit', compact(
            'product',
            'categories',
            'inventoryItems',
            'selectedInventoryItems',
            'quantities'
        ));
    }

    public function update(Request $request, Product $product)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0',
        'category_id' => 'required|exists:categories,id',
        'inventory_items' => 'array',
        'inventory_items.*' => 'exists:inventory_items,id',
        'quantities' => 'array',
        'quantities.*' => 'nullable|numeric|min:1',
    ]);

    // Update product details
    $product->update($request->only('name', 'price', 'description', 'category_id'));

    // Sync inventory items and their quantities
    $inventoryItems = [];
    foreach ($request->input('quantities', []) as $itemId => $quantity) {
        if (!empty($quantity) && $quantity > 0) {
            $inventoryItems[$itemId] = ['quantity_used' => $quantity];
        }
    }

    $product->inventoryItems()->sync($inventoryItems);

    return redirect()->route('products.index')->with('success', 'Product updated successfully!');
}


    public function destroy(Product $product)
    {
        // Delete associated images (handled by model events)
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}