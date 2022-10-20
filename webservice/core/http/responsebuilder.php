<?php

    class ResponseBuilder{

        private $response;

        function __construct($headerfields, $payload)
        {

            $this->response = new Response($payload);
            
            $this->addHeaderFields($headerfields);

        }

        function getResponse(){

            return $this->response;

        }

        private function setProperties($headerfields){

            $this->response->statuscode = $headerfields["Status-Code"];
            $this->response->contenttype = $headerfields["Content-Type"];
            $this->response->statustext = $headerfields["Status-Text"];

        }

        function addHeaderFields(array $headerfields){

            $result = array_merge($this->response->header, $headerfields); //merge the two headerfields

            $this->response->header = $result; //reset header to the merged arrays

            // Make sure the individual response properties have the same values as the $header property:
            $this->setProperties($this->response->header);

            $this->setHTTPHeaderFields($this->response->header);

        }

        function setHTTPHeaderFields(array $headerfields){
            $statusLine = 'HTTP/1.1 '.$headerfields['Status-Code'].' '.$headerfields['Status-Text'];

            header($statusLine);

            header('Content-Type: '.$headerfields['Content-Type']);
        }

    }

?>