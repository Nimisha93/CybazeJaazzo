<?php echo $header; ?>
<style type="text/css">
    #edit_brand_name {text-transform: capitalize;}
</style>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>



</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
<div class="">
<div style="float: right;">

</div>


<div class="clearfix"></div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
    <h2>Edit Requisitions<small></small></h2>
    <ul class="nav navbar-right panel_toolbox">
        <li><a href="<?php echo  base_url();?>hr/Recruitment/requisitions"> <input type="submit" class="btn btn-primary fllft" value="View Requisitions"></a></li>
        <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
    </ul>
    <div class="clearfix"></div>
</div>
<div class="x_content">
    <div class="">

        <!-- ========================== calendar which hide previous date===================================================-->

        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <form role="form" id="update_form" method="post" name="update_form" action="<?= base_url();?>hr/Recruitment/update_requisition">
                <div class="box-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-12">

                            </div>
                           
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="place">Branch:</label>
                                     <input type="hidden" id="id" name="id" value="<?php echo $requisitions['rq_id']; ?>"class="form-control ">

                                    <select id="supplier_name" name="branch" class="form-control select2">
                                        <?php foreach ($branch as $branch){?>
                                        <option <?php echo $requisitions['branch'] == $branch['id'] ? 'selected="selected"' : "";?> value="<?= $branch['id'];?>"><?= $branch['branch'];?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="place">Department:</label>

                                    <select id="supplier_name1" name="dep" class="form-control select2">
                                        <option value="">Select Department</option>
                                        <?php foreach ($department as $dep){ ?>
                                        <option <?php echo $requisitions['dep'] == $dep['id'] ? 'selected="selected"' : "";?> value="<?php echo $dep['id'];?>"><?php echo $dep['tittle'];?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="place">Job Title:</label>
                                    <input type="text" id="place" name="title" value="<?php echo $requisitions['title']; ?>" class="form-control">

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="place">Job Type:</label>

                                    <select id="supplier_name" name="type" class="form-control">
                                        <option value="<?php echo $requisitions['type']; ?>"><?php echo $requisitions['type']; ?></option>
                                        <option value="">----</option>
                                        <option value="permenant">Permenant</option>
                                        <option value="temperory">Temperory</option>
                                        <option value="contract">Contract</option>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="place">Job Posts:</label>
                                    <input type="number" id="posts" value="<?php echo $requisitions['posts']; ?>"name="posts" class="form-control">

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="place">Job Location:</label>
                                    <input type="text" id="location" value="<?php echo $requisitions['location']; ?>" name="location" class="form-control">

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="place">Candidate Age Range (Start):</label>
                                    <input type="number" id="place" name="age_st" value="<?php echo $requisitions['age_st']; ?>"class="form-control">



                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="place">Candidate Age Range (End):</label>
                                    <input type="number" id="place" name="age_en" value="<?php echo $requisitions['age_en']; ?>"class="form-control">



                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="place">Candid Salary Range (Start):</label>
                                    <input type="number" id="place" name="salary_st" value="<?php echo $requisitions['salary_st']; ?>" class="form-control">


                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="place">Candid Salary Range (End):</label>
                                    <input type="number" id="place" name="salary_en" value="<?php echo $requisitions['salary_en']; ?>"class="form-control">



                                </div>
                            </div>

                            <!-- </div>
                            <div class="col-md-6"> -->

                            <div class="col-md-12">
                                <!-- <label >Candidate Qualification</label> -->
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label> Qualification:</label>
                                    <!--                                                        <textarea class="form-control" name="qual" rows="4"></textarea>-->
                                    <select id="qual" name="qual" class="form-control select2">
                                        <option value="">Select Qualification</option>
                                        <?php foreach ($quali as $dep){ ?>
                                        <option <?php echo $requisitions['qual'] == $dep['id'] ? 'selected="selected"' : "";?>value="<?php echo $dep['id'];?>"><?php echo $dep['qualification'];?></option>
                                        <?php } ?>
                                    </select>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label> Experience:</label>
                                    <textarea class="form-control" name="exp" rows="4"><?php echo $requisitions['exp']; ?></textarea>

                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label> Description:</label>
                                    <textarea class="form-control" name="desp" rows="4"><?php echo $requisitions['desp']; ?></textarea>

                                </div>
                            </div>


                        </div>
                    </div>


                    <!--  -->

                </div><!-- /.box-body -->

                <div class="box-footer">
                    <button id="gen_submit" type="submit" name="gen_submit"
                            class="btn btn-primary  pull-right">Submit
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
    jQuery(document).ready(function(){
        // binds form submission and fields to the validation engine
        // jQuery("#patient_form").validationEngine();
        // $('.select2').select2();

        $('#supplier_name').SumoSelect({search: true, placeholder: 'Select branch'});
            $('#supplier_name1').SumoSelect({search: true, placeholder: 'Select department'});

    });

</script>
<script type="text/javascript">
    $(document).ready(function () {

        // $('#gen_submit').click(function (e) {
        //     e.preventDefault();
        //     var sta = $("#update_form").validationEngine("validate");
        //     if (sta == true) {
        //         var cur = $(this);
        //         var data = $('#update_form').serializeArray();
        //         $('.body_blur').show();
        //         $.post('<?= base_url();?>hr/Recruitment/update_requisition', data, function (data) {
        //             $('.body_blur').hide();
        //             if (data.status) {
        //                  $.toast("Successfully updated",{'width' :500});
        //                 //noty({text: "Successfully Updated", type: 'success', layout: 'top', timeout: 3000});
        //                 $('#update_form')[0].reset();
        //                 setTimeout(function(){

        //                    window.location="<?php echo base_url();?>hr/Recruitment/requisitions";
        //                 },2000);
        //             } else {
        //                 $.toast(data.reason,{'width' :500});
        //                // noty({text: data.reason, type: 'error', layout: 'top', timeout: 3000});
        //             }
        //         }, 'json');

        //     }
        // });



           var v = jQuery("#update_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#update_form').hide();
                            $('.body_blur').hide();
                          

                           var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Updated Requisitions</div></div>';
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


                    $('#update_form').submit(function(e){     
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