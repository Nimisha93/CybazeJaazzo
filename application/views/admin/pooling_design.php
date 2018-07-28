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
                        <h2>Change password<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <div class="col-md-6">
                                    <form  class="form-horizontal Calendar" name="pass_form" id="pass_form" method="post" action="<?php echo base_url();?>admin/Change_password/change_current_pass">
                                    <div class="col-md-8 col-sm-6 col-xs-12 form-group">
                                      
                                        
                                        <input type="password" placeholder="Current Password" name='old' ng-model="designation" id="old" class="form-control"><br>
                                        
                                        <input type="password" placeholder="New Password" name='new_pass' ng-model="designation" id="new_pass" class="form-control"><br>
                                        
                                        <input type="password" placeholder="Confirm Password" name='confirm_pass' ng-model="designation" id="confirm_pass" class="form-control"><br>
                                        
                                    </div>
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <input type="submit" id="change" name="change" class="btn btn-primary antosubmit"></button>
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

<script type="text/javascript">
        $(document).ready(function() {

            // bind form using ajaxForm
            $('#pass_form').ajaxForm({
                // dataType identifies the expected content type of the server response
                dataType:  'json',

                // success identifies the function to invoke when the server response
                // has been received
                success:   function(data){
                    if(data.status){
                        noty({text: 'Password changed', type: 'success', timeout: 1000 });
                        window.location = "<?php echo base_url();?>admin/Change_password/changepsw";
                    } else {
                        noty({text: data.reason, type: 'error', timeout: 1000 });
                    }

                }
            });
            $('#pro_quantity').on('input',function() {
                calculte_cost();
            });
            $('#pro_actualcost').on('input',function() {
                calculte_cost();
            });
        });
        // function calculte_cost(){
        //     var quantity = isNaN(parseInt($('#pro_quantity').val())) ? 0 : parseInt($('#pro_quantity').val());
        //     var actualcost = isNaN(parseInt($('#pro_actualcost').val())) ? 0 : parseInt($('#pro_actualcost').val());
        //     var sal_one_day = quantity * actualcost;
        //     $("#product_form").find('#pro_cost').val(parseInt(sal_one_day));
        //     var test = inWords(cost);
        //     console.log(test);
        // }

    </script>


    </div>
</div>

<?php echo $footer  ?>

<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>


