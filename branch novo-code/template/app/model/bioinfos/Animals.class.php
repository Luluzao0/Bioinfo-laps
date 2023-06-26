<?php
use Adianti\Database\TRecord;

class Animals extends TRecord {

    const TABLENAME = 'animals';

    const PRIMARYKEY = 'idanimals';

    const IDPOLICY = 'serial';

    public function __construct($idanimals = NULL) {
        
        parent::__construct($idanimals);
        parent::addAttribute('kingdom');
        parent::addAttribute('phylum');
        parent::addAttribute('class');
        parent::addAttribute('subclass');
        parent::addAttribute('order_animal');
        parent::addAttribute('family');
        parent::addAttribute('subfamily');
        parent::addAttribute('genus');
        parent::addAttribute('epiteto');
        parent::addAttribute('species');
        parent::addAttribute('subspecies');
        parent::addAttribute('functional_group');
        parent::addAttribute('abundance');
        parent::addAttribute('sexo');
        parent::addAttribute('caste');
        parent::addAttribute('development_stage');
        parent::addAttribute('determination_start');
        parent::addAttribute('determination_end');
        parent::addAttribute('biomass');
    }

    /*
    public static function getForm() {
        return AnimalsForm::getForm();
    }
    */

    public function get_animals(){
        if(empty($this->animals))
            $this-> animals = new Animals($this -> idanimals);
        return $this -> animals;
    }

}