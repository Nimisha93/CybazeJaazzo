<?php echo $header; ?>
<style type="text/css">
    #edit_brand_name {text-transform: capitalize;}
</style>
<!-- <script src="<?php echo base_url();?>assets/admin/js/jquery-1.11.3.js"></script> -->
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">

</head>
<?php echo $sidebar; ?>
<!-- Modal content-->

<!-- Modal conten endt-->

<div class="right_col" role="main">
    <div class="">
      <!--  <div class="page-title">
            <div class="title_left">
                <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."><i class="fa fa-info-circle" aria-hidden="true"></i></div>
                </h3>
            </div>
            <div class="title_right">
                <form>
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                  <button class="btn btn-default" type="button">Go!</button>
                  </span> </div>
                    </div>
                </form>
            </div>
        </div>-->
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2> Payment <small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">

                            <!-- ========================== calendar which hide previous date===================================================-->

                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">

                                <div class="x_content">
                                    <div class="">

                                        <!-- ========================== calendar which hide previous date===================================================-->

                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">


                                            <form role="form" method="post" id="payment_form" name="myForm" action="<?php echo base_url();?>hr/Payroll/payroll_payment">
                                                <div class="box-body">
                                                    <div class="row">
                                                        <div class="col-md-3"> <div class="form-group">
                                                                <label >Employee Name</label>

                                                                <select name="empl_id" id="empl_id" class="form-control select2" data-rule-required="true">
                                                                    <option value="">Please Select</option>
                                                                    <?php foreach($employees['reqemp'] as $emp){ ?>
                                                                    <option value="<?= $emp['id'];?>"><?= $emp['name'];?>(<?= $emp['employee_code'];?>)</option>
                                                                    <?php } ?>
                                                                </select>

                                                            </div></div>

                                                        <div class="col-md-3"><div class="form-group">
                                                                <label for="date_of_join"> Date of Join</label>
                                                                <input type="text" id="date_of_join" value="" name="doj" class="form-control" readonly="readonly" data-rule-required="true">

                                                            </div></div>
                                                        <div class="col-md-3"><div class="form-group">
                                                                <label for="phone"> Phone</label>
                                                                <input type="text" id="phone" name="mob" value="" class="form-control" readonly="readonly" data-rule-required="true">
                                                                <p class="phone_ex"></p>
                                                            </div></div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label for="email">Email</label>
                                                                <input type="email" id="email" name="emi" value="" class="form-control" readonly="readonly" data-rule-required="true">
                                                            </div></div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="col-md-3"><div class="form-group">
                                                                <label for="age">Department</label>
                                                                <input type="text" id="department" name="dep" value="" class="form-control" readonly="readonly">
                                                            </div></div>
                                                        <div class="col-md-3"><div class="form-group">
                                                                <label for="age">Designation</label>
                                                                <input type="text" id="designation" name="dsg" value="" class="form-control" readonly="readonly">
                                                            </div></div>
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>From</label>
                                                               
                                                                <input type="text" id="frm" name="frm" class="form-control" value=""  data-rule-required="true">
                                                            </div>
                                                        </div>
                                              
                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>To</label>
                                                                <input type="text" id="too" name="too" class="form-control" value=""  data-rule-required="true">
                                                            </div>
                                                        </div>
                                                         
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-3"><div class="form-group">
                                                                <label > Bank</label>
                                                                <input type="text" name="bnk" class="form-control" value="" id="bank_name" readonly="readonly">

                                                            </div></div>
                                                        <div class="col-md-3"><div class="form-group">
                                                                <label > Bank A/C No</label>
                                                                <input type="text" name="bac" class="form-control" value="" id="bank_ac_no" readonly="readonly">

                                                            </div></div>
                                                        <div class="col-md-3"><div class="form-group">
                                                                <label > IFSC Code</label>
                                                                <input type="text" name="ifc" class="form-control" value="" id="ifsc_code" readonly="readonly">

                                                            </div></div>

                                                        <div class="col-md-3">
                                                            <div class="form-group">
                                                                <label>Total Working Days</label>

                                                                <input type="text" id="work_days" name="wds" class="form-control" value="" data-rule-required="true" readonly="" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                    <div class="col-md-3"><div class="form-group">
                                                                        <label >Total Leaves </label>
                                                                        <input type="text" id="total_leav" value="" name="lvt" class="form-control" data-rule-required="true"  onKeyPress="return isNumberKey(event)">
                                                                    </div></div>
                                                        <div class="col-md-3"><div class="form-group">
                                                                        <label >Allowed Leaves</label>
                                                                        <input type="text" id="allowed_leave" value="" name="lvr" class="form-control" data-rule-required="true"  onKeyPress="return isNumberKey(event)">
                                                                    </div></div>
                                                         <div class="col-md-3"><div class="form-group">
                                                                <label >Salary</label>
                                                                <input type="text" id="salary" value="" name="sly" class="form-control" readonly="readonly" data-rule-required="true">
                                                            </div></div>
                                                         <span><b>Paid By</b></span><br>
                                                        <div class="col-md-1">
                                                                <label >Cash</label>
                                                                <input type="radio" id="cash" value="CASH" name="mode" data-rule-required="true">
                                                               </div>
                                                        <div class="col-md-1">
                                                                <label >Bank</label>
                                                                <input type="radio" id="bank" value="BANK" name="mode" data-rule-required="true">

                                                            </div>

                                                    </div>
                                                    <div class="row">

                                                    </div>
                                                    <span><b>Total Earnings</b></span>
                                                    <div class="row">
                                                        <div class="col-md-3"><div class="form-group">
                                                                <label >TA</label>
                                                                <input type="text" id="ta" value="" name="ta" class="form-control" onKeyPress="return isFloatKey(event)">
                                                            </div></div>
                                                        <div class="col-md-3"><div class="form-group">
                                                                <label>DA</label>

                                                                <input type="text" id="da" value="" name="da" class="form-control" onKeyPress="return isFloatKey(event)">
                                                            </div></div>
                                                        <!--div class="col-md-2"><div class="form-group">
                                                                <label >Reimbursement</label>

                                                                <input type="text" id="reimburse" value="" name="rbs" class="form-control" >
                                                            </div></div-->

                                                       
                                                        <div class="col-md-3"><div class="form-group">
                                                                <label >Incentives</label>
                                                                <input type="text" id="inc_amount" value="" name="inc_amount" class="form-control" onKeyPress="return isFloatKey(event)">
                                                            </div></div>
                                                       
                                                        <div class="col-md-3"><div class="form-group">
                                                                <label >Bonus</label><br> 
                                                                <input type="text" id="bonus" value="" name="bonus" class="form-control" onKeyPress="return isFloatKey(event)">
                                                        </div></div>        
                                                       
                                                    </div>
                                                    <div class="row">
                                                                        <div class="col-md-3"><div class="form-group">
                                                                <label >HRA</label>
                                                                <input type="text" id="hra" value="" name="hra" class="form-control" onKeyPress="return isFloatKey(event)">
                                                            </div></div>
                                                        <div class="col-md-3"><div class="form-group">
                                                                <label>Additional TA (km)</label>

                                                                <input type="text" id="add_ta" value="" name="add_ta" class="form-control" onKeyPress="return isFloatKey(event)">
                                                            </div></div>
                                                        
                                                        <div class="col-md-3"><div class="form-group">
                                                                <label >Headquarter Allowance</label>
                                                                <input type="text" id="hq_allowance" value="" name="hq_allowance" class="form-control" onKeyPress="return isFloatKey(event)">
                                                            </div></div>
                                                         <div class="col-md-3"><div class="form-group">
                                                                <label >Ex-Headquarter Allowance</label>
                                                                <input type="text" id="ex_hq_allowance" value="" name="ex_hq_allowance" class="form-control" onKeyPress="return isFloatKey(event)">
                                                            </div></div>
                                                    </div>
                                                    <div class="row">
                                                        
                                                        <div class="col-md-3"><div class="form-group">
                                                                <label >Outdoor Allowance</label>
                                                                <input type="text" id="outdoor_allowance" value="" name="outdoor_allowance" class="form-control" onKeyPress="return isFloatKey(event)">
                                                            </div></div>
                                                        <div class="col-md-3"><div class="form-group">
                                                                <label >Other Allowance</label>
                                                                <input type="text" id="othe_allowance" value="" name="othe_allowance" class="form-control" onKeyPress="return isFloatKey(event)">
                                                            </div></div>

                                                    </div>
                                                    <span><b>Total Deductions</b></span>
                                                    <div class="row">


                                                             
                                                                <div class="col-md-3"><div class="form-group">
                                                                        <label >Advance Salary</label><input type="hidden" id="advance_old" value="" name="advance_old" class="form-control" readonly="readonly">
                                                                        <input type="text" id="advance" value="" name="ads" class="form-control" onKeyPress="return isFloatKey(event)">
                                                                    </div></div>
                                                                 <div class="col-md-3"><div class="form-group">
                                                                        <label > Loss Of Pay</label>
                                                                        <input type="text" id="lop" value="" name="lop" class="form-control" readonly="readonly" onKeyPress="return isFloatKey(event)">
                                                                    </div></div>
                                                              
                                                                   <div class="col-md-3"><div class="form-group">
                                                                        <label >Others</label>
                                                                        <input type="text" id="other_deductions" value="" name="ots" class="form-control" onKeyPress="return isFloatKey(event)">
                                                                    </div></div>
                                                                 <div class="col-md-3"><div class="form-group">
                                                                        <label >Insurance</label>
                                                                        <input type="text" id="insurance" value="" name="insurance" class="form-control" onKeyPress="return isFloatKey(event)">
                                                                    </div></div>
                                                                


                                                                    <div class="col-md-1"><div class="form-group">
                                                                <label >PF</label><br>
                                                                <input type="checkbox" id="pf" value="pf"  name="inc" >
                                                            </div></div> 
                                                        <div class="col-md-2" id="div_epf_amount"><div class="form-group">
                                                                <label >Employee PF Amount</label>
                                                                <input type="text" id="emp_pf_amount" value="0" name="emp_pf_amount" class="form-control" readonly onKeyPress="return isFloatKey(event)">
                                                               
                                                            </div></div>
                                                        <div class="col-md-2" id="div_epf_perc"><div class="form-group">
                                                                <label >PF Percentage</label>
                                                                <input type="text" id="emp_pf_perc" value="" name="emp_pf_perc" class="form-control" onKeyPress="return isFloatKey(event)">
                                                            </div></div>
                                                                <div class="col-md-2" id="div_cpf_amount"><div class="form-group">
                                                                <label >Company PF Amount</label>
                                                                <input type="text" id="cmp_pf_amount" value="0" name="cmp_pf_amount" class="form-control" readonly onKeyPress="return isFloatKey(event)">
                                                               
                                                            </div></div>
                                                        <div class="col-md-2" id="div_cpf_perc"><div class="form-group">
                                                                <label >Company PF Percentage</label>
                                                                <input type="text" id="cmp_pf_perc" value="" name="cmp_pf_perc" class="form-control" onKeyPress="return isFloatKey(event)">
                                                            </div></div>
                                                                 <div class="col-md-1"><div class="form-group">
                                                                <label >ESI</label><br>
                                                                <input type="checkbox" id="esi" value="esi" name="esi" onKeyPress="return isFloatKey(event)">
                                                            </div></div> 
                                                         <div class="col-md-2" id="div_esi_amount"><div class="form-group">
                                                                <label >ESI Amount</label>
                                                                <input type="text" id="esi_amount" value="0" name="esi_amount" class="form-control" readonly onKeyPress="return isFloatKey(event)">
                                                               
                                                            </div></div>
                                                        <div class="col-md-2" id="div_esi_perc"><div class="form-group">
                                                                <label >ESIC Percentage</label>
                                                                <input type="text" id="esi_perc" value="" name="esi_perc" class="form-control">
                                                            </div></div>
                                                                  
                                                       

                                                    </div>
                                                
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label>Gross Earning</label>
                                                                <input type="text" id="gross_earning" value="" name="gse" class="form-control" readonly="readonly">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4"> <div class="form-group">
                                                                <label >Gross Deduction</label>
                                                                <input type="text" id="gross_deduction" value="" name="gsd" class="form-control" readonly="readonly">
                                                            </div></div>
                                                        <div class="col-md-4"> <div class="form-group">
                                                            <label >Net Pay</label>
                                                            <input type="text" id="net_pay" value="" name="net" class="form-control" readonly="readonly" data-rule-required="true">
                                                        </div></div>
                                                    </div>

                                                </div>
                                                <div class="row append_expnce">

                                                </div>
                                                

                                                <!--  -->

                                        </div><!-- /.box-body -->

                                        <div class="box-footer">
                                            <button  type="submit" name="gen_submit" id="gen_submit" class="btn btn-primary  pull-right">Make Payment</button>
                                        </div>  <!-- /.box-body -->

                                        </form>

                                    </div>

                                </div>



                            </div>

                        </div>
                    </div>
                    <div class="clearfix"></div>


                    <div class="clearfix"></div>


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
<div id="notifications" style="z-index: 99999"></div><input type="hidden" id="position" value="center">

