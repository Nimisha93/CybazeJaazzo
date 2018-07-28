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
	function get_wallet_overview()
	{
		$data =array();
		$session_array = $this->session->userdata('logged_in_admin');
		$logid = $session_array['id'];
		$qry1 = "SELECT SUM(wv.total_value)as total_value FROM `gp_wallet_values` wv left join gp_login_table log on wv.user_id=log.id left join gp_pl_channel_partner cp ON log.user_id=cp.id where log.type='Channel_partner' and wv.wallet_type_id='4'";
		$qry1 = $this->db->query($qry1);
		if($qry1->num_rows()>0)
		{
			$res1 =  $qry1->row_array();
			$data['channel']= $res1['total_value'];
		}else{
			$data['channel']= '0' ;
		}
		$qry2 = "SELECT ROUND(SUM(wv.total_value),2)as total_value FROM `gp_wallet_values` wv left join gp_login_table log on wv.user_id=log.id where log.type='executive' and wv.wallet_type_id='3'";
		$qry2 = $this->db->query($qry2);
		if($qry2->num_rows()>0)
		{
			$res2 =  $qry2->row_array();
			$data['executive']= $res2['total_value'];
		}else{
			$data['executive']= '0' ;
		}
		$qry3 = "SELECT ROUND(SUM(wv.total_value),2)as total_value FROM `gp_wallet_values` wv left join gp_login_table log on wv.user_id=log.id where log.type='normal_customer' and (wv.wallet_type_id='2')";
		$qry3 = $this->db->query($qry3);
		if($qry3->num_rows()>0)
		{
			$res3 =  $qry3->row_array();
			$data['customers']= $res3['total_value'];
		}else{
			$data['customers']= '0' ;
		}
		$qry4 = "SELECT ROUND(SUM(wv.total_value),2)as total_value FROM `gp_wallet_values` wv left join gp_login_table log on wv.user_id=log.id where log.type='normal_customer' and (wv.wallet_type_id='4')";
		$qry4 = $this->db->query($qry4);
		if($qry4->num_rows()>0)
		{
			$res4 =  $qry4->row_array();
			$data['customers_mywallet']= $res4['total_value'];
		}else{
			$data['customers_mywallet']= '0' ;
		}
		return $data;	
	}
	function get_wallet_count($search)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (nc.name LIKE '%$keyword%' OR t.title LIKE '%$keyword%' OR tt.title LIKE '%$keyword%' OR a.wallet_val_id LIKE '%$keyword%' OR a.description LIKE '%$keyword%' OR DATE_FORMAT(a.date_modified, '%d-%b-%Y') LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $query="select
				t.title title_a,nc.name,
				tt.title title_b,
				a.wallet_val_id,
				TRUNCATE(a.change_value,2) as value,
				a.description,
				DATE_FORMAT(a.date_modified, '%d-%b-%Y') as modified
				from
				gp_wallet_activity a 
				left join gp_wallet_types t on t.id = a.wallet_type_id
				left join gp_wallet_values v on v.id = a.wallet_val_id				
                left join gp_login_table log on v.user_id=log.id
                left join gp_normal_customer nc on log.user_id=nc.id
				left join gp_wallet_types tt on tt.id = v.wallet_type_id".$where." order by a.date_modified desc";
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
          return $result->num_rows();
        } else{
          return false;
        }
    }
    function get_wallets($search,$limit=NULL,$start=NULL)
    {        
      	if(!empty($search)){
          $keyword = "%{$search}%";
          $where = "  WHERE (nc.name LIKE '%$keyword%' OR t.title LIKE '%$keyword%' OR tt.title LIKE '%$keyword%' OR a.wallet_val_id LIKE '%$keyword%' OR a.description LIKE '%$keyword%' OR DATE_FORMAT(a.date_modified, '%d-%b-%Y') LIKE '%$keyword%')";
      	}else{
          $where = '';
      	}
      	if(!is_null($start)&&!is_null($limit)){
          $pg = " LIMIT $start, $limit";
      	}else{
          $pg = "";
      	}
      	$query="select
				t.title title_a,nc.name,
				tt.title title_b,
				a.wallet_val_id,
				TRUNCATE(a.change_value,2) as value,
				a.description,
				DATE_FORMAT(a.date_modified, '%d-%b-%Y') as modified
				from
				gp_wallet_activity a 
				left join gp_wallet_types t on t.id = a.wallet_type_id
				left join gp_wallet_values v on v.id = a.wallet_val_id
                left join gp_login_table log on v.user_id=log.id
                left join gp_normal_customer nc on log.user_id=nc.id
				left join gp_wallet_types tt on tt.id = v.wallet_type_id".$where." order by a.date_modified desc".$pg;
      	$result=$this->db->query($query);
      	if($result->num_rows()>0)
      	{
          return $result->result_array();
      	}else
      	{
          return array();
      	}
    }
}
?>