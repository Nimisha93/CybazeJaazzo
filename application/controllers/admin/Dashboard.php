<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */

Class Dashboard extends CI_Controller
{

    function __construct()
    {

        parent:: __construct();
        $this->load->library(array('session','form_validation'));
        $this->load->helper(array('url','form'));
        $this->load->model(array('admin/Dashboard_model'));
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array)){
            redirect('admin/Login');
        }


    }

    function index()
    {
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/cp_sidebar', '', true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $this->load->view('admin/edit_super_admin_dashboard', $data);
    }

    function main_admin()
    {
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['details']=$this->Dashboard_model->get_graph_datas();
        $data['my_wallet_value']=$this->Dashboard_model->get_mywallet_value();
        $this->load->view('admin/edit_super_admin_dashboard', $data);
    }

    function graph()
    {
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        $data['details']=$this->Dashboard_model->get_graph_data();
       // echo json_encode($data['details']);
        $this->load->view('public/edit_view_graph',$data);
    }
    function bch_dashboard()
    {
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/bch_sidebar', '', true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['my_wallet_value']=$this->Dashboard_model->get_cpwallet_value();
        $this->load->view('admin/edit_bch_dashboard', $data);
    }
    function ba_dashboard()
    {
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/ba_sidebar', '', true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['my_wallet_value']=$this->Dashboard_model->get_cpwallet_value();
        $this->load->view('admin/edit_ba_dashboard', $data);
    }

}


?>