<?php echo $default_assets; ?>


</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
<div class="">
    <div class="page-title">
        <div class="title_left">
            <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."></div>
            </h3>
        </div>
        <div class="title_right">
            <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
            
            </div>
        </div>
    </div>

    <div class="clearfix"></div>
    
       <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Set Category Level<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="">
                        <div class="table-responsive tabmargntp30">
                            <form method="post" name="commission_form_up" id="commission_form_up" action="<?php echo base_url();?>admin/home/update_category_level">
                                <div class="col-md-12"> 
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label>No of Levels</label>
                                        <input type="hidden" name="hidden_id" value="<?= $cat_level['id'] ?>">
                                         <input type="text" placeholder="Enter levels here" id="cat_level" name="cat_level" class="form-control" data-rule-required="true" value="<?= $cat_level['value'] ?>" onKeyPress="return isNumberKey(event)">
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <button type="submit" class="btn btn-primary commisionsubmit commi" id="commisionsubmit" name="commisionsubmit">Save</button>
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



</div>
</div>
</div>
</div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">

<!--************************row  end******************************************************************* -->
</div>

<?php echo $footer; ?>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<script type="text/javascript">     
$(document).ready(function () {


 var v = jQuery("#commission_form_up").validate({
   
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
                   
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully updated category levels </div></div>';
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
                    refresh_close();
                    //$.toast(data.reason, {'width': 500});
                   // return false;
                }
            }
        });
    }
 });    
   
 
}); 
 </script> 


</body>
</html>