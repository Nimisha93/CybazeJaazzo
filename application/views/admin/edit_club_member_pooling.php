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
                        <h2>Add Designation<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="table-responsive tabmargntp30">
                                <div class="col-md-12">
                                    <form id="desigination" class="form-horizontal Calendar"   ng-controller="FormController" ng-submit="submitForm()" role="form" method="post">
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Desigination</label>
                                            <input type="text" placeholder="Desigination" name='Desigination' ng-model="designation" id="designation" name="desigination" class="form-control">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Sortorder</label>
                                            <input type="text" placeholder="Sortorder" name='Sortorder' ng-model="sortorder" id="sortorder" name="sortorder" class="form-control">
                                        </div>


                                        <div class="col-md-8 col-sm-8 col-xs-8 form-group">
                                            <label>Discription</label>
                                            <textarea class="form-control" rows="3" name='discription' id="discription" ng-model="discription" name="discription" placeholder="Discription"></textarea>
                                        </div>


                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                            <button type="submit" id="add_designation" class="btn btn-primary antosubmit">Save</button>
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
    $(document)
</script>

