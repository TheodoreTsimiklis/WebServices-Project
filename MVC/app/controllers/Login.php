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
    public function index()
    {
        if(!isset($_POST['login'])){
            $this->view('Login/index');
        }
        else{
            $user = $this->loginModel->getAccount($_POST['email']);
            
            if($user != null){
                $hashed_pass = $user->pass_hash;
                $password = $_POST['password'];
                if(password_verify($password,$hashed_pass)){
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
                $this->view('Login/index',$data);
            }
        }
    }

    public function signup()
    {
        if(!isset($_POST['signup'])){
            $this->view('Login/signup');
        }
        else{
            $user = $this->loginModel->getAccount($_POST['email']);
            if($user == null){
                $data = [
                    'email' => trim($_POST['email']),
                    'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
                    'firstname' => trim($_POST['firstname']),
                    'lastname' => trim($_POST['lastname']),
                ];
                if($this->loginModel->createAccount($data)){
                        echo 'Please wait creating the account for '.trim($_POST['firstname']);
                        echo '<meta http-equiv="Refresh" content="2; url=/MVC/Login/">';      
                }
            }
            else{
                $data = [
                    'msg' => "Account: ". $_POST['email'] ." already exists",
                ];
                $this->view('Login/create',$data);
            }
            
        }
    }

    public function createSession($user){
        $_SESSION['user_id'] = $user->userID;
        $_SESSION['email'] = $user->email;
    }

    public function logout(){
        unset($_SESSION['user_id']);
        session_destroy();
        echo '<meta http-equiv="Refresh" content="1; url=/MVC/Login/">';   

    }
}
