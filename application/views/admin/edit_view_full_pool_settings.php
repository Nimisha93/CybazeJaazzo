<?php  echo $default_assets; ?>
<?php echo $sidebar; ?>

<div class="right_col" role="main" xmlns="http://www.w3.org/1999/html">
    <div class="">
        
        <div class="clearfix"></div>

        <form class="" id='update_pools' method="post" enctype="multipart/form-data>">
           <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">

                        <h2>View &  Edit  Pool<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                        <?php echo validation_errors(); ?>
                        
                            <h2 style="color:#ff2520 ">You can split <label id="split" name="split"><?php $bal= 100- $total_group_persantage['total_persantage'] ; echo $bal ?>%</label> to Any Pool group<small></small></h2>
                            <input type="hidden" name="check_bal" id="check_bal" value="<?php echo $bal; ?>">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
<!--                            <div class="table-responsive tabmargntp30">
<!--                                <div class="col-md-12">-->
<!---->
<!--<input type="hidden" name="type" value="--><?php //echo $type ?><!--">-->
<!--                                       <input type="hidden"  name="main_id" value="--><?php //echo $id ?><!--">-->
<!--                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">-->
<!--                                        <label>Pool Name</label>-->
<!--                                        <input type="text" placeholder="Pool Name" name="pool_name" id="pool_name" value="--><?php //echo $pooling_details[0]['title']; ?><!--" class="form-control validate[required]">-->
<!--                                    </div>-->
<!---->
<!--                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">-->
<!--                                        <label>Allowed Persantage(%)</label>-->
<!--                                        <input type="text" placeholder="Allowed Persantage(%)" name="allow_persantage" id="allow_persantage" value="--><?php //echo $pooling_details[0]['group_persentage']; ?><!--" class="form-control validate[required]">-->
<!--                                    </div>-->
<!--                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">-->
<!--                                        <label>No Of Levels</label>-->
<!--                                        <input type="text" placeholder="No Of Levels" id="no_of_levels" name="no_of_levels" value=" --><?php //echo $pooling_details[0]['no_of_levels']; ?><!--"  class="form-control validate[required]">-->
<!--                                    </div>-->
<!---->
<!---->
<!---->
<!--                                </div>-->
<!--                                <div class="col-md-12" id="pool_rssow">-->
<!---->
<!--                                    --><?php //foreach ($pooling_details as $pool_details) {  ?>
<!--                                    <div class="row_persantage"><div class="col-md-5 col-sm-12 col-xs-12 form-group"><label>Select Designation</label>-->
<!--                                        <select id="heard" class="form-control validate[required]" required="" name="designation[]">-->
<!--                                            --><?php //echo json_encode($designations); foreach($designations as $desigin) { ?><!--<option --><?//= $desigin['id']==$pool_details['id'] ? 'selected' : '';  ?><!-- value="--><?php //echo  $desigin['id'] ?><!-- ">--><?php //echo  $desigin['designation'] ?><!--</option>--><?php // } ?>
<!---->
<!--                                            </select>-->
<!--                                        </div>-->
<!--                                        <div class="col-md-5 col-sm-12 col-xs-12 form-group">-->
<!--                                            <label>Allowed Persantage</label>-->
<!--                                            <input type="hidden" class="allowed_persantage_id" name="allowed_persantage_id[]" value="--><?php //echo  $pool_details['id'] ?><!--">-->
<!--                                            <input class="form-control validate[required] allow" rows="3" name="design_allwed_persantage[]" value="--><?php //echo  $pool_details['member_persantage'] ?><!--" placeholder="Allowed Persantage">-->
<!--                                            </div>-->
<!--                                        <label>Action</label>-->
<!--                                    <div class="col-md-2 col-sm-12 col-xs-12 form-group ">-->
<!---->
<!--                                        <i class="fa fa-trash remove_persantage" ></i>-->
<!--                                        <i class="fa fa fa-plus-square-o add_persantage" ></i>-->
<!--                                    </div>-->
<!--                                    </div>-->
<!---->
<!---->
<!--                                        --><?php //} ?>
<!--                                    <!--  -->
<!--                                </div>-->
<!---->
<!---->
<!---->
<!--                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">-->
<!--                                    <button type="submit" id="update_pool" name="update_pool" class="btn btn-primary antosubmit">Update  Pool</button>-->
<!--                                </div>
<!--                            </div-->


                             <div class="row">
        <div class="poolbx2">
            <div class="pricingTable">
             
                <div class="pricingTable-header"  style="padding-top:10px;">
                <table class="table">
                         <tr>
                             <input type="hidden"  name="main_id" value="<?php echo $id ?>">
                             <input type="hidden"  id="type" name="type" value="<?php echo $type; ?>" >
                <td  style="border:none;">
                <label style="color: #fff;">Pool Name</label>
       <input type="text"  placeholder="Pool Name" id="pool_name" name="pool_name" value="<?php echo $pooling_details[0]['title']; ?>"  class="form-control validate[required]">
     
       </td>

                <td  style="border:none;">
                 <label style="color: #fff;">Allowed Percentage(%)</label>
                 <input type="hidden" class="allow_persantage_old" id="allow_persantage_old" name="allow_persantage_old" value="<?php echo $pooling_details[0]['group_persentage']; ?>">
                <input type="text" placeholder="Allowed Persantage(%)" id="allow_persantage" value="<?php echo $pooling_details[0]['group_persentage']; ?>"  name="allow_persantage" class="form-control validate[required]"></td>

                    <td  style="border:none;">  <label style="color: #fff;">No Of Levels</label>
                    <input type="text"  placeholder="No of Levels" id="no_of_levels" name="no_of_levels" value=" <?php echo $pooling_details[0]['no_of_levels']; ?>"  class="form-control validate[required]"></td>


            </tr>
           </table>
                </div>
 
                <div class="pricingContent">
                    <div class="bs-example prctbl">
   <table class="table">
 
        <tbody class="tablmargntp">
            <tr>

                <div class="col-md-12" id="pool_row">

                    <?php foreach ($pooling_details as $pool_details) {  ?>
                    <div class="row_persantage"><div class="col-md-5 col-sm-12 col-xs-12 form-group"><label>Select Designation</label>
                        <select id="heard" class="form-control validate[required]" required="" name="designation[]">
                            <?php echo json_encode($designations); foreach($designations as $desigin) { ?><option <?= $desigin['id']==$pool_details['id'] ? 'selected' : '';  ?> value="<?php echo  $desigin['id'] ?> "><?php echo  $desigin['designation'] ?></option><?php  } ?>

                        </select>
                    </div>
                        <div class="col-md-5 col-sm-12 col-xs-12 form-group">
                            <label>Allowed Percentage</label>
                            <input type="hidden" class="allowed_persantage_id" name="allowed_persantage_id[]" value="<?php echo  $pool_details['id'] ?>">

                            <input class="form-control validate[required] allow" rows="3" name="design_allwed_persantage[]" value="<?php echo  $pool_details['member_persantage'] ?>" placeholder="Allowed Percentage">
                        </div>
                        <label>Action</label>
                        <div class="col-md-2 col-sm-12 col-xs-12 form-group ">
                       <button type="button" class="btn btn-primary">
                            <i class="fa fa-trash remove_persantage" ></i>
                            </button>
                            <button type="button" class="btn btn-primary">
                            <i class="fa fa fa-plus-square-o add_persantage" ></i>
                            </button>
                            
                        </div>
                    </div>


                    <?php } ?>
                    <!--  -->
                </div>



                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                    <button type="submit" id="update_pool" name="update_pool" class="btn btn-primary antosubmit">Update  Pool</button>
                </div>
            </tr>
           
            
           
        </tbody>

    </table>
