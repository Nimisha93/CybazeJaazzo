<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/sumo-select/sumoselect.css" rel="stylesheet" />
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
</style>
<?php echo $map['js']; ?>
<script type="text/javascript">
    function getPosition(newLat, newLng)
    {
        $('#lat').val(newLat);
        $('#long').val(newLng);
    }
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57 ))
            return false;
        return true;
    }
</script>

</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
<div class="">


<div class="clearfix"></div>
<div class="row">
<form method="post" name="channel_form" id="channel_form" action="<?php echo base_url();?>admin/Home/add_partner" enctype="multipart/form-data">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
    <h2>Channel Details<small></small></h2>
    <ul class="nav navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
    </ul>
    <div class="clearfix"></div>
</div>


<div class="x_content">
<div class="">
<div class="">

<div class="col-md-12">
<div class="col-md-4 col-sm-6 col-xs-12 form-group">
    <label>Channel Name </label> <label style="color:red;">(Mandatory)</label>
    <input type="text" placeholder="Name of the Organization (Company/Institution/Shop)" name="name" class="form-control" data-rule-required="true">
</div>
<div class="col-md-4 col-sm-6 col-xs-12 form-group">
    <label>Service </label>  <label style="color:red;">(Mandatory)</label>
    <select name="module" class="form-control search-box-open-up search-box" id="module" data-rule-required="true">
        <option value="">Please Select</option>
        <?php foreach ($modules['type'] as $type) { ?>
        <option value="<?php echo $type['id'];?>"><?php echo $type['module_name'];?></option>
        <?php } ?>
    </select>
</div>

<div class="col-md-4 col-sm-6 col-xs-12 form-group">
    <label>Channel Partner Type </label>  <label style="color:red;">(Mandatory)</label>
    <select id="channel_type" class="form-control search-box-open-up search-box-sel-all channel_type" name="channel_type[]" multiple="multiple" onchange="console.log($(this).val())" data-rule-required="true">
        <?php foreach($category['type'] as $type){ ?>
                                            
                                           
                                            <optgroup label="<?php echo $type['title'];?>">
                                            <?php $pid=$type['id']; foreach($subcategory['type'] as $stype){ if($stype['parent']==$pid){ ?>

            <option class="subc" value="<?php echo $stype['id'];?>"><?php echo $stype['title'];?></option>

            <?php } ?> </optgroup> <?php } } ?>
    </select>
</div>

<div class="col-md-4 col-sm-6 col-xs-12 form-group">
    <label>Email </label>  <label style="color:red;">(Mandatory)</label>
    <input type="email" name="email" class="form-control email" id="email" data-rule-required="true" data-rule-email="true" placeholder="Email Id (Username)">
</div>
<div class="col-md-4 col-sm-6 col-xs-12 form-group">
    <label>Contact Number </label>  <label style="color:red;">(Mandatory)</label>
    <input type="number"  onKeyPress="return isNumberKey(event)" placeholder="Phone" name="phone" id="phone" class="form-control" data-rule-required="true" data-rule-number="true">
</div>


</div>
</div>
</div>
</div>
</div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
    <h2>Contact Details<small></small></h2>
    <ul class="nav navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
    </ul>
    <div class="clearfix"></div>
</div>

<div class="col-md-4 col-sm-6 col-xs-12 form-group">
    <label>Owner Contact Person </label>  <label style="color:red;">(Mandatory)</label>
    <input type="text" placeholder="Contact Person" name="ocname" class="form-control" data-rule-required="true">
</div>
<div class="col-md-4 col-sm-6 col-xs-12 form-group">
    <label>Owner Contact Email </label>  <label style="color:red;">(Mandatory)</label>
    <input type="text" name="oc_email" class="form-control oc_email" id="oc_email" data-rule-required="true" data-rule-email="true" placeholder="Contact Email">
</div>

<div class="col-md-4 col-sm-6 col-xs-12 form-group">
    <label>Owner Contact Mobile </label>  <label style="color:red;">(Mandatory)</label>
    <input type="number"  onKeyPress="return isNumberKey(event)" name="oc_mobile" class="form-control oc_mobile" id="oc_mobile" data-rule-required="true" data-rule-number="true"  placeholder="Contact Mobile">
</div>
<div class="col-md-3 col-sm-6 col-xs-12 form-group">
    <label>Country </label>  <label style="color:red;">(Mandatory)</label>
    <select name="country" class="form-control search-box-open-up search-box-sel-all" id="sel_country" data-rule-required="true">
        <option value="">Please Select</option>
        <?php foreach ($countries as $key => $country) { ?>
        <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
        <?php } ?>
    </select>
</div>
<div class="col-md-3 col-sm-6 col-xs-12 form-group">
    <label>State </label>  <label style="color:red;">(Mandatory)</label>
    <select name="state" class="form-control sel_state select_box_sel" id="sel_state" data-rule-required="true">
        <option value="">Please Select</option>
    </select>
</div>

<div class="col-md-3 col-sm-6 col-xs-12 form-group">
    <label>City </label>  <label style="color:red;">(Mandatory)</label>
    
     <select name="town" class="form-control town" id="town" data-rule-required="true">
        <option value="">Please Select</option>
    </select>
