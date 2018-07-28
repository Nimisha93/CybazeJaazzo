<?php echo $header; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>
 <script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>

<?php echo $sidebar; ?>
</head>


<div class="right_col" role="main">
    <div class="">
    
            <div style="float: right;"><a href="<?php echo  base_url();?>hr/timesheet/leaves"> <input type="submit" class="btn btn-primary fllft" value="View Leaves"></a></div>

      
        <div class="clearfix"></div>
        <div class="row">

            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>  Edit Leave<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">

                            <!-- ========================== calendar which hide previous date===================================================-->

                          

                                        <form role="form" id="leave_form" method="post" name="leave_form" action="">
                                            <div class="box-body">

                                                <div class="row">
                                                    <div class="col-md-12">
                                                        

                                                        <div class="row">
                                                     

                                                        <div class="col-md-4"><div class="form-group">
                                                                <label for="place">Leave type:</label>
                                                                 <input type="hidden" id="requsted_id" name="requsted_id" value="<?= $leaves[0]['lr_id'];?>" class="form-control">
                                                                <select id="supplier_name" name="ltype" class="form-control">
                                                                    <option value="">Select</option>
                                                                    <?php foreach ($leaves_type as $key => $type)  { ?>
                                                                        <option <?= $type['lt_id'] == $leaves[0]['lt_id'] ? 'selected' : '';?> value="<?= $type['lt_id'];?>"><?= $type['leavename'];?></option>
                                                                    <?php }  ?>
                                                                </select>


                                                            </div></div>
                                                            <div class="col-md-4"> <div class="form-group">
                                                                    <label >From :</label><?php
                                                                    $from=$leaves[0]['levfrom'];
                                                                    $from=date('d-m-Y',strtotime($from));
                                                                    ?>
                                                                    <input type="text" id="picker1" value="<?= $from;?>" name="lfrom" class="form-control">

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
                                                            <div class="col-md-4"><div class="form-group">
                                                                    <label for="place">To:</label><?php
                                                                    $to=$leaves[0]['levto'];
                                                                    $to=date('d-m-Y',strtotime($to));
                                                                    ?>
                                                                    <input type="text" id="picker2" value="<?= $to;?>" name="lto" class="form-control">

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
                                                        <div class="col-md-12"><div class="form-group">
                                                                <label for="place">Reason :</label>
                                                                <!-- <input type="date" id="place" name="dob" class="form-control"> -->
                                                                <input type="text" id="" value="<?= $leaves[0]['reason'];?>" name="rson" class="form-control">


                                                            </div></div>
                                                        </div>

                                                        <div class="row">

                                                    

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

<script type="text/javascript">
    $(document).ready(function() {

        $('#gen_submit').click(function(e){
            e.preventDefault();
          //  var sta = $("#leave_form").validationEngine("validate");
//            if(sta == true)
//            {
                var cur = $(this);
                var requsted_id = $('#leave_form').find('#requsted_id').val();
                var data = $('#leave_form').serializeArray();
                $('.body_blur').show();
                $.post('<?= base_url();?>hr/Timesheet/edit_leaves_applyins/'+requsted_id, data, function(data){
                    $('.body_blur').hide();
                    if(data.status){
                         var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Updated</div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        location.reload();
                    }, 1000);
                    } else{
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
                },'json');

//            }
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

<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>

<script type="text/javascript">
    $(function() {
        $('.form-group').on('keydown', '#phone', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    });
  
</script>

</body>
</html>