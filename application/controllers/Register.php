<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Register extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
		$this->load->helper(array('form','string'));
		$this->load->model('register_model');
	}
	function new_customer()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules("email","Email","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("phone","Phone Number","required|htmlspecialchars");
			$this->form_validation->set_rules("password","Password","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("confirm_password","Confirm Password","trim|required|htmlspecialchars|matches[password]");
			$this->form_validation->set_rules("accept","Terms and Conditions","trim|htmlspecialchars|required");
			if( $this->form_validation->run() == TRUE )
			{
				$reg_email = $this->input->post('email');
				$validate_email = $this->register_model->validate_email($reg_email);
				
				if($validate_email['status'] === TRUE)
				{
					$reg_phone =  $this->input->post('phone');
					$validate_phone = $this->register_model->validate_phone($reg_phone);
					if($validate_phone['status'] === TRUE)
					{
						$mobile = $this->input->post('phone');
						$email = $this->input->post('email');
						$results=$this->register_model->customer_registration();
						if($results['status'] == TRUE){
							$response = array('phone' => $mobile, 'email' => $email);
							$otp = $results['info']['otp'];
							/*
							// Authorisation details.
							$username = "faisal@cybaze.com";
							$hash = "29b89b2ccf079979f19ad3c6ff401b0cddc999ff";

							// Config variables. Consult http://api.textlocal.in/docs for more info.
							$test = "0";

							// Data for text message. This is the text message data.
							$sender = "GREEN INDIA"; // This is who the message appears to be from.
							$numbers = "$mobile"; // A single number or a comma-seperated list of numbers
							$message = "Please use this OTP for completing your green India registration :$otp";
							// 612 chars or less
							// A single number or a comma-seperated list of numbers
							$message = urlencode($message);
							$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
							$ch = curl_init('http://api.textlocal.in/send/?');
							curl_setopt($ch, CURLOPT_POST, true);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							$result = curl_exec($ch);
							curl_close($ch);
							*/
							$email_message = $this->load->view('public/edit_email_template_otp', $results,TRUE);

							//$ci = get_instance();
							$this->load->library('email');
							$config['protocol'] = "smtp";
							$config['smtp_host'] = "ssl://smtp.gmail.com";
							$config['smtp_port'] = "465";
							$config['smtp_user'] = 'pranavpk.pk1@gmail.com';
							$config['smtp_pass'] = '9544146763';
							$config['charset'] = "utf-8";
							$config['mailtype'] = "html";
							$config['newline'] = "\r\n";

							$this->email->initialize($config);
							$this->email->from('greenindia@gmail.com', 'Green India');
							$this->email->to($email);
							$this->email->reply_to('no-replay@gmail.com', 'OTP Verification');
							$this->email->subject('OTP Verification');
							$this->email->message($email_message);
							$this->email->send();

							exit(json_encode(array("status"=>TRUE, 'data' => $response)));
						}else{
							exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
						}
					}else{
						exit(json_encode(array("status"=>FALSE,"reason"=>$validate_phone['reason'])));
					}
					}else{
						exit(json_encode(array("status"=>FALSE,"reason"=>$validate_email['reason'])));
					}
				}else{	
					exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
				}	}
			else{
				show_error("We are unable to process this request on this way!"); 	
			}
	}
	function validate_otp()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules("reg_otp","Verification Number","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("email","Email","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("mobile","Phone Number","required|htmlspecialchars");
			
			if( $this->form_validation->run() == TRUE )
			{
				$result = $this->register_model->otp_validate();

				if($result['status'] == TRUE)
				{
					 $session_array = array();
				$session_array = array(
                       
                        'id' => $result['info']['id'],
                        'type' => $result['info']['type'],
                        'email' => $result['info']['email'],
                        'mobile' => $result['info']['mobile'],
                        'user_id' => $result['info']['user_id'],
                        'login' =>true);
				$this->session->set_userdata('logged_in_user', $session_array);
					exit(json_encode(array("status"=>TRUE)));
				} else{
					exit(json_encode(array("status"=>FALSE,"reason"=>$result['reason'])));
				}
			}else{	
				exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
			}				
		}
		else{
			show_error("We are unable to process this request on this way!"); 	
		}
	}
	function new_club_member()
	{
		if($this->input->is_ajax_request())
		{
			// $this->form_validation->set_rules("club_plan","Membership Plan","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("cl_reg_name","Name","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("cl_reg_mail","Email","trim|required|htmlspecialchars|valid_email");
			$this->form_validation->set_rules("cl_reg_mobile","Phone Number","numeric|required|htmlspecialchars");
			$this->form_validation->set_rules("cl_reg_pass","Password","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("cl_reg_cpass","Confirm Password","trim|required|htmlspecialchars|matches[cl_reg_pass]");
			$this->form_validation->set_rules("agree","Terms and Conditions","trim|htmlspecialchars|required");
			if( $this->form_validation->run() == TRUE )
			{
				$mobile = $this->input->post('cl_reg_mobile');
				$email = $this->input->post('cl_reg_mail');
				$validate_email = $this->register_model->validate_email($email);
				
				if($validate_email['status'] === TRUE)
				{

					$validate_phone = $this->register_model->validate_phone($mobile);
					if($validate_phone['status'] === TRUE)
					{
						
						$results=$this->register_model->club_registration();
						if($results['status'] == TRUE){
							$response = array('phone' => $mobile, 'email' => $email);
							$otp = $results['info']['otp'];
							/*
							// Authorisation details.
							$username = "faisal@cybaze.com";
							$hash = "29b89b2ccf079979f19ad3c6ff401b0cddc999ff";

							// Config variables. Consult http://api.textlocal.in/docs for more info.
							$test = "0";

							// Data for text message. This is the text message data.
							$sender = "GREEN INDIA"; // This is who the message appears to be from.
							$numbers = "$mobile"; // A single number or a comma-seperated list of numbers
							$message = "Please use this OTP for completing your green India registration :$otp";
							// 612 chars or less
							// A single number or a comma-seperated list of numbers
							$message = urlencode($message);
							$data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
							$ch = curl_init('http://api.textlocal.in/send/?');
							curl_setopt($ch, CURLOPT_POST, true);
							curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
							curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
							$result = curl_exec($ch);
							curl_close($ch);
							
							$email_message = $this->load->view('public/edit_email_template_otp', $results,TRUE);

							
							$this->load->library('email');
							$config['protocol'] = "smtp";
							$config['smtp_host'] = "ssl://smtp.gmail.com";
							$config['smtp_port'] = "465";
							$config['smtp_user'] = 'pranavpk.pk1@gmail.com';
							$config['smtp_pass'] = '9544146763';
							$config['charset'] = "utf-8";
							$config['mailtype'] = "html";
							$config['newline'] = "\r\n";

							$this->email->initialize($config);
							$this->email->from('greenindia@gmail.com', 'Green India');
							$this->email->to($email);
							$this->email->reply_to('no-replay@gmail.com', 'OTP Verification');
							$this->email->subject('OTP Verification');
							$this->email->message($email_message);
							$this->email->send();
							*/
							exit(json_encode(array("status"=>TRUE, 'data' => $response)));
						}else{
							exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
						}
					}else{
						exit(json_encode(array("status"=>FALSE,"reason"=>$validate_phone['reason'])));
					}
					}else{
						exit(json_encode(array("status"=>FALSE,"reason"=>$validate_email['reason'])));
					}
				}else{	
					exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
				}				
			}
			else{
				show_error("We are unable to process this request on this way!"); 	
			}
	}
	function validate_otp_club_reg()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules("otp_reg_confirm","Verification Number","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("otp_reg_email","Email","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("otp_reg_phone","Phone Number","required|htmlspecialchars");
			
			if( $this->form_validation->run() == TRUE )
			{
				$result = $this->register_model->otp_validate_reg();
				if($result['status'] == TRUE)
				{
					 $session_array = array();
				$session_array = array(
                       
                        'id' => $result['info']['id'],
                        'type' => $result['info']['type'],
                        'email' => $result['info']['email'],
                        'mobile' => $result['info']['mobile'],
                        'user_id' => $result['info']['user_id'],
                        'login' =>true);
				$this->session->set_userdata('logged_in_user', $session_array);
					exit(json_encode(array("status"=>TRUE)));
				}
			}else{	
				exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
			}				
		}
		else{
			show_error("We are unable to process this request on this way!"); 	
		}
	}
	function become_clubmember()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules("club_plan","Membership Plan","trim|required|htmlspecialchars");
			
			if( $this->form_validation->run() == TRUE )
			{
				$result = $this->register_model->become_club_member();
				
				exit(json_encode(array("status"=>TRUE)));
			}
			else{	
				exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
			}				
		}
		else{
			show_error("We are unable to process this request on this way!"); 	
		}
	}
	function facebookLogin()
	{
		$userData = $this->input->post('userData');
		if(!empty($userData)){
		    $oauth_provider = $this->input->post('oauth_provider');
		    //Check whether user data already exists in database
		    $prevQuery = "SELECT * FROM gp_login_table WHERE oauth_provider = '".$oauth_provider."' AND oauth_uid = '".$userData->id."'";
		    $prevResult = $this->db->query($prevQuery);

		    if($prevResult->num_rows() > 0){ 
		    	$cur_details = $prevResult->row_array();
		    	$info = array(
		    		'email' => $userData->email,
		    		'updated_on' => date("Y-m-d H:i:s"),
		    		'name' => $userData->first_name,
		    		'profile_image' => $userData->picture->data->url,
		    		'updated_on' => date("Y-m-d H:i:s")
		    		); 
		    	$this->db->where('oauth_provider', $oauth_provider);
		    	$this->db->where('oauth_uid', $userData->id);
		    	$this->db->update('gp_normal_customer', $info);

		    	$details = array(
		    		'email' => $userData->email
		    		);
		    	$this->db->where('oauth_provider', $oauth_provider);
		    	$this->db->where('oauth_uid', $userData->id);
		    	$this->db->update('gp_login_table', $details);


		    	$session_array = array();
				$session_array = array(
                      
                        'id' => $cur_details['id'],
                        'type' => $cur_details['type'],
                        'email' => $cur_details['email'],
                        'mobile' => $cur_details['mobile'],
                        'user_id' => $cur_details['user_id'],
                        'login' =>true);
				$this->session->set_userdata('logged_in_user', $session_array);

		        echo json_encode(array('status'=>TRUE));
		    }else{
		    	$info = array(
		    		'email' => $userData->email,
		    		'created_on' => date("Y-m-d H:i:s"),
		    		'name' => $userData->first_name,
		    		'profile_image' => $userData->picture->data->url,
		    		'oauth_provider' => $oauth_provider,
		    		'oauth_uid' => $userData->id
		    		); 
		    	
		    	$this->db->insert('gp_normal_customer', $info);
		    	$ins_id = $this->db->insert_id();
		       
		       $details = array(
		    		'email' => $userData->email,
		    		'type' => 'normal_customer',
		    		'oauth_provider' => $oauth_provider,
		    		'oauth_uid' => $userData->id,
		    		'user_id' => $ins_id
		    		);
		       $this->db->insert('gp_login_table', $details);
		       $log_id = $this->db->insert_id();

		       $wallete = array(
							array('wallet_type_id' => 2,
									'user_id' => $log_id,
									'total_value' => 0
									),
							array('wallet_type_id' => 4,
									'user_id' => $log_id,
									'total_value' => 0
									)
							);
				
				$qry3 = $this->db->insert_batch('gp_wallet_values', $wallete);

		       	$session_array = array();
				$session_array = array(
                      
                        'id' => $log_id,
                        'type' => 'normal_customer',
                        'email' => $userData->email,
                        'mobile' => '',
                        'user_id' => $ins_id,
                        'login' =>true);
				$this->session->set_userdata('logged_in_user', $session_array);
		        
		        echo json_encode(array('status'=>TRUE));
		        
		    }
		}
	}
	public function googlelogin(){
        // Include the google api php libraries
        include_once APPPATH."libraries/google-api-php-client/Google_Client.php";
        include_once APPPATH."libraries/google-api-php-client/contrib/Google_Oauth2Service.php";
        
        // Google Project API Credentials
        $clientId = 'Insert Google Client ID';
        $clientSecret = 'Insert Google Client secret';
        $redirectUrl = base_url() . 'user_authentication/';
        
        // Google Client Configuration
        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to greenindia.com');
        $gClient->setClientId($clientId);
        $gClient->setClientSecret($clientSecret);
        $gClient->setRedirectUri($redirectUrl);
        $google_oauthV2 = new Google_Oauth2Service($gClient);

        if (isset($_REQUEST['code'])) {
            $gClient->authenticate();
            $this->session->set_userdata('token', $gClient->getAccessToken());
            redirect($redirectUrl);
        }

        $token = $this->session->userdata('token');
        if (!empty($token)) {
            $gClient->setAccessToken($token);
        }

        if ($gClient->getAccessToken()) {
            $userProfile = $google_oauthV2->userinfo->get();
            // Preparing data for database insertion
            $userData['oauth_provider'] = 'google';
            $userData['oauth_uid'] = $userProfile['id'];
            $userData['first_name'] = $userProfile['given_name'];
            $userData['last_name'] = $userProfile['family_name'];
            $userData['email'] = $userProfile['email'];
            $userData['gender'] = $userProfile['gender'];
            $userData['locale'] = $userProfile['locale'];
            $userData['profile_url'] = $userProfile['link'];
            $userData['picture_url'] = $userProfile['picture'];
            // Insert or update user data
            $insertt = $this->register_model->checkGoogleUser($userData);
            if(!empty($insertt)){
                $data['userData'] = $insertt;
                $this->session->set_userdata('logged_in_user',$insertt);
                
            } else {
               $data['userData'] = array();
            }
        } else {
            $data['authUrl'] = $gClient->createAuthUrl();
        }
        return $data;
    }
}
?>