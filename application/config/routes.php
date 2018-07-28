<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home';
//$route['login']='/Home/login_mobile';
$route['create_an_account']='/Home/create_an_account_mob';
$route['become_ba']='/Home/become_ba_mob';
$route['add_agent']='/Home/add_agent';
$route['admin']='/admin/Login';
$route['my_dashboard']='admin/channel_partner';
$route['logout']='admin/login/loged_out';
$route['admin/new_pool']='admin/Pooling/new_pool';
$route['new_designation/(:num)']='admin/pooling/new_designation/$1';
$route['edit_system_pooling']='admin/pooling/full_system_pool_settings';
$route['pooling_details/:num']='admin/pooling/full_system_pool_settings/$1';


$route['partner_type']='admin/home/partner_type';
$route['cp_sub_type']='admin/Channel_partner/cp_sub_type';
$route['partner']='admin/Home/new_partner';
$route['channel_partner']='/admin/Login/cp_login';
//$route['get_partner_type1']='admin/home/view_partner_type1';
$route['get_partner_type/(:num)']='admin/home/view_partner_type/$1';
$route['get_channel_partner']='admin/Home/view_channelpartner';
$route['get_reffered_cp/:num']='admin/Home/get_reffered_cp/$1';
$route['get_tl_reffered_cp/:num']='admin/Home/get_tl_reffered_cp/$1';
//$route['get_unapproved_cp']='admin/Home/get_unapproved_cp';
$route['get_unapproved_cp/:num']='admin/Home/get_unapproved_cp/$1';
$route['get_approved_cp/:num']='admin/Home/get_approved_cp/$1';
$route['get_active_cp/:num']='admin/Home/get_active_cp/$1';
$route['pay_cp/(:num)']='admin/Home/get_cp_payments/$1';
$route['permanent_deactivation/(:num)']='admin/Home/get_permanent_deactivated_cp/$1';
$route['temporary_deactivation/(:num)']='admin/Home/get_temporary_deactivated_cp/$1';
$route['set_pooling']='admin/Pooling/new_commision';
$route['set_pooling_ratio']='admin/Pooling/set_commission';
$route['channel_pooling']='admin/Pooling/get_commision_all';
$route['view_cp_commission']='admin/Channel_partner/get_cp_commission';
$route['set_commission/(:num)']='admin/Channel_partner/set_cp_commission/$1';
$route['deal']='admin/Deal/new_deal';
$route['view_deal/(:num)']='admin/Deal/get_deal/$1';
$route['purchased_deal']='admin/Deal/view_purchased_deal';
$route['more_deal']='admin/Deal/more_deal';
$route['product_list/(:num)']='admin/Product/get_product/$1';
$route['deal_list']='admin/Deal/get_deal';
$route['Notification']='admin/Channel_partner/get_purchase_notification';
$route['cp_notification/(:num)']='admin/Deal/notification/$1';
$route['deal_settings/(:num)']='admin/home/deal_new/$1';
$route['cp_product']='admin/Channel_partner/new_product';
$route['cp_product_list/(:num)']='admin/Channel_partner/get_product/$1';
$route['product']='admin/Product/new_product';
$route['cp_wallet_report'] = 'admin/Channel_partner/wallet_report';
$route['commission_approval/(:num)'] = 'admin/home/commission_approval/$1';
$route['bulk_mail']='admin/Home/bulk_mail';
$route['bulk_sms']='admin/Home/bulk_sms';
$route['approve_deals/(:num)']='admin/Home/approve_deal_purchases/$1';

