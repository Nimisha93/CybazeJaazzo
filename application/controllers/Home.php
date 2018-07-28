<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Home extends CI_controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('user/user_model','user/product_model','admin/Channelpartner_model','register_model','admin/Executives_model','user/Cp_model'));
        $this->load->library(array('form_validation'));
        $this->load->helper(array('form', 'date','string'));
        // Load facebook library
        $this->load->library('facebook');
        require_once APPPATH.'third_party/src/Google_Client.php';
        require_once APPPATH.'third_party/src/contrib/Google_Oauth2Service.php';

    }
    function index()
    {

        $data = $this->check_fb_login();
        $datas = getLoginId();
        //echo json_encode($datas);exit(); 
        if($datas){
        $login_id = $datas['login_id'];
        //$user_id = $datas['user_id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);  
            $data['vallet_type'] = getWallet();
        }
        $data['get_menu']=$this->product_model->get_menus();
      
        $data['products'] = $this->product_model->get_Product();
        $data['deals'] = $this->product_model->get_deal_product();
        //echo json_encode($data['deals']);exit(); 
        $data['submenu'] = $this->product_model->get_submenu();
        $data['product'] = $this->product_model->get_product_view();
        // echo json_encode($data['product']);exit(); 
        $data['left_adv'] = $this->user_model->get_ads();
        $data['centre_adv'] = $this->user_model->get_ads_center();
        $data['right_adv'] = $this->user_model->get_ads_right();
        $data['bottom_adv'] = $this->user_model->get_ads_bottom();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_landing_page",$data);
    }
    function check_fb_login()
    {
        $userData = array();
        $session_array = array();
        // Check if user is logged in
        if($this->facebook->is_authenticated()){
            // Preparing data for database insertion
            $userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');
            // echo json_encode($userProfile);exit();
            $userData['oauth_provider'] = 'facebook';
            $userData['oauth_uid'] = $userProfile['id'];
            $userData['name'] = $userProfile['first_name'];
           
            $userData['email'] = $userProfile['email'];
            $validate_social_key=$this->user_model->validate_social_key($userData['oauth_uid']);
            if(!$validate_social_key){
                $validate_email=$this->user_model->validate_email($userData['email']);
            
                if($validate_email)
                {
                    $id = $validate_email['id'];
                    $details = array('oauth_provider'=>'facebook','oauth_uid'=>$userProfile['id']);
                    $update_social_key=$this->user_model->update_social_key($details,$id);
                   
                    $session_array = array(
                        'id' => $validate_email['id'],
                        'type' => $validate_email['type'],
                        'email' => $validate_email['email'],
                        'user_id' => $validate_email['user_id'],
                        'club_type_id'=>$validate_email['club_type_id'],
                        'login' =>true);
                }else{
                    $sign_up=$this->user_model->fb_sign_up($userData);
                    $session_array = array(
                    'id' => $sign_up['id'],
                    'type' => $sign_up['type'],
                    'email' => $sign_up['email'],
                    'user_id' => $sign_up['user_id'],
                    'club_type_id'=>$sign_up['club_type_id'],
                    'login' =>true);
                }
                //get Data

            }else{
                $session_array = array(
                    'id' => $validate_social_key['id'],
                    'type' => $validate_social_key['type'],
                    'email' => $validate_social_key['email'],
                    'user_id' => $validate_social_key['user_id'],
                    'club_type_id'=>$validate_social_key['club_type_id'],
                    'login' =>true);
            }
            $type = $session_array['type'];
                
              if($type=='normal_customer')
              {
                  $this->session->set_userdata('logged_in_user', $session_array); 
              }else if($type == 'club_member')
              {
                $this->session->set_userdata('logged_in_club_member', $session_array); 
              }else if($type=='club_agent')
              {
                $this->session->set_userdata('logged_in_club_agent', $session_array); 
              }

            // Get logout URL
            $data['logoutUrl'] = $this->facebook->logout_url();
        }else{
            $fbuser = '';
            // Get login URL
            $data['authUrl'] =  '';//$this->facebook->login_url();
        }
        return $data;
    }
    function get_deal()
    {
        if($this->input->is_ajax_request())
        {
          $id = $this->input->post('id');
          $check = $this->user_model->check_quantity($id);
          if($check)
            {  
                
                $datas = getLoginId(); 
                if ($datas) { 
                    $coupon_code = generate_coupon();     
                    $result = $this->user_model->get_deal($datas,$id,$check,$coupon_code);
                    if($result){ 
                          $email = $datas['email'];
                          $price =(($check[0]['special_prize'] * $check[0]['coupon_percentage']) /$check[0]['special_prize'] )*100; 
                          $email_details['coupon_code'] = $coupon_code;
                          $email_details['name'] = $check[0]['name'];
                          $email_details['coupon_validity'] = $check[0]['coupon_validity'];
                          $email_details['address'] = $check[0]['address'];
                          $email_details['city'] = $check[0]['city'];
                          $email_details['state'] = $check[0]['state'];
                          $email_details['country'] = $check[0]['country'];
                          $email_details['price'] = $price;
                          $mail = "maneeshakk16@gmail.com";
                          $mail_head = 'Message From Jaazzo';
                          $status = send_custom_email($mail, $mail_head, $email, 'Purchased deal coupon', $this->load->view('email_templates/coupon_purchase_confirmation', $email_details,TRUE));
                        
                        exit(json_encode(array("status"=>TRUE)));
                    }else{
                        exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                    }
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Something went wrong!')));
                }    
            }else{
                exit(json_encode(array("status"=>FALSE,"reason"=>'All Deals have been purchased!')));
            }           
        }else{
            show_error("We are unable to process this request on this way!");   
        }
    }
    
    function google_login(){
        $clientId = '1001053451037-t07f8kkbvgip656red9gmed6ibea60ud.apps.googleusercontent.com'; 
        $clientSecret = 'FYuKJ-opEtZ_-j5w9Og5fcKM'; //Google client secret
        $redirectURL = 'http://jaazzo.cybase.in/jaazzo/home/google_login';
        
        //Call Google API
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectURL);
        $google_oauthV2 = new Google_Oauth2Service($gClient);
        
        if(isset($_GET['code']))
        {
            $gClient->authenticate($_GET['code']);
            $_SESSION['token'] = $gClient->getAccessToken();
            header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
        }

        if (isset($_SESSION['token'])) 
        {
            $gClient->setAccessToken($_SESSION['token']);
        }
        
        if ($gClient->getAccessToken()) {
                    $gpUserProfile = $google_oauthV2->userinfo->get();
            //Insert or update user data to the database
                    $gpUserData = array(
                        'oauth_provider'=> 'google',
                        'oauth_uid'     => $gpUserProfile['id'],
                        'name'          => $gpUserProfile['given_name'],
                        'email'         => $gpUserProfile['email']
                    );
                    $validate_social_key=$this->user_model->validate_social_key($gpUserData['oauth_uid']);
                    if(!$validate_social_key){
                        $validate_email=$this->user_model->validate_email($gpUserData['email']);
                    
                        if($validate_email)
                        {
                            $lg_type = array("normal_customer", "club_member", "club_agent");

                            if (in_array($validate_email['type'], $lg_type))
                            {
                                $id = $validate_email['id'];
                                $details = array('oauth_provider'=>'google','oauth_uid'=>$gpUserData['oauth_uid']);
                                $update_social_key=$this->user_model->update_social_key($details,$id);
                               
                                $session_array = array(
                                    'id' => $validate_email['id'],
                                    'type' => $validate_email['type'],
                                    'email' => $validate_email['email'],
                                    'user_id' => $validate_email['user_id'],
                                    'club_type_id'=>$validate_email['club_type_id'],
                                    'login' =>true);
                            }else{
                                $this->index();
                            }
                        }else{
                            $sign_up=$this->user_model->fb_sign_up($gpUserData);
                            $session_array = array(
                            'id' => $sign_up['id'],
                            'type' => $sign_up['type'],
                            'email' => $sign_up['email'],
                            'user_id' => $sign_up['user_id'],
                            'club_type_id'=>$sign_up['club_type_id'],
                            'login' =>true);
                        }
                        //get Data
                    }else{
                        $lg_type = array("normal_customer", "club_member", "club_agent");
                        if (in_array($validate_social_key['type'], $lg_type))
                        {
                            $session_array = array(
                                'id' => $validate_social_key['id'],
                                'type' => $validate_social_key['type'],
                                'email' => $validate_social_key['email'],
                                'mobile' => $validate_social_key['mobile'],
                                'user_id' => $validate_social_key['user_id'],
                                'club_type_id'=>$validate_social_key['club_type_id'],
                                'fixed_club_type_id'=>$validate_social_key['fixed_club_type_id'],
                                'investor_type_id'=>$validate_social_key['investor_type_id'],
                                'type' => $validate_social_key['type'],
                                'login' =>true);
                        }else{
                            $this->index();
                        }
                    }
                  $type = $session_array['type'];
                
                  if($type=='normal_customer')
                  {
                      $this->session->set_userdata('logged_in_user', $session_array); 
                      $this->index();
                  }else if($type == 'club_member')
                  {
                    $this->session->set_userdata('logged_in_club_member', $session_array); 
                    $this->index();
                  }else if($type=='club_agent')
                  {
                    $this->session->set_userdata('logged_in_club_agent', $session_array);
                    $this->index(); 
                  }
                    //$this->index();
            }else{
                    $url = $gClient->createAuthUrl();
                    header("Location: $url");
                    exit;
            }
    } 


    
    function signup_cp()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('email', 'Email', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_message('password_check', '%s must contain both numbers and alphabets');
           
            if($this->form_validation->run() == TRUE)
            {
                $mail = $this->input->post('email');
                $id = $this->input->post('id');
               
                    $password = $this->input->post('password');
                   
                        $cpassword =$this->input->post('cpassword');
                        if($password==$cpassword){
                            $result = $this->user_model->signup_cp($mail,$id);
                            if($result)
                            {
                                
                                exit(json_encode(array("status"=>TRUE)));
                            }
                            else
                            {
                                exit(json_encode(array("status"=>FALSE,'reason'=>'Database Error!')));
                            }
                        }else{
                            exit(json_encode(array('status'=>false, 'reason'=>'Password and Confirm should be same')));
                        }
                   
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        }  
    }
    
    function cp_signup($otp,$id)
    {
        $data['get_menu']=$this->product_model->get_menus();
        
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_ca_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $id = $id;
        $data['details'] = $this->Channelpartner_model->get_cp_details($id);
        
        $this->load->view("public/edit_cp_signup",$data);
    }
    function create_an_account_mob()
    {
        $session_array = $this->session->userdata('logged_in_user');

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/page2",$data);
    }
    function become_ba_mob()
    {
        $session_array = $this->session->userdata('logged_in_user');

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/page3",$data);
    }
    function add_agent()
    {
        $session_array = $this->session->userdata('logged_in_user');
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/add-agent",$data);
    }
    function show_deals()
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
           
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['vallet_type'] = $this->product_model->get_wallet();  
        }

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $data['get_menu']=$this->product_model->get_menus();
        $this->load->view("public/edit_show_deals",$data);
    }
    function deal_details($id)
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
           
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['vallet_type'] = $this->product_model->get_wallet();  
        }
        
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
     
        $data['products'] = $this->product_model->get_deal_details_by_id($id);
        $lat = $data['products']['details']['lattitude'];
        $long = $data['products']['details']['longitude'];
        $this->load->library('googlemaps');
        $config['center'] = '"'.$lat.",". $long.'"';
        $marker['position'] = '"'.$lat.",". $long.'"';
        $this->googlemaps->add_marker($marker);
        $config['zoom'] = '8';
        $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $count = incriment_count($id);
        $data['get_menu']=$this->product_model->get_menus();
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        //echo json_encode($data['products']);exit(); 
        $this->load->view("public/edit_show_deal_details",$data);
    }
    function product_details($id)
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
           
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['vallet_type'] = $this->product_model->get_wallet();  
        }
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $type = "p.`type` = '0'";
        $data['products'] = $this->product_model->get_product_details_by_id($id,$type);
        $lat = $data['products']['details']['lattitude'];
        $long = $data['products']['details']['longitude'];
        $this->load->library('googlemaps');
        $config['center'] = '"'.$lat.",". $long.'"';
        $marker['position'] = '"'.$lat.",". $long.'"';
        $this->googlemaps->add_marker($marker);
        $config['zoom'] = '8';
        $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $count = incriment_count($id);
        
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $this->load->view("public/edit_show_product_details",$data);
    }

    function module_single($id)
    {
       
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
           
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['vallet_type'] = $this->product_model->get_wallet();  
        }
        $data['get_menu']=$this->product_model->get_menus();
        $data['products'] = $this->product_model->get_Product();
        $locationsession = $this->session->userdata('selected_location');
        $lcid=($locationsession['id']) ? $locationsession['id'] : 0;
        $data['deals'] = $this->product_model->get_deal_product_module_wise($id,$lcid);
        $data['submenu'] = $this->product_model->get_submenu();
        $data['product'] = $this->product_model->get_product_view_module_wise($id,$lcid);
        $data['left_adv'] = $this->user_model->get_ads();
        $data['centre_adv'] = $this->user_model->get_ads_center();
        $data['right_adv'] = $this->user_model->get_ads_right();
        $data['mod_id'] = $id;
       
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/edit_show_individual_module_details",$data);
    }
    function get_search_list($key)
    {
       
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
           
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['vallet_type'] = $this->product_model->get_wallet();  
        }
        $data['get_menu']=$this->product_model->get_menus();
        $locationsession = $this->session->userdata('selected_location');
        $lcid=($locationsession['id']) ? $locationsession['id'] : 0;
        $data['submenu'] = $this->product_model->get_submenu();
        $data['product'] = $this->product_model->get_product_searchlist($key,$lcid);
        $data['cp'] = $this->product_model->get_cp_searchlist($key,$lcid);
        $data['deals'] = $this->product_model->get_deals_searchlist($key,$lcid);
        //echo json_encode($data['deals']);exit();
        $data['mod_id'] = $key;
       
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/edit_list_search_list",$data);
    }
    function channel_partner_wise($id)
    {
       
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
           
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['vallet_type'] = $this->product_model->get_wallet();  
        }
        $data['get_menu']=$this->product_model->get_menus();
      
        $data['deals'] = $this->product_model->get_deal_product_cp_wise($id);
        $data['submenu'] = $this->product_model->get_submenu();
        $data['product'] = $this->product_model->get_product_cp_wise($id);
        $data['left_adv'] = $this->user_model->get_ads();
        $data['centre_adv'] = $this->user_model->get_ads_center();
        $data['right_adv'] = $this->user_model->get_ads_right();
        $data['cp_id'] = $id;
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/edit_list_products_cp_wise",$data);
    }
    function club_membership()
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $type = $datas['type'];
            if($type=='club_member'){
                $club_type_id = $datas['club_type_id'];
                $data['club_types'] = $this->user_model->get_all_club_plans($club_type_id);
                $data['ctype_data'] = getClubtypeById($club_type_id);
                $data['ctype'] = isset($data['ctype_data']['type'])?$data['ctype_data']['type']:'';
                $data['fixed_club_types'] = get_club_plan_bytypes('FIXED');
            }
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['vallet_type'] = $this->product_model->get_wallet();  
        }
        $data['ul_club_types'] = get_club_plan_bytypes('UNLIMITED');
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/edit_club_member_details",$data);
    }

    function product_deal($id)
    {


        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
           
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['vallet_type'] = $this->product_model->get_wallet();  
        }


        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $data['deals'] = $this->product_model->get_deal_details_by_id($id);

        $this->load->view("public/edit_show_deal_details",$data);
    }
    function type_wallet()
    {
        $data = getLoginId();
        if($data){
            $login_id = $data['login_id'];
            $id =  $this->input->post('id');
            $result=$this->product_model->get_wallet_amout($id,$login_id);
            if($result)
            {
                $res =$result['total_value'];// round_number($result['total_value']);
                exit(json_encode(array("status"=>TRUE,"value"=>$res)));
            }
            else
            {
                exit(json_encode(array("status"=>FALSE,"value"=>$result)));
            }
        }
    }
    function clubmember_signup($otp,$id)
    {
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_ca_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $id = $id;
        $data['details'] = $this->Executives_model->get_clubmember_details($id);
        $data['get_menu']=$this->product_model->get_menus();
        $this->load->view("public/edit_clubmember_signup",$data);
    }
    function signup_clubmember()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('email', 'Email', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_message('password_check', '%s must contain both numbers and alphabets');
           
            if($this->form_validation->run() == TRUE)
            {
                $mail = $this->input->post('email');
                $id = $this->input->post('id');

                /*$validate_email = $this->register_model->validate_mail($mail,$id);
                
                if($validate_email['status'] === TRUE)
                {*/
                    $password = $this->input->post('password');

                    $validate_password = $this->Executives_model->validate_password(encrypt_decrypt('encrypt',$this->input->post('password')));

                    if($validate_password['status'] === TRUE)
                    {

                        $cpassword =$this->input->post('cpassword');

                        if($password==$cpassword){
                            $password =encrypt_decrypt('encrypt',$this->input->post('password'));
                            $data_input = array('password'=>$password,'otp_status'=>1,'email'=>$mail);
                            $where = array('id'=>$id);
                            $res = update_tbl('gp_login_table',$data_input,$where);
                           /// echo $res;exit();
                            if($res)
                            {

                                $where = 'gp_login_table.user_id=gp_normal_customer.id';
                                $result = select_all_by_id('gp_login_table',$id,'gp_normal_customer',$where);
                                /*$session_array = array();
                                $session_array = array(
                                        'id' => $result->id,
                                        'type' => $result->type,
                                        'email' => $result->email,
                                        'mobile' => $result->mobile,
                                        'user_id' => $result->user_id,
                                        'club_type_id'=>$result->club_type_id,
                                        'login' =>true);
                                $this->session->set_userdata('logged_in_user', $session_array);*/
                                exit(json_encode(array('status'=>true)));
                            }else{
                                exit(json_encode(array('status'=>false)));
                            }
                        }else{
                            exit(json_encode(array('status'=>false, 'reason'=>'Password and Confirm should be same')));
                        }
                    }else{
                        exit(json_encode(array('status'=>false, 'reason'=>'Password already exist')));
                    }
                /*}else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Email already exist')));
                }*/
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        }  
    }

    function profile()
    {
        $session_array1 = $this->session->userdata('logged_in_user');
        $session_array2 = $this->session->userdata('logged_in_club_member');
        $session_array3 = $this->session->userdata('logged_in_club_agent');
        
        if(isset($session_array1)){
            $login_id = $session_array1['id'];
            $userid=$session_array1['user_id'];
            $data['channel_partner'] = get_all_channel_partners();
        }
        if(isset($session_array2)){
            $login_id = $session_array2['id'];
            $userid=$session_array2['user_id'];
            $this->load->library('googlemaps');
            $config['center'] = '10.804305026919454, 76.11534118652344';
            $config['zoom'] = '8';
            $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
            $this->googlemaps->initialize($config);
            $data['map'] = $this->googlemaps->create_map();
            $data['channel_partner'] = get_all_channel_partners();
            //$data['channel_partner'] = $this->Cp_model->get_my_channel_partner($login_id);
            //$data['club_agents'] = get_my_club_members($login_id);
        }
        if(isset($session_array3)){
            $login_id = $session_array3['id'];
            $userid=$session_array3['user_id'];
            $data['channel_partner'] = get_all_channel_partners();
        }
        if($login_id){
            
            $data['countries'] = $this->Cp_model->get_countries();
            $data['modules'] = $this->Cp_model->get_modules();
            $data['get_menu']=$this->product_model->get_menus();
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
           // echo json_encode($data['wallet']);exit(); 
            //$data['refer'] = $this->refer_model->get_refer($login_id);
            //$data['child'] = $this->refer_model->get_child($login_id);
            $data['countries'] = $this->Cp_model->get_countries();
            $data['category']=$this->Cp_model->get_cpcategory();
            $data['subcategory']=$this->Cp_model->get_cpscategory();
        
            $data['vallet_type'] = $this->product_model->get_wallet();
            $data['deactivate_reasons'] = getDeactivateReasons();
            $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
            $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
            $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
            /*if($loginsession['type'] == 'normal_customer' || $loginsession['type'] == 'club_member'|| $loginsession['type'] == 'club_agent' )
            {*/
                $data['user']=$this->user_model->get_normal_customer($userid);
                if($data['user']['country'])
                {
                    $country = $data['user']['country'];
                    $data['state'] = $this->register_model->get_state_by_country($country);
                }
                //echo json_encode($data);exit;
                $data['user_image']=$this->user_model->get_image($userid);
                $this->load->view('public/edit_profile',$data);
           /*}*/ 
        }else{
            redirect('/');
        }
    }
    function edit_normal_byid($id){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            //$this->form_validation->set_rules("address", "Address ", "trim|required|htmlspecialchars");
            // $this->form_validation->set_rules("phone", "Mobile", "numeric|trim|required|htmlspecialchars");
            //$this->form_validation->set_rules("phone2", "Mobile2", "numeric|trim|required|htmlspecialchars");
            // $this->form_validation->set_rules("email", "Email ", "trim|required|htmlspecialchars");

           if($this->form_validation->run()== TRUE)
           {

              $result = $this->user_model->update_normal_customer_byid($id);

                    if($result){
                        exit(json_encode(array("status"=>TRUE)));
                    }
                    else{

                        exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                    }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
        else
        {
            show_error("We are unable to process this request on this way!");
        }
    }
    function edit_profile_byid($id){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("location", "Location ", "trim|required|htmlspecialchars");

            if($this->form_validation->run()== TRUE)
            {
              $result = $this->user_model->update_profile_byid($id);

                    if($result){
                        exit(json_encode(array("status"=>TRUE)));
                    }
                    else{

                        exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                    }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
        else
        {
            show_error("We are unable to process this request on this way!");
        }
    }
    function do_upload()
    {
        $this->load->library('upload');
        $images=array();
        $data=array();
        $files = $_FILES;
        $cpt = count($_FILES['userfile']['name']);
        for($i=0; $i<$cpt; $i++)
        {
            $_FILES['userfile']['name']= $files['userfile']['name'][$i];
            $_FILES['userfile']['type']= $files['userfile']['type'][$i];
            $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
            $_FILES['userfile']['error']= $files['userfile']['error'][$i];
            $_FILES['userfile']['size']= $files['userfile']['size'][$i];

            $this->upload->initialize($this->set_upload_options());
            $upload_img= $this->upload->do_upload();
             if(!$upload_img){
                exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
            } else{
                $fileName = $_FILES['userfile']['name'];
                $images[] = $fileName;
            }
        }
        $datas = getLoginId();
        if($datas){
            $userid = $datas['id'];
        }
        foreach ($images as $key => $img) {
            $data[] = array('user_id'=>$userid,'profile'=>$img);
        }
        $query=$this->user_model->image_add($data);
        if($query){
            redirect('Home/profile/');
        }
    }

    private function set_upload_options()
    {
        //upload an image options
        $config = array();
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        //$config['max_size']   = '100';
        // $config['max_width']  = '1024';
        //$config['max_height']  = '768';
        $config['overwrite']     = FALSE;
        return $config;
    }

    function view_image()
    {
        //$session_array = $this->session->userdata('logged_in_user');
        $loginsession = $this->session->userdata('logged_in_user');
        $userid=$loginsession['user_id'];
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        // var_dump( $data['user']);
        $this->load->view('edit_profile',$data);
    }
    public function edit_image(){
        $id = $this->input->post('userfile');

        if(($_FILES['userfile']['name']) != NULL)
        {
            $config['upload_path']   = './uploads';
            $config['allowed_types'] = 'gif|jpg|png|flv|f4v';
            $config['max_size']      = 2048;
            $config['max_width']     = 2048;
            $config['max_height']    = 2048;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ( ! $this->upload->do_upload('userfile'))
            {
                exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));

            }
            else
            {
                $uploading_file = $this->upload->data();
                $image_file = $uploading_file['file_name'];

            }

        } else {
            $current_image = $this->Baner_model->get_cur_client_img($id);

            $image_file = $current_image['image'];

        }

        $update = $this->Baner_model->edit_profile($image_file,$id);
        if($update)
        {
            redirect('Home/profile');
        }else{
            exit(json_encode(array('status'=>FALSE, 'reason'=>"Database Error")));
        }
    }


    function ba_mail()
    {
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("email", "Email", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Mobile", "trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $mail_from = 'maneeshakk16@gmail.com';
                $mail_head = 'Jaazzo';
                $subject = 'BA Request';
                $email=$this->input->post('email');
                $phone=$this->input->post('phone');

                $email_message = "Thank you for your recent request submission!  Your request has been received and added . We will contact you very soon!  ";
                $mail= send_custom_email($mail_from, $mail_head, $email, $subject, $email_message);

                if($mail)
                {
                   $sql = "select email from gp_login_table where type = 'super_admin'";
                    $sql = $this->db->query($sql);
                    $qr = $sql->row_array();
                    $email = $qr['email'];
                    $mail_from = 'maneeshakk16@gmail.com';
                    $mail_head = 'Jaazzo';
                    $mail_to = $email;
                    $subject = 'BA Request';
                    $email=$this->input->post('email');
                    $phone=$this->input->post('phone');
                    // $email_message = $this->load->view('public/edit_email_template_otp', '',TRUE);
                    $email_message = "request for business associates name:$email , phone: $phone";
                    $mail= send_custom_email($mail_from, $mail_head, $mail_to, $subject, $email_message);

                    exit(json_encode(array("status"=>TRUE)));

                }
            }else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }else{
            echo "unable to process in this way";
        }
    }
    function get_all_products_cat_wise($cat_id)
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
        }else{
            $login_id = '';
        }
        if(!empty($login_id)){
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
        }
            

        $data['channel_partner'] = $this->user_model->get_channel_partner();
        $data['vallet_type'] = $this->product_model->get_wallet();
        $data['get_category']=$this->product_model->get_all_category();
   
        $data['get_brand']=$this->product_model->get_all_brands();
        $this->load->library('pagination');   

        $brand = $this->input->post('brand');
        $category = $this->input->post('category');
      
        if($brand=='')
         {
             $brand_query='';
         }
         else
         {
             $brands = implode("','",$brand);

             $brand_query ="dt.brand_id IN ('$brands') and ";         
         }
        
        if(empty($category)){
            $result = $this->product_model->get_all_categories_from_parent($cat_id);
          
            if(empty($result)){
            $cat_where = "dt.sub_cp_type_id = '$cat_id' and ";
            }else{
                $cat_where = "(dt.sub_cp_type_id IN ('$result') or dt.sub_cp_type_id='$cat_id') and ";            
            }
         }
         else{
              $result = implode("','",$category);
              $cat_where = "dt.sub_cp_type_id IN ('$result') and ";
         }
        
         
        $where = $brand_query.''.$cat_where;
    
        $config = array();
          if($this->uri->segment(5) == ''){
                $config["base_url"] = base_url() . 'home/get_all_products_cat_wise/$cat_id/page/';
            }else{
                $config["base_url"] = base_url() . 'home/get_all_products_cat_wise/$cat_id/page/';
            }
          $sort_order = $this->input->post('sort_order');
          $locationsession = $this->session->userdata('selected_location');
          $lcid=($locationsession['id']) ? $locationsession['id'] : 0;  
          $config["total_rows"] = $this->product_model->getAllProductCount($where,$lcid);
          
          $config["per_page"] = 15;
        
          $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
          $config['full_tag_close'] = '</ul></div><!--pagination-->';
          
          $config['first_link'] = '&laquo; First';
          $config['first_tag_open'] = '<li class="prev page">';
          $config['first_tag_close'] = '</li>';

          $config['last_link'] = 'Last &raquo;';
          $config['last_tag_open'] = '<li class="next page">';
          $config['last_tag_close'] = '</li>';

          $config['next_link'] = 'Next &rarr;';
          $config['next_tag_open'] = '<li class="next page">';
          $config['next_tag_close'] = '</li>';

          $config['prev_link'] = '&larr; Previous';
          $config['prev_tag_open'] = '<li class="prev page">';
          $config['prev_tag_close'] = '</li>';

          /*$config['cur_tag_open'] = '<li class="active"><a href="">';
          $config['cur_tag_close'] = '</a></li>';*/
          
          $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
          $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

          $config['num_tag_open'] = '<li class="page">';
          $config['num_tag_close'] = '</li>';


          $this->pagination->initialize($config);
          //var_dump($this->pagination->create_links());exit();
          $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
          $data['page'] = $page;

          $data["data"] = $this->product_model->getAllProduct1($where, $config["per_page"],$page,$sort_order,$lcid);
          //echo json_encode($data["data"]);exit();
          $data['cat_id'] = $cat_id;
          // echo json_encode($data["data"]);exit;
            if($this->input->post('ajax') == true)
            { exit(json_encode(array(
                'data' => $data["data"],
                'status' => $data["data"]["status"],
                'pagination' => $this->pagination->create_links()
            )));
            }
       
        //echo json_encode( $data);exit;
        $data['submenu'] = $this->product_model->get_submenu();
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_list_products_catwise",$data);
    }
    function get_all_products($lcid)
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
        }else{
            $login_id = '';
        }
        if(!empty($login_id)){
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
        }
            

        $data['channel_partner'] = $this->user_model->get_channel_partner();
        $data['vallet_type'] = $this->product_model->get_wallet();
        $data['get_category']=$this->product_model->get_all_category();
   
        $data['get_brand']=$this->product_model->get_all_brands();
        $this->load->library('pagination');   

        $brand = $this->input->post('brand');
        $category = $this->input->post('category');
       
         if($brand=='')
         {
             $brand_query='';
         }
         else
         {
             $brands = implode("','",$brand);

             $brand_query ="dt.brand_id IN ('$brands') and";         
         }
        
          if($category == "")  
          {
           $category_query = "";
          }
          
          else{
               $categories = implode("','",$category);
              if($brand_query == '')
               { 
                  $category_query = "dt.sub_cp_type_id IN ('$categories') and";
               }
               else{
                  $category_query = " dt.sub_cp_type_id IN ('$categories') and";
               }
            }
        $where = $brand_query.$category_query;
      
        $config = array();
          if($this->uri->segment(6) == ''){
                $config["base_url"] = base_url() . 'home/get_all_products/$lcid/page/';
            }else{
                $config["base_url"] = base_url() . 'home/get_all_products/$lcid/page/';
            }
          $sort_order = $this->input->post('sort_order');  
          $config["total_rows"] = $this->product_model->getAllProductCount($where,$lcid);
          //echo json_encode($config["total_rows"]);exit;
          $config["per_page"] = 15;
        
          $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
          $config['full_tag_close'] = '</ul></div><!--pagination-->';
          
          $config['first_link'] = '&laquo; First';
          $config['first_tag_open'] = '<li class="prev page">';
          $config['first_tag_close'] = '</li>';

          $config['last_link'] = 'Last &raquo;';
          $config['last_tag_open'] = '<li class="next page">';
          $config['last_tag_close'] = '</li>';

          $config['next_link'] = 'Next &rarr;';
          $config['next_tag_open'] = '<li class="next page">';
          $config['next_tag_close'] = '</li>';

          $config['prev_link'] = '&larr; Previous';
          $config['prev_tag_open'] = '<li class="prev page">';
          $config['prev_tag_close'] = '</li>';

          $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
          $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

          $config['num_tag_open'] = '<li class="page">';
          $config['num_tag_close'] = '</li>';


          $this->pagination->initialize($config);
          //var_dump($this->pagination->create_links());exit();
          $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
          $data['page'] = $page;

          $data["data"] = $this->product_model->getAllProduct($where, $config["per_page"],$page,$sort_order,$lcid);
          //echo json_encode($data["data"]);exit;
            if($this->input->post('ajax') == true)
            { exit(json_encode(array(
                'data' => $data["data"],
                'status' => $data["data"]["status"],
                'pagination' => $this->pagination->create_links()
            )));
            }
        if($lcid!=0)
        {            
            $cdata = select_by_id('cities',$lcid);
            $session_location = array();
            $session_location = array(      
                'id' => $lcid,
                'name' => $cdata->name,
            );
            $this->session->set_userdata('selected_location', $session_location);
        }
           
        $data['submenu'] = $this->product_model->get_submenu();
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_list_products",$data);
    }
    function get_all_deals()
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
        }else{
            $login_id = '';
        }
        if(!empty($login_id)){
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
        }
            

        $data['channel_partner'] = $this->user_model->get_channel_partner();
        $data['vallet_type'] = $this->product_model->get_wallet();
        $data['get_category']=$this->product_model->get_all_category();
   
        $data['get_brand']=$this->product_model->get_all_brands();
        $this->load->library('pagination');   

        $brand = $this->input->post('brand');
        $category = $this->input->post('category');
       // var_dump($category);exit();
         if($brand=='')
         {
             $brand_query='';
         }
         else
         {
             $brands = implode("','",$brand);

             $brand_query =" dt.brand_id IN ('$brands') and";         
         }
        
       
       
          if($category == "")  
          {
           $category_query = "";
          }
          
          else{
               $categories = implode("','",$category);
              if($brand_query == "")
               { 
                  $category_query = "dt.sub_cp_type_id IN ('$categories') and";
               }
               else{
                  $category_query = "dt.sub_cp_type_id IN ('$categories') and";
               }
            }
        $where = $brand_query.$category_query;
       // var_dump($where);exit();
        $config = array();
          if($this->uri->segment(5) == ''){
                $config["base_url"] = base_url() . 'home/get_all_deals/page/';
            }else{
                $config["base_url"] = base_url() . 'home/get_all_deals/page/';
            }
          $sort_order = $this->input->post('sort_order');  
          $config["total_rows"] = $this->product_model->getAllDealsCount($where);
          
          $config["per_page"] = 15;
          //var_dump($config["total_rows"]);var_dump($config["per_page"]);exit();
          //pagination customization using bootstrap styles
          $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
          $config['full_tag_close'] = '</ul></div><!--pagination-->';
          
          $config['first_link'] = '&laquo; First';
          $config['first_tag_open'] = '<li class="prev page">';
          $config['first_tag_close'] = '</li>';

          $config['last_link'] = 'Last &raquo;';
          $config['last_tag_open'] = '<li class="next page">';
          $config['last_tag_close'] = '</li>';

          $config['next_link'] = 'Next &rarr;';
          $config['next_tag_open'] = '<li class="next page">';
          $config['next_tag_close'] = '</li>';

          $config['prev_link'] = '&larr; Previous';
          $config['prev_tag_open'] = '<li class="prev page">';
          $config['prev_tag_close'] = '</li>';

          /*$config['cur_tag_open'] = '<li class="active"><a href="">';
          $config['cur_tag_close'] = '</a></li>';*/
          
          $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
          $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

          $config['num_tag_open'] = '<li class="page">';
          $config['num_tag_close'] = '</li>';


          $this->pagination->initialize($config);
          //var_dump($this->pagination->create_links());exit();
          $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
          $data['page'] = $page;

          $data["data"] = $this->product_model->getAllDeal($where, $config["per_page"],$page,$sort_order);
          // echo json_encode($data["data"]);exit;
            if($this->input->post('ajax') == true)
            { exit(json_encode(array(
                'data' => $data["data"],
                'status' => $data["data"]["status"],
                'pagination' => $this->pagination->create_links()
            )));
            }

        //echo json_encode( $data);exit;
        
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_list_deals",$data);
    }
    function get_all_products_module_wise($mod_id)
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
        }else{
            $login_id = '';
        }
        if(!empty($login_id)){
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
        }
            

        $data['channel_partner'] = $this->user_model->get_channel_partner();
        $data['vallet_type'] = $this->product_model->get_wallet();
        $data['get_category']=$this->product_model->get_all_category();
        $data['get_brand']=$this->product_model->get_all_brands();
        $this->load->library('pagination');   

        $brand = $this->input->post('brand');
        $category = $this->input->post('category');
          if($brand=='')
             {
                 $brand_query='';
             }
             else
             {
                 $brands = implode("','",$brand);

                 $brand_query ="dt.brand_id IN ('$brands') and";         
             }
            
              if($category == "")  
              {
               $category_query = "";
              }
              
              else{
                   $categories = implode("','",$category);
                  if($brand_query == '')
                   { 
                      $category_query = "dt.sub_cp_type_id IN ('$categories') and";
                   }
                   else{
                      $category_query = " dt.sub_cp_type_id IN ('$categories') and";
                   }
                }
            $where = $brand_query.$category_query;
          $config = array();
          if($this->uri->segment(5) == ''){
                $config["base_url"] = base_url() . 'home/get_all_products_module_wise/$mod_id/page/';
            }else{
                $config["base_url"] = base_url() . 'home/get_all_products_module_wise/$mod_id/page/';
            }
          $sort_order = $this->input->post('sort_order'); 
          $locationsession = $this->session->userdata('selected_location');
          $lcid=($locationsession['id']) ? $locationsession['id'] : 0; 
          $config["total_rows"] = $this->product_model->getAllProductCountModulewise($where,$mod_id,$lcid);
          //var_dump($config["total_rows"]);exit();
          $config["per_page"] = 15;
        
          $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
          $config['full_tag_close'] = '</ul></div><!--pagination-->';
          
          $config['first_link'] = '&laquo; First';
          $config['first_tag_open'] = '<li class="prev page">';
          $config['first_tag_close'] = '</li>';

          $config['last_link'] = 'Last &raquo;';
          $config['last_tag_open'] = '<li class="next page">';
          $config['last_tag_close'] = '</li>';

          $config['next_link'] = 'Next &rarr;';
          $config['next_tag_open'] = '<li class="next page">';
          $config['next_tag_close'] = '</li>';

          $config['prev_link'] = '&larr; Previous';
          $config['prev_tag_open'] = '<li class="prev page">';
          $config['prev_tag_close'] = '</li>';

          $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
          $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

          $config['num_tag_open'] = '<li class="page">';
          $config['num_tag_close'] = '</li>';

          $this->pagination->initialize($config);
          //var_dump($this->pagination->create_links());exit();
          $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
          $data['page'] = $page;

          $data["data"] = $this->product_model->getAllProductModulewise($where, $config["per_page"],$page,$sort_order,$mod_id,$lcid);
          $data['mod_id'] = $mod_id;
          // echo json_encode($data["data"]);exit;
            if($this->input->post('ajax') == true)
            { exit(json_encode(array(
                'data' => $data["data"],
                'status' => $data["data"]["status"],
                'pagination' => $this->pagination->create_links()
            )));
            }

        //echo json_encode( $data);exit;
        $data['submenu'] = $this->product_model->get_submenu();
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_list_products_modulewise",$data);
    }
    function get_all_products_cp_wise($id)
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
        }else{
            $login_id = '';
        }
        if(!empty($login_id)){
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
        }
            

        $data['channel_partner'] = $this->user_model->get_channel_partner();
        $data['vallet_type'] = $this->product_model->get_wallet();
        $data['get_category']=$this->product_model->get_all_category();
        $data['get_brand']=$this->product_model->get_all_brands();
        $this->load->library('pagination');   

        $brand = $this->input->post('brand');
        $category = $this->input->post('category');
          if($brand=='')
             {
                 $brand_query='';
             }
             else
             {
                 $brands = implode("','",$brand);

                 $brand_query ="dt.brand_id IN ('$brands') and";         
             }
            
              if($category == "")  
              {
               $category_query = "";
              }
              
              else{
                   $categories = implode("','",$category);
                  if($brand_query == '')
                   { 
                      $category_query = "dt.sub_cp_type_id IN ('$categories') and";
                   }
                   else{
                      $category_query = " dt.sub_cp_type_id IN ('$categories') and";
                   }
                }
            $where = $brand_query.$category_query;
          $config = array();
          if($this->uri->segment(5) == ''){
                $config["base_url"] = base_url() . 'home/get_all_products_module_wise/$id/page/';
            }else{
                $config["base_url"] = base_url() . 'home/get_all_products_module_wise/$id/page/';
            }
          $sort_order = $this->input->post('sort_order');  
          $config["total_rows"] = $this->product_model->getAllProductCountCpwise($where,$id);
          
          $config["per_page"] = 15;
        
          $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
          $config['full_tag_close'] = '</ul></div><!--pagination-->';
          
          $config['first_link'] = '&laquo; First';
          $config['first_tag_open'] = '<li class="prev page">';
          $config['first_tag_close'] = '</li>';

          $config['last_link'] = 'Last &raquo;';
          $config['last_tag_open'] = '<li class="next page">';
          $config['last_tag_close'] = '</li>';

          $config['next_link'] = 'Next &rarr;';
          $config['next_tag_open'] = '<li class="next page">';
          $config['next_tag_close'] = '</li>';

          $config['prev_link'] = '&larr; Previous';
          $config['prev_tag_open'] = '<li class="prev page">';
          $config['prev_tag_close'] = '</li>';

          $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
          $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

          $config['num_tag_open'] = '<li class="page">';
          $config['num_tag_close'] = '</li>';

          $this->pagination->initialize($config);
          //var_dump($this->pagination->create_links());exit();
          $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
          $data['page'] = $page;

          $data["data"] = $this->product_model->getAllProductCpwise($where, $config["per_page"],$page,$sort_order,$id);
          $data['cp_id'] = $id;
          // echo json_encode($data["data"]);exit;
            if($this->input->post('ajax') == true)
            { exit(json_encode(array(
                'data' => $data["data"],
                'status' => $data["data"]["status"],
                'pagination' => $this->pagination->create_links()
            )));
            }

        //echo json_encode( $data);exit;
        $data['submenu'] = $this->product_model->get_submenu();
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_list_all_products_cpwise",$data);
    }
    function get_all_cp($id)
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
        }else{
            $login_id = '';
        }
        if(!empty($login_id)){
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
        }
            

        $data['channel_partner'] = $this->user_model->get_channel_partner();
        $data['vallet_type'] = $this->product_model->get_wallet();
        $data['get_category']=$this->product_model->get_all_category();
        $data['get_brand']=$this->product_model->get_all_brands();
        $this->load->library('pagination');   

          $config = array();
          if($this->uri->segment(5) == ''){
                $config["base_url"] = base_url() . 'home/get_all_cp/$id/page/';
            }else{
                $config["base_url"] = base_url() . 'home/get_all_cp/$id/page/';
            }  
          $config["total_rows"] = $this->product_model->getAllcpsCount($id);
          
          $config["per_page"] = 15;
        
          $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
          $config['full_tag_close'] = '</ul></div><!--pagination-->';
          
          $config['first_link'] = '&laquo; First';
          $config['first_tag_open'] = '<li class="prev page">';
          $config['first_tag_close'] = '</li>';

          $config['last_link'] = 'Last &raquo;';
          $config['last_tag_open'] = '<li class="next page">';
          $config['last_tag_close'] = '</li>';

          $config['next_link'] = 'Next &rarr;';
          $config['next_tag_open'] = '<li class="next page">';
          $config['next_tag_close'] = '</li>';

          $config['prev_link'] = '&larr; Previous';
          $config['prev_tag_open'] = '<li class="prev page">';
          $config['prev_tag_close'] = '</li>';

          $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
          $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

          $config['num_tag_open'] = '<li class="page">';
          $config['num_tag_close'] = '</li>';

          $this->pagination->initialize($config);
          //var_dump($this->pagination->create_links());exit();
          $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
          $data['page'] = $page;

          $data["data"] = $this->product_model->getAllcps($config["per_page"],$page,$id);
          //echo json_encode($data["data"]);exit();
          //var_dump($this->input->post('ajax'));exit();
          $data['cp_id'] = $id;
            if($this->input->post('ajax') == true)
            {  //var_dump("expression");exit;
                exit(json_encode(array(
                'data' => $data["data"],
                'status' => $data["data"]["status"],
                'pagination' => $this->pagination->create_links()
            )));
            }
         if($id !="0")
            { 
                $session_location = array();
                if($id=="all"){
                   $session_location = array(      
                    'id' => "all",
                    'name' => "All Locations",
                  );
                }else{
                   $cdata = select_by_id('cities',$id);
                   $session_location = array(      
                    'id' => $id,
                    'name' => $cdata->name,
                  );
                }
                  $this->session->set_userdata('selected_location', $session_location);
            }     
        $data['submenu'] = $this->product_model->get_submenu();
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_list_channelpartners",$data);
    }
    function get_all_deals_module_wise($mod_id)
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
        }else{
            $login_id = '';
        }
        if(!empty($login_id)){
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
        }
            

        $data['channel_partner'] = $this->user_model->get_channel_partner();
        $data['vallet_type'] = $this->product_model->get_wallet();
        $data['get_category']=$this->product_model->get_all_category();
   
        $data['get_brand']=$this->product_model->get_all_brands();
        $this->load->library('pagination');   

        $brand = $this->input->post('brand');
        $category = $this->input->post('category');
          if($brand=='')
             {
                 $brand_query='';
             }
             else
             {
                 $brands = implode("','",$brand);

                 $brand_query ="dt.brand_id IN ('$brands') and";         
             }
            
              //var_dump($brand_query);exit();
           
              if($category == "")  
              {
               $category_query = "";
              }
              
              else{
                   $categories = implode("','",$category);
                  if($brand_query == '')
                   { 
                      $category_query = "dt.sub_cp_type_id IN ('$categories') and";
                   }
                   else{
                      $category_query = " dt.sub_cp_type_id IN ('$categories') and";
                   }
                }
            $where = $brand_query.$category_query;
          $config = array();
          if($this->uri->segment(5) == ''){
                $config["base_url"] = base_url() . 'home/get_all_deals_module_wise/$mod_id/page/';
            }else{
                $config["base_url"] = base_url() . 'home/get_all_deals_module_wise/$mod_id/page/';
            }
          $sort_order = $this->input->post('sort_order');  
          $config["total_rows"] = $this->product_model->getAllDealCountModulewise($where,$mod_id);
          
          $config["per_page"] = 15;
        
          $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
          $config['full_tag_close'] = '</ul></div><!--pagination-->';
          
          $config['first_link'] = '&laquo; First';
          $config['first_tag_open'] = '<li class="prev page">';
          $config['first_tag_close'] = '</li>';

          $config['last_link'] = 'Last &raquo;';
          $config['last_tag_open'] = '<li class="next page">';
          $config['last_tag_close'] = '</li>';

          $config['next_link'] = 'Next &rarr;';
          $config['next_tag_open'] = '<li class="next page">';
          $config['next_tag_close'] = '</li>';

          $config['prev_link'] = '&larr; Previous';
          $config['prev_tag_open'] = '<li class="prev page">';
          $config['prev_tag_close'] = '</li>';

          $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
          $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

          $config['num_tag_open'] = '<li class="page">';
          $config['num_tag_close'] = '</li>';

          $this->pagination->initialize($config);
          //var_dump($this->pagination->create_links());exit();
          $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
          $data['page'] = $page;

          $data["data"] = $this->product_model->getAllDealModulewise($where, $config["per_page"],$page,$sort_order,$mod_id);
          $data['mod_id'] = $mod_id;
          // echo json_encode($data["data"]);exit;
            if($this->input->post('ajax') == true)
            { exit(json_encode(array(
                'data' => $data["data"],
                'status' => $data["data"]["status"],
                'pagination' => $this->pagination->create_links()
            )));
            }

        //echo json_encode( $data);exit;
        $data['submenu'] = $this->product_model->get_submenu();
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_list_deals_modulewise",$data);
    }
    function get_all_deals_cp_wise($id)
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
        }else{
            $login_id = '';
        }
        if(!empty($login_id)){
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
        }
            

        $data['channel_partner'] = $this->user_model->get_channel_partner();
        $data['vallet_type'] = $this->product_model->get_wallet();
        $data['get_category']=$this->product_model->get_all_category();
   
        $data['get_brand']=$this->product_model->get_all_brands();
        $this->load->library('pagination');   

        $brand = $this->input->post('brand');
        $category = $this->input->post('category');
          if($brand=='')
             {
                 $brand_query='';
             }
             else
             {
                 $brands = implode("','",$brand);

                 $brand_query ="dt.brand_id IN ('$brands') and";         
             }
            
              //var_dump($brand_query);exit();
           
              if($category == "")  
              {
               $category_query = "";
              }
              
              else{
                   $categories = implode("','",$category);
                  if($brand_query == '')
                   { 
                      $category_query = "dt.sub_cp_type_id IN ('$categories') and";
                   }
                   else{
                      $category_query = " dt.sub_cp_type_id IN ('$categories') and";
                   }
                }
            $where = $brand_query.$category_query;
          $config = array();
          if($this->uri->segment(5) == ''){
                $config["base_url"] = base_url() . 'home/get_all_deals_cp_wise/$id/page/';
            }else{
                $config["base_url"] = base_url() . 'home/get_all_deals_cp_wise/$id/page/';
            }
          $sort_order = $this->input->post('sort_order');  
          $config["total_rows"] = $this->product_model->getAllDealCountCpwise($where,$id);
          
          $config["per_page"] = 15;
        
          $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
          $config['full_tag_close'] = '</ul></div><!--pagination-->';
          
          $config['first_link'] = '&laquo; First';
          $config['first_tag_open'] = '<li class="prev page">';
          $config['first_tag_close'] = '</li>';

          $config['last_link'] = 'Last &raquo;';
          $config['last_tag_open'] = '<li class="next page">';
          $config['last_tag_close'] = '</li>';

          $config['next_link'] = 'Next &rarr;';
          $config['next_tag_open'] = '<li class="next page">';
          $config['next_tag_close'] = '</li>';

          $config['prev_link'] = '&larr; Previous';
          $config['prev_tag_open'] = '<li class="prev page">';
          $config['prev_tag_close'] = '</li>';

          $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
          $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

          $config['num_tag_open'] = '<li class="page">';
          $config['num_tag_close'] = '</li>';

          $this->pagination->initialize($config);
          //var_dump($this->pagination->create_links());exit();
          $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
          $data['page'] = $page;

          $data["data"] = $this->product_model->getAllDealCpwise($where, $config["per_page"],$page,$sort_order,$id);
          $data['cp_id'] = $id;
          // echo json_encode($data["data"]);exit;
            if($this->input->post('ajax') == true)
            { exit(json_encode(array(
                'data' => $data["data"],
                'status' => $data["data"]["status"],
                'pagination' => $this->pagination->create_links()
            )));
            }

        //echo json_encode( $data);exit;
        $data['submenu'] = $this->product_model->get_submenu();
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_list_deals_cpwise",$data);
    }
    function get_all_products_by_id($id)
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
           
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['vallet_type'] = $this->product_model->get_wallet();  
        } 

        $data['get_category']=$this->product_model->get_all_category();
        //echo json_encode($data['get_category']);exit;
        $data['get_brand']=$this->product_model->get_all_brands();
        $this->load->library('pagination');

        $brand = $this->input->post('brand');
        $catgery = $this->input->post('catgery');
        //var_dump($catgery);
        //var_dump($brand);exit;
        $brand =  $brand=="0"? "" : "and dt.brand_id = '$brand' ";
        // var_dump($brand);exit;
        if($brand == "")
        {
            $catgery =  $catgery=="0"? "" : "and dt.category_id = '$catgery'";
        }else{
            $catgery =  $catgery=="0"? "" : "or dt.category_id = '$catgery'";
        }



        $where = $brand.$catgery;
        // var_dump($where);exit;
        $config["base_url"] = base_url().'home/get_all_products/';
        $config["total_rows"] = $this->product_model->getAllProductCountById($where,$id);
        //var_dump($config["total_rows"]); exit();

        $config["per_page"] = 15;

        //pagination customization using bootstrap styles
        $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
        $config['full_tag_close'] = '</ul></div><!--pagination-->';

        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';

        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';

        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';

        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';



        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';

        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['page'] = $page;

        $data["data"] = $this->product_model->getAllProductById($where, $config["per_page"],$page,$id);
        //echo json_encode($data["data"]);exit;
        //check if ajax is called
        //  echo json_encode( $data["data"]["status"]);exit;

        if($this->input->post('ajax') == true)
        {       exit(json_encode(array(
            'data' => $data["data"],
            'status' => $data["data"]["status"],
            'pagination' => $this->pagination->create_links()
        )));
        }

        //echo json_encode( $data);
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_show_all_product",$data);
    }
    
    

    function module_inner()
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
           
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['vallet_type'] = $this->product_model->get_wallet();  
        } 
        $data['get_menu']=$this->product_model->get_menus();
        $data['products'] = $this->product_model->get_Product();
        $data['deal'] = $this->product_model->get_deal_product();
        $data['submenu'] = $this->product_model->get_submenu();
        $data['premiyam'] = $this->product_model->get_premiyam();
        $data['prod'] = $this->product_model->get_product_view();

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_module_inner_page",$data);
    }
  
    function change_current_pass()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('old', 'Username', 'required|trim');
            $this->form_validation->set_rules('new_pass', 'Password', 'required|trim');
            $this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'required|trim');
           
            if($this->form_validation->run() == TRUE)
            {
                $old_pass = $this->input->post('old');

                $new_pass = $this->input->post('new_pass');
                $confirm_pass = $this->input->post('confirm_pass');
                $session_array = $this->session->userdata('logged_in_user');
                
                $user_id = $session_array['id'];

                $current_pass = $this->user_model->get_current_pass($user_id);
                $current_pass = $current_pass['password'];
                
                if($current_pass == $old_pass)
                {
                    if($new_pass == $confirm_pass){
                        $update_pass = $this->user_model->update_pass($new_pass, $user_id);
                        if($update_pass)
                        {
                            exit(json_encode(array('status'=>true)));
                        } else
                        {
                            exit(json_encode(array('status'=>false, 'reason'=>'Database Error')));
                        }
                    } else
                    {
                        exit(json_encode(array('status'=>false, 'reason'=>'New password and Confirm Password Does not Matchs')));
                    }
                } else
                {
                    exit(json_encode(array('status'=>false, 'reason'=>'This is not your old password :(')));
                }
                
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } 
        else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        }  
    }


    // Club Agent
    function add_club_agent()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('mail', 'Email', 'required|trim');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim');
            /*if (empty($_FILES['ufile']['name']))
            {
              $this->form_validation->set_rules('ufile', 'File', 'required');
            }*/
            if($this->form_validation->run() == TRUE)
            {
                $name = $this->input->post('name');
                $mail = $this->input->post('mail');
                $validate_email = $this->register_model->validate_email($mail);
                
                if($validate_email['status'] === TRUE)
                {
                    $mobile = $this->input->post('mobile');
                    $validate_phone = $this->register_model->validate_phone($mobile);
                    if($validate_phone['status'] === TRUE)
                    {
                        $files = $_FILES;
                        if($files){
                        $config['upload_path'] =  './uploads/ca_docs';
                        $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
                        $config['max_size'] = '2000000';
                        $config['remove_spaces'] = true;
                        $config['overwrite'] = false;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('ufile'))
                        {
                          exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
                        }else{
                            $_FILES['ufile']['name']= time().str_replace(' ', '_', $files['ufile']['name']);
                            $_FILES['ufile']['type']= $files['ufile']['type'];
                            $_FILES['ufile']['tmp_name']= $files['ufile']['tmp_name'];
                            $_FILES['ufile']['error']= $files['ufile']['error'];
                            $_FILES['ufile']['size']= $files['ufile']['size'];
                            $this->upload->do_upload('ufile');
                            $fileName = time().str_replace(' ', '_', $files['ufile']['name']);
                            $upload_data = $this->upload->data();
                            $data=array('mobile' => $mobile,
                            'name' => $name,
                            'email' => $mail,
                            'file'=>'uploads/ca_docs/'.$fileName,
                            'register_via'=>'club_member'
                            );
                        }
                    }else{
                        $data=array('mobile' => $mobile,
                            'name' => $name,
                            'email' => $mail,
                            'register_via'=>'club_member'
                            );
                    }
                            $result = $this->register_model->add_club_agent($data);
                            //var_dump($result);exit();
                            if($result)
                            {
                                $data['id'] = $result['info']['user_id'];
                                $data['otp'] = $result['info']['otp'];
                                $otp=$data['otp'];
                                //$username = "pranavpk.pk1@gmail.com";
                                //$hash = "4ec424c177ff9fdebcb835599d38a546ff2238cd";
                                $datas['mobile'] = $mobile;
                                // $test = "0";
                                // $sender = "TXTLCL"; // This is who the message appears to be from.
                                $numbers = $mobile; // A single number or a comma-seperated list of numbers
                                $url =base_url();
                                $message = "Hi, Welcome to Jaazzo.If you are interested with Jaazzo.Please continue with signup: ".$url."ca_signup/".encrypt_decrypt('encrypt',$otp).'/'.$result['info']['user_id'];
                                $message = urlencode($message);
                                /*$data1 = "username=" . $username . "&hash=" . $hash . "&message=" . $message . "&sender=" . $sender . "&numbers=" . $numbers . "&test=" . $test;
                                $ch = curl_init('http://api.textlocal.in/send/?');
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $result = curl_exec($ch); // This is the result from the API
                                curl_close($ch);*/
                                $status= send_message($numbers,$message);
                                
                                if(!empty($mail)){
                                    $email = "maneeshakk16@gmail.com";
                                    $mail_head = 'Message From Jaazzo';
                                    $status = send_custom_email($email, $mail_head, $mail, 'Sign Up - Club Agent', $this->load->view('templates/public/mail/ca_sign_up', $data,TRUE));
                                }
                                if($status)
                                {
                                    exit(json_encode(array('status'=>true)));
                                }else{
                                    exit(json_encode(array("status"=>TRUE)));
                                }
                            }else{
                                exit(json_encode(array('status'=>false, 'reason'=>'Database Error')));
                            }

                        
                    }else{
                        exit(json_encode(array('status'=>false, 'reason'=>'Mobile already exist')));
                    }
                }else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Email already exist')));
                }
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        }  
    } 

    function password_check($str)
    {
        if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
          return TRUE;
        }
       return FALSE;
    }
    function change_password()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('opassword', 'Old Password', 'required|trim');
            $this->form_validation->set_rules('npassword', 'Password', 'required|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[npassword]|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_message('password_check', '%s must contain both numbers and alphabets');

            if($this->form_validation->run() == TRUE)
            {
                $old_pass = $this->input->post('opassword');
                $new_pass = $this->input->post('npassword');
                $confirm_pass = $this->input->post('cpassword');

                $log_id = $this->input->post('id');
                $current_pass_status = $this->register_model->check_current_pwd($log_id,$old_pass);
                if($current_pass_status['status']==true)
                {
                    if($new_pass == $confirm_pass){
                        $update_pass = $this->register_model->update_password($new_pass,$log_id);
                        if($update_pass)
                        {
                            exit(json_encode(array('status'=>true)));
                        } else{
                            exit(json_encode(array('status'=>false, 'reason'=>'Database Error')));
                        }
                    } else{
                        exit(json_encode(array('status'=>false, 'reason'=>'New password and Confirm Password Does not Matchs')));
                    }
                } else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Current Password is incorrect')));
                }
                
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        }
    }
    function add_member()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("email","Email","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("mobile","Mobile No","required|htmlspecialchars");
            $this->form_validation->set_rules("name","Name","trim|required|htmlspecialchars");
            if( $this->form_validation->run() == TRUE )
            {
                
                            $name = $this->input->post('name');
                            $mobile = $this->input->post('mobile');
                            $email = $this->input->post('email');
                            $results=$this->register_model->add_normal_customer();
                            if($results['status'] == TRUE){
                                $otp = $results['info']['otp'];
                                $username = "pranavpk.pk1@gmail.com";
                                $hash = "4ec424c177ff9fdebcb835599d38a546ff2238cd";
                                $test = "0";
                                $sender = "TXTLCL"; // This is who the message appears to be from.
                                $numbers = $mobile; // A single number or a comma-seperated list of numbers
                                $url = base_url().'Register/signup/'.encrypt_decrypt('encrypt',$otp);
                                $message = "Hi, This is from Jaazzo.If you are interested to join with us.Please follow the link below.".$url;
                                $message = urlencode($message);
                                $data = "username=" . $username . "&hash=" . $hash . "&message=" . $message . "&sender=" . $sender . "&numbers=" . $numbers . "&test=" . $test;
                                $ch = curl_init('http://api.textlocal.in/send/?');
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $result = curl_exec($ch); // This is the result from the API
                                curl_close($ch);
                                if($result){
                                    exit(json_encode(array("status"=>TRUE)));
                                }
                            }else{
                                exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                            }
                        // }else{
                        //     exit(json_encode(array("status"=>FALSE,"reason"=>$validate_phone['reason'])));
                        // }
                    // }else{
                    //     exit(json_encode(array("status"=>FALSE,"reason"=>$validate_email['reason'])));
                    // }
            }else{  
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }   
        }else{
            show_error("We are unable to process this request on this way!");   
        }
    }
    function customer_signup()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("email","Email","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("mobile","Mobile No","required|htmlspecialchars");
            $this->form_validation->set_rules("name","Name","trim|required|htmlspecialchars");
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_message('password_check', '%s must contain both numbers and alphabets');
            if( $this->form_validation->run() == TRUE )
            {
                $data = array('email'=>$this->input->post('email'),
                    'name'=>$this->input->post('name'),
                    'mobile'=>$this->input->post('mobile'),
                    'password'=>$this->input->post('password'),
                    'id'=>$this->input->post('id'),
                    'created_by'=>$this->input->post('created_by')
                    );
                $result = $this->register_model->customer_signup($data);
                if($result['status']){
                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }
            }else{  
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }   
        }else{
            show_error("We are unable to process this request on this way!");   
        }
    }
    function exec_sett_signup($id)
    {
      
       
        $data['details'] =$this->Executives_model->get_executives_userid($id);
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_ca_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/exec_signup",$data);
    }

    function signup_executive()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('email', 'Email', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_message('password_check', '%s must contain both numbers and alphabets');
           
            if($this->form_validation->run() == TRUE)
            {
                $mail = $this->input->post('email');
                $id = $this->input->post('id');
                /*$validate_email = $this->register_model->validate_mail($mail,$id);
                
                if($validate_email['status'] === TRUE)
                {*/
                    $password = $this->input->post('password');
                    //$validate_password = $this->Executives_model->validate_password(encrypt_decrypt('encrypt',$this->input->post('password')));
                    /*if($validate_password['status'] === TRUE)
                    {*/
                        $cpassword =$this->input->post('cpassword');
                        
                        if($password==$cpassword){
                            $password =encrypt_decrypt('encrypt',$this->input->post('password'));
                            
                            $data_input = array('password'=>$password,'otp_status'=>1,'email'=>$mail);
                            $where = array('id'=>$id);
                            $res = update_tbl('gp_login_table',$data_input,$where);

                            $s_res = select_by_id('gp_login_table',$id);
                            $u_id = $s_res->user_id;
                            $cr = date("Y-m-d h:i:sa");
                        



                            $data = array('status'=>'ACTIVE','created_on'=>$cr);
                            $ex_where = array('id'=>$u_id);
                            $res = update_tbl('gp_pl_sales_team_members',$data,$ex_where);
                            if($res)
                            {
                               /* $where = 'gp_login_table.user_id=gp_normal_customer.id';
                                $result = select_all_by_id('gp_login_table',$id,'gp_normal_customer',$where);*/
                                /*$session_array = array();
                                $session_array = array(
                                        'id' => $result->id,
                                        'type' => $result->type,
                                        'email' => $result->email,
                                        'mobile' => $result->mobile,
                                        'user_id' => $result->user_id,
                                        'club_type_id'=>$result->club_type_id,
                                        'login' =>true);
                                $this->session->set_userdata('logged_in_user', $session_array);*/
                                exit(json_encode(array('status'=>true)));
                            }else{
                                exit(json_encode(array('status'=>false)));
                            }
                        }else{
                            exit(json_encode(array('status'=>false, 'reason'=>'Password and Confirm should be same')));
                        }
/*                    }else{
                        exit(json_encode(array('status'=>false, 'reason'=>'Password already exist')));
                    }
*/                /*}else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Email already exist')));
                }*/
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        }  
    }
    function get_state_by_country($country)
    {

        if ($this->input->is_ajax_request()) 
        {
            $data = $this->register_model->get_state_by_country($country);
            if($data){
                exit(json_encode(array('status'=>true,'data'=>$data)));
            } else{
                exit(json_encode(array('status'=>false, 'reason'=>'invalid selection')));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        } 
    }


    function new_partner()
    {
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("channel_type[]", "Channel Partner Type ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Phone", "numeric|trim|required|min_length[10]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("phone2", "Phone", "numeric|trim|min_length[7]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email", "valid_email|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("c_email", "Contact Email", "valid_email|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("address", "Address", "trim|required|htmlspecialchars");
           
            $this->form_validation->set_rules("town", "Town", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("isagree", "Agree with the terms and conditions", "trim|required|htmlspecialchars");

            if($this->form_validation->run()== TRUE){
                $this->load->helper('string');
                $otp = random_string('numeric', 5);
                $data = array();
                // var_dump($_FILES['pro']['name']);exit();
                if(!isset($_FILES['pro']['name']))
                {
                    exit(json_encode(array('status'=>FALSE, 'reason'=>"Please select a profile image")));
                }
                if(!isset($_FILES['bri']['name']))
                {
                    exit(json_encode(array('status'=>FALSE, 'reason'=>"Please select a brand image")));
                }
                $result=$this->Cp_model->add_partner($otp);
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
    }
    function get_all_cptypes()
    {
        if ($this->input->is_ajax_request()) 
        {
            $data =  $this->Channelpartner_model->get_all_cptypes();
            if($data){
                exit(json_encode(array('status'=>true,'data'=>$data)));
            } else{
                exit(json_encode(array('status'=>false, 'reason'=>'invalid selection')));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        } 
    }

    
    function cm_signup($otp,$id)
    {
        $otp =  encrypt_decrypt('decrypt',$otp);
        $id = $id;
        $data['details'] = $this->register_model->get_ca_details($id);
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_ca_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/edit_club_member_signup",$data);
    }
    function aboutus()
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);  
            $data['vallet_type'] = getWallet();
        }
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/about_us",$data);
    }
    function our_investors()
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);  
            $data['vallet_type'] = getWallet();
        }
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/our_investors",$data);
    }
    function contact()
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);  
            $data['vallet_type'] = getWallet();
        }
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/contact",$data);
    }
    function send_feedback(){
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|min_length[10]|numeric');
            $this->form_validation->set_rules('comment', 'Comments', 'required');
            $this->form_validation->set_rules('type', 'Type', 'required');
           
            if($this->form_validation->run() == TRUE)
            {
                $tbl = 'contact';
                $data = array('name'=>$this->input->post('name'),
                    'email'=>$this->input->post('email'),
                    'phone'=>$this->input->post('mobile'),
                    'message'=>$this->input->post('comment'),
                    'type'=>$this->input->post('type')
                    );
                $res = insert($tbl,$data);
                if($res){
                    //ack mail
                    $email = $this->input->post('email');
                    $email_message1 = $this->load->view('templates/public/mail/ack_contact_sender','',true);
                    $mail_from = "maneeshakk16@gmail.com";
                    $mail_head = 'JAAZZO';
                    $status1 = send_custom_email($mail_from, $mail_head, $email,'Message From Contact',$email_message1);

                    //Mail to admin
                    $email_message2 = $this->load->view('templates/public/mail/ack_contact_admin',$data,true);
                    $mail_to = "maneeshakk16@gmail.com";
                    $status2 = send_custom_email($email, $mail_head, $mail_to,'Message From Contact',$email_message2);

                    exit(json_encode(array('status'=>true)));
                }else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Something went wrong.Please try again')));
                }
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        }  
    }
    function sitemap()
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);  
            $data['vallet_type'] = getWallet();
        }
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/sitemap",$data);
    }
    function term_condition()
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);  
            $data['vallet_type'] = getWallet();
        }
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/term_condition",$data);
    }
    function help()
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);  
            $data['vallet_type'] = getWallet();
        }
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/help",$data);
    }
    function privacy()
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);  
            $data['vallet_type'] = getWallet();
        }
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/privacy",$data);
    }
    function fare()
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);  
            $data['vallet_type'] = getWallet();
        }
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/fare",$data);
    }

    function testimonial()
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);  
            $data['vallet_type'] = getWallet();
        }
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/testimonial",$data);
    }
    function career()
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);  
            $data['vallet_type'] = getWallet();
        }
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/career",$data);
    }
    function news()
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);  
            $data['vallet_type'] = getWallet();
        }
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/news",$data);
    }
    function news_more()
    {
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);  
            $data['vallet_type'] = getWallet();
        }
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/news_more",$data);
    }
    function download_sms1()
    {
        if($this->input->is_ajax_request())
        {

            $this->form_validation->set_rules("mobile","Mobile","trim|required|htmlspecialchars");
            if( $this->form_validation->run() == TRUE )
            {

                $mobile = $this->input->post('mobile');
                $number =  $mobile; // A single number or a comma-seperated list of numbers
                $message = "Hi, Welcome to Jaazzo. If you are interested with Jaazzo. Please continue with signup: https://play.google.com/store/apps/details?id=com.cybaze.jaazzo";
              
               $result= send_message($number,$message);
                
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{
                    exit(json_encode(array("status"=>FALSE)));
                }
            }

        }else{
            show_error("We are unable to process this request on this way!");
        }

    }
    function ba_signup($otp,$id)
    {
        $otp =  encrypt_decrypt('decrypt',$otp);
        $id = $id;
        $data['details'] = $this->Executives_model->get_ba_details($id);
        $data['get_menu']=$this->product_model->get_menus();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_ca_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/edit_ba_signup",$data);
    }
    function signup_ba()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('email', 'Email', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_message('password_check', '%s must contain both numbers and alphabets');
           
            if($this->form_validation->run() == TRUE)
            {
                $mail = $this->input->post('email');
                $id = $this->input->post('id');

                /*$validate_email = $this->register_model->validate_mail($mail,$id);
                
                if($validate_email['status'] === TRUE)
                {*/
                    $password = $this->input->post('password');

                    /*$validate_password = $this->Executives_model->validate_password(encrypt_decrypt('encrypt',$this->input->post('password')));

                    if($validate_password['status'] === TRUE)
                    {*/

                        $cpassword =$this->input->post('cpassword');

                        if($password==$cpassword){
                            $password =encrypt_decrypt('encrypt',$this->input->post('password'));
                            $data_input = array('password'=>$password,'otp_status'=>1,'email'=>$mail);
                            $where = array('id'=>$id);
                            $res = update_tbl('gp_login_table',$data_input,$where);
                           /// echo $res;exit();
                            if($res)
                            {

                                $where = 'gp_login_table.user_id=pl_ba_registration.id';
                                $result = select_all_by_id('gp_login_table',$id,'pl_ba_registration',$where);

                                $res1 = select_by_id('gp_login_table',$id);
                                $ba_id = $res1->user_id;
                                $tbl2 ='pl_ba_registration';
                                $where2 = "id='$ba_id'";
                                $data2 = array('status'=>'ACTIVE');
                                $RES2 = update_tbl($tbl2,$data2,$where2);
                                /*$session_array = array();
                                $session_array = array(
                                        'id' => $result->id,
                                        'type' => $result->type,
                                        'email' => $result->email,
                                        'mobile' => $result->mobile,
                                        'user_id' => $result->user_id,
                                        'club_type_id'=>$result->club_type_id,
                                        'login' =>true);
                                $this->session->set_userdata('logged_in_user', $session_array);*/
                                exit(json_encode(array('status'=>true)));
                            }else{
                                exit(json_encode(array('status'=>false)));
                            }
                        }else{
                            exit(json_encode(array('status'=>false, 'reason'=>'Password and Confirm should be same')));
                        }
                    /*}else{
                        exit(json_encode(array('status'=>false, 'reason'=>'Password already exist')));
                    }*/
                /*}else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Email already exist')));
                }*/
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        }  
    }

    
    function test($search)
    {
        //$search='a';
        $tbl='gp_normal_customer';
        $cols=array('name','phone','email');
        $result = pagination($search,$tbl,$cols,4,2);
        echo json_encode($result);
    }
    function check_usage_limit(){
        $amount =$this->input->post('amount');
        $data = getLoginId();
        if($data){
            $userid = $data['user_id'];
            $udetail = get_details_by_userid($userid);
            $dateString=$udetail['created_on'];
           // $data["club_type_id"];
            $det = getClubtypeById($data["club_type_id"]);
            $year_limit = $det['cash_limit'];
            $years = round((time()-strtotime($dateString))/(3600*24*365.25));
            if($year_limit>=$years){
                $usage_limit = $det['amount']/$year_limit;
                if($amount<=$usage_limit)
                {
                    exit(json_encode(array('status'=>true)));
                }else{
                    exit(json_encode(array('status'=>false,'reason'=>'You can only use '.$usage_limit.' per year')));
                }
            }else{
                exit(json_encode(array('status'=>false,'reason'=>'Club Membership  expired')));
            }
        }                
    }
    function update_profile_pic()
    {
        $this->load->library('upload');
        $data=array();
        $files = $_FILES;
            $_FILES['userfile']['name']= $files['userfile']['name'];
            $_FILES['userfile']['type']= $files['userfile']['type'];
            $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'];
            $_FILES['userfile']['error']= $files['userfile']['error'];
            $_FILES['userfile']['size']= $files['userfile']['size'];

            $this->upload->initialize($this->set_upload_options());
            $upload_img= $this->upload->do_upload();
             if(!$upload_img){
                exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
            } else{
                $fileName = $_FILES['userfile']['name'];
                $image = $fileName;
            }
        
        $datas = getLoginId();
        if($datas){
            $userid = $datas['user_id'];
        }
        $data = array('user_id'=>$userid,'profile_image'=>$image);
        
        $res=$this->user_model->update_profile_image($data);
        if($res){
           exit(json_encode(array('status'=>TRUE)));          
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'Something went wrong')));
        }
    }
    function deactivate_account()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('reason', 'Reason for leaving', 'required|trim');
            
            if($this->form_validation->run() == TRUE)
            {
                // var_dump($_POST);
                $res=$this->user_model->deactivate_account();
                if($res){
                    $datas = getLoginId();
                    $this->facebook->destroy_session();
                    if($datas){
                       $type = $datas['type'];
                       if($type=='normal_customer')
                        {
                            $this->session->unset_userdata('logged_in_user'); 
                        }else if($type == 'club_member')
                        {
                          $this->session->unset_userdata('logged_in_club_member'); 
                        }else if($type=='club_agent')
                        {
                          $this->session->unset_userdata('logged_in_club_agent'); 
                        }

                        $this->session->sess_destroy(); 
                        exit(json_encode(array('status'=>TRUE)));  
                    }
                } else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Something went wrong')));
                }
            } else{
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        }  
    }
    //mobile - window
    function user_login(){
        $data = $this->check_fb_login();
        $data['get_menu']=$this->product_model->get_menus();
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);  
            $data['vallet_type'] = getWallet();
            $type = $datas['type'];
            if($type=='normal_customer')
            {
                $this->session->unset_userdata('logged_in_user'); 
            }else if($type == 'club_member')
            {
              $this->session->unset_userdata('logged_in_club_member'); 
            }else if($type=='club_agent')
            {
              $this->session->unset_userdata('logged_in_club_agent'); 
            }
            $this->session->sess_destroy();
        }
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_ca_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/edit_user_login",$data);
    }
    function be_a_member(){
        $data['get_menu']=$this->product_model->get_menus();
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);  
            $data['vallet_type'] = getWallet();
        }
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/edit_be_member",$data);
    }
    function money_transfer(){
        $data['get_menu']=$this->product_model->get_menus();
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);  
            $data['vallet_type'] = getWallet();
        }
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/edit_money_transfer",$data);
    }
    function check_usage_limit_exceed()
    {
        $amount =$this->input->post('amount');
        $type =$this->input->post('type');
        $data = getLoginId();
        if($data){
            $userid = $data['user_id'];
            $lid = $data['login_id'];
            $udetail = get_details_by_userid($userid);
            $dateString=$udetail['created_on'];
            $fixed_join_date=$udetail['fixed_join_date'];

            //$data["club_type_id"];
            if($type==1){
                $club = ($data["club_type_id"]>0)?$data["club_type_id"]:$data["investor_type_id"];
                $det = getClubtypeById($club);
                $year_limit = $det['cash_limit'];
                $years = round((time()-strtotime($dateString))/(3600*24*365));
                if($year_limit>=$years){
                    $wallet_used_per_year = $this->get_club_wallet_used_per_year($lid);
                    $usage_limit = ($det['amount']/$year_limit)-$wallet_used_per_year;
                    //$usage_limit = $det['amount']/$year_limit;
                    if($amount<=$usage_limit)
                    {
                        exit(json_encode(array('status'=>true)));
                    }else{
                        exit(json_encode(array('status'=>false,'reason'=>'You can only use '.round($usage_limit).' per year')));
                    }
                }else{
                    exit(json_encode(array('status'=>false,'reason'=>'Club Membership  expired')));
                }
            }
            if($type==5){
                $det2 = getClubtypeById($data["fixed_club_type_id"]);
                $fixed_wallet_details = get_fixed_wallet_details($lid);
                $fixed_wallet_used = get_wallet_used_by_member($lid,5);
                $fixed_wallet_used_per_year = $this->get_fixed_wallet_used_per_year($lid);
                // $tot_amnt = $fixed_wallet_details+$fixed_wallet_used;
                $tot_amnt = $fixed_wallet_details;
                $year_limit = $det2['cash_limit'];
                $years = (time()-strtotime($fixed_join_date))/(3600*24*365);

                if($year_limit>=$years){
                    $fix_within_first_year = date('Y-m-d H:i:s',strtotime('+1 year',strtotime($fixed_join_date)));
                    if(date('Y-m-d H:i:s')<=$fix_within_first_year){
                    }else{
                        switch ($years) {
                            case ($years<=2):
                                $year_limit=4;
                                break;
                            case ($years<=3):
                                $year_limit=3;
                                break;
                            case ($years<=4):
                                $year_limit=2;
                                break;
                            default:
                                $year_limit=1;
                        }
                    }
                        $usage_limit = (($fixed_wallet_details+$fixed_wallet_used_per_year)/$year_limit)-$fixed_wallet_used_per_year;
                        if($amount<$usage_limit)
                        {
                            exit(json_encode(array('status'=>true)));
                        }else if($usage_limit==0)
                        {
                            exit(json_encode(array('status'=>false,'reason'=>'Your fixed wallet usage limit exceed in this year')));
                        }else{
                            exit(json_encode(array('status'=>false,'reason'=>'You can only use '.round($usage_limit).' per year')));
                        }
                }else{
                    exit(json_encode(array('status'=>false,'reason'=>'Fixed Club Membership  expired')));
                }
            }
        }   
    }
    function get_fixed_wallet_used_per_year($id){
        
        $year = date('Y');
        $qry="SELECT SUM(change_value) AS total FROM gp_wallet_activity wa  WHERE wa.wallet_type_id='5' AND wa.user_id='$id' AND wa.type='LOSS' AND YEAR(date_modified) = '$year'";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            $res =  $result->row_array();
            $total = isset($res['total'])?$res['total']:0;
            return $total;
        }else {
            return 0;
        }
    }
    function get_club_wallet_used_per_year($id){
        
        $year = date('Y');
        $qry="SELECT SUM(change_value) AS total FROM gp_wallet_activity wa  WHERE wa.wallet_type_id='1' AND wa.user_id='$id' AND wa.type='LOSS' AND YEAR(date_modified) = '$year'";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            $res =  $result->row_array();
            $total = isset($res['total'])?$res['total']:0;
            return $total;
        }else {
            return 0;
        }
    }
    function crypt()
    {   
        $t = '3425';
        echo $en = encrypt_decrypt('encrypt',$t);
        echo "<br><br>";
        echo $de = encrypt_decrypt('decrypt',$en);
    }
}
?>
