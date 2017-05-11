<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 */

Class Channel_partner extends CI_Controller
{

    function __Construct(){

        parent:: __construct();
        $this->load->library(array('session','form_validation'));
        $this->load->model(array('admin/Channelpartner_model', 'admin/Dashboard_model'));
        $this->load->helper(array('url','form'));
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array)){
            redirect('admin/Login');
        }
    }

    function set_menu(){
        $loginsession = $this->session->userdata('logged_in_admin');
        //var_dump($loginsession);exit;
        if($loginsession['type'] == 'super_admin'){
             $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        }else if($loginsession['type'] == 'Channel_partner'){
             $data['sidebar'] = $this->load->view('admin/templates/cp_sidebar', '', true);
        }else if($loginsession['type'] == 'bch'){
             $data['sidebar'] = $this->load->view('admin/templates/bch_sidebar', '', true);
        }
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
    
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        return $data;
    }

    function index(){
        $data=$this->set_menu();
        $data['cp_wallet_value']=$this->Dashboard_model->get_cpwallet_value();
        $this->load->view('admin/edit_view_channelpartner_dashboard',$data);
    }

    function partner_type(){
        $data=$this->set_menu();
        $this->load->view('admin/edit_add_channelpartner_type',$data);
    }

    function new_partner_type(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("title", "Title", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("description", "Description", "trim|required|htmlspecialchars");
            $mailms['otp']=$this->input->post('email');
            $mailms['mail']=$this->input->post('email');
            if($this->form_validation->run()== TRUE){
                $result=$this->Channelpartner_model->add_partnertype();
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

    function partner(){
        $data=$this->set_menu();
        $data['partner_type']=$this->Channelpartner_model->get_partner_type();
        $this->load->view('admin/edit_add_channelpartner',$data);
    }

    function new_partner(){

        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("channel_type[]", "Channel Partner Type ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Phone", "numeric|trim|required|min_length[10]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("phone2", "Phone", "numeric|trim|min_length[10]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email", "valid_email|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("fax", "Fax", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("address", "Address", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("isagree", "Agree with the terms and conditions", "trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $result=$this->Channelpartner_model->add_partner();

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

    function view_partner_type(){
        $data=$this->set_menu();
        $data['partner_type']=$this->Channelpartner_model->get_all_partnertype();
        $this->load->view('admin/edit_view_channerpartner_type',$data);
    }

    function edit_partnertype_byid(){
        $result=$this->Channelpartner_model->get_edit_partnertypebyid();
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }

    function delete_partnertype(){
        $result=$this->Channelpartner_model->delete_partnertypebyid();
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }

    function view_channelpartner(){
        $data=$this->set_menu();
        $data['partner']=$this->Channelpartner_model->get_channerpartner();
        $this->load->view('admin/edit_view_channerpartner',$data);
    }

    function get_channelpartner_byid($id){
        $data=$this->set_menu();
        $data['partner_type']=$this->Channelpartner_model->get_partner_type();
        $data['partner']=$this->Channelpartner_model->get_channerpartner_byid($id);
        $this->load->view('admin/edit_channerpartner_edit',$data);
    }

    function edit_partner(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("name", "Name ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Phone", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("fax", "Fax", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("address", "Address", "trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $result=$this->Channelpartner_model->edit_partnerbyid();

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

    function delete_partnerbyid($id){
        $result=$this->Channelpartner_model->delete_partnerbyid($id);
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }

    function mail_exists()
    {
        $mail=$this->input->post('mail');
        $result = $this->Channelpartner_model->mail_exisits($mail);
        if($result == FALSE)
        {
            exit(json_encode(array('status'=> true)));
        } else{
            exit(json_encode(array('status'=> FALSE)));
        }
    }

    function mobile_exists(){
        $mob=$this->input->post('mob');
        $result = $this->Channelpartner_model->mobile_exisits($mob);
        if($result == FALSE)
        {
            exit(json_encode(array('status'=> true)));
        } else{
            exit(json_encode(array('status'=> FALSE)));
        }
    }

    function get_purchase_notification(){
        $data=$this->set_menu();
        $data['notification']=$this->Channelpartner_model->get_all_purchasenotification();
        $this->load->view('admin/edit_view_notification',$data);
    }

    function purchase_approvel_byotp(){
        $result=$this->Channelpartner_model->purchase_approval_by_otp();
        if($result){
         
            $cp_con_id = $result['channel_partner_conn_id'];
           
            $notyid = $result['id'];
            $check_one_cat_only = $this->Channelpartner_model->get_only_one_cat($cp_con_id);
            $cat_level = $check_one_cat_only['category_level'];
            $con_id = $check_one_cat_only['id'];
            if($cat_level == 0)
            {
                exit(json_encode(array('status' => TRUE)));
            } else{
                $get_cat = $this->Channelpartner_model->get_saled_cat($cp_con_id);
                exit(json_encode(array("status"=>TRUE, 'data' => $get_cat, 'notyid' => $notyid)));
            }
           
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Invalid otp")));
        }
    }


    function purchase_otp(){

        $this->load->helper('string');
        $otp= random_string('numeric',5);
        $email_details = array();
        $mobile=$this->input->post('mobile');
        $emailll=$this->input->post('emailll');
        
        $email_details['otp'] = $otp;
        $email_details['mobile'] = $mobile;
        $results=$this->Channelpartner_model->get_purchase_otp($otp);
        if($results){
            
            //msg otp
            $username = "faisal@cybaze.com";
            $hash = "29b89b2ccf079979f19ad3c6ff401b0cddc999ff";

            // Config variables. Consult http://api.textlocal.in/docs for more info.
            $test = "0";

            // Data for text message. This is the text message data.
            $sender = "GREEN INDIA"; // This is who the message appears to be from.
            $numbers = "$mobile"; // A single number or a comma-seperated list of numbers
            $message = "Please use this OTP for completing your purchase :$otp";
            // 612 chars or less
            // A single number or a comma-seperated list of numbers
            $message = urlencode($message);
            $data = "username=".$username."&hash=".$hash."&message=".$message."&sender=".$sender."&numbers=".$numbers."&test=".$test;
            $ch = curl_init('http://api.textlocal.in/send/?');
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $result = curl_exec($ch);
            curl_close($ch);
            // end msg otp
            //mail otp
            $email_message = $this->load->view('email_templates/edit_purchase_notification_otp', $email_details,TRUE);
            $this->load->library('email');
            $config['protocol'] = "smtp";
            $config['smtp_host'] = "ssl://smtp.gmail.com";
            $config['smtp_port'] = "465";
            $config['smtp_user'] = 'pranavpk.pk1@gmail.com';
            $config['smtp_pass'] = '9544146763';
            $config['charset'] = "utf-8";
            $config['mailtype'] = "html";
            $config['newline'] = "\r\n";

            $this->email->initialize($config);
            $this->email->from('greenindia@gmail.com', 'Green India');
            $this->email->to($emailll);
            $this->email->reply_to('no-replay@gmail.com', 'OTP Verification');
            $this->email->subject('OTP Verification');
            $this->email->message($email_message);
            $this->email->send();
            //end mail otp
            exit(json_encode(array("status"=>TRUE, 'data'=> $results)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }



    /* module2*/

    function mail_to_customers(){
        $data=$this->set_menu();
        $data['customers']=$this->Channelpartner_model->get_cpcustomer_mailid();
        $this->load->view('admin/edit_send_cpmail',$data);
    }
    function send_new_mail(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("cus_mail[]", "Mail", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("message", "Message", "trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $email=$this->input->post('cus_mail');
                $this->load->library('email');
                $config['protocol'] = "smtp";
                $config['smtp_host'] = "ssl://smtp.gmail.com";
                $config['smtp_port'] = "465";
                $config['smtp_user'] = 'pranavpk.pk1@gmail.com';
                $config['smtp_pass'] = '9544146763';
                $config['charset'] = "utf-8";
                $config['mailtype'] = "html";
                $config['newline'] = "\r\n";
                $mailmsg['message'] = $this->input->post('message');

                $email_message = $this->load->view('admin/edit_cpsend_mail_content', $mailmsg,TRUE);
                $this->email->initialize($config);


                foreach($email as $mail){
                    $this->email->from('greenindia@gmail.com', 'Green India');
                    $this->email->to($mail);
                    $this->email->reply_to('no-replay@gmail.com', 'OTP Verification');
                    $this->email->subject('OTP Verification');
                    $this->email->message($email_message);
                    $this->email->send();


                }

                exit(json_encode(array("status"=>true)));


            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }

    }

    function send_notification_customer(){
        $data=$this->set_menu();
        $data['customers']=$this->Channelpartner_model->get_cpcustomer_connid();
        $this->load->view('admin/edit_send_cp_notification',$data);
    }

    function get_customer_notification(){
        $data=$this->set_menu();
        $data['notification']=$this->Channelpartner_model->get_cpcustomer_notidetails();
        $this->load->view('admin/edit_view_cp_notification2',$data);
    }

    function cp_send_notification(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("customer[]", "Mail", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("notification", "Notification", "trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){

                $result=$this->Channelpartner_model->send_notification_customer();
                if($result){
                    exit(json_encode(array("status"=>true)));
                }
                else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>"Error")));

                }

            }

            exit(json_encode(array("status"=>true)));

        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
        }

//        function get_notification(){
//            $data=$this->set_menu();
////            $data['partner_type']=$this->Channelpartner_model->get_cp_notification();
//            $this->load->view('admin/edit_view_cptransaction',$data);
//        }



    }
    /* end*/




    function get_partner_con_cat_level($con_id)
    {
        $data = $this->Channelpartner_model->get_cat_level($con_id);
        if($data)
        {
            exit(json_encode(array('status' => TRUE, 'data'=> $data)));
        } else{
             exit(json_encode(array('status' => FALSE, 'reason'=> 'No Data Found')));
        }
    }
    function total_percentage()
    {
        if($this->input->is_ajax_request()){
          // $cat_id = $this->input->post('cat_id');
            $this->form_validation->set_rules("total_bill", "Total Amount", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("percentage[]", "Percentage", "trim|required|htmlspecialchars");
             if($this->form_validation->run()== TRUE){
                $cat_percentage = $this->input->post('percentage');
                $noty_id = $this->input->post('notyid');
                $total_amount = $this->input->post('total_bill');
                $product_nos = $this->input->post('product_nos');  
                $sum_cat = 0;
                
                $sum_nos = 0;
                foreach ($product_nos as $key => $nos) {
                   if($nos != '' || $nos != 0){
                   
                    $sum_cat += ($cat_percentage[$key] * $nos); 
                    $sum_nos += $nos; 
                    }
                }
              
                $total_percent = $sum_cat/$sum_nos;
                
              
                $data = array(
                    'bill_total' => $total_amount,
                    'direct_commision_percentage' =>  $total_percent
                    );
            //    var_dump($data);exit;
                $discount = ($total_amount * $total_percent)/100;
                $update = $this->Channelpartner_model->updatewallet($noty_id, $discount, $data);
                if($update)
                {
                    exit(json_encode(array('status' => TRUE)));
                } else{
                     exit(json_encode(array('status' => FALSE, 'reason' => 'Invalid transaction')));
                }
            }else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }else{
            show_error("We are unable to process this request on this way!");
        }
    }
}
?>