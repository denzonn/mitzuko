<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with(['galleries', 'category'])->get();
        return view('pages.admin.product.index', [
            'products' => $products
        ]);
    }

    public function detail(Request $request, $id)
    {
        $product = Product::with(['galleries', 'category'])->findOrFail($id);

        $categories = Category::all();

        return view('pages.admin.product.detail', [
            'product' => $product,
            'categories' => $categories
        ]);
    }

    public function uploadGallery(Request $request)
    {
        $product = Product::findOrFail($request->products_id);

        if ($request->hasFile('photos')) {
            $images = $request->file('photos');

            $extension = $images->getClientOriginalExtension();

            $random = \Str::random(10);
            $file_name = "product-gallery" . $random . "." . $extension;
        }

        $gallery = [
            'products_id' => $product->id,
            'photos' => $request->file('photos')->storeAs('public/assets/product-gallery', $file_name)
        ];

        ProductGallery::create($gallery);

        return redirect()->route('admin-dashboard-product-details', $request->products_id);
    }

    public function deleteGallery(Request $request, $id)
    {
        $item = ProductGallery::findOrFail($id);
        $item->delete();

        return redirect()->route('admin-dashboard-product-details', $item->products_id);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //Relasi untuk memanggil di View
        $categories = Category::all();

        return view('pages.admin.product.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->all();

        $data['slug'] = \Str::slug($request->name);

        $product = Product::create($data);

        if ($request->hasFile('photo')) {
            $images = $request->file('photo');

            $extension = $images->getClientOriginalExtension();

            $random = \Str::random(10);
            $file_name = "product-gallery" . $random . "." . $extension;
        }

        $gallery = [
            'products_id' => $product->id,
            'photos' => $request->file('photo')->storeAs('public/assets/product-gallery', $file_name)
        ];

        ProductGallery::create($gallery);

        return redirect()->route('product.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $item = Product::findOrFail($id);
        $categories = Category::all();

        return view('pages.admin.product.edit', [
            'item' => $item,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {
        $data = $request->all();

        $item = Product::findOrFail($id);

        $data['slug'] = \Str::slug($request->name);

        $item->update($data);

        return redirect()->route('product.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Product::findOrFail($id);
        $item->delete();

        return redirect()->route('product.index');
    }
}
