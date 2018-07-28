<?php echo $header; ?>
<style type="text/css">
    #edit_brand_name {text-transform: capitalize;}
</style>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<!-- <script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>
 -->
 <script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>

</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
          

        <div class="clearfix"></div>
        <div class="row">
        
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2> Copy Job Post <small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">

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


                                            <?php foreach ($requisitions as $key => $requisition) { ?>
                   <form role="form" id="job_form" method="post" name="job_form" action="<?= base_url();?>hr/Recruitment/add_new_post">
                                                    <div class="box-body">

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="col-md-12">
                                                                   
                                                                </div>
                                                                <div class="col-md-3"> <div class="form-group">
                                                                        <label >Job Title:</label>
                                                                        <input type="text" id="supplier_name" value="<?= $requisition['title'];?>" name="title" class="form-control" data-rule-required="true">

                                                                      

                                                                    </div></div>

                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label for="place">Job Type:</label>
                                                                        <!-- <input type="text" id="place" name="type" class="form-control validate[required]"> -->

                                                                        <select id="supplier_name" name="type" class="form-control" data-rule-required="true">
                                                                            <option value="<?= $requisition['type'];?>"><?= $requisition['type'];?></option>
                                                                            <option value="permenant">Permenant</option>
                                                                            <option value="temperory">Temperory</option>
                                                                            <option value="contract">Contract</option>
                                                                            <option value="">----</option>
                                                                        </select>

                                                                    </div></div>
                                                                    

                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label for="place">No: Posts:</label>
                                                                        <input type="number" id="place" name="posts" value="<?= $requisition['posts'];?>" class="form-control" data-rule-required="true">

                                                                        
                                                                    </div></div>
                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label for="place">Closing Date:</label>
                                                                        <!-- <input type="Date" id="place" name="closing" class="form-control"> -->
                                                                        <input type="text" id="datepicker1" value="<?php echo date("d-m-Y"); ?>" name="closing" class="form-control " data-rule-required="true">



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


                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label for="place">Branch:</label>
                                                                        <!-- <input type="text" id="place" name="place" class="form-control validate[required]"> -->

                                                                        <select id="supplier_name" name="branch" class="form-control " data-rule-required="true">

                                                                            <?php foreach ($branches as $branch){?>
                                                                                <option <?= $requisition['branch'] == $branch['id'] ? 'selected' : '';?> value="<?= $branch['id'];?>"><?= $branch['branch'];?></option>
                                                                            <?php } ?>
                                                                        </select>

                                                                    </div></div>
                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label for="place">Department:</label>
                                                                        <!-- <input type="number" id="posts" name="posts" class="form-control"> -->
                                                                        <select id="supplier_name" name="dep" class="form-control" data-rule-required="true">

                                                                            <?php foreach ($department as $dep){ ?>
                                                                                <option <?= $requisition['dep'] == $dep['id'] ? 'selected' : '';?> value="<?php echo $dep['id'];?>"><?php echo $dep['tittle'];?></option>
                                                                            <?php } ?>
                                                                        </select>

                                                                    </div></div>
                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label for="place">Candidate Age Range (Start):</label>
    <input type="text"  data-rule-required="true" id="place" name="age_st" value="<?= $requisition['age_st'];?>" class="form-control" >

                                            

                                                                    </div></div>
                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label for="place">Candidate Age Range (End):</label>
                                                                        <input type="text" data-rule-required="true" value="<?= $requisition['age_en'];?>" id="place" name="age_en" class="form-control" >

                                                              

                                                                    </div></div>
                                                                <div class="col-md-6"><div class="form-group">
                                                                        <label for="place">Candid Salary Range (Start):</label>
                                                                        <input type="text" id="place" value="<?= $requisition['salary_st'];?>" name="salary_st" class="form-control" data-rule-required="true">

                                                                    </div></div>
                                                                <div class="col-md-6"><div class="form-group">
                                                                        <label for="place">Candid Salary Range (End):</label>
                                                                        <input type="text" data-rule-required="true" id="place" value="<?= $requisition['salary_en'];?>" name="salary_en" class="form-control" >

                                                                        

                                                                    </div></div>

                                                                <!-- </div>
                                                                <div class="col-md-6"> -->

                                                                <div class="col-md-12">
                                                                    <!-- <label >Candidate Qualification</label> -->
                                                                </div>
                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label > Qualification:</label>
                                                                <select id="qual" name="qual" class="form-control select2" data-rule-required="true">
                                                                    <option value="">Select Qualification</option>
                                                                    <?php foreach ($quali as $qal){ ?>
                                                                    <option <?php echo $requisition['qual'] == $qal['id'] ? 'selected="selected"' : "";?> value="<?php echo $qal['id'];?>"><?php echo $qal['qualification'];?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                        

                                                                    </div></div>
                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label > Experience:</label>
                                                                        <textarea class="form-control" name="exp" rows="4"><?= $requisition['exp'];?></textarea>

                                                                    </div></div>
                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label > Description:</label>
                                                                        <textarea class="form-control" name="desp" rows="4" data-rule-required="true"><?= $requisition['desp'];?></textarea>

                                                                    </div></div>
                                                               
                                                            </div>
                                                        </div>



                                                        <!--  -->

                                                    </div><!-- /.box-body -->

                                                    <div class="box-footer">
                                                        <button id="gen_submit" type="submit" name="gen_submit" class="btn btn-primary  pull-right">New Job Post</button>
                                                    </div>  <!-- /.box-body -->
                                                </form>
                                            <?php   } ?>

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

<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.buttons.min.js" type="text/javascript"></script>



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





<style>
tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
		background-color:#e6e6e6;
    }
	tfoot {background-color:#f1f1f1}
	</style>
    

<link rel="stylesheet" href="<?php echo base_url();?>assets/validation/css/validationEngine.jquery.css" type="text/css"/>
<link rel="stylesheet" href="<?php echo base_url();?>assets/validation/css/template.css" type="text/css"/>

<script src="<?php echo base_url();?>assets/validation/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
</script>
<script src="<?php echo base_url();?>assets/validation/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8">
</script>
<link href="<?php echo base_url();?>assets/css/select2.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/js/select2.full.js" type="text/javascript" charset="utf-8">

</script>
<link href="<?php echo base_url();?>assets/jqui/jq_jquery-ui.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/jqui/jquery-ui.js" type="text/javascript" charset="utf-8"></script>

<script type="text/javascript">
    var v = jQuery("#job_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#job_form').hide();
                            $('.body_blur').hide();

                               var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Created</div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                                                        window.location= '<?php echo base_url();?>hr/Recruitment/posts';

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

       $('#job_form').submit(function(e){     
      e.preventDefault();

      if (v.form()) 
      {
        $('.body_blur').show();
        //$(this).ajaxSubmit(datas);  
      }          
    });
</script>
</body>
</html>