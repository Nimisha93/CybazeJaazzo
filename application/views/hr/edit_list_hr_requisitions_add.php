<?php echo $header; ?>
<style type="text/css">
    #edit_brand_name {text-transform: capitalize;}
</style>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">


<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.9.0/ui-bootstrap-tpls.min.js"></script>

</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
     <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Requisitions<small></small></h2>
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
                                <form role="form" id="requisition_form" method="post" name="requisition_form"
                                      action="<?= base_url();?>hr/Recruitment/add_new_requisition">
                                    <div class="box-body">

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-12">

                                                </div>
                                             
                                                <div class="col-md-6 slctdt">
                                                    <div class="form-group">
                                                        <label for="place">Branch:</label>
                                                        <!-- <input type="text" id="place" name="place" class="form-control validate[required]"> -->

                                                        <select id="supplier_name" name="branch" class="form-control select2 " data-rule-required="true">
                                                               <option value="">Please Select</option>
                                                            <?php foreach ($branch as $branch){?>
                                                                <option value="<?= $branch['id'];?>"><?= $branch['branch'];?></option>
                                                            <?php } ?>
                                                        </select>

                                                    </div>
                                                </div>
                                                <div class="col-md-6 slctdt">
                                                    <div class="form-group">
                                                        <label for="place">Department:</label>

                                                        <select id="supplier_name1" name="dep" class="form-control select2 slctd" data-rule-required="true">
                                                            <option value="">Select Department</option>
                                                           <?php foreach ($department as $dep){ ?>
                                                               <option value="<?php echo $dep['id'];?>"><?php echo $dep['tittle'];?></option>
                                                            <?php } ?>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="place">Job Title:</label>
                                                        <input type="text" id="title" name="title" class="form-control" data-rule-required="true">

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="place">Job Type:</label>

                                                        <select id="type" name="type" class="form-control" data-rule-required="true">
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
                                                        <input type="number" id="posts" name="posts" class="form-control posts" data-rule-required="true">

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="place">Job Location:</label>
                                                        <input type="text" id="location" name="location" class="form-control" data-rule-required="true">

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="place">Candidate Age Range (Start):</label>
                                                        <input type="number" id="age_st" name="age_st" class="form-control age_st" data-rule-required="true">



                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="place">Candidate Age Range (End):</label>
                                                        <input type="number" id="age_en" name="age_en" class="form-control age_en" data-rule-required="true">



                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="place">Candid Salary Range (Start):</label> 
                                                        <input type="text" id="salary_st" name="salary_st" class="form-control salary_st" data-rule-required="true">


                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label for="place">Candid Salary Range (End):</label>
                                                        <input type="text" id="salary_en" name="salary_en" class="form-control salary_en" data-rule-required="true">



                                                    </div>
                                                </div>

                                                <!-- </div>
                                                <div class="col-md-6"> -->

                                                <div class="col-md-12  ">
                                                    <!-- <label >Candidate Qualification</label> -->
                                                </div>
                                                   <div class="col-md-2 slctdt" >
                                                    <div class="form-group ">
                                                        <label> Qualification:</label>
<!--                                                        <textarea class="form-control" name="qual" rows="4"></textarea>-->
                                                        <select id="qual" name="qual" class="form-control select2 qual" data-rule-required="true">
                                                            <option value="">Select Qualification</option>
                                                            <?php foreach ($quali as $dep){ ?>
                                                            <option value="<?php echo $dep['id'];?>"><?php echo $dep['qualification'];?></option>
                                                            <?php } ?>
                                                        </select>


                                                    </div>
                                                </div>

                                                <div class="col-md-1 col-sm-1 col-xs-3 sddbtnmrtp">
                                                    <a href="" class="dropdown-toggle info-number" data-toggle="modal" data-target="#add_unit_type">
                                                        <span class="addmdlbtn"> + </span>
                                                    </a>

                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label> Experience:</label>
                                                        <textarea class="form-control" name="exp" rows="4" data-rule-required="true"></textarea>

                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label> Description:</label>
                                                        <textarea class="form-control" name="desp" rows="4" data-rule-required="true"></textarea>

                                                    </div>
                                                </div>


                                            </div>
                                        </div>


                                        <!--  -->

                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button id="gen_submit" type="submit" name="gen_submit"
                                                class="btn btn-primary  pull-right">New Requisitions
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


