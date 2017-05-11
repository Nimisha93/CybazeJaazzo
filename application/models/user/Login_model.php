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
	function validate_login()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$qry = "select * from gp_login_table lg where (lg.email = '$username' or lg.mobile = '$username') and lg.password = '$password' and lg.otp_status = 1 and (lg.type ='normal_customer' or lg.type = 'club_member')";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			return $qry->row_array();
		}else{
			return array();
		}
	}
}
?>