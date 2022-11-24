<?php
class Appointment extends Controller
{
    /*
     Default constructor for the About
     */ 
    public function __construct()
    {
    }

    /*
    Displays About page (who we are information)
     */
    public function index()
    {
        $this->view('Appointment/index');

    }
}