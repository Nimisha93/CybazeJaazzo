<?= $default_assets;?>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/style-grid.css" />
    <noscript>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/fallback.css" />
    </noscript>
    <script type="text/javascript" src="<?= base_url();?>assets/public/js/modernizr.custom.26633.js"></script>
    <style type="text/css">
    .row{margin:0;}
    .goToTop{position:fixed;border-bottom:1px solid #000;z-index: 17;}
    @media (max-width:1030px){
    .goToTop{height:auto;position:relative;}
    }
    @media (max-width:767px){
        .goToTop {
        position: relative;
        top: 0;
        left: 0;
        z-index: 10;
          background-color: #1a4794;
      }
    }
    .form-control1{
      display: block;
        width: 100%;
        height: 34px;
        padding: 6px 12px;
        font-size: 13px;
        line-height: 1.42857143;
        color: #555;
        background-color: #fff;
        background-image: none;
        border: 1px solid #ccc;
        border-radius: 4px;
        -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);}

        .mbrwdth {
    width: 278px;
    z-index: 1;
    top: 2px;
    padding: 30px 20px;
    position: relative;
    background-color: #fff;
    border: 1px solid #d0cece;
    right: 5px;
    margin-right: 10px;
}

  </style>
</head>
<body>
<!--===========header end here ========================-->
<?= $header;?>
 <header>
      <div class="container-fluid" >
      </div>
      </div>
    </div>
  </div>
