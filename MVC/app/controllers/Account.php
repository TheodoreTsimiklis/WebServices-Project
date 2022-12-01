<?php
class Account extends Controller
{
    /*
     Default constructor for the About
     */ 
    public function __construct()
    {
        $this->accountModel = $this->model('accountModel');
    }

    /*
    Displays About page (who we are information)
     */
    public function index()
    {

       if (!isset($_POST['myAccount'])) {
            $this->view('Account/index');
       } 
       else {
        $info = $this->accountModel->getPersonalInfo();
        if ($info == null) {
            $this->createSession($info);
            $data = [
                'fname' => $info->firstname,
                'lname' => $info->lastname,
                'email' => $info->email
            ];
            $this->view('Account/index',$data);
                
        }
        }
    }

    public function createSession($info){
        $_SESSION['email'] = $info->email;
        $_SESSION['fname'] = $info->firstname;
        $_SESSION['lname'] = $info->lastname;
    }

}