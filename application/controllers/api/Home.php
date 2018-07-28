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

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('api/Home_model');
        $this->load->helper(array('string','date','form'));
        header("Access-Control-Request-Headers:*");
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: content-type, origin, accept, Authorization-key");
        header('Cache-control: no-cache');
        header("Connection: Keep-alive");

    }
    function get_countries(){
            $data['countries']=$this->Home_model->get_countries();
    		if(!empty($data))
    		{
		        echo json_encode(array("error"=>false, 'message' => "All Countries", 'data' => $data));
		    }else{
		        echo json_encode(array("error"=>true, 'message' => "No Countries"));
		    }		
    }

    function get_state(){
    	$this->form_validation->set_rules('country', 'Country', 'required|trim|htmlspecialchars');
    	if ($this->form_validation->run() === TRUE) {
    		$country = $this->input->post('country');
    		$data['states']=$this->Home_model->get_state($country);
    		if(!empty($data))
    		{
		        echo json_encode(array("error"=>false, 'message' => "All states", 'data' => $data));
		    }else{
		        echo json_encode(array("error"=>true, 'message' => "No state"));
		    }

			}
    }
    function get_city(){
        $this->form_validation->set_rules('state', 'State', 'required|trim|htmlspecialchars');
    	if ($this->form_validation->run() === TRUE) {
    		$state = $this->input->post('state');
    		$data['city']=$this->Home_model->get_city($state);
    		if(!empty($data))
    		{
		        echo json_encode(array("error"=>false, 'message' => "All city", 'data' => $data));
		    }else{
		        echo json_encode(array("error"=>true, 'message' => "No city"));
		    }

		}	
    }
    function get_executive_designations(){


    		
    		$data['designations']=$this->Home_model->get_executive_designations();
    		if(!empty($data))
    		{
		        echo json_encode(array("error"=>false, 'message' => "All designations", 'data' => $data));
		    }else{
		        echo json_encode(array("error"=>true, 'message' => "No designations"));
		    }
	}	
    function change_password(){
            $this->form_validation->set_rules('old_password', 'Old Password', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('new_password', 'New Password', 'required|trim|htmlspecialchars');
            if ($this->form_validation->run() == TRUE) {
                $password = $this->input->post('old_password');
                $new_pass = $this->input->post('new_password');
                $api_key=get_api_key();
                $validate_user = $this->Home_model->validate_psw($password,$api_key);

                if ($validate_user) {
                    $res = $this->Home_model->change_password($new_pass,$api_key);
                    if ($res) {
                        echo json_encode(array('error' => false,'message' => "password changed"));
                    } else {
                        echo json_encode(array('error' => true, 'message' => 'Database Error, Please try Again'));
                    }
                }
                else{
                    echo json_encode(array('error' => true, 'message' => 'Incorrect Current Password '));
                }
            }
            else{
               echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
            }
    }
    function forgot_password_otp(){
            $required_email = $this->input->post('mobile') ? '' : '|required' ;
            $required_mobile = $this->input->post('email') ? '' : '|required' ;
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim'. $required_mobile .'|htmlspecialchars');
            $this->form_validation->set_rules('email', 'Email', 'trim'. $required_email .'|htmlspecialchars');
            if ($this->form_validation->run() == TRUE) {  
                $validate_user = $this->Home_model->validate_user();
                if ($validate_user) {
                    $mobile = $this->input->post('mobile');
                    if(!empty($mobile))   
                       {  
                           $numbers =  $mobile; // A single number or a comma-seperated list of numbers
                           $message = $validate_user." is the OTP for mobile number verification. Please enter it in the space provided in the website. Thank you for using Jaazzo. ";
                                      
                           $result= send_message($numbers,$message);
                       }
                    $email = $this->input->post('email');
                    if(!empty($email))   
                       { 
                          $results['info']['otp'] = $validate_user;  
                          $email_message = $this->load->view('templates/public/mail/member_otp_verification', $results,TRUE);
                          $mail_from = "maneeshakk16@gmail.com";
                          $mail_head = 'JAAZZO';
                          $status = send_custom_email($mail_from, $mail_head, $email,'OTP Verification',$email_message);
                       }
                    
                        echo json_encode(array('error' => false,'message' => "OTP Send"));
                   
                }
                else{
                    echo json_encode(array('error' => true, 'message' => 'Invalid User'));
                }
            }
            else{
                echo json_encode(array('error'=>true,'message'=>strip_tags(validation_errors())));
            }
    }
    
    function confirm_otp_forgot_password(){
            $required_email = $this->input->post('mobile') ? '' : '|required' ;
            $required_mobile = $this->input->post('email') ? '' : '|required' ;
            $this->form_validation->set_rules('mobile', 'Mobile', 'trim'. $required_mobile .'|htmlspecialchars');
            $this->form_validation->set_rules('email', 'Email', 'trim'. $required_email .'|htmlspecialchars');
            $this->form_validation->set_rules('otp', 'OTP', 'required|trim|htmlspecialchars');
            if ($this->form_validation->run() == TRUE) { 
                $data = $this->Home_model->confirm_otp();
                if(!empty($data))
                {
                echo json_encode(array("error"=>false, 'message' => "OTP matches", 'data' => $data));
                }else{
                    echo json_encode(array("error"=>true, 'message' => "OTP Not Match", 'data' => $data));
                }
            }else{
                echo json_encode(array('error'=>true,'message'=>strip_tags(validation_errors())));
            }
    }

    function reset_password(){
            $this->form_validation->set_rules('password', 'Password', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('api_key', 'Api_key', 'required|trim|htmlspecialchars');
            
            if ($this->form_validation->run() == TRUE) { 
                $data = $this->Home_model->reset_password();
                if(!empty($data))
                {
                echo json_encode(array("error"=>false, 'message' => "Successfully reset password", 'data' => ''));
                }else{
                    echo json_encode(array("error"=>true, 'message' => "error", 'data' => $data));
                }
            }else{
                echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
            }
    }
    function profile(){
        $api_key = get_api_key();
        if($api_key){
            $result = $this->Home_model->profile($api_key);
            if($result)
            {
                echo json_encode(array("error"=>false, 'data' => $result,'message' => 'Success'));
            }else{
                echo json_encode(array("error"=>true, 'message' => 'Invalid Api key'));
            }
        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }
    function add_money_to_wallet()
    {
        $api_key = get_api_key();
        if($api_key){
            $this->form_validation->set_rules('amount', 'Amount', 'required|numeric|trim|htmlspecialchars');

            if($this->form_validation->run() === TRUE) {

                $udetails = user_details_by_apikey($api_key);
                $login_id = $udetails['id'];
                $user_id = $udetails['user_id']; 
                $type = $udetails['type']; 
                if($login_id){
                    if(($type !='club_agent') && ($type !='executive')){

                        $result = $this->Home_model->add_money_to_wallet($login_id);
                        if($result['status'])
                        {
                            echo json_encode(array("error"=>false, 'message' => 'Amount added to account'));
                        }else{
                            echo json_encode(array("error"=>true, 'message' => 'Invalid Api key'));
                        } 
                    }else{
                        echo json_encode(array("error"=>true, 'message' => 'Unable to add money to your wallet'));
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
    function get_reason(){
            $data['reason']=$this->Home_model->get_reason();
            if(!empty($data))
            {
                echo json_encode(array("error"=>false, 'message' => "All Reasons", 'data' => $data));
            }else{
                echo json_encode(array("error"=>true, 'message' => "No Countries"));
            }       
    }
    function get_package($id){
        $data['details'] = getClubtypeById($id);
        $this->load->view("public/edit_vew_package_details",$data);
    }
    function help_support(){
        $this->load->view("public/view_help_support");
    }
    function privacy_policy(){
        $this->load->view("public/view_privacy_policy");
    }
    
    function register_terms_n_condition(){
        $this->load->view("public/view_register_terms_n_condition");
    }
    function ca_terms_n_condition(){
        $this->load->view("public/view_ca_terms_n_condition");
    }
    function cm_terms_n_condition(){
        $this->load->view("public/view_cm_terms_n_condition");
    }
    function get_search_product_locations(){
        $this->form_validation->set_rules('key', 'Search key', 'required|trim|htmlspecialchars');
            
        if ($this->form_validation->run() == TRUE) { 
            $key = $this->input->post('key');
            $data['locations']=$this->Home_model->get_search_product_locations($key);
            if(!empty($data))
            {
                echo json_encode(array("error"=>false, 'message' => "This is a product locations", 'data' => $data));
            }else{
                echo json_encode(array("error"=>true, 'message' => "No Locations"));
            }
        }else{
             echo json_encode(array('error'=>true,'message'=>strip_tags(validation_errors())));  
        }
    }
    function get_location_wise_channel_partner(){
        $this->form_validation->set_rules('location_id', 'Location id', 'required|trim|htmlspecialchars');
            
        if ($this->form_validation->run() == TRUE) { 
            $location_id = $this->input->post('location_id');
            $data['channels']=$this->Home_model->get_location_wise_channel_partner($location_id);
            if(!empty($data))
            {
                echo json_encode(array("error"=>false, 'message' => "Your channel partners", 'data' => $data));
            }else{
                echo json_encode(array("error"=>true, 'message' => "No channel partners"));
            }
        }else{
             echo json_encode(array('error'=>true,'message'=>strip_tags(validation_errors())));  
        }
    }
    
}