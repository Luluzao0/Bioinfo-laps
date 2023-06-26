<?php

use Adianti\Database\TRecord;

class Plot extends TRecord
{

    const TABLENAME = 'plot';

    const PRIMARYKEY = 'idplot';

    const IDPOLICY = 'serial';

    public function __construct($idplot = NULL)
    {

        parent::__construct($idplot);
        parent::addAttribute('station_field_number');
        parent::addAttribute('fk_environments');
        parent::addAttribute('fk_chem_comp');
        parent::addAttribute('fk_sampling_history');
        parent::addAttribute('fk_land_user_history');
        parent::addAttribute('fk_carbon');
        parent::addAttribute('land_ower');
        parent::addAttribute('name');
        parent::addAttribute('county');
        parent::addAttribute('state');
        parent::addAttribute('country');
        parent::addAttribute('continent');
        parent::addAttribute('conservation_unit_class');
        parent::addAttribute('conservation_unit_name');
        parent::addAttribute('previous_land_use');
        parent::addAttribute('lat');
        parent::addAttribute('log');
        parent::addAttribute('relief');
        parent::addAttribute('topography');
        parent::addAttribute('soil_order');
        parent::addAttribute('soil_suborder');
        parent::addAttribute('bioma');
        parent::addAttribute('vegetation_physignomia');
        parent::addAttribute('vegetation_age');
        parent::addAttribute('land_use');
        parent::addAttribute('dem');
        parent::addAttribute('hand');
    }



    /*
    public static function getForm() {
        return AnimalsForm::getForm();
    }
    */



    public function get_plot()
    {
        if (empty($this->plot))
            $this->plot = new Plot($this->idplot);
        return $this->plot;
    }



}