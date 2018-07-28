<?= $default_assets;?>

<style type="text/css">

    .row{margin:0;}
    .goToTop{position:fixed;border-bottom:1px solid #000;z-index: 17;    background-color: #3c497d;}

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
            background-color: #1a4794;
        }
    }
</style>

<body>
<?= $header;?>

</div>

<div class="container" style="max-width: 1200px">
    <div class="row content" style="margin-top: 50px;margin-bottom: 50px;">
        <div class="col-sm-9 col-xs-12">
            <div class="ftrd_hding">Contact Details</div>
            <table width="98%" class="tp_mar30">
              <tbody>
                <tr>
                  <td class="top_pad10 col-xs-3"> Address </td>
                  <td class="top_pad10 ">
                    3rd Floor, Emarald Mall 
                    Near Big Bazar
                    <br> Mavoor Road <br> Calicut-4 
                  </td>
                </tr>
                <tr>
                  <td class="top_pad10 col-xs-3">Customer Support</td>
                  <td class="top_pad10 "> 
                        (+91) 7356 33 55 01 <br> 7356335502 <br> 7356 33 55 03 
                    <div class="blue"> greenindiatours@gmail.com </div>
                  </td>
                </tr>
              </tbody>
            </table>

            <div class="clear"></div>

            <div class="tp_mar20">
                <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d125218.42895681!2d75.74077336090741!3d11.255826554601812!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba65938563d4747%3A0x32150641ca32ecab!2sKozhikode%2C+Kerala!5e0!3m2!1sen!2sin!4v1494851288675" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen></iframe> -->
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1956.5117182496283!2d75.7896981!3d11.2596861!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ba65948b45eaced%3A0x9e22195c0d520a93!2sGreen+India+Tours+%26+Travels!5e0!3m2!1sen!2sin!4v1442643094198" width="100%" height="250" frameborder="0" style="border:0" allowfullscreen=""></iframe>
            </div>

        </div>

        <div class="col-sm-3 col-xs-12" >
            <div class="ftrd_hding">Send Your Feedback </div>
            <div class="loginbx" style="background-color: #e6eafb;padding: 10px">

                <form action="<?php echo base_url();?>Home/send_feedback" id="feedback_form" name="feedback_form" method="post">
                    <div class="clear"></div>
                    <table width="98%" class="lodmr" style="display: table;">
                        <tbody>
                        <tr>
                            <td class="col-xs-12  top_pad10">
                                <input type="text" name="name" placeholder="Enter your Name" id="input-email" class="form-control">
                            </td>
                        </tr>
                        <tr>
                            <td class="col-xs-12  top_pad10"><input type="text" name="email" placeholder="Enter your  Email ID" class="form-control">
                            </td>

                        </tr>
                        <tr>
                            <td class="col-xs-12  top_pad10"><input type="number" onKeyPress="return isNumberKey(event)" name="mobile" placeholder="Enter your Mobile Number" id="input-password" class="form-control"></td>

                        </tr>
                        <tr>
                            <td class="col-xs-12  top_pad10">
                                <select class="form-control validate[required]" id="sel1" name="type">
                                    <option value="">Select Feedback Type</option>
                                    <option value="Issue">Issue</option>
                                    <option value="Suggestion">Suggestion</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="col-xs-12  top_pad10"><textarea class="form-control
                            validate[required]" rows="3" id="comment" name="comment" placeholder="Enter Your Feedback"></textarea></td>
                        </tr>
                        <tr>
                            <td class="col-xs-4 col-sm-4 col-md-4 col-lg-4 top_pad10">
                                <input type="hidden" name="customer_id" value="">
                                <button type="submit" class="btn btn-danger login_button btn_feedback"> Submit </button>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </form>
            </div>

            </div>

        <div class="clear"></div>
    </div>
</div>














<?php echo $footer; ?>
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
</style>
<script type="text/javascript">
function isNumberKey(evt){
    var charCode = (evt.which) ? evt.which : event.keyCode
    if (charCode > 31 && (charCode < 48 || charCode > 57 ))
        return false;
    return true;
  }
    var m = jQuery("#feedback_form").validate({
        rules: {
          name: {
            required: true
          },
          email: {
            required: true,
            email: true//,
          },
          mobile: {
            required: true,
            minlength: 10
          },
          comment: {
            required: true
          }
        },
        messages: {
          name: {
              required: "Please provide a name"
          },
          email: {
              required: "Please provide an email",
              email: "Email is invalid"
          },
          mobile: {
              required: "Please provide a mobile no",
              minlength: "Mobile field must be at least 10 characters long"
          },
          comment: {
              required: "Please provide  your comments here"
          }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas1 = { 
      dataType : "json",
      success:   function(data){
        $('.body_blur').hide();
        if(data.status){
            swal("Success!", "Your enquiry has been successfully received. We will contact you soon.", "success");
        } else{
          var regex = /(<([^>]+)>)/ig;
          var body = data.reason;
          var result = body.replace(regex, "");
          swal("Warning!", result, "error");
        }
      }
    };
    $('#feedback_form').submit(function(e){     
      e.preventDefault();
      if (m.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas1);  
      }          
    });
</script>
</body>

</html>