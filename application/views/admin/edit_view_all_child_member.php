<?php echo $default_assets; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">

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
                        <h2>Child Users<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                    <th>No</th>
                                    <th>Email</th>
                                    <th>Mobile </th>
                                    <th>Type</th>
                                    <th>Action</th>


                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>No</th>
                                    <th>Email</th>
                                    <th>Mobile </th>
                                    <th>Type</th>
                                    <th>Action</th>
                                </tr>
                                </tfoot>
                                <tbody style="overflow:scroll">
                                <?php foreach($members as $key => $member){?>
                                <tr><input type="hidden" value="<?php echo $member['id'];?>" class="user_id">
                                    <td><?php echo $key;?></td>
                                    <td> <?php echo $member['email'];?></td>
                                    <td><?php echo $member['mobile'];?></td>
                                    <td><?php echo $member['type'];?></td>
                                     <?php  $loginsession = $this->session->userdata('logged_in_admin'); ?>
                                    
                                    <td>
                                   <?php if($loginsession['type'] == 'executive'){ ?>

                                    <a href="<?php echo base_url();?>admin/clubmember/become_clubmember/<?php echo $member['id'];?>" class="btn btn-primary chanege">Update</a>
                                    <?php } else if($loginsession['type'] == 'business_associate'){ ?>
                                   
                                       <a href="<?php echo base_url();?>admin/clubmember/become_ba_clubmember/<?php echo $member['id'];?>" class="btn btn-primary chanege">Update</a>
                                 <?php   } ?>
                                 </td> 
                                </tr>
                                    <?php }?>
                                

                              
                                </tbody>
                            </table>
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
<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>




<!-- Datatables -->

<!--============new customer popup start here=================-->

</body>
</html>





























