<?php

use Adianti\Database\TRecord;

class Monolith extends TRecord
{

    const TABLENAME = 'monolith';

    const PRIMARYKEY = 'idmonolith';

    const IDPOLICY = 'serial';

    public function __construct($idmonolith = NULL)
    {

        parent::__construct($idmonolith);
        parent::addAttribute('fk_catalog');
        parent::addAttribute('fk_monolith_chem');
        parent::addAttribute('monolith_code');
        parent::addAttribute('monolith_number_count');
        parent::addAttribute('area');
        parent::addAttribute('soil_depth');
        parent::addAttribute('soil_layer_depth');
    }   



    /*
    public static function getForm() {
        return AnimalsForm::getForm();
    }
    */



    public function get_monolith()
    {
        if (empty($this->monolith))
            $this->monolith = new Monolith($this->idmonolith);
       return $this->monolith;
    }
}