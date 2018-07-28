<?php echo $default_assets; ?>
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
            </div>
            <div class="title_right">
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Channel Partner  Report<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="box-body">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="pull-right">Search:</label>
                                    </div>
                                    <div class="col-sm-2">
                                        <input type="text" class="form-control search" name="search" id="search" placeholder="">
                                    </div>
                                    <div class="col-sm-2">
                                        <label>Channel Partner Type</label>
                                    </div>
                                    <div class="col-sm-4">
                                        <select id="channel_type" class="form-control search-box-open-up search-box-sel-all channel_type" name="channel_type">
                                        </select>
                                    </div>
                                </div><br>
                                <table id="purchase_table" class="table table-bordered table-striped">
                                    <thead>
                                     <tr class="tablbg">
                                        <th style="width: 35px">SlNo.</th>
                                        <th>Name</th>
                                        <th>Contact Name</th>
                                        <th style="width: 100px">Brand Image</th>
                                        <th>Phone</th>
                                        <th>Alternative Phone</th>
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
                                <th colspan="6" id="tit">JAAZZO<br><p>Channel Partner Report</p></th>
                            </tr>
                            <tr class="filters">
                                <th>SI No.</th>
                                <th>Name</th>
                                <th>Contact Name</th>
                                <th style="width: 100px">Brand Image</th>
                                <th>Phone</th>
                                <th>Alternative Phone</th>
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
            if(search){
                $('.body_blur').hide();
            }else{
                $('.body_blur').show();
            }
            var type = $('#channel_type').val();
            $.post(base_url + "channel_partner_report/" + index, { ajax: true,search:search,type:type}, function(data) {
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
                            '<td>'+data1[i].cname+'</td>'+
                            '<td><img src='+base_url+data1[i].brand_image+' style="width: 70px;height: 70px;"></td>'+
                            '<td>'+data1[i].phone+'</td>'+
                            '<td>'+data1[i].phone2+'</td>'+
                            '</tr>';
                    }
                    $('tbody').html(tr);
                    $('#search').val(data.search);
                    $('#pagination').html(data.pagination);
                    $('#channel_type').html('');
                    var category = data.category.type;
                    var subcategory = data.subcategory.type;
                    var opt='';
                    for(var j = 0; j< category.length; j++){
                        opt += '<optgroup label="'+category[j].title+'">';
                        var pid=category[j].id;
                        for(var k = 0; k< subcategory.length; k++){
                          if(subcategory[k].parent==pid){
                            opt += '<option class="subc" value="'+subcategory[k].id+'">'+subcategory[k].title+'</option>';
                          }  
                        }
                        opt += '</optgroup>';
                    }
                    $('#channel_type').append(opt);
                    $('#channel_type').val(type);
                }else{
                    tr += '<tr>'+
                            '<td colspan="6">No Data Found</td>'+
                            '</tr>';
                    $('tbody').html(tr);$('#pagination').parent().parent().hide();$('.btn_print').hide();
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
        $(document).on('change','#channel_type',function(){
            load_demo();
        });
    });

    $(document).on('click','.btn_print',function(){
        var base_url = "<?php echo base_url(); ?>";
        var search = $('#search').val();var type = $('#channel_type').val();
        $.post(base_url + "admin/Report/print_channel_partner_report", {search:search,type:type}, function(data) {
            if(data.status){

              
                var tr = '';
                    var data1 = data.data;
                    // var dat=data1.data;
                    for(var i = 0; i< data1.length; i++){
                        var sl_no=(i + 1);
                        tr += '<tr>'+
                            '<td>'+sl_no+'</td>'+
                            '<td>'+data1[i].name+'</td>'+
                            '<td>'+data1[i].cname+'</td>'+
                            '<td><img src='+base_url+data1[i].brand_image+' style="width: 70px;height: 70px;"></td>'+
                            '<td>'+data1[i].phone+'</td>'+
                            '<td>'+data1[i].phone2+'</td>'+
                            '</tr>';
                    }
                $('.tbodyy').html(tr);
                var ttyp=($("#channel_type option:selected").text())?('-'+$("#channel_type option:selected").text()):'';
                $('#tit').html('JAAZZO<br><p>Channel Partner Report'+ttyp);
                var tt= $('.report_left_inner').html();
                PrintDiv(tt);
            }
        },'json');
    });
</script>
</body>
</html>





























az