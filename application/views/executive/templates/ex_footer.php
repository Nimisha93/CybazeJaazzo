<div class="body_blur" style="display: none"></div>
<footer>
    <div class="pull-left">
        Copyrights  2017 <a href="" target="_blank">jaazzo</a>. All Rights Reserved
    </div>
    <div class="pull-right">
        Conceived By <a href="http://www.cybaze.com/" target="_blank">Cybaze</a>
    </div>
    <!-- <div class="pull-right">
        Anona E-mart <a href=""></a>
    </div> -->
    <div class="clearfix"></div>
</footer>
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

<!---->
<!--<footer class="footer">-->
<!--    <div class="container-fluid">-->
<!---->
<!--        <p class="copyright pull-right">-->
<!---->
<!---->
<!--            <a href="http://www.cybaze.com/">Created by cybaze </a>, made with love for  <a-->
<!--                href="http://www.jayakumarmenon.com/"> &copy; jayakumar menon</a>-->
<!--        </p>-->
<!--    </div>-->
<!--</footer>-->
<!--   Core JS Files   -->
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap/bootstrap.min.js"></script>
<script src="<?php echo base_url();?>assets/admin/js/datatables.net/js/jquery.dataTables.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/material.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
<!-- Include a polyfill for ES6 Promises (optional) for IE11, UC Browser and Android browser support SweetAlert -->
<script src="<?php echo base_url(); ?>assets/ajax/libs/core-js/2.4.1/core.js"></script>
<!-- Library for adding dinamically elements -->
<script src="<?php echo base_url(); ?>assets/admin/js/arrive.min.js" type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.validate.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?php echo base_url(); ?>assets/admin/js/moment.min.js"></script>
<!--  Charts Plugin, full documentation here: https://gionkunz.github.io/chartist-js/ -->
<!--<script src="assets/js/chartist.min.js"></script>-->
<!--  Plugin for the Wizard, full documentation here: https://github.com/VinceG/twitter-bootstrap-wizard -->
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.bootstrap-wizard.js"></script>
<!--  Notifications Plugin, full documentation here: http://bootstrap-notify.remabledesigns.com/    -->
<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap-notify.js"></script>
<!--   Sharrre Library    -->
<!--<script src="assets/js/jquery.sharrre.js"></script>-->
<!--  Plugin for the DateTimePicker, full documentation here: https://eonasdan.github.io/bootstrap-datetimepicker/ -->
<script src="<?php echo base_url(); ?>assets/admin/js/bootstrap-datetimepicker.js"></script>
<!-- Vector Map plugin, full documentation here: http://jvectormap.com/documentation/ -->
<!--<script src="assets/js/jquery-jvectormap.js"></script>-->
<!-- Sliders Plugin, full documentation here: https://refreshless.com/nouislider/ -->
<!--<script src="assets/js/nouislider.min.js"></script>-->
<!--  Google Maps Plugin    -->
<!--<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD1_8C5Xz9RpEeJSaJ3E_DeBv8i7j_p6Aw"></script>-->
<!--  Plugin for Select, full documentation here: http://silviomoreto.github.io/bootstrap-select -->
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.select-bootstrap.js"></script>
<!--  DataTables.net Plugin, full documentation here: https://datatables.net/    -->

<!-- Sweet Alert 2 plugin, full documentation here: https://limonte.github.io/sweetalert2/ -->
<script src="<?php echo base_url(); ?>assets/admin/js/sweetalert2.js"></script>
<!-- Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?php echo base_url(); ?>assets/admin/js/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin, full documentation here: https://github.com/fullcalendar/fullcalendar    -->
<!--<script src="assets/js/fullcalendar.min.js"></script>-->
<!-- Plugin for Tags, full documentation here: https://github.com/bootstrap-tagsinput/bootstrap-tagsinputs  -->
<script src="<?php echo base_url(); ?>assets/admin/js/jquery.tagsinput.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?php echo base_url(); ?>assets/admin/js/material-dashboard.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo base_url(); ?>assets/admin/demo.js"></script>
<script src="<?php echo base_url(); ?>assets/admin/js/alertBox.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/admin/css/alertBox.css"> 
<!-- Notification -->
<link href="<?php echo base_url(); ?>assets/admin/_css/Icomoon/style.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/admin/_css/animate.css" rel="stylesheet" type="text/css" />
<link href="<?php echo base_url(); ?>assets/admin/_css/animated-notifications.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">
    function resize(){$('#notifications').height(window.innerHeight - 50);}
        $( window ).resize(function() {resize();});
        resize();


        function refresh_close(){
            $('.close').click(function(){$(this).parent().fadeOut(200);});
             setTimeout(function(){ location.reload(); }, 1000);
        }
</script>

<script type="text/javascript">
    $(document).ready(function() {
        demo.initFormExtendedDatetimepickers(
                {format: 'dd-MM-yyyy'}
        );
    });
</script>




<script  type="text/javascript">
    $(document).ready(function(){
        $('.admn').each(function() {
            var tt = window.location.href;

            if ($(this).find('a').prop('href') == tt) {
                $(this).children().addClass('current');
            }
            if($(this).children().hasClass('in'))
            {
                $(this).addClass('current');
            }

        });
    });
</script>
<script>
    $('#compose, .compose-close').click(function(){
        $('.compose').slideToggle();
    });
</script>
<script type="text/javascript">
    function resize(){$('#notifications')}
        $( window ).resize(function() {resize();});
        resize();


        function refresh_close(){
            $('.close').click(function(){$(this).parent().fadeOut(1000);});
            setTimeout(function(){ location.reload(); }, 1000);
        }
</script>