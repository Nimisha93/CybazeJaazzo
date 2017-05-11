</head>

  <body class="nav-md">
  <div class="container body">
      <div class="main_container">
          <div class="col-md-3 left_col ">
              <div class="left_col scroll-view">
                  <div class="navbar nav_title" style="border: 0;background-color:#84868b">

                      <a href="index.html" class="site_title whiteclr">Green India</a>


                  </div>

                  <div class="clearfix"></div>

                  <!-- menu profile quick info -->
                  <div class="profile clearfix">
                      <div class="profile_pic">
                          <img src="<?php echo base_url(); ?>assets/admin/images/img.jpg" alt="..." class="img-circle profile_img">
                      </div>
                      <div class="profile_info">
                          <span>Welcome,</span>
                          <h2>Green india</h2>
                          <p>Business Centre Head</p>


                      </div>
                  </div>
                  <!-- /menu profile quick info -->



                  <!-- sidebar menu -->
                  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                      <div class="menu_section">

                          <ul class="nav side-menu">




                              <li><a href="<?php echo base_url() ?>bch"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard </a></li>


                              <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>Club Members<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <li><a href="<?php echo base_url();?>admin/clubmember/new_clubmember">Add Club Members</a></li>
                                      <li><a href="<?php echo base_url();?>list_members">View Club Members</a></li>
                                  </ul>
                              </li>
                             <li><a><i class="fa fa-google-wallet" aria-hidden="true"></i>Wallet<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <li><a href="<?php echo base_url();?>bch-wallet">Wallet Report</a></li>
                                  </ul>
                              </li>

                      
                          </ul>
                      </div>

                      <div class="menu_section">
                          <h3>Common</h3>
                          <ul class="nav side-menu">
                              <li><a href="calendar.php"><i class="fa fa-calendar"></i> Calendar </a>
                                  <!--<ul class="nav child_menu">
                                    <li><a href="e_commerce.html">E-commerce</a></li>
                                    <li><a href="projects.html">Projects</a></li>
                                    <li><a href="project_detail.html">Project Detail</a></li>
                                    <li><a href="contacts.html">Contacts</a></li>
                                    <li><a href="profile.html">Profile</a></li>
                                  </ul>-->
                              </li>
                              <li><a href="#"><i class="fa fa-envelope-o"></i> Notification </a> </li>
                              <li><a href="#"><i class="fa fa-bell-o"></i> Inbox </a></li>
                              <li><a><i class="fa fa-user-plus"></i> System Administration <span class="fa fa-chevron-down"></span></a>

                                  <ul class="nav child_menu">
                                       <li><a href="<?php echo base_url();?>profile">My Profile</a></li>
                              <li><a href="<?php echo base_url();?>cpw">Account Settings</a></li>
                              <li> <a href="<?php echo base_url();?>logout">Sign Out</a></li>

                                  </ul>

                              </li>

                          </ul>
                          </li>

                          </ul>
                      </div>
                  </div>

              </div>
          </div>

          <!-- top navigation -->
<?php $this->load->view('admin/templates/admin_header') ?>