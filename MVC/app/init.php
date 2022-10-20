<?php 
    //adding our config file 
    require_once 'config/config.php';
    require_once 'core/helper.php';   // you need to do this because helper does not have a class -> its only a php file with method
    require_once dirname(APPROOT).'/vendor/autoload.php'; 
    
    spl_autoload_register(function($className){
        require_once 'core/'. $className .'.php';
    });