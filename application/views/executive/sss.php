<?php
echo $default_assets;

echo $sidebar;

?>
<script src="http://ajax.googleapis.com/ajax/libs/angularjs/1.2.8/angular.min.js"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/angular-ui-bootstrap/0.9.0/ui-bootstrap-tpls.min.js"></script>
<div class="right_col" role="main">
    <div class="">
        <div class="page-title">
            
            <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">

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
                        <button type="button" class="btn btn-primary editsub pull-right"><a href="<?php echo base_url();?>exe-settings-add">Set Promotion</a></button>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <div class="col-md-12">
                                    <form method="post" action="<?php echo base_url();?>admin/executives/exec_seteditins" id="exec_form1">
                                    <input type="hidden"  id="id" name="id" class="form-control id">
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label>From Desigination</label>
                                        <!-- <input type="text" placeholder="Desigination" name='Desigination' ng-model="designation" id="designation" name="desigination" class="form-control"> -->
                                        
                                        <select name="dsig" required="true" class="form-control from">
                                        <option value="">Select</option>
                                        <?php $a=1; foreach ($designations as $key => $dsg) { ?>
                                        <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?>
                                        </select>
                                    </div>
                                        <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                            <label>To Designation</label>
                                            <!-- <input type="text" placeholder="Desigination" name='Desigination' ng-model="designation" id="designation" name="desigination" class="form-control"> -->

                                            <select name="to" required="true" class="form-control to">
                                                <option value="">Select</option>
                                                <?php $a=1; foreach ($designations as $key => $dsg) { ?>
                                                <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <button type="submit" id="view" name="view" class="btn btn-primary antosubmit">View</button>
                                    </div>
                              
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div  class="promotion" id="pomotion" style="display:none">
            <div class="clearfix" ></div>
                <div class="col-lg-12">
                    <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                        <label>From Designation</label>
                        <input type="text" placeholder="Desigination" name='Desigination' ng-model="designation" id="designation" name="desigination" class="form-control desig">
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 form-group"></div>
                    <div class="col-md-3 col-sm-6 col-xs-12 form-group"></div>
                    <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                        <label>To Designation</label>
                        <input type="text" placeholder="Desigination" name='Desigination' ng-model="designation" id="designation" name="desigination" class="form-control promo">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="col-lg-3">
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">

                            <input type="text"  name="module" class="form-control" required="true" value="Club Membership" readonly>
                        </div>
                    </div>
                    <div class="col-lg-9">
                        <div class="col-lg-4">
                            <label>Count</label>
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                <input type="text" name="co" ng-model="designation" placeholder="Count" value=""  class="form-control count1">
                            </div>
                        </div>
                    
                    <div class="col-lg-4">
                        <label>Amount</label>
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                            <input type="text" name="am" ng-model="designation" placeholder="Amount" value=""  class="form-control promotion_amount1">
                        </div>
                    </div>
                    <div class="col-lg-4">
                     <label>Period/(Month)</label>
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                           <input type="text" name="pd" ng-model="designation" placeholder="Period/(Month)" value=""  class="form-control promotion_period1">
                        </div>
                    </div>
                    </div>
                </div>    
                                     
                <div class="text-center" style="margin-bottom: 10px"> or</div>
                    <div class="col-lg-12">
                        <div class="col-lg-4">
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                
                                <input type="text" name="co2" ng-model="designation" placeholder="Count" value=""  class="form-control count2">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                               
                                <input type="text" name="am2" ng-model="designation" placeholder="Amount" value=""  class="form-control promotion_amount2">
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                
                                <input type="text" name="pd2" ng-model="designation" placeholder="Period" value=""  class="form-control promotion_period2">
                            </div>
                        </div>
                    </div>
                <div class="text-center" style="margin-bottom: 10px"> or</div>
                <div class="col-lg-12">
                    <div class="col-lg-4">
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                            
                            <input type="text" name="co3" ng-model="designation" placeholder="Count" value=""  class="form-control count3">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                
                            <input type="text" name="am3" ng-model="designation" placeholder="Amount" value=""  class="form-control promotion_amount3 ">
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                          
                            <input type="text" name="pd3" ng-model="designation" placeholder="Period" value=""  class="form-control promotion_period3">
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                    <input type="submit" class="btn btn-primary antosubmit" value="Update"></button>
                </div>
        </div>
                               

 <!--************************rowend******************************************************************* -->
   <div  class="promotion_teamleader" id="promotion_teamleader" style="display:none">
        <div class="clearfix" ></div>
            
            <input type="hidden"  id="id" name="id" class="form-control id">
                <div class="col-lg-12">
                    <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                        <label>From Designation</label>
                        <input type="text" placeholder="Desigination" name='Desigination' ng-model="designation" id="designation" name="desigination" class="form-control desig">
                    </div>
                    <div class="col-md-3 col-sm-6 col-xs-12 form-group"></div>
                    <div class="col-md-3 col-sm-6 col-xs-12 form-group"></div>
                    <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                        <label>To Designation</label>
                        <input type="text" placeholder="Desigination" name='Desigination' ng-model="designation" id="designation" name="desigination" class="form-control promo">
                    </div>
                    </div>
                    <div class="col-md-12">
                        <div class="col-lg-3">
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                <select name="module" class="form-control module" required="true">
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
                                        <input type="text" name="co" ng-model="designation" placeholder="Count" value=""  class="form-control count1">
                                    </div>
                                </div>
                                    <div class="col-lg-4">
                                       <label>Period/(Month)</label>
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <input type="text" name="pd" ng-model="designation" placeholder="Period/(Month)" value=""  class="form-control promotion_period1">
                                        </div>
                                    </div>
                                
                                <div class="text-center" style="margin-bottom: 10px"> or</div>
                                    <div class="col-lg-12">
                                        <div class="col-lg-4">
                                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                               <input type="text" name="co2" ng-model="designation" placeholder="Count" value=""  class="form-control count2">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <input type="text" name="pd2" ng-model="designation" placeholder="Period" value=""  class="form-control promotion_period2">
                                        </div>
                                    </div>
                           
                        </div>
                            <div class="text-center" style="margin-bottom: 10px"> or</div>
                                <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <input type="text" name="co3" ng-model="designation" placeholder="Count" value=""  class="form-control count3">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <input type="text" name="pd3" ng-model="designation" placeholder="Period" value=""  class="form-control promotion_period3">
                                        </div>
                                    </div>
                                </div>
                        </div>
                         </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <input type="submit" class="btn btn-primary antosubmit" value="Save">
                        </div>
                    </div>
                </form>
            </div>



<?php echo $footer  ?>

<script>
    $(document).on("change",".from",function(e) {
        e.preventDefault();
        var from = $(this).val();
       // alert(from);
        $.post('<?= base_url(); ?>admin/Executives/get_exec_to',{from:from },function(data)
        {
            if(data.status)
            {
                var opt = '';
                data = data.data.result.res;
                //console.log(data);
                 for(var i = 0; i<data.length; i++)
                 {
                     opt += '<option value="'+data[i].id +'">'+data[i].designation +'</option>';
                 }
                 var sel = "";
                 sel += '<label>To Designation</label>'+
                        '<select>'+opt+'</select>';
                $('.to').html(sel);
            }
            else
            {
                noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
            }

        },'json');

    });

</script>
    <script type="text/javascript">
    $("#view").click(function(e)
    {
       /* alert("dshgsh");*/
        e.preventDefault();
        var from = $('.from').val();
        var to = $('.to').val();
       
        var data= $("#desigination").serializeArray();
        $.post('<?= base_url(); ?>admin/Executives/get_promotion_view',{from:from ,to:to},function(data)
        {
            if(data.status)
            {

             data=data.data;
             var id=data['id'];
             var desig=data['desg'];
             var promo=data['promo'];
             var count1=data['promotion_count'];
             var count2=data['promotion_count2'];
             var count3=data['promotion_count3'];
             var promotion_period1=data['promotion_period'];
             var promotion_period2=data['promotion_period2'];
             var promotion_period3=data['promotion_period3'];
             var promotion_amount1=data['promotion_amount'];
             var promotion_amount2=data['promotion_amount2'];
             var promotion_amount3=data['promotion_amount3'];
             var module=data['sysmodule_id'];
             //console.log(module);
             if(module == 1)
             {
             $(".promotion").show();
             $(".promotion_teamleader").hide();
             $('.id').val(id);
             $('.desig').val(desig);
             $('.promo').val(promo);
             $('.count1').val(count1);
             $('.count2').val(count2);
             $('.count3').val(count3);
             $('.promotion_period1').val(promotion_period1);
             $('.promotion_period2').val(promotion_period2);
             $('.promotion_period3').val(promotion_period3);
             $('.promotion_amount1').val(promotion_amount1);
             $('.promotion_amount2').val(promotion_amount2);
             $('.promotion_amount3').val(promotion_amount3);
             }
             else{
             $('.id').val(id);
             $(".promotion_teamleader").show();
             $(".promotion").hide();
             $('.desig').val(desig);
             $('.promo').val(promo);
             $('.count1').val(count1);
             $('.count2').val(count2);
             $('.count3').val(count3);
             $('.promotion_period1').val(promotion_period1);
             $('.promotion_period2').val(promotion_period2);
             $('.promotion_period3').val(promotion_period3);
             $('.promotion_amount1').val(promotion_amount1);
             $('.promotion_amount2').val(promotion_amount2);
             $('.promotion_amount3').val(promotion_amount3);
             $('.module').val(module);
             }

        
            
   /* */
            }
            else
            {
                noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
            }

        },'json');

    });    
    </script>
    <script type="text/javascript">
     $(document).ready(function () {

         var v = jQuery("#exec_form1").validate({
        
            submitHandler: function(datas) {
           alert(v);
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