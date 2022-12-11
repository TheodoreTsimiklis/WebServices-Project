<?php
require dirname(__DIR__) . "/core/http/requestbuilder.php";
require dirname(__DIR__) . "/core/http/responsebuilder.php";
require_once dirname(__DIR__) . '/vendor/autoload.php';
require_once dirname(__DIR__) . "/core/http/request.php";
require_once dirname(__DIR__) . "/core/http/response.php";
require_once dirname(__DIR__) . "/core/auth/auth.php";
require_once dirname(__DIR__) . "/vendor/autoload.php";

use Monolog\Handler\FirePHPHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

spl_autoload_register('auto_loader');

function auto_loader($class)
{
    if (file_exists(dirname(__DIR__) . "/controllers/" . $class . ".php")) {
        require dirname(__DIR__) . "/controllers/" . $class . ".php";
    }

}

/**
 * @OA\Info(
 *     version="1.0",
 *     title="Blood Donation Appointment Booking API"
 * )
 */
class API
{
    private $request;
    public $response;
    private $controller;
    private $auth;
    private $jwt;

    public function __construct()
    {
    }

    public function processRequest()
    {
        $this->auth = new AuthToken();
        $requestBuilder = new RequestBuilder();
        $this->request = $requestBuilder->getRequest();
        $controllername = ucfirst($this->request->urlparams["resource"]) . "Controller";

        if (class_exists($controllername)) {
            $this->controller = new $controllername();
        } else {
            // either throw an error
            // or
            // implement a default controller
        }
        switch ($this->request->method) {
            case 'GET':
                if ($controllername == "AppointmentsController") {
                    $this->processGetUserAppointmentsResponse();
                }

                if ($controllername == "AuthController") {
                    $this->processGetAuthResponse();
                }

                if ($controllername == "HospitalsController") {
                    $this->processGetHospitalResponse();
                }

                if ($controllername == "CdnController") {
                    $this->processGetCDNResponse();
                }

                break;
            case 'POST':
                // for appointment booking
                if ($controllername == "AppointmentsController") {
                    $this->processPostResponse();
                }

                break;
            case 'PUT':
                // for modifying appointments
                if ($controllername == "AppointmentsController") {
                    $this->processPutResponse();
                }

                break;
            case 'DELETE':
                if ($controllername == "AppointmentsController") {
                    echo "HERE";
                }

                $this->processDeleteResponse();
                break;
            case 'HEAD':
                break;
            case 'OPTIONS':
                break;
        }
    }

    /**
     * @OA\Get  (
     *     tags={"Blood Donation Appointment"},
     *     path="/webservice/api/appointments/",
     *     summary="Donor's appointment",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               @OA\Property(description="client apikey", property="apikey", type="string"),
     *               @OA\Property(description="user id", property="userID", type="integer"),
     *               @OA\Property(description="donor name", property="donorname", type="string"),
     *               @OA\Property(description="date and time", property="datetime", type="string"),
     *               required={"apikey", "userID", "donorname", "datetime"}
     *             ),
     *             example={"apikey": "abc123", "userID": 1, "donorname": "Chilka Castro", "datetime": "2022-09-23 11:40"}
     *         )
     *     ),
     *     @OA\Response(response="401", description="Booking Appointment Failed"),
     *     @OA\Response(response="200", description="Booking Appointment Successful"),
     * )
     */

    public function processGetHospitalResponse()
    {

        $this->verifyAuthorizationHeader();
        // $apikey = $this->request->header['X-API-Key'];
        // Determine the reponse properties
        $header = array();
        $payload = array();
        $statuscode = 0;
        $statustext = "";
        $contenttype = "";
        $customtoken = "";

        // Get the data/resource
        $rawpayload = $this->controller->getHospitalsList();

        // Check if data  was returned: the data here is the requested resource
        // If the data is found and can be returned
        // The HTTP status code of the response should be: 200
        if (count($rawpayload) > 0) {
            $statuscode = 200;
            $statustext = "OK";
        } else {
            $statuscode = 404;
            $statustext = "Not Found";

            $rawpayload = array('message' => "No data found, possibly invalid enpoint.");
        }

        // How do we decide what is the response content-type?
        switch ($this->request->header['Accept']) {

            case 'application/json':
                // Serialize the array of objects into a JSON array
                $payload = json_encode($rawpayload);
                $contenttype = 'application/json';
                $customtoken = 'Bearer ' . $this->jwt;

                break;
            case 'application/xml':
                break;
            default:
                $payload = json_encode($rawpayload);
                $contenttype = 'application/json';
                $customtoken = 'Bearer ' . $this->jwt;
        }

        $headerfields = ['Status-Code' => $statuscode, 'Status-Text' => $statustext, 'Content-Type' => $contenttype, 'Custom-Token' => $customtoken];

        $responseBuilder = new Responsebuilder($headerfields, $payload);

        $this->response = $responseBuilder->getResponse();

        echo $this->response->payload;
    }

