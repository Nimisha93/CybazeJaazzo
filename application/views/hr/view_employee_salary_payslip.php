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

                        <h2>Salary Slip </h2>

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



                                <table id="mytable" class="table display table-bordered table-striped responsive-utilities jumbo_table">

                                    <thead>



                                    <tr class="tablbg">

                                    <tr class="tablbg">
                                    <th>No</th>
                                    <th>Employee Name</th>
                                    
                                    <th>Salary From</th>
                                    <th>Salary To</th>
                                    <th>Basic Salary</th>
                                    <th>Total Working Days</th>
                                   
                                    <th>Total Total leaves</th>
                                    <th>Total Allowed leaves</th>
                                    <th>Total Allowens </th>
                                    <th>Total Allowed Deductions</th>

                                    <th>Net Paid</th>
                                   
                                    </tr>

                                    </thead>




                                    <tbody>
                                <?php foreach($salary as $key => $val){ 
                                        $allowens = ($this->Mdl_payroll->get_total_allowance($val['id']));
                                        $deductions = ($this->Mdl_payroll->get_total_deductions($val['id']));
                                    ?>
                                     <tr>
                                        <td><?php echo $key+1; ?></td>
                                        <td><?php echo $val['name']; ?></td>
                                        <td><?php echo $val['from_date']; ?></td>
                                        <td><?php echo $val['to_date']; ?></td>
                                        <td><?php echo $val['basicsalary']; ?></td>
                                        <td><?php echo $val['total_workingdays']; ?></td>
                                        <td><?php echo $val['total_leaves']; ?></td>
                                        <td><?php echo $val['allowed_leaves']; ?></td>
                                        <td><?php echo isset($allowens)?$allowens:'-'; ?></td>
                                        <td><?php echo isset($deductions)?$deductions:'-'; ?></td>
                                        <td><?php echo $val['net_paid']; ?></td>
                                    </tr>
                                <?php }?>

                                

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



<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/buttons.print.min.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/admin/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
<script>

    var table = $('#mytable').DataTable( {
        dom: 'Bfrtip',

        buttons: [

            { extend: 'print',  title: 'Salary Slip' },
        ]
    } );
</script>



    
</body>

</html>