<?php echo $default_assets; ?>
<link href="<?php echo base_url() ?>assets/admin/css/select2.css" rel="stylesheet">
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
    <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Privileges<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li> 
                                <button type="button" class="btn btn-primary " style="margin-top:8px" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i></button>
                            </li>
                            <li><button type="button" class="btn btn-danger del_btn"  style="margin-top:8px" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></button> 
                            </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="row">
                                <div class="col-sm-offset-7 col-sm-3">
                                    <label class="pull-right">Search:</label>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control search" name="search" id="search" placeholder="">
                                </div>
                            </div><br>
                            <div class="box-body">
                                <table id="purchase_table" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr class="filters">
                                            <th>No</th>
                                            <th>Group Name</th>
                                            <th>Members</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                  

                                    </tbody>
                                    <tfoot>
                                        <td colspan="4">
                                            <div class="pull-right" id="pagination"></div>
                                        </td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- Modal content-->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog pupwidth"> 
          <!-- Modal content-->
          <div class="modal-content">
            <form action="<?php echo base_url(); ?>admin/Privilleges/add_prv_members" method="post" id="privilege_form" name="privilege_form" enctype="multipart/form-data">
              <div class="modal-header">
                <h2>Add Privilege<small></small></h2>
              </div>
              <div class="" id="master_file" style="margin-top: 20px;">
                <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label>Group </label>

                        <select id="prv_grp" name="prv_grp" class="form-control select2">
                            

<option value="">Select</option>
<?php 
foreach ($privilage_grp['privilege_group'] as $key => $prv) {

    ?>
<option value="<?php echo $prv['id'] ; ?>"><?php echo $prv['title'] ; ?></option>

    <?php
   
}


?>



                        </select>
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label>Members</label>
                        <br>

                                <select id="prv_memb" name="prv_memb[]" class="form-control " multiple>
                            

<option value="">Select</option>
<?php 
foreach ($employee['employee'] as $key => $employee) {

    ?>
<option value="<?php echo $employee['id'] ; ?>" data-id="<?php echo $employee['email'] ; ?>"><?php echo $employee['name'] ; ?></option>

    <?php
   
}


?>



                        </select>
                       <!--  <select id="1testSelAll" class="form-control select2 1testSelAll" name="access_perm[]"  multiple>
                          <option value="">--Select Any--</option>
                          <?php foreach($privilage['privilege'] as $pri) {  ?>
                            <option value="<?php echo $pri['id'] ?>"><?php echo $pri['title']; ?></option>
                          <?php } ?>
                        </select> -->
                      </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  <input type="submit" value="Save" class="btn btn-primary antosubmit tpmr10">
                  <button type="button" class="btn btn-default tpmr10" data-dismiss="modal">Close</button>
                </div>
              </div>
            </form>
          </div>
        </div>
    </div>
</div>



  <div id="Upmodel" class="modal fade" role="dialog">
        <div class="modal-dialog pupwidth"> 
          <!-- Modal content-->
          <div class="modal-content">
            <form action="<?php echo base_url(); ?>admin/Privilleges/update_prv_members" method="post" id="up_form" name="up_form" enctype="multipart/form-data">
              <div class="modal-header">
                <h2>Add Privilege<small></small></h2>
              </div>
              <div class="" id="master_file" style="margin-top: 20px;">
                <div class="row">
                    <div class="col-md-12">
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group" id="grp_update">
                        <label>Group </label>

                 <!--        <select id="prv_grp_up" name="prv_grp" class="form-control select2">
                            

<!-- <option value="">Select</option>
<?php 
foreach ($privilage_grp['privilege_group'] as $key => $prv) {

    ?>
<option value="<?php echo $prv['id'] ; ?>"><?php echo $prv['title'] ; ?></option>

    <?php
   
}


?> -->



                        </select> -->


                      </div>
                       <input type="hidden" name="emp_id" id="emp_id" class="form-control">

                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label>Members</label>
                        <br>
                        <input type="text" name="pr_emp" id="pr_emp" class="form-control" readonly="">

     <!--                            <select id="prv_memb" name="prv_memb" class="form-control select2">
                            

<option value="">Select</option>
<?php 
foreach ($employee['employee'] as $key => $employee) {

    ?>
<option value="<?php echo $employee['id'] ; ?>"><?php echo $employee['name'] ; ?></option>

    <?php
   
}


?>



                        </select> -->
                       <!--  <select id="1testSelAll" class="form-control select2 1testSelAll" name="access_perm[]"  multiple>
                          <option value="">--Select Any--</option>
                          <?php foreach($privilage['privilege'] as $pri) {  ?>
                            <option value="<?php echo $pri['id'] ?>"><?php echo $pri['title']; ?></option>
                          <?php } ?>
                        </select> -->
                      </div>
                    </div>
                </div>
              </div>
              <div class="modal-footer">
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  <input type="submit" value="Save" class="btn btn-primary antosubmit tpmr10">
                  <button type="button" class="btn btn-default tpmr10" data-dismiss="modal">Close</button>
                </div>
              </div>
            </form>
          </div>
        </div>
    </div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>