</div>
                </div>
                
                
                
                <!-- /  CONTENT BOX-->
 
                <div class="pricingTable-sign-up">
                </div><!-- BUTTON BOX-->
            </div>
        </div>
        
            
        
        </div>
    </div>
</div>
 
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        </form>
        
        
    </div>
</div>
<div class="clearfix"></div>



                        </div>
                    </div>
                </div>

            </div>
        </div>
        </form>
    </div>
</div>
<div class="clearfix"></div>

<!--************************row  end******************************************************************* -->

<?php echo $footer; ?>

<script type="text/javascript">

    $(document).ready(function(){
        getsum();


        sum=getsum();
        if(sum>100)
        {

            noty({text: 'Allowed Persentage is 100%', type: 'error',timeout:4000});
            $("#update_pool").prop('disabled',true);
        }
        else
        {


        }

        $('.design_allwed_persantage').change(function(){

            alert("hai");
        });

        $(document).on('click','.add_persantage',function()
        {
           // alert("sdvks nd");
            ///var cur=this()
           // var new_row='';
          var   new_row='<div class="row_persantage"><div class="col-md-5 col-sm-12 col-xs-12 form-group"><label>Select Designation</label>'+
                    '<select id="heard" class="form-control validate[required]" required="" name="designation_new[]">'+
                    '<?php foreach($designations as $desigin) { ?><option value="<?php echo  $desigin['id'] ?> "><?php echo  $desigin['designation'] ?></option><?php  } ?>'+

                    '</select>'+
                    '</div>'+
                    '<div class="col-md-5 col-sm-12 col-xs-12 form-group">'+
                    '<label>Allowed Persantage</label>'+
                    '<input class="form-control validate[required] allow" rows="3" name="new_designation_persantage[]" placeholder="Allowed Percentage">'+
                    '</i></div></div>';

            new_row+='<label>Action</label>'+
                    '<div class="col-md-2 col-sm-12 col-xs-12 form-group ">'+
                   '<button type="button" class="btn btn-primary">'+
                '<i class="fa fa-trash remove_persantage" ></i>&nbsp&nbsp&nbsp&nbsp'+
				'</button>'+
				'<button type="button" class="btn btn-primary">'+
                '<i class="fa fa fa-plus-square-o add_persantage" ></i>'+
				'</button>'+
                '</div></div>';

                  var sum=0;

                  sum=getsum();
            if(sum>=100)
            {
                noty({text: 'Allowed Persentage is 100%', type: 'error',timeout:4000});
            }
            else
            {
                var new_value=0;
                $("#pool_row").append(new_row);
                var no_levels=$("#no_of_levels").val();
               var  val= parseInt(no_levels);
                 new_value=val+1;
                $("#no_of_levels").val(new_value);
            }




            //console.log($('.allow').length);

        });

        $(document).on('keyup','.allow',function()
        {

            var sum=0;
            
            sum=getsum();
            if(sum>100)
            {
                noty({text: 'Allowed Percentage is 100%', type: 'error',timeout:4000});
                $("#update_pool").prop('disabled',true);
            }
            else
            {
                 findSum();
                //noty({text: 'not reached Allowed Percentage', type: 'error',timeout:4000});
                $("#update_pool").prop('disabled',false);
            }


        });
        // allow_persantage

        function findSum()
        {
            var sum=0;
            var alp1 = $(document).find('#allow_persantage').val();
            var alp2 = $(document).find('#allow_persantage_old').val();
            var check = $(document).find('#check_bal').val();
           // alert(check);
             sum = parseInt(check) +parseInt (alp2-alp1);
              if(sum<0)
            {
                noty({text: 'Allowed Percentage has Exceeded the limit', type: 'error',timeout:4000});
                $("#update_pool").prop('disabled',true);
                $(".allow").prop('disabled',true);
                
            }
            else
            {
               // noty({text: 'not reached Allowed Percentage', type: 'error',timeout:4000});
                $("#update_pool").prop('disabled',false);
                 $(".allow").prop('disabled',false);
            }
        }

         $(document).on('keyup','#allow_persantage',function()
        {

            var sum=0;
            var sum = findSum();
        });

        function getsum()
        {
          var allow_sval=0
            $('.allow').each(function(){
                var val=$(this).val();
                var vals = isNaN(parseInt(val)) ? 0 : parseInt(val);
                val= parseInt(val);

                allow_sval+=vals;

            });
            console.log(allow_sval);
            return allow_sval;
        }



        //add pool detals ajax function

        $(document).on('click', '#update_pool',function(e)
        {
            //alert("dshgsh");
            e.preventDefault();
          
            var data= $("#update_pools").serializeArray();
            console.log(data);
            
            $.post('<?= base_url(); ?>/admin/pooling/update_pool_data',data,function(data)
            {
                if(data.status)
                {
                    noty({text:"Successfully updated",type: 'success',layout: 'top', timeout: 3000});
                   // $('#allow_persantage').val('');
                   // $('#no_of_levels').val('');
                   // $('#pool_name').val('');

                  //  window.location = '--><?//= base_url();?><!--admin/pooling/new_pool';

                }
                else
                {
                    noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                }

            },'json');

        });

        $(document).on('click','.remove_persantage',function()
        {

            var cur = $(this);
            var pool_id = cur.parent().parent().find('.allowed_persantage_id').val();
            //alert(pool_id);
            $(this).parent().parent().remove();

            var new_value=0;
            var no_levels=$("#no_of_levels").val();
            var  val= parseInt(no_levels);
            new_value=val-1;
            $("#no_of_levels").val(new_value);
           var data= $("#update_pools").serializeArray();


            $.post('<?= base_url(); ?>/admin/pooling/delete_system_stage_pooling_group/'+pool_id,data,function(data)
            {
                if(data.status)
                {
                    noty({text:"Successfully deleted",type: 'success',layout: 'top', timeout: 3000});
                    


                }
                else
                {
                    noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                }

            },'json');




})

    });

</script>



</body>
</html>