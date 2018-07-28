<?= $header; ?>

<body>

<div class="wrapper">

<?= $sidebar; ?>

<div class="content">
<div class="container-fluid">
<div class="row">
<?php if($status==1) { ?>
<div class="col-md-12">
<!-- card  -->
<div class="card">
<div class="card-header card-header-icon" data-background-color="purple">
    Notification
</div><br><br>
<div class="card-content">
<!--    <h4 class="card-title">Commision</h4>-->
<div class="toolbar">
    <!--        Here you can write extra buttons/actions for the toolbar              -->
</div>
<div class="material-datatables">

<div class="row">
                                <div class="col-sm-offset-7 col-sm-3">
                                    <label class="pull-right">Search:</label>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control search" name="search" id="search" placeholder="" style="margin-top: -36px">
                                </div>
                            </div><br>
<table id="datatables" class="table datatables table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
       style="width:100%">
<thead>
<tr><th>No</th>
    <th>Name</th>
    <th>Phone</th>
    <th>Email</th>
    <th>Wallet Total</th>
   
    <th>Action</th>
</tr>
</thead>

<tbody>

</tbody>

<tfoot>
<td colspan="6">
    <div class="pull-right" id="pagination"></div>
</td>
</tfoot>
</table>
</div>
</div>
<!-- end content-->
</div>
<!--  end card  -->
</div>
<!-- end col-md-12 -->
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
<!-- end row -->
</div>


</div>


    <div class="modal fade" id="aprv" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-notice">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">close</i></button>
                    <h5 class="modal-title" id="myModalLabel">OTP</h5>
                </div>
                <div class="modal-body">
                    <div class="instruction">
                        <div class="row">
                            <form method="post" id="otp_forms" class="otp_forms" name="otp_forms" action="<?php echo base_url();?>admin/Channel_partner/purchase_approvel_byotp">


                                <div class="col-md-8">

                                    <div class="input-group">
                                            <span class="input-group-addon">
                                               <i class="material-icons">visibility</i>
                                            </span>
                                        <div class="form-group label-floating">
                                            <label class="control-label">Enter your otp here</label>
                                            <input type="hidden" placeholder="" class="form-control" id="hiddenotp" name="hiddenotp">
                                        <input type="text" class="form-control" name="purchase_otp" id="purchase_otp" data-rule-required="true" data-rule-number="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    
                                    <button type="submit" class="btn btn-fill btn-rose otp_sub" name="otp_sub" id="otp_sub">Verify</button>
                                </div>
                            </form>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>


<div class="modal fade" id="saled_cat_modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="z-index: 999999999">
    <div class="modal-dialog modal-notice" style="overflow-y: scroll; max-height:80%; ">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">close</i></button>
                <h5 class="modal-title" id="">Purchase Details</h5>
            </div>
            <div class="modal-body">
                <div class="instruction">
                    <div class="row">
                        <form method="post" class="calc_percnt_form" id="calc_percnt_form" action="<?php echo base_url();?>admin/Channel_partner/total_percentage">
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
                            <div class="col-md-12 get_category">
                            
                                <div class="input-group">
                                            <span class="input-group-addon">
                                               <i class="material-icons">visibility</i>
                                            </span>
                                    <div class="form-group label-floating">
                                        <label class="control-label"></label>
                                        <input type="text" class="form-control">
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="notyid" id="notyid" class="form-control">
                            <div class="col-md-4">
                                <button type="submit" class="btn btn-fill btn-rose make_payment">Submit</button>
                               
                            </div>
                        </form>

                    </div>
                </div>

            </div>

        </div>
    </div>
</div>

<?= $footer; ?>




<script src="<?php echo base_url(); ?>assets/admin/js/paging.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){
                    $('#coupon_div').hide();
                    $('[name="have_coupon"]').change(function()
                      {
                        if ($(this).is(':checked')) {
                           $( "#coupon_div" ).toggle( "slow");
                        }else{
                            $("#coupon_div" ).hide();
                        }
                      });  
                    var base_url = "<?php echo base_url(); ?>";
                    function load_demo(index) {
                        index = index || 0;
                        var search = $('#search').val();
                        $.post(base_url + "cp_notification/" + index, { ajax: true,search:search}, function(data) {
                            console.log(data);
                            $('tbody').html("");
                            $('.body_blur').hide();
                            var tr = '';
                            if(data.status){
                                var data1 = data.data;

                                //var data1=data11.produ;
                                for(var i = 0; i< data1.length; i++){
                                    var cur_index=parseInt(index);
                                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                                    tr += '<tr>'+
                    '<input type="hidden" value="'+data1[i].noty_id+'" class="hiddentype_id">'+

                                        '<td>'+sl_no+'</td>'+
                                        '<td>'+data1[i].name+'</td>'+
                                        '<td class="mobile">'+data1[i].phone+'</td>'+

                                         '<td class="email">'+data1[i].email+'</td>'+
                                        
                                        '<td>'+data1[i].wallet_total+'</td>'+
                                      
                                        '<td><button type="button" class="btn btn-fill btn-rose approve">Approve </button></td>'+
                                        '</tr>';
                                }
                                $('tbody').html(tr);
                                $('#search').val(data.search);
                                // pagination
                                $('#pagination').html(data.pagination);

                            }else{
                                 tr += '<tr>'+
                                        '<td colspan="6" style="text-align:center">No Data Found</td>'+
                                        '</tr>';
                                $('tbody').html(tr);
                            }
                        }, "json");
                    }
                    //calling the function
                    load_demo();
                    //pagination update
                    $('#pagination').on('click', '.page_test a', function(e) {
                        e.preventDefault();
                        //grab the last paramter from url
                        var link = $(this).attr("href").split(/\//g).pop();
                        load_demo(link);
                        return false;
                    });
                    $("#search").keyup(function(){
                        load_demo();
                    });
                });                
