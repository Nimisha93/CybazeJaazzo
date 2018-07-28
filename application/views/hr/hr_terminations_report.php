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

                        <h2>Termination Report</h2>

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



                                    <tr  class="tablbg">

                                        <th>No</th>

                                        <th style="min-width: 130px;">Employee Terminated</th>

                                      

                                        <th style="min-width: 80px;">Termination Date</th>

                                        <th style="min-width: 80px;">Notice Date</th>



                                        <th style="min-width: 130px;">Termination Type</th>



                                        <th>Termination Description</th>

                                        <th class="HideColumn">Status</th>





                                    </tr>

                              <!--      <tr class="filters">

                                        <th></th>

                                        <th class="input-filter">Complaint From</th>

                                        <th class="input-filter">Foraward Application To</th>

                                        <th class="date-filter">Complaint Title</th>

                                        <th class="date-filter">Complaint Date</th>

                                        <th class="input-filter">Complaint Against</th>

                                        <th class="input-filter">Complaint description</th>

                                        <th class="input-filter">Status</th>







                                    </tr>-->

                                    </thead>

                       

                                    <tbody>



                                    <?php foreach ($termination['compl'] as $key => $request) { ?>

                                        <tr>

                                            <input type="hidden" id="termination_hidden" name="termination_hidden" class="termination_hidden" value="<?= $request['id'];?>">

                                            <td><?= $key+1;?></td>

                                            <td><?= $request['name'];?>(<?= $request['employee_code'];?>)</td>

                                            <?php

                                            $termina_date= $request['termina_date'];

                                            $date1=convert_ui_date($termina_date);



                                            ?>



                                            <td><?= $date1;?></td>

                                            <?php

                                            $notice_dat= $request['notice_dat'];

                                            $date12=convert_ui_date($termina_date);



                                            ?>

                                            <td><?= $date12;?></td>



                                            <td><?= $request['type'];?></td>

                                            <td><?= $request['description'];?></td>

                                            <td><?= $request['status'];?></td>





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



<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/buttons.print.min.js" type="text/javascript"></script>
<link href="<?php echo base_url();?>assets/admin/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css">
<script>

    var table = $('#example').DataTable( {
        dom: 'Bfrtip',

        buttons: [

            { extend: 'print',  title: 'Termination Report' },
        ]
    } );
</script>



</body>

</html>