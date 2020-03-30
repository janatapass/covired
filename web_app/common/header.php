<?php
include 'common/session_start.php';
include_once ('web_api/include/DbHandler.php');
//include 'common/action.php'; 
$DbHandler = new DbHandler();
?>
<!--header-->
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Janata Pass</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/iziToast.min.css">
      <link rel='stylesheet' href='css/datepicker.css'>
      <link rel="stylesheet" href="css/main.css">
   </head>
<body>