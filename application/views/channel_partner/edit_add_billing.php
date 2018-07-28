<?= $header; ?>
<body>
<div class="wrapper">

    <?= $sidebar; ?>

    <div class="content">
        <div class="container-fluid">

        <?php if($status==1) { ?>
            <div class="col-md-12">

                <div class="card"  id="verify_user_form">
                    <div class="card-header card-header-text" data-background-color="orange">
                        <h4 class="card-title">Verify User</h4>

                    </div>

                    <div class="card-content">

                        <form method="post" action="<?php echo base_url();?>admin/channel_partner/verify_user" id="verify_mobile">
                            <div class="col-md-12">
                                <div class="form-group label-floating is-empty">
                                    <label>Mobile Number</label>
                                    <input type="text" class="form-control mobile" id = "mobile"  value="" name="mobile" data-rule-required ="true" onKeyPress="return isNumberKey(event)">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>

                            </div>

                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-fill btn-rose prosubmit" name="prosubmit" id="prosubmit">Verify</button>
                            </div>

                        </form>
                    </div>
                 </div>
                 <div class="card"  id="otp_form">
                    <div class="card-header card-header-text" data-background-color="orange">
                        <h4 class="card-title">Verify Otp</h4>

                    </div>    
                    <div class="card-content" >

                        <form method="post" action="<?php echo base_url();?>admin/channel_partner/verify_otp" id="otp_verify_form">

                            <div class="col-md-12 col-sm-9">

       
                            <div class="col-md-10">
                                <div class="form-group label-floating is-empty">
                                    <label>Enter your otp here</label>
                                    <input type="text" class="form-control" id = "otp"  value="" name="otp" data-rule-required ="true" onKeyPress="return isNumberKey(event)">
                                    <input type="hidden" class="form-control" id = "pur_id"  value="" name="pur_id" >
                                    <input type="hidden" class="form-control" id = "mob"  value="" name="mob" >
                                    <span class="material-input"></span><span class="material-input"></span></div>

                            </div>

                            </div>

                            <div class="col-md-12">
                                <!-- <a class="btn btn-fill btn-rose view_payment_info">Verify</a> -->
                                <button type="submit" class="btn btn-fill btn-rose prosubmit" name="otp_submit" id="otp_submit">Verify</button><button type="submit" class="btn btn-fill btn-rose resend" name="resend" id="resend">Resend</button>
                            </div>

                        </form>
                    </div>
                </div>
                <div class="card"  id="wallet_form">
                    <div class="card-header card-header-text" data-background-color="orange">
                        <h4 class="card-title">Wallet Details</h4>

                    </div>
                    <div class="card-content">

                       <form method="post" action="<?php echo base_url();?>admin/channel_partner/add_wallet" 
                        id="wallet_submit_form">

                            
                            <div class="col-md-12 col-sm-9">
                            <input type="hidden" name="purchase_id" id="purchase_id">
                            <input type="hidden" name="login_id" id="login_id">
                            <div class="col-md-12">
                                <div class="form-group label-floating is-empty">
                                    
                                      <table class="" style="width:80%;margin:auto;">                
                                        <tbody id="wallet_details"> 
                                        </tbody>
                                      </table> 
                                </div>

                            </div>

                            </div>

                            <div class="col-md-12">
                                <!-- <a class="btn btn-fill btn-rose view_payment_info">Verify</a> -->
                                <button type="submit" class="btn btn-fill btn-rose prosubmit" name="wallet_submit" id="wallet_submit">Add</button>
                            </div>

                        </form>
                    </div>
                </div>    
                <div class="card"  id="commission_form">
                    <div class="card-header card-header-text" data-background-color="orange">
                        <h4 class="card-title">Commission Details</h4>

                    </div>
                    <div class="card-content" >

                        <form method="post" action="<?php echo base_url();?>admin/channel_partner/total_percentage" id="commission_submit_form">
                            
                            <div class="col-md-12 col-sm-9">
                                    <div class="col-md-3">
                                        <div class="form-group label-floating is-empty">
                                            <label>Have Coupon : </label>
                                            <label><input type="radio" class="" value="Yes" name="have_coupon" > Yes</label>
                                            <label> <input type="radio" class="" value="No" name="have_coupon" > No</label>
                                            </div> 
                                    </div>
                                    <div id="coupon_div">
                                        <div class="col-md-3">
                                           <div class="form-group label-floating is-empty">
                                           <label>Enter Your Coupon Code :</label>
                                           <span class="material-input"></span><span class="material-input"> </span>
                                           </div> 
                                        </div>
                                        <div class="col-md-1">
                                           <div class="form-group label-floating is-empty">
                                           <input type="text" class="form-control " id = ""  value="JZ" name="" readonly>
                                           <span class="material-input"></span><span class="material-input"> </span>
                                           </div> 
                                        </div>
                                        <div class="col-md-2">
                                           <div class="form-group label-floating is-empty">
                                           <input type="text" class="form-control coupon_code" id = "coupon_code"  value="" name="coupon_code">
                                           <input type="hidden" name="coupon_id" id="coupon_id">
                                           
                                           <span class="material-input"></span><span class="material-input"> </span>
                                           </div> 
                                        </div>
                                        <div class="col-md-3">
                                           <div class="form-group label-floating is-empty">
                                           <input type="text" class="form-control coupon_amount" id = "coupon_amount"  value="" name="coupon_amount" readonly>
                                           <span class="material-input"></span><span class="material-input"> </span>
                                           </div> 
                                        </div>
                                    </div>    
                            </div> 
                            <div class="col-md-12 col-sm-9">
                                   
                                    <div class="col-md-6">
                                       <div class="form-group label-floating is-empty">
                                       <label>Wallet Used:</label>
                                       <span class="material-input"></span><span class="material-input"> </span>
                                       </div> 
                                    </div>
                                    <div class="col-md-2">
                                       <div class="form-group label-floating is-empty">
                                       <input type="text" class="form-control wallet_amt" id = "wallet_amt"  value="" name="wallet_amt">
                                      
                                       <span class="material-input"></span><span class="material-input"> </span>
                                       </div> 
                                    </div>
                                       
                            </div>
                            <div class="col-md-12 col-sm-9">

                            <input type="hidden" name="notyid" id="notyid">
                                <div class="form-group label-floating is-empty">
                                    
                                      <div class="col-md-12 get_category">
                                      </div> 
                                </div>
                            </div>

                            <div class="col-md-12">
                               
                                <button type="submit" class="btn btn-fill btn-rose prosubmit" name="commission_submit" id="commission_submit">Add</button>
                            </div>

                        </form>
                    </div>
                </div>    

               
            </div>
            <?php } else { ?>
              <div class="col-md-12">

                <div class="card">
                  
                 <div class="card-content">

                        <div class="alert alert-rose alert-with-icon" data-notify="container">
                         
                            <span data-notify="message"><h3>BILLING DEACTIVATED</h3>
                            <div class="alert alert-success"><span>
                            <input type="hidden" name="hidden_id" value="">
                            <b>Sorry! Your account has been frozen due failure in payment. Please clear all the dues and enjoy Jaazzo facilities.</span>
                            </div>
                           
                            </span>
                           
                            <A class="btn btn-default" href="<?= base_url(); ?>cp_transaction"> PAY NOW</a>
                           </div>

                         
                    </div>
                </div>
            <?php } ?>
        </div>
    
        <div id="notifications"></div><input type="hidden" id="position" value="center">
        <?= $footer; ?>


