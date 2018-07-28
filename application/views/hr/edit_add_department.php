<?php echo $header; ?>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<link href="<?php echo base_url(); ?>assets/admin/css/buttons.dataTables.min.css" rel="stylesheet">
<style type="text/css">
    #edit_brand_name {text-transform: capitalize;}
</style>
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."></div>
            </div>
            <div class="title_right">
            
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Departments<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            

                 <li>

                       <a type="button" data-original-title="Add new" class="btn btn-success btn_add" style="background-color:#162b52"><i class="fa fa-user-plus"></i></a>
                    </li>
                <li>
                <a type="button" class="btn btn-primary fllft del_btn btn-danger" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                </li>
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="tbleovrscroll">

                            <table id="mytable" class="display table-bordered table-striped" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                    <th>No</th>
                                    <th>Department Name</th>
                                    <th>Description</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($department as $key=> $dept) { ?>
                                    <tr>
                                        <td><?php echo $key+1; ?>
                                            <input type="hidden" name="d_id" class="d_id" value="<?php echo $dept['id']; ?>"></td>
                                        <td class="title"><?php echo $dept['tittle']; ?></td>
                                        <td class="description"><?php echo $dept['description']; ?></td>
                                        <td>
                                            <button type="button" class="btn btn btn-primary fllft edit_btn"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</button>
                                            <input type="checkbox" name="" value="<?php echo $dept['id'];?>" class="chck_grp_item"></td>


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
                    <h4 class="modal-title">Add Department</h4>
                </div>
                <form id="department_form" class="department_form" method="post" action="<?= base_url();?>hr/department/new_department">
                    <div class="modal-body">
                   <!--   <label>Branch</label>
                        <select name="branch_type" id="branch_type" class="form-control validate[required]">
                           <option value="">Please select</option>
                           <?php foreach ($station_type as $key => $station) { ?>
                             <option value="<?php echo $station['id'];?>"><?php echo $station['type_name'];?></option>
                           <?php } ?>
                         </select> -->
                        <label>Title</label>

                       <input type="text" class="form-control title" id="title" name="title" data-rule-required="true">
                     <br>
                        <label>Description</label>
                        <br>
                       <textarea name="description" class="description form-control" rows="5" data-rule-required="true"></textarea>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submit_department" class="btn btn-primary add_department" >Add</button>
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
<div id="notifications" style="z-index: 99999"></div><input type="hidden" id="position" value="center">

<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<script>
    $(document).ready(function() {
        // DataTable
        var table = $('#mytable').DataTable();
    });
</script>

<script type="text/javascript">
/*    $(document).ready(function() {
        var datas = { 
    
            dataType : "json",
            
            success  :    function(data)
            {
                if(data.status == true)
                {
                  $('.body_blur').hide();
                  if(data.result=='add'){

                      $.toast('Department added successfully', {'width': 500});
                    setTimeout(function(){
                        $('#department_form')[0].reset();

                    }, 1000);
                  }else{
                    $.toast('Department updated successfully', {'width': 500});
                    setTimeout(function(){
                        $('#department_form')[0].reset();
                          }, 1000);
                  }
                  setTimeout(function(){
                    $('#department_form')[0].reset();
                    location.reload();
                  }, 3000);
                }
                else
                {
                  $('.body_blur').hide();
                  noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                  return false;
                }
                } 
            };
        
        $('#department_form').submit(function(e){     
          e.preventDefault();
          $('.body_blur').show();
          $(this).ajaxSubmit(datas);            
        });
    });*/
    var v = jQuery("#department_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {



 if(data.result=='add'){

   var msg='Successfully Added Department';
                    }else{

                          var  msg='Successfully Updated Department';

                    }

                            $('#department_form').hide();
                            $('.body_blur').hide();

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

     $('#department_form').submit(function(e){     
      e.preventDefault();

      if (v.form()) 
      {
        $('.body_blur').show();
        //$(this).ajaxSubmit(datas);  
      }          
    });


    $(document).on('click', '.btn_add',function (e) {
        e.preventDefault();
        $('#department_modal').modal('show');
        $('#department_modal').find('.modal-title').text('Add Department');
        $('#department_form').find('.title').val('');
        $('#department_form').find('#submit_department').text('Save');
        $('#submit_department').addClass('add_department');
        $('#submit_department').removeClass('update_department');
        var up_form = '<?= base_url();?>hr/department/new_department';
        $("#department_form").attr("action", up_form);
    });
    $(document).on('click', '.edit_btn',function () {
        var cur = $(this);
        var title = cur.parent().parent().find('.title').text();

        var description = cur.parent().parent().find('.description').text();
        var d_id = cur.parent().parent().find('.d_id').val();
        $('#department_modal').modal('show');
        $('#department_modal').find('.modal-title').text('Update Department');
        $('#department_form').find('.title').val(title);
        $('#department_form').find('.description').val(description);
        $('#department_form').find('#submit_department').text('Update');
        $('#submit_department').removeClass('add_department');
        $('#submit_department').addClass('update_department');
        var up_form = '<?= base_url();?>hr/department/update_department/'+d_id;
        $("#department_form").attr("action", up_form);
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
                            $.post('<?php echo base_url();?>hr/department/deleteDepartment/',{itemgrps:itemgrps}, function(data){
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