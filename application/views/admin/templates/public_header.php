

<div class="body_blur" style="display: none"></div>
<header>
  <section>
    <div class="pos3">
      <div class="container-fluid">
        <div class="bgclr2 navbar navbar-inverse">
          <div class="row bordrbotm topbar">
            <div class="android2"> <a href="#" class="fnt1 border2"><i class="fa fa-android" aria-hidden="true"></i></a> <a href="#" class="fnt1"><i class="fa fa-apple" aria-hidden="true"></i></a></div>
            <div class="su_listnav">
              <ul>
                <div class="fllft_mmbr">
                  <?php
 $session_array = $this->session->userdata('logged_in_user');
        if($session_array == NULL){ ?>
                  <li> <a data-toggle="modal" type="button" data-target="#logincstmr" style="color:#000000;cursor: pointer;" class=""><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Login </span> <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <div id="logincstmr" class="modal fade" role="dialog">
                      <div class="modal-dialog mbrwdth">

                        <!-- Modal content-->
                        <div class="modal-content">

                          <div class="modal-body">
                            <div class="mbrwdth flleftlgn"> <?php if(!empty($authUrl)) { ?>
                              <a href="<?php echo $authUrl ?>">
                              <div class="fbbx_mbr"> <i class="fa fa-facebook pd2" aria-hidden="true"></i>Login with Facebook </div>
                              </a> 
                              <?php } ?>  <a href="">
                              <div class="gglbx_mbr"> <i class="fa fa-google-plus fntsz1 pd2 login_google_plus" aria-hidden="true"></i>Login with Google Plus </div>
                              </a>
                              <div class="or">
                                <p> Or </p>
                              </div>
                              <h5>Greenindia Account</h5>
                              <div class="logn_frrmbx">
                                <form name="website" action="" id="login_form" method="post">
                                  <input class="txt_bg3 validate[required]" name="username" type="text" placeholder="Username" />
                                  <input class="txt_bg3 validate[required]" name="password" type="password" placeholder="Password" />
                                  <div class="login_ckbx">
                                    <input type="checkbox" name="group2" id="checkbox-1">
                                    <label for="checkbox-1"><span class="checkbox">Remember me</span></label>
                                  </div>
                                  <button type="submit"  class="button_submit3 continue_login">continue</button>
                                </form>
                                <!-- <a class="frmlgn triggerforgot" href="">Forgot password?</a><br /> -->
                                <p class="frmlgn triggerforgot"><a href="#">forgot password</a></p>
                                <div class="forgot">
                                  <form name="forgot_pass" action="" id="forgot_pass" method="post">
                                    <input type="text" name="forgot_username" class="form-control" placeholder="Enter Username">
                                    <button type="submit"  class="button_submit3 forgot_btn">Send</button>
                                  </form>
                                </div>
                              </div>
                            </div>

                            <div class=" flrgttlgn">
                              <div class="or">
                                <p> Or </p>
                              </div>

                              <a  data-target="#loginmbr" data-toggle="modal" style="color:#000000;cursor: pointer;" class=""><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Create an account </span> </a>

                            </div>


                          </div>
                          <div class="modal-footer"> </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </div>
                <div class="fllft_mmbr">






                  <li><a  data-target="#loginmbr" data-toggle="modal" style="color:#000000;cursor: pointer;" class=""><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Be a Member </span> <i class="fa fa-caret-down" aria-hidden="true"></i></a>

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
                        <form name="website" action="" method="post" id="register_form">
                          <input class="txt_bg3 validate[required]" id="reg_mail" name="email" type="email" placeholder="E-mail" />
                          <input class="txt_bg3 validate[required]" id="reg_phone" name="phone" type="text" placeholder="Your Mobile No." />
                          <input type="password" name="password" class="txt_bg3 validate[required]"  placeholder="Password" id="password">
                          <input type="password" name="confirm_password" class="txt_bg3 validate[required,equals[password]]" placeholder="Confirm Password" id="confirm_password">

                          <div class="login_ckbx">
                            <input type="checkbox" class="validate[required]" name="accept" id="creat2">
                            <label for="creat2"><span class="checkbox">I Agree to the T & C</span></label>
                          </div>
                          <input class="button_submit3 btn_register" name="send" type="submit" value="Create Account" />
                          <p style="text-align:left;line-height:18px;font-size:12px;">(You will receive an message/e-mail containing the otp verification code.)</p>
                        </form>
                         <form name="website" action="" method="post" id="otp_form_reg">
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
                    <li><a  data-target="#ba" data-toggle="modal" style="color:#000000;cursor: pointer;" class=""><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Become  BA </span> <i class="fa fa-caret-down" aria-hidden="true"></i></a>

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
                                                <form name="ba_form" action="" method="post" id="ba_form">

                                                    <input class="txt_bg3 validate[required]" id="reg_mail" name="email" type="email" placeholder="E-mail" />
                                                    <input class="txt_bg3 validate[required]" id="reg_phone" name="phone" type="text" placeholder="Your Mobile No." />

                                                    <div class="login_ckbx">
                                                        <input type="checkbox" class="validate[required]" name="accept" id="creat2">
                                                        <label for="creat2"><span class="checkbox">I Agree to the T & C</span></label>
                                                    </div>
                                                    <input class="button_submit3"  name="send" id="ba_send" type="submit" value="Create Account" />
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



                    </li>
                </div>
                <?php } else{ ?>


                  <li> <a data-toggle="modal" type="button" data-target="#logincstmr" style="color:#000000;cursor: pointer;" class=""><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Money Transfer </span> <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <div id="logincstmr" class="modal fade" role="dialog">
                      <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">

                          <div class="modal-body">
                            <div class="">
                             <div class="logn_frrmbx">

                                <form name="transfer_form" method="post" id="transfer_form">
                                    <h5>Greenindia Eazy Transfer</h5>
                              <select id="wallet_ids" name="transfer_type" class="validate[required] form-control">
                                  <option value="">please select</option>
                                  <option value="<?php echo $vallet_type['reward_id'] ?>"><?php echo $vallet_type['reward_name'] ?></option>
                                  <option value="<?php echo $vallet_type['mywallt_id'] ?>"><?php echo $vallet_type['mywallet_name'] ?></option>
                              </select>
                                    <br>
                                    <div style="display: none" id="wallet_value">
                         wallet amound  :
                         <input class="txt_bg3" name="wallet" id="wallet" type="text" value="" />
                                    </div>

                              <div class="logn_frrmbx">



                                Enter Mobile :  <input class="txt_bg3 validate[required]" name="transfer_mobile" type="text" placeholder="Mobile" />
                                Enter Amount :  <input class="txt_bg3 validate[required]" name="transfer_amount" type="text" placeholder="Amount" />

                                  <input type="button" name="transfer_submit" id="transfer_submit" class="button_submit3 continue_login" value="continue">


                                <!-- <a class="frmlgn triggerforgot" href="">Forgot password?</a><br /> -->


                              </div>
                              </form>
                            </div>



                          </div>
                          <div class="modal-footer"> </div>
                             </div>
                           </div>
                         </div>

                  </li>
                  <?php $session_array = $this->session->userdata('logged_in_user');
                  if(isset($session_array)){ $type = $session_array['type'];
                  if($type='club_member'){ ?>
                  <li> <a data-toggle="modal" type="button" data-target="#transfer_modals" style="color:#000000;cursor: pointer;" class=""><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Add a Friend </span> <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <div id="transfer_modals" class="modal fade" role="dialog">
                      <div class="modal-dialog">
                        <div class="modal-content">
                         <div class="modal-body">
                            <div class="">
                             <div class="logn_frrmbx">
                                <form name="transfer_forms" method="post" id="transfer_forms">
                                <!-- wallet amound  : -->
                                <!-- <input class="txt_bg3 validate[required]" name="wallet" type="text" value="<?php echo $wallet1['amount']['total_value'];?>" /> -->
                                <h5>Add a Friend</h5>
                                <div class="logn_frrmbx">
                                <!-- Enter Mobile or Email :   -->
                                <input class="txt_bg3 validate[required]" name="name" type="text" placeholder="Name" />
                                <input class="txt_bg3 validate[required]" name="mail1" type="text" placeholder="Email id" />
                              
                                <input class="txt_bg3 validate[required]" name="mobile1" type="text" placeholder="Mobile number" />
                                <!--   <input class="txt_bg3 validate[required]" name="mail2" type="text" placeholder="Alternate Email id" />
                                <input class="txt_bg3 validate[required]" name="mobile2" type="text" placeholder="Alternate Mobile number" /> -->
                                <!-- Enter Email :  <input class="txt_bg3 validate[required]" name="transfer_amount" type="text" placeholder="Email" /> -->
                                          <input type="button" name="transfer_submit" id="transfer_submits" class="button_submit3 continue_login" value="continue">
                                        </div>
                                      </form>
                                    </div>
                                  </div>
                                <div class="modal-footer"> </div>
                             </div>
                           </div>
                         </div>
                        </li>
                        <?php } } ?>

                       <?php
 $session_array = $this->session->userdata('logged_in_user');
 $userid=$session_array['user_id'];
 $data['user']=$this->user_model->get_normal_customer($userid);

 // echo var_dump($data['user']);
// exit();
?>

 <li class="dropdown profldrp" style="padding:0px 5px"> <a href="<?php echo base_url() ?>user_profile" class="dropbtn"><img src="<?php echo base_url();?>uploads\<?= $data['user']['profile_image'];?>" class="profileimage" /> </a>
 <div class="dropdown-content prldropdownx">
    <a href="<?= base_url();?>home/profile"><i class="fa fa-user" aria-hidden="true"></i> Profile</a>
    <a href=""><i class="fa fa-cog" aria-hidden="true"></i> Account Settings</a>

    <div class="logoutbx">
    <a href="<?= base_url();?>user/login/logout"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>

    </div>

  </div>

 </li>


<!-- <li style="list-style:none;float:left;margin:0px 2px;border:none;text-align:center;padding:4px 10px;background-color:#6f4e0e;"><a href="<?= base_url();?>user/login/logout" style="color:#FFF"><i class="fa fa-sign-out" aria-hidden="true"></i><span class="icnspace"> Logout </span> </a>
  </li>-->

   <?php } ?>
                <div class="fllft_mmbr">
                  <li style="list-style:none;float:left;margin:0px 2px;border:none;text-align:center;padding:4px 10px;background-color:#6f4e0e;"><a href="<?= base_url();?>home/club_membership" style="color:#FFF"><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Be a Club Member </span> </a> </li>
                </div>
              </ul>
            </div>
          </div>
        </div>
        <div class="">
         
         <?php
 $session_array = $this->session->userdata('logged_in_user');
        if($session_array == NULL){ ?>
         <div class="row bordrbotm topbar2">
            <div class="fllft_club_mmbr">
              <li style="padding:10px 20px;"> <a data-toggle="collapse" data-target="#mobilelogin" class=""><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Login </span> <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                <div class="collapse topmnu" id="mobilelogin">
                  <ul>
                    <li><a data-target="#loginmbr" data-toggle="modal"><i class="fa fa-user icnspace" aria-hidden="true"></i> Login</a></li>
                    <li> <a href=""><i class="fa fa-user icnspace" aria-hidden="true"></i> Be a Member</a></li>
                    <li> <a href="<?= base_url();?>home/club_membership"><i class="fa fa-user icnspace" aria-hidden="true"></i> Be a Club Member</a></li>
                    <li> <a href="account.php"><i class="fa fa-user icnspace" aria-hidden="true"></i> Your Wallet</a></li>
                  </ul>
                </div>
              </li>
            </div>
            <div class="android2"> <a href="#" class="fnt1 border2"><i class="fa fa-android" aria-hidden="true"></i></a> <a href="#" class="fnt1"><i class="fa fa-apple" aria-hidden="true"></i></a></div>
          </div>
          <?php } 
		  else
		  
		  {?>
			  <div class="row bordrbotm topbar2">
            <div class="fllft_club_mmbr">
              <li style="padding:10px 20px;"> <a data-toggle="collapse" data-target="#mobilelogin" class=""><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Login </span> <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                <div class="collapse topmnu" id="mobilelogin">
                  <ul>
                    <li><a data-target="#loginmbr" data-toggle="modal"><i class="fa fa-user icnspace" aria-hidden="true"></i> Logout</a></li>
                    <li> <a href=""><i class="fa fa-user icnspace" aria-hidden="true"></i> Be a Member</a></li>
                    <li> <a href="<?= base_url();?>home/club_membership"><i class="fa fa-user icnspace" aria-hidden="true"></i> Be a Club Member</a></li>
                    <li> <a href="account.php"><i class="fa fa-user icnspace" aria-hidden="true"></i> Your Wallet</a></li>
                  </ul>
                </div>
              </li>
            </div>
            <div class="android2"> <a href="#" class="fnt1 border2"><i class="fa fa-android" aria-hidden="true"></i></a> <a href="#" class="fnt1"><i class="fa fa-apple" aria-hidden="true"></i></a></div>
          </div>			<?php  }?>
          
        </div>
        <div class="clear"></div>
        <div class="row">
          <div class="col-md-2 col-sm-4 col-xs-8"> <a href="<?= base_url();?>home"> <img src="<?= base_url();?>assets/public/images/online-portal-logo.png" alt="greenindia logo"> </a> </div>
          <div class="col-md-4 col-sm-6 col-xs-12">
           <!--  <form class="">
              <input type="button" value="" class="indxsearch">
              <input type="search" class="txsrch" placeholder="Search for a product, Brand, or Category">
            </form> -->
            <form class="">
            <input type="button" value="" class="indxsearch">
            <input type="search" id="search_data" class="txsrch" name="search_data" placeholder="Search for a product, Brand, or Category"  onkeyup="ajaxSearch();">
            </form>

                  <div class="drop_down search_dropdown">
                    <div class="col-lg-12">
                      <div class="col-lg-5 brdr_rght">

                            <!-- <h4 style="color: #042f6d;">Recent Searches</h4>
                            <div class="options">
                                                  <div id="suggestions">
                                                  <div id="autoSuggestionsList">
                                                  </div>
                                                  </div>
                            </div> -->
                                                  <div id="suggestions">
                                                  <div id="autoSuggestionsList">
                                                  </div>
                                                  </div>

                            <!-- <h4 style="color: #042f6d;">Popular Search</h4>
                            <div class="options">
                                                 <div id="suggestions2">
                                                 <div id="autoSuggestionsList2">
                                                 </div>
                                                 </div>
                            </div> -->
                                                 <div id="suggestions2">
                                                 <div id="autoSuggestionsList2">
                                                 </div>
                                                 </div>

                          <!--chanel partner sedarch  list -->
                          <div id="suggestions3">
                              <div id="autoSuggestionsList3">
                              </div>
                          </div>

                      </div>
                      <div class="col-lg-7">
                        <!-- <h4 style="color: #042f6d;">Popular Products</h4> -->
                                                    <div id="suggestions1">
                                                    <div id="autoSuggestionsList1">
                                                    </div>
                                                    </div>
                      </div>
                      <div class="col-lg-12">
                          <div class="col-lg-6">
                      <a href="get_all_delears/">
                          <h4 style="color: #042f6d; text-align: left;">View All Dealers</h4></a>
                              </div>
                          <div class="col-lg-6">
                          <a href="search/get_search_result/1">
                              <h4 style="color: #042f6d; text-align: right;">View All Products</h4>
                      </a>
                          </div>
                          </div>
                    </div>
                  </div>
