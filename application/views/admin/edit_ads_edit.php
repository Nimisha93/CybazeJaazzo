<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/css/file-browse/dropzone.min.css" rel="stylesheet" />
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Update Advertisement<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="tabmargntp30">
                                <form method="post" action="<?php echo base_url();?>admin/Advertisement/edit_ads_byid/<?=$adss['id'];?>" name="update_ads" id="update_ads" enctype="multipart/form-data">
                                    <div class="col-md-12">
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Name</label>
                                            <input type="text" placeholder="Name" name="name" class="form-control" value="<?=$adss['title'];?>">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Sort Order</label>
                                            <input type="text" placeholder="Sort Order" name="sort" class="form-control" value="<?=$adss['sort_order'];?>">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group" style="height: 65px">
                                            <label>Type</label>
                                            <br>
                                            <label style="margin-right: 5px;">
                                                <input type="radio" value="left" name="type" <?= $adss['type']=='left'?'checked':''; ?> >Left
                                            </label>
                                            <label style="margin-right: 5px;">
                                                <input type="radio" value="center" name="type" <?= $adss['type']=='center'?'checked':''; ?>>Middle
                                            </label>
                                            <label style="margin-right: 5px;">
                                                <input type="radio" value="right" name="type" <?= $adss['type']=='right'?'checked':''; ?>>Right
                                            </label>
                                            <label style="margin-right: 5px;">
                                                <input type="radio" value="bottom" name="type" <?= $adss['type']=='bottom'?'checked':''; ?>>Bottom
                                            </label>
                                        </div>
                                        <div class="col-md-4 col-sm-3 col-xs-12">
                                            <label>Choose image</label><br>
                                            <div id="imagePreview">
                                                <img src="<?php echo base_url();?>upload\<?= $adss['image'];?>" style="max-width:100%;height:160px">
                                            </div>
                                            <input id="uploadFile" type="file" name="image" class="img btn btn-danger" />
                                            <div class="clear"></div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                            <input type="submit" class="btn btn-primary prosubmit pull-right" name="prosubmit" id="prosubmit" value="Update Changes">
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
    <div id="notifications"></div><input type="hidden" id="position" value="center">
    <div class="clearfix"></div>
    <!--************************row  end******************************************************************* -->
</div>
</div>
</div>
</div>
</div>
<?php echo $footer; ?>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/file-browse/dropzone-min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
        //update
        var v = jQuery("#update_ads").validate({
            rules: {
                name: {
                    required: true
                },
                sort: {
                    required: true
                },
                type: {
                    required: true
                }

            },
            messages: {
                name: {
                    required: "Please provide a name field"
                },
                sort: {
                    required: "Please provide sort order field"
                },
                type: {
                    required: "Please provide a type"
                }
            },
            errorElement: "span",
            errorClass: "help-inline-error",
        });

        var datas = { 
            dataType : "json",
            success:   function(data){
              $('.body_blur').hide();
              if(data.status){
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully updated </div></div>';
                var effect='zoomIn';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
              } else{
                var regex = /(<([^>]+)>)/ig;
                var body = data.reason;
                var result = body.replace(regex, "");
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                var effect='fadeInRight';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
              }
          }
        };
        $('#update_ads').submit(function(e){  
          $('.body_blur').show();   
          e.preventDefault();
          if (v.form()) {
            $(this).ajaxSubmit(datas);  
          }          
        });
    });
    $(function() {
        $("#uploadFile").on("change", function()
        {
            var files = !!this.files ? this.files : [];
            if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
            if (/^image/.test( files[0].type)){ // only image file
                var reader = new FileReader(); // instance of the FileReader
                reader.readAsDataURL(files[0]); // read the local file

                reader.onloadend = function(){ // set image data as background of div
                    $("#imagePreview").css("background-image", "url("+this.result+")");
                }
            }
        });
    });
</script>
</body>
</html>