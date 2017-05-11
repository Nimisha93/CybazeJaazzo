
<!-- hridya -->

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
                <h2>Add Advertisement<small></small></h2>

 

                  <form  method="post"  name="myForm" id="myForm"  enctype="multipart/form-data" <?php echo form_open_multipart('admin/Advertisement/add_ads') ?> 
                  <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div class="">
                  <div class="table-responsive tabmargntp30">
                    <div class="col-md-12">


                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Tittle</label>
                        <input type="text" placeholder="Tittle"  name="title" id="title" class="form-control" required="true">
                      </div>

                     <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Advertisement Type</label>
                        <input type="text" placeholder="Advertisement Type"   name="type" id="type" class="form-control" required="true">
                      </div>
                      <div class="dropdown">

                      <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                        <label>Sort order</label>
                        <input type="text" placeholder="Priority" name="sort" id="sort" class="form-control" required="true">
                      </div>
                       <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Image</label>
                                            <input type="file" placeholder="Image" name="images" class="form-control" required="true">

                                        </div>

                      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <label>Description</label>
                        <textarea class="form-control" required="true" rows="3" placeholder="Description" name="dis" ></textarea>
                      </div>


                      <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                        <input type="submit"
                         name="add"  id="add_ads" class="btn btn-primary antosubmit"></button>
                      </div>
                    </div>
                  </div>
                </div>
                </div>

              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div>
        <?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/dataTables.fixedHeader.min.js" type="text/javascript"></script>


<script>

    $(document).ready(function() {
        var table = $('#example').DataTable( {
            fixedHeader: {
                header: true,
                footer: true,

            }
        } );

    } );

</script>

        <!--************************row  end******************************************************************* -->




      </div>
    </div>



<!-- Datatables -->

<!--============new customer popup start here=================-->


</body>
</html>
<!-- hridya -->