<?php echo $default_assets; ?>
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Transaction Report - By &nbsp;&nbsp;&nbsp;<h3 id="byy" style="font-size: large;margin-top: 15px;text-transform: capitalize;"></h3></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="box-body">
                                <div class="row">
                                        <div class="col-sm-2">
                                            <input type="text" name="from" class="form-control" id="from">
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" name="to" class="form-control" id="to">
                                        </div>
                                        <div class="col-sm-2">
                                            <button class="btn btn-primary" id="btn_go">Go</button>
                                        </div>
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control search" name="search" id="search" placeholder="">
                                        </div>
                                        <div class="col-sm-3">
                                            <select id="by" class="form-control by" name="by">
                                                <option value="">--Select Any--</option>
                                                <option value="admin">Admin</option>
                                                <option value="channel_partner">Channel Partner</option>
                                            </select>
                                        </div>
                                </div><br>
                                <table id="purchase_table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="tablbg">
                                            <th style="width: 45px">No</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Amount</th>
                                            <th>Date</th>
                                            <th>Description</th>
                                            <th>Payment Method</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                    <tfoot>
                                        <td colspan="7">
                                            <div class="pull-right" id="pagination"></div>
                                            <div class="pull-left"><button type="button" class="btn btn-sm btn-primary btn_print">PRINT</button></div>
                                        </td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div id="report_left_inner" class="report_left_inner" style="display: none">
                    <table id="purchase_table" class="table table-bordered table-striped" width="100%">
                        <thead>
                            <tr class="filters">
                                <th colspan="7">JAAZZO<br><p>Transaction Report&nbsp;&nbsp;&nbsp;<h3 id="by1" style="font-size: large;margin-top: 5px;text-transform: capitalize;"></h3></p></th>
                            </tr>
                            <tr class="filters">
                                <th style="width: 45px">No</th>
                                <th>From</th>
                                <th>To</th>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Payment Method</th>
                            </tr>
                        </thead>
                        <tbody class="tbodyy">
                      

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
<?php echo $footer; ?>
<script src="<?php echo base_url(); ?>assets/admin/js/paging.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/admin/js/moment2.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/css/bootstrap-datetimepicker.min.css" />
<script type="text/javascript">
    $(function () {
        $('#from').datetimepicker(
            {
                format: 'DD/MM/YYYY h:m a'
            }
        );
        $('#to').datetimepicker(
            {
                format: 'DD/MM/YYYY h:m a'
            }
        );
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        const toTitleCase = (phrase) => {
          return phrase
            .split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1))
            .join(' ');
        };
        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            var by = $('#by').val();

            var from = $('#from').val();
            var to = $('#to').val();
            by = by || 'admin';
            if(search){
                $('.body_blur').hide();
            }else{
                $('.body_blur').show();
            }
            $.post(base_url + "transaction_report/" + index, { ajax: true,search:search,by:by,from:from,to:to}, function(data) {
                console.log(data);
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.status){

                    var tr = '';
                    var data1 = data.data;
                    for(var i = 0; i< data1.length; i++){
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                        if(data1[i].mode=='cheque'){
                            var detail = ' Payment Via : Cheque'+'<br>';
                            detail +='Name of the Bank :'+data1[i].bank_name+'<br>';
                            detail +='Cheque No :'+data1[i].cheque_number+'<br>';
                            detail +='Cheque Date :'+data1[i].cdate;
                        }else{
                           var detail = ' Payment Via : '+data1[i].mode
                           .charAt(0).toUpperCase() + data1[i].mode.slice(1);
                        }
                        var dtyp =data1[i].typ;
                        tr += '<tr>'+
                            '<td>'+sl_no+'</td>'+
                            '<td>'+data1[i].creator+'</td>'+
                            '<td>'+data1[i].tr_to+'('+toTitleCase(dtyp.replace(/_/g, ' '))+')'+'</td>'+
                            '<td>'+data1[i].transaction_amount+'</td>'+
                            '<td>'+data1[i].transaction_date+'</td>'+
                            '<td>'+data1[i].narration+'</td>'+
                            '<td>'+detail+'</td>'+
                            '</tr>';
                    }
                    $('tbody').html(tr);
                    $('#search').val(data.search);
                    $('#by').val(data.by);
                    if(by=='channel_partner'){
                        var byy = 'Channel Partner';
                    }else{
                        var byy = 'Jaazzo';
                    }
                    $('#byy').html(byy);
                    // pagination
                    $('#pagination').html(data.pagination);$('#pagination').show();$('#pagination').parent().parent().show();

                }else{
                    $('tbody').html('<tr><td colspan="7">No Data Found !!</td></tr>');
                    $('#byy').html(byy);
                    // pagination
                    $('#pagination').hide();$('#pagination').parent().parent().hide();
                }
            }, "json");
        }
        //calling the function
        load_demo();
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
        $("#by").change(function(){
            load_demo();
        });
        $("#btn_go").click(function(){
            load_demo();
        });
    });

    $(document).on('click','.btn_print',function(){
        var base_url = "<?php echo base_url(); ?>";
        var search = $('#search').val();
        var by = $('#by').val();
        var from = $('#from').val();
        var to = $('#to').val();
        $.post(base_url + "admin/Report/print_transaction_report", {search:search,by:by,from:from,to:to}, function(data) {
            if(data.status){
                var tr = '';
                var data1 = data.data;
                for(var i = 0; i< data1.length; i++){
                    var sl_no=i + 1;
                    if(data1[i].mode=='cheque'){
                        var detail = ' Payment Via : Cheque'+'<br>';
                        detail +='Name of the Bank :'+data1[i].bank_name+'<br>';
                        detail +='Cheque No :'+data1[i].cheque_number+'<br>';
                        detail +='Cheque Date :'+data1[i].cdate;
                    }else{
                       var detail = ' Payment Via : '+data1[i].mode
                       .charAt(0).toUpperCase() + data1[i].mode.slice(1);
                    }
                    var dtyp =data1[i].typ;
                    tr += '<tr>'+
                        '<td>'+sl_no+'</td>'+
                        '<td>'+data1[i].creator+'</td>'+
                        '<td>'+data1[i].tr_to+'('+toTitleCase(dtyp.replace(/_/g, ' '))+')'+'</td>'+
                        '<td>'+data1[i].transaction_amount+'</td>'+
                        '<td>'+data1[i].transaction_date+'</td>'+
                        '<td>'+data1[i].narration+'</td>'+
                        '<td>'+detail+'</td>'+
                        '</tr>';
                }
                $('.tbodyy').html(tr);
                if(by=='channel_partner'){
                    var byy = 'Channel Partner';
                }else{
                    var byy = 'Jaazzo';
                }
                $('#by1').html('By '+byy);
                var tt= $('.report_left_inner').html();
                PrintDiv(tt);
            }
        },'json');
    });
</script>
</body>
</html>

