$route['transaction/(:num)']='admin/home/transaction/$1';
$route['approve_cp_transaction/(:num)']='admin/home/na_cp_transaction/$1';
$route['transaction_cp']='admin/Cp_transaction/cp_requests';
$route['cp_transaction']='admin/Cp_transaction/cp_last_trandetails';
$route['send_mail']='admin/Channel_partner/mail_to_customers';
$route['notification_list']='admin/Channel_partner/get_customer_notification';
$route['billing']='admin/Channel_partner/billing';
$route['cp_profile']='admin/Channel_partner/profile';
$route['pending_transaction/(:num)']='admin/home/pending_transaction/$1';
$route['cp_settings']='admin/Channel_partner/cp_settings';
$route['Notifications']='admin/Home/add_notification';
$route['All_notifications/(:num)']='admin/Home/get_notification/$1';
$route['delete_notification']='admin/Home/delete_notification';
$route['category_level']='admin/Home/category_level_settings';
$route['cp_transaction_history/(:num)']='admin/Home/cp_transaction_history/$1';
$route['inbox']='admin/Channel_partner/inbox';
$route['new_stage_pool']='admin/Pooling/new_stage_pool';
$route['club']='admin/Clubmember/add_club_member';
$route['edit_club_type/(:num)']='admin/Clubmember/edit_club_type/$1';
$route['club_membership_pooling']='admin/Clubmember/club_member_pooling';
$route['all_club_members/(:num)']='admin/Clubmember/get_all_club_members/$1';
$route['all_clubs']='admin/Clubmember/get_all_club_types';
$route['all_club_types/(:num)']='admin/Clubmember/get_all_clubtypes/$1';
$route['cm_transaction/(:num)']='admin/Home/cm_transaction/$1';
$route['ca_transaction/(:num)']='admin/Home/ca_transaction/$1';

$route['cp_status/(:num)']='admin/home/cp_status/$1';
$route['new_pool_stage']='admin/Pooling/pool_stage';
$route['view_stages'] ='admin/Pooling/view_all_pool_stages';

$route['new_group_pool']='admin/Pooling/new_pool';
$route['new_BA_pool']='admin/Pooling/new_ba_pool_landing';
$route['new_ba_group_pool']='admin/Pooling/new_ba_pool';
$route['new_ba_stage_pool']='admin/Pooling/new_ba_stage_pool';
$route['view_ba_pooling']='admin/pooling/view_pool_ba_group_settings';


//bch
$route['new_Bch_pool']='admin/Pooling/new_bch_pool_landing';
$route['new_bch_group_pool']='admin/Pooling/new_bch_pool';
$route['new_bch_stage_pool']='admin/Pooling/new_bch_stage_pool';
$route['view_bch_pooling']='admin/pooling/view_pool_bch_group_settings';

/*end*/
// kavyasree
// kavyasree
$route['exe-dashboard']='admin/Executives/exec_dashboard';
$route['exe-add']='admin/Home/exec_add';
$route['exe-view/(:num)']='admin/Home/exec_view/$1';
$route['exec_profile']='admin/Executives/exec_profile';
$route['exe-setting']='admin/Executives/exec_settings';
$route['Add_channel_partner']='admin/Executives/add_channel_partner';
$route['view_channel_partner/(:num)']='admin/Executives/view_channel_partner/$1';
$route['view_active_channel_partner/(:num)']='admin/Executives/view_active_channel_partner/$1';
$route['club_member_channel_partner/(:num)']='admin/Executives/club_member_channel_partner/$1';
$route['exec_add_clubmember']='admin/Executives/exec_add_clubmember';
$route['view_club_member/(:num)']='admin/Executives/view_club_member/$1';
$route['view_active_club_member/(:num)']='admin/Executives/view_active_club_member/$1';
$route['exec_add_club_agent']='admin/Executives/add_club_agent';
$route['view_club_agent/(:num)']='admin/Executives/view_club_agent';
$route['view_active_club_agent/(:num)']='admin/Executives/view_active_club_agent/$1';
$route['tm_executive']='admin/Executives/tm_add_executive';
$route['tm_exec_view/(:num)']='admin/Executives/tm_exec_view/$1';
$route['tm_exec_reffered_view/(:num)']='admin/Executives/tm_exec_reffered_view/$1';
$route['view_pro_exec']='admin/Executives/exec_pro_view';
$route['view_notification']='admin/Executives/view_notification';
$route['view_wallet']='admin/Executives/view_wallet';
$route['add_ba']='admin/Home/add_ba';
$route['view_ba/(:num)']='admin/Home/ba_view/$1';
$route['exec_add_ba']='admin/Executives/exec_add_ba';
$route['exec_view_ba']='admin/Executives/exec_view_ba';
$route['exec_reffered_ba']='admin/Executives/exec_reffered_ba';
$route['exe-cpw']='admin/Executives/exec_cpw';
$route['About_us']='home/aboutus';
$route['Our_investors']='home/our_investors';
$route['contact']='home/contact';
$route['Sitemap']='home/sitemap';
$route['Term_condition']='home/term_condition';
$route['help']='home/help';
$route['privacy']='home/privacy';
$route['fare']='home/fare';
$route['Testimonial']='home/testimonial';
$route['News']='home/news';
$route['career']='home/career';
$route['user_profile']='Home/profile';
$route['exe-select']='admin/Home/exec_sel';
$route['exe-settings-add']='admin/Home/exec_setadd';
$route['exe-settings-view']='admin/Executives/exec_setview';
$route['promoted_employee/(:num)']='admin/Home/promoted_employee/$1';
$route['set_gift']='admin/Home/set_gift';
$route['transaction_executive/(:num)']='admin/Home/transaction_executive/$1';
$route['executive_transaction_history/(:num)']='admin/Home/exec_transaction_history/$1';
$route['view_exec_transaction']='admin/Executives/view_exec_transaction';


