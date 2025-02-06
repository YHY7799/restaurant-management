<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItem;
use App\Models\Product;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();
        return view('orders.index', compact('orders'));
    }


    public function create()
    {
        return view('orders.create'); // The Blade file that includes @livewire('create-order')
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'nullable|exists:customers,id', // Make customer_id optional
            'items' => 'required|array',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $order = Order::create([
            'customer_id' => $request->customer_id, // Can be null
            'order_number' => 'ORD' . time(),
            'status' => 'pending',
            'total_amount' => 0, // Calculate total in the next step
        ]);

        $totalAmount = 0;

        foreach ($request->items as $item) {
            $product = Product::find($item['product_id']);
            $orderItem = $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $product->price,
            ]);

            $totalAmount += $product->price * $item['quantity'];
        }

        $order->update(['total_amount' => $totalAmount]);

        return redirect()->route('orders.index')->with('success', 'Order created successfully.');
    }

    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,preparing,completed',
        ]);

        $order->status = $validated['status'];
        $order->save();

        return redirect()->back()->with('success', 'Order status updated successfully!');
    }
}
