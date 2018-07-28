<?php
Class Executives_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();
    }

    function get_clubagent_count($id){
    $qry = "SELECT count(gp_customer.id) co_clubagent FROM gp_login_table gp_login left join `gp_normal_customer` gp_customer on gp_customer.id=gp_login.user_id where gp_customer.created_by='$id'  and gp_login.type='club_agent' and gp_login.otp_status='1' and gp_customer.status='approved'";
       
        $query=$this->db->query($qry);
        if($query){
            $data['member']=$query->row_array();
        }
        else{
            $data['member']=array();
        }
        return $data;

}
function check_count($desig,$id)
{
    $data = array();
     $qry = "SELECT type1.bde_count FROM `gp_pl_sales_designation_type` type1  where type1.id='$desig'";
    //echo $qry;exit();
      $query = $this->db->query($qry);
    if($query->num_rows()>0)
    {
        $cm_details =  $query->row_array();
        

            $sql1 = "SELECT * FROM `gp_login_table` where type='executive' and parent_login_id='$id' ORDER BY `id`  DESC";
            $sqll1 =$this->db->query($sql1);
            if($sqll1->num_rows()>0)
            {
       
                $data['bde_limit'] = $cm_details['bde_count'];
                $data['bde_count'] = $sqll1->num_rows();
            }else{

                $data['bde_limit'] = $cm_details['bde_count'];
                $data['bde_count'] = 0;
            }
            //print_r($data);
            return $data;
    } else{
     return array();
    }
}
function get_low_sort(){
        $qry = "SELECT id,designation FROM `gp_pl_sales_designation_type`  where sort_order=(SELECT MIN(sort_order) FROM gp_pl_sales_designation_type where type='executive')";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->row_array();
        }   else{
            return array();
        }   
    }



    function get_channel_count($id){
       
      $qry = "select
                count(cp.id) cp_id
                from
                gp_pl_channel_partner cp
               

                left join gp_login_table gp_log on gp_log.id=cp.created_by
                where cp.is_del='0' and cp.created_by='$id' and gp_log.otp_status='1' and cp.status='joined'
               ";
    
        $query=$this->db->query($qry);
        if($query){
            $data['partner']=$query->row_array();
        }
        else{
            $data['partner']=array();
        }
        return $data;
    }
    function get_ba_count($id){
       
      $qry = "SELECT count(id) ba_id FROM `pl_ba_registration` where created_by='$id'
                
               ";
    
        $query=$this->db->query($qry);
        if($query){
            $data['ba']=$query->row_array();
        }
        else{
            $data['ba']=array();
        }
        return $data;
    }
    function get_executive_count($id){
       
      $qry = "SELECT count(id) exec_id FROM `gp_pl_sales_team_members` where status='ACTIVE' and created_by='$id'
                
               ";
    
        $query=$this->db->query($qry);
        if($query){
            $data['exec']=$query->row_array();
        }
        else{
            $data['exec']=array();
        }
        return $data;
    }
    function get_club_count($id){
    
    $qry = "SELECT count(gp_customer.id) c_id FROM gp_login_table gp_login left join `gp_normal_customer` gp_customer on gp_customer.id=gp_login.user_id where gp_customer.created_by='$id' and gp_customer.status='approved' and gp_login.type='club_member' ";

        $query=$this->db->query($qry);
        if($query){
            $data['member']=$query->row_array();
        }
        else{
            $data['member']=array();
        }
        return $data;

}
/*    function is_set_gift($desig){
    
    $qry = "SELECT count(gp_customer.id) c_id FROM gp_login_table gp_login left join `gp_normal_customer` gp_customer on gp_customer.id=gp_login.user_id where gp_customer.created_by='$id' and gp_customer.status='approved' and gp_login.type='club_member' ";

        $query=$this->db->query($qry);
        if($query){
            $data['member']=$query->row_array();
        }
        else{
            $data['member']=array();
        }
        return $data;

}*/
/*    function get_my_wallet($id){
    $qry = "SELECT wallet.total_value FROM gp_wallet_values wallet  where wallet.user_id='$id' ";

        $query=$this->db->query($qry);
        if($query){
            $data['member']=$query->row_array();
        }
        else{
            $data['member']=array();
        }
        return $data;

}*/
    function get_my_wallet($id){
    $qry = "SELECT wallet.total_value FROM gp_wallet_values wallet  where wallet.user_id='$id' ";
   
        $query=$this->db->query($qry);
        if($query){
            $data['member']=$query->row_array();
        }
        else{
            $data['member']=array();
        }
        return $data;
    }
    function get_mywallet_value()
    {
        $qry="SELECT total_value FROM `gp_wallet_values` WHERE `user_id` = '13'";

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
    function get_promotion($id){
       $cur_date = date('Y-m-d'); 
       $qry = "select
                type.designation,pg.package_name,pg.image
                from promotion_notification pn
                left join gp_pl_sales_designation_type type on type.id=pn.designation
                left join promotion_gifts pg on pg.to_desig=pn.designation and pg.is_del='0'

                where pn.user_id='$id' and pn.date='$cur_date'";
             
        $query=$this->db->query($qry);
        if($query){
            $result=$query->row_array();
        }
        else{
            $result=array();
        }
        return $result;
    }



    function get_desigsviewall(){
    $qry="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id
        FROM `gp_pl_sales_designation_type` LEFT JOIN `gp_executive_promotion_settings`
        ON gp_pl_sales_designation_type.id = gp_executive_promotion_settings.designation_id 
        where gp_pl_sales_designation_type.is_del='0' and gp_pl_sales_designation_type.type='executive'
        GROUP BY gp_pl_sales_designation_type.designation  ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_countries()
    {
        $qry = "select
                c.*
                from
                countries c";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
    function club_membership()
    {
        $qry = "select
                c.*
                from
                club_member_type c";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
    function insert_execbasics($data,$data1,$data3)
    {
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $desig=$loginsession['desig'];
        $date = date('Y-m-d');
        $a1 = $this->input->post('ename');
        $api=apikey_generate();
        $is_team = $this->get_is_team($desig);
  if($is_team->add_exec=='1'){
          $promotion = $this->upgrade_designation_team($userid,$lgid);  
        }
        $qry = $this->db->insert('gp_pl_sales_team_members', $data);
        $lid=$this->db->insert_id();
        $data2 = array('sales_team_member_id' => $lid );
        $appended1 = array_merge($data1,$data2);
        $data4 = array( 'user_id' => $lid, 'api_key' => $api);
        $appended2 = array_merge($data3,$data4);
        $qry1 = $this->db->insert('gp_pl_sales_team_member_details', $appended1);
        $qry2 = $this->db->insert('gp_login_table', $appended2);
        $u_id=$this->db->insert_id();
      
                     $hr_ldg = array(
                                    'type_id' => $u_id,
                                    '_type' => 'EXECUTIVE',
                                    'group_id' => 25,
                                    'name' => $u_id ."_".$a1.'_ledger'
                                );
            $acc_qry = $this->db->insert('erp_ac_ledgers', $hr_ldg);
            $leg_id=$this->db->insert_id();


                         $opening = array(
                                    'ledger_id' => $leg_id,
                                    'fy_id' => '1',
                                    'opening_date' =>$date
                                    );
            $open_qry = $this->db->insert('erp_ac_opening_balance', $opening);

        $data6 = array('wallet_type_id'=>'3',
            'user_id' => $u_id);
        
        $qry3 = $this->db->insert('gp_wallet_values', $data6);
        //echo $this->db->last_query();exit();
            $action = "Added Executives ";
            $date = date("Y-m-d h:i:sa") ;
            $loginsession = $this->session->userdata('logged_in_exec');
            $userid=$loginsession['user_id'];
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
    function edit_execbasics($data,$data1)
    {
        $this->db->trans_begin();
        $id = $this->input->post('id');
        $this->db->where('id',$id);
        $qry = $this->db->update('gp_pl_sales_team_members', $data);
     
        $this->db->where('sales_team_member_id',$id);
        $qry1 = $this->db->update('gp_pl_sales_team_member_details', $data1);

        $action = "Edited Executives ";
        $date = date("Y-m-d h:i:sa") ;
        $loginsession = $this->session->userdata('logged_in_exec');

        $userid=$loginsession['user_id'];
        $status = 0;

        activity_log($action,$userid,$status,$date);
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
    function get_executives_count($search)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (gp_member_det.phone LIKE '%$keyword%' OR gp_member_det.email LIKE '%$keyword%' OR gp_desig.designation LIKE '%$keyword%' OR gp_desig.designation LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="select gp_team_mem.*,gp_member_det.name,gp_member_det.phone,gp_member_det.email,gp_member_det.address,gp_desig.designation
        from gp_pl_sales_team_members gp_team_mem
        join gp_pl_sales_team_member_details gp_member_det on gp_team_mem.id = gp_member_det.sales_team_member_id
        join gp_pl_sales_designation_type gp_desig on gp_team_mem.sales_desig_type_id = gp_desig.id
        join gp_login_table on gp_team_mem.id = gp_login_table.user_id where 
        gp_team_mem.is_del ='0'
        and gp_login_table.is_del ='0' and  gp_member_det.is_del ='0'".$where." group by gp_team_mem.id order by gp_team_mem.id desc";
        $qry = $this->db->query($qry);
       // echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            return $qry->num_rows();
        } else{
            return false;
        }

    }
    function get_executives($search,$limit,$start){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (gp_member_det.phone LIKE '%$keyword%' OR gp_member_det.email LIKE '%$keyword%' OR gp_desig.designation LIKE '%$keyword%' OR gp_desig.designation LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="select gp_team_mem.*,gp_member_det.name,gp_member_det.phone,gp_member_det.email,gp_member_det.address,gp_desig.designation
        from gp_pl_sales_team_members gp_team_mem
        join gp_pl_sales_team_member_details gp_member_det on gp_team_mem.id = gp_member_det.sales_team_member_id
        join gp_pl_sales_designation_type gp_desig on gp_team_mem.sales_desig_type_id = gp_desig.id
        join gp_login_table on gp_team_mem.id = gp_login_table.user_id where 
        gp_team_mem.is_del ='0'
        and gp_login_table.is_del ='0' and  gp_member_det.is_del ='0' and gp_team_mem.status='ACTIVE'".$where." group by gp_team_mem.id order by gp_team_mem.id desc  LIMIT $start, $limit";
        $qry = $this->db->query($qry);
       // echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function tm_get_executives_count($search,$lgid)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (gp_member_det.phone LIKE '%$keyword%' OR gp_member_det.email LIKE '%$keyword%' OR gp_desig.designation LIKE '%$keyword%' OR gp_desig.designation LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="select gp_team_mem.*,gp_member_det.name,gp_member_det.phone,gp_member_det.email,gp_member_det.address,gp_desig.designation
        from gp_pl_sales_team_members gp_team_mem
        join gp_pl_sales_team_member_details gp_member_det on gp_team_mem.id = gp_member_det.sales_team_member_id
        join gp_pl_sales_designation_type gp_desig on gp_team_mem.sales_desig_type_id = gp_desig.id
        join gp_login_table on gp_team_mem.id = gp_login_table.user_id where 
        gp_team_mem.is_del ='0'
        and gp_login_table.is_del ='0' and  gp_member_det.is_del ='0' and gp_team_mem.status='ACTIVE' and gp_team_mem.created_by='$lgid'".$where." group by gp_team_mem.id order by gp_team_mem.id desc";
        $qry = $this->db->query($qry);
       // echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            return $qry->num_rows();
        } else{
            return false;
        }

    }
        function tm_get_executives_count_reffered($search,$lgid)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (gp_member_det.phone LIKE '%$keyword%' OR gp_member_det.email LIKE '%$keyword%' OR gp_desig.designation LIKE '%$keyword%' OR gp_desig.designation LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="select gp_team_mem.*,gp_member_det.name,gp_member_det.phone,gp_member_det.email,gp_member_det.address,gp_desig.designation
        from gp_pl_sales_team_members gp_team_mem
        join gp_pl_sales_team_member_details gp_member_det on gp_team_mem.id = gp_member_det.sales_team_member_id
        join gp_pl_sales_designation_type gp_desig on gp_team_mem.sales_desig_type_id = gp_desig.id
        join gp_login_table on gp_team_mem.id = gp_login_table.user_id where 
        gp_team_mem.is_del ='0'
        and gp_login_table.is_del ='0' and  gp_member_det.is_del ='0' and gp_team_mem.status='NOT_APPROVED'   and gp_team_mem.created_by='$lgid'".$where." group by gp_team_mem.id order by gp_team_mem.id desc";
        $qry = $this->db->query($qry);

        if($qry->num_rows()>0){
            return $qry->num_rows();
        } else{
            return false;
        }

    }

        function tm_get_executives($search,$limit,$start,$lgid){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (gp_member_det.phone LIKE '%$keyword%' OR gp_member_det.email LIKE '%$keyword%' OR gp_desig.designation LIKE '%$keyword%' OR gp_desig.designation LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="select gp_team_mem.*,gp_member_det.name,gp_member_det.phone,gp_member_det.email,gp_member_det.address,gp_desig.designation
        from gp_pl_sales_team_members gp_team_mem
        join gp_pl_sales_team_member_details gp_member_det on gp_team_mem.id = gp_member_det.sales_team_member_id
        join gp_pl_sales_designation_type gp_desig on gp_team_mem.sales_desig_type_id = gp_desig.id
        join gp_login_table on gp_team_mem.id = gp_login_table.user_id where 
        gp_team_mem.is_del ='0'
        and gp_login_table.is_del ='0' and  gp_member_det.is_del ='0' and gp_team_mem.status='ACTIVE'   and gp_team_mem.created_by='$lgid' ".$where." group by gp_team_mem.id order by gp_team_mem.id desc  LIMIT $start, $limit";
        $qry = $this->db->query($qry);
    
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function tm_get_executives_refferd($search,$limit,$start,$lgid){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (gp_member_det.phone LIKE '%$keyword%' OR gp_member_det.email LIKE '%$keyword%' OR gp_desig.designation LIKE '%$keyword%' OR gp_desig.designation LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="select gp_team_mem.*,gp_member_det.name,gp_member_det.phone,gp_member_det.email,gp_member_det.address,gp_desig.designation
        from gp_pl_sales_team_members gp_team_mem
        join gp_pl_sales_team_member_details gp_member_det on gp_team_mem.id = gp_member_det.sales_team_member_id
        join gp_pl_sales_designation_type gp_desig on gp_team_mem.sales_desig_type_id = gp_desig.id
        join gp_login_table on gp_team_mem.id = gp_login_table.user_id where 
        gp_team_mem.is_del ='0'
        and gp_login_table.is_del ='0' and  gp_member_det.is_del ='0' and gp_team_mem.status='NOT_APPROVED'   and gp_team_mem.created_by='$lgid' ".$where." group by gp_team_mem.id order by gp_team_mem.id desc  LIMIT $start, $limit";
        $qry = $this->db->query($qry);
           //echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }



        function get_executives_id($id){
        $qry="select gp_team_mem.*,gp_member_det.name,gp_member_det.phone,gp_member_det.email,gp_member_det.address,gp_member_det.image,gp_desig.designation,gp_member_det.country,gp_member_det.state,gp_member_det.city from gp_pl_sales_team_members gp_team_mem join gp_pl_sales_team_member_details gp_member_det on gp_team_mem.id = gp_member_det.sales_team_member_id join gp_pl_sales_designation_type gp_desig on gp_team_mem.sales_desig_type_id = gp_desig.id join gp_login_table on gp_team_mem.id = gp_login_table.user_id where gp_team_mem.is_del ='0' and gp_login_table.is_del ='0' and gp_member_det.is_del ='0' and gp_team_mem.id='$id' group by gp_team_mem.id";
        $qry = $this->db->query($qry);
       //echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_executives_userid($id){
        $qry="SELECT gp_log . * ,gp_log.id u_id, gp_team_mem . * , gp_member_det.name, gp_member_det.phone, gp_member_det.email, gp_member_det.address, gp_desig.designation, gp_member_det.country, gp_member_det.state, gp_member_det.city
FROM  `gp_login_table` gp_log
JOIN gp_pl_sales_team_members gp_team_mem ON gp_log.user_id = gp_team_mem.id
JOIN gp_pl_sales_team_member_details gp_member_det ON gp_team_mem.id = gp_member_det.sales_team_member_id
JOIN gp_pl_sales_designation_type gp_desig ON gp_team_mem.sales_desig_type_id = gp_desig.id
JOIN gp_login_table ON gp_team_mem.id = gp_login_table.user_id
WHERE gp_team_mem.is_del =  '0'
AND gp_login_table.is_del =  '0'
AND gp_member_det.is_del =  '0'
AND gp_log.id =$id
GROUP BY gp_log.id";
        $qry = $this->db->query($qry);
       //echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
        return $data;
    }
    


    function delete_exectives($data)
    {
        $itemgrp = $data['itemgrps'];
        $info = array('is_del' => 1);
        $this->db->where_in('id', $itemgrp);
        $qry = $this->db->update('gp_pl_sales_team_members', $info);
        if($qry){
          $this->db->where_in('sales_team_member_id', $itemgrp);
        $qry1 = $this->db->update('gp_pl_sales_team_member_details', $info);  
        }
        return $qry;
    }

    function edit_profile($id)
    {
      
       $loginsession = $this->session->userdata('logged_in_exec');
       $userid=$loginsession['user_id'];
       $lgid=$loginsession['id'];
       $created_on = date("Y-m-d h:i:sa") ;
       $created_by=$lgid;
       $photo=date("YmHms");
       $photo1=$photo+1;
       if(!empty($_FILES['file']['name'])){
           $tmp1=explode(".",$_FILES['file']['name']);
           $extension1=end($tmp1);
           $image=$photo1.".".$extension1;
           if(($extension1=="jpg")||($extension1=="JPG")||($extension1=="png")||($extension1=="PNG")||($extension1=="JPEG")||($extension1=="jpeg")||($extension1=="gif")||($extension1=="GIF"))
            {

           move_uploaded_file($_FILES['file']['tmp_name'],"upload/exec_profile/".$image);

           } 
       }
       else{

        $image='default-avatar.png';
       }
      

       $data=array(

            'name'=>$this->input->post('name'),
            
            'phone'=>$this->input->post('c_number'),
            'email'=>$this->input->post('email'),
            'address'=>$this->input->post('address'),
            'image'=> $image,
        );

        $this->db->where('id', $id);
        $qry = $this->db->update('gp_pl_sales_team_member_details', $data);
        $this->db->trans_complete();
        if($this->db->trans_status()===false)
        {
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
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

/*
//clubmember
    function validate_password($password)
    {
        $qry_res = "SELECT tb.* from gp_login_table tb where tb.password = '$password'";
        $qry_res = $this->db->query($qry_res);
        //echo $this->db->last_query();exit;
        if($qry_res->num_rows()>0)
        {
            $data['status'] = FALSE;
        }else{
            $data['status'] = TRUE;
        }
        return $data;
    }
*/

    function validate_club_member($a3,$a4)
    {
        $data = array();
       $qry = "select * from gp_login_table where email = '$a3' and mobile='$a4' and type = 'club_member' ";

        $qry = $this->db->query($qry);
        
        if($qry->num_rows()>0)
        {
            $data['reason'] = "Already A Clubmember Exists with same Email id And Password";
            $data['status'] = FALSE;
        } else{
            $data['status'] =  TRUE;
        }
        return $data;
    }

    function validate_user($a3,$a4)
    {
       $data = array();
       $qry = "select * from gp_login_table where email = '$a3' and mobile='$a4' and type = 'normal_customer' ";
      
        $qry = $this->db->query($qry);
        
        if($qry->num_rows()>0)
        {
            $data['reason'] = $qry->row_array();

            $data['status'] =  TRUE;
        } else{
            $data['reason'] = "Not A Normal User";

            
            $data['status'] = FALSE;
        }
        return $data;
    }

    function validate_email($email)
    {
        $data = array();
       $qry = "select * from gp_login_table where email = '$email' and type = 'club_member' ";
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
        $qry2 = "select * from gp_login_table where mobile = '$phone' and type = 'club_member'";
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
       
        $qry1 = $this->db->query("SELECT m.last_promotion_date,s.id,s.promotion_designation FROM gp_pl_sales_team_members m left join gp_executive_promotion_settings s on m.sales_desig_type_id = s.designation_id where m.id = '$userid'");
            if($qry1->num_rows()>0)
            {
              $res1 =  $qry1->row();
              $last_promo_date = $res1->last_promotion_date;
              $promo_id = $res1->id;
              $next_designation = $res1->promotion_designation;
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
                                     
                                      $qry_count = $this->db->query("SELECT count(id) as club_count FROM gp_normal_customer nc WHERE nc.parent_id = '$lgid' and nc.register_via = 'executive' and nc.is_del = '0' and nc.status = 'approved' and (nc.created_on BETWEEN '$each_month' and '$cur_date')");
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
                                        //echo $this->db->last_query();exit();
                                }
                                else{
                                        for($i=1; $i<=$period; $i++){
                                         
                                            $qry_amount =$this->db->query("SELECT nc.club_type_id,sum(IFNULL(c_type.amount,0)+IFNULL(c_type2.amount,0)) as amount1 FROM gp_normal_customer nc
                                                left join club_member_type c_type on c_type.id=nc.fixed_club_type_id
                                                left join club_member_type c_type2 on c_type2.id=nc.club_type_id
                                                WHERE nc.parent_id = '$lgid' and nc.register_via = 'executive' and nc.is_del = '0' and nc.status = 'approved' and (nc.joined_on BETWEEN '$each_month' and '$cur_date')");
                                          
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
                                    //echo $this->db->last_query();exit();

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
    function upgrade_designation_team($userid,$lgid)
    {
           
        $qry1 = $this->db->query("SELECT m.last_promotion_date,s.id,s.promotion_designation ,s.sysmodule_id FROM gp_pl_sales_team_members m left join gp_executive_promotion_settings s on m.sales_desig_type_id = s.designation_id where m.id = '$userid'");
            if($qry1->num_rows()>0)
            {
              $res1 =  $qry1->row();
              $last_promo_date = $res1->last_promotion_date;
              $promo_id = $res1->id;
              $next_designation = $res1->promotion_designation;
              $sysmodule_id= $res1->sysmodule_id;
              $qry2 = $this->db->query("select * from gp_executive_promotion_details s where s.promo_id = '$promo_id' order by s.period ASC");
              if($qry2->num_rows()>0){
                 $res2 =  $qry2->result_array();
                    foreach ($res2 as $key => $value) {
                        $cur_date = date('Y-m-d');
                        $period = $value['period'];
                        $count = $value['count'];
                        $qry_month = $this->db->query("SELECT DATE_SUB(curdate(), INTERVAL +$period MONTH) as month");
                          if($qry_month->num_rows()>0){
                                $res3 = $qry_month->row();
                                $init_month = $res3->month;
                                $count1 = 0;
                                $x = strtotime($cur_date);
                                $each_month = date("Y-m-d",strtotime("-1 month",$x));
                                //var_dump($cur_date);var_dump($each_month);exit;
                                for($i=1; $i<=$period; $i++){
                                     
                                      $qry_count = $this->db->query("SELECT count(gm.id) ex_count FROM `gp_pl_sales_team_members` gm where gm.created_by=$lgid AND gm.sales_desig_type_id='$sysmodule_id' and gm.is_del = '0'and gm.status = 'ACTIVE' and (gm.created_on BETWEEN '$each_month' and '$cur_date')");
                                         // echo $this->db->last_query();exit();
                                        // var_dump($cur_date);var_dump($each_month);
                                        
                                         if($qry_count->num_rows()>0){
                                            $res4 = $qry_count->row();
                                            $c_count = $res4->ex_count;
                                           
                                            $int_count = (int)$c_count;
                                      
                                            
                                            if($int_count >= $count){
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
                                            'date' =>$cur_date
                                        );
                                        $qry1 = $this->db->insert('promotion_notification', $datas_ins);
                                       
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

    function club_registration($res)
    {
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $desig=$loginsession['desig'];
        $data = array();
        $this->db->trans_begin();
        $id = $res['id'];
        $user_id = $res['user_id'];
        $details = get_details_by_loginid($id);
        $datas2 = array(
        'customer_log_id' => $id,
        'parent_log_id' => $details['parent_login_id'],
        'current_parent_log_id' => $lgid
        );
        $qry = $this->db->insert('gp_be_clubmember', $datas2);
         
        $mode_payment = $this->input->post('mode');

        $club_plan = $this->input->post('club_plan');
        $det1 = getClubtypeById($club_plan);
        $type2 =$this->input->post('club_plan2');
        $det2 = isset($type2)?getClubtypeById($type2):'';
        $datas = array(
            'profile_image' =>'',
            'type'=>'club_member',
            'parent_id' => $lgid,
            'mode_payment'=>$mode_payment,
            'created_by'=>$lgid,
            
            'register_via' =>'executive',
            'status'=>'notapproved'
            
            );

/*      if(!empty($det1)&&$det1['type']=='UNLIMITED'){
            $datas['club_type_id'] = $club_plan;
            $datas['fixed_club_type_id']=$type2;
        }else{
            $datas['club_type_id'] = $type2;
            $datas['fixed_club_type_id']=$club_plan;
        }
        if(!empty($det2)&&$det2['type']=='UNLIMITED'){
            $datas['club_type_id'] = $type2;
            $datas['fixed_club_type_id']=$club_plan;
        }*/
            $datas['club_type_id'] = $club_plan;
            $datas['fixed_club_type_id']=$type2;
        if($type2){
            $datas['fixed_join_date']=date('Y-m-d h:i:s');
        }
        if($mode_payment=='cheque'){
            $datas['cheque_no']=$this->input->post('cheque');
            $datas['bank']=$this->input->post('bank');
            $datas['cheque_date']=date('Y-m-d',strtotime($this->input->post('cheque_date')));

        }

        $this->db->where('id', $user_id);
        $qry = $this->db->update('gp_normal_customer', $datas);

        $userLogin = array( 'type' => 'club_member','parent_login_id'=>$lgid ); 
        $this->db->where('id', $id);
        $qry_login = $this->db->update('gp_login_table', $userLogin);
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
        }
        if($type2>0){
            $wallete = array('wallet_type_id' => 5, 'user_id' => $id, 'total_value' =>'0');  
            $qry3 = $this->db->insert('gp_wallet_values', $wallete);
            $wal_id = $this->db->insert_id();


            $wal_activityss = array(
                'wallet_type_id' =>5,
                'wallet_val_id' => $wal_id,
                'user_id' => $id,
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
function get_clubmember_details($id)
{
 $qry= "SELECT gp_log.id u_id,gp_log.otp_status,gp_customer.id,gp_customer.name,gp_customer.phone,gp_customer.email,gp_customer.otp FROM `gp_login_table` gp_log 
        left join gp_normal_customer gp_customer on gp_customer.id=gp_log.user_id
        where gp_customer.id='$id'";
$qry = $this->db->query($qry);
       //echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
        return $data;
}

function get_club_member($id){
          $qry = "SELECT gp_customer.* ,gp_login.otp_status,IFNULL(type1.type,'')AS un,IFNULL(type2.type,'')AS fix  FROM gp_login_table gp_login
        left join `gp_normal_customer` gp_customer on gp_customer.id=gp_login.user_id 
        left join club_member_type type1 on type1.id=gp_customer.club_type_id
        left join club_member_type type2 on type2.id=gp_customer.fixed_club_type_id where gp_customer.created_by='$id' and gp_customer.is_del ='0' and gp_customer.status='notapproved'";

        $query=$this->db->query($qry);
        if($query){
            $data['member']=$query->result_array();
        }
        else{
            $data['member']=array();
        }
        return $data;

}
function get_club_member_all($search,$limit=NULL,$start=NULL,$id){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (type1.type LIKE '%$keyword%' OR type2.type  LIKE '%$keyword%' OR gp_customer.name LIKE '%$keyword%' OR gp_customer.email LIKE '%$keyword%' ) AND gp_customer.id IS NOT NULL ";
        }else{
            $where = '';
        }
           if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
          $qry = "SELECT gp_customer.* ,gp_login.otp_status,IFNULL(type1.type,'')AS un,IFNULL(type2.type,'')AS fix  FROM gp_login_table gp_login
        left join `gp_normal_customer` gp_customer on gp_customer.id=gp_login.user_id 
        left join club_member_type type1 on type1.id=gp_customer.club_type_id
        left join club_member_type type2 on type2.id=gp_customer.fixed_club_type_id where gp_customer.created_by='$id' and gp_customer.is_del ='0' and gp_customer.status='notapproved'".$where."".$pg;

        $query=$this->db->query($qry);
        if($query){
            $data['member']=$query->result_array();
        }
        else{
            $data['member']=array();
        }
        return $data;

}
function get_club_member_count($id,$search){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (type1.type LIKE '%$keyword%' OR type2.type  LIKE '%$keyword%' OR gp_customer.name LIKE '%$keyword%' OR gp_customer.email LIKE '%$keyword%' ) AND gp_customer.id IS NOT NULL ";
        }else{
            $where = '';
        }
          $qry = "SELECT gp_customer.* ,gp_login.otp_status,IFNULL(type1.type,'')AS un,IFNULL(type2.type,'')AS fix  FROM gp_login_table gp_login
        left join `gp_normal_customer` gp_customer on gp_customer.id=gp_login.user_id 
        left join club_member_type type1 on type1.id=gp_customer.club_type_id
        left join club_member_type type2 on type2.id=gp_customer.fixed_club_type_id where gp_customer.created_by='$id' and gp_customer.is_del ='0' and gp_customer.status='notapproved'".$where."";


        $query=$this->db->query($qry);
        if($query){
            return $query->num_rows();
        }
        else{
             return false;
        }
        return $data;

}




function get_active_club_member($id){
    $qry = "SELECT gp_customer.* ,gp_login.id m_id,gp_login.otp_status, IFNULL(type1.type,'')AS un,IFNULL(type2.type,'')AS fix  FROM gp_login_table gp_login
        left join `gp_normal_customer` gp_customer on gp_customer.id=gp_login.user_id 
        left join club_member_type type1 on type1.id=gp_customer.club_type_id
        left join club_member_type type2 on type2.id=gp_customer.fixed_club_type_id where gp_customer.created_by='$id'  and gp_customer.status='approved' and gp_login.type='club_member'";

        $query=$this->db->query($qry);
        if($query){
            $data['member']=$query->result_array();
        }
        else{
            $data['member']=array();
        }
        return $data;
}
function get_active_club_member_all($search,$limit=NULL,$start=NULL,$id){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (type1.type LIKE '%$keyword%' OR type2.type  LIKE '%$keyword%' OR gp_customer.name LIKE '%$keyword%' OR gp_customer.email LIKE '%$keyword%' ) AND gp_customer.id IS NOT NULL ";
        }else{
            $where = '';
        }
           if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
    $qry = "SELECT gp_customer.* ,gp_login.id m_id,gp_login.otp_status, IFNULL(type1.type,'')AS un,IFNULL(type2.type,'')AS fix FROM gp_login_table gp_login
        left join `gp_normal_customer` gp_customer on gp_customer.id=gp_login.user_id 
        left join club_member_type type1 on type1.id=gp_customer.club_type_id
        left join club_member_type type2 on type2.id=gp_customer.fixed_club_type_id where gp_customer.created_by='$id'  and gp_customer.status='approved' and gp_login.type='club_member'".$where."".$pg;

        $query=$this->db->query($qry);
        if($query){
            $data['member']=$query->result_array();
        }
        else{
            $data['member']=array();
        }
        return $data;
}
  function get_active_club_member_count($id,$search){

        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (type1.type LIKE '%$keyword%' OR type2.type  LIKE '%$keyword%' OR gp_customer.name LIKE '%$keyword%' OR gp_customer.email LIKE '%$keyword%' ) AND gp_customer.id IS NOT NULL ";
        }else{
            $where = '';
        }


        $qry="SELECT gp_customer.* ,gp_login.id m_id,gp_login.otp_status,IFNULL(type1.type,'')AS un,IFNULL(type2.type,'')AS fix FROM gp_login_table gp_login
        left join `gp_normal_customer` gp_customer on gp_customer.id=gp_login.user_id 
        left join club_member_type type1 on type1.id=gp_customer.club_type_id
        left join club_member_type type2 on type2.id=gp_customer.fixed_club_type_id where gp_customer.created_by='$id'  and gp_customer.status='approved' and gp_login.type='club_member' ".$where."";
        $qry=$this->db->query($qry);
     
        if($qry->num_rows()>0)
        {
            return $qry->num_rows();
        }else{
            return false;
        }
    }













function get_club_details_id($id){

    $qry = "SELECT clubmember.*, typee.type ty,type1.type ty1 FROM gp_normal_customer clubmember 
            join `gp_login_table` login on login.user_id=clubmember.id
            left join club_member_type typee on typee.id=clubmember.club_type_id
            left join club_member_type type1 on type1.id=clubmember.fixed_club_type_id
             where login.id='$id'";
      
        $query=$this->db->query($qry);
        if($query){
            $data=$query->row_array();
        }
        else{
            $data=array();
        }
        return $data;
}
function get_active_club_member_fixed($id){
    $qry = "SELECT gp_customer.*,gp_login.id m_id FROM gp_login_table gp_login left join `gp_normal_customer` gp_customer on gp_customer.id=gp_login.user_id where gp_customer.created_by='$id'  and gp_customer.status='approved' and gp_customer.club_type_id!= 0 ";

        $query=$this->db->query($qry);
        if($query){
            $data['member']=$query->result_array();
        }
        else{
            $data['member']=array();
        }
        return $data;

}
    function delete_club_member($datas)
    {
        $this->db->trans_begin();
       
        $ca_ids = $datas['itemgrps'];
     
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



    function get_member_byId($id2)
    {
         
       $qry="SELECT gp_normal_customer.*,DATE_FORMAT(gp_normal_customer.cheque_date, '%d-%m-%Y') as cheque,
       (SELECT club_member_type.type FROM club_member_type WHERE gp_normal_customer.club_type_id=club_member_type.id ) as ctype,(SELECT club_member_type.title FROM club_member_type WHERE gp_normal_customer.club_type_id=club_member_type.id )as type ,gp_login_table.id as log_id FROM `gp_normal_customer` 
        LEFT JOIN gp_login_table ON gp_normal_customer.id=gp_login_table.user_id
        WHERE gp_normal_customer.id='$id2'
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
      //  print_r($data);exit();
        //echo $id;exit();
        $this->db->trans_begin();
        $this->db->select('club_type_id')
                    ->from('gp_normal_customer')
                    ->where('id',$id);
        $type = $this->db->get()->row()->club_type_id;
        $club_plan=$data['club_type_id'];
        //echo $club_plan;
        $log_id = $this->input->post('log_id');
        if(isset($club_plan)&&($type!=$club_plan)){
            $qry_amount = $this->db->query("select id, amount from club_member_type where id = '$club_plan'");
            if($qry_amount->num_rows()>0)
            {
                $get_clubdetails = $qry_amount->row_array();
                $get_amount = $get_clubdetails['amount'];
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


   /* function delete_club_agent($data)
    {
        
        $ca_ids = $data['itemgrps'];

        foreach ($ca_ids as $key => $ca_id) {
          
            $results = array();
            $this->db->select('ca_docs')
                    ->from('gp_normal_customer')
                    ->where('id',$ca_id);

            $results['ca_docs'] = $this->db->get()->row()->ca_docs;


            $info = array('is_del' => 1);
            $this->db->where('id', $ca_id);
            $qry = $this->db->update('gp_normal_customer', $info);
            $infos = array('is_del' => 1);
            $this->db->where('user_id', $ca_id);
            $qrs = $this->db->update('gp_login_table', $infos);
        }
         return $qrs;
    }
*/

//channel partner

    function add_partner($otp,$qr_no,$creg,$license){
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];

       $email=$this->input->post('email');
       $created_on = date("Y-m-d h:i:sa") ;
       $created_by=$lgid;
       
       $module = $this->input->post('module');
         $name = $this->input->post('name');
       $string = str_replace(' ','',$name);
       $myStr = substr($string, 0, 3);  
       $qrcode = strtoupper($myStr).$qr_no;
      // var_dump($this->input->post('category'));var_dump($this->input->post('commission'));exit();
        $this->db->trans_begin();
        

            $data=array(
            'club_mem_id'=>$this->input->post('club_member'),
            'parent_id' =>$this->input->post('club_member'),
            'club_type' => $this->input->post('club_type'),
            'name'=>$this->input->post('name'),
            'phone'=>$this->input->post('phone'),
            
            'email'=>$this->input->post('email'),
            
            'owner_name'=>$this->input->post('ocname'),
            'owner_email'=>$this->input->post('oc_email'),
            'owner_mobile'=>$this->input->post('oc_mobile'),
            'country'=>$this->input->post('country'),
            'state'=>$this->input->post('state'),
            'town'=>$this->input->post('town'),
            
            
            
            'area'=>$this->input->post('area'),
            
            
            
            
            
            'pan'=>$this->input->post('pan'),
            'gst'=>$this->input->post('gst'),
            'company_registration'=>$creg,
            'license'=>$license,
            'created_on'=>$created_on,
            'created_by'=>$created_by,
            'lattitude'=>$this->input->post('latt'),
            'longitude'=>$this->input->post('long'),
            'module'=>$module,
            'otp'=>$otp,
            'qr_code' =>$qrcode,
            
           
        );
        $this->db->insert('gp_pl_channel_partner',$data);
        //echo $this->db->last_query();exit();
        $last_channelid=$this->db->insert_id();
        $channel_type=$this->input->post('channel_type');
        foreach($channel_type as $key => $type){
            $data=array(
                'channel_partner_type_id'=>$type,
                'channel_partner_id'=>$last_channelid,
                'module_id' => $module
            );
            $this->db->insert('gp_pl_channel_partner_type_connection',$data);
        }
        $logindata=array(
            'email'=>$this->input->post('email'),
            'mobile'=>$this->input->post('phone'),
            'otp_status' => 0,
            'user_id'=>$last_channelid,
            'parent_login_id'=>$this->input->post('club_member'),
            'type'=>"Channel_partner"
        );
        $user=$this->db->insert('gp_login_table',$logindata);
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
        $channelpsw['email'] = $this->input->post('email');
        $channelpsw['mobile'] = $this->input->post('phone');
        //$channelpsw['psw']= $password;

        $qry3 = $this->db->insert_batch('gp_wallet_values', $wallete);
        // $session_data=$this->session->userdata('logged_in_admin');
        // $typ = $session_data['type'];
        // if($typ = 'executive')
        // {
        //     $qry_a = $this->get_cp_promotion_count();
        // }
        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return $last_channelid;
        }
    }
    /*function add_refer_partner($otp,$qr_no){
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];

       $email=$this->input->post('email');
       $created_on = date("Y-m-d h:i:sa") ;
       $created_by=$lgid;
       $photo=date("YmHms");
       $photo1=$photo+1;
       $photo2=$photo+2;
       $tmp1=explode(".",$_FILES['pro']['name']);
       $tmp2=explode(".",$_FILES['bri']['name']);
       $extension1=end($tmp1);
       $extension2=end($tmp2);
       $p1=$photo1.".".$extension1;
       $p2=$photo2.".".$extension2;
       $image_file1 = "upload/".$p1;
       $image_file2 = "assets/admin/brand/".$p2;
       if(($extension1=="jpg")||($extension1=="JPG")||($extension1=="png")||($extension1=="PNG")||($extension1=="JPEG")||($extension1=="jpeg")||($extension1=="gif")||($extension1=="GIF"))
       {
           move_uploaded_file($_FILES['pro']['tmp_name'],"upload/".$p1);
       }
       
       if(($extension2=="jpg")||($extension2=="JPG")||($extension2=="png")||($extension2=="PNG")||($extension2=="JPEG")||($extension2=="jpeg")||($extension2=="gif")||($extension2=="GIF"))
       {
           move_uploaded_file($_FILES['bri']['tmp_name'],"assets/admin/brand/".$p2);
       }
       $module = $this->input->post('module');
      // var_dump($this->input->post('category'));var_dump($this->input->post('commission'));exit();
        $this->db->trans_begin();
        
        $id=$this->input->post('id');
        $module = $this->input->post('module');
        $name = $this->input->post('name');
       $string = str_replace(' ','',$name);
       $myStr = substr($string, 0, 3);  
       $qrcode = strtoupper($myStr).$qr_no;
           $data=array(
            'club_mem_id'=>$this->input->post('club_member'),
            'parent_id' =>$this->input->post('club_member'),
            'club_type' => $this->input->post('club_type'),
            'name'=>$this->input->post('name'),
            'phone'=>$this->input->post('phone'),
            'phone2'=>$this->input->post('phone2'),  
            'email'=>$this->input->post('email'),
            'cname'=>$this->input->post('cname'),
            'c_email'=>$this->input->post('c_email'),
            'c_mobile'=>$this->input->post('c_mobile'),
            'alt_c_name'=>$this->input->post('acname'),
            'alt_c_email'=>$this->input->post('ac_email'),
            'alt_c_mobile'=>$this->input->post('ac_mobile'),
            'owner_name'=>$this->input->post('ocname'),
            'owner_email'=>$this->input->post('oc_email'),
            'owner_mobile'=>$this->input->post('oc_mobile'),
            'country'=>$this->input->post('country'),
            'state'=>$this->input->post('state'),
            'town'=>$this->input->post('town'),
            'address'=>$this->input->post('address'),
            'bank_name'=>$this->input->post('bank_name'),
            'account_no'=>$this->input->post('ac_number'),
            'account_holder_name'=>$this->input->post('ac_holder_name'),
            'ifsc'=>$this->input->post('ifsc'),
            'is_reffered'=>1,
            'created_on'=>$created_on,
            'created_by'=>$created_by,
            'lattitude'=>$this->input->post('latt'),
            'longitude'=>$this->input->post('long'),
            'module'=>$module,
            'otp'=>$otp,
            'qr_code' =>$qrcode,
            'profile_image'=> $image_file1,
            'brand_image'=> $image_file2,
            'status'=>'NOT_APPROVED',

           
        );
          
            $this->db->where('id', $id);
            $qrs = $this->db->update('gp_pl_channel_partner', $data);     
//$this->db->insert('gp_pl_channel_partner',$data);
        //echo $this->db->last_query();exit();
        //$last_channelid=$this->db->insert_id();
        $channel_type=$this->input->post('channel_type');
        foreach($channel_type as $key => $type){
            $data=array(
                'channel_partner_type_id'=>$type,
                'channel_partner_id'=>$id,
                'module_id' => $module
            );
            $this->db->insert('gp_pl_channel_partner_type_connection',$data);
        }
        $logindata=array(
            'email'=>$this->input->post('email'),
            'mobile'=>$this->input->post('phone'),
            'otp_status' => 0,
            'user_id'=>$id,
            'parent_login_id'=>$this->input->post('club_member'),
            'type'=>"Channel_partner"
        );
        $user=$this->db->insert('gp_login_table',$logindata);
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
        $channelpsw['email'] = $this->input->post('email');
        $channelpsw['mobile'] = $this->input->post('phone');
        //$channelpsw['psw']= $password;

        $qry3 = $this->db->insert_batch('gp_wallet_values', $wallete);
        // $session_data=$this->session->userdata('logged_in_admin');
        // $typ = $session_data['type'];
        // if($typ = 'executive')
        // {
        //     $qry_a = $this->get_cp_promotion_count();
        // }
        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return $id;
        }
    }*/
    
    
    
    
    
    
    
    function add_refer_partner($otp,$qr_no,$creg,$license){
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];

       $email=$this->input->post('email');
       $created_on = date("Y-m-d h:i:sa") ;
       $created_by=$lgid;


      /* $photo=date("YmHms");
       $photo1=$photo+1;
       $photo2=$photo+2;
       $tmp1=explode(".",$_FILES['pro']['name']);
       $tmp2=explode(".",$_FILES['bri']['name']);
       $extension1=end($tmp1);
       $extension2=end($tmp2);
       $p1=$photo1.".".$extension1;
       $p2=$photo2.".".$extension2;
       $image_file1 = "upload/".$p1;
       $image_file2 = "assets/admin/brand/".$p2;
       if(($extension1=="jpg")||($extension1=="JPG")||($extension1=="png")||($extension1=="PNG")||($extension1=="JPEG")||($extension1=="jpeg")||($extension1=="gif")||($extension1=="GIF"))
       {
           move_uploaded_file($_FILES['pro']['tmp_name'],"upload/".$p1);
       }
       
       if(($extension2=="jpg")||($extension2=="JPG")||($extension2=="png")||($extension2=="PNG")||($extension2=="JPEG")||($extension2=="jpeg")||($extension2=="gif")||($extension2=="GIF"))
       {
           move_uploaded_file($_FILES['bri']['tmp_name'],"assets/admin/brand/".$p2);
       }*/
       $module = $this->input->post('module');
      // var_dump($this->input->post('category'));var_dump($this->input->post('commission'));exit();
        $this->db->trans_begin();
        
        $id=$this->input->post('id');
        $module = $this->input->post('module');
        $name = $this->input->post('name');
       $string = str_replace(' ','',$name);
       $myStr = substr($string, 0, 3);  
       $qrcode = strtoupper($myStr).$qr_no;
           $data=array(
            'club_mem_id'=>$this->input->post('club_member'),
            'parent_id' =>$this->input->post('club_member'),
            'club_type' => $this->input->post('club_type'),
            'name'=>$this->input->post('name'),
            'phone'=>$this->input->post('phone'),
            'phone2'=>$this->input->post('phone2'),  
            'email'=>$this->input->post('email'),



            /*'cname'=>$this->input->post('cname'),
            'c_email'=>$this->input->post('c_email'),
            'c_mobile'=>$this->input->post('c_mobile'),
            'alt_c_name'=>$this->input->post('acname'),
            'alt_c_email'=>$this->input->post('ac_email'),
            'alt_c_mobile'=>$this->input->post('ac_mobile'),*/


            'pan'=>$this->input->post('pan'),
            'gst'=>$this->input->post('gst'),
            'company_registration'=>$creg,
            'license'=>$license,




            'owner_name'=>$this->input->post('ocname'),
            'owner_email'=>$this->input->post('oc_email'),
            'owner_mobile'=>$this->input->post('oc_mobile'),
            'country'=>$this->input->post('country'),
            'state'=>$this->input->post('state'),
            'town'=>$this->input->post('town'),
            
            
            
            
            
            'area'=>$this->input->post('area'),
            
            
            
            
            
            


            /*'address'=>$this->input->post('address'),
            'bank_name'=>$this->input->post('bank_name'),
            'account_no'=>$this->input->post('ac_number'),
            'account_holder_name'=>$this->input->post('ac_holder_name'),
            'ifsc'=>$this->input->post('ifsc'),*/


            'is_reffered'=>1,
            'created_on'=>$created_on,
            'created_by'=>$created_by,
            'lattitude'=>$this->input->post('latt'),
            'longitude'=>$this->input->post('long'),
            'module'=>$module,
            'otp'=>$otp,
            'qr_code' =>$qrcode,


            /*'profile_image'=> $image_file1,
            'brand_image'=> $image_file2,*/


            'status'=>'NOT_APPROVED',

           
        );
          
            $this->db->where('id', $id);
            $qrs = $this->db->update('gp_pl_channel_partner', $data);     
//$this->db->insert('gp_pl_channel_partner',$data);
        //echo $this->db->last_query();exit();
        //$last_channelid=$this->db->insert_id();
        $channel_type=$this->input->post('channel_type');
        foreach($channel_type as $key => $type){
            $data=array(
                'channel_partner_type_id'=>$type,
                'channel_partner_id'=>$id,
                'module_id' => $module
            );
            $this->db->insert('gp_pl_channel_partner_type_connection',$data);
        }
        $logindata=array(
            'email'=>$this->input->post('email'),
            'mobile'=>$this->input->post('phone'),
            'otp_status' => 0,
            'user_id'=>$id,
            'parent_login_id'=>$this->input->post('club_member'),
            'type'=>"Channel_partner"
        );
        $user=$this->db->insert('gp_login_table',$logindata);
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
        $channelpsw['email'] = $this->input->post('email');
        $channelpsw['mobile'] = $this->input->post('phone');
        //$channelpsw['psw']= $password;

        $qry3 = $this->db->insert_batch('gp_wallet_values', $wallete);
        // $session_data=$this->session->userdata('logged_in_admin');
        // $typ = $session_data['type'];
        // if($typ = 'executive')
        // {
        //     $qry_a = $this->get_cp_promotion_count();
        // }
        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return $id;
        }
    }
    
    
    
    
    
    
    
    
    
    
    function get_channerpartner_byid($id){
        $qry="select chp.* from gp_pl_channel_partner chp
                where chp.is_del='0' and chp.id='$id'";
        $query=$this->db->query($qry);
        if($query){
            $data['partner']=$query->row_array();
              $qry2 ="select c.channel_partner_type_id from gp_pl_channel_partner_type_connection c 
               where c.channel_partner_id = '$id' and c.is_del='0'";
          $qry2=$this->db->query($qry2);
          if($qry2->num_rows()>0){
              $res = $qry2->rows_array();
              $array = array();
              foreach ($res as $key => $value) {
                  # code...
                  $id = $value['channel_partner_type_id'];
                  array_push($array, $id);
              }
              $data['grp_sel'] = $array;
          }
          else{
              $data['grp_sel']=array();
          }
       
        }
        else{
            $data['partner']=array();
        }
        return $data;
    }
    function get_channerpartner($id){
       
        $qry = "select
                cp.id as cp_id,
                cp.name, cp.phone,
                cp.phone2,
                cp.email,
                cp.fax,
                cp.address,
                GROUP_CONCAT(typ.title) as cp_type, 
                typ.description
                from
                gp_pl_channel_partner_type_connection con
                left join gp_pl_channel_partner cp on cp.id = con.channel_partner_id
                left join gp_pl_channel_partner_types typ on typ.id = con.channel_partner_type_id
                where cp.is_del='0' and cp.created_by='$id' and cp.status='NOT_APPROVED'
                group by cp.id ";

        $query=$this->db->query($qry);
        if($query){
            $data['partner']=$query->result_array();
        }
        else{
            $data['partner']=array();
        }
        return $data;
    }


    function get_active_channerpartner($id){
       
        $qry = "select
                cp.id as cp_id,
                cp.name, cp.phone,
                cp.phone2,
                cp.email,cp.status,
                cp.fax,
                cp.address,
                GROUP_CONCAT(typ.title) as cp_type, 
                typ.description
                from
                gp_pl_channel_partner_type_connection con
                left join gp_pl_channel_partner cp on cp.id = con.channel_partner_id
                left join gp_pl_channel_partner_types typ on typ.id = con.channel_partner_type_id
                left join gp_login_table gp_log on gp_log.id=cp.created_by
                where cp.is_del='0' and cp.created_by='$id' and (cp.status='APPROVED' or cp.status='JOINED')
                group by cp.id ";
        $query=$this->db->query($qry);
        if($query){
            $data['partner']=$query->result_array();
        }
        else{
            $data['partner']=array();
        }
        return $data;
    }
    function get_active_channerpartner_count($search,$id){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and ( cp.name LIKE '%$keyword%' OR cp.phone  LIKE '%$keyword%' OR cp.email LIKE '%$keyword%' OR cp.status LIKE '%$keyword%' OR cp.owner_name LIKE '%$keyword%' OR typ.owner_mobile LIKE '%$keyword%' OR cp.pan LIKE '%$keyword%', ) AND cp.id IS NOT NULL ";

        }else{
            $where = '';
        }
       
        $qry = "select
                cp.id as cp_id,
                cp.name, cp.phone,
                cp.email,cp.status,cp.owner_name,cp.owner_mobile,cp.pan,
                GROUP_CONCAT(typ.title) as cp_type
                from
                gp_pl_channel_partner_type_connection con
                left join gp_pl_channel_partner cp on cp.id = con.channel_partner_id
                left join gp_pl_channel_partner_types typ on typ.id = con.channel_partner_type_id
                left join gp_login_table gp_log on gp_log.id=cp.created_by
                where cp.is_del='0' and cp.created_by='$id' and (cp.status='APPROVED' or cp.status='JOINED')
                group by cp.id ".$where."";
        $query=$this->db->query($qry);
        if($query){
            return $query->num_rows();
        }
        else{
             return false;
        }
    }  
    function get_active_channerpartner_all($search,$limit=NULL,$start=NULL,$id){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and ( cp.name LIKE '%$keyword%' OR cp.phone  LIKE '%$keyword%' OR cp.email LIKE '%$keyword%' OR cp.status LIKE '%$keyword%' OR cp.owner_name LIKE '%$keyword%' OR typ.owner_mobile LIKE '%$keyword%' OR cp.pan LIKE '%$keyword%', ) AND cp.id IS NOT NULL ";
        }else{
            $where = '';
        }
           if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
       
        $qry = "select
                cp.id as cp_id,
                cp.name, cp.phone,
                cp.email,cp.status,cp.owner_name,cp.owner_mobile,cp.pan,
                GROUP_CONCAT(typ.title) as cp_type
                from
                gp_pl_channel_partner_type_connection con
                left join gp_pl_channel_partner cp on cp.id = con.channel_partner_id
                left join gp_pl_channel_partner_types typ on typ.id = con.channel_partner_type_id
                left join gp_login_table gp_log on gp_log.id=cp.created_by
                where cp.is_del='0' and cp.created_by='$id' and (cp.status='APPROVED' or cp.status='JOINED')
                group by cp.id ".$where."".$pg;
        $query=$this->db->query($qry);
        if($query){
            return $query->result_array();// return $query->num_rows();
        }
        else{
             return array();
        }
    } 



    function get_reffer_channerpartner($id){
       
       $qry = "select cp.id as cp_id, cp.name, cp.phone, cp.phone2, cp.email, cp.fax, cp.address,log.user_id,clubmember.name club_name ,cp.cname,cp.c_email,cp.phone,cp.c_mobile from gp_pl_channel_partner cp
            left join gp_login_table log on cp.club_mem_id = log.id
            left join gp_normal_customer clubmember on clubmember.id =log.user_id
            where cp.is_del='0' and cp.status='REFERED' and clubmember.created_by = $id ";
               
        $query=$this->db->query($qry);
        if($query){
            $data['partner']=$query->result_array();
        }
        else{
            $data['partner']=array();
        }
        return $data;
    }
    function get_reffer_channerpartner_count($search,$id){
        //echo $id;exit();
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and ( cp.name LIKE '%$keyword%' OR cp.phone  LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%' OR cp.email LIKE '%$keyword%' ) AND cp.id IS NOT NULL ";

        }else{
            $where = '';
        }

       
       $qry = "select cp.id as cp_id, cp.name, cp.phone, cp.phone2, cp.email, cp.fax, cp.address,log.user_id,clubmember.name club_name ,cp.cname,cp.c_email,cp.phone,cp.c_mobile from gp_pl_channel_partner cp
            left join gp_login_table log on cp.club_mem_id = log.id
            left join gp_normal_customer clubmember on clubmember.id =log.user_id
            where cp.is_del='0' and cp.status='REFERED' and clubmember.created_by = $id ".$where."";
               
        $query=$this->db->query($qry);
        if($query){
            return $query->num_rows();
        }
        else{
             return false;
        }
    }
        function get_reffer_channerpartner_all($search,$limit=NULL,$start=NULL,$id){
              //echo $id;
                if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and ( cp.name LIKE '%$keyword%' OR cp.phone  LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%' OR cp.email LIKE '%$keyword%' ) AND cp.id IS NOT NULL ";
        }else{
            $where = '';
        }
           if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
       
       $qry = "select cp.id as cp_id, cp.name, cp.phone, cp.phone2, cp.email, cp.fax,cp.pan,cp.owner_name, cp.address,log.user_id,clubmember.name club_name ,cp.cname,cp.c_email,cp.phone,cp.c_mobile from gp_pl_channel_partner cp
            left join gp_login_table log on cp.club_mem_id = log.id
            left join gp_normal_customer clubmember on clubmember.id =log.user_id
            where cp.is_del='0' and cp.status='REFERED' and clubmember.created_by = $id ".$where." order by cp.id desc ".$pg;

        $query=$this->db->query($qry);
        if($query){
            $data['partner']=$query->result_array();
        }
        else{
            $data['partner']=array();
        }
        return $data;
            }
    function get_member_type($id){
       
        $qry = "SELECT nc.club_type_id,nc.fixed_club_type_id,nc.investor_type_id,ty.type club,ty1.type fixed ,ty2.type investor FROM `gp_normal_customer` nc
            LEFT JOIN gp_login_table login on login.user_id=nc.id
            LEFT JOIN club_member_type ty on ty.id=nc.club_type_id
            LEFT JOIN club_member_type ty1 on ty1.id=nc.fixed_club_type_id
            LEFT JOIN club_member_type ty2 on ty2.id=nc.investor_type_id
            WHERE login.id=$id";
               
        $query=$this->db->query($qry);
        if($query){
            return $data=$query->row_array();
        }
        else{
            return $data=array();
        }
        return $data;
    }
   function edit_partnerbyid($image_file1,$image_file2)
   {

        $datas = getLoginDetails();
        if($datas){
            $userid=$datas['user_id'];
        }
        $updated_on = date("Y-m-d h:i:sa");
        $this->db->trans_begin();
        $hiddenid=$this->input->post('hiddenid');
        $module = $this->input->post('module');
        $data=array(
            'club_mem_id'=>$this->input->post('club_member'),
            'parent_id' =>$this->input->post('club_member'),
            'club_type' => $this->input->post('club_type'),
            'name'=>$this->input->post('name'),
            'phone'=>$this->input->post('phone'),
            'phone2'=>$this->input->post('phone2'),  
            'email'=>$this->input->post('email'),
            'cname'=>$this->input->post('cname'),
            'c_email'=>$this->input->post('c_email'),
            'c_mobile'=>$this->input->post('c_mobile'),
            'alt_c_name'=>$this->input->post('acname'),
            'alt_c_email'=>$this->input->post('ac_email'),
            'alt_c_mobile'=>$this->input->post('ac_mobile'),
            'owner_name'=>$this->input->post('ocname'),
            'owner_email'=>$this->input->post('oc_email'),
            'owner_mobile'=>$this->input->post('oc_mobile'),
            'country'=>$this->input->post('country'),
            'state'=>$this->input->post('state'),
            'town'=>$this->input->post('town'),
            
            
            
            'area'=>$this->input->post('area'),
            
            
            
            
            
            'address'=>$this->input->post('address'),
            'bank_name'=>$this->input->post('bank_name'),
            'account_no'=>$this->input->post('ac_number'),
            'account_holder_name'=>$this->input->post('ac_holder_name'),
            'ifsc'=>$this->input->post('ifsc'),
            'branch_name'=>$this->input->post('branch'),
            'updated_on'=>$updated_on,
            'updated_by'=>$userid,
            'status'=>'NOT_APPROVED',
            'lattitude'=>$this->input->post('latt'),
            'longitude'=>$this->input->post('long'),
            'module'=> $module, 
            'profile_image'=> $image_file1,
            'brand_image'=> $image_file2
        );
        $id = $this->input->post('hiddenid');
        $this->db->where('id',$id);
        $this->db->update('gp_pl_channel_partner',$data);

        $qrs3 = "select c.channel_partner_type_id from gp_pl_channel_partner_type_connection c where c.channel_partner_id = $id";
        $qrs3 = $this->db->query($qrs3);

        $channel = array();
        if($qrs3->num_rows()>0){
            $ppt = $qrs3->result_array();
            foreach ($ppt as $prt){
                array_push($channel,$prt['channel_partner_type_id']);
            }
        }
        $channel_type=$this->input->post('channel_type');
        foreach ($channel_type as $ch){
            if (in_array($ch, $channel))
            {

            }else{
                $ins = array(
                    'channel_partner_type_id'=>$ch,
                    'channel_partner_id'=>$id,
                    'module_id' => $module
                );
                $qrs2 = $this->db->insert('gp_pl_channel_partner_type_connection', $ins);

            }
           }
            foreach ($channel as $pr){
            if (in_array($pr, $channel_type))
            {
            }else{
                $qry32 = "delete from gp_pl_channel_partner_type_connection where channel_partner_id = $id and channel_partner_type_id = '$pr'";
                $qry32 = $this->db->query($qry32);
                $this->delete_product_by_cptype($pr,$id);
            }
            }


        $date = date("Y-m-d h:i:sa") ;
        $action = "updated parnter ";
        $status = 0;

        activity_log($action,$userid,$status,$date);

        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    

   } 




/* Club Agent */
    function add_club_agent($data)
    {
        $session_array = $this->session->userdata('logged_in_exec');
        $id = $session_array['user_id'];
        $log_id = $session_array['id'];

        $this->db->trans_begin();
        $otp = random_string('numeric', 5);
        $datas = array(
            'mem_id' => $data['mem_id'],
            'name' => $data['name'],
            'phone' => $data['mobile'],
            'email' => $data['email'],
            'otp' => $otp,
            'profile_image' =>'',
            'ca_docs'=>isset($data['file'])?$data['file']:'',
            'reg_otp_status' => 0,
            'register_via' => "executive",
            'type' => 'club_agent',
            'created_by'=>$log_id,
            'parent_id'=> $data['mem_id']


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
            'parent_login_id'=>$data['mem_id']
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
    function get_club_agent($lid){
        $qry="SELECT nc.* ,nc1.name club,lt1.user_id FROM gp_normal_customer nc 
        LEFT JOIN gp_login_table lt ON lt.user_id=nc.id
        LEFT JOIN gp_login_table lt1 ON lt1.id=nc.mem_id
        left join gp_normal_customer nc1 on nc1.id=lt1.user_id
        WHERE lt.type='club_agent' AND nc.is_del=0  AND nc.created_by='$lid' and lt.otp_status='0'";
        $query=$this->db->query($qry);
        if($query){
            $data['agent']=$query->result_array();
        }
        else{
            $data['agent']=array();
        }
        return $data;
    }
    function get_club_agent_count($search,$lid){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and ( cp.name LIKE '%$keyword%' OR cp.phone  LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%' OR cp.email LIKE '%$keyword%' ) AND cp.id IS NOT NULL ";

        }else{
            $where = '';
        }

        $qry="SELECT nc.* ,nc1.name club,lt1.user_id FROM gp_normal_customer nc 
        LEFT JOIN gp_login_table lt ON lt.user_id=nc.id
        LEFT JOIN gp_login_table lt1 ON lt1.id=nc.mem_id
        left join gp_normal_customer nc1 on nc1.id=lt1.user_id
        WHERE lt.type='club_agent' AND nc.is_del=0  AND nc.created_by='$lid' and lt.otp_status='0'".$where."";
        $query=$this->db->query($qry);
        if($query){
            return $query->num_rows();
        }
        else{
             return false;
        }
    }
        function get_club_agent_all($search,$limit=NULL,$start=NULL,$lid){
            if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and ( cp.name LIKE '%$keyword%' OR cp.phone  LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%' OR cp.email LIKE '%$keyword%' ) AND cp.id IS NOT NULL ";
        }else{
            $where = '';
        }
           if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $qry="SELECT nc.* ,nc1.name club,lt1.user_id FROM gp_normal_customer nc 
        LEFT JOIN gp_login_table lt ON lt.user_id=nc.id
        LEFT JOIN gp_login_table lt1 ON lt1.id=nc.mem_id
        left join gp_normal_customer nc1 on nc1.id=lt1.user_id
        WHERE lt.type='club_agent' AND nc.is_del=0  AND nc.created_by='$lid' and lt.otp_status='0'".$where."";
      $query=$this->db->query($qry);
        if($query){
            $data['partner']=$query->result_array();
        }
        else{
            $data['partner']=array();
        }
        return $data;
    }
    function get_active_club_agent($lid){
                 $qry="SELECT nc.* ,nc1.name club,lt1.user_id FROM gp_normal_customer nc 
        LEFT JOIN gp_login_table lt ON lt.user_id=nc.id
        LEFT JOIN gp_login_table lt1 ON lt1.id=nc.mem_id
        left join gp_normal_customer nc1 on nc1.id=lt1.user_id WHERE lt.type='club_agent' AND nc.is_del=0  AND nc.created_by='$lid' and lt.otp_status='1'";
        $query=$this->db->query($qry);
        if($query){
            $data['agent']=$query->result_array();
        }
        else{
            $data['agent']=array();
        }
        return $data;
    }

    function delete_club_agent($data)
    {
        
        $ca_ids = $data['itemgrps'];

        foreach ($ca_ids as $key => $ca_id) {
          
            $results = array();
            $this->db->select('ca_docs')
                    ->from('gp_normal_customer')
                    ->where('id',$ca_id);

            $results['ca_docs'] = $this->db->get()->row()->ca_docs;
/*            if(isset($results['ca_docs'])){
            unlink($results['ca_docs']);
            }*/

            $info = array('is_del' => 1);
            $this->db->where('id', $ca_id);
            $qry = $this->db->update('gp_normal_customer', $info);
            $infos = array('is_del' => 1);
            $this->db->where('user_id', $ca_id);
            $qrs = $this->db->update('gp_login_table', $infos);
        }
         return $qrs;
    }

    function get_club_agent_id($id)
    {
        $qry_res = "SELECT tb.*,nc.name,nc.mem_id,nc.club_type_id,nc.otp,nc.ca_docs from gp_login_table tb 
        left join gp_normal_customer nc on tb.user_id=nc.id 

        where nc.id = '$id' and tb.type = 'club_agent'";
        $qry_res = $this->db->query($qry_res);
        if($qry_res->num_rows()>0)
        {
            return $login_details = $qry_res->row_array();
        }else{
            return false;
        }
    }  


    function update_club_agent($data,$id)
    {
     
        $this->db->trans_begin();
        if(isset($data['ca_docs'])){
            $this->db->select('ca_docs')
                    ->from('gp_normal_customer')
                    ->where('id',$id);

            $ca_docs = $this->db->get()->row()->ca_docs;
            if($ca_docs!=''){unlink($ca_docs);}
        }

        $this->db->where('id', $id);
        $qry = $this->db->update('gp_normal_customer', $data);

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
    function close_notification($id)
    {
     $id=$this->input->post('id');
        $this->db->trans_begin();
            $data = array(
            'is_read' => '1',

        );

        $this->db->where('id', $id);
        $qry = $this->db->update('admin_notifications', $data);

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

/////promotion setting
        function get_exec_to_data(){

        $from = $this->input->post('from');
        $qry="select id,designation ,sort_order from gp_pl_sales_designation_type where id ='$from'";
        $qry = $this->db->query($qry);
        $result['res'] =  $qry->row_array();
        $sort=$result['res']['sort_order'];
        $so=$sort+1;

        $qry1="select id,designation ,sort_order from gp_pl_sales_designation_type where sort_order > '$sort' and is_del='0' order by sort_order asc limit 1 ";
        //echo $qry1;exit();
        $qry1 = $this->db->query($qry1);
        if($qry1->num_rows()>0){
            $data['res'] =  $qry1->result_array();
            //print_r($data['res']);exit();
        } else{
            $data['res'] =  array();
        }
        return $data;
    }

    function get_modules(){
        $qry="select * from gp_systemmodule";

        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
        return $data;
    }

   function get_desigsadd(){
    $qry="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id,gp_pl_sales_designation_type.sort_order FROM `gp_pl_sales_designation_type`  where gp_pl_sales_designation_type.is_del='0' and gp_pl_sales_designation_type.type='executive' and gp_pl_sales_designation_type.slug='team_leader'";
        $qry = $this->db->query($qry);
        $result['res'] =  $qry->row_array();
        $sort=$result['res']['sort_order'];
       // echo $qry;exit();
    $qry1="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id FROM `gp_pl_sales_designation_type`  where  id NOT IN(
            SELECT designation_id     FROM gp_executive_promotion_settings) and gp_pl_sales_designation_type.is_del='0' and gp_pl_sales_designation_type.type='executive' and gp_pl_sales_designation_type.id<= $sort";
        
        $qry1 = $this->db->query($qry1);
        if($qry1->num_rows()>0){
        
            return $qry1->result_array();
        } else{
            return array();
        }
       // return $data;
    }
    


    function get_promotion_view(){
      
        $from= $this->input->post('from');
        $to= $this->input->post('to');
        $qry="select pr.*,type.designation desg,type1.designation promo ,details.* from gp_executive_promotion_settings pr
        left join gp_pl_sales_designation_type type on type.id=pr.designation_id
        left join gp_pl_sales_designation_type type1 on type1.id=pr.promotion_designation
        left join gp_executive_promotion_details details on details.promo_id=pr.id
        where pr.designation_id=$from and pr.promotion_designation=$to ";
       
    
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        
    }

    function get_desigsview(){
        $qry="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id
        FROM `gp_pl_sales_designation_type` LEFT JOIN `gp_executive_promotion_settings`
        ON gp_pl_sales_designation_type.id = gp_executive_promotion_settings.designation_id
        WHERE gp_executive_promotion_settings.designation_id IS NOT NULL
        GROUP BY gp_pl_sales_designation_type.designation";
        //echo $qry;exit();
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function my_designation($id){
        $qry="select gp_mem.*,gp_type.designation,gp_type.sort_order  from gp_pl_sales_team_members gp_mem
        left join gp_pl_sales_designation_type gp_type on gp_type.id=gp_mem.sales_desig_type_id  where gp_mem.id=$id";
      
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
    }
        function exec_count($lgid,$userid){
        $qry="SELECT promo.sysmodule_id FROM `gp_pl_sales_team_members` exe
                left join gp_executive_promotion_settings promo on promo.designation_id=exe.sales_desig_type_id
                where exe.id=$userid ";
        $qry = $this->db->query($qry);
        $result['res'] =  $qry->row_array();
        $sysmodule_id=$result['res']['sysmodule_id'];
        

        if($sysmodule_id!=''){
        $qry1="SELECT count(exe.id) exec FROM `gp_pl_sales_team_members` exe
                left join gp_executive_promotion_settings promo on promo.designation_id=exe.sales_desig_type_id
                where exe.created_by=$lgid and exe.sales_desig_type_id=$sysmodule_id ";
      
        $qry1 = $this->db->query($qry1);
        if($qry1->num_rows()>0){
            return $qry1->row_array();
        } else{
            return array();
        }
    }
    }
/*    function my_designation($id){
        $qry="select gp_mem.*,gp_type.designation from gp_pl_sales_team_members gp_mem
        left join gp_pl_sales_designation_type gp_type on gp_type.id=gp_mem.sales_desig_type_id  where gp_mem.id=$id";
       
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
    }*/

    function my_count($id){

        $date=date('Y-m-d');
        $qry1 = $this->db->query("SELECT m.last_promotion_date,s.id,s.promotion_designation FROM gp_pl_sales_team_members m left join gp_executive_promotion_settings s on m.sales_desig_type_id = s.designation_id 
            left join gp_login_table login on login.user_id=m.id  where login.id = '$id'");
        //echo $this->db->last_query();exit();
            if($qry1->num_rows()>0)
            {
              $res1 =  $qry1->row();
              $last_promo_date = $res1->last_promotion_date;
            }

      $qry="SELECT count(gp_customer.id) c_id FROM gp_login_table gp_login left join `gp_normal_customer` gp_customer on gp_customer.id=gp_login.user_id where gp_customer.created_by='$id' and gp_customer.status='approved' and (gp_customer.created_on BETWEEN '$last_promo_date' AND '$date')";
      
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
    }
    function my_period($id){
   
    $qry="SELECT PERIOD_DIFF(DATE_FORMAT(DATE_ADD((CASE WHEN DAY(NOW()) >= DAY(created_on) THEN NOW() ELSE DATE_ADD(NOW(), INTERVAL -1 MONTH) END), INTERVAL -(FLOOR(PERIOD_DIFF(DATE_FORMAT(NOW(), '%Y%m'), DATE_FORMAT(last_promotion_date, '%Y%m')) / 12)) YEAR), '%Y%m'), DATE_FORMAT(last_promotion_date, '%Y%m')) as months_employed,DATEDIFF(NOW(), last_promotion_date) - DATEDIFF(DATE_ADD(CONVERT(CONCAT(DATE_FORMAT((CASE WHEN DAY(NOW()) >= DAY(last_promotion_date) THEN NOW() ELSE DATE_ADD(NOW(), INTERVAL -1 MONTH) END), '%Y-%m-'), RIGHT('0' + DAY(last_promotion_date), 2)), DATE), INTERVAL -1 DAY), last_promotion_date) as days_employed 
            FROM  gp_pl_sales_team_members  where id=$id ";
        
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
    }

    function my_wallet($id){
        $date=date('Y-m-d');
        $qry1 = $this->db->query("SELECT m.last_promotion_date,s.id,s.promotion_designation FROM gp_pl_sales_team_members m left join gp_executive_promotion_settings s on m.sales_desig_type_id = s.designation_id 
            left join gp_login_table login on login.user_id=m.id  where login.id = '$id'");
        //echo $this->db->last_query();exit();
            if($qry1->num_rows()>0)
            {
              $res1 =  $qry1->row();
              $last_promo_date = $res1->last_promotion_date;
            }
       $qry="SELECT SUM(wa.change_value) total FROM `gp_wallet_activity` wa WHERE wa.user_id = $id  and wa.clubmember_ship='1' and (date(wa.date_modified) BETWEEN '$last_promo_date' AND '$date')"; 
      
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
    }

    function my_status($id){
    $qry="SELECT PERIOD_DIFF(DATE_FORMAT(DATE_ADD((CASE WHEN DAY(NOW()) >= DAY(gp_pl_sales_team_members.last_promotion_date) THEN NOW() ELSE DATE_ADD(NOW(), INTERVAL -1 MONTH) END), INTERVAL -(FLOOR(PERIOD_DIFF(DATE_FORMAT(NOW(), '%Y%m'), DATE_FORMAT(gp_pl_sales_team_members.last_promotion_date, '%Y%m')) / 12)) YEAR), '%Y%m'), DATE_FORMAT(gp_pl_sales_team_members.last_promotion_date, '%Y%m')) as months_employed,DATEDIFF(NOW(), gp_pl_sales_team_members.last_promotion_date) - DATEDIFF(DATE_ADD(CONVERT(CONCAT(DATE_FORMAT((CASE WHEN DAY(NOW()) >= DAY(gp_pl_sales_team_members.last_promotion_date) THEN NOW() ELSE DATE_ADD(NOW(), INTERVAL -1 MONTH) END), '%Y-%m-'), RIGHT('0' + DAY(gp_pl_sales_team_members.last_promotion_date), 2)), DATE), INTERVAL -1 DAY),gp_pl_sales_team_members. last_promotion_date) as days_employed ,count(gp_customer.id) c_id ,wallet.total_value
            FROM  gp_pl_sales_team_members 
            left join gp_login_table login on login.user_id=gp_pl_sales_team_members.id
            left join gp_normal_customer gp_customer on gp_customer.created_by=login.id
            left join gp_wallet_values wallet on wallet.user_id=login.id
            where gp_pl_sales_team_members.id=3 and gp_customer.type='club_member' and wallet.wallet_type_id='$id'";
       
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
    }


/*       function get_exec_to(){

        $from = $this->input->post('from');

        $qry="select gs.id,gs.designation from gp_executive_promotion_settings gps inner join gp_pl_sales_designation_type gs
    on    gps.promotion_designation = gs.id   where gps.designation_id ='$from' and gs.is_del='0'";
    echo $qry;exit();
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            $data['res'] =  $qry->result_array();
        } else{
            $data['res'] =  array();
        }
        return $data;
    }
*/



//ba add
/**/

    function get_baview(){
        $qry="select ba.id ,c.id as country_id,c.name as county_name,
              s.id as state_id,s.name as state_name,ba.name,
              ba.mobil_no,ba.email,
              ba.company_name,
              ba.office_phno,
              ba.office_email,
              ba.city
              FROM pl_ba_registration ba
              left join  countries c ON c.id= ba.country
              left join  states s ON s.id=ba.state where is_del='0'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }

    function get_ba_view_byid($id)
    {

        $qry="select ba.club_mem_id as mem_id,ba.id ,ba.country,ba.state ,
              ba.name,
              ba.mobil_no,ba.email,
              ba.company_name,
              ba.office_phno,
              ba.office_email,
              ba.city
              FROM pl_ba_registration ba
             
              where is_del='0' and ba.id='$id'" ;

        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_ba_details($id)
    {

        $qry="select ba.id ,ba.country,ba.state ,
              ba.name,
              ba.mobil_no,ba.email,
              ba.company_name,
              ba.office_phno,
              ba.office_email,
              ba.otp,
              ba.city,login.*
              FROM pl_ba_registration ba
             left join gp_login_table login on login.user_id=ba.id
              where ba.is_del='0' and login.type='ba' and ba.id='$id'" ;

        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
        return $data;
    }
    function  edit_ba_by_id($countryName,$stateName,$cityName)
    {

        $session_array = $this->session->userdata('logged_in_exec');
        $id = $session_array['user_id'];
        $log_id = $session_array['id'];

        $hiddenid=$this->input->post('hiddenid');




        $created_on = date('Y-m-d H:i:s');

        $name=$this->input->post('ba_name');
        $mobile=$this->input->post('ba_mobile');
        $email=$this->input->post('ba_email');
        $company_name=$this->input->post('ba_company_Name');
        $office_phone=$this->input->post('office_phone');
        $office_emailid=$this->input->post('office_email_id');
   

        $data = array(
            'name' => $name,
            'mobil_no' =>$mobile,
            'email' =>$email,
            'company_name' =>$company_name,
            'office_phno' =>$office_phone,
            'office_email' =>$office_emailid,
            'city' =>$cityName,
            'country' =>$countryName,
            'state' =>$stateName,
            'created_on' => $created_on,
            'created_by' => $log_id,


        );
       
        $this->db->where('id',$hiddenid);
        $query=  $this->db->update('pl_ba_registration',$data);



           $date = date("Y-m-d h:i:sa") ;
            $action = "updated ba ";
            $loginsession = $this->session->userdata('logged_in_exec');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
        return $query;
    }


        function  edit_refer_ba_by_id($countryName,$stateName,$cityName)
    {
        $this->db->trans_begin();

        $session_array = $this->session->userdata('logged_in_exec');
        $id = $session_array['user_id'];
        $log_id = $session_array['id'];

        $hiddenid=$this->input->post('hiddenid');



        $club_member=$this->input->post('club_member');
        $created_on = date('Y-m-d H:i:s');
        $otp = random_string('numeric', 5);
        $name=$this->input->post('ba_name');
        $mobile=$this->input->post('ba_mobile');
        $email=$this->input->post('ba_email');
        $company_name=$this->input->post('ba_company_Name');
        $office_phone=$this->input->post('office_phone');
        $office_emailid=$this->input->post('office_email_id');
   

        $data = array(
            'club_mem_id' =>$club_member,
            'name' => $name,
            'mobil_no' =>$mobile,
            'email' =>$email,
            'company_name' =>$company_name,
            'office_phno' =>$office_phone,
            'office_email' =>$office_emailid,
            'city' =>$cityName,
            'country' =>$countryName,
            'state' =>$stateName,
            'created_on' => $created_on,
            'created_by' => $log_id,
            'status' =>'ACTIVE'


        );
       
        $this->db->where('id',$hiddenid);
        $query=  $this->db->update('pl_ba_registration',$data);

          
            $data3 = array(
            'email' => $email,
            'mobile' => $mobile,
            'user_id' =>$hiddenid,
            'type' => 'ba',
            'otp_status' => 0,
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

           $date = date("Y-m-d h:i:sa") ;
            $action = "updated ba ";
            $loginsession = $this->session->userdata('logged_in_exec');

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
            $info = array('user_id' => $hiddenid, 'otp' => $otp);
            $data['info'] = $info;
        }
        return $query;
    }


      function add_New_ba($countryName,$stateName,$cityName)
    {
        $this->db->trans_begin();
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $session_array = $this->session->userdata('logged_in_exec');
        $created_by = $session_array['id'];
        $created_on = date('Y-m-d H:i:s');
        
        $club_member=$this->input->post('club_member');
        $name=$this->input->post('ba_name');
        $mobile=$this->input->post('ba_mobile');
        $email=$this->input->post('ba_email');
        $company_name=$this->input->post('ba_company_Name');
        $office_phone=$this->input->post('office_phone');
        $office_emailid=$this->input->post('office_email_id');
        $city=$this->input->post('city');

        $country=$this->input->post('country');
        $otp = random_string('numeric', 5);
        $state=$this->input->post('state');
        $data = array(
            'club_mem_id' =>$club_member,
            'name' => $name,
            'mobil_no' =>$mobile,
            'email' =>$email,
            'company_name' =>$company_name,
            'office_phno' =>$office_phone,
            'office_email' =>$office_emailid,
            'city' =>$cityName,
            'country' =>$countryName,
            'state' =>$stateName,
            'otp' => $otp,
            'created_on' => $created_on,
            'created_by' => $lgid,
        );
        

        $this->db->insert('pl_ba_registration', $data);
        $insert_id = $this->db->insert_id();
            $data3 = array(
            'email' => $email,
            'mobile' => $mobile,
            'user_id' =>$insert_id,
            'type' => 'ba',
            'otp_status' => 0,
            // 'parent_login_id'=>$log_id
        );
        $qry3 = $this->db->insert('gp_login_table', $data3);
        $last_userid=$this->db->insert_id();
        $date = date('Y-m-d H:i:s');
        $financial_year = get_financial_year();
        $qry3 = $this->db->insert_batch('gp_wallet_values', $wallete);
                     $hr_ldg = array(
                                    'type_id' => $last_userid,
                                    '_type' => 'JAAZZO_STORE',
                                    'group_id' => 25,
                                    'name' => $last_userid ."_".$name.'_ledger'
                                );
            $acc_qry = $this->db->insert('erp_ac_ledgers', $hr_ldg);
            $leg_id=$this->db->insert_id();


                         $opening = array(
                                    'ledger_id' => $leg_id,
                                    'fy_id' => $financial_year,
                                    'opening_date' =>$date
                                    );
            $open_qry = $this->db->insert('erp_ac_opening_balance', $opening);



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
            $loginsession = $this->session->userdata('logged_in_exec');

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
            $info = array('user_id' => $insert_id, 'otp' => $otp);
            $data['info'] = $info;
        }
 return $data;
    }

    function delete_ba($data)
    {
        $itemgrp = $data['itemgrps'];
        $info = array('is_del' => 1);
        $this->db->where_in('id', $itemgrp);
        $qry = $this->db->update('pl_ba_registration', $info);
        return $qry;
    }

    function get_exec_baview()
    {
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
             $qry="select ba.id ,
              ba.name,ba.state,ba.country,
              ba.mobil_no,ba.email,
              ba.company_name,
              ba.office_phno,
              ba.office_email,
              ba.city
              FROM pl_ba_registration ba
              left join gp_login_table gp on gp.id=ba.club_mem_id
              left join gp_normal_customer nc on nc.id=gp.user_id
              where ba.is_del='0' and nc.created_by=$lgid and ba.status='ACTIVE'  ";

        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }

    function get_reffer_baview()
    {
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $qry="select ba.id ,
              ba.name,ba.state,ba.country,
              ba.mobil_no,ba.email,
              ba.company_name,
              ba.office_phno,
              ba.office_email,
              ba.city
              FROM pl_ba_registration ba
              where ba.is_del='0' and ba.created_by=$lgid and ba.status='PENDING' ORDER BY ba.id DESC";
             /*$qry="select ba.id ,
              ba.name,ba.state,ba.country,
              ba.mobil_no,ba.email,
              ba.company_name,
              ba.office_phno,
              ba.office_email,
              ba.city
              FROM pl_ba_registration ba
              left join gp_login_table gp on gp.id=ba.club_mem_id
              left join gp_normal_customer nc on nc.id=gp.user_id
              where ba.is_del='0' and nc.created_by=$lgid and ba.status='PENDING' ";*/

        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
//notification
    function get_mywallet_details()
    {

        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
            $qry="select wa.*,DATE_FORMAT( wa.date_modified, '%d-%m-%Y')
              as date_modified 
              FROM gp_wallet_activity wa
              where  wa.user_id=$lgid";
             
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }

    function active_notification_club(){

        $date = date('Y-m-d');
      
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $qry="select customer.*
              FROM gp_normal_customer customer
              where customer.created_by=$lgid and customer.status='APPROVED' and date(customer.created_on)='$date' group by customer.id
              ";
        // echo $qry;exit();
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function active_notification_channel(){
        $date = date('Y-m-d');
      
        $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $qry="select cp.*
              FROM gp_pl_channel_partner cp
              where cp.created_by=$lgid and cp.status='JOINED' and date(cp.created_on)='$date' group by cp.id";
        //echo  $qry;exit();   
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }

    function admin_notification(){
      $date = date('Y-m-d');
      $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $qry="SELECT * FROM `admin_notifications` where login_id='$lgid' and is_read='0'";
        //echo  $qry;exit();   
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }

    function reward_notification(){
      $date = date('Y-m-d');
      $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $qry="select wallet.*
              FROM gp_wallet_activity wallet
              where wallet.user_id=$lgid and date(wallet.date_modified)=$date ";
        //echo  $qry;exit();   
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }

    function get_exec_transaction(){
      $date = date('Y-m-d');
      $loginsession = $this->session->userdata('logged_in_exec');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $qry="select trans.*,DATE_FORMAT(trans.transaction_date, '%d-%m-%Y') as trans
              FROM gp_cp_transaction trans
              where trans._to=$lgid ";
        //echo  $qry;exit();   
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }

    function delete_partnerbyid($datas){

        $data=array(
            'is_del'=>"1",

        );
       
       $this->db->trans_begin();
        $ca_ids = $datas['chck_item_id'];
        foreach ($ca_ids as $key => $ca_id) {
           
            $this->db->where('id', $ca_id);
            $qry = $this->db->update('gp_pl_channel_partner',$data);
            $this->db->where('channel_partner_id', $ca_id);
            $qry = $this->db->update('gp_pl_channel_partner_type_connection',$data);
            
        }
        $date = date("Y-m-d h:i:sa") ;
        $action = "deleted channel partner ";
        $loginsession = $this->session->userdata('logged_in_admin');

        $userid=$loginsession['user_id'];
        $status = 0;

        activity_log($action,$userid,$status,$date);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }


    function get_refer_cp($id){
        $qry="SELECT cp.*,cus.name clubname from gp_pl_channel_partner cp
        left join gp_login_table login on login.id = cp.club_mem_id
        left join gp_normal_customer cus on login.user_id = cus.id
        where cp.id=$id ";
        $qry=$this->db->query($qry);
     
        if($qry){
            
            $data=$qry->row_array();
        }
        else{
            
            $data=array();
        }
        
        return $data;
    }






 














    function get_modulesid($id){
        $qry="select * from gp_systemmodule where id=$id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }

    function get_protion_settings_id($id)
    {
        $qry="SELECT  DISTINCT(promotion_designation)  from gp_executive_promotion_settings where designation_id='$id'";

        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            $promotion_desigf_id=$result->row_array();
           
            $id=$promotion_desigf_id['promotion_designation'];
            $query="SELECT designation  FROM `gp_pl_sales_designation_type` WHERE id='$id'";
            $results=$this->db->query($query);
            if($results->num_rows()>0)
            {
                return $results->row_array();
            }
            else
            {
                return array();
            }
        }

    }

    function exec_setdelete($did){
        $qry = "DELETE FROM gp_executive_promotion_settings WHERE designation_id = $did" ;
        $qry = $this->db->query($qry);
        // return $data;
    }
    function get_exec_to(){

        $from = $this->input->post('from');

        $qry="select gs.id,gs.designation from gp_executive_promotion_settings gps inner join gp_pl_sales_designation_type gs
    on    gps.promotion_designation = gs.id   where gps.designation_id ='$from' and gs.is_del='0'";
    //echo $qry;exit();
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            $data['res'] =  $qry->result_array();
        } else{
            $data['res'] =  array();
        }
        return $data;
    }

    function get_exec_data(){
        $to = $this->input->post('to');
        $from = $this->input->post('from');
        $mod = $this->input->post('mod');
        $qry="select * from gp_executive_promotion_settings where designation_id ='$from' and sysmodule_id = '$mod' and
        promotion_designation = '$to'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            $data['res'] =  $qry->result_array();
        } else{
            $data['res'] =  array();
        }
        return $data;
    }


    function update_setexec($data,$id)
    {
        $qry = $this->db->where('id', $id);
        $qry = $this->db->update('gp_executive_promotion_settings', $data);
       // echo $this->db->last_query();exit;
        return $qry;
    }
    function insert_execclub1($data1,$a1)
    {
        $qry = $this->db->where('id', $a1);
        $qry = $this->db->update('gp_normal_customer', $data1);
        return $qry;
    }
    function insert_execclub2($data2)
    {
        $qry = $this->db->insert('gp_normal_customer', $data2);
        return $qry;
    }

    function get_users(){
        $qry="select * from gp_normal_customer where club_type_id = '0' ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_clubtypes(){
        $qry="select * from club_member_type where is_del = '0' ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_clubs(){
        $qry="select gp_normal_customer.*,club_member_type.title from gp_normal_customer
        join club_member_type on gp_normal_customer.club_type_id = club_member_type.id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function add_new_product($image_file){
        $this->db->trans_begin();
        $data=array(
            'category_id'=>$this->input->post('pro_category'),
            'name'=>$this->input->post('pro_name'),
            'quantity'=>$this->input->post('pro_quantity'),
            'description'=>$this->input->post('pro_description'),
            'model'=>$this->input->post('pro_model'),
            'actual_cost'=>$this->input->post('pro_actualcost'),
            'image'=>$image_file,
            'cost'=>$this->input->post('pro_cost'),
        );
        $this->db->insert('gp_product_details',$data);
          $action = "added new product";
            $date = date("Y-m-d h:i:sa") ;
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
    function get_all_product(){
        $qry="select p.*,pc.title from gp_product_details p
              left join gp_product_category pc on pc.id=p.category_id
              where p.is_del='0'";
        $qry=$this->db->query($qry);
        if($qry){
            $data['produ']=$qry->result_array();
        }
        else{
            $data['produ']=array();
        }
        return $data;
    }
    function get_product_byid($id){
        $qry="select p.*,pc.title from gp_product_details p
              left join gp_product_category pc on pc.id=p.category_id
              where p.id='$id'";
        $qry=$this->db->query($qry);
        if($qry){
            $data['produ']=$qry->row_array();
        }
        else{
            $data['produ']=array();
        }
        return $data;
    }
    function edit_product_byid($image_file,$id){
        $this->db->trans_begin();
        $data=array(
            'category_id'=>$this->input->post('pro_category'),
            'name'=>$this->input->post('pro_name'),
            'quantity'=>$this->input->post('pro_quantity'),
            'description'=>$this->input->post('pro_description'),
            'model'=>$this->input->post('pro_model'),
            'actual_cost'=>$this->input->post('pro_actualcost'),
            'image'=>$image_file,
            'cost'=>$this->input->post('pro_cost'),
        );
        $this->db->where('id',$id);
        $this->db->update('gp_product_details',$data);
         $action = "updated new product";
            $date = date("Y-m-d h:i:sa") ;
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);


        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
    //Arya ba  module start


   /* function get_states()
    {
        $qry = "select
                s.*
                from
                states s";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
    function get_cities()
    {
        $qry = "select
                c.*
                from
                cities c";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
    function get_state_by_country($id)
    {
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
*/
    function random_password( $length = 8 ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
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


    function delete_ba_by_id($id){

        $data=array(
            'is_del'=>"1",

        );

        $qry = $this->db->where('id', $id);
        $qry = $this->db->update('pl_ba_registration', $data);

             $date = date("Y-m-d h:i:sa") ;
            $action = "deleted ba ";
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
        return $qry;

    }
    function delete_executive($id){

        $data=array(
            'is_del'=>"1",

        );

        $qry = $this->db->where('id', $id);
        $qry = $this->db->update('gp_pl_sales_team_members', $data);
        $qry1 = $this->db->where('sales_team_member_id', $id);
        $qry1 = $this->db->update('gp_pl_sales_team_member_details', $data);
        $qry2 = $this->db->where('user_id', $id);
        $qry2 = $this->db->update('gp_login_table', $data);

        $date = date("Y-m-d h:i:sa") ;
        $action = "deleted ba ";
        $loginsession = $this->session->userdata('logged_in_admin');

        $userid=$loginsession['user_id'];
        $status = 0;

        activity_log($action,$userid,$status,$date);
        return $qry;

    }
    function get_pending_cp_count($search,$lgid){
        if(!empty($search)){
            $keyword = $search;
            $where = "and ( cp.name LIKE '%$keyword%' OR cp.phone  LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%' OR cp.email LIKE '%$keyword%' OR cp.status LIKE '%$keyword%' OR cp.address LIKE '%$keyword%' OR typ.description LIKE '%$keyword%', ) AND cp.id IS NOT NULL ";

        }else{
            $where = '';
        }
       
        $qry = "select
                cp.id as cp_id,
                cp.name, cp.phone,
                cp.phone2,
                cp.email,cp.status,
                cp.fax,
                cp.address,
                GROUP_CONCAT(typ.title) as cp_type, 
                typ.description
                from
                gp_pl_channel_partner_type_connection con
                left join gp_pl_channel_partner cp on cp.id = con.channel_partner_id
                left join gp_pl_channel_partner_types typ on typ.id = con.channel_partner_type_id
                left join gp_login_table gp_log on gp_log.id=cp.created_by
                where cp.is_del='0' and cp.created_by='$lgid' and (cp.status='NOT_APPROVED')
                group by cp.id ".$where." ORDER BY cp.id DESC";
        $query=$this->db->query($qry);
        if($query){
            return $query->num_rows();
        }
        else{
             return false;
        }
    }
    function get_pending_cp_all($search,$limit,$start,$lgid){
        if(!empty($search)){
            $keyword = $search;
            $where = "and ( cp.name LIKE '%$keyword%' OR cp.phone  LIKE '%$keyword%' OR cp.email LIKE '%$keyword%' OR cp.owner_name  LIKE '%$keyword%' OR cp.owner_mobile  LIKE '%$keyword%' OR cp.pan  LIKE '%$keyword%' ) AND cp.id IS NOT NULL ";

        }else{
            $where = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $qry = "select
                cp.id as cp_id,
                cp.name, cp.phone,
                cp.email,cp.status,cp.owner_name,cp.owner_mobile,cp.pan,
                GROUP_CONCAT(typ.title) as cp_type
                from
                gp_pl_channel_partner_type_connection con
                left join gp_pl_channel_partner cp on cp.id = con.channel_partner_id
                left join gp_pl_channel_partner_types typ on typ.id = con.channel_partner_type_id
                left join gp_login_table gp_log on gp_log.id=cp.created_by
                where cp.is_del='0' and cp.created_by='$lgid' and (cp.status='NOT_APPROVED')
                group by cp.id ".$where." ORDER BY cp.id DESC ".$pg;
        $query=$this->db->query($qry);
        if($query){
            return $query->result_array();
        }
        else{
            return array();
        }
    }
    function get_active_ca_count($search,$lgid){

        if(!empty($search)){
            $keyword = $search;
            $where = "and ( nc.name LIKE '%$keyword%' OR nc.phone  LIKE '%$keyword%' OR  nc.email LIKE '%$keyword%' OR cp.status LIKE '%$keyword% OR nc1.name club LIKE '%$keyword%'')";

        }else{
            $where = '';
        }
       
        $qry="SELECT nc.* ,nc1.name club,lt1.user_id FROM gp_normal_customer nc 
        LEFT JOIN gp_login_table lt ON lt.user_id=nc.id
        LEFT JOIN gp_login_table lt1 ON lt1.id=nc.mem_id
        left join gp_normal_customer nc1 on nc1.id=lt1.user_id WHERE lt.type='club_agent' AND nc.is_del=0  AND nc.created_by='$lgid' and lt.otp_status='1'  and nc.status='approved'".$where." ORDER BY nc.id DESC";
        $query=$this->db->query($qry);
        if($query){
           return $query->num_rows();
        }
        else{
            return false;
        }
    }
    function get_all_active_ca($search,$limit,$start,$lgid){
        if(!empty($search)){
            $keyword = $search; 
            $where = "and ( nc.name LIKE '%$keyword%' OR nc.phone  LIKE '%$keyword%' OR  nc.email LIKE '%$keyword%' OR cp.status LIKE '%$keyword% OR nc1.name club LIKE '%$keyword%'')";
        }else{
            $where = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $qry = "SELECT nc.* ,nc1.name club,lt1.user_id FROM gp_normal_customer nc 
        LEFT JOIN gp_login_table lt ON lt.user_id=nc.id
        LEFT JOIN gp_login_table lt1 ON lt1.id=nc.mem_id
        left join gp_normal_customer nc1 on nc1.id=lt1.user_id WHERE lt.type='club_agent' AND nc.is_del=0  AND nc.created_by='$lgid' and lt.otp_status='1' and nc.status='approved' ".$where." ORDER BY nc.id DESC ".$pg;
        $query=$this->db->query($qry);
        if($query){
            return $query->result_array();
        }
        else{
            return array();
        }
    }
    function check_cp_limit_exceed($id){
        $qry="SELECT t.type,t.id as login_id,n.id as user_id,n.club_type_id,n.fixed_club_type_id,n.investor_type_id,t.type,t.email FROM gp_login_table t left join gp_normal_customer n on t.user_id = n.id WHERE t.id = '$id' and t.type not in ('super_admin','channel_partner','executive') and t.is_del = '0' and n.status = 'approved'";
        $result=$this->db->query($qry); 
        if($result->num_rows()>0)
        {
            $datas =  $result->row_array();
            if($datas){
                $lid = $datas['login_id'];
                $userid = $datas['user_id'];
                $udetail = get_details_by_userid($userid);
                $dateString=$udetail['created_on'];
                $fixed_joind=$udetail['fixed_join_date'];
                $years = round((time()-strtotime($dateString))/(3600*24*365));
                $fix_years = round((time()-strtotime($fixed_joind))/(3600*24*365));
                $fix_year_exceed = date('Y-m-d H:i:s',strtotime('+1 year',strtotime($fixed_joind)));

                $investor = isset($datas['investor_type_id'])?$datas['investor_type_id']:0;
                $club_type_id = $datas['club_type_id'];
                $fixed_plan = $udetail['fixed_club_type_id'];
                $fixed_details = getClubtypeById($fixed_plan);
                $fixed_amnt = $fixed_details['amount'];
                $reward_per_refer_cp = $fixed_details['ref_reward_per_cp'];
                $reward_per_cp = $fixed_details['reward_per_cp'];

                $fixed_wallet_used = get_wallet_used_by_member($lid,5);
                $fixed_wallet_details = get_fixed_wallet_details($lid);

                $expected_total1 = $fixed_wallet_details +$reward_per_refer_cp + $fixed_wallet_used;
                $expected_total2 = $fixed_wallet_details +$reward_per_cp + $fixed_wallet_used;
                $exp1 = $fixed_wallet_details+$fixed_wallet_used;
                $allow1 = '';
                if($exp1<$fixed_amnt){
                  $allow1 = 1 ;
                }
                $det = get_cmfacility_by_id($lid);
                $year_limit =  $det['year_limit'];
                if($datas['fixed_club_type_id']>0){
                    $fixed_year_limit =  $det['fixed_year_limit'];
                }else{
                    $fixed_year_limit =0;
                }
                if((($year_limit>=$years)&&($club_type_id>0)) || ((date('Y-m-d H:i:s')<=$fix_year_exceed)&& (($expected_total2<=$fixed_amnt)|| ($allow1==1)))){
                    $data['status'] = true;
                    $data['msg'] = 'Success';
                    return $data;
                }else{
                    $data['status'] = false;
                    $data['msg'] = 'Sorry!!...Channel Partner Limit Crossed';
                    return $data;
                }
            }else {
                $data['status'] = false;
                $data['msg'] = 'Sorry!!...Club member not found';
                return $data;
            }
        }
    }
    function check_cp_limit_status($id,$type){
        $qry="SELECT t.type,t.id as login_id,n.id as user_id,n.club_type_id,n.fixed_club_type_id,n.investor_type_id,t.type,t.email FROM gp_login_table t left join gp_normal_customer n on t.user_id = n.id WHERE t.id = '$id' and t.type not in ('super_admin','channel_partner','executive') and t.is_del = '0' and n.status = 'approved'";
        $result=$this->db->query($qry); 
        if($result->num_rows()>0)
        {
            $datas =  $result->row_array();
            if($datas){
                $lid = $datas['login_id'];
                $userid = $datas['user_id'];
                $udetail = get_details_by_userid($userid);
                $dateString=$udetail['created_on'];
                $fixed_joind=$udetail['fixed_join_date'];
                $det = get_cmfacility_by_id($lid);
                if($type=='FIXED'){
                    $fix_years = round((time()-strtotime($fixed_joind))/(3600*24*365));
                    $fix_year_exceed = date('Y-m-d H:i:s',strtotime('+1 year',strtotime($fixed_joind)));
                    $fixed_plan = $udetail['fixed_club_type_id'];
                    $fixed_details = getClubtypeById($fixed_plan);
                    $fixed_amnt = $fixed_details['amount'];
                    $reward_per_refer_cp = $fixed_details['ref_reward_per_cp'];
                    $reward_per_cp = $fixed_details['reward_per_cp'];

                    $fixed_wallet_used = get_wallet_used_by_member($lid,5);
                    $fixed_wallet_details = get_fixed_wallet_details($lid);

                    $expected_total1 = $fixed_wallet_details +$reward_per_refer_cp + $fixed_wallet_used;
                    $expected_total2 = $fixed_wallet_details +$reward_per_cp + $fixed_wallet_used;
                    $exp1 = $fixed_wallet_details+$fixed_wallet_used;
                    $allow1 = '';
                    if($exp1<$fixed_amnt){
                      $allow1 = 1 ;
                    }
                    if($datas['fixed_club_type_id']>0){
                        $fixed_year_limit =  $det['fixed_year_limit'];
                    }else{
                        $fixed_year_limit =0;
                    }
                    if((date('Y-m-d H:i:s')<=$fix_year_exceed)&& (($expected_total2<=$fixed_amnt)|| ($allow1==1))){
                        $data['status'] = true;
                        $data['msg'] = 'Success';
                        return $data;
                    }else{
                        $data['status'] = false;
                        $data['msg'] = 'Sorry!!...Channel Partner Limit Crossed';
                        return $data;
                    }
                }else{
                    $years = round((time()-strtotime($dateString))/(3600*24*365));
                    $club_type_id = $datas['club_type_id'];

                    $year_limit =  $det['year_limit'];
                    if(($year_limit>=$years)&&($club_type_id>0)){
                        $data['status'] = true;
                        $data['msg'] = 'Success';
                        return $data;
                    }else{
                        $data['status'] = false;
                        $data['msg'] = 'Sorry!!...Channel Partner Limit Crossed';
                        return $data;
                    }
                }
            }else {
                $data['status'] = false;
                $data['msg'] = 'Sorry!!...Club member not found';
                return $data;
            }
        }
    }
}
?>
