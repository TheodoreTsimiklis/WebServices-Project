<?php
class Appointment extends Controller
{
    private $jwt;
    /*
     Default constructor for the About
     */ 
    public function __construct()
    {
        $this->loginModel = $this->model('loginModel');
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
        if (isset($this->jwt)) {    
            // echo $this->jwt;
            // go to the view page and send the list of hospitals
            
            if (isset($_POST['submit'])) {  // POST : clicked Book an appointment button
                // echo "goes here";
                $data = $this->createAppointment();
                $this->view('Appointment/appointment_status', $data);

            }
            else { 
                // $data for all the hospital
                // get hospitals list and put it in an array and then send it on the view
                $data = $this->getHospitalList();

                $this->view('Appointment/index', $data); // keep showing this page
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
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Retudn headers seperatly from the Response Body

        $response = curl_exec($ch);
        // $data = json_decode($response, TRUE);
        // var_dump($data);
        return $response;

        // $info = curl_getinfo($ch);
    }
    /*
        Creates a POST request to create an appointment in the web service
     */
    public function createAppointment() {
        $ch = curl_init();
        $url = "http://localhost/WebServices-Project/webservice/api/appointments/"; // set url
        
        // get user email
        $email = $this->loginModel->getEmail($_SESSION['user_id']);

        $data = json_encode(array(
            "api_Key" => "abcd123",
            "user_ID" =>  $_SESSION['user_id'],
            "donor_Name" => $_SESSION['name'],
            "date_Time" => $_POST['datetime'],
            "hospital" => $_POST['hospital'], //using this date and time for now since there is no form created yet
            "email" => $email,
        ));
        // var_dump($data);

        curl_setopt($ch, CURLOPT_URL,$url); 

        curl_setopt($ch, CURLOPT_POST, 1);
        
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);

        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-type: application/json", 'Accept: application/json', 'Expect:', 'Content-Length: ' . strlen($data), 'Authorization: ' . $this->jwt, 'X-API-Key: abcd123'));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        
        // Execute
        $response = curl_exec($ch);
        // if( $response != null || $response != FALSE || $response != '' ) {
        //     echo $response;
        // // Closing the connection
        // curl_close($ch);
        // }

        curl_close($ch);

        return $response;
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