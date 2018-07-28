<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/sumo-select/sumoselect.css" rel="stylesheet" />
</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
<div class="">
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Update Club Agent Details<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="">
                        <div class="">
                            <form method="post" name="ca_forms" id="ca_forms"  enctype="multipart/form-data" action="<?php echo base_url(); ?>update_club_agent">
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <label>Name</label>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input class="form-control" name="name" type="text" placeholder="Name" value="<?= $details['name'];?>" />
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <label>Email Id</label>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input class="form-control validate[required,custom[email]]" name="email" type="email" placeholder="Email Id" data-errormessage-value-missing="Email is required!" 
                                        data-errormessage-custom-error="Let me give you a hint: someone@nowhere.com" 
                                        value="<?= $details['email'];?>"/>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <label>Mobile No</label>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input class="form-control validate[required,custom[integer]]" name="mobile" onKeyPress="return isNumberKey(event)"   type="number" placeholder="Mobile No" data-errormessage-custom-error="Mobile no should be numeric value"  value="<?= $details['phone'];?>"/>
                                    </div>
                                </div>
                                <br>
                                <input type="hidden" name="id" value="<?php echo $details['id'];?>">
                                <?php  $by = $details['register_via']; $mem_id = $details['mem_id']; ?>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <label>Register via</label>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <input type="radio" name="create_by" value="admin" <?php echo($by=='admin')?'checked':''?>><label style="padding-left: 10px;">Admin</label>
                                    </div>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <input type="radio" name="create_by" value="club_member" <?php echo($by!='admin')?'checked':''?>><label style="padding-left: 10px;">Club Member</label>
                                    </div>
                                </div>
                                <br>
                                <div class="row" id="cm" style="display: none;">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <label>Select Club Member</label>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <select name="by" class="form-control search-box-open-up search-box" id="by">
                                            <option value="">Please Select</option>
                                            <?php foreach ($club_members as $mem) { ?>
                                            <option value="<?php echo $mem['id'];?>" <?php echo ($mem_id==$mem['id'])?'selected':''?>><?php echo $mem['name'];?></option>
                                            <?php } ?>
                                            </select>
                                    </div>
                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <label>Documents</label>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                        <input class="form-control validate[required]" name="ufile" type="file" multiple />
                                    </div>
                                </div>
                                <?php ?>
                                <br>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <?php $ext = pathinfo($details['ca_docs'], PATHINFO_EXTENSION);
                                            if($ext=='docx'){
                                        ?>
                                                <iframe class="doc" src="http://docs.google.com/gview?url=<?= base_url();?>uploads/ca_docs/<?php echo $details['ca_docs'];?>&embedded=true" style="width:60%" data-title="docs"></iframe>

                                                <br>
                                                <a href="#" class="btn btn-sm btn-danger btn_del" data-id="<?php echo $details['id'];?>"><i class="fa fa-trash"></i></a>
                                        <?php
                                            }else if($ext=='pdf'){
                                        ?>
                                                <a href="<?= base_url().$details['ca_docs'];?>"><i class="btn btn-sm btn-primary fa fa-file" target="_blank" data-title="pdf"></i><?= str_replace("uploads/ca_docs/", "",$details['ca_docs']);?></a>

                                                <br>
                                                <a href="#" class="btn btn-sm btn-danger btn_del" data-id="<?php echo $details['id'];?>"><i class="fa fa-trash"></i></a>
                                        <?php
                                            }else{
                                                echo "No Docs";
                                            }
                                        ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <button type="submit" class="pull-right btn btn-primary channelsubmit" name="channelsubmit" id="channelsubmit">Save Changes</button>
                                    </div>
                                </div>
                            </form>
<div id="notifications"></div><input type="hidden" id="position" value="center">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="clearfix"></div>

<!--************************row  end******************************************************************* -->
</div>
<?php echo $footer; ?>
<script type="text/javascript">
window.onload = function(e){ 
    <?php  if($by!='admin'){?>
      $('#cm').show();
    <?php } ?>
}

    $(function(){
      $('input[type="radio"]').click(function(){
        if ($(this).is(':checked'))
        {
          var cur = $(this);
                var by = cur.val();
                if(by=='club_member')
                {
                    $('#cm').show();
                }else{
                    $('#cm').hide();
                }
        }
      });
    });
    $(document).ready(function(){
        //Delete docs
        $(document).on('click', '.btn_del', function(e){
            e.preventDefault();
            var cur = $(this);
            var ca_id = cur.data('id');
            $('body').alertBox({
                title: 'Are You Sure?',
                lTxt: 'Back',
                lCallback: function(){
                  
                },
                rTxt: 'Okey',
                rCallback: function(){
                    $('.body_blur').show();
                    $.post('<?php echo base_url();?>delete_club_agent_docs/'+ca_id, function(data){
                        $('.body_blur').hide();
                        if(data.status){
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully deleted </div></div>';
                            var effect='zoomIn';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            refresh_close();
                        }else{
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+data.reason+'</div></div>';
                            var effect='fadeInRight';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            refresh_close();
                        }
                    },'json');
                }
            })
        });
        //update
         var v = jQuery("#ca_forms").validate({
            rules: {
                name: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    email: true,
                },
                mobile: {
                    required: true,
                    minlength: 10
                // },
                // ufile: {
                //     required: true
                }

            },
            messages: {
                name: {
                    required: "Please provide a name field",
                    minlength: "Name field must be at least 3 characters long"
                },
                email: {
                    required: "Please provide an email",
                    email: "Email is invalid"
                },
                mobile: {
                    required: "Please provide a mobile no",
                    minlength: "Mobile field must be at least 10 characters long"
                // },
                // ufile: {
                //     required: "Please provide a mobile no",
                }
            },
            errorElement: "span",
            errorClass: "help-inline-error",
        });

        var datas = { 
            dataType : "json",
            success:   function(data){
              // $('.body_blur').hide();
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
        $('#ca_forms').submit(function(e){     
          e.preventDefault();
          if (v.form()) {
            $(this).ajaxSubmit(datas);  
          }          
        });
    });
</script>
</body>
</html>