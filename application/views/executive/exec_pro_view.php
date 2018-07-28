 <?php echo $header; ?>
<body>
<div class="wrapper">

 <?php echo $sidebar; ?>

    <div class="content">
        <div class="container-fluid">


            <div class="col-md-12">

                <a  data-target="#designation_modal" data-toggle="modal" class="btn btn-fill btn-rose pull-right" > <!--  <img src="<?php echo base_url(); ?>assets/admin/img/stair2.jpeg" style="height: 50px;"> --> my Status<i
                        class="material-icons">keyboard_arrow_right</i><div
                        class="ripple-container"></div></a>
                <div class="card">
                    <div class="card-header card-header-text" data-background-color="orange">
                        <h4 class="card-title"> Executive Promotion 

                    </div>
                    <div class="card-content">

                        <form method="#" action="#">



                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                   <!--  <label>From Desigination</label> -->
                                    <select class="form-control from" >
                                    <option value="">Select From Desigination</option>
                                        <?php $a=1; foreach ($designations as $key => $dsg) { ?>
                                        <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?>
                                    </select>
                                       <span class="material-input"></span>
                                </div>
                            </div>

                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <!-- <label class="control-label">To Desigination</label> -->
                                    <select class="form-control to" >
                                        <option value="">To Desigination</option>

                                    </select>

                                    <span class="material-input"></span></div>
                            </div>








                            <div class="col-md-4">
                                <button type="submit" id="view" class="btn btn-fill btn-rose view">View</button>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <div class="container-fluid promotion" style="display:none">


            <div class="col-md-12">

                <div class="card">
                    <div class="card-header card-header-text" data-background-color="orange">
                        <h4 class="card-title"> Module 1
                        </h4>

                    </div>

                    <div class="card-content">

                        <form method="#" action="#">



                            <div class="col-md-12">

                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Count</label>
                                            <input type="text" class="form-control count1" name="count1">
                                            <span class="material-input"></span><span class="material-input"></span><span class="material-input"></span></div>

                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Amount</label>
                                            <input type="text" class="form-control promotion_amount1">
                                            <span class="material-input"></span><span class="material-input"></span>
                                            <span class="material-input"></span></div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Period</label>
                                            <input type="text" class="form-control promotion_period1" >
                                            <span class="material-input"></span><span class="material-input"></span>
                                            <span class="material-input"></span></div>
                                    </div>


                                </div>
                            </div>

                            <div class="col-md-12">
                                <h4 class="subttl">Or</h4>
                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Count</label>
                                            <input type="text" class="form-control count2" >
                                            <span class="material-input"></span><span class="material-input"></span><span class="material-input"></span></div>

                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Amount</label>
                                            <input type="text" class="form-control promotion_amount2" >
                                            <!-- <input type="text" class="form-control amount2"> -->
                                            <span class="material-input"></span><span class="material-input"></span>
                                            <span class="material-input"></span></div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Period</label>
                                            <input type="text" class="form-control promotion_period2" >
                                            <span class="material-input"></span><span class="material-input"></span>
                                            <span class="material-input"></span></div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-md-12">
                                <h4 class="subttl">Or</h4>
                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Count</label>
                                            <input type="text" class="form-control count3" >
                                            <span class="material-input"></span><span class="material-input"></span><span class="material-input"></span></div>

                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Amount</label>
                                            <input type="text" class="form-control promotion_amount3" >
                                            <span class="material-input"></span><span class="material-input"></span>
                                            <span class="material-input"></span></div>
                                    </div>


                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Period</label>
                                            <input type="text" class="form-control promotion_period3" >
                                            <span class="material-input"></span><span class="material-input"></span>
                                            <span class="material-input"></span></div>
                                    </div>


                                </div>
                            </div>


                            <div class="col-md-12">
                           

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>



    <div class="container-fluid promotion_teamleader" style="display:none">


            <div class="col-md-12">

                <div class="card">
                    <div class="card-header card-header-text" data-background-color="orange">
                        <h4 class="card-title"> Module 1
                        </h4>

                    </div>

                    <div class="card-content">

                        <form method="#" action="#">



                            <div class="col-md-12">

                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                    <label>&nbsp;</label>
                                    <select class="form-control module" >
                                    <option value="">Select</option>
                                    <?php $a=1; foreach ($module as $key => $dsg) { ?>
                                    <option value="<?= $dsg['id'];?>"><?= $dsg['designation'];?></option> <?php } ?>
                                        </select>
                                       

                              

                                    <span class="material-input"></span>
                                    </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Count</label>
                                            <input type="text" class="form-control count1" name="count1">
                                            <span class="material-input"></span><span class="material-input"></span><span class="material-input"></span></div>

                                    </div>



                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Period</label>
                                            <input type="text" class="form-control promotion_period1" >
                                            <span class="material-input"></span><span class="material-input"></span>
                                            <span class="material-input"></span></div>
                                    </div>


                                </div>
                            </div>

                            <div class="col-md-12">
                            <div class="col-md-5 col-md-offset-7">
                                <h4 class="subttl ">Or</h4>
                                </div>

                                <div class="row">
                                    <div class="col-sm-4">
                                   

                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Count</label>
                                            <input type="text" class="form-control count2" >
                                            <span class="material-input"></span><span class="material-input"></span><span class="material-input"></span></div>

                                    </div>



                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Period</label>
                                            <input type="text" class="form-control promotion_period2" >
                                            <span class="material-input"></span><span class="material-input"></span>
                                            <span class="material-input"></span></div>
                                    </div>


                                </div>
                            </div>
                            <div class="col-md-12">
                                  <div class="col-md-5 col-md-offset-7">
                                <h4 class="subttl ">Or</h4>
                                </div>

                                <div class="row">
                                        <div class="col-sm-4">
                                       

                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Count</label>
                                            <input type="text" class="form-control count3" >
                                            <span class="material-input"></span><span class="material-input"></span><span class="material-input"></span></div>

                                    </div>




                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Period</label>
                                            <input type="text" class="form-control promotion_period3" >
                                            <span class="material-input"></span><span class="material-input"></span>
                                            <span class="material-input"></span></div>
                                    </div>


                                </div>
                            </div>


                            <div class="col-md-12">
                           

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        <?php echo $footer; ?>

        <link href="<?php echo base_url(); ?>assets/admin/css/sumoselect.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>assets/admin/js/sumoslct.js"></script>
        <script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
</body>
  <div id="designation_modal" class="modal fade" role="dialog">
        <div class="modal-dialog">


            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal"></button>
                    <h4 class="modal-title">Status</h4>
                </div>
                <form id="designation_form" class="department_form" method="post" action="">
                <div class="card-content">

                      



                            <div class="col-md-12">

                                <div class="row">

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Count</label>
                                             <?php if($team_leader1['sort_order']>$my_designation['sort_order']){?>
                                            <input type="text" class="form-control counts" name="count1" value="<?php echo $exec_count['exec'];?>">
                                            <?php }
                                            else{?>
                                             <input type="text" class="form-control counts" name="count1" value="<?php echo $my_count['c_id'];?>">
                                            <?php }?>
                                            <span class="material-input"></span><span class="material-input"></span><span class="material-input"></span></div>

                                    </div>
                                    <?php if($team_leader1['sort_order']>$my_designation['sort_order']){?>
                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Amount</label>
                                            <input type="text" class="form-control promotion_amounts" value="<?php echo $my_wallet['total'];?>">
                                            <span class="material-input"></span><span class="material-input"></span>
                                            <span class="material-input"></span></div>
                                    </div>
                                  <?php }?>

                                    <div class="col-sm-4">
                                        <div class="form-group label-floating is-empty">
                                            <label class="">Period</label>
                                            <input type="text" class="form-control promotion_periods"

                                       

                                             value="<?php echo empty($my_period['months_employed'])? '0' : $my_period['months_employed'];?>" >
                                            <span class="material-input"></span><span class="material-input"></span>
                                            <span class="material-input"></span></div>
                                    </div>


                                </div>
                            </div>
                    <div class="modal-footer">
        
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
<script>
    $(document).on("change",".from",function(e) {
        e.preventDefault();
       
        var from = $(this).val();
       // alert(from);
        $.post('<?= base_url(); ?>admin/Executives/get_exec_to_data',{from:from },function(data)
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
</html>