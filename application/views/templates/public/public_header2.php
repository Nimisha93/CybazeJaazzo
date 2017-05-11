<div id="otp_model" class="modal fade" role="dialog">
  <div class="modal-dialog"> 
    
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">X</button>
        <h4 class="modal-title">Enter OTP Here</h4>
      </div>
      <form id="otp_form_reg" method="post">
        <div class="modal-body">
          <input type="text" name="reg_otp" class="form-control" id="reg_otp">
          <input type="hidden" name="email" id="email" class="form-control"  >
          <input type="hidden" name="mobile" id="mobile" class="form-control"  >
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-success submit_otp">Submit</button>
        </div>
      </form>
    </div>
  </div>
</div>
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
                <div class="dropdown fllft_mmbr">
                  <?php
 $session_array = $this->session->userdata('logged_in_user');
   //     if(isset($session_array)){ ?>
                  <li> <a data-toggle="modal" type="button" data-target="#logincstmr" style="color:#000000;cursor: pointer;" class=""><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Login </span> <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                    <div id="logincstmr" class="modal fade" role="dialog">
                      <div class="modal-dialog mbrwdth"> 
                        
                        <!-- Modal content-->
                        <div class="modal-content">
                         
                          <div class="modal-body">
                            <div class="mbrwdth flleftlgn"> <a href="">
                              <div class="fbbx_mbr"> <i class="fa fa-facebook pd2" aria-hidden="true"></i>Login with Facebook </div>
                              </a> <a href="">
                              <div class="gglbx_mbr"> <i class="fa fa-google-plus fntsz1 pd2" aria-hidden="true"></i>Login with Google Plus </div>
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
                             
                              <a  data-target="#loginmbr" data-toggle="modal" style="color:#000000;cursor: pointer;" class=""><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Be a Member </span> <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                             
                            </div>
                            
                            
                          </div>
                          <div class="modal-footer"> </div>
                        </div>
                      </div>
                    </div>
                  </li>
                </div>
                <div class="dropdown fllft_mmbr">
                
                
              



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
                          <input class="txt_bg3 validate[required]" name="email" type="email" placeholder="E-mail" />
                          <input class="txt_bg3 validate[required]" name="phone" type="text" placeholder="Your Mobile No." />
                          <input type="password" name="password" class="txt_bg3 validate[required]" placeholder="Password" id="password">
                          <input type="password" name="confirm_password" class="txt_bg3 validate[required,equals[password]]" placeholder="Confirm Password" id="confirm_password">
                          <!-- <div class="login_ckbx">
      <input type="checkbox" class="validate[required]" name="remember_me" id="creat1">
      <label for="creat1"><span class="checkbox">Remember me</span></label>
    </div> -->
                          <div class="login_ckbx">
                            <input type="checkbox" class="validate[required]" name="accept" id="creat2">
                            <label for="creat2"><span class="checkbox">I Agree to the T & C</span></label>
                          </div>
                          <input class="button_submit3 btn_register" name="send" type="submit" value="Create Account" />
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
                <?php// } ?>
                <div class="dropdown fllft_mmbr">
                  <li style="list-style:none;float:left;margin:0px 2px;border:none;text-align:center;padding:4px 10px;background-color:#6f4e0e;"><a href="club-member.php" style="color:#FFF"><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Be a Club Member </span> </a> </li>
                </div>
              </ul>
            </div>
          </div>
        </div>
        <div class="bgclr2">
          <div class="row bordrbotm topbar2">
            <?php
 $session_array = $this->session->userdata('logged_in_user');
        if(isset($session_array)){ ?>
            <div class="fllft_club_mmbr">
              <li style="padding:10px 20px;"> <a  data-toggle="collapse" data-target="#mobilelogin" class=""><i class="fa fa-user icnspace" aria-hidden="true"></i><span class="icnspace"> Login </span> <i class="fa fa-caret-down" aria-hidden="true"></i></a>
                <div class="collapse topmnu" id="mobilelogin" >
                  <ul>
                    <li><a href=""><i class="fa fa-user icnspace" aria-hidden="true"></i> Login</a></li>
                    <li> <a href=""><i class="fa fa-user icnspace" aria-hidden="true"></i> Be a Member</a></li>
                    <li> <a href="club-member.php"><i class="fa fa-user icnspace" aria-hidden="true"></i> Be a Club Member</a></li>
                    <li> <a href="account.php"><i class="fa fa-user icnspace" aria-hidden="true"></i> Your Wallet</a></li>
                  </ul>
                </div>
              </li>
            </div>
            <div class="android2"> <a href="#" class="fnt1 border2"><i class="fa fa-android" aria-hidden="true"></i></a> <a href="#" class="fnt1"><i class="fa fa-apple" aria-hidden="true"></i></a></div>
          </div>
          <?php } ?>
        </div>
        <div class="clear"></div>
        <div class="row">
          <div class="col-md-2 col-sm-5 col-xs-8"> <a href="<?= base_url();?>home"> <img src="<?= base_url();?>assets/public/images/online-portal-logo.png" alt="greenindia logo"> </a> </div>
          <div class="col-md-3 col-sm-7 col-xs-12">
            <form class="">
              <input type="button" value="" class="indxsearch">
              <input type="search" class="txsrch" placeholder="Search for a product, Brand, or Category">
            </form>
          </div>
          <div class="col-md-7 walltbx hidden-xs">
            <div class="dealbtn"> <a href="get-deal.php" target="_blank" style="color:#FFF"><i class="fa fa-thumbs-up icnspace" aria-hidden="true"></i><span class="icnspace"> Get deals </span> </a> </div>
              <div class="dealbtn"> <a href="get-deal.php" target="_blank" style="color:#FFF"><i class="fa fa-thumbs-up icnspace" aria-hidden="true"></i><span class="icnspace"> Get deals </span> </a> </div>
            
            <div class="wallet walletchld3">
              <div class="wlt">Club Wallet</div>
              <div class="amnt">0.00</div>
            </div>
            <div class="wallet walletchld2">
              <div class="wlt">My Wallet</div>
              <div class="amnt">0.00</div>
            </div>
            <div class="wallet walletchld1">
              <div class="wlt">Reward Wallet</div>
              <div class="amnt">0.00</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</header>
