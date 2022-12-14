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
                $this->processPutResponse();
                break;
            case 'DELETE':
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
     *     tags={"Hospitals List"},
     *     path="/WebServices-Project/webservice/api/hospitals/",
     *     summary="Get Hospitals List",
     *
     *     @OA\Parameter(name="X-API-Key", in="header", required=true, description="Api key", @OA\Schema(type="string")),
     *     @OA\Response(response="401", description="Get hospitals list failed"),
     *     @OA\Response(response="200", description="Get hospitals list Successful"),
     * )
     */
    public function processGetHospitalResponse()
    {

        $this->verifyAuthorizationHeader();

        $header = array();
        $payload = array();
        $statuscode = 0;
        $statustext = "";
        $contenttype = "";
        $customtoken = "";

        // Get the data/resource
        $rawpayload = $this->controller->getHospitalsList();

        if (count($rawpayload) > 0) {
            $statuscode = 200;
            $statustext = "OK";
        } else {
            $statuscode = 404;
            $statustext = "Not Found";

            $rawpayload = array('message' => "No data found, possibly invalid enpoint.");
        }

        switch ($this->request->header['Accept']) {

            case 'application/json':
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
     *     tags={"CDN"},
     *     path="/WebServices-Project/webservice/api/cdn/",
     *     summary="Get File from CDN",
     *
     *     @OA\Parameter(name="X-API-Key", in="header", required=true, description="Api key", @OA\Schema(type="string")),
     *     @OA\Response(response="401", description="Get File from CDN failed"),
     *     @OA\Response(response="200", description="Get File from CDN Successful"),
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

        if (count($rawpayload) > 0) {
            $statuscode = 200;
            $statustext = "OK";
        } else {
            $statuscode = 404;
            $statustext = "Not Found";

            $rawpayload = array('message' => "No data found, possibly invalid enpoint.");
        }
        switch ($this->request->header['Accept']) {

            case 'application/json':
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
     *     path="/WebServices-Project/webservice/api/appointments/{appointment_ID}/?user_ID={user_ID}/",
     *     summary="Get User's Appointments or get a single appointment",
     *
     *     @OA\Parameter(name="X-API-Key", in="header", required=true, description="Api key", @OA\Schema(type="string")),
     *     @OA\Parameter(name="appointment_ID", in="path", description="Appointment ID", @OA\Schema(type="Integer")),
     *     @OA\Parameter(name="user_ID", in="path", required=true, description="User ID", @OA\Schema(type="Integer")),
     *
     *
     *     @OA\Response(response="401", description="Get appointment failed"),
     *     @OA\Response(response="200", description="Get appointment Successful"),
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

        $header = array();
        $payload = array();
        $statuscode = 0;
        $statustext = "";
        $contenttype = "";
        $customtoken = "";
        $rawpayload = $this->controller->getUserAppointments($data, $appointment_ID);

        if (count($rawpayload) > 0) {
            $statuscode = 200;
            $statustext = "OK";
        } else {
            $statuscode = 404;
            $statustext = "Not Found";

            $rawpayload = array('message' => "No data found, possibly invalid enpoint.");
        }

        switch ($this->request->header['Accept']) {
            case 'application/json':
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
     *     path="/WebServices-Project/webservice/api/appointments/",
     *     summary="Book an appointment",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *               @OA\Property(description="client apikey", property="api_Key", type="string"),
     *               @OA\Property(description="user id", property="user_ID", type="integer"),
     *               @OA\Property(description="donor name", property="donor_Name", type="string"),
     *               @OA\Property(description="date and time", property="date_Time", type="string"),
     *               @OA\Property(description="Hospital ID", property="hospital", type="integer"),
     *               @OA\Property(description="Donor's Email", property="email", type="string"),
     *               required={"apikey", "userID", "donorname", "datetime"}
     *             ),
     *             example={"api_Key": "abcd123", "user_ID": 1, "donor_Name": "Chilka Castro", "date_Time": "2022-09-23 11:40" , "hospital": 1, "email": "example@gmail.com" }
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
        } else {
            $statuscode = 404;
            $statustext = "Not Found";
            $rawpayload = array('message' => "Possibly invalid endpoint.");
        }
        switch ($this->request->header['Accept']) {
            case 'application/json':
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
     * @OA\Put(
     *   tags={"Blood Donation Appointment"},
     *   path="/WebServices-Project/webservice/api/appointments/{appointment_ID}/",
     *   summary="Update an appointment time",
     *   @OA\Parameter(name="appointment_ID", in="path", required=true, description="appointment id", @OA\Schema(type="integer")),
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/json",
     *         @OA\Schema(
     *           @OA\Property(description="api key", property="api_Key", type="string"),
     *           @OA\Property(description="data time", property="date_Time", type="string"),
     *           required={"api_Key": "abcd1234", "date_Time" :"2022-12-12 14:30"}
     *           ),
     *           example={"api_Key": "abcd123", "date_Time": "2022-09-23 11:40" }
     *       )
     *     ),
     *   @OA\Response(response="401", description="Update Appointment Failed"),
     *   @OA\Response(response="200", description="Update Appointment Successful"),
     * )
     */
    public function processPutResponse()
    {
        $this->verifyAuthorizationHeader();

        $json = file_get_contents('php://input');
        $data = json_decode($json, true);
        $appointment_ID = $this->request->urlparams['id'];

        $header = array();
        $payload = array();
        $statuscode = 0;
        $statustext = "";
        $contenttype = "";
        $customtoken = "";

        $status = $this->controller->updateAppointment($data, $appointment_ID);
        $rawpayload = array("updateStatus" => $status);

        if (!is_null($rawpayload)) {
            $statuscode = 200;
            $statustext = "OK";
            $customtoken = 'Bearer ' . $this->jwt;
        } else {
            $statuscode = 404;
            $statustext = "Not Found";
            $rawpayload = array('message' => "Possibly invalid enpoint.");
            $customtoken = 'Bearer ' . $this->jwt;
        }
        switch ($this->request->header['Accept']) {
            case 'application/json':
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
     * @OA\Delete(
     *   tags={"Blood Donation Appointment"},
     *   path="/WebServices-Project/webservice/api/appointments/{appointment_ID}/",
     *   summary="Delete an appointment",
     *   @OA\Parameter(name="appointment_ID", in="path", required=true, description="appointment id", @OA\Schema(type="integer")),
     *   @OA\Parameter(name="X-API-Key", in="header", required=true, description="api key", @OA\Schema(type="string")),

     *   @OA\Response(response="401", description="Delete Appointment Failed"),
     *   @OA\Response(response="200", description="Delete Appointment Successful"),
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
        } else {
            $statuscode = 404;
            $statustext = "Not Found";
            $rawpayload = array('message' => "Possibly invalid enpoint.");
            $customtoken = 'Bearer ' . $this->jwt;
        }

        switch ($this->request->header['Accept']) {
            case 'application/json':
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


    public function verifyAuthorizationHeader()
    {
        try {
            $Authorization = $this->request->header["Authorization"];
            $this->jwt = explode(" ", $Authorization)[1];
            $apikey = $this->request->header["X-API-Key"];
            $decodedpayload = $this->auth->verifyToken($this->jwt, $apikey);
        } catch (Exception $e) {
            echo 'Caught exception: ', $e->getMessage(), "\n";
        }
    }

    /**
     * @OA\Get(
     *     tags={"JWT Authentication"},
     *     path="/WebServices-Project/webservice/api/auth/",
     *     summary="Create JWT",
     *     security={{ "Bearer":{} }},
     *
     * @OA\Parameter(
     *     name="X-API-Key",
     *     in="header",
     *     required=true,
     *         @OA\Schema(
     *              type="http"
     *         )
     *      ),
     * @OA\SecurityScheme(
     *      securityScheme="bearerAuth",
     *      in="header",
     *      name="Authorization",
     *      type="http",
     *      scheme="Bearer",
     *      bearerFormat="JWT",
     * ),
     *     @OA\Response(response="401", description="Unauthorized"),
     *     @OA\Response(response="200", description="Success"),
     * )
     */
    public function processGetAuthResponse()
    {
        $apikey = $this->request->header['X-API-Key'];
        $header = array();
        $payload = array();
        $statuscode = 0;
        $statustext = "";
        $contenttype = "";
        $customtoken = "";

        $jwt_token = $this->controller->processToken($apikey);

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
        switch ($this->request->header['Accept']) {
            case 'application/json':
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
