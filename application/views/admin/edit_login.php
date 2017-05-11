<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

       <title>Greeenindia </title>
     <link href="<?php echo base_url();?>assets/admin/images/fav.png" rel="shortcut icon">

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
  background: #16a085;
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
  <form class="contact_form" action="<?php echo base_url();?>admin/login/login_process" method="post" name="contact_form">
    <h1>Login Into Your Account</h1>
      <ul>
          <li>
              <input type="text" class="textbox1" name="username" placeholder="Username" required />
              <span class="form_hint">Enter a valid email</span>
               <p><img src="<?php echo base_url();?>assets/admin/images/contact.png" alt=""></p>
          </li>
          <li>
              <input type="password" name="password" class="textbox2" placeholder="Password">
              <p><img src="<?php echo base_url();?>assets/admin/images/lock.png" alt=""></p>
          </li>
         </ul><h1><span style="font-size: 11px;color: #F44336;"><?php echo $this->session->flashdata('errormsg');?></span></h1>
          <input type="submit" name="Sign-in" value="Sign in"/>
      <div class="clear"></div> 
      <label class="checkbox"><input type="checkbox" name="checkbox" checked><i></i>Remember me</label>
     <div class="forgot">
      <a data-toggle="modal" data-target="#myModal">forgot password?</a>
    </div> 
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
          <form action="<?php echo base_url();?>admin/Forgot_psw/forgot_password" method="post" name="pass_form" id="pass_form"  method="post" >
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




  <script type="text/javascript">
        $(document).ready(function() {

            // bind form using ajaxForm
            $('#pass_form').ajaxForm({
                // dataType identifies the expected content type of the server response
                dataType:  'json',

                // success identifies the function to invoke when the server response
                // has been received
                success:   function(data){
                    if(data.status){
                        noty({text: 'Password changed', type: 'success', timeout: 1000 });
                        window.location = "<?php echo base_url();?>admin/Login/loged_out";
                    } else {
                        noty({text: data.reason, type: 'error', timeout: 1000 });
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
</div>
</body>
</html>