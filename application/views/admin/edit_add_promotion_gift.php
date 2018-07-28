<?php echo $default_assets; ?>
<link href="<?php echo base_url();?>assets/admin/sumo-select/sumoselect.css" rel="stylesheet" />

  <?php echo $map['js']; ?>
  <script type="text/javascript">
    function getPosition(newLat, newLng)
    {
      $('#lat').val(newLat);
      $('#long').val(newLng);
    }
  </script>

</head>
<?php echo $sidebar; ?>
<div class="right_col" role="main">
    <div class="">
        

        <div class="clearfix"></div>
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Add Channel Partner<small></small></h2>
                        <ul class="nav navbar-right panel_toolbox">
                            <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a> </li>
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div class="">
                            <div class="">
                                <form method="post" name="channel_form" id="channel_form" action="<?php echo base_url();?>admin/Home/add_partner" enctype="multipart/form-data">
                                    <div class="col-md-12">
                                        
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Module</label>
                                            <select name="module" class="form-control search-box-open-up search-box" id="module" data-rule-required="true">
                                            <option value="">Please Select</option>
                                            <?php foreach ($modules['type'] as $type) { ?>
                                            <option value="<?php echo $type['id'];?>"><?php echo $type['module_name'];?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                     
                                       <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Channel Partner Type</label>
                                            <select id="channel_type" class="form-control search-box-open-up search-box-sel-all channel_type" name="channel_type[]" multiple="multiple" onchange="console.log($(this).val())" data-rule-required="true">
                                            <?php foreach($category['type'] as $type){ ?>
                                            
                                           
                                            <optgroup label="<?php echo $type['title'];?>">
                                            <?php $pid=$type['id']; foreach($subcategory['type'] as $stype){ if($stype['parent']==$pid){ ?>

                                            <option class="subc" value="<?php echo $stype['id'];?>"><?php echo $stype['title'];?></option>
                                            
                                            <?php } ?> </optgroup> <?php } } ?>
                                            </select>
                                        </div>
                
                                        
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Channel Name</label>
                                            <input type="text" placeholder="Name of the Organization" name="name" class="form-control" data-rule-required="true">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Email(Username)</label>
                                            <input type="email" name="email" class="form-control email" id="email" data-rule-required="true" data-rule-email="true">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Contact Number</label>
                                            <input type="text" placeholder="Phone" name="phone" id="phone" class="form-control" data-rule-required="true" data-rule-number="true">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Alternative Contact Number</label>
                                            <input type="text" placeholder="Phone" name="phone2" class="form-control" data-rule-required="true" data-rule-number="true">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Contact Person</label>
                                            <input type="text" placeholder="Contact Person" name="cname" class="form-control" data-rule-required="true">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Contact Email</label>
                                            <input type="text" name="c_email" class="form-control c_email" id="c_email" data-rule-required="true" data-rule-email="true" placeholder="Contact Email">
                                        </div>
                                        
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Contact Mobile</label>
                                            <input type="text" name="c_mobile" class="form-control c_mobile" id="c_mobile" data-rule-required="true" data-rule-number="true"  placeholder="Contact Mobile">
                                        </div>
                                         <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Alternative Contact Person</label>
                                            <input type="text" placeholder="Contact Person" name="acname" class="form-control" data-rule-required="true">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Alternative Contact Email</label>
                                            <input type="text" name="ac_email" class="form-control ac_email" id="ac_email" data-rule-required="true" data-rule-email="true" placeholder="Contact Email">
                                        </div>
                                        
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Alternative Contact Mobile</label>
                                            <input type="text" name="ac_mobile" class="form-control ac_mobile" id="ac_mobile" data-rule-required="true" data-rule-number="true" placeholder="Contact Mobile">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Owner Contact Person</label>
                                            <input type="text" placeholder="Contact Person" name="ocname" class="form-control" data-rule-required="true">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Owner Contact Email</label>
                                            <input type="text" name="oc_email" class="form-control oc_email" id="oc_email" data-rule-required="true" data-rule-email="true" placeholder="Contact Email">
                                        </div>
                                        
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Owner Contact Mobile</label>
                                            <input type="text" name="oc_mobile" class="form-control oc_mobile" id="oc_mobile" data-rule-required="true" data-rule-number="true"  placeholder="Contact Mobile">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Country</label>
                                            <select name="country" class="form-control search-box-open-up search-box-sel-all" id="sel_country" data-rule-required="true">
                                            <option value="">Please Select</option>
                                            <?php foreach ($countries as $key => $country) { ?>
                                            <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                                            <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>State</label>
                                            <select name="state" class="form-control sel_state select_box_sel" id="sel_state" data-rule-required="true">
                                             <option value="">Please Select</option>                                       
                                            </select>
                                        </div>

                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Town</label>
                                            <input type="text" name="town" class="form-control" id="town" data-rule-required="true">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Bank Name</label>
                                            <input type="text" name="bank_name" class="form-control" id="bank_name" >
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Account Number</label>
                                            <input type="text" name="ac_number" class="form-control" id="ac_number" >
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Account Holder Name</label>
                                            <input type="text" name="ac_holder_name" class="form-control" id="ac_holder_name">
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>IFSC Number</label>
                                            <input type="text" name="ifsc" class="form-control" id="ifsc" >
                                        </div>
                                        <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                            <label>Branch Name</label>
                                            <input type="text" name="branch" class="form-control" id="branch" >
                                        </div>
                                       
                                        
                                          <div class="col-md-4 col-sm-6 col-xs-12">
                    <label>Profile Image</label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Browse&hellip; <input type="file" name="pro" id="pro" class="form-control" data-rule-required="true" style="display: none;" multiple >
                    </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div>
          </div>
        
        
                                        
                                         <div class="col-md-4 col-sm-6 col-xs-12">
                    <label>Brand Image</label>
            <div class="input-group">
                <label class="input-group-btn">
                    <span class="btn btn-primary">
                        Browse&hellip; <input type="file" name="bri" data-rule-required="true" class="form-control" id="bri" style="display: none;" multiple>
                    </span>
                </label>
                <input type="text" class="form-control" readonly>
            </div>
          </div>
          
          


    <!--************************row  end******************************************************************* -->
     


</div>
</div>
</div>
</div>
</div>
<div id="notifications"></div><input type="hidden" id="position" value="center">

<!--************************row  end******************************************************************* -->
</div>
<?php echo $footer; ?>
<script type="text/javascript">     
$(document).ready(function () {
 var v = jQuery("#channel_form").validate({

    submitHandler: function(datas) {
    $('.body_blur').show();
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {
                 $('.body_blur').hide();
                if(data.status)
                {

                    //$('#channel_form').hide();
                   
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added channel partner </div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        //$('#channel_form').hide();
                        location.reload();
                    }, 1000);
                }
                else
                {
                   // $('#channel_form').hide();
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    $('.close').click(function(){
                         $(this).parent().fadeOut(1000);
                     });
                    //$.toast(data.reason, {'width': 500});
                   // return false;
                }
            }
        });
    }
 });
}); 
 </script> 
    <script type="text/javascript">
        $(document).on('change', '#sel_country',function(){
          var cur = $(this); 
          var country = cur.val();
          $('.body_blur').show();
          $('#sel_state')[0].sumo.unload();
          $.post('<?php echo base_url();?>admin/Home/get_state_by_id/'+country, function(data){
            $('.body_blur').hide();
            if(data.status)
            {
              var data = data.data;
              var option ='';
               option += '<option value="">Please Select</option>';
             for(var i=0; i<data.length; i++){
                option += '<option value="'+data[i].id+'">'+data[i].name+'</option>';
             }
              $('.sel_state').html(option);
            } else{
              noty({text: data.reason, type:error, timeout:1000});
            }
            $('#sel_state').SumoSelect({search: true, placeholder: 'select state'});
          },'json');
        });
    </script>
    <script type="text/javascript">
        $(document).ready(function(){
           
        $('#email').focusout(function(){
            var mail = $(this).val();
            var cur = $(this);
            $.post('<?php echo base_url();?>admin/Home/mail_exists/',{mail :mail},
                   function(data)
                    {
                        if(data.status)
                        {
                            var regex = /(<([^>]+)>)/ig;
                            var body = "Mail Id Already Exists";
                            var result = body.replace(regex, "");
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                            var effect='fadeInRight';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            $('.close').click(function(){
                                    $(this).parent().fadeOut(1000);
                            });
                           
                            cur.val("");
                            
                        }else{
                            
                        }
                    },'json');
         });
        $('#phone').focusout(function(){
            var mob = $(this).val();
            var cur = $(this);
            $.post('<?php echo base_url();?>admin/Home/mobile_exists/',{mob :mob},
                    function(data)
                    {
                        if(data.status)
                        {
                          
                           var regex = /(<([^>]+)>)/ig;
                            var body = "Mobile Number Already Exists";
                            var result = body.replace(regex, "");
                            var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                            var effect='fadeInRight';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            $('.close').click(function(){
                                    $(this).parent().fadeOut(1000);
                            });
                            cur.val("");
                        }else{
                            
                        }
            },'json');
        });
     });
    </script>
