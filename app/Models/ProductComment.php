<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductComment extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',
        'variant_type_id',
        'products_id',
        'comment',
        'rating',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function variant()
    {
        return $this->belongsTo(VariantType::class, 'variant_type_id', 'id');
    }
}
