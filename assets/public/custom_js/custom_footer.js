$(document).ready(function(){
    var base_url = $(document).find('#baseurl').val();
    $(".forgot" ).hide();
    $('#otp_form_reg').hide();
    $( ".triggerforgot" ).click(function() {
        $( ".forgot" ).toggle( "slow");
    });

    $('#transfer_submit').click(function(e){
        e.preventDefault();
        var sta = $("#transfer_form").validationEngine("validate");
        if(sta== true){

            var cur= $(this);
            var data=$("#transfer_form").serializeArray();
            $('.body_blur').show();

            $.post(base_url+'user/Money_transfer/transfer_amount', data, function(data){


                $('.body_blur').hide();

                if(data.status){
                    noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                    $('#transfer_form')[0].reset();
                }
                else{
                    noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                }

            },'json');
        }

    });
    $('#wallet_ids').change(function(){
        var wallet_id=  $(this).val();
        $.post(base_url+'home/type_wallet',{ id:wallet_id}, function(data){
            if(data.status)
            {
                var num = data.value;


                $("#wallet_value").show();
                $("#wallet").val(num);
            }
        },'json');
    });
    $('.input_price').on('input', function(){
        var current_rs = $(this).parent().parent().find('.current_rs').text();
        var current_rs = isNaN(current_rs) ? 0 : current_rs;

        var entered_rs = isNaN(parseFloat($(this).val())) ? 0 : parseFloat($(this).val());
        get_wallet_billing();
        if(entered_rs > current_rs)
        {
            noty({text:"Not enough Money in this wallet", type: 'error',layout: 'center', timeout: 2000});
        }else{


        }



    });

    $('#submit_billing').click(function(e){
        e.preventDefault();

        var st = $("#billing_form").validationEngine("validate");

        if(st == true)
        {
            var datas = $('#billing_form').serializeArray();
            $.post(base_url+'user/purchase/give_notification', datas, function(data){
                if(data.status)
                {
                    noty({text:"under verification", type: 'success', layout: 'top', timeout: 2000});
                    $('#billing_form')[0].reset();
                    $('#billing').modal('hide');
                }else{
                    noty({text:data.reason, type: 'error', layout: 'top', timeout: 2000});
                }
            },'json');

        }else{
            //   noty({text:"Not enough Money in this wallet", type: 'error',layout: 'center', timeout: 2000});
        }
    });
    $('.sub_forgot').click(function(e){
        e.preventDefault();
        var cur = $(this);
        var uname = cur.parent().parent().parent().find('.forgot_uname').val();

        $.post(base_url+'admin/login/forgot_password', {uname:uname}, function(data){
            if(data.status){
                noty({text: 'password sent to your email', type: 'success', timeout:1000});
            } else{
                noty({text: data.reason, type: 'error', timeout:2000});
            }

        },'json');
    });

    $('.continue_login').click(function(e){
        e.preventDefault();
        var st = $("#login_form").validationEngine("validate");
        if(st == true)
        {

            var datas = $('#login_form').serializeArray();
            $('.body_blur').show();
            $.post(base_url+'user/login/login_process', datas, function(data){
                $('.body_blur').hide();
                if(data.status)
                {
                    swal({
                     title: "Success!",
                     text: "Login Successfully",
                     type: "success",
                     timer: 2000
                     });
                     function () {
                       location.reload();
                     };
                }else{
                    swal("Warning", data.reason, "warning");
                }
            },'json');

        }
    });
    $('.submit_otp').click(function(e){
        e.preventDefault();
        var otp_entered = $("#otp_form_reg").find('#reg_otp').val();
        if(otp_entered != '')
        {

            var datas = $('#otp_form_reg').serializeArray();
            $('.body_blur').show();
            $.post(base_url+'register/validate_otp', datas, function(data){
                $('.body_blur').hide();
                if(data.status)
                {
                    swal({
                     title: "Success!",
                     text: "Your registration completed Successfully Please login",
                     type: "success",
                     timer: 2000
                     });
                     function () {
                        window.location = base_url+'home';
                     };
                    // noty({text:"Your registration completed Successfully Please login", type: 'success',layout: 'center', timeout: 2000});
                    
                }else{
                    // noty({text:data.reason, type: 'error',layout: 'top', timeout: 2000});
                    swal("Warning", data.reason, "warning");
                }
            },'json');

        }


    });

    $('#transfer_submit').click(function(e){
        e.preventDefault();
        var sta = $("#transfer_form").validationEngine("validate");
        if(sta== true){

            var cur= $(this);
            var data=$("#transfer_form").serializeArray();
            $('.body_blur').show();

            $.post(base_url+'user/Money_transfer/transfer_amount', data, function(data){
                $('.body_blur').hide();

                if(data.status){
                    noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                    $('#transfer_form')[0].reset();
                    $('#transfer_modal').modal('hide');
                }
                else{
                    noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                }

            },'json');
        }

    });

    $('.btn_register').click(function(e){
        e.preventDefault();
        var st = $("#register_form").validationEngine("validate");
        if(st == true)
        {

            var datas = $('#register_form').serializeArray();

            $('.body_blur').show();
            $.post(base_url+'register/new_customer', datas, function(data){
                $('.body_blur').hide();
                if(data.status)
                {
                    var data = data.data;
                    $('#register_form :input').attr('readonly','readonly');
                    $('#otp_form_reg').show('slow');
                    $('#otp_form_reg').find('#email').val(data.email);
                    $('#otp_form_reg').find('#mobile').val(data.phone);
                    swal("Good job!", "A verification code has been sent to your mobile and email", "success");
                    // noty({text:"A verification code has been sent to your mobile and email", type: 'success',layout: 'center', timeout: 2000});
                    $('#otp_model').modal({backdrop: 'static', keyboard: false });
                }else{
                    swal("Warning", data.reason, "warning");
                    // noty({text:data.reason, type: 'error',layout: 'top', timeout: 2000});

                }
            },'json');

        }


    });



    //start arya


    $('#ba_send').click(function(e){
        e.preventDefault();
        var sta = $("#ba_form").validationEngine("validate");
        if(sta== true){
            var cur= $(this);
            var data=$("#ba_form").serializeArray();
            $('.body_blur').show();
            $.post(base_url+'home/ba_mail', data, function(data){
                if(data.status){
                    $('.body_blur').hide();
                    noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                    $('#ba_form')[0].reset();

                }
                else{
                    noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                }
            },'json');
        }
    });







    //end sumesh






    //end sumesh kk





    $(".txsrch").on('keyup', function(e) {
        $(".search_dropdown").toggle();
        e.stopPropagation();
    });
    $(document).click(function(e) {
        if (!$(e.target).is('.search_dropdown, .search_dropdown *')) {
            $(".search_dropdown").hide();
        }
    });
});

