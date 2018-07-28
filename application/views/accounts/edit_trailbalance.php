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
                        <h2>Trial Balance<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">

                           
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>





                    <div class="x_content">
                        <form role="form" id="trial_bal_search_form" method="post" name="trial_bal_search_form">
                            <div class="box-body">
                                <div class="row">
 <?php        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $from11 = $finacial['start_year']; 
$from=convert_ui_date($from11);

        ?>

                                  <input type='hidden' class="form-control" style="width: 144%;" id="fn_st_date"
                                                   value="<?php echo $from11; ?>" name="fn_st_date" />

                                    <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                        <label >From Date</label>
                                        <div class='input-group date' id='datetimepicker3'>
                                            <input type='text' class="form-control "  style="width: 144%" id="from_date" value="<?php echo date("d-m-Y"); ?>" name="from_date" required=""/>

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
                                        <label >To Date</label>
                                        <div class='input-group date' id='datetimepicker2'>
                                            <input type='text' class="form-control "  style="width: 144%"  id="to_date" value="<?php echo date("d-m-Y"); ?>" name="to_date" required=""/>

                                        </div>

                                        <input type="hidden" id="date1" name="date1" class="date1"/>
                                        <input type="hidden" id="date2" name="date2" class="date2"/>


                                    </div>

                                    <div class="col-md-3"> <div class="form-group">
                                            <label ></label><br>
                                            <button type="button" class="btn btn-primary btn_search" style="margin-top: 5px;">Search</button>
                                        </div></div>
                                </div></div>
                        </form>



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

                                    <th>Ledger</th>
                                    <th>O/p Balance</th>

                                    <th>Dr Total</th>
                                    <th>Cr Total</th>
                                    <th>C/l Balance</th>
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
<!-- 
                        <div class="tbleovrscroll">
                            <table id="mytable" class="display table-bordered table-striped" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                    <th>Ledger</th>
                                    <th>O/p Balance</th>

                                    <th>Dr Total</th>
                                    <th>Cr Total</th>
                                    <th>C/l Balance</th>
                                </tr>
                                </thead>


                                <tbody class="tbody" style=" height:300px;overflow:scroll">
                                <?php
                                $total_dr = 0;
                                $total_cr = 0;
                                foreach ($ledger_details['ledger'] as $key => $ledger) { ?>
                                    <?php
                                    $total_dr += $ledger['ld_dr_total'];

                                    $total_cr += $ledger['ld_cr_total']; ?>
                                    <tr>
                                        <td><?= $ledger['name'];?></td>
                                        <td><?= $ledger['ld_open_bal'];?></td>
                                        <?php if($ledger['ld_close_bal']> 0)
                                        {
                                            $closing = 'Dr '.$ledger['ld_close_bal'];
                                        }
                                        else
                                        {
                                            $closing = 'Cr '.abs($ledger['ld_close_bal']);
                                        } ?>
                                        <td><?= $ledger['ld_dr_total'];?></td>
                                        <td><?= $ledger['ld_cr_total'];?></td>
                                        <td><?= $closing;?></td>
                                    </tr>

                                    <?php
                                }
                                ?>
                                </tbody>

                                <tr>
                                    <td><strong>Total</strong></td>
                                    <td></td>
                                    <td class="tbody1"><strong><?= 'Dr '. $total_dr;?></strong></td>
                                    <td class="tbody2"><strong><?= 'Cr '. $total_cr;?></strong></td>
                                    <td></td>
                                </tr>
                            </table>
                        </div> -->
                        <!-- <div class="col-md-12 text-center">
                            <ul class="pagination pagination-lg pager" id="myPager"></ul>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>






<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/buttons.print.min.js" type="text/javascript"></script>

<script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>
<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script type="text/javascript" src="<?= base_url() ?>assets/admin/js/moment2.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/css/bootstrap-datetimepicker.min.css"/>
<!-- <script type="text/javascript">
    $(function () {
        $('#from_date, #to_date').datetimepicker({
            format: 'DD-MM-YYYY'
        });
    });
</script> -->

