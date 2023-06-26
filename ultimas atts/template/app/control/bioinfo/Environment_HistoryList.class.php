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



class Environment_HistoryList extends TPage 
{
    private $datagrid;

    public function __construct()
    {
        parent::__construct();

        // Criar o datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'min-width: 1900px';

        $this->datagrid->addColumn(new TDataGridColumn('idEnvironment_History', '#', 'center'));
        $this->datagrid->addColumn(new TDataGridColumn('clima_koppen', 'clima koppen', 'left'));
        $this->datagrid->addColumn( new TDataGridColumn('preciptation_month_mean_WC', 'preciptation month mean WC', 'left') );
        $this->datagrid->addColumn( new TDataGridColumn('preciptation_anual_mean_WC',     'preciptation anual mean WC',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('temperature_month_mean_WC',     'temperature month mean WC',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('temperature_annual_mean_WC',     'temperature annual mean WC',     'left') );
        
        
        $action1 = new TDataGridAction([$this, 'onView'], ['idEnvironment_History' => '{idEnvironment_History}', 'clima_koppen' => '{clima_koppen}']);
        $this->datagrid->addAction($action1, 'View', 'fa:search blue');

        // Criar o modelo do datagrid
        $this->datagrid->createModel();

        $panel = new TPanelGroup(_t('Environment History List'));
        $panel->add($this->datagrid);
        $panel->addFooter('LAPS');

        // Tornar o scroll horizontal
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
            TTransaction::open('Environment_history'); // Substitua 'database_name' pelo nome do banco de dados

            $repository = new TRepository('Environment_History'); // Substitua 'ca$Environment_History' pelo nome da classe de entidade dos animais

            $Environment_History = $repository->load(); // Carregar todos os animais do banco de dados

            $this->datagrid->clear();

            foreach ($Environment_History as $Environment_History) {
                $item = new stdClass;
                $item->idEnvironment_History = $Environment_History->idEnvironment_History;
                $item->clima_koppen = $Environment_History->clima_koppen;
                $item->preciptation_month_mean_WC = $Environment_History->preciptation_month_mean_WC;
                $item->preciptation_anual_mean_WC = $Environment_History->preciptation_anual_mean_WC;
                $item->temperature_month_mean_WC = $Environment_History->temperature_month_mean_WC;
                $item->temperature_annual_mean_WC = $Environment_History->temperature_annual_mean_WC;

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
        $code = $param['idEnvironment_History'];
        $clima_koppen = $param['clima_koppen'];
        new TMessage('info', "The code is: <br> $code </br> <br> The clima_koppen is: <b>$clima_koppen</b>");
    }

    public function show()
    {
        $this->onReload();
        parent::show();
    }
}