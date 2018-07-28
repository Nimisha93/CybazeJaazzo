<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<style type="text/css">
    span.help-inline-error{
        color: red;
    }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
</style>
</head>
<?php echo $sidebar; ?>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            </div>
            <div class="title_right">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">

                        <h2>Pending Amounts to Channel Partners</h2>
                        <ul class="nav navbar-right panel_toolbox">
                          
                           <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>

                        </ul>
                        <div class="clearfix"></div>
                        
                    </div>
                    <div class="x_content">
                        <div class="">

                           <div class="row">
                                    
                                    <div class="col-sm-offset-7 col-sm-3">
                                        <label class="pull-right">Search:</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control search" name="search" id="search" placeholder="">
                                    </div>
                                </div><br>
                            <table id="example" class="display table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="tablbg">
                                        <th style="width: 45px">Slno</th>
                                        <th>Name</th>
                                        <th>Wallet Amount</th>
                                        <th>Coupon Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style=" height:100px;overflow:scroll">
                                    
                                </tbody>
                                <tfoot id ="foot">
                                    <td colspan="10">
                                        <div class="pull-right" id="pagination"></div>
                                    </td>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>


<!--modal-->

<div id="transaction_pop" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h4 class="modal-title">Payment to <span id="cp_name"></span></h4>
            </div>
<form method="post" action="<?php echo base_url();?>admin/home/new_transaction" id="transaction_form">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <label>Payment For</label>
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <input type="hidden" name="hidden_id" id="hidden_id" class="hidden_id">
                        <input name="payment_for[]" type="checkbox" class="payment_for"  value="wallet"  data-rule-required="true">&nbsp;Wallet                    
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12">
                        <input name="payment_for[]" type="checkbox" class="payment_for" value="coupon"  data-rule-required="true">&nbsp;Coupon
                    </div>
                    
                </div>
                <br>
                <div class="row amount" style="display:none;">
                    <div class="col-md-3 col-sm-12 col-xs-12">
                       
                    </div>
                    <div class="wallet">
                         <div class="col-md-1 col-sm-12 col-xs-12">
                          <label>Wallet</label>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                        <input class="form-control cp_id" name="cp_id" type="hidden" id="cp_id"/>
                        <input class="form-control pending_amount" name="pending_amount" type="hidden" id="pending_amount"/>
                        <input class="form-control pay_amount" name="pay_amount" type="text" placeholder="Pending Amount"  id="pay_amount"  data-rule-required="true"/>
                        </div>
                    </div>
                    <div class="coupon">
                        <div class="col-md-1 col-sm-12 col-xs-12">
                          <label>Coupon</label>
                        </div>
                        <div class="col-md-3 col-sm-12 col-xs-12">
                        <input class="form-control coupon_amount" name="coupon_amount" type="hidden" id="coupon_amount"/>
                        <input class="form-control pay_coupon" name="pay_coupon" type="text" placeholder="Pending Amount" id="pay_coupon"  data-rule-required="true"/>
                        </div>
                    </div>
                </div>
                <br>
                       
                <div class="row">
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <label>Payment mode</label>
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <input name="payment_mode" type="radio" class="payment_mode"  value="cash">&nbsp;Cash                    
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <input name="payment_mode" type="radio" class="payment_mode" value="cheque">&nbsp;Cheque
                    </div>
                    <div class="col-md-3 col-sm-12 col-xs-12">
                        <input name="payment_mode" type="radio" class="payment_mode" value="online">&nbsp;Online
                    </div>
                </div>
                <br>
                <div class="row details" style="display: none;" id="details">
                   <div class="col-md-3 col-sm-12 col-xs-12">
                        
                    </div>
                    <div class="col-md-1 col-sm-12 col-xs-12">
                        <label class="control-label">Cheque No</label>
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <input type="text" name="cheque_number" class="form-control">
                    </div>
                    <div class="col-md-1 col-sm-12 col-xs-12">
                        <label class="control-label">Bank</label>
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <input type="text" name="bank" class="form-control">
                    </div>
                    <div class="col-md-1 col-sm-12 col-xs-12">
                        <label class="control-label">Date</label>
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12">
                        <input type="text" name="cheque_date" class="form-control" id="cheque_date">
                    </div>  
                 </div>
                 <br>
                 
                    <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <label>Date of Transaction</label>
                        </div>
                        <div class="col-md-9 col-sm-12 col-xs-12">
                            <input class="form-control" name="transaction_date"  type="text" placeholder="Date of Transaction" data-rule-required="true" id="transaction_date" />
                        </div>
                    </div>
                    <br>
                     <div class="row">
                        <div class="col-md-3 col-sm-12 col-xs-12">
                            <label>Description</label>
                        </div>
                        <div class="col-md-9 col-sm-12 col-xs-12">
                            <input class="form-control" name="narration" type="text" placeholder="Description" />
                        </div>
                    </div>
                    <br>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary editsub" id="editsub">Submit</button>
                <button type="button" class="btn btn-default editsub"  data-dismiss="modal">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

<!--end of modal -->