</body>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>

<script type="text/javascript">
                              
$(document).ready(function () {
    $('#otp_form').hide();
    $('#wallet_form').hide();
    $('#commission_form').hide();
    $('#coupon_div').hide();
    $('[name="have_coupon"]').change(function()
      {
        if ($(this).is(':checked')) {
          if($(this).val()=="Yes")
            {  
             $( "#coupon_div" ).show( "slow");
            }else{
               $("#coupon_div" ).hide(); 
            } 
        }else{
             $("#coupon_div" ).hide();
        }
      });    
    var v1 = jQuery("#verify_mobile").validate({
        
        submitHandler: function(datas) {
        $('.body_blur').show();
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {
                $('.body_blur').hide();
                if(data.status)
                {
                    var p_id = data.data.purchase_id;
                    var mob = data.data.mobile;
                    $('#verify_user_form').hide("fast");
                    $('#otp_form').show("slow");
                    $('#pur_id').val(p_id);
                    $('#otp_form').find('#mob').val(mob);
                   
                }
                else
                {
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    $('.close').click(function(){
                             $(this).parent().fadeOut(1000);
                    });
                }
            }
        });
        }
    });

    var v2 = jQuery("#otp_verify_form").validate({

        submitHandler: function(datas) {
        $('.body_blur').show();    
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {
                $('.body_blur').hide();
                if(data.status)
                {
                    var wallet = data.data.wallet;
                    console.log(data.data);
                    $('#otp_form').hide('fast');
                    $('#wallet_form').show('slow');
                    $('#login_id').val(data.data.login_id);
                    $('#purchase_id').val(data.data.purchase_id);
                     var tr = "";
                        var color = ['billing_walletbg1', 'billing_walletbg2', 'billing_walletbg3'];
                        for (var i = 0; i < wallet.length; i++) {
                               
                            tr += '<tr>'+
                                  '<td>'+
                                    '<div class="billing_wallet walletchld3 '+color[i]+'">'+
                                      '<div class="wlt">'+wallet[i].title+'</div>'+
                                      '<input type="hidden" name="wallet_id[]" class="form-control" size="16" value="'+wallet[i].id+'">'+
                                    '</div>'+
                                  '</td>'+
                                  '<td class="text-center">'+
                                    '<p class="form-control-static current_rs">'+wallet[i].total_value+'</p><input type="hidden" id="type" value="'+wallet[i].wallet_type_id+'">'+
                                  '</td>'+
                                  '<td>'+
                                    '<input type="text" name="price[]" class="form-control input_price" size="16" value="" onchange="price_change(this)" onKeyPress="return isFloatKey(event)">'+
                                  '</td>'+
                                '</tr>';
                        
                        }  
                     
                    tr += '<input type="hidden" id="sum_of_billing" name="sum_of_billing">';
                    $('#wallet_details').html(tr);
                   
                }
                else
                {
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    $('.close').click(function(){
                             $(this).parent().fadeOut(1000);
                    });
                }
            }
        });
        }
    });

 
    var v3 = jQuery("#wallet_submit_form").validate({
        
        submitHandler: function(datas) {
        $('.body_blur').show(); 
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {
                $('.body_blur').hide();
                if(data.status)
                {
                    
                    console.log(data.data);
                    $('#wallet_form').hide('fast');
                    var notyid = data.notyid;
                    $('#commission_form').find('#notyid').val(notyid);
                    $('#commission_form').find('#wallet_amt').val(data.wallet);
                    var data= data.data;
                    var div ='';
                   // console.log(data.length);
                       for(var i =0; i<data.length; i++)
                       {
                         
                         div += '<div class="col-md-12">'+
                         '<div class="col-md-4 col-sm-6">'+
                            '<div class="form-group label-floating is-empty">'+
                                '<label class="">Category</label>'+
                                '<input type="text" class="form-control" name="pro_name" value="'+data[i].category_title+'" readonly>'+
                                '<span class="material-input"></span><span class="material-input"></span></div></div>'+
                            '<div class="col-md-4 col-sm-6">'+
                            '<div class="form-group label-floating is-empty">'+
                                '<label class="">Percentage</label>'+
                                '<input type="text" class="form-control" name="percentage[]" value="'+data[i].percentage+'" readonly>'+
                                '<span class="material-input"></span><span class="material-input"></span></div></div>'+
                          '<div class="col-md-4 col-sm-6">'+
                            '<div class="form-group label-floating is-empty">'+
                                '<label class="">Amount</label>'+
                                '<input type="text" class="form-control amount" name="amount[]" onKeyPress="return isFloatKey(event)">'+
                                '<span class="material-input"></span><span class="material-input"></span></div></div>'+     
                        '</div>';
                   
                       }

                      div += '<div class="col-md-12">'+
                             '<div class="col-md-6">'+
                               '<div class="form-group label-floating is-empty">'+
                                 '<label class="">Total Bill</label>'+
                                 '<input type="text" class="form-control" name="total_bill" value="" id="total_bill" readonly>'+
                                 '<span class="material-input"></span><span class="material-input"></span>'+
                                '</div>'+
                              '</div>'+
                              '<div class="col-md-6">'+
                               '<div class="form-group label-floating is-empty">'+
                                 '<label class="">Net Bill</label>'+
                                 '<input type="text" class="form-control" name="net_bill" value="" id="net_bill" readonly>'+
                                 '<span class="material-input"></span><span class="material-input"></span>'+
                                '</div>'+
                              '</div>'+

                            '</div>';
                       
                       $("#commission_form").show();
                       
                       $('.get_category').html(div);
                 
                     
                   
                }
                else
                {
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    $('.close').click(function(){
                             $(this).parent().fadeOut(1000);
                    });
                    if(data.res_status=1){
                        setTimeout(function(){
                           window.location.href = "<?= base_url(); ?>set_commission/0";
                        }, 1000);                  
                    }
                }
            }
        });
        }
    });

    var v4 = jQuery("#commission_submit_form").validate({
        
        submitHandler: function(datas) {
        $('.body_blur').show(); 
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {
                $('.body_blur').hide();
                if(data.status)
                {
                    
                    console.log(data.data);
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully completed billing</div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        location.reload();
                    }, 1000);
                }
                else
                {
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    $('.close').click(function(){
                             $(this).parent().fadeOut(1000);
                    });
                }
            }
        });
        }
    });
    $(document).on('change','#coupon_code' ,function(){
       var coupon_code = $(this).val();
       $.post('<?php echo base_url();?>admin/Channel_partner/check_coupon_code', {coupon_code:coupon_code}, function(data){
                $('.body_blur').hide();

                if(data.status){
                   $("#coupon_amount").val(data.amount);
                   $("#coupon_id").val(data.id);
                   var total_bill = isNaN(parseFloat($('#total_bill').val())) ? 0 : parseFloat($('#total_bill').val());
                   var wallet_amt = isNaN(parseFloat($('#wallet_amt').val())) ? 0 : parseFloat($('#wallet_amt').val());
                   if(total_bill>0){
                      var net = parseFloat(total_bill)-(parseFloat(data.amount) + parseFloat(wallet_amt));
                      if(net>0){
                        $('#net_bill').val(net); 
                    }else{

                        var regex = /(<([^>]+)>)/ig;
                        var body = "Amount exceeds";
                        var result = body.replace(regex, "");
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                        var effect='fadeInRight';
                        $("#notifications").append(center);
                        $("#notifications-full").addClass('animated ' + effect);
                        $('.close').click(function(){
                            $(this).parent().fadeOut(1000);
                        });
                        $('#total_bill').val('');
                        $('#total_bill').val('');
                        $("#coupon_amount").val(''); 
                   }
                    }
                }
                else{
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    $('.close').click(function(){
                        $(this).parent().fadeOut(1000);
                    });
                    $("#coupon_amount").val('');  
                }
               
        },'json'); 
       
    });
    $(document).on('change','.amount' ,function(){
    
       var sum = 0;
        $( ".amount" ).each(function( index ) {
           var amount = $(this).val();
           amount = isNaN(parseFloat(amount)) ? 0 : parseFloat(amount);
           sum += amount;
        });
        var wallet = isNaN(parseFloat($('#wallet_amt').val())) ? 0 : parseFloat($('#wallet_amt').val());
        var coupon_amount = isNaN(parseFloat($('#coupon_amount').val())) ? 0 : parseFloat($('#coupon_amount').val());
        var net = parseFloat(sum)-(parseFloat(coupon_amount)+parseFloat(wallet));
        if(net>0){
           $('#total_bill').val(sum);
           $('#net_bill').val(net);
        }else{
                    var regex = /(<([^>]+)>)/ig;
                    var body = "Amount exceeds";
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    $('.close').click(function(){
                        $(this).parent().fadeOut(1000);
                    });
                    $('#total_bill').val('');
                    $('#total_bill').val(''); 
        } 
    });


    $(document).on('click','.resend' ,function(e){
       e.preventDefault();
            
            var cur = $(this);
            var pur_id = $('#otp_verify_form').find('#pur_id').val();
            var mobile = $('#otp_verify_form').find('#mob').val();
            $('.body_blur').show();

            $.post('<?php echo base_url();?>admin/Channel_partner/resend_otp', {pur_id:pur_id,mobile:mobile}, function(data){
                $('.body_blur').hide();

                if(data.status){
                   
                }
                else{
                   
                }
               
            },'json');      
    });

});
    function price_change(cur){
        var cur = $(cur);
        var base_url = '<?php echo base_url();?>';
        var current_rs =cur.parent().parent().find('.current_rs').text();
        var current_rs = isNaN(current_rs) ? 0 : current_rs;
        var entered_rs = isNaN(parseFloat(cur.val())) ? 0 : parseFloat(cur.val());
        var mobile = $('#otp_verify_form').find('#mob').val();
        get_wallet_billing();
        if(entered_rs > current_rs)
        {
           // swal("Warning!", "Not enough Money in this wallet", "error",{timer: 1500});

            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Not enough Money in this wallet</div></div>';
            var effect='fadeInRight';
            $("#notifications").append(center);
            $("#notifications-full").addClass('animated ' + effect);
            $('.close').click(function(){
                $(this).parent().fadeOut(1000);
            });
          cur.val('');
          $("#sum_of_billing").val('');
        }else{
          var type=cur.parent().parent().find('#type').val();
          if(type==1 || type==5){
            $.post(base_url+'admin/Channel_partner/check_usage_limit_exceed',{ amount:entered_rs,type:type,mobile:mobile}, function(data){
              console.log(data);
              if(data.status)
              {

              }else{
                var regex = /(<([^>]+)>)/ig;
                var body = data.reason;
                var result = body.replace(regex, "");
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                var effect='fadeInRight';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                $('.close').click(function(){
                    $(this).parent().fadeOut(1000);
                });
                // swal("Warning!", data.reason, "error",{timer: 1500});
                cur.val('');
                $("#sum_of_billing").val('');
              }
            },'json');
          }
        }
    }
    function get_wallet_billing()
    {
        var sum = 0;
        $('.input_price').each(function(){
            var cur = $(this);
            var money_wallet = parseFloat($(this).val());
            money_wallet = isNaN(money_wallet) ? 0 : money_wallet;
            sum = sum + money_wallet;
        });
        $('#sum_of_billing').val(sum);    
    }
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    } 
</script>
</html>