<?php

namespace App\Models;

use App\Enums\Product\ProductInstock;
use App\Enums\Product\ProductStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Support\Eloquent\Sluggable;
use Illuminate\Database\Eloquent\Casts\AsArrayObject;

class Product extends Model
{
    use HasFactory, Sluggable;

    protected $table = 'products';
    protected $guarded = [];

    protected $casts = [
        'status' => ProductStatus::class,
        'in_stock' => ProductInstock::class,
        'gallery' => AsArrayObject::class
    ];

    public function categories(){
        return $this->belongsToMany(ProductCategory::class, 'product_categories_products', 'product_id', 'category_id')->orderBy('position', 'asc');
    }

    public function purchaseQty(){
        return $this->hasMany(ProductPurchaseQty::class, 'product_id', 'id');
    }
    public function scopePublished($query){
        return $query->where('status', ProductStatus::Published);
    }
    public function scopeStocking($query){
        return $query->where('in_stock', ProductInstock::Yes);
    }
}
