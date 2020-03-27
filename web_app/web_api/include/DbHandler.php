<?php
session_start();    
//include_once './rpay/vendor/autoload.php';
//use Razorpay\Api\Api;
 require_once 'DbConnect.php';
  require_once 'phpqrcode.php';  

class DbHandler {

    private $conn;
    private $tax = 18;
    private $api;

    function __construct() {
        $db = new DbConnect();
        $this->conn = $db->connect();
        //echo "construct";
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
        $response['message'] = "status";
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
            $response['message'] = "status";
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
        $_SESSION['mobile'] = $mobile;
        $arr_response['status'] = 1;
		$arr_response['message'] = "Registered OTP sent Successfully -".$otp;
    }else{
        $arr_response['status'] = 0;
        $arr_response['message'] = "Data insert error !";
    }
   // print_r($arr_response);
    return $arr_response;
    //echo json_encode($arr_response);
    
}

// SMS Gateway - Trigger SMS
public function sendsms($mobile,$message,$otp){
    $arr_sms['mobile'] = $mobile;
    $arr_sms['otp'] = $otp;
    $arr_sms['message'] = $message;
    
    // Account details
	$apiKey = urlencode('Up+KJCGt/4o-8jsKIr9A37ROpz2jJQ5QJHU3HY5JDW');

	// Message details
	//$numbers = array(918123456789, 918987654321);
	$sender = urlencode('TXTLCL');
	$message = rawurlencode($message);
	if (is_array($mobile)) {
		$numbers = implode(',', $mobile);
	} else {
		$numbers = $mobile;
	}

	// Prepare data for POST request
	$data = array('apikey' => $apiKey, 'numbers' => $numbers, "sender" => $sender, "message" => $message);

	// Send the POST request with cURL
	$ch = curl_init('https://api.textlocal.in/send/');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	//$curl_response = curl_exec($ch);
	$curl_response = 'test';
	$arr_sms['response'] = $curl_response;
	$arr_sms['status'] = 1;
	$arr_response = $this->insert_sms_log($arr_sms);
	curl_close($ch);
	//print_r($arr_response);
	return $arr_response;
}
	
// Generate OTP & send SMS
function generate_otp($mobile){
    //$mobile ='9538131315';
    $otp = mt_rand(1000, 9999);
	$message = "Your OTP for Janata Pass Registration  is ".$otp;
    $response = $this->sendsms($mobile,$message,$otp); // send registration otp    
   // print_r($response);
	return $response; 
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
        $response['message'] =' OTP Verified successfully!';
   	}else{
   	     $response['status']=0;
        $response['message'] =' Entered OTP is not valid!';
   	}
   echo json_encode($response);
}

// verify mobile
function verify_mobile($mobile){
    $response = array();
    $sql = "SELECT * FROM users WHERE status='1' AND mobile='".$mobile."'";
    $stmt = $this->conn->query($sql, PDO::FETCH_ASSOC);
    $stmt->execute();
   	$row = $stmt->fetch();
   	$count = $stmt->rowCount();
   	if($count!="" && $count!=0){
        $response['status']=0;
        $response['message'] ='Mobile Number already registered with Janata Pass!';
   	}else{
       // $response['status']=1;
       // $response['message'] ='status';
       
        $response = $this->generate_otp($mobile);
        if(is_array($response)){
         //   echo 'asfasdf';
        }
      // print_r($response);
   	}
   	//print_r($response);
   	echo json_encode($response);
}

// register user 
function register(){
    $arr_fields = array('mobile','user_type_id','name','aadhar_number','address','city','pincode');
	foreach($arr_fields as $field){
		$arr_data[$field] = $_REQUEST[$field];
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
        if($last_inserted_id!='' && $last_inserted_id!=0){
            $arr_response['status'] = 1;
    		$arr_response['message'] = "User Registered statusfully!";
    		$arr_response['user_id'] = $last_inserted_id;
        }else{
            $arr_response['status'] = 0;
            $arr_response['message'] = "Error when trying to create user !";
        }
        //echo json_encode($arr_response);
        return $response;
	}
}

function new_QR_code(){
    $code = $_REQUEST['code'];
    $color_code = $_REQUEST['color_code'];
    // generating
    $text = QRcode::text($code);
    $raw = join("<br/>", $text);
    
    $raw = strtr($raw, array(
        '1' => '<span style="color:white">&#9608;&#9608;</span>',
        '0'=>'<span style="color:'.$color_code.'">&#9608;&#9608;</span>'
    ));
    
    // displaying
    
    echo '<tt style="font-size:7px">'.$raw.'</tt>';
    
}

function generate_QR_code(){
    $size = 200;
    $filename = '';
    $code = 'LASDF';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://chart.googleapis.com/chart');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, "chs={$size}x{$size}&cht=qr&chl=" . urlencode($code));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    $img = curl_exec($ch);
    curl_close($ch);
   // echo $img;
    //echo  "<img src='https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=Hello%20world' ></img>";

    if($img) {
        if($filename!='') {
            if(!preg_match("#\.png$#i", $filename)) {
                $filename .= ".png";
            }
            
            echo file_put_contents($filename, $img);
        } else {
            header("Content-type: image/png");
            print $img;
            return true;
        }
    }
    return false;
    
}

// destruct db connection
public function __destruct() {
    // close the database connection
    $this->conn = null;
}


}


?>
