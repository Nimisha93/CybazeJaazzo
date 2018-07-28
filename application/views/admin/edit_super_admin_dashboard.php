<?php echo $default_assets; ?>


<?php echo $sidebar; ?>
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
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/highcharts-more.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>




<div class="right_col" role="main">
    <div class="">

        <div class="page-title">
            <div class="title_left">
                <h3 class=""></small>
                </h3>
            </div>

            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                       <!--  <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span> -->
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12">
                    <div class="x_panel">
                        
                        <div class="x_content">
                           <div class="row">
                            <div class="col-lg-3 col-sm-6">
                                <div class="circle-tile">
                                    <a href="#">
                                        <div class="circle-tile-heading dark-blue">
                                            <i class="fa fa-cogs fa-fw fa-3x"></i>
                                        </div>
                                    </a>
                                    <div class="circle-tile-content dark-blue">
                                        <div class="circle-tile-description text-faded">
                                            My Wallet 
                                        </div>
                                        <?php $wallet = empty($my_wallet_value['total_value']) ?0 : $my_wallet_value['total_value']; ?>
                                        <div class="circle-tile-number text-faded">
                                          <?php echo $wallet; ?>
                                            <span id="sparklineA"></span>
                                        </div>
                                        <a href="<?php echo base_url();?>wallet_overview" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="circle-tile">
                                    <a href="#">
                                        <div class="circle-tile-heading orange">
                                            <i class="fa fa-sitemap fa-fw fa-3x"></i>
                                        </div>
                                    </a>
                                    <div class="circle-tile-content orange">
                                        <div class="circle-tile-description text-faded">
                                            Total Channel Partners
                                        </div>
                                        <div class="circle-tile-number text-faded">
                                            <?php echo $data['cp_count']; ?>
                                        </div>
                                        <a href="<?php echo base_url() ?>get_active_cp/0" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="circle-tile">
                                    <a href="#">
                                        <div class="circle-tile-heading blue">
                                            <i class="fa fa-user fa-fw fa-3x"></i>
                                        </div>
                                    </a>
                                    <div class="circle-tile-content blue">
                                        <div class="circle-tile-description text-faded">
                                            Total Club Members
                                        </div>
                                        <div class="circle-tile-number text-faded">
                                           <?php echo $data['cm_count']; ?>
                                            <span id="sparklineB"></span>
                                        </div>
                                        <a href="<?php echo base_url();?>all_club_members/0" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-3 col-sm-6">
                                <div class="circle-tile">
                                    <a href="#">
                                        <div class="circle-tile-heading red">
                                            <i class="fa fa-black-tie fa-fw fa-3x"></i>
                                        </div>
                                    </a>
                                    <div class="circle-tile-content red">
                                        <div class="circle-tile-description text-faded">
                                            Total Executives
                                        </div>
                                        <div class="circle-tile-number text-faded">
                                            <?php echo $data['exc_count']; ?>
                                            <span id="sparklineC"></span>
                                        </div>
                                        <a href="<?php echo base_url();?>exe-view/0" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div>
                    </div> 
            </div>
            <div class="col-md-12">
                <div class="col-md-9 col-sm-10 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Cash Flow<small></small></h2>
                            <div id="container"></div>
                            <button id="plain">Plain</button>
                            <button id="inverted">Inverted</button>
                            <button id="polar">Polar</button>

                            <style>
                                #container {
                                    min-width: 320px;
                                    max-width: 600px;
                                    margin: 0 auto;
                                }
                            </style>
                            <script>
                                var chart = Highcharts.chart('container', {

                                    title: {
                                        text: 'My Wallet'
                                    },

                                    subtitle: {
                                        text: 'Cash Flow'
                                    },

                                    xAxis: {

                                        categories: [<?php foreach($details as $detail) { ?> <?php echo "'".$detail['month'] ."',";?>   <?php } ?>]

                                    <?php ?>
                                    },

                                    series: [{
                                        type: 'column',
                                        colorByPoint: true,
                                        data: [<?php foreach($details as $detail) { if ($detail['sums']==null) {$val=0;}else{$val=$detail['sums'];} ?> <?php echo $val .",";?>   <?php } ?>],
                                        showInLegend: false
                                    }]

                                });


                                $('#plain').click(function () {
                                    chart.update({
                                        chart: {
                                            inverted: false,
                                            polar: false
                                        },
                                        subtitle: {
                                            text: 'Plain'
                                        }
                                    });
                                });

                                $('#inverted').click(function () {
                                    chart.update({
                                        chart: {
                                            inverted: true,
                                            polar: false
                                        },
                                        subtitle: {
                                            text: 'Inverted'
                                        }
                                    });
                                });

                                $('#polar').click(function () {
                                    chart.update({
                                        chart: {
                                            inverted: false,
                                            polar: true
                                        },
                                        subtitle: {
                                            text: 'Polar'
                                        }
                                    });
                                });

                            </script>
                        </div>

                    </div>
                </div>


