<?php
use Adianti\Database\TRecord;


class Alunos extends TRecord{
    const TABLENAME ='alunos';
    const PRIMARYKEY='id';
    const IDPOLICY='serial';

    public function __construct($id = NULL){
        parent::__construct($id);
        parent::addAttribute('nome');
        parent::addAttribute('cursos_id');

    }

    public function get_cursos(){
        if(empty($this->cursos))
            $this->cursos = new Cursos($this->cursos_id);
        return $this->cursos;
    
    }

}