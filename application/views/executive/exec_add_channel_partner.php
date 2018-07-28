  <?php echo $header; ?>
    <?php echo $map['js']; ?>
  <script type="text/javascript">
    function getPosition(newLat, newLng)
    {
      $('#lat').val(newLat);
      $('#long').val(newLng);
    }
  </script>
  <style type="text/css">
      .subc{margin-left: 31px;}

.manerr .error
{
    position: absolute;
    top: 37px;
    left: 0;
}

.manerr2 .error
{
    position: absolute;
    top: 42px;
    left: 0;
        text-transform: capitalize;
}

form.cmxform label.error, label.error {
    color: red;
    /* font-style: italic; */
    position: absolute;
    bottom: -15px;
}
  </style>
<body>
<div class="wrapper">

   <?php echo $sidebar; ?>

    <div class="content">
        <div class="container-fluid">


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-text" data-background-color="orange">
                        <h4 class="card-title"> Add Channel Partner </h4>

                    </div>
                    <div class="card-content">

                        <form method="post" name="channel_form" id="channel_form" action="<?php echo base_url();?>admin/executives/new_channel_partner" enctype="multipart/form-data">

                            <div class="col-md-12 col-sm-6">
                                <div class="col-md-12 ">
                                <!--<div class="form-group label-floating is-empty">-->
                                
                                
                                <div class="form-group">
                                    
                                    
                                
                                <!--     <label class="control-label">Module</label> -->
                                
                                
                                <label class="">Club Member </label>  <label style="color:red;">(Mandatory)</label>
                                
                                

                                   <select name="club_member" class="form-control search-box-open-up search-box club_member" id="club_member" data-rule-required="true">
                                         <option value="">Please Select Club Member</option>
                                            <?php foreach ($member['member'] as $type) { ?>
                                            <option value="<?php echo $type['m_id'];?>"><?php echo $type['name'];?></option>
                                            <?php } ?>
                                            </select>  

                                    <!-- </select> -->

                                </div></div>

                            <div class="channel" >
                            <div class="col-md-4">
                                
                                <div class="form-group">
                                    
                                    
                                    
                                    <!--<label class="control-label">Club Type</label>--> 
                                    
                                    <label class="">Club Type </label>   <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                    
                                    
                                  <select name="club_type" class="form-control club_type" id="club_type" data-rule-required="true">
                                  <option value="">Please Select Club Type</option>
                                 <!--  <option value="UNLIMITED">Unlimited</option> -->
                                <!--   <?php if($session_array2['fixed_club_type_id']){?>
                                  <option value="FIXED">Fixed</option>
                                  <?php } ?> -->

                                  </select>
                                </div>
                              </div>





                            <div class="col-md-4 col-sm-6">
                                <!--<div class="form-group label-floating is-empty">-->
                                
                                
                                <div class="form-group">
                                
                                
                                <!--     <label class="control-label">Module</label> -->
                                
                                
                                <label class="">Module </label>  <label style="color:red;">(Mandatory)</label>
                                
                                
                                
                        <select name="module" class="form-control module" id="
                        modu" data-rule-required="true">
                                         <option value="">Please Select Module</option>
                                            <?php foreach ($modules['type'] as $type) { ?>
                                            <option value="<?php echo $type['id'];?>"><?php echo $type['module_name'];?></option>
                                            <?php } ?>
                                            </select>          
                                    <!-- </select> -->

                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 col-xs-12 form-group manerr">
                                         <!--   <label class="control-label">&nbsp;</label> 
 -->
 
 
                                    <label class="">Channel Partner Type </label>  <label style="color:red;">(Mandatory)</label>
 
 
 
                                            <select id="channel_type" data-rule-required="true" class="testSelAll form-control  search-box-open-up search-box-sel-all channel_type" name="channel_type[]" multiple="multiple" onchange="console.log($(this).children
                                    (':selected')
                                    .length)">
                                    <optionb value="">Select Channel Partner Type</option>

                                            <?php foreach($category['type'] as $type){ ?>
                                            <optgroup label="<?php echo $type['title'];?>">
                                          
                                            
                                            <?php $pid=$type['id']; foreach($subcategory['type'] as $stype){ if($stype['parent']==$pid){ ?>

                                            <option class="subc" value="<?php echo $stype['id'];?>"><?php echo $stype['title'];?></option>
                                            
                                            <?php } ?>
                                            </optgroup>
                                            <?php } } ?>
                                            </select>
                                        </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group ">
                                    
                                    <label class="">Name </label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    <input type="text" placeholder="Name" name="name" class="form-control" data-rule-required="true">
                                    <span class="material-input"></span><span class="material-input"></span></div>
 
                            </div>
                            <div class="col-md-4 col-sm-6">
                                
                                <!--<div class="form-group label-floating is-empty">-->
                                
                                <div class="form-group">
                                    
                                    <label class="">Email </label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                    <input type="text" placeholder="Company Email (Username)" name="email" id="email" class="form-control" data-rule-required="true">
                                    <span class="material-input"></span><span class="material-input" data-rule-required="true"></span>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    
                                    <label class="">Contact Number</label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                    <input type="number" placeholder="Contact Number" name="phone" id="phone" class="form-control" data-rule-required="true">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>

                         
                            


                            <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    
                                    <label class="">Owner Name</label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                    <input type="text" placeholder="Owner Name"  name="ocname" class="form-control" data-rule-required="true">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>
                                <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    
                                    <label class="">Owner Email</label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                    <input type="text" placeholder="Owner Email" name="oc_email" class="form-control" data-rule-required="true">
                                    <span class="material-input"></span><span class="material-input" ></span>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6 col-xs-12 ">
                             <div class="form-group">
                                 
                                    <label  class="">Owner Number</label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                            <input type="number" placeholder="Owner Number" name="oc_mobile" class="form-control" data-rule-required="true">
                                            <span class="material-input"></span><span class="material-input" data-rule-required="true"></span>
                                        </div>
                                        </div>

                            <div class="col-md-4 col-sm-6 manerr">
                                <div class="form-group">
                                  <!--   <label >Country</label> -->
                                  
                                  <label  class="">Country </label>  <label style="color:red;">(Mandatory)</label>
                                  
                                    <select name="country" class="form-control search-box-open-up search-box-sel-all" id="sel_country" data-rule-required="true">
                                      <option value="">Please Select Country</option>
                                        <?php foreach ($countries as $key => $country) { ?>
                                            <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                                            <?php } ?>
                                            </select>
                                </div>
                            </div>





                            <div class="col-md-4 col-sm-6 manerr">
                                <div class="form-group">
                                    
                                     <label  class="">State </label>  <label style="color:red;">(Mandatory)</label>
                                     
                                            <select name="state" id="states" class="form-control" data-rule-required="true">
                                             <option value="">Please Select </option>
                                            </select>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6 manerr">
                                <!--<div class="form-group label-floating is-empty">-->
                               
                               <div class="form-group">
                                   
                               
                               <label  class="">City </label>  <label style="color:red;">(Mandatory)</label>
                               
                                            <select name="town" id="city" class="form-control" data-rule-required="true">
                                             <option value="">Please Select</option>
                                            </select>
                                    <!-- <span class="material-input"></span><span class="material-input"></span> -->
                                </div>
                            </div>
                            
                            
                            
                            
                            
                            
                            
                            
                            <div class="col-md-4 col-sm-6">
                                <!--<div class="form-group label-floating is-empty">-->
                                
                                <div class="form-group">
                                
                                
                                    <label class="">Area </label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    <input type="text" placeholder="Area" name="area" class="form-control" data-rule-required="true">
                                    <span class="material-input"></span><span class="material-input"></span></div>
 
                            </div>
                            
                            
                            
                            
                            
                            
                            


                            </div></div>
                            <div class="col-md-4 col-sm-6">
                                <!--<div class="form-group label-floating is-empty">-->
                                <div class="form-group">
                                
                                    <label class="">PAN Number </label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                    <input type="text" placeholder="PAN Number" name="pan" class="form-control" data-rule-required="true" id="pan">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>
                                <div class="col-md-4 col-sm-6">
                                <div class="form-group">
                                    
                                    <label class="">GST Number </label>  
                                    
                                    
                                    <input type="text" placeholder="GST Number" name="gst" class="form-control" id="gst">
                                    <span class="material-input"></span><span class="material-input" ></span>
                                </div>
                            </div>
                            <div style="padding-top: 30px;" class="col-md-4 col-sm-6 manerr2">

                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                                    <span class="btn btn-rose btn-round btn-file crsor" style="overflow: visible;">
                                                        <span class="fileinput-new crsor">Company Registration Document</span>
                                                    <span class="fileinput-exists">Change</span>
