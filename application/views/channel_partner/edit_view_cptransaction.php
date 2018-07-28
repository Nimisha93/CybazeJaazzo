<?= $header; ?>
<body>

<div class="wrapper">

    <?= $sidebar; ?>

    <div class="content">
        <div class="container-fluid">


            <div class="col-md-12">

                <div class="card">
                    <div class="card-header card-header-text" data-background-color="orange">
                        <h4 class="card-title">Transaction</h4>

                    </div>

                    <div class="card-content">

                        <form method="post" action="<?php echo base_url();?>admin/Cp_transaction/new_transaction" id="transaction_form">                     
                            <div class="col-md-12 col-sm-9">


                            <div class="col-md-12">
                                <div class="form-group label-floating is-empty">
                                    <label>Pending Amount</label> 
                                    <?php
                                     $pending_amount = ($cp_details < 0) ? '' : $cp_details ;
                                      ?>
                                    <input type="text" class="form-control" id = "pay_amount" value="<?php echo abs($pending_amount);?>" name="pay_amount"  data-rule-required="true" data-rule-min="1" onKeyPress="return isFloatKey(event)">
                                    <input type="hidden" class="form-control" id = "pending_amount"  value="<?php echo abs($pending_amount);?>" readonly name="pending_amount">
                                    <span class="material-input"></span><span class="material-input"></span></div>

                            </div>
                            <div class="col-md-12">
                                <div class="form-group label-floating is-empty">
                                    <label>Payment Mode</label></br> 
                                   <div class="col-md-2"> 
                                        <input type="radio" name="payment_mode" class="" value="cash">&nbsp;Cash
                                    </div>    
                                    <div class="col-md-2">     
                                        <input type="radio" name="payment_mode" class="" value="cheque">&nbsp;Cheque
                                    </div>    
                                    <div class="col-md-2">     
                                        <input type="radio" name="payment_mode" class="" value="online">&nbsp;Pay Online
                                    </div>    
                                    <span class="material-input"></span><span class="material-input"></span>
                            </div>

                            </div>
                            <div class="col-md-12" id="details">
                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label>Cheque Number</label> 
                                    
                             <input type="text" class="form-control" id = "cheque_number"  value="" name="cheque_number">
                                        <span class="material-input"></span><span class="material-input"></span></div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label>Bank Name</label> 
                                       
                                        <input type="text" class="form-control" id = "bank"  value="" name="bank">
                                        <span class="material-input"></span><span class="material-input"></span></div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label>Date</label> 
                                        
                                        <input type="text" class="form-control" id = "cheque_date"  value="" name="cheque_date"><span class="material-input"></span>
                                        <span class="material-input"></span></div>

                                </div>
                            </div>
                            <div class="col-md-12">

                                    <div class="form-group label-floating is-empty">
                                        <label class="label-control">Date of Transaction</label>
                                         <input type="text" name="transaction_date" class="form-control" id="datetimepicker" placeholder="Last Transaction Date" value=""  data-rule-required="true"/> 

                                    </div>

                                </div>
                            <div class="col-md-12">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">Description</label>
                                    <textarea type="text" class="form-control" name="narration"></textarea>
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>

                            </div>
                             <div class="col-md-12">
                               <input type="submit" class="btn btn-primary amountsub" name="amountsub" id="amountsub" value="Submit">
                             </div>
                                

                            </div>



                            <div class="col-md-12">
                                <a class="btn btn-fill btn-rose view_payment_info_to_admin">Transaction Details ( To admin )</a>
                                <a class="btn btn-fill btn-rose view_payment_info_from_admin">Transaction Details ( From admin )</a>
                                <?php if($cp_details<0) { 
                                    $amt = abs($cp_details);
                                    $amt1 = round($amt,2);?>
                                <a  class="btn btn-fill btn-rose"  id="request_payment">Request Payment of Rs. <?=
                                 $amt ?></a>
                                <?php } ?>
                            </div>


                        </form>
                    </div>
                </div>
            </div>




        </div>
   

        <!-- view details modal  To admin-->
        <div class="modal fade" id="payment_details_to_admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog modal-notice">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                        <h5 class="modal-title" id="myModalLabel">Last Transaction Details</h5>
                    </div>
                    <div class="modal-body">
                        <div class="instruction">
                            <div class="row">
                              <div class="card">
                                
                                <div class="card-content">
                                <!--    <h4 class="card-title">Commision</h4>-->
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                                </div>
                                <div class="material-datatables">
                                <table id="datatables" class="table datatables table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
                                       style="width:100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Amount</th>
                                    <th>Transaction Date</th>
                                    <th>Mode of Payment</th>
                                    
                                </tr>
                                </thead>

                                <tbody>
                                <?php foreach ($to_admin as $key => $value) { ?>
                                <tr>
                                    <td class="titleclass">
                                    <?= $key+1;?></td>
                                    <td class="mobile"><?php echo $value['transaction_amount'];?></td>
                                    <td class="email"><?= date('d-m-Y g:i a',strtotime($value['transaction_date']));?></td>
                                   <?php if($value['mode']=='cheque'){ ?>
                                         <td>Payment Via : Cheque</br>
                                         Name of the Bank : <?= $value['bank_name'];?></br>
                                         Cheque No : <?= $value['cheque_number'];?></br>
                                         Cheque Date : <?= date('d-m-Y g:i a',strtotime($value['cheque_date']));?></br></td>
                                         <?php }else{ ?>
                                         <td>Payment Via : <?= $value['mode'] ?></td>
                                    <?php } ?> 
                                </tr>
                                <?php } ?>
                                
                                </tbody>
                                </table>
                                </div>
                                </div>
                                <!-- end content-->
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
        

        <!-- view details modal From admin  -->
        <div class="modal fade" id="payment_details_from_admin" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" >
            <div class="modal-dialog modal-notice">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">clear</i></button>
                        <h5 class="modal-title" id="myModalLabel">Last Transaction Details</h5>
                    </div>
                    <div class="modal-body">
                        <div class="instruction">
                            <div class="row">
                              <div class="card">
                                
                                <div class="card-content">
                                <!--    <h4 class="card-title">Commision</h4>-->
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                                </div>
                                <div class="material-datatables">
                                <table id="datatables" class="table datatables table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
                                       style="width:100%">
                                <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Amount</th>
                                    <th>Transaction Date</th>
                                    <th>Mode of Payment</th>
                                    
                                </tr>
                                </thead>

                                <tbody>
                                <?php foreach ($from_admin as $key1 => $value) { ?>
                                <tr>
                                    <td class="titleclass">
                                    <?= $key1+1;?></td>
                                    <td class="mobile"><?php echo $value['transaction_amount'];?></td>
                                    <td class="email"><?= date('d-m-Y g:i a',strtotime($value['transaction_date']));?></td>
                                    <?php if($value['mode']=='cheque'){ ?>
                                         <td>Payment Via : Cheque</br>
                                         Name of the Bank : <?= $value['bank_name'];?></br>
                                         Cheque No : <?= $value['cheque_number'];?></br>
                                         Cheque Date : <?= date('d-m-Y g:i a',strtotime($value['cheque_date']));?></br></td>
                                         <?php }else{ ?>
                                         <td>Payment Via : <?= $value['mode'] ?></td>
                                    <?php } ?> 
                                    <!-- <td class="email"><?php echo $value['mode'];?></td> -->
                                </tr>
                                <?php } ?>
                                
                                </tbody>
                                </table>
                                </div>
                                </div>
                                <!-- end content-->
                                </div>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

