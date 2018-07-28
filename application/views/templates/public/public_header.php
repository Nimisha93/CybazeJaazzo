<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
    #add_friend .form-group{
      margin-bottom: 0px;
    }
    .pointer{cursor:pointer;}
</style>
<script type="text/javascript">
  function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57))
        return false;
    return true;
  }
  function isFloatKey(e){
    if ((e.which != 46 || $(this).val().indexOf('.') != -1) && (e.which < 48 || e.which > 57))
        return false;
    return true;    
  }

</script>


<div class="body_blur" style="display: none"></div>
<header>
  <section>
    <div class="pos3">
      <div class="fulwidth">
        <div class="bgclr2 navbar navbar-inverse">
          <div class="row topbar">

            <div class="android2"> <a href="#" class="fnt1 border2"><i class="fa fa-android" aria-hidden="true"></i></a> <a href="#" class="fnt1"><i class="fa fa-apple" aria-hidden="true"></i></a></div>
            <div class="su_listnav">
              <ul>
                <div class="fllft_mmbr">
               
                  <?php
                    
                    $session_array1 = $this->session->userdata('logged_in_user');
                    $session_array2 = $this->session->userdata('logged_in_club_member');
                    $session_array3 = $this->session->userdata('logged_in_club_agent');
                    $datas = getLoginId();
                    if($datas){
                      $lid = $datas['login_id'];
                      $club_type_id = $datas['club_type_id'];
                      $fixed = isset($datas['fixed_type_id'])?$datas['fixed_type_id']:0;
                      $investor = isset($datas['investor_type_id'])?$datas['investor_type_id']:0;
                      $userid = $datas['user_id'];
                      $udetail = get_details_by_userid($userid);
                      $dateString=$udetail['created_on'];
                      $years = round((time()-strtotime($dateString))/(3600*24*365.25));
                    }
                    if($session_array1 == NULL && $session_array2 == NULL &&  $session_array3 == NULL ){  
                  ?> 
                 
                  <li> <a data-toggle="modal" type="button" data-target="#logincstmr" style=";cursor: pointer;" class=""><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Login </span></a>

                    <div id="logincstmr" class="modal fade" role="dialog">
                      <div class="modal-dialog mbrwdth">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">X</button>
                                <h4 class="modal-title">Login</h4>
                            </div>
                          <div class="modal-body">
                            <div class="mbrwdth flleftlgn"><?php if(!empty($authUrl)) { ?>
                              <a href="<?php echo $authUrl; ?>">
                              <div class="fbbx_mbr"> <i class="fa fa-facebook pd2" aria-hidden="true"></i>Login with Facebook </div>
                              </a> 
                              <?php } ?>
                              <a href="<?php echo base_url()?>Home/google_login">
                              <div class="gglbx_mbr"> <i class="fa fa-google-plus fntsz1 pd2 login_google_plus" aria-hidden="true"></i>Login with Google Plus </div>
                              </a>
                              <div class="or">
                                <p> Or </p>
                              </div>
                              <h5 class="log_frm">Jaazzo Account</h5>
                              <div class="logn_frrmbx">
                                <div class="log">
                                  <form name="website" action="<?php echo base_url()?>user/login/login_process" id="login_form" method="post">
                                    <input class="txt_bg3 validate[required]" name="username" type="text" placeholder="Username" />
                                    <input class="txt_bg3 validate[required]" name="password" type="password" placeholder="Password" />
                                   
                                    <button type="submit"  class="button_submit3 continue_login">Continue</button>
                                  </form>
                                  <form name="website" action="<?= base_url()?>user/login/validate_otp" method="post" id="otp_form_log">
                                  <input type="text" name="log_otp" class="txt_bg3 form-control validate[required]" id="log_otp" placeholder="Enter OTP Here">
                                  <input type="hidden" name="maill" id="maill" class="form-control"  >
                                  <input type="hidden" name="pasword" id="pasword" class="form-control"  >
                                   <input class="button_submit3 submit_log_otp" name="submit" type="submit" value="Continue" />
                                  </form>
                                </div>
                               
                                <p class="frmlgn triggerforgot"><a href="#">Forgot password</a></p>
                                <div class="forgot">
                                  <form name="forgot_pass" action="<?php echo base_url()?>user/login/forgot_password" id="forgot_pass" method="post">
                                    <input type="text" id="forgot_username" name="forgot_username" class="form-control" placeholder="Enter Username">
                                    <button type="submit"  class="button_submit3 forgot_btn">Send</button>
                                  </form>
                                </div>
                              </div>
                            </div>
                            <div class=" flrgttlgn">
                              <div class="or">
                                <p> Or </p>
                              </div>
                              <a class="btn button button_submit3" data-target="#loginmbr" data-toggle="modal" style="width: 100%;color: #fff;cursor: pointer;padding: 7px 11px 0px 11px;" class=""><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Create an account </span> </a>
                            </div>
                          </div>
                          <div class="modal-footer"> </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </div>
                <div class="fllft_mmbr">
                <?php if( $session_array2 == NULL &&  $session_array3 == NULL){?>
                  <li><a  data-target="#loginmbr" data-toggle="modal" style="cursor: pointer;" class=""><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Be a Member </span></a>
                    <div id="loginmbr" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">X</button>
                            <h4 class="modal-title">Be A  Member</h4>
                          </div>
                          <div class="modal-body">
                            <div class="mbrwdth_nrml_mmbr">
                              <h5>Create Account</h5>
                              <div class="logn_frrmbx">
                                 <form name="website" id="be_a_member" action="<?= base_url()?>register/new_customer" method="post">
                                  <input class="txt_bg3 validate[required]" id="first_name" name="first_name"  placeholder="First Name" />&nbsp;<span style="font-size: medium;color: red;">*</span>
                                  <input class="txt_bg3 validate[required]" id="last_name" name="last_name"  placeholder="Last Name" />
                                  <input class="txt_bg3 validate[required]" id="reg_mail" name="email" type="email" placeholder="E-mail" />
                                  <input class="txt_bg3" id="reg_phone" name="phone" placeholder="Mobile No"  type="number"  onKeyPress="return isNumberKey(event)"/>&nbsp;<span style="font-size: medium;color: red;">*</span>
                                  <input type="password" name="password" class="txt_bg3 validate[required]"  placeholder="Password" id="password">&nbsp;<span style="font-size: medium;color: red;">*</span>
                                  <input type="password" name="confirm_password" class="txt_bg3 validate[required,equals[password]]" placeholder="Confirm Password" id="confirm_password">&nbsp;<span style="font-size: medium;color: red;">*</span>

                                  <div class="login_ckbx">
                                    <input type="checkbox" class="validate[required]" name="accept" id="creat2">
                                  <label for="creat2"><span class="checkbox">I Agree to the<a style="    border-right: none;" href="<?= base_url()?>Term_condition" target="_blank">T & C</a></span></label>
                                  </div>
                                  <input class="button_submit3 btn_mem_register" name="send" type="submit" value="Create Account" style="line-height: 13px;"/>
                                  <p style="text-align:left;line-height:18px;font-size:12px;">(You will receive an message/e-mail containing the OTP verification code.)</p>
                                </form>
                                <form name="website" action="<?= base_url()?>register/validate_otp" method="post" id="otp_form_reg">
                                  <input type="text" name="reg_otp" class="txt_bg3 form-control validate[required]" id="reg_otp" placeholder="Enter OTP Here">
                                  <input type="hidden" name="email" id="email" class="form-control"  >
                                  <input type="hidden" name="mobile" id="mobile" class="form-control"  >
                                   <input class="button_submit3 submit_otp" name="submit" type="submit" value="Continue" />
                                </form>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                <?php } ?>
                 
                    <div id="ba" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                          <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">X</button>
                              <h4 class="modal-title">Become  BA</h4>
                          </div>
                          <div class="modal-body">
                            <div class="mbrwdth_nrml_mmbr">
                              <h5>Create Account</h5>
                              <div class="logn_frrmbx">
                                <form name="ba_form" action="<?php echo base_url(); ?>home/ba_mail" method="post" id="ba_form">
                                  <input class="txt_bg3" id="reg_mail" name="email" type="email" placeholder="E-mail" />
                                  <input class="txt_bg3" id="reg_phone" name="phone" type="number"  onKeyPress="return isNumberKey(event)" placeholder="Your Mobile No."   />
                                  <div class="login_ckbx">
                                      <input type="checkbox" class="" name="accept" id="creat2">
                                    <label for="creat2"><span class="checkbox">I Agree to the T & C</span></label>
                                  </div>
                                  <input class="button_submit3"  name="send" id="ba_send" type="submit" value="Send Request" />
                                  <p style="text-align:left;line-height:18px;font-size:12px;">(You will receive an message/e-mail containing the otp verification code.)</p>
                                </form>
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">

                          </div>
                        </div>
                      </div>
                    </div>
                </div>
                <?php } else{ ?>
                  <li> <a data-toggle="modal" type="button" data-target="#mnytrasfr" style="cursor: pointer;" class=""> Money Transfer </span> </a>
                    <div id="mnytrasfr" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">X</button>
                              <h4 class="modal-title">Jaazzo Easy Transfer</h4>
                          </div>
                          <div class="modal-body">
                            <div class="">
                              <div class="logn_frrmbx">
                                <form name="transfer_form" method="post" id="transfer_form" action="<?php echo base_url();?>user/Money_transfer/transfer_amount">
                                  Select Your Wallet :
                                  <select id="wallet_ids" name="transfer_type" class="form-control" style="width: 95%">
                                        <option value="">please select</option>
                                        <?php 
                                          foreach ($wallet as $key => $wal) { 
                                            if($wal['wallet_type_id']!='3' && $wal['wallet_type_id']!='5'){
                                        ?>
                                        <option value="<?php echo $wal['wallet_type_id'] ?>">
                                          <?php echo $wal['title'] ?></option>
                                        <?php }} ?>
                                        
                                  </select>
                                  <br>
                                  <div style="display: none" id="wallet_value">
                                    Wallet Amount  :
                                    <input class="txt_bg3" name="wallet" id="wallet" type="text" value="" />
                                  </div>
                                  <div class="logn_frrmbx">
                                    Enter Mobile :  <input class="txt_bg3" name="transfer_mobile" type="number"  onKeyPress="return isNumberKey(event)" placeholder="Mobile" />
                                    <br>
                                    Enter Amount :  <input class="txt_bg3 edit1" id="transfer_amount" name="transfer_amount" type="text" placeholder="Amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" />
                                    <input type="submit" name="transfer_submit" id="transfer_submit" class="button_submit3 continue_login" value="Continue">
                                  </div>
                                </form>
                              </div>
                            </div>
                            <div class="modal-footer"> </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </li>
                  <?php  
                      if((($session_array2['type']=='club_member')&&(($club_type_id>0 || $investor>0)&& $fixed==0 ))|| $session_array3['type']=='club_agent'){                         
                        //var_dump($session_array2);
                        if($session_array3['type']=='club_agent'){
                          $tit = 'Add a User';
                          $det = get_ca_facility_by_id($lid);
                          //var_dump($det);
                        }else{
                          $tit = 'Add a Friend';
                          $det = get_cmfacility_by_id($lid);//get_cm_facility_by_id($lid);
                          $year_limit =  $det['year_limit'];
                        }
                        if(isset($det['frnd_limit'])&&($det['frnd_limit']>$det['frnd_count'])){
                  ?>
                        <li> <a data-toggle="modal" type="button" data-target="#transfer_modals" style="cursor: pointer;" class=""><span class="icnspace"> <?php echo $tit;?></span> </a>
                        </li>
                  <?php }else if(($session_array2['type']=='club_member') && ($year_limit>=$years)&&isset($det['frnd_limit'])&&($det['frnd_limit']>$det['frnd_count'])){ ?>
                        <li> <a data-toggle="modal" type="button" data-target="#transfer_modals" style="cursor: pointer;" class=""><span class="icnspace"> <?php echo $tit;?></span> </a>
                        </li>
                  <?php } ?>
                          <div id="transfer_modals" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                  <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">X</button>
                                  <h4 class="modal-title"><?php echo $tit;?></h4>
                              </div>
                              <div class="modal-body">
                                  <div class="">
                                    <div class="logn_frrmbx">
                                      <form name="transfer_forms" action="<?php echo base_url();?>user/Refer/add_friend" method="post" id="add_friend">
                                      <!-- wallet amound  : -->
                                      <!-- <input class="txt_bg3 validate[required]" name="wallet" type="text" value="<?php echo $wallet1['amount']['total_value'];?>" /> -->
                                        <div class="logn_frrmbx">
                                          <!-- Enter Mobile or Email :   -->
                                          <div class="form-group">
                                            <label>Name</label>
                                            <input class="txt_bg3" name="name" type="text" placeholder="Name" />
                                          </div>
                                          <div class="form-group">
                                          <label>Email id</label>
                                          <input class="txt_bg3" name="mail1" type="text" placeholder="Email id" />
                                          </div>
                                          <div class="form-group">
                                          <label>Mobile number</label>
                                          <input class="txt_bg3" name="mobile1" type="number"  onKeyPress="return isNumberKey(event)" placeholder="Mobile number" style=" background-color: #fff;width:100%" />
                                          </div>
                                          <div class="form-group">
                                          <label>Location</label>
                                          <input class="txt_bg3" name="location" type="text"  placeholder="Location" />
                                          </div>
                                        
                                          <input type="submit" name="transfer_submit" id="transfer_submits" class="button_submit3 continue_login" value="Submit" style="padding: 0px;width: 100%;">
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                <div class="modal-footer"> </div>
                              </div>
                              </div>
                            </div>
                          </div>
                  <?php }
                        if(($session_array2['type']=='club_member')&&($session_array2['club_type_id']>0||$investor>0)){
                          
                          if(($year_limit>=$years)&&($det['ca_limit']>=$det['ca_count'])){
                  ?>
                        <li> <a data-toggle="modal" type="button" data-target="#club_agent_modals" style="cursor: pointer;" class=""><span class="icnspace"> Add a Club Agent </span> </a>
                        </li>
                          <div id="club_agent_modals" class="modal fade" role="dialog">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal">X</button>
                                  <h4 class="modal-title"> Add a Club Agent</h4>
                                </div>
                                <div class="modal-body">
                                  <div class="">
                                    <div class="logn_frrmbx">
                                      <form name="ca_forms" method="post" id="ca_forms" enctype="multipart/form-data"  action="<?php echo base_url(); ?>Home/add_club_agent">
                                        <div class="logn_frrmbx">
                                          <!-- Enter Mobile or Email :   -->
                                          <div class="row">
                                            <label>Name</label>
                                            <input class="txt_bg3" name="name" type="text" placeholder="Name" />
                                          </div>
                                          <div class="row">
                                            <label>Email Id</label>
                                            <input class="txt_bg3" name="mail" type="email" placeholder="Email Id" data-errormessage-value-missing="Email is required!"  data-errormessage-custom-error="Let me give you a hint: someone@nowhere.com" style="    background-color: #fff;width:100%"/>
                                          </div>
                                          <div class="row">
                                            <label>Mobile No</label>
                                            <input class="txt_bg3" name="mobile" type="number" placeholder="Mobile No" onKeyPress="return isNumberKey(event)"  data-errormessage-custom-error="Mobile no should be numeric value" style="    background-color: #fff;width:100%"/>
                                          </div>
                                          <div class="row">
                                            <label>Documents</label>
                                            <input class="txt_bg3 validate[required]" name="ufile" type="file" style="    background-color: #fff;width:100%;height: auto;"/>
                                          </div>
                                          <input type="submit" name="ca_submit" id="ca_submits" class="button_submit3 btn_save_ca" value="Submit" style="padding: 0px;width: 100%">
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                  <div class="modal-footer"> </div>
                                </div>
                              </div>
                            </div>
                          </div>
                  <?php   }
                  }

              
                  $datas = getLoginId();
                  if($datas){
                    $userid = $datas['user_id'];                  
                    $type = $datas['type'];
                    if($type=='normal_customer'){
                      $t = 'oilfield5';
                    }else if($type=='club_member'){
                      $t = 'oilfield6';
                    }else if($type=='club_agent'){
                      $t = 'oilfield6';
                    }
                  }
                  $data['user']=$this->user_model->get_normal_customer($userid);
                  $profile_image=(!empty($data['user']['profile_image']))?$data['user']['profile_image']:'profile.jpg';
                ?>
                  <li class="dropdown profldrp" style="padding:3px 5px;width: auto;font-size: 14px">&nbsp; Hi &nbsp;<?= isset($data['user']['name'])?$data['user']['name'].' !':''; ?><a href="<?php echo base_url() ?>user_profile" class="dropbtn"><img src="<?php echo base_url();?>uploads/<?= $profile_image;?>"  class="profileimage"/> </a>
                    <div class="dropdown-content prldropdownx">
                      <a href="<?= base_url();?>user_profile"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; Profile</a>
                      <a href="<?= base_url();?>user_profile#<?= $t ;?>" onclick="window.location.reload();"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp; Account Settings</a>
                      <div class="logoutbx">
                        <a href="<?= base_url();?>user/login/logout"><i class="fa fa-sign-out" aria-hidden="true"></i>&nbsp; Logout</a>
                      </div>
                    </div>
                  </li>

                <?php 
                } 
                if($session_array2 && ($session_array2['investor_type_id']==0)&&($session_array2['club_type_id']>=0)){//&& ($session_array2['investor_type_id']==0)
                ?>
                  <div class="fllft_mmbr">
                    <li style="list-style:none;float:left;margin:0px 2px;border:none;text-align:center;padding:4px 10px;background-color:#d8890b;"><a href="<?= base_url();?>home/club_membership" style="color:#FFF"><span class="icnspace"> Upgrade</span> </a> </li>
                  </div>
                <?php }elseif ($session_array1) { ?>
                  <div class="fllft_mmbr">
                    <li style="list-style:none;float:left;margin:0px 2px;border:none;text-align:center;padding:4px 10px;background-color:#d8890b;"><a href="<?= base_url();?>home/club_membership" style="color:#FFF"><span class="icnspace"> Be a Club Member </span> </a> </li>
                  </div>
                <?php  } ?>
              </ul>
            </div>
          </div>
        </div>
       <div class="">
          <?php 
            $datas = getLoginId();
              if($datas){
                $lid = $datas['login_id'];
            ?>
            <div class="row topbar2">
              <div class="fllft_club_mmbr">
                <li style="padding:10px 20px;">
                &nbsp; Hi &nbsp;<?= isset($data['user']['name'])?$data['user']['name'].' !':''; ?><a  data-toggle="collapse" data-target="#mobilelogin" class=""  aria-hidden="true"><img src="<?php echo base_url();?>uploads/<?= $profile_image;?>"  class="profileimage"/><i class="fa fa-caret-down" aria-hidden="true"></i> </a>
                  <div class="collapse topmnu" id="mobilelogin">
                    <ul>
                      <li><a href="<?= base_url();?>user_profile"><i class="fa fa-user" aria-hidden="true"></i>&nbsp; Profile</a></li>
                      <li><a href="<?= base_url();?>user_profile#<?= $t ;?>" onclick="window.location.reload();"><i class="fa fa-lock" aria-hidden="true"></i>&nbsp; Account Settings</a></li>
                      <?php
                      if($session_array2 && ($session_array2['investor_type_id']==0)&&($session_array2['club_type_id']>=0)){
                      ?>
                      <li> <a href="<?= base_url();?>home/club_membership"><i class="fa fa-user icnspace" aria-hidden="true"></i> Upgrade</a></li>
                      <?php }elseif ($session_array1) { ?>
                      <li> <a href="<?= base_url();?>home/club_membership"><i class="fa fa-user icnspace" aria-hidden="true"></i> Be a Club Member</a></li>
                      <?php } ?>
                      <li> <a href="<?= base_url();?>home/money_transfer"><i class="fa fa-suitcase icnspace" aria-hidden="true"></i>Money Transfer</a></li>
                      <li><a href="<?= base_url();?>user/login/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a></li>
                    </ul>
                  </div>
                </li>
              </div>
              <div class="android2"> <a href="#" class="fnt1 border2"><i class="fa fa-android" aria-hidden="true"></i></a> <a href="#" class="fnt1"><i class="fa fa-apple" aria-hidden="true"></i></a></div>
            </div>
            <?php } else {?>   
            <div class="row  topbar2">
              <div class="fllft_club_mmbr">
                <li style="padding:10px 20px;"> <a data-toggle="collapse" data-target="#mobilelogin" class=""><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Login </span> <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                  <div class="collapse topmnu" id="mobilelogin">
                    <ul>
                      <li><a href="<?= base_url();?>user_login"><i class="fa fa-lock icnspace" aria-hidden="true"></i> Login</a></li>
                      <li> <a href="<?= base_url();?>be_a_member"><i class="fa fa-user icnspace" aria-hidden="true"></i> Be a Member</a></li>
                    </ul>
                  </div>
                </li>
              </div>
              <div class="android2"> <a href="#" class="fnt1 border2"><i class="fa fa-android" aria-hidden="true"></i></a> <a href="#" class="fnt1"><i class="fa fa-apple" aria-hidden="true"></i></a></div>
            </div>   
            <?php  }?>
        </div>
        <div class="clear"></div>
        <div class="row headerbgclr" style="margin-left: 0;margin-right: 0">
          <div class="col-md-2 col-sm-3 col-xs-10"> <a href="<?= base_url();?>"> <img src="<?= base_url();?>assets/public/images/online-portal-logo.png" alt="Jaazzo logo"> </a> </div>

          
 <div class="col-md-2 col-sm-3 col-xs-5" style="margin-left: -15px;margin-right: -15px"> 
          <div class="">
              
