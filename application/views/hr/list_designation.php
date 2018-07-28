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

                        <h2>Designations</h2>

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

                                <table id="mytable" class="table display table-bordered table-striped responsive-utilities jumbo_table" >

                                    <thead>

                                    <tr class="tablbg" >

                                        <th>No</th>

                                        <th>Station</th>

                                        <th>Department</th>

                                        <th>Title</th>

                                      



                                    </tr>



                                    </thead>

                                

                                



                                    <tbody>

                                    <?php foreach ($designations as $key => $designation) { ?>

                                        <tr>

                                            <input type="hidden" name="station_id" class="station_id"

                                                   value="<?php echo $designation['branch_id']; ?>">

                                            <input type="hidden" name="dsig_id" class="dsig_id"

                                                   value="<?php echo $designation['id']; ?>">

                                            <input type="hidden" name="dept_id" class="dept_id"

                                                   value="<?php echo $designation['dept_id']; ?>">

                                            <td><?php echo $key + 1; ?></td>

                                            <td><?php echo $designation['branch']; ?></td>

                                            <td><?php echo $designation['dept']; ?></td>

                                            <td class="title"><?php echo $designation['title']; ?></td>



                                         





                                        </tr>

                                    <?php } ?>



                                    </tbody>

                                </table>

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



<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/buttons.print.min.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/admin/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
   
<script>

    var table = $('#mytable').DataTable( {
        dom: 'Bfrtip',

        buttons: [

            { extend: 'print',  title: 'Designations' },
        ]
    } );
</script>



    
</body>

</html>