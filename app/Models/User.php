<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Enums\User\{UserStatus, UserGender};

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'code',
        'slug',
        'username',
        'fullname',
        'email',
        'phone',
        'birthday',
        'gender',
        'avatar',
        'address',
        'token_get_password',
        'password',
        'status'
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
        'gender' => UserGender::class,
        'status' => UserStatus::class
    ];

    public function orders(){
        return $this->hasMany(Order::class, 'user_id', 'id');
    }

    public function productWishlist(){
        return $this->belongsToMany(Product::class, 'product_wishlists', 'user_id', 'product_id');
    }

    public function productReviews(){
        return $this->hasMany(Review::class, 'user_id', 'id');
    }
}
