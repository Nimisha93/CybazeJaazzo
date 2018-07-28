<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

function update_tbl($tbl,$data,$where)
{
	$ci =& get_instance();
	$ci->load->database();
	$ci->db->trans_begin();
	$ci->db->where($where); 
    $ci->db->update($tbl,$data);
    //echo $ci->db->last_query();exit();
	$ci->db->trans_complete();
    if( $ci->db->trans_status()===false){
    	$ci->db->trans_rollback();
    	return false;
    }else{
        $ci->db->trans_commit();
    	return true;
    }
}
function select_all_by_id($tbl,$id,$tbl2,$where)
{
	$ci =& get_instance();
	$ci->load->database();
 	$data = $ci->db->select('*')
 	    ->join($tbl2,$where)
        ->where($tbl.'.id',$id)
        ->limit(1)
        ->get($tbl)
        ->row();
    if($data) {
        return $data;
    }else{
        return false;
    }
}
function select_all_by_id_result($tbl,$where,$tbl2,$on)
{
    $ci =& get_instance();
    $ci->load->database();
    $data = $ci->db->select('*')
        ->join($tbl2,$on)
        ->where($where)
        ->get($tbl)
        ->result();
    
    if($data) {
        return $data;
    }else{
        return false;
    }
}
function raw_select($tbl1,$tbl2,$on,$where,$sel)
{
    $ci =& get_instance();
    $ci->load->database();
    $data = $ci->db->select($sel)
        ->join($tbl2,$on)
        ->where($where)
        ->get($tbl1)
        ->result();
        
    if($data) {
        return $data;
    }else{
        return false;
    }
}
function select_by_id($tbl,$id)
{
    $ci =& get_instance();
    $ci->load->database();
    $data = $ci->db->select('*')
        ->where($tbl.'.id',$id)
        ->limit(1)
        ->get($tbl)
        ->row();
        //echo $ci->db->last_query();exit();
    if($data) {
        return $data;
    }else{
        return false;
    }
 }
 function normal_select($tbl,$where,$sel)
{
    $ci =& get_instance();
    $ci->load->database();
    $data = $ci->db->select($sel)
        ->where($where)
        ->get($tbl)
        ->result();
        //echo $ci->db->last_query();exit();
    if($data) {
        return $data;
    }else{
        return false;
    }
 }
function multi_insert($tbl,$data)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->trans_begin(); 
    $ci->db->insert_batch($tbl,$data);
    $ci->db->trans_complete();
    if( $ci->db->trans_status()===false){
        $ci->db->trans_rollback();
        return false;
    }else{
        $ci->db->trans_commit();
        return true;
    }
}
function insert($tbl,$data)
{
    $ci =& get_instance();
    $ci->load->database();
    $ci->db->trans_begin(); 
    $ci->db->insert($tbl,$data);
    $ci->db->trans_complete();
    if( $ci->db->trans_status()===false){
        $ci->db->trans_rollback();
        return false;
    }else{
        $ci->db->trans_commit();
        return true;
    }
}
function search_where($search,$cols)
{
    $where = '';
        foreach ($cols as $ky => $col ){
            if($ky==0){
            $where = "and (".$col." LIKE '%$search%' " ;

            }
            $where .= "OR ".$col." LIKE '%$search%'";
            
        }
        $where .= ")";
    return $where;
}

function row_count($search,$tbl1,$tbl2,$on1,$tbl3,$on2,$cols)
{ 
    if(!empty($search)){
        $where = search_where($search,$cols);
    }else{
        $where = '';
    }
    $ci =& get_instance();
    $ci->load->database();
     $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
    $coll = implode(',',$cols); 
    

    if($tbl2!='' && $tbl3!='') {
      $datas = $ci->db->select($coll)
        ->join($tbl2,$on1)
        ->join($tbl3,$on2)
        ->where($tbl1.'.parent_login_id='.$login_id.' AND '.$tbl1.'.is_del=0 '.$where)
        ->get($tbl1)
        ->num_rows();
    }else{
        if($tbl3!='') {
          $datas = $ci->db->select($coll)
            ->join($tbl2,$on1)
            ->join($tbl3,$on2)
            ->where($tbl1.'.id='.$login_id.' AND '.$tbl1.'.is_del=0 '.$where)
            ->get($tbl1)
            ->num_rows();
        }else if($tbl2!='') {
            if($tbl2=='gp_normal_customer'){
                $datas = $ci->db->select($coll)
                ->join($tbl2,$on1)
                ->where('('.$tbl1.'.parent_login_id='.$login_id.' OR '.$tbl2.'.mem_id='.$login_id.') AND '.$tbl1.'.is_del=0 '.$where)
                ->get($tbl1)
                ->num_rows(); 
            }else{
                $datas = $ci->db->select($coll)
                ->join($tbl2,$on1)
                ->where($tbl1.'.club_mem_id='.$login_id.' AND '.$tbl1.'.is_del=0 '.$where)
                ->get($tbl1)
                ->num_rows();   
            }
        }else{
          $datas = $ci->db->select($coll)
            ->where($tbl1.'.created_by='.$login_id.' AND '.$tbl1.'.is_del=0 '.$where)
            ->get($tbl1)
            ->num_rows();
        } 
    }
    if($datas) {
        return $datas;
    }else{
        return false;
    }
}

