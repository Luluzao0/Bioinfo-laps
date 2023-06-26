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

class PlotList extends TPage 
{
    private $datagrid;

    public function __construct()
    {
        parent::__construct();

        // Create the datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'min-width: 1900px';
        $this->datagrid->addColumn(new TDataGridColumn('idplot', '#', 'center'));
        $this->datagrid->addColumn(new TDataGridColumn('station_field_number', 'Station Field Number', 'left'));
        $this->datagrid->addColumn( new TDataGridColumn('fk_environments', 'Environments', 'left') );
        $this->datagrid->addColumn( new TDataGridColumn('fk_chem_comp',     'Chem Comp',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('fk_sampling_history',     'Sampling History',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('fk_land_user_history',      'Land User History',      'left') );
        $this->datagrid->addColumn( new TDataGridColumn('fk_carbon',     'Carbon',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('land_ower',   'Land Ower',   'left') );
        $this->datagrid->addColumn( new TDataGridColumn('name',      'Name',      'center') );
        $this->datagrid->addColumn( new TDataGridColumn('county',      'County',      'left') );
        $this->datagrid->addColumn( new TDataGridColumn('state', 'State', 'left') );
        $this->datagrid->addColumn( new TDataGridColumn('country',     'Country',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('continent',     'Continent',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('conservation_unit_class',      'Conservation Unit class',      'left') );
        $this->datagrid->addColumn( new TDataGridColumn('conservation_unit_name',     'Conservation Unit name',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('previous_land_use',   'Preivous Land Use',   'left') );
        $this->datagrid->addColumn( new TDataGridColumn('lat',      'Lat',      'center') );
        $this->datagrid->addColumn( new TDataGridColumn('log',      'Log',      'left') );
        $this->datagrid->addColumn( new TDataGridColumn('relief', 'Relief', 'left') );
        $this->datagrid->addColumn( new TDataGridColumn('topography',     'Topography',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('soil_order',     'Soil Order',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('soil_suborder',     'Soil Suborder',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('bioma',     'Bioma',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('vegetation_physignomia',     'Vegetation Physignomia',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('vegetation_age',     'Vegetation Age',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('land_use',     'Land Use',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('dem',     'Dem',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('hand',     'Hand',     'left') );

        $action1 = new TDataGridAction([$this, 'onView'], ['idplot' => '{idplot}', 'station_field_number' => '{station_field_number}']);
        $this->datagrid->addAction($action1, 'View', 'fa:search blue');

        // Create the datagrid model
        $this->datagrid->createModel();

        $panel = new TPanelGroup(_t('Plot List'));
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
            TTransaction::open('plot'); // Replace 'plot' with the actual database name

            $repository = new TRepository('plot'); // Replace 'plot' with the actual entity class name

            $plots = $repository->load(new TCriteria); // Load all records from the database

            $this->datagrid->clear();

            foreach ($plots as $plot) {
                $item = new stdClass;
                $item->idplot = $plot->idplot;
                $item->station_field_number = $plot->station_field_number;
                $item->fk_environments = $plot->fk_environments;
                $item->fk_chem_comp = $plot->fk_chem_comp;
                $item->fk_sampling_history = $plot->fk_sampling_history;
                $item->fk_land_user_history = $plot->fk_land_user_history;
                $item->fk_carbon = $plot -> fk_carbon;
                $item ->land_ower = $plot -> land_ower;
                $item ->name = $plot -> name;
                $item -> county = $plot -> county;
                $item -> state = $plot -> state;
                $item -> country = $plot -> country;
                $item -> continent = $plot -> continent;
                $item -> conservation_unit_class = $plot -> conservation_unit_class;
                $item -> conservation_unit_name = $plot -> conservation_unit_name;
                $item -> previous_land_use = $plot -> previous_land_use;
                $item -> lat = $plot -> lat;
                $item -> log = $plot -> log;
                $item -> relief = $plot -> relief;
                $item -> topography = $plot -> topography;
                $item -> soil_order = $plot -> soil_order;
                $item -> soil_suborder = $plot -> soil_suborder;
                $item -> bioma = $plot -> bioma;
                $item -> vegetation_physignomia = $plot -> vegetation_physignomia;
                $item -> vegetation_age = $plot -> vegetation_age;
                $item -> land_use = $plot -> land_use;
                $item -> dem = $plot -> dem;
                //$item -> item = $plot -> item;
                $item -> hand = $plot -> hand;

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
        $idplot = $param['idplot'];
        $station_field_number = $param['station_field_number'];
        new TMessage('info', "The code is: <br> $idplot </br> <br> The Station Field Number is: <b>$station_field_number</b>");
    }

    public function show()
    {
        $this->onReload();
        parent::show();
    }
}
