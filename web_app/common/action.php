<?php
date_default_timezone_set('Asia/Kolkata');

include_once ('../web_api/include/DbHandler.php'); 
$DbHandler = new DbHandler();
$action = isset($_POST['action']) ? $_POST['action'] : "";

switch($action){
    case 'verify_mobile':
        $mobile = $_REQUEST['mobile'];
        $DbHandler->verify_mobile($mobile);
   	break;
    case 'generate_otp':
        $mobile = $_REQUEST['mobile'];
        $DbHandler->generate_otp($mobile);
   	break;
    case 'verify_otp':
        $mobile = $_REQUEST['mobile'];
        $otp = $_REQUEST['otp'];
        $DbHandler->verify_otp($mobile,$otp);
   	break;

}
//$response = $obj->utf8_converter($response);
//$returnresponse = json_encode($response,JSON_HEX_QUOT);
//echo $returnresponse;
//die($returnresponse);	

?>