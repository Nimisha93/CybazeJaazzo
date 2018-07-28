<?php echo $header; ?>
<body>
<div class="wrapper">
<?php echo $sidebar; ?>

    <div class="content">
        <div class="container-fluid">


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-text" data-background-color="orange">
                        <h4 class="card-title"> Add Club Member</h4>

                    </div>
                    <div class="card-content">

                         <form method="post" name="clubmember_form" id="clubmember_form" action="<?php echo base_url();?>admin/executives/new_club_member" enctype="multipart/form-data">
                           <div class="row">

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">Name</label>
                                    <input type="text" name="name" class="form-control" data-rule-required="true">
                                    <span class="material-input"></span><span class="material-input"></span></div>

                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">Email</label>
                                    <input type="email" name="email" class="form-control" data-rule-required="true">
                                    <span class="material-input"></span><span class="material-input"></span></div>

                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label class="control-label">Contact Number</label>
                                    <input type="number" name="mob" class="form-control" data-rule-required="true">
                                    <span class="material-input"></span><span class="material-input"></span></div>

                            </div>
                         
                                <div class="col-md-3 col-sm-12 col-xs-12">
                                    <label>Type</label><br>
                                    <label> <input name="type" type="checkbox" class="type" value="UNLIMITED">&nbsp;Unlimited </label>
                              
                               <label>  <input name="type" type="checkbox" class="type"  value="FIXED">&nbsp;Fixed  </label>
                                </div>
                            <div class="col-md-12 col-sm-6 plan" style="display: none;background: #eee;clear: both;overflow: hidden; padding: 20px;margin-bottom:15px"></div>
                            <div class="clearfix"></div>
                            
                            <div class="row" style="margin-top: 15px;">
                                 <div class="col-md-12">
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >Mode Of Payment</label><br>
                                  <label >   <input name="mode" type="radio" class="mode"  value="cash" data-rule-required="true">&nbsp;Cash   </label>                 
                           
                                    <label > <input name="mode" type="radio" class="mode" value="cheque">&nbsp;Cheque </label>
                                   <label >  <input name="mode" type="radio" class="mode" value="payment">&nbsp;Pay Online </label>
                                    <span class="material-input"></span><span class="material-input"></span></div>
                                </div>
                            <div class="details" style="display: none;">
                             <div class="col-md-3 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label class="">Cheque No</label>
                                    <input type="text" name="cheque" class="form-control" data-rule-required="true">
                                    <span class="material-input"></span><span class="material-input"></span></div>

                            </div> 
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label class="">Bank</label>
                                    <input type="text" name="bank" class="form-control" data-rule-required="true">
                                    <span class="material-input"></span><span class="material-input"></span></div>

                            </div>   
                             <!-- </div> -->
                            
                                <div class="col-md-2 col-sm-6 ">
                                  
                                <div class="form-group label-floating is-empty">
                                    <div class="form-group">
                                    <label>Cheque Date</label>
                                    <input type="text" class="form-control " id ="cheque_date"  value="" name="cheque_date">
                                    <span class="material-input"></span>
                                        <span class="material-input"></span></div>
                                </div>   

                             </div>    </div>
                            </div>








                            <div class="col-md-12">
                                <input type="submit" class="btn btn-fill btn-rose" value="Submit">
                                </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
<div id="notifications"></div><input type="hidden" id="position" value="center">
        <?php echo $footer; ?>
        <script src="<?php echo base_url(); ?>assets/admin/js/jquery.form.js" type="text/javascript"></script>
        <link href="<?php echo base_url(); ?>assets/admin/css/sumoselect.css" rel="stylesheet">
        <script src="<?php echo base_url(); ?>assets/admin/js/sumoslct.js"></script>
        <script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>
        <link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">

<script type="text/javascript">
    $(document).ready(function() {
        $('#datetimepicker').datetimepicker(
                {format: 'DD-MM-YYYY h:mm'}
        );
        $('#cheque_date').datetimepicker(
                {format: 'DD-MM-YYYY'}
        );
    });
</script>






<script type="text/javascript">

       
$(document).ready(function () {

 var v = jQuery("#clubmember_form").validate({

    submitHandler: function(datas) {
    
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {
               //console.log(data);
                if(data.status)
                {
                //alert("Successfully added club member");
                 $('.body_blur').hide();
var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully added club member </div></div>';
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
                    $('.body_blur').hide();
                    $('#channel_form').hide();
                    var regex = /(<([^>]+)>)/ig;
                    var body = data.reason;
                    var result = body.replace(regex, "");
                    var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-down" data-icon="&#xe261;"></span></div><div id="notifications-full-text">'+result+'</div></div>';
                    var effect='fadeInRight';
                    $("#notifications").append(center);
                    $("#notifications-full").addClass('animated ' + effect);
                                $('.close').click(function(){
                                $(this).parent().fadeOut(1000);
                            });
                    //refresh_close();
                    //$.toast(data.reason, {'width': 500});
                   // return false;
                }
            }
        });
    }
});
     $('#clubmember_form').submit(function(e){     
      e.preventDefault();

    
      if (v.form()) 
      {
     
        $('.body_blur').show();
        //$(this).ajaxSubmit(datas);  
      }          
    });
}); 
</script> 
<script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        $('input[name="type"]').click(function(){
                new_obj = {}
                $('input[name="type"]:checked').each(function(i,j) {
                    if(this.value=='FIXED'){

                        new_obj[this.name+'2'] = this.value;  
                    }else{
                        new_obj[this.name+(i+1)] = this.value;  
                    }  
                });
             
                $(".plan").html('');
                $.post('<?php echo base_url();?>get_clubplans_by_type',new_obj, function(data){
                    if(data.status){
                        $(".plan").append(data.data);$(".plan").show();
                    }else{
                        var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Please try to select type</div></div>';
                            var effect='fadeInRight';
                            $("#notifications").append(center);
                            $("#notifications-full").addClass('animated ' + effect);
                            $('.close').click(function(){
                                $(this).parent().fadeOut(1000);
                            });
                    }
                },'json');
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function(){
        var base_url = "<?php echo base_url(); ?>";
        $('input:radio[name="mode"]').change(
            function(){
                if ($(this).val() == 'cheque') {
                   $(".details").show();
                }
                else{
                   $(".details").hide(); 
                }

            });
          });
</script>
</body>

</html>