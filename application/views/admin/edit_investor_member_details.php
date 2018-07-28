<?php echo $default_assets; ?>
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    span.help-inline-error{
        color: red;
    }
</style>
<script type="text/javascript">
  function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
  }
</script>
<link href="<?php echo base_url();?>assets/admin/sumo-select/sumoselect.css" rel="stylesheet" />
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
<div class="">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Update Team Lead Club<!-- Investor Club Member --> Details<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="">
                        <div class="">
                            <form method="post" name="cm_forms" id="cm_forms"  enctype="multipart/form-data" action="<?php echo base_url(); ?>update_investor_club_member">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <label>Name</label>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input class="form-control" name="name" type="text" placeholder="Name" value="<?= $details['name'];?>" />
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <label>Email Id</label>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input class="form-control validate[required,custom[email]]" name="email" type="email" placeholder="Email Id" data-errormessage-value-missing="Email is required!" 
                                        data-errormessage-custom-error="Let me give you a hint: someone@nowhere.com" 
                                        value="<?= $details['email'];?>" readonly/>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <label>Mobile No</label>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input class="form-control validate[required,custom[integer]]" name="mobile" onKeyPress="return isNumberKey(event)"   type="number" placeholder="Mobile No" data-errormessage-custom-error="Mobile no should be numeric value"  value="<?= $details['phone'];?>"/>
                                    </div>
                                </div>
                                <br>
                                <input type="hidden" name="log_id" value="<?php echo $details['log_id'];?>">
                                <input type="hidden" name="id" value="<?php echo $details['id'];?>">
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <label>Team Lead Club Plan</label>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                    <?php foreach ($club_plans as $key => $club) { ?>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <input type="radio" name="type" id="club_plan" value="<?php echo $club['id'];?>" <?php echo ($details['investor_type_id']==$club['id'])?'checked':'';?>><label style="padding-left: 10px;"><?php echo ucwords($club['title']);?></label>
                                    </div>
                                    <?php } ?>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <label>Payment mode</label>
                                    </div>

                                     <div class="col-md-8 col-xs-12">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                      <label>   <input name="payment_mode" type="radio" class="payment_mode" <?php echo ($details['mode_payment']=='cash')?'checked':'';?>  value="cash">&nbsp;Cash    </label>                 
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                      <label> <input name="payment_mode" type="radio" class="payment_mode" <?php echo ($details['mode_payment']=='cheque')?'checked':'';?> value="cheque">&nbsp;Cheque</label> 
                                    </div>
                                </div></div>
                                <br>
                                <div class="row details">
                                    <div class="col-md-2 col-sm-12 col-xs-12">
                                        <label class="control-label">Cheque No</label>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <input type="number" name="cheque" class="form-control" value="<?php echo $details['cheque_no'];?>">
                                    </div>
                                    <div class="col-md-2 col-sm-12 col-xs-12">
                                        <label class="control-label">Cheque Date</label>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <input type="text" name="cheque_date" class="form-control" value="<?php echo $details['cheque_date'];?>" id="cheque_date">
                                    </div>
                                </div>
                                <br>
                                <div class="row details">
                                    <div class="col-md-2 col-sm-12 col-xs-12"  style="margin-top: 15px">
                                        <label class="control-label">Bank</label>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12"  style="margin-top: 15px">
                                        <input type="text" name="bank" class="form-control" value="<?php echo $details['bank'];?>">
                                    </div>  
                                 </div>
                                 <br>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <button type="submit" class="pull-right btn btn-primary channelsubmit" name="channelsubmit" id="channelsubmit">Save Changes</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>
<div id="notifications"></div><input type="hidden" id="position" value="center">

<!--************************row  end******************************************************************* -->
</div>
<?php echo $footer; ?>
<!--***************************date picker******************************-->
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/moment2.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/bootstrap-datetimepicker.min.css" />
<script type="text/javascript">
    $(function () {
        $('#cheque_date').datetimepicker(
                {
                 format: 'YYYY-MM-DD'
                }
        );
    });
</script>
<script type="text/javascript">
    var base_url = "<?php echo base_url(); ?>";
    var mode_payment =  '<?php echo ($details['mode_payment']);?>';
    if(mode_payment=='cheque'){
        $('.details').show();
    }else{
        $('.details').hide();
    }
    $('input:radio[name="payment_mode"]').change(
        function(){
            if ($(this).val() == 'cheque') {
               $(".details").show();
            }
            else{
               $(".details").hide(); 
            }
    });
    $(document).ready(function(){
        //update
        var v = jQuery("#cm_forms").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                mobile: {
                    required: true,
                    minlength: 10
                }

            },
            messages: {
                name: {
                    required: "Please provide a name field",
                    minlength: "Name field must be at least 3 characters long"
                },
                mobile: {
                    required: "Please provide a mobile no",
                    minlength: "Mobile field must be at least 10 characters long"
                }
            },
            errorElement: "span",
            errorClass: "help-inline-error",
        });

        var datas = { 
            dataType : "json",
            success:   function(data){
              $('.body_blur').hide();
              if(data.status){
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully updated </div></div>';
                var effect='zoomIn';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
              } else{
                var regex = /(<([^>]+)>)/ig;
                var body = data.reason;
                var result = body.replace(regex, "");
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                var effect='fadeInRight';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
              }
          }
        };
        $('#cm_forms').submit(function(e){     
          e.preventDefault();
          if (v.form()) {
            $('.body_blur').show();
            $(this).ajaxSubmit(datas);  
          }          
        });
    });
</script>
</body>
</html>