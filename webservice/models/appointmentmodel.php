<?php

// __DIR__ is a predefined global variable that gives the cureent path
// __DIR__ : C:\xampp\htdocs\webservice\models

// But we need to go up one level then to access core/database

// dirname returns the parent directory of the given path as parameter
// dirname(__DIR__): C:\xampp\htdocs\webservice

require(dirname(__DIR__) . "/core/database/dbconnectionmanager.php");


/**
 * Database model
 */

class AppointmentModel
{
    public $appointment_ID;
    public $client_ID;
    public $user_ID;
    public $date_Time;
    public $donor_Name;

    private $conn;

    function __construct()
    {
        $dbconnmanager = new DBConnectionManager();

        $this->conn = $dbconnmanager->getconnection();
    }

    // Retrieve the appointments  for a specific client using the client's api key
    function getUserAppointments($data, $appointment_ID)
    {
        $query = 'SELECT appointments.appointment_ID, appointments.client_ID, appointments.user_ID, appointments.hospital_ID, appointments.date_time,
            hospitals.hospital_name, hospitals.hospital_street, hospitals.city, hospitals.province, hospitals.postal_code
                    FROM appointments
                    INNER JOIN hospitals ON appointments.hospital_ID = hospitals.hospital_ID
                    WHERE user_ID = :user_ID
                    AND client_ID =
                            (SELECT client_ID 
                            FROM clients
                            WHERE api_key = :api_key)';

        $statement = $this->conn->prepare($query);

        if($appointment_ID != ""){
            $query = $query . ' AND appointments.appointment_ID = :appointment_ID';
            
            $statement = $this->conn->prepare($query);

            $statement->bindParam(':appointment_ID', $appointment_ID, PDO::PARAM_INT);

        }

        $statement->bindParam(':user_ID', $data['user_ID'], PDO::PARAM_INT);
        $statement->bindParam(':api_key', $data['api_key'], PDO::PARAM_STR);

        $statement->execute();

        //FETCH_CLASS returns an array of objects of type videoconversions: result->id
        // FETCH_ASSOC returns an associative array of conversions: result["id"]

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

    /**
     * add a new appointment  
     */
    function addAppointment($data)
    {
        $query = "INSERT INTO appointments(client_ID, hospital_ID, user_ID, date_time, donor_name, donor_email) 
                    values (:client_ID, :hospital_ID, :user_ID, :date_Time, :donor_Name, :donor_email)";

        $statement = $this->conn->prepare($query);

        $statement->bindParam(':client_ID', $data["client_ID"], PDO::PARAM_INT);
        $statement->bindParam(':hospital_ID', $data["hospital_ID"], PDO::PARAM_INT);
        $statement->bindParam(':user_ID', $data["user_ID"], PDO::PARAM_INT);
        $statement->bindParam(':date_Time', $data["date_Time"], PDO::PARAM_STR);
        $statement->bindParam(':donor_Name', $data["donor_Name"], PDO::PARAM_STR);
        $statement->bindParam(':donor_email', $data["email"], PDO::PARAM_STR);

        return $statement->execute();
    }

   function getClientID($apikey) {
        $query = 'SELECT client_ID 
                FROM clients
                WHERE api_Key = :apikey';
        
        $statement = $this->conn->prepare($query);

        $statement->bindParam(':apikey', $apikey, PDO::PARAM_STR);

        $statement->execute();
        return $statement->fetch(PDO::FETCH_NUM); // fetch number 
    }

    function getHospitalList($apikey){
        $query= 'SELECT * FROM hospitals';

        $statement = $this->conn->prepare($query);

        $statement->bindParam(':apikey', $apikey, PDO::PARAM_STR);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }

   function updateAppointment($data, $appointment_ID) {
        $query= 'UPDATE appointments 
            SET date_time = :date_time 
            WHERE appointment_ID = :appointment_ID';
            
        $statement = $this->conn->prepare($query);
        $statement->bindParam(':date_time', $data["date_Time"], PDO::PARAM_STR);
        $statement->bindParam(':appointment_ID', $appointment_ID, PDO::PARAM_STR);
        return $statement->execute();
   }


    // function getSingleAppointment($data){
    //     $query = "SELECT hospital_name FROM hospitals 
    //                 WHERE appointment_ID = :appointment_ID";

    //     $statement = $this->conn->prepare($query);

    //     $statement->execute();

    //     return $statement->fetchColumn();   // only return hospital's name, just a string
    
    // }

}



// $query = 'SELECT appointments.appointment_ID, appointments.client_ID, appointments.user_ID, appointments.hospital_ID, appointments.date_time,
//             hospitals.hospital_name
//                     FROM appointments
//                     INNER JOIN hospitals ON appointments.hospital_ID = hospitals.hospital_ID
//                     WHERE user_ID = :user_ID AND appointments.appointment_ID = :appointment_ID
//                     AND client_ID =
//                             (SELECT client_ID 
//                             FROM clients
//                             WHERE api_key = :api_key)';

//         $statement = $this->conn->prepare($query);
//         $statement->bindParam(':user_ID', $data['user_ID'], PDO::PARAM_INT);
//         $statement->bindParam(':api_key', $data['api_key'], PDO::PARAM_STR);
//         $statement->bindParam(':appointment_ID', $data['appointment_ID'], PDO::PARAM_INT);


