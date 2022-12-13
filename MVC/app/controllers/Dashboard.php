<?php
class Dashboard extends Controller
{
    /*
     Default constructor for the About
     */ 
    public function __construct()
    {
        if(!isLoggedIn()){
            header('Location: /WebServices-Project/MVC/Login');
        }
    }

    /*
    Displays About page (who we are information)
     */
    public function index()
    {
        $this->view('Dashboard/index');

    }
}