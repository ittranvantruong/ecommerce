<?php

namespace App\Admin\DataTables\Order;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Admin\Traits\GetConfig;
use App\Enums\Order\OrderStatus;

class OrderDataTable extends BaseDataTable
{

    use GetConfig;
    /**
     * Available button actions. When calling an action, the value will be used
     * as the function name (so it should be available)
     * If you want to add or disable an action, overload and modify this property.
     *
     * @var array
     */
    // protected array $actions = ['pageLength', 'excel', 'reset', 'reload'];
    protected array $actions = ['reset', 'reload'];

    public function __construct(
        OrderRepositoryInterface $repository
    ){
        parent::__construct();

        $this->repository = $repository;

        $this->nameTable = 'orderTable';

        $this->configColumnSearch();
    }

    public function getView(){
        return [
            'action' => 'admin.orders.datatable.action',
            'edit_link' => 'admin.orders.datatable.edit-link',
            'status' => 'admin.orders.datatable.status',
            'user' => 'admin.orders.datatable.user',
        ];
    }

    public function configColumnSearch(){

        $this->columnAllSearch = [0, 1, 2, 4];

        $this->columnSearchDate = [4];
        
        $this->columnSearchSelect = [
            [
                'column' => 2,
                'data' => OrderStatus::asSelectArray()
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
        $this->editColumnId();
        $this->editColumnTotal();
        $this->editColumnStatus();
        $this->editColumnUser();
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
        return $this->repository->getQueryBuilderWithRelations();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        $this->instanceHtml = $this->builder()
        ->setTableId($this->nameTable)
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->dom('Bfrtip')
        ->orderBy(0)
        ->selectStyleSingle();

        $this->htmlParameters();

        return $this->instanceHtml;
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function setCustomColumns(){
        $this->customColumns = $this->traitGetConfigDatatableColumns('order');
    }

    protected function filename(): string
    {
        return 'order_' . date('YmdHis');
    }

    protected function editColumnId(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('id', $this->view['edit_link']);
    }
    protected function editColumnStatus(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('status', $this->view['status']);
    }
    protected function editColumnTotal(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('total', '{{ format_price($total) }}');
    }
    protected function editColumnUser(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('user', $this->view['user']);
    }
    protected function editColumnCreatedAt(){
        $this->instanceDataTable = $this->instanceDataTable->editColumn('created_at', '{{ date("d-m-Y", strtotime($created_at)) }}');
    }
    protected function addColumnAction(){
        $this->instanceDataTable = $this->instanceDataTable->addColumn('action', $this->view['action']);
    }
    protected function rawColumnsNew(){
        $this->instanceDataTable = $this->instanceDataTable->rawColumns(['id', 'status', 'user', 'action']);
    }
}