<?php echo $header; ?>

<body>
<div class="wrapper">

<?php echo $sidebar; ?>
<div class="content">
<div class="container-fluid">
<div class="row">
<div class="col-md-12">
<div class="card">
<div class="card-header card-header-icon" data-background-color="purple">
   Add Jaazzo Store

</div><br><br>
<div class="card-content">
                            <form method="post"  name="ba_form" action="<?php echo base_url();?>admin/Executives/new_ba" id="ba_form" enctype="multipart/form-data">
                                <div class="col-md-12">
                             <div class="col-md-12 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                <!--     <label class="control-label">Module</label> -->

                                   <select name="club_member" class="form-control search-box-open-up search-box club_member" id="module" data-rule-required="true">
                                         <option value="">Please Select Club Member</option>
                                            <?php foreach ($member['member'] as $type) { ?>
                                            <option value="<?php echo $type['m_id'];?>"><?php echo $type['name'];?></option>
                                            <?php } ?>
                                            </select>          
                                    </select>

                                </div>

                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Name</label>
                                        <input type="text" placeholder="Name" id="ba_name" name="ba_name" class="form-control"  data-rule-required="true" >
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Mobile No</label>
                                        <input type="text" placeholder="Mobile" id="ba_mobile" name="ba_mobile" class="form-control "  data-rule-required="true">
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Email ID</label>
                                        <input type="text" placeholder="Email" id="ba_email" name="ba_email" class="form-control "  data-rule-required="true">
                                    </div>

                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Company Name</label>
                                        <input type="text" placeholder="Company Name" id="ba_company_Name" name="ba_company_Name" class="form-control "  data-rule-required="true">
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Office Phone</label>
                                        <input type="text" placeholder="Office Phone" id="office_phone" name="office_phone" class="form-control "  data-rule-required="true">
                                    </div>


                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>Office Email Id</label>
                                        <input type="text" placeholder="Office Email Id" id="office_email_id" name="office_email_id" class="form-control "  data-rule-required="true">
                                    </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12"> 
                                        <label for="Contact Person">Country</label>

                                        <select name="country" id="country" class="form-control  sel_country select_box_sel"  data-rule-required="true" >
                                            <option value="">Please Select</option>
                                            <?php foreach ($countries as $key => $country) { ?>
                                            <option value="<?php echo $country['id'];?>"><?php echo $country['name'];?></option>
                                            <?php  } ?>

                                        </select>
                                    </div>
                                     <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                       
                                            <label for="Contact Number">State</label>
                                            <select name="state" id="states" class="form-control sel_state select_box_sel "  data-rule-required="true">
                                                
                                            </select>
                                        </div>
                                    <div class="col-md-4 col-sm-6 col-xs-12 form-group">
                                        <label>City /Twon</label>
                                            <select name="city" id="city" class="form-control"  data-rule-required="true">

                                            </select>
                                    </div>
 
                                    </div>
                              
<!--                                     <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                        <input type="submit"  class="btn btn-primary " name="prosubmit" id="prosubmit" value="Save" >
                                    </div> -->
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-fill btn-rose" value="Save">

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
<div id="notifications"></div><input type="hidden" id="position" value="center">
<?php echo $footer; ?>

<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<link href="<?php echo base_url(); ?>assets/admin/sumo-select/sumoex.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>assets/admin/js/sumoslct.js"></script>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">

<!--************************row  end******************************************************************* -->
<script type="text/javascript">
 $(document).ready(function () {

         var v = jQuery("#ba_form").validate({
        
            submitHandler: function(datas) {
            
                jQuery(datas).ajaxSubmit({
                    
                    dataType : "json",
                    success  :    function(data)
                    {

                        if(data.status)
                {

                    //$('#channel_form').hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added BA </div></div>';
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
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    //$.toast(data.reason, {'width': 500});
                   // return false;
                }
                    }
                });
            }
        });
        $('#states').SumoSelect();
        $('#city').SumoSelect();
        $('#country').SumoSelect({search: true, placeholder: 'select country'});
        $('#country').change(function () {

            var cur = $(this);
            var country_id = cur.val();

            if (country_id != '') {

                $.get('<?= base_url();?>admin/executives/get_states_by_country', {country_id: country_id}, function (data) {
                    if (data.status) {
                        
                        $('#states')[0].sumo.unload();
                        var opt = '';
                        var data = data.data;
                        
                        opt += '<option value="">Please select</option>';
                        for (var i = 0; i < data.length; i++) {

                            opt += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }

                        //  $('#states')[0].sumo.unload();
                        $('#states').html(opt);
                        $('#states').SumoSelect({search: true, placeholder: 'select state'});
                    } else {
                        $.toast('No state found', {'width': 500});
                    }
                }, 'json');
            }
        });
        $('#states').change(function () {
            var cur = $(this);
            var state_id = cur.val();
            
            if (state_id != '') {

                $.get('<?= base_url();?>admin/executives/get_city_by_state', {state_id: state_id}, function (data) {
                    if (data.status) {
                       $('#city')[0].sumo.unload();
                        var opt = '';
                        var data = data.data;
                        for (var i = 0; i < data.length; i++) {
                            opt += '<option value="' + data[i].id + '">' + data[i].name + '</option>';
                        }
                        $('#city').html(opt);
                        $('#city').SumoSelect({search: true, placeholder: 'select state'});
                    } else {
                        $.toast('No city found', {'width': 500});
                    }
                }, 'json');
            }

        });
    });

    </script>
<script type="text/javascript">
$(".club_member").change(function(){
   var club_id = $(".club_member option:selected"). val();
  
   $.post('<?php echo base_url();?>admin/executives/get_count_by_id_store/'+club_id, function(data){
           var data1 = data.data;
         console.log(data1);
            if(data1['ba_limit']>data1['ba_count']){

              $(".details").show();
            }
            else{
                
               $(".details").hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Sorry!!....Club Agent Limit Crossed </div></div>';
                    var effect='zoomIn';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                    refresh_close();
                    setTimeout(function(){

                        //$('#channel_form').hide();
                        location.reload();
                    }, 1000);
            }
         
           },'json');

});
</script>


<!--============new customer popup start here=================-->


</div>
</div>
</body>
</html>