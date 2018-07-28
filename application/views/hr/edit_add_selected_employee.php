<?php echo $header; ?>
<style type="text/css">
    #edit_brand_name {text-transform: capitalize;}
</style>
<!-- <script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script> -->
<!-- <link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css"> -->

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
                        <h2> Edit Employee <small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a href="<?php echo  base_url();?>hr/employee/add_employee"> <input type="submit" class="btn btn-primary fllft" value="View Employees"></a></li>
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">

                            <!-- ========================== calendar which hide previous date===================================================-->

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            
                                            
                                <form role="form" id="employee_form" method="post" name="staff_form" action="<?= base_url();?>hr/recruitment/add_candidates/">
                                    <div class="box-body">
                                         <input type="hidden" id="id" data-rule-required="true" name="name" class=" form-control" value="<?= $cand['cd_id'];?> " >
                                        <div class="row">
                                            <div class="col-md-4"> <div class="form-group">
                                                    <label style="color: #2E5D78;">Personal :</label>
                                                </div></div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-2"> <div class="form-group">
                                                    <label >Employee Name</label>
                                                  
                                                    <input type="text" id="name" data-rule-required="true" name="name" class=" form-control" value="<?= $cand['name'];?> " >
                                                </div></div>
                                            <div class="col-md-2"><div class="form-group">
                                                    <label for="phone"> Phone</label>
                                                    <input type="text" id="phone" name="phone" class="form-control phone " value="<?= $cand['phone'];?>" data-rule-required="true"/ >
                                                    <p class="phone_ex"></p>
                                                </div></div>
                                            <div class="col-md-2">
                                                <div class="form-group">

                                                    <label for="place"> Blood Group</label>
                                                    <select name="blood_group" class="form-control " >
                                                        <option value="">SELECT BLOOD GROUP</option>
                                                        <option  value="A +ve">A +ve</option>
                                                        <option  value="A -ve">A -ve</option>
                                                        <option value="B +ve">B +ve</option>
                                                        <option value="B -ve">B -ve</option>
                                                        <option  value="AB +ve">AB +ve</option>
                                                        <option value="AB -ve">AB -ve</option>
                                                        <option  value="O +ve">O +ve</option>
                                                        <option  value="O -ve">O -ve</option>
                                                    </select>


                                                </div></div>
                                            <div class="col-md-2"><div class="form-group">
                                                    <label for="email">Email</label>
                                                    <input type="email" id="email" name="email" class="form-control " value="<?= $cand['email'];?>" data-rule-required="true">

                                                </div></div>
                                            <div class="col-md-2"><div class="form-group">
                                                    <label for="p_phone"> Parent Mobile</label>
                                                    <input type="text" id="p_phone" name="p_phone" class="form-control p_phone" data-rule-required="true">


                                                </div></div>
                                            <div class="col-md-2"><div class="form-group">
                                                    <label for="gender">Gender</label>
                                                    <select name="gender" class="gender form-control" id="gender" data-rule-required="true">
                                                        <option value="">SELCET GENDER</option>
                                                        <option <?= $cand['gender'] == 'male' ? 'selected' : '' ;?> value="Male">Male</option>
                                                        <option <?= $cand['gender'] == 'female' ? 'selected' : '' ;?> value="Female">Female</option>
                                                    </select>

                                                </div></div>


                                        </div>
                                        <div class="row"></div>

                                        <div class="row">

                                          <div class="col-md-2">  <div class='form-group input-group date' id=''>
                                           <?php
                                                 $dater= $cand['dob'];
                                                  $date1=date('d-m-Y',strtotime($dater));
                                                  //echo $date1;exit();
                                                ?>
                                                 <label for="place"> Date of Birth</label>
                                                 <input type="text"  id="datepicker1" name="date_of_birth" value="<?=$date1;?>" class="form-control"  data-rule-required="true">

                                                   
                                                    </div>


                                        <!--div class="col-md-2"><div class="form-group">
                                                <label for="place"> Date of Birth</label>
                                                <input type="text" required name="date_of_birth" class="form-control " id="datepicker-example1-1">

                                            </div></div-->

                                                     </div>
                                            <div class="col-md-2"><div class="form-group">
                                                    <label > Bank</label>
                                                    <input type="text"  name="bank_name" class="form-control" id="bank_name" >

                                                </div></div>
                                            <div class="col-md-2"><div class="form-group">
                                                    <label > Bank A/C No</label>
                                                    <input type="text" name="bank_ac_no" class="form-control" id="bank_ac_no">

                                                </div></div>
                                            <div class="col-md-2"><div class="form-group">
                                                    <label > IFSC Code</label>
                                                    <input type="text" name="ifsc_code" class="form-control" id="ifsc_code">

                                                </div></div>
                                            <div class="col-md-2"><div class="form-group">
                                                    <label > Address</label>
                                                    <textarea class="form-control" name="address" ><?= $cand['address'];?></textarea>

                                                </div></div>
                                        </div>
                                        <div class="row">

                                        </div>
                                        <div class="row">
                                            <div class="col-md-4"> <div class="form-group">
                                                    <label style="color: #2E5D78;">Work :</label>
                                                </div></div></div>
                                        <div class="row">
                                            <div class="col-md-3 ">
                                        <div class="form-group">
                                            <label for="email">Branch</label>
                                            <select name="branch" class="form-control  "  id="branch" data-rule-required="true">
                                                <option value="">SELECT BRANCH</option>
                                                <?php foreach ($branch as $key => $value) { ?>
                                                   <option  value="<?= $value['id'];?>"><?= $value['branch'];?></option>
                                                <?php  } ?>
                                            </select>
                                        </div></div>
                                            <div class="col-md-3 slctdt"><div class="form-group">
                                                    <label for="place"> Department</label>
                                                    <select name="department" id="department" class="form-control" data-rule-required="true">
                                                        <option value="">SELECT DEPARTMENT</option>
                                                        <?php foreach($departments as $dept){ ?>
                                                            <option  value="<?= $dept['id'];?>"><?= $dept['tittle'];?></option>
                                                        <?php } ?>
                                                    </select>

                                                </div></div>
                                            <div class="col-md-3"><div class="form-group">
                                                    <label for="designation"> Designation</label>
                                                    <select name="designation" id="designation" class="form-control " data-rule-required="true">
                                                        <option value="">SELECT DESIGNATION</option>
                                                        <?php foreach($designations as $desig){ ?>
                                                            <option value="<?= $desig['id'];?>"><?= $desig['title'];?></option>
                                                        <?php } ?>
                                                    </select>

                                                </div></div>
                                            <div class="col-md-3"><div class="form-group">
                                                    <label for="place">Basic Salary</label>
                                                    <input type="text" name="basic_salary" class="form-control basic_salary" id="basic_salary"  data-rule-required="true" >
                                                    <!--input type="hidden" name="cur_sal_id" class="form-control" id="cur_sal_id" value="<?= $employee['salry_id'];?>"-->

                                                </div></div>
                                         
                                        </div>

                                        <div class="row">
                                 <div class="col-md-4"><div class="form-group">
                                            <label for="probation"> TA</label>
                                          <input type="text" name="ta" class="form-control ta ">

                                        </div></div>
                                 <div class="col-md-4"><div class="form-group">
                                            <label for="probation"> TD</label>
                                          <input type="text" name="da" class="form-control td ">

                                        </div></div>
                                 <div class="col-md-4"><div class="form-group">
                                            <label for="probation">HRA</label>
                                          <input type="text" name="hra" class="form-control hra ">

                                        </div></div>

                            </div>

                                        <div class="row">
                                         <div class="col-md-3"><div class="form-group">
                                            <label for="probation"> Probation Period</label>
                                          <input type="text" name="probation" class="form-control probation "  data-rule-required="true" >

                                        </div></div>
                                             <div class="col-md-2">  <label for="place"> Date of Joining</label>
                                              <div class='form-group input-group date' id='datepicker12'>
                                                
                
                 <input type="text"  id="date_of_join" name="date_of_join" class="form-control" data-rule-required="true">

                   
                    </div>



                                         </div>
    
                                            <div class="col-md-3"><div class="form-group">
                                                    <label for="place"> Work Phone</label>
                                                    <input type="text" name="work_phone" class="form-control work_phone" id="work_phone" >

                                                </div></div>
                                            <div class="col-md-3"><div class="form-group">
                                                    <label for="place"> Work Email</label>
                                                    <input type="email" name="work_email" class="form-control" id="work_email" >

                                                </div></div>

                                        </div>

                                    </div><!-- /.box-body -->

                                    <div class="box-footer">
                                        <button id="staff_add" type="submit" name="gen_submit" class="btn btn-primary  pull-right">Add Employee</button>
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
<!--***************************date picker******************************-->
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

