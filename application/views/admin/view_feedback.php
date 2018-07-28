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
                        <h2>All Feedback<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                            <li><a type="button" class="btn btn-danger fllft del_btn" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a> 
                            </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="row">
                            <div class="col-sm-offset-7 col-sm-3">
                                <label class="pull-right">Search:</label>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" class="form-control search" name="search" id="search" placeholder="">
                            </div>
                        </div><br>
                        <div class="">
                            <table id="example" class="table table-bordered display" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                    <th style="width: 40px">SI No.</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Type</th>
                                    <th>Message</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody style=" height:100px;overflow:scroll">
                                </tbody>
                                <tfoot>
                                    <td colspan="7">
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
    <div class="clearfix"></div>
    <div id="notifications"></div>
    <input type="hidden" id="position" value="center">  
</div>
<?php echo $footer; ?>
            <script type="text/javascript">
                $(document).ready(function(){
                    var base_url = "<?php echo base_url(); ?>";
                    function load_demo(index) {
                        index = index || 0;
                        var search = $('#search').val();
                        $.post(base_url + "feedback/" + index, { ajax: true,search:search}, function(data) {
                            console.log(data);
                            $('tbody').html("");
                            $('.body_blur').hide();
                            var tr = '';
                            if(data.status){
                                var data1 = data.data;
                                for(var i = 0; i< data1.length; i++){
                                    var cur_index=parseInt(index);
                                    var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                                    tr += '<tr>'+
                                        '<td>'+sl_no+'</td>'+
                                        '<td>'+data1[i].name+'</td>'+
                                        '<td>'+data1[i].email+'</td>'+
                                        '<td>'+data1[i].phone+'</td>'+
                                        '<td>'+data1[i].type+'</td>'+
                                        '<td>'+data1[i].message+'</td>'+
                                        '<td><input type="checkbox" name="" value="'+data1[i].id+'" class="chck_item_id"></td>'+
                                        '</tr>';
                                }
                                $('tbody').html(tr);
                                $('#search').val(data.search);
                                // pagination
                                $('#pagination').html(data.pagination);

                            }else{
                                 tr += '<tr>'+
                                        '<td colspan="7" style="text-align:center">No Data Found</td>'+
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
                    //Delete feedback
                    $(document).on('click','.del_btn',function(){
                        var cur=$(this);
                        var chck_item_id = [];
                        $('.chck_item_id').each(function () {
                            var cur_this = $(this);
                            var cur_val = $(this).val();
                            if(cur_this.is(":checked")){
                                chck_item_id.push(cur_val);
                            }
                        });
                        if(chck_item_id.length > 0){
                            $('body').alertBox({
                                title: 'Are You Sure?',
                                lTxt: 'Back',
                                lCallback: function(){
                                  
                                },
                                rTxt: 'Okey',
                                rCallback: function(){
                                    $('.body_blur').show();
                                    $.post('<?php echo base_url();?>delete_feedback/',{chck_item_id:chck_item_id}, function(data){
                                        $('.body_blur').hide();
                                        if(data.status){
                                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully deleted </div></div>';
                                            var effect='zoomIn';
                                            $("#notifications").append(center);
                                            $("#notifications-full").addClass('animated ' + effect);
                                            refresh_close();
                                        }else{
                                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+data.reason+'</div></div>';
                                            var effect='fadeInRight';
                                            $("#notifications").append(center);
                                            $("#notifications-full").addClass('animated ' + effect);
                                            //refresh_close();
                                            $('.close').click(function(){
                                                $(this).parent().fadeOut(1000);
                                            });
                                        }
                                    },'json');
                                }
                            })
                        }
                    });
                });
            </script>
</body>
</html>

