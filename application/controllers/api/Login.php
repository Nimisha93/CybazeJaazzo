<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Login extends CI_controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model(array('api/login_model','api/cm_model'));
        $this->load->helper(array('string','date','form'));
        header("Access-Control-Request-Headers:*");
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: content-type, origin, accept, Authorization-key");
        header('Cache-control: no-cache');
        header("Connection: Keep-alive");
        // Load facebook library
        $this->load->library('facebook');
        require_once APPPATH.'third_party/src/Google_Client.php';
        require_once APPPATH.'third_party/src/contrib/Google_Oauth2Service.php';
    }
    //normal customer registration
    function signup()
    {
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|numeric|max_length[10]|trim|htmlspecialchars');
        $this->form_validation->set_rules('name', 'Name', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('password', 'Password', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('fcm_token', 'FCM ID', 'trim|htmlspecialchars');
        $this->form_validation->set_rules('email', 'Email ID', 'trim|htmlspecialchars');

        if($this->form_validation->run() === true )
        {
            $mobile = $this->input->post('mobile');
            $email = $this->input->post('email');
            $mob = $this->login_model->check_mobile_exist($mobile);
            if($mob){
                if($mob['type']=='normal_customer'){
                    $logid = $mob['id'];
                    $mem_status = $this->login_model->get_member_status($logid,$mob['type']);
                    if($mem_status['status']=='notapproved'){
                        $result=$this->login_model->sign_up();
                        if($result['status'] == true){
                            $otp = $result['info']['otp'];
                            $message = $otp." is the OTP for mobile number verification. Please enter it in the space provided in the website. Thank you for using Jaazzo. ";
                            send_message($mobile,$message);
                            echo json_encode(array("error"=>false, 'message' => "Successfully registered.Verify your OTP"));
                        }else{
                            echo json_encode(array("error"=>true, 'message' => "SignUp Faild"));
                        }
                    }else{
                        goto a;
                    }
                }else{
                    a:$typs = array('normal_customer','ba','club_agent','Channel_partner','club_member','executive');
                    if (!in_array($mob['type'], $typs)) {
                        $res = $this->login_model->check_exist_email($email);
                        if($res)
                        {
                            $result=$this->login_model->sign_up();
                            if($result['status'] == true){
                                $otp = $result['info']['otp'];
                                $message = $otp." is the OTP for mobile number verification. Please enter it in the space provided in the website. Thank you for using Jaazzo. ";
                                send_message($mobile,$message);

                                echo json_encode(array("error"=>false, 'message' => "Successfully registered.Verify your OTP"));
                            }else{
                                echo json_encode(array("error"=>true, 'message' => "SignUp Faild"));
                            }
                        }else{
                            echo json_encode(array("error"=>true, 'message' => "Mail Id already exists"));
                        }
                    }else{
                        echo json_encode(array("error"=>true, 'message' => "Mobile Number Already Exists"));
                    } 
                }
            }else{
                echo json_encode(array("error"=>true, 'message' => "Mobile Number Already Exists"));
            }
        }else{
            echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
        } 
    }
    
    //verify the otp
    function verify_otp()
    {
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|numeric|max_length[10]|trim|htmlspecialchars');
        $this->form_validation->set_rules('otp', 'OTP', 'required|numeric|max_length[5]|trim|htmlspecialchars');
       
        if( $this->form_validation->run() === true )
        {
            $mobile = $this->input->post('mobile');
            $otp_code = $this->input->post('otp');    
            $result = $this->login_model->verify_otp();

            if($result['status'] == false){
                echo json_encode(array("error"=>true, 'message' => $result['reason']));
            }else{
                echo json_encode(array("error"=>false, 'data' => $result['info'], 'message' => "Succcessfully upgraded your package"));
            }   
        }else{
           echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
        }  
    }

    //otp request when a signup incomplete
    function request_otp()
    {
        $this->form_validation->set_rules('mobile', 'Mobile', 'required|numeric|max_length[10]|trim|htmlspecialchars');
         
        if( $this->form_validation->run() === true )
        {
            $mobile = $this->input->post('mobile');
            // $mobile = "9961464275";
            $result = $this->login_model->resend_otp($mobile);
            if($result['status']){
                $otp = $result['data'];
                $message = $otp." is the OTP for mobile number verification. Please enter it in the space provided in the website. Thank you for using Jaazzo. ";
                send_message($mobile,$message);

                echo json_encode(array("error"=>false, 'message' => "OTP requested"));
            }else{
                echo json_encode(array("error"=>true, 'message' => $result['reason']));
            }   
        }else{
            echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
        }
    }

    //login process - customer,club member,club agent,executive,executive team lead
   function login_process()
    {  
        $this->form_validation->set_rules('fcm_id', 'FCM ID', 'trim|htmlspecialchars');
        $required_email = $this->input->post('mobile') ? '' : '|required' ;
        $required_mobile = $this->input->post('email') ? '' : '|required' ;
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim'. $required_mobile .'|htmlspecialchars');
        $this->form_validation->set_rules('email', 'Email', 'trim'. $required_email .'|htmlspecialchars');     
        if( $this->form_validation->run() === true )
        {
            $result = $this->login_model->login_process();
            // var_dump( $result);exit;
            if($result){
                echo json_encode(array("error"=>false,'message' => "Loggedin", 'data' =>$result));
            }else{  
                echo json_encode(array("error"=>true, 'message' => "Invalid Username or Password"));
            }   
        }else{
            echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
        }  
    }


    //wallet details
    function wallet_details(){
        $api_key = get_api_key();
        if($api_key){
            $udetails = user_details_by_apikey($api_key);
            $login_id = $udetails['id'];
            $user_id = $udetails['user_id'];
            if($login_id){
                $res = $this->cm_model->get_my_wallet($login_id,$user_id);
                if(!empty($res)){
                    echo json_encode(array("error"=>false,"data"=>$res,'message' => 'Loggedin'));
                }else{
                    echo json_encode(array("error"=>true, 'message' => 'Something went wrong'));
                } 
            }else{
                echo json_encode(array("error"=>true, 'message' => 'Invalid Api key'));
            }
        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }

    //Get user details
    function get_user_details(){
        // $api_key = get_api_key();
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|numeric|trim|htmlspecialchars');
            $mobile = $this->input->post('mobile');

            if($this->form_validation->run() === TRUE) {

                $udetails = user_details_by_mobile($mobile);
                $api_key = $udetails['api_key'];
                $login_id = $udetails['id'];
                if($login_id){
                    $type = $udetails['type'];
                    $res = $this->cm_model->get_user_details($api_key,$type);
                    if($res){
                        echo json_encode(array("error"=>false,"data"=>$res,'message' => 'User found'));
                    }else{
                        echo json_encode(array("error"=>true, 'message' => 'Something went wrong'));
                    } 
                }else{
                    echo json_encode(array("error"=>true, 'message' => 'Invalid Api key'));
                }
            }else{
                echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
            }
    }

    //Add Club Agent
    function add_club_agent(){
        $api_key = get_api_key();
        if($api_key){
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|htmlspecialchars');
            $this->form_validation->set_rules('name', 'Name', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|numeric|trim|htmlspecialchars');

            
                $udetails = user_details_by_apikey($api_key);
                $login_id = $udetails['id'];
                $user_id = $udetails['user_id']; 
                $type = $udetails['type']; 
                if($login_id){
                    if($type==='executive'){
                        $this->form_validation->set_rules('club_member_id', 'Club Member', 'required|numeric|trim|htmlspecialchars');
                    }
                    if($this->form_validation->run() === TRUE) {
                        $mail = $this->input->post('email');
                        $validate_email = $this->login_model->check_ca_exist_email($mail);
                        if($validate_email === TRUE)
                        {
                            $mobile = $this->input->post('mobile');
                            $name = $this->input->post('name');
                            $club_member_id = $this->input->post('club_member_id');
                            $club_member_id = isset($club_member_id)?$club_member_id:$login_id;
                            $validate_phone = $this->login_model->check_ca_mobile_exist($mobile);
                            if($validate_phone['status'] === TRUE)
                            {
                                /*$files = $_FILES;
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
                            }else{*/
                                $data=array('mobile' => $mobile,
                                    'name' => $name,
                                    'email' => $mail,
                                    'register_via'=>$type,
                                    'club_member_id'=>$club_member_id
                                    );
                            // }
                                    $result = $this->cm_model->add_club_agent($data,$login_id);
                                    if($result)
                                    {
                                        $data['id'] = $result['info']['user_id'];
                                        $data['otp'] = $result['info']['otp'];
                                        $otp=$data['otp'];
                                        $url = base_url().'ca_signup/'.encrypt_decrypt('encrypt',$otp).'/'.$result['info']['user_id'];
                                        $message = "Hi, Welcome to Jaazzo.If you are interested with Jaazzo.Please continue with signup:".$url;
                                        $status = send_message($mobile,$message);

                                        if(!empty($mail)){
                                            $email = "maneeshakk16@gmail.com";
                                            $mail_head = 'Message From Jaazzo';
                                            $status = send_custom_email($email, $mail_head, $mail, 'Sign Up - Club Agent', $this->load->view('templates/public/mail/ca_sign_up', $data,TRUE));
                                        }
                                        if($status)
                                        {
                                            exit(json_encode(array('error'=>false)));
                                        }else{
                                            exit(json_encode(array("error"=>false)));
                                        }
                                    }else{
                                        exit(json_encode(array('error'=>true, 'message'=>'Database Error')));
                                    }

                                
                            }else{
                                exit(json_encode(array('error'=>true, 'message'=>'Mobile already exist')));
                            }
                        }else{
                            exit(json_encode(array('error'=>true, 'message'=>'Email already exist')));
                        }
                    }else{
                        echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
                    }
                }else{
                    echo json_encode(array("error"=>true, 'message' => 'Invalid Api key'));
                }
        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }

    //Add Club Member
    function add_club_member(){
        $api_key = get_api_key();
        if($api_key){
            $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|htmlspecialchars');
            $this->form_validation->set_rules('name', 'Name', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|numeric|trim|htmlspecialchars');
            $this->form_validation->set_rules('package', 'Package', 'required|trim|htmlspecialchars');


            if($this->form_validation->run() === TRUE) {

                $udetails = user_details_by_apikey($api_key);
                $login_id = $udetails['id'];
                $user_id = $udetails['user_id']; 
                $type = $udetails['type']; 
                if($login_id){
                    $mail = $this->input->post('email');
                    $validate_email = $this->login_model->check_cm_exist_email($mail);
                    if($validate_email === TRUE)
                    {
                        $mobile = $this->input->post('mobile');
                        $name = $this->input->post('name');
                        $validate_phone = $this->login_model->check_cm_mobile_exist($mobile);
                        $validate_phone_result = $validate_phone['result'];
                        if($validate_phone['status'] === TRUE)
                        {
                            $data=array('mobile' => $mobile,
                                'name' => $name,
                                'email' => $mail,
                                'package'=>$this->input->post('package'),
                                'id'=>$validate_phone_result['id']
                                );
                                $result = $this->cm_model->add_club_member($data,$login_id);
                                if($result)
                                {
                                   exit(json_encode(array('error'=>false, 'message'=>'Successfully added')));
                                }else{
                                    exit(json_encode(array('error'=>true, 'message'=>'Database Error')));
                                }

                        }else{
                            exit(json_encode(array('error'=>true, 'message'=>'Not a normal member')));
                        }
                    }else{
                        exit(json_encode(array('error'=>true, 'message'=>'Email already exist')));
                    }
                }else{
                    echo json_encode(array("error"=>true, 'message' => 'Invalid Api key'));
                }
            }else{
                echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));  
            }
        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }

    //social login
    function social_login()
    {
        $this->form_validation->set_rules('unique_id', 'Unique Id', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('fcm_token', 'Token', 'required|trim|htmlspecialchars'); 
        $this->form_validation->set_rules('email', 'Email', 'required|trim|htmlspecialchars'); 
        $this->form_validation->set_rules('name', 'Name', 'required|trim|htmlspecialchars'); 
        $this->form_validation->set_rules('oauth_provider', 'Type', 'required|trim|htmlspecialchars'); 

        if ($this->form_validation->run() === TRUE) {
            $social_key=$this->input->post('unique_id');
            $fcm_token=$this->input->post('fcm_token');
            $name=$this->input->post('name');
            $email=$this->input->post('email');
            $oauth_provider = $this->input->post('oauth_provider');
            $validate_social_key=$this->login_model->validate_social_key($social_key);
            $res = $this->login_model->validate_email($email);
            if(isset($social_key))
            {
                if($validate_social_key['status']==true)
                {
                    if($res['status']==true)
                    {
                        //var_dump('hh');exit;
                        $insert_data=array('name'=>$name,'email'=>$email,'oauth_uid'=>$social_key,'oauth_provider'=>$oauth_provider);
                        $result=$this->login_model->social_signup($insert_data);
                        if($result)
                        {

                            $data=$this->login_model->get_data_by_mem_id($result);
                            echo json_encode(array("error"=>false, 'message' => "Loggedin",'data'=>$data));
                        }else{
                            echo json_encode(array("error"=>true, 'message' => "server error"));
                        }

                    }else{
                        if($res['status']==false)
                        {
                            $log_id=$res['id'];
                        }
                        $insert_data=array('oauth_uid'=>$social_key,'oauth_provider'=>$oauth_provider,'id'=>$log_id);
                        $result=$this->login_model->update_social_signup($insert_data);
                        $data=$this->login_model->get_data_by_mem_id($res['id']);
                        echo json_encode(array("error"=>false, 'message' => "Loggedin",'data'=>$data));

                    }
                }else{
                    $data=$this->login_model->get_data_by_social_key($social_key);
                    echo json_encode(array("error"=>false, 'message' => "Loggedin",'data'=>$data));
                }
            }
        }else{
            echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
        }
    }
}
?>