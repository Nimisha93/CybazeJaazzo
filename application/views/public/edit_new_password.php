<?= $default_assets;?>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/style-grid.css" />
    <noscript>
		<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/fallback.css" />
	</noscript>
    <script type="text/javascript" src="<?= base_url();?>assets/public/js/modernizr.custom.26633.js"></script>
   	<style type="text/css">
		.row{margin:0;}
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
		span.help-inline-error{
			color: red;
		}

.forgotmail
{
  width: 300px;
  margin: auto;
}
.indxhdrmartop{display: none}

	</style>
</head>
<body>
<!--===========header end here ========================-->
<a href=""> <img src="<?php echo base_url();?>assets/public/images/online-portal-logo.png" alt="Jaazzo logo" style="padding: 10px;display: block;margin:30px auto 0;"> </a> 
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
	<div class="container ">
		<div class="forgotmail">
			<div class="col-xs-12">
			    <h2 class="" style="margin-bottom: 20px">Set New Password</h2>
			</div><br>
			<div class="cusmragnt">
				<form name="forgot_pwd" action="<?php echo base_url()?>user/login/update_password" method="post" id="forgot_pwd">        
					<div class="col-sm-12 col-xs-12 form-group">
					<label>Password</label>
						<input type="password" name="password" class="form-control" id="password"  placeholder="******" style="text-transform: none;">
						 <input type="hidden" name="random" id="random_no" value="<?php echo $random;?>"></td>
					</div>
					<div class="col-sm-12 col-xs-12 form-group">
					<label>Confirm Password</label>
						<input type="password" name="cpassword" class="form-control" id="cpassword"  placeholder="******" style="text-transform: none;">
					</div>
					<div class="col-xs-12 form-group">
					<button class="button_submit3" style="width: 100%"  type="submit">Save</button>
					</div>
				</form>  
		    </div>
		</div>
	</div>
</section>
<div class="body_blur" style="display: none"></div>
<input type="hidden" name="baseurl" id="baseurl" value="<?php echo base_url();?>">
<!-- SWEAT ALERT JS -->
<link data-require="sweet-alert@*" data-semver="0.4.2" rel="stylesheet" href="<?php echo base_url() ?>assets/public/css/sweet-alert.min.css" />
<script data-require="sweet-alert@*" data-semver="0.4.2" src="<?php echo base_url() ?>assets/public/js/sweet-alert.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        //Change pwd
    var pwd = jQuery("#forgot_pwd").validate({
        rules: {
          password: {
              required: true,
              minlength: 6
          },
          cpassword: {
              required: true,
              minlength: 6
          }
        },
        messages: {
          password: {
              required: "Please provide password",
              minlength: "Password field must be at least 6 characters long"
          },
          cpassword: {
              required: "Please provide confirm password",
              minlength: "Confirm Password field must be at least 6 characters long"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
          swal("Success!", "Your password changed successfully Please login.", "success",{timer: 1500});
          setTimeout(function(){
              window.location= "<?= base_url() ?>logout";
          }, 1500);
        } else{
          var regex = /(<([^>]+)>)/ig;
          var body = data.reason;
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
        }
      }
    };
    $('#forgot_pwd').submit(function(e){     
      e.preventDefault();
      if (pwd.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas);  
      }          
    });
  // End
    });
</script> 
</body>
</html>