    /**
     * @OA\Get  (
     *     tags={"Blood Donation Appointment"},
     *     path="/webservice/api/appointments/",
     *     summary="Donor's appointment",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               @OA\Property(description="client apikey", property="apikey", type="string"),
     *               @OA\Property(description="user id", property="userID", type="integer"),
     *               @OA\Property(description="donor name", property="donorname", type="string"),
     *               @OA\Property(description="date and time", property="datetime", type="string"),
     *               required={"apikey", "userID", "donorname", "datetime"}
     *             ),
     *             example={"apikey": "abc123", "userID": 1, "donorname": "Chilka Castro", "datetime": "2022-09-23 11:40"}
     *         )
     *     ),
     *     @OA\Response(response="401", description="Booking Appointment Failed"),
     *     @OA\Response(response="200", description="Booking Appointment Successful"),
     * )
     */

    public function processGetCDNResponse()
    {

        $this->verifyAuthorizationHeader();

        // Determine the reponse properties
        $header = array();
        $payload = array();
        $statuscode = 0;
        $statustext = "";
        $contenttype = "";
        $customtoken = "";

        $rawpayload = $this->controller->getFileFromCDN();

        
        // $fileURL = $this->controller->getFileFromCDN();
        // echo "returned result" . $fileURL;

        // $rawpayload = array("fileURL" => $fileURL);

        // Get the data/resource

        // Check if data  was returned: the data here is the requested resource
        // If the data is found and can be returned
        // The HTTP status code of the response should be: 200
        if (count($rawpayload) > 0) {
            $statuscode = 200;
            $statustext = "OK";
        } else {
            $statuscode = 404;
            $statustext = "Not Found";

            $rawpayload = array('message' => "No data found, possibly invalid enpoint.");
        }

        // How do we decide what is the response content-type?
        switch ($this->request->header['Accept']) {

            case 'application/json':
                // Serialize the array of objects into a JSON array
                $payload = json_encode($rawpayload);
                $contenttype = 'application/json';
                $customtoken = 'Bearer ' . $this->jwt;

                break;
            case 'application/xml':
                break;
            default:
                $payload = json_encode($rawpayload);
                $contenttype = 'application/json';
                $customtoken = 'Bearer ' . $this->jwt;
        }

        $headerfields = ['Status-Code' => $statuscode, 'Status-Text' => $statustext, 'Content-Type' => $contenttype, 'Custom-Token' => $customtoken];

        $responseBuilder = new Responsebuilder($headerfields, $payload);

        $this->response = $responseBuilder->getResponse();

        echo $this->response->payload;
    }

    /**
     * @OA\Get (
     *     tags={"Blood Donation Appointment"},
     *     path="/webservice/api/appointments/",
     *     summary="Donor's appointment",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               @OA\Property(description="client apikey", property="apikey", type="string"),
     *               @OA\Property(description="user id", property="userID", type="integer"),
     *               @OA\Property(description="donor name", property="donorname", type="string"),
     *               @OA\Property(description="date and time", property="datetime", type="string"),
     *               required={"apikey", "userID", "donorname", "datetime"}
     *             ),
     *             example={"apikey": "abc123", "userID": 1, "donorname": "Chilka Castro", "datetime": "2022-09-23 11:40"}
     *         )
     *     ),
     *     @OA\Response(response="401", description="Booking Appointment Failed"),
     *     @OA\Response(response="200", description="Booking Appointment Successful"),
     * )
     */

