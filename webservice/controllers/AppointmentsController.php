<?php
require(dirname(__DIR__)."/models/appointmentModel.php");
require_once(dirname(__DIR__).'/vendor/autoload.php');
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;
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
        $logger = new Logger('appoinmentControllerLogger');
        $logger->pushHandler(new StreamHandler(dirname(dirname(__FILE__)).'/logs/info.log', Level::Info));
        $logger->pushHandler(new FirePHPHandler());
        
        $result = $this->appointmentModel->addAppointment($data);
            
        if ($result)
            $logger->info($donor_Name . "'s " . 'appointment booking successful');
        else 
            $logger->info($donor_Name . "'s " . 'appointment booking failed');

        return $result; // returns to index.php method processPostResponse
    }
    function getUserAppointments($data, $appointment_ID) {
        return $this->appointmentModel->getUserAppointments($data, $appointment_ID); 
    }

    function updateAppointment($data, $appointment_ID){
        return $this->appointmentModel->updateAppointment($data, $appointment_ID);
    }

    function deleteAppointment($appointment_ID) {
        return $this->appointmentModel->deleteAppointment($appointment_ID);
    }
    // function getSingleAppointment($data){
    //     return $this->appointmentModel->getSingleAppointment($data);
    // }







}

?>