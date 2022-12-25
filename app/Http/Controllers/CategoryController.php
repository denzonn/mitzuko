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

        //Relasikan dahulu dengan galleries untuk mengambil gambarnya
        $products = Product::with(['galleries'])->paginate(32);
        return view('pages.category', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    public function detail(Request $request, $slug)
    {
        $categories = Category::all();

        //Relasikan dahulu dengan galleries untuk mengambil gambarnya
        $category = Category::where('slug', $slug)->firstOrFail();

        $products = Product::with(['galleries'])->where('categories_id', $category->id)->paginate(32);
        return view('pages.category', [
            'categories' => $categories,
            'products' => $products,
        ]);
    }
}
