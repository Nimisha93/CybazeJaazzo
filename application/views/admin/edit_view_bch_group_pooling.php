<?php echo $default_assets; ?>

<link href="<?php echo base_url();?>assets/admin/css/fixed-data-table.css" rel="stylesheet">

</head>
<?php echo $sidebar; ?>

<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <div type="button" class="btn" data-toggle="popover" data-placement="right" title="" data-content="This is the name that will be shown on invoices, bills created for this contact."><i class="fa fa-info-circle" aria-hidden="true"></i></div>
                </h3>
            </div>
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for...">
                <span class="input-group-btn">
                <button class="btn btn-default" type="button">Go!</button>
                </span> </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
       <!--  <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Channel Partner Type<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <table id="example" class="display" cellspacing="0" width="100%">
                                <thead>
                                <tr class="tablbg">
                                    <th>Pool Group Name</th>
                                    <th>Allocated Pesentage</th>
                                    <th>No Of Levels</th>
                                    <th>Action</th>

                                </tr>
                                </thead>
                                <tfoot>
                                <tr>
                                    <th>Pool Group Name</th>
                                    <th>Allocated Pesentage</th>
                                    <th>No Of Levels</th>
                                    <th>Action</th>

                                </tr>
                                </tfoot>
                                <tbody style=" height:100px;overflow:scroll">

                                <?php  foreach($pooling_groups as $pool_group ){?>
                                <tr>
                                    <td class="titleclass"><input type="hidden" value="<?php echo $pool_group['id'];?>" class="hiddentype_id"><?php echo $pool_group['title'];?></td>
                                    <td class="descrip"><?php echo $pool_group['group_persentage'];?></td>
                                    <td class="descrip"><?php echo $pool_group['no_of_levels'];?></td>
                                    <td><a href="<?= base_url();  ?>admin/pooling/full_system_pool_bch_settings/<?= $pool_group['id']; ?>/group/">View Full Pool Settings</a>
                                        <button type="button" class="commission_delete">Delete Pool Group</button></td>



                                </tr>
                                    <?php }?>
                                <?php  foreach($pooling_stages as $pool_group ){?>
                                <tr>
                                    <td class="titleclass"><input type="hidden" value="<?php echo $pool_group['id'];?>" class="hiddentype_id"><?php echo $pool_group['title'];?></td>
                                    <td class="descrip"><?php echo $pool_group['group_persentage'];?></td>
                                    <td class="descrip"><?php echo $pool_group['no_of_levels'];?></td>
                                    <td><a href="<?= base_url();  ?>admin/pooling/full_system_pool_bch_settings/<?= $pool_group['id']; ?>/stage/">View Full Pool Settings</a>
                                        <button type="button" class="stage_commission_delete">Delete Pool Group</button></td>



                                </tr>
                                    <?php }?>

                            
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div> -->
    </div>
    <div class="clearfix"></div>
    <script>

                                    $(document).ready(function(){
                                        $(document).on('click','.type_sub',function(){
                                            var cur=$(this);
                                            var hiddentype_id=cur.parent().parent().find('.hiddentype_id').val();
                                            var title=cur.parent().parent().find('.titleclass').text();
                                            var descrip=cur.parent().parent().find('.descrip').text();
                                            $(document).find('#title').val(title);
                                            $(document).find('#descriptext').val(descrip);
                                            $(document).find('#hiddentype').val(hiddentype_id);

                                        });
                                        $("#editsub").click(function(e){
                                            e.preventDefault();
                                            var str = $("#type_forms").validationEngine("validate");
                                            if(str==true){

                                                var data=$("#type_forms").serializeArray();
                                                $('.body_blur').show();
                                                $.post("<?php echo base_url();?>admin/Channel_partner/edit_partnertype_byid", data, function(data){
                                                    $('.body_blur').hide();
                                                    if(data.status){
                                                        noty({text:"Successfully updated",type: 'success',layout: 'top', timeout: 3000});
                                                        $('#type_forms')[0].reset();
                                                    }
                                                    else{
                                                        noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                                                        $('#type_forms')[0].reset();
                                                    }
                                                },'json');
                                            }
                                            else{

                                            }

                                        })
                                        $(document).on('click','.type_delete',function(){
                                            var cur=$(this);
                                            var hiddentypeid=cur.parent().parent().find('.hiddentype_id').val();
                                            noty({
                                                text: 'Do you want to continue?',
                                                type: 'warning',
                                                buttons: [
                                                    {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {

                                                        // this = button element
                                                        // $noty = $noty element

                                                        $noty.close();
                                                        $('.body_blur').show();
                                                        $.post('<?php echo base_url();?>admin/Channel_partner/delete_partnertype/'+hiddentypeid, function(data){
                                                            $('.body_blur').hide();
                                                            if(data.status){
                                                                noty({text: 'Deleted Succesfully', type: 'success', timeout:1000});
                                                                cur.parent().parent().remove();
                                                            }else{
                                                                noty({text: 'Database Error', type: 'error'});
                                                            }
                                                        },'json');
                                                    }
                                                    },
                                                    {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
                                                        $noty.close();

                                                    }
                                                    }
                                                ]
                                            });

                                        })
                                    });
                                    $(document).on('click','.commission_delete',function(){
                                        var cur=$(this);
                                        var hiddentypeid=cur.parent().find('.hiddentype_id').val();
                                        noty({
                                            text: 'Do you want to continue?',
                                            type: 'warning',
                                            buttons: [
                                                {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {

                                                    // this = button element
                                                    // $noty = $noty element

                                                    $noty.close();
                                                    $('.body_blur').show();
                                                    $.post('<?php echo base_url();?>admin/Pooling/delete_system_bch_pool_group/'+hiddentypeid, function(data){
                                                        $('.body_blur').hide();
                                                        if(data.status){
                                                            noty({text: 'Deleted Succesfully', type: 'success', timeout:1000});
                                                            cur.parent().parent().remove();
                                                        }else{
                                                            noty({text: 'Database Error', type: 'error'});
                                                        }
                                                    },'json');
                                                }
                                                },
                                                {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
                                                    $noty.close();

                                                }
                                                }
                                            ]
                                        });

                                    })

                                    $(document).on('click','.stage_commission_delete',function()
                                    {
                                        var cur=$(this);
                                        var hiddentypeid=cur.parent().find('.hiddentype_id').val();
                                        noty({
                                            text: 'Do you want to continue?',
                                            type: 'warning',
                                            buttons: [
                                                {addClass: 'btn btn-primary', text: 'Ok', onClick: function($noty) {

                                                    // this = button element
                                                    // $noty = $noty element

                                                    $noty.close();
                                                    $('.body_blur').show();
                                                    $.post('<?php echo base_url();?>admin/Pooling/delete_system_stage_bch_pool_group/'+hiddentypeid, function(data){
                                                        $('.body_blur').hide();
                                                        if(data.status){
                                                            noty({text: 'Deleted Succesfully', type: 'success', timeout:1000});
                                                            cur.parent().parent().remove();
                                                        }else{
                                                            noty({text: 'Database Error', type: 'error'});
                                                        }
                                                    },'json');
                                                }
                                                },
                                                {addClass: 'btn btn-danger', text: 'Cancel', onClick: function($noty) {
                                                    $noty.close();

                                                }
                                                }
                                            ]
                                        });
                                    });

                                </script>


      <div class="clearfix"></div>
 <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>BCH Pool Settings<small></small></h2>
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
              <?php  foreach($pooling_groups as $key=> $pool_group ){?>

                <div class="col-md-3 col-sm-6 col-xs-12 float-shadow">        
                    <div class="price_table_container">
                    <input type="hidden" value="<?php echo $pool_group['id'];?>" class="hiddentype_id">
                        <div class="price_table_heading"><?php echo $pool_group['title'];?></div>
                        <div class="price_table_body">
                            <div class="price_table_row cost warning-bg"><strong><?php echo $pool_group['group_persentage'];?> </strong><span>%</span></div>
                            <div class="bs-example prctbl">
                                <table class="table">
 
                                    <tbody class="tablmargntp">
                                     <tr>
                                        <td>No Of Levels</td>
                                        <td><?php echo $pool_group['no_of_levels'];?></td>
                                    </tr>
                                </tbody>

                                </table>
                            </div>                              
                        </div>
               <a href="<?= base_url();  ?>admin/pooling/full_system_pool_bch_settings/<?= $pool_group['id']; ?>/group/" class="btn btn-warning btn-lg btn-block">View Full Pool Setting</a>
                <a href="#" class="btn btn-warning btn-lg btn-block commission_delete">Delete Pool Group</a>
                    </div>
                </div>
          <?php } ?>
           <?php  foreach($pooling_stages as $pool_group ){?>
            <div class="col-md-3 col-sm-6 col-xs-12 float-shadow">        
                    <div class="price_table_container">
                    <input type="hidden" value="<?php echo $pool_group['id'];?>" class="hiddentype_id">
                        <div class="price_table_heading"><?php echo $pool_group['title'];?></div>
                        <div class="price_table_body">
                            <div class="price_table_row cost warning-bg"><strong><?php echo $pool_group['group_persentage'];?> </strong><span>%</span></div>
                            <div class="bs-example prctbl">
                                <table class="table">
 
                                    <tbody class="tablmargntp">
                                     <tr>
                                        <td>No Of Levels</td>
                                        <td><?php echo $pool_group['no_of_levels'];?></td>
                                    </tr>
                                </tbody>

                                </table>
                            </div>                              
                        </div>
               <a href="<?= base_url();  ?>admin/pooling/full_system_pool_bch_settings/<?= $pool_group['id']; ?>/stage/" class="btn btn-warning btn-lg btn-block">View Full Pool Setting</a>
                <a href="#" class="btn btn-warning btn-lg btn-block stage_commission_delete">Delete Pool Group</a>
                    </div>
                </div>
            <?php } ?>
               
        
            </div>
        </div>


                    
                        </div>
                    </div>

                </div>
            </div>
        </div>
        




    <!--************************row  end******************************************************************* -->




</div>

<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>


<script>

    $(document).ready(function() {
        var table = $('#example').DataTable( {
            fixedHeader: {
                header: true,
                footer: true

            }
        } );

    } );

</script>

</body>
</html>

