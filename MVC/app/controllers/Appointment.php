<?php
class Appointment extends Controller
{
    private $jwt;
    /*
     Default constructor for the About
     */ 
    public function __construct()
    {
        // if(!isLoggedIn()){
        //     header('Location: /MVC/Login');
        // }
    }

    /*
        Displays About page (who we are information)
    */
    public function index()
    {   
        if(!isset($this->jwt)) { //  avoids regenerating jwt again 
            // generate token first 
            $this->generateToken();
        }            
        
        // if you have the jwt already
        else {
            // get hospitals list and put it in an array and then send it on the view

            //$data

            // go to the view page and send the list of hospitals
            if (isset($_POST['submit'])) {
                $this->createAppointment();
            }
            else { 
                // $data for all the hospital

                $this->view('Appointment/index'); // keep showing this page
                echo "Please enter your name and appointment date and time.";
            }
        }
    }

    /*
        Retrieve all the hospitals in the web service 
     */
    public function getHospitalList() {
        $url = "http://localhost/WebServices-Project/webservice/hospital/";
        $ch = curl_init();
        $data = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'X-API-Key: abcd123');

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $data);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Retudn headers seperatly from the Response Body

        $response = curl_exec($ch);
        // $info = curl_getinfo($ch);
    }
    /*
        Creates a POST request to create an appointment in the web service
     */
    public function createAppointment() {
        $ch = curl_init();
        $url = "http://localhost/WebServices-Project/webservice/api/appointments/"; // set url
        $data = json_encode(array(
            "api_Key" => "abcd123",
            "user_ID" =>  $_SESSION['user_id'],
            "donor_Name" => $_SESSION['name'],
            "date_Time" => $_POST['appointmenttime'], //using this date and time for now since there is no form created yet
        )); 

        curl_setopt($ch, CURLOPT_URL,$url); 

        curl_setopt($ch, CURLOPT_POST, 1);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json", 'Accept: application/json', 'Expect:', 'Content-Length: ' . strlen($data), 'Authorization: ' . $jwt, 'X-API-Key: abcd123'));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Execute
        $response = curl_exec($ch);
        if( $response != null || $response != FALSE || $response != '' ) {
            echo $response;
        // Closing the connection
        curl_close($ch);
        }
    }

    /*
        Generates a token by asking the web service to generate it
     */
    public function generateToken() {
        // CURL CODE REQUESTING ALL THE HOSPITALS
        $url = "http://localhost/WebServices-Project/webservice/api/auth/";
        $ch = curl_init();
        $data = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'X-API-Key: abcd123');

        //return the transfer as a string
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $data);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Retudn headers seperatly from the Response Body

        $response = curl_exec($ch);
        $info = curl_getinfo($ch);

        $headers = get_headers_from_curl_response($response);

        function get_headers_from_curl_response($response)
        {
            $headers = array();

            $header_text = substr($response, 0, strpos($response, "\r\n\r\n"));

            foreach (explode("\r\n", $header_text) as $i => $line)
                if ($i === 0)
                    $headers['http_code'] = $line;
                else
                {
                    list ($key, $value) = explode(': ', $line);

                    $headers[$key] = $value;
                }

            return $headers;
        }
    
    // echo "FROM CLIENT SIDE: " . $headers["WWW-Authenticate"];
    $this->jwt = $headers["WWW-Authenticate"];
    }

    public function view_appointments()
    {
        $this->view('Appointment/view_appointments');

    }
}