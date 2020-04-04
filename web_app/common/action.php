<?php
date_default_timezone_set('Asia/Kolkata');

include_once ('../web_api/include/DbHandler.php'); 
$DbHandler = new DbHandler();
$action = isset($_REQUEST['action']) ? $_REQUEST['action'] : "";
//print_r($_REQUEST);
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
    case 'save_approver':
        $DbHandler->save_approver();
   	break;
    case 'approver_pass_count':
        $DbHandler->approver_pass_count();
   	break;
    case 'validate_approver':
        $DbHandler->validate_approver($_REQUEST['approver_mobile'],$_REQUEST['approver_id'],$_REQUEST['user_type_id']);
   	break;
    case 'register':
        $DbHandler->save_user($_REQUEST['approver_mobile'],$_REQUEST['approver_id']);
   	break;
    case 'create_user_pass':
        $DbHandler->create_user_pass();
   	break;   	
    case 'share_trip_details':
         $share_mobile = $_REQUEST['share_mobile'];
         $share_name = $_REQUEST['share_name'];
         $pass_id = $_REQUEST['pass_id'];
         $user_id = $_REQUEST['user_id'];
        $DbHandler->share_trip_details($share_name,$pass_id,$share_mobile,$user_id);
   	break; 
   	case 'get_locality_names':
   	    $city_name = $_REQUEST['city_name'];
        $DbHandler->get_locality_names($city_name);
   	break; 
    case 'save_birthmark':
        $DbHandler->save_birthmark();
   	break;
}
//$response = $obj->utf8_converter($response);
//$returnresponse = json_encode($response,JSON_HEX_QUOT);
//echo $returnresponse;
//die($returnresponse);	

?>