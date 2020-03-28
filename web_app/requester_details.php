<!-- <!DOCTYPE html>
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
			   <h4 class="text-center"><strong>Please register your details</strong></h4>
			   <form> -->
                <?php 
              include_once ('web_api/include/DbHandler.php');
                 $DbHandler = new DbHandler();
            $arr_org = $DbHandler->get_active_org();
            $arr_org = $arr_org['data'];
            $arr_services = $DbHandler->get_active_services();
            $arr_services = $arr_services['data'];
         
               ?>
               <form name="form_appr" id="form_appr" method="POST" enctype="multipart">
               <div class="card mb-3 mt-3">
                  <div class="card-body passes_list">
                     <div class="row">
                        <div class="col-lg-12 col-12">
                           <div class="row">
								<div class="col-lg-12 col-12">
								<div class="form-group grey_box">
								<label for="sel1">Select Organization</label>
								<select  id="organisation_id" name="organisation_id" class="form-control" required>
                          <option value=''> Select Organisation </option>
                          <?php if(is_array($arr_org) && count($arr_org)!=0){
                              foreach($arr_org as $org){ 
                          ?>
                             <option value="<?= $org['id'];?>" selected><?= $org['org_name'];?></option>
                          <?php } 
                          }?>
                      </select>
								</div>
								</div>
                              <div class="col-lg-12 col-12">
                                 <div class="form-group grey_box">
								 <label for="sel1">Services</label>
                          <select  id="service_id" name="service_id" class="form-control" required>
                                         <option value=''> Select Nature of Service </option>
                                         <?php if(is_array($arr_services) && count($arr_services)!=0){
                                             foreach($arr_services as $service){ 
                                         ?>
                                            <option value="<?= $service['service_id'];?>" selected><?= $service['service_name'];?></option>
                                         <?php } 
                                         }?>
                                     </select>
                                   <!--  <input type="text" class="form-control" placeholder="Enter Services" id=""> -->
                                 </div>
                              </div>
                              <div class="col-lg-12 col-12">
                                 <div class="form-group grey_box">
								 <label for="sel1">Approver details</label>
                                    <input type="text" class="form-control" placeholder="Approver mobile number" id="apr_mobile">
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </form>
               <button type="button" class="btn btn-primary" onclick="save_appr()" id="">Submit</button>
			  <!--  </form>
               <p class="p_tag_bottom">A CoVIRED initiative</p>
            </div>
         </div>
      </div>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
   </body>
</html> -->

<script type="text/javascript">
function save_appr(){
   
   var organisation_id = $('#organisation_id').val();
   var  apr_mobile= $('#apr_mobile').val();
   //  var data = new FormData(form);
   // data.append("action", 'check_appr');
   //  data.append('organisation_id',organisation_id);
   //  data.append('apr_mobile',apr_mobile);

   $.ajax({
        type: 'POST',
      
        url: "common/action.php",
        type: "POST",
        data: {action:"check_appr",organisation_id:organisation_id,apr_mobile:apr_mobile},

        success: function (data) {
            alert(data);
            
             if(data.status ==0){
                  error_alert(data.message);
              }
             
        }
    });

    var form_name = 'form_appr';
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
   
    // If you want to add an extra field for the FormData
    data.append("action", 'save_appr');
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
        success: function (data) {
            alert(data);
            
             if(data.status ==0){
                  error_alert(data.message);
              }
              if(data.status ==1){
                $('#approver_id').val(data.approver_id);
                success_alert(data.message,'requester_details.php');
              }
            //alertify.alert("Success", data.msg, function () {
            /*alertify.notify(data.msg,"Success",1, function () {
                window.location.href = BASE_URL + data.redirect_url;
            });*/
        }
    });
}
</script>