<div class="modal fade" id="add_unit_type" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <button type="button" class="close" data-dismiss="modal">X</button>
                <h4 class="modal-title">Add new qualification</h4>
            </div>
            <div class="modal-body" style="height:auto;overflow:hidden">
                <form role="form" method="post" id="qualification_form"  >
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label>Qualification</label>
                        <input type="text" placeholder="" name="qualifc" id="qualifc" required class="form-control">
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <input type="submit" id="add_type"value="save" class="btn btn-primary antosubmit">
                    </div>
                </form>
            </div>
            <div class="modal-footer">&nbsp;
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
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">

<script>
    // jQuery(document).ready(function(){
    //     // binds form submission and fields to the validation engine
    //     jQuery("#patient_form").validationEngine();
    //     $('.select2').select2();
    // });

            $('#supplier_name').SumoSelect({search: true, placeholder: 'Select branch'});
            $('#supplier_name1').SumoSelect({search: true, placeholder: 'Select department'});


</script>
<script type="text/javascript">


  $(document).on('keypress',".posts",function (e) {
        //if  theletter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
    
    
  $(document).on('keypress',".age_st",function (e) {
        //if  theletter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
      $(document).on('keypress',".age_en",function (e) {
        //if  theletter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
    
      $(document).on('keypress',".salary_st",function (e) {
        //if  theletter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
    
      $(document).on('keypress',".salary_en",function (e) {
        //if  theletter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
    
    
    
    
    $(document).ready(function () {
    
    
    
            $('#add_type').click(function(e){
            //  alert("xhbhjxzb");
//            var sta = $("#facility").validationEngine("validate");
            e.preventDefault();
//            if(sta == true){

            var cur = $(this);
            var data = $('#qualification_form').serializeArray();
            //  alert(data);
            $('.body_blur').show();
            $.post('<?= base_url();?>hr/Recruitment/new_qualification', data, function(data){
               // 
                if(data.status){
                    var data = data.data;
                    //  alert(data);
                    //      console.log(data);

//                      var opt= '<label>Facility rooms details</label>'+'<select  id="facility" name="facility[]"  class="form-control validate[required]  "  multiple="multiple"></select>';
                    var opt='<option value="">Please select</option> '  ;

                    for(var i=0 ;i<data.length;i++){

                        opt += '<option value="'+data[i].id+'">'+data[i].qualification+'</option>';

                    }

                         
$('.body_blur').hide(); 


                           var center = '<div id="notifications-full"><div id="notifications-full-close" class="close" style="color: black;font-size=26px;"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Added Qualification</div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    alert_close();
                  
                    setTimeout(function(){
                   }, 1000);                    //noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                    $('.qual').html(opt);
                    //   $('#facility').html(opt);
                    //    $('#pkgform')[0].reset();
                    $('#qualification_form').trigger("reset");
                    $('#add_unit_type').modal('hide');




                } else{
                      var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                                        alert_close();

                   // noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                }
            },'json');
//            }



        });


    //         $('#qualification_form').submit(function(e){     
    //   e.preventDefault();

    //   if (v.form()) 
    //   {
    //     $('.body_blur').show();
    //     //$(this).ajaxSubmit(datas);  
    //   }          
    // });

        // $('#gen_submit').click(function (e) {
        //     e.preventDefault();
        //     var sta = $("#requisition_form").validationEngine("validate");
        //     if (sta == true) {
        //         var cur = $(this);
        //         var data = $('#requisition_form').serializeArray();
        //         $('.body_blur').show();
        //         $.post('<?= base_url();?>hr/Recruitment/add_new_requisition', data, function (data) {
        //             $('.body_blur').hide();
        //             if (data.status) {

        //                 noty({text: "Successfully created", type: 'success', layout: 'top', timeout: 3000});
        //                 $('#requisition_form')[0].reset();
        //                 setTimeout(function(){
        //                     window.location="<?php echo base_url()?>hr/Recruitment/requisitions";
        //                 },2000);
        //             } else {
        //                 noty({text: data.reason, type: 'error', layout: 'top', timeout: 3000});
        //             }
        //         }, 'json');

        //     }
        // });
        var v = jQuery("#requisition_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#requisition_form').hide();
                            $('.body_blur').hide();
                          

                           var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Added Requisitions</div></div>';
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
</body>
</html>