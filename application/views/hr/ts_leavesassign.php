<?php echo $header; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>
 <script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>

<?php echo $sidebar; ?>
</head>


<div class="right_col" role="main">
    <div class="">
     
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Leave Assign
                           
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i></a></li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">

                            <!-- ========================== calendar which hide previous date===================================================-->

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <form role="form" id="assign_form" method="post" name="assign_form" action="<?= base_url();?>hr/Timesheet/leave_assignins">
                                    <div class="box-body">
                                        <table id="example" class="table display table-bordered table-striped responsive-utilities">
                                            <thead>

                                              <tr class="tablbg">
                                                
                                                <th>Employee</th>
                                                <th class="HideColumn">Employee ID</th>
                                                
                                                <th>Email</th>
                                                <th>Status</th>
                                                <th>Action</th>

                                                <!-- <th class="HideColumn">n4</th> -->

                                            </tr>

                                            </thead>
                                            <tbody>

                                            <?php foreach ($employees as $key => $emp) { ?>
                                                <tr>
                                                    <input type="hidden" name="emp_id" class="emp_id" value="<?= $emp['id'];?>">
                                                    <td><?= $emp['name'];?></td>
                                                    <td><?= $emp['employee_code'];?></td>
                                                    <td><?= $emp['email'];?></td>
                                                    <td><?= $emp['status'];?></td>
                                                    <td><input type="checkbox" class="check_list" name="check_list[]" value="<?= $emp['id']; ?>" ></td>
                                                </tr>
                                            <?php   } ?>



                                            </tbody>
                                            <tfoot>

                                            </tfoot>
                                        </table>
                                        <br>


                                    </div>
                                    <!-- <form role="form" id="supplier_form" method="post" name="supplier_form" action="<?= base_url();?>hr/Timesheet/leave_assignins"> -->
                                    <div class="box-body">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <label >Leave Assign Information </label>
                                                </div>


                                            </div></div>

                                        <div class="col-md-3"><div class="form-group">
                                                <label for="place">Leave type:</label>
                                                <!-- <input type="text" id="place" name="leave" class="form-control"> -->

                                                <select id="supplier_name" name="leave" class="form-control" data-rule-required="true" >
                                                    <option value="">----</option>
                                                    <?php foreach ($leaves as $key => $lev) { ?>
                                                        <option value="<?= $lev['lt_id'];?>"><?= $lev['leavename'];?></option>
                                                    <?php   } ?>
                                                </select>

                                            </div></div>
                                        <div class="col-md-3"><div class="form-group">
                                                <label for="place">Total days:</label>
                                                <!-- <input type="date" id="place" name="dob" class="form-control"> -->
                                                <input type="number"  name="days" class="form-control" data-rule-required="true">



                                            </div></div>

                                        <div class="col-md-3"> <div class="form-group">
                                                <label >From date :</label>
                                                <input type="text" id="picker1" name="fdate" class="form-control" data-rule-required="true">

                                            </div></div>
                                            <script type="text/javascript">
                                                $(function () {
                                                 $('#picker1').datetimepicker(
                                                                            {



                                                              //  minDate: moment("12/10/2017"),
                                                            format: 'DD-MM-YYYY'

                                                            }
                                                            );
                                                            });
                                                                    </script>
                                        <div class="col-md-3"><div class="form-group">
                                                <label for="place">To Date :</label>
                                                <input type="text" id="picker2" name="tdate" class="form-control" data-rule-required="true" >


                                            </div></div>
                                            <script type="text/javascript">
                                                $(function () {
                                                 $('#picker2').datetimepicker(
                                                                            {



                                                              //  minDate: moment("12/10/2017"),
                                                            format: 'DD-MM-YYYY'

                                                            }
                                                            );
                                                            });
                                                                    </script>

                                    </div>
                                     <div class="col-md-8"><div class="form-group">
                                                    <label for="place">Reason :</label>

                                                    <input type="text" id="" name="rson" class="form-control" data-rule-required="true">


                                                </div>
                            </div>

                        </div><!-- /.box-body -->

                        <div class="box-footer">
                            <button id="gen_submit" type="submit" name="gen_submit" class="btn btn-primary  pull-right">Submit</button>
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
<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<!--***************************date picker******************************-->
   <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/moment2.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/bootstrap-datetimepicker.min.css" />
  <link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">

<script type="text/javascript">
    $(document).ready(function() {

           var v = jQuery("#assign_form").validate({
          
            submitHandler: function(datas) {
            var length=$('input[name="check_list[]"]:checked').length;
              if(length==0){
              // $.toast('Please Select Employee', {'width': 500});


                         var center = '<div id="notifications-full"><div id="notifications-full-close" class="close" style="color: black;font-size=26px;"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Please Select Employee</div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    alert_close();
                    setTimeout(function(){

                        // location.reload();
                    }, 1000);
            
              }
               jQuery(datas).ajaxSubmit({


                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#assign_form').hide();
                            $('.body_blur').hide();
                            
                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Assigned Leave</div></div>';
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
                              $('.body_blur').hide();
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


                   $('#assign_form').submit(function(e){     
      e.preventDefault();

      if (v.form()) 
      {
        $('.body_blur').show();
        //$(this).ajaxSubmit(datas);  
      }          
    });

    });

</script>



<script>

$(document).ready(function() {
    var table = $('#example').DataTable( {
        fixedHeader: {
            header: true,
            footer: true
			
        }
    } );
	
} );

</script>
<style>
tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
		background-color:#e6e6e6;
    }
	tfoot {background-color:#f1f1f1}
	</style>
    
    
<link rel="stylesheet" href="<?php echo base_url();?>assets/validation/css/validationEngine.jquery.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/validation/css/template.css" type="text/css"/>

<script src="<?php echo base_url();?>assets/validation/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
</script>
<script src="<?php echo base_url();?>assets/validation/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
</script>
<!-- <link href="<?php echo base_url();?>assets/icheck/skins/square/blue.css" rel="stylesheet">
  <script src="<?php echo base_url();?>assets/icheck/icheck.min.js" type="text/javascript" charset="utf-8">
  </script> -->
<link href="<?php echo base_url();?>assets/css/select2.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/js/select2.full.js" type="text/javascript" charset="utf-8">
</script>
<link href="<?php echo base_url();?>assets/jqui/jq_jquery-ui.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/jqui/jquery-ui.js" type="text/javascript" charset="utf-8"></script>
<script>
    jQuery(document).ready(function(){
        // binds form submission and fields to the validation engine
        // jQuery("#patient_form").validationEngine();
        $('.select2').select2();
    });

</script>

<script type="text/javascript">
    $(function() {
        $('.form-group').on('keydown', '#phone', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    });
    
</script>

</body>
</html>