<!--<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Janata Pass</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/main.css">
   </head>
   <body class="janata_pass">
      <div class="container">
         <div class="row">
            <div class="col-lg-6 col-sm-6 col-12 mx-auto">
               <img alt="Janata Pass" class="logo" src="img/logo.png">
               <h1>Janata Pass</h1>-->
               <?php
               //print_r($_REQUEST);
			   include_once ('web_api/include/DbHandler.php');
               $DbHandler = new DbHandler();
               $approver_id = isset($_REQUEST['approver_id'])?$_REQUEST['approver_id']:'';
               if($approver_id!=''){
                   $arr_app = $DbHandler->get_approver_details($approver_id);
                   if(isset($arr_app['approver_details'])){
                       $green_count = $arr_app['approver_details']['green_pass_count'];
                       $yellow_count = $arr_app['approver_details']['yellow_pass_count'];
                   }
               }else{
                   $green_count = '';
                   $yellow_count = '';
               }
               ?>
               <div class="card mb-3 mt-3">
                  <div class="card-body">
                     <div class="row">
					 <div class="col-lg-12 col-12">
					  <h4>How many passes do you require?</h4>
					 </div>
					 </div>
                     <div class="row">
					 <div class="col-lg-4 col-sm-4 col-4 mb-4">
					<div class="box">
					<select class="green">
					<option>Green</option>
					</select>
					</div>
					 </div>
					 <div class="col-lg-8 col-sm-8 col-8 mb-4">
					<div class="form-group grey_box">
					<input type="number" class="form-control" min="1" placeholder="Number of pass" id="green_pass_count" name="green_pass_count" required max="100" min="1" value="<?= $green_count;?>">
					</div>
					 </div>
					 </div>
					 <div class="row">
					 <div class="col-lg-4 col-sm-4 col-4 mb-4">
					<div class="box">
					<select class="Yellow">
					<option>Yellow</option>
					</select>
					</div>
					 </div>
					 <div class="col-lg-8 col-sm-8 col-8 mb-4">
					 <div class="form-group grey_box">
					<input type="number" min="1" class="form-control" placeholder="Number of pass" id="yellow_pass_count" name="yellow_pass_count" required max="100" min="1" value="<?= $yellow_count;?>">
					</div>
					 </div>
					 </div>
                  </div>
               </div>
			   <button type="button" class="btn btn-primary" onclick="approver_passes();">Generate Passes</button>
               <!--<p class="p_tag_bottom">A CoVIRED initiative</p>
            </div>
         </div>
      </div>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
	  <script>
	  $('.dropdown-menu li').on('click', function() {
  var getValue = $(this).text();
  $('.dropdown-select').text(getValue);
});
	  </script>
   </body>
</html>-->
<script type="text/javascript">
function approver_passes(){
    var approver_id = $('#approver_id').val();
    var green_pass_count = $('#green_pass_count').val();
    var yellow_pass_count = $('#yellow_pass_count').val();
      $.ajax({
        url: "common/action.php",
        type: "POST",
        data: {
            'action': "approver_pass_count",
            'approver_id': approver_id,
            'green_pass_count':green_pass_count,
            'yellow_pass_count':yellow_pass_count
        },
        success: function (response){
          // alert(response);
             var data = $.parseJSON(response);
            // alert(data.status);
              if(data.status ==0){
                  error_alert(data.message);
              }
              if(data.status ==1){
                //$('#user_mobile').val(mobile);
                var user_approver_id = $('#user_approver_id').val();
                var pass_url = 'passes_6.php?approver_id='+approver_id+'&user_id='+user_approver_id;
                //alert(pass_url);
                success_alert(data.message, pass_url);
              }
        }
      });
}
</script>