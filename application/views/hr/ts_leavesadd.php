<?php echo $header; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>

<?php echo $sidebar; ?>
</head>

<div class="right_col" role="main">
    <div class="">
      
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Leave Type
                            
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
                                <form role="form" id="leave_form" method="post" name="leave_form" action="<?= base_url();?>hr/Timesheet/leaves_add">
                                    <div class="box-body">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-12">

                                                </div>
                                                <div class="col-md-4"> <div class="form-group">
                                                        <label >Leave Title :</label>
                                                        <input type="text" id="supplier_name" name="title" class="form-control" data-rule-required="true">
                                                        <!-- <select id="supplier_name" name="ename" class="form-control">
                                        <option value="">Select</option>
                                        <?php foreach ($employees as $key => $emp) { ?>
                                        <option value="<?= $emp['ep_id'];?>"><?= $emp['name'];?></option> <?php } ?>
                                        </select>
                        -->

                                                    </div></div>

                                                
                                           


                                                <div class="col-md-6"><div class="form-group">
                                                        <label for="place">Description :</label>
                                                        <textarea class="form-control" name="desp" rows="4"></textarea>
                                                    </div></div>


                                            </div>
                                        </div>



                                        <!--  -->

                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button id="btn_submit" type="submit" name="gen_submit" class="btn btn-primary  pull-right">Submit</button>
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
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">

<script type="text/javascript">

    $(document).on('keypress',".money",function (e) {
        //if  theletter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
    $(document).ready(function() {

        /*$('#btn_submit').click(function(e){
            e.preventDefault();
            var sta = $("#leave_form").validationEngine("validate");
            if(sta == true)
            {
                var cur = $(this);
                var data = $('#leave_form').serializeArray();
                $('.body_blur').show();
                $.post('<?= base_url();?>hr/Timesheet/leaves_add', data, function(data){
                    $('.body_blur').hide();
                    if(data.status){
                        noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                        $('#leave_form')[0].reset();
                         setTimeout(function(){
                                window.location="<?php echo base_url()?>hr/Timesheet/leavetype";
                                },2000);

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
                            
                                      

                           var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Added Leave type</div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        location.reload();
                    }, 2000);
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

          
                       $('#leave_form').submit(function(e){     
      e.preventDefault();

      if (v.form()) 
      {
        $('.body_blur').show();
        //$(this).ajaxSubmit(datas);  
      }          
    });

    });
</script>
</body>
</html>