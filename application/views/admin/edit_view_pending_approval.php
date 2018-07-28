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

                        <h2>Approve Commission</h2>
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
                            <table id="example" class="display table-bordered" cellspacing="0" width="100%">
                                <thead>
                                    <tr class="tablbg">
                                        <th>No</th>
                                        <th>Channel Partner Name</th>
                                        <th>Category</th>
                                         <th>Current Commission</th>
                                        <th>New Commission</th>
                                        <th>Action</th>
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

        function load_demo(index) {
            index = index || 0;
            var search = $('#search').val();
            
            $.post(base_url + "commission_approval/" + index, { ajax: true,search:search}, function(data) {
                
                $('tbody').html("");
                $('.body_blur').hide();
                if(data.data.length>0){
                  console.log(data);
                    var tr = '';
                    var data1 = data.data;
                    for(var i = 0; i< data1.length; i++){
                        var cur_index=parseInt(index);
                        var sl_no=index!=0?(cur_index+(i + 1)):(i + 1);
                       
                        tr += '<tr>'+

                            '<td class="slno"><input type="hidden" value="'+data1[i].id+'" class="hiddentype_id">'+
                            '<input type="hidden" value="'+data1[i].uid+'" class="u_id">'+sl_no+'</td>'+
                            '<td class="titleclass">'+data1[i].name+'</td>'+
                            '<td class="mobile">'+data1[i].category_title+'</td>'+
                            '<td class="email">'+data1[i].old_commission+'</td>'+
                            '<td class="new_commission">'+data1[i].new_commission+'</td>'+
                            '<td><button type="button" class="btn btn-primary approve">Approve </button></td>'+
                            '</tr>';

                    }
                    
                    $('#search').val(data.search);
                
                        $('#pagination').html(data.pagination);
                    

                }else{
                     tr += '<tr><td colspan="10">No data found</td></tr>';
                   
                }
               
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
<script type="text/javascript">
    $(document).on('click','.approve',function(){
               var cur=$(this);
               var id = cur.parent().parent().find('.hiddentype_id').val();
               var u_id = cur.parent().parent().find('.u_id').val();
               var new_commission = cur.parent().parent().find('.new_commission').text();
              // alert(new_commission);alert(id);
                $('body').alertBox({
                    title: 'Are You Sure?',
                    lTxt: 'Back',
                    lCallback: function(){
                      
                    },
                    rTxt: 'Okay',
                    rCallback: function(){
                        $('.body_blur').show();
                        $.post('<?php echo base_url();?>admin/home/approve_cp_new_commission',{new_commission:new_commission,id:id,u_id:u_id}, function(data){
                            $('.body_blur').hide();
                            if(data.status){
                                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Approved </div></div>';
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
            
        });
    });
</script>
