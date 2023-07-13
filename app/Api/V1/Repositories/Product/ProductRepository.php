<?php

namespace App\Api\V1\Repositories\Product;
use App\Admin\Repositories\Product\ProductRepository as AdminProductRepository;
use App\Api\V1\Repositories\Product\ProductRepositoryInterface;

class ProductRepository extends AdminProductRepository implements ProductRepositoryInterface
{
    public function getSearchByKeysWithRelations(array $data, array $relations = []){
        $this->instance = $this->model->published();
        if(isset($data['keywords'])){
            $this->instance = $this->instance->where('name', 'like', "%{$data['keywords']}%");    
        }
        if(!empty($relations)){
            $this->instance = $this->instance->with($relations);    
        }
        $this->instance = $this->instance->orderBy('id', 'desc')->get();
        return $this->instance;
    }
    
    public function getByCategoriesWithRelations(array $categories_id = [], array $relations = []){
        $this->instance = $this->model->published()
        ->whereHas('categories', function($query) use ($categories_id){
            $query->whereIn('id', $categories_id);
        });
        if(!empty($relations)){
            $this->instance = $this->instance->with($relations);
        }
        $this->instance = $this->instance->orderBy('id', 'desc')
        ->get();
        return $this->instance;
    }

    public function findOrFailWithRelations($id, array $relations = []){
        $this->findByPublishedOrFail($id);
        if(!empty($relations)){
            $this->instance = $this->instance->load($relations);
        }
        return $this->instance;
    }

    public function findByPublishedOrFail($id){
        $this->instance = $this->model->where('id', $id)
        ->published()
        ->firstOrFail();
        
        return $this->instance;
    }
}