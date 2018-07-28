 <?php echo $header; ?>
<body>
<div class="wrapper">

 <?php echo $sidebar; ?>

<div class="content">
<div class="container-fluid">


<div class="col-md-12">
    <div class="card">
        <div class="card-header card-header-text" data-background-color="orange">
            <h4 class="card-title"> Add User </h4>

        </div>
        <div class="card-content">

            <form name="user_form" action="<?php echo base_url(); ?>admin/Executives/user_add" class="form-horizontal Calendar" method="post" id="user_form">



                <div class="col-md-4 col-sm-6">
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">Name</label>
                        <input type="text" name="name" class="form-control" data-rule-required="true">
                        <span class="material-input"></span><span class="material-input"></span></div>

                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">Email</label>
                        <input type="email" name="email" class="form-control" data-rule-required="true">
                        <span class="material-input"></span><span class="material-input"></span></div>

                </div>

                <div class="col-md-4 col-sm-6">
                    <div class="form-group label-floating is-empty">
                        <label class="control-label">Mobile No</label>
                        <input type="number" name="mob" class="form-control" data-rule-required="true">
                        <span class="material-input"></span><span class="material-input"></span></div>

                </div>






                <div class="col-md-12">
                    <input type="submit" value="Submit"  class="btn btn-fill btn-rose">

                </div>
            </form>
        </div>
    </div>
</div>




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

                            $('#user_form').hide();
                            $('.body_blur').hide();

                            $.toast('New User added Succesfully', {'width': 500});
                            setTimeout(function(){

                                $('#user_form').hide();
                                location.reload();
                            }, 1000);
                        }
                        else
                        {
                            $('.user_form').hide();
                            $.toast(data.reason, {'width': 500});
                            return false;
                        }
                    }
                });
            }
        });
    });     
</script>

</body>

</html>