$route['exe-clubmsadd']='admin/Executives/exec_clubmsadd';
$route['exe-clubmsview']='admin/Executives/exec_clubmsview';
// fsl
$route['clubmember']='admin/clubmember/new_ba_clubmember';
$route['newclubmember']='admin/clubmember/create_new_clubmember';
$route['clubmember_otp']='admin/clubmember/submit_otp';
$route['list_members']='admin/clubmember/get_members';
$route['paynow']='admin/clubmember/ba_payment';
$route['bch']='admin/dashboard/bch_dashboard';
$route['business']='admin/dashboard/ba_dashboard';
$route['wallet-activity']='admin/wallet/get_wallet_activityget_wallet_activity';
$route['ba-wallet']='admin/wallet/get_wallet_activity_ba';
$route['bch-wallet']='admin/wallet/get_wallet_activity_bch';
$route['exe-wallet']='admin/wallet/get_wallet_activity_exe';
$route['wallet/(:num)']='admin/wallet/get_wallet_activity_admin/$1';
// fsl





$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


$route['coupon_purchased_users']='admin/Deal/coupon';

$route['ads']='admin/Advertisement';
$route['ads-type']='admin/Advertisement/type';
$route['default_ads']='admin/Advertisement/default_ads';
$route['ads-view']='admin/Advertisement/view_ads';
// Report
$route['designation_report/(:num)']='admin/Report/designation/$1';
$route['clubtype_report/(:num)']='admin/Report/club_type/$1';
$route['channel_partner_report/(:num)']='admin/Report/channelpartner/$1';
$route['cm_channelpartners/(:num)']='admin/Report/cm_channelpartners/$1';
$route['exe_channelpartners/(:num)']='admin/Report/exe_channelpartners/$1';
$route['admin_channelpartners/(:num)']='admin/Report/admin_channelpartners/$1';
$route['club_members_by_type/(:num)']='admin/Report/club_members_by_type_report/$1';
$route['club_members_by/(:num)']='admin/Report/club_members_by_report/$1';
$route['customers_report/(:num)']='admin/Report/customers_report/$1';
$route['clubagents_report/(:num)']='admin/Report/clubagents_report/$1';
$route['pooling_report/(:num)']='admin/Report/pooling_report/$1';
$route['purchase_by_customers/(:num)']='admin/Report/purchase_by_customers/$1';
$route['purchase_by_cp/(:num)']='admin/Report/purchase_by_cp/$1';
$route['executives/(:num)']='admin/Report/executives_report/$1';
$route['ba_report/(:num)']='admin/Report/ba_report/$1';
$route['transaction_report/(:num)']='admin/Report/transaction_report/$1';
$route['feedback/(:num)']='admin/Report/feedback/$1';
$route['delete_feedback']='admin/Report/delete_feedback';
//$route['executives']='admin/Report/executives_report';
$route['module']='admin/Report/module_report';
//Privillage

