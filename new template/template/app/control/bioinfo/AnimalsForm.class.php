<?php
use Adianti\Database\TRecord;

class AnimalForm extends TRecord {

    const TABLENAME = 'animals';

    const PRIMARYKEY = 'idanimal';

    const IDPOLICY = 'serial';

    public function __construct($idanimal = NULL) {
        
        parent::__construct($idanimal);
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

    public static function getForm() {
        return AnimalForm::getForm();
    }


    public function get_animal_forms(){
        if(empty($this->animal_forms))
            $this-> animal_forms = new AnimalForm($this -> idanimal_forms);
        return $this -> animal_forms;
    }

}