<div id="imaginary_container">
 <form autocomplete="off" action="/action_page.php">
  <div class="autocomplete">
  <?php $session_location = $this->session->userdata('selected_location'); 
    if($session_location){ ?>
    <input id="hidden_location" type="hidden" value="<?= $session_location['id'];  ?>" name="hidden_location"> <?php 
    $location_name = $session_location['name'];
    $placeholder = $session_location['name'];
   }else{
   $location_name ="";
   $placeholder ="Search by location";
   }?>
       <!--<i class="fa fa-map-marker" aria-hidden="true"></i>-->
    <input id="myInput" type="text" name="myCountry" placeholder="<?= $placeholder; ?>" class="lctn" value="">
   
    <ul id="menu">
     
    </ul>
  </div>

</form>

</div>



<script type="text/javascript">
   
    
    $("html, body").click(function(e) {
        if ($(e.target).hasClass('autocomplete')) {
            return false;
        }
        $("#menu").html("");
    });

  $(document).on('change input','#myInput',function(){
    var keyword = $(this).val();
    var li = '<li class="each_location" value = "0"><a href="<?= base_url() ?>home/get_all_cp/all" >All Locations</a></li>';
     $.post('<?php echo base_url();?>search/search_location/',{keyword:keyword}, function(data){
        if(data.status){
            console.log(data.data);
            var res = data.data;
            for (var i = 0; i < res.length; i++) {
               li += '<li class= "each_location" value = "'+res[i].id+'"><a href="<?= base_url() ?>home/get_all_cp/'+res[i].id+'" >'+res[i].name+'</a></li>';
            }
        }else{
             li ='';
        }
         $('#menu').html(li);
    },'json');   
  });
  ////
  $(document).on('click','.each_location',function(){
    var id = $(this).val();
    var city = $(this).text();
    var li = "";
    $('#myInput').val(city);  
    $('#hidden_location').val(id);  
  });