<?php echo $footer; ?>

<!--***************************date picker******************************-->
   <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/moment2.js"></script>
  <script type="text/javascript" src="<?php echo base_url();?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
  <link rel="stylesheet" href="<?php echo base_url();?>assets/admin/css/bootstrap-datetimepicker.min.css" />
  <!--***************************date picker end******************************-->
<script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<link href="<?php echo base_url();?>assets/admin/css/select2.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/select2.full.js" type="text/javascript" charset="utf-8">
</script>


<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script>
  $(document).ready(function(){
      $(document).on('keyup','#advance',function(){
        var adv = $(this).val();
            var adv_old = $('#advance_old').val();
            
         
            if(parseInt(adv) > parseInt(adv_old)){
             // noty({text:"Advance Salary exceeds "+adv_old,type: 'success',layout: 'top', timeout: 3000});
             $.toast("Advance Salary exceeds "+adv_old, {'width' :500});
              $('#advance').val(adv_old);
            }
  
         deduction();

      });
  });
  </script>
<script>
  $(document).ready(function(){
      $(document).on('keyup','#bonus_perc',function(){

         var cur=$(this);
         var perc=cur.val();
         var salary=$('#salary').val();
         var amount=(perc*salary)/100;
         $('#bonus_amount').val(amount);
         calculte_earning();

      });

      $(document).on('keyup','#esi_perc',function(){

         var cur=$(this);
         var perc=cur.val();
         var salary=$('#salary').val();
         var amount=(perc*salary)/100;
         $('#esi_amount').val(amount);
         deduction();

      });

       $(document).on('keyup','#cmp_pf_perc',function(){

         var cur=$(this);
         var perc=cur.val();
         var salary=$('#salary').val();
         var amount=(perc*salary)/100;
         $('#cmp_pf_amount').val(amount);
         deduction();

      });

       $(document).on('keyup','#emp_pf_perc',function(){

         var cur=$(this);
         var perc=cur.val();
         var salary=$('#salary').val();
         var amount=(perc*salary)/100;
         $('#emp_pf_amount').val(amount);
         deduction();

      });

  })  ;


