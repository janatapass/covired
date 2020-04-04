<?php
    
//include_once './rpay/vendor/autoload.php';
//use Razorpay\Api\Api;
include_once 'phpqrcode.php';
class DbHandler {

    private $conn;

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


// get active travel reasons in the system
function travel_reasons(){
	$response=array();
    $r = array();
    $sql = "SELECT id,reason FROM travel_reasons WHERE status=1 and is_active=1 order by reason asc";
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $stmt->execute();
    $rows = $stmt->fetchALL();    
    return $rows;
}

// get active cities in the system
function get_city_names(){
	$response=array();
    $r = array();
    $sql = "SELECT id,city_name FROM cities WHERE status=1 and is_active=1 AND city_id=0 order by city_name asc";
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $stmt->execute();
    $rows = $stmt->fetchALL();    
    return $rows;
}

// get active localities for the city
function locality_names($city=''){
    //echo "city name".$city_name."<br>";
	$response=array();
    $r = array();
    $sql = "SELECT id,locality,city_name FROM cities WHERE status=1 and is_active=1 AND city_id!=0 ";
    if($city!=''){
         $sql .= " AND city_name ='".$city."'" ;
    }
    $sql .= " order by locality asc ";
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $stmt->execute();
    $rows = $stmt->fetchALL(); 
    return $rows;
}

// get active localities for the city
function get_locality_names($city_name){
    //echo "city name".$city_name."<br>";
	$response=array();
    $r = array();
    $sql = "SELECT locality FROM cities WHERE status=1 and is_active=1 AND city_id!=0 ";
    if($city_name!=''){
         $sql .= " AND city_name ='".$city_name."'" ;
    }
    
    //$sql .= " order by locality asc ";
    //echo $sql;
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $stmt->execute();
    $rows = $stmt->fetchALL(); 
    echo '<select class="form-control" id="locality" name="locality">
                <option value="">Select Locality</option>';
    if(is_array($rows)&&count($rows)!=0){
        foreach($rows as $locality){
            echo "<option value='".$locality['locality']."'>".$locality['locality']."</option>";
        }
       
    }else{
        echo '';
    }
     echo "</select>";
   // return $rows;
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
    if($otp==''){
        $message = ' Trip Details Shared Successfully!';
    }else{
        $message =  "OTP sent Successfully - ".$otp;;
    }
    if($stmt3){
        $arr_response['status'] = 1;
		$arr_response['message'] =$message;
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
         $response['user_id'] = isset($row['id'])?$row['id']:0;
   //	}
   echo json_encode($response);	
}

// register user 
function save_user(){
    $arr_fields = array('mobile','user_type_id','name','aadhar_number','user_category_id','qr_code','approver_id','city','locality','address','pincode','user_proof','services','share_with_mobile','share_with_name','relationship','longitude','latitude');
	foreach($arr_fields as $field){
		$arr_data[$field] = isset($_REQUEST[$field])?$_REQUEST[$field]:'';
	}
	if($arr_data['qr_code']==''){
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
    	if(isset($_REQUEST['pass_id']) && $_REQUEST['pass_id']!=""&& $_REQUEST['pass_id']!=0){
        	$arr_user['assigned_user_id'] = $last_inserted_id;
        	$arr_user['pass_id'] = $_REQUEST['pass_id'];
        	$this->update_pass_status($arr_user);
    	}
    	
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
		$arr_data[$field] =  isset($_REQUEST[$field])?$_REQUEST[$field]:'';
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


// get approver details
public function get_approver_details($approver_id){
    $sql = "SELECT * FROM approver_details WHERE status='1' AND id='".$approver_id."'";
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $stmt->execute();
   	$row = $stmt->fetch();
   	if(is_array($row) && count($row)!=0){
        //$arr_response = $this->generate_passes();
       // $arr_response['status'] = 1;
	//	$arr_response['message'] = "approve pass count updated!";
		$arr_response['approver_id'] = $approver_id;
		$arr_response['approver_details'] = $row;
    }else{
        $arr_response['status'] = 0;
        $arr_response['message'] = "Error when trying to update pass count !";
    }
    //echo json_encode($arr_response);
    return $arr_response;

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
function get_approver_passes($approver_id,$status='',$user_type=''){
	 $response=array();
	   $r = array();
        $sql = "SELECT * FROM approver_pass_details WHERE approver_id=".$approver_id;
        if($status!=""){
            $sql .= ' AND pass_status="'.$status.'"';
        }
        
        if($user_type!=""){
            $category = ($user_type==2)?'G':'Y';
            $sql .= ' AND pass_type="'.$category.'"';
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
   	//if($row['user_type_id']==1){
   	    $arr_passes = $this->user_pass_details($user_id); // get approver passes    
   	    $response['passes'] = (is_array($arr_passes) && count($arr_passes)!=0 && isset($arr_passes['data']))?$arr_passes['data']:'';
   	//}
   //	if($row['user_type_id']==3){
   	//    $arr_leave_entries = $this->user_pass_details($user_id);
   	//    $response['leave_entries'] = (is_array($arr_leave_entries) && count($arr_leave_entries)!=0 && isset($arr_leave_entries['data']))?$arr_leave_entries['data']:'';
   //	}
   	
   	if($count!="" && $count!=0){
   	     if($row['approver_id']!="" && $row['approver_id']!=0){
       	        $arr_approver = $this->get_approver_details($row['approver_id']);    
       	        if(is_array($arr_approver) && count($arr_approver)!=0){
       	            $arr_approver = $arr_approver['approver_details'];
       	            $row['organisation'] = $arr_approver['org_name'];
       	            $row['green_pass_count'] = $arr_approver['green_pass_count'];
       	            $row['yellow_pass_count'] = $arr_approver['yellow_pass_count'];
       	        }
       	    }else{
       	        $row['organisation'] = '';
       	    }
        $response['status']=1;
        $response['message'] =' user details!';
        $response['data'] = $row;
   	}else{
   	     $response['status']=0;
        $response['message'] =' Entered User ID is invalid or not active in the system';
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


function validate_approver($mobile,$org_id,$user_type){
    $response=array();
    $r = array();
    $sql = "SELECT org_name,id FROM approver_details WHERE approver_details.status=1 AND id=".$org_id." AND approver_mobile =".$mobile;
    $arr_passes = $this->get_approver_passes($org_id,'O',$user_type);
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


/** Pass Entries **/
function all_pass(){
     $response=array();
       $r = array();
        $sql = "SELECT * FROM pass_entries  WHERE is_active=1";
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

function user_pass_details($user_id,$pass_id=0){
     $response=array();
     if($user_id!="" && $user_id!=0){
     $sql = "SELECT * FROM pass_entries WHERE user_id= $user_id AND travel_date >= CURDATE() AND  is_active=1 ";
     }
     if($pass_id!=0 && $pass_id!=""){
        $sql .= " AND id= $pass_id ";
     }
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $stmt->execute();
    $rows = $stmt->fetchAll(); 

 if(count($rows)>0)
    {
        $response['status'] = 1;
        $response['message'] = "success";
        $response['data'] = $rows;
    }
       else{
          $response['status'] = "failed";
          $response['message'] = "Passes not found";
       } 

return $response;
  } 

  function create_user_pass()
  {
     // print_r($_REQUEST);
    $arr_fields = array('user_id', 'travel_reason','start_time','end_time','travel_date','trip_from','trip_to','vehicle_number','duration');
	foreach($arr_fields as $field){
		$arr_data[$field] =  isset($_REQUEST[$field])?$_REQUEST[$field]:'';
	}
	$arr_data['travel_date'] = date('Y-m-d h:s:i');
	
	$when = new DateTime($arr_data['start_time']);
	$arr_data['start_time'] = $when->format('Y-m-d h:i A');
    $when->add(new DateInterval('PT' . $arr_data['duration'] . 'M'));
   // echo 'End time: ' . $when->format('Y-m-d h:i A') . "\n";
    $arr_data['end_time'] = $when->format('Y-m-d h:i A');

	/*
	if($arr_data['start_time']!=""){
	    $arr_data['start_time'] = 'TIME( STR_TO_DATE( "' . $arr_data['start_time'] . '", "%h:%i %p" ) )';
	  //$arr_data['start_time'] = date('Y-m-d H:s:i A',strtotime());
	}
	
	if($arr_data['end_time']!=""){
	  //  $arr_data['end_time'] = date('Y-m-d h:s:i',strtotime($arr_data['end_time']));
	  $arr_data['end_time'] = 'TIME( STR_TO_DATE( "' . $arr_data['end_time'] . '", "%h:%i %p" ) )';
	}*/
	//print_r($arr_data);
    //exit;
	if(is_array($arr_data) && count($arr_data)!=0){
	    $arr_data['is_active'] = 1;
	    $arr_data['travel_status'] = 'OPEN';
	    $arr_data['cby'] = $arr_data['mby'] = $arr_data['user_id'];
	    $arr_data['cdate'] = $arr_data['mdate'] = date('y-m-d h:d:i');
    	$str_fields = implode(",",array_keys($arr_data));
    	$str_values = implode("','",array_values($arr_data));  
    	$sql3 = $this->conn->prepare("INSERT INTO pass_entries (".$str_fields.") VALUES ('".$str_values."')");
    	$sql3->execute();
    	$last_inserted_id = $this->conn->lastInsertId();
    	$response['status'] = 1;
        $response['message'] = "Leave Pass Created Successfully!";
        $response['pass_id'] = $last_inserted_id;
	}else{
	    $response['status'] = "failed";
        $response['message'] = "Data insert error !";
	}
	echo json_encode($response);
     /* $response = array();
      $is_active=1;
      $cdate = date('Y-m-d H:i:s');
        $sql = "INSERT INTO pass_entries (user_id,travel_reason,services,start_time,end_time,location,is_active,cdate) VALUES (?,?,?,?,?,?,?,?)";
            $stmt= $this->conn->prepare($sql);
            $stmt->execute([$user_id, $reason,$services,$duration_from,$duration_to,$location,$is_active,$cdate]);
            if($stmt){
                $response['status'] = "success";
                $response['message'] = "success";
               $pass_id =  $this->conn->lastInsertId();
        }
      else{
            $response['status'] = "failed";
            $response['message'] = "Data insert error !";
        }

    return $response;*/
  }

  function edit_pass($id,$user_id,$reason,$services,$duration_from,$duration_to,$location)
  {
    $response = array();
    $mdate = date('Y-m-d H:i:s');
    $sql = "UPDATE pass_entries SET user_id='$user_id', travel_reason='$reason', services='$services', start_time='$duration_from', end_time='$duration_to', location='$location', mdate='$mdate' WHERE id=$id";
    $stmt = $this->conn->query($sql);
    $stmt->execute();
         if($stmt){
           $response['status'] = "success";
           $response['message'] = "success";
        }else{
            $response['status'] = "failed";
            $response['message'] = "Passes exists !";
        }
    return $response;
  }
  /** Pass Entries **/
  
  
  function update_leave_status($pass_id,$travel_status,$verifier_id){
      $warning_reason = $_REQUEST['warning_reason'];
      $warning_date = $_REQUEST['warning_date'];
      $warning_time = $_REQUEST['warning_time'];
      $latitude = $_REQUEST['latitude'];
      $longitude = $_REQUEST['longitude'];
        $response = array();
        $mdate = date('Y-m-d H:i:s');
        $sql = "UPDATE pass_entries SET travel_status='".$travel_status."',mby=".$verifier_id;
        if($warning_reason!=""){
            $sql .=  " , warning_reason='".$warning_reason."'";
        }
        if($warning_date!=""){
            $sql .=  " , warning_date='".$warning_date."'";
        }
        if($warning_time!=""){
            $sql .=  " , warning_time='".$warning_time."'";
        }
         if($latitude!=""){
            $sql .=  " , latitude='".$latitude."'";
        }
         if($warning_time!=""){
            $sql .=  " , longitude='".$longitude."'";
        }
        $sql .= " WHERE id=".$pass_id;
        
        //echo $sql;
        $stmt = $this->conn->query($sql);
        $stmt->execute();
             if($stmt){
               $response['status'] = 1;
               $response['message'] = "Leave Pass Updated Successfully!";
            }else{
                $response['status'] = "failed";
                $response['message'] = "Passes exists !";
            }
    return $response;
  }
  
  public function get_citizen_details($mobile,$qr_code){

      $sql = "SELECT users.*, user_categories.color_code FROM users join user_categories on user_categories.id = users.user_category_id  WHERE ";
      if($mobile!="" && $qr_code!=""){
          $sql .= " mobile ='".$mobile."' AND  qr_code = '".$qr_code."'";
      }else if($mobile!='' && $qr_code==''){
          $sql .= "  mobile = '".$mobile."'";
      }else if($qr_code!='' && $mobile==""){
          $sql .= "  qr_code = '".$qr_code."'";
      }
       // echo $sql;
        $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
        $stmt->execute();
       	$row = $stmt->fetch();
       	$count = $stmt->rowCount();
       	if($count!=0){
       	    if($row['approver_id']!="" && $row['approver_id']!=0){
       	        $arr_approver = $this->get_approver_details($row['approver_id']);    
       	        if(is_array($arr_approver) && count($arr_approver)!=0){
       	            $arr_approver = $arr_approver['approver_details'];
       	            $row['organisation'] = $arr_approver['org_name'];
       	        }
       	    }else{
       	        $row['organisation'] = '';
       	    }
       	    
       	    //approver_details.org_name as organisation_name, approver_details.org_type
       	    $user_id = $row['id'];
       	    $arr_passes = $this->user_pass_details($user_id); // get approver passes    
       	    $response['passes'] = (is_array($arr_passes) && count($arr_passes)!=0 && isset($arr_passes['data']))?$arr_passes['data']:array();
            $response['status']=1;
            $response['message'] =' user details!';
            $response['data'] = $row;
           
       	}else{
       	    $response['status']=0;
            $response['message'] =' Entered mobile/qr_code is invalid!';
       	}
   	
        echo json_encode($response);
  }
  
  public function share_trip_details($name,$pass_id,$mobile,$user_id){
      //$mobile = '9538131315';
      $arr_pass = $this->user_pass_details($user_id,$pass_id);
      if(is_array($arr_pass) && count($arr_pass)!=0){
          $arr_pass = $arr_pass['data'];
          $pass_details = $arr_pass[0];
      }
      $message = " Dear ".$name.",\n Sharing my trip details\n";
      $message .= " Travel Date : ".$pass_details['travel_date']."\n Travelling from : ".$pass_details['trip_from']." to ".$pass_details['trip_to']."\n";
      $message .= " Start Time : ".$pass_details['start_time']." \n End Time ".$pass_details['end_time']."\n";
      $message .= " Reason : ".$pass_details['travel_reason']."\n";
      if($pass_details['vehicle_number']!="") $message .= " Vehicle Number  : ".$pass_details['vehicle_number']."\n";
      //echo $message;
      $response = $this->sendsms($mobile,$message,'');
      echo json_encode($response);
  }
  
  public function user_pass_history($user_id){
       $response=array();
       $r = array();
        $sql = "SELECT user_id,travel_date,trip_from,trip_to,travel_reason,travel_status,start_time,end_time,mby,mdate,longitude,latitude FROM pass_entries  WHERE is_active=1 AND user_id=".$user_id;
        $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
        $stmt->execute();
        $rows = $stmt->fetchALL();
        if(count($rows)>0) {
            $response['status'] = 1;
            $response['message'] = "User Passes History List";
            $response['data'] = $rows;
        }else{
            $response['status'] = 0;
        $response['message'] = "No passes found for the user";
        }
    return $response;
  }
  
  public function user_warnings($user_id){
       $response=array();
       $r = array();
        $sql = "SELECT user_id,travel_date,trip_from,trip_to,travel_reason,travel_status,start_time,end_time,mby,mdate,warning_reason,warning_date,warning_time,longitude,latitude FROM pass_entries  WHERE is_active=1 AND user_id=".$user_id." AND travel_status = 'WARNING'";
        $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
        $stmt->execute();
        $rows = $stmt->fetchALL();
        if(count($rows)>0) {
            $response['status'] = 1;
            $response['message'] = "User Passes History List";
            $response['data'] = $rows;
        }else{
            $response['status'] = 0;
        $response['message'] = "No passes with warnings found for the user";
        }
    return $response;
  }
  
  // total passes in the system
  public function get_total_passes($locality,$date){
        $response=array();
       $r = array();
        $sql = "SELECT count(*) as total_passes_count  FROM pass_entries  WHERE is_active=1  ";
        if($date!=""){
            $sql .=  " AND travel_date = '".$date."' ";
        }else{
           $sql .=  " AND travel_date = CURRENT_DATE ";
        }
        if($locality!=""){
            $sql .= " AND (trip_from='".$locality."' || trip_to='".$locality."') ";
        }
        //echo $sql;
        $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
        $stmt->execute();
        $rows = $stmt->fetch();
        if(count($rows)>0) {
            return $rows['total_passes_count'];
        }else{
            return 0;
        }
  }
  
  // completed passes in the system
  public function get_completed_passes($locality,$date){
        $response=array();
        $r = array();
        $sql = "SELECT count(*) as pass_count FROM `pass_entries` where  AND is_active=1 ";
        if($date!=""){
            $sql .=  " AND ( travel_date = ".$date." AND end_time < CURRENT_TIMESTAMP )";
        }else{
           $sql .=  "  ( travel_date = CURRENT_DATE AND end_time < CURRENT_TIMESTAMP ) ";
        }
        if($locality!=""){
            $sql .= " AND (trip_from='".$locality."' || trip_to='".$locality."') ";
        }
        $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
        $stmt->execute();
        $rows = $stmt->fetch();
        if(count($rows)>0) {
            return $rows['pass_count'];
        }else{
            return 0;
        }
  }
  
   // passes at home 
  public function get_passes_at_home($type,$locality,$date){
        $response=array();
        $r = array();
        
        $sql = "SELECT count(*) as pass_count FROM `pass_entries` where ( travel_date = CURRENT_DATE AND start_time > CURRENT_TIMESTAMP ) AND is_active=1";
        
        if($locality!=""){
            $sql .= " AND (trip_from='".$locality."' || trip_to='".$locality."') ";
        }
        $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
        $stmt->execute();
        $rows = $stmt->fetch();
        if(count($rows)>0) {
            return $rows['pass_count'];
        }else{
            return 0;
        }
  }
  
  public function get_passes_counts($type,$locality){
      switch($type) {
           case 'total':
              $sql = "SELECT count(*) as pass_count  FROM pass_entries  WHERE is_active=1  ";
              break;
           case 'completed':
              $sql = "SELECT count(*) as pass_count  FROM pass_entries  WHERE is_active=1  ";
              $sql .= " AND ( travel_date = CURRENT_DATE AND end_time < CURRENT_TIMESTAMP ) ";
              // $sql .= " AND  travel_date = ".$date." AND travel_status != 'OPEN'  ";
              break;
           case 'at_home':
              $sql = "SELECT count(*) as pass_count  FROM pass_entries  WHERE is_active=1  ";
              $sql .= " AND ( travel_date = CURRENT_DATE AND start_time > CURRENT_TIMESTAMP ) ";
              //$sql .= " AND  travel_date = ".$date." AND travel_status = 'OPEN'  ";
              break;
      }
      
        if($locality!=""){
            $sql .= " AND (trip_from='".$locality."' || trip_to='".$locality."') ";
        }

        $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
        $stmt->execute();
        $rows = $stmt->fetch();
        if(count($rows)>0) {
            return $rows['pass_count'];
        }else{
            return 0;
        }
  }
  
  public function daily_statistics($locality='',$date=''){
    // registered passes, completed passes, passes at home
    /*$response['total_passes_count'] = $this->get_total_passes($locality,$date); // total passes in the system
    $response['completed_passes_count'] = $this->get_completed_passes($locality,$date); // completed passes in the system
    $response['passes_athome_count'] = $this->get_passes_at_home($locality,$date); // total passes at home at the given time*/
    $response['total_passes_count'] = $this->get_passes_counts('total',$locality); // total passes in the system
    $response['completed_passes_count'] = $this->get_passes_counts('completed',$locality); // completed passes in the system
    $response['passes_athome_count'] = $this->get_passes_counts('at_home',$locality); // total passes at home at the given time
    return $response;
  }


public function save_birthmark(){
    $user_id  = $_REQUEST['user_id'];
    $user_birthmark  = $_REQUEST['user_birthmark'];
    if($user_id!=0 && $user_id!=""){
        $sql2 = "UPDATE users SET user_birthmark=? WHERE id=?";
        $this->conn->prepare($sql2)->execute([$user_birthmark, $user_id]);
        $response['status']=1;
        $response['message'] =' User Birth Mark details updated successfully!';
    }else{
        $response['status']=0;
        $response['message'] =' Error when trying to update Birth Mark details!';
    }
    echo json_encode($response);
}
  
// destruct db connection
public function __destruct() {
    // close the database connection
    $this->conn = null;
}


}


?>
