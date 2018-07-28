<?php  echo $default_assets; ?>
<?php echo $sidebar; ?>
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
</style>
<div class="right_col" style="max-height: 100vh;overflow: hidden;"  role="main" xmlns="http://www.w3.org/1999/html">
    <div class="">
        <div class="clearfix"></div>
        <form  action="<?= base_url(); ?>/admin/pooling/update_pool_data" id='update_pools' method="post" enctype="multipart/form-data>">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Update Pool Settings<small></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                            
                                <h2 style="color:#ff2520 ">You can split <label id="split" name="split"><?php $bal= 100-$total_persantage['total_percentage'] ; echo $bal ?>%</label> to Any Pool group<small></small></h2>
                                <input type="hidden" name="check_bal" id="check_bal" value="<?php echo $bal; ?>">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="">
                                <div class="row">
                                    <div class="poolbx2">
                                        <div class="pricingTable">
                                            <div class="pricingTable-header"  style="padding-top:10px;">
                                                <table class="table">
                                                    <tr>
                                                        <input type="hidden"  name="main_id" value="<?php echo $id ?>">
                                                        <td  style="border:none;">
                                                            <label style="color: #fff;">Pool Name</label>
                                                            <input type="text"  placeholder="Pool Name" id="pool_name" name="pool_name" value="<?php echo $pooling_details[0]['title']; ?>"  class="form-control validate[required]">
                                                        </td>
                                                        <td  style="border:none;">
                                                            <label style="color: #fff;">Allowed Percentage(%)</label>
                                                            <input type="hidden" class="allow_persantage_old" id="allow_persantage_old" name="allow_persantage_old" value="<?php echo $pooling_details[0]['percentage']; ?>">
                                                            <input type="number" placeholder="Allowed Persantage(%)" id="allow_persantage" value="<?php echo $pooling_details[0]['percentage']; ?>"  name="allow_persantage" class="form-control validate[required]">
                                                        </td>
                                                        <td  style="border:none;">  
                                                            <label style="color: #fff;">No Of Levels</label>
                                                            <input type="number"  placeholder="No of Levels" id="no_of_levels" name="no_of_levels" value="<?php echo $pooling_details[0]['no_of_levels']; ?>"  class="form-control validate[required]">
                                                        </td>
                                                        <td  style="border:none;">  
                                                            <label style="color: #fff;">Related To</label><br>
                                                            <input name="related_to" type="radio" class="related_to" value="CHANNEL_PARTNER" <?php echo ($pooling_details[0]['related_to']=='CHANNEL_PARTNER')?'checked':'';?> >&nbsp;Channel Partner&nbsp;&nbsp; 
                                                            <input name="related_to" type="radio" class="related_to"  value="CUSTOMER" <?php echo ($pooling_details[0]['related_to']=='CUSTOMER')?'checked':'';?>>&nbsp;Customer
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
     
                                            <div class="pricingContent">
                                                <div class="bs-example prctbl">
                                                    <table class="table">
                                                        <tbody class="tablmargntp">
                                                            <tr>
                                                                <div class="col-md-12" id="pool_row">
                                                                    <div class="col-md-offset-10 col-md-2">
                                                                        <button type="button" class="btn btn-primary">
                                                                            <i class="fa fa fa-plus-square-o add_persantage" ></i>
                                                                        </button>
                                                                    </div>    
                                                                    <?php foreach ($pooling_details as $pool_details) {  ?>
                                                                    <div class="row_persantage">
                                                                        <div class="col-md-5 col-sm-12 col-xs-12 form-group">
                                                                            <label>Select Designation</label>
                                                                            <select id="heard" class="form-control validate[required]" required="" name="designation[]">
                                                                                <?php 
                                                                                    foreach($designations as $desigin) { 
                                                                                ?>
                                                                                <option <?= $desigin['id']==$pool_details['designation_id'] ? 'selected' : '';  ?> value="<?php echo  $desigin['id'] ?> "><?php echo  $desigin['designation'] ?></option>
                                                                                <?php  } ?>
                                                                            </select>
                                                                        </div>
                                                                        <div class="col-md-5 col-sm-12 col-xs-12 form-group">
                                                                            <label>Allowed Percentage</label>
                                                                            <input type="hidden" class="allowed_persantage_id" name="allowed_persantage_id[]" value="<?php echo  $pool_details['id'] ?>">

                                                                            <input type="number" class="form-control validate[required] allow" rows="3" name="design_allwed_persantage[]" value="<?php echo  $pool_details['member_persantage'] ?>" placeholder="Allowed Percentage">
                                                                        </div>
                                                                        <label>Action</label>
                                                                        <div class="col-md-2 col-sm-12 col-xs-12 form-group ">
                                                                            <button type="button" class="btn btn-primary remove_persantage">
                                                                                <i class="fa fa-trash" ></i>
                                                                            </button>
                                                                        </div>
                                                                    </div>
                                                                    <?php } ?>
                                                                </div>
                                                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                                    <button type="submit" id="update_pool" name="update_pool" class="btn btn-primary antosubmit">Update  Pool</button>
                                                                </div>
                                                            </tr>
                                                        </tbody>
                                                    </table>
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
        <div id="notifications"></div><input type="hidden" id="position" value="center">
    </div>
