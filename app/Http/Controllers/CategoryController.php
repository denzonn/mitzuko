<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();

        $products = Product::join('transaction_details', 'products.id', '=', 'transaction_details.products_id')
            ->selectRaw('products.*, sum(transaction_details.quantity) as total_purchases')
            ->groupBy('products.id')
            ->orderBy('total_purchases', 'desc')->limit(20)
            ->get();

        return view('pages.category', [
            'products' => $products,
            'categories' => $categories,
        ]);
    }

    public function detail(Request $request, $slug)
    {        //Relasikan dahulu dengan galleries untuk mengambil gambarnya
        $category = Category::where('slug', $slug)
            ->firstOrFail();

        $products = Product::with(['galleries'])
            ->where('categories_id', $category->id)
            ->get();

        return view('pages.category-detail', [
            'category' => $category,
            'products' => $products,
        ]);
    }
}
