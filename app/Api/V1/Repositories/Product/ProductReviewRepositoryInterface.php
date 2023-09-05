<?php

namespace App\Api\V1\Repositories\Product;

use App\Admin\Repositories\EloquentRepositoryInterface;

interface ProductReviewRepositoryInterface extends EloquentRepositoryInterface
{
    public function getByProductId($product_id);
    public function createAuthCurrent($data);
}