<?php //include_once('common/header.php'); ?>
   <!--<body class="janata_pass">
      <div class="container">
         <div class="row">
            <div class="col-lg-6 col-sm-6 col-12 mx-auto">
               <img alt="Janata Pass" class="logo" src="img/logo.png">
               <h1>Janata Pass</h1>-->
                  <div class="form-group">
                     <label for="text">Mobile Number:</label>
                     <input type="text" class="form-control" placeholder="Enter your mobile number" id="mobile" name="mobile" value="<?=$_SESSION['mobile'];?>" readonly>
                  </div>
				  <div class="form-group">
                     <label for="opt">Enter OTP:</label>
                     <div class="row">
                     <div class="col">
					  <input type="text" pattern="\d*" maxlength="1" class="form-control text-center" id="otp1" min="0" max="9" required value="" onkeyup="onKeyUpEvent(1, event)" onfocus="onFocusEvent(1)"> 
					 </div>
					 <div class="col">
					  <input type="text" pattern="\d*" maxlength="1"  class="form-control text-center" id="otp2"  min="0" max="9" required value="" onkeyup="onKeyUpEvent(2, event)" onfocus="onFocusEvent(2)">
					 </div>
					 <div class="col">
					  <input type="text" pattern="\d*" maxlength="1"  class="form-control text-center" id="otp3"  min="0" max="9"  required value="" onkeyup="onKeyUpEvent(3, event)" onfocus="onFocusEvent(3)">
					 </div>
					 <div class="col">
					  <input type="text" pattern="\d*" maxlength="1"  class="form-control text-center" id="otp4"  min="0" max="9"  required value="" onkeyup="onKeyUpEvent(4, event)" onfocus="onFocusEvent(4)">
					 </div>
					 </div>
                  </div>
                  <button type="button" onclick="verifyOTP()" class="btn btn-primary">Submit</button>
<!--
               <p class="p_tag_bottom">A CoVIRED initiative</p>
            </div>
         </div>
      </div>
      <?php include_once('common/footer.php');?>-->
      <script type="text/javascript">
      $(document).ready(function () {
      var user_mobile = $('#user_mobile').val();
      $('#mobile').val(user_mobile);
      });
</script>
<script>
function getCodeBoxElement(index) {
  return document.getElementById('otp' + index);
}
function onKeyUpEvent(index, event) {
  const eventCode = event.which || event.keyCode;
  if (getCodeBoxElement(index).value.length === 1) {
	 if (index !== 4) {
		getCodeBoxElement(index+ 1).focus();
	 } else {
		getCodeBoxElement(index).blur();
		// Submit code
		console.log('submit code ');
	 }
  }
  if (eventCode === 8 && index !== 1) {
	 getCodeBoxElement(index - 1).focus();
  }
}
function onFocusEvent(index) {
  for (item = 1; item < index; item++) {
	 const currentElement = getCodeBoxElement(item);
	 if (!currentElement.value) {
		  currentElement.focus();
		  break;
	 }
  }
}
</script>
