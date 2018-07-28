<?= $default_assets;?>
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/style-grid.css" />
    <noscript>
		<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/fallback.css" />
	</noscript>
    <script type="text/javascript" src="<?= base_url();?>assets/public/js/modernizr.custom.26633.js"></script>
   	<style type="text/css">
		
 .row{margin:0;}
    .goToTop{position:fixed;border-bottom:1px solid #ccc;z-index: 17;    background-color: #d88909;}

 .panel-default > .panel-heading {
        color: #353434;
        background-color: #e4e4e4;
        border-color: #ddd;
    }

    @media (max-width:1030px){

        .goToTop{height:auto;position:relative;}


    }
    @media (max-width:767px){

        .goToTop {
            position: relative;
            top: 0;
            left: 0;
            z-index: 10;
            background-color: #d88909;
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
        <?php if($details['otp_status']!=1){ ?>
		<div class="col-md-offset-4 col-md-4">
			<div class="col-xs-12">
			    <!-- <h2 class="tp_mar20">Set Password</h2>
				<h3>Get Started-it's Free.</h3>
				<h5>Registration take less than 2 minutes</h5> -->
			</div>
			<div class="cusmragnt">
                <h2>Executive-Sign Up</h2>
				<form name="" action="" method="post" id="become_club_agent">        
					<div class="col-xs-12 form-group">
					<label>Email</label>
					<input type="email" class="form-control1" id="email" name="email" value="<?php echo strtolower($details['email'])?>" placeholder="Email">
					
					<input type="hidden" name="id" value="<?php echo $details['u_id']?>">
					</div>
					<div class="col-sm-6 col-xs-12 form-group">
					<label>Password</label>
					<input type="password" name="password" class="form-control" id="password"  placeholder="Enter Your Password">
					</div>
					<div class="col-sm-6 col-xs-12 form-group">
					<label>Confirm Password</label>
					<input type="password" name="cpassword" class="form-control" id="cpassword"  placeholder="Enter Your confirm Password">
					</div>
					
					
					
					
					
					
					
					<div class="col-sm-6 col-xs-12 form-group">
						<div class="login_ckbx">
	                      <input type="checkbox" class="validate[required]" value="1" name="accept" id="creat2">
	                      <label for="creat2"><span class="checkbox">I Agree to the <a style="    border-right: none;" href="<?= base_url();?>Term_condition">T &amp; C</a></span></label>
	                    </div>
                    </div>
					
					
					
					
					
					
					
					
					
					
					
					
					<div class="col-xs-12 form-group">
					<button class="button_submit3 btn_set_password"  type="submit">Join now</button>
					</div>
				</form>  
		    </div>
		</div>
		<?php }else{ ?>
		<div class="col-md-offset-4 col-md-4">
			<div class="col-xs-12">
				<h5>Your session has expired !!</h5>
			</div>
		</div>
		<?php } ?>
	</div>	
	</div>
</section>
<script type="text/javascript">
    $(document).ready(function() {
       /* $(".gototop").click(function() {
            $("html, body").animate({"scrollTop": "0px"});
        });*/
        $('.btn_set_password').click(function(e){
            e.preventDefault(); 
	        $('.body_blur').show();
            if(!$('input[type=checkbox]:checked').length) {
	            $('.body_blur').hide();
		        swal("Warning!",'Please agree to Terms & Conditions', "warning");
		        //stop the form from submitting
		        return false;
		    }else{
	            var data = $('#become_club_agent').serializeArray();
	            $.post('<?= base_url();?>Home/signup_executive', data, function(data){
	            	$('.body_blur').hide();
	                if(data.status){
	                    swal("Good job!", "Your registration completed Successfully Please login", "success");
	                    // noty({text:"Congratulations !!", type: 'success',layout: 'center', timeout: 2000});
	                    window.location = '<?= base_url();?>logout';
	                }else{
	                	var regex = /(<([^>]+)>)/ig;
                        var body = data.reason;
                        var result = body.replace(regex, ""); 
	                    swal("Warning!",result, "warning");
	                    // noty({text:data.reason, type: 'error',layout: 'top', timeout: 2000});
	                }
	            },'json');
		    }
        });
    });
</script> 
<?php echo $footer; ?>
</body>
</html>