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
                        <h2>Club Members Report<small></small></h2>
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
                                        <div class="col-sm-3">
                                            <input type="text" class="form-control search" name="search" id="search" placeholder="">
                                        </div>
                                        <div class="col-sm-2" style="text-align: right;">
                                            <label>Club Member Type</label>
                                        </div>
                                        <div class="col-sm-3">
                                            <select id="club_type" class="form-control club_type" name="club_type">
                                                <option value="">--Select Any--</option>
                                                <option value="UNLIMITED">Unlimited</option>
                                                <option value="FIXED">Fixed</option>
                                                <option value="INVESTOR">Team Lead Club</option>
                                            </select>
                                        </div>
                                </div><br>
                                <table id="purchase_table" class="table table-bordered table-striped">
                                    <thead>
                                        <tr class="tablbg">
                                            <th style="width: 45px">No</th>
                                            <th>Name</th>
                                            <th>Phone</th>
                                            <th>Email</th>
                                            <th>Unlimited<!-- Club Type 1 --> </th>
                                            <th>Fixed<!-- Club Type 2 --> </th>
                                            <th>Team Lead Club<!-- Club Type 2 --> </th>
                                            <th>Status</th>
                                            <th>Created on</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    
                                    </tbody>
                                    <tfoot>
                                        <td colspan="9">
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
                                <th colspan="8">JAAZZO<br><p>Club Members Report</p></th>
                            </tr>
                            <tr class="filters">
                                <th>No</th>
                                <th>Name</th>
                                <th>Phone</th>
                                <th>Email</th>
                                <th>Unlimited<!-- Club Type 1 --> </th>
                                <th>Fixed<!-- Club Type 2 --> </th>
                                <th>Team Lead Club<!-- Club Type 2 --> </th>
                                <th>Status</th>
                                <th>Created on</th>
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
            var club_type = $('#club_type').val();
            if(search){
                $('.body_blur').hide();
            }else{
                $('.body_blur').show();
            }
            $.post(base_url + "club_members_by_type/" + index, { ajax: true,search:search,club_type:club_type}, function(data) {
                console.log(data);
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.status){

                    var tr = '';
                    var data1 = data.data;
                    for(var i = 0; i< data1.length; i++){
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                        var stat=(data1[i].status).toLowerCase().replace("_", " ");
                        stat = stat.substring(0,1).toUpperCase() + 
                        stat.substring(1,stat.length);
                        var plan1 = (!$.isNumeric(data1[i].plan_1))?data1[i].plan_1:"-";
                        var plan2 = (!$.isNumeric(data1[i].plan_2))?data1[i].plan_2:"-";
                        var plan3 = (!$.isNumeric(data1[i].plan_3))?data1[i].plan_3:"-";
                        tr += '<tr>'+
                            '<td>'+sl_no+'</td>'+
                            '<td>'+data1[i].name+'</td>'+
                            '<td>'+data1[i].phone+'</td>'+
                            '<td>'+data1[i].email+'</td>'+
                            '<td>'+plan1+'</td>'+
                            '<td>'+plan2+'</td>'+
                            '<td>'+plan3+'</td>'+
                            '<td>'+stat+'</td>'+
                            '<td>'+data1[i].created_on+'</td>'+
                            '</tr>';
                    }
                    $('tbody').html(tr);
                    $('#search').val(data.search);
                    $('#club_type').val(data.club_type);

                    // pagination
                    $('#pagination').html(data.pagination);

                }else{

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
        $("#club_type").change(function(){
            load_demo();
        });
    });

    $(document).on('click','.btn_print',function(){
        var base_url = "<?php echo base_url(); ?>";
        var search = $('#search').val();
        var club_type = $('#club_type').val();

        $.post(base_url + "admin/Report/print_cm_by_type_report", {search:search,club_type:club_type}, function(data) {
            if(data.status){

              
                var tr = '';
                    var data1 = data.data;
                    // var dat=data1.data;
                    for(var i = 0; i< data1.length; i++){
                        var sl_no=(i + 1);
                        var stat=(data1[i].status).toLowerCase().replace("_", " ");
                        stat = stat.substring(0,1).toUpperCase() + 
                        stat.substring(1,stat.length);
                        var plan1 = (!$.isNumeric(data1[i].plan_1))?data1[i].plan_1:"-";
                        var plan2 = (!$.isNumeric(data1[i].plan_2))?data1[i].plan_2:"-";
                        var plan3 = (!$.isNumeric(data1[i].plan_3))?data1[i].plan_3:"-";
                        tr += '<tr>'+
                            '<td>'+sl_no+'</td>'+
                            '<td>'+data1[i].name+'</td>'+
                            '<td>'+data1[i].phone+'</td>'+
                            '<td>'+data1[i].email+'</td>'+
                            '<td>'+plan1+'</td>'+
                            '<td>'+plan2+'</td>'+
                            '<td>'+plan3+'</td>'+
                            '<td>'+stat+'</td>'+
                            '<td>'+data1[i].created_on+'</td>'+
                            '</tr>';
                    }
                $('.tbodyy').html(tr);
                var tt= $('.report_left_inner').html();
                PrintDiv(tt);
            }
        },'json');
    });
</script>
</body>
</html>





























az