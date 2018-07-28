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
                        <h2> Edit Resignation
                            
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i></a></li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        
                         <div style="float: right;">
                                <a href="<?php echo  base_url();?>hr/resignation/res_emp_list"> <input type="submit" class="btn btn-primary fllft" value="View Resignation"></a>

        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content" style="overflow: visible">
                        <div class="">

                            <!-- ========================== calendar which hide previous date===================================================-->

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <?php
                                foreach($res as $key=>$items)
                                {
                                ?>
                                <form role="form" id="res_form" method="post" name="res_form" action="<?php echo base_url();?>hr/Resignation/edit_resignation/<?php echo $items['id'];?>" >

                                    <!--form role="form" id=staff_form method="post" name=staff_form enctype="multipart/form-data" action="<?php //echo site_url('admin/Resignation/edit_resignation/'.$items['id'].'');?>"-->
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-3"> <div class="form-group">
                                                    <label>Resigning Employee</label><input type="hidden" name="hiddenid" id="hiddenid" value="<?php echo $items['id'];?>">
                                                    <!--  <input type="hidden" id="r_name" name="r_name" value="<?php //echo $value['employee_id'];?>" class="validate[required] form-control">-->
                                                    <select required name="r_name" class="form-control  select_box_sel select2"  id="r_name" data-rule-required="true">
                                                        <!--  <option value="<?php //echo $item['employee_id'];?>"><?php// echo $item['employee_id'].")";?></option>-->
                                                        <?php
                                                        foreach($d as $key=>$item)
                                                        {
                                                            ?>

                                                            <option <?php echo $items['employee_id']==$item['employee_code'] ? 'selected="selected"': "";?> value="<?php echo $item['employee_code'];?>"><?php echo $item['name']."(". $item['employee_code'].")";?></option>
                                                        <?php }?>
                                                    </select>
                                                </div></div>

                                         <!--   <div class="col-md-6"><div class="form-group">
                                                    <label for="place">Forward Application To</label>

                                                    <select name="f_name" class="form-control validate[required] select_box_sel select2"  id="f_name">
                                                        <?php /*foreach ($forward['reqemp'] as $key => $emp) { */?>



                                                            <option <?php /*echo $items['forward_applicant']==$emp['id'] ? 'selected="selected"': "";*/?> value="<?php /*echo $emp['id'];*/?>"><?php /*echo $emp['name']."(". $emp['employee_code'].")";*/?></option>
                                                        <?php /*}*/?>
                                                    </select>
                                                </div></div>-->

<!--                                            <div class="col-md-3"><div class="form-group">-->
<!--                                                    <label>Notice Date</label>-->
<!--                                                    <input type="text" id="n_date" name="n_date" class="form-control validate[required]" value="--><?php //echo $items['notice_date'];?><!--">-->
<!--                                                    <p class="phone_ex"></p>-->
<!--                                                </div></div>-->
                                            <?php
                                            $daten= $items['notice_date'];
                                            $date1=convert_ui_date($daten);

                                            ?>
                                    <div class="col-md-3">       <div class="form-group">
                                                <label for="place">Notice Date</label>
                                                   
                                                        <input type="text" id='datetimepicker1' name="n_date" class="form-control " value="<?= $date1;?>" data-rule-required="true" >
               
                                               
                                                 </div></div>
                                            <?php
                                            $resignation_date= $items['resignation_date'];
                                            $date12=convert_ui_date($resignation_date);

                                            ?>

                                            <div class="col-md-3">       <div class="form-group">
                                                <label for="place">Resignation Date</label>
                                               
                                                    <input type="text" id='datetimepicker2' data-rule-required="true" name="r_date" class="form-control " value="<?=$date12;?>">
                    </span>
                                               
                                            </div></div>


     <div class="col-md-3"><div class="form-group">
                                                    <label for="place">Status</label>
                                                    <select name="status" class="form-control select_box_sel select2"  id="status" data-rule-required="true">
                                                        <?php foreach ($status['emp_stat'] as $key => $rows) { ?>
                                                            <option  <?php echo $items['status']== $rows['id'] ? 'selected="selected"': "";?> value="<?php echo $rows['id'];?>"><?php echo $rows['status'];?></option>
                                                        <?php  } ?>

                                                    </select>
                                                </div></div>
                                        </div>
                                        <div class="row">


                                        </div>


                                        <div class="row">
                                            <div class="col-md-6"><div class="form-group">
                                                    <label>Reason</label>

                                                    <textarea name="reason" class="form-control" id="reason" ><?php echo $items['reason'];?></textarea>
                                                    <p class="phone_ex"></p>
                                                </div></div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Additional Information</label>
                                                    <textarea name="add_info" class="form-control" id="add_info" ><?php echo $items['additional_info'];?></textarea>

                                                </div></div>

                                        </div>

                                        <?php }?>



                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button id="res_edit" type="submit" name="res_edit" class="btn btn-primary  pull-right">Update Resignation</button>

                                        <!--input id="res_edit" type="submit" name="res_edit" value="submit" class="btn btn-primary  pull-right"-->
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
<script>
    jQuery(document).ready(function(){
        // binds form submission and fields to the validation engine
        // jQuery("#company_form").validationEngine();
        $('.select2').select2();
    });

</script>
<script type="text/javascript">
    $(document).ready(function () {


 /*       $('#res_form').submit(function (e) {
            e.preventDefault();
          
            var hidden_id = $('#hiddenid').val();
      
                var cur = $(this);
                var data = $('#res_form').serializeArray();
                $('.body_blur').show();
                $.post('<?php echo base_url();?>hr/Resignation/edit_resignation/' + hidden_id, data, function (data) {
                    $('.body_blur').hide();
                    if (data.status) {

                     
                      noty({text:'Successfully Updated', type: 'success', layout: 'top', timeout: 3000});
                        window.location= '<?php echo base_url();?>hr/resignation/res_emp_list/';

                    } else {
                        noty({text: data.reason, type: 'error', layout: 'top', timeout: 3000});
                    }
                }, 'json');

        });*/
        var v = jQuery("#res_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#res_form').hide();
                            $('.body_blur').hide();

                                


                             var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Resignation Updated Successfully</div></div>';
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