<!--/////////////////////////////////////-->

              
                <div class="col-lg-3 col-sm-6">
                    <div class="circle-tile">
                        
                        <div class="circle-tile-content red">
                            <div class="circle-tile-description text-faded">
                               Total Club Agents
                            </div>
                            <div class="circle-tile-number text-faded">
                               <?php echo $data['ca_count']; ?>
                                <span id="sparklineC"></span>
                            </div>
                            <a href="<?php echo base_url();?>all_club_agents/0" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="circle-tile">
                       
                        <div class="circle-tile-content red">
                            <div class="circle-tile-description text-faded">
                               Total Jaazzo Store
                            </div>
                            <div class="circle-tile-number text-faded">
                               <?php echo $data['jz_count']; ?>
                                <span id="sparklineC"></span>
                            </div>
                            <a href="<?php echo base_url();?>view_ba" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-sm-6">
                    <div class="circle-tile">
                        
                        <div class="circle-tile-content red">
                            <div class="circle-tile-description text-faded">
                               Total Normal Customers
                            </div>
                            <div class="circle-tile-number text-faded">
                               <?php echo $data['nc_count']; ?>
                                <span id="sparklineC"></span>
                            </div>
                            <a href="<?php echo base_url();?>normal_users/0" class="circle-tile-footer">More Info <i class="fa fa-chevron-circle-right"></i></a>
                        </div>
                    </div>
                </div>


            </div>
        </div>

        <!-- ================= row end here =================================================-->

        


    </div>
    <!-- /page content -->

</div> </div> </div>

<?php echo $footer; ?>


<!--============new customer popup start here=================-->

<div id="newcstomr" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
<div class="modal-dialog">


<div class="modal-content">

<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">X</button>
    <h4 class="modal-title">New Cutomer</h4>
</div>
<div class="modal-body">
<div id="testmodal" style="padding: 5px 20px;">
<form id="antoform" class="form-horizontal Calendar" role="form">
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <select id="heard" class="form-control" required="">
            <option value="">Saluation</option>
            <option value="press">Mr.</option>
            <option value="press">Mrs.</option>
            <option value="press">Ms.</option>
            <option value="press">Miss.</option>
            <option value="press">Dr.</option>

        </select>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <input type="text" placeholder="First Name" class="form-control">
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <input type="text" placeholder="Last Name" class="form-control">
    </div>

    <div class="col-md-6 col-sm-12 col-xs-12 form-group">
        <input type="text" placeholder="company name" class="form-control">
    </div>

    <div class="col-md-5 col-sm-11 col-xs-11 form-group">
        <input type="text" placeholder="company display name" class="form-control">
    </div>
    <div class="col-md-1 col-sm-1 col-xs-1">

        <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."><i class="fa fa-info-circle" aria-hidden="true"></i></div>
    </div>
    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <input type="text" placeholder="Work Phone" class="form-control">
    </div>

    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <input type="text" placeholder="Mobile" class="form-control">
    </div>

    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
        <a data-toggle="collapse" data-target="#morefield" class="lnht1">Add More Field</a>
    </div>
    <div class="clear"></div>

    <div id="morefield" class="collapse">

        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <input type="text" placeholder="Skype Name/ No." class="form-control">
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <input type="text" placeholder="Designation" class="form-control">
        </div>

        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
            <input type="text" placeholder="Department" class="form-control">
        </div>
    </div>


    <div class="col-md-12 col-sm-12 col-xs-12 form-group clear">
        <input type="text" placeholder="Website" class="form-control">
    </div>
</form>



<div class="col-md-12 col-sm-12 col-xs-12">
<div class="x_panel">

<div class="x_content">


<div class="" role="tabpanel" data-example-id="togglable-tabs">
<ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">other Details</a>
    </li>
    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Address</a>
    </li>
    <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Custom Field</a>
    </li>
    <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Reporting Tags</a>
    </li>

    <li role="presentation" class=""><a href="#tab_content5" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Remarks</a>
    </li>


