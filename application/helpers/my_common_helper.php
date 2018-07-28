<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


    function round_number( $NUM,$POS = 2 )
    {
        //return number_format((float)$NUM, $POS, '.', '');
        return number_format((int)$NUM,$POS, '.', ''); 


    }
    function round_number_no_decimal( $NUM,$POS = 0 )
    {
        //return number_format((float)$NUM, $POS, '.', '');
        return number_format((int)$NUM,$POS, '.', ''); 


    }
    function send_custom_email($from, $mail_head, $to, $subject, $email_message)
    {
        $ci =& get_instance();
        $ci->load->database();
        $ci->load->library('email');
        
        $config['protocol'] = "smtp";
        $config['smtp_host'] = "ssl://smtp.googlemail.com";
        $config['smtp_port'] = "465";
        $config['smtp_user'] = 'techcybaze@gmail.com';
        $config['smtp_pass'] = 'cyb@ze-7';
        $config['charset'] = "iso-8859-1";
        $config['mailtype'] = "html";
        $config['newline'] = "\r\n";

        $ci->email->initialize($config);
        $ci->email->from($from, $mail_head);
        $ci->email->to($to);
        $ci->email->reply_to('no-replay@gmail.com', 'OTP Verification');
        $ci->email->subject($subject);
        $ci->email->message($email_message);
        $send = $ci->email->send();
        if($send == TRUE)
        {
            return TRUE;
        } else{
            return FALSE;
        }
    }
    function send_message($mobile,$message){
        $username="cybaze";
        $api_password="f8386zw7u5mdz5dws";
        $sender="JAAZZO";
        $domain="webqua.net";
        $priority="11";// 11-Enterprise, 12- Scrub
        $method="POST";

        $username=urlencode($username);
        // $password=urlencode($password);
       //var_dump($mobile);var_dump($message);exit;
        $sender=urlencode($sender);
        $message=urlencode($message);

        $parameters="username=$username&api_password=$api_password&sender=$sender&to=$mobile&message=$message&priority=$priority";

        $url="http://$domain/pushsms.php";

        $ch = curl_init($url);

        if($method=="POST")
        {
            curl_setopt($ch, CURLOPT_POST,1);
            curl_setopt($ch, CURLOPT_POSTFIELDS,$parameters);
        }
        else
        {
            $get_url=$url."?".$parameters;

            curl_setopt($ch, CURLOPT_POST,0);
            curl_setopt($ch, CURLOPT_URL, $get_url);
        }

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION,1); 
        curl_setopt($ch, CURLOPT_HEADER,0);  // DO NOT RETURN HTTP HEADERS 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);  // RETURN THE CONTENTS OF THE CALL
        
        $return_val = curl_exec($ch);

    } 
    function activity_log($action,$userid,$status,$date){
        $date = date('m/d/Y h:i:s', time());
        $ci =& get_instance();
             //load databse library
             $ci->load->database();
             $ci->load->library('session');
           $insert = array('action' => $action,
            'user_id'=> $userid,
            'status_' => $status,'date'=>$date

            );
           
           $qry = $ci->db->insert('gp_activity_log',$insert);
        return $qry;
    }
    function get_execuitive_details()
    {
        $ci =& get_instance();
        $ci->load->library('session');
        $sesson_array =  $ci->session->userdata('logged_in_admin');
        $lgid = $sesson_array['id'];
        $userid = $sesson_array['user_id'];
        $qry = "select * from gp_pl_sales_team_members m where m.id = '$userid'";
        $query = $ci->db->query($qry);
        if($query->num_rows()>0)
        {
            return $query->row_array();
        } else{
            return array();
        }
    }


function safe_b64encode($string)
{
    $data = base64_encode($string);
    $data = str_replace(array('+', '/', '='), array('-', '_', ''), $data);
    return $data;
}

function safe_b64decode($string)
{
    $data = str_replace(array('-', '_'), array('+', '/'), $string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    return base64_decode($data);
}

function encrypt_decrypt_forgot($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'j@@zz00@cybaze01';
        $secret_iv = 'This is my secret iv';
        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
           
            $output = safe_b64encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(safe_b64decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
    function encrypt_decrypt($action, $string) {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = 'j@@zz00@cybaze01';
        $secret_iv = 'This is my secret iv';
        // hash
        $key = hash('sha256', $secret_key);
        
        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ( $action == 'encrypt' ) {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if( $action == 'decrypt' ) {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }
    function random_password($length = 6) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }
    /*erp starts here*/
function get_countries()
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $qry = $ci->db->get('countries');
    if ($qry->num_rows() > 0) {
        return $qry->result_array();
    } else {
        return array();
    }
}

function get_countryName_by_id($country_id)
{
   
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->where('id', $country_id);
    $ci->db->select('*');
    $qry = $ci->db->get('countries');
    
    if ($qry->num_rows() > 0) {
        return $qry->row_array();
    } else {
        return array();
    }
}
function get_new_purchase_count()
{
    $ci =& get_instance();
    $ci->load->database();
    $count = $ci->db->where('status',0)->where('type','indirect')->select('count(id) as count')->get('gp_purchase_bill_notification')->row('count');
    //echo $ci->db->last_query();exit();
   // var_dump($count);exit;
    if ($count) {
        return $count;
    } else {
        return 0;
    }
}
function random_select($where,$select,$table,$type)
{   
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->where($where);
    $ci->db->select($select);
    $qry = $ci->db->get($table);
    if ($qry->num_rows() > 0) {
        return $qry->$type();
    } else {
        return array();
    }
}

function get_states_by_country($country_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->where('country_id', $country_id);
    $qry = $ci->db->get('states');

    if ($qry->num_rows() > 0) {
        return $qry->result_array();
    } else {
        return array();
    }
}

function getCountry_byName($countryName)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->where('name', $countryName);
    $ci->db->select('*');
    $qry = $ci->db->get('countries');
    if ($qry->num_rows() > 0) {
        return $qry->row_array();
    } else {
        return array();
    }
}

function get_stateName_by_id($state_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->where('id', $state_id);
    $qry = $ci->db->get('states');

    if ($qry->num_rows() > 0) {
        return $qry->row_array();
    } else {
        return array();
    }
}

function convert_to_mysql($date)
{

    $mysql_date = date('Y-m-d', strtotime($date));
    return $mysql_date;
}


function convert_ui_date($date)
{

    $ui_date = date('d-m-Y', strtotime($date));
    return $ui_date;
}
function get_current_financial_year()
{
    $ci =& get_instance();
    $ci->load->database();
    $qry = "SELECT * FROM financial_year fy WHERE fy.id_current = 1";
    $qry = $ci->db->query($qry);
    if ($qry->num_rows() > 0) {
        return $qry->row_array();
    } else {
        return array();
    }
}

function get_number()
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select_max('number');
    $result = $ci->db->get('erp_ac_entries');
    if($result->num_rows()>0)
    {
        $res = $result->row();
        $res =$res->number;
        $ret_res = $res+1;
    }else{
        $ret_res = 1000;
    }
    return $ret_res;
}

function getStatebyName($state)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->where('name', $state);
    $qry = $ci->db->get('states');
    if ($qry->num_rows() > 0) {
        return $qry->row_array();
    } else {
        return array();
    }
}

function get_city_by_state($state_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->where('state_id', $state_id);
    $qry = $ci->db->get('cities');

    if ($qry->num_rows() > 0) {
        return $qry->result_array();
    } else {
        return array();
    }
}

function get_cityName_by_id($state_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $ci->db->where('id', $state_id);
    $qry = $ci->db->get('cities');
    if ($qry->num_rows() > 0) {
        return $qry->row_array();
    } else {
        return array();
    }
}
function get_commission()
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->select('*');
    $qry = $ci->db->get('gp_pl_commission');
    if ($qry->num_rows() > 0) {
        return $qry->row_array();
    } else {
        return array();
    }
}
function get_notification_count($login_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->where("n.is_read = '0' and n.is_del = '0' and n.login_id = '$login_id'");
    $ci->db->select('count(n.id) as noti_count');

    $qry = $ci->db->get('admin_notifications n');
    if ($qry->num_rows() > 0) {
        return $qry->row();
    } else {
        return array();
    }
}

