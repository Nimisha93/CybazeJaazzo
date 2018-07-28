<?php
/**
 * User: kavyasree
 * Date: 4/11/17
 * Time: 2:47 PM
 */

class Department extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('hr/Mdl_department');


        $this->load->library(array('session','form_validation','pagination'));

        $this->load->helper(array('url','form','my_common_helper','string'));
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array))
        {
            redirect('admin/login');
        }
    }
  
/*    function index()
    {
          if(has_role('manage_vendor')){
            $data['header'] = $this->load->view('templates/admin/edit_header','', true);
            $data['sidebar'] = $this->load->view('templates/admin/edit_sidebar','', true);
            $data['footer'] =  $this->load->view('templates/admin/edit_footer','', true);
            $data['vendors']=$this->Mdl_vendor->get_all_vendors();
            $this->load->view('admin/edit_vendor_list',$data);
        }
    }*/
 function set_menu()
    {
         $data['header'] = $this->load->view('hr/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('hr/templates/hr_sidebar', '', true);
        $data['footer'] = $this->load->view('hr/templates/hr_footer', '', true);
        return $data;
    }

        function add_department(){
       
            if(has_role('add_department')){
            $data=$this->set_menu();
            $data['department'] = $this->Mdl_department->get_all_departments();
            $data['branch'] = $this->Mdl_department->get_all_branchs();
            

            $this->load->view('hr/edit_add_department',$data);
            }

    }

    function new_department()
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
     function update_department($id)
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("title","Title","trim|required");
            $this->form_validation->set_rules("description","Description","trim|required");

            if($this->form_validation->run()== TRUE)
            {
                $session_data = $this->session->userdata('logged_in_admin');
                 $cid = $session_data['id']; 
                $qry = $this->Mdl_department->update_department($id,$cid);
                if($qry)
                {
                    exit(json_encode(array('status'=>TRUE,'result'=>'update')));
                }else{
                    exit(json_encode(array('status'=>FALSE, 'reason'=>'Database Error..!')));
                }
            }else{
                exit(json_encode(array('status'=>FALSE,'reason'=>validation_errors())));
            }
        }else{
            show_error("Unable To Process The Request In This Way");
        }
    }
     function deleteDepartment()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->Mdl_department->deleteDepartment($this->input->post());
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
    function designations()
    {
         if(has_role('add_designation')){
       $data=$this->set_menu();
        $data['departments'] = $this->Mdl_department->get_all_departments();
        $data['designations'] = $this->Mdl_department->get_all_designations();
        $data['branch'] = $this->Mdl_department->get_all_branchs();
        $this->load->view('hr/edit_list_designations',$data);
         }
    }
     function check_default($element)
    {
        if($element == '')
        { 
          return FALSE;
        }
        return TRUE;
    }
    function add_designation()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("branch","","trim|required");
            $this->form_validation->set_rules("desig","Designation","trim|required");
            $this->form_validation->set_rules("dept","Department","trim|required|callback_check_default");
            $this->form_validation->set_message('check_default', 'You need to select something other than the default');
            if($this->form_validation->run()== TRUE)
            {
                
                $qry = $this->Mdl_department->add_designation();
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
        function update_designation($id)
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("desig","Designation","trim|required");
            $this->form_validation->set_rules("dept","Department","trim|required|callback_check_default");
            $this->form_validation->set_message('check_default', 'You need to select something other than the default');
            if($this->form_validation->run()== TRUE)
            {
                
                $qry = $this->Mdl_department->update_designation($id);
                if($qry)
                {
                    exit(json_encode(array('status'=>TRUE,'result'=>'update')));
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
    function deletedesignation()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->Mdl_department->deletedesignation($this->input->post());
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
    
}