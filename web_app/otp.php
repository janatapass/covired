<?php include_once('common/header.php'); ?>
   <body class="janata_pass">
      <div class="container">
         <div class="row">
            <div class="col-lg-6 col-sm-6 col-12 mx-auto">
               <img alt="Janata Pass" class="logo" src="img/logo.png">
               <h1>Janata Pass</h1>
                  <div class="form-group">
                     <label for="text">Mobile Number:</label>
                     <input type="text" class="form-control" placeholder="Enter your mobile number" id="mobile" name="mobile" value="<?=$_SESSION['mobile'];?>" readonly>
                  </div>
				  <div class="form-group">
                     <label for="opt">Enter OTP:</label>
                     <div class="row">
                     <div class="col">
					  <input type="text" pattern="\d*" maxlength="1" class="form-control" id="otp1" min="0" max="9" required> 
					 </div>
					 <div class="col">
					  <input type="text" pattern="\d*" maxlength="1"  class="form-control" id="otp2"  min="0" max="9" required>
					 </div>
					 <div class="col">
					  <input type="text" pattern="\d*" maxlength="1"  class="form-control" id="otp3"  min="0" max="9"  required>
					 </div>
					 <div class="col">
					  <input type="text" pattern="\d*" maxlength="1"  class="form-control" id="otp4"  min="0" max="9"  required>
					 </div>
					 </div>
                  </div>
                  <button type="button" onclick="verifyOTP()" class="btn btn-primary">Submit</button>

               <p class="p_tag_bottom">A CoVIRED initiative</p>
            </div>
         </div>
      </div>
      <?php include_once('common/footer.php');?>
