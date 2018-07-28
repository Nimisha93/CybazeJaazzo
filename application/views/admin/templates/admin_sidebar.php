</head>
  <body class="nav-md">
  <div class="container body">
  <div class="main_container">
  <div class="col-md-3 left_col ">
      <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;background-color:#313854">
              <a href="<?php echo base_url() ?>" class="site_title whiteclr"> <img src="<?php echo base_url(); ?>assets/admin/images/adminl-logo.png" style="height:50px;"></a>
          </div>
          <!-- menu profile quick info -->
          <div class="profile clearfix">

              <div class="profile_info">
                <?php
                 $loginsession = $this->session->userdata('logged_in_admin');
                  if($loginsession['type'] == 'super_admin'){
                    $name = 'Admin';
                  }else{
                    $id = $loginsession['user_id'];
                    $details =get_emp_det_by_id($id);
                    $name = $details['name'];
                  } 
                ?>
                  <span>Welcome <?= $name; ?></span>
                  <!-- <h2>Green india</h2> -->
              </div>
          </div>
          <!-- /menu profile quick info -->
          <!-- sidebar menu -->
          <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
            <div class="menu_section">
              <ul class="nav side-menu">
                <li><a href="<?php echo base_url() ?>index.php/admin/dashboard/main_admin"><i class="fa fa-tachometer" aria-hidden="true"></i>
                  Dashboard </a></li>
                <?php if (has_priv('view_services')||has_priv('view_banr_adv')||has_priv('view_servce_adv')||has_priv('view_servce_adv')) { ?>
                <li><a><i class="fa fa-file-text-o" aria-hidden="true"></i>Front End<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                  
                     <?php if (has_priv('view_services')) { ?>
                    <li><a href="<?php echo base_url();?>module_list/0">Services</a></li>
                     <?php }?>
                     <?php if (has_priv('view_banr_adv')) { ?>
                    <li><a href="<?= base_url() ?>ads-view">Banner Advertisements</a></li> <?php }?>
                    <?php if (has_priv('view_servce_adv')) { ?>
                    <li><a href="<?php echo base_url();?>view_ads">Services Advertisements</a></li><?php }?>

                    <?php if (has_priv('view_servce_adv')) { ?>
                    <li><a href="<?php echo base_url();?>view_brands/0">Brands</a></li><?php }?>
                  </ul>
                </li>
                <?php } ?>
                <?php if (has_priv('manage_cm_type')||has_priv('view_club_member')||has_priv('view_tl')||has_priv('approve_cm')||has_priv('view_cl_agent')) { ?>
                <li><a><i class="fa fa fa-user" aria-hidden="true"></i>Club Membership<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php if (has_priv('manage_cm_type')) { ?>
                    <li><a href="<?= base_url() ?>club">Add New Club Member Type</a></li>
                    <li><a href="<?= base_url() ?>all_club_types/0">All Club Member Type</a></li>
                    <!-- <li><a href="<?= base_url() ?>all_clubs">All Club Member Type</a></li> -->
                    <?php } ?>
                    <?php if (has_priv('view_club_member')) { ?> 
                    <li><a href="<?= base_url() ?>all_club_members/0">Approved Club Members</a></li>  <?php } ?> 
                    <?php if (has_priv('view_tl')) { ?>
                    <li><a href="<?= base_url() ?>investor_club_members/0">Team Lead Club <!-- (Investor Club Members) --></a></li>
                    <?php } ?>
                    <?php if (has_priv('approve_cm')) { ?>
                    <li><a href="<?= base_url() ?>approve_club_members/0">Approve Club Members</a></li> 
                    <?php } ?>
                    <?php if (has_priv('view_cl_agent')) { ?>
                    <li><a href="<?= base_url() ?>all_club_agents/0">All Club Agents</a></li> 
                    <?php } ?>
                  </ul>
                </li>
                <?PHP }?>
                <?php if (has_priv('view_norm_custmr')) { ?>
                <li><a href="<?php echo base_url();?>normal_users/0"><i class="fa fa-users" aria-hidden="true"></i>Normal 
                Customers</a></a>
                </li>
                <?php } ?>
                <?php if (has_priv('view_cp_type')) { ?>
                <li><a href="<?php echo base_url();?>get_partner_type/0"><i class="fa fa-server" aria-hidden="true"></i>Channel Partner Types</a>
                </li>
                <?php } ?>
                <?php if (has_priv('add_cp')||has_priv('view_reffered_cp')||has_priv('view_tl_reffered_cp')||has_priv('approve_cp')||has_priv('view_approved_cp')||has_priv('view_joined_cp')||has_priv('view_coupon_purchased_cp')||has_priv('deactivate_cp')) { ?>
                <li><a><i class="fa fa-building" aria-hidden="true"></i>Channel Partner <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php if (has_priv('add_cp')) { ?>
                    <li><a href="<?php echo base_url();?>partner">Add Channel Partner</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_reffered_cp')) { ?> 
                    <li><a href="<?php echo base_url();?>get_reffered_cp/0">Reffered Channel Partners</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_tl_reffered_cp')) { ?> 
                    <li><a href="<?php echo base_url();?>get_tl_reffered_cp/0">Reffered Channel Partners -Team Lead Club </a></li>
                    <?php } ?>
                    <?php if (has_priv('approve_cp')) { ?> 
                    <li><a href="<?php echo base_url();?>get_unapproved_cp/0">Approve Channel Partners</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_approved_cp')) { ?> 
                    <li><a href="<?php echo base_url();?>get_approved_cp/0">Approved Channel Partners</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_joined_cp')) { ?> 
                    <li><a href="<?php echo base_url();?>get_active_cp/0">Joined Channel Partners</a></li>                     
                    <?php } ?>
                    <?php if (has_priv('view_coupon_purchased_cp')) { ?> 
                    <li><a href="<?php echo base_url();?>pay_cp/0">Coupon Purchased Users </a></li>
                    <?php } ?>
                    <?php if (has_priv('deactivate_cp')) { ?> 
                    <li><a href="<?php echo base_url();?>cp_status/0">Activation Status</a></li>
                    <?php } ?>
                  </ul>
                </li>
                <?php } ?>
                 <li><a href="#"><i class="fa fa-user-times" aria-hidden="true"></i>Deactivation<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo base_url();?>temporary_deactivation/0">Temporary</a>
                       </li>
                    <li><a href="<?php echo base_url();?>permanent_deactivation/0">Permanent</a>
                       </li>  
                  </ul> 
                </li>
                <?php if (has_priv('manage_deal')) { ?>
                <li><a href="#"><i class="fa fa-thumbs-o-up" aria-hidden="true"></i>Deals<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo base_url();?>deal_settings/0">Add New Deal</a>
                       </li>
                    <li><a href="<?php echo base_url();?>approve_deals/0">Approve Purchased Deals</a>
                       </li>  
                  </ul> 
                </li>
                <?php } ?>
                <?php if (has_priv('add_products')||has_priv('view_products')) { ?>
                <li><a><i class="fa fa-product-hunt" aria-hidden="true"></i>Products<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <!-- <li><a href="<?php echo base_url();?>category_type">Add Category</a></li>
                    <li><a href="<?php echo base_url();?>view_category">ViewCategory</a></li> -->

                    <?php if (has_priv('add_products')) { ?>
                    <li><a href="<?php echo base_url();?>product">Add Products</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_products')) { ?>
                    <li><a href="<?php echo base_url();?>product_list/0">View Products</a></li>
                    <?php } ?>
                  </ul>
                </li>
                <?php } ?>
                <?php if (has_priv('view_pending_amount')||has_priv('view_transaction_history')||has_priv('approve_cp_transaction')||has_priv('view_excute_pending_amount')||has_priv('view_executive_transaction_history')||has_priv('view_tl_club_pending_amount')||has_priv('view_ca_pending_amount')) { ?>
                <li><a><i class="fa fa-exchange" aria-hidden="true"></i>Transaction<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                      <?php if (has_priv('view_pending_amount')) { ?>
                        <li><a href="#">Cp Pending Amounts
                          <span class="fa fa-chevron-down"></span></a>
                          <ul class="nav child_menu">
                            <li><a href="<?php echo base_url();?>transaction/0">To Cp</a>
                            </li>
                            <li><a href="<?php echo base_url();?>pending_transaction/0">From Cp</a>
                            </li>    
                          </ul>
                        </li>
                      <?php } ?>
                      <?php if (has_priv('view_transaction_history')) { ?>
                      <li><a href="<?php echo base_url();?>cp_transaction_history/0">Cp Transaction History</a></li>
                      <?php } ?>
                      <?php if (has_priv('approve_cp_transaction')) { ?>
                      <li><a href="<?php echo base_url();?>approve_cp_transaction/0">Approve Cp Transaction</a></li>
                      <?php } ?>
                      <?php if (has_priv('view_excute_pending_amount')||has_priv('view_executive_transaction_history')) { ?>
                      <li><a href="#">Executives Transaction
                        <span class="fa fa-chevron-down"></span></a>
                        <ul class="nav child_menu">
                          <?php if (has_priv('view_excute_pending_amount')) { ?>
                            <li><a href="<?php echo base_url();?>transaction_executive/0">Executives Pending Amounts</a>
                             </li>
                          <?php } ?> 
                          <?php if (has_priv('view_executive_transaction_history')) { ?>
                            <li><a href="<?php echo base_url();?>executive_transaction_history/0">Transaction History </a>
                            </li> 
                          <?php } ?>     
                        </ul>
                      </li>
                      <?php } ?>
                      <?php if (has_priv('view_tl_club_pending_amount')) { ?>
                      <li><a href="<?php echo base_url();?>cm_transaction/0">Team Lead Club- Pending Amounts</a></li>
                      <?php } ?>
                      <?php if (has_priv('view_ca_pending_amount')) { ?>
                      <li><a href="<?php echo base_url();?>ca_transaction/0">Club Agents- Pending Amounts</a></li>
                      <?php } ?>
                  </ul>
                </li>
                <?php } ?>
                <?php if (has_priv('add_commision')||has_priv('view_commision')) { ?>
                <li><a><i class="fa fa-inr" aria-hidden="true"></i>Commission<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php if (has_priv('add_commision')) { ?>
                    <li><a href="<?php echo base_url();?>set_pooling_ratio">Set Pooling Commission</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_commision')) { ?>
                    <li><a href="<?php echo base_url();?>commission_approval/0">Approve Commission</a></li>
                    <?php } ?>
                   <!--  <li><a href="<?php echo base_url();?>set_pooling">Add Commision</a></li>
                    <li><a href="<?php echo base_url();?>channel_pooling">View Commision</a></li> -->
                  </ul>
                </li>
                <?php } ?>
                <?php if (has_priv('add_pool_designation')||has_priv('new_pool')||has_priv('view_pool')) { ?>
                <li><a><i class="fa fa fa-cog" aria-hidden="true"></i>System Pool Settings <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php if (has_priv('add_pool_designation')) { ?>
                    <li><a href="<?php echo base_url() ?>new_designation/0">Add Designation</a></li>
                    <?php }?>
                    <?php if (has_priv('new_pool')) { ?>
                    <li><a href="<?php echo base_url() ?>new_pool">Add New Pool</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_pool')) { ?>
                    <li><a href="<?php echo base_url() ?>view_pooling">View All Pools</a></li>
                    <?php }?>
                  </ul>
                </li>
                <?php } ?>
                <?php if (has_priv('view_preferences')) { ?>
                <li><a href="<?= base_url() ?>preferences"><i class="fa fa-star" aria-hidden="true"></i>Preferences</a></li>
                <?php }?>
                <?php if (has_priv('notification')) { ?>
                  <li><a href="<?php echo base_url();?>All_notifications/0"><i class="fa fa-commenting-o" aria-hidden="true"></i>Notification</a>
                  </li>
                <?php } ?>
                <?php if (has_priv('view_feedback')) { ?>
                <li><a href="<?php echo base_url();?>feedback/0"><i class="fa fa-commenting-o" aria-hidden="true"></i>Feedback</a>
                </li>
                <?php } ?>
                <!-- <li><a><i class="fa fa-graduation-cap" aria-hidden="true"></i>View Activity<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo base_url();?>activity/0">View Activity</a></li>
                  </ul>
                </li> -->
                <?php if (has_priv('send_mail')||has_priv('send_sms')) { ?>
                <li><a><i class="fa fa-envelope-open-o" aria-hidden="true"></i>CRM<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php if (has_priv('send_mail')) { ?>
                    <li><a href="<?php echo base_url();?>bulk_mail"> Bulk Mail</a></li>
                    <?php } ?>
                    <?php if (has_priv('send_sms')) { ?>
                    <li><a href="<?php echo base_url();?>bulk_sms"> Bulk SMS</a></li>
                    <?php } ?>
                  </ul>
                </li>
                <?php } ?>
                <?php if (has_priv('add_exec') || has_priv('manage_bde_des') || has_priv('view_exec') || has_priv('exec_set')|| has_priv('view_promoted_employee') || has_priv('add_promotion_gifts')) { ?>
                <li><a><i class="fa fa-briefcase" aria-hidden="true"></i>Executive Settings<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <!-- <li><a href="<?php echo base_url();?>exe-dashboard">Executive Dashboard</a></li> -->
                    <?php if (has_priv('add_exec') || has_priv('manage_bde_des')) { ?>
                    <li><a href="<?php echo base_url();?>exe-add">Add Executives</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_exec') || has_priv('manage_bde_des')) { ?>
                    <li><a href="<?php echo base_url();?>exe-view/0">View Executives</a></li>
                    <?php } ?>
                    <!-- <li><a href="<?php echo base_url();?>exe-cpw">Change Password</a></li> -->
                    <!-- <li><a href="<?php echo base_url();?>exe-clubmsadd">Add Club Membership</a></li> -->
                    <!-- <li><a href="<?php echo base_url();?>exe-clubmsview">View Club Membership</a></li> -->
                    <?php if (has_priv('exec_set')) { ?> 
                    <li><a href="<?php echo base_url();?>exe-select">Executive  Promotion Settings</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_promoted_employee')) { ?>
                    <li><a href="<?php echo base_url();?>promoted_employee/0">Promoted Employees </a></li>
                    <?php } ?>
                    <?php if (has_priv('add_promotion_gifts')) { ?>
                    <li><a href="<?php echo base_url();?>set_gift">Promotion Gifts</a></li>
                    <?php } ?>
                  </ul>
                </li>
                <?php }?>
                <?php if (has_priv('add_ba')||has_priv('add_ba_design')||has_priv('view_ba')||has_priv('view_ba_des')) { ?>
                <li><a><i class="fa fa-briefcase" aria-hidden="true"></i>Jaazzo Store Settings<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php if (has_priv('add_ba')||has_priv('add_ba_design')) { ?>
                    <li><a href="<?php echo base_url();?>add_ba">Add  Jaazzo Store </a></li>
                    <?php }?>
                    <?php if (has_priv('view_ba')||has_priv('view_ba_des')) { ?>
                    <li><a href="<?php echo base_url();?>view_ba/0">View Jaazzo Store </a></li>
                    <?php }?>
                  </ul>
                </li>
                <?php } ?>
                <?php if (has_priv('manage_privilege')) { ?>
                <li><a><i class="fa fa-lock" aria-hidden="true"></i>Privillages<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo base_url();?>privilleges/0">View Privillages</a></li>
                    <li><a href="<?php echo base_url();?>view_members/0">View Normal Privillege Members</a></li>
                    <li><a href="<?php echo base_url();?>view_designation_members/0">View Designation Wise Privillege Members</a></li>
                  </ul>
                </li>
                <?php } ?>
                <?php if (has_priv('view_wallet')) { ?>
                <li><a><i class="fa fa-google-wallet" aria-hidden="true"></i>Wallet<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo base_url();?>wallet_overview">Overview</a></li>
                    <li><a href="<?php echo base_url();?>wallet/0">Wallet Report</a></li>
                  </ul>
                </li>
                <?php }?>
                <?php if (has_priv('manage_accounts')) { ?>
                <li><a href="<?php echo base_url();?>ledgers/0"><i class="fa fa-calculator" aria-hidden="true"></i>Accounts<span class="fa fa-chevron-down"></span></a></li>
                <?php }?>
                <li><a href="<?php echo base_url();?>hr_dashboard"><i class="fa fa-users" aria-hidden="true"></i>HR<span class="fa fa-chevron-down"></span></a> </li>
                <?php if (has_priv('view_report')) { ?>
                <li><a><i class="fa fa-file-text" aria-hidden="true"></i>Reports <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a href="<?php echo base_url();?>designation_report/0">Desiginations Report</a></li>
                    <li><a>Channel Partners Report<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li>
                          <a href="<?php echo base_url();?>channel_partner_report/0">Typewise Channel Partners</a>
                        </li>
                        <li>
                          <a href="<?php echo base_url();?>cm_channelpartners/0">ClubMemberwise Channel Partners</a>
                        </li>
                        <li>
                          <a href="<?php echo base_url();?>exe_channelpartners/0">Executivewise Channel Partners</a>
                        </li>
                        <li>
                          <a href="<?php echo base_url();?>admin_channelpartners/0">Adminwise Channel Partners</a>
                        </li>
                      </ul>
                    </li>
                    <li><a href="<?php echo base_url();?>clubtype_report/0">Club Types Report</a></li>
                    <li><a>Club Members Report<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li>
                          <a href="<?php echo base_url();?>club_members_by_type/0">Typewise Club Members</a>
                        </li>
                        <li>
                          <a href="<?php echo base_url();?>club_members_by/0">Created By Club Members</a>
                        </li>
                      </ul>
                    </li>
                    <li><a href="<?php echo base_url();?>clubagents_report/0">Club Agents Report</a></li>
                    <li><a href="<?php echo base_url();?>customers_report/0">Customers Report </a></li>
                    <li><a href="<?php echo base_url();?>pooling_report/0">Pooling Report </a></li>
                    <li><a>Purchase Report<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li>
                          <a href="<?php echo base_url();?>purchase_by_customers/0">Customers wise</a>
                        </li>
                        <li>
                          <a href="<?php echo base_url();?>purchase_by_cp/0">Channel Partnerswise</a>
                        </li>
                      </ul>
                    </li>
                    <li><a href="<?php echo base_url();?>ba_report/0">BA Report </a></li> 
                    <li><a href="<?php echo base_url();?>executives/0">Executives Reports</a> </li><li><a href="<?php echo base_url();?>transaction_report/0">Transaction Reports</a> </li>
                    <!-- <li><a href="<?php echo base_url();?>module">Module Reports</a></li> -->
                  </ul>
                </li>
                <?php } ?>
              </ul>
            </div>
            <div class="menu_section">
              <h3>Common</h3>
              <ul class="nav side-menu">
<!--                   <li><a href="#"><i class="fa fa-bell-o"></i> Inbox </a></li>
 -->                <li><a><i class="fa fa-user-plus"></i> System Administration <span class="fa fa-chevron-down"></span></a>
                    <ul class="nav child_menu">
<!--                           <li><a href="<?php echo base_url();?>profile">My Profile</a></li>
 -->                  <li><a href="<?php echo base_url();?>cpw">Account Settings</a></li>
                      <li> <a href="<?php echo base_url();?>logout">Sign Out</a></li>
                    </ul>
                  </li>
              </ul>
            </div>
          </div>
      </div>
  </div>
<!-- <script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>   -->
  <!-- top navigation -->
<?php $this->load->view('admin/templates/admin_header') ?>