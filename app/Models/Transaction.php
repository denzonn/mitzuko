<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'users_id',  'code', 'users_id',  'total', 'ongkir', 'transaction_status', 'shipping_status', 'snap_token'
    ];

    protected $hidden = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }

    public function transaction_details()
    {
        return $this->hasMany(TransactionDetail::class, 'transactions_id', 'id');
    }
}