<!--  <input type="file" class="crsor" name=""> -->
                                                    <input type="file" name="company_registration" id="company_registration" class="crsor"  >
                                                    </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    </div>
                                </div>
                            </div>
                         

                            <div class="col-md-4 col-sm-6 manerr2">

                                <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                    <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                    <div>
                                                    <span class="btn btn-rose btn-round btn-file crsor" style="overflow: visible;">
                                                        <span class="fileinput-new crsor">Corporation/Panchayath/Muncipality License</span>
                                                    <span class="fileinput-exists">Change</span>
                                                    <input type="file" name="license"  class="crsor">
                                                    </span>
                                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                    </div>
                                </div>
                            </div>
                            
                            
                            
                            
<div class="col-md-12 col-sm-12 col-xs-12">
<h4>Map Locator (Please choose channel location)</h4>
</div>
                            
                            
                            
                            
                            
                            
 <div class="col-md-12">
                            <div class="col-md-6 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    
                                    <label >Latitude* </label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                    <input type="text" data-rule-required="true" placeholder="Latitude" id="lat" name="latt" class="form-control ">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    
                                    <label >Longitude* </label>  <label style="color:red;">(Mandatory)</label>
                                    
                                    
                                     <input type="text" data-rule-required="true" placeholder="Longitude" id="long" name="long" class="form-control ">
                                    <span class="material-input"></span><span class="material-input"></span>
                                </div>
                            </div>

                            <div class="col-md-12" style="margin-top: 40px">
                               <?php echo $map['html']; ?>
                                </div>


                            <div class="col-md-12">
                                <input type="submit" class="btn btn-fill btn-rose" value="Submit">

                            </div>
                        </form>
                    </div>
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

 var v = jQuery("#channel_form").validate({

    submitHandler: function(datas) {
    
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {

                if(data.status)
                {

                    //$('#channel_form').hide();
                    $('.body_blur').hide();
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
                   $('.body_blur').hide();
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
       $('#clubmember_form').submit(function(e){     
      e.preventDefault();

    
      if (v.form()) 
      {
     
        $('.body_blur').show();
        //$(this).ajaxSubmit(datas);  
      }          
    });
}); 
</script> 
<script type="text/javascript">
        $('#states').SumoSelect();
        $('#city').SumoSelect();
        $('#sel_country').SumoSelect({search: true, placeholder: 'select country'});
        $('#sel_country').change(function () {

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
    

</script>
    <script type="text/javascript">
        $(document).ready(function(){
            


        $('#email').focusout(function(){
            var mail = $(this).val();
            var cur = $(this);
            $.post('<?php echo base_url();?>admin/Executives/mail_exists/',{mail :mail},
                   function(data)
                    {
                        if(data.status)
                        {
                            // noty({text:"Mailid Already Exists",type: 'error',layout: 'top', timeout: 3000});
                            
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Mailid Already Exists</div></div>';
                            var effect='fadeInRight';
                            $("#notifications").append(center);
                            $('#email').val('');
                            $("#notifications-full").addClass('animated ' + effect);
                            $('.close').click(function(){
                                $(this).parent().fadeOut(1000);
                            });
//                                    cur.next().text("Mailid Already Exists").css('color', 'red');
                            $("#channelsubmit").hide();
                        }else{
                            cur.next().remove();
                            $("#channelsubmit").show();
                        }
                    },'json');
         });
        $('#phone').focusout(function(){
            var mob = $(this).val();
            var cur = $(this);
            $.post('<?php echo base_url();?>admin/channel_partner/mobile_exists/',{mob :mob},
                    function(data)
                    {
                        if(data.status)
                        {
                            noty({text:"Mobile Number Already Exists",type: 'error',layout: 'top', timeout: 3000});
//                                    cur.next().text("Mailid Already Exists").css('color', 'red');
                            $("#channelsubmit").hide();
                        }else{
                            cur.next().remove();
                            $("#channelsubmit").show();
                        }
                    },'json');
        });
     });
    </script>
    <script>
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
    $(document).on('change', '.club_member',function(){
        var cur = $(this); 
        var club_member= cur.val();
        // $.post('<?php echo base_url();?>admin/executives/get_count_by_id/'+club_member, function(data){
        //    var data1 = data.data;
        //    console.log(data1);
            /*if(data1['cp_limit']>data1['cp_count']){

              $(".channel").show();
            }
            else{
               $(".channel").hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Sorry!!...Channel Partner Limit Crossed </div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        //$('#channel_form').hide();
                        location.reload();
                    }, 1000);
            }*/
         
        // },'json');

        $.post('<?php echo base_url();?>admin/executives/check_cp_limit_exceed/'+club_member, function(data){
            $('.body_blur').show();
            if(data.status){
                $.post('<?php echo base_url();?>admin/executives/get_club_details_id/'+club_member, function(data){
                    $('.body_blur').hide();
               
                    if(data.status)
                    {
                        var data = data.data;
                        var unlimited = data.club_type_id;
                        //console.log(data);
                        if(data.ty1 == null){
                            var ty2=data.ty1;
                            var option ='';
                            option += '<option value="">Please Select</option>';
                            option += '<option value="'+data.ty+'">'+data.ty+'</option>';
                        }else if(data.ty == null){
                            var option ='';
                            option += '<option value="">Please Select</option>';
                            option += '<option value="'+data.ty1+'">'+data.ty1+'</option>';
                        }else{
                            var option ='';
                            option += '<option value="">Please Select</option>';
                            option += '<option value="'+data.ty+'">'+data.ty+'</option>';
                            option += '<option value="'+data.ty1+'">'+data.ty1+'</option>';
                        }
                        $('.club_type').html(option);
                       
                        
                    }else{
                        var regex = /(<([^>]+)>)/ig;
                        var body = data.reason;
                        var res = body.replace(regex, "");
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+res+'</div></div>';
                        var effect='zoomIn';
                        $("#notifications").append(center);
                        $("#notifications-full").addClass('animated ' + effect);
                        refresh_close();
                    }
                },'json');
            }else{
                $('.body_blur').hide();
                var regex = /(<([^>]+)>)/ig;
                var body = data.reason;
                var res = body.replace(regex, "");
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+res+'</div></div>';
                var effect='zoomIn';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
                setTimeout(function(){
                    location.reload();
                }, 1000);
            }
             
        },'json');
    });   
    $(document).on('change', '.club_type',function(){
        var cur = $(this); 
        var club_type= cur.val();
        var club_member = $('.club_member').val();
        if(club_type!=''){
            $('.body_blur').show();
            $.post('<?php echo base_url();?>admin/executives/check_cp_limit_status',{club_member:club_member,club_type:club_type}, function(data){
                console.log(data);$('.body_blur').hide();
                if(data.status){

                }else{
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var res = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+res+'</div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){
                        location.reload();
                    }, 1000);
                }
            },'json');
        }
    });
</script>
</body>

</html>