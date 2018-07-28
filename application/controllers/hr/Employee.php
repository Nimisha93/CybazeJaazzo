<?php


class Employee extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('hr/Mdl_employee','hr/Mdl_warning'));

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
    function add_employee(){

         if(has_role('view_employee')){
        $data=$this->set_menu();
        $data['employees'] = $this->Mdl_employee->get_all_employee();
        $data['branch']= $this->Mdl_employee->get_all_branch();
        $data['departments']= $this->Mdl_employee->get_all_departments();
        //var_dump( $data['branch']);exit();
        $this->load->view('hr/edit_add_employee',$data);
         }


    }
     function get_designation_by_dep($dep)
    {
        $data = $this->Mdl_employee->get_designation_by_dep($dep);
        if($data)
        {
            exit(json_encode(array('status' =>TRUE, 'data' => $data)));
        } else{
            exit(json_encode(array('status' => FALSE, 'reason' => 'No Data')));
        }
    }
    function new_employee()
    {
       // var_dump("success");exit();
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("name","Employee Name","trim|required");
            $this->form_validation->set_rules("phone","Phone","trim|required|is_unique[hr_employee.mobile]");
            $this->form_validation->set_rules("email","Email","trim|required|valid_email|is_unique[hr_employee.email]");
            $this->form_validation->set_rules("work_email","Work Email","valid_email|is_unique[hr_employee.email]");
            $this->form_validation->set_rules("p_phone","Parent Mobile","trim|required");
            $this->form_validation->set_rules("gender","Gender","trim|required");
            // $this->form_validation->set_rules("bank_ac_no","Bank A/C No","trim|required");
            // $this->form_validation->set_rules("ifsc_code","IFSC Code","trim|required");
            $this->form_validation->set_rules("address","Address","trim|required");
            // $this->form_validation->set_rules("ta","TA","trim|required|numeric");
            // $this->form_validation->set_rules("da","DA","trim|required|numeric");
            // $this->form_validation->set_rules("hra","HRA","trim|required|numeric");

            if($this->form_validation->run()== TRUE)
            {
                $session_data = $this->session->userdata('logged_in_admin');
                $id = $session_data['id'];


                $qry = $this->Mdl_employee->add_employee( $id);
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
    function view($id)
    {
         if(has_role('edit_employee')){
        $data=$this->set_menu();
        $data['departments'] = $this->Mdl_employee->get_all_departments();
        $data['employees'] = $this->Mdl_employee->get_employee_by_id($id);
        
//var_dump( $data['employees'][0]['department']);exit();
        $data['designations'] = $this->Mdl_employee->get_designation_by_dep($data['employees'][0]['department']);
        $data['branch']= $this->Mdl_employee->get_all_branch();
//var_dump( $data['employees'] );exit();
        $this->load->view('hr/edit_employee_edit', $data);
         }
    }
function update_staff($id)
    {
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("name","Name","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone","Phone","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("blood_group","Blood Group","trim|htmlspecialchars");
            $this->form_validation->set_rules("email","Email","trim|required|htmlspecialchars|valid_email");
            $this->form_validation->set_rules("p_phone","Parent Phone","trim|htmlspecialchars");
            $this->form_validation->set_rules("gender","Gender","trim|htmlspecialchars");
            $this->form_validation->set_rules("department","Department","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("address","Address","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("designation","Designation","trim|htmlspecialchars");
            $this->form_validation->set_rules("basic_salary","Basic Salary","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("date_of_join","Date","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("work_phone","Work Phone","trim|htmlspecialchars");
            $this->form_validation->set_rules("work_email","Work Email","trim|htmlspecialchars");
            if( $this->form_validation->run() == TRUE )
            {
                $result=$this->Mdl_employee->updateEmployee($id);
                if($result){
                    exit(json_encode(array("status"=>TRUE, 'response' => 'Created Successfully')));
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

     function delete_staff()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->Mdl_employee->delete_staff($this->input->post());
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

      function get_employee_join($id)
    {
        $data = $this->Mdl_employee->join_employee($id);
        if($data)
        {
            exit(json_encode(array('status' =>TRUE, 'data' => $data)));
        } else{
            exit(json_encode(array('status' => FALSE, 'reason' => 'No employee join')));
        }
    }
    function get_offer_letter($id)
    {
        $data=$this->set_menu();
        $data['employee_details'] = $this->Mdl_employee->get_emp_det_by_id($id);
        //echo json_encode($data['employee_details']);
        $this->load->view('hr/employee_offer_letter', $data);
    }
   function update_status($id)
    {
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("status","Status","trim|required|htmlspecialchars");
            if( $this->form_validation->run() == TRUE )
            {
                $data = $this->Mdl_employee->updateStatus($id);
                if($data)
                {
                    exit(json_encode(array('status' => true)));
                } else{
                    exit(json_encode(array('status' =>FALSE, 'reason' => 'No Data')));
                }
            } else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }else{
            show_error("We are unable to process this request on this way!");
        }
    }

    function update_terminated()
    {
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("employee_id","Employee Id","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("ter_status","Status","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("reason_comment","Reason","trim|required|htmlspecialchars");
            if( $this->form_validation->run() == TRUE )
            {
                $data = $this->Mdl_employee->updateTerminated();
                if($data)
                {
                    exit(json_encode(array('status' => true)));
                } else{
                    exit(json_encode(array('status' =>FALSE, 'reason' => 'No Data')));
                }
            } else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }else{
            show_error("We are unable to process this request on this way!");
        }
    }
    function active_employee()
    {
       
         if(has_role('view_active_employee')){
        $data=$this->set_menu();
        $data['employees'] = $this->Mdl_employee->get_active_employee();
        $data['branch']= $this->Mdl_employee->get_all_branch();
        $data['departments']= $this->Mdl_employee->get_all_departments();
        //var_dump( $data['branch']);exit();
        $this->load->view('hr/employee_list',$data);
         }
    }
      function get_salary_details($id)
    {
        $data = $this->Mdl_employee->get_salaryId($id);
        if($data)
        {
            exit(json_encode(array('status' =>TRUE, 'data' => $data)));
        } else{
            exit(json_encode(array('status' => FALSE, 'reason' => 'No Salary')));
        }
    }
     function hike_salary()
    {
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("hike_emp_id","Employee Id","trim|required|htmlspecialchars");
    $this->form_validation->set_rules("current_salry_id","Current Salary Id","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("from_sal","From Date","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("cur_sal","Salary","trim|required|htmlspecialchars");
            if( $this->form_validation->run() == TRUE )
            {
                //echo "dfdfd";exit();
                $data = $this->Mdl_employee->hikeSalaryById();
                if($data)
                {
                    exit(json_encode(array('status' =>true)));
                } else{
                    exit(json_encode(array('status' => FALSE, 'reason' => 'No Salary')));
                }
            } else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }else{
            show_error("We are unable to process this request on this way!");
        }
    }

     function payment()
    {
        $data=$this->set_menu();
        $data['employees'] = $this->Mdl_employee->get_salary_payment_employee();
        $data['first_last_date'] = $this->Mdl_employee->get_first_last_day();
        $this->load->view('hr/edit_employee_payment', $data);
    }
    function preference()
    {
        if(has_role('view_preferences')){
        $data=$this->set_menu();
        $data['prefer'] = $this->Mdl_employee->get_preference();
        $this->load->view('hr/edit_preference', $data);
         }

    }
    function edit_preference($id)
    {
     $result=$this->Mdl_employee->edit_preference($id);

      if($result)
    {
    exit(json_encode(array('status'=>true,'data'=>$result)));
    }
    else
    {
    exit(json_encode(array('status'=>false)));
    }
    }
    function update_prefernce()
    {
    $result=$this->Mdl_employee->update_preference();
    if($result)
    {
    exit(json_encode(array('status'=>true,'data'=>$result)));
    }
    else
    {
    exit(json_encode(array('status'=>false)));
    }

      
    }

    function get_all_emp_joining_report()

    {
 if(has_role('view_employee_joining_report')){
        $data=$this->set_menu();

        $data['employees'] = $this->Mdl_employee->get_employee();

//		$data['product'] = $this->product_model->get_product();

        $this->load->view('hr/employee_joining_report', $data);

 }

    }
    function get_active_employee_report()

    {
if(has_role('view_active_employee_report')){
        $data=$this->set_menu();

     

        $data['request'] = $this->Mdl_employee->get_salary_paid();



        $data['employees'] = $this->Mdl_employee->get_active_employee();

//		$data['product'] = $this->product_model->get_product();

        $this->load->view('hr/view_employee_list', $data);
}
    }

     function get_requisition_report()
    {
if(has_role('view_requisition_report')){
        $data=$this->set_menu();
        $data['request'] = $this->Mdl_employee->get_requesition_by_id();
        $this->load->view('hr/hr_requisition_report', $data);
}
    }

    function  get_designation_report()

    {
 if(has_role('view_designation_report')){
        $data=$this->set_menu();

        $data['stations'] = $this->Mdl_employee->get_all_stations();

       $data['departments'] = $this->Mdl_employee->get_all_departments();

        $data['designations'] = $this->Mdl_employee->get_designation();

        // $data['alldesignations'] = $this->staff_model->get_all_designation();

        $this->load->view('hr/list_designation', $data);

 }

    }


    
}