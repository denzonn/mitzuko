<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\RecomendationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

class DetailController extends Controller
{
    public function index(Request $request, $slug)
    {
        $product = Product::with(['galleries'])
            ->where('slug', $slug)
            ->firstOrFail();

        $id = $product->categories_id;

        $recomendation_one = RecomendationCategory::where('categories_id', $id)
            ->first()
            ->recomendation_one;

        $recomendation_two = RecomendationCategory::where('categories_id', $id)
            ->first()
            ->recomendation_two;

        // Ambil data product berdasarkan id yang direkomendasikan ambil 10 data teratas
        $recomendationOne = Product::with(['galleries'])
            ->where('categories_id', $recomendation_one)
            ->join('transaction_details', 'products.id', '=', 'transaction_details.products_id')
            ->selectRaw('products.*, sum(transaction_details.quantity) as total_purchases')
            ->groupBy('products.id')
            ->orderBy('total_purchases', 'desc')
            ->take(10)
            ->get();

        // Lakukan Pengecekan Apakah data yang ada klaw tidak ambil semua product berdasarkan categories_id dari recomendation
        if (count($recomendationOne) == 0) {
            $recomendationOne = Product::with(['galleries'])
                ->where('categories_id', $recomendation_one)
                ->take(20)
                ->get();
        } else {
            $recomendationOne;
        }

        $recomendationTwo = Product::where('categories_id', $recomendation_two)
            ->where('categories_id', $recomendation_two)
            ->join('transaction_details', 'products.id', '=', 'transaction_details.products_id')
            ->selectRaw('products.*, sum(transaction_details.quantity) as total_purchases')
            ->groupBy('products.id')
            ->orderBy('total_purchases', 'desc')
            ->take(20)
            ->get();

        if (count($recomendationTwo) == 0) {
            $recomendationOne = Product::with(['galleries'])
                ->where('categories_id', $recomendation_two)
                ->take(10)
                ->get();
        } else {
            $recomendationTwo;
        }

        return view('pages.detail', [
            'product' => $product,
            'recomendationOne' => $recomendationOne,
            'recomendationTwo' => $recomendationTwo
        ]);
    }

    public function add(Request $request, $id)
    {
        $cart = Cart::where('products_id', $id)->where('users_id', Auth::user()->id);

        if ($cart->count()) {
            $cart->increment('quantity');
            $cart = $cart->first();
        } else {
            $data = [
                'products_id' => $id,
                'users_id' => Auth::user()->id,
                'quantity' => 1,
            ];
            Cart::create($data);
        }

        return redirect()->route('cart');
    }
}
