<?php

namespace App\Admin\DataTables\User;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\User\UserRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Enums\User\UserGender;

class UserDataTable extends BaseDataTable
{

    use GetConfig;

    public function __construct(
        UserRepositoryInterface $repository
    ){
        $this->repository = $repository;
        
        parent::__construct();

        $this->nameTable = 'userTable';
        
    }

    public function getView(){
        return [
            'action' => 'admin.users.datatable.action',
            'edit_link' => 'admin.users.datatable.edit-link'
        ];
    }

    public function configColumnSearch(){

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
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        $this->instanceDataTable = datatables()->eloquent($query);
        $this->filterColumnCreatedAt();
        $this->filterColumnGender();
        $this->editColumnFullname();
        $this->editColumnGender();
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
        $this->customColumns = $this->traitGetConfigDatatableColumns('user');
    }

    protected function filterColumnGender(){
        $this->instanceDataTable = $this->instanceDataTable
        ->filterColumn('gender', function($query, $keyword) {
            $query->where('gender', $keyword);
        });
    }
    protected function filterColumnCreatedAt(){
        $this->instanceDataTable = $this->instanceDataTable->filterColumn('created_at', function($query, $keyword) {

            $query->whereDate('created_at', date('Y-m-d', strtotime($keyword)));

        });
    }
    protected function editColumnId(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('id', $this->view['edit_link']);
    }
    protected function editColumnFullname(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('fullname', $this->view['edit_link']);
    }
    protected function editColumnGender(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('gender', function($admin){
            return $admin->gender->description();
        });
    }
    protected function editColumnCreatedAt(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('created_at', '{{ date("d-m-Y", strtotime($created_at)) }}');
    }
    protected function addColumnAction(){
        $this->instanceDataTable = $this->instanceDataTable->addColumn('action', $this->view['action']);
    }
    protected function rawColumnsNew(){
        $this->instanceDataTable = $this->instanceDataTable->rawColumns(['fullname', 'action']);
    }
}