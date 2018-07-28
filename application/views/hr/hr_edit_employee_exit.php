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

                        <h2> Edit Exits <small></small></h2>

                        <ul class="nav navbar-right panel_toolbox">

                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>

                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>

                        </ul>
                        <div style="float: right;"><a href="<?php echo  base_url();?>hr/employee_exit/get_exit"> <input type="submit" class="btn btn-primary fllft" value="View Exit"></a></div>

                        <div class="clearfix"></div>

                    </div>

                    <div class="x_content">

                        <div class="">



                            <!-- ========================== calendar which hide previous date===================================================-->



                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">



                                <form role="form" id="request_form" class="request_form" method="post" name="request_form" action="<?= base_url();?>hr/employee_exit/edit_get_exit/<?php echo $request['request']['employee'];?>">

                                    <div class="box-body">

                                        <div class="col-md-12">

                                            <div class="col-md-3"> <div class="form-group">

                                                    <label>Employee</label><input type="hidden" name="hiddenid" id="hiddenid" value="<?php echo $request['request']['id'];?>">

                                        <input type="hidden" id="req_by1" name="req_by1" class="form-control " value="<?php echo $request['request']['employee'];?>">


                                                    <select name="req_by" class="form-control select_box_sel select2"  id="req_by" disabled data-rule-required="true">

                                                        <?php foreach ($employees['reqemp'] as $key => $emp) { ?>

                                                            <option  value="<?php echo $request['request']['employee'];?>"><?php echo $request['request']['name']; ?>(<?php echo $request['request']['employee_code'];?>)</option>

                                                        <?php  } ?>



                                                    </select>

                                                </div></div>

<!--                                            <div class="col-md-3"><div class="form-group">-->

<!--                                                    <label for="place">Exit Date</label>-->

<!--                                                    <input type="date" id="title" name="date" class="form-control validate[required]" value="--><?php //echo $request['request']['exit_date'];?><!--">-->

<!--                                                    <p class="phone_ex"></p>-->

<!---->

<!--                                                </div></div>-->

                                            <?php

                                            $date=$request['request']['exit_date'];

                                            $exit_date=convert_ui_date($date);



                                            ?>





                                            <div class="col-md-3">     <div class="form-group">
                                                <label for="place">Exit Date</label>

                                                <div class='input-group date' id='datetimepicker'>
                                                    <input type="text" id="date"  name="date" value="<?=$exit_date;?>" class="form-control  datepicker" data-rule-required="true">              
                                                </div>


                                            </div></div>






                                            <div class="col-md-3"><div class="form-group">

                                                    <label for="place">Type Of Exit</label>

                                                    <select data-rule-required="true"  name="type" class="form-control select_box_sel select2"  id="req_by">

                                                        <?php foreach ($type['reqemp'] as $key => $emp) { ?>

                                                            <option <?php echo  $emp['id'] == $request['request']['type']? 'selected="selected"': "";?> value="<?php echo $emp['id'];?>"><?php echo $emp['type'];?></option>

                                                        <?php  } ?>



                                                    </select>

                                                </div></div>

                                            <div class="col-md-3"><div class="form-group">

                                                    <label for="phone">Conducted Exit Interview </label>



                                                    <select name="interview" class="form-control select_box_sel select2"  id="forward" data-rule-required="true">

                                                        <?php foreach ($exit['reqemp'] as $key => $emp) { ?>

                                                            <option  <?php echo  $emp['id'] == $request['request']['exit_interview']? 'selected="selected"': "";?> value="<?php echo $emp['id'];?>"><?php echo $emp['exit_interview'];?></option>

                                                        <?php  } ?>



                                                    </select>







                                                </div></div>

                                            <!--div class="col-md-3"><div class="form-group">

                                        <label for="place">Exit Reason</label>

                                        <input type="text" id="title" name="title" class="form-control validate[required]" value="<?php echo $request['request']['subject'];?>">

                                        <p class="phone_ex"></p>

                                    </div></div-->



                                            <div>

                                                <div class="">

                                                    <div class="col-md-12"><div class="form-group">

                                                            <label >Exit Reason</label>

                                                            <textarea class="form-control" name="descrip" id="descrip" data-rule-required="true"><?php echo $request['request']['exit_reason'];?></textarea>



                                                        </div></div>

                                                </div>





                                            </div><!-- /.box-body -->



                                            <div class="box-footer">

                                                <button id="request_submit" type="submit" name="request_submit" class="btn btn-primary  pull-right">Update Exit</button>

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

<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script>
    jQuery(document).ready(function(){
        // binds form submission and fields to the validation engine
       $('#forward').SumoSelect({search: true, placeholder: 'Select employee'});

    });

</script>



<script type="text/javascript">

    $(document).ready(function(){

/*        $('#request_form').submit(function(e){

            e.preventDefault();

          

            var hidden_id = $('#hiddenid').val();




                var cur = $(this);



                var data = $('#request_form').serializeArray();

                $('.body_blur').show();

                $.post('<?= base_url();?>hr/employee_exit/edit_get_exit/'+hidden_id, data, function(data){

                    $('.body_blur').hide();

                    if(data.status){



                       
                        noty({text:'Successfully Updated',type: 'success',layout: 'top', timeout: 3000});

                        window.location= '<?php echo base_url();?>hr/employee_exit/get_exit/';



                    } else{

                        noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});

                    }

                },'json');



           

        });*/

var v = jQuery("#request_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#request_form').hide();
                            $('.body_blur').hide();

                     

                             var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Updated</div></div>';
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

        $('#datetimepicker').datetimepicker({ format: 'DD-MM-YYYY' });





    });

</script>



</body>

</html>