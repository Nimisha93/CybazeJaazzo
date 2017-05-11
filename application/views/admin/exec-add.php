<?php
echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/sumo-select/sumoselect.css" rel="stylesheet" />

  <?php echo $map['js']; ?>
  <script type="text/javascript">
    function getPosition(newLat, newLng)
    {
      $('#lat').val(newLat);
      $('#long').val(newLng);
    }
  </script>

<?php echo $sidebar; ?>
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
                        <h2>Add Executives<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <div class="col-md-12">
                                    <form action="<?php echo base_url();?>admin/executives/exec_addins" class="form-horizontal Calendar" method="post">
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Name</label>
                                        <input type="text" placeholder="Name" name='ename' ng-model="designation" id="designation" class="form-control">
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Desigination</label>
                                        <!-- <input type="text" placeholder="Desigination" name='Desigination' ng-model="designation" id="designation" name="desigination" class="form-control"> -->
                                        <select name="dsig" class="form-control search-box-open-up search-box-sel-all">
                                        <option value="">Select designation</option>
                                        <?php $a=1; foreach ($designations as $key => $dsg) { ?>
                                        <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?>
                                        </select>
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Email</label>
                                        <input type="text" placeholder="Email" name='email' ng-model="designation" id="designation" class="form-control">
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Mobile</label>
                                        <input type="number" placeholder="Mobile" name='mob' ng-model="designation" id="designation" class="form-control">
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Country</label>
                                            <select name="country" class="form-control search-box-open-up search-box-sel-all" id="sel_country">
                                            <option value="">Select Country</option>
                                            <?php foreach ($countries as $key => $country) { ?>
                                            <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                                            <?php } ?>
                                            </select>
                                    </div>

                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>State</label>
                                            <select name="state" class="validate[required] form-control sel_state select_box_sel" id="sel_state">
                                            <option value="">Select State</option>                                       
                                            </select>
                                        </div>
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <label>Address</label>
                                            <textarea class="form-control" id="descriptext" placeholder="address" name="address"></textarea>
                                        </div>

                                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                            <label>Latitude*</label>
                                            <input type="text" placeholder="Latitude" id="lat" name="latt" class="form-control validate[required]">
                                        </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                            <label>Longitude*</label>
                                            <input type="text" placeholder="Longitude" id="long" name="long" class="form-control validate[required]">
                                        </div>

                                        <div class="col-md-12">
                                        <?php echo $map['html']; ?>
                                        <br>
                                        </div>

                                    <!-- <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Name</label>
                                        <input type="text" placeholder="Fax" name='fax' ng-model="designation" id="designation" class="form-control">
                                    </div> -->
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                <input type="text" name='fax' hidden="" value="0">
                                    <button type="submit" id="view_settings" name="submit" class="btn btn-primary antosubmit">Submit</button>
                                    </div>
                                <form>
                                </div>
                                <!-- <div class="col-md-6">
                                    <form id="desigination" class="form-horizontal Calendar" ng-controller="FormController" ng-submit="submitForm()" role="form" method="post">
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <a href="<?php echo base_url();?>exe-settings-add"><button type="button" name="add" class="btn btn-primary antosubmit">Add Executives Promotion Setting</button></a>
                                    </div>
                                <form>
                                </div> -->
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
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        window.asd = $('.SlectBox').SumoSelect({ csvDispCount: 3, captionFormatAllSelected: "Yeah, OK, so everything." });
        window.test = $('.testsel').SumoSelect({okCancelInMulti:true, captionFormatAllSelected: "Yeah, OK, so everything." });
        window.testSelAll = $('.testSelAll').SumoSelect({okCancelInMulti:true, selectAll:true });
        window.testSelAlld = $('.SlectBox-grp').SumoSelect({okCancelInMulti:true, selectAll:true });

        window.testSelAll2 = $('.testSelAll2').SumoSelect({selectAll:true });


        window.Search = $('.search-box').SumoSelect({ csvDispCount: 3, search: true, searchText:'Enter here.' });
        window.searchSelAll = $('.search-box-sel-all').SumoSelect({ csvDispCount: 3, selectAll:true, search: true, searchText:'Enter here.', okCancelInMulti:true });
        window.searchSelAll = $('.search-box-open-up').SumoSelect({ csvDispCount: 3, selectAll:true, search: false, searchText:'Enter here.', up:true });

        window.groups_eg_g = $('.groups_eg_g').SumoSelect({selectAll:true, search:true });
    });
</script>
<?php echo $footer  ?>
 <script type="text/javascript">
        $(document).on('change', '#sel_country',function(){
          var cur = $(this); 
          var country = cur.val();
          $('.body_blur').show();
          $.post('<?php echo base_url();?>admin/Channel_partner/get_state_by_id/'+country, function(data){
            $('.body_blur').hide();
            if(data.status)
            {
              var data = data.data;
              var option ='';
               option += '<option value="">Please Select</option>';
             for(var i=0; i<data.length; i++){
                option += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
             }
              $('.sel_state').html(option);
            } else{
              noty({text: data.reason, type:error, timeout:1000});
            }
          },'json');
        });
    </script>
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