</div>









<div class="col-md-3 col-sm-6 col-xs-12 form-group">
    <label>Area </label>  <label style="color:red;">(Mandatory)</label>
    <input type="text" placeholder="Area" name="area" class="form-control" data-rule-required="true">
</div>





 


<div class="col-md-12 col-sm-12 col-xs-12">
<h2>Map Locator (Please choose channel location) <small></small></h2>
</div>





<div class="col-md-6 col-sm-6 col-xs-12 form-group">
    <label>Latitude* </label>  <label style="color:red;">(Mandatory)</label>
    <input type="text" placeholder="Latitude" id="lat" name="latt" class="form-control" data-rule-required="true">
</div>
<div class="col-md-6 col-sm-6 col-xs-12 form-group">
    <label>Longitude* </label>  <label style="color:red;">(Mandatory)</label>
    <input type="text" placeholder="Longitude" id="long" name="long" class="form-control" data-rule-required="true">
</div>

<div class="col-md-12">
    <?php echo $map['html']; ?>
    <br>
</div>

</div>
</div>
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">
<div class="x_title">
    <h2>Verification Details<small></small></h2>
    <ul class="nav navbar-right panel_toolbox">
        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
    </ul>
    <div class="clearfix"></div>
</div>


<div class="x_content">
<div class="">
<div class="">

<div class="col-md-12">
<div class="col-md-4 col-sm-6 col-xs-12 form-group">
    <label>Pan Number </label>  <label style="color:red;">(Mandatory)</label>
    <input type="text" placeholder="Pan Number of Comapny" name="pan" class="form-control" data-rule-required="true" id="pan" >
</div>

<div class="col-md-4 col-sm-6 col-xs-12 form-group">
    <label>Gst Number</label>
    <input type="text" name="gst" class="form-control" id="gst" placeholder="Gst Number">
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <label>Company Registration Document</label>
    <div class="input-group">
        <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Browse&hellip; <input type="file" name="company_registration" id="company_registration" class="form-control" data-rule-required="true" style="display: none;" multiple >
                    </span>
        </label>
        <input type="text" class="form-control" readonly>
    </div>
</div>



<div class="col-md-4 col-sm-6 col-xs-12">
    <label>Corporation/Panchayath/Muncipality License</label>
    <div class="input-group">
        <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Browse&hellip; <input type="file" name="license" data-rule-required="true" class="form-control" id="license" style="display: none;" multiple>
                    </span>
        </label>
        <input type="text" class="form-control" readonly>
    </div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

<div class="col-md-12 col-sm-12 col-xs-12 form-group">
<input type="submit" class="btn btn-primary channelsubmit" name="channelsubmit" id="channelsubmit" value="Save">
</div>

</form>
<div class="clearfix"></div>

<!--************************row  end******************************************************************* -->



</div>
</div>
</div>
</div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">

<!--************************row  end******************************************************************* -->
</div>
<?php echo $footer; ?>
<script type="text/javascript">
    $(document).ready(function () {
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

                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added channel partner </div></div>';
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
                            //$.toast(data.reason, {'width': 500});
                            // return false;
                        }
                    }
                });
            }
        });
    });
    //pan validation
    $('#pan').change(function (event) {     
     var regExp = /[A-Z]{5}\d{4}[A-Z]{1}/; 
     var txtpan = $(this).val(); 
     if (txtpan.length == 10 ) { 
      if( txtpan.match(regExp) ){ 
      
      }
      else {
       
        var regex = /(<([^>]+)>)/ig;
        var body = "Not a valid PAN number";
        var result = body.replace(regex, "");
        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
        var effect='fadeInRight';
        $("#notifications").append(center);
        $("#notifications-full").addClass('animated ' + effect);
        $('.close').click(function(){
            $(this).parent().fadeOut(1000);
        });
        $('#pan').val('');
       event.preventDefault(); 
      } 
     } 
     else { 
           
            var regex = /(<([^>]+)>)/ig;
            var body = "Please enter 10 digits for a valid PAN number";
            var result = body.replace(regex, "");
            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
            var effect='fadeInRight';
            $("#notifications").append(center);
            $("#notifications-full").addClass('animated ' + effect);
            $('.close').click(function(){
                $(this).parent().fadeOut(1000);
            });

           event.preventDefault(); 
     } 

    });
    //end of pan validation
    //gst validation
      $(document).on('change',"#gst", function(){    
        var inputvalues = $(this).val();
        var gstinformat = new RegExp('^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$');

        if (gstinformat.test(inputvalues)) {
         return true;
        } else {
            var regex = /(<([^>]+)>)/ig;
            var body = "Please Enter Valid GST Number";
            var result = body.replace(regex, "");
            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
            var effect='fadeInRight';
            $("#notifications").append(center);
            $("#notifications-full").addClass('animated ' + effect);
            $('.close').click(function(){
                $(this).parent().fadeOut(1000);
            });
            $("#gst").val('');
            $("#gst").focus();
        }

     });
    // end of gst validation
