<?php echo $header; ?>
<style>
.slctdt .error {
    position: absolute;
    bottom: -24px;
    left: 15px;
}
</style>

</head>
<?php echo $sidebar; ?>

    <div class="right_col" role="main">
      <div class="">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>New Branch<small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div class="">
                  <div class="container" style="margin-top: 20px;">
                  <form action="<?php echo base_url(); ?>hr/branch/new_branch" method="post" id="branch_form" enctype="multipart/form-data">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                          <label>Branch Type</label>
                           <select name="branch_type" id="branch_type" class="form-control" data-rule-required="true" >
                           <option value="">Please select</option>
                           <?php foreach ($station_type as $key => $station) { ?>
                             <option value="<?php echo $station['id'];?>"><?php echo $station['type_name'];?></option>
                           <?php } ?>
                         </select>

                        </div>

                       <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                          <label>Branch</label>
                          <input type="text" placeholder="Name" name="name" class="form-control" data-rule-required="true">
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                          <label>Mobile</label>
                          <input type="text" placeholder="Mobile Number"  name="mobile" class="form-control mobile" data-rule-required="true"  onKeyPress="return isNumberKey(event)">
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                          <label>Email</label>
                          <input type="email" placeholder="Email" name="email" class="form-control " data-rule-required="true">
                        </div>
                    </div>
                     <div class="row ">
                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                          <label>Address</label>
                          <textarea placeholder="Address" name="address" class="form-control" data-rule-required="true" ></textarea>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12 form-group slctdt ">
                          <label>Country</label>
                         <select name="country" id="country" class="form-control" data-rule-required="true">
                          <option value="">Please select</option>
                         
                           <?php foreach ($countries as $key => $county) { ?>
                             <option value="<?php echo $county['id'];?>"><?php echo $county['name'];?></option>
                           <?php } ?>
                         </select>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 form-group slctdt ">
                          <label>State</label>
                         <select name="state" id="states" class="form-control" data-rule-required="true">

                         </select>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                          <label>City</label>
                         <select name="city" id="city" class="form-control">

                         </select>
                        </div>
                        </div>
                          </div>

                          </div>

                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">

                          <input type="submit" class="btn btn-primary btn_save pull-right" value="Submit">
                        </div>
                      </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--************************row  end******************************************************************* -->
    </div>
  </div>
</div>
</div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">

<?php echo $footer; ?>
<!--<script src="--><?php //echo base_url();?><!--assets/admin/js/jquery.form.js" type="text/javascript"></script>-->
<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet" />\
<script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<script type="text/javascript">


    $(document).ready(function()
    {

        $('#states').SumoSelect();
        $('#city').SumoSelect();
        $('#country').SumoSelect({search:true,placeholder:'select country'});


           var v = jQuery("#branch_form").validate({
        
            submitHandler: function(datas) {
            
                jQuery(datas).ajaxSubmit({
                    
                    dataType : "json",
                    success  :    function(data)
                    {

                        if(data.status)
                {

                    //$('#channel_form').hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added Branch </div></div>';
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
                   $('.body_blur').hide();
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
    $('#branch_form').submit(function(e){     
      e.preventDefault();

      if (v.form()) 
      {
        $('.body_blur').show();
        //$(this).ajaxSubmit(datas);  
      }          
    });





      $('#country').change(function(){
       
        var cur = $(this);
        var country_id = cur.val();
         if (country_id != '') {
          $('#states')[0].sumo.unload();
        $.get('<?= base_url();?>admin/Home/get_states_by_country', {country_id : country_id}, function(data){
          if(data.status){

            var opt = '';
            var data = data.data;
            for (var i = 0; i < data.length; i++) {

              opt += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            }
            //  $('#states')[0].sumo.unload();
            $('#states').html(opt);
            $('#states').SumoSelect({search:true,placeholder:'select state'});
          }
else{
  var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close" style="color:black;font-size:25px"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+'No state found'+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    alert_close();

 var opt = '';
                     $('#states').html(opt);
            $('#states').SumoSelect({search:true,placeholder:'Select State'});
}








        },'json');
      }
      else {
           var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close" style="color:black;font-size:25px"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+'Please select country'+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    alert_close();  
             }
      });
      
      

      $('#states').change(function(){
        var cur = $(this);

        var state_id = cur.val();
        if (state_id != '') {
         $('#city')[0].sumo.unload();
        $.get('<?= base_url();?>admin/Home/get_city_by_state', {state_id : state_id}, function(data){
          if(data.status){
           
            var opt = '';
            var data = data.data;
            for (var i = 0; i < data.length; i++) {
              opt += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
            }
            $('#city').html(opt);
            $('#city').SumoSelect({search:true,placeholder:'Select City'});
          }
else{
  var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+'No city found'+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    alert_close();

 var opt = '';
                     $('#city').html(opt);
            $('#city').SumoSelect({search:true,placeholder:'Select City'});
}



        },'json');
      }
      else {
var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+'Please select state'+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    alert_close();            
                  }
      });

    });
 $(document).on('keypress',".mobile",function (e) {
     //if  theletter is not digit then display error and don't type anything
     if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
        //display error message
     //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
               return false;
    }
   });
$(document).ready(function () {
  //called when key is pressed in textbox
 
});
</script>
</body>
</html>