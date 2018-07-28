<?= $header; ?>
<style type="text/css">
    
    .card-stats .card-content {
    text-align: right;
    padding-top: 10px;
    min-height: 100px;
}

</style>
<body>
<div class="wrapper">

    <?= $sidebar; ?>

    <div class="content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="orange" data-header-animation="true">
                            <i class="fa fa-exchange" aria-hidden="true"></i>
                        </div>
                         <?php 
                             if($cp_details==0){
                                 // $text = "No Pending Amounts";
                                 $pending ="0";
                             }
                             else if($cp_details<0) { 
                                    $amt = abs($cp_details);
                                    $pending = round($amt,2);
                                    
                                 }else{
                                      
                                       $pending = round($cp_details,2);
                                      
                                 }   
                          ?>
                        <div class="card-content">
                            <p class="category">Pending Transaction Amount</p>
                            <h3 class="card-title"><?= $pending; ?></h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
<!--                                 <i class="fa fa-angle-double-right" aria-hidden="true"></i>
 --><!--                                 <a class="more1" href="works.php">More...</a>
 -->                            </div>
                        </div>
                    </div>
                   

                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="orange" data-header-animation="true">
                            <i class="fa fa-rupee"> </i>
                        </div>
                        <div class="card-content">
                            <p class="category">Bill Total</p>
                            <?php $bill_total= empty($dashboard['details']->bill_total) ?"0" :$dashboard['details']->bill_total; ?>
                            <h3 class="card-title"><?= $bill_total; ?></h3>
                        </div>
                        <div class="card-footer">
                            <div class="stats">
                                <!-- <a class="more1" href="about.php">More...</a> -->
                            </div>
                        </div>
                    </div>
                 

                </div>
                <div class="col-lg-4 col-md-6 col-sm-6">
                    <div class="card card-stats">
                        <div class="card-header" data-background-color="orange" data-header-animation="true">
                            <i class="  fa  fa-gift"></i>
                        </div>
                        <div class="card-content">
                            <p class="category">Customer Redeemed Rewards</p>
                            <?php $wallet = empty($dashboard['details']->wallet_total) ?"0" :$dashboard['details']->wallet_total ; ?>
                            <h3 class="card-title"><?= $wallet ; ?></h3>
                        </div>

                        <div class="card-footer">
                            <div class="stats">
<!--                                 <a class="more1" href="gallery.php">More...</a>
 -->                            </div>
                        </div>
                    </div>
                   

                </div>

            </div>

        </div>
    </div>

    <?= $footer; ?>
</div>
</div>

</body>

</body>