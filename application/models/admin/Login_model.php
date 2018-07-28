<?php
/**
* 
*/
class Login_model extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}
	function validate_login()
	{
		$username = $this->input->post('username');
		$password = encrypt_decrypt('encrypt',$this->input->post('password'));
		//echo $password;exit();
		$data = array();
		  $qry = "select 
				u.id,u.email,u.mobile,u.password,u.type,u.user_id,sm.sales_desig_type_id as desig
				from gp_login_table u
				left join gp_pl_sales_team_members sm on u.user_id=sm.id
				left join gp_pl_channel_partner p on u.user_id = p.id 
				where (u.email = '$username' or u.mobile='$username')
				and u.password = '$password' and u.type in ('super_admin','channel_partner','executive','Employee','ba')
				and u.is_del = 0 and (u.type!='Channel_partner' or p.is_del=0)";
		$qry = $this->db->query($qry);
		//echo $this->db->last_query();exit();
		if($qry->num_rows()>0)
		{
			$data['status'] = true;
			$data['data'] = $qry->row_array();
			$date = date("Y-m-d h:i:sa") ;
			$action = "logged";
			$userid = $data['data']['id'];
			$status = 0;

			activity_log($action,$userid,$status,$date);
			
		}	else{
			$data['status'] = false;
			$data['data'] = array();
		}
			
		return $data;
	}
	function validate_login_cp()
	{
		$username = $this->input->post('username');
		$password = encrypt_decrypt('encrypt',$this->input->post('password'));
		$data = array();
		$qry = "select 
				u.id,u.email,u.mobile,u.password,u.type,u.user_id
				from
				gp_login_table u
				where (u.email = '$username' or u.mobile='$username')
				and u.password = '$password'
				and u.is_del = 0 and u.type = 'Channel_partner'";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			$data['status'] = true;
			$data['data'] = $qry->row_array();
			 $date = date("Y-m-d h:i:sa") ;
			$action = "logged";
			$userid = $data['data']['id'];
			$status = 0;

			activity_log($action,$userid,$status,$date);
			
		}	else{
			$data['status'] = false;
			$data['data'] = array();
		}
			
		return $data;
	}
	function get_school_details_by_id($id)
	{
		$qry = "select * from schools where id = '$id'";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			return $qry->row_array();
		} else
		{
			return array();
		}
	}
	function get_teacher_details_by_id($id)
	{
		$qry = "select * from teachers where id = '$id'";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			return $qry->row_array();
		} else
		{
			return array();
		}
	}
	function validate_user($username)
	{
		$query = "select * from users u where u.username = ?";
		$query = $this->db->query($query, $username);
		//echo $this->db->last_query();exit;
		if($query->num_rows()>0)
		{
			return $query->row_array();
		} else
		{
			return false;
		}
	}
	function update_password($pass, $uname)
	{
		$data = array('password' => $pass);
		$this->db->where('username', $uname);
		$qry = $this->db->update('users', $data);
		
		//echo $this->db->last_query();exit;
		return $qry;
	}
}
?>