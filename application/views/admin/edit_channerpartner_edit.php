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
    <form method="post" name="channel_form" id="channel_form" action="<?php echo base_url();?>admin/home/edit_partner">
    <div class="row">
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
                        <input type="hidden" name="hiddenid" class="form-control hiddenid"  value="<?php echo $partner['partner']['id'];?>"> 
                         <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Name</label> <label style="color:red;">(Mandatory)</label>
                            <input type="text" placeholder="Name" name="name" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['name'];?>">
                        </div>    
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Module</label> <label style="color:red;">(Mandatory)</label>
                            <select name="module" class="form-control search-box-open-up search-box" id="module" >
                            <option value="">Please Select</option>
                            <?php foreach ($modules['type'] as $type) { ?>
                            <option <?= $partner['partner']['module']==$type['id'] ? "selected" : "" ; ?> value="<?php echo $type['id'];?>"><?php echo $type['module_name'];?></option>
                            <?php } ?>
                            </select>
                        </div>
                   
                       <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Channel Partner Type</label> <label style="color:red;">(Mandatory)</label>
                            <select id="channel_type" class="form-control search-box-open-up search-box-sel-all channel_type" name="channel_type[]" multiple="multiple" onchange="console.log($(this).val())" >
                            <?php 
                             $cat = $partner['grp_sel'];
                            foreach($category['type'] as $type){ ?>
                          
                            <optgroup label="<?php echo $type['title'];?>">
                            <?php $pid=$type['id']; 
                            foreach($subcategory['type'] as $stype){ if($stype['parent']==$pid){
                               $stype_id = $stype['id'];
                                  if(in_array($stype_id, $cat)){
                                     $selcted = 'selected = "selected"';
                                  }else{
                                     $selcted = '';
                                  }
                             ?>

                            <option <?= $selcted; ?> class="subc" value="<?php echo $stype['id'];?>"><?php echo $stype['title'];?></option>
                            
                            <?php } ?> </optgroup> <?php } } ?>
                            </select>
                        </div>
                          
                        
                        <div class="col-md-4 col-sm-6 col-xs-12">
                            <label>Profile Image</label> 
                            
                            
                            
                            
                            <?php
              
                        if($partner['partner']['profile_image']){
                    ?> 

                            
                            
                            
                            
                            
                            
                            <div id="imagePreview" style="overflow:hidden;">
                              <img src="<?php echo base_url().$partner['partner']['profile_image']?>" style="max-width:100%;height:160px;">
                            </div>
                            
                            
                            
                            <?php } ?>
                            
                            
                            
                            <div class="input-group">
                                <label class="input-group-btn">
                                    <span class="btn btn-primary">
                                        Browse&hellip; <input type="file" name="pro" id="pro" class="form-control" style="display: none;" >
                                    </span>
                                </label>
                                <input type="text" class="form-control" readonly>
                            </div>
                          </div>


                                
                         <div class="col-md-4 col-sm-6 col-xs-12">
                           <label>Brand Image</label> 
                           
                           
                           
                           
                           <?php
              
                        if($partner['partner']['brand_image']){
                    ?>
                           
                           
                           
                           
                              <div id="imagePreview" style="overflow:hidden;">
                                <img src="<?php echo base_url().$partner['partner']['brand_image']?>" style="max-width:100%;height:160px;">
                              </div>
                              
                              
                              <?php } ?>
                              
                              
                              
                              
                              <div class="input-group">
                                  <label class="input-group-btn">
                                      <span class="btn btn-primary">
                                          Browse&hellip; <input type="file" name="bri" class="form-control" id="bri" style="display: none;">
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
                                <label>Email(Username)</label> <label style="color:red;">(Mandatory)</label>
                                <input type="email" name="email" class="form-control email" id="email" data-rule-required="true" data-rule-email="true" value="<?php echo $partner['partner']['email'];?>" readonly="">
                            </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Contact Number</label> <label style="color:red;">(Mandatory)</label>
                            <input type="number"  onKeyPress="return isNumberKey(event)" placeholder="Phone" name="phone" id="phone" class="form-control" data-rule-required="true" data-rule-number="true" value="<?php echo $partner['partner']['phone'];?>">
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Alternative Contact Number</label>
                            <input type="number"  onKeyPress="return isNumberKey(event)" placeholder="Phone" name="phone2" class="form-control"  data-rule-number="true" value="<?php echo $partner['partner']['phone2'];?>">
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Contact Person</label>
                            <input type="text" placeholder="Contact Person" name="cname" class="form-control" value="<?php echo $partner['partner']['cname'];?>">
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Contact Email</label>
                            <input type="text" name="c_email" class="form-control c_email" id="c_email"  data-rule-email="true" placeholder="Contact Email"
                            value="<?php echo $partner['partner']['c_email'];?>" >
                        </div>
                        
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Contact Mobile</label>
                            <input type="number"  onKeyPress="return isNumberKey(event)" name="c_mobile" class="form-control c_mobile" id="c_mobile" data-rule-number="true"  placeholder="Contact Mobile"
                            value="<?php echo $partner['partner']['c_mobile'];?>">
                        </div>
                         <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Alternative Contact Person</label>
                            <input type="text" placeholder="Contact Person" name="acname" class="form-control" value="<?php echo $partner['partner']['alt_c_name'];?>">
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Alternative Contact Email</label>
                            <input type="text" name="ac_email" class="form-control ac_email" id="ac_email"  placeholder="Contact Email" value="<?php echo $partner['partner']['alt_c_email'];?>">
                        </div>
                        
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Alternative Contact Mobile</label>
                            <input type="number"  onKeyPress="return isNumberKey(event)" name="ac_mobile" class="form-control ac_mobile" id="ac_mobile"  placeholder="Contact Mobile" value="<?php echo $partner['partner']['alt_c_mobile'];?>">
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Owner Contact Person</label> <label style="color:red;">(Mandatory)</label>
                            <input type="text" placeholder="Contact Person" name="ocname" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['owner_name'];?>">
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Owner Contact Email</label> <label style="color:red;">(Mandatory)</label>
                            <input type="text" name="oc_email" class="form-control oc_email" id="oc_email" data-rule-required="true" data-rule-email="true" placeholder="Contact Email" value="<?php echo $partner['partner']['owner_email'];?>">
                        </div>
                        
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Owner Contact Mobile</label> <label style="color:red;">(Mandatory)</label>
                            <input type="number"  onKeyPress="return isNumberKey(event)" name="oc_mobile" class="form-control oc_mobile" id="oc_mobile" data-rule-required="true" data-rule-number="true"  placeholder="Contact Mobile" value="<?php echo $partner['partner']['owner_mobile'];?>">
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                            <label>Country</label> <label style="color:red;">(Mandatory)</label>
                            <select name="country" class="form-control search-box-open-up search-box-sel-all" id="sel_country" data-rule-required="true">
                            <option value="">Please Select</option>
                            <?php foreach ($countries as $key => $country) { ?>
                            <option <?= $partner['partner']['country'] == $country['id'] ? "selected" : "" ; ?> value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                            <?php } ?>
                            </select>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                            <label>State</label> <label style="color:red;">(Mandatory)</label>
                            <select name="state" class="form-control sel_state select_box_sel" id="sel_state" data-rule-required="true">
                             <option value="">Please Select</option>
                             <?php foreach ($states as $st) { ?>
                            <option <?= $partner['partner']['state'] == $st['id'] ? "selected" : "" ; ?> value="<?php echo $st['id'];?>"><?php echo $st['name'];?></option>
                            <?php } ?>                                       
                            </select>
                        </div>

                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                            <label>City</label> <label style="color:red;">(Mandatory)</label>
                            <select name="town" class="form-control town select_box_sel" id="town" data-rule-required="true">
                             <option value="">Please Select</option>
                             <?php foreach ($cities as $city) { ?>
                            <option <?= $partner['partner']['town'] == $city['id'] ? "selected" : "" ; ?> value="<?php echo $city['id'];?>"><?php echo $city['name'];?></option>
                            <?php } ?>                                       
                            </select>
                           <!--  
                            <input type="text" name="town" class="form-control" id="town" data-rule-required="true" value="<?php echo $partner['partner']['town'];?>"> -->
                        </div>
                        
                        
                        
                        
                        
                        
                        
                              <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                    <label>Area </label> <label style="color:red;">(Mandatory)</label>
                                    <input type="text" placeholder="Area" name="area" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['area'];?>">
                                </div>
                        
                        
                        
                        
                        
                    
                    
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label>Address</label> <label style="color:red;">(Mandatory)</label>
                        <textarea class="form-control" title="Address" name="address" rows="3" placeholder="Address" class="form-control"><?php echo $partner['partner']['address'];?></textarea>
                    </div>
                    
                    
                    
                    
                    
                    
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h4>Map Locator (Please choose channel location)</h4>
                        </div>
                    
                    
                    
                    
                    
                    
                    

                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label>Latitude*</label> <label style="color:red;">(Mandatory)</label>
                        <input type="text" placeholder="Latitude" id="lat" name="latt" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['lattitude'];?>">
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label>Longitude*</label> <label style="color:red;">(Mandatory)</label>
                        <input type="text" placeholder="Longitude" id="long" name="long" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['longitude'];?>">
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
                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                    <label>Pan Number</label> <label style="color:red;">(Mandatory)</label>
                    <input type="text" placeholder="Pan Number of Company" name="pan" class="form-control" data-rule-required="true" id="pan" value="<?php echo $partner['partner']['pan'];?>">
                </div>

                <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                    <label>Gst Number</label>
                    <input type="text" name="gst" class="form-control" id="gst" placeholder="Gst Number" value="<?php echo $partner['partner']['gst'];?>">
                </div>
                
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <label>Company Registration Document</label>
                  <?php
                 
                 if($partner['partner']['company_registration']){ ?>
                  <div id="imagePreview" style="overflow:hidden;">
                   
                    <object width="400" height="400" data="<?php echo base_url().$partner['partner']['company_registration']?>"></object>
                  </div>
              
                  <?php }?>
                  <div class="input-group">
                      <label class="input-group-btn">
                          <span class="btn btn-primary">
                              Browse&hellip; <input type="file" name="company_registration" id="company_registration" class="form-control" style="display: none;" >
                          </span>
                      </label>
                      <input type="text" class="form-control" readonly>
                  </div>
                </div>
                <?php
                 
                 if($partner['partner']['company_registration']){ ?>
                <div class="col-md-3 col-sm-6 col-xs-12">
                   <?php
                    $keywords = explode('cp_docs/', $partner['partner']['company_registration']);
                    $ext = pathinfo($keywords[1], PATHINFO_EXTENSION);
                        if($ext=='docx'){
                    ?>
                            <iframe class="doc" src="http://docs.google.com/gview?url=<?php echo base_url().$partner['partner']['company_registration']?>&embedded=true" style="width:60%" data-title="docs"></iframe>

                            <br>
                            
                            <!--<a href="#" class="btn btn-sm btn-danger btn_del" data-id="<?php echo $details['id'];?>"><i class="fa fa-trash"></i></a>-->
                            
                            
                            
                            
                    <?php
                        }else if($ext=='pdf'|| $ext=='jpg'|| $ext=='png'|| $ext=='jpeg' ){
                    ?>
                            <a href="<?php echo base_url().$partner['partner']['company_registration']?>"><i class="btn btn-sm btn-primary fa fa-file" target="_blank" data-title="pdf"></i><?= $keywords[1] ?></a>

                            <br>
                            
                            
                            <!--<a href="#" class="btn btn-sm btn-danger btn_del" data-id="<?php echo $partner['partner']['id'];?>"><i class="fa fa-trash"></i></a>-->
                            
                            
                            
                            
                    <?php
                        }else{
                            echo "No Docs";
                        }
                    ?>
                </div>
                <?php } ?>
                <div class="col-md-3 col-sm-6 col-xs-12">
                  <label>Corporation/Panchayath/Muncipality License</label>
                  <?php if($partner['partner']['license']){ ?>
                  <div id="imagePreview" style="overflow:hidden;">
                    <object width="400" height="400" data="<?php echo base_url().$partner['partner']['license']?>"></object>
                  </div>
                  <?php } ?>
                  <div class="input-group">
                      <label class="input-group-btn">
                          <span class="btn btn-primary">
                              Browse&hellip; <input type="file" name="license" id="license" class="form-control" style="display: none;" >
                          </span>
                      </label>
                      <input type="text" class="form-control" readonly>
                  </div>
                </div>
                <?php if($partner['partner']['license']){ ?>
                <div class="col-md-3 col-sm-6 col-xs-12">
                   <?php
                    $keywords1 = explode('cp_docs/', $partner['partner']['license']);
                    
                    $ext1 = pathinfo($keywords1[1], PATHINFO_EXTENSION);
                        if($ext1=='docx'){
                    ?>
                            <iframe class="doc" src="http://docs.google.com/gview?url=<?php echo base_url().$partner['partner']['license']?>&embedded=true" style="width:60%" data-title="docs"></iframe>

                            <br>
                            
                    <?php
                        }else if($ext1=='pdf'|| $ext1=='jpg'|| $ext1=='png'|| $ext1=='jpeg'){
                    ?>
                            <a href="<?php echo base_url().$partner['partner']['license']?>"><i class="btn btn-sm btn-primary fa fa-file" target="_blank" data-title="pdf"></i><?= $keywords1[1] ?></a>

                            <br>
                          
                    <?php
                        }else{
                            echo "No Docs";
                        }
                    ?>
                </div>
                <?php } ?>
                </div>
                </div>
                </div>
                </div>
                </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12">
                     <div class="col-md-12 col-sm-12 col-xs-12">
                      <div class="x_panel">
                       <div class="x_title">
                         <h2>Bank Details<small></small></h2>
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
                            <label>Bank Name</label>
                            <input type="text" name="bank_name" class="form-control" id="bank_name" value="<?php echo $partner['partner']['bank_name'];?>" placeholder="Bank Name">
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Account Number</label>
                            <input type="text" name="ac_number" class="form-control" id="ac_number" value="<?php echo $partner['partner']['account_no'];?>"  placeholder="Account Number">
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Account Holder Name</label>
                            <input type="text" name="ac_holder_name" class="form-control" id="ac_holder_name" value="<?php echo $partner['partner']['account_holder_name'];?>"  placeholder="Account Holder Name">
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>IFSC Number</label>
                            <input type="text" name="ifsc" class="form-control" id="ifsc" value="<?php echo $partner['partner']['ifsc'];?>"  placeholder="IFSC Number">
                        </div>
                       
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                  
                    <input type="submit" class="btn btn-primary channelsubmit" name="channelsubmit" id="channelsubmit" value="Save">
                </div>
                </div>
</div>
</div>
</div>
</div>
</div>
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

<!--************************row  end******************************************************************* -->




</div>
</div>
</div>
</div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>

<script type="text/javascript">
    $(document).on('change', '#sel_country',function(){
        var cur = $(this);
        var country = cur.val();
        $('.body_blur').show();
        $('#sel_state')[0].sumo.unload();
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
        },'json');
    });
    $(document).on('change', '#sel_state',function(){
        var cur = $(this);
        var state = cur.val();
        $('.body_blur').show();
        $('#town')[0].sumo.unload();
        $.post('<?php echo base_url();?>admin/Home/get_town_by_id/'+state, function(data){
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
                           
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully updated channel partner </div></div>';
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
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.channel_type').SumoSelect({search: true, placeholder: 'select category',okCancelInMulti: true,triggerChangeCombined: false});


        $('#sel_country').SumoSelect({search: true, placeholder: 'select country'});
        $('#sel_state').SumoSelect({search: true, placeholder: 'select state'});
        $('#town').SumoSelect({search: true, placeholder: 'select city'});
        
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

    });
</script>









</body>
</html>