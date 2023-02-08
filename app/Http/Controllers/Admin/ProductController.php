<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductGallery;
use App\Models\VariantProduct;
use App\Models\VariantType;
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

    public function search(Request $request)
    {
        // dd($request);
        // if ($request->has('search')) {
        //     $products = Product::where('name', 'LIKE', '%' . $request->search . '%')->get();
        //     dd($products);
        // } else {
        //     $products = Product::with(['galleries', 'category'])->get();
        // }

        // return view('pages.admin.product.index', [
        //     'products' => $products
        // ]);
        $keyword = $request['search'];

        $products = Product::where('name', 'like', '%' . $keyword . '%')->get();

        return view('pages.admin.product.index', [
            'products' => $products
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
        $variantProduct = VariantProduct::all();

        return view('pages.admin.product.create', [
            'categories' => $categories,
            'variantProduct' => $variantProduct
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

        // Product
        $data['slug'] = \Str::slug($request->name);
        $product = Product::create($data);

        // Variant Product
        $variants = [];
        foreach ($request->variant_name as $key => $value) {
            $variant = [
                'products_id' => $product->id,
                'variant_product_id' => $request->variant_product_id ?? 0,
                'name' => $value ?? 'No Variant',
                'price' => $request->variant_price[$key] ?? 0,
                'stock' => $request->variant_stock[$key] ?? 0,
            ];
            $variants[] = $variant;

            VariantType::create($variant);
        }

        // Gallery Product
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


    public function detail(Request $request, $id)
    {
        $product = Product::with(['galleries', 'category', 'variantProduct'])->findOrFail($id);

        $categories = Category::all()->except($product->categories_id);

        // Ambil data variant product
        $variantProduct = VariantProduct::all()->except($product->variant_product_id);

        // Cek dahulu apakah ada variant product kalau ada maka ambil variant typenya berdasarkan product id
        if (isset($product->variant_product_id)) {
            $variantType = VariantType::where('products_id', $product->id)->get();
        } else {
            $variantType = null;
        }

        return view('pages.admin.product.detail', [
            'variantType' => $variantType,
            'variantProduct' => $variantProduct,
            'product' => $product,
            'categories' => $categories
        ]);
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
        // Product
        $data = $request->all();
        $item = Product::findOrFail($id);
        $data['slug'] = \Str::slug($request->name);
        $item->update($data);

        // Update Variant Product
        $variant_ids = [];
        foreach ($request->variant_name as $key => $value) {
            $variant = [
                'products_id' => $item->id,
                'variant_product_id' => $request->variant_product_id ?? 0,
                'name' => $value ?? 'No Variant',
                'price' => $request->variant_price[$key] ?? 0,
                'stock' => $request->variant_stock[$key] ?? 0,
            ];

            $variant_id = VariantType::updateOrCreate(
                [
                    'products_id' => $item->id,
                    'variant_product_id' => $variant['variant_product_id'],
                    'name' => $variant['name'],
                    'price' => $variant['price'],
                    'stock' => $variant['stock'],
                ],
                $variant
            );
            $variant_ids[] = $variant_id->id;
        }

        VariantType::whereNotIn('id', $variant_ids)
            ->where('products_id', $item->id)
            ->delete();

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
        // Product
        $item = Product::findOrFail($id);
        $item->delete();

        // Variant Product
        $variant = VariantType::where('products_id', $id);
        $variant->delete();

        return redirect()->route('product.index');
    }
}
