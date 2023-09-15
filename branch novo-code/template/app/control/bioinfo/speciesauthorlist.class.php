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

class speciesauthorlist extends TPage
{
    private $datagrid;

    public function __construct()
    {
        parent::__construct();

        // Criar o datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'min-width: 1900px';

        $this->datagrid->addColumn(new TDataGridColumn('id', '#', 'center'));
        $this->datagrid->addColumn(new TDataGridColumn('last_name', 'last_name', 'left'));
        $this->datagrid->addColumn(new TDataGridColumn('class_year', 'class_year', 'left'));

        $action1 = new TDataGridAction([$this, 'onView'], ['id' => '{id}', 'last_name' => '{last_name}']);
        $this->datagrid->addAction($action1, 'View', 'fa:search blue');

        // Criar o modelo do datagrid
        $this->datagrid->createModel();

        $panel = new TPanelGroup(_t('species author List'));
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
            TTransaction::open('speciesauthor'); // Substitua 'database_name' pelo nome do banco de dados

            $repository = new TRepository('speciesauthor'); // Substitua 'Animal' pelo nome da classe de entidade dos animais

            $speciesauthors = $repository->loadAll(); // Carregar todos os animais do banco de dados

            $this->datagrid->clear();

            foreach ($speciesauthors as $speciesauthor) {
                $item = new stdClass;
                $item->id = $speciesauthor->id;
                $item->last_name = $speciesauthor->last_name;
                $item->class_year = $speciesauthor->class_year;

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
        $code = $param['id'];
        $lastName = $param['last_name'];
        new TMessage('info', "The code is: <br> $code </br> <br> Last name is: <b>$lastName</b>");
    }

    public function show()
    {
        $this->onReload();
        parent::show();
    }
}
