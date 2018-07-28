<?= $default_assets;?>
<style>


 .row{margin:0;}
    .goToTop{position:fixed;border-bottom:1px solid #ccc;z-index: 17;    background-color: #d88909;}

    @media (max-width:1030px){

        .goToTop{height:auto;position:relative;}


    }
    @media (max-width:767px){

        .goToTop {
            position: relative;
            top: 0;
            left: 0;
            z-index: 10;
            background-color: #d88909;
        }
    }

    .content {
        padding-top: 30px;
    }

        /* Testimonials */
    .testimonials blockquote {
        background: #f8f8f8 none repeat scroll 0 0;
        border: medium none;
        color: #666;
        display: block;
        font-size: 14px;
        line-height: 20px;
        padding: 15px;
        position: relative;
    }
    .testimonials blockquote::before {
        width: 0;
        height: 0;
        right: 0;
        bottom: 0;
        content: " ";
        display: block;
        position: absolute;
        border-bottom: 20px solid #fff;
        border-right: 0 solid transparent;
        border-left: 15px solid transparent;
        border-left-style: inset; /*FF fixes*/
        border-bottom-style: inset; /*FF fixes*/
    }
    .testimonials blockquote::after {
        width: 0;
        height: 0;
        right: 0;
        bottom: 0;
        content: " ";
        display: block;
        position: absolute;
        border-style: solid;
        border-width: 20px 20px 0 0;
        border-color: #7886c3 transparent transparent transparent;
    }
    .testimonials .carousel-info img {
        border: 1px solid #f5f5f5;
        border-radius: 150px !important;
        height: 75px;
        padding: 3px;
        width: 75px;
    }
    .testimonials .carousel-info {

        overflow: hidden;
        border-bottom: 1px dotted #ccc;
        margin-bottom: 20px;
    }
    .testimonials .carousel-info img {
        margin-right: 15px;
    }
    .testimonials .carousel-info span {
        display: block;
    }
    .testimonials span.testimonials-name {
        color: #e6400c;
        font-size: 16px;
        font-weight: 300;
        margin: 23px 0 7px;
    }
    .testimonials span.testimonials-post {
        color: #656565;
        font-size: 12px;
    }

</style>
<body>
<?= $header;?>
</div>




<div class="container content" style="max-width: 1200px;">



    <div class="row">
        <div class="col-md-12 ">
            <div class="testimonials">
                <div class="active item">
                    <blockquote><p>Denim you probably haven't heard of. Lorem ipsum dolor met consectetur adipisicing sit amet, consectetur adipisicing elit, of them jean shorts sed magna aliqua. Lorem ipsum dolor met.</p></blockquote>
                    <div class="carousel-info">
                        <img alt="" src="http://keenthemes.com/assets/bootsnipp/img1-small.jpg" class="pull-left">
                        <div class="pull-left">
                            <span class="testimonials-name">Lina Mars</span>
                            <span class="testimonials-post">Commercial Director</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 ">
            <div class="testimonials">
                <div class="active item">
                    <blockquote><p>Denim you probably haven't heard of. Lorem ipsum dolor met consectetur adipisicing sit amet, consectetur adipisicing elit, of them jean shorts sed magna aliqua. Lorem ipsum dolor met.</p></blockquote>
                    <div class="carousel-info">
                        <img alt="" src="http://keenthemes.com/assets/bootsnipp/img1-small.jpg" class="pull-left">
                        <div class="pull-left">
                            <span class="testimonials-name">Lina Mars</span>
                            <span class="testimonials-post">Commercial Director</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12 ">
            <div class="testimonials">
                <div class="active item">
                    <blockquote><p>Denim you probably haven't heard of. Lorem ipsum dolor met consectetur adipisicing sit amet, consectetur adipisicing elit, of them jean shorts sed magna aliqua. Lorem ipsum dolor met.</p></blockquote>
                    <div class="carousel-info">
                        <img alt="" src="http://keenthemes.com/assets/bootsnipp/img1-small.jpg" class="pull-left">
                        <div class="pull-left">
                            <span class="testimonials-name">Lina Mars</span>
                            <span class="testimonials-post">Commercial Director</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12 ">
            <div class="testimonials">
                <div class="active item">
                    <blockquote><p>Denim you probably haven't heard of. Lorem ipsum dolor met consectetur adipisicing sit amet, consectetur adipisicing elit, of them jean shorts sed magna aliqua. Lorem ipsum dolor met.</p></blockquote>
                    <div class="carousel-info">
                        <img alt="" src="http://keenthemes.com/assets/bootsnipp/img1-small.jpg" class="pull-left">
                        <div class="pull-left">
                            <span class="testimonials-name">Lina Mars</span>
                            <span class="testimonials-post">Commercial Director</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>


<?php echo $footer; ?>

</body>

</html>