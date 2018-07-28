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
                                <form  action="<?php echo base_url(); ?>admin/Privilleges/update_privilege/" method="post" id="privilege_form" name="privilege_form">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <label>Group Name</label>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <input type="hidden"  name="group_id" id="group_id" value="<?php echo $privilage['grp']['id'];?>">
                            
                                                <input type="text" placeholder="Group Name" name="group_name" id="group_name"
                                                value="<?php echo $privilage['grp']['title'];?>" class="form-control validate[required] group_name">
                                            </div>
                                        </div>


                                            <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                        <div style="height:52.2px">
        <label>Type</label>&nbsp;&nbsp;

        <label>       <input type="radio"    name="yesno" <?php echo ($privilage['grp']['type']=='normal')?'checked':'';?> value="normal" id="yesCheck"> Normal  </label>
        <label>           <input type="radio"   name="yesno"  <?php echo ($privilage['grp']['type']=='design')?'checked':'';?> value="design" id="noCheck"> Designation Wise</label>

    </div>

                      </div>
                                        <div class="col-md-3">Access Permission</div>
                                        <div class="col-md-3 norm_pr" id="norm_pr">
                                            <div class="form-group">
                                                <select id="1testSelAll" class="form-control select2 1testSelAll" name="access_perm[]"  multiple>
                                                    <option value="">--Select Any--</option>
                                                    <?php  
                                                        $privi = $privilage['grp_sel'];
                                                        foreach ($all_privilage['privilege'] as $priv) {
                                                            $pri_id = $priv['id'];
                                                            if(in_array($pri_id, $privi)){
                                                               $selcted = 'selected = "selected"';
                                                            }else{
                                                               $selcted = '';
                                                            }
                                                    ?>
                                                    <option <?= $selcted;?> value="<?php echo $priv['id'];?>" ><a><?php echo $priv['privilege']?></a></option>
                                                     
                                                    <?php }  ?>
                                                </select>
                                            </div>
                                        </div>



                                         <div class="col-md-3 des_pr" id="des_pr">
                                            <div class="form-group">
                                                <select id="1testSelAll1" class="form-control select2 1testSelAll1" name="access_perm[]"  multiple>
                                                    <option value="">--Select Any--</option>
                                                    <?php  
                                                        $privi = $privilage['grp_sel'];
                                                        foreach ($all_privilage_des['des'] as $priv1) {
                                                            $pri_id = $priv1['id'];
                                                            if(in_array($pri_id, $privi)){
                                                               $selcted = 'selected = "selected"';
                                                            }else{
                                                               $selcted = '';
                                                            }
                                                    ?>
                                                    <option <?= $selcted;?> value="<?php echo $priv1['id'];?>" ><a><?php echo $priv1['privilege']?></a></option>
                                                     
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
            $(document).ready(function() {
              $('#1testSelAll').select2({ width: '100%' });
                            $('#1testSelAll1').select2({ width: '100%' });

            });
            </script> 
            <script src="<?php echo base_url() ?>assets/admin/js/select2.full.js"  type="text/javascript"></script>
            <script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script> 
            <script type="text/javascript">
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
                            window.location = "<?php echo base_url();?>privilleges/0";
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

<script type="text/javascript">
    

     $(document).ready(function(){

                    var type=$("input[name='yesno']:checked"). val();

                   // alert(type);
                    if(type=='normal'){
                $(".norm_pr" ).show();
                 $(".des_pr").hide();
            }

            else{
                $(".norm_pr" ).hide();

                                $(".des_pr").show();
            }


     });
</script>
              <script type="text/javascript">
            $(document).ready(function(){
                  $('input:radio[name="yesno"]').change(
        function()
        {
            if ($(this).val() == 'normal') {
                $(".norm_pr" ).show();
                 $(".des_pr").hide();
            
            }else {
             
                                $(".norm_pr" ).hide();

                                $(".des_pr").show();

            }
        }
    );
              });
            </script>
          </div>
        </div>
    </div>
 </div>
</body>
</html>


