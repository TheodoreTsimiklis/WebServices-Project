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
            $this->urlparams = $urlparams;
            $this->header = $header;
            $this->payload = $payload;
        }
    }


?>