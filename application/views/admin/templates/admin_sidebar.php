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
                  <img src="<?php echo base_url(); ?>assets/admin/images/online-portal-logo.png" alt="..." class="img-circle profile_img">
              </div>
              <div class="profile_info">
                  <span>Welcome,</span>
                  <!-- <h2>Green india</h2> -->
                  <p>admin</p>



              </div>
          </div>
          <!-- /menu profile quick info -->



          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">

                  <ul class="nav side-menu">



                     <li><a href="<?php echo base_url() ?>index.php/admin/dashboard/main_admin"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard </a></li>
                     <!--  <li><a href="<?php echo base_url() ?>my_dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard </a></li> -->
                      <li><a><i class="fa fa fa-cog" aria-hidden="true"></i>System Pool Settings <span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                              <li><a href="<?php echo base_url() ?>admin/new_designation">Add Designation</a></li>
                              <li><a href="<?php echo base_url() ?>new_pool_stage">Create A New Pool stage</a></li>
                              <li><a href="<?php echo base_url() ?>view_stages">View Pool stages</a></li>
                              <li><a href="<?php echo base_url() ?>new_pool">Add New System Pool</a></li>
                              <li><a href="<?php echo base_url() ?>view_pooling">View System Pool</a></li>

                          </ul>
                      </li>
                      <li><a><i class="fa fa fa-cog" aria-hidden="true"></i>System BCH Pool Settings <span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                              <li><a href="<?php echo base_url() ?>new_Bch_pool">Add New Bch System Pool</a></li>
                              <li><a href="<?php echo base_url() ?>view_bch_pooling">View Bch Pooling</a></li>

                          </ul>
                      </li>
                      <li><a><i class="fa fa fa-cog" aria-hidden="true"></i>System BA Pool Settings <span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">

                              <li><a href="<?php echo base_url() ?>new_BA_pool">Add New BA System Pool</a></li>
                              <li><a href="<?php echo base_url() ?>view_ba_pooling">View BA Pooling</a></li>

                          </ul>
                      </li>
                      <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>ADS<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">


                              <li><a href="<?php echo base_url();?>Ads">Add Models Ads</a></li>
                              <li><a href="<?php echo base_url();?>view_ads">view Models Ads</a></li>

                          </ul>
                      </li>
                      <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>view activity<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">


                              
                              <li><a href="<?php echo base_url();?>activity">view activity</a></li>

                          </ul>
                      </li>

                       <li><a><i class="fa fa-file-text" aria-hidden="true"></i>Reports <span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">

                          <li><a href="<?php echo base_url();?>report">Desigination Reports</a></li>
                             <li><a href="<?php echo base_url();?>channel">Channel Partner Reports</a></li>
                               <li><a href="<?php echo base_url();?>clubtype">Club Type Reports</a></li>
                              <li><a href="<?php echo base_url();?>customer">Customer Reports </a></li>
                              
                              <li><a href="<?php echo base_url();?>members">Club Members Reports</a></li>
                              
                              <li><a href="<?php echo base_url();?>executives">Executives Reports</a></li>
                              <li><a href="<?php echo base_url();?>module">Module Reports</a></li>
                              

                          </ul>
                      </li>
                      
       <li><a><i class="fa fa fa-cog" aria-hidden="true"></i>Advertisement<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                         
                              <li><a href="<?= base_url() ?>ads">Add advertisement</a></li>
                              
                              <li><a href="<?= base_url() ?>ads-view">view Advertisement</a></li>




                          </ul>
                      </li>


                      <li><a><i class="fa fa-user" aria-hidden="true"></i>Channel Partner <span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                              <li><a href="<?php echo base_url();?>partner_type">Add Channel Partner Type</a></li>
                              <li><a href="<?php echo base_url();?>get_partner_type">View Channel Partner Type</a></li>
                              <li><a href="<?php echo base_url();?>channel_partner">Add Channel Partner</a></li>
                              <li><a href="<?php echo base_url();?>get_channel_partner">View Channel Partner</a></li>

                          </ul>
                      </li>
                      <li><a><i class="fa fa-inr" aria-hidden="true"></i>Commission<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                              <li><a href="<?php echo base_url();?>set_pooling">Add Commision</a></li>
                              <li><a href="<?php echo base_url();?>channel_pooling">View Commision</a></li>
                          </ul>
                      </li>
                      <li><a href="<?php echo base_url();?>Notification"><i class="fa fa-commenting-o" aria-hidden="true"></i>Notification<span class="fa fa-chevron-down"></span></a>
                      </li>
                      <li><a><i class="fa fa-product-hunt" aria-hidden="true"></i>Products<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                              <li><a href="<?php echo base_url();?>category_type">Add Category</a></li>
                              <li><a href="<?php echo base_url();?>view_category">ViewCategory</a></li>
                              <li><a href="<?php echo base_url();?>product">Add Products</a></li>
                              <li><a href="<?php echo base_url();?>product_list">View Products</a></li>

                          </ul>
                      </li>

                      <!-- <li><a><i class="fa fa fa-cog" aria-hidden="true"></i>System Pool Settings <span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                              <li><a href="<?php echo base_url() ?>admin/new_designation">Add Designation</a></li>
                              <li><a href="<?php echo base_url() ?>admin/new_pool">Add New Pool</a></li>
                              <li><a href="<?php echo base_url() ?>view_pooling">Add New Pool</a></li>


                          </ul>
                      </li> -->
                      <li><a><i class="fa fa-exchange" aria-hidden="true"></i>Transaction<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                              <li><a href="<?php echo base_url();?>transaction"> Transaction</a></li>

                          </ul>
                      </li>
                      <li><a><i class="fa fa-briefcase" aria-hidden="true"></i>Executive Settings<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                              <!-- <li><a href="<?php echo base_url();?>exe-dashboard">Executive Dashboard</a></li> -->
                              <li><a href="<?php echo base_url();?>exe-add">Add Executives</a></li>
                              <li><a href="<?php echo base_url();?>exe-view">View Executives</a></li>
                              <!-- <li><a href="<?php echo base_url();?>exe-cpw">Change Password</a></li> -->
                              <!-- <li><a href="<?php echo base_url();?>exe-clubmsadd">Add Club Membership</a></li> -->
                              <!-- <li><a href="<?php echo base_url();?>exe-clubmsview">View Club Membership</a></li> -->
                              <li><a href="<?php echo base_url();?>exe-select">Executive Promotion Settings</a></li>

                          </ul>
                      </li>
                      <li><a><i class="fa fa-lock" aria-hidden="true"></i>Admin Privillage<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                              <li><a href="<?php echo base_url();?>privillage">Privillage</a></li>
                              <li><a href="<?php echo base_url();?>privillege_list">View Privillage</a></li>
                              <li><a href="<?php echo base_url();?>new_module">Create Module </a></li>
                              <li><a href="<?php echo base_url();?>module_list">View Modules </a></li>
                          </ul>
                      </li>
                      <li><a><i class="fa fa-briefcase" aria-hidden="true"></i>BA Settings<span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">

                              <li><a href="<?php echo base_url();?>add_ba">Add  BA</a></li>
                              <li><a href="<?php echo base_url();?>view_ba">View BA</a></li>

                          </ul>
                      </li>
                      <li><a><i class="fa fa-google-wallet" aria-hidden="true"></i>Wallet<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <li><a href="<?php echo base_url();?>wallet">Wallet Report</a></li>
                                  </ul>
                              </li>
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

<!-- <li><a><i class="fa fa-user" aria-hidden="true"></i>Reports <span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                              <li><a href="<?php echo base_url();?>customer">Customers </a></li>
                              <li><a href="<?php echo base_url();?>channel">Channel Partner</a></li>
                              <li><a href="<?php echo base_url();?>members">Club Member </a></li>
                              <li><a href="<?php echo base_url();?>report">Desigination Type</a></li>
                              <li><a href="<?php echo base_url();?>clubtype">Club  Type</a></li>
                              <li><a href="<?php echo base_url();?>module">Module</a></li>
                              <li><a href="<?php echo base_url();?>executives">Exicutives</a></li>

                          </ul>
                      </li> -->



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