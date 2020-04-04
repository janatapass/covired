 <!--<div class="row">
    <div class="col-lg-6 col-sm-6 col-12 mx-auto">
       <img alt="Janata Pass" class="logo" src="img/logo.png">
       <h1>Janata Pass</h1>-->
       <h4 class="text-center"><strong>Please register your details</strong></h4>
       <div class="card mb-3 mt-3">
          <div class="card-body passes_list">
             <div class="row">
                <div class="col-lg-12 col-12">
                   <div class="row">
                      <div class="col-lg-12 col-sm-12 col-12">
                         <h3>Provide details of your mole / Birth mark</h3>
						 <p class="pl-0 descrip mb-3">(You can use it to prove that is you to the traffic authorities)</p>
						 <form action="" id="form_bmark" name="form_bmark" method="POST">
						     <input type="hidden" value="<?= $_REQUEST['user_id'];?>" id="user_id" name="user_id"/>
						  <div class="form-group grey_box">
						   <textarea id="" class="form-control" placeholder="Description" id="user_birthmark" name="user_birthmark" rows="4" cols="50"></textarea>
						  </div>
						 </form>
                      </div>
                   </div>
                </div>
             </div>
          </div>
       </div>
       <button type="button" class="btn btn-primary" id="" onclick="save_birth_mark();">Submit</button>
       <!--<p class="p_tag_bottom">A CoVIRED initiative</p>
    </div>
 </div>-->
 <script type="text/javascript">
 function save_birth_mark(){
     var form_name = 'form_bmark';
     var birthmark = $('#user_birthmark').val();
     var user_id = $('#user_id').val();
      var form = $('#' + form_name)[0];
    var data = new FormData(form);
    console.log(data);
    // If you want to add an extra field for the FormData
    data.append("action", 'save_birthmark');
    data.append('user_id',user_id);
    data.append('user_birthmark',birthmark);
      $.ajax({
        type: 'POST',
        enctype: 'multipart/form-data',
        url: "common/action.php",
        type: "POST",
        data : data,
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
                var redirect_url = 'approver_user_details.php?user_id='+user_id;
                success_alert(data.message,redirect_url);
              }
        }
      });
     
 }
</script>