</script>


<script>
 $(document).ready(function(){
$('#div_epf_amount').hide();
$('#div_epf_perc').hide();
$('#div_cpf_amount').hide();
$('#div_cpf_perc').hide();
$('#div_esi_amount').hide();
$('#div_esi_perc').hide();
$("#pf").click(function () {
if ($(this).prop('checked') === true) {
$('#div_epf_amount').show();
$('#div_epf_perc').show();
$('#div_cpf_amount').show();
$('#div_cpf_perc').show();
}
else
    {
$('#div_epf_amount').hide();
$('#div_epf_perc').hide();
$('#div_cpf_amount').hide();
$('#div_cpf_perc').hide();
    }

});


$("#esi").click(function () {
if ($(this).prop('checked') === true) {
$('#div_esi_amount').show();
$('#div_esi_perc').show();

}
else
    {
$('#div_esi_amount').hide();
$('#div_esi_perc').hide();
    }

});
 });
</script>
<script type="text/javascript">
    $(document).ready(function(){


      var v = jQuery("#payment_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                            $('#payment_form').hide();
                            $('.body_blur').hide();
                             var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Added Payment</div></div>';
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
                    }
                });
            }
        });

    });


</script>
<script type="text/javascript">



    $(document).on('keypress',".incentives",function (e) {
        //if  theletter is not digit then display error and don't type anything
        if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) {
            //display error message
            //   $("#errmsg").html("Digits Only").show().fadeOut("slow");
            return false;
        }
    });

    // American Numbering System
    var a = ['', 'one ', 'two ', 'three ', 'four ', 'five ', 'six ', 'seven ', 'eight ', 'nine ', 'ten ', 'eleven ', 'twelve ', 'thirteen ', 'fourteen ', 'fifteen ', 'sixteen ', 'seventeen ', 'eighteen ', 'nineteen '];
    var b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
    function inWords(num) {
        if ((num = num.toString()).length > 9) return 'overflow';
        n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        if (!n) return;
        var str = '';
        str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
        str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
        str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
        str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
        str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
        $('#inwords').val(str)
    }
