<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InventoryItem;
use App\Models\Product;

class InventoryItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = InventoryItem::latest()->paginate(10);
        return view('inventory.index', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('inventory.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost_per_unit' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0'
        ]);

        InventoryItem::create($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory item created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $item = InventoryItem::findOrFail($id);
        return view('inventory.show', compact('item'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $item = InventoryItem::findOrFail($id);
        return view('inventory.edit', compact('item'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'cost_per_unit' => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0'
        ]);

        $item = InventoryItem::findOrFail($id);
        $item->update($validated);

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $item = InventoryItem::findOrFail($id);
        
        // Prevent deletion if used in products
        if($item->products()->exists()) {
            return redirect()->back()
                ->with('error', 'Cannot delete item - it is being used in products');
        }

        $item->delete();

        return redirect()->route('inventory.index')
            ->with('success', 'Inventory item deleted successfully');
    }
}