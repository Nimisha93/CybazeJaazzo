<?php
/**
* 
*/
class User_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function get_wallete_values_user($login_id)
	{
		$qry = "select
				wal.id,
				wal.wallet_type_id,
				typ.title,
				wal.user_id,
        ROUND(wal.total_value,2) as total_value
				from
				gp_wallet_values wal
				
				left join gp_wallet_types typ on  typ.id = wal.wallet_type_id
				where wal.user_id = ?
				order by typ.title asc";
		$qry = $this->db->query($qry, $login_id);
        //echo $this->db->last_query();exit;
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		} else{
			return array();
		}		
	}
//   function signup_cp($mail,$id){
//         $this->db->trans_begin();
//           $password =encrypt_decrypt('encrypt',$this->input->post('password'));
//           $data_input = array('password'=>$password,'otp_status'=>1,'email'=>$mail);
//           $where = array('id'=>$id);
//           $res = update_tbl('gp_login_table',$data_input,$where);
//           $s_res = select_by_id('gp_login_table',$id);
//           $u_id = $s_res->user_id;
//           $lg_id = $s_res->id;
//           $cr = date("Y-m-d h:i:sa");
//           $date = date("Y-m-d");
//           $cp_data_input = array('status'=>'JOINED','created_on'=>$cr);
//           $cp_where = array('id'=>$u_id);
//           $cp_res = update_tbl('gp_pl_channel_partner',$cp_data_input,$cp_where);
//           if($res)
//           {
//           //wallet
//           $data = array('wallet_type_id' => 4,
//                           'user_id' => $id,
//                           'total_value' => 0
//           );
                   
//               $res = insert('gp_wallet_values', $data);
//               $sel = "id='$u_id'";
//               $rand = random_select($sel,'name','gp_pl_channel_partner','row');
//               //ledger
//               $hr_ldg = array(
//                   'type_id' => $lg_id,
//                   '_type' => 'CHANNEL_PARTNER',
//                   'group_id' => 25,
//                   'name' => $lg_id ."_".$rand->name.'_ledger'
//               );
//               $acc_qry = $this->db->insert('erp_ac_ledgers', $hr_ldg);
//               $hr_led_id = $this->db->insert_id();
//               $fy_year = get_current_financial_year();
//               $fy_id = $fy_year['id'];
//               $opn_blnce = array(
//                   'opening_balance' => '0.00',
//                   'op_balance_dc' => 'Dr',
//                   'ledger_id' => $hr_led_id,
//                   'fy_id' => $fy_id,
//                   'opening_date' => $date
//               );
//               $acc_qry = $this->db->insert('erp_ac_opening_balance', $opn_blnce);
//               //var_dump($hr_led_id);exit();
//               $where = 'gp_login_table.user_id=gp_pl_channel_partner.id';
//               $result = select_all_by_id('gp_login_table',$id,'gp_pl_channel_partner',$where);
//               $club_member = $result->club_mem_id;
//               $club_type = $result->club_type;
            
//               if($club_type=='FIXED'){
//                 $ref_status = $result->is_reffered;
//                   $sql2 = "SELECT * FROM `gp_login_table` where type='channel_partner' and parent_login_id='$club_member' ORDER BY `id`  DESC";
//                   $sqll2 = $this->db->query($sql2);
//                   if($sqll2->num_rows()>0)
//                   {
//                       $cp_count = $sqll2->num_rows();
//                   }else{
//                     $cp_count = 0;
//                   } 
//                 $qry2 = "SELECT nc.created_by,nc.name,nc.id as user_id,nc.fixed_club_type_id,lt.id as login_id,mt.title as plan,mt.cp_status,mt.cp_limit,mt.reward_per_cp,mt.ref_cp_status,mt.ref_cp_limit,mt.ref_reward_per_cp,mt.bde_benefit,mt.ref_bde_benefit FROM `gp_normal_customer` nc 
//                 left join gp_login_table lt ON lt.user_id = nc.id  
//                 left JOIN club_member_type mt ON nc.fixed_club_type_id=mt.id 
//                 WHERE lt.id='$club_member' AND  lt.type='club_member' ";
//                 $query2 = $this->db->query($qry2);
//               // echo $this->db->last_query();exit();
//                 if($query2->num_rows()>0)
//                 {
//                     $details =  $query2->row_array();
//                     //$cp_limit = $details['cp_limit']; 
//                     //$reward_per_cp = $details['reward_per_cp'];
//                     //$bde_benefit = $details['bde_benefit'];
//                     $cp_limit = ($ref_status==0)? $details['cp_limit']: $details['ref_cp_limit'];
//                     $reward_per_cp = ($ref_status==0)? $details['reward_per_cp']: $details['ref_reward_per_cp'];
//                     $bde_benefit = ($ref_status==0)? $details['bde_benefit']: $details['ref_bde_benefit'];
//                     if($cp_limit>$cp_count)
//                     {
//                       $this->db->set('total_value', 'total_value + ' . (float) $reward_per_cp, FALSE);
//                       $this->db->where('user_id', $club_member);
//                       $this->db->where('wallet_type_id', 5);
//                       $this->db->update('gp_wallet_values');
                      
