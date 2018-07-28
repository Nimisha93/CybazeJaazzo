<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 */

Class Executives extends CI_Controller
{

    function __Construct()
    {
        parent:: __construct();
        $this->load->library(array('session','form_validation','pagination'));
        $this->load->model(array('admin/Executives_model','admin/Profile_model','admin/Clubmember_model','admin/Channelpartner_model','user/product_model','admin/Home_model'));
        $this->load->helper(array('url','form', 'custom','my_common_helper','string'));
       
        $session_array1 = $this->session->userdata('logged_in_exec');
        if(!isset($session_array1) ){
            redirect('admin/Login');
        }
    }
    function get_clubplans_by_type()
    {
        if($this->input->is_ajax_request())
        {
            $res = $this->Clubmember_model->get_clubplans_by_type($this->input->post());
           
            if($res)
            {
                $det = '';
                if(isset($res['res1'])){
                    $det .='<div class="col-md-4">'.ucfirst(strtolower($res['res1']['0']['type'])).'</div><div class="col-md-8 col-sm-12 col-xs-12">';
                    foreach ($res['res1'] as $key => $value) {
                        $det .='<div class="col-md-4 col-sm-12 col-xs-12">
                            <input type="radio" name="club_plan" value="'.$value['id'].'"><label style="padding-left: 10px;">'.ucwords($value['title']).'</label>
                        </div>';
                    }
                    $det .='</div>';
                }
                if(isset($res['res2'])){
                $det .='<div class="col-md-4">'.ucfirst(strtolower($res['res2']['0']['type'])).'</div><div class="col-md-8 col-sm-12 col-xs-12">';
                    foreach ($res['res2'] as $key => $value) {
                        $det .='<div class="col-md-4 col-sm-12 col-xs-12">
                            <input type="radio" name="club_plan2" value="'.$value['id'].'"><label style="padding-left: 10px;">'.ucwords($value['title']).'</label>
                        </div>';
                    }
                $det .='</div>';
                }
                exit(json_encode(array('status'=>TRUE,'data'=>$det)));
            }else{
                exit(json_encode(array('status'=>FALSE, 'reason'=>'Please try again later..!')));
            }
        }else{
            show_error("Unable to process the request in this way");
        }
    }
    function set_menu(){
        

        $datas = getLoginDetails();
        if($datas){
            $type = $datas['type'];
            $userid=$datas['user_id'];
        } 
      
        $data['user']=$this->Profile_model->get_exicutives($userid);
        

        if($type == 'executive'){
        
        $data['header'] = $this->load->view('executive/templates/ex_header',$data,  true);
        $data['sidebar'] = $this->load->view('executive/templates/ex_sidebar',$data,  true);
        $data['footer'] = $this->load->view('executive/templates/ex_footer', '', true);
        }
        else{
            
            $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
            $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
            $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
            }
      
        return $data;
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
    function exec_dashboard()
    {
        $loginsession = $this->session->userdata('logged_in_exec');

        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $desig=$loginsession['desig'];
        $desig=$loginsession['desig'];
        //echo $desig;exit();
        $data['user']=$this->Profile_model->get_exicutives($userid);

        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $exe_details = get_execuitive_details();
        $data['header'] = $this->load->view('executive/templates/ex_header',$data,  true);
        $data['sidebar'] = $this->load->view('executive/templates/ex_sidebar',$data,  true);
        $data['footer'] = $this->load->view('executive/templates/ex_footer', '', true);
        $data['clubagent']=$this->Executives_model->get_clubagent_count($lgid);
        $data['channel_partner']=$this->Executives_model->get_channel_count($lgid);
        $data['club_member']=$this->Executives_model->get_club_count($lgid);
        $data['my_wallet']=$this->Executives_model->get_my_wallet($lgid);
        $data['executive']=$this->Executives_model->get_executive_count($lgid);
        $data['ba']=$this->Executives_model->get_ba_count($lgid);
        $data['my_wallet_value']=$this->Executives_model->get_mywallet_value();
        $data['promotion']=$this->Executives_model->get_promotion($lgid);

        //$data['is_set_gift']=$this->Executives_model->is_set_gift($desig);
        //print_r($data['promotion']);exit();
        $this->load->view('executive/ex_dashboard',$data);

    }
    function exec_profile(){
       
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['executives']=$this->Executives_model->get_executives_id($userid);
        //print_r($userid);exit();
        $this->load->view('executive/exec_profile',$data);
    }
    function edit_profile($id){

            if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("c_number", "Contact No", "numeric|trim|required|min_length[10]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email", "trim|required|htmlspecialchars");
           

            if($this->form_validation->run()== TRUE){
               
                // var_dump($_FILES['pro']['name']);exit();
/*                if(!isset($_FILES['file']['name']))
                {
                    exit(json_encode(array('status'=>FALSE, 'reason'=>"Please select a profile image")));
                }
*/
                $result=$this->Executives_model->edit_profile($id);
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
        show_error("We are unable to process this request on this way!");   
        }

    }




    function exec_settings(){
       
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $this->load->view('executive/exec_change_password',$data);
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
                $session_data=$this->session->userdata('logged_in_exec');
                $id=$session_data['id'];
                $validate_user = $this->Home_model->validate_psw($password,$id);
                // $validate_user = $this->Executives_model->get_clubagent_count($password);
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





//clubmember

    function exec_add_clubmember(){
       
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];

        $club_membership = $this->Executives_model->club_membership();
        $this->load->view('executive/exec_add_clubmember',$data);
    }
     

     function new_club_member(){
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];

        $lgid=$loginsession['id'];
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("email","Email", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("mob", "Mobile", "numeric|trim|required|min_length[10]|max_length[13]|htmlspecialchars");
           if($this->form_validation->run()== TRUE){

                        $a3 = $this->input->post('email');
                        $a4 = $this->input->post('mob');

                $validate_clubmember = $this->Executives_model->validate_club_member($a3,$a4);
                
                if($validate_clubmember['status'] === TRUE)
                {
               

                    $validate_user = $this->Executives_model->validate_user($a3,$a4);
                  
                    if($validate_user['status'] === TRUE)
                    {
                        $res = $validate_user['reason'];
                          //print_r($res);exit();
/*                        $normal_user_id = $validate_user['reason']['user_id'];
                        $parent_id = $validate_user['reason']['parent_login_id'];

                        $a1 = $this->input->post('name');
                        $a2 = $this->input->post('package');
                        $a3 = $this->input->post('email');
                        $a4 = $this->input->post('mob');
                        $a5 = $this->input->post('mode_payment');
                        $a6 = $this->input->post('cheque_no');
                        $a7 = $this->input->post('bank');
                        $date = date('Y-m-d');
                        $otp = random_string('numeric', 5);
                    $data = array( 
                                'club_type_id' => $a2,
                                'name' => $a1,
                                'phone' => $a4,
                                'email' => $a3,
                                'otp' => $otp,
                                'profile_image' => 'profile.png',
                                'reg_otp_status' => 0,
                                'type'=>'club_member',
                                'mode_payment'=>$a5,
                                'cheque_no'=> $a6,
                                'bank'=>$a7,
                                'parent_id' => $lgid,
                                'created_by'=>$lgid,
                                'created_on' =>$date,
                                'register_via' =>'executive',
                                'status'=>'notapproved'
                                );*/
                   
                    $results=$this->Executives_model->club_registration($res);
                      if($results)
                            {
                                 
                                /* $data['id'] = $results['info']['user_id'];
                                $data['otp'] = $results['info']['otp'];
                                $email = "maneeshakk16@gmail.com";
                                $mail_head = 'Message From Jaazzo';
                                $status = send_custom_email($email, $mail_head, $a3, 'Sign Up - Club Member', $this->load->view('templates/public/mail/club_member_sign_up', $data,TRUE));
                                
                                if($status)
                                {
                                    exit(json_encode(array('status'=>true,'data'=>'hh')));
                                }else{
                                    exit(json_encode(array("status"=>false)));
                                }*/
                                exit(json_encode(array('status'=>true,'data'=>'hh')));
                            }else{
                                exit(json_encode(array('status'=>false, 'reason'=>'Database Error')));
                            }
            
                    }else{
                        exit(json_encode(array("status"=>FALSE,"reason"=>$validate_user['reason'])));
                        }
                }else{
                        exit(json_encode(array("status"=>FALSE,"reason"=>$validate_clubmember['reason'])));
                    }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
                }
        }
        else{
                show_error("We are unable to process this request on this way!");   
            }
    }
    function view_club_member(){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];

        $lgid=$loginsession['id'];
        $data['member']=$this->Executives_model->get_club_member($lgid);
        //echo $data['member']['member'][0]['fixed_club_type_id'];exit();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
            
        }else{
            $param = '';
        }
        $base_url = base_url() . "view_club_member/";
        $result_count =$this->Executives_model->get_club_member_count($param,$lgid);
        
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Executives_model->get_club_member_all($param,$per_page,$page,$lgid);
       // echo "vb b";exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('executive/exec_view_club_member',$data);
    }
    function view_active_club_member(){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['member']=$this->Executives_model->get_active_club_member($lgid);
        
       if ($this->input->post('search')) {
            $param = $this->input->post('search');
            
        }else{
            $param = '';
        }
        $base_url = base_url() . "view_active_club_member/";
        $result_count =$this->Executives_model->get_active_club_member_count($param,$lgid);
       
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Executives_model->get_active_club_member_all($param,$per_page,$page,$lgid);
       // echo "vb b";exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }




        $this->load->view('executive/exec_view_active_club_member',$data);
    }

    function delete_club_member()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->Executives_model->delete_club_member($this->input->post());
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
    function update_club_member($id)
    {

        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['c_memb']=$this->Executives_model->get_member_byId($id);
        $ctype = isset($data['details']['ctype'])?$data['details']['ctype']:'UNLIMITED';
        $data['club_types'] = get_club_plan_bytypes($ctype);
        $data['fixed_club_types'] = get_club_plan_bytypes('FIXED');
        //print_r($data['c_memb']);exit();
        $this->load->view('executive/exec_update_clubmember',$data);
    }
    function get_clubplans_by_type_exc()
    {
        if($this->input->is_ajax_request())
        {
            $res = $this->clubmember_model->get_clubplans_by_type($this->input->post());
           
            if($res)
            {
                $det = '';
                if(isset($res['res1'])){
                    $det .='<div class="col-md-4">'.ucfirst(strtolower($res['res1']['0']['type'])).'</div><div class="col-md-8 col-sm-12 col-xs-12">';
                    foreach ($res['res1'] as $key => $value) {
                        $det .='<div class="col-md-4 col-sm-12 col-xs-12">
                            <input type="radio" name="club_plan" value="'.$value['id'].'"><label style="padding-left: 10px;">'.ucwords($value['title']).'</label>
                        </div>';
                    }
                    $det .='</div>';
                }
                if(isset($res['res2'])){
                $det .='<div class="col-md-4">'.ucfirst(strtolower($res['res2']['0']['type'])).'</div><div class="col-md-8 col-sm-12 col-xs-12">';
                    foreach ($res['res2'] as $key => $value) {
                        $det .='<div class="col-md-4 col-sm-12 col-xs-12">
                            <input type="radio" name="club_plan2" value="'.$value['id'].'"><label style="padding-left: 10px;">'.ucwords($value['title']).'</label>
                        </div>';
                    }
                $det .='</div>';
                }
                exit(json_encode(array('status'=>TRUE,'data'=>$det)));
            }else{
                exit(json_encode(array('status'=>FALSE, 'reason'=>'Please try again later..!')));
            }
        }else{
            show_error("Unable to process the request in this way");
        }
    }


    function edit_club_member($id)
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('mob', 'Mobile', 'required|trim');
            $this->form_validation->set_rules("type","Membership Type","trim|required|htmlspecialchars");
            // $this->form_validation->set_rules('club_plan', 'Club Plan', 'required|trim');
            if($this->form_validation->run() == TRUE)
            {

                $club_plan = $this->input->post('club_plan');
                $det1 = getClubtypeById($club_plan);
                $type2 =$this->input->post('club_plan2');
                $det2 = isset($type2)?getClubtypeById($type2):'';
              
                $name = $this->input->post('name');
                $id = $this->input->post('id');
                $mobile = $this->input->post('mob');
                $club_plan = $this->input->post('club_plan');
                $mode_payment = $this->input->post('mode');
                $ch = $this->input->post('cheque');
                $cheque_no = isset($ch)?$ch:'';
                $ba = $this->input->post('bank');

                $bank = isset($ba)?$ba:'';
                $cdate = $this->input->post('cheque_date');
                $date = isset($cdate)?$cdate:'';
                
                $datas=array('phone' => $mobile,
                    'name' => $name,
                    'mode_payment'=>$mode_payment
                    );
                if(!empty($det1)&&$det1['type']=='UNLIMITED'){
                    $datas['club_type_id'] = $club_plan;
                    $datas['fixed_club_type_id']=$type2;
                }else{
                    $datas['club_type_id'] =$type2;
                    $datas['fixed_club_type_id']=$club_plan;
                }
                if(!empty($det2)&&$det2['type']=='UNLIMITED'){
                    $datas['club_type_id'] = $type2;
                    $datas['fixed_club_type_id']=$club_plan;
                }else{
                    $datas['club_type_id'] = $club_plan;
                    $datas['fixed_club_type_id']=$type2;
                }
                if($mode_payment=='cheque'){
                    $datas['cheque_no']=$cheque_no;
                    $datas['bank']=$bank;
                    $datas['cheque_date']=date('Y-m-d',strtotime($date));
                    //echo $datas['cheque_date'];exit();
                }

                $result = $this->Executives_model->update_club_member($datas,$id);
                
                
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Database Error')));
                }
                    
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        } 
    }



