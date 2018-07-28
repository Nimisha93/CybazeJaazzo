<?php


class Payroll extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('hr/Mdl_payroll','hr/Mdl_warning'));

        $this->load->library(array('session', 'form_validation'));
                $this->load->helper(array('url', 'string'));

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


     function payment()
    {
          if(has_role('add_payment')){
        $data=$this->set_menu();
        $data['employees'] = $this->Mdl_payroll->get_salary_payment_employee();
        $data['first_last_date'] = $this->Mdl_payroll->get_first_last_day();
        $this->load->view('hr/edit_employee_payment', $data);;
          }
    }
    function get_employee_det_id($id)
    {

        $data = $this->Mdl_payroll->get_employee_det_id($id);
        if($data)
        {
            exit(json_encode(array('status' =>TRUE, 'data' => $data)));
        } else{
            exit(json_encode(array('status' =>FALSE, 'reason' => 'Employee not found')));
        }
    }
    function payroll_payment()
    {
        // echo "string"; exit();
    if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("empl_id","Employee Name","trim|required");
            $this->form_validation->set_rules("too","To","trim|required");
            $this->form_validation->set_rules("lvt","Total Leaves","trim|required");
            $this->form_validation->set_rules("lvr","Allowed Leaves","trim|required");
            $this->form_validation->set_rules("mode","Paid By","trim|required");

            if($this->form_validation->run()== TRUE)
            {
        $result=$this->Mdl_payroll->insert_payment();
        if($result)
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
function advance_payment(){

     if(has_role('view_advance')){


        $data=$this->set_menu();
        $data['advance'] = $this->Mdl_payroll->get_advance_salary();
      
        $this->load->view('hr/hr_view_advancesalary', $data);
     }
    }
     function add_advance(){

         if(has_role('add_advance')){
                $data=$this->set_menu();
                $data['employees'] = $this->Mdl_payroll->get_req_employee();
              //  $data['forward'] = $this->Mdl_payroll->get_forward() ;

                $this->load->view('hr/hr_add_advancesalary',$data);
         }
    }
     function add_new_advancesalary(){



                $result=$this->Mdl_payroll->addadvancesalary();
                if($result){

                   
                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }

    }
    function get_adv_lastdate_by_id()
    {
        
        $id = $this->input->post('id');
        $data = $this->Mdl_payroll->get_adv_lastdate_by_id($id);
        if($data)
        {
            exit(json_encode(array('status' =>true, 'data' => $data)));
        } else{
            exit(json_encode(array('status' =>false, 'reason' => 'No Data Found')));
        }
    }
    function get_advance_by_id($id)
    {
//        $this->permission->checkRole( 'edit_advance_salary' );

        $data=$this->set_menu();
        $data['employees'] = $this->Mdl_payroll->get_req_employee();
      //  $data['forward'] = $this->Mdl_payroll->get_forward() ;

        $data['advance'] = $this->Mdl_payroll->get_advance_salary_by_id($id);
        $this->load->view('hr/hr_edit_advancesalary', $data);
    }
     function edit_new_advancesalary(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("emp_name","Employee Name","trim|required|htmlspecialchars");
//            $this->form_validation->set_rules("forward_to","Forward To","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("advance_date","Date","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("advance_amount","Salary Amount","trim|required|htmlspecialchars");

            if( $this->form_validation->run() == TRUE )
            {
                $result=$this->Mdl_payroll->editadvancesalary();
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
    function delete_advance()
    {
        $data = $this->Mdl_payroll->delete_advancesal($this->input->post());
        if($data){
            exit(json_encode(array('status'=>TRUE)));
        } else{
            exit(json_encode(array('status'=>FALSE, 'reason'=> 'Databse Error')));
        }
    }
    function get_esi_perc()
    {
         $data = $this->Mdl_payroll->get_esi_perc();
        if($data){
            exit(json_encode(array('status'=>TRUE,'data'=>$data)));
        } else{
            exit(json_encode(array('status'=>FALSE, 'reason'=> 'Databse Error')));
        }
    }
    function get_pf_perc()
    {
        $data=$this->Mdl_payroll->get_pf_perc();
         if($data){
            exit(json_encode(array('status'=>TRUE,'data'=>$data)));
        } else{
            exit(json_encode(array('status'=>FALSE, 'reason'=> 'Databse Error')));
        }
    }
    function get_bonus_perc()
    {
        $data=$this->Mdl_payroll->get_bonus_perc();
         if($data){
            exit(json_encode(array('status'=>TRUE,'data'=>$data)));
        } else{
            exit(json_encode(array('status'=>FALSE, 'reason'=> 'Databse Error')));
        }
    }
    function salary_list()
    {
         if(has_role('view_payment')){
        $data = $this->set_menu();
        $data['salary'] = $this->Mdl_payroll->salary_details();
        $this->load->view('hr/edit_list_salary',$data);
         }
    }
    function pay_salary()
    {



                $id = $this->input->post('id');
                $qry = $this->Mdl_payroll->pay_salary($id, $this->input->post());
                if($qry)
                {
                    exit(json_encode(array('status'=>TRUE)));
                }else{
                    exit(json_encode(array('status'=>FALSE, 'reason'=>'Database Error..!')));
                }

    }
     function view_paid_payslip()
    {
          if(has_role('view_paid_slip')){
        $data = $this->set_menu();
        $data['salary'] = $this->Mdl_payroll->get_paid_salary_details();
        $this->load->view('hr/edit_list_salary_payslip',$data);
          }
    }

    function edit_salary($id,$sid)
    {
        //var_dump($sid);exit();
        $data = $this->set_menu();
        $data['employee'] = $this->Mdl_payroll->get_all_employee();
        $data['salary'] = $this->Mdl_payroll->get_salary_details_by_id($id,$sid);
        //echo json_encode($data['salary']);exit();
        $this->load->view('hr/edit_salary',$data);
    }
    function get_advsal_details_by_id()
    {
        $data = $this->Mdl_payroll->get_advsal_details_by_id();
        if($data)
        {
            exit(json_encode(array('status' =>true, 'data' => $data)));
        } else{
            exit(json_encode(array('status' =>false, 'reason' => 'No Data Found')));
        }
    }
    function payroll_update($id)
    {
         if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("empl_id","Employee Name","trim|required");
            $this->form_validation->set_rules("too","To","trim|required");
            $this->form_validation->set_rules("lvt","Total Leaves","trim|required");
            $this->form_validation->set_rules("lvr","Allowed Leaves","trim|required");
           
            if($this->form_validation->run()== TRUE)
            {
                $session_data = $this->session->userdata('logged_in_admin');
                 $cid = $session_data['id'];
                $qry = $this->Mdl_payroll->update_salary($id,$cid);
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
function delete_salary()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->Mdl_payroll->delete_salary($this->input->post());
            if($qry)
            {
                exit(json_encode(array('status'=>TRUE)));
            }else{
                exit(json_encode(array('status'=>FALSE, 'reason'=>'Database Error..!')));
            }
        }else{
            show_error("Unable To Process The Request In This Way");
        }
    }

    function generate_bill($id)
    {
        $data = $this->set_menu();

        $data['salary'] = $this->Mdl_payroll->get_bill_data_by_id($id);

        $this->load->view('hr/bill',$data);
    }

     function get_payslip_report(){


 if(has_role('view_payslip_report')){
        $data=$this->set_menu();

        

        $data['salary'] = $this->Mdl_payroll->get_salary_paid_report();



        $this->load->view('hr/view_employee_salary_payslip', $data);

 }

    }
    function get_total_allowance($salid)
    {
        $qry = "SELECT sum(u.amount_value) as ttlamount 
                FROM `erp_hr_salary_updations` u
                where u.salary_id='$salid' and u.type='EARNING' group by u.salary_id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            $data = $qry->row_array();
            return $data['ttlamount'];
        } else{
            return false;
        }
    }

    function get_total_deductions($salid)
    {
        $qry = "SELECT sum(u.amount_value) as ttlamount 
                FROM `erp_hr_salary_updations` u
                where u.salary_id='$salid' and u.type='DEDUCTION' group by u.salary_id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            $data = $qry->row_array();
            return $data['ttlamount'];
        } else{
            return false;
        }
    }

   function deduct_list_report(){

        $data=$this->set_menu();

        $data['deduct'] = $this->Mdl_payroll->get_deduct();

//        echo json_encode($data['reimburse']);exit();

        $this->load->view('hr/deduction_report', $data);

    }
function bonuses_list_report(){

        $data=$this->set_menu();

        $data['bonus'] = $this->Mdl_payroll->get_bonus();


        $this->load->view('hr/hr_bonus_report', $data);

    }

    function advance_payment_report(){

        $data=$this->set_menu();

        $data['advance'] = $this->Mdl_payroll->get_advance_salary();

        $this->load->view('hr/advancesalary_report', $data);

    }

    function pf_report(){
    $data=$this->set_menu();
    $data['pf'] = $this->Mdl_payroll->get_all_pf();
    $this->load->view('hr/pf_report', $data);

    }
    function esi_report(){
    $data=$this->set_menu();

        $data['pf'] = $this->Mdl_payroll->get_all_esi();
        $this->load->view('hr/esi_report', $data);

    }
 function advancesalary_report(){
        $data = $this->set_menu();
        $data['employees'] = $this->Mdl_payroll->get_all_employee();
        $this->load->view('hr/edit_advance_salary_report',$data);

    }
    function advance_salary_by_emp_id()
        {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("employee","Employee","trim|required");
            if($this->form_validation->run()== TRUE)
            {
                $id = $this->input->post('employee');
                $qry = $this->Mdl_payroll->advance_salary_by_emp_id($id);
                if($qry)
                {
                    exit(json_encode(array('status'=>TRUE,'data'=>$qry)));
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
    
}?>