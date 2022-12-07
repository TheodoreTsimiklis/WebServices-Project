<?php

require(dirname(__DIR__)."/models/appointmentModel.php");

class AppointmentsController {

    private $appointmentsModel; //model
    
    function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
    }

    function createAppointment($data){

        // get the parameters from the request
        $api_Key = $data['api_Key'];
        $date_Time = $data['date_Time'];
        $donor_Name = $data['donor_Name'];
        $user_ID = $data['user_ID'];
        $hospital_ID = $data['hospital'];
        $email = $data['email'];
        
        // Insert to database and at the same time return to the index
        $data =[
            'client_ID' => $this->appointmentModel->getClientID($api_Key),
            'date_Time' => $date_Time,
            'donor_Name'=> $donor_Name,
            'user_ID' => $user_ID,
            'hospital_ID' =>$hospital_ID,
            'email' => $email,
        ];
        $result = $this->appointmentModel->addAppointment($data);
        return $result; // returns to index.php method processPostResponse
    }
    function getUserAppointments($data) {
        return $this->appointmentModel->getUserAppointments($data); 
    }

    function updateAppointment($data, $appointment_ID){
        return $this->appointmentModel->updateAppointment($data, $appointment_ID);
    }
}

?>