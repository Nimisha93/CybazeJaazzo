<?php echo $default_assets; ?>
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<style type="text/css">
    @media (min-width: 768px){
        .circle-tile {
            margin-bottom: 30px;
        }
    }

    .circle-tile {
        margin-bottom: 15px;
        text-align: center;
    }

    .circle-tile-heading {
        position: relative;
        width: 80px;
        height: 80px;
        margin: 0 auto -40px;
        border: 3px solid rgba(255,255,255,0.3);
        border-radius: 100%;
        color: #fff;
        transition: all ease-in-out .3s;
    }
        /* Use these to cuztomize the background color of a div. These are used along with tiles, or any other div you want to customize. */

    .dark-blue {
        background-color: #34495e;
    }

    .blue {
        background-color: #5d8ab3;
    }

    .orange {
        background-color: #5e8eb9;
    }

    .red {
        background-color: #597590;
    }

    .purple {
        background-color: #8e44ad;
    }

    .dark-gray {
        background-color: #7f8c8d;
    }

    .gray {
        background-color: #95a5a6;
    }

    .light-gray {
        background-color: #bdc3c7;
    }

    .yellow {
        background-color: #f1c40f;
    }

        /* -- Text Color Helper Classes */

    .text-dark-blue {
        color: #34495e;
    }



    .text-blue {
        color: #2980b9;
    }

    .text-orange {
        color: #f39c12;
    }

    .text-red {
        color: #e74c3c;
    }



    .text-faded {
        color: rgba(255,255,255,0.7);
    }



    .circle-tile-heading .fa {
        line-height: 80px;
    }

    .circle-tile-content {
        padding-top: 50px;
    }
    .circle-tile-description {
        text-transform: uppercase;
    }

    .text-faded {
        color: rgba(255,255,255,0.7);
    }

    .circle-tile-number {
        padding: 5px 0 15px;
        font-size: 26px;
        font-weight: 700;
        line-height: 1;
    }

    .circle-tile-footer {
        display: block;
        padding: 5px;
        color: rgba(255,255,255,0.5);
        background-color: rgba(0,0,0,0.1);
        transition: all ease-in-out .3s;
    }

    .circle-tile-footer:hover {
        text-decoration: none;
        color: rgba(255,255,255,0.5);
        background-color: rgba(0,0,0,0.2);
    }
</style>
</head>
<?php echo $sidebar; ?>

<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Dashboard<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="circle-tile">
                                    <a href="#">
                                        <div class="circle-tile-heading dark-blue">
                                            <i class="fa fa-users fa-fw fa-3x"></i>
                                        </div>
                                    </a>
                                    <div class="circle-tile-content dark-blue">
                                        <div class="circle-tile-description text-faded">
                                            Total Entries
                                        </div>
                                        <div class="circle-tile-number text-faded">
                                            3
                                            <span id="sparklineA"></span>
                                        </div>
                                        <a href="<?php echo base_url();?>branch_list" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="circle-tile">
                                    <a href="#">
                                        <div class="circle-tile-heading orange">
                                            <i class="fa fa-bell fa-fw fa-3x"></i>
                                        </div>
                                    </a>
                                    <div class="circle-tile-content orange">
                                        <div class="circle-tile-description text-faded">
                                            Total Departments
                                        </div>
                                        <div class="circle-tile-number text-faded">
                                            5
                                        </div>
                                        <a href="<?php echo base_url() ?>add_department" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="circle-tile">
                                    <a href="#">
                                        <div class="circle-tile-heading blue">
                                            <i class="fa fa-tasks fa-fw fa-3x"></i>
                                        </div>
                                    </a>
                                    <div class="circle-tile-content blue">
                                        <div class="circle-tile-description text-faded">
                                            Total Employees
                                        </div>
                                        <div class="circle-tile-number text-faded">
                                            5
                                            <span id="sparklineB"></span>
                                        </div>
                                        <a href="<?php echo base_url();?>active_employees" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="circle-tile">
                                    <a href="#">
                                        <div class="circle-tile-heading red">
                                            <i class="fa fa-shopping-cart fa-fw fa-3x"></i>
                                        </div>
                                    </a>
                                    <div class="circle-tile-content red">
                                        <div class="circle-tile-description text-faded">
                                            Total Posts
                                        </div>
                                        <div class="circle-tile-number text-faded">
                                            6
                                            <span id="sparklineC"></span>
                                        </div>
                                        <a href="<?php echo base_url();?>posts" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php echo $footer; ?>
</body>
</html>

