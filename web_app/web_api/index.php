<?php
 
require_once './include/DbHandler.php';
require '././libs/Slim/Slim.php';
 
\Slim\Slim::registerAutoloader();
 
$app = new \Slim\Slim();


function echoRespnse($status_code, $response) {
    $app = \Slim\Slim::getInstance();
    // Http response code
    $app->status($status_code);
 
    // setting response content type to json
    $app->contentType('application/json');
    
    echo json_encode($response);
}

/**
 * Verifying required params posted or not
 */
function verifyRequiredParams($required_fields) {
    $error = false;
    $error_fields = "";
    $request_params = array();
    $request_params = $_REQUEST;
    // Handling PUT request params
    if ($_SERVER['REQUEST_METHOD'] == 'PUT') {
        $app = \Slim\Slim::getInstance();
        parse_str($app->request()->getBody(), $request_params);
    }
    foreach ($required_fields as $field) {
        if (!isset($request_params[$field]) || strlen(trim($request_params[$field])) <= 0) {
            $error = true;
            $error_fields .= $field . ', ';
        }
    }
 
    if ($error) {
        // Required field(s) are missing or empty
        // echo error json and stop the app
        $response = array();
        $app = \Slim\Slim::getInstance();
        $response["error"] = true;
        $response["message"] = 'Required field(s) ' . substr($error_fields, 0, -2) . ' is missing or empty';
        echoRespnse(400, $response);
        $app->stop();
    }
}

// get all user types in the system
$app->get('/user_types', function() use($app){
    $db = new DbHandler();
    $result = $db->get_user_types();
    echoRespnse(200, $result);
});

// get all active services in the system
$app->get('/services', function() use($app){
    $db = new DbHandler();
    $result = $db->get_active_services();
    echoRespnse(200, $result);
});
// get all active services in the system
$app->get('/organisation', function() use($app){
    $db = new DbHandler();
    $result = $db->get_active_org();
    echoRespnse(200, $result);
}); 

// generate OTP
$app->post('/generate_otp', function() use($app){
    verifyRequiredParams(array('mobile'));
    $mobile = $app->request->post('mobile');
    $db = new DbHandler();
    $result = $db->generate_otp($mobile);
    echoRespnse(200, $result);
});

// Verify OTP
$app->post('/verify_otp', function() use($app){
    verifyRequiredParams(array('mobile','otp'));
    $mobile = $app->request->post('mobile');
    $otp = $app->request->post('otp');
    $db = new DbHandler();
    $result = $db->verify_otp($mobile,$otp);
    echoRespnse(200, $result);
});


// Verify Mobile
$app->post('/verify_mobile', function() use($app){
    verifyRequiredParams(array('mobile'));
    $mobile = $app->request->post('mobile');
    $db = new DbHandler();
    $result = $db->verify_mobile($mobile);
    echoRespnse(200, $result);
});

// User Register
$app->post('/save_user', function() use($app){
     verifyRequiredParams(array('mobile', 'user_type_id','name','address','city','pincode','aadhar_number'));
     $db = new DbHandler();
     $result = $db->save_user();
     echoRespnse(200, $result);
});

// generate_QR_code
$app->get('/generate_QR_code', function() use($app){
     //verifyRequiredParams(array('code', 'color_code'));
     $db = new DbHandler();
     $result = $db->generate_QR_code();
}); 

// pass entries
$app->post('/create_user_pass', function() use($app){
     verifyRequiredParams(array('user_id', 'travel_reason','start_time','end_time','location','travel_date'));
     $db = new DbHandler();
     $result = $db->create_user_pass();
     echoRespnse(200, $result);
}); 

//list user pass entries
$app->get('/user_pass_details', function() use($app){
    verifyRequiredParams(array('pass_id'));
    $user_id = $app->request->get('pass_id');
    $db = new DbHandler();
    $result = $db->user_pass_details($user_id);
    echoRespnse(200, $result);
});

//list all passes
$app->get('/all_pass', function() use($app){
    $db = new DbHandler();
    $result = $db->all_pass();
    echoRespnse(200, $result);
});

// update pass entries
$app->post('/edit_pass', function() use($app){
     $id = $app->request->post('id');
     $user_id = $app->request->post('user_id');
     $reason = $app->request->post('reason');
     $services = $app->request->post('services');
     $start_time = $app->request->post('duration_from');
     $end_time = $app->request->post('duration_to');
     $location = $app->request->post('location');
     $db = new DbHandler();
     $result = $db->pass_entries($id,$user_id,$reason,$services,$start_time,$end_time,$location);
     echoRespnse(200, $result);
});

//save approver
$app->post('/save_approver', function() use($app){
     verifyRequiredParams(array('approver_mobile','org_name','org_type','org_location','org_email','user_type_id'));
     $db = new DbHandler();
     $result = $db->save_approver();
     echoRespnse(200, $result);
});

// approve pass count
$app->post('/approver_pass_count', function() use($app){
    verifyRequiredParams(array('green_pass_count','yellow_pass_count','approver_id'));
    $db = new DbHandler();
    $result = $db->approver_pass_count();
    echoRespnse(200, $result);
});

// generate passes
$app->post('/generate_passes', function() use($app){
    verifyRequiredParams(array('green_pass_count','yellow_pass_count','approver_id'));
    $db = new DbHandler();
    $result = $db->generate_passes();
    echoRespnse(200, $result);
});

// get approver passes
$app->post('/get_approver_passes', function() use($app){
    verifyRequiredParams(array('approver_id'));
    $approver_id = $_REQUEST['approver_id'];
    $db = new DbHandler();
    $result = $db->get_approver_passes($approver_id);
    echoRespnse(200, $result);
});

// get user details
$app->post('/get_user_details', function() use($app){
    verifyRequiredParams(array('user_id'));
    $user_id = $_REQUEST['user_id'];
    $db = new DbHandler();
    $result = $db->get_user_details($user_id);
    echoRespnse(200, $result);
});

//list all approver organisations
$app->get('/all_approver_organisations', function() use($app){
    $db = new DbHandler();
    $result = $db->get_active_approvers();
    echoRespnse(200, $result);
});

//validate approver
$app->post('/validate_approver', function() use($app){
     verifyRequiredParams(array('approver_id','approver_mobile','user_type_id'));
    $approver_id = $_REQUEST['approver_id'];
    $approver_mobile = $_REQUEST['approver_mobile'];
    $user_type_id = $_REQUEST['user_type_id'];
    $db = new DbHandler();
    $result = $db->validate_approver($approver_mobile,$approver_id,$user_type_id);
    echoRespnse(200, $result);
});

// get approver details

$app->post('/get_approver_details', function() use($app){
     verifyRequiredParams(array('approver_id'));
    $approver_id = $_REQUEST['approver_id'];
    $db = new DbHandler();
    $result = $db->get_approver_details($approver_id);
    echoRespnse(200, $result);
});


$app->post('/update_leave_status', function() use($app){
     verifyRequiredParams(array('travel_status','pass_id'));
    $pass_id = $_REQUEST['pass_id'];
    $travel_status = $_REQUEST['travel_status'];
    $db = new DbHandler();
    $result = $db->update_leave_status($pass_id,$travel_status);
    echoRespnse(200, $result);
});


$app->run();
?>
