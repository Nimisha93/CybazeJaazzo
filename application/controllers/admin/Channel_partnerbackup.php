<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 */

Class Channel_partner extends CI_Controller
{

    function __Construct(){

        parent:: __construct();
        $this->load->library(array('session','form_validation'));
        $this->load->model(array('admin/Channelpartner_model','admin/Profile_model','admin/Dashboard_model','user/product_model','register_model'));
        $this->load->helper(array('url','form','my_common_helper'));
        $session_array1 = $this->session->userdata('logged_in_admin');
        $session_array2 = $this->session->userdata('logged_in_cp');
        $session_array3 = $this->session->userdata('logged_in_exec');
        if(!isset($session_array1) and !isset($session_array2) and !isset($session_array3)){
            redirect('admin/Login');
        }
    }

    function set_menu(){
        $datas = getLoginDetails();
        if($datas){
            $type = $datas['type'];
            $userid=$datas['user_id'];
        } 
        
         if($type == 'Channel_partner'){ 
              $data['user']=$this->Profile_model->get_all_partnertype($userid);
              $data['header'] = $this->load->view('channel_partner/templates/header', '', true);
              $data['sidebar'] = $this->load->view('channel_partner/templates/sidebar',$data, true);
              $data['footer'] = $this->load->view('channel_partner/templates/footer', '', true);
         } 
         else{
              $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
              $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
              $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
         }  
        return $data;
    }

    function set_cp_menu(){
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];

        $data['user']=$this->Profile_model->get_all_partnertype($userid);

        $data['header'] = $this->load->view('channel_partner/templates/header', '', true);
        $data['sidebar'] = $this->load->view('channel_partner/templates/sidebar',$data, true);
        $data['footer'] = $this->load->view('channel_partner/templates/footer', '', true);
        return $data;
    }
    
    function index(){      
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['cp_wallet_value']=$this->Channelpartner_model->get_cpwallet_value($userid);
        $data['details']=$this->Dashboard_model->get_graph_datas($lgid);
        $data['dashboard']=$this->Channelpartner_model->get_dashboard_details($userid);
        $this->load->view('channel_partner/edit_view_channelpartner_dashboard',$data);
    }
    function set_cp_commission()
    {   
        $data=$this->set_menu();
        $datas = getLoginDetails();
        if($datas){
            $userid=$datas['user_id'];
        } 
        $data['data']=$this->Channelpartner_model->get_cp_commission($userid);
       
       if(!empty($data['data'])){
            $this->load->view('channel_partner/view_cp_commission',$data);
        }else{
             $this->load->view('channel_partner/edit_add_commission',$data);
       }
        
    }
    
    
    
    function set_new_cp_commission(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("category[]", "Category", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("commission[]", "Commission", "trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){

                $result=$this->Channelpartner_model->set_new_cp_commission();
                if($result){
                    exit(json_encode(array("status"=>true)));
                }
                else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>"Error")));

                }

            }
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
        }
    }
    function send_notification_customer(){
        $data=$this->set_menu();
        $datas = getLoginDetails();
        if($datas){
            $user_id=$datas['user_id'];
        } 
        $data['customers']=$this->Channelpartner_model->get_cpcustomer_connid($user_id);
        $this->load->view('admin/edit_send_cp_notification',$data);
    }
    function partner()
    {       
        $data=$this->set_menu();
        $this->load->library('googlemaps');
        $config['center'] = '10.804305026919454, 76.11534118652344';
        $config['zoom'] = '8';
        $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $data['category']=$this->Channelpartner_model->get_cpcategory();
        $data['subcategory']=$this->Channelpartner_model->get_cpscategory();
        $data['countries'] = $this->Channelpartner_model->get_countries();
        $data['modules'] = $this->Channelpartner_model->get_modules();
        $this->load->view('admin/edit_add_channelpartner',$data);
    }
    function new_partner(){

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
                $otp = random_string('numeric', 5);
              
                $data = array();
             
                if(!isset($_FILES['pro']['name']))
                {
                    exit(json_encode(array('status'=>FALSE, 'reason'=>"Please select a profile image")));
                }
                if(!isset($_FILES['bri']['name']))
                {
                    exit(json_encode(array('status'=>FALSE, 'reason'=>"Please select a brand image")));
                }
                $result=$this->Channelpartner_model->add_partner($otp);
                if($result){
                      $data['otp'] = $otp;
                      $mail = $this->input->post('email');
                 
                      $data['id'] = $result;
                    
                     //$email = "maneeshakk16@gmail.com";
                     //$mail_head = 'Message From Jaazzo';
                     //$status = send_custom_email($email, $mail_head, $mail, 'Sign Up - Channel Partner', $this->load->view('admin/edit_email_channelpartner_otp', $data,TRUE));
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
    function partner_type(){
        $data=$this->set_menu();
        $data['get_allcategory']=$this->Channelpartner_model->get_catNsubCategory();
        $this->load->view('admin/edit_add_channelpartner_type',$data);
    }
    function cp_sub_type(){
        $data=$this->set_menu();
        $data['category']=$this->Channelpartner_model->get_category_sub();
        $this->load->view('admin/edit_add_cp_sub_types',$data);
    }
    
    function new_partner_sub_type(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("category", "Category", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("title", "Title", "trim|required|htmlspecialchars");

            if($this->form_validation->run()== TRUE){
                $result=$this->Channelpartner_model->add_partnertype_sub();
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
    function new_partner_type(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("category", "Category", "trim|required|htmlspecialchars");
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
                exit(json_encode(array("status"=>FALSE,"reason"=>"Validation Error")));
            }
        }

    }

    
    function get_cp_commission(){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $data['data']=$this->Channelpartner_model->get_cp_commission($userid);
        $this->load->view('channel_partner/view_cp_commission',$data);
    }
    function approve_cp_new_commission()
    {  
        $data = $this->Channelpartner_model->approve_cp_new_commission();
        if($data){
            exit(json_encode(array('status'=>true)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'Database Error Occured')));
        }
    }
   
    function new_commission()
    {  
        $data = $this->Channelpartner_model->new_commission();
        if($data){
            exit(json_encode(array('status'=>true)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'Database Error Occured')));
        }
    }
    
    function get_city_by_id($id)
    {
        $data = $this->Channelpartner_model->get_city_by_state($id);
        if($data){
            exit(json_encode(array('status'=>true,'data'=>$data)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'invalid selection')));
        }
    }
        public function password_check($str)
        {
           if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
             return TRUE;
           }
           return FALSE;
        }
       function signup_cp()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('email', 'Email', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_message('password_check', '%s must contain both numbers and alphabets');
           
            if($this->form_validation->run() == TRUE)
            {
                $mail = $this->input->post('email');
                $id = $this->input->post('id');
                /*$validate_email = $this->register_model->validate_mail($mail,$id);
                
                if($validate_email['status'] === TRUE)
                {*/
                    $password = $this->input->post('password');
                    $validate_password = $this->Channelpartner_model->validate_password(encrypt_decrypt('encrypt',$this->input->post('password')));
                    if($validate_password['status'] === TRUE)
                    {
                        $cpassword =$this->input->post('cpassword');
                        if($password==$cpassword){
                            $password =encrypt_decrypt('encrypt',$this->input->post('password'));
                            $data_input = array('password'=>$password,'otp_status'=>1,'email'=>$mail);
                            $where = array('id'=>$id);
                            $res = update_tbl('gp_login_table',$data_input,$where);
                            $s_res = select_by_id('gp_login_table',$id);
                            $u_id = $s_res->user_id;
                            $cp_data_input = array('status'=>1);
                            $cp_where = array('id'=>$u_id);
                            $cp_res = update_tbl('gp_pl_channel_partner',$cp_data_input,$cp_where);
                            if($res)
                            {
                                $where = 'gp_login_table.user_id=gp_pl_channel_partner.id';
                                $result = select_all_by_id('gp_login_table',$id,'gp_pl_channel_partner',$where);
                                /*$session_array = array();
                                $session_array = array(
                                        'id' => $result->id,
                                        'type' => $result->type,
                                        'email' => $result->email,
                                        'mobile' => $result->mobile,
                                        'user_id' => $result->user_id,
                                        'club_type_id'=>$result->club_type_id,
                                        'login' =>true);
                                $this->session->set_userdata('logged_in_user', $session_array);*/
                                exit(json_encode(array('status'=>true)));
                            }else{
                                exit(json_encode(array('status'=>false)));
                            }
                        }else{
                            exit(json_encode(array('status'=>false, 'reason'=>'Password and Confirm should be same')));
                        }
                    }else{
                        exit(json_encode(array('status'=>false, 'reason'=>'Password already exist')));
                    }
                /*}else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Email already exist')));
                }*/
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
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
    
    function get_all_cptypes()
    {
        
        
        $data = $this->Channelpartner_model->get_all_cptypes();
        if($data){
            exit(json_encode(array('status'=>true,'data'=>$data)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'invalid selection')));
        }
    }
    function get_cp_type()
    {
        $id = $this->input->post('id');
       
        $data = $this->Channelpartner_model->get_cp_type($id);
     
        if($data){
            exit(json_encode(array('status'=>true,'data'=>$data)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'invalid selection')));
        }
    }
    function view_partner_type(){
         $loginsession = $this->session->userdata('logged_in_admin');
         $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['user']=$this->Profile_model->get_exicutives($userid);
         $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar',$data, true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
       
        $data['category']=$this->Channelpartner_model->get_all_categories();
        $data['subcategory']=$this->Channelpartner_model->get_cpscategory();
        $data['get_allcategory']=$this->Channelpartner_model->get_catNsubCategory();
   
        $data['cat']=$this->Channelpartner_model->get_category();
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
        $result=$this->Channelpartner_model->delete_partnertypebyid($this->input->post());
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
    function get_unapproved_cp(){
        $data=$this->set_menu();
        $status = "NOT_APPROVED";
        $data['partner']=$this->Channelpartner_model->get_cps_by_status($status);
        $data['status'] = "NOT APPROVED";
        $this->load->view('admin/edit_view_na_channerpartner',$data);
    }
    function get_approved_cp(){
        $data=$this->set_menu();
        $status = "APPROVED";
        $data['partner']=$this->Channelpartner_model->get_cps_by_status($status);
        $data['status'] = $status;
        $this->load->view('admin/edit_view_na_channerpartner',$data);
    }
    function get_active_cp(){
        $data=$this->set_menu();
        $status = "JOINED";
        $data['partner']=$this->Channelpartner_model->get_cps_by_status($status);
        $data['status'] = $status;
        $this->load->view('admin/edit_view_na_channerpartner',$data);
    }

    function get_channelpartner_byid($id){
        $data=$this->set_menu();
        $this->load->library('googlemaps');
        $config['center'] = '10.804305026919454, 76.11534118652344';
        $config['zoom'] = '8';
        $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $data['category']=$this->Channelpartner_model->get_cpcategory();
        $data['subcategory']=$this->Channelpartner_model->get_cpscategory();
        $data['countries'] = $this->Channelpartner_model->get_countries();
        $data['states'] = $this->Channelpartner_model->get_states();
        $data['modules'] = $this->Channelpartner_model->get_modules();
        $data['partner']=$this->Channelpartner_model->get_channerpartner_byid($id);
        //echo json_encode($data['partner']);exit;
        $this->load->view('admin/edit_channerpartner_edit',$data);
    }


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
                $subject = $this->input->post('subject');

                $email_message = $this->load->view('admin/edit_cpsend_mail_content', $mailmsg,TRUE);
                $this->email->initialize($config);


                foreach($email as $mail){
                    $this->email->from('greenindia@gmail.com', 'Green India');
                    $this->email->to($mail);
                    $this->email->reply_to('no-replay@gmail.com', 'OTP Verification');
                    $this->email->subject($subject);
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

        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
        }



    }


    function edit_partner(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("name", "Name ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Phone", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email", "trim|required|htmlspecialchars");
           // $this->form_validation->set_rules("fax", "Fax", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("address", "Address", "trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $id = $this->input->post('hiddenid');
                  $data['img']=$this->Channelpartner_model->get_item_byid($id);
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

                          unlink($data['img']['profile_image']);

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
                          unlink($data['img']['brand_image']);

                      }
                      $image_file2 = "assets/admin/brand/".$image_file;
                  }
                  else{
                      $image_file2=$data['img']['brand_image'];
                  }
                $result=$this->Channelpartner_model->edit_partnerbyid($image_file1,$image_file2);

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

    function delete_partnerbyid(){
        $result=$this->Channelpartner_model->delete_partnerbyid($this->input->post());
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
        
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        
        $data['user']=$this->Profile_model->get_all_partnertype($userid);
        
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        if($loginsession['type'] == 'super_admin'){
            $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar',$data, true);
        }else if($loginsession['type'] == 'Channel_partner'){
            $data['sidebar'] = $this->load->view('admin/templates/cp_sidebar',$data, true);
        }

        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['notification']=$this->Channelpartner_model->get_all_purchasenotification();
        $this->load->view('admin/edit_view_notification',$data);
    }

    function purchase_approvel_byotp(){
      
        $result=$this->Channelpartner_model->purchase_approval_by_otp();
       // $result= true;
        if($result){
            //$notyid = 41;
            $notyid = $result['id'];
            $cp_id = $result['channel_partner_id'];
            //$cp_id = 124;
           // $res = $this->Channelpartner_model->get_cp_cat($cp_id);
            $res = $this->Channelpartner_model->get_cp_commission($cp_id);
           // echo json_encode($res);exit(); 
            if($res)
            {
                exit(json_encode(array("status"=>TRUE, "data" => $res, 'notyid' => $notyid)));
            } else{
                exit(json_encode(array("status"=>FALSE,"reason"=>"You haven't set commission for categories")));
                
            }
           
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Invalid otp")));
        }
    }

    function get_state_by_id($id)
    {
        $data = $this->Channelpartner_model->get_state_by_country($id);
        if($data){
            exit(json_encode(array('status'=>true,'data'=>$data)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'invalid selection')));
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
            
              $mail = "maneeshakk16@gmail.com";
              $mail_head = 'Message From Jaazzo';
              $status = send_custom_email($mail, $mail_head, $emailll, 'OTP - Verification', $this->load->view('email_templates/edit_purchase_notification_otp', $email_details,TRUE));
            exit(json_encode(array("status"=>TRUE, 'data'=> $results)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    function get_cp_sub_types()
    {
        $data = $this->Channelpartner_model->get_cp_sub_types();
        if($data)
        {
            exit(json_encode(array('status' => TRUE, 'data'=> $data)));
        } else{
            exit(json_encode(array('status' => FALSE, 'reason'=> 'No Data Found')));
        }
    }
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
         
            $this->form_validation->set_rules("total_bill", "Total Amount", "trim|required|htmlspecialchars");
            //$this->form_validation->set_rules("amount[]", "Amount", "trim|required|htmlspecialchars");
           
             if($this->form_validation->run()== TRUE){
                $cat_percentage = $this->input->post('percentage');
                $noty_id = $this->input->post('notyid');
                $total_amount = $this->input->post('total_bill');
                $amount = $this->input->post('amount');  
                $total_percent = 0;
                
                $total_discount = 0;
                foreach ($amount as $key => $nos) {
                   if($nos != '' || $nos != 0){
                   
                    $total_discount += (($cat_percentage[$key] * $nos)/100);

                    $total_percent += $cat_percentage[$key]; 
                    }
                }
              
                $data = array(
                    'bill_total' => $total_amount,
                    'direct_commision_percentage' =>  $total_percent
                    );
              
                $update = $this->Channelpartner_model->updatewallet($noty_id, $total_discount, $data);
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