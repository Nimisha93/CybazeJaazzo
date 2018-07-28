<?php echo $default_assets; ?>
<link href="<?php echo base_url() ?>assets/admin/css/select2.css" rel="stylesheet">
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
                        <h2>Ledgers<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li> 
                                <a href="<?php echo base_url();?>add_ledger" data-original-title="Add new" class="btn btn-success" style="background-color:#162b52"><i class="fa fa-plus"></i></a>
                            </li>
                            <li><a type="button" class="btn btn-danger fllft del_btn"><i class="fa fa-trash" aria-hidden="true"></i></a> 
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
                                        <tr class="tablbg">

                                     <th>Action</th>
                                    <th>Group</th>
                                    <th>Ledger</th>
                                    <th>O/p Balance</th>
                                    <th>C/l Balance</th>
                                    <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                  

                                    </tbody>
                                    <tfoot>
                                        <td colspan="6">
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
   

   <div id="add" class="modal fade" role="dialog">
    <div class="modal-dialog" style="max-width:600px">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="item_group_form" method="post" action="<?php echo base_url();?>admin/accounts/editgroup">
                <div class="modal-body">
                    <p>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">

                            <label>Account Type</label>
                            <select class="form-control sel_typee" name="sel_typee" id="sel_typee">
                                <?php 

                                foreach($groups['type'] as $key => $type) { ?>
                                <option  value="<?= $type['id'];?>"><?= $type['name'];?></option>
                                <?php } ?>
                            </select>                        </div> </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">

                        <label>Group Name</label>
                        <input type="text" name="groupname" placeholder="Group Name" class="form-control validate[required] groupname">
                        <input type="hidden" name="group_id" placeholder="Group Name" class="form-control validate[required] group_id">

                    </div>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit_itemgroup" class="btn btn-default">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>
<script type="text/javascript">
$(document).ready(function() {
  $('#1testSelAll').select2({ width: '100%' });
    $('#1testSelAll1').select2({ width: '100%' });

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
                        $.post(base_url + "ledgers/" + index, { ajax: true,search:search}, function(data) {
                           
                            $('tbody').html("");
                            $('.body_blur').hide();
                            var tr = '';
                            if(data.status){
                                var data_l = data.data;
                            var data1 = data_l.ledger;


  
                                for(var i = 0; i< data1.length; i++){

                          
if(data1[i].opening_balance!=null){
    var op=data1[i].opening_balance;
}
else{
    var op='';
}
                                    
                                    var cur_index=parseInt(index);
                                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);

                                       if(data1[i].closing>0)
                                    {
                                        var cl='Dr'+data1[i].closing;
                                    }

                                    else{
                                       var cl='Cr'+data1[i].closing; 
                                    }

                                    tr += '<tr>'+

                                     '<td><a type="button"  class="btn btn-primary fllft edit_btn"><i class="fa fa-pencil" aria-hidden="true"></i></a></td>'+

 '<input type="hidden" class="itemgrp_id" value="'+data1[i].ld_id+'">'+
                                        '<input type="hidden" class="grp_id" value="'+data1[i].id+'">'+
                                        '<input type="hidden" class="grp_name" value="'+data1[i].name+'">'+
                                        '<input type="hidden" class="acc_type_id" value="'+data1[i].acc_type_id+'">'+

                                        '<td>'+data1[i].name+'</td>'+
                            '<td>'+data1[i].ld_name+'</td>'+
                            

                            '<td>'+op+'</td>'+


                          


                                 


                            '<td>'+cl+'</td>'+
                            //'<td>'+data1[i].last_promotion_date+'</td>'+
                          
                                        '<td>'+
                                         '<a type="button" href="'+base_url+"accounts/accounts/view_ledger_entry/"+data1[i].ld_id+'" class="btn btn-primary fllft view"><i class="fa fa-eye" aria-hidden="true"></i></a>';


    if(data1[i]._type=='ACCOUNT')
{
                                         

                                        tr +='<a href="'+base_url+"edit_ledger/"+data1[i].ld_id+'"><button type="button" class="btn btn-primary"><i class="fa fa-pencil"></i> </button></a>';
}

                                        


                                        tr +='<input type="checkbox" name="" value="'+data1[i].ld_id+'" class="chck_item_id"></td>'+
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
            $(document).ready(function(){
    

    $(document).on('click', '.btn_add',function (e) {
        e.preventDefault();
        var group_id  = cur.parent().parent().find('.grp_id').val();
        var group_name  = cur.parent().parent().find('.grp_name').text();
        $('#add').modal('show');
        $('#add').find('.modal-title').text('Add Item Group');
        $('#item_group_form').find('.groupname').val('');
        $('#item_group_form').find('#submit_itemgroup').text('Save');
        $('#submit_itemgroup').addClass('add_item_group');
        $('#submit_itemgroup').removeClass('update_item_group');
        var up_form = '<?= base_url();?>admin/items/addItemGroup';
        $("#item_group_form").attr("action", up_form);
    });
    $(document).on('click', '.edit_btn',function () {
        var cur = $(this);
        var group_id  = cur.parent().parent().find('.grp_id').val();
       var acc_type_id  = cur.parent().parent().find('.acc_type_id').val();
        var group_name  = cur.parent().parent().find('.grp_name').val();
      //  alert(acc_type_id);

        $('#add').modal('show');
        $('#add').find('.modal-title').text('Update  Group');
        $('#item_group_form').find('.groupname').val(group_name);

        $('#item_group_form').find('.group_id').val(group_id);
        $('#item_group_form').find('.sel_typee').val(acc_type_id);
        $('#item_group_form').find('#submit_itemgroup').text('Update');
        $('#submit_itemgroup').removeClass('add_item_group');
        $('#submit_itemgroup').addClass('update_item_group');
        var up_form = '<?= base_url();?>accounts/accounts/editgroup/'+group_id;
        $("#item_group_form").attr("action", up_form);
    });
              });
            </script>
            <script type="text/javascript">
            
             $(document).ready(function() {


        var v = jQuery("#item_group_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#item_group_form').hide();
                            $('.body_blur').hide();
                            
                                 var msg=' Group updated successfully';
                            
                            




                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+msg+'</div></div>';

                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    alert_close();
                    setTimeout(function(){
                        // $('#group_form')[0].reset();
                        //         $('#group_form').hide();

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



$('#item_group_form').submit(function(e){     
      e.preventDefault();

      if (v.form()) 
      {
        $('.body_blur').show();
      
      }          
    });

    });
                //Delete Privilege
                $(document).on('click','.del_btn',function(){
                    var cur=$(this);
                   
                     var itemgrps = [];
                    $('.chck_item_id').each(function () {
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
                                $.post('<?php echo base_url();?>accounts/accounts/delete_ledgers/',{itemgrps:itemgrps}, function(data){
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