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
$app->post('/register', function() use($app){
     verifyRequiredParams(array('mobile', 'user_type_id'));
     $db = new DbHandler();
     $result = $db->register();
     echoRespnse(200, $result);
});

// generate_QR_code
$app->get('/generate_QR_code', function() use($app){
     verifyRequiredParams(array('code', 'color_code'));
     $db = new DbHandler();
     $result = $db->new_QR_code();
});

$app->run();
?>
