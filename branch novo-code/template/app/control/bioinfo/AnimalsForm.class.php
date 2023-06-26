<?php

use Adianti\Control\TAction;
use Adianti\Control\TPage;
use Adianti\Database\TTransaction;
use Adianti\Widget\Dialog\TMessage;
use Adianti\Widget\Form\TEntry;
use Adianti\Widget\Form\TLabel;
use Adianti\Wrapper\BootstrapFormBuilder;

class AnimalsForm extends TPage
{
    private $form;

    public function __construct()
    {
        parent::__construct();

        $this->form = new BootstrapFormBuilder('form_animals');

        $kingdom = new TEntry('kingdom');
        $phylum = new TEntry('phylum');
        // Adicione outros campos aqui conforme necessário

        $this->form->addFields([
            new TLabel('Kingdom:'),
            new TLabel('Phylum:'),
            // Adicione outros rótulos aqui conforme necessário
        ], [
            $kingdom,
            $phylum,
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
            TTransaction::open('animals');

            $data = $this->form->getData();

            $animal = new Animals();
            $animal->kingdom = $data->kingdom;
            $animal->phylum = $data->phylum;
            // Atribua os outros campos à entidade conforme necessário

            $animal->store();

            new TMessage('info', "Animal incluído com sucesso!!!");

            TTransaction::close();
        } catch (Exception $e) {
            new TMessage('error', $e->getMessage());
        }
    }
}
