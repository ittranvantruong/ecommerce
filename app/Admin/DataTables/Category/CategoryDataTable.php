<?php

namespace App\Admin\DataTables\Category;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Enums\Category\CategoryStatus;

class CategoryDataTable extends BaseDataTable
{

    use GetConfig;

    public function __construct(
        CategoryRepositoryInterface $repository
    ){
        $this->repository = $repository;
        
        parent::__construct();

        $this->nameTable = 'categoryTable';

    }

    public function getView(){
        return [
            'action' => 'admin.categories.datatable.action',
            'edit_link' => 'admin.categories.datatable.edit-link',
            'status' => 'admin.categories.datatable.status',
        ];
    }

    public function configColumnSearch(){

        $this->columnAllSearch = [0, 1];
        
        $this->columnSearchSelect = [
            [
                'column' => 1,
                'data' => CategoryStatus::asSelectArray()
            ],
        ];
    }
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->instanceDataTable = datatables()->collection($query);
        $this->editColumnName();
        $this->editColumnStatus();
        $this->editColumnCreatedAt();
        $this->addColumnAction();
        $this->rawColumnsNew();
        return $this->instanceDataTable;
    }
    
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\PostCategory $model
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
        $this->customColumns = $this->traitGetConfigDatatableColumns('category');
    }
    
    protected function editColumnName(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('name', $this->view['edit_link']);
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
        $this->instanceDataTable = $this->instanceDataTable->rawColumns(['name', 'status', 'action']);
    }
}