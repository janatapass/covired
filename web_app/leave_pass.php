	<?php
	 include_once ('web_api/include/DbHandler.php');
     $DbHandler = new DbHandler();
     $user_mobile = isset($_REQUEST['user_mobile'])?$_REQUEST['user_mobile']:0;
     $city = isset($_REQUEST['city'])?$_REQUEST['city']:'';
     
     //$arr_reasons = array('Medical Emergency'=>'Medical Emergency','Buying groceries'=>"Buying groceries","ATM"=>"ATM");
     $arr_reasons = $DbHandler->travel_reasons();
     $arr_localities =  $DbHandler->locality_names($city);
     //$arr_duration = array('30 mins'=>'30 Minutes','1 hour'=>'1 Hour','2 hours'=>'2 Hours','3 hours'=>'3 Hours');
     //print_r($localities);
     //$arr_user = $DbHandler->get_citizen_details($user_mobile);
     //if(is_array($arr_user))
     //print_r($arr_reasons);
	?>
	<div class="modal-header">
          <h4 class="modal-title">Leave Pass</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" style="height:500px;overflow-y: auto;">
	<form name="form_pass" id="form_pass" method="POST">
	     <div class="form-group grey_box">
               
               <div class="row content">
                  <div class="col-ld-6 col-sm-6 col-6">
                      <label for="text">Mobile </label>
                     <span class="form-control"><?= $user_mobile;?> </span>
                  </div>
                  <div class="col-ld-6 col-sm-6 col-6">
                      <label for="text">Date </label>
                     <span class="form-control"><?=  date('d/m/Y');?> </span>
                  </div>
               </div>
            </div>
             <div class="form-group">
               <div class="row content">
                  <div class="col-ld-6 col-sm-6 col-6">
                    <div class="form-group grey_box">
        		<label for="text">Travel From *</label>
        		<!--<input type="text" class="form-control" id="trip_from"  name="trip_from" value="" placeholder="Trip From" >-->
        		<select class="form-control" id="trip_from"  name="trip_from">
        		    <option value=''> Trip From </option>
        		     <?php 
        		    if(is_array($arr_localities) && count($arr_localities)!=0){
        		    foreach($arr_localities as $locality){ ?>
    		        <option value='<?=  $locality['locality']?>'> <?= $locality['locality'];?></option>
    		        <?php } 
    		        }
    		        ?>
        		</select>
    		</div>
                  </div>
                  <div class="col-ld-6 col-sm-6 col-6">
                      <div class="form-group grey_box">
        		<label for="text">Travel To *</label>
        		<!--<input type="text" class="form-control" id="trip_to"  name="trip_to" value="" placeholder="Trip To" >-->
        		<select class="form-control" id="trip_to"  name="trip_to">
        		    <option value=''> Trip To </option>
        		    <?php 
        		    if(is_array($arr_localities) && count($arr_localities)!=0){
        		    foreach($arr_localities as $locality){ ?>
    		        <option value='<?=  $locality['locality']?>'> <?= $locality['locality'];?></option>
    		        <?php } 
    		        }
    		        ?>
        		</select>
    		</div>
                  </div>
               </div>
            </div>
    	<!--	 <div class="form-group grey_box">
        		<label for="text">Travel From *</label>
        		<input type="text" class="form-control" id="trip_from"  name="trip_from" value="" placeholder="Trip From" >
    		</div>
    		 <div class="form-group grey_box">
        		<label for="text">Travel To *</label>
        		<input type="text" class="form-control" id="trip_to"  name="trip_to" value="" placeholder="Trip To" >
    		</div>-->
    	
    	    <div class="form-group">
               
               <div class="row content">
                  <div class="col-ld-6 col-sm-6 col-6">
                      <label for="text">Start Time *</label>
                     <div class="form-group">
                        <div class="input-group time" id="start_time_div">
                           <input class="form-control"  id="start_time" placeholder="HH:MM AM/PM"  /><span class="input-group-append input-group-addon"><span class="input-group-text"><i class="fa fa-clock-o"></i></span></span>
                           <!--<input class="form-control" id="end_time" placeholder="HH:MM AM/PM" /><span class="input-group-append input-group-addon"><span class="input-group-text"><i class="fa fa-clock-o"></i></span></span>-->
                        </div>
                     </div>
                  </div>
                  <div class="col-ld-6 col-sm-6 col-6">
                      <label for="text">Duration *</label>
                      <div class="form-group">
                          	<select class="form-control" id="duration"  name="duration" onchange="generate_end_time();">
                    		    <option value=''>Travel Duration </option>
                    		    <?php 
                    		    if(is_array($arr_duration) && count($arr_duration)!=0){
                    		    foreach($arr_duration as $dkey=>$duration){ ?>
                		        <option value='<?= $dkey;?>'> <?= $duration;?></option>
                		        <?php } 
                		        }
                		        ?>
                		    </select>
                      </div>
                     <!--<div class="form-group">
                        <div class="input-group time" id="end_time_div">
                           <input class="form-control"id="end_time" placeholder="HH:MM AM/PM" /><span class="input-group-append input-group-addon"><span class="input-group-text"><i class="fa fa-clock-o"></i></span></span>
                        </div>
                     </div>-->
                  </div>
               </div>
            </div>
            <div class="form-group grey_box">
    		    <label for="text">Reason for stepping out *</label>
    		    <select class="form-control" placeholder="Enter Reason for stepping out" id="travel_reason"  name="travel_reason">
    		        <option value=''> Select Travel Reason </option>
    		        <?php foreach($arr_reasons as $reason){ ?>
    		        <option value='<?= $reason['reason'];?>'> <?= $reason['reason'];?></option>
    		        <?php } ?>
    		    </select>
    		    <!--<input type="text" class="form-control" placeholder="Enter Reason for stepping out" id="travel_reason"  name="travel_reason">-->
    		</div>
    		<div class="form-group grey_box">
    		    <label for="text">Vehicle Number </label>
    		    <input type="text" class="form-control" placeholder="Vehicle Number" id="vehicle_number"  name="vehicle_number">
    		</div>
    		<div class="col-ld-12 col-sm-12 col-12 mt-3 text-left">
            <div class="card mb-3 mt-3" style="width: 25rem;">
              <div class="card-body text-left">
                <h5 class="card-title card-header">Suggested Guidance</h5>
                <p class="card-text"> 
                <footer class="blockquote-footer mb-2">If you are a senior citizen or you would need help (and you live in South/ South East Bangalore), please call the helpline 09946499464 for assistance</footer>
                <footer class="blockquote-footer mb-2">Please go to the nearest place to obtain the goods</footer>
                <footer class="blockquote-footer mb-2">Stay away from crowded shops</footer>
                <footer class="blockquote-footer mb-2">Wash your hands thoroughly after you return home</footer>
                <footer class="blockquote-footer mb-2">Do not step out if you are feeling unwell/ have symptoms of corona virus</footer>
                <footer class="blockquote-footer mb-2">To check the status of the spread of COVID19 virus in your area, please click this link 
                <a href="https://www.coronatracker.in" target="_blank" class="text-primary">coronatracker.in</a></footer>
                <input class="mb-2" type="checkbox" name="understand_check" id="understand_check" onclick="enable_leave_apply();" ></input><strong> I understand the guidance and will be abiding by them </strong> 
                </p>
              </div>
            </div>
            <div class="card mb-3 mt-3" style="width: 25rem;">
              <div class="card-body">
                  <p class="card-text mb-2"> 
                  <input type="checkbox"  name="liable_check" id="liable_check" onclick="enable_leave_apply();" ></input><strong> I understand this app is for self regulation and that i will still be held liable for my actions if found to be violating government issued guidelines  </strong>
                 </p>
              </div>
            </div>
    		</div>
    		<div class="col-ld-12 col-sm-12 col-12 mt-3 text-center">
    		<button type="button" onclick="create_pass()" class="btn btn-black" name="leave_pass_btn" id="leave_pass_btn" disabled>Apply</button>
    		</div>
		</form>
		</div>
		<script type="text/javascript">
		
		 function enable_leave_apply(){
       var check = $('#liable_check').prop('checked');
       var check1 = $('#understand_check').prop('checked');
//       alert(check);
       //console.log("check", check, check1)
       if(check ===true && check1 === true){
           $('#leave_pass_btn').prop('disabled',false);
           //window.location.href = "select_4.php";
           //ajax_load('select_4.php','div_main_body');
       } else {
            $('#leave_pass_btn').prop('disabled',true);
           //error_alert('Please select the checkboxes to move to next page');
           //alert('Fill checkbox');
       }
      }
      
		    $(document).ready(function(){
		            for(var i=30; i <= 180; i+=30){
		                j = (i / 60);
		                if(j<1){
                            $('#duration').append('<option value="'+i+'">'+i+' min'+'</option>');
		                }else{
		                    $('#duration').append('<option value="'+i+'">'+j+' hour'+'</option>');
		                }
                    }
                    
                    
                     for(var i=700; i<= 1700; i+=30){
                        var mins = i % 100;
                        var hours = parseInt(i/100);
                
                      if (mins > 45) {
                             mins = 0;
                             hours += 1;
                             i = hours * 100;
                        }
                
                        var standardTime = ' AM';
                
                        if(hours > 12){
                             standardTime = ' PM';
                             hours %= 13;
                             hours++;
                        }else{
                             hours %= 13;
                        }
                
                        //$('#start_time').append('<option value="'+i+'">'+('0' + (hours)).slice(-2)+':'+('0' +mins).slice(-2)+standardTime+'</option>');
                     }
		    });
		</script>
  <script id="rendered-js">
         if (/Mobi/.test(navigator.userAgent)) {
           // if mobile device, use native pickers
           $(".date input").attr("type", "date");
           $(".time input").attr("type", "time");
         } else {
           // if desktop device, use DateTimePicker
           $("#datepicker").datetimepicker({
    useCurrent: false,
    format: "L",
    showTodayButton: true,
    icons: {
      next: "fa fa-chevron-right",
      previous: "fa fa-chevron-left",
      today: 'todayText',
    }
  });
          $("#start_time_div input").datetimepicker({
             format: "LT",
			 allowInputToggle: true,
             icons: {
               up: "fa fa-chevron-up",
               down: "fa fa-chevron-down" } });
         	  
           /*$("#end_time_div input").datetimepicker({
             format: "LT",
			 allowInputToggle: true,
             icons: {
               up: "fa fa-chevron-up",
               down: "fa fa-chevron-down" } });*/
         
         
         }
         
         
    function getFormattedTime(time) {
     var postfix = "AM";
     var hour = time.getHours();
     var min = time.getMinutes();
    
     //format hours
     if (hour > 12) {
       hour = (hour - 12 === 0) ? 12 : hour - 12;
       postfix = hour === 0 ? "AM" : "PM";
     }
    
     //format minutes
     min = (''+min).length > 1 ? min : '0' + min;
     var end_time = hour + ':' + min + ' ' + postfix;
     //return hour + ':' + min + ' ' + postfix;
     $('#end_time').val(end_time);
}

         function generate_end_time(){
             var startTime = $('#start_time').val();
             var timeChange = $('#duration').val();
           // alert(start_time);
            var time = new Date();
            //var startTime = "12:01 PM";
            //var timeChange = 60; //60 minutes
            var startHour = startTime.split(':')[0];
            var startMin = startTime.split(':')[1].replace(/AM|PM/gi, '');
            
            time.setHours(parseInt(startHour));
            time.setMinutes(parseInt(startMin));
            
           // $("#start").html(getFormattedTime(time));
            
            //adjusted time
            time.setMinutes(time.getMinutes() + timeChange);
            $("#end_time").html(getFormattedTime(time));
    
        }
         //# sourceURL=pen.js
             
      </script>
	  <script type="text/javascript">
            $(function () {
                $('#datetimepicker2').datetimepicker({
                    locale: 'ru'
                });
            });
        </script>