function get_all_club_members()
{
    $data =array();
    $ci =& get_instance();
    $ci->load->database();
    $qry = "SELECT nc.name,lt.id,mt.title as plan,mt.club_agent_status,mt.ca_limit FROM `gp_normal_customer` nc 
    left join gp_login_table lt ON lt.user_id = nc.id  
    left JOIN club_member_type mt ON nc.club_type_id=mt.id 
    WHERE nc.club_type_id!='0' AND lt.type='club_member'";
    $query = $ci->db->query($qry);
    if($query->num_rows()>0)
    {
        $cm_details = $query->result_array();
        foreach ($cm_details as $key => $value) {
            $uid = $value['id'];
                array_push($data,array('id'=>$value['id'],'name'=>$value['name']));   
        }
        return $data;
    } else{
        return array();
    }
}
function get_all_clubmembers()
{
    $data =array();
    $ci =& get_instance();
    $ci->load->database();
    $qry = "SELECT nc.name,lt.id,mt.title as plan,mt.club_agent_status,mt.ca_limit FROM `gp_normal_customer` nc 
    left join gp_login_table lt ON lt.user_id = nc.id  
    left JOIN club_member_type mt ON nc.club_type_id=mt.id 
    WHERE nc.club_type_id>='0' AND nc.fixed_club_type_id='0' AND lt.type='club_member'";
    $query = $ci->db->query($qry);
    if($query->num_rows()>0)
    {
        $cm_details = $query->result_array();
        foreach ($cm_details as $key => $value) {
            $uid = $value['id'];
                array_push($data,array('id'=>$value['id'],'name'=>$value['name']));   
        }
        return $data;
    } else{
        return array();
    }
}
function club_agent_facilty_bycm($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $data = array();
    $qry = "SELECT nc.name,nc.id,mt.title as plan,mt.club_agent_status,mt.ca_limit FROM `gp_normal_customer` nc 
    left join gp_login_table lt ON lt.user_id = nc.id  
    left JOIN club_member_type mt ON nc.club_type_id=mt.id 
    WHERE lt.id='$id' AND nc.club_type_id!='0' AND lt.type='club_member'";
    $query = $ci->db->query($qry);
    if($query->num_rows()>0)
    {
        $cm_details =  $query->row_array();
        if($cm_details['club_agent_status'])
        {
            $uid = $cm_details['id'];
            $sql = "SELECT nc.* FROM `gp_normal_customer` nc 
            left join gp_login_table lt ON lt.user_id = nc.id  
            WHERE nc.mem_id='$uid' AND lt.type='club_agent'";
            $sqll = $ci->db->query($sql);
            if($sqll->num_rows()>0)
            {
                $data['ca_details'] =  $sqll->result_array();
                $data['ca_limit'] = $cm_details['ca_limit'];
                $data['ca_count'] = $sqll->num_rows();
                return $data;
            }else{
                $data['ca_limit'] = $cm_details['ca_limit'];
                $data['ca_count'] = 0;
                return $data;
            }
        }
    } else{
        return array();
    }
}
function getLoginId()
{
    $data = array();
    $ci =& get_instance();
    $session_array1 = $ci->session->userdata('logged_in_user');
    $session_array2 = $ci->session->userdata('logged_in_club_member');
    $session_array3 = $ci->session->userdata('logged_in_club_agent');
    
    if(isset($session_array1)){
        $data['type'] = $session_array1['type'];
        $data['login_id'] = $session_array1['id'];
        $data['user_id'] = $session_array1['user_id'];
        $data['email'] = $session_array1['email'];
        $data['club_type_id'] = $session_array1['club_type_id'];    
    }
    if(isset($session_array2)){
        $data['type'] = $session_array2['type'];
        $data['login_id'] = $session_array2['id'];
        $data['user_id'] = $session_array2['user_id'];
        $data['club_type_id'] = $session_array2['club_type_id'];
        $data['fixed_club_type_id']= $session_array2['fixed_club_type_id'];
        $data['investor_type_id']= $session_array2['investor_type_id'];
        $data['type'] = $session_array2['type'];
        $data['email'] = $session_array2['email'];  
    }
    if(isset($session_array3)){
        $data['type'] = $session_array3['type'];
        $data['login_id'] = $session_array3['id'];
        $data['user_id'] = $session_array3['user_id'];
        $data['club_type_id'] = $session_array3['club_type_id'];
        $data['email'] = $session_array3['email'];
    }
    return $data;
}
function generate_coupon()
{
    $ci =& get_instance();
    $ci->load->database();
    $sql = "SELECT c.coupon_code FROM `coupon` c ORDER BY `id` DESC LIMIT 1";
    $result = $ci->db->query($sql);
  
    if ($result->num_rows() > 0) {
        $results = $result->row();
        $coupon = $results->coupon_code + 1;
    } else {
        $coupon = 1000;
    }
    return $coupon;
}
function getCpLoginId()
{
    $data = array();
    $ci =& get_instance();
    $session_array = $ci->session->userdata('logged_in_cp'); 
    if(isset($session_array)){
        $data['type'] = $session_array['type'];
        $data['login_id'] = $session_array['id'];
        $data['user_id'] = $session_array['user_id']; 
    }
    
    return $data;
}
function getLoginDetails()
{
    $data = array();
    $ci =& get_instance();
    $session_array1 = $ci->session->userdata('logged_in_admin');
    $session_array2 = $ci->session->userdata('logged_in_cp'); 
    $session_array3 = $ci->session->userdata('logged_in_exec'); 
    if(isset($session_array1)){
        $data['type'] = $session_array1['type'];
        $data['id'] = $session_array1['id'];
        $data['user_id'] = $session_array1['user_id'];
        $data['desig'] = 0;  
    }
    if(isset($session_array2)){
        $data['type'] = $session_array2['type'];
        $data['id'] = $session_array2['id'];
        $data['user_id'] = $session_array2['user_id']; 
        $data['desig'] = $session_array2['desig'];  

    }
    if(isset($session_array3)){
        $data['type'] = $session_array3['type'];
        $data['id'] = $session_array3['id'];
        $data['user_id'] = $session_array3['user_id']; 
        $data['desig'] = $session_array3['desig'];  
                // $data['desig'] = $session_array3['desig'];  

    }
    return $data;
}
function getWallet()
{
    $data =array();
    $ci =& get_instance();
    $ci->load->database();
    $data = getLoginId();
    $type=$data['type'];
    if($type=='club_member'){

    $qry= "select a.id as reward_id,
       b.id as mywallt_id,
       c.id as club_id,
       a.title as reward_name,
       b.title as mywallet_name,
       c.title as club_name
       from gp_wallet_types a
       join gp_wallet_types b
       join gp_wallet_types c
       where a.id = 2
       and b.id = 4
       and c.id = 1";
    }else{
    $qry= "select a.id as reward_id,
       b.id as mywallt_id,
       a.title as reward_name,
       b.title as mywallet_name
       from gp_wallet_types a
       join gp_wallet_types b
       where a.id = 2
       and b.id = 4";
    }
    $query=$ci->db->query($qry);
    if($query->num_rows()>0)
    {
        return $query->row_array();
    }else{
        return array();
    }
}
function get_my_club_members($id)
{
    $ci =& get_instance();
    $ci->load->database(); 
    $qry = "select *
        from
        gp_normal_customer nc
        where nc.created_by='$id' or nc.mem_id='$id'";
      $qry = $ci->db->query($qry);
      if($qry->num_rows()>0)
      {
        return $qry->result_array();
      } else{
        return array();
      } 
}
//To generate slug
function slugify($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '_', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '_');

  // remove duplicate -
  $text = preg_replace('~-+~', '_', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n_a';
  }

  return $text;
}
//To get all designations
function get_all_desigination()
{
    $ci =& get_instance();
    $ci->load->database();
    $qry="select gp_des.id,gp_des.designation,gp_des.type,gp_des.description,gp_des.sort_order,gp_des.group_id,gp_gpname.group from gp_pl_sales_designation_type gp_des 
             left join gp_privillage_groupname gp_gpname on gp_des.group_id=gp_gpname.id where gp_des.is_del !='1'";
    $result= $ci->db->query($qry);

    if($result->num_rows()>0)
    {
        return $result->result_array();
    }else{
        return array();
    }
}
function get_cm_facility_by_id($id)
{

    $ci =& get_instance();
    $ci->load->database();
    $data = array();
      $qry = "SELECT nc.name,nc.id as user_id,nc.club_type_id,nc.fixed_club_type_id,lt.id as login_id,mt.title as plan,mt.club_agent_status,mt.ca_limit,mt.cp_status,mt.cp_limit,mt.user_status,mt.user_limit ,mt.ba_status,mt.ba_limit FROM `gp_normal_customer` nc 
    left join gp_login_table lt ON lt.user_id = nc.id  
    left JOIN club_member_type mt ON nc.club_type_id=mt.id 
    WHERE lt.id='$id' AND  lt.type='club_member'";
    $query = $ci->db->query($qry);
    if($query->num_rows()>0)
    {
        $cm_details =  $query->row_array();
        $login_id = $id;
        $fixed = $cm_details['fixed_club_type_id'];
        if($fixed)
        {
           $qry2 = "SELECT nc.name,nc.id as user_id,nc.club_type_id,nc.fixed_club_type_id,lt.id as login_id,mt.title as plan,mt.cp_status,mt.cp_limit,mt.reward_per_cp ,mt.bde_benefit FROM `gp_normal_customer` nc 
            left join gp_login_table lt ON lt.user_id = nc.id  
            left JOIN club_member_type mt ON nc.fixed_club_type_id=mt.id 
            WHERE lt.id='$id' AND  lt.type='club_member'";
            $query2 = $ci->db->query($qry2);
            if($query2->num_rows()>0)
            {
                $details =  $query2->row_array();
                $data['cp_limit'] = $details['cp_limit'];
            }
        }
        if($cm_details['club_agent_status'])
        {
            $sql1 = "SELECT * FROM `gp_login_table` where type='club_agent' and parent_login_id='$login_id' ORDER BY `id`  DESC";
            $sqll1 = $ci->db->query($sql1);
            if($sqll1->num_rows()>0)
            {
                $data['ca_details'] =  $sqll1->result_array();
                $data['ca_limit'] = $cm_details['ca_limit'];
                $data['ca_count'] = $sqll1->num_rows();
            }else{
                $data['ca_details'] = array();
                $data['ca_limit'] = $cm_details['ca_limit'];
                $data['ca_count'] = 0;
            }
        }else{
                $data['ca_details'] = array();
                $data['ca_limit'] = 0;
                $data['ca_count'] = 0;
        }

        if($cm_details['cp_status'])
        {
            $sql2 = "SELECT * FROM `gp_pl_channel_partner` where club_type='FIXED' and club_mem_id='$login_id' ORDER BY `id`  DESC";
            $sqll2 = $ci->db->query($sql2);
            if($sqll2->num_rows()>0)
            {
                $data['cp_details'] =  $sqll2->result_array();

                $data['cp_limit'] = $cm_details['cp_limit'];
                $data['cp_count'] = $sqll2->num_rows();
            }else{
                $data['cp_details'] = array();

                $data['cp_limit'] = $cm_details['cp_limit'];

                $data['cp_count'] = 0;
            }
        }else{
                $data['cp_details'] = array();
                $data['cp_limit'] = 0;
                $data['cp_count'] = 0;
        }
        if($cm_details['user_status'])
        {
            $sql3 = "SELECT * FROM `gp_user_referrel` where created_by='$login_id' ORDER BY `id`  DESC";
            $sqll3 = $ci->db->query($sql3);
            if($sqll3->num_rows()>0)
            {
                $data['frnd_details'] =  $sqll3->result_array();
                $data['frnd_limit'] = $cm_details['user_limit'];
                $data['frnd_count'] = $sqll3->num_rows();
            }else{
                $data['frnd_details'] = array();
                $data['frnd_limit'] = $cm_details['user_limit'];
                $data['frnd_count'] = 0;
            }
        }else{
                $data['frnd_details'] = array();
                $data['frnd_limit'] = 0;
                $data['frnd_count'] = 0;
        }
        if(isset($cm_details['ba_status']))
                {
                    $sql4 = "SELECT * FROM `pl_ba_registration` where created_by='$login_id' and is_del='0' ORDER BY `id`  DESC";
                    $sqll4 = $ci->db->query($sql4);
                    if($sqll4->num_rows()>0)
                    {
                        $data['ba_details'] =  $sqll4->result_array();
                        $data['ba_limit'] = $cm_details['ba_limit'];
                        $data['ba_count'] = $sqll4->num_rows();
                    }else{
                        $data['ba_details'] = array();
                        $data['ba_limit'] = $cm_details['ba_limit'];
                        $data['ba_count'] = 0;
                    }
                }else{
                        $data['ba_details'] = array();
                        $data['ba_limit'] = 0;
                        $data['ba_count'] = 0;
                }
                print_r($data);
            return $data;
    } else{
     return array();
    }
}
function get_ca_facility_by_id($id)
{

    $ci =& get_instance();
    $ci->load->database();
    $data = array();
    $qry = "SELECT nc.name,nc.id as user_id,lt.id as login_id,count(*)as user_limit FROM `gp_normal_customer` nc 
    left join gp_login_table lt ON lt.user_id = nc.id  
    WHERE lt.parent_login_id='$id' AND  lt.type='normal_customer'";

    $query = $ci->db->query($qry);
    if($query->num_rows()>0)
    {
        $ca_details =  $query->row_array();
        $login_id = $id;
       
        $sql1 = "SELECT * FROM `gp_preference` where slug='add_friend_facility' ORDER BY `id`  DESC";
        $sql1 = $ci->db->query($sql1);
        if($sql1->num_rows()>0)
        {
            $details =  $sql1->row_array();
            $data['frnd_count'] = $ca_details['user_limit'];
            $data['frnd_limit'] = $details['value'];
        }else{
            $details =  array();
            $data['frnd_count'] = $ca_details['user_limit'];
            $data['frnd_limit'] = 0;
        }
        
        return $data;
    } else{
        return array();
    }
}

