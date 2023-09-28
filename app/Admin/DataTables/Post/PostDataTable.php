<?php

namespace App\Admin\DataTables\Post;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Post\PostRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Enums\Post\PostStatus;

class PostDataTable extends BaseDataTable
{

    use GetConfig;

    public function __construct(
        PostRepositoryInterface $repository
    ){
        $this->repository = $repository;
        
        parent::__construct();

        $this->nameTable = 'postTable';
    }

    public function getView(){
        return [
            'action' => 'admin.posts.datatable.action',
            'feature_image' => 'admin.posts.datatable.feature-image',
            'edit_link' => 'admin.posts.datatable.edit-link',
            'status' => 'admin.posts.datatable.status',
        ];
    }

    public function configColumnSearch(){

        $this->columnAllSearch = [1, 2, 3];

        $this->columnSearchDate = [3];
        
        $this->columnSearchSelect = [
            [
                'column' => 2,
                'data' => PostStatus::asSelectArray()
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
        $this->instanceDataTable = datatables()->eloquent($query);
        $this->filterColumnCreatedAt();
        $this->editColumnImage();
        $this->editColumnTitle();
        $this->editColumnStatus();
        $this->editColumnCreatedAt();
        $this->addColumnAction();
        $this->rawColumnsNew();
        return $this->instanceDataTable;
    }
    
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function setCustomColumns(){
        $this->customColumns = $this->traitGetConfigDatatableColumns('post');
    }

    protected function filterColumnCreatedAt(){
        $this->instanceDataTable = $this->instanceDataTable->filterColumn('created_at', function($query, $keyword) {

            $query->whereDate('created_at', date('Y-m-d', strtotime($keyword)));

        });
    }
    protected function editColumnImage(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('feature_image', $this->view['feature_image']);
    }
    protected function editColumnTitle(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('title', $this->view['edit_link']);
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
        $this->instanceDataTable = $this->instanceDataTable->rawColumns(['feature_image', 'title', 'status', 'action']);
    }
}