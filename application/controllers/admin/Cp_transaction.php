<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Cp_transaction extends CI_Controller{

    function __construct(){
        parent:: __construct();
        $this->load->library(array('session','form_validation'));
        $this->load->model(array('admin/Transaction_model','admin/Profile_model','admin/Channelpartner_model'));
        $this->load->helper(array('url','form','my_common_helper'));
        $session_array = $this->session->userdata('logged_in_cp');
        if(!isset($session_array)){
            redirect('admin/Login');
        }
        
    }

  
    function set_menu(){
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        $data['user']=$this->Profile_model->get_all_partnertype($userid);
        $data['notification'] = get_new_purchase_count();
        $data['commission_settings']=$this->Channelpartner_model->get_cp_commission_status($userid);
        $data['sidebar'] = $this->load->view('channel_partner/templates/sidebar', $data, true);
        $data['header'] = $this->load->view('channel_partner/templates/header', '', true);
        $data['footer'] = $this->load->view('channel_partner/templates/footer', '', true);
        return $data;
    }
    
    function cp_last_trandetails(){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        $login_id=$loginsession['id'];
        $data['to_admin']=$this->Transaction_model->cp_last_transaction_details($login_id,1);
        $data['from_admin']=$this->Transaction_model->cp_last_transaction_details(1,$login_id);
        $data['cp_details']=$this->Transaction_model->get_cptransaction_details($login_id);
        $this->load->view('channel_partner/edit_view_cptransaction',$data);
    }

    function cp_requests()
    {
      if (has_priv('cp_requests')) {

         $data=$this->set_menu();
         $data['cp_details']=$this->Transaction_model->get_transaction_details_cp();
         $this->load->view('admin/edit_view_transaction_cp',$data);

      }
    }
    function approve_transaction_request(){
        if($this->input->is_ajax_request()){

                $result=$this->Transaction_model->approve_transaction_request();
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{

                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            
        }
        else{
                exit(json_encode(array("status"=>FALSE,"reason"=>"This is not an ajax request")));
        }
    }
    
    function transaction_request(){
       

        if($this->input->is_ajax_request()){

            $loginsession = $this->session->userdata('logged_in_cp');
            $id=$loginsession['id'];
            $userid=$loginsession['user_id'];
            $email=$loginsession['username'];
            $pending=$this->Transaction_model->get_cptransaction_details($id);

            if($pending<0){
              $amount = abs($pending);
              $data['amount'] = $amount;
              $cp = random_select("cp.id = '$userid'","cp.name","gp_pl_channel_partner cp","row");
              $cp_name = $cp->name;
              $data['name'] = $cp_name;
              $date = date('Y-m-d');
              $des = $cp_name." has been requested a payment of Rs. ".$amount;
              $noty = array('title'=>'Payment Request','description'=>$des,'from'=> $userid,'_to'=>'1' ,'des_type_id'=>'2' ,'login_id'=>$id,'type' => 'user', 'created_on' => $date);
              insert('admin_notifications',$noty);
              $data['email'] = $email;
              $mail = "maneeshakk16@gmail.com";
              $mail_head = 'Message From Jaazzo';
              $status = send_custom_email($mail, $mail_head, $email, 'Transaction Request', $this->load->view('email_templates/transaction_request', $data,TRUE));
              if($status)
                {exit(json_encode(array("status"=>TRUE)));}
              else{
                exit(json_encode(array("status"=>FALSE,"reason"=>"Something went wrong!")));
              }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>"You don't have any pending transaction amounts!")));
            }
        }
         else{
                exit(json_encode(array("status"=>FALSE,"reason"=>"This is not an ajax request")));
            }
    }
    function new_transaction(){

        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("pay_amount", "Amount", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("payment_mode", "Payment Mode", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("transaction_date", "Transaction Date", "trim|required|htmlspecialchars");
            if($this->input->post('payment_mode')=='cheque'){
                $this->form_validation->set_rules("cheque_number", "Cheque Number", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("bank", "Bank", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("cheque_date", "Cheque Date", "trim|required|htmlspecialchars");
            }
            if($this->form_validation->run()== TRUE){
                $loginsession = $this->session->userdata('logged_in_cp');
                $userid=$loginsession['user_id'];
                $lgid=$loginsession['id'];
                $result=$this->Transaction_model->new_transaction_byid($userid,$lgid);
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
        else{
                exit(json_encode(array("status"=>FALSE,"reason"=>"This is not an ajax request")));
        }
    }
/*module2 */

    function get_cp_transaction($id){
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['user']=$this->Profile_model->get_all_partnertype($userid);
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/cp_sidebar',$data, true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data=$this->set_menu();
        $data['cp_customer']=$this->Transaction_model->cuspur_cp_details($id);
        $this->load->view('admin/edit_cp_transaction_details',$data);
    }

    
    /*end*/


}