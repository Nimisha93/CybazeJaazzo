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
                        <h2>Bulk SMS<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <form method="post" name="email_form" id="email_form" action="<?php echo base_url();?>admin/Home/send_sms">
                                    <div class="col-md-12">
                                       
                                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                            <label for="Company Name">User Type</label>
                                              <select name="user_type" id="user_type" class="form-control user_type" required="required">
                                                <option value="">Please Select</option>
                                                <option value="executive">Executive</option>    
                                                <option value="club_member">Clubmember</option>
                                                <option value="club_agent">Club Agent</option>
                                                <option value="normal_customer">Normal Customer</option>
                                                <option value="Channel_partner">Channel Partner</option>
                                              </select>
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                            <label for="Email">Mobile</label>
                                              <select name="selectbox[]" id="selectbox" class="form-control selectbox"  multiple>
                                                
                                              </select>
                                        </div>
                                        
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                            <label>Body</label>
                                            <textarea class="form-control body" title="body" name="body" rows="5"   cols="20" placeholder="Body" class="form-control" data-rule-required="true"></textarea>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                          
                                            <input type="submit" class="btn btn-primary channelsubmit" name="channelsubmit" id="channelsubmit" value="Save">
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
    <div class="clearfix"></div>

    <!--************************row  end******************************************************************* -->
     


</div>
</div>
</div>
</div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">

<!--************************row  end******************************************************************* -->
</div>
<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
           
            $('#selectbox').SumoSelect({search: true, placeholder: 'Select Number',okCancelInMulti: true,triggerChangeCombined: false});
        });





           function  alert_close(){
             $('.close').click(function(){$(this).parent().fadeOut(1000);});
            setTimeout(function(){  }, 1000);
        }
    </script>
    <script type="text/javascript">
        $(document).on('change', '#user_type',function(){
          var cur = $(this); 
          var type = cur.val();
          $('#selectbox')[0].sumo.unload();
          $.post('<?php echo base_url();?>admin/Home/get_user_type_mobile/'+type, function(data){
            var data = data.data;
            console.log(data);
            if(data)
            {
                var option ='';
                // option += '<option value="">Please Select</option>';
                 for(var i=0; i<data.length; i++){
                    option += '<option value="'+data[i].phone+'">'+data[i].phone+'('+data[i].name+')</option>';
                 }
                $('#selectbox').html(option);
               
            } else{
               var regex = /(<([^>]+)>)/ig;
                    // var body = data.reason;
                    // var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close" style="color:black;font-size:25px"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+'No member found'+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    alert_close();

 var opt = '';
                     $('#selectbox').html(opt);
            }
            $('#selectbox').SumoSelect({search: true,  selectAll:true, placeholder: 'Select Number',okCancelInMulti: true,triggerChangeCombined: false});



          },'json');
        });
        $(document).ready(function () {
         var v = jQuery("#email_form").validate({

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
                           
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully send SMS </div></div>';
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
 
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">

<script src="<?php echo base_url();?>assets/admin/js/file-browse/dropzone-min.js"></script>

</body>          
</html>