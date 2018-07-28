<?php echo $header; ?>
<style type="text/css">
    #edit_brand_name {text-transform: capitalize;}
</style>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>

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
                    <div class="tbleovrscroll" style="min-width: 1200px;overflow-x: auto">
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
                                <td><?= $key + 1; ?> <input type="hidden" name="emp_id" class="emp_id"
                                                            value="<?= $employee['id']; ?>">
                                    <input type="hidden" name="cur_sal_id" class="cur_sal_id"
                                           value="<?= $employee['cur_sal_id']; ?>"></td>

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
                                    <a class="btn btn-info hike_sal"><i class="fa fa-line-chart"></i> Hike</a>
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

<div id="department_modal" class="modal fade" role="dialog">
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
        <input type="text" id="name" required name="name" class=" form-control " data-rule-required="true">
    </div></div>
    <div class="col-md-2"><div class="form-group">
        <label for="phone"> Phone</label>
        <input type="text" id="phone"  data-rule-required="true" name="phone" class="form-control phone >
                                                <p class="phone_ex"></p>
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
        <input type="text" id="p_phone" name="p_phone" class="form-control p_phone " data-rule-required="true">

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
        <input type="text" id='datepicker1' data-rule-required="true" name="date_of_birth" class="form-control " >


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
        </script></div>
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
        <input type="text" name="ifsc_code" class="form-control" id="ifsc_code" >

    </div></div>
    <div class="col-md-4"><div class="form-group">
        <label > Address</label>
        <textarea class="form-control "  name="address" data-rule-required="true"></textarea>

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
            <label for="email">Branch</label>
            <select name="branch" class="form-control" id="branch" data-rule-required="true">
                <option value="">SELECT BRANCH</option>
                <?php foreach ($branch as $key => $value) { ?>
                <option value="<?php echo $value['id'];?>"><?php echo $value['branch'];?></option>
                <?php  } ?>
            </select>
        </div></div>
    <div class="col-md-3">
        <div class="form-group slctdt">
            <label for="email">Department</label><br>
            <select name="department" class="form-control  select_box_sel select2 "  id="department" data-rule-required="true" style="width: 100%">
                <option value="">SELECT DEPARTMENT</option>
                <?php foreach ($departments as $key => $parent) { ?>
                <option value="<?php echo $parent['id'];?>"><?php echo $parent['tittle'];?></option>
                <?php  } ?>
            </select>
        </div></div>

    <div class="col-md-3"><div class="form-group">
        <label for="designation"> Designation</label>
        <select name="designation" id="designation" class="form-control " data-rule-required="true">

        </select>

    </div></div>
    <div class="col-md-3"><div class="form-group">
        <label for="probation"> Probation Period (In Days)</label>
        <input type="text" name="probation" class="form-control probation " data-rule-required="true">

    </div></div>


</div>
<div class="row">
    <div class="col-md-4"><div class="form-group">
        <label for="probation"> TA</label>
        <input type="number" name="ta" class="form-control ta " data-rule-required="true" >

    </div></div>
    <div class="col-md-4"><div class="form-group">
        <label for="probation"> TD</label>
        <input type="number" name="da" class="form-control td" data-rule-required="true">

    </div></div>
    <div class="col-md-4"><div class="form-group">
        <label for="probation">HRA</label>
        <input type="number" name="hra" class="form-control hra " data-rule-required="true">

    </div></div>