<style>
.options{
 background-color:; margin:0px 20px;
 }
 .options p{
margin:0px;
 }
 .drop_down{
height:; width:105%; background-color:#fff; float:left; z-index: 9999; position: absolute; padding: 10px 0px 15px; border-top: 1px solid #ccc;    box-shadow: 1px 15px 25px -9px;
 }
 .brdr_rght{
 border-right:1px solid #ccc;
 }
.cart-entry{
  border-bottom:1px solid #f5f5f5;    padding: 5px;
 }
</style>
<script type="text/javascript">
    function ajaxSearch()
    {
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
                        $('#suggestions').show();
                        $('#autoSuggestionsList').addClass('auto_list');
                        $('#autoSuggestionsList').html(data);
                        }
                    }
                });
          // $('#suggestions').hide();
          }
          else
            {
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
                        $('#suggestions3').show();
                        $('#autoSuggestionsList').addClass('auto_list');
                        $('#autoSuggestionsList').html(data);
                        }
                    }
                });
              }

        var input_data = $('#search_data').val();

        if (input_data.length === 0)
          {
            var post_data = {
              'search_data': input_data,
              '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                };
              $.ajax({
              type: "POST",
              url: "<?php echo base_url(); ?>search/search_popular/",
              data: post_data,
              success: function (data) {
                    // return success
                    if (data.length > 0) {
                        $('#suggestions1').show();
                        $('#autoSuggestionsList1').addClass('auto_list');
                        $('#autoSuggestionsList1').html(data);
                        }
                    }
                });
          // $('#suggestions1').hide();
          }
          else
          {
              var post_data = {
              'search_data': input_data,
              '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
                };
              $.ajax({
              type: "POST",
              url: "<?php echo base_url(); ?>search/search_products/",
              data: post_data,
              success: function (data) {
                    // return success
                    if (data.length > 0) {
                        $('#suggestions1').show();
                        $('#autoSuggestionsList1').addClass('auto_list');
                        $('#autoSuggestionsList1').html(data);
                        }
                    }
                });
              }

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
                              $('#suggestions2').show();
                              $('#autoSuggestionsList2').addClass('auto_list');
                              $('#autoSuggestionsList2').html(data);
                              }
                          }
                      });
                // $('#suggestions1').hide();
                }
                else
                {
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
                              $('#suggestions2').show();
                              $('#autoSuggestionsList2').addClass('auto_list');
                              $('#autoSuggestionsList2').html(data);
                              }
                          }
                      });
                    }
        if (input_data.length === 0)
        {
            var post_data = {
                'search_data': input_data,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            };
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>search/search_chanelpartner/",
                data: post_data,
                success: function (data) {
                    // return success
                    if (data.length > 0) {
                        $('#suggestions3').show();
                        $('#autoSuggestionsList3').addClass('auto_list');
                        $('#autoSuggestionsList3').html(data);
                    }
                }
            });
            // $('#suggestions1').hide();
        }
        else
        {
            var post_data = {
                'search_data': input_data,
                '<?php echo $this->security->get_csrf_token_name(); ?>': '<?php echo $this->security->get_csrf_hash(); ?>'
            };
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>search/search_chanelpartner/",
                data: post_data,
                success: function (data) {
                    // return success
                    if (data.length > 0) {
                        $('#suggestions3').show();
                        $('#autoSuggestionsList3').addClass('auto_list');
                        $('#autoSuggestionsList3').html(data);
                    }
                }
            });
        }
    }
    </script>


          </div>
          <div class=" walltbx hidden-xs" style="float:right;">
          <?php
           if($session_array != NULL){ ?>
            <div class="billng" data-toggle="modal" data-target="#billing"> <a style="color:#FFF"><i class="fa fa-thumbs-up icnspace" aria-hidden="true"></i><span class="icnspace"> Billing </span> </a> </div>


            <div id="billing" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">X</button>
        <h4 class="modal-title">Modal Header</h4>

      </div>
      <div class="modal-body">
        <table class="" style="width:80%;margin:auto;">
        <tr>
          <form id="billing_form" action="" method="post">
          <input type="hidden" name="login_id" value="<?= $session_array['id'];?>">
        <td colspan="3" class="billngtomrgn">
        <select class="form-control error bgtotlbill validate[required]" name="channel_partner_con_id">
              <option value="">Select Shope</option>
             <?php foreach ($channel_partner as $key => $partner) { ?>
               <option value="<?= $partner['con_id'];?>"><?= $partner['name'];?>(<?= $partner['shope_type'];?>)</option>
            <?php } ?>
            </select>
            </td>
          <!-- <td colspan="1" class="billngtomrgn">
           <input type="text" name="total_bill_amount" class="form-control" placeholder="Bill Amount">
          </td> -->

            </tr>
        <tr>
        <th style="width:40%"></th>
        <th style="width:25%"></th>
        <th style="width:35%"></th>

        </tr>
        <tbody>

        <?php
           $color = array('billing_walletbg1', 'billing_walletbg2', 'billing_walletbg3');
             foreach ($wallet as $key => $wal) { ?>

            <tr>
              <td>
              <div class="billing_wallet walletchld3 <?php echo $color[$key];?>">
                  <div class="wlt"><?= $wal['title'];?></div>
                  <input type="hidden" name="wallet_id[]" class="form-control" size="16" value="<?= $wal['id'];?>">
                </div>
              </td>
              <td class="text-center">
                <p class="form-control-static current_rs"><?= round_number($wal['total_value']);?></p>

              </td>
              <td>
              <input type="text" name="price[]" class="form-control input_price" size="16" value="">

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
            <input type="text" id="sum_of_billing" name="sum_of_billing" class="form-control " size="16" value="">
          </th>
          <th><input type="submit" id="submit_billing" name="submit_billing" class="btn btn-primary pull-right" value="Submit"></th>
          </tr>
          </table>
          </form>
      </div>
    </div>

  </div>
</div>
          <?php } ?>


         <div class="dealbtn"> <a href="<?php echo base_url();?>home/show_deals" target="_blank" style="color:#FFF"><i class="fa fa-thumbs-up icnspace" aria-hidden="true"></i><span class="icnspace"> Get deals </span> </a> </div>
            <?php
            $session_array = $this->session->userdata('logged_in_user');
            if($session_array){

             $color = array('walletchld3', 'walletchld2', 'walletchld1', 'walletchld3');

             foreach ($wallet as $key => $wal) { ?>
               <div class="wallet <?php echo $color[$key];?>">
                <div class="wlt"><?= $wal['title'];?></div>
                <div class="amnt"><?= round_number($wal['total_value']);?></div>
          </div>

            <?php } } ?>
          </div>
        </div>
      </div>
    </div>
  </section>
</header>
<div class="indxhdrmartop">
<div class="">
  <div class="container-fluid">
      <div class="indxhdrmartop">
          <div class="">
              <div class="container-fluid  btmbdr">

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
                                        print_r($login_id);
                                    } } ?>
                                  </span>
                                  <span class="icon-bar"></span>
                                  <span class="icon-bar"></span>
                              </button>

                          </div>
                          <div class="collapse navbar-collapse js-navbar-collapse">
                              <ul class="nav navbar-nav">

                                <!--   <?php foreach($category['type'] as $type){ $pid = $type['id'];?> -->
                                    <li class="dropdown mega-dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo $type['title']; ?><span class="caret"></span></a>
                                        <ul class="dropdown-menu mega-dropdown-menu">
                                            <li class="col-sm-3">
                                                <ul>
                                                    <li class="dropdown-header">Men Collection</li>
                                                    <div id="menCollection" class="carousel slide" data-ride="carousel">
                                                        <div class="carousel-inner">

                                                            <?php foreach ($product['module'] as $key => $prods){
                                                              foreach ($prods['product'] as $key => $prod){
                                                            $act = $key == 0 ? 'active' : '';
                                                            ?>

                                                            <div class="item <?php echo $act;?>">
                                                                <a href="#"><img src="<?php echo base_url();?>assets\admin\products\<?php echo $prod['image'];?>" class="img-responsive" alt="product 1"></a>
                                                                <h4><small><?php echo $prod['name'];?> </small></h4>
                                                                <button class="btn btn-primary" type="button"><?php echo $prod['cost'];?> €</button>
                                                            </div><!-- End Item -->
                                                            <?php } ?>
                                                            <?php } ?>
                                                        </div><!-- End Carousel Inner -->
                                                        <!-- Controls -->
                                                        <a class="left carousel-control" href="#menCollection" role="button" data-slide="prev">
                                                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                                            <span class="sr-only">Previous</span>
                                                        </a>
                                                        <a class="right carousel-control" href="#menCollection" role="button" data-slide="next">
                                                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                                            <span class="sr-only">Next</span>
                                                        </a>
                                                    </div><!-- /.carousel -->
                                                    <li class="divider"></li>
                                                    <li><a href="#">View all Collection <span class="glyphicon glyphicon-chevron-right pull-right"></span></a></li>
                                                </ul>
                                            </li>
                                            <li class="col-sm-3">
                                                <ul>
                                                    <li class="dropdown-header"><?php echo $type['title']; ?></li>
                                                    <?php foreach($subcategory['type'] as $stype){
                                                    if($stype['parent']==$pid){ ?>
                                                        <li><a href="#"><?php echo $stype['title']; ?></a></li>
                                                        <?php } } ?>
                                                </ul>
                                            </li>
                                        </ul>
                                    </li>
                                  <!-- <?php } ?> -->


                              </ul>
                              <ul class="nav navbar-nav navbar-right">


                              </ul>
                          </div><!-- /.nav-collapse -->
                      </nav>
                  </div>


              </div>
          </div>

      </div>
</div>
</div>