<?php

namespace App\Admin\DataTables\ProductCategory;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\ProductCategory\ProductCategoryRepositoryInterface;

class ProductCategoryDataTable extends BaseDataTable
{

    protected $nameTable = 'productCategoryTable';

    public function __construct(
        ProductCategoryRepositoryInterface $repository
    ){
        $this->repository = $repository;
        
        parent::__construct();
    }

    public function setView(){
        $this->view = [
            'action' => 'admin.product_categories.datatable.action',
            'edit_link' => 'admin.product_categories.datatable.edit-link',
            'feature_image' => 'admin.product_categories.datatable.feature-image',
            'status' => 'admin.product_categories.datatable.status',
        ];
    }

    public function setColumnSearch(){

        $this->columnAllSearch = [0];
    }
    
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\ProductCategory $model
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function query()
    {
        $query = $this->repository->getFlatTree();
        return $query;
    }

    protected function setCustomColumns(){
        $this->customColumns = config('datatables_columns.product_categories', []);
    }

    protected function setCustomEditColumns(){
        $this->customEditColumns = [
            'name' => $this->view['edit_link'],
            'feature_image' => $this->view['feature_image'],
            'status' => $this->view['status'],
            'created_at' => '{{ date(config("custom.format.date"), strtotime($created_at)) }}'
        ];
    }

    protected function startBuilderDataTable($query){
        $this->instanceDataTable = datatables()->collection($query);
    }

    protected function setCustomAddColumns(){
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(){
        $this->customRawColumns = ['name', 'feature_image', 'status', 'action'];
    }
}