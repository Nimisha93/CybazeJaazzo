<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/sumo-select/sumoselect.css" rel="stylesheet" />


</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Gift Setting<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <form method="post" name="gift_form" id="gift_form" action="<?php echo base_url();?>admin/Home/add_gift" enctype="multipart/form-data">
                                    <div class="col-md-12">
                                        
                                       
                                        
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Gift Package Name</label>
                                            <input type="text" placeholder="Name of Package" name="name" class="form-control" data-rule-required="true">
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Designation From</label>
                                                <select name="dsig" class="form-control fromdesg1" required="true">
                                                    <option value="">Select</option>
                                                    <?php $a=1; foreach ($team_leader as $key => $dsg) { ?>
                                                    <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?>
                                                </select>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Designation To</label>
                                            <select name="desigto" required="true" class="form-control todesg1">
                                            <option value="">Select</option>
                                            <?php foreach ($designations as $key => $dsg) { ?>
                                            <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?>
                                            </select>
                                        </div>
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                              <label>Image</label>
                                            <div class="input-group">
                                                <label class="input-group-btn">
                                                    <span class="btn btn-primary">
                                                        Browse&hellip; <input type="file" name="userfile" id="pro" class="form-control"  style="display: none;"  >
                                                    </span>
                                                </label>
                                                <input type="text" class="form-control" readonly>
                                            </div>
                                          </div>
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <label>Description</label>
                                            <textarea placeholder="Details" name="details" id="details" class="form-control details"></textarea>

                                        </div>
                                          <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                        <input type="submit" class="btn btn-primary antosubmit" value="Save">
                                         </div>
                                    </div>
                                </form>
                            </div>
                        </div> 
                    </div>   
                </div>
                    <div class="x_panel">
                    <div class="x_title">
                        <h2>All Gift Packages <small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                              <li>
                                <a type="button" class="btn btn-danger del_btn" style="float:  right;" data-title="Delete" data-toggle="tooltip"><i class="fa fa-trash" aria-hidden="true" float="right"></i></a>
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
                        <table id="designation_tbl" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                                <tr class="tablbg">
                                    <th style="width: 35px;">Slno</th>
                                    <th>Package Name</th>
                                    <th>Designation From</th>
                                    <th>Designation To</th>
                                    <th>Image</th>
                                    <th>Description</th>
                                    
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="designation_tbody" style=" height:100px;overflow:scroll">
                            <?php


                                foreach($gift as $key=>$type){

                                ?>
                                <tr>
                                <td class="id"><?php echo $key+1;?></td>
                                <td class="package_name"><?php echo $type['package_name'];?></td>
                                <td class="from"><?php echo $type['designation'];?></td>
                                <input type="hidden" name="to1" class="form-control to1" value="<?php echo $type['to_desig'];?>">
                                <input type="hidden" name="from1" class="form-control from1" value="<?php echo $type['from_desig'];?>">
                                <td class="to"><?php echo $type['to_des'];?></td>
                                <td class="ima"><img src="<?php echo base_url();?>uploads/gifts/<?php echo $type['image'];?>" width="50px" height="50px"></td>
                                <input type="hidden" name="image" value="<?php echo $type['image'];?>" class="image">
                                <td class="description"><?php echo $type['description'];?></td>
                                <td class="text-right">

                                   <a href="#" class="btn_edit"  data-id="<?php echo $type['id'];?>" data-toggle="tooltip" data-original-title="Edit"><button type="button" class="btn btn-primary type_sub"><i class="fa fa-pencil"></i> </button></a><input type="checkbox" name="" value="<?php echo $type['id'];?>" class="chck_grp_item">
                                </td>
                                <?php } ?>
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
                    <div id="gift_modal" class="modal fade" role="dialog">
                        <div class="modal-dialog">
                            <!-- Modal content-->
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal"></button>
                                    <h4 class="modal-title">Update Gift Package</h4>
                                </div>
                                <form id="designation_form" class="department_form" method="post" action="">
                                    <div class="modal-body">
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Gift Package Name</label>
                                             <input type="hidden" placeholder="Name of Package" name="id" class="form-control pack_id" data-rule-required="true">
                                            <input type="text" placeholder="Name of Package" name="name" class="form-control package" data-rule-required="true">
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Designation From</label>
                                                <select name="dsig" class="form-control fromdesg1" required="true">
                                                    <option value="">Select</option>
                                                    <?php $a=1; foreach ($edit_team_leader as $key => $dsg) { ?>
                                                    <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?>
                                                </select>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>Designation To</label>
                                            <select name="desigto" required="true" class="form-control todesg1">
                                            <option value="">Select</option>
                                                    <?php $a=1; foreach ($edit_team_leader as $key => $dsg) { ?>
                                                    <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?>
                                            </select>
                                        </div>
                                            <div class="col-md-3 col-sm-6 col-xs-12">
                                              <label>Image</label>
                                                <div id="imagePreview" class="dummyimage">
                                                 <!-- <img id="dummyimage" class="dummyimage" src="" style="max-width:100%;height:160px"> -->
                                            </div>
                                            <div class="input-group">
                                                <label class="input-group-btn">
                                                    <span class="btn btn-primary">
                                                        Browse&hellip; <input type="file" name="userfile" id="pro" class="form-control image" data-rule-required="true" style="display: none;"  >
                                                    </span>
                                                </label>
                                                <input type="text" class="form-control" readonly>
                                            </div>
                                          </div>
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <label>Description</label>
                                            <textarea placeholder="Details" name="details" id="details" class="form-control details"></textarea>

                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12" style="border-top: 1px solid darkgray;padding: 10px;">
                                            <input type="submit" id="edit_designation" class=" pull-right btn btn-primary edit_designation" >
                                            <button type="button" class="btn btn-default  pull-right" data-dismiss="modal">Close</button>
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
                                        

                                 
               
                                       
<!--************************row  end******************************************************************* -->
     



<div id="notifications"></div><input type="hidden" id="position" value="center">

<!--************************row  end******************************************************************* -->
</div>
<?php echo $footer; ?>
<script type="text/javascript">   
   $(document).on("change",".fromdesg1",function(e) {
        e.preventDefault();
        var from = $(this).val();
        // alert(from);
        $.post('<?= base_url(); ?>admin/Home/get_exec_to_data',{from:from },function(data)
        {
            if(data.status)
            {
                var opt = '';
                data = data.data.result.res;
                console.log(data);
                for(var i = 0; i<data.length; i++)
                {
                    opt += '<option value="'+data[i].id +'">'+data[i].designation +'</option>';
                }
                var sel = "";
                sel += '<label>To Designation</label>'+
                        '<select>'+opt+'</select>';
                $('.todesg1').html(sel);
            }
            else
            {
                noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
            }

        },'json');

    });
</script> 
<script type="text/javascript">     
$(document).ready(function () {
 var v = jQuery("#gift_form").validate({

    submitHandler: function(datas) {
    $('.body_blur').show();
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {
                 $('.body_blur').hide();
                if(data.status)
                {

                    //$('#channel_form').hide();
                   
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added Gift Package </div></div>';
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
}); 
    $(document).on('click', '.btn_edit',function () {
        var cur = $(this);
        var des_id = cur.data('id');  
        var package = cur.parent().parent().find('.package_name').text();
        var from  = cur.parent().parent().find('.from1').val();
        var to  = cur.parent().parent().find('.to1').val();
     
        var image = cur.parent().parent().find('.image').val();
        
        var description = cur.parent().parent().find('.description').text();
        var img_src='<?= base_url();?>uploads/gifts/'+image;



        var tt='<img src="<?= base_url();?>uploads/gifts/'+image+'" height="150" width="150">';
      
        $('#gift_modal').modal('show');
        $('#designation_form').find('.package').val(package);
        $('#designation_form').find('.fromdesg1').val(from);
        $('#designation_form').find('.todesg1').val(to);
        //$('#designation_form').find('.image').val(image);
        $('#designation_form').find('.details').val(description);
        $('#designation_form').find('.pack_id').val(des_id);

        /*$(".dummyimage").attr('src',"http://192.168.1.14/jaazzo/uploads/gifts/visa.png");*/
        $('#designation_form').find('.dummyimage').html(tt);


        //$('#submit_department').addClass('update_department');
        var up_form = '<?= base_url();?>admin/home/update_gift/'+des_id;
        $("#designation_form").attr("action", up_form);
    });
 
    var v = jQuery("#designation_form").validate({

    submitHandler: function(datas) {
    $('.body_blur').show();
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {
                 $('.body_blur').hide();
                if(data.status)
                {

                    //$('#channel_form').hide();
                   
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Updated Gift Package </div></div>';
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
                    $.post('<?php echo base_url();?>admin/home/delete_gift',{itemgrps:itemgrps}, function(data){
                        $('.body_blur').hide();
                        if(data.status)
                        {
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text"> Gift Package deleted successfully</div></div>';
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
 </script> 
  
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>

<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">

<script type="text/javascript">
    $(document).ready(function () {
        //$('.channel_type').SumoSelect({search: true, placeholder: 'select category',okCancelInMulti: true,});
        $('#module').SumoSelect();
        $('.channel_type').SumoSelect({search: true, placeholder: 'select category',okCancelInMulti: true,triggerChangeCombined: false});
        $('#sel_country').SumoSelect({search: true, placeholder: 'select country'});
        $('#sel_state').SumoSelect({search: true, placeholder: 'select state'});
    });
</script>


 <script src="<?php echo base_url();?>assets/admin/js/file-browse/dropzone-min.js"></script>



<script>
$(function() {

  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }

      });
  });
  
});</script>

</body>          
</html>