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
		$otp = random_string('numeric', 5);
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
                                                       echo $this->db->last_query();
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
}
 ?>