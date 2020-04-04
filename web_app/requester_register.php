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
               //echo 'asdfsdfsdf';
                include_once ('web_api/include/DbHandler.php');
                $DbHandler = new DbHandler();
                //print_r($DbHandler);
                $arr_relationship = array('FATHER'=>'Father','MOTHER'=>'Mother','BROTHER'=>'Brother','SISTER'=>'Sister','SON'=>'Son','DAUGTHER'=>'Daughter','FRIEND'=>'Friend');
                $arr_city = $DbHandler->get_city_names();
                //print_r($arr_city);
                //$arr_city = array('Chennai'=>'Chennai',"Bangalore"=>"Bangalore","Hyderabad"=>"Hyderabad","Cochi"=>"Cochi");
               ?>
               <form name="form_requester" id="form_requester" method="POST" enctype="multipart">
               <input type="hidden" id="longitude" name="longitude" />
               <input type="hidden" id="latitude" name="latitude" />
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
              <input type="text" class="form-control" placeholder="Enter your aadhar number" id="aadhar_number" name="aadhar_number">
           </div>
           </div>
           <div class="col-lg-12 col-12">
           <div class="form-group grey_box">
              <input type="text" class="form-control" placeholder="Enter your address" id="address" name="address">
           </div>
           </div>
           <div class="col-lg-12 col-12">
           <div class="form-group grey_box">
              <!--<input type="text" class="form-control" placeholder="Enter your city" id="city" name="city">-->
              <select class="form-control" id="city" name="city" onchange="load_locality('div_locality')">
                  <option value=''>Select City</option>
                  <?php
                   foreach($arr_city as $ckey=>$city){
                       ?>
                       <option value="<?= $city['city_name'];?>"><?= $city['city_name'];?></option>
                       <?php
                   }
                   ?>
              </select>
           </div>
           </div>
           <div class="col-lg-12 col-12">
           <div class="form-group grey_box">
               <div id='div_locality' name="div_locality">
                <select class="form-control" id="locality" name="locality">
                     <option value=''>Select Locality</option>
                </select>
                </div>
           </div>
           </div>
           <div class="col-lg-12 col-12">
           <div class="form-group grey_box">
              <input type="text" class="form-control" placeholder="Enter your pincode" id="pincode" name="pincode">
           </div>
           </div>
           <?php if(isset($_REQUEST['user_type']) && $_REQUEST['user_type']==3){ ?>
            <div class="col-lg-12 col-12">
               <div class="form-group grey_box">
                  <input type="text" class="form-control" placeholder="Name of the Person to share trip details " id="share_with_name" name="share_with_name">
               </div>
            </div>
            <div class="col-lg-12 col-12">
               <div class="form-group grey_box">
                   <select class="form-control" placeholder="Relationship " id="relationship" name="relationship">
                       <option value="">Relationship</option>
                   <?php
                   foreach($arr_relationship as $key=>$relationship){
                       ?>
                       <option value="<?= $key;?>"><?= $relationship;?></option>
                       <?php
                   }
                   ?>
                   </select>
                  <!--<input type="text" class="form-control" placeholder="Relationship " id="relationship" name="relationship">-->
               </div>
           </div>
           <div class="col-lg-12 col-12">
               <div class="form-group grey_box">
                  <input type="text" class="form-control" placeholder="Share Person Mobile Number " id="share_with_mobile" name="share_with_mobile">
               </div>
            </div>
           <?php } ?>
           <div class="col-lg-12 col-12 mb-3">
           <label>Choose how we can know its you</label>
           </div>
		   <div class="btn-group btn-group-toggle col-lg-12 col-12 mb-3" data-toggle="buttons">
    		<div class="col-lg-6 col-sm-6 col-6 pl-1 pr-0">
        		<label class="btn btn-secondary active">
        		<input type="radio" id="user_proof" name="user_proof" value="photo" autocomplete="off" checked> 
        		<div class="avatar-wrapper">
        		<img class="profile-pic" src="img/camera.png" />
        		<div class="upload-button">
        		</div>
        		</div>
        		Take my picture
        		</label>
    		</div>
    		<div class="col-lg-6 col-sm-6 col-6 pr-1">
        		<label class="btn btn-secondary">
        		<input type="radio"id="user_proof" name="user_proof" value="birthmark" autocomplete="off"> 
        		<div class="avatar-wrapper">
        		<img class="profile-pic" src="img/mole.png" />
        		<div class="upload-button">
        		</div>
        		</div>
        		Enter mode/birthmark
        		</label>
    		</div>
		</div>
           <!--<div class="col-lg-6 col-sm-6 col-6">
           <div class="avatar-wrapper">
            <img class="profile-pic" src="img/camera.png" />
            <div class="upload-button">
            </div>
            <input class="file-upload" type="radio" id="user_proof" name="user_proof" value="photo">
          </div>
           </div>
           <div class="col-lg-6 col-sm-6 col-6">
           <div class="avatar-wrapper_">
            <img class="profile-pic_" src="img/mole.png" />
            <div class="upload-button_">
            </div>
            <input class="file-upload_" type="radio" id="user_proof" name="user_proof" value="birthmark">
           </div>
           </div>-->
           </div>
           </div>
           </div>
                  </div>
               </div>
         <button type="button" class="btn btn-primary" onclick="save_requester()" id="">Next</button>
         </form>
               <!--<p class="p_tag_bottom">A CoVIRED initiative</p>
            </div>
          
         </div>
      </div>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
      -->
      <script type="text/javascript">
      
      function load_locality(div_id){
    var city_name = $('#city').val();
   // alert(city_name);
     $.ajax({
        url: "common/action.php",
        type: "POST",
        data: {
            'action': "get_locality_names",
            'city_name': city_name
        },
        success: function (response){
          //  alert(response);
            $('#'+div_id).html(response);
        }
      });
}

