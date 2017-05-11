<?php
/**
* 
*/
class Wallet extends CI_Controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->library(array('form_validation'));
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
	function get_wallet_activity_admin()
	{
		$loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
      
		$data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
    	$data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
    	$data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['wallet_activity']=$this->wallet_model->get_wallet_activity();
        $this->load->view('admin/edit_wallet_activity', $data);
	}
}

?>