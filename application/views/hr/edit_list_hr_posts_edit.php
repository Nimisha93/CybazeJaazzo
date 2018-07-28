<?php echo $header; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
 <script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>

</head>
<?php echo $sidebar; ?>

<div class="right_col" role="main">
    <div class="">
    <div style="float: right;"></div>

    
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2> Edit Job Posts <small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li>
                                <a href="<?php echo  base_url();?>posts"> <input type="submit" class="btn btn-primary fllft" value="View Posts"></a>
                            </li>
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


                                            <?php foreach ($posts as $key => $post) { ?>
                                                <form role="form" id="supplier_form" method="post" name="supplier_form"
                                                action="<?= base_url();?>hr/Recruitment/add_edit_post">
                                                    <div class="box-body">

                                                        <div class="row">
                                                            <div class="col-md-12">
                                                                <div class="col-md-12">

                                                                </div>
                                                                <div class="col-md-3"> <div class="form-group">
                                                                        <label >Job Title:</label>
                                                                        <input type="text" id="supplier_name" value="<?= $post['title'];?>" name="title" class="form-control" data-rule-required="true">
                                                                        <input type="hidden" id="supplier_name" hidden="" value="<?= $post['po_id'];?>" name="po_id" class="form-control">

                                                                      

                                                                    </div></div>

                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label for="place">Job Type:</label>
                                                                        <!-- <input type="text" id="place" name="type" class="form-control validate[required]"> -->

                                                                        <select id="supplier_name" name="type" class="form-control" data-rule-required="true">
                                                                            <option value="<?= $post['type'];?>"><?= $post['type'];?></option>
                                                                            <option value="permenant">Permenant</option>
                                                                            <option value="temperory">Temperory</option>
                                                                            <option value="contract">Contract</option>
                                                                            <option value="">----</option>
                                                                        </select>

                                                                    </div></div>
                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label for="place">No: Posts:</label>
                                                                        <input type="number" id="place" name="posts" value="<?= $post['posts'];?>" class="form-control" data-rule-required="true">

                                                                       
                  
                                                                    </div></div>
                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label for="place">Closing Date:</label>
                                                                        <!-- <input type="Date" id="place" name="closing" class="form-control"> -->
                                                                        <input type="text" id="datepicker1" value="<?= $post['closing'];?>" name="closing" class="form-control" data-rule-required="true">

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

                                                                        <select id="branch" name="branch" class="form-control" data-rule-required="true">

                                                                            <?php foreach ($branches as $branch){?>
                                                                                <option <?= $post['branch'] == $branch['id'] ? 'selected' : '';?> value="<?= $branch['id'];?>"><?= $branch['branch'];?></option>
                                                                            <?php } ?>
                                                                        </select>

                                                                    </div></div>
                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label for="place">Department:</label>
                                                                       
                                                                        <select id="dep" name="dep" class="form-control" data-rule-required="true">

                                                                            <?php foreach ($department as $dep){ ?>
                                                                                <option <?= $post['dep'] == $dep['id'] ? 'selected' : '';?> value="<?php echo $dep['id'];?>"><?php echo $dep['tittle'];?></option>
                                                                            <?php } ?>
                                                                        </select>

                                                                    </div></div>
                                                                <div class="col-md-3"><div class="form-group ">
                                                                        <label for="place">Candidate Age Range (Start):</label>
                                                                        <input type="text" id="place" name="age_st" value="<?= $post['age_st'];?>" class="form-control" data-rule-required="true">

                                                                     

                                                                    </div></div>
                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label for="place">Candidate Age Range (End):</label>
                                                                        <input type="text" value="<?= $post['age_en'];?>" id="place" name="age_en" class="form-control" data-rule-required="true">

                                                                        
                                                                    </div></div>


                                                                <div class="col-md-6" style="clear: both;"><div class="form-group">
                                                                        <label for="place">Candid Salary Range (Start):</label>
                                                                        <input type="text" id="place" value="<?= $post['salary_st'];?>" name="salary_st" class="form-control" data-rule-required="true">

                                                                       

                                                                    </div></div>
                                                                <div class="col-md-6"><div class="form-group">
                                                                        <label for="place">Candid Salary Range (End):</label>
                                                                        <input type="text" id="place" value="<?= $post['salary_en'];?>" name="salary_en" class="form-control" data-rule-required="true">
                                                                    </div></div>
                                                                       
                                                                <div class="col-md-12">
                                                                    <!-- <label >Candidate Qualification</label> -->
                                                                </div>
                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label > Qualification:</label>
<!--                                                                        <textarea class="form-control" name="qual" rows="4">--><?//= $post['qual'];?><!--</textarea>-->
                                                                    <select id="qual" name="qual" class="form-control select2 " data-rule-required="true">
                                                                        <option value="">Select Qualification</option>
                                                                        <?php foreach ($quali as $dep){ ?>
                                                                        <option <?php echo $post['qual'] == $dep['id'] ? 'selected="selected"' : "";?>value="<?php echo $dep['id'];?>"><?php echo $dep['qualification'];?></option>
                                                                        <?php } ?>
                                                                    </select>


                                                                    </div></div>
                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label > Experience:</label>
                                                                        <textarea class="form-control" data-rule-required="true" name="exp" rows="4"><?= $post['exp'];?></textarea>

                                                                    </div></div>
                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label > Description:</label>
                                                                        <textarea class="form-control" name="desp" rows="4" data-rule-required="true"><?= $post['desp'];?></textarea>

                                                                    </div></div>
                                                               

                                                            </div>
                                                        </div>



                                                        <!--  -->

                                                    </div><!-- /.box-body -->

                                                    <div class="box-footer">
                                                        <button id="gen_submit" type="submit" name="gen_submit" class="btn btn-primary  pull-right">Update Job Post</button>
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
    $(document).ready(function() {
         $('#branch').SumoSelect({search: true, placeholder: 'Select branch'});
            $('#dep').SumoSelect({search: true, placeholder: 'Select department'});
        // $('#gen_submit').click(function(e){
        //     e.preventDefault();
        //     var sta = $("#supplier_form").validationEngine("validate");
        //     if(sta == true)
        //     {
        //         var cur = $(this);
        //         var data = $('#supplier_form').serializeArray();
        //         $('.body_blur').show();
        //         $.post('<?= base_url();?>hr/Recruitment/add_edit_post', data, function(data){
        //             $('.body_blur').hide();
        //             if(data.status){

        //                 noty({text:"Successfully Updated",type: 'success',layout: 'top', timeout: 3000});
        //                 setTimeout(function(){
        //                 window.location="<?php echo base_url()?>hr/Recruitment/posts";
        //                 },2000);
        //             } else{
        //                 noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
        //             }
        //         },'json');

        //     }
        // });
        var v = jQuery("#supplier_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#supplier_form').hide();
                           $('.body_blur').hide();
                                   var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Updated Post</div></div>';
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

                            $('#supplier_form').submit(function(e){     
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