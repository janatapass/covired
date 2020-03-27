<!DOCTYPE html>
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
               <div class="card mb-3 mt-3">
                  <div class="card-body passes_list pt-5">
                     <div class="row">
                        <div class="col-lg-12 col-12">
                           <div class="row">
                              <div class="col-lg-12 col-sm-12 col-12">
                                 <div class="avatar-wrapper">
                                    <img class="profile-pic" src="img/camera.png" />
                                    <div class="upload-button">
                                       <!-- <i class="fa fa-arrow-circle-up" aria-hidden="true"></i> -->
                                       <!-- <img alt="" class="fa fa-arrow-circle-up icon_img" src="img/camera.png"> -->
                                    </div>
                                    <input class="file-upload" type="file" accept="image/*"/>
                                 </div>
                              </div>
							<div class="col-lg-12 col-sm-12 col-12">
							<div class="open_camera">
							<input type="file" accept="image/*" capture="camera" id="photo">
							<label for="photo">
							Open Camera
							</label>
							</div>
							</div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               <a href="requester_register_3"><button type="button" class="btn btn-primary" id="">Submit</button></a>
               <p class="p_tag_bottom">A CoVIRED initiative</p>
            </div>
         </div>
      </div>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
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
      
   </body>
</html>