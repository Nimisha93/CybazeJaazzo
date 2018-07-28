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
	function chk_validate_email($email){
		$data = array();
		/*$qry = "select log.* from gp_login_table as log left join gp_normal_customer  on log.user_id=gp_normal_customer.id where log.email = '$email' and (log.type = 'club_member' or log.type = 'normal_customer' or log.type = 'club_agent')AND gp_normal_customer.status='approved'";*/
		$qry = "select log.* from gp_login_table as log left join gp_normal_customer  on log.user_id=gp_normal_customer.id where log.email = '$email' AND gp_normal_customer.status='approved'";
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
	function chk_validate_mobile($phone)
	{
		$data = array();
		$qry2 = "select log.* from gp_login_table log left join gp_normal_customer nc on log.user_id=nc.id
		where log.mobile = '$phone' and log.type = 'normal_customer' AND nc.status='approved'";
		//$qry2 = "select * from gp_login_table where mobile = '$phone'";
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
	function sign_up()
    {
    	$api = apikey_generate();
    	$rid=0; $rtid=0;
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$qry1 = "select id,referrer_id from gp_user_referrel where (mobile = '$phone' or altmobile = '$phone' OR email = '$email' or altemail = '$email') and status = '0' ";
		$qry1 = $this->db->query($qry1);
		if($qry1->num_rows()>0)
		{
			$ref = $qry1->row_array();
			$rid = $ref['referrer_id'];
			$rtid = $ref['id'];
			// print_r($rid);
		}else{
			$rid = 1;
			$rtid = 0;	
		}
		$this->db->trans_begin();
		$qryy = "SELECT c.*,log.id as log_id from gp_normal_customer c left join gp_login_table log  on log.user_id=c.id
		where  (log.email = '$email' or log.mobile = '$phone')  and c.status='notapproved'";
		$qryy = $this->db->query($qryy);
		//var_dump($this->db->last_query());exit;
		$otp = random_string('numeric',4);

		if($qryy->num_rows()>0)
		{

			$user_details = $qryy->row_array();
			$insert_id = $user_details['id'];
			$log_id = $user_details['log_id'];
			$data1 = array(
				'parent_id' => $rid,
				'name'=>$this->input->post('first_name'),
				'phone' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'type' => 'normal_customer',
				'otp' => $otp,
				'reg_otp_status'=>1,
				'profile_image'=>'',
				'is_del'=>0,
				'register_via'=>'normal',
				'created_on' => date("Y-m-d H:i:s"),
				'status'=>'notapproved',
				// 'api_key'=>$api
				);
			$this->db->where('id', $insert_id);
			$qry = $this->db->update('gp_normal_customer', $data1);

			$userLogin = array(
				'mobile' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'user_id' => $insert_id,
				'is_del'=>0,
				'password' => encrypt_decrypt('encrypt',$this->input->post('password')),
				'type' => 'normal_customer',
                'api_key'=>$api,
				'otp_status'=>1
				); 
			$this->db->where('id', $log_id);
			$qry_login = $this->db->update('gp_login_table', $userLogin);
			if($rtid!=0){
				$array = array('status' => 1);
				$this->db->where('id', $rtid);
				$upqry = $this->db->update('gp_user_referrel', $array);
			}
		}else{
			$data1 = array(
				'parent_id' => $rid,
				'name'=>$this->input->post('first_name'),
				'phone' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'type' => 'normal_customer',
				'otp' => $otp,
				'reg_otp_status'=>1,
				'profile_image'=>'',
				'is_del'=>0,
				'register_via'=>'normal',
				'created_on' => date("Y-m-d H:i:s"),
				'status'=>'notapproved'
				);
			$qry = $this->db->insert('gp_normal_customer', $data1);

			$insert_id = $this->db->insert_id();
			$userLogin = array(
				'parent_login_id' => $rid,
				'mobile' => $this->input->post('phone'),
				'email' => $this->input->post('email'),
				'user_id' => $insert_id,
				'is_del'=>0,
				'password' => encrypt_decrypt('encrypt',$this->input->post('password')),
				'type' => 'normal_customer',
				'fcm_token'=>$this->input->post('fcm_token'),
                'api_key'=>$api,
				'otp_status'=>1
				); 
			$qry_login = $this->db->insert('gp_login_table', $userLogin);
			if($rtid!=0){
				$array = array('status' => 1);
				$this->db->where('id', $rtid);
				$upqry = $this->db->update('gp_user_referrel', $array);
			}
			$data2 = array('customer_id' => $insert_id );
		    $qry2 = $this->db->insert('gp_customer_additional_info', $data2);
		}


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

	function validate_email($email)
	{
		$data = array();
		/*$qry = "select * from gp_login_table where email = '$email' and (type = 'club_member' or type = 'normal_customer' or type = 'club_agent')";*/
		$qry = "select * from gp_login_table where email = '$email'";
		
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
		/*$qry2 = "select * from gp_login_table where mobile = '$phone' and (type = 'club_member' or type = 'normal_customer' or type = 'club_agent')";
		*/
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
	//Normal Customer
	function customer_registration()
	{
		$rid=0; $rtid=0;
		$email = $this->input->post('email');
		$phone = $this->input->post('phone');
		$qry1 = "select id,referrer_id from gp_user_referrel where (mobile = '$phone' or altmobile = '$phone' OR email = '$email' or altemail = '$email') and status = '0' ";
		$qry1 = $this->db->query($qry1);
		if($qry1->num_rows()>0)
		{
			$ref = $qry1->row_array();
			$rid = $ref['referrer_id'];
			$rtid = $ref['id'];
			// print_r($rid);
		}else{
			$rid = 1;
			$rtid = 0;	
		}
		$this->db->trans_begin();
		$otp = random_string('numeric', 4);
		$data1 = array(
			'parent_id' => $rid,
			'name'=>$this->input->post('first_name'),
			'phone' => $this->input->post('phone'),
			'email' => $this->input->post('email'),
			'type' => 'normal_customer',
			'otp' => $otp,
			'reg_otp_status'=>1,
			'profile_image'=>'',
			'is_del'=>0,
			'register_via'=>'normal',
			'created_on' => date("Y-m-d H:i:s"),
			'status'=>'notapproved'
			);
		$qry = $this->db->insert('gp_normal_customer', $data1);

		$insert_id = $this->db->insert_id();
		$userLogin = array(
			'parent_login_id' => $rid,
			'mobile' => $this->input->post('phone'),
			'email' => $this->input->post('email'),
			'user_id' => $insert_id,
			'is_del'=>0,
			'password' => encrypt_decrypt('encrypt',$this->input->post('password')),
			'type' => 'normal_customer',
			'otp_status'=>1
			); 
		$qry_login = $this->db->insert('gp_login_table', $userLogin);

		if($rtid!=0){
			$array = array('status' => 1);
			$this->db->where('id', $rtid);
			$upqry = $this->db->update('gp_user_referrel', $array);
		}

		$data2 = array(
            'customer_id' => $insert_id,
            'lastname'=>$this->input->post('last_name')
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
			$qry_res = "SELECT tb.*,nc.club_type_id,nc.name  from gp_login_table tb left join gp_normal_customer nc on tb.user_id=nc.id where tb.user_id = '$user_id' and tb.type = 'normal_customer'";
			$qry_res = $this->db->query($qry_res);
			//echo $this->db->last_query(); exit;
			if($qry_res->num_rows()>0)
			{
				$login_details = $qry_res->row_array();
				$login_id = $login_details['id'];
				$userid = $login_details['user_id'];
				$name = $login_details['name'];

				$update_status1 = array('otp_status' => 0);
				$this->db->where('id', $login_id);
				$upqry1 = $this->db->update('gp_login_table', $update_status1);

				$update_status2 = array('reg_otp_status' => 0,'status'=>'approved');
				$this->db->where('id', $userid);
				$upqry2 = $this->db->update('gp_normal_customer', $update_status2);


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
				$wal_activity = array(array(
		            'wallet_type_id' => 2,
		            'user_id' => $login_id,
		            'change_value' => 0,
		            'date_modified' => date('Y-m-d h:i:s'),
		            'description' => 'Normal Customer Sign up'
		            ),array(
		            'wallet_type_id' => 4,
		            'user_id' => $login_id,
		            'change_value' => 0,
		            'date_modified' => date('Y-m-d h:i:s'),
		            'description' => 'Normal Customer Sign up'
		            ));
		        $this->db->insert_batch('gp_wallet_activity', $wal_activity);
		        
		        //Normal customer -Create Ledger
                $date = date('Y-m-d');
                $financial_year = get_financial_year();
                $nc_ldg = array(
                                'type_id' => $login_id,
                                '_type' => 'CUSTOMER',
                                'group_id' => 25,
                                'name' => $login_id ."_".$name.'_ledger'
                                );
                $ldg_qry = $this->db->insert('erp_ac_ledgers', $nc_ldg);
                $ldg_id = $this->db->insert_id();
                $opening =  array(
                                'ledger_id' => $ldg_id,
                                'fy_id' => $financial_year,
                                'opening_date' =>$date
                                );
                $open_qry = $this->db->insert('erp_ac_opening_balance', $opening);

				$date = date("Y-m-d h:i:sa") ;
		        $action = "normal customer registration ";
		       	$status = 0;
		       	activity_log($action,$login_id,$status,$date);
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
	//Change normal customer to club member
    function be_club_member()
	{
		$data = array();
		$this->db->trans_begin();
		//$club_plan=$this->input->post('club_plan');
		$datas = getLoginId();
        if($datas){
            $login_id = $datas['login_id'];
            $userid = $datas['user_id'];

            $details = get_details_by_loginid($login_id);

            $datas = array(
			'customer_log_id' => $login_id,
			'parent_log_id' => $details['parent_login_id'],
			'current_parent_log_id' => 1
			);
			$qry = $this->db->insert('gp_be_clubmember', $datas);

        
	        $club_plan = $this->input->post('club_plan');
	        $det1 = getClubtypeById($club_plan);
	        
	        $datas = array('type'=>'club_member' );
	        
	        $det = get_details_by_userid($userid);
	        //$det1 = getClubtypeById($club_plan);
	        $cnt = 0 ;
	        $bde_benefit = $det1['bde_benefit'];
	        $tl_benefit = $det1['tl_benefit'];
	        if($club_plan>0){
	        	$amount = $det1['amount'];//-($bde_benefit+$tl_benefit);
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
                $ledger_payment_cr = getLedgerId($login_id,"CUSTOMER");
		        //$ledger_payment_cr = 71;
	            $entry_items_cr = array(
	                'entry_id' => $entry_id,
	                'ledger_id' => $ledger_payment_cr,
	                'amount' => $amount,
	                'dc' => 'Cr',
	                'fy_id' =>$fy_id,
	                'created_date' => date('Y-m-d')
	            );
	            $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);

	            $ledger_payment_dr = 35;
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
	                $wal_typ = 3;
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
	                    // Debt 
	                    // $ledger_payment_dr2 = 32;
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
	        }
	        $datas['club_type_id'] = $club_plan;
	      
	        $datas['updated_on']=date('Y-m-d h:i:s');
	        $this->db->where('id', $userid);
	        $qry = $this->db->update('gp_normal_customer', $datas);
	        
	        $userLogin = array('parent_login_id'=>1,'type' => 'club_member' ); 
	        $this->db->where('id', $login_id);
	        $qry_login = $this->db->update('gp_login_table', $userLogin);


			$qry_amount = $this->db->query("select id, amount from club_member_type where id = '$club_plan'");
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
            $data['info'] = $details;
        }
        return $data;
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
                    AND  st.id='$user_id'";       
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
        //$fy_year = get_current_financial_year();
        //$fy_id = $fy_year['id'];
    
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
	//upgrade club membership
	function become_club_member($data)
	{	
		$datas = getLoginId();
        if($datas){
            $log_id = $datas['login_id'];
            $id = $datas['user_id'];
        }
		$this->db->trans_begin();
        $this->db->select('club_type_id')
                    ->from('gp_normal_customer')
                    ->where('id',$id);
        $type = $this->db->get()->row()->club_type_id;
        $det1 = getClubtypeById($type);
        $club_plan=$data['club_type_id'];
        $old_id = $this->input->post('cplan');
        // if(isset($club_plan)&&($type!=$club_plan)){
        	// $qry1 = $this->db->query("select * from gp_wallet_values where user_id = '$log_id' AND wallet_type_id='1'");
            //    if($qry1->num_rows()>0)
            //    {
            //        $wal_details = $qry1->row_array();
                
	            $qry_amount = $this->db->query("select id, amount from club_member_type where id = '$club_plan'");
	            if($qry_amount->num_rows()>0)
	            {
	                $get_clubdetails = $qry_amount->row_array();
	                $get_amount = $get_clubdetails['amount'];
	                
	                if(isset($det1['amount'])){
    	                $g_amount = $get_amount - $det1['amount'];
    	                $this->db->set('total_value', 'total_value + ' . (float) $get_amount, FALSE);
    	                $this->db->where('user_id', $log_id);
    	                $this->db->where('wallet_type_id', 1);
    	                $this->db->update('gp_wallet_values');
	                }else{
	                    $g_amount = $get_amount;
	                    $wall_amnt = array(
	                        'total_value' => (float) $get_amount,
	                        'wallet_type_id' =>1,
	                        'user_id'=>$log_id
	                        );
    	                $this->db->insert('gp_wallet_values',$wall_amnt);
	                }
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
			        $entry_dr = $this->db->insert('erp_ac_entryitems', $entry_items_dr);
		        }
           //  }else{
           //  	$qry_amount = $this->db->query("select id, amount from club_member_type where id = '$club_plan'");
	          //   if($qry_amount->num_rows()>0)
	          //   {
	          //       $get_clubdetails = $qry_amount->row_array();
	          //       $get_amount = $get_clubdetails['amount'];
	          //       $wallet = array(
			        //     'wallet_type_id' => 1,
			        //     'user_id' => $log_id,
			        //     'total_value' => $get_amount
			        //     );
			        // $this->db->insert('gp_wallet_values', $wallet);
	          //       $wal_activity = array(
	          //           'wallet_type_id' => 1,
	          //           'user_id' => $log_id,
	          //           'change_value' => $get_amount,
	          //           'date_modified' => date('Y-m-d h:i:s'),
	          //           'description' => 'Upgrade Club Membership'
	          //           );
	          //       $this->db->insert('gp_wallet_activity', $wal_activity);
	          //   }
           //  }
       //  }else{
       //      if(isset($data['fixed_club_type_id'])&&($type==$old_id)&&($club_plan==0)){
       //          $qry_amount = $this->db->query("select id, amount from club_member_type where id = '$old_id'");
       //          if($qry_amount->num_rows()>0)
       //          {
       //              $get_clubdetails = $qry_amount->row_array();
       //              $get_amount = $get_clubdetails['amount'];
       //              $this->db->set('total_value', 'total_value -' . (float) $get_amount, FALSE);
       //              $this->db->where('user_id', $log_id);
       //              $this->db->where('wallet_type_id', 1);
       //              $this->db->update('gp_wallet_values');
       //              $wal_activity = array(
       //                  'wallet_type_id' => 1,
       //                  'user_id' => $log_id,
       //                  'change_value' => $get_amount,
       //                  'date_modified' => date('Y-m-d h:i:s'),
       //                  'description' => 'Upgrade Club Membership'
       //                  );
       //              $this->db->insert('gp_wallet_activity', $wal_activity);
       //          }
       //      }
       //      /*$qry_amount = $this->db->query("select id, amount from club_member_type where id = '$type'");
       //      if($qry_amount->num_rows()>0)
       //      {
       //          $get_clubdetails = $qry_amount->row_array();
       //          $get_amount = $get_clubdetails['amount'];
       //          $this->db->set('total_value', 'total_value -' . (float) $get_amount, FALSE);
       //          $this->db->where('user_id', $log_id);
       //          $this->db->where('wallet_type_id', 1);
       //          $this->db->update('gp_wallet_values');
       //          $wal_activity = array(
		     //        'wallet_type_id' => 1,
		     //        'user_id' => $log_id,
		     //        'change_value' => $get_amount,
		     //        'date_modified' => date('Y-m-d h:i:s'),
		     //        'description' => 'Upgrade Club Membership'
		     //        );
		    	// $this->db->insert('gp_wallet_activity', $wal_activity);
       //      }*/
       //  }

        
        $data['updated_on']=date('Y-m-d h:i:s');
        $this->db->where('id', $id);
        $qry = $this->db->update('gp_normal_customer', $data);

        $date = date("Y-m-d h:i:sa") ;
        $action = "Upgrade Club Membership";
        $status = 0;
        activity_log($action,$log_id,$status,$date);

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $qry2 = "select lg.*,nc.club_type_id,lg.type,nc.fixed_club_type_id from gp_login_table lg left join gp_normal_customer nc on lg.user_id=nc.id where (lg.id='$log_id' and lg.type = 'club_member')";
			$qry2 = $this->db->query($qry2);
			if($qry2->num_rows()>0)
			{
				$dataas = $qry2->row_array();
			}else{
				$dataas =array();
			}
            return $dataas;
        } else {
            $this->db->trans_rollback();
            return false;
        }
	}
	//refered friend  -signup
	function customer_signup($data)
	{
		$this->db->trans_begin();
		$ref=$data['id'];
		$qry = "SELECT * from gp_user_referrel where id=$ref";
		$qry = $this->db->query($qry);

		if($qry->num_rows()>0)
		{
			$user_details = $qry->row_array();
		}
		$api = apikey_generate();
		$otp = random_string('numeric', 4);
		$datas = array(
			'name' => $data['first_name'],
			'phone' => $data['mobile'],
			'email' => $data['email'],
			'parent_id'=>$data['created_by'],
			'otp' => $otp,
            'profile_image' =>'',
			'reg_otp_status' => 0,
			'type' => 'normal_customer',
			'is_del'=> 0,
			'created_by'=>$data['created_by'] ,
			'created_on'=> date("Y-m-d H:i:s"),
			'register_via'=>'club_member',
			'status'=>'approved'
			);
		$qry = $this->db->insert('gp_normal_customer', $datas);
		$insert_id = $this->db->insert_id();
        $data2 = array(
            'customer_id' => $insert_id,
            'lastname' => $data['last_name'],
            'location'=> $user_details['location']
        );
        $qry2 = $this->db->insert('gp_customer_additional_info', $data2);
        $data3 = array(
            'email' =>$data['email'],
            'mobile' => $data['mobile'],
            'password' =>encrypt_decrypt('encrypt',$data['password']),
            'type' => 'normal_customer',
            'otp_status' => 1,
            'user_id'=>$insert_id,
            'parent_login_id'=> $data['created_by'],
            'api_key' =>$api
        );
        $qry3 = $this->db->insert('gp_login_table', $data3);
		$log_id = $this->db->insert_id();
        $data4 = array(
            'email' =>$data['email'],
            'name' => $data['first_name'],
            'status'=>1
        );
        $this->db->where('id',$data['id']);
        $qry4 = $this->db->update('gp_user_referrel', $data4);
        
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
		$wal_activity = array(array(
	        'wallet_type_id' => 2,
	        'user_id' => $log_id,
	        'change_value' => 0,
	        'date_modified' => date('Y-m-d h:i:s'),
	        'description' => 'Normal Customer Sign up'
	        ),array(
	        'wallet_type_id' => 4,
	        'user_id' => $log_id,
	        'change_value' => 0,
	        'date_modified' => date('Y-m-d h:i:s'),
	        'description' => 'Normal Customer Sign up'
	        ));
	    $this->db->insert_batch('gp_wallet_activity', $wal_activity);

		$date = date("Y-m-d h:i:sa") ;
	    $action = "normal customer registration ";
	   	$status = 0;
	   	activity_log($action,$log_id,$status,$date);
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
		$otp = random_string('numeric',4);
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
            'profile_image' =>'',
			'reg_otp_status' => 0,
			'type'=>'club_member'
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
			'parent_login_id'=>1,
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
			$qry_res = "SELECT tb.*,nc.club_type_id,tb.type from gp_login_table tb left join gp_normal_customer nc on tb.user_id=nc.id where tb.user_id = '$user_id' and tb.type = 'club_member'";
			$qry_res = $this->db->query($qry_res);
			if($qry_res->num_rows()>0)
			{
				$login_details = $qry_res->row_array();
				$login_id = $login_details['id'];

				$update_status = array('otp_status' => 1,'type' => 'club_member');
				$this->db->where('id', $login_id);
				$upqry = $this->db->update('gp_login_table', $update_status);


				$wallete = array(
							array('wallet_type_id' => 1,
									'user_id' => $login_id,
									'total_value' => 0
									),
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

		$session_array = $this->session->userdata('logged_in_club_member');
		$id = $session_array['user_id'];
		$log_id = $session_array['id'];
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
			'created_by'=>$log_id,
			'register_via'=>'club_member',
            'type' => 'club_agent',
			'mem_id'=>$log_id,
			'status'=>'notapproved'
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
            'api_key'=>$api,
            'parent_login_id'=>$log_id
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
		$qry_res = "SELECT tb.*,nc.club_type_id,nc.otp from gp_login_table tb left join gp_normal_customer nc on tb.user_id=nc.id where tb.user_id = '$id' and (tb.type = 'club_agent' or tb.type = 'club_member')";
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
		$session_array = $this->session->userdata('logged_in_club_agent');
		$id = $session_array['user_id'];
		$log_id = $session_array['id'];

		$this->db->trans_begin();
		$otp = random_string('numeric', 4);
		$datas = array(
			'name' => $this->input->post('name'),
			'phone' => $this->input->post('mobile'),
			'email' => $this->input->post('email'),
			'otp' => $otp,
            'profile_image' =>'',
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

	function delete_ca($id)
    {
    	$this->db->trans_begin();
        $qry_res = "DELETE lt,nc from gp_login_table lt INNER JOIN gp_normal_customer nc ON lt.user_id=nc.id
         where lt.id = '$id'";
		$qry_res = $this->db->query($qry_res);
		

        $date = date("Y-m-d h:i:s a") ;
        $action = "Club agent has been deleted";
        $datas = getLoginId();
        if($datas){
          $user_id = $datas['user_id'];
        }
        $status = 0;

        activity_log($action,$user_id,$status,$date);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }
    function get_clubplans_by_type($data)
    {
        $type1  = isset($data['type1'])?$data['type1']:'';
        $type2  = isset($data['type2'])?$data['type2']:'';
        $qry1="SELECT * FROM `club_member_type` WHERE is_del ='0' AND type='$type1'";
        $result1=$this->db->query($qry1);
        if($result1->num_rows()>0)
        {
            $data['res1']=$result1->result_array();
        }
        $qry2="SELECT * FROM `club_member_type` WHERE is_del ='0' AND  type='$type2'";
        $result2=$this->db->query($qry2);
        if($result2->num_rows()>0)
        {
            $data['res2']= $result2->result_array();
        }
        if($data)
        {
            return $data;  
        }else {
            return array();
        }
    }
    function add_ba(){
    	$country = $this->input->post('country');
        $mail = $this->input->post('email');
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
        $this->db->trans_begin();
        $datas = getLoginId();
        if($datas){
          $user_id = $datas['user_id'];
          $login_id = $datas['login_id'];
        }
        $created_by = $login_id;
        $created_on = date('Y-m-d H:i:s');
        $name=$this->input->post('name');
        $mobile=$this->input->post('phone');
        $email=$this->input->post('email');
        $company_name=$this->input->post('c_name');
        $office_phone=$this->input->post('c_mobile');
        $office_emailid=$this->input->post('c_email');
        $city=$this->input->post('city');
		$address=$this->input->post('address');
        $country=$this->input->post('country');
        $otp = random_string('numeric', 4);
        $state=$this->input->post('state');
        $api=apikey_generate();
        $data = array(
            'name' => $name,
            'club_mem_id'=>$login_id,
            'mobil_no' =>$mobile,
            'email' =>$email,
            'company_name' =>$company_name,
            'office_phno' =>$office_phone,
            'office_email' =>$office_emailid,
            'city' =>$cityName,
            'country' =>$countryName,
            'state' =>$stateName,
            'address'=>$address,
            'otp' => $otp,
            'created_on' => $created_on,
            'created_by' => $login_id,
            'status'=>'PENDING'
        );
        

        $this->db->insert('pl_ba_registration', $data);
        $insert_id = $this->db->insert_id();
            $data3 = array(
            'email' => $email,
            'mobile' => $mobile,
            'user_id' =>$insert_id,
            'type' => 'ba',
            'otp_status' => 0,
            'api_key' => $api
            // 'parent_login_id'=>$log_id
        );
        $qry3 = $this->db->insert('gp_login_table', $data3);
        $last_userid=$this->db->insert_id();
        $wallete = array(
            array('wallet_type_id' => 2,
                'user_id' => $last_userid,
                'total_value' => 0
            ),
            array('wallet_type_id' => 4,
                'user_id' => $last_userid,
                'total_value' => 0
            )
        );


        $qry3 = $this->db->insert_batch('gp_wallet_values', $wallete);
        $date = date('Y-m-d H:i:s');
        $action = "added ba ";
        $userid=$login_id;
        $status = 0;

        activity_log($action,$userid,$status,$date);


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
    function add_bde()
    {
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
        $this->db->trans_begin();
        $datas = getLoginId();
        if($datas){
          $sid = $datas['login_id'];
        }
        $a  = '1';
        $a1 = $this->input->post('name');
        $a2 = $this->input->post('designation');
        $a3 = $this->input->post('email');
        $a4 = $this->input->post('phone');
        $a5 = $this->input->post('address');
       
        $str = random_password(6);
        
        $date = date('Y-m-d');
        $data = array(  'sales_desig_type_id' => $a2,
                        'name' => $a1,
                        'parent_id' => $sid,
                        'created_by' => $sid,
                        'created_on' => $date,'status'=>'NOT_APPROVED' );
        $data1 = array( 'name' => $a1,
                        'phone' => $a4,
                        'address' => $a5,
                        'email' =>$a3,
                        'country' =>$countryName,
                        'state' => $stateName,
                        'city' => $cityName,
                        'image' =>'default-avatar.png',
                        'status' => '1');
        $data3 = array( 
                        'email' => $a3,
                        'type' => 'executive',
                        'status'=>'NOT_APPROVED'
                        );
     	$qry = $this->db->insert('gp_pl_sales_team_members', $data);
        $lid=$this->db->insert_id();
        $data2 = array('sales_team_member_id' => $lid );
        $appended1 = array_merge($data1,$data2);
        $api=apikey_generate();
        $data4 = array( 'email' => $a3,
                        'type' => 'executive',
                        'user_id' => $lid,
                        'parent_login_id'=>$sid,'api_key' => $api );
        $appended2 = array_merge($data3,$data4);
        $qry1 = $this->db->insert('gp_pl_sales_team_member_details', $appended1);
        $qry2 = $this->db->insert('gp_login_table', $data4);
        $u_id=$this->db->insert_id();
        $data6 = array('wallet_type_id'=>'3',
            'user_id' => $u_id);
        
        $qry3 = $this->db->insert('gp_wallet_values', $data6);
            $action = "Added Executives ";
            $date = date("Y-m-d h:i:sa") ;
            
            $userid=$sid;
            $status = 0;
        activity_log($action,$userid,$status,$date);

        if ($this->db->trans_status() === TRUE)
        {
            $this->db->trans_commit();
            return $u_id;
        }else
        {
            $this->db->trans_rollback();
            return false;
        }
    }
    function refer_ba()
    {
        $mail = $this->input->post('email');
        $this->db->trans_begin();
        $datas = getLoginId();
        if($datas){
          $user_id = $datas['user_id'];
          $login_id = $datas['login_id'];
        }
        $created_by = $login_id;
        $created_on = date('Y-m-d H:i:s');
        $name=$this->input->post('name');
        $mobile=$this->input->post('phone');
        $email=$this->input->post('email');
        $otp = random_string('numeric', 4);
        $data = array(
            'name' => $name,
            'club_mem_id'=>$login_id,
            'mobil_no' =>$mobile,
            'email' =>$email,
            'otp' => $otp,
            'created_on' => $created_on,
            'created_by' => $login_id,
            'status'=>'PENDING'
        );
        

        $this->db->insert('pl_ba_registration', $data);
        // $insert_id = $this->db->insert_id();
        //     $data3 = array(
        //     'email' => $email,
        //     'mobile' => $mobile,
        //     'user_id' =>$insert_id,
        //     'type' => 'ba',
        //     'otp_status' => 0,
        //     // 'parent_login_id'=>$log_id
        // );
        // $qry3 = $this->db->insert('gp_login_table', $data3);
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
    function ba_validation($email,$mobile)
    {
		$data = array();
		$qry2 = "select * from pl_ba_registration where mobil_no = '$mobile' OR email ='$email'";
		$qry2 = $this->db->query($qry2);
		if($qry2->num_rows()>0)
		{
			$data['reason'] = "already Exists";
			$data['status'] = FALSE;
		} else{
			$data['status'] =  TRUE;
		}
		return $data;
    }
    function get_exe()
    {
    	$data = array();
		$qry2 = "SELECT st.name,st.created_on,dtype.designation FROM `gp_pl_sales_team_members` st LEFT JOIN gp_pl_sales_designation_type dtype ON st.sales_desig_type_id=dtype.id ORDER BY st.created_by ASC";
		$qry2 = $this->db->query($qry2);
		if($qry2->num_rows()>0)
		{
			$result = $qry2->result_array();
			foreach ($result as $key => $value) {
				$created_by = $value['created_by'];
				$parent_desig = $this->getDesignation($created_by);
				array_push($data, array('name'=>$value['name'],
					'designation'=>$value['designation'],
					'parent'=>$parent_desig,
					'joined_on'=>$value['created_on'],
					));
			}
		} else{
		}
		return $data;
    }
    function getDesignation($id)
    {
    	$desg = '';
    	$qry = "SELECT * FROM gp_login_table WHERE id='$id'";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			$result = $qry->row_array();
			if($result['type']=='super_admin')
			{
				$desg = 'Jaazzo';
			}elseif($result['type']=='executive'){
				$userid = $result['user_id'];
				$qry2 = "SELECT st.*,dtype.designation FROM `gp_pl_sales_team_members` st LEFT JOIN gp_pl_sales_designation_type dtype ON st.sales_desig_type_id=dtype.id 
				    WHERE st.id='$userid'";
				$qry2 = $this->db->query($qry2);
				if($qry2->num_rows()>0)
				{
					$result2 = $qry2->row_array();
					$desg = $result2['name']."(".$result2['designation'].")";
				}
			}elseif($result['type']=='club_member'){
				$userid = $result['user_id'];
				$qry2 = "SELECT name FROM `gp_normal_customer` nc 
				    WHERE nc.id='$userid'";
				$qry2 = $this->db->query($qry2);
				if($qry2->num_rows()>0)
				{
					$result2 = $qry2->row_array();
					$desg = $result2['name']."(Club Member)";
				}
			}
			return $desg;
		}	
    }
}
?>