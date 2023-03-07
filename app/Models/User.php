<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'phone_number',
        'email',
        'password',
        'roles',
        'address_one',
        'address_two',
        'provinces_id',
        'regencies_id',
        'zip_code',
        'country',
        'photo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function provinces()
    {
        return $this->belongsTo(Province::class, 'provinces_id', 'id');
    }

    public function regencies()
    {
        return $this->belongsTo(Regency::class, 'regencies_id', 'id');
    }

    public function productComment()
    {
        return $this->hasMany(ProductComment::class, 'users_id', 'id');
    }

    public function wishlist()
    {
        return $this->hasMany(Wishlist::class, 'users_id', 'id');
    }

    public function chat()
    {
        return $this->hasMany(Chat::class, 'users_id', 'id');
    }
}
