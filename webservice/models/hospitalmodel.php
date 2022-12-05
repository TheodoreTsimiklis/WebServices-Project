<?php

require(dirname(__DIR__) . "/core/database/dbconnectionmanager.php");


/**
 * Database model
 */

class HospitalModel
{

    private $conn;

    function __construct()
    {
        $dbconnmanager = new DBConnectionManager();

        $this->conn = $dbconnmanager->getconnection();
    }

    // Retrieve the appointments  for a specific client using the client's api key
    function hospital_list($apikey)
    {
        $query = 'SELECT * FROM hospitals';

        $statement = $this->conn->prepare($query);

        $statement->bindParam(':apikey', $apikey, PDO::PARAM_STR);

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
        $query = "INSERT INTO appointments(client_ID, date_Time, donor_Name, user_ID) 
                    values (:client_ID, :date_Time, :donor_Name, :user_ID)";

        $statement = $this->conn->prepare($query);

        $statement->bindParam(':client_ID', $data["client_ID"], PDO::PARAM_INT);
        $statement->bindParam(':date_Time', $data["date_Time"], PDO::PARAM_STR);
        $statement->bindParam(':donor_Name', $data["donor_Name"], PDO::PARAM_STR);
        $statement->bindParam(':user_ID', $data["user_ID"], PDO::PARAM_INT);
        
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

    function getHospitalsList(){
        $query= 'SELECT * FROM hospitals';

        $statement = $this->conn->prepare($query);

        // $statement->bindParam(':apikey', $apikey, PDO::PARAM_STR);

        $statement->execute();

        return $statement->fetchAll(PDO::FETCH_CLASS);
    }
}