<div id="notifications"></div><input type="hidden" id="position" value="center">        
<?= $footer; ?>


</body> 
<script type="text/javascript">

    $(document).on('click','.view_payment_info_from_admin',function(){          
       $("#payment_details_from_admin").modal('show'); 
    });
    $(document).on('click','.view_payment_info_to_admin',function(){          
       $("#payment_details_to_admin").modal('show'); 
    });
    $(document).on('change','#pay_amount',function(){            
       var amount = $(this).val();
       var pending_amount = $('#pending_amount').val();
       
       if(parseInt(amount)>parseInt(pending_amount)){
           var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Requested amount exceeds pending amount</div></div>';
                var effect='zoomIn';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                $('.close').click(function(){
                                    $(this).parent().fadeOut(1000);
                        });
                $('#pay_amount').val('');
                             
       }
    });
</script>
<script type="text/javascript">
                             
    $(document).ready(function () {
        var amt = $('#pay_amount').val();
        if(!amt){
            $('#pay_amount').prop('readonly',true); 
        }
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

        $(document).on('click','#request_payment',function(){
            var cur=$(this);
                $('body').alertBox({
                    title: 'Are You Sure?',
                    lTxt: 'Back',
                    lCallback: function(){
                      
                    },
                    rTxt: 'Okey',
                    rCallback: function(){
                        $('.body_blur').show();
                        $.post('<?php echo base_url();?>admin/Cp_transaction/transaction_request/', function(data){
                            $('.body_blur').hide();
                            if(data.status){
                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Requested for Pending Payment</div></div>';
                                var effect='zoomIn';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                refresh_close();
                            }else{
                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+data.reason+'</div></div>';
                                var effect='fadeInRight';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                //refresh_close();
                                $('.close').click(function(){
                                    $(this).parent().fadeOut(1000);
                                });
                            }
                        },'json');
                    }
                })
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }

        });


        var table = $('#datatables').DataTable();

        // Edit record
        table.on('click', '.edit', function() {
            $tr = $(this).closest('tr');

            var data = table.row($tr).data();
            alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        });

        // Delete a record
        table.on('click', '.remove', function(e) {
            $tr = $(this).closest('tr');
            table.row($tr).remove().draw();
            e.preventDefault();
        });

        //Like record
        table.on('click', '.like', function() {
            alert('You clicked on Like button');
        });

        $('.card .material-datatables label').addClass('form-group');
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#datetimepicker').datetimepicker(
                {format: 'DD-MM-YYYY h:mm a',
                 defaultDate:new Date()}
        );
        $('#cheque_date').datetimepicker(
                {format: 'DD-MM-YYYY'}
        );
    });
</script>

</html>