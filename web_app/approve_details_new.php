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
               <h1>Janata Pass</h1>
			   <form>-->
			   <?php 
			   include_once ('web_api/include/DbHandler.php');
               $DbHandler = new DbHandler();
			   $arr_services = $DbHandler->get_active_services();
			   $arr_services = $arr_services['data'];
			   //print_r($arr_services);
			   ?>
               <div class="card mb-3 mt-3">
                  <div class="card-body passes_list">
                     <div class="row">
                        <div class="col-lg-12 col-12">
                            <form name="form_approver" id="form_approver" method="POST" enctype="multipart">
                           <div class="row">
                              <div class="col-lg-12 col-12">
							  <h4 class="text-left mb-3"><strong>Organization details</strong></h4>
							  </div>
                              <div class="col-lg-12 col-12">
                                 <div class="form-group grey_box">
                                    <input type="text" class="form-control" placeholder="Enter organization name" id="org_name" name="org_name" required value="">
                                 </div>
                              </div>
                              <div class="col-lg-12 col-12">
                                 <div class="form-group grey_box">
                                    <input type="text" class="form-control" placeholder="Enter Location" id="org_location" name="org_location" required value="">
                                 </div>
                              </div>
                              <div class="col-lg-12 col-12">
                                 <div class="form-group grey_box">
                                    <input type="text" class="form-control" placeholder="Type of Organization" id="org_type" name="org_type" required value="">
                                 </div>
                              </div>
							  <div class="col-lg-12 col-12">
                                 <div class="form-group grey_box">
                                    <input type="email" class="form-control" placeholder="Enter business email address" id="org_email" name="org_email" required value="">
                                 </div>
                              </div>
                              <div class="col-lg-12 col-12">
                                 <div class="form-group grey_box">
                                     <select  id="service_id" name="service_id" class="form-control" required>
                                         <option value=''> Select Nature of Service </option>
                                         <?php if(is_array($arr_services) && count($arr_services)!=0){
                                             foreach($arr_services as $service){ 
                                         ?>
                                            <option value="<?= $service['service_id'];?>" selected><?= $service['service_name'];?></option>
                                         <?php } 
                                         }?>
                                     </select>
                                    <!--<input type="text" class="form-control" placeholder="Nature of service" id="service_id" name="service_id">-->
                                 </div>
                              </div>
                              <div class="col-lg-12 col-12">
							  <h4 class="text-left mb-3"><strong>Provide Evidence</strong></h4>
							  </div>
                               <div class="col-lg-12 col-sm-12 col-12 mb-3">
							<div class="open_camera mt-0 text-left">
							<input type="file" accept="image/*" capture="camera" id="org_proof" name="org_proof"> 
							<label for="org_proof">
							Upload a valid documents
							</label>
							</div>
							<small>e.g, Hospital registration, shop licence, etc</small>
							</div>
						
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <button type="button" class="btn btn-primary" onclick="save_approver()" id="">Submit</button>
               	</form>
			  <!-- </form>
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
function save_approver(){
    var form_name = 'form_approver';
    var user_type_id = $('#user_type_id').val();
    var mobile = $('#user_mobile').val();
    var params = $('#' + form_name).serialize();
    //var ajax_url = BASE_URL + url;
    //alert(ajax_url);
    // Get form
    var form = $('#' + form_name)[0];

    // Create an FormData object 
    var data = new FormData(form);
    // Attach file
    var obj_files = $('input[type=file]')[0];
    if (typeof obj_files.files[0] !== 'undefined') {
        data.append('org_proof', $('input[type=file]')[0].files[0]);
    }
    // If you want to add an extra field for the FormData
    data.append("action", 'save_approver');
    data.append('user_type_id',user_type_id);
    data.append('approver_mobile',mobile);

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
        beforeSend: function() { 
            $('#loading_gif').show(); 
        },
        complete: function() {
            $('#loading_gif').hide(); 
        },
        success: function (response) {
            alert(response);
            var data = $.parseJSON(response);
             if(data.status ==0){
                  error_alert(data.message);
              }
              if(data.status ==1){
                $('#approver_id').val(data.approver_id);
                $('#user_approver_id').val(data.user_approver_id);
                success_alert(data.message,'generate_5.php');
              }
            //alertify.alert("Success", data.msg, function () {
            /*alertify.notify(data.msg,"Success",1, function () {
                window.location.href = BASE_URL + data.redirect_url;
            });*/
        }
    });
}
</script>