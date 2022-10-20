<?php
    // a factory class that builds requests

    require("request.php");

    class RequestBuilder{

        private $Request;

        function __construct()
        {
            // Setup the Request

            $method = $_SERVER["REQUEST_METHOD"]; // GET, POST, PUT, HEAD, OPTION, DELETE

            $urlparams = $_GET; // An associative array

            $header =  getallheaders(); // An associative array

            // read the payload and make it an associative array
            parse_str(file_get_contents("php://input"), $payload);

            $this->Request = new Request($method, $urlparams, $header, $payload);
            
        }

        public function getRequest(){

            return $this->Request;

        }

    }

?>