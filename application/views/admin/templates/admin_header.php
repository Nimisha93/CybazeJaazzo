<div class="top_nav">
<div class="nav_menu">







<nav>



    <ul class="nav navbar-nav navbar-right">


        <li class="">

            <img src="<?php echo base_url(); ?>assets/admin/images/online-portal-logo.png" style="height:50px;">


        </li>


        <li class="help"><a href="#" > <i class="fa fa-question-circle" aria-hidden="true"></i></a> </li>

        <li class="profl1 dropdown">
            <a href="#" class="dropdown-toggle" ><i class="fa fa-user-plus"></i><span class=""> </span></a>

            <ul class="dropdown-menu ">
                <h4>System Administration</h4>
               <li> <a href="<?php echo base_url();?>profile"><i class="fa fa-user" style="margin-right:6px;"></i>My Profile</a></li>
                <li> <a href="<?php echo base_url();?>cpw"><i class="fa fa-cog" style="margin-right:6px;"></i>Account Settings</a></li>
                <li> <a href="<?php echo base_url();?>logout"><i class="fa fa-sign-out" style="margin-right:6px;"></i>Sign Out</a></li>



            </ul>
        </li>


    </ul>
</nav>


<div class="nav toggle lft10">

    <a id="menu_toggle"><i class="fa fa-bars"></i></a>
</div>

<ul class="add-mdulebtton">

    <li role="presentation" class="dropdown" style="margin-top:15px;">
        <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
            <span class="addmdlbtn"> + </span>

        </a>
        <ul id="menu1" class="dropdown-menu mnu-itms" role="menu">
            <div class="col-sm-6">
                <h2 class="sales">Sales</h2>
                <li><a id="fc_create" data-toggle="modal" data-target="#newcstomr"><span class="sbmnu1" style="margin-right:6px;">+</span>Customer</a> </li>
                <li><a href=""><span class="sbmnu1" style="margin-right:6px;">+</span>Log Time</a> </li>
                <li> <a href=""><span class="sbmnu1" style="margin-right:6px;">+</span>Sales order</a> </li>
                <li><a href=""><span class="sbmnu1" style="margin-right:6px;">+</span>Estmate</a> </li>
                <li><a href=""><span class="sbmnu1" style="margin-right:6px;">+</span>Retailer Invoice</a> </li>
                <li><a href=""><span class="sbmnu1" style="margin-right:6px;">+</span>Invoice</a> </li>
                <li><a href=""><span class="sbmnu1" style="margin-right:6px;">+</span>Customer Payment</a> </li>

            </div>

            <div class="col-sm-6">
                <h2 class="prchs">Purchases</h2>
                <li><a id="fc_create" data-toggle="modal" data-target="#newcstomr"><span class="sbmnu1" style="margin-right:6px;">+</span>Customer</a> </li>
                <li><a href=""><span class="sbmnu1" style="margin-right:6px;">+</span>Log Time</a> </li>
                <li> <a href=""><span class="sbmnu1" style="margin-right:6px;">+</span>Sales order</a> </li>
                <li><a href=""><span class="sbmnu1" style="margin-right:6px;">+</span>Estmate</a> </li>
                <li><a href=""><span class="sbmnu1" style="margin-right:6px;">+</span>Retailer Invoice</a> </li>
                <li><a href=""><span class="sbmnu1" style="margin-right:6px;">+</span>Invoice</a> </li>
                <li><a href=""><span class="sbmnu1" style="margin-right:6px;">+</span>Customer Payment</a> </li>

            </div>

        </ul>
    </li>

</ul>

