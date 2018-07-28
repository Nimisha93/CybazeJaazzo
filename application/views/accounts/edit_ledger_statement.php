<?php echo $default_assets; ?>
<link href="<?php echo base_url(); ?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Ledger Statement<small></small>
                        </h2>
                        <ul class="nav navbar-right panel_toolbox">

                           
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <form role="form" id="ledger_form" method="post" name="ledger_form">
                            <div class="box-body">
                                <div class="row">
 <?php        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $from11 = $finacial['start_year']; 
$from=convert_ui_date($from11);
      // echo $from;exit();

        ?>
         <input type='hidden' class="form-control" style="width: 144%;" id="fn_st_date"
                                                   value="<?php echo date("d-m-Y"); ?>" name="fn_st_date" />   
                                                   <div class="col-md-3 col-sm-6 col-xs-12 form-group">

                                        <label>From Date</label>
                                        <div class='input-group date' id='datetimepicker3'>
                                            <input type='text' class="form-control" style="width: 144%;" id="from_date"
                                                   value="<?php echo date("d-m-Y"); ?>" name="from_date" required=""/>
                                        </div>
                                    </div>

 <?php        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $from22 = $finacial['end_year']; 
$end=convert_ui_date($from22);

        ?>
 <input type='hidden' class="form-control" style="width: 144%;" id="fn_e_date"
                                                   value="<?php echo $from22; ?>" name="fn_e_date" />
                                    <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                        <label>To Date</label>
                                        <div class='input-group date' id='datetimepicker2'>
                                            <input type='text' class="form-control" style="width: 144%;" id="to_date"
                                                   value="<?php echo date("d-m-Y"); ?>" name="to_date" required=""/>
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Ledger Name</label>
                                            <select name="ld_name"
                                                    class="form-control ledger_name"
                                                    id="ld_name">

                                                <option value="">Please Select</option>
                                                <?php foreach ($ledegrs['group'] as $groups) {
                                                    foreach ($groups['ledger'] as $ledger) {
                                                        ?>
                                                        <option value="<?= $ledger['ld_id']; ?>"><?= $ledger['ld_name']; ?></option>
                                                    <?php }

                                                } ?>
                                            </select>
                                            <input type="hidden" id="pr_name" name="pr_name" class="pr_name" value="">
                                            <input type="hidden" id="date1" name="date1" class="date1" value="">
                                            <input type="hidden" id="date2" name="date2" class="date2" value="">


                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label></label><br>
                                            <button type="submit" id="add_product" class="btn btn-primary btn_search"
                                                    style="margin-top: 5px;">Search
                                            </button>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <br><br>



                                <div class="x_content">
                        <div class="">
                            <div class="row">
                                <div class="col-sm-offset-7 col-sm-3">
                                    <label class="pull-right">Search:</label>
                                </div>
                                <div class="col-sm-2">
                                    <input type="text" class="form-control search" name="search" id="search" placeholder="">
                                </div>
                            </div><br>
                            <div class="box-body">
                                <table id="purchase_table" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr class="tablbg">

                                    <th>Date</th>
                                    <th>Number</th>
                                    <th>Type</th>
                                    <th>Dr Amount</th>
                                    <th>Cr Amount</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                  

                                    </tbody>
                                    <tfoot>
                                        <td colspan="5">
                                            <div class="pull-right" id="pagination"></div>
                                        </td>
                                    </tfoot>
                                </table>
                            </div>

                        </div>

                        <div class="col-md-12 text-center">
                            <ul class="pagination pagination-lg pager" id="myPager"></ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>


<?php echo $footer; ?>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/dataTables.buttons.min.js" type="text/javascript"></script>

<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script type="text/javascript" src="<?= base_url() ?>assets/admin/js/moment2.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/css/bootstrap-datetimepicker.min.css"/>
<script src="<?php echo base_url(); ?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>

<script type="text/javascript">
    jQuery(document).ready(function () {
        // binds form submission and fields to the validation engine
//        jQuery("#journal_entry_form").validationEngine();
        $('.ledger_name').SumoSelect({okCancelInMulti: true, selectAll: true, search: true});


    });

