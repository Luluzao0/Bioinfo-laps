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



class AnimalsList extends TPage 
{
    private $datagrid;

    public function __construct()
    {
        parent::__construct();

        // Criar o datagrid
        $this->datagrid = new BootstrapDatagridWrapper(new TDataGrid);
        $this->datagrid->style = 'min-width: 1900px';

        $this->datagrid->addColumn(new TDataGridColumn('idanimals', '#', 'center'));
        $this->datagrid->addColumn(new TDataGridColumn('kingdom', 'Kingdom', 'left'));
        $this->datagrid->addColumn( new TDataGridColumn('phylum', 'phylum', 'left') );
        $this->datagrid->addColumn( new TDataGridColumn('class',     'Class',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('subclass',     'subclass',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('order_animal',      'Order',      'left') );
        $this->datagrid->addColumn( new TDataGridColumn('family',     'Family',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('subfamily',   'Subfamily',   'left') );
        $this->datagrid->addColumn( new TDataGridColumn('genus',      'Genus',      'center') );
        $this->datagrid->addColumn( new TDataGridColumn('epiteto',      'Epiteto',      'left') );
        $this->datagrid->addColumn( new TDataGridColumn('species', 'Species', 'left') );
        $this->datagrid->addColumn( new TDataGridColumn('subspecies',     'Subspecies',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('functional_group',     'Functional Group',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('abundance',      'Abundance',      'left') );
        $this->datagrid->addColumn( new TDataGridColumn('sexo',     'Seo',     'left') );
        $this->datagrid->addColumn( new TDataGridColumn('caste',   'Caste',   'left') );
        $this->datagrid->addColumn( new TDataGridColumn('development_stage',      'Development_stage',      'center') );
        $this->datagrid->addColumn( new TDataGridColumn('determination_start',      'Determination Start',      'left') );
        $this->datagrid->addColumn( new TDataGridColumn('determination_end', 'Determination End', 'left') );
        $this->datagrid->addColumn( new TDataGridColumn('biomass',     'Biomass',     'left') );



        $action1 = new TDataGridAction([$this, 'onView'], ['idanimals' => '{idanimals}', 'kingdom' => '{kingdom}']);
        $this->datagrid->addAction($action1, 'View', 'fa:search blue');

        // Criar o modelo do datagrid
        $this->datagrid->createModel();

        $panel = new TPanelGroup(_t('Animals List'));
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
            TTransaction::open('animals'); // Substitua 'database_name' pelo nome do banco de dados

            $repository = new TRepository('animals'); // Substitua 'Animal' pelo nome da classe de entidade dos animais

            $animals = $repository->load(); // Carregar todos os animais do banco de dados

            $this->datagrid->clear();

            foreach ($animals as $animal) {
                $item = new stdClass;
                $item->idanimals = $animal->idanimals;
                $item->kingdom = $animal->kingdom;
                $item->phylum = $animal->phylum;
                $item->class = $animal->class;
                $item->subclass = $animal->subclass;
                $item->order_animal = $animal->order_animal;
                $item->family = $animal -> family;
                $item ->subfamily = $animal -> subfamily;
                $item ->genus = $animal -> genus;
                $item -> epiteto = $animal -> epiteto;
                $item -> species = $animal -> species;
                $item -> subspecies = $animal -> subspecies;
                $item -> functional_group = $animal -> functional_group;
                $item -> abundance = $animal -> abundance;
                $item -> sexo = $animal -> sexo;
                $item -> caste = $animal -> caste;
                $item -> development_stage = $animal -> development_stage;
                $item -> determination_start = $animal -> determination_start;
                $item -> determination_end = $animal -> determination_end;
                $item -> biomass = $animal -> biomass;

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
        $kingdom = $param['kingdom'];
        new TMessage('info', "The code is: <br> $code </br> <br> The Kingdom is: <b>$kingdom</b>");
    }

    public function show()
    {
        $this->onReload();
        parent::show();
    }
}
