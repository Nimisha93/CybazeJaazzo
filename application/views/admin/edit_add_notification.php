<?php echo $default_assets; ?>

<link href="<?php echo base_url();?>assets/admin/css/file-browse/dropzone.min.css" rel="stylesheet" />

</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
<div class="">
    

    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Add Notification<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="">
                        <div class="">
                            <form method="post"  name="ba_form" action="<?php echo base_url();?>admin/Home/add_new_notification" id="ba_form" enctype="multipart/form-data">
                                <div class="col-md-12">
                           

                                    <div class="col-md-5 col-sm-6 col-xs-12 form-group">
                                        <label>Designation Type</label>
                                        <select name="type" id="country" class="form-control  sel_country select_box_sel"  data-rule-required="true" >
                                            <option value="">Please Select</option>
                                            <option value="normal_customer">Normal Customer</option> 
                                            <?php foreach ($type as $key => $s_type) { ?>
                                            <option value="<?php echo $s_type['id'];?>"><?php echo $s_type['designation'];?></option>
                                            <?php  } ?>

                                        </select>
                                    </div>
                                    
                                    <div class="col-md-5 col-sm-6 col-xs-12 form-group" id="types">
                                       
                                            <label for="Contact Number">Types</label>
                                            <select name="cm_types" id="cm_types" class="form-control cm_types select_box_sel "  data-rule-required="true">
                                               <option>Select</option> 
                                               <option value="unlimited">Unlimited</option> 
                                               <option value="investor">Investor</option>
                                               <option value="fixed">Fixed</option>
                                            </select>
                                    </div>

                                    <div class="col-md-5 col-sm-6 col-xs-12 form-group">
                                       
                                            <label for="Contact Number">Members</label>
                                            <select name="members" id="states" class="form-control sel_state select_box_sel "  data-rule-required="true">
                                                
                                            </select>
                                    </div>

                                         <input type="hidden" placeholder="Title" id="log_id" name="log_id" class="form-control "  >

                                    <div class="col-md-5 col-sm-6 col-xs-12 form-group">
                                        <label>Title</label>
                                        <input type="text" placeholder="Title" id="title" name="title" class="form-control "  data-rule-required="true">
                                    </div>

                                    <div class="col-md-7 col-sm-6 col-xs-12 form-group">
                                        <label>Description</label>
                                       <textarea class="form-control" id="descriptext" placeholder="description" name="description" rows="7" cols="10" data-rule-required="true"></textarea>
                                    </div>

                                  
 
                                    </div>
                              
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <input type="submit"  class="btn btn-primary " name="prosubmit" id="prosubmit" value="Save" >
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
</div>
<?php echo $footer; ?>

<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/admin/sumo-select/sumoex.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>assets/admin/js/sumoslct.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">

<!--************************row  end******************************************************************* -->
<script type="text/javascript">
 $(document).ready(function () {
    $('#types').hide();
         var v = jQuery("#ba_form").validate({
        
            submitHandler: function(datas) {
            
                jQuery(datas).ajaxSubmit({
                    
                    dataType : "json",
                    success  :    function(data)
                    {

                        if(data.status)
                {

                    //$('#channel_form').hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Added Notification </div></div>';
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
        $('#states').SumoSelect();
        $('#city').SumoSelect();
         $('#cm_types').SumoSelect();
        $('#country').SumoSelect({search: true, placeholder: 'select country'});
        $('#cm_types').change(function () {

            var cur = $(this);
            var cm_types = cur.val();

            if (cm_types != '') {
              
                     $.get('<?= base_url();?>admin/Home/get_sales_member_by_id/'+cm_types , function (data) {
                    if (data.status) {
                        
                        $('#states')[0].sumo.unload();
                        var opt = '';
                        var data = data.data;
                        
                        opt += '<option value="">Please select</option>';
                        for (var i = 0; i < data.length; i++) {


                            opt += '<option value="' + data[i].id + '"  data-id="' + data[i].log_id + '">' + data[i].name + '</option>';
                        }

                        //  $('#states')[0].sumo.unload();
                        $('#states').html(opt);
                        $('#states').SumoSelect({search: true, placeholder: 'Select members'});
                    } else {
                        // $.toast('No Members found', {'width': 500});
                        var regex = /(<([^>]+)>)/ig;
                                
                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">No Members found</div></div>';
                                var effect='fadeInRight';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                $('.close').click(function(){
                                    $(this).parent().fadeOut(1000);
                                });
                    }
                }, 'json');
        
            }
        });
        $('#country').change(function () {

            var cur = $(this);
            var country_id = cur.val();
             var opt = '';
            if (country_id != '') {
               if(country_id==1)
                 {
                    $('#types').show();
                 }
                else{
                    $('#types').hide();
                     $.get('<?= base_url();?>admin/Home/get_sales_member_by_id/'+country_id , function (data) {
                    if (data.status) {
                        
                        $('#states')[0].sumo.unload();
                       
                        var data = data.data;
                        
                        opt += '<option value="">Please select</option>';
                        for (var i = 0; i < data.length; i++) {


                            opt += '<option value="' + data[i].id + '"  data-id="' + data[i].log_id + '">' + data[i].name + '</option>';
                        }

                        //  $('#states')[0].sumo.unload();
                        $('#states').html(opt);
                        $('#states').SumoSelect({search: true, placeholder: 'Select members'});
                    } else {
                        //$('#states').html(opt);
                        var regex = /(<([^>]+)>)/ig;
                                
                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">No Members found</div></div>';
                                var effect='fadeInRight';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                $('.close').click(function(){
                                    $(this).parent().fadeOut(1000);
                                });
                    }
                }, 'json');
                }
            }else{
                $('#states').html(opt);
            }
        });
        $('#states').change(function () {


            var cur = $(this);
          //var state_id = $(this).data('id');
           var state_id=$(this).find(':selected').data('id')
             
            
            if (state_id != '') {

            $('#log_id').val(state_id);

                
            }

        });
    });

    </script>



<!--============new customer popup start here=================-->


</div>
</div>
</body>
</html>