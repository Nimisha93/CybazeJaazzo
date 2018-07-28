<?php echo $header; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<!-- <script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>
 --><script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>


</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
<div class="">
    <div class="page-title">
        <div class="title_left">
            <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."></div>
        </div>
        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel" style="overflow-x: auto;">
                <div class="x_title">
                    <h2>Employee<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <!-- <li>                    <button type="button" class="btn btn-info pull-right btn_add" data-toggle="tooltip" style="background-color:#162b52;border-color: #162b52" data-title=""><i class="fa fa-plus"></i></button>
                        </li> -->


                        <li>

                            <a type="button" data-original-title="Add new" class="btn btn-success btn_add" style="background-color:#162b52"><i class="fa fa-user-plus"></i></a>
                        </li>
                        <li>
                            <a type="button" class="btn btn-primary fllft del_btn btn-danger" style=""><i class="fa fa-trash" aria-hidden="true"></i></a>
                        </li>
                        <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                        
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="tbleovrscroll" style="overflow-x: auto; min-width: 1200px;">
                        <table id="example" class="display table-bordered table-striped" cellspacing="0" width="100%">
                            <thead>
                            <tr class="tablbg">
                                <th>No</th>
                                <th>Name</th>
                                <th class="HideColumn">Employee Code</th>

                                <th class="HideColumn">Designation</th>
                                <th style="width: 100px">Date of Join</th>
                                <th>Probation Period</th>
                                <th class="HideColumn">Email</th>
                                <th class="HideColumn">Mobile</th>

                                <th class="HideColumn">Salary</th>

                                <th style="width: 100px">Quick Action</th>
                                <th>Action</th>
                            </tr>
                            </thead>
                            <tbody id="table_data">
                            <?php foreach ($employees as $key => $employee) { ?>
                            <tr>
                                
                                 <input type="hidden" name="emp_id" class="emp_id"
                                                            value="<?= $employee['id']; ?>">
                                    <!--input type="hidden" name="cur_sal_id" class="cur_sal_id"
                                                   value="<?= $employee['cur_sal_id']; ?>"-->
                                
                                
                                <td><?= $key + 1; ?></td>

                                <td><?= $employee['name']; ?></td>
                                <td><?= $employee['employee_code']; ?></td>

                                <td><?= $employee['desig']; ?></td>

                                <td><?= $employee['date_of_join']; ?></td>
                                <td><?= $employee['probation']." Days"; ?></td>
                                <td><?= $employee['email']; ?></td>
                                <td><?= $employee['mobile']; ?></td>

                                <td><?= $employee['salary']; ?></td>

                                <td><select class="employee_status form-control" name="employee_status">
                                    <option value="" >Please Select</option>
                                    <option <?= $employee['status'] == 'Active' ? 'selected' : ""; ?>
                                            value="Active">Active
                                    </option>
                                    <option <?= $employee['status'] == 'Terminated' ? 'selected' : ""; ?>
                                            value="Terminated">Terminated
                                    </option>
                                    <option <?= $employee['status'] == 'Resigned' ? 'selected' : ""; ?>
                                            value="Resigned">Resigned
                                    </option>
                                </select>
                                </td>


                                <td><a class="btn btn-primary"
                                       href="<?php echo base_url(); ?>update_employee/<?php echo $employee['id']; ?>">
                                    <i class="fa fa-pencil"></i></a>
                                    <input type="checkbox" name="" value="<?php echo $employee['id'];?>" class="chck_emp_item">
                                    <?php if($employee['status'] != 'Active'){?>
                                        <a class="btn btn-info join_emp"><i class="fa fa-user-circle" aria-hidden="true"></i> Join</a>
                                        <?php } ?>
                                </td>

                            </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<div id="employee_modal" class="modal fade" role="dialog">
<div class="modal-dialog">

<!-- Modal content-->
<div class="modal-content">
<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal"></button>
    <h4 class="modal-title">Add Employee</h4>
</div>
<form id="employee_form" class="employee_form" method="post" action="<?php echo base_url();?>hr/employee/new_employee">
<div class="modal-body">
<div class="box-body">
<div class="row">
    <div class="col-md-4"> <div class="form-group">
        <label style="color: #2E5D78;">Personal :</label>
    </div></div></div>
<div class="row">
    <div class="col-md-2"> <div class="form-group">
        <label >Employee Name</label>
        <input type="text" id="name"  name="name" class=" form-control" data-rule-required="true">
    </div></div>
    <div class="col-md-2"><div class="form-group">
        <label for="phone"> Phone</label>
        <input type="text" id="phone"  required name="phone" class="form-control phone " required>
        <p class="phone_ex" data-rule-required="true"></p>
    </div></div>
    <div class="col-md-2">
        <div class="form-group">

            <label for="place"> Blood Group</label>
            <select name="blood_group" data-rule-required="true" class="form-control " >
                <option value="">SELECT BLOOD GROUP</option>
                <option value="A +ve">A +ve</option>
                <option value="A -ve">A -ve</option>
                <option value="B +ve">B +ve</option>
                <option value="B -ve">B -ve</option>
                <option value="AB +ve">AB +ve</option>
                <option value="AB -ve">AB -ve</option>
                <option value="O +ve">O +ve</option>
                <option value="O -ve">O -ve</option>
            </select>


        </div></div>


    <div class="col-md-2"><div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" class="form-control email " data-rule-required="true">
        <p class="mail_ex"></p>

    </div></div>
    <div class="col-md-2"><div class="form-group">
        <label for="p_phone"> Parent Mobile</label>
        <input type="text" id="p_phone" name="p_phone" class="form-control p_phone " data-rule-required="true" >

    </div></div>
    <div class="col-md-2"><div class="form-group">
        <label for="gender">Gender</label>
        <select name="gender" class="gender form-control " id="gender " data-rule-required="true">
            <option value="">SELCET GENDER</option>
            <option value="Male">Male</option>
            <option value="Female">Female</option>
        </select>

    </div></div>
</div>

<div class="row">


    <div class="col-md-2">  <div class='form-group input-group date' >
        <label for="place"> Date of Birth</label>
        <input type="text" name="date_of_birth" class="form-control " id='datepicker1' data-rule-required="true">


    </div>


        <!--div class="col-md-2"><div class="form-group">
                <label for="place"> Date of Birth</label>
                <input type="text" required name="date_of_birth" class="form-control " id="datepicker-example1-1">

            </div></div-->

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
    </div>
    <div class="col-md-2"><div class="form-group">
        <label > Bank</label>
        <input type="text"  name="bank_name" class="form-control " id="bank_name" >

    </div></div>
    <div class="col-md-2"><div class="form-group">
        <label > Bank A/C No</label>
        <input type="text" name="bank_ac_no" class="form-control " id="bank_ac_no " >

    </div></div>
    <div class="col-md-2"><div class="form-group">
        <label > IFSC Code</label>
        <input type="text" name="ifsc_code" class="form-control " id="ifsc_code" >

    </div></div>
    <div class="col-md-4"><div class="form-group">
        <label > Address</label>
        <textarea class="form-control"  name="address" data-rule-required="true"></textarea>

    </div></div>
</div>

<div class="row">


</div>
<div class="row">
    <div class="col-md-4"> <div class="form-group">
        <label style="color: #2E5D78;">Work :</label>
    </div></div></div>
<div class="row">
    <div class="col-md-3">
        <div class="form-group">
            <label for="email">Branch</label><br>
            <select name="branch" class="form-control "  id="branch" data-rule-required="true">
                <option value="">SELECT BRANCH</option>
                <?php foreach ($branch as $key => $value) { ?>
                <option value="<?php echo $value['id'];?>"><?php echo $value['branch'];?></option>
                <?php  } ?>
            </select>
        </div></div>
    <div class="col-md-3 slctdt">
        <div class="form-group">
            <label for="email">Department</label><br>
            <select name="department" class="form-control  select_box_sel select2 "  id="department" data-rule-required="true" style="width: 100%">
                <option value="">SELECT DEPARTMENT</option>
                <?php foreach ($departments as $key => $parent) { ?>
                <option value="<?php echo $parent['id'];?>"><?php echo $parent['tittle'];?></option>
                <?php  } ?>

            </select><br>

        </div></div>

    <div class="col-md-3"><div class="form-group">
        <label for="designation"> Designation</label>
        <select name="designation" id="designation" class="form-control" data-rule-required="true">

        </select>

    </div></div>
    <div class="col-md-3"><div class="form-group">
        <label for="probation"> Probation Period (In Days)</label>
        <input type="text" name="probation" class="form-control probation" data-rule-required="true">

    </div></div>


</div>

<div class="row">
    <div class="col-md-4"><div class="form-group">
        <label for="probation"> TA</label>
        <input type="number" name="ta" class="form-control ta" >

    </div></div>
    <div class="col-md-4"><div class="form-group">
        <label for="probation"> TD</label>
        <input type="number" name="da" class="form-control td" >

    </div></div>
    <div class="col-md-4"><div class="form-group">
        <label for="probation">HRA</label>
        <input type="number" name="hra" class="form-control hra" >

    </div></div>

</div>
<div class="row">


    <div>   <div>
        <div class="col-md-3"><div class="form-group">
            <label for="place"> Basic Salary</label>
            <input type="text" name="basic_salary" class="form-control basic_salary" id="basic_salary" data-rule-required="true">

        </div></div>
        <div class='col-sm-3'>
            <!--  <div class="form-group">
                 <div class='input-group date ' > -->
            <label for="place"> Date of Joining</label>
            <input type='text' class="form-control" name="date_of_join" id="date_of_join" data-rule-required="true" />

            <!--    </div>
           </div> -->

            <script type="text/javascript">
                $(function () {
                    $('#date_of_join').datetimepicker(
                            {



                                //minDate: moment("12/10/2017"),
                                format: 'DD-MM-YYYY'

                            }
                    );
                });
            </script>
        </div>



        <div class="col-md-3"><div class="form-group">
            <label for="place"> Work Phone</label>
            <input type="text" name="work_phone" class="form-control work_phone " id="work_phone">

        </div></div>
        <div class="col-md-3"><div class="form-group">
            <label for="place"> Work Email</label>
            <input type="email" name="work_email" class="form-control" id="work_email">

        </div></div>


    </div>


    </div><!-- /.box-body -->

</div>
<div class="modal-footer">
    <button type="submit" id="add_emp" class="btn btn-primary add_emp" >Add</button>
    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
</div>
</form>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
</div>


<div id="comment_box" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h4 class="modal-title">Comment</h4>
            </div>
            <form action="" name="form_tem" id="form_tem">
                <div class="modal-body">
                    <input type="hidden" name="employee_id" class="form-control employee_id">
                    <input type="hidden" name="ter_status" class="form-control ter_status">
                    <textarea class="form-control reason_comment" name="reason_comment" id="reason_comment"></textarea>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info btn_approve_status">Update</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
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
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<!-- <script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
 -->

<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js"></script>
<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>

<script>


    $('#branch').SumoSelect({search: true, placeholder: 'Select branch'});
    $('#department').SumoSelect({search: true, placeholder: 'Select department'});
    // $('#designation').SumoSelect({search: true, placeholder: 'Select designation'});
    $('#designation').SumoSelect({ placeholder: 'Select designation'});
    // $('#department').select2();
    $(document).ready(function() {
        var table = $('#example').DataTable( {
            fixedHeader: {
                header: true,
                footer: true,
            }
        });

    });
</script>
<script>

    jQuery(document).ready(function(){

        // $(document).on('click','.del_btn',function(){

        //     var cur=$(this);
        //     var empdata = [];
        //     $('.chck_emp_item').each(function () {
        //         var cur_this = $(this);
        //         var cur_val = $(this).val();

        //         if(cur_this.is(":checked")){
        //             empdata.push(cur_val);
        //         }

        //     });

        //     if(empdata.length > 0){
        //         noty({
        //             text: 'Do you want to continue?',
        //             type: 'warning',
        //             buttons: [
        //                 {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {

        //                     // this = button element
        //                     // $noty = $noty element

        //                     $noty.close();


        //                     $('.body_blur').show();
        //                     $.post('<?php echo base_url();?>hr/Employee/delete_staff/',{empdata:empdata}, function(data){
        //                         $('.body_blur').hide();
        //                         if(data.status){

        //                             $.toast('Deleted successfully', {'width': 500,'duration': 2000});
        //                             setTimeout(function(){

        //                                 location.reload();
        //                             }, 2000);


        //                         }else{
        //                             $.toast(data.reason, {'width': 500});
        //                         }
        //                     },'json');
        //                 }


        //                 },
        //                 {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
        //                     $noty.close();

        //                 }
        //                 }
        //             ]
        //         });
        //     }
        // });



        $(document).on('click','.del_btn',function(){
            var cur=$(this);
            var itemgrps = [];
            $('.chck_emp_item').each(function () {
                var cur_this = $(this);
                var cur_val = $(this).val();
                if(cur_this.is(":checked")){
                    itemgrps.push(cur_val);
                }

            });

            if(itemgrps.length > 0){
                $('body').alertBox({
                    title: 'Are You Sure?',
                    lTxt: 'Back',
                    lCallback: function(){

                    },
                    rTxt: 'Okey',
                    rCallback: function(){
                        $('.body_blur').show();
                        $.post('<?php echo base_url();?>hr/Employee/delete_staff/',{itemgrps:itemgrps}, function(data){
                            $('.body_blur').hide();
                            if(data.status)
                            {

                                //$('#channel_form').hide();
                                $('.body_blur').hide();
                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Deleted </div></div>';
                                var effect='zoomIn';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                refresh_close();
                                setTimeout(function(){

                                    //$('#channel_form').hide();
                                    location.reload();
                                }, 1000);
                            }
                            else
                            {
                                // $('#channel_form').hide();
                                var regex = /(<([^>]+)>)/ig;
                                var body = data.reason;
                                var result = body.replace(regex, "");
                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                                var effect='fadeInRight';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                refresh_close();
                                //$.toast(data.reason, {'width': 500});
                                // return false;
                            }
                        },'json');
                    }
                })
            }
        });









        // $('#branch').select2();


        // binds form submission and fields to the validation engine
        //     jQuery("#employee_form").validationEngine();

        $('#department').change(function(){
            var cur = $(this);
            var dept = cur.val();

            $('#designation')[0].sumo.unload();
            $('.body_blur').show();
            $.post('<?= base_url();?>hr/employee/get_designation_by_dep/'+dept, function(data){
                $('.body_blur').hide();
                if(data.status){
                    var data = data.data;
                    var option ='';
                    option += '<option value="">Select Designation</option>';
                    for(var i=0; i<data.length; i++){

                        option += '<option value="'+data[i].id+'">'+data[i].title+'</option>';
                    }
                    //console.log(option);
                    // cur.parents().find('#designation').html(option);

                    $('#designation').html(option);
                    $('#designation').SumoSelect({search:true,placeholder:'Select Designation'});
                }       else {


                    $('.body_blur').hide();
                    //         var regex = /(<([^>]+)>)/ig;
                    //         var body = data.reason;
                    //         var result = body.replace(regex, "");
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close" style="color:black;font-size:26px"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">No designation found</div></div>';
                            var effect='fadeInRight';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            alert_close();

                             var opt = '';
                     $('#designation').html(opt);
            $('#designation').SumoSelect({search:true,placeholder:'Select Designation'});
                    // $.toast('No designation found', {'width': 500});
                }
            },'json');
        });
    });
</script>
<script>
    /*$(document).ready(function(){
      $('#add_emp').click(function(e){

                e.preventDefault();

                var sta = $("#employee_form").validationEngine("validate");
                if(sta == true)
                {

                 var data = $('#employee_form').serializeArray();
                 $('.body_blur').show();
                 $.post('<?php echo base_url();?>hr/employee/new_employee', data, function(data){
             $('.body_blur').hide();
             if(data.status){
             $.toast('Employee has been added successfully',{ 'width':500});

              setTimeout (function(){

                location.reload();

                },1000);

             } else{

            $.toast(data.reason,{ 'width':500});

            }

    },'json');



}
});


});*/
    $(document).ready(function() {


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

                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Employee has been added successfully</div></div>';
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
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close" style="color:black;font-size:26px"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                            var effect='fadeInRight';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            alert_close();
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


    $(document).on('keypress',".phone",function (e) {
        //if  theletter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
    $(document).on('keypress',".p_phone",function (e) {
        //if  theletter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
    $(document).on('keypress',".basic_salary",function (e) {
        //if  theletter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });

    $(document).on('keypress',".work_phone",function (e) {
        //if  theletter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {






        $(document).on('click', '.btn_add',function (e) {
            e.preventDefault();
            $('#employee_modal').modal('show');


        });



        $(document).on('click', '.join_emp', function(){
            var cur = $(this);
            var emp_id = cur.parent().parent().find('.emp_id').val();
            // alert(emp_id);
            $('.body_blur').show();
            $.post('<?= base_url();?>hr/Employee/get_employee_join/'+emp_id, function(data){
                $('.body_blur').hide();
                if(data.status)
                    if(data.status)
                    {
                        // $.toast('Employee has joined',{'width' :500});
                        $('#salary_box').modal('hide');


                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Employee has joined</div></div>';
                        var effect='zoomIn';
                        $("#notifications").append(center);
                        $("#notifications-full").addClass('animated ' + effect);
                        refresh_close();
                        setTimeout(function(){

                            window.location = "<?php echo base_url();?>offer_letter/"+emp_id;
                        }, 1000);
                    } else{
                        var regex = /(<([^>]+)>)/ig;
                        var body = data.reason;
                        var result = body.replace(regex, "");
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                        var effect='fadeInRight';
                        $("#notifications").append(center);
                        $("#notifications-full").addClass('animated ' + effect);
                        refresh_close();                }
            },'json');
        });





        $(document).on('change', '.employee_status', function(){
            var cur = $(this);
            var status = cur.val();
            var emp_id = cur.parent().parent().find('.emp_id').val();//alert(emp_id);
            if(status == 'Terminated'){
                $('#comment_box').modal('show');
                $('#comment_box').find('.employee_id').val(emp_id);
                $('#comment_box').find('.ter_status').val(status);
            } else{
                $('.body_blur').show();
                $.post('<?= base_url();?>hr/Employee/update_status/'+emp_id, {status : status}, function(data){
                    $('.body_blur').hide();
                    if(data.status)
                    {



                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Status Updated Succesfully</div></div>';
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
            }
        });



        $(document).ready(function(){

            $('.btn_approve_status').click(function(){
                var data = $('#form_tem').serializeArray();
                $('.body_blur').show();
                $.post('<?= base_url();?>hr/Employee/update_terminated', data, function(data){
                    $('.body_blur').hide();
                    if(data.status){
                        $('#comment_box').modal('hide');


                        noty({text: 'Status Updated Succesfully', type: 'success', timeout:1000});
                    } else{
                        noty({text: data.reason, type: 'error', timeout:1000});
                    }
                },'json');
            });
        });

    });
</script>
</body>