<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script type="text/javascript">
                                                         
 $('#branch').SumoSelect({search: true, placeholder: 'Select branch'});
            $('#department').SumoSelect({search: true, placeholder: 'Select department'});


                                                            $(function () {
                                                                $('#datepicker1').datetimepicker(
                                                        {



                                                  //  minDate: moment("12/10/2017"),
                                                     format: 'DD-MM-YYYY'

                                                }
                                                );
                                                });
                                                </script>
 <script type="text/javascript">
            $(function () {
                $('#date_of_join').datetimepicker(
        {



     format: 'DD-MM-YYYY'

      }
     );
});
        </script>
<script>
    $(document).ready(function(){
        // binds form submission and fields to the validation engine
        //jQuery("#company_form").validationEngine();
        $('.select2').select2({
            placeholder: 'Please Select'
        });

    });

</script>
<script>
    $(document).ready(function(){
        // binds form submission and fields to the validation engine
       // jQuery("#staff_form").validationEngine();
        // $('#department').select2();
        $('#department').change(function(){
            var cur = $(this);
            var dept = cur.val();
            $('.body_blur').show();
            $.post('<?= base_url();?>hr/employee/get_designation_by_dep/'+dept, function(data){
                $('.body_blur').hide();
                if(data.status){
                    var data = data.data;
                    var option ='';
                    option += '<option value="">SELECT DESIGNATION</option>';
                    for(var i=0; i<data.length; i++){

                        option += '<option value="'+data[i].id+'">'+data[i].title+'</option>';
                    }
                    //console.log(option);
                    cur.parents().find('#designation').html(option);
                } else{
                     $.toast("No Designation", {'width' :500});
                }
            },'json');
        });
    });

