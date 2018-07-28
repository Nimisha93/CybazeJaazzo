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
        $this->load->model(array('admin/Dashboard_model','admin/ba_model'));
        $session_array = $this->session->userdata('logged_in_admin');
        $session_array1 = $this->session->userdata('logged_in_ba');
        if((!isset($session_array)) and (!isset($session_array1))){
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
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);

        $data['details']=$this->Dashboard_model->get_graph_datas($lgid);
        $data['my_wallet_value']=$this->Dashboard_model->get_mywallet_value();
        $data['data']=$this->Dashboard_model->getDashboardData();
        //var_dump($data['data']);exit();
        $slug1 = 'hr';$slug2 = 'accounts';
        if(check_privilage($slug1,$lgid)) {
            redirect('/hr_dashboard');
        }else if(check_privilage($slug2,$lgid)) {
            redirect('/ledgers/0');
        }
        else{
            $this->load->view('admin/edit_super_admin_dashboard', $data);
        }
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
        $loginsession = $this->session->userdata('logged_in_ba');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['user']=$this->ba_model->get_ba($userid);
        $data['header'] = $this->load->view('executive/templates/ex_header',$data,  true);
        $data['sidebar'] = $this->load->view('executive/templates/ba_sidebar',$data , true);
        $data['footer'] = $this->load->view('executive/templates/ex_footer', '', true);
        $data['my_wallet_value']=$this->Dashboard_model->get_cpwallet_value();
        $this->load->view('ba/ba_dashboard', $data);
    }

}


?>