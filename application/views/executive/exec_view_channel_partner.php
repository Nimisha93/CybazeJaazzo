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
                             Pending Channel Partner   
                            </div>
                            <br><br>
                            <div class="card-content">
                            <!--    <h4 class="card-title">Commision</h4>-->
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->
                                </div>
                                <div class="material-datatables">
                                    <div class="row">
                                        <div class="col-sm-offset-6 col-sm-3">
                                            <label class="pull-right">Search:</label>
                                        </div>
                                        <div class="col-sm-2">
                                            <input type="text" class="form-control search" name="search" id="search" placeholder="">
                                        </div>
                                        <div class="col-sm-1">
                                            <a type="button" class="btn btn-primary fllft del_btn" style="background-color:#bf0b0b ;float:right;color: #fff; padding: 10px;" ><i class="fa fa-trash" aria-hidden="true"></i></a>
                                        </div>
                                    </div><br>
                                    <table id="datatables" class="table datatables table-striped table-no-bordered table-hover" cellspacing="0" width="100%"
                                           style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Name of the Organization</th>
                                                <th>Email</th>
                                                <th>Contact No</th>
                                                <th>Owner</th>
                                                <th>Owner Mobile</th>
                                                <th>PAN No.</th>
                                                <th class="disabled-sorting text-right">Actions</th>
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
        <div id="notifications"></div><input type="hidden" id="position" value="center">
    <?php echo $footer; ?>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.datatables.js"></script>
<script>
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
                $.post(base_url + "view_channel_partner/" + index, { ajax: true,search:search}, function(data) {
                    console.log(data);
                    $('tbody').html("");
                    $('.body_blur').hide();
                    if(data.status){

                        var tr = '';
                        var data1 = data.data;
                        for(var i = 0; i< data1.length; i++){
                            var cur_index=parseInt(index);
                            var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                            var act ='<a href="<?php echo base_url();?>admin/executives/update_channel_partner/'+data1[i].cp_id+'" class="btn btn-simple btn-info btn-icon edit"><i class="material-icons">edit</i></a><input type="checkbox" name="" value="'+data1[i].cp_id+'" class="chck_item_id">';
                            tr += '<tr>'+
                                '<td>'+sl_no+'</td>'+
                                '<td>'+data1[i].name+'</td>'+
                                '<td>'+data1[i].phone+'</td>'+
                                '<td>'+data1[i].email+'</td>'+
                                '<td>'+data1[i].owner_name+'</td>'+
                                '<td>'+data1[i].owner_mobile+'</td>'+
                                '<td>'+data1[i].pan+'</td>'+
                                '<td>'+act+'</td>'+
                                '</tr>';
                        }
                        $('tbody').html(tr);
                        $('#search').val(data.search);
                        // pagination
                        $('#pagination').html(data.pagination);

                    }else{
                        var tr='';
                        tr += '<tr>'+
                                '<td colspan="8">No Data Found</td>'+
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
            console.log(chck_item_id);
            if(chck_item_id.length > 0){
                $('body').alertBox({
                    title: 'Are You Sure?',
                    lTxt: 'Back',
                    lCallback: function(){
                      
                    },
                    rTxt: 'Okey',
                    rCallback: function(){
                        $('.body_blur').show();
                        $.post('<?php echo base_url();?>admin/executives/delete_partnerbyid/',{chck_item_id:chck_item_id}, function(data){
                            $('.body_blur').hide();
                            if(data.status){
                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully deleted </div></div>';
                                var effect='zoomIn';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                refresh_close();
                                setTimeout(function(){

                        //$('#channel_form').hide();
                        location.reload();
                    }, 1000);
                            }else{
                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+data.reason+'</div></div>';
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
</script>
</body>
</html>