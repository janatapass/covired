function error_alert(message){
     iziToast.error({
                    title: 'Warning',
                    message: message,
                     buttons: [
                    ['<button>Ok</button>', function (instance, toast) {
                       instance.hide({
                        transitionOut: 'fadeOutUp'
                    }, toast, 'buttonName');
                    }, true]
                ]
                });
}

function success_alert(message,redirect=false){
    iziToast.success({
        title: 'Success',
        message: message,
         buttons: [
        ['<button>Ok</button>', function (instance, toast) {
           instance.hide({
            transitionOut: 'fadeOutUp',
            onClosing: function(instance, toast, closedBy){
                if(redirect!=""){
                    window.location.href = BASE_URL + redirect;
                } 
                console.info('closedBy: ' + closedBy); // The return will be: 'closedBy: buttonName'
            }
        }, toast, 'buttonName');
        }, true]
        ]
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
            //alert(response);
             var data = $.parseJSON(response);
            // alert(data.status);
              if(data.status ==0){
                  error_alert(data.message);
              }
              if(data.status ==1){
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
            alert(response);
             var data = $.parseJSON(response);
            // alert(data.status);
              if(data.status ==0){
                  error_alert(data.message);
              }
              if(data.status ==1){
                success_alert(data.message,'warning_3.php');
              }
        }
      });
}  


 function selectNext(){
 
  var check = $('#customCheck1').prop('checked')
  var check1 = $('#customCheck2').prop('checked')
  console.log("check", check, check1)
 }