</div>
<div class="row">

    <!--div class="col-md-3"><div class="form-group">
            <label for="place"> Date of Joining</label>
            <input type="text" name="date_of_join" class="form-control " id="datepicker-example1" required>

        </div></div-->



    <div>   <div>
        <div class="col-md-3"><div class="form-group">
            <label for="place"> Basic Salary</label>
            <input type="text" name="basic_salary" class="form-control basic_salary " id="basic_salary" data-rule-required="true">

        </div></div>
        <div class='col-sm-3'>
            <div class="form-group">

                <label for="place"> Date of Joining</label>
                <input type='text' class="form-control" name="date_of_join" id="date_of_join" data-rule-required="true" id='datepicker1-1' />


            </div>

            <script type="text/javascript">
                $(function () {
                    $('#date_of_join').datetimepicker(
                            {



                                minDate: 0,
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

        <!--  -->

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

<div id="salary_box" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h4 class="modal-title">Salary</h4>
            </div>
            <div class="modal-body div_salary_table">
                <table id="salary_table" class="table display salary_table table-bordered table-striped responsive-utilities">
                    <thead class="the_clss" ">
                    <tr>
                        <th >Salary</th>
                        <th >From</th>
                        <th >to</th>
                    </tr>

                    </thead>

                    <tbody class="tbody_sal" style=" width: 100%; overflow-y: scroll; height: 100px !important; overflow-x: hidden;"" >
                    </tbody>

                    <tfoot>

                    </tfoot>
                </table>
            </div>
            <form id="sal_form" name="sal_form" method="post" action="<?= base_url();?>hr/employee/hike_salary" class="sal_form">
                <div class="modal-body">

                    <div class="col-md-6"><label>New Salary</label>
                        <input type="text" placeholder="New Salary" name="cur_sal" class="form-control cur_sal" data-rule-required="true">
                    </div>
                    <div class="col-md-6"><label>New Salary From</label>
                        <input type="hidden" name="hike_emp_id" class="form-control hike_emp_id">
                        <input type="hidden" name="current_salry_id" class="form-control current_salry_id">
                        <input type="text" id="from_sal" placeholder="From" name="from_sal" class="form-control from_sal" data-rule-required="true">

                        <script type="text/javascript">
                            $(function () {
                                $('#from_sal').datetimepicker(
                                        {



                                            //  minDate: moment("12/10/2017"),
                                            format: 'DD-MM-YYYY'

                                        }
                                );
                            });
                        </script>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div style="margin-top: 15px;" class="modal-footer">
                    <button  type="submit" class="btn btn-info up_cur_sal">Submit</button>
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

<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">

<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js"></script>
<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script>


    $('#branch').SumoSelect({search: true, placeholder: 'Select Branch'});
    $('#department').SumoSelect({search: true, placeholder: 'Select Department'});
    // $('#designation').SumoSelect({search: true, placeholder: 'Select designation'});
    $('#designation').SumoSelect({ placeholder: 'Select Designation'});

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
    $(document).ready(function(){

        $(document).on('click','.hike_sal', function(){
            var cur = $(this);
            var emp_id = cur.parent().parent().find('.emp_id').val();
            var current_salry_id = cur.parent().parent().find('.cur_sal_id').val();
            // alert(emp_id);
            $('.body_blur').show();
            $.post('<?= base_url();?>hr/Employee/get_salary_details/'+emp_id, function(data){
                $('.body_blur').hide();
                if(data.status)
                {
                    var data= data.data;
                    var tr = '';
                    for (var i = 0; i < data.length; i++) 
                    {

var dateAr = data[i].from.split('-');
var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0].slice(0);

var dateAr1 = data[i].to.split('-');
var newDate1 = dateAr1[2] + '-' + dateAr1[1] + '-' + dateAr1[0].slice(0);

                        tr += '<tr>'+
                                '<td>'+data[i].salary+'</td>'+
                                '<td>'+newDate+'</td>'+
                                '<td>'+newDate1+'</td>'+
                                '</tr>'  ;
                    }

                    $('.tbody_sal').html(tr);
                    $('#salary_box').modal('show');
                    $('#salary_box').find('.hike_emp_id').val(emp_id);
                    $('#salary_box').find('.current_salry_id').val(current_salry_id);



                } else{
                    noty({text: data.reason, type: 'error', timeout:1000});
                }
            },'json');
        });

    });

</script>
<script type="text/javascript">
    $(document).ready(function(){


        //      $('#branch').select2();


        //     // binds form submission and fields to the validation engine
        // //     jQuery("#employee_form").validationEngine();
        //     $('#department').select2();
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
                    option += '<option value="">SELECT DESIGNATION</option>';
                    for(var i=0; i<data.length; i++){

                        option += '<option value="'+data[i].id+'">'+data[i].title+'</option>';
                    }
                    //console.log(option);
                    $('#designation').html(option);
                    $('#designation').SumoSelect({search:true,placeholder:'Select Designation'});
                }       else {
                    $.toast('No designation found', {'width': 500});
                }
            },'json');
        });
        /*        $('.up_cur_sal').click(function(){
                    var cur = $(this);
                    var data = $('.sal_form').serializeArray();
                    $('.body_blur').show();
                    $.post('<?= base_url();?>hr/employee/hike_salary', data, function(data){
                $('.body_blur').hide();
                if(data.status)
                {
                    $.toast('Salary updated successfully',{'width' : 500});
                    $('#salary_box').modal('hide');
                    setTimeout(function(){

                             window.location="<?php echo base_url().'hr/Employee/active_employee'?>";
                         }, 1000);
                } else{
                    $.toast(data.reason, { 'width' : 500});
                }
            },'json');
        });*/
        var v = jQuery("#sal_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {
                            //alert("hdfjg");
                            $('#employee_modal').hide();
                            $('.body_blur').hide();


                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Salary updated successfully</div></div>';
                            var effect='zoomIn';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            refresh_close();
                            setTimeout(function(){

                                location.reload();
                            }, 1000);

                        } else
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


        $('#sal_form').submit(function(e){
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


    $(document).ready(function() {


        $(document).on('click', '.btn_add',function (e) {
            e.preventDefault();
            $('#department_modal').modal('show');
            $('#department_modal').find('.modal-title').text('Add Employee');
            $('#department_form').find('.title').val('');
            $('#department_form').find('#submit_department').text('Save');
            $('#submit_department').addClass('add_department');
            $('#submit_department').removeClass('update_department');
            var up_form = '<?= base_url();?>hr/department/new_department';
            $("#department_form").attr("action", up_form);
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
                        noty({text: 'Employee has joined', type: 'success', timeout:1000});
                        $('#salary_box').modal('hide');
                        window.location = "<?php echo site_url();?>hr/employee/get_offer_letter/"+emp_id;
                        //location.reload();
                    } else{
                        noty({text: data.reason, type: 'error', timeout:1000});
                    }
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

                        noty({text: 'Status updated succesfully', type: 'success', timeout:1000});
                        setTimeout(function(){

                            window.location="<?php echo base_url().'hr/Employee/add_employee'?>";
                        }, 2000);
                    } else{
                        noty({text: data.reason, type: 'error', timeout:1000});
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


                        noty({text: 'Status updated succesfully', type: 'success', timeout:1000});
                    } else{
                        noty({text: data.reason, type: 'error', timeout:1000});
                    }
                },'json');
            });
        });

    });
</script>
</body>
</html>