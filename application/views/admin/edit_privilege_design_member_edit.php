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
                        <h2>Update Privilege Details<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="box-body">
                    <form  action="<?php echo base_url(); ?>admin/Privilleges/update_prv_designation_members/" method="post" id="privilege_form" name="privilege_form">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Group Name</label>
                                        </div>

                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="hidden"  name="pr_id" id="pr_id" value="<?php echo $privilage['users']['group_id'] ; ?>">
                            
                                                <input type="text" readonly="" placeholder="Group Name" name="group_name" id="group_name"
                                                value="<?php echo $privilage['users']['group_name'];?>" class="form-control validate[required] group_name" >
                                            </div>
                                        </div>
                                    
                                        <div class="col-md-3">Members</div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <select id="1testSelAll" class="form-control select2 1testSelAll" name="prv_members[]"  multiple>
                                                    <option value="">--Select Any--</option>
                                                    <?php  
                                                        $privi = $privilage['grp_sel'];
                                                        //echo json_encode($privi);exit();
                                                        foreach ($employee['employee'] as $priv) {
                                                            $pri_id = $priv['id'];
                                                            if(in_array($pri_id, $privi)){
                                                               $selcted = 'selected = "selected"';
                                                            }else{
                                                               $selcted = '';
                                                            }
                                                    ?>
                                                    <option <?= $selcted;?> value="<?php echo $priv['id'];?>" ><a><?php echo $priv['designation']?></a></option>
                                                     
                                                    <?php }  ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group pull-right">
                                                <input type="submit" value="Save Changes" class="btn btn-primary antosubmit tpmr10">
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
    </div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>
            <script type="text/javascript">


             function  alert_close(){
             $('.close').click(function(){$(this).parent().fadeOut(1000);});
            setTimeout(function(){  }, 1000);
                }

            $(document).ready(function() {
              $('#1testSelAll').select2({ width: '100%' });
            });
            </script> 
            <script src="<?php echo base_url() ?>assets/admin/js/select2.full.js"  type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script> 
            <script type="text/javascript">



   $("select").on("select2:select", function(evt) {
        var element = evt.params.data.element;
        var $element = $(element);
        $element.detach();
        $(this).append($element);
        $(this).trigger("change");



  if ($('#1testSelAll').select2('val') != null){


    var value=$('#1testSelAll').select2('val');
    var len=value.length;


    for(var i=0;i<len;i++)
    {


    }
   // alert(value);
  // alert(value[len-1]);
 //alert(value[i-1]);
    if(value[len-1]==1)
        {
            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Please update your plan</div></div>';
                                    var effect='zoomIn';
                                    $("#notifications").append(center);
                                    $("#notifications-full").addClass('animated ' + effect);
                                    alert_close();
        }


  }
    });















              $(document).ready(function() {
                var datas = { 
                  dataType : "json",
                  success:   function(data){
                    $('.body_blur').hide();
                    if(data.status){
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Privilage has been updated successfully  </div></div>';
                        var effect='zoomIn';
                        $("#notifications").append(center);
                        $("#notifications-full").addClass('animated ' + effect);
                        setTimeout(function(){
                            window.location = "<?php echo base_url();?>view_designation_members/0";
                        }, 1000);
                    }else {
                       var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+data.reason+'</div></div>';
                        var effect='fadeInRight';
                        $("#notifications").append(center);
                        $("#notifications-full").addClass('animated ' + effect);
                        //refresh_close();
                        $('.close').click(function(){
                            $(this).parent().fadeOut(1000);
                        });
                    }
                  }
                };
                
                $('#privilege_form').submit(function(e){     
                  e.preventDefault();
                  $('.body_blur').show();
                  $(this).ajaxSubmit(datas);            
                });
              });
            </script>
          </div>
        </div>
    </div>
 </div>
</body>
</html>


