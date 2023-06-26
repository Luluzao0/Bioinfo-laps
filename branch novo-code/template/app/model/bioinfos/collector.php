<?php
use Adianti\Database\TRecord;

class collector extends TRecord {

    const TABLENAME = 'collector';

    const PRIMARYKEY = 'id';

    const IDPOLICY = 'serial';

    public function __construct($id = NULL) {

        parent::__construct($id);
        parent::addAttribute('first_name');
        parent::addAttribute('last_name');

    }

    /*
    public static function getForm() {
        return AnimalsForm::getForm();
    }
    */

    public function get_collector(){
        if(empty($this->collector))
            $this-> collector = new collector($this -> id);
        return $this -> collector;
    }

}