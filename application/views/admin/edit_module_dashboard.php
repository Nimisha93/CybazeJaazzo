

<?php echo $default_assets; ?>


<?php echo $sidebar; ?>


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
                        <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>



        <!-- ================= row end here =================================================-->

        <div class="row">
<!--            <div class="col-md-12">-->
<!--                --><?php //foreach ($cp_wallet_value['wallet'] as $rows){?>
<!--                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">-->
<!--                    <div class="tile-stats">-->
<!--                        <div class="icon"><i class="fa fa-caret-square-o-right"></i>-->
<!--                        </div>-->
<!--                        <div class="count">--><?php //echo $rows['total_value'];?><!--</div>-->
<!---->
<!--                        <h3>--><?php //echo $rows['title'];?><!--</h3>-->
<!--                        <!--                        <p>Lorem ipsum psdea itgum rixt.</p>-->-->
<!--                    </div>-->
<!--                </div>-->
<!--                --><?php
//            }
//                ?>
<!---->
<!--                <!--                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">-->-->
<!--                <!--                    <div class="tile-stats">-->-->
<!--                <!--                        <div class="icon"><i class="fa fa-sort-amount-desc"></i>-->-->
<!--                <!--                        </div>-->-->
<!--                <!--                        <div class="count">179</div>-->-->
<!--                <!---->-->
<!--                <!--                        <h3>New Sign ups</h3>-->-->
<!--                <!--                        <p>Lorem ipsum psdea itgum rixt.</p>-->-->
<!--                <!--                    </div>-->-->
<!--                <!--                </div>-->-->
<!--                <!--                <div class="animated flipInY col-lg-3 col-md-3 col-sm-6 col-xs-12">-->-->
<!--                <!--                    <div class="tile-stats">-->-->
<!--                <!--                        <div class="icon"><i class="fa fa-check-square-o"></i>-->-->
<!--                <!--                        </div>-->-->
<!--                <!--                        <div class="count">179</div>-->-->
<!--                <!---->-->
<!--                <!--                        <h3>New Sign ups</h3>-->-->
<!--                <!--                        <p>Lorem ipsum psdea itgum rixt.</p>-->-->
<!--                <!--                    </div>-->-->
<!--                <!--                </div>-->-->
<!--                <!--            </div>-->-->
<!---->
<!---->
<!--            </div>-->

            <div class="row">
                <div class="col-md-12">
                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Cash Flow<small></small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content"><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;"></iframe>
                                <canvas id="lineChart" height="355" width="711" style="width: 569px; height: 284px;"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 col-sm-6 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Bar graph <small></small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                                    </li>

                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content"><iframe class="chartjs-hidden-iframe" style="width: 100%; display: block; border: 0px; height: 0px; margin: 0px; position: absolute; left: 0px; right: 0px; top: 0px; bottom: 0px;"></iframe>
                                <canvas id="mybarChart" height="355" width="711" style="width: 569px; height: 284px;"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

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