<?php
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Wrapper\TQuickGrid;




class AlunosList extends TPage {
    private $datagrid;
    private $loaded = false;

    public function __construct(){
        parent::__construct();
        $this->datagrid = new TQuickGrid();

        $this->datagrid->addQuickColumn('#', 'cursos_id','nome');
        $this->datagrid->addQuickColumn('', 'Nome', 'nome');

        $this->datagrid->createModel();

        parent::add($this->datagrid);
    }

    public function onReload($params){
        try {
            TTransaction::open('sample');
            
            $alunos = Alunos::getObjects();
            $this->datagrid->addItems($alunos);

            TTransaction::close();
        }
        catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }

    public function show()
    {
        if (!$this->loaded AND (!isset($_GET['method']) OR !(in_array($_GET['method'],  array('onReload', 'onSearch')))) )
        {
            if (func_num_args() > 0)
            {
                $this->onReload( func_get_arg(0) );
            }
            else
            {
                $this->onReload();
            }
            $this->loaded = true;
        }
        parent::show();
    }
}
