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

        // echo "this is indix function, u better fucing diusplay this "; 
        if(!isset($this->jwt)) { //  avoids regenerating jwt again 
            // generate token first 
            $this->generateToken();
            echo "this is indix function, u better fucing diusplay this "; 
        }            
        // if you have the jwt already
        else {
            // go to the view page and send the list of hospitals
            if (isset($_POST['submit'])) {  // POST : clcked Book an appointment button
                $this->createAppointment();
            }
            else { 
                echo "enter here";  // GET HOSPITALS
                // $data for all the hospital
                // get hospitals list and put it in an array and then send it on the view
                $data = $this->getHospitalList();

                $this->view('Appointment/index', $data); // keep showing this page
                echo "Please enter your name and appointment date and time.";
                // echo $data;
            }
        }
    }

    /*
        Retrieve all the hospitals in the web service 
     */
    public function getHospitalList() {
        $url = "http://localhost/WebServices-Project/webservice/api/hospitals/";
        $ch = curl_init();
        $data = array(
            'Accept: application/json',
            'Content-Type: application/json',
            'Authorization: ' . $this->jwt,
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
        var_dump($response);
        
        return $response;
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

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json", 'Accept: application/json', 'Expect:', 'Content-Length: ' . strlen($data), 'Authorization: ' . $this->jwt, 'X-API-Key: abcd123'));

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

        $headers = $this->get_headers_from_curl_response($response);
        $this->jwt = $headers["Custom-Token"];

    }

    public function get_headers_from_curl_response($response)
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

    
    public function view_appointments()
    {
        $this->view('Appointment/view_appointments');

    }
}