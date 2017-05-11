<?php
echo $default_assets;

echo $sidebar;

?>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.9.0/ui-bootstrap-tpls.min.js"></script>
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
                        <h2>Select Designation<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <div class="col-md-6">
                                    <form action="<?php echo base_url();?>admin/executives/exec_setview" class="form-horizontal Calendar" method="post">
                                    <div class="col-md-8 col-sm-6 col-xs-12 form-group">
                                        <!-- <label>Desigination</label> -->
                                        <!-- <input type="text" placeholder="Desigination" name='Desigination' ng-model="designation" id="designation" name="desigination" class="form-control"> -->
                                        
                                        <select name="dsig" required="true" class="form-control">
                                        <option value="">Select</option>
                                        <?php $a=1; foreach ($designations as $key => $dsg) { ?>
                                        <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?>
                                        </select>
                                    </div><div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <button type="submit" id="view_settings" name="view" class="btn btn-primary antosubmit">View</button>
                                    </div>
                                <form>
                                </div>
                                <div class="col-md-6">
                                    <form id="desigination" class="form-horizontal Calendar" ng-controller="FormController" ng-submit="submitForm()" role="form" method="post">
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <a href="<?php echo base_url();?>exe-settings-add">
                                        <button type="button" name="add" class="btn btn-primary antosubmit">Add Executives Promotion Setting</button></a>
                                    </div>
                                <form>
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

