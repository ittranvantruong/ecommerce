<?php

namespace App\Api\V1\Repositories\ProductCategory;

use App\Admin\Repositories\ProductCategory\ProductCategoryRepository as AdminProductCategoryRepository;
use App\Api\V1\Repositories\ProductCategory\ProductCategoryRepositoryInterface;

class ProductCategoryRepository extends AdminProductCategoryRepository implements ProductCategoryRepositoryInterface
{
    public function getTree(){
        $this->instance = $this->model->published()->orderBy('position', 'ASC')->get()->toTree();
        return $this->instance;
    }
    public function findByIdOrSlug($idOrSlug){
        $this->instance = $this->model->whereIdOrSlug($idOrSlug)->firstOrFail();
        return $this->instance;
    }
    public function findByIdOrSlugWithAncestorsAndDescendants($idOrSlug){
        $this->findByIdOrSlug($idOrSlug);

        $this->instance = $this->instance->load([
            'ancestors' => function($query) {
                $query->defaultOrder();
            },
            'descendants'
        ]);
        return $this->instance;

    }

    public function getRootWithAllChildren(){
        $this->instance = $this->model->active()
        ->whereNull('parent_id')
        ->with(['descendants'])
        ->OrderBy('position', 'ASC')
        ->get();
        return $this->instance;
    }
}