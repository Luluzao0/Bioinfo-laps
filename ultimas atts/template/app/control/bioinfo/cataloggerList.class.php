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



class cataloggerList extends TPage 
{
    private $datagrid;

    public function __construct()
    {
        parent::__construct();

        // Criar o datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'min-width: 1900px';

        $this->datagrid->addColumn(new TDataGridColumn('idcatalogger', '#', 'center'));
        $this->datagrid->addColumn(new TDataGridColumn('first_name', 'first name', 'left'));
        $this->datagrid->addColumn( new TDataGridColumn('middle_name_initials', 'middle name initials', 'left') );
        $this->datagrid->addColumn( new TDataGridColumn('last_name',     'last name',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('cataloged_date',     'cataloged date',     'left') );

        $action1 = new TDataGridAction([$this, 'onView'], ['idcatalogger' => '{idcatalogger}', 'first_name' => '{first_name}']);
        $this->datagrid->addAction($action1, 'View', 'fa:search blue');

        // Criar o modelo do datagrid
        $this->datagrid->createModel();

        $panel = new TPanelGroup(_t('catalogger List'));
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
            TTransaction::open('catalogger'); // Substitua 'database_name' pelo nome do banco de dados

            $repository = new TRepository('catalogger'); // Substitua 'ca$catalogger' pelo nome da classe de entidade dos animais

            $catalogger = $repository->load(); // Carregar todos os animais do banco de dados

            $this->datagrid->clear();

            foreach ($catalogger as $catalogger) {
                $item = new stdClass;
                $item->idcatalogger = $catalogger->idcatalogger;
                $item->first_name = $catalogger->first_name;
                $item->middle_name_initials = $catalogger->midddle_name_initials;
                $item->last_name = $catalogger->last_name;
                $item->cataloged_date = $catalogger->cataloged_date;
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
        $code = $param['idcatalogger'];
        $first_name = $param['first_name'];
        new TMessage('info', "The code is: <br> $code </br> <br> The first_name is: <b>$first_name</b>");
    }

    public function show()
    {
        $this->onReload();
        parent::show();
    }
}
