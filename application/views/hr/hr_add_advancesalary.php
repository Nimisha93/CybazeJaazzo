<?php echo $header; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<!-- <script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>
 --><link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">


 <script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>

</head>
<?php echo $sidebar; ?>

<div class="right_col" role="main">
    <div class="">
    
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Advance Salary<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">

                            <!-- ========================== calendar which hide previous date===================================================-->

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <form role="form" id="advance_form" class="advance_form" method="post" name="advance_form" action="<?= base_url();?>hr/Payroll/add_new_advancesalary" >
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3"> <div class="form-group">
                                                    <label>Employee Name</label>
                                                    <select name="emp_name" class="form-control  select_box_sel select2"  id="emp_name" data-rule-required="true">
                                                     <option value="">Please Select</option>
                                                        <?php foreach ($employees['reqemp'] as $key => $emp) { ?>
                                                            <option value="<?php echo $emp['id'];?>"><?php echo $emp['name'];?>(<?php echo $emp['employee_code'];?>)</option>
                                                        <?php  } ?>
                                                    </select>
                                                </div></div>

                                            <div class="col-md-3"><div class="form-group">
                                                    <label for="phone">Date</label>
                                                    <input type="text" id="advance_date" name="advance_date" class="form-control  datepicker" data-rule-required="true">
                                                </div></div>
 <script type="text/javascript">
            $(function () {
                $('#advance_date').datetimepicker(
                {

                	 format: 'DD-MM-YYYY'

                });
            });
 </script>
                                            <div class="col-md-3"><div class="form-group">
                                                    <label for="phone">Amount</label>
                                                    <input type="text" id="advance_amount" name="advance_amount" class="form-control advance_amount" data-rule-required="true">
                                                </div></div>
                                        </div>
                                       

                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button id="advance_submit" type="submit" name="advance_submit" class="btn btn-primary  pull-right">Save</button>
                                    </div>  <!-- /.box-body -->

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
       $(document).ready(function(){

     

        // $('#advance_submit').click(function(e){
        //     e.preventDefault();
        //     var sta = $("#advance_form").validationEngine("validate");
        //     if(sta == true)
        //     {
        //         var cur = $(this);
        //         var data = $('#advance_form').serializeArray();
        //         $('.body_blur').show();
        //         $.post('<?= base_url();?>hr/Payroll/add_new_advancesalary', data, function(data){
        //             $('.body_blur').hide();
        //             if(data.status){
        //                 $.toast("Successfully created", {'width': 500});
        //                  setTimeout(function(){
        //                         window.location.href = '<?php echo base_url();?>hr/Payroll/advance_payment/' ;
        //                     }, 1000);
        //             } else{
        //                 $.toast(data.reason, {'width': 500});
                       
        //             }
        //         },'json');

        //     }
        // });
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
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Added Advance Salary </div></div>';
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
        $(document).on('change','#emp_name', function(){
        var cur = $(this);
        var id = cur.val();
        
        $.post('<?php echo base_url(); ?>hr/Payroll/get_adv_lastdate_by_id',{id : id}, function(data){
         
          if(data.status == true)
          { 
             var dataz = data.data;
             console.log(dataz);
          
             $("#advance_date").datetimepicker('minDate', dataz.to_date);
          
          }else{
              $("#advance_date").datetimepicker('minDate', null);
             //noty({text: data.reason, type: 'error', timeout: 2000});
           //  setTimeout(function(){ location.reload() }, 1000);
          }

        },'json');
       });

    });

    </script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<!--***************************date picker******************************-->
   <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/moment2.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/bootstrap-datetimepicker.min.css" />

  <script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
  <!--***************************date picker end******************************-->

  <script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js"></script>

  <script>
$('#emp_name').SumoSelect({search: true, placeholder: 'Select employee'});


</script>

<script type="text/javascript">
    $(function() {
        $('.advance_form').on('keydown', '#advance_amount', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    });
</script>
 
<script type="text/javascript">

    $(document).on('keypress',".advance_amount",function (e) {
        //if  theletter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
 


</script>


</body>
</html>