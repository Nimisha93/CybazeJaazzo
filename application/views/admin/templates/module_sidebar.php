</head>
  <body class="nav-md">
  <div class="container body">
      <div class="main_container">
          <div class="col-md-3 left_col ">
              <div class="left_col scroll-view">
                  <div class="navbar nav_title" style="border: 0;background-color:#313854">

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
                          <!-- <h2>Green india</h2> -->
                          <p>Module</p>

                      </div>
                  </div>
                  <!-- /menu profile quick info -->
                  <!-- sidebar menu -->
                  <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                      <div class="menu_section">
                          <ul class="nav side-menu">
                              
                              <?php $a=1; if($a==0){ ?>
                              <li><a href="<?php echo base_url() ?>my_dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard </a></li>
                              
                              <?php if((has_role('add_channel_partner')==true) || (has_role('add_channel_partner')==true)){?>
                              <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>Commissiond<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                  <?php  if(has_role('dd')==true){?>
                                      <li><a href="<?php echo base_url();?>set_pooling">Add Commision</a></li>
                                  <?php } ?>
                                  <?php  if(has_role('add_channel_partner')==true){?>
                                      <li><a href="<?php echo base_url();?>channel_pooling">View Commision</a></li>
                                  <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>

                              <li><a href="<?php echo base_url();?>Notification"><i class="fa fa-graduation-cap" aria-hidden="true"></i>Notifications
                              <span class="fa fa-chevron-down"></span></a> </li>
                              
                              <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>Products<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <li><a href="<?php echo base_url();?>product">Add Products</a></li>
                                      <li><a href="<?php echo base_url();?>product_list">View Products</a></li>
                                  </ul>
                              </li>
                              
                              <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>Deal<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <li><a href="<?php echo base_url();?>deal">Add Deal</a></li>
                                      <li><a href="<?php echo base_url();?>my_deal">View Deal</a></li>
                                  </ul>
                              </li>
                              
                              <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>Transaction<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <li><a href="<?php echo base_url();?>cp_transaction">Transaction</a></li>
                                  </ul>
                              </li>

                              <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>Bulk Mail<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <li><a href="<?php echo base_url();?>/send_mail">Send Mail</a></li>
                                  </ul>
                              </li>
                              
                              <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>Notification<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <li><a href="<?php echo base_url();?>cp_notification">Notification</a></li>
                                      <li><a href="<?php echo base_url();?>notification_list">View Notification</a></li>
                                  </ul>
                              </li>

                              <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i> mod Privillage<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <li><a href="<?php echo base_url();?>user_privillage">Privillage1</a></li>
                                      <li><a href="<?php echo base_url();?>privillege_list">View Privillage</a></li>
                                      <li><a href="<?php echo base_url();?>user_module">Create Module </a></li>
                                      <li><a href="<?php echo base_url();?>module_list">View Modules </a></li>
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
                              <?php } ?>

                              <?php if((has_role('dashboard')==true)){?>
                              <li><a href="<?php echo base_url() ?>my_dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard </a></li>
                              <?php } ?>
                              
                              <?php if((has_role('add_Commision')==true) || (has_role('view_Commision')==true)){?>
                              <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>Commissiond<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                  <?php  if(has_role('add_Commision')==true){?>
                                      <li><a href="<?php echo base_url();?>set_pooling">Add Commision</a></li>
                                  <?php } ?>
                                  <?php  if(has_role('view_Commision')==true){?>
                                      <li><a href="<?php echo base_url();?>channel_pooling">View Commision</a></li>
                                  <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>

                              <?php if(has_role('notification')==true){?>
                              <li><a href="<?php echo base_url();?>Notification"><i class="fa fa-graduation-cap" aria-hidden="true"></i>Notifications
                              <span class="fa fa-chevron-down"></span></a> </li>
                              <?php } ?>
                              
                              <?php if((has_role('add_products')==true) || (has_role('view_products')==true)){?>
                              <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>Products<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('add_products')==true){?>
                                      <li><a href="<?php echo base_url();?>product">Add Products</a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_products')==true){?>
                                      <li><a href="<?php echo base_url();?>product_list">View Products</a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>

                              <?php if((has_role('add_deal')==true) || (has_role('view_deal')==true)){?>
                              <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>Deal<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('add_deal')==true){?>
                                      <li><a href="<?php echo base_url();?>deal">Add Deal</a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_deal')==true){?>
                                      <li><a href="<?php echo base_url();?>my_deal">View Deal</a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>

                              <?php if(has_role('transaction')==true){?>
                              <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>Transaction<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('transaction')==true){?>
                                      <li><a href="<?php echo base_url();?>cp_transaction">Transaction</a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>

                              <?php if(has_role('send_mail')==true){?>
                              <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>Bulk Mail<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('send_mail')==true){?>
                                      <li><a href="<?php echo base_url();?>/send_mail">Send Mail</a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>
                              
                              <?php if((has_role('cpnotification')==true) || (has_role('view_notification')==true)){?>
                              <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>Notification<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('cpnotification')==true){?>
                                      <li><a href="<?php echo base_url();?>cp_notification">Notification</a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_notification')==true){?>
                                      <li><a href="<?php echo base_url();?>notification_list">View Notification</a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>

                              <?php if((has_role('privillage')==true) || (has_role('view_privillage')==true) || (has_role('create_module')==true) || (has_role('view_module')==true)){?>
                              <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i> mod Privillage<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('privillage')==true){?>
                                      <li><a href="<?php echo base_url();?>user_privillage">Privillage1</a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_privillage')==true){?>
                                      <li><a href="<?php echo base_url();?>privillege_list">View Privillage</a></li>
                                      <?php } ?>
                                      <?php if(has_role('create_module')==true){?>
                                      <li><a href="<?php echo base_url();?>user_module">Create Module </a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_module')==true){?>
                                      <li><a href="<?php echo base_url();?>module_list">View Modules </a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>

                              <?php if(has_role('dashboard')==true){?>
                              <li><a href="<?php echo base_url() ?>my_dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i> Dashboard </a></li>
                              <?php } ?>
                      
                              <?php if((has_role('add_designation')==true) || (has_role('new_pool')==true) || (has_role('view_pool')==true) || (has_role('new_sys_pool')==true) || (has_role('view_sys_pool')==true)){?>
                              <li><a><i class="fa fa fa-cog" aria-hidden="true"></i>System Pool Settings <span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('add_designation')==true){?>
                                      <li><a href="<?php echo base_url() ?>admin/new_designation">Add Designation</a></li>
                                      <?php } ?>
                                      <?php if(has_role('new_pool')==true){?>
                                      <li><a href="<?php echo base_url() ?>new_pool_stage">Create A New Pool stage</a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_pool')==true){?>
                                      <li><a href="<?php echo base_url() ?>view_stages">View Pool stages</a></li>
                                      <?php } ?>
                                      <?php if(has_role('new_sys_pool')==true){?>
                                      <li><a href="<?php echo base_url() ?>new_pool">Add New System Pool</a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_sys_pool')==true){?>
                                      <li><a href="<?php echo base_url() ?>view_pooling">View System Pool</a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>
                              
                              <?php if((has_role('new_bch')==true) || (has_role('view_bch')==true)){?>
                              <li><a><i class="fa fa fa-cog" aria-hidden="true"></i>System BCH Pool Settings <span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('new_bch')==true){?>
                                      <li><a href="<?php echo base_url() ?>new_Bch_pool">Add New Bch System Pool</a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_bch')==true){?>
                                      <li><a href="<?php echo base_url() ?>view_bch_pooling">View Bch Pooling</a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>
                              
                              <?php if((has_role('new_ba')==true) || (has_role('view_ba')==true)){?>
                              <li><a><i class="fa fa fa-cog" aria-hidden="true"></i>System BA Pool Settings <span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('new_ba')==true){?>
                                      <li><a href="<?php echo base_url() ?>new_BA_pool">Add New BA System Pool</a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_ba')==true){?>
                                      <li><a href="<?php echo base_url() ?>view_ba_pooling">View BA Pooling</a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>

                              <?php if((has_role('desigination_report')==true) || (has_role('channel_partner_report')==true) || (has_role('club_tyre_report')==true) || (has_role('customer_report')==true) || (has_role('club_members_report')==true) || (has_role('executives_report')==true) || (has_role('module_report')==true)){?>
                              <li><a><i class="fa fa-file-text" aria-hidden="true"></i>Reports <span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('desigination_report')==true){?>
                                      <li><a href="<?php echo base_url();?>report">Desigination Reports</a></li>
                                      <?php } ?>
                                      <?php if(has_role('channel_partner_report')==true){?>
                                      <li><a href="<?php echo base_url();?>channel">Channel Partner Reports</a></li>
                                      <?php } ?>
                                      <?php if(has_role('club_tyre_report')==true){?>
                                      <li><a href="<?php echo base_url();?>clubtype">Club Type Reports</a></li>
                                      <?php } ?>
                                      <?php if(has_role('customer_report')==true){?>
                                      <li><a href="<?php echo base_url();?>customer">Customer Reports </a></li>
                                      <?php } ?>
                                      <?php if(has_role('club_members_report')==true){?>
                                      <li><a href="<?php echo base_url();?>members">Club Members Reports</a></li>
                                      <?php } ?>
                                      <?php if(has_role('executives_report')==true){?>
                                      <li><a href="<?php echo base_url();?>executives">Executives Reports</a></li>
                                      <?php } ?>
                                      <?php if(has_role('module_report')==true){?>
                                      <li><a href="<?php echo base_url();?>module">Module Reports</a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>

                              <?php if((has_role('add_cp_type')==true) || (has_role('view_cp_type')==true) || (has_role('add_cp')==true) || (has_role('view_cp')==true)){?>
                              <li><a><i class="fa fa-user" aria-hidden="true"></i>Channel Partner <span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('add_cp_type')==true){?>
                                      <li><a href="<?php echo base_url();?>partner_type">Add Channel Partner Type</a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_cp_type')==true){?>
                                      <li><a href="<?php echo base_url();?>get_partner_type">View Channel Partner Type</a></li>
                                      <?php } ?>
                                      <?php if(has_role('add_cp')==true){?>
                                      <li><a href="<?php echo base_url();?>channel_partner">Add Channel Partner</a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_cp')==true){?>
                                      <li><a href="<?php echo base_url();?>get_channel_partner">View Channel Partner</a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>

                              <?php if((has_role('add_Commision')==true) || (has_role('view_Commision')==true)){?>
                              <li><a><i class="fa fa-inr" aria-hidden="true"></i>Commission<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('add_commision')==true){?>
                                      <li><a href="<?php echo base_url();?>set_pooling">Add Commision</a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_commision')==true){?>
                                      <li><a href="<?php echo base_url();?>channel_pooling">View Commision</a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>

                              <?php if(has_role('notification')==true){?>
                              <li><a href="<?php echo base_url();?>Notification"><i class="fa fa-commenting-o" aria-hidden="true"></i>Notification<span class="fa fa-chevron-down"></span></a>
                              </li>
                              <?php } ?>

                              <?php if((has_role('add_products')==true) || (has_role('view_products')==true)){?>
                              <li><a><i class="fa fa-product-hunt" aria-hidden="true"></i>Products<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('add_products')==true){?>
                                      <li><a href="<?php echo base_url();?>product">Add Products</a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_products')==true){?>
                                      <li><a href="<?php echo base_url();?>product_list">View Products</a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>

                              <?php if(has_role('transaction')==true){?>
                              <li><a><i class="fa fa-exchange" aria-hidden="true"></i>Transaction<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('transaction')==true){?>
                                      <li><a href="<?php echo base_url();?>transaction"> Transaction</a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>

                              <?php if((has_role('add_exec')==true) || (has_role('view_exec')==true) || (has_role('exec_set')==true)){?>
                              <li><a><i class="fa fa-briefcase" aria-hidden="true"></i>Executive Settings<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('add_exec')==true){?>
                                      <li><a href="<?php echo base_url();?>exe-add">Add Executives</a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_exec')==true){?>
                                      <li><a href="<?php echo base_url();?>exe-view">View Executives</a></li>
                                      <?php } ?>
                                      <?php if(has_role('exec_set')==true){?>
                                      <li><a href="<?php echo base_url();?>exe-select">Executive Promotion Settings</a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>

                              <?php if((has_role('privillage')==true) || (has_role('view_privillage')==true) || (has_role('create_module')==true) || (has_role('view_module')==true)){?>
                              <li><a><i class="fa fa-lock" aria-hidden="true"></i>Admin Privillage<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('privillage')==true){?>
                                      <li><a href="<?php echo base_url();?>privillage">Privillage</a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_privillage')==true){?>
                                      <li><a href="<?php echo base_url();?>privillege_list">View Privillage</a></li>
                                      <?php } ?>
                                      <?php if(has_role('create_module')==true){?>
                                      <li><a href="<?php echo base_url();?>new_module">Create Module </a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_module')==true){?>
                                      <li><a href="<?php echo base_url();?>module_list">View Modules </a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>

                              <?php if((has_role('add_ba')==true) || (has_role('view_ba')==true)){?>
                              <li><a><i class="fa fa-briefcase" aria-hidden="true"></i>BA Settings<span class="fa fa-chevron-down"></span></a>
                                  <ul class="nav child_menu">
                                      <?php if(has_role('add_ba')==true){?>
                                      <li><a href="<?php echo base_url();?>add_ba">Add BA</a></li>
                                      <?php } ?>
                                      <?php if(has_role('view_ba')==true){?>
                                      <li><a href="<?php echo base_url();?>view_ba">View BA</a></li>
                                      <?php } ?>
                                  </ul>
                              </li>
                              <?php } ?>


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
                                      <li><a href="profile.php">My Profile</a></li>
                                      <li><a href="#">Account Settings</a></li>
                                      <li> <a href="#">Sign Out</a></li>

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