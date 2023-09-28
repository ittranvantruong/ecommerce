<?php

namespace App\Admin\DataTables\Admin;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Admin\AdminRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Enums\Admin\AdminRoles;

class AdminDataTable extends BaseDataTable
{

    use GetConfig;

    public function __construct(
        AdminRepositoryInterface $repository
    ){
        $this->repository = $repository;
        
        parent::__construct();

        $this->nameTable = 'adminTable';
        
    }

    public function getView(){
        return [
            'action' => 'admin.admins.datatable.action',
            'edit-link' => 'admin.admins.datatable.edit-link',
        ];
    }

    public function configColumnSearch(){

        $this->columnAllSearch = [1, 2, 3, 4, 5];
        $this->columnSearchDate = [5]; 
        
        $this->columnSearchSelect = [
            [
                'column' => 4,
                'data' => auth('admin')->user()->roles->asArraySelectListRolesAdminAfterCase()
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
        $this->instanceDataTable = datatables()->eloquent($query)->addIndexColumn();
        $this->filterColumnCreatedAt();
        $this->filterColumnRoles();
        $this->editColumnFullname();
        $this->editColumnRoles();
        $this->editColumnCreatedAt();
        $this->addColumnAction();
        $this->rawColumnsNew();
        return $this->instanceDataTable;
    }
    
    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Admin $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->repository->getQueryBuilderFollowRole();
    }
    /**
     * Get columns.
     *
     * @return array
     */
    protected function setCustomColumns(){
        $this->customColumns = $this->traitGetConfigDatatableColumns('admin');
    }

    protected function filterColumnRoles(){
        $this->instanceDataTable = $this->instanceDataTable
        ->filterColumn('roles', function($query, $keyword) {
            $query->where('roles', $keyword);
        });
    }
    protected function filterColumnCreatedAt(){
        $this->instanceDataTable = $this->instanceDataTable->filterColumn('created_at', function($query, $keyword) {

            $query->whereDate('created_at', date('Y-m-d', strtotime($keyword)));

        });
    }
    protected function editColumnId(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('id', $this->view['edit-link']);
    }
    protected function editColumnFullname(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('fullname', $this->view['edit-link']);
    }
    protected function editColumnRoles(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('roles', function($admin){
            return $admin->roles->description();
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