</script>
<script>

    jQuery(document).ready(function(){

        $('.select2').select2({
            placeholder:'Please select'
        });

        $('#work_days').on('input',function() {
            lossofpay();
            calculte_earning();
        });
        $('#total_leav').on('input',function() {
            lossofpay();
            calculte_earning();
        });
        $('#inc_amount').on('input',function() {
            lossofpay();
            calculte_earning();
        });
        $('#ta').on('input',function() {
            lossofpay();
            calculte_earning();
        });
        $('#da').on('input',function() {
            lossofpay();
            calculte_earning();
        });
        $('#hra').on('input',function() {
            lossofpay();
            calculte_earning();
        });
        

        $('#hq_allowance').on('input',function() {
            lossofpay();
            calculte_earning();
        });
        $('#add_ta').on('input',function() {
            lossofpay();
            calculte_earning();
        });
        $('#ex_hq_allowance').on('input',function() {
            lossofpay();
            calculte_earning();
        });
        $('#other_deductions').on('input',function() {
            lossofpay();
            calculte_earning();
        });
        $('#outdoor_allowance').on('input',function() {
            lossofpay();
            calculte_earning();
        });
        $('#bonus').on('input',function() {
            lossofpay();
            calculte_earning();
        });
        $('#othe_allowance').on('input',function() {
            lossofpay();
            calculte_earning();
        });
        $('#allowed_leave').on('input',function() {
            lossofpay();
            calculte_earning();
        });
        $('#insurance').on('input',function() {
            //alert("f");
            deduction();
        });

        $('#other_deductions').on('input',function() {
            deduction();
        });
         if($('#esi').is(':checked')){

             //deduction();
         }
         if($('#pf').is(':checked')){

            // deduction();
         }


    });


    function calculte_earning(){

        var cur_salary = isNaN(parseFloat($('#salary').val())) ? 0 : parseFloat($('#salary').val());
        var bonus = isNaN(parseFloat($('#bonus').val())) ? 0 : parseFloat($('#bonus').val());
//        var reimburse = isNaN(parseFloat($('#reimburse').val())) ? 0 : parseFloat($('#reimburse').val());
        var incentives = isNaN(parseFloat($('#inc_amount').val())) ? 0 : parseFloat($('#inc_amount').val());
//        var deduct_rate = isNaN(parseFloat($('#deduct_rate').val())) ? 0 : parseInt($('#deduct_rate').val());
        var advance = isNaN(parseFloat($('#advance').val())) ? 0 : parseInt($('#advance').val());
        var other_deductions = isNaN(parseFloat($('#other_deductions').val())) ? 0 : parseFloat($('#other_deductions').val());
        var lop_amount = isNaN(parseFloat($('#lop').val())) ? 0 : parseFloat($('#lop').val());
        var ta = isNaN(parseFloat($('#ta').val())) ? 0 : parseFloat($('#ta').val());
        var da = isNaN(parseFloat($('#da').val())) ? 0 : parseFloat($('#da').val());
        var add_ta = isNaN(parseFloat($('#add_ta').val())) ? 0 : parseFloat($('#add_ta').val());
        var hq_allowance = isNaN(parseFloat($('#hq_allowance').val())) ? 0 : parseFloat($('#hq_allowance').val());
        var hra = isNaN(parseFloat($('#hra').val())) ? 0 : parseFloat($('#hra').val());
        var ex_hq_allowance = isNaN(parseFloat($('#ex_hq_allowance').val())) ? 0 : parseFloat($('#ex_hq_allowance').val());
        var outdoor_allowance = isNaN(parseFloat($('#outdoor_allowance').val())) ? 0 : parseFloat($('#outdoor_allowance').val());
        var othe_allowance = isNaN(parseFloat($('#othe_allowance').val())) ? 0 : parseFloat($('#othe_allowance').val());


        var gross_earn = bonus + hra + incentives + ta + da + add_ta + hq_allowance + ex_hq_allowance  + outdoor_allowance + othe_allowance;
        
        var gross_deduc = lop_amount + other_deductions + advance ;
        var net_pay = gross_earn - gross_deduc;
        net_pay = net_pay.toFixed(2);
        $("#payment_form").find('#gross_earning').val(parseFloat(gross_earn));
        var gross_deduction=$('#gross_deduction').val();
        var total = cur_salary + gross_earn - gross_deduction;

           $('#net_pay').val(total);
    }
    function lossofpay() {
        var hra = isNaN(parseFloat($('#hra').val())) ? 0 : parseFloat($('#hra').val());
        var ta = isNaN(parseFloat($('#ta').val())) ? 0 : parseFloat($('#ta').val());
        var da = isNaN(parseFloat($('#da').val())) ? 0 : parseFloat($('#da').val());
        //console.log(hra);console.log(add_ta);console.log(hq_allowance);
        var cur_salary = isNaN(parseFloat($('#salary').val())) ? 0 : parseFloat($('#salary').val());
        var no_working_days = isNaN(parseFloat($('#work_days').val())) ? 0 : parseFloat($('#work_days').val());
        var total_leav = isNaN(parseFloat($('#total_leav').val())) ? 0 : parseFloat($('#total_leav').val());
        var allowed_leav = isNaN(parseFloat($('#allowed_leave').val())) ? 0 : parseFloat($('#allowed_leave').val());
        var total = cur_salary ;
        //console.log(total);
        var sal_one_day = (total * 12)/365;
        //console.log(sal_one_day);
        if(total_leav>allowed_leav){
            var leav = total_leav-allowed_leav;
            var loss_pay = (sal_one_day * leav).toFixed(2);
            $("#payment_form").find('#lop').val(parseFloat(loss_pay));
        }
        else{

            $("#payment_form").find('#lop').val(parseFloat(0));
        }
        deduction();
    }


    function deduction()
    {
          var cur_salary = isNaN(parseFloat($('#salary').val())) ? 0 : parseFloat($('#salary').val());
          var other_deductions = isNaN(parseFloat($('#other_deductions').val())) ? 0 : parseFloat($('#other_deductions').val());
          var insurance = isNaN(parseFloat($('#insurance').val())) ? 0 : parseFloat($('#insurance').val());
          var emp_pf_amount = isNaN(parseFloat($('#emp_pf_amount').val())) ? 0 : parseFloat($('#emp_pf_amount').val());
      
          var esi_amount = isNaN(parseFloat($('#esi_amount').val())) ? 0 : parseFloat($('#esi_amount').val());

          var advance = isNaN(parseFloat($('#advance').val())) ? 0 : parseFloat($('#advance').val());
          var lop = isNaN(parseFloat($('#lop').val())) ? 0 : parseFloat($('#lop').val());

          var gross_deduction = other_deductions + insurance + emp_pf_amount + esi_amount + advance + lop;

     
         $('#gross_deduction').val(gross_deduction);

         var gross_earning=isNaN(parseFloat($('#gross_earning').val())) ? 0 : parseFloat($('#gross_earning').val());
         //console.log(cur_salary);console.log(gross_earning);console.log(gross_deduction);
         var total = cur_salary + gross_earning - gross_deduction;
      
         $('#net_pay').val(total);
         return gross_deduction;

 }
