<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 */
/**
* 
*/
class Clubagent extends CI_Controller
{
	
	function __construct()
	{
		parent:: __construct();
        $this->load->library(array('session','form_validation','pagination'));
        $this->load->model(array('admin/Channelpartner_model', 'admin/Dashboard_model', 'register_model', 'admin/clubagent_model'));
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
    // get all club agents
    function get_all_club_agents()
    {
    	$data=$this->set_menu();
        // $data['club_agents']= $this->clubagent_model->get_all_club_agents();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $config = array();
        $config["base_url"] = base_url() . "all_club_agents/";
        $result_count = $this->clubagent_model->get_all_club_agents_count($param);
        $config["total_rows"] =  $result_count;
        $config["per_page"] = 10;
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
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;

        $data["data"] = $this->clubagent_model->get_all_club_agents($param,$config["per_page"], $page);
        
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $data['club_members'] = get_all_club_members();
        $this->load->view('admin/edit_view_all_club_agents',$data);
    }
    //Add new club agent
    function new_club_agent()
    {
    	if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim');
            if($this->form_validation->run() == TRUE)
            {
                $name = $this->input->post('name');
                $mail = $this->input->post('email');
                $create_by = $this->input->post('create_by');
                $validate_email = $this->register_model->validate_email($mail);
                $by = $this->input->post('by');
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
                                'register_via'=>$create_by,
                                'mem_id'=>$by
	                            );
	                            $result = $this->clubagent_model->add_club_agent($data);
	                        }
	                    }else{
	                    	$data=array('mobile' => $mobile,
	                            'name' => $name,
	                            'email' => $mail,
                                'register_via'=>$create_by,
                                'mem_id'=>$by
	                            );
	                        $result = $this->clubagent_model->add_club_agent($data);
	                    }
	                    
                	    if($result)
                        {
                            $data['id'] = $result['info']['user_id'];
                            $data['otp'] = $result['info']['otp'];
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
    //Delete club agebt
    function delete_club_agent()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->clubagent_model->delete_club_agent($this->input->post());
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
    function get_clubagent_byid($id)
    {
        $data=$this->set_menu();
        $data['details']= $this->clubagent_model->get_clubagent_byid($id);
        $data['club_members'] = get_all_clubmembers();
        $this->load->view('admin/edit_view_club_agent_by_id',$data);
    }
    function delete_club_agent_docs($id)
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->clubagent_model->delete_club_agent_docs($id);
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
    function update_club_agent()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('email', 'Email', 'required|trim');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim');
            if($this->form_validation->run() == TRUE)
            {
                $name = $this->input->post('name');
                $mail = $this->input->post('email');
                $id = $this->input->post('id');
                $create_by = $this->input->post('create_by');
                $mobile = $this->input->post('mobile');
                $mem_id = ($create_by=='admin')?'':$this->input->post('by');    
                $files = $_FILES;
                if($files){
                    $config['upload_path'] =  './uploads/ca_docs';
                    $config['allowed_types'] = 'doc|docx|pdf';
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
                        $data=array('phone' => $mobile,
                        'name' => $name,
                        'email' => $mail,
                        'ca_docs'=>'uploads/ca_docs/'.$fileName,
                        'register_via'=>$create_by,
                        'mem_id'=>$mem_id
                        );
                        $result = $this->clubagent_model->update_club_agent($data,$id);
                    }
                }else{
                    $data=array('phone' => $mobile,
                        'name' => $name,
                        'email' => $mail
                        );
                    $result = $this->clubagent_model->update_club_agent($data,$id);
                }
                
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