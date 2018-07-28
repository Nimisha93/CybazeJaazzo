<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**

*

*/

class Employee_warning extends CI_Controller

{



	function __construct()

	{

		parent::__construct();


        $this->load->model('hr/Mdl_warning');

        //$this->load->model('admin/patient_model');
         $this->load->library(array('session','form_validation','pagination'));

        $this->load->helper(array('url','form','my_common_helper','string'));


        $session_array = $this->session->userdata('logged_in_admin');

        if(!isset($session_array))

        {

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

    function get_warning()

    {
         if(has_role('view_warning')){
        $data=$this->set_menu();

        $data['request'] = $this->Mdl_warning->get_requesition_by_id();
     
        $data['employees'] = $this->Mdl_warning->get_req_employee();

        $this->load->view('hr/hr_view_warning', $data);
         }

    }

       function index()

    {

     if(has_role('add_warning')){
        $data=$this->set_menu();

        $data['employees'] = $this->Mdl_warning->get_req_employee();

    //    $data['forward'] = $this->Mdl_warning->get_forward();



        $this->load->view('hr/hr_add_warning',$data);
     }

    }
    function add_new_warning(){

        if($this->input->is_ajax_request())

		{

		$this->form_validation->set_rules("forward","Warning To","trim|required|htmlspecialchars");
                $this->form_validation->set_rules("forwardd","Warning By","trim|required|htmlspecialchars");
                $this->form_validation->set_rules("title","Date","trim|required|htmlspecialchars");
                $this->form_validation->set_rules("date","Subject","trim|required|htmlspecialchars");

		if( $this->form_validation->run() == TRUE )

		{

                $result=$this->Mdl_warning->addcomplaint();

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


  
 function get_warning_by_id($id)

    {

      if(has_role('edit_warning')){
        $data=$this->set_menu();

        $data['request'] = $this->Mdl_warning->edit_warning_by_id($id);

    //    $data['forward'] = $this->Mdl_warning->get_forward();



        $data['status'] = $this->Mdl_warning->get_employee_status();

        $data['priority'] = $this->Mdl_warning->get_priority_req();

        $data['employees'] = $this->Mdl_warning->get_req_employee11();

        $this->load->view('hr/hr_edit_warning', $data);
      }

    }

      function edit_get_warning(){
//var_dump("dsfdsfsd");
        if($this->input->is_ajax_request()){

                $this->form_validation->set_rules("forward","Warning To","trim|required|htmlspecialchars");
                $this->form_validation->set_rules("warning_by","Warning By","trim|required|htmlspecialchars");
                $this->form_validation->set_rules("title","Date","trim|required|htmlspecialchars");
                $this->form_validation->set_rules("daten","Subject","trim|required|htmlspecialchars");

		if( $this->form_validation->run() == TRUE )

		{

              
                $result=$this->Mdl_warning->editrequest();

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
      }

      function delete_warning()

    {

        if($this->input->is_ajax_request())
        {
            $qry = $this->Mdl_warning->delete_warning($this->input->post());
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

    function get_warning_report()

    {
 if(has_role('warning_report')){
        $data=$this->set_menu();

        $data['request'] = $this->Mdl_warning->get_requesition_by_id();

        $data['employees'] = $this->Mdl_warning->get_req_employee();

        $this->load->view('hr/hr_warning_report', $data);
 }

    }
}

?>