</script>


<script type="text/javascript">
    $(document).ready(function(){
        var date_input = $('input[id="frm"]');
                      today = new Date();        //alert(today);
                      var options={
                        format: 'DD-MM-YYYY',
            //            todayHighlight: true,
                      
                       
       };
     date_input.datetimepicker(options);
     var date_input1 = $('input[id="too"]');
                      today = new Date();        //alert(today);
                      var options={
                        format: 'DD-MM-YYYY',
            //            todayHighlight: true,
                      
                       
       };
     date_input1.datetimepicker(options);      
        $('#empl_id').change(function(){
            var cur = $(this);
            var emp_id = cur.val();
            $('.body_blur').show();
            $.post('<?= base_url();?>hr/Payroll/get_employee_det_id/'+emp_id, function(data){
                $('.body_blur').hide();
                if(data.status)
                {
                    var data = data.data;
                    var emp_det = data.emp;
                    var bonus = data.bonus;
                   
                    var adv_sal = data.adv_sal;
                    var prefer=data.prefer;
                   
                    var emp_sal = emp_det.salary
                    var date = data.date;


                    var from = date.from_date;

                    var fromz = moment(from).format('DD-MM-YYYY');

                    var date = new Date(from);
                    var lastDay = new Date(date.getFullYear(), date.getMonth() + 1, 0);
                    var str = moment(lastDay).format('DD-MM-YYYY');
                    
                    //$("#too").datetimepicker('minDate', fromz);
                    //$("#too").datetimepicker('maxDate', str);
                   // $("#frm").datetimepicker('minDate', fromz);
                    $("#payment_form").find('#frm').val(from);
                    $("#payment_form").find('#too').val('');
                    $('#work_days').val('');
                    $("#payment_form").find('#date_of_join').val(emp_det.date_of_join);
                    $("#payment_form").find('#phone').val(emp_det.mobile);
                    $("#payment_form").find('#email').val(emp_det.email);
                    $("#payment_form").find('#department').val(emp_det.dept);
                    $("#payment_form").find('#designation').val(emp_det.desig);
                    $("#payment_form").find('#bank_name').val(emp_det.bank_name);
                    $("#payment_form").find('#bank_ac_no').val(emp_det.bank_ac_no);
                    $("#payment_form").find('#ifsc_code').val(emp_det.bank_ifsc);
                    $("#payment_form").find('#salary').val(emp_sal);
                   
                   
                    $("#payment_form").find('#ta').val(emp_det.ta);
                    $("#payment_form").find('#da').val(emp_det.da);
                    $("#payment_form").find('#hra').val(emp_det.hra);
                    
           
                    var esiprc = data.esi;
                    var esi_perc=esiprc.value;
                    $('#esi_perc').val(esi_perc);
                    //alert(esi_perc);
                    var salary=$('#salary').val();
                    var esi_amnt=salary*(esi_perc/100);//alert(esi_amnt);
                    $('#esi_amount').val(esi_amnt);
                     if($("#esi").is(":checked"))
                           {
                           $('#esi_amount').val(esi_amnt);//alert("dfsdfsd");
                          deduction();
                         
                           }
                       else
                           {
                            $('#esi_amount').val(0);
                           deduction();
                          
                           }

                      var cmppf=data.cmp_pf;
                      var emppf=data.emp_pf;
                      var cmp_perc=cmppf.value;
                      var emp_perc=emppf.value;
                      $('#cmp_pf_perc').val(cmp_perc);
                      $('#emp_pf_perc').val(emp_perc);
                      var emp_pf_amt=salary*(emp_perc/100);
                      var cmp_pf_amt=salary*(cmp_perc/100);
                      $('#cmp_pf_amount').val(cmp_pf_amt);
                      $('#emp_pf_amount').val(emp_pf_amt);


                      if($("#pf").is(":checked"))
                           {  
                           $('#cmp_pf_amount').val(cmp_pf_amt);
                           $('#emp_pf_amount').val(emp_pf_amt);
                           deduction();
                           }
                       else
                           {
                            $('#cmp_pf_amount').val(0);
                            $('#emp_pf_amount').val(0);
                            deduction();
                           }

                     
                     
                      calculte_earning();
                      deduction(); 

                  
                } else{
                    //noty({text:data.reason,type: 'error',layout: 'top', timeout: 2000});
                    $.toast(data.reason,{'width' :500});
                }
            },'json');
  
        });



    });