<script src="<?php echo base_url();?>assets/admin/sumo-select/jquery.sumoselect.js"></script>

<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">

<script type="text/javascript">
    $(document).ready(function () {
        //$('.channel_type').SumoSelect({search: true, placeholder: 'select category',okCancelInMulti: true,});
        $('#module').SumoSelect();
        $('.channel_type').SumoSelect({search: true, placeholder: 'select category',okCancelInMulti: true,triggerChangeCombined: false});
        $('#sel_country').SumoSelect({search: true, placeholder: 'select country'});
        $('#sel_state').SumoSelect({search: true, placeholder: 'select state'});
    });
</script>
<script>
    $(document).ready(function() {
        //set initial state.
        $('#textbox1').val($(this).is(':checked'));

        $('#checkbox1').change(function() {
            $('#textbox1').val($(this).is(':checked'));
        });

        // $('#checkbox1').click(function() {
        //     if ($(this).is(':checked')) {
        //         return confirm("Are you sure?");
        //     }
        // });
        $(document).on('click','#checkbox1',function(){
            var cur=$(this);
    
                $('body').alertBox({
                    title: 'Are You Sure?',
                    lTxt: 'Back',
                    lCallback: function(){
                      
                    },
                    rTxt: 'Okey',
                    rCallback: function(){
                        
                        
                    }
                })
            });
        // $(".SumoSelect li").bind('click.check', function(event) {
        //         alert($(this).hasClass('selected'));
        // })
        
       
    });
</script>
       

 <script src="<?php echo base_url();?>assets/admin/js/file-browse/dropzone-min.js"></script>



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
  });
  
});</script>

</body>          
</html>