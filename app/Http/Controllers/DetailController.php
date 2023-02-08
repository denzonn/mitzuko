<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\RecomendationCategory;
use App\Models\TransactionDetail;
use App\Models\VariantType;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Jorenvh\Share\Share;

class DetailController extends Controller
{
    public function index(Request $request, $slug)
    {
        // Product Detail
        $product = Product::with(['galleries'])
            ->where('slug', $slug)
            ->firstOrFail();

        $newProduct = Product::with(['galleries'])
            ->where('categories_id', $product->categories_id)
            ->where('id', '!=', $product->id)
            ->take(6)
            ->get();

        // Recomendation Product
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

        // Variant Product
        $variant = VariantType::where('products_id', $product->id)->get();
        // Product Rating
        $productId = $product->id;

        // Ambil product comment berdasarkan idnya
        $productComment = ProductComment::where('products_id', $productId)
            ->with(['user', 'variant'])
            ->get();

        $totalBuying = TransactionDetail::where('shipping_status', 'SUCCESS')
            ->select('products_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('products_id')
            ->get();

        $rating = ProductComment::select('products_id', DB::raw('AVG(rating) as total_rating'))
            ->groupBy('products_id')
            ->get();

        // Share
        $share = \Share::page(
            // akses foto product
            url('/detail/' . $product->slug),
            'Segera dapatkan product ini sekarang juga ' . " . $product->name . " . 'dengan harga murah hanya di Toko Kami',
        )
            ->facebook()
            ->twitter()
            ->whatsapp()
            ->telegram();

        // End Share

        return view('pages.detail', [
            'share' => $share,
            'totalBuying' => $totalBuying,
            'rating' => $rating,
            'newProduct' => $newProduct,
            'productComment' => $productComment,
            'product' => $product,
            'recomendationOne' => $recomendationOne,
            'recomendationTwo' => $recomendationTwo,
            'variant' => $variant,
        ]);
    }

    public function add(Request $request, $id)
    {
        // Ambil data product berdasarkan id
        $cart = Cart::where('products_id', $id)->where('users_id', Auth::user()->id);

        // Lakukan pengecekan apakah product yang di add ke cart sudah ada di cart
        if ($cart->count()) {
            // Cek juga apakah variant id nya sama klaw sama tambahkan quantity nya klaw variant id nya beda tambahkan cart baru
            if ($cart->first()->variant_type_id == $request->input('variant_id')) {
                $cart = Cart::where('products_id', $id)
                    ->where('users_id', Auth::user()->id)
                    ->where('variant_type_id', $request->input('variant_id'))
                    ->first();
                $cart->increment('quantity');
                $cart = $cart->first();
            } else if ($cart->first()->variant_type_id != $request->input('variant_id')) {
                // Jika variant idnya berbeda tambahkan cart baru
                $data = [
                    'variant_type_id' => $request->input('variant_id'),
                    'users_id' => Auth::user()->id,
                    'products_id' => $id,
                    'quantity' => 1,
                ];
                Cart::create($data);
            }
        } else {
            if ($request->input('variant_id')) {
                $data = [
                    'variant_type_id' => $request->input('variant_id'),
                    'users_id' => Auth::user()->id,
                    'products_id' => $id,
                    'quantity' => 1,
                ];
            } else {
                $data = [
                    'users_id' => Auth::user()->id,
                    'products_id' => $id,
                    'quantity' => 1,
                ];
            }
            // dd($data);
            Cart::create($data);
        }

        return redirect()->route('cart');
    }
}
