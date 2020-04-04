<?php
date_default_timezone_set('Asia/Kolkata');
$website_url = 'https://fatneedle.com/janata_pass/Application/';
$host = "localhost";
$dbuser = "fatnejjj_janata";
$dbpsw = "JanataPass@123";
$dbname = "fatnejjj_janatapass";   
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