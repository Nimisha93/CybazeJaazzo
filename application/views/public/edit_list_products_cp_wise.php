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
    <title>Jaazzo | rewards unlimitted</title>
    <link rel="shortcut icon" href="<?= base_url();?>assets/public/favicon/favicon.png">
    <?= $default_assets;?>

    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/slick.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/slick-theme.css">
<link rel='stylesheet' href='<?= base_url();?>assets/public/css/dscountdown.css' type='text/css' media='all' />



    <style type="text/css">

        .row{margin:0;}
        .goToTop{position:fixed;border-bottom:1px solid #ccc;z-index: 17; background-color: #000;}

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


<!--===========header end here ========================-->
<div id="success" class="modal fade zndx1 " role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">

            <div class="modal-body">
                <p>success...</p>
            </div>

        </div>

    </div>
</div>
<header>
    <section>
        <div class="pos3">
            <div class="container-fluid">

                <div class="clear"></div>

            </div></div>

    </section>
</header>

</div>






<!-- ============================================================================================-->


<div class="clear"></div>


<!-- ============================================================================================-->
<div class="module_sldr_contnr">


    <!--**********************************************************************-->
    <div class="module_sldleft">
        <div class="">
            <div class="">
                <div id="myCarousel" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                        <li data-target="#myCarousel" data-slide-to="3"></li>
                        <li data-target="#myCarousel" data-slide-to="4"></li>
                    </ol>

                    <!-- Wrapper for slides -->
                    <div class="carousel-inner">
                        <div class="item active"> <img src="<?php echo base_url();?>assets/images/banner1.jpg" alt="Jaazzo"> </div>
                        <div class="item"> <img src="<?php echo base_url();?>assets/images/banner2.jpg" alt="Jaazzo"> </div>
                        <div class="item"> <img src="<?php echo base_url();?>assets/images/banner3.jpg" alt="Jaazzo"> </div>
                        <div class="item"> <img src="<?php echo base_url();?>assets/images/banner4.jpg" alt="Jaazzo"> </div>
                        <div class="item"> <img src="<?php echo base_url();?>assets/images/banner5.jpg" alt="Jaazzo"> </div>
                    </div>

                    <!-- Left and right controls -->
                    <a class="left carousel-control" href="#myCarousel" data-slide="prev"> <span class="glyphicon glyphicon-chevron-left"></span> <span class="sr-only">Previous</span> </a> <a class="right carousel-control" href="#myCarousel" data-slide="next"> <span class="glyphicon glyphicon-chevron-right"></span> <span class="sr-only">Next</span> </a> </div>
            </div>
        </div>
        <div class="clearfix"></div>
    </div>


    <div class="module_sldright">
        <div id="carousel" class="carousel  carousel-fade" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carousel" data-slide-to="0" class="active"></li>
                <li data-target="#carousel" data-slide-to="1"></li>
                <li data-target="#carousel" data-slide-to="2"></li>
                <li data-target="#carousel" data-slide-to="3"></li>
            </ol>
            <!-- Carousel items -->
            <div class="carousel-inner">
                <div class="active item"> <img src="<?php echo base_url();?>assets/images/add1.jpg" alt=""> </div>
                <div class="item"> <img src="<?php echo base_url();?>assets/images/add2.jpg" alt=""> </div>
                <div class="item"> <img src="<?php echo base_url();?>assets/images/add3.jpg" alt=""> </div>
                <div class="item"> <img src="<?php echo base_url();?>assets/images/add4.jpg" alt=""> </div>
            </div>
            <!-- Carousel nav -->

        </div>
    </div>
</div>

<div class="clear"></div>

<main class="cd-main-content top_pad20" style="background-color:#f7f7f7">
<?php if(!empty($deals)) {?>
    <section>

        <div class="container bm_mar20">

            <div class="sc_cntnt">

                <div class="tp_mar10">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="hdln1">
                            <h4>Crazy Deals</h4>
                            <a href="<?= base_url();?>home/get_all_deals_cp_wise/<?= $cp_id; ?>">
                                <div class="redmr1">See All </div>
                            </a>
                           </div></div>
                </div>

                <div class="tp_mar20 clear"></div>


                <div class="hover15">
                    <div class="regular2 slider">
                        
                        <?php foreach ($deals as $key => $deal) { ?>
                            <div>
                                <a href="<?= base_url() ?>home/deal_details/<?= $deal['id']; ?>">
                                    <div class="deal" style="height: 388px;">
                                    <div class="indxprct">
                                     <img src="<?php echo base_url(). $deal['image'];?>" class="">
                                     </div>



                                        <div class="su_box100 dealbg1">
                                            <h4><img src="<?php echo base_url().$deal['partner_img'];?>" class="logoleft">Deal with <?php echo $deal['partner'];?>   </h4>
                                        </div>

                                        <h3><?php echo $deal['name'];?></h3>
                                        <div class="clear"></div>
                                        <div class="">
                                            <div class="su3bx">
                                                <div class="oldrate1"><span class="rupee">RS</span> <?php echo $deal['actual_cost'];?> </div>
                                            </div>
                                            <div class="su3bx">
                                                <?php
                                                $bal = $deal['actual_cost'] - $deal['special_prize'];
                                                if ($deal['actual_cost']<1) { $per = 01; }
                                                else{ $per = (100 * $bal)/$deal['actual_cost'];  }
                                                ?>

                                                <div class="offferrate3"><?= sprintf("%.2f",$per) ?>% Off</div>
                                            </div>
                                            <br>

                                            <div class="su3bx">
                                                <div class="offferrate1"><span class="rupee">RS</span> <?php echo $deal['special_prize'];?></div>
                                            </div>
                                            <!-- <?php echo $deal['end_date'];?> -->
                                            <div class="demo3" data-date="<?php echo $deal['end_date'];?>"></div>
                                        </div>

                                        <div class="clear"></div>
                                    </div>
                                </a>
                            </div>

                            <?php }?>
                        
                    </div>

                </div>
            </div>
        </div>
    </section>
<?php } ?>    
<div class="clear"></div>
<?php if(!empty($product['product'])) {?>    
    <section class="hover15">

        <div class="container bm_mar20">
            <div class="sc_cntnt">
                <div class="tp_mar10 ">

                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="hdln1">
                            <h4>Products</h4>
                            <a href="<?= base_url();?>home/get_all_products_cp_wise/<?= $cp_id; ?>">
                                <div class="redmr1">See All </div>
                            </a>
                             </div>
                    </div>

                    <div class="tp_mar20 clear"></div>


                    <div class="">
                        <div class="regular2 slider">
                            <?php  foreach ($product['product'] as $key => $produ) { ?>
                            <div>
                                <a href="<?= base_url() ?>home/product_details/<?= $produ['id']; ?>">
                                    <div class="deal">  <div class="indxprct"><img src="<?=  base_url().$produ['image'];?>" class="">

 </div>


                                        <div class="su_box100 dealbg1">
                                            <h4><img src="<?php echo base_url(). $produ['partner_img'];?>" class="logoleft"><?php echo $produ['partner'];?> </h4>
                                        </div>

                                        <h3><?php echo $produ['name'];?></h3>
                                        <div class="clear"></div>
                                        <div class="">
                                            <div class="su3bx">
                                                <div class="offferrate1"><span class="rupee">RS</span><?php echo $produ['special_prize'];?> </div>
                                            </div>
                                            
                                            <div class="su3bx">
                                                <div class="offferrate3"><?= sprintf("%.2f",$produ['reward_percentage']) ?>% Off </div>
                                            </div>
                                            <br>

                                        </div>

                                        <div class="clear"></div>
                                    </div>
                                </a>
                            </div>

                            <?php } ?>
                        </div>

                    </div>
                </div>
            </div>

    </section>
<?php }?>


</main>


<!--===========main end here ========================-->


<?php echo $footer; ?>

<!--=======================================slider right==============================================-->
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


<script type="text/javascript">
    // <![CDATA[
    $(document).ready(function() {
        $(".gototop").click(function() {
            $("html, body").animate({"scrollTop": "0px"});
        });
    });
</script>



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
            slidesToShow: 6,
            slidesToScroll: 5,
            responsive: [
                {
                    breakpoint: 1360,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 4,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },

                {
                    breakpoint: 700,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 1
                    }
                },

                {
                    breakpoint: 550,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
                        infinite: true,
                        dots: true
                    }
                },

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
            slidesToShow: 5,
            slidesToScroll: 4,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 3,
                        infinite: true,
                        dots: true
                    }
                },
                {
                    breakpoint: 700,
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

</script>


</body>
</html>