<script type="text/javascript">
    $(function () {
var fs=$('#fn_st_date').val();
        $('#from_date').datetimepicker({
            minDate:fs,
             // startDate: '2016/08/19 10:00',
            format: 'DD-MM-YYYY'
        });
var fe=$('#fn_e_date').val();

         $(' #to_date').datetimepicker({
            maxDate:fe,
             // startDate: '2016/08/19 10:00',
            format: 'DD-MM-YYYY'
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){




            var base_url = "<?php echo base_url(); ?>";
                    function load_demo1(index) {
                        index = index || 0;
                        var search = $('#search').val();
                        $.post(base_url + "trial_balance/"+index, { ajax: true,search:search}, function (data) {
 $('tbody').html("");
                            $('.body_blur').hide();
                            var tr = '';


                        if (data.status) {


                            var search11=data.search;
                             var pagination=data.pagination;

                             //console.log(pagination);


var grand_det=data.grand_tot;
var grand_ledg=grand_det.ledger;

 var dr_total_n = 0;
                            var cr_total_n = 0;
                           
                         var dr_sum_n = 0;
                        var cr_sum_n = 0;

for(var i=0; i<grand_ledg.length; i++){

   // console.log(grand_ledg.length);
    
                           var dr_total_n = grand_ledg[i].ld_dr_total== null ? 0: grand_ledg[i].ld_dr_total;
                            var cr_total_n = grand_ledg[i].ld_cr_total== null ?0: grand_ledg[i].ld_cr_total;

// dr_sum_n=parseFloat(dr_sum_n)+parseFloat(dr_total_n);

                     dr_sum_n += Number(dr_total_n);

                            cr_sum_n += Number(cr_total_n);

                           

}
//console.log(dr_sum_n);






                            var data = data.data;


                           // $('tfoot').html('');
                            var datas = data.ledger;
// console.log(datas);
                            

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

                            // $('#ledger_form').find('.pr_name').val(ledger_name);
                           
                            var dr_total = 0;
                            var cr_total = 0;
                            var tr = '';
                         var dr_sum = 0;
                        var cr_sum = 0;



     for(var i=0; i<datas.length; i++){






        var cur_index=parseInt(index);
                                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);


                            if(datas[i].ld_close_bal> 0){
                                var closing =  'Dr '+datas[i].ld_close_bal;
                            }else{
                                var closing =  'Cr '+Math.abs(datas[i].ld_close_bal);
                            }




                            var dr_tot = datas[i].ld_dr_total== null ? '': datas[i].ld_dr_total;
                            var cr_tot = datas[i].ld_cr_total== null ? '': datas[i].ld_cr_total;
                            dr_sum += Number(dr_tot);
                            cr_sum += Number(cr_tot);



                            tr +=
                                '<tr>' +
                                '<td>'+datas[i].name+'</td>'+
                                '<td>'+datas[i].ld_open_bal+'</td>'+


                                '<td>'+dr_tot+'</td>'+
                                '<td>'+cr_tot+'</td>'+
                                '<td>'+closing+'</td>'+

                                '</tr>'
                            
                        }




                            $('tbody').html(tr);
                                

// console.log(pagination);
                        
                               var tr11 =  '<tr style="font-weight: 700;">' +
                               '<td>Total</td>' +
                               '<td colspan="1"></td>' +
                               '<td>' + dr_sum_n + '</td>' +
                               '<td>' + cr_sum_n + '</td>' +
                               '<td></td>'+
                               '</tr>';
$('tbody').append(tr11);
                           // $('tfoot').append(tr);
                         
$('#search').val(search11);
                                // pagination

                                
                                $('#pagination').html(pagination);


                        }
                        else {

                            // $('#ledger_form').find('.pr_name').val(ledger_name);

                            tr += '<tr>'+
                                        '<td colspan="4" style="text-align:center">No Data Found</td>'+
                                        '</tr>';
                                $('tbody').html(tr);
                        }


                    }, 'json');
                    }
                    //calling the function
                    load_demo1();
                    //pagination update
                    $('#pagination').on('click', '.page_test11 a', function(e) {
                        e.preventDefault();
                        //grab the last paramter from url
                        var link = $(this).attr("href").split(/\//g).pop();
                        load_demo1(link);
                        return false;
                    });
                    $("#search").keyup(function(){
                        load_demo1();
                    });
                // });



































        $('.btn_search').click(function(e){
            e.preventDefault();

            load_demo();
            // var from = $('#trial_bal_search_form').find('#from_date').val();
            // var to = $('#trial_bal_search_form').find('#to_date').val();

            // if(to != '' || from != ''){


            //     var table1 = $('#mytable').DataTable();

            //     table1
            //         .clear()
            //         .draw();
            //     var data = $('#trial_bal_search_form').serializeArray();
            //     $('.body_blur').show();
            //     $.post('<?= base_url();?>accounts/accounts/get_trialbalance_by_date', data, function(data){
            //         $('.body_blur').hide();
            //         if(data.status){

            //             var data = data.data;
            //             var datas = data.ledger;
            //             var tr = '';
            //             var tr1 = '';
            //             var tr2 = '';
            //             var tot=0;
            //             var tot2=0;
            //             var dr_sum = 0;
            //             var cr_sum = 0;
            //             for(var i=0; i<datas.length; i++){
            //                 if(datas[i].ld_close_bal> 0){
            //                     var closing =  'Dr '+datas[i].ld_close_bal;
            //                 }else{
            //                     var closing =  'Cr '+Math.abs(datas[i].ld_close_bal);
            //                 }



            //                 var table = $('#mytable').DataTable( );

            //                 var dr_tot = datas[i].ld_dr_total== null ? '': datas[i].ld_dr_total;
            //                 var cr_tot = datas[i].ld_cr_total== null ? '': datas[i].ld_cr_total;
            //                 dr_sum += Number(dr_tot);
            //                 cr_sum += Number(cr_tot);

            //                 table.row.add($(
            //                     '<tr>' +
            //                     '<td>'+datas[i].name+'</td>'+
            //                     '<td>'+datas[i].ld_open_bal+'</td>'+


            //                     '<td>'+dr_tot+'</td>'+
            //                     '<td>'+cr_tot+'</td>'+
            //                     '<td>'+closing+'</td>'+

            //                     '</tr>'
            //                 )).draw(false);
            //             }


            //             tr1 +=  '<td><strong>'+'Dr ' + dr_sum+'</strong></td>';
            //             tr2 +=        '<td><strong>'+'Cr '+cr_sum+'</strong></td>';


            //             $('.tbody1').html(tr1);
            //             $('.tbody2').html(tr2);

            //         }


            //         $('#trial_bal_search_form').find('.date1').val(from);
            //         $('#trial_bal_search_form').find('.date2').val(to);
            //     },'json');
            // } else{
            //     noty({text:"Please Select any date",type: 'error',layout: 'top', timeout: 3000});
            // }


        });



function load_demo(index) {

     var base_url = "<?php echo base_url(); ?>";
  var from = $('#trial_bal_search_form').find('#from_date').val();
            var to = $('#trial_bal_search_form').find('#to_date').val();


             // var ledger = $('#ledger_form').find('#ld_name').val();
                // var ledger_name = $('#ledger_form').find('#ld_name  option:selected').text();

index = index || 0;
                        var search = $('#search').val();

                if (to != '' || from != '') 
                {

                    // var data = $('#ledger_form').serializeArray();
                    $('.body_blur').show();
                    $.post(base_url + "get_trialbalance_by_date/"+index, { ajax: true,search:search,from_date:from,to_date:to}, function (data) {
 $('tbody').html("");
                            $('.body_blur').hide();
                            var tr = '';


                        if (data.status) {


                            var search11=data.search;
                             var pagination=data.pagination;
                            var data = data.data;


                            $('tfoot').html('');
                            var datas = data.ledger;
console.log(datas);
                            

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

                            // $('#ledger_form').find('.pr_name').val(ledger_name);
                            $('#ledger_form').find('.date1').val(from);
                            $('#ledger_form').find('.date2').val(to);
                            var dr_total = 0;
                            var cr_total = 0;
                            var tr = '';
                         var dr_sum = 0;
                        var cr_sum = 0;



     for(var i=0; i<datas.length; i++){
                            if(datas[i].ld_close_bal> 0){
                                var closing =  'Dr '+datas[i].ld_close_bal;
                            }else{
                                var closing =  'Cr '+Math.abs(datas[i].ld_close_bal);
                            }




                            var dr_tot = datas[i].ld_dr_total== null ? '': datas[i].ld_dr_total;
                            var cr_tot = datas[i].ld_cr_total== null ? '': datas[i].ld_cr_total;
                            dr_sum += Number(dr_tot);
                            cr_sum += Number(cr_tot);



                            tr +=
                                '<tr>' +
                                '<td>'+datas[i].name+'</td>'+
                                '<td>'+datas[i].ld_open_bal+'</td>'+


                                '<td>'+dr_tot+'</td>'+
                                '<td>'+cr_tot+'</td>'+
                                '<td>'+closing+'</td>'+

                                '</tr>'
                            
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
                               '<td>Total</td>' +
                               '<td colspan="1"></td>' +
                               '<td>' + dr_sum + '</td>' +
                               '<td>' + cr_sum + '</td>' +
                               '<td></td>'+
                               '</tr>';

                            $('tfoot').append(tr);
                            // if (data.open_bal !== null) {


                            //     var op=
                            //         '<tr><td colspan="4">Opening Balance</td><td style="font-weight:bold;">' + data.open_bal + '</td></tr>';
                            //                                $('tbody').append(op);



                            // } else {

                            // }



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
                // });









    });
</script>


<script>
    function nWin() {

        document.getElementById('mytable_length').style.display = 'none';
        document.getElementById('mytable_filter').style.display = 'none';
        document.getElementById('mytable_paginate').style.display = 'none';
        document.getElementById('mytable_info').style.display = 'none';

        document.getElementById("txtlft2").style.textAlign = "Left";


        var divToPrint=document.getElementById("book");
        newWin= window.open("");
        newWin.document.write(divToPrint.outerHTML);
        newWin.print();
        newWin.close();


    }

    $(function() {
        $("a#print").click(nWin);
    });</script>


<!-- <script>

    var table = $('#mytable').DataTable( {
        dom: 'Bfrtip',

        buttons: [

            { extend: 'print',

                title: function() {
                    return 'Trial Balance   ' + $('#date1').val() +'  -  '+  $('#date2').val()
                }



            },
        ]
    } );

</script> -->


</body>
</html>