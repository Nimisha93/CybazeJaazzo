<?php


class Employee_complaints extends CI_Controller

{


function __construct()

	{

		parent::__construct();

        $this->load->helper(array('url','string','form'));

        $this->load->model('hr/Mdl_complaints');

        //$this->load->model('admin/patient_model');

        $this->load->library(array('session','form_validation'));

        $session_array = $this->session->userdata('logged_in_admin');

        if(!isset($session_array))

        {

            redirect('admin/Login');

        }

	}

       function set_menu()
    {
        $data['header'] = $this->load->view('templates/hr/edit_header','', true);
        $data['sidebar'] = $this->load->view('templates/hr/edit_sidebar','', true);
        $data['footer'] =  $this->load->view('templates/hr/edit_footer','', true);
        return $data;
    }

     function index()
    {

        $data=$this->set_menu();

        $data['employees'] = $this->Mdl_complaints->get_req_employee();
      //  $data['forward'] = $this->Mdl_complaints->get_forward();


        $this->load->view('hr/hr_add_complaints',$data);
    }
     function get_complaints()
    {
//        $this->permission->checkRole( 'view_complaints' );

        $data=$this->set_menu();
        $data['complaint'] = $this->Mdl_complaints->get_complaints_by_id();
        $this->load->view('hr/hr_view_emp_complaints', $data);
    }

     function add_new_complaint(){
       //  if($this->input->is_ajax_request()){

             $result=$this->Mdl_complaints->addcomplaint();
                if($result){

                     exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }



       // }
    }
     function get_complaint_reports()
    {
        if(has_role('view_complaint_report')){
        $data=$this->set_menu();
        $data['complaint'] = $this->Mdl_complaints->get_complaints_by_id();
        $this->load->view('hr/hr_complaints_report', $data);
         }
    }


}

?>