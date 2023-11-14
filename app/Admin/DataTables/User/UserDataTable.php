<?php

namespace App\Admin\DataTables\User;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Enums\User\UserGender;

class UserDataTable extends BaseDataTable
{

    protected $nameTable = 'userTable';

    public function __construct(
        UserRepositoryInterface $repository
    ){
        $this->repository = $repository;
        
        parent::__construct();
    }

    public function setView(){
        $this->view = [
            'action' => 'admin.users.datatable.action',
            'edit_link' => 'admin.users.datatable.edit-link',
        ];
    }

    public function setColumnSearch(){

        $this->columnAllSearch = [0, 1, 2, 3, 4, 5];

        $this->columnSearchDate = [5];
        
        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => UserGender::asSelectArray()
            ]
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
        $this->customColumns = config('datatables_columns.user', []);
    }

    protected function setCustomEditColumns(){
        $this->customEditColumns = [
            'fullname' => $this->view['edit_link'],
            'gender' => function($user){
                return $user->gender->description();
            },
            'created_at' => '{{ date(config("custom.format.date"), strtotime($created_at)) }}'
        ];
    }

    protected function setCustomAddColumns(){
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(){
        $this->customRawColumns = ['fullname', 'action'];
    }
}