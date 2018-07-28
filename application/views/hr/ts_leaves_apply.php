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
                        <h2>Leave Apply
                            
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a></li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">

                            <!-- ========================== calendar which hide previous date===================================================-->

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                    
                               


                            </div>

                            <form role="form" id="leave_form" method="post" name="leave_form" action="<?= base_url();?>hr/Timesheet/leaves_apply">
                                <div class="box-body">

                                    <div class="row">
                                        <div class="col-md-12">
                                          

                                            <div class="row">
                                        

                                                <div class="col-md-4"><div class="form-group">
                                                    <label for="place">Select employee:</label>

                                                    <select id="emp_name" name="emp_name" class="form-control select_box_sel select2 emp_name" data-rule-required="true">
                                                        <option value="">Please Select</option>
                                                        <?php foreach ($employees as $key => $employees)   { ?>
                                                        <option value="<?= $employees['id'];?>"><?= $employees['name'];?></option>
                                                        <?php  } ?>
                                                    </select>


                                                </div></div>

                                                <div class="col-md-4"><div class="form-group">
                                                        <label for="place">Leave Type:</label>

                                                        <select id="supplier_name" name="ltype" class="form-control" data-rule-required="true">
                                                            <option value="">Select</option>
                                                            <?php foreach ($leaves_type as $key => $leav)   { ?>
                                                                <option value="<?= $leav['lt_id'];?>"><?= $leav['leavename'];?></option>
                                                            <?php  } ?>
                                                        </select>


                                                    </div></div>

                                                <div class="col-md-4"> <div class="form-group">
                                                        <label >From :</label>
                                                        <input type="text" id="picker1" name="lfrom" class="form-control" data-rule-required="true">

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
                                                <div class="col-md-4" style="clear: both;"><div class="form-group">
                                                        <label for="place">To:</label>
                                                        <input type="text" id="picker2" name="lto" class="form-control" data-rule-required="true">

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

                                            <div class="col-md-8"><div class="form-group">
                                                    <label for="place">Reason :</label>

                                                    <input type="text" id="" name="rson" class="form-control" data-rule-required="true">


                                                </div></div>
                                            </div>

                                            <div class="row">


                                        <!--    <div class="col-md-4"><div class="form-group">
                                                    <label for="place">Description:</label>

                                                    <textarea class="form-control" name="ldesp" rows="4"></textarea>

                                                </div></div>-->
                                            </div>

                                        </div>
                                    </div>



                                    <!--  -->

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

<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script type="text/javascript">



        $('#emp_name').SumoSelect({search: true, placeholder: 'Select employee'});
    $(document).ready(function() {

/*        $('#gen_submit').click(function(e){
            e.preventDefault();
            var sta = $("#leave_form").validationEngine("validate");
            if(sta == true)
            {
                var cur = $(this);
                var data = $('#leave_form').serializeArray();
                $('.body_blur').show();
                $.post('<?= base_url();?>hr/Timesheet/leaves_apply', data, function(data){
                    $('.body_blur').hide();
                    if(data.status){
                        noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                        $('#leave_form')[0].reset();
                    } else{
                        noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                    }
                },'json');

            }
        });*/
          var v = jQuery("#leave_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#leave_form').hide();
                            $('.body_blur').hide();
                            
                                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Added Leave</div></div>';
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


    });
</script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.buttons.min.js" type="text/javascript"></script>


<script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>
<!--***************************date picker******************************-->
   <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/moment2.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/bootstrap-datetimepicker.min.css" />
  <!--***************************date picker end******************************-->
  <link href="<?php echo base_url();?>assets/admin/css/select2.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/select2.full.js" type="text/javascript" charset="utf-8">
</script>
 <script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>



<script type="text/javascript">
    $(function() {
        $('.form-group').on('keydown', '#phone', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    });
 
</script>


</body>
</html>