    public function processGetUserAppointmentsResponse()
    {
        $this->verifyAuthorizationHeader();

        $api_key = $this->request->header['X-API-Key'];
        $user_ID = $this->request->urlparams['user_ID'];
        $appointment_ID = $this->request->urlparams['id'];

        $data = [
            'api_key' => $api_key,
            'user_ID' => $user_ID,
        ];

        // Determine the reponse properties
        $header = array();
        $payload = array();
        $statuscode = 0;
        $statustext = "";
        $contenttype = "";
        $customtoken = "";
        $rawpayload = $this->controller->getUserAppointments($data, $appointment_ID);

        // Get the data/resource

        // Check if data  was returned: the data here is the requested resource
        // If the data is found and can be returned
        // The HTTP status code of the response should be: 200
        if (count($rawpayload) > 0) {
            $statuscode = 200;
            $statustext = "OK";
        } else {
            $statuscode = 404;
            $statustext = "Not Found";

            $rawpayload = array('message' => "No data found, possibly invalid enpoint.");
        }

        // How do we decide what is the response content-type?
        switch ($this->request->header['Accept']) {

            case 'application/json':
                // Serialize the array of objects into a JSON array
                $payload = json_encode($rawpayload);
                $contenttype = 'application/json';
                $customtoken = 'Bearer ' . $this->jwt;

                break;
            case 'application/xml':
                break;
            default:
                $payload = json_encode($rawpayload);
                $contenttype = 'application/json';
                $customtoken = 'Bearer ' . $this->jwt;
        }

        $headerfields = ['Status-Code' => $statuscode, 'Status-Text' => $statustext, 'Content-Type' => $contenttype, 'Custom-Token' => $customtoken];

        $responseBuilder = new Responsebuilder($headerfields, $payload);

        $this->response = $responseBuilder->getResponse();

        echo $this->response->payload;
    }

    /**
     * @OA\Post  (
     *     tags={"Blood Donation Appointment"},
     *     path="/webservice/api/appointments/",
     *     summary="Donor's appointment",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               @OA\Property(description="client apikey", property="apikey", type="string"),
     *               @OA\Property(description="user id", property="userID", type="integer"),
     *               @OA\Property(description="donor name", property="donorname", type="string"),
     *               @OA\Property(description="date and time", property="datetime", type="string"),
     *               required={"apikey", "userID", "donorname", "datetime"}
     *             ),
     *             example={"apikey": "abc123", "userID": 1, "donorname": "Chilka Castro", "datetime": "2022-09-23 11:40"}
     *         )
     *     ),
     *     @OA\Response(response="401", description="Booking Appointment Failed"),
     *     @OA\Response(response="200", description="Booking Appointment Successful"),
     * )
     */
    public function processPostResponse()
    {

        $this->verifyAuthorizationHeader();

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);

        $header = array();
        $payload = array();
        $statuscode = 0;
        $statustext = "";
        $contenttype = "";
        $customtoken = "";

        $appointmentStatus = $this->controller->createAppointment($data);

        $rawpayload = array("appointmentStatus" => $appointmentStatus);

        if (!is_null($rawpayload)) {
            $statuscode = 200;
            $statustext = "OK";
        } else { // 0 rows in the databasse because the resource was not found
            $statuscode = 404;
            $statustext = "Not Found";
            $rawpayload = array('message' => "Possibly invalid enpoint.");
        }

        // How do we decide what is the response content-type?
        switch ($this->request->header['Accept']) { // Making sure we know what the client wants -> we are generalizing/assuming that we know that we know what the client wants back(Accept)
            case 'application/json':
                // Serialize the array of objects into a JSON array
                $payload = json_encode($rawpayload);
                $contenttype = 'application/json';
                $customtoken = 'Bearer ' . $this->jwt;
                break;

            case 'application/xml':
                break;

            default:
                $payload = json_encode($rawpayload);
                $contenttype = 'application/json';
                $customtoken = 'Bearer ' . $this->jwt;
        }
        //set up the headerfields that will be sent to the response builder
        $headerfields = ['Status-Code' => $statuscode, 'Status-Text' => $statustext, 'Content-Type' => $contenttype, 'Custom-Token' => $customtoken];

        $responseBuilder = new Responsebuilder($headerfields, $payload);

        $this->response = $responseBuilder->getResponse(); // which returns a response objec

        $responseBody = json_decode($this->response->payload);

