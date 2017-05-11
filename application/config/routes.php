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

$route['admin']='/admin/Login';
$route['my_dashboard']='admin/channel_partner';
$route['logout']='admin/login/loged_out';
$route['admin/new_pool']='admin/Pooling/new_pool';
$route['admin/new_designation']='admin/pooling/new_designation';
$route['view_pooling']='admin/pooling/view_pool_group_settings';
$route['edit_system_pooling']='admin/pooling/full_system_pool_settings';
$route['pooling_details/:num']='admin/pooling/full_system_pool_settings/$1';
$route['partner_type']='admin/Channel_partner/partner_type';
$route['channel_partner']='admin/Channel_partner/partner';
$route['get_partner_type']='admin/Channel_partner/view_partner_type';
$route['get_channel_partner']='admin/Channel_partner/view_channelpartner';
$route['set_pooling']='admin/Pooling/new_commision';
$route['channel_pooling']='admin/Pooling/get_commision_all';
$route['product']='admin/Product/new_product';


$route['view_pooling']='admin/pooling/view_pool_group_settings';

//pranav
$route['club']='admin/club_member';
$route['club_membership_pooling']='Club_member/edit_club_member_pooling';
$route['all_club_members']='admin/Club_member/get_all_club_members';
$route['all_clubs']='admin/Club_member/get_all_club_types';
$route['new_pool_stage']='admin/Pooling/pool_stage';
$route['view_stages'] ='admin/Pooling/view_all_pool_stages';
$route['new_pool']='admin/Pooling/new_pool_landing';

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


$route['new_stage_pool']='admin/Pooling/new_stage_pool';
//ecnd pranav

/*module2*/
$route['transaction']='admin/Cp_transaction';
$route['cp_transaction']='admin/Cp_transaction/cp_last_trandetails';
$route['send_mail']='admin/Channel_partner/mail_to_customers';
$route['cp_notification']='admin/Channel_partner/send_notification_customer';
$route['notification_list']='admin/Channel_partner/get_customer_notification';
/*end*/
// vyshak
$route['exe-dashboard']='admin/Executives/exec_dashboard';
$route['exe-add']='admin/Executives/exec_add';
$route['exe-view']='admin/Executives/exec_view';
$route['exe-cpw']='admin/Executives/exec_cpw';
$route['exe-select']='admin/Executives/exec_sel';
$route['exe-settings-add']='admin/Executives/exec_setadd';
$route['exe-settings-view']='admin/Executives/exec_setview';
$route['exe-clubmsadd']='admin/Executives/exec_clubmsadd';
$route['exe-clubmsview']='admin/Executives/exec_clubmsview';
// vyshak
$route['product_list']='admin/Product/get_product';
$route['Notification']='admin/Channel_partner/get_purchase_notification';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


//hridya
$route['ads']='admin/Advertisement';
$route['ads-type']='admin/Advertisement/type';

$route['ads-view']='admin/Advertisement/view_ads';
$route['report']='admin/Report/designation';
$route['channel']='admin/Report/channelpartner';
$route['clubtype']='admin/Report/club_type';
$route['customer']='admin/Report/customer';
$route['members']='admin/Report/club_members';
$route['executives']='admin/Report/executives_report';
$route['module']='admin/Report/module_report';
//hridya
$route['module_dashboard']='admin/privillage/dashboard';
$route['privillage']='admin/privillage';
$route['new_module']='admin/privillage/new_module';
$route['permission_module']='admin/privillage/new_permission_module';
$route['user_privillage']='admin/privillage/new_user_privillage';
$route['user_module']='admin/privillage/new_usermodule';
$route['set_usermodule']='admin/privillage/new_permission_usermodule';
$route['privillege_list']='admin/privillage/get_privillege';
$route['module_list']='admin/privillage/get_module';
//hridya
$route['profile']='admin/Profile/change_profile';
$route['cpw']='admin/Change_password/changepsw';
$route['forgot']='admin/Forgot_psw/forgot';
$route['user_profile']='Home/profile';
$route['activity']='admin/Advertisement/view_activity';

//hridya
// fsl
$route['clubmember']='admin/clubmember/new_ba_clubmember';
$route['newclubmember']='admin/clubmember/create_new_clubmember';
$route['clubmember_otp']='admin/clubmember/submit_otp';
$route['list_members']='admin/clubmember/get_members';
$route['paynow']='admin/clubmember/ba_payment';
$route['bch']='admin/dashboard/bch_dashboard';
$route['business']='admin/dashboard/ba_dashboard';
$route['wallet-activity']='admin/wallet/get_wallet_activity';
$route['ba-wallet']='admin/wallet/get_wallet_activity_ba';
$route['bch-wallet']='admin/wallet/get_wallet_activity_bch';
$route['exe-wallet']='admin/wallet/get_wallet_activity_exe';
$route['wallet']='admin/wallet/get_wallet_activity_admin';
// fsl
//arya

$route['add_ba']='admin/Executives/add_ba';
$route['view_ba']='admin/Executives/ba_view';
$route['Ads']='admin/Product/add_module_ads';
$route['view_ads']='admin/Product/view_module_ads';
$route['category_type']='admin/Product/category_type';
$route['view_category']='admin/Product/view_category';

//

