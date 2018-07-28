<?= $default_assets;?>
<style>

    .row{margin:0;}
    .goToTop{position:fixed;border-bottom:1px solid #ccc;z-index: 17;    background-color: #d88909;}

    .panel-default > .panel-heading {
        color: #353434;
        background-color: #d88909;
        border-color: #ddd;
    }

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

.bhoechie-tab-container{text-align: left}
    div.bhoechie-tab-container{
        z-index: 10;
        background-color: #ffffff;
        padding: 0 !important;
        border-radius: 4px;
        -moz-border-radius: 4px;
        border:1px solid #ddd;
        margin-top: 20px;
        margin-left: 50px;
        -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
        box-shadow: 0 6px 12px rgba(0,0,0,.175);
        -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
        background-clip: padding-box;
        opacity: 0.97;
        filter: alpha(opacity=97);
    }
    div.bhoechie-tab-menu{
        padding-right: 0;
        padding-left: 0;
        padding-bottom: 0;
    }
    .abtcntnt{font-size: 14px;}

    div.bhoechie-tab-menu div.list-group{
        margin-bottom: 0;
    }
    div.bhoechie-tab-menu div.list-group>a{
        margin-bottom: 0;
    }
    div.bhoechie-tab-menu div.list-group>a .glyphicon,
    div.bhoechie-tab-menu div.list-group>a .fa {
        color: #232222;
    }
    div.bhoechie-tab-menu div.list-group>a:first-child{
        border-top-right-radius: 0;
        -moz-border-top-right-radius: 0;
    }
    div.bhoechie-tab-menu div.list-group>a:last-child{
        border-bottom-right-radius: 0;
        -moz-border-bottom-right-radius: 0;
    }
    div.bhoechie-tab-menu div.list-group>a.active,
    div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
    div.bhoechie-tab-menu div.list-group>a.active .fa{
        background-color: #232222;
        background-image: #232222;
        color: #ffffff;
    }
    div.bhoechie-tab-menu div.list-group>a.active:after{
        content: '';
        position: absolute;
        left: 100%;
        top: 50%;
        margin-top: -13px;
        border-left: 0;
        border-bottom: 13px solid transparent;
        border-top: 13px solid transparent;
        border-left: 10px solid #232222;
    }

    div.bhoechie-tab-content{
        background-color: #ffffff;
        /* border: 1px solid #eeeeee; */
        padding-left: 20px;
        padding-top: 10px;
    }

    div.bhoechie-tab div.bhoechie-tab-content:not(.active){
        display: none;
    }
</style>

<body>
<?= $header;?>
</div>


<div class="container" style="max-width: 1200px;margin-bottom: 50px;margin-top: 50px">

    <div class="row">
        <div class="col-lg-12  bhoechie-tab-container">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
                <div class="list-group">
                    <a href="#" class="list-group-item active text-center">
                        <h4 class="glyphicon glyphicon-user"></h4><br/>Who We Are
                    </a>
                    <a href="#" class="list-group-item text-center">
                        <h4 class="glyphicon glyphicon-road"></h4><br/>Our History
                    </a>
                    <a href="#" class="list-group-item text-center">
                        <h4 class=""></h4><i class="fa fa-eye"></i> <br/>Our Vision
                    </a>

                </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                <!-- flight section -->
                <div class="bhoechie-tab-content active">


                        <h2 style="margin-top: 0;color:#000;text-align: left">Cooming Soon</h2>
                       <div class="abtcntnt">lorem ipsum,lorem ipsum lorem ipsum,lorem ipsum lorem ipsum,lorem ipsum
                                             lorem ipsum,lorem ipsum lorem ipsum,lorem ipsum lorem ipsum,lorem ipsum
                                             lorem ipsum,lorem ipsum lorem ipsum,lorem ipsum lorem ipsum,lorem ipsum

                                             lorem ipsum,lorem ipsum lorem ipsum,lorem ipsum lorem ipsum,lorem ipsumlorem ipsum,lorem ipsum lore
                                             ipsum,lorem ipsum lorem ipsum,lorem ipsumlorem
                                             ipsum,lorem ipsum lorem ipsum,lorem ipsum lorem ipsum,lorem ipsum</div>

                </div>
                <!-- train section -->
                <div class="bhoechie-tab-content">
                    <h2 style="margin-top: 0;color:#000;text-align: left">Cooming Soon</h2>
                    <div class="abtcntnt">lorem ipsum,lorem ipsum lorem ipsum,lorem ipsum lorem ipsum,lorem ipsum
                                          lorem ipsum,lo
                                          lorem ipsum,lorem ipsum lorem ipsum,lorem ipsum lorem ipsum,lorem ipsumlorem ipsum,lorem ipsum lore
                                          ipsum,lorem ipsum lorem ipsum,lorem ipsumlorem
                                          ipsum,lorem ipsum lorem ipsum,lorem ipsum lorem ipsum,lorem ipsum</div>

                </div>

                <!-- hotel search -->
                <div class="bhoechie-tab-content">
                    <h2 style="margin-top: 0;color:#000;text-align: left">Cooming Soon</h2>
                    <div class="abtcntnt">lorem ipsum,lorem ipsum lorem ipsum,lorem ipsum lorem ipsum,lorem ipsum
                                          lorem ipsuorem ipsum,lorem ipsum lorem ipsum,lorem ipsum

                                          lorem ipsum,lorem ipsum lorem ipsum,lorem ipsum lorem ipsum,lorem ipsumlorem ipsum,lorem ipsum lore
                                          ipsum,lorem ipsum lorem ipsum,lorem ipsumlorem
                                          ipsum,lorem ipsum lorem ipsum,lorem ipsum lorem ipsum,lorem ipsum</div>

                </div>

            </div>
        </div>
    </div>

</div>

<?php echo $footer; ?>
<script>
    $(document).ready(function() {
        $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
            e.preventDefault();
            $(this).siblings('a.active').removeClass("active");
            $(this).addClass("active");
            var index = $(this).index();
            $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
            $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
        });
    });
</script>
</body>

</html>