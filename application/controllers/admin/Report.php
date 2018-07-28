<?php
defined('BASEPATH') OR exit('No direct script access allowed');
 //desigination report hridya
Class Report extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('session','form_validation','pagination'));
        $this->load->helper(array('url','form','string'));
        $this->load->model(array('admin/Report_model','admin/Channelpartner_model'));
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
    function designation()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "designation_report/";
        $result_count = $this->Report_model->get_all_desigination_count($param);
        $status =($result_count==0)?0:1;
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Report_model->get_desigination_reports($param,$per_page,$page);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => $status,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/desigination_report',$data);
    }
    function print_designation_report()
    {
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $data["data"] = $this->Report_model->get_desigination_reports($param);
        exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1
            )));
    }
    function club_type()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "clubtype_report/";
        $result_count = $this->Report_model->get_club_types_count($param);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Report_model->get_club_types($param,$per_page, $page);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/clubtype_report',$data);
    }
    function print_club_type_report()
    {
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $data["data"] = $this->Report_model->get_club_types($param);
        exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1
            )));
    }
    function channelpartner()
    {
        $data=$this->set_menu();
        //$data['channel']=$this->Report_model->get_channelpartner_reports();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('type')) {
            $type = $this->input->post('type');
        }else{
            $type = '';
        }
        $base_url = base_url() . "channel_partner_report/";
        $result_count = $this->Report_model->get_channel_partner_count($param,$type);
        $status =($result_count==0)?0:1;
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Report_model->get_channel_partners($param,$type,$per_page,$page);
        $data['category'] =$this->Channelpartner_model->get_cpcategory();
        $data['subcategory']=$this->Channelpartner_model->get_cpscategory();
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'category'=>$data['category'],
                'subcategory'=>$data['subcategory'],
                'search'=>$param,
                'status' =>$status,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/channelpartner_report',$data);
    }
    function print_channel_partner_report(){
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('type')) {
            $type = $this->input->post('type');
        }else{
            $type = '';
        }
        $data["data"] = $this->Report_model->get_channel_partners($param,$type);
        exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1
            )));
    }
    function cm_channelpartners(){
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('club_type')) {
            $club_type = $this->input->post('club_type');
        }else{
            $club_type = '';
        }
        $base_url = base_url() . "cm_channelpartners/";
        $result_count = $this->Report_model->get_cm_channelpartners_count($param,$club_type);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Report_model->get_cm_channelpartners($param,$club_type,$per_page, $page);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'club_type'=>$club_type,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/cm_channel_partner_report',$data);
    }
    function print_cm_channelpartners_report(){
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('club_type')) {
            $type = $this->input->post('club_type');
        }else{
            $type = '';
        }
        $data["data"] = $this->Report_model->get_cm_channelpartners($param,$type);
        exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'club_type'=>$type,
                'status' => 1
            )));
    }
    function exe_channelpartners()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        
        $base_url = base_url() . "exe_channelpartners/";
        $result_count = $this->Report_model->get_exe_channelpartners_count($param);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Report_model->get_exe_channelpartners($param,$per_page, $page);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/exe_channel_partner_report',$data);
    }
    function print_exe_channelpartners_report(){
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $data["data"] = $this->Report_model->get_exe_channelpartners($param);
        exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1
            )));
    }
    function admin_channelpartners()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        
        $base_url = base_url() . "admin_channelpartners/";
        $result_count = $this->Report_model->get_admin_channelpartners_count($param);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Report_model->get_admin_channelpartners($param,$per_page, $page);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/admin_channel_partner_report',$data);
    }
    function print_admin_channelpartners_report(){
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $data["data"] = $this->Report_model->get_admin_channelpartners($param);
        exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1
            )));
    }
    function club_members_by_type_report()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('club_type')) {
            $club_type = $this->input->post('club_type');
        }else{
            $club_type = '';
        }
        $base_url = base_url() . "club_members_by_type/";
        $result_count = $this->Report_model->get_club_members_by_type_count($param,$club_type);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Report_model->get_club_members_by_type($param,$club_type,$per_page, $page);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'club_type'=>$club_type,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/clubmembers_by_type_report',$data);
    }
    function print_cm_by_type_report(){
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('club_type')) {
            $type = $this->input->post('club_type');
        }else{
            $type = '';
        }
        $data["data"] = $this->Report_model->get_club_members_by_type($param,$type);
        exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'club_type'=>$type,
                'status' => 1
            )));
    }
    function club_members_by_report()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('by')) {
            $by = $this->input->post('by');
        }else{
            $by = '';
        }
        $base_url = base_url() . "club_members_by/";
        $result_count = $this->Report_model->get_club_members_by_count($param,$by);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Report_model->get_club_members_by($param,$by,$per_page, $page);
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'by'=>$by,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/clubmembers_by_report',$data);
    }
    function print_club_members_by_report(){
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('by')) {
            $by = $this->input->post('by');
        }else{
            $by = '';
        }
        $data["data"] = $this->Report_model->get_club_members_by($param,$by);
        exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'by'=>$by,
                'status' => 1
            )));
    }
    function customers_report()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('by')) {
            $by = $this->input->post('by');
        }else{
            $by = '';
        }
        $base_url = base_url() . "customers_report/";
        $result_count = $this->Report_model->get_customers_by_count($param,$by);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Report_model->get_customers($param,$by,$per_page, $page);
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'by'=>$by,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/customer_report',$data);
    }
    function print_normal_customers_by_report(){
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('by')) {
            $by = $this->input->post('by');
        }else{
            $by = '';
        }
        $data["data"] = $this->Report_model->get_customers($param,$by);
        exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'by'=>$by,
                'status' => 1
            )));
    }
    function clubagents_report()
    {
       $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('by')) {
            $by = $this->input->post('by');
        }else{
            $by = '';
        }
        $base_url = base_url() . "clubagents_report/";
        $result_count = $this->Report_model->get_clubagents_by_count($param,$by);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Report_model->get_clubagents($param,$by,$per_page, $page);
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'by'=>$by,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/clubagents_report',$data); 
    }
    function print_club_agents_by_report()
    {
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('by')) {
            $by = $this->input->post('by');
        }else{
            $by = '';
        }
        $data["data"] = $this->Report_model->get_clubagents($param,$by);
        exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'by'=>$by,
                'status' => 1
            )));
    }
    function pooling_report()
    {
       $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "pooling_report/";
        $result_count = $this->Report_model->get_pooling_count($param);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Report_model->get_poolings($param,$per_page, $page);
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/pooling_report',$data); 
    }
    function print_pooling_report()
    {
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $data["data"] = $this->Report_model->get_poolings($param);
        exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1
            )));
    }
    function purchase_by_customers()
    {
       $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('from')||$this->input->post('to')) {
            $from = convert_to_mysql($this->input->post('from'));
            $to = convert_to_mysql($this->input->post('to'));
        }else{
            $from = '';
            $to = '';
        }
        $base_url = base_url() . "purchase_by_customers/";
        $result_count = $this->Report_model->get_purchase_by_customers_count($param,$from,$to);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Report_model->get_purchase_by_customers($param,$from,$to,$per_page, $page);
        //echo json_encode($data["data"]);exit;
        $status = ($result_count==0)?0:1;
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' =>$status,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/purchase_by_customers_report',$data); 
    }
    function print_purcase_report_bycustomers()
    {
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('from')||$this->input->post('to')) {
            $from = convert_to_mysql($this->input->post('from'));
            $to = convert_to_mysql($this->input->post('to'));
        }else{
            $from = '';
            $to = '';
        }
        $data["data"] = $this->Report_model->get_purchase_by_customers($param,$from,$to);
        exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1
            )));
    }
    function purchase_by_cp()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('by')) {
            $by = $this->input->post('by');
        }else{
            $by = '';
        }
        if ($this->input->post('from')||$this->input->post('to')) {
            $from = convert_to_mysql($this->input->post('from'));
            $to = convert_to_mysql($this->input->post('to'));
        }else{
            $from = '';
            $to = '';
        }

        $data['channel_partner'] = get_all_channel_partners();
        $base_url = base_url() . "purchase_by_cp/";
        $type = 'count';
        $result_count = $this->Report_model->get_purchase_by_cp($param,$by,$from,$to,NULL,NULL,$type);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Report_model->get_purchase_by_cp($param,$by,$from,$to,$per_page, $page,NULL);
        //echo json_encode($data["data"]);exit;
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/purchase_by_channel_partners_report',$data); 
    }
    function print_purcase_report_bycp()
    {
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('by')) {
            $by = $this->input->post('by');
        }else{
            $by = '';
        }
        if ($this->input->post('from')||$this->input->post('to')) {
            $from = convert_to_mysql($this->input->post('from'));
            $to = convert_to_mysql($this->input->post('to'));
        }else{
            $from = '';
            $to = '';
        }
        $data["data"] = $this->Report_model->get_purchase_by_cp($param,$by,$from,$to,NULL,NULL,NULL);
        exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1
            )));
    }
    function executives_report()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('by')) {
            $by = $this->input->post('by');
        }else{
            $by = '';
        }
        $base_url = base_url() . "executives/";
        $type = 'count';
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $per_page = 10;
        $result_count = $this->Report_model->get_all_executives($param,$by,NULL,NULL,$type);

        $this->load_paging($base_url,$result_count,$per_page);
        $data["data"] = $this->Report_model->get_all_executives($param,$by,$per_page,$page,NULL);
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'by'=>$by,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        //$data['executives']=$this->Report_model->get_executives_reports();
        $this->load->view('admin/executives_report',$data);
    }
    function print_executive_report()
    {
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('by')) {
            $by = $this->input->post('by');
        }else{
            $by = '';
        }
        $data["data"] = $this->Report_model->get_all_executives($param,$by,NULL,NULL,NULL);
        exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'by'=>$by,
                'status' => 1
            )));
    }
    function ba_report()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('by')) {
            $by = $this->input->post('by');
        }else{
            $by = '';
        }
        $base_url = base_url() . "ba_report/";
        $type = 'count';
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $per_page = 10;
        $result_count = $this->Report_model->get_all_ba($param,$by,NULL,NULL,$type);

        $this->load_paging($base_url,$result_count,$per_page);
        $data["data"] = $this->Report_model->get_all_ba($param,$by,$per_page,$page,NULL);
        //echo json_encode($data["data"]);
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'by'=>$by,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/ba_report',$data);
    }
    function print_ba_report()
    {
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('by')) {
            $by = $this->input->post('by');
        }else{
            $by = '';
        }
        $data["data"] = $this->Report_model->get_all_ba($param,$by,NULL,NULL,NULL);
        exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'by'=>$by,
                'status' => 1
            )));
    }
    function transaction_report()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('by')) {
            $by = $this->input->post('by');
        }else{
            $by = '';
        }

        if ($this->input->post('from')||$this->input->post('to')) {
            $from = convert_to_mysql_date($this->input->post('from'));
            $to = convert_to_mysql_date($this->input->post('to'));
        }else{
            $from = '';
            $to = '';
        }

        $base_url = base_url() . "transaction_report/";
        $type = 'count';
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $per_page = 10;
        $result_count = $this->Report_model->get_all_transactions($param,$by,$from,$to,NULL,NULL,$type);

        $this->load_paging($base_url,$result_count,$per_page);
        $data["data"] = $this->Report_model->get_all_transactions($param,$by,$from,$to,$per_page,$page,NULL);
        $status = ($result_count==0)?0:1;
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'by'=>$by,
                'status' =>$status,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/transaction_report',$data);
    }
    function print_transaction_report()
    {
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('by')) {
            $by = $this->input->post('by');
        }else{
            $by = '';
        }
        if ($this->input->post('from')||$this->input->post('to')) {
            $from = convert_to_mysql_date($this->input->post('from'));
            $to = convert_to_mysql_date($this->input->post('to'));
        }else{
            $from = '';
            $to = '';
        }
        $data["data"] = $this->Report_model->get_all_transactions($param,$by,$from,$to,NULL,NULL,NULL);
        exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'by'=>$by,
                'status' => 1
            )));
    }
    function feedback(){
        if (has_priv('view_feedback')) { 
            $data=$this->set_menu();
            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $base_url = base_url() . "feedback/";
            $type = 'count';
            $result_count = $this->Report_model->get_all_feedback($param,NULL,NULL,$type);
            $status = ($result_count==0)?0:1;
            $per_page = 10;
            $this->load_paging($base_url,$result_count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data['page'] = $page;
            $data["data"] = $this->Report_model->get_all_feedback($param,$per_page,$page,NULL);
            //echo json_encode($data["data"]);exit;
            if ($this->input->post('ajax', FALSE)) {
                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'status' => $status,
                    'pagination' => $this->pagination->create_links()
                )));
            }
            $this->load->view('admin/view_feedback',$data);
        }
    }
    function delete_feedback(){
        if($this->input->is_ajax_request())
        {
            $qry = $this->Report_model->delete_feedback($this->input->post());
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
    function module_report()
    {

        $data=$this->set_menu();
        $data['module']=$this->Report_model->get_module_reports();
        $this->load->view('admin/module_report',$data);
    }

}