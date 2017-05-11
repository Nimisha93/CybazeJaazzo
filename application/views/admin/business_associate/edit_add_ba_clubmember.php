<?php echo $default_assets; ?>

<link href="<?php echo base_url();?>assets/admin/css/file-browse/dropzone.min.css" rel="stylesheet" />

</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."><i class="fa fa-info-circle" aria-hidden="true"></i></div>
                </h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
                </span> </div>
                </div>
            </div>
        </div>

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Club Member<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="table-responsive tabmargntp30">
                                <form method="post" action="<?php echo base_url();?>newclubmember" name="club_ba_form" id="club_ba_form" enctype="multipart/form-data">
                                    <div class="col-md-12">
                                        

                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Name</label>
                                            <input type="text" placeholder="Name" name="_name" class="form-control validate[required]">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Email</label>
                                            <input type="email" placeholder="Name" name="email" class="form-control validate[required]">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Mobile</label>
                                            <input type="text" placeholder="Mobile" name="phone" class="form-control validate[required]">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Alternate Mobile</label>
                                            <input type="text" placeholder="Alternate Mobile" name="phone2" class="form-control validate[required]">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Pincode</label>
                                            <input type="text" placeholder="Pincode" name="pincode" class="form-control validate[required]">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Address</label>
                                            <input type="text" placeholder="Address" name="address" id="address" class="form-control validate[required]">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            
                                            <input type="checkbox" name="terms_condition" class="validate[required]">
                                            <label>Terms and Conditions</label>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                            <input type="submit" class="btn btn-primary prosubmit" name="prosubmit" id="prosubmit" value="Save">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <div class="clearfix"></div>

    <!-- otp form -->
    <div id="ba_otp_model" class="modal fade" role="dialog">
        <div class="modal-dialog">

         <!-- Modal content-->
        <div class="modal-content" style="width: 400px;margin-left: 30%;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h4 class="modal-title">OTP</h4>
            </div>
            <form method="post" id="ba_otp_forms" class="ba_otp_forms" action="<?php echo base_url();?>clubmember_otp" name="ba_otp_forms">
                <div class="modal-body">
                    <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="col-md-10 col-sm-12 col-xs-12">
                            <label>Enter the otp here</label>
                            <input type="hidden" class="form-control validate[required]" id="otp_mail" name="otp_mail">
                            <input type="hidden" class="form-control validate[required]" id="otp_phone" name="otp_phone">
                            <input type="text" placeholder="OTP" class="form-control validate[required]" id="reg_otp" name="reg_otp">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <input type="submit" class="btn btn-primary otp_sub" id="otp_sub" value="Submit">
                </div>
            </form>
        </div>
        </div>
    </div>
                                       <!-- end otp form -->

    <!--************************row  end******************************************************************* -->

   


</div>
</div>
</div>
</div>
</div>



<input type="hidden" id="baseurl" name="baseurl" value="<?php echo base_url(); ?>" />

<?php echo $footer; ?>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/custom_js/add_ba_club_member.js"></script>


<!--============new customer popup start here=================-->

</body>
</html>