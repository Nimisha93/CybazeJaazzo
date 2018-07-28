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

         <a href="<?php echo base_url(); ?>hr/Recruitment/get_all_selected_report" class="btn btn-primary pull-right">Selected Candidates</a>
                        <a href="<?php echo base_url(); ?>hr/Recruitment/get_all_shortlist_report" class="btn btn-primary pull-right">Shortlists</a>
                                    <a href="<?php echo base_url(); ?>hr/Recruitment/get_all_candid_report" class="btn btn-primary pull-right">Candidates</a>
                                                <a href="<?php echo base_url(); ?>hr/Recruitment/get_all_post_report" class="btn btn-primary pull-right">Posts</a>
                                                            <a href="<?php echo base_url(); ?>hr/Recruitment/get_all_requisition_report" class="btn btn-primary pull-right">Requesitions</a>

            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">

                    <div class="x_title">

                        <h2>Candidates</h2>

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

                                <table id="patient_table"
                                       class="table display table-bordered table-striped responsive-utilities">

                                    <thead>


                                    <tr class="tablbg">

                                                 <th>No</th>

                                        <th >Post </th>

                                        <th >Name</th>

                                        <th >DOB</th>

                                        <th >Gender</th>

                                        <th>Address</th>

                                        <th >Pin</th>

                                        <th>Email</th>

                                        <th>Phone</th>

                                        <th >Qualification</th>

                                        <th >Experience</th>
                                        <th>Status</th>


                                    </tr>


                                    </thead>

                                    <tbody>
                                    <?php foreach ($candids as $key => $candid) { 
                                    
                                    
                                    ?>

                                        <tr>

                                            <input type="hidden" name="cnd_id" class="cnd_id" value="<?= $candid['cd_id'];?>">

                                            <td><?= $key+1;?></td>

                                            <td><?= $candid['posts'];?></td>

                                            <td><?= $candid['name'];?></td>

                                            <?php

                                            $dater= $candid['dob'];

                                            $date1=convert_ui_date($dater);



                                            ?>



                                            <td><?=$date1;?></td>

                                            <td><?= $candid['gender'];?></td>

                                            <td><?= $candid['address'];?></td>

                                            <td><?= $candid['pin'];?></td>

                                            <td><?= $candid['email'];?></td>

                                            <td><?= $candid['phone'];?></td>

                                            <td><?= $candid['qualification'];?></td>

                                            <td><?= $candid['exp'];?></td>

                                             <?php if($candid['shortlists_status']==0) { ?><td></i>Shortlist</a></td><?php }
                                            else { ?><td>Shortlisted</button></td><?php } ?>





                                         

                                              



                                        </tr>

                                    <?php   } ?>


                                    </tbody>

                                    <tfoot>


                                    </tfoot>

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

            {extend: 'print', title: 'Candidates'},
        ]
    });
</script>


</body>

</html>