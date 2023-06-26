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

class species_authorList extends TPage
{
    private $datagrid;

    public function __construct()
    {
        parent::__construct();

        // Criar o datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'min-width: 1900px';

        $this->datagrid->addColumn(new TDataGridColumn('idspecies_author', '#', 'center'));
        $this->datagrid->addColumn(new TDataGridColumn('last_name', 'last_name', 'left'));
        $this->datagrid->addColumn(new TDataGridColumn('class_year', 'class_year', 'left'));

        $action1 = new TDataGridAction([$this, 'onView'], ['idspecies_author' => '{idspecies_author}', 'last_name' => '{last_name}']);
        $this->datagrid->addAction($action1, 'View', 'fa:search blue');

        // Criar o modelo do datagrid
        $this->datagrid->createModel();

        $panel = new TPanelGroup(_t('Species Author List'));
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
            TTransaction::open('species_author'); // Substitua 'species_author' pelo nome do banco de dados

            $repository = new TRepository('Species_au'); // Substitua 'SpeciesAuthor' pelo nome da classe de entidade dos autores de espécies

            $species_authors = $repository->load(); // Carregar todos os autores de espécies do banco de dados

            $this->datagrid->clear();

            foreach ($species_authors as $species_author) {
                $item = new stdClass;
                $item->idspecies_authors = $species_author->idspecies_authors;
                $item->last_name = $species_author->last_name;
                $item->class_year = $species_author->class_year;

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
        $code = $param['idspecies_author'];
        $lastName = $param['last_name'];
        new TMessage('info', "The code is: <br> $code </br> <br> Last name is: <b>$lastName</b>");
    }

    public function show()
    {
        $this->onReload();
        parent::show();
    }
}