</script>
<script type="text/javascript">
 $(document).ready(function(){


     /*   $("#employee_form").validationEngine();

        $('#staff_add').click(function(e){
            e.preventDefault();
            var sta = $("#employee_form").validationEngine("validate");
            var employee_id = $('#employee_id').val();
            if(sta == true)
            {
                var cur = $(this);
                var data = $('#staff_form').serializeArray();
                $('.body_blur').show();
                $.post('<?= base_url();?>hr/employee/update_staff/'+employee_id, data, function(data){
                    $('.body_blur').hide();
                    console.log(data);
                    if(data.status){

                        $.toast("Successfully added", {'width' :500});
                        setTimeout(function(){

                             window.location="<?php echo base_url().'hr/Employee/add_employee'?>";
                             
                         }, 1000);

                    } else{
                        $.toast(data.reason,{'width' :500});
                    }
                },'json');

            }
         });
      */

var v = $("#employee_form").validate({

            submitHandler: function(datas) {
                $(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#employee_form').hide();
                            $('.body_blur').hide();

                               var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Employee has been added successfully</div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                                                    window.location="<?php echo base_url()?>employee";

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


       $('#employee_form').submit(function(e){     
      e.preventDefault();

      if (v.form()) 
      {
        $('.body_blur').show();
        //$(this).ajaxSubmit(datas);  
      }          
    });

    });

</script>
<script>

/*  $('#add_emp').click(function(e){

            e.preventDefault();

            var sta = $("#employee_form").validationEngine("validate");
            if(sta == true)
            {


          var data = $('#employee_form').serializeArray();
          $('.body_blur').show();
          $.post('<?php echo base_url();?>hr/employee/new_employee', data, function(data){
          $('.body_blur').hide();
          if(data.status){

                                $.toast('Successfully created',{'width' : 500});
                                setTimeout (function(){
                                    location.reload();
                                },1000);
                            } else{

                                $.toast(data.reason,{'width' : 500});

                            }
                        },'json');



}
});


});*/

   /* $(document).ready(function() {


        var v = jQuery("#employee_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#employee_modal').hide();
                            $('.body_blur').hide();
                             
                            $.toast('Employee has been added successfully',{ 'width':500});

                           setTimeout (function(){

                              location.reload();

                            },1000);

                         } else
                        {
                          
                            $('.body_blur').hide();
                            $.toast(data.reason, {'width': 500});
                            return false;
                        }
                        }
                  
                });
            }
        });



    });*/
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
$(document).ready(function () {
  //called when key is pressed in textbox
 
});
 $(document).on('keypress',".basic_salary",function (e) {
     //if  theletter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
     //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
$(document).ready(function () {
  //called when key is pressed in textbox
 
});
 $(document).on('keypress',".work_phone",function (e) {
     //if  theletter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
     //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
$(document).ready(function () {
  //called when key is pressed in textbox
 
});
 $(document).on('keypress',".probation",function (e) {
     //if  theletter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
     //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
$(document).ready(function () {
  //called when key is pressed in textbox
 
});
 $(document).on('keypress',".probation",function (e) {
     //if  theletter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
     //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
$(document).ready(function () {
  //called when key is pressed in textbox
 
});
 $(document).on('keypress',".ta",function (e) {
     //if  theletter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
     //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
$(document).ready(function () {
  //called when key is pressed in textbox
 
});
 $(document).on('keypress',".td",function (e) {
     //if  theletter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
     //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
$(document).ready(function () {
  //called when key is pressed in textbox
 
});
 $(document).on('keypress',".hra",function (e) {
     //if  theletter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
     //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
$(document).ready(function () {
  //called when key is pressed in textbox
 
});
 $(document).on('keypress',".p_phone",function (e) {
     //if  theletter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
     //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
$(document).ready(function () {
  //called when key is pressed in textbox
 
});

</script> 

</body>
</html>