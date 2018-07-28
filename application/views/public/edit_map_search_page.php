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
<?php echo $default_assets ?>


    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/slick.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/slick-theme.css">

<link rel="stylesheet" type="text/css" href="../_public/_css/jquery-ui-1.8.21.custom.css" />
<script type="text/javascript" src="../_public/_jquery/jquery-1.7.1.js"></script>
<script type="text/javascript" src="../_public/_jquery/jquery-ui-1.8.21.custom.min.js"></script>

   
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
  height: 210px;
  z-index: 10;
}
.row{margin:0;}
}
</style>
<?php echo $header; ?>

<div class="clear"></div>
</header>
</div>
<div class="container-fluid maxmapbx nopaddiv">
<div class="col-lg-3 col-md-3 col-sm-4 col-xs-4 nopaddiv">

<div class="clubmmbr">

      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 maptp20">                  
<img class="smalpr" src="<?php echo base_url();?>assets/public/images/home/klyan.png">

<div class="mapmmrname">Kalyan Silks</div>
</div>

<div id="custom-search-input" class="">
                            <div class="input-group col-md-12 ">
                                <input type="text" class=" maptp20 search-query form-control" value="kumbalanga" />
                                <span class="input-group-btn">
                                    <button class="btn" type="button">
                                        <span class=" glyphicon glyphicon-search"></span>
                                    </button>
                                </span>
                            </div>
                        </div>

</div>
<div class="clear"></div>

<div class="col-lg-1 col-md-1 col-sm-12 col-xs-12 "></div>

<div class="col-lg-10 col-md-10 col-sm-12 col-xs-12 ">

<section class="regular slider">
<?php foreach ($deal as $key => $deal) { ?>
    <div>

        <div class="deal"> <img src="<?php echo base_url();?>assets\admin\products\<?php echo $deal['image'];?>" class="indxprct">

            <a href="<?php echo base_url();?>home/product_deal/<?php echo $deal['id'];?>">
                <div class="redmr2">Get this deal</div>
            </a>
            

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


</div>

<div class="col-lg-9 col-md-9 col-sm-8 col-xs-8 nopaddiv">

<iframe src="https://www.google.com/maps/embed?pb=!1m14!1m12!1m3!1d31283.704553844615!2d75.68253401244945!3d11.44646454379703!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!5e0!3m2!1sen!2sin!4v1491562061389" width="100%" height="100%" frameborder="0" style="border:0" allowfullscreen></iframe>

</div>

</div>

<?php echo $footer; ?>

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
            slidesToShow: 1,
            slidesToScroll: 1,
            responsive: [
                {
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 1,
                        slidesToScroll: 1,
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

