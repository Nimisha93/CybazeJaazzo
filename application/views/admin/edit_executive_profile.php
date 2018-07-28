<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/sumo-select/sumoselect.css" rel="stylesheet" />


</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."><i class="fa fa-info-circle" aria-hidden="true"></i></div>
                </h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
                </span> </div>
                </div>
            </div>
        </div>

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

                               <?php //echo $user['id'];
                               ?>
                       
                        <div class="">
                            <div class="table-responsive tabmargntp30">
                                <form method="post" name="executive" enctype='multipart/form-data'  id="executive" action="<?php echo base_url();?>admin/Profile/edit_executive_byid/<?php echo $user['id'];?>">
                                    <div class="col-md-12">


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
                                            <button type="submit" class="btn btn-primary" name="" id="">Update      </button>
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
            $('#executive').ajaxForm({

                

                // dataType identifies the expected content type of the server response
                dataType:  'json',

                // success identifies the function to invoke when the server response
                // has been received
                success:   function(data){

                    if(data.status){


                        noty({text: 'Updated', type: 'success', timeout: 1000 });
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