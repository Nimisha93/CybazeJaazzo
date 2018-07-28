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
    <link href="<?php echo base_url();?>assets/admin/sumo-select/sumoselect.css" rel="stylesheet" />

   
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
  z-index: 10;
      background-color: #1a4794;
}

.row{margin:0;}
}
</style>
</head>

<body>

<!--===========header end here ========================-->


<?= $header;?>
<div class="right_col" role="main">
    <div class="">
        

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Change Profile<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <form method="post" name="channel" id="channel"  enctype='multipart/form-data' action="<?php echo base_url();?>admin/Profile/edit_channel_byid/<?php echo $user['id'];?>">
                                    <div class="">
                            <?php //echo $user['name']
                               
                           ?>

                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Name</label>
                                           
                                            <input type="text" value="<?php echo  $user['name']; ?>"  placeholder="Name"   name="name"  class="form-control validate[required]" >
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Contact Number</label>
                                            <input type="text" value="<?php echo  $user['phone']; ?>" placeholder="Phone" name="phone" id="phone"  class="form-control validate[required]" >
                                        </div>
                                        
                                         <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Contact Number</label>
                                            <input type="text" value="<?php echo  $user['phone2']; ?>" placeholder="Phone2" name="phone2" id="phone2"  class="form-control validate[required]" >
                                        </div>
                                         <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Email</label>
                                            <input type="text"  value="<?php echo  $user['email']; ?>" name="email" class="form-control validate[required] email" id="email"  >
                                        </div>

                                       <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Address</label>
                                            <input type="text"  value="<?php echo  $user['address']; ?>" name="address" class="form-control validate[required]" >
                                        </div>




                                         <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Image</label>
                                            <input type="file"  value="<?php echo  $user['image']; ?>" name="image" class="form-control validate[required] image" id="image"  >
                                        </div>
                                            
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                            <button type="submit" class="btn btn-primary" name="" id="">Update </button>
                                        </div>
                                    </div>
                                
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>

    <!--************************row  end******************************************************************* -->

      <script type="text/javascript">
        $(document).ready(function() {


            // bind form using ajaxForm
            $('#channel').ajaxForm({

                // dataType identifies the expected content type of the server response
                dataType:  'json',

                // success identifies the function to invoke when the server response
                // has been received
                success:   function(data){

                    if(data.status){

                        noty({text: 'Updated profile', type: 'success', timeout: 1000 });
                        window.location = "<?php echo base_url();?>admin/Profile/change_profile";
                    } else {
                        noty({text: data.reason, type: 'error', timeout: 1000 });
                    }

                }
            });
            // $('#pro_quantity').on('input',function() {
            //     calculte_cost();
            // });
            // $('#pro_actualcost').on('input',function() {
            //     calculte_cost();
            // });
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
</div>
</div>
</div>
</div>
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>


<?php echo $footer; ?>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>

<!-- Datatables -->

<!--============new customer popup start here=================-->


</div>
</body>
</html>