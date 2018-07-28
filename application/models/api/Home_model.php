<?php
Class Home_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();

    }




    function get_state($country)
    {
		$qry = "select s.name,s.id from states s where s.country_id = '$country' ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
    function get_countries(){
        $qry = "select c.name,c.id from countries c ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
    function get_reason(){
        $qry = "select c.reason,c.id from gp_deactivate_reasons c ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
    function get_city($state){
    	$qry = "select s.name,s.id from cities s where s.state_id = '$state' ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
    function get_executive_designations(){
    	$qry = "select s.designation as name,s.id from gp_pl_sales_designation_type s where s.type = 'executive' ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
    function validate_psw($pass,$api_key)
    {
        $usr_data=user_details_by_apikey($api_key);
        $id = $usr_data['id'];
        $password = $this->input->post('old_password');
        $psd = encrypt_decrypt('encrypt',$password);
        $query = "select * from gp_login_table u where u.password ='$psd' and u.id = $id";
        $query = $this->db->query($query);
      
        if($query->num_rows()>0)
        {
            return true;
        } else
        {
            return false;
        }
    }
    function validate_email($email)
    {
        $data = array();
       $qry = "select * from gp_login_table where email = '$email'  ";
        $qry = $this->db->query($qry);
        
        if($qry->num_rows()>0)
        {
            $data['reason'] = "Email id already Exists";
            $data['status'] = FALSE;
        } else{
            $data['status'] =  TRUE;
        }
        return $data;
    } 
    function validate_phone($phone)
    {
        $data = array();
        $qry2 = "select * from gp_login_table where mobile = '$phone' ";
            $qry2 = $this->db->query($qry2);
            if($qry2->num_rows()>0)
            {
               
                $data['reason'] = "Phone no already Exists";
                $data['status'] = FALSE;
            } else{
                $data['status'] =  TRUE;
            }
            
        
        return $data;
    } 
    function change_password($password,$api_key)
    {
        $data = array();
        $this->db->trans_begin();
        $usr_data=user_details_by_apikey($api_key);
        $id = $usr_data['id'];
        $pass = encrypt_decrypt('encrypt',$password);
        $datas = array('password' => $pass);
        $this->db->where('id',$id);
        $this->db->update('gp_login_table',$datas);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data['status'] = FALSE;
        } else {
            $this->db->trans_commit();
            $data['status'] = TRUE;
        }
        return $data;
    }
    function validate_user(){
        $mobile = $this->input->post('mobile');
        $email = $this->input->post('email');
        if(!empty($mobile)){
            $where = "u.mobile ='$mobile'";
        }else{
            $where = "u.email ='$email'";
        } 
        $otp = random_string('numeric', 4);
        $query = "select u.id from gp_login_table u where ".$where. " and u.type not in ('super_admin','channel_partner') and u.is_del = 0" ;
        $query = $this->db->query($query);

        if($query->num_rows()>0)
        {
            $data['user']=$query->row_array();
            $id=$data['user']['id'];
            $datas = array('otp' => $otp);
            $this->db->where('id',$id);
            $this->db->update('gp_login_table',$datas);
            return $otp;
        } else
        {
            return false;
        }
    }
    function confirm_otp(){
        $mobile = $this->input->post('mobile');
        $email = $this->input->post('email'); 
        $otp = $this->input->post('otp');
        $query = "select u.api_key as id from gp_login_table u where (u.mobile ='$mobile' or u.email ='$email') and u.otp='$otp'";
         $query = $this->db->query($query);
        if($query->num_rows()>0)
        {
            return $query->row_array();
        } else
        {
            return false;
        }
    }
    function reset_password(){

        $pass= $this->input->post('password');
        $api_key = $this->input->post('api_key'); 
        $password =encrypt_decrypt('encrypt',$this->input->post('password'));
        $datas = array('password' => $password);
        $this->db->where('api_key',$api_key);
        $qry=$this->db->update('gp_login_table',$datas);
        //echo  $this->db->last_query();exit();
        return $qry;

    }
    function profile($api_key)
    {
        $udetails = user_details_by_apikey($api_key);
        if(!empty($udetails)){
                $type =$udetails['type'];
                if($type=='club_member'||$type=='club_agent'||$type=='normal_customer'){
                    $base = base_url().'uploads/';
                    $qry="select gp_login_table.id,gp_login_table.email,gp_login_table.mobile as phone ,gp_normal_customer.name as firstName,
                        gpa.alt_mobile as phone_sec, 
                        IFNULL(gp_normal_customer.pincode,'') as pin,
                        IFNULL(gpa.lastname,'') as lastName,
                        IFNULL(gpa.whatssup_no,'') as whats_app_number,
                        IFNULL(gp_normal_customer.profile_image,'') as image_url,
                        IFNULL(gpa.alt_email,'') as email_sec,
                        IFNULL(gpa.house_name,'') as house_name,
                        IFNULL(gpa.house_no,'') as house_number,
                        IFNULL(gpa.streat,'') as street,
                        IFNULL(gpa.road,'') as road,
                        IFNULL(gpa.location,'') as location,
                        IFNULL(gpa.area,'') as area,
                        gpa.city as city_id,
                        IFNULL(gpa.post_office,'') as post_office,
                        IFNULL(gpa.district,'null') as district,
                        gpa.country as country_id,
                        gpa.state as state_id,
                        IFNULL(gpa.facebook_id,'') as facebook_id,
                        IFNULL(gpa.twitter,'') as twitter,
                        IFNULL(gpa.google_plus,'') as google_plus,
                        (select c.name from countries c WHERE c.id = gpa.country) as country,(select ct.name from cities ct WHERE ct.id = gpa.city) as city,(select s.name from states s WHERE s.id = gpa.state) as state
                        from gp_login_table 
                        left join gp_normal_customer 
                        on gp_login_table.user_id= gp_normal_customer.id 
                        inner join gp_customer_additional_info gpa
                        on gpa.customer_id =gp_normal_customer.id  
                        where gp_login_table.api_key='$api_key'";
                }else if($type=='executive'){
                   $base = base_url().'upload/';
                    $qry="select gp_login_table.id,gp_login_table.email,gp_login_table.mobile as phone ,gpa.name as firstName,
                        IFNULL(gpa.image,'') as image_url,
                        IFNULL(gpa.city,'') as city,
                        IFNULL(gpa.country,'') as country,
                        IFNULL(gpa.state,'') as state
                        from gp_login_table 
                        left join gp_pl_sales_team_members 
                        on gp_login_table.user_id= gp_pl_sales_team_members.id 
                        inner join gp_pl_sales_team_member_details gpa
                        on gpa.sales_team_member_id =gp_pl_sales_team_members.id  
                        where gp_login_table.api_key='$api_key'";
                }else{
                    return false;
                }
                
                $qry=$this->db->query($qry);
               // echo $this->db->last_query();
                if($qry->num_rows()>0){
                    $reff = array();
                    $details = $qry->row_array();
                    $login_id = $details['id'];
                    $not_details= get_notification_count($login_id);
                    $details['notification_count'] = $not_details->noti_count; 
                    if($details['image_url']==''){
                        $img = $base.'profile.jpg';
                    }else{
                        $img = $base.$details['image_url'];
                    }
                    $details['image_url'] = $img; 
                    if($type=='executive'){
                        $details['pin']="";
                        $details['phone_sec']=""; 
                        $details['lastName']="";
                        $details['whats_app_number']="";
                        $details['email_sec']="";
                        $details['house_name']="";
                        $details['house_number']="";
                        $details['street']="";
                        $details['road']="";
                        $details['location']="";
                        $details['area']="";
                        $details['post_office']="";
                        $details['district']="";
                        $details['facebook_id']="";
                        $details['twitter']="";
                        $details['google_plus']="";
                    }
                    /*$reffered = $this->get_reffered_friends($login_id);
                    foreach ($reffered as $key => $value) {
                        $value['profile_image']='';
                        array_push($reff,$value);
                    }*/
                    $bonus = $this->get_bonus($login_id);
                    $details['bounus'] = $bonus;

                }else{
                    $details = false;
                }
        }else{
            $details = false;
        }
        return $details;
    }
    function get_reffered_friends($login_id)
    {
        $qry = "select r.name as firstName,
        IFNULL(r.email,'') as email,
        r.mobile as phone,
        IFNULL(r.altemail,'') as email_sec,
        IFNULL(r.altmobile,'') as phone_sec,
        r.id from gp_user_referrel r  
        where r.referrer_id = '$login_id' and r.is_del!=1 and status = 0";
        $qry = $this->db->query($qry, $login_id);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        } else{
            return array();
        }       
    }
    function get_active_friends($login_id)
    {
        $url = base_url()."uploads/";
        $qry = "select lt.id,nc.name as firstName,lt.mobile as phone,
            IFNULL(gcai.lastname,'') as lastName,
            CONCAT('http://jaazzo.cybase.in/jaazzo/uploads/',nc.profile_image)as profile_image,
            IFNULL(gcai.city,'') as city,
            IFNULL(gcai.house_name,'') as house_name,
            IFNULL(gcai.district,'') as district,
            IFNULL(gcai.alt_mobile,'') as phone_sec,
            IFNULL(gcai.alt_email,'') as email_sec,
            lt.email
            from gp_login_table lt
            left join gp_normal_customer nc on lt.user_id = nc.id
            left join gp_customer_additional_info gcai on nc.id=gcai.customer_id
            where lt.parent_login_id = '$login_id' and lt.type='normal_customer'
            union select lt.id,nc.name as firstName,lt.mobile as phone,
            IFNULL(gcai.lastname,'') as lastName,
            CONCAT('$url',nc.profile_image)as profile_image,
            IFNULL(gcai.city,'') as city,
            IFNULL(gcai.house_name,'') as house_name,
            IFNULL(gcai.district,'') as district,
            IFNULL(gcai.alt_mobile,'') as phone_sec,
            IFNULL(gcai.alt_email,'') as email_sec,
            lt.email from `gp_be_clubmember`  LEFT JOIN  `gp_login_table` lt  ON `gp_be_clubmember`.`parent_log_id`= `lt`.`id`  LEFT JOIN `gp_normal_customer` nc ON `lt`.`user_id` = `nc`.`id` JOIN `gp_customer_additional_info` gcai ON `nc`.`id` = `gcai`.`customer_id` WHERE `gp_be_clubmember`.`parent_log_id` = '$login_id' AND `lt`.`is_del` = 0 AND lt.type='club_member'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        } else{
            return array();
        }       
    }
    function get_bonus($login_id){
        $base = base_url().'uploads/';
        $resultt = array();
        // $query="SELECT bn.id as bill_id,bn.login_id as cus_login_id,wa.change_value,date(bn.purchased_on)as purchase_date,cp.name as channel_partner,cp.id as channel_id
        // FROM gp_purchase_bill_notification bn 
        // left join gp_wallet_activity wa on bn.id=wa.purchase_bill_notification_id
        // left join gp_pl_channel_partner cp on cp.id=bn.channel_partner_id
        // where  (wa.user_id='$login_id' and wa.type='GAIN') 
        // group by bn.id ";
        $query="select bn.id as bill_id,bn.login_id as cus_login_id,wa.change_value,date(bn.purchased_on)as purchase_date,cp.name as channel_partner,cp.id as channel_id FROM `gp_wallet_activity` wa inner join gp_purchase_bill_notification bn on bn.id=wa.purchase_bill_notification_id
        left join gp_pl_channel_partner cp on bn.channel_partner_id=cp.id
        where (`wa`.`user_id`='$login_id' and `wa`.`wallet_type_id`='2' and wa.type='GAIN') group by wa.id  ORDER BY `wa`.`wallet_type_id` DESC ";
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            $det_res = $result->result_array();
            foreach ($det_res as $key => $det2) {
                $amount = $det2['change_value'];
                $purchase_date = $det2['purchase_date'];
                $channel_name = $det2['channel_partner'];
                $channel_id =  $det2['channel_id'];
                $bill_id = $det2['bill_id'];
                $cus_login_id = $det2['cus_login_id'];
                $cus_details = $this->getCustomerName($cus_login_id);
                $url = base_url()."uploads/";
                if($cus_details['p_image']==''){
                    $img = $base.'profile.jpg';
                }else{
                    $img = $base.$cus_details['p_image'];
                }
                $name = $cus_details['name'];
                array_push($resultt,array('customer_name'=>$name,
                    'channel_name'=>$channel_name,
                    'customer_id'=>$cus_login_id,
                    'channel_partner_id'=>$channel_id,
                    'customer_image'=>$img,
                    'bonus'=>$amount,
                    'date'=>$purchase_date,
                    'id'=>$bill_id,
                    ));
            }
                
            return $resultt;
        }else{
            return array();
        } 


       
    }
    function getCustomerName($login_id)
    {
        $qry = "select lt.id,nc.name as name,nc.profile_image as p_image
            from gp_login_table lt
            left join gp_normal_customer nc on lt.user_id = nc.id
             where lt.id = '$login_id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->row_array();
        } else{
            return array();
        }   
    }
    function add_money_to_wallet($login_id)
    {
        $data = array();
        $this->db->trans_begin();
        $amnt = $this->input->post('amount');

        $qry1 = $this->db->query("select * from gp_wallet_values where user_id = '$login_id' 
            AND wallet_type_id='4'");
        if($qry1->num_rows()>0)
        {
            $wal_details = $qry1->row_array();
            $this->db->set('total_value', 'total_value + ' . (float) $amnt, FALSE);
            $this->db->where('user_id', $login_id);
            $this->db->where('wallet_type_id', 4);
            $this->db->update('gp_wallet_values');
            $wal_activity = array(
            'wallet_type_id' => 4,
            'user_id' => $login_id,
            'change_value' => $amnt,
            'date_modified' => date('Y-m-d h:i:s'),
            'description' => 'Added Money to my wallet'
            );
            $this->db->insert('gp_wallet_activity', $wal_activity);
        }else{
            $wallet = array(
                'wallet_type_id' => 4,
                'user_id' => $login_id,
                'total_value' => $amnt
                );
            $this->db->insert('gp_wallet_values', $wallet);
            $wal_activity = array(
                'wallet_type_id' => 4,
                'user_id' => $login_id,
                'change_value' => $amnt,
                'date_modified' => date('Y-m-d h:i:s'),
                'description' => 'Added Money to my wallet'
                );
            $this->db->insert('gp_wallet_activity', $wal_activity);
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data['status'] = FALSE;
        } else {
            $this->db->trans_commit();
            $data['status'] = TRUE;
        }
        return $data;
    }
    function get_search_product_locations($key){
        $qry = "SELECT c.id,c.name from cities c LEFT join states s on c.state_id = s.id left join countries ctr on ctr.id = s.country_id where ctr.id = 101 and  c.name LIKE '%$key%' order by c.name LIKE '$key%' desc,c.id desc";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
    function get_location_wise_channel_partner($location_id){
        $base =base_url();
        $qry = "SELECT cp.id,cp.name,cp.email,cp.phone,
                CASE
                    WHEN cp.profile_image ='' THEN '' 
                    ELSE CONCAT('$base',cp.profile_image)
                END AS  image,
            cp.area as address FROM gp_pl_channel_partner cp  LEFT JOIN cities c ON cp.town=c.id WHERE cp.status='JOINED' AND cp.is_active=1
            AND cp.is_del=0 AND cp.town='$location_id'
            ORDER BY cp.id DESC";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
}
?>