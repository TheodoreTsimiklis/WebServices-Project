<?php

    class Response{

        public array $header;
        public $payload;
        public $statuscode;
        public $statustext;
        public $contenttype;

        function __construct($payload)
        {
            $this->payload = $payload;

            $this->header = array();

        }

    }


?>