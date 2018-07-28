<?php echo $header; ?>
<style type="text/css">
    #edit_brand_name {text-transform: capitalize;}
</style>
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
                        <h2>Paid Salary Details<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                  <div class="x_content">
                        <div class="tbleovrscroll">
                          <table id="example" class="display table-bordered table-striped" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                    <th>No</th>
                                    <th>Employee Name</th>
                                    <th>Salary Date</th>
                                    <th>Total Working Days</th>
                                 
                                    <th>Net Paid</th>
                                    <th> Paid Date</th>
                                    <th>Action</th>

                                    </tr>

                                    </thead>




                                    <tbody>

                               <?php foreach($salary as $key=> $slr) { ?>
                                    <tr>
                                        <td><?php echo $key+1; ?>
                                            <input type="hidden" name="salary_id" class="salary_id" value="<?php echo $slr['id']; ?>"></td>
                                        <td><?php echo $slr['name']; ?></td>
                                        <td><?php echo $slr['to_date']; ?></td>
                                        <td><?php echo $slr['total_workingdays']; ?></td>
                                        <td><?php echo $slr['net_paid']; ?></td>
 <td><?php echo $slr['paid_date']; ?></td>
                                        <td>

                                          <a href="<?php echo base_url();?>hr/Payroll/generate_bill/<?php echo $slr['id']?>" data-toggle="tooltip" title="" class="btn btn-info" data-original-title="Edit" aria-describedby="tooltip393774" target="_blank"><i class="fa fa-print"></i>&nbsp;Print</a>

                                    </tr>
                                <?php } ?>

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
<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
 <script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>
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
<script>
    $(document).ready(function(){

           $(document).on('click','.pay',function(){
            var cur = $(this);

            var id=cur.parent().parent().find('.salary_id').val();

            $('.body_blur').show();
            $.post('<?php echo  base_url() ?>hr/Payroll/salary_payment',{id:id},function(data)
            {
                 $('.body_blur').hide();
                if(data.status == true)
                {
                  $('.body_blur').hide();

                    noty({text:"Salary Paid succesfully ",type: 'success',layout: 'top', timeout: 3000});

                    cur.parent().parent().remove();
                }
                else
                {

                  noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});

                }

            },'json');
        });

    });

    </script>
<script type="text/javascript">
    $(document).on('click', '.del_advance', function(){
        var cur = $(this);
        var advance_hidden  = cur.parent().parent().find('.advance_hidden').val();

        noty({
            text: 'Do you want to continue?',
            type: 'warning',
            buttons: [
                {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {

                    // this = button element
                    // $noty = $noty element

                    $noty.close();
                    $('.body_blur').show();
                    $.post('<?php echo base_url();?>hr/Payroll/delete_advance/'+advance_hidden, function(data){
                        $('.body_blur').hide();
                        if(data.status){
                            noty({text: 'Deleted Succesfully', type: 'success', timeout:1000});
                            cur.parent().parent().remove();
                        }else{
                            noty({text: 'Database Error', type: 'error'});
                        }
                    },'json');
                }
                },
                {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
                    $noty.close();

                }
                }
            ]
        });


    });
</script>
</body>
</html>