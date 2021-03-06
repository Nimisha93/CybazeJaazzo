<?= $default_assets;?>
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
</style>
</style> 
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/themes/smoothness/jquery-ui.min.css" rel="stylesheet" type="text/css" /> 
<script src="<?php echo base_url();?>assets/public/js/jquery-ui.min.js"></script> 
<script src="<?php echo base_url();?>assets/public/js/angular.min.js"></script> 


<script type="text/javascript">
$(function () {
    $("#date").datepicker({
      dateFormat: 'yy-mm-dd'
    });
});
angular.module("date", [])
    .directive("datepicker", function () {
    return {
        restrict: "A",
        link: function (scope, el, attr) {
            el.datepicker({
                            dateFormat: 'yy-mm-dd'
                        });
        }
    };
}).controller("dateCtrl", function ($scope) {
});
  function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57 ))
        return false;
    return true;
  }
</script>
<?php  
  $datas = getLoginId();

  $session_array1 = $this->session->userdata('logged_in_user');
  $session_array2 = $this->session->userdata('logged_in_club_member');
  $session_array3 = $this->session->userdata('logged_in_club_agent');
        
  if(isset($session_array1)){
    $type= $session_array1['type'];
  }
  if(isset($session_array2)){
    $type= $session_array2['type'];
  echo $map['js']; ?>
  <script type="text/javascript">
    function getPosition(newLat, newLng)
    {
      $('#lat').val(newLat);
      $('#long').val(newLng);
    }
  </script>   
<?php  }
  if(isset($session_array3)){
    $type= $session_array3['type'];
  }
