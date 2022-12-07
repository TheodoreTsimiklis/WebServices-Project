<?php

require(dirname(__DIR__)."/models/hospitalModel.php");

class HospitalsController {

    private $hospitalsModel; //model
    
    function __construct() {
        $this->hospitalsModel = new HospitalModel();
    }

    function getHospitalsList() {
        return $this->hospitalsModel->getHospitalsList();
    }
}

?>