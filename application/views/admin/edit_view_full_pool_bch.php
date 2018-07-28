<?php  echo $default_assets; ?>
<?php echo $sidebar; ?>
<div class="right_col" role="main" xmlns="http://www.w3.org/1999/html">
    <div class="">
  
        <div class="clearfix"></div>

        <form class="" id='update_pools' method="post" enctype="multipart/form-data>">

<!--                                        --><?php //} ?>
            <div class="x_title">
                <h2>Bch Pool Settings<small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                    <h2 style="color:red ">You can split <label id="split" name="split"><?php $bal= 100- $total_group_persantage['total_persantage'] ; echo $bal ?>%</label> to Any Pool group<small></small></h2>
                    <input type="hidden" name="check_bal" id="check_bal" value="<?php echo $bal; ?>">
                   
                </ul>
                <div class="clearfix"></div>
            </div>
        <div class="poolbx2">
            <div class="pricingTable">

                <div class="pricingTable-header" style="padding-top:10px;">
                    <table class="table">
                        <tbody><tr>


                            <td style="border:none;">
                                <input type="hidden" name="type" value="<?php echo $type ?>">
                                <input type="hidden" name="main_id" value="<?php echo $id ?>">
                                <label style="color: #fff;">Pool Name</label>
                                <input placeholder="Pool Name" id="pool_name" name="pool_name" value="<?php echo $pooling_details[0]['title']; ?>" class="form-control validate[required]" type="text">

                            </td>

                            <td style="border:none;">
                                <label style="color: #fff;">Allowed Percentage(%)</label>
                                <input  id="allow_persantage_old" value="<?php echo $pooling_details[0]['group_persentage']; ?>" name="allow_persantage_old" class="form-control validate[required]" type="hidden">
                                <input placeholder="Allowed Percentage(%)" id="allow_persantage" value="<?php echo $pooling_details[0]['group_persentage']; ?>" name="allow_persantage" class="form-control validate[required]" type="text"></td>

                            <td style="border:none;">  <label style="color: #fff;">No of Levels</label>
                                <input placeholder="No of Levels" id="no_of_levels" name="no_of_levels" value="<?php echo $pooling_details[0]['no_of_levels']; ?>" class="form-control validate[required]" type="text"></td>

                        </tr>
                        </tbody></table>
                </div>

                <div class="pricingContent">
                    <div class="bs-example prctbl">
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
                                    <input class="form-control validate[required] allow perc_cls" rows="3" name="design_allwed_persantage[]" value="<?php echo  $pool_details['percentage'] ?>" placeholder="Allowed Persantage">
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
                        </div> </div><table class="table">

                        <tbody class="tablmargntp">
                        <tr>






                        </tr>



                        </tbody>

                    </table>
                    </div>
                </div>



                <!-- /  CONTENT BOX-->

                <div class="pricingTable-sign-up">
                </div><!-- BUTTON BOX-->
            </div>

        </form>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!--************************row  end******************************************************************* -->

<?php echo $footer; ?>

<?php //if($pesantage_limit=='over_flow'){ ?>
<!---->
<!--<script type="text/javascript">-->
<!---->
<!--    $(document).ready(function()-->
<!--    {-->
<!---->
<!--        alert("System Pooling Percentage Limit Exceeded")-->
<!--        window.location="--><?php //echo base_url(); ?><!--admin/edit_pooling"-->
<!---->
<!--    });-->
<!--</script>-->
<!---->
<?php //}  ?>

<script type="text/javascript">

    $(document).ready(function(){
        getsum();
//        alert('dhbh');

        // $("#add_pool").disable();

        sum=getsum();
        if(sum>100)
        {
            noty({text: 'Allowed Percentage is 100%', type: 'error',timeout:4000});
            $("#update_pool").prop('disabled',true);
        }
        else
        {


        }

        $('.design_allwed_persantage').change(function()
        {

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
                    '<label>Allowed Percentage</label>'+
                    '<input class="form-control validate[required] allow perc_cls" rows="3"  class="allowed_persantage_id" name="design_allwed_persantage_new[]" placeholder="Allowed Persantage">'+
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
                noty({text: 'Allowed Percentage is 100%', type: 'error',timeout:4000});
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
                $("#update_pool").prop('disabled',false);
            }


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

        function get_perc_sum()
        {
    var sum = 0;
    $('.perc_cls').each(function(){
       // $(this).val();
        var cur_per = isNaN(parseInt($(this).val())) ? 0 : parseInt($(this).val());
        sum +=cur_per;
        //alert(sum);

    });
    return sum;
}

        function findSum()
        {
            var sum=0;
            var alp1 = $(document).find('#allow_persantage').val();
            var alp2 = $(document).find('#allow_persantage_old').val();
            var check = $(document).find('#check_bal').val();

            sum = parseInt(check)+parseInt (alp2-alp1);
            //alert(sum);

            if(sum<0)
            {
                noty({text: 'Allowed Percentage has Exceeded the limit', type: 'error',timeout:4000});
                $("#update_pool").prop('disabled',true);
                $(".allow").prop('disabled',true);

            }
            else
            {

                $("#update_pool").prop('disabled',false);
                $(".allow").prop('disabled',false);
            }
        }

        $(document).on('keyup','#allow_persantage',function()
        {

            var sum=0;
            var sum = findSum();
        });

        $("#update_pool").click(function(e)
        {
            //alert("hello");
            e.preventDefault();
            var summ = get_perc_sum();
           // alert(summ);

            if(summ == 100){
              //  alert("hi");
                var data= $("#update_pools").serializeArray();
                $.post('<?= base_url(); ?>/admin/pooling/update_pool_bch_data',data,function(data)
                {
                    if(data.status)
                    {
                        noty({text:"Successfully Updated",type: 'success',layout: 'top', timeout: 3000});
                        $('#allow_persantage').val('');
                        $('#no_of_levels').val('');
                        $('#pool_name').val('');
                    }
                    else
                    {
                        //noty({text:"fff",type: 'error',layout: 'top', timeout: 3000});
                       noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                    }

                },'json');
            }else{
                noty({text:"sum of allowed percentage should be hundred",type: 'error',layout: 'top', timeout: 3000});
            }


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


            $.post('<?= base_url(); ?>/admin/pooling/delete_system_stage_bch_pooling_group/'+pool_id,data,function(data)
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