<?php echo $header; ?>
<!-- <script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>
 --><link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>


</head>

<?php echo $sidebar; ?>
<script type="text/javascript">


    jQuery(document).ready(function(){

        // binds form submission and fields to the validation engine

       // jQuery("#warning_form").validationEngine();

        $('.select2').select2();

    });



</script>



<div class="right_col" role="main">

    <div class="">

       
        <div class="clearfix"></div>

        <div class="row">




            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">

                    <div class="x_title">

                        <h2> Edit Warnings <small></small></h2>

                        <ul class="nav navbar-right panel_toolbox">

                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>

                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>

                        </ul>
                        <div style="float: right;"><a href="<?php echo  base_url();?>hr/employee_warning/get_warning"> <input type="submit" class="btn btn-primary fllft" value="View Warnings"></a></div>

                        <div class="clearfix"></div>

                    </div>

                    <div class="x_content" style="overflow: visible">

                        <div class="">



                            <!-- ========================== calendar which hide previous date===================================================-->



                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">



                                <form role="form" id="warning_form" class="warning_form" method="post" name="warning_form" action="<?= base_url();?>hr/Employee_warning/edit_get_warning/<?php echo $request['request']['id'];?>">

                                    <div class="box-body">

                                        <div class="row">

                                            <div class="col-md-3"> <div class="form-group">

                                                <label>Warning To</label><input type="hidden" name="hiddenid" id="hiddenid" value="<?php echo $request['request']['id'];?>" >

                                                <select name="forward" class="form-control  select_box_sel "  id="forward" data-rule-required="true">

                                                    <?php foreach ($employees['reqemp'] as $key => $emp) { ?>

                                                    <option <?php echo  $emp['id'] == $request['request']['warning_to']? 'selected="selected"': "";?> value="<?php echo $emp['id'];?>"><?php echo $emp['name'];?>(<?php echo $emp['employee_code'];?>)(<?php echo $emp['status'];?>)</option>

                                                    <?php  } ?>



                                                </select>

                                            </div></div>

                                        
                                            <div class="col-md-3"><div class="form-group">

                                                <label for="place">Warning By</label>

                                                <select name="warning_by" class="form-control  select_box_sel "  id="forwardd" data-rule-required="true">

                                                    <?php foreach ($employees['reqemp'] as $key => $emp) { ?>

                                                    <option <?php echo  $emp['id'] == $request['request']['warning_by']? 'selected="selected"': "";?> value="<?php echo $emp['id'];?>"><?php echo $emp['name'];?>(<?php echo $emp['employee_code'];?>)</option>

                                                    <?php  } ?>



                                                </select>

                                            </div></div>

                                    
                                            <?php

                                            $dater= $request['request']['date'];

                                            $date1=date('d-m-Y',strtotime($dater));



                                            ?>



                                            <div class="col-md-3">     <div class="form-group">

                                                <label for="place">Date</label>

                                                <div class='input-group date' id='datetimepicker1'>
                                                <?php

                                                  $date1=date('d-m-Y',strtotime($date1));
                                                  //echo $date1;exit();
                                                ?>
                                                    <input type="text" id="daten" name="daten" class="form-control " style="    width: 159%;
" value="<?=$date1;?>" data-rule-required="true" >


                                                </div>

                                            </div></div>

                                            <script type="text/javascript">
                                                        $(function () {
                                                            $('#daten').datetimepicker(
                                                            {



                                              //  minDate: moment("12/10/2017"),
                                                     format: 'DD-MM-YYYY'

                                            }
                                            );
                                            });
                                                    </script>





                                            <div class="col-md-3"><div class="form-group">

                                                <label for="place">Subject</label>

                                                <input type="text" id="title" name="title" class="form-control " value="<?php echo $request['request']['subject'];?>" data-rule-required="true">

                                                <p class="phone_ex"></p>

                                            </div></div>



                                        </div>

                                        <div class="row">







                                            <div class="col-md-12"><div class="form-group">

                                                <label > Description</label>

                                                <textarea class="form-control" name="descrip" id="descrip"><?php echo $request['request']['description'];?></textarea>



                                            </div></div>

                                        </div>





                                    </div><!-- /.box-body -->



                                    <div class="box-footer">

                                        <button id="warning_submit" type="submit" name="warning_submit" class="btn btn-primary  pull-right">Update Warning</button>

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
$('#forward').SumoSelect({search: true, placeholder: 'Select employee'});
  $('#forwardd').SumoSelect({search: true, placeholder: 'Select employee'});
/*    $('#warning_submit').click(function(e){

        e.preventDefault();


        var hidden_id = $('#hiddenid').val();


            var cur = $(this);



            var data = $('#warning_form').serializeArray();

            $('.body_blur').show();

            $.post('<?= base_url();?>hr/Employee_warning/edit_get_warning/'+hidden_id, data, function(data){

                $('.body_blur').hide();

                if(data.status){
                      $.toast('Successfully Updated',{'width' : 500});

                       setTimeout(function(){
                        window.location= '<?php echo base_url();?>hr/employee_warning/get_warning';
                    },1000);

                } else{
                    $.toast(data.reason,{'width' : 500});

                }

            },'json');


    });*/

var v = jQuery("#warning_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#warning_submit').hide();
                            $('.body_blur').hide();

                                 var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Warning  updated successfully</div></div>';
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
<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>

<!--***************************date picker******************************-->

   <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/moment2.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/bootstrap-datetimepicker.min.css" />

  <!--***************************date picker end******************************-->
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
  <script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>
  <link href="<?php echo base_url();?>assets/admin/css/select2.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/select2.full.js" type="text/javascript" charset="utf-8">
</script>
<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>






</body>

</html>