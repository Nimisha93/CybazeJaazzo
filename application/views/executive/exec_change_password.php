  <?php echo $header; ?>




<body>
<div class="wrapper">

      <?php echo $sidebar; ?>

    <div class="content">
        <div class="container-fluid">

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-icon" data-background-color="orange"
                         data-header-animation="true">
                        <i class="fa fa-eye"></i>
                    </div>
                    <div class="card-content">
                        <h4 class="card-title">Change Pasword</h4>
                        <form name="password_form" id="password_form" action="<?php echo base_url(); ?>admin/Executives/update_password" class="form-horizontal Calendar" method="post" id="user_form">
                            <div class="">

                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label">Old Password</label>
                                        <input type="text" name="current_password" class="form-control" data-rule-required="true">
                                        <span class="material-input"></span><span class="material-input"></span></div>

                                </div>
                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label">New Password</label>
                                        <input type="text" name="new_password" class="form-control" data-rule-required="true">
                                        <span class="material-input"></span><span class="material-input"></span></div>

                                </div>

                                <div class="col-md-4">
                                    <div class="form-group label-floating is-empty">
                                        <label class="control-label">Confirm Password</label>
                                        <input type="text" name="confirm_password" class="form-control" data-rule-required="true">
                                        <span class="material-input"></span><span class="material-input"></span></div>

                                </div>


                            </div>




                    </div>
                    <div class="col-md-12">
                        <input type="submit" class="btn btn-fill btn-rose" value="Submit">
                    </div>
                    </form>
                </div>

            </div>
        </div>


    </div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
  <?php echo $footer; ?>
  <script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<script type="text/javascript">
 $(document).ready(function () {

         var v = jQuery("#password_form").validate({
        
            submitHandler: function(datas) {
            
                jQuery(datas).ajaxSubmit({
                    
                    dataType : "json",
                    success  :    function(data)
                    {

                        if(data.status)
                {

                    //$('#channel_form').hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Changed </div></div>';
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
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    //$.toast(data.reason, {'width': 500});
                   // return false;
                }
                    }
                });

            }
        });
    $('#password_form').submit(function(e){     
      e.preventDefault();

    
      if (v.form()) 
      {
     
        $('.body_blur').show();
        //$(this).ajaxSubmit(datas);  
      }          
    });
    });     
</script>

</body>

</html>