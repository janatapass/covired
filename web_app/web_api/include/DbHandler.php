<?php
    
//include_once './rpay/vendor/autoload.php';
//use Razorpay\Api\Api;
include_once 'phpqrcode.php';
class DbHandler {

    private $conn;
    private $tax = 18;
    private $api;

    function __construct() {
        require_once 'DbConnect.php';
        $db = new DbConnect();
        $this->conn = $db->connect();
    }


/* Generate access Token */

function getToken($length){
     $token = "";
     $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
     $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
     $codeAlphabet.= "0123456789";
     $max = strlen($codeAlphabet); // edited

    for ($i=0; $i < $length; $i++) {
        $token .= $codeAlphabet[mt_rand(0, $max-1)];
    }
    return $token;
}

function verifyToken($id, $token) {
    $sql = "SELECT id FROM users WHERE id = $id AND access_token = '$token'";
	$stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
	$stmt->execute();
	$row = $stmt->fetch();
    if($row){
        return true;
    }else {
        return false;
    }
}


// get active user types in the system
function get_user_types(){
	$response=array();
    $r = array();
    $sql = "SELECT * FROM user_type WHERE status=1";
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $stmt->execute();
    $rows = $stmt->fetchALL();    
    if(count($rows)>0) {
        $response['status'] = 1;
        $response['message'] = "success";
        $response['data'] = $rows;
    }else{
		$response['status'] = 0;
    $response['message'] = "User type not found";
	}
    return $response;
}


// get active services in the system
function get_active_services(){
	 $response=array();
	   $r = array();
        $sql = "SELECT services.name as service_name, user_categories.name as user_category FROM services join user_categories on user_categories.id = services.user_category_id WHERE services.status=1";
        $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
        $stmt->execute();
        $rows = $stmt->fetchALL();    
        if(count($rows)>0) {
            $response['status'] = 1;
            $response['message'] = "success";
            $response['data'] = $rows;
        }else{
			$response['status'] = 0;
	    $response['message'] = "Services not found";
		}
    return $response;
}

// Log the SMS trigger
public function insert_sms_log($data){
    //print_r($data);
    $mobile = $data['mobile'];
    $otp = $data['otp'];
    $response = $data['response'];
    $message =  $data['message'];
    $status = $data['status'];
    $sql3 = "INSERT INTO sms_log (mobile, otp, response, status,message) VALUES (?,?,?,?,?)";
    $stmt3= $this->conn->prepare($sql3);
   
    $stmt3->execute([$mobile, $otp, $response, $status,$message]);
    if($stmt3){
        $arr_response['status'] = 1;
		$arr_response['message'] = "Registered OTP sent Successfully - ".$otp;
    }else{
        $arr_response['status'] = 0;
        $arr_response['message'] = "Data insert error !";
    }
//    echo json_encode($arr_response);
    return $arr_response;
    
}

// SMS Gateway - Trigger SMS
public function sendsms($mobile,$message,$otp){
    $arr_sms['mobile'] = $mobile = $mobile;
    $arr_sms['otp'] = $otp;
    $arr_sms['message'] = $message = urlencode($message);
	 // Account details
	$apiKey = '356A4aLR5nCe2m5e7da678P44';
	// Message details
	$sender = 'Janata';
	$message = rawurlencode($message);
	// Prepare data for POST request
    $data = "authkey=".$apiKey."&mobiles=91".$mobile."&message=".$message."&sender=Janata&route=4&country=0";
	// Send the POST request with cURL
	$ch = curl_init('http://sms.vngsms.in/api/sendhttp.php?');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//$response = curl_exec($ch);
	$response = 'test response';
	$arr_sms['response'] = $response;
	$arr_sms['status'] = 1;
	$arr_response = $this->insert_sms_log($arr_sms);
	curl_close($ch);
	return $arr_response;
}
	
// Generate OTP & send SMS
function generate_otp($mobile){
    //$mobile ='9538131315';
    //$message = 'this is test message for janatapass';
    $otp = mt_rand(1000, 9999);
	$message = "Your OTP for Janata Pass Registration  is ".$otp;
	$arr_response = $this->sendsms($mobile,$message,$otp); // send registration otp    
	return $arr_response;
	//echo json_encode($arr_response);
}


// verify OTP 
function verify_otp($mobile,$otp){
    $sql = "SELECT * FROM sms_log WHERE status='1' AND mobile='".$mobile."' AND otp ='".$otp."'";
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $stmt->execute();
   	$row = $stmt->fetch();
   	$count = $stmt->rowCount();
   	if($count!="" && $count!=0){
   	    $sql2 = "UPDATE sms_log SET status=? WHERE id=?";
        $this->conn->prepare($sql2)->execute([0, $row['id']]);
        $response['status']=1;
        $response['message'] =' OTP Verified Successfully!';
   	}else{
   	     $response['status']=0;
        $response['message'] =' Entered OTP is invalid!';
   	}
   echo json_encode($response);
}

// verify mobile
function verify_mobile($mobile){
    $sql = "SELECT * FROM users WHERE status='1' AND mobile='".$mobile."'";
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $stmt->execute();
   	$row = $stmt->fetch();
   	$count = $stmt->rowCount();
   /*	if($count!="" && $count!=0){
        $response['status']=1;
        $response['message'] ='Mobile Number already registered with Janata Pass!';
        $response['user_id'] = $row['id'];
       // echo json_encode($response);
   	}else{*/
   	   
   	   // $response['success']=0;
        //$response['message'] ='Please enter a valid OTP!';
        $response = $this->generate_otp($mobile);
         $response['user_id'] = $row['id'];
   //	}
   echo json_encode($response);	
   
}

// register user 
function register(){
    $arr_fields = array('mobile','user_type_id','name','aadhar_number','user_category_id','qr_code','approver_id','city','address','pincode','user_proof','services');
	foreach($arr_fields as $field){
		$arr_data[$field] = $_REQUEST[$field];
	}
	if(!isset($arr_data['qr_code'])){
	    $arr_data['qr_code'] = $arr_data['mobile'].substr(md5(microtime()),rand(0,26),5);
	}
	if(is_array($arr_data) && count($arr_data)!=0){
	    $arr_data['status'] = $arr_data['is_active'] = 1;
	    $arr_data['cby'] = $arr_data['mby'] = 1;
	    $arr_data['cdate'] = $arr_data['mdate'] = date('y-m-d h:d:i');
    	$str_fields = implode(",",array_keys($arr_data));
    	$str_values = implode("','",array_values($arr_data));  
        
    	$sql3 = $this->conn->prepare("INSERT INTO users (".$str_fields.") VALUES ('".$str_values."')");
    	$sql3->execute();
    	$last_inserted_id = $this->conn->lastInsertId();
    	if($_REQUEST['pass_id']!=""&& $_REQUEST['pass_id']!=0){
        	$arr_user['assigned_user_id'] = $last_inserted_id;
        	$arr_user['pass_id'] = $_REQUEST['pass_id'];
    	}
    	$this->update_pass_status($arr_user);
        if($last_inserted_id!='' && $last_inserted_id!=0){
            $arr_response['status'] = 1;
    		$arr_response['message'] = "User Registered Successfully!";
    		$arr_response['user_id'] = $last_inserted_id;
        }else{
            $arr_response['status'] = 0;
            $arr_response['message'] = "Error when trying to create user !";
        }
        echo json_encode($arr_response);
	}
}

function update_pass_status($arr_user){
    $sql2 = "UPDATE approver_pass_details SET pass_status='A', assigned_user_id=".$arr_user['assigned_user_id']." WHERE id=".$arr_user['pass_id'];
    $this->conn->prepare($sql2)->execute();
}

function create_approver_user($arr_data){
    if(is_array($arr_data) && count($arr_data)!=0){
	    $arr_data['status'] = $arr_data['is_active'] = 1;
	    $arr_data['cby'] = $arr_data['mby'] = 1;
	    $arr_data['cdate'] = $arr_data['mdate'] = date('y-m-d h:d:i');
        $arr_data['qr_code'] = $arr_data['mobile'].substr(md5(microtime()),rand(0,26),5);
        $arr_data['user_category_id'] = 1;
    	$str_fields = implode(",",array_keys($arr_data));
    	$str_values = implode("','",array_values($arr_data));  
    	$sql3 = $this->conn->prepare("INSERT INTO users (".$str_fields.") VALUES ('".$str_values."')");
    	$sql3->execute();
    	$last_inserted_id = $this->conn->lastInsertId();
    	return $last_inserted_id;
    }
}


function save_approver(){
    $arr_user['mobile'] = $_REQUEST['approver_mobile'];
    $arr_user['user_type_id'] = $_REQUEST['user_type_id'];
    $arr_user['name'] = $_REQUEST['org_name'];
    $arr_user['address'] = $_REQUEST['org_location'];
    $arr_user['user_email'] = $_REQUEST['org_email'];
    
    $arr_fields = array('approver_mobile','org_name','org_type','org_location','org_email','user_type_id');
	foreach($arr_fields as $field){
		$arr_data[$field] = $_REQUEST[$field];
	}
	//print_r($arr_data);exit;
	if(is_array($arr_data) && count($arr_data)!=0){
	    $arr_data['status'] = $arr_data['is_active'] = 1;
	    $arr_data['cby'] = $arr_data['mby'] = 1;
	    $arr_data['cdate'] = $arr_data['mdate'] = date('y-m-d h:d:i');
    	$str_fields = implode(",",array_keys($arr_data));
    	$str_values = implode("','",array_values($arr_data));  
    	$sql3 = $this->conn->prepare("INSERT INTO approver_details (".$str_fields.") VALUES ('".$str_values."')");
    	$sql3->execute();
    	$last_inserted_id = $this->conn->lastInsertId();
    	$arr_user['approver_id'] = $last_inserted_id;
        if($last_inserted_id!='' && $last_inserted_id!=0){
            $arr_response['user_approver_id'] = $this->create_approver_user($arr_user);
            $arr_response['status'] = 1;
    		$arr_response['message'] = "Approver Registered Successfully!";
    		$arr_response['approver_id'] = $last_inserted_id;
        }else{
            $arr_response['status'] = 0;
            $arr_response['message'] = "Error when trying to create approver !";
        }
        
        echo json_encode($arr_response);
	}
}


// update approver pass count 
public function approver_pass_count(){
    $green_pass_count = $_REQUEST['green_pass_count'];
    $yellow_pass_count = $_REQUEST['yellow_pass_count'];
    $approver_id = $_REQUEST['approver_id'];
    $sql2 = "UPDATE approver_details SET green_pass_count=? , yellow_pass_count =?  WHERE id=?";
    if($this->conn->prepare($sql2)->execute([$green_pass_count, $yellow_pass_count,$approver_id])){
        $arr_response = $this->generate_passes();
       // $arr_response['status'] = 1;
	//	$arr_response['message'] = "approve pass count updated!";
		$arr_response['approver_id'] = $approver_id;
    }else{
        $arr_response['status'] = 0;
        $arr_response['message'] = "Error when trying to update pass count !";
    }
    echo json_encode($arr_response);

}

// create pass entry  
public function create_pass_entry($arr_pass,$approver_id){
    $arr_fields = array('pass_type','qr_code');
	foreach($arr_fields as $field){
		$arr_pass[$field] = $arr_pass[$field];
	}
	if(is_array($arr_pass) && count($arr_pass)!=0){
	    $arr_pass['approver_id'] = $approver_id;
        $arr_pass['pass_status'] = 'O';
        $arr_pass['is_active'] = 1;
        $arr_pass['cby'] = $arr_pass['mby'] = 1;
        $arr_pass['cdate'] = $arr_pass['mdate'] = date('y-m-d h:d:i');
    	$str_fields = implode(",",array_keys($arr_pass));
    	$str_values = implode("','",array_values($arr_pass));  
    	$sql3 = $this->conn->prepare("INSERT INTO approver_pass_details (".$str_fields.") VALUES ('".$str_values."')");
    	$sql3->execute();
    	$last_inserted_id = $this->conn->lastInsertId();
    	return $last_inserted_id;
    }
}

// generate approver passes
public function generate_passes(){
    $green_pass_count = $_REQUEST['green_pass_count'];
    $yellow_pass_count = $_REQUEST['yellow_pass_count'];
    $approver_id = $_REQUEST['approver_id'];
   
    for($i=1;$i<=$green_pass_count;$i++){
        $arr_pass['pass_type'] = 'G';
        $arr_pass['qr_code'] = substr(md5(microtime()),rand(0,26),5);
        $arr_pass_ids[] = $this->create_pass_entry($arr_pass,$approver_id);
    }
    
    for($j=1;$j<=$yellow_pass_count;$j++){
        $arr_pass['pass_type'] = 'Y';
        $arr_pass['qr_code'] = substr(md5(microtime()),rand(0,26),5);
        $arr_pass_ids[] = $this->create_pass_entry($arr_pass,$approver_id);
    }
    if(is_array($arr_pass_ids) && count($arr_pass_ids)!=0){
        $arr_response['status'] = 1;
		$arr_response['message'] = "passes generated Successfully!";
    }else{
        $arr_response['status'] = 0;
        $arr_response['message'] = "Error when trying to create user !";
    }
   // echo json_encode($arr_response);
   return $arr_response;
}

// get all approver passes
function get_approver_passes($approver_id,$status=''){
	 $response=array();
	   $r = array();
        $sql = "SELECT * FROM approver_pass_details WHERE approver_id=".$approver_id;
        if($status!=""){
            $sql .= ' AND pass_status="'.$status.'"';
        }
        $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
        $stmt->execute();
        $rows = $stmt->fetchALL();    
        if(count($rows)>0) {
            $response['status'] = 1;
            $response['message'] = "success";
            $response['data'] = $rows;
        }else{
			$response['status'] = 0;
	    $response['message'] = "Passes not found";
		}
    return $response;
} 

function check_appr($organisation_id,$arr_mobile)
{
   $response=array();
   
        $sql = "SELECT * FROM approver_details WHERE id=$organisation_id AND approver_mobile='$arr_mobile' ";
        $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
        $stmt->execute();
        $row = $stmt->fetch();    
        if($row) {
            $response['status'] = 1;
            $response['message'] = "success";
            $response['data'] = $row;
        }else{
            $response['status'] = 0;
        $response['message'] = "Not found";
        }
    return $response;

}


// verify OTP 
function get_user_details($user_id,$json=true){
    $sql = "SELECT users.*, user_categories.color_code FROM users join user_categories on user_categories.id = users.user_category_id WHERE users.id=".$user_id;
   // echo $sql;
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $stmt->execute();
   	$row = $stmt->fetch();
   	$count = $stmt->rowCount();
   	if($count!="" && $count!=0){
        $response['status']=1;
        $response['message'] =' user details!';
        $response['data'] = $row;
   	}else{
   	     $response['status']=0;
        $response['message'] =' Entered OTP is invalid!';
   	}
   	if($json==true){
        echo json_encode($response);
   	}else{
   	    return $response;
   	}
}


function generate_QR_code($code='',$color_code='black'){
    // generating
    $text = QRcode::text($code);
    $raw = join("<br/>", $text);
    
    $raw = strtr($raw, array(
        '0' => '<span style="color:white">&#9608;&#9608;</span>',
        '1' => '<span style="color:'.$color_code.'">&#9608;&#9608;</span>'
    ));
    
    // displaying
    
    echo '<tt style="font-size:7px">'.$raw.'</tt>';
    
}


// get active approver organisations in the system
function get_active_approvers($approver_id=''){
	 $response=array();
	   $r = array();
        $sql = "SELECT org_name,id FROM approver_details WHERE approver_details.status=1";
        if($approver_id!="" && $approver_id!=0){
            $sql .= " AND id=".$approver_id;
        }
        $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
        $stmt->execute();
        $rows = $stmt->fetchALL();    
        if(count($rows)>0) {
            $response['status'] = 1;
            $response['message'] = "success";
            $response['data'] = $rows;
        }else{
			$response['status'] = 0;
	        $response['message'] = "approvers not found";
		}
    return $response;
}


function validate_approver($mobile,$org_id){
    $response=array();
    $r = array();
    $sql = "SELECT org_name,id FROM approver_details WHERE approver_details.status=1 AND id=".$org_id." AND approver_mobile =".$mobile;
    $arr_passes = $this->get_approver_passes($org_id,'O');
    //print_r($arr_passes);
    $arr_pass = (isset($arr_passes['data']))?$arr_passes['data'][0]:0;
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $stmt->execute();
    $rows = $stmt->fetch();    
    if(count($rows)!=0 && $arr_pass==0) {
        $response['status'] = 2;
        $response['message'] = "No Approved passes available at the moment! Please contact your approver ";
    }else if(count($rows)!=0 && count($arr_pass)!=0) {
        $response['status'] = 1;
        $response['message'] = "success";
        $response['data'] = $rows;
        $response['qr_code'] = $arr_pass['qr_code'];
        $response['pass_type'] = $arr_pass['pass_type'];
        $response['pass_id'] = $arr_pass['id'];
    }else{
		$response['status'] = 0;
        $response['message'] = "Invalid Approver detail entered! Please enter Correct details! ";
	}
	//print_r($response);
    echo json_encode($response);
}

// destruct db connection
public function __destruct() {
    // close the database connection
    $this->conn = null;
}


}


?>
