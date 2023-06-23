<?php
use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Widget\Wrapper\TDBCombo;
use Adianti\Wrapper\BootstrapFormBuilder;



class AlunosForm extends TPage{

    private $form;

    public function __construct(){
        parent:: __construct();

        
        $this->form = new BootstrapFormBuilder('Form_alunos');
        $nome = new TEntry('nome');
        $cursos = new TDBCombo('cursos_id', 'sample', 'Cursos', 'id', 'nome');

        $this->form->addFields([new TLabel('Nome:')], [$nome]);
        $this->form->addFields([new TLabel('Curso:')],[$cursos]);
        $this->form->addAction('salvar nome do aluno', new TAction(array($this,'onSave')),'fa:check-circle-o green');


        parent::add($this->form);

        
    }
    
    public function  onSave(){
        try {
            TTransaction::open('sample');
            $data = $this->form->getData('Alunos');
            $data -> store();
            /*
            $aluno = new Alunos();
            $aluno -> nome = $data->nome;
            $aluno->cursos_id = $data -> cursos_id;
            $aluno->store();
            */

            TTransaction::close();
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}