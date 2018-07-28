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
        $this->load->library(array('session','form_validation','pagination'));
        $this->load->model(array('admin/Channelpartner_model', 'admin/Dashboard_model', 'register_model', 'admin/clubmember_model'));
        $this->load->helper(array('form','string','my_common_helper'));
        $session_array1 = $this->session->userdata('logged_in_admin');
        $session_array2 = $this->session->userdata('logged_in_exec');

        if(!isset($session_array1)){// and !isset($session_array2)){
            redirect('admin/Login');
        }
	}
	public function load_paging($base_url,$count,$per_page)
    {
        $config = array();
        $config["base_url"] = $base_url;
        $config["total_rows"] =  $count;
        $config["per_page"] = $per_page;
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
    }
    function set_menu(){
        $loginsession = $this->session->userdata('logged_in_admin');
        if($loginsession['type'] == 'super_admin'){
             $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        }else if($loginsession['type'] == 'Channel_partner'){
             $data['sidebar'] = $this->load->view('admin/templates/cp_sidebar', '', true);
        }else if($loginsession['type'] == 'executive'){
             $data['sidebar'] = $this->load->view('admin/templates/bch_sidebar', '', true);
        }else if($loginsession['type'] == 'business_associate'){
             $data['sidebar'] = $this->load->view('admin/templates/ba_sidebar', '', true);
        }
        else{
        	$data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
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
		}else{
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

    function add_club_member()
    {

    	if (has_priv('manage_cm_type')) {
		    $data=$this->set_menu();
		    $this->load->view('admin/edit_club_membership',$data);
    	}
    }

    function add_club_member_type()
    {
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("clubname", "Club Name ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("ussage_limit", "No of Years", "trim|required|htmlspecialchars");
            
            //$this->form_validation->set_rules("amount", "Amount", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("type", "Type", "trim|required");
            // $this->form_validation->set_rules("bde_benfit", "BDE Benefit", "trim|required");
            // $this->form_validation->set_rules("tl_benfit", "TL Benefit", "trim|required");
            $this->form_validation->set_rules("description", "Description ", "trim|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $result=$this->clubmember_model->add_club_type();
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }else  {
                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }else {
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }else{
			show_error("We are unable to process this request on this way!"); 	
		}
    }
    function edit_club_type($id){
    	$data=$this->set_menu();
        $data['details'] =getClubtypeById($id);
        // var_dump($data['details']);exit;
        $this->load->view('admin/edit_update_clubmember_type', $data);
    }
    function update_club_member_type()
    {
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("clubname", "Club Name ", "trim|required|htmlspecialchars");

            $this->form_validation->set_rules("ussage_limit", "No of Years", "trim|required|htmlspecialchars");
            // $this->form_validation->set_rules("amount", "Amount", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("type", "Type", "trim|required");
            $this->form_validation->set_rules("description", "Description ", "trim|htmlspecialchars");
            // $this->form_validation->set_rules("bde_benfit", "BDE Benefit", "trim|required");
            // $this->form_validation->set_rules("tl_benfit", "TL Benefit", "trim|required");
            if($this->form_validation->run()== TRUE){
                $result=$this->clubmember_model->update_club_type();
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }else  {
                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }else {
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }else{
			show_error("We are unable to process this request on this way!"); 	
		}
    }
    //delete club type
    function delete_club_type()
    {
    	if($this->input->is_ajax_request())
        {
            $qry = $this->clubmember_model->delete_club_type($this->input->post());
            if($qry)
            {
                exit(json_encode(array('status'=>TRUE)));
            }else{
                exit(json_encode(array('status'=>FALSE, 'reason'=>'Please try again later..!')));
            }
        }else{
            show_error("Unable to process the request in this way");
        }
    }
    // view all club members
    function  get_all_club_members()
    {

    	if (has_priv('view_club_member')) { 
                                        
	        $data=$this->set_menu();
	        // $data['club_members']= $this->clubmember_model->get_all_club_members();
	        $data['club_types'] = $this->clubmember_model->get_all_club_types();
        	if ($this->input->post('search')) {
        		$param = $this->input->post('search');
        	}else{
        		$param = '';
        	}
        	if ($this->input->post('type')) {
        		$type = $this->input->post('type');
        	}else{
        		$type = '';
        	}
            $result_count = $this->clubmember_model->get_all_club_members_count($param,$type);
            $base_url = base_url() . "all_club_members/";
            $count =  $result_count;
            $per_page = 10;
            $this->load_paging($base_url,$count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data['page'] = $page;

            $data["data"] = $this->clubmember_model->get_all_club_members($param,$type,$per_page, $page);
            
            if ($this->input->post('ajax', FALSE)) {

                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'status' => 1,                    
                    'type'=>$type,
                    'pagination' => $this->pagination->create_links()
                )));
            }
        	$this->load->view('admin/edit_view_all_club_members',$data);
    	}
    }
    // club member pooling  commision settings
    function  club_member_pooling()
    {
        $data=$this->set_menu();
        $this->load->view('edit_club_member_pooling',$data);
    }
    // get all club member types
    function get_all_club_types()
    {
    	if (has_priv('manage_cm_type')) {
	        $data=$this->set_menu();
	        $data['club_types']=$this->clubmember_model->get_all_club_types();
	        $this->load->view('admin/edit_view_all_club_types',$data   );
    	}
    }
    function get_all_clubtypes()
    {
    	if (has_priv('manage_cm_type')) {
    		$data=$this->set_menu();
	    	if ($this->input->post('search')) {
	    		$param = $this->input->post('search');
	    	}else{
	    		$param = '';
	    	}
	        $result_count = $this->clubmember_model->get_all_club_types_count($param);
	        $base_url = base_url() . "all_clubs/";
	        $count =  $result_count;
	        $per_page = 10;
	        $this->load_paging($base_url,$count,$per_page);
	        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
	        $data['page'] = $page;

	        $data["data"] = $this->clubmember_model->get_all_clubtypes($param,$per_page, $page);
	        if ($this->input->post('ajax', FALSE)) {
	            exit(json_encode(array(
	                'data' => $data["data"],
	                'search'=>$param,
	                'status' => 1,
	                'pagination' => $this->pagination->create_links()
	            )));
	        }
	        // $data=$this->set_menu();
	        // $data['club_types']=$this->clubmember_model->get_all_club_types();
	        $this->load->view('admin/edit_all_clubtypes',$data);
    	}
    }
    //New
    function new_club_member()
	{
		if (has_priv('add_clubmember'))
        {
			if($this->input->is_ajax_request())
			{
				$this->form_validation->set_rules("type","Membership Type","trim|required|htmlspecialchars");
				$this->form_validation->set_rules("name","Name","trim|required|htmlspecialchars");
				$this->form_validation->set_rules("email","Email","trim|required|htmlspecialchars|valid_email");
				$this->form_validation->set_rules("mobile","Phone Number","numeric|required|htmlspecialchars");
				if( $this->form_validation->run() == TRUE )
				{
					$mobile = $this->input->post('mobile');
					$email = $this->input->post('email');
					$validate_club_member = $this->clubmember_model->validate_club_member($email,$mobile);
					
					if($validate_club_member['status'] === TRUE)
					{
						$validate_normal_customer = $this->clubmember_model->validate_normal_customer($email,$mobile);
						if($validate_normal_customer['status'] === TRUE)
						{
							$res = $validate_normal_customer['result'];
							$results=$this->clubmember_model->club_registration($res);
							
							if($results['status'] === TRUE){
								$this->session->unset_userdata('logged_in_user'); 
							
	                            $number = $mobile; // A single number or a comma-seperated list of numbers
	                            $message = 'Hi,Welcome to Jaazzo.You are successfully upgraded to Club Member';
	                            
                                send_message($number,$message);
								  
	                            $email_message = $this->load->view('templates/public/mail/club_member_success','',TRUE);                                   
							    $from = "maneeshakk16@gmail.com";
	                            $mail_head = 'Message From Jaazzo';
	                            $status = send_custom_email($from, $mail_head, $email, 'Club Membership', $email_message);
	                            $status=1;
	                            if($status)
	                            {
	                               exit(json_encode(array('status'=>true, 'data' =>'')));
	                            }else{
	                               exit(json_encode(array("status"=>TRUE, 'data' =>'')));
	                            }
							}else{
								exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
							}
						}else{
							exit(json_encode(array("status"=>FALSE,"reason"=>$validate_normal_customer['reason'])));
						}
					}else{
						exit(json_encode(array("status"=>FALSE,"reason"=>$validate_club_member['reason'])));
					}
				}else{	
					exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
				}				
			}else{
				show_error("We are unable to process this request on this way!"); 	
			}
		}
	}
    function get_member_byid($id)
	{
	   $data = $this->set_menu();
       $data['details'] = $this->clubmember_model->get_memberdetails_byid($id);
       // print_r($data['details']);exit;
       $ctype = isset($data['details']['ctype'])?$data['details']['ctype']:'UNLIMITED';
       $fixed_plan = ($data['details']['fixed_club_type_id']>0)?$data['details']['fixed_club_type_id']:0;
       $club_id = $data['details']['club_type_id'];
       $data['club_types'] =get_upgradable_club_plan_bytypes($club_id,$ctype);// get_club_plan_bytypes($ctype);

       $data['fixed_club_types'] = ($fixed_plan>0)?get_upgradable_club_plan_bytypes($fixed_plan,'FIXED'):get_club_plan_bytypes('FIXED');
       
       $this->load->view('admin/edit_clubmember_details', $data);
	}
	function update_club_member()
	{
		if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim');
            $this->form_validation->set_rules("type","Membership Type","trim|required|htmlspecialchars");
			// $this->form_validation->set_rules('club_plan', 'Club Plan', 'required|trim');
            if($this->form_validation->run() == TRUE)
            {
            	$club_plan = $this->input->post('club_plan');
		        $det1 = getClubtypeById($club_plan);
		        $type2 =$this->input->post('club_plan2');
		        $det2 = isset($type2)?getClubtypeById($type2):'';
		      
                $name = $this->input->post('name');
                $id = $this->input->post('id');;
                $mobile = $this->input->post('mobile');
                $club_plan = $this->input->post('club_plan');
                $mode_payment = $this->input->post('payment_mode');
                $ch = $this->input->post('cheque');
                $cheque_no = isset($ch)?$ch:'';
                $ba = $this->input->post('bank');
                $bank = isset($ba)?$ba:'';
                $cdate = $this->input->post('cheque_date');
                $date = isset($cdate)?convert_to_mysql($cdate):'';
      

                $datas=array('phone' => $mobile,
                    'name' => $name,
                    'mode_payment'=>$mode_payment
                    );
                if(!empty($det1)&&$det1['type']=='UNLIMITED'){
		            $datas['club_type_id'] = $club_plan;
		            $datas['fixed_club_type_id']=$type2;
		        }else{
		            $datas['club_type_id'] =$type2;
		            $datas['fixed_club_type_id']=$club_plan;
		        }
		        if(!empty($det2)&&$det2['type']=='UNLIMITED'){
		            $datas['club_type_id'] = $type2;
		            $datas['fixed_club_type_id']=$club_plan;
		        }else{
		            $datas['club_type_id'] = $club_plan;
		            $datas['fixed_club_type_id']=$type2;
		        }
		        if($mode_payment=='cheque'){
		            $datas['cheque_no']=$cheque_no;
		            $datas['bank']=$bank;
		            $datas['cheque_date']=$date;
		        }
		        if($this->input->post('fixed_plan')=='0' && isset($type2))
		        {
		        	$datas['fixed_join_date']=date('Y-m-d h:i:s');
		        }else{
		        	$datas['fixed_join_date']='0000-00-00 00:00:00';
		        }
                $result = $this->clubmember_model->update_club_member($datas,$id);
                
                
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Database Error')));
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
	function delete_club_member()
	{
		if($this->input->is_ajax_request())
        {
            $qry = $this->clubmember_model->delete_club_member($this->input->post());
            if($qry)
            {
                exit(json_encode(array('status'=>TRUE)));
            }else{
                exit(json_encode(array('status'=>FALSE, 'reason'=>'Please try again later..!')));
            }
        }else{
            show_error("Unable to process the request in this way");
        }
	}
	function get_clubplans_by_type()
	{
		if($this->input->is_ajax_request())
        {
            $res = $this->clubmember_model->get_clubplans_by_type($this->input->post());
           
            if($res)
            {
            	$det = '';
            	if(isset($res['res1'])){
            		$det .='<div class="col-md-4">'.ucfirst(strtolower($res['res1']['0']['type'])).'</div><div class="col-md-8 col-sm-12 col-xs-12">';
            		foreach ($res['res1'] as $key => $value) {
	            		$det .='<div class="col-md-4 col-sm-12 col-xs-12">
	                        <input type="radio" name="club_plan" value="'.$value['id'].'"><label style="padding-left: 10px;">'.ucwords($value['title']).'</label>
	                    </div>';
	                }
            		$det .='</div>';
            	}
            	if(isset($res['res2'])){
            	$det .='<div class="col-md-4">'.ucfirst(strtolower($res['res2']['0']['type'])).'</div><div class="col-md-8 col-sm-12 col-xs-12">';
	            	foreach ($res['res2'] as $key => $value) {
	            		$det .='<div class="col-md-4 col-sm-12 col-xs-12">
	                        <input type="radio" name="club_plan2" value="'.$value['id'].'"><label style="padding-left: 10px;">'.ucwords($value['title']).'</label>
	                    </div>';
	            	}
            	$det .='</div>';
	            }
                exit(json_encode(array('status'=>TRUE,'data'=>$det)));
            }else{
                exit(json_encode(array('status'=>FALSE, 'reason'=>'Please try again later..!')));
            }
        }else{
            show_error("Unable to process the request in this way");
        }
	}
	function approve_club_members()
	{

		if (has_priv('approve_cm')) {
		$data=$this->set_menu();
    	if ($this->input->post('search')) {
    		$param = $this->input->post('search');
    	}else{
    		$param = '';
    	}
        $result_count = $this->clubmember_model->get_all_notapproved_clubmembers_count($param);
        $base_url = base_url() . "approve_club_members/";
        $count =  $result_count;
        $per_page = 10;
        $this->load_paging($base_url,$count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;

        $data["data"] = $this->clubmember_model->get_all_notapproved_clubmembers($param,$per_page, $page);
        
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/edit_view_notapproved_clubmembers',$data);
		}
	}
	function approve_club_membership()
	{


		if ($this->input->is_ajax_request()) 
        {
        	$user_id = $this->input->post('user_id');
            $result = $this->clubmember_model->approve_club_member($user_id);


            if($result['status'])
            {
            	$re = $result['det'];
            	$mobile = $re['mobile'];
            	$number = $mobile; // A single number or a comma-seperated list of numbers
            //	var_dump($number);exit;
                
                $message = "Congratulations, Welcome to Jaazzo. You have suceessfully registered as Club member";
                send_message($number,$message);
                exit(json_encode(array("status"=>TRUE)));
            }else{
                exit(json_encode(array('status'=>false, 'reason'=>'Database Error')));
            }
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        } 
	
	}
	function view_normal_users()
	{
		$data=$this->set_menu();
        	if ($this->input->post('search')) {
        		$param = $this->input->post('search');
        	}else{
        		$param = '';
        	}
            $result_count = $this->clubmember_model->get_all_normal_members_count($param);
            $base_url = base_url() . "normal_users/";
            $count =  $result_count;
            $per_page = 10;
            $this->load_paging($base_url,$count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data['page'] = $page;

            $data["data"] = $this->clubmember_model->get_all_normal_members($param,$per_page,$page);
            // echo json_encode($data["data"]);exit();
            if ($this->input->post('ajax', FALSE)) {

                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'status' => 1,
                    'pagination' => $this->pagination->create_links()
                )));
            }
        $this->load->view('admin/edit_view_all_normal_members',$data);
	}
	function investor_club_members()
	{
		if (has_priv('view_tl')) {
			$data=$this->set_menu();
			$data['club_plans'] = $this->clubmember_model->get_investor_plans();
        	if ($this->input->post('search')) {
        		$param = $this->input->post('search');
        	}else{
        		$param = '';
        	}
            $result_count = $this->clubmember_model->get_investor_club_members_count($param);
            $base_url = base_url() . "investor_club_members/";
            $count =  $result_count;
            $per_page = 10;
            $this->load_paging($base_url,$count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data['page'] = $page;

            $data["data"] = $this->clubmember_model->get_investor_club_members($param,$per_page,$page);
            // echo json_encode($data['club_plans']);exit();
            if ($this->input->post('ajax', FALSE)) {

                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'status' => 1,
                    'pagination' => $this->pagination->create_links()
                )));
            }
        	$this->load->view('admin/edit_view_investor_club_members',$data);
        }
	}
	function new_investor_club_member()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules("type","Club Plan","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("name","Name","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("email","Email","trim|required|htmlspecialchars|valid_email");
			$this->form_validation->set_rules("mobile","Phone Number","numeric|required|htmlspecialchars");
			if( $this->form_validation->run() == TRUE )
			{
				$mobile = $this->input->post('mobile');
				$email = $this->input->post('email');
				$validate_club_member = $this->clubmember_model->validate_club_member($email,$mobile);
				
				if($validate_club_member['status'] === TRUE)
				{
					$validate_normal_customer = $this->clubmember_model->validate_normal_customer($email,$mobile);
					if($validate_normal_customer['status'] === TRUE)
					{
						$res = $validate_normal_customer['result'];
						$results=$this->clubmember_model->investor_club_registration($res);
						
						if($results['status'] === TRUE){
							$this->session->unset_userdata('logged_in_user'); 
                            $number = $mobile; // A single number or a comma-seperated list of numbers
                            $message = 'Hi,Welcome to Jaazzo.You are successully upgraded to Team Lead Club Member';
                            send_message($number,$message);
							  
                            $email_message = $this->load->view('templates/public/mail/club_member_success','',TRUE);                                   
						    $from = "maneeshakk16@gmail.com";
                            $mail_head = 'Message From Jaazzo';
                            $status = send_custom_email($from, $mail_head, $email, 'Club Membership', $email_message);
                            if($status)
                            {
                               exit(json_encode(array('status'=>true)));
                            }else{
                               exit(json_encode(array("status"=>TRUE)));
                            }
						}else{
							exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
						}
					}else{
						exit(json_encode(array("status"=>FALSE,"reason"=>$validate_normal_customer['reason'])));
					}
				}else{
					exit(json_encode(array("status"=>FALSE,"reason"=>$validate_club_member['reason'])));
				}
			}else{	
				exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
			}				
		}else{
			show_error("We are unable to process this request on this way!"); 	
		}
	}
	function get_investor_member_byid($id)
	{
	   $data = $this->set_menu();
       $data['details'] = $this->clubmember_model->get_investor_member($id);
       $data['club_plans'] = $this->clubmember_model->get_investor_plans();
       $this->load->view('admin/edit_investor_member_details', $data);
	}
	function update_investor_club_member()
	{
		if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim');
            $this->form_validation->set_rules("type","Club Plan","trim|required|htmlspecialchars");
			// $this->form_validation->set_rules('club_plan', 'Club Plan', 'required|trim');
            if($this->form_validation->run() == TRUE)
            {
            	$name = $this->input->post('name');
                $id = $this->input->post('id');
                $mobile = $this->input->post('mobile');
            	$club_plan = $this->input->post('type');
		        $mode_payment = $this->input->post('payment_mode');
                $ch = $this->input->post('cheque');
                $cheque_no = isset($ch)?$ch:'';
                $ch_dat = $this->input->post('cheque_date');
                $ch_date = isset($ch_dat)?convert_to_mysql($ch_dat):'';
                $ba = $this->input->post('bank');
                $bank = isset($ba)?$ba:'';
               
                $datas=array('phone' => $mobile,
                    'name' => $name,
                    'mode_payment'=>$mode_payment,
		            'investor_type_id'=>$club_plan
		        );
		        if($mode_payment=='cheque'){
		            $datas['cheque_no']=$cheque_no;
		            $datas['cheque_date']=$ch_date;
		            $datas['bank']=$bank;
		        }

                $result = $this->clubmember_model->update_investor_club_member($datas,$id);
                
                
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Database Error')));
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
}

?>