//                       $wal_activity = array(
//                           'wallet_type_id' => 5,
//                           'user_id' => $club_member,
//                           'change_value' => $reward_per_cp,
//                           'date_modified' => date('Y-m-d h:i:s'),
//                           'description' => 'Reward when a new channel partner added'
//                           );
//                       $this->db->insert('gp_wallet_activity', $wal_activity);
//                       /************bde benfit***********/
//                      // $sql5 = "SELECT gp_pl_channel_partner.created_by FROM `gp_pl_channel_partner` where id=$u_id";
                     
//                      // $sqll5 = $this->db->query($sql5);
//                      // echo $this->db->last_query();exit();
//                       //if($sqll5->num_rows()>0)
//                       //{

//                       //   $res = $sqll5->row();
//                       //   $created_by = $res->created_by;
//                       //}
//                       $created_by = $details['created_by'];
//                       $user = get_details_by_loginid($created_by);  
                      
//                       $type=$user['type'];
//                       //var_dump($type);exit;
//                       if($type=='executive'){
                         
//                       $this->db->set('total_value', 'total_value + ' . (float) $bde_benefit, FALSE);
//                       $this->db->where('user_id', $created_by);
//                       $this->db->where('wallet_type_id', 3);
//                       $this->db->update('gp_wallet_values');
                     
//                       $wal_activity1 = array(
//                           'wallet_type_id' => 3,
//                           'user_id' => $created_by,
//                           'change_value' => $bde_benefit,
//                           'date_modified' => date('Y-m-d h:i:s'),
//                           'description' => 'Reward when a new channel partner added'
//                           );
//                       $this->db->insert('gp_wallet_activity', $wal_activity1);



//                       /************Entry Start***********/

//                       $fy_year = get_current_financial_year();
//                       $fy_id = $fy_year['id'];
//                       $no =get_number();
                      
//                         $ent_data1 = array(
//                           'entrytype_id'=>2,
//                           '_type'=>'CLUB_MEMBERSHIP',
//                           'type_id'=>$club_member,
//                           'number'=>$no,
//                           'fy_id' =>$fy_id,
//                           'date'=>date('Y-m-d'),
//                           'dr_total'=>$bde_benefit,
//                           'cr_total'=>$bde_benefit
//                       );
//                       $this->db->insert('erp_ac_entries',$ent_data1);

//                     $entry_id1 = $this->db->insert_id();
//                     $ledger_payment_cr1 = 70;
//                       $entry_items_cr1 = array(
//                           'entry_id' => $entry_id1,
//                           'ledger_id' => $ledger_payment_cr1,
//                           'amount' => $bde_benefit,
//                           'dc' => 'Cr',
//                           'fy_id' =>$fy_id,
//                           'created_date' => date('Y-m-d')
//                       );
//                       $entry_dr1 = $this->db->insert('erp_ac_entryitems', $entry_items_cr1);

//                     }else{
                      
//                       $this->db->set('total_value', 'total_value + ' . (float) $bde_benefit, FALSE);
//                       $this->db->where('user_id', 1);
//                       $this->db->where('wallet_type_id', 4);
//                       $this->db->update('gp_wallet_values');
                     
//                       $wal_activity1 = array(
//                           'wallet_type_id' => 4,
//                           'user_id' => 1,
//                           'change_value' => $bde_benefit,
//                           'date_modified' => date('Y-m-d h:i:s'),
//                           'description' => 'Reward when a new channel partner added'
//                           );
//                       $this->db->insert('gp_wallet_activity', $wal_activity1);



//                       /************Entry Start***********/

//                       $fy_year = get_current_financial_year();
//                       $fy_id = $fy_year['id'];
//                       $no =get_number();
                      
//                         $ent_data1 = array(
//                           'entrytype_id'=>2,
//                           '_type'=>'CLUB_MEMBERSHIP',
//                           'type_id'=>$club_member,
//                           'number'=>$no,
//                           'fy_id' =>$fy_id,
//                           'date'=>date('Y-m-d'),
//                           'dr_total'=>$bde_benefit,
//                           'cr_total'=>$bde_benefit
//                       );
//                       $this->db->insert('erp_ac_entries',$ent_data1);

