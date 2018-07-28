</head>
  <body class="nav-md">
  <div class="container body">
  <div class="main_container">
  <div class="col-md-3 left_col ">
      <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;background-color:#6b88a5">
              <a href="<?php echo base_url() ?>" class="site_title whiteclr"> <img src="<?php echo base_url(); ?>assets/admin/images/adminl-logo.png" style="height:50px;"></a>
          </div>
          <!-- menu profile quick info -->
          <div class="profile clearfix">
<!--              <div class="profile_pic">-->
<!--                  <img src="--><?php //echo base_url(); ?><!--assets/admin/images/online-portal-logo.png" alt="..." class="img-circle profile_img">-->
<!--              </div>-->
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
              <!--  <li><a href="<?php echo base_url() ?>hr_dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i>
                  Dashboard </a></li> -->
                <?php if (has_priv('manage_accounts')) { ?>
                <li><a href="<?php echo base_url();?>ledgers/0"><i class="fa fa-inr" aria-hidden="true"></i> Ledgers</a>
                </li>
                <li><a href="<?php echo base_url();?>entries/0"><i class="fa fa-credit-card-alt" aria-hidden="true"></i> Entries</a>
                </li>
                <li><a href="<?php echo base_url();?>ledger_statement"><i class="fa fa-money" aria-hidden="true"></i> Ledger Statement</a>
                </li>
                <li><a href="<?php echo base_url();?>trial_balance/0"><i class="fa fa-file-o" aria-hidden="true"></i> Trial balance</a>
                </li>
                <li><a href="<?php echo base_url();?>profit_loss"><i class="fa fa-file-text" aria-hidden="true"></i> Profit & Loss</a>
                </li>
                <li><a href="<?php echo base_url();?>balance_sheet"><i class="fa fa-file-o" aria-hidden="true"></i> Balance Sheet</a>
                </li>
                <li><a href="<?php echo base_url();?>add_financial_year"><i class="fa fa-file-o" aria-hidden="true"></i>Account Settings</a>
                </li>
                <?php } ?>
              </ul>
            </div>
          </div>
      </div>
  </div>
<!-- <script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>   -->
  <!-- top navigation -->
<?php $this->load->view('accounts/templates/acc_header') ?>