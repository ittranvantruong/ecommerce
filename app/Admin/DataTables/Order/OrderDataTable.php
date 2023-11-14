<?php

namespace App\Admin\DataTables\Order;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\Order\OrderRepositoryInterface;
use App\Enums\Order\OrderStatus;

class OrderDataTable extends BaseDataTable
{

    protected $nameTable = 'orderTable';

    public function __construct(
        OrderRepositoryInterface $repository
    ){
        $this->repository = $repository;
        
        parent::__construct();
    }

    public function setView(){
        $this->view = [
            'action' => 'admin.orders.datatable.action',
            'edit_link' => 'admin.orders.datatable.edit-link',
            'status' => 'admin.orders.datatable.status',
            'user' => 'admin.orders.datatable.user',
        ];
    }

    public function setColumnSearch(){

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
     * Get query source of dataTable.
     *
     * @param \App\Models\User $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query()
    {
        return $this->repository->getQueryBuilderWithRelations(['user']);
    }

    protected function setCustomColumns(){
        $this->customColumns = config('datatables_columns.order', []);
    }

    protected function setCustomEditColumns(){
        $this->customEditColumns = [
            'id' => $this->view['edit_link'],
            'status' => $this->view['status'],
            'total' => '{{ format_price($total) }}',
            'user' => $this->view['user'],
            'created_at' => '{{ date(config("custom.format.date"), strtotime($created_at)) }}'
        ];
    }

    protected function setCustomAddColumns(){
        $this->customAddColumns = [
            'action' => $this->view['action'],
        ];
    }

    protected function setCustomRawColumns(){
        $this->customRawColumns = ['id', 'status', 'user', 'action'];
    }
}