</header>
<!--===========header end here ========================-->
<div class="clear"></div>
</div>
<section class="top_pad20 botm_pad20">
  <div class="container tp_mar20">
    <div class="">
      <div class="cusmragnt" style="width: 300px;margin: auto;">
        <div class="mbrwdth flleftlgn"><?php if(!empty($authUrl)) { ?>
          <a href="<?php echo $authUrl ?>">
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
                <input class="txt_bg3 validate[required]" name="password" type="password" placeholder="Password" style="width:100%" />
                <!-- <div class="login_ckbx">
                  <input type="checkbox" name="group2" id="checkbox-1">
                  <label for="checkbox-1"><span class="checkbox">Remember me</span></label>
                </div> -->
                <button type="submit"  class="button_submit3 continue_login" style="width:100%">Continue</button>
              </form>
            </div>
            <!-- <a class="frmlgn triggerforgot" href="">Forgot password?</a><br /> -->
            <p class="frmlgn triggerforgot"><a href="#">Forgot password ?</a></p>
            <div class="forgot">
              <form name="forgot_pass" action="<?php echo base_url()?>user/login/forgot_password" id="forgot_pass" method="post">
                <input type="text" id="forgot_username" name="forgot_username" class="form-control" placeholder="Enter Username">
                <button type="submit"  class="button_submit3 forgot_btn">Send</button>
              </form>
            </div>
          </div>
        </div>
        </div>
    </div>
  </div>
</section>
<script type="text/javascript">
  $(document).ready(function() {
    $(".gototop").click(function() {
        $("html, body").animate({"scrollTop": "0px"});
    });
    $( ".forgot" ).hide();
    $( ".triggerforgot" ).click(function() {
      $( ".forgot" ).toggle( "slow");
      $( ".log" ).hide();
    });
    $( ".log_frm" ).click(function() {
      $( ".log" ).toggle( "slow");
      $( ".forgot" ).hide();
    });
  });
</script> 
<div class="clear"></div>
<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url();?>">
<footer class="footr_bgclr1">
  <div class="clear"></div>
  <div class="container top_pad30 botm_pad30  wow fadeInLeft"> <!-- bgclr4 -->
    <div class="col-md-3 col-sm-4 col-xs-12">
      <div class="su_list1">
        <h3 class="">Corporate Information</h3>
        <ul>
           <li><a href="<?php echo base_url();?>About_us">About Us</a></li>
            <li><a href="<?php echo base_url();?>Our_investors">Our Investors</a></li>
            <li><a href="" target="_blank">Our Blog</a></li>
            <li><a href="<?php echo base_url();?>contact">Contact Us</a></li>
            <li><a href="<?php echo base_url();?>Sitemap">Sitemap</a></li>
         
        </ul>
      </div>
      <div class=" bm_mar10">
        <div class="clear"></div>
        <div class="row1 tp_mar20 tobrdrftr">
          <div class="tp_mar20 wow slideInLeft"><?php if(!empty($authUrl)) { ?>
              <a href="<?php echo $authUrl;//$authUrl ?>">
              <div class="fbbx_mbr"> <i class="fa fa-facebook fntsz1 pd2" aria-hidden="true"></i>Login with Facebook </div>
          </a><?php } ?> </div>
          <?php 
              $datas = getLoginId();
              if(empty($datas)){
          ?>
          <div class="tp_mar20 wow slideInRight"> <a href="<?php echo base_url()?>Home/google_login">
              <div class="gglbx"> <i class="fa fa-google-plus fntsz1 pd2 login_google_plus" aria-hidden="true"></i>Login with Google Plus </div>
          </a> </div>
          <?php } ?>
        </div>
        <div class="col-md-4 col-sm-4 wow slideInRight"> </div>
      </div>
    </div>
    <div class="col-md-9 col-sm-8 col-xs-12">
      <div class="row1">
        <div class=" top_pad10 ">
          <h3 class="text-center ">Jaazzo On Mobile</h3>
          <div class="border3">
            <div class="col-md-5 col-sm-12 col-xs-12 wow slideInLeft t30">
                <div class="col-md-4 col-sm-4 col-xs-4">
                    <a href=""><img src="<?= base_url();
                ?>assets/public/images/playstore.png"></a> </div>
                <div class="col-md-4 col-sm-4 col-xs-4"> <a href=""><img src="<?= base_url();
                ?>assets/public/images/appstore.png"></a> </div>
                <div class="col-md-4 col-sm-4 col-xs-4"> <a href=""><img src="<?= base_url();
                ?>assets/public/images/wndsstore.png"></a> </div>
            </div>
            <div class="col-md-1 hidden-sm hidden-xs tp_mar30">
                <div class="fntbld tp_mar10 hidden-sm fntsz1 text-center whit2 ">OR</div>
            </div>
            <div class="col-md-6 col-sm-12 wow slideInRight">
                <form name="download" id="download" action="<?php echo base_url();?>home/download_sms1" method="post">
                    <div class="col-md-12 col-sm-12 col-xs-12 ">
                        <label class="fntsz2 whit2">Download via SMS</label><br>
                        <input type="number" onKeyPress="return isNumberKey(event)" name="mobile" class="txt_bg1 newssus" id="usr" placeholder="Enter Your Mobile number" data-rule-required="true">
                        <input type="submit" class="button_submit1" value="Submit">
                        <!--                            <label class="fntsz3 whit2">Or you can also give a missed call on 080888888 to download the jaazzo-->
                        <!--                                app</label>-->
                    </div>
                </form>
            </div>
          </div>
        </div>
      </div>
      <div class="row1 ">
        <div class="tobrdrftr2"></div>
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="su_list1">
            <h3 class="bm_mar10">Customer Care</h3>
            <ul>
              <li><a href="<?php echo base_url();?>Term_condition">Terms & Conditions</a></li>
              <li><a href="<?php echo base_url();?>help">Help & FAQs</a></li>
              <li><a href="<?php echo base_url();?>privacy">Privacy Policy</a></li>
              <!--                    <li><a href="--><?php //echo base_url();?><!--fare"">Fare Rules</a></li>-->
              <!--   <li><a href="">User Agreement</a></li> -->
                <!-- <li><a href="">Holiday Retail Store</a></li> -->
            </ul>
          </div>
        </div>
        <!--===========col-md-3 end here ========================-->
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="su_list1">
            <h3 class="">Why Buy With Jaazzo</h3>
            <ul>
                <li><a href="<?php echo base_url();?>Testimonial">Testimonial</a></li>
               <!--  <li><a href="">Awards Won</a></li> -->
                <li><a href="<?php echo base_url();?>News">Jaazzo in the News</a></li>
                <li><a href="<?php echo base_url();?>career">Careers</a></li>
                <!-- <li><a href="">Holiday Retail Store</a></li> -->
            </ul>            
          </div>
        </div>
        <!--===========col-md-3 end here ========================-->
        <div class="col-md-4 col-sm-4 col-xs-12">
          <div class="su_list1">
            <h3 class="">Partner With Us</h3>
            <ul>
                
                <li><a href="<?php echo base_url();?>home/club_membership">Become a Club Member</a></li>
                 <li><a  data-target="#loginmbr" data-toggle="modal" style="cursor: pointer;" class=""><span class="icnspace"> Be a Member </span></a></li>
                <!--  <li><a  data-target="#ba" data-toggle="modal" style="cursor: pointer;" class=""><span class="icnspace">Become a BA</a></li>
              <li><a href="">Jaazzo Holiday Advisors</a></li>
                <li><a href="">Sell Holiday Packages</a></li>
                <li><a href="">Register Your Homestay</a></li> -->
            </ul>
          </div>
        </div>
        <!--===========col-md-3 end here ========================-->
      </div>
    </div> 
  </div>
  <section>
    <div class="clear"></div>
    <div class="clear"></div>
    <div class="bgclr1 wow fadeInRight">
      <div class="container top_pad10 botm_pad10">
          <div class="tobrdrftr2"></div>
          <div class="col-md-6 col-sm-6">
              <div class="flleft1">
                  <h6 class="whit2">We Accept</h6>
              </div>
              <div class="flleft1"> <img src="<?= base_url();?>assets/public/images/visa.png" alt="greenindia"> </div>
              <div class="flleft1"> <img src="<?= base_url();?>assets/public/images/master.png" alt="greenindia"> </div>
              <div class="flleft1"> <img src="<?= base_url();?>assets/public/images/american.png" alt="greenindia"> </div>
              <div class="flleft1"> <img src="<?= base_url();?>assets/public/images/net.png" alt="greenindia"> </div>
              <div class="flleft1"> <img src="<?= base_url();?>assets/public/images/emi.png" alt="greenindia"> </div>
              <div class="flleft1"> <img src="<?= base_url();?>assets/public/images/rupay.png" alt="greenindia"> </div>
          </div>
          <!--===========col-md-6 end here ========================-->
          <div class="col-md-6 col-sm-6">
              <div class="flleft1">
                  <h6 class="whit2">Secured Sites <img src="<?= base_url();?>assets/public/images/scrd.png" alt="greenindia"> </h6>
              </div>
              <div class="flleft1">
                  <h6 class="whit2">Secured Sites <img src="<?= base_url();?>assets/public/images/vrsn.png" alt="greenindia"> </h6>
              </div>
              <div class="flleft1">
                  <h6 class="whit2">Our Premium Business Partner <a href="http://www.emarald.in/hotel-calicut/"><img src="<?= base_url();?>assets/public/images/emerald.png" alt="greenindia"></a> </h6>
              </div>
          </div>
      </div>
      <!--===========containerfluid end here ========================-->

      <div class="container botm_pad10">
          <div class="border1"></div>
          <h6 class="text-center tp_mar10 whit2">All rights reserved @ Jaazzo.com</h6>
          <h6 class="text-center tp_mar10 whit2">© 2017 www.jaazzo.com | All Rights
              Reserved.  Conceived By <a  style="background:none;border:none;padding-left:5px;width:45px;" href="http://www.cybaze.com/" target="_blank"><img style="width: 40px;" src="<?= base_url();?>/assets/public/images/cybaze-logo.png" /></a> </h6>
      </div>
    </div>
  </section>
</footer>
<!--===========footer end here ========================--> 
<div id="back-top" style="display: block;">
  <a class="gototopbtn" href="#"><span></span> </a>
</div>
<script  language="JavaScript" type="text/javascript">
    // <![CDATA[
    $(document).ready(function() {
        $(".gototopbtn").click(function() {
            $("html, body").animate({"scrollTop": "0px"});
        });
    });
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57 ))
            return false;
        return true;
    }
