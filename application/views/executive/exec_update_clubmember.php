<?php echo $header; ?>

<style type="text/css">
    

    
</style>

<body>
<div class="wrapper">
<script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>
<?php echo $sidebar; ?>

    <div class="content">
        <div class="container-fluid">


            <div class="col-md-12">
                <div class="card">
                    <div class="card-header card-header-text" data-background-color="orange">
                        <h4 class="card-title"> Edit Club Member</h4>

                    </div>
                    <div class="card-content">

                         <form method="post" name="clubmember_form" id="clubmember_form" action="<?php echo base_url();?>admin/executives/edit_club_member/<?php echo $c_memb['id'];?>" enctype="multipart/form-data">
                         <input type="hidden" name="id" value="<?php echo $c_memb['id'];?>">
                          <input type="hidden" name="log_id" value="<?php echo $c_memb['log_id'];?>">
                            <div class="col-md-3 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >Name</label>
                                    <input type="text" name="name" class="form-control" data-rule-required="true" value="<?= $c_memb['name'];?>" >
                                    <span class="material-input"></span><span class="material-input"></span></div>

                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" data-rule-required="true" value="<?= $c_memb['email'];?>" readonly >
                                    <span class="material-input"></span><span class="material-input"></span></div>

                            </div>

                            <div class="col-md-3 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >Contact Number</label>
                                    <input type="number" name="mob" class="form-control" data-rule-required="true"  value="<?= $c_memb['phone'];?>" readonly>
                                    <span class="material-input"></span><span class="material-input"></span></div>

                            </div>
                            <div class="col-md-3 col-sm-12 col-xs-12">
                                    <label>Type</label><br><br>
                                    <label> <input name="type" type="checkbox" class="type"<?php echo ($c_memb['ctype']=='UNLIMITED')?'checked':'';?> value="UNLIMITED">&nbsp;Unlimited</label>
                              
                               <label>  <input name="type" type="checkbox" class="type"  <?php echo ($c_memb['ctype']=='FIXED')?'checked':(($c_memb['fixed_club_type_id']!='0')?'checked':'');?> value="FIXED">&nbsp;Fixed  </label>
                                </div>
                                <input type="hidden" name="cplan" id="cplan" value="<?php echo $c_memb['club_type_id'];?>">
                                <input type="hidden" name="fixed_plan" id="fixed_plan" value="<?php echo $c_memb['fixed_club_type_id'];?>">
                                <div class="plan" style="    background: #eee;clear: both;overflow: hidden; padding: 20px;margin-bottom:15px">
                                <?php if($c_memb['club_type_id']!=0){ ?>
                                <div class="row">
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <label>Unlimited</label>
                                    </div>
                                    <div class="col-md-9 col-sm-12 col-xs-12">
                                    <?php foreach ($club_types as $key => $club) { ?>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <input type="radio" name="club_plan" id="club_plan" value="<?php echo $club['id'];?>" <?php echo ($c_memb['club_type_id']==$club['id'])?'checked':'';?>><label style="padding-left: 10px;"><?php echo ucwords($club['title']);?></label>
                                    </div>
                                    <?php } ?>
                                    </div>
                                </div>
                                <br>
                                <?php } if($c_memb['fixed_club_type_id']!=0){ ?>
                                <div class="row">
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <label>Fixed</label>
                                    </div>
                                    <div class="col-md-8 col-sm-12 col-xs-12">
                                    <?php foreach ($fixed_club_types as $key => $club) { ?>
                                    <div class="col-md-4 col-sm-12 col-xs-12">
                                        <input type="radio" name="club_plan2" id="club_plan2" value="<?php echo $club['id'];?>" <?php echo ($c_memb['fixed_club_type_id']==$club['id'])?'checked':'';?>><label style="padding-left: 10px;"><?php echo ucwords($club['title']);?></label>
                                    </div>
                                    <?php } ?>
                                    </div>
                                </div>
                                <br>
                                <?php } ?>
                                </div>


                            

              
                            <div class="row">
                                 <div class="col-md-12">
                            <div class="col-md-4 col-sm-6">
                                <div class="form-group label-floating is-empty">
                                    <label >Mode Of Payment</label><br>
                                    <label > <input name="mode" type="radio" class="mode"  <?php echo ($c_memb['mode_payment']=='cash')?'checked':'';?>  value="cash">&nbsp;Cash </label>                   
                           
                                     <label ><input name="mode" type="radio" class="mode" <?php echo ($c_memb['mode_payment']=='cheque')?'checked':'';?> value="cheque">&nbsp;Cheque</label>
                                     <label ><input name="mode" type="radio" class="mode" <?php echo ($c_memb['mode_payment']=='payment')?'checked':'';?> value="payment">&nbsp;Pay Online</label>
                                    <span class="material-input"></span><span class="material-input"></span></div>
                                </div>
                             <div class="row details">
                                    <div class="col-md-2 col-sm-12 col-xs-12">
                                        <label>Cheque No</label>
                                   
                                        <input type="text" name="cheque" class="form-control" value="<?php echo $c_memb['cheque_no'];?>">
                                    </div>
                                    <div class="col-md-3 col-sm-12 col-xs-12">
                                        <label>Bank</label>
                                   
                                        <input type="text" name="bank" class="form-control" value="<?php echo $c_memb['bank'];?>">
                                    </div>  
                                <div class="col-md-2 col-sm-6">
                                <!-- <div class="form-group label-floating is-empty"> -->
                                    <label>Cheque Date</label>
                                    <input type="text" class="form-control" id='cheque_date' value="<?php echo $c_memb['cheque'];?>" name="cheque_date"><span class="material-input"></span>
                                    <span class="material-input"></span>
                                </div>


                            <!-- </div> -->
                                 </div>  

      



                            <div class="col-md-12">
                                <input type="submit" class="btn btn-fill btn-rose" value="Save">

                            </div></div>
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
    var base_url = "<?php echo base_url(); ?>";
    var mode_payment =  '<?php echo ($c_memb['mode_payment']);?>';
   
    if(mode_payment=='cheque'){
        $('.details').show();
    }else{
        $('.details').hide();
    }
    $('input:radio[name="mode"]').change(
        function(){
            if ($(this).val() == 'cheque') {
               $(".details").show();
            }
            else{
               $(".details").hide(); 
            }
    });
    $('input[name="type"]').click(function(){
        new_obj = {}
        $('input[name="type"]:checked').each(function(i,j) {
            if(this.value=='FIXED'){
                new_obj[this.name+'2'] = this.value;  
            }else{
                new_obj[this.name+(i+1)] = this.value;  
            }
        });
        var cplan = $('#cplan').val();
        var fixed_plan = $('#fixed_plan').val();
        $(".plan").html('');
        $.post('<?php echo base_url();?>get_clubplans_by_type',new_obj, function(data){
            if(data.status){
                $(".plan").append(data.data);$(".plan").show();
                $('input[name="club_plan"][value="' + cplan.toString() + '"]').prop("checked", true);
                $('input[name="club_plan2"][value="' + fixed_plan.toString() + '"]').prop("checked", true);
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
</script>
<script type="text/javascript">

       
$(document).ready(function () {

 var v = jQuery("#clubmember_form").validate({

    submitHandler: function(datas) {
    
        jQuery(datas).ajaxSubmit({
            
            dataType : "json",
            success  :    function(data)
            {
               console.log(data);
                if(data.status)
                {
                //alert("Successfully added club member");
                $('.body_blur').hide();
var center = '<div id="notifications-full"><div id="notifications-full-close" class="close"><span class="iconb" data-icon="&#xe20e;"></span></div><div id="notifications-full-icon"><span class="icon-thumbs-up" data-icon="&#xe261;"></span></div><div id="notifications-full-text">Successfully Edited club Member </div></div>';
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
                   $('.body_blur').hide();
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
                   setTimeout(function(){

                        //$('#channel_form').hide();
                        location.reload();
                    }, 1000);
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

</body>

</html>