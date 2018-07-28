 <?php echo $header; ?>

<body>
<div class="wrapper">

  <?php echo $sidebar; ?>


    <div class="content">
        <div class="container-fluid">


            <div class="col-md-12">

                <div class="card">
<div class="card-header card-header-icon" data-background-color="purple">
Notifications
    
</div><br><br>

                    <div class="card-content">
                              <?php 
                        foreach($admin_notification as $key=>$admin){
                    ?>
                        <div class="alert alert-rose alert-with-icon" data-notify="container" id="admin">
                            <i class="material-icons" data-notify="icon">notifications</i>
                            <button type="button" aria-hidden="true" class="close" value="<?php echo $admin['id'];?> " id='close1'>
                                <i class="material-icons">close</i>
                            </button>
                              <span data-notify="message">Notification From Admin!!!...
                            </span>
                             <span data-notify="message"><?php echo $admin['title'];?> 
                            </span>
                            <span data-notify="message"><?php echo $admin['description'];?> 
                            </span>
                        </div>
                        <?php } ?>
                    <?php 
                        foreach($notification_club as $key=>$type){
                    ?>
                        <div class="alert alert-rose alert-with-icon" data-notify="container">
                            <i class="material-icons" data-notify="icon">notifications</i>
                            <button type="button" aria-hidden="true" class="close">
                                <i class="material-icons">close</i>
                            </button>
                            <span data-notify="message">A Club Member Named <?php echo $type['name'];?> is activated.
                            </span>
                        </div>
                        <?php } ?>
                        <?php 
                        foreach($notification_channel as $key=>$type1){
                    ?>
                        <div class="alert alert-rose alert-with-icon" data-notify="container">
                            <i class="material-icons" data-notify="icon">notifications</i>
                            <button type="button" aria-hidden="true" class="close">
                                <i class="material-icons">close</i>
                            </button>
                            <span data-notify="message">A Club Channel Partner Named <?php echo $type1['name'];?> is activated.
                            </span>
                        </div>
                        <?php } ?>
                        <?php 
                        foreach($reward_notification as $key=>$re){
                    ?>
                        <div class="alert alert-rose alert-with-icon" data-notify="container">
                            <i class="material-icons" data-notify="icon">notifications</i>
                            <button type="button" aria-hidden="true" class="close">
                                <i class="material-icons">close</i>
                            </button>
                            <span data-notify="message">A Club Channel Partner Named <?php echo $re['change_value'];?> is activated.
                            </span>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php echo $footer; ?>


</body>
<script>
    $(document).on("click","#close1",function(e) {
        e.preventDefault();
       
        var id = $(this).val();
       // alert(from);
        $.post('<?= base_url(); ?>admin/Executives/close_notification',{id:id},function(data)
        {
            if(data.status)
            {
             $('#admin').hide();
            }
         

        },'json');

    });
    </script>
</html>