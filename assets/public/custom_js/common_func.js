$(document).ready(function(){
    $(".forgot" ).hide();
    $( ".triggerforgot" ).click(function() {
        $( ".forgot" ).toggle( "slow");
        $( ".log" ).hide();
    });
    $( ".log_frm" ).click(function() {
        $( ".log" ).toggle( "slow");
        $( ".forgot" ).hide();
    });
    var base_url = $(document).find('#baseurl').val();
    //member sign up
    $('#otp_form_reg').hide();
    $('#otp_form_log').hide();
    var m = jQuery("#be_a_member").validate({
        rules: {
          //email: {
              //required: true,
          //    email: true//,
          // },
          phone: {
              required: true,
              minlength: 10
          },
          password: {
              required: true,
              minlength: 6
          },
          confirm_password: {
              required: true,
              minlength: 6
          },
          accept:{
          	required:true
          }
        },
        messages: {
          //email: {
              //required: "Please provide an Email",
          //    email: "Email is invalid"
          //},
          phone: {
              required: "Please provide a mobile no",
              minlength: "Mobile field must be at least 10 characters long"
          },
          password: {
              required: "Please provide password",
              minlength: "Password field must be at least 6 characters long"
          },
          confirm_password: {
              required: "Please provide confirm password",
              minlength: "Confirm Password field must be at least 6 characters long"
          },
          accept: {
              required: "Please provide agree T&C "
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas1 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
            var data = data.data;
	        $('#register_form :input').attr('readonly','readonly');
	        $('#otp_form_reg').show('slow');
	        $('#otp_form_reg').find('#email').val(data.email);
	        $('#otp_form_reg').find('#mobile').val(data.phone);
	        swal("Success!", "A verification code has been sent to your mobile and email", "success");
	        $('#otp_model').modal({backdrop: 'static', keyboard: false });
        } else{
          var regex = /(<([^>]+)>)/ig;
          var body = data.reason;
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
        }
      }
    };
    $('#be_a_member').submit(function(e){     
      e.preventDefault();
      if (m.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas1);  
      }          
    });
    //otp verification of member
    var otp = jQuery("#otp_form_reg").validate({
        rules: {
          reg_otp: {
              required: true
          }
        },
        messages: {
          reg_otp: {
              required: "Please provide your OTP"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas2 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          swal({ 
            title: "Success!",
            text: "Your registration completed Successfully",
            type: "success" 
            },
            function(){
               window.location = base_url+'home/profile';
          });
        } else{
          var regex = /(<([^>]+)>)/ig;
          var body = data.reason;
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
        }
      }
    };
    $('#otp_form_reg').submit(function(e){     
      e.preventDefault();
      if (otp.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas2);  
      }          
    });
    //Member become club member
    var bc = jQuery("#become_club").validate({
        rules: {
          club_plan: {
              required: true
          },
          type: {
              required: true
          }
        },
        messages: {
          club_plan: {
              required: "Please provide your Member Plan"
          },
          type: {
              required: "Please provide your Type"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas3 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
        	swal("Success!", "Congratulations .Your  membership plan has been changed!!", "success",{timer: 1500});
	          setTimeout(function(){
	              location.reload();
	          }, 1500);
        } else{
          var regex = /(<([^>]+)>)/ig;
          var body = data.reason;
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
        }
      }
    };
    $('#become_club').submit(function(e){     
      e.preventDefault();
      if (bc.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas3);  
      }          
    });
    //Be a Club member
    //$('#club_registration_otp_form').hide();
    var cm = jQuery("#club_registration").validate({
        rules: {
          /*cl_reg_mail: {
              //required: true,
              email: true//,
          },
          cl_reg_mobile: {
              required: true,
              minlength: 10
          },
          cl_reg_pass: {
              required: true,
              minlength: 6
          },
          cl_reg_cpass: {
              required: true,
              minlength: 6
          },*/
          club_plan:{
          	required:true
          },
          /*type:{
            required:true
          },*/
          agree:{
          	required:true
          },
        },
        messages: {
          /*cl_reg_mail: {
              //required: "Please provide an Email",
              email: "Email is invalid"
          },
          cl_reg_mobile: {
              required: "Please provide a mobile no",
              minlength: "Mobile field must be at least 10 characters long"
          },
          cl_reg_pass: {
              required: "Please provide password",
              minlength: "Password field must be at least 6 characters long"
          },
          cl_reg_cpass: {
              required: "Please provide confirm password",
              minlength: "Confirm Password field must be at least 6 characters long"
          },*/
          /*type: {
              required: "Please provide a type"
          },*/
          club_plan: {
              required: "Please select a package"
          },
          agree:{
              required: "Please check agree T&C "
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas4 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
        	var datas = data.data;
          swal("Success!", "You are successfully upgraded to Club Member", "success",{timer: 1500});
          setTimeout(function(){
              location.reload();
          }, 1500);
          /*  $('#club_registration_otp_form').show('slow');
            $('#club_registration_otp_form').find('.otp_reg_email').val(datas.email);
            $('#club_registration_otp_form').find('.otp_reg_phone').val(datas.phone);
        	swal("Success!", "A verification code has been sent to your mobile and email", "success",{timer: 1500});*/
        } else{
          var regex = /(<([^>]+)>)/ig;
          var body = data.reason;
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
        }
      }
    };
    $('#club_registration').submit(function(e){     
      e.preventDefault();
      if (cm.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas4);  
      }          
    });
    //OTP -Verification of Be a Club member
    /*$('#club_registration_otp_form').hide();
    var otp_cm = jQuery("#club_registration_otp_form").validate({
        rules: {
          otp_reg_confirm: {
              required: true
          }
        },
        messages: {
          otp_reg_confirm: {
              required: "Please provide your OTP"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas5 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
        	swal("Success!", "OTP is verified successfully.Welcome to Jazzo !!!", "success",{timer: 1500});
        	setTimeout(function(){
              window.location = base_url+'home';
            }, 1500);
        } else{
          var regex = /(<([^>]+)>)/ig;
          var body = data.reason;
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
        }
      }
    };
    $('#club_registration_otp_form').submit(function(e){     
      e.preventDefault();
      if (otp_cm.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas5);  
      }          
    });*/
    
    //Add member agent
    var ca = jQuery("#ca_forms").validate({
        rules: {
            name: {
                required: true,
                minlength: 3
            },
            /*email: {
                required: true,
                email: true,
            },*/
            mobile: {
                required: true,
                minlength: 10
            }

        },
        messages: {
          name: {
              required: "Please provide a name",
              minlength: "Name field must be at least 3 characters long"
          },
          /*email: {
              required: "Please provide an email",
              email: "Email is invalid"
          },*/
          mobile: {
              required: "Please provide a mobile no",
              minlength: "Mobile field must be at least 10 characters long"
          // },
          // ufile: {
          //     required: "Please provide a mobile no",
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas6 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          swal("Success!", "Your Club Agent Added Successfully.", "success",{timer: 1500});
          setTimeout(function(){
              location.reload();
          }, 1500);
        } else{
          var regex = /(<([^>]+)>)/ig;
          var body = data.reason;
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
        }
      }
    };
    $('#ca_forms').submit(function(e){     
      e.preventDefault();
      if (ca.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas6);  
      }          
    });
    //End
    //Add customer via Club agent
    var mem = jQuery("#mem_forms").validate({
        rules: {
          name: {
              required: true,
              minlength: 3
          },
          mail1: {
              email: true,
          },
          mobile1: {
              required: true,
              minlength: 10
          }
        },
        messages: {
          name: {
              required: "Please provide a name",
              minlength: "Name field must be at least 3 characters long"
          },
          mail1: {
              email: "Email is invalid"
          },
          mobile1: {
              required: "Please provide a mobile no",
              minlength: "Mobile field must be at least 10 characters long"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas7 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          swal("Success!", "Member Added Successfully.", "success",{timer: 1500});
          setTimeout(function(){
              location.reload();
          }, 1500);
        } else{
          var regex = /(<([^>]+)>)/ig;
          var body = data.reason;
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
        }
      }
    };
    $('#mem_forms').submit(function(e){     
      e.preventDefault();
      if (mem.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas7);  
      }          
    });
    //End
    //Login Start
    var log = jQuery("#login_form").validate({
        rules: {
          username: {
              required: true
          },
          password: {
              required: true,
              minlength: 6
          }
        },
        messages: {
          username: {
              required: "Please provide your username"
          },
          password: {
              required: "Please provide password",
              minlength: "Password field must be at least 6 characters long"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas8 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          if(data.reason){
              var data = data.reason;
              $('#login_form :input').attr('readonly','readonly');
              $('#otp_form_log').show('slow');
              $('#otp_form_log').find('#maill').val(data.email);
              $('#otp_form_log').find('#pasword').val(data.password);
              swal("Success!", "A verification code has been sent to your mobile and email", "success");
          }else{
            //swal("Success!", "Login Successfully.", "success",{timer: 1500});
            setTimeout(function(){
              //location.reload();
               window.location.href=base_url+"user_profile",true;
            }, 1500);
          }
        } else{
          var regex = /(<([^>]+)>)/ig;
          var body = data.reason;
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
        }
      }
    };
    $('#login_form').submit(function(e){     
      e.preventDefault();
      if (log.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas8);  
      }          
    });
    //Login End
    //Add Friend
    var add_frnd = jQuery("#add_friend").validate({
        rules: {
          /*mail1: {
              email: true,
          },*/
          mobile1: {
              required: true,
              minlength: 10
          }
        },
        messages: {
          /*mail1: {
              email: "Email is invalid"
          },*/
          mobile1: {
              required: "Please provide mobile no",
              minlength: "Mobile no. field must be at least 10 characters long"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas9 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          swal("Success!", "Invitation has been sent.", "success",{timer: 1500});
          setTimeout(function(){
              location.reload();
          }, 1500);
        } else{
          var regex = /(<([^>]+)>)/ig;
          var body = data.reason;
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
        }
      }
    };
    $('#add_friend').submit(function(e){     
      e.preventDefault();
      if (add_frnd.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas9);  
      }          
    });
  // End
  //Club Agent Signup
    var sign = jQuery("#become_club_agent").validate({
        rules: {
          email: {
              required: true,
              email: true,
          },
          password: {
              required: true,
              minlength: 6
          },
          cpassword: {
              required: true,
              minlength: 6
          }
        },
        messages: {
          email: {
              required: "Please provide an Email",
              email: "Email is invalid"
          },
          password: {
              required: "Please provide password",
              minlength: "Password field must be at least 6 characters long"
          },
          cpassword: {
              required: "Please provide confirm password",
              minlength: "Confirm Password field must be at least 6 characters long"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas10 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          swal("Success!", "Your registration completed Successfully Please login.", "success",{timer: 1500});
          setTimeout(function(){
              window.location=base_url+'home';
          }, 1500);
        } else{
          var regex = /(<([^>]+)>)/ig;
          var body = data.reason;
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
        }
      }
    };
    $('#become_club_agent').submit(function(e){     
      e.preventDefault();
      if (sign.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas10);  
      }          
    });
  // End
  $(document).on('change', '#sel_country',function(){
    var cur = $(this); 
    var country = cur.val();
    $('.body_blur').show();
    // $('#sel_state')[0].sumo.unload();
    $.post('get_state_by_country/'+country, function(data){
      $('.body_blur').hide();
      if(data.status)
      {
        var data = data.data;
        var option ='';
         option += '<option value="">Please Select</option>';
       for(var i=0; i<data.length; i++){
          option += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
       }
        $('.sel_state').html(option);
      } else{
       swal("Warning!", data.result, "error"); // noty({text: data.reason, type:error, timeout:1000});
      }
      $('#sel_state').SumoSelect({search: true, placeholder: 'select state'});
    },'json');
  });
  //
  //Club member Signup
    var cm_sign = jQuery("#become_club_member").validate({
        rules: {
          email: {
              required: true,
              email: true,
          },
          password: {
              required: true,
              minlength: 6
          },
          cpassword: {
              required: true,
              minlength: 6
          }
        },
        messages: {
          email: {
              required: "Please provide an Email",
              email: "Email is invalid"
          },
          password: {
              required: "Please provide password",
              minlength: "Password field must be at least 6 characters long"
          },
          cpassword: {
              required: "Please provide confirm password",
              minlength: "Confirm Password field must be at least 6 characters long"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas11 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          swal("Success!", "Your registration completed Successfully Please login.", "success",{timer: 1500});
          setTimeout(function(){
              window.location=base_url+'home';
          }, 1500);
        } else{
          var regex = /(<([^>]+)>)/ig;
          var body = data.reason;
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
        }
      }
    };
    $('#become_club_member').submit(function(e){     
      e.preventDefault();
      if (cm_sign.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas11);  
      }          
    });
  // End
  //Forgot password Start
    var forgot = jQuery("#forgot_pass").validate({
        rules: {
          forgot_username: {
              required: true
          }
        },
        messages: {
          forgot_username: {
              required: "Please provide your username"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas12 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          swal("Success!", "Please check your email to reset password.", "success",{timer: 1500});
          setTimeout(function(){
              location.reload();
          }, 1500);
        } else{
          
          swal("Warning!", common(data.reason), "error");
        }
      }
    };
    $('#forgot_pass').submit(function(e){     
      e.preventDefault();
      if (forgot.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas12);  
      }          
    });
  //Forgot password End
  //Money transfer Start
    var money_transfer = jQuery("#transfer_form").validate({
        rules: {
          transfer_type: {
              required: true
          },
          transfer_mobile: {
              required: true
          },
          transfer_amount: {
              required: true
          }
        },
        messages: {
          transfer_type: {
              required: "Please provide transfer type field"
          },
          transfer_mobile: {
              required: "Please provide mobile no. field"
          },
          transfer_amount: {
              required: "Please provide amount field"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas13 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          swal("Success!", "Transfered successfully", "success",{timer: 1500});
          setTimeout(function(){
              location.reload();
          }, 1500);
        } else{
          
          swal("Warning!", common(data.reason), "error");
        }
      }
    };
    $('#transfer_form').submit(function(e){     
      e.preventDefault();
      if (money_transfer.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas13);  
      }          
    });
  //Money transfer end
});
$(document).ready(function(){
  var base_url = $(document).find('#baseurl').val();

  $('#wallet_ids').change(function(){
    var wallet_id=  $(this).val();
    $.post(base_url+'home/type_wallet',{ id:wallet_id}, function(data){
      console.log(data);
      if(data.status)
      {
        var num = data.value;
        $("#wallet_value").show();
        $("#wallet").val(num);
      }
    },'json');
  });
  $('#transfer_amount').on('change', function(){
    var current_rs = $(this).parent().parent().find('#wallet').val();
    var type=$(this).parent().parent().find('#wallet_ids').val();
    var current_rs = isNaN(current_rs) ? 0 : current_rs;
    var entered_rs = isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val());
    get_wallet_billing();
    if(type){
      if(entered_rs > current_rs)
      {
        swal("Warning!", "Not enough Money in this wallet", "error",{timer: 1500});
      }else{
        var type=$(this).parent().parent().find('#wallet_ids').val();
        if(type==1){
          $.post(base_url+'Home/check_usage_limit',{ amount:entered_rs}, function(data){
            console.log(data);
            if(data.status)
            {

            }else{
              swal("Warning!", data.reason, "error",{timer: 1500});
              $("#transfer_amount").val('');
            }
          },'json');
        }
      }
    }else{
      swal("Warning!", "You have to select a wallet", "error",{timer: 1500});
    }
  }); 
  $('.input_price').on('change', function(){
    var cur = $(this);
    var current_rs = $(this).parent().parent().find('.current_rs').text();
    var current_rs = isNaN(current_rs) ? 0 : current_rs;
    var entered_rs = isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val());
    get_wallet_billing();
    if(entered_rs > current_rs)
    {
      swal("Warning!", "Not enough Money in this wallet", "error",{timer: 1500});
      cur.val('');
      $("#sum_of_billing").val('');
    }else{
      var type=$(this).parent().parent().find('#type').val();
      
      if(type==1 || type==5){
        $.post(base_url+'Home/check_usage_limit_exceed',{ amount:entered_rs,type:type}, function(data){
          console.log(data);
          if(data.status)
          {

          }else{
            swal("Warning!", data.reason, "error",{timer: 1500});
            cur.val('');
            $("#sum_of_billing").val('');
          }
        },'json');
      }
    }
  });

  //Billing Start
    var billing = jQuery("#billing_form").validate({
        rules: {
          channel_partner_id: {
              required: true
          }
        },
        messages: {
          channel_partner_id: {
              required: "Please provide shop name field"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas14 = { 
      dataType : "json",
      success:   function(data){
        
        if(data.status){
         // $('.body_blur').hide();
          swal("Success!", "Under verification", "success",{timer: 1500});
          setTimeout(function(){
            $('#billing_form')[0].reset();
            $('#billing').modal('hide');
            location.reload();
            
          }, 1500);
        } else{
          
          swal("Warning!", common(data.reason), "error");
        }
      }
    };
    $('#billing_form').submit(function(e){     
      e.preventDefault();
      if (billing.form()) 
      {
       // $('.body_blur').show();
        $(this).ajaxSubmit(datas14);  
      }          
    });
  //Billing end

  //BA Form Start
    var ba_frm = jQuery("#ba_form").validate({
        rules: {
          email: {
              required: true
          },
          phone: {
              required: true
          }
        },
        messages: {
          email: {
              required: "Please provide email field"
          },
          phone: {
              required: "Please provide mobile no. field"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas15 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          swal("Success!", "Successfully created", "success",{timer: 1500});
          setTimeout(function(){
            $('#ba_form')[0].reset();
          }, 1500);
        } else{
          swal("Warning!", common(data.reason), "error");
        }
      }
    };
    $('#ba_form').submit(function(e){     
      e.preventDefault();
      if (ba_frm.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas15);  
      }          
    });
  //BA Form end
  //Money transfer 2 Start
    var money_transfer2 = jQuery("#transfer_form2").validate({
        rules: {
          transfer_type: {
              required: true
          },
          transfer_mobile: {
              required: true
          },
          transfer_amount: {
              required: true
          }
        },
        messages: {
          transfer_type: {
              required: "Please provide transfer type field"
          },
          transfer_mobile: {
              required: "Please provide mobile no. field"
          },
          transfer_amount: {
              required: "Please provide amount field"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas16 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          swal("Success!", "Transferred successfully", "success",{timer: 1500});
          setTimeout(function(){
              location.reload();
          }, 1500);
        } else{
          
          swal("Warning!", common(data.reason), "error");
        }
      }
    };
    $('#transfer_form2').submit(function(e){     
      e.preventDefault();
      if (money_transfer2.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas16);  
      }          
    });
  //Money transfer end
    $('#wallet_ids2').change(function(){
      var wallet_id=  $(this).val();
      $.post(base_url+'home/type_wallet',{ id:wallet_id}, function(data){
        console.log(data);
        if(data.status)
        {
          var num = data.value;
          $("#wallet_value2").show();
          $("#wallet2").val(num);
        }
      },'json');
    });
    $('#transfer_amount2').on('change', function(){
      var current_rs = $(this).parent().parent().find('#wallet2').val();
     
      var current_rs = isNaN(current_rs) ? 0 : current_rs;
      var entered_rs = isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val());
      get_wallet_billing();
      if(entered_rs > current_rs)
      {
        swal("Warning!", "Not enough Money in this wallet", "error",{timer: 1500});
      }else{

      }
    });
    //Deactivate account
    var deact_accnt = $("#deactivate_accunt").validate({
      rules: {
        reason: {
            required: true
        }
      },
      errorElement: "label",
      errorClass: "error",
      messages: {
        reason: "Please select reason for leaving"
      }
    });
    var datz = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          // swal("Success!", "Your account has been deactivated successfully", "success",{timer: 1500});
          // setTimeout(function(){
            window.location.href=base_url,true;
          // }, 1500);
        } else{
          
          swal("Warning!", common(data.reason), "error");
        }
      }
    };
    $('#deactivate_accunt').submit(function(e){     
      e.preventDefault();
      if (deact_accnt.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datz);  
      }          
    });
  //Change Password Start
    /*var chng_pwd = $("#chng_pwd").validate({
      rules: {
        opassword: {
            required: true
        },
        npassword: {
            required: true,
            minlength: 6
        },
        cpassword: {
            required: true,
            minlength: 6,
            equalTo: "#npassword"
        }
      },
      errorElement: "label",
      errorClass: "error",
      messages: {
        opassword: "Enter Old Password",
        npassword: {
            required: "Enter a New Password",
            minlength: jQuery.format("Enter at least {0} characters")
        },
        cpassword: {
            required: "Enter Confirm Password",
            minlength: jQuery.format("Enter at least {0} characters"),
            equalTo: "Please enter the same password as above"
        }
      }
    });
    var datas17 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          swal("Success!", "Password changed successfully", "success",{timer: 1500});
          setTimeout(function(){
            window.location.replace=base_url+"Home/profile";
          }, 1500);
        } else{
          
          swal("Warning!", common(data.reason), "error");
        }
      }
    };
    $('#chng_pwd').submit(function(e){     
      e.preventDefault();
      if (chng_pwd.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas17);  
      }          
    });
*/  //Change Password end

});
function common(res)
{
  var regex = /(<([^>]+)>)/ig;
  var body = res;
  var result = body.replace(regex, "");
  return result;
}
//otp verification for deactivated log
    var otp_log = jQuery("#otp_form_log").validate({
        rules: {
          log_otp: {
              required: true
          }
        },
        messages: {
          log_otp: {
              required: "Please provide your OTP"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var log_otp = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          var base_url = $(document).find('#baseurl').val();
          window.location = base_url+'home/profile';
        } else{
          var regex = /(<([^>]+)>)/ig;
          var body = data.reason;
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
        }
      }
    };
    $('#otp_form_log').submit(function(e){     
      e.preventDefault();
      if (otp_log.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(log_otp);  
      }          
    });