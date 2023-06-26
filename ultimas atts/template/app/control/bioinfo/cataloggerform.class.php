<?php
use Adianti\Database\TRecord;

class cataloggerForm extends TRecord {

    const TABLENAME = 'catalogger';

    const PRIMARYKEY = 'id';

    const IDPOLICY = 'serial';

    public function __construct($id = NULL) {
        
        parent::__construct($id);
        parent::addAttribute('first_name');
        parent::addAttribute('middle_name_initials');
        parent::addAttribute('last_name');
        parent::addAttribute('cataloged_date');
    }

    public static function getForm() {
        return CataloggerForm::getForm();
    }


    public function get_catalogger_forms(){
        if(empty($this->catalogger_forms))
            $this-> catalogger_forms = new cataloggerForm($this -> idcatalogger_forms);
        return $this -> catalogger_forms;
    }

}