?>
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
              <img class="profleimge" src="<?php echo base_url();?>uploads\<?= $user['profile_image'];?>">
              <div class="prflname"><?php echo  $user['name']; ?></div>
              <div class="prflemail"><?php echo  $user['email']; ?></div>
            </div>
            <li><i class="fa fa-user marleft7" aria-hidden="true"></i>About</li>
            <li><i class="fa fa-cog marleft7" aria-hidden="true"></i>Update Account Info </li>
            <?php if($type=='normal_customer'||$type=='club_member'||$type=='club_agent') {?>
            <li><i class="fa fa-cog marleft7" aria-hidden="true"></i>My Transactions</li>
            <?php }?>
            <li><i class="fa fa-cog marleft7" aria-hidden="true"></i>Account Settings</li>
            <li><i class="fa fa-window-maximize marleft7" aria-hidden="true"></i>Wallet</li>
            <?php if($type=='club_member'||$type=='club_agent') {?>
            <li><i class="fa fa-users marleft7" aria-hidden="true"></i>All Active <?php echo($type=='club_agent')?'Members':'Friends'?></li>
            <li><i class="fa fa-user-o marleft7" aria-hidden="true"></i>All Referred <?php echo($type=='club_agent')?'Members':'Friends'?></li>
            <?php  } if($type=='club_member') {?>
            <li><i class="fa fa-window-maximize marleft7" aria-hidden="true"></i>All Club Agents</li>
            <li><i class="fa fa-window-maximize marleft7" aria-hidden="true"></i>Refer Channel Partner</li>

            <?php 
              if($datas){
                $lid = $datas['login_id'];
              }
              $det = get_cm_facility_by_id($lid);
              if($det['cp_limit']>=$det['cp_count']){
            ?>
            <li><i class="fa fa-window-maximize marleft7" aria-hidden="true"></i>Add Channel Partner</li>
            <?php } ?>
            <li><i class="fa fa-window-maximize marleft7" aria-hidden="true"></i>All Channel Partners</li>

            <?php  } ?>

            <div class="hegtdiv"></div>
          </div> 
        </ul>
        <div class="resp-tabs-container">
          <div>
            <div class="row prfilebox">
              <div class="col-md-3 col-sm-4 col-xs-12 ">
                <div id="myCarousel2" class="carousel slide" data-ride="carousel">
                  <div class="carousel-inner">
                    <?php  
                      foreach($user_image as $ky=> $row)
                      {
                        $cls = $ky==0 ? 'active' : '';
                    ?>
                    <div class="item <?= $cls;?>">
                     <img class="prfimanimage" src="<?php echo base_url();?>uploads\<?= $row['profile'];?>">
                    </div>
                    <?php
                       }
                    ?>
                  </div>
                    <img class="profleimge" src="<?php echo base_url();?>uploads\<?= $user['profile_image'];?>">

                  <div class="camera" style="margin:0px 140px">
                    <a class="" data-toggle="modal" data-target="#uplodimage"><i class="fa fa-camera" aria-hidden="true"></i></a>
                  </div>
                  <a class="left carousel-control" href="#myCarousel2" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left"></span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="right carousel-control" href="#myCarousel2" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right"></span>
                    <span class="sr-only">Next</span>
                  </a>  <!-- Left and right controls -->
                </div>
              </div>
              <div class="col-md-9 col-sm-8 col-xs-12 prfilebox">
                <div class="su_prname"><?php echo  $user['name']; ?></div>
                <div class="su_prphone"><i class="fa fa-mobile prclr1" style="font-size: 27px !important" aria-hidden="true"></i> <?php echo $user['phone']; ?></div>
                <div class="su_prphone2"><i class="fa fa-whatsapp prclr2"   style="font-size: 19px !important" aria-hidden="true"></i> <?php echo $user['whatssup_no']; ?></div>
                <div class="su_whatsapp"><i class="fa fa-envelope-o prclr1"  aria-hidden="true"></i> 
                <?php echo $user['email']; ?></div>
                <div class="su_praddrs"><i class="fa fa-map-marker prclr2"  style="font-size: 23px !important" aria-hidden="true"></i>
                <?php echo $user['location']; ?></div>
                <div class="socialmediaicon" style="width: 91px;">
                  <ul>
                    <a href="<?php echo  $user['facebook_id']; ?>" target="_blank">
                    <li> <i class="fa fa-facebook" aria-hidden="true"></i></li>
                    </a> 
                    <a href="<?php echo  $user['google_plus']; ?>" target="_blank">
                    <li><i class="fa fa-google-plus" aria-hidden="true"></i></li>
                    </a>
                    <a href="<?php echo  $user['twitter']; ?>" target="_blank">
                    <li><i class="fa fa-twitter" aria-hidden="true"></i></li>
                    </a>
                  </ul>
                </div>
                <br>
                <button type="button" class="editsub " id="editsub" data-toggle="modal" data-target="#editprofile"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit Info</button>
              </div>
            </div>
          </div>
          <!--========================= tab 1 end here =============================================-->
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row wlletbg_prfile">
                <h1 class="profil_ttlt">
                   EDIT PROFILE
                </h1>
                <div id="no-more-tables">
                  <form method="post" name="profile_form" id="profile_form" action="<?php echo base_url();?>Home/edit_normal_byid/<?php echo $user['id'];?>">
                    <div class="row">
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>First Name</label>
                        <input type="text" value="<?php echo  $user['name']; ?>"  placeholder="Name"   name="name"  class="form-control validate[required]" >
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Last Name</label>
                        <input type="text" value="<?php echo  $user['lastname']; ?>" name="lastname" class="form-control validate[required]" placeholder="Last Name">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Mobile No (1)</label>
                        <input type="number"  onKeyPress="return isNumberKey(event)" value="<?php echo  $user['phone']; ?>"  placeholder="Mobile No(1)"   name="phone"  class="form-control validate[required]" >
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Mobile No (2)</label>
                        <input type="number"  onKeyPress="return isNumberKey(event)" value="<?php echo  $user['phone2']; ?>"  placeholder="Mobile No(2)"   name="phone2"  class="form-control validate[required]" >
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Whatsapp No</label>
                        <input value="<?php echo  $user['whatssup_no']; ?>" name="whatssup_no" class="form-control validate[required]" type="number"  onKeyPress="return isNumberKey(event)" placeholder="Whatsapp No">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Email</label>
                        <input type="email" value="<?php echo  $user['email']; ?>"  placeholder="Email"   name="email"  class="form-control validate[required]" data-rule-required="true" data-rule-email="true" readonly='true'>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Alternative Email</label>
                        <input type="email" value="<?php echo  $user['alt_email']; ?>" name="alt_email" class="form-control validate[required]" data-rule-email="true" placeholder="Alternate Email">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label for="sel1">Select Country</label>
                        <select class="form-control" id="sel_country" name="country">
                          <?php foreach ($countries as $key => $country) { ?>
                          <option <?= $user['country']==$country['id']?"selected" : ""; ?> value="<?php echo $country['id'];?>"  ><?php echo $country['name'];?></option>
                          <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label for="sel1">Select State</label>
                        <select class="form-control sel_state" id="sel2" name="state">
                            <?php foreach ($state as  $key => $st) { ?>
                            <option <?= $user['state']==$st['id']?"selected" : ""; ?> value="<?php echo $st['id'];?>"  ><?php echo $st['name'];?></option>
                            <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>District</label>
                        <input type="text" value="<?php echo  $user['district']; ?>"  name="district" class="form-control validate[required]" placeholder="District">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>City / Town</label>
                        <input type="text" value="<?php echo  $user['city']; ?>"  name="city" class="form-control validate[required]" placeholder="City / Town">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Location</label>
                        <input type="text" value="<?php echo  $user['location']; ?>" name="location" class="form-control validate[required]" placeholder="Location">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Area</label>
                        <input type="text" value="<?php echo  $user['area']; ?>"  name="area" class="form-control validate[required]" placeholder="Area">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Post Office</label>
                        <input type="text" value="<?php echo  $user['post_office']; ?>"  name="post_office" class="form-control validate[required]" placeholder="Post Office">
                      </div>
                      
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Road</label>
                        <input type="text" value="<?php echo  $user['road']; ?>"  name="road" class="form-control validate[required]" placeholder="Road">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Street</label>
                        <input type="text" value="<?php echo  $user['streat']; ?>"  name="streat" class="form-control validate[required]" placeholder="Street">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Apartment Name / House Name</label>
                        <input type="text" value="<?php echo  $user['house_name']; ?>" placeholder="Apartment Name / House Name" name="house_name" class="form-control validate[required]">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Apartment No / House No</label>
                        <input type="text" value="<?php echo  $user['house_no']; ?>"  name="house_no" class="form-control validate[required]" placeholder="Apartment No / House No">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Facebook</label>
                        <input type="text" value="<?php echo  $user['facebook_id']; ?>" placeholder="Facebook" name="facebook_id" class="form-control validate[required]">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Twitter</label>
                        <input type="text" value="<?php echo  $user['twitter']; ?>" placeholder="Twitter" name="twitter" class="form-control validate[required]">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Google plus</label>
                        <input type="text" value="<?php echo  $user['google_plus']; ?>" placeholder="Google Plus" name="google_plus" class="form-control validate[required]">
                      </div>
                      <div class="clear"></div>
                      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" name="" id="">Update</button>
                      </div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <?php if($type=='normal_customer'||$type=='club_member'||$type=='club_agent') {?>
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row wlletbg_prfile">
                <h1 class="profil_ttlt">
                  My Transactions
                </h1>
                <div id="no-more-tables">
                  <div class="row">
                  <div ng-app="date">
                    <div ng-controller="dateCtrl">
                      
                      <div class="col-sm-3">
                          <input type="text" id="date" name="date" ng-model="date" class="fromdate form-control">
                      </div>
                      <div class="col-sm-3">
                           <input type="text" datepicker ng-model="date2" class="todate form-control" />
                      </div> 
                      <div class="col-sm-1">
                        <button class="btn btn-info" id="btn_search">Go</button>
                      </div>
                    </div>
                  </div>
                       
                      <div class="col-sm-3">
                          <label class="pull-right">Search:</label>
                      </div>
                      <div class="col-sm-2">
                          <input type="text" class="form-control search" name="search" id="search5" placeholder="">
                      </div>
                  </div><br>
                  <table id="example" class="col-md-12 table-bordered table-striped table-condensed cf table-fixed" width="100%">
                    <thead class="cf">
                      <tr>
                        <th width="65px;">Sn No.</th>
                        <th>Channel Partner</th>
                        <th>Purchased On</th>
                        <th>Total Bill</th>
                        <th>Discount</th>
                      </tr>
                    </thead>
                    <tbody id="tbody5" style=" height:100px;overflow:scroll">
                        
                    </tbody>
                    <tfoot>
                        <td colspan="5">
                            <div class="pull-right" id="pagination5"></div>
                        </td>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <?php }?>
          <!--========================= tab 2 end here =============================================-->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 prfilebox">
              <div class="col-md-6 col-sm-6 col-xs-12">
                <div class="prfl_trnsfr wlletbg_prfile tp_mar20 top_pad20 botm_pad20" style="overflow:hidden">
                  <h1 class="bm_mar10">Change Your Password</h1>
                  <form name="chng_pwd" action="<?php echo base_url();?>Home/change_password" method="post" id="chng_pwd">
                    <div class="form-group">
                      <input type="password" class="form-control" placeholder="Enter Old password" name="opassword" id="opassword">
                    </div>      
                    <div class="form-group">
                      <input type="password" class="form-control" placeholder="Enter New password" name="npassword" id="npassword">
                    </div> 
                    <div class="form-group">
                      <input type="password" class="form-control" placeholder=" Confirm password" name="cpassword" id="cpassword">
                    </div> 
                    <button class="button_submit3 btn_chang_pwd" style="width:100%"  type="submit">Save Changes</button>
                  </form>
                </div>
                <a class="desctvtbtn" data-toggle="collapse" data-target="#deactvte">  Deactivate your Account ? </a>
                <div id="deactvte" class="collapse">
                  <form name="" action="" method="post" onSubmit="return validate_form()">
                    <div class="col-md-4">Reason for leaving</div>
                    <div class="col-md-8">
                      <label class="radio-inline"><input type="radio" name="optradio">This is temporary. I'll be back.</label><br>
                      <label class="radio-inline"><input type="radio" name="optradio">I don't find Jaazzo useful.</label><br>
                      <label class="radio-inline"><input type="radio" name="optradio">My account was hacked.</label><br>
                      <label class="radio-inline"><input type="radio" name="optradio">I have a privacy concern.</label><br>
                      <label class="radio-inline"><input type="radio" name="optradio">I get too many emails, invitations, and requests from Jaazzo.</label><br>
                      <label class="radio-inline"><input type="radio" name="optradio">Other, please explain further:</label><br>
                    </div>
                    <br>
                    <div class="col-md-4">Please explain further</div>
                    <div class="col-md-8">
                      <div class="form-group">
                        <textarea class="form-control" rows="5" id="comment"></textarea>
                      </div>
                    </div>
                    <br>
                    <div class="col-md-4">Email opt out</div>
                    <div class="col-md-8">
                      <label class="checkbox-inline">
                      <input type="checkbox" value="">Opt out of receiving future emails from Jaazzo</label>
                    </div>
                    <button class="button_submit3" data-toggle="modal" data-target="#success" type="submit">Continue</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <!--========================= tab 3 end here =============================================-->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 prfilebox">
              <div class="col-sm-4 col-xs-12">
                <div class="wlletbg_prfile tp_mar20 top_pad20 botm_pad20" style="overflow:hidden;">
                  <?php
                   $session_array = $this->session->userdata('logged_in_user');
                   if($session_array){
                       foreach ($wallet as $key => $wal) { 
                  ?>
                     <div class="prflrwd_wllt">
                         <div class="hgsd"><img src="<?php echo base_url();?>assets/public/images/prfl_wlt.png"></div>
                         <div class="prfl_wltname"><?= $wal['title'];?></div>
                         <div class="prfl_wltname"><?= round_number($wal['total_value']);?></div>
                     </div>
                  <?php } } ?>
                </div>
              </div>
              <div class="col-md-8 col-sm-8 col-md-12">
                <div class="prfl_trnsfr wlletbg_prfile tp_mar20 top_pad20 botm_pad20" style="overflow:hidden">
                  <h1 class="bm_mar10">Jaazzo Eazy Transfer</h1>
                  <form name="transfer_form" method="post" id="transfer_form2" action="<?php echo base_url();?>user/Money_transfer/transfer_amount">
                    Select Your Wallet :
                    <select id="wallet_ids2" name="transfer_type" class="form-control" style="width: 95%">
                          <option value="">please select</option>
                          <option value="<?php echo $vallet_type['reward_id'] ?>">
                            <?php echo $vallet_type['reward_name'] ?></option>
                          <option value="<?php echo $vallet_type['mywallt_id'] ?>">
                            <?php echo $vallet_type['mywallet_name'] ?>
                          </option>
                          <?php if($session_array2['type']=='club_member'){?>
                          <option value="<?php echo $vallet_type['club_id'] ?>">
                            <?php echo $vallet_type['club_name'] ?>
                          </option>
                          <?php } ?>
                    </select>
                    <br>
                    <div style="display: none" id="wallet_value2">
                      wallet amount  :
                      <input class="txt_bg3" name="wallet" id="wallet2" type="text" value="" />
                    </div>
                    <div class="logn_frrmbx">
                      Enter Mobile :  <input class="txt_bg3" name="transfer_mobile" type="number"  onKeyPress="return isNumberKey(event)" placeholder="Mobile" />
                      <br>
                      Enter Amount :  <input class="txt_bg3" id="transfer_amount2" name="transfer_amount" onKeyPress="return isNumberKey(event)" type="text" placeholder="Amount" />
                      <input type="submit" name="transfer_submit" id="transfer_submit" class="button_submit3 continue_login" value="continue">
                    </div>
                  </form>
                </div>
              </div>            
            </div>  
          </div>
          <!--========================= tab 4 end here =============================================-->
          <?php if($type=='club_member'||$type=='club_agent') {?>
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row wlletbg_prfile">
                <h1 class="profil_ttlt">
                    Active <?php echo($type=='club_agent')?'Members':'Friends'?>
                </h1>
                <div id="no-more-tables">
                  <div class="row">
                      <div class="col-sm-offset-7 col-sm-3">
                          <label class="pull-right">Search:</label>
                      </div>
                      <div class="col-sm-2">
                          <input type="text" class="form-control search" name="search" id="search1" placeholder="">
                      </div>
                  </div><br>
                  <table id="example" class="col-md-12 table-bordered table-striped table-condensed cf table-fixed" width="100%">
                    <thead class="cf">
                      <tr>
                        <th width="65px;">Sn No.</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th class="numeric">Image</th>
                        <th class="numeric">Location</th>
                      </tr>
                    </thead>
                    <tbody id="tbody1" style=" height:100px;overflow:scroll">
                        
                    </tbody>
                    <tfoot>
                        <td colspan="5">
                            <div class="pull-right" id="pagination1"></div>
                        </td>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
          <!--========================= tab 5 end here =============================================-->
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row wlletbg_prfile">
                <h1 class="profil_ttlt">
                  All Referred <?php echo($type=='club_agent')?'Members':'Friends'?>
                </h1>
                <div id="no-more-tables2">
                  <div class="row">
                      <div class="col-sm-offset-7 col-sm-3">
                          <label class="pull-right">Search:</label>
                      </div>
                      <div class="col-sm-2">
                          <input type="text" class="form-control search" name="search" id="search2" placeholder="">
                      </div>
                  </div><br>
                  <table class="col-md-12 table-bordered table-striped table-condensed cf">
                    <thead class="cf">
                      <tr>
                        <th width="65px;">Sn No.</th>
                        <th>Name</th>
                        <th>Mobile</th>
                        <th class="">Location</th>
                        <th width="200px">Action</th>
                      </tr>
                    </thead>
                    <tbody id="tbody2" style=" height:100px;overflow:scroll">
                        
                    </tbody>
                    <tfoot>
                        <td colspan="5">
                            <div class="pull-right" id="pagination2"></div>
                        </td>
                    </tfoot>
                  </table>
                </div>
              </div>         
            </div>  
          </div>
          <!--========================= tab 6 end here =============================================-->
          <?php }if($type=='club_member'){?>
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row wlletbg_prfile">
                <h1 class="profil_ttlt">
                  All Club Agents
                </h1>
                <div id="no-more-tables2">
                  <div class="row">
                      <div class="col-sm-offset-7 col-sm-3">
                          <label class="pull-right">Search:</label>
                      </div>
                      <div class="col-sm-2">
                          <input type="text" class="form-control search" name="search" id="search4" placeholder="">
                      </div>
                  </div><br>
                  <table class="col-md-12 table-bordered table-striped table-condensed cf">
                    <thead class="cf">
                      <tr>
                        <th width="65px;">Sn No.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact No</th>
                        <th width="200px">Action</th>
                      </tr>
                    </thead>

                    <tbody id="tbody4" style=" height:100px;overflow:scroll">
                        
                    </tbody>
                    <tfoot>
                        <td colspan="5">
                            <div class="pull-right" id="pagination4"></div>
                        </td>
                    </tfoot>
                  </table>
                </div>
              </div>         
            </div>  
          </div>
          <!--========================= tab 7 end here =============================================-->
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 prfilebox">
              <div class="prfl_trnsfr wlletbg_prfile tp_mar20 top_pad20 botm_pad20" style="overflow:hidden">
                <h1 class="bm_mar10">Refer Channel Partner</h1>
                <form name="refer_cp" action="<?php echo base_url();?>user/Profile/refer_channel_partner" method="post" id="refer_cp">
                  <div class="col-md-6">
                    <label>Club Type</label>
                    <div class="form-group">
                      <select name="club_type" class="form-control" id="club_type" data-rule-required="true">
                      <option value="">Please Select</option>
                      <option value="UNLIMITED">Unlimited</option>
                      <?php if($session_array2['fixed_club_type_id']){?>
                      <option value="FIXED">Fixed</option>
                      <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <label>Name of the Channel Partner</label>
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Name" name="name" id="name">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Contact No</label>
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Contact" name="phone" id="contact">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Contact Person</label>
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Contact Person" name="cname" id="contact_person">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Contact Mobile</label>
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Contact Mobile" name="c_mobile" id="contact_mobile">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Contact Email</label>
                    <div class="form-group">
                      <input type="email" class="form-control" placeholder="Contact Email" name="c_email" id="contact_email">
                    </div>     
                  </div>
                  <div class="col-md-6">
                    <label>Town</label>
                    <div class="form-group">
                      <input type="text" class="form-control" placeholder="Town" name="location" id="location">
                    </div>     
                  </div>
                  <div class="col-md-offset-5 col-md-3">
                    <button class="button_submit3 btn_add" type="submit" style="width: 70%;">Save </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!--========================= tab 8 end here =============================================-->
          <?php 
            if($datas){
              $lid = $datas['login_id'];
            }
            $det = get_cm_facility_by_id($lid);
            echo json_encode(get_cmfacility_by_id($lid));
             if($det['cp_limit']>=$det['cp_count']){
          ?>
          <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 prfilebox">
                <form method="post" name="channel_form" id="channel_form" action="<?php echo base_url();?>new_partner" enctype="multipart/form-data">
                  <div class="col-md-12">
                    <div class="row">
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Club Type</label>
                        <select name="club_type" class="form-control" id="club_type" data-rule-required="true">
                        <option value="">Please Select</option>
                        <option value="UNLIMITED">Unlimited</option>
                        <?php if($session_array2['fixed_club_type_id']){?>
                        <option value="FIXED">Fixed</option>
                        <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Module</label>
                        <select name="module" class="form-control search-box-open-up search-box" id="module" data-rule-required="true">
                        <option value="">Please Select</option>
                        <?php foreach ($modules['type'] as $type) { ?>
                        <option value="<?php echo $type['id'];?>"><?php echo $type['module_name'];?></option>
                        <?php } ?>
                        </select>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Channel Partner Type</label>
                          <select id="channel_type" class="form-control search-box-open-up search-box-sel-all channel_type" name="channel_type[]" multiple="multiple" data-rule-required="true">
                              <?php foreach($category['type'] as $type){ ?>
                              
                              <!-- <option value="<?php echo $type['id'];?>"><?php echo $type['title'];?></option> -->
                              <optgroup label="<?php echo $type['title'];?>">
                              <?php $pid=$type['id']; foreach($subcategory['type'] as $stype){ if($stype['parent']==$pid){ ?>

                              <option class="subc" value="<?php echo $stype['id'];?>"><?php echo $stype['title'];?></option>
                              
                              <?php } ?> </optgroup> <?php } } ?>
                            </select>
                         <!--  <select id="channel_type" class="form-control search-box-open-up search-box-sel-all channel_type" name="channel_type[]" multiple="multiple" onchange="console.log($(this).val())" data-rule-required="true">
                          <?php foreach($category['type'] as $type){ ?>
                          
                          <option value="<?php echo $type['id'];?>"><?php echo $type['title'];?></option>
                          
                          <?php $pid=$type['id']; foreach($subcategory['type'] as $stype){ if($stype['parent']==$pid){ ?>

                          <option class="subc" value="<?php echo $stype['id'];?>"><?php echo $stype['title'];?></option>
                          
                          <?php } } } ?>
                          </select> -->
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Name</label>
                          <input type="text" placeholder="Name" name="name" class="form-control" data-rule-required="true">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Email</label>
                          <input type="text" name="email" class="form-control email" id="ch_email" data-rule-required="true" data-rule-email="true">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Contact Number</label>
                        <input type="number" placeholder="Phone" name="phone" id="ch_phone" class="form-control" data-rule-required="true" data-rule-number="true" onKeyPress="return isNumberKey(event)">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Alternative Contact Number</label>
                        <input type="number" placeholder="Phone" name="phone2" class="form-control" data-rule-required="true" data-rule-number="true" onKeyPress="return isNumberKey(event)">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Contact Person</label>
                          <input type="text" placeholder="Name" name="cname" class="form-control" data-rule-required="true">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Contact Email</label>
                          <input type="email" name="c_email" class="form-control c_email" id="c_email" data-rule-required="true" data-rule-email="true">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Contact Mobile</label>
                          <input type="text" name="c_mobile" class="form-control c_mobile" id="c_mobile" data-rule-required="true" data-rule-number="true"  placeholder="Contact Mobile">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Alternative Contact Person</label>
                          <input type="text" placeholder="Contact Person" name="acname" class="form-control" data-rule-required="true">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Alternative Contact Email</label>
                          <input type="text" name="ac_email" class="form-control ac_email" id="ac_email"  data-rule-email="true" placeholder="Contact Email">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Alternative Contact Mobile</label>
                          <input type="text" name="ac_mobile" class="form-control ac_mobile" id="ac_mobile" data-rule-number="true" placeholder="Contact Mobile">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Owner Contact Person</label>
                          <input type="text" placeholder="Contact Person" name="ocname" class="form-control">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Owner Contact Email</label>
                          <input type="text" name="oc_email" class="form-control oc_email" id="oc_email"  data-rule-email="true" placeholder="Contact Email">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Owner Contact Mobile</label>
                          <input type="text" name="oc_mobile" class="form-control oc_mobile" id="oc_mobile" data-rule-number="true"  placeholder="Contact Mobile">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Country</label>
                          <select name="country" class="form-control search-box-open-up search-box-sel-all" id="ch_country" data-rule-required="true">
                          <option value="">Please Select</option>
                          <?php foreach ($countries as $key => $country) { ?>
                          <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                          <?php } ?>
                          </select>
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>State</label>
                          <select name="state" class="form-control sel_state select_box_sel" id="ch_state" data-rule-required="true">
                           <option value="">Please Select</option>                                       
                          </select>
                      </div>

                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                          <label>Town</label>
                          <input type="text" name="town" class="form-control" id="town" data-rule-required="true">
                      </div>
                      <div class="col-md-4 col-sm-6 col-xs-12">
                          <label>Profile Image</label>
                          <div class="input-group">
                              <label class="input-group-btn">
                                  <span class="btn btn-primary">
                                      Browse&hellip; <input type="file" name="pro" id="pro" class="form-control" data-rule-required="true" style="display: none;" multiple >
                                  </span>
                              </label>
                              <input type="text" class="form-control" readonly>
                          </div>
                      </div>
                    <div class="col-md-4 col-sm-6 col-xs-12">
                      <label>Brand Image</label>
                      <div class="input-group">
                          <label class="input-group-btn">
                              <span class="btn btn-primary">
                                  Browse&hellip; <input type="file" name="bri" data-rule-required="true" class="form-control" id="bri" style="display: none;" multiple>
                              </span>
                          </label>
                          <input type="text" class="form-control" readonly>
                      </div>
                    </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label>Address</label>
                        <textarea class="form-control" title="Address" name="address" rows="3" placeholder="Address" class="form-control" data-rule-required="true"></textarea>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label>Latitude*</label>
                        <input type="text" placeholder="Latitude" id="lat" name="latt" class="form-control" data-rule-required="true">
                    </div>
                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                        <label>Longitude*</label>
                        <input type="text" placeholder="Longitude" id="long" name="long" class="form-control" data-rule-required="true">
                    </div>

                    <div class="col-md-12">
                    <?php echo $map['html']; ?>
                    <br>
                    </div>
                                      
                    <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                        <div class="checkbox">
                          <label> <input type="checkbox"  name="isagree" data-rule-required="true" id="checkbox1" class=""> <p type="" class="" data-toggle="modal" data-target="#agree1"> Agree Terms and Condition</p> </label>
                        </div>
                        <div id="agree1" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                                <!-- Modal content-->
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal">X</button>
                                        <h4 class="modal-title">Modal Header</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                                            <div class="panel">
                                                <a class="panel-heading collapsed" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" style="color:#000">
                                                    <h4 class="panel-title">Collapsible Group Items #1</h4>
                                                </a>
                                                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                                    <div class="panel-body">
                                                        <table class="table table-bordered">
                                                            <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>First Name</th>
                                                                <th>Last Name</th>
                                                                <th>Username</th>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            <tr>
                                                                <th scope="row">1</th>
                                                                <td>Mark</td>
                                                                <td>Otto</td>
                                                                <td>@mdo</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">2</th>
                                                                <td>Jacob</td>
                                                                <td>Thornton</td>
                                                                <td>@fat</td>
                                                            </tr>
                                                            <tr>
                                                                <th scope="row">3</th>
                                                                <td>Larry</td>
                                                                <td>the Bird</td>
                                                                <td>@twitter</td>
                                                            </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel">
                                                <a class="panel-heading collapsed" role="tab" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo"  style="color:#000">
                                                    <h4 class="panel-title">Collapsible Group Items #2</h4>
                                                </a>
                                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                                    <div class="panel-body">
                                                        <p><strong>Collapsible Item 2 data</strong>
                                                        </p>
                                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor,
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="panel">
                                                <a class="panel-heading collapsed" role="tab" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree"  style="color:#000">
                                                    <h4 class="panel-title">Collapsible Group Items #3</h4>
                                                </a>
                                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
                                                    <div class="panel-body">
                                                        <p><strong>Collapsible Item 3 data</strong>
                                                        </p>
                                                        Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-primary antosubmit">Agree</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                       <!--  <button type="button" class="btn btn-primary channelsubmit" name="channelsubmit" id="channelsubmit">Save</button> -->
                        <input type="submit" class="btn btn-primary channelsubmit" name="channelsubmit" id="channelsubmit" value="Save">
                    </div>
                  </div>
              </form>
            </div>  
          </div>
          <?php  } ?>
          <!--========================= tab 9 end here =============================================-->
          <div>
            <div class="col-md-12 col-sm-12 col-xs-12">
              <div class="row wlletbg_prfile">
                <h1 class="profil_ttlt">
                  All Channel Partners
                </h1>
                <div id="no-more-tables2">
                  <div class="row">
                    <div class="col-sm-offset-7 col-sm-3">
                        <label class="pull-right">Search:</label>
                    </div>
                    <div class="col-sm-2">
                        <input type="text" class="form-control search" name="search" id="search3" placeholder="">
                    </div>
                  </div><br>
                  <table class="col-md-12 table-bordered table-condensed cf">
                    <thead class="cf">
                      <style>
                      .foo {
                        float: left;
                        width: 20px;
                        height: 20px;
                        margin: 5px;
                        border: 1px solid rgba(0, 0, 0, .2);
                      }

                      .green {
                        background:#aae6ab;
                      }
                      .blue {
                        background:blue;
                      }
                     .grey {
                        background:grey;
                      }
                      .red {
                        background:#efc3c3;
                      }
                      </style>
                      <tr>
                        <td colspan="3"></td>
                        <td>Active <div class="foo green"></div></td>
                        <td>Approved <div class="foo blue"></div></td>
                        <td>Not Approved <div class="foo grey"></div></td>
                        <td>Refered <div class="foo red"></div></td>
                      </tr>
                      <tr>
                        <th width="65px;">Sn No.</th>
                        <th>Name</th>
                        <th style="width: 20%;">Image</th>
                        <th>Mobile</th>
                        <th>Contact Person</th>
                        <th>Contact No</th>
                        <th width="200px">Action</th>
                      </tr>
                    </thead>
                    <tbody id="tbody3" style=" height:100px;overflow:scroll">
                        
                    </tbody>
                    <tfoot>
                        <td colspan="7">
                            <div class="pull-right" id="pagination3"></div>
                        </td>
                    </tfoot>
                  </table>
                </div>
              </div>         
            </div>  
          </div>
          <!--========================= tab 10 end here =============================================-->
          <?php  } ?>
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
<!-- Update refered friend details -->
<div id="addfrend_dtils" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">X</button>
        <h4 class="modal-title">Update Details</h4>
      </div>
      <form name="update_frnd_details" id="update_frnd_details" action="<?php echo base_url();?>user/Refer/update_refer" method="post">
      <div class="modal-body">
        <div class="prfl_trnsfr wlletbg_prfile tp_mar20 " style="overflow:hidden">
            <div class="form-group">
              <label>Name</label>
              <input type="text" class="form-control" value="" name="name" id="name">
              <input type="hidden" name="row_id" id="row_id" value="">
            </div>      
            <div class="form-group">
              <label>Mobile Number</label>
              <input type="text"  name="mobile" class="form-control" value="" id="mobile">
            </div> 
            <div class="form-group">
              <label>Location</label>
              <input type="text" class="form-control" placeholder="Enter Your Location" name="location" id="location" value="">
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <input class="button_submit3" data-toggle="modal" data-target="#success" type="submit" value="Upadate">
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
<script src="<?php echo base_url();?>assets/public/custom_js/datatable.js"></script>
<script>
  $('#oilfield').easyResponsiveTabs({
    type: 'vertical'
  });
</script> 
<!--=======================================slider right==============================================--> 
<script language="javascript" type="text/javascript">
  $(function () {
    $("#fileupload").change(function () {
      if (typeof (FileReader) != "undefined") {
        var dvPreview = $("#dvPreview");
        dvPreview.html("");
        var regex = /^([a-zA-Z0-9\s_\\.\-:])+(.jpg|.jpeg|.gif|.png|.bmp)$/;
        $($(this)[0].files).each(function () {
          var file = $(this);
          if (regex.test(file[0].name.toLowerCase())) {
              var reader = new FileReader();
              reader.onload = function (e) {
                  var img = $("<img />");
                  img.attr("style", "height:100px;width: 100px");
                  img.attr("src", e.target.result);
                  dvPreview.append(img);
              }
              reader.readAsDataURL(file[0]);
          } else {
              alert(file[0].name + " is not a valid image file.");
              dvPreview.html("");
              return false;
          }
        });
      } else {
          alert("This browser does not support HTML5 FileReader.");
      }
    });
  });
  $(document).ready(function () {
    var w = jQuery("#profile_form").validate({
      submitHandler: function(datas) {
        $('.body_blur').show();
        jQuery(datas).ajaxSubmit({
            dataType : "json",
            success  :    function(data)
            {
              $('.body_blur').hide();
              if(data.status){
                swal("Success!", "Profile updated successfully", "success");
                window.location = "<?php echo base_url();?>Home/profile";
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
                    swal("Success!", "Channel Partner added successfully", "success",{timer: 1500});
                    setTimeout(function(){
                        location.reload();
                    }, 1500);
                }
                else
                {
                  var regex = /(<([^>]+)>)/ig;
                  var body = data.reason;
                  var result = body.replace(regex, "");
                  swal("Warning!", result, "error");
                }
            }
        });
      }
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
  });
  $(document).ready(function () {
    $('#module').SumoSelect();
    $('.channel_type').SumoSelect({search: true, placeholder: 'select category',okCancelInMulti: true,triggerChangeCombined: false});
    $('#ch_country').SumoSelect({search: true, placeholder: 'select country'});
    $('#ch_state').SumoSelect({search: true, placeholder: 'select state'});
  });
  $(document).ready(function() {
    //set initial state.
    $('#textbox1').val($(this).is(':checked'));

    $('#checkbox1').change(function() {
      $('#textbox1').val($(this).is(':checked'));
    });

    $('#checkbox1').click(function() {
      if ($(this).is(':checked')) {
       // return confirm("Are you sure?");
        var box= confirm("Are you sure you want to do this?");
        if (box==true)
            return true;
        else
             document.getElementById('checkbox1').checked = true;
      }
    });
  /*   $('.btnOk').on('click', function () {
        //debugger;
        var obj = [],
        items = '';
            $('.channel_type option:selected').each(function (i) {
              obj.push($(this).val());
            });
            $.post('<?php echo base_url();?>Home/get_all_cptypes/',{obj :obj},
            function(data)
            {
                console.log(data);
                if(data.status)
                {
                    var data = data.data;
                    var commissiongroup = "";
                    for (var i = 0 ; i < data.length ; i++) {
                      commissiongroup += '<div class="col-md-12"><div class="col-md-6"><input type="text" name="category[]" class="form-control category" value="'+data[i].title+'"></div><div class="col-md-6"><input type="text" name="commission[]" class="form-control commission"></div></div>';
                    }
                   
                    $('.commissiongroup').html(commissiongroup);
                }else{
                }
            },'json');
    });*/
  });
  $(document).ready(function() {
    $(".gototop").click(function() {
        $("html, body").animate({"scrollTop": "0px"});
    });
  });
  $(document).ready(function() {
    /*$('#profile_form').ajaxForm({
      dataType:  'json',
      success:   function(data){
        if(data.status){
            swal("Success!", "Profile updated successfully", "success");
            window.location = "<?php echo base_url();?>Home/profile";
        } else {
           var regex = /(<([^>]+)>)/ig;
            var body = data.reason;
            var result = body.replace(regex, "");
            swal("Warning!", result, "error");
        }
      }
    });*/
    $('#edit_profile_form').ajaxForm({
      dataType:  'json',
      success:   function(data){
        if(data.status){
            swal("Success!", "Profile updated successfully", "success");
            window.location = "<?php echo base_url();?>Home/profile";
        } else {
           var regex = /(<([^>]+)>)/ig;
            var body = data.reason;
            var result = body.replace(regex, "");
            swal("Warning!", result, "error");
        }
      }
    }); 
  });
  $(document).on('change', '#ch_country',function(){
    var cur = $(this);
    var country = cur.val();
    $('.body_blur').show();
    $('#ch_state')[0].sumo.unload();
    $.post('<?php echo base_url();?>Register/get_state_by_id/'+country, function(data){
      $('.body_blur').hide();
      if(data.status)
      {
        var data = data.data;
        var option ='';
        option += '<option value="">Please Select</option>';
        for(var i=0; i<data.length; i++){
            option += '<option   value="'+data[i].id+'">'+data[i].name+'</option>';
        }
        $('#ch_state').html(option);
      } else{
        var regex = /(<([^>]+)>)/ig;
        var body = data.reason;
        var result = body.replace(regex, "");
        swal("Warning!", result, "error");
      }
      $('#ch_state').SumoSelect({search: true, placeholder: 'select state'});
    },'json');
  });
  //Change Password Start
  $(document).ready(function(){
      var chng_pwd = $("#chng_pwd").validate({
        rules: {
          opassword: {
              required: true
          },
          npassword: {
              required: true,
              minlength: 6
          },
          cpassword: {
              required: true,
              minlength: 6,
              equalTo: "#npassword"
          }
        },
        errorElement: "label",
        errorClass: "error",
        messages: {
          opassword: "Enter Old Password",
          npassword: {
              required: "Enter a New Password",
              minlength: jQuery.format("Enter at least {0} characters")
          },
          cpassword: {
              required: "Enter Confirm Password",
              minlength: jQuery.format("Enter at least {0} characters"),
              equalTo: "Please enter the same password as above"
          }
        }
      });
      var datas17 = { 
        dataType : "json",
        success:   function(data){
          $('.body_blur').hide();
          if(data.status){
            swal("Success!", "Password changed successfully", "success",{timer: 1500});
            setTimeout(function(){
              window.location.replace=base_url+"Home/profile";
            }, 1500);
          } else{
            
            swal("Warning!", common(data.reason), "error");
          }
        }
      };
      $('#chng_pwd').submit(function(e){     
        e.preventDefault();
        if (chng_pwd.form()) 
        {
          $('.body_blur').show();
          $(this).ajaxSubmit(datas17);  
        }          
      });
  });

  //Refered Friends Actions
  //delete
  $(document).on('click', '.del_refer_frnd', function () {
      var row_id = $(this).data('id');
      var cur = $(this);
      $.ajax({
          url:"<?php echo base_url(); ?>user/Refer/delete_refer",
          method:"POST",
          data:{row_id:row_id},
          success:function (data)
          {
              swal("Success!", "Referred Member Deleted Successfully.", "success",{timer: 1500});
              setTimeout(function(){
                  location.reload();
              }, 1500);
            
          }
      });
  });
  //update refer friend  Start
  $(document).on('click', '#update_frend_dtils', function () {
    var cur = $(this);
    var row_id = cur.data('id');
    var nam = cur.parent().parent().find('.nam').html();
    var mob = cur.parent().parent().find('.mob').html();
    var loc = cur.parent().parent().find('.loc').html();
    $('#addfrend_dtils').modal('show');
    $('#update_frnd_details').find('#name').val(nam);
    $('#update_frnd_details').find('#mobile').val(mob);
    $('#update_frnd_details').find('#location').val(loc);
    $('#update_frnd_details').find('#row_id').val(row_id);
    var up_form = '<?= base_url();?>user/Refer/update_refer';
    $("#update_frnd_details").attr("action", up_form);
  });
  var update_frnd_details = jQuery("#update_frnd_details").validate({
      rules: {
        mobile: {
            required: true
        }
      },
      messages: {
        mobile: {
            required: "Please provide mobile no. field"
        }
      },
      errorElement: "span",
      errorClass: "help-inline-error",
  });
  var datas17= { 
    dataType : "json",
    success:   function(data){
      $('.body_blur').hide();
      if(data.status){
        swal("Success!", "Updated successfully", "success",{timer: 1500});
        setTimeout(function(){
            location.reload();
        }, 1500);
      } else{
        
        swal("Warning!", common(data.reason), "error");
      }
    }
  };
  $('#update_frnd_details').submit(function(e){     
    e.preventDefault();
    if (update_frnd_details.form()) 
    {
      $('.body_blur').show();
      $(this).ajaxSubmit(datas17);  
    }          
  });
  //refer channel partner
  var refer_cp = jQuery("#refer_cp").validate({
      rules: {
        club_type: {
            required: true
        },
        name: {
            required: true
        },
        phone: {
            required: true
        },
        c_mobile:{
          required:true
        }

      },
      messages: {
        club_type: {
            required: "Please provide  Club Type field"
        },
        name: {
            required: "Please provide  Channel Partner field"
        },
        phone: {
            required: "Please provide  Contact field"
        },
        c_mobile: {
            required: "Please provide  Contact Mobile field"
        }
      },
      errorElement: "span",
      errorClass: "help-inline-error",
  });
  var datas18= { 
    dataType : "json",
    success:   function(data){
      $('.body_blur').hide();
      if(data.status){
        swal("Success!", "Refered Channel Partner added successfully", "success",{timer: 1500});
        setTimeout(function(){
            location.reload();
        }, 1500);
      } else{
        
        swal("Warning!", common(data.reason), "error");
      }
    }
  };
  $('#refer_cp').submit(function(e){     
    e.preventDefault();
    if (refer_cp.form()) 
    {
      $('.body_blur').show();
      $(this).ajaxSubmit(datas18);  
    }          
  });
  // Delete CA
  $(document).on('click', '.delet_ca', function () {
      var row_id = $(this).data('id');
      var cur = $(this);
      $.ajax({
          url:"<?php echo base_url(); ?>user/Profile/delete_ca",
          method:"POST",
          data:{row_id:row_id},
          success:function (data)
          {
              swal("Success!", "Club Agent Deleted Successfully.", "success",{timer: 1500});
              setTimeout(function(){
                  location.reload();
              }, 1500);
            
          }
      });
  });

  //Delete CP
    $(document).on('click', '.delet_cp', function () {
      var row_id = $(this).data('id');
      var cur = $(this);
      $.ajax({
          url:"<?php echo base_url(); ?>user/Profile/delete_cp",
          method:"POST",
          data:{row_id:row_id},
          success:function (data)
          {
              swal("Success!", "Channel Partner Deleted Successfully.", "success",{timer: 1500});
              setTimeout(function(){
                  location.reload();
              }, 1500);
            
          }
      });
  });
</script>
</body>
</html>
