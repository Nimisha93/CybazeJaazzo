<?= $default_assets;?>

<style type="text/css">

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
</style>

<body>
<?= $header;?>
</div>


<div class="container" style="margin-top: 50px;margin-bottom: 50px;max-width: 1200px">

<div class="newsbx">
    <div class="newsimagbx">
        <img src="<?= base_url();?>assets/public/images/online-portal-logo.png">
    </div>
<div class="neswscntnt">
<h3>News Heading 1</h3>
<h6><span class="date">February 8, 2018</span> </h6>
    <div style="margin-top: 10px;font-size: 15px;line-height: 24px">UiPath is the backbone for the intelligent enterprise. Daniel’s clear and ambitious vision for the company has helped
       drive impressive traction in a short period of time.
       Many enterprises around the world are recognizing how its RPA software can make their business smarter, and yet </div>

    <a href="<?= base_url();?>home/news_more/" class="redmornews">More..</a>

</div>
    </div>



    <div class="newsbx">
        <div class="newsimagbx">
            <img src="<?= base_url();?>assets/public/images/online-portal-logo.png">
        </div>
        <div class="neswscntnt">
            <h3>News Heading 2</h3>
            <h6><span class="date">February 8, 2018</span> </h6>
            <div style="margin-top: 10px;font-size: 15px;line-height: 24px">UiPath is the backbone for the intelligent enterprise. Daniel’s clear and ambitious vision for the company has helped
               drive impressive traction in a short period of time.
               Many enterprises around the world are recognizing how its RPA software can make their business smarter, and yet </div>

            <a href="<?= base_url();?>home/news_more/" class="redmornews">More..</a>

        </div>
    </div>


</div>
<?php echo $footer; ?>

</body>

</html>