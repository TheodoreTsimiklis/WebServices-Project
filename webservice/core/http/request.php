<?php

// A class that represents an HTTP Request

    // We could make the Request objects immutable
    class Request{

        public readonly string $method;
        public readonly array $urlparams;
        public readonly array $header;
        public readonly array $payload;// data

        function __construct($method, $urlparams, $header, $payload)
        {   
            $this->method = $method;
            // var_dump($urlparams);
            // echo "</br>";
            // var_dump($header);
            // echo "</br>";

            // var_dump(payload);
            $this->urlparams = $urlparams;
            $this->header = $header;
            $this->payload = $payload;
        }

        // We could implement Getters
        // but don't mplement setters because this object is upposed to be immutable

        

    }


?>