//                     $entry_id1 = $this->db->insert_id();
//                     $ledger_payment_cr1 = 70;
//                       $entry_items_cr1 = array(
//                           'entry_id' => $entry_id1,
//                           'ledger_id' => $ledger_payment_cr1,
//                           'amount' => $bde_benefit,
//                           'dc' => 'Cr',
//                           'fy_id' =>$fy_id,
//                           'created_date' => date('Y-m-d')
//                       );
//                       $entry_dr1 = $this->db->insert('erp_ac_entryitems', $entry_items_cr1);
//                     }


//                       $ent_data = array(
//                           'entrytype_id'=>2,
//                           '_type'=>'CLUB_MEMBERSHIP',
//                           'type_id'=>$club_member,
//                           'number'=>$no,
//                           'fy_id' =>$fy_id,
//                           'date'=>date('Y-m-d'),
//                           'dr_total'=>$reward_per_cp,
//                           'cr_total'=>$reward_per_cp
//                       );
//                       $this->db->insert('erp_ac_entries',$ent_data);
//                       $entry_id = $this->db->insert_id();
                      
//                       $ledger_payment_dr = 32; 
//                       $entry_items_dr = array(
//                           'entry_id' => $entry_id,
//                           'ledger_id' => $ledger_payment_dr,
//                           'amount' => $reward_per_cp,
//                           'dc' => 'Dr',
//                           'fy_id' =>$fy_id,
//                           'created_date' => date('Y-m-d')
//                       );
//                       $entry_dr = $this->db->insert('erp_ac_entryitems', $entry_items_dr);

//                       $ledger_payment_cr = 71;
//                       $entry_items_cr = array(
//                           'entry_id' => $entry_id,
//                           'ledger_id' => $ledger_payment_cr,
//                           'amount' => $reward_per_cp,
//                           'dc' => 'Cr',
//                           'fy_id' =>$fy_id,
//                           'created_date' => date('Y-m-d')
//                       );
//                       $entry_dr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);
//                       /************Entry End***********/
//                     }
//                     //end cp_limit>cp_count
//                 }
//                 //end nu_rows>0
//               }
//           //end if(fixed)
             
