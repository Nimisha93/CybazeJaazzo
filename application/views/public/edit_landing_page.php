<?= $default_assets;?>

<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/slick.css">
<link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/slick-theme.css">
<link rel="stylesheet" href="<?= base_url();?>assets/public/css/flexslider.css" type="text/css" media="screen" />

<link rel='stylesheet' href='<?= base_url();?>assets/public/css/dscountdown.css' type='text/css' media='all' />
<style type="text/css">

    .row{margin:0;}
    .goToTop{position:fixed;border-bottom:1px solid #ccc;z-index: 17;    background-color: #000;}

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


                    <div class="flexslider carousel">
                        <ul class="slides">
                            <?php foreach ($submenu as $key => $submenu) {
                            $id = $submenu['id'];?>


                            <li>

                                <a href="<?php echo base_url(); ?>Home/module_single/<?php echo $id ?>" target="_blank">
                                    <div class="mnuht">
                                        <i class="fa fa-trello clear2" aria-hidden="true"></i>

                                        <?php echo $submenu['module_name'];?>


                                    </div>
                                    <div class="bordrmnu"><div class="bordrmnu_sub"></div></div>

                                </a>

                            </li>

                            <?php }?>

                        </ul>
                    </div>
                    <!-- ============================================================================================-->
                </div>
            </div>


        </div>
    </div>

    </div>
</section>

<!-- ============================================================================================-->
<section class="bgclr2 botm_pad30">
    <div class="container-fluid ">

        <div class="col-md-4 col-sm-4 col-xs-12 tp_mar20">
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
                    <?php $i=0; foreach($left_adv as $left)
                {
                    if($i==0)
                    {
                        $class='active';
                    }
                    else
                    {
                        $class='';
                    }
                    ?>
                    <div class="item <?php echo $class ?>">
                        <img src="<?php echo base_url();?>/upload/<?=$left['image'];?>">
                    </div>
                    <?php $i++; } ?>
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


        <div class="col-md-4 col-sm-4 col-xs-12 tp_mar20">
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
                    <?php   $i=0; foreach($centre_adv as $center)
                {
                    if($i==0)
                    {
                        $class='active';
                    }
                    else
                    {
                        $class='';
                    }
                    ?>
                    <div class="item <?php echo $class ?>">
                        <img src="<?php echo base_url();?>/upload/<?= $center['image']; ?>">
                    </div>

                    <?php $i++; } ?>

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


        <div class="col-md-4 col-sm-4 col-xs-12 tp_mar20">
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
                    <?php $i=0; foreach($right_adv as $right)
                {
                    if($i==0)
                    {
                        $class='active';
                    }
                    else
                    {
                        $class='';
                    }
                    ?>
                    <div class="item <?php echo $class ?>">
                        <img src="<?php echo base_url();?>/upload/<?= $right['image']; ?>">
                    </div>

                    <?php $i++; } ?>

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

<main class="cd-main-content top_pad20 bgoff " >
<?php
$com = get_commission();
$customer_per = $com['customer_commission'];
?>

<?php if(!empty($deals)) {?>
<section class="hover15">

    <div class="container bm_mar10">


        <div class="clear"></div>

        <div class="sc_cntnt">

            <div class="tp_mar10 bm_mar10 col-md-12">
                <div class="hdln1">
                    <h4>Crazy Deals</h4>
                    <a href="<?= base_url();?>home/get_all_deals">
                        <div class="redmr1">See All </div>
                    </a> </div>
            </div>


            <div class="">
                <div class="col-md-12">
                    <div class="regular slider todaysdeal">
                        <?php foreach ($deals as $key => $deal) { ?>
                        <div>
                            <a target="_blank" href="<?php echo base_url();?>home/deal_details/<?php echo $deal['pr_id'];?>" >

                                <div class="deal">
                                    <div class="indxprct">
                                        <img src="<?php echo base_url().$deal['image'];?>" class="">
                                        <?php
                                            $voucher_price = ($deal['special_prize'] * $deal['coupon_percentage'])/ 100;
                                        ?>
                                        <div class="leftpr">Voucher price<br><?= $voucher_price ?></div>
                                    </div>

                                    <div class="su_box100 dealbg1">
                                        <h4><img src="<?php echo base_url(). $deal['brand_image'];?>" class="logoleft">

                                            Deal with  <?php echo $deal['cp_name'];?>
                                        </h4>
                                    </div>

                                    <h3><?php echo $deal['name'];?> </h3>
                                    <div class="clear"></div>
                                    <div class="">
                                        <div class="su3bx">
                                            <div class="oldrate1"><span class="rupee">RS</span><?php echo $deal['actual_cost'];?> </div>
                                        </div>
                                        <div class="su3bx ofrright">
                                            <?php
                                            $bal = $deal['actual_cost'] - $deal['special_prize'];
                                            if ($deal['actual_cost']<1) { $per = 01; }
                                            else{ $per = (100 * $bal)/$deal['actual_cost'];  }
                                            ?>
                                            <div class="offferrate3"><?= sprintf("%.2f",$per) ?>% off </div>
                                        </div>
                                        <br>


                                        <div class="su3bx">
                                            <div class="offferrate1"><span class="rupee">RS</span> <?php echo $deal['special_prize'];?> </div>
                                        </div><!-- February 11, 2018 12: 00: 00 -->
                                        <!--December 24, 2018 23:59:00-->
              
                                        <div class="demo3" data-date="<?php echo $deal['end_date'];?>"></div>

                                    </div>

                                    <div class="clear"></div>
                                </div></a>

                        </div>
                        <?php } ?>



                    </div></div>

            </div></div>
    </div>
</section>
<?php } ?>
<!-- ======================== section end here ====================================================================-->
<?php if(!empty($products)) {?>
<section class="hover15">


    <div class="container bm_mar10">


        <div class="clear"></div>

        <div class="sc_cntnt">

            <div class="tp_mar10 bm_mar10 col-md-12">
                <div class="hdln1">
                    <h4>All Products</h4>
                 
                        <div class="redmr1" id="see_all" style= "cursor:pointer">See All </div>
                    </div>
            </div>


            <div class="dealiconimagesction">
                <img class="dealiconimage" src="<?= base_url();?>assets/public/images/mydeals/channel.jpg">
            </div>
            <div class="slidrscetion">
                <div class="col-md-12">
                    <div class="regular2 slider">
                        <?php  foreach ($products as $key => $produ) { 
                           $reward_price = $produ['special_prize'] * ( $produ['reward_percentage'] / 100)* ($customer_per / 100); 
                           $per = ($reward_price * 100) / $produ['special_prize']; 
                        ?>
                        <div>
                            <a target="_blank" href="<?php echo base_url();?>home/product_details/<?php echo $produ['pr_id'];?>">

                                <div class="deal">
                                    <div class="indxprct">
                                        <img src="<?php echo base_url(). $produ['image'];?>" class="">
                                    </div>



                                    <div class="su_box100 dealbg1">
                                        <h4><img src="<?php echo base_url(). $produ['brand_image'];?>" class="logoleft">

                                            <?php echo $produ['cp_name'];?>
                                        </h4>
                                    </div>

                                    <h3><?php echo $produ['name'];?> </h3>
                                    <div class="clear"></div>
                                    <div class="">
                                        <div class="su3bx">
                                            <div class="su3bx ofrright"><span class="rupee">RS</span><?php echo $produ['special_prize'];?> </div>
                                        </div>
                                        <div class="su3bx ofrright">
                                           
                                            <div class="offferrate3"><?= sprintf("%.2f",$per) ?>% off </div>
                                        </div>
                                        <br>



                                    </div>

                                    <div class="clear"></div>
                                </div></a>

                        </div>
                        <?php }?>



                    </div></div>

            </div></div>
    </div>
</section>
<?php } ?>
<!-- ======================== section end here ====================================================================-->

<?php if(!empty($bottom_adv)) {?>
<section class="hover15">

    <div class="container">


        <div class="clear"></div>

        <div class="sc_cntnt">


            <div class=" tp_mar10 bm_mar20">
                <div class="regular3 slider">
                      <?php foreach($bottom_adv as $bottom) { ?>
                    <div>
                        <a href="<?php echo base_url();?>home/product_details/<?php echo $bottom['id'];?>">

                            <div class="deal_add">

                                <img src="<?php echo base_url();?>/upload/<?= $bottom['image']; ?>" class="">

                                <div class="clear"></div>
                            </div></a>

                    </div>
                    <?php } ?>



                </div></div>

        </div>
    </div>
</section>
<?php } ?>

<div class="clear"></div>

<?php  foreach($product['module'] as $key => $pro) { 
if(!empty($pro['product'])){ ?>
<section class="hover15">

    <div class="container tp_mar10">
        <div class="sc_cntnt">
            <div class="tp_mar10 bm_mar10 col-md-12">
            <div class="hdln1">
                <h4>Premium <?php echo $pro['module_name'];?></h4>
                <a target="_blank" href="<?= base_url();?>home/get_all_products">
                    <?php $id = $pro['id']; ?>
                    <a href="<?php echo base_url(); ?>Home/module_single/<?php echo $id ?>" target="_blank"><div class="redmr1">See All </div>
                    </a>
                </a> </div>
        </div>

        <div class="tp_mar20 clear"></div>
        <div class="dealiconimagesction">
            <img  class="dealiconimage" src="<?php echo base_url(). $pro['module_image'];?>">
        </div>
            <div class="slidrscetion">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="regular2 slider">
                <?php  foreach($pro['product'] as $key => $products) { 
                           
                           $reward = $products['special_prize'] * ( $products['reward_percentage'] / 100)* ($customer_per / 100); 
                           $perz = ($reward * 100) / $products['special_prize'];
                ?>
                <div>
                    <a target="_blank" href="<?php echo base_url();?>home/product_details/<?php echo $products['p_id'];?>">

                    <div class="deal">
                        <div class="indxprct"><img src="<?php echo base_url(). $products['image'];?>" class="">

</div>


                        <div class="su_box100 dealbg1">
                            <h4><img src="<?php echo base_url(). $products['par_img'];?>" class="logoleft"><?php echo $products['partner_name'];?> </h4>
                        </div>

                        <h3><?php echo $products['name'];?> </h3>
                        <div class="clear"></div>
                        <div class="">
                            <div class="su3bx">
                                <div class="offferrate1"><span class="rupee">RS</span><?php echo $products['special_prize'];?> </div>
                            </div>
                           
                            <div class="su3bx ofrright">
                                <div class="offferrate3"> <?= sprintf("%.2f",$perz) ?>% Off </div>
                            </div>
</br>
                        </div>

                        <div class="clear"></div>
                    </div>
                    </a>
                </div>
                <?php }?>



            </div></div>

        </div>
    </div>
    </div>
</section>
<?php } }?>
<!-- ======================== section end here ====================================================================-->

</main>
</section>

<!-- ============================================================================================-->



</main>
<?php echo $footer; ?>


<script type="text/javascript" src="<?= base_url();?>assets/public/js/dscountdown.min.js"></script>
<script>
    jQuery(document).ready(function($){

        $(".demo3").each(function() {
            var cur = $(this);

            cur.dsCountDown({
                endDate: new Date($(this).data('date')),
                theme: 'red'
            });

        });
    });
</script>


<script defer src="<?= base_url();?>assets/public/js/jquery.flexslider.js"></script>

<script type="text/javascript">

    (function() {

        // store the slider in a local variable
        var $window = $(window),
                flexslider = { vars:{} };

        // tiny helper function to add breakpoints
        function getGridSize() {

        }
        $window.load(function() {
            $('.flexslider').flexslider({
                animation: "slide",
                autoplay: "false",
                animationSpeed: 400,
                animationLoop: false,
                itemWidth: 120,
                itemMargin: 5,
                minItems: getGridSize(), // use function to pull in initial value
                maxItems: getGridSize(), // use function to pull in initial value
                start: function(slider){
                    $('body').removeClass('loading');
                    flexslider = slider;
                }
            });
        });

        // check grid size on resize event
        $window.resize(function() {
            var gridSize = getGridSize();

            flexslider.vars.minItems = gridSize;
            flexslider.vars.maxItems = gridSize;
        });
    }());

</script>
<!--=======================================slider right==============================================-->
<script>

    $(document).on('ready', function() {
        $('.regular3').slick({
            dots: false,
            loop: true,
            autoplay:true,
            autoplaySpeed:4500,
            arrows:true,
            speed: 300,
            slidesToShow: 3,
            slidesToScroll: 3,
            responsive: [
                {
                    breakpoint: 1370,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: false
                    }
                },
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
                    breakpoint: 700,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2
                    }
                },

                {
                    breakpoint: 340,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: false
                    }
                },

                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    });

