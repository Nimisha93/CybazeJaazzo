<?php echo $header; ?>

<link href="<?php echo base_url(); ?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<script src="<?php echo base_url(); ?>assets/admin/js/jquery-1.11.3.js"></script>


</head>
<?php echo $sidebar; ?>


<div class="right_col" role="main">

    <div class="">

        <div class="page-title">

            <div class="title_left">

                <div type="button" class="btn" data-toggle="popover" data-placement="right" title=""

                     data-content="This is the name that will be shown on invoices, bills created for this contact."></div>

                </h3>

            </div>

            <div class="title_right">


            </div>

        </div>

        <div class="clearfix"></div>

        <div class="row">

        

            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">

                    <div class="x_title">

                        <h2>PF Report</h2>

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

                                        <th>No</th>

                                      

                                        <th>Employee</th>

                                        <th>Date</th>

                                        

                                       
                                        <th>PF Amount[Employee]</th>
                                        <th>PF Amount[Company]</th>
                                         <th>Total Amount</th>
                                      

                                        


                                    </tr>





                                    

                                    </thead>

                                    

                          

                                    <tbody>


                                    <?php if(!empty($pf['emp'])){
                                     foreach ($pf['emp'] as $key => $pf) { 
                                     if( !empty($pf['epf'] ) || !empty($pf['cpf']) ) { ?>
                                        <tr>
                                        <td><?php echo $key+1; ?></td>
                                        <td><?php echo $pf['name']."(".$pf['employee_code'].")"; ?></td>
                                        <td><?php echo $pf['from_date']." - ".$pf['to_date']; ?></td>
                                        <td><?php echo $pf['epf']; ?></td>
                                        <td><?php echo $pf['cpf']; ?></td>
                                        <td><?php echo $pf['net_paid']; ?></td>
                                       </tr>
                                   <?php 
                                    } 
                                   }
                                  } ?>







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

<script src="<?php echo base_url(); ?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/dataTables.buttons.min.js" type="text/javascript"></script>


<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/buttons.print.min.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/admin/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">

<script>

    var table = $('#patient_table').DataTable({
        dom: 'Bfrtip',

        buttons: [

            {extend: 'print', title: 'PF Report'},
        ]
    });
</script>




</body>

</html>