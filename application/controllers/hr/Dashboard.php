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
        $this->load->model(array('hr/Mdl_dashboard','admin/ba_model'));
        $session_array = $this->session->userdata('logged_in_admin');
        if((!isset($session_array) )){
            redirect('admin/Login');
        }


    }

    function index()
    {
        $data['default_assets'] = $this->load->view('hr/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('hr/templates/hr_sidebar', '', true);
        $data['footer'] = $this->load->view('hr/templates/hr_footer', '', true);
        $data['dashboard'] = $this->Mdl_dashboard->getdashborad_data();

        $this->load->view('hr/edit_hr_dashboard', $data);
    }

  

    

}


?>