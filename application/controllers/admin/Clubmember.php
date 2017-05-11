<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 */
/**
* 
*/
class Clubmember extends CI_Controller
{
	
	function __construct()
	{
		parent:: __construct();
        $this->load->library(array('session','form_validation'));
        $this->load->model(array('admin/Channelpartner_model', 'admin/Dashboard_model', 'register_model', 'admin/clubmember_model'));
        $this->load->helper(array('form','string','my_common_helper'));
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array)){
            redirect('admin/Login');
        }
	}
	
    function set_menu(){
        $loginsession = $this->session->userdata('logged_in_admin');
        //var_dump($loginsession);exit;
        if($loginsession['type'] == 'super_admin'){
             $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        }else if($loginsession['type'] == 'Channel_partner'){
             $data['sidebar'] = $this->load->view('admin/templates/cp_sidebar', '', true);
        }else if($loginsession['type'] == 'executive'){
             $data['sidebar'] = $this->load->view('admin/templates/bch_sidebar', '', true);
        }else if($loginsession['type'] == 'business_associate'){
             $data['sidebar'] = $this->load->view('admin/templates/ba_sidebar', '', true);
        }
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
    
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        return $data;
    }
    function index()
    {
    //	$data=$this->set_menu();
    	 $data['sidebar'] = $this->load->view('admin/templates/bch_sidebar', '', true);
    	 $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
    	 $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['my_wallet_value']=$this->Dashboard_model->get_cpwallet_value();
        $this->load->view('admin/edit_execuitive_dash_board', $data);
    }
	function new_clubmember()
	{
		 $data['sidebar'] = $this->load->view('admin/templates/bch_sidebar', '', true);
    	 $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
    	 $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $this->load->view('admin/edit_add_club_member', $data);
	}
	function create_clubmember()
	{
		//var_dump($this->input->post());exit;
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules("_name","Name","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("email","Email","trim|required|htmlspecialchars|valid_email");
			$this->form_validation->set_rules("phone","Phone Number","numeric|required|htmlspecialchars");
			$this->form_validation->set_rules("phone2","Alternative Number","numeric|required|htmlspecialchars");
			$this->form_validation->set_rules("address","Address","required|htmlspecialchars");
			$this->form_validation->set_rules("pincode","Pincode","trim|htmlspecialchars|required");
			$this->form_validation->set_rules("terms_condition","Terms and Conditions","trim|htmlspecialchars|required");
			if( $this->form_validation->run() == TRUE )
			{
				$mobile = $this->input->post('phone');
				$email = $this->input->post('email');
				$validate_email = $this->register_model->validate_email($email);
				
				if($validate_email['status'] === TRUE)
				{

					$validate_phone = $this->register_model->validate_phone($mobile);
					if($validate_phone['status'] === TRUE)
					{
						
						$results=$this->clubmember_model->club_member_registration();
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
							$mail_from = 'greenindia@gmail.com';
							$mail_to = $email;
							$email_message = $this->load->view('public/edit_email_template_otp', $results,TRUE);

							$aa = send_custom_email($mail_from, $mail_to, 'OTP Verification', $email_message);
							//var_dump($aa);
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
	function confirm_otp()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules("reg_otp","Verification Code","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("otp_mail","Email","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("otp_phone","Phone Number","required|htmlspecialchars");		
			if( $this->form_validation->run() == TRUE )
			{
				$result = $this->clubmember_model->validate_otp_reg();
				if($result['status'] == TRUE)
				{	
				/*	
					$rndum_pass = random_string('alnum', 6);

					$mail = $result['info']['email'];
					$phone = $result['info']['mobile'];
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
							$this->email->to($mail);
							$this->email->reply_to('no-replay@gmail.com', 'OTP Verification');
							$this->email->subject('OTP Verification');
							$this->email->message($rndum_pass);
							$this->email->send();
							*/
					exit(json_encode(array("status"=>TRUE, 'data' => $result['info'])));
				} else{
					exit(json_encode(array("status"=>FALSE,"reason"=>"Invalid OTP")));
				}
			}else{	
				exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
			}				
		}
		else{
			show_error("We are unable to process this request on this way!"); 	
		}
	}
	function get_members()
	{
		$data=$this->set_menu();
        $data['members']=$this->clubmember_model->get_all_members();
        $this->load->view('admin/edit_view_all_child_member', $data);
	}
	function become_clubmember($id)
	{
		$data=$this->set_menu();
        $data['member'] = $this->clubmember_model->get_member_byId($id);
        //var_dump($data['member']);exit;
        $data['club_type'] = $this->clubmember_model->get_club_types();
        $this->load->view('admin/edit_select_clubmember_type', $data);
	}
	function payment()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules("user_id","Club Member","numeric|trim|required|htmlspecialchars");
			$this->form_validation->set_rules("type","Membership Type","trim|required|htmlspecialchars");	
			if( $this->form_validation->run() == TRUE )
			{
				$result = $this->clubmember_model->club_payment();
				if($result == TRUE)
				{	
			
					exit(json_encode(array("status"=>TRUE)));
				} else{
					exit(json_encode(array("status"=>FALSE,"reason"=>"Invalid OTP")));
				}
			}else{	
				exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
			}				
		}
		else{
			show_error("We are unable to process this request on this way!"); 	
		}
	}

	// BA Pooling
	function new_ba_clubmember()
	{
		$data=$this->set_menu();
        //$data['my_wallet_value']=$this->Dashboard_model->get_cpwallet_value();
        
        $this->load->view('admin/business_associate/edit_add_ba_clubmember', $data);
	}
	function create_new_clubmember()
	{
		//var_dump($this->input->post());exit;
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules("_name","Name","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("email","Email","trim|required|htmlspecialchars|valid_email");
			$this->form_validation->set_rules("phone","Phone Number","numeric|required|htmlspecialchars");
			$this->form_validation->set_rules("phone2","Alternative Number","numeric|required|htmlspecialchars");
			$this->form_validation->set_rules("address","Address","required|htmlspecialchars");
			$this->form_validation->set_rules("pincode","Pincode","trim|htmlspecialchars|required");
			$this->form_validation->set_rules("terms_condition","Terms and Conditions","trim|htmlspecialchars|required");
			if( $this->form_validation->run() == TRUE )
			{
				$mobile = $this->input->post('phone');
				$email = $this->input->post('email');
				$validate_email = $this->register_model->validate_email($email);
				
				if($validate_email['status'] === TRUE)
				{

					$validate_phone = $this->register_model->validate_phone($mobile);
					if($validate_phone['status'] === TRUE)
					{
						
						$results=$this->clubmember_model->club_member_registration();
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

							$mail_from = 'greenindia@gmail.com';
							$mail_head = 'Green India';
							$mail_to = $email;
							$subject = 'OTP Verification';
							$email_message = $this->load->view('public/edit_email_template_otp', $results,TRUE);

							send_custom_email($mail_from, $mail_head, $mail_to, $subject, $email_message);
							
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
	function submit_otp()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules("reg_otp","Verification Code","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("otp_mail","Email","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("otp_phone","Phone Number","required|htmlspecialchars");		
			if( $this->form_validation->run() == TRUE )
			{
				$result = $this->clubmember_model->validate_otp_reg();
				if($result['status'] == TRUE)
				{	
				/*	
					$rndum_pass = random_string('alnum', 6);

					$mail = $result['info']['email'];
					$phone = $result['info']['mobile'];
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
							$this->email->to($mail);
							$this->email->reply_to('no-replay@gmail.com', 'OTP Verification');
							$this->email->subject('OTP Verification');
							$this->email->message($rndum_pass);
							$this->email->send();
							*/
					exit(json_encode(array("status"=>TRUE, 'data' => $result['info'])));
				} else{
					exit(json_encode(array("status"=>FALSE,"reason"=>"Invalid OTP")));
				}
			}else{	
				exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
			}				
		}
		else{
			show_error("We are unable to process this request on this way!"); 	
		}
	}
	function become_ba_clubmember($id)
	{
		$data=$this->set_menu();
        $data['member'] = $this->clubmember_model->get_member_byId($id);
        //var_dump($data['member']);exit;
        $data['club_type'] = $this->clubmember_model->get_club_types();
        $this->load->view('admin/edit_select_clubmember_type', $data);
	}
	function ba_payment()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules("user_id","Club Member","numeric|trim|required|htmlspecialchars");
			$this->form_validation->set_rules("type","Membership Type","trim|required|htmlspecialchars");	
			if( $this->form_validation->run() == TRUE )
			{
				$result = $this->clubmember_model->club_ba_payment();
				if($result == TRUE)
				{	
			
					exit(json_encode(array("status"=>TRUE)));
				} else{
					exit(json_encode(array("status"=>FALSE,"reason"=>"Invalid OTP")));
				}
			}else{	
				exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
			}				
		}
		else{
			show_error("We are unable to process this request on this way!"); 	
		}
	}

}

?>