// $route['entries1/(:num)']='admin/privilleges/get_entries/$1';
$route['module_list/(:num)']='admin/privillage/get_module/$1';
$route['privilleges/(:num)']='admin/privilleges/list_privilages/$1';
$route['view_members/(:num)']='admin/privilleges/list_member_privilages/$1';
$route['set_login_password/(:num)']='admin/privilleges/set_login_password/$1';

$route['view_designation_members/(:num)']='admin/privilleges/list_des_privilege_members/$1';
//$route['privilege_password']='admin/privilleges/set_login_password';



$route['delete_privilages']='admin/privilleges/delete_privilages';
$route['delete_privilage_user']='admin/privilleges/delete_privilage_user';


$route['module_dashboard']='admin/privillage/dashboard';
$route['privillage']='admin/privillage';
$route['new_module']='admin/privillage/new_module';
$route['permission_module']='admin/privillage/new_permission_module';
$route['user_privillage']='admin/privillage/new_user_privillage';
$route['user_module']='admin/privillage/new_usermodule';
$route['set_usermodule']='admin/privillage/new_permission_usermodule';
$route['privillege_list']='admin/privillage/get_privillege';

$route['cpw']='admin/Change_password/changepsw';
$route['forgot']='admin/Forgot_psw/forgot';
$route['activity/(:num)']='admin/Advertisement/view_activity/$1';
$route['preferences']='admin/Home/preferences';

//$route['single_module']='Home/module_single';

$route['Ads']='admin/Product/add_module_ads';
$route['view_ads']='admin/Product/view_module_ads';
$route['category_type']='admin/Product/category_type';
$route['view_category']='admin/Product/view_category';

//

$route['all_club_agents/(:num)']='admin/Clubagent/get_all_club_agents/$1';
$route['new_club_agent']='admin/Clubagent/new_club_agent';
$route['delete_club_agent']='admin/Clubagent/delete_club_agent';
$route['get_clubagent_byid/(:num)']='admin/Clubagent/get_clubagent_byid/$1';
$route['delete_club_agent_docs/(:num)']='admin/Clubagent/delete_club_agent_docs/$1';
$route['update_club_agent']='admin/Clubagent/update_club_agent';
// $route['signup/(:any)']='Home/Register/signup/$1';
$route['friends_signup/(:any)']='Register/friends_signup/$1';
$route['new_club_member']='admin/Clubmember/new_club_member';
$route['new_investor_club_member']='admin/Clubmember/new_investor_club_member';
$route['update_club_member']='admin/Clubmember/update_club_member';
$route['update_investor_club_member']='admin/Clubmember/update_investor_club_member';
$route['delete_club_member']='admin/Clubmember/delete_club_member';
$route['delete_club_type']='admin/Clubmember/delete_club_type';
$route['normal_users/(:num)']='admin/Clubmember/view_normal_users/$1';
$route['investor_club_members/(:num)']='admin/Clubmember/investor_club_members/$1';
//FB Login
$route['fb_login']='home';
//Google Plus
$route['google_login']='home/google_login';
$route['user_login']='home/user_login';
$route['be_a_member']='home/be_a_member';


//pooling
$route['new_pool']='admin/Pooling/new_pool_landing';
$route['view_pooling']='admin/pooling/view_pool_settings';
$route['delete_pool_settings/(:num)']='admin/pooling/delete_pool_settings/$1';
$route['view_pool_members/(:num)']='admin/pooling/view_pool_members/$1';
$route['delete_pooling_member/(:num)']='admin/pooling/delete_pooling_member/$1';

