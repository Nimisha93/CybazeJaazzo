<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
<style type="text/css">
    span.help-inline-error{
        color: red;
    }
    input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
</style>
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

                        <h2><?php echo $status; ?> Channel Partners</h2>
                        <ul class="nav navbar-right panel_toolbox">
                           <?php if($status=='Not Approved'){ ?>
                           <li><a type="button" class="btn btn-danger fllft del_btn" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a> 
                           </li>
                           <?php } ?>
                            <li><a class="btn btn-primary editsub"  style="background-color:#162b52"  href="<?php echo base_url();?>partner"><i class="fa fa-user-plus"></i></a> </li>
                           <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                        <input type="hidden" name="root_url" value="<?= $root_url; ?>" id="root_url">
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
                            <table id="example" class="display table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="tablbg">
                                        <th style="width: 30px">No.</th>
                                        <th>Name of the Organization</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Type</th>
                                        <th>Owner</th>
                                        <th>Owner Mobile</th>
                                        
                                        <th>PAN No</th>
                                        <?php if($status=="Not Approved"){ ?>
                                        <th class="approve_th">Approve</th>
                                        <?php } ?>
                                        <th style="width: 90px">Action</th>
                                    </tr>
                                </thead>
                                <tbody style=" height:100px;overflow:scroll">
                                    
                                </tbody>
                                <tfoot id ="foot">
                                    <td colspan="10">
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
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        var root_url = $('#root_url').val();
        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            $.post(base_url + root_url +"/" + index, { ajax: true,search:search}, function(data) {
                
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.data.length>0){
                  console.log(data.data);
                    var tr = '';
                    var data1 = data.data;
                    for(var i = 0; i< data1.length; i++){
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                        console.log(data1[i].status);
                        if(data1[i].status=='NOT_APPROVED'){
                            var appprove = '<td class="approve_td"><button type="button" class="btn btn-danger approve_cp">Approve</button></td>';
                            var del ='<input type="checkbox" name="" value="'+data1[i].cp_id+'" class="chck_item_id">';
                        }else{
                            var appprove = "";
                            var del='';
                        }
                        tr += '<tr>'+
                            '<td><input type="hidden" value="'+data1[i].cp_id+'" class="hiddentype_id">'+
                                 '<input type="hidden" value="'+data1[i].email+'" class="email">'+
                                 '<input type="hidden" value="'+data1[i].otp+'" class="otp">'+sl_no+'</td>'+
                            '<td>'+data1[i].name+'</td>'+
                            '<td>'+data1[i].phone+'</td>'+
                            '<td>'+data1[i].email+'</td>'+
                            '<td>'+data1[i].cp_type+'</td>'+
                            '<td>'+data1[i].owner_name+'</td>'+
                            '<td>'+data1[i].owner_mobile+'</td>'+
                           
                            '<td>'+data1[i].pan+'</td>'+appprove+     
                            '<td><a href="'+base_url+"admin/home/get_channelpartner_byid/"+data1[i].cp_id+'"><button type="button" class="btn btn-primary type_sub"><i class="fa fa-pencil"></i> </button></a>'+del+'</td>'+
                            '</tr>';

                    }
                    
                    $('#search').val(data.search);
                    
                        $('#pagination').html(data.pagination);
                

                }else{
                     tr += '<tr><td colspan="10">No data found</td></tr>';
                     
                }
                $('#status').text(status);
                $('tbody').html(tr);
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
<script>
    $(document).ready(function(){
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
                        $.post('<?php echo base_url();?>admin/Home/delete_partnerbyid/',{chck_item_id:chck_item_id}, function(data){
                            $('.body_blur').hide();
                            if(data.status){
                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully deleted </div></div>';
                                var effect='zoomIn';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                refresh_close();
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
    });
</script>
<script>
$(document).ready(function(){
 
    $(document).on('click','.approve_cp',function(){
        var cur=$(this);
        var hiddentypeid=cur.parent().parent().find('.hiddentype_id').val();
        var email=cur.parent().parent().find('.email').val();
        var otp=cur.parent().parent().find('.otp').val();
      
                    $('.body_blur').show();
                    $.post('<?php echo base_url();?>admin/Home/approve_cp/',{id:hiddentypeid,email:email,otp:otp}, function(data){
                        $('.body_blur').hide();
                        if(data.status){
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Approved Channel Partner </div></div>';
                                var effect='zoomIn';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                refresh_close();
                        }else{
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Database Error</div></div>';
                                var effect='fadeInRight';
                                $("#notifications").append(center);
                                $("#notifications-full").addClass('animated ' + effect);
                                refresh_close();
                                                                    }
                    },'json');
                          

                })
            });
</script>