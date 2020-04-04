function error_alert(message,redirect=''){
     iziToast.error({
                    title: 'Warning',
                    message: message,
                     buttons: [
                    ['<button>Ok</button>', function (instance, toast) {
                       instance.hide({
                        transitionOut: 'fadeOutUp',
                        onClosing: function(instance, toast, closedBy){
                            if(redirect!=""){
                               // window.location.href = BASE_URL + redirect;
                               ajax_load(redirect,'div_main_body');
                            } 
                            console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
                        }
                    }, toast, 'buttonName');
                    }, true]
                ]
                });
}

function success_alert(message,redirect=''){
    iziToast.success({
        title: 'Success',
        message: message,
         buttons: [
        ['<button>Ok</button>', function (instance, toast) {
           instance.hide({
            transitionOut: 'fadeOutUp',
            onClosing: function(instance, toast, closedBy){
                if(redirect!=""){
                   // window.location.href = BASE_URL + redirect;
                   ajax_load(redirect,'div_main_body');
                } 
                console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
            }
        }, toast, 'buttonName');
        }, false]
        ],
        onClosing: function(instance, toast, closedBy){
            if(redirect!=""){
               // window.location.href = BASE_URL + redirect;
               ajax_load(redirect,'div_main_body');
            } 
        }
    });
}

function ajax_load(url,div_id){
    //$('#loading').show();
    $.ajax({
        url:url,
        type: "POST",
        success: function(response) {
            $('#'+div_id).html(response);
            $('#'+div_id).show();
            $('#loading').hide();
            //alert(response);
            //alert("Item Added to Cart!");
            //window.location.href = BASE_URL + 'my_cart.php';
        }
    });
}

// common ajax function to submit forms
function ajax_fileform_submit(form_name, url, id) {
    var params = $('#' + form_name).serialize();
    var ajax_url = BASE_URL + url;
    //alert(ajax_url);
    // Get form
    var form = $('#' + form_name)[0];

    // Create an FormData object 
    var data = new FormData(form);
    // Attach file
    var obj_files = $('input[type=file]')[0];
    if (typeof obj_files.files[0] !== 'undefined') {
        data.append('photo', $('input[type=file]')[0].files[0]);
    }
    // If you want to add an extra field for the FormData
    //data.append("member_id", member_id);

    $.ajax({
        type: 'POST',
        enctype: 'multipart/form-data',
        url: ajax_url,
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
            var data = $.parseJSON(response);
            //alertify.alert("Success", data.msg, function () {
            alertify.notify(data.msg,"Success",1, function () {
                window.location.href = BASE_URL + data.redirect_url;
            });
        }
    });


}


function show_data_modal(url,div_id){
   
   // var ajax_url = BASE_URL + url;
    $.ajax({
        url: url,
        dataType: 'html',
        success: function(res) {
            $('div[id="div_'+div_id+'"]').html(res)
            $('div[id="'+div_id+'"]').modal('show');
        },
        error:function(request, status, error) {
            console.log("ajax call went wrong:" + request.responseText);
        }
    });
}
   

function request_otp(){
    var mobile = $('#mobile').val();
      $.ajax({
        url: "common/action.php",
        type: "POST",
        data: {
            'action': "verify_mobile",
            'mobile': mobile
        },
        success: function (response){
           // alert(response);
             var data = $.parseJSON(response);
             //alert(data.user_id);
             $('#user_id').val(data.user_id);
              if(data.status ==0 && data.user_id!=0){
                  //error_alert(data.message);
                  
                 
              }
              if(data.status ==1){
                $('#user_mobile').val(mobile);
                success_alert(data.message,'otp.php');
              }
        }
      });
}



function verifyOTP(){
    var mobile = $('#mobile').val();
    var otp1 = $('#otp1').val();
    var otp2 = $('#otp2').val();
    var otp3 = $('#otp3').val();
    var otp4 = $('#otp4').val();
    var total_otp =otp1+''+otp2+''+otp3+''+otp4;
      $.ajax({
        url: "common/action.php",
        type: "POST",
        data: {
            'action': "verify_otp",
            'mobile': mobile,
            'otp':total_otp
        },
        success: function (response){
           // alert(response);
             var data = $.parseJSON(response);
            // alert(data.status);
              if(data.status ==0){
                  error_alert(data.message);
              }
              if(data.status ==1){
                $('#user_otp').val(total_otp);
                var user_id = $('#user_id').val();
                //alert('user_id'+user_id);
                if(user_id!='' && user_id!=0){
                    redirect_url = 'approver_user_details.php?user_id='+user_id;
                }else{
                    redirect_url = 'warning_3.php';
                }
                success_alert(data.message,redirect_url);
              }
        }
      });
}  

// enable next button in the warning details page
 function enabletNext(){
       var check = $('#customCheck1').prop('checked');
       var check1 = $('#customCheck2').prop('checked');
//       alert(check);
       //console.log("check", check, check1)
       if(check ===true && check1 === true){
           $('#conditions_next').prop('disabled',false);
           //window.location.href = "select_4.php";
           //ajax_load('select_4.php','div_main_body');
       } else {
           //error_alert('Please select the checkboxes to move to next page');
           //alert('Fill checkbox');
            $('#conditions_next').prop('disabled',true);
       }
      }


function load_locality(div_id){
    var city_name = $('#city').val();
    alert(city_name);
     $.ajax({
        url: "common/action.php",
        type: "POST",
        data: {
            'action': "get_locality_names",
            'city_name': city_name
        },
        success: function (response){
            alert(response);
            $('#'+div_id).html(response);
        }
      });
}

