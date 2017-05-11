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
    <link rel="stylesheet" type="text/css" href="<?= base_url();?>assets/public/css/delear.css">
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Arima+Madurai:100,200,300,400,500,700,800,900" rel="stylesheet">
    <script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>
   <script>
       $().ready(function(){
           $('[rel="tooltip"]').tooltip();

       });

       function rotateCard(btn){
           var $card = $(btn).closest('.card-container');
           console.log($card);
           if($card.hasClass('hover')){
               $card.removeClass('hover');
           } else {
               $card.addClass('hover');
           }
       }
   </script>



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


<div class="container">
<div class="row">
<div class="col-sm-10 col-sm-offset-1">

    <?php foreach($delears as $delear) { ?>

    <div class="col-md-4 col-sm-6" style="margin-bottom: 20px;">
        <div class="card-container manual-flip">
            <div class="card">
                <div class="front">
                    <div class="cover">
                        <img src="https://www.clipartsgram.com/image/124089475-california-beaches-tumblr-wallpaper-3.jpg"/>
                    </div>
                    <div class="user">
                        <img class="img-circle" src="http://www.outbrain.com/risingstars/wp-content/uploads/708x708-RS-Profile-Ashley-Callahan-400x400.jpg"/>
                    </div>
                    <div class="content">
                        <div class="main">
                            <h3 class="name"><?php echo $delear['name']; ?></h3>
                            <p class="profession"><?php echo $delear['email']; ?></p>
                            <p class="text-center">"Lamborghini Mercy <br>Your chick she so thirsty <br>I'm in that two seat Lambo"</p>
                        </div>

                    </div>
                </div> <!-- end front panel -->

            </div> <!-- end card -->
        </div> <!-- end card-container -->
    </div>

<?php } ?>

</div> <!-- end col-sm-10 -->
</div> <!-- end row -->
<div class="space-200"></div>
</div>












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