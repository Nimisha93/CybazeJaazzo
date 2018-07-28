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

                        <h2>Active Employees </h2>

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

                                <div  style="overflow-x: auto">
                                <table id="example" class="table display table-bordered table-striped responsive-utilities jumbo_table" >

                                    <thead>

                                    <tr class="tablbg" >

                                        <th>No</th>

                                        <th>Name</th>

                                        <th class="HideColumn">Employee Code</th>

                                        <th>Department</th>

                                        <th class="HideColumn">Designation</th>

                                        <th style="width: 80px" class="HideColumn">Date of Join</th>

                                        <th class="HideColumn">Email</th>

                                        <th>Mobile</th>

                                        <th class="HideColumn">Gender</th>

                                        <th>Date of Birth</th>

                                        <th>Salary</th>








                                    </tr>







                                    </thead>





                                    <tbody style=" height:100px;overflow:scroll">

                                    <?php foreach ($employees as $key => $employee) { ?>

                                    <tr>

                                        <td><?= $key + 1; ?></td>

                                        <td>

                                            <input type="hidden" name="emp_id" class="emp_id"

                                                   value="<?= $employee['id']; ?>">

                                            <input type="hidden" name="cur_sal_id" class="cur_sal_id"

                                                   value="<?= $employee['cur_sal_id']; ?>">

                                            <?= $employee['name']; ?></td>

                                        <td><?= $employee['employee_code']; ?></td>

                                        <td><?= $employee['dept']; ?></td>

                                        <td><?= $employee['desig']; ?></td>

                                        <?php

                                        $date_of_join= $employee['date_of_join'];

                                        $date1=date('d-m-Y',strtotime($date_of_join));



                                        ?>

                                        <td><?=$date1; ?></td>

                                        <td><?= $employee['email']; ?></td>

                                        <td><?= $employee['mobile']; ?></td>

                                        <td><?= $employee['gender']; ?></td>

                                        <?php

                                        $dob= $employee['dob'];

                                        $datedob=date('d-m-Y',strtotime($dob));



                                        ?>

                                        <td><?= $datedob; ?></td>

                                        <td><?= $employee['salary']; ?></td>










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
        dom: 'Bfrtip',

        buttons: [

            { extend: 'print',  title: 'Active Employees' },
        ]
    } );
</script>



</body>

</html>