<div class="indxhdrmartop">
<div class="">
  <div class="container-fluid bm_mar10 btmbdr">
    <nav id="ddmenu">
      <div class="menu-icon"></div>
      <ul>
        <li class="full-width"> <span class="top-heading">sumesh</span> <i class="caret"></i>
          <div class="dropdown">
            <div class="dd-inner">
              <ul class="column">
                <li>
                  <h3>Lorem Ipsum</h3>
                </li>
                <li><a href="#">Sed interdumSed interdumSed interdumSed interdum</a></li>
                <li><a href="#">Consectetur elit</a></li>
                <li><a href="#">Etiam massa</a></li>
                <li><a href="#">Suscipit sapien</a></li>
                <li><a href="#">Quis turpis</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>sumesh Massa</h3>
                </li>
                <li><a href="#">Sed interdum</a></li>
                <li><a href="#">Fringilla congue</a></li>
                <li><a href="#">Dolor nisl auctor</a></li>
                <li><a href="#">Quisque dictum</a></li>
                <li><a href="#">Porttitor</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>new name Massa</h3>
                </li>
                <li><a href="#">Sed interdum</a></li>
                <li><a href="#">Fringilla congue</a></li>
                <li><a href="#">Dolor nisl auctor</a></li>
                <li><a href="#">Quisque dictum</a></li>
                <li><a href="#">Porttitor</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>Etiam Massa</h3>
                </li>
                <li><a href="#">Sed interdumSed interdumSed interdum</a></li>
                <li><a href="#">Fringilla congue</a></li>
                <li><a href="#">Dolor nisl auctor</a></li>
                <li><a href="#">Quisque dictum</a></li>
                <li><a href="#">Porttitor</a></li>
              </ul>
            </div>
          </div>
        </li>
        <li class="no-sub"><a class="top-heading" href="http://www.google.com">Quisque</a></li>
        <li class="full-width"> <a class="top-heading" href="http://www.microsoft.com">Link</a> <i class="caret"></i>
          <div class="dropdown">
            <div class="dd-inner">
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
            </div>
          </div>
        </li>
        <li class="full-width"> <a class="top-heading" href="http://www.microsoft.com">Link</a> <i class="caret"></i>
          <div class="dropdown">
            <div class="dd-inner">
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
            </div>
          </div>
        </li>
        <li class="full-width"> <a class="top-heading" href="http://www.microsoft.com">Link</a> <i class="caret"></i>
          <div class="dropdown">
            <div class="dd-inner">
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
            </div>
          </div>
        </li>
        <li class="full-width"> <a class="top-heading" href="http://www.microsoft.com">Link</a> <i class="caret"></i>
          <div class="dropdown">
            <div class="dd-inner">
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
            </div>
          </div>
        </li>
        <li class="full-width"> <a class="top-heading" href="http://www.microsoft.com">Link</a> <i class="caret"></i>
          <div class="dropdown">
            <div class="dd-inner">
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
              <ul class="column">
                <li>
                  <h3>Vestibulum Ut</h3>
                </li>
                <li><a href="#">Nunc pharetra</a></li>
                <li><a href="#">Vestibulum ante</a></li>
                <li><a href="#">Nulla id laoreet</a></li>
                <li><a href="#">Elementum blandit</a></li>
              </ul>
            </div>
          </div>
        </li>
      </ul>
    </nav>
  </div>
</div>
