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


        <!--===========col-md-3 end here ========================-->
        </div>
    </div> </div>


    <section>

    
    <!--===========container end here ========================-->
    
    <div class="clear"></div>



    <!--===========containerfluid end here ========================-->
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
  
  <!--===========section end here ========================-->
  


</footer>
<!--===========footer end here ========================--> 
<div id="back-top" style="display: block;"> <a class="gototopbtn" href="#"><span></span> </a> </div>




<!-- <script type="text/javascript" src="<?= base_url();?>assets/public/js/jquery-2.0.3.js"></script> 

<script src="<?= base_url();?>assets/public/js/bootstrap.js"></script>  -->


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
<link href="<?php echo base_url();?>assets/public/sumo-select/sumoselect.css" rel="stylesheet" />
<script src="<?php echo base_url();?>assets/public/sumo-select/jquery.sumoselect.js"></script>
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
<script type="text/javascript" src="<?php echo base_url();?>assets/public/custom_js/common_func.js"></script>
<script type="text/javascript">
    function get_wallet_billing()
    {
        var sum = 0;
        $('.input_price').each(function(){
            var cur = $(this);
            var money_wallet = parseFloat($(this).val());
            money_wallet = isNaN(money_wallet) ? 0 : money_wallet;
            sum = sum + money_wallet;
        });
        $('#sum_of_billing').val(sum);   
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
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
        /* var v = jQuery("#download").validate({
        
            submitHandler: function(datas) {
            
                jQuery(datas).ajaxSubmit({
                    
                    dataType : "json",
                    success  :    function(data)
                    {

                        if(data.status)
                {

                    //$('#channel_form').hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added channel partner </div></div>';
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
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    //$.toast(data.reason, {'width': 500});
                   // return false;
                }
                    }
                });
            }
        }); */
    });     
</script>
