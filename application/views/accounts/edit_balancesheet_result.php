<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Balance Sheet<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">

                            
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="tbleovrscroll">
                            <div class="row">
                                <div class="col-md-12">
                                                                    <?php        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $from11 = $finacial['start_year']; 
$from=convert_ui_date($from11);

        ?>

                                  <input type='hidden' class="form-control" style="width: 144%;" id="fn_st_date"
                                                   value="<?php echo $from11; ?>" name="fn_st_date" />



 <?php        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $from22 = $finacial['end_year']; 
$end=convert_ui_date($from22);

        ?>
 <input type='hidden' class="form-control" style="width: 144%;" id="fn_e_date"
                                                   value="<?php echo $from22; ?>" name="fn_e_date" />
                                    <div class="col-md-6">
                                        <div class="input-group input-daterange">

                                            <input type="text" id="min-date" class="form-control" placeholder="From:">

                                            <div class="input-group-addon">to</div>

                                            <input type="text" id="max-date" class="form-control" placeholder="To:">

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-primary btn_submit">Submit</button>
                                    </div>
                                
                               
                                </div>
                            </div>
                            <table id="example" class="display table-bordered table-striped" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                  
                                    <th>Perticulars</th>
                                    <th>Dr Amount</th>
                                    <th>Cr Amount</th>
                                    <th>Balance</th>
                                </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>
                      <!--   <div class="pull-right" id="pagination"></div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<?php echo $footer; ?>

<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet" />
<script type="text/javascript" src="<?= base_url() ?>assets/admin/js/moment2.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/css/bootstrap-datetimepicker.min.css" />


<!-- <script type="text/javascript">
    $(function () {
        $('#max-date,#min-date,#max-dates,#min-dates').datetimepicker(
            {
                format: "DD-MM-YYYY"
            }
        );
    });

</script> -->

<script type="text/javascript">
    $(function () {
var fs=$('#fn_st_date').val();
        $('#min-date').datetimepicker({
            minDate:fs,
             // startDate: '2016/08/19 10:00',
            format: 'DD-MM-YYYY'
        });
var fe=$('#fn_e_date').val();


         $(' #max-date').datetimepicker({
            maxDate:fe,
             // startDate: '2016/08/19 10:00',
            format: 'DD-MM-YYYY'
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        $('.selectBox').SumoSelect({okCancelInMulti:true, selectAll:true, search:true});
        var base_url = "<?php echo base_url(); ?>";
        function load_demo(index) {
            index = index || 0;
            var from_date = $('#min-date').val();
            var todate = $('#max-date').val();
            
            $('.body_blur').show();
            $.post(base_url + "accounts/accounts/get_balanceSheet/", { ajax: true, from_date: from_date, todate: todate }, function(data) {
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.status){

                    var tr = '';
                    var assets = data.assets;
                    var liabilities = data.liabilities;

                     var income = data.income;
                    var expence = data.expence;


// 
                    var total_assets =0;   
                    var total_liabilities =0;   

                    var total_income =0;   
                    var total_expence =0;   
                    tr += '<tr>'+
                           
                            '<td><b>Liabilities</b></td>'+
                            '<td colspan="3"></td>'+
                            
                            '</tr>';


                             for(var i = 0; i< income.length; i++)
                             {

total_income += parseFloat(income[i].balance);

                             }

                                 for(var i = 0; i< expence.length; i++)
                                 {

total_expence += parseFloat(expence[i].balance);
                                
                             }


var net_income=Math.abs(total_income)-Math.abs(total_expence);

                           


                    for(var i = 0; i< liabilities.length; i++){
                        
                         if(liabilities[i].balance >0){
                            var bal = 'Dr '+liabilities[i].balance;
                         }else{
                            var bal = 'Cr '+liabilities[i].balance;
                         }

                        tr += '<tr>'+
                           
                            '<td>'+liabilities[i].gp_name+'</td>'+
                            '<td>'+liabilities[i].dr_amount+'</td>'+
                            '<td>'+liabilities[i].cr_amount+'</td>'+
                            '<td>'+bal+'</td>'+
                            '</tr>';
                            total_assets += parseFloat(liabilities[i].balance);

                    }


                     var total_assets1=Math.abs(total_assets+net_income);

                    if(total_assets >0)
                    {
                            var total_assets = 'Dr '+total_assets;
                         }else{
                            var total_assets = 'Cr '+total_assets;
                         }



                     tr += '<tr>'+
                           
                            '<td colspan="3"><b>Total Liabilities</b></td>'+
                          
                            '<td><b>'+total_assets+'</b></td>'+
                            '</tr>';

                             tr += '<tr>'+
                           
                            '<td colspan="3"><b>Net Profit</b></td>'+
                          
                            '<td><b>'+net_income+'</b></td>'+
                            '</tr>';

                                tr += '<tr>'+
                           
                            '<td colspan="3"><b>Total</b></td>'+
                          
                            '<td><b>'+total_assets1+'</b></td>'+
                            '</tr>';

                       tr += '<tr>'+
                           
                            '<td><b>Assets</b></td>'+
                            '<td colspan="3"></td>'+
                            
                            '</tr>';

                    for(var i = 0; i< assets.length; i++){
                        total_liabilities += parseFloat(assets[i].balance);
                        if(assets[i].balance >0){
                            var ball = 'Dr-'+assets[i].balance;
                         }else{
                            var ball = 'Cr'+assets[i].balance;
                         }

                        tr += '<tr>'+
                           
                            '<td>'+assets[i].gp_name+'</td>'+
                            '<td>'+assets[i].dr_amount+'</td>'+
                            '<td>'+assets[i].cr_amount+'</td>'+
                            '<td>'+ball+'</td>'+
                            '</tr>';

                    }

                    var tot_asst=Math.abs(total_liabilities);
                     if(total_liabilities >0){
                            var total_liabilities = 'Dr '+total_liabilities;
                         }else{
                            var total_liabilities = 'Cr '+total_liabilities;
                         }
                    tr += '<tr>'+
                           
                            '<td colspan="3"><b>Total </b></td>'+
                            
                            '<td><b>'+tot_asst+'</b></td>'+
                            '</tr>';
                    

                    $('tbody').html(tr);

                }else{



                }



            }, "json");
        }

        //calling the function
        load_demo();



      



        $('.btn_submit').click(function () {
            load_demo();
        });




    });

</script>


</body>
</html>