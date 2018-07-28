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

                        <h2> Warnings <small></small></h2>

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



                                <form role="form" id="warning_form" class="warning_form" method="post" name="warning_form" action="<?= base_url();?>hr/employee_warning/add_new_warning">                                             

      

                                    <div class="box-body">

                                        <div class="row">

                                            <div class="col-md-3"> <div class="form-group">

                                                    <label>Warning To</label>

                                                    <select name="forward" class="form-control select_box_sel select2"  id="forward" data-rule-required="true">

                                                     <option value="">Please Select</option>

                                                        <?php foreach ($employees['reqemp'] as $key => $emp) { ?>

                                                            <option value="<?php echo $emp['id'];?>"><?php echo $emp['name'];?>(<?php echo $emp['employee_code'];?>)</option>

                                                        <?php  } ?>

                                                    </select>

                                                </div></div>

                                           

                                            <div class="col-md-3"> <div class="form-group">

                                                    <label>Warning By</label>

                                                    <select name="forwardd" class="form-control select_box_sel select2"  id="forwardd" data-rule-required="true">

                                                      <option value="">Please Select</option>

                                                        <?php foreach ($employees['reqemp'] as $key => $emp) { ?>

                                                            <option value="<?php echo $emp['id'];?>"><?php echo $emp['name'];?>(<?php echo $emp['employee_code'];?>)</option>

                                                        <?php  } ?>

                                                    </select>

                                                </div></div>

                                            <div class="col-md-3"><div class="form-group" >

                                                    <label for="phone">Subject</label>

                                                    <input type="text" id="title" name="title" class="form-control" data-rule-required="true">

                                                </div></div>



                                            <div class="col-md-3">      
                                            <div class="form-group">

                                                <label for="phone">Date</label>

                                                

                                               

                                                    <input type="text"  name="date" class="form-control datepicker" id='datetimepicker' data-rule-required="true"> 

                    
                    

                                                </div>


                                           </div>

                                            </div>





                                        <div class="row">

                                            <div class="col-md-12"><div class="form-group">

                                                    <label > Description</label>

                                                    <textarea class="form-control" name="descrip" id="descrip"></textarea>



                                                </div></div>

                                        </div>





                                    </div><!-- /.box-body -->



                                    <div class="box-footer">

                                        <button id="warning_submit" type="submit" name="warning_submit" class="btn btn-primary  pull-right">New Warnings</button>

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

    <link href="<?php echo base_url();?>assets/admin/css/select2.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/select2.full.js" type="text/javascript" charset="utf-8">
</script>

<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
  <!--***************************date picker end******************************-->

 


<script type="text/javascript">
 $('#forward').SumoSelect({search: true, placeholder: 'Select employee'});
  $('#forwardd').SumoSelect({search: true, placeholder: 'Select employee'});

        // $('#forward').select2();
        //         $('#forwardd').select2();


/*        $('#warning_submit').click(function(e){

            e.preventDefault();



                var cur = $(this);

                var data = $('#warning_form').serializeArray();

                $('.body_blur').show();

                $.post('<?= base_url();?>hr/employee_warning/add_new_warning', data, function(data){

                    $('.body_blur').hide();

                    if(data.status){



                        $.toast('Successfully created',{ 'width' :500});

                        $('#warning_form')[0].reset();

                    } else{

                        $.toast(data.reason,{ 'width' :500});

                    }

                },'json');



    });*/

    $(document).ready(function() {


        var v = jQuery("#warning_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#warehouse_modal').hide();
                            $('.body_blur').hide();
                            
                          


                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Created</div></div>';
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

    $(document).on('change', '#forwardd',function(){

        var cur = $(this);



        var type  = cur.val();

        

                    var group_id = $('#warning_form').find('#forward').val();



      

  

   if(type ==group_id ){

   var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Against and forward employee are same </div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    
                    setTimeout(function(){
 refresh_close();
                        //$('#channel_form').hide();
                        location.reload();
                    }, 2000);




   }

    });

</script>



<script type="text/javascript">

    $(function () {

        $('#datetimepicker').datetimepicker({ format: 'DD-MM-YYYY' });





    });

</script>



</body>

</html>