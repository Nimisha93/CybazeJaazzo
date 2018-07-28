<style>
        .body_blur {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 99999;
            background-color: rgba(0,0,0,0.4);
            background-image: url("<?php echo base_url(); ?>assets/admin/images/ajax-loader.gif");
            background-position: center;
            background-repeat: no-repeat;
            background-size: 30px 30px;
            display: none;
        }
     #notification-count{
         padding: 3px 7px 3px 7px;
         background: #cc0000;
         color: #ffffff;
         font-weight: bold;
         margin-left: 23px;
         border-radius: 9px;
         -moz-border-radius: 9px;
         -webkit-border-radius: 9px;
         position: absolute;
         margin-top: 0px;
         font-size: 11px;
         z-index: 1;
     }

      #notification-count2{
         padding: 3px 7px 3px 7px;
         background: #cc0000;
         color: #ffffff;
         font-weight: bold;
         margin-left: 23px;
         border-radius: 50%;
       
         position: absolute;
         margin-top: -12px;
         font-size: 11px;
         z-index: 1;
     }

     .notsu  
     {  
        background-color: #fff;
    padding: 9px 11px 9px 13px;
    text-align: center;
    border-radius: 50%;
    position: relative;
    display: inline-block;
}

 </style>


<div class="body_blur" style="display: none"></div>
<div class="sidebar" data-active-color="rose" data-background-color="black" data-image="assets/img/sidebar-1.jpg">

    <div class="logo">
        <a href="" class="simple-text logo-mini"> </a>
        <a href="" class="simple-text logo-normal">
            Admin Panel
        </a>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <?php
                 if(empty($profile->profile_image)){
                    $img = $user['profile_image'];
                   
                 }else{
                     
                     $img = "assets/img/default-avatar.png";
                 } 
                ?>
                <img src="<?php echo base_url().$img; ?>" />
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    <span>
                              <?= $user['name']; ?>
                                <b class="caret"></b>
                            </span>
                </a>
                <div class="clearfix"></div>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li class="admn">
                            <a href="<?= base_url() ?>cp_profile">
                                <i class="fa fa-user"></i>
                                <span class=""> My Profile </span>
                            </a>
                        </li>
                        <li class="admn">
                            <a href="<?= base_url() ?>cp_settings">
                                <i class="fa fa-cog"></i>
                                <span class=""> Settings </span>
                            </a>
                        </li>
                        <li class="admn">
                            <a href="<?= base_url() ?>logout">
                                <i class="fa fa-sign-out"></i>
                                <span class=""> Logout </span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <ul class="nav">
            <li class="admn active"><a href="<?= base_url() ?>admin/channel_partner/"><i class="material-icons">dashboard</i><p> Dashboard
            </p></a></li>
            <li class="admn">
                <a href="<?php echo base_url() ?>billing">
                    <i class="fa fa-commenting-o" aria-hidden="true"></i>
                    <p>Billing</p>
                </a>
            </li>
            <li class="admn">
                <a href="<?php echo base_url() ?>cp_notification/0">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    <p>Purchase Notification</p>
                </a>
            </li>
            <li class="admn">
                <a href="<?php echo base_url() ?>set_commission/0">
                    <i class="fa fa fa-inr" aria-hidden="true"></i>
                    <p> Commission Settings</p>
                </a>
            </li>
            <li class="admn">
                <a data-toggle="collapse" href="#products">
                    <i class="fa fa-product-hunt" aria-hidden="true"></i>
                    <p> Products
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="products">
                    <ul class="nav">
                        <li>
                            <a href="<?php echo base_url() ?>cp_product">
                                <span class="sidebar-mini"> <i class="fa fa-angle-double-right lightcolr"
                                                               aria-hidden="true"></i> </span>
                                <span class="sidebar-normal"> Add Products </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>cp_product_list/0">
                                <span class="sidebar-mini">
                                    <i class="fa fa-angle-double-right lightcolr" aria-hidden="true"></i> </span>
                                <span class="sidebar-normal"> View Products</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>


            <li class="admn">
                <a data-toggle="collapse" href="#deals">
                    <i class="fa fa-thumbs-up" aria-hidden="true"></i>
                    <p> Deals
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="deals">
                    <ul class="nav">
                        <li>
                            <a href="<?php echo base_url() ?>deal">
                                <span class="sidebar-mini"> <i class="fa fa-angle-double-right lightcolr"
                                                               aria-hidden="true"></i> </span>
                                <span class="sidebar-normal"> Purchase Deals </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url() ?>purchased_deal">
                                <span class="sidebar-mini"> <i class="fa fa-angle-double-right lightcolr"
                                                               aria-hidden="true"></i> </span>
                                <span class="sidebar-normal">Your Deals </span>
                            </a>
                        </li>
                        
                        <li>
                            <a href="<?php echo base_url() ?>view_deal/0">
                                <span class="sidebar-mini"> <i class="fa fa-angle-double-right lightcolr"
                                                               aria-hidden="true"></i> </span>
                                <span class="sidebar-normal"> View Deals</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo base_url() ?>coupon_purchased_users">
                                <span class="sidebar-mini"> <i class="fa fa-angle-double-right lightcolr"
                                                               aria-hidden="true"></i> </span>
                                <span class="sidebar-normal">Coupon Purchased Users</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            
            <li class="admn">
                <a href="<?= base_url() ?>cp_transaction">
                    <i class="fa fa-exchange" aria-hidden="true"></i>
                    <p>Transaction</p>
                </a>
            </li>
           <!--  <li class="admn">
                <a href="sendmail.php">
                    <i class="fa fa-envelope-o" aria-hidden="true"></i>
                    <p> Send Mail</p>
                </a>
            </li> -->

            <li class="admn">
                <a href="<?= base_url() ?>cp_wallet_report">
                    <i class="fa fa-google-wallet" aria-hidden="true"></i>
                    <p>Wallet Statement</p>
                </a>
            </li>
           
            <li class="admn">
                <a href="<?= base_url() ?>inbox">
                    <i class="fa fa-bell-o"></i>
                    <p> Inbox</p>
                </a>
            </li>
        </ul>

    </div>

</div>
<div class="main-panel">
<?php

 if(empty($user['profile_image']) || empty($user['brand_image']) || empty($user['address']) || empty($user['phone2']) || ($commission_settings)){ ?>
<marquee style = "background-color: #c1c1c1;
    padding: 20px;
    color: #d43131;
    font-size: 16px;
">Please update your profile and set commission soon!</marquee>
<?php } ?>
    <nav class="navbar navbar-transparent navbar-absolute">
        <div class="container-fluid">
            <div class="navbar-minimize">
                <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                    <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                    <i class="material-icons visible-on-sidebar-mini">view_list</i>
                </button>
              
               <!--  <span id="notification-count">12</span> -->
               <?php if($notification!=0){ ?>
                     <a  href="<?php echo base_url() ?>cp_notification/0" class="dropdown-toggle">
                        <div class="notsu">
                          <span id="notification-count2"><?= $notification; ?></span>
                          <i class="fa fa-bell"  id="notificationLink"></i>
                        </div>
                     </a>
                <?php } ?>
            </div>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#"> </a>
            </div>
            <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav navbar-right">

                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle logoutbtn" data-toggle="dropdown">
                            <i class="material-icons">person</i>

                        </a>
                        <ul class="dropdown-menu">
                            <li>
                                <a href="<?php echo base_url();?>logout">
                                    <i class="fa fa-sign-out" aria-hidden="true"></i>logout
                                </a>

                            </li>
                        </ul>
                    </li>

                </ul>

            </div>
        </div>
    </nav>
