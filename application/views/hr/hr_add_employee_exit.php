<?php echo $header; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>


</head>
<?php echo $sidebar; ?>


<div class="right_col" role="main">
    <div class="">
    
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2> Add Exits </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="overflow: visible">
                        <div class="">

                            <!-- ========================== calendar which hide previous date===================================================-->

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">

                                <form role="form" id="exit_form" class="exit_form" method="post"  action="<?= base_url();?>hr/employee_exit/add_new_exit">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3"> <div class="form-group">
                                                    <label>Employee</label>
                                                    <select name="forward" class="form-control  select_box_sel "  id="forward" data-rule-required="true">
                                                     <option value="">Please Select</option>
                                                        <?php foreach ($employees['reqemp'] as $key => $emp) { ?>
                                                            <option value="<?php echo $emp['id'];?>"><?php echo $emp['name'];?>(<?php echo $emp['employee_code'];?>)</option>
                                                        <?php  } ?>
                                                    </select>
                                                </div></div>

                                            <div class="col-md-3">     <div class="form-group">
                                                <label for="place">Exit Date</label>
                                                <div class='input-group date' >
                                            <input type="text" id='datetimepicker1' name="date" class="form-control  datepicker" data-rule-required="true" style="    width: 159%;
"> 
                                            
                                            </div></div>
                                            </div>
                                            <div class="col-md-3"> <div class="form-group">
                                                    <label>Type Of Exit</label>
                                                    <select name="type" class="form-control  select_box_sel "  id="forward1" data-rule-required="true">
                                                     <option value="">Please Select</option>
                                                        <?php foreach ($type['reqemp'] as $key => $emp) { ?>
                                                            <option value="<?php echo $emp['id'];?>"><?php echo $emp['type'];?></option>
                                                        <?php  } ?>

                                                    </select>
                                                </div></div>

                                            

                                            <div class="col-md-3"><div class="form-group">
                                                    <label for="phone">Conducted Exit Interview</label>
                                                    <select name="interview" class="form-control  select_box_sel "  id="forward2" data-rule-required="true">
                                                    <option value="">Please Select</option>
                                                        <?php foreach ($exit['reqemp'] as $key => $emp) { ?>
                                                            <option value="<?php echo $emp['id'];?>"><?php echo $emp['exit_interview'];?></option>
                                                        <?php  } ?>

                                                    </select>

                                                </div></div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-12"><div class="form-group">
                                                    <label > Exit Reason</label>
                                                    <textarea class="form-control" name="descrip" id="descrip" ></textarea>

                                                </div></div>
                                        </div>


                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button id="exit_submit" type="submit" name="exit_submit" class="btn btn-primary  pull-right">New Exit</button>
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

<!--************************rowend******************************************************************* -->

</div>
</div>
</div>
</div>
</div>
<div id="notifications" style="z-index: 99999"></div><input type="hidden" id="position" value="center">

<?php echo $footer; ?>

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

<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script>
$('#forward').SumoSelect({search: true, placeholder: 'Select employee'});


</script>

<script>
    jQuery(document).ready(function(){
        // binds form submission and fields to the validation engine
    //     jQuery("#exit_form").validationEngine();
    //     $('.select2').select2();
    // });

</script>
<script type="text/javascript">
    $(document).ready(function(){




/*        $('#exit_submit').click(function(e){
            e.preventDefault();
            var sta = $("#exit_form").validationEngine("validate");
            if(sta == true)
            {
                var cur = $(this);
                var data = $('#exit_form').serializeArray();
                $('.body_blur').show();
                $.post('<?= base_url();?>hr/employee_exit/add_new_exit', data, function(data){
                    $('.body_blur').hide();
                    if(data.status){

                        $.toast('Successfully created',{'width' : 500});
                        setTimeout(function(){

                           location.reload();
                        }, 1000);
                        
                    } else{
                        $.toast(data.reason,{'width' : 500});
                    }
                },'json');

            }
        });


    });
*/
var v = jQuery("#exit_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {


                            $('#exit_form').hide();
                            $('.body_blur').hide();

                          


                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Exit Added Succesfully</div></div>';
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
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="Stylesheet" type="text/css" />



<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({ format: 'DD-MM-YYYY' });


    });
</script>
</body>
</html>