</script>

    </div> </div>
          <div class="col-md-2 col-sm-4 col-xs-7">
            <div class="rowsu">
            <form class="serchjazzo" id="">
            
              <input type="search" id="search_data" class="txsrch" name="search_data" placeholder="Search by product"  onkeyup="ajaxSearch();">
              <input type="button" value="" class="indxsearch" id="indxsearch">

            </form>
            <div class="drop_down search_dropdown">
              <div class="col-lg-12">
                <div class="row33">
                  <div id="suggestions5">
                      <div id="autoSuggestionsList5">
                      </div>
                  </div>
                  <div id="suggestions">
                      <div id="autoSuggestionsList">
                      </div>
                  </div>

                 
                  <div id="suggestions2">
                      <div id="autoSuggestionsList2">
                      </div>
                  </div>

                  <!--chanel partner sedarch  list -->
                  <div id="suggestions3">
                      <div id="autoSuggestionsList3">
                      </div>
                  </div>
               
                  <div id="suggestions1">
                  <div id="autoSuggestionsList1">
                  </div>
                  </div>


                  <div id="suggestions4">
                  <div id="autoSuggestionsList4">
                  </div>
                  </div>
                                                

                  </div>
              
              </div>
            </div>
            <style>
              .options{
                  background-color:; margin:0px 0px;font-size:14px;
              }
              .options p{
                  margin:0px;
              }
              .drop_down{
                  height:500px;overflow:auto; width:92%; background-color:#fff; float:left; z-index: 9999; position: absolute; padding: 10px 0px 15px; border-top: 1px solid #ccc;    box-shadow: 1px 15px 25px -9px;display:none;
              }
              .brdr_rght{
                  border-right:1px solid #ccc;
              }
              .cart-entry{
                  border-bottom:1px solid #f5f5f5;    padding: 5px;
              }
              .dsnone{display:none;}
              @media (max-width:768px)
              {
                  .drop_down{
                      height:300px;
                  }
              }
            </style>


