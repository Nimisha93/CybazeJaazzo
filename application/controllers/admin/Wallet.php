<?php
/**
* 
*/
class Wallet extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation','pagination'));
        $this->load->model(array('admin/wallet_model','admin/Profile_model'));
        $this->load->helper(array('form','string'));
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array)){
            redirect('admin/Login');
        }
	}
	function get_wallet_activity()
	{
		$loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['user']=$this->Profile_model->get_all_partnertype($userid);
		$data['sidebar'] = $this->load->view('admin/templates/cp_sidebar', $data, true);
    	$data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
    	$data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['wallet_activity']=$this->wallet_model->get_wallet_activity();
        $this->load->view('admin/edit_wallet_activity', $data);
	}
	function get_wallet_activity_ba()
	{
		$loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
       $data = array();
		$data['sidebar'] = $this->load->view('admin/templates/ba_sidebar', $data, true);
    	$data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
    	$data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['wallet_activity']=$this->wallet_model->get_wallet_activity();
        $this->load->view('admin/edit_wallet_activity', $data);
	}
	function get_wallet_activity_bch()
	{
		$loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
       	$data = array();
		$data['sidebar'] = $this->load->view('admin/templates/bch_sidebar', $data, true);
    	$data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
    	$data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['wallet_activity']=$this->wallet_model->get_wallet_activity();
        $this->load->view('admin/edit_wallet_activity', $data);
	}
	function get_wallet_activity_exe()
	{
		$loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['user']=$this->Profile_model->get_exicutives($userid);
		$data['sidebar'] = $this->load->view('admin/templates/ex_sidebar', $data, true);
    	$data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
    	$data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['wallet_activity']=$this->wallet_model->get_wallet_activity();
        $this->load->view('admin/edit_wallet_activity', $data);
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
	function get_wallet_activity_admin()
	{
		$loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
      
		$data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
    	$data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
    	$data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "designation_report/";
        $result_count = $this->wallet_model->get_wallet_count($param);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->wallet_model->get_wallets($param,$per_page,$page);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        //$data['wallet_activity']=$this->wallet_model->get_wallet_activity();
        $this->load->view('admin/edit_wallet_activity', $data);
	}
    function overview()
    {
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
      
        $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['result'] = $this->wallet_model->get_wallet_overview();
        //echo json_encode( $data['result']);exit;
        $this->load->view('admin/edit_wallet_overview', $data);
    }
}

?>