</div>
<div class="clearfix"></div>
<?php echo $footer; ?>
<script type="text/javascript">
    $(document).on('click','.add_persantage',function()
    {
        var new_row='<div class="row_persantage"><div class="col-md-5 col-sm-12 col-xs-12 form-group"><label>Select Designation</label>'+
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
                   '<button type="button" class="btn btn-primary remove_persantage">'+
                '<i class="fa fa-trash" ></i>&nbsp&nbsp&nbsp&nbsp'+
                '</button>'+
                '</div></div>';

        var sum=0;

        sum=getsum();
        if(sum>=100)
        {
            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Allowed Persentage is 100%</div></div>';
            var effect='fadeInRight';
            $("#notifications").append(center);
            $("#notifications-full").addClass('animated ' + effect);
            refresh_close();
        }else{
            var new_value=0;
            $("#pool_row").append(new_row);
            var no_levels=$("#no_of_levels").val();
            var  val= parseInt(no_levels);
            new_value=val+1;
            $("#no_of_levels").val(new_value);
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
        return allow_sval;
    }

    $(document).ready(function(){
        getsum();
        sum=getsum();
        if(sum>100)
        {
            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Allowed Persentage is 100%</div></div>';
            var effect='fadeInRight';
            $("#notifications").append(center);
            $("#notifications-full").addClass('animated ' + effect);
            //refresh_close();
            $('.close').click(function(){
                $(this).parent().fadeOut(1000);
            });
            $("#update_pool").prop('disabled',true);
        }
    });
    $(document).on('keyup','.allow',function()
    {
        var sum=0;        
        sum=getsum();
        if(sum>100)
        {
            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Allowed Persentage is 100%</div></div>';
            var effect='fadeInRight';
            $("#notifications").append(center);
            $("#notifications-full").addClass('animated ' + effect);
            // refresh_close();
            $('.close').click(function(){
                $(this).parent().fadeOut(1000);
            });
            $("#update_pool").prop('disabled',true);
        }
        else
        {
            findSum();
            $("#update_pool").prop('disabled',false);
        }
    });
    function findSum()
    {
        var sum=0;
        var alp1 = $(document).find('#allow_persantage').val();
        var alp2 = $(document).find('#allow_persantage_old').val();
        var check = $(document).find('#check_bal').val();
        sum = parseInt(check) +parseInt (alp2-alp1);
        if(sum<0)
        {
            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Allowed Percentage has Exceeded the limit</div></div>';
            var effect='fadeInRight';
            $("#notifications").append(center);
            $("#notifications-full").addClass('animated ' + effect);
            // refresh_close();
             $('.close').click(function(){
                $(this).parent().fadeOut(1000);
            });
            $("#update_pool").prop('disabled',true);
            $(".allow").prop('disabled',true);
            
        }else{
            $("#update_pool").prop('disabled',false);
            $(".allow").prop('disabled',false);
        }
    }
    $(document).on('keyup','#allow_persantage',function()
    {
        var sum=0;
        var sum = findSum();
    });
    $(document).on('click','.remove_persantage',function()
    {
        var cur = $(this);
        var pool_id = cur.parent().parent().parent().find('.allowed_persantage_id').val();
        //alert(pool_id);
        $(this).parent().parent().remove();

        var new_value=0;
        var no_levels=$("#no_of_levels").val();
        var  val= parseInt(no_levels);
        new_value=val-1;
        $("#no_of_levels").val(new_value);
        var data= $("#update_pools").serializeArray();


        $.post('<?= base_url(); ?>delete_pooling_member/'+pool_id,data,function(data)
        {
            if(data.status)
            {
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">  Successfully Deleted</div></div>';
                var effect='zoomIn';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
            } else{
                var regex = /(<([^>]+)>)/ig;
                var body = data.reason;
                var result = body.replace(regex, "");
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                var effect='fadeInRight';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                // refresh_close();
                $('.close').click(function(){
                    $(this).parent().fadeOut(1000);
                });
            }

        },'json');
    })
    //update pool detals ajax function
    var m = jQuery("#update_pools").validate({
        rules: {
            pool_name: {
              required: true
            },
            allow_persantage: {
              required: true
            },
            no_of_levels: {
              required: true
            }
        },
        messages: {
            pool_name: {
              required: "Please provide a Pool Name"
            },
            allow_persantage: {
              required: "Please provide Allow Percentage"
            },
            no_of_levels: {
              required: "Please provide No of Levels"
            }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });
    var datas1 = { 
        dataType : "json",
        success:   function(data){
        $('.body_blur').hide();
            if(data.status)
            {
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text"> Pool updated successfully</div></div>';
                var effect='zoomIn';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
                $('#new_pool')[0].reset();
                $("#pool_row").hide();
                // setTimeout(function(){// wait for 5 secs(2)
                //        location.reload(); // then reload the page.(3)
                // }, 1000);
            }else{
                var regex = /(<([^>]+)>)/ig;
                var body = data.reason;
                var result = body.replace(regex, "");
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                var effect='fadeInRight';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                // refresh_close();
                $('.close').click(function(){
                    $(this).parent().fadeOut(1000);
                });

            }
        }
    };
    $('#update_pools').submit(function(e){     
      e.preventDefault();
      if (m.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas1);  
      }          
    });
    /*$(document).on('click', '#update_pool',function(e)
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
    });*/
</script>
</body>
</html>