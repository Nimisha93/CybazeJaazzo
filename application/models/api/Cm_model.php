<?php 
/**
* 
*/
class Cm_model extends CI_Model
{
	
	function __construct()
    {
        parent:: __construct();
        $this->load->database();
    }
    function get_parent_login($lg_id)
    { 
        $data = array();
        $lg_id = ($lg_id==0)?1:$lg_id;
        $qry = "select * from gp_login_table lg where lg.id = '$lg_id'";       
        $lg_qry = $this->db->query($qry);
        if($lg_qry && $lg_qry->num_rows()>0)
        {
            $lg_result = $lg_qry->row_array();
            $parent_login_id = $lg_result['parent_login_id'];
            $typ = $lg_result['type'];
            $user_id = $lg_result['user_id'];
            if($typ=='executive'){
                $qryy = "SELECT st.*,typ.designation FROM `gp_pl_sales_team_members` st INNER JOIN gp_pl_sales_designation_type typ ON st.sales_desig_type_id=typ.id WHERE typ.add_exec='1' 
                    AND st.id='$user_id'";       
                $details = $this->db->query($qryy);
                if($details && $details->num_rows()>0)
                {
                    $result = $details->row_array(); 
                    $data['type'] = 'team_leader';
                }else{
                   $data['type'] = 'executive';
                } 

                $data['id'] = $lg_id;
                $data['parent_login_id'] = $parent_login_id;
            }else{
                if($typ=='club_member'){
                    $qry2 = "select lg.parent_login_id,nc.investor_type_id from gp_login_table lg left join gp_normal_customer nc
                    on lg.user_id=nc.id where lg.id = '$lg_id'";       
                    $lg_qry2 = $this->db->query($qry2);
                    if($lg_qry2 && $lg_qry2->num_rows()>0)
                    {
                        $result2 = $lg_qry2->row_array(); 
                        if($result2['investor_type_id']>0){
                            $data['type'] = 'tl';
                            $data['id'] = $lg_id;
                            $data['parent_login_id'] = $result2['parent_login_id'];
                        }
                    }
                }else{
                    $data['id'] = $lg_id;
                    if($typ=='super_admin'){
                        $data['type'] = 'admin';
                    }
                }

            }
                return $data;

        }
    }
    function get_club_benefit($p_id,$benfit,$wal_typ){
        $fy_year = get_current_financial_year();
        $fy_id = $fy_year['id'];
        $type = 'CUSTOMER';
        $this->db->set('total_value', 'total_value + ' . (float) $benfit, FALSE);
        $this->db->where('user_id',$p_id);
        $this->db->where('wallet_type_id', $wal_typ);
        $this->db->update('gp_wallet_values');
        //$wal_val_id =get_wallet_val_id($p_id,3);
        $wal_activitys = array(
            'wallet_type_id' => $wal_typ,
            //'wallet_val_id' => $wal_val_id,
            'user_id' => $p_id,
            'change_value' => $benfit,
            'type'=>'GAIN',
            'date_modified' => date('Y-m-d h:i:s'),
            'description' => 'benefit through club membership'
        );
        $this->db->insert('gp_wallet_activity', $wal_activitys);
        /*Dr start*/
        // $ledger_payment_dr = 72;
        // $entry_items_dr = array(
        //     'entry_id' => $entry_id,
        //     'ledger_id' => $ledger_payment_dr,
        //     'amount' => $benfit,
        //     'dc' => 'Dr',
        //     'fy_id' =>$fy_id,
        //     'created_date' => date('Y-m-d')
        // );
        // $entry_dr = $this->db->insert('erp_ac_entryitems', $entry_items_dr);
        /*Dr End*/
        return true;
    }
    function getAvailableClubTypes($id)
    {
        $det =array();
        $type = array(); 
        if(!ctype_digit($id)){
            $details = user_details_by_apikey($id);
            $id = $details['id'];
        }
        $qry = "select ty.club_type_id, ty.fixed_club_type_id, ty.investor_type_id from gp_normal_customer ty left join gp_login_table log on log.user_id = ty.id where log.id='$id' and ty.is_del = 0 and status = 'approved'";
        $qry = $this->db->query($qry);
      
        if($qry->num_rows()>0)
        {
            $res = $qry->row_array();
            
            if($res['club_type_id']>0){
               array_push($type, array('key'=>2 ,'value'=>'UNLIMITED'));
            }
            if($res['fixed_club_type_id']>0){
               array_push($type, array('key'=>1 ,'value'=>'FIXED'));
            }
            if($res['investor_type_id']>0){
               array_push($type, array('key'=>3 ,'value'=>'INVESTOR'));
            }
            return $type;
        }   else{
            return array();
        }
    }
    function be_club_member($api_key)
    {
    	$data = array();
		$this->db->trans_begin();
		$datas1 = user_details_by_apikey($api_key);
        $payment_mode = $this->input->post('payment_mode');
        if($datas1){
            $login_id = $datas1['id'];
            $userid = $datas1['user_id'];

            $details = get_details_by_loginid($login_id);
            $datas2 = array(
			'customer_log_id' => $login_id,
			'parent_log_id' => $details['parent_login_id'],
			'current_parent_log_id' => 1
			);
			$qry = $this->db->insert('gp_be_clubmember', $datas2);
       

            $package = $this->input->post('package');
            $det1 = getClubtypeById($package);
            if($det1['type']=='UNLIMITED'){
            	$det = get_details_by_userid($userid);
                $amount = $det1['amount'];//-($bde_benefit+$tl_benefit);

                $bde_benefit = $det1['bde_benefit'];
                $tl_benefit = $det1['tl_benefit'];
                /************Entry Start***********/
                $fy_year = get_current_financial_year();
                $fy_id = $fy_year['id'];
               
                $no =get_number();
                $data = array(
                    'entrytype_id'=>2,
                    '_type'=>'CLUB_MEMBERSHIP',
                    'type_id'=>$login_id,
                    'number'=>$no,
                    'fy_id' =>$fy_id,
                    'date'=>date('Y-m-d'),
                    'dr_total'=>$amount,
                    'cr_total'=>$amount
                );
                $this->db->insert('erp_ac_entries',$data);
                $entry_id = $this->db->insert_id();
                //$ledger_payment_cr = 71;
                $ledger_payment_cr = getLedgerId($login_id,"CUSTOMER");
                $entry_items_cr = array(
                    'entry_id' => $entry_id,
                    'ledger_id' => $ledger_payment_cr,
                    'amount' => $amount,
                    'dc' => 'Cr',
                    'fy_id' =>$fy_id,
                    'created_date' => date('Y-m-d')
                );
                $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);

                if($payment_mode=='cash'){
                    $ledger_payment_dr = 32;
                }
                else if($payment_mode=='cheque'){
                    $ledger_payment_dr = 35;
                }
                else{
                    $ledger_payment_dr = 35;
                }

                //$dr_amount1 = $det1['amount']-($bde_benefit+$tl_benefit);
                $entry_items_dr1 = array(
                    'entry_id' => $entry_id,
                    'ledger_id' => $ledger_payment_dr,
                    'amount' => $amount,
                    'dc' => 'Dr',
                    'fy_id' =>$fy_id,
                    'created_date' => date('Y-m-d')
                );
                $entry_dr1 = $this->db->insert('erp_ac_entryitems', $entry_items_dr1);
                /************Entry End***********/
            	$cnt = 0 ;
    	        $parent_id = $det['created_by'];
                $parent_details = $this->get_parent_login($parent_id);
                a:$parent_id = $parent_details['id'];
                $p_id = $parent_details['id'];
                if($parent_details['type']=='executive'){
                    $cnt++;
                    $wal_typ = 3;
                    $res1 = $this->get_club_benefit($p_id,$bde_benefit,$wal_typ);
                    $parent_log_id = $parent_details['parent_login_id'];
                    $parent_details = $this->get_parent_login($parent_log_id);
                    goto a;
                }else if($parent_details['type']=='team_leader'){ 
                    $wal_typ = 3;
                    $cnt++;
                    $benefit = ($cnt==1)?$bde_benefit:$tl_benefit;
                    $res2 = $this->get_club_benefit($p_id,$benefit,$wal_typ);
                        $parent_log_id = $parent_details['parent_login_id'];
                        $parent_details = $this->get_parent_login($parent_log_id);
                    if($cnt<=1){
                      goto a;
                    }
                }else if($parent_details['type']=='tl'){ 
                    $wal_typ = 2;
                    $cnt++;
                    $benefit = ($cnt==1)?$bde_benefit:$tl_benefit;
                    $res2 = $this->get_club_benefit($p_id,$benefit,$wal_typ);
                        $parent_log_id = $parent_details['parent_login_id'];
                        $parent_details = $this->get_parent_login($parent_log_id);
                        goto a; 
                }else if($parent_details['type']=='admin'){
                    $cnt++;
                    if($cnt==1){
                        $benfit = $bde_benefit+$tl_benefit;
                    }else if($cnt==2){
                        $benfit = $tl_benefit;
                    }
                    if($benfit){
                        $this->db->set('total_value', 'total_value + ' . (float) $benfit, FALSE);
                        $this->db->where('user_id', 1);
                        $this->db->where('wallet_type_id', 4);
                        $this->db->update('gp_wallet_values');
                        $wal_val_id8 =get_wallet_val_id(1,4);
                        $wal_activitys = array(
                            'wallet_type_id' => 4,
                            'wallet_val_id' => $wal_val_id8,
                            'user_id' => 1,
                            'change_value' => $benfit,
                            'type'=>'GAIN',
                            'date_modified' => date('Y-m-d h:i:s'),
                            'description' => 'Reward through club membership'
                        );
                        $this->db->insert('gp_wallet_activity', $wal_activitys);
                        // $entry_items_dr2 = array(
                        //     'entry_id' => $entry_id,
                        //     'ledger_id' => $ledger_payment_dr,
                        //     'amount' => $benfit,
                        //     'dc' => 'Dr',
                        //     'fy_id' =>$fy_id,
                        //     'created_date' => date('Y-m-d')
                        // );
                        // $entry_dr2 = $this->db->insert('erp_ac_entryitems', $entry_items_dr2);
                    }
                }
            	$datas['club_type_id'] = $package;
            }
            if($det1['type']=='FIXED'){
            	$datas['fixed_club_type_id']=$package;
            }

            $datas['updated_on']=date('Y-m-d h:i:s');
            $datas['status']="notapproved";
            $datas['type']="club_member";
            $this->db->where('id', $userid);
            $qry = $this->db->update('gp_normal_customer', $datas);
          // echo $this->db->last_query();exit;
            $userLogin = array('parent_login_id'=>1,'type' => 'club_member' ); 
            $this->db->where('id', $login_id);
            $qry_login = $this->db->update('gp_login_table', $userLogin);


    		$qry_amount = $this->db->query("select id, amount from club_member_type where id = '$package'");
    		if($qry_amount->num_rows()>0)
    		{
    			$get_clubdetails = $qry_amount->row_array();
    			$get_amount = $get_clubdetails['amount'];
    			
    		}else{
    			$get_clubdetails = array();
    			$get_amount = 0;
    		}
    		
            $wallete = array('wallet_type_id' => 1,
    						'user_id' => $login_id,
    						'total_value' => $get_amount
    					);
    		$qry3 = $this->db->insert('gp_wallet_values', $wallete);
    		$wal_activity = array(
    	        'wallet_type_id' => 1,
    	        'user_id' => $login_id,
    	        'change_value' => $get_amount,
    	        'date_modified' => date('Y-m-d h:i:s'),
    	        'description' => 'Normal Customer become Club Member'
    	        );
    	    $this->db->insert('gp_wallet_activity', $wal_activity);

    		$date = date("Y-m-d h:i:sa") ;
    	    $action = "normal customer become club member";
    	   	$status = 0;
    	   	activity_log($action,$login_id,$status,$date);

        }

