<?php echo $default_assets; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">

</head>
<?php echo $sidebar; ?>

<div class="right_col" role="main">
    <div class="">
        
        <div class="clearfix"></div>
        <div class="row">
        <div class="col-sm-offset-7 col-sm-3">
                        <label class="pull-right">Search:</label>
                        </div>
                        <div class="col-sm-2">
                            <input type="text" class="form-control search" name="search" id="search" placeholder="">
                        </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Transaction<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <table id="example" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                <th>No</th>
                                    <th>Name</th>
                                    <th>My Incentive Wallet</th>
                                    <th>Action</th>


                                </tr>
                                </thead>

                                <tbody style=" height:100px;overflow:scroll">
                                </tbody>
                                <tfoot>
                                    <td colspan="8">
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

    <!--************************row  end******************************************************************* -->




</div>
</div>
</div>
</div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">


  <div id="transaction_pop" class="modal fade" role="dialog">
                        <div class="modal-dialog">

                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">X</button>
                                    <h4 class="modal-title">Transaction</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="accordion" id="accordion" role="tablist" >
                                        <div class="panel">
                                          

                                        </div>
                                        <form method="post" id='wal_amountsub' name="wal_amountsub" action="<?php echo base_url();?>admin/home/new_exec_transaction">
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <label>Amount</label>
                                                <input type="hidden" class="form-control" id="wallet_hiddenid" name="wallet_hiddenid">
                                                <input type="hidden" class="form-control" id="cp_hiddenid" name="cp_hiddenid">

                                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                    
                                                <input type="text" placeholder="Amount" class="form-control" name="pay_amt"  data-rule-required="true"
                                                 id="pay_amt">
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                <label>Date</label></br>
                                                <input type="text" placeholder="Transaction Date" class="form-control" id="transaction_date" name="transaction_date"  data-rule-required="true">
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

                                                <div class="col-md-12" id="details">
                                                <div class="col-md-4">
                                                    <label>Cheque Number</label> 
                                                    <input type="text" class="form-control" id = "cheque_number"  value="" name="cheque_number" data-rule-required="true">
                                                </div>
                                            
                                                <div class="col-md-4">
                                                   <label>Bank Name</label> 
                                                   <input type="text" class="form-control" id = "bank"  value="" name="bank" data-rule-required="true">
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Date</label> 
                                                    <input type="text" class="form-control datetimepicker" id="cheque_date"  value="" name="cheque_date"><span class="material-input" data-rule-required="true"></span>
                                                </div>
                                                </div>
                                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                <label>Description</label></br>
                                                <textarea class="form-control" rows="3" name="narration" id="narration" placeholder="Narration"  data-rule-required="true"></textarea>
                                               
                                            </div>
                                            <input type="hidden" placeholder="Amount" class="form-control" id="total_amtvalue" name="total_amtvalue" >
                                            </div>
                                            </div>
                                            </div>
                                            <div class="modal-footer">
                                               
                                                <input type="submit" class="btn btn-primary amountsub" name="amountsub" id="amountsub" value="Submit">
                                            </div>
                                        </form>
                                    </div>
                            </div>
                    </div>

<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/alertBox.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/alertBox.css">
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();

            $.post(base_url + "transaction_executive/" + index, { ajax: true,search:search}, function(data) {
                //console.log(data);
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.status){

                    var tr = '';
                    var data1 = data.data;
                    var data2=data1.details;
                    for(var i = 0; i< data2.length; i++){
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                        tr += '<tr>'+
                            '<td>'+sl_no+'</td>'+
                            '<td><input type="hidden" value="'+data2[i].waletid+'" class="wallet_hiddenid"><input type="hidden" value="'+data2[i].exe_id+ ' "class="cp_hiddenid">'+data2[i].name+'</td>'+
                            '<td class="total_amount">'+data2[i].total_value+'</td>'+

                            '<td> <button type="button" class="btn btn-primary paid_trans"  data-toggle="modal" data-target="#transaction_pop">Pay </button><a   href="'+base_url+"admin/Home/get_exec_transaction/"+data2[i].exe_id+'"> <button type="button" class="btn btn-danger">View Details </button></td></a></td>'+
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
<script type="text/javascript">
    $(document).ready(function() {

        $('#cheque_date').datetimepicker(
                {format: 'DD-MM-YYYY'}
        );
               $('#transaction_date').datetimepicker(
                {format: 'DD-MM-YYYY h:mm'}
        );
    });
</script>
<script>
    $(document).ready(function(){
        $(document).on('click','.paid_trans',function(){
            var cur=$(this);
            var hiddentype_id=cur.parent().parent().find('.hiddentype_id').val();
            var wal_id=cur.parent().parent().find('.wallet_hiddenid').val();
            var amount=cur.parent().parent().find('.total_amount').text();
            var cpid=cur.parent().parent().find('.cp_hiddenid').val();
            $(document).find('#wallet_hiddenid').val(wal_id);
            $(document).find('#total_amtvalue').val(amount);
            $(document).find('#pay_amt').val(amount);
            $(document).find('#cp_hiddenid').val(cpid);

        });
    });
    $(document).on('change','#pay_amt',function(){
        var pay_amt = $('#pay_amt').val();
        var total_amtvalue = $('#total_amtvalue').val();
        if(parseFloat(pay_amt)>parseFloat(total_amtvalue)){
            var regex = /(<([^>]+)>)/ig;
            var body = "Amount should not exceed "+total_amtvalue;
            var result = body.replace(regex, "");
            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
            var effect='fadeInRight';
            $('#pay_amt').val(total_amtvalue);
            $("#notifications").append(center);
            $("#notifications-full").addClass('animated ' + effect);
            $('.close').click(function(){
                 $(this).parent().fadeOut(1000);
             });
        }
    });
</script>

<script type="text/javascript">
                              
    $(document).ready(function () {
       //alert("sd");
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
                   
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Updated Wallet </div></div>';
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
    }); 
/*$(document).ready(function() {
    var table = $('#example').DataTable( {
        fixedHeader: {
            header: true,
            footer: true,
			
        }
    } );
	
} );*/
</script>

</body>
</html>





