</script>
<!-- SWEAT ALERT JS -->
<link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="<?php echo base_url() ?>assets/public/css/sweet-alert.min.css" />
<script data-require="sweet-alert@*" data-semver="0.4.2" src="<?php echo base_url() ?>assets/public/js/sweet-alert.min.js"></script>

<!--<script type="text/javascript" src="<?= base_url();?>assets/public/js/scrolling.js"></script> -->
<script type="text/javascript" src="<?= base_url();?>assets/public/js/stickynav.js"></script> 
<script src="<?= base_url();?>assets/public/js/jquery.singlePageNav.min.js"></script> 
<script src="<?= base_url();?>assets/public/js/typed.js"></script> 
<script src="<?= base_url();?>assets/public/js/wow.min.js"></script> 
<script src="<?= base_url();?>assets/public/js/custom.js"></script>
<script src="<?= base_url();?>assets/public/js/ddmenu.js"></script>
<script src="<?php echo base_url();?>assets/public/validation/js/languages/jquery.validationEngine-en.js" type="text/javascript" charset="utf-8">
</script>
<script src="<?php echo base_url();?>assets/public/validation/js/jquery.validationEngine.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="<?php echo base_url();?>assets/public/js/jquery.noty.packaged.min.js"></script>
<!--===========common js end ========================--> 
<!--<script type="text/javascript" src="<?php echo base_url();?>assets/public/custom_js/custom_footer.js"></script>-->
<script type="text/javascript" src="<?php echo base_url();?>assets/public/custom_js/sociallogin.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>

