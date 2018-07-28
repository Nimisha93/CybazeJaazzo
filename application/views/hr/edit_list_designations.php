<?php echo $header; ?>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/admin/css/buttons.dataTables.min.css" rel="stylesheet">
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content=""></div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>All Designations<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            

                             <li>

                       <a type="button" data-original-title="Add new" class="btn btn-success btn_add" style="background-color:#162b52"><i class="fa fa-user-plus"></i></a>
                    </li>
                                <a type="button" class="btn btn-primary fllft del_btn btn-danger" ><i class="fa fa-trash" aria-hidden="t
                                rue"></i></a>
                            </li>
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="tbleovrscroll">
                            <table id="mytable" class="table table-bordered table-striped" width="100%">
                                <thead>
                                <tr class="tablbg">
                                    <th>No</th>
                                    <th>Branch</th>
                                    <th>Department</th>
                                    <th>Designation</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody id="table_data">
                                <?php foreach($designations as $key=> $desig) {
                                    ?>
                                    <tr>
                                        <td> <?php echo $key+1 ?>
                                        <input type="hidden" class="desig_id"  value="<?php echo $desig['id']; ?>">
                                        <input type="hidden" class="department_id"  value="<?php echo $desig['department_id']; ?>">
                                        <input type="hidden" class="branch_id"  value="<?php echo $desig['branch_id']; ?>">
                                        </td>
                                        <td><?php echo $desig['branch']; ?></td>
                                        <td><?php echo $desig['department']; ?></td>
                                        <td class="desig_name"><?php echo $desig['title']; ?></td>
                                         
                                        <td><a type="button" class="btn btn-primary fllft edit_btn"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</a>
                                         <input type="checkbox" name="" value="<?php echo $desig['id'];?>" class="chck_grp_item"></td>
                                         
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
    <div id="desig_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <h4 class="modal-title">Add Designation</h4>
                </div>
                <form id="desig_form" class="desig_form" method="post" action="<?= base_url();?>hr/Department/add_designation">
                    <div class="modal-body">
                    <label>Branch</label>
                    <select class="form-control" id="branch" name="branch" data-rule-required="true">
                            <option value="">--Select Branch--</option>
                            <?php foreach ($branch as $bran){ ?>
                                <option value="<?= $bran['id'];?>"><?= $bran['branch'];?></option>
                            <?php } ?>
                        </select>
                        <br>
                        <label>Department</label>
                        <select class="form-control" id="dept" name="dept" data-rule-required="true">
                            <option value="">--Select Department--</option>
                            <?php foreach ($departments as $dept){ ?>
                                <option value="<?= $dept['id'];?>"><?= $dept['tittle'];?></option>
                            <?php } ?>
                        </select>
                        <br>
                        <label>Designation</label>
                        <input type="text" class="form-control desig" id="desig" name="desig" data-rule-required="true">
                    </div>
                      <br>
                    <div class="modal-footer">
                        <button type="submit" id="submit_desig" class="btn btn-primary add_desig" >Add</button>
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
<div id="notifications" style="z-index: 99999"></div><input type="hidden" id="position" value="center">

<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<script>
    $(document).ready(function() {
        // DataTable
        var table = $('#mytable').DataTable();
    });
</script>
<script type="text/javascript">
/*    $(document).ready(function() {
        var desig = {
            dataType : "json",
            success  :    function(data)
            {
                if(data.status == true)
                {
                    $('.body_blur').hide();
                    if(data.result=='add'){
                                $.toast('New designation added successfully', {'width': 500});
                            }else{
                                $.toast('Designation updated successfully', {'width': 500});
                            }
                            setTimeout(function(){

                                $('#desig_modal').hide();
                                location.reload();
                            }, 1000);
                        }
                        else
                        {
                            $('.body_blur').hide();
                            $.toast(data.reason, {'width': 500});
                            return false;
                        }
            }
        };
        $('#desig_form').submit(function(e){
            e.preventDefault();
            $(this).ajaxSubmit(desig);
            $('.body_blur').show();
        });
    });*/

    $(document).ready(function() {


        var v = jQuery("#desig_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#desig_modal').hide();
                            $('.body_blur').hide();
                            if(data.result=='add'){
                                   var msg='New designation added successfully';

                            }else{
                                   var msg=' Designation updated successfully';
                            }
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+msg+' </div></div>';
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
                            $('.body_blur').hide();
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

         $('#desig_form').submit(function(e){     
      e.preventDefault();

      if (v.form()) 
      {
        $('.body_blur').show();
        //$(this).ajaxSubmit(datas);  
      }          
    });


    });
        $(document).on('click', '.btn_add',function (e) {
        e.preventDefault();
        $('#desig_modal').modal('show');
        $('#desig_form').find('#desig').val('');
        $('#desig_form').find('#dept').val('');
        $('#desig_modal').find('.modal-title').text('Add Designation');
        $('#desig_form').find('#submit_opt').text('Save');
        $('#submit_desig').addClass('add_desig');
        $('#submit_desig').removeClass('update_desig');
        var up_form = '<?= base_url();?>hr/Department/add_designation';
        $("#desig_modal").attr("action", up_form);
    });
    $(document).on('click', '.edit_btn',function (e) {
        e.preventDefault();
        var cur = $(this);
        var desig_name = cur.parent().parent().find('.desig_name').text();
        var dept_id = cur.parent().parent().find('.department_id').val();
        var branch_id = cur.parent().parent().find('.branch_id').val();
        var desig_id = cur.parent().parent().find('.desig_id').val();
        $('#desig_modal').modal('show');
        $('#desig_form').find('#dept').val(dept_id);
        $('#desig_form').find('#branch').val(branch_id);
        $('#desig_form').find('#desig').val(desig_name);
        $('#desig_modal').find('.modal-title').text('Update Designation');
        $('#desig_form').find('#submit_desig').text('Update');
        $('#submit_desig').removeClass('add_desig');
        $('#submit_desig').addClass('update_desig');
        var up_form = '<?= base_url();?>hr/Department/update_designation/'+desig_id;
        $("#desig_form").attr("action", up_form);
    });






       $(document).on('click','.del_btn',function(){
            var cur=$(this);
            var itemgrps = [];
            $('.chck_grp_item').each(function () {
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
                            $.post('<?php echo base_url();?>hr/department/deletedesignation/',{itemgrps:itemgrps}, function(data){
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


</script>
</body>
</html>