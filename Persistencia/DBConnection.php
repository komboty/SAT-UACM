<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
Class Connection{
    private $connection;
    
    function __construct() {    
        
         // Load configuration as an array. Use the actual location of your configuration file
        //$config = parse_ini_file('../config.ini'); 
       
            $this->connection = mysqli_connect('sql3.freemysqlhosting.net','sql3208221','lPMsPBIfZs','sql3208221');
          
    }

    function db_connect() {

    // Define connection as a static variable, to avoid connecting more than once 
    
        
    // Try and connect to the database, if a connection has not been established yet
        if(!isset($this->connection)) {
         // Load configuration as an array. Use the actual location of your configuration file
        //$config = parse_ini_file('../config.ini'); 
       
            $this->connection = mysqli_connect('sql3.freemysqlhosting.net','sql3208221','lPMsPBIfZs','sql3208221');
        }

    // If connection was not successful, handle the error
        if($this->connection === false) {
        // Handle error - notify administrator, log to a file, show an error screen, etc.
            return mysqli_connect_error(); 
        }
        return $this->connection;
    }
    
    function db_query($query) {
    // Connect to the database
    

    // Query the database
    $result = mysqli_query($this->connection,$query);

    return $result;
    }
    
    function db_error() {
        $this->connection = db_connect();
        return mysqli_error($connection);
    }
}

?>
