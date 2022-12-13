<?php
class Dashboard extends Controller
{
    /*
     Default constructor for the Dashboard
     */ 
    public function __construct()
    {
        if(!isLoggedIn()){
            header('Location: /WebServices-Project/MVC/Login');
        }
    }

    /*
    Displays Dashboard page 
     */
    public function index()
    {
        $this->view('Dashboard/index');

    }
}