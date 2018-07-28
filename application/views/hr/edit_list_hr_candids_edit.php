<?php echo $header; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
 <script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>

<?php echo $sidebar; ?>
</head>



<div class="right_col" role="main">
    <div class="">


    
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                                            <h2> Edit candidates <small></small></h2>
                         

                        <ul class="nav navbar-right panel_toolbox">
                        <a href="<?php echo  base_url();?>hr/Recruitment/candidates"> <input type="submit" class="btn btn-primary fllft" value="View Candidates"></a>
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">

                            <!-- ========================== calendar which hide previous date===================================================-->

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">

                                <div class="x_content">
                                    <div class="">

                                        <!-- ========================== calendar which hide previous date===================================================-->

                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">

                                            <form role="form" id="candidate_form" method="post" name="candidate_form" action="<?= base_url();?>hr/Recruitment/edit_new_candid/<?= $candid['cd_id'];?>">

                                                <div class="box-body">

                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="col-md-12">

                                                            </div>
                                                            <div class="col-md-4"> <div class="form-group">
                                                                    <label >Job Field:</label>
                                                                     <input type="hidden" id="cand_id" name="cand_id" value="<?= $candid['cd_id'];?>" class="form-control " >

                                                                    <select id="title" name="title" class="form-control" data-rule-required="true">
                                                                        <option value="">Please Select</option>
                                                                      <?php foreach ($job as $jobs){ ?>
                                                                          <option <?= $candid['po_id'] == $jobs['po_id'] ? 'selected' : '';?> value="<?= $jobs['po_id'];?>"><?= $jobs['title'];?></option>
                                                                        <?php } ?>

                                                                    </select>

                                                                </div></div>

                                                            <div class="col-md-4"><div class="form-group">
                                                                    <label for="place">Name:</label>
                                                                    <input type="text" id="place" name="name" value="<?= $candid['name'];?>" class="form-control " data-rule-required="true">



                                                                </div></div>
                                                            <div class="col-md-4"><div class="form-group">
                                                                    <label for="place">Date of birth:</label>
                                                                    <?php $dob=$candid['dob'];
                                                                          $dob=date('d-m-Y',strtotime($dob));
                                                                             ?>
                                                                    <input type="text" id="datepicker1" value="<?= $dob;?>" name="dob" class="form-control " data-rule-required="true">



                                                                </div></div>

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
                                                            <div class="col-md-3" style="clear: both;"><div class="form-group">
                                                                    <label for="place">Gender:</label>
                                                                    <!-- <input type="Date" id="place" name="closing" class="form-control"> -->

                                                                    <select id="supplier_name" name="gender" class="form-control " data-rule-required="true">
                                                                        <option <?= $candid['gender'] == 'male' ? 'selected' : '';?> value="male">Male</option>
                                                                        <option <?= $candid['gender'] == 'female' ? 'selected' : '';?> value="female">Female</option>
                                                                    </select>

                                                                </div></div>

                                                            <div class="col-md-3"><div class="form-group">
                                                                    <label for="place">Email:</label>
                                                                    <input type="text" id="place" value="<?= $candid['email'];?>" name="email" class="form-control " data-rule-required="true" data-rule-email="true">
                                                                   <input type="hidden" value="<?= $candid['email'];?>" name="email_old" class="form-control " data-rule-required="true" data-rule-email="true">

                                                                </div></div>
                                                            <div class="col-md-3"><div class="form-group">
                                                                    <label for="place">Phone:</label>
                                                                    <input type="text" id="place" value="<?= $candid['phone'];?>" name="phone" class="form-control phone" data-rule-required="true">
                                                                    <input type="hidden" value="<?= $candid['phone'];?>" name="phone_old" class="form-control phone" data-rule-required="true">
                                                                   
                                                                </div></div>
                                                         
                                                            <div class="col-md-3"><div class="form-group">
                                                                    <label for="place">PIN:</label>
                                                                    <input type="number" id="place" value="<?= $candid['pin'];?>" name="pin" class="form-control phone">

                                                                </div></div>

                                                            <div class="col-md-4"><div class="form-group">
                                                                <label for="place">Qualification:</label>
                                                                
                                                                <select id="qual" name="qual" class="form-control select2" data-rule-required="true">
                                                                    <option value="">Select Qualification</option>
                                                                    <?php foreach ($quali as $dep){ ?>
                                                                    <option <?php echo $candid['qual'] == $dep['id'] ? 'selected="selected"' : "";?>value="<?php echo $dep['id'];?>"><?php echo $dep['qualification'];?></option>
                                                                    <?php } ?>
                                                                </select>


                                                            </div></div>
                                                            <div class="col-md-4"><div class="form-group">
                                                                    <label for="place">Address:</label>
                                                                    <textarea class="form-control" name="address" rows="4" data-rule-required="true"><?= $candid['address'];?></textarea>
                                                                   

                                                                </div></div>


                                                            <div class="col-md-4"><div class="form-group">
                                                                    <label for="place">Experience:</label>
                                                                    <textarea class="form-control " name="exp" rows="4" data-rule-required="true"><?= $candid['exp'];?></textarea>


                                                                </div></div>


                                                      


                                                        </div>
                                                    </div>



                                                    <!--  -->

                                                </div><!-- /.box-body -->

                                                <div class="box-footer">
                                                    <button id="gen_submit" type="submit" name="gen_submit" class="btn btn-primary  pull-right">Update Candidate</button>
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
 <script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>

<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>

        <script type="text/javascript">

         $('#title').SumoSelect({search: true, placeholder: 'Select job'});
            $('#qual').SumoSelect({search: true, placeholder: 'Select qualification'});
            $(document).ready(function() {

               /* $('#gen_submit').click(function(e){
                    e.preventDefault();
                    var cand_id = $("#candidate_form").find('#cand_id').val();
                    var sta = $("#candidate_form").validationEngine("validate");
                    if(sta == true)
                    {
                        var cur = $(this);
                        var data = $('#candidate_form').serializeArray();
                        $('.body_blur').show();
                        $.post('<?= base_url();?>hr/Recruitment/edit_new_candid/'+cand_id, data, function(data){
                            $('.body_blur').hide();
                            if(data.status){

                                noty({text:"Successfully Updated",type: 'success',layout: 'top', timeout: 3000});
                                 setTimeout(function(){
                                window.location="<?php echo base_url()?>hr/Recruitment/candidates";
                                },2000);

                            } else{
                                noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                            }
                        },'json');

                    }
                });
*/
         var v = jQuery("#candidate_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#candidate_form').hide();
                            $('.body_blur').hide();
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Updated Candidates</div></div>';
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
</body>
</html>