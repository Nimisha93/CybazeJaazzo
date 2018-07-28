<!--  edit_show_product_details  -->
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

    <link type="text/css" rel="stylesheet" href="<?= base_url();?>assets/public/css/thumbnailslider.css" />

    <script type="text/javascript" src="<?= base_url();?>assets/public/js/jssor.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/public/js/jssor.slider.js"></script>
    <script type="text/javascript" src="<?= base_url();?>assets/public/js/slidthumbnail.js"></script>

    <style type="text/css">

        .row{margin:0;}
        @media (max-width:767px){

            .goToTop {
                position: static;
                top: 0;
                left: 0;
                height: 210px;
                z-index: 10;
            }
            .row{margin:0;}
        }


    </style>






    <style>
        .row{margin-left:0; margin-right:0;}

        .goToTop{height:50px;position:fixed;background-color:#fff;border-bottom:1px solid #000}
        @media (max-width:1000px){

            .goToTop{height:auto;position:relative;background-color:#fff;}


        }

    </style>
</head>

<body>

<!--===========header end here ========================-->


<?= $header;?>







<div class="clear"></div>

<!--===========main end here ========================-->



<!--===========section end here ========================-->


<!--===========section end here ========================-->
<div class="clear"></div>

<!-- Begin Body -->



<section class="bgclr6 top_pad50 botm_pad50">
<div id="photos" class=""></div>


<div class="clear" ></div>


<div class="container ">
<div class="bgclr3 border3">
<div class="su_box90_marauoto">



    <div class="col-md-5 col-sm-5">
        <?php
        $bal = $products[0]['actual_cost'] - $products[0]['cost']; ?>

        <div class="row">
            <div class="inneroffr">Save <span class="rupee">RS</span> <?php echo $bal;?></div>
            <div id="slider1_container" class="innr_sldr">

                <!-- Loading Screen -->
                <div u="loading" style="position: absolute; top: 0px; left: 0px;">
                    <div class="innrsl">
                    </div>
                    <div style="position: absolute; display: block; background: url(../img/loading.gif) no-repeat center center;
                top: 0px; left: 0px;width: 100%;height:100%;">
                    </div>
                </div>

                <!-- Slides Container -->
                <div u="slides" style="cursor: move; position: absolute; left: 0px; top: 0px; width: 400px; height: 450px; overflow: hidden;">


                    <div>
                        <img u="image" src="<?php echo base_url();?>assets\admin\products\<?php echo $products[0]['image'] ?>" />
                        <img u="thumb" src="<?php echo base_url();?>assets\admin\products\<?php echo $products[0]['image'] ?>" />
                    </div>

                    <?php
                    foreach($products as $product)
                    {

                        ?>
                        <div>
                            <img u="image" src="<?php echo base_url();?>assets\admin\products\<?php  echo $product['product_image']; ?>" />
                            <img u="thumb" src="<?php echo base_url();?>assets\admin\products\<?php  echo $product['product_image']; ?>" />
                        </div>
                        <?php } ?>

                </div>

                <!-- Arrow Navigator Skin Begin -->

                <!-- Arrow Left -->
        <span u="arrowleft" class="jssora05l" style="width: 40px; height: 40px; top: 158px; left: 8px;">
        </span>
                <!-- Arrow Right -->
        <span u="arrowright" class="jssora05r" style="width: 40px; height: 40px; top: 158px; right: 8px">
        </span>
                <!-- Arrow Navigator Skin End -->

                <!-- Thumbnail Navigator Skin Begin -->
                <div u="thumbnavigator" class="jssort01" style="position: absolute; width: 400px; height: 100px; left:0px; bottom: 0px;">
                    <!-- Thumbnail Item Skin Begin -->

                    <div u="slides" style="cursor: move;">
                        <div u="prototype" class="p" style="position: absolute; width: 72px; height: 72px; top: 0; left: 0;">
                            <div class=w><div u="thumbnailtemplate" style=" width: 100%; height: 100%; border: none;position:absolute; top: 0; left: 0;"></div></div>
                            <div class=c>
                            </div>
                        </div>
                    </div>


                    <!-- Thumbnail Item Skin End -->
                </div>
                <!-- Thumbnail Navigator Skin End -->
                <!-- Trigger -->
                <script>
                    jssor_slider1_starter('slider1_container');
                </script>
            </div>

        </div>





    </div>




    <div class="col-md-7 col-sm-7">

        <div class="brndname"><?php echo $products['0']['name'];?> </div>

        <div class="companylogo"><img src="<?php echo base_url();?>assets\admin\brand\<?php echo $products['0']['brand_image'];?>"></div>
        <div class="companyname"><?php echo $products['0']['cp_name'];?></div>
        <div class="clear"></div>
        <div class="line2 tp_mar20"></div>
        <div class="row">


        </div>
        <div class="clear"></div>

        <div class="row">



            <div class="col-md-12">


                <table class="brnd_spcifctn tp_mar10">
                    <thead>
                    <tr>
                        <th class="spcfcn">Specification</th>

                    </tr>
                    </thead>

                    <tbody>
                    <tr>

                        <td><?php echo $products[0]['description'];?></td>
                    </tr>


                    </tbody>
                </table>

            </div>
            <div class="clear"></div>

            <a class="morspcfcn" data-scroll data-options='{ "easing": "easeInQuad" }' href="#more">more...</a>


            <div class="line1 tp_mar20"></div>
            <div class="col-md-12">

                <div class="ratebox">
                    <table>
                        <tr>
                            <td class="brand_rate"> MRP</td>
                            <td class="brand_rate_none"> <span class="rupee">RS</span><?php echo $products[0]['actual_cost'];?> </td>
                        </tr>


                        <tr>
                            <td class="brand_rate">Model</td>
                            <td class="brand_rate_actual"> <span class=""></span><?php echo $products[0]['model'];?> </td>
                        </tr>


                        <tr>
                            <td class="brand_rate"> Our Deal</td>
                            <td class="brand_rate_actual"> <span class="rupee">RS</span><?php  echo $products[0]['cost'];?> </td>
                        </tr>

                    </table>

                </div></div>
            <?php
            $bal = $products[0]['actual_cost'] - $products[0]['cost'];
            if ($products[0]['actual_cost']<1) { $perc = 01; }
            else{ $perc = (100 * $bal)/$products[0]['actual_cost'];  }
            ?>

        </div>
        <div class="brand_offer"><?php echo round_number_no_decimal($perc);?>% Off</div>
        <div class="brand_offer_dealbtn"><a href=""> Get this Deal </a>
        </div>
    </div>

    <div class="clear"></div>


    <div id="more" class="border3 tp_mar50" >
        <div class="col-md-12">

            <h2 class="text-left"> Full Specification</h2>
            <div class="line2 bm_mar20"></div>
            <table class="brnd_spcifctn_full tp_mar10">
                <thead>
                <tr>

                </tr>
                </thead>

                <tbody>
                <?php echo $products[0]['full_specification'];?>
                </tbody>
            </table>

        </div>

    </div>

</div>





</div ></div>


<!--===========col-md-3 end here ========================-->


</section>

<!--===========header end here ========================-->

<div class="clear"></div>

<section class="bgclrwhite">
<div class="container top_pad30 botm_pad50">
<div class="hdln1">
    <h4>Related Products</h4>
</div>

<section class="regular slider">

<div>

    <div class="deal"> <img src="<?= base_url();?>assets/public/images/mydeals/10.jpg" class="indxprct">

        <a href="deal-inner.php">
            <div class="redmr2">Get this deal</div>
        </a>
        <div class="su_box100 dealbg1">
            <h4><img src="<?= base_url();?>assets/public/images/home/bismi.png" class="logoleft">Deal with Bismi  </h4>
        </div>

        <h3>Sansui 150 L Direct Cool Single Door Refrigerator  </h3>
        <div class="clear"></div>
        <div class="">
            <div class="su3bx">
                <div class="oldrate1"><span class="rupee">RS</span> 120 </div>
            </div>
            <div class="su3bx">
                <div class="offferrate1"><span class="rupee">RS</span> 69 </div>
            </div>

            <div class="su3bx">
                <div class="offferrate3">- 69% </div>
            </div>

        </div>

        <div class="clear"></div>
    </div>

</div>

<div>
    <div class="deal"> <img src="<?= base_url();?>assets/public/images/mydeals/10.jpg" class="indxprct">

        <a href="deal-inner.php">
            <div class="redmr2">Get this deal</div>
        </a>
        <div class="su_box100 dealbg1">
            <h4><img src="<?= base_url();?>assets/public/images/home/bismi.png" class="logoleft">Deal with Bismi  </h4>
        </div>

        <h3>Sansui 150 L Direct Cool Single Door Refrigerator  </h3>
        <div class="clear"></div>
        <div class="">
            <div class="su3bx">
                <div class="oldrate1"><span class="rupee">RS</span> 120 </div>
            </div>
            <div class="su3bx">
                <div class="offferrate1"><span class="rupee">RS</span> 69 </div>
            </div>

            <div class="su3bx">
                <div class="offferrate3">- 69% </div>
            </div>

        </div>

        <div class="clear"></div>
    </div>
</div>
<div>
    <div class="deal"> <img src="<?= base_url();?>assets/public/images/mydeals/10.jpg" class="indxprct">

        <a href="deal-inner.php">
            <div class="redmr2">Get this deal</div>
        </a>
        <div class="su_box100 dealbg1">
            <h4><img src="<?= base_url();?>assets/public/images/home/bismi.png" class="logoleft">Deal with Bismi  </h4>
        </div>

        <h3>Sansui 150 L Direct Cool Single Door Refrigerator  </h3>
        <div class="clear"></div>
        <div class="">
            <div class="su3bx">
                <div class="oldrate1"><span class="rupee">RS</span> 120 </div>
            </div>
            <div class="su3bx">
                <div class="offferrate1"><span class="rupee">RS</span> 69 </div>
            </div>

            <div class="su3bx">
                <div class="offferrate3">- 69% </div>
            </div>

        </div>

        <div class="clear"></div>
    </div>
</div>
<div>
    <div class="deal"> <img src="<?= base_url();?>assets/public/images/mydeals/10.jpg" class="indxprct">

        <a href="deal-inner.php">
            <div class="redmr2">Get this deal</div>
        </a>
        <div class="su_box100 dealbg1">
            <h4><img src="<?= base_url();?>assets/public/images/home/bismi.png" class="logoleft">Deal with Bismi  </h4>
        </div>

        <h3>Sansui 150 L Direct Cool Single Door Refrigerator  </h3>
        <div class="clear"></div>
        <div class="">
            <div class="su3bx">
                <div class="oldrate1"><span class="rupee">RS</span> 120 </div>
            </div>
            <div class="su3bx">
                <div class="offferrate1"><span class="rupee">RS</span> 69 </div>
            </div>

            <div class="su3bx">
                <div class="offferrate3">- 69% </div>
            </div>

        </div>

        <div class="clear"></div>
    </div>
</div>
<div>
    <div class="deal"> <img src="<?= base_url();?>assets/public/images/mydeals/10.jpg" class="indxprct">

        <a href="deal-inner.php">
            <div class="redmr2">Get this deal</div>
        </a>
        <div class="su_box100 dealbg1">
            <h4><img src="<?= base_url();?>assets/public/images/home/bismi.png" class="logoleft">Deal with Bismi  </h4>
        </div>

        <h3>Sansui 150 L Direct Cool Single Door Refrigerator  </h3>
        <div class="clear"></div>
        <div class="">
            <div class="su3bx">
                <div class="oldrate1"><span class="rupee">RS</span> 120 </div>
            </div>
            <div class="su3bx">
                <div class="offferrate1"><span class="rupee">RS</span> 69 </div>
            </div>

            <div class="su3bx">
                <div class="offferrate3">- 69% </div>
            </div>

        </div>

        <div class="clear"></div>
    </div>
</div>
<div>
    <div class="deal"> <img src="<?= base_url();?>assets/public/images/mydeals/10.jpg" class="indxprct">

        <a href="deal-inner.php">
            <div class="redmr2">Get this deal</div>
        </a>
        <div class="su_box100 dealbg1">
            <h4><img src="<?= base_url();?>assets/public/images/home/bismi.png" class="logoleft">Deal with Bismi  </h4>
        </div>

        <h3>Sansui 150 L Direct Cool Single Door Refrigerator  </h3>
        <div class="clear"></div>
        <div class="">
            <div class="su3bx">
                <div class="oldrate1"><span class="rupee">RS</span> 120 </div>
            </div>
            <div class="su3bx">
                <div class="offferrate1"><span class="rupee">RS</span> 69 </div>
            </div>

            <div class="su3bx">
                <div class="offferrate3">- 69% </div>
            </div>

        </div>

        <div class="clear"></div>
    </div>
</div>
<div>
    <div class="deal"> <img src="<?= base_url();?>assets/public/images/mydeals/10.jpg" class="indxprct">

        <a href="deal-inner.php">
            <div class="redmr2">Get this deal</div>
        </a>
        <div class="su_box100 dealbg1">
            <h4><img src="<?= base_url();?>assets/public/images/home/bismi.png" class="logoleft">Deal with Bismi  </h4>
        </div>

        <h3>Sansui 150 L Direct Cool Single Door Refrigerator  </h3>
        <div class="clear"></div>
        <div class="">
            <div class="su3bx">
                <div class="oldrate1"><span class="rupee">RS</span> 120 </div>
            </div>
            <div class="su3bx">
                <div class="offferrate1"><span class="rupee">RS</span> 69 </div>
            </div>

            <div class="su3bx">
                <div class="offferrate3">- 69% </div>
            </div>

        </div>

        <div class="clear"></div>
    </div>
</div>
<div>
    <div class="deal"> <img src="<?= base_url();?>assets/public/images/mydeals/10.jpg" class="indxprct">

        <a href="deal-inner.php">
            <div class="redmr2">Get this deal</div>
        </a>
        <div class="su_box100 dealbg1">
            <h4><img src="<?= base_url();?>assets/public/images/home/bismi.png" class="logoleft">Deal with Bismi  </h4>
        </div>

        <h3>Sansui 150 L Direct Cool Single Door Refrigerator  </h3>
        <div class="clear"></div>
        <div class="">
            <div class="su3bx">
                <div class="oldrate1"><span class="rupee">RS</span> 120 </div>
            </div>
            <div class="su3bx">
                <div class="offferrate1"><span class="rupee">RS</span> 69 </div>
            </div>

            <div class="su3bx">
                <div class="offferrate3">- 69% </div>
            </div>

        </div>

        <div class="clear"></div>
    </div>
</div>

</section>

</div>

</section>



<div id="back-top" style="display: block;"> <a class="gototop" href="#"><span></span> </a> </div>
<?php echo $footer; ?>
<!-- <script src="<?= base_url();?>assets/public/js/cbpHorizontalMenu.min.js"></script>
<script>
      $(function() {
        cbpHorizontalMenu.init();
      });
    </script> -->

<script src="<?= base_url();?>assets/public/js/smooth-scroll.js"></script>
<script>
    //smoothScroll.init();
    smoothScroll.init({

        speed: 1000, // Integer. How fast to complete the scroll in milliseconds
        easing: 'easeInOutCubic', // Easing pattern to use
        offset: 120, // Integer. How far to offset the scrolling anchor location in pixels
        callback: function ( anchor, toggle ) {} // Function to run after scrolling
    });
</script>

<!--=======================================slider right==============================================-->

<script src="<?= base_url();?>assets/public/js/slick.js" type="text/javascript" charset="utf-8"></script>
<script>

    $(document).on('ready', function() {
        $('.regular').slick({
            dots: false,
            loop: true,
            speed: 300,
            slidesToShow: 5,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
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