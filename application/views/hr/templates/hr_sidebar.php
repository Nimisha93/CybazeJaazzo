</head>
  <body class="nav-md">
  <div class="container body">
  <div class="main_container">
  <div class="col-md-3 left_col ">
      <div class="left_col scroll-view">
          <div class="navbar nav_title" style="border: 0;background-color:#6673a0">
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
                <li><a href="<?php echo base_url() ?>hr_dashboard"><i class="fa fa-tachometer" aria-hidden="true"></i>
                  Dashboard </a></li>
                <?php if (has_priv('add_branch')||has_priv('view_branch')) { ?>  
                <li><a><i class="fa fa fa-cog" aria-hidden="true"></i>Branch<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php if (has_priv('add_branch')) { ?>
                    <li><a href="<?php echo base_url();?>add_branch">Add Branch</a>
                     
                    </li>
                    <?php }?>
                    <?php if (has_priv('view_branch')) { ?>
                    <li><a href="<?php echo base_url();?>branch_list">View Branch</a></li>
                    <?php }?>
                  </ul>
                </li>
                <?php } ?>
                <?php if (has_priv('add_department')||has_priv('add_designation')) { ?>
                <li><a><i class="fa fa-sitemap" aria-hidden="true"></i>Department <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php if (has_priv('add_department')) { ?>
                    <li><a href="<?php echo base_url() ?>add_department"> Departments</a></li>
                    <?php }?>
                    <?php if (has_priv('add_designation')) { ?>
                    <li><a href="<?php echo base_url() ?>designations">Designations</a></li>
                    <?php }?>
                  </ul>
                </li>
                <?php } ?>
                <?php if (has_priv('view_preferences')) { ?>
                <li>
                <a href="<?php echo base_url();?>preference"><i class="fa fa-hourglass-half " aria-hidden="true"></i>Preference</a></a>
                </li>
                <?php } ?>
                <?php if (has_priv('view_employee')||has_priv('view_employee')) { ?>
                <li><a><i class="fa fa-users" aria-hidden="true"></i>Employees<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php if (has_priv('view_employee')) { ?>
                    <li><a href="<?php echo base_url();?>employee"> All Employees</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_employee')) { ?>
                    <li><a href="<?php echo base_url();?>active_employees">Active Employees</a></li>
                    <?php } ?>
                  </ul>
                </li>
                <?php } ?>
                <?php if (has_priv('view_warning')||has_priv('view_requisition')||has_priv('view_complaint')||has_priv('view_termination')||has_priv('view_exit')||has_priv('view_resignation')) { ?>
                <li><a><i class="fa fa-exclamation-circle" aria-hidden="true"></i>Employee Actions<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php if (has_priv('view_warning')) { ?>
                    <li><a href="<?php echo base_url();?>warnings">Warnings</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_requisition')) { ?>
                    <li><a href="<?php echo base_url();?>requisition">Requisitions</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_complaint')) { ?>
                    <li><a href="<?php echo base_url();?>complaints">Complaints</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_termination')) { ?>
                    <li><a href="<?php echo base_url();?>terminations">Terminations</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_exit')) { ?>
                    <li><a href="<?php echo base_url();?>employee_exit">Employee Exits</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_resignation')) { ?>
                    <li><a href="<?php echo base_url();?>resignation">Resignation</a></li>
                    <?php } ?>
                   <!--  <li><a href="<?php echo base_url();?>set_pooling">Add Commision</a></li>
                    <li><a href="<?php echo base_url();?>channel_pooling">View Commision</a></li> -->
                  </ul>
                </li>
                <?php } ?>
                <?php if (has_priv('add_payment')||has_priv('view_payment')||has_priv('view_paid_slip')||has_priv('view_advance')) { ?>
                <li><a><i class="fa fa-money" aria-hidden="true"></i>Payroll<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <!-- <li><a href="<?php echo base_url();?>category_type">Add Category</a></li>
                    <li><a href="<?php echo base_url();?>view_category">ViewCategory</a></li> -->
                    <?php if (has_priv('add_payment')) { ?>
                    <li><a href="<?php echo base_url();?>payments">Pay Salary</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_payment')) { ?>
                    <li><a href="<?php echo base_url();?>salary_list">Salary  Payslip</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_paid_slip')) { ?>
                    <li><a href="<?php echo base_url();?>paid_salary_list">Paid Salary Payslip</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_advance')) { ?>
                    <li><a href="<?php echo base_url();?>advance_salary">Advance Salary</a></li>
                    <?php } ?>
                  </ul>
                </li>
                <?php } ?>
                <?php if (has_priv('view_recruitment_requisition')||has_priv('view_posts')||has_priv('view_candidates')||has_priv('view_shortlist')||has_priv('view_selected')) { ?>
                <li><a><i class="fa fa-user-plus" aria-hidden="true"></i>Recruitment<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php if (has_priv('view_recruitment_requisition')) { ?>
                    <li><a href="<?php echo base_url();?>requisitions">Requisitions</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_posts')) { ?>
                    <li><a href="<?php echo base_url();?>posts">Job Posts</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_candidates')) { ?>
                    <li><a href="<?php echo base_url();?>candidates">Candidates</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_shortlist')) { ?>
                    <li><a href="<?php echo base_url();?>shortlists">Shortlists</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_selected')) { ?>
                    <li><a href="<?php echo base_url();?>selected">Selected</a></li>
                    <?php } ?>
                  </ul>
                </li>
                <?php } ?>
                <?php if (has_priv('view_levetype')||has_priv('view_leaves')||has_priv('add_leave_assign')) { ?>
                <li><a><i class="fa fa-clock-o" aria-hidden="true"></i>Time Sheets<span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <?php if (has_priv('view_levetype')) { ?>
                    <li><a href="<?php echo base_url();?>leavetype"> Leave Types</a></li>
                    <?php } ?>
                    <?php if (has_priv('view_leaves')) { ?>
                    <li><a href="<?php echo base_url();?>leaves">Leaves</a></li><?php } ?>
                    <?php if (has_priv('add_leave_assign')) { ?>
                    <li><a href="<?php echo base_url();?>assign_leaves">Assign
                                            Leaves</a></li>
                    <?php } ?> 
                  </ul>
                </li>
                <?php } ?>
                <?php if (has_priv('view_hr_report')){ ?>
                <li><a><i class="fa fa-file-text" aria-hidden="true"></i>Reports <span class="fa fa-chevron-down"></span></a>
                  <ul class="nav child_menu">
                    <li><a>Employees<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li>
                          <a href="<?php echo base_url();?>hr/Employee/get_all_emp_joining_report">Employee
                                                    Joining Report</a>
                        </li>
                        <li>
                          <a href="<?php echo base_url();?>hr/Employee/get_active_employee_report">Active
                                                    Employees</a>
                        </li>
                        <li>
                          <a href="<?php echo base_url();?>hr/Employee/get_requisition_report">Requisition
                                                    Report</a>
                        </li>
                        <li>
                          <a href="<?php echo base_url();?>hr/complaint/get_complaint_reports">Complaint
                                                    Report</a>
                        </li>

                         <li><a href="<?php echo base_url();?>hr/employee_terminations/get_termination_report">Termination Report</a></li>


                          <li>
                          <a href="<?php echo base_url();?>hr/employee_warning/get_warning_report">Warning
                                                    Report</a>
                        </li>

                             <li>
                          <a href="<?php echo base_url();?>hr/employee_exit/get_exit_report">Exit
                                                    Report</a>
                        </li>

                             <li>
                          <a href="<?php echo base_url();?>hr/Recruitment/get_all_requisition_report">Recruitment
                                                    Report</a>
                        </li>


                      </ul>
                    </li>



                    <li><a href="<?php echo base_url();?>hr/Employee/get_designation_report">Designation Report</a></li>


                    <li><a>Hr Report<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li>
                          <a href="<?php echo base_url();?>hr/report/departments_list">Departments</a>
                        </li>
                        <li>
                          <a href="<?php echo base_url();?>hr/report/birthdays_calendar">Birthday
                                                    Calender</a>
                        </li>
                      </ul>
                    </li>
                   
                    <li><a>Payroll Report<span class="fa fa-chevron-down"></span></a>
                      <ul class="nav child_menu">
                        <li>
                          <a href="<?php echo base_url();?>hr/Payroll/get_payslip_report">Salary
                                                    Pay Slip</a>
                        </li>
                        <li>
                          <a href="<?php echo base_url();?>hr/Payroll/pf_report">PF Report</a>
                        </li>

                         <li>
                          <a href="<?php echo base_url();?>hr/Payroll/esi_report">ESIC Report</a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <?php } ?>
              <!--   <li><a href="<?php echo base_url();?>index.php/admin/dashboard/main_admin"><i class="fa fa-tachometer" aria-hidden="true"></i>Inventory<span class="fa fa-chevron-down"></span></a> -->
              </ul>
            </div>


          </div>
      </div>
  </div>
<!-- <script src="<?php echo base_url();?>assets/admin/js/jquery.min.js"></script>   -->
  <!-- top navigation -->
<?php $this->load->view('hr/templates/hr_header') ?>