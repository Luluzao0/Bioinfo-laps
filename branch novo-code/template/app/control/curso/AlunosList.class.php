<?php
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Wrapper\TQuickGrid;

class AlunosList extends TPage
{
    private $datagrid;
    private $loaded = false;

    public function __construct()
    {
        parent::__construct();
        $this->datagrid = new TQuickGrid();

        $this->datagrid->addQuickColumn('#', 'cursos_id', 'center', 50);
        $this->datagrid->addQuickColumn('Nome', 'nome', 'left', 200);
        $this->datagrid->addQuickColumn('Cursos', 'curso_nome', 'left', 200);

        $this->datagrid->createModel();

        parent::add($this->datagrid);
    }

    public function onReload($params = null)
    {
        try {
            TTransaction::open('sample');
            
            $alunos = Alunos::all(); // Supondo que você tenha uma classe "Aluno" que representa a tabela de alunos no banco de dados
            $this->datagrid->addItems($alunos);

            TTransaction::close();
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }

    public function show()
    {
        if (!$this->loaded && (!isset($_GET['method']) || !in_array($_GET['method'], ['onReload', 'onSearch']))) {
            $this->onReload();
            $this->loaded = true;
        }
        parent::show();
    }
}
