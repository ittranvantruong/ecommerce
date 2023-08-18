<?php

namespace App\Admin\DataTables;

use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Column;

abstract class BaseDataTable extends DataTable
{
    protected $repository;
    /**
     * ['pageLength', 'excel', 'reset', 'reload']
     *
     * @var array
     */
    protected $action = ['reset', 'reload'];
    /**
     * Mảng chứa đường dẫn tới views
     *
     * @var array
     */
    protected $view;
    /**
     * Current Object instance
     *
     * @var object|array|mixed
     */
    protected $instanceDataTable;
    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    protected $instanceHtml;
    /**
     * make columns
     *
     * @var array
     */
    protected $buildColumns = [];

    protected $customColumns = [];

    protected $removeColumns = [];

    protected $columnAllSearch = [];

    protected $columnSearchDate = [];

    protected $columnSearchSelect = [];

    protected $columnSearchSelect2 = [];

    protected $nameTable = 'tableID';
    /**
     * config search columns
     *
     * @var array
     */
    protected $parameters;


    
    public function __construct(){
        
        $this->setView();
        
        $this->setCustomColumns();
        
        $this->setParameters();
        
    }

    abstract protected function setCustomColumns();

    public function getParameters(){
        return $this->parameters ?? [
            'responsive' => true,
            'ordering' => false,
            'autoWidth' => false,
            // 'searching' => false,
            // 'searchDelay' => 350,
            // 'lengthMenu' => [ [3, 25, 50, -1], [20, 50, 100, "All"] ],
            'language' => [
                'url' => url('/public/libs/datatables/language.json')
            ]
        ];
    }

    public function getView(){
        return $this->view ?? [];
    }

    public function setParameters(){
        return $this->parameters = $this->getParameters();
    }

    public function setView(){
        $this->view = $this->getView();
    }


    protected function getColumns()
    {
        $this->exportVisiableColumns();

        foreach($this->customColumns as $key => $items){
            if(!in_array($key, $this->removeColumns)){

                $buildColumn = Column::make($key);
                foreach($items as $key => $item){
                    if($key == 'title'){
                        $buildColumn = $buildColumn->$key(__($item));
                    }else{
                        $buildColumn = $buildColumn->$key($item);
                    }
                }
                array_push($this->buildColumns, $buildColumn);
            }
        }
        return $this->buildColumns;

    }
    protected function exportVisiableColumns(){
        if ($this->request && in_array($this->request->get('action'), ['excel', 'csv'])) {
            if ($this->request->get('visible_columns')) {
                foreach ($this->customColumns as $key => $item) {
                    if (!in_array($key, $this->request->get('visible_columns'))) {
                        $this->customColumns[$key]['exportable'] = false;
                    }
                }
            }
        }
    }

    protected function htmlParameters(){
        
        $this->parameters['buttons'] = $this->actions;

        $this->parameters['initComplete'] = "function () {

            moveSearchColumnsDatatable('#{$this->nameTable}');

            searchColumsDataTable(this, ".json_encode($this->columnAllSearch).", ".json_encode($this->columnSearchDate).", ".json_encode($this->columnSearchSelect).", ".json_encode($this->columnSearchSelect2).");
        }";

        $this->instanceHtml = $this->instanceHtml
        ->parameters($this->parameters);
    }
}