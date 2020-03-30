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
               <div class="card mb-3 mt-3">
                  <div class="card-body">
                     <div class="row">
    					 <div class="col-lg-6 col-sm-6 col-6 mb-4" onclick="load_user_type_page('approver','approve_details_new.php');">
        					 <div class="grid_grey">
            					 <img alt="app_icon" class="app_icon" src="img/approver.png">
            					 <p>Approver</p>
        					 </div>
					    </div>
					 <div class="col-lg-6 col-sm-6 col-6 mb-4" onclick="load_user_type_page('requester','requester_details_change_page.php');">
    					 <div class="grid_grey">
        					 <a><img alt="app_icon" class="app_icon" src="img/requester.png"></a>
        					 <p>Requester</p>
    					 </div>
					 </div>
					 <div class="col-lg-6 col-sm-6 col-6" onclick="load_user_type_page('citizen','requester_register.php');">
    					 <div class="grid_grey">
        					 <a><img alt="app_icon" class="app_icon" src="img/general_citizen.png"></a>
        					 <p>General Citizen</p>
    					 </div>
					 </div>
					 <div class="col-lg-6 col-sm-6 col-6" onclick="load_user_type_page('volunteer','requester_details_change_page.php');">
    					 <div class="grid_grey">
        					 <img alt="app_icon" class="app_icon" src="img/volunteers.png">
        					 <p>Volunteers</p>
    					 </div>
					 </div>
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
   </body>
</html>-->
<script type="text/javascript">
function load_user_type_page(user_type,type_page){
   // alert(user_type);
    switch(user_type){
        case 'approver': 
            user_type_id = 1;
            ajax_load(type_page,'div_main_body');
            break;
      case 'requester': 
            user_type_id = 2;
            ajax_load(type_page,'div_main_body');
        break;
      case 'citizen': 
            user_type_id = 3;
            ajax_load(type_page,'div_main_body');
        break;
      case 'volunteer': 
            user_type_id = 4;
            ajax_load(type_page,'div_main_body');
        break;
        
    }
    $('#user_type_id').val(user_type_id);
}
</script>