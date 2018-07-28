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
                        <h2>Preference<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="tbleovrscroll">
                            <table id="example" class="display table-bordered table-striped" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                    <th>Title</th>
                                    <th>Value</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php foreach($prefer as $key=> $value) { ?>
                                    <tr>

                                        <td class="title"><?php echo $value->title; ?></td>
                                        <td class="description"><?php echo $value->value; ?></td>
                                        <td><input type="hidden" name="hiddenid" id="hiddenid" value="<?php echo $value->id; ?>">
                                            <button type="button" class="btn btn btn-primary fllft edit_btn" data-toggle="modal" data-target="#myModal"><i class="fa fa-pencil" aria-hidden="true"></i>&nbsp;Edit</button>

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

    <div id="myModal" class="modal fade " role="dialog">
        <div class="modal-dialog modal-sm">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <h4 class="modal-title">Update Preference</h4>
                </div>
                <form id="preference_form" class="preference_form" method="post" action="">
                    <div class="modal-body">
                        <label>Title</label>
                        <br> <input type="text" class="form-control title" id="title" name="title" readonly>
                        <label>value</label>
                        <br> 
                        <input type="hidden" class="form-control id" id="id" name="id">
                       <input type="text" class="form-control value" id="value" name="value">

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="submit_prefernce" class="btn btn-primary submit_prefernce" >Update</button>
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
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>

<script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        // DataTable
        var table = $('#mytable').DataTable();
    });
</script>
<script>
     $(document).ready(function() {
       $(document).on('click','.edit_btn',function(){
var cur=$(this);
var id=cur.parent().parent().find('#hiddenid').val();
$.post('<?php echo base_url();?>hr/Employee/edit_preference/'+id,function(data){
              $('.body_blur').hide();
              if(data.status){ 
                  data=data.data;
                  var result=data.arr;
                  var value=result.value;
                  $('#value').val(value);
                  $('#title').val(result.title);
                  $('#id').val(result.id);

              }
               else{
              noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                }
               },'json');
       });
    });

    </script>
<script type="text/javascript">
    $(document).ready(function(){

        $(document).on('keypress',".value",function (e) {
        //if  theletter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });

    $(document).on('click','#submit_prefernce',function(e){
        e.preventDefault();
        var m = $("#preference_form").validate();
            if(m.form())
            {


              var data = $('#preference_form').serializeArray();
              //console.log(data);exit;
              $('.body_blur').show();
              $.post('<?php echo base_url();?>hr/Employee/update_prefernce', data, function(data){
              $('.body_blur').hide();
              if(data.status){

                  var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Updated  </div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        //$('#channel_form').hide();
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















            var v = jQuery("#preference_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#preference_form').hide();
                            $('.body_blur').hide();

                                


                             var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Resignation Updated Successfully</div></div>';
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

    });


</script>
</body>
</html>