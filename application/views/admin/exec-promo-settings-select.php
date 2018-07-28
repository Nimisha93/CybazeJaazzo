<?php
echo $default_assets;

echo $sidebar;

?>
<style type="text/css">
    div#pomotion {
    height: auto !IMPORTANT;
    border: 1px solid #dadada;
    float: left;
    padding-top: 10px;
}
div#promotion_teamleader {
    border: 1px solid #e2e2e2;
    float: left;
    padding-top: 10px;
}
.line{height: 1px;background-color: #ccc;margin-top: 20px;margin-bottom: 20px;}
</style>
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
                        <h2>View Promotions<small></small></h2>
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
                                    
                                   
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">

                                        <label>From Desigination</label>
                                       
                                        
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
  <form method="post" action="<?php echo base_url();?>admin/Home/exec_seteditins" id="exec_form1">
   <input type="hidden"  id="id" name="id" class="form-control id">
    <input type="hidden"  id="from" name="dsig" class="form-control from">
     <input type="hidden"  id="to" name="to" class="form-control to">
        <div  class="promotion" id="pomotion" style="display:none">
            <div class="clearfix"> </div>
                <div class="col-lg-12">
                 <!--    <div class="col-md-3 col-sm-6 col-xs-12 form-group"></div> -->
                    <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                        <label>From Designation</label>
                        <input type="text" placeholder="Desigination" name="Desigination" ng-model="designation" id="designation" name="desigination" class="form-control desig">
                    </div>
                   
                    <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                        <label>To Designation</label>
                        <input type="text" placeholder="Desigination" name="Desigination" ng-model="designation" id="designation" name="desigination" class="form-control promo">
                    </div>
                     <div class="col-md-3 col-sm-6 col-xs-12 form-group"></div>
                </div>
                <div class="clearfix"></div>
                <div class="line "></div>
 <div class="clearfix"></div>
                <div class="col-md-12">
                    <div class="col-lg-3">
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                         <div class="row">
                             <label>&nbsp;</label>
                            <input type="text"  name="module" class="form-control" required="true" value="Club Membership" readonly>
                        </div> </div>
                    </div>
                    <div class="col-lg-9">
                    <div class="row">
                        <div class="col-lg-3">
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                            <label>Count</label>
                            
                                <input type="text" name="co" ng-model="designation" placeholder="Count" value=""  class="form-control count1 count">
                            </div>
                        </div>
                    
                    <div class="col-lg-3">
                          <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                        <label>Amount</label>
                      
                            <input type="text" name="am" ng-model="designation" placeholder="Amount" value=""  class="form-control promotion_amount1 amount">
                        </div>
                    </div>
                    <div class="col-lg-3">
                         <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                     <label>Period</label>
                       
                           <input type="text" name="pd" ng-model="designation" placeholder="Period/(Month)" value=""  class="form-control promotion_period1 period">
                        </div>
                    </div>
                    <div class="col-lg-1">
                     <label></label><br>
                     
          <button  class="btn btn-simple btn-info btn-icon edit1 edit" data-id="" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                     </div>



                    </div>
                    </div>
                </div>    
                                     
                <div class="col-md-1"></div>
                    <div class="col-md-11">
                        <div class="text-center" style="margin-bottom: 10px"> or </div>
                    </div>
                    <div class="col-md-12">
                    <div class="col-lg-3">
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                            </div>
                        </div>
                    <div class="col-lg-9">
                        <div class="row">
                        <div class="col-lg-3">
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                
                                <input type="text" name="co2" ng-model="designation" placeholder="Count" value=""  class="form-control count2 count">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                               
                                <input type="text" name="am2" ng-model="designation" placeholder="Amount" value=""  class="form-control promotion_amount2 amount">
                            </div>
                        </div>
                        <div class="col-lg-3">
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                
                                <input type="text" name="pd2" ng-model="designation" placeholder="Period" value=""  class="form-control promotion_period2 period">
                            </div>
                        </div>
                        <div class="col-lg-1">
                <button class="btn btn-simple btn-info btn-icon edit2 edit" data-id=""><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                     </div>
                    </div>
                     </div>
                     </div>
                    <div class="col-md-1"></div>
                    <div class="col-md-11">
                        <div class="text-center" style="margin-bottom: 10px"> or </div>
                    </div>



                     <div class="col-md-12">
                    <div class="col-lg-3">
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                            </div>
                        </div>
                <div class="col-lg-9">
                    <div class="row">
                    <div class="col-lg-3">
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                            
                            <input type="text" name="co3" ng-model="designation" placeholder="Count" value=""  class="form-control count3 count">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                
                            <input type="text" name="am3" ng-model="designation" placeholder="Amount" value=""  class="form-control promotion_amount3 amount">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                          
                            <input type="text" name="pd3" ng-model="designation" placeholder="Period" value=""  class="form-control promotion_period3 period">
                        </div>
                    </div>
                    <div class="col-lg-1">
                     

               <button class="btn btn-simple btn-info btn-icon edit3 edit" data-id=""><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                     </div>
                </div>
                 </div>
                  </div>
<!--                 <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                    <input type="submit" class="btn btn-primary antosubmit" value="Update"></button>
                </div> -->
               </div>
                 </form>
       
                               

<!--************************rowend******************************************************************* -->
 
   <div  class="promotion_teamleader" id="promotion_teamleader" style="display:none">
    <form method="post" action="<?php echo base_url();?>admin/executives/exec_seteditins_team" id="exec_form">
        <div class="clearfix" ></div>
            
            <input type="hidden"  id="id" name="id" class="form-control id">
                <input type="hidden"  id="dsig" name="dsig" class="form-control from">
                <input type="hidden"  id="to" name="to" class="form-control to">
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
                     <!-- <input type="text" name="promo_id" ng-model="promo_id" placeholder="promo_id" value=""  class="form-control promo_id"> -->
                    <div class="col-md-12">
                        <div class="col-lg-3">
                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">

                          <label>&nbsp;</label>

                                <select name="module1" class="form-control module" required="true">
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
                                        <input type="text" name="cot" ng-model="designation" placeholder="Countt" value=""  class="form-control count1 count">

                                    </div>
                                </div>
                                    <div class="col-lg-4">
                                       <label>Period/(Month)</label>
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <input type="text" name="pdt" ng-model="designation" placeholder="Period/(Month)" value=""  class="form-control promotion_period1 period">
                                        </div>
                                    </div>
                                    <br>
                                 <button  class="btn btn-simple btn-info btn-icon edit1 editt" data-id="" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button></i></a>
                        
                       </div>
                    <div class="col-md-12">

                    <div class="col-md-9 col-offest-md-3">
                        <div class="text-center" style="margin-bottom: 10px;margin-left: -45px"> or</div>
                    </div> 

                    </div>

                     <div class="col-md-12">

                                    <div class="col-lg-4">
                                        
                                            <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                               <input type="text" name="cot2" ng-model="designation" placeholder="Count" value=""  class="form-control count2 count">
                                            </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <input type="text" name="pdt2" ng-model="designation" placeholder="Period" value=""  class="form-control promotion_period2 period">
                                        </div>
                                    </div>
                                    <button  class="btn btn-simple btn-info btn-icon edit2 editt" data-id="" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                           
                        </div>
                    <div class="col-lg-12">
                             <div class="col-md-9 col-offest-md-3">
                        <div class="text-center" style="margin-bottom: 10px;margin-left: -45px"> or</div>
                    </div> 
                                 </div>

                                 <div class="col-lg-12">
                                    <div class="col-lg-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <input type="text" name="cot3" ng-model="designation" placeholder="Count" value=""  class="form-control count3 count">
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="col-md-12 col-sm-6 col-xs-12 form-group">
                                            <input type="text" name="pdt3" ng-model="designation" placeholder="Period" value=""  class="form-control promotion_period3 period">
                                        </div>
                                    </div>
                                     <button  class="btn btn-simple btn-info btn-icon edit3 editt" data-id="" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                </div>
                        </div>
                         </div>
                    <!--     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                            <input type="submit" class="btn btn-primary antosubmit" value="Save">
                        </div> -->
                    </div>
             </form>
            </div>

            </div>
            </div>
            </div>
            </div>

                <div id="designation_modal" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"></button>
                                <h4 class="modal-title">Update</h4>
                            </div>
                            <form id="designation_form" class="department_form" method="post" action="">
                                <div class="modal-body">
                                <div class="row">
                                <input type="hidden" class="promo_id form-control" id="promo_id" name="promo_id">
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Count</label>
                                        <input type="text" class="count form-control" id="count" name="count">
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-xs-12 form-
                                    group">
                                        <label>Amount</label>
                                        <input type="text" class="form-control amount" id="amount" name="amount">
                                    </div>
                                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>period</label>
                                        <input type="text" class="form-control period" id="period" name="period">
                                    </div>

                                        </div> 
                                      
                                        </div>


                                    <div class="col-md-12 col-sm-12 col-xs-12" style="border-top: 1px solid darkgray;padding: 10px;">
                                        <input type="submit" id="edit_designation" class=" pull-right btn btn-primary edit_designation" >
                                        <button type="button" class="btn btn-default  pull-right" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>


                  <div id="designation_modal1" class="modal fade" role="dialog">
                    <div class="modal-dialog">
                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal"></button>
                                <h4 class="modal-title">Update</h4>
                            </div>
                            <form id="designation_form1" class="department_form" method="post" action="">
                                <div class="modal-body">
                                <div class="row">
                                 <input type="hidden" class="promo_id form-control" id="promo_id" name="promo_id">
                                    <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label>Count</label>
                                        <input type="text" class="count form-control" id="count" name="count">
                                    </div>
            

                                      <div class="col-md-6 col-sm-6 col-xs-12 form-group">
                                        <label>period</label>
                                        <input type="text" class="form-control period" id="period" name="period">
                                    </div>

                                        </div> 
                                      
                                        </div>


                                    <div class="col-md-12 col-sm-12 col-xs-12" style="border-top: 1px solid darkgray;padding: 10px;">
                                        <input type="submit" id="edit_designation" class=" pull-right btn btn-primary edit_designation" >
                                        <button type="button" class="btn btn-default  pull-right" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>                 
        



  <div id="notifications"></div><input type="hidden" id="position" value="center">
  <?php echo $footer  ?>



<script>
    $(document).on("change",".from",function(e) {
        e.preventDefault();
        var from = $(this).val();
       // alert(from);
        $.post('<?= base_url(); ?>admin/Home/get_exec_to',{from:from },function(data)
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
     
        e.preventDefault();
        var from = $('.from').val();
        var to = $('.to').val();
       
        var data= $("#desigination").serializeArray();
        $.post('<?= base_url(); ?>admin/Home/get_promotion_view',{from:from ,to:to},function(data)
        {
            if(data.status)
            {

             data=data.data;
             //console.log(data[1]);
             var id=data[0]['id'];
             var desig=data[0]['desg'];
             var promo=data[0]['promo'];
             var module=data[0]['sysmodule_id'];
             

             //alert(promotion_amount2);
             //console.log(module);
             if(module == 1)
              {
                 $(".promotion").show();
                 $(".promotion_teamleader").hide();
                

                 var count1=data[0]['count'];
                if(data[1] && data[2]){
                  
                    var count2=data[1]['count'];
                    var promotion_period2=data[1]['period'];
                    var promotion_amount2=data[1]['amount'];
                    var de_id2=data[1]['det_id'];
                    var count3=data[2]['count'];
                    var promotion_period3=data[2]['period'];
                    var promotion_amount3=data[2]['amount'];
                    var de_id3=data[2]['det_id'];
                 }
                else if(data[1]){
                   
                    var count2=data[1]['count'];
                    var promotion_period2=data[1]['period'];
                    var promotion_amount2=data[1]['amount'];
                    var de_id2=data[1]['det_id'];

                 }
                 else if(data[2]){
                    var count3=data[2]['count'];
                    var promotion_period3=data[2]['period'];
                    var promotion_amount3=data[2]['amount'];
                    var de_id3=data[2]['det_id'];
                 }

                 else{
                   
                    var count2='';
                    var promotion_period2='';
                    var promotion_amount2='';
                    var count3='';
                    var promotion_period3='';
                    var promotion_amount3='';
                    var de_id3='';
                 }
                // var count3=data[2]['count'];
                 var promotion_period1=data[0]['period'];
                
                 //var promotion_period3=data[2]['period'];
                 var promotion_amount1=data[0]['amount'];
                 
                 //var promotion_amount3=data[2]['amount'];
                 var de_id1=data[0]['det_id'];
                
                 
                 $('.id').val(id);
                 $('.from').val(from);
                 $('.to').val(to);
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
                 $('.edit1').attr("data-id", de_id1);
                 $('.edit2').attr("data-id", de_id2);
                 $('.edit3').attr("data-id", de_id3);
                }
             else{
             
             $(".promotion_teamleader").show();
             $(".promotion").hide();

          


             var count1=data[0]['count'];
            if(data[1] && data[2]){
                   
                    var count2=data[1]['count'];
                    var promotion_period2=data[1]['period'];
                    var promotion_amount2=data[1]['amount'];
                    var de_id2=data[1]['det_id'];
                    var count3=data[2]['count'];
                    var promotion_period3=data[2]['period'];
                    var promotion_amount3=data[2]['amount'];
                    var de_id3=data[2]['det_id'];
                 }
             else if(data[1]){
               
                var count2=data[1]['count'];
                var promotion_period2=data[1]['period'];
                var promotion_amount2=data[1]['amount'];
                var de_id2=data[1]['det_id'];
             }
             else if(data[2]){
                var count3=data[2]['count'];
                var promotion_period3=data[2]['period'];
                var promotion_amount3=data[2]['amount'];
                var de_id3=data[2]['det_id'];
             }
             else{
               
                var count2='';
                var promotion_period2='';
                var promotion_amount2='';
             }


             var count1=data[0]['count'];
           /*  var count2=data[1]['count'];
             var count3=data[2]['count'];*/
             var promotion_period1=data[0]['period'];
            /* var promotion_period2=data[1]['period'];
             var promotion_period3=data[2]['period'];*/
             var promotion_amount1=data[0]['amount'];
           /*  var promotion_amount2=data[1]['amount'];
             var promotion_amount3=data[2]['amount'];*/
             var de_id1=data[0]['det_id'];
        /*     var de_id2=data[1]['det_id'];
             var de_id3=data[2]['det_id'];*/
             $('.id').val(id);
             $('.from').val(from);
             $('.to').val(to);
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
             $('.edit1').attr("data-id", de_id1);
             $('.edit2').attr("data-id", de_id2);
             $('.edit3').attr("data-id", de_id3);
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
      $(document).on('click', '.edit',function () {
        var cur = $(this);
        var des_id = cur.data('id');
        if(des_id!=''){
        var amount = cur.parent().parent().parent().find('.amount').val();
        var period = cur.parent().parent().parent().find('.period').val();
        var count  = cur.parent().parent().parent().find('.count').val();
  
        $('#designation_modal').modal('show');
        $('#designation_form').find('.count').val(count);
        $('#designation_form').find('.amount').val(amount);
        $('#designation_form').find('.period').val(period);
        var up_form = '<?= base_url();?>admin/Home/update_promotion/'+des_id;
        $("#designation_form").attr("action", up_form);
        var v = jQuery("#designation_form").validate({
        rules: {
            amount: {
              required: true
            },
            period: {
              required: true
            },
            count: {
              required: true
            },

        },
        messages: {
            amount: {
              required: "Please provide a Amount"
            },
            period: {
              required: "Please provide a Period"
            },
            count: {
              required: "Please provide Sort Count"
            },

        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    }
    else{
        var prom_id = cur.parent().parent().parent().parent().parent().parent().find('.id').val();
        var amount = cur.parent().parent().parent().find('.amount').val();
        var period = cur.parent().parent().parent().find('.period').val();
        var count  = cur.parent().parent().parent().find('.count').val();
  
        $('#designation_modal').modal('show');
        $('#designation_form').find('.promo_id').val(prom_id);
        $('#designation_form').find('.count').val(count);
        $('#designation_form').find('.amount').val(amount);
        $('#designation_form').find('.period').val(period);
        var up_form = '<?= base_url();?>admin/Home/update_add_promotion/';
        $("#designation_form").attr("action", up_form);
        var v = jQuery("#designation_form").validate({
        rules: {
            amount: {
              required: true
            },
            period: {
              required: true
            },
            count: {
              required: true
            },

        },
        messages: {
            amount: {
              required: "Please provide a Amount"
            },
            period: {
              required: "Please provide a Period"
            },
            count: {
              required: "Please provide Sort Count"
            },

        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    }
    var datas2 = { 
        dataType : "json",
        success:   function(data){
        $('.body_blur').hide();
            if(data.status)
            {
                $('#designation_modal').modal('hide');
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Promotion updated successfully</div></div>';
                var effect='zoomIn';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
            }else{
                var regex = /(<([^>]+)>)/ig;
                var body = data.reason;
                var result = body.replace(regex, "");
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                var effect='fadeInRight';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
            }
        }
    };
    $('#designation_form').submit(function(e){     
      e.preventDefault();
      if (v.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas2);  
      }          
    });

    });
        $(document).on('click', '.editt',function () {
        var cur = $(this);
        var des_id = cur.data('id');
        if(des_id!=''){
        //var amount = cur.parent().parent().parent().find('.amount').val();
        var period = cur.parent().find('.period').val();
        var count  = cur.parent().find('.count').val();
     
        $('#designation_modal1').modal('show');

        
        $('#designation_form1').find('.count').val(count);
        $('#designation_form1').find('.amount').val(amount);
        $('#designation_form1').find('.period').val(period);
        var up_form = '<?= base_url();?>admin/Home/update_promotion1/'+des_id;
        $("#designation_form1").attr("action", up_form);
        var v = jQuery("#designation_form1").validate({
        rules: {
            amount: {
              required: true
            },
            period: {
              required: true
            },
            count: {
              required: true
            },

        },
        messages: {
            amount: {
              required: "Please provide a Amount"
            },
            period: {
              required: "Please provide a Period"
            },
            count: {
              required: "Please provide Sort Count"
            },

        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    }
    else{
        var period = cur.parent().find('.period').val();
        var count  = cur.parent().find('.count').val();
        var prom_id = cur.parent().parent().parent().parent().find('.id').val();
        
        $('#designation_modal1').modal('show');
        $('#designation_form1').find('.promo_id').val(prom_id);
        $('#designation_form1').find('.count').val(count);
        $('#designation_form1').find('.amount').val(amount);
        $('#designation_form1').find('.period').val(period);
        var up_form = '<?= base_url();?>admin/Home/update_add_promotion1/';
        $("#designation_form1").attr("action", up_form);
        var v = jQuery("#designation_form1").validate({
        rules: {
            amount: {
              required: true
            },
            period: {
              required: true
            },
            count: {
              required: true
            },

        },
        messages: {
            amount: {
              required: "Please provide a Amount"
            },
            period: {
              required: "Please provide a Period"
            },
            count: {
              required: "Please provide Sort Count"
            },

        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });  
    }    
    var datas2 = { 
        dataType : "json",
        success:   function(data){
        $('.body_blur').hide();
            if(data.status)
            {
                $('#designation_modal1').modal('hide');
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Promotion updated successfully</div></div>';
                var effect='zoomIn';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
            }else{
                var regex = /(<([^>]+)>)/ig;
                var body = data.reason;
                var result = body.replace(regex, "");
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                var effect='fadeInRight';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
            }
        }
    };





    $('#designation_form1').submit(function(e){     
      e.preventDefault();
      if (v.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas2);  
      }          
    });

    });
</script>