</script>
<script src="<?= base_url();?>assets/public/js/slick.js" type="text/javascript" charset="utf-8"></script>


<!-- FlexSlider -->




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
        $('.regular2').slick({
            dots: true,
            loop: true,
            speed: 300,
            slidesToShow: 4,
            slidesToScroll: 4,
            responsive: [
                {
                    breakpoint: 1370,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        infinite: true,
                        dots: true
                    }
                },
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
                    breakpoint: 700,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        autoplay:false
                    }
                },

                {
                    breakpoint: 550,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true,
                        autoplay:false,
                        dots: true
                    }

                },

                {
                    breakpoint: 340,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        autoplay:false,
                        dots: true
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
        $('.regular').slick({
            dots: true,
            loop: true,
            speed: 300,
            slidesToShow: 5,
            slidesToScroll: 5,
            responsive: [
                {
                    breakpoint: 1370,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 5,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                        infinite: true,

                        dots: true
                    }
                },

                {
                    breakpoint: 700,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 1,
                        autoplay:false
                    }
                },

                {
                    breakpoint: 550,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1,
                        infinite: true,
                        autoplay:false,
                        dots: true
                    }

                },

                {
                    breakpoint: 340,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        autoplay:false,
                        dots: true
                    }

                }

                // You can unslick at a given breakpoint now by adding:
                // settings: "unslick"
                // instead of a settings object
            ]
        });
    });
 $(document).on("click", '#see_all',function(){
    var location = ($('#hidden_location').val())? $('#hidden_location').val(): 0;
    window.location.href = "<?= base_url();?>home/get_all_products/"+location;
 });
 
</script>



</body>
</html>