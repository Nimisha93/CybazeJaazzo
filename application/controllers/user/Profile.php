<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
class Profile extends CI_controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('register_model','user/user_model','user/product_model','admin/Channelpartner_model','register_model','admin/Executives_model','user/Cp_model','admin/Home_model'));
        $this->load->library(array('form_validation','pagination'));
        $this->load->helper(array('form', 'date','string'));
    }
    function set_menu()
    {
        $session_array1 = $this->session->userdata('logged_in_user');
        $session_array2 = $this->session->userdata('logged_in_club_member');
        $session_array3 = $this->session->userdata('logged_in_club_agent');
        
        if(isset($session_array1)){
            $login_id = $session_array1['id'];
            $userid=$session_array1['user_id'];
            $data['channel_partner'] = get_all_channel_partners();
        }
        if(isset($session_array2)){
            $login_id = $session_array2['id'];
            $userid=$session_array2['user_id'];
            //$data['channel_partner'] = $this->Cp_model->get_my_channel_partner($login_id);
            //$data['club_agents'] = get_my_club_members($login_id);
        }
        if(isset($session_array3)){
            $login_id = $session_array3['id'];
            $userid=$session_array3['user_id'];
        }
        $data['login_id']=$login_id;
        $data['userid']=$userid;
        if($login_id){
            $data['cagents']=get_my_club_agents();
            $data['category']=$this->Cp_model->get_cpcategory();
            $data['subcategory']=$this->Cp_model->get_cpscategory();
            $data['countries'] = $this->Cp_model->get_countries();
            $data['modules'] = $this->Cp_model->get_modules();
            $data['subcptype']=$this->product_model->get_subcptype();
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['countries'] = $this->Cp_model->get_countries();

            $data['get_menu']=$this->product_model->get_menus();
            $data['vallet_type'] = $this->product_model->get_wallet();
            $data['user']=$this->user_model->get_normal_customer($userid);
            if($data['user']['country'])
            {
                $country = $data['user']['country'];
                $data['state'] = $this->register_model->get_state_by_country($country);
            }
            $data['user_image']=$this->user_model->get_image($userid);
           
            $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
            $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
            $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        
            return $data;
        }else{
            redirect('/');
        }
    }
    function login_mobile()
    {
        $session_array = $this->session->userdata('logged_in_user');
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/page1",$data);
    }
    function active_friends()
    {
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
       
        $base_url = base_url() . "active_friends/";
        $tbl1 ="gp_login_table" ;
        $tbl2 ="gp_normal_customer";
        $tbl3 ="gp_customer_additional_info";
        $cols = array($tbl1.'.id',$tbl2.'.name',$tbl1.'.mobile',$tbl2.'.profile_image',$tbl3.'.location',$tbl1.'.type');
      
        $result_count = active_friends_count($param,$cols);//active_frnds_count($param,$cols);
        $per_page =  10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;

        $data["data"] = active_friends_paging($param,$cols,$per_page, $page);//active_frnds_paging($param,$cols,$per_page, $page);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    }
    function refered_friends()
    {
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
       
        $base_url = base_url() . "refered_friends/";
        $tbl1 ="gp_user_referrel";//"gp_login_table" ;
        $tbl2 ="";
        $tbl3 ="";
        $cols = array($tbl1.'.id',$tbl1.'.name',$tbl1.'.mobile',$tbl1.'.location ');
        $on1 = "";
        $on2 = "";
        $result_count = refered_friends_count($param,$cols);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;

        $data["data"] = refered_friends_paging($param,$cols,$per_page,$page);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    }
    function get_my_channel_partners()
    {
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
       
        $base_url = base_url() . "my_channel_partners/";
        $tbl1 ="gp_pl_channel_partner";
        $cols = array($tbl1.'.id',$tbl1.'.name',$tbl1.'.pan',$tbl1.'.phone',$tbl1.'.email',$tbl1.'.status',$tbl1.'.owner_name');
        
        $result_count = my_channel_partners_count($param,$cols);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;

        $data["data"] = my_channel_partners_paging($param,$cols,$per_page,$page);
        // echo json_encode($data["data"]);exit;
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    }
    function get_my_club_agents()
    {
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
       
        $base_url = base_url() . "my_club_agents/";
        $tbl1 ="gp_login_table";
        $tbl2 ="gp_normal_customer";
        $cols = array($tbl1.'.id',$tbl2.'.name',$tbl1.'.email',$tbl1.'.mobile',$tbl2.'.ca_docs',$tbl2.'.status');
        
        $result_count = club_agents_count($param,$cols);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = club_agents_paging($param,$cols,$per_page,$page);
        
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    }
    function my_transactions()
    {
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        if ($this->input->post('from')||$this->input->post('to')) {
            $fromm = str_replace('/','-',$this->input->post('from'));
            $from = convert_to_mysql($fromm);
            $too = str_replace('/','-',$this->input->post('to'));
            $to = convert_to_mysql($too);
        }else{
            $from = '';
            $to = '';
        }
        $base_url = base_url() . "my_transactions/";
        $cols = array('gp_pl_channel_partner.name','gp_purchase_bill_notification.purchased_on','gp_purchase_bill_notification.bill_total','gp_purchase_bill_notification.wallet_total','gp_wallet_activity.change_value');
        
        $result_count = my_transactions_count($param,$from,$to,$cols);//get_purchase_by_customers_count($param,$from,$to);//
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = my_transaction_paging($param,$from,$to,$cols,$per_page,$page);//get_purchase_by_customers($param,$from,$to,$per_page,$page);

        //echo json_encode($data["data"]);exit;
        ////my_transaction_paging($param,$from,$to,$cols,$per_page,$page);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
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
    function delete_ca(){
        if($this->input->is_ajax_request()){
            $id = $this->input->post('row_id');
            $result = $this->register_model->delete_ca($id);
            if($result){
                exit(json_encode(array("status"=>TRUE)));
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
            }
            
        } else {
            show_error("We are unable to process this request on this way!");
        }
    }
    function delete_cp(){
        if($this->input->is_ajax_request()){
            $id = $this->input->post('row_id');
            $result = $this->Cp_model->delete_cp($id);
            if($result){
                exit(json_encode(array("status"=>TRUE)));
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
            }
            
        } else {
            show_error("We are unable to process this request on this way!");
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
                        return TRUE;
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
                        return TRUE;
                }
        } 
    function new_partner()
    {
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("channel_type[]", "Channel Partner Type ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email", "valid_email|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Phone", "numeric|trim|required|min_length[10]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("ocname", "Contact Person", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("oc_mobile", "Contact Person's Mobile No", "numeric|trim|min_length[10]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("oc_email", "Contact Email", "valid_email|trim|required|htmlspecialchars");





            $this->form_validation->set_rules("area", "Area", "trim|required|htmlspecialchars");







           
            $this->form_validation->set_rules("latt", "Latitude", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("long", "Longitude", "trim|required|htmlspecialchars");
            //$this->form_validation->set_rules("town", "City", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pan", "PAN Number", "trim|required|htmlspecialchars|exact_length[10]|callback_pan_check");
            if($this->input->post('gst')){
                $this->form_validation->set_rules("gst", "GST Number", "trim|htmlspecialchars|exact_length[15]|callback_gst_check");
            }

            if($this->form_validation->run()== TRUE){
                $this->load->helper('string');
                $otp = random_string('numeric', 4);
                $qr_no = random_string('numeric', 4);
                $data = array();
                // var_dump($_FILES['pro']['name']);exit();
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
                $result=$this->Cp_model->add_partner($otp,$qr_no,$creg,$license);
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
    function ch_mail_exists()
    {
        $mail=$this->input->post('mail');
        $result = $this->Cp_model->mail_exisits($mail);
        if($result == FALSE)
        {
            exit(json_encode(array('status'=> true)));
        } else{
            exit(json_encode(array('status'=> FALSE)));
        }
    }
    function ch_mobile_exists(){
        $mob=$this->input->post('mob');
        $result = $this->Cp_model->mobile_exisits($mob);
        if($result == FALSE)
        {
            exit(json_encode(array('status'=> true)));
        } else{
            exit(json_encode(array('status'=> FALSE)));
        }
    }
    function refer_channel_partner(){
        if($this->input->is_ajax_request()){
            // $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            // $this->form_validation->set_rules("phone", "Phone","numeric|trim|required|min_length[10]|max_length[13]|htmlspecialchars");
            
            $this->form_validation->set_rules('club_type', 'Club Type', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('name', 'Channel Name', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('email', 'Channel Email', 'trim|valid_email|htmlspecialchars|is_unique[gp_pl_channel_partner.email]');
            $this->form_validation->set_rules('phone', 'Phone', 'required|trim|numeric|is_unique[gp_pl_channel_partner.phone]');
            $this->form_validation->set_rules('oc_name', 'Owner Name', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('oc_email', 'Owner Email', 'required|trim|valid_email|htmlspecialchars');
            $this->form_validation->set_rules('oc_mobile', 'Owner Mobile', 'required|trim|numeric');
            $this->form_validation->set_rules('area', 'Area', 'required|trim');
            if($this->form_validation->run()== TRUE){
                $result=$this->Cp_model->refer_partner();
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
    function add_ba()
    {
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Contact","numeric|trim|required|min_length[10]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email", "required|trim");
            $this->form_validation->set_rules("address", "Address", "trim|required|htmlspecialchars");

            if($this->form_validation->run()== TRUE){
                $mail= $this->input->post('email');
                $mob = $this->input->post('phone');
                $res = $this->register_model->ba_validation($mail,$mob);
                if($res['status']){
                    $result=$this->register_model->add_ba();
                    if($result){
                        $data['id'] = $result['info']['user_id'];
                        $data['otp'] = $result['info']['otp'];
                        $email = "kavyababu19@gmail.com";
                        $mail_head = 'Message From Jaazzo';
                       
                        $mail=$this->input->post('email');
                        $status = send_custom_email($email, $mail_head, $mail, 'Sign Up - BA', $this->load->view('templates/public/mail/ba_sign_up', $data,TRUE));

                        if($status)
                        {
                            exit(json_encode(array('status'=>true)));
                        }else{
                            exit(json_encode(array("status"=>TRUE)));
                        }
                    }
                    else{
                        exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                    }
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>"Jaazzo Store Already exist")));
                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
    }
    function add_bde()
    {
      if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Contact","numeric|trim|required|min_length[10]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email", "required|trim");
            //$this->form_validation->set_rules("c_email", "Contact Email", "valid_email|trim|required|htmlspecialchars");

            if($this->form_validation->run()== TRUE){
                $result=$this->register_model->add_bde();
                if($result){
                    $a3 = $this->input->post('email');
                    $data['id']=$result;
                    $email = "kavyababu19@gmail.com";
                    $mail_head = 'Message From Jaazzo';
                    $status = send_custom_email( $email, $mail_head,$a3, 'Sign Up - Executive', $this->load->view('templates/public/mail/exec_sign_up',$data,TRUE ));
                    if($status)
                       {
                        exit(json_encode(array('status'=>true)));
                        }else{
                        exit(json_encode(array("status"=>TRUE)));
                        }
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
    function get_my_ba(){
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "get_my_ba/";
        $cols = array('ba.id ,ba.name,
              ba.mobil_no AS mobile,ba.email,
              ba.company_name,
              ba.office_phno AS company_contact,
              ba.office_email AS company_email,ba.status');
        $result_count = get_ba_count($param,$cols);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = get_all_bas($param,$cols,$per_page,$page);

        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    }
    function get_my_bde(){
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "get_my_bde/";
        $cols = array('gp_team_mem.id,gp_member_det.name,gp_member_det.phone,gp_member_det.email,gp_desig.designation,gp_team_mem.status');
        $result_count = get_bde_count($param,$cols);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;
        $data["data"] = get_all_bdes($param,$cols,$per_page,$page);

        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    }
    function refer_ba()
    {
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Contact","numeric|trim|required|min_length[10]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email", "required|trim");

            if($this->form_validation->run()== TRUE){
                $mail= $this->input->post('email');
                $mob = $this->input->post('phone');
                $res = $this->register_model->ba_validation($mail,$mob);
                if($res['status']){
                    $result=$this->register_model->refer_ba();
                    if($result){
                        exit(json_encode(array("status"=>TRUE)));
                    }
                    else{
                        exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                    }
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>"BA Already exist")));
                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
    }
    function test()
    {
       $res = $this->register_model->get_exe(); 
       echo json_encode($res);
    }
    function view_channel_partner($id)
    {
        $data = $this->set_menu();
        $data['partner']=$this->Cp_model->get_cp_details($id);
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
        $this->load->view('public/edit_my_channelpartners',$data);
    }
    function edit_channel_partner($id)
    {
        $data = $this->set_menu();
        $data['partner']=$this->Cp_model->get_cp_details($id);
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
        $this->load->view('public/edit_cp_details',$data);
    }
    function edit_refer_partner()
    {
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email", "valid_email|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Phone", "numeric|trim|required|min_length[10]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("ocname", "Owner Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("oc_mobile", "Owner's Mobile Number", "numeric|trim|min_length[7]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("oc_email", "Owner's Email", "valid_email|trim|required|htmlspecialchars"); 
            $this->form_validation->set_rules("address", "Address", "trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $result=$this->Cp_model->update_refer_partner();
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
    function edit_partner()
    {
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
                  $data['img']=$this->Cp_model->get_item_byid($id);
                  //var_dump($data['img']);exit;
                  /*if(isset($_FILES['pro']['name']))
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
                  }*/
                  $creg =$data['img']['company_registration'];
                  $license = $data['img']['license'];
                
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
                    $result=$this->Cp_model->edit_partnerbyid($creg,$license);
                /*$result=$this->Cp_model->edit_partnerbyid($image_file1,$image_file2,$creg,$license);*/

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
}