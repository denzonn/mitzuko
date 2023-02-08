<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantProduct extends Model
{
    use HasFactory;

    protected $table = 'variant_product';

    // Isi name dengan warna dan ukuran
    protected $fillable = [
        'name',
    ];

    public function variantType()
    {
        return $this->hasMany(VariantType::class, 'variant_product_id', 'id');
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'variant_product_id', 'id');
    }
}
