   <?php echo $header; ?>

<body xmlns="http://www.w3.org/1999/html">
<div class="wrapper">

  <?php echo $sidebar; ?>

    <div class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="orange">
                            <i class="material-icons">perm_identity</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title"></h4>
                            <div class="clearfix"></div>
                            <form name="profile_form" action="<?php echo base_url(); ?>admin/Executives/edit_profile/<?php echo $executives['id'];?>" class="form-horizontal Calendar" method="post" id="exec_form">
                                <div class="row">

                                    <div class="col-sm-12">
                                        <div class="form-group label-floating is-empty">
                                            <label >Name</label>
                                            <input type="text" name="name" class="form-control" value="<?php echo $executives['name'];?>" data-rule-required="true">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group label-floating is-empty">
                                            <label >Contact Number</label>
                                            <input type="number" name="c_number" class="form-control" value="<?php echo $executives['phone'];?>" data-rule-required="true" readonly>
                                            <span class="material-input"></span></div>
                                    </div>
                                
                                 
                                    <div class="col-sm-6">
                                        <div class="form-group label-floating is-empty">
                                            <label>Email</label>
                                            <input type="email" name="email" class="form-control" value="<?php echo $executives['email'];?>" data-rule-required="true" readonly>
                                            <span class="material-input"></span></div>
                                    </div>

                                </div>


                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Address</label>
                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"> </label>
                                                <textarea class="form-control" rows="4" data-rule-required="true" name="address"><?php echo $executives['address'];?></textarea>
                                                <span class="material-input"></span></div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-sm-6">

                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                                    <span class="btn btn-rose btn-round btn-file crsor">
                                                        <span class="fileinput-new crsor">Select Profile image</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" name="file" class="crsor" name="pr_image">
                                                    </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>
                                <input type="submit" class="btn btn-rose pull-right" value="Update Profile">
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <a href="#pablo">
                                <img class="img" src="<?php echo base_url();?>upload/exec_profile/<?php echo $executives['image'];?>">
                            </a>
                        </div>
                        <div class="card-content">
                            <h4 class="category"> <?php echo $executives['name'];?></h4>
                            <h6 class=""><?php echo $executives['phone'];?></h6>

                            <h6 class=""><?php echo $executives['email'];?></h6>

                            <p class="description">
                              <?php echo $executives['city'];?>
                              <br>
                              <?php echo $executives['state'];?><br>
                              <?php echo $executives['country'];?><br>

                            </p>


                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="notifications"></div><input type="hidden" id="position" value="center">
</div>
<?php echo $footer; ?>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<script type="text/javascript">
 $(document).ready(function () {

         var v = jQuery("#exec_form").validate({
           
            submitHandler: function(datas) {
                // console.log(v);
                jQuery(datas).ajaxSubmit({
                    
                    dataType : "json",
                    success  :    function(data)
                    {

                if(data.status)
                {

                    //$('#exec_form').hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Updated Profile </div></div>';
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
    $('#exec_form').submit(function(e){     
      e.preventDefault();

    
      if (v.form()) 
      {
       
        $('.body_blur').show();
        //$(this).ajaxSubmit(datas);  
      }          
    });
        $('#states').SumoSelect();
        $('#city').SumoSelect();
        $('#country').SumoSelect({search: true, placeholder: 'select country'});
        $('#country').change(function () {

            var cur = $(this);
            var country_id = cur.val();

            if (country_id != '') {

                $.get('<?= base_url();?>admin/executives/get_states_by_country', {country_id: country_id}, function (data) {
                    if (data.status) {
                        
                        $('#states')[0].sumo.unload();
                        var opt = '';
                        var data = data.data;
                        
                        opt += '<option value="">Please select</option>';
                        for (var i = 0; i < data.length; i++) {

                            opt += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }

                        //  $('#states')[0].sumo.unload();
                        $('#states').html(opt);
                        $('#states').SumoSelect({search: true, placeholder: 'select state'});
                    } else {
                        $.toast('No state found', {'width': 500});
                    }
                }, 'json');
            }
        });
        $('#states').change(function () {
            var cur = $(this);
            var state_id = cur.val();
            
            if (state_id != '') {

                $.get('<?= base_url();?>admin/executives/get_city_by_state', {state_id: state_id}, function (data) {
                    if (data.status) {
                       $('#city')[0].sumo.unload();
                        var opt = '';
                        var data = data.data;
                        for (var i = 0; i < data.length; i++) {
                            opt += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }
                        $('#city').html(opt);
                        $('#city').SumoSelect({search: true, placeholder: 'select state'});
                    } else {
                        $.toast('No city found', {'width': 500});
                    }
                }, 'json');
            }

        });
    });

    </script>

</div>
</div>
</body>

</html>