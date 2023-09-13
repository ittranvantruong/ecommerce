<?php

namespace App\Models;

use App\Enums\Order\OrderPaymentMethod;
use App\Enums\Order\OrderShippingMethod;
use App\Enums\Order\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $guarded = [];

    protected $casts = [
        'status' => OrderStatus::class,
        'payment_method' => OrderPaymentMethod::class,
        'shipping_method' => OrderShippingMethod::class,
    ];

    public function isCompleted(){
        return $this->status == OrderStatus::Completed;
    }

    public function details(){
        return $this->hasMany(OrderDetail::class, 'order_id', 'id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function scopeCurrentAuth($query){
        return $query->where('user_id', auth()->user()->id);
    }
}
