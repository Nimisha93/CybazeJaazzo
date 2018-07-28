<?php echo $header; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script>


</head>
<?php echo $sidebar; ?>




<div class="right_col" role="main">

    <div class="">

    

        <div class="clearfix"></div>

        <div class="row">



            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">

                    <div class="x_title">

                        <h2>Complaints Report</h2>

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

                                <table id="example" class="table display table-bordered table-striped responsive-utilities jumbo_table">

                                    <thead>



                                    <tr class="tablbg" >

                                        <th>No</th>

                                        <!-- <th>Complaint From</th> -->

                                      

                                        <th>Complaint Title</th>

                                        <th>Complaint Date</th>

                                        <th>Complaint Against</th>

                                        <th class="HideColumn">Complaint Description</th>

                                     







                                    </tr>

                               
                                    </thead>

                                    

                              

                                    <tbody>



                                    <?php foreach ($complaint['compl'] as $key => $request) { ?>

                                        <tr>

                                            <input type="hidden" id="complaint_hidden" name="complaint_hidden" class="complaint_hidden" value="<?= $request['id'];?>">

                                            <td><?= $key+1;?></td>

                                           
                                           

                                            <td><?= $request['title'];?></td>

                                            <td><?= $request['created_on'];?></td>

                                            <td><?= $request['againstname'];?>(<?= $request['againstcode'];?>)(<?= $request['e_stat'];?>)</td>

                                            <td><?= $request['description'];?></td>

                                           



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
<script src="<?php echo base_url();?>assets/admin/js/buttons.print.min.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/admin/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">

<script>

    var table = $('#example').DataTable( {
         fixedHeader: {

            header: true,

            footer: true



        },
        dom: 'Bfrtip',

        buttons: [

            { extend: 'print',  title: 'Requestion Report' },
        ]
    }


);
</script>







    
</body>

</html>