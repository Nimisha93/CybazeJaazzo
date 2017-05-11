<?php
/**
* 
*/
class Forgot_model extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}

function validate_user($username)
	{
		$query = "select * from gp_login_table where email='$username' or mobile='$username'";
		$query = $this->db->query($query, $username);

	             	
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
		$this->db->where('email', $uname);
		$this->db->or_where('mobile', $uname);
		$qry = $this->db->update('gp_login_table', $data);
		
		//echo $this->db->last_query();exit;
		return $qry;
	}
	}


 
    

?>