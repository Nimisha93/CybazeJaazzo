<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Executive extends CI_controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->helper(array('string','date','form'));
        $this->load->model(array('api/Executive_model','api/Home_model'));

        header("Access-Control-Request-Headers:*");
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: content-type, origin, accept, Authorization-key");
        header('Cache-control: no-cache');
        header("Connection: Keep-alive");

    }
        function add_executive(){

            //$data= $this->Mdl_home->get_user_profile($api_key);
            $this->form_validation->set_rules('name', 'Name', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|min_length[7]|max_length[12]|trim|numeric');
            $this->form_validation->set_rules('executive_type', 'Executive_type', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('country', 'Country', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('state', 'State', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('city', 'City', 'required|trim|htmlspecialchars');
            $email_to = $this->input->post('email');
            if ($this->form_validation->run() === TRUE) {
                $name = $this->input->post('name');
                $email = $this->input->post('email');
                $mobile = $this->input->post('mobile');
                $validate_email= $this->Home_model->validate_email($email);
                $validate_phone= $this->Home_model->validate_phone($mobile);
                if($validate_phone['status'] === TRUE){
                   if($validate_email['status'] === TRUE){
                        $api_key=get_api_key();
                        if($api_key){
                        $result=$this->Executive_model->add_executive($api_key);
                            if($result)
                            {
                                $data['id']=$result;
                                $email = "kavyababu19@gmail.com";
                                $mail_head = 'Message From Jaazzo';
                                $status = send_custom_email( $email, $mail_head,$email_to, 'Sign Up - Executive', $this->load->view('templates/public/mail/exec_sign_up',$data,TRUE ));
                                if($status)
                                {
                                     echo json_encode(array('error'=>false,'message' => "Added Executive",'data' => '' ));
                                    }else{
                                     echo json_encode(array("error"=>true,'message' => "error", ));
                                }
                            }else{
                                echo json_encode(array('error' => true, 'message' => 'Please try again later'));
                            }
                        }    
                        else{
                        echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
                        }
                    }
                    else{
                      exit(json_encode(array('error' => true, 'message'=>$validate_email['reason'])));
                    }
                }        
                else{
                exit(json_encode(array('error' => true, "message"=>$validate_phone['reason'])));
                }    
            }
        else{
           echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
        }

        }
        function add_jaazzo_store_or_ba(){

            //$data= $this->Mdl_home->get_user_profile($api_key);
            $this->form_validation->set_rules('name', 'Name', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('email', 'Email', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|min_length[7]|max_length[12]|trim|numeric');
            $this->form_validation->set_rules('company_name', 'Company Name', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('email_office', 'Email Office', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('phone_office', 'Office Phone', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('country', 'Country', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('state', 'State', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('city', 'City', 'required|trim|htmlspecialchars');
            $email_to = $this->input->post('email');
            if ($this->form_validation->run() === TRUE) {
                $api_key=get_api_key();

                if($api_key){
                    $mail= $this->input->post('email');
                    $mob = $this->input->post('phone');
                    $res = $this->Executive_model->ba_validation($mail,$mob);
                    if($res['status']){
                        $result=$this->Executive_model->add_jaazzo_store($api_key);
                        if($result)
                        {
                                    $data['id'] = $result['info']['user_id'];
                                    $data['otp'] = $result['info']['otp'];
                                    $email = "kavyababu19@gmail.com";
                                    $mail_head = 'Message From Jaazzo';
                                   
                                    $status = send_custom_email($email, $mail_head, $email_to, 'Sign Up - BA', $this->load->view('templates/public/mail/ba_sign_up', $data,TRUE));
                            /*if($status)
                            {*/
                                 echo json_encode(array('error'=>false,'message' => "Added jaazzo store",'data' => '' ));
                            /*}else{
                                 echo json_encode(array("error"=>true,'message' => "error", ));
                            }*/
                        }else{
                            echo json_encode(array('error' => true, 'message' => 'Please try again later'));
                        }
                    }else{
                        exit(json_encode(array("status"=>FALSE,"reason"=>"Jaazzo Store Already exist")));
                    }
                }    
                else{
                echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
                }
            }
            else{
                echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
            }

        }
        public function pan_check($str)
        {
            $where = array('is_del'=>0, 'pan'=>$str);
            $sql = $this->db->select('id')->where($where)->get('gp_pl_channel_partner')->row('id');

                if ($sql)
                {
                        $this->form_validation->set_message('pan_check', 'The {field} should be unique');
                        return FALSE;
                }
                else
                {

                    $pattern = '/^([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}?$/';
                    $result = preg_match($pattern, $str);
                    if ($result) {
                        $findme = ucfirst(substr($str, 3, 1));
                        $mystring = 'CPHFATBLJG';
                        $pos = strpos($mystring, $findme);
                        if ($pos === false) {
                           
                            $this->form_validation->set_message('pan_check', '{field} is not valid');
                            return FALSE;
                        } else {
                           return TRUE;
                        }
                    } else {
                       
                        $this->form_validation->set_message('pan_check', '{field} is not valid');
                        return FALSE;
                    }
                        
                }
        }
    public function gst_check($str)
        {
            $where = array('is_del'=>0, 'gst'=>$str);
            $sql = $this->db->select('id')->where($where)->get('gp_pl_channel_partner')->row('id');

                if ($sql)
                {
                        $this->form_validation->set_message('gst_check', 'The {field} should be unique');
                        return FALSE;
                }
                else
                {
                    if(!preg_match("/^(0[1-9]|[1-2][0-9]|3[0-5])([a-zA-Z]){5}([0-9]){4}([a-zA-Z]){1}([a-zA-Z0-9]){1}([a-zA-Z]){1}([0-9]){1}?$/", $str)) {
                            $this->form_validation->set_message('gst_check', '{field} is not valid');
                            return FALSE;
                        }else{
                            return TRUE;
                        } 
                        
                }
        } 
        function add_channel_partner(){

            //$data= $this->Mdl_home->get_user_profile($api_key);

            $this->form_validation->set_rules('club_type', 'Club Type', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('module_id', 'Module id', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('channel_partner_type', 'Channel partner type', 'required');
             $this->form_validation->set_rules('channel_name', 'Channel Name', 'required|trim|htmlspecialchars');
             $this->form_validation->set_rules('channel_email', 'Channel Email', 'required|trim|htmlspecialchars');
             $this->form_validation->set_rules('contact_number', 'Contact Number', 'required|min_length[7]|max_length[12]|trim|numeric');
            
             $this->form_validation->set_rules('country_id', 'Country', 'required|trim|htmlspecialchars');
             $this->form_validation->set_rules('state_id', 'State', 'required|trim|htmlspecialchars');
             $this->form_validation->set_rules('lattitude', 'lattitude', 'required|trim|htmlspecialchars');
             $this->form_validation->set_rules('longitude', 'longitude', 'required|trim|htmlspecialchars');
             $this->form_validation->set_rules('city_id', 'City', 'required|trim|htmlspecialchars');
             $this->form_validation->set_rules('area', 'Area', 'required|trim|htmlspecialchars');
           
             $this->form_validation->set_rules('owner_name', 'Owner Name', 'required|trim|htmlspecialchars');
             $this->form_validation->set_rules('owner_number', 'Owner Number', 'required|trim|htmlspecialchars');
             $this->form_validation->set_rules('owner_email', 'Owner Email', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules("pan_number", "PAN Number", "trim|required|htmlspecialchars|exact_length[10]|callback_pan_check");
            if($this->input->post('gst_number')){
                $this->form_validation->set_rules("gst_number", "GST Number", "trim|htmlspecialchars|exact_length[15]|callback_gst_check");
            }
            if ($this->form_validation->run() === TRUE) {
                $mobile = $this->input->post('contact_number');
                $email = $this->input->post('channel_email');
                $mobExist = $this->Executive_model->mobile_exist($mobile);
                $mailExist = $this->Executive_model->mail_exist($email);
                if(!$mobExist){
                    exit(json_encode(array("error"=>true,"message"=>"Mobile no already exist")));
                }
                if(!$mailExist){
                    exit(json_encode(array("error"=>true,"message"=>"Email already exist")));
                }

                $this->load->helper('string');
                $otp = random_string('numeric', 5);
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
                if(isset($_FILES['company_reg_doc']['name'])){ 
                    if (!$this->upload->do_upload('company_reg_doc')) {
                    exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
                    } else {
                    $fileData1 = $this->upload->data();
                    $creg ='uploads/cp_docs/'.$fileData1['file_name'];
                    }
                }
                if(isset($_FILES['licence_doc']['name'])){
                    if (!$this->upload->do_upload('licence_doc')) {
                    exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
                    } else {
                    $fileData2 = $this->upload->data();
                    $license = 'uploads/cp_docs/'.$fileData2['file_name'];
                    }
                }
                $api_key=get_api_key();
                if($api_key){
                $usr_data=user_details_by_apikey($api_key);
                $id = $usr_data['id'];
                $typ = $usr_data['type'];
                if(!empty($id)){
                    $result=$this->Executive_model->add_channel_partner($otp,$api_key,$qr_no,$creg,$license);
                    if($result){
                        echo json_encode(array("error"=>false,'message'=>"Channel partner added successfully",'data'=>''));
                    }
                    else{
                        echo json_encode(array("error"=>true,"message"=>"Database Error"));
                    }
                 }else{
                     echo json_encode(array("error"=>true, 'message' => "Invalid User"));
                 }   
                } 
                else{
                    echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
                }   
            }
            else{
                echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
            }

        }


    function deactivate_account(){

            $this->form_validation->set_rules('reason', 'Reason', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('opt_out_promotions', 'Email Option', 'required|trim|htmlspecialchars');
            if ($this->form_validation->run() === TRUE) {
                $api_key=get_api_key();
                
                if($api_key){
                    $user=$this->Executive_model->validate_pswd($api_key);

                    if($user){
                        $result=$this->Executive_model->deactivate_account($api_key);
                        if($result)
                        {
                            echo json_encode(array("error"=>false, 'message' => 'You have deactivated your account'));

                        }else{
                            echo json_encode(array("error"=>true, 'message' => 'Please try again later'));
                        }
                    }
                    else{
                        echo json_encode(array("error"=>true, 'message' => "Password incorrect"));
                    }    
                }    
                else{
                echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
                }
            }
            else{
                echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
                } 
    }
   function get_wallet_transactions(){
            $this->form_validation->set_rules('main_wallet_type', 'Wallet Type', 'required|numeric|trim|htmlspecialchars');
            $this->form_validation->set_rules('transaction_type', 'Transaction Type', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('page', 'Page', 'required|numeric|trim|htmlspecialchars');
            if ($this->form_validation->run() === TRUE) {
                $api_key=get_api_key();
                if($api_key){
                 $usr_data=user_details_by_apikey($api_key);
                 if(!empty($usr_data)){   
                    $data=$this->Executive_model->get_wallet_transactions($usr_data);
                    if($data)
                    {
                        echo json_encode(array("error"=>false, 'message' => 'Wallet','data' => $data ));

                    }else{
                        echo json_encode(array("error"=>true, 'message' => 'Please try again later'));
                    }
                  }else{
                    echo json_encode(array("error"=>true, 'message' => "Api key is incorrect"));
                  }  
                }
                else{
                echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
                }
            }
            else{
            echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
            }    
   }
    function get_executive_data(){
        $api_key=get_api_key();
            if($api_key){
            $data=$this->Executive_model->get_executive_data($api_key);
                if(!empty($data))
                {
                    echo json_encode(array('data' => $data,"error"=>false, 'message' => "Success" ));
                }else{
                    echo json_encode(array("error"=>true, 'message' => 'Please try again later'));
                }
            }  
            else{
                    echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
            } 
    }
    public function pan_checks($str)
    {
        
        $id = $this->input->post('channel_id'); 
        $sql = $this->db->query("select c.id from gp_pl_channel_partner c where c.id != '$id' and c.is_del = 0 and c.pan = '$str'");
       
            if ($sql->num_rows()>0)
            {
                /*$this->form_validation->set_message('pan_checks', 'The {field} should be unique');*/
                $this->form_validation->set_message('pan_checks', 'The {field} already exists');
                return FALSE;
            } else{
                return TRUE;
            }
    }
    public function gst_checks($str)
    {
       
        $id = $this->input->post('channel_id'); 
        $sql = $this->db->query("select c.id from gp_pl_channel_partner c where c.id != '$id' and c.is_del = 0 and c.gst = '$str'");
            if ($sql->num_rows()>0)
            {
                $this->form_validation->set_message('gst_checks', 'The {field} should be unique');
                return FALSE;
            }else{
                return TRUE;
            }
    }
    function add_refered_channel_partner(){
        $api_key=get_api_key();
        if($api_key){
            $usr_data=user_details_by_apikey($api_key);
            $id = $usr_data['id'];
            if(!empty($id)){
                
                $this->form_validation->set_rules("channel_id", "Channel Id", "trim|required|numeric|htmlspecialchars");
                $this->form_validation->set_rules("channel_name", "Name", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("channel_partner_type[]", "Channel Partner Type ", "trim|required");
                $this->form_validation->set_rules("contact_number", "Phone", "numeric|trim|required|htmlspecialchars");
                $this->form_validation->set_rules("channel_email", "Email", "valid_email|trim|required|htmlspecialchars");     
                $this->form_validation->set_rules("country_id", "Country", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("state_id", "State", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("city_id", "City", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("lattitude", "Lattitude", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("longitude", "Longitude", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("owner_name", "Owner Name", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("owner_email", "Owner Email", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("owner_number", "Owner Contact", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("area", "Area", "trim|required|htmlspecialchars");
                $form_type = $this->input->post('form_type');
                if($form_type=='ADD_REFERED_CP'){
                    $this->form_validation->set_rules("pan_number", "PAN Number", "trim|required|htmlspecialchars|exact_length[10]|callback_pan_check");
                    if($this->input->post('gst_number')){
                        $this->form_validation->set_rules("gst_number", "GST Number", "trim|htmlspecialchars|exact_length[15]|callback_gst_check");
                    }
                }else{
                    $this->form_validation->set_rules("pan_number", "PAN Number", "trim|required|htmlspecialchars|exact_length[10]|callback_pan_checks");
                    if($this->input->post('gst')){
                        $this->form_validation->set_rules("gst_number", "GST Number", "trim|htmlspecialchars|exact_length[15]|callback_gst_checks");
                    }
                }
                if($this->form_validation->run()== TRUE){
                    $mobile = $this->input->post('contact_number');
                    $email = $this->input->post('channel_email');
                    $channel_id = $this->input->post('channel_id');

                    if($form_type=='ADD_REFERED_CP'){
                        $mobExist = $this->Executive_model->mobile_exist($mobile);
                        $mailExist = $this->Executive_model->mail_exist($email);
                        if(!$mobExist){
                            exit(json_encode(array("error"=>true,"message"=>"Mobile no already exist")));
                        }
                        if(!$mailExist){
                            exit(json_encode(array("error"=>true,"message"=>"Email already exist")));
                        }
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
                        if(isset($_FILES['company_reg_doc']['name'])){ 
                            if (!$this->upload->do_upload('company_reg_doc')) {
                            exit(json_encode(array('error'=>FALSE, 'message'=>$this->upload->display_errors())));
                            } else {
                            $fileData1 = $this->upload->data();
                            $creg ='uploads/cp_docs/'.$fileData1['file_name'];
                            }
                        }
                        if(isset($_FILES['licence_doc']['name'])){
                            if (!$this->upload->do_upload('licence_doc')) {
                            exit(json_encode(array('error'=>FALSE, 'message'=>$this->upload->display_errors())));
                            } else {
                            $fileData2 = $this->upload->data();
                            $license = 'uploads/cp_docs/'.$fileData2['file_name'];
                            }
                        }
                        $result=$this->Executive_model->add_refer_partner($api_key,$otp,$qr_no,$creg,$license);
                    }else if ($form_type=='EDIT') {
                        $mobExist = $this->Executive_model->chk_mobile_exist($mobile,$channel_id);
                        $mailExist = $this->Executive_model->chk_mail_exist($email,$channel_id);
                        if(!$mobExist){
                            exit(json_encode(array("error"=>true,"message"=>"Mobile no already exist")));
                        }
                        if(!$mailExist){
                            exit(json_encode(array("error"=>true,"message"=>"Email already exist")));
                        }
                        $data['img']=$this->Executive_model->get_item_byid($channel_id);
                        $creg1 =$data['img']['company_registration'];
                        $license1 = $data['img']['license'];
                
                        $config['upload_path'] =  './uploads/cp_docs';
                        $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
                        $config['max_size'] = '2000000';
                        $config['remove_spaces'] = true;
                        $config['overwrite'] = false;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if(isset($_FILES['company_reg_doc']['name'])){ 
                            if (!$this->upload->do_upload('company_reg_doc')) {
                                exit(json_encode(array('error'=>FALSE, 'message'=>$this->upload->display_errors())));
                            } else {
                                $fileData1 = $this->upload->data();
                                $creg ='uploads/cp_docs/'.$fileData1['file_name'];
                                !empty($creg1)?unlink($creg1):'';
                            }
                        }
                        if(isset($_FILES['licence_doc']['name'])){
                            if (!$this->upload->do_upload('licence_doc')) {
                                exit(json_encode(array('error'=>FALSE, 'message'=>$this->upload->display_errors())));
                            } else {
                                $fileData2 = $this->upload->data();
                                $license = 'uploads/cp_docs/'.$fileData2['file_name'];
                                !empty($license1)?unlink($license1):'';
                            }
                        }
                        $result=$this->Executive_model->edit_channel_partner($api_key,$creg,$license);
                    }
                    if($result){
                        exit(json_encode(array("error"=>FALSE,"message"=>'Channel partner edited successfully')));
                    }
                    else{
                        exit(json_encode(array("error"=>TRUE,"message"=>"Database Error")));
                    }
                }else{
                    echo json_encode(array('error'=>true,'message'=>strip_tags(validation_errors())));  
                }
            }else{
                 echo json_encode(array("error"=>true, 'message' => "Invalid User"));
            }   
        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        } 
    }
    function get_all_channel_partners(){
        $api_key=get_api_key();
            if($api_key){
                $data=$this->Executive_model->get_all_channel_partners($api_key);
                if(!empty($data))
                {
                    echo json_encode(array('data' => $data,"error"=>false, 'message' => "Your channel partners" ));
                }else{
                    echo json_encode(array("error"=>true, 'message' => 'Please try again later'));
                }
            }  
            else{
                    echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
            } 
    }    
    function edit_refer_cp(){
        $api_key=get_api_key();
        if($api_key){
            $usr_data=user_details_by_apikey($api_key);
            $id = $usr_data['id'];
            if(!empty($id)){
                
                $this->form_validation->set_rules("channel_id", "Channel Id", "trim|required|numeric|htmlspecialchars");
                $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
                $this->form_validation->set_rules("phone", "Phone", "numeric|trim|required|htmlspecialchars");
                $this->form_validation->set_rules('owner_name', 'Owner Name', 'required|trim|htmlspecialchars');
                $this->form_validation->set_rules('owner_email', 'Owner Email', 'required|trim|valid_email|htmlspecialchars');
                $this->form_validation->set_rules('owner_mobile', 'Owner Mobile', 'required|trim|numeric');
                $this->form_validation->set_rules("area", "Area", "trim|required|htmlspecialchars");
                
                if($this->form_validation->run()== TRUE){
                    $mobile = $this->input->post('phone');
                    $email = $this->input->post('email');
                    $channel_id = $this->input->post('channel_id');

                        $mobExist = $this->Executive_model->chk_mobile_exist($mobile,$channel_id);
                        $mailExist = $this->Executive_model->chk_mail_exist($email,$channel_id);
                        if(!$mobExist){
                            exit(json_encode(array("error"=>true,"message"=>"Phone no already exist")));
                        }
                        if(!$mailExist){
                            exit(json_encode(array("error"=>true,"message"=>"Email already exist")));
                        }

                        $valid= $this->Executive_model->chk_valida_cp($id,$channel_id);
                        if($valid){
                            $result=$this->Executive_model->edit_refer_channel_partner($api_key);   
                        }else{
                            exit(json_encode(array("error"=>TRUE,"message"=>"Invalid channel id")));
                        }
                    
                    if($result){
                        exit(json_encode(array("error"=>FALSE,"message"=>'Your reference has been updated.',"data"=>new stdClass())));
                    }
                    else{
                        exit(json_encode(array("error"=>TRUE,"message"=>"Database Error")));
                    }
                }else{
                    echo json_encode(array('error'=>true,'message'=>strip_tags(validation_errors())));  
                }
            }else{
                 echo json_encode(array("error"=>true, 'message' => "Invalid User"));
            }   
        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }
    function get_club_member_by_executive(){
        $api_key=get_api_key();
        if($api_key){
            $data=$this->Executive_model->get_club_member_by_executive($api_key);
            if(!empty($data))
            {
                echo json_encode(array('data' => $data,"error"=>false, 'message' => "Your Club Members" ));
            }else{
                echo json_encode(array("error"=>true, 'message' => 'Please try again later'));
            }
        }  
        else{
                echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        } 
    }
    function get_members(){
        $api_key=get_api_key();
        if($api_key){
            $this->form_validation->set_rules("type", "Type", "trim|required|htmlspecialchars");
                
            if($this->form_validation->run()== TRUE){
                $data=$this->Executive_model->get_members_by_type($api_key);
                if(!empty($data))
                {
                    echo json_encode(array('data' => $data,"error"=>false, 'message' => "This is a sample success message" ));
                }else{
                    echo json_encode(array("error"=>true, 'message' => 'Please try again later'));
                }
            }else{
                echo json_encode(array('error'=>true,'message'=>strip_tags(validation_errors())));  
            }
        }  
        else{
                echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        } 
    }
}    