<?= $header; ?>
<body>
<div class="wrapper">
<style>
.card .category:not([class*="text-"]){text-transform: none;}
</style>
<?= $sidebar; ?>

<div class="content">
<div class="container-fluid">


    <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-text" data-background-color="orange">
                <h4 class="card-title"> Set Commission </h4>

            </div>
            <div class="card-content">

                 <form method="post" action="<?php echo base_url();?>admin/Channel_partner/set_new_cp_commission" name="channel_form" id="channel_form" >
                   
                    <div class="col-md-6 col-sm-6 commissiongroup">
                     <?php for($i = 0; $i<$cat_level; $i++){ ?>
                   
                       <div class="form-group label-floating is-empty">
                            <label class="control-label">Category</label>
                            <input type="text" class="form-control category" name="category[]" data-rule-required = "true">
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    
                   <?php } ?>
                  </div>
                   <div class="col-md-6 col-sm-6 commissiongroup">
                     <?php for($i = 0; $i<$cat_level; $i++){ ?>
                   
                        <div class="form-group label-floating is-empty">
                            <label class="control-label">Commission</label>
                            <input type="text" class="form-control commission" name="commission[]" onKeyPress="return isFloatKey(event)" data-rule-required = "true" data-rule-max="100">
                            <span class="material-input"></span><span class="material-input"></span>
                        </div>
                    
                   <?php } ?>
                  </div>
                    <div class="col-md-12">
                        <button type="submit" class="btn btn-fill btn-rose prosubmit" name="prosubmit" id="prosubmit">Submit</button>

                    </div>
                </form>
            </div>
        </div>
    </div>




</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
<?= $footer; ?>


</body>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>


<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script type="text/javascript">
    $('#pro_category').SumoSelect({search: true, placeholder: 'Select Category',okCancelInMulti: true,triggerChangeCombined: false});
   
     var v = jQuery("#channel_form").validate({

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
                       
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added commission </div></div>';
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
</script>


</html>