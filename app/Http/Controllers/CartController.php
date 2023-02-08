<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Courier;
use App\Models\Product;
use App\Models\VariantType;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with(['product.galleries'])
            ->where('users_id', Auth::user()->id)
            ->get();

        $variantTypeIds = [];
        foreach ($carts as $cart) {
            // Ambil variant type id berdasarkan cart
            $variantTypeIds[] = $cart->variant_type_id;
        }
        $variantData = VariantType::whereIn('id', $variantTypeIds)->get();
        // dd($variantData);

        return view('pages.cart', [
            'variantData' => $variantData,
            'carts' => $carts,
        ]);
    }

    public function pricing(Request $request)
    {
        $id = $request->input('id', []);

        if (count($id) < 1) {
            return response()->json(['totalPrice' => 0]);
        } else {
            $carts = Cart::with(['product'])
                ->whereIn('id', $id)
                ->get();

            // Perulangan untuk mengambil price dari variant type
            $variantTypeIds = [];
            foreach ($carts as $cart) {
                $variantTypeIds[] = $cart->variant_type_id;
            }
            $variantData = VariantType::whereIn('id', $variantTypeIds)->get();

            // Perulangan jumlah harga 
            $totalPrice = 0;
            foreach ($carts as $cart) {
                // Jika variant type id tidak ada maka ambil dari product
                $found = false;
                foreach ($variantData as $variant) {
                    if ($cart->variant_type_id == $variant->id) {
                        $totalPrice += $variant->price * $cart->quantity;
                        $found = true;
                        break;
                    }
                }
                if (!$found) {
                    $totalPrice += $cart->product->price * $cart->quantity;
                }
            }
            return response()->json(['totalPrice' => $totalPrice]);
        }
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