<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<!-- <link href="<?php echo base_url(); ?>assets/admin/sumo-select/sumoex.css" rel="stylesheet">
 -->        <script src="<?php echo base_url(); ?>assets/admin/js/sumoslct.js"></script>
        <link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>

<script type="text/javascript">
$(document).ready(function() {
  $('#1testSelAll').select2({ width: '100%' });
          $('#prv_grp').SumoSelect({search: true, placeholder: 'Select Group'});
                    // $('#prv_memb').SumoSelect({search: true, placeholder: 'Select Members'});
                      $('#prv_memb').select2({ width: '100%' });

                    $('#prv_grp_up').SumoSelect({search: true, placeholder: 'Select Group'});
                    // $('#prv_memb').SumoSelect({search: true, placeholder: 'Select Members'});

          

});
</script> 
<script src="<?php echo base_url() ?>assets/admin/js/select2.full.js"  type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/admin/js/paging.js"></script>
            <script type="text/javascript">
                $(document).ready(function(){
                    var base_url = "<?php echo base_url(); ?>";
                    function load_demo(index) {
                        index = index || 0;
                        var search = $('#search').val();
                        $.post(base_url + "view_members/" + index, { ajax: true,search:search}, function(data) {
                            console.log(data);
                            $('tbody').html("");
                            $('.body_blur').hide();
                            var tr = '';
                            if(data.status){
                                var data1 = data.data;
                                for(var i = 0; i< data1.length; i++){
                                    var cur_index=parseInt(index);
                                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                                    tr += '<tr>'+
                                        '<td>'+sl_no+'</td>'+
                                        '<td>'+data1[i].group_name+'</td>'+
                                        '<td>'+data1[i].employee+'</td>'+
                                       
                                    '<input type="hidden" id="gr_id"  class="gr_id" value="'+data1[i].group_id+'">'+
                                // '<input type="hidden" id="emp_id" value="'+data1[i].user_id+'">'


                                        '<td><a href="'+base_url+"admin/Privilleges/edit_member_by_id/"+data1[i].id+'" id="btn_edit"class="btn_edit"  data-group_id="'+data1[i].group_id+'" data-usr_privilege_id="'+data1[i].user_id+'"   data-id="'+data1[i].id+'">'+
                                        '<button type="button" class="btn btn-primary"><i class="fa fa-pencil"></i> </button></a><input type="checkbox" name="" value="'+data1[i].id+'" class="chck_item_id">'+
                    '<input type="hidden" id="emp_name" class="emp_name" value="'+data1[i].employee+'">'+
                                        '</td>'+
                                        '</tr>';
                                }
                                $('tbody').html(tr);
                                $('#search').val(data.search);
                                // pagination
                                $('#pagination').html(data.pagination);

                            }else{
                                 tr += '<tr>'+
                                        '<td colspan="4" style="text-align:center">No Data Found</td>'+
                                        '</tr>';
                                $('tbody').html(tr);
                            }
                        }, "json");
                    }
                    //calling the function
                    load_demo();
                    //pagination update
                    $('#pagination').on('click', '.page_test a', function(e) {
                        e.preventDefault();
                        //grab the last paramter from url
                        var link = $(this).attr("href").split(/\//g).pop();
                        load_demo(link);
                        return false;
                    });
                    $("#search").keyup(function(){
                        load_demo();
                    });
                });
            </script>

            <script type="text/javascript">
                
                    $(document).ready(function() {


                    var datas = { 
                        dataType : "json",
                        success:   function(data){
                                $('.body_blur').hide();
                                if(data.status)
                                {
                                    $('#Upmodel').modal('hide');
                                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text"> Privillaege Member Updated Successfully</div></div>';
                                    var effect='zoomIn';
                                    $("#notifications").append(center);
                                    $("#notifications-full").addClass('animated ' + effect);
                                    refresh_close();
                                }
                                else
                                {
                                    var regex = /(<([^>]+)>)/ig;
                                    var body = data.reason;
                                    var result = body.replace(regex, "");
                                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                                    var effect='fadeInRight';
                                    $("#notifications").append(center);
                                    $("#notifications-full").addClass('animated ' + effect);
                                    
                                }
                        }
                    };
                    $('#up_form').submit(function(e){     
                        e.preventDefault();
                        $('.body_blur').show();


                        
                        $(this).ajaxSubmit(datas);            
                    });
                });
            </script>

            <script type="text/javascript">
                




//                  $(document).on('change','#pr_emp',function(){

// alert("fcfd");




// });
                 $(document).on('click','.btn_edit',function(){
                    var g='';
                    var m='';
        var cur=$(this);
        var emp_name = cur.parent().parent().find('.emp_name').val();
         var group = cur.attr('data-group_id');
                  var id = cur.attr('data-id');

        // var group = cur.parent().parent().find('.gr_id').val();
//        alert(employee);
         var usr_privilege_id = cur.attr('data-usr_privilege_id');

        $('#Upmodel').modal('show');
        $('#Upmodel').find('.modal-title').text('Update User Privilege');
        // $('#up_form').find('#prv_grp_up').val(group).trigger('change');
g +='<label>Group </label>'+'<select id="prv_grp_up" name="prv_grp" class="form-control select2">'+
'<option value="">Select</option>'+
       '<?php foreach ($privilage_grp['privilege_group'] as $key => $prv){?>';
                       var gg=<?php echo $prv['id'] ?>;
  var gg1=(gg==group)? 'selected' : '' ;

               g += '<option value="<?php echo $prv['id'];?>" '+gg1+'><?php echo $prv['title'] ; ?></option>'+
                '<?php } ?>'+
                '</select>';



                m +='<label>Group </label>'+'<select id="prv_grp_up" name="prv_grp" class="form-control select2">'+
'<option value="">Select</option>'+
       '<?php foreach ($privilage_grp['privilege_group'] as $key => $prv){?>';
                       var gg=<?php echo $prv['id'] ?>;
  var gg1=(gg==group)? 'selected' : '' ;

               m += '<option value="<?php echo $prv['id'];?>" '+gg1+'><?php echo $prv['title'] ; ?></option>'+
                '<?php } ?>'+
                '</select>';


// console.log(emp_name);



$('#grp_update').html(g);

// $("#ledger_name").val(led).trigger('change');
        $('#up_form').find('#pr_emp').val(emp_name);
        $('#up_form').find('#emp_id').val(usr_privilege_id);

        // $('#privilege_form').find('#employee').val(employee);
        // $('#privilege_form').find('#emp_name').attr("disabled", true);

        $('#up_form').find('.antosubmit').val("Update");

        var up_form = '<?= base_url();?>admin/Privilleges/update_prv_members/'+id;
        $("#up_form").attr("action", up_form);

                            $('#prv_grp_up').SumoSelect({search: true, placeholder: 'Select Group'});

    });
            </script>
            <script type="text/javascript">
                //Add Privilege
                $(document).ready(function() {
                    var datas = { 
                        dataType : "json",
                        success:   function(data){
                                $('.body_blur').hide();
                                if(data.status)
                                {
                                    $('#myModal').modal('hide');
                                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">New Member Added Successfully</div></div>';
                                    var effect='zoomIn';
                                    $("#notifications").append(center);
                                    $("#notifications-full").addClass('animated ' + effect);
                                    refresh_close();
                                }
                                else
                                {
                                    var regex = /(<([^>]+)>)/ig;
                                    var body = data.reason;
                                    var result = body.replace(regex, "");
                                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                                    var effect='fadeInRight';
                                    $("#notifications").append(center);
                                    $("#notifications-full").addClass('animated ' + effect);
                                    
                                }
                        }
                    };
                    $('#privilege_form').submit(function(e){     
                        e.preventDefault();
                        $('.body_blur').show();
                        $(this).ajaxSubmit(datas);            
                    });
                });
                //Delete Privilege
                $(document).on('click','.del_btn',function(){
                    var cur=$(this);
                    var chck_item_id = [];
                    $('.chck_item_id').each(function () {
                        var cur_this = $(this);
                        var cur_val = $(this).val();
                        if(cur_this.is(":checked")){
                            chck_item_id.push(cur_val);
                        }
                    });
                    if(chck_item_id.length > 0){
                        $('body').alertBox({
                            title: 'Are You Sure?',
                            lTxt: 'Back',
                            lCallback: function(){
                              
                            },
                            rTxt: 'Okey',
                            rCallback: function(){
                                $('.body_blur').show();
                                $.post('<?php echo base_url();?>delete_privilage_user/',{chck_item_id:chck_item_id}, function(data){
                                    $('.body_blur').hide();
                                    if(data.status){
                                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully deleted </div></div>';
                                        var effect='zoomIn';
                                        $("#notifications").append(center);
                                        $("#notifications-full").addClass('animated ' + effect);
                                        refresh_close();
                                    }else{
                                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+data.reason+'</div></div>';
                                        var effect='fadeInRight';
                                        $("#notifications").append(center);
                                        $("#notifications-full").addClass('animated ' + effect);
                                        //refresh_close();
                                        $('.close').click(function(){
                                            $(this).parent().fadeOut(1000);
                                        });
                                    }
                                },'json');
                            }
                        })
                    }
                });
            </script> 
          </div>
        </div>
    </div>
 </div>
</body>
</html>


