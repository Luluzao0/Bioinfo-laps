<?php
use Adianti\Database\TRecord;

class Catalogger extends TRecord {

    const TABLENAME = 'catalogger';

    const PRIMARYKEY = 'idcatalogger';

    const IDPOLICY = 'serial';

    public function __construct($idcatalogger = NULL) {
        
        parent::__construct($idcatalogger);
        parent::addAttribute('first_name');
        parent::addAttribute('middle_name_initials');
        parent::addAttribute('last_name');
        parent::addAttribute('cataloged_date');
    }

    /*
    public static function getForm() {
        return catalogerForm::getForm();
    }
    */

    public function get_catalogger(){
        if(empty($this->catalogger))
            $this-> catalogger = new catalogger($this -> idcatalogger);
        return $this -> catalogger;
    }

}