<?php
/**
* 
*/
class Clubmember_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	function club_member_registration()
	{
		$data = array();
		$this->db->trans_begin();
		$session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['id'];
		$otp = random_string('numeric', 4);
		$datas = array(
			'name' => $this->input->post('_name'),
			'phone' => $this->input->post('phone'),
			'phone2' => $this->input->post('phone2'),
			'pincode' => $this->input->post('pincode'),
			'address' => $this->input->post('address'),
			'email' => $this->input->post('email'),
			'otp' => $otp
			
			);
		$qry = $this->db->insert('gp_normal_customer', $datas);
		$insert_id = $this->db->insert_id();

		$userLogin = array(
			'mobile' => $this->input->post('phone'),
			'email' => $this->input->post('email'),
			'user_id' => $insert_id,
			'type' => 'normal_customer',
			'parent_login_id' => $loginuser
			); 
		$qry_login = $this->db->insert('gp_login_table', $userLogin);

               $date = date("Y-m-d h:i:sa") ;

               $action = "club member registration ";
               $loginsession = $this->session->userdata('logged_in_admin');

               $userid=$loginsession['user_id'];
               $status = 0;

               activity_log($action,$userid,$status,$date);
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
	function validate_otp_reg()
	{
		$this->db->trans_begin();
		$data = array();
		$otp = $this->input->post('reg_otp');
		$phone = $this->input->post('otp_phone');
		$email = $this->input->post('otp_mail');
		$qry = "SELECT * from gp_normal_customer c where c.otp = '$otp' and (c.email = '$email' or c.phone = '$phone')";
		$qry = $this->db->query($qry);
		//var_dump($this->db->last_query());exit;
		if($qry->num_rows()>0)
		{

			$user_details = $qry->row_array();
			$user_id = $user_details['id'];
			$qry_res = "SELECT * from gp_login_table tb where tb.user_id = '$user_id' and tb.type = 'normal_customer'";
			$qry_res = $this->db->query($qry_res);
			if($qry_res->num_rows()>0)
			{
				$login_details = $qry_res->row_array();
				$login_id = $login_details['id'];

				$update_status = array('otp_status' => 1);
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
		}else{
			$data['info'] =  array();
			$data['status'] = FALSE;
		}
		return $data;		
	}
	function get_all_members()
	{
		$session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['id'];
        $qry = "select
				*
				from
				gp_login_table lg 
				where lg.parent_login_id = '$loginuser'";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		}	else{
			return array();
		}	
	}
	function get_member_byId($id)
	{
		$qry = "select
				*
				from
				gp_login_table lg 
				where lg.id = '$id'";
		$qry = $this->db->query($qry);
        //echo $this->db->last_query();exit;
		if($qry->num_rows()>0)
		{
			return $qry->row_array();
		}	else{
			return array();
		}	
	}
	function get_club_types()
	{
		$qry = "select ty.id, ty.title, ty.amount, ty.cash_limit from club_member_type ty where ty.is_del = 0";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		}	else{
			return array();
		}
	}
	function club_payment()
	{
		$session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['id'];
		//var_dump($this->input->post());
        $this->db->trans_begin();
		$user_id = $this->input->post('user_id');
		$lg_id = $this->input->post('log_id');
		$type = $this->input->post('type');
		$qry = "select ty.id, ty.title, ty.amount, ty.pooling_commision, ty.cash_limit from club_member_type ty where ty.is_del = 0 and ty.id = '$type'";
		$qry = $this->db->query($qry);
		$type_details = $qry->row_array();
		$amount = $type_details['amount'];
		$pooling_perc = $type_details['pooling_commision'];
		$pooling_amt = ($amount * $pooling_perc)/100;

		// get BHC percentage
		$qry_perc = "select * from gp_pl_pool_extra_benefit b where b.id = 1 or b.title = 'BCH'";
		$qry_perc = $this->db->query($qry_perc);
		$bch_details = $qry_perc->row_array();
		//var_dump($bch_details);exit;
		$bch_perc = $bch_details['percentage'];

		$bch_amount = ($pooling_amt * $bch_perc)/100;

		$this->db->set('total_value', 'total_value + ' . (float) $bch_amount, FALSE);
        $this->db->where('user_id', $loginuser);
        $this->db->where('wallet_type_id', 3);
        $this->db->update('gp_wallet_values');
               $date = date("Y-m-d h:i:sa") ;

               $action = "club payment  ";
               $loginsession = $this->session->userdata('logged_in_admin');

               $userid=$loginsession['user_id'];
               $status = 0;

               activity_log($action,$userid,$status,$date);


        //echo $this->db->last_query();

        $wal_activity = array(
            'wallet_type_id' => 3,
            'user_id' => $loginuser,
            'change_value' => $bch_amount,
            'date_modified' => date('Y-m-d h:i:s'),
            'description' => 'Reward when Registerd a Club Member'
            );
        $this->db->insert('gp_wallet_activity', $wal_activity);

       $date = date("Y-m-d h:i:sa") ;

               $action = "Added reward  ";
               $loginsession = $this->session->userdata('logged_in_admin');

               $userid=$loginsession['user_id'];
               $status = 0;

               activity_log($action,$userid,$status,$date);

        
		// end BCH get percentage
        // convert club type 
        $up_array = array('type' => 'club_member'); 
        $this->db->where('id', $lg_id);
        $this->db->update('gp_login_table', $up_array);
       
        $up_reg_tb = array('club_type_id' => $type);
        $this->db->where('id', $user_id);
        $this->db->update('gp_normal_customer', $up_reg_tb);
        // end convert club type 
        // Club Wallet
        	$wal_qry = "select * from gp_wallet_values v where v.user_id = '$lg_id' and v.wallet_type_id = 1";
        	$wal_qry = $this->db->query($wal_qry);
        	if($wal_qry->num_rows()>0)
        	{

        	} else{
        		$wal_arr = array('wallet_type_id' => 1, 'user_id' => $lg_id, 'total_value' =>0);
        		$ins = $this->db->insert('gp_wallet_values', $wal_arr);
        	}
        // End Club Wallet
		// Pooling
		// Group Pooling
                $grp_sttgs = $this->get_bch_group_pooling_settings();

                foreach ($grp_sttgs as $key => $sttgs)
                {

                    $grp_id = $sttgs['id'];
                    $perc_each_grp = ($pooling_amt * $sttgs['percentage'])/100;

                    $sel_gp_memb = "select * from gp_pl_pool_bch_group_members mem where mem.bch_grp_id = '$grp_id'";
                    $sel_gp_memb = $this->db->query($sel_gp_memb);
                    if($sel_gp_memb && $sel_gp_memb->num_rows()> 0)
                    {
                        $pool_eff_membs = $sel_gp_memb->result_array();
                        $new_id = 0;
                        foreach ($pool_eff_membs as $key => $pool_eff_memb)
                        {
                            if($key == 0){
                               $old_id = $user_id;
                            }else{
                                $old_id = $new_id;
                            }
                            $desig_type = $pool_eff_memb['designation_type_id'];
                            $pool_perc = $pool_eff_memb['percentage'];
                            $parent_reward_rs = ($pool_perc * $perc_each_grp)/100;
                                $old_id = $old_id + $new_id - $new_id;
                                $get_parent_id_qry = "select * from gp_login_table where id = '$old_id'";
                                $get_parent_id_qry = $this->db->query($get_parent_id_qry);
                                if($get_parent_id_qry && $get_parent_id_qry->num_rows() >0)
                                {
                                    $get_login_details = $get_parent_id_qry->row_array();
                                    $new_id = $get_login_details['parent_login_id'];

                                       if($new_id == 0)
                                        {
                                            // update admin wallet
                                            $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                            $this->db->where('user_id', 13);
                                            $this->db->where('wallet_type_id', 4);
                                            $this->db->update('gp_wallet_values');
                                        //    echo $this->db->last_query();
                                            $wal_activitys = array(
                                                'wallet_type_id' => 4,
                                                'user_id' => 13,
                                                'change_value' => $parent_reward_rs,
                                                'date_modified' => date('Y-m-d h:i:s'),
                                                'description' => 'Reward when BCH club registration Parent is zero group Pooling'
                                            );
                                            $this->db->insert('gp_wallet_activity', $wal_activitys);
                                        } else
                                        {
                                            $lg_qry = "select * from gp_login_table lg where lg.id = '$new_id'";
                                            $lg_qry = $this->db->query($lg_qry);
                                            if($lg_qry && $lg_qry->num_rows()>0)
                                            {
                                                $lg_result = $lg_qry->row_array();
                                                $lg_id = $lg_result['id'];
                                                $lg_user_id = $lg_result['user_id'];
                                                $exe_qry =  "select * from gp_pl_sales_team_members mem where mem.id = '$lg_user_id'";
                                                $exe_qry = $this->db->query($exe_qry);
                                                if($exe_qry && $exe_qry->num_rows()>0)
                                                {
                                                    $res_exe = $exe_qry->row_array();
                                                    $exe_desig_id = $res_exe['sales_desig_type_id'];
                                                    if($exe_desig_id == $desig_type)
                                                    {
                                                        $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                        $this->db->where('user_id', $new_id);
                                                        $this->db->where('wallet_type_id', 2);
                                                        $this->db->update('gp_wallet_values');
                                                    //    echo $this->db->last_query();
                                                        $wal_activiti = array(
                                                            'wallet_type_id' => 2,
                                                            'user_id' => $new_id,
                                                            'change_value' => $parent_reward_rs,
                                                            'date_modified' => date('Y-m-d h:i:s'),
                                                            'description' => 'Reward when chiled purchased'
                                                            );
                                                        $this->db->insert('gp_wallet_activity', $wal_activiti);

                                                    } else
                                                    {
                                                        $get_new_id = $this->get_parent_from_login($lg_id, $desig_type,$parent_reward_rs);
                                                       // var_dump($get_new_id);
                                                        $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                        $this->db->where('user_id', $get_new_id);
                                                        $this->db->where('wallet_type_id', 2);
                                                        $this->db->update('gp_wallet_values');
                                                    //    echo $this->db->last_query();
                                                        $wal_activitys = array(
                                                            'wallet_type_id' => 2,
                                                            'user_id' => $get_new_id,
                                                            'change_value' => $parent_reward_rs,
                                                            'date_modified' => date('Y-m-d h:i:s'),
                                                            'description' => 'Reward when chiled converted to club member by BCH'
                                                            );
                                                        $this->db->insert('gp_wallet_activity', $wal_activitys);

                                                    }

                                                }else{
                                                    $res_exe = array();

                                                    //get reward to admin when no sales members

                                                    // update admin wallet
                                                    $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                    $this->db->where('user_id', 13);
                                                    $this->db->where('wallet_type_id', 4);
                                                    $this->db->update('gp_wallet_values');
                                                 //   echo $this->db->last_query();
                                                    $wall_activitys = array(
                                                        'wallet_type_id' => 4,
                                                        'user_id' => 13,
                                                        'change_value' => $parent_reward_rs,
                                                        'date_modified' => date('Y-m-d h:i:s'),
                                                        'description' => 'get reward to admin when no sales members'
                                                    );
                                                    $this->db->insert('gp_wallet_activity', $wall_activitys);

                                                }


                                            } else{
                                                $lg_result = array();
                                                // get reward to admin when no user
                                                // update admin wallet
                                                $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                $this->db->where('user_id', 13);
                                                $this->db->where('wallet_type_id', 4);
                                                $this->db->update('gp_wallet_values');
                                             //   echo $this->db->last_query();
                                                $wall_activitys = array(
                                                    'wallet_type_id' => 4,
                                                    'user_id' => 13,
                                                    'change_value' => $parent_reward_rs,
                                                    'date_modified' => date('Y-m-d h:i:s'),
                                                    'description' => 'get reward to admin when no sales members'
                                                );
                                                $this->db->insert('gp_wallet_activity', $wall_activitys);

                                                // $date = date("Y-m-d h:i:sa") ;
                                                // $action = "delete Advertisement ";
                                                // $loginsession = $this->session->userdata('logged_in_admin');

                                                // $userid=$loginsession['user_id'];
                                                // $status = 0;

                                                //  activity_log($action,$userid,$status,$date);


                                                
               
                                            }
                                        }


                                }else{
                                    // get reward to admin when no parent
                                    // update admin wallet
                                    $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                    $this->db->where('user_id', 13);
                                    $this->db->where('wallet_type_id', 4);
                                    $this->db->update('gp_wallet_values');
                                 ///  echo $this->db->last_query();
                                    $wall_activitys = array(
                                        'wallet_type_id' => 4,
                                        'user_id' => 13,
                                        'change_value' => $parent_reward_rs,
                                        'date_modified' => date('Y-m-d h:i:s'),
                                        'description' => 'get reward to admin when no parent'
                                    );
                                    $this->db->insert('gp_wallet_activity', $wall_activitys);
                                }

                        }

                    }else{
                        $pool_eff_membs = array();
                    }

                }


        // stage pooling

        // Stage Pooling
        $stage_sttgs = $this->get_bch_pooling_stage_settings();
        foreach ($stage_sttgs as $key => $stg_sttgs)
        {
            $stag_id = $stg_sttgs['id'];
            $stag_percentage = ($pooling_amt * $stg_sttgs['percentage'])/100;
            $sel_stage_memb = "select * from gp_pl_pool_bch_stage_members s where s.bch_stg_id = '$stag_id'";
            $sel_stage_memb = $this->db->query($sel_stage_memb);
            if($sel_stage_memb && $sel_stage_memb->num_rows()> 0)
            {
                $stag_pool_effec = $sel_stage_memb->result_array();
                $stg_new_id = 0;
                foreach ($stag_pool_effec as $key => $stg_pool_eff_memb)
                {
                    if($key == 0){
                        $stg_old_id = $user_id;
                    }else{
                        $stg_old_id = $stg_new_id;
                    }
                    //$desig_type = $stg_pool_eff_memb['designation_type_id'];
                    $stg_pool_perc = $stg_pool_eff_memb['percentage'];
                    $parent_stg_reward_rs = ($stg_pool_perc * $stag_percentage)/100;
                    $stg_old_id = $stg_old_id + $stg_new_id - $stg_new_id;
                    $get_stg_parent_id_qry = "select * from gp_login_table where id = '$stg_old_id'";
                    $get_stg_parent_id_qry = $this->db->query($get_stg_parent_id_qry);
                    if($get_stg_parent_id_qry && $get_stg_parent_id_qry->num_rows() >0)
                    {
                        $get_stg_login_details = $get_stg_parent_id_qry->row_array();
                        $stg_new_id = $get_stg_login_details['parent_login_id'];
                        if($stg_new_id == 0)
                        {
                            // update admin wallet
                            $this->db->set('total_value', 'total_value + ' . (float) $parent_stg_reward_rs, FALSE);
                            $this->db->where('user_id', 13);
                            $this->db->where('wallet_type_id', 4);
                            $this->db->update('gp_wallet_values');
                           // echo $this->db->last_query();
                            $wal_stg_activitys = array(
                                'wallet_type_id' => 4,
                                'user_id' => 13,
                                'change_value' => $parent_stg_reward_rs,
                                'date_modified' => date('Y-m-d h:i:s'),
                                'description' => 'Reward when Parent is zero Stage Pooling(bch club registration)'
                            );
                            $this->db->insert('gp_wallet_activity', $wal_stg_activitys);
                        } else{
                            $lg_stag_qry = "select * from gp_login_table lg where lg.id = '$stg_new_id'";
                            $lg_stag_qry = $this->db->query($lg_stag_qry);
                            if($lg_stag_qry && $lg_stag_qry->num_rows()>0)
                            {
                                $lg_stg_result = $lg_stag_qry->row_array();
                                $log_stag_id = $lg_stg_result['id'];
                                $lg_stg_user_id = $lg_stg_result['user_id'];

                                $this->db->set('total_value', 'total_value + ' . (float) $parent_stg_reward_rs, FALSE);
                                $this->db->where('user_id', $stg_new_id);
                                $this->db->where('wallet_type_id', 2);
                                $this->db->update('gp_wallet_values');
                              //  echo $this->db->last_query();
                                $wal_stg_activitysss = array(
                                    'wallet_type_id' => 2,
                                    'user_id' => $stg_new_id,
                                    'change_value' => $parent_stg_reward_rs,
                                    'date_modified' => date('Y-m-d h:i:s'),
                                    'description' => 'Reward when chiled purchased (bch club registration)'
                                );
                                $this->db->insert('gp_wallet_activity', $wal_stg_activitysss);


                            }else{
                                // update admin wallet
                                $this->db->set('total_value', 'total_value + ' . (float) $parent_stg_reward_rs, FALSE);
                                $this->db->where('user_id', 13);
                                $this->db->where('wallet_type_id', 4);
                                $this->db->update('gp_wallet_values');
                                //echo $this->db->last_query();
                                $wal_stg_activityss = array(
                                    'wallet_type_id' => 4,
                                    'user_id' => 13,
                                    'change_value' => $parent_stg_reward_rs,
                                    'date_modified' => date('Y-m-d h:i:s'),
                                    'description' => 'Reward when Parent is zero Stage Pooling (bch club registration)'
                                );
                                $this->db->insert('gp_wallet_activity', $wal_stg_activityss);

                            }
                        }
                    } else{
                        // update admin wallet
                        $this->db->set('total_value', 'total_value + ' . (float) $parent_stg_reward_rs, FALSE);
                        $this->db->where('user_id', 13);
                        $this->db->where('wallet_type_id', 4);
                        $this->db->update('gp_wallet_values');
                      //  echo $this->db->last_query();
                        $waal_stg_activitys = array(
                            'wallet_type_id' => 4,
                            'user_id' => 13,
                            'change_value' => $parent_stg_reward_rs,
                            'date_modified' => date('Y-m-d h:i:s'),
                            'description' => 'Reward when Parent is zero Stage Pooling (bch club registration)'
                        );
                        $this->db->insert('gp_wallet_activity', $waal_stg_activitys);
                    }
                }

            }else {
                $stag_poop_effec = array();
            }

        }
		// end Stage pooling
        $this->db->trans_complete();
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
	}
	function get_bch_group_pooling_settings()
	{
		$qry = "select grp.id, grp.title, grp.percentage, grp.no_of_levels from gp_pl_pool_bch_group_settings grp";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0)
		{
			return $qry->result_array();
		} else{
			return array();
		}
	}

    function get_bch_pooling_stage_settings()
    {
        $qry_stg_pool_set = "select stg.id, stg.title, stg.percentage, stg.no_of_levels from gp_pl_pool_bch_stage_settings stg";
        $qry_stg_pool_set = $this->db->query($qry_stg_pool_set);
        if($qry_stg_pool_set->num_rows()>0)
        {
            return $qry_stg_pool_set->result_array();
        }else{
            return array();
        }
    }
	function get_parent_from_login($login_id, $desig_type_id,$parent_reward_rs)
    {      
        $qry = "select * from gp_login_table lg where lg.id = '$login_id'";       
        $lg_qry = $this->db->query($qry);
        if($lg_qry && $lg_qry->num_rows()>0)
        {

            $lg_result = $lg_qry->row_array();
            $parent_id = $lg_result['parent_login_id'];
            if($parent_id == 0){
                // update admin wallet
                $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                $this->db->where('user_id', 13);
                $this->db->where('wallet_type_id', 4);
                $this->db->update('gp_wallet_values');
              //  echo $this->db->last_query();
                $wal_activitys = array(
                    'wallet_type_id' => 4,
                    'user_id' => 13,
                    'change_value' => $parent_reward_rs,
                    'date_modified' => date('Y-m-d h:i:s'),
                    'description' => 'Reward when chiled purchased'
                );
                $this->db->insert('gp_wallet_activity', $wal_activitys);
                return true;
            }else{
                $lg_user_id = $lg_result['user_id'];
                $exe_qry =  "select * from gp_pl_sales_team_members mem where mem.id = '$lg_user_id'";
                $exe_qry = $this->db->query($exe_qry);
                // echo '2'.$this->db->last_query();
                if($exe_qry && $exe_qry->num_rows()>0)
                {
                    $result_sales = $exe_qry->row_array();
                    $desig_id = $result_sales['sales_desig_type_id'];
                    $des_type = $desig_type_id;
                    if($des_type == $desig_id)
                    {
                        return $login_id;

                    } else{
                        return  $this->get_parents_login($parent_id, $desig_type_id,$parent_reward_rs);
                    }
                }else{
                    return array();
                }
            }


        } else{
            $lg_result = array();
        }   
    }
    function get_parents_login($parent_id, $desig_type_id,$parent_reward_rs)
    {
        $qry = "select * from gp_login_table lg where lg.id = '$parent_id'";
        $lg_qry = $this->db->query($qry);
        if($lg_qry && $lg_qry->num_rows()>0)
        {
            $lg_result = $lg_qry->row_array();
            $lg_id = $lg_result['id'];
           return $this->get_parent_from_login($lg_id,$desig_type_id,$parent_reward_rs);
        }else{
           return $this->get_parent_from_login($parent_id,$desig_type_id,$parent_reward_rs);
        }
    }



    function club_ba_payment()
    {
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['id'];
        //var_dump($this->input->post());
        $this->db->trans_begin();
        $user_id = $this->input->post('user_id');
        $lg_id = $this->input->post('log_id');
        $type = $this->input->post('type');
        $qry = "select ty.id, ty.title, ty.amount, ty.pooling_commision, ty.cash_limit from club_member_type ty where ty.is_del = 0 and ty.id = '$type'";
        $qry = $this->db->query($qry);
        $type_details = $qry->row_array();
        $amount = $type_details['amount'];
        $pooling_perc = $type_details['pooling_commision'];
        $pooling_amt = ($amount * $pooling_perc)/100;

        // get BHC percentage
        $qry_perc = "select * from gp_pl_pool_extra_benefit b where b.id = 2 or b.title = 'BA'";
        $qry_perc = $this->db->query($qry_perc);
        $bch_details = $qry_perc->row_array();
        //var_dump($bch_details);exit;
        $bch_perc = $bch_details['percentage'];

        $bch_amount = ($pooling_amt * $bch_perc)/100;

        $this->db->set('total_value', 'total_value + ' . (float) $bch_amount, FALSE);
        $this->db->where('user_id', $loginuser);
        $this->db->where('wallet_type_id', 3);
        $this->db->update('gp_wallet_values');
        echo $this->db->last_query();

        $wal_activity = array(
            'wallet_type_id' => 3,
            'user_id' => $loginuser,
            'change_value' => $bch_amount,
            'date_modified' => date('Y-m-d h:i:s'),
            'description' => 'Reward when Registerd a Club Member'
            );
        $this->db->insert('gp_wallet_activity', $wal_activity);
        
        // end BCH get percentage
        // convert club type 
        $up_array = array('type' => 'club_member'); 
        $this->db->where('id', $lg_id);
        $this->db->update('gp_login_table', $up_array);
       
        $up_reg_tb = array('club_type_id' => $type);
        $this->db->where('id', $user_id);
        $this->db->update('gp_normal_customer', $up_reg_tb);
        // end convert club type 
        // Club Wallet
            $wal_qry = "select * from gp_wallet_values v where v.user_id = '$lg_id' and v.wallet_type_id = 1";
            $wal_qry = $this->db->query($wal_qry);
            if($wal_qry->num_rows()>0)
            {

            } else{
                $wal_arr = array('wallet_type_id' => 1, 'user_id' => $lg_id, 'total_value' =>0);
                $ins = $this->db->insert('gp_wallet_values', $wal_arr);
            }
        // End Club Wallet
        // Pooling
        // Group Pooling
                $grp_sttgs = $this->get_ba_group_pooling_settings();

                foreach ($grp_sttgs as $key => $sttgs)
                {

                    $grp_id = $sttgs['id'];
                    $perc_each_grp = ($pooling_amt * $sttgs['percentage'])/100;

                    $sel_gp_memb = "select * from gp_pl_pool_ba_group_members mem where mem.bch_grp_id = '$grp_id'";
                    $sel_gp_memb = $this->db->query($sel_gp_memb);
                    if($sel_gp_memb && $sel_gp_memb->num_rows()> 0)
                    {
                        $pool_eff_membs = $sel_gp_memb->result_array();
                        $new_id = 0;
                        foreach ($pool_eff_membs as $key => $pool_eff_memb)
                        {
                            if($key == 0){
                               $old_id = $user_id;
                            }else{
                                $old_id = $new_id;
                            }
                            $desig_type = $pool_eff_memb['designation_type_id'];
                            $pool_perc = $pool_eff_memb['percentage'];
                            $parent_reward_rs = ($pool_perc * $perc_each_grp)/100;
                                $old_id = $old_id + $new_id - $new_id;
                                $get_parent_id_qry = "select * from gp_login_table where id = '$old_id'";
                                $get_parent_id_qry = $this->db->query($get_parent_id_qry);
                                if($get_parent_id_qry && $get_parent_id_qry->num_rows() >0)
                                {
                                    $get_login_details = $get_parent_id_qry->row_array();
                                    $new_id = $get_login_details['parent_login_id'];

                                       if($new_id == 0)
                                        {
                                            // update admin wallet
                                            $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                            $this->db->where('user_id', 13);
                                            $this->db->where('wallet_type_id', 4);
                                            $this->db->update('gp_wallet_values');
                                          echo $this->db->last_query();
                                            $wal_activitys = array(
                                                'wallet_type_id' => 4,
                                                'user_id' => 13,
                                                'change_value' => $parent_reward_rs,
                                                'date_modified' => date('Y-m-d h:i:s'),
                                                'description' => 'Reward when BA club registration Parent is zero group Pooling'
                                            );
                                            $this->db->insert('gp_wallet_activity', $wal_activitys);
                                        } else
                                        {
                                            $lg_qry = "select * from gp_login_table lg where lg.id = '$new_id'";
                                            $lg_qry = $this->db->query($lg_qry);
                                            if($lg_qry && $lg_qry->num_rows()>0)
                                            {
                                                $lg_result = $lg_qry->row_array();
                                                $lg_id = $lg_result['id'];
                                                $lg_user_id = $lg_result['user_id'];
                                                $exe_qry =  "select * from gp_pl_sales_team_members mem where mem.id = '$lg_user_id'";
                                                $exe_qry = $this->db->query($exe_qry);
                                                if($exe_qry && $exe_qry->num_rows()>0)
                                                {
                                                    $res_exe = $exe_qry->row_array();
                                                    $exe_desig_id = $res_exe['sales_desig_type_id'];
                                                    if($exe_desig_id == $desig_type)
                                                    {
                                                        $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                        $this->db->where('user_id', $new_id);
                                                        $this->db->where('wallet_type_id', 2);
                                                        $this->db->update('gp_wallet_values');
                                                    
                                                        $wal_activiti = array(
                                                            'wallet_type_id' => 2,
                                                            'user_id' => $new_id,
                                                            'change_value' => $parent_reward_rs,
                                                            'date_modified' => date('Y-m-d h:i:s'),
                                                            'description' => 'Reward when chiled purchased'
                                                            );
                                                        $this->db->insert('gp_wallet_activity', $wal_activiti);

                                                    } else
                                                    {
                                                        $get_new_id = $this->get_parent_from_login($lg_id, $desig_type,$parent_reward_rs);
                                                       // var_dump($get_new_id);
                                                        $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                        $this->db->where('user_id', $get_new_id);
                                                        $this->db->where('wallet_type_id', 2);
                                                        $this->db->update('gp_wallet_values');
                                                      echo $this->db->last_query();
                                                        $wal_activitys = array(
                                                            'wallet_type_id' => 2,
                                                            'user_id' => $get_new_id,
                                                            'change_value' => $parent_reward_rs,
                                                            'date_modified' => date('Y-m-d h:i:s'),
                                                            'description' => 'Reward when child converted to club member by BA'
                                                            );
                                                        $this->db->insert('gp_wallet_activity', $wal_activitys);

                                                    }

                                                }else{
                                                    $res_exe = array();

                                                    //get reward to admin when no sales members

                                                    // update admin wallet
                                                    $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                    $this->db->where('user_id', 13);
                                                    $this->db->where('wallet_type_id', 4);
                                                    $this->db->update('gp_wallet_values');
                                                  echo $this->db->last_query();
                                                    $wall_activitys = array(
                                                        'wallet_type_id' => 4,
                                                        'user_id' => 13,
                                                        'change_value' => $parent_reward_rs,
                                                        'date_modified' => date('Y-m-d h:i:s'),
                                                        'description' => 'get reward to admin when no sales members'
                                                    );
                                                    $this->db->insert('gp_wallet_activity', $wall_activitys);

                                                }


                                            } else{
                                                $lg_result = array();
                                                // get reward to admin when no user
                                                // update admin wallet
                                                $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                $this->db->where('user_id', 13);
                                                $this->db->where('wallet_type_id', 4);
                                                $this->db->update('gp_wallet_values');
                                              echo $this->db->last_query();
                                                $wall_activitys = array(
                                                    'wallet_type_id' => 4,
                                                    'user_id' => 13,
                                                    'change_value' => $parent_reward_rs,
                                                    'date_modified' => date('Y-m-d h:i:s'),
                                                    'description' => 'get reward to admin when no sales members'
                                                );
                                                $this->db->insert('gp_wallet_activity', $wall_activitys);
                                            }
                                        }


                                }else{
                                    // get reward to admin when no parent
                                    // update admin wallet
                                    $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                    $this->db->where('user_id', 13);
                                    $this->db->where('wallet_type_id', 4);
                                    $this->db->update('gp_wallet_values');
                                  echo $this->db->last_query();
                                    $wall_activitys = array(
                                        'wallet_type_id' => 4,
                                        'user_id' => 13,
                                        'change_value' => $parent_reward_rs,
                                        'date_modified' => date('Y-m-d h:i:s'),
                                        'description' => 'get reward to admin when no parent'
                                    );
                                    $this->db->insert('gp_wallet_activity', $wall_activitys);
                                }

                        }

                    }else{
                        $pool_eff_membs = array();
                    }

                }


        // stage pooling

        // Stage Pooling
        $stage_sttgs = $this->get_ba_pooling_stage_settings();
        foreach ($stage_sttgs as $key => $stg_sttgs)
        {
            $stag_id = $stg_sttgs['id'];
            $stag_percentage = ($pooling_amt * $stg_sttgs['percentage'])/100;
            $sel_stage_memb = "select * from gp_pl_pool_ba_stage_members s where s.bch_stg_id = '$stag_id'";
            $sel_stage_memb = $this->db->query($sel_stage_memb);
            if($sel_stage_memb && $sel_stage_memb->num_rows()> 0)
            {
                $stag_pool_effec = $sel_stage_memb->result_array();
                $stg_new_id = 0;
                foreach ($stag_pool_effec as $key => $stg_pool_eff_memb)
                {
                    if($key == 0){
                        $stg_old_id = $user_id;
                    }else{
                        $stg_old_id = $stg_new_id;
                    }
                    //$desig_type = $stg_pool_eff_memb['designation_type_id'];
                    $stg_pool_perc = $stg_pool_eff_memb['percentage'];
                    $parent_stg_reward_rs = ($stg_pool_perc * $stag_percentage)/100;
                    $stg_old_id = $stg_old_id + $stg_new_id - $stg_new_id;
                    $get_stg_parent_id_qry = "select * from gp_login_table where id = '$stg_old_id'";
                    $get_stg_parent_id_qry = $this->db->query($get_stg_parent_id_qry);
                    if($get_stg_parent_id_qry && $get_stg_parent_id_qry->num_rows() >0)
                    {
                        $get_stg_login_details = $get_stg_parent_id_qry->row_array();
                        $stg_new_id = $get_stg_login_details['parent_login_id'];
                        if($stg_new_id == 0)
                        {
                            // update admin wallet
                            $this->db->set('total_value', 'total_value + ' . (float) $parent_stg_reward_rs, FALSE);
                            $this->db->where('user_id', 13);
                            $this->db->where('wallet_type_id', 4);
                            $this->db->update('gp_wallet_values');
                           echo $this->db->last_query();
                            $wal_stg_activitys = array(
                                'wallet_type_id' => 4,
                                'user_id' => 13,
                                'change_value' => $parent_stg_reward_rs,
                                'date_modified' => date('Y-m-d h:i:s'),
                                'description' => 'Reward when Parent is zero Stage Pooling(BA club registration)'
                            );
                            $this->db->insert('gp_wallet_activity', $wal_stg_activitys);
                        } else{
                            $lg_stag_qry = "select * from gp_login_table lg where lg.id = '$stg_new_id'";
                            $lg_stag_qry = $this->db->query($lg_stag_qry);
                            if($lg_stag_qry && $lg_stag_qry->num_rows()>0)
                            {
                                $lg_stg_result = $lg_stag_qry->row_array();
                                $log_stag_id = $lg_stg_result['id'];
                                $lg_stg_user_id = $lg_stg_result['user_id'];

                                $this->db->set('total_value', 'total_value + ' . (float) $parent_stg_reward_rs, FALSE);
                                $this->db->where('user_id', $stg_new_id);
                                $this->db->where('wallet_type_id', 2);
                                $this->db->update('gp_wallet_values');
                                echo $this->db->last_query();
                                $wal_stg_activitysss = array(
                                    'wallet_type_id' => 2,
                                    'user_id' => $stg_new_id,
                                    'change_value' => $parent_stg_reward_rs,
                                    'date_modified' => date('Y-m-d h:i:s'),
                                    'description' => 'Reward when chiled purchased (BA club registration)'
                                );
                                $this->db->insert('gp_wallet_activity', $wal_stg_activitysss);


                            }else{
                                // update admin wallet
                                $this->db->set('total_value', 'total_value + ' . (float) $parent_stg_reward_rs, FALSE);
                                $this->db->where('user_id', 13);
                                $this->db->where('wallet_type_id', 4);
                                $this->db->update('gp_wallet_values');
                                echo $this->db->last_query();
                                $wal_stg_activityss = array(
                                    'wallet_type_id' => 4,
                                    'user_id' => 13,
                                    'change_value' => $parent_stg_reward_rs,
                                    'date_modified' => date('Y-m-d h:i:s'),
                                    'description' => 'Reward when Parent is zero Stage Pooling (BA club registration)'
                                );
                                $this->db->insert('gp_wallet_activity', $wal_stg_activityss);

                            }
                        }
                    } else{
                        // update admin wallet
                        $this->db->set('total_value', 'total_value + ' . (float) $parent_stg_reward_rs, FALSE);
                        $this->db->where('user_id', 13);
                        $this->db->where('wallet_type_id', 4);
                        $this->db->update('gp_wallet_values');
                        echo $this->db->last_query();
                        $waal_stg_activitys = array(
                            'wallet_type_id' => 4,
                            'user_id' => 13,
                            'change_value' => $parent_stg_reward_rs,
                            'date_modified' => date('Y-m-d h:i:s'),
                            'description' => 'Reward when Parent is zero Stage Pooling (BA club registration)'
                        );
                        $this->db->insert('gp_wallet_activity', $waal_stg_activitys);
                    }
                }

            }else {
                $stag_poop_effec = array();
            }

        }
        // end Stage pooling
        $this->db->trans_complete();
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
    function get_ba_group_pooling_settings()
    {
        $qry = "select grp.id, grp.title, grp.percentage, grp.no_of_levels from gp_pl_pool_ba_group_settings grp";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        } else{
            return array();
        }
    }
    function get_ba_pooling_stage_settings()
    {
        $qry_stg_pool_set = "select stg.id, stg.title, stg.percentage, stg.no_of_levels from gp_pl_pool_ba_stage_settings stg";
        $qry_stg_pool_set = $this->db->query($qry_stg_pool_set);
        if($qry_stg_pool_set->num_rows()>0)
        {
            return $qry_stg_pool_set->result_array();
        }else{
            return array();
        }
    }

    //add club member type
    function  add_club_type()
    {
        $this->db->trans_begin();
        $datestring = date('Y-m-d H:i:s')
        ;
        $club_agent_fecility=$this->input->post('club_agent_fecility');
        $club_agent_fecility=isset($club_agent_fecility)?1:0;

        $channel_partner_fecility=$this->input->post('channel_partner_fecility');
        $channel_partner_fecility=isset($channel_partner_fecility)?1:0;

        $ref_channel_partner_fecility=$this->input->post('ref_channel_partner_fecility');
        $ref_channel_partner_fecility=isset($ref_channel_partner_fecility)?1:0;

        $user_fecility=$this->input->post('user_fecility');
        $user_fecility=isset($user_fecility)?1:0;

        $ba_fecility=$this->input->post('ba_fecility');
        $ba_fecility=isset($ba_fecility)?1:0;

        $bde_fecility=$this->input->post('bde_fecility');
        $bde_fecility=isset($bde_fecility)?1:0;

        $type = $this->input->post('type');
                //'pooling_commision'=>$this->input->post('club_pooling'),
        if($type=='FIXED'){
            $data=array(
                'title'=>$this->input->post('clubname'),
                'description'=>$this->input->post('description'),
                'amount'=>$this->input->post('amount'),
                'cash_limit'=>$this->input->post('ussage_limit'),
                'bde_benefit'=>$this->input->post('bde_benfit'),
                'ref_bde_benefit'=>$this->input->post('ref_cp_bde_benefit'),
                // 'tl_benefit'=>$this->input->post('tl_benfit'),
                'type'=>$type,
                'cp_status'=>$channel_partner_fecility,
                'cp_limit'=>$this->input->post('cp_limit'),
                'reward_per_cp'=>$this->input->post('reward_per_cp'),
                'ref_cp_status'=>$ref_channel_partner_fecility,
                'ref_cp_limit'=>$this->input->post('ref_cp_limit'),
                'ref_reward_per_cp'=>$this->input->post('ref_reward_per_cp'),
               
                'created_on'=>$datestring,
                'created_by'=>'super_admin'
            );
        }else if($type=='INVESTOR'){
            $data=array(
                'title'=>$this->input->post('clubname'),
                'description'=>$this->input->post('description'),
                'amount'=>$this->input->post('amount'),
                'cash_limit'=>$this->input->post('ussage_limit'),
                // 'bde_benefit'=>$this->input->post('bde_benfit'),
                // 'tl_benefit'=>$this->input->post('tl_benfit'),
                'type'=>$type,
                'club_agent_status'=>$club_agent_fecility,
                'ca_limit'=>$this->input->post('ca_limit'),
                'cp_status'=>$channel_partner_fecility,
                'cp_limit'=>$this->input->post('cp_limit'),
                'user_status'=>$user_fecility,
                'user_limit'=>$this->input->post('user_limit'),
                'bde_status'=>$bde_fecility,
                'bde_limit'=>$this->input->post('bde_limit'),
                'ba_status'=>$ba_fecility,
                'ba_limit'=>$this->input->post('ba_limit'),
                'created_on'=>$datestring,
                'created_by'=>'super_admin'
            );
        }else{
            $data=array(
                'title'=>$this->input->post('clubname'),
                'description'=>$this->input->post('description'),
                'amount'=>$this->input->post('amount'),
                'cash_limit'=>$this->input->post('ussage_limit'),                
                'bde_benefit'=>$this->input->post('bde_benfit'),
                'tl_benefit'=>$this->input->post('tl_benfit'),
                'type'=>$type,
                'club_agent_status'=>$club_agent_fecility,
                'ca_limit'=>$this->input->post('ca_limit'),
                'cp_status'=>$channel_partner_fecility,
                'cp_limit'=>$this->input->post('cp_limit'),
                'user_status'=>$user_fecility,
                'user_limit'=>$this->input->post('user_limit'),
                'ba_status'=>$ba_fecility,
                'ba_limit'=>$this->input->post('ba_limit'),
                'created_on'=>$datestring,
                'created_by'=>'super_admin'
            );
        }
        //var_dump($data);exit;
        $result= $this->db->insert('club_member_type',$data);
        /*$this->db->last_query();
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }*/
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
    //update club member type
    function  update_club_type()
    {
        $datestring = date('%Y-%m-%d %H:%i:%s');
        $id=$this->input->post('id');
        $club_agent_fecility=$this->input->post('club_agent_fecility');
        $club_agent_fecility=isset($club_agent_fecility)?1:0;
        
        $channel_partner_fecility=$this->input->post('channel_partner_fecility');
        $channel_partner_fecility=isset($channel_partner_fecility)?1:0;
        
        $ref_channel_partner_fecility=$this->input->post('ref_channel_partner_fecility');
        $ref_channel_partner_fecility=isset($ref_channel_partner_fecility)?1:0;
        
        $user_fecility=$this->input->post('user_fecility');
        $user_fecility=isset($user_fecility)?1:0;

        $ba_fecility=$this->input->post('ba_fecility');
        $ba_fecility=isset($ba_fecility)?1:0;
        
        $bde_fecility=$this->input->post('bde_fecility');
        $bde_fecility=isset($bde_fecility)?1:0;

        $type=$this->input->post('type');
        if($type=='FIXED'){
            $data=array(
                'title'=>$this->input->post('clubname'),
                'description'=>$this->input->post('description'),
                'amount'=>$this->input->post('amount'),
                'cash_limit'=>$this->input->post('ussage_limit'),
                'bde_benefit'=>$this->input->post('bde_benfit'),
                'ref_bde_benefit'=>$this->input->post('ref_cp_bde_benefit'),
                // 'tl_benefit'=>$this->input->post('tl_benfit'),
                'type'=>$type,
                'cp_status'=>$channel_partner_fecility,
                'cp_limit'=>$this->input->post('cp_limit'),
                'reward_per_cp'=>$this->input->post('reward_per_cp'),
                'ref_cp_status'=>$ref_channel_partner_fecility,
                'ref_cp_limit'=>$this->input->post('ref_cp_limit'),
                'ref_reward_per_cp'=>$this->input->post('ref_reward_per_cp'),
               
            );
        }else if($type=='INVESTOR'){
            $data=array(
                'title'=>$this->input->post('clubname'),
                'description'=>$this->input->post('description'),
                'amount'=>$this->input->post('amount'),
                'cash_limit'=>$this->input->post('ussage_limit'),
                // 'bde_benefit'=>$this->input->post('bde_benfit'),
                // 'tl_benefit'=>$this->input->post('tl_benfit'),
                'type'=>$type,
                'club_agent_status'=>$club_agent_fecility,
                'ca_limit'=>$this->input->post('ca_limit'),
                'cp_status'=>$channel_partner_fecility,
                'cp_limit'=>$this->input->post('cp_limit'),
                'user_status'=>$user_fecility,
                'user_limit'=>$this->input->post('user_limit'),
                'ba_status'=>$ba_fecility,
                'ba_limit'=>$this->input->post('ba_limit'),
                'bde_status'=>$bde_fecility,
                'bde_limit'=>$this->input->post('bde_limit')

            );
        }else{
            $data=array(
                'title'=>$this->input->post('clubname'),
                'description'=>$this->input->post('description'),
                'amount'=>$this->input->post('amount'),
                'cash_limit'=>$this->input->post('ussage_limit'),
                'bde_benefit'=>$this->input->post('bde_benfit'),
                'tl_benefit'=>$this->input->post('tl_benfit'),
                'type'=>$type,
                'club_agent_status'=>$club_agent_fecility,
                'ca_limit'=>$this->input->post('ca_limit'),
                'cp_status'=>$channel_partner_fecility,
                'cp_limit'=>$this->input->post('cp_limit'),
                'user_status'=>$user_fecility,
                'user_limit'=>$this->input->post('user_limit'),
                'ba_status'=>$ba_fecility,
                'ba_limit'=>$this->input->post('ba_limit')
            );
        }

        $this->db->where('id',$id);
        $result= $this->db->update('club_member_type',$data);
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    function get_all_club_members_count($search,$type)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (gp_normal_customer.name LIKE '%$keyword%' OR gp_normal_customer.phone LIKE '%$keyword%' OR gp_normal_customer.email LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        if(!empty($type)){
            if($type =='unlimited'){
                $where2 = " and (gp_normal_customer.club_type_id >0)";
            }else if($type =='fixed'){
                $where2 = " and (gp_normal_customer.fixed_club_type_id >0)";
            }else if($type =='investor'){
                $where2 = " and (gp_normal_customer.investor_type_id >0)";
            }
            
        }else{
            $where2 = '';
        }
        $qry="SELECT gp_normal_customer.id as user_id,gp_normal_customer.*,type1.type un,type2.type fix 
        FROM `gp_normal_customer` 
        left join club_member_type type1 on type1.id=gp_normal_customer.club_type_id
        left join club_member_type type2 on type2.id=gp_normal_customer.fixed_club_type_id
        WHERE gp_normal_customer.type='club_member' and 
        gp_normal_customer.is_Del!='1' and 
        gp_normal_customer.investor_type_id='0' ".$where.$where2." and gp_normal_customer.status='approved' ORDER BY gp_normal_customer.id DESC";
        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else {
            return false;
        }
    }
    // get all club members
    function get_all_club_members($search,$type,$limit, $start)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (gp_normal_customer.name LIKE '%$keyword%' OR gp_normal_customer.phone LIKE '%$keyword%' OR gp_normal_customer.email LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        if(!empty($type)){
            if($type =='unlimited'){
                $where2 = " and (gp_normal_customer.club_type_id >0)";
            }else if($type =='fixed'){
                $where2 = " and (gp_normal_customer.fixed_club_type_id >0)";
            }else if($type =='investor'){
                $where2 = " and (gp_normal_customer.investor_type_id >0)";
            }
            
        }else{
            $where2 = '';
        }
        $qry="SELECT gp_normal_customer.id as user_id,gp_normal_customer.*,
        IFNULL(type1.type,'')AS un,IFNULL(type2.type,'')AS fix 
        FROM `gp_normal_customer` 
        left join club_member_type type1 on type1.id=gp_normal_customer.club_type_id
        left join club_member_type type2 on type2.id=gp_normal_customer.fixed_club_type_id WHERE gp_normal_customer.type='club_member' and gp_normal_customer.is_Del!='1' and gp_normal_customer.investor_type_id='0' ".$where.$where2." and gp_normal_customer.status='approved' ORDER BY gp_normal_customer.id DESC LIMIT $start, $limit";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->result_array();

        }
        else
        {
            return array();
        }
    }
    function get_all_club_types_count($search)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (club_member_type.title LIKE '%$keyword%' OR club_member_type.amount LIKE '%$keyword%' OR
                club_member_type.description LIKE '%$keyword%' OR
                club_member_type.amount LIKE '%$keyword%' OR
                club_member_type.cash_limit LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="SELECT * FROM `club_member_type` WHERE is_del ='0' ".$where." ORDER BY club_member_type.id DESC";
        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else {
            return false;
        }
    }
    function get_all_clubtypes($search,$limit, $start)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (club_member_type.title LIKE '%$keyword%' OR club_member_type.amount LIKE '%$keyword%' OR
                club_member_type.description LIKE '%$keyword%' OR
                club_member_type.amount LIKE '%$keyword%' OR
                club_member_type.cash_limit LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="SELECT * FROM `club_member_type` WHERE is_del ='0'".$where." ORDER BY club_member_type.id DESC LIMIT $start, $limit";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->result_array();
        } else{
            return array();
        }
    }
    function get_all_club_types()
    {
        $qry="SELECT * FROM `club_member_type` WHERE is_del ='0' ORDER BY id DESC";
        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            return $result->result_array();
        }else {
            return array();
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
    function delete_club_type($datas)
    {
        $this->db->trans_begin();
        $ca_ids = $datas['chck_item_id'];
        foreach ($ca_ids as $key => $ca_id) {
            $info = array('is_del' => 1);
            $this->db->where('id', $ca_id);
            $qry = $this->db->update('club_member_type', $info);
        }
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
    function validate_email($email)
    {
        $data = array();
        //$email = $this->input->post('email');
        
        // $qry = "select * from gp_login_table where email = '$email' and (type = 'club_member' or type = 'normal_customer')";
        $qry = "select * from gp_login_table where email = '$email' and (type = 'club_member' or type = 'normal_customer' or type = 'club_agent')";
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
        
        //$phone = $this->input->post('phone');
        
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
    function validate_normal_customer($email,$phone)
    {
        $data = array();
        $qry = "select * from gp_login_table where (email = '$email' or mobile = '$phone')and (type = 'normal_customer')";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data['status'] =  TRUE;
            $data['result'] =  $qry->row_array();
        } else{
            $data['status'] = FALSE;
            $data['reason'] = "Not a Normal Customer";
        }
        
        return $data;
    }
    function validate_club_member($email,$phone)
    {
        $data = array();
        $qry = "select * from gp_login_table where (email = '$email' or mobile = '$phone')and (type = 'club_member')";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            
            $data['reason'] = "Already A Clubmember Exists with same Email id And Mobile No";
            $data['status'] = FALSE;
        } else{
            $data['status'] =  TRUE;
        }
        return $data;
    }
    function club_registration($res)
    {
        $data = array();
        $this->db->trans_begin();
        $id = $res['id'];
        $user_id = $res['user_id'];
        $details = get_details_by_loginid($id);

        $datas2 = array(
        'customer_log_id' => $id,
        'parent_log_id' => $details['parent_login_id'],
        'current_parent_log_id' => 1
        );
        $qry = $this->db->insert('gp_be_clubmember', $datas2);

        $mode_payment = $this->input->post('payment_mode');
        $club_plan = $this->input->post('club_plan');
        $type2 =$this->input->post('club_plan2');
        $club = (empty($club_plan))?$type2 : $club_plan;
        $det1 = getClubtypeById($club);

        
        $det2 = isset($type2)?getClubtypeById($type2):'';
        $datas = array(
            'profile_image' =>'',
            'type'=>'club_member',
            'mode_payment'=>$mode_payment,
            'parent_id' => 1,
            'created_by'=>1,
            'register_via'=>'admin'
            );
       
        $datas['club_type_id'] = $club_plan;
        $datas['fixed_club_type_id']=$type2;
        if($mode_payment=='cheque'){
            $datas['cheque_no']=$this->input->post('cheque');
            $datas['bank']=$this->input->post('bank');
            $datas['cheque_date']=convert_to_mysql($this->input->post('cheque_date'));
        }

        $det = get_details_by_userid($user_id);
        //$det1 = getClubtypeById($club_plan);
        $cnt = 0 ;
        $amount = $det1['amount'];
         /************Entry Start***********/
        $fy_year = get_current_financial_year();
        $fy_id = $fy_year['id'];
       
        $no =get_number();
        $data = array(
            'entrytype_id'=>2,
            '_type'=>'CLUB_MEMBERSHIP',
            'type_id'=>$id,
            'number'=>$no,
            'fy_id' =>$fy_id,
            'date'=>date('Y-m-d'),
            'dr_total'=>$amount,
            'cr_total'=>$amount
        );
        $this->db->insert('erp_ac_entries',$data);
        $entry_id = $this->db->insert_id();
        $ledger_payment_cr = getLedgerId($id,"CUSTOMER");
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

        if($mode_payment=='cash'){
            $ledger_payment_dr = 32;
        }
        else if($mode_payment=='cheque'){
            $ledger_payment_dr = 35;
        }else{
            $ledger_payment_dr = 35;
        }

        //$dr_amount1 = $amount-($bde_benefit+$tl_benefit);//$det1['amount']-($bde_benefit+$tl_benefit);
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
        if($club_plan>0){
            $bde_benefit = $det1['bde_benefit'];
            $tl_benefit = $det1['tl_benefit'];
            //-($bde_benefit+$tl_benefit);
           
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
        if($type2){
            $datas['fixed_join_date']=date('Y-m-d h:i:s');
        }
        $this->db->where('id', $user_id);
        $qry = $this->db->update('gp_normal_customer', $datas);

        $userLogin = array( 'type' => 'club_member','parent_login_id'=>1); 
        $this->db->where('id', $id);
        $qry_login = $this->db->update('gp_login_table', $userLogin);
        if(!empty($club_plan)){
            $wallete = array('wallet_type_id' => 1, 'user_id' => $id, 'total_value' => $det1['amount'] );  
            $qry3 = $this->db->insert('gp_wallet_values', $wallete);
            $wal_id = $this->db->insert_id();


            $wal_activityss = array(
                'wallet_type_id' => 1,
                'wallet_val_id' => $wal_id,
                'user_id' => $id,
                'type'=>'GAIN',
                'date_modified' => date('Y-m-d h:i:s'),
                'change_value' => $amount,
                'description' => 'Club wallet added'
                );
            $this->db->insert('gp_wallet_activity', $wal_activityss);
        }
        if($type2>0){
            $wallete = array('wallet_type_id' => 5, 'user_id' => $id, 'total_value' =>0 );  
            $qry3 = $this->db->insert('gp_wallet_values', $wallete);
            $wal_id = $this->db->insert_id();


            $wal_activityss = array(
                'wallet_type_id' =>5,
                'wallet_val_id' => $wal_id,
                'user_id' => $id,
                'type'=>'GAIN',
                'date_modified' => date('Y-m-d h:i:s'),
               
                'description' => 'Fixed Club wallet added'
                );
            $this->db->insert('gp_wallet_activity', $wal_activityss);
        }
        /*$qrys = "select ty.id, ty.title, ty.amount, ty.bde_benefit,ty.tl_benefit,ty.cash_limit 
        from club_member_type ty where ty.is_del = 0 and ty.id = '$club_plan'";
        $qrys = $this->db->query($qrys);
        $type_details = $qrys->row_array();
        $bde_benefit = $type_details['bde_benefit'];
        $tl_benefit = $type_details['tl_benefit'];*/


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
    function get_memberdetails_byid($id)
    {
        $qry="SELECT gp_normal_customer.*,DATE_FORMAT(gp_normal_customer.cheque_date,'%d-%m-%Y')as chequ_date,(SELECT club_member_type.type FROM club_member_type WHERE gp_normal_customer.club_type_id=club_member_type.id ) as ctype,(SELECT club_member_type.title FROM club_member_type WHERE gp_normal_customer.club_type_id=club_member_type.id )as type ,gp_login_table.id as log_id FROM `gp_normal_customer` 
        LEFT JOIN gp_login_table ON gp_normal_customer.id=gp_login_table.user_id
        WHERE gp_normal_customer.id='$id' AND gp_login_table.type='club_member' 
        GROUP BY gp_normal_customer.id";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->row_array();

        }
        else
        {
            return array();
        }
    }
    function update_club_member($data,$id)
    {
        $this->db->trans_begin();
        $this->db->select('club_type_id')
                    ->from('gp_normal_customer')
                    ->where('id',$id);
        $utype = $this->db->get()->row()->club_type_id;
        $utype =isset($utype)?$utype:0;
        $udet = getClubtypeById($utype);

        $this->db->select('fixed_club_type_id')
                    ->from('gp_normal_customer')
                    ->where('id',$id);
        $ftype = $this->db->get()->row()->fixed_club_type_id;
        $ftype = isset($ftype)?$ftype:0;
        $fdet = getClubtypeById($ftype);


        $club_plan=isset($data['club_type_id'])?$data['club_type_id']:0;
        $fixed_plan = isset($data['fixed_club_type_id'])?$data['fixed_club_type_id']:0;
        $log_id = $this->input->post('log_id');
        $old_id = $this->input->post('cplan');
        $cnt = 0;
        //has old unlimited
        if($utype){
            //upgrade unlimited
            if($club_plan>0 && $club_plan!=$utype)
            {
                $udetails = getClubtypeById($club_plan); 
                $u_amount = $udetails['amount'];
                $g_amount = $u_amount - $udet['amount'];
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
                   
                    $no1 =get_number();
                    $ent_data1 = array(
                        'entrytype_id'=>2,
                        '_type'=>'CLUB_MEMBERSHIP',
                        'type_id'=>$log_id,
                        'number'=>$no1,
                        'fy_id' =>$fy_id,
                        'date'=>date('Y-m-d'),
                        'dr_total'=>$g_amount,
                        'cr_total'=>$g_amount,
                    );
                    $this->db->insert('erp_ac_entries',$ent_data1);
                    $entry_id1 = $this->db->insert_id();
                    $ledger_payment_cr1 = getLedgerId($log_id,"CUSTOMER");
                   // $ledger_payment_cr = 71;
                    $entry_items_cr1 = array(
                        'entry_id' => $entry_id1,
                        'ledger_id' => $ledger_payment_cr1,
                        'amount' => $g_amount,
                        'dc' => 'Cr',
                        'fy_id' =>$fy_id,
                        'created_date' => date('Y-m-d')
                    );
                    $entry_cr1 = $this->db->insert('erp_ac_entryitems', $entry_items_cr1);
                    $mode_payment = $this->input->post('payment_mode');
                    if($mode_payment=='cash'){
                        $ledger_payment_dr1 = 32;
                    }
                    else if($mode_payment=='cheque'){
                        $ledger_payment_dr1 = 35;
                    }
                    else{
                        $ledger_payment_dr1 = 35;
                    }

                    $entry_items_dr1 = array(
                        'entry_id' => $entry_id1,
                        'ledger_id' => $ledger_payment_dr1,
                        'amount' => $g_amount,
                        'dc' => 'Dr',
                        'fy_id' =>$fy_id,
                        'created_date' => date('Y-m-d')
                    );
                    $entry_dr1 = $this->db->insert('erp_ac_entryitems', $entry_items_dr1);
                $cnt++;       
            }else{
            //if new fixed and no old fixed
                if($fixed_plan>0 && $ftype==0)
                {
                    $fdetails = getClubtypeById($fixed_plan); 
                    $f_amount = $fdetails['amount'];

                    $wallete = array('wallet_type_id' => 5, 'user_id' => $log_id, 'total_value' =>0 );  
                    $qry3 = $this->db->insert('gp_wallet_values', $wallete);
                    $wal_id = $this->db->insert_id();
                    $wal_activityss = array(
                        'wallet_type_id' =>5,
                        'wallet_val_id' => $wal_id,
                        'user_id' => $id,
                        'type'=>'GAIN',
                        'date_modified' => date('Y-m-d h:i:s'),
                        'description' => 'Fixed Club wallet added'
                        );
                    $this->db->insert('gp_wallet_activity', $wal_activityss);
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
                            'dr_total'=>$f_amount,
                            'cr_total'=>$f_amount,
                        );
                        $this->db->insert('erp_ac_entries',$ent_data);
                        $entry_id = $this->db->insert_id();
                        $ledger_payment_cr = getLedgerId($log_id,"CUSTOMER");
                       // $ledger_payment_cr = 71;
                        $entry_items_cr = array(
                            'entry_id' => $entry_id,
                            'ledger_id' => $ledger_payment_cr,
                            'amount' => $f_amount,
                            'dc' => 'Cr',
                            'fy_id' =>$fy_id,
                            'created_date' => date('Y-m-d')
                        );
                        $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);
                        $mode_payment = $this->input->post('payment_mode');
                        if($mode_payment=='cash'){
                            $ledger_payment_dr = 32;
                        }
                        else if($mode_payment=='cheque'){
                            $ledger_payment_dr = 35;
                        }
                        else{
                            $ledger_payment_dr = 35;
                        }

                        $entry_items_dr1 = array(
                            'entry_id' => $entry_id,
                            'ledger_id' => $ledger_payment_dr,
                            'amount' => $f_amount,
                            'dc' => 'Dr',
                            'fy_id' =>$fy_id,
                            'created_date' => date('Y-m-d')
                        );
                        $entry_dr1 = $this->db->insert('erp_ac_entryitems', $entry_items_dr1); 
                    $cnt++;       
                }
            }
        }
        //has old fixed
        if($ftype){
            //upgrade fixed
            if($fixed_plan>0 && $fixed_plan!=$ftype)
            {
                $xdetails = getClubtypeById($fixed_plan); 
                $x_amount = $xdetails['amount'];
                $y_amount = $x_amount - $fdet['amount'];
                /*$this->db->set('total_value', 'total_value + ' . (float) $y_amount, FALSE);
                $this->db->where('user_id', $log_id);
                $this->db->where('wallet_type_id', 5);
                $this->db->update('gp_wallet_values');
                $wal_activity = array(
                'wallet_type_id' => 5,
                'user_id' => $log_id,
                'change_value' => $y_amount,
                'date_modified' => date('Y-m-d h:i:s'),
                'description' => 'Upgrade Fixed Club Membership'
                );
                $this->db->insert('gp_wallet_activity', $wal_activity);*/
                //Entry
                $fy_year = get_current_financial_year();
                $fy_id = $fy_year['id'];
               
                $no2 =get_number();
                $ent_data2 = array(
                    'entrytype_id'=>2,
                    '_type'=>'CLUB_MEMBERSHIP',
                    'type_id'=>$log_id,
                    'number'=>$no2,
                    'fy_id' =>$fy_id,
                    'date'=>date('Y-m-d'),
                    'dr_total'=>$y_amount,
                    'cr_total'=>$y_amount,
                );
                $this->db->insert('erp_ac_entries',$ent_data2);
                $entry_id2 = $this->db->insert_id();
                $ledger_payment_cr2 = getLedgerId($log_id,"CUSTOMER");
               // $ledger_payment_cr = 71;
                $entry_items_cr2 = array(
                    'entry_id' => $entry_id2,
                    'ledger_id' => $ledger_payment_cr2,
                    'amount' => $y_amount,
                    'dc' => 'Cr',
                    'fy_id' =>$fy_id,
                    'created_date' => date('Y-m-d')
                );
                $entry_cr2 = $this->db->insert('erp_ac_entryitems', $entry_items_cr2);
                $mode_payment = $this->input->post('payment_mode');
                if($mode_payment=='cash'){
                    $ledger_payment_dr2 = 32;
                }
                else if($mode_payment=='cheque'){
                    $ledger_payment_dr2 = 35;
                }
                else{
                    $ledger_payment_dr2 = 35;
                }

                $entry_items_dr2 = array(
                    'entry_id' => $entry_id2,
                    'ledger_id' => $ledger_payment_dr2,
                    'amount' => $y_amount,
                    'dc' => 'Dr',
                    'fy_id' =>$fy_id,
                    'created_date' => date('Y-m-d')
                );
                $entry_dr2 = $this->db->insert('erp_ac_entryitems', $entry_items_dr2); 
                $cnt++;
            }else{
                //if new unlimited and no old unlimited
                if($club_plan>0 && $utype==0)
                {
                    $pdetails = getClubtypeById($club_plan); 
                    $p_amount = $pdetails['amount'];

                    $wallete1 = array('wallet_type_id' => 1, 'user_id' => $log_id, 'total_value' =>$p_amount );  
                    $qry4 = $this->db->insert('gp_wallet_values', $wallete1);
                    $wal_id1 = $this->db->insert_id();
                    $wal_activityss1 = array(
                        'wallet_type_id' =>1,
                        'wallet_val_id' => $wal_id1,
                        'user_id' => $id,
                        'change_value' => $p_amount,
                        'type'=>'GAIN',
                        'date_modified' => date('Y-m-d h:i:s'),
                        'description' => 'Unlimited Club wallet added'
                        );
                    $this->db->insert('gp_wallet_activity', $wal_activityss1);
                    //Entry
                        $fy_year = get_current_financial_year();
                        $fy_id = $fy_year['id'];
                       
                        $no3 =get_number();
                        $ent_data3 = array(
                            'entrytype_id'=>2,
                            '_type'=>'CLUB_MEMBERSHIP',
                            'type_id'=>$log_id,
                            'number'=>$no3,
                            'fy_id' =>$fy_id,
                            'date'=>date('Y-m-d'),
                            'dr_total'=>$p_amount,
                            'cr_total'=>$p_amount,
                        );
                        $this->db->insert('erp_ac_entries',$ent_data3);
                        $entry_id3 = $this->db->insert_id();
                        $ledger_payment_cr3 = getLedgerId($log_id,"CUSTOMER");
                       // $ledger_payment_cr = 71;
                        $entry_items_cr3 = array(
                            'entry_id' => $entry_id3,
                            'ledger_id' => $ledger_payment_cr3,
                            'amount' => $p_amount,
                            'dc' => 'Cr',
                            'fy_id' =>$fy_id,
                            'created_date' => date('Y-m-d')
                        );
                        $entry_cr3 = $this->db->insert('erp_ac_entryitems', $entry_items_cr3);
                        $mode_payment = $this->input->post('payment_mode');
                        if($mode_payment=='cash'){
                            $ledger_payment_dr3 = 32;
                        }
                        else if($mode_payment=='cheque'){
                            $ledger_payment_dr3 = 35;
                        }
                        else{
                            $ledger_payment_dr3 = 35;
                        }

                        $entry_items_dr3 = array(
                            'entry_id' => $entry_id3,
                            'ledger_id' => $ledger_payment_dr3,
                            'amount' => $p_amount,
                            'dc' => 'Dr',
                            'fy_id' =>$fy_id,
                            'created_date' => date('Y-m-d')
                        );
                        $entry_dr3 = $this->db->insert('erp_ac_entryitems', $entry_items_dr3); 
                    $cnt++;
                }
            }
        }
            

        $data['updated_on']=date('Y-m-d h:i:s');
        $this->db->where('id', $id);
        $qry = $this->db->update('gp_normal_customer', $data);

        $date = date("Y-m-d h:i:sa") ;
        $action = "Upgrade Club Membership";
        $status = 0;
        activity_log($action,$log_id,$status,$date);

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            if($cnt>0){
                $udetail = get_details_by_userid($id);
                $mobile = $udetail['phone'];
                $this->send_message($mobile);
            }
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
    function send_message($mobile){
        $message = "Congratulations, You have suceessfully upgraded your Club membership.Please continue with login:".base_url()."user_login";
        send_message($mobile,$message);
    }
    //delete club members
    function delete_club_member($datas)
    {
        $this->db->trans_begin();
        $ca_ids = $datas['chck_item_id'];
        foreach ($ca_ids as $key => $ca_id) {
            $info = array('is_del' => 1);
            $this->db->where('id', $ca_id);
            $qry = $this->db->update('gp_normal_customer', $info);
            $infos = array('is_del' => 1);
            $this->db->where('user_id', $ca_id);
            $qrs = $this->db->update('gp_login_table', $infos);
        }
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
    //get unapproved cm's count
    function get_all_notapproved_clubmembers_count($search)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (gp_normal_customer.name LIKE '%$keyword%' OR gp_normal_customer.phone LIKE '%$keyword%' OR gp_normal_customer.email LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="SELECT gp_normal_customer.id as user_id,gp_normal_customer.* FROM `gp_normal_customer` 
        WHERE gp_normal_customer.status='notapproved' and gp_normal_customer.type='club_member' and gp_normal_customer.is_Del!='1'".$where." ORDER BY gp_normal_customer.id DESC";
        $result=$this->db->query($qry);
       // echo $this->db->last_query();exit;
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else {
            return false;
        }
    }
    // get unapproved club members
    function get_all_notapproved_clubmembers($search,$limit, $start)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (gp_normal_customer.name LIKE '%$keyword%' OR gp_normal_customer.phone LIKE '%$keyword%' OR gp_normal_customer.email LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="SELECT gp_normal_customer.id as user_id,gp_normal_customer.* FROM `gp_normal_customer`  WHERE gp_normal_customer.type='club_member' AND gp_normal_customer.status='notapproved' and gp_normal_customer.is_Del!='1'".$where." ORDER BY gp_normal_customer.id DESC LIMIT $start, $limit";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->result_array();
        } else{
            return array();
        }
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
            'clubmember_ship'=>1,
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
    function get_is_team($desig)
    {
       
        $qry2 = "select type.sort_order,type.add_exec from gp_pl_sales_designation_type type where  id ='$desig'";
            $qry2 = $this->db->query($qry2);
            if($qry2->num_rows()>0)
            {
               
                $data = $qry2->row();
            } else{
                $data=  FALSE;
            }
            
        
        return $data;
    }
    function upgrade_designation($userid,$lgid)
    {
       
        $qry1 = $this->db->query("SELECT m.last_promotion_date,s.id,s.promotion_designation,m.created_by FROM gp_pl_sales_team_members m left join gp_executive_promotion_settings s on m.sales_desig_type_id = s.designation_id where m.id = '$userid'");
              // echo $this->db->last_query();exit();
            if($qry1->num_rows()>0)
            {
              $res1 =  $qry1->row();
              $last_promo_date = $res1->last_promotion_date;
              $promo_id = $res1->id;
              $next_designation = $res1->promotion_designation;
              $created_by=$res1->created_by;


              $qry2 = $this->db->query("select * from gp_executive_promotion_details s where s.promo_id = '$promo_id' order by s.period ASC");
              if($qry2->num_rows()>0){
                 $res2 =  $qry2->result_array();
                    foreach ($res2 as $key => $value) {
                        $cur_date = date('Y-m-d');
                        $period = $value['period'];
                         $amount = $value['amount'];
                         $count = $value['count'];
                        $qry_month = $this->db->query("SELECT DATE_SUB(curdate(), INTERVAL +$period MONTH) as month");
                          if($qry_month->num_rows()>0){
                                $res3 = $qry_month->row();
                                $init_month = $res3->month;
                                $count1 = 0;
                                $amount1 = 0;
                                $x = strtotime($cur_date);
                                $each_month = date("Y-m-d",strtotime("-1 month",$x));
                                //var_dump($cur_date);var_dump($each_month);exit;
                                for($i=1; $i<=$period; $i++){
                                     
                                      $qry_count = $this->db->query("SELECT count(id) as club_count FROM gp_normal_customer nc WHERE nc.parent_id = '$lgid' and nc.club_type_id!='0' and nc.register_via = 'executive' and nc.is_del = '0' and nc.status = 'approved' and (nc.created_on BETWEEN '$each_month' and '$cur_date')");
                                        //var_dump($cur_date);var_dump($each_month);
                                        //echo $this->db->last_query();
                                         if($qry_count->num_rows()>0){
                                            $res4 = $qry_count->row();
                                            $c_count = $res4->club_count;
                                           
                                            $int_count = (int)$c_count;
                                      
                                            
                                            if($int_count == $count){
                                             $count1++;   
                                            }
                                            else{
                                                
                                                break;
                                            }
                                            $cur_date = $each_month;
                                            $x = strtotime($cur_date);
                                            $each_month = date("Y-m-d",strtotime("-1 month",$x));
                                         
                                           
                                         }else{
                                            
                                            $res4 = false;
                                 
                                            
                                         }
                                    
                                }
                                $int_period = (int)$period;
                                 $cur_date1 = date('Y-m-d');
                                //var_dump($count1);var_dump($int_period);exit();
                                if($count1>=$int_period){
                                    $up_data = array(
                                        'sales_desig_type_id'=> $next_designation ,
                                        'last_promotion_date' =>$cur_date1
                                        );
                                 $this->db->where('id', $userid);
                                 $qry = $this->db->update('gp_pl_sales_team_members', $up_data);
                                        $datas_ins= array(
                                            'user_id'=>$lgid,
                                            'designation'=> $next_designation ,
                                            'date' =>$cur_date1
                                        );
                                        $qry1 = $this->db->insert('promotion_notification', $datas_ins);
                                         $qry_created = $this->db->query("SELECT * from gp_login_table where type='executive' and id='$created_by'");
                                      
                                         if($qry_created->num_rows()>0){
                                             $res_cr =  $qry_created->row();
                                             $cr_lgid = $res_cr->id;
                                             $cr_user_id = $res_cr->user_id;
                                             $upgrade_team_next=upgrade_designation_team($cr_user_id,$cr_lgid);

                                         }
                                         else{
                                            $res_cr = false;
                                         }
                                        //echo $this->db->last_query();exit();
                                }
                                else{
                                        for($i=1; $i<=$period; $i++){
                                         
                                            $qry_amount =$this->db->query("SELECT nc.club_type_id,sum(IFNULL(c_type.amount,0)+IFNULL(c_type2.amount,0)) as amount1 FROM gp_normal_customer nc
                                                left join club_member_type c_type on c_type.id=nc.fixed_club_type_id
                                                left join club_member_type c_type2 on c_type2.id=nc.club_type_id
                                                WHERE nc.parent_id = '$lgid' and nc.club_type_id!='0' and nc.register_via = 'executive' and nc.is_del = '0' and nc.status = 'approved' and (nc.joined_on BETWEEN '$each_month' and '$cur_date')");
                                          
                                               // echo $this->db->last_query();
                                             if($qry_amount->num_rows()>0){
                                                $res5 = $qry_amount->row();
                                                $t_amount = $res5->amount1;
                                                //echo $amount;exit();
                                                //$int_count = (int)$c_count;
                                          
                                                
                                                if($t_amount >= $amount){
                                                 $amount1++;   
                                                }
                                                else{
                                                    
                                                    break;
                                                }
                                                $cur_date = $each_month;
                                                $x = strtotime($cur_date);
                                                $each_month = date("Y-m-d",strtotime("-1 month",$x));
                                             
                                               
                                             }else{
                                               
                                                $res5 = false;
                                          
                                                
                                             }
                                        }

                                    //var_dump($amount1);var_dump($int_period);exit();
                                     $cur_date1 = date('Y-m-d');
                                    if($amount1>=$int_period){
                                        $up_data1 = array(
                                            'sales_desig_type_id'=> $next_designation ,
                                            'last_promotion_date' =>$cur_date1
                                            );
                                     $this->db->where('id', $userid);
                                     $qry = $this->db->update('gp_pl_sales_team_members', $up_data1);



                                      $datas_ins= array(
                                            'user_id'=>$lgid,
                                            'designation'=> $next_designation ,
                                            'date' =>$cur_date1
                                        );
                                        $qry1 = $this->db->insert('promotion_notification', $datas_ins);
                                       
                                        $qry_created = $this->db->query("SELECT * from gp_login_table where type='executive' and id='$created_by'");
                                      
                                         if($qry_created->num_rows()>0){
                                             $res_cr =  $qry_created->row();
                                             $cr_lgid = $res_cr->id;
                                             $cr_user_id = $res_cr->user_id;
                                            
                                             
                                             $upgrade_team_next=upgrade_designation_team($cr_user_id,$cr_lgid);

                                         }
                                         else{
                                            $res_cr = false;
                                         }

                                     }
                                   }
                               
                            }else{
                                 $res3 = false;
                            } 
                    }
                }else{
                    $res2 =  false;
                }
            } else{
                $res1 =  false;
            }
            
   //var_dump("expression");exit();
        return true;
    }
    // function approve_club_member($user_id)
    // {
    //     $benfit ='';
    //     $this->db->trans_begin();
    //     $qry1 = "select * from gp_login_table  where user_id='$user_id' AND is_del = 0";
    //     $qry1 = $this->db->query($qry1);
    //     if($qry1->num_rows()>0)
    //     {
    //         $det2= $qry1->row_array();
    //         $id = $det2['id'];
    //     }
    //     $cnt = 0;

    //     $det = get_details_by_userid($user_id);
      
    //     $datestring = date('Y-m-d H:i:s');
    //     $info = array('status' => 'approved','created_on'=>$datestring);
    //     $this->db->where('id', $user_id);
    //     $qry = $this->db->update('gp_normal_customer', $info);

    //     $parent_login = $det['created_by'];
    //      /************Promotion Start***********/
  

    //     $qry1 = "select exec.id,exec.sales_desig_type_id from gp_login_table l
    //              left join gp_pl_sales_team_members exec on exec.id=l.user_id where l.id='$parent_login' AND exec.is_del = 0";
        
    //     $qry1 = $this->db->query($qry1);
    //     if($qry1->num_rows()>0)
    //     {
    //         $details= $qry1->row_array();
    //         $desig = $details['sales_desig_type_id'];
    //         $exec_id = $details['id'];

        
    //    $is_team = $this->get_is_team($desig);
     
    //     if($is_team->add_exec=='0'){
    //       $promotion = $this->upgrade_designation($exec_id,$parent_login); 
         
    //     }
    //     }

    //     /************Promotion Start***********/
    //     $datas2 = array(
    //     'customer_log_id' => $id,
    //     'parent_log_id' => 1,
    //     'current_parent_log_id' => $det['created_by']
    //     );
    //     $qryy = $this->db->insert('gp_be_clubmember', $datas2);

    //     $infos = array('type' => 'club_member','parent_login_id'=>$parent_login);
    //     $this->db->where('user_id', $user_id);
    //     $qrs = $this->db->update(' gp_login_table', $infos);

       
        

    //     if($det['club_type_id']>0){
    //          $club_plan = $det['club_type_id'];
    //          $det1 = getClubtypeById($club_plan);
       
    //          $bde_benefit = $det1['bde_benefit'];
    //          $tl_benefit = $det1['tl_benefit'];
    //         $amount = $det1['amount'];//-($bde_benefit+$tl_benefit);
    //         /************Entry Start***********/
    //         $fy_year = get_current_financial_year();
    //         $fy_id = $fy_year['id'];
           
    //         $no =get_number();
    //         $data = array(
    //             'entrytype_id'=>2,
    //             '_type'=>'CLUB_MEMBERSHIP',
    //             'type_id'=>$id,
    //             'number'=>$no,
    //             'fy_id' =>$fy_id,
    //             'date'=>date('Y-m-d'),
    //             'dr_total'=>$amount,
    //             'cr_total'=>$amount,
    //         );
    //         $this->db->insert('erp_ac_entries',$data);
    //         $entry_id = $this->db->insert_id();

    //         $ledger_payment_cr = 71;
    //         $entry_items_cr = array(
    //             'entry_id' => $entry_id,
    //             'ledger_id' => $ledger_payment_cr,
    //             'amount' => $amount,
    //             'dc' => 'Cr',
    //             'fy_id' =>$fy_id,
    //             'created_date' => date('Y-m-d')
    //         );
    //         $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);
    //         $mode_payment=$det['mode_payment'];
    //         if($mode_payment=='cash'){
    //             $ledger_payment_dr = 32;
    //         }
    //         else if($mode_payment=='cheque'){
    //             $ledger_payment_dr = 35;
    //         }
    //         else{
    //             $ledger_payment_dr = 35;
    //         }

    //         $dr_amount1 = $det1['amount']-($bde_benefit+$tl_benefit);
    //         $entry_items_dr1 = array(
    //             'entry_id' => $entry_id,
    //             'ledger_id' => $ledger_payment_dr,
    //             'amount' => $dr_amount1,
    //             'dc' => 'Dr',
    //             'fy_id' =>$fy_id,
    //             'created_date' => date('Y-m-d')
    //         );
    //         $entry_dr1 = $this->db->insert('erp_ac_entryitems', $entry_items_dr1);

    //         /************Entry End***********/
    //         $parent_id = $det['created_by'];
    //         //echo  $det['created_by'] ;exit();
    //         $parent_details = $this->get_parent_login($parent_id);
    //         //print_r($parent_details);
    //         a:$parent_id = $parent_details['id'];
    //         $p_id = $parent_details['id'];
    //         if($parent_details['type']=='executive'){
    //             $cnt++;
    //             $wal_typ = 3;
    //             $res1 = $this->get_club_benefit($p_id,$bde_benefit,$wal_typ,$entry_id);
    //             $parent_log_id = $parent_details['parent_login_id'];
    //             $parent_details = $this->get_parent_login($parent_log_id);
    //            //print_r($parent_details);exit();
    //             goto a;
    //         }else if($parent_details['type']=='team_leader'){ 
    //             $wal_typ = 3;
    //             $cnt++;
    //             $benefit = ($cnt==1)?$bde_benefit:$tl_benefit;
    //             $res2 = $this->get_club_benefit($p_id,$benefit,$wal_typ,$entry_id);
    //                 $parent_log_id = $parent_details['parent_login_id'];
    //                 $parent_details = $this->get_parent_login($parent_log_id);
    //                 if($cnt<=1){
    //                   goto a;
    //                 } 
    //         }else if($parent_details['type']=='tl'){ 
    //             $wal_typ = 3;
    //             $cnt++;
    //             $benefit = ($cnt==1)?$bde_benefit:$tl_benefit;
    //             $res2 = $this->get_club_benefit($p_id,$benefit,$wal_typ,$entry_id);
    //                 $parent_log_id = $parent_details['parent_login_id'];
    //                 $parent_details = $this->get_parent_login($parent_log_id);
    //                 goto a; 
    //         }else if($parent_details['type']=='admin'){
    //             $cnt++;
                
    //             if($cnt==1){
    //                 $benfit = $bde_benefit+$tl_benefit;
    //             }else if($cnt==2){
    //                 $benfit = $tl_benefit;
    //             }else{
    //                 $benfit ='';
    //             }
                
    //             if($benfit){
    //                 $this->db->set('total_value', 'total_value + ' . (float) $benfit, FALSE);
    //                 $this->db->where('user_id', 1);
    //                 $this->db->where('wallet_type_id', 4);
    //                 $this->db->update('gp_wallet_values');
    //                 $wal_val_id8 =get_wallet_val_id(1,4);
    //                 $wal_activitys = array(
    //                     'wallet_type_id' => 4,
    //                     'wallet_val_id' => $wal_val_id8,
    //                     'user_id' => 1,
    //                     'change_value' => $benfit,
    //                     'type'=>'GAIN',
    //                     'date_modified' => date('Y-m-d h:i:s'),
    //                     'description' => 'Reward through club membership'
    //                 );
    //                 $this->db->insert('gp_wallet_activity', $wal_activitys);
    //                 // Debt 
    //                 $ledger_payment_dr2 = 70;
    //                 $entry_items_dr2 = array(
    //                     'entry_id' => $entry_id,
    //                     'ledger_id' => $ledger_payment_dr,
    //                     'amount' => $benfit,
    //                     'dc' => 'Dr',
    //                     'fy_id' =>$fy_id,
    //                     'created_date' => date('Y-m-d')
    //                 );
    //                 $entry_dr2 = $this->db->insert('erp_ac_entryitems', $entry_items_dr2);
    //             }
    //         }
         
    //     }
       

      
    //     /*$wallete = array('wallet_type_id' => 1, 'user_id' => $det2['id'], 'total_value' => $det1['amount'] );  
    //     $qry3 = $this->db->insert('gp_wallet_values', $wallete);
    //     $wal_id = $this->db->insert_id();


    //     $wal_activityss = array(
    //         'wallet_type_id' => 1,
    //         'wallet_val_id' => $wal_id,
    //         'user_id' => $det2['id'],
    //         'type'=>'GAIN',
    //         'date_modified' => date('Y-m-d h:i:s'),
    //         'description' => 'Club wallet added'
    //         );
    //     $this->db->insert('gp_wallet_activity', $wal_activityss);*/

    //     if ($this->db->trans_status() === TRUE) {
    //         $this->db->trans_commit();
    //         $data['status']= true;
    //         $data['det'] = $det2;
    //     } else {
    //         $this->db->trans_rollback();
    //         $data['status']= false;
    //     }
    //     return $data;
    // }
    function approve_club_member($user_id)
    {
        $benfit ='';
        $this->db->trans_begin();
        $qry1 = "select * from gp_login_table  where user_id='$user_id' AND type='club_member' AND is_del = 0";
        $qry1 = $this->db->query($qry1);
        if($qry1->num_rows()>0)
        {
                $det2= $qry1->row_array();
                $id = $det2['id'];
                $cnt = 0;
                $det = get_details_by_userid($user_id);
                //var_dump($det);exit;
                if($det){
                    $datestring = date('Y-m-d H:i:s');
                    $info = array('status' => 'approved','created_on'=>$datestring);
                    $this->db->where('id', $user_id);
                    $qry = $this->db->update('gp_normal_customer', $info);

                    $parent_login = $det['created_by'];
                     /************Promotion Start***********/
              

                    $qry1 = "select exec.id,exec.sales_desig_type_id from gp_login_table l
                             left join gp_pl_sales_team_members exec on exec.id=l.user_id where l.id='$parent_login' AND exec.is_del = 0";
                    
                    $qry1 = $this->db->query($qry1);
                    if($qry1->num_rows()>0)
                    {
                        $details= $qry1->row_array();
                        $desig = $details['sales_desig_type_id'];
                        $exec_id = $details['id'];

                    
                        $is_team = $this->get_is_team($desig);
                     
                        if($is_team->add_exec=='0'){
                          $promotion = $this->upgrade_designation($exec_id,$parent_login); 
                         
                        }
                    }

                    /************Promotion Start***********/
                    $datas2 = array(
                    'customer_log_id' => $id,
                    'parent_log_id' => 1,
                    'current_parent_log_id' => $det['created_by']
                    );
                    $qryy = $this->db->insert('gp_be_clubmember', $datas2);

                    $infos = array('type' => 'club_member','parent_login_id'=>$parent_login);
                    $this->db->where('user_id', $user_id);
                    $qrs = $this->db->update(' gp_login_table', $infos);
                    $club_plan = ($det['club_type_id'] >0 )? $det['club_type_id']: $det['fixed_club_type_id'];
                    $det1 = getClubtypeById($club_plan);
                   // var_dump($det1);exit();
                    $amount = $det1['amount'];//-($bde_benefit+$tl_benefit);
                    /************Entry Start***********/
                        $fy_year = get_current_financial_year();
                        $fy_id = $fy_year['id'];
                       
                        $no =get_number();
                        $data = array(
                            'entrytype_id'=>2,
                            '_type'=>'CLUB_MEMBERSHIP',
                            'type_id'=>$id,
                            'number'=>$no,
                            'fy_id' =>$fy_id,
                            'date'=>date('Y-m-d'),
                            'dr_total'=>$amount,
                            'cr_total'=>$amount,
                        );
                        $this->db->insert('erp_ac_entries',$data);
                        $entry_id = $this->db->insert_id();
                        $ledger_payment_cr = getLedgerId($id,"CUSTOMER");
                       
                        $entry_items_cr = array(
                            'entry_id' => $entry_id,
                            'ledger_id' => $ledger_payment_cr,
                            'amount' => $amount,
                            'dc' => 'Cr',
                            'fy_id' =>$fy_id,
                            'created_date' => date('Y-m-d')
                        );
                        $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);
                        $mode_payment=$det['mode_payment'];
                        if($mode_payment=='cash'){
                            $ledger_payment_dr = 32;
                        }
                        else if($mode_payment=='cheque'){
                            $ledger_payment_dr = 35;
                        }
                        else{
                            $ledger_payment_dr = 35;
                        }
                        
                        
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
               
                
                        if($det['club_type_id']>0){
                             
                       
                            $bde_benefit = $det1['bde_benefit'];
                            $tl_benefit = $det1['tl_benefit'];
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
                               //print_r($parent_details);exit();
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
                                }else{
                                    $benfit ='';
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
                                    // // Debt 
                                    // $ledger_payment_dr2 = 70;
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
               
                }
        }

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            $data['status']= true;
            $data['det'] = $det2;
        } else {
            $this->db->trans_rollback();
            $data['status']= false;
        }
        return $data;
    }
    function get_all_normal_members_count($search)
    { 
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (gp_normal_customer.name LIKE '%$keyword%' OR gp_normal_customer.phone LIKE '%$keyword%' OR gp_normal_customer.email LIKE '%$keyword%' OR DATE_FORMAT(gp_normal_customer.created_on,'%d-%b-%Y') LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="SELECT gp_normal_customer.id as user_id,gp_normal_customer.*,DATE_FORMAT(gp_normal_customer.created_on,'%d-%b-%Y') FROM `gp_normal_customer`  WHERE gp_normal_customer.type='normal_customer' and gp_normal_customer.is_del!='1'".$where." ORDER BY gp_normal_customer.id DESC";
        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else {
            return false;
        }
    }
    function get_all_normal_members($search,$limit, $start)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (gp_normal_customer.name LIKE '%$keyword%' OR gp_normal_customer.phone LIKE '%$keyword%' OR gp_normal_customer.email LIKE '%$keyword%' OR DATE_FORMAT(gp_normal_customer.created_on,'%d-%b-%Y') LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="SELECT gp_normal_customer.id as user_id,gp_normal_customer.*,DATE_FORMAT(gp_normal_customer.created_on,'%d-%b-%Y')as joined FROM `gp_normal_customer`  WHERE gp_normal_customer.type='normal_customer' and gp_normal_customer.is_del!='1'".$where." ORDER BY gp_normal_customer.id DESC LIMIT $start, $limit";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->result_array();

        }
        else
        {
            return array();
        }
    }
    function get_investor_plans()
    {
        $qry="SELECT * FROM `club_member_type` WHERE type='INVESTOR' AND is_del ='0'";
        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            return $result->result_array();
        }else {
            return array();
        }
    }
    function get_investor_club_members_count($search)
    { 
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "AND (nc.id LIKE '%$keyword%' OR nc.name LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.email LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="SELECT nc.id,nc.name,nc.phone,nc.email,type.title FROM `gp_normal_customer` nc LEFT JOIN gp_login_table log ON nc.id=log.user_id LEFT JOIN club_member_type type ON nc.investor_type_id=type.id WHERE log.type='club_member' AND type.type='INVESTOR' AND nc.status='approved' AND log.is_del=0 ".$where;
        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else {
            return false;
        }
    }
    function get_investor_club_members($search,$limit, $start)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "AND (nc.id LIKE '%$keyword%' OR nc.name LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.email LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="SELECT nc.id,nc.name,nc.phone,nc.email,type.title AS club_plan FROM `gp_normal_customer` nc LEFT JOIN gp_login_table log ON nc.id=log.user_id LEFT JOIN club_member_type type ON nc.investor_type_id=type.id WHERE log.type='club_member' AND type.type='INVESTOR' AND nc.status='approved' AND log.is_del=0 ".$where." ORDER BY log.id DESC LIMIT $start, $limit";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->result_array();
        }else {
            return array();
        }
    }
    function investor_club_registration($res)
    {
        $data = array();
        $this->db->trans_begin();
        $id = $res['id'];
        $user_id = $res['user_id'];
        $details = get_details_by_loginid($id);

        $datas2 = array(
        'customer_log_id' => $id,
        'parent_log_id' => $details['parent_login_id'],
        'current_parent_log_id' => 1
        );
        $qry = $this->db->insert('gp_be_clubmember', $datas2);

        $mode_payment = $this->input->post('payment_mode');
        $type = $this->input->post('type');
        $datas = array(
            'profile_image' =>'',
            'type'=>'club_member',
            'mode_payment'=>$mode_payment,
            'parent_id' => 1,
            'created_by'=>1,
            'club_type_id' => '0',
            'fixed_club_type_id'=> '0',
            'investor_type_id'=> $type,
        );
            

        if($mode_payment=='cheque'){
            $datas['cheque_no']=$this->input->post('cheque');
            $datas['cheque_date']=$this->input->post('cheque_date');
            $datas['bank']=$this->input->post('bank');
        }

        $this->db->where('id', $user_id);
        $qry = $this->db->update('gp_normal_customer', $datas);

        $userLogin = array( 'type' => 'club_member' ); 
        $this->db->where('id', $id);
        $qry_login = $this->db->update('gp_login_table', $userLogin);
        $det1 = getClubtypeById($type);
        if(!empty($det1)){
            $wallete = array('wallet_type_id' => 1, 'user_id' => $id, 'total_value' => $det1['amount'] );  
            $qry3 = $this->db->insert('gp_wallet_values', $wallete);
            $wal_id = $this->db->insert_id();


            $wal_activityss = array(
                'wallet_type_id' => 1,
                'wallet_val_id' => $wal_id,
                'user_id' => $id,
                'type'=>'GAIN',
                'date_modified' => date('Y-m-d h:i:s'),
                'description' => 'Club wallet added'
                );
            $this->db->insert('gp_wallet_activity', $wal_activityss);
            //Entry Start
            $fy_year = get_current_financial_year();
            $fy_id = $fy_year['id'];
           
            $no =get_number();
            $ent_data = array(
                'entrytype_id'=>2,
                '_type'=>'CLUB_MEMBERSHIP',
                'type_id'=>$id,
                'number'=>$no,
                'fy_id' =>$fy_id,
                'date'=>date('Y-m-d'),
                'dr_total'=>$det1['amount'] ,
                'cr_total'=>$det1['amount'] ,
            );
            $this->db->insert('erp_ac_entries',$ent_data);
            $entry_id = $this->db->insert_id();
           
            //$ledger_payment_cr = 71;
            $ledger_payment_cr = getLedgerId($id,"CUSTOMER");
            if($mode_payment=='cash'){
                $ledger_payment_dr = 32;
            }
            else if($mode_payment=='cheque'){
                $ledger_payment_dr = 35;
            }
            else{
                $ledger_payment_dr = 35;
            }

            

            $entry_items_cr = array(
                'entry_id' => $entry_id,
                'ledger_id' => $ledger_payment_cr,
                'amount' => $det1['amount'],
                'dc' => 'Cr',
                'fy_id' =>$fy_id,
                'created_date' => date('Y-m-d')
            );
            $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);

            $entry_items_dr = array(
                'entry_id' => $entry_id,
                'ledger_id' => $ledger_payment_dr,
                'amount' => $det1['amount'] ,
                'dc' => 'Dr',
                'fy_id' =>$fy_id,
                'created_date' => date('Y-m-d')
            );
            $entry_dr = $this->db->insert('erp_ac_entryitems', $entry_items_dr);
            //Entry End
            $wallete2 = array('wallet_type_id' => 3, 'user_id' => $id, 'total_value' => 0 );  
            $qry32 = $this->db->insert('gp_wallet_values', $wallete2);
            $wal_id2 = $this->db->insert_id();


            $wal_activityss2 = array(
                'wallet_type_id' => 1,
                'wallet_val_id' => $wal_id2,
                'user_id' => $id,
                'type'=>'GAIN',
                'date_modified' => date('Y-m-d h:i:s'),
                'description' => 'Club wallet added'
                );
            $this->db->insert('gp_wallet_activity', $wal_activityss2); 
        }
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
    function get_investor_member($id)
    {
        $qry="SELECT gp_normal_customer.*,(SELECT club_member_type.title FROM club_member_type WHERE gp_normal_customer.investor_type_id=club_member_type.id )as type ,gp_login_table.id as log_id FROM `gp_normal_customer` 
        LEFT JOIN gp_login_table ON gp_normal_customer.id=gp_login_table.user_id
        WHERE gp_normal_customer.id='$id' AND gp_login_table.type='club_member' 
        GROUP BY gp_normal_customer.id";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->row_array();

        } else{
            return array();
        }
    }
    function update_investor_club_member($data,$id)
    {
        $this->db->trans_begin();
        $this->db->select('investor_type_id')
                    ->from('gp_normal_customer')
                    ->where('id',$id);
        $type = $this->db->get()->row()->investor_type_id;
        $det1 = getClubtypeById($type);
        $club_plan=$data['investor_type_id'];
        $log_id = $this->input->post('log_id');
        $payment_mode =$this->input->post('payment_mode');
        if(isset($club_plan)&&($type!=$club_plan)){
            $qry_amount = $this->db->query("select id, amount from club_member_type where id = '$club_plan'");
            if($qry_amount->num_rows()>0)
            {
                $get_clubdetails = $qry_amount->row_array();
                $get_amount = $get_clubdetails['amount'];
                $g_amount = $get_clubdetails['amount']-$det1['amount'];
                $this->db->set('total_value', 'total_value + ' . (float) $get_amount, FALSE);
                $this->db->where('user_id', $log_id);
                $this->db->where('wallet_type_id', 1);
                $this->db->update('gp_wallet_values');
                
                $wal_activity = array(
                    'wallet_type_id' => 1,
                    'user_id' => $log_id,
                    'change_value' => $get_amount,
                    'date_modified' => date('Y-m-d h:i:s'),
                    'description' => 'Upgrade Club Membership'
                    );
                $this->db->insert('gp_wallet_activity', $wal_activity);
                $fy_year = get_current_financial_year();
                $fy_id = $fy_year['id'];
               
                $no =get_number();
                $ent_data = array(
                    'entrytype_id'=>2,
                    '_type'=>'CLUB_MEMBERSHIP',
                    'type_id'=>$id,
                    'number'=>$no,
                    'fy_id' =>$fy_id,
                    'date'=>date('Y-m-d'),
                    'dr_total'=>$g_amount ,
                    'cr_total'=>$g_amount 
                );
                $this->db->insert('erp_ac_entries',$ent_data);
                $entry_id = $this->db->insert_id();
               
                $ledger_payment_cr = 71;
                
                if($payment_mode=='cash'){
                    $ledger_payment_dr = 32;
                }
                else if($payment_mode=='cheque'){
                    $ledger_payment_dr = 35;
                }
                /*else{
                    $ledger_payment_dr = 49;
                }*/

                

                $entry_items_cr = array(
                    'entry_id' => $entry_id,
                    'ledger_id' => $ledger_payment_cr,
                    'amount' => $g_amount,
                    'dc' => 'Cr',
                    'fy_id' =>$fy_id,
                    'created_date' => date('Y-m-d')
                );
                $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);

                $entry_items_dr = array(
                    'entry_id' => $entry_id,
                    'ledger_id' => $ledger_payment_dr,
                    'amount' => $g_amount ,
                    'dc' => 'Dr',
                    'fy_id' =>$fy_id,
                    'created_date' => date('Y-m-d')
                );
                $entry_dr = $this->db->insert('erp_ac_entryitems', $entry_items_dr);
            }
        }else{
            $qry_amount = $this->db->query("select id, amount from club_member_type where id = '$type'");
            if($qry_amount->num_rows()>0)
            {
                $get_clubdetails = $qry_amount->row_array();
                $get_amount = $get_clubdetails['amount'];
                $this->db->set('total_value', 'total_value -' . (float) $get_amount, FALSE);
                $this->db->where('user_id', $log_id);
                $this->db->where('wallet_type_id', 1);
                $this->db->update('gp_wallet_values');
                $wal_activity = array(
                    'wallet_type_id' => 1,
                    'user_id' => $log_id,
                    'change_value' => $get_amount,
                    'date_modified' => date('Y-m-d h:i:s'),
                    'description' => 'Upgrade Club Membership'
                    );
                $this->db->insert('gp_wallet_activity', $wal_activity);
            }
        }


        $data['updated_on']=date('Y-m-d h:i:s');
        $this->db->where('id', $id);
        $qry = $this->db->update('gp_normal_customer', $data);

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
 ?>