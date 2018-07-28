<?php
/**
 * User: kavyasree
 * Date: 10/11/17
 * Time: 11:10 PM
 */

class Requisition extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('hr/Mdl_requisition');
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
             if(has_role('view_requisition')){
           $data=$this->set_menu();
            $data['requisition'] = $this->Mdl_requisition->get_all_requisitions();
            $this->load->view('hr/edit_list_requisition',$data);
             }
    }
    function new_requisition(){
         if(has_role('add_requisition')){
           $data=$this->set_menu();
            $data['priority'] = $this->Mdl_requisition->get_all_priority();
            $data['employee'] = $this->Mdl_requisition->get_all_employee();

            $this->load->view('hr/edit_add_requisition',$data);
         }

    }
    function add_requisition(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("req_by","Requesition By","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("tittle","Title","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("priority","Priority","trim|required|htmlspecialchars");

            if( $this->form_validation->run() == TRUE )
            {
                $result=$this->Mdl_requisition->add_request();
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
    function get_requisition_by_id($id)
    {
         if(has_role('edit_requisition')){
                      $data=$this->set_menu();

            $data['priority'] = $this->Mdl_requisition->get_all_priority();
            $data['status'] = $this->Mdl_requisition->get_all_status();
            $data['employee'] = $this->Mdl_requisition->get_all_employee();
            $data['req'] = $this->Mdl_requisition->get_all_requisitions_id($id);
            $this->load->view('hr/edit_update_requisition', $data);
         }
    }
        function update_requisition($id){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("req_by","Requisition By","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("tittle","Title","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("priority","Priority","trim|required|htmlspecialchars");

            if( $this->form_validation->run() == TRUE )
            {
                $result=$this->Mdl_requisition->edit_request($id);
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
    function deleterequisition()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->Mdl_requisition->deleterequisition($this->input->post());
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