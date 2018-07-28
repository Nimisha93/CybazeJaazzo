<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Change_password extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('session','form_validation'));
		$this->load->helper(array('url','form','string'));
		$this->load->model('admin/Change_model');
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array)){
            redirect('admin/Login');
        }
	}



 function admin_set_menu()
    {
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        return $data;
    }
    

      public function changepsw() {


        // $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        // $data['sidebar'] = $this->load->view('admin/templates/ex_sidebar', '', true);
        // $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
         
   $data=$this->admin_set_menu();
        $this->load->view('admin/change_psw',$data);

    }

    
    function change_current_pass()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('old', 'Old Password', 'required|trim');
            $this->form_validation->set_rules('new_pass', 'New Password', 'required|trim');
            $this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'required|trim');
            
            if($this->form_validation->run() == TRUE)
            {
                $old_pass = $this->input->post('old');
                $new_pass = $this->input->post('new_pass');
                $confirm_pass = $this->input->post('confirm_pass');
                $session_array = $this->session->userdata('logged_in_admin');
                $user_id = $session_array['id'];
                
                $current_pass = $this->Change_model->get_current_pass($user_id);
                $current_pass = $current_pass['password'];
                $current_pass = encrypt_decrypt('decrypt',$current_pass);
                //var_dump($current_pass);var_dump($old_pass);exit();
                if($current_pass == $old_pass)
                {
                    if($new_pass == $confirm_pass){
                        $new_pass = encrypt_decrypt('encrypt',$new_pass);
                        $update_pass = $this->Change_model->update_pass($new_pass, $user_id);
                        if($update_pass)
                        {
                            exit(json_encode(array('status'=>true)));
                        } else{
                            exit(json_encode(array('status'=>false, 'reason'=>'Database Error')));
                        }
                    } else{
                        exit(json_encode(array('status'=>false, 'reason'=>'New password and confirm password does not match')));
                    }
                } else{
                    exit(json_encode(array('status'=>false, 'reason'=>'This is not your old password ')));
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