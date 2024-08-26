<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|string',
            'user_email' => 'required|email',
            'product_id' => 'required|string',
            'product_name' => 'required|string',
            'product_quantity' => 'required|integer|min:1',
            'price_per_product' => 'required|numeric|min:0',
        ]);

        $cartItem = Cart::firstOrNew([
            'user_id' => $validatedData['user_id'],
            'product_id' => $validatedData['product_id'],
        ]);

        $cartItem->user_email = $validatedData['user_email'];
        $cartItem->product_name = $validatedData['product_name'];
        $cartItem->product_quantity += $validatedData['product_quantity'];
        $cartItem->price_per_product = $validatedData['price_per_product'];
        $cartItem->save();

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart successfully!',
            'data' => $cartItem,
        ], 200);
    }

    public function fetchCart(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|string',
        ]);

        $cartItems = Cart::where('user_id', $validatedData['user_id'])->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No items found in the cart',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $cartItems,
        ], 200);
    }

    public function deleteCartItem(Request $request)
    {
        $validatedData = $request->validate([
            'user_id' => 'required|string',
            'product_id' => 'required|string',
        ]);

        $cartItem = Cart::where('user_id', $validatedData['user_id'])
                        ->where('product_id', $validatedData['product_id'])
                        ->first();

        if (!$cartItem) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found in the cart',
            ], 404);
        }

        $cartItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Item deleted from cart successfully!',
        ], 200);
    }
}