<div id="notifications"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
         
        var base_url = "<?php echo base_url(); ?>";

        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            var from = $('.fromdate').val();
            var to = $('.todate').val();
            $.post(base_url + "transaction/" + index, { ajax: true,search:search,from:from,to:to}, function(data) {
                
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.data.length>0){
                  console.log(data);
                    var tr = '';
                    
                    var data1 = data.data;
                    console.log(data1);
                    for(var i = 0; i< data1.length; i++){
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                        
                            tr += '<tr>'+

                                '<td class="slno">'+sl_no+'</td>'+                                                   
                                '<td class="cp_name"><input type="hidden" value="'+data1[i].id+'" class="hiddentype_id">'+data1[i].name+'</td>'+
                                '<td class="total_amount">'+Math.abs(data1[i].amount)+'</td>'+
                                '<td class="coupon_total">'+Math.abs(data1[i].coupon)+'</td>'+
                                '<td><button type="button" id="transaction_button" class="btn btn-primary paid_trans">Pay </button></td>'+
                                
                                '</tr>';
                        
                    }
                    
                    $('#search').val(data.search);
                
                        $('#pagination').html(data.pagination);
                    

                }else{
                     tr += '<tr><td colspan="10">No data found</td></tr>';
                   
                }
               
                $('tbody').html(tr);
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
<script type="text/javascript">
                              
    $(document).ready(function () {
       
        var v = jQuery("#transaction_form").validate({
          
        submitHandler: function(datas) {
           
        $('.body_blur').show();
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {
                 
                 $('.body_blur').hide();

                if(data.status)
                {

                    //$('#channel_form').hide();
                   
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully completed transaction</div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        //$('#channel_form').hide();
                        location.reload();
                    }, 1000);
                }
                else
                {
                   // $('#channel_form').hide();
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    $('.close').click(function(){
                         $(this).parent().fadeOut(1000);
                     });
                    //$.toast(data.reason, {'width': 500});
                   // return false;
                }
            }
        });
        }
        });
    }); 
</script>
<script>
    $(document).ready(function () {
        $("#details").hide();
        $('input:radio[name="payment_mode"]').change(
            function(){
                if ($(this).val() == 'cheque') {
                   $("#details").show();
                }
                else{
                   $("#details").hide(); 
                }
        }); 
        $(".amount").hide();$(".wallet").hide();$(".coupon").hide();
        $('.payment_for').click(
            function(){
                $(".wallet").hide();$(".coupon").hide();
                $(".payment_for").each(function(i,j) { 
                  if($(this).is(":checked"))
                  {   
                    // alert($(this).val());
                        $(".amount").show();
                        if ($(this).val() == 'wallet') {
                           $(".amount").find(".wallet").show();
                        }
                        if ($(this).val() == 'coupon'){
                           $(".amount").find(".coupon").show(); 
                        }
                   }     
                });
               
        });
       
    });    
    $(document).ready(function(){
        $(document).on('click','#transaction_button',function(){
            var cur=$(this);
            var hiddentype_id=cur.parent().parent().find('.hiddentype_id').val();
            var amount=cur.parent().parent().find('.total_amount').text();
            var coupon=cur.parent().parent().find('.coupon_total').text();
            var cp_name=cur.parent().parent().find('.cp_name').text(); 
            $(document).find('#pay_amount').val(amount);
            $(document).find('#pending_amount').val(amount);
            $(document).find('#cp_name').text(cp_name);
            $(document).find('#cp_id').val(hiddentype_id);
            $(document).find('#coupon_amount').val(coupon);
            $(document).find('#pay_coupon').val(coupon);
            $(document).find('#hidden_id').val(hiddentype_id);
            $('#transaction_pop').modal('show'); 
        });
    });
</script>

<script type="text/javascript">
                              
    $(document).ready(function () {
       // alert("sd");
        var v = jQuery("#wal_amountsub").validate({

        submitHandler: function(datas) {
            //alert("sd");
        $('.body_blur').show();
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {
                 $('.body_blur').hide();
                if(data.status)
                {

                    //$('#channel_form').hide();
                   
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added channel partner </div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        //$('#channel_form').hide();
                        location.reload();
                    }, 1000);
                }
                else
                {
                   // $('#channel_form').hide();
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    $('.close').click(function(){
                         $(this).parent().fadeOut(1000);
                     });
                    //$.toast(data.reason, {'width': 500});
                   // return false;
                }
            }
        });
        }
        });
    }); 
</script>
 <script type="text/javascript">
    $(function () {
        $('#transaction_date').datetimepicker(
                {
                    format: 'DD-MM-YYYY h:mm a',
                    defaultDate:new Date()
                }
        );
        $('#cheque_date').datetimepicker(
                {
                    format: 'DD-MM-YYYY'
                }
        );
    });
     $(document).on('change','#pay_amount',function(){

        var pay_amt = $('#pay_amount').val();
        var pending_amount = $('#pending_amount').val();
        if(parseFloat(pay_amt)>parseFloat(pending_amount)){
            var regex = /(<([^>]+)>)/ig;
            var body = "Amount should not exceed "+pending_amount;
            var result = body.replace(regex, "");
            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
            var effect='fadeInRight';
            $('#pay_amount').val(pending_amount);
            $("#notifications").append(center);
            $("#notifications-full").addClass('animated ' + effect);
            $('.close').click(function(){
                 $(this).parent().fadeOut(1000);
             });
        }
    });
     $(document).on('change','#pay_coupon',function(){
 
        var pay_coupon = $('#pay_coupon').val();
        var coupon_amount = $('#coupon_amount').val();
        if(parseFloat(pay_coupon)>parseFloat(coupon_amount)){
            var regex = /(<([^>]+)>)/ig;
            var body = "Amount should not exceed "+coupon_amount;
            var result = body.replace(regex, "");
            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
            var effect='fadeInRight';
            $('#pay_coupon').val(coupon_amount);
            $("#notifications").append(center);
            $("#notifications-full").addClass('animated ' + effect);
            $('.close').click(function(){
                 $(this).parent().fadeOut(1000);
             });
        }
    });
</script>