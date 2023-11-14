<?php

namespace App\Admin\DataTables\Product;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Product\ProductRepositoryInterface;
use App\Admin\Repositories\ProductCategory\ProductCategoryRepositoryInterface;
use App\Enums\Product\ProductInstock;
use App\Enums\Product\ProductStatus;

class ProductDataTable extends BaseDataTable
{


    protected $repositoryCat;
    
    protected $nameTable = 'productTable';

    public function __construct(
        ProductRepositoryInterface $repository,
        ProductCategoryRepositoryInterface $repositoryCat
    ){
        $this->repository = $repository;
        
        $this->repositoryCat = $repositoryCat;
        
        parent::__construct();

    }

    public function setView(){
        $this->view = [
            'action' => 'admin.products.datatable.action',
            'edit_link' => 'admin.products.datatable.edit-link',
            'in_stock' => 'admin.products.datatable.in-stock',
            'status' => 'admin.products.datatable.status',
            'feature_image' => 'admin.products.datatable.feature-image',
            'price' => 'admin.products.datatable.price',
            'categories' => 'admin.products.datatable.categories',
            'checkbox' => 'admin.products.datatable.checkbox'
        ];
    }

    public function setColumnSearch(){

        $this->columnAllSearch = [2, 3, 4, 6, 8];

        $this->columnSearchDate = [8];
        
        $this->columnSearchSelect = [
            [
                'column' => 3,
                'data' => ProductInstock::asSelectArray()
            ],
            [
                'column' => 4,
                'data' => ProductStatus::asSelectArray()
            ]
        ];
        $this->columnSearchSelect2 = [
            [
                'column' => 6,
                'data' => $this->repositoryCat->getFlatTree()->map(function($category){
                    return [$category->id => generate_text_depth_tree($category->depth).$category->name];
                })
            ]
        ];
    }
    
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Product $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->repository->getQueryBuilderHasPermissionWithRelations(['categories']);
    }

    protected function setCustomColumns(){
        $this->customColumns = config('datatables_columns.product', []);
    }

    protected function setCustomEditColumns(){
        $this->customEditColumns = [
            'name' => $this->view['edit_link'],
            'feature_image' => $this->view['feature_image'],
            'in_stock' => $this->view['in_stock'],
            'price' => $this->view['price'],
            'status' => $this->view['status'],
            'categories' => $this->view['categories'],
            'created_at' => '{{ date(config("custom.format.date"), strtotime($created_at)) }}'
        ];
    }

    protected function setCustomAddColumns(){
        $this->customAddColumns = [
            'checkbox' => $this->view['checkbox'],
            'action' => $this->view['action']
        ];
    }

    protected function setCustomFilterColumns()
    {
        $this->customFilterColumns = [
            'created_at' => function($query, $keyword) {
                $query->whereDate('created_at', date('Y-m-d', strtotime($keyword)));
            }
        ];
    }

    protected function setCustomRawColumns(){
        $this->customRawColumns = ['checkbox', 'feature_image', 'name', 'in_stock', 'status', 'categories', 'price', 'action'];
    }

    protected function filterColumnCategories(){
        $this->instanceDataTable = $this->instanceDataTable->filterColumn('categories', function($query, $keyword) {
            $keyword = explode(',', $keyword);
            $query->whereHas('categories', function($query) use ($keyword){
                $query->whereIn('id', $keyword);
            });

        });
    }
}