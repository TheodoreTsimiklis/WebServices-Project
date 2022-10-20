<?php

class DBConnectionManager{

    private $user;
    private $password;
    private $host;
    private $dbname;

    private $conn;

    function __construct()
    {
        $config = simplexml_load_file(dirname(__DIR__)."/config.xml");

        $this->user = $config->database->user;
        $this->password = $config->database->password;
        $this->host = $config->database->host;
        $this->dbname = $config->database->dbname;

    }

    function getconnection(){

        try {
            $this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname,
            $this->user,  $this->password);
        } catch(PDOException $exception){
            // Log the exception

        }

        return $this->conn;

    }

}

?>