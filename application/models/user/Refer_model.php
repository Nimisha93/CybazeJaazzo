<?php
/**
* 
*/
class Refer_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function refer_validation($mail1,$mail2,$mob1,$mob2)
	{	$mobile='start';$email='start';
        // print_r($mail1);print_r($mail2);print_r($mob1);print_r($mob2); exit();
		// if(!preg_match("/^[0-9]*$/",$mob1) && strlen($mob1)!= 10)
		// echo $mob1; exit();
		if($mail1 != $mail2 && $mob1 != $mob2){
		if(preg_match("/^[0-9]*$/",$mob1) && strlen($mob1)== 10)
		{
		$mobile='true';
		// echo "m1t"; exit();
		if($mob2 !=null){
						if(preg_match("/^[0-9]*$/",$mob2) && strlen($mob2)== 10)
						{
						$mobile='true';
						}
						else
							{
							$mobile='false';
							}
						}
		}				
		else
		{
		// echo "m1f"; exit();
		$mobile='false';
		}
			if (!filter_var($mail1, FILTER_VALIDATE_EMAIL) === false) 
			{
		    $email='true';
			// echo "e1t"; exit();
		    if($mail2 !=null)
		    	{
				if (!filter_var($mail2, FILTER_VALIDATE_EMAIL) === false) 
					{
					// echo "e2t"; exit();
		    		$email='true';
					} 
					else
			    		{
						// echo "e2f"; exit();
						$email='false';
						}
				}
			} 
			else
			    {
				$email='false';
				// echo "e1f"; exit();
				}
		}
		else
		{
			if($mail1 == $mail2 && $mob1 == $mob2){ $mobile = 'same'; $email = 'same'; }
				elseif($mail1 == $mail2){ $email = 'same'; }
					elseif($mob1 == $mob2){ $mobile = 'same'; }
		}
		// echo $mobile; echo $email; exit();
		if($mobile == 'same' && $email == 'same'){ return 'bothsame'; }
		elseif($mobile == 'same'){ return 'mobsame'; }
		elseif($email == 'same'){ return 'mailsame'; }
		elseif($mobile == 'true' && $email == 'true'){ return 'bothtrue'; }
		elseif($mobile == 'false' && $email == 'false'){ return 'bothfalse'; }
		elseif($mobile == 'false'){ return 'mobfalse'; }
		elseif($email == 'false'){ return 'mailfalse'; }
	}
	function refer_exists($mail1,$mail2,$mob1,$mob2)
	{
        // print_r($mail1);print_r($mail2);print_r($mob1);print_r($mob2); 
        // exit();
		// $qry = "select id from gp_user_referrel where refer = '$refer'";
		$qry = "select id from gp_user_referrel where email = '$mail1' OR email = '$mail2' OR altemail = '$mail1' OR altemail = '$mail2' OR mobile = '$mob1' OR mobile = '$mob2'
		 OR altmobile = '$mob1' OR altmobile = '$mob2' UNION select id from gp_login_table where email = '$mail1' OR email = '$mail2' OR mobile = '$mob1' OR email = '$mob2'";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{   $a=0;$b=0;$c=0;$d=0;
			$qry1 = "select id from gp_user_referrel where email = '$mail1' or altemail = '$mail1' UNION select id from gp_login_table where email = '$mail1'";
			$qry1 = $this->db->query($qry1);
			if($qry1->num_rows()>0)
			{ $a=1; }
			$qry2 = "select id from gp_user_referrel where email = '$mail2' or altemail = '$mail2' UNION select id from gp_login_table where email = '$mail2'";
			$qry2 = $this->db->query($qry2);
			if($qry2->num_rows()>0)
			{ $b=1; }
			$qry3 = "select id from gp_user_referrel where mobile = '$mob1' or altmobile = '$mob1' UNION select id from gp_login_table where mobile = '$mob1'";
			$qry3 = $this->db->query($qry3);
			if($qry3->num_rows()>0)
			{ $c=1; }
			$qry4 = "select id from gp_user_referrel where mobile = '$mob2' or altmobile = '$mob2' UNION select id from gp_login_table where mobile = '$mob2'";
			$qry4 = $this->db->query($qry4);
			if($qry4->num_rows()>0)
			{ $d=1; }
		// echo $a,$b,$c,$d; exit();
		// return $a,$b,$c,$d;
		if($a == 1 && $b == 1 && $c == 1 && $d == 1){ return 'allerror'; }
		elseif($a == 1 && $b == 0 && $c == 0 && $d == 0){ return '1'; }
		elseif($a == 0 && $b == 1 && $c == 0 && $d == 0){ return '2'; }
		elseif($a == 0 && $b == 0 && $c == 1 && $d == 0){ return '3'; }
		elseif($a == 0 && $b == 0 && $c == 0 && $d == 1){ return '4'; }
		elseif($a == 1 && $b == 1 && $c == 0 && $d == 0){ return '5'; }
		elseif($a == 1 && $b == 0 && $c == 1 && $d == 1){ return '6'; }
		elseif($a == 1 && $b == 0 && $c == 1 && $d == 0){ return '7'; }
		elseif($a == 1 && $b == 0 && $c == 0 && $d == 1){ return '8'; }
		elseif($a == 0 && $b == 1 && $c == 1 && $d == 0){ return '9'; }
		elseif($a == 0 && $b == 1 && $c == 0 && $d == 1){ return '10'; }
		elseif($a == 1 && $b == 1 && $c == 1 && $d == 0){ return '11'; }
		elseif($a == 1 && $b == 1 && $c == 0 && $d == 1){ return '12'; }
		elseif($a == 1 && $b == 0 && $c == 1 && $d == 1){ return '13'; }
		elseif($a == 0 && $b == 1 && $c == 1 && $d == 1){ return '14'; }
		else{ return 'error'; }
		} 
		else
			{ 
			// echo "string"; exit();
			return 'allok';
			}
	}
	function refer($name,$mail1,$mail2,$mob1,$mob2,$lid)
	{	
	    $created_on = date("h:i:sa");
		$data=array(            
            'referrer_id'=>$lid,
            'name'=>$name,
            'email'=>$mail1,
            'altemail'=>$mail2,
            'mobile'=>$mob1,
            'altmobile'=>$mob2,
            'status' =>"0",
            'created_by' => $lid,
            'created_on' => $created_on
        );
        $this->db->insert('gp_user_referrel',$data);
    	$this->db->trans_complete();
    	if( $this->db->trans_status()===false){
	    	$this->db->trans_rollback();
	    	return false;
	    }
	    else{
	        $this->db->trans_commit();
	    	return true;
	    }
	}
	function get_refer($login_id)
	{
		$qry = " select * from gp_user_referrel
				where referrer_id = $login_id ";
		$qry = $this->db->query($qry, $login_id);
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		} else{
			return array();
		}		
	}
	function get_child($login_id)
	{
		$qry = " select lt.*,nc.name,nc.profile_image from gp_login_table lt
				join gp_normal_customer nc on lt.user_id = nc.id
				where lt.parent_login_id = $login_id ";
		$qry = $this->db->query($qry, $login_id);
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		} else{
			return array();
		}		
	}
	function get_wallete_values_user($login_id)
	{
		$qry = "select
				wal.id,
				wal.wallet_type_id,
				typ.title,
				wal.user_id,
				wal.total_value
				from
				gp_wallet_values wal

				left join gp_wallet_types typ on  typ.id = wal.wallet_type_id
				where wal.user_id = ?
				order by typ.title asc";
		$qry = $this->db->query($qry, $login_id);
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		} else{
			return array();
		}		
	}
	function get_channel_partner()
	{
		$qry = "select
				con.id as con_id,
				cp.name,
				cp.phone,
				typ.title as shope_type,
				typ.`status`
				from
				gp_pl_channel_partner_type_connection con

				left join gp_pl_channel_partner cp on cp.id = con.channel_partner_id
				left join gp_pl_channel_partner_types typ on typ.id = con.channel_partner_type_id";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		} else{
			return array();
		}	

	}


	function get_totel_wallete_amount($login_id)
    {

		$qry= "select walv.total_value FROM gp_login_table logg 
		LEFT JOIN gp_wallet_values walv on walv.user_id=logg.id and walv.wallet_type_id='4' 
		where logg.id='$login_id'";
		
	    $query= $this->db->query($qry);
			if($query->num_rows()>0)
			{
				$data['amount'] =$query->row_array();
			} else{
				$data['amount'] =array();
			}	
			return $data;
	}

	function transfer_phone($reg_phone)
	{
           $qry= "select logg.id  FROM gp_login_table logg where  logg.mobile='$reg_phone'";
			$query=$this->db->query($qry);
			if($query->num_rows()>0)
			{
				return $query->row_array();
			} else{
				return array();
			}	
	}
    function transfer_amount($userid,$reg_amount,$login_id )
    {

        $qry= "select walv.id  FROM gp_wallet_values walv where walv.user_id='$login_id' and walv.total_value >= '$reg_amount'  and walv.wallet_type_id = '4'";
		$query=$this->db->query($qry);
		//echo $this->db->last_query();exit;
		if($query->num_rows()>0)
		{
			$this->transfer_result($userid,$reg_amount,$login_id );
			return true;
		} else{
			return array();
		}	
    }
	function transfer_result($userid,$reg_amount,$login_id)
	{

		
	    $this->db->trans_begin();
	    $rec_qry="update `gp_wallet_values` set total_value=total_value + '$reg_amount' where user_id='$userid' and wallet_type_id = '4'";

	    $recquery=$this->db->query($rec_qry);

	    $send_qry="update `gp_wallet_values` set total_value=total_value - '$reg_amount' where user_id='$login_id' and wallet_type_id = '4'";

	    $query=$this->db->query($send_qry);
	    $created_on= date('Y-m-d H:i:s');

  		$data=array(
            
            'form_id'=>$login_id,
            'to_id'=>$userid,
            'amount'=>$reg_amount,
            'status' =>"1",
            'created_by' => $login_id,
            'created_on' => $created_on
        );
        $this->db->insert('gp_payment_transfer',$data);
    	$this->db->trans_complete();
	    if( $this->db->trans_status()===false){
	    	$this->db->trans_rollback();
	    	return false;

	    }
	    else{
	        $this->db->trans_commit();
	    	return true;
	    }
	}		


}

?>