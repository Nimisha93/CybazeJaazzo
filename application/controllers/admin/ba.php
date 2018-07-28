<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 */

Class Ba extends CI_Controller
{

    function __Construct()
    {
        parent:: __construct();
        $this->load->library(array('session','form_validation','pagination'));
        $this->load->model(array('admin/Executives_model','admin/Profile_model','admin/Clubmember_model','admin/Channelpartner_model','user/product_model'));
        $this->load->helper(array('url','form', 'custom','my_common_helper','string'));

        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array)){
            redirect('admin/Login');
        }

    }
}