<?php
echo $default_assets;
echo $sidebar;
?>
<style type="text/css">
    #notifications{z-index:100;} 
    span.help-inline-error{
        color: red;
    }
</style>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."></div>
                </h3>
            </div>
            <div class="title_right">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Designation<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <div class="col-md-12">
                                    <form id="desigination" class="form-horizontal Calendar"   method="post" action="<?= base_url(); ?>/admin/pooling/add_designation">
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Designation</label>
                                            <input type="text" placeholder="Designation" name='designation' id="designation" name="designation" class="form-control">
                                        </div>
<!--                                         <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Type</label>
                                            <select class="form-control" name="type" id="type">
                                                <option value="">Select Any</option>
                                                <option value="Executive">Executive</option>
                                                <option value="Non-Executive">Non-Executive</option>
                                            </select>
                                        </div> -->
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Sortorder</label>
                                            <input type="text" placeholder="Sortorder" name='sortorder'  id="sortorder" name="sortorder" class="form-control">
                                        </div>
<!--                                         <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Group</label>
                                            <select id="priv_group" class="form-control " name="priv_group">
                                            <option value="">Please Select</option>
                                                <?php foreach($group['name'] as $grp){?>
                                                <option value="<?php echo $grp['id'];?>"><?php echo $grp['group'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div> -->
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                             <label>&nbsp; </label><br>
                                            <label>Allow Add Executive 
                                           <input type="checkbox" name="add_exec" ></label>
                                        </div> 



                                    <div class="cp" style="display:none">

                                            <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                                <label>BD Facility</label><br />
                                                <input name="bde_count" type="text" class="bde form-control">
                                            </div>
                                    </div>



                                        <div class="col-md-9 col-sm-9 col-xs-12 form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" rows="3" name='description' id="description" name="description" placeholder="Description"></textarea>
                                        </div>
                                        
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                            <button type="submit" id="add_designation" class="btn btn-primary antosubmit">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div id="notifications1"></div><input type="hidden" id="position" value="center"> -->
                <div class="x_panel">
                    <div class="x_title">
                        <h2>All Designations<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                             <li >
                                <a type="button" class="btn btn-danger del_btn" style="float:  right;margin-top: 4px" data-title="Delete" data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true" float="right"></i></a>
                            </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                         <div class="row">
                            <div class="col-sm-offset-6 col-sm-3">
                                <label class="pull-right">Search:</label>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control search" name="search" id="search" placeholder="">
                            </div>
                           
                        </div><br>
                        <table id="designation_tbl" class="display table table-bordered  " cellspacing="0" width="100%">
                            <thead>
                                <tr class="tablbg">
                                    <th style="width: 30px">Slno</th>
                                    <th>Designation</th>
                                   
                                    <th>Sortorder</th>
                                    <th>Description</th>
                                    <!-- <th>Group</th> -->
                                    <th style="width: 90px">Action</th>
                                </tr>
                            </thead>
                            <tbody id="designation_tbody" style=" height:100px;overflow:scroll">
                            </tbody>
                            <tfoot>
                                <td colspan="7">
                                    <div class="pull-right" id="pagination"></div>
                                </td>
                            </tfoot>
                        </table>
                    </div>

                </div>
     
                   
                        
                   
                <!-- Update desg Modal -->
                <div id="designation_modal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"></button>
                                <button type="button" class="close" data-dismiss="modal">X</button>
                                <h4 class="modal-title">Update Designation</h4>
                            </div>
                            <form id="designation_form" class="department_form" method="post" action="">
                                <div class="modal-body" style="overflow:hidden;">
                                <div class="">
                                    <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                        <label>Designation</label>
                                        <input type="text" class="designation form-control" id="designation" name="designation">
                                    </div>

                                    <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                        <label>Sort Order</label>
                                        <input type="text" class="form-control sort_order" id="title" name="sortorder">
                                    </div>
<!--                                       <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                        <label>Group</label>
                                        <select id="priv_group" class="form-control priv_group" name="priv_group">
                                            <option value="">Please Select</option>
                                            <?php foreach($group['name'] as $grp){?>
                                            <option value="<?php echo $grp['id'];?>"><?php echo $grp['group'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div> -->
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                             <label>&nbsp; </label><br>
                                            <label>Allow Add Executive 
                                           <input type="checkbox" name="add_exec1" class="add_exec1" value="1"></label>
                                        </div>
                                    <div class="cp1" style="display:none">
 
                                            <div class="col-sm-3 col-xs-12 form-group">
                                                <label>BD Facility</label><br />
                                                <input name="bde_count" type="text" class="bde form-control">

                                        </div>
                                    </div>
                                        </div> 
                                      
                                       

                                    <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                        <label>Description</label>
                                        <textarea name="description" class="description form-control" rows="5"></textarea>
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12" style="">
                                        <input type="submit" id="edit_designation" class=" btn btn-primary edit_designation" >
                                        <!-- <button type="button" class="btn btn-default  pull-right" data-dismiss="modal">Close</button> -->
                                    </div>

                                </div>        
                                                 <div class="modal-footer">
        <!-- <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> -->
      </div>
                </div>

                     </form>
                        </div>

                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
 <div id="notifications" style="height: 33px !important">
    <input type="hidden" id="position" value="center">
 </div>
<?php echo $footer  ?>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<script>
    //add designation
    var m = jQuery("#desigination").validate({
        rules: {
            designation: {
              required: true
            },
            type: {
              required: true
            },
            sortorder: {
              required: true
            },
            priv_group: {
              required: true
            }
        },
        messages: {
            designation: {
              required: "Please provide a Designation"
            },
            type: {
              required: "Please provide a Type"
            },
            sortorder: {
              required: "Please provide Sort Order"
            },
            priv_group: {
              required: "Please provide a Privilage Group"
            }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas1 = { 
        dataType : "json",
        success:   function(data){
        $('.body_blur').hide();
            if(data.status)
            {
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">  Desigination added successfully</div></div>';
                var effect='zoomIn';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
            }else{
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
    };
    $('#desigination').submit(function(e){     
      e.preventDefault();
      if (m.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas1);  
      }          
    });
    // List all designations
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            $.post(base_url + "new_designation/" + index, { ajax: true,search:search}, function(data) {
                
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.status){

                    var tr = '';
                    var data1 = data.data;
                     console.log(data1);
                    for(var i = 0; i< data1.length; i++){

                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                        var sort=data1[i].sort_order-3;
                           console.log(data1[i].designation);
                        tr += '<tr>'+
                            '<td>'+sl_no+'</td>'+
                            '<td class="designation">'+data1[i].designation+'</td>'+
                           
                            '<td class="sort_order">'+sort+'</td>'+
                            '<td class="description">'+data1[i].description+'</td>'+
                          /*  '<td class="group_name">'+data1[i].group+'</td>'+*/
                            '<input type="hidden" name="group_id" value="'+data1[i].group_id+'" class="group_id">'+
                            '<input type="hidden" name="add_exec" value="'+data1[i].add_exec+'" class="add_exec">'+
                            '<input type="hidden" name="bde_count" value="'+data1[i].bde_count+'" class="bde_count">'+
                            '<td><a href="#" class="btn_edit" data-id="'+data1[i].id+'" data-toggle="tooltip" data-original-title="Edit"><button type="button" class="btn btn-primary type_sub"><i class="fa fa-pencil"></i> </button></a>';
                            if(data1[i].slug!='team_leader'){
                             tr +=   '<input type="checkbox" name="" value="'+data1[i].id+'" class="chck_grp_item"></td>';
                                }
                            '</tr>';
                            
                            
 
                    }

                    $('tbody').html(tr);

                    $('#search').val(data.search);
                    // pagination
                    $('#pagination').html(data.pagination);
                }else{
                }
            }, "json");
        }
        //calling the function
        load_demo();
        //pagination update
        $('#pagination').on('click', '.page_test a', function(e) {
            e.preventDefault();
            var link = $(this).attr("href").split(/\//g).pop();
            load_demo(link);
            return false;
        });
        $("#search").keyup(function(){
            load_demo();
        });
    });
    //Delete designation
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
                    $.post('<?php echo base_url();?>admin/Pooling/delete_designaton',{itemgrps:itemgrps}, function(data){
                        $('.body_blur').hide();
                        if(data.status)
                        {
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text"> Designation deleted successfully</div></div>';
                            var effect='zoomIn';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            refresh_close();
                        }else{
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
            })
        }
    });  
    // update Pop up      
    $(document).on('click', '.btn_edit',function () {
        var cur = $(this);
        var des_id = cur.data('id');  
        var designation = cur.parent().parent().find('.designation').text();
        var sort_order  = cur.parent().parent().find('.sort_order').text();
        var description = cur.parent().parent().find('.description').text();
        var group_name  = cur.parent().parent().find('.group_name').val();
        var group_id  = cur.parent().parent().find('.group_id').val();
        var type  = cur.parent().parent().find('.type').text();
        var add_exec  = cur.parent().parent().find('.add_exec').val();
        var bde_count = cur.parent().parent().find('.bde_count').val();
        $('#designation_modal').modal('show');
        $('#designation_form').find('.designation').val(designation);
        $('#designation_form').find('.sort_order').val(sort_order);
        $('#designation_form').find('.description').val(description);
        $('#designation_form').find('.priv_group').val(group_id);
        $('#designation_form').find('.type').val(type);
        $('#designation_form').find('.bde').val(bde_count);
       
        if(add_exec == '1')
        {
          
            $('#designation_form').find('.add_exec1').prop('checked', true);
             $(".cp1" ).show();
        }

        $('#submit_department').addClass('update_department');
        var up_form = '<?= base_url();?>admin/pooling/update_designation/'+des_id;
        $("#designation_form").attr("action", up_form);
    });
    //update designation
    var v = jQuery("#designation_form").validate({
        rules: {
            designation: {
              required: true
            },
            type: {
              required: true
            },
            sortorder: {
              required: true
            },
            priv_group: {
              required: true
            }
        },
        messages: {
            designation: {
              required: "Please provide a Designation"
            },
            type: {
              required: "Please provide a Type"
            },
            sortorder: {
              required: "Please provide Sort Order"
            },
            priv_group: {
              required: "Please provide a Privilage Group"
            }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas2 = { 
        dataType : "json",
        success:   function(data){
        $('.body_blur').hide();
            if(data.status)
            {
                $('#designation_modal').modal('hide');
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">  Desigination updated successfully</div></div>';
                var effect='zoomIn';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
            }else{
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
    };
    $('#designation_form').submit(function(e){     
      e.preventDefault();
      if (v.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas2);  
      }          
    });


    $('input:checkbox[name="add_exec"]').change(

        function()
        {
    if ($(this).is(':checked')) {
           $( ".cp" ).toggle( "slow");
        }else{
            $(".cp" ).hide();
        }
        }
    );
    $('input:checkbox[name="add_exec1"]').change(

        function()
        {


    if ($(this).is(':checked')) {
           $( ".cp1" ).toggle( "slow");
        }else{
            $(".cp1" ).hide();
        }
        }
    );

</script>
</body>
</html>