<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/css/file-browse/dropzone.min.css" rel="stylesheet"
      xmlns="http://www.w3.org/1999/html"/>
</head>
<?php echo $sidebar; ?>
  <div class="right_col" role="main">
    <div class="">  
      <div class="clearfix"></div>
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Add Advertisements<small></small></h2>
                  <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                  </ul>
                <div class="clearfix"></div>
              </div>
              <form  method="post"  name="myForm" id="myForm"  enctype="multipart/form-data" action="<?php echo base_url();?>admin/Advertisement/add_ads">
              <div class="x_content">
                <div class="">
                  <div class="table-responsive tabmargntp30">
                    <div class="col-md-4">
                      <label>Tittle</label>
                      <input type="text" placeholder="Tittle"  name="name" id="title" class="form-control">
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                      <label>Priority</label>
                      <input type="text" placeholder="Priority" name="sort" id="sort" class="form-control">
                    </div>
                    <div class="col-md-4 col-sm-12 col-xs-12 form-group">
                      <label>Images</label>
                      <div class="input-group">
                        <label class="input-group-btn">
                          <span class="btn btn-primary">
                              Browse&hellip; <input type="file" name="images" style="display: none;">
                          </span>
                        </label>
                        <input type="text" class="form-control" readonly>
                      </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                      <label>Advertisement Type</label>
                      <br>
                      <label style="margin-right: 5px;line-height: 2px">
                        <input type="radio" value="left" name="type">Left
                      </label>
                      <label style="margin-right: 5px;line-height: 2px">
                        <input type="radio" value="center" name="type">Middle
                      </label>
                      <label style="margin-right: 5px;line-height: 2px">
                        <input type="radio" value="right" name="type">Right
                      </label>
                      <label style="margin-right: 5px;line-height: 2px">
                        <input type="radio" value="bottom" name="type">Bottom
                      </label>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                      <input type="submit" name="add"  id="add_ads" class="btn btn-primary antosubmit"></button>
                    </div>
                  </div>
                </div>
              </div>
              </form>
              <div id="notifications"></div><input type="hidden" id="position" value="center">
            </div>
          </div>
        </div>
      </div>
      <div class="clearfix"></div>
    </div>
  </div>
<?php echo $footer; ?>
<script>
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
      //Add
      var v = jQuery("#myForm").validate({
          rules: {
              name: {
                  required: true
              },
              sort: {
                  required: true
              },
              type: {
                  required: true
              },
              images:{
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
              },
              images:{
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
              var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added </div></div>';
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
  });
</script>
</body>
</html>