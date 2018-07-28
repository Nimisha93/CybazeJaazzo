<?php echo $default_assets; ?>
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Channel Partner Business Type<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <form method="post" name="type_form" id="type_form" action="<?php echo base_url();?>admin/home/new_partner_type">
                                <div class="">
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Select Category</label>
                                        
                                        <select id="channel_type" class="form-control target" name="category" data-rule-required="true">
                                        <option style="font-weight: bold;" value="O">MAIN CATEGORY </option>
                                          <?php foreach($get_allcategory['main'] as $main) {  ?>
                                          <option style="font-weight: bold;" value="<?php echo $main['id'] ?>"><?php echo $main['title']; ?></option>
                                           <?php foreach($main['sub'] as $sub) {  ?>
                                           <option value="<?php echo $sub['id'] ?>">&nbsp; &nbsp; &nbsp;<?php echo $sub['title']; ?></option>
                                          <?php } ?>
                                          <?php } ?>
                                      </select>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Title</label>
                                        <input type="text" placeholder="Title" name="title" class="form-control" data-rule-required="true">
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                                        <label>Description</label>
                                        <textarea class="form-control" title="description" name="description" rows="3" placeholder="Description" class="form-control" data-rule-required="true"></textarea>
                                    </div>

                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <!-- <button type="button" class="btn btn-primary typesubmit" name="type_submit" id="type_submit">Save</button> -->
                                        <input type="submit" class="btn btn-primary typesubmit" name="type_submit" id="type_submit" value="Save">
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
<div id="notifications"></div><input type="hidden" id="position" value="center">
    <!--************************row  end******************************************************************* -->

<!-- <script type="text/javascript">
    $(document).ready(function(){

        $('#type_submit').click(function(e){
            e.preventDefault();
            var sta = $("#type_form").validationEngine("validate");
            if(sta== true){

                var cur= $(this);
                var data=$("#type_form").serializeArray();
                $('.body_blur').show();

                $.post('<?php echo base_url();?>admin/Channel_partner/new_partner_type', data, function(data){
                    $('.body_blur').hide();

                    if(data.status){
                        noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                        $('#type_form')[0].reset();
                    }
                    else{
                        noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                    }

                },'json');
            }

        });

    });
</script> -->


</div>
</div>
</div>
</div>
</div>
<?php echo $footer; ?>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<script type="text/javascript">     
$(document).ready(function () {
 var v = jQuery("#type_form").validate({

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
                   
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added channel partner type </div></div>';
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

<!-- Datatables -->

<!--============new customer popup start here=================-->


</body>
</html>