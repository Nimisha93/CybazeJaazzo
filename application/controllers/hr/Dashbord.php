<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * User: kavyasree
 * Date: 5/11/17
 * Time: 10:47 PM
 */
class Dashboard extends CI_Controller
{
	
	 function __construct()
    {
        parent::__construct();
        $this->load->model(array('admin/Mdl_dashboard'));
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array))
        {
            redirect('admin/login');
        }
    }
    function index()
    {
    	echo "tryu";
    	
    	$this->load->view('hr/edit_dashboard');
    }
}