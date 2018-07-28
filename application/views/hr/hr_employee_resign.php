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

                        <h2>Add Resignation <small></small></h2>

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



                                <form role="form" id="res_form" class="res_form" method="post" name="res_form"  action="<?php echo base_url();?>hr/Resignation/add_new_resignation">



                                    <div class="box-body">



                                        <div class="row">

                                            <div class="col-md-4 slctdt"> <div class="form-group">

                                                    <label>Resigning Employee</label>

                                                    <!--<input type="text" id="r_name" name="r_name" class=" form-control">-->

                                                    <select name="res_emp" class="form-control select_box_sel select2"  id="res_emp" data-rule-required="true">

                                                    <option value="">Please Select</option>



                                                        <?php foreach ($employees['reqemp'] as $key => $emp) { ?>

                                                            <option value="<?php echo $emp['employee_code'];?>"><?php echo $emp['name'];?>(<?php echo $emp['employee_code'];?>)</option>

                                                        <?php  } ?>

                                                    </select>

                                                </div></div>



                                            <div class="col-md-4 ">

                                            <div class=" col-md-12 form-group">

                                                <label >Notice Date</label>



                                                

                                                    <input type="text" id="datetimepicker1" name="n_date" class="form-control er2"  data-rule-required="true" >

                  






                                            </div></div>

                                            <div class="col-md-4 ">

                                                <div class="form-group">

                                                    <label >Resigning Date</label>



                                                    

                                                        <input type="text"  id='datetimepicker2' name="r_date" class="form-control er2" data-rule-required="true">

                 

                                                   





                                                </div></div>





<!--                                            <div class="col-md-4">-->

<!--                                                <div class="form-group">-->

<!--                                                    <label>Resigning Date</label>-->

<!--                                                    <input type="text" id="r_date" name="r_date" class="form-control validate[required]" required>-->

<!--                                                </div></div>-->

                                        </div>



                                        <div class="row">







                                        </div>

                                        <div class="row">



                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label >Resignation Reason</label>

                                                    <textarea class="form-control" name="reason" id="reason" data-rule-required="true"></textarea>

                                                </div></div>

                                            <div class="col-md-6">

                                                <div class="form-group">

                                                    <label for="email">Additional Information</label>

                                                    <textarea class="form-control" name="add_info" id="add_info"></textarea>



                                                </div></div>



                                        </div>











                                    </div><!-- /.box-body -->



                                    <div class="box-footer">

                                        <button id="res_submit" type="submit" name="res_submit" value="submit" class="btn btn-primary  pull-right">New Resignation</button>

                                        <!--input id="company_submit" type="submit" value="submit" name="company_submit" class="btn btn-primary  pull-right"-->

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

<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<script>

    jQuery(document).ready(function(){

        // binds form submission and fields to the validation engine



        $('.select2').select2({

           

        });



    });



</script>



<script type="text/javascript">

    $(document).ready(function(){



/*        $('#res_submit').click(function(e){

            e.preventDefault();

            var sta = $("#res_form").validationEngine("validate");

            if(sta == true)

            {

                var cur = $(this);

                var data = $('#res_form').serializeArray();

                $('.body_blur').show();

                $.post('<?php echo base_url();?>hr/Resignation/add_new_resignation', data, function(data){

                    $('.body_blur').hide();

                    if(data.status){



                        $.toast("Resignation Added Successfully ",{'width' : 500});

                        setTimeout(function(){

                            location.reload();
                        }, 1000);

                    } else{
                        $.toast(data.reason,{'width' : 500});


                    }

                },'json');



            }

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


                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Resignation Added Successfully</div></div>';
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