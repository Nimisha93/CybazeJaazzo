<?= $default_assets;?>
<style type="text/css">
    .req{
        font-size: x-large;
        color: red;
    }
    .row{margin:0;}
    .goToTop{position:fixed;border-bottom:1px solid #000;z-index: 17;}

    @media (max-width:1030px){

        .goToTop{height:auto;position:relative;}


    }
    @media (max-width:767px){

        .goToTop {
            position: static;
            top: 0;
            left: 0;
            z-index: 10;
            background-color: #1a4794;z-index: 17;
        }
    }
    
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
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

<div class="slidbg_clubmbr">
    <div class="clbmnmberadd">
        <div id="slctpackage" class="">
            <?php
            $session_array1 = $this->session->userdata('logged_in_user');
            $session_array2 = $this->session->userdata('logged_in_club_member');
            if(($session_array1 == NULL) && ($session_array2 == NULL)){ ?>
                <form id="club_registration" action="<?= base_url();?>register/new_club_member" method="POST">

                    <ul>
                        <?php foreach ($club_types as $key => $club) { ?>
                        <li>
                            <input type="radio"  value="<?php echo $club['id'];?>" name="club_plan">
                            <label for="f-option"><?php echo ucwords($club['title']);?><span class="slvr">( <span class="rupee">RS</span><?php echo $club['amount'];?> )</span></label>
                            <div class="check">
                                <div class="inside"></div>
                            </div>
                        </li>

                        <?php } ?>

                    </ul>



                    <input type="text" class="clubmbr1 name  validate[required]" name="cl_reg_name" id=""  placeholder="Enter Your Name">
                    <span class="req">*</span>
                    <input type="email" class="clubmbr1 email validate[required]" id="" name="cl_reg_mail"  placeholder="Enter Your E-mail id">
                    <span class="req">*</span>
                    <input type="number" class="clubmbr1 mobile validate[required]" onKeyPress="return isNumberKey(event)"  value="" name="cl_reg_mobile" id="some_class_1" placeholder="Mobile No.">
                    <span class="req">*</span>

                    <input type="password" class="clubmbr1 password validate[required]" id="" name="cl_reg_pass" placeholder="Enter Your Password">
                    <span class="req">*</span>
                    <input type="password" class="clubmbr1 password validate[required,equals[cl_reg_pass]]" id="" name="cl_reg_cpass"  placeholder="Confirm Your Password">
                    <span class="req">*</span>
                    <div class="login_ckbx">
                        <input type="checkbox" name="agree" id="clbmembrshp2">
                        <label for="clbmembrshp2"><span class="checkbox">I Agree to the T &amp; C</span></label>
                    </div>
                    <button type="submit" class="clu_sbmit club_submit">Submit</button>

                </form>

                <form id="club_registration_otp_form" action="<?= base_url();?>register/validate_otp_club_reg" method="post">
                    <input type="hidden" class="otp_reg_email" name="otp_reg_email">
                    <input type="hidden" class="otp_reg_phone" name="otp_reg_phone">
                    <input type="text" class="clubmbr1 validate[required]" id="" name="otp_reg_confirm" placeholder="Enter Your OTP">
                    <button type="submit" class="clu_sbmit otp_reg_culb">Verify</button>
                </form>

                <?php } else{ ?>
                <form id="become_club" action="<?= base_url();?>register/become_clubmember" method="post">


                    <h4 class="text-left bm_mar10">Select a Package & Be a Club Member </h4>
                    <!--<div class="underline2"></div>-->

                    <ul>
                        <?php foreach ($club_types as $key => $club) { ?>


                        <li>
                            <input type="radio"  value="<?php echo $club['id'];?>" <?php echo ($session_array2['club_type_id']==$club['id'])?'checked':''?> name="club_plan">
                            <label for="f-option"><?php echo ucwords($club['title']);?><span class="slvr">( <span class="rupee">RS</span> <?php echo $club['amount'];?> )</span></label>
                            <div class="check">
                                <div class="inside"></div>
                            </div>
                        </li>
                        <?php } ?>
                        <!-- <li>
                          <input type="radio"  value="2" name="club_plan">
                          <label for="s-option"> Gold <span class="slvr">( <span class="rupee">RS</span> 10000 )</span> </label>
                          <div class="check">
                            <div class="inside"></div>
                          </div>
                        </li>
                        <li>
                          <input type="radio"  value="3" name="club_plan">
                          <label for="t-option">Platinum<span class="slvr">( <span class="rupee">RS</span> 20000 )</span> </label>
                          <div class="check">
                            <div class="inside"></div>
                          </div>
                        </li> -->

                    </ul>

                    <button type="submit" class="clu_sbmit club_pay_now">Pay Now</button>
                </form>
                <?php } ?>
        </div>
    </div>
</div>
<!--===========main end here ========================-->
<main class="bgclr6">
<section>
    <div class="bgclr3">
    <div class="container clubwraper ">

        <div class="col-md-12 col-sm-12 col-xs-12">

            <div class="pckge_clbmbr_sub">
                <div class="clbmbrimgbx">
                    <img src="<?php echo base_url();?>assets/public/images/bronze.png">
                </div>
                <h3>Bronze</h3>
                <a data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#bronze">Below  RS 8000 psum dolor sit amet, consectetur adipiscing elit. Estne, quaeso,  </a>
            </div>
            <!-- ********************************-->

            <div class="pckge_clbmbr_sub">
                <div class="clbmbrimgbx">
                    <img src="<?php echo base_url();?>assets/public/images/silver.png">
                </div>
                <h3>silver</h3>
                <a data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#silver">Below  RS 8000 psum dolor sit amet, consectetur adipiscing elit. Estne, quaeso,  </a>
            </div>
            <!-- ********************************-->





            <div class="pckge_clbmbr_sub">
                <div class="clbmbrimgbx">
                    <img src="<?php echo base_url();?>assets/public/images/gold.png">
                </div>
                <h3>Gold</h3>
                <a data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#gold">Below  RS 8000 psum dolor sit amet, consectetur adipiscing elit. Estne, quaeso,  </a>
            </div>
            <!-- ********************************-->


            <div class="pckge_clbmbr_sub">
                <div class="clbmbrimgbx">
                    <img src="<?php echo base_url();?>assets/public/images/platnm.png">
                </div>
                <h3>Platinum</h3>
                <a data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#platinum">Below  RS 8000 psum dolor sit amet, consectetur adipiscing elit. Estne, quaeso,  </a>
            </div>
            <!-- ********************************-->

        </div>

        <div class="clear"></div>
        <div class="clbline"></div>

        <div class="">

            <div class="col-md-12 col-sm-12 col-xs-12 tp_mar20">

                <div class="col-md-6 tp_mar20" id="bronze">

                    <h3 class="clbpackghd">1, Bronze ( RS.5000 )</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui
                    </p>
                    <ul class="pcg">
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>
                        <li>psum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>
                        <li>it amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>

                        <li>ipiscing elit. Estne, quaeso, inquam</li>
                    </ul>

                </div>

                <!-- ********************************-->



                <div class="col-md-6 tp_mar20" id="silver">

                    <h3 class="clbpackghd">2, Silver ( RS.8000 )</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui
                    </p>
                    <ul class="pcg">
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>
                        <li>psum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>
                        <li>it amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>

                        <li>ipiscing elit. Estne, quaeso, inquam</li>
                    </ul>

                </div>


                <!-- ********************************-->
                <div class="clear"></div>


                <div class="col-md-6 tp_mar20" id="gold">

                    <h3 class="clbpackghd">3, Gold ( RS.15000  )</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui
                    </p>
                    <ul class="pcg">
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>
                        <li>psum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>
                        <li>it amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>

                        <li>ipiscing elit. Estne, quaeso, inquam</li>
                    </ul>

                </div>

                <!-- ********************************-->



                <div class="col-md-6 tp_mar20" id="platinum">

                    <h3 class="clbpackghd">4, Platinum ( RS.25000 )</h3>
                    <p>
                        Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui
                    </p>
                    <ul class="pcg">
                        <li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>
                        <li>psum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>
                        <li>it amet, consectetur adipiscing elit. Estne, quaeso, inquam</li>

                        <li>ipiscing elit. Estne, quaeso, inquam</li>
                    </ul>

                </div>


                <!-- ********************************-->


            </div>
        </div>
        <!-- ********************************-->





    </div>
    </div>
</section>
<div class="clear"></div>


<!--<section>
<div class="container tp_mar50 bm_mar50 bgpackage botm_pad40">
<h1 class="tp_mar20 text-center text-uppercase">Packages</h1>
<div class="col-md-12">

<div id="silver" class="col-lg-4 col-md-4 col-sm-12 col-xs-12 tp_mar30 ">
<div class="bgsilver">
<h2 class="text-left bgsilver_sub1 text-center">Silver</h2>
<h3 class="text-left bgsilver_sub2 text-center"><span class="rupee"> RS </span>1000 </h3>
<div class="su_box90_marauoto">

<p class="tp_mar20">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui
</p>

<a class="morspcfcn" data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#slctpackage">
<div class="select_pkg bgsilver_sub2">Select a Package</div></a>

</div>
</div></div>




<div id="gold" class="col-lg-4 col-md-4 col-sm-12 col-xs-12 tp_mar30 ">
<div class="bggold">
<h2 class="text-left bggold_sub1 text-center">Gold</h2>
<h3 class="text-left bggold_sub2 text-center"><span class="rupee"> RS </span>1000 - <span class="rupee"> RS </span>100000 </h3>
<div class="su_box90_marauoto">

<p class="tp_mar20">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui
</p>

 <a class="morspcfcn" data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#slctpackage">
 <div class="select_pkg select_pkg bggold_sub2">Select a Package</div></a>

</div>
</div></div>




<div id="platinum" class="col-lg-4 col-md-4 col-sm-12 col-xs-12 tp_mar30 ">
<div class="bgplatinum">
<h2 class="text-left platinum_sub1 text-center">Platinum</h2>
<h3 class="text-left platinum_sub2 text-center">Abve<span class="rupee"> RS </span>10000 </h3>
<div class="su_box90_marauoto">

<p class="tp_mar20">
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui
</p>

<a class="morspcfcn" data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#slctpackage"><div class="select_pkg platinum_sub2">Select a Package</div></a>
</div>
</div></div>

</div>
</div>

</section>-->


<!--===========section end here ========================-->
<div class="clear"></div>

</main>
<?php echo $footer; ?>

<script type="text/javascript">
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57))
            return false;
        return true;
    }
    $(document).ready(function(){
        $('#club_registration_otp_form').hide();
    });
</script>

<script src="<?= base_url();?>assets/public/js/smooth-scroll.js"></script>
<script>
    smoothScroll.init();

</script>
<!--=======================================slider right==============================================-->




<script type="text/javascript">
    // <![CDATA[
    $(document).ready(function() {
        $(".gototop").click(function() {
            $("html, body").animate({"scrollTop": "0px"});
        });
    });
</script>

</body>
</html>