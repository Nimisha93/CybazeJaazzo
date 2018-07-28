<?= $header; ?>
<body>
<div class="wrapper">

    <?= $sidebar; ?>

    <div class="content">
        <div class="container-fluid">

        <?php foreach ($deal_info as $key => $value) { ?>
            <div class="col-md-12">

                <div class="card">


                    <div class="card-content">

                        <div class="alert alert-rose alert-with-icon" data-notify="container">
                         
                            <span data-notify="message"><h3>You Have an Amazing Deal at</h3>
                            <div class="alert alert-success"><span>
                            <input type="hidden" name="hidden_id" value="<?= $value['id'] ?>">
                            <b> Rs.<?= $value['amount'] ?> Only </b> FOR <?= $value['duration'] ?> Hours</span>
                            </div>
                            
                            <?= $value['name'] ?></br>
                            <?= $value['description'] ?></br>
                            Please purchase and enhance your business.
                            </span>
                           
                            <button class="btn btn-default" data-toggle="confirmation" data-id="<?= $value['id'] ?>" data-amount="<?= $value['amount'] ?>">BUY NOW</button>
                           </div>

                         
                    </div>
                </div>
            </div>
        <?php } ?>
            
        </div>
        <div class="modal fade" id="payment" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-notice">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="material-icons">close</i></button>
                        <h5 class="modal-title" id="myModalLabel">Payment</h5>
                    </div>
                    <div class="modal-body">
                        <div class="instruction">
                            <div class="row">
                               <form method="post" action="<?php echo base_url();?>admin/Deal/add_new_deal_settings" id="transaction_form">                     
                            <div class="col-md-12 col-sm-9">


                            <div class="col-md-12">
                                <div class="form-group label-floating is-empty">
                                    <label>Deal Price</label> 
                                    <input type="hidden" name="hidden_id" id="hidden_id">
                                    <input type="text" class="form-control" id = "amount"  value="" name="amount"  data-rule-required="true" readonly="">
                                    
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
                                        
                                        <input type="text" class="form-control datetimepicker" id = "cheque_date"  value="" name="cheque_date"><span class="material-input"></span>
                                        <span class="material-input"></span></div>

                                </div>
                            </div>
                           
                           
                             <div class="col-md-12">
                               <input type="submit" class="btn btn-primary amountsub" name="amountsub" id="amountsub" value="Submit">
                             </div>
                                

                            </div>



                        </form>

                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
       <div id="notifications"></div><input type="hidden" id="position" value="center">

        <?= $footer; ?>
        <script src="<?php echo base_url(); ?>assets/admin/js/bootstrap-confirmation.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {

            // bind form using ajaxForm
            $('[data-toggle=confirmation]').confirmation({

              rootSelector: '[data-toggle=confirmation]',
              onConfirm: function() {
                var cur =$(this);
                var id = cur.data('id');
                var amount = cur.data('amount');
                $('#hidden_id').val(id);
                $('#amount').val(amount);
               $('#payment').modal('show');
               
                
               },
              onCancel: function() {
               //alert('You didn\'t choose');
              },
              // other options
            });
            
        });
        </script>   
        <script type="text/javascript">
            $(document).ready(function () {
                $('#cheque_date').datetimepicker({format: 'DD-MM-YYYY'});
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
                   
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully purchased deal</div></div>';
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
            });     
        </script>
</body>

</html>