<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
  .foo {
    float: left;
    width: 20px;
    height: 20px;
    margin: 5px;
    border: 1px solid rgba(0, 0, 0, .2);
  }

  .green {
    background:#aae6ab;
  }

  .red {
    background:#efc3c3;
  }

  .blue {
    background:#74b2d2;
  }
</style>
<script type="text/javascript">
  function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
  }
</script>
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>All Preferences<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <table id="example" class="display table table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="tablbg">
                                        <th>SI No.</th>
                                        <th>Title</th>
                                        <th>Value</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody style=" height:100px;overflow:scroll">
                                <?php foreach($preferences as $key=>$value){ ?>
                                <tr >
                                    <td><?php echo $key+1 ;?></td>
                                    <td><?php echo $value['title'];?></td>
                                    <td><?php echo $value['value'];?></td>
                                    <td>
                                        <a href="#edit_<?php echo $value['id'];?>" data-toggle="modal" class="clbtn"><button type="button" class="btn btn-primary type_sub"><i class="fa fa-pencil"></i> </button></a>
                                    </td>
                                    <div id="edit_<?php echo $value['id'];?>" class="edit_form modal fade" role="dialog">
                                        <div class="modal-dialog" style="width: 40%;">
                                            <!-- Modal content-->
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="close" data-dismiss="modal">X</button>
                                                    <h4 class="modal-title">Edit Preference</h4>
                                                </div>
                                                <form method="post" id="edt_forms<?php echo $value['id'];?>" class="edt_forms" name="edt_forms" action="<?php echo base_url();?>admin/Home/update_preference">
                                                    <div class="modal-body">
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                                                <label>Title</label>
                                                            </div>
                                                            <div class="col-md-8 col-sm-6 col-xs-12 form-group">
                                                                <input type="text" placeholder="Title" name="title" id="title" value="<?php echo $value['title'];?>" class="form-control" data-rule-required="true" data-msg-required="Please enter title field." readonly="true">
                                                                <input type="hidden" value="<?php echo $value['id'];?>" class="hiddentype_id" name="id">
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                                                <label>Value</label>
                                                            </div>
                                                            <div class="col-md-8 col-sm-6 col-xs-12 form-group">
                                                                <input type="text" placeholder="Value" name="value" id="value" class="form-control" value="<?php echo $value['value'];?>" data-rule-required="true"  data-msg-required="Please enter value field.">
                                                            </div>
                                                    </div>
                                                    <div class="clearfix"></div>
                                                    <div class="modal-footer">
                                                        <div class="col-md-12 form-group ">
                                                             <button type="button" class="btn btn-primary btn_save" id="editsub" data-id="<?php echo $value['id'];?>">Submit</button>

                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </tr>
                                <?php }?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<div id="notifications" style="z-index: 999999;"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>
<script>
    $(document).on('click', '.btn_save', function(e){
        e.preventDefault();
        $('.body_blur').show();
        var cur = $(this);
        var id = cur.data('id');
        var va = "#edt_forms"+id;
        var v = jQuery(va).validate();
        if (v.form()) {
            jQuery(va).ajaxSubmit({
                dataType : "json",
                success  :    function(data)
                {
                    var modl = "#edit_"+id;
                    
                    $('.body_blur').hide();
                    if(data.status)
                    {
                        $(modl).modal('hide');
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text"> Updated Successfully</div></div>';
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
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                        var effect='fadeInRight';
                        $("#notifications").append(center);
                        $("#notifications-full").addClass('animated ' + effect);
                        // refresh_close();
                        $('.close').click(function(){
                            $(this).parent().fadeOut(1000);
                        });
                    }
                }
            });
        }
    });
</script>
<style>


