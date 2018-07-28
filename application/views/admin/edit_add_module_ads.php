<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/css/file-browse/dropzone.min.css" rel="stylesheet" />
<style type="text/css">
    span.help-inline-error{
        color: red;
    }
</style>
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">     
        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Service Ad<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <form method="post" action="<?php echo base_url();?>admin/Product/new_module_ads"  name="ad_form" id="ad_form" enctype="multipart/form-data">
                                    <div class="col-md-12">
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Business Type</label>
                                            <select id="add_type" class="form-control " name="ad_type">
                                                <option value="">Select Module</option>
                                                <?php foreach($select['type'] as $type){?>
                                                <option value="<?php echo $type['id'];?>" data-img="<?php echo $type['module_image']?>"><?php echo $type['module_name'];?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 ">
                                            <label>Choose Image</label>
                                            <div class="input-group">
                                                <label class="input-group-btn">
                                                <span class="btn btn-primary">
                                                    Browse&hellip; <input type="file" style="display: none;" name="ad_image">
                                                </span>
                                                </label>
                                                <input type="text" class="form-control"  readonly>
                                            </div>
                                            <br>
                                            <div id="img_cont"></div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                            <input type="submit"   name="add"  id="add_ads" class="btn btn-primary antosubmit"></button>
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
    <div class="clearfix"></div><div id="notifications"></div><input type="hidden" id="position" value="center">
</div>
<?php echo $footer; ?>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/file-browse/dropzone-min.js"></script>
<script>
$(document).on('change', '#add_type',function(){
    var cur = $(this); 
    var image = cur.children('option:selected').data('img');
    var img = '<img src="<?php echo base_url();?>'+image+'" width="50%" height="50%">';
    $('#img_cont').html(img);
});
$(function() {

  $(document).on('change', ':file', function() {
    var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
    input.trigger('fileselect', [numFiles, label]);
  });

  $(document).ready( function() {
      $(':file').on('fileselect', function(event, numFiles, label) {

          var input = $(this).parents('.input-group').find(':text'),
              log = numFiles > 1 ? numFiles + ' files selected' : label;

          if( input.length ) {
              input.val(log);
          } else {
              if( log ) alert(log);
          }

      });
  });  
});
</script>
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
         //Add module service
        var v = jQuery("#ad_form").validate({
            rules: {
                ad_type: {
                    required: true
                },
                ad_image: {
                    required: true
                }

            },
            messages: {
                ad_type: {
                    required: "Please provide a module"
                },
                ad_image: {
                    required: "Please provide an image"
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
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Service Ads Added Successfully </div></div>';
                var effect='zoomIn';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
                setTimeout(function(){
                   location.reload()
                  }, 1500);
              } else{
                var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+data.reason+'</div></div>';
                var effect='fadeInRight';
                $("#notifications").append(center);
                $("#notifications-full").addClass('animated ' + effect);
                refresh_close();
              }
          }
        };
        $('#ad_form').submit(function(e){     
          e.preventDefault();
          if (v.form()) {
            $('.body_blur').show();
            $(this).ajaxSubmit(datas);  
          }          
        });
        //End 
    });
</script>
</body>
</html>