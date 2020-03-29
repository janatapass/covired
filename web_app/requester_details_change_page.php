<!--<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Janata Pass</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/main.css">
   </head>
   <body class="janata_pass green">
      <div class="container">
         <div class="row">
            <div class="col-lg-6 col-sm-6 col-12 mx-auto">
               <img alt="Janata Pass" class="logo" src="img/logo.png">
               <h1>Janata Pass</h1>-->
               <?php 
               //print_r($_REQUEST);
			   include_once ('web_api/include/DbHandler.php');
               $DbHandler = new DbHandler();
			   $arr_orgs = $DbHandler->get_active_approvers();
			  
			   $arr_orgs = $arr_orgs['data'];
			   //print_r($arr_orgs);
			   ?>
                <div class="container">
			   <h4 class="text-center"><strong>Please register your details</strong></h4>
			   <form>
               <div class="card mb-3 mt-3">
                  <div class="card-body passes_list">
                     <div class="row">
                        <div class="col-lg-12 col-12">
                           <div class="row">
								<div class="col-lg-12 col-12">
								<div class="form-group grey_box">
								<label for="sel1">Select Organization</label>
								<select class="form-control" id="org_id" name="org_id" required>
								    <option value="">Select Organisation</option>
								    <?php if(is_array($arr_orgs) && count($arr_orgs)!=0){ 
								    foreach($arr_orgs as $org){
								    ?>
								    	<option value="<?= $org['id'];?>"><?= $org['org_name'];?></option>
								    <?php
								    }
								    } ?>
    							</select>
								</div>
								</div>
								<!-- <div class="col-lg-12 col-12">
								<div class="form-group grey_box">
								<label for="sel1">Select Services</label>
								<select class="form-control" id="sel1">
								<option>Organization 1</option>
								<option>Organization 2</option>
								<option>Organization 3</option>
								<option>Organization 4</option>
								</select>
								</div>
								</div> -->
                              <div class="col-lg-12 col-12">
                                 <div class="form-group grey_box">
								 <label for="sel1">Services</label>
                                    <input type="text" class="form-control" placeholder="Enter Services" id="services_id" name=services_id required>
                                 </div>
                              </div>
                              <div class="col-lg-12 col-12">
                                 <div class="form-group grey_box">
								 <label for="sel1">Approver details</label>
                                    <input type="text" pattern="\d*" maxlength="10"  class="form-control" placeholder="Approver mobile number" id="approver_mobile" name="approver_mobile" required>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <button type="button" class="btn btn-primary" onclick="validate_approver();"> Next </button>
			   </form>
               <!--<p class="p_tag_bottom">A CoVIRED initiative</p>-->
            </div>
         <!--</div>
      </div>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
   </body>
</html>-->

<script type="text/javascript">

function validate_approver(){
    //alert('validate approver');
    var approver_mobile = $('#approver_mobile').val();
    var org_id = $('#org_id').val();
    var services_id = $('#services_id').val();
     $.ajax({
        url: "common/action.php",
        type: "POST",
        data: {
            'action': "validate_approver",
            'approver_mobile': approver_mobile,
            'approver_id':org_id
        },
        success: function (response){
              //alert(response);
             var data = $.parseJSON(response);
              // invalid approver details
              if(data.status ==0){
                  error_alert(data.message);
              }
              // correct approver details but no pass available
              if(data.status ==2){
                error_alert(data.message,'index.php');
              }
              // correct approver and passes available
              if(data.status ==1){
                //$('#user_mobile').val(mobile);
                $('#req_org').val(org_id);
                $('#req_services').val(services_id);
                $('#req_qr_code').val(data.qr_code);
                $('#req_pass_type').val(data.pass_type);
                $('#req_pass_id').val(data.pass_id);
                ajax_load('requester_register.php','div_main_body');
              }
        }
      });
}
</script>