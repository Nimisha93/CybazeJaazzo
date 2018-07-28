<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<style type="text/css">
    span.help-inline-error{
        color: red;
    }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
</style>
</head>
<?php echo $sidebar; ?>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            </div>
            <div class="title_right">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">

                        <h2>Channel Partner Types</h2>
                        <ul class="nav navbar-right panel_toolbox">
                           <li><a type="button" class="btn btn-danger fllft del_btn" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a> 
                           </li>
                           <li><a class="btn btn-primary editsub"  style="background-color:#162b52"  href="<?php echo base_url();?>partner_type"><i class="fa fa-user-plus"></i></a> </li>
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
                            <table id="example" class="display table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="tablbg">
                                        <th style="width: 20px">Slno.</th>
                                        <th>Type</th>
                                        <th>Description</th>
                                        <th>Parent</th>
                                        <th style="width: 80px">Action</th>
                                    </tr>
                                </thead>
                                <tbody style=" height:100px;overflow:scroll">
                                    
                                </tbody>
                                <tfoot id ="foot">
                                    <td colspan="10">
                                        <div class="pull-right" id="pagination"></div>
                                    </td>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>

<!-- modal-->
<div id="agree1" class="modal fade" role="dialog">
<div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">X</button>
            <h4 class="modal-title">Edit Channel Partner Type</h4>
        </div>
         <form method="post" id="type_forms" class="type_forms" name="type_forms" action="<?php echo base_url();?>admin/home/edit_partnertype_byid">
               
        <div class="modal-body"  style="overflow:hidden;">
            <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                
               
                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                    <label>Select Category</label>
                    
                    <select id="channel_type" class="form-control target" name="channel_type" data-rule-required="true">
                    <option value="O" style="font-weight: bold;">MAIN CATEGORY </option>
                      <?php 
//echo json_encode($get_allcategory['main']);

                      foreach($get_allcategory['main'] as $main) {  ?>
                      <option style="font-weight: bold;" value="<?php echo $main['id'] ?>"><?php echo $main['title']; ?></option>
                       <?php foreach($main['sub'] as $sub) {  ?>
                       <option value="<?php echo $sub['id'] ?>">&nbsp; &nbsp; &nbsp;<?php echo $sub['title']; ?></option>
                      <?php } ?>
                      <?php } ?>
                  </select>
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <label>Title</label>
                    <input class="form-control hidden" id="hiddentype" name="hiddentype">
                    <input type="text" placeholder="Last Name" class="form-control" id="title" name="title" value="" data-rule-required="true">
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <label>Description</label>
                    <textarea class="form-control" id="descriptext" name="descriptext" data-rule-required="true"></textarea>
                </div>
                 <div class="col-md-12 col-sm-12 col-xs-12">
                    <label>&nbsp;</label><br>
               <input type="submit" class="btn btn-primary typesubmit" name="type_submit" id="type_submit" value="Save">

                     </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="modal-footer">
         
           <!-- <input type="submit" class="btn btn-primary typesubmit" name="type_submit" id="type_submit" value="Save"> -->
        </div>
        </form>
    </div>
</div>
</div>
<!--end of modal-->

<div id="notifications"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";

        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            
            $.post(base_url + "get_partner_type/" + index, { ajax: true,search:search}, function(data) {
                
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.data.length>0){
                  console.log(data);
                    var tr = '';
                    var data1 = data.data;
                    for(var i = 0; i< data1.length; i++){
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                        var main_cat=(!data1[i].main_cat)?'Main Category':data1[i].main_cat;
                        tr += '<tr>'+

                            '<td class="slno"><input type="hidden" name="parent_id" value="'+data1[i].main_id+'" class="parent_id">'+sl_no+'</td>'+
                            '<td class="titleclass"><input type="hidden" value="'+data1[i].id+'" class="hiddentype_id">'+data1[i].title+'</td>'+
                            '<td class="descrip">'+data1[i].description+'</td>'+
                            '<td class="parent">'+main_cat+'</td>'+
                               
                            '<td><button type="button" class="btn btn-primary type_sub">'+
                            '<i class="fa fa-pencil"></i></button>'+
                            '<input type="checkbox" name="" value="'+data1[i].id+'" class="chck_item_id"></td>'+
                            '</tr>';

                    }
                    
                    $('#search').val(data.search);
                
                        $('#pagination').html(data.pagination);
                    

                }else{
                     tr += '<tr><td colspan="10">No data found</td></tr>';
                   
                }
               
                $('tbody').html(tr);
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
<script>
    $(document).ready(function(){
        $(document).on('click','.type_sub',function(){
            var cur=$(this);
            $('#agree1').modal('show');
            var hiddentype_id=cur.parent().parent().find('.hiddentype_id').val();
            var channel_id=cur.parent().parent().find('.channel_id').val();
            var title=cur.parent().parent().find('.titleclass').text();
            var descrip=cur.parent().parent().find('.descrip').text();
            var parent=cur.parent().parent().find('.parent_id').val();
           
            parent1 =(!parent)? '0': parent;
           
           var yy='';
            $(document).find('#title').val(title);
            $(document).find('#descriptext').val(descrip);
           // $(document).find('#parent').val(parent);
           //$(document).find('#channel_type').val('parent1'); 

           if(parent1==0)
           {
                 $('#channel_type').prop('selected','');

                    $('#channel_type').find('option:first').prop("selected","selected");

           }
           else {
 $('#channel_type').prop('selected','');

            $('#channel_type option[value='+parent1+']').prop('selected','selected');
           }



           // 
             $(document).find('#hiddentype').val(hiddentype_id);

        });
        
       
    });
</script> 
<script type="text/javascript">     
$(document).ready(function () {
 var v = jQuery("#type_forms").validate({

    submitHandler: function(datas) {
    $('.body_blur').show();
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {
                 $('.body_blur').hide();
                if(data.status)
                {

                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully updated channel partner type </div></div>';
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
                    $('.close').click(function(){
                         $(this).parent().fadeOut(1000);
                     });
                    //$.toast(data.reason, {'width': 500});
                   // return false;
                }
            }
        });
    }
 });


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
                $.post('<?php echo base_url();?>admin/home/delete_partnertype/',{chck_item_id:chck_item_id}, function(data){
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
  }); 
 </script> 