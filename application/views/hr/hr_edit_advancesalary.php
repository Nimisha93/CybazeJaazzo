<?php echo $header; ?>
<style type="text/css">
    #edit_brand_name {text-transform: capitalize;}
</style>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<!-- <script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>
 --> <script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>


</head>
<?php echo $sidebar; ?>

<div class="right_col" role="main">
    <div class="">


     
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Edit Advance Salary<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
        <a href="<?php echo  base_url();?>hr/Payroll/advance_payment"> <input type="submit" class="btn btn-primary fllft" value="View Advance salary"></a>
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">

    <!-- ========================== calendar which hide previous date===================================================-->

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <form role="form" id="advance_form" class="advance_form" method="post" name="advance_form" action="<?= 
                                      base_url();?>hr/Payroll/edit_new_advancesalary/<?php echo $advance['advance']['id'];?>" >
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3"> <div class="form-group">
                                                    <label>Employee Name</label>
                                                    <input type="hidden" name="advance_hidden" id="advance_hidden" value="<?php echo 
                                                      $advance['advance']['id'];?>">
                                                    <select name="emp_name" class="form-control select_box_sel "  id="emp_name">
                                                        <?php foreach ($employees['reqemp'] as $key => $emp) { ?>
                                                            <option <?php echo $advance['advance']['emp_id']==$emp['id'] ? 'selected="selected"' 
                                                             : "";?>value="<?php echo $emp['id'];?>"><?php echo $emp['name'];?>(<?php echo 
                                                             $emp['employee_code'];?>)</option>
                                                        <?php  } ?>
                                                    </select>
                                                </div></div>

           
                                            <div class="col-md-3"><div class="form-group">
                                                    <label for="phone">Date</label>
                                                    <?php $date=$advance['advance']['salary_date'];
                                                    $date=date('d-m-Y',strtotime($date));?>
                                                    <input type="text" id="advance_date" name="advance_date" class="form-control  datepicker" 
                                                    value="<?php echo $date;?>" data-rule-required="true">
                                                </div></div>
                                            <script type="text/javascript">
                                             $(function () {
                                             $('#advance_date').datetimepicker(
		                               {



                                              // minDate: moment("12/10/2017"),
	                                         format: 'DD-MM-YYYY'

                                                 }
                                                 );
                                                 });
                                            </script>
                                            <div class="col-md-3"><div class="form-group">
                                                    <label for="phone">Amount</label>
                                                    <input type="text" id="advance_amount" name="advance_amount" class="form-control " value="<?php echo $advance['advance']['amount'];?>" data-rule-required="true">
                                                </div></div>
                                        </div>
                                       

                                    </div>

                                    <div class="box-footer">
                                       
<input type="submit" class="btn btn-primary btn_save pull-right" value="Submit">
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
<div class="clearfix"></div>

<!--************************row  end******************************************************************* -->

</div>
</div>
</div>
</div>
</div>

<div id="notifications" style="z-index: 99999"></div><input type="hidden" id="position" value="center">

<?php echo $footer; ?>
<script type="text/javascript">


    $(document).ready(function()
    {
     var v = jQuery("#advance_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#advance_form').hide();
                           



                            $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Updated Advance Salary Succesfully </div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        //$('#channel_form').hide();
                        location.reload();
                    }, 2000);
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
                    refresh_close();
                        }
                    }
                });
            }
        });
});
</script>
<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet" />\
<script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
  <!--***************************date picker end******************************-->

  <script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>

  <script src="<?php echo base_url();?>assets/admin/js/jquery.form.js"></script>

     <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/moment2.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/bootstrap-datetimepicker.min.css" />

<!-- <script>
    jQuery(document).ready(function(){
        // binds form submission and fields to the validation engine
        jQuery("#terminations_form").validationEngine();
        $('.select2').select2();
    });

</script>


 -->

   <script>
$('#emp_name').SumoSelect({search: true, placeholder: 'Select employee'});


</script>
<script type="text/javascript">
    $(function() {
        $('.advance_form').on('keydown', '#advance_amount', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    });
</script>



<!-- <script>

    $(function() {

        $(".datepicker").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd'
        });

    });
</script> -->
</body>
</html>