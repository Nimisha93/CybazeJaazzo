<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta mame="description" content=" " />
<META content="ALL" name="ROBOTS"/>
<META content="FOLLOW" name="ROBOTS"/>
<META content="" name="copyright"/>
<meta name="distribution" content="Global" />
<title>Greenindia</title>
<link rel="shortcut icon" href="<?= base_url();?>assets/public/favicon/favicon.png">
<?= $default_assets;?>

 <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/slick.css">
  <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/slick-theme.css">


  
   
<style type="text/css">

.row{margin:0;}
.goToTop{position:fixed;background-color:#1268b3;border-bottom:1px solid #000;z-index: 17;}




@media (max-width:1000px){
  
.goToTop{height:auto;position:relative;background-color:#fff;}
  
  
}
@media (max-width:767px){
  
  .goToTop {
  position: static;
  top: 0;
  left: 0;
  height: 210px;
  z-index: 10;
}
.row{margin:0;}
}
</style>





    

</head>

<body>

<!--===========header end here ========================-->


  <?= $header;?>
   
   
     


 
    
   
  

 <header>
  <div id="hero-wrapper">
    <div class="carousel-wrapper" style="max-height:540px;overflow:hidden;">
      <div class="container-fluid" >
          <?php// include('index-nav.php'); ?>
      </div>
      
            <div class="item active"> <img src="<?= base_url();?>assets/public/images/clubmember-manner.jpg"> </div>
           
          
      </div>
    </div>
  </div>
</header>
<!--===========header end here ========================-->

<div class="clear"></div>

<!--===========main end here ========================-->
<main>
  <section>
    <div class="container clubwraper">
      
      
       <div id="slctpackage" class="col-md-4 col-sm-4 col-xs-12">
       <?php
 $session_array = $this->session->userdata('logged_in_user');
        if($session_array == NULL){ ?>
        <form id="club_registration">
   <!-- <h4 class="text-left bm_mar10">Select a Package & Be a Club Member </h4> -->
   <!--<div class="underline2"></div>-->
          
<ul>
 <?php foreach ($club_types as $key => $club) { ?>
                    <li>
                      
                      <label for="f-option"><?php echo $club['title'];?><span class="slvr">( <span class="rupee">RS</span><?php echo $club['amount'];?> )</span></label>
                      <div class="check">
                        <div class="inside"></div>
                      </div>
                    </li>
                     <?php } ?>
                 <!--    <li>
                     
                      <label for="s-option"> Gold <span class="slvr">( <span class="rupee">RS</span> 10000 )</span> </label>
                      <div class="check">
                        <div class="inside"></div>
                      </div>
                    </li>
                    <li>
                     
                      <label for="t-option">Platinum<span class="slvr">( <span class="rupee">RS</span> 20000 )</span> </label>
                      <div class="check">
                        <div class="inside"></div>
                      </div>
                    </li> -->
                  
                  </ul>
                  
                  

<input type="text" class="clubmbr1 name tp_mar20 validate[required]" name="cl_reg_name" id=""  placeholder="Enter Your Name">

<input type="email" class="clubmbr1 email validate[required]" id="" name="cl_reg_mail"  placeholder="Enter Your E-mail id">

<input type="text" class="clubmbr1 mobile validate[required]" value="" name="cl_reg_mobile" id="some_class_1" placeholder="Mobile No.">


<input type="password" class="clubmbr1 password validate[required]" id="" name="cl_reg_pass" placeholder="Enter Your Password">

<input type="password" class="clubmbr1 password validate[required,equals[cl_reg_pass]]" id="" name="cl_reg_cpass"  placeholder="Confirm Your Password">

   <div class="login_ckbx">
      <input type="checkbox" name="agree" id="clbmembrshp2">
      <label for="clbmembrshp2"><span class="checkbox">I Agree to the T &amp; C</span></label>
    </div>
            <button type="submit" class="clu_sbmit club_submit">Submit</button>
          
                     

        </form>
      
        <form id="club_registration_otp_form"> 
        <input type="hidden" class="otp_reg_email" name="otp_reg_email">
        <input type="hidden" class="otp_reg_phone" name="otp_reg_phone">
        <input type="text" class="clubmbr1 validate[required]" id="" name="otp_reg_confirm" placeholder="Enter Your OTP">
        <button type="submit" class="clu_sbmit otp_reg_culb">Verify</button>
        </form>
        
     <?php } else{ ?>
      <form id="become_club"> 
       

         <h4 class="text-left bm_mar10">Select a Package & Be a Club Member </h4>
   <!--<div class="underline2"></div>-->
          
<ul>
                  <?php foreach ($club_types as $key => $club) { ?>
                  

                    <li>
                      <input type="radio"  value="<?php echo $club['id'];?>" name="club_plan">
                      <label for="f-option"><?php echo $club['title'];?><span class="slvr">( <span class="rupee">RS</span> <?php echo $club['amount'];?> )</span></label>
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
                  
        
       <!--  <input type="hidden" class="user_id validate[required]" name="user_id" value="<?= $session_array['user_id'];?>"> -->
        
        <button type="submit" class="clu_sbmit club_pay_now">Pay Now</button>
      </form>
      <?php } ?> 
      </div>
    
      
      <div class="col-md-8 col-sm-8 col-xs-12">
      
      <div class="silverbx">
      <h3>Silver</h3>
      <p class="tp_mar10">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui 
      </p>
             <a class="slvrlink" data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#silver">Read more</a>

      </div>
      
      
      <div class="silverbx tp_mar20">
      <h3>Gold</h3>
      <p class="tp_mar10">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui 
      </p>      
      
       <a class="slvrlink" data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#gold">Read more</a>

      </div>
      
      
      <div class="silverbx tp_mar20">
      <h3>Platinum</h3>
      <p class="tp_mar10">
      Lorem ipsum dolor sit amet, consectetur adipiscing elit. Estne, quaeso, inquam, sitienti in bibendo voluptas? Tu autem negas fortem esse quemquam posse, qui 
      </p>
       <a class="slvrlink" data-scroll="" data-options="{ &quot;easing&quot;: &quot;easeInQuad&quot; }" href="#platinum">Read more</a>
      </div>
      
      </div>
      
      
    </div>
    
  </section>
  <div class="clear"></div>
  
  
      <section>
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
      
      </section>  
     
        
  <!--===========section end here ========================-->
  <div class="clear"></div>

</main>
<?php echo $footer; ?>

      <script type="text/javascript">
        $(document).ready(function(){
          $('#club_registration_otp_form').hide();
          $('.club_submit').click(function(e){
            e.preventDefault();
            var data = $('#club_registration').serializeArray();
            $.post('<?= base_url();?>register/new_club_member', data, function(data){
              if(data.status){
                var datas = data.data;
                 noty({text:"A verification code has been sent to your mobile and email", type: 'success',layout: 'center', timeout: 2000});
                    $('#club_registration_otp_form').show('slow');
                    $('#club_registration_otp_form').find('.otp_reg_email').val(datas.email);
                    $('#club_registration_otp_form').find('.otp_reg_phone').val(datas.phone);
              }else{
                noty({text:data.reason, type: 'error',layout: 'top', timeout: 2000});
              }
            },'json');

          });

          $('.otp_reg_culb').click(function(e){
            e.preventDefault();
            var data = $('#club_registration_otp_form').serializeArray();
            $.post('<?= base_url();?>register/validate_otp_club_reg', data, function(data){
              if(data.status){
                 noty({text:"A verification code has been sent to your mobile and email", type: 'success',layout: 'center', timeout: 2000});
                   window.location = '<?= base_url();?>home';
              }else{
                noty({text:data.reason, type: 'error',layout: 'top', timeout: 2000});
              }
            },'json');

          });
          $('.club_pay_now').click(function(e){
            e.preventDefault();
            var data = $('#become_club').serializeArray();
             $.post('<?= base_url();?>register/become_clubmember', data, function(data){
              if(data.status){
                /// noty({text:"A verification code has been sent to your mobile and email", type: 'success',layout: 'center', timeout: 2000});
                   window.location = '<?= base_url();?>home';
              }else{
                noty({text:data.reason, type: 'error',layout: 'top', timeout: 2000});
              }
            },'json');

          });
        });
      </script>

<script src="<?= base_url();?>assets/public/js/smooth-scroll.js"></script>
    <script>
      smoothScroll.init();
    </script>
<!--=======================================slider right==============================================--> 

<script src="<?= base_url();?>assets/public/js/slick.js" type="text/javascript" charset="utf-8"></script>
  
  



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