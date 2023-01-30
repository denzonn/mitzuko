<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

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
        $products = Product::with(['galleries'])->latest()->paginate(32)->withQueryString();

        return view('pages.home', [
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
