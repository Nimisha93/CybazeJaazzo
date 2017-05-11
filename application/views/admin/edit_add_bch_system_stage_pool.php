<?php  echo $default_assets; ?>

<?php echo $sidebar; ?>
<div class="right_col" role="main" xmlns="http://www.w3.org/1999/html">
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

        <form class="" id='new_pool' method="post" enctype="multipart/form-data>"
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>System Pool Settings<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <h2 style="color:red ">You Have split <label id="split" name="split"><?php $bal= 100- $total_group_persantage['total_persantage'] ; echo $bal ?>%</label> to Any Pool group<small></small></h2>
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="table-responsive tabmargntp30">
                                <div class="col-md-12">



                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Pool Name</label>
                                        <input type="text" placeholder="Pool Name" name="pool_name" id="pool_name" class="form-control validate[required]">
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Allowed Persantage(%)</label>
                                        <input type="text" placeholder="Allowed Persantage(%)" name="allow_persantage" id="allow_persantage" class="form-control validate[required]">
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>No Of Levels</label>
                                        <input type="text" placeholder="No Of Levels" id="no_of_levels" name="no_of_levels" class="form-control validate[required]">
                                    </div>



                                </div>
                                <div class="col-md-12" id="pool_row">

                                    <!--  -->
                                </div>



                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <button type="button" id="add_pool" class="btn btn-primary antosubmit">Add New Pool</button>
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

<!--************************row  end******************************************************************* -->

<?php echo $footer; ?>

<?php if( $pesantage_limit=='over_flow'){ ?>

<script type="text/javascript">

    $(document).ready(function()
    {


        alert("System Pooling Persatage Limit Exceeded")
        window.location="<?php echo base_url(); ?>view_pooling"

    });
</script>

<?php }  ?>

<script type="text/javascript">
    $(document).ready(function(){




//        alert('dhbh');

        // $("#add_pool").disable();

        $('.design_allwed_persantage').change(function(){

            alert("hai");
        })

        $("#no_of_levels").keyup(function()
        {

            var level=$("#no_of_levels").val();
            var new_row='<div><h2></h2> <h2 style="color:green;  ">You Have Split <label id="split" name="split">100%</label> To Any Pool Stage<small></small></h2>';
            for(var i=0; i<level; i++)
            {

                new_row+='<div class="row_persantage"><div class="col-md-6 col-sm-12 col-xs-12 form-group"><label>Select Pool Stage </label>'+
                        '<select id="heard" class="form-control validate[required]" required="" name="designation[]">'+
                        '<?php foreach($stages as $stage) { ?><option value="<?php echo  $stage['id'] ?> "><?php echo  $stage['stage_name'] ?></option><?php  } ?>'+

                        '</select>'+
                        '</div>'+
                        '<div class="col-md-6 col-sm-12 col-xs-12 form-group">'+
                        '<label>Allowed Persantage</label>'+
                        '<input class="form-control validate[required]" rows="3" name="design_allwed_persantage[]" placeholder="Allowed Persantage">'+
                        '<i class="fa fa-trash remove_persantage" ></i></div></div>';
            }
            new_row+='</div>';

            $("#pool_row").html(new_row).show();

//            alert(level);

        });

        //add pool detals ajax function

        $("#add_pool").click(function(e)
        {
            //alert("dshgsh");
            e.preventDefault();

            var data= $("#new_pool").serializeArray();
            $.post('<?= base_url(); ?>/admin/pooling/add_new_bch_stage_pool_data',data,function(data)
            {

                if(data.status)
                {
                    noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                    $('#allow_persantage').val('');
                    $('#no_of_levels').val('');
                    $('#pool_name').val('');

                    window.location = '<?= base_url();?>new_bch_stage_pool';

                }
                else
                {
                    noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                }

            },'json');

        });

        $(document).on('click','.remove_persantage',function()
        {

            $(this).parent().parent().remove();


        })
    });

</script>



</body>
</html>