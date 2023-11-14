<?php

namespace App\Admin\DataTables\Category;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Category\CategoryRepositoryInterface;
use App\Enums\Category\CategoryStatus;

class CategoryDataTable extends BaseDataTable
{

    protected $nameTable = 'categoryTable';

    public function __construct(
        CategoryRepositoryInterface $repository
    ){
        $this->repository = $repository;
        
        parent::__construct();
    }

    public function setView(){
        $this->view = [
            'action' => 'admin.categories.datatable.action',
            'edit_link' => 'admin.categories.datatable.edit-link',
            'status' => 'admin.categories.datatable.status',
        ];
    }

    public function setColumnSearch(){

        $this->columnAllSearch = [0];
        
        // $this->columnSearchSelect = [
        //     [
        //         'column' => 1,
        //         'data' => CategoryStatus::asSelectArray()
        //     ],
        // ];
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

    protected function setCustomColumns(){
        $this->customColumns = config('datatables_columns.category', []);
    }

    protected function setCustomEditColumns(){
        $this->customEditColumns = [
            'name' => $this->view['edit_link'],
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
        $this->customRawColumns = ['name', 'status', 'action'];
    }
}