</script>
<script>
$('#frm').on("dp.change", function(){
     
     /*   var cur = $(this);
        var from = cur.val();
        var statarr=from.split('-');
        var dstart = new Date(statarr[1]+'-'+statarr[0]+'-'+statarr[2]);
     
        var lastDay = new Date(dstart.getFullYear(), dstart.getMonth() + 1, 0);
        var str = moment(lastDay).format('DD-MM-YYYY');
        var dstart = moment(dstart).format('DD-MM-YYYY');
        console.log(dstart);console.log(str);
         $("#too").datetimepicker('maxDate', str);
        $("#too").datetimepicker('minDate', dstart);*/
       

  });      
 $('#too').on("dp.change", function(){
        
        var cur = $(this);
        var to = cur.val();

        var from = $('#frm').val();
        
        var msDay = 60*60*24*1000;            
        var statarr=from.split('-');
        var endarr=to.split('-');

        var dstart = new Date(statarr[1]+'-'+statarr[0]+'-'+statarr[2]).getTime();
        var dend   = new Date(endarr[1]+'-'+endarr[0]+'-'+endarr[2]).getTime();

        var diff = parseInt(dend-dstart);

        var diff=Math.floor(diff / msDay)+1;

        $('#work_days').val(diff);
        var emp_id = $('#empl_id option:selected').val();
       // $('#empl_id').val(emp_id);
        //alert(emp_id)
        $.post('<?= base_url();?>hr/Payroll/get_advsal_details_by_id',{emp_id : emp_id,from_date:from,to_date:to}, function(data1){
                            console.log(data1);
                            if(data1.status==true)
                            {
                                var cur_salary = isNaN(parseFloat($('#salary').val())) ? 0 : parseFloat($('#salary').val());
                                var ad = data1.data.advance_salary_org;
                                $("#net_pay").val(parseFloat(cur_salary)-parseFloat(ad));
                                var sal = data1.data.advance_salary_org;
                                if( sal == '0' || sal == '' || sal == 'undefined' || sal == null )
                                    $('#advance').attr("readonly", "readonly");
                                else
                                $('#advance').val(sal);
                              $('#advance_old').val(sal);
                            }else{
                                $('#advance').attr("readonly", "readonly");
                                calculte_earning();
                                deduction(); 
                            }
                        },'json');
            
       });
