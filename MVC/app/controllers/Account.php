<?php
class Account extends Controller
{
    /*
     Default constructor for the About
     */ 
    public function __construct()
    {
    }

    /*
    Displays Account page 
     */
    public function index()
    {

        $this->view('Account/index');
                
    }
}