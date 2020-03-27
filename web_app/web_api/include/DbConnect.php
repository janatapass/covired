<?php

class DbConnect {
 
    private $conn;
 
    function __construct() {        
    }
 
    
    function connect() {
        include_once 'Config.php';
        
        try {
            $this->conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" .DB_NAME . "", DB_USERNAME, DB_PASSWORD);
            
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8");
            //return "Connected successfully"; 
            
            return $this->conn;
            }
        catch(PDOException $e)
            {
            return "Connection failed: " . $e->getMessage();
            }
    }
 
}
?>