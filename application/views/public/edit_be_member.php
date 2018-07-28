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

.moblsn{width: 300px;
margin:auto;
padding: 20px;
border: 1px solid #ccc}

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
    <div class="moblsn">
      <h5>Create Account</h5>
      <div class="logn_frrmbx">
         <form name="website" id="be_a_member" action="<?= base_url()?>register/new_customer" method="post">
          <input class="txt_bg3" id="first_name" name="first_name" type="text" placeholder="First Name" />
          <input class="txt_bg3" id="last_name" name="last_name" type="text" placeholder="Last Name" />
          <input class="txt_bg3" id="reg_mail" name="email" type="email" placeholder="E-mail" />
          <input class="txt_bg3" id="reg_phone" name="phone" placeholder="Mobile No"  type="number"  onKeyPress="return isNumberKey(event)"/>&nbsp;<span style="font-size: medium;color: red;">*</span>
          <input type="password" name="password" class="txt_bg3 validate[required]"  placeholder="Password" id="password">&nbsp;<span style="font-size: medium;color: red;">*</span>
          <input type="password" name="confirm_password" class="txt_bg3 validate[required,equals[password]]" placeholder="Confirm Password" id="confirm_password">&nbsp;<span style="font-size: medium;color: red;">*</span>

          <div class="login_ckbx">
            <input type="checkbox" class="validate[required]" name="accept" id="creat3">
          <label for="creat3"><span class="checkbox">I Agree to the <a style="    border-right: none;" href="<?= base_url()?>Term_condition">T & C</a></span></label>
          </div>
          <input class="button_submit3 btn_mem_register" name="send" type="submit" value="Create Account" />
          <p style="text-align:left;line-height:18px;font-size:12px;">(You will receive an message/e-mail containing the OTP verification code.)</p>
        </form>
        <form name="website" action="<?= base_url()?>register/validate_otp" method="post" id="otp_form_reg">
          <input type="text" name="reg_otp" class="txt_bg3 form-control validate[required]" id="reg_otp" placeholder="Enter OTP Here" style="width: 96%;" >
          <input type="hidden" name="email" id="email" class="form-control"  style="width: 96%;" >
          <input type="hidden" name="mobile" id="mobile" class="form-control" style="width: 96%;"  >
           <input class="button_submit3 submit_otp" name="submit" type="submit" value="Continue"  style="width: 96%;" />
        </form>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        $(".gototop").click(function() {
            $("html, body").animate({"scrollTop": "0px"});
        });
    });
</script> 
<?php echo $footer; ?>
</body>
</html>