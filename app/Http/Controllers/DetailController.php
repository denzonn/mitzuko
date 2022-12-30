<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class DetailController extends Controller
{
    public function index(Request $request, $id)
    {
        $product = Product::with(['galleries'])->where('slug', $id)->firstOrFail();
        return view('pages.detail', [
            'product' => $product
        ]);
    }

    public function add(Request $request, $id)
    {
        $cart = Cart::where('products_id', $id);

        if ($cart->count()) {
            $cart->increment('quantity');
            $cart = $cart->first();
        } else {
            $data = [
                'products_id' => $id,
                'users_id' => auth()->user()->id,
                'quantity' => 1,
            ];
            Cart::create($data);
        }

        return redirect()->route('cart');
    }
}
