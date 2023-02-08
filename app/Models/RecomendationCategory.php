<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecomendationCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'categories_id',
        'recomendation_one',
        'recomendation_two'
    ];

    protected $hidden = [];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
