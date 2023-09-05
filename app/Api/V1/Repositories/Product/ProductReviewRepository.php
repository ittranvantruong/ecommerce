<?php

namespace App\Api\V1\Repositories\Product;

use App\Admin\Repositories\EloquentRepository;
use App\Api\V1\Repositories\Product\ProductReviewRepositoryInterface;
use App\Models\ProductReview;

class ProductReviewRepository extends EloquentRepository implements ProductReviewRepositoryInterface
{
    public function getModel(){
        return ProductReview::class;
    }

    public function getByProductId($product_id){
        $this->instance = $this->model->where('product_id', $product_id)
        ->with('user')
        ->get();
        return $this->instance;
    }
    public function createAuthCurrent($data){
        $this->instance = auth('sanctum')->user()->productReviews()->create($data);
        return $this->instance;
    }
}