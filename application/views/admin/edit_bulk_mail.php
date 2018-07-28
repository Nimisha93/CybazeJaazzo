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
                        <h2>Bulk Mail<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <form method="post" name="email_form" id="email_form" action="<?php echo base_url();?>admin/Home/send_mail">
                                    <div class="col-md-12">
                                       
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
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
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label for="Email">Email</label>
                                              <select name="selectbox[]" id="selectbox" class="form-control selectbox"  multiple>
                                                
                                              </select>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label for="Subject">Subject</label>
                                              <input type="text" name="subject" id="subject" class="form-control subject" required="required">
                                              
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                            <label>Body</label>
                                            <textarea class="form-control body" title="body" name="body" rows="3" placeholder="Body" class="form-control" data-rule-required="true"></textarea>
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





<script src="https://cloud.tinymce.com/stable/tinymce.min.js?apiKey=ouelsr0cp0wd709qu42eo2a1fcw8iibuwekc5ntce4juh12z"></script>
<script>
    tinymce.init({
        selector: 'textarea',

        height: 80,
        theme: 'modern',
        file_browser_callback_types: 'file image media',
        automatic_uploads: true,
        images_upload_url: '',
        images_reuse_filename: true,
        plugins: [
            'advlist autolink lists link image charmap print preview hr anchor pagebreak',
            'searchreplace wordcount visualblocks visualchars code fullscreen',
            'insertdatetime media nonbreaking save table contextmenu directionality',
            'emoticons template paste textcolor colorpicker textpattern imagetools codesample toc'
        ],

        toolbar1: 'undo redo | insert | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        toolbar2: 'print preview media | forecolor backcolor emoticons | codesample',
        image_advtab: true,
        templates: [
            { title: 'Test template 1', content: 'Test 1' },
            { title: 'Test template 2', content: 'Test 2' }
        ],
        content_css: [
            '//fonts.googleapis.com/css?family=Lato:300,300i,400,400i',
            '//www.tinymce.com/css/codepen.min.css'
        ]

    });
</script>
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
           
            $('#selectbox').SumoSelect({search: true,  placeholder: 'Select Mail',okCancelInMulti: true,triggerChangeCombined: false});
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
          $.post('<?php echo base_url();?>admin/Home/get_user_type/'+type, function(data){
            var data = data.data;
            console.log(data);
            if(data)
            {
                var option ='';
                // option += '<option value="">Please Select</option>';
                 for(var i=0; i<data.length; i++){
                    option += '<option value="'+data[i].email+'">'+data[i].email+'</option>';
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
            // $('#selectbox').SumoSelect({search:true,placeholder:'Select Mail'});


            }
            // $('#selectbox').SumoSelect({search: true, placeholder: 'Select Mail',okCancelInMulti: true,triggerChangeCombined: false});

            $('#selectbox').SumoSelect({ 
                    csvDispCount: 3, 
                    selectAll:true, 
                    search: true, 
                    placeholder: 'Select Mail',
                    okCancelInMulti:true 
                  });
          },'json');
        });
        $(document).ready(function () {
         var v = jQuery("#email_form").validate({

            submitHandler: function(datas) {
            $('.body_blur').show();
            tinyMCE.triggerSave();
                jQuery(datas).ajaxSubmit({
                    
                    dataType : "json",
                    success  :    function(data)
                    {
                         $('.body_blur').hide();
                        if(data.status)
                        {

                            //$('#channel_form').hide();
                           
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully send mail </div></div>';
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