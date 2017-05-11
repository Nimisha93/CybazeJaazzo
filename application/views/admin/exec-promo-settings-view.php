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
                                    <form method="post" action="<?php echo base_url();?>admin/executives/exec_seteditins">
                                        <!-- <form id="desigination" class="form-horizontal Calendar"   ng-controller="FormController" ng-submit="submitForm()" role="form" method="post"> -->
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>From Desigination</label>
                                            <?php foreach ($designation as $key => $dsg) { ?>
                                            <input type="button" ng-model="designation" value="<?= $dsg['designation'];?>" class="form-control">
                                            <input type="text"  hidden="" value="<?= $dsg['id'];?>" name="pid" >
                                            <?php } ?>
                                        </div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3"></div>
                                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                            <label>To Desigination</label>

                                            <input type="button" ng-model="designation" value="<?= $todesig['designation'];?>" class="form-control">
                                            <input type="text"  hidden="" value="<?= $todesig['designation']; ?>?>" name="did" >

                                        </div>
                                </div>
                                <div class="col-md-12">
                                    <!-- <div class="col-md-4 col-sm-6 col-xs-12 form-group"><label>Module</label></div> -->
                                    <!-- <div class="col-md-4 col-sm-6 col-xs-12 form-group"><label>Count</label></div> -->
                                    <!-- <div class="col-md-4 col-sm-6 col-xs-12 form-group"><label>Amount</label></div> -->
                                </div>
                                <?php $s=1; foreach ($settings as $key => $set){ ?>
                                <?php
                                // $d[$s]=$set['sysmodule_id'];
                                // $e[$s]=$set['promotion_count'];
                                // $f[$s]=$set['promotion_amount'];
                                $d=$set['sysmodule_id'];
                                $e[$d]= $set['promotion_count'];
                                $f[$d]= $set['promotion_amount'];
                                $g[$d]= $set['promotion_period'];


                                // echo $set['sysmodule_id'],$set['promotion_count'],$set['promotion_amount'];
                                ?>
                                <!-- id,designation_id,sysmodule_id,promotion_count,promotion_amount,date -->
                                <?php $s=$s+1; } ?>
                                <div class="col-md-12">
                                    <!-- <?php print_r($modules); ?> -->
                                    <br>
                                    <?php $ss=0; foreach ($modules as $key => $mod) { $w=$mod['id']; ?>
                                    <!-- <?php print_r($mod); ?> -->
                                    <div class="col-md-3">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Module</label> -->
                                            <!-- <input type="button" name="md[<?= $ss; ?>]" ng-model="designation" value="<?= $mod['name'];?>" id="designation" class="form-control"> -->
                                            <input type="text" name="md[]" hidden="" value="<?= $mod['id'];?>" >
                                            <!-- <?php if (array_key_exists("$w",$e)) { echo $e[$w]; } ?> -->
                                            <input type="button" ng-model="designation" value="<?= $mod['name'];?>" id="designation" class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Count</label> -->
                                            <!-- <input type="text" name="co[<?= $ss; ?>]" ng-model="designation" placeholder="Count" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="co[]" ng-model="designation" value="<?php if (array_key_exists("$w",$e)) { echo $e[$w]; } ?>" placeholder="Count" id="designation" class="form-control">
                                        </div></div>

                                    <div class="col-md-3">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Amount</label> -->
                                            <!-- <input type="text" name="am[<?= $ss; ?>]" ng-model="designation" placeholder="Amount" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="am[]" ng-model="designation" value="<?php if (array_key_exists("$w",$f)) { echo $f[$w]; } ?>" placeholder="Amount" id="designation" class="form-control">
                                        </div></div>
                                    <div class="col-md-3">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Count</label> -->
                                            <!-- <input type="text" name="co[<?= $ss; ?>]" ng-model="designation" placeholder="Count" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="pd[]" ng-model="designation" value="<?php if (array_key_exists("$w",$g)) { echo $g[$w]; } ?>" placeholder="period" id="designation" class="form-control">
                                        </div></div>
                                    <?php $ss=$ss+1; } ?>
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

        <!--************************row  end******************************************************************* -->




    </div>
</div>

<?php echo $footer  ?>

<script>
    <!--    var App = angular.module('myApp', ['ui.bootstrap']);-->
    <!--    function FormController($scope, $http) {-->
    <!---->
    <!--        $scope.designation = undefined;-->
    <!--        $scope.sortorder = undefined;-->
    <!--        $scope.discription = undefined;-->
    <!--        $scope.submitForm = function ()-->
    <!--        {-->
    <!--            console.log("posting data....");-->
    <!--            $http({-->
    <!--                method: 'POST',-->
    <!--                url: '--><?php //echo base_url(); ?><!--/admin/pooling/add_designation',-->
    <!--                headers: {'Content-Type': 'application/json'},-->
    <!--                data: JSON.stringify({designation: $scope.designation,sortorder:$scope.sortorder,discription:$scope.discription})-->
    <!--            }).success(function (data) {-->
    <!--                        console.log(data);-->
    <!--                        $scope.message = data.status;-->
    <!--                    });-->
    <!--        }-->
    <!--    }-->

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

