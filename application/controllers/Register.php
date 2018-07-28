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
		$this->load->model(array('register_model','user/product_model','user/refer_model'));
		// Load facebook library
        $this->load->library('facebook');
        //Load user model
        $this->load->model('user');
	}

	/*************************NORMAL CUSTOMER start***********************/
	function new_customer2()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules("email","Email","trim|valid_email|htmlspecialchars");
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
							/*$otp = $results['info']['otp'];

							$username = "pranavpk.pk1@gmail.com";
                            $hash = "4ec424c177ff9fdebcb835599d38a546ff2238cd";
                            $datas['mobile'] = $mobile;
                            $test = "0";
                            $sender = "TXTLCL"; // This is who the message appears to be from.
                            $numbers = $mobile; // A single number or a comma-seperated list of numbers
                            $message = "Hi, Welcome to Jaazzo.Please verify the one time password".$otp;
                            $message = urlencode($message);
                            $data = "username=" . $username . "&hash=" . $hash . "&message=" . $message . "&sender=" . $sender . "&numbers=" . $numbers . "&test=" . $test;
                            $ch = curl_init('http://api.textlocal.in/send/?');
                            curl_setopt($ch, CURLOPT_POST, true);
                            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                            $result = curl_exec($ch); // This is the result from the API
                            curl_close($ch);

							$email_message = $this->load->view('templates/public/mail/member_otp_verification', $results,TRUE);
							$mail_from = "maneeshakk16@gmail.com";
                            $mail_head = 'JAAZZO';
                            $status = send_custom_email($mail_from, $mail_head, $email,'OTP Verification',$email_message);
                            if($status){
								exit(json_encode(array("status"=>TRUE, 'data' => $response)));
							}else{*/
								exit(json_encode(array("status"=>TRUE, 'data' => $response)));
							//}
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
	function new_customer()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules("email","Email","trim|htmlspecialchars");
			$this->form_validation->set_rules("phone","Phone Number","required|htmlspecialchars");
			$this->form_validation->set_rules("password","Password","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("confirm_password","Confirm Password","trim|required|htmlspecialchars|matches[password]");
			$this->form_validation->set_rules("accept","Terms and Conditions","trim|htmlspecialchars|required");
			if( $this->form_validation->run() == TRUE )
			{
				$reg_email = $this->input->post('email');
				$reg_phone =  $this->input->post('phone');
                $validate_email = $this->register_model->chk_validate_email($reg_email);
                if ($validate_email['status'] === TRUE) {
                    if(empty($reg_mobile)){
                      	$validate_mobile['status'] = TRUE;
                    }else{
                     	$validate_mobile = $this->register_model->chk_validate_mobile($reg_phone);
                     }
                      if ($validate_mobile['status'] === TRUE) {
                        $results = $this->register_model->sign_up();
                        if ($results== TRUE) {
                               $data['name'] = $this->input->post('first_name');
                               $data['username'] = $this->input->post('email');
                               $data['password'] = $this->input->post('password');
	                            if(!empty($reg_email)){
	                            	$email_message = $this->load->view('templates/public/mail/member_otp_verification', $results,TRUE);
									$mail_from = "maneeshakk16@gmail.com";
		                            $mail_head = 'JAAZZO';
		                            $status = send_custom_email($mail_from, $mail_head, $reg_email,'OTP Verification',$email_message);
	                            } 
	                            if(!empty($reg_phone)){
								    $otp = $results['info']['otp'];
									$number = $reg_phone; // A single number or a comma-seperated list of numbers
								    $message = $otp." is the OTP for mobile number verification. Please enter it in the space provided in the website. Thank you for using Jaazzo. ";
								    
								    send_message($number,$message);
								}
                            $response = array('phone' => $reg_phone, 'email' => $reg_email); 
                            // if($status){
                            	exit(json_encode(array("status"=>TRUE, 'data' => $response)));
                            // }
                        }else {
                            exit(json_encode(array("status" => FALSE, "reason" => 'Database Error Try Again Later')));
                        }
                      }else{
                        exit(json_encode(array("status" => FALSE, "reason" => "Mobile Already Exists")));
                      }
                }else {
                    exit(json_encode(array("status" => FALSE, "reason" => "Email Already Exists")));
                }
			}else{	
				exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
			}	
		}else{
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
                        'club_type_id'=>$result['info']['club_type_id'],
                        'investor_type_id'=>0,
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
	/*************************NORMAL CUSTOMER end*************************/

 	/****************Change normal customer to club member****************/
    function be_club_member()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules("type","Membership Type","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("club_plan","Membership Plan","trim|required|htmlspecialchars");
			
			$this->form_validation->set_rules("agree","Terms and Conditions","trim|htmlspecialchars|required");
			if( $this->form_validation->run() == TRUE )
			{
				$results=$this->register_model->be_club_member();
				//var_dump($results);exit;
				if($results['status'] == TRUE){
					$mobile = $results['info']['mobile'];
					$ses_status = $this->session->unset_userdata('logged_in_user');
	                if($ses_status){
	    	            $this->session->session_destroy();
	                }
	                $session_array = array();
					$session_array = array(
	                                   'id' => $results['info']['id'],
	                                   'type' => 'club_member',
	                                   'email' => $results['info']['email'],
	                                   'mobile' => $results['info']['mobile'],
	                                   'user_id' => $results['info']['user_id'],
	                                   'club_type_id'=>$this->input->post('club_plan'),
	                                   'fixed_club_type_id'=>$this->input->post('club_plan2'),
	                                   'investor_type_id'=>0,
	                                   'login' =>true);
					$this->session->set_userdata('logged_in_club_member', $session_array);
                    $number = $mobile;
                    $message = "Congratulations, Welcome to Jaazzo. You have suceessfully registered as a Club member";
                    send_message($number,$message);
                    exit(json_encode(array('status'=>true)));
				}else{
					exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
				}
					
			}else{	
				exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
			}				
		}
		else{
			show_error("We are unable to process this request on this way!"); 	
		}
	}
	function get_club_plans_by_type()
    {
    	if($this->input->is_ajax_request())
        {
            $res = $this->register_model->get_clubplans_by_type($this->input->post());
            if($res)
            {
            	$det = '';
            	if(isset($res['res1'])){
            		// $det .='<div>'.ucfirst(strtolower($res['res1']['0']['type'])).'</div>';
            		foreach ($res['res1'] as $key => $value) {
	            		$det .='<li>
	                        <input type="radio" name="club_plan" value="'.$value['id'].'"><a href="#'.strtolower($value['title']).'"><label style="padding-left: 10px;">'.ucwords($value['title']).'</label><span class="slvr">( <span class="rupee">RS</span> '.$value['amount'].')</span></a>
	                    </li><br>';
	                }
            	}
            	if(isset($res['res2'])){
            	// $det .='<div>'.ucfirst(strtolower($res['res2']['0']['type'])).'</div>';
	            	foreach ($res['res2'] as $key => $value) {
	            		$det .='<li>
	                        <input type="radio" name="club_plan2" value="'.$value['id'].'"><label style="padding-left: 10px;">'.ucwords($value['title']).'</label>
	                    </li>';
	            	}
	            }
                exit(json_encode(array('status'=>TRUE,'data'=>$det)));
            	/*$det = '';
            	foreach ($res as $key => $value) {
            		$det .='<li>
                            <input type="radio"  value="'.$value['id'].'" name="club_plan">
                            <label for="f-option">'.ucwords($value['title']).'<span class="slvr">( <span class="rupee">RS</span>'.ucwords($value['amount']).')</span></label>
                            <div class="check">
                                <div class="inside"></div>
                            </div>
                        </li>';
            	}
                exit(json_encode(array('status'=>TRUE,'data'=>$det)));*/
            }else{
                exit(json_encode(array('status'=>FALSE, 'reason'=>'Please try again later..!')));
            }
        }else{
            show_error("Unable to process the request in this way");
        }
    }
    /*********************Upgrade Club member*****************************/
    function upgrade_clubmembership()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules("ctype","Membership Type","trim|required|htmlspecialchars");
			if( $this->form_validation->run() == TRUE )
			{
			    $dats = getLoginId();
		        if($dats){
		            $type2 = $dats['fixed_club_type_id'];
		        }
				$club_plan = $this->input->post('club_plan');
		        $det1 = getClubtypeById($club_plan);
		        //$type2 =$this->input->post('club_plan2');
		        $det2 = isset($type2)?getClubtypeById($type2):'';
		      
                /*if(!empty($det1)&&$det1['type']=='UNLIMITED'){
		            $datas['club_type_id'] = $club_plan;
		            $datas['fixed_club_type_id']=$type2;
		        }else{
		            $datas['club_type_id'] =$type2;
		            $datas['fixed_club_type_id']='0';
		        }
		        if(!empty($det2)&&$det2['type']=='UNLIMITED'){
		            $datas['club_type_id'] = $type2;
		            $datas['fixed_club_type_id']=$club_plan;
		        }else{
		            $datas['club_type_id'] = $club_plan;
		            $datas['fixed_club_type_id']=$type2;
		        }*/
		        $datas['club_type_id'] = $club_plan;
		        $datas['fixed_club_type_id']=$type2;
		        if($type2 && $this->input->post('fixed_plan'))
		        {
            		$datas['fixed_join_date']=date('Y-m-d h:i:s');
		        }else{
		        	$datas['fixed_join_date']='0000-00-00 00:00:00';
		        }
		        $result = $this->register_model->become_club_member($datas);
				$ses_status = $this->session->unset_userdata('logged_in_club_member');
                if($ses_status){
    	            $this->session->session_destroy();
                }
                $session_array = array();
				$session_array = array(
                                   'id' => $result['id'],
                                   'type' => $result['type'],
                                   'email' => $result['email'],
                                   'mobile' => $result['mobile'],
                                   'user_id' => $result['user_id'],
                                   'club_type_id'=>$datas['club_type_id'],
                                   'fixed_club_type_id'=>$datas['fixed_club_type_id'],
                                   'investor_type_id'=>0,
                                   'login' =>true);
				$this->session->set_userdata('logged_in_club_member', $session_array);

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
    /*******************************END***********************************/
    /******************referd friend set their pwd and signup*************/
    function friends_signup($value)
    {
        $mobile = encrypt_decrypt('decrypt',$value);
        $check_valid =$this->refer_model->check_valid_mobile($mobile);
        if($check_valid)
        {
            $data['details'] = $check_valid;
        }
        	$data['get_menu']=$this->product_model->get_menus();
            $data['category']=$this->product_model->get_cpcategory();
            $data['subcategory']=$this->product_model->get_cpscategory();
            $data['subcptype']=$this->product_model->get_subcptype();
            $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
            $data["header"] = $this->load->view("templates/public/public_ca_header",$data,TRUE);
            $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
            $this->load->view("public/edit_member_signup",$data);
    }
    function password_check($str)
    {
        if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
          return TRUE;
        }
       return FALSE;
    }
    function signup_friends()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("email","Email","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("mobile","Mobile No","required|htmlspecialchars");
            $this->form_validation->set_rules("first_name","First Name","trim|required|htmlspecialchars");
            //$this->form_validation->set_rules("last_name","Last Name","trim|required|htmlspecialchars");
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_message('password_check', '%s must contain both numbers and alphabets');
            if( $this->form_validation->run() == TRUE )
            {
                $data = array('email'=>$this->input->post('email'),
                    'first_name'=>$this->input->post('first_name'),
                    'last_name'=>$this->input->post('last_name'),
                    'mobile'=>$this->input->post('mobile'),
                    'password'=>$this->input->post('password'),
                    'id'=>$this->input->post('id'),
                    'created_by'=>$this->input->post('referrer_id')
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
    /*******************************END***********************************/
    /**********************CLub agent Sign up*****************************/
    function ca_signup($otp,$id)
    {
        $otp =  encrypt_decrypt('decrypt',$otp);
        $id = $id;
        $data['get_menu']=$this->product_model->get_menus();
        $data['details'] = $this->register_model->get_ca_details($id);
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_ca_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/edit_memberagent_signup",$data);
    }

    function signup_clubagent()
    {
        if ($this->input->is_ajax_request()) 
        {
            //$this->form_validation->set_rules('email', 'Email', 'required|trim');
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
                    /*$validate_password = $this->register_model->validate_password(encrypt_decrypt('encrypt',$this->input->post('password')));
                    if($validate_password['status'] === TRUE)
                    {*/
                        $cpassword =$this->input->post('cpassword');
                        if($password==$cpassword){
                            $password =encrypt_decrypt('encrypt',$this->input->post('password'));
                            $data_input = array('password'=>$password,'otp_status'=>1,'email'=>$mail);
                            $where = array('id'=>$id);
                            $res = update_tbl('gp_login_table',$data_input,$where);

                            if($res)
                            {
                                $where = 'gp_login_table.user_id=gp_normal_customer.id';
                                $result = select_all_by_id('gp_login_table',$id,'gp_normal_customer',$where);
                                $user_id = $result->user_id;
                                $ca_name = $result->name;

        						$datestring = date('Y-m-d H:i:s');
                                $data_input2 = array('type'=>'club_agent','created_on'=>$datestring,'status'=>'approved');
	                            $where2 = array('id'=>$user_id);
	                            $res2 = update_tbl('gp_normal_customer',$data_input2,$where2);

                                $data = array(
                                        array('wallet_type_id' => 3,
                                                'user_id' => $id,
                                                'total_value' => 0
                                                ),
                                        array('wallet_type_id' => 2,
                                                'user_id' => $id,
                                                'total_value' => 0
                                                ),
                                        array('wallet_type_id' => 4,
                                                'user_id' => $id,
                                                'total_value' => 0
                                                )
                                        );
                
                                $res = multi_insert('gp_wallet_values', $data);
                                //Club agent -Create Ledger
                                $date = date('Y-m-d');
                                $financial_year = get_financial_year();
                                $ca_ldg = array(
                                                'type_id' => $id,
                                                '_type' => 'EMPLOYEE',
                                                'group_id' => 25,
                                                'name' => $id ."_".$ca_name.'_ledger'
                                                );
                                $ldg_qry = $this->db->insert('erp_ac_ledgers', $ca_ldg);
                                $ldg_id = $this->db->insert_id();
                                $opening =  array(
                                                'ledger_id' => $ldg_id,
                                                'fy_id' => $financial_year,
                                                'opening_date' =>$date
                                                );
                                $open_qry = $this->db->insert('erp_ac_opening_balance', $opening);
 
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
	/*******************************END***********************************/
    function get_states_by_country()
    {

        $country_id = $this->input->get('country_id');
        $country_id = intval($country_id);
        $data = get_states_by_country($country_id);

        if(!empty($data))
        {
            exit(json_encode(array('status' => true, 'data'=> $data)));
        }else{
            exit(json_encode(array('status' => false, 'reason'=> 'Please try again later')));
        }
    }
    function get_city_by_state()
    {
        $state_id = $this->input->get('state_id');
        $state_id = intval($state_id);
        $data = get_city_by_state($state_id);
        if(!empty($data))
        {
            exit(json_encode(array('status' => true, 'data'=> $data)));
        }else{
            exit(json_encode(array('status' => false, 'reason'=> 'Please try again later')));
        }
    }





	function new_club_member()
	{
		if($this->input->is_ajax_request())
		{
			$this->form_validation->set_rules("club_plan","Membership Plan","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("cl_reg_name","Name","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("cl_reg_mail","Email","trim|htmlspecialchars|valid_email");
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
							$datas['mobile'] = $mobile;
                            $otp = $results['info']['otp'];
                            $number = $mobile; // A single number or a comma-seperated list of numbers
                            $message = "Hi, Welcome to Jaazzo.Please verify the one time password".$otp;
                            send_message($number,$message);

                            $email_message = $this->load->view('templates/public/mail/member_otp_verification', $results,TRUE);
							$from = "maneeshakk16@gmail.com";
                            $mail_head = 'Message From Jaazzo';
                            $status = send_custom_email($from, $mail_head, $email, 'OTP Verification', $email_message);
                             if($status)
                             {
                               exit(json_encode(array('status'=>true, 'data' => $response)));
                             }else{
                               exit(json_encode(array("status"=>TRUE, 'data' => $response)));
                             }

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
    function get_state_by_id($id)
    {
        $data = $this->register_model->get_state_by_country($id);
        if($data){
            exit(json_encode(array('status'=>true,'data'=>$data)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'invalid selection')));
        }
    }
    function get_city_by_id($id)
    {
        $data = $this->register_model->get_city_by_state($id);
        if($data){
            exit(json_encode(array('status'=>true,'data'=>$data)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'invalid selection')));
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
				$result = $this->register_model->otp_validate_club_reg();
				if($result['status'] == TRUE)
				{
                                   $ses_status = $this->session->unset_userdata('logged_in_user');
                                   if($ses_status){
                    	             $this->session->session_destroy();
                                   }
                                   $session_array = array();
				   $session_array = array(
                                     'id' => $result['info']['id'],
                                     'type' => $result['info']['type'],
                                     'email' => $result['info']['email'],
                                     'mobile' => $result['info']['mobile'],
                                     'user_id' => $result['info']['user_id'],
									 'club_type_id'=>$result['info']['club_type_id'],
                                     'login' =>true);
				   $this->session->set_userdata('logged_in_club_member', $session_array);
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
    function signup($otp)
    {
    	$otp = encrypt_decrypt('decrypt',$otp);
    	$result = $this->register_model->check_otp_validate($otp);
    	$data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_ca_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
		if($result)
		{
			$data['details']=$result;
		} else{
			$data['details']=array();
		}
		// var_dump($data['details']);exit;
		$this->load->view("public/edit_normal_customer_signup",$data);
    }
    function fb_login()
    {
    	$userData = array();
        $this->facebook->is_authenticated();

        // Check if user is logged in
        if($this->facebook->is_authenticated()){
            // Preparing data for database insertion
            $userProfile = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,gender,locale,picture');

            // echo json_encode($userProfile);exit();
            $userData['oauth_provider'] = 'facebook';
            $userData['oauth_uid'] = $userProfile['id'];
            $userData['name'] = $userProfile['first_name'];
            $userData['email'] = $userProfile['email'];

            // Insert or update user data
            $userID = $this->user->checkUser($userData);

            // Check user data insert or update status
            if(!empty($userID)){
                $data['userData'] = $userData;
                $this->session->set_userdata('logged_in_user',$userData);
            }else{
               $data['userData'] = array();
            }

            // Get logout URL
            $data['logoutUrl'] = $this->facebook->logout_url();
        }else{
            $fbuser = '';

            // Get login URL
            $data['authUrl'] =  $this->facebook->login_url();
        }
        $this->load->view('user_authentication/index',$data);
    }
    public function fb_logout() {
        // Remove local Facebook session
        $this->facebook->destroy_session();

        // Remove user data from session
        $this->session->unset_userdata('userData');

        // Redirect to login page
        redirect('/index.php/Register/fb_login');
    }
}
?>