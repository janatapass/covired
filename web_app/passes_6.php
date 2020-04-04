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
		 <div class="button_box">
		 <div class="div_btn" onclick="toggleVisibility('Menu2');"><img alt="approver_black" src="img/approver_black.png"></div>
		 <div class="div_btn active" onclick="toggleVisibility('Menu1');"><img alt="black" src="img/black.png"></div>
		 </div>
            <div class="col-lg-6 col-sm-6 col-12 mx-auto">
               <img alt="Janata Pass" class="logo" src="img/logo.png">
               <h1>Janata Pass</h1>-->
                <?php 
               //print_r($_REQUEST);
			   include_once ('web_api/include/DbHandler.php');
               $DbHandler = new DbHandler();
               $approver_id = $_REQUEST['approver_id'];
			   $arr_passes = $DbHandler->get_approver_passes($approver_id);
			   $arr_passes = $arr_passes['data'];
			   
			   //print_r($arr_passes);
			   
			   $user_id = $_REQUEST['user_id'];
			   $arr_user = $DbHandler->get_user_details($user_id,false);
			   $arr_user = $arr_user['data'];
			   //print_r($arr_user);
			   $qr_code = $arr_user['qr_code'];
			   $color_code = $arr_user['color_code'];
			   //print_r($arr_services);
			   ?>
               <div class="row">
		             <div class="button_box" onclick="ajax_load('approver_user_details.php?user_id=<?=$user_id;?>','div_main_body');">
            		 <div class="div_btn" ><img alt="approver_black" src="img/black.png"></div>
            		 <!--<div class="div_btn active" onclick="toggleVisibility('Menu1');"><img alt="black" src="img/approver_black.png"></div>-->
            		 </div>
              
               <div class="card mb-3 mt-3">
					 <div class="grid_position_abs">
            		<button class="btn btn-info w-100" onclick='ajax_load("generate_5.php?approver_id=<?= $approver_id;?>&user_id=<?= $user_id;?>","div_main_body");'>Add more passes</button>
					</div>
					<div class="card-body passes_list">
                     <div class="row">
					 <div class="col-lg-12 col-12">
					 <div id="Menu1">
					 <div class="row">
					 <div class="col-lg-12 col-12">
					  <h4>Here are you passes</h4>
					 </div>
					 </div>
					 <?php if(is_array($arr_passes) && count($arr_passes)!=0){
					 foreach($arr_passes as $key=>$pass){
					     $btn_class = ($pass['pass_type']=='G')?'btn-success':'btn-yellow';
					     $pass_status = $pass['pass_status']=='O'?'Open':'Assigned';
					 ?>
					  <div class="row">
    					 <div class="col-lg-12">
    					     <button class="btn <?= $btn_class;?> ">Pass #<?= ++$key;?></button> <p class="pl-3 mt-2"><?= $pass['qr_code'];?> <span class="font_14"><?= $pass_status;?></span></p>
    					 </div>
					 </div>
					 <?php
					     
					 }
					 }?>
										 </div>
										 <div class="row">
					 <div class="col-lg-12">
					 <p>Send them to your employees only 1 pass per employee</p>
					 </div>
					 </div>
					 <div class="row">
					    <div class="col-ld-12 col-sm-12 col-12 mt-3 text-center">
						 <button class="btn btn-info" onclick="ajax_load('approver_user_details.php?user_id=<?=$user_id;?>','div_main_body');"> Home </button>
					    </div>
					 </div>
					 <!--<div id="Menu2" style="display:none;">
					 <div class="scanner"><?php $DbHandler->generate_QR_code($qr_code,$color_code); ?> </div>
					 <h3 class="text-center"><?= $arr_user['name'];?></h3>
					 <div class="row">
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p>Organization</p>
					 </div>
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p><?= $arr_user['name'];?></p>
					 </div>
					 </div>
					 <div class="row">
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p>Address</p>
					 </div>
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p><?= $arr_user['address'];?></p>
					 </div>
					 </div>
					 <div class="row">
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p>City</p>
					 </div>
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p><?= $arr_user['address'];?></p>
					 </div>
					 </div>
					 <div class="row">
					 <div class="col-ld-12 col-sm-12 col-12 mt-3 text-center">
					 <button class="btn btn-info2">Go to home</button>
					 </div>
					 </div>
					 </div>-->
					 </div>
					 </div>
					 <!--<a href='approver_user_details.php'><button class="btn btn-info2"> Your QR Code </button></a>-->
					 </div>
                  </div>
               </div>
			   <!--
               <p class="p_tag_bottom">A CoVIRED initiative</p>
            </div>
         </div>
      </div>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
	      <script type="text/javascript">
         var divs = ["Menu1", "Menu2"];
         var visibleDivId = null;
         function toggleVisibility(divId) {
           if(visibleDivId === divId) {
             //visibleDivId = null;
           } else {
             visibleDivId = divId;
           }
           hideNonVisibleDivs();
         }
         function hideNonVisibleDivs() {
           var i, divId, div;
           for(i = 0; i < divs.length; i++) {
             divId = divs[i];
             div = document.getElementById(divId);
             if(visibleDivId === divId) {
               div.style.display = "block";
             } else {
               div.style.display = "none";
             }
           }
         }
               
      </script>
	  <script>
	  $(document).ready(function(){
  $('.div_btn').click(function(){
    $('.div_btn').removeClass("active");
    $(this).addClass("active");
});
});
  </script>
   </body>
</html>-->