$route['active_friends/(:num)']='user/Profile/active_friends/$1';
$route['refered_friends/(:num)']='user/Profile/refered_friends/$1';
$route['my_channel_partners/(:num)']='user/Profile/get_my_channel_partners/$1';
$route['my_club_agents/(:num)']='user/Profile/get_my_club_agents/$1';
$route['my_transactions/(:num)']='user/Profile/my_transactions/$1';
$route['get_my_ba/(:num)']='user/Profile/get_my_ba/$1';
$route['get_my_bde/(:num)']='user/Profile/get_my_bde/$1';
$route['view_cp/(:num)']='user/Profile/view_channel_partner/$1';
$route['edit_cp/(:num)']='user/Profile/edit_channel_partner/$1';
$route['get_clubplans_by_type_exe']='admin/executives/get_clubplans_by_type_exc';
$route['get_clubplans_by_type']='admin/Clubmember/get_clubplans_by_type';
$route['get_club_plans_by_type']='Register/get_club_plans_by_type';
$route['approve_club_members/(:num)']='admin/Clubmember/approve_club_members/$1';
 $route['approve_club_membership']='admin/Clubmember/approve_club_membership';
$route['new_partner']='user/Profile/new_partner';
$route['ca_signup/(:any)/(:num)']='Register/ca_signup/$1/$2';

$route['get_reports']='user/Report';
$route['rewards_by_members/(:num)']='user/Report/rewards_by_members/$1';
$route['rewards_by_cp/(:num)']='user/Report/rewards_by_cp/$1';
$route['rewards_by_clubagents/(:num)']='user/Report/rewards_by_clubagents/$1';
$route['view_cm_transaction/(:num)']='user/Report/view_cm_transaction/$1';
$route['get_notitfication/(:num)']='user/Report/get_notitfication/$1';
$route['get_money_transfer/(:num)']='user/Report/get_money_transfer/$1';
$route['get_to_money_transfer/(:num)']='user/Report/get_to_money_transfer/$1';

$route['wallet_overview']='admin/wallet/overview';

$route['view_brands/(:num)']='admin/Product/brands/$1';


// $route['exe-view/(:num)']='admin/Home/exec_view/$1';
//accounts


$route['account_dashboard']='accounts/Dashboard';
$route['entries/(:num)']='accounts/entries/get_entries/$1';


$route['add_entries']='accounts/entries/add_entries';

$route['add_entries']='accounts/entries/add_entries';
$route['ledgers/(:num)']='accounts/accounts/get_ledgers/$1';

$route['add_ledger']='accounts/accounts/add_ledger';
$route['edit_ledger/(:num)']='accounts/accounts/edit_ledger/$1';
// $route['view_ledger/(:num)(:num)']='accounts/accounts/view_ledger_entry/$1/$2';


// $route['view_ledger/(:num)']='accounts/accounts/view_ledger_entry/$1';
$route['ledger_statement']='accounts/accounts/ledgerstatement';
$route['trial_balance/(:num)']='accounts/accounts/trialbalance/$1';

$route['profit_loss']='accounts/accounts/get_profitandLoss';
$route['balance_sheet']='accounts/accounts/get_balanceSheet';
$route['ledger_statement_by_id/(:num)']='accounts/accounts/get_ledger_statement_by_id/$1
';
$route['get_trialbalance_by_date/(:num)']='accounts/accounts/get_trialbalance_by_date/$1';

$route['add_financial_year']='accounts/accounts/add_financial_year';



// hr

$route['hr_dashboard']='hr/Dashboard';
$route['add_branch']='hr/Branch/branch';

