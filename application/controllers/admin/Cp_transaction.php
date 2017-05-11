<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Cp_transaction extends CI_Controller{

    function __construct(){
        parent:: __construct();
        $this->load->library(array('session','form_validation'));
        $this->load->model('admin/Transaction_model');
        $this->load->helper('url','form','my_common_helper');
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array)){
            redirect('admin/Login');
        }
    }

    function set_menu(){
        $loginsession = $this->session->userdata('logged_in_admin');
        if($loginsession['type'] == 'super_admin'){
            $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        }else{
            $data['sidebar'] = $this->load->view('admin/templates/cp_sidebar', '', true);
        }
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        return $data;
    }

    function index(){
        $data=$this->set_menu();
        $data['cp_details']=$this->Transaction_model->get_transaction_details();
        $this->load->view('admin/edit_view_transaction',$data);
    }
    function new_transaction(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("pay_amt", "Amount", "numeric|trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $result=$this->Transaction_model->new_transaction_byid();
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{

                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
    }
/*module2 */

    function get_cp_transaction($id){
        $data=$this->set_menu();
         $loginsession = $this->session->userdata('logged_in_admin');
       $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['user']=$this->Profile_model->get_exicutives($userid);
         $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/cp_sidebar',$data, true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data=$this->set_menu();
        $data['cp_customer']=$this->Transaction_model->cuspur_cp_details($id);
        $this->load->view('admin/edit_cp_transaction_details',$data);

    }

    function cp_last_trandetails(){
        $data=$this->set_menu();
        $data=$this->set_menu();
         $loginsession = $this->session->userdata('logged_in_admin');
       $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['user']=$this->Profile_model->get_exicutives($userid);
         $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/cp_sidebar',$data, true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['cp_details']=$this->Transaction_model->get_cptransaction_details();
        $this->load->view('admin/edit_view_cptransaction',$data);
    }

    /*end*/


}