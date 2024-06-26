<?php

namespace App\Admin\Repositories\Product;
use App\Admin\Repositories\EloquentRepositoryInterface;
use App\Models\Product;

interface ProductRepositoryInterface extends EloquentRepositoryInterface
{
    public function updateMultipleByIds(array $ids, array $data);

    public function updateWithAllRelations(array $product, array $categories_id = []);
    
    public function createWithAllRelations(array $product, array $categories_id = []);

    public function getByIdsAndOrderByIds(array $ids);
    public function getByColumnsWithRelationsLimit(array $data, array $relations = [], $limit = 10);

    public function getAllByColumns(array $data);

    public function loadRelations(Product $product, array $relations = []);

    public function attachCategories(Product $product, array $categoriesId);

    public function syncCategories(Product $product, array $categoriesId);
	
    public function getQueryBuilderHasPermissionWithRelations($relations = []);

    public function getQueryBuilderWithRelations($relations = []);

    public function getQueryBuilderOrderBy($column = 'id', $sort = 'DESC');

}