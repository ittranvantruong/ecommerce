<?php

namespace App\Admin\DataTables\Post;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Post\PostRepositoryInterface;
use App\Enums\Post\PostStatus;

class PostDataTable extends BaseDataTable
{

    protected $nameTable = 'postTable';

    public function __construct(
        PostRepositoryInterface $repository
    ){
        $this->repository = $repository;
        
        parent::__construct();

        

    }

    public function setView(){
        $this->view = [
            'action' => 'admin.posts.datatable.action',
            'feature_image' => 'admin.posts.datatable.feature-image',
            'edit_link' => 'admin.posts.datatable.edit-link',
            'status' => 'admin.posts.datatable.status',
        ];
    }

    public function setColumnSearch(){

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
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->repository->getQueryBuilderOrderBy();
    }

    protected function setCustomColumns(){
        $this->customColumns = config('datatables_columns.post', []);
    }

    protected function setCustomEditColumns(){
        $this->customEditColumns = [
            'feature_image' => $this->view['feature_image'],
            'title' => $this->view['edit_link'],
            'status' => $this->view['status'],
            'created_at' => '{{ date(config("custom.format.date"), strtotime($created_at)) }}'
        ];
    }

    protected function setCustomAddColumns(){
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(){
        $this->customRawColumns = ['feature_image', 'title', 'status', 'action'];
    }
}