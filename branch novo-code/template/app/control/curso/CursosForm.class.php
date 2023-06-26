<?php
use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapFormBuilder;

class CursosForm extends TPage
{
private $form;

    function __construct(){
        parent::__construct();
        $this->form = new BootstrapFormBuilder('form_cursos');

        $nome = new TEntry('nome');

        $this->form->addFields([new TLabel('Nome:')], [$nome]);
        $this->form->addAction('gravar', new TAction(array($this,'onSave')),'fa:check-circle-o green');
        parent:: add($this->form);
    }

    function onMostrar(){
        $data = $this->form->getData();

        new TMessage('info', "o nome digitado é {$data->nome}");

    }
    

    function onSave(){
        try {
            
            TTransaction::open('sample');
            
            $data = $this->form->getData();

            $cursos = new Cursos();
            $cursos->nome = $data->nome;
            $cursos->store();

            new TMessage('info', "Curso {$cursos->nome} incluso com sucesso!!!");
            TTransaction::close();
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
        
        

    }
}