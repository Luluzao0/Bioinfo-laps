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



class subspecies_author extends TPage 
{
    private $datagrid;

    public function __construct()
    {
        parent::__construct();

        // Criar o datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'min-width: 1900px';

        $this->datagrid->addColumn(new TDataGridColumn('idsubspecies_author', '#', 'center'));
        $this->datagrid->addColumn( new TDataGridColumn('last_name', 'Last_name', 'left') );
        $this->datagrid->addColumn( new TDataGridColumn('class_year',     'Class_year',     'left') );



        $action1 = new TDataGridAction([$this, 'onView'], ['idsubspecies_author' => '{idsubspecies_author}', 'last_name' => '{last_name}']);
        $this->datagrid->addAction($action1, 'View', 'fa:search blue');

        // Criar o modelo do datagrid
        $this->datagrid->createModel();

        $panel = new TPanelGroup(_t('subspecies_author List'));
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
            TTransaction::open('subspecies_author'); // Substitua 'database_name' pelo nome do banco de dados

            $repository = new TRepository('subspecies_author'); // Substitua 'Animal' pelo nome da classe de entidade dos animais

            $subspecies_author = $repository->load(); // Carregar todos os animais do banco de dados

            $this->datagrid->clear();

            foreach ($subspecies_author as $subspecies_author) {
                $item = new stdClass;
                $item->idsubspecies_author = $subspecies_author->idsubspecies_author;
                $item->last_name = $subspecies_author->last_name;
                $item->class_year = $subspecies_author->class_year;

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
        $code = $param['idsubspecies_author'];
        $last_name = $param['last_name'];
        new TMessage('info', "The code is: <br> $code </br> <br> The last_name is: <b>$last_name</b>");
    }

    public function show()
    {
        $this->onReload();
        parent::show();
    }
}