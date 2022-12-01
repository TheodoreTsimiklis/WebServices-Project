<?php
require_once(dirname(__DIR__).'/vendor/autoload.php');
require_once(dirname(__DIR__)."/core/auth/auth.php");
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class AuthController {
    function __construct() {
    }

    function processToken($apikey) {
        $key = $apikey;
        $payload = [
            'iss' => 'http://localhost/webservice/api.com',
            'aud' => 'http://localhost/client/clientJWT.com',
            'iat' => 1668112489,
            'nbf' => 1668004579,
            'exp' => 1699659829
        ];

        $auth = new AuthToken();
        $jwt = $auth->generateToken($payload, $key);
        return $jwt; 
    }
}