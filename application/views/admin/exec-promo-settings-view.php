<?php
echo $default_assets;

echo $sidebar;

?>
<script src="<?php echo base_url();?>/assets/admin/js/angular.min.js"></script>
<script src="<?php echo base_url();?>/assets/admin/js/ui-bootstrap-tpls.min.js"></script>
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
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Executive Promotion Settings<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class=" tabmargntp30">
                                <div class="col-md-12">
                                    <form method="post" id="exec_form" action="<?php echo base_url();?>admin/executives/exec_seteditins">
                                     <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <div class="col-md-12">
                                            <label>From Desigination</label>
                                            <?php foreach ($designation as $key => $dsg) { ?>
                                            <input type="button" ng-model="designation" value="<?= $dsg['designation'];?>" class="form-control">
                                            <input type="text"  hidden="" value="<?= $dsg['id'];?>" name="pid" >
                                            <?php } ?>
                                        </div></div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <div class="col-md-12">
                                                <label>To Desigination</label>

                                            <input type="button" ng-model="designation" value="<?= $todesig['designation'];?>" class="form-control">
                                            <input type="text"  hidden="" value="<?= $todesig['designation']; ?>?>" name="did" >

                                        </div> </div>
                                </div>
                                <div class="col-md-12">
                                    <!-- <div class="col-md-4 col-sm-6 col-xs-12 form-group"><label>Module</label></div> -->
                                    <!-- <div class="col-md-4 col-sm-6 col-xs-12 form-group"><label>Count</label></div> -->
                                    <!-- <div class="col-md-4 col-sm-6 col-xs-12 form-group"><label>Amount</label></div> -->
                                </div>
                                <?php $s=1; foreach ($settings as $key => $set){ ?>
                                <?php

                                // $e[$s]=$set['promotion_count'];
                                // $f[$s]=$set['promotion_amount'];
                                $d=$set['sysmodule_id'];
                                $id[$d]=$set['id'];
                               //echo $id[$d];exit;
                                $e[$d]= $set['promotion_count'];
                                $f[$d]= $set['promotion_amount'];
                                $g[$d]= $set['promotion_period'];
                                $h[$d]= $set['promotion_count2'];
                                $i[$d]= $set['promotion_amount2'];
                                $j[$d]= $set['promotion_period2'];
                                $k[$d]= $set['promotion_count3'];
                                $l[$d]= $set['promotion_amount3'];
                                $m[$d]= $set['promotion_period3'];

                                // echo $set['sysmodule_id'],$set['promotion_count'],$set['promotion_amount'];
                                ?>
                                <!-- id,designation_id,sysmodule_id,promotion_count,promotion_amount,date -->
                                <?php $s=$s+1; } ?>
                                <div class="col-md-12">
                                    <!-- <?php print_r($modules); ?> -->
                                    <br>
                                    <input type="hidden" name="id" ng-model="designation" value="<?php echo $id[$d];  ?>" id="designation" class="form-control">
                                    <?php $ss=0; 


                                   

                                    //foreach ($modules as $key => $mod) {
                                         $w=$modules['id'];
                                          
                                          ?>
                                    <!-- <?php print_r($mod); ?> -->
                                    <div class="col-md-3">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                        
                                            <input type="text" name="md[]" hidden="" value="<?= $modules['id'];?>" >
                                            <!-- <?php if (array_key_exists("$w",$e)) { echo $e[$w]; } ?> -->
                                            <input type="button" ng-model="designation" value="<?= $modules['name'];?>" id="designation" class="form-control">
                                        </div>
                                    </div>
                                        <div class="col-lg-9">
                                    <div class="col-md-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Count</label> -->

                                            <input type="text" name="co[]" ng-model="designation" value="<?php if (array_key_exists("$w",$e)) { echo $e[$w]; } ?>" placeholder="Count" id="designation" class="form-control">
                                        </div></div>

                                    <div class="col-md-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                           
                                            <input type="text" name="am[]" ng-model="designation" value="<?php if (array_key_exists("$w",$f)) { echo $f[$w]; } ?>" placeholder="Amount" id="designation" class="form-control">
                                        </div></div>
                                    <div class="col-md-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                           
                                            <input type="text" name="pd[]" ng-model="designation" value="<?php if (array_key_exists("$w",$g)) { echo $g[$w]; } ?>" placeholder="period" id="designation" class="form-control">
                                        </div></div>


                                        <div class="col-md-4">
                                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                               
                                                <input type="text" name="co2[]" ng-model="designation" value="<?php if (array_key_exists("$w",$h)) { echo $h[$w]; } ?>" placeholder="Count" id="designation" class="form-control">
                                            </div></div>

                                        <div class="col-md-4">
                                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                                
                                                <input type="text" name="am2[]" ng-model="designation" value="<?php if (array_key_exists("$w",$i)) { echo $i[$w]; } ?>" placeholder="Amount" id="designation" class="form-control">
                                            </div></div>
                                        <div class="col-md-4">
                                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                              
                                                <input type="text" name="pd2[]" ng-model="designation" value="<?php if (array_key_exists("$w",$j)) { echo $j[$w]; } ?>" placeholder="period" id="designation" class="form-control">
                                            </div></div>

                                    
                                    <div class="col-md-4">
                                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                             
                                                <input type="text" name="co3[]" ng-model="designation" value="<?php if (array_key_exists("$w",$k)) { echo $k[$w]; } ?>" placeholder="Count" id="designation" class="form-control">
                                            </div></div>

                                        <div class="col-md-4">
                                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                              
                                                <input type="text" name="am3[]" ng-model="designation" value="<?php if (array_key_exists("$w",$l)) { echo $l[$w]; } ?>" placeholder="Amount" id="designation" class="form-control">
                                            </div></div>
                                        <div class="col-md-4">
                                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                          
                                                <input type="text" name="pd3[]" ng-model="designation" value="<?php if (array_key_exists("$w",$m)) { echo $m[$w]; } ?>" placeholder="period" id="designation" class="form-control">
                                            </div></div>

                                    </div>
                                    <?php 
                                    //$ss=$ss+1; }
                                     ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <input type="text" name="ss" hidden="" value="<?= $ss; ?>" id="designation">
                                        <button type="submit" class="btn btn-primary antosubmit">Save</button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
 <div id="notifications"></div><input type="hidden" id="position" value="center">
        <!--************************row  end******************************************************************* -->




    </div>
