<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Chat;
use App\Models\Product;
use App\Models\ProductComment;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{


    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::all();
        //Relasikan dahulu dengan galleries untuk mengambil gambarnya
        $products = Product::with(['galleries'])->latest()->paginate(80);


        $popularProducts = Product::with(['galleries'])
            ->join('transaction_details', 'products.id', '=', 'transaction_details.products_id')
            ->selectRaw('products.*, sum(transaction_details.quantity) as total_purchases')
            ->groupBy('products.id')
            ->orderBy('total_purchases', 'desc')
            ->limit(12)
            ->get();

        // Cek semua products_id yang ada pada $transaction, jika sama gabungkan lalu jumlahkan berdasrkan quantitynya
        $totalBuying = TransactionDetail::where('shipping_status', 'SUCCESS')
            ->select('products_id', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('products_id')
            ->get();

        // Ambil rating dari productComment 
        $rating = ProductComment::select('products_id', DB::raw('AVG(rating) as total_rating'))
            ->groupBy('products_id')
            ->get();
        // dd($rating);

        return view('pages.home', [
            'popularProducts' => $popularProducts,
            'rating' => $rating,
            'totalBuying' => $totalBuying,
            'categories' => $categories,
            'products' => $products
        ]);
    }

    public function product()
    {
        $searchKeyword = request('search');

        return view('pages.product', [
            'search' => Product::with(['galleries'])->filter()->get(),
            'fresh' => Product::with(['galleries'])->filter()->latest()->get(),
            'searchKeyword' => $searchKeyword,
            'popular' => Product::join('transaction_details', 'products.id', '=', 'transaction_details.products_id')
                ->selectRaw('products.*, sum(transaction_details.quantity) as total_purchases')
                ->groupBy('products.id')
                ->orderBy('total_purchases', 'desc')
                ->filter()
                ->get(),
            // 'cheapest' => Product::cheapest($searchKeyword),
            // 'mostExpensive' => Product::mostExpensive($searchKeyword),
        ]);
    }
}
