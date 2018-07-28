<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

Class Privillage extends CI_Controller
{

    function __Construct(){

        parent:: __construct();
        $this->load->library(array('session','form_validation','pagination'));
        $this->load->model(array('admin/privillage_model','admin/Channelpartner_model'));
        $this->load->helper(array('url','form','my_common_helper'));
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array)){
            redirect('admin/Login');
        }
    }

    function font(){
        $this->load->view('admin/font');
    }
    function set_module(){
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $loginsession = $this->session->userdata('logged_in_admin');

        if($loginsession['type'] == 'super_admin'){
            $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        }else{
            $data['sidebar'] = $this->load->view('admin/templates/module_sidebar', '', true);
        }
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        return $data;
    }



    function index(){
        $data=$this->set_module();
        $data['privillage']=$this->privillage_model->get_privillage();
        $this->load->view('admin/edit_add_privillage',$data);
    }
    function dashboard(){

        $data=$this->set_module();
        //$data['my_wallet_value']=$this->Dashboard_model->get_mywallet_value();
        $this->load->view('admin/edit_module_dashboard', $data);
    }

    function set_new_privillage(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("group_name", "Group Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("access_perm[]", "Access Permission", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("allow_perm[]", "Access Permission", "trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $result=$this->privillage_model->add_privillage();
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{

                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
    }

    function new_module(){
        if (has_priv('add_services')) {
        $data=$this->set_module();

        $data['group']=$this->privillage_model->get_groupname();
        $this->load->view('admin/edit_add_module',$data);
    }
}
    function new_permission_module(){
       // var_dump($this->input->post());exit;
        if($this->input->is_ajax_request()){
        //$imageNames =  time().$_FILES[$img]['name'];var_dump($imageNames);
            $this->form_validation->set_rules("module", "Service Name" ,"trim|required|htmlspecialchars");
            $this->form_validation->set_rules("images", "Service Icon" ,"trim|required|htmlspecialchars");
            if($this->form_validation->run()==TRUE){

                $result=$this->privillage_model->set_modulle_privillage();
                if($result){
                   
                    exit(json_encode(array("status"=>true)));
                }
                else{
                    exit(json_encode(array("status"=>false, "reason"=>"Database Error")));
                }
            }

            exit(json_encode(array("status"=>false, "reason"=>validation_errors())));

        }
    }

    function new_user_privillage(){
        $data=$this->set_module();
        $data['access_priv']=$this->privillage_model->get_user_privillage();
        $data['allow_priv']=$this->privillage_model->get_user_allow_privillage();
        $this->load->view('admin/edit_add_user_privillage',$data);
    }

    function new_userpermission_module(){

        if($this->input->is_ajax_request()){

            $email=$this->input->post('email');


            $this->form_validation->set_rules("user_name", "User Name" ,"trim|required|htmlspecialchars");
            if($this->form_validation->run()==TRUE){
                $result=$this->privillage_model->set_module_userprivillage();
                if($result){

                    $email_message = $this->load->view('admin/edit_email_template_module', $result,TRUE);

                    //$ci = get_instance();
                    $this->load->library('email');
                    $config['protocol'] = "smtp";
                    $config['smtp_host'] = "ssl://smtp.gmail.com";
                    $config['smtp_port'] = "465";
                    $config['smtp_user'] = 'pranavpk.pk1@gmail.com';
                    $config['smtp_pass'] = '9544146763';
                    $config['charset'] = "utf-8";
                    $config['mailtype'] = "html";
                    $config['newline'] = "\r\n";

                    $this->email->initialize($config);
                    $this->email->from('greenindia@gmail.com', 'Green India');
                    $this->email->to($email);
                    $this->email->reply_to('no-replay@gmail.com', 'Module Login details');
                    $this->email->subject('Module Login creddentials');
                    $this->email->message($email_message);
                    $this->email->send();
                    exit(json_encode(array("status"=>true)));
                }
                else{
                    exit(json_encode(array("status"=>false, "reason"=>"Database Error")));
                }
            }

            exit(json_encode(array("status"=>false, "reason"=>validation_errors())));

        }
    }

    function new_usermodule(){
        $data=$this->set_module();
        $data['group']=$this->privillage_model->get_user_groupname();
        $this->load->view('admin/edit_add_user_module',$data);
    }

    function new_permission_usermodule(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("module", "Module Name" ,"trim|required|htmlspecialchars");
            if($this->form_validation->run()==TRUE){
                $result=$this->privillage_model->set_usermodulle_privillage();
                if($result){
                    exit(json_encode(array("status"=>true)));
                }
                else{
                    exit(json_encode(array("status"=>false, "reason"=>"Database Error")));
                }
            }

            exit(json_encode(array("status"=>false, "reason"=>validation_errors())));

        }
    }


    function get_privillege(){
        $data=$this->set_module();
        $data['group']=$this->privillage_model->get_group_list();
        $this->load->view('admin/edit_view_privillege',$data);
    }

    function delete_group($grpid){

        $result=$this->privillage_model->delete_groupbyid($grpid);
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }

    function get_group_byid($id){
        $data=$this->set_module();
        $data['all_priv']=$this->privillage_model->get_all_privillege();
        $data['privillege']=$this->privillage_model->get_privillege_by_group($id);
        $this->load->view('admin/edit_privillege_edit',$data);
    }

    function edit_new_privillage($id){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("access_perm_edit[]", "Access Permission", "trim|required|htmlspecialchars");
            //            $this->form_validation->set_rules("allow_perm[]", "Access Permission", "trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $result=$this->privillage_model->edit_privillages_by_group($id);var_dump($result);
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{

                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
    }

    function add_new_privillage($id){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("access_perm[]", "Access Permission", "trim|required|htmlspecialchars");
        //            $this->form_validation->set_rules("allow_perm[]", "Access Permission", "trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $result=$this->privillage_model->edit_add_privillages($id);
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{

                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
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
    
    function get_module(){

      if (has_priv('view_services')) {
        $data=$this->set_module();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $result_count = $this->privillage_model->get_all_module_count($param);
        $base_url = base_url() . "all_partner_types/";
        $count =  $result_count;
        $per_page = 10;
        $this->load_paging($base_url,$count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->privillage_model->get_all_module($param,$per_page, $page);
        //echo json_encode($data["data"]);exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'pagination' => $this->pagination->create_links()
            )));
        }
        
        $this->load->view('admin/edit_view_module',$data);
    }
    }
    function get_module_byid($id){
        $data=$this->set_module();
        $data['group']=$this->privillage_model->get_group_list();
        $data['modules']=$this->privillage_model->get_moduleview_byid($id);
        $this->load->view('admin/edit_view_module_edit',$data);
    }

    function edit_module_byid(){

        $this->form_validation->set_rules("module", "Module Name" ,"trim|required|htmlspecialchars");
        if($this->form_validation->run()==TRUE){
            $result=$this->privillage_model->edit_module_byid();
            if($result){
                exit(json_encode(array("status"=>TRUE)));
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
            }
        }
        else{

            exit(json_encode(array("status"=>false, "reason"=>validation_errors())));
        }
    }

    function delete_module(){

        $result=$this->privillage_model->delete_modulebyid($this->input->post());
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }

    function mail_exists()
    {
        $mail=$this->input->post('mail');
        $result = $this->Channelpartner_model->mail_exisits($mail);
        if($result == FALSE)
        {
            exit(json_encode(array('status'=> true)));
        } else{
            exit(json_encode(array('status'=> FALSE)));
        }
    }
    function group_exists()
    {
        $group=$this->input->post('group_name');
        $result = $this->privillage_model->check_group_exisits($group);
        if($result == FALSE)
        {
            exit(json_encode(array('status'=> true)));
        } else{
            exit(json_encode(array('status'=> FALSE)));
        }
    }

}
?>