<?php
class loginModel{
    public function __construct(){
        $this->db = new Model;
    }
    
    public function getAccount($email){
        $this->db->query("SELECT * FROM user WHERE email = :email");
        $this->db->bind(':email',$email);
        return $this->db->getSingle();
    }

    public function createAccount($data){
        $this->db->query("INSERT INTO user (email, password, firstname, lastname) values (:email, :password, :firstname, :lastname)");
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':firstname', $data['firstname']);
        $this->db->bind(':lastname', $data['lastname']);


        if($this->db->execute()){
            return true;
        }
        else{
            return false;
        }

    }
}
?>