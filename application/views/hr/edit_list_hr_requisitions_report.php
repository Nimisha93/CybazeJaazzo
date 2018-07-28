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

         <a href="<?php echo base_url(); ?>hr/get_all_selected_report" class="btn btn-primary pull-right">Selected Candidates</a>
                        <a href="<?php echo base_url(); ?>hr/Recruitment/get_all_shortlist_report" class="btn btn-primary pull-right">Shortlists</a>
                                    <a href="<?php echo base_url(); ?>hr/Recruitment/get_all_candid_report" class="btn btn-primary pull-right">Candidates</a>
                                                <a href="<?php echo base_url(); ?>hr/Recruitment/get_all_post_report" class="btn btn-primary pull-right">Posts</a>
                                                            <a href="<?php echo base_url(); ?>requisition_report" class="btn btn-primary pull-right">Requesitions</a>

            <div class="col-md-12 col-sm-12 col-xs-12">

                <div class="x_panel">

                    <div class="x_title">

                        <h2>Requisitions</h2>

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


                                        <th >Branch</th>

                                        <th >Department</th>

                                        <th >Title</th>

                                        <th>Posts</th>

                                        <th >Location</th>

                                        <th >Age Range</th>

                                        <th >Salary Range</th>

                                        <th>Qualification</th>

                                        <th >Experience</th>
                                        <th >Description</th>


                                    </tr>


                                    </thead>

                                    <tbody>
                                    

                                    <?php $to = ' to ';
                                    foreach ($requisitions as $key => $requisition) {
                                        $date1 = $requisition['addon'];
                                        $date = convert_ui_date($date1);
                                        ?>

                                        <tr>

                                            <input type="hidden" name="req_id" class="req_id"
                                                   value="<?= $requisition['rq_id']; ?>">

                                            <td><?= $key + 1; ?></td>


                                            <td><?= $requisition['st_name']; ?></td>

                                            <td><?= $requisition['dep']; ?></td>

                                            <td><?= $requisition['title']; ?></td>

                                            <td><?= $requisition['posts']; ?></td>

                                            <td><?= $requisition['location']; ?></td>

                                            <td><?= $requisition['age_st'], $to, $requisition['age_en']; ?></td>

                                            <td><?= $requisition['salary_st'], $to, $requisition['salary_en']; ?></td>

                                            <td><?= $requisition['qualificationss']; ?></td>

                                            <td><?= $requisition['exp']; ?></td>
                                             <td><?= $requisition['desp']; ?></td>

                                        </tr>

                                    <?php } ?>


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

            {extend: 'print', title: 'Requisitions'},
        ]
    });
</script>


</body>

</html>