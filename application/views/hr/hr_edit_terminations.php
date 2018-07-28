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
                        <h2> Edit Terminations <small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
<div style="float: right;"><a href="<?php echo  base_url();?>hr/employee_terminations/get_terminations"> <input type="submit" class="btn btn-primary fllft" value="View Terminations"></a></div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="overflow: visible">
                        <div class="">

                            <!-- ========================== calendar which hide previous date===================================================-->

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">

                                <div class="">
                                    <div class="row">

                                        <!-- ========================== calendar which hide previous date===================================================-->

                                        <div class="">

                                            <form role="form" id="terminations_form" class="terminations_form" method="post" name="terminations_form" action="<?= base_url();?>hr/employee_terminations/edit_get_terminations/<?= $terminations['terminations']['id'];?>">
                                                <div class="box-body">
                                                    <div class="col-md-12">
                                                        <div class="col-md-3"> <div class="form-group">
                                                                <label>Employee Terminated</label>
                                                                <input type="hidden" id="termination_hidden" name="termination_hidden" class="termination_hidden" value="<?= $terminations['terminations']['id'];?>">
                                                                <select data-rule-required="true" name="emp_terminatedd" class="form-control select_box_sel select2"  id="emp_terminatedd">
                                                                    <?php foreach ($employees['reqemp'] as $key => $emp) { ?>
                                                                        <option <?php echo $terminations['terminations']['emp_terminatedd']== $emp['id'] ? 'selected="selected"': "";?> value="<?php echo $emp['id'];?>"><?php echo $emp['name'];?>(<?php echo $emp['employee_code'];?>)</option>
                                                                    <?php  } ?>

                                                                </select>
                                                            </div></div>

                                                  
                                                        <div class="col-md-3"> <div class="form-group">
                                                                <label>Termination Type</label>

                                                                <select data-rule-required="true" name="termina_type" class="form-control select_box_sel select2"  id="termina_type">
                                                                    <?php foreach ($terminaType['reqemp'] as $key => $emp) { ?>
                                                                        <option <?php echo $terminations['terminations']['type']== $emp['type'] ? 'selected="selected"': "";?> value="<?php echo $emp['id'];?>"><?php echo $emp['type'];?></option>
                                                                    <?php  } ?>
                                                                </select>
                                                            </div></div>
                                                        
                                                        <?php
                                                        $date= $terminations['terminations']['termina_date'];
                                                        $date3=convert_ui_date($date);

                                                        ?>
                                                        <div class="col-md-3"> <div class="form-group">
                                                            <label>Termination Date</label>
                                                        
                                                            <input type='text' id='datetimepicker1'     data-rule-required="true" name="termina_date" value="<?=$date3;?>" class="form-control posts" />
                
                                                        </div></div>



<!---->
<!--                                                        <div class="col-md-3"> <div class="form-group">-->
<!--                                                                <label>Notice Date</label>-->
<!--                                                                <input type="text" class="form-control" name="notice_dat" id="notice_dat" value="--><?//= $terminations['terminations']['notice_dat'];?><!--">-->
<!--                                                            </div></div>-->
                                                        <?php
                                                        $datenot= $terminations['terminations']['notice_dat'];
                                                        $date2=convert_ui_date($datenot);

                                                        ?>
                                                        <div class="col-md-3"> <div class="form-group">
                                                            <label>Notice Date</label>
                                                       
                                                            <input type='text' data-rule-required="true" id='datetimepicker2' name="notice_dat" value="<?=$date2;?>" class="form-control posts"  />
                  
                                                        </div>


                                                    </div>

                                                    <div class="col-md12">
                                                    
                                                          <div class="col-md-3" style="clear: both;"><div class="form-group">
                                                <label for="place">Status</label>
                                                <select name="status" class="form-control validate[required] select_box_sel select2"  id="status">
                                                    <?php foreach ($status['emp_stat'] as $key => $rows) { ?>
                                                    <option  <?php echo $terminations['terminations']['emp_stat']== $rows['id'] ? 'selected="selected"': "";?> value="<?php echo $rows['id'];?>"><?php echo $rows['status'];?></option>
                                                    <?php  } ?>

                                                </select>
                                            </div></div>
                                                        <div class="col-md-9"><div class="form-group">
                                                                <label > Description</label>
                                                                <textarea class="form-control" name="descrip" id="descrip"><?= $terminations['terminations']['description'];?></textarea>

                                                            </div></div>
                                                    </div>


                                                </div><!-- /.box-body -->

                                                <div class="box-footer">
                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <button id="terminations_submit" type="submit" name="terminations_submit" class="btn btn-primary  pull-right">Update Termination</button>
                                                </div>  </div> <!-- /.box-body -->

                                            </form>


                                        </div>

                                    </div>



                                </div>

                            </div>
                        </div>
                        <div class="clearfix"></div>


                        <div class="clearfix"></div>


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

<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script>
        $('#emp_terminatedd').SumoSelect({search: true, placeholder: 'Select employee'});

    // jQuery(document).ready(function(){
    //     // binds form submission and fields to the validation engine
    //     jQuery("#terminations_form").validationEngine();
    //     $('.select2').select2();
    // });

</script>

<script type="text/javascript">
    $(document).ready(function(){



/*        $('#terminations_form').submit(function(e){
            e.preventDefault();
            var hidden_id = $('#termination_hidden').val();
          
                var cur = $(this);
                var data = $('#terminations_form').serializeArray();
                $('.body_blur').show();
                $.post('<?= base_url();?>hr/employee_terminations/edit_get_terminations/'+hidden_id, data, function(data){
                    $('.body_blur').hide();
                    if(data.status){

                       
                        noty({text:'Successfully Updated',type: 'success',layout: 'top', timeout: 3000});
                        window.location= '<?php echo base_url();?>hr/Employee_terminations/get_terminations/'+hidden_id;

                    } else{
                        noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                    }
                },'json');

        });*/
        var v = jQuery("#terminations_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#terminations_form').hide();
                            $('.body_blur').hide();



                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Updated Termination</div></div>';
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






<script type="text/javascript">
    $(function () {
        $('#datetimepicker1').datetimepicker({ format: 'DD-MM-YYYY' });


    });
</script>


<script type="text/javascript">
    $(function () {
        $('#datetimepicker2').datetimepicker({ format: 'DD-MM-YYYY' });


    });
</script>

</body>
</html>