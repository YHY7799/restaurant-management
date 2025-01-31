<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;

class CreateOrder extends Component
{
    public $categories;
    public $products;
    public $orderItems = [];
    public $selectedCategory = null;

    public function mount()
    {
        $this->categories = Category::all();
        $this->products = Product::all();
    }

    public function selectCategory($categoryId)
    {
        $this->selectedCategory = $categoryId;
        $this->products = Product::where('category_id', $categoryId)->get();
    }

    public function addToOrder($productId)
    {
        $product = Product::find($productId);

        if ($product) {
            $this->orderItems[] = [
                'id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }
    }

    public function removeItem($index)
    {
        unset($this->orderItems[$index]);
        $this->orderItems = array_values($this->orderItems);
    }

    public function saveOrder()
    {
        if (empty($this->orderItems)) {
            session()->flash('message', 'Cannot save an empty order.');
            return;
        }

        $order = Order::create([
            'order_number' => strtoupper(uniqid('ORD-')), // Generate a unique order number
            'status' => 'pending',
            'total_amount' => collect($this->orderItems)->sum(fn($item) => $item['quantity'] * $item['price']),
        ]);

        foreach ($this->orderItems as $item) {
            $order->items()->create([
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        $this->reset(['orderItems']);
        session()->flash('message', 'Order saved successfully!');
    }

    public function processOrder()
    {
        if (empty($this->orderItems)) {
            session()->flash('message', 'Cannot process an empty order.');
            return;
        }

        $order = Order::create([
            'order_number' => strtoupper(uniqid('ORD-')),
            'status' => 'processed', // Mark as processed
            'total_amount' => collect($this->orderItems)->sum(fn($item) => $item['quantity'] * $item['price']),
        ]);

        foreach ($this->orderItems as $item) {
            $order->items()->create([
                'product_id' => $item['id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }

        $this->reset(['orderItems']);
        session()->flash('message', 'Order processed successfully!');
    }


    public function voidOrder()
    {
        $this->orderItems = [];
    }

    public function render()
    {
        return view('livewire.create-order');
    }
}
