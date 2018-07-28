<?php  echo $default_assets; ?>
<?php echo $sidebar; ?>
<div class="right_col" role="main" xmlns="http://www.w3.org/1999/html">
    <div class="">
        
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







                                </div>
                                <div class="col-md-12" id="pool_row">

                                    <!--  -->
                                </div>

                                <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                    <label>BA Main Pesantage %</label>
                                    <input type="text" placeholder="BA Main Pesantage %" name="ba_persantage" id="ba_persantage" class="form-control validate[required]">
                                </div>

                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <button type="button" id="add_stage_pooling" class="btn btn-primary antosubmit">Add System Stage Pool </button>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                    <button type="button" id="add_ba_group_pooling" class="btn btn-primary antosubmit">Add System Group Pool</button>
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
        window.location="<?php echo base_url(); ?>view_ba_pooling"

    });
</script>

<?php }  ?>

<script type="text/javascript">
    $(document).ready(function(){
          //get ba pooling
        $.post("<?php echo base_url(); ?>/admin/pooling/get_ba_commision",function(data)
        {

                $("#ba_persantage").val(data.vals)

        },'json');
         //update the ba main persantage
        $("#ba_persantage").keyup(function()
        {
          //  $(".body_blur").show();
           // alert($("#ba_persantage").val());
            var commision =$("#ba_persantage").val();

            $.post('<?php echo base_url(); ?>admin/pooling/add_ba_commision',{comission:commision},function(data)
            {

               if(data)
               {
                   noty({text:data.reason,type: 'success',layout: 'top', timeout: 3000});
               }
                else
               {
                   noty({text:'Something Went Wrong',type: 'error',layout: 'top', timeout: 3000});
               }

            });
        });
        $('.design_allwed_persantage').change(function(){

            alert("hai");
        })

        $("#no_of_levels").keyup(function()
        {
            var level=$("#no_of_levels").val();
            var new_row='<div><h2></h2> <h2 style="color:green;  ">You Have Split <label id="split" name="split">100%</label> To Any Sales Designation Types<small></small></h2>';
            for(var i=0; i<level; i++)
            {

                new_row+='<div class="row_persantage"><div class="col-md-6 col-sm-12 col-xs-12 form-group"><label>Select Designation</label>'+
                        '<select id="heard" class="form-control validate[required]" required="" name="designation[]">'+
                        '<?php foreach($designations as $desigin) { ?><option value="<?php echo  $desigin['id'] ?> "><?php echo  $desigin['designation'] ?></option><?php  } ?>'+

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
            $.post('<?= base_url(); ?>/admin/pooling/add_new_pool_data',data,function(data)
            {
                if(data.status)
                {
                    noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                    $('#allow_persantage').val('');
                    $('#no_of_levels').val('');
                    $('#pool_name').val('');

                    window.location = '<?= base_url();?>admin/pooling/new_pool';

                }
                else
                {
                    noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                }

            },'json');

        });

        $("#add_ba_group_pooling").click(function(e)
        {

            window.location="<?php echo base_url(); ?>new_ba_group_pool"


        })

        $("#add_stage_pooling").click(function(e)
        {

            window.location="<?php echo base_url(); ?>new_ba_stage_pool"


        })

        $(document).on('click','.remove_persantage',function()
        {

            $(this).parent().parent().remove();


        })
    });

</script>



</body>
</html>