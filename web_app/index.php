<?php include_once('common/header.php');?>
   <body class="janata_pass">
      <div class="container">
         <div class="row">
            <div class="col-lg-6 col-sm-6 col-12 mx-auto">
               <img alt="Janata Pass" class="logo" src="img/logo.png">
               <h1>Janata Pass</h1>
               <form  class="landingpaege">
                  <div class="form-group">
                     <label for="mobile">Mobile Number:</label>
                     <input type="text" pattern="\d*" maxlength="10" class="form-control" placeholder="Enter your mobile number" id="mobile" name="mobile" required>
                  </div>
                  <button type="button" class="btn btn-primary" onclick="request_otp();" id="myButton" >Request OTP</button>
               </form>
               <p class="p_tag_bottom">A CoVIRED initiative</p>
            </div>
         </div>
      </div>
      <?php include_once('common/footer.php');?>
   