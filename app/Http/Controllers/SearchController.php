<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Order;


class SearchController extends Controller
{
    public function searchApi(Request $request)
    {
        $query = $request->input('query');

        // Search products
        $products = Product::with('category')
            ->where('name', 'like', "%{$query}%")
            ->orWhere('description', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        // Search categories
        $categories = Category::where('name', 'like', "%{$query}%")
            ->limit(3)
            ->get();

        // Search customers
        $customers = Customer::where('name', 'like', "%{$query}%")
            ->orWhere('phone', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        // Search orders by order number
        $orders = Order::where('order_number', 'like', "%{$query}%")
            ->limit(5)
            ->get();

        return response()->json([
            'products' => $products,
            'categories' => $categories,
            'customers' => $customers,
            'orders' => $orders,
        ]);
    }
}
