<?php echo $default_assets; ?>

<link href="<?php echo base_url();?>assets/admin/css/file-browse/dropzone.min.css" rel="stylesheet" />

</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
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
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Product<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="table-responsive tabmargntp30">
                                <form method="post" action="<?php echo base_url();?>admin/Product/new_module_ads"  name="product_form" id="product_form" enctype="multipart/form-data">
                                    <div class="col-md-12">
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Bussiness Type</label>
                                            <select id="add_type" class="form-control " name="add_type">
                                                <option value="">Select Module</option>
                                                <?php foreach($select['type'] as $type){?>
                                                <option value="<?php echo $type['id'];?>"><?php echo $type['module_name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>


                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Image</label>
                                            <input type="file" placeholder="Image" name="pro_image" class="form-control">

                                        </div>




                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                            <input type="submit"
                                                   name="add"  id="add_ads" class="btn btn-primary antosubmit"></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

    </div>
    <div class="clearfix"></div>

    <!--************************row  end******************************************************************* -->

    <!--script type="text/javascript">
        $(document).ready(function(){

            $('#prosubmit').click(function(e){
                e.preventDefault();
                var sta = $("#product_form").validationEngine("validate");
                if(sta== true){

                    var cur= $(this);
                    var data=$("#product_form").serializeArray();
                    $('.body_blur').show();

                    $.post('<?php echo base_url();?>admin/Product/new_product_add', data, function(data){
                        $('.body_blur').hide();

                        if(data.status){
                            noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                            $('#product_form')[0].reset();
                        }
                        else{
                            noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                        }

                    },'json');
                }

            });

        });
    </script-->
    <script type="text/javascript">
        $(document).ready(function() {
            // bind form using ajaxForm
            $('#product_form').ajaxForm({
                // dataType identifies the expected content type of the server response
                dataType:  'json',

                // success identifies the function to invoke when the server response
                // has been received
                success:   function(data){
                    if(data.status){

                        noty({text: 'Product Added', type: 'success', timeout: 1000 });
                        window.location = "<?php echo base_url();?>Ads";
                    } else {
                        noty({text: data.reason, type: 'error', timeout: 1000 });
                    }

                }
            });
            $('#pro_quantity').on('input',function() {
                calculte_cost();
            });
            $('#pro_actualcost').on('input',function() {
                calculte_cost();
            });
        });
        function calculte_cost(){
            var quantity = isNaN(parseInt($('#pro_quantity').val())) ? 0 : parseInt($('#pro_quantity').val());
            var actualcost = isNaN(parseInt($('#pro_actualcost').val())) ? 0 : parseInt($('#pro_actualcost').val());
            var sal_one_day = quantity * actualcost;
            $("#product_form").find('#pro_cost').val(parseInt(sal_one_day));
            var test = inWords(cost);
            console.log(test);
        }

    </script>


</div>

<script>
    $(document).ready(function() {
        //set initial state.
        $('#textbox1').val($(this).is(':checked'));

        $('#checkbox1').change(function() {
            $('#textbox1').val($(this).is(':checked'));
        });

        $('#checkbox1').click(function() {
            if (!$(this).is(':checked')) {
                return confirm("Are you sure?");
            }
        });
    });
</script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/file-browse/dropzone-min.js"></script>

<?php echo $footer; ?>


<!-- Datatables -->

<!--============new customer popup start here=================-->


</body>
</html>