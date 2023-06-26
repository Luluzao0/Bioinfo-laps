<?php
use Adianti\Database\TRecord;

class Cursos extends TRecord{
    const TABLENAME = 'cursos';
    const PRIMARYKEY = 'id';
    const IDPOLICY = 'serial';

    public function __construct($id = NULL){
        parent::__construct($id);
        parent::addAttribute('nome');
    }
}