<script>
   $('body').click(function() {
   $('.search_dropdown').hide();
});

$('.search_dropdown').click(function(event){
   event.stopPropagation();
});
    
</script>
            <script type="text/javascript">
              function ajaxSearch()
              {
                //search channel partner
                var input_data = $('#search_data').val();

                  if (input_data.length === 0)
                  {
                      var post_data = {
                        'search_data': input_data,
                        '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                      };
                      $.ajax({
                        type: "POST",
                        url: "<?php echo base_url(); ?>search/search_popular_cp/",
                        data: post_data,
                        success: function (data) {
                            // return success
                          if (data.length > 0) {
                             $('.drop_down').show();
                            $('#suggestions5').show();
                            $('#autoSuggestionsList5').addClass('auto_list');
                            $('#autoSuggestionsList5').html(data);
                          }
                        }
                      });
                      // $('#suggestions1').hide();
                  }else {
                    var post_data = {
                      'search_data': input_data,
                      '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    };
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url(); ?>search/search_cp/",
                      data: post_data,
                      success: function (data) {
                          // return success
                        if (data.length > 0) {
                           $('.drop_down').show();
                          $('#suggestions5').show();
                          $('#autoSuggestionsList5').addClass('auto_list');
                          $('#autoSuggestionsList5').html(data);
                        }
                      }
                    });
                  }
                //end cp search
                //category search
                var input_data = $('#search_data').val();
                if (input_data.length === 0 )
                {
                  var post_data = {
                    'search_data': input_data,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                  };
                  $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>search/search_recent/",
                    data: post_data,
                    success: function (data) {
                        // return success
                      if (data.length > 0) {
                         $('.drop_down').show();
                          $('#suggestions').show();
                          $('#autoSuggestionsList').addClass('auto_list');
                          $('#autoSuggestionsList').html(data);
                      }
                    }
                  });
                    // $('#suggestions').hide();
                }else {
                  var post_data = {
                    'search_data': input_data,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                  };
                  $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>search/search_category/",
                    data: post_data,
                    success: function (data) {
                        // return success
                      if (data.length > 0) {
                         $('.drop_down').show();
                        $('#suggestions3').show();
                        $('#autoSuggestionsList3').addClass('auto_list');
                        $('#autoSuggestionsList3').html(data);
                      }
                    }
                  });
                }

                //search products

                var input_data = $('#search_data').val();

                if (input_data.length === 0)
                {
                    var post_data = {
                      'search_data': input_data,
                      '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    };
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url(); ?>search/search_popular1/",
                      data: post_data,
                      success: function (data) {
                          // return success
                        if (data.length > 0) {
                           $('.drop_down').show();
                          $('#suggestions2').show();
                          $('#autoSuggestionsList2').addClass('auto_list');
                          $('#autoSuggestionsList2').html(data);
                        }
                      }
                    });
                    
                }else {
                  var post_data = {
                    'search_data': input_data,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                  };
                  $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>search/search_products1/",
                    data: post_data,
                    success: function (data) {
                        // return success
                      if (data.length > 0) {
                         $('.drop_down').show();
                        $('#suggestions2').show();
                        $('#autoSuggestionsList2').addClass('auto_list');
                        $('#autoSuggestionsList2').html(data);
                      }
                    }
                  });
                }

                //search deals
                var input_data = $('#search_data').val();

                if (input_data.length === 0)
                {
                    var post_data = {
                      'search_data': input_data,
                      '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                    };
                    $.ajax({
                      type: "POST",
                      url: "<?php echo base_url(); ?>search/search_popular_deals/",
                      data: post_data,
                      success: function (data) {
                          // return success
                        if (data.length > 0) {
                           $('.drop_down').show();
                          $('#suggestions4').show();
                          $('#autoSuggestionsList4').addClass('auto_list');
                          $('#autoSuggestionsList4').html(data);
                        }
                      }
                    });
                    // $('#suggestions1').hide();
                }else {
                  var post_data = {
                    'search_data': input_data,
                    '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                  };
                  $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>search/search_deals/",
                    data: post_data,
                    success: function (data) {
                        // return success
                      if (data.length > 0) {
                         $('.drop_down').show();
                        $('#suggestions4').show();
                        $('#autoSuggestionsList4').addClass('auto_list');
                        $('#autoSuggestionsList4').html(data);
                      }
                    }
                  });
                } 
              }
              $("#indxsearch").click(function () {
                    key_word = $("#search_data").val();
                    if(key_word!=''){
                        //alert(key_word);
                        window.location.href = "<?= base_url(); ?>home/get_search_list/" + key_word;
                    }
              })


 
            </script>
           
            </div>
          </div>
          <div class=" walltbx hidden-xs" style="float:right;">
            <?php   
                $data = getLoginId();
                  if($data){
                    $login_id = $data['login_id'];
             ?>
            <div class="billng" data-toggle="modal" data-target="#billing"> <a style="color:#FFF"><i class="fa fa-thumbs-up icnspace" aria-hidden="true"></i><span class="icnspace"> Billing </span> </a> </div>
            <div id="billing" class="modal fade" role="dialog">
                <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal">X</button>
                      <h4 class="modal-title"> BILLING</h4>
                    </div>
                    <form id="billing_form" action="<?php echo base_url(); ?>user/purchase/give_notification" method="post">
                      <div class="modal-body">
                        <table class="" style="width:80%;margin:auto;">
                          <tr>
                              <input type="hidden" name="login_id" value="<?= $login_id;?>">
                              <td colspan="3" class="billngtomrgn">
                                <select class="form-control  bgtotlbill" name="channel_partner_id" id="channel_partner_id">
                                  <option value="">Select Shop</option>
                                  <?php foreach ($channel_partner as $key => $partner) { ?>
                                  <option value="<?= $partner['id'];?>"><?= $partner['name'];?></option>
                                  <?php } ?>
                                </select>
                              </td>
                          </tr>
                          <tr>
                            <th style="width:40%"></th>
                            <th style="width:25%"></th>
                            <th style="width:35%"></th>
                          </tr>
                          <tbody>
                            <?php
                                $color = array('billing_walletbg1', 'billing_walletbg2', 'billing_walletbg3', 'billing_walletbg4','billing_walletbg5');
                                foreach ($wallet as $key => $wal) { 
                            ?>
                                <tr>
                                  <td>
                                    <div class="billing_wallet walletchld3 <?php echo $color[$key];?>">
                                      <div class="wlt"><?= $wal['title'];?></div>
                                      <input type="hidden" name="wallet_id[]" class="form-control" size="16" value="<?= $wal['id'];?>">
                                    </div>
                                  </td>
                                  <td class="text-center">
                                    <p class="form-control-static current_rs"><?= $wal['total_value'];?></p>
                                    <input type="hidden" id="type" value="<?php echo $wal['wallet_type_id'];?>">
                                  </td>
                                  <td>
                                    <input type="text" name="price[]" class="form-control input_price" size="16" value="" onKeyPress="return isFloatKey(event)">
                                  </td>
                                </tr>
                            <?php }  ?>
                          </tbody>
                        </table>
                      </div>
                      <div class="modal-footer">
                        <table>
                          <tr class="billngtomrgn">
                            <th class="billngtotl">
                              Total
                            </th>
                            <th class="billngtotl">
                              <input type="text" id="sum_of_billing" name="sum_of_billing" class="form-control " size="16" value="" readonly="">
                            </th>
                            <th>
                              <input type="submit" id="submit_billing" name="submit_billing" class="btn btn-primary pull-right" value="Submit">
                            </th>
                          </tr>
                        </table>
                      </div>
                    </form>
                  </div>
                </div>
            </div>
            <?php } ?>
            <div class="dealbtn"> <a href="<?php echo base_url();?>home/get_all_deals" target="_blank" style="color:#FFF"><i class="fa fa-thumbs-up icnspace" aria-hidden="true"></i><span class="icnspace"> Get deals </span> </a> </div>
              <?php 
              //$session_array = $this->session->userdata('logged_in_user');
                // if($session_array){
                  $data = getLoginId();
                  if($data){
                    $userid = $data['user_id'];
                    $udetail = get_details_by_userid($userid);
                    $dateString=$udetail['created_on'];
                    $color = array('walletchld3', 'walletchld2', 'walletchld1', 'walletchld3');
                    foreach ($wallet as $key => $wal) { 
                        if($wal['wallet_type_id']==1 && $data['type']=='club_member'){
                          $ctype = ($data['investor_type_id']>0)?$data['investor_type_id']:$data["club_type_id"];
                          $det = getClubtypeById($ctype);
                          $year_limit = $det['cash_limit'];
                          $years = round((time()-strtotime($dateString))/(3600*24*365.25));
                          if($year_limit>=$years){
              ?>
                            <div class="wallet <?php echo $color[$key];?>">
                              <div class="wlt"><?= $wal['title'];?></div>
                              <div class="amnt"><?= $wal['total_value'];?></div>
                            </div>
              <?php
                          }
                          
                          // $data["club_type_id"]
                          // $data["fixed_club_type_id"]
                          // $data["investor_type_id"]
                        }
                        if($wal['wallet_type_id']==5){
                          if(isset($data["fixed_club_type_id"])){
                            $det = getClubtypeById($data["fixed_club_type_id"]);
                            $year_limit = $det['cash_limit'];
                            $years = round((time()-strtotime($dateString))/(3600*24*365.25));
                            if($year_limit>=$years){
              ?>
                            <div class="wallet <?php echo $color[$key];?>">
                              <div class="wlt"><?= $wal['title'];?></div>
                              <div class="amnt"><?= $wal['total_value'];?></div>
                            </div>
              <?php              // $active2 = 1;
                            }
                          }
                          // $data["club_type_id"]
                          // $data["fixed_club_type_id"]
                          // $data["investor_type_id"]
                        }else if($wal['wallet_type_id']==2||$wal['wallet_type_id']==3||$wal['wallet_type_id']==4){
              ?>

                          <div class="wallet <?php echo $color[$key];?>">
                            <div class="wlt"><?= $wal['title'];?></div>
                            <div class="amnt"><?= $wal['total_value'];?></div>
                          </div>
              <?php
                        }
              ?>
              <?php   } 
                    } 
                ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</header>