function paginations($search,$tbl1,$tbl2,$on1,$tbl3,$on2,$cols,$limit,$start)
{
    if(!empty($search)){
        $where = search_where($search,$cols);
    }else{
        $where = '';
    }
     $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
    $ci =& get_instance();
    $ci->load->database();
    $coll = implode(',',$cols);  
    if($tbl2!='' && $tbl3!='') {
      $datas = $ci->db->select($coll)
        ->join($tbl2,$on1)
        ->join($tbl3,$on2)
        ->where($tbl1.'.parent_login_id='.$login_id.' AND '.$tbl1.'.is_del=0 '.$where)
        ->order_by($tbl1.".id", "desc")
        ->limit($limit, $start)
        ->get($tbl1)
        ->result();
    }else{
        if($tbl3!='') {
          $datas = $ci->db->select($coll)
            ->join($tbl2,$on1)
            ->join($tbl3,$on2)
            ->where($tbl1.'.id='.$login_id.' AND '.$tbl1.'.is_del=0 '.$where)
            ->order_by($tbl1.".id", "desc")
            ->limit($limit, $start)
            ->get($tbl1)
            ->result();
        }else if($tbl2!='') {
            if($tbl2=='gp_normal_customer'){
                $datas = $ci->db->select($coll)
                ->join($tbl2,$on1)
                ->where('('.$tbl1.'.parent_login_id='.$login_id.' OR '.$tbl2.'.mem_id='.$login_id.') AND '.$tbl1.'.is_del=0 '.$where)
                ->order_by($tbl1.".id", "desc")
                ->limit($limit, $start)
                ->get($tbl1)
                ->result();
            }else{

                $datas = $ci->db->select($coll)
                ->join($tbl2,$on1)
                ->where($tbl1.'.club_mem_id='.$login_id.' AND '.$tbl1.'.is_del=0 '.$where)
                ->order_by($tbl1.".id", "desc")
                ->limit($limit, $start)
                ->get($tbl1)
                ->result();
            }

           /* $datas = $ci->db->select($coll)
                ->join($tbl2,$on1)
                ->where(($tbl1.'.club_mem_id='.$login_id.'OR '.$tbl2.'.mem_id='.$login_id.') AND '.$tbl1.'.is_del=0 '.$where))
                ->order_by($tbl1.".id", "desc")
                ->limit($limit, $start)
                ->get($tbl1)
                ->result();*/
        }else{
          $datas = $ci->db->select($coll)
            ->where($tbl1.'.created_by='.$login_id.' AND '.$tbl1.'.status=0 '.$where)
            ->order_by($tbl1.".id", "desc")
            ->limit($limit, $start)
            ->get($tbl1)
            ->result();
        } 
    } 
    if($datas) {
        return $datas;
    }else{
        return false;
    }
}
function get_cmfacility_by_id($id)
{

    $ci =& get_instance();
    $ci->load->database();
    $data = array();
    $qry = "SELECT nc.name,nc.id as user_id,nc.club_type_id,nc.fixed_club_type_id,nc.investor_type_id,lt.id as login_id FROM `gp_normal_customer` nc 
    left join gp_login_table lt ON lt.user_id = nc.id  
    WHERE lt.id='$id' AND  lt.type='club_member'";

    $query = $ci->db->query($qry);
    if($query->num_rows()>0)
    {
        $cm_details1 =  $query->row_array();
        $club_type_id = $cm_details1['club_type_id'];
        $fixed = $cm_details1['fixed_club_type_id'];
        $investr = $cm_details1['investor_type_id'];
        if($investr>0){
            $qry2 = "SELECT mt.title as plan,mt.club_agent_status,mt.ca_limit,mt.cp_status,mt.cp_limit,mt.user_status,mt.user_limit,mt.bde_status,mt.bde_limit,mt.ba_status,mt.ba_limit,mt.cash_limit FROM `gp_normal_customer` nc 
            left join gp_login_table lt ON lt.user_id = nc.id  
            left JOIN club_member_type mt ON nc.investor_type_id=mt.id 
            WHERE lt.id='$id' AND  lt.type='club_member'";
        }
        if($fixed>0){
            $qry2 = "SELECT mt.title as plan,mt.cp_status,mt.cp_limit,mt.user_status,mt.user_limit,mt.cash_limit FROM 
            `gp_normal_customer` nc 
            left join gp_login_table lt ON lt.user_id = nc.id  
            left JOIN club_member_type mt ON nc.fixed_club_type_id=mt.id 
            WHERE lt.id='$id' AND  lt.type='club_member'";
        }
        if(!empty($club_type_id))
        {
            $qry2 = "SELECT mt.title as plan,mt.club_agent_status,mt.ca_limit,mt.cp_status,mt.cp_limit,mt.user_status,mt.user_limit,mt.ba_status,mt.ba_limit,mt.cash_limit FROM `gp_normal_customer` nc 
            left join gp_login_table lt ON lt.user_id = nc.id  
            left JOIN club_member_type mt ON nc.club_type_id=mt.id 
            WHERE lt.id='$id' AND  lt.type='club_member'";
        }
        $query2 = $ci->db->query($qry2);
        if($query2->num_rows()>0)
        {

            $cm_details2 =  $query2->row_array();
            $login_id = $id;
            $fixedd = $cm_details1['fixed_club_type_id'];
            if($fixedd)
            {
                $qry22 = "SELECT nc.name,nc.id as user_id,nc.club_type_id,nc.fixed_club_type_id,lt.id as login_id,mt.title as plan,mt.cp_status,   mt.ref_cp_status,    mt.cp_limit,    mt.ref_cp_limit,    mt.reward_per_cp,mt.cash_limit FROM `gp_normal_customer` nc 
                left join gp_login_table lt ON lt.user_id = nc.id  
                left JOIN club_member_type mt ON nc.fixed_club_type_id=mt.id 
                WHERE lt.id='$id' AND  lt.type='club_member'";
                $query22 = $ci->db->query($qry22);
                if($query22->num_rows()>0)
                {
                    $details =  $query22->row_array();
                    
                    
                    
                    
                    
                      if($details['cp_status'])
                    {
                        $data['fixed_cp_limit'] = $details['cp_limit'];

                    }
                    else
                    {
                        $data['fixed_cp_limit'] = 0;
                    }



                    if($details['ref_cp_status'])
                    {
                        $data['fixed_cp_limit'] += $details['ref_cp_limit'];

                    }
                    
                   /* else
                    {
                        $data['fixed_cp_limit'] = 0;
                    }*/
                    
                    
                    
                    
                    
                    
                   /* $data['fixed_cp_limit'] = $details['cp_limit'];*/
                   
                   
                    $data['fixed_year_limit'] = $details['cash_limit']; // $data['cp_limit'] = $details['cp_limit'];
                }
                $sql222 = "SELECT * FROM `gp_pl_channel_partner` where club_type='FIXED' and club_mem_id='$login_id' ORDER BY `id`  DESC";
                $sqll222 = $ci->db->query($sql222);
               
                if($sqll222->num_rows()>0)
                {
                    $data['fixed_cp_count'] = $sqll222->num_rows();
                    
                }else{
                    $data['fixed_cp_count'] = 0;
                }
            }else{
                $data['fixed_cp_limit'] = 0;
                $data['fixed_cp_count'] = 0;
            }
            $data['year_limit'] = $cm_details2['cash_limit']; 
            if(isset($cm_details2['club_agent_status']))
            {
                $sql1 = "SELECT * FROM `gp_login_table` log left join `gp_normal_customer` nc ON
                log.user_id=nc.id where log.type='club_agent' and log.parent_login_id='$login_id' AND nc.status='approved' ORDER BY log.id  DESC";
                $sqll1 = $ci->db->query($sql1);
                if($sqll1->num_rows()>0)
                {
                    $data['ca_details'] =  $sqll1->result_array();
                    $data['ca_limit'] = $cm_details2['ca_limit'];
                    $data['ca_count'] = $sqll1->num_rows();
                }else{
                    $data['ca_details'] = array();
                    $data['ca_limit'] = $cm_details2['ca_limit'];
                    $data['ca_count'] = 0;
                }
            }else{
                    $data['ca_details'] = array();
                    $data['ca_limit'] = 0;
                    $data['ca_count'] = 0;
            }

            if($cm_details2['cp_status'])
            {
                $sql2 = "SELECT * FROM `gp_pl_channel_partner` where club_type='UNLIMITED' and club_mem_id='$login_id' ORDER BY `id`  DESC";
                $sqll2 = $ci->db->query($sql2);
                if($sqll2->num_rows()>0)
                {
                    $data['cp_details'] =  $sqll2->result_array();
                    $data['cp_limit'] = $cm_details2['cp_limit'];
                    $data['cp_count'] = $sqll2->num_rows();
                }else{
                    $data['cp_details'] = array();
                    $data['cp_limit'] = $cm_details2['cp_limit'];
                    $data['cp_count'] = 0;
                }
                $data['cp_status'] = 1;
            }else{
                    $data['cp_details'] = array();
                    $data['cp_limit'] = 0;
                    $data['cp_count'] = 0;
                    $data['cp_status'] = 0;
            }
            if(isset($cm_details2['user_status']))
            {
                $sql3 = "SELECT * FROM `gp_login_table` where parent_login_id='$login_id' AND (type='normal_customer')
                and is_del='0' ORDER BY `id`  DESC";
                $sqll3 = $ci->db->query($sql3);
                if($sqll3->num_rows()>0)
                {
                    $data['frnd_details'] =  $sqll3->result_array();
                    $data['frnd_limit'] = $cm_details2['user_limit'];
                    $data['frnd_count'] = $sqll3->num_rows();
                }else{
                    $data['frnd_details'] = array();
                    $data['frnd_limit'] = $cm_details2['user_limit'];
                    $data['frnd_count'] = 0;
                }
                $sql6 = "SELECT * FROM `gp_be_clubmember` LEFT JOIN   `gp_login_table` ON `gp_be_clubmember`.`parent_log_id`= `gp_login_table`.`id`  where parent_log_id='$login_id' AND `gp_login_table`.`type`='club_member'  ORDER BY `gp_be_clubmember`.`id`  DESC";
                $sqll6 = $ci->db->query($sql6);
                if($sqll6->num_rows()>0)
                {
                    $data['frnd_count'] += $sqll6->num_rows();
                }
            }else{
                    $data['frnd_details'] = array();
                    $data['frnd_limit'] = 0;
                    $data['frnd_count'] = 0;
            }
            if(isset($cm_details2['ba_status']))
            {
                $sql4 = "SELECT * FROM `pl_ba_registration` where created_by='$login_id' and is_del='0' ORDER BY `id`  DESC";
                $sqll4 = $ci->db->query($sql4);
                if($sqll4->num_rows()>0)
                {
                    $data['ba_details'] =  $sqll4->result_array();
                    $data['ba_limit'] = $cm_details2['ba_limit'];
                    $data['ba_count'] = $sqll4->num_rows();
                }else{
                    $data['ba_details'] = array();
                    $data['ba_limit'] = $cm_details2['ba_limit'];
                    $data['ba_count'] = 0;
                }
            }else{
                    $data['ba_details'] = array();
                    $data['ba_limit'] = 0;
                    $data['ba_count'] = 0;
            }
            if(isset($cm_details2['bde_status']))
            {
                $sql5 = "SELECT * FROM gp_pl_sales_team_members st
                LEFT JOIN gp_pl_sales_designation_type des
                ON st.sales_desig_type_id =des.id
                where des.type='executive' and st.created_by='$login_id' and st.status='ACTIVE' and st.is_del='0' ORDER BY st.id  DESC";
                $sqll5 = $ci->db->query($sql5);
                if($sqll5->num_rows()>0)
                {
                    $data['bde_details'] =  $sqll5->result_array();
                    $data['bde_limit'] = $cm_details2['bde_limit'];
                    $data['bde_count'] = $sqll5->num_rows();
                }else{
                    $data['bde_details'] = array();
                    $data['bde_limit'] = $cm_details2['bde_limit'];
                    $data['bde_count'] = 0;
                }
            }else{
                    $data['bde_details'] = array();
                    $data['bde_limit'] = 0;
                    $data['bde_count'] = 0;
            }
            return $data;
        }
    } else{
        return array();
    }
}
?>