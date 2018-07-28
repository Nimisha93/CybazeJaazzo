<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Clubmember extends CI_controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model(array('api/Executive_model','api/cm_model','api/Home_model'));
        $this->load->helper(array('string','date','form','file'));
        header("Access-Control-Request-Headers:*");
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: content-type, origin, accept, Authorization-key");
        header('Cache-control: no-cache');
        header("Connection: Keep-alive");

    }
    //be club member
    function add()
    {
        $this->form_validation->set_rules('package', 'Package', 'required|trim|htmlspecialchars');
        if($this->form_validation->run() === TRUE) {
            $api_key = get_api_key();
            if($api_key){
                $result = $this->cm_model->be_club_member($api_key);
                if($result)
                {
                    echo json_encode(array("error"=>false, 'message' => 'Ok'));
                }else{
                    echo json_encode(array("error"=>true, 'message' => 'Something went wrong'));
                }
            }else{
                echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
            }
        }else{
            echo json_encode(array('error'=>true,'message'=>strip_tags(validation_errors())));  
        }
    }
    //get club types
    function getAvailableClubTypes(){
        $id = $this->input->post('id');
        $data['club_types'] =$this->cm_model->getAvailableClubTypes($id);
        if(!empty($data))
        {
            echo json_encode(array("error"=>false, 'message' => "Available club types for this user", 'data' => $data));
        }else{
            echo json_encode(array("error"=>true, 'message' => "No club types"));
        }
    }
    //active friends
    function active_friends(){
        $api_key = get_api_key();
        if($api_key){
            $udetails = user_details_by_apikey($api_key);
            $login_id = $udetails['id'];
            $result = $this->Home_model->get_active_friends($login_id);
            $res = array('friends'=>$result);
            if($result)
            {
                echo json_encode(array("error"=>false, 'data' => $res,'message' => 'Success'));
            }else{
                echo json_encode(array("error"=>true, 'message' => 'No active friends found'));
            }
        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }
    //reffered Friends
    function refferd_friends(){
        $api_key = get_api_key();
        if($api_key){
            $udetails = user_details_by_apikey($api_key);
            $login_id = $udetails['id'];
            $result = $this->Home_model->get_reffered_friends($login_id);
            $res = array('friends'=>$result);
            if($result)
            {
                echo json_encode(array("error"=>false, 'data' => $res,'message' => 'Success'));
            }else{
                echo json_encode(array("error"=>true, 'message' => 'No reffered friends found'));
            }
        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }
    //add friend
    function add_friend(){
        $api_key = get_api_key();
        if($api_key){
            $this->form_validation->set_rules('name', 'Name', 'required|trim|htmlspecialchars');
            // $this->form_validation->set_rules('email', 'Email', 'required|valid_email|trim|htmlspecialchars');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|numeric|trim|htmlspecialchars');
            if($this->form_validation->run() === TRUE) {

                $udetails = user_details_by_apikey($api_key);
                $login_id = $udetails['id'];
                if($login_id){
                    $name = $this->input->post('name');
                    $mail = $this->input->post('email');
                    $mob = $this->input->post('mobile');

                    $result = $this->cm_model->refer_validation($mail,$mob);
                  
                    if($result == 'bothtrue')
                    {
                        $result1 = $this->cm_model->friend_exists($mob);
                        if($result1 == 'allok')
                        {
                            $result2 = $this->cm_model->add_friend($name,$mail,$mob,$login_id);
                            if($result2==TRUE)
                            { 

                                $message = "Hi, Welcome to Jaazzo.If you are interested with Jaazzo.Please continue with signup: http://jaazzo.cybase.in/jaazzo/friends_signup/".encrypt_decrypt('encrypt',$mob);
                                send_message($mob,$message);

                                exit(json_encode(array("error"=>false,'message' => 'Success')));
                            }elseif($result2==FALSE)
                            { 
                                $s=19;
                            }

                        }
                        elseif($result1 == '3')
                        { $s=23;
                        } 
                    }
                    elseif($result == 'mobfalse' )
                    { $s=36; 
                    }
                    if($s==19){ exit(json_encode(array('error'=> TRUE,"message"=>"Unsuccess"))); }
                    elseif($s==23){ exit(json_encode(array('error'=> TRUE,"message"=>"Mobile number already exist"))); }
                    elseif($s==36){ exit(json_encode(array('error'=> TRUE,"message"=>"Invalid Mobile Format"))); }    
                    else{ exit(json_encode(array('error'=> TRUE,"message"=>".$result.Hai.$s."))); }
                }else{
                    echo json_encode(array("error"=>true, 'message' => 'Invalid Api key'));
                }
            }else{
                echo json_encode(array('error'=>true,'message'=>strip_tags(validation_errors())));  
            }
        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }
    //get club packages
    function get_club_packages(){
        $this->form_validation->set_rules('type', 'Type', 'trim|htmlspecialchars');
        if($this->form_validation->run() === TRUE) {
            $type = $this->input->post('type')?$this->input->post('type'):'UNLIMITED';
            $data['club_packages']=$this->cm_model->get_club_packages($type);
            if(!empty($data))
            {
                echo json_encode(array("error"=>false, 'message' => "Club packgaes", 'data' => $data));
            }else{
                echo json_encode(array("error"=>true, 'message' => "No Club packgaes"));
            }
        }else{
            echo json_encode(array('error'=>true,'message'=>strip_tags(validation_errors())));  
        }
    }
    // Get club member by search
    function get_club_member_by_search(){
        $this->form_validation->set_rules('search_text', 'Search Keyword', 'required|trim|htmlspecialchars');
        $this->form_validation->set_rules('member_type', 'Member Type', 'required|trim|htmlspecialchars');
        if($this->form_validation->run() === TRUE) {
            $search = $this->input->post('search_text');
            $member_type = $this->input->post('member_type');
            $datas = array('search_text'=>$search,'member_type'=>$member_type);
            $result = $this->cm_model->get_club_member_by_search($datas);
            if($result)
            {
                echo json_encode(array("error"=>false, 'data' => array('members'=>$result),'message' => 'Club member suggestions'));
            }else{
                echo json_encode(array("error"=>true, 'message' => 'No results found'));
            }
        }else{
            echo json_encode(array('error'=>true,'message'=>strip_tags(validation_errors())));  
        }
    }
    //transfer rewards
    function transfer_rewards(){
        $api_key = get_api_key();
        if($api_key){
            $this->form_validation->set_rules('wallet_type', 'Wallet Type', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('amount', 'Amount', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|numeric|trim|htmlspecialchars');
            $this->form_validation->set_rules('target_user_id', 'Target User Id', 'required|numeric|trim|htmlspecialchars');
            
            if($this->form_validation->run() === TRUE) {

                $udetails = user_details_by_apikey($api_key);
                $login_id = $udetails['id'];
                if($login_id){
                    $wallet = $this->input->post('wallet_type');
                    $wallet = $this->input->post('wallet_type');
                    if($wallet == "CLUB_WALLET"){
                        $wallet = 1;
                    }else if($wallet == "REWARD_WALLET"){
                        $wallet = 2;
                    }else if($wallet == "MY_WALLET"){
                        $wallet = 4;
                    }else if($wallet == "INCENTIVE_WALLET"){
                        $wallet = 3;
                    }
                   
                    $amount = $this->input->post('amount');
                    $mobile_number = $this->input->post('mobile');
                    $valid_phone = $this->cm_model->transfer_phone_exist($mobile_number);
                    if($valid_phone==TRUE){
                        $userid=$valid_phone['id'];
                        $wallet_res = $this->cm_model->transfer_amount($userid,$amount,$login_id,$wallet);
                        if($wallet_res['status']==TRUE){
                            // $res = $this->cm_model->get_my_wallet($login_id);
                            exit(json_encode(array("error"=>false,"data"=>array(),"message"=>"Successfully transfered")));
                        }else{
                            exit(json_encode(array("error"=>true,"message"=>$wallet_res['reason'])));
                        }                 
                    }else{  
                        exit(json_encode(array("error"=>true,"message"=>"Mobile doesnt exist")));
                    }       
                }else{
                    echo json_encode(array("error"=>true, 'message' => 'Invalid Api key'));
                }
            }else{
                echo json_encode(array('error'=>true,'message'=>strip_tags(validation_errors())));  
            }
        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }
    //update profile
    function update_profile(){
        $api_key = get_api_key();
        if($api_key){
            
            $this->form_validation->set_rules('first_name', 'First Name', 'required|trim|htmlspecialchars');
           
            if($this->form_validation->run() === TRUE) {

                $udetails = user_details_by_apikey($api_key);
                $login_id = $udetails['id'];
                $user_id = $udetails['user_id']; 
                if($login_id){
                    $type = $udetails['type'];
                    $res = $this->cm_model->update_profile($login_id,$user_id,$type);
                    if($res){
                        echo json_encode(array("error"=>false, 'message' => 'Success'));
                    }else{
                        echo json_encode(array("error"=>true, 'message' => 'Something went wrong'));
                    } 
                }else{
                    echo json_encode(array("error"=>true, 'message' => 'Invalid Api key'));
                }
            }else{
                echo json_encode(array('error'=>true,'message'=> strip_tags(validation_errors()) ));  
            }
        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }
    //update profile image
    function update_image(){
        $api_key = get_api_key();
        if($api_key){
            if (!empty($_FILES['image']['name']))
            {
                $this->load->library('upload');
                $udetails = user_details_by_apikey($api_key);
                $login_id = $udetails['id'];
                $user_id = $udetails['user_id']; 
                if($login_id){
                    $type = $udetails['type'];
                    // $data=array();
                    $files = $_FILES;
                    $_FILES['image']['name']= $files['image']['name'];
                    $_FILES['image']['type']= $files['image']['type'];
                    $_FILES['image']['tmp_name']= $files['image']['tmp_name'];
                    $_FILES['image']['error']= $files['image']['error'];
                    $_FILES['image']['size']= $files['image']['size'];

                    $this->upload->initialize($this->set_upload_options($type));
                    $upload_img= $this->upload->do_upload('image');
                     if(!$upload_img){
                        exit(json_encode(array('error'=>true, 'message'=>$this->upload->display_errors())));
                    } else{
                        $fileName = $_FILES['image']['name'];
                        $image = $fileName;
                    }
                    $data =array('id'=>$user_id,'type'=>$type,'image'=>$image);
                    $res = $this->cm_model->update_profile_image($data);
                    if($res){
                        echo json_encode(array("error"=>false, 'message' => 'Success'));
                    }else{
                        echo json_encode(array("error"=>true, 'message' => 'Something went wrong'));
                    } 
                }else{
                    echo json_encode(array("error"=>true, 'message' => 'Invalid Api key'));
                }
            }else{
                echo json_encode(array("error"=>true, 'message' => 'Please select a image'));
            }
            /*if($this->form_validation->run() === TRUE) {
                echo "stcccccccring";*/

                
            /*}else{
                echo "string";*/
                // echo json_encode(array('error'=>true,'message'=>validation_errors()));  
            // }
        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }
    private function set_upload_options($type)
    {
        //upload an image options
        $config = array();
        $path = ($type=='executive')?'./upload/exec_profile':'./uploads/';
        $config['upload_path'] = $path;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['overwrite']     = FALSE;
        return $config;
    }
     function refer_cp(){
        $api_key = get_api_key();
        if($api_key){
            $this->form_validation->set_rules('club_type', 'Club Type', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('name', 'Channel Name', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('email', 'Channel Email', 'trim|valid_email|htmlspecialchars|is_unique[gp_pl_channel_partner.email]');
            $this->form_validation->set_rules('phone', 'Phone', 'required|trim|numeric|is_unique[gp_pl_channel_partner.phone]');
            $this->form_validation->set_rules('owner_name', 'Owner Name', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('owner_email', 'Owner Email', 'required|trim|valid_email|htmlspecialchars');
            $this->form_validation->set_rules('owner_mobile', 'Owner Mobile', 'required|trim|numeric');
            $this->form_validation->set_rules('area', 'Area', 'required|trim');
            if ($this->form_validation->run() === TRUE) {
                $data = array();
                $usr_data=user_details_by_apikey($api_key);
                $id = $usr_data['id'];
                $data['id'] = $id;

                if(!empty($id)){
                    $type = $this->input->post('club_type');
                    $check_fixed_limit = $this->Executive_model->check_fixed_usage($id,$type);
                    if($check_fixed_limit['status']===false){
                        echo json_encode(array("error"=>true,"message"=>$check_fixed_limit['msg']));
                        exit();
                    }
                    $result=$this->cm_model->refer_channel_partner($data);
                    if($result){
                        echo json_encode(array("error"=>false,'message'=>"Your reference has been added.",'data'=>''));
                    }
                    else{
                        echo json_encode(array("error"=>true,"message"=>"Database Error"));
                    }
                 }else{
                     echo json_encode(array("error"=>true, 'message' => "Invalid User"));
                 }   
            }
            else{
                echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
            }

        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }
    function get_refered_cp(){
        $api_key = get_api_key();
        if($api_key){
            $data = array();
            $usr_data=user_details_by_apikey($api_key);
            $id = $usr_data['id'];
            $data['id'] = $id;
            if(!empty($id)){
                $result=$this->cm_model->get_refered_channel_partners($id);
                if($result){
                    echo json_encode(array("error"=>false,'message'=>"Your reference",'data'=>$result));
                }
                else{
                    echo json_encode(array("error"=>true,"message"=>"Database Error"));
                }
             }else{
                 echo json_encode(array("error"=>true, 'message' => "Invalid User"));
             }  
        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }
    function remove_referred_channel_partner(){
        $api_key = get_api_key();
        if($api_key){
            $this->form_validation->set_rules('channel_id', 'Channel Id', 'required|trim|numeric');
            if ($this->form_validation->run() === TRUE) {
                $data = array();
                $usr_data=user_details_by_apikey($api_key);
                $id = $usr_data['id'];
                $data['channel_id'] = $this->input->post('channel_id');
                $data['id'] = $id;

                if(!empty($id)){
                    $result=$this->cm_model->remove_refered_channel_partner($data);
                    if($result['status']){
                        echo json_encode(array("error"=>false,'message'=>'This is a sample success message'));
                    }else{
                        echo json_encode(array("error"=>true,"message"=>$result['message']));
                    }
                 }else{
                     echo json_encode(array("error"=>true, 'message' => "Invalid User"));
                 }   
            }
            else{
                echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
            }

        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }
    function update_referred_friend(){
        $api_key = get_api_key();
        if($api_key){
            $this->form_validation->set_rules('id', 'Id', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('name', 'Name', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim|numeric');
            if ($this->form_validation->run() === TRUE) {
                $data = array();
                $usr_data=user_details_by_apikey($api_key);
                $id = $usr_data['id'];

                if(!empty($id)){
                    $mobile = $this->input->post('mobile');
                    $email = $this->input->post('email');
                    $friend_id = $this->input->post('id');

                        $mobExist = $this->cm_model->chk_mobile_exist($mobile,$friend_id);

                        if(!$mobExist){
                            exit(json_encode(array("error"=>true,"message"=>"Phone no already exist")));
                        }
                        if($email){

                            $mailExist = $this->cm_model->chk_mail_exist($email,$friend_id);
                            if(!$mailExist){
                                exit(json_encode(array("error"=>true,"message"=>"Email already exist")));
                            }
                        }
                    $valid= $this->cm_model->chk_valida_friend($id,$friend_id);
                    if($valid){    
                        $result=$this->cm_model->update_referred_friend($friend_id);
                        if($result){
                            echo json_encode(array("error"=>false,'message'=>"Your reference has been updated.",'data'=>new stdClass()));
                        }else{
                            echo json_encode(array("error"=>true,"message"=>"Database Error"));
                        }
                    }else{
                        exit(json_encode(array("error"=>TRUE,"message"=>"Invalid friend id")));
                    }
                }else{
                    echo json_encode(array("error"=>true, 'message' => "Invalid User"));
                }   
            }
            else{
                echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
            }

        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }
    function delete_referred_friend(){
        $api_key = get_api_key();
        if($api_key){
            $this->form_validation->set_rules('friend_id', 'Friend Id', 'required|trim|numeric');
            if ($this->form_validation->run() === TRUE) {
                $data = array();
                $usr_data=user_details_by_apikey($api_key);
                $id = $usr_data['id'];
                $data['friend_id'] = $this->input->post('friend_id');
                $data['id'] = $id;

                if(!empty($id)){
                    $result=$this->cm_model->remove_refered_friend($data);
                    if($result['status']){
                        echo json_encode(array("error"=>false,'message'=>'Your reference has been deleted.'));
                    }else{
                        echo json_encode(array("error"=>true,"message"=>$result['message']));
                    }
                 }else{
                     echo json_encode(array("error"=>true, 'message' => "Invalid User"));
                 }   
            }
            else{
                echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
            }

        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }
    function upgrade_club_membership(){
        $api_key = get_api_key();
        if($api_key){
            $this->form_validation->set_rules('club_id', 'Club Id', 'required|trim|numeric');
            if ($this->form_validation->run() === TRUE) {
                $data = array();
                $usr_data=user_details_by_apikey($api_key);
                $id = $usr_data['user_id'];
                $data['club_id'] = $this->input->post('club_id');
                $data['type'] = $this->input->post('type');
                $data['id'] = $id;
                $data['log_id']=$usr_data['id'];

                if(!empty($id)){
                    $result=$this->cm_model->upgrade_club_membership($data);
                    if($result){
                        echo json_encode(array("error"=>false,'message'=>'Club membership upgraded successfully','data'=>new stdClass()));
                    }else{
                        echo json_encode(array("error"=>true,"message"=>'Something went wrong'));
                    }
                }else{
                    echo json_encode(array("error"=>true, 'message' => "Invalid User"));
                }   
            }else{
                echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
            }

        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }
    function check_cp_facility(){
        $api_key = get_api_key();
        if($api_key){
            $this->form_validation->set_rules('member_id', 'Member Id', 'required|trim|numeric');
            if ($this->form_validation->run() === TRUE) {
                $data = array();
                $usr_data=user_details_by_apikey($api_key);
                $type = $usr_data['type'];
                $id = $usr_data['id'];
                $data['member_id'] = $this->input->post('member_id');
                $data['id'] = $id;
                $data['type'] = $type;
                if(!empty($id)){
                    $result=$this->cm_model->check_cp_facility($data);
                    if($result['status']){
                        echo json_encode(array("error"=>false,'message'=>'','data'=>$result['data']));
                    }else{
                        echo json_encode(array("error"=>true,"message"=>$result['msg']));
                    }
                 }else{
                     echo json_encode(array("error"=>true, 'message' => "Invalid User"));
                 }   
            }
            else{
                echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
            }

        }else{
            echo json_encode(array("error"=>true, 'message' => "Api key Missing"));
        }
    }
}
?>