function get_all_channel_partners()
{
    $ci =& get_instance();
    $ci->load->database();
    $qry = "select
        cp.id,
        cp.name
        from gp_pl_channel_partner cp 
        left join gp_login_table gp_log on gp_log.id=cp.created_by
        where cp.status='JOINED' and cp.is_del=0";
    $qry = $ci->db->query($qry);
    if($qry->num_rows()>0)
    {
        return $qry->result_array();
    } else{
        return array();
    }
}
function get_club_plan_bytypes($type)
{
    $ci =& get_instance();
    $ci->load->database();
    $qry = "select ty.id, ty.title, ty.amount, ty.cash_limit,ty.description from club_member_type ty where ty.type='$type' AND ty.is_del = 0";
    $qry = $ci->db->query($qry);
    if($qry->num_rows()>0)
    {
        return $qry->result_array();
    }   else{
        return array();
    }
}
function getClubtypeById($id)
{
    $ci =& get_instance();
    $ci->load->database();
    $qry = "select * from club_member_type ty where ty.id='$id' AND ty.is_del = 0";
    $qry = $ci->db->query($qry);
    
    if($qry->num_rows()>0)
    {
        return $qry->row_array();
    }   else{
        return array();
    }
}
function get_details_by_loginid($id)
{
   $ci =& get_instance();
    $ci->load->database();
    $qry = "select * from gp_login_table  where id='$id' AND is_del = 0";
    $qry = $ci->db->query($qry);
    if($qry->num_rows()>0)
    {
        return $qry->row_array();
    }   else{
        return array();
    } 
}
function get_details_by_userid($id)
{
   $ci =& get_instance();
    $ci->load->database();
   $qry = "select * from gp_normal_customer  where id='$id' AND is_del = 0";
    $qry = $ci->db->query($qry);
    if($qry->num_rows()>0)
    {
        return $qry->row_array();
    }   else{
        return array();
    } 
}
function active_frnds_count($search,$cols)
{ 
    $ci =& get_instance();
    $ci->load->database();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }

    $coll = implode(',',$cols); 
    if(!empty($search)){
        $where = search_where($search,$cols);
    }else{
        $where = '';
    }
    $qry="SELECT ".$coll." FROM `gp_login_table` JOIN `gp_normal_customer` ON `gp_login_table`.`user_id` = `gp_normal_customer`.`id` 
        JOIN `gp_customer_additional_info` ON `gp_normal_customer`.`id` = `gp_customer_additional_info`.`customer_id` 
        WHERE `gp_login_table`.`parent_login_id` = '$login_id' AND `gp_login_table`.`is_del` = 0 AND `gp_login_table`.`type`='normal_customer'".$where;
    $result=$ci->db->query($qry);
    if($result->num_rows()>0)
    {
        return $result->num_rows();
    }else {
        return false;
    }
}
function active_frnds_paging ($search,$cols,$limit, $start)
{ 
    $ci =& get_instance();
    $ci->load->database();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }
     if(!empty($search)){
        $where = search_where($search,$cols);
    }else{
        $where = '';
    }
    $coll = implode(',',$cols); 
    $qry="select ".$coll." FROM `gp_login_table` JOIN `gp_normal_customer` ON `gp_login_table`.`user_id` = `gp_normal_customer`.`id`  JOIN `gp_customer_additional_info` ON `gp_normal_customer`.`id` = `gp_customer_additional_info`.`customer_id`  WHERE `gp_login_table`.`parent_login_id` = '$login_id' AND `gp_login_table`.`is_del` = 0 AND `gp_login_table`.`type`='normal_customer'".$where."LIMIT $start, $limit";
    $result=$ci->db->query($qry);

    if($result->num_rows()>0)
    {
        return $result->result_array();
    }else {
        return array();
    }
}
function active_friends_count($search,$cols)
{ 
    $ci =& get_instance();
    $ci->load->database();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }

    $coll = implode(',',$cols); 
    if(!empty($search)){
        $where = search_where($search,$cols);
    }else{
        $where = '';
    }
    $qry="SELECT ".$coll." FROM `gp_login_table` JOIN `gp_normal_customer` ON `gp_login_table`.`user_id` = `gp_normal_customer`.`id` JOIN `gp_customer_additional_info` ON `gp_normal_customer`.`id` = `gp_customer_additional_info`.`customer_id` WHERE `gp_login_table`.`parent_login_id` = '$login_id' AND `gp_login_table`.`is_del` = 0 AND `gp_login_table`.`type`='normal_customer' UNION 
        SELECT ".$coll." FROM `gp_be_clubmember` LEFT JOIN   `gp_login_table` ON `gp_be_clubmember`.`parent_log_id`= `gp_login_table`.`id`  LEFT JOIN `gp_normal_customer` ON `gp_login_table`.`user_id` = `gp_normal_customer`.`id` JOIN `gp_customer_additional_info` ON `gp_normal_customer`.`id` = `gp_customer_additional_info`.`customer_id` WHERE `gp_be_clubmember`.`parent_log_id` = '$login_id' AND `gp_login_table`.`is_del` = 0 AND gp_login_table.type='club_member' ".$where;
    $result=$ci->db->query($qry);
    if($result->num_rows()>0)
    {
        return $result->num_rows();
    }else {
        return false;
    }
}
function active_friends_paging ($search,$cols,$limit, $start)
{ 
    $ci =& get_instance();
    $ci->load->database();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }
     if(!empty($search)){
        $where = search_where($search,$cols);
    }else{
        $where = '';
    }
    $coll = implode(',',$cols); 
    $qry="SELECT ".$coll." FROM `gp_login_table` JOIN `gp_normal_customer` ON `gp_login_table`.`user_id` = `gp_normal_customer`.`id` JOIN `gp_customer_additional_info` ON `gp_normal_customer`.`id` = `gp_customer_additional_info`.`customer_id` WHERE `gp_login_table`.`parent_login_id` = '$login_id' AND `gp_login_table`.`is_del` = 0 AND `gp_login_table`.`type`='normal_customer' UNION 
        SELECT ".$coll." FROM `gp_be_clubmember` LEFT JOIN   `gp_login_table` ON `gp_be_clubmember`.`parent_log_id`= `gp_login_table`.`id`  LEFT JOIN `gp_normal_customer` ON `gp_login_table`.`user_id` = `gp_normal_customer`.`id` JOIN `gp_customer_additional_info` ON `gp_normal_customer`.`id` = `gp_customer_additional_info`.`customer_id` WHERE `gp_be_clubmember`.`parent_log_id` = '$login_id' AND `gp_login_table`.`is_del` = 0 AND gp_login_table.type='club_member' ".$where."LIMIT $start, $limit";
    $result=$ci->db->query($qry);

    if($result->num_rows()>0)
    {
        return $result->result_array();
    }else {
        return array();
    }
}
function my_channel_partners_count($search,$cols)
{
    $ci =& get_instance();
    $ci->load->database();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }

    $coll = implode(',',$cols); 
    if(!empty($search)){
        $where = search_where($search,$cols);
    }else{
        $where = '';
    }
    $qry="SELECT ".$coll." FROM `gp_pl_channel_partner` WHERE `gp_pl_channel_partner`.`club_mem_id` = '$login_id' ".$where;

    $result=$ci->db->query($qry);
    if($result->num_rows()>0)
    {
        return $result->num_rows();
    }else {
        return false;
    }
}
function my_channel_partners_paging($search,$cols,$limit, $start)
{ 
    $ci =& get_instance();
    $ci->load->database();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }
     if(!empty($search)){
        $where = search_where($search,$cols);
    }else{
        $where = '';
    }
    $coll = implode(',',$cols); 
    $qry="select ".$coll." FROM `gp_pl_channel_partner` WHERE `gp_pl_channel_partner`.`club_mem_id` = '$login_id'".$where."LIMIT $start, $limit";
    $result=$ci->db->query($qry);

    if($result->num_rows()>0)
    {
        return $result->result_array();
    }else {
        return array();
    }
}
function refered_friends_count($search,$cols)
{
    $ci =& get_instance();
    $ci->load->database();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }

    $coll = implode(',',$cols); 
    if(!empty($search)){
        $where = search_where($search,$cols);
    }else{
        $where = '';
    }
    $qry="SELECT ".$coll." FROM `gp_user_referrel` WHERE `gp_user_referrel`.`created_by` = '$login_id' AND `gp_user_referrel`.`is_del` = 0 AND `gp_user_referrel`.`status` = 0 ".$where;

    $result=$ci->db->query($qry);
    if($result->num_rows()>0)
    {
        return $result->num_rows();
    }else {
        return false;
    }
}
function refered_friends_paging($search,$cols,$limit, $start)
{ 
    $ci =& get_instance();
    $ci->load->database();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }
     if(!empty($search)){
        $where = search_where($search,$cols);
    }else{
        $where = '';
    }
    $coll = implode(',',$cols); 
    $qry="select ".$coll." FROM `gp_user_referrel` WHERE `gp_user_referrel`.`created_by` = '$login_id' AND `gp_user_referrel`.`is_del` = 0 AND `gp_user_referrel`.`status` = 0 ".$where."LIMIT $start, $limit";
    $result=$ci->db->query($qry);

    if($result->num_rows()>0)
    {
        return $result->result_array();
    }else {
        return array();
    }
}
function club_agents_count($search,$cols)
{
    $ci =& get_instance();
    $ci->load->database();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }

    $coll = implode(',',$cols); 
    if(!empty($search)){
        $where = search_where($search,$cols);
    }else{
        $where = '';
    }
    $qry="SELECT ".$coll." FROM `gp_login_table` 
 JOIN `gp_normal_customer` ON `gp_login_table`.`user_id` = `gp_normal_customer`.`id`
  WHERE (`gp_login_table`.`parent_login_id` = '$login_id' OR `gp_normal_customer`.`mem_id` = '$login_id')AND `gp_login_table`.`type` = 'club_agent' AND `gp_login_table`.`is_del` = 0 ".$where;

    $result=$ci->db->query($qry);
    if($result->num_rows()>0)
    {
        return $result->num_rows();
    }else {
        return false;
    }
}
function club_agents_paging($search,$cols,$limit, $start)
{ 
    $ci =& get_instance();
    $ci->load->database();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }
     if(!empty($search)){
        $where = search_where($search,$cols);
    }else{
        $where = '';
    }
    $coll = implode(',',$cols); 
    $qry="select ".$coll." FROM `gp_login_table` 
 JOIN `gp_normal_customer` ON `gp_login_table`.`user_id` = `gp_normal_customer`.`id`
  WHERE (`gp_login_table`.`parent_login_id` = '$login_id' OR `gp_normal_customer`.`mem_id` = '$login_id')AND `gp_login_table`.`type` = 'club_agent' AND `gp_login_table`.`is_del` = 0 ".$where."LIMIT $start, $limit";
    $result=$ci->db->query($qry);

    if($result->num_rows()>0)
    {
        return $result->result_array();
    }else {
        return array();
    }
}
function get_wallettype_by_id($wal_id)
{
    $ci =& get_instance();
    $ci->load->database();
    $qry="SELECT * FROM `gp_wallet_values` WHERE `id`='$wal_id'";
    $result=$ci->db->query($qry);

    if($result->num_rows()>0)
    {
        $res =  $result->row_array();
        return $res['wallet_type_id'];
    }else {
        return 0;
    }
}

