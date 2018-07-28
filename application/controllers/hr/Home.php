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
        $this->load->model(array('user/user_model','user/refer_model','user/product_model','admin/Channelpartner_model','register_model','admin/Executives_model','user/Cp_model'));
        $this->load->library(array('form_validation'));
        $this->load->helper(array('form', 'date','string'));
        // Load facebook library
        $this->load->library('facebook');
        require_once APPPATH.'third_party/src/Google_Client.php';
        require_once APPPATH.'third_party/src/contrib/Google_Oauth2Service.php';

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
            $data['authUrl'] =  $this->facebook->login_url();
        }
        return $data;
    }
    function get_deal()
    {
        if($this->input->is_ajax_request())
        {
            $datas = getLoginId(); 
            if ($datas) {
                $uid = $datas['user_id'];
            }
            // $session_array = $this->session->userdata('logged_in_user');
            // $uid = $session_array['user_id'];
                $data = array(
                              'user_id'=>$uid,
                              'deal_con' =>$this->input->post('deal_id')  
                    );
                $result = $this->user_model->get_deal($data);
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }   
        }else{
            show_error("We are unable to process this request on this way!");   
        }
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

        //echo json_encode($data['wallet']);exit(); 
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['products'] = $this->product_model->get_Product();
        $data['deals'] = $this->product_model->get_deal_product();
        // echo json_encode($data['deals']);exit(); 
        $data['submenu'] = $this->product_model->get_submenu();
        $data['product'] = $this->product_model->get_product_view();
        //  echo json_encode($data['product']);exit(); 
        $data['left_adv'] = $this->user_model->get_ads();
        $data['centre_adv'] = $this->user_model->get_ads_center();
        $data['right_adv'] = $this->user_model->get_ads_right();
        $data['bottom_adv'] = $this->user_model->get_ads_bottom();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_landing_page",$data);
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


    function login_mobile()
    {
        $session_array = $this->session->userdata('logged_in_user');
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/page1",$data);
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
                /*$validate_email = $this->register_model->validate_mail($mail,$id);
                
                if($validate_email['status'] === TRUE)
                {*/
                    $password = $this->input->post('password');
                    //$validate_password = $this->Channelpartner_model->validate_password(encrypt_decrypt('encrypt',$this->input->post('password')));
                   // if($validate_password['status'] === TRUE)
                   // {
                        $cpassword =$this->input->post('cpassword');
                        if($password==$cpassword){
                            $password =encrypt_decrypt('encrypt',$this->input->post('password'));
                            $data_input = array('password'=>$password,'otp_status'=>1,'email'=>$mail);
                            $where = array('id'=>$id);
                            $res = update_tbl('gp_login_table',$data_input,$where);
                            $s_res = select_by_id('gp_login_table',$id);
                            $u_id = $s_res->user_id;
                            $cr = date("Y-m-d h:i:sa");
                            $cp_data_input = array('status'=>'JOINED','created_on'=>$cr);
                            $cp_where = array('id'=>$u_id);
                            $cp_res = update_tbl('gp_pl_channel_partner',$cp_data_input,$cp_where);
                            if($res)
                            {
                                $where = 'gp_login_table.user_id=gp_pl_channel_partner.id';
                                $result = select_all_by_id('gp_login_table',$id,'gp_pl_channel_partner',$where);
                                $club_member = $result->club_mem_id;
                                $club_type = $result->club_type;
                                if($club_type=='FIXED'){
                                    $sql2 = "SELECT * FROM `gp_login_table` where type='channel_partner' and parent_login_id='$club_member' ORDER BY `id`  DESC";
                                    $sqll2 = $this->db->query($sql2);
                                    if($sqll2->num_rows()>0)
                                    {
                                        $cp_count = $sqll2->num_rows();
                                    }else{
                                      $cp_count = 0;
                                    }
                                  $qry2 = "SELECT nc.name,nc.id as user_id,nc.fixed_club_type_id,lt.id as login_id,mt.title as plan,mt.cp_status,mt.cp_limit,mt.reward_per_cp FROM `gp_normal_customer` nc 
                                  left join gp_login_table lt ON lt.user_id = nc.id  
                                  left JOIN club_member_type mt ON nc.fixed_club_type_id=mt.id 
                                  WHERE lt.id='$club_member' AND  lt.type='club_member'";
                                  $query2 = $this->db->query($qry2);
                                  if($query2->num_rows()>0)
                                  {
                                      $details =  $query2->row_array();
                                      $cp_limit = $details['cp_limit']; 
                                      $reward_per_cp = $details['reward_per_cp'];
                                      if($cp_limit>$cp_count)
                                      {
                                        $this->db->set('total_value', 'total_value + ' . (float) $reward_per_cp, FALSE);
                                        $this->db->where('user_id', $club_member);
                                        $this->db->where('wallet_type_id', 2);
                                        $this->db->update('gp_wallet_values');
                                        
                                        $wal_activity = array(
                                            'wallet_type_id' => 1,
                                            'user_id' => $club_member,
                                            'change_value' => $reward_per_cp,
                                            'date_modified' => date('Y-m-d h:i:s'),
                                            'description' => 'Reward when a new channel partner added'
                                            );
                                        $this->db->insert('gp_wallet_activity', $wal_activity);
                                      }
                                  }
                                }
                               // var_dump($result);exit;
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
                    //}else{
                      //  exit(json_encode(array('status'=>false, 'reason'=>'Password already exist')));
                   // }
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
    function cp_signup($otp,$id)
    {
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_ca_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $id = $id;
        $data['details'] = $this->Channelpartner_model->get_cp_details($id);
        //var_dump($data['details']);exit();
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        
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
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
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
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
     
        $data['products'] = $this->product_model->get_deal_details_by_id($id);
        $data['subcptype']=$this->product_model->get_subcptype();
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
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $type = "p.`type` = '0'";
        $data['products'] = $this->product_model->get_product_details_by_id($id,$type);
        $data['subcptype']=$this->product_model->get_subcptype();
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $this->load->view("public/edit_show_product_details",$data);
    }

    function module_single($id)
    {
        //var_dump($id);exit;
        $datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
           
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();    
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['vallet_type'] = $this->product_model->get_wallet();  
        }
        //      $data['category']=$this->product_model->get_cpcategory_module_wise($id);
        //       $data['subcategory']=$this->product_model->get_cpscategory_module_wise($id);
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['products'] = $this->product_model->get_Product();
        $data['deals'] = $this->product_model->get_deal_product_module_wise($id);
        $data['submenu'] = $this->product_model->get_submenu();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['product'] = $this->product_model->get_product_view_module_wise($id);


      //  echo json_encode($data['deal']);exit;
        // $data['prod'] = $this->product_model->get_product_view();
        $data['left_adv'] = $this->user_model->get_ads();
        $data['centre_adv'] = $this->user_model->get_ads_center();
        $data['right_adv'] = $this->user_model->get_ads_right();
        // $data['user']=$this->user_model->get_normal_customer($userid);

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/edit_show_individual_module_details",$data);
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
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();

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
                $res = round_number($result['total_value']);
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
        //print_r($data['details']);
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        
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
        }
        if($login_id){
            $data['category']=$this->Cp_model->get_cpcategory();
            $data['subcategory']=$this->Cp_model->get_cpscategory();
            $data['countries'] = $this->Cp_model->get_countries();
            $data['modules'] = $this->Cp_model->get_modules();
            $data['subcptype']=$this->product_model->get_subcptype();
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
           // echo json_encode($data['wallet']);exit(); 
            //$data['refer'] = $this->refer_model->get_refer($login_id);
            //$data['child'] = $this->refer_model->get_child($login_id);
            $data['countries'] = $this->Cp_model->get_countries();

            $data['vallet_type'] = $this->product_model->get_wallet();
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
            $this->form_validation->set_rules("phone", "Mobile", "numeric|trim|required|htmlspecialchars");
            //$this->form_validation->set_rules("phone2", "Mobile2", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email ", "trim|required|htmlspecialchars");

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
         //$categories=$this->input->post('categories');
        if(empty($category)){
            $result = $this->product_model->get_all_categories_from_parent($cat_id);
          
            if(empty($result)){
            $cat_where = "dt.sub_cp_type_id = '$cat_id' and ";
            }else{
                $cat_where = "dt.sub_cp_type_id IN ('$result') or dt.sub_cp_type_id='$cat_id' and ";            
            }
         }
         else{
              $result = implode("','",$category);
              $cat_where = "dt.sub_cp_type_id IN ('$result') and ";
         }
         //if($brand_query == "")
         // { 
          //  $category_query = "and $cat_where";
         // }else{
          //  $category_query = "or $cat_where";
         // }
         
        $where = $brand_query.''.$cat_where;
      //var_dump($where);exit();
        $config = array();
          if($this->uri->segment(5) == ''){
                $config["base_url"] = base_url() . 'home/get_all_products_cat_wise/$cat_id/page/';
            }else{
                $config["base_url"] = base_url() . 'home/get_all_products_cat_wise/$cat_id/page/';
            }
          $sort_order = $this->input->post('sort_order');  
          $config["total_rows"] = $this->product_model->getAllProductCount($where);
          
          $config["per_page"] = 5;
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
          $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
          $data['page'] = $page;

          $data["data"] = $this->product_model->getAllProduct($where, $config["per_page"],$page,$sort_order);
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
        
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_list_products_catwise",$data);
    }
    function get_all_products()
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

             $brand_query ="and dt.brand_id IN ('$brands')";         
         }
        
       
       
          if($category == "")  
          {
           $category_query = "";
          }
          
          else{
               $categories = implode("','",$category);
              if($brand_query == "")
               { 
                  $category_query = "and dt.sub_cp_type_id IN ('$categories')";
               }
               else{
                  $category_query = "or dt.sub_cp_type_id IN ('$categories')";
               }
            }
        $where = $brand_query.$category_query;
       // var_dump($where);exit();
        $config = array();
          if($this->uri->segment(5) == ''){
                $config["base_url"] = base_url() . 'home/get_all_products/page/';
            }else{
                $config["base_url"] = base_url() . 'home/get_all_products/page/';
            }
          $sort_order = $this->input->post('sort_order');  
          $config["total_rows"] = $this->product_model->getAllProductCount($where);
          
          $config["per_page"] = 5;
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

          $data["data"] = $this->product_model->getAllProduct($where, $config["per_page"],$page,$sort_order);
          // echo json_encode($data["data"]);exit;
            if($this->input->post('ajax') == true)
            { exit(json_encode(array(
                'data' => $data["data"],
                'status' => $data["data"]["status"],
                'pagination' => $this->pagination->create_links()
            )));
            }

        //echo json_encode( $data);exit;
        
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
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

             $brand_query ="and dt.brand_id IN ('$brands')";         
         }
        
       
       
          if($category == "")  
          {
           $category_query = "";
          }
          
          else{
               $categories = implode("','",$category);
              if($brand_query == "")
               { 
                  $category_query = "and dt.sub_cp_type_id IN ('$categories')";
               }
               else{
                  $category_query = "or dt.sub_cp_type_id IN ('$categories')";
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
          
          $config["per_page"] = 5;
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
        
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_list_deals",$data);
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

        $config["per_page"] = 8;

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
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
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

        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
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
                                $username = "pranavpk.pk1@gmail.com";
                                $hash = "4ec424c177ff9fdebcb835599d38a546ff2238cd";
                                $datas['mobile'] = $mobile;
                                $test = "0";
                                $sender = "TXTLCL"; // This is who the message appears to be from.
                                $numbers = $mobile; // A single number or a comma-seperated list of numbers
                                $message = "Hi, Welcome to Jaazzo.If you are interested with Jaazzo.Please continue with signup: http://jaazzo.cybase.in/jaazzo/ca_signup/".encrypt_decrypt('encrypt',$otp).'/'.$result['info']['user_id'];
                                $message = urlencode($message);
                                $data1 = "username=" . $username . "&hash=" . $hash . "&message=" . $message . "&sender=" . $sender . "&numbers=" . $numbers . "&test=" . $test;
                                $ch = curl_init('http://api.textlocal.in/send/?');
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $data1);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $result = curl_exec($ch); // This is the result from the API
                                curl_close($ch);

                                $email = "maneeshakk16@gmail.com";
                                $mail_head = 'Message From Jaazzo';
                                $status = send_custom_email($email, $mail_head, $mail, 'Sign Up - Club Agent', $this->load->view('templates/public/mail/ca_sign_up', $data,TRUE));
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

                $session_array = $this->session->userdata('logged_in_user');
                $log_id = $session_array['id'];
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
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
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
                    $validate_password = $this->Executives_model->validate_password(encrypt_decrypt('encrypt',$this->input->post('password')));
                    if($validate_password['status'] === TRUE)
                    {
                        $cpassword =$this->input->post('cpassword');
                        
                        if($password==$cpassword){
                            $password =encrypt_decrypt('encrypt',$this->input->post('password'));
                            
                            $data_input = array('password'=>$password,'otp_status'=>1,'email'=>$mail);
                            $where = array('id'=>$id);
                            $res = update_tbl('gp_login_table',$data_input,$where);
                            
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
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_ca_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/edit_club_member_signup",$data);
    }
    function aboutus()
    {
        $session_array = $this->session->userdata('logged_in_user');

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/about_us",$data);
    }
    function our_investors()
    {
        $session_array = $this->session->userdata('logged_in_user');

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/our_investors",$data);
    }
    function contact()
    {
        $session_array = $this->session->userdata('logged_in_user');

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/contact",$data);
    }
    function sitemap()
    {
        $session_array = $this->session->userdata('logged_in_user');

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/sitemap",$data);
    }
    function term_condition()
    {
        $session_array = $this->session->userdata('logged_in_user');

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/term_condition",$data);
    }
    function help()
    {
        $session_array = $this->session->userdata('logged_in_user');

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/help",$data);
    }
    function privacy()
    {
        $session_array = $this->session->userdata('logged_in_user');

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/privacy",$data);
    }
    function fare()
    {
        $session_array = $this->session->userdata('logged_in_user');

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/fare",$data);
    }

    function testimonial()
    {
        $session_array = $this->session->userdata('logged_in_user');

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/testimonial",$data);
    }
    function career()
    {
        $session_array = $this->session->userdata('logged_in_user');

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/career",$data);
    }
    function news()
    {
        $session_array = $this->session->userdata('logged_in_user');
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/news",$data);
    }
    function news_more()
    {
        $session_array = $this->session->userdata('logged_in_user');
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

                $s=18;
                $username = "pranavpk.pk1@gmail.com";
                $hash = "4ec424c177ff9fdebcb835599d38a546ff2238cd";
                $datas['mobile'] =  $mobile;
                $test = "0";
                $sender = "TXTLCL"; // This is who the message appears to be from.
                $numbers =  $mobile; // A single number or a comma-seperated list of numbers
                $message = "Hi, Welcome to Jaazzo. If you are interested with Jaazzo. Please continue with signup: http://jaazzo.cybase.in/jaazzo/".encrypt_decrypt('encrypt',$mobile);
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
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
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
}


?>