//channelpartner
    function add_channel_partner(){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $this->load->library('googlemaps');
        $config['center'] = '10.804305026919454, 76.11534118652344';
        $config['zoom'] = '8';
        $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $data['member']=$this->Executives_model->get_active_club_member($lgid);
        $data['category']=$this->Home_model->get_cpcategory();
        $data['subcategory']=$this->Home_model->get_cpscategory();
        $data['countries'] = $this->Home_model->get_countries();
        $data['modules'] = $this->Home_model->get_modules();
        $this->load->view('executive/exec_add_channel_partner',$data);
    
     }


    function refer_cp_add($id){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $this->load->library('googlemaps');
        $config['center'] = '10.804305026919454, 76.11534118652344';
        $config['zoom'] = '8';
        $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $data['member']=$this->Executives_model->get_active_club_member($lgid);
        $data['category']=$this->Home_model->get_cpcategory();
        $data['subcategory']=$this->Home_model->get_cpscategory();
        $data['countries'] = $this->Home_model->get_countries();
        $data['modules'] = $this->Home_model->get_modules();
        $data['cp'] = $this->Channelpartner_model->get_refer_cp($id);
        $this->load->view('executive/exec_add_cp_reffer',$data);
    
     }
    function update_channel_partner($id)
     {
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $this->load->library('googlemaps');
        $config['center'] = '10.804305026919454, 76.11534118652344';
        $config['zoom'] = '8';
        $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $data['member']=$this->Executives_model->get_active_club_member($lgid);

        $data['category']=$this->Home_model->get_cpcategory();
        $data['subcategory']=$this->Home_model->get_cpscategory();
        $data['countries'] = $this->Home_model->get_countries();
        $data['states'] = $this->Home_model->get_states();
        //$data['city'] = $this->Home_model->get_city();
        $data['modules'] = $this->Home_model->get_modules();
        $data['partner']= $this->Home_model->get_channerpartner_byid($id);
        $state_id=$data['partner']['partner']['state'];
        $data['cities'] = $this->Home_model->get_town_by_id($state_id);

        $club_id = $data['partner']['partner']['club_mem_id'];
        $data['cl_type']= $this->Executives_model->get_member_type($club_id);
/*                $country = $data['partner']['country'];

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
            }*/
        //print_r($data['partner']);exit();
        $this->load->view('executive/exec_update_cp',$data);
     }
    function update_channel_partner_id(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("name", "Name ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Phone", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email", "trim|required|htmlspecialchars");
           // $this->form_validation->set_rules("fax", "Fax", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("address", "Address", "trim|required|htmlspecialchars");
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
                $result=$this->Executives_model->edit_partnerbyid($image_file1,$image_file2);

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
    public function pan_check($str)
        {
            $where = array('is_del'=>0, 'pan'=>$str);
            $sql = $this->db->select('id')->where($where)->get('gp_pl_channel_partner')->row('id');

                if ($sql)
                {
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
    function new_channel_partner()
    {
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("channel_type[]", "Channel Partner Type ", "trim|required|htmlspecialchars"); 
            $this->form_validation->set_rules("email", "Email", "valid_email|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Phone", "numeric|trim|required|min_length[10]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("ocname", "Owner Name", "trim|required|htmlspecialchars");
           
            $this->form_validation->set_rules("oc_mobile", "Owner's Mobile Number", "numeric|trim|min_length[7]|max_length[13]|htmlspecialchars");
            
            $this->form_validation->set_rules("oc_email", "Owner Email", "valid_email|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pan", "PAN Number", "trim|required|htmlspecialchars|exact_length[10]|callback_pan_check");
            if($this->input->post('gst')){
                $this->form_validation->set_rules("gst", "GST Number", "trim|htmlspecialchars|exact_length[15]|callback_gst_check");
            }
            $this->form_validation->set_rules("town", "City", "trim|required|htmlspecialchars");
            
            
            
            $this->form_validation->set_rules("area", "Area", "trim|required|htmlspecialchars");
            
            
            
            
            $this->form_validation->set_rules("latt", "Latitude", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("long", "Longitude", "trim|required|htmlspecialchars");
            

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

                
                $result=$this->Executives_model->add_partner($otp,$qr_no,$creg,$license);
                if($result){
                    exit(json_encode(array("status"=>TRUE,)));
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
    
     /*   function refer_channel_partner()
    {
      
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("channel_type[]", "Channel Partner Type ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Phone", "numeric|trim|required|min_length[10]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("phone2", "Phone", "numeric|trim|min_length[7]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email", "valid_email|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("address", "Address", "trim|required|htmlspecialchars");
           
            $this->form_validation->set_rules("town", "Town", "trim|required|htmlspecialchars");
           

            if($this->form_validation->run()== TRUE){
                $this->load->helper('string');
                $otp = random_string('numeric', 4);
                $qr_no = random_string('numeric', 4);
                $data = array();
                // var_dump($_FILES['pro']['name']);exit();
                if(!isset($_FILES['pro']['name']))
                {
                    exit(json_encode(array('status'=>FALSE, 'reason'=>"Please select a profile image")));
                }
                if(!isset($_FILES['bri']['name']))
                {
                    exit(json_encode(array('status'=>FALSE, 'reason'=>"Please select a brand image")));
                }
                $result=$this->Executives_model->add_refer_partner($otp,$qr_no);
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
    }*/
    
    
    
    
    
    
          function refer_channel_partner()
    {
      
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("channel_type[]", "Channel Partner Type ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Phone", "numeric|trim|required|min_length[10]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("phone2", "Phone", "numeric|trim|min_length[7]|max_length[13]|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email", "valid_email|trim|required|htmlspecialchars");
           /* $this->form_validation->set_rules("address", "Address", "trim|required|htmlspecialchars");*/
           
            $this->form_validation->set_rules("town", "Town", "trim|required|htmlspecialchars");
            
            
            
            $this->form_validation->set_rules("area", "Area", "trim|required|htmlspecialchars");
            
            
           
            $this->form_validation->set_rules("pan", "PAN Number", "trim|required|htmlspecialchars|exact_length[10]|callback_pan_check");

            if($this->form_validation->run()== TRUE){
                $this->load->helper('string');
                $otp = random_string('numeric', 4);
                $qr_no = random_string('numeric', 4);

               /* $data = array();*/
                // var_dump($_FILES['pro']['name']);exit();
             /*   if(!isset($_FILES['pro']['name']))
                {
                    exit(json_encode(array('status'=>FALSE, 'reason'=>"Please select a profile image")));
                }
                if(!isset($_FILES['bri']['name']))
                {
                    exit(json_encode(array('status'=>FALSE, 'reason'=>"Please select a brand image")));
                }*/



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

                
                $result=$this->Executives_model->add_refer_partner($otp,$qr_no,$creg,$license);




               /* $result=$this->Executives_model->add_refer_partner($otp,$qr_no);*/
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
    
    
    
    
    
    
    
    
    
    
    
    
    
    function get_club_details_id($id){

        if($this->input->is_ajax_request())
        {
            $data = $this->Executives_model->get_club_details_id($id);
          
            if($data)
            {
                exit(json_encode(array('status'=>TRUE ,'data'=>$data)));
            }else{
                exit(json_encode(array('status'=>FALSE, 'reason'=>'Please try again later..!')));
            }
        }else{
            show_error("Unable to process the request in this way");
        }   
    }
    function get_count_by_id($id){
       
        if($this->input->is_ajax_request())
        {

           $det = get_cmfacility_by_id($id);

          if($det)
            {
                exit(json_encode(array('status'=>TRUE ,'data'=>$det)));
            }else{
                exit(json_encode(array('status'=>FALSE, 'reason'=>'Please try again later..!')));
            }
        }   
    }
        function get_count_by_id_store($id){
       
        if($this->input->is_ajax_request())
        {

           $det = get_cm_facility_by_id($id);
        
          if($det)
            {
                exit(json_encode(array('status'=>TRUE ,'data'=>$det)));
            }else{
                exit(json_encode(array('status'=>FALSE, 'reason'=>'Please try again later..!')));
            }
        }   
    }
    function view_channel_partner(){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        //$data['partner']=$this->Executives_model->get_channerpartner($lgid);
        //print_r($data['partner']);exit();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
            
        }else{
            $param = '';
        }
        $base_url = base_url() . "view_channel_partner/";
        $result_count =$this->Executives_model->get_pending_cp_count($param,$lgid);
        
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Executives_model->get_pending_cp_all($param,$per_page,$page,$lgid);

        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('executive/exec_view_channel_partner',$data);
    }
    function view_active_channel_partner(){
/*        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['partner']=$this->Executives_model->get_active_channerpartner($lgid);
        $this->load->view('executive/exec_view_active_channel_partner',$data);*/


        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['partner']=$this->Executives_model->get_active_channerpartner($lgid);
        //print_r($data['partner']);
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
            
        }else{
            $param = '';
        }
        $base_url = base_url() . "view_active_channel_partner/";
        $result_count =$this->Executives_model->get_active_channerpartner_count($param,$lgid);
        
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Executives_model->get_active_channerpartner_all($param,$per_page,$page,$lgid);

       // echo "vb b";exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('executive/exec_view_active_channel_partner',$data);
    }

    function club_member_channel_partner(){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['partner']=$this->Executives_model->get_reffer_channerpartner($lgid);
        //print_r($data['partner']);
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
            
        }else{
            $param = '';
        }
        $base_url = base_url() . "club_member_channel_partner/";
        $result_count =$this->Executives_model->get_reffer_channerpartner_count($param,$lgid);
        
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Executives_model->get_reffer_channerpartner_all($param,$per_page,$page,$lgid);

       // echo "vb b";exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('executive/view_club_member_channel_partner',$data);
    }


//clubagent

    function add_club_agent(){
        $data=$this->set_menu();
        
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['member']=$this->Executives_model->get_active_club_member_fixed($lgid);
        $this->load->view('executive/exec_add_club_agent',$data);
    }

    function new_club_agent()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('club_member', 'Club Member', 'required|trim');
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('mail', 'Email', 'required|trim');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim');
            /*if (empty($_FILES['ufile']['name']))
            {
              $this->form_validation->set_rules('ufile', 'File', 'required');
            }*/
            if($this->form_validation->run() == TRUE)
            {
                $club_member = $this->input->post('club_member');
                $name = $this->input->post('name');
                $mail = $this->input->post('mail');
                $validate_email = $this->Executives_model->validate_email($mail);
                
                if($validate_email['status'] === TRUE)
                {
                    $mobile = $this->input->post('mobile');
                    $validate_phone = $this->Executives_model->validate_phone($mobile);
                    if($validate_phone['status'] === TRUE)
                    {
                        $files = $_FILES;
                        if($files){
                        $config['upload_path'] =  './uploads/ca_docs';
                        $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
                        $config['max_size'] = '2000000';
                        $config['remove_spaces'] = true;
                        $config['overwrite'] = false;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('ufile'))
                        {
                          exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
                        }else{
                            $_FILES['ufile']['name']= time().str_replace(' ', '_', $files['ufile']['name']);
                            $_FILES['ufile']['type']= $files['ufile']['type'];
                            $_FILES['ufile']['tmp_name']= $files['ufile']['tmp_name'];
                            $_FILES['ufile']['error']= $files['ufile']['error'];
                            $_FILES['ufile']['size']= $files['ufile']['size'];
                            $this->upload->do_upload('ufile');
                            $fileName = time().str_replace(' ', '_', $files['ufile']['name']);
                            $upload_data = $this->upload->data();
                            $data=array('mem_id' => $club_member,
                            'mobile' => $mobile,
                            'name' => $name,
                            'email' => $mail,
                            'file'=>'uploads/ca_docs/'.$fileName,
                            'register_via' => "executive",
                            'type' => 'club_agent'
                            );
                        }
                    }else{
                        $data=array('mem_id' => $club_member,
                            'mobile' => $mobile,
                            'name' => $name,
                            'email' => $mail,
                            'register_via' => "executive",
                            'type' => 'club_agent'
                            );
                    }

                            $result = $this->Executives_model->add_club_agent($data);
                            //var_dump($result);exit();
                            if($result)
                            { 
                               
                                $data['id'] = $result['info']['user_id'];
                                $data['otp'] = $result['info']['otp'];
                                $email = "kavyababu19@gmail.com";
                                $mail_head = 'Message From Jaazzo';
                                 //echo $mail_head;exit();
                                $status = send_custom_email($email, $mail_head, $mail, 'Sign Up - Club Agent', $this->load->view('templates/public/mail/ca_sign_up', $data,TRUE));

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
                        exit(json_encode(array('status'=>false, 'reason'=>'Mobile already exist')));
                    }
                }else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Email already exist')));
                }
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        }  
    } 
    function view_club_agent(){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['agent']=$this->Executives_model->get_club_agent($lgid);
       // print_r($data['agent']);exit();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
            
        }else{
            $param = '';
        }
        $base_url = base_url() . "view_club_agent/";
        $result_count =$this->Executives_model->get_club_agent_count($param,$lgid);
        
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Executives_model->get_club_agent_all($param,$per_page,$page,$lgid);

       // echo "vb b";exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('executive/exec_view_club_agent',$data); 
    }

    function view_active_club_agent(){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        // $data['agent']=$this->Executives_model->get_active_club_agent($lgid);
        // echo json_encode($data['agent']);exit();
         if ($this->input->post('search')) {
            $param = $this->input->post('search');
            
        }else{
            $param = '';
        }
        $base_url = base_url() . "view_active_club_agent/";
        $result_count =$this->Executives_model->get_active_ca_count($param,$lgid);
        
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Executives_model->get_all_active_ca($param,$per_page,$page,$lgid);
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('executive/exec_view_active_club_agent',$data); 
    }
    function delete_club_agent()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->Executives_model->delete_club_agent($this->input->post());
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
    function edit_club_agent($id){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['member']=$this->Executives_model->get_active_club_member($lgid);
        $data['agent']=$this->Executives_model->get_club_agent_id($id);
       // print_r($data['agent']);exit();
        $this->load->view('executive/exec_edit_club_agent',$data); 
    }

    function update_club_agent($id)
    {
       
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('mail', 'Email', 'required|trim');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim');
            if($this->form_validation->run() == TRUE)
            {
                $club_member = $this->input->post('club_member');
                
                $name = $this->input->post('name');
                $mail = $this->input->post('mail');
                /*$id = $this->input->post('id');*/
                $create_by = $this->input->post('create_by');
                $mobile = $this->input->post('mobile');
                    
                $files = $_FILES;
                if($files){
                    $config['upload_path'] =  './uploads/ca_docs';
                    $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
                    $config['max_size'] = '2000000';
                    $config['remove_spaces'] = true;
                    $config['overwrite'] = false;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if (!$this->upload->do_upload('ufile'))
                    {
                      exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
                    }else{
                        $_FILES['ufile']['name']= time().str_replace(' ', '_', $files['ufile']['name']);
                        $_FILES['ufile']['type']= $files['ufile']['type'];
                        $_FILES['ufile']['tmp_name']= $files['ufile']['tmp_name'];
                        $_FILES['ufile']['error']= $files['ufile']['error'];
                        $_FILES['ufile']['size']= $files['ufile']['size'];
                        $this->upload->do_upload('ufile');
                        $fileName = time().str_replace(' ', '_', $files['ufile']['name']);
                        $upload_data = $this->upload->data();
                        $data=array('mem_id' => $club_member,
                        'phone' => $mobile,
                        'name' => $name,
                        'email' => $mail,
                        'ca_docs'=>'uploads/ca_docs/'.$fileName,
                        'register_via'=>$create_by
                        );
                        $result = $this->Executives_model->update_club_agent($data,$id);
                    }
                }else{
                    $data=array('mem_id' => $club_member,
                        'phone' => $mobile,
                        'name' => $name,
                        'email' => $mail
                        );
                    $result = $this->Executives_model->update_club_agent($data,$id);
                }
                
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Database Error')));
                }
                    
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        } 
    }





    function add_user(){
        $data=$this->set_menu();
        $this->load->view('executive/exec_add_user',$data);
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
    function exec_add(){
/*        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];*/
        $datas = getLoginDetails();
        if($datas){
            $type = $datas['type'];
            $userid=$datas['user_id'];
        } 
        
        $data=$this->set_menu();
        $this->load->library('googlemaps');
        $config['center'] = '10.804305026919454, 76.11534118652344';
        $config['zoom'] = '8';
        $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $data['countries'] = $this->Channelpartner_model->get_countries();
        $data['designations']=$this->Executives_model->get_desigsviewall();
        $this->load->view('admin/exec-add',$data);
    }
    

    function update_executive($id){

        $data=$this->set_menu();
        $this->load->library('googlemaps');
        $config['center'] = '10.804305026919454, 76.11534118652344';
        $config['zoom'] = '8';
        $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $data['countries'] = $this->Channelpartner_model->get_countries();
        $data['designations']=$this->Executives_model->get_desigsviewall();
        $data['executives']=$this->Executives_model->get_executives_id($id);
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
    
    function delete_exectives()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->Executives_model->delete_exectives($this->input->post());
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

    function password_check($str)
    {
        if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
          return TRUE;
        }
       return FALSE;
    }

//team leader add executive
    function tm_add_executive(){

        if (has_priv('manage_bde_des')) {
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data=$this->set_menu();
        $data['countries'] = $this->Home_model->get_countries();
        $data['low'] = $this->Executives_model->get_low_sort();
        //print_r($data['low']);exit();
        $data['designations']=$this->Executives_model->get_desigsviewall();
        $this->load->view('executive/exec_add',$data);
    }
    }
    function new_executive(){
        if($this->input->is_ajax_request()){
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $desig=$loginsession['desig'];
            $check_count = $this->Executives_model->check_count($desig,$lgid);


            if($check_count['bde_limit']>$check_count['bde_count']){
                $this->form_validation->set_rules('ename', 'Name', 'required|trim');
                $this->form_validation->set_rules('mob', 'Mobile', 'required|min_length[7]|max_length[12]|trim|numeric');
                if($this->form_validation->run()==TRUE)
                {
                        $email = $this->input->post('email');
                        $mobile = $this->input->post('mob');
                      
                        $validate_email= $this->Home_model->validate_email($email);
                        $validate_phone= $this->Home_model->validate_phone($mobile);
                    if($validate_phone['status'] === TRUE){
                       if($validate_email['status'] === TRUE){
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
              
                                    $session_array = $this->session->userdata('logged_in_exec');
                                    $sid = $session_array['id'];
                                    $a  = '1';
                                    $a1 = $this->input->post('ename');
                                    $a2 = $this->input->post('dsig');
                                    $a3 = $this->input->post('email');
                                    $a4 = $this->input->post('mob');
                                    $a5 = $this->input->post('address');
                                    $a7 = $this->input->post('latt');
                                    $a8 = $this->input->post('long');
                                   
                                    $str = random_password(6);
                                    
                                   
                                    $date = date('Y-m-d');
                                    $data = array(  'sales_desig_type_id' => $a2,
                                                    'name' => $a1,
                                                    'parent_id' => $sid,
                                                    'created_by' => $sid,
                                                    'created_on' => $date,
                                                    'status' =>'NOT_APPROVED',
                                                    'last_promotion_date' =>$date );
                                    $data1 = array( 'name' => $a1,
                                                    'phone' => $a4,
                                                    'address' => $a5,
                                                    'email' =>$a3,
                                                    'country' =>$countryName,
                                                    'state' => $stateName,
                                                    'city' => $cityName,
                                                    'image' =>'default-avatar.png',
                                                    'status' => '1');
                                    $data3 = array( 'parent_login_id' =>$sid,
                                                    'email' => $a3,
                                                    'type' => 'executive',
                                                    'mobile' =>$a4);
                                 
                                    $result=$this->Executives_model->insert_execbasics($data,$data1,$data3);
                                    if($result)

                                        {
                                           // exit(json_encode(array('status'=>true)));
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
            }    
            else{
                 exit(json_encode(array('status'=>FALSE,'reason'=>'You Cross The Limit')));
                 
                }        
        }else{
            show_error("Unable To Process The Request In This Way");
        }

    }

    function tm_exec_view(){

        if (has_priv('manage_bde_des')) {
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data=$this->set_menu();
        $data['designations']=$this->Executives_model->get_desigsviewall();
        //$data['executives']=$this->Executives_model->get_executives();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $config = array();
        $config["base_url"] = base_url() . "tm_exec_view/";
        $result_count = $this->Executives_model->tm_get_executives_count($param,$lgid);
        //echo $result_count;exit();
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

        $data["data"] = $this->Executives_model->tm_get_executives($param,$config["per_page"], $page,$lgid);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    //print_r($data["data"]);exit();
        $this->load->view('executive/exec_view',$data);
    }
    }
    function tm_exec_reffered_view(){

        if (has_priv('manage_bde_des')) {
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data=$this->set_menu();
        $data['designations']=$this->Executives_model->get_desigsviewall();
        //$data['executives']=$this->Executives_model->get_executives();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $config = array();
        $config["base_url"] = base_url() . "tm_exec_view/";
        $result_count = $this->Executives_model->tm_get_executives_count_reffered($param,$lgid);
        //echo $result_count;exit();
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

        $data["data"] = $this->Executives_model->tm_get_executives_refferd($param,$config["per_page"], $page,$lgid);
        //print_r($data["data"]);exit();
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
    //print_r($data["data"]);exit();
        $this->load->view('executive/view_exec_refer',$data);
    }
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

                $session_array = $this->session->userdata('logged_in_exec');
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
        $result=$this->Executives_model->edit_execbasics($data,$data1);
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
    function tm_update_executive($id){

        $data=$this->set_menu();

        $data['countries'] = $this->Home_model->get_countries();
        $data['designations']=$this->Executives_model->get_desigsviewall();
        $data['executives']=$this->Executives_model->get_executives_id($id);
        $country = $data['executives']['country'];

            if (!empty($country)) {
                $countryData = getCountry_byName($country);
                $country_id = $countryData['id'];
                $data['states'] = get_states_by_country($country_id);
            }
            $state = $data['executives']['state'];
            if (!empty($state)) {
                $stateData = getStatebyName($state);
                $state_id = $stateData['id'];
                $data['cities'] = get_city_by_state($state_id);
            }
        
        $this->load->view('executive/exec_edit',$data);
    }



// promotion setting


    function get_exec_to_data()
    {

        $data['result']=$this->Executives_model->get_exec_to_data();
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

/*        $a8 = $this->input->post('co2');
        $a9 = $this->input->post('am2');
        $a10 = $this->input->post('pd2');
        $a11 = $this->input->post('co3');
        $a12 = $this->input->post('am3');
        $a13 = $this->input->post('pd3');*/
        $date = date('Y-m-d');

        $club = 'club_membership';
        if($a3 == $club){
            $am='1';
             
        }
        else{
            $am = $a3;
        }
         
/*        if($a5 == ''){
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
        }*/
        
   
            $data = array(
            'designation_id' => $a2,
            'sysmodule_id' => $am,
            'promotion_designation'=>$a6,
/*          'promotion_count' => $a4,
            'promotion_amount' => $am1,
            'promotion_period' => $a7,
            'promotion_count2' => $a8,
            'promotion_amount2' => $am2,
            'promotion_period2' => $a10,
            'promotion_count3' => $a11,
            'promotion_amount3' => $am3,
            'promotion_period3' => $a13,*/
            'date' => $date);

          $result=$this->Executives_model->insert_setexec($data);
//        }
        if($result){
            exit(json_encode(array("status"=>TRUE)));
/*            echo "<script>alert('success')</script>";
            $data=$this->set_menu();
            $data['designations']=$this->Executives_model->get_desigsview();
            $this->load->view('admin/exec-promo-settings-select',$data);*/
        }else{
            exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
        }
    }

    function exec_sel(){
        $data=$this->set_menu();
        $data['designations']=$this->Executives_model->get_desigsview();
        //print_r($data['designations']);exit();
        $data['modules']=$this->Executives_model->get_modules();
        $data['module']=$this->Executives_model->get_module();
        $this->load->view('admin/exec-promo-settings-select',$data);
    }
    function exec_setadd(){
        $data=$this->set_menu();
        $data['designations1']=$this->Executives_model->get_desigsadd();
        $data['team_leader']=$this->Executives_model->get_team_leader();
        //print_r($data['designations1']);exit();
        $data['modules']=$this->Executives_model->get_modules();
        $data['module']=$this->Executives_model->get_module();
       
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
        $data=$this->Executives_model->get_promotion_view();   
        if($data){
            exit(json_encode(array('status'=>TRUE, 'data'=>$data)));
        } else{
            exit(json_encode(array('status'=>FALSE, 'reason'=> 'Databse Error')));
        } 
  
   }

    function view_notification(){
        $data=$this->set_menu();
        $data['notification_club']=$this->Executives_model->active_notification_club();
        $data['notification_channel']=$this->Executives_model->active_notification_channel();
        $data['reward_notification']=$this->Executives_model->reward_notification();
        $data['admin_notification']=$this->Executives_model->admin_notification();
        //print_r( $data['admin_notification']);exit();
        $this->load->view('executive/view_notification',$data);
    }
    function view_wallet(){
        $data=$this->set_menu();
        $data['wallet_details']=$this->Executives_model->get_mywallet_details();
        
        $this->load->view('executive/view_wallet',$data);
    }
    function my_promotion(){
        $data=$this->set_menu();
        //$data['designations']=$this->Executives_model->get_desigsview();
        $this->load->view('executive/view_my_promotion',$data);
    }

    function exec_pro_view(){
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        //echo $userid;exit();
        $data=$this->set_menu();
        $data['designations']=$this->Executives_model->get_desigsview();
       
        $data['my_designation']=$this->Executives_model->my_designation($userid);
     
        $data['my_count']=$this->Executives_model->my_count($lgid);
        $data['team_leader1']=$this->Home_model->get_team_leader_sortorder();
        $data['exec_count']=$this->Executives_model->exec_count($lgid,$userid);
        $data['my_period']=$this->Executives_model->my_period($userid);
        $data['module']=$this->Home_model->get_module();
        $data['my_status']=$this->Executives_model->my_status($lgid);
        $data['my_wallet']=$this->Executives_model->my_wallet($lgid);
        $this->load->view('executive/exec_pro_view',$data);
    }





    //Add ba form





    function ba_view()
    {
        $data=$this->set_menu();
        $data['viewba']=$this->Executives_model->get_baview();
        $this->load->view('admin/edit-view-ba',$data);
    }

    function get_ba_view_byid($id)
    {
      $data=$this->set_menu();
      $data['countries'] = $this->Executives_model->get_countries();
      $data['viewba']=$this->Executives_model->get_ba_view_byid($id);
      $country = $data['viewba']['country'];
     
                if (!empty($country)) {
                $countryData = getCountry_byName($country);
                //print_r($countryData);
                $country_id = $countryData['id'];
                $data['states'] = get_states_by_country($country_id);
            }
            $state = $data['viewba']['state'];
            if (!empty($state)) {
                $stateData = getStatebyName($state);
                $state_id = $stateData['id'];
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
                $result=$this->Executives_model->edit_ba_by_id($countryName,$stateName,$cityName);

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
    function refer_ba(){

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
                    $mail = $this->input->post('ba_email');
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
                $result=$this->Executives_model->edit_refer_ba_by_id($countryName,$stateName,$cityName);

                  if($result)
                            { 
                               
                              $data['id'] = $result['info']['user_id'];
                                $data['otp'] = $result['info']['otp'];
                                $email = "kavyababu19@gmail.com";
                                $mail_head = 'Message From Jaazzo';
                               
                                $status = send_custom_email($email, $mail_head, $mail, 'Sign Up -Jaazzo Store', $this->load->view('templates/public/mail/ba_sign_up', $data,TRUE));

                                if($status)
                                {
                                    exit(json_encode(array('status'=>true)));
                                }else{
                                    exit(json_encode(array("status"=>TRUE)));
                                }
                            }else{
                                exit(json_encode(array('status'=>false, 'reason'=>'Database Error')));
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


//executive_add_ba
    function exec_add_ba()
    {
        if (has_priv('manage_ba_design')) {
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['member']=$this->Executives_model->get_active_club_member($lgid);
        //print_r($data['member']);exit();
        $data['countries'] = $this->Home_model->get_countries();
        $this->load->view('executive/edit_add_ba',$data);
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
            $result=$this->Executives_model->add_New_ba($countryName,$stateName,$cityName);


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
/*    function exec_view_ba()
    {
        $data=$this->set_menu();
        $data['viewba']=$this->Executives_model->get_baview();
        $this->load->view('executive/edit_view_ba',$data);
    }*/

    function exec_view_ba(){

        if (has_priv('manage_ba_design')) {
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data=$this->set_menu();
        $data['viewba']=$this->Executives_model->get_exec_baview();
        //print_r($data['viewba']);exit();
        $this->load->view('executive/edit_view_ba',$data);
    }
     }


    function exec_reffered_ba(){
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data=$this->set_menu();
        $data['viewba']=$this->Executives_model->get_reffer_baview();
       $this->load->view('executive/reffered_view_ba',$data);
    }

    function exec_get_refer_ba_byid($id)
    {
      $data=$this->set_menu();
      $loginsession = $this->session->userdata('logged_in_exec');
      $userid=$loginsession['user_id'];
      $lgid=$loginsession['id'];
      $data['countries'] = $this->Executives_model->get_countries();
      $data['member']=$this->Executives_model->get_active_club_member($lgid);
      $data['viewba']=$this->Executives_model->get_ba_view_byid($id);
      //print_r($data['viewba']);exit();
      $country = $data['viewba']['country'];
     
                if (!empty($country)) {
               /* $countryData = getCountry_byName($country);
                //print_r($countryData);
                $country_id = $countryData['id'];*/
                $data['states'] = get_states_by_country($country);
            }
            $state = $data['viewba']['state'];
            if (!empty($state)) {
               /* $stateData = getStatebyName($state);
                $state_id = $stateData['id'];*/
                $data['cities'] = get_city_by_state($state);
            }
      //print_r( $data['viewba']);
      $this->load->view('executive/exec_refer_ba_edit',$data);
    }




    function exec_get_ba_view_byid($id)
    {
      $data=$this->set_menu();
      $data['countries'] = $this->Executives_model->get_countries();
      $data['viewba']=$this->Executives_model->get_ba_view_byid($id);
      $country = $data['viewba']['country'];
     
                if (!empty($country)) {
                $countryData = getCountry_byName($country);
                //print_r($countryData);
                $country_id = $countryData['id'];
                $data['states'] = get_states_by_country($country_id);
            }
            $state = $data['viewba']['state'];
            if (!empty($state)) {
                $stateData = getStatebyName($state);
                $state_id = $stateData['id'];
                $data['cities'] = get_city_by_state($state_id);
            }
      //print_r( $data['viewba']);
      $this->load->view('executive/exec_edit_ba_edit',$data);
    }


    function get_state_by_id($id)
    {

        $data = $this->Executives_model->get_state_by_country($id);
        if($data)
        {
            exit(json_encode(array('status'=>true,'data'=>$data)));
        }
        else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'invalid selection')));
        }
    }

function view_exec_transaction(){
        $data=$this->set_menu();
        $data['transaction']=$this->Executives_model->get_exec_transaction();
        $this->load->view('executive/view_transaction',$data);
}

    function delete_partnerbyid(){
        $result=$this->Executives_model->delete_partnerbyid($this->input->post());
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    function close_notification(){
        $result=$this->Executives_model->close_notification($this->input->post());
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
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
        }else {
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
        } else{
            return TRUE;
        }
    } 
    function update_cp_details(){
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
    function view_cp_details($id){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
      
        $data['member']=$this->Executives_model->get_active_club_member($lgid);

        $data['category']=$this->Home_model->get_cpcategory();
        $data['subcategory']=$this->Home_model->get_cpscategory();
        $data['countries'] = $this->Home_model->get_countries();
        $data['states'] = $this->Home_model->get_states();
        //$data['city'] = $this->Home_model->get_city();
        $data['modules'] = $this->Home_model->get_modules();
        $data['partner']= $this->Home_model->get_channerpartner_byid($id);
        $state_id=$data['partner']['partner']['state'];
        $data['cities'] = $this->Home_model->get_town_by_id($state_id);

        $club_id = $data['partner']['partner']['club_mem_id'];
        $data['cl_type']= $this->Executives_model->get_member_type($club_id);
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
        $this->load->view('executive/exec_view_cp',$data);
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
    function check_cp_limit_exceed($id){
        if($this->input->is_ajax_request()){
            $result=$this->Executives_model->check_cp_limit_exceed($id);
            if($result['status']){
                exit(json_encode(array("status"=>TRUE)));
            }else{
                exit(json_encode(array("status"=>FALSE,"reason"=>$result['msg'])));
            }
        }else{
            show_error("We are unable to process this request on this way!");   
        }
    }
    function check_cp_limit_status(){
        if($this->input->is_ajax_request()){
            $id = $this->input->post('club_member');
            $type = $this->input->post('club_type');
            $result=$this->Executives_model->check_cp_limit_status($id,$type);
            if($result['status']){
                exit(json_encode(array("status"=>TRUE)));
            }else{
                exit(json_encode(array("status"=>FALSE,"reason"=>$result['msg'])));
            }
        }else{
            show_error("We are unable to process this request on this way!");   
        }
    }
}
?>