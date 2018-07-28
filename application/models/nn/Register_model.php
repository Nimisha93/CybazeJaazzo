<?php
/**
* 
*/
class Register_model extends CI_Model
{
	
	function __construct()
	{
	    parent::__construct();
        $this->load->database();
	}
	function validate_email($email)
	{
		$data = array();
		//$email = $this->input->post('email');
		
		// $qry = "select * from gp_login_table where email = '$email' and (type = 'club_member' or type = 'normal_customer')";
		$qry = "select * from gp_login_table where email = '$email' and (type = 'club_member' or type = 'normal_customer' or type = 'club_agent')";
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
		
		//$phone = $this->input->post('phone');
		
			$qry2 = "select * from gp_login_table where mobile = '$phone'";
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
	function customer_registration()
	{
		$rid=0; $rtid=0;
		$phone = $this->input->post('phone');
		$qry4 = "select id,referrer_id from gp_user_referrel where mobile = '$phone' or altmobile = '$phone' and status = '0' ";
		$qry4 = $this->db->query($qry4);
			if($qry4->num_rows()>0)
			{
				$rid = $qry4->row_array();
				$rid = $rid['referrer_id'];
				$rtid = $rid['id'];
				// print_r($rid);
			}
			else
			{
				$email = $this->input->post('email');
				$qry5 = "select id,referrer_id from gp_user_referrel where email = '$email' or altemail = '$email' and status = '0' ";
				$qry5 = $this->db->query($qry5);
					if($qry5->num_rows()>0)
					{
					$rid = $qry5->row_array();
					$rid = $rid['referrer_id'];
					$rtid = $rid['id'];
					// print_r($rid);
					}
				}
		$data = array();
		$this->db->trans_begin();
		$otp = random_string('numeric', 5);
		$datas = array(
			'parent_id' => $rid,
			'phone' => $this->input->post('phone'),
			'email' => $this->input->post('email'),
			'otp' => $otp,
			'created_on' => date("Y-m-d H:i:s")
			);
		$qry = $this->db->insert('gp_normal_customer', $datas);

		$insert_id = $this->db->insert_id();
		$userLogin = array(
			'parent_login_id' => $rid,
			'mobile' => $this->input->post('phone'),
			'email' => $this->input->post('email'),
			'user_id' => $insert_id,
			'password' => encrypt_decrypt('encrypt',$this->input->post('password')),
			'type' => 'normal_customer'
			); 
		$qry_login = $this->db->insert('gp_login_table', $userLogin);
		$array = array('status' => 1);
		$this->db->where('id', $rtid);
		$upqry = $this->db->update('gp_user_referrel', $array);
        $data2 = array(
            'customer_id' => $insert_id
        );
        $qry2 = $this->db->insert('gp_customer_additional_info', $data2);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        	$data['status'] = FALSE;
        } else {
            $this->db->trans_commit();
            $data['status'] = TRUE;
            $info = array('user_id' => $insert_id,
			            'otp' => $otp
			            	);
            $data['info'] = $info;
        }
        return $data;
	}
	function otp_validate()
	{
		$this->db->trans_begin();
		$data = array();
		$otp = $this->input->post('reg_otp');
		$phone = $this->input->post('mobile');
		$email = $this->input->post('email');
		$qry = "SELECT * from gp_normal_customer c where c.otp = '$otp' and (c.email = '$email' or c.phone = '$phone')";
		$qry = $this->db->query($qry);
		//var_dump($this->db->last_query());exit;
		if($qry->num_rows()>0)
		{

			$user_details = $qry->row_array();
			$user_id = $user_details['id'];

			

			/*$qry_res = "SELECT * from gp_login_table tb where tb.user_id = '$user_id' and tb.type = 'normal_customer'";*/
			$qry_res = "SELECT tb.*,nc.club_type_id from gp_login_table tb left join gp_normal_customer nc on tb.user_id=nc.id where tb.user_id = '$user_id' and tb.type = 'normal_customer'";
			$qry_res = $this->db->query($qry_res);
			//echo $this->db->last_query(); exit;
			if($qry_res->num_rows()>0)
			{
				$login_details = $qry_res->row_array();
				$login_id = $login_details['id'];

				$update_status = array('otp_status' => 1);
				$this->db->where('id', $login_id);
				$upqry = $this->db->update('gp_login_table', $update_status);


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
    function get_state_by_country($id){
        $qry = "select
                s.id,s.name,s.country_id
                from
                states s
                where s.country_id = '$id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
    function get_city_by_state($id){
        $qry = "select
                c.id,c.name,c.state_id
                from
                cities c
                where c.state_id = '$id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
	function club_registration()
	{
		$data = array();
		$this->db->trans_begin();
		$otp = random_string('numeric', 5);
		/*$datas = array(
			'name' => $this->input->post('cl_reg_name'),
			'phone' => $this->input->post('cl_reg_mobile'),
			'email' => $this->input->post('cl_reg_mail'),
			'otp' => $otp,
            'profile_image' =>'profile.png',
			'reg_otp_status' => 0
			);*/
		$datas = array(
			'club_type_id' => $this->input->post('club_plan'),
			'name' => $this->input->post('cl_reg_name'),
			'phone' => $this->input->post('cl_reg_mobile'),
			'email' => $this->input->post('cl_reg_mail'),
			'otp' => $otp,
                        'profile_image' =>'profile.png',
			'reg_otp_status' => 0
			);
		$qry = $this->db->insert('gp_normal_customer', $datas);
		$insert_id = $this->db->insert_id();
                $data2 = array(
                   'customer_id' => $insert_id
                );
                $qry2 = $this->db->insert('gp_customer_additional_info', $data2);
		$userLogin = array(
			'mobile' => $this->input->post('cl_reg_mobile'),
			'email' => $this->input->post('cl_reg_mail'),
			'user_id' => $insert_id,
			'password' =>  encrypt_decrypt('encrypt',$this->input->post('cl_reg_pass')),//encrypt($this->input->post('cl_reg_pass')),
			'type' => 'club_member'//'type' => 'normal_customer'
			); 
		$qry_login = $this->db->insert('gp_login_table', $userLogin);
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
                     $this->db->trans_rollback();
        	     $data['status'] = FALSE;
                } else {
                     $this->db->trans_commit();
                     $data['status'] = TRUE;
                     $info = array('user_id' => $insert_id,
			            'otp' => $otp
			            	);
                     $data['info'] = $info;
               }
        return $data;
	}
	function otp_validate_reg()
	{
		$this->db->trans_begin();
		$data = array();
		$otp = $this->input->post('otp_reg_confirm');
		$phone = $this->input->post('otp_reg_phone');
		$email = $this->input->post('otp_reg_email');
		$qry = "SELECT * from gp_normal_customer c where c.otp = '$otp' and (c.email = '$email' or c.phone = '$phone')";
		$qry = $this->db->query($qry);

		if($qry->num_rows()>0)
		{

			$user_details = $qry->row_array();
			$user_id = $user_details['id'];
			$qry_res = "SELECT * from gp_login_table tb where tb.user_id = '$user_id' and tb.type = 'normal_customer'";
			$qry_res = $this->db->query($qry_res);
            //var_dump($this->db->last_query());exit;
			if($qry_res->num_rows()>0)
			{
				$login_details = $qry_res->row_array();
				$login_id = $login_details['id'];

				$update_status = array('otp_status' => 1,'type' => 'club_member');
				$this->db->where('id', $login_id);
				$upqry = $this->db->update('gp_login_table', $update_status);


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
				$this->db->trans_complete();
				$data['info'] =  $login_details;
				$data['status'] = TRUE;
			} else{
				$data['info'] =  array();
				$data['status'] = FALSE;
			}
		}
		return $data;		
	}
        function otp_validate_club_reg()
	{
		$this->db->trans_begin();
		$data = array();
		$otp = $this->input->post('otp_reg_confirm');
		$phone = $this->input->post('otp_reg_phone');
		$email = $this->input->post('otp_reg_email');
		$qry = "SELECT * from gp_normal_customer c where c.otp = '$otp' and (c.email = '$email' or c.phone = '$phone')";
		$qry = $this->db->query($qry);

		if($qry->num_rows()>0)
		{

			$user_details = $qry->row_array();
			$user_id = $user_details['id'];
			$qry_res = "SELECT * from gp_login_table tb where tb.user_id = '$user_id' and tb.type = 'club_member'";
			$qry_res = $this->db->query($qry_res);
			if($qry_res->num_rows()>0)
			{
				$login_details = $qry_res->row_array();
				$login_id = $login_details['id'];

				$update_status = array('otp_status' => 1,'type' => 'club_member');
				$this->db->where('id', $login_id);
				$upqry = $this->db->update('gp_login_table', $update_status);


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
				$this->db->trans_complete();
				$data['info'] =  $login_details;
				$data['status'] = TRUE;
			} else{
				$data['info'] =  array();
				$data['status'] = FALSE;
			}
		}
		return $data;
	}
	function become_club_member()
	{
		$session_array1 = $this->session->userdata('logged_in_user');
		$session_array2 = $this->session->userdata('logged_in_club_member');
		if($session_array1){
		  $id = $session_array1['user_id'];
		  $log_id = $session_array1['id'];
		}else{
		  $id = $session_array2['user_id'];
		  $log_id = $session_array2['id'];
		}
		
		$club_plan = $this->input->post('club_plan');
		$this->db->trans_begin();
		$data = array('club_type_id' => $this->input->post('club_plan'));
		$this->db->where('id', $id);
		$upqry = $this->db->update('gp_normal_customer', $data);

		$qry_amount = $this->db->query("select id, amount from club_member_type where id = '$club_plan'");
		if($qry_amount->num_rows()>0)
		{
			$get_clubdetails = $qry_amount->row_array();
			$get_amount = $get_clubdetails['amount'];
			
		}else{
			$get_clubdetails = array();
			$get_amount = 0;
		}


		$qry_login = "select * from gp_login_table where user_id = '$id' and type = 'normal_customer'";
		$qry_login = $this->db->query($qry_login);
		if($qry_login->num_rows()>0)
		{
			$get_details = $qry_login->row_array();
			$login_id = $get_details['id'];
			$wallete = array('wallet_type_id' => 1,
						'user_id' => $login_id,
						'total_value' => $get_amount
					);
			$qry3 = $this->db->insert('gp_wallet_values', $wallete);
		}else{
			$get_details = array();
		     $this->db->set('total_value', 'total_value + ' . (float) $get_amount, FALSE);
                     $this->db->where('user_id', $log_id);
                     $this->db->where('wallet_type_id', 1);
                     $this->db->update('gp_wallet_values');
		}
		
		$up_data = array('type' => 'club_member');
		$this->db->where('user_id', $id);
		$this->db->where('type', 'normal_customer');
		$qry = $this->db->update('gp_login_table', $up_data);

		$qry2 = "select lg.*,nc.club_type_id,lg.type from gp_login_table lg left join gp_normal_customer nc on lg.user_id=nc.id where (lg.id='$log_id' and lg.type = 'club_member')";
		$qry2 = $this->db->query($qry2);
		if($qry2->num_rows()>0)
		{
			$data = $qry2->row_array();
		}else{
			$data =array();
		}
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        
        	return FALSE;
        } else {
            $this->db->trans_commit();

            return $data;
            
        }

	}
	function checkGoogleUser($data = array())
	{
		$this->db->select('*');
		$this->db->from('gp_login_table');
		$this->db->where(array('oauth_provider'=>$data['oauth_provider'],'oauth_uid'=>$data['oauth_uid']));
		$prevQuery = $this->db->get();
		$prevCheck = $prevQuery->num_rows();
		
		if($prevCheck > 0){
			$prevResult = $prevQuery->row_array();
			
			$userid = $prevResult['id'];


   			


			$info = array(
		    		'email' => $data['email'],
		    		'updated_on' => date("Y-m-d H:i:s"),
		    		'name' => $data['first_name'],
		    		'profile_image' => $data['picture_url'],
		    		'updated_on' => date("Y-m-d H:i:s")
		    		); 
		    	$this->db->where('oauth_provider', $data['oauth_provider']);
		    	$this->db->where('oauth_uid', $data['oauth_uid']);
		    	$this->db->update('gp_normal_customer', $info);

		    	$details = array(
		    		'email' => $data['email']
		    		);
		    	$this->db->where('oauth_provider', $data['oauth_provider']);
		    	$this->db->where('oauth_uid', $data['oauth_uid']);
		    	$this->db->update('gp_login_table', $details);

		    	$ret = array();
		    	$ret['id'] = $userid;
		    	$ret['type'] = $prevResult['type'];
		    	$ret['email'] = $prevResult['email'];
		    	$ret['mobile'] = $prevResult['mobile'];
		    	$ret['user_id'] = $prevResult['user_id'];
		    	$ret['login'] = TRUE;
		    	return $ret;
		}else{
			$info = array(
		    		'email' => $data['email'],
		    		'name' => $data['first_name'],
		    		'profile_image' => $data['picture_url'],
		    		'oauth_provider' => $data['oauth_provider'],
		    		'oauth_uid' => $data['oauth_uid'],
		    		'created_on' => date("Y-m-d H:i:s")
		    		); 
		    	
		    	$this->db->insert('gp_normal_customer', $info);
		    	$ins_id = $this->db->insert_id();
		       
		       $details = array(
		    		'email' => $data['email'],
		    		'type' => 'normal_customer',
		    		'oauth_provider' => $data['oauth_provider'],
		    		'oauth_uid' => $data['oauth_uid'],
		    		'user_id' => $ins_id
		    		);
		       $this->db->insert('gp_login_table', $details);
		       $log_id = $this->db->insert_id();

		       $wallete = array(
							array('wallet_type_id' => 2,
									'user_id' => $log_id,
									'total_value' => 0
									),
							array('wallet_type_id' => 4,
									'user_id' => $log_id,
									'total_value' => 0
									)
							);
				$qry3 = $this->db->insert_batch('gp_wallet_values', $wallete);

				$ret = array();
		    	$ret['id'] = $log_id;
		    	$ret['type'] = 'normal_customer';
		    	$ret['email'] = $data['email'];
		    	$ret['mobile'] = '';
		    	$ret['user_id'] = $ins_id;
		    	$ret['login'] = TRUE;
		    	return $ret;
		}
		//return TRUE;
		
	}
	/* Club Agent */
	function add_club_agent($data)
	{
		$session_array = $this->session->userdata('logged_in_user');
		$id = $session_array['user_id'];
		$log_id = $session_array['id'];

		$this->db->trans_begin();
		$otp = random_string('numeric', 5);
		$datas = array(
			'name' => $data['name'],
			'phone' => $data['mobile'],
			'email' => $data['email'],
			'otp' => $otp,
            'profile_image' =>'profile.png',
            'ca_docs'=>isset($data['file'])?$data['file']:'',
			'reg_otp_status' => 0,
			'created_by'=>$log_id
			);
		$qry = $this->db->insert('gp_normal_customer', $datas);
		$insert_id = $this->db->insert_id();
        $data2 = array(
            'customer_id' => $insert_id,
            'lastname' => $data['name']
        );
        $qry2 = $this->db->insert('gp_customer_additional_info', $data2);
        $data3 = array(
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'user_id' =>$insert_id,
            'type' => 'club_agent',
            'otp_status' => 0,
            // 'parent_login_id'=>$log_id
        );
        $qry3 = $this->db->insert('gp_login_table', $data3);


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
	function get_ca_details($id)
	{
		$qry_res = "SELECT tb.*,nc.club_type_id,nc.otp from gp_login_table tb left join gp_normal_customer nc on tb.user_id=nc.id where tb.user_id = '$id' and tb.type = 'club_agent'";
		$qry_res = $this->db->query($qry_res);
		if($qry_res->num_rows()>0)
		{
			return $login_details = $qry_res->row_array();
		}else{
			return false;
		}
	}
	function validate_password($password)
	{
		$qry_res = "SELECT tb.* from gp_login_table tb where tb.password = '$password'";
		$qry_res = $this->db->query($qry_res);
		if($qry_res->num_rows()>0)
		{
			$data['status'] = FALSE;
		}else{
			$data['status'] = TRUE;
		}
		return $data;
	}
	function validate_mail($email,$id)
	{
		$data = array();
		$qry = "select * from gp_login_table where email = '$email' and (type = 'club_member' or type = 'normal_customer' or type = 'club_agent')and id !=$id";
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
	function  check_current_pwd($id,$password)
	{
		$pwd = encrypt_decrypt('encrypt',$password);
		$qry_res = "SELECT tb.* from gp_login_table tb where tb.password = '$pwd' and tb.id='$id'";
		$qry_res = $this->db->query($qry_res);
		if($qry_res->num_rows()>0)
		{
			$data['status'] = TRUE;
		}else{
			$data['status'] = FALSE ;
		}
		return $data;
	}
	function update_password($password,$id)
	{
		$this->db->trans_begin();
		$pwd =  encrypt_decrypt('encrypt',$password);

		$data=array('password'=>$pwd);
        $this->db->where('id',$id);
        $this->db->update('gp_login_table',$data);
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
	}
	function add_normal_customer()
	{
		$data = array();
		$session_array = $this->session->userdata('logged_in_user');
		$id = $session_array['user_id'];
		$log_id = $session_array['id'];

		$this->db->trans_begin();
		$otp = random_string('numeric', 5);
		$datas = array(
			'name' => $this->input->post('name'),
			'phone' => $this->input->post('mobile'),
			'email' => $this->input->post('email'),
			'otp' => $otp,
            'profile_image' =>'profile.png',
			'reg_otp_status' => 0,
			'created_by'=>$log_id ,
			'created_on'=> date("Y-m-d H:i:s")
			);
		$qry = $this->db->insert('gp_normal_customer', $datas);
		$insert_id = $this->db->insert_id();
        $data2 = array(
            'customer_id' => $insert_id
        );
        $qry2 = $this->db->insert('gp_customer_additional_info', $data2);
        $data3 = array(
            'email' =>$this->input->post('email'),
            'mobile' => $this->input->post('mobile'),
            'user_id' =>$insert_id,
            'type' => 'normal_customer',
            'otp_status' => 0,
            // 'parent_login_id'=>$log_id
        );
        $qry3 = $this->db->insert('gp_login_table', $data3);

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        	$data['status'] = FALSE;
        } else {
            $this->db->trans_commit();
            $data['status'] = TRUE;
            $info = array('user_id' => $insert_id,'otp' => $otp);
            $data['info'] = $info;
        }
        return $data;
	}
	function check_otp_validate($otp)
	{
		$qry = "SELECT c.*,lt.otp_status from gp_normal_customer c left join gp_login_table lt on c.id=lt.user_id where c.otp = '$otp' AND otp_status=0";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			return $qry->row_array();
		} else{
			
			return  FALSE;
		}	
		
	}
	function customer_signup($data)
	{
		$this->db->trans_begin();
		$otp = random_string('numeric', 5);
		$datas = array(
			'name' => $data['name'],
			'phone' => $data['mobile'],
			'email' => $data['email'],
			'reg_otp_status' =>1
			);
		$this->db->where('id',$data['id']);
		$qry = $this->db->update('gp_normal_customer', $datas);
        $data3 = array(
            'email' =>$data['email'],
            'mobile' => $data['mobile'],
            'password' =>encrypt_decrypt('encrypt',$data['password']),
            'type' => 'normal_customer',
            'otp_status' => 1,
            'parent_login_id'=> $data['created_by']
        );
        $this->db->where('user_id',$data['id']);
        $qry3 = $this->db->update('gp_login_table', $data3);
        $data2 = array(
            'email' =>$data['email'],
            'name' => $data['name'],
            'referrer_id' => $data['created_by']
        );
        $qry3 = $this->db->insert('gp_user_referrel', $data2);
 
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
}
?>