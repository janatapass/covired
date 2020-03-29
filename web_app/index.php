<?php include_once('common/header.php');?>
   <body class="janata_pass">
      <div class="container">
         <div class="row h-100">
            <div class="col-lg-6 col-sm-6 col-12 mx-auto h-100 d-table">
			<div class="d-table-cell align-middle">
               <img alt="Janata Pass" class="logo" src="img/logo.png">
               <h1>Janata Pass</h1>
               <input type="hidden" id="user_mobile" name="user_mobile"/>
               <input type="hidden" id="user_otp" name="user_otp"/>
               <input type="hidden" id="user_type_id" name="user_type_id"/>
               <input type="hidden" id="approver_id" name="approver_id"/>
               <input type="hidden" id="user_approver_id" name="user_approver_id"/>
               <input type="hidden" id="user_id" name="user_id"/>
               <input type="hidden" id="req_org" name="req_org"/>
               <input type="hidden" id="req_services" name="req_services"/>
               <input type="hidden" id="req_qr_code" name="req_qr_code"/>
               <input type="hidden" id="req_pass_type" name="req_pass_type"/>
               <input type="hidden" id="req_pass_id" name="req_pass_id"/>

               <div id="div_main_body" name="div_main_body">
                   <div class="form-group">
                     <label for="mobile">Mobile Number:</label>
                     <input type="text" pattern="\d*" maxlength="10" class="form-control" placeholder="Enter your mobile number" id="mobile" name="mobile" required  value="">
                  </div>
                  <button type="button" class="btn btn-primary" onclick="request_otp();" id="myButton" >Request OTP</button>
               </div>
               <!--<form  class="landingpaege">
                  <div class="form-group">
                     <label for="mobile">Mobile Number:</label>
                     <input type="text" pattern="\d*" maxlength="10" class="form-control" placeholder="Enter your mobile number" id="mobile" name="mobile" required>
                  </div>
                  <button type="button" class="btn btn-primary" onclick="request_otp();" id="myButton" >Request OTP</button>
               </form>-->
               <p class="p_tag_bottom">A CoVIRED initiative</p>
            </div>
            </div>
         </div>
      </div>
      <?php include_once('common/footer.php');?>
     
   