$(document).ready(function(){
$(document).on('click','#esi',function(){
var cur=$(this);
   $.post('<?= base_url();?>hr/Payroll/get_esi_perc/', function(data){
              
                if(data.status)
                {
                    var data = data.data;
                    var esiprc = data.esi;
                    var esi_perc=esiprc.value;
                    $('#esi_perc').val(esi_perc);
                    //alert(esi_perc);
                    var salary=$('#salary').val();
                    var esi_amnt=salary*(esi_perc/100);//alert(esi_amnt);
                    $('#esi_amount').val(esi_amnt);
                    
                    
                    if (cur.prop('checked') === true) {
                    
                    $('#esi_amount').val(esi_amnt);
                    deduction();
                    }
                    else
                     {
                    $('#esi_amount').val(0);
                    deduction();
                     }

                    

                } else{
                   // noty({text:data.reason,type: 'error',layout: 'top', timeout: 2000});
                   $.toast(data.reason,{'width' :500});
                }
            },'json');

   //$.toast("Successfully created", {'width' :500}); 
   // $.toast(data.reason,{'width' :500});          
});

});


 </script>

<script>
  $(document).ready(function(){
  $(document).on('click','#pf',function(){

  var cur=$(this);
 $.post('<?php echo base_url();?>hr/Payroll/get_pf_perc',function(data){

  if(data.status)
      {
      data=data.data;
      var cmppf=data.cmp_pf;
      var emppf=data.emp_pf;
      var cmp_perc=cmppf.value;
      var emp_perc=emppf.value;
      $('#cmp_pf_perc').val(cmp_perc);
      $('#emp_pf_perc').val(emp_perc);
      var salary=$('#salary').val();
      var emp_pf_amt=salary*(emp_perc/100);
      var cmp_pf_amt=salary*(cmp_perc/100);
      $('#cmp_pf_amount').val(cmp_pf_amt);
      $('#emp_pf_amount').val(emp_pf_amt);

 if (cur.prop('checked') === true) {
                $('#cmp_pf_amount').val(cmp_pf_amt);
                $('#emp_pf_amount').val(emp_pf_amt);
                deduction();
            }
            else
            {
                $('#cmp_pf_amount').val(0);
                $('#emp_pf_amount').val(0);
                deduction();
            }
      }

 },'json');

 
  })  ;

  })  ;
 function isNumberKey(evt){
      var charCode = (evt.which) ? evt.which : event.keyCode
      if (charCode > 31 && (charCode < 48 || charCode > 57))
          return false;
      return true;
  }
  function isFloatKey(e){
    
       if ((e.which != 46 || $(this).val().indexOf('.') != -1) && (e.which < 48 || e.which > 57)) {
       e.preventDefault();
           // noty({text: 'Numbers Only', type: 'error', timeout: 1000 });// alert("Numbers Only");
            return false;
        }
  }
</script>


</body>
</html>