<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;
use App\Models\RecomendationCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        return view('pages.admin.category.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $data = $request->all();

        $data['slug'] = \Str::slug($request->name);


        if ($request->hasFile('photo')) {
            $images = $request->file('photo');

            $extension = $images->getClientOriginalExtension();

            $random = \Str::random(10);
            $file_name = "category" . $random . "." . $extension;

            $images->storeAs('public/assets/category', $file_name);
            $data['photo'] = 'public/assets/category' . '/' . $file_name;
        }

        $category = Category::create($data);

        RecomendationCategory::create([
            'categories_id' => $category->id,
            'recomendation_one' => 1,
            'recomendation_two' => 1,
        ]);

        return redirect()->route('category.index');
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
        $item = Category::findOrFail($id);
        $categories = Category::all();

        // // Ambil id dari masing-masing rekomendasi
        $recomendation_one = RecomendationCategory::where('categories_id', $item->id)->first()->recomendation_one;
        $recomendation_two = RecomendationCategory::where('categories_id', $item->id)->first()->recomendation_two;

        // // Cari Nama Dari masing-masing rekomendasi
        $category_one = Category::find($recomendation_one);
        $category_two = Category::find($recomendation_two);

        return view('pages.admin.category.edit', [
            'item' => $item,
            'categories' => $categories,
            'category_one' => $category_one,
            'category_two' => $category_two
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function update(CategoryRequest $request, $id)
    {
        $data = $request->all();

        $data['slug'] = \Str::slug($request->name);

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store(
                'assets/category',
                'public'
            );
        }

        $item = Category::findOrFail($id);
        $item->update($data);

        $recomendation_1 = $request->input('recomendation1');
        $recomendation_2 = $request->input('recomendation2');

        $recomendation = RecomendationCategory::where('categories_id', $item->id)->first();

        if ($recomendation) {
            $recomendation->update([
                'recomendation_one' => $recomendation_1,
                'recomendation_two' => $recomendation_2,
            ]);
        } else {
            RecomendationCategory::create([
                'categories_id' => $item->id,
                'recomendation_one' => $recomendation_1,
                'recomendation_two' => $recomendation_2,
            ]);
        }

        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Category::findOrFail($id);
        $item->delete();

        return redirect()->route('category.index');
    }
}
