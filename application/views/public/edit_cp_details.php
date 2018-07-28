<?= $default_assets;?>
<link href="<?php echo base_url();?>assets/public/css/dashboard.css" rel="stylesheet" type="text/css" /> 
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }.fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
}
.upld
{
      background-color: #f9f9f9;
    height: 40px;
    padding-left: 20px;
    -webkit-box-align: no;
    box-shadow: none;
    border: 1px solid #ccc;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
</style>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<?php  
  $datas = getLoginId();
  $lid = $datas['login_id'];
  $det = get_cmfacility_by_id($lid);
  $club_type_id = $datas['club_type_id'];
  $investor = isset($datas['investor_type_id'])?$datas['investor_type_id']:0;
  $fixed = isset($datas['fixed_type_id'])?$datas['fixed_type_id']:0;
  $session_array1 = $this->session->userdata('logged_in_user');
  $session_array2 = $this->session->userdata('logged_in_club_member');
  $session_array3 = $this->session->userdata('logged_in_club_agent');
        
  if(isset($session_array1)){
    $type= $session_array1['type'];
  }
  if(isset($session_array2)){
    $type= $session_array2['type'];
  }
  if(isset($session_array3)){
    $type= $session_array3['type'];
  }
?>
<?php  
  $datas = getLoginId();
  $club_type_id = $datas['club_type_id'];
  $investor = isset($datas['investor_type_id'])?$datas['investor_type_id']:0;
  $fixed = isset($datas['fixed_type_id'])?$datas['fixed_type_id']:0;
  $session_array1 = $this->session->userdata('logged_in_user');
  $session_array2 = $this->session->userdata('logged_in_club_member');
  $session_array3 = $this->session->userdata('logged_in_club_agent');
  echo $map['js'];
?>

  <script type="text/javascript">
    function getPosition(newLat, newLng)
    {
      $('#lat').val(newLat);
      $('#long').val(newLng);
    }
  </script>
<link href="<?php echo base_url();?>assets/public/sumo-select/sumoselect.css" rel="stylesheet" />
<link rel="stylesheet" href="<?php echo base_url();?>assets/public/css/easy-responsive-tabs.css">

<style type="text/css">
.row{margin:0;}
.goToTop{position:fixed;border-bottom:1px solid #000;z-index: 17;}

.fileUpload {
    position: relative;
    overflow: hidden;
    margin: 10px;
}
.upld
{
      background-color: #f9f9f9;
    height: 40px;
    padding-left: 20px;
    -webkit-box-align: no;
    box-shadow: none;
    border: 1px solid #ccc;
}
.fileUpload input.upload {
    position: absolute;
    top: 0;
    right: 0;
    margin: 0;
    padding: 0;
    font-size: 20px;
    cursor: pointer;
    opacity: 0;
    filter: alpha(opacity=0);
}
@media (max-width:980px){
.goToTop{height:40px;position:relative;}
}
@media (max-width:767px){
  .goToTop {
    position: relative;
    top: 0;
    left: 0;
    z-index: 10;
    background-color: #1a4794;
  }

.row{margin:0;}
}
label.error{
  color: red;
}
</style>
</head>
<body>
<!--===========header end here ========================-->
<?= $header;?>
</div>
<div class="clear"></div>
<section>
  <div class="content">
    <div class=" strchbx">
      <div id="oilfield">
        <ul class="resp-tabs-list">
          <div class="strchbxchild2">
            <div class="profimagemain">
              <?php $img = (!empty($user['profile_image']))? $user['profile_image']:'profile.jpg';?>
              <img class="profleimge" src="<?php echo base_url();?>uploads/<?= $img;?>">
              <div class="prflname"><?php echo  $user['name']; ?></div>
              <div class="prflemail"><?php echo  $user['email']; ?></div>
            </div>
            <div class="panel panel-defaul" style="background: none">
              <ul>
                <li><a href="<?php echo base_url();?>user_profile"  style="color: #fff;"><i class="fa fa-tachometer marleft7" aria-hidden="true"></i>Dashboard</a></li>
              </ul>
              
            </div>
            <div class="hegtdiv"></div>
          </div> 

        </ul>
        <div class="resp-tabs-container">
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="row wlletbg_prfile">
                  <h1 class="profil_ttlt">
                    Channel Partner Details :: <?php echo $partner['partner']['name'];?>
                  </h1>
                  <?php 
                    if($partner['partner']['status']=='REFERED'){
                  ?>
                    <form method="post" name="channel_form" id="refer_channel_form" action="<?php echo base_url();?>user/Profile/edit_refer_partner">
                      <div class="row">
                        <div class="col-md-12">
                          <input type="hidden" name="hiddenid" class="form-control hiddenid"  value="<?php echo $partner['partner']['id'];?>"> 
                          <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Club Type</label>
                          <select name="club_type" class="form-control" id="club_type" data-rule-required="true">
                            <?php 
                            if($session_array2['fixed_club_type_id'] && ($det['fixed_cp_limit']>$det['fixed_cp_count'])){
                              if($partner['partner']['club_type']=='FIXED'){
                                $sel ='selected';
                              }else{
                                $sel ='';
                              }
                            ?>
                            <option value="FIXED" <?= $sel; ?>>Fixed</option>
                            <?php } if($session_array2['investor_type_id']){?>
                            <option value="INVESTOR" selected="selected">Team Lead Club</option>
                            <?php }if($session_array2['club_type_id']){ 
                              if($partner['partner']['club_type']=='UNLIMITED'){
                                $sel ='selected';
                              }else{
                                $sel ='';
                              }
                            ?>
                            <option value="UNLIMITED" <?= $sel; ?>>Unlimited</option>
                            <?php } ?>
                          </select>
                        </div>
                          <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Channel Name (Company/Institution/Shop)</label>
                            <input type="text" placeholder="Name" name="name" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['name'];?>">
                          </div>    
                          <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Email(Username)</label>
                            <input type="email" name="email" class="form-control email" id="ch_email" data-rule-required="true" data-rule-email="true" value="<?php echo $partner['partner']['email'];?>">
                          </div>
                          <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Contact Number</label>
                            <input type="text" placeholder="Phone" name="phone" id="ch_phone" class="form-control" data-rule-required="true" data-rule-number="true" value="<?php echo $partner['partner']['phone'];?>">
                          </div>
                          <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Owner Contact Person</label>
                            <input type="text" placeholder="Contact Person" name="ocname" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['owner_name'];?>">
                          </div>
                          <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Owner Contact Email</label>
                            <input type="text" name="oc_email" class="form-control oc_email" id="oc_email" data-rule-required="true" data-rule-email="true" placeholder="Contact Email" value="<?php echo $partner['partner']['owner_email'];?>">
                          </div>
                        
                          <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                            <label>Owner Contact Mobile</label>
                            <input type="text" name="oc_mobile" class="form-control oc_mobile" id="oc_mobile" data-rule-required="true" data-rule-number="true"  placeholder="Contact Mobile" value="<?php echo $partner['partner']['owner_mobile'];?>">
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <label>Address</label>
                            <textarea class="form-control" title="Address" name="address" rows="3" placeholder="Address" class="form-control"><?php echo $partner['partner']['address'];?></textarea>
                          </div>
                          <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                              <button type="submit" class="btn btn-info channelsubmit" name="channelsubmit" id="channelsubmit">Save</button>
                          </div>
                        </div>  
                      </div>
                    </form>
                  <?php
                    }else{
                  ?>
                  <form method="post" name="channel_form" id="channel_form" action="<?php echo base_url();?>user/Profile/edit_partner">
                    <div class="row">
                      <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                        <h4>Channel Details</h4>
                        <hr>
                      </div>
                      <div class="col-md-12">
                        <input type="hidden" name="hiddenid" class="form-control hiddenid"  value="<?php echo $partner['partner']['id'];?>"> 
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">



                          <label>Club Type</label> <label style="color:red;">(Mandatory)</label>



                          <select name="club_type" class="form-control" id="club_type" data-rule-required="true">
                            <?php 
                            if($session_array2['fixed_club_type_id'] && ($det['fixed_cp_limit']>$det['fixed_cp_count'])){
                              if($partner['partner']['club_type']=='FIXED'){
                                $sel ='selected';
                              }else{
                                $sel ='';
                              }
                            ?>
                            <option value="FIXED" <?= $sel; ?>>Fixed</option>
                            <?php } if($session_array2['investor_type_id']){?>
                            <option value="INVESTOR" selected="selected">Team Lead Club</option>
                            <?php }if($session_array2['club_type_id']){ 
                              if($partner['partner']['club_type']=='UNLIMITED'){
                                $sel ='selected';
                              }else{
                                $sel ='';
                              }
                            ?>
                            <option value="UNLIMITED" <?= $sel; ?>>Unlimited</option>
                            <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">



                          <label>Service</label> <label style="color:red;">(Mandatory)</label>



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
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">



                          <label>Channel Name (Company/Institution/Shop)</label> <label style="color:red;">(Mandatory)</label>



                          <input type="text" placeholder="Name" name="name" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['name'];?>">
                        </div>  
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">



                            <label>Email(Username)</label> <label style="color:red;">(Mandatory)</label>



                            <input type="email" name="email" class="form-control email" id="email" data-rule-required="true" data-rule-email="true" value="<?php echo $partner['partner']['email'];?>" readonly="">
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">



                          <label>Contact Number</label> <label style="color:red;">(Mandatory)</label>



                          <input type="text" placeholder="Phone" name="phone" id="phone" class="form-control" data-rule-required="true" data-rule-number="true" value="<?php echo $partner['partner']['phone'];?>">
                        </div>
                      </div> 
                      <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                        <h4>Contact Details</h4>
                        <hr>
                      </div> 
                      <div class="row">
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



                            <input type="text" name="oc_mobile" class="form-control oc_mobile" id="oc_mobile" data-rule-required="true" data-rule-number="true"  placeholder="Contact Mobile" value="<?php echo $partner['partner']['owner_mobile'];?>">
                          </div>
                          <!-- <div class="col-md-4 col-sm-6 col-xs-12 form-group"> -->
                            <div class="col-md-3 col-sm-6 col-xs-12 form-group">



                            <label>Country</label> <label style="color:red;">(Mandatory)</label>



                            <select name="country" class="form-control search-box-open-up search-box-sel-all" id="sel_country" data-rule-required="true">
                            <option value="">Please Select</option>
                            <?php foreach ($countries as $key => $country) { ?>
                            <option <?= $partner['partner']['country'] == $country['id'] ? "selected" : "" ; ?> value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                            <?php } ?>
                            </select>
                          </div>
                         <!--  <div class="col-md-4 col-sm-6 col-xs-12 form-group"> -->
                           <div class="col-md-3 col-sm-6 col-xs-12 form-group">



                            <label>State</label> <label style="color:red;">(Mandatory)</label>



                            <select name="state" class="form-control sel_state select_box_sel" id="sel_state" data-rule-required="true">
                             <option value="">Please Select</option>
                             <?php foreach ($states as $st) { ?>
                            <option <?= $partner['partner']['state'] == $st['id'] ? "selected" : "" ; ?> value="<?php echo $st['id'];?>"><?php echo $st['name'];?></option>
                            <?php } ?>                                       
                            </select>
                          </div>
                         <!--  <div class="col-md-4 col-sm-6 col-xs-12 form-group"> -->
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






                          <div class="col-md-12 col-sm-12 col-xs-12">
                        <h5>Map Locator (Please choose channel location)</h5>
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
                      <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                        <h4>Verification Details</h4>
                        <hr>
                      </div>
                      <div class="col-md-12">
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">



                            <label>Pan Number</label> <label style="color:red;">(Mandatory)</label>



                            <input type="text" placeholder="Pan Number of Comapny" name="pan" class="form-control" data-rule-required="true" id="pan" value="<?php echo $partner['partner']['pan'];?>">
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                            <label>Gst Number</label>
                            <input type="text" name="gst" class="form-control" id="gst" placeholder="Gst Number" value="<?php echo $partner['partner']['gst'];?>">
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12">
                          <label>Company Registration Document</label>
                          <?php if($partner['partner']['company_registration']){ ?>
                          <div id="imagePreview" style="overflow:hidden;">
                           
                            <object width="400" height="400" data="<?php echo base_url().$partner['partner']['company_registration']?>"></object>
                          </div>
                          <?php } ?>
                          <div class="input-group">
                              <label class="input-group-btn">
                                  <span class="btn btn-primary">
                                      Browse&hellip; <input type="file" name="company_registration" id="company_registration" class="form-control" style="display: none;" >
                                  </span>
                              </label>
                              <input type="text" class="form-control" readonly>
                          </div>
                        </div>
                        <?php if($partner['partner']['company_registration']){ ?>
                          <div class="col-md-3 col-sm-6 col-xs-12">
                            <?php
                              $keywords = explode('cp_docs/', $partner['partner']['company_registration']);
                              $ext = pathinfo($keywords[1], PATHINFO_EXTENSION);
                                if($ext=='docx'){
                            ?>
                                    <iframe class="doc" src="http://docs.google.com/gview?url=<?php echo base_url().$partner['partner']['company_registration']?>&embedded=true" style="width:60%" data-title="docs"></iframe>

                                    <br>
                                    <a href="#" class="btn btn-sm btn-danger btn_del" data-id="<?php echo $details['id'];?>"><i class="fa fa-trash"></i></a>
                            <?php
                                }else if($ext=='pdf'|| $ext=='jpg'|| $ext=='png'|| $ext=='jpeg' ){
                            ?>
                                    <a href="<?php echo base_url().$partner['partner']['company_registration']?>"><i class="btn btn-sm btn-primary fa fa-file" target="_blank" data-title="pdf"></i><?= $keywords[1] ?></a>

                                    <br>
                                    <a href="#" class="btn btn-sm btn-danger btn_del" data-id="<?php echo $partner['partner']['id'];?>"><i class="fa fa-trash"></i></a>
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
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                          <button type="submit" class="btn btn-info channelsubmit" name="channelsubmit" id="channelsubmit">Save</button>
                      </div>
                    </div>
                  </form>
                  <?php } ?>
                </div>         
              </div> 
            </div>
          </div>
        </div>
      </div>
    </section>
  </section>
</div>
<?php echo $footer; ?>
<div id="editprofile" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content editprfl">
      <div class="modal-header ">
        <button type="button" class="close" data-dismiss="modal">X</button>
        <h4 class="modal-title">EDIT PROFILE</h4>
      </div>
      <form method="post" name="profile_form" id="edit_profile_form" action="<?php echo base_url();?>Home/edit_profile_byid/<?php echo $user['id'];?>">
        <div class="modal-body" style="overflow-x:auto">
            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
              <label>First Name</label>
              <input type="text" value="<?php echo  $user['name']; ?>"  placeholder="Name"   name="name"  class="form-control validate[required]" >
            </div>
            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
              <label>Last Name</label>
              <input type="text" value="<?php echo  $user['lastname']; ?>" name="lastname" class="form-control validate[required]">
            </div>
            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
              <label>Location</label>
              <input type="text" value="<?php echo  $user['location']; ?>" name="location" class="form-control validate[required]">
            </div>
        </div>
        <div class="clear"></div>
        <div class="modal-footer">
          <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary" name="" id="">Update</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
<div id="uplodimage" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">X</button>
        <h4 class="modal-title">Upload Your Profile Image</h4>
      </div>
      <?php echo form_open_multipart('Home/do_upload');?>
        <div class="modal-body">
          <div>
            <div class="fileUpload btn btn-primary">
              <span>Upload</span>
              <input id="fileupload" type="file" class="upload" id="fileupload" multiple="multiple" name="userfile[]" />
            </div>
            <hr />
            <b>Live Preview</b>
            <br />
            <br />
            <div id="dvPreview">
            </div>
          </div>
          <input type="submit" name="upload" class="btn btn-danger" value="Save" style="margin-top:10px;margin-left:10px;">
  <!--    <button type="button" class="btn btn-danger" style="margin-top:10px;">Save</button>-->
        </div>
       </form>
    </div>
  </div>
</div>
<script src="<?php echo base_url();?>assets/public/js/easyResponsiveTabs.js"></script> 
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
<script src="<?php echo base_url();?>assets/public/sumo-select/jquery.sumoselect.js"></script>
<script src="<?php echo base_url();?>assets/public/custom_js/paging.js"></script>
<script>
  $('#oilfield').easyResponsiveTabs({
    type: 'vertical'
  });
</script> 
<!--=======================================slider right==============================================--> 
<script language="javascript" type="text/javascript">
  $(document).ready(function() {
    $('.channel_type').SumoSelect({search: true, placeholder: 'select category',okCancelInMulti: true,triggerChangeCombined: false});
    $('#sel_country').SumoSelect({search: true, placeholder: 'select country'});
    $('#sel_state').SumoSelect({search: true, placeholder: 'select state'});
    $('#town').SumoSelect({search: true, placeholder: 'select city'});
    $(".gototop").click(function() {
        $("html, body").animate({"scrollTop": "0px"});
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
        }else { 
             
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
    var x = jQuery("#channel_form").validate({
      submitHandler: function(datas) {
        $('.body_blur').show();
        jQuery(datas).ajaxSubmit({
            dataType : "json",
            success  :    function(data)
            {
              $('.body_blur').hide();
              if(data.status){
                swal("Success!", "Channel Partner details updated successfully", "success");
              } else {
                var regex = /(<([^>]+)>)/ig;
                var body = data.reason;
                var result = body.replace(regex, "");
                swal("Warning!", result, "error");
              }
            }
        });
      }
    });

    var y = jQuery("#refer_channel_form").validate({
      submitHandler: function(datas) {
        $('.body_blur').show();
        jQuery(datas).ajaxSubmit({
            dataType : "json",
            success  :    function(data)
            {
              $('.body_blur').hide();
              if(data.status){
                swal("Success!", "Channel Partner details updated successfully", "success");
              } else {
                var regex = /(<([^>]+)>)/ig;
                var body = data.reason;
                var result = body.replace(regex, "");
                swal("Warning!", result, "error");
              }
            }
        });
      }
    });
  });
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
  $('#ch_email').focusout(function(){
    var cur = $(this);
    var mail = cur.val();

    $.post('<?php echo base_url();?>user/Profile/ch_mail_exists/',{mail :mail},function(data)
    {
      if(data.status)
      {
          var regex = /(<([^>]+)>)/ig;
          var body = "Mail Id Already Exists";
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
          cur.val("");
      }else{
      }
    },'json');
  });
  $('#ch_phone').focusout(function(){
    var cur = $(this);
    var mob = cur.val();
    $.post('<?php echo base_url();?>user/Profile/ch_mobile_exists/',{mob :mob},function(data)
    {
      if(data.status)
      {
        var regex = /(<([^>]+)>)/ig;
        var body = "Mobile Number Already Exists";
        var result = body.replace(regex, "");
        swal("Warning!", result, "error");
        cur.val("");
      }else{
      }
    },'json');
  });
</script>
</body>
</html>
