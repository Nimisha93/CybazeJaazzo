<?php
/**
 * User: kavyasree
 * Date: 4/11/17
 * Time: 2:47 PM
 */

class Warning extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('hr/Mdl_warning'));
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array))
        {
            redirect('admin/login');
        }
    }
  
    function index()
    {
          if(has_role('manage_vendor')){
            $data['header'] = $this->load->view('templates/admin/edit_header','', true);
            $data['sidebar'] = $this->load->view('templates/admin/edit_sidebar','', true);
            $data['footer'] =  $this->load->view('templates/admin/edit_footer','', true);
            $data['warning']=$this->Mdl_warning->get_all_warning();
            $this->load->view('hr/edit_list_warning',$data);
        }
    }

        function add_warning(){
       
       
            $data['header'] = $this->load->view('templates/hr/edit_header','', true);
            $data['sidebar'] = $this->load->view('templates/hr/edit_sidebar','', true);
            $data['footer'] =  $this->load->view('templates/hr/edit_footer','', true);
            $data['employee'] = $this->Mdl_warning->get_all_employee();
            $this->load->view('hr/edit_add_warning',$data);
        

    }
   function new_warning()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("title","Title","trim|required");
            $this->form_validation->set_rules("description","Description","trim|required");

            if($this->form_validation->run()== TRUE)
            {
                $session_data = $this->session->userdata('logged_in_admin');
                 $id = $session_data['id']; 

               
                $qry = $this->Mdl_department->add_department( $id);
                if($qry)
                {
                    exit(json_encode(array('status'=>TRUE,'result'=>'add')));
                }else{
                    exit(json_encode(array('status'=>FALSE, 'reason'=>'Database Error..!')));
                }
            }else{
                exit(json_encode(array('status'=>FALSE,'reason'=>validation_errors())));
            }
        }else{
            show_error("Unable to process the request in this way");
        }
    }
    
}