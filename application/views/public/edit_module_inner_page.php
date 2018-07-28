<?php echo $default_assets ?>

    <link rel="shortcut icon" href="<?= base_url();?>assets/public/favicon/favicon.png">
    
    
  
     <link rel="stylesheet" href="<?= base_url();?>assets/public/css/responsiveslides.css">
  <link rel="stylesheet" href="<?= base_url();?>assets/public/css/demo.css">
  


    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/slick.css">
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/slick-theme.css">




<style type="text/css">
     .row{margin-left:0 !important; margin-right:0 !important;}

        .goToTop{position:fixed ;border-bottom:1px solid #ccc;background-color: #000}
		
        @media (max-width:1000px){

            .goToTop{height:auto;position:relative}


        }
	
		</style>

<?php echo $header; ?>
</div>
<div class="container-fluid">
<div class="col-lg-8 col-md-8 col-sm-8 col-xs-12 ">
<div class="nopad">
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
    <img class="sldriamageht" src="<?php echo base_url();?>assets\public\images\sld1.jpg" alt="">
    </div>

    <div class="item">
     <img class="sldriamageht" src="<?php echo base_url();?>assets\public\images\sld2.jpg" alt="">
    </div>

    <div class="item">
     <img class="sldriamageht" src="<?php echo base_url();?>assets\public\images\sld3.jpg" alt="">
    </div>

    <div class="item">
      <img class="sldriamageht" src="<?php echo base_url();?>assets\public\images\sld4.jpg" alt="">
    </div>
  </div>

  <!-- Left and right controls -->

</div>

</div></div>
<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 ">
<div class="nopad">
   <div id="wrapper">
   
  
    <ul class="rslides" id="slider1">
      <li><img class="sldriamageht" src="<?php echo base_url();?>assets\public\images\sldd1.jpg" alt=""></li>
      <li><img class="sldriamageht" src="<?php echo base_url();?>assets\public\images\sldd2.jpg" alt=""></li>
      <li><img class="sldriamageht" src="<?php echo base_url();?>assets\public\images\sldd3.jpg" alt=""></li>
       <li><img class="sldriamageht" src="<?php echo base_url();?>assets\public\images\sldd4.jpg" alt=""></li>
    </ul>
    
    </div>

</div>
</div>

</div>

<div class="clear"></div>

<?php  foreach($product['module'] as $key => $pro) { ?>
    <section>

<div class="container bm_mar20">
<div class="tp_mar20 ">
    <div class="hdln1">
        <h4>Premium <?php echo $pro['module_name'];?></h4>
        <a href="<?= base_url();?>home/get_all_products">
            <div class="redmr1">See All </div>
        </a> </div>
</div>

<div class="tp_mar20 clear"></div>
<div class="col-md-3 col-sm-3 hidden-xs">
    <img src="<?php echo base_url();?>assets/admin/products/<?php echo $pro['module_image'];?>">
</div>

<div class="col-md-9 col-sm-9 col-xs-12">
<div class="regular2 slider">
     <?php  foreach($pro['product'] as $key => $products) { ?>z
    <div>

        <div class="deal"> 
        <a href="<?php echo base_url();?>home/product_details/<?php echo $products['p_id'];?>">
 <div class="indxprct">
<img src="<?php echo base_url();?>assets/admin/products/<?php echo $products['image'];?>" class="">

                          
</div>
                            <div class="su_box100 dealbg1">
                                <h4><img src="<?php echo base_url();?>assets/admin/products/<?php echo $products['par_img'];?>" class="logoleft">Deal with <?php echo $products['partner_name'];?> </h4>
                            </div>

                         <h3><?php echo $products['name'];?> </h3>
                            <div class="clear"></div>
                            <div class="">
                                <div class="su3bx">
                                 <div class="oldrate1"><span class="rupee">RS</span><?php echo $products['cost'];?> </div>
                                </div>
                                 <div class="su3bx ofrright">
                                    <div class="offferrate3">- 69% </div>
                                </div>
                                <br>

                                <div class="su3bx">
                                    <div class="offferrate1"><span class="rupee">RS</span> <?php echo $products['actual_cost'];?> </div>
                                </div>

                               

                            </div>
                             </a>
                            <div class="clear"></div>
                        </div>
                        

    </div>
<?php }?>



</div>

</div>
</div>
</section>
    <?php }?>
    
    
<?php echo $footer; ?>

  <script src="<?= base_url();?>assets/public/js/responsiveslides.min.js"></script>
  
<script>
    // You can also use "$(window).load(function() {"
    $(function () {

      // Slideshow 1
      $("#slider1").responsiveSlides({
        maxwidth: 800,
        speed: 800
      });

      // Slideshow 2
     $(".rslides").responsiveSlides({
  auto: true,             // Boolean: Animate automatically, true or false
  speed: 500,            // Integer: Speed of the transition, in milliseconds
  timeout: 4000,          // Integer: Time between slide transitions, in milliseconds
  pager: false,           // Boolean: Show pager, true or false
  nav: false,             // Boolean: Show navigation, true or false
  random: false,          // Boolean: Randomize the order of the slides, true or false
  pause: false,           // Boolean: Pause on hover, true or false
  pauseControls: true,    // Boolean: Pause when hovering controls, true or false
  prevText: "Previous",   // String: Text for the "previous" button
  nextText: "Next",       // String: Text for the "next" button
  maxwidth: "",           // Integer: Max-width of the slideshow, in pixels
  navContainer: "",       // Selector: Where controls should be appended to, default is after the 'ul'
  manualControls: "",     // Selector: Declare custom pager navigation
  namespace: "rslides",   // String: Change the default namespace used
  before: function(){},   // Function: Before callback
  after: function(){}     // Function: After callback
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
                    breakpoint: 700,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 2
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
                    breakpoint: 700,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 2
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