<?php
use Adianti\Database\TRecord;

class species_author extends TRecord {

    CONST TABLENAME = 'species_author';

    CONST PRIMARYKEY = 'idspecies_author';

    CONST IDPOLICY = 'serial';


    public function __construct($idspecies_author = NULL)
    {

        parent::__construct($idspecies_author);
        parent::addAttribute('last_name');
        parent::addAttribute('class_year');
    }

    public function get_species_author()
    {
        if (empty($this->species_author))
            $this->species_author = new Species_author($this->idspecies_author);
        return $this->species_author;
    }


}