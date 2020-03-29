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
               <form name="form_requester" id="form_requester" method="POST" enctype="multipart">
               <div class="container">
         <h4 class="text-center"><strong>Please register your details</strong></h4>
               <div class="card mb-3 mt-3">
                  <div class="card-body passes_list">
                     <div class="row">
           <div class="col-lg-12 col-12">
           <div class="row">
           <div class="col-lg-12 col-12">
           <div class="form-group grey_box">
              <input type="text" class="form-control" placeholder="Enter your name" id="name" name="name">
           </div>
           </div>
           <div class="col-lg-12 col-12">
           <div class="form-group grey_box">
              <input type="text" class="form-control" placeholder="Enter your city" id="city" name="city">
           </div>
           </div>
           <div class="col-lg-12 col-12">
           <div class="form-group grey_box">
              <input type="text" class="form-control" placeholder="Enter your aadhar number" id="aadhar_number" name="aadhar_number">
           </div>
           </div>
           <div class="col-lg-12 col-12 mb-3">
           <label>Choose how we can know its you</label>
           </div>
           <div class="col-lg-6 col-sm-6 col-6">
           <div class="avatar-wrapper">
            <img class="profile-pic" src="img/camera.png" />
            <div class="upload-button">
              <!-- <i class="fa fa-arrow-circle-up" aria-hidden="true"></i> -->
              <!-- <img alt="" class="fa fa-arrow-circle-up icon_img" src="img/camera.png"> -->
            </div>
            <input class="file-upload" type="radio" id="user_proof" name="user_proof" value="photo">
          </div>
           </div>
           <div class="col-lg-6 col-sm-6 col-6">
           <div class="avatar-wrapper_">
            <img class="profile-pic_" src="img/mole.png" />
            <div class="upload-button_">
              <!-- <i class="fa fa-arrow-circle-up" aria-hidden="true"></i> -->
              <!-- <img alt="" class="fa fa-arrow-circle-up icon_img" src="img/camera.png"> -->
            </div>
            <input class="file-upload_" type="radio" id="user_proof" name="user_proof" value="birthmark">
          </div>
           </div>
           </div>
           </div>
           </div>
                  </div>
               </div>
         <button type="button" class="btn btn-primary" onclick="save_requester()" id="">Next</button>
         </form>
         </div>
               <!--<p class="p_tag_bottom">A CoVIRED initiative</p>
            </div>
          
         </div>
      </div>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      -->
      <script type="text/javascript">
function save_requester(){
    var ele = document.getElementsByName('user_proof'); 
    for(i = 0; i < ele.length; i++) { 
        if(ele[i].checked){ 
           user_proof = ele[i].value;
        }
    } 
    var form_name = 'form_requester';

    
    var user_type_id = $('#user_type_id').val();
    var user_mobile = $('#user_mobile').val();
    var req_org = $('#req_org').val();
    var req_services = $('#req_services').val();
    var req_qr_code = $('#req_qr_code').val();
    var req_pass_type = $('#req_pass_type').val();
    var req_pass_id = $('#req_pass_id').val();

    var params = $('#' + form_name).serialize();

    var form = $('#' + form_name)[0];
    var data = new FormData(form);
    console.log(data);
    // If you want to add an extra field for the FormData
    data.append("action", 'register');
    data.append('user_type_id',user_type_id);
    if(user_type_id==4){
        data.append('user_category_id',2); // yellow for volunteer 
    }else{
        data.append('user_category_id',1); // green for requester 
    }
    
    data.append('approver_id',req_org);
    data.append('services',req_services);
    data.append('user_proof',user_proof);
    data.append('qr_code',req_qr_code);
    data.append('pass_type',req_pass_type);
    data.append('mobile',user_mobile);
    data.append('pass_id',req_pass_id);

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
                $('#user_id').val(data.user_id);
                if(user_proof=='photo'){
                   // redirect_url = 'requester_register_2.php';
                }
                if(user_proof =='birthmark'){
                   // redirect_url = 'requester_register_3.php';
                }
                redirect_url = 'approver_user_details.php?user_id='+data.user_id;
                success_alert(data.message,redirect_url);
              }
            //alertify.alert("Success", data.msg, function () {
            /*alertify.notify(data.msg,"Success",1, function () {
                window.location.href = BASE_URL + data.redirect_url;
            });*/
        }
    });
}
</script>

    <script>
    $(document).ready(function() {
  
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-pic').attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
   
    $(".file-upload").on('change', function(){
        readURL(this);
    });
    
    $(".upload-button").on('click', function() {
       $(".file-upload").click();
    });
  
});
    </script>
    
    <script>
    $(document).ready(function() {
  
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('.profile-pic_').attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }
    }
   
    $(".file-upload_").on('change', function(){
        readURL(this);
    });
    
    $(".upload-button_").on('click', function() {
       $(".file-upload_").click();
    });
  
});
    </script>
   </body>
</html>