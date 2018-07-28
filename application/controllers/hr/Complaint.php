<?php
/**
 * User: kavyasree
 * Date: 13/11/17
 * Time: 10:10 PM
 */

class Complaint extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('hr/Mdl_complaint','hr/Mdl_requisition'));

         $this->load->library(array('session','form_validation','pagination'));

        $this->load->helper(array('url','form','my_common_helper','string'));
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array))
        {
            redirect('admin/login');
        }
    }


    function set_menu()
    {
        $data['header'] = $this->load->view('hr/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('hr/templates/hr_sidebar', '', true);
        $data['footer'] = $this->load->view('hr/templates/hr_footer', '', true);
        return $data;
    }
     function index(){
          if(has_role('view_complaint')){
             $data=$this->set_menu();
            $data['complaint'] = $this->Mdl_complaint->get_all_complaints();
            
            $this->load->view('hr/edit_list_complaints',$data);
          
          }
    }
    function new_complaint(){
         if(has_role('add_complaint')){
              $data=$this->set_menu();
            
            $data['employee'] = $this->Mdl_requisition->get_all_employee();
            $this->load->view('hr/edit_add_complaint',$data);
         }

    }
    function add_complaint(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("com_against","Complaint Against","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("tittle","Title","trim|required|htmlspecialchars");
           

            if( $this->form_validation->run() == TRUE )
            {

                $result=$this->Mdl_complaint->add_request();
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
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
    function deletecomplaint()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->Mdl_complaint->deletecomplaint($this->input->post());
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
    function get_complaint_by_id($id)
    {
         if(has_role('edit_complaint')){
            $data=$this->set_menu();
            $data['status'] = $this->Mdl_requisition->get_all_status();
            $data['employee'] = $this->Mdl_requisition->get_all_employee();
            $data['compl'] = $this->Mdl_complaint->get_all_complaint_id($id);
        $this->load->view('hr/edit_update_complaint', $data);
         }
    }


      function get_complaint_reports()
    {
        if(has_role('view_complaint_report')){
        $data=$this->set_menu();
        $data['complaint'] = $this->Mdl_complaint->get_complaints_by_id();
        $this->load->view('hr/hr_complaints_report', $data);
         }
    }
       function update_complaint($id){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("com_against","Complaint Against","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("tittle","Title","trim|required|htmlspecialchars");
           

            if( $this->form_validation->run() == TRUE )
            {

                $result=$this->Mdl_complaint->edit_request($id);
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
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
}