<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<style type="text/css">
    span.help-inline-error1{
        color: red;
        position: absolute;
        width: 100%;
        top: 70px;
        line-height: 20px;
        left: 15px;
    }
    span.help-inline-error{
        color: red;
    }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
</style>
<script type="text/javascript">
  $(document).ready(function () {
    var base_url = $(document).find('#baseurl').val();
    var download = jQuery("#download").validate({
        rules: {
          mobile: {
              required: true
          }
        },
        messages: {
          mobile: {
              required: "Please provide mobile no field"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error1",
    });
    var download_response = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status)
        {
            $('.body_blur').hide();
            swal("Success!", "Request has been sent.", "success",{timer: 1500});
              setTimeout(function(){
                  location.reload();
              }, 1500);
        }else{
           var regex = /(<([^>]+)>)/ig;
           var body = data.reason;
           var result = body.replace(regex, "");
           swal("Warning!", result, "error");
        }
      }
    };
    $('#download').submit(function(e){     
      e.preventDefault();
      if (download.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(download_response);  
      }          
    });
    //Login Start
    var log = jQuery("#login_form").validate({
        rules: {
          username: {
              required: true
          },
          password: {
              required: true,
              minlength: 6
          }
        },
        messages: {
          username: {
              required: "Please provide your username"
          },
          password: {
              required: "Please provide password",
              minlength: "Password field must be at least 6 characters long"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas8 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          if(data.reason){
              var data = data.reason;
              $('#login_form :input').attr('readonly','readonly');
              $('#otp_form_log').show('slow');
              $('#otp_form_log').find('#maill').val(data.email);
              $('#otp_form_log').find('#pasword').val(data.password);
              swal("Success!", "A verification code has been sent to your mobile and email", "success");
          }else{
            //swal("Success!", "Login Successfully.", "success",{timer: 1500});
            setTimeout(function(){
              //location.reload();
               window.location.href=base_url+"user_profile",true;
            }, 1500);
          }
        } else{
          var regex = /(<([^>]+)>)/ig;
          var body = data.reason;
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
        }
      }
    };
    $('#login_form').submit(function(e){     
      e.preventDefault();
      if (log.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas8);  
      }          
    });
    //Login End
    //Forgot password Start
    var forgot = jQuery("#forgot_pass").validate({
        rules: {
          forgot_username: {
              required: true
          }
        },
        messages: {
          forgot_username: {
              required: "Please provide your username"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas12 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          swal("Success!", "Please check your email to reset password.", "success",{timer: 1500});
          setTimeout(function(){
              location.reload();
          }, 1500);
        } else{
          
          swal("Warning!", common(data.reason), "error");
        }
      }
    };
    $('#forgot_pass').submit(function(e){     
      e.preventDefault();
      if (forgot.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas12);  
      }          
    });
    //Forgot password End
  });     
</script>
</body>
</html>