<nav class="navbar navbar-inverse fllft hidemobilmenu" role="navigation" >
    <div class="">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <i class="fa fa-caret-down" aria-hidden="true"></i>
            </button>

        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">


            <ul class="nav navbar-nav">
            <?php
                 $loginsession = $this->session->userdata('logged_in_admin');
                  if($loginsession['type'] == 'super_admin'){ ?>

                <li >
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-home"></i><span class="mnulist">Home</span></a>

                </li>




                <!--=================== add button end here=========================================-->


                <li class="dropdown">
                    <a href="add-ledger.html" class="dropdown-toggle" ><i class="fa fa-cog"></i><span class="mnulist">Organization</span></a>
                    <ul class="dropdown-menu accntsubmnuhide">
                        <h4>Organization</h4>

                        <li><a href="<?php echo base_url() ?>admin/new_designation"><i class="fa fa-plane" style="margin-right:6px;"></i>Add Designation</a></li>
                        <li><a href="<?php echo base_url() ?>admin/new_pool"><i class="fa fa-building" style="margin-right:6px;"></i>Add New Pool</a></li>
                        <li><a href="<?php echo base_url();?>partner_type"><i class="fa fa-sitemap" style="margin-right:6px;"></i>Add channel partner type</a></li>
                        <li><a href="<?php echo base_url();?>channel_partner"><i class="fa fa-sitemap" style="margin-right:6px;"></i>Add channel partner</a></li>
                        <li><a href="<?php echo base_url();?>set_pooling"><i class="fa fa-sitemap" style="margin-right:6px;"></i>Add Commision</a></li>
                        <li><a href="<?php echo base_url();?>product"><i class="fa fa-product-hunt" style="margin-right:6px;"></i>Add Products</a></li>
                        <li><a href="<?php echo base_url();?>exe-add"><i class="fa fa-briefcase" style="margin-right:6px;"></i>Add Executives</a></li>
                        <li><a href="<?php echo base_url();?>add_ba"><i class="fa fa-briefcase" style="margin-right:6px;"></i>Add  BA</a></li>





                    </ul>
                </li>


                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" ><i class="fa fa-address-card"></i><span class="mnulist">Recruitment</span></a>
                    <ul class="dropdown-menu accntsubmnuhide">
                        <h4>Recruitment</h4>
                        <li><a href="<?php echo base_url() ?>view_pooling"><i class="fa fa-id-badge" style="margin-right:6px;"></i>View New Pool</a></li>
                        <li><a href="<?php echo base_url();?>get_partner_type"><i class="fa fa-id-badge" style="margin-right:6px;"></i>View Channel Partner Type</a></li>
                        <li><a href="<?php echo base_url();?>get_channel_partner"><i class="fa fa-id-badge" style="margin-right:6px;"></i>View Channel Partner</a></li>
                        <li><a href="<?php echo base_url();?>channel_pooling"><i class="fa fa-id-badge" style="margin-right:6px;"></i>View Commision</a></li>
                         <li><a href="<?php echo base_url();?>product_list"><i class="fa fa-id-badge" style="margin-right:6px;"></i>View Products</a></li>
                         <li><a href="<?php echo base_url();?>exe-view"><i class="fa fa-id-badge" style="margin-right:6px;"></i>View Executives</a></li>
                          <li><a href="<?php echo base_url();?>privillege_list"><i class="fa fa-id-badge" style="margin-right:6px;"></i>View Privillage</a></li>
                           <li><a href="<?php echo base_url();?>module_list"><i class="fa fa-id-badge" style="margin-right:6px;"></i>View Modules</a></li>
                            <li><a href="<?php echo base_url();?>view_ba"><i class="fa fa-id-badge" style="margin-right:6px;"></i>View BA</a></li>

                    </ul>  
                </li> 

               <!--  <li class="dropdown">

                    <a href="chart-account.html" class="dropdown-toggle" ><i class="fa fa-user"></i><span class="mnulist">Employees</span></a>



                    <ul class="dropdown-menu accntsubmnuhide">
                        <h4>Employees</h4>


                        <li> <a href=""><i class="fa fa-user" style="margin-right:6px;"></i>Employees</a></li>
                        <li> <a href=""><i class="fa fa-user-o" style="margin-right:6px;"></i>Employees Joinig</a></li>
                        <li> <a href=""><i class="fa fa-random" style="margin-right:6px;"></i>Requisitions</a></li>
                        <li> <a href=""><i class="fa fa-chain-broken" style="margin-right:6px;"></i>Resignations</a></li>
                        <li> <a href=""><i class="fa fa-wpforms" style="margin-right:6px;"></i>Complaints</a></li>
                        <li> <a href="#"><i class="fa fa-exclamation-triangle" style="margin-right:6px;"></i>Warnings</a></li>
                        <li> <a href=""><i class="fa fa-stop-circle-o" style="margin-right:6px;"></i>Terminations</a></li>
                        <li> <a href=""><i class="fa fa-external-link-square" style="margin-right:6px;"></i>Employees Exit</a></li>

                    </ul>
                </li> -->


<!-- 
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" ><i class="fa fa-file-o"></i><span class="mnulist"> Balance Sheet</span></a>
                    <ul class="dropdown-menu accntsubmnuhide">
                        <h4>Balance Sheet</h4>
                        <li> <a href="#"><i class="fa fa-address-card-o" style="margin-right:6px;"></i>Attendance</a></li>
                        <li> <a href="#"><i class="fa fa-clock-o" style="margin-right:6px;"></i>Employee Hours</a></li>
                        <li> <a href="#"><i class="fa fa-address-book-o" style="margin-right:6px;"></i>Leaves</a></li>
                        <li> <a href="#"><i class="fa fa-file-text" style="margin-right:6px;"></i>Worksheet</a></li>
                        <li> <a href="#"><i class="fa fa-clone" style="margin-right:6px;"></i>Work Shifts</a></li>
                        <li> <a href="#"><i class="fa fa-file-excel-o" style="margin-right:6px;"></i>Holidays</a></li>

                    </ul>
                </li> -->



               <!--  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" ><i class="fa fa-calculator"></i><span class="mnulist"> Payroll</span></a>
                    <ul class="dropdown-menu accntsubmnuhide">
                        <h4>Payroll</h4>
                        <li> <a href="#"><i class="fa fa-inr" style="margin-right:6px;"></i>Salary</a></li>
                        <li> <a href="#"><i class="fa fa-file-archive-o" style="margin-right:6px;"></i>Salary Payslips</a></li>
                        <li> <a href="#"><i class="fa fa-database" style="margin-right:6px;"></i>Payroll Structure</a></li>
                        <li> <a href="#"><i class="fa fa-file-excel-o" style="margin-right:6px;"></i>Deductions</a></li>
                        <li> <a href="#"><i class="fa fa-cart-plus" style="margin-right:6px;"></i>Bonuses</a></li>
                        <li> <a href="#"><i class="fa fa-adjust" style="margin-right:6px;"></i>Adjustments</a></li>
                        <li> <a href="#"><i class="fa fa-credit-card-alt" style="margin-right:6px;"></i>Reimbursements</a></li>
                        <li> <a href="#"><i class="fa fa-clock-o" style="margin-right:6px;"></i>Overtimes</a></li>
                        <li> <a href="#"><i class="fa fa-money" style="margin-right:6px;"></i>Provident Fund</a></li>
                        <li> <a href="#"><i class="fa fa-credit-card" style="margin-right:6px;"></i>Advance Salary</a></li>


                    </ul>
                </li> -->

                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" ><i class="fa fa-pie-chart"></i> <span class="mnulist"> Reports</span></a>
                    <ul class="dropdown-menu accntsubmnuhide">
                        <h4>Reports</h4>
                        <li> <a href="<?php echo base_url();?>report"><i class="fa fa-globe" style="margin-right:6px;"></i>Designation Reports</a></li>
                        <li> <a href="<?php echo base_url();?>channel"><i class="fa fa-file-archive-o" style="margin-right:6px;"></i>Channel Partner Reports</a></li>
                        <li> <a href="<?php echo base_url();?>clubtype"><i class="fa fa-file-text-o" style="margin-right:6px;"></i>Club Type Reports    </a></li>
                        <li> <a href="<?php echo base_url();?>customer"><i class="fa fa-file-text" style="margin-right:6px;"></i>Customer Reports</a></li>
                        <li><a href="<?php echo base_url();?>members"><i class="fa fa-file-text" style="margin-right:6px;"></i>Club Members Reports</a></li>
               <li><a href="<?php echo base_url();?>executives"><i class="fa fa-file-text" style="margin-right:6px;"></i>Executives Reports</a></li>
<li><a href="<?php echo base_url();?>module"><i class="fa fa-file-text" style="margin-right:6px;"></i> Module Reports</a></li>
                    </ul>


                </li>




<!-- 
                <li>
                    <a href="#" ><i class="fa fa-calendar"></i><span class="mnulist"> Settings</span></a>
                </li>


                <li>
                    <a href="#" ><i class="fa fa-envelope-o" style="margin-right:0px;"></i><span class="mnulist"> Settings</span></a>
                </li> -->


                <li class="dropdown">
                    <a href="<?php echo base_url();?>Notification" class="dropdown-toggle"  ><i class="fa fa-bell-o"></i><span class="mnulist"> Notification</span></a>
                    <ul class="dropdown-menu notictn accntsubmnuhide">


                        <h4>Notification</h4>
                        <li> <a href="<?php echo base_url();?>Notification" style="color:#039"><i class="fa fa-check" style="margin-right:6px;"></i> marked all as read</a></li>
                        <li style="float:left;"> <a href="#" style="color:#039"> <i class="fa fa-globe" style="margin-right:6px;"></i> All notification</a></li>


                        <div class="col-md-12 col-sm-12">

                            <p class="ntfctin"> <a href="#">No notification </a> </p>

                        </div>

                    </ul>
                </li>



                <?php } ?>




            </ul>


        </div>
        <!-- /.navbar-collapse -->
    </div>
    <!-- /.container-fluid -->
</nav>

</div>
</div>