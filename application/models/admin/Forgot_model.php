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
		$query = "select * from gp_login_table where email='$username' and type in ('Channel_partner','super_admin','executive')  and is_del = 0";
		$query = $this->db->query($query, $username);

	             	
		if($query->num_rows()>0)
		{
			return $query->row_array();
		} else
		{
			return false;
		}
	}


	 function add_random_string($random, $uname)
    {
        $data = array('random_key' => $random, 'random_date' => date("Y-m-d h:i:s"));
        $this->db->where('email', $uname);
        $qry = $this->db->update('gp_login_table', $data);
        return $qry;
    }

    function validate_user_with_random_key($username, $random)
    {
         $query = "select * from gp_login_table c where c.email = '$username' and c.random_key = '$random'";
        $query = $this->db->query($query);
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
	
	
	 function change_pwd($username,$password,$random)
    {
        $data = array('password' => $password,
             'random_key' => ''
            );
        $this->db->where('email', $username);
        $qry = $this->db->update('gp_login_table', $data);
        return $qry;
    }
    
	}


 
    

?>