<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapFormBuilder;

class speciesauthorform extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder('form_speciesauthor');

        $last_name = new TEntry('last_name');
        $class_year = new TEntry('class_year');
// Adicione outros campos aqui conforme necessário

        $this->form->addFields([
            new TLabel('last name:'),
            new TLabel('class year:'),
// Adicione outros rótulos aqui conforme necessário
        ], [
            $last_name,
            $class_year,
// Adicione outros campos aqui conforme necessário
        ]);

        $this->form->addAction('gravar', new TAction([$this, 'onSave']), 'fa:check-circle-o green');

        parent::add($this->form);
    }

    public function onMostrar()
    {
        $data = $this->form->getData();

        new TMessage('info', "Os dados digitados são:<br>
Kingdom: {$data->kingdom}<br>
Phylum: {$data->phylum}<br>
// Adicione outras informações aqui conforme necessário
");
    }

    public function onSave()
    {
        try {
            TTransaction::open('speciesauthor');

            $data = $this->form->getData();

            $speciesauthor = new SpeciesAuthor();
            $speciesauthor->last_name = $data->last_name;
            $speciesauthor->class_year = $data->class_year;
// Atribua os outros campos à entidade conforme necessário

            $speciesauthor->store();

            new TMessage('info', "dados incluidos com sucesso!!");

            TTransaction::close();
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}