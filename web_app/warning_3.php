<!DOCTYPE html>
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
               <h1>Janata Pass</h1>
               <div class="card mb-3 mt-3">
                  <div class="card-body">
                     <img alt="warnig" class="warnig" src="img/warning.png">
                     <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever</p>
                  </div>
               </div>
               <div class="custom-control custom-checkbox mb-3">
                  <input type="checkbox" class="custom-control-input" id="customCheck1" checked>
                  <label class="custom-control-label" for="customCheck1">Please tick to confirm you will use the app responsibility</label>
               </div>
               <div class="custom-control custom-checkbox mb-3">
                  <input type="checkbox" class="custom-control-input" id="customCheck2" required>
                  <label class="custom-control-label" for="customCheck2">I am aware of the importance of the 21 day lockdown <a href="">Click to Watch</a></label>
               </div>
			   <button type="button" class="btn btn-primary" onclick="selectNext()" id="">Next</button>
               <p class="p_tag_bottom">A CoVIRED initiative</p>
            </div>
         </div>
      </div>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
     <script type="text/javascript">
         function selectNext(){
 
            var check = $('#customCheck1').prop('checked')
           var check1 = $('#customCheck2').prop('checked')
           console.log("check", check, check1)
           if(check && check1){
               window.location.href = "select_4.php";
           } else {
               alert('Fill checkbox')
           }
          }
     </script>
   </body>
</html>