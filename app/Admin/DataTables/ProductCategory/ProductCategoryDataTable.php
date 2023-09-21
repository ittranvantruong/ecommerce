<?php

namespace App\Admin\DataTables\ProductCategory;

use App\Admin\DataTables\BaseDataTable;
use App\Admin\Repositories\ProductCategory\ProductCategoryRepositoryInterface;
use App\Admin\Traits\GetConfig;

class ProductCategoryDataTable extends BaseDataTable
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
        ProductCategoryRepositoryInterface $repository
    ){
        parent::__construct();

        $this->repository = $repository;

        $this->nameTable = 'productCategoryTable';

        $this->configColumnSearch();
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
        $query = $this->filterIsActive($query);
        return $query;
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
        $this->customColumns = $this->traitGetConfigDatatableColumns('product_categories');
    }

    protected function filename(): string
    {
        return 'Category_' . date('YmdHis');
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