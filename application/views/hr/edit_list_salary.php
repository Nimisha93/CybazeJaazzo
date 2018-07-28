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
                        <h2>Salary Details<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                             <li>
                               <a type="button" class="btn btn-primary fllft del_btn btn-danger" style=""><i class="fa fa-trash" aria-hidden="true"></i></a>
                            </li>
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
                                    <th>Action</th>

                                    </tr>

                                    </thead>




                                    <tbody>

                              <?php foreach($salary as $key=> $slr) { ?>
                                    <tr>
                                        <td><?php echo $key+1; ?>
                                            <input type="hidden" name="paid_by" class="paid_by" value="<?php echo $slr['paid_by']; ?>">
                                            <input type="hidden" name="emp_id" class="emp_id" value="<?php echo $slr['emp_id']; ?>">
                                            <input type="hidden" name="salary_id" class="salary_id" value="<?php echo $slr['id']; ?>"></td>
                                        <td><?php echo $slr['name']; ?></td>
                                        <td><?php echo $slr['to_date']; ?></td>
                                        <td><?php echo $slr['total_workingdays']; ?></td>
                                        <td class="net_paid"><?php echo $slr['net_paid']; ?></td>

                                        <td>
                                          <button type="button" class="btn btn-info pay"><i class="fa fa-money" aria-hidden="true" data-toggle="tooltip" data-original-title="Pay" aria-describedby="tooltip393774"></i></button>
                                         
                                          <a href="<?php echo base_url();?>hr/Payroll/edit_salary/<?php echo $slr['emp_id']?>/<?php echo $slr['id']?>" class="btn btn btn-primary fllft edit_btn" data-toggle="tooltip" data-original-title="Edit" aria-describedby="tooltip393774"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                        
                                           <input type="checkbox" name="" value="<?php echo $slr['id'];?>" class="chck_grp_item">
                                          </td>
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

<div id="pay_salary_model" class="modal fade" role="dialog">
    <div class="modal-dialog" style="max-width:600px">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">X</button>
                <h4 class="modal-title">Payment</h4>
            </div>
            <form id="pay_form" method="post">
                <div class="modal-body">
                    <p>
                    <div class="row">
                        
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">

                            <label>Payment Date</label>
                            <input type="hidden" id="salary_id" name="salary_id" class="form-control">
                            <input type="hidden" id="emp_id" name="emp_id" class="form-control">
                            <input type="hidden" id="paid_by" name="paid_by" class="form-control">
                            <input type="hidden" id="net_paid" name="net_paid" class="form-control">
                            <input type="text" id="payment_date" name="payment_date" placeholder="Payment Date" data-rule-required="true" class="form-control">
                        </div>
                    </div>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit_payment" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>

    </div>
</div>



<!--************************row  end******************************************************************* -->

</div>
</div>
</div>
</div>
</div>
<div id="notifications" style="z-index: 99999"></div><input type="hidden" id="position" value="center">

<?php echo $footer; ?>


<script type="text/javascript" src="<?= base_url() ?>assets/admin/js/moment2.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/css/bootstrap-datetimepicker.min.css" />
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
<script type="text/javascript">
    $(function () {
        $('#payment_date').datetimepicker(
            {
                format: 'DD-MM-YYYY'
            }
        );
    });
</script>

<script type="text/javascript">
    $(document).ready(function(){
        $('#submit_payment').click(function(e){
            e.preventDefault();
            var id= $('#pay_form').find("#salary_id").val();
            var emp_id= $('#pay_form').find("#emp_id").val();
            var paid_by=$('#pay_form').find("#paid_by").val();
            var net_paid=$('#pay_form').find("#net_paid").val();
            var p_date = $('#pay_form').find("#payment_date").val();
            $('.body_blur').show();
            $.post('<?php echo  base_url() ?>hr/Payroll/pay_salary',{id:id,emp_id:emp_id,net_paid:net_paid,paid_by:paid_by,p_date:p_date},function(data)
            {
                 $('.body_blur').hide();
                if(data.status == true)
                {
                  $('.body_blur').hide();
                 
                   


                   
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Salary Paid successfully</div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

 location.reload();
                    }, 2000);
                }
                else
                {
                 $('.body_blur').hide();
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                 
                }
               
            },'json');
        });
    });
    $(document).on('click','.pay', function()
     {      
            var cur = $(this);
            var id=cur.parent().parent().find('.salary_id').val();
            var emp_id=cur.parent().parent().find('.emp_id').val();
            var paid_by=cur.parent().parent().find('.paid_by').val();
            var net_paid=cur.parent().parent().find('.net_paid').html();
            $('#pay_form').find("#salary_id").val(id);
            $('#pay_form').find("#emp_id").val(emp_id);
            $('#pay_form').find("#paid_by").val(paid_by);
            $('#pay_form').find("#net_paid").val(net_paid);
            $('#pay_salary_model').modal('show');
           
            
        });
  $(document).on('click','.del_btn',function(){
    
        var cur=$(this);

        var itemgrps = [];
        $('.chck_grp_item').each(function () {
            var cur_this = $(this);
            var cur_val = $(this).val();
            if(cur_this.is(":checked")){
                itemgrps.push(cur_val);
            }

        });
       
        if(itemgrps.length > 0){
            noty({
            text: 'Do you want to continue?',
            type: 'warning',
            buttons: [
                {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {

                    $noty.close();


                        $('.body_blur').show();
                        $.post('<?php echo base_url();?>hr/Payroll/delete_salary/',{itemgrps:itemgrps}, function(data){
                            $('.body_blur').hide();
                            if(data.status){
                                $.toast('Deleted successfully', {'width': 500});

                                setTimeout(function(){
                                    location.reload();
                                }, 1000);



                                }else{
                                    $.toast(data.reason, {'width': 500});
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
        }
    });    
</script>
</body>
</html>