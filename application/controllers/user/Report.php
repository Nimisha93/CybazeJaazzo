<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Report extends CI_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('register_model','user/user_model','user/refer_model','user/product_model','admin/Channelpartner_model','register_model','admin/Executives_model','user/Cp_model','user/Report_model'));
        $this->load->library(array('form_validation','pagination'));
        $this->load->helper(array('form', 'date','string'));
    }
    function set_menu()
    {
        $session_array1 = $this->session->userdata('logged_in_user');
        $session_array2 = $this->session->userdata('logged_in_club_member');
        $session_array3 = $this->session->userdata('logged_in_club_agent');
        
        if(isset($session_array1)){
            $login_id = $session_array1['id'];
            $userid=$session_array1['user_id'];
            $data['channel_partner'] = get_all_channel_partners();
        }
        if(isset($session_array2)){
            $login_id = $session_array2['id'];
            $userid=$session_array2['user_id'];
            $this->load->library('googlemaps');
            $config['center'] = '10.804305026919454, 76.11534118652344';
            $config['zoom'] = '8';
            $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
            $this->googlemaps->initialize($config);
            $data['map'] = $this->googlemaps->create_map();
            $data['channel_partner'] = get_all_channel_partners();
            //$data['channel_partner'] = $this->Cp_model->get_my_channel_partner($login_id);
            //$data['club_agents'] = get_my_club_members($login_id);
        }
        if(isset($session_array3)){
            $login_id = $session_array3['id'];
            $userid=$session_array3['user_id'];
        }
        $data['login_id']=$login_id;
        $data['userid']=$userid;
        if($login_id){
            return $data;
        }else{
            redirect('/');
        }
    }
    function index()
    {   
        $data = $this->set_menu();
        $login_id = $data['login_id'];
        $userid = $data['userid'];
        $data['cagents']=get_my_club_agents();
        $data['category']=$this->Cp_model->get_cpcategory();
        $data['subcategory']=$this->Cp_model->get_cpscategory();
        $data['countries'] = $this->Cp_model->get_countries();
        $data['modules'] = $this->Cp_model->get_modules();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
        $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
        $data['countries'] = $this->Cp_model->get_countries();

        $data['get_menu']=$this->product_model->get_menus();
        $data['vallet_type'] = $this->product_model->get_wallet();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
    
            $data['user']=$this->user_model->get_normal_customer($userid);
            if($data['user']['country'])
            {
                $country = $data['user']['country'];
                $data['state'] = $this->register_model->get_state_by_country($country);
            }
            $data['user_image']=$this->user_model->get_image($userid);
            $this->load->view('public/edit_my_report',$data);   
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
    function rewards_by_members()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "rewards_by_members/";
        $result_count = $this->Report_model->get_rewards_by_members_count($param);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Report_model->get_rewards_by_members_reports($param,$per_page,$page);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    }
    function rewards_by_cp()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "rewards_by_cp/";
        $result_count = $this->Report_model->get_rewards_by_cp_count($param);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Report_model->get_rewards_by_cp_reports($param,$per_page,$page);
        // echo json_encode($data["data"]);exit;
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    }
    function rewards_by_clubagents()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')!='') {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('from')||$this->input->post('to')) {
            $date1 = str_replace('/', '-', $this->input->post('from'));
            $from = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $this->input->post('to'));
            $to = date('Y-m-d', strtotime($date2));
        }else{
            $from = '';
            $to = '';
        }
        $base_url = base_url() . "rewards_by_clubagents/";
        $result_count = $this->Report_model->get_rewards_by_clubagents_count($param,$from,$to);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Report_model->get_rewards_by_clubagents_reports($param,$from,$to,$per_page,$page);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    }
    function view_cm_transaction()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')!='') {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        /*if ($this->input->post('from')||$this->input->post('to')) {
            $from = $this->input->post('from');
            $to = $this->input->post('to');
        }else{
            $from = '';
            $to = '';
        }*/
        $base_url = base_url() . "view_cm_transaction/";
        $result_count = $this->Report_model->get_cm_transaction_byid_count($param);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Report_model->get_cm_transaction_byid($param,$per_page,$page);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    }
    function get_notitfication()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')!='') {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        /*if ($this->input->post('from')||$this->input->post('to')) {
            $from = $this->input->post('from');
            $to = $this->input->post('to');
        }else{
            $from = '';
            $to = '';
        }*/
        $base_url = base_url() . "get_notitfication/";
        $result_count = $this->Report_model->get_notitfications_count($param);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Report_model->get_notitfications($param,$per_page,$page);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    }
    function get_money_transfer()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')!='') {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('from')||$this->input->post('to')) {
            $date1 = str_replace('/', '-', $this->input->post('from'));
            $from = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $this->input->post('to'));
            $to = date('Y-m-d', strtotime($date2));
        }else{
            $from = '';
            $to = '';
        }
        $base_url = base_url() . "get_money_transfer/";
        $result_count = $this->Report_model->get_money_transfer_count($param,$from,$to);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Report_model->get_money_transfer($param,$from,$to,$per_page,$page);
        
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    }
    function get_to_money_transfer()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')!='') {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('from')||$this->input->post('to')) {
            $date1 = str_replace('/', '-', $this->input->post('from'));
            $from = date('Y-m-d', strtotime($date1));
            $date2 = str_replace('/', '-', $this->input->post('to'));
            $to = date('Y-m-d', strtotime($date2));
        }else{
            $from = '';
            $to = '';
        }
        $base_url = base_url() . "get_money_transfer/";
        $result_count = $this->Report_model->get_to_money_transfer_count($param,$from,$to);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Report_model->get_to_money_transfer($param,$from,$to,$per_page,$page);
        
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    }
}