<div class="indxhdrmartop">
<div class="">
  <div class="fulwidth">
      <div class="indxhdrmartop">
          <div class="">
              <div class="fulwidth  btmbdr">

                  <div class="">
                      <nav class="navbar navbar-inverse">
                          <div class="navbar-header">
                              <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                                  <span class="sr-only">Toggle navigation</span>
                                  <span class="icon-bar">
                                    <?php $a=1; if($a==1){
                                    $session_array = $this->session->userdata('logged_in_user');
                                    if(isset($session_array)){
                                        $login_id = $session_array['id'];
                                        //print_r($login_id);
                                    } } ?>
                                  </span>
                                  <span class="icon-bar"></span>
                                  <span class="icon-bar"></span>
                              </button>

                          </div>
                          <div class="collapse navbar-collapse js-navbar-collapse">
                              <ul class="nav navbar-nav">

                                   <?php foreach ($get_menu['main_category'] as $key => $main_category){

                                          if($key=="8")
                                          {
                                            break;
                                          }
                                    ?> 
                                    <li class="dropdown mega-dropdown">
                                        <a href="<?= base_url();?>home/get_all_products_cat_wise/<?php echo $main_category['id']; ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo $main_category['title']; ?><span class="caret"></span></a>
                                        <ul class="dropdown-menu mega-dropdown-menu">

                                                <ul class="divsion">

                                                    <?php foreach ($main_category['category'] as $key => $category){ ?>
                                                        <li class="col-sm-3"><a class="dropdown-header" href="<?= base_url();?>home/get_all_products_cat_wise/<?php echo $category['cat_id']; ?>"><?php echo $category['cat_name']; ?></a>
                                                            <ul class="divsion">
                                                            <?php foreach ($category['sub_cat'] as $key => $sub_cat) {
                                                                ?>
                                                                    <li><a href="<?= base_url();?>home/get_all_products_cat_wise/<?php echo $sub_cat['sub_cat_id']; ?>"><?php echo $sub_cat['sub_cat_name']; ?></a></li>
                                                                <?php } ?>
                                                            </ul>
                                                        </li>
                                                        <?php } ?>
                                                </ul>

                                        </ul>
                                    </li>
                                   <?php } ?> 


                              </ul>
            <?php foreach ($get_menu['main_category'] as $key1 => $main_category){  


            }