function my_transactions_count($search,$from,$to,$cols)
{ 
    $ci =& get_instance();
    $ci->load->database();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }

    $coll = implode(',',$cols); 
    if(!empty($search)){
        $where = search_where($search,$cols);
    }else{
        $where = "";
    }
    if(empty($from)&&!empty($to)){
        $where2 = "AND (date(gp_purchase_bill_notification.purchased_on)='".$to."')";
    }elseif(empty($to)&&!empty($from)){
        $where2 = "AND (date(gp_purchase_bill_notification.purchased_on)='".$from."')";
    }elseif(!empty($from)&&!empty($to)){
        $where2 = "AND (date(gp_purchase_bill_notification.purchased_on) between '".$from."' and '".$to."')";
    }else{
        $where2 ="";
    }
    $qry="SELECT ".$coll." FROM `gp_wallet_activity`  
        inner join gp_purchase_bill_notification on gp_purchase_bill_notification.id=gp_wallet_activity.purchase_bill_notification_id
        left join gp_pl_channel_partner  on gp_purchase_bill_notification.channel_partner_id=gp_pl_channel_partner.id
        where (`gp_wallet_activity`.`user_id`='$login_id' and `gp_wallet_activity`.`wallet_type_id`='2' and gp_wallet_activity.type='GAIN')".$where. $where2." group by gp_wallet_activity.id ORDER BY `gp_wallet_activity`.`wallet_type_id` DESC";
    $result=$ci->db->query($qry);
    if($result->num_rows()>0)
    {
        return $result->num_rows();
    }else {
        return false;
    }
}
function my_transaction_paging ($search,$from,$to,$cols,$limit, $start)
{ 
    $ci =& get_instance();
    $ci->load->database();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }
     if(!empty($search)){
        $where = search_where($search,$cols);
    }else{
        $where = '';
    }
    if(empty($from)&&!empty($to)){
        $where2 = "AND ( date(gp_purchase_bill_notification.purchased_on)='".$to."')";
    }elseif(empty($to)&&!empty($from)){
        $where2 = "AND ( date(gp_purchase_bill_notification.purchased_on)='".$from."')";
    }elseif(!empty($from)&&!empty($to)){
        $where2 = "AND ( date(gp_purchase_bill_notification.purchased_on) between '".$from."' and '".$to."')";
    }else{
        $where2 ="";
    }
    $coll = implode(',',$cols); 
    $qry="select ".$coll." FROM `gp_wallet_activity` 
        inner join gp_purchase_bill_notification on gp_purchase_bill_notification.id=gp_wallet_activity.purchase_bill_notification_id
        left join gp_pl_channel_partner  on gp_purchase_bill_notification.channel_partner_id=gp_pl_channel_partner.id
        where (`gp_wallet_activity`.`user_id`='$login_id' and `gp_wallet_activity`.`wallet_type_id`='2'and gp_wallet_activity.type='GAIN')".$where. $where2." group by gp_wallet_activity.id  ORDER BY `gp_wallet_activity`.`wallet_type_id` DESC LIMIT $start, $limit";
    $result=$ci->db->query($qry);

    if($result->num_rows()>0)
    {
        return $result->result_array();
    }else {
        return array();
    }
}
function get_cp_name($id,$search)
{
    $ci =& get_instance();
    $ci->load->database();
    if(!empty($search)){
        $where= " AND cp.name LIKE '%{$search}%'";
    }else{
        $where = '';
    }

    
    $sql = "SELECT cp.name FROM gp_pl_channel_partner cp WHERE cp.id='$id'".$where;
    $sql=$ci->db->query($sql);

    if($sql->num_rows()>0)
    {
        $res2 = $sql->row_array();
        return $res2['name'];
    }
}
function get_rewards($login_id,$id,$search)
{
    $ci =& get_instance();
    $ci->load->database();
    if(!empty($search)){
        $where = " AND change_value LIKE '%{$search}%'";
    }else{
        $where = '';
    }
    $sql3 = "SELECT change_value FROM `gp_wallet_activity`  
            WHERE user_id='$login_id' and  `gp_wallet_activity`.`wallet_type_id`='2' and purchase_bill_notification_id='$id' and type='GAIN' ".$where."
             ORDER BY `id` DESC";
    $sql3=$ci->db->query($sql3);

    if($sql3->num_rows()>0)
    {
        $res3 = $sql3->row_array();
        return $res3['change_value'];
    }
}
function get_purchase_by_customers_count($search,$from,$to)
{
    $ci =& get_instance();
    $ci->load->database();
    $data=array();
    $details=array();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }
    if(!empty($search)){
        $keyword = "%{$search}%";
        $where = " AND (nc.name LIKE '$keyword' OR bn.wallet_total LIKE '$keyword' OR bn.bill_total LIKE '$keyword' OR DATE_FORMAT(bn.purchased_on,'%d-%b-%Y') LIKE '$keyword')";
    }else{
        $where = '';
    }
    if(empty($from)&&!empty($to)){
        $to = $to." 00:00:00";
        $where2 = "AND bn.purchased_on='".$to."'";
    }elseif(empty($to)&&!empty($from)){
        $from =$from." 00:00:00";
        $where2 = "AND bn.purchased_on='".$from."'";
    }elseif(!empty($from)&&!empty($to)){
        $from =$from." 00:00:00";$to = $to." 23:59:59";
        $where2 = "AND bn.purchased_on between '".$from."' and '".$to."'";
    }else{
        $where2 ="";
    }


    $query="SELECT bn.id,bn.login_id,nc.name,bn.wallet_total,bn.bill_total,bn.purchased_on as purchase_date, DATE_FORMAT(bn.purchased_on,'%d-%b-%Y')as purchsed_on,bn.channel_partner_id FROM gp_purchase_bill_notification bn LEFT JOIN gp_login_table log ON log.id=bn.login_id 
        LEFT JOIN gp_normal_customer nc ON log.user_id=nc.id WHERE log.id='$login_id' AND log.type='normal_customer'".$where. $where2." GROUP BY bn.id";
    $result=$ci->db->query($query);
   
    if($result->num_rows()>0)
    {
        $res1 = $result->result_array();
        foreach ($res1 as $key => $value) {
            $channel_partner_id = $value['channel_partner_id'];
            $purchase_date = $value['purchase_date'];
            $login_id = $value['login_id'];
            $noty_id = $value['id'];
            $value['channel'] = get_cp_name($channel_partner_id,$search);
            $value['reward']=get_rewards($login_id,$noty_id,$search);
            array_push($data,$value);
        }
    }
    else
    {
        unset($data); // $data is gone
        $data = array();
        $query2="SELECT bn.id,bn.login_id,nc.name,bn.wallet_total,bn.bill_total,bn.purchased_on as purchase_date, DATE_FORMAT(bn.purchased_on,'%d-%b-%Y')as purchsed_on,bn.channel_partner_id FROM gp_purchase_bill_notification bn LEFT JOIN gp_login_table log ON log.id=bn.login_id 
        LEFT JOIN gp_normal_customer nc ON log.user_id=nc.id WHERE log.id='$login_id' AND log.type='normal_customer'". $where2." GROUP BY bn.id";
        $result2=$ci->db->query($query2);
        $res1 = $result2->result_array();
        foreach ($res1 as $key => $value2) {
            $channel_partner_id = $value2['channel_partner_id'];
            $purchase_date = $value2['purchase_date'];
            $login_id = $value2['login_id'];
            $noty_id = $value2['id'];
            $value['channel'] = get_cp_name($channel_partner_id,$search);
            
            if(!empty($search)){
                $where4 = " AND change_value LIKE '%{$search}%'";
            }else{
                $where4 = '';
            }
            $sql3 = "SELECT change_value FROM `gp_wallet_activity`  
                    WHERE user_id='$login_id' and  `gp_wallet_activity`.`wallet_type_id`='2' and purchase_bill_notification_id='$noty_id' and type='GAIN' ".$where4."
                     ORDER BY `id` DESC";
            $sql3=$ci->db->query($sql3);

            if($sql3->num_rows()>0)
            {
                $res3 = $sql3->row_array();
                $details['reward']=$res3['change_value'];
                $details['name']=$value2['name'];
                $details['id']=$value2['id'];
                $details['wallet_total']=$value2['wallet_total'];
                $details['bill_total']=$value2['bill_total'];
                $details['purchsed_on']=$value2['purchsed_on'];
                array_push($data,$details);

            }   
        }
    }  
    return sizeof($data);
}
function get_purchase_by_customers($search,$from,$to,$limit=NULL,$start=NULL)
{
    $ci =& get_instance();
    $ci->load->database();
    $data=array();
    $details=array();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }
    if(!empty($search)){
        $keyword = "%{$search}%";
        $where = " AND (nc.name LIKE '$keyword' OR bn.wallet_total LIKE '$keyword' OR bn.bill_total LIKE '$keyword' OR DATE_FORMAT(bn.purchased_on,'%d-%b-%Y') LIKE '$keyword')";
    }else{
        $where = '';
    }
    if(empty($from)&&!empty($to)){
        $to = $to." 00:00:00";
        $where2 = "AND bn.purchased_on='".$to."'";
    }elseif(empty($to)&&!empty($from)){
        $from =$from." 00:00:00";
        $where2 = "AND bn.purchased_on='".$from."'";
    }elseif(!empty($from)&&!empty($to)){
        $from =$from." 00:00:00";$to = $to." 23:59:59";
        $where2 = "AND bn.purchased_on between '".$from."' and '".$to."'";
    }else{
        $where2 ="";
    }
    if(!is_null($start)&&!is_null($limit)){
        $pg = " LIMIT $start, $limit";
    }else{
        $pg = "";
    }


    $query="SELECT bn.id,bn.login_id,nc.name,bn.wallet_total,bn.bill_total,bn.purchased_on as purchase_date, DATE_FORMAT(bn.purchased_on,'%d-%b-%Y')as purchsed_on,bn.channel_partner_id FROM gp_purchase_bill_notification bn LEFT JOIN gp_login_table log ON log.id=bn.login_id 
        LEFT JOIN gp_normal_customer nc ON log.user_id=nc.id WHERE log.id='$login_id' AND log.type='normal_customer'".$where. $where2." GROUP BY bn.id".$pg;
    $result=$ci->db->query($query);
   
    if($result->num_rows()>0)
    {
        $res1 = $result->result_array();
        foreach ($res1 as $key => $value) {
            $channel_partner_id = $value['channel_partner_id'];
            $purchase_date = $value['purchase_date'];
            $login_id = $value['login_id'];
            $noty_id = $value['id'];
            $value['channel'] = get_cp_name($channel_partner_id,$search);
            $value['reward']=get_rewards($login_id,$noty_id,$search);
            
            array_push($data,$value);
        }
    }
    else
    {
        unset($data); // $data is gone
        $data = array();
        $query2="SELECT bn.id,bn.login_id,nc.name,bn.wallet_total,bn.bill_total,bn.purchased_on as purchase_date, DATE_FORMAT(bn.purchased_on,'%d-%b-%Y')as purchsed_on,bn.channel_partner_id FROM gp_purchase_bill_notification bn LEFT JOIN gp_login_table log ON log.id=bn.login_id 
        LEFT JOIN gp_normal_customer nc ON log.user_id=nc.id WHERE log.id='$login_id' AND log.type='normal_customer'". $where2." GROUP BY bn.id".$pg;
        $result2=$ci->db->query($query2);
        $res1 = $result2->result_array();
        foreach ($res1 as $key => $value2) {
            $channel_partner_id = $value2['channel_partner_id'];
            $purchase_date = $value2['purchase_date'];
            $login_id = $value2['login_id'];
            $noty_id = $value2['id'];
            $value['reward']=get_rewards($login_id,$noty_id,$search);
            
            if(!empty($search)){
                $where4 = " AND change_value LIKE '%{$search}%'";
            }else{
                $where4 = '';
            }
            $sql3 = "SELECT change_value FROM `gp_wallet_activity`  
                    WHERE user_id='$login_id' and  `gp_wallet_activity`.`wallet_type_id`='2' and purchase_bill_notification_id='$noty_id' and type='GAIN' ".$where4."
                     ORDER BY `id` DESC";
            $sql3=$ci->db->query($sql3);

            if($sql3->num_rows()>0)
            {
                $res3 = $sql3->row_array();
                $details['reward']=$res3['change_value'];
                $details['name']=$value2['name'];
                $details['id']=$value2['id'];
                $details['wallet_total']=$value2['wallet_total'];
                $details['bill_total']=$value2['bill_total'];
                $details['purchsed_on']=$value2['purchsed_on'];
                array_push($data,$details);

            }   
        }
    }  
    return $data;
}
function getDesignations()
{
    $ci =& get_instance();
    $ci->load->database();
    
    $qry="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id,gp_pl_sales_designation_type.slug
    FROM `gp_pl_sales_designation_type` LEFT JOIN `gp_executive_promotion_settings`
    ON gp_pl_sales_designation_type.id = gp_executive_promotion_settings.designation_id 
    where gp_pl_sales_designation_type.is_del='0' and gp_pl_sales_designation_type.type='executive'
    GROUP BY gp_pl_sales_designation_type.designation  ";
    $qry = $ci->db->query($qry);
    if($qry->num_rows()>0){
        return $qry->result_array();
    } else{
        return array();
    }
}
function get_ba_count($search,$cols)
{
    $ci =& get_instance();
    $ci->load->database();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }

    $coll = implode(',',$cols); 
    if(!empty($search)){
        $where = "and (ba.id LIKE '%{$search}%' OR ba.name LIKE '%{$search}%' OR
              ba.mobil_no LIKE '%{$search}%' OR ba.email LIKE '%{$search}%' OR
              ba.company_name LIKE '%{$search}%' OR
              ba.office_phno LIKE '%{$search}%' OR
              ba.office_email LIKE '%{$search}%' OR ba.status LIKE '%{$search}%')";
    }else{
        $where = '';
    }
    $qry="SELECT ".$coll." FROM pl_ba_registration ba where ba.club_mem_id='$login_id' AND ba.is_del='0' ".$where;

    $result=$ci->db->query($qry);
    if($result->num_rows()>0)
    {
        return $result->num_rows();
    }else {
        return false;
    }
}
function get_all_bas($search,$cols,$limit, $start)
{ 
    $ci =& get_instance();
    $ci->load->database();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }
     if(!empty($search)){
        $where = "and (ba.id LIKE '%{$search}%' OR ba.name LIKE '%{$search}%'OR
              ba.mobil_no LIKE '%{$search}%' OR ba.email LIKE '%{$search}%' OR
              ba.company_name LIKE '%{$search}%' OR
              ba.office_phno LIKE '%{$search}%' OR
              ba.office_email LIKE '%{$search}%' OR ba.status LIKE '%{$search}%')";
    }else{
        $where = '';
    }
    $coll = implode(',',$cols); 
    $qry="select ".$coll."  FROM pl_ba_registration ba where ba.club_mem_id='$login_id' AND ba.is_del='0'  ".$where."LIMIT $start, $limit";
    $result=$ci->db->query($qry);

    if($result->num_rows()>0)
    {
        return $result->result_array();
    }else {
        return array();
    }
}
function get_bde_count($search,$cols)
{
    $ci =& get_instance();
    $ci->load->database();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }

    $coll = implode(',',$cols); 
    if(!empty($search)){
        // $where = search_where($search,$cols);
        $where = "and (gp_team_mem.id LIKE '%{$search}%' OR gp_member_det.name LIKE '%{$search}%'OR
              gp_member_det.phone LIKE '%{$search}%' OR gp_member_det.email LIKE '%{$search}%' OR
              gp_desig.designation LIKE '%{$search}%' OR
              gp_team_mem.status LIKE '%{$search}%')";
    }else{
        $where = '';
    }
    $qry="SELECT ".$coll." from gp_pl_sales_team_members gp_team_mem
        join gp_pl_sales_team_member_details gp_member_det on gp_team_mem.id = gp_member_det.sales_team_member_id
        join gp_pl_sales_designation_type gp_desig on gp_team_mem.sales_desig_type_id = gp_desig.id
        join gp_login_table on gp_team_mem.id = gp_login_table.user_id where gp_team_mem.created_by='$login_id' and
        gp_team_mem.is_del ='0'
        and gp_login_table.is_del ='0' and  gp_member_det.is_del ='0'".$where." group by gp_team_mem.id order by gp_team_mem.id desc";

    $result=$ci->db->query($qry);
    if($result->num_rows()>0)
    {
        return $result->num_rows();
    }else {
        return false;
    }
}
function get_all_bdes($search,$cols,$limit, $start)
{ 
    $ci =& get_instance();
    $ci->load->database();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
    }
     if(!empty($search)){
         $where = "and (gp_team_mem.id LIKE '%{$search}%' OR gp_member_det.name LIKE '%{$search}%'OR
              gp_member_det.phone LIKE '%{$search}%' OR gp_member_det.email LIKE '%{$search}%' OR
              gp_desig.designation LIKE '%{$search}%' OR
              gp_team_mem.status LIKE '%{$search}%')";
        // $where = search_where($search,$cols);
    }else{
        $where = '';
    }
    $coll = implode(',',$cols); 
    $qry="select ".$coll."  from gp_pl_sales_team_members gp_team_mem
        join gp_pl_sales_team_member_details gp_member_det on gp_team_mem.id = gp_member_det.sales_team_member_id
        join gp_pl_sales_designation_type gp_desig on gp_team_mem.sales_desig_type_id = gp_desig.id
        join gp_login_table on gp_team_mem.id = gp_login_table.user_id where gp_team_mem.created_by='$login_id' and
        gp_team_mem.is_del ='0'
        and gp_login_table.is_del ='0' and  gp_member_det.is_del ='0' ".$where."group by gp_team_mem.id order by gp_team_mem.id desc LIMIT $start, $limit";
    $result=$ci->db->query($qry);

    if($result->num_rows()>0)
    {
        return $result->result_array();
    }else {
        return array();
    }
}
function get_wallet_val_id($user_id,$type){
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->where('user_id', $user_id);
    $ci->db->where('wallet_type_id',$type);
    $wal_id =  $ci->db->get('gp_wallet_values')->row()->id;
    return $wal_id;
}
function get_api_key()
{
    $ci =& get_instance();
    $ci->load->database();
    $api_key= $ci->input->get_request_header('Authorization');
    return $api_key;
}
function user_details_by_apikey($api_key)
{

$ci =& get_instance();
$ci->load->database();
 $qry = "select u.id, u.email,u.user_id,u.type from gp_login_table u where u.api_key = '$api_key'";

        $qry = $ci->db->query($qry);
       
        if($qry->num_rows()>0) {
            $data = $qry->row_array();
        }else{
            $data = array();
        }
        return $data;
}
    function apikey_available($random_no)
    {
        $ci =& get_instance();
        $qry = "select
                u.api_key
                from
                gp_login_table u where u.api_key= '$random_no'";
        $query = $ci->db->query($qry);
        if($query->num_rows()>0)
        {
            return FALSE;
        }else{
            return TRUE;
        }
    }
    function apikey_generate()
    {
        $ci =& get_instance();
        $ci->load->database();
        $random_no = random_string('alnum', 10);
        $result = apikey_available($random_no);

        if($result == TRUE)
        {
            return $random_no;
        } else{
            $random_no = random_string('alnum', 10);
            $result = apikey_available($random_no);
        }
    }
    function getDeactivateReasons()
    {
        $ci =& get_instance();
        $ci->load->database();
        $qry = "select * from gp_deactivate_reasons";

        $qry = $ci->db->query($qry);
       
        if($qry->num_rows()>0) {
            $data = $qry->result_array();
        }else{
            $data = array();
        }
        return $data;
    }
    function check_bal_in_wallet($wallet_price, $user_id,$type)
        {
            $ci =& get_instance();
            $ci->load->database();

            $wal_qry = "select * from gp_wallet_values where user_id = '$user_id' and total_value >= '$wallet_price' and wallet_type_id = '$type'";
            $wal_qry = $ci->db->query($wal_qry);
            if($wal_qry->num_rows()>0)
            {
                $data['status'] = TRUE;
            } else{
                $data['status'] = FALSE;
            }
            
            return $data;
        }
        function get_wallet_id($user_id,$type)
        {
            $ci =& get_instance();
            $ci->load->database();

            $wal_qry = "select id from gp_wallet_values where user_id = '$user_id' and wallet_type_id = '$type'";
            $wal_qry = $ci->db->query($wal_qry);
            if($wal_qry->num_rows()>0)
            {
                $wal_qry = $wal_qry->row();
                $data = $wal_qry->id;
            } else{
                $data = FALSE;
            }
            
            return $data;
        }
        function incriment_count($id)
        {
            $ci =& get_instance();
            $ci->load->database();
            $qry=$ci->db->query("UPDATE gp_product_details set viewed =viewed+1
             where id = '$id' ");
            if($qry)
            {
                return true;
            }
            else
            {
                return false;
            }
          }
          function getLedgerId($emp_id,$type)
            {
                $ci =& get_instance();
                $ci->load->database();
                $id = $ci->db->select('id')
                    ->where('_type',$type)
                    ->where('type_id',$emp_id)
                    ->limit(1)
                    ->get('erp_ac_ledgers')
                    ->row('id');
                    //echo $ci->db->last_query();exit();
                if($id) {
                   return $id;
                }else{
                    return false;
                }
            }
          
function get_financial_year()
    {
        $ci =& get_instance();
        $ci->load->database();
        $id = $ci->db->select('id')
            ->where('id_current',1)
            ->limit(1)
            ->get('financial_year')
            ->row('id');
        if($id) {
           return $id;
        }else{
            return false;
        }
    }
    function get_wallet_val($user_id,$type)
        {
            $ci =& get_instance();
            $ci->load->database();

            $wal_qry = "select total_value from gp_wallet_values where user_id = '$user_id' and wallet_type_id = '$type'";
            $wal_qry = $ci->db->query($wal_qry);
            if($wal_qry->num_rows()>0)
            {
                $wal_qry = $wal_qry->row();
                $data = $wal_qry->total_value;
            } else{
                $data = FALSE;
            }
            
            return $data;
        }   
    function user_details_by_mobile($mobile){
        $ci =& get_instance();
$ci->load->database();
 $qry = "select u.id,u.api_key, u.email,u.user_id,u.type from gp_login_table u where u.mobile = '$mobile'";

        $qry = $ci->db->query($qry);
       
        if($qry->num_rows()>0) {
            $data = $qry->row_array();
        }else{
            $data = array();
        }
        return $data;
    }
    function get_my_club_agents()
    { 
        $ci =& get_instance();
        $ci->load->database();
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
        $qry="select nc.name,log.id FROM gp_login_table log 
        JOIN gp_normal_customer nc ON log.user_id = nc.id
        WHERE (log.parent_login_id = '$login_id' OR nc.mem_id = '$login_id')
        AND log.type = 'club_agent' AND log.is_del = 0";
        $result=$ci->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->result_array();
        }else {
            return array();
        }
    }
    function add_acc_entry($type_id,$amount){
        $ci =& get_instance();
        $ci->load->database();
        $fy_year = get_current_financial_year();
        $fy_id = $fy_year['id'];   
        $no =get_number();
        $ent_data = array(
                'entrytype_id'=>4,
                '_type'=>'PURCHASE',
                'type_id'=>$type_id,
                'number'=>$no,
                'fy_id' =>$fy_id,
                'date'=>date('Y-m-d'),
                'dr_total'=>$amount,
                'cr_total'=>$amount,
            );
        $ci->db->insert('erp_ac_entries',$ent_data);
        $entry_id = $ci->db->insert_id();
        return $entry_id;
    }
    function add_acc_entry_item($entry_id,$ledger_payment,$type,$amount){
        $ci =& get_instance();
        $ci->load->database();
        $fy_year = get_current_financial_year();
        $fy_id = $fy_year['id'];   
        $entry_items = array(
                'entry_id' => $entry_id,
                'ledger_id' => $ledger_payment,
                'amount' => $amount,
                'dc' => $type,
                'fy_id' =>$fy_id,
                'created_date' => date('Y-m-d')
            );
        $entry = $ci->db->insert('erp_ac_entryitems', $entry_items);
        return $entry;
    }
    function getLedgerById($emp_id)
    {
        $ci =& get_instance();
        $ci->load->database();
        $id = $ci->db->select('id')
            ->where('type_id',$emp_id)
            ->limit(1)
            ->get('erp_ac_ledgers')
            ->row('id');
            //echo $ci->db->last_query();exit();
        if($id) {
           return $id;
        }else{
            return false;
        }
    }
    function get_preference_data(){
        $ci =& get_instance();
        $ci->load->database();
        $qry = "SELECT * FROM gp_preference p ORDER BY id DESC";
        $qry = $ci->db->query($qry);
        if ($qry && $qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }
    function get_designation_by_slug($slug){
        $ci =& get_instance();
        $ci->load->database();
        $qry = "SELECT * FROM gp_pl_sales_designation_type p WHERE p.slug='$slug'";
        $qry = $ci->db->query($qry);
        if ($qry && $qry->num_rows() > 0) {
            $res =  $qry->row();
            return $res->id;
        } else {
            return false;
        }
    }
     function upgrade_designation_team($userid,$lgid)
    {


        $ci =& get_instance();
        $ci->load->database();   
        $qry1 = $ci->db->query("SELECT m.last_promotion_date,s.id,s.promotion_designation ,s.sysmodule_id FROM gp_pl_sales_team_members m left join gp_executive_promotion_settings s on m.sales_desig_type_id = s.designation_id where m.id = '$userid'");

            if($qry1->num_rows()>0)
            {
              $res1 =  $qry1->row();
              $last_promo_date = $res1->last_promotion_date;
              $promo_id = $res1->id;
              $next_designation = $res1->promotion_designation;
              $sysmodule_id= $res1->sysmodule_id;
              $qry2 = $ci->db->query("select * from gp_executive_promotion_details s where s.promo_id = '$promo_id' order by s.period ASC");
              //echo $ci->db->last_query();exit();
              if($qry2->num_rows()>0){
                 $res2 =  $qry2->result_array();
                    foreach ($res2 as $key => $value) {
                        $cur_date = date('Y-m-d');
                        $period = $value['period'];
                        $count = $value['count'];
                        $qry_month = $ci->db->query("SELECT DATE_SUB(curdate(), INTERVAL +$period MONTH) as month");
                          if($qry_month->num_rows()>0){

                                $res3 = $qry_month->row();
                                $init_month = $res3->month;
                                $count1 = 0;
                                $x = strtotime($cur_date);
                                $each_month = date("Y-m-d",strtotime("-1 month",$x));
                                //var_dump($period);var_dump($each_month);exit;

                                for($i=1; $i<=$period; $i++){
                                    
                                      $qry_count13 = $ci->db->query("SELECT count(gm.id) ex_count FROM `gp_pl_sales_team_members` gm where gm.created_by=$lgid AND gm.sales_desig_type_id='$sysmodule_id' and gm.is_del = '0'and gm.status = 'ACTIVE' and (gm.created_on BETWEEN '$each_month' and '$cur_date')");
                                           
                                    
                                         $res55 =  $qry_count13->result_array();
                                         if($qry_count13->num_rows()>0){
                                            $res55 =  $qry_count13->row_array();
                                            // $res55 = $qry_count13->row_array();var_dump($res55);
                                            $c_count11 = $res55['ex_count'];
                                           /*var_dump($c_count11);
                                            exit;*/
                                            $int_count = (int)$c_count11;
                                      
                                            //echo $c_count;exit();
                                            if($int_count >= $count){
                                             $count1++;   
                                            }
                                            else{
                                                
                                                break;
                                            }
                                            $cur_date = $each_month;
                                            $x = strtotime($cur_date);
                                            $each_month = date("Y-m-d",strtotime("-1 month",$x));
                                         
                                           
                                         }else{
                                            
                                            $res4 = false;
                                 
                                            
                                         }
                                    
                                }
                              
                                $int_period = (int)$period;
                                $cur_date1 = date('Y-m-d');
                               //var_dump($count1);var_dump($int_period);exit();
                                if($count1>=$int_period){
                                    $up_data = array(
                                        'sales_desig_type_id'=> $next_designation ,
                                        'last_promotion_date' =>$cur_date1
                                        );
                                 $ci->db->where('id', $userid);
                                 $qry = $ci->db->update('gp_pl_sales_team_members', $up_data);
                                        $datas_ins= array(
                                            'user_id'=>$lgid,
                                            'designation'=> $next_designation ,
                                            'date' =>$cur_date1
                                        );
                                        $qry1 = $ci->db->insert('promotion_notification', $datas_ins);
                                       
                                }
                                
                               
                            }else{
                                 $res3 = false;
                            } 
                    }
                }else{
                    $res2 =  false;
                }
            } else{
                $res1 =  false;
            }
            
        // var_dump("expression123");exit();
        return true;
    }
    function check_wallet_exist($id,$type){
        $ci =& get_instance();
        $ci->load->database();  
        $qry= "select *  FROM gp_wallet_values where user_id='$id' and wallet_type_id= '$type'";
        $query=$ci->db->query($qry);
        if($query->num_rows()>0)
        {
          return true;
        } else{
          return false;
        } 
    }
    function convert_to_mysql_date($date)
    {
    $d = str_replace('/','-',$date);
    $mysql_date = date('Y-m-d H:i', strtotime($d));
    return $mysql_date;
    }
    function get_deactivate_details($id)
    {
        $ci =& get_instance();
        $ci->load->database();
        
        $sql = "SELECT * FROM gp_deactivate_account da  WHERE da.login_id='$id'";
        $sql=$ci->db->query($sql);
    
        if($sql->num_rows()>0)
        {
            $res2 = $sql->row_array();
            return $res2;
        }else{
            return array();
        }
    }
    function random_search($key,$location_id)
    {   
        $ci =& get_instance();
        $ci->load->database();

        $base = base_url();
        $qry = "select CONCAT(ROUND((((dt.actual_cost - dt.special_prize)/dt.actual_cost)*100),2), '%' ) as offer_percent, 
          CASE WHEN gpi.p_image ='' THEN '' 
                    ELSE CONCAT('$base',gpi.p_image)
                END AS  image,
          dt.actual_cost as old_price,dt.id,
          CASE WHEN p.brand_image ='' THEN '' 
                    ELSE CONCAT('$base',p.brand_image)
                END AS brand_logo,
          IFNULL(dt.name, '') as product_name, dt.special_prize as offer_price
          from gp_product_details dt 
          left join gp_pl_channel_partner p on p.id = dt.channel_partner_id 
          LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id 
          left join gp_product_brands b on dt.brand_id = b.id 
          where  dt.is_del = 0 AND p.town='$location_id' AND dt.is_del = '0' 
                AND  dt.type = '0' AND dt.name LIKE '%$key%' ORDER BY dt.name LIKE '$key%' desc,dt.id desc";
        $qry=$ci->db->query($qry);
    
        if ($qry->num_rows() > 0) {
            $data['products'] = $qry->result_array();
            foreach ($data['products'] as $key => $value) {
               $data['products'][$key]['isProduct'] = true;
               $data['products'][$key]['rating'] = '0';
            }
        } else {
            $data['products'] =  array();
        }
        return $data;
    }
    function get_fixed_wallet_details($id){
        $ci =& get_instance();
        $ci->load->database();
        $qry="SELECT * FROM `gp_wallet_values` WHERE `user_id`='$id' AND `wallet_type_id`='5'";
        $result=$ci->db->query($qry);

        if($result->num_rows()>0)
        {
            $res =  $result->row_array();
            return $res['total_value'];
        }else {
            return 0;
        }
    }
    function get_wallet_used_by_member($id,$type){
        $ci =& get_instance();
        $ci->load->database();
        $qry="SELECT SUM(change_value) AS total FROM gp_wallet_activity wa  WHERE wa.wallet_type_id='$type' AND wa.user_id='$id' AND wa.type='LOSS'";
        $result=$ci->db->query($qry);

        if($result->num_rows()>0)
        {
            $res =  $result->row_array();
            $total = isset($res['total'])?$res['total']:0;
            return $total;
        }else {
            return 0;
        }
    }
    function get_details_by_mobile($mob){
        $ci =& get_instance();
        $ci->load->database();
        $qry="SELECT t.type,t.id as login_id,n.id as user_id,n.club_type_id,n.fixed_club_type_id,n.investor_type_id,t.type,t.email FROM gp_login_table t left join gp_normal_customer n on t.user_id = n.id WHERE t.mobile = '$mob' and t.type not in ('super_admin','channel_partner','executive') and t.is_del = '0' and n.status = 'approved'";
        $result=$ci->db->query($qry); 
        if($result->num_rows()>0)
        {
            return $result->row_array();
        }else {
            return array();
        }
    }
    function get_upgradable_club_plan_bytypes($id,$type)
    {
        $ci =& get_instance();
        $ci->load->database();
        $qry = "select ty.id, ty.title, ty.amount, ty.cash_limit,ty.description from club_member_type ty where ty.type='$type' AND ty.amount>=(SELECT amount FROM `club_member_type` WHERE id='$id' GROUP BY id) AND ty.is_del = 0 ORDER BY ty.amount asc";
        $qry = $ci->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
?>