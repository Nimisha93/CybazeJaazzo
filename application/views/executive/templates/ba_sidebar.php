<div class="sidebar" data-active-color="rose" data-background-color="black" data-image="<?php echo base_url();?>assets/admin/img/sidebar-1.jpg">

    <div class="logo">
        <a href="" class="simple-text logo-mini"> </a>
        <a href="" class="simple-text logo-normal">
            Business Associative
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
                          <p>Business Associative</p>
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