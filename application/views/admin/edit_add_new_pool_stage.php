<?php

echo $default_assets;

echo $sidebar;

?>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.9.0/ui-bootstrap-tpls.min.js"></script>
<div class="right_col" role="main">
    <div class="">
        
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add New Pool Stage <small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <div class="col-md-12">
                                    <form id="pool_stage" class="form-horizontal Calendar"  action="" role="form" method="post">
                                    <div class="col-md-12">
                                        <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                                            <label>Stage Name</label>
                                            <input type="text" placeholder="Stage Name" name='stage_name' ng-model="designation" id="designation" name="desigination" class="form-control">
                                        </div>
                                        </div>

<div class="col-md-12">
                                        <div class="col-md-4 col-sm-4 col-xs-8 form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" rows="3" name='discription' id="discription" ng-model="discription" name="discription" placeholder="Discription"></textarea>
                                        </div></div>

<div class="col-md-12">
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                            <button type="submit" id="add_stage" class="btn btn-primary antosubmit">Add New Stage</button>
                                        </div>
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






    </div>
</div>

<?php echo $footer  ?>

<script>
    $(document).ready(function()
    {
        $('#add_stage').click(function(e){

            e.preventDefault();


           var data=$("#pool_stage").serializeArray();
            $.post("<?php echo base_url(); ?>admin/Pooling/add_new_pool_stage",data,function(data)
            {

                if(data.status)
                {
                    noty({text:"Successfully add new stage",type: 'success',layout: 'top', timeout: 3000});
                    $('#pool_stage')[0].reset();
                }
                else{
                    noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                    $('#pool_stage')[0].reset();
                }


            },'json')
        })
    })
</script>