</ul>
<div id="myTabContent" class="tab-content sclbr mdltab">
    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">


        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
            <select id="heard" class="form-control" required="">
                <option value="">Saluation</option>
                <option value="press">Mr.</option>
                <option value="press">Mrs.</option>
                <option value="press">Ms.</option>
                <option value="press">Miss.</option>
                <option value="press">Dr.</option>

            </select>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
            <select id="heard" class="form-control" required="">
                <option value="">Saluation</option>
                <option value="press">Mr.</option>
                <option value="press">Mrs.</option>
                <option value="press">Ms.</option>
                <option value="press">Miss.</option>
                <option value="press">Dr.</option>

            </select>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
            <div class="checkbox">
                <label>
                    <input type="checkbox" value=""> Allow portal access for this contact
                </label>
            </div>
        </div>
        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
            <select id="heard" class="form-control" required="">
                <option value="">Portal Language</option>
                <option value="press">Mr.</option>
                <option value="press">Mrs.</option>
                <option value="press">Ms.</option>
                <option value="press">Miss.</option>
                <option value="press">Dr.</option>

            </select>
        </div>
        <div class="clear"></div>
        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
            <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Facebook">
            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
        </div>

        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
            <input type="text" class="form-control has-feedback-left" id="inputSuccess2" placeholder="Twitter">
            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
        </div>



    </div>


    <!--======================tab_content1 end ==========================-->

    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">


        <div class="col-md-6 col-sm-6 col-xs-12">
            <h3 class="tblttle">BILLING ADDRESS</h3>

            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <input type="text" placeholder="Attention" class="form-control">
            </div>


            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <textarea class="form-control" rows="3" placeholder="Street"></textarea>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <input type="text" placeholder="City" class="form-control">
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <input type="text" placeholder="State" class="form-control">
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <input type="text" placeholder="Zip code" class="form-control">
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <select id="heard" class="form-control" required="">
                    <option value="">Country</option>
                    <option value="press">Mr.</option>
                    <option value="press">Mrs.</option>
                    <option value="press">Ms.</option>
                    <option value="press">Miss.</option>
                    <option value="press">Dr.</option>

                </select>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <input type="text" placeholder="Fax" class="form-control">
            </div>

        </div>

        <!--++++++++++++++++SHIPPING ADDRESS end +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->

        <div class="col-md-6 col-sm-6 col-xs-12">
            <h3 class="tblttle">SHIPPING ADDRESS</h3>

            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <input type="text" placeholder="Attention" class="form-control">
            </div>


            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <textarea class="form-control" rows="3" placeholder="Street"></textarea>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <input type="text" placeholder="City" class="form-control">
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <input type="text" placeholder="State" class="form-control">
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <input type="text" placeholder="Zip code" class="form-control">
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <select id="heard" class="form-control" required="">
                    <option value="">Country</option>
                    <option value="press">Mr.</option>
                    <option value="press">Mrs.</option>
                    <option value="press">Ms.</option>
                    <option value="press">Miss.</option>
                    <option value="press">Dr.</option>

                </select>
            </div>

            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <input type="text" placeholder="Fax" class="form-control">
            </div>

        </div>


        <!--++++++++++++++++SHIPPING ADDRESS end +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++-->



        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
            <strong>Note:</strong> You can add and manage additional addresses from contact details section.
        </div>


    </div>
    <!--======================tab_content2 end ==========================-->

    <div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
        <p class="tabtxt">Start adding custom fields for your contacts by going to More Settings <strong> > </strong> Preferences <strong>></strong> Contacts. You can add as many as Ten extra fields, as well as refine the address format of your contacts from there. </p>
    </div>
    <!--======================tab_content3 end ==========================-->

    <div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
        <p class="tabtxt">You've not created any Reporting Tags.
            Start creating reporting tags by going to More Settings  <strong> > </strong>  Reporting Tags </p>
    </div>
    <!--======================tab_content3 end ==========================-->

    <div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">

        <div class="col-md-9 col-sm-9 col-xs-12 form-group">
            <strong>Remarks </strong>(For Internal Use)
            <textarea class="form-control" rows="5" placeholder="Street"></textarea>
        </div>


    </div>
    <!--======================tab_content3 end ==========================-->




</div>
</div>

</div>
</div>
</div>



</div>
</div>



<div class="modal-footer">
    <button type="button" class="btn btn-default antoclose" data-dismiss="modal">Cancel</button>
    <button type="button" class="btn btn-primary antosubmit">Save</button>
</div>
</div> </div> </div>

</body>
</html>