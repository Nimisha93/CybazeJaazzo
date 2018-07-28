<?php
echo $default_assets;

echo $sidebar;

?>

<div class="right_col" role="main">
    <div class="">
        
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Change password<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <div class="">
                                    <form  class="form-horizontal Calendar" name="pass_form" id="pass_forms" method="post" action="<?php echo base_url();?>admin/Change_password/change_current_pass">
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                      
                                        
                                        <input type="password" placeholder="Current Password" name='old' ng-model="designation" id="old" class="form-control" data-rule-required = "true">
                                        </div>
                                        
                                        
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                      
                                        
                                        <input type="password" placeholder="New Password" name='new_pass' ng-model="designation" id="new_pass" class="form-control" data-rule-required = "true">
                                        
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                      
                                      
                                        
                                        <input type="password" placeholder="Confirm Password" name='confirm_pass' ng-model="designation" id="confirm_pass" class="form-control" data-rule-required = "true">
                                        
                                        </div>
                                        
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <input type="submit" id="change" name="change" class="btn btn-primary antosubmit"></button>
                                    </div>
                                <form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>

        <!--************************row  end******************************************************************* -->

    </div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
<?php echo $footer  ?>
<script type="text/javascript">
    $(document).ready(function () {
        var v = jQuery("#pass_forms").validate({

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

                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully changed password </div></div>';
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
</script>
<!-- <script type="text/javascript">
        $(document).ready(function() {
          
            $('#pass_forms').ajaxForm({

                dataType:  'json',

                success:   function(data){
                    if(data.status){
                       
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully changed password </div></div>';
                            var effect='zoomIn';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            refresh_close();
                            setTimeout(function(){

                                location.reload();
                            }, 1000);
                       
                    } else {
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
                    }

                }
            });
            
        });
       

    </script> -->

