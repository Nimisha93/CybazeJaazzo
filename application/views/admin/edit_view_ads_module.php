<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
<div class="">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Services Advertisements<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">

                        <li><a href="<?= base_url() ?>Ads"><button type="button" class="btn btn-primary editsub pull-right"><i class="fa fa-plus"></i></button></a></li>
                        <li><a href="<?= base_url() ?>default_ads"><button type="button" class="btn btn-primary editsub pull-right">Add Default Services Advertisement</button></a></li>
                        <li><a type="button" class="btn btn-danger fllft del_item" title="Delete"><i class="fa fa-trash" aria-hidden="true"></i></a> 
                        </li>
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="">
                        <table id="example" class="display table table-bordered" cellspacing="0" width="100%">
                            <thead>
                            <tr class="tablbg">
                                <th style="width: 30px">No</th>
                                <th>Module</th>
                                <th>Image</th>
                                <th style="width: 90px">Action</th>
                            </tr>
                            </thead>
                            <tbody style=" height:100px;overflow:scroll">
                            <?php  foreach($ads['ads'] as  $key =>  $ads){?>
                            <tr>
                                <input type="hidden" value="<?php echo $ads['id'];?>" class="hiddentype_id">
                                <td><?= $key+1;?></td>
                                <td><?php echo $ads['module_name'];?></td>
                                <td class="descrip"><img src="<?php echo base_url().$ads['module_image'];?>" width="50px" height="50px"></td>
                                <td>
                                    <a href="<?php echo base_url();?>admin/Product/get_ads_byid/<?=$ads['id'];?>"><button type="button" class="btn btn-primary type_sub"><i class="fa fa-pencil"></i> </button></a>
                                    <input type="checkbox" name="" value="<?php echo $ads['id'];?>" class="chck_item_id"> 
                                </td>
                            </tr>
                            <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><div id="notifications"></div><input type="hidden" id="position" value="center">
<div class="clearfix"></div>
</div>
</div>
</div>
</div>
</div>
<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function() {
        var table = $('#example').DataTable( {
            fixedHeader: {
                header: true,
                footer: true,
            }
        });
        //Delete Club agent
    $(document).on('click','.del_item',function(){
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
                    $.post('<?php echo base_url();?>admin/product/delete_module_ads/',{chck_item_id:chck_item_id}, function(data){
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
                            refresh_close();
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





























