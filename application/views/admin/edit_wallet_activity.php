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
                        <h2>Wallet Report<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="box-body">
                                <table id="wallet_activity_table" class="table table-bordered table-striped" width="100%">
                                    <thead>
                                        <tr>
                                           <th>No</th>
                                            <th>Wallet</th>
                                            <th>Name</th>
                                            <th>Value</th>
                                            <th>Date</th>
                                            <th>Description</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                    <tfoot>
                                        <td colspan="6">
                                            <div class="pull-right" id="pagination"></div>
                                        </td>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
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
                        $.post(base_url + "wallet/" + index, { ajax: true,search:search}, function(data) {
                            console.log(data);
                            $('tbody').html("");
                            $('.body_blur').hide();
                            var tr = '';
                            if(data.status){
                                var data1 = data.data;
                                for(var i = 0; i< data1.length; i++){
                                    var cur_index=parseInt(index);
                                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                                    if(data1[i].title_a === 'NULL'){
                                        var  tit = data1[i].title_b;
                                    }else{
                                        var  tit = data1[i].title_a; 
                                    }
                                    if(data1[i].name === 'null'){
                                        var  name = '-';
                                    }else{
                                        var  name = data1[i].name; 
                                    }
                                    
                                    tr += '<tr>'+
                                        '<td>'+sl_no+'</td>'+
                                        '<td>'+tit+'</td>'+
                                        '<td>'+name+'</td>'+
                                        '<td>'+data1[i].value+'</td>'+
                                        '<td>'+data1[i].modified+'</td>'+
                                        '<td>'+data1[i].description+'</td>'+
                                        '</tr>';
                                }
                                $('tbody').html(tr);
                                $('#search').val(data.search);
                                // pagination
                                $('#pagination').html(data.pagination);

                            }else{
                                 tr += '<tr>'+
                                        '<td colspan="4" style="text-align:center">No Data Found</td>'+
                                        '</tr>';
                                $('tbody').html(tr);
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
            </script>
</body>
</html>
