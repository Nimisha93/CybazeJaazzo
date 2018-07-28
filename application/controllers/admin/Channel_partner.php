<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 */

Class Channel_partner extends CI_Controller
{

    function __Construct(){

        parent:: __construct();
        $this->load->library(array('session','form_validation','pagination'));
        $this->load->model(array('admin/Channelpartner_model','admin/Profile_model','admin/Dashboard_model','admin/Product_model','admin/Home_model','admin/Transaction_model'));
        $this->load->helper(array('url','form','my_common_helper'));
        $session_array = $this->session->userdata('logged_in_cp');
        if(!isset($session_array)){
            redirect('admin/Login');
        }
    }
    function set_menu(){
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['notification'] = get_new_purchase_count();
        $data['user']=$this->Profile_model->get_all_partnertype($userid);
        $data['commission_settings']=$this->Channelpartner_model->get_cp_commission_status($userid);
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
        $data['dashboard']=$this->Channelpartner_model->get_dashboard_details($userid);
        $data['cp_details']=$this->Transaction_model->get_cptransaction_details($lgid);
        $this->load->view('channel_partner/edit_view_channelpartner_dashboard',$data);
    }
    function inbox(){      
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_cp');
        $lgid=$loginsession['id'];
        $where = "n.type = 'admin' and n.is_del = 0 and n.login_id = '$lgid'";
        $data['notification'] = random_select($where,'*','admin_notifications n','result');
        $this->load->view('channel_partner/edit_add_inbox',$data);
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

    function set_cp_commission()
    {   
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        $data['data']=$this->Channelpartner_model->get_cp_commission($userid);
       if(!empty($data['data'])){



if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "set_commission/";
        $result_count = $this->Channelpartner_model->get_cp_commission_count($param,$userid);

        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Channelpartner_model->get_cp_commission_all($param,$per_page,$page,$userid);
       // echo "vb b";exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('channel_partner/view_cp_commission',$data);

            //$this->load->view('channel_partner/view_cp_commission',$data);
         }else{
             $res = random_select("p.slug = 'category_level'","p.value","gp_preference p","row");
             $data['cat_level'] = $res->value;
             $this->load->view('channel_partner/edit_add_commission',$data);
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
    function set_new_cp_commission(){
        if($this->input->is_ajax_request()){
        
            //$this->form_validation->set_rules("category[]", "Category", "trim|required|htmlspecialchars");
            //$this->form_validation->set_rules("commission[]", "Commission", "trim|required|htmlspecialchars");
           // if($this->form_validation->run()== TRUE){
             //var_dump("expression2");exit();
                $result=$this->Channelpartner_model->set_new_cp_commission();
                if($result){
                    exit(json_encode(array("status"=>true)));
                }
                else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>"Error")));

                }

            //}
        //else{
            exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
        //}
        }else{
            show_error("We are unable to process this request on this way!");
        }
    }
    function new_product(){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id']; 
        $data['product_cate']=$this->Product_model->get_category();
        $data['brands']=$this->Product_model->get_brands();
        $data['cp'] = $this->Channelpartner_model->get_cp_type($userid);
        $data['category'] = $this->Channelpartner_model->get_reward_categories($userid);
        $this->load->view('channel_partner/edit_add_product',$data);        
     }
    function get_product(){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        //$data['products']=$this->Product_model->get_all_product_by_id($userid);

if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "cp_product_list/";
        $result_count = $this->Product_model->get_all_product_by_id_count($param,$userid);

        $per_page = 10;




 $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Product_model->get_all_product_by_id_page($param,$per_page,$page,$userid);
       // echo "vb b";exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }
       




        //echo json_encode($data['products']);exit();
        $this->load->view('channel_partner/edit_view_product',$data);    
    }
    function get_product_byid($id){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        $data['product_cate']=$this->Channelpartner_model->get_cp_type($userid);
        $data['brands']=$this->Product_model->get_brands();
        $data['category'] = $this->Channelpartner_model->get_reward_categories($userid);
        $data['products']=$this->Channelpartner_model->get_product_byid($id);

        $this->load->view('channel_partner/edit_product_edit',$data);
    }
    
    
    
    
    
    
    
    
    
    
    function mail_exists()
    {
        $mail=$this->input->post('mail');
        $this->load->model('admin/Home_model');
        $result = $this->Home_model->mail_exisits($mail);
        if($result == false)
        {
            exit(json_encode(array('status'=> true)));
        } else{
            exit(json_encode(array('status'=> false)));
        }
    }
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    function edit_product_byid($id){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("pro_category", "Channel Partner Type ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_name", "Product", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_description", "description ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("reward_category", "Reward Category", "trim|required|htmlspecialchars|callback_check_default");
            $this->form_validation->set_rules("brands", "Brand Name", "trim|required|htmlspecialchars|callback_check_default");
            $this->form_validation->set_rules("pro_model", "Product Model", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_actualcost", "Actual Cost", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("special_prize", "Specila Prize", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_message('check_default', 'You need to select something other than the default values'); 
            if($this->form_validation->run()== TRUE){

                $data['products']=$this->Product_model->get_product_byid($id);
                $this->load->library('upload');
                if(isset($_FILES['pro_image']['name']))
                {
                     $files = $_FILES;
                     $cpt = count($_FILES['pro_image']['name']);
                     for($i=0; $i<$cpt; $i++)
                        {
                            
                            $_FILES['pro_image']['name']= time().$files['pro_image']['name'][$i];
                            $_FILES['pro_image']['type']= $files['pro_image']['type'][$i];
                            $_FILES['pro_image']['tmp_name']= $files['pro_image']['tmp_name'][$i];
                            $_FILES['pro_image']['error']= $files['pro_image']['error'][$i];
                            $_FILES['pro_image']['size']= $files['pro_image']['size'][$i];
                            $config['upload_path'] =  './assets/admin/products';
                            $config['allowed_types'] = 'gif|jpg|png|jpeg';
                            $config['max_size'] = '2000000';
                            $config['remove_spaces'] = true;
                            $config['overwrite'] = false;
                            $config['max_width'] = '';
                            $config['max_height'] = '';
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            //$this->upload->display_errors()
                            $upload_img = $this->upload->do_upload('pro_image');
                            if(!$upload_img){
                                    exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
                                }
                            else
                            {
                                $uploading_file = $this->upload->data();
                                $image_file = $uploading_file['file_name'];
                                $images[] = $image_file;
                            }
                        }    
                }
                else{
                    $images[] = array('0' =>"Empty");
                }
                //var_dump($images);exit();
                    $result = $this->Channelpartner_model->edit_product_byid($images,$id);

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
    function check_default($element)
    {
        if($element == '0')
        { 
          return FALSE;
        }
        return TRUE;
    }



    function new_product_add(){
        if($this->input->is_ajax_request()){

           
            $this->form_validation->set_rules("pro_category", "Channel Partner Type ", "trim|required|htmlspecialchars|callback_check_default");
              $this->form_validation->set_rules("sub_type", "Channel Partner Sub Type ", "trim|required|htmlspecialchars|callback_check_default");
            $this->form_validation->set_rules("pro_name", "Product", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_description", "description ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("brands", "Brand Name", "trim|required|htmlspecialchars|callback_check_default");
            $this->form_validation->set_rules("reward_category", "Reward Category", "trim|required|htmlspecialchars|callback_check_default");
            $this->form_validation->set_rules("pro_model", "Product Model", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_actualcost", "Actual Cost", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("special_prize", "Special Price",'less_than['.$this->input->post('pro_actualcost').']' ,"numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_message('check_default', 'You need to select something other than the default values');
            
            

     if (empty($_FILES['userfile']['name']))
            {
              $this->form_validation->set_rules('userfile', 'Image', 'required');
            }
             if($this->form_validation->run()== TRUE){
                $files = $_FILES;
              $count = count($_FILES['userfile']['name']);
             
                    for($i=0; $i<$count; $i++)
                    {
                        $_FILES['userfile']['name']= time().$files['userfile']['name'][$i];
                        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                        $_FILES['userfile']['size']= $files['userfile']['size'][$i];
                        $config['upload_path'] =  './assets/admin/products';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $config['max_size'] = '2000000';
                        $config['remove_spaces'] = true;
                        $config['overwrite'] = false;
                        $config['max_width'] = '';
                        $config['max_height'] = '';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        $this->upload->do_upload();
                        
                        $image_data = $this->upload->data();
                        $fileName = $image_data['raw_name'].$image_data['file_ext'];
                        $images[] = $fileName;
                    }
                
                  
                    $result = $this->Channelpartner_model->add_new_product($images);

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
    function delete_product_image($id)
    {
        $result=$this->Channelpartner_model->delete_product_image($id);
        if($result)
        {
            exit(json_encode(array("status"=>TRUE)));
        }
        else
        {
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    function get_cp_sub_types()
    {
         $id = $this->input->post('id');
        $data = $this->Channelpartner_model->get_cp_sub_types($id);
        if($data)
        {
            exit(json_encode(array('status' => TRUE, 'data'=> $data)));
        } else{
            exit(json_encode(array('status' => FALSE, 'reason'=> 'No Data Found')));
        }
    }
    function delete_productbyid($id){
        $result=$this->Channelpartner_model->delete_productbyid($id);
        if($result){
            exit(json_encode(array("status"=>TRUE)));        
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    function wallet_report(){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        $login_id=$loginsession['id'];
        $data['wallet']=$this->Channelpartner_model->get_cpWallet($userid);
        $data['trans']=$this->Channelpartner_model->get_transaction_amount($login_id);
        $this->load->view('channel_partner/edit_view_cp_wallet',$data);
    }
    function billing(){      
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        $sel = random_select("p.is_del = 0 and p.status = 'joined' and p.id='$userid'","p.is_active","gp_pl_channel_partner p ","row");
        $data['status'] = $sel->is_active;
        $this->load->view('channel_partner/edit_add_billing',$data);
    }
    //verify_user
    function purchase_otp(){
       $this->load->helper('string');
        $otp= random_string('numeric',4);
        $email_details = array();
        $mobile=$this->input->post('mobile');
        $emailll=$this->input->post('emailll');
        $purcid=$this->input->post('hiddentype_id');
        $qry="SELECT noty.login_id,wa.wallet_type_id,p_item.wallet_value as wallet_used FROM gp_purchase_bill_noty_wallet_items p_item 
            LEFT JOIN gp_wallet_values wa ON p_item.wallet_id=wa.id
            LEFT JOIN gp_purchase_bill_notification noty ON noty.id= p_item.bill_notification_id
            WHERE wa.wallet_type_id in(1,5) AND p_item.wallet_value!='' AND p_item.bill_notification_id='$purcid'";
        $res=$this->db->query($qry);
       
        if($res->num_rows()>0){
            $purchase_details = $res->result_array();
            $data = get_details_by_mobile($mobile);
            foreach ($purchase_details as $key => $value) {
                if($data){
                    $userid = $data['user_id'];
                    $lid = $data['login_id'];
                    $udetail = get_details_by_userid($userid);
                    $dateString=$udetail['created_on'];
                    $fixed_join_date=$udetail['fixed_join_date'];
                    $type = $value['wallet_type_id'];
                    $amount = $value['wallet_used'];
                    //$data["club_type_id"];
                    if($type==1){
                        $club = ($data["club_type_id"]>0)?$data["club_type_id"]:$data["investor_type_id"];
                        $det = getClubtypeById($club);// $det = getClubtypeById($data["club_type_id"]);
                        $year_limit = $det['cash_limit'];
                        $years = round((time()-strtotime($dateString))/(3600*24*365.25));
                        if($year_limit>=$years){
                            $wallet_used_per_year = $this->get_club_wallet_used_per_year($lid);
                            $usage_limit = ($det['amount']/$year_limit)-$wallet_used_per_year;
                            if($amount<=$usage_limit)
                            {
                                $res = true;
                            }else{
                                exit(json_encode(array('status'=>false,'reason1'=>'You can only use '.$usage_limit.' per year')));
                            }
                        }else{
                            exit(json_encode(array('status'=>false,'reason1'=>'Club Membership  expired')));
                        }
                    }
                    if($type==5){
                        $det2 = getClubtypeById($data["fixed_club_type_id"]);
                        $fixed_wallet_details = get_fixed_wallet_details($lid);
                        $fixed_wallet_used = get_wallet_used_by_member($lid,5);
                        $fixed_wallet_used_per_year = $this->get_fixed_wallet_used_per_year($lid);
                        // $tot_amnt = $fixed_wallet_details+$fixed_wallet_used;
                        $tot_amnt = $fixed_wallet_details;
                        $year_limit = $det2['cash_limit'];
                        $years = (time()-strtotime($fixed_join_date))/(3600*24*365);

                        if($year_limit>=$years){
                            $fix_within_first_year = date('Y-m-d H:i:s',strtotime('+1 year',strtotime($fixed_join_date)));
                            if(date('Y-m-d H:i:s')<=$fix_within_first_year){
                            }else{
                                switch ($years) {
                                    case ($years<=2):
                                        $year_limit=4;
                                        break;
                                    case ($years<=3):
                                        $year_limit=3;
                                        break;
                                    case ($years<=4):
                                        $year_limit=2;
                                        break;
                                    default:
                                        $year_limit=1;
                                }
                            }
                                $usage_limit = (($fixed_wallet_details+$fixed_wallet_used_per_year)/$year_limit)-$fixed_wallet_used_per_year;
                                if($amount<$usage_limit)
                                {
                                    $res = true;
                                }else if($usage_limit==0)
                                {
                                    exit(json_encode(array('status'=>false,'reason2'=>'Your fixed wallet usage limit exceed in this year')));
                                }else{
                                    exit(json_encode(array('status'=>false,'reason2'=>'You can only use '.round($usage_limit).' per year')));
                                }
                        }else{
                            exit(json_encode(array('status'=>false,'reason2'=>'Fixed Club Membership  expired')));
                        }
                    }
                }
            }
        }
        if($res){
            $email_details['otp'] = $otp;
            $email_details['mobile'] = $mobile;
            $results=$this->Channelpartner_model->get_purchase_otp($otp);
            if($results){
                 $number = $mobile; // A single number or a comma-seperated list of numbers
                 
                 //$message = $otp." is the OTP for mobile number verification. Please enter it in the space provided in the website. Thank you for using Jaazzo. ";
                 //send_message($number,$message);
                 
                exit(json_encode(array("status"=>TRUE, 'data'=> $results)));
            }
        }else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    function purchase_approvel_byotp(){
      
        $result=$this->Channelpartner_model->purchase_approval_by_otp();
        if($result){
            
            $notyid = $result['id'];
            $cp_id = $result['channel_partner_id'];
            $res = $this->Channelpartner_model->get_cp_commission($cp_id);
            if($res)
            {
                 exit(json_encode(array("status"=>TRUE, "data" => $res, 'notyid' => $notyid, 'wallet' =>$result['wallet_total'])));
            } else{
                exit(json_encode(array("status"=>FALSE,"reason"=>"You haven't set commission for categories" ,"type"=>"no_commission")));
                
            }
           
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Invalid otp")));
        }
    }
    function total_percentage()
    {
        if($this->input->is_ajax_request()){
         
            $this->form_validation->set_rules("total_bill", "Total Amount", "trim|required|htmlspecialchars");
           
             if($this->form_validation->run()== TRUE){
                $cat_percentage = $this->input->post('percentage');
                $noty_id = $this->input->post('notyid');
                $total_amount = $this->input->post('total_bill');
                $amount = $this->input->post('amount');  
                $total_discount = 0;
                foreach ($amount as $key => $nos) {
                   if($nos != '' || $nos != 0){
                   
                    $total_discount += (($cat_percentage[$key] * $nos)/100);
                    }
                }
               
                $update = $this->Channelpartner_model->updatewallet($noty_id, $total_discount, $total_amount);
                if($update)
                {
                    $lg_id = $update['login'];
                    $reward = $update['reward'];
                    $lg_query = get_details_by_loginid($lg_id);
                    $number = $lg_query['mobile'];
                    $message = "Thank you for shopping through your jaazzo account. You have got a reward of Rs. ".$reward;
                    send_message($number,$message);
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
    function verify_user()
    {
      if($this->input->is_ajax_request()){
         
        $this->form_validation->set_rules("mobile", "Mobile", "trim|required|numeric|exact_length[10]");
           
         if($this->form_validation->run()== TRUE){  
               $loginsession = $this->session->userdata('logged_in_cp');
                $userid=$loginsession['user_id'];
                $mobile = $this->input->post('mobile');
                $data = $this->Channelpartner_model->verify_user($mobile,$userid);
                if($data['status']==true)
                {
                    $otp = $data['data']['otp'];

                    $purchase_id = $data['data']['purchase_id'];
                    
                     $number = $mobile; // A single number or a comma-seperated list of numbers
                     //$message = "Hi, Welcome to Jaazzo. Please verify the one time password ".$otp;
                     $message = $otp." is the OTP for mobile number verification. Please enter it in the space provided in the website. Thank you for using Jaazzo. ";
                     send_message($number,$message);
                     $info = array('purchase_id' =>$purchase_id ,'mobile'=>$mobile);
                    
                    exit(json_encode(array('status' => TRUE , 'data' => $info)));
                } else{
                    exit(json_encode(array('status' => FALSE, 'reason'=> 'Invalid User')));
                }
             }else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }else{
            show_error("We are unable to process this request on this way!");
        }    
    }
    function resend_otp()
    {
      if($this->input->is_ajax_request()){ 
            $this->load->helper('string');
            $otp = random_string('numeric', 4);
            $data = $this->Channelpartner_model->resend_otp($otp);
            if($data['status']==true)
            {
                 $otp = $data['otp'];
                 $number = $this->input->post('mobile'); // A single number or a comma-seperated list of numbers
                 //$message = "Hi, Welcome to Jaazzo. Please verify the one time password ".$otp;
                  $message = $otp." is the OTP for mobile number verification. Please enter it in the space provided in the website. Thank you for using Jaazzo. ";
                 send_message($number,$message);
                exit(json_encode(array('status' => TRUE )));
            } else{
                exit(json_encode(array('status' => FALSE, 'reason'=> 'Something went wrong! Try again later.')));
            }
        }else{
            show_error("We are unable to process this request on this way!");
        }    
    }
    function verify_otp()
    {
     if($this->input->is_ajax_request()){
         
      $this->form_validation->set_rules("otp", "OTP", "trim|required|numeric");
           
      if($this->form_validation->run()== TRUE){     
                $result = $this->Channelpartner_model->verify_otp();
                if($result)
                {
                    $login_id = $result['login_id'];
                    $purchase_id = $result['purchase_id'];
                    $data = $this->Channelpartner_model->get_wallet($login_id);
                    $details = array('wallet' =>$data, 'login_id' =>$login_id,'purchase_id' =>$purchase_id );
                    if($data)
                     {exit(json_encode(array('status' => TRUE, 'data' =>$details)));}
                    else{
                      exit(json_encode(array('status' => FALSE, 'reason'=> 'Something went wrong!')));  
                    }
                } else{
                    exit(json_encode(array('status' => FALSE, 'reason'=> 'Invalid otp!')));
                }
       }else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }else{
            show_error("We are unable to process this request on this way!");
        }         
    }
    
    function add_wallet()
    {
       if($this->input->is_ajax_request()){

                $wal_amount = $this->Channelpartner_model->get_total_wallet_amount_customer();
                $wallet_price = $this->input->post('price');
                $sum_enterd = 0;
                foreach ($wallet_price as $key => $price) {
                    $price = ($price=='')? 0 : $price;
                    $sum_enterd += $price;
                }
                $in_wallet = $wal_amount['as_total'];
                $in_wallet = intval($in_wallet);
                $sum_enterd = intval($sum_enterd);

                if($in_wallet >= $sum_enterd){
                    $check_bal_in_wallet = $this->Channelpartner_model->check_bal_in_wallet();
                    if($check_bal_in_wallet["status"] == TRUE){
                        $result=$this->Channelpartner_model->give_notification();        
                        if($result){
                            $loginsession = $this->session->userdata('logged_in_cp');
                            $userid=$loginsession['user_id'];
                            $res = $this->Channelpartner_model->get_cp_commission($userid);
                              if($res)
                                {
                                    $notyid = $this->input->post('purchase_id');
                                    exit(json_encode(array("status"=>TRUE, "data" => $res, 'notyid' => $notyid, 'wallet' =>$sum_enterd)));
                                } else{
                                    exit(json_encode(array("status"=>FALSE,"reason"=>"You haven't set commission for categories")));
                                    
                                }
                        }else{
                            exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                        }
                    } else{
                        exit(json_encode(array("status"=>FALSE,"reason"=>'Not Enough Money1')));
                    }
                        
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Not Enough Money in Your Wallet ')));
                }
                                            
        }else{
            show_error("We are unable to process this request on this way!");
        } 
    }
    function profile(){      
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['dashboard']=$this->Channelpartner_model->get_dashboard_details($userid);
        $data['profile']=$this->Channelpartner_model->get_profile_details($userid);
        $data['countries'] = $this->Home_model->get_countries();
        $data['states'] = $this->Home_model->get_states();
        $state = $data['profile']->state;
        $data['cities'] = $this->Home_model->get_town_by_id($state);
        $this->load->library('googlemaps');
        $lat = $data['profile']->lattitude;
        $long = $data['profile']->longitude;
        $config['center'] = '"'.$lat.",". $long.'"';
        $marker['position'] = '"'.$lat.",". $long.'"';
        $this->googlemaps->add_marker($marker);
        $config['zoom'] = '8';
        $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        //var_dump($data['profile']);exit();
        $this->load->view('channel_partner/edit_add_profile',$data);
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
                        $this->form_validation->set_message('gst_checks', 'The {field} should be unique');
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }
        } 
    function update_profile(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
           
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
                          if($data['img']['profile_image']){
                             unlink($data['img']['profile_image']);
                           }
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
                          if($data['img']['profile_image']){
                            unlink($data['img']['brand_image']);
                          }
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
                $result=$this->Channelpartner_model->update_profile($image_file1,$image_file2,$creg,$license);

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


     function cp_settings(){    
        $data=$this->set_menu();
        $this->load->view('channel_partner/cp_change_password',$data);
    }
    function update_password()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('current_password', 'Current password', 'trim|required');
            $this->form_validation->set_rules('new_password', 'New password', 'trim|required');
            $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[new_password]');
            if ($this->form_validation->run() == TRUE) {
                $password = $this->input->post('current_password');
                
                $new_pass = $this->input->post('new_password');
                $session_data=$this->session->userdata('logged_in_cp');
                $id=$session_data['id'];
                $validate_user = $this->Home_model->validate_psw($password,$id);
              
                if ($validate_user) {
                    $res = $this->Home_model->change_password($new_pass,$id);
                    if ($res) {
                        exit(json_encode(array('status' => true)));
                    } else {
                        exit(json_encode(array('status' => false, 'reason' => 'Database Error, Please try Again')));
                    }
                } else {
                    exit(json_encode(array('status' => false, 'reason' => 'Incorrect Current Password ')));
                }
            } else {
                exit(json_encode(array("status" => FALSE, "reason" => validation_errors())));
            }
        } else {
            show_error("Unable To Process The Request In This Way");
        }
    }
    function check_usage_limit_exceed(){
        $amount =$this->input->post('amount');
        $type =$this->input->post('type');
        $mobile =$this->input->post('mobile');
        $data = get_details_by_mobile($mobile);    
        if($data){
            $userid = $data['user_id'];
            $lid = $data['login_id'];
            $udetail = get_details_by_userid($userid);
            $dateString=$udetail['created_on'];
            $fixed_join_date=$udetail['fixed_join_date'];

            //$data["club_type_id"];
            if($type==1){
                $club = ($data["club_type_id"]>0)?$data["club_type_id"]:$data["investor_type_id"];
                $det = getClubtypeById($club);
                // $det = getClubtypeById($data["club_type_id"]);
                $year_limit = $det['cash_limit'];
                $years = round((time()-strtotime($dateString))/(3600*24*365.25));
                if($year_limit>=$years){
                    $wallet_used_per_year = $this->get_club_wallet_used_per_year($lid);
                    $usage_limit = ($det['amount']/$year_limit)-$wallet_used_per_year;
                    // $usage_limit = $det['amount']/$year_limit;
                    if($amount<=$usage_limit)
                    {
                        exit(json_encode(array('status'=>true)));
                    }else{
                        exit(json_encode(array('status'=>false,'reason'=>'You can only use '.$usage_limit.' per year')));
                    }
                }else{
                    exit(json_encode(array('status'=>false,'reason'=>'Club Membership  expired')));
                }
            }
            if($type==5){
                $det2 = getClubtypeById($data["fixed_club_type_id"]);
                $fixed_wallet_details = get_fixed_wallet_details($lid);
                $fixed_wallet_used = get_wallet_used_by_member($lid,5);
                $fixed_wallet_used_per_year = $this->get_fixed_wallet_used_per_year($lid);
                // $tot_amnt = $fixed_wallet_details+$fixed_wallet_used;
                $tot_amnt = $fixed_wallet_details;
                $year_limit = $det2['cash_limit'];
                $years = (time()-strtotime($fixed_join_date))/(3600*24*365);

                if($year_limit>=$years){
                    $fix_within_first_year = date('Y-m-d H:i:s',strtotime('+1 year',strtotime($fixed_join_date)));
                    if(date('Y-m-d H:i:s')<=$fix_within_first_year){
                    }else{
                        switch ($years) {
                            case ($years<=2):
                                $year_limit=4;
                                break;
                            case ($years<=3):
                                $year_limit=3;
                                break;
                            case ($years<=4):
                                $year_limit=2;
                                break;
                            default:
                                $year_limit=1;
                        }
                    }
                        $usage_limit = (($fixed_wallet_details+$fixed_wallet_used_per_year)/$year_limit)-$fixed_wallet_used_per_year;
                        if($amount<$usage_limit)
                        {
                            exit(json_encode(array('status'=>true)));
                        }else if($usage_limit==0)
                        {
                            exit(json_encode(array('status'=>false,'reason'=>'Your fixed wallet usage limit exceed in this year')));
                        }else{
                            exit(json_encode(array('status'=>false,'reason'=>'You can only use '.round($usage_limit).' per year')));
                        }
                }else{
                    exit(json_encode(array('status'=>false,'reason'=>'Fixed Club Membership  expired')));
                }
            }
        }   
    }
    function get_fixed_wallet_used_per_year($id){
        
        $year = date('Y');
        $qry="SELECT SUM(change_value) AS total FROM gp_wallet_activity wa  WHERE wa.wallet_type_id='5' AND wa.user_id='$id' AND wa.type='LOSS' AND YEAR(date_modified) = '$year'";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            $res =  $result->row_array();
            $total = isset($res['total'])?$res['total']:0;
            return $total;
        }else {
            return 0;
        }
    }
    function get_club_wallet_used_per_year($id){
        
        $year = date('Y');
        $qry="SELECT SUM(change_value) AS total FROM gp_wallet_activity wa  WHERE wa.wallet_type_id='1' AND wa.user_id='$id' AND wa.type='LOSS' AND YEAR(date_modified) = '$year'";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            $res =  $result->row_array();
            $total = isset($res['total'])?$res['total']:0;
            return $total;
        }else {
            return 0;
        }
    }
    function check_coupon_code()
    {  
        $data = $this->Channelpartner_model->check_coupon_code();
        if($data){
            if($data['status']=="ACTIVE")
             {
                exit(json_encode(array('status'=>true,'amount'=>$data['amount'],'id'=>$data['id'])));
             }
            else if($data['status']=="USED"){
                 exit(json_encode(array('status'=>false, 'reason'=>'This Coupon is already used')));
            }else{
                 exit(json_encode(array('status'=>false, 'reason'=>'This Coupon is Expired')));
            } 
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'Not a valid Coupon')));
        }
    }
    function delete_billing(){
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('billing_id', 'Billing Id', 'trim|required');
            if ($this->form_validation->run() == TRUE) {
                $billing_id = $this->input->post('billing_id');
                $data = $this->Channelpartner_model->delete_billing($billing_id);
                if($data){
                    exit(json_encode(array('status'=>true)));
                } else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Something went wrong')));
                }
            } else {
                exit(json_encode(array("status" => FALSE, "reason" => validation_errors())));
            }
        } else {
            show_error("Unable To Process The Request In This Way");
        }
    }
}
?>