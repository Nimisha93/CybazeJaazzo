 <?php echo $header; ?>
<body>
<div class="wrapper">

 <?php echo $sidebar; ?>

<div class="content">
<div class="container-fluid">


<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-text" data-background-color="orange">
            <h4 class="card-title"> Add Club Agent </h4>

        </div>
        <div class="card-content">

            <form name="user_form" action="<?php echo base_url(); ?>admin/Executives/new_club_agent" class="form-horizontal Calendar" method="post" id="user_form">
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
                            </div>
                <div class="details">
                <div class="col-md-4 col-sm-6">
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">Name</label>
                        <input type="text" name="name" class="form-control" data-rule-required="true">
                        <span class="material-input"></span><span class="material-input"></span></div>

                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">Email</label>
                        <input type="email" name="mail" class="form-control" data-rule-required="true">
                        <span class="material-input"></span><span class="material-input"></span></div>

                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">Mobile No</label>
                        <input type="number" name="mobile" class="form-control" data-rule-required="true">
                        <span class="material-input"></span><span class="material-input"></span></div>

                </div>

                </div>

                <div class="row">
                    <div class="col-md-12">
                                <div class="col-md-4 col-sm-6">

                                            <label>Documents</label>
                                            <input type="file" data-rule-required="true" class="crsor" name="ufile" />
                                          </div>

</div></div>

                <div class="col-md-12">
                    <input type="submit" value="Submit"  class="btn btn-fill btn-rose">

                </div>
            </form>
        </div>
    </div>
</div>



<div id="notifications"></div><input type="hidden" id="position" value="center">
</div>
 <?php echo $footer; ?>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/admin/js/jquery.sumoselect.js"></script>
<link href="<?= base_url() ?>assets/admin/css/sumoselect.css" rel="stylesheet"/>
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<script type="text/javascript">
 $(document).ready(function () {

         var v = jQuery("#user_form").validate({
        
            submitHandler: function(datas) {
            
                jQuery(datas).ajaxSubmit({
                    
                    dataType : "json",
                    success  :    function(data)
                    {

                        if(data.status)
                {

                    //$('#channel_form').hide();
                    $('.body_blur').hide();
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added Club Agent </div></div>';
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
                    refresh_close();
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
$(".club_member").change(function(){
   var club_id = $(".club_member option:selected"). val();

   $.post('<?php echo base_url();?>admin/executives/get_count_by_id/'+club_id, function(data){
           var data1 = data.data;
          //alert(data1['ca_limit']);
            if(data1['ca_limit']>data1['ca_count']){

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
</body>

</html>