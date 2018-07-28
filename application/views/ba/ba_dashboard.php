   <?php echo $header; ?>

<body>
<div class="wrapper">

<?php echo $sidebar; ?>

    <div class="content">
        <div class="container-fluid">

            <div class="row">
               
        
           <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="card card-stats" style="background-color: #ffffff;">
                        <div class="card-header" data-background-color="orange" data-header-animation="true" style="border-radius: 50%;background: linear-gradient(60deg, #6e68ce, #53b2bb);">
                          <i class="fa fas fa fa-inr" aria-hidden="true"></i>
                        </div>
                        <div class="card-content">
                            <p class="category"> My Wallet</p>
                            <h3 class="card-title"><!-- <?php echo $my_wallet['member']['total_value'];?> -->10</h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                               <!--  <i class="fa fa-angle-double-right" aria-hidden="true"></i> -->
                                <!-- <a class="more1" href="works.php">More...</a> -->
                            </div>
                        </div>
                    </div>
         

                </div>
                </div>

            </div>

        </div>
    </div>

<?php echo $footer; ?>
</div>
</div>

</body>

</body>