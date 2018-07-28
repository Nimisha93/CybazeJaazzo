<?php echo $default_assets; ?>
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
  .SumoSelect {
    display: block;
    position: relative;
    outline: none;
}
</style>
<script type="text/javascript">
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57 ))
            return false;
        return true;
    }
</script>  
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
                                    <form name="exec_form" action="<?php echo base_url(); ?>admin/Home/exec_addins" class="form-horizontal Calendar" method="post" id="exec_form">
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Name</label>
                                        <input type="text" placeholder="Name" name='ename' ng-model="designation" id="designation" class="form-control" data-rule-required="true">
                                    </div>
                                    
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Designation</label>
                                      
                                        <select name="dsig"  class="form-control" data-rule-required="true">
                                        <option value="">Select designation</option>
                                        <?php foreach ($designations as $key => $dsg) { ?>
                                        <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?>
                                        </select>
                                     <input type="hidden" placeholder="Mobile Number" data-rule-required="true" name="designations" class="form-control" readonly="">

                                    </div>

                                    
                                 
                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                                <label>Email</label>
                                                <input type="email" placeholder="Email" name="email"
                                                       data-rule-required="true" class="form-control">
                                            </div>
                                            <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                                <label>Mobile</label>
                                                <input type="number" onKeyPress="return isNumberKey(event)" placeholder="Mobile Number" data-rule-required="true"
                                                       name="mob" class="form-control">
                                            </div>
                                    <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                                            <label>Country</label>
                                            <select name="country" id="country" class="form-control"  data-rule-required="true">
                                                <option value="">Please select</option>
                                                <?php foreach ($countries as $key => $county) { ?>
                                                    <option value="<?php echo $county['id']; ?>"><?php echo $county['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                                            <label>State</label>
                                            <select name="state" id="states" class="form-control"  data-rule-required="true">

                                            </select>
                                        </div>
                                        <div class="col-md-2 col-sm-6 col-xs-12 form-group">
                                            <label>City</label>
                                            <select name="city" id="city" class="form-control">

                                            </select>
                                        </div>
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" id="descriptext" placeholder="address" name="address" rows="5" data-rule-required="true"></textarea>
                                        </div>

 
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
                    $('.body_blur').hide();
                        if(data.status)
                {
                   
                    //$('#channel_form').hide();
                    
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added Executive </div></div>';
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
                   // refresh_close();
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
            }else{
                var count = $('#states option').length;
                for(var i = 0; i < count; i++) {
                    $('#states')[0].sumo.remove(0);    
                }
                $('#states').html('<option value="">Please Select</option>');
                $('#states').SumoSelect({search: true, placeholder: 'select state'});

                var count1 = $('#city option').length;
                for(var j = 0; j < count1; j++) {
                    $('#city')[0].sumo.remove(0);    
                }
                $('#city').html('<option value="">Please Select</option>');
                $('#city').SumoSelect({search: true, placeholder: 'select city'});
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
                        $('#city').SumoSelect({search: true, placeholder: 'select city'});
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
                    //refresh_close();
                    
                    }
                }, 'json');
            }else{
                var count1 = $('#city option').length;
                for(var j = 0; j < count1; j++) {
                    $('#city')[0].sumo.remove(0);    
                }
                $('#city').html('<option value="">Please Select</option>');
                $('#city').SumoSelect({search: true, placeholder: 'select city'});
            }

        });
    });

    </script>
    <script type="text/javascript">
$(".club_member").change(function(){
   var club_id = $(".club_member option:selected"). val();

   $.post('<?php echo base_url();?>admin/executives/get_count_by_id/'+club_id, function(data){
           var data1 = data.data;
          //alert(data1['ca_limit']);
            if(data1['ca_limit']>data1['ca_count']){

              $(".details").show();
            }
            else{
                
               $(".details").hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Sorry!!....Club Agent Limit Crossed </div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        //$('#channel_form').hide();
                        location.reload();
                    }, 1000);
            }
         
           },'json');

});
</script>
</body>
</html>
