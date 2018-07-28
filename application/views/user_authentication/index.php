<?php
if(!empty($authUrl)) {
    echo '<a href="'.$authUrl.'"><img src="'.base_url().'assets/img/fb.png" alt=""/></a>';
}else{
?>
<div class="wrapper">

    <h1>Facebook Profile Details </h1>
    <div class="welcome_txt">Welcome <b><?php echo $userData['name']; ?></b></div>
    <div class="fb_box">
<!--         <p class="image"><img src="<?php echo $userData['photo_url']; ?>" alt="" width="300" height="220"/></p>
 -->        <p><b>Facebook ID : </b><?php echo $userData['auth_hash']; ?></p>
        <p><b>Name : </b><?php echo $userData['name'].' '.$userData['name']; ?></p>
        <p><b>Email : </b><?php echo $userData['email']; ?></p>
<!--         <p><b>Gender : </b><?php echo $userData['gender']; ?></p>
 -->        <p><b>Locale : </b><?php echo $userData['place']; ?></p>
        <p><b>You are login with : </b>Facebook</p>
        <p><a href="<?php echo $userData['profile_url']; ?>" target="_blank">Click to Visit Facebook Page</a></p>
        <p><b>Logout from <a href="<?php echo $logoutUrl; ?>">Facebook</a></b></p>
    </div>
</div>
<?php } ?>
