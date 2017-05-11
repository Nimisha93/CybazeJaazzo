<?php echo $default_assets; ?>
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
                        <h2>Add Channel Partner Business Type<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="table-responsive tabmargntp30">
                                <form method="post" name="type_form" id="type_form">
                                    <div class="col-md-12">
                                        <div class="col-md-10 col-sm-6 col-xs-12 form-group">
                                            <label>Select Category</label>
                                            <select id="channel_type" class="form-control validate[required] " name="category">
                                                <option value="0">none</option>
                                                <?php
                                                foreach($category['type'] as $type){?>
                                                    <option value="<?php echo $type['id'];?>"><?php echo $type['title'];?></option>
                                                    <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-10 col-sm-6 col-xs-12 form-group">
                                            <label>Title</label>
                                            <input type="text" placeholder="Title" name="title" class="form-control validate[required]">
                                        </div>
<!--                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">-->
<!--                                            <label>Image</label>-->
<!--                                            <input type="file" placeholder="Image" name="userfile" id="userfile" class="form-control">-->
<!---->
<!--                                        </div>-->
                                        <div class="col-md-10 col-sm-12 col-xs-12 form-group">
                                            <label>Description</label>
                                            <textarea class="form-control" title="description" name="description" rows="3" placeholder="Description" class="form-control validate[required]"></textarea>
                                        </div>

                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                            <button type="button" class="btn btn-primary typesubmit" name="type_submit" id="type_submit">Save</button>
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

    <script type="text/javascript">
        $(document).ready(function(){

            $('#type_submit').click(function(e){
                e.preventDefault();
                var sta = $("#type_form").validationEngine("validate");
                if(sta== true){

                    var cur= $(this);
                    var data=$("#type_form").serializeArray();
                    $('.body_blur').show();

                    $.post('<?php echo base_url();?>admin/Product/new_category', data, function(data){
                        $('.body_blur').hide();

                        if(data.status){
                            noty({text:"Successfully created",type: 'success',layout: 'top', timeout: 3000});
                            $('#type_form')[0].reset();
                        }
                        else{
                            noty({text:data.reason,type: 'error',layout: 'top', timeout: 3000});
                        }

                    },'json');
                }

            });

        });
    </script>


</div>
<?php echo $footer; ?>


<!-- Datatables -->

<!--============new customer popup start here=================-->


</body>
</html>