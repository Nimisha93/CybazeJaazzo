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
                        <h2>Designation Report<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
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
                                            <th style="width:40px">Slno</th>
                                            <th>Designation</th>
                                            <th>Description</th>
                                            <th>Sort Order</th>
                                            
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                  

                                    </tbody>
                                </table>
                                <tfoot>
                                    <td colspan="6">
                                        <div class="pull-right" id="pagination"></div>
                                        <div class="pull-left"><button type="button" class="btn btn-sm btn-primary btn_print">PRINT</button></div>
                                    </td>
                                </tfoot>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div id="report_left_inner" class="report_left_inner" style="display: none">
                <table id="purchase_table" class="table table-bordered table-striped" width="100%">
                    <thead>
                        <tr class="filters">
                            <th colspan="6">JAAZZO<br><p>Designation  Report</p></th>
                        </tr>
                        <tr class="filters">
                            <th>No</th>
                            <th>Designation</th>
                            <th>Description</th>
                            <th>Sort_Order</th>
                            
                            <th>Date </th>
                        </tr>
                    </thead>
                    <tbody class="tbodyy">
                  

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<?php echo $footer; ?>
<script src="<?php echo base_url(); ?>assets/admin/js/paging.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            if(search){
                $('.body_blur').hide();
            }else{
                $('.body_blur').show();
            }
            $.post(base_url + "designation_report/" + index, { ajax: true,search:search}, function(data) {
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
                            '<td>'+data1[i].designation+'</td>'+
                            '<td>'+data1[i].description+'</td>'+
                            '<td>'+data1[i].sort_order+'</td>'+
                            
                            '<td>'+data1[i].date_time+'</td>'+
                            '</tr>';
                    }
                    $('tbody').html(tr);
                    $('#search').val(data.search);
                    // pagination
                    $('#pagination').html(data.pagination);

                }else{
                    var tr='';
                    tr += '<tr>'+
                            '<td colspan="6">No Data Found</td>'+
                            '</tr>';
                    $('tbody').html(tr);$('#pagination').hide();$('.btn_print').hide();
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
    });

    $(document).on('click','.btn_print',function(){
        var base_url = "<?php echo base_url(); ?>";
        var search = $('#search').val();
        $.post(base_url + "admin/Report/print_designation_report", {search:search}, function(data) {
            if(data.status){

              
                var tr = '';
                    var data1 = data.data;
                    // var dat=data1.data;
                    for(var i = 0; i< data1.length; i++){
                        var sl_no=(i + 1);
                        tr += '<tr>'+
                            '<td>'+sl_no+'</td>'+
                            '<td>'+data1[i].designation+'</td>'+
                            '<td>'+data1[i].description+'</td>'+
                            '<td>'+data1[i].sort_order+'</td>'+
                            '<td>'+data1[i].groupname+'</td>'+
                            '<td>'+data1[i].date_time+'</td>'+
                            '</tr>';
                    }
                $('.tbodyy').html(tr);
                var tt= $('.report_left_inner').html();
                PrintDiv(tt);
            }
        },'json');
    });
</script>
          </div>
        </div>
    </div>
 </div>
</body>
</html>


