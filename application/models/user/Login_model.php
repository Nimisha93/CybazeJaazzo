    <?php
/**
* 
*/
class Login_model extends CI_Model
{
	
    function __construct()
    {
		parent::__construct();
		$this->load->database();
    }
    /*function validate_login()
    {
		$username = $this->input->post('username');
		$password = encrypt_decrypt('encrypt',$this->input->post('password'));
		/*$qry = "select lg.*,nc.club_type_id,nc.fixed_club_type_id,nc.investor_type_id,lg.type from gp_login_table lg left join gp_normal_customer nc on lg.user_id=nc.id where (lg.email = '$username' or lg.mobile = '$username') and lg.password = '$password' and (lg.type ='normal_customer' or lg.type = 'club_member' or lg.type = 'club_agent') and  lg.is_del = 0 and nc.status='approved'";*///lg.otp_status = 1 and
        /*$qry = "select lg.*,nc.club_type_id,nc.fixed_club_type_id,nc.investor_type_id,lg.type from gp_login_table lg left join gp_normal_customer nc on lg.user_id=nc.id where (lg.email = '$username' or lg.mobile = '$username') and lg.password = '$password' and  lg.is_del = 0 and nc.status='approved'";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			return $qry->row_array();
		}else{
			return array();
		}
   // }*/
    function validate_login()
    {
		$username = $this->input->post('username');
		$password = encrypt_decrypt('encrypt',$this->input->post('password'));
		/*$qry = "select lg.*,nc.club_type_id,nc.fixed_club_type_id,nc.investor_type_id,lg.type from gp_login_table lg left join gp_normal_customer nc on lg.user_id=nc.id where (lg.email = '$username' or lg.mobile = '$username') and lg.password = '$password' and (lg.type ='normal_customer' or lg.type = 'club_member' or lg.type = 'club_agent') and  lg.is_del = 0 and nc.status='approved'";*///lg.otp_status = 1 and
        $qry = "select lg.*,nc.club_type_id,nc.fixed_club_type_id,nc.investor_type_id,lg.type from gp_login_table lg left join gp_normal_customer nc on lg.user_id=nc.id where (lg.email = '$username' or lg.mobile = '$username') and lg.password = '$password' and  nc.status='approved'";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
            $dets =  $qry->row_array();
            if($dets['is_del']==1){
                $otp = random_string('numeric',4);
                $log_id = $dets['id'];
                $user_id = $dets['user_id'];
                $data1 = array(
                    'otp' => $otp,
                    'reg_otp_status'=>1,
                    );
                $this->db->where('id', $user_id);
                $qry1 = $this->db->update('gp_normal_customer', $data1);

                $userLogin = array(
                    'otp_status'=>1
                    ); 
                $this->db->where('id', $log_id);
                $qry_login = $this->db->update('gp_login_table', $userLogin);
                $qry2 = "select lg.*,nc.club_type_id,nc.fixed_club_type_id,nc.investor_type_id,lg.type,nc.otp from gp_login_table lg left join gp_normal_customer nc on lg.user_id=nc.id where (lg.email = '$username' or lg.mobile = '$username') and lg.password = '$password' and  nc.status='approved'";
                $qry2 = $this->db->query($qry2);
                if($qry2->num_rows()>0)
                {
                    return $dets2 =  $qry2->row_array();
                }
            }else{
                return $qry->row_array();
            }
		}else{
			return array();
		}
    }
    function otp_validate()
    {
        $this->db->trans_begin();
        $data = array();
        $otp = $this->input->post('log_otp');
        $password =  encrypt_decrypt('encrypt',$this->input->post('pasword'));
        $email = $this->input->post('maill');
        $qry = "SELECT * from gp_normal_customer c left join gp_login_table log on log.user_id=c.id where c.otp = '$otp' and (log.email = '$email' or log.password = '$password')";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {

            $user_details = $qry->row_array();
            $user_id = $user_details['user_id'];

            $qry_res = "SELECT tb.*,nc.club_type_id,nc.name,nc.fixed_club_type_id,nc.investor_type_id  from gp_login_table tb left join gp_normal_customer nc on tb.user_id=nc.id where tb.user_id = '$user_id'";
            $qry_res = $this->db->query($qry_res);
            if($qry_res->num_rows()>0)
            {
                $login_details = $qry_res->row_array();
                $login_id = $login_details['id'];
                $userid = $login_details['user_id'];

                $update_status1 = array('otp_status' => 0,'is_del'=>0);
                $this->db->where('id', $login_id);
                $upqry1 = $this->db->update('gp_login_table', $update_status1);

                $update_status2 = array('reg_otp_status' => 0,'status'=>'approved','is_del'=>0);
                $this->db->where('id', $userid);
                $upqry2 = $this->db->update('gp_normal_customer', $update_status2);

                $date = date("Y-m-d h:i:s a") ;
                $action = "login";
                $status = 0;
                activity_log($action,$login_id,$status,$date);
                $this->db->trans_complete();
            } else{
                $data['status'] = FALSE;
                $data['reason'] = "Invalid User";
                return $data;   
            }   
        } else{
            $data['status'] = FALSE;
            $data['reason'] = "Invalid OTP";
            return $data;   
        }   
        
        //var_dump($this->db->trans_status());
        if($this->db->trans_status() === TRUE)
        {
            $data['info'] =  $login_details;
            $data['status'] = TRUE;
        }else{
            $data['info'] =  array();
            $data['status'] = FALSE;
            $data['reason'] = "Database Error";
        }
        return $data;       
    }
    function validate_user($username)
    {
        /*$query = "select * from gp_login_table lg where lg.email = ? and (lg.type ='normal_customer' or lg.type = 'club_member' or (lg.type = 'club_agent' and lg.is_del != 1))";*/
        $query = "select * from gp_login_table lg where lg.email = ? and  lg.is_del != 1";
        $query = $this->db->query($query, $username);
        if($query->num_rows()>0)
        {
            return $query->row_array();
        } else
        {
            return false;
        }
    }
    function validate_user_mail($email){
        $query = "select * from gp_login_table lg where lg.email = ? and (lg.type ='normal_customer' or lg.type = 'club_member' or (lg.type = 'club_agent' and lg.is_del != 1))";
        $query = $this->db->query($query, $email);
        if($query->num_rows()>0)
        {
            return $query->row_array();
        } else
        {
            return false;
        }
    }
    function check_randomexists($random){
        $query = "select * from gp_login_table lg where lg.random_key = ? and (lg.type ='normal_customer' or lg.type = 'club_member' or lg.type = 'club_agent' and (lg.is_del != 1))";
        $query = $this->db->query($query, $random);
        if($query->num_rows()>0)
        {
            return $query->row_array();
        } else
        {
            return false;
        }
    }
    function insert_random($email,$random){
        $data = array('random_key' => $random,'random_date' => date('Y-m-d H:i:s'));
        $this->db->where('email', $email);
        $qry = $this->db->update('gp_login_table', $data);
        return $qry;
    }
    function get_date($rand)
    {
        
        $result = $this->db->select("gp_login_table.*,gp_normal_customer.club_type_id,gp_normal_customer.fixed_club_type_id,gp_normal_customer.investor_type_id")
            ->join('gp_normal_customer','gp_login_table.user_id=gp_normal_customer.id')
            ->where('random_key',$rand)
            ->get('gp_login_table')
            ->row();
        if($result) 
        return $result;
        else
        return array();
    }
    function update_new_password($random,$password)
    {
        $data = array(
            'password' => encrypt_decrypt('encrypt',$password)
        );
        $this->db->where('random_key',$random);
        $result=$this->db->update('gp_login_table',$data);   
        return $result;
    }
    function validate_social_key($social_key){
        $data = array();
        $qry2 = "select * from gp_login_table where oauth_uid = '$social_key'";
        $qry2 = $this->db->query($qry2);
        if($qry2->num_rows()>0)
        {
            $result=$qry2->row_array();
            $data['id'] = $result['id'];
            $data['status'] = FALSE;
        }
        else
        {
            $data['status'] =  TRUE;
        }
        return $data;
    }
    function validate_email($email){
        $data = array();
        $qry2 = "select * from gp_login_table where email = '$email'";
        $qry2 = $this->db->query($qry2);
        if($qry2->num_rows()>0)
        {
            $result=$qry2->row_array();
            $data['id'] = $result['id'];
            $data['status'] = FALSE;
            $result=$qry2->row_array();
            $data['password'] = $result['password'];
            if($data['password']!='')
            {
                $data['id'] = $result['id'];
                $data['reason'] = "Phone no already Exists";
                $data['status'] = FALSE;
            }
            else
            {
                $data['status'] =  TRUE;
            }
        } else{
            $data['status'] =  TRUE;
        }
        return $data;
    }
    function get_data_by_social_key($social_key){
        $qrs = "select gp_login_table.id,gp_login_table.email,gp_login_table.mobile,gp_normal_customer.name as firstName,gpa.lastname as lastName,
gp_normal_customer.profile_image
            from gp_login_table  left join gp_normal_customer
             on gp_login_table.user_id= gp_normal_customer.id inner join gp_customer_additional_info gpa
             on gpa.customer_id =gp_normal_customer.id  where gp_login_table.oauth_uid='$social_key'";
        $qrs = $this->db->query($qrs);
        if($qrs->num_rows()>0)
        {
            $result=$qrs->row_array();
        }
        else
        {
            $result=array();
        }
        return $result;
    }
}
?>