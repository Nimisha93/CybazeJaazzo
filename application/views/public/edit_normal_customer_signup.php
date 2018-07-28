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
		<?php if(!empty($details)&&($details['otp_status']!=1)){?>
		<div class="col-md-offset-2 col-md-6">
			<div class="col-xs-12">
			    <h2 class="tp_mar20">Sign up Free</h2>
			</div>
			<div class="cusmragnt">
				<form  method="post" id="become_normal_customer" action="<?php echo base_url(); ?>Home/customer_signup">        
					<div class="col-sm-6 col-xs-12 form-group">
					<label>Name</label>
					<input type="text" name="name" class="form-control" id="name" value="<?php echo $details['name']?>">
					</div>
					<div class="col-sm-6 col-xs-12 form-group">
					<label>Mobile</label>
					<input type="text" name="mobile" class="form-control" id="mobile" value="<?php echo $details['phone']?>">
					</div>
					<div class="col-xs-12 form-group">
					<label>Email</label>
					<input type="email" class="form-control1" id="email" name="email" value="<?php echo strtolower($details['email'])?>" placeholder="Email">
					<input type="hidden" name="otp" value="<?php echo $details['otp']?>">
					<input type="hidden" name="id" value="<?php echo $details['id']?>">
					<input type="hidden" name="created_by" value="<?php echo $details['created_by']?>">
					</div>
					<div class="col-sm-6 col-xs-12 form-group">
					<label>Password</label>
					<input type="password" name="password" class="form-control" id="password"  placeholder="*****">
					</div>
					<div class="col-sm-6 col-xs-12 form-group">
					<label>Confirm Password</label>
					<input type="password" name="cpassword" class="form-control" id="cpassword"  placeholder="*****">
					</div>
					<div class="col-xs-12 form-group">
					<button class="button_submit3 btn_join"  type="submit">Join now</button>
					</div>
				</form>  
		    </div>
		</div>
		<?php }else{?>
		<div class="col-md-offset-2 col-md-6">
			<div class="col-xs-12">
				<h5>Your session has expired !!</h5>
			</div>
		</div>
		<?php }?>
	</div>
</section>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
    	var base_url = $(document).find('#baseurl').val();
        $(".gototop").click(function() {
            $("html, body").animate({"scrollTop": "0px"});
        });
        $('.btn_set_password').click(function(e){
            e.preventDefault();
            var data = $('#become_club_agent').serializeArray();
            $.post('<?= base_url();?>Home/signup_clubagent', data, function(data){
                if(data.status){
                    swal("Good job!", "Your registration completed Successfully Please login", "success");
                    // noty({text:"Congratulations !!", type: 'success',layout: 'center', timeout: 2000});
                    window.location = '<?= base_url();?>home';
                }else{
                    swal("Warning!",data.reason, "warning");
                    // noty({text:data.reason, type: 'error',layout: 'top', timeout: 2000});
                }
            },'json');
        });

        var c = jQuery("#become_normal_customer").validate({
	        rules: {
	          name: {
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
	          name: {
	              required: "Please provide a name",
	              minlength: "Name field must be at least 3 characters long"
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
	              minlength: "Mobile field must be at least 10 characters long"
	          },
	          cpassword: {
	              required: "Please provide confirm password",
	              minlength: "Mobile field must be at least 10 characters long"
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
	          swal("Success!", "Customer Added Successfully.", "success",{timer: 1500});
	          setTimeout(function(){
	              window.location = base_url+'home';
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