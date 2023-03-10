<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartIncDecController extends Controller
{
    // public function cartIncrement(Request $request)
    // {
    //     $cart = Cart::find($request->cart_id);
    //     $cart->increment('quantity');
    //     return response()->json([
    //         'success' => true,
    //         'data'    => $cart
    //     ]);
    // }

    // public function cartDecrement(Request $request)
    // {
    //     $cart = Cart::find($request->cart_id);
    //     $cart->decrement('quantity');
    //     return response()->json([
    //         'success' => true,
    //         'data'    => $cart,
    //     ]);
    // }

    public function incrementQuantity(Request $request)
    {
        $cart = Cart::where('id', $request->cart_id)->first();
        $cart->increment('quantity');
        return response()->json([
            'success' => 'Quantity Increment',
            'quantity' => $cart->quantity,
        ]);
    }

    public function decrementQuantity(Request $request)
    {
        $cart = Cart::where('id', $request->cart_id)->first();
        $cart->decrement('quantity');
        return response()->json([
            'success' => 'Quantity Decrement',
            'quantity' => $cart->quantity,
        ]);
    }
}
