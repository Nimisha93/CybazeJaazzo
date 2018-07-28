<?= $default_assets;?>
<link href="<?php echo base_url();?>assets/public/css/dashboard.css" rel="stylesheet" type="text/css" /> 
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    select {
      -webkit-appearance: none;
      -moz-appearance: none;
      text-indent: 1px;
      text-overflow: '';
    }
</style>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
<?php  
  $datas = getLoginId();
  $lid = $datas['login_id'];
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








.form-control[disabled] {
    cursor: not-allowed;
    background: #fff;
}











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
.error{
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
                  <form id="cp_form">
                  <div class="row">
                    <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                      <h4>Channel Details</h4>
                      <hr>
                    </div>
                    <div class="col-md-12">
                      <input type="hidden" name="hiddenid" class="form-control hiddenid"  value="<?php echo $partner['partner']['id'];?>"> 
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Club Type</label>
                        <input type="text" placeholder="Club Type" name="club_type" class="form-control"  value="<?php echo $partner['partner']['club_type'];?>">
                      </div> 
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Channel Name (Company/Institution/Shop)</label>
                        <input type="text" placeholder="Name" name="name" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['name'];?>">
                      </div>    
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Service</label>
                        <select name="module" class="form-control search-box-open-up search-box" id="module" >
                          <option value="">Please Select</option>
                          <?php foreach ($modules['type'] as $type) { ?>
                          <option <?= $partner['partner']['module']==$type['id'] ? "selected" : "" ; ?> value="<?php echo $type['id'];?>"><?php echo $type['module_name'];?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Channel Partner Type</label>
                       <!-- <select id="channel_type" class="form-control search-box-open-up search-box-sel-all channel_type" name="channel_type[]" multiple="multiple" onchange="console.log($(this).val())" >
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
                        </select>-->
                        <?php $cat = $partner['grp_sel'];$typ=array();
                                foreach($category['type'] as $type){ $pid=$type['id'];
                                foreach($subcategory['type'] as $stype){ 
                                if($stype['parent']==$pid){ $stype_id = $stype['id'];
                                if(in_array($stype_id, $cat)){ array_push($typ,$stype['title']); } }  } } ?>
                                <textarea class="form-control">
                                <?php  foreach($typ as $typee){
                                    echo $typee.'&#13;&#10;';
                                 } ?>
                                </textarea>
                      </div>

                      <?php if ($partner['partner']['profile_image'])  { ?>
                      <div class="col-md-4 col-sm-6 col-xs-12">
                        <label>Profile Image</label>





                        



                        <div id="imagePreview" style="overflow:hidden;">
                          <img src="<?php echo base_url().$partner['partner']['profile_image']?>" style="max-width:100%;height:160px;">
                        </div>


                     







                      </div>

                       <?php } ?>

                      <?php if($partner['partner']['brand_image'])  { ?>


                      <div class="col-md-4 col-sm-6 col-xs-12">
                        <label>Brand Image</label>





                        



                        <div id="imagePreview" style="overflow:hidden;">
                          <img src="<?php echo base_url().$partner['partner']['brand_image']?>" style="max-width:100%;height:160px;">
                        </div>

                     









                      </div>

                       <?php } ?>


                    </div> 
                    <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                      <h4>Contact Details</h4>
                      <hr>
                    </div> 
                    <div class="row">
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Email(Username)</label>
                          <input type="email" name="email" class="form-control email" id="email" data-rule-required="true" data-rule-email="true" value="<?php echo $partner['partner']['email'];?>" readonly="">
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Contact Number</label>
                          <input type="text" placeholder="Phone" name="phone" id="phone" class="form-control" data-rule-required="true" data-rule-number="true" value="<?php echo $partner['partner']['phone'];?>">
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Alternative Contact Number</label>
                          <input type="text" placeholder="Phone" name="phone2" class="form-control"  data-rule-number="true" value="<?php echo $partner['partner']['phone2'];?>">
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
                          <input type="text" name="c_mobile" class="form-control c_mobile" id="c_mobile" data-rule-number="true"  placeholder="Contact Mobile"
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
                          <input type="text" name="ac_mobile" class="form-control ac_mobile" id="ac_mobile"  placeholder="Contact Mobile" value="<?php echo $partner['partner']['alt_c_mobile'];?>">
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
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Country</label>
                          <select name="country" class="form-control search-box-open-up search-box-sel-all" id="sel_country" data-rule-required="true">
                          <option value="">Please Select</option>
                          <?php foreach ($countries as $key => $country) { ?>
                          <option <?= $partner['partner']['country'] == $country['id'] ? "selected" : "" ; ?> value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                          <?php } ?>
                          </select>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>State</label>
                          <select name="state" class="form-control sel_state select_box_sel" id="sel_state" data-rule-required="true">
                           <option value="">Please Select</option>
                           <?php foreach ($states as $st) { ?>
                          <option <?= $partner['partner']['state'] == $st['id'] ? "selected" : "" ; ?> value="<?php echo $st['id'];?>"><?php echo $st['name'];?></option>
                          <?php } ?>                                       
                          </select>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>City</label>
                          <select name="town" class="form-control town select_box_sel" id="town" data-rule-required="true">
                           <option value="">Please Select</option>
                           <?php foreach ($cities as $city) { ?>
                          <option <?= $partner['partner']['town'] == $city['id'] ? "selected" : "" ; ?> value="<?php echo $city['id'];?>"><?php echo $city['name'];?></option>
                          <?php } ?>                                       
                          </select>
                         <!--  
                          <input type="text" name="town" class="form-control" id="town" data-rule-required="true" value="<?php echo $partner['partner']['town'];?>"> -->
                        </div>









                         <!--  <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label>Area</label>
                  <input type="text" class="form-control" value="" name="area" >
                                            <span class="material-input"></span></div>
                                    </div> -->


                       <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Area </label>
                  <input type="text" placeholder="Area" name="cname" class="form-control" value="<?php echo $partner['partner']['area'];?>">
                        </div>             










                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                          <label>Address</label>
                          <textarea class="form-control" title="Address" name="address" rows="3" placeholder="Address" class="form-control"><?php echo $partner['partner']['address'];?></textarea>
                        </div>









                                                         <div class="col-md-12 col-sm-12 col-xs-12">
                            <h2 style="float:left;">Map Locator </h2>
                            </div>











                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                          <label>Latitude*</label>
                          <input type="text" placeholder="Latitude" id="lat" name="latt" class="form-control" data-rule-required="true" value="<?php echo $partner['partner']['lattitude'];?>">
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                          <label>Longitude*</label>
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
                          <label>Pan Number</label>
                          <input type="text" placeholder="Pan Number of Comapny" name="pan" class="form-control" data-rule-required="true" id="pan" value="<?php echo $partner['partner']['pan'];?>">
                      </div>
                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                          <label>Gst Number</label>
                          <input type="text" name="gst" class="form-control" id="gst" placeholder="Gst Number" value="<?php echo $partner['partner']['gst'];?>">
                      </div>
                      
       <!--                <div class="col-md-3 col-sm-6 col-xs-12">
                        <label>Company Registration Document</label>
                        <?php if($partner['partner']['company_registration']){ ?>
                        <div id="imagePreview" style="overflow:hidden;">
                         
                          <object width="250px" height="250px" data="<?php echo base_url().$partner['partner']['company_registration']?>"></object>
                        </div>       
                        <?php } ?>
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
                          <?php
                              }else if($ext=='pdf'|| $ext=='jpg'|| $ext=='png'|| $ext=='jpeg' ){
                          ?>
                                  <a href="<?php echo base_url().$partner['partner']['company_registration']?>"><i class="btn btn-sm btn-primary fa fa-file" target="_blank" data-title="pdf"></i><?= $keywords[1] ?></a>

                                  <br>
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
                          <object width="250px" height="250px" data="<?php echo base_url().$partner['partner']['license']?>"></object>
                        </div>
                        <?php } ?>
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
                    <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                      <h4>Bank Details</h4>
                      <hr>
                    </div>
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
                      </div> -->









                    </div>
                  </div>
                  </form>
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
    $("#cp_form :input").prop("disabled", true);

    // $('.channel_type').SumoSelect({search: true, placeholder: 'select category',okCancelInMulti: true,triggerChangeCombined: false});
    // $('#sel_country').SumoSelect({search: true, placeholder: 'select country'});
    // $('#sel_state').SumoSelect({search: true, placeholder: 'select state'});
    // $('#town').SumoSelect({search: true, placeholder: 'select city'});
    $(".gototop").click(function() {
        $("html, body").animate({"scrollTop": "0px"});
    });
  });
</script>
</body>
</html>
