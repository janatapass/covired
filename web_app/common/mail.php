<!-- mailure php-->
<?php
include_once('smtp/class.smtp.php');
include_once('smtp/class.phpmailer.php');

if(isset($_POST['submit']))
{


$username 	 =	$_POST['name'];

$userphone   =	$_POST['mobile'];

$usermessage     =	$_POST['message'];

	
	
  
	$mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPDebug = 0; 
        $mail->CharSet="iso-8859-1";
        $mail->Host = 'mail.abrb.co.in';
        $mail->SMTPAuth = true;
        $mail->Username = 'contactus@abrb.co.in';
        $mail->Password = 'Chennai123$';
		$mail->SMTPSecure = 'ssl';
        $mail->Port = 465;
        $mail->From = 'contactus@abrb.co.in';
        $mail->FromName = $username;
        $mail->AddAddress('redantmediamani@gmail.com'); 
		$mail->IsHTML(true);
		$mail->Subject = 'Contactus';
		//$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
	   $mail->Body    = '
	   
	   <table  class="table table-bordered" border="0" width="80%" cellpadding="5" cellspacing="5">
	   <tbody>
		  <tr>
			<td width="40%"><font style="color:#000;font-size:16px;font-weight:bold;">Name :</font></td>
			<td width="60%"><font style="color:#000;font-size:16px;font-weight:bold;">'.$username.'</font></td>
		    </tr>
		  <tr>
			<td width="40%"><font style="color:#000;font-size:16px;font-weight:bold;">Mobile Number: </font></td>
			<td width="60%"><font style="color:#000;font-size:16px;font-weight:bold;">'.$userphone.'</font></td>
		    </tr> 
		  <tr>
			<td width="40%"><font style="color:#000;font-size:16px;font-weight:bold;">Message: </font></td>
			<td width="60%"><font style="color:#000;font-size:16px;font-weight:bold;">'.$usermessage.'</font></td>
		   </tr> 
		  
		</tbody>
	  </table>
		
	   ';
   
		if(!$mail->Send())
		{
		$message = '<div class="alert alert-info alert_text alert-dismissible " role="alert">There is an Error</div>';	
		//$message = '<div class="alert alert-success">Application Successfully Submitted</div>';
		//unlink($path);
		 
		}
		else
		{
			$message = '<div class="alert alert-info alert_text alert-dismissible " role="alert">your message has been sent Successfully </div>';
		//$message = '<div class="alert alert-danger">There is an Error</div>';

		}
   

}

 ?>

<!--End mailure -->