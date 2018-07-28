<?php


class Recruitment extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('hr/Mdl_recruitment','hr/Mdl_employee'));
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
    function requisitions()
    {
         if(has_role('view_recruitment_requisition')){
        $data = $this->set_menu();
        $data['requisitions'] = $this->Mdl_recruitment->getrequisitions();

        $this->load->view('hr/edit_list_hr_requisitions', $data);
         }
    }
    function new_requisitions()
    {
      if(has_role('add_recruitment_requisition')){
        $data = $this->set_menu();
        $data['employees'] = $this->Mdl_recruitment->getemployees();
      //  $data['forward'] = $this->Mdl_recruitment->get_forward();
        $data['company'] = $this->Mdl_recruitment->getcompany();
        $data['branch'] = $this->Mdl_recruitment->getstations();
        $data['quali'] = $this->Mdl_recruitment->getqualification();
        $data['department'] = $this->Mdl_recruitment->getdepartment();
        $this->load->view('hr/edit_list_hr_requisitions_add', $data);
      }
    }
    function new_qualification()
    {
      
        if ($this->input->is_ajax_request()) {

        $result=$this->Mdl_recruitment->add_qualification();
        if($result)
        {
            $qual=$this->Mdl_recruitment->getqualification();
            exit(json_encode(array('status'=>true,'data'=>$qual)));
           
        }
        else

        {
           exit(json_encode(array('status'=>false,'reason'=>"Database error")));
        }
        }
        else {
            show_error("We are unable to process this request on this way!");
        }

    }
     function check_equal_less($second_field) 

        {
         $first_field = $this->input->post('salary_st');
         if ($second_field <= $first_field) { 
        return false; }
         else { return true; } 
        }
        function check_equal_less1($second_field) 

        {
            //var_dump($second_field);var_dump($first_field);exit();
         $first_field = $this->input->post('age_st');
         if ($second_field <= $first_field) { 
        return false; }
         else { return true; } 
        }
 function add_new_requisition()
    {
        if ($this->input->is_ajax_request()) {
//			$this->form_validation->set_rules("forward","Forward to","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("branch", "Branch", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("dep", "Department", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("title", "Job Title", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("type", "Job Type", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("posts", "Job Posts", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("location", "Job Location", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("age_st", "Age starting", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("age_en", "Age Ending", "trim|required|callback_check_equal_less1");
             
            $this->form_validation->set_rules("salary_st","Salary Range Start","trim|required");
            $this->form_validation->set_rules("salary_en","Salary Range End", 
                "trim|required|callback_check_equal_less");
            $this->form_validation->set_message('check_equal_less', 'The starting salary exceeds ending salary.'); 
            $this->form_validation->set_message('check_equal_less1', 'The starting age exceeds ending age.'); 
            $this->form_validation->set_rules("qual", "Qualification", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("exp", "Experience", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("desp", "Description", "trim|required|htmlspecialchars");
            if ($this->form_validation->run() == TRUE) {
                $result = $this->Mdl_recruitment->new_requisition();
                if ($result) {
                    exit(json_encode(array("status" => TRUE)));
                } else {
                    exit(json_encode(array("status" => FALSE, "reason" => 'Database Error')));
                }
            } else {
                exit(json_encode(array("status" => FALSE, "reason" => validation_errors())));
            }
        } else {
            show_error("We are unable to process this request on this way!");
        }
    }

    function edit_requisition($id){
     if(has_role('edit_recruitment_requisition')){
        $data = $this->set_menu();
         $data['employees'] = $this->Mdl_recruitment->getemployees();
        // $data['forward'] = $this->Mdl_recruitment->get_forward();
         $data['company'] = $this->Mdl_recruitment->getcompany();
         $data['branch'] = $this->Mdl_recruitment->getstations();
         $data['quali'] = $this->Mdl_recruitment->getqualification();
         $data['department'] = $this->Mdl_recruitment->getdepartment();
         $data['requisitions'] = $this->Mdl_recruitment->get_requisitions_by_id($id);
        $this->load->view('hr/edit_hr_requisitions', $data);
     }
    }

 function update_requisition(){

        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules("branch", "Branch", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("dep", "Department", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("title", "Job Title", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("type", "Job Type", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("posts", "Job Posts", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("location", "Job Location", "trim|required|htmlspecialchars");
            // $this->form_validation->set_rules("age_st", "Age starting", "trim|required|htmlspecialchars");
            // $this->form_validation->set_rules("age_en", "Age Ending", "trim|required|htmlspecialchars");
            // $this->form_validation->set_rules("salary_st", "Salary Starting", "trim|required|htmlspecialchars");
            // $this->form_validation->set_rules("salary_en", "Salary Ending", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("age_st", "Age starting", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("age_en", "Age Ending", "trim|required|callback_check_equal_less1");
             
            $this->form_validation->set_rules("salary_st","Salary Range Start","trim|required");
            $this->form_validation->set_rules("salary_en","Salary Range End", 
                "trim|required|callback_check_equal_less");
            $this->form_validation->set_message('check_equal_less', 'The starting salary exceeds ending salary.'); 
            $this->form_validation->set_message('check_equal_less1', 'The starting age exceeds ending age.'); 
            $this->form_validation->set_rules("qual", "Qualification", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("exp", "Experience", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("desp", "Description", "trim|required|htmlspecialchars");

            if ($this->form_validation->run() == TRUE) {
                $result = $this->Mdl_recruitment->update_requisition();
                if ($result) {
                    exit(json_encode(array("status" => TRUE)));
                } else {
                    exit(json_encode(array("status" => FALSE, "reason" => 'Database Error')));
                }
            } else {
                exit(json_encode(array("status" => FALSE, "reason" => validation_errors())));
            }
        } else {
            show_error("We are unable to process this request on this way!");
        }
    }
    function new_posts_copy($id)
    {
        $data = $this->set_menu();
        $data['requisitions'] = $this->Mdl_recruitment->getreqbyid($id);

        $data['branches'] = $this->Mdl_recruitment->getstations();
        $data['quali'] = $this->Mdl_recruitment->getqualification();
        //var_dump($data['quali']);exit();
        $data['department'] = $this->Mdl_recruitment->getdepartment();
        $this->load->view('hr/edit_list_hr_posts_copy', $data);
    }

     function add_new_post()
    {
      if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules("title", "Job Title", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("type", "Job Type", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("posts", "No: Posts", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("branch", "Branch", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("closing", "Closing Date", "trim|required|htmlspecialchars");
            // $this->form_validation->set_rules("age_st", "Age starting", "trim|required|htmlspecialchars");
            // $this->form_validation->set_rules("age_en", "Age Ending", "trim|required|htmlspecialchars");
            // $this->form_validation->set_rules("salary_st", "Salary Starting", "trim|required|htmlspecialchars");
            // $this->form_validation->set_rules("salary_en", "Salary Ending", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("age_st", "Age starting", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("age_en", "Age Ending", "trim|required|callback_check_equal_less1");
             
            $this->form_validation->set_rules("salary_st","Salary Range Start","trim|required");
            $this->form_validation->set_rules("salary_en","Salary Range End", 
                "trim|required|callback_check_equal_less");
            $this->form_validation->set_message('check_equal_less', 'The starting salary exceeds ending salary.'); 
            $this->form_validation->set_message('check_equal_less1', 'The starting age exceeds ending age.'); 
            $this->form_validation->set_rules("qual", "Qualification", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("exp", "Experience", "trim|required|htmlspecialchars");
            

            if ($this->form_validation->run() == TRUE) {

                $result = $this->Mdl_recruitment->new_post();
                if ($result) {

                exit(json_encode(array("status" => TRUE)));
                } else {
                    exit(json_encode(array("status" => FALSE, "reason" => 'Database Error')));
                }
            }
            else {
                exit(json_encode(array("status" => FALSE, "reason" => validation_errors())));
            }
        } else {
            show_error("We are unable to process this request on this way!");
        }


    }
    function posts()
    {
         if(has_role('view_posts')){
        $data = $this->set_menu();
        $data['posts'] = $this->Mdl_recruitment->getposts();
      

        $this->load->view('hr/edit_list_hr_posts', $data);
         }
    }

      function new_posts()
    {
             if(has_role('add_posts')){

        $data = $this->set_menu();
        $data['branches'] = $this->Mdl_recruitment->getstations();
        $data['department'] = $this->Mdl_recruitment->getdepartment();
        $data['quali'] = $this->Mdl_recruitment->getqualification();
        $this->load->view('hr/edit_list_hr_posts_add', $data);
              }
    }
     function posts_edit($id)
    {
          if(has_role('edit_posts')){
        $data = $this->set_menu();
        $data['posts'] = $this->Mdl_recruitment->getpostbyid($id);
        $data['branches'] = $this->Mdl_recruitment->getstations();
        $data['department'] = $this->Mdl_recruitment->getdepartment();
        $data['quali'] = $this->Mdl_recruitment->getqualification();
        $this->load->view('hr/edit_list_hr_posts_edit', $data);
          }
    }
     function add_edit_post()
    {
        if ($this->input->is_ajax_request()) {

            $this->form_validation->set_rules("title", "Job Title", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("type", "Job Type", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("posts", "No: Posts", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("branch", "Branch", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("closing", "Closing Date", "trim|required|htmlspecialchars");
            //$this->form_validation->set_rules("age_st", "Age starting", "trim|required|htmlspecialchars");
            //$this->form_validation->set_rules("age_en", "Age Ending", "trim|required|htmlspecialchars");
            //$this->form_validation->set_rules("salary_st", "Salary Starting", "trim|required|htmlspecialchars");
            //$this->form_validation->set_rules("salary_en", "Salary Ending", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("age_st", "Age starting", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("age_en", "Age Ending", "trim|required|callback_check_equal_less1");
             
            $this->form_validation->set_rules("salary_st","Salary Range Start","trim|required");
            $this->form_validation->set_rules("salary_en","Salary Range End", 
                "trim|required|callback_check_equal_less");
            $this->form_validation->set_message('check_equal_less', 'The starting salary exceeds ending salary.'); 
            $this->form_validation->set_message('check_equal_less1', 'The starting age exceeds ending age.');
            $this->form_validation->set_rules("qual", "Qualification", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("exp", "Experience", "trim|required|htmlspecialchars");

            if ($this->form_validation->run() == TRUE) {

                $id = $this->input->post('po_id');

                $result = $this->Mdl_recruitment->edit_post($id);
                if ($result) {
                    exit(json_encode(array("status" => TRUE)));
                } else {
                    exit(json_encode(array("status" => FALSE, "reason" => 'Database Error')));
                }
           }
            else {
                exit(json_encode(array("status" => FALSE, "reason" => validation_errors())));
            }
        } else {
            show_error("We are unable to process this request on this way!");
        }
    }

    function posts_status()
    {
        $data = $this->set_menu();
        $id = $this->input->post('pos_id');
        $stat = $this->input->post('status');
        $result=$this->Mdl_recruitment->statuspostbyid($id, $stat);
       
         if ($result) {
            exit(json_encode(array("status" => TRUE)));
          } else {
            exit(json_encode(array("status" => FALSE, "reason" => 'Failed to update status')));
         }
    }
     function posts_delete()
    {
        $data = $this->set_menu();
        $del = $this->Mdl_recruitment->deletepostbyid($this->input->post());
        if ($del) {
            exit(json_encode(array("status" => TRUE)));
        } else {
            exit(json_encode(array("status" => FALSE, "reason" => 'Database Error')));
        }
    }
    function candidates()
    {
         if(has_role('view_candidates')){
        $data = $this->set_menu();
        $data['candids'] = $this->Mdl_recruitment->getcandidates();
        $this->load->view('hr/edit_list_hr_candids', $data);
         }
    }

    function new_candids()
    {
         if(has_role('add_candidates')){
        $data = $this->set_menu();
        $data['job'] = $this->Mdl_recruitment->getjob();
        $data['quali'] = $this->Mdl_recruitment->getqualification();
        $this->load->view('hr/edit_list_hr_candids_add', $data);
         }
    }
    public function unique_email($str)
    {    
        $row = $this->db->select("COUNT(*) AS dupe")->where('email',$str)->where('is_del',0)->get('hr_candids')->row();
       
        return ($row->dupe > 0) ? FALSE : TRUE;
    }
    public function unique_phone($str)
    {    
        $row = $this->db->select("COUNT(*) AS dupe")->where('phone',$str)->where('is_del',0)->get('hr_candids')->row();
       
        return ($row->dupe > 0) ? FALSE : TRUE;
    }
    function add_new_candid()
    {
        
     if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules("title", "Job Title", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("name", "Candidate Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("dob", "Candidate DOB", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("gender", "Candidate Gender", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("email", "Candidate Email", "trim|required|htmlspecialchars|valid_email|callback_unique_email");
            $this->form_validation->set_rules("phone", "Candidate Phone", "trim|required|htmlspecialchars|numeric|callback_unique_phone");
            $this->form_validation->set_message('unique_email', 'The %s is already exist');
            $this->form_validation->set_message('unique_phone', 'The %s is already exist');
            $this->form_validation->set_rules("address", "Candidate Address", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pin", "Address Pin", "trim|required|htmlspecialchars|numeric|exact_length[6]");
            $this->form_validation->set_rules("qual", "Qualification", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("exp", "Experience", "trim|required|htmlspecialchars");
            if ($this->form_validation->run() == TRUE) {
                $result = $this->Mdl_recruitment->new_candid();
                if ($result) {
                    exit(json_encode(array("status" => TRUE)));
                } else {
                    exit(json_encode(array("status" => FALSE, "reason" => 'Database Error')));
                }
                } else {
                exit(json_encode(array("status" => FALSE, "reason" => validation_errors())));
            }
        } else {
            show_error("We are unable to process this request on this way!");
        }

    }
    function update_status_candidates($id){
    
         if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("status","Status","trim|required|htmlspecialchars");

            if( $this->form_validation->run() == TRUE )

            {

                $data = $this->Mdl_recruitment->update_candid_Status($id);

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
    function candids_shortlist()
    {
        $data = $this->set_menu();
        $id = $this->input->post('cnd_id');
        $result = $this->Mdl_recruitment->candid_shortlist($id);
                if ($result) {
                    exit(json_encode(array("status" => TRUE)));
                } else {
                    exit(json_encode(array("status" => FALSE, "reason" => 'Database Error')));
                }

    }
     function edit_candidate($id)
    {
          if(has_role('edit_candidates')){
        $data = $this->set_menu();
        $data['candid'] = $this->Mdl_recruitment->edit_candidate($id);
        $data['job'] = $this->Mdl_recruitment->getjob();
         
        $data['quali'] = $this->Mdl_recruitment->getqualification();
        $this->load->view('hr/edit_list_hr_candids_edit', $data);
          }
    }
    function edit_new_candid($id)
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules("title", "Job Title", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("name", "Candidate Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("dob", "Candidate DOB", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("gender", "Candidate Gender", "trim|required|htmlspecialchars");
            $email = $this->input->post('email');$email_old = $this->input->post('email_old');
            $phone = $this->input->post('phone');$phone_old = $this->input->post('phone_old');
            if($email == $email_old){
               $this->form_validation->set_rules("email", "Candidate Email", "trim|required|htmlspecialchars|valid_email"); 
            }else{
                $this->form_validation->set_rules("email", "Candidate Email", "trim|required|htmlspecialchars|valid_email|callback_unique_email");
            }
            if($phone == $phone_old){
                $this->form_validation->set_rules("phone", "Candidate Phone", "trim|required|htmlspecialchars"); 
            }else{
                $this->form_validation->set_rules("phone", "Candidate Phone", "trim|required|htmlspecialchars|numeric|callback_unique_phone");
            }
            $this->form_validation->set_message('unique_email', 'The %s is already exist');
            $this->form_validation->set_message('unique_phone', 'The %s is already exist');
            $this->form_validation->set_rules("address", "Candidate Address", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pin", "Address Pin", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("qual", "Qualification", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("exp", "Experience", "trim|required|htmlspecialchars");
            if ($this->form_validation->run() == TRUE) {
                $result = $this->Mdl_recruitment->edit_candid_by_id($id);
                if ($result) {
                    exit(json_encode(array("status" => TRUE)));
                } else {
                    exit(json_encode(array("status" => FALSE, "reason" => 'Database Error')));
                }
            } else {
                exit(json_encode(array("status" => FALSE, "reason" => validation_errors())));
            }
        } else {
            show_error("We are unable to process this request on this way!");
        }
    }

    function candids_delete()
    {
        $data = $this->set_menu();
        $del = $this->Mdl_recruitment->candid_delete($this->input->post());
        if ($del) {
            exit(json_encode(array("status" => TRUE)));
        } else {
            exit(json_encode(array("status" => FALSE, "reason" => 'Database Error')));
        }
    }
    function shortlists()
    {
        if(has_role('view_shortlist')){
        $data = $this->set_menu();
        $data['shortlists'] = $this->Mdl_recruitment->getshortlists();
        $this->load->view('hr/edit_list_hr_shortlists', $data);
        }
    }
    function candids_change_status()
    {
        $id = $this->input->post('shl_id');
        $po_id = $this->input->post('po_id');
        $shortlists = $this->input->post('shortlists');
        $posts = $this->input->post('posts');
        $data = $this->set_menu();
        $result = $this->Mdl_recruitment->candids_change_status($id,$po_id,$shortlists,$posts);
        if ($result) {
            exit(json_encode(array("status" => TRUE)));
        } else {
            exit(json_encode(array("status" => FALSE, "reason" => 'Database Error')));
        }
    }
    function candids_select()
    {
        $id = $this->input->post('shl_id');
        $po_id = $this->input->post('po_id');
        $posts = $this->input->post('posts');
        $data = $this->set_menu();
        $result = $this->Mdl_recruitment->candid_select($id,$po_id,$posts);
        if ($result) {
            exit(json_encode(array("status" => TRUE)));
        } else {
            exit(json_encode(array("status" => FALSE, "reason" => 'Database Error')));
        }
        

    }
    function selected()
    {
         if(has_role('view_selected')){
        $data = $this->set_menu();
        $data['selected'] = $this->Mdl_recruitment->getselected();
        $this->load->view('hr/edit_list_hr_selected', $data);
         }
    }

   

    function deleterequisition()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->Mdl_recruitment->deleterequisition($this->input->post());
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
   function get_all_requisition_report()
    {
       if(has_role('view_recruitment_report')){
        $data = $this->set_menu();
        $data['requisitions'] = $this->Mdl_recruitment->getrequisitionss();
        $this->load->view('hr/edit_list_hr_requisitions_report', $data);
    }

    }
    function get_all_post_report()
    {
        if(has_role('view_post_report')){
        $data = $this->set_menu();
        $data['posts'] = $this->Mdl_recruitment->getposts();
        $this->load->view('hr/edit_list_hr_posts_reports', $data);
    }
    }
    function get_all_candid_report()
    {
        if(has_role('view_candidate_report')){
        $data = $this->set_menu();
        $data['candids'] = $this->Mdl_recruitment->getcandids();
        $this->load->view('hr/edit_list_hr_candids_report', $data);
    }
    }
    function get_all_shortlist_report()
    {
        if(has_role('view_shortlist_report')){
        $data = $this->set_menu();
        $data['shortlists'] = $this->Mdl_recruitment->getshortlists();
        $this->load->view('hr/edit_list_hr_shortlists_report', $data);
    }
}
    function get_all_selected_report()
    {
        if(has_role('view_shortlist_report')){
        $data = $this->set_menu();
        $data['selected'] = $this->Mdl_recruitment->get_new_selected();
        $this->load->view('hr/edit_list_hr_selected_add_report', $data);
    }
    }
function emp_join($id){

        $data=$this->set_menu();
        $data['branch']= $this->Mdl_employee->get_all_branch();
        $data['departments']= $this->Mdl_employee->get_all_departments();
        $data['cand'] = $this->Mdl_recruitment->get_candid_emp($id);
        //print_r($data['cand']);exit();
        $this->load->view('hr/edit_add_selected_employee', $data);
       }
    function add_candidates()
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

            $this->form_validation->set_rules("address","Address","trim|required");
            $this->form_validation->set_rules("ta","TA","trim|required|numeric");
            $this->form_validation->set_rules("da","DA","trim|required|numeric");
            $this->form_validation->set_rules("hra","HRA","trim|required|numeric");

            if($this->form_validation->run()== TRUE)
            {
                $session_data = $this->session->userdata('logged_in_admin');
                $id = $session_data['id'];


                $qry = $this->Mdl_recruitment->add_candidates($id);
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
    function cron()
    {
         $this->Mdl_recruitment->get_birthday();
    }
}?>