<?php

use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Container\TPanelGroup;
use Adianti\Widget\Container\TVBox;
use Adianti\Widget\Datagrid\TDataGrid;
use Adianti\Widget\Datagrid\TDataGridAction;
use Adianti\Widget\Datagrid\TDataGridColumn;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Util\TXMLBreadCrumb;
use Adianti\Wrapper\BootstrapDatagridWrapper;
use Adianti\Database\TRepository;

class MonolithList extends TPage 
{
    private $datagrid;

    public function __construct()
    {
        parent::__construct();

        // Create the datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'min-width: 1900px';
        $this->datagrid->addColumn(new TDataGridColumn('idplot', '#', 'center'));
        $this->datagrid->addColumn(new TDataGridColumn('fk_catalog', 'fk catalog', 'left'));
        $this->datagrid->addColumn( new TDataGridColumn('fk_monolith_chem', 'fk monolith chem', 'left') );
        $this->datagrid->addColumn( new TDataGridColumn('monolith_code',     'monolith code',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('monolith_number_count',     'monolith number count',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('area',      'area',      'left') );
        $this->datagrid->addColumn( new TDataGridColumn('soil_depth',     'soil depth',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('soil_layer_depth',   'soil layer depth',   'left') );


        $action1 = new TDataGridAction([$this, 'onView'], ['idmonolith' => '{idmonolith}', 'fk_catalog' => '{fk_catalog}']);
        $this->datagrid->addAction($action1, 'View', 'fa:search blue');

        // Create the datagrid model
        $this->datagrid->createModel();

        $panel = new TPanelGroup(_t('Monolith List'));
        $panel->add($this->datagrid);
        $panel->addFooter('LAPS - Laboratorio de Aquisição e Processamento de Sinais');

        // Make the panel scrollable horizontally
        $panel->getBody()->style = "overflow-x:auto;";

        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', __CLASS__));
        $vbox->add($panel);

        parent::add($vbox);
    }

    public function onReload()
    {
        try {
            TTransaction::open('monolith'); // Replace 'plot' with the actual database name

            $repository = new TRepository('monolith'); // Replace 'plot' with the actual entity class name

            $monolith = $repository->load(new TCriteria); // Load all records from the database

            $this->datagrid->clear();

            foreach ($monolith as $monolith) {
                $item = new stdClass;
                $item->idmonolith = $monolith->idmonolith;
                $item->fk_catalog = $monolith->fk_catalog;
                $item->fk_monolith_chem = $monolith->fk_monolith_chem;
                $item->monolith_code = $monolith->monolith_code;
                $item->monolith_number_count = $monolith->monolith_number_count;
                $item->area = $monolith->area;
                $item->soil_depth = $monolith -> soil_depth;
                $item ->soil_layer_depth = $monolith -> soil_layer_depth;
        
                //$item -> item = $plot -> item;

                $this->datagrid->addItem($item);
            }

            TTransaction::close();
        } catch (Exception $e) {
            new TMessage('error', 'Error: ' . $e->getMessage());
            TTransaction::rollback();
        }
    }

    public static function onView($param)
    {
        $idmonolith = $param['idmonolith'];
        $monolith_code = $param['monolith_code'];
        new TMessage('info', "The code is: <br> $idmonolith </br> <br> The Monolith code is: <b>$monolith_code</b>");
    }

    public function show()
    {
        $this->onReload();
        parent::show();
    }
}
