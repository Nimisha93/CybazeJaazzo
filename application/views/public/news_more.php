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

<div class="container" style="max-width: 1200px;margin-top: 50px;margin-bottom: 50px;">

<img src="<?= base_url();?>upload/201706Tue100656.jpg" style="display: block;margin:15px  0;max-height: 600px;">

<div class="clearfix"></div>

    <div class="newsbx">
    <h2 style="text-align: left">News heading 1</h2>

    <h6><span class="date">February 8, 2018</span> </h6>
    <div style="margin-top: 10px;font-size: 15px;line-height: 24px">
        This privacy policy has been compiled to better serve those who are concerned with how their 'Personally Identifiable Information' (PII)
        is being used online. PII, as described in US privacy law and information security, is information that can be used on its own or with other information to identify, contact, or locate a single person, or to identify an individual in context. Please read our privacy policy carefully to get a clear understanding of
        how we collect, use, protect or otherwise handle your Personally Identifiable Information in accordance with our website.
    </div>

    </div></div>

<?php echo $footer; ?>

</body>

</html>