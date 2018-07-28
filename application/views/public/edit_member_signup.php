<?= $default_assets;?>
<input type="hidden" name="baseurl" id="baseurl" value="<?= base_url();?>">
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
		<?php if($details['status']!=1){?>
		<div class="col-md-offset-3 col-md-6" style="background: #f1f1f1;padding-top: 30px;    margin-bottom: 20px;">
			<div class="col-xs-12">
			    <h2 class="tp_mar20">Member Sign Up</h2>
			<!--	<h3>Get Started-it's Free.</h3> -->
			</div>
			<div class="cusmragnt">
				<form method="post" id="become_normal_customer" action="<?php echo base_url(); ?>Register/signup_friends">        
					<div class="col-sm-6 col-xs-12 form-group">
					<label>Firstname</label>
						<input type="text" name="first_name" class="form-control" id="first_name">
					</div>
					<div class="col-sm-6 col-xs-12 form-group">
					<label>Lastname</label>
						<input type="text" name="last_name" class="form-control" id="last_name">
					</div>
					<div class="col-xs-6 form-group">
					<label>Email</label>
					<input type="email" class="form-control1" id="email" name="email" value="<?php echo strtolower($details['email'])?>" placeholder="Email">
					<input type="hidden" name="id" value="<?php echo $details['id']?>">
					<input type="hidden" name="referrer_id" value="<?php echo $details['referrer_id']?>">

					</div>
					<div class="col-xs-6 form-group">
					<label>Mobile</label>
					<input type="text" readonly="true" class="form-control1" id="mobile" name="mobile" value="<?php echo strtolower($details['mobile'])?>" placeholder="Email">
					</div>
					<div class="col-sm-6 col-xs-12 form-group">
					<label>Password</label>
						<input type="password" name="password" class="form-control" id="password"  placeholder="*****" style="text-transform: none;">
					</div>
					<div class="col-sm-6 col-xs-12 form-group">
					<label>Confirm Password</label>
						<input type="password" name="cpassword" class="form-control" id="cpassword"  placeholder="*****" style="text-transform: none;">
					</div>
					<div class="col-xs-12 form-group">
					<button class="button_submit3 btn_set_password"  style="width:100%;margin-bottom: 28px;"  type="submit">Join now</button>
					</div>
				</form>  
		    </div>
		</div>
		<?php }else{?>
		<div class="col-md-offset-3 col-md-6">
			<div class="col-xs-12">
				<h5>Your session has expired !!</h5>
			</div>
		</div>
		<?php }?>
	</div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
        $(".gototop").click(function() {
            $("html, body").animate({"scrollTop": "0px"});
        });

        var c = jQuery("#become_normal_customer").validate({
	        rules: {
	          first_name: {
	              required: true,
	              minlength: 3
	          },
	          email: {
	              email: true,
	          },
	          mobile: {
	              required: true,
	              minlength: 10
	          },
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
	          first_name: {
	              required: "Please provide your first name",
	              minlength: "First Name field must be at least 3 characters long"
	          },
	          email: {
	              email: "Email is invalid"
	          },
	          mobile: {
	              required: "Please provide a mobile no",
	              minlength: "Mobile field must be at least 10 characters long"
	          },
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
	    var datas2 = { 
	      dataType : "json",
	      success:   function(data){
	        $('.body_blur').hide();
	        if(data.status){
	          swal("Congrats!", "Sign up Successfully.", "success",{timer: 1500});
	          setTimeout(function(){
	              window.location.href = '<?php echo base_url(); ?>',true;
	          }, 1500);
	        } else{
	          var regex = /(<([^>]+)>)/ig;
	          var body = data.reason;
	          var result = body.replace(regex, "");
	          swal("Warning!", result, "error");
	        }
	      }
	    };
	    $('#become_normal_customer').submit(function(e){     
	      e.preventDefault();
	      if (c.form()) 
	      {
	        $('.body_blur').show();
	        $(this).ajaxSubmit(datas2);  
	      }          
	    });
    });
</script> 
<?php echo $footer; ?>
</body>
</html>