<?php
use Adianti\Database\TRecord;

class Subspecies_author extends TRecord {

    const TABLENAME = 'subspecies_author';

    const PRIMARYKEY = 'idsubspecies_author';

    const IDPOLICY = 'serial';
    
    public function __construct($idsubspecies_author = NULL) {
        
        parent::__construct($idsubspecies_author);
        parent::addAttribute('last_name');
        parent::addAttribute('class_year');
    }

    /*
    public static function getForm() {
        return AnimalsForm::getForm();
    }
    */

    public function get_subspecies_author(){
        if(empty($this->subspecies_author))
            $this->subspecies_author = new Subspecies_author($this -> idsubspecies_author);
        return $this -> subspecies_author;
    }

}