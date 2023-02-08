<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'products_id', 'variant_type_id', 'transactions_id', 'price', 'quantity', 'resi', 'shipping_status'
    ];

    protected $hidden = [];

    public function product()
    {
        return $this->hasOne(Product::class, 'id', 'products_id');
    }

    public function transaction()
    {
        return $this->hasOne(Transaction::class, 'id', 'transactions_id');
    }

    public function variant_type()
    {
        return $this->hasOne(VariantType::class, 'id', 'variant_type_id');
    }
}
