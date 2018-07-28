<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Jaazzo | rewards unlimitted</title>
    <link href="<?= base_url();?>assets/public/favicon/favicon.png" rel="shortcut icon">

    <!-- Bootstrap -->

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

    <link href="<?php echo base_url();?>assets/admin/css/bootstrap/bootstrap-theme.min.css" rel="stylesheet">

    <link href="<?php echo base_url();?>assets/admin/css/bootstrap/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>assets/admin/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->

<link href="<?php echo base_url();?>assets/admin/css/login-style.css" rel="stylesheet" type="text/css" media="all" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script type='text/javascript' src='<?php echo base_url();?>assets/admin/js/jquery.particleground.js'></script>
  <script type='text/javascript' src='<?php echo base_url();?>assets/admin/js/demo.js'></script>
  <script type='text/javascript' src='<?php echo base_url();?>assets/public/js/bootstrap.js'></script>

  <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>
  <!-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->
 <script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>





  <style>
  html, body {
  width: 100%;
  height: 100%;
  overflow: hidden;
}

body {
  background: #041a2b;
  color: #fff;
  line-height: 1.3;
  -webkit-font-smoothing: antialiased;
}
#particles {
  width: 100%;
  height: 100%;
  overflow: hidden;
}

#intro {
  position: absolute;
  left: 0;
  top: 50%;
  padding: 0 20px;
  width: 100%;
  text-align: center;
}

input:-webkit-autofill {
    -webkit-box-shadow: 0 0 0px 1000px white inset;
}

@media only screen and (max-width: 568px) {
  #intro {
    padding: 0 10px;
  }
}

</style>
</head>
<body>

<div id="particles">
  <div id="intro">
<div class="wrap">
<!-- strat-contact-form --> 
<div class="contact-form">



<!-- start-form -->
  <form class="contact_form" action="<?php echo base_url();?>admin/forgot_psw/change_pwd" method="post" name="contact_form" id="contact_form">
    <h1>Change Password</h1>
      <ul>
          <li>
           <input type="hidden" name="username" value="<?php echo $username; ?>">
                            <input type="hidden" name="random" value="<?php echo $random; ?>">
              <input type="password" class="textbox1" name="password" placeholder="Password" required />
              <span class="form_hint">Enter a password</span>
               <p><img src="<?php echo base_url();?>assets/admin/images/contact.png" alt=""></p>
          </li>
          <li>
              <input type="password" name="c_password" class="textbox2" placeholder="Confirm Password">
              <p><img src="<?php echo base_url();?>assets/admin/images/lock.png" alt=""></p>
          </li>
         </ul>
          <input type="submit" name="Sign-in" value="Submit"/>
      <div class="clear"></div> 
      
  </form>
    
    
<div class="account">
  <h2 class="tpmr30">Welcom to </h2>
  <img class="tpmr30" src="<?php echo base_url();?>assets/admin/images/online-portal-logo.png">
  <p>Lorem Ipsum is also known as: Greeked text, blind text, placeholderdd text, dummy content, filler text, lipsum, and mock-content.
Samuel L Ipsum: Lo</p>
  
</div>

   <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"></h4>
        </div>
        <div class="modal-body">
          <form action="<?php echo base_url();?>admin/Forgot_psw/forgot_password_new" method="post" name="pass_form" id="pass_form"  method="post" >
          <input type="text" placeholder="Username" name='email' ng-model="designation" id="email" class="form-control">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" id="change" name="change" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" >submit</button>
        </div>
        </form>
      </div>
    </div>
  </div>


  
<!-- end-account -->
<div class="clear"></div> 
</div>
<!-- end-contact-form -->
</div></div>
<div id="notifications"></div><input type="hidden" id="position" value="center">

<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/alertBox.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/alertBox.css"> 
<!-- Notification -->
<link href="<?php echo base_url(); ?>assets/admin/_css/Icomoon/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/admin/_css/animate.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/admin/_css/animated-notifications.css" rel="stylesheet" type="text/css" />


  <script type="text/javascript">
        $(document).ready(function() {

            // bind form using ajaxForm
            $('#contact_form').ajaxForm({
                // dataType identifies the expected content type of the server response
                dataType:  'json',

                // success identifies the function to invoke when the server response
                // has been received
                success:   function(data){
                    if(data.status){
                                      var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Password Changed Successfully</div></div>';
                                    var effect='zoomIn';
                                    $("#notifications").append(center);
                                    $("#notifications-full").addClass('animated ' + effect);
                                  refresh_close();
                                    
                                     setTimeout(function(){
                     

                       
                    }, 2000);
                    
                    } else {
                                   var regex = /(<([^>]+)>)/ig;
                                    var body = data.reason;
                                    var result = body.replace(regex, "");
                                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                                    var effect='fadeInRight';
                                    $("#notifications").append(center);
                                    $("#notifications-full").addClass('animated ' + effect);
                                    alert_close();
                                    
                    }

                }
            });
            $('#pro_quantity').on('input',function() {
                calculte_cost();
            });
            $('#pro_actualcost').on('input',function() {
                calculte_cost();
            });
        });
        // function calculte_cost(){
        //     var quantity = isNaN(parseInt($('#pro_quantity').val())) ? 0 : parseInt($('#pro_quantity').val());
        //     var actualcost = isNaN(parseInt($('#pro_actualcost').val())) ? 0 : parseInt($('#pro_actualcost').val());
        //     var sal_one_day = quantity * actualcost;
        //     $("#product_form").find('#pro_cost').val(parseInt(sal_one_day));
        //     var test = inWords(cost);
        //     console.log(test);
        // }

    </script>
    
    
    <script type="text/javascript">
    function resize(){$('#notifications')}
        $( window ).resize(function() {resize();});
        resize();


        function refresh_close(){
            $('.close').click(function(){$(this).parent().fadeOut(1000);});
            setTimeout(function(){   window.location = "<?php echo base_url();?>admin/Login"; }, 1000);
        }
         function  alert_close(){
             $('.close').click(function(){$(this).parent().fadeOut(1000);});
            setTimeout(function(){  }, 1000);
        }
</script>
</div>
</body>
</html>