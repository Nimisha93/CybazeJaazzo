<?php
echo $default_assets;

echo $sidebar;

?>
<script src="<?php echo base_url();?>/assets/admin/js/angular.min.js"></script>
<script src="<?php echo base_url();?>/assets/admin/js/ui-bootstrap-tpls.min.js"></script>
<div class="right_col" role="main">
    <div class="">
        
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Executive Promotion Settings<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class=" tabmargntp30">
                                <div class="col-md-12">
                                    <form method="post" action="<?php echo base_url();?>admin/home/exec_setaddins" id="exec_form">
                                        <!-- <form id="desigination" class="form-horizontal Calendar"   ng-controller="FormController" ng-submit="submitForm()" role="form" method="post"> -->
                                        <div class="col-lg-12">
                                            <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                                <label>From Designation</label>
                                                <select name="dsig" class="form-control fromdesg" required="true">
                                                    <option value="">Select</option>
                                                    <?php $a=1; foreach ($designations1 as $key => $dsg) { ?>
                                                    <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-xs-12 form-group"></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12 form-group"></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                                <label>To Designation</label>
                                                <select name="todsig" class="form-control todesg" required="true">
                                                
                                                </select>
                                            </div>
                                        </div>
                                </div>
                                <div class="col-md-12">

                                </div>
                                <div class="col-md-12">

                                    <div class="col-lg-3">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                         <input type="hidden"  name="module" class="form-control module" required="true" value="club_membership" readonly>
                                            <input type="text"  name="module1" class="form-control module" required="true" value="Club Membership" readonly>
<!--                                                  <option>Select</option>
                                                <!-<?php $ss=0; foreach ($modules as $key => $mod) { ?> -->
                                                  <!--  <option value="<?= $mod['id'];?>"><?= $mod['name'] ?></option>
                                                  <?php } ?>
                                               </select>  -->
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="col-lg-12">
                                    <div class="col-lg-4">
                                    <label>Count</label>
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Count</label> -->
                                            <!-- <input type="text" name="co[<?= $ss; ?>]" ng-model="designation" placeholder="Count" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="co[]" ng-model="designation" placeholder="Count per Month" value=""  class="form-control"   required="true">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                    <label>Amount</label>
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Amount</label> -->
                                            <!-- <input type="text" name="am[<?= $ss; ?>]" ng-model="designation" placeholder="Amount" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="am[]" ng-model="designation" placeholder="Amount" value=""  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                   <label>Period/(Month)</label>
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Amount</label> -->
                                            <!-- <input type="text" name="am[<?= $ss; ?>]" ng-model="designation" placeholder="Amount" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="pd[]" ng-model="designation" placeholder="Period/(Month)" value=""  class="form-control">
                                        </div>
                                    </div>
                                        </div>
                                     <div class="text-center" style="margin-bottom: 10px"> or</div>
                                        <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Count</label> -->
                                            <!-- <input type="text" name="co[<?= $ss; ?>]" ng-model="designation" placeholder="Count" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="co[]" ng-model="designation" placeholder="Count Per Month" value=""  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Amount</label> -->
                                            <!-- <input type="text" name="am[<?= $ss; ?>]" ng-model="designation" placeholder="Amount" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="am[]" ng-model="designation" placeholder="Amount" value=""  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Amount</label> -->
                                            <!-- <input type="text" name="am[<?= $ss; ?>]" ng-model="designation" placeholder="Amount" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="pd[]" ng-model="designation" placeholder="Period" value=""  class="form-control">
                                        </div>
                                    </div>

                                </div>


<div class="text-center" style="margin-bottom: 10px"> or</div>
                                        <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Count</label> -->
                                            <!-- <input type="text" name="co[<?= $ss; ?>]" ng-model="designation" placeholder="Count" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="co[]" ng-model="designation" placeholder="Count Per Month" value=""  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Amount</label> -->
                                            <!-- <input type="text" name="am[<?= $ss; ?>]" ng-model="designation" placeholder="Amount" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="am[]" ng-model="designation" placeholder="Amount" value=""  class="form-control">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Amount</label> -->
                                            <!-- <input type="text" name="am[<?= $ss; ?>]" ng-model="designation" placeholder="Amount" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="pd[]" ng-model="designation" placeholder="Period" value=""  class="form-control">
                                        </div>
                                    </div>

                                </div>

</div>

<!--                                    --><?php //$ss=$ss+1; } ?>
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <input type="text" name="ss" hidden="" value="<?= $ss; ?>" id="designation">
                                        <input type="submit" class="btn btn-primary antosubmit" value="Save"></button>
                                    </div>
                                    </form>





<!-- 
        <div class="clearfix"></div>
        <div class="row"> -->
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                         <h2>Team Leader Promotion Settings<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                   <form method="post" action="<?php echo base_url();?>admin/Home/exec_setaddins" id="exec_form1">
                                        <!-- <form id="desigination" class="form-horizontal Calendar"   ng-controller="FormController" ng-submit="submitForm()" role="form" method="post"> -->
                                        <div class="col-lg-12">
                                            <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                                <label>From Designation</label>
                                                <select name="dsig" class="form-control fromdesg1" required="true">
                                                    <option value="">Select</option>
                                                    <?php $a=1; foreach ($team_leader as $key => $dsg) { ?>
                                                    <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?>
                                                </select>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-xs-12 form-group"></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12 form-group"></div>
                                            <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                                                <label>To Designation</label>
                                                <select name="todsig" class="form-control todesg1" required="true">
                                                    <!-- <option value="">Select</option>
                                                    <?php $a=1; foreach ($designations1 as $key => $dsg) { ?>
                                                    <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?> -->
                                                </select>
                                            </div>
                                        </div>
                               
                                <div class="col-md-12">

                                </div>
                                <div class="col-md-12">

                                    <div class="col-lg-3">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
<!--                                          <label>To Designation</label>
 -->                                                <select name="module" class="form-control module" required="true">
                                                    <option value="">Select</option>
                                                    <?php $a=1; foreach ($module as $key => $dsg) { ?>
                                                    <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?>
                                                </select>                                              
                 
                                        </div>
                                    </div>
                                    <div class="col-lg-9">
                                        <div class="col-lg-12">
                                    <div class="col-lg-4">
                                    <label>Count</label>
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Count</label> -->
                                            <!-- <input type="text" name="co[<?= $ss; ?>]" ng-model="designation" placeholder="Count" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="co[]"  placeholder="Count" value=""  class="form-control" data-rule-required="true">
                                        </div>
                                    </div>

                                    <div class="col-lg-4">
                                   <label>Period/(Month)</label>
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Amount</label> -->
                                            <!-- <input type="text" name="am[<?= $ss; ?>]" ng-model="designation" placeholder="Amount" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="pd[]"  placeholder="Period/(Month)"   class="form-control" data-rule-required="true" >
                                        </div>
                                    </div>
                                        </div>
                                        <div class="col-md-12">
                                        <div class="col-md-2"></div>

                                     <div class="text-center col-md-4" style="margin-bottom: 10px"> or</div>
                                     <div class="col-md-4"></div>
                                        </div>
                                        <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Count</label> -->
                                            <!-- <input type="text" name="co[<?= $ss; ?>]" ng-model="designation" placeholder="Count" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="co[]" ng-model="designation" placeholder="Count" value=""  class="form-control">
                                        </div>
                                    </div>
                               
                                    <div class="col-lg-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Amount</label> -->
                                            <!-- <input type="text" name="am[<?= $ss; ?>]" ng-model="designation" placeholder="Amount" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="pd[]" ng-model="designation" placeholder="Period" value=""  class="form-control" >
                                        </div>
                                    </div>

                                </div>


           <div class="col-md-12">
                                        <div class="col-md-2"></div>

                                     <div class="text-center col-md-4" style="margin-bottom: 10px"> or</div>
                                     <div class="col-md-4"></div>
                                        </div>
                                        <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Count</label> -->
                                            <!-- <input type="text" name="co[<?= $ss; ?>]" ng-model="designation" placeholder="Count" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="co[]" ng-model="designation" placeholder="Count" value=""  class="form-control" >
                                        </div>
                                    </div>
                                 
                                    <div class="col-lg-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <!-- <label>Amount</label> -->
                                            <!-- <input type="text" name="am[<?= $ss; ?>]" ng-model="designation" placeholder="Amount" value="" id="designation" class="form-control"> -->
                                            <input type="text" name="pd[]" ng-model="designation" placeholder="Period" value=""  class="form-control">
                                        </div>
                                    </div>

                                </div>

</div>


                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <input type="text" name="ss" hidden="" value="<?= $ss; ?>" id="designation">
                                        <input type="submit" class="btn btn-primary antosubmit" value="Save"></button>
                                    </div>
                                    </form>
                                     </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
  <div id="notifications"></div><input type="hidden" id="position" value="center">
<!--************************rowend******************************************************************* -->




    </div>
</div>

<?php echo $footer  ?>

<script>
   $(document).on("change",".fromdesg",function(e) {
        e.preventDefault();
        var from = $(this).val();
        // alert(from);
        $.post('<?= base_url(); ?>admin/Home/get_exec_to_data',{from:from },function(data)
        {
            if(data.status)
            {
                var opt = '';
                data = data.data.result.res;
                console.log(data);
                for(var i = 0; i<data.length; i++)
                {
                    opt += '<option value="'+data[i].id +'">'+data[i].designation +'</option>';
                }
                var sel = "";
                sel += '<label>To Designation</label>'+
                        '<select>'+opt+'</select>';
                $('.todesg').html(sel);
            }
            else
            {
                noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
            }

        },'json');

    });
   $(document).on("change",".fromdesg1",function(e) {
        e.preventDefault();
        var from = $(this).val();
        // alert(from);
        $.post('<?= base_url(); ?>admin/Home/get_exec_to_data',{from:from },function(data)
        {
            if(data.status)
            {
                var opt = '';
                data = data.data.result.res;
                console.log(data);
                for(var i = 0; i<data.length; i++)
                {
                    opt += '<option value="'+data[i].id +'">'+data[i].designation +'</option>';
                }
                var sel = "";
                sel += '<label>To Designation</label>'+
                        '<select>'+opt+'</select>';
                $('.todesg1').html(sel);
            }
            else
            {
                noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
            }

        },'json');

    });
 $(document).ready(function () {

         var v = jQuery("#exec_form").validate({
        
            submitHandler: function(datas) {
           
                jQuery(datas).ajaxSubmit({
                    
                    dataType : "json",
                    success  :    function(data)
                    {

                    if(data.status)
                    {
                  
                   
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully set a Promotion  </div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        //$('#channel_form').hide();
                        window.location= 'exe-select';
                        //window.location.replace(exe-select);
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
  $(document).ready(function () {

         var v = jQuery("#exec_form1").validate({
        
            submitHandler: function(datas) {
           
                jQuery(datas).ajaxSubmit({
                    
                    dataType : "json",
                    success  :    function(data)
                    {

                    if(data.status)
                    {
                  
                   
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully set a Promotion  </div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        //$('#channel_form').hide();
                       window.location= 'exe-select';
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

