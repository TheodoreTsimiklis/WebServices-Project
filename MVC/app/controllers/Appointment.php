<?php
class Appointment extends Controller
{
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
        $this->view('Appointment/index');

    }
}