    <?= $header; ?>
<?php echo $map['js']; ?>
 <script type="text/javascript">
    function getPosition(newLat, newLng)
    {
      $('#lat').val(newLat);
      $('#long').val(newLng);
    }
</script>

<style type="text/css">
    .card-profile, .card-testimonial {
    margin-top: 25px;
    text-align: center;
}
</style>

<body xmlns="http://www.w3.org/1999/html">
<div class="wrapper">

    <?= $sidebar; ?>

    <div class="content">

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header card-header-icon" data-background-color="orange">
                            <i class="material-icons">perm_identity</i>
                        </div>
                        <div class="card-content">
                            <h4 class="card-title"><?= $profile->name; ?></h4>
                           <form method="post" name="channel_form" id="channel_form" action="<?php echo base_url();?>admin/channel_partner/update_profile">
                                <div class="row">

                                    <div class="col-sm-6">
                                        <div class="form-group label-floating is-empty">



                                            <label>Name</label>  <label style="color:red;">(Mandatory)</label>



                                            <input type="hidden" name="hiddenid" class="form-control" value="<?= $profile->id; ?>">
                                            <input type="text" name="name" class="form-control" value="<?= $profile->name; ?>" data-rule-required="true">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group label-floating is-empty">



                                            <label>Contact Number</label> <label style="color:red;">(Mandatory)</label>




                                            <input type="text" class="form-control" value="<?= $profile->phone; ?>" name="phone" data-rule-required="true">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group label-floating is-empty">
                                            <label>Alternative Contact Number</label>
                                            <input type="text" class="form-control" value="<?= $profile->phone2; ?>" name="phone2">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group label-floating is-empty">



                                            <label>Email</label>  <label style="color:red;">(Mandatory)</label>



                                            <input type="email" class="form-control" value="<?= $profile->email; ?>" readonly name="email" data-rule-required="true">
                                            <span class="material-input"></span></div>
                                    </div>

                                </div>
                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">



                                            <label>Contact Person</label> <label style="color:red;">(Mandatory)</label>


                                            <input type="text" class="form-control" value="<?= $profile->cname; ?>" name="cname" data-rule-required="true">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">


                                            <label>Contact Email</label> <label style="color:red;">(Mandatory)</label>



                                            <input type="text" class="form-control" value="<?= $profile->c_email; ?>" name="c_email" data-rule-required="true">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">



                                            <label>Contact Mobile</label> <label style="color:red;">(Mandatory)</label>



                                            <input type="text" class="form-control" value="<?= $profile->c_mobile; ?>" name="c_mobile" data-rule-required="true">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label>Alternative Contact Person</label>
                                            <input type="text" class="form-control" value="<?= $profile->alt_c_name; ?>" name="acname">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label>Alternative Contact Email</label>
                                            <input type="text" class="form-control" value="<?= $profile->alt_c_email; ?>" name="ac_email">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label>Alternative Contact Mobile</label>
                                            <input type="text" class="form-control" value="<?= $profile->alt_c_mobile; ?>" name="ac_mobile">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">



                                            <label>Owner</label> <label style="color:red;">(Mandatory)</label>



                                            <input type="text" class="form-control" value="<?= $profile->owner_name; ?>" name="ocname" >
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">



                                            <label>Owner Email</label> <label style="color:red;">(Mandatory)</label>



                                            <input type="text" class="form-control" value="<?= $profile->owner_email; ?>" name="oc_email">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">



                                            <label>Owner Mobile</label> <label style="color:red;">(Mandatory)</label>



                                            <input type="text" class="form-control" value="<?= $profile->owner_mobile; ?>" name="oc_mobile">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label>Bank Name</label>
                                            <input type="text" class="form-control" value="<?= $profile->bank_name; ?>" name="bank_name">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label>Account Number</label>
                                            <input type="text" class="form-control" value="<?= $profile->account_no; ?>" name="ac_number">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label>Account Holder Name</label>
                                            <input type="text" class="form-control" value="<?= $profile->account_holder_name; ?>" name="ac_holder_name">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label>IFSC Number</label>
                                            <input type="text" class="form-control" value="<?= $profile->ifsc; ?>" name="ifsc">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">



                                        <label>PAN Number</label> <label style="color:red;">(Mandatory)</label>



                                            <input type="text" class="form-control" value="<?= $profile->pan; ?>" name="pan">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label>GST Number</label>
                                            <input type="text" class="form-control" value="<?= $profile->gst; ?>" name="gst">
                                            <span class="material-input"></span></div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">



                                            <label>Country</label> <label style="color:red;">(Mandatory)</label>



                                            <select class="form-control" name="country" id="sel_country" data-rule-required="true">
                                               <?php foreach ($countries as $key => $country) { ?>
                                                <option <?= $profile->country == $country['id'] ? "selected" : "" ; ?> value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">



                                            <label>State</label> <label style="color:red;">(Mandatory)</label>



                                <select name="state" class="form-control sel_state" id="sel_state" data-rule-required="true">
                                             <option value="">Please Select</option>
                                             <?php foreach ($states as $st) { ?>
                                              <option <?= $profile->state == $st['id'] ? "selected" : "" ; ?> value="<?php echo $st['id'];?>"><?php echo $st['name'];?></option>
                                            <?php } ?>                                       
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">




                                            <label>Town</label> <label style="color:red;">(Mandatory)</label>




                                            <!-- <input type="text" class="form-control" value="<?= $profile->town; ?>" name="town" data-rule-required="true"> -->
                                            <select name="town" class="form-control town" id="town" data-rule-required="true">
                                             <option value="">Please Select</option>
                                             <?php foreach ($cities as $ct) { ?>
                                              <option <?= $profile->town == $ct['id'] ? "selected" : "" ; ?> value="<?php echo $ct['id'];?>"><?php echo $ct['name'];?></option>
                                            <?php } ?>                                       
                                            </select>
                                            <span class="material-input"></span></div>
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                       <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">



                                            <label>Area</label> <label style="color:red;">(Mandatory)</label>



                                            <input type="text" class="form-control" value="<?= $profile->area; ?>" name="area" >
                                            <span class="material-input"></span></div>
                                    </div>
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                    
                                </div>
                                
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group">



                                            <label>Address</label> <label style="color:red;">(Mandatory)</label>



                                            <div class="form-group label-floating is-empty">
                                                <label class="control-label"> </label>
                                                <textarea class="form-control" rows="4" name="address" data-rule-required="true"><?= $profile->address; ?></textarea>
                                                <span class="material-input"></span></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        
                                        
                                        
                                         <?php
              
                        if($profile->profile_image){
                    ?> 
                                        
                                        
                                        
                                        
                                        <div id="imagePreview" style="overflow:hidden;">
                                          <img src="<?php echo base_url().$profile->profile_image; ?>" style="max-width:100%;height:160px;" name="">
                                        </div>
                                        
                                        <?php } ?>
                                        
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                            <div class="fileinput-preview fileinput-exists thumbnail">
                    
                                            </div>
                                            <div>
                                                <span class="btn btn-rose btn-round btn-file crsor">
                                                    <span class="fileinput-new crsor">Profile image</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" class="crsor" name="pro">
                                                </span>
                                                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        
                                            <?php
              
                        if($profile->brand_image){
                    ?>
                                        
                                        
                                        
                                    <div id="imagePreview" style="overflow:hidden;">
                                      <img src="<?php echo base_url().$profile->brand_image; ?>" style="max-width:100%;height:160px;">
                                    </div>
                                    
                                    <?php } ?>
                                    
                                    
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                        <div class="fileinput-preview fileinput-exists thumbnail">
                
                                        </div>
                                        <div>
                                            <span class="btn btn-rose btn-round btn-file crsor">
                                                <span class="fileinput-new crsor">Brand image</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" class="crsor" name="bri">
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6 col-sm-6">
                                        
                                          <?php
              
                        if($profile->company_registration){
                    ?>
                                        
                                        
                                        <div id="imagePreview" style="overflow:hidden;">
                                          <img src="<?php echo base_url().$profile->company_registration; ?>" style="max-width:100%;height:160px;" name="">
                                        </div>
                                        
                                        <?php } ?>
                                        
                                        
                                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                            <div class="fileinput-preview fileinput-exists thumbnail">
                    
                                            </div>
                                            <div>
                                                <span class="btn btn-rose btn-round btn-file crsor">
                                                    <span class="fileinput-new crsor">Company Registration Document</span>
                                                <span class="fileinput-exists">Change</span>
                                                <input type="file" class="crsor" name="company_registration">
                                                </span>
                                                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-sm-6">
                                        
                                         <?php
              
                        if($profile->license){
                    ?> 
                                        
                                        
                                    <div id="imagePreview" style="overflow:hidden;">
                                      <img src="<?php echo base_url().$profile->license; ?>" style="max-width:100%;height:160px;">
                                    </div>
                                    
                                    <?php } ?>
                                    
                                    
                                    
                                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">

                                        <div class="fileinput-preview fileinput-exists thumbnail">
                
                                        </div>
                                        <div>
                                            <span class="btn btn-rose btn-round btn-file crsor">
                                                <span class="fileinput-new crsor">Corporation/Panchayath/Muncipality License</span>
                                            <span class="fileinput-exists">Change</span>
                                            <input type="file" class="crsor" name="license">
                                            </span>
                                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                                        </div>
                                    </div>
                                </div>
                                </div>
                                
                                
                                
                                 <div class="row">
                                    
                                    <div class="col-md-12 col-sm-12 col-xs-12">
<h2><small>Map Locator (Please choose channel location) </small></h2>
</div>
                                    
                                    
                                    <div class="col-sm-6">
                                        <div class="form-group label-floating is-empty">



                                            <label>Latitude </label> <label style="color:red;">(Mandatory)</label>



                                            <input type="text" class="form-control" value="<?= $profile->lattitude; ?>" name="latt" data-rule-required="true" id="lat">
                                            <span class="material-input"></span></div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group label-floating is-empty">



                                         <label>Longitude </label> <label style="color:red;">(Mandatory)</label>




                                            <input type="text" class="form-control" value="<?= $profile->longitude; ?>" name="long" data-rule-required="true" id="long">
                                            <span class="material-input"></span></div>
                                    </div>
                                   
                                </div>
                                <div class="row">

                                    <div class="col-sm-12">
                                        <?php echo $map['html']; ?>
                                    </div>
                                    
                                </div>
                                <input type="submit" class="btn btn-primary channelsubmit" name="channelsubmit" id="channelsubmit" value="Update Profile">
                                <!-- <button type="submit" class="btn btn-rose pull-right">Update Profile</button> -->
                                <div class="clearfix"></div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-profile">
                        <div class="card-avatar">
                            <a href="#pablo">
                            <?php
                             if(empty($profile->profile_image)){
                                $img = "assets/img/default-avatar.png";
                               
                             }else{
                                 $img = $profile->profile_image;
                             } 
                            ?>
                                <img class="img" src="<?php echo base_url().$img ?>">
                            </a>
                        </div>
                        <div class="card-content">
                            <h4 class="category"> <?= $profile->name; ?> </h4>
                            <h6 class=""><?= $profile->phone; ?></h6>

                            <h6 class=""><?= $profile->email; ?></h6>

                            <p class="description">
                              <?= $profile->address; ?><br>
                              <?= $profile->city1; ?>, <?= $profile->state1; ?>
                              <br>
                              <?= $profile->country1; ?><br>

                            </p>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div id="notifications"></div><input type="hidden" id="position" value="center">
        <?= $footer; ?>
        <link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
        <script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>
        <script type="text/javascript">
        $(document).on('change', '#sel_country',function(){
          var cur = $(this); 
          var country = cur.val();
          $('.body_blur').show();
          $('#sel_state')[0].sumo.unload();
          $.post('<?php echo base_url();?>admin/channel_partner/get_state_by_id/'+country, function(data){
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
              noty({text: data.reason, type:error, timeout:1000});
            }
            $('#sel_state').SumoSelect({search: true, placeholder: 'select state'});
          },'json');
        });
        $(document).on('change', '#sel_state',function(){
        var cur = $(this);
        var state = cur.val();
        $('.body_blur').show();
        $('#town')[0].sumo.unload();
        $.post('<?php echo base_url();?>admin/channel_partner/get_town_by_id/'+state, function(data){
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
            $('#town').SumoSelect({search: true, placeholder: 'select state'});
        },'json');
    });
    </script>
    <script type="text/javascript">
    $(document).ready(function () {
       
      
        $('#sel_country').SumoSelect({search: true, placeholder: 'select country'});
        $('#sel_state').SumoSelect({search: true, placeholder: 'select state'});
        $('#town').SumoSelect({search: true, placeholder: 'select state'});
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
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
                           
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully updated profile</div></div>';
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

</body>

</html>