//var x = document.getElementById("location");
function getLocation() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
   // x.innerHTML = "Geolocation is not supported by this browser.";
  }
}

function showPosition(position) {
    $('#latitude').val(position.coords.latitude);
    $('#longitude').val(position.coords.longitude);
 // x.innerHTML = "Latitude: " + position.coords.latitude +
  //"<br>Longitude: " + position.coords.longitude;
}
getLocation();

      
function save_requester(){
    var ele = document.getElementsByName('user_proof'); 
    for(i = 0; i < ele.length; i++) { 
        if(ele[i].checked){ 
           user_sel_proof = ele[i].value;
        }
    } 
   // alert(user_sel_proof);
    var form_name = 'form_requester';

    var redirect_url='';
    var user_type_id = $('#user_type_id').val();
    var user_mobile = $('#user_mobile').val();
    var req_org = $('#req_org').val();
    var req_services = $('#req_services').val();
    var req_qr_code = $('#req_qr_code').val();
    var req_pass_type = $('#req_pass_type').val();
    var req_pass_id = $('#req_pass_id').val();
    var latitude = $('#latitude').val();
    var longitude = $('#longitude').val();

    var params = $('#' + form_name).serialize();

    var form = $('#' + form_name)[0];
    var data = new FormData(form);
    console.log(data);
    // If you want to add an extra field for the FormData
    data.append("action", 'register');
    data.append('user_type_id',user_type_id);
    data.append('user_proof',user_sel_proof);
    data.append('mobile',user_mobile);
    data.append('latitude',latitude);
    data.append('longitude',longitude);
    
    // Color code for QR Code
    if(user_type_id==4){// yellow for volunteer
        data.append('user_category_id',2);  
    }else if(user_type_id==2){// green for requester 
        data.append('user_category_id',1); 
    }else{// pink for citizen 
        data.append('user_category_id',3); 
    }
    
    
   
    if(user_type_id==4 || user_type_id==2){ // approver details appended only for Requester/Volunteer
        data.append('approver_id',req_org);
        data.append('qr_code',req_qr_code);
        data.append('pass_type',req_pass_type);
        data.append('pass_id',req_pass_id);
        data.append('services',req_services);
    }

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
            //alert(user_sel_proof);
             //alert(response);
             var data = $.parseJSON(response);
             if(data.status ==0){
                  error_alert(data.message);
              }
              if(data.status ==1){
                $('#user_id').val(data.user_id);
                if(user_sel_proof=='photo'){
                   // redirect_url = 'requester_register_2.php';
                }else{
                    redirect_url = 'approver_user_details.php?user_id='+data.user_id;
                }
                if(user_sel_proof =='birthmark'){
                   redirect_url = 'birth_details.php?user_id='+data.user_id;
                }
                //
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

   <!-- <script>
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
    </script>-->
   </body>
</html>