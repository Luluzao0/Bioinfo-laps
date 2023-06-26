<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapFormBuilder;

class collectorform extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder('form_collector');

        $first_name = new TEntry('first_name');
        $last_name = new TEntry('last_name');
// Adicione outros campos aqui conforme necessário

        $this->form->addFields([
            new TLabel('first_name:'),
            new TLabel('last_name:'),
// Adicione outros rótulos aqui conforme necessário
        ], [
            $first_name,
            $last_name,
// Adicione outros campos aqui conforme necessário
        ]);

        $this->form->addAction('gravar', new TAction([$this, 'onSave']), 'fa:check-circle-o green');

        parent::add($this->form);
    }

    public function onMostrar()
    {
        $data = $this->form->getData();

        new TMessage('info', "Os dados digitados são:<br>
Kingdom: {$data->first_name}<br>
Phylum: {$data->last_name}<br>
// Adicione outras informações aqui conforme necessário
");
    }

    public function onSave()
    {
        try {
            TTransaction::open('collector');

            $data = $this->form->getData();

            $collector = new Animals();
            $collector->first_name = $data->first_name;
            $collector->last_name = $data->last_name;
// Atribua os outros campos à entidade conforme necessário

            $collector->store();

            new TMessage('info', "dados incluídos com sucesso!!!");

            TTransaction::close();
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}