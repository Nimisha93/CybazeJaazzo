   <?php echo $header; ?>

<body>
<div class="wrapper">




<?php echo $sidebar; ?>

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="orange" data-header-animation="true">
                            <i class="fa far fa-user" aria-hidden="true"></i>
                        </div>
                        <div class="card-content">
                            <p class="category"> Club Member</p>
                            <h3 class="card-title"><?php echo $club_member['member']['c_id'];?></h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                               <!--  <i class="fa fa-angle-double-right" aria-hidden="true"></i> -->
                                <!-- <a class="more1" href="works.php">More...</a> -->
                            </div>
                        </div></div>
                    
                   <!--  <div class="card card-product">
                        <div class="card-image" data-header-animation="true">
                            <a href="#pablo">
                                <img class="img" src="<?php echo base_url(); ?>assets/admin/img/card-2.jpg">
                            </a>
                        </div>
                        <div class="card-content">
                            <div class="card-actions">
                                <button type="button" class="btn btn-danger btn-simple fix-broken-card">
                                    <i class="material-icons">build</i>
                                </button>
                                <a href="works.php" class="btn btn-default btn-simple" rel="tooltip"
                                   data-placement="bottom" title="View">
                                    <i class="material-icons">art_track</i>
                                </a>

                            </div>
                            <h4 class="card-title">
                                <a href="works.php">Total 7 ChannelPartner</a>
                            </h4>

                        </div> 

                    </div>-->

                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="orange" data-header-animation="true">
                            <i class="fa fa-handshake-o"></i>
                        </div>
                        <div class="card-content">
                            <p class="category">Channel Partner</p>
                            <h3 class="card-title"><?php echo $channel_partner['partner']['cp_id'];?></h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                               <!--  <a class="more1" href="about.php">More...</a> -->
                            </div>
                        </div>
                    </div>
                  <!--   <div class="card card-product">
                        <div class="card-image" data-header-animation="true">
                            <a href="#pablo">
                                <img class="img" src="<?php echo base_url(); ?>assets/admin/img/card-2.jpg">
                            </a>
                        </div>
                   <div class="card-content">
                            <div class="card-actions">
                                <button type="button" class="btn btn-danger btn-simple fix-broken-card">
                                    <i class="material-icons">build</i>
                                </button>
                                <a href="about.php" class="btn btn-default btn-simple" rel="tooltip"
                                   data-placement="bottom" title="View">
                                    <i class="material-icons">art_track</i>
                                </a>

                            </div>
                            <h4 class="card-title">
                                <a href="about.php">Total 5 User</a>
                            </h4>

                        </div> 

                    </div>-->

                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="orange" data-header-animation="true">
                            <i class="fa  fa-address-card-o"></i>
                        </div>
                        <div class="card-content">
                            <p class="category">Club Agent</p>
                            <h3 class="card-title"><?php echo $clubagent['member']['co_clubagent'];?></h3>
                        </div>

                        <div class="card-footer">
                            <div class="stats">
                                <!-- <a class="more1" href="gallery.php">More...</a> -->
                            </div>
                        </div>
                    </div>
                    <!-- <div class="card card-product">
                        <div class="card-image" data-header-animation="true">
                            <a href="#pablo">
                                <img class="img" src="<?php echo base_url(); ?>assets/admin/img/card-2.jpg">
                            </a>
                        </div>
                        <div class="card-content">
                            <div class="card-actions">
                                <button type="button" class="btn btn-danger btn-simple fix-broken-card">
                                    <i class="material-icons">build</i>
                                </button>
                                <a href="gallery.php" class="btn btn-default btn-simple" rel="tooltip"
                                   data-placement="bottom" title="View">
                                    <i class="material-icons">art_track</i>
                                </a>

                            </div>
                            <h4 class="card-title">
                                <a href="gallery.php">Total 15 Clubmember</a>
                            </h4>

                        </div> -->
     

                    </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats" style="background-color: #ffffff;">
                        <div class="card-header" data-background-color="orange" data-header-animation="true" style="border-radius: 50%;background: linear-gradient(60deg, #6e68ce, #53b2bb);">
                          <i class="fa fas fa fa-inr" aria-hidden="true"></i>
                        </div>
                        <div class="card-content">
                            <p class="category"> My Wallet</p>
                            <h3 class="card-title"><?php echo $my_wallet['member']['total_value'];?></h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                               <!--  <i class="fa fa-angle-double-right" aria-hidden="true"></i> -->
                                <!-- <a class="more1" href="works.php">More...</a> -->
                            </div>
                        </div>
                    </div>
         
                   <!--  <div class="card card-product">
                        <div class="card-image" data-header-animation="true">
                            <a href="#pablo">
                                <img class="img" src="<?php echo base_url(); ?>assets/admin/img/card-2.jpg">
                            </a>
                        </div>
                        <div class="card-content">
                            <div class="card-actions">
                                <button type="button" class="btn btn-danger btn-simple fix-broken-card">
                                    <i class="material-icons">build</i>
                                </button>
                                <a href="works.php" class="btn btn-default btn-simple" rel="tooltip"
                                   data-placement="bottom" title="View">
                                    <i class="material-icons">art_track</i>
                                </a>

                            </div>
                            <h4 class="card-title">
                                <a href="works.php">Total 7 ChannelPartner</a>
                            </h4>

                        </div> 

                    </div>-->

            </div>
        <!-- <div class="row"> -->
         <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="orange" data-header-animation="true">
                            <i class="fa fab fas fa-archive"></i>
                        </div>
                        <div class="card-content">
                            <p class="category">jaazzo Store</p>
                            <h3 class="card-title"><?php echo $ba['ba']['ba_id'];?></h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                               <!--  <a class="more1" href="about.php">More...</a> -->
                            </div>
                        </div>
                    </div>
                  <!--   <div class="card card-product">
                        <div class="card-image" data-header-animation="true">
                            <a href="#pablo">
                                <img class="img" src="<?php echo base_url(); ?>assets/admin/img/card-2.jpg">
                            </a>
                        </div>
                   <div class="card-content">
                            <div class="card-actions">
                                <button type="button" class="btn btn-danger btn-simple fix-broken-card">
                                    <i class="material-icons">build</i>
                                </button>
                                <a href="about.php" class="btn btn-default btn-simple" rel="tooltip"
                                   data-placement="bottom" title="View">
                                    <i class="material-icons">art_track</i>
                                </a>

                            </div>
                            <h4 class="card-title">
                                <a href="about.php">Total 5 User</a>
                            </h4>

                        </div> 

                    </div>-->

                </div>
            <?php 
            if($user['add_exec']==1){
                ?> 
                    <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="orange" data-header-animation="true">
                            <i class="fa fa-user-secret"></i>
                        </div>
                        <div class="card-content">
                            <p class="category">Executives</p>
                            <h3 class="card-title"><?php echo $executive['exec']['exec_id'];?></h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                               <!--  <a class="more1" href="about.php">More...</a> -->
                            </div>
                        </div>
                    </div>
                  <!--   <div class="card card-product">
                        <div class="card-image" data-header-animation="true">
                            <a href="#pablo">
                                <img class="img" src="<?php echo base_url(); ?>assets/admin/img/card-2.jpg">
                            </a>
                        </div>
                   <div class="card-content">
                            <div class="card-actions">
                                <button type="button" class="btn btn-danger btn-simple fix-broken-card">
                                    <i class="material-icons">build</i>
                                </button>
                                <a href="about.php" class="btn btn-default btn-simple" rel="tooltip"
                                   data-placement="bottom" title="View">
                                    <i class="material-icons">art_track</i>
                                </a>

                            </div>
                            <h4 class="card-title">
                                <a href="about.php">Total 5 User</a>
                            </h4>

                        </div> 

                    </div>-->

                </div>
                <?php } ?>

             <!--    </div> -->
                <?php
                if($promotion['designation']!=''){
                    ?>
                    <div class="col-lg-12 col-md-6 col-sm-6">
                        <div class="alert alert-rose alert-with-icon" data-notify="container">
                            <i class="material-icons" data-notify="icon">notifications</i>
                            <button type="button" aria-hidden="true" class="close">
                              
                            </button>
                            <p data-notify="message" style="color: #ccc">Congratulations!!!  You Are Promoted To
                            <span style="font-size: 20px;color: #fff;display: inline-block;width: auto;">  <?php echo $promotion['designation'];?> !!</span></p>
                        </div>
                        </div>
                         <?php
                    if($promotion['package_name']!=''){
                    ?>
                        <div class="col-lg-12 col-md-6 col-sm-6" style="margin-top: -44px">

                        <div class="card card-stats "  data-count="1" >


                          <p  style="color: red;margin: 20px;font-size: 21px;text-align: center;">You Have Got the 
                          <?php echo $promotion['package_name'];?> Gift Package
                          </p>
                        <div class="col-sm-6 col-md-offset-3" >
                         <img src="<?= base_url();?>uploads/gifts/<?php echo $promotion['image'];?>" style="max-height: 200px;width: ">
                        
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                               <!--  <i class="fa fa-angle-double-right" aria-hidden="true"></i> -->
                                <!-- <a class="more1" href="works.php">More...</a> -->
                            </div>
                        </div>
                    </div> 
                    <?php } ?>
                    </div>
                        <?php } ?>

                </div>

            </div>

        </div>
    </div>

<?php echo $footer; ?>
</div>
</div>

</body>

</body>