		$this->db->trans_complete();
		if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
        	$data['status'] = FALSE;
    	} else {
            $this->db->trans_commit();
            $data['status'] = TRUE;
            //$data['info'] = $details;
        }
        return $data;
    }
    function refer_validation($mail1,$mob1)
    {   
        $mobile='start';$email='start';
        if(preg_match("/^[0-9]*$/",$mob1) && strlen($mob1)== 10)
        {
            $mobile='true';
        }               
        else
        {
            $mobile='false';
        }
        /*if (!filter_var($mail1, FILTER_VALIDATE_EMAIL) === false) 
        {
            $email='true';
        } 
        else{
            $email='false';
        }*/
        /*if($mobile == 'true' && $email == 'true'){ return 'bothtrue'; }
        elseif($mobile == 'false' && $email == 'false'){ return 'bothfalse'; }*/
        // else
            if($mobile == 'false'){ return 'mobfalse'; }else{ return 'bothtrue'; }
        // elseif($email == 'false'){ return 'mailfalse'; }
    }
    function friend_exists($mob1)
    {
        $qry = "select id from gp_user_referrel where  mobile = '$mob1' 
         OR altmobile = '$mob1' UNION select id from gp_login_table where (mobile = '$mob1')AND(type='club_member' OR type='normal_customer') ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {   
            $a=0;$c=0;
          
            $qry3 = "select id from gp_user_referrel where mobile = '$mob1' or altmobile = '$mob1' UNION select id from gp_login_table where mobile = '$mob1' AND(type='club_member' OR type='normal_customer')";
            $qry3 = $this->db->query($qry3);
            if($qry3->num_rows()>0)
            { $c=1; }
            if($c == 1 ){ return '3'; }
            else{ return 'error'; }
        }else{ 
            return 'allok';
        }
    }
    function add_friend($name,$mail,$mob,$login_id)
    {
        $this->db->trans_begin();
        $created_on = date("h:i:sa");
        $data=array(            
            'referrer_id'=>$login_id,
            'name'=>$name,
            'email'=>$mail,
            'mobile'=>$mob,
            'status' =>"0",
            'created_by' => $login_id,
            'created_on' => $created_on
        );
        $this->db->insert('gp_user_referrel',$data);
        $this->db->trans_complete();
        if( $this->db->trans_status()===false){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }
    }
    function get_club_packages($type)
    {
        $det =array();
        $qry = "select ty.id, ty.title as name, ty.amount as price_upper_limit from club_member_type ty where ty.type='$type' and ty.is_del = 0";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $res = $qry->result_array();
            foreach ($res as $key => $value) {
                $value['price_lower_limit']="0";
                array_push($det,$value);
            }
            return $det;
        }   else{
            return array();
        }
    }
    function get_club_member_by_search($datas)
    {
        $search = $datas['search_text'];
        $base = base_url().'uploads/';
        $type = strtoupper($datas['member_type']);
        $det = array();
        if(!empty($search)){
            if($type){
                if($type=='ALL'){
                    $where= " AND (nc.name LIKE '%{$search}%' or nc.profile_image LIKE '%{$search}%') AND log.type='club_member' and log.is_del = 0 and nc.is_del = 0 and nc.status = 'approved'";
                }else{
                    $where= " AND (nc.name LIKE '%{$search}%' or nc.profile_image LIKE '%{$search}%') AND typ.type='$type' AND log.type='club_member' and log.is_del = 0 and nc.is_del = 0 and nc.status = 'approved'";
                }
            }else{
                $where= " AND (nc.name LIKE '%{$search}%' or nc.profile_image LIKE '%{$search}%') AND log.type='club_member' and log.is_del = 0 and nc.is_del = 0 and nc.status = 'approved'";
            }
        }else{
            if($type){
                if($type=='ALL'){
                    $where= "AND log.type='club_member' and log.is_del = 0 and nc.is_del = 0 and nc.status = 'approved'";
                }else{
                    $where= " AND typ.type='$type' AND log.type='club_member' and log.is_del = 0 and nc.is_del = 0 and nc.status = 'approved'";
                }
            }else{
                $where= "AND log.type='club_member' and log.is_del = 0 and nc.is_del = 0 and nc.status = 'approved'";
            }
        }

        $qry = "SELECT nc.name as firstName,log.id,(nc.profile_image) as p_image FROM gp_login_table log LEFT JOIN gp_normal_customer nc ON log.user_id=nc.id"; 
        if($type=='FIXED'){
            $qry .= " LEFT JOIN club_member_type typ ON nc.fixed_club_type_id=typ.id
            WHERE log.type='club_member'".$where;
        }else  if($type=='ALL'){
            $qry .= " WHERE log.type='club_member'".$where;
        }else{
            $qry .= " LEFT JOIN club_member_type typ ON nc.club_type_id=typ.id
            WHERE log.type='club_member'".$where;   
        }
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $res = $qry->result_array();
            foreach ($res as $key => $value) {
                if($value['p_image']==''){
                    $value['profile_image'] = $base.'profile.jpg';
                }else{
                    $value['profile_image'] = $base.$cus_details['p_image'];
                }
                unset($value['p_image']);
                array_push($det,$value);
            }
            return $det;
            
        } else{
            return array();
        }  
    }
    function transfer_phone_exist($reg_phone)
    {
        $qry= "select logg.id  FROM gp_login_table logg where  logg.mobile='$reg_phone' and (type = 'normal_customer' or type = 'club_member'or type = 'club_agent' or logg.type='executive')";
        $query=$this->db->query($qry);
        if($query->num_rows()>0)
        {
            return $query->row_array();
        } else{
            return array();
        }   
    }
    function transfer_amount($userid,$reg_amount,$login_id,$trans_type )
    {
       $qry= "select
                    *
                    from
                    gp_wallet_values vl 
                    where vl.wallet_type_id = '$trans_type'
                    and vl.user_id = '$login_id'";
        $query=$this->db->query($qry);
       
        if($query->num_rows()>0)
        {
            $res = $query->row_array();
            if($res['total_value'] >= $reg_amount){
                $result = check_wallet_exist($userid,$trans_type);
                if($result){
                    $re = $this->transfer_result($userid,$reg_amount,$login_id,$trans_type );
                    if($re==true){
                        $data['status']=true;
                    }else{
                        $data['status']=false;
                        $data['reason']='No Wallet exist';
                    }
                }else{
                  $data['reason']='You are transferring to a user does not have such wallet';
                  $data['status']=false;
                }
            }else{
                $data['status']=false;
                $data['reason']='Not enough money';
            }
        }else{
            $data['status']=false;
            $data['reason']='Your wallet is empty';
        }   
        return $data;
    }
    function transfer_result($userid,$reg_amount,$login_id,$trans_type)
    {
        $this->db->trans_begin();
        $rec_qry="update `gp_wallet_values` set total_value=total_value + '$reg_amount' where user_id='$userid' and wallet_type_id= '$trans_type'";

        $recquery=$this->db->query($rec_qry);


        $send_qry="update `gp_wallet_values` set total_value=total_value - '$reg_amount' where user_id='$login_id' and wallet_type_id= '$trans_type'";

        $query=$this->db->query($send_qry);
        $created_on= date('Y-m-d H:i:s');

        $data=array(
            'form_id'=>$login_id,
            'to_id'=>$userid,
            'amount'=>$reg_amount,
            'wallet'=>$trans_type,
            'status' =>"1",
            'created_by' => $login_id,
            'created_on_date' => $created_on
        );
        $this->db->insert('gp_payment_transfer',$data);
        $wal_activity = array(array(
              'wallet_type_id' => $trans_type,
              'user_id' => $login_id,
              'change_value' => $reg_amount,
              'type'=>'LOSS',
              'date_modified' => date('Y-m-d h:i:s'),
              'description' => 'Wallet Transfer'
              ),array(
              'wallet_type_id' => $trans_type,
              'user_id' => $userid,
              'change_value' =>$reg_amount,
              'type'=>'GAIN',
              'date_modified' => date('Y-m-d h:i:s'),
              'description' => 'Wallet Transfer'
              ));
        $this->db->insert_batch('gp_wallet_activity', $wal_activity);
        $this->db->trans_complete();
        if( $this->db->trans_status()===false){
            $this->db->trans_rollback();
            return false;
        } else{
            $this->db->trans_commit();
            return true;
        }
    }
    function get_my_wallet($login_id,$user_id){
        $wallet =array();
        $qry = "select wa.id,wa.wallet_type_id,wa.total_value from gp_wallet_values wa where wa.user_id ='$login_id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $res = $qry->result_array();
            foreach ($res as $key => $value) {
                if($value['wallet_type_id']==1){
                    $club_wallet = $value['total_value'];
                }elseif($value['wallet_type_id']==2){
                    $reward_wallet = $value['total_value'];
                }elseif($value['wallet_type_id']==3){
                    $incentive_wallet = $value['total_value'];
                }elseif($value['wallet_type_id']==4){
                    $my_wallet = $value['total_value'];
                }elseif($value['wallet_type_id']==5){
                    $fixed_club_wallet = $value['total_value']; 
                }
               // array_push($det,array(($value['wallet_type_id']==1)?('club_wallet'=>($value['wallet_type_id']==1)?$value['total_value']:"0"):'');
            }
            
            if(isset($club_wallet)){
                $club_wallet = $club_wallet;
                array_push($wallet,array('key'=>'club_wallet',
                        'value'=>$club_wallet,
                        'wallet_id'=>$value['wallet_type_id'],
                        'is_transferable'=>true)
                    );
            }
            if(isset($reward_wallet)){
                $reward_wallet = $reward_wallet;
                array_push($wallet,array('key'=>'reward_wallet',
                    'value'=>$reward_wallet,
                    'wallet_id'=>$value['wallet_type_id'],
                    'is_transferable'=>true)
                );
            }
            if(isset($my_wallet)){
                $my_wallet = $my_wallet;
                array_push($wallet,array('key'=>'my_wallet',
                    'value'=>$my_wallet,
                    'wallet_id'=>$value['wallet_type_id'],
                    'is_transferable'=>true)
                );  
            }
            if(isset($incentive_wallet)){
                $incentive_wallet = $incentive_wallet;
                array_push($wallet,array('key'=>'incentive_wallet',
                    'value'=>$incentive_wallet,
                    'wallet_id'=>$value['wallet_type_id'],
                    'is_transferable'=>false)
                );
            }
            if(isset($fixed_club_wallet)){
                $fixed_club_wallet = $fixed_club_wallet;
                array_push($wallet,array('key'=>'fixed_club_wallet',
                        'value'=>$fixed_club_wallet,
                        'wallet_id'=>$value['wallet_type_id'],
                        'is_transferable'=>false)
                    );
            }
            
            $club_wallet = (!empty($club_wallet))?$club_wallet:"0";
            $reward_wallet = (!empty($reward_wallet))?$reward_wallet:"0";
            $my_wallet = (!empty($my_wallet))?$my_wallet:"0";
            $incentive_wallet =(!empty($incentive_wallet))?$incentive_wallet:"0";
            $fixed_club_wallet =(!empty($fixed_club_wallet))?$fixed_club_wallet:"0";
            
            $noty = get_notification_count($login_id);
            $noty = $noty->noti_count;
            $qry2 = "select u.id, u.email,u.user_id,u.type,c.name from gp_login_table u 
             left join gp_normal_customer c on u.user_id=c.id
             where u.id = '$login_id'";

            $qry2 = $this->db->query($qry2);
           
            if($qry2->num_rows()>0) {
                $user_dets = $qry2->row_array();
                $type=$user_dets['type'];
                if($type=='executive'){
                    $qry3 = "select u.id, u.email,u.user_id,u.type,c.name from gp_login_table u left join gp_pl_sales_team_members c on u.user_id=c.id
                     where u.id = '$login_id'";

                    $qry3 = $this->db->query($qry3);
                   
                    if($qry3->num_rows()>0) {
                        $exe_dets = $qry3->row_array();
                        $name=$exe_dets['name'];
                    }
                }else{
                    $name=$user_dets['name'];
                }
            }else{
                $name='';
                $type=''; 
            }
            $qryy = "Select ROUND((IFNULL(SUM(wa.change_value),0)* 100 / (Select SUM(total_value) From gp_wallet_values WHERE user_id='$login_id')),2) as wallet_usage
                From gp_wallet_activity wa WHERE wa.user_id='$login_id' AND wa.type='LOSS'";
            $qryy = $this->db->query($qryy);
            if($qryy->num_rows()>0)
            {
                $res2 = $qryy->row_array();
                $wallet_usage_percent = $res2['wallet_usage'];
            }
            $det['incentive_wallet']=$incentive_wallet;
            $det['my_wallet']=$my_wallet;
            $det['reward_wallet']=$reward_wallet;
            $det['club_wallet']=$club_wallet;
            $det['fixed_club_wallet']=$fixed_club_wallet;
            $det['notification_count']=$noty;
            $det['wallet_usage_percent']=$wallet_usage_percent;
            $det['user_type']=$type;
            $det['wallet'] = $wallet;
            return $det;
        }   else{
            return array();
        }
    }
    function update_profile($login_id,$user_id,$type){
        $this->db->trans_begin();
        $country = $this->input->post('country');
        if(!empty($country)){
            $countrydata = get_countryName_by_id($this->input->post('country'));
            $countryName = $countrydata['name'];
        }else{
            $countryName = '';
        }
        $stst = $this->input->post('state');
        if(!empty($stst)){
            $statedata = get_stateName_by_id($this->input->post('state'));
            $stateName = $statedata['name'];
        }else{
            $stateName = '';
        }
        $cty = $this->input->post('city');
        if(!empty($cty)){
            $citydata = get_cityName_by_id($this->input->post('city'));
            $cityName = $citydata['name'];
        }else{
            $cityName = '';
        }
        if($type=='executive'){
            /*$details1 = array('email'=>$this->input->post('email'),
                        'mobile'=>$this->input->post('mobile'));*/
            $details2 = array( 'name'=>$this->input->post('fname')); 
            $details3 = array('name'=>$this->input->post('fname'),
                        // 'email'=>$this->input->post('email'),
                        // 'mobile'=>$this->input->post('mobile'),
                        'city'=>$country,
                        'state'=>$stst,
                        'country'=>$cty
                        );  
            /*$this->db->where('id',$login_id);
            $this->db->update('gp_login_table',$details1);*/
            $this->db->where('id',$user_id);
            $this->db->update('gp_pl_sales_team_members',$details2);
            
            $this->db->where('sales_team_member_id',$user_id);
            $this->db->update('gp_pl_sales_team_member_details',$details3);
            //echo $this->db->last_query();exit();

        }else{

            /*$details1 = array('email'=>$this->input->post('email'),
                'mobile'=>$this->input->post('mobile'));  */
            $details2= array(
                'name'=>$this->input->post('fname'),
                // 'phone'=>$this->input->post('mobile'),
                'phone2'=>$this->input->post('mobile_alternate'),
                // 'email'=>$this->input->post('email'),
                'pincode'=>$this->input->post('pin')
                );  
            $details3 = array('lastname'=>$this->input->post('lname'),
                'alt_mobile'=>$this->input->post('mobile_alternate'),
                'whatssup_no'=>$this->input->post('whatsapp_num'),
                'alt_email'=>$this->input->post('email_alternate'),
                'house_name'=>$this->input->post('house_name'),
                'house_no'=>$this->input->post('house_number'),
                'streat'=>$this->input->post('street'),
                'road'=>$this->input->post('road'),
                'location'=>$this->input->post('location'),
                'city'=>$cty,
                'post_office'=>$this->input->post('post'),
                'area'=>$this->input->post('area'),
                'country'=>$country,
                'state'=>$stst,
                'district'=>$this->input->post('district')
                );  
            /*$this->db->where('id',$login_id);
            $this->db->update('gp_login_table',$details1);*/
            $this->db->where('id',$user_id);
            $this->db->update('gp_normal_customer',$details2);
            
            $this->db->where('customer_id',$user_id);
            $this->db->update('gp_customer_additional_info',$details3);  
            //echo $this->db->last_query();exit();
        } 
        $this->db->trans_complete();
        if( $this->db->trans_status()===false){
            $this->db->trans_rollback();
            return false;
        } else{
            $this->db->trans_commit();
            return true;
        }
    }
    function update_profile_image($data){
        $this->db->trans_begin();
        $id = $data['id'];
        $type = $data['type'];
        if($type=='executive'){
            $selqry = "select image from gp_pl_sales_team_member_details where sales_team_member_id = '$id'";
            $sid =  'sales_team_member_id';
            $tbl = 'gp_pl_sales_team_member_details';
            $imgg = array('image'=>$data['image']);
        }else{
            $selqry = "select profile_image as image from gp_normal_customer where id = '$id'";
            $sid = 'id';
            $tbl = 'gp_normal_customer';
            $imgg = array('profile_image'=>$data['image']);
        }
        
        $selqry = $this->db->query($selqry);

        if($selqry->num_rows()>0){
            $datass = $selqry->row_array();
            $del_img = $datass['image'];
            if(!empty($del_img)){
               $del_img=($type=='executive')?'upload/exec_profile/'.$del_img:'uploads/'.$del_img;
               unlink($del_img);
            }
        }  
        $this->db->where($sid,$id);
        $res= $this->db->update($tbl,$imgg);

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
    function get_user_details($api_key,$type){

        if($type=='executive'){
            $url = base_url()."upload/exec_profile/";
            $qry="select lg.id,lg.email,lg.mobile as phone,sm.name as firstName,smd.image as p_image,(CASE WHEN typ.slug='team_leader' THEN 'executive_team_lead' ELSE 'executive' END) AS user_type
            from gp_login_table lg left join gp_pl_sales_team_members sm
            on lg.user_id= sm.id
            inner join gp_pl_sales_team_member_details smd 
            on smd.sales_team_member_id =sm.id  
            inner join gp_pl_sales_designation_type typ on sm.sales_desig_type_id=typ.id
            where lg.api_key='$api_key'";
        }else{
            $url = base_url()."uploads/";
            $qry="select lg.id,lg.email,lg.mobile as phone,nc.name as firstName,IFNULL(gpa.lastname,'') as lastName,nc.profile_image as p_image,(CASE WHEN nc.type='normal_customer' THEN 'customer' ELSE 'club_member' END)AS user_type,nc.club_type_id,nc.fixed_club_type_id from gp_login_table lg left join gp_normal_customer nc on lg.user_id= nc.id inner join gp_customer_additional_info gpa on gpa.customer_id =nc.id where lg.api_key='$api_key'";
        } 

        $qry=$this->db->query($qry);
       // echo $this->db->last_query();
        if($qry->num_rows()>0){
            $reff = array();
            $details = $qry->row_array();
            if($details['p_image']!=''){
                $details['profile_image']=$url.$details['p_image'];
            }else{
                $details['profile_image']=$url.'profile.jpg';
            }
            if($type=='executive'){
                $details['member_type']='';
            }else if($type=='club_agent')
            {
                $details['user_type']='club_agent';
                $details['member_type']='';
            }else
            {
                $details['member_type']=($details['club_type_id']>0)?'UNLIMITED':(($details['fixed_club_type_id']>0)?'FIXED':'');
                unset($details['club_type_id']);
                unset($details['fixed_club_type_id']);
            }
            unset($details['p_image']);
        }else{
            $details = false;
        }

        return $details;
    }
    function add_club_agent($data,$login_id){
        $api = apikey_generate();
        $this->db->trans_begin();
        $otp = random_string('numeric', 4);
        $datas = array(
            'name' => $data['name'],
            'phone' => $data['mobile'],
            'email' => $data['email'],
            'otp' => $otp,
            'profile_image' =>'',
            'ca_docs'=>isset($data['file'])?$data['file']:'',
            'reg_otp_status' => 0,
            'created_by'=>$login_id,
            'register_via'=>$data['register_via'],
            'type' => 'club_agent',
            'mem_id'=>$data['club_member_id']
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
            'parent_login_id'=>$data['club_member_id'],
            'api_key'=>$api
        );
        $qry3 = $this->db->insert('gp_login_table', $data3);
        //Club agent -Create Ledger
        $id = $this->db->insert_id(); 
        $date = date('Y-m-d');
        $financial_year = get_financial_year();
        $ca_ldg = array(
                        'type_id' => $id,
                        '_type' => 'EMPLOYEE',
                        'group_id' => 25,
                        'name' => $id ."_".$data['name'].'_ledger'
                        );
        $ldg_qry = $this->db->insert('erp_ac_ledgers', $ca_ldg);
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
            $data['status'] = FALSE;
        } else {
            $this->db->trans_commit();
            $data['status'] = TRUE;
            $info = array('user_id' => $insert_id, 'otp' => $otp);
            $data['info'] = $info;
        }
        return $data;
    }
    function add_club_member($data,$login_id){
        $this->db->trans_begin();
        $details = get_details_by_loginid($data['id']);

        $datas2 = array(
        'customer_log_id' => $data['id'],
        'parent_log_id' => $details['parent_login_id'],
        'current_parent_log_id' =>$login_id
        );
        $qry = $this->db->insert('gp_be_clubmember', $datas2);

        $club_plan = $this->input->post('package');
        $det1 = getClubtypeById($club_plan);
        
        $datas = array(
            'profile_image' =>'',
            'type'=>'club_member',
            'parent_id' => $login_id,
            'created_by'=>$login_id,
            'register_via' =>'normal',
            'status'=>'notapproved',
            'club_type_id' => $club_plan);

        $this->db->where('id', $details['user_id']);
        $qry = $this->db->update('gp_normal_customer', $datas);

        $userLogin = array( 'type' => 'club_member' ); 
        $this->db->where('id', $data['id']);
        $qry_login = $this->db->update('gp_login_table', $userLogin);
        if(!empty($det1)){
            $wallete = array('wallet_type_id' => 1, 'user_id' =>  $data['id'], 'total_value' => $det1['amount'] );  
            $qry3 = $this->db->insert('gp_wallet_values', $wallete);
            $wal_id = $this->db->insert_id();

            $wal_activityss = array(
                'wallet_type_id' => 1,
                'wallet_val_id' => $wal_id,
                'user_id' =>  $data['id'],
                'type'=>'GAIN',
                'date_modified' => date('Y-m-d h:i:s'),
                'description' => 'Club wallet added'
                );
            $this->db->insert('gp_wallet_activity', $wal_activityss);
        }

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data['status'] = FALSE;
        } else {
            $this->db->trans_commit();
            $data['status'] = TRUE;       
        }
        //echo $this->db->last_query();exit();
        return $data;
    }
    function refer_channel_partner($data){
        $this->db->trans_begin();
        $created_on = date("Y-m-d h:i:sa") ;
        $login_id = $data['id'];

        $data=array(
            'name'=>$this->input->post('name'),
            'club_mem_id'=>$login_id ,
            'club_type'=>$this->input->post('club_type'),
            'phone'=>$this->input->post('phone'),
            'email'=>$this->input->post('email'),
            'owner_name'=>$this->input->post('owner_name'),
            'created_on'=>$created_on,
            'owner_email'=>$this->input->post('owner_email'),
            'owner_mobile'=>$this->input->post('owner_mobile'),
            'address'=>$this->input->post('address'),
            'area'=>$this->input->post('area'),
            'created_by'=>$login_id,
            'status'=>'REFERED' ,
            'is_reffered'=>1
        );
        $this->db->insert('gp_pl_channel_partner',$data);
        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
    function get_refered_channel_partners($id){
        $qry= "select cp.id,cp.name,cp.phone,cp.email,cp.owner_name,cp.owner_email,cp.owner_mobile as owner_number, cp.address,cp.club_mem_id as referred_club_member_id,clubmember.name as referred_club_member_name from gp_pl_channel_partner cp
            left join gp_login_table log on cp.club_mem_id = log.id
            left join gp_normal_customer clubmember on clubmember.id =log.user_id
            where cp.is_del='0' and cp.status='REFERED' and clubmember.created_by = $id";
        $query=$this->db->query($qry);
        if($query->num_rows()>0)
        {
            $data['channels'] = $query->result_array();
        } else{
            $data['channels'] = array();
        } 
        return $data;
    }
    function remove_refered_channel_partner($data){
        $id = $data['id'];
        $channel_id = $data['channel_id'];

        $qry= "SELECT id,name,email,phone,address FROM `gp_pl_channel_partner` WHERE created_by='$id' AND id='$channel_id' AND status='REFERED' ORDER BY id DESC";
        $query=$this->db->query($qry);
        if($query->num_rows()>0)
        {
            $res = $this->db->delete('gp_pl_channel_partner', array('id' => $channel_id));
            if($res){
                $data['status'] =true;
                $data['message'] ='success';
            }else{
                $data['status'] =false;
                $data['message'] ='something wemt wrong';
            }
        } else{
            $data['status'] =false;
            $data['message'] ='invalid channel id';
        } 
        return $data;
    }
    function chk_mail_exist($mail,$id){

        $qry = "select id from gp_user_referrel where  (email = '$mail' 
         OR altemail = '$mail')AND gp_user_referrel.id!='$id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return FALSE;
        } else
        {
            return TRUE;
        }
    }
    function chk_mobile_exist($mob,$id){
        $qry = "select id from gp_user_referrel where  (mobile = '$mob' 
         OR altmobile = '$mob')AND gp_user_referrel.id!='$id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return FALSE;
        } else
        {
            return TRUE;
        }
    }
    function chk_valida_friend($id,$frnd_id){
        $qry = "select * from gp_user_referrel where id = '$frnd_id' and referrer_id='$id' and status!=1";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return TRUE;
        } else
        {
            return FALSE;
        }
    }
    function update_referred_friend($lid){
        $this->db->trans_begin();
       
        $data=array(            
            'name'=>$this->input->post('name'),
            'mobile'=>$this->input->post('mobile'),
            'email'=>$this->input->post('email')
        );

        $this->db->where('id',$lid);
        $this->db->update('gp_user_referrel',$data);
        $this->db->trans_complete();
        if( $this->db->trans_status()===false){
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }
    }
    function remove_refered_friend($data){
        $id = $data['id'];
        $friend_id = $data['friend_id'];

        $qry= "SELECT * FROM `gp_user_referrel` WHERE referrer_id='$id' AND id='$friend_id' AND status=0 ORDER BY id DESC";
        $query=$this->db->query($qry);
        if($query->num_rows()>0)
        {
            $res = $this->db->delete('gp_user_referrel', array('id' => $friend_id));
            if($res){
                $data['status'] =true;
                $data['message'] ='success';
            }else{
                $data['status'] =false;
                $data['message'] ='something wemt wrong';
            }
        } else{
            $data['status'] =false;
            $data['message'] ='invalid friend id';
        } 
        return $data;
    }
    function upgrade_club_membership($data){
        $this->db->trans_begin();
        $id = $data['id'];
        $log_id = $data['log_id'];
        $club_id = $data['club_id'];
        $type = $data['type'];
        $datas['updated_on']=date('Y-m-d h:i:s');
        $datas['club_type_id']=$club_id;
        $this->db->select('club_type_id')
            ->from('gp_normal_customer')
            ->where('id',$id);
        $old_id = $this->db->get()->row()->club_type_id;
        $det1 = getClubtypeById($old_id);
        if($club_id!=$old_id){
            $qry1 = $this->db->query("select * from gp_wallet_values where user_id = '$log_id' AND wallet_type_id='1'");
            if($qry1->num_rows()>0)
            {
                $wal_details = $qry1->row_array();
                
                $qry_amount = $this->db->query("select id, amount from club_member_type where id = '$club_id'");
                if($qry_amount->num_rows()>0)
                {
                    $get_clubdetails = $qry_amount->row_array();
                    $get_amount = $get_clubdetails['amount'];
                    $g_amount = $get_amount - $det1['amount'];
                    $this->db->set('total_value', 'total_value + ' . (float) $g_amount, FALSE);
                    $this->db->where('user_id', $log_id);
                    $this->db->where('wallet_type_id', 1);
                    $this->db->update('gp_wallet_values');
                   
                    $wal_activity = array(
                    'wallet_type_id' => 1,
                    'user_id' => $log_id,
                    'change_value' => $g_amount,
                    'date_modified' => date('Y-m-d h:i:s'),
                    'description' => 'Upgrade Club Membership'
                    );
                    $this->db->insert('gp_wallet_activity', $wal_activity);
                    //Entry
                    $fy_year = get_current_financial_year();
                    $fy_id = $fy_year['id'];
                   
                    $no =get_number();
                    $ent_data = array(
                        'entrytype_id'=>2,
                        '_type'=>'CLUB_MEMBERSHIP',
                        'type_id'=>$log_id,
                        'number'=>$no,
                        'fy_id' =>$fy_id,
                        'date'=>date('Y-m-d'),
                        'dr_total'=>$g_amount,
                        'cr_total'=>$g_amount,
                    );
                    $this->db->insert('erp_ac_entries',$ent_data);
                    $entry_id = $this->db->insert_id();
                    $ledger_payment_cr = getLedgerId($log_id,"CUSTOMER");
                    //$ledger_payment_cr = 71;
                    $entry_items_cr = array(
                        'entry_id' => $entry_id,
                        'ledger_id' => $ledger_payment_cr,
                        'amount' => $g_amount,
                        'dc' => 'Cr',
                        'fy_id' =>$fy_id,
                        'created_date' => date('Y-m-d')
                    );
                    $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);
                    
                    $ledger_payment_dr = 35;
                    $entry_items_dr = array(
                        'entry_id' => $entry_id,
                        'ledger_id' => $ledger_payment_dr,
                        'amount' => $g_amount,
                        'dc' => 'Dr',
                        'fy_id' =>$fy_id,
                        'created_date' => date('Y-m-d')
                    );
                    $entry_dr1 = $this->db->insert('erp_ac_entryitems', $entry_items_dr);
                    ////////////////////////////
                    $data['updated_on']=date('Y-m-d h:i:s');
                    $this->db->where('id', $id);
                    $qry = $this->db->update('gp_normal_customer', $datas);

                    $date = date("Y-m-d h:i:sa") ;
                    $action = "Upgrade Club Membership";
                    $status = 0;
                    activity_log($action,$log_id,$status,$date);
                    if ($this->db->trans_status() === TRUE) {
                        $this->db->trans_commit();
                        return true;
                    } else {
                        $this->db->trans_rollback();
                        return false;
                    }
                }
            }
        }
    }
    function get_club_details($id){
        $qry = "SELECT mt.title as plan,mt.club_agent_status,mt.ca_limit,mt.cp_status,mt.cp_limit,mt.user_status,mt.user_limit,mt.ba_status,mt.ba_limit,mt.cash_limit FROM  
            club_member_type mt
            WHERE mt.id='$id'";
        $query = $this->db->query($qry);
        if($query->num_rows()>0)
        {
            $details =  $query->row_array();
            return $year_limit = $details['cash_limit'];
        }
    }
    function check_cp_facility($data){
        $id = $data['id'];
        $member_id = $data['member_id'];
        $type = $data['type'];
        $res  = array();
        $qry="SELECT t.type,t.id as login_id,n.id as user_id,n.club_type_id,n.fixed_club_type_id,n.investor_type_id,t.type,t.email,n.fixed_join_date,n.created_on FROM gp_login_table t left join gp_normal_customer n on t.user_id = n.id WHERE t.id = '$member_id' and t.type not in ('super_admin','channel_partner','executive') and t.is_del = '0' and n.status = 'approved'";
        $result=$this->db->query($qry); 
        if($result->num_rows()>0)
        {
            $datas =  $result->row_array();
            $login_id = $datas['login_id'];
            $fixed_joind = $datas['fixed_join_date'];
            $club_type = $datas['club_type_id'];
            $dateString = $datas['created_on'];
            $years = round((time()-strtotime($dateString))/(3600*24*365));
            $year_limit = $this->get_club_details($club_type);
            if($datas){
                if($datas['club_type_id']>0){
                    if($year_limit>=$years){
                        $data1['status'] = true;
                        $data1['msg'] = 'Success';
                        array_push($res,'UNLIMITED');
                        $data1['data'] = $res;
                    }else{
                        $data1['status'] = false;
                        $data1['msg'] = 'Your club membership expired';
                    }
                }
                if($datas['fixed_club_type_id']>0){
                    $fix_year_exceed = date('Y-m-d H:i:s',strtotime('+1 year',strtotime($fixed_joind)));
                    $fixed_plan = $datas['fixed_club_type_id'];
                    $fixed_details = getClubtypeById($fixed_plan);
                    $fixed_amnt = $fixed_details['amount'];
                    $reward_per_refer_cp = $fixed_details['ref_reward_per_cp'];
                    $reward_per_cp = $fixed_details['reward_per_cp'];

                    $fixed_wallet_used = get_wallet_used_by_member($login_id,5);
                    $fixed_wallet_details = get_fixed_wallet_details($login_id);

                    $expected_total1 = $fixed_wallet_details +$reward_per_refer_cp + $fixed_wallet_used;
                    $expected_total2 = $fixed_wallet_details +$reward_per_cp + $fixed_wallet_used;
                    $exp1 = $fixed_wallet_details+$fixed_wallet_used;
                    $allow1 = '';
                    if($exp1<$fixed_amnt){
                      $allow1 = 1 ;
                    }
                    if($type=='executive'){
                        if((date('Y-m-d H:i:s')<=$fix_year_exceed)&& (($expected_total2<=$fixed_amnt)|| ($allow1==1))){
                            $data1['msg'] = 'Success';
                            $data1['status'] = true;
                            array_push($res,'FIXED');
                            $data1['data'] = $res;
                        }else{
                            if($year_limit>=$years){
                                $data1['status'] = true;
                                $data1['msg'] = 'Success';
                                array_push($res,'UNLIMITED');
                                $data1['data'] = $res;
                            }else{
                                $data1['status'] = false;
                                $data1['msg'] = 'Sorry!!...Channel Partner Limit crossed by this club member';
                            }
                        }
                    }else if($type=='club_member'){
                        if((date('Y-m-d H:i:s')<=$fix_year_exceed)&& (($expected_total1<=$fixed_amnt)|| ($allow1==1))){
                            $data1['msg'] = 'Success';
                            $data1['status'] = true;
                            array_push($res,'FIXED');
                            $data1['data'] = $res;
                        }else{
                            if($year_limit>=$years){
                                $data1['status'] = true;
                                $data1['msg'] = 'Success';
                                array_push($res,'UNLIMITED');
                                $data1['data'] = $res;
                            }else{
                                $data1['status'] = false;
                                $data1['msg'] = 'Sorry!!...Channel Partner Limit crossed by this club member';
                            }
                        }
                    }
                }
                return $data1;
            }else{
                $data1['status'] = false;
                $data1['msg'] = 'Sorry!!...Club member not found';
            }
            
            return $data1;
        }
    }
}
?>