<?php include_once('common/header.php');?>
   <body class="janata_pass">
      <div class="blue_" id="janata_body_class">
       <div class="container">
         <div class="row h-100">
            <div class="col-lg-6 col-sm-6 col-12 mx-auto h-100 d-table">
			<div class="d-table-cell align-middle">
               <img alt="Janata Pass" class="logo" src="img/logo.png">
               <h1>Janata Pass</h1>
               <div id='location'></div>
               <input type="hidden" id="user_mobile" name="user_mobile"/>
               <input type="hidden" id="user_otp" name="user_otp"/>
               <input type="hidden" id="user_type_id" name="user_type_id"/>
               <input type="hidden" id="approver_id" name="approver_id"/>
               <input type="hidden" id="user_approver_id" name="user_approver_id"/>
               <input type="hidden" id="user_id" name="user_id"/>
               <input type="hidden" id="pass_id" name="pass_id"/>
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
      </div>
      
       <div class="modal fade" id="leave_modal" name="leave_modal" >
   <div class="modal-dialog">
     <div class="modal-content" id="div_leave_modal" name="div_leave_modal">
     </div>
   </div>
 </div>
 
      <!-- The Modal -->
<div class="modal" id="leave_pass">
    <div class="modal-dialog" id="div_pass_modal">
      <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Leave Pass</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body -->
		<div class="modal-body" id='div_leave_pass'>
		<!--<form name="form_pass" id="form_pass" method="POST">
		    <div class="form-group grey_box">
        		<label for="text">Date </label>
        		<input type="text" class="form-control" id="travel_date"  name="travel_date" value="<?= date('d/m/Y');?>" readonly>
    		</div>
    		<div class="form-group grey_box">
    		<label for="text">Reason for stepping out</label>
    		<input type="text" class="form-control" placeholder="Enter Reason for stepping out" id="travel_reason"  name="travel_reason">
    		</div>
    	    <div class="form-group">
               <label for="text">Duration</label>
               <div class="row content">
                  <div class="col-ld-6 col-sm-6 col-6">
                     <div class="form-group">
                        <div class="input-group time" id="start_time_div">
                           <input class="form-control"  id="start_time" placeholder="HH:MM AM/PM" /><span class="input-group-append input-group-addon"><span class="input-group-text"><i class="fa fa-clock-o"></i></span></span>
                        </div>
                     </div>
                  </div>
                  <div class="col-ld-6 col-sm-6 col-6">
                     <div class="form-group">
                        <div class="input-group time" id="end_time_div">
                           <input class="form-control"id="end_time" placeholder="HH:MM AM/PM" /><span class="input-group-append input-group-addon"><span class="input-group-text"><i class="fa fa-clock-o"></i></span></span>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
    		<div class="form-group grey_box">
    		<label for="text">Area</label>
    		<input type="text" class="form-control" placeholder="Enter Area" id="location"  name="location">
    		</div>
    		<div class="col-ld-12 col-sm-12 col-12 mt-3 text-center">
    		<button type="button" onclick="create_pass()" class="btn btn-black">Apply</button>
    		</div>
		</form>-->
		</div>
      </div>
    </div>
</div>  
<!--
<div class="modal" id="share_trip">
    <div class="modal-dialog">
      <div class="modal-content">
        <!-- Modal Header --
        <div class="modal-header">
          <h4 class="modal-title">Share Trip</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal body --
		<div class="modal-body">
		<form>
		<div class="form-group grey_box">
		<input type="text" class="form-control" value="Start" id="" name="" required >
		</div>
		<div class="form-group grey_box">
		<input type="text" class="form-control" placeholder="Mobile number" id="" name="" required value="">
		</div>
		<button class="btn btn-info"> Share</button>
		</form>
		</div>
      </div>
    </div>
  </div>-->
      <?php include_once('common/footer.php');?>
      
      <script id="rendered-js">
         if (/Mobi/.test(navigator.userAgent)) {
           // if mobile device, use native pickers
           $(".date input").attr("type", "date");
           $(".time input").attr("type", "time");
         } else {
           // if desktop device, use DateTimePicker
           $("#datepicker").datetimepicker({
    useCurrent: false,
    format: "L",
    showTodayButton: true,
    icons: {
      next: "fa fa-chevron-right",
      previous: "fa fa-chevron-left",
      today: 'todayText',
    }
  });
           $("#start_time_div input").datetimepicker({
             format: "LT",
			 allowInputToggle: true,
             icons: {
               up: "fa fa-chevron-up",
               down: "fa fa-chevron-down" } });
         	  
           $("#end_time_div input").datetimepicker({
             format: "LT",
			 allowInputToggle: true,
             icons: {
               up: "fa fa-chevron-up",
               down: "fa fa-chevron-down" } });
         
         
         }
         //# sourceURL=pen.js
             
      </script>
	  <script>

	  
            $(function () {
                $('#datetimepicker2').datetimepicker({
                    locale: 'ru'
                });
            });
        </script>
      
