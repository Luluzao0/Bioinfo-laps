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



class CollectorList extends TPage
{
    private $datagrid;

    public function __construct()
    {
        parent::__construct();

        // Criar o datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'min-width: 1900px';

        $this->datagrid->addColumn(new TDataGridColumn('id', '#', 'center'));
        $this->datagrid->addColumn(new TDataGridColumn('first_name', 'first_name', 'left'));
        $this->datagrid->addColumn( new TDataGridColumn('last_name', 'last_name', 'left') );




        $action1 = new TDataGridAction([$this, 'onView'], ['id' => '{id}', 'first_name' => '{first_name}']);
        $this->datagrid->addAction($action1, 'View', 'fa:search blue');

        // Criar o modelo do datagrid
        $this->datagrid->createModel();

        $panel = new TPanelGroup(_t('collectors list'));
        $panel->add($this->datagrid);
        $panel->addFooter('LAPS');

        // Tornar o scroll horizontal
        $panel->getBody()->style = "overflow-x:auto;";

        $vbox = new TVBox;
        $vbox->style = 'width: 100%';
        $vbox->add(new TXMLBreadCrumb('menu.xml', _CLASS_));
        $vbox->add($panel);

        parent::add($vbox);
    }

    public function onReload()
    {
        try {
            TTransaction::open('collector'); // Substitua 'database_name' pelo nome do banco de dados

            $repository = new TRepository('collector'); // Substitua 'Animal' pelo nome da classe de entidade dos animais

            $collector = $repository->load(); // Carregar todos os animais do banco de dados

            $this->datagrid->clear();

            foreach ($collector as $collector) {
                $item = new stdClass;
                $item->id = $collector->ids;
                $item->first_name = $collector->fisrt_name;
                $item->last_name = $collector->last_name;


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
        $code = $param['idanimals'];
        $first_name = $param['kingdom'];
        new TMessage('info', "The code is: <br> $code </br> <br> first name is: <b>$first_name</b>");
    }

    public function show()
    {
        $this->onReload();
        parent::show();
    }
}
