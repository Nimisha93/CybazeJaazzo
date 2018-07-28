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
                        <h2>Club Agent-Transaction<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                           <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
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
                                        <th style="width: 30px">SI No.</th>
                                        <th>Name</th>
                                        <th>Amount</th>
                                        <th style="width: 190px">Action</th>
                                    </tr>
                                </thead>
                                <tbody style=" height:100px;overflow:scroll">
                                    
                                </tbody>
                                <tfoot>
                                    <td colspan="4">
                                        <div class="pull-right" id="pagination"></div>
                                    </td>
                                </tfoot>
                            </table>

                            <div id="transaction_pop" class="modal fade" role="dialog">
                                <div class="modal-dialog">
                                    <!-- Modal content-->
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal">X</button>
                                            <h4 class="modal-title">Transaction</h4>
                                        </div>
                                        <form method="post" id="wal_amountsub" class="wal_amountsub" name="wal_amountsub" action="<?php echo base_url();?>admin/home/add_ca_transaction">
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <label>Amount</label>
                                                    <input type="hidden" placeholder="Last Name" class="form-control" id="wallet_hiddenid" name="wallet_hiddenid">
                                                    <input type="hidden" placeholder="Last Name" class="form-control" id="cp_hiddenid" name="cp_hiddenid">
                                                    <input type="text" placeholder="Amount" class="form-control" id="pay_amt" name="pay_amt"  data-rule-required="true">
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                    <label>Date</label></br>
                                                    <input type="text" placeholder="Transaction Date" class="form-control transaction_date" id="transaction_date" name="transaction_date"  data-rule-required="true">
                                                </div>
                                                <div class="col-md-12">
                                                    <label>Payment Mode</label></br> 
                                                    <div class="col-md-2"> 
                                                        <input type="radio" name="payment_mode" class="" id ="pending_amount"  value="cash">&nbsp;Cash
                                                    </div>    
                                                    <div class="col-md-2">     
                                                        <input type="radio" name="payment_mode" class="" id ="pending_amount"  value="cheque">&nbsp;Cheque
                                                    </div>    
                                                    <div class="col-md-2">     
                                                        <input type="radio" name="payment_mode" class="" id ="pending_amount"  value="online">&nbsp;Pay Online
                                                    </div>    
                                                    <span class="material-input"></span><span class="material-input"></span>
                                                </div>
                                                <br>
                                                <div class="col-md-12 details" style="display: none;">
                                                    <div class="col-md-4">
                                                        <label>Cheque No</label> 
                                                        <input type="text" class="form-control" id = "cheque_number"  value="" name="cheque_number">
                                                    </div>
                                                
                                                    <div class="col-md-4">
                                                       <label>Bank Name</label> 
                                                       <input type="text" class="form-control" id = "bank"  value="" name="bank">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Date</label> 
                                                        <input type="text" class="form-control datetimepicker cheque_date" id = "cheque_date"  value="" name="cheque_date"><span class="material-input"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                    <label>Description</label></br>
                                                    <textarea class="form-control" rows="3" name="narration" id="narration" placeholder="Narration"  data-rule-required="true"></textarea>
                                                </div>
                                                <input type="hidden" placeholder="Amount" class="form-control" id="total_amtvalue" name="total_amtvalue" >
                                            </div>
                                        </div>
                                            <div class="modal-footer">
                                                <input type="submit" class="btn btn-primary amountsub" name="amountsub" id="amountsub" value="Submit">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/admin/js/moment2.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/css/bootstrap-datetimepicker.min.css" />
<script type="text/javascript">
    $(function () {
        $('.cheque_date').datetimepicker(
            {
                format: 'DD-MM-YYYY'
            }
        );
        $('.transaction_date').datetimepicker(
            {
                format: 'DD-MM-YYYY h:m a'
            }
        );
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            $.post(base_url + "ca_transaction/" + index, { ajax: true,search:search}, function(data) {
                console.log(data);
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.status){

                    var tr = '';
                    var data1 = data.data;
                    for(var i = 0; i< data1.length; i++){
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                        
                        tr += '<tr>'+
                            '<td>'+sl_no+'</td>'+
                            '<td>'+data1[i].name+'<input type="hidden" value="'+data1[i].waletid+'" class="wallet_hiddenid">'+
                                    '<input type="hidden" value="'+data1[i].mem_id+'" class="cp_hiddenid"></td>'+
                            '<td class="total_amount">'+data1[i].total_value+'</td>'+
                            '<td><a href="'+base_url+"admin/Home/view_ca_transaction/"+data1[i].mem_id+'"><button type="button" class="btn btn-danger type_sub">View Details</button></a><button type="button" class="btn btn-primary paid_trans"  data-toggle="modal" data-target="#transaction_pop">Pay </button></td>'+
                            '</tr>';


                    }
                    $('tbody').html(tr);
                    $('#search').val(data.search);
                    // pagination
                    $('#pagination').html(data.pagination);

                }else{

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
        $('input:radio[name="payment_mode"]').change(
            function(){
                if ($(this).val() == 'cheque') {
                   $(".details").show();
                }
                else{
                   $(".details").hide(); 
                }
        });
        $(document).on('click','.paid_trans',function(){
            var cur=$(this);
            var wal_id=cur.parent().parent().find('.wallet_hiddenid').val();
            var amount=cur.parent().parent().find('.total_amount').text();
            var cpid=cur.parent().parent().find('.cp_hiddenid').val();
            $(document).find('#wallet_hiddenid').val(wal_id);
            $(document).find('#total_amtvalue').val(amount);
            $(document).find('#cp_hiddenid').val(cpid);

        });
    });
</script>
<script>
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
</script>
<script type="text/javascript">
                              
    $(document).ready(function () {
        var v = jQuery("#wal_amountsub").validate({
        submitHandler: function(datas) {
        $('.body_blur').show();
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {
                $('.body_blur').hide();
                if(data.status)
                {
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Updated Wallet </div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    /*setTimeout(function(){
                        location.reload();
                    }, 1000);*/
                }
                else
                {
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
                }
            }
        });
        }
        });
    }); 
</script>
