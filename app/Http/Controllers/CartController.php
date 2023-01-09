<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with(['product.galleries'])
            ->where('users_id', Auth::user()->id)
            ->get();

        return view('pages.cart', [
            'carts' => $carts,
        ]);
    }

    public function pricing(Request $request)
    {
        $id = $request->input('id');

        $carts = Cart::with(['product'])
            ->whereIn('id', $id)
            ->get();

        $totalPrice = 0;
        foreach ($carts as $cart) {
            $totalPrice += $cart->product->price * $cart->quantity;
        }

        return response()->json(['totalPrice' => $totalPrice]);
    }

    public function delete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        $cart->delete();

        return redirect()->route('cart');
    }

    public function success()
    {
        return view('pages.success');
    }
}
