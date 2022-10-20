<?php

// helper is just a php file so in the init.php we need to load it manually in the init.php
// no class because we just want to have a function 

    session_start();

    // method to check whether 
    function isLoggedIn(){
        if(isset($_SESSION['user_id'])){
          return true;
        } else {
          return false;
        }
      }

?>