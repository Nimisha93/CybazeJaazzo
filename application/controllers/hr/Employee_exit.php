<?php

/**

 *

 */

class Employee_exit extends CI_Controller

{



    function __construct()

    {

        parent::__construct();

        $this->load->helper('form');


        $this->load->model(array('hr/Mdl_exit'));

         $this->load->library(array('session','form_validation','pagination'));

        $this->load->helper(array('url','form','my_common_helper','string'));

        $session_array = $this->session->userdata('logged_in_admin');

        if(!isset($session_array)){

            redirect('admin/Login');

        }

    }

    function set_menu()
    {
        $data['header'] = $this->load->view('hr/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('hr/templates/hr_sidebar', '', true);
        $data['footer'] = $this->load->view('hr/templates/hr_footer', '', true);
        return $data;
    }


    function index()

    {
if(has_role('add_exit')){
        $data=$this->set_menu();

        $data['exit'] = $this->Mdl_exit->get_req_interview();

        $data['employees'] = $this->Mdl_exit->get_req_employee();

        $data['type'] = $this->Mdl_exit->get_req_type();



        $this->load->view('hr/hr_add_employee_exit',$data);
}

    }

    function add_new_exit()

    {
        $this->form_validation->set_rules('forward', 'Employee', 'required|trim');
        $this->form_validation->set_rules('date', 'Date', 'required|trim');
        $this->form_validation->set_rules('type', 'Exit type', 'required|trim');
        $this->form_validation->set_rules('interview', 'Interview', 'required|trim');
        $this->form_validation->set_rules('descrip', 'Description', 'required|trim');
        if ($this->form_validation->run() == TRUE) {
                   $result=$this->Mdl_exit->addexit();

                if($result){

               exit(json_encode(array("status"=>TRUE)));

                }else{

                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));

                }
        } else {
            exit(json_encode(array("status" => FALSE, 'reason'=>validation_errors())));

        }

    }

    function get_exit()

    {
 if(has_role('view_exit')){
        $data=$this->set_menu();

        $data['type'] = $this->Mdl_exit->get_req_type();



        $data['request'] = $this->Mdl_exit->get_exit_by_id();

        $this->load->view('hr/hr_view_employee_exit', $data);
 }

    }

    function delete_exit()

    {

        $data = $this->Mdl_exit->delete_exiting($this->input->post());

        if($data){

            exit(json_encode(array('status'=>TRUE)));

        } else{

            exit(json_encode(array('status'=>FALSE, 'reason'=> 'Databse Error')));

        }

    }

    function get_exit_by_id($id)

    {
if(has_role('add_exit')){
        $data=$this->set_menu();

        $data['request'] = $this->Mdl_exit->edit_exit_by_id($id);

        $data['employees'] = $this->Mdl_exit->get_req_employee1();

        $data['type'] = $this->Mdl_exit->get_req_type();

        $data['exit'] = $this->Mdl_exit->get_req_interview();





        $this->load->view('hr/hr_edit_employee_exit', $data);
}

    }

    function edit_get_exit(){

        if($this->input->is_ajax_request()){

                $result=$this->Mdl_exit->editexit();

                if($result){

                    exit(json_encode(array("status"=>TRUE)));

                }else{

                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));

                }

        }

        else{

            show_error("We are unable to process this request on this way!");

        }

    }

   function get_exit_report()

    {
 if(has_role('employee_exit_report')){
        $data=$this->set_menu();

        $data['type'] = $this->Mdl_exit->get_req_type();



        $data['request'] = $this->Mdl_exit->get_exit_by_id();

        $this->load->view('hr/hr_exit_report', $data);
 }
    }
}

?>