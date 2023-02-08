<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VariantType extends Model
{
    use HasFactory;

    protected $table = 'variant_type';

    protected $fillable = [
        'products_id',
        'variant_product_id',
        'name',
        'price',
        'stock',
    ];

    public function variantProduct()
    {
        return $this->belongsTo(VariantProduct::class, 'variant_product_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'products_id', 'id');
    }

    public function cart()
    {
        return $this->hasMany(Cart::class, 'variant_type_id', 'id');
    }

    public function transactionDetail()
    {
        return $this->hasMany(TransactionDetail::class, 'variant_type_id', 'id');
    }

    public function productComment()
    {
        return $this->hasMany(ProductComment::class, 'variant_type_id', 'id');
    }
}
