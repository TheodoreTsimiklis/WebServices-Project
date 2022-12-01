<?php
require_once(dirname(dirname(__DIR__)).'/vendor/autoload.php');
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
class AuthToken {
    // default constructor
    function __construct() {
    }
    // will generate the token
    function generateToken($payload, $key) {
    // generate
        $jwt = JWT::encode($payload, $key, 'HS256');
        return $jwt;
    }

    // will verify the token
    function verifyToken($jwt, $apikey) { 
        $decoded = JWT::decode($jwt, new Key($apikey, 'HS256'));
        return $decoded;
    }
}

?>