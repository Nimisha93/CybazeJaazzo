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
        if((!isset($session_array) )){
            redirect('admin/Login');
        }


    }

    function index()
    {
        $data['default_assets'] = $this->load->view('accounts/templates/default_assets', '', true);
         $data['sidebar'] = $this->load->view('accounts/templates/acc_sidebar', '', true);
        $data['footer'] = $this->load->view('accounts/templates/acc_footer', '', true);
        $this->load->view('accounts/edit_acc_dashboard', $data);
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
       // var_dump($data['my_wallet_value']);
        $this->load->view('admin/edit_super_admin_dashboard', $data);
    }

    

}


?>