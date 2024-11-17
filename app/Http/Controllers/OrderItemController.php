<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class OrderItemController extends Controller
{
    public function addToCart(Request $request, $product_id)
    {
        $product = Product::find($product_id);
        // Check if the product exists
        if (!$product) {
            return redirect()->back()->with('error', 'Product not found.');
        }

        $cart = session()->get('cart', []);
        // Increment quantity if product already exists in cart
        if (isset($cart[$product_id])) {
            $cart[$product_id]['quantity']++;
        } else {
            // Add new product to cart
            $cart[$product_id] = [
                "name" => $product->name,
                "price" => $product->price,
                "quantity" => 1,
                "image" => $product->image
            ];
        }

        session()->put('cart', $cart);
        return redirect()->route('cart')->with('success', 'Product added to cart successfully!');
    }

    public function updateCart(Request $request)
    {
        $cart = session()->get('cart');

        if ($cart && isset($cart[$request->id])) {
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);

            // Calculate totals
            $itemTotal = number_format($cart[$request->id]["price"] * $cart[$request->id]["quantity"], 2);
            $cartTotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

            return response()->json(['success' => 'Cart updated successfully', 'itemTotal' => $itemTotal, 'cartTotal' => number_format($cartTotal, 2)]);
        }

        return response()->json(['error' => 'Product not found in cart'], 404);
    }

    public function removeFromCart(Request $request)
    {
        $cart = session()->get('cart');

        if ($cart && isset($cart[$request->id])) {
            unset($cart[$request->id]);
            session()->put('cart', $cart);

            // Calculate new total
            $cartTotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

            return response()->json(['success' => 'Product removed successfully', 'cartTotal' => number_format($cartTotal, 2)]);
        }

        return response()->json(['error' => 'Product not found in cart'], 404);
    }

}
