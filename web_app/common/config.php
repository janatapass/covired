<?php
date_default_timezone_set('Asia/Kolkata');
$website_url = 'PROJECT LOCATION HERE';
$host = "localhost";
$dbuser = "DB_USER";
$dbpsw = "DB_PASSWORD";
$dbname = "DB_NAME";   
// Payumoney details
//$_MERCHANT_KEY = '6u9dOJzc';
//$_MERCHANT_SALT = '5SBiSLvFPH';
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpsw);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>