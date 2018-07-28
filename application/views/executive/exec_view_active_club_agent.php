<?php echo $header; ?>
    <body>
        <div class="wrapper">
            <?php echo $sidebar; ?>
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header card-header-icon" data-background-color="purple">
                                    Active Club Agents
                                </div><br><br>
                                <div class="card-content">
                                <!--    <h4 class="card-title">Commision</h4>-->
                                    <div class="toolbar">
                                        <!--        Here you can write extra buttons/actions for the toolbar              -->
                                    </div>
                                    <div class="material-datatables">
                                        <div class="row">
                                            <div class="col-sm-offset-7 col-sm-3">
                                                <label class="pull-right">Search:</label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="text" class="form-control search" name="search" id="search" placeholder="">
                                            </div>
                                        </div>
                                        <br>
                                        <table id="" class="table datatables table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
                                               style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Contact No</th>
                                                    <th>Club Member</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                            <tfoot>
                                                <td colspan="8">
                                                    <div class="pull-right" id="pagination"></div>
                                                </td>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            <!-- end content-->
                            </div>
                        <!--  end card  -->
                        </div>
                    <!-- end col-md-12 -->
                    </div>
                <!-- end row -->
                </div>
            </div>
            <?php echo $footer; ?>
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
                    $.post(base_url + "view_active_club_agent/" + index, { ajax: true,search:search}, function(data) {
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
                                    '<td>'+data1[i].phone+'</td>'+
                                    '<td>'+data1[i].email+'</td>'+
                                    '<td>'+data1[i].club+'</td>'+
                                    '</tr>';
                            }
                            $('tbody').html(tr);
                            $('#search').val(data.search);
                            // pagination
                            $('#pagination').html(data.pagination);

                        }else{
                            var tr='';
                            tr += '<tr>'+
                                    '<td colspan="5">No Data Found</td>'+
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
        </script>
    </body>
</html>