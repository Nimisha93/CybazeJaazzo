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
                        <h2>Purchase Report - By Channel Partners&nbsp;&nbsp;&nbsp;<h3 id="byy" style="font-size: large;margin-top: 5px;text-transform: capitalize;"></h3></h2>
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
                                      <input type="text" id="from" name="from" class="fromdate form-control">
                                    </div>
                                    <div class="col-sm-2">
                                       <input type="text"  id="to" name="to" class="todate form-control" />
                                    </div> 
                                    <div class="col-sm-1">
                                        <button class="btn btn-info" id="btn_search">Go</button>
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" name="by" id="by">
                                            <option value="">--Select any--</option>
                                            <?php foreach ($channel_partner as $key => $partner) { ?>
                                            <option value="<?= $partner['id'];?>"><?= $partner['name'];?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <label class="pull-right">Search:</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control search" name="search" id="search" placeholder="">
                                    </div>
                                </div><br>
                                <table id="purchase_table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="tablbg">
                                            <th style="width: 45px">No</th>
                                            <th>Name of the Shop</th>
                                            <th>Purchase By</th>
                                            <th>Bill Total</th>
                                            <th>Rewards Gain</th>
                                            <th>Purchased On</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                    <tfoot>
                                        <td colspan="6">
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
                                <th colspan="6">JAAZZO<br><p>Purchase Report&nbsp;By Channel Partners</p></th>
                            </tr>
                            <tr class="filters">
                                <th>No</th>
                                <th>Name of the Shop</th>
                                <th>Purchase By</th>
                                <th>Bill Total</th>
                                <th>Rewards Gain</th>
                                <th>Purchased On</th>
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
<script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            var from = $('.fromdate').val();
            var to = $('.todate').val();
            var by = $('#by').val();
            if(search){
                $('.body_blur').hide();
            }else{
                $('.body_blur').show();
            }
            $.post(base_url + "purchase_by_cp/" + index, { ajax: true,search:search,from:from,to:to,by:by}, function(data) {
                console.log(data);
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.status){

                    var tr = '';
                    var data1 = data.data;
                    for(var i = 0; i< data1.length; i++){
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                        tr += '<tr>'+
                            '<td>'+sl_no+'</td>'+
                            '<td>'+data1[i].name+'</td>'+
                            '<td>'+data1[i].purchase_by+'</td>'+
                            '<td>'+data1[i].bill_total+'</td>'+
                            '<td>'+data1[i].wallet_total+'</td>'+
                            '<td>'+data1[i].purchsed_on+'</td>'+
                            '</tr>';
                    }
                    $('tbody').html(tr);
                    $('#search').val(data.search);
                    $('#by').val(by);
                    // pagination
                    $('#pagination').html(data.pagination);
                    $('.btn_print').show();
                }else{
                    var tr='';
                    tr += '<tr>'+
                            '<td colspan="6">No Data Found !!</td>'+
                            '</tr>';
                    $('tbody').html(tr);$('#pagination').html("");
                    $('.btn_print').hide();
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
        $(document).on('click', '#btn_search', function () {
            load_demo();
        });
        $(document).on('change', '#by', function () {
            load_demo();
        });
    });

    $(document).on('click','.btn_print',function(){
        var base_url = "<?php echo base_url(); ?>";
        var search = $('#search').val();
        var from = $('.fromdate').val();
        var to = $('.todate').val();
        $.post(base_url + "admin/Report/print_purcase_report_bycp", {search:search,from:from,to:to}, function(data) {
            if(data.status){
                $('.tbodyy').html("");
                var tr = '';
                    var data1 = data.data;
                    // var dat=data1.data;
                    for(var i = 0; i< data1.length; i++){
                        var sl_no=(i + 1);
                        tr += '<tr>'+
                            '<td>'+sl_no+'</td>'+
                            '<td>'+data1[i].name+'</td>'+
                            '<td>'+data1[i].purchase_by+'</td>'+
                            '<td>'+data1[i].bill_total+'</td>'+
                            '<td>'+data1[i].wallet_total+'</td>'+
                            '<td>'+data1[i].purchsed_on+'</td>'+
                            '</tr>';
                    }
                $('.tbodyy').html(tr);
                var tt= $('.report_left_inner').html();
                PrintDiv(tt);
            }
        },'json');
    });
</script>
<script type="text/javascript" src="<?= base_url() ?>assets/admin/js/moment2.js"></script>
<script type="text/javascript" src="<?= base_url() ?>assets/admin/js/bootstrap-datetimepicker.min.js"></script>
<link rel="stylesheet" href="<?= base_url() ?>assets/admin/css/bootstrap-datetimepicker.min.css" />
<script type="text/javascript">
    $(function () {
        $('.fromdate').datetimepicker(
            {
                format: 'DD-MM-YYYY'
            }
        );
        $('.todate').datetimepicker(
            {
                format: 'DD-MM-YYYY'
            }
        );
    });
</script>
</body>
</html>





























az