if($key1>=9)
{
            ?>                 



              <ul class="nav navbar-nav navbar-right">

     <ul class="nav navbar-nav moremnu">

      
        <li class="dropdown">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown" > <i class="fa fa-ellipsis-v" style="font-size:24px;margin-top: 8px"></i></a>
          <ul class="dropdown-menu">
            <?php foreach ($get_menu['main_category'] as $key => $main_category){
                                          if($key>=9)
                                          {
                                            ?>
                                                  <div class="panel-group" id="accordion<?php echo $main_category['id']; ?>">
        <div class="panel panel-default">
          <div class="panel-heading">
           
               <a  style=" font-size: 14px;color: #000; padding-left: 0px !important; line-height: 22px;text-transform: uppercase; font-weight: 600;" accordion-toggle" data-toggle="collapse" data-parent="#accordion<?php echo $main_category['id']; ?>" href="#accordion<?php echo $main_category['id']; ?>_1" href="<?= base_url();?>home/get_all_products_cat_wise/<?php echo $main_category['id']; ?>"><li><?php echo $main_category['title']; ?>  
                <i class="fa fa fa-caret-down pull-right" aria-hidden="true"></i></li></a>
          
          </div>
          <div id="accordion<?php echo $main_category['id']; ?>_1" class="panel-collapse collapse">
          <ul class="">

           <?php 

if($main_category['category']!=NULL)
{



           foreach ($main_category['category'] as $key => $category){ ?>
   <a  style=" font-size: 12px;color: #000; padding-left: 0px !important; line-height: 30px;text-transform: uppercase; font-weight: 600;"  href="<?= base_url();?>home/get_all_products_cat_wise/<?php echo $category['cat_id']; ?>"><li><?php echo $category['cat_name']; ?></li></a>


 <?php foreach ($category['sub_cat'] as $key => $sub_cat) {
                                                                ?>

<a  href="<?= base_url();?>home/get_all_products_cat_wise/<?php echo $sub_cat['sub_cat_id']; ?>"><li><?php echo $sub_cat['sub_cat_name']; ?></li></a>

<?php } ?>


            

                <?php }}

                else{ ?>
                  <a     href=""><li> &nbsp;&nbsp;&nbsp;No sub categories</li></a>

                <?php  } ?>
          </ul>
          </div>
        </div>
       
     
      </div>

            <li class="divider"></li><?php
                                          }



                                         
                                          

                                    ?>

        
            <?php } ?> 
          </ul>
        </li>
      </ul>
                              </ul>


                              <?php } ?>
                          </div><!-- /.nav-collapse -->
                      </nav>
                  </div>


              </div>
          </div>

      </div>
</div>
</div>
<script type="text/javascript">
  $(document).ready(function(){
    $('#more').click(function(e){
        e.preventDefault();
       $('#more_div').show();
    });
    $('#channel_partner_id').SumoSelect({'search':true});
  });
  
   
</script>

<style type="text/css">
  .moremnu .dropdown-menu{
    min-width: 250px;
  }

  
  .moremnu .panel-heading{
    min-width: 250px;
  }
  
   .moremnu .panel-default > .panel-heading,  .moremnu .panel
   {
    border: none;
    box-shadow: none;
   }

   .moremnu .panel-heading
   {
    padding: 2px 5px
   }

   .moremnu .panel-collapse ul li
   {
list-style: none;
line-height: 22px;
padding-left: 20px;
opacity: .8
   }

 .moremnu .panel-collapse ul li:hover
   {
list-style: none;
line-height: 22px;
padding-left: 20px;
opacity: 1
   }

 .moremnu .panel-group {
    margin-bottom: 0px;
}

</style>