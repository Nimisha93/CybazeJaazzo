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
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>All Pool Settings<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="">        
                        <div class="container">
                            <div class="row">
                            <?php $color = array('warning','primary','success','info');?>
                            <?php  foreach($poolings as $key=> $pool ){?>
                                <div class="col-md-3 col-sm-6 col-xs-12 float-shadow">        
                                    <div class="price_table_container">
                                        <input type="hidden" value="<?php echo $pool['id'];?>" class="hiddentype_id">
                                        <div class="price_table_heading"><?php echo $pool['title'];?></div>
                                        <div class="price_table_body">
                                            <div class="price_table_row cost <?php echo $color[$key];?>-bg"><strong><?php echo $pool['percentage'];?> </strong><span>%</span></div>
                                            <div class="bs-example prctbl">
                                                <table class="table">
                                                    <tbody class="tablmargntp">
                                                    <tr>
                                                        <td>No Of Levels</td>
                                                        <td><?php echo $pool['no_of_levels'];?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Related To</td>
                                                        <td><?php echo ucfirst(strtolower(str_replace("_", " ", $pool['related_to'])));?></td>
                                                    </tr>
                                                </tbody>
                                                </table>
                                            </div>                              
                                        </div>
                                        <a href="<?= base_url();  ?>view_pool_members/<?= $pool['id']; ?>" class="btn btn-<?php echo $color[$key];?> btn-lg btn-block">View Full Pool Setting</a>
                                        <a href="#" class="btn btn-<?php echo $color[$key];?> btn-lg btn-block pool_delete">Delete Pool Group</a>
                                    </div>
                                </div>
                            <?php } ?>
                                <div id="notifications"></div><input type="hidden" id="position" value="center">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>  
</div>
<div class="clearfix"></div>
<?php echo $footer; ?>
<script>
    $(document).on('click','.pool_delete',function(){
        var cur=$(this);
        var hiddentypeid=cur.parent().find('.hiddentype_id').val();
        $('body').alertBox({
            title: 'Are You Sure?',
            lTxt: 'Back',
            lCallback: function(){
              
            },
            rTxt: 'Okey',
            rCallback: function(){
                $('.body_blur').show();
                $.post('<?php echo base_url();?>delete_pool_settings/'+hiddentypeid, function(data){
                    $('.body_blur').hide();
                    if(data.status){
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully deleted </div></div>';
                        var effect='zoomIn';
                        $("#notifications").append(center);
                        $("#notifications-full").addClass('animated ' + effect);
                        $('.close').click(function(){
                            $(this).parent().fadeOut(1000);
                            location.reload();
                        });
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
    });
</script>
</body>
</html>





























