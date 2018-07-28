<?php  echo $default_assets; ?>
<?php echo $sidebar;?>
<style type="text/css">
    span.help-inline-error{
        color: red;
    }
</style>
<div class="right_col" role="main" xmlns="http://www.w3.org/1999/html">
    <div class="">  
        <div class="clearfix"></div>
            <form class="" action="<?= base_url(); ?>/admin/pooling/add_new_pool_data" id='new_pool' method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>New Pool Settings<small></small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <h4 style="color:red ;float: left">You Have split <label id="split" name="split"><?php $bal= 100- $total_persantage['total_percentage'] ; echo $bal ?>%</label> to Any Pool group <small> </small> </h4>
                                    <input type="hidden" name="check_bal" id="check_bal" value="<?php echo $bal; ?>">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="row">
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Pool Name</label>
                                        <input type="text" placeholder="Pool Name" name="pool_name" id="pool_name" class="form-control">
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Allowed Percentage(%)</label>
                                        <input type="number"  onKeyPress="return isNumberKey(event)" placeholder="Allowed Percentage(%)" name="allow_persantage" id="allow_persantage" class="form-control">
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>No of Levels</label>
                                        <input type="text" placeholder="No Of Levels" id="no_of_levels" name="no_of_levels" class="form-control">
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Related To</label><br>
                                         <div class="form-group">
                                       <label><input name="related_to" type="radio" class="related_to" value="CHANNEL_PARTNER">&nbsp;Channel Partner</label> 
                                      <label>   <input name="related_to" type="radio" class="related_to"  value="CUSTOMER">&nbsp;Customer</label> 
                                    </div>
                                    </div>
                                </div>
                                <div class="col-md-12" id="pool_row">

                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                      <div class="row">
                                    <button type="submit" id="add_pool" class="btn btn-primary antosubmit">Add New Pool</button>
                                </div>
                                 </div>
                                <div id="notifications"></div><input type="hidden" id="position" value="center">
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
    $(document).on('keyup','#allow_persantage',function()
    {
        var sum=0;
        var sum = findSum();
    });
    function findSum()
    {
        var sum=0;
        var alp1 = $(document).find('#allow_persantage').val();
        var check = $(document).find('#check_bal').val();

        sum = parseInt(check)-parseInt (alp1);
        if(sum<0)
        {
            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Allowed Percentage has Exceeded the limit</div></div>';
            var effect='fadeInRight';
            $("#notifications").append(center);
            $("#notifications-full").addClass('animated ' + effect);
            refresh_close();
            $("#add_pool").prop('disabled',true);
            $(".allow").prop('disabled',true);
            
        } else{
            $("#add_pool").prop('disabled',false);
            $(".allow").prop('disabled',false);
        }
    }
    $("#no_of_levels").keyup(function()
    {
        var level=$("#no_of_levels").val();
        var new_row='<div><h2></h2> <h2 style="color:green;  ">You Have Split <label id="split" name="split">100%</label> To Any Pool Stage<small></small></h2>';
        for(var i=0; i<level; i++)
        {
            new_row+='<div class="row_persantage"><div class="col-md-6 col-sm-12 col-xs-12 form-group"><label>Select Pool Stage </label><select id="heard" class="form-control validate[required]" required="" name="designation[]"><option value="">Select Stage</option><?php foreach($stages as $stage) { ?><option value="<?php echo  $stage['id'] ?> "><?php echo  $stage['designation'] ?></option><?php  } ?></select></div><div class="col-md-5 col-sm-12 col-xs-12 form-group"><label>Allowed Percentage</label><input class="form-control validate[required] allow" rows="3" name="design_allwed_persantage[]" placeholder="Allowed Percentage"></div><div class="col-md-1 col-sm-12 col-xs-12"><i class="fa fa-trash remove_persantage" style="padding: 27px;"></i></div></div>';
        }
        new_row+='</div>';
        $("#pool_row").html(new_row).show();
    });
    $(document).on('click','.remove_persantage',function()
    {
        $(this).parent().parent().remove();
    })
    //add pool 
    var m = jQuery("#new_pool").validate({
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
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">  New Pool added successfully</div></div>';
                var effect='zoomIn';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
                $('#new_pool')[0].reset();
                $("#pool_row").hide();
                setTimeout(function(){// wait for 5 secs(2)
                       location.reload(); // then reload the page.(3)
                }, 1000);
            }else{
                var regex = /(<([^>]+)>)/ig;
                var body = data.reason;
                var result = body.replace(regex, "");
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                var effect='fadeInRight';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
            }
        }
    };
    $('#new_pool').submit(function(e){     
      e.preventDefault();
      if (m.form()) 
      {
        $('.body_blur').show();
        $(this).ajaxSubmit(datas1);  
      }          
    });
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57 ))
            return false;
        return true;
    }
</script>
<style type="text/css">
 input[type=number]::-webkit-inner-spin-button, 
    input[type=number]::-webkit-outer-spin-button { 
      -webkit-appearance: none; 
      margin: 0; 
    }
</style>
</body>
</html>