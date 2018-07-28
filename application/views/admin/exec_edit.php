<?php
echo $default_assets; ?>



  <style>
  .SumoSelect {
    display: block;
    position: relative;
    outline: none;
}
</style>
  
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.9.0/ui-bootstrap-tpls.min.js"></script>
<?php echo $sidebar; ?>


<div class="right_col" role="main">
    <div class="">
        
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Executives<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <div class="col-md-12">
                                    <form name="exec_form" action="<?php echo base_url(); ?>admin/Home/edit_addins" class="form-horizontal Calendar" method="post" id="exec_form">
                                    <input type="hidden"  name='id' value="<?php echo $executives['id'];?>" >
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Name</label>
                                        <input type="text" placeholder="Name" name='ename' ng-model="designation" id="designation" class="form-control" value="<?php echo $executives['name'];?>" data-rule-required="true">
                                    </div>
                                    
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Desigination</label>
                                      
                                        <select name="dsig"  class="form-control" data-rule-required="true">
                                        <option value="">Select designation</option>
                                        <?php foreach ($designations as $key => $dsg) { ?>
                                        <option  <?php echo $executives['sales_desig_type_id'] == $dsg['id'] ? 'selected' : '';?> value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?>
                                        </select>
                                    </div>
                                    
                                 
                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                                <label>Email</label>
                                                <input type="email" placeholder="Email" name="email" value="<?php echo $executives['email'];?>"
                                                       data-rule-required="true" class="form-control" readonly>
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                                <label>Mobile</label>
                                                <input type="number" placeholder="Mobile Number" data-rule-required="true" value="<?php echo $executives['phone'];?>"
                                                       name="mob" class="form-control" readonly>
                                            </div>
                                    <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                                            <label>Country</label>
                                            <select name="country" id="country" class="form-control">
                                                <option value="">Please select</option>
                                                 <?php foreach ($countries as $key => $county) { ?>
                                                    <option <?php echo $executives['country'] == $county['name'] ? 'selected' : '';?> value="<?php echo $county['id'];?>"><?php echo $county['name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                                            <label>State</label>
                                            <select name="state" id="states" class="form-control">
                                                <?php foreach ($states as $key => $state) { ?>
                                                    <option <?php echo $executives['state'] === $state['name'] ? 'selected' : '';?>  value="<?php echo $state['id'];?>"><?php echo $state['name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                                            <label>City</label>
                                            <select name="city" id="city" class="form-control">
                                                <?php foreach ($cities as $key => $city) { ?>
                                                    <option <?php echo $executives['city'] === $city['name'] ? 'selected' : '';?> value="<?php echo $city['id'];?>"><?php echo $city['name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" id="descriptext" placeholder="address" name="address" rows="5" data-rule-required="true"><?php echo $executives['address'];?></textarea>
                                        </div>

<!--                                         <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                            <label>Latitude*</label>
                                            <input type="text" placeholder="Latitude" id="lat" name="latt" class="form-control" data-rule-required="true" value="<?php echo $executives['latitude'];?>">
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                            <label>Longitude*</label>
                                            <input type="text" placeholder="Longitude" id="long" name="long" class="form-control" data-rule-required="true" value="<?php echo $executives['longitude'];?>">
                                        </div>

                                        <div class="col-md-12">
                                        <?php echo $map['html']; ?>
                                        <br>
                                        </div> -->

                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
              
                                    
                                    <input type="submit" class="btn btn-primary btn_save pull-right" value="Submit"  id="view_settings">
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
            
                jQuery(datas).ajaxSubmit({
                    
                    dataType : "json",
                    success  :    function(data)
                    {

                        if(data.status)
                        {

                            $('#exec_form').hide();
                            $('.body_blur').hide();

                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Edited Executive </div></div>';
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
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                        }
                    }
                });
            }
        });
        $('#states').SumoSelect();
        $('#city').SumoSelect();
        $('#country').SumoSelect({search: true, placeholder: 'select country'});
        $('#country').change(function () {

            var cur = $(this);
            var country_id = cur.val();

            if (country_id != '') {

                $.get('<?= base_url();?>admin/Home/get_states_by_country', {country_id: country_id}, function (data) {
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

                $.get('<?= base_url();?>admin/Home/get_city_by_state', {state_id: state_id}, function (data) {
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
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+'No city found'+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    }
                }, 'json');
            }

        });
    });

    </script>
</body>
</html>
