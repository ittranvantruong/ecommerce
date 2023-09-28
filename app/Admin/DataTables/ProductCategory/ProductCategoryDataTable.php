<?php

namespace App\Admin\DataTables\ProductCategory;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\ProductCategory\ProductCategoryRepositoryInterface;
use App\Admin\Traits\GetConfig;

class ProductCategoryDataTable extends BaseDataTable
{

    use GetConfig;

    public function __construct(
        ProductCategoryRepositoryInterface $repository
    ){
        $this->repository = $repository;
        
        parent::__construct();

        $this->nameTable = 'productCategoryTable';

    }

    public function getView(){
        return [
            'action' => 'admin.product_categories.datatable.action',
            'edit_link' => 'admin.product_categories.datatable.edit-link',
            'feature_image' => 'admin.product_categories.datatable.feature-image',
            'status' => 'admin.product_categories.datatable.status',
        ];
    }

    public function configColumnSearch(){

        $this->columnAllSearch = [0];
    }
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        // dd($query);
        $this->instanceDataTable = datatables()->collection($query);
        // $this->filterColumnCreatedAt();
        $this->editColumnName();
        $this->editColumnCreatedAt();
        $this->editColumnFeatureImage();
        $this->editColumnStatus();
        $this->addColumnAction();
        $this->rawColumnsNew();
        return $this->instanceDataTable;
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

    /**
     * Get columns.
     *
     * @return array
     */
    protected function setCustomColumns(){
        $this->customColumns = $this->traitGetConfigDatatableColumns('product_categories');
    }

    protected function filterIsActive($query){
        $value = request('columns.2.search.value');
        if ($value !== null){
            $query = $query->where('is_active', 0);
        }
        return $query;
    }
    
    protected function editColumnId(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('id', $this->view['edit_link']);
    }

    protected function editColumnName(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('name', $this->view['edit_link']);
    }

    protected function editColumnFeatureImage(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('feature_image', $this->view['feature_image']);
    }

    protected function editColumnStatus(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('status', $this->view['status']);
    }

    protected function editColumnCreatedAt(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('created_at', '{{ date("d-m-Y", strtotime($created_at)) }}');
    }

    protected function addColumnAction(){
        $this->instanceDataTable = $this->instanceDataTable->addColumn('action', $this->view['action']);
    }
    protected function rawColumnsNew(){
        $this->instanceDataTable = $this->instanceDataTable->rawColumns(['name', 'feature_image', 'status', 'action']);
    }
}