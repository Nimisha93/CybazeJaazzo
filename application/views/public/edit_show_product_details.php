<?= $default_assets;?>
<?php echo $map['js']; ?>
<!-- <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/slick.css">
<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/slick-theme.css"> -->

<link rel="stylesheet" href="<?= base_url();?>assets/public/css/flexslider-2.css" type="text/css" media="screen" />


<style type="text/css">

    .row{margin:0;}
    .goToTop{position:fixed;border-bottom:1px solid #ccc;z-index: 17;background-color: #000;}

    @media (max-width:1030px){

        .goToTop{height:auto;position:relative;}


    }
    @media (max-width:767px){

        .goToTop {
            position: relative;
            top: 0;
            left: 0;
            z-index: 10;
            background-color: #000;
        }
    }
    #map_canvas{height: 250px !important}
</style>
</head>

<body>

<!--===========header end here ========================-->


<?= $header;?>





</div>

<div class="clear"></div>

<!--===========main end here ========================-->



<!--===========section end here ========================-->


<!--===========section end here ========================-->
<div class="clear"></div>

<!-- Begin Body -->



<section class="bgclr6 top_pad20 botm_pad20">
<div id="photos" class=""></div>


<div class="clear" ></div>


<div class="container ">
<div class="bgclr3 border3">
<div class="col-md-12">

<div class="col-md-5 col-sm-5">

    <div class="slider">
        <?php 
            $com = get_commission();
            $customer_per = $com['customer_commission'];
            $reward_price = $products['details']['special_prize'] * ($products['details']['reward_percentage']  / 100)* ($customer_per / 100);
            //$reward_price = ($products['details']['special_prize'] * $products['details']['reward_percentage'] ) / 100;

        ?>
        <div id="slider" class="flexslider">





            


            <?php if( $reward_price !=0 ) { ?>
           
            <div class="inneroffr">Gain<span class="rupee">RS</span> <?php echo $reward_price;?></div>
            <?php } ?>








            <ul class="slides">
               
                <?php
                  foreach($products['images'] as $product)
                    {

                        ?>
                    <li style="height: 320px"> 
                      <img src="<?php echo base_url().$product['p_image']; ?>" />

                   </li>
                <?php  } ?>


            </ul>
        </div>
        <div id="carousel" class="flexslider">
            <ul class="slides">
               
                <?php   foreach($products['images'] as $product1)
                {

                 ?>
                
                      <li style="height:60px !important;position: relative;">
                    <img style="position: absolute;left: 0;right: 0;bottom: 0;top: 0;margin: auto;max-height: 100%" src="<?php echo base_url().$product1['p_image']; ?>" />
                </li>
                <?php } ?>


            </ul>
        </div>


    </div>


    <?php
    $bal = $products['details']['actual_cost'] - $products['details']['special_prize']; ?>




</div>


<div class="col-md-7 col-sm-7">

    <div class="brndname"><?php echo $products['details']['name'];?> </div>

    <div class="companylogo"><img src="<?php echo base_url(). $products['details']['brand_image'];?>"></div>
    <div class="companyname"><?php echo $products['details']['cp_name'];?></div>
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

                    <td class="descfix"><?php echo $products['details']['description'];?></td>
                </tr>


                </tbody>
            </table>

        </div>
        <div class="clear"></div>

        <a class="morspcfcn" data-scroll data-options='{ "easing": "easeInQuad" }' href="#more">more...</a>


        <div class="line1 tp_mar10"></div>
        <div class="col-md-12">

            <div class="ratebox">
                <table>


                    <tr>
                        <td class="brand_rate">Model</td>
                        <td class="brand_rate_actual"> <span class=""></span><?php echo $products['details']['model'];?> </td>
                    </tr>
                    <tr>
                        <td class="brand_rate"> MRP</td>
                        <td class="brand_rate_actual"> <span class="rupee">RS</span><?php echo $products['details']['special_prize'];?> </td>
                    </tr>
                   










                   <?php if($reward_price != 0) { ?>
                    <tr>
                        <td class="brand_rate"> Jaazzo Rewards</td>
                        <td class="brand_rate_actual"> <span class="rupee">RS</span><?= $reward_price;?> </td>
                    </tr>

                <?php } ?>









                </table>

            </div></div>
        <?php
        
        // $perc = $products['details']['reward_percentage'];
        $perc = ($reward_price * 100 )/$products['details']['special_prize'];
        ?>

    </div>












    <?php if($perc !=0) { ?>


    <div class="brand_offer"><?php echo round_number_no_decimal($perc);?>% Off</div>

    <?php } ?>













   
<div class="clear"></div>


</div>

<div class="clear"></div>
<div class="map_container">
                            <h3 class="">Location Details</h3>
                            <div class="col-md-7 mapht">
                        
                              <?php echo $map['html']; ?>

                            </div>
                            <div class="col-md-5">
                                <panel class="contact_details">
                                    <div>
                                        <div>
                                                <span><?= $products['details']['cp_name'] ?></span><br>
                                                <span><?= $products['details']['address'] ?>, <?= $products['details']['city'] ?> </span><br>

                                                                                            
                                                <span><?= $products['details']['state'] ?></span><br>
                                                <span><?= $products['details']['country'] ?></span><br>
                                                                                                                              
<div class="map_phn" ><i class="fa fa-phone " aria-hidden="true"></i> : +<?= $products['details']['phone'] ?> <br>

<i class="fa fa-envelope-o" aria-hidden="true"></i> : <a class="decoration" href=""><?= $products['details']['email'] ?></a>
 </div>


                                                                                                                                </div>
                                    </div>
                                </panel>
                            </div>
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
            <?php echo $products['details']['description'];?>
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



<div id="back-top" style="display: block;"> <a class="gototop" href="#"><span></span> </a> </div>
<?php echo $footer; ?>
<!-- <script src="<?= base_url();?>assets/public/js/cbpHorizontalMenu.min.js"></script>
<script>
      $(function() {
        cbpHorizontalMenu.init();
      });
    </script> -->

<script defer src="<?= base_url();?>assets/public/js/jquery.flexslider.js"></script>


<script type="text/javascript">

    $(window).load(function(){
        $('#carousel').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            itemWidth: 60,
            itemMargin: 5,
            asNavFor: '#slider'
        });

        $('#slider').flexslider({
            animation: "slide",
            controlNav: false,
            animationLoop: false,
            slideshow: false,
            sync: "#carousel",
            start: function(slider){
                $('body').removeClass('loading');
            }
        });
    });
</script>



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
<!-- 
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
                        slidesToShow: 4,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },
                {
                    breakpoint: 800,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                },
                {
                    breakpoint: 580,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                }
                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    });

</script> -->


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