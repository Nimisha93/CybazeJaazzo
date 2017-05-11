<?php 
/**
* 
*/
class Money_transfer extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('user/user_model'));
		$this->load->library(array('form_validation'));
		$this->load->helper(array('form', 'date'));
	}


function transfer_amount()
{
       $session_array = $this->session->userdata('logged_in_user');
		if(isset($session_array)){
			 $login_id = $session_array['id'];

			 if($this->input->is_ajax_request()){
			 	$this->form_validation->set_rules("transfer_type", "Wallet", "trim|required|htmlspecialchars");
                 $this->form_validation->set_rules("transfer_mobile", "Mobile ", "trim|required|htmlspecialchars");
                 $this->form_validation->set_rules("transfer_amount", "Amount", "numeric|trim|required|htmlspecialchars");
         

                 if($this->form_validation->run()== TRUE){

                     $reg_phone =  $this->input->post('transfer_mobile');
                      $reg_amount =  $this->input->post('transfer_amount');
                     $trans_type =  $this->input->post('transfer_type');

					 $transfer_phone = $this->user_model->transfer_phone($reg_phone);
                         if($transfer_phone==TRUE){
                         	 $userid=$transfer_phone['id'];
                               $wallet_res = $this->user_model->transfer_amount($userid,$reg_amount,$login_id,$trans_type );
                                	if($wallet_res==TRUE){
					                    exit(json_encode(array("status"=>TRUE)));
					                }
					                else{

					                    exit(json_encode(array("status"=>FALSE,"reason"=>"Not Enough amount")));
					                }     			  
				            }
			              else{	
		 		          exit(json_encode(array("status"=>FALSE,"reason"=>"Mobile doesnt exist")));
			              }				
                  }
                  else{	
		 		          exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
			       }	

                }
           

        }

    }

 }






?>