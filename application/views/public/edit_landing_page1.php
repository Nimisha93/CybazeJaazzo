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




    <style>


        .row{margin-left:0 !important; margin-right:0 !important;}

        .goToTop{height:50px;position:fixed;border-bottom:1px solid #000}
        @media (max-width:1000px){

            .goToTop{height:auto;position:relative}


        }

    </style>
</head>

<body>

<!--===========header end here ========================-->


<?= $header;?>





<section>

<!-- ====================================================================-->

<div class="">
<div class="container-fluid">
<div class="su_box95_marauoto">
<div class="su_mnulist">
<ul>

<?php foreach ($submenu as $key => $submenu) { ?>

<a href="hotel-home.php" target="_blank">
    <li>
        <i class="fa fa-trello clear2" aria-hidden="true"></i>
        <?php echo $submenu['module_name'];?>
        <div class="bordrmnu"><div class="bordrmnu_sub"></div></div>
    </li>
</a>

<?php }?>



<!--///////////////////////////////////////////////////////-->



</ul>
<!-- ============================================================================================-->
</div>
</div>







</div>
</div>

</div>
</section>




<!-- ============================================================================================-->
<section class="bgclr2 top_pad30 botm_pad30">
    <div class="container-fluid">

        <div class="col-md-4 col-sm-6 col-xs-12 tp_mar20">
            <div id="myCarousel" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel" data-slide-to="1"></li>
                    <li data-target="#myCarousel" data-slide-to="2"></li>
                    <li data-target="#myCarousel" data-slide-to="3"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="<?= base_url();?>assets/public/images/mydeals/1483330459491.jpg">
                    </div>

                    <div class="item">
                        <img src="<?= base_url();?>assets/public/images/mydeals/15.jpg">
                    </div>

                    <div class="item">
                        <img src="<?= base_url();?>assets/public/images/mydeals/14.jpg">
                    </div>

                    <div class="item">
                        <img src="<?= base_url();?>assets/public/images/mydeals/13.jpg">
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <!-- =============================================-->


        <div class="col-md-4 col-sm-6 col-xs-12 tp_mar20">
            <div id="myCarousel2" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel2" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel2" data-slide-to="1"></li>
                    <li data-target="#myCarousel2" data-slide-to="2"></li>
                    <li data-target="#myCarousel2" data-slide-to="3"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="<?= base_url();?>assets/public/images/mydeals/1483337287840.jpg">
                    </div>

                    <div class="item">
                        <img src="<?= base_url();?>assets/public/images/mydeals/13.jpg">
                    </div>

                    <div class="item">
                        <img src="<?= base_url();?>assets/public/images/mydeals/14.jpg">
                    </div>

                    <div class="item">
                        <img src="<?= base_url();?>assets/public/images/mydeals/16.jpg">
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel2" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel2" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
        <!-- ======================================================-->


        <div class="col-md-4 col-sm-12 col-xs-12 tp_mar20">
            <div id="myCarousel3" class="carousel slide" data-ride="carousel">
                <!-- Indicators -->
                <ol class="carousel-indicators">
                    <li data-target="#myCarousel3" data-slide-to="0" class="active"></li>
                    <li data-target="#myCarousel3" data-slide-to="1"></li>
                    <li data-target="#myCarousel3" data-slide-to="2"></li>
                    <li data-target="#myCarousel3" data-slide-to="3"></li>
                </ol>

                <!-- Wrapper for slides -->
                <div class="carousel-inner" role="listbox">
                    <div class="item active">
                        <img src="<?= base_url();?>assets/public/images/mydeals/1483339334724.jpg">
                    </div>

                    <div class="item">
                        <img src="<?= base_url();?>assets/public/images/mydeals/1483339334724.jpg">
                    </div>

                    <div class="item">
                        <img src="<?= base_url();?>assets/public/images/mydeals/1483339334724.jpg">
                    </div>

                    <div class="item">
                        <img src="<?= base_url();?>assets/public/images/mydeals/1483339334724.jpg">
                    </div>
                </div>

                <!-- Left and right controls -->
                <a class="left carousel-control" href="#myCarousel3" role="button" data-slide="prev">
                    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="right carousel-control" href="#myCarousel3" role="button" data-slide="next">
                    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>


    </div>
</section>


<div class="clear"></div>
<section>

<main class="cd-main-content" style="background-color:#fff">
<section>

<div class="container bm_mar30">
<div class="tp_mar50 ">
    <div class="hdln1">
        <h4>Crazy Deals</h4>
        <a href="">
            <div class="redmr1">See All </div>
        </a> </div>
</div>

<div class="tp_mar20 clear"></div>
<section class="regular slider">
<?php foreach ($deal as $key => $deal) { ?>
    <div>

        <div class="deal"> <img src="<?php echo base_url();?>assets\admin\products\<?php echo $deal['image'];?>" class="indxprct">

            <a href="<?php echo base_url();?>home/product_deal/<?php echo $deal['id'];?>">
                <div class="redmr2">Get this deal</div>
            </a>
            <div class="su_box100 dealbg1">
                <h4><img src="<?= base_url();?>assets/public/images/home/bismi.png" class="logoleft">Deal with Bismi  </h4>
            </div>

            <h3><?php echo $deal['name'];?> </h3>
            <div class="clear"></div>
            <div class="">
                <div class="su3bx">
                    <div class="oldrate1"><span class="rupee">RS</span> <?php echo $deal['cost'];?> </div>
                </div>
                <div class="su3bx">
                    <div class="offferrate1"><span class="rupee">RS</span> <?php echo $deal['actual_cost'];?> </div>
                </div>

                <div class="su3bx">
                    <div class="offferrate3">- 52% </div>
                </div>

           </div>

             <div class="clear"></div>
        </div>

    </div>

  <?php }?>
</section>
</div>
</section>
<div class="clear"></div>

<!-- ======================== section end here ====================================================================-->


<section>

<div class="container bm_mar20">
<div class="tp_mar20 ">
    <div class="hdln1">
        <h4>Best Performer</h4>
        <a href="">
            <div class="redmr1">See All </div>
        </a> </div>
</div>

<div class="tp_mar20 clear"></div>
<div class="col-md-3 col-sm-3 hidden-xs">
    <img src="<?= base_url();?>assets/public/images/mydeals/channel.jpg">
</div>

<div class="col-md-9 col-sm-9 col-xs-12">
<div class="regular2 slider">
    <?php  foreach ($products as $key => $produ) { ?>
    <div>

        <div class="deal"> <img src="<?php echo base_url();?>assets\admin\products\<?php echo $produ['image'];?>" class="indxprct">

            <a href="<?php echo base_url();?>home/product_details/<?php echo $produ['id'];?>">
                <div class="redmr2">Get this deal</div>
            </a>
            <div class="su_box100 dealbg1">
                <h4><img src="<?= base_url();?>assets/public/images/home/klyan.png" class="logoleft">Deal with klyan Sarees  </h4>
            </div>

            <h3><?php echo $produ['name'];?> </h3>
            <div class="clear"></div>
            <div class="">
                <div class="su3bx">
                    <div class="oldrate1"><span class="rupee">RS</span><?php echo $produ['cost'];?> </div>
                </div>
                <div class="su3bx">
                    <div class="offferrate1"><span class="rupee">RS</span> <?php echo $produ['actual_cost'];?> </div>
                </div>

                <div class="su3bx ofrright">
                    <div class="offferrate3">- 69% </div>
                </div>

            </div>

            <div class="clear"></div>
        </div>

    </div>
<?php }?>



</div>

</div>
</div>
</section>

<!-- ======================== section end here ====================================================================-->

<div class="clear"></div>
<?php  foreach($prod['module'] as $key => $pro) { ?>
    <section>


        <div class="container bm_mar20">
            <div class="tp_mar20 ">
                <div class="hdln1">
                    <h4>premium <?php echo $pro['module_name'];?></h4>
                    <a href="">


                        <div class="redmr1">See All </div>
                    </a> </div>
            </div>

            <div class="tp_mar20 clear"></div>
            <div class="col-md-3 col-sm-3 hidden-xs">
                <img src="<?php echo base_url();?>assets\admin\products\<?php echo $pro['image'];?>">
            </div>
        <?php  foreach($pro['product'] as $key => $products) { ?>
            <div class="col-md-9 col-sm-9 col-xs-12">
                <div class="regular2 slider">


                    <div>

                       <div class="deal"> <img src="<?php echo base_url();?>assets\admin\products\<?php echo $products['image'];?>" class="indxprct">

                            <a href="<?php echo base_url();?>home/product_details/<?php echo $products['id'];?>">
                                <div class="redmr2">Get this deal</div>
                            </a>
                            <div class="su_box100 dealbg1">
                                <h4><img src="<?= base_url();?>assets/public/images/home/klyan.png" class="logoleft">Deal with klyan Sarees  </h4>
                            </div>

                         <h3><?php echo $products['name'];?> </h3>
                            <div class="clear"></div>
                            <div class="">
                                <div class="su3bx">
                                 <div class="oldrate1"><span class="rupee">RS</span><?php echo $products['cost'];?> </div>
                                </div>
                                <div class="su3bx">
                                    <div class="offferrate1"><span class="rupee">RS</span> <?php echo $products['actual_cost'];?> </div>
                                </div>

                                <div class="su3bx ofrright">
                                    <div class="offferrate3">- 69% </div>
                                </div>

                            </div>

                            <div class="clear"></div>
                        </div>

                    </div>




                </div>

            </div>

        </div>
        <?php }?>
    </section>
    <?php }?>
<!-- ======================== section end here ====================================================================-->

</main>
</section>

<!-- ============================================================================================-->



</main>
<?php echo $footer; ?>
<!-- <script src="<?= base_url();?>assets/public/js/cbpHorizontalMenu.min.js"></script>
<script>
      $(function() {
        cbpHorizontalMenu.init();
      });
    </script> -->


<!--=======================================slider right==============================================-->

<script src="<?= base_url();?>assets/public/js/slick.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript">
    $(document).on('ready', function() {
        /*  $(".regular").slick({
            dots: true,
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 4,
          });*/
        $(".center").slick({
            dots: true,
            infinite: true,
            centerMode: true,
            slidesToShow: 3,
            slidesToScroll: 3
        });
        $(".variable").slick({
            dots: true,
            infinite: true,
            variableWidth: true,
            slidesToShow: 1,
            slidesToScroll: 1,
        });
    });


</script>

<script>

    $(document).on('ready', function() {
        $('.regular').slick({
            dots: true,
            loop: true,
            speed: 300,
            slidesToShow: 5,
            slidesToScroll: 4,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 580,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    });

</script>


<script>

    $(document).on('ready', function() {
        $('.regular2').slick({
            dots: true,
            loop: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },
                {
                    breakpoint: 580,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    });

</script>


<script type="text/javascript">
    // <![CDATA[
    $(document).ready(function() {
        $(".gototop").click(function() {
            $("html, body").animate({"scrollTop": "0px"});
        });
    });
</script>

</body>
</html>