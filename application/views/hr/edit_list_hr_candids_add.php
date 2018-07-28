<?php echo $header; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
 <script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>

<?php echo $sidebar; ?>
</head>


<div class="right_col" role="main">
    <div class="">
    
            <div style="float: right;"></div>

      
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add New Candidate <small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a href="<?php echo  base_url();?>hr/Recruitment/candidates"> <input type="submit" class="btn btn-primary fllft" value="View Candidates"></a></li>
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">

                            <!-- ========================== calendar which hide previous date===================================================-->

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <form role="form" id="candidates_form" method="post" name="candidates_form" action="<?= base_url();?>hr/Recruitment/add_new_candid">
                                    <div class="box-body">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-12">

                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Job Field:</label>
                                                        <!-- <input type="text" id="supplier_name" name="title" class="form-control"> -->

                                                        <select id="title" name="title" class="form-control" data-rule-required="true">
                                                            <option value="">Select</option>
                                                            <?php foreach ($job as $key => $value) { ?>
                                                                <option value="<?= $value['po_id']; ?>"><?= $value['title']; ?></option>
                                                            <?php } ?>
                                                           
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="place">Name:</label>
                                                        <input type="text" id="name" name="name" class="form-control" data-rule-required="true">


                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="place">Date of Birth:</label>
                                                        <!-- <input type="date" id="place" name="dob" class="form-control"> -->
                                                
                                                               
                                                  <input type="text" id="datepicker1"  name="dob" class="form-control datepicker" data-rule-required="true">


                                                   

                                                    </div>
                                                </div>

                                                  <script type="text/javascript">
                                                                        $(function () {
                                                                            $('#datepicker1').datetimepicker(
                                                                            {



                                                              //  minDate: moment("12/10/2017"),
                                                                     format: 'DD-MM-YYYY'

                                                            }
                                                            );
                                                            });
                                                                    </script>
                                                <div class="col-md-3" style="clear: both;">
                                                    <div class="form-group">
                                                        <label for="place">Gender:</label>
                                                        <!-- <input type="Date" id="place" name="closing" class="form-control"> -->

                                                        <select id="supplier_name" name="gender" class="form-control" data-rule-required="true">
                                                            <option value="">Select</option>
                                                            <option value="male">Male</option>
                                                            <option value="female">Female</option>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="place">Email:</label>
                                                        <input type="email" id="place" name="email" class="form-control"  one" name="phone" class="form-control phone" data-rule-email="true">
                                                        <!-- <select id="supplier_name" name="company" class="form-control">
                     <option value="">Select</option>
                     <option value="qrs">QRS</option>
                     <option value="tata">TATA</option>
                     <option value="tcs">TCS</option>
                 </select> -->

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="place">Phone:</label>
                                                        <input type="text" id="phone" name="phone" class="form-control phone" data-rule-required="true">

                                                        
                                                    </div>
                                                </div>
                                              
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="place">PIN:</label>
                                                        <input type="text" id="pin" name="pin" class="form-control phone" data-rule-required="true">

                                                    </div>
                                                </div>

                                                <div class="col-md-4 slctdt">
                                                    <div class="form-group">
                                                        <label for="place">Qualification:</label>
                                                        <!-- <input type="text" id="place" name="qual" class="form-control"> -->
                                                        <!--                                                        <textarea class="form-control" name="qual" rows="4"></textarea>-->

                                                        <select id="qual" name="qual" class="form-control select2" data-rule-required="true">
                                                            <option value="">Select Qualification</option>
                                                            <?php foreach ($quali as $dep){ ?>
                                                            <option value="<?php echo $dep['id'];?>"><?php echo $dep['qualification'];?></option>
                                                            <?php } ?>
                                                        </select>

                                                        

                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="place">Address:</label>
                                                        <!-- <input type="text" id="posts" name="address" class="form-control"> -->
                                                        <textarea class="form-control" name="address" rows="4"></textarea>
                                                      

                                                    </div>
                                                </div>


                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="place">Experience:</label>
                                                        <!-- <input type="text" id="place" name="exp" class="form-control"> -->
                                                        <textarea class="form-control" name="exp" rows="4" data-rule-required="true"></textarea>

                                                        

                                                    </div>
                                                </div>


                                                <!-- </div>
                                                <div class="col-md-6"> -->


                                            </div>
                                        </div>


                                        <!--  -->

                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button id="candid_submit" type="submit" name="candid_submit"
                                                class="btn btn-primary  pull-right">New Candidate
                                        </button>
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
<script>
    jQuery(document).ready(function(){
        // binds form submission and fields to the validation engine
        // jQuery("#candidates_form").validationEngine();
        // $('.select2').select2();
      

      $('#title').SumoSelect({search: true, placeholder: 'Select job'});
            $('#qual').SumoSelect({search: true, placeholder: 'Select qualification'});
    });

</script>
<script>
     $(document).ready(function () {

       
         var v = jQuery("#candidates_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#candidates_form').hide();
                            $('.body_blur').hide();
                         var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Added Candidates</div></div>';
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
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close" style="color: black;font-size=26px;"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    alert_close();
                        }
                    }
                });
            }
        });


         
                            $('#candidates_form').submit(function(e){     
      e.preventDefault();

      if (v.form()) 
      {
        $('.body_blur').show();
        //$(this).ajaxSubmit(datas);  
      }          
    });

    });
    </script>
<script type="text/javascript">

    $(document).on('keypress',".phone",function (e) {
        //if  theletter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
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
 <script src="<?php echo  base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>

<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>

<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>

<script type="text/javascript">
    $(function() {
        $('.form-group').on('keydown', '#phone', function(e){-1!==$.inArray(e.keyCode,[46,8,9,27,13,110,190])||/65|67|86|88/.test(e.keyCode)&&(!0===e.ctrlKey||!0===e.metaKey)||35<=e.keyCode&&40>=e.keyCode||(e.shiftKey||48>e.keyCode||57<e.keyCode)&&(96>e.keyCode||105<e.keyCode)&&e.preventDefault()});
    });
</script>


</body>
</html>