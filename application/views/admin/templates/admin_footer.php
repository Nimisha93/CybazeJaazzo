<div class="body_blur" style="display: none"></div>
<footer>
    <div class="pull-right">
        Jaazzo <a href=""></a>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>
<link href="<?php echo base_url();?>assets/admin/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
<link rel="stylesheet" media="screen" href="<?= base_url() ?>assets/admin/plugins/val/demo/css/screen.css">
<link href="<?php echo base_url();?>assets/admin/plugins/jqtoast/jquery.m.toast.css" rel="stylesheet">
<script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/plugins/jqtoast/jquery.m.toast.js"></script>

<script src="<?php echo base_url();?>assets/admin/js/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/sidebar.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/fastclick.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/nprogress.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap-wysiwyg.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.hotkeys.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/prettify.js"></script>
<!-- <script src="<?php echo base_url(); ?>assets/admin/js/Chart.min.js"></script> -->
<script src="<?php echo base_url(); ?>assets/admin/js/custom.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/moment.min.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap-datetimepicker.js"></script>
<script>
    function goBack() {
        window.history.back();
    }
</script>
<style>
    .body_blur {
        width: 100%;
        height: 100%;
        position: fixed;
        top: 0;
        left: 0;
        z-index: 99999;
        background-color: rgba(0,0,0,0.4);
        background-image: url(<?= base_url() ?>assets/admin/images/lloading.gif);
        background-position: center;
        background-repeat: no-repeat;
        background-size: 30px 30px;
        display: none;
    }

</style>

<!-- Switchery -->

<!-- Autosize -->

<!-- jQuery autocomplete -->
<script src="<?= base_url() ?>assets/admin/plugins/val/dist/jquery.validate.js"></script>


<script src="<?php echo base_url();?>assets/admin/js/jquery.form.js"></script>

<script>

    $('ul.nav li.dropdown').hover(function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeIn(500);
    }, function() {
        $(this).find('.dropdown-menu').stop(true, true).delay(100).fadeOut(500);
    });

</script>

<script>
    $('#compose, .compose-close').click(function(){
        $('.compose').slideToggle();
    });
</script>

<script>
    $(document).ready(function(){
        $('[data-toggle="popover"]').popover();
    });
</script>
<!-- alertBox -->
<script src="<?php echo base_url(); ?>assets/admin/js/alertBox.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/alertBox.css"> 
<!-- Notification -->
<link href="<?php echo base_url(); ?>assets/admin/_css/Icomoon/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/admin/_css/animate.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/admin/_css/animated-notifications.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    function resize(){$('#notifications')}
        $( window ).resize(function() {resize();});
        resize();


        function refresh_close(){
            $('.close').click(function(){$(this).parent().fadeOut(1000);});
            setTimeout(function(){ location.reload(); }, 1000);
        }
</script>
<!-- <script type="text/javascript">
    function resize(){$('#notifications').height(window.innerHeight - 50);}
        $( window ).resize(function() {resize();});
        resize();


        function refresh_close(){
            $('.close').click(function(){$(this).parent().fadeOut(1000);});
            setTimeout(function(){ location.reload(); }, 1000);
        }
</script> -->