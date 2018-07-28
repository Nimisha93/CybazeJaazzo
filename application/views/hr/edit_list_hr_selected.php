<?php echo $header; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>

<?php echo $sidebar; ?>
</head>


<div class="right_col" role="main">
    <div class="">
    
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Selected candidates
                            <small></small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i
                                            class="fa fa-arrow-left" aria-hidden="true"></i></a></li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">

                            <!-- ========================== calendar which hide previous date===================================================-->

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                <table id="example" class="table display table-bordered table-striped responsive-utilities">
                                    <thead>

                                  <tr class="tablbg">

                                        <th>No</th>
                                        <!-- <th>Post Id</th> -->
                                        <th>Post Name</th>
                                        <th>Post Type</th>
                                        <th>No: Posts</th>
                                        <th>Candidate Name</th>

                                        <th>Addon</th>

                                        <th>Action</th>

                                    </tr>
                                    
                                    </thead>
                                    
                                  
                                    <tbody>

                                    <?php foreach ($selected as $key => $select) { ?>
                                        <tr>
                                            <input type="hidden" name="sel_id" class="sel_id" value="<?= $select['cd_id'];?>">
                                            <td><?= $key+1;?></td>
                                            <!-- <td><?= $select['po_id'];?></td> -->
                                            <td><?= $select['title'];?></td>
                                            <td><?= $select['type'];?></td>
                                            <td><?= $select['posts'];?></td>
                                            <td><?= $select['name'];?></td>

                                            <!-- <td><?php
                                            $selt = $select['selected'];
                                            $tags = explode(',',$selt);
                                            foreach($tags as $key) { echo ''.$key.'<br/>'; } ?></td> -->


                                            <td><?= date('d-M-Y',strtotime($select['addon']));?></td>
                                            <td><a  type="button" class="btn btn-primary fllft" href="<?php echo base_url();?>hr/Recruitment/emp_join/<?php echo $select['cd_id'];?>" class="btn btn-primary fllft edit_btn"><i class="fa fa-paper-plane" aria-hidden="true"></i></a></td>
                                            
                                        </tr>
                                    <?php   } ?>



                                    </tbody>
                                    
                                </table>
                                <br>


                            </div>

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
<?php echo $footer; ?>

<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.buttons.min.js" type="text/javascript"></script>


<script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>
<!--***************************date picker******************************-->
   <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/moment2.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/bootstrap-datetimepicker.min.css" />
  <!--***************************date picker end******************************-->
  <link href="<?php echo base_url();?>assets/admin/css/select2.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/select2.full.js" type="text/javascript" charset="utf-8">
</script>
 <script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>

<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>


<script>

$(document).ready(function() {
    var table = $('#example').DataTable( {
        fixedHeader: {
            header: true,
            footer: true
			
        }
    } );
	
} );

</script>


</body>
</html>