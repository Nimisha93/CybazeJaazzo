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
                <h2>Add Advertisement<small></small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                  </ul>
                <div class="clearfix"></div>
              </div>
              <form  method="post"  name="myForm" id="myForm"  enctype="multipart/form-data" action="<?php echo base_url();?>admin/Advertisement/add_default_ads" >
                <div class="x_content">
                  <div class="">
                    <div class="table-responsive tabmargntp30">
                      <div class="col-md-12">
                        <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                          <label>Tittle</label>
                          <input type="text" placeholder="Tittle" value="<?php echo $ads['title'] ?>" name="title" id="title" class="form-control">
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 ">
                          <label>Choose Image</label><br>
                           <img src="<?php echo base_url().$ads['image'];?>" style="max-width:100%;height:160px">
                          <div class="input-group">
                            <label class="input-group-btn">


                              <span class="btn btn-primary">
                                Browse&hellip; <input type="file" style="display: none;" name="images" multiple>
                              </span>
                            </label>
                            <input type="text" class="form-control" readonly>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-12">
                       <!--  <div class="col-md-8 col-sm-12 col-xs-12 form-group">
                          <label>Description</label>
                          <textarea class="form-control" rows="3" placeholder="Description" name="dis" ><?php echo $ads['title'] ?></textarea>
                        </div> -->
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                          <input type="submit" name="add"  id="add_ads" class="btn btn-primary antosubmit"></button>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </form>
              </div>
            </div>
          </div>
        </div>
        <div class="clearfix"></div><div id="notifications"></div><input type="hidden" id="position" value="center">
      </div>
  </div>
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
    });
  });
</script>
<script>
  $(document).ready( function() {
  //Add
      var v = jQuery("#myForm").validate({
          rules: {
            title: {
                required: true
            },
            dis: {
                required: true
            }
          },
          messages: {
            title: {
                required: "Please provide a title field"
            },
            des: {
                required: "Please provide description field"
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

      $('#myForm').submit(function(e){  
        e.preventDefault();
        if (v.form()) {
          $('.body_blur').show();   
          $(this).ajaxSubmit(datas);  
        }          
      });
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
</body>
</html>
