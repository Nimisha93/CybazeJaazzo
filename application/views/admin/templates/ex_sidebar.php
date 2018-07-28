</head>

  <body class="nav-md">
  <div class="container body">
      <div class="main_container">
          <div class="col-md-3 left_col ">
              <div class="left_col scroll-view">
                  <div class="navbar nav_title" style="border: 0;background-color:#313854">

                      <a href="index.html" class="site_title whiteclr">Jaazzo</a>


                  </div>

                  <div class="clearfix"></div>

                    <!-- menu profile quick info -->
                   <div class="profile clearfix">
                      <div class="profile_pic">
                  <img src="<?php echo base_url();?>upload/<?= $user['image'];?>" alt="" class="img-circle profile_img">  
                      </div>
                      <div class="profile_info">
                      <span>Welcome
                      </span> 
                         <?= $user['name'];?> 
                          <p>Executive</p>


                      </div>
                  </div>
                  <!-- /menu profile quick info -->



                  <!-- sidebar menu -->
                  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                      <div class="menu_section">

                          <ul class="nav side-menu">




                              
                              <!-- <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>Executive Settings<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu"> -->
                            
                              <!-- <li><a href="<?php echo base_url();?>exe-add">Add Executives</a></li> -->
                              <!-- <li><a href="<?php echo base_url();?>exe-view">View Executives</a></li> -->
                              <?php  if(has_role('add_channel_partner')==true){?>
                              <li><a href="<?php echo base_url();?>exe-cpw">Change Password</a></li>
                              <?php } ?>
                              <?php  if(has_role('view_channel_partner')==true){?>
                              <li><a href="<?php echo base_url();?>exe-clubmsadd">Add Club Membership</a></li>
                              <?php } ?>
                              <?php  if(has_role('edit_channel_partner')==true){?>
                              <li><a href="<?php echo base_url();?>exe-clubmsview">View Club Membership</a></li>
                              <?php } ?>
                              <?php  if(has_role('delete_channel_partner')==true){?>
                              <li><a href="<?php echo base_url();?>exe-clubmsview">Delete Club Membership</a></li>
                              <?php } ?>
                              
                               <li><a><i class="fa fa-google-wallet" aria-hidden="true"></i>Wallet<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <li><a href="<?php echo base_url();?>exe-wallet">Wallet Report</a></li>
                                  </ul>
                              </li>
                                      

                                      <!-- <li><a href="<?php echo base_url();?>exe-select">Executive Promotion Settings</a></li> -->

                          <!-- </ul>
                      </li> -->
                              <!-- <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>Products<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <li><a href="<?php echo base_url();?>product">Add Products</a></li>
                                      <li><a href="<?php echo base_url();?>product_list">View Products</a></li>

                                  </ul>
                              </li> -->

<!--                              <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>Designation<span class="fa fa-chevron-down"></span></a>-->
<!--                                  <ul class="nav child_menu">-->
<!--                                      <li><a href="add--designation.php">Add Designation</a></li>-->
<!---->
<!--                                  </ul>-->
<!--                              </li>-->


                              <!--                      <li><a><i class="fa fa-user" aria-hidden="true"></i>Team Member <span class="fa fa-chevron-down"></span></a>-->
                              <!--                          <ul class="nav child_menu">-->
                              <!--                              <li><a href="add-team-member.php">Add Team Member</a></li>-->
                              <!---->
                              <!--                          </ul>-->
                              <!--                      </li>-->

                              <!--                      <li><a><i class="fa fa-user-circle" aria-hidden="true"></i>Club Member <span class="fa fa-chevron-down"></span></a>-->
                              <!--                          <ul class="nav child_menu">-->
                              <!--                              <li><a href="add-club-member.php">Add Club Member</a></li>-->
                              <!--                              <li><a href="add-clubmember-type.php">Add Club Member Type</a></li>-->
                              <!--                          </ul>-->
                              <!--                      </li>-->
                              <!---->

                              <!--                      <li><a><i class="fa fa-archive" aria-hidden="true"></i>Products <span class="fa fa-chevron-down"></span></a>-->
                              <!--                          <ul class="nav child_menu">-->
                              <!--                              <li><a href="add-products.php">Add Products</a></li>-->
                              <!---->
                              <!--                          </ul>-->
                              <!--                      </li>-->
                              <!---->
                              <!--                      <li><a><i class="fa fa-thumbs-up" aria-hidden="true"></i>Deals <span class="fa fa-chevron-down"></span></a>-->
                              <!--                          <ul class="nav child_menu">-->
                              <!--                              <li><a href="add-new-deals.php">Add New Deals</a></li>-->
                              <!---->
                              <!--                          </ul>-->
                              <!--                      </li>-->
                              <!---->
                              <!---->
                              <!--                      <li><a><i class="fa fa-pie-chart" aria-hidden="true"></i>Reports <span class="fa fa-chevron-down"></span></a>-->
                              <!--                          <ul class="nav child_menu">-->
                              <!--                              <li><a href="all-product-report.php">All Products Report</a></li>-->
                              <!--                              <li><a href="total-customer-report.php">Totel Cutomers Report</a></li>-->
                              <!--                              <li><a href="purchase-report.php">Purchase Report</a></li>-->
                              <!---->
                              <!--                          </ul>-->
                              <!--                      </li>-->

                              <!--                      <li><a href="c"><i class="fa fa-star" aria-hidden="true"></i>Activity Log </a>-->
                              <!---->
                              <!--                      </li>-->
                              <!---->
                              <!--                      <li><a href="c"><i class="fa fa-question-circle" aria-hidden="true"></i>Enquery </a>-->
                              <!---->
                              <!--                      </li>-->





                          </ul>
                      </div>

                      <div class="menu_section">
                          <h3>Common</h3>
                          <ul class="nav side-menu">
                              <li><a href="#"><i class="fa fa-calendar"></i> Calendar </a>
                                  <!--<ul class="nav child_menu">
                                    <li><a href="e_commerce.html">E-commerce</a></li>
                                    <li><a href="projects.html">Projects</a></li>
                                    <li><a href="project_detail.html">Project Detail</a></li>
                                    <li><a href="contacts.html">Contacts</a></li>
                                    <li><a href="profile.html">Profile</a></li>
                                  </ul>-->
                              </li>

                              <li><a href="<?php echo base_url();?>Notification"><i class="fa fa-envelope-o"></i> Notification </a> </li>
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