$route['branch_list']='hr/Branch/get_branch';
$route['updatebranch/(:num)']='hr/branch/updatebranch/$1';
$route['add_department']='hr/department/add_department';
$route['designations']='hr/department/designations';
$route['preferance']='hr/Employee/preference';
$route['employee']='hr/Employee/add_employee';
$route['update_employee/(:num)']='hr/employee/view/$1';
$route['active_employees']='hr/Employee/active_employee';
$route['warnings']='hr/Employee_warning/get_warning';
$route['employee_warning']='hr/employee_warning';
$route['requisition']='hr/requisition';
$route['new_requisition']='hr/Requisition/new_requisition';
$route['update_requisition/(:num)']='hr/requisition/get_requisition_by_id/$1';
$route['complaints']='hr/complaint';
$route['new_complaint']='hr/Complaint/new_complaint';
$route['update_complaint/(:num)']='hr/complaint/get_complaint_by_id/$1';
$route['employee_exit']='hr/employee_exit/get_exit';
$route['add_employee_exit']='hr/employee_exit';
$route['update_exit/(:num)']='hr/employee_exit/get_exit_by_id/$1';
$route['terminations']='hr/Employee_terminations/get_terminations';
$route['add_termination']='hr/employee_terminations';
$route['add_termination']='hr/employee_terminations';
$route['update_termination/(:num)']='hr/employee_terminations/get_terminations_by_id/$1';
$route['resignation']='hr/resignation/res_emp_list';
$route['add_resignation']='hr/resignation';
$route['update_resignation/(:num)']='hr/Resignation/get_resignation/$1';
$route['payments']='hr/Payroll/payment';
$route['salary_list']='hr/Payroll/salary_list';
$route['update_salary/(:num)(:num)']='hr/Payroll/edit_salary/$1/$2';
$route['paid_salary_list']='hr/Payroll/view_paid_payslip';
$route['advance_salary']='hr/Payroll/advance_payment';
$route['add_advance_salary']='hr/Payroll/add_advance';
$route['update_advance_salary/(:num)']='hr/Payroll/get_advance_by_id/$1';
$route['advance_salary']='hr/Payroll/advance_payment';
$route['requisitions']='hr/Recruitment/requisitions';
$route['add_requisitions']='hr/Recruitment/new_requisitions';
$route['edit_requisition/(:num)']='hr/Recruitment/edit_requisition/$1';
$route['copy_to_post/(:num)']='hr/Recruitment/new_posts_copy/$1';
$route['posts']='hr/Recruitment/posts';
$route['new_post']='hr/Recruitment/new_posts';
$route['posts_edit/(:num)']='hr/Recruitment/posts_edit/$1';
$route['candidates']='hr/Recruitment/candidates';
$route['add_candidates']='hr/Recruitment/new_candids';
$route['update_candidate/(:num)']='hr/Recruitment/edit_candidate/$1';
$route['shortlists']='hr/Recruitment/shortlists';
$route['selected']='hr/Recruitment/selected';
$route['emp_join/(:num)']='hr/Recruitment/emp_join/$1';
$route['leavetype']='hr/Timesheet/leavetype';
$route['add_leavetype']='hr/timesheet/leaves_addview';
$route['leaves']='hr/Timesheet/leaves';
$route['add_leaves']='hr/Timesheet/leaves_applyview';