//           }
//           //end if($res)
//         if($this->db->trans_status=false){
//             $this->db->trans_rollback();
//             return false;
//         }
//         else{
//             $this->db->trans_commit();
//             return true;
//         }
//   }
    
	function get_channel_partner()
	{
		$qry = "select cp.id,cp.name,cp.phone from gp_pl_channel_partner cp where cp.is_del = 0 and cp.status = 'joined' and cp.is_active=1";
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
  function signup_cp($mail,$id){
        $this->db->trans_begin();
          $password =encrypt_decrypt('encrypt',$this->input->post('password'));
          $data_input = array('password'=>$password,'otp_status'=>1,'email'=>$mail);
          $where = array('id'=>$id);
          $res = update_tbl('gp_login_table',$data_input,$where);
          $s_res = select_by_id('gp_login_table',$id);
          //echo $this->db->last_query();exit();
          $u_id = $s_res->user_id;
          $lg_id = $s_res->id;
          $cr = date("Y-m-d h:i:sa");
          $date = date("Y-m-d");
          $cp_data_input = array('status'=>'JOINED','created_on'=>$cr);
          $cp_where = array('id'=>$u_id);
          $cp_res = update_tbl('gp_pl_channel_partner',$cp_data_input,$cp_where);
          if($res)
          {
          //walleT
          $data = array('wallet_type_id' => 4,
                          'user_id' => $id,
                          'total_value' => 0
          );
                   
              $res = insert('gp_wallet_values', $data);
              $sel = "id='$u_id'";
              $rand = random_select($sel,'name','gp_pl_channel_partner','row');
              //ledger
              $hr_ldg = array(
                  'type_id' => $lg_id,
                  '_type' => 'CHANNEL_PARTNER',
                  'group_id' => 25,
                  'name' => $lg_id ."_".$rand->name.'_ledger'
              );
              $acc_qry = $this->db->insert('erp_ac_ledgers', $hr_ldg);
              $hr_led_id = $this->db->insert_id();
              $fy_year = get_current_financial_year();
              $fy_id = $fy_year['id'];
              $opn_blnce = array(
                  'opening_balance' => '0.00',
                  'op_balance_dc' => 'Dr',
                  'ledger_id' => $hr_led_id,
                  'fy_id' => $fy_id,
                  'opening_date' => $date
              );
              $acc_qry = $this->db->insert('erp_ac_opening_balance', $opn_blnce);
              $where = 'gp_login_table.user_id=gp_pl_channel_partner.id';
              $result = select_all_by_id('gp_login_table',$id,'gp_pl_channel_partner',$where);
              $club_member = $result->club_mem_id;
              $club_type = $result->club_type;
            
              if($club_type=='FIXED'){
                $ref_status = $result->is_reffered;
                
                $sql2 = "SELECT total_value FROM `gp_wallet_values` where user_id='$club_member' and wallet_type_id=5";
                $sqll2 = $this->db->query($sql2);
                  if($sqll2->num_rows()>0)
                  {
                    $sqll2 = $sqll2->row();
                    $fixed_amount = $sqll2->total_value;
                  }else{
                    $fixed_amount = 0;
                  }
                $sql3 = $this->db->query("SELECT SUM(change_value) AS total FROM `gp_wallet_activity` WHERE wallet_type_id = 5 and user_id='$club_member' and type = 'LOSS'");
             
                  if($sql3->num_rows()>0)
                  {
                    $sql3 = $sql3->row();
                    $fixed_used = $sql3->total;
                  }else{
                    $fixed_used = 0;
                  }

                  $fixed = $fixed_amount + $fixed_used;    
                $qry2 = "SELECT nc.name,nc.id as user_id,nc.fixed_club_type_id,lt.id as login_id,mt.title as plan,mt.cp_status,mt.cp_limit,mt.reward_per_cp,mt.ref_cp_status,mt.ref_cp_limit,mt.ref_reward_per_cp,mt.bde_benefit,mt.ref_bde_benefit,mt.amount as fixed_amount FROM `gp_normal_customer` nc 
                left join gp_login_table lt ON lt.user_id = nc.id  
                left JOIN club_member_type mt ON nc.fixed_club_type_id=mt.id 
                WHERE lt.id='$club_member' AND  lt.type='club_member' ";
                $query2 = $this->db->query($qry2);
                if($query2->num_rows()>0)
                {
                    $details =  $query2->row_array();
                    $fixed_plan_amount = $details['fixed_amount'];
                 
                    $reward_per_cp = ($ref_status==0)? $details['reward_per_cp']: $details['ref_reward_per_cp'];
                    $bde_benefit = ($ref_status==0)? $details['bde_benefit']: $details['ref_bde_benefit'];
                   
                    if($fixed_plan_amount>$fixed)
                    {
                      $fx = $fixed + $reward_per_cp;
            
                      if($fx>$fixed_plan_amount){
                        $reward_per_cp = $fixed_plan_amount - $fx + $reward_per_cp;
                      }
                      $upid = $this->db->where('user_id', $club_member)->where('wallet_type_id', 5)->get('gp_wallet_values')->row()->id;
                      $this->db->set('total_value', 'total_value + ' . (float) $reward_per_cp, FALSE);
                      //$this->db->where('user_id', $club_member);
                      //$this->db->where('wallet_type_id', 5);
                      $this->db->where('id', $upid);
                      $this->db->update('gp_wallet_values');
                      
                      $wal_activity = array(
                          'wallet_type_id' => 5,
                          'wallet_val_id' => $upid,
                          'user_id' => $club_member,
                          'change_value' => $reward_per_cp,
                          'date_modified' => date('Y-m-d h:i:s'),
                          'description' => 'Reward when a new channel partner added'
                          );
                      $this->db->insert('gp_wallet_activity', $wal_activity);
                      /************bde benfit***********/
                  
                    }
                    //end cp_limit>cp_count
                    //FIXED CP BDE BENEFIT
                    $sql5 = "SELECT gp_pl_channel_partner.created_by FROM `gp_pl_channel_partner` where id=$u_id";
                     
                      $sqll5 = $this->db->query($sql5);
                    
                      if($sqll5->num_rows()>0)
                      {

                          $res = $sqll5->row();
                          $created_by = $res->created_by;
                      }
                      $user = get_details_by_loginid($created_by);  
                      
                      $type=$user['type'];

                      if($type=='executive'){
                          $upzid = $this->db->where('user_id', $created_by)->where('wallet_type_id', 3)->get('gp_wallet_values')->row()->id;
                          $this->db->set('total_value', 'total_value + ' . (float) $bde_benefit, FALSE);
                          // $this->db->where('user_id', $created_by);
                          // $this->db->where('wallet_type_id', 3);
                          $this->db->where('id', $upzid);
                          $this->db->update('gp_wallet_values');
                         
                          $wal_activity1 = array(
                              'wallet_type_id' => 3,
                              'user_id' => $created_by,
                              'wallet_val_id' => $upzid,
                              'change_value' => $bde_benefit,
                              'date_modified' => date('Y-m-d h:i:s'),
                              'description' => 'Reward when a new channel partner added'
                              );
                          $this->db->insert('gp_wallet_activity', $wal_activity1);
                          /************Entry Start***********/
                 

                      }else{
                      $upsid = $this->db->where('user_id', 1)->where('wallet_type_id', 4)->get('gp_wallet_values')->row()->id;
                      $this->db->set('total_value', 'total_value + ' . (float) $bde_benefit, FALSE);
                      $this->db->where('id', $upsid);
                      //$this->db->where('wallet_type_id', 4);
                      $this->db->update('gp_wallet_values');
                     
                      $wal_activity1 = array(
                          'wallet_type_id' => 4,
                          'user_id' => 1,
                          'wallet_val_id' => $upsid,
                          'change_value' => $bde_benefit,
                          'date_modified' => date('Y-m-d h:i:s'),
                          'description' => 'Reward when a new channel partner added'
                          );
                      $this->db->insert('gp_wallet_activity', $wal_activity1);

                    }
                  //END FIXED CP BDE BENEFIT
                }
                //end nu_rows>0
              }
           //end if(fixed)
             
          }
          //end if($res)
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
  }
	function transfer_phone($reg_phone)
	{
      $qry= "select logg.id  FROM gp_login_table logg where  logg.mobile='$reg_phone' and (type = 'normal_customer' or type = 'club_member'or type = 'club_agent')";
			$query=$this->db->query($qry);
        //echo $this->db->last_query();exit;
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
          $this->transfer_result($userid,$reg_amount,$login_id,$trans_type);
          $data['msg']='success';
          $data['status']=true;
          //return true;
        }else{
          $data['msg']='You are transferring to a user does not have such wallet';
          $data['status']=false;
          //return false;
        }
			}else{
        $data['msg']='Not Enough amount in your wallet';
        $data['status']=false;
				//return false;
			}
		}else{
      $data['msg']='You have not such a wallet';
      $data['status']=false;
			//return false;
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
       // echo  $sql1 = $this->db->last_query();
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
    }
    else{
        $this->db->trans_commit();
    	return true;
    }
	}		

  function get_normal_customer($id)
	{
        $qry="select gp_login_table.*,gp_normal_customer.*,gpa.lastname,gpa.whatssup_no,gpa.alt_email,gpa.house_name,gpa.house_no,gpa.streat,gpa.road
        ,gpa.location,gpa.area,gpa.city,gpa.post_office,gpa.district,gpa.country,gpa.state,gpa.facebook_id,gpa.twitter,gpa.google_plus from gp_login_table  left join gp_normal_customer
         on gp_login_table.user_id= gp_normal_customer.id inner join gp_customer_additional_info gpa
         on gpa.customer_id =gp_normal_customer.id  where gp_login_table.user_id='$id'";

        $qry=$this->db->query($qry);
       // echo $this->db->last_query();
        if($qry->num_rows()>0){
            $data=$qry->row_array();
        }
        else{
            $data=array();
        }
        return $data;
  }
  function update_normal_customer_byid($id){
      $this->db->trans_begin();
      $datas = getLoginId();
      if($datas){
        $lg_id = $datas['login_id'];
      }
        $data=array(
            'name'=>$this->input->post('name'),
            // 'phone'=>$this->input->post('phone'),
            'phone2'=>$this->input->post('phone2'),
            // 'email'=>$this->input->post('email'),
            'address'=>$this->input->post('address')

        );

        $this->db->where('id',$id);
        $this->db->update('gp_normal_customer',$data);

        /* $datass=array(
            'email'=>$this->input->post('email'),
            'mobile'=>$this->input->post('phone')
            );
         $this->db->where('id',$lg_id);
        $this->db->update('gp_login_table',$datass);
*/
        $data2=array(
            'lastname'=>$this->input->post('lastname'),
            'whatssup_no'=>$this->input->post('whatssup_no'),
            'alt_email'=>$this->input->post('alt_email'),
            'house_name'=>$this->input->post('house_name'),
            'house_no'=>$this->input->post('house_no'),
            'streat'=>$this->input->post('streat'),
            'road'=>$this->input->post('road'),
            'location'=>$this->input->post('location'),
            'area'=>$this->input->post('area'),
            'city'=>$this->input->post('city'),
            'post_office'=>$this->input->post('post_office'),
            'district'=>$this->input->post('district'),
            'country' =>$this->input->post('country'),
            'state' =>$this->input->post('state'),
            'facebook_id'=>$this->input->post('facebook_id'),
            'twitter'=>$this->input->post('twitter'),
            'google_plus'=>$this->input->post('google_plus')
        );

        $this->db->where('customer_id',$id);
        $this->db->update('gp_customer_additional_info',$data2);
       // echo$this->db->last_query();exit;
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
  }
  function update_profile_byid($id){
      $this->db->trans_begin();
      $datas = getLoginId();
      if($datas){
        $lg_id = $datas['login_id'];
      }
        $data=array(
            'name'=>$this->input->post('name')
        );
        $this->db->where('id',$id);
        $this->db->update('gp_normal_customer',$data);

        $data2=array(
            'lastname'=>$this->input->post('lastname'),
            'location'=>$this->input->post('location')
        );
        $this->db->where('customer_id',$id);
        $this->db->update('gp_customer_additional_info',$data2);
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
  }

  function image_add($data){
   	 $session_array = $this->session->userdata('logged_in_user');
       $userid = $session_array['user_id'];
       		$selqry = "select * from profile where user_id = '$userid'";
       		$selqry = $this->db->query($selqry);

       		if($selqry->num_rows()>0){
       			$datass = $selqry->result_array();
       				foreach ($data as $key => $datas) {
       					$del_img = $datas['profile'];


       					unlink(base_url('uploads/'.$del_img));
       					}
       			 $this->db->where('user_id',$userid);
                   
                    $this->db->delete('profile');
       			}
       			
                   



          if($this->input->post('upload')) {
          $img = $data[0]['profile'];
            $image=array('profile_image'=>$img);




                $this->db->where('id',$userid);
                $res= $this->db->update("gp_normal_customer",$image);

               $qry = $this->db->insert_batch('profile',$data);
              echo $this->db->last_query();
               return $qry;
   

   
         $qry = $this->db->insert_batch('profile',$data);
              echo $this->db->last_query();
              return $qry;

        }
  }
  function get_image($id)
	{
        $qry="SELECT * FROM `profile` WHERE user_id='$id'";

        $qry=$this->db->query($qry);
       // echo $this->db->last_query();

        if($qry->num_rows()>0){
            $data=$qry->result_array();
        }
        else{
            $data=array();
        }
        return $data;
  }
  function get_cur_client_img($id)
  {
     $this->db->select("profile");
        $this->db->from('profile');
          $this->db->where('id',$id);
        $query=$this->db->get();
        return $query->row_array();
  }
  public function edit_profile($image_file)
  {  
    $data=array('profile'=>$image_file);
    $this->db->where('id',$id);
    $res= $this->db->update("profile",$data);
    return $res;
  }
  function get_all_club_types()
  {
      $qry = "select
              t.id,
              t.title,
              t.amount
              from
              club_member_type t
              where t.is_del= 0
              order by t.amount asc";
      $qry = $this->db->query($qry);
      //  echo $this->db->last_query();
      if($qry->num_rows()>0)
      {
        return $qry->result_array();
      } else{
        return array();
      }
  }
  //hridya ads
  function get_ads()
  {
    $qry ="SELECT * FROM `advertisement` WHERE type='left' AND is_del='0'";
    
    $qry = $this->db->query($qry);
    if($qry->num_rows()>0)
    {
      return $qry->result_array();
    } else{
      return array();
    } 
  }
  function get_ads_center()
  {
    $qry ="SELECT * FROM `advertisement` WHERE type='center' AND is_del='0'";
    $qry = $this->db->query($qry);
    if($qry->num_rows()>0)
    {
      return $qry->result_array();
    } else{
      return array();
    } 
  }
  function get_ads_right()
  {
    $qry ="SELECT * FROM `advertisement` WHERE type='right' AND is_del='0'";
    $qry = $this->db->query($qry);
    if($qry->num_rows()>0)
    {
      return $qry->result_array();
    } else{
      return array();
    } 
  }
  function get_ads_bottom()
  {
        $qry ="SELECT * FROM `advertisement` WHERE type='bottom' AND is_del='0'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        } else{
            return array();
        }
  }
  function get_current_pass($id)
  {
        $qry = $this->db->query("SELECT password from gp_login_table where id = '$id'");
        //echo $this->db->last_query();
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
  }
  function update_pass($pass, $id)
  {
    $qry = $this->db->query("update gp_login_table set password = '$pass' where id ='$id'");
    return $qry;
  }
    function validate_social_key($oauth_uid)
    {
      $qry = $this->db->query("select lg.*,nc.club_type_id,nc.fixed_club_type_id,nc.investor_type_id from gp_login_table lg left join gp_normal_customer nc on lg.user_id=nc.id where (lg.oauth_uid = '$oauth_uid' and lg.otp_status = 1) and (lg.type ='normal_customer' or lg.type = 'club_member' or lg.type = 'club_agent') UNION select lg.*,lg.id as login_id,lg.user_id as userid,lg.type as type from gp_login_table lg  where (lg.oauth_uid = '$oauth_uid')");
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return false;
        }
    }
    function validate_email($email)
    {
      $qry = $this->db->query("select lg.*,nc.club_type_id,nc.fixed_club_type_id,nc.investor_type_id from gp_login_table lg left join gp_normal_customer nc on lg.user_id=nc.id where (lg.email = '$email' and lg.otp_status = 1) and (lg.type ='normal_customer' or lg.type = 'club_member' or lg.type = 'club_agent') UNION select lg.*,lg.id as login_id,lg.user_id as userid,lg.type as type from gp_login_table lg where (lg.email = '$email')");
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return false;
        }
    } 
    function update_social_key($data,$id)
    {
      $this->db->trans_begin();
        $this->db->where('id',$id);
        $this->db->update('gp_login_table',$data);
      if($this->db->trans_status=false){
        $this->db->trans_rollback();
        return false;
      }else{
        $this->db->trans_commit();
        $qry = $this->db->query("select lg.*,nc.club_type_id from gp_login_table lg left join gp_normal_customer nc on lg.user_id=nc.id where (lg.id= '$id' and lg.otp_status = 1) and (lg.type ='normal_customer' or lg.type = 'club_member' or lg.type = 'club_agent')");
        //echo $this->db->last_query();
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return false;
        }
      }
    }
    function check_quantity($id){
      $qry = $this->db->query("
        SELECT p.quantity,cp.name, cp.address,cp.area as location,p.special_prize,c.coupon_percentage,l.id,ctr.name as country, st.name as state,ct.name as city,DATE_FORMAT(c.coupon_validity,'%d-%b-%Y') as coupon_validity FROM gp_product_details p LEFT join gp_pl_channel_partner cp on p.channel_partner_id = cp.id left join gp_deal_channel_partner_con c on p.id = c.product_id left join gp_login_table l on cp.id = l.user_id left join countries ctr on ctr.id = cp.country LEFT join states st on st.id = cp.state LEFT join cities ct on ct.id = cp.town WHERE p.quantity > 0 and p.id = '$id'");
      if($qry->num_rows()>0)
      {
        return $qry->result_array();
      } else{
        return false;
      }
    }
    function get_deal($datas,$id,$check,$coupon_code)
    {

      $price =(($check[0]['special_prize'] * $check[0]['coupon_percentage']) / $check[0]['special_prize']) * 100;
      $cp_id =$check[0]['id'];
      $uid = $datas['user_id'];
      $lgid = $datas['login_id'];
      $email = $datas['email'];
      
      $data = array(
                'user_id'=>$uid,
                'coupon_code' =>$coupon_code,
                'amount' =>$price,
                'deal_con' =>$this->input->post('deal_id')  
      );
      $this->db->trans_begin();
      $qry = $this->db->insert('coupon', $data);
      $insert_id = $this->db->insert_id();
      $qry_up = $this->db->query("UPDATE gp_product_details p set p.quantity = p.quantity-1 WHERE p.id = '$id'");
      //entry creation
      $fy_year = get_current_financial_year();
      $fy_id = $fy_year['id'];
      $no =get_number();
        $ac_data = array(
            'entrytype_id'=>4,
            '_type'=>'DEAL',
            'type_id'=>$insert_id,
            'number'=>$no,
            'fy_id' =>$fy_id,
            'date'=>date('Y-m-d'),
            'dr_total'=>$price,
            'cr_total'=>$price
        );
        $this->db->insert('erp_ac_entries',$ac_data);
        $entry_id = $this->db->insert_id();
        
        $type = 'CUSTOMER';
        $ledger_payment_cr = getLedgerId($lgid,$type);

        $entry_items_cr = array(
            'entry_id' => $entry_id,
            'ledger_id' => $ledger_payment_cr,
            'amount' => $price,
            'dc' => 'Cr',
            'fy_id' =>$fy_id,
            'created_date' => date('Y-m-d')
        );
        $ledger_payment_dr = '35';
        $entry_items_dr = array(
            'entry_id' => $entry_id,
            'ledger_id' => $ledger_payment_dr,
            'amount' => $price,
            'dc' => 'Dr',
            'fy_id' =>$fy_id,
            'created_date' => date('Y-m-d')
        );
        $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);
        $entry_dr = $this->db->insert('erp_ac_entryitems', $entry_items_dr);
      $this->db->trans_complete();
      if ($this->db->trans_status() === FALSE) {
        $this->db->trans_rollback();
        return FALSE;
      } else {
        $this->db->trans_commit();  
        return TRUE; 
      }
    }
    function fb_sign_up($data)
    {
      $this->db->trans_begin();
      $otp = random_string('numeric',4);
      $api_key = apikey_generate();
      
      $datas = array(
        'email' => $data['email'],
        'name' => $data['name'],
        'otp' => $otp,'type' => 'normal_customer',
        'created_on' => date("Y-m-d H:i:s")
        );
      $qry = $this->db->insert('gp_normal_customer', $datas);

      $insert_id = $this->db->insert_id();
      $data2 = array(
          'customer_id' => $insert_id
      );
      $qry2 = $this->db->insert('gp_customer_additional_info', $data2);
      $userLogin = array(
        'oauth_uid'=>$data['oauth_uid'],
        'oauth_provider'=>$data['oauth_provider'],
        'email' => $data['email'],
        'user_id' => $insert_id,
        'type' => 'normal_customer',
        'otp_status'=>1,
        'parent_login_id'=>1,
        'api_key'=>$api_key
        ); 
      $qry_login = $this->db->insert('gp_login_table', $userLogin);
      $log_id = $this->db->insert_id();
      $wal_data = array(
          array('wallet_type_id' => 2,
                'user_id' => $log_id,
                'total_value' => 0
                ),
          array('wallet_type_id' => 4,
                'user_id' => $log_id,
                'total_value' => 0
                )
        );

        $res = multi_insert('gp_wallet_values', $wal_data);
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
        //-Create Ledger
        $date = date('Y-m-d');
        $financial_year = get_financial_year();
        $mem_ldg = array(
              'type_id' => $log_id,
              '_type' => 'CUSTOMER',
              'group_id' => 25,
              'name' => $log_id ."_".$data['name'].'_ledger'
              );
        $ldg_qry = $this->db->insert('erp_ac_ledgers', $mem_ldg);
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
        return FALSE;
      } else {
        $this->db->trans_commit();
        $qry1 = $this->db->query("select lg.*,nc.* from gp_login_table lg left join gp_normal_customer nc on lg.user_id=nc.id where (lg.id= '$id' and lg.otp_status = 1) and (lg.type ='normal_customer')");
        //echo $this->db->last_query();
        if($qry1->num_rows()>0){
            return $qry1->row_array();
        } else{
            return false;
        }
      }
    }
    function get_all_club_plans($club_type_id){
      $qry = "select
              t.id,
              t.title,
              t.amount,t.description
              from
              club_member_type t
              where t.is_del= 0 AND t.type =(select t.type from club_member_type t where t.id='$club_type_id')
              order by t.amount asc";
      $qry = $this->db->query($qry);
      //  echo $this->db->last_query();
      if($qry->num_rows()>0)
      {
        return $qry->result_array();
      } else{
        return array();
      }
    }
    function update_profile_image($data){
      $this->db->trans_begin();
      $userid = $data['user_id'];
      $selqry = "select * from gp_normal_customer where id = '$userid'";
      $selqry = $this->db->query($selqry);

      if($selqry->num_rows()>0){
        $datass = $selqry->row_array();
        $del_img = $datass['profile_image'];
        if(!empty($del_img)){
          unlink('uploads/'.$del_img);
        }
      }  

      $this->db->where('id',$userid);
      $res= $this->db->update("gp_normal_customer",array('profile_image'=>$data['profile_image']));
      if ($this->db->trans_status() === TRUE) {
        $this->db->trans_commit();
        return true;
      } else {
        $this->db->trans_rollback();
        return false;
      }
  }
  function deactivate_account(){
    $this->db->trans_begin();
    $datas = getLoginId(); 
    if ($datas) {
        $login_id = $datas['login_id'];
        $user_id = $datas['user_id'];
        $type = $datas['type'];
    }
    $comment = $this->input->post('comment');
    $reason = $this->input->post('reason');
    $mail_status = isset($_POST['mail_status'])?1:0;
    $data=array(
            'comments'=>$comment,
            'reason'=>$reason,
            'mail_status'=>$mail_status,
            'login_id' => $login_id,
            'type' => $type
        );
    $this->db->insert('gp_deactivate_account',$data);

    $this->db->where('id',$login_id);
    $this->db->update('gp_login_table',array('is_del'=>1));

    $this->db->where('id',$user_id);
    $this->db->update('gp_normal_customer',array('is_del'=>1));
    
    if ($this->db->trans_status() === TRUE) {
      $this->db->trans_commit();
      return true;
    } else {
      $this->db->trans_rollback();
      return false;
    }
  }
    
}

?>