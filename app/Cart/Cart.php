<?php

namespace App\Cart;

use Illuminate\Support\Facades\Session;

class Cart
{
    protected $cartKey = 'shopping_cart';

    /**
     * Add a product to the cart.
     */
    public function add($productId, $name, $price, $quantity = 1, $options = [])
    {
        $cart = Session::get($this->cartKey, []);

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] += $quantity;
        } else {
            $cart[$productId] = [
                'name' => $name,
                'price' => $price,
                'quantity' => $quantity,
                'options' => $options,
            ];
        }

        Session::put($this->cartKey, $cart);
    }

    /**
     * Remove a product from the cart.
     */
    public function remove($productId)
    {
        $cart = Session::get($this->cartKey, []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put($this->cartKey, $cart);
        }
    }

    /**
     * Get all items in the cart.
     */
    public function content()
    {
        return Session::get($this->cartKey, []);
    }

    /**
     * Get the total number of items in the cart.
     */
    public function count()
    {
        return count($this->content());
    }

    /**
     * Clear the cart.
     */
    public function clear()
    {
        Session::forget($this->cartKey);
    }

    /**
     * Get the total price of items in the cart.
     */
    public function total()
    {
        $total = 0;
        foreach ($this->content() as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        return $total;
    }
}