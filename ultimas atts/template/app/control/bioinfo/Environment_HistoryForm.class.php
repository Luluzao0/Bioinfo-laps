<?php
use Adianti\Database\TRecord;

class Environment_History extends TRecord {

    const TABLENAME = 'Environment_History';

    const PRIMARYKEY = 'idEnvironment_History';

    const IDPOLICY = 'serial';

    public function __construct($idEnvironment_history = NULL) {
        
        parent::__construct($idEnvironment_history);
        parent::addAttribute('clima_koppen');
        parent::addAttribute('preciptation_month_mean_WC');
        parent::addAttribute('preciptation_anual_mean_WC');
        parent::addAttribute('temperature_month_mean_WC');
        parent::addAttribute('temperature_annual_mean_WC');
    }

   
    public static function getForm() {
        return catalogerForm::getForm();
    }
   

    public function get_Environment_History(){
        if(empty($this->Environment_History))
            $this-> Environment_History = new Environment_History($this -> idEnvironment_History);
        return $this -> Environment_History;
    }

}