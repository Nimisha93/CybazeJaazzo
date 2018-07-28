<?php
defined('BASEPATH') OR exit('No direct script access allowed');
Class Privilleges extends CI_Controller
{

    function __Construct(){
        parent:: __construct();
        $this->load->library(array('session','form_validation','pagination'));
        $this->load->model(array('admin/privillages_model','accounts/mdl_entries'));
        $this->load->helper(array('url','form','my_common_helper'));
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array)){
            redirect('admin/Login');
        }
    }
    function set_menu()
    {
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        return $data;
    }

    public function load_paging($base_url,$count,$per_page)
    {
        $config = array();
        $config["base_url"] = $base_url;
        $config["total_rows"] =  $count;
        $config["per_page"] = $per_page;
        //pagination customization using bootstrap styles
        $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
        $config['full_tag_close'] = '</ul></div><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
    }
    //list privilages
    function list_privilages()
    {
        if (has_priv('manage_privilege')) {
            $data = $this->set_menu();
            $data['privilage']=$this->privillages_model->get_privillage();
            $data['privilage_des']=$this->privillages_model->get_privillage_desg();
            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $base_url = base_url() . "privillages/";
            $result_count = $this->privillages_model->get_all_privillages_count($param);
            $per_page = 10;
            $this->load_paging($base_url,$result_count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data["data"] = $this->privillages_model->get_all_privillages($param,$per_page,$page);
            if ($this->input->post('ajax', FALSE)) {
                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'status' => !empty($data["data"])?1:0,
                    'pagination' => $this->pagination->create_links()
                )));
            }
            $this->load->view('admin/edit_list_privillages',$data);
        }
    }

    function list_member_privilages()
    {
        if (has_priv('manage_privilege')) {
            $data = $this->set_menu();
            $data['privilage_grp']=$this->privillages_model->get_privillage_groups();
            $data['employee']=$this->privillages_model->get_employees();
                    // $data['privilage']=$this->privillages_model->get_privillage_members();
            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $base_url = base_url() . "privillages/";
            $result_count = $this->privillages_model->get_all_member_count($param);
            $per_page = 10;
            $this->load_paging($base_url,$result_count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data["data"] = $this->privillages_model->get_all_member_privillages($param,$per_page,$page);
            if ($this->input->post('ajax', FALSE)) {
                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'status' => !empty($data["data"])?1:0,
                    'pagination' => $this->pagination->create_links()
                )));
            }
            $this->load->view('admin/edit_list_privillege_members',$data);
        }
    }

    function list_des_privilege_members()
    {
        if (has_priv('manage_privilege')) {
            $data = $this->set_menu();
            $data['privilage_grp']=$this->privillages_model->get_privillage_groups_desig();
            $data['employee']=$this->privillages_model->get_designation_type();
                // $data['privilage']=$this->privillages_model->get_privillage_members();

            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $base_url = base_url() . "privillages/";
            $result_count = $this->privillages_model->get_all_desg_member_count($param);
            $per_page = 10;
            $this->load_paging($base_url,$result_count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data["data"] = $this->privillages_model->get_all_desg_member_privillages($param,$per_page,$page);
            if ($this->input->post('ajax', FALSE)) {
                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'status' => !empty($data["data"])?1:0,
                    'pagination' => $this->pagination->create_links()
                )));
            }
            $this->load->view('admin/edit_list_des_prv_members',$data);
        }
    }

    //Add Privilege
    function add_privilege()
    {
        if (has_priv('manage_privilege')) {
            if($this->input->is_ajax_request()){
                $this->form_validation->set_rules("group_name", "Group Name", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("access_perm[]", "Access Permission", "trim|required|htmlspecialchars");
                if($this->form_validation->run()== TRUE){
                    $result=$this->privillages_model->add_privillage();
                    if($result){
                        exit(json_encode(array("status"=>TRUE)));
                    }
                    else{
                        exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                    }
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
                }
            }
        }
    }

    function add_prv_members()
    {
        if (has_priv('manage_privilege')) {
            if($this->input->is_ajax_request()){
                $this->form_validation->set_rules("prv_grp", "Group Name", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("prv_memb[]", "Members", "trim|required|htmlspecialchars");
                if($this->form_validation->run()== TRUE){
                    $result=$this->privillages_model->add_privillage_members();
                    if($result){
                        $emp=$this->input->post('prv_memb');
                        foreach ($emp as $key => $emp_id) {
                            $qry="select * from hr_employee where id='$emp_id' ";
                            $query=$this->db->query($qry);
                            if($query->num_rows()>0){
                                $emp=$query->row_array();
                                $emp_email=$emp['email'];
                                 $mobile=$emp['mobile'];
                            }
                            else{
                                $emp=array();
                            }
                            if($mobile)
                            {

                                $logindata=array(
                                    'email'=>$emp_email,
                                    'mobile'=>$mobile,
                                    'otp_status' => 1,
                                    'user_id'=>$emp_id,
                                    'type'=>"Employee"
                                );
                                $user=$this->db->insert('gp_login_table',$logindata);
                                $insert_id=$this->db->insert_id();
                                $data['id'] =  $insert_id;
                                $email = $emp_email;
                                $mail_head = 'Message From Jaazzo';
                                //echo $mail_head;exit();
                                $status = send_custom_email($email, $mail_head, $emp_email, 'Set Your Password', $this->load->view('templates/public/mail/privilege_login', $data,TRUE));
                            }
                        }
                        exit(json_encode(array("status"=>TRUE)));
                    }else{
                        exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                    }
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
                }
            }
        }
    }

    function set_login_password($id)
    {
        // $otp =  encrypt_decrypt('decrypt',$otp);
        $id = $id;
        $data['id']=$id;
        $data['details'] = get_details_by_loginid($id);
        // $data['details'] = $this->register_model->get_ca_details($id);
        // $data['category']=$this->product_model->get_cpcategory();
        // $data['subcategory']=$this->product_model->get_cpscategory();
        // $data['subcptype']=$this->product_model->get_subcptype();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_ca_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/edit_set_privilege_psw",$data);
    }

    function add_design_prv_members()
    {
        if (has_priv('manage_privilege')) {
            if($this->input->is_ajax_request()){
                $this->form_validation->set_rules("prv_grp", "Group Name", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("prv_memb[]", "Members", "trim|required|htmlspecialchars");
                if($this->form_validation->run()== TRUE){
                    $result=$this->privillages_model->add_design_prv_members();
                    if($result){
                        exit(json_encode(array("status"=>TRUE)));
                    }else{
                        exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                    }
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
                }
            }
        }
    }
    function edit_member_by_id($id)
    {
        if (has_priv('manage_privilege')) {
            $data = $this->set_menu();
            $data['privilage_grp']=$this->privillages_model->get_privillage_groups();
            $data['employee']=$this->privillages_model->get_employees();
            $data['privilage']=$this->privillages_model->get_member_by_id($id);
            //echo json_encode($data['privilage']);exit();
            // $data['all_privilage']=$this->privillages_model->get_privillage();
            $this->load->view('admin/edit_privilege_member_edit',$data);
        }
    }
    function edit_desg_member_by_id($id)
    {
        if (has_priv('manage_privilege')) {
            $data = $this->set_menu();
            $data['privilage_grp']=$this->privillages_model->get_privillage_groups();
            $data['employee']=$this->privillages_model->get_designation_type();
            $data['privilage']=$this->privillages_model->get_desg_member_by_id($id);
            //echo json_encode($data['privilage']);exit();
            // $data['all_privilage']=$this->privillages_model->get_privillage();
            $this->load->view('admin/edit_privilege_design_member_edit',$data);
        }
    }
    function update_prv_members()
    {
        if (has_priv('manage_privilege')) {
            if($this->input->is_ajax_request()){
                $this->form_validation->set_rules("prv_members[]", "Members", "trim|required|htmlspecialchars");
                // $this->form_validation->set_rules("prv_memb", "Members", "trim|required|htmlspecialchars");
                if($this->form_validation->run()== TRUE){
                    $result=$this->privillages_model->edit_privillage_members();
                    if($result){
                        exit(json_encode(array("status"=>TRUE)));
                    }
                    else{
                        exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                    }
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
                }
            }
        }
    }
    function update_prv_designation_members()
    {
        if (has_priv('manage_privilege')) {
            if($this->input->is_ajax_request()){
                $this->form_validation->set_rules("prv_members[]", "Members", "trim|required|htmlspecialchars");
                // $this->form_validation->set_rules("prv_memb", "Members", "trim|required|htmlspecialchars");
                if($this->form_validation->run()== TRUE){
                    $result=$this->privillages_model->edit_desig_privillage_members();
                    if($result){
                        exit(json_encode(array("status"=>TRUE)));
                    }
                    else{
                        exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                    }
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
                }
            }
        }
    }
    //Delete Privilages
    function delete_privilages()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->privillages_model->delete_privilages($this->input->post());
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
    function delete_privilage_user()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->privillages_model->delete_privilage_user($this->input->post());
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
    //Edit View Privlage
    function edit_privilage_by_id($id)
    {
        if (has_priv('manage_privilege')) {
            $data = $this->set_menu();
            $data['privilage']=$this->privillages_model->get_privillege_by_group($id);
            $data['all_privilage']=$this->privillages_model->get_privillage();
            // echo json_encode($data['all_privilage']);exit();
            $data['all_privilage_des']=$this->privillages_model->get_privillage_desg();
            $this->load->view('admin/edit_privilege_details',$data);
        }
    }
    //Update Privilage
    function update_privilege()
    {
        if (has_priv('manage_privilege')) {
            if($this->input->is_ajax_request()){
                $this->form_validation->set_rules("group_name", "Group Name", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("access_perm[]", "Access Permission", "trim|required|htmlspecialchars");
                if($this->form_validation->run()== TRUE){
                    $result=$this->privillages_model->update_privilege();
                    if($result){
                        exit(json_encode(array("status"=>TRUE)));
                    }
                    else{
                        exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                    }
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
                }
            }
        }
    }
    function set_new_password()
    {
        $this->form_validation->set_rules("password","Password","trim|required");
        $this->form_validation->set_rules("cpassword","Confirm Password","trim|required|matches[password]");
        if( $this->form_validation->run() === true ){
            $id = $this->input->post('log_id');
            $l_password = $this->input->post('password');
            $password =encrypt_decrypt('encrypt',$this->input->post('password'));
            $data_input = array('password'=>$password,'otp_status'=>0);
            $where = array('id'=>$id);
            $res = update_tbl('gp_login_table',$data_input,$where);
            if($res)
            {
                echo(json_encode(array('status'=>TRUE,'data'=>"Password Successfully Updated")));
            }else{
                exit(json_encode(array('status'=>FALSE,'reason'=>"Password Cannot Updated")));
            }
        } else{      
            exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));      
        }
    }
    function get_entries()
    {
        // if (has_role('manage_entries')) {

        //   $data=$this->set_menu();
        //     $data['entries'] = $this->mdl_entries->get_entries();
        //     // $data['en_number'] = $this->mdl_entries->create_entry_no();
        //     // $data['groups'] = $this->mdl_entries->get_acc_type_group_ledger();
        //     // $data['countries'] =get_countries();

        //     $this->load->view('accounts/edit_list_entries', $data);
        // }
        if (has_priv('manage_entries')) {
            $data = $this->set_menu();
            // echo json_encode($data);exit();
            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $base_url = base_url() . "entries1/";
            $result_count = $this->mdl_entries->get_entries_count($param);
            $per_page = 10;
            $this->load_paging($base_url,$result_count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data["data"] = $this->mdl_entries->get_entries($param,$per_page,$page);
            if ($this->input->post('ajax', FALSE)) {
                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'status' => !empty($data["data"])?1:0,
                    'pagination' => $this->pagination->create_links()
                )));
            }
            $this->load->view('accounts/edit_list_entries',$data);
        }
    }
}
?>