</script>

<script>
$(document).ready(function(){
    $(document).on('click','.approve',function(){
       // $("#agree1").modal('show');

        var cur=$(this);
        var hiddentype_id=cur.parent().parent().find('.hiddentype_id').val();
        var mobile=cur.parent().parent().find('.mobile').text();
        var emailll =cur.parent().parent().find('.email').text();
        $(document).find('#hiddenotp').val(hiddentype_id);
         $('.body_blur').show();
        $.post("<?php echo base_url();?>admin/Channel_partner/purchase_otp",{hiddentype_id : hiddentype_id,mobile : mobile, emailll:emailll},  function(data){
            $('.body_blur').hide();
            if(data.status){
           
                $("#aprv").modal('show');
                var purch_id = data.data;
                                     
            }
            else{
                var regex = /(<([^>]+)>)/ig;
                    if(data.reason1){
                        var body = data.reason1;
                    }else if(data.reason2){
                        var body = data.reason2;
                    }else{
                        var body = data.reason;
                    }
                        
                        var result = body.replace(regex, "");
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                        var effect='fadeInRight';
                        $("#notifications").append(center);
                        $("#notifications-full").addClass('animated ' + effect);
                        $('.close').click(function(){
                            $(this).parent().fadeOut(1000);
                            if(data.reason1 || data.reason2){
                                $('body').alertBox({
                                    title: 'Do you want to delete this billing?',
                                    lTxt: 'Back',
                                    lCallback: function(){
                                      
                                    },
                                    rTxt: 'Okey',
                                    rCallback: function(){
                                        $('.body_blur').show();
                                        $.post('<?php echo base_url();?>delete_billing/',{billing_id:hiddentype_id}, function(data){
                                            $('.body_blur').hide();
                                            if(data.status){
                                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully deleted </div></div>';
                                                var effect='zoomIn';
                                                $("#notifications").append(center);
                                                $("#notifications-full").addClass('animated ' + effect);
                                                refresh_close();
                                            }else{
                                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+data.reason+'</div></div>';
                                                var effect='fadeInRight';
                                                $("#notifications").append(center);
                                                $("#notifications-full").addClass('animated ' + effect);
                                                refresh_close();
                                            }
                                        },'json');
                                    }
                                })
                             }
                         });
                
            }
        },'json');

    });
    var v1 = jQuery("#otp_forms").validate({
        
        submitHandler: function(datas) {
        $('.body_blur').show();
       
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {
                $('.body_blur').hide();
                console.log(data);
                if(data.status)
                {
                    var notyid = data.notyid;
                    $("#aprv").modal('hide');
                    $('#calc_percnt_form').find('#notyid').val(notyid);
                    $('#calc_percnt_form').find('#wallet_amt').val(data.wallet);
                    var data= data.data;
                    var div =''; 
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
                                '<input type="text"  class="form-control amount" name="amount[]" onKeyPress="return isFloatKey(event)">'+
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
                       
                       $("#saled_cat_modal").modal('show');
                       
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
                     refresh_close();
                    setTimeout(function(){
                      if(data.type=="no_commission"){
                          window.location.href="<?= base_url(); ?>set_commission/0";   
                        }else{
                            $("#aprv").modal('hide');
                            location.reload();
                        }  
                    }, 1000);
                }
            }
        });
        }
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
        if(net>=0){
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
    var v2 = jQuery("#calc_percnt_form").validate({
       
        submitHandler: function(datas) {
         
        $('.body_blur').show();
       
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {
                $('.body_blur').hide();
                console.log(data);
                if(data.status)
                {
                     var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully finished billing</div></div>';
                                var effect='zoomIn';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                refresh_close();
                                setTimeout(function(){
                                    $("#saled_cat_modal").modal('hide');
                                    $('#calc_percnt_form')[0].reset();
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
});
</script>  


</body>
<div id="notifications"></div><input type="hidden" id="position" value="center">
<style type="text/css">
  #notifications{
    z-index: 9999999999;
  }
</style>
</html>