$route['edit_leave/(:num)(:num)']='hr/timesheet/leavesbyid/$1/$2';
$route['assign_leaves']='hr/Timesheet/leaves_assignview';
$route['preference']='hr/Employee/preference';
$route['offer_letter/(:num)']='hr/employee/get_offer_letter/$1';
$route['requisition_report']='hr/Recruitment/get_all_requisition_report';
$route['posts_report']='hr/Recruitment/get_all_post_report';
$route['delete_billing']='admin/Channel_partner/delete_billing';
/************************* API *******************************/
$route['register']='api/Login/signup';
$route['verify_otp']='api/Login/verify_otp';
$route['request_otp']='api/Login/request_otp';
$route['login']='api/Login/login_process';
$route['be_club_member']='api/Clubmember/add';
$route['active_friends']='api/Clubmember/active_friends';
$route['reffered_friends']='api/Clubmember/refferd_friends';
$route['add_friend']='api/Clubmember/add_friend';
$route['get_club_packages']='api/Clubmember/get_club_packages';
$route['get_club_member_by_search']='api/Clubmember/get_club_member_by_search';
$route['update_profile']='api/Clubmember/update_profile';
$route['update_image']='api/Clubmember/update_image';
$route['transfer_rewards']='api/Clubmember/transfer_rewards';
$route['wallet_details']='api/Login/wallet_details';
$route['social_login']='api/Login/social_login';
$route['profile']='api/Home/profile';
$route['edit_profile']='api/Clubmember/update_profile';
$route['get_user_details']='api/Login/get_user_details';
$route['add_club_agent']='api/Login/add_club_agent';
$route['add_club_member']='api/Login/add_club_member';
$route['add_money_to_wallet']='api/Home/add_money_to_wallet';
$route['get_package/(:num)']='api/Home/get_package/$1';
$route['help_support']='api/Home/help_support';
$route['privacy_policy']='api/Home/privacy_policy';
$route['terms_condition/register']='api/Home/register_terms_n_condition';
$route['terms_condition/ca']='api/Home/ca_terms_n_condition';
$route['terms_condition/cm']='api/Home/cm_terms_n_condition';
$route['get_countries']='api/home/get_countries';
$route['get_city']='api/home/get_city';
$route['get_state']='api/home/get_state';
$route['get_executive_designations']='api/home/get_executive_designations';
$route['add_executive']='api/executive/add_executive';
$route['add_jaazzo_store_or_ba']='api/executive/add_jaazzo_store_or_ba';
$route['change_password']='api/home/change_password';
$route['forgot_password_otp']='api/home/forgot_password_otp';
$route['confirm_otp_forgot_password']='api/home/confirm_otp_forgot_password';
$route['reset_password']='api/home/reset_password';
$route['add_channel_partner']='api/executive/add_channel_partner';
$route['get_reason']='api/home/get_reason';
$route['deactivate_account']='api/executive/deactivate_account';
$route['get_wallet_transactions']='api/executive/get_wallet_transactions';
$route['get_executive_data']='api/executive/get_executive_data';

$route['home']='api/Front';
$route['get_product']='api/Front/get_product';
$route['get_deal']='api/Front/get_deal';
$route['get_shops']='api/Front/get_shops';
$route['get_modules']='api/Front/get_modules';
$route['category_list']='api/Front/category_list';
$route['get_notifications']='api/Front/get_notifications';
$route['get_shop_suggestions']='api/Front/get_shop_suggestions';
$route['get_notification_detail']='api/Front/get_notification_detail';
$route['scan']='api/Front/scan';
$route['get_billing_details']='api/Front/get_billing_details';
$route['get_shop_from_code']='api/Front/get_shop_from_code';
$route['get_channel_partner_type']='api/Front/get_channel_partner_type';
$route['get_filter_options']='api/Front/get_filter_options';
$route['side_bar_data']='api/Front/side_bar_data';
$route['search']='api/Front/search';
$route['complete_billing']='api/Front/complete_billing';
//$route['complete_billing']='api/Front/complete_billing';
$route['getAvailableClubTypes'] = 'api/Clubmember/getAvailableClubTypes';
$route['refer_channel_partner']='api/Clubmember/refer_cp';
$route['get_reffered_channel_partner']='api/Clubmember/get_refered_cp';
$route['remove_referred_channel_partner']='api/Clubmember/remove_referred_channel_partner';
$route['edit_channel_partner']='api/executive/add_refered_channel_partner';
$route['get_all_channel_partners']='api/executive/get_all_channel_partners';
$route['edit_refer_channel_partner']='api/executive/edit_refer_cp';
$route['get_search_product_locations']='api/Home/get_search_product_locations';
$route['get_location_wise_channel_partner']='api/Home/get_location_wise_channel_partner';
$route['get_products_from_channel_partner']='api/Front/get_products_from_cp';
$route['get_club_member_by_executive']='api/Executive/get_club_member_by_executive';
$route['get_members']='api/Executive/get_members';
$route['edit_referred_friend']='api/Clubmember/update_referred_friend';
$route['delete_referred_friend']='api/Clubmember/delete_referred_friend';
$route['upgrade_club_membership']='api/Clubmember/upgrade_club_membership';
$route['check_cp_facility']='api/Clubmember/check_cp_facility';


