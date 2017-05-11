<?php
/**
* 
*/
class Wallet_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
        $this->load->database();
	}
	function get_wallet_activity()
	{
		$session_array = $this->session->userdata('logged_in_admin');
		$logid = $session_array['id'];
		$qry = "select
				a.wallet_type_id,
				t.title title_a,
				v.wallet_type_id,
				tt.title title_b,
				a.wallet_val_id,
				TRUNCATE(a.change_value,2) as value,
				a.description,
				a.user_id,
				DATE_FORMAT(a.date_modified, '%d-%b-%Y') as modified
				from
				gp_wallet_activity a 
				left join gp_wallet_types t on t.id = a.wallet_type_id
				left join gp_wallet_values v on v.id = a.wallet_val_id
				left join gp_wallet_types tt on tt.id = v.wallet_type_id
				where v.user_id = $logid or a.user_id = $logid
				order by a.date_modified desc";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		}	else{
			return array();
		}	
	}
}
?>