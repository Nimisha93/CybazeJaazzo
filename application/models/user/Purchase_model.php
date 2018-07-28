<?php 
/**
* 
*/
class Purchase_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function give_notification()
	{
		$this->db->trans_begin();
		$wallet_price = $this->input->post('price');
		$wallet_id =  $this->input->post('wallet_id');
		$customer = $this->input->post('login_id');

		$sum = 0;
		if($wallet_price){
			foreach ($wallet_price as $key => $price) {
				$price = ($price=='')? 0 : $price;
				$sum += $price;
			}
		}
		$data = array(
			'channel_partner_id' =>  $this->input->post('channel_partner_id'),
			'login_id' => $this->input->post('login_id'),
			// 'bill_total' => $this->input->post('total_bill_amount'),
			'wallet_total' => $sum,
			'purchased_on' => date('Y-m-d H:i:s'),
			'status' => 0
			);
		$qry = $this->db->insert('gp_purchase_bill_notification', $data);
        //echo $this->db->last_query();exit;
		$insert_id = $this->db->insert_id();
        //var_dump($insert_id);
		if($wallet_price){
			foreach ($wallet_price as $key => $wallet_amt) {
				$noty[] = array(
					'bill_notification_id' => $insert_id,
					'wallet_id' => $wallet_id[$key],
					'wallet_value' => $wallet_amt
					);
			}
			$this->db->insert_batch('gp_purchase_bill_noty_wallet_items', $noty);
		}else{
			$data2 = array(
				'bill_notification_id' => $insert_id,
				);
			$qry2 = $this->db->insert('gp_purchase_bill_noty_wallet_items', $data2);
		}
       //echo $this->db->last_query();exit;
		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        	return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
		
	}
	function check_bal_in_wallet()
	{
		$data = array();
		$wallet_price = $this->input->post('price');
		$wallet_id =  $this->input->post('wallet_id');
		foreach ($wallet_id as $key => $walt) {
			$price = $wallet_price[$key];
			$wal_qry = "select * from gp_wallet_values where id = '$walt' and total_value >= '$price'";
			$wal_qry = $this->db->query($wal_qry);
            // echo $this->db->last_query();
			if($wal_qry->num_rows()>0)
			{
				$data['status'] = TRUE;
			} else{
				$data['status'] = FALSE;
			}
		}
		return $data;
	}
	function get_total_wallet_amount_customer()
	{
		$data = getLoginId();
        if($data){
            $login_id = $data['login_id'];
			$qry = "select sum(wl.total_value) as_total
					from gp_wallet_values wl
					where wl.user_id = '$login_id'";
			$qry = $this->db->query($qry);
	      //  echo $this->db->last_query();
			if($qry->num_rows()>0)
			{
				return $qry->row_array();
			}else
			{
				return array();
			}
		}else{
			return array();
		}
	}
}
?>