</script>
<script type="text/javascript">
    $(function () {
var fs=$('#fn_st_date').val();
//alert(fs);
        $('#from_date').datetimepicker({
           //minDate:fs,
             // startDate: '2016/08/19 10:00',
            //format: 'DD-MM-YYYY'
        });
var fe=$('#fn_e_date').val();

         $(' #to_date').datetimepicker({
           // maxDate:fe,
             // startDate: '2016/08/19 10:00',
            //format: 'DD-MM-YYYY'
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {

//        $('#ld_name').select2();


        var t;
        $('body').delegate('#add_product', 'click', function (e) {
            clearTimeout(t);
            // $('#add_product').click(function(e){
            e.preventDefault();


          
load_demo();
        });


   







function load_demo(index) {

     var base_url = "<?php echo base_url(); ?>";
 var from = $('#ledger_form').find('#from_date').val();

            var to = $('#ledger_form').find('#to_date').val();


             var ledger = $('#ledger_form').find('#ld_name').val();
                var ledger_name = $('#ledger_form').find('#ld_name  option:selected').text();

index = index || 0;
                        var search = $('#search').val();

                if (ledger != '' && (to != '' || from != '')) 
                {

                    var data = $('#ledger_form').serializeArray();
                    $('.body_blur').show();
                    $.post(base_url + "ledger_statement_by_id/"+index, { ajax: true,search:search,ld_name:ledger,from_date:from,to_date:to}, function (data) {
                        $('.body_blur').hide();
 $('tbody').html("");
                            $('.body_blur').hide();
                            var tr = '';


                        if (data.status) {

                            var search11=data.search;
                             var pagination=data.pagination;
                            var data = data.data;


                            $('tfoot').html('');
                            var datas = data.ledger;

                            

                            var closing_balce = data.closing_bal;
                            if(closing_balce > 0)
                            {
                                closing_balce = 'Dr '+closing_balce;
                            }else if(closing_balce < 0){
                                closing_balce = 'Cr '+Math.abs(closing_balce)
                                ;
                            }else{
                                closing_balce =0;
                            }
                            var txtbalance = 'Balance';
                           // var table = $('#mytable').DataTable();

                            $('#ledger_form').find('.pr_name').val(ledger_name);
                            $('#ledger_form').find('.date1').val(from);
                            $('#ledger_form').find('.date2').val(to);
                            var dr_total = 0;
                            var cr_total = 0;
                            var tr = '';
                            for (var i = 0; i < datas.length; i++) {
                                var date = datas[i].date;
                                dr_total += parseFloat(datas[i].dr_amount);
                                cr_total += parseFloat(datas[i].cr_amount);
                                var dateAr = date.split('-');
                                var newDate = dateAr[2] + '-' + dateAr[1] + '-' + dateAr[0].slice(-4);


                               
                                  tr +=  '<tr>' +
                                    '<td>' + newDate + '</td>' +
                                    '<td>' + datas[i].number + '</td>' +
                                    '<td>' + datas[i].en_type + '</td>' +
                                    '<td>' + datas[i].dr_amount + '</td>' +
                                    '<td>' + datas[i].cr_amount + '</td>' +
                                    '</tr>';
                              


                            }

                            $('tbody').html(tr);
                                $('#search').val(search11);
                                // pagination
                                $('#pagination').html(pagination);

                           /*tr =  '<tr style="font-weight: 700;">' +
                               '<td>Current Balance</td>' +
                               '<td colspan="3"></td>' +
                               '<td>' + closing_balce + '</td>' +
                               '</tr>';*/
                                tr =  '<tr style="font-weight: 700;">' +
                               '<td>Current Balance</td>' +
                               '<td colspan="2"></td>' +
                               '<td>' + dr_total + '</td>' +
                               '<td>' + cr_total + '</td>' +
                               '</tr>';

                            $('tfoot').append(tr);
                            if (data.open_bal != null||data.open_bal != undefined) {

                                var op=
                                    '<tr><td colspan="4">Opening Balance</td><td style="font-weight:bold;">' + data.open_bal + '</td></tr>';
                                                           $('tbody').append(op);



                            } else {




                            }



                        }
                        else {

                            $('#ledger_form').find('.pr_name').val(ledger_name);

                            tr += '<tr>'+
                                        '<td colspan="4" style="text-align:center">No Data Found</td>'+
                                        '</tr>';
                                $('tbody').html(tr);
                        }


                    }, 'json');
                } else {
                    noty({text: "Please Select Ledger and any date", type: 'error', layout: 'top', timeout: 3000});
                }


}


















                    //pagination update
                    $('#pagination').on('click', '.page_test a', function(e) {
                        e.preventDefault();
                        //grab the last paramter from url
                        var link = $(this).attr("href").split(/\//g).pop();
                        load_demo(link);
                        return false;
                    });
                    $("#search").keyup(function(){
                        load_demo();
                    });
                });


























</script>


</body>
</html>