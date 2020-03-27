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
		 <div class="button_box">
		 <div class="div_btn" onclick="toggleVisibility('Menu2');"><img alt="approver_black" src="img/approver_black.png"></div>
		 <div class="div_btn active" onclick="toggleVisibility('Menu1');"><img alt="black" src="img/black.png"></div>
		 </div>
            <div class="col-lg-6 col-sm-6 col-12 mx-auto">
               <img alt="Janata Pass" class="logo" src="img/logo.png">
               <h1>Janata Pass</h1>
               <div class="card mb-3 mt-3">
                  <div class="card-body passes_list">
                     <div class="row">
					 <div class="col-lg-12 col-12">
					 <div id="Menu1">
					 <div class="row">
					 <div class="col-lg-12 col-12">
					  <h4>Here are you passes</h4>
					 </div>
					 </div>
					 <div class="row">
					 <div class="col-lg-12">
					 <button class="btn btn-success">Pass #1</button> <p>LFZPA</p>
					 </div>
					 </div>
					 <div class="row">
					 <div class="col-lg-12">
					 <button class="btn btn-success">Pass #1</button> <p>LFZPA</p>
					 </div>
					 </div>
					 <div class="row">
					 <div class="col-lg-12">
					 <button class="btn btn-success">Pass #1</button> <p>LFZPA</p>
					 </div>
					 </div>
					 <div class="row">
					 <div class="col-lg-12">
					 <button class="btn btn-success">Pass #1</button> <p>LFZPA</p>
					 </div>
					 </div>
					 <div class="row">
					 <div class="col-lg-12">
					 <button class="btn btn-yellow">Pass #1</button> <p>LFZPA</p>
					 </div>
					 </div>
					 <div class="row">
					 <div class="col-lg-12">
					 <button class="btn btn-yellow">Pass #1</button> <p>LFZPA</p>
					 </div>
					 </div>
					 </div>
					 <div id="Menu2" style="display:none;">
					 <img alt="black" src="img/black.png" class="scanner" >
					 <h3 class="text-center">Pandi</h3>
					 <div class="row">
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p>Organization</p>
					 </div>
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p>Appolo</p>
					 </div>
					 </div>
					 <div class="row">
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p>Address</p>
					 </div>
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p>Chennai</p>
					 </div>
					 </div>
					 <div class="row">
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p>City</p>
					 </div>
					 <div class="col-ld-6 col-sm-6 col-6">
					 <p>Tricy</p>
					 </div>
					 </div>
					 <div class="row">
					 <div class="col-ld-12 col-sm-12 col-12 mt-3 text-center">
					 <button class="btn btn-info2">Go to home</button>
					 </div>
					 </div>
					 </div>
					 </div>
					 </div>
                  </div>
               </div>
			   
               <p class="p_tag_bottom">A CoVIRED initiative</p>
            </div>
         </div>
      </div>
      <script src="js/jquery.min.js"></script>
      <script src="js/popper.min.js"></script>
      <script src="js/bootstrap.min.js"></script>
	      <script>
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
</html>