<?php 
/**
* 
*/
class Login_model extends CI_Model
{
	
	function __construct()
    {
        parent:: __construct();
        $this->load->database();
    }
    function check_mobile_exist($mob)
    {
		$qry = "select log.id,log.type from gp_login_table log 
		where log.mobile = '$mob'";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			return $qry->row_array();
		} else{
			return true;
		}
    }
    function get_member_status($id,$type){
    	$qry = "select nc.status,log.type from gp_login_table log left join gp_normal_customer nc on log.user_id=nc.id
		where log.id = '$id' and log.type='$type'";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			return $qry->row_array();
		} else{
			return false;
		}
    }
    function check_exist_email($mail)
    {
    	$qry = "select * from gp_login_table log 
		where log.email = '$mail' ";
    	/*$qry = "select * from gp_login_table log left join gp_normal_customer nc on log.user_id=nc.id
		where log.email = '$mail' and log.type = 'normal_customer' AND nc.status='approved'";*/
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			return FALSE;
		} else{
			return TRUE;
		}
    }
    function sign_up()
    {
    	$api_key = apikey_generate();
    	$rid=0; $rtid=0;
		$email = $this->input->post('email');
		$phone = $this->input->post('mobile');
		$qry1 = "select id,referrer_id from gp_user_referrel where (mobile = '$phone' or altmobile = '$phone' OR email = '$email' or altemail = '$email') and status = '0' ";
		$qry1 = $this->db->query($qry1);
		if($qry1->num_rows()>0)
		{
			$ref = $qry1->row_array();
			$rid = $ref['referrer_id'];
			$rtid = $ref['id'];
			// print_r($rid);
		}else{
			$rid = 1;
			$rtid = 0;	
		}
		$this->db->trans_begin();
		$qryy = "SELECT c.*,log.id as log_id from gp_normal_customer c left join gp_login_table log  on log.user_id=c.id
		where  (log.email = '$email' or log.mobile = '$phone') and c.status='notapproved'";
		$qryy = $this->db->query($qryy);
		//var_dump($this->db->last_query());exit;
		$otp = random_string('numeric', 4);

		if($qryy->num_rows()>0)
		{

			$user_details = $qryy->row_array();
			$insert_id = $user_details['id'];
			$log_id = $user_details['log_id'];
			$data1 = array(
				'parent_id' => $rid,
				'name'=>$this->input->post('name'),
				'phone' => $this->input->post('mobile'),
				'email' => $this->input->post('email'),
				'type' => 'normal_customer',
				'otp' => $otp,
				'reg_otp_status'=>1,
				'profile_image'=>'',
				'is_del'=>0,
				'register_via'=>'normal',
				'created_on' => date("Y-m-d H:i:s"),
				'status'=>'notapproved'
				);
			$this->db->where('id', $insert_id);
			$qry = $this->db->update('gp_normal_customer', $data1);

			$userLogin = array(
				'mobile' => $this->input->post('mobile'),
				'email' => $this->input->post('email'),
				'user_id' => $insert_id,
				'is_del'=>0,
				'password' => encrypt_decrypt('encrypt',$this->input->post('password')),
				'type' => 'normal_customer',
				'fcm_token'=>$this->input->post('fcm_token'),
                'api_key'=>$api_key,
				'otp_status'=>1
				); 
			$this->db->where('id', $log_id);
			$qry_login = $this->db->update('gp_login_table', $userLogin);
			if($rtid!=0){
				$array = array('status' => 1);
				$this->db->where('id', $rtid);
				$upqry = $this->db->update('gp_user_referrel', $array);
			}
		}else{
			$data1 = array(
				'parent_id' => $rid,
				'name'=>$this->input->post('name'),
				'phone' => $this->input->post('mobile'),
				'email' => $this->input->post('email'),
				'type' => 'normal_customer',
				'otp' => $otp,
				'reg_otp_status'=>1,
				'profile_image'=>'',
				'is_del'=>0,
				'register_via'=>'normal',
				'created_on' => date("Y-m-d H:i:s"),
                //'api_key'=>$api,
				'status'=>'notapproved'
				);
			$qry = $this->db->insert('gp_normal_customer', $data1);

			$insert_id = $this->db->insert_id();
			$userLogin = array(
				'parent_login_id' => $rid,
				'mobile' => $this->input->post('mobile'),
				'email' => $this->input->post('email'),
				'user_id' => $insert_id,
				'is_del'=>0,
				'password' => encrypt_decrypt('encrypt',$this->input->post('password')),
				'type' => 'normal_customer',
				'fcm_token'=>$this->input->post('fcm_token'),
				'api_key'=>$api_key,
				'otp_status'=>1
				); 
			$qry_login = $this->db->insert('gp_login_table', $userLogin);
			if($rtid!=0){
				$array = array('status' => 1);
				$this->db->where('id', $rtid);
				$upqry = $this->db->update('gp_user_referrel', $array);
			}
			$data2 = array('customer_id' => $insert_id );
		    $qry2 = $this->db->insert('gp_customer_additional_info', $data2);
		}


		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        	$data['status'] = FALSE;
        } else {
            $this->db->trans_commit();
            $data['status'] = TRUE;
            $info = array('user_id' => $insert_id, 'otp' => $otp);
            $data['info'] = $info;
        }
        return $data;
    }
    function verify_otp()
    {
    	$this->db->trans_begin();
		$data = array();
		$otp = $this->input->post('otp');
		$phone = $this->input->post('mobile');
		$qry = "SELECT * from gp_normal_customer c where c.otp = '$otp' and c.phone = '$phone'";
		$qry = $this->db->query($qry);
		//var_dump($this->db->last_query());exit;
		if($qry->num_rows()>0)
		{

			$user_details = $qry->row_array();
			$user_id = $user_details['id'];

			$qry_res = "SELECT tb.api_key,nc.phone,nc.name,nc.email,nc.id,tb.id as log_id  from gp_login_table tb left join gp_normal_customer nc on tb.user_id=nc.id where tb.user_id = '$user_id' and tb.type = 'normal_customer'";
			$qry_res = $this->db->query($qry_res);
			//echo $this->db->last_query(); exit;
			if($qry_res->num_rows()>0)
			{
				$login_details = $qry_res->row_array();
				$login_id = $login_details['log_id'];
				$userid = $login_details['id'];
				$name = $login_details['name'];
				$api_key = $login_details['api_key'];

				$update_status1 = array('otp_status' => 0);
				$this->db->where('id', $login_id);
				$upqry1 = $this->db->update('gp_login_table', $update_status1);

				$update_status2 = array('reg_otp_status' => 0,'status'=>'approved');
				$this->db->where('id', $userid);
				$upqry2 = $this->db->update('gp_normal_customer', $update_status2);


				$wallete = array(
							array('wallet_type_id' => 2,
									'user_id' => $login_id,
									'total_value' => 0
									),
							array('wallet_type_id' => 4,
									'user_id' => $login_id,
									'total_value' => 0
									)
							);
				$qry3 = $this->db->insert_batch('gp_wallet_values', $wallete);
				$wal_activity = array(array(
		            'wallet_type_id' => 2,
		            'user_id' => $login_id,
		            'change_value' => 0,
		            'date_modified' => date('Y-m-d h:i:s'),
		            'description' => 'Normal Customer Sign up'
		            ),array(
		            'wallet_type_id' => 4,
		            'user_id' => $login_id,
		            'change_value' => 0,
		            'date_modified' => date('Y-m-d h:i:s'),
		            'description' => 'Normal Customer Sign up'
		            ));
		        $this->db->insert_batch('gp_wallet_activity', $wal_activity);
		        //-Create Ledger
		        $date = date('Y-m-d');
		        $financial_year = get_financial_year();
		        $mem_ldg = array(
		              'type_id' => $login_id,
		              '_type' => 'CUSTOMER',
		              'group_id' => 25,
		              'name' => $login_id ."_".$name.'_ledger'
		              );
		        $ldg_qry = $this->db->insert('erp_ac_ledgers', $mem_ldg);
		        $ldg_id = $this->db->insert_id();
		        $opening =  array(
		                        'ledger_id' => $ldg_id,
		                        'fy_id' => $financial_year,
		                        'opening_date' =>$date
		                        );
		        $open_qry = $this->db->insert('erp_ac_opening_balance', $opening);
				$date = date("Y-m-d h:i:sa") ;
		        $action = "normal customer registration ";
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
			$login_details['user_type']="customer";
			$login_details['member_type']="normal";
			unset($login_details['id']);
			$login_details['id'] = $login_details['api_key'];
			unset($login_details['log_id']);
			$data['info'] =  $login_details;
			$data['status'] = TRUE;
		}else{
			$data['info'] =  array();
			$data['status'] = FALSE;
			$data['reason'] = "Database Error";
		}
		return $data;
    }
    function request_otp($mobile)
    {
    	$qry = "SELECT * from gp_normal_customer c where c.type = 'normal_customer' and c.phone = '$mobile' and c.status='notapproved'";
		$qry = $this->db->query($qry);
		// var_dump($this->db->last_query());exit;
		if($qry->num_rows()>0)
		{
			$otp = random_string('numeric',4);
	    	$data = array('otp' => $otp);
	    	$this->db->where('phone', $mobile);
	    	$qryy = $this->db->update('gp_normal_customer', $data);
	    	//echo $this->db->last_query();exit;
	    	$row = $this->db->affected_rows();
	    	if($row >0){
	    		$data['data']=$otp;
	    		$data['status']=TRUE;
	    	}else{
	    		$data['status']=FALSE;
	    		$data['reason']='Mobile Number Does Not Exist';
	    	}
	    }else{
	    	$data['status']=FALSE;
	    	$data['reason']='Sign up completed';

	    }
	    return $data;
    }
    function resend_otp($mobile)
    {
    	$qry = "SELECT * from gp_normal_customer c where c.type = 'normal_customer' and c.phone = '$mobile' and c.status='notapproved'";
		$qry = $this->db->query($qry);
		// var_dump($this->db->last_query());exit;
		if($qry->num_rows()>0)
		{
			$otp = random_string('numeric',4);
	    	$data = array('otp' => $otp);
	    	$this->db->where('phone', $mobile);
	    	$qryy = $this->db->update('gp_normal_customer', $data);
	    	//echo $this->db->last_query();exit;
	    	$row = $this->db->affected_rows();
	    	if($row >0){
	    		$data['data']=$otp;
	    		$data['status']=TRUE;
	    	}else{
	    		$data['status']=FALSE;
	    		$data['reason']='Mobile Number Does Not Exist';
	    	}
	    }else{
	    	$data['status']=FALSE;
	    	$data['reason']='Sign up completed';

	    }
	    return $data;
    }
    function login_process()
    {
    	$fcm_id = $this->input->post('fcm_id');
        $password = $this->input->post('password');
        $username = $this->input->post('mobile')?$this->input->post('mobile'):$this->input->post('email');

        $qrs = "select lg.*	from gp_login_table lg  where ((lg.email = '$username' or lg.mobile = '$username') and lg.password = ?) and ((lg.type ='normal_customer' or lg.type = 'club_member' or lg.type = 'club_agent' or lg.type='executive')) and lg.is_del!=1";
    	$qrs = $this->db->query($qrs, array(encrypt_decrypt('encrypt',$this->input->post('password'))));
    	//echo $this->db->last_query();
    	if($qrs->num_rows()>0)
    	{
    		$result = $qrs->row_array();
    		$log_id = $result['id'];
    		$type = $result['type'];
    		$api_key = $result['api_key'];
            //update fcm id
            $this->db->where('id', $log_id);
            $fcm_up = array('fcm_token' => $fcm_id);
            $update = $this->db->update('gp_login_table', $fcm_up);
            
            $login_details = $this->get_log_details($log_id);
            $user_id = $result['user_id'];
            if($type=='normal_customer'){
            	$user_type='customer';
            	$member_type = 'normal';
            	unset($login_details['club_type_id']);
            	unset($login_details['fixed_club_type_id']);
            	unset($login_details['investor_type_id']);
            }else if($type=='club_member'){
            	$user_type='club_member';
            	if($login_details['club_type_id']>0){
            		$member_type = 'unlimited';
            	}if($login_details['fixed_club_type_id']>0){
            		$member_type = 'fixed';
            	}if($login_details['investor_type_id']>0){
					$member_type = 'tl_clubmember';
            	}
            }else if($type=='club_agent'){
            	$user_type='club_agent';
				$member_type = '';

            	unset($login_details['user_id']);
            	unset($login_details['club_type_id']);
            	unset($login_details['fixed_club_type_id']);
            	unset($login_details['investor_type_id']);
            }else if($type=='executive'){
            	$login_details = $this->get_executive_details($user_id);
            	$login_details['lastName'] = '';
            	if($login_details['slug']=='team_leader')
            	{
					$user_type="executive_team_lead";
					$member_type = "";
            	}else{
					$user_type="executive";
					$member_type = "";
            	}
            	unset($login_details['slug']);
            	unset($login_details['designation']);
            }else{
            	$member_type="";
            }
            $login_details['id'] = $api_key;
            $login_details['user_type'] = $user_type;	
            $login_details['member_type'] = $member_type;	

			$wallete = $this->get_wallet_values($log_id);
			foreach ($wallete as $key => $value) {
				$login_details['club_wallet'] = ($value['wallet_type_id']==1)?($value['total_value']):'0';
				$login_details['reward_wallet'] = ($value['wallet_type_id']==2)?($value['total_value']):'0';
				$login_details['incentive_wallet'] = ($value['wallet_type_id']==3)?($value['total_value']):'0';
				$login_details['my_wallet'] = ($value['wallet_type_id']==4)?($value['total_value']):'0';
			}

    	}else{
    		$login_details = false;
    	}

    	return $login_details;
    }
    function get_log_details($log_id)
    {
    	$url = base_url().'uploads/';

    	$qrs = "select nc.id as user_id,nc.name as firstName,ca.lastname as lastName,CONCAT('$url',nc.profile_image)as profile_image,log.email,
    	log.id,log.mobile as phone,nc.club_type_id,nc.fixed_club_type_id,nc.investor_type_id
		from gp_login_table log left join gp_normal_customer nc on log.user_id=nc.id
		left join gp_customer_additional_info ca on ca.customer_id=nc.id
		where log.id='$log_id'";
    	$qrs = $this->db->query($qrs);
    	if($qrs->num_rows()>0)
    	{
    		$result = $qrs->row_array();

    	}else{
    		$result = array();
    	}	
    	return $result;
    }
    function get_wallet_values($log_id)
    {
    	$qrs = "select wa.* from gp_login_table log left join gp_wallet_values wa on log.id = wa.user_id
		where log.id='$log_id'";
    	$qrs = $this->db->query($qrs);
    	if($qrs->num_rows()>0)
    	{
    		$result = $qrs->result_array();

    	}else{
    		$result = array();
    	}	
    	return $result;
    }
    function get_executive_details($id){
    	$url = base_url().'upload/';
    	$qrs = "SELECT sm.name as firstName,det.phone,det.email,CONCAT('$url',det.image) as profile_image,des_type.designation,des_type.slug
    	FROM gp_pl_sales_team_members sm 
		LEFT JOIN gp_pl_sales_designation_type des_type ON sm.sales_desig_type_id=des_type.id
		LEFT JOIN gp_pl_sales_team_member_details det ON det.sales_team_member_id=sm.id
		WHERE sm.id='$id'";
    	$qrs = $this->db->query($qrs);
    	if($qrs->num_rows()>0)
    	{
    		$result = $qrs->row_array();

    	}else{
    		$result = array();
    	}	
    	return $result;  
    }
    function check_ca_mobile_exist($mob)
    {
		$qry = "select * from gp_login_table log 
		where log.mobile = '$mob'";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			$data['result']= $qry->row_array();
			$data['status']= false;
		} else{
			$data['status']= true;
		}
		return $data;
    }
    function check_ca_exist_email($mail)
    {
    	$qry = "select * from gp_login_table log 
		where log.email = '$mail'";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			return FALSE;
		} else{
			return TRUE;
		}
    }
    function check_cm_mobile_exist($mob)
    {
		$data = array();

		$qry2 = "select log.* from gp_login_table log 
		where log.mobile = '$mob' and log.type='normal_customer' and log.type not in('Channel_partner','club_agent','ba','super_admin','executive')";
		$qry2 = $this->db->query($qry2);
		if($qry2->num_rows()>0)
		{
			$data['result']= $qry2->row_array();
			$data['status'] = TRUE;
		} else{
			$data['result']= array();
			$data['status'] =  FALSE;
		}
		return $data;
    }
    function check_cm_exist_email($mail)
    {
    	$qry = "select * from gp_login_table log 
		where log.email = '$mail' and log.type!='normal_customer'";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			return FALSE;
		} else{
			return TRUE;
		}
    }
    //validate social signup key
    function validate_social_key($key)
    {
        $data = array();
        $qry2 = "select * from gp_login_table where oauth_uid = '$key'";
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
    function validate_email($email)
    {
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
    function social_signup($data)
    {
    	$api_key = apikey_generate();
    	$this->db->trans_begin();
	    $otp = random_string('numeric',4);
	      
      	$datas = array(
	        'email' => $data['email'],
	        'name' => $data['name'],
	        'otp' => $otp,'type' => 'normal_customer',
	        'created_on' => date("Y-m-d H:i:s")
	    );
        $qry = $this->db->insert('gp_normal_customer', $datas);

	    $insert_id = $this->db->insert_id();
	    $data2 = array(
	          'customer_id' => $insert_id
	    );
	    $qry2 = $this->db->insert('gp_customer_additional_info', $data2);
	    $userLogin = array(
	        'oauth_uid'=>$data['oauth_uid'],
	        'oauth_provider'=>$data['oauth_provider'],
	        'email' => $data['email'],
	        'user_id' => $insert_id,
	        'type' => 'normal_customer',
	        'otp_status'=>0,
	        'parent_login_id'=>1,
	        'api_key'=>$api_key
	    ); 
	    $qry_login = $this->db->insert('gp_login_table', $userLogin);
	    $log_id = $this->db->insert_id();
	    
	    $data = array(
        	array('wallet_type_id' => 1,
                'user_id' => $log_id,
                'total_value' => 0
                ),
        	array('wallet_type_id' => 4,
                'user_id' => $log_id,
                'total_value' => 0
                )
        );

        $res = multi_insert('gp_wallet_values', $data);
        //-Create Ledger
        $date = date('Y-m-d');
        $financial_year = get_financial_year();
        $mem_ldg = array(
              'type_id' => $log_id,
              '_type' => 'CUSTOMER',
              'group_id' => 25,
              'name' => $log_id ."_".$data['name'].'_ledger'
              );
        $ldg_qry = $this->db->insert('erp_ac_ledgers', $mem_ldg);
        $ldg_id = $this->db->insert_id();
        $opening =  array(
                        'ledger_id' => $ldg_id,
                        'fy_id' => $financial_year,
                        'opening_date' =>$date
                        );
        $open_qry = $this->db->insert('erp_ac_opening_balance', $opening);
	    $this->db->trans_complete();
	    if ($this->db->trans_status() === FALSE) {
	        $this->db->trans_rollback();
	        return FALSE;
	    } else {
	        $this->db->trans_commit();
	        return $log_id;
	    }
    }
    //update social signup
    function update_social_signup($data)
    {
        $oauth_uid=$data['oauth_uid'];
        $oauth_provider=$data['oauth_provider'];
        $id=$data['id'];
        $sql="UPDATE gp_login_table SET oauth_uid='$oauth_uid',oauth_provider='$oauth_provider' 
        WHERE id='$id'";
        $result=$this->db->query($sql);
        if($result)
        {
            return true;
        }else{
        	return false;
        }
    }
    //get scustomer data by social key
    function get_data_by_social_key($key)
    {
        $base = base_url().'uploads/';
        $qrs = "select gp_login_table.api_key as id,gp_login_table.id as log_id,gp_login_table.email,gp_login_table.mobile as phone,
            gp_normal_customer.name as firstName,IFNULL(gpa.lastname,'') as lastName,
            IFNULL(gp_normal_customer.profile_image,'') as p_image 
            from gp_login_table  left join gp_normal_customer
             on gp_login_table.user_id= gp_normal_customer.id inner join gp_customer_additional_info gpa
             on gpa.customer_id =gp_normal_customer.id  where gp_login_table.oauth_uid='$key'";
        $qrs = $this->db->query($qrs);
        if($qrs->num_rows()>0)
        {
            $result=$qrs->row_array();
            $result['user_type']='customer';
            $result['member_type']='';
            $login_id = $result['log_id'];
            if($result['p_image']==''){
				$result['profile_image']=$base.'profile.jpg';
            }else{
				$result['profile_image']=$base.$result['p_image'];
            }
            $qry = "select wa.wallet_type_id,wa.total_value from gp_wallet_values wa where wa.user_id ='$login_id'";
	        $qry = $this->db->query($qry);
	        if($qry->num_rows()>0)
	        {
	            $res = $qry->result_array();
	            foreach ($res as $key => $value) {
	                $club_wallet = ($value['wallet_type_id']==1)?$value['total_value']:"0";
	                $reward_wallet = ($value['wallet_type_id']==2)?$value['total_value']:"0";
	                $my_wallet = ($value['wallet_type_id']==4)?$value['total_value']:"0";
	                $incentive_wallet = ($value['wallet_type_id']==3)?$value['total_value']:"0";
	            }
	            
	            $result['incentive_wallet']=$incentive_wallet;
	            $result['my_wallet']=$my_wallet;
	            $result['reward_wallet']=$reward_wallet;
	            $result['club_wallet']=$club_wallet;
	        }else{
	        	$result['incentive_wallet']="0";
	            $result['my_wallet']="0";
	            $result['reward_wallet']="0";
	            $result['club_wallet']="0";
	        }
	        unset($result['log_id']);
	        unset($result['p_image']);
        }
        else
        {
            $result=array();
        }
        return $result;
    }
    function get_data_by_mem_id($login_id)
    {
    	$base = base_url().'uploads/';
        $qrs = "select gp_login_table.api_key as id,gp_login_table.id as log_id,gp_login_table.email,gp_login_table.mobile as phone,
            gp_normal_customer.name as firstName,IFNULL(gpa.lastname,'') as lastName,
            IFNULL(gp_normal_customer.profile_image,'') as p_image 
            from gp_login_table  left join gp_normal_customer
             on gp_login_table.user_id= gp_normal_customer.id inner join gp_customer_additional_info gpa
             on gpa.customer_id =gp_normal_customer.id  where gp_login_table.id='$login_id'";
        $qrs = $this->db->query($qrs);
        if($qrs->num_rows()>0)
        {
            $result=$qrs->row_array();
            $result['user_type']='customer';
            $result['member_type']='';
            $login_id = $result['log_id'];
            if($result['p_image']==''){
				$result['profile_image']=$base.'profile.jpg';
            }else{
				$result['profile_image']=$base.$result['p_image'];
            }
            $qry = "select wa.wallet_type_id,wa.total_value from gp_wallet_values wa where wa.user_id ='$login_id'";
	        $qry = $this->db->query($qry);
	        if($qry->num_rows()>0)
	        {
	            $res = $qry->result_array();
	            foreach ($res as $key => $value) {
	                $club_wallet = ($value['wallet_type_id']==1)?$value['total_value']:0;
	                $reward_wallet = ($value['wallet_type_id']==2)?$value['total_value']:0;
	                $my_wallet = ($value['wallet_type_id']==4)?$value['total_value']:0;
	                $incentive_wallet = ($value['wallet_type_id']==3)?$value['total_value']:0;
	            }
	            
	            $result['incentive_wallet']=$incentive_wallet;
	            $result['my_wallet']=$my_wallet;
	            $result['reward_wallet']=$reward_wallet;
	            $result['club_wallet']=$club_wallet;
	        }else{
	        	$result['incentive_wallet']=0;
	            $result['my_wallet']=0;
	            $result['reward_wallet']=0;
	            $result['club_wallet']=0;
	        }
	        unset($result['log_id']);
	        unset($result['p_image']);
        }
        else
        {
            $result=array();
        }
        return $result;
    }
}
?>