<?php
use Monolog\Level;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

class Login extends Controller
{
    public function __construct()
    {
        $this->loginModel = $this->model('loginModel');
    }

    // default method of the Login page
    public function index() // logs in user
    {
        if(!isset($_POST['login'])){
            $this->view('Login/index');
        }
        else{
            $user = $this->loginModel->getAccount($_POST['email']);
            
            if($user != null){
                $password = $_POST['password'];
                if($password){
                    //echo '<meta http-equiv="Refresh" content="2; url=/MVC/">';
                    $this->createSession($user);
                    $data = [
                        'msg' => "Welcome, $user->firstname!",
                    ];
                    $this->view('Home/index',$data);
                
                    /*
                    // LOGGING
                    // Create the logger
                    $logger = new Logger('my_logger');
                    // Now add some handlers
                    $logger->pushHandler(new StreamHandler(dirname(dirname(__FILE__)).'/logs/conversionlog.log', Level::Debug));
                    $logger->pushHandler(new FirePHPHandler());

                    // You can now use your logger
                    $logger->info($user->username.' logged in successfully');
                    */
                }
                else{
                    $data = [
                        'msg' => "Password incorrect! for $user->email",
                    ];
                    $this->view('Login/index',$data);
                }
            }
            else{
                $data = [
                    'msg' => "User: ". $_POST['email'] ." does not exists",
                ];
                $this->view('Login/signup',$data);
            }
        }
    }

    public function signup() // creates account
    {
        if(!isset($_POST['signup'])){
            $this->view('Login/signup');
        }
        else{
            $user = $this->loginModel->getAccount($_POST['email']);
            if($user == null){
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => trim($_POST['password'], PASSWORD_DEFAULT),
                    'firstname' => trim($_POST['firstname']),
                    'lastname' => trim($_POST['lastname']),
                ];
                if($this->loginModel->createAccount($data)){
                        echo 'Please wait creating the account for '.trim($_POST['firstname']);
                        echo '<meta http-equiv="Refresh" content="2; url='.URLROOT.'/MVC/Login/">';      
                }
            }
            else{
                $data = [
                    'msg' => "Account: ". $_POST['email'] ." already exists",
                ];
                $this->view('Login/signup',$data);
            }
            
        }
    }

    public function createSession($user){
        $_SESSION['user_id'] = $user->userID;
        $_SESSION['name'] = $user->firstname . ' ' . $user->lastname;
        $_SESSION['email'] = $user->email;
    }

    public function logout(){
        unset($_SESSION['user_id']);
        session_destroy();
        echo '<meta http-equiv="Refresh" content="1; url='.URLROOT.'/Login/index">';   

    }
}
