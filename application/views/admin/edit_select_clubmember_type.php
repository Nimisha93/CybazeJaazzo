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
                        <h2>Club Member<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="table-responsive tabmargntp30">
                                <form method="post" action="" name="payment_form" id="payment_form" enctype="multipart/form-data">
                                    <div class="col-md-12">
                                        
                                         <input type="hidden" name="user_id" value="<?php echo $member['user_id'];?>">
                                         <input type="hidden" name="log_id" value="<?php echo $member['id'];?>">
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label><?php echo $member['email'];?></label>
                                            
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label><?php echo $member['mobile'];?></label>
                                            
                                        </div>
                                        
                                        
                                        <?php foreach ($club_type as $key => $type) { ?>
                                          <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                           
                                            <input type="radio" name="type" value="<?php echo $type['id'];?>">
                                             <label><?php echo $type['title'];?></label>
                                        </div>
                                     <?php   } ?>
                                        
                                       

                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                            <button type="submit" class="btn btn-primary payment_sub" name="payment_sub" id="payment_sub">Save</button>
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


    <!--************************row  end******************************************************************* -->

   


</div>
</div>
</div>
</div>
</div>



<input type="hidden" id="baseurl" name="baseurl" value="<?php echo base_url(); ?>" />
<script src="<?php echo base_url(); ?>assets/admin/custom_js/add_club_member.js"></script>
<?php echo $footer; ?>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>



<!--============new customer popup start here=================-->

</body>
</html>