</div>

<?php echo $footer  ?>

<script>

    $("#add_designation").click(function(e)
    {
        //alert("dshgsh");
        e.preventDefault();

        var data= $("#desigination").serializeArray();
        $.post('<?= base_url(); ?>/admin/pooling/add_designation',data,function(data)
        {
            if(data.status)
            {
                noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                $('#allow_persantage').val('');
                $('#no_of_levels').val('');
                $('#pool_name').val('');

                window.location = '<?= base_url();?>admin/pooling/new_designation';

            }
            else
            {
                noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
            }

        },'json');

    });

    $("#sortorder").change(function()
    {
        var data=$("#desigination").serializeArray();
        $.post('<?= base_url(); ?>/admin/pooling/check_sort_order',data,function(data)
        {
            if(data.status)
            {
                noty({text:"Sort Order Already Exist",type: 'error',layout: 'top', timeout: 2000});

                $('#sortorder').val('');



            }
            else
            {
                //     noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
            }

        },'json');
    });
</script>
<script type="text/javascript">
     $(document).ready(function () {

         var v = jQuery("#exec_form").validate({
        
            submitHandler: function(datas) {
           
                jQuery(datas).ajaxSubmit({
                    
                    dataType : "json",
                    success  :    function(data)
                    {

                        if(data.status)
                {
                  
                    //$('#channel_form').hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Edited </div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        //$('#channel_form').hide();
                        location.reload();
                    }, 1000);
                }
                else
                {
                   // $('#channel_form').hide();
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    //$.toast(data.reason, {'width': 500});
                   // return false;
                }
                    }
                });
            }
        });
     });
</script>
