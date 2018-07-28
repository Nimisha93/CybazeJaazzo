<?php echo $header; ?>
</head>
<?php echo $sidebar; ?>

    <div class="right_col" role="main">
      <div class="">
        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Edit Complaint<small></small></h2>
                <ul class="nav navbar-right panel_toolbox">
                  <li><a onclick="goBack()" data-toggle="tooltip" title="" data-original-title="Go Back"><i class="fa fa-arrow-left" aria-hidden="true"></i></a> </li>
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <div class="">
                  <div class="container" style="margin-top: 20px;">
                  <form action="<?php echo base_url(); ?>hr/complaint/update_complaint/<?php echo $compl['id'];?>" method="post" id="complaint_form" enctype="multipart/form-data">
                    <div class="row">        
                     

                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                          <label>Complaint Against</label>
                        <select name="com_against" id="com_against" class="form-control" data-rule-required="true">
                          <option value="">Please select</option>
                           <?php foreach ($employee as $key => $emp) { ?>
                             <option <?php echo $compl['complaint_against'] == $emp['id'] ? 'selected' : '';?> value="<?php echo $emp['id'];?>"><?php echo $emp['name'];?>(<?php echo $emp['employee_code'];?>)</option>
                           <?php } ?>
                         </select>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                          <label>Tittle</label>
                          <input type="text" placeholder="Tittle"  name="tittle" class="form-control" data-rule-required="true" value=<?php echo $compl['title'];?>>
                        </div> 
                         <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                          <label>Status</label>
                          <select name="status" id="status" class="form-control" data-rule-required="true">
                          <option value="">Please select</option>
                           <?php foreach ($status as $key => $st) { ?>
                             <option  <?php echo $compl['status'] == $st['id'] ? 'selected' : '';?> value="<?php echo $st['id'];?>"><?php echo $st['status'];?></option>
                           <?php } ?>
                         </select>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-12 form-group">
                          <label>Description</label>
                          <textarea placeholder="Address" name="descrp" class="form-control" data-rule-required="true"><?php echo $compl['description'];?></textarea>
                        </div> 
                       
                        </div>

                          </div>

                        </div>  
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group"> 
                             
                          <input type="submit" class="btn btn-primary btn_save pull-right" value="Submit">
                        </div>    
                      </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--************************row  end******************************************************************* --> 
    </div>
  </div>
</div>
</div>
</div>
<div id="notifications" style="z-index: 99999"></div><input type="hidden" id="position" value="center">

<?php echo $footer; ?>
<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?php echo base_url();?>assets/admin/js/noty/jquery.noty.packaged.min.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">]

<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script type="text/javascript">
$('#com_against').SumoSelect({search: true, placeholder: 'Select employee'});

    $(document).ready(function()
    {
     var v = jQuery("#complaint_form").validate({
            submitHandler: function(datas) {
                jQuery(datas).ajaxSubmit({

                    dataType : "json",
                    success  :    function(data)
                    {
                        if(data.status)
                        {

                           

                             var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Complaint Updated Succesfully</div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        location.reload();
                    }, 1000);
                        }
                        else
                        {
                          $('.body_blur').hide();
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
                });
            }
        });


    });
   
</script>
</body>
</html>