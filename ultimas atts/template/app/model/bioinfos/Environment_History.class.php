<?php
use Adianti\Database\TRecord;

class environment_history extends TRecord {

    const TABLENAME = 'environment_history';

    const PRIMARYKEY = 'idenvironment_history';

    const IDPOLICY = 'serial';

    public function __construct($idenvironment_history = NULL) {
        
        parent::__construct($idenvironment_history);
        parent::addAttribute('clima_koppen');
        parent::addAttribute('preciptation_month_mean_WC');
        parent::addAttribute('preciptation_anual_mean_WC');
        parent::addAttribute('temperature_month_mean_WC');
        parent::addAttribute('temperature_annual_mean_WC');
    }

    /*
    public static function getForm() {
        return catalogerForm::getForm();
    }
    */

    public function get_environment_history(){
        if(empty($this->environment_history))
            $this-> environment_history = new environment_history($this -> idenvironment_history);
        return $this -> environment_history;
    }

}