




<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */
 //desigination report hridya
Class Report extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('session','form_validation'));
        $this->load->helper(array('url','form','string'));
        $this->load->model('admin/Report_model');
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
   
    function designation()
    {


$data=$this->set_menu();
$data['reports']=$this->Report_model->get_desigination_reports();

        $this->load->view('admin/desigination_report',$data);


    }

 function channelpartner()
    {

$data=$this->set_menu();
$data['channel']=$this->Report_model->get_channelpartner_reports();

        $this->load->view('admin/channelpartner_report',$data);


    }

function club_type()
    {

        $data=$this->set_menu();
        $data['club']=$this->Report_model->get_club_type_reports();

        $this->load->view('admin/clubtype_report',$data);


    }
    function customer()
    {

$data=$this->set_menu();
$data['customer']=$this->Report_model->get_customer_reports();

        $this->load->view('admin/customer_report',$data);


    }

 function club_members()
    {

$data=$this->set_menu();
$data['members']=$this->Report_model->get_club_members_reports();

        $this->load->view('admin/clubmembers_report',$data);


    }
    function executives_report()
    {

$data=$this->set_menu();
$data['executives']=$this->Report_model->get_executives_reports();

        $this->load->view('admin/executives_report',$data);


    }
     function module_report()
    {

$data=$this->set_menu();
$data['module']=$this->Report_model->get_module_reports();

        $this->load->view('admin/module_report',$data);


    }

}