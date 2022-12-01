<?php
class accountModel{
    public function __construct(){
        $this->db = new Model;
    }

    public function getPersonalInfo(){
        $this->db->query("SELECT firstname,lastname,email FROM user");
        return $this->db->getResultSet();
    }
}
?>