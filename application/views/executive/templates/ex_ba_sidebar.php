<div class="sidebar" data-active-color="rose" data-background-color="black" data-image="<?php echo base_url();?>assets/admin/img/sidebar-1.jpg">

    <div class="logo">
        <a href="" class="simple-text logo-mini"> </a>
        <a href="" class="simple-text logo-normal">
            Business Associate
        </a>
    </div>
    <div class="sidebar-wrapper">
        <div class="user">
            <div class="photo">
                <img src="<?php echo base_url();?>upload/exec_profile/<?php echo $user['image'];?>" />
            </div>
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    <span>
                        <?= $user['name'];?> 
                          <p>Executive</p>
                                <b class="caret"></b>
                            </span>
                </a>
                <div class="clearfix"></div>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li class="admn">
                            <a href="<?php echo base_url();?>profile">
                                <i class="fa fa-user"></i>
                                <span class=""> My Profile </span>
                            </a>
                        </li>
                        <li class="admn">
                           <a href="<?php echo base_url();?>exe-setting">
                                <i class="fa fa-cog"></i>
                                <span class=""> Settings </span>
                            </a>
                        </li>
                        <li class="admn">
                            <a href="<?php echo base_url();?>logout">
                                <i class="fa fa-sign-out"></i>
                                <span class=""> Logout </span>
                            </a>
                        </li>

                    </ul>
                </div>
            </div>
        </div>

        <ul class="nav">
            <li class="admn active"><a href="<?php echo base_url();?>admin/executives/exec_dashboard"><i class="material-icons">dashboard</i><p> Dashboard
            </p></a>
            </li>
             <li class="admn">
                <a href="<?php echo base_url();?>view_wallet">
                    <i class="fa  fa-inr" aria-hidden="true"></i>
                    <p> Purchase</p>
                </a>
            </li>





            <li class="admn">
                <a data-toggle="collapse" href="#products">
                    <i class="fa fa-handshake-o" aria-hidden="true"></i>
                    <p> Channel Partner
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="products">
                    <ul class="nav">
                        <li>
                            <a href="<?php echo base_url();?>Add_channel_partner">
                                <span class="sidebar-mini"> <i class="fa fa-angle-double-right lightcolr"
                                                               aria-hidden="true"></i> </span>
                                <span class="sidebar-normal"> Add Channel Partner </span>
                            </a>
                        </li>

                        <li>
                           <a href="<?php echo base_url();?>view_active_channel_partner">
                                <span class="sidebar-mini"> <i class="fa fa-angle-double-right lightcolr"
                                                               aria-hidden="true"></i> </span>
                                <span class="sidebar-normal">View Active Channel Partner </span>
                            </a>
                        </li>

                        <li>
                            
                             <a href="<?php echo base_url();?>view_channel_partner">
                                <span class="sidebar-mini"> <i class="fa fa-angle-double-right lightcolr"
                                                               aria-hidden="true"></i> </span>
                                <span class="sidebar-normal"> View reffered Channel Partner </span>
                            </a>
                        </li>



                    </ul>
                </div>
            </li>
            <li class="admn">
                <a data-toggle="collapse" href="#deals">
                    <i class="fa fa-address-card-o" aria-hidden="true"></i>
                    <p> Club Agent
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="deals">
                    <ul class="nav">
                        <li>
                            <a href="<?php echo base_url();?>add_club_agent">
                                <span class="sidebar-mini"> <i class="fa fa-angle-double-right lightcolr"
                                                               aria-hidden="true"></i> </span>
                                <span class="sidebar-normal">  Add Club Agent </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>view_club_agent">
                                <span class="sidebar-mini"> <i class="fa fa-angle-double-right lightcolr"
                                                               aria-hidden="true"></i> </span>
                                <span class="sidebar-normal"> View reffered Club Agent</span>
                            </a>
                        </li>

                        <li>
                            <a href="<?php echo base_url();?>view_active_club_agent">
                                <span class="sidebar-mini"> <i class="fa fa-angle-double-right lightcolr"
                                                               aria-hidden="true"></i> </span>
                                <span class="sidebar-normal"> View Active Club Agent</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
            <?php 
            if($user['add_exec']==1){
                ?>
            <li class="admn">
                <a data-toggle="collapse" href="#Executives">
                    <i class="fa fa-user-secret" aria-hidden="true"></i>
                    <p> Executives
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="Executives">
                    <ul class="nav">
                        <li>
                            <a href="<?php echo base_url();?>tm_executive">
                                <span class="sidebar-mini"> <i class="fa fa-angle-double-right lightcolr"
                                                               aria-hidden="true"></i> </span>
                                <span class="sidebar-normal">Add Executives </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>tm_exec_view/0">
                                <span class="sidebar-mini"> <i class="fa fa-angle-double-right lightcolr"
                                                               aria-hidden="true"></i> </span>
                                <span class="sidebar-normal"> View Executives</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
          <?php } ?>

            <li class="admn">
                <a data-toggle="collapse" href="#ba">
                    <i class="fa fab fa-btc" aria-hidden="true"></i>
                    <p> BA
                        <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="ba">
                    <ul class="nav">
                        <li>
                            <a href="<?php echo base_url();?>exec_add_ba">
                                <span class="sidebar-mini"> <i class="fa fa-angle-double-right lightcolr" aria-hidden="true"></i> </span>
                                <span class="sidebar-normal">Add BA </span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>exec_view_ba">
                                <span class="sidebar-mini"> <i class="fa fa-angle-double-right lightcolr" aria-hidden="true"></i> </span>
                                <span class="sidebar-normal">View BA</span>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>
   


            <li class="admn">
                <a href="<?php echo base_url();?>view_pro_exec">
                    <i class="fa fa-briefcase" aria-hidden="true"></i>
                    <p> Executive Promotion Settings</p>
                </a>
            </li>

            <li class="admn">
                <a href="<?php echo base_url();?>view_notification">
                    <i class="fa fa-commenting-o" aria-hidden="true"></i>
                    <p> Notification</p>
                </a>
            </li>

            <li class="admn">
                <a href="<?php echo base_url();?>view_wallet">
                    <i class="fa  fa-inr" aria-hidden="true"></i>
                    <p> Wallet</p>
                </a>
            </li>






            <!--<li><a  href="#formsExamples"><i class="fa fa-clone" aria-hidden="true"></i><p> My Pages</p></a></li>-->

        </ul>

    </div>

</div>
<div class="main-panel">
    <nav class="navbar navbar-transparent navbar-absolute">
        <div class="container-fluid">
            <div class="navbar-minimize">
                <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                    <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                    <i class="material-icons visible-on-sidebar-mini">view_list</i>
                </button>
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