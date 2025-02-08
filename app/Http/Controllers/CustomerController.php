<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Category;
use App\Cart\Facades\Cart;



class CustomerController extends Controller
{

    // View the menu
    public function viewMenu($category = null)
    {
        // Fetch all active products with images
        $products = Product::where('active', true)->with('images');

        // Filter products by category if a category is selected
        if ($category) {
            $products->where('category_id', $category);
        }

        // Execute the query and get results
        $products = $products->get();

        // Fetch all categories
        $categories = Category::all();

        // Pass products and categories to the view
        return view('customer.menu', compact('products', 'categories'));
    }


    public function viewMenuByCategory(Category $category)
    {
        // Fetch active products in the selected category
        $products = Product::where('active', true)->where('category_id', $category->id)->get();

        // Fetch all categories
        $categories = Category::all();

        // Pass products and categories to the view
        return view('customer.menu', compact('products', 'categories'));
    }

    public function addToCart(Request $request)
    {
        $product = Product::findOrFail($request->product_id);

        // Add the product to the cart
        Cart::add($product->id, $product->name, $product->price, $request->quantity);
        session()->put('cart', [
            1 => ['quantity' => 2, 'price' => 10.00], // Example item
        ]);


        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function viewCart()
    {
        // Fetch the cart items
        $cart = Cart::content();

        // Pass the cart items to the view
        return view('customer.cart', compact('cart'));
    }

    public function update(Request $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');

        // Update the cart using the Cart facade
        Cart::update($productId, $quantity);

        return redirect()->route('customer.cart')->with('success', 'Cart updated successfully');
    }

    public function removeFromCart(Request $request)
    {
        Cart::remove($request->product_id);
        return redirect()->back()->with('success', 'Product removed from cart!');
    }

    // Submit the order
    public function submitOrder(Request $request)
    {
        if (config('app.order_submission_enabled', true)) {
            $cart = session()->get('cart', []);

            if (empty($cart)) {
                return redirect()->back()->with('error', 'Your cart is empty!');
            }

            $request->validate([
                'name' => 'nullable|string|max:255',
                'phone' => 'nullable|string|max:20',
            ]);

            $customerName = $request->name ?: null;

            $orderNumber = 'ORD-' . strtoupper(uniqid());

            $totalAmount = array_reduce($cart, function ($sum, $item) {
                return $sum + ($item['quantity'] * $item['price']);
            }, 0);

            // Create the order
            $order = new Order();
            $order->order_number = $orderNumber;
            $order->customer_name = $customerName;;
            $order->customer_phone = $request->phone;
            $order->status = 'pending';
            $order->total_amount = $totalAmount;
            $order->source = true; // Mark this as a customer order
            $order->save();

            // Save order items
            foreach ($cart as $productId => $item) {
                $product = Product::find($productId);
                if ($product) {
                    $orderItem = new OrderItem();
                    $orderItem->order_id = $order->id;
                    $orderItem->product_id = $productId;
                    $orderItem->quantity = $item['quantity'];
                    $orderItem->price = $item['price'];
                    $orderItem->save();
                }
            }

            session()->forget('cart');

            return redirect()->route('customer.order.confirmation')->with('success', 'Order placed successfully!');
        } else {
            return redirect()->back()->with('error', 'Order submission is currently disabled.');
        }
    }


    // Order confirmation page
    public function orderConfirmation()
    {
        return view('customer.order_confirmation');
    }
}
