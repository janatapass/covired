<?php 
   //print_r($_REQUEST);
   include_once ('web_api/include/DbHandler.php');
   $DbHandler = new DbHandler();
   $user_id = $_REQUEST['user_id'];
   $pass_id = $_REQUEST['pass_id'];
   $arr_user = $DbHandler->get_user_details($user_id,false);
   $arr_pass = $arr_user['passes'];
  // print_r($arr_user);
   $arr_user = $arr_user['data'];
   $approver_id = $arr_user['approver_id'];
  // print_r($arr_pass);
   $qr_code = $arr_user['qr_code'];
   $user_type = $arr_user['user_type_id'];
   $user_cat_type = $arr_user['user_category_id'];
   $color_code = ($user_cat_type!=3)?$arr_user['color_code']:'black';
   if($user_cat_type==3 && is_array($arr_pass) && count($arr_pass)!=0){
        $color_code = $arr_user['color_code'];
        //$arr_pass = $DbHandler->user_pass_details($pass_id);
        // get pass details
        $leave_pass_disable=true;
   }else{
       $leave_pass_disable = false;
   }
   //echo "User Type->".$user_cat_type."<br>";
   switch($user_cat_type){
       // Approver & Requester
       case '1': $class_name='green_grid';break;
       // volunteer
       case '2': $class_name='yellow_grid';break;
       // citizen
       case '3': $class_name='pink_grid';break;
   }
  // $DbHandler->generate_QR_code($qr_code,$color_code);
  // exit;
   ?>
			  
  <!--
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Janata Pass</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="css/bootstrap.min.css">
      <link rel="stylesheet" href="css/iziToast.min.css">
      <link rel="stylesheet" href="css/main.css">
	  
   </head>
<body class="janata_pass green"> 
      
         <div class="row h-100">
            <div class="col-lg-6 col-sm-6 col-12 mx-auto">-->
      <div class="card mb-3 mt-3">
               <input type="hidden" id="user_mobile" name="user_mobile" />
               <input type="hidden" id="user_otp" name="user_otp"/>
               <input type="hidden" id="user_type_id" name="user_type_id"/>
               <input type="hidden" id="approver_id" name="approver_id"/>

            <div class="card-body passes_list">
                <div class="row">
                    <div class="col-lg-12 col-12">
                        <div class="row mb-3">
                            <?php $DbHandler->generate_QR_code($qr_code,$color_code); ?>
                        </div>
                        <div class="row">
                            <div id="Menu2" class="col-12 w-100" style="display:block;">
					 <h3 class="text-center"><?= $arr_user['name'];?></h3>
					 <div class="row mb-2">
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p>Organization</p>
					 </div>
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p><?= $arr_user['name'];?></p>
					 </div>
					 </div>
					 <div class="row mb-2">
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p>Address</p>
					 </div>
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p><?= $arr_user['address'];?></p>
					 </div>
					 </div>
					 <div class="row mb-2">
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p>City</p>
					 </div>
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p><?= $arr_user['city'];?></p>
					 </div>
					 </div>
					 <div class="row mb-2">
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p>Pincode</p>
					 </div>
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p><?= $arr_user['pincode'];?></p>
					 </div>
					 </div>
					 <?php if($user_cat_type == 3){ 
					 if(is_array($arr_pass) && count($arr_pass)!=0){ 
					    foreach($arr_pass as $key=>$pass){
					 ?>
					 <div class="row mb-2">&nbsp;</div>
					  <div class="row mb-2">
    					 <div class="col-ld-6 col-sm-6 col-6">
    					    <p> Pass Details <?= ++$key;?> </p>
    					 </div>
    					 <div class="col-ld-6 col-sm-6 col-6">
    					    <div><?= $pass['travel_reason'];?> </div><br/>
    					    <div><?= $pass['location'];?></div>
    					    <div><?= date('h:i a',strtotime($pass['start_time']));?> - <?= date('h:i a',strtotime($pass['end_time']));?> </div>
    					    <div>Status : <?= ucwords(str_replace("_",strtolower($pass['travel_status'])));?></div>
    					 </div>
					 </div>
					 <div class="row mb-2">&nbsp;</div>
					 <?php }
					 } ?>
					 <div class="row">
					<div class="col-ld-12 col-sm-12 col-12 mt-3 text-center">
					<button class="btn btn-black" data-toggle="modal" data-target="#leave_pass"> Leave Pass</button>
					</div>
					</div>
					<?php } 
					// if approver 
					if($user_type==1){ ?>
					  <div class="row">
    					 <div class="col-ld-12 col-sm-12 col-12 mt-3 text-center">
    					    <button class="btn btn-info2" onclick='ajax_load("passes_6.php?approver_id=<?= $approver_id;?>&user_id=<?= $user_id;?>","div_main_body");'>View Passes </button>
    					 </div>
					 </div>
					<?php }?>
					 <!--<div class="row">
					 <div class="col-ld-12 col-sm-12 col-12 mt-3 text-center">
					 <button class="btn btn-info2">Go to home</button>
					 </div>
					 </div>-->
					 </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--</div>
        </div>-->
       
      
<script type="text/javascript">
$(document).ready(function(){
   $("#janata_body_class").addClass('<?= $class_name;?>');
   $('#approver_id').val("<?= $approver_id;?>");
   $('#user_id').val("<?= $user_id;?>");
   $('#user_type_id').val("<?= $user_type;?>");
   $('#user_approver_id').val("<?= $user_id;?>");
});

function create_pass(){
    //var start_time = $('#start_time').val();
  // alert(start_time);
    
    var form_name = 'form_pass';
    var params = $('#' + form_name).serialize();
    var form = $('#' + form_name)[0];
    var data = new FormData(form);
    console.log(data);
    // If you want to add an extra field for the FormData
    data.append("action", 'create_user_pass');
    data.append('user_id','<?= $_REQUEST['user_id'];?>');
    
    $.ajax({
        type: 'POST',
        enctype: 'multipart/form-data',
        url: "common/action.php",
        type: "POST",
        data: data,
        processData: false,
        contentType: false,
        cache: false,
        datatype: 'json',
        success: function (response) {
             //alert(response);
             var data = $.parseJSON(response);
             if(data.status ==0){
                  error_alert(data.message);
              }
              if(data.status ==1){
                  $('#pass_id').val(data.pass_id);
                redirect_url = 'approver_user_details.php?user_id='+<?= $_REQUEST['user_id'];?>+'&pass_id='+data.pass_id;
                success_alert(data.message,redirect_url);
                 $('#div_pass_modal').modal('hide');
              }
        }
    });

}
/*
$(document).ready(function() {

    $('.datepicker').datetimepicker({
        format: 'dd/mm/yyyy'
    });
});
	  $(function () {
  $("#start_time").datepicker({ 
        autoclose: true, 
        todayHighlight: true,
		format: "dd-mm-yyyy"
  }).datepicker('update', new Date());
  
  $("#end_time").datepicker({ 
        autoclose: true, 
        todayHighlight: true,
		format: "dd-mm-yyyy"
  }).datepicker('update', new Date());
});*/

	  </script>
	  <script>
	  $('#start_time, #end_time').on('changeDate', function(ev){
          $(this).datepicker('hide');
      }); 
	  </script>
			   
					 