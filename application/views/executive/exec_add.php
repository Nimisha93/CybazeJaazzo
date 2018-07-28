  <?php echo $header; ?>
   

  <style type="text/css">
      .subc{margin-left: 31px;}

  </style>
<body>
<div class="wrapper">

   <?php echo $sidebar; ?>

    <div class="content">
        <div class="container-fluid">


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-text" data-background-color="orange">
                        <h4 class="card-title"> Add Executive </h4>

                    </div>
                    <div class="card-content">

                        <form method="post" name="exec_form" id="exec_form" action="<?php echo base_url();?>admin/executives/new_executive" enctype="multipart/form-data">
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                
                                        <label>Name</label>
                                        <input type="text" placeholder="Name" name='ename' ng-model="designation" id="designation" class="form-control" data-rule-required="true">
 

                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                <!--     <label class="control-label">Module</label> -->
                                        <label>Desigination</label>
                                      
<!--                                         <select name="dsig"  class="form-control" data-rule-required="true">
                                        <option value="">Select designation</option>
                                        <?php foreach ($designations as $key => $dsg) { ?>
                                        <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?>
                                        </select> -->
                                        <input type="text" placeholder="Designation" data-rule-required="true" name="designation1" value="<?php echo $low['designation'];?>"" class="form-control" readonly="">
                                        <input type="hidden" placeholder="Designation" data-rule-required="true" name="dsig" value="<?php echo $low['id'];?>"" class="form-control" readonly="">

                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                                <label>Email</label>
                                                <input type="email" placeholder="Email" name="email"
                                                       data-rule-required="true" class="form-control">
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label>Mobile</label>
                                    <input type="number" placeholder="Mobile Number" data-rule-required="true"
                                                       name="mob" class="form-control">
                                    <span class="material-input"></span><span class="material-input"></span></div>

                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                     <label>Country</label>
                                            <select name="country" id="country" class="form-control" data-rule-required="true">
                                                <option value="">Please select</option>
                                                <?php foreach ($countries as $key => $county) { ?>
                                                    <option value="<?php echo $county['id']; ?>"><?php echo $county['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                      <label>State</label>
                                            <select name="state" id="states" class="form-control" data-rule-required="true">

                                            </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                      <label>City</label>
                                            <select name="city" id="city" class="form-control">

                                            </select>
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>


                            <div class="col-md-8 col-sm-6 col-xs-12 ">
                             <div class="form-group label-floating is-empty">
                                           <label>Address</label>
                                            <textarea class="form-control" id="descriptext" placeholder="address" name="address" rows="5" data-rule-required="true"></textarea>
                                        </div>
                                        </div>
                                


                           





                            <div class="col-md-12">
                                <input type="submit" class="btn btn-fill btn-rose" value="Submit">

                            </div>
                        </form>
                    </div>
                </div>
            </div>


<div id="notifications"></div><input type="hidden" id="position" value="center">
</div>

        </div>

        

        <?php echo $footer; ?>

<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/admin/sumo-select/sumoex.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>assets/admin/js/sumoslct.js"></script>
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

                    //$('#channel_form').hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added Executive</div></div>';
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
                                        $('.close').click(function(){
                                $(this).parent().fadeOut(1000);
                            });
                    //refresh_close();
                    //$.toast(data.reason, {'width': 500});
                   // return false;
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
                         var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+'No city found'+'</div></div>';
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
    });

    </script>

</body>

</html>