</script>
<script type="text/javascript">
    $(document).on('change', '#sel_country',function(){
        var cur = $(this);
        var country = cur.val();
        if(country!=''){
            $('#sel_state')[0].sumo.unload();
            $('.body_blur').show();
            $.post('<?php echo base_url();?>admin/Home/get_state_by_id/'+country, function(data){
                $('.body_blur').hide();
                if(data.status)
                {
                    var data = data.data;
                    var option ='';
                    option += '<option value="">Please Select</option>';
                    for(var i=0; i<data.length; i++){
                        option += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
                    }
                    $('.sel_state').html(option);
                } else{
                    
                }
                $('#sel_state').SumoSelect({search: true, placeholder: 'select state'});
                var count1 = $('#town option').length;
                for(var j = 0; j < count1; j++) {
                    $('#town')[0].sumo.remove(0);    
                }
                $('#town').html('<option value="">Please Select</option>');
                $('#town').SumoSelect({search: true, placeholder: 'select city'});
            },'json');
        }else{
            var count = $('#sel_state option').length;
            for(var i = 0; i < count; i++) {
                $('#sel_state')[0].sumo.remove(0);    
            }
            $('#sel_state').html('<option value="">Please Select</option>');
            $('#sel_state').SumoSelect({search: true, placeholder: 'select city'});

            var count1 = $('#town option').length;
            for(var j = 0; j < count1; j++) {
                $('#town')[0].sumo.remove(0);    
            }
            $('#town').html('<option value="">Please Select</option>');
            $('#town').SumoSelect({search: true, placeholder: 'select city'});
        }
    });
    $(document).on('change', '#sel_state',function(){
        var cur = $(this);
        var state = cur.val();
        if(state!=''){
            $('.body_blur').show();
            $('#town')[0].sumo.unload();
            $.post('<?php echo base_url();?>admin/Home/get_town_by_id/'+state, function(data){
                console.log(data);
                $('.body_blur').hide();
                if(data.status)
                {
                    var data = data.data;
                    var option ='';
                    option += '<option value="">Please Select</option>';
                    for(var i=0; i<data.length; i++){
                        option += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
                    }
                    $('.town').html(option);
                } else{
                    
                }
                $('#town').SumoSelect({search: true, placeholder: 'select city'});
            },'json');  
        }else{
            var count1 = $('#town option').length;
            for(var j = 0; j < count1; j++) {
                $('#town')[0].sumo.remove(0);    
            }
            $('#town').html('<option value="">Please Select</option>');
            $('#town').SumoSelect({search: true, placeholder: 'select city'});
        }

    });
</script>
<script type="text/javascript">
    $(document).ready(function(){

        $('#email').focusout(function(){
            var mail = $(this).val();
            var cur = $(this);
            $.post('<?php echo base_url();?>admin/Home/mail_exists/',{mail :mail},
                    function(data)
                    {
                        if(data.status)
                        {
                            var regex = /(<([^>]+)>)/ig;
                            var body = "Mail Id Already Exists";
                            var result = body.replace(regex, "");
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                            var effect='fadeInRight';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            $('.close').click(function(){
                                $(this).parent().fadeOut(1000);
                            });

                            cur.val("");

                        }else{

                        }
                    },'json');
        });
        $('#phone').focusout(function(){
            var mob = $(this).val();
            var cur = $(this);
            $.post('<?php echo base_url();?>admin/Home/mobile_exists/',{mob :mob},
                    function(data)
                    {
                        if(data.status)
                        {

                            var regex = /(<([^>]+)>)/ig;
                            var body = "Mobile Number Already Exists";
                            var result = body.replace(regex, "");
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                            var effect='fadeInRight';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            $('.close').click(function(){
                                $(this).parent().fadeOut(1000);
                            });
                            cur.val("");
                        }else{

                        }
                    },'json');
        });
    });
</script>
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>

<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">

<script type="text/javascript">
    $(document).ready(function () {
        //$('.channel_type').SumoSelect({search: true, placeholder: 'select category',okCancelInMulti: true,});
        $('#module').SumoSelect();
        $('.channel_type').SumoSelect({search: true, placeholder: 'select category',okCancelInMulti: true,triggerChangeCombined: false});
        $('#sel_country').SumoSelect({search: true, placeholder: 'select country'});
        $('#sel_state').SumoSelect({search: true, placeholder: 'select state'});
        $('#town').SumoSelect({search: true, placeholder: 'select city'});
    });
</script>


<script src="<?php echo base_url();?>assets/admin/js/file-browse/dropzone-min.js"></script>



<script>
    $(function() {

        $(document).on('change', ':file', function() {
            var input = $(this),
                    numFiles = input.get(0).files ? input.get(0).files.length : 1,
                    label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
            input.trigger('fileselect', [numFiles, label]);
        });

        $(document).ready( function() {
            $(':file').on('fileselect', function(event, numFiles, label) {

                var input = $(this).parents('.input-group').find(':text'),
                        log = numFiles > 1 ? numFiles + ' files selected' : label;

                if( input.length ) {
                    input.val(log);
                } else {
                    if( log ) alert(log);
                }

            });
        });

    });</script>

</body>
</html>