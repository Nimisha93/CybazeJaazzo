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

                        <h2>Departments </h2>

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

                                <table id="mytable" class="table display table-bordered table-striped responsive-utilities">

                                    <thead>



                                    <tr class="tablbg">



                                        <th>No</th>

                                        <!-- <th>Branch</th>   -->

                                        <th style="min-width:140px;">Title</th>

                                        <th>Description</th>

                                        <!-- <th>Department head</th> -->

                                        <th style="min-width:80px;">Created on</th>

                                        

                                       

                                        </tr>

                                      

                                    </thead>

                                    

                                 

                                    

                                    <tbody>



                                    <?php foreach ($departmentslist as $key => $att) { 
                                    
                                     $date1=$att['created_on'];
                                    $date=date('d-m-Y',strtotime($date1));
                                    
                                    ?>

                                        <tr>

                                            <input type="hidden" name="att_id" class="att_id" value="<?= $att['id'];?>">

                                            <td><?= $key+1;?></td>

                                            <!-- <td><?= $att['branch_name'];?></td> -->

                                            <td><?= $att['tittle'];?></td>

                                            <td><?= $att['description'];?></td>

                                          

                                            <td><?= $date ;?></td>

                                          



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

    var table = $('#mytable').DataTable( {
        dom: 'Bfrtip',

        buttons: [

            { extend: 'print',  title: 'Departments' },
        ]
    } );
</script>

<style>

tfoot input {

        width: 100%;

        padding: 3px;

        box-sizing: border-box;

		background-color:#e6e6e6;

    }

	tfoot {background-color:#f1f1f1}

	</style>

    

    

    

<!--<script src="<?php echo base_url();?>assets/datatables/jquery.dataTables.min.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/dataTables.bootstrap.min.js"></script>



<link rel="stylesheet" href="<?php echo base_url();?>assets/css/datatable_daterangepicker.css">

<link rel="stylesheet" href="<?php echo base_url();?>assets/datatables/style_datatable.css">

<script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/dataTables.buttons.min.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/buttons.bootstrap.min.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/jszip.min.js">

</script>

<script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/pdfmake.min.js">

</script>

<script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/vfs_fonts.js">

</script>

<script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/buttons.html5.min.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/buttons.print.min.js"></script>

<script type="text/javascript" language="javascript" src="<?php echo base_url();?>assets/datatables/buttons.colVis.min.js"></script>



<script type="text/javascript" src="<?php echo base_url();?>assets/datatables/moment.min.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/datatables/datatable_custom.js"></script>

<script type="text/javascript" src="<?php echo base_url();?>assets/datatables/daterangepicker.js"></script>-->

</body>

</html>