        // for printing the payload response
        if ($responseBody->appointmentStatus) {
            echo "APPOINTMENT BOOKING SUCCESSFUL FOR " . $data['donor_Name'] . " ON " . date("F-d-Y", strtotime($data['date_Time'])) . ", " . date("h:i", strtotime($data['date_Time'])) . ", Email: " . $data['email'];
        } else {
            echo "APPOINTMENT BOOKING FAILED";
        }
    }

    /**
     * @OA\Post  (
     *     tags={"Blood Donation Appointment"},
     *     path="/webservice/api/appointments/",
     *     summary="Donor's appointment",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               @OA\Property(description="client apikey", property="apikey", type="string"),
     *               @OA\Property(description="user id", property="userID", type="integer"),
     *               @OA\Property(description="donor name", property="donorname", type="string"),
     *               @OA\Property(description="date and time", property="datetime", type="string"),
     *               required={"apikey", "userID", "donorname", "datetime"}
     *             ),
     *             example={"apikey": "abc123", "userID": 1, "donorname": "Chilka Castro", "datetime": "2022-09-23 11:40"}
     *         )
     *     ),
     *     @OA\Response(response="401", description="Booking Appointment Failed"),
     *     @OA\Response(response="200", description="Booking Appointment Successful"),
     * )
     */

    public function processPutResponse()
    {
        $this->verifyAuthorizationHeader();

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $appointment_ID = $this->request->urlparams['id'];
        echo 'this is put method in api index.php ' . $appointment_ID;
        var_dump($data);

        $header = array();
        $payload = array();
        $statuscode = 0;
        $statustext = "";
        $contenttype = "";
        $customtoken = "";

        $rawpayload = $this->controller->updateAppointment($data, $appointment_ID);

        if (!is_null($rawpayload)) {
            $statuscode = 200;
            $statustext = "OK";
            $customtoken = 'Bearer ' . $this->jwt;
        } else { // 0 rows in the databasse because the resource was not found
            $statuscode = 404;
            $statustext = "Not Found";

            $rawpayload = array('message' => "Possibly invalid enpoint.");

            $customtoken = 'Bearer ' . $this->jwt;
        }

        // How do we decide what is the response content-type?
        switch ($this->request->header['Accept']) { // Making sure we know what the client wants -> we are generalizing/assuming that we know that we know what the client wants back(Accept)
            case 'application/json':
                // Serialize the array of objects into a JSON array
                $payload = json_encode($rawpayload);
                $contenttype = 'application/json';
                $customtoken = 'Bearer ' . $this->jwt;
                break;

            case 'application/xml':
                break;

            default:
                $payload = json_encode($rawpayload);
                $contenttype = 'application/json';
                $customtoken = 'Bearer ' . $this->jwt;
        }
        //set up the headerfields that will be sent to the response builder
        $headerfields = ['Status-Code' => $statuscode, 'Status-Text' => $statustext, 'Content-Type' => $contenttype, 'Custom-Token' => $customtoken];

        $responseBuilder = new Responsebuilder($headerfields, $payload);

        $this->response = $responseBuilder->getResponse(); // which returns a response objec

        echo $this->response->payload;
    }

    /**
     * @OA\Get  (
     *     tags={"Blood Donation Appointment"},
     *     path="/webservice/api/appointments/",
     *     summary="Donor's appointment",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               @OA\Property(description="client apikey", property="apikey", type="string"),
     *               @OA\Property(description="user id", property="userID", type="integer"),
     *               @OA\Property(description="donor name", property="donorname", type="string"),
     *               @OA\Property(description="date and time", property="datetime", type="string"),
     *               required={"apikey", "userID", "donorname", "datetime"}
     *             ),
     *             example={"apikey": "abc123", "userID": 1, "donorname": "Chilka Castro", "datetime": "2022-09-23 11:40"}
     *         )
     *     ),
     *     @OA\Response(response="401", description="Booking Appointment Failed"),
     *     @OA\Response(response="200", description="Booking Appointment Successful"),
     * )
     */

    public function processDeleteResponse()
    {
        $this->verifyAuthorizationHeader();
        $appointment_ID = $this->request->urlparams['id'];

        $header = array();
        $payload = array();
        $statuscode = 0;
        $statustext = "";
        $contenttype = "";
        $customtoken = "";

        $appointmentStatus = $this->controller->deleteAppointment($appointment_ID);
        $rawpayload = array("appointmentStatus" => $appointmentStatus);

        if (!is_null($rawpayload)) {
            $statuscode = 200;
            $statustext = "OK";
            $customtoken = 'Bearer ' . $this->jwt;
        } else { // 0 rows in the databasse because the resource was not found
            $statuscode = 404;
            $statustext = "Not Found";
            $rawpayload = array('message' => "Possibly invalid enpoint.");
            $customtoken = 'Bearer ' . $this->jwt;
        }
        // How do we decide what is the response content-type?
        switch ($this->request->header['Accept']) { // Making sure we know what the client wants -> we are generalizing/assuming that we know that we know what the client wants back(Accept)
            case 'application/json':
                // Serialize the array of objects into a JSON array
                $payload = json_encode($rawpayload);
                $contenttype = 'application/json';
                $customtoken = 'Bearer ' . $this->jwt;
                break;

            case 'application/xml':
                break;

            default:
                $payload = json_encode($rawpayload);
                $contenttype = 'application/json';
                $customtoken = 'Bearer ' . $this->jwt;
        }
        //set up the headerfields that will be sent to the response builder
        $headerfields = ['Status-Code' => $statuscode, 'Status-Text' => $statustext, 'Content-Type' => $contenttype, 'Custom-Token' => $customtoken];
        $responseBuilder = new Responsebuilder($headerfields, $payload);
        $this->response = $responseBuilder->getResponse(); // which returns a response objec
        echo $this->response->payload;
    }

    public function verifyAuthorizationHeader()
    {
        try {
            $Authorization = $this->request->header["Authorization"];
            // echo $jwt;
            $this->jwt = explode(" ", $Authorization)[1];
            $apikey = $this->request->header["X-API-Key"];
            $decodedpayload = $this->auth->verifyToken($this->jwt, $apikey);
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    /**
     * @OA\Get (
     *     tags={"Blood Donation Appointment"},
     *     path="/webservice/api/appointments/",
     *     summary="Donor's appointment",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               @OA\Property(description="client apikey", property="apikey", type="string"),
     *               @OA\Property(description="user id", property="userID", type="integer"),
     *               @OA\Property(description="donor name", property="donorname", type="string"),
     *               @OA\Property(description="date and time", property="datetime", type="string"),
     *               required={"apikey", "userID", "donorname", "datetime"}
     *             ),
     *             example={"apikey": "abc123", "userID": 1, "donorname": "Chilka Castro", "datetime": "2022-09-23 11:40"}
     *         )
     *     ),
     *     @OA\Response(response="401", description="Booking Appointment Failed"),
     *     @OA\Response(response="200", description="Booking Appointment Successful"),
     * )
     */

    public function processGetAuthResponse()
    {

        $apikey = $this->request->header['X-API-Key'];
        // Determine the reponse properties
        $header = array();
        $payload = array();
        $statuscode = 0;
        $statustext = "";
        $contenttype = "";
        $customtoken = "";
        // Generate a JWT token
        $jwt_token = $this->controller->processToken($apikey);
        // Check if data  was returned: the data here is the requested resource
        // If the data is found and can be returned
        // The HTTP status code of the response should be: 200

        $logger = new Logger('JWTLogger');
        $logger->pushHandler(new StreamHandler(dirname(dirname(__FILE__)) . '/logs/info.log', Level::Info));
        $logger->pushHandler(new FirePHPHandler());

        if (!empty($jwt_token)) {
            $statuscode = 200;
            $statustext = "OK";
            $logger->info("Token is not empty. " . "JWT is: " . $jwt_token);
        } else {
            $statuscode = 401;
            $statustext = "Unauthorized";
            $logger->info("Token is empty");
        }
        // How do we decide what is the response content-type?
        switch ($this->request->header['Accept']) {
            case 'application/json':
                // Serialize the array of objects into a JSON array
                $customtoken = "Bearer " . $jwt_token;
                $contenttype = 'application/json';
                break;
            case 'application/xml':
                break;
            default:
                $customtoken = "Bearer " . $jwt_token;
                $contenttype = 'application/json';
        }
        $headerfields = [
            'Status-Code' => $statuscode, 'Status-Text' => $statustext, 'Content-Type' => $contenttype,
            'Custom-Token' => $customtoken,
        ];
        $responseBuilder = new Responsebuilder($headerfields, $payload);

        $this->response = $responseBuilder->getResponse();
    }
} // API class

$api = new API();

$api->processRequest();
