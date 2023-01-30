<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'brand',
        'categories_id',
        'price',
        'stock',
        'description',
        'slug',
    ];

    protected $hidden = [];

    // Relasi ke table product gallery
    public function galleries()
    {
        return $this->hasMany(ProductGallery::class, 'products_id', 'id');
    }

    // Relasi ke table categories
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id', 'id');
    }

    //Query scope pencarian
    public function scopeFilter($query)
    {
        $searchKeyword = request('search');

        if (request('search')) {
            return $query = $query->where('name', 'like', '%' . $searchKeyword . '%')
                ->orWhere('description', 'like', '%' . $searchKeyword . '%');
        }
    }

    // public function scopeCheapest($query, $search)
    // {
    //     return $query->where('name', 'like', '%' . $search . '%')
    //         ->orderBy('price', 'asc')
    //         ->get();
    // }

    // public function scopeMostExpensive($query, $search)
    // {
    //     return $query->where('name', 'like', '%' . $search . '%')
    //         ->orderBy('price', 'desc')
    //         ->get();
    // }
}
