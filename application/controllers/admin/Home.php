<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Home extends CI_Controller
{
    
    function __Construct(){

        parent:: __construct();
        $this->load->library(array('session','form_validation','pagination'));
        $this->load->model(array('admin/Channelpartner_model','admin/Home_model','admin/Dashboard_model','admin/Transaction_model','register_model','admin/Executives_model'));
        $this->load->helper(array('url','form','my_common_helper','string'));
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array)){
            redirect('admin/Login');
     }
    } 
   function set_menu(){
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        return $data;
    }
   function bulk_mail()
   {
    if (has_priv('send_mail')) {
        $data = $this->set_menu();
        $this->load->view('admin/edit_bulk_mail',$data);
   }
   }
   function update_category_level(){

        if($this->input->is_ajax_request()){
          
          $this->form_validation->set_rules("cat_level", "Category Level", "trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){  

            $result = $this->Home_model->update_category_level();
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
    function category_level_settings(){
        $data =$this->set_menu();
        $data['cat_level'] = $this->Home_model->category_level_settings();   
        $this->load->view('admin/edit_add_category_level',$data);  
    }

   function bulk_sms()
   {
    if (has_priv('send_sms')) {
        $data = $this->set_menu();
        $this->load->view('admin/edit_bulk_sms',$data);
   }
   }
  
   

   function get_user_type_mobile($type){
        if($this->input->is_ajax_request()){

                $result=$this->Home_model->get_user_type_mobile($type);
                if($result){
                    exit(json_encode(array("status"=>TRUE, "data" => $result)));
                }
                else{

                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }
           
        else{
          exit(json_encode(array("status"=>FALSE,"reason"=>"This is not an ajax request")));
        }

    }


   function get_user_type($type){
        if($this->input->is_ajax_request()){

                $result=$this->Home_model->get_user_type($type);
                if($result){
                    exit(json_encode(array("status"=>TRUE, "data" => $result)));
                }
                else{

                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }
           
        else{
          exit(json_encode(array("status"=>FALSE,"reason"=>"This is not an ajax request")));
        }

    }
    function send_mail()
    {
        
        if($this->input->is_ajax_request())
        {

            $this->form_validation->set_rules('selectbox[]', 'Sender ', 'required|trim');
            $this->form_validation->set_rules('subject', 'Subject Field', 'required|trim');
            $this->form_validation->set_rules('body', 'Message ', 'required|trim');

            if($this->form_validation->run()==TRUE)
            {
               
                $selected = $this->input->post('selectbox');
                
                $title=$this->input->post('subject');
                $content['message']=$this->input->post('body');
                $subject=$title;
               
                    $sender_email = "mail@jaazzo.com";
                    $mail_head = "Jaazzo";
                      
               
                    $content['name']='Customer';
                    $message=$this->load->view('admin/templates/mail/bulk_mail',$content,TRUE);
                   
                    // $ci =& get_instance();
                    // $ci->load->database();
                    // $ci->load->library('email');
                    
                    // $config['protocol'] = "smtp";
                    // $config['smtp_host'] = "ssl://smtp.gmail.com";
                    // $config['smtp_port'] = "465";
                    // $config['smtp_user'] = 'techcybaze@gmail.com';
                    // $config['smtp_pass'] = 'cyb@ze-7';
                    // $config['charset'] = "utf-8";
                    // $config['mailtype'] = "html";
                    // $config['newline'] = "\r\n";

                    // $ci->email->initialize($config);
                    // $ci->email->from($sender_email, $mail_head);
                    // $ci->email->to($selected);
                    // $ci->email->reply_to('no-replay@gmail.com');
                    // $ci->email->subject($subject);
                    // $ci->email->message($message);
                    // $send = $ci->email->send();





                $ci = get_instance();
                $ci->load->library('email');
                $config['protocol'] = "smtp";
                $config['smtp_host'] = "ssl://smtp.googlemail.com";
                $config['smtp_port'] = "465";
            $config['smtp_user'] = 'techcybaze@gmail.com';
            $config['smtp_pass'] = 'cyb@ze-7';
                $config['charset'] = "utf-8";
                $config['mailtype'] = "html";
                $config['newline'] = "\r\n";


                $ci->email->initialize($config);
            $this->email->set_newline("\r\n");
            $this->email->set_mailtype("html");
            $this->email->clear(TRUE);
           // $this->email->from("anju@cybaze.com");
            $this->email->from($sender_email, $mail_head);
            //$this->email->to($selected);
            //$this->email->to('kavya@cybaze.com');
            $this->email->bcc($selected);
            $this->email->subject($subject);
            $this->email->message($message);

            $send=$this->email->send();








                   
                if($send)
                {
                    exit(json_encode(array('status'=>TRUE)));

                } else
                {
                    exit(json_encode(array('status'=>FALSE, 'reason'=>'Mail not send, Please try again later')));
                }
            }else
            {
                exit(json_encode(array('status'=>FALSE,'reason'=>validation_errors())));
            }
        }else{
            show_error("Unable To Process The Request In This Way");
        }
    }


  function send_sms()
  {

    if($this->input->is_ajax_request())
        {

            $this->form_validation->set_rules('selectbox[]', 'Sender ', 'required|trim');
           // $this->form_validation->set_rules('title', 'Subject Field', 'required|trim');
            $this->form_validation->set_rules('body', 'Message ', 'required|trim');

            if($this->form_validation->run()==TRUE)
            {
                //$list = '9961464275';

               $selected = $this->input->post('selectbox');
              
               // $title=$this->input->post('title');
                $message=$this->input->post('body');

                //$message = urlencode($message);

                foreach ($selected as $key => $value) {
               // echo json_encode($value);

                      $ch=send_message($value,$message);

          //                 $ch = curl_init( 'http://webqua.net/pushsms.php?username=cybaze&api_password=f8386zw7u5mdz5dws&sender=JAAZZO& to='.$value.'&&priority=11&message='.$message);
          //   curl_setopt($ch, CURLOPT_POST, true);
          //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
          //   $result = curl_exec($ch); // This is the result from the API
          //   curl_close($ch);
          // //  echo $result;exit();

                 }        
                
                exit(json_encode(array('status'=>TRUE)));        
            }else
            {
                exit(json_encode(array('status'=>FALSE,'reason'=>validation_errors())));
            }
        }else{
            show_error("Unable To Process The Request In This Way");
        }
     

  }


    function new_partner()
    {   


        if (has_priv('add_cp')) 
        {    
            $data=$this->set_menu();
            $this->load->library('googlemaps');
            $config['center'] = '10.804305026919454, 76.11534118652344';
            $config['zoom'] = '8';
            $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
            $this->googlemaps->initialize($config);
            $data['map'] = $this->googlemaps->create_map();
            $data['category']=$this->Home_model->get_cpcategory();
            $data['subcategory']=$this->Home_model->get_cpscategory();
            $data['countries'] = $this->Home_model->get_countries();
            $data['modules'] = $this->Home_model->get_modules();
            $this->load->view('admin/edit_add_channelpartner',$data);
        }
     }
    function delete_product_image($id)
    {
        $result=$this->Home_model->delete_product_image($id);
        if($result)
        {
            exit(json_encode(array("status"=>TRUE)));
        }
        else
        {
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
     public function pan_check($str)
        {
            $where = array('is_del'=>0, 'pan'=>$str);
            $sql = $this->db->select('id')->where($where)->get('gp_pl_channel_partner')->row('id');

                if ($sql)
                {
                        /*$this->form_validation->set_message('pan_check', 'The {field} should be unique');*/
                        $this->form_validation->set_message('pan_check', 'The {field} already exists');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
    public function gst_check($str)
    {
        $where = array('is_del'=>0, 'gst'=>$str);
        $sql = $this->db->select('id')->where($where)->get('gp_pl_channel_partner')->row('id');
        if ($sql)
        {
            $this->form_validation->set_message('gst_check', 'The {field} already exists');
            return FALSE;
        }
        else
        {
                return TRUE;
        }
    }    
    function add_partner(){

        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("channel_type[]", "Channel Partner Type ", "trim|required|htmlspecialchars"); 
            $this->form_validation->set_rules("email", "Email", "valid_email|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Phone", "numeric|trim|required|min_length[10]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("ocname", "Owner Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("oc_mobile", "Owner's Mobile Number", "numeric|trim|min_length[7]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("oc_email", "Owner's Email", "valid_email|trim|required|htmlspecialchars"); 
            $this->form_validation->set_rules("country", "Country", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("state", "State", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("town", "City", "trim|required|htmlspecialchars");
            
            
            
            $this->form_validation->set_rules("area", "Area", "trim|required|htmlspecialchars");
            
            
            
            $this->form_validation->set_rules("latt", "Latitude", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("long", "Longitude", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pan", "PAN Number", "trim|required|htmlspecialchars|exact_length[10]|callback_pan_check");
            if($this->input->post('gst')){
                $this->form_validation->set_rules("gst", "GST Number", "trim|htmlspecialchars|exact_length[15]|callback_gst_check");
            }
            
           
            if($this->form_validation->run()== TRUE){
                $this->load->helper('string');
                $otp = random_string('numeric', 4);
                $qr_no = random_string('numeric', 4);
                $data = array();
                $files = $_FILES;
                $creg ='';$license = '';
                
                    $config['upload_path'] =  './uploads/cp_docs';
                    $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
                    $config['max_size'] = '2000000';
                    $config['remove_spaces'] = true;
                    $config['overwrite'] = false;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if(isset($_FILES['company_registration']['name'])){ 
                        if (!$this->upload->do_upload('company_registration')) {
                        exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
                        } else {
                        $fileData1 = $this->upload->data();
                        $creg ='uploads/cp_docs/'.$fileData1['file_name'];
                        }
                    }
                    if(isset($_FILES['license']['name'])){
                        if (!$this->upload->do_upload('license')) {
                        exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
                        } else {
                        $fileData2 = $this->upload->data();
                        $license = 'uploads/cp_docs/'.$fileData2['file_name'];
                        }
                    }

                $result=$this->Home_model->add_partner($otp,$qr_no,$creg,$license);
                if($result){
                      $data['otp'] = $otp;
                      $mail = $this->input->post('email');
                 
                      $data['id'] = $result;
                    
                     $email = "maneeshakk16@gmail.com";
                     $mail_head = 'Message From Jaazzo';
                     $status = send_custom_email($email, $mail_head, $mail, 'Sign Up - Channel Partner', $this->load->view('admin/edit_email_channelpartner_otp', $data,TRUE));
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
    function get_state_by_id($id)
    {
        $data = $this->Home_model->get_state_by_country($id);
        if($data){
            exit(json_encode(array('status'=>true,'data'=>$data)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'invalid selection')));
        }
    }
    function get_town_by_id($id)
    {
        $data = $this->Home_model->get_town_by_id($id);
        if($data){
            exit(json_encode(array('status'=>true,'data'=>$data)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'invalid selection')));
        }
    }
    function mail_exists()
    {
        $mail=$this->input->post('mail');
        $result = $this->Home_model->mail_exisits($mail);
        if($result == FALSE)
        {
            exit(json_encode(array('status'=> true)));
        } else{
            exit(json_encode(array('status'=> FALSE)));
        }
    }
    function mobile_exists(){
        $mob=$this->input->post('mob');
        $result = $this->Home_model->mobile_exists($mob);
        if($result == FALSE)
        {
            exit(json_encode(array('status'=> true)));
        } else{
            exit(json_encode(array('status'=> FALSE)));
        }
    }
   function get_all_cptypes()
    {  
        $data = $this->Home_model->get_all_cptypes();
        if($data){
            exit(json_encode(array('status'=>true,'data'=>$data)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'invalid selection')));
        }
    }

    function get_unapproved_cp1(){

if (has_priv('approve_cp')) {
        $data=$this->set_menu();
        $status = "NOT_APPROVED";
        $data['partner']=$this->Home_model->get_cps_by_status($status);
        $data['status'] = "NOT APPRO
        VED";
        $this->load->view('admin/edit_view_na_channerpartner',$data);
         }
    }
    function approve_deal_purchases1(){
        $data=$this->set_menu();
       
        $data['deal']=$this->Home_model->get_na_deals();
        $this->load->view('admin/edit_view_na_deals',$data);
    }
    function approve_deal_purchases(){
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $result_count = $this->Home_model->get_all_deal_purchase_count($param);
        $base_url = base_url() . "all_deal_purchases/";
        $count =  $result_count;
        $per_page = 10;
        $this->load_paging($base_url,$count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Home_model->get_all_deal_purchase($param,$per_page, $page);
       // echo json_encode($data["data"]);exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'pagination' => $this->pagination->create_links()
            )));
        }
        
        $this->load->view('admin/edit_view_na_deals',$data);
    }
    function get_permanent_deactivated_cp(){
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $result_count = $this->Home_model->get_permanent_deactivated_cp_count($param);
        $base_url = base_url() . "tempo_deactivated_cp/";
        $count =  $result_count;
        $per_page = 10;
        $this->load_paging($base_url,$count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Home_model->get_permanent_deactivated_cp($param,$per_page, $page);
        
        $data['channelpartner'] = $this->Home_model->get_active_cp();
        //echo json_encode($data["channelpartner"]);exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'pagination' => $this->pagination->create_links()
            )));
        }
        
        $this->load->view('admin/edit_view_permanent_deactivated_cp',$data);
    }
    function activate_cp_temp(){
        $result=$this->Home_model->activate_cp_temp($this->input->post());
        if($result){
            $ca_ids = $this->input->post('chck_item_id');
            foreach ($ca_ids as $key => $ca_id) {
                $data = select_by_id("gp_pl_channel_partner",$ca_id);
                //var_dump($data);exit();
                $mail = $data->email;
                $number = $data->phone;
                $mail_info['name'] = $data->name;
                $message = 'This is to inform you that, Your account has been activated again. Enjoy jaazzo fecilities again.'; 
                send_message($number,$message);
                $subject = 'Account Activation';
                $mail_info['message']= $message;
                $email = "maneeshakk16@gmail.com";
                $mail_head = 'Message From Jaazzo';
                $status = send_custom_email($email, $mail_head, $mail, $subject, $this->load->view('email_templates/cp_status_change', $mail_info,TRUE));  
            }
            
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    function get_temporary_deactivated_cp(){
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $result_count = $this->Home_model->get_temporary_deactivated_cp_count($param);
        $base_url = base_url() . "temporarily_deactivated_cp/";
        $count =  $result_count;
        $per_page = 10;
        $this->load_paging($base_url,$count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Home_model->get_temporary_deactivated_cp($param,$per_page, $page);
        //echo json_encode($data["data"]);exit();
        $data['channelpartner'] = $this->Home_model->get_active_cp_temp();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'pagination' => $this->pagination->create_links()
            )));
        }
        
        $this->load->view('admin/edit_view_temporarily_deactivated_cp',$data);
    }

    function deactivate_temporarily(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("channelpartner", "Channel Partner", "trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $id=$this->input->post('channelpartner');
                $result=$this->Home_model->deactivate_temporarily($id);
                if($result){
                    $data = select_by_id("gp_pl_channel_partner",$id);
                    $mail = $data->email;
                    $number = $data->phone;
                    $mail_info['name'] = $data->name;
                    $message = 'This is to inform you that, your account has been frozen due to failure in payment. Please clear all the dues and enjoy jaazzo facilities.'; 
                    send_message($number,$message);
                    $subject = 'Account Deactivation';
                    $mail_info['message']= $message;
                    $email = "maneeshakk16@gmail.com";
                    $mail_head = 'Message From Jaazzo';
                    $status = send_custom_email($email, $mail_head, $mail, $subject, $this->load->view('email_templates/cp_status_change', $mail_info,TRUE));
                            exit(json_encode(array("status"=>TRUE)));
                    }
                else{

                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>"Validation Error")));
            }
        }

     }
    function deactivate_permanently(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("channelpartner", "Channel Partner", "trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $id=$this->input->post('channelpartner');
                $result=$this->Home_model->deactivate_permanently($id);
                if($result){
                    $data = select_by_id("gp_pl_channel_partner",$id);
                    $mail = $data->email;
                    $number = $data->phone;
                    $mail_info['name'] = $data->name;
                    $message = 'This is to inform you that, your account has been deactivated permanently. Please contact with jaazzo admin for further enquiry.'; 
                    send_message($number,$message);
                    $subject = 'Account Deactivation';
                    $mail_info['message']= $message;
                    $email = "maneeshakk16@gmail.com";
                    $mail_head = 'Message From Jaazzo';
                    $status = send_custom_email($email, $mail_head, $mail, $subject, $this->load->view('email_templates/cp_status_change', $mail_info,TRUE));
                            exit(json_encode(array("status"=>TRUE)));
                    }
                else{

                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>"Validation Error")));
            }
        }

     }
    function edit_partnertype_byid(){
        $result=$this->Home_model->get_edit_partnertypebyid();
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    function approve_deal(){

        $result=$this->Home_model->approve_deal_purchase(); 
        if($result){  
            exit(json_encode(array("status"=>TRUE)));
        }
        else{

            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }

    function approve_cp(){


         $data['otp'] = $this->input->post('otp');
         $mail = $this->input->post('email');
        
         $data['id'] = $this->input->post('id');
        
        $email = "maneeshakk16@gmail.com";
        $mail_head = 'Message From Jaazzo';

        
        $status = send_custom_email($email, $mail_head, $mail, 'Sign Up - Channel Partner', $this->load->view('admin/edit_email_channelpartner_otp', $data,TRUE));
        if($status){ 
        $cr = date("Y-m-d h:i:sa");
        $cp_data_input = array('status'=>'APPROVED','created_on'=>$cr);
        $cp_where = array('id'=>$this->input->post('id'));
        $cp_res = update_tbl('gp_pl_channel_partner',$cp_data_input,$cp_where);   
            exit(json_encode(array("status"=>TRUE)));
        }
        else{

            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
     function activate_cp(){
        $result=$this->Home_model->activate_cp($this->input->post());
        if($result){
            $ca_ids = $this->input->post('chck_item_id');
            foreach ($ca_ids as $key => $ca_id) {
                $data = select_by_id("gp_pl_channel_partner",$ca_id);
                $mail = $data->email;
                $number = $data->phone;
                $mail_info['name'] = $data->name;
                $message = 'This is to inform you that, Your account has been activated again. Enjoy jaazzo fecilities again.'; 
                send_message($number,$message);
                $subject = 'Account Activation';
                $mail_info['message']= $message;
                $email = "maneeshakk16@gmail.com";
                $mail_head = 'Message From Jaazzo';
                $status = send_custom_email($email, $mail_head, $mail, $subject, $this->load->view('email_templates/cp_status_change', $mail_info,TRUE));  
            }
            
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }

    function delete_partnerbyid(){
        $result=$this->Home_model->delete_partnerbyid($this->input->post());
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    function get_unapproved_cp(){
        if (has_priv('approve_cp')) {
            $status = "NOT_APPROVED";

            $data=$this->set_menu();
            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $result_count = $this->Home_model->get_cps_spec_by_status_count($param,$status);
            $base_url = base_url() . "all_channelpartners/";
            $count =  $result_count;
            $per_page = 10;
            $this->load_paging($base_url,$count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data['page'] = $page;
            $data['status'] = "Not Approved";
            $data['root_url'] = "get_unapproved_cp";
            $data["data"] = $this->Home_model->get_cps_spec_by_status($param,$status,$per_page, $page);
           //echo json_encode($data["data"]);exit;
            if ($this->input->post('ajax', FALSE)) {
                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'pagination' => $this->pagination->create_links()
                )));
            }
            $this->load->view('admin/edit_view_cp_status_wise',$data);
        }
    }
    function get_approved_cp(){
        if (has_priv('view_approved_cp')) {
            $status = "APPROVED";
            $data=$this->set_menu();
            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $result_count = $this->Home_model->get_cps_spec_by_status_count($param,$status);
            $base_url = base_url() . "all_channelpartners/";
            $count =  $result_count;
            $per_page = 10;
            $this->load_paging($base_url,$count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data['page'] = $page;
            $data['status'] = "Approved";
            $data["data"] = $this->Home_model->get_cps_spec_by_status($param,$status,$per_page, $page);
            $data['root_url'] = "get_approved_cp";
            // echo json_encode($this->pagination->create_links());exit();
            if ($this->input->post('ajax', FALSE)) {
                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'pagination' => $this->pagination->create_links()
                )));
            }
            $this->load->view('admin/edit_view_cp_status_wise',$data);
        }
    }
    function get_active_cp(){
        if (has_priv('view_joined_cp')) {
            $status = "JOINED";
            $data=$this->set_menu();
            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $result_count = $this->Home_model->get_cps_spec_by_status_count($param,$status);
            $base_url = base_url() . "all_channelpartners/";
            $count =  $result_count;
            $per_page = 10;
            $this->load_paging($base_url,$count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data['page'] = $page;
            $data['status'] = "Joined";
            $data["data"] = $this->Home_model->get_cps_spec_by_status($param,$status,$per_page, $page);
            $data['root_url'] = "get_active_cp";
            if ($this->input->post('ajax', FALSE)) {
                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'pagination' => $this->pagination->create_links()
                )));
            }
            $this->load->view('admin/edit_view_cp_status_wise',$data);
        }
    }

    function get_cp_payments()
    {
 if (has_priv('view_coupon_purchased_cp')) {

        $data=$this->set_menu();

         if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $config = array();
        $config["base_url"] = base_url() . "pay_cp/";
        $result_count = $this->Home_model->get_cp_payments_count($param);

        $config["total_rows"] =  $result_count;
        $config["per_page"] = 10;
        //pagination customization using bootstrap styles
        $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
        $config['full_tag_close'] = '</ul></div><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;

        $data["data"] = $this->Home_model->get_cp_payments($param,$config["per_page"], $page);
       //  echo json_encode($data["data"]);exit();
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    
        $this->load->view('admin/edit_view_cp_payments',$data);



        // $data['partner']=$this->Home_model->get_cp_payments();
        // $this->load->view('admin/edit_view_cp_payments',$data);
        } 
    }

    // function approve_cp_payment()
    // {
    //     if (has_priv('approve_cp_payment')) {

    //     $data=$this->set_menu();
    //     $data['partner']=$this->Home_model->get_cp_payments();
    //     $this->load->view('admin/edit_view_cp_payments',$data);
    //     } 
    // }

    function view_channelpartner(){
       if (has_priv('view_cp')) {

        $data=$this->set_menu();
        $data['partner']=$this->Home_model->get_channerpartner();
        $this->load->view('admin/edit_view_channerpartner',$data);
         } 
    }
    function get_channelpartner_byid($id){
        $data=$this->set_menu();
        $data['partner']=$this->Home_model->get_channerpartner_byid($id);
        $lat = $data['partner']['partner']['lattitude'];
        $long = $data['partner']['partner']['longitude'];
        $this->load->library('googlemaps');
        $config['center'] = '"'.$lat.",". $long.'"';
        $marker['position'] = '"'.$lat.",". $long.'"';
        $this->googlemaps->add_marker($marker);
        $config['zoom'] = '8';
        $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $data['category']=$this->Home_model->get_cpcategory();
        $data['subcategory']=$this->Home_model->get_cpscategory();

        $data['countries'] = $this->Home_model->get_countries();

        $country = $data['partner']['partner']['country'];

            if (!empty($country)) {
              
                $data['states'] = get_states_by_country($country);
            }
            $state = $data['partner']['partner']['state'];
            if (!empty($state)) {
            
                $data['cities'] = get_city_by_state($state);
            }
        $data['modules'] = $this->Home_model->get_modules();
        
        $this->load->view('admin/edit_channerpartner_edit',$data);
    }
   public function pan_checks($str)
        {
            
            $id = $this->input->post('hiddenid'); 
            $sql = $this->db->query("select c.id from gp_pl_channel_partner c where c.id != '$id' and c.is_del = 0 and c.pan = '$str'");
           
                if ($sql->num_rows()>0)
                {
                        /*$this->form_validation->set_message('pan_checks', 'The {field} should be unique');*/
                        $this->form_validation->set_message('pan_checks', 'The {field} already exists');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        }
    public function gst_checks($str)
        {
           
            $id = $this->input->post('hiddenid'); 
            $sql = $this->db->query("select c.id from gp_pl_channel_partner c where c.id != '$id' and c.is_del = 0 and c.gst = '$str'");
                if ($sql->num_rows()>0)
                {
                        $this->form_validation->set_message('gst_checks', 'The {field} already exists');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        } 
    function edit_partner(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("channel_type[]", "Channel Partner Type ", "trim|required|htmlspecialchars"); 
            $this->form_validation->set_rules("email", "Email", "valid_email|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Phone", "numeric|trim|required|min_length[10]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("ocname", "Owner Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("oc_mobile", "Owner's Mobile Number", "numeric|trim|min_length[7]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("oc_email", "Owner's Email", "valid_email|trim|required|htmlspecialchars"); 
            $this->form_validation->set_rules("country", "Country", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("state", "State", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("town", "City", "trim|required|htmlspecialchars");
            
            
            
            $this->form_validation->set_rules("area", "Area", "trim|required|htmlspecialchars");
            
            
            
            $this->form_validation->set_rules("latt", "Latitude", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("long", "Longitude", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pan", "PAN Number", "trim|required|htmlspecialchars|exact_length[10]|callback_pan_checks");
            if($this->input->post('gst')){
                $this->form_validation->set_rules("gst", "GST Number", "trim|htmlspecialchars|exact_length[15]|callback_gst_checks");
            }
            if($this->form_validation->run()== TRUE){
                $id = $this->input->post('hiddenid');
                  $data['img']=$this->Home_model->get_item_byid($id);
                  //var_dump($data['img']);exit;
                  if(isset($_FILES['pro']['name']))
                  {
                      $config['upload_path']   = 'upload';
                      $config['allowed_types'] = 'gif|jpg|png|jpeg';
                      $config['max_size']      = 2048;
                      $config['max_width']     = 2048;
                      $config['max_height']    = 2048;
                      $this->load->library('upload', $config);
                      $this->upload->initialize($config);
                      if(!$this->upload->do_upload('pro'))
                      {
                          exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));

                      }
                      else
                      {
                          $uploading_file = $this->upload->data();
                          $image_file = $uploading_file['file_name'];
                          $this->upload->do_upload($image_file);

                         ($data['img']['profile_image'])?unlink($data['img']['profile_image']):'';

                      }
                      $image_file1 = "upload/".$image_file;
                  }
                  else{
                      $image_file1=$data['img']['profile_image'];
                  }
                   if(isset($_FILES['bri']['name']))
                  {
                      $config['upload_path']   = 'assets/admin/brand/';
                      $config['allowed_types'] = 'gif|jpg|png|jpeg';
                      $config['max_size']      = 2048;
                      $config['max_width']     = 2048;
                      $config['max_height']    = 2048;
                      $this->load->library('upload', $config);
                      $this->upload->initialize($config);
                      if(!$this->upload->do_upload('bri'))
                      {
                          exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));

                      }
                      else
                      {
                          $uploading_file = $this->upload->data();
                          $image_file = $uploading_file['file_name'];
                          $this->upload->do_upload($image_file);
                          
                           ($data['img']['brand_image'])?unlink($data['img']['brand_image']):'';
                          /*unlink($data['img']['brand_image']);*/

                      }
                      $image_file2 = "assets/admin/brand/".$image_file;
                  }
                  else{
                      $image_file2=$data['img']['brand_image'];
                  }
                  $creg =$data['img']['company_registration'];$license = $data['img']['license'];
                
                    $config['upload_path'] =  './uploads/cp_docs';
                    $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
                    $config['max_size'] = '2000000';
                    $config['remove_spaces'] = true;
                    $config['overwrite'] = false;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if(isset($_FILES['company_registration']['name'])){ 
                        if (!$this->upload->do_upload('company_registration')) {
                        exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
                        } else {
                        $fileData1 = $this->upload->data();
                        $creg ='uploads/cp_docs/'.$fileData1['file_name'];
                        }
                    }
                    if(isset($_FILES['license']['name'])){
                        if (!$this->upload->do_upload('license')) {
                        exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
                        } else {
                        $fileData2 = $this->upload->data();
                        $license = 'uploads/cp_docs/'.$fileData2['file_name'];
                        }
                    }

                $result=$this->Home_model->edit_partnerbyid($image_file1,$image_file2,$creg,$license);

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

      if (has_priv('view_cp_type')) {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $result_count = $this->Home_model->get_all_partner_type_count($param);
        $base_url = base_url() . "all_partner_types/";
        $count =  $result_count;
        $per_page = 10;
        $this->load_paging($base_url,$count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Home_model->get_all_partner_type($param,$per_page, $page);
        //echo json_encode($data["data"]);exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $data['subcategory']=$this->Home_model->get_cpscategory();
        $data['get_allcategory']=$this->Home_model->get_catNsubCategory();
        $data['cat']=$this->Home_model->get_category();
        $this->load->view('admin/edit_view_channerpartner_type',$data);
    }
    }
    
    function partner_type(){
        $data=$this->set_menu();
        $data['get_allcategory']=$this->Home_model->get_catNsubCategory();
        $this->load->view('admin/edit_add_channelpartner_type',$data);
    }
    function new_partner_type(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("category", "Category", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("title", "Title", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("description", "Description", "trim|required|htmlspecialchars");
            $mailms['otp']=$this->input->post('email');
            $mailms['mail']=$this->input->post('email');
            if($this->form_validation->run()== TRUE){
                $result=$this->Home_model->add_partnertype();
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{

                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>"Validation Error")));
            }
        }

     }
     function delete_partnertype(){
        $result=$this->Home_model->delete_partnertypebyid($this->input->post());
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    function deal_new(){
        if (has_priv('manage_deal')) {
            $data=$this->set_menu();
            // $data['deal'] = $this->Home_model->get_deal_details();
            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $result_count = $this->Home_model->get_deals_count($param);
            $status=($result_count>0)?true:false;
            $base_url = base_url() . "deal_settings/";
            $count =  $result_count;
            $per_page = 10;
            $this->load_paging($base_url,$count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data['page'] = $page;
            $data["data"] = $this->Home_model->get_all_deal_details($param,$per_page, $page);
            // echo json_encode($data["data"]);exit(); 
            if ($this->input->post('ajax', FALSE)) {
                exit(json_encode(array(
                    'status'=>$status,
                    'data' => $data["data"],
                    'search'=>$param,
                    'pagination' => $this->pagination->create_links()
                )));
            }
            $this->load->view('admin/add_new_deal',$data);
        }  
    }
    function transaction1(){
        if (has_priv('view_pending_amount')) {
            $data=$this->set_menu();
            $data['cp_details']=$this->Home_model->get_transaction_details();
            $this->load->view('admin/edit_view_transaction',$data);
        }   
    }
    function transaction(){

      if (has_priv('view_pending_amount')) {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $result_count = $this->Home_model->get_pending_transaction_count($param);
        $base_url = base_url() . "get_pending_transaction/";
        $count =  $result_count;
        $per_page = 10;
        $this->load_paging($base_url,$count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Home_model->get_pending_transaction($param,$per_page, $page);
       // echo json_encode($data["data"]);exit(); 
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'pagination' => $this->pagination->create_links()
            )));
        }
        
        $this->load->view('admin/edit_view_transaction',$data);
    }
    }
    function pending_transaction1(){
   if (has_priv('view_pending_amount')) {
          $data=$this->set_menu();
          $data['cp_details']=$this->Home_model->get_transaction_details2();
          $this->load->view('admin/edit_view_cptransaction',$data);
    }
     } 
     function pending_transaction(){

      if (has_priv('view_pending_amount')) {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $result_count = $this->Home_model->get_cp_pending_transaction_count($param);
        $base_url = base_url() . "get_pending_transaction/";
        $count =  $result_count;
        $per_page = 10;
        $this->load_paging($base_url,$count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Home_model->get_cp_pending_transaction($param,$per_page, $page);
       //echo json_encode($data["data"]);exit(); 
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'pagination' => $this->pagination->create_links()
            )));
        }
        
        $this->load->view('admin/test',$data);
    }
    }  
    function new_transaction(){

        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("payment_for[]", "Payment For", "trim|required|htmlspecialchars");
            $p_for = $this->input->post('payment_for');
            if(in_array('coupon', $p_for) && in_array('wallet', $p_for)) {
              $this->form_validation->set_rules("pay_amount", "Wallet Amount", "trim|required|htmlspecialchars");
              $this->form_validation->set_rules("pay_coupon", "Coupon Amount", "trim|required|htmlspecialchars");
            }
            else if(in_array('coupon', $p_for)){
              $this->form_validation->set_rules("pay_coupon", "coupon Amount", "trim|required|htmlspecialchars");
            }else if(in_array('wallet', $p_for)){
              $this->form_validation->set_rules("pay_amount", "Wallet Amount", "trim|required|htmlspecialchars");
            }
           
            $this->form_validation->set_rules("payment_mode", "Payment Mode", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("transaction_date", "Transaction Date", "trim|required|htmlspecialchars");
            if($this->input->post('payment_mode')=='cheque'){
                $this->form_validation->set_rules("cheque_number", "Cheque Number", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("bank", "Bank", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("cheque_date", "Cheque Date", "trim|required|htmlspecialchars");
            }
            if($this->form_validation->run()== TRUE){
                $loginsession = $this->session->userdata('logged_in_admin');
                $userid=$loginsession['user_id'];
                $lgid = $this->input->post('cp_id');
                $result=$this->Home_model->new_transaction($userid,$lgid);
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
    
    function transaction_history1()
    {
        $data=$this->set_menu();
        $data['cp_details'] = $this->Home_model->transaction_history1();
        //echo json_encode($data['cp_details']);exit(); 
        $this->load->view('admin/cp_transaction_history',$data);
    }
    function cp_transaction_history(){

        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $from = $this->input->post('from');$to = $this->input->post('to');
        if (!empty($from) and !empty($to)) {
            $from = convert_to_mysql_date($from);
            $to = convert_to_mysql_date($to);
        }else if(!empty($from) and empty($to)){
            $from = convert_to_mysql_date($from);
            $to = "";
        }else if(empty($from) and !empty($to)){
            $to = convert_to_mysql_date($to);
            $from = "";
        }
        else{
            $from = '';
            $to = '';
        }
       
        $result_count = $this->Home_model->get_cp_transaction_history_count($param,$from,$to);

        $base_url = base_url() . "all_cp_transaction_history/";
        $count =  $result_count;
        $per_page = 10;
        $this->load_paging($base_url,$count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Home_model->get_cp_transaction_history($param,$per_page, $page,$from,$to);
        //echo json_encode($data["data"]);exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'pagination' => $this->pagination->create_links()
            )));
        }
      
        $this->load->view('admin/cp_transaction_history',$data);
    }
    function exec_transaction_history()
    {
       if (has_priv('view_executive_transaction_history')) { 
        $data=$this->set_menu();
        $data['cp_details'] = $this->Home_model->exec_transaction_history();
         if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }

        $result_count = $this->Home_model->exec_transaction_history_count($param);
        $base_url = base_url() . "exec_transaction_history/";
        $count =  $result_count;
        $per_page = 10;
        $this->load_paging($base_url,$count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Home_model->exec_transaction_history_all($param,$per_page, $page);
        //echo json_encode($data["data"]);exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                   'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }

        //print_r( $data['cp_details']);
        $this->load->view('admin/exec_transaction_history',$data);
    }    }
    function na_cp_transaction1(){
          $data=$this->set_menu();
          $data['cp_details']=$this->Home_model->get_na_cp_transaction();
          $this->load->view('admin/edit_view_na_transaction',$data);   
    }
    function na_cp_transaction(){

        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $result_count = $this->Home_model->get_all_na_cp_transaction_count($param);
        $base_url = base_url() . "transaction/";
        $count =  $result_count;
        $per_page = 10;
        $this->load_paging($base_url,$count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Home_model->get_all_na_cp_transaction($param,$per_page, $page);
        //echo json_encode($data["data"]);exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,

                'pagination' => $this->pagination->create_links()
            )));
        }
        
        $this->load->view('admin/edit_view_na_transaction',$data);

    }
    function cp_status(){

      if (has_priv('deactivate_cp')) {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $result_count = $this->Home_model->get_all_cp_status_count($param);
        $base_url = base_url() . "cp_status/";
        $count =  $result_count;
        $per_page = 10;
        $this->load_paging($base_url,$count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = $this->Home_model->get_all_cp_status($param,$per_page, $page);
        //echo json_encode($data["data"]);exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'pagination' => $this->pagination->create_links()
            )));
        }

        $this->load->view('admin/cp_status_change',$data);
     }
    }
    function cp_change_active_status()
    {   $status = $this->input->post('status');
        $data = $this->Home_model->cp_change_active_status($status);
        if($data){
            $mail = $data['email'];
            $number = $data['mobile'];
            $mail_info['name'] = $data['name'];
            $message1 = ($status==0) ?'This is to inform you that, your account has been activated again, enjoy jaazzo facilities.' :'This is to inform you that, your account has been frozen due to failure in payment. Please clear all the dues and enjoy jaazzo facilities.'; 
            $message2 = ($status==0) ?'Your account has been activated again, enjoy jaazzo fecilities.' :'Your account has been frozen due to failure in payment. Please clear all the dues and enjoy jaazzo facilities.'; 
            send_message($number,$message2);
            $subject = ($status==0) ? 'Account Activation' : 'Account Deactivation';
            $mail_info['message']= $message1;
            $email = "maneeshakk16@gmail.com";
            $mail_head = 'Message From Jaazzo';
            $status = send_custom_email($email, $mail_head, $mail, $subject, $this->load->view('email_templates/cp_status_change', $mail_info,TRUE));
            exit(json_encode(array('status'=>true)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'Database Error Occured')));
        }
    }
     function add_new_deal(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("pro_name", "Deal", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_description", "Description ", "trim|required|htmlspecialchars");
            //$this->form_validation->set_rules("amount", "Amount", "numeric|trim|required|htmlspecialchars|greater_than[0]");
            $this->form_validation->set_rules("duration", "Durtion", "numeric|trim|required|htmlspecialchars");

            if($this->form_validation->run()== TRUE){


                $result = $this->Home_model->add_new_deal();

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
     function update_deal_by_id(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("title", "Deal", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("description", "Description ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("duration", "Durtion", "numeric|trim|required|htmlspecialchars");

            if($this->form_validation->run()== TRUE){


                $result = $this->Home_model->update_deal_by_id();

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
    function delete_deal(){
        $result=$this->Home_model->delete_deal($this->input->post());
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    
    function commission_approval()
    {
     if (has_priv('view_commision')) {

        $data=$this->set_menu();

         if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $config = array();
        $config["base_url"] = base_url() . "pay_cp/";
        $result_count = $this->Home_model->get_commission_approval_request_count($param);

        $config["total_rows"] =  $result_count;
        $config["per_page"] = 10;
        //pagination customization using bootstrap styles
        $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
        $config['full_tag_close'] = '</ul></div><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;

        $data["data"] = $this->Home_model->get_commission_approval_requests($param,$config["per_page"], $page);
       //  echo json_encode($data["data"]);exit();
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    
        $this->load->view('admin/edit_view_pending_approval',$data);
        } 
    }
    function approve_cp_new_commission()
    {  
        $data = $this->Home_model->approve_cp_new_commission();
        if($data){
            exit(json_encode(array('status'=>true)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'Database Error Occured')));
        }
    }

    
    function get_cp_transaction($id){
        $data=$this->set_menu();
        $data['transaction']=$this->Home_model->last_transaction_details($id,1);
        $this->load->view('admin/edit_transaction_details',$data);
    }
    function get_admin_transaction($id){
        $data=$this->set_menu();
        $data['transaction']=$this->Home_model->last_transaction_details(1,$id);
        $this->load->view('admin/edit_transaction_details',$data);
    }
    function transaction_history(){
if (has_priv('view_transaction_history')) {

        $data=$this->set_menu();
        $data['transaction']=$this->Home_model->last_transaction_details(1,$id);
        $this->load->view('admin/edit_transaction_details',$data);
    } }
  function approve_cp_transaction()
    {  
       if (has_priv('approve_cp_transaction')) {
        $data = $this->Home_model->approve_cp_transaction();
        if($data){
            exit(json_encode(array('status'=>true)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'Database Error Occured')));
        }
    }
   }
  function reject_cp_transaction()
    {  
        $data = $this->Home_model->reject_cp_transaction();
        if($data){
            exit(json_encode(array('status'=>true)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'Database Error Occured')));
        }
   }

///////////////////////////////////////
/*add ba*/
    function add_ba()
    {
if (has_priv('add_ba')||has_priv('add_ba_design')) {

        $data=$this->set_menu();
        $data['countries'] = $this->Home_model->get_countries();
      
        $this->load->view('admin/edit_add-ba-settings',$data);

    }

    }
    function new_ba(){

        if($this->input->is_ajax_request()){

   
            $this->form_validation->set_rules("ba_name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("ba_mobile", "Mobile", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("ba_email", "Email", "valid_email|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("ba_company_Name", "Company Name","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("office_phone", "Office Phone", "trim|required|htmlspecialchars");
       
            $this->form_validation->set_rules("office_email_id", "valid_email", "trim|required|htmlspecialchars");

            $this->form_validation->set_rules("country", "Select Country","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("state", "Select State","trim|required|htmlspecialchars");

            if( $this->form_validation->run() == TRUE )
            {
                $country = $this->input->post('country');
                $mail = $this->input->post('ba_email');
                if(!empty($country)){
                    $countrydata = get_countryName_by_id($this->input->post('country'));

                    $countryName = $countrydata['name'];
                }else{
                    $countryName = '';
                }
                $stst = $this->input->post('state');
                if(!empty($stst)){
                    $statedata = get_stateName_by_id($this->input->post('state'));
                    $stateName = $statedata['name'];
                }else{
                    $stateName = '';
                }
                $cty = $this->input->post('city');
                if(!empty($cty)){
                    $citydata = get_cityName_by_id($this->input->post('city'));
                    $cityName = $citydata['name'];
                }else{
                    $cityName = '';
                }
               //echo $cityName;exit();
            $result=$this->Home_model->add_New_ba($countryName,$stateName,$cityName);


                  if($result)
                            { 
                               
                                $data['id'] = $result['info']['user_id'];
                                $data['otp'] = $result['info']['otp'];
                                $email = "kavyababu19@gmail.com";
                                $mail_head = 'Message From Jaazzo';
                               
                                $status = send_custom_email($email, $mail_head, $mail, 'Sign Up - Jaazzo Store', $this->load->view('templates/public/mail/ba_sign_up', $data,TRUE));

                                if($status)
                                {
                                    exit(json_encode(array('status'=>true)));
                                }else{
                                    exit(json_encode(array("status"=>TRUE)));
                                }
                            }else{
                                exit(json_encode(array('status'=>false, 'reason'=>'Database Error')));
                            }


            }else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }

        }
        else{
            show_error("We are unable to process this request on this way!");
        }
    }
    function get_states_by_country()
    {

        $country_id = $this->input->get('country_id');
        $country_id = intval($country_id);
        $data = get_states_by_country($country_id);

        if(!empty($data))
        {
            exit(json_encode(array('status' => true, 'data'=> $data)));
        }else{
            exit(json_encode(array('status' => false, 'reason'=> 'Please try again later')));
        }
    }
    function get_city_by_state()
    {
        $state_id = $this->input->get('state_id');
        $state_id = intval($state_id);
        $data = get_city_by_state($state_id);
        if(!empty($data))
        {
            exit(json_encode(array('status' => true, 'data'=> $data)));
        }else{
            exit(json_encode(array('status' => false, 'reason'=> 'Please try again later')));
        }
    }
    function ba_view()
    {
        if (has_priv('view_ba')||has_priv('view_ba_des')) {
            $data=$this->set_menu();
            // $data['viewba']=$this->Home_model->get_baview();
            if ($this->input->post('search')) {
                $param = $this->input->post('search');
                
            }else{
                $param = '';
            }
            $base_url = base_url() . "view_ba/";

            $result_count =$this->Home_model->get_all_ba_count($param);
          
            $per_page = 10;
            $this->load_paging($base_url,$result_count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data["data"] = $this->Home_model->get_all_ba($param,$per_page,$page);
            if ($this->input->post('ajax', FALSE)) {
                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'status' => !empty($data["data"])?1:0,
                    'pagination' => $this->pagination->create_links()
                )));
            }
            $this->load->view('admin/edit-view-ba',$data);
        }     
    }

    function get_ba_view_byid($id)
    {
      $data=$this->set_menu();
      $data['countries'] = $this->Home_model->get_countries();
      $data['viewba']=$this->Home_model->get_ba_view_byid($id);
      $country = $data['viewba']['country'];
     
            if (!empty($country)) {
                $countryData = getCountry_byName($country);
                //print_r($countryData);
                $country_id = $country;//Data['id'];
                $data['states'] = get_states_by_country($country_id);
            }
            $state = $data['viewba']['state'];
            if (!empty($state)) {
                $stateData = getStatebyName($state);
                $state_id = $state;//Data['id'];
                $data['cities'] = get_city_by_state($state_id);
            }
      //print_r( $data['viewba']);
      $this->load->view('admin/edit-ba-edit',$data);
    }


    function edit_ba(){

        if($this->input->is_ajax_request()){
       
            $this->form_validation->set_rules("ba_name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("ba_mobile", "Mobile", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("ba_email", "Email", "valid_email|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("ba_company_Name", "Company Name","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("office_phone", "Office Phone", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("office_email_id", "valid_email", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("city", "City", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("sel_country", "Select Country","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("state", "Select State","trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                    $country = $this->input->post('sel_country');
                 
                    if(!empty($country)){
                        $countrydata = get_countryName_by_id($this->input->post('sel_country'));
                        //($countrydata);
                        $countryName = $countrydata['name'];
                    }else{
                        $countryName = '';
                    }
                    $stst = $this->input->post('state');
                    if(!empty($stst)){
                        $statedata = get_stateName_by_id($this->input->post('state'));
                        $stateName = $statedata['name'];
                    }else{
                        $stateName = '';
                    }
                    $cty = $this->input->post('city');
                    if(!empty($cty)){
                        $citydata = get_cityName_by_id($this->input->post('city'));
                        $cityName = $citydata['name'];
                    }else{
                        $cityName = '';
                    }
                $result=$this->Home_model->edit_ba_by_id($countryName,$stateName,$cityName);

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

   
    function delete_ba()
    {
        $result=$this->Executives_model->delete_ba($this->input->post());

        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }

//admin add executive
function exec_add(){
if (has_priv('add_exec') || has_priv('add_bde_des')) {
        
        $data=$this->set_menu();
        $this->load->library('googlemaps');
        $config['center'] = '10.804305026919454, 76.11534118652344';
        $config['zoom'] = '8';
        $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $data['countries'] = $this->Home_model->get_countries();
        $data['designations']=$this->Executives_model->get_desigsviewall();
        $this->load->view('admin/exec-add',$data);
    }
    }
  function exec_addins(){
    if($this->input->is_ajax_request()){

        $this->form_validation->set_rules('ename', 'Name', 'required|trim');
        $this->form_validation->set_rules('mob', 'Mobile', 'required|min_length[7]|max_length[12]|trim|numeric');
        if($this->form_validation->run()==TRUE)
        {
          $email = $this->input->post('email');
          $mobile = $this->input->post('mob');
          $validate_email= $this->Home_model->validate_email($email);
          $validate_phone= $this->Home_model->validate_phone($mobile);
          //print_r($validate_email);exit();
          $country = $this->input->post('country');
          if($validate_phone['status'] === TRUE){
            if($validate_email['status'] === TRUE){
          
                if(!empty($country)){
                    $countrydata = get_countryName_by_id($this->input->post('country'));
                    $countryName = $countrydata['name'];
                }else{
                    $countryName = '';
                }
                $stst = $this->input->post('state');
                if(!empty($stst)){
                    $statedata = get_stateName_by_id($this->input->post('state'));
                    $stateName = $statedata['name'];
                }else{
                    $stateName = '';
                }
                $cty = $this->input->post('city');
                if(!empty($cty)){
                    $citydata = get_cityName_by_id($this->input->post('city'));
                    $cityName = $citydata['name'];
                }else{
                    $cityName = '';
                }
      
                $session_array = $this->session->userdata('logged_in_admin');
                $sid = $session_array['id'];
                $a  = '1';
                $a1 = $this->input->post('ename');
                $a2 = $this->input->post('dsig');
                $a3 = $this->input->post('email');
                $a4 = $this->input->post('mob');
                $a5 = $this->input->post('address');
                $str = random_password(6);
               
                //$password =encrypt($str);
                $date = date('Y-m-d');
                $data = array(  'sales_desig_type_id' => $a2,
                                'name' => $a1,
                                'parent_id' => $sid,
                                'created_by' => $sid,
                                'created_on' => $date ,
                                'last_promotion_date' =>$date);
                $data1 = array( 'name' => $a1,
                                'phone' => $a4,
                                'address' => $a5,
                                'email' =>$a3,
                                'country' =>$countryName,
                                'state' => $stateName,
                                'city' => $cityName,
                                'image' =>'default-avatar.png',
                                'status' => '1');
                $data3 = array( 
                                'mobile' => $a4,
                                'email' => $a3,
                                'type' => 'executive',
                                'parent_login_id'=>'1');
             
                $result=$this->Home_model->insert_execbasics($data,$data1,$data3);
                if($result)
                  {
                    $data['id']=$result;
                    //var_dump($result);exit();
                    $email = "kavyababu19@gmail.com";
                    $mail_head = 'Message From Jaazzo';
                    $status = send_custom_email( $email, $mail_head,$a3, 'Sign Up - Executive', $this->load->view('templates/public/mail/exec_sign_up',$data,TRUE ));
                    if($status)
                     {
                      exit(json_encode(array('status'=>true)));
                      }else{
                      exit(json_encode(array("status"=>TRUE)));
                      }
                  }else{
                    exit(json_encode(array('status' => false, 'reason' => 'Please try again later')));
              
                  }
            }
            else{
            exit(json_encode(array('status' => false, 'reason'=>$validate_email['reason'])));
            }
          }        
          else{
            exit(json_encode(array('status' => false, "reason"=>$validate_phone['reason'])));
          }
        }else{
            exit(json_encode(array('status'=>FALSE,'reason'=>validation_errors())));
            }
    }else{
        show_error("Unable To Process The Request In This Way");
        }
  }


    function exec_view(){


      if (has_priv('view_exec')|| has_priv('view_bde_des')) {
        $data=$this->set_menu();
        $data['designations']=$this->Home_model->get_desigsviewall();
        //$data['executives']=$this->Executives_model->get_executives();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $config = array();
        $config["base_url"] = base_url() . "exe-view/";
        $result_count = $this->Home_model->get_executives_count($param);
        $config["total_rows"] =  $result_count;
        $config["per_page"] =10;
        //pagination customization using bootstrap styles
        $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
        $config['full_tag_close'] = '</ul></div><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;

        $data["data"] = $this->Executives_model->get_executives($param,$config["per_page"], $page);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    
        $this->load->view('admin/exec-view',$data);
        }
    }
    
    function promoted_employee(){


if (has_priv('view_promoted_employee')) {
        $data=$this->set_menu();






                if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $config = array();
        $config["base_url"] = base_url() . "promoted_employee/";
        $result_count = $this->Home_model->get_promoted_employee_count($param);

        $config["total_rows"] =  $result_count;
        $config["per_page"] = 10;
        //pagination customization using bootstrap styles
        $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
        $config['full_tag_close'] = '</ul></div><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;

        $data["data"] = $this->Home_model->promoted_employee($param,$config["per_page"], $page);
       //  echo json_encode($data["data"]);exit();
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    
        $this->load->view('admin/view_promoted_employee',$data);



        
        // $data['promoted_employee']=$this->Home_model->promoted_employee();
        // $this->load->view('admin/view_promoted_employee',$data);


        }
    }
    
    
    function set_gift(){

        if (has_priv('add_promotion_gifts')) {

        $data=$this->set_menu();
        $data['team_leader']=$this->Home_model->get_team_leader_desig();
        $data['edit_team_leader']=$this->Home_model->get_team_leader_edit();
        $data['gift']=$this->Home_model->get_gift_package();
        $this->load->view('admin/add_promotion_gift',$data);
    }

 }

    function add_gift(){
      if($this->input->is_ajax_request()){
       
            $this->form_validation->set_rules("name", "Gift Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("dsig", "Designation From", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("desigto", "Designation To", "trim|required|htmlspecialchars");
              if($this->form_validation->run()== TRUE){
                  if (!empty($_FILES['userfile']['name'])) {
                  $files = $_FILES;
                  $_FILES['userfile']['name'] = $files['userfile']['name'];
                  $_FILES['userfile']['type'] = $files['userfile']['type'];
                  $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'];
                  $_FILES['userfile']['error'] = $files['userfile']['error'];
                  $_FILES['userfile']['size'] = $files['userfile']['size'];
                  $config = array();
                  $config['upload_path'] = './uploads/gifts/';
                  $config['allowed_types'] = 'gif|jpg|jpeg|png|flv|f4v';
                  $config['max_size']      = '2400';
                  $config['overwrite']     = FALSE;
                          $this->load->library('upload', $config);
                          $this->upload->initialize($config);
                          $this->upload->do_upload('userfile');
                              
                                  $fileName = $_FILES['userfile']['name'];
                                  $fileName = str_replace(' ', '_', $fileName);
                                  $images = $fileName;
                                 
                  $result=$this->Home_model->add_gift($images);

                  }
                  else{
                    $images = 'gift.jpg';
                                 
                  $result=$this->Home_model->add_gift($images);
                  }
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
function update_gift()
{
      
        if($this->input->is_ajax_request())
        {
            
           $this->form_validation->set_rules("name", "Gift Name", "trim|required|htmlspecialchars");
           $this->form_validation->set_rules("dsig", "Designation From", "trim|required|htmlspecialchars");
           $this->form_validation->set_rules("desigto", "Designation To", "trim|required|htmlspecialchars");
              if($this->form_validation->run()== TRUE){
                  if (!empty($_FILES['userfile']['name'])) {
                  $files = $_FILES;
                  $_FILES['userfile']['name'] = $files['userfile']['name'];
                  $_FILES['userfile']['type'] = $files['userfile']['type'];
                  $_FILES['userfile']['tmp_name'] = $files['userfile']['tmp_name'];
                  $_FILES['userfile']['error'] = $files['userfile']['error'];
                  $_FILES['userfile']['size'] = $files['userfile']['size'];
                  $config = array();
                  $config['upload_path'] = './uploads/gifts/';
                  $config['allowed_types'] = 'gif|jpg|jpeg|png|flv|f4v';
                  $config['max_size']      = '2400';
                  $config['overwrite']     = FALSE;
                          $this->load->library('upload', $config);
                          $this->upload->initialize($config);
                          $this->upload->do_upload('userfile');
                              
                                  $fileName = $_FILES['userfile']['name'];
                                  $fileName = str_replace(' ', '_', $fileName);
                                  $images = $fileName;

                }
                else{

                  $images = '';
                }
                $result=$this->Home_model->update_gift($images);

              
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
       }
}
    function update_executive($id){

        $data=$this->set_menu();
        $data['countries'] = $this->Home_model->get_countries();
        $data['designations']=$this->Home_model->get_desigsviewall();
        $data['executives']=$this->Home_model->get_executives_id($id);
        $country = $data['executives']['country'];

            if (!empty($country)) {
                $countryData = getCountry_byName($country);
               // 
                $country_id = $countryData['id'];
                $data['states'] = get_states_by_country($country_id);
            }
            $state = $data['executives']['state'];
            if (!empty($state)) {
                $stateData = getStatebyName($state);
                $state_id = $stateData['id'];
                $data['cities'] = get_city_by_state($state_id);
            }
        
        $this->load->view('admin/exec_edit',$data);
    }
        function edit_addins(){
        if($this->input->is_ajax_request()){

        $this->form_validation->set_rules('ename', 'Name', 'required|trim');
        $this->form_validation->set_rules('mob', 'Mobile', 'required|min_length[7]|max_length[12]|trim|numeric');
            if($this->form_validation->run()==TRUE)
            {
                $country = $this->input->post('country');

                    if(!empty($country)){
                        $countrydata = get_countryName_by_id($this->input->post('country'));
                        $countryName = $countrydata['name'];
                    }else{
                        $countryName = '';
                    }
                    $stst = $this->input->post('state');
                    if(!empty($stst)){
                        $statedata = get_stateName_by_id($this->input->post('state'));
                        $stateName = $statedata['name'];
                    }else{
                        $stateName = '';
                    }
                    $cty = $this->input->post('city');
                    if(!empty($cty)){
                        $citydata = get_cityName_by_id($this->input->post('city'));
                        $cityName = $citydata['name'];
                    }else{
                        $cityName = '';
                    }

                $session_array = $this->session->userdata('logged_in_admin');
                $sid = $session_array['id'];
                $a  = '1';
        $a1 = $this->input->post('ename');
        $a2 = $this->input->post('dsig');
        $a3 = $this->input->post('email');
        $a4 = $this->input->post('mob');
        $a5 = $this->input->post('address');

       
        $date = date('Y-m-d');
        $data = array(  'sales_desig_type_id' => $a2,
                        'name' => $a1,
                        'parent_id' => $sid,
                        'created_by' => $sid,
                        'created_on' => $date );
        $data1 = array( 'name' => $a1,
                        'phone' => $a4,
                        'address' => $a5,
                        'email' =>$a3,
                        'country' =>$countryName,
                        'state' => $stateName,
                        'city' => $cityName,

                        'status' => '1');
        $result=$this->Home_model->edit_execbasics($data,$data1);
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }
            }else{
            exit(json_encode(array('status'=>FALSE,'reason'=>validation_errors())));
            }
        }else{
            show_error("Unable To Process The Request In This Way");
        }
    }

    function delete_exectives()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->Home_model->delete_exectives($this->input->post());
            if($qry)
            {
                exit(json_encode(array('status'=>TRUE)));
            }else{
                exit(json_encode(array('status'=>FALSE, 'reason'=>'Please try again later..!')));
            }
        }else{
            show_error("Unable to process the request in this way");
        }
    }
// promotion setting


    function get_exec_to_data()
    {

        $data['result']=$this->Home_model->get_exec_to_data();
        if($data){
            exit(json_encode(array("status"=>TRUE,"data"=>$data)));
        }else{
            exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
        }
    }



    function exec_setaddins(){
       
        $a=1;
        $a2 = $this->input->post('dsig');
        $a3 = $this->input->post('module');
        $a6 = $this->input->post('todsig');
        $date = date('Y-m-d');

        $club = 'club_membership';
        if($a3 == $club){
            $am='1';
             
        }
        else{
            $am = $a3;
        }

   
            $data = array(
            'designation_id' => $a2,
            'sysmodule_id' => $am,
            'promotion_designation'=>$a6,

            'date' => $date);

          $result=$this->Home_model->insert_setexec($data);
//        }
        if($result){
            exit(json_encode(array("status"=>TRUE)));

        }else{
            exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
        }
    }

    function exec_sel(){
        $data=$this->set_menu();
        $data['designations']=$this->Home_model->get_desigsview();
        //print_r($data['designations']);exit();
        $data['modules']=$this->Home_model->get_modules();
        $data['module']=$this->Home_model->get_module();
        $this->load->view('admin/exec-promo-settings-select',$data);
    }
    function exec_setadd(){
        $data=$this->set_menu();
        $data['designations1']=$this->Home_model->get_desigsadd();
        //print_r($data['designations1']);exit();
        $data['team_leader']=$this->Home_model->get_team_leader();
        $data['modules1']=$this->Home_model->get_modules1();
        $data['module']=$this->Home_model->get_module();
       
        $this->load->view('admin/exec-promo-settings-add',$data);
    }
/*    function exec_setview(){
        $a2 = $this->input->post('dsig');
        $a6 = $this->input->post('todsig');
        $data=$this->set_menu();
      $data['designation']=$this->Executives_model->get_desigid($a2);
        $data['modules']=$this->Executives_model->get_modules();
        $data['settings']=$this->Executives_model->get_settings($a2);
        
        $data['todesig']=$this->Executives_model->get_protion_settings_id($a2);
       // echo json_encode($data['settings']);exit;

        $this->load->view('admin/exec-promo-settings-view',$data);
    }
*/
function exec_seteditins(){
        $a=1;
        $id = $this->input->post('id');
    
        $a2 = $this->input->post('dsig');
        $a3 = $this->input->post('module');
        $a4 = $this->input->post('co');
        $a5 = $this->input->post('am');
        $a6 = $this->input->post('to');
        $a7 = $this->input->post('pd');
        $a8 = $this->input->post('co2');
        $a9 = $this->input->post('am2');
        $a10 = $this->input->post('pd2');
        $a11 = $this->input->post('co3');
        $a12 = $this->input->post('am3');
        $a13 = $this->input->post('pd3');
        $date = date('Y-m-d');
        $club="club_membership";
        $a3 = $this->input->post('module');
         

         if($a3==$club){
            $am='1';
          
  
             
        }
         
        if($a5 == ''){
            $am1 = '0';
        }
        else{
            $am1 = $a5;
           
        }
        if($a9 == ''){
            $am2 = '0';
        }
        else{
            $am2 = $a5;
        }
        if($a12 ==''){
            $am3 = '0';
        }
        else{
            $am3 = $a12;
        }
        
   
            $data = array(
            'designation_id' => $a2,
            'sysmodule_id' => $am,
            'promotion_count' => $a4,
            'promotion_amount' => $am1,
            'promotion_designation'=>$a6,
            'promotion_period' => $a7,
            'promotion_count2' => $a8,
            'promotion_amount2' => $am2,
            'promotion_period2' => $a10,
            'promotion_count3' => $a11,
            'promotion_amount3' => $am3,
            'promotion_period3' => $a13,
            'date' => $date);
      
            $result=$this->Executives_model->update_setexec($data,$id);
            if($result){
            exit(json_encode(array("status"=>TRUE)));
            }else{
            exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
            }
    }
function exec_seteditins_team(){
        $a=1;
        $id = $this->input->post('id');
    
        $a2 = $this->input->post('dsig');
        $a3 = $this->input->post('module1');
        $a4 = $this->input->post('cot');
        $a5 = $this->input->post('amt');
        $a6 = $this->input->post('to');
        $a7 = $this->input->post('pdt');
        $a8 = $this->input->post('cot2');
        $a9 = $this->input->post('amt2');
        $a10 = $this->input->post('pdt2');
        $a11 = $this->input->post('cot3');
        $a12 = $this->input->post('amt3');
        $a13 = $this->input->post('pdt3');
        $date = date('Y-m-d');
       
        if($a3 == "Club Membership"){
            $am='1';
            
             
        }
        else{
            $am = $a3;

        }
      
        if($a5 == ''){
            $am1 = '0';
        }
        else{
            $am1 = $a5;
           
        }
        if($a9 == ''){
            $am2 = '0';
        }
        else{
            $am2 = $a5;
        }
        if($a12 ==''){
            $am3 = '0';
        }
        else{
            $am3 = $a12;
        }
        
   
            $data = array(
            'designation_id' => $a2,
            'sysmodule_id' => $am,
            'promotion_count' => $a4,
            'promotion_amount' => $am1,
            'promotion_designation'=>$a6,
            'promotion_period' => $a7,
            'promotion_count2' => $a8,
            'promotion_amount2' => $am2,
            'promotion_period2' => $a10,
            'promotion_count3' => $a11,
            'promotion_amount3' => $am3,
            'promotion_period3' => $a13,
            'date' => $date);
            
            $result=$this->Executives_model->update_setexec($data,$id);
            if($result){
            exit(json_encode(array("status"=>TRUE)));
            }else{
            exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
            }
    }
       function get_promotion_view(){
        $data=$this->Home_model->get_promotion_view();   
        if($data){
            exit(json_encode(array('status'=>TRUE, 'data'=>$data)));
        } else{
            exit(json_encode(array('status'=>FALSE, 'reason'=> 'Databse Error')));
        } 
  
   }
    function get_exec_to()
    {

        $data['result']=$this->Executives_model->get_exec_to();
        if($data){
            exit(json_encode(array("status"=>TRUE,"data"=>$data)));
        }else{
            exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
        }
    }
    function delete_gift()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->Home_model->delete_gift($this->input->post());
            if($qry)
            {
                exit(json_encode(array('status'=>TRUE)));
            }else{
                exit(json_encode(array('status'=>FALSE, 'reason'=>'Please try again later..!')));
            }
        }else{
            show_error("Unable to process the request in this way");
        }
    }
    function transaction_executive(){
            if (has_priv('view_excute_pending_amount')) {

          $data=$this->set_menu();
          $data['exec_details']=$this->Home_model->exec_transaction_details();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
            
        }else{
            $param = '';
        }
        $base_url = base_url() . "transaction_executive/";

        $result_count =$this->Home_model->exec_transaction_details_count($param);
      
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Home_model->exec_transaction_details_all($param,$per_page,$page);
         // print_r($data["data"]);
       // echo "vb b";exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }

          $this->load->view('admin/edit_view_exec_transaction',$data);
       
    } }

  function new_exec_transaction(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("pay_amt", "Amount", "numeric|trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $result=$this->Home_model->new_exec_transaction_byid();
                //print_r($result);exit();
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

    function get_exec_transaction($id)
    {

          $data=$this->set_menu();
          $data['exec_details']=$this->Home_model->exec_trans_details($id);
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
            
        }else{
            $param = '';
        }
        $base_url = base_url() . "exec_trans_details/";
        $result_count =$this->Home_model->exec_trans_details_count($param,$id);
        
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(6)) ? $this->uri->segment(6) : 0;
        $data["data"] = $this->Home_model->exec_trans_details_all($param,$per_page,$page,$id);
       // echo "vb b";exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }
          $this->load->view('admin/view_exec_transaction_details',$data);
    }
  function update_promotion($id)
  {
    if($this->input->is_ajax_request()){
          $this->form_validation->set_rules("count", "Count", "trim|required|htmlspecialchars");
          $this->form_validation->set_rules("amount", "Amount", "trim|required|htmlspecialchars");
          $this->form_validation->set_rules("period", "Period", "trim|required|htmlspecialchars");
          if($this->form_validation->run()== TRUE){
          $result=$this->Home_model->edit_promotion_by_id($id);
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
function update_add_promotion()
  {
    if($this->input->is_ajax_request()){
          $this->form_validation->set_rules("count", "Count", "trim|required|htmlspecialchars");
          $this->form_validation->set_rules("amount", "Amount", "trim|required|htmlspecialchars");
          $this->form_validation->set_rules("period", "Period", "trim|required|htmlspecialchars");
          if($this->form_validation->run()== TRUE){
          $result=$this->Home_model->edit_add_promotion_by_id();
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
    function update_promotion1($id)
  {
    if($this->input->is_ajax_request()){
          $this->form_validation->set_rules("count", "Count", "trim|required|htmlspecialchars");
        
          $this->form_validation->set_rules("period", "Period", "trim|required|htmlspecialchars");
          if($this->form_validation->run()== TRUE){
          $result=$this->Home_model->edit_promotion_by_id($id);
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
function update_add_promotion1()
  {
    if($this->input->is_ajax_request()){
          $this->form_validation->set_rules("count", "Count", "trim|required|htmlspecialchars");
        
          $this->form_validation->set_rules("period", "Period", "trim|required|htmlspecialchars");
          if($this->form_validation->run()== TRUE){
          $result=$this->Home_model->edit_add_promotion_by_id();
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
    public function load_paging($base_url,$count,$per_page)
    {
        $config = array();
        $config["base_url"] = $base_url;
        $config["total_rows"] =  $count;
        $config["per_page"] = $per_page;
        //pagination customization using bootstrap styles
        $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
        $config['full_tag_close'] = '</ul></div><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
    }
    function get_reffered_cp(){
        if (has_priv('view_reffered_cp')) {
            $status = "REFERED";
            $data=$this->set_menu();
            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $result_count = $this->Home_model->get_ref_cps_by_status_count($param,$status);
            $base_url = base_url() . "all_club_members/";
            $count =  $result_count;
            $per_page = 10;
            $this->load_paging($base_url,$count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data['page'] = $page;

            $data["data"] = $this->Home_model->get_all_ref_cps_by_status($param,$status,$per_page, $page);
            if ($this->input->post('ajax', FALSE)) {

                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'status' => 1,
                    'pagination' => $this->pagination->create_links()
                )));
            }
            $this->load->view('admin/edit_view_reffered_channelpartner',$data);
        }  
    }
    function add_reffered_cp($id){
        if (has_priv('add_cp')) 
        {    
            $data=$this->set_menu();
            $this->load->library('googlemaps');
            $config['center'] = '10.804305026919454, 76.11534118652344';
            $config['zoom'] = '8';
            $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
            $this->googlemaps->initialize($config);
            $data['map'] = $this->googlemaps->create_map();
            $data['category']=$this->Home_model->get_cpcategory();
            $data['subcategory']=$this->Home_model->get_cpscategory();
            $data['countries'] = $this->Home_model->get_countries();
            $data['modules'] = $this->Home_model->get_modules();
            $data['cp'] = $this->Channelpartner_model->get_refer_cp($id);
            $this->load->view('admin/edit_add_refered_channelpartner',$data);
        }
    }
    function add_refered_partner(){

        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("channel_type[]", "Channel Partner Type ", "trim|required|htmlspecialchars"); 
            $this->form_validation->set_rules("email", "Email", "valid_email|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Phone", "numeric|trim|required|min_length[10]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("cname", "Contact Person", "trim|required|htmlspecialchars");
           
            $this->form_validation->set_rules("c_mobile", "Contact Person's Mobile Number", "numeric|trim|min_length[7]|max_length[13]|htmlspecialchars");
            
            $this->form_validation->set_rules("c_email", "Contact Email", "valid_email|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("address", "Address", "trim|required|htmlspecialchars");
           
            $this->form_validation->set_rules("town", "Town", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("latt", "Latitude", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("long", "Longitude", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("isagree", "Agree with the terms and conditions", "trim|required|htmlspecialchars");

            if($this->form_validation->run()== TRUE){
                $this->load->helper('string');
                $otp = random_string('numeric', 4);
                $qr_no = random_string('numeric', 4);
                $data = array();
             
                if(!isset($_FILES['pro']['name']))
                {
                    exit(json_encode(array('status'=>FALSE, 'reason'=>"Please select a profile image")));
                }
                if(!isset($_FILES['bri']['name']))
                {
                    exit(json_encode(array('status'=>FALSE, 'reason'=>"Please select a brand image")));
                }
                $result=$this->Home_model->add_refered_partner($otp,$qr_no);
                if($result){
                      $data['otp'] = $otp;
                      $mail = $this->input->post('email');
                 
                      $data['id'] = $result;
                    
                     $email = "maneeshakk16@gmail.com";
                     $mail_head = 'Message From Jaazzo';
                     $status = send_custom_email($email, $mail_head, $mail, 'Sign Up - Channel Partner', $this->load->view('admin/edit_email_channelpartner_otp', $data,TRUE));
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


    function add_notification()
    {
        if (has_priv('add_notification')) {
            $data=$this->set_menu();
            $data['type'] = $this->Home_model->get_sales_type();
            $this->load->view('admin/edit_add_notification',$data);
        }

    }


    function get_sales_member_by_id($id)
    {


        $data = $this->Home_model->get_sales_member_by_id($id);
        if($data){
            exit(json_encode(array('status'=>true,'data'=>$data)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'invalid selection')));
        }
    }

    function add_new_notification()
    {
                if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("type", "Type", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("members", "Members", "trim|required|htmlspecialchars");
                        $this->form_validation->set_rules("title", "Title", "trim|required|htmlspecialchars");

            $this->form_validation->set_rules("description", "Description", "trim|required|htmlspecialchars");


            if($this->form_validation->run()== TRUE){
                $result=$this->Home_model->add_new_notification();
                //print_r($result);exit();
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

    function get_notification()
    {
        if (has_priv('view_notification')) {

        $data = $this->set_menu();
        
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "All_notifications/";
        $result_count = $this->Home_model->get_all_notification_count($param);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Home_model->get_all_notification($param,$per_page,$page);
       // echo "vb b";exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/edit_list_notification',$data);

    }
    }


    function delete_notification()
    {
         $result=$this->Home_model->delete_notification($this->input->post());
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    function cm_transaction(){
        if (has_priv('view_tl_club_pending_amount')) {
            $data=$this->set_menu();
            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $result_count = $this->Home_model->get_cm_transaction_count($param);
            $base_url = base_url() . "cm_transaction/";
            $count =  $result_count;
            $per_page = 10;
            $this->load_paging($base_url,$count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data['page'] = $page;

            $data["data"] = $this->Home_model->get_all_cm_transaction($param,$per_page, $page);
            if ($this->input->post('ajax', FALSE)) {
                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'status' => 1,
                    'pagination' => $this->pagination->create_links()
                )));
            }
            $this->load->view('admin/edit_view_tl_club_transaction',$data);
        } 
    }
    function add_cm_transaction()
    {
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("pay_amt", "Amount", "numeric|trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $result=$this->Home_model->add_cm_transaction();
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }else{
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
    function view_cm_transaction($id)
    {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $data['id'] = $id;
        $result_count = $this->Home_model->get_cm_transaction_byid_count($param,$id);
        $base_url = base_url() . "admin/Home/view_cm_transaction/";
        $count =  $result_count;
        $per_page = 10;
        $this->load_paging($base_url,$count,$per_page);
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $data['page'] = $page;

        $data["data"] = $this->Home_model->get_all_cm_transaction_byid($param,$id,$per_page, $page);
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'id'=>$id,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/view_cm_transaction_details',$data);
    }
    function preferences(){
       $data=$this->set_menu();
       $data['preferences'] = get_preference_data();
       $this->load->view('admin/view_preference_details',$data);  
    }
    function update_preference(){
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("value","Value","trim|required");
            if($this->form_validation->run()== TRUE)
            {
                $id = $this->input->post('id');
                $qry = $this->Home_model->update_preference($id);
                if($qry)
                {
                    exit(json_encode(array('status'=>TRUE)));
                }else{
                    exit(json_encode(array('status'=>FALSE, 'reason'=>'Database Error..!')));
                }
            }else{
                exit(json_encode(array('status'=>FALSE,'reason'=>validation_errors())));
            }
        }else{
            show_error("Unable To Process The Request In This Way");
        }
    }
    function ca_transaction(){
        if (has_priv('view_ca_pending_amount')) {
            $data=$this->set_menu();
            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $result_count = $this->Home_model->get_ca_transaction_count($param);
            $base_url = base_url() . "ca_transaction/";
            $count =  $result_count;
            $per_page = 10;
            $this->load_paging($base_url,$count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data['page'] = $page;

            $data["data"] = $this->Home_model->get_all_ca_transaction($param,$per_page, $page);
            if ($this->input->post('ajax', FALSE)) {
                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'status' => 1,
                    'pagination' => $this->pagination->create_links()
                )));
            }
            $this->load->view('admin/edit_view_ca_transaction',$data);
        } 
    }
    function add_ca_transaction()
    {
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("pay_amt", "Amount", "numeric|trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $result=$this->Home_model->add_ca_transaction();
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }else{
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
    function view_ca_transaction($id)
    {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $data['id'] = $id;
        $result_count = $this->Home_model->get_cm_transaction_byid_count($param,$id);
        $base_url = base_url() . "admin/Home/view_ca_transaction/";
        $count =  $result_count;
        $per_page = 10;
        $this->load_paging($base_url,$count,$per_page);
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;
        $data['page'] = $page;

        $data["data"] = $this->Home_model->get_all_cm_transaction_byid($param,$id,$per_page, $page);
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'id'=>$id,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/view_ca_transaction_details',$data);
    }
    function get_tl_reffered_cp(){
        if (has_priv('view_tl_reffered_cp')) {
            $status = "REFERED";
            $data=$this->set_menu();
            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $result_count = $this->Home_model->get_tl_ref_cps_by_status_count($param,$status);
            $base_url = base_url() . "get_tl_reffered_cp/";
            $count =  $result_count;
            $per_page = 10;
            $this->load_paging($base_url,$count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data['page'] = $page;

            $data["data"] = $this->Home_model->get_all_tl_ref_cps_by_status($param,$status,$per_page, $page);
            if ($this->input->post('ajax', FALSE)) {

                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'status' => 1,
                    'pagination' => $this->pagination->create_links()
                )));
            }
            $this->load->view('admin/edit_view_tl_reffered_channelpartner',$data);
        }  
    }
}
?>