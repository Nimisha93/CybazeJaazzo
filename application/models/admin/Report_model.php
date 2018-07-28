<?php

Class Report_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_all_desigination_count($search)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (designation LIKE '%$keyword%' OR description LIKE '%$keyword%' OR gp_privillage_groupname.group LIKE '%$keyword%' OR sort_order LIKE '%$keyword%' OR DATE_FORMAT(gp_pl_sales_designation_type.created_on,'%d-%b-%Y') LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $query="SELECT gp_pl_sales_designation_type.id, designation,description,gp_privillage_groupname.group as groupname,sort_order,DATE_FORMAT(gp_pl_sales_designation_type.created_on,'%d-%m-%y') as date_time   FROM  gp_pl_sales_designation_type LEFT JOIN gp_privillage_groupname ON  gp_pl_sales_designation_type.group_id=gp_privillage_groupname.id  where gp_pl_sales_designation_type.type='executive' and gp_pl_sales_designation_type.is_del='0'".$where;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }
        else
        {
            return false;
        }
    }
    function  get_desigination_reports($search,$limit=NULL,$start=NULL)
    {        
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and(designation LIKE '%$keyword%' OR description LIKE '%$keyword%' OR gp_privillage_groupname.group LIKE '%$keyword%' OR sort_order LIKE '%$keyword%' OR DATE_FORMAT(gp_pl_sales_designation_type.created_on,'%d-%b-%Y') LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT gp_pl_sales_designation_type.id, designation,description,gp_privillage_groupname.group as groupname,sort_order,DATE_FORMAT(gp_pl_sales_designation_type.created_on,'%d-%m-%Y') as date_time   FROM  gp_pl_sales_designation_type LEFT JOIN gp_privillage_groupname ON  gp_pl_sales_designation_type.group_id=gp_privillage_groupname.id where gp_pl_sales_designation_type.type='executive'and gp_pl_sales_designation_type.is_del='0'".$where.$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
    }

    //Club Type Report
    function get_club_types_count($search)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (id LIKE '%$keyword%' OR title LIKE '%$keyword%' OR type LIKE '%$keyword%' OR amount LIKE '%$keyword%' OR cash_limit LIKE '%$keyword%' OR DATE_FORMAT(club_member_type.created_on,'%d-%b-%Y') LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $query="SELECT id, title,type, amount, cash_limit, DATE_FORMAT(club_member_type.created_on,'%d-%b-%Y') as date_time FROM club_member_type ORDER BY id DESC".$where;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }
        else
        {
            return false;
        }
    }
    function  get_club_types($search,$limit=NULL,$start=NULL)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (id LIKE '%$keyword%' OR title LIKE '%$keyword%' OR type LIKE '%$keyword%' OR amount LIKE '%$keyword%' OR cash_limit LIKE '%$keyword%' OR DATE_FORMAT(club_member_type.created_on,'%d-%b-%Y') LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT id, title,type, amount, cash_limit, DATE_FORMAT(club_member_type.created_on,'%d-%b-%Y') as date_time FROM club_member_type ORDER BY id DESC".$where.$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
    }
    //All channel partner report
    function get_channel_partner_count($search,$type=NULL)
    {
        if(!empty($type)){
            $join1 = " LEFT JOIN gp_pl_channel_partner_type_connection cp_con ON cp.id=cp_con.channel_partner_id LEFT JOIN gp_pl_channel_partner_types type ON cp_con.channel_partner_type_id=type.id WHERE type.id='$type' and cp.is_del='0'";
        }else{
            $join1 = "where cp.is_del='0'";
        }
        if(!empty($search)){
            $keyword = "%{$search}%";
            if(!empty($type)){
                $where = " AND (name LIKE '%$keyword%' OR cname LIKE '%$keyword%' OR phone LIKE '%$keyword%' OR phone2 LIKE '%$keyword%') ";
            }else{
                $where = " WHERE (name LIKE '%$keyword%' OR cname LIKE '%$keyword%' OR phone LIKE '%$keyword%' OR phone2 LIKE '%$keyword%') and is_del='0'";
            }
        }else{
            $where = '';
        }
        $query="SELECT cp.id,name,phone,cname,phone2,brand_image FROM gp_pl_channel_partner cp ".$join1.$where."  group by cp.id ORDER BY cp.id DESC";
      
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }
        else
        {
            return false;
        }
    }
    function  get_channel_partners($search,$type=NULL,$limit=NULL,$start=NULL)
    {
        if(!empty($type)){
            $join1 = "LEFT JOIN gp_pl_channel_partner_type_connection cp_con ON cp.id=cp_con.channel_partner_id  LEFT JOIN gp_pl_channel_partner_types type ON cp_con.channel_partner_type_id=type.id WHERE type.id='$type' and cp.is_del='0'";
        }else{
            $join1 = "where cp.is_del='0'";
        }
        if(!empty($search)){
            $keyword = "%{$search}%";
            if(!empty($type)){
                $where = " AND (name LIKE '%$keyword%' OR cname LIKE '%$keyword%' OR phone LIKE '%$keyword%' OR phone2 LIKE '%$keyword%')";
            }else{
                $where = " WHERE (name LIKE '%$keyword%' OR cname LIKE '%$keyword%' OR phone LIKE '%$keyword%' OR phone2 LIKE '%$keyword%') and is_del='0'";
            }
        }else{
            $where = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT cp.id,name,phone,cname,phone2,brand_image FROM gp_pl_channel_partner cp ".$join1.$where." group by cp.id ORDER BY id DESC".$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
    }
    //channel partner via club member
    function get_cm_channelpartners_count($search,$type=NULL)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            if(!empty($type)){
                $where = " AND (cp.status LIKE '%$keyword%' OR cp.name LIKE '%$keyword%' OR nc.name LIKE '%$keyword%' OR cp.cname LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%')AND cp.club_type='$type' and is_del='0'";
            }else{
                $where = " AND (cp.status LIKE '%$keyword%' OR cp.name LIKE '%$keyword%' OR nc.name LIKE '%$keyword%' OR cp.cname LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%') and is_del='0'";
            }
            
        }else{
            if(!empty($type)){
                $where = " AND cp.club_type='$type' and is_del='0'";
            }else{
                
                $where = " and cp.is_del='0'";
            }
        }

        $query="SELECT cp.id,cp.name,nc.name as cm_name,cp.phone,cp.cname,cp.phone2,cp.brand_image,cp.status FROM gp_pl_channel_partner cp   left join gp_login_table lt on cp.club_mem_id=lt.id left join gp_normal_customer nc on lt.user_id=nc.id WHERE lt.type='club_member'".$where."  group by cp.id ORDER BY cp.id DESC";
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }
        else
        {
            return false;
        }
    }
    function  get_cm_channelpartners($search,$type=NULL,$limit=NULL,$start=NULL)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            if(!empty($type)){
                $where = " AND (cp.status LIKE '%$keyword%' OR cp.name LIKE '%$keyword%' OR nc.name LIKE '%$keyword%' OR cp.cname LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%')AND cp.club_type='$type' and is_del='0'";
            }else{
                $where = " AND (cp.status LIKE '%$keyword%' OR cp.name LIKE '%$keyword%' OR nc.name LIKE '%$keyword%' OR cp.cname LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%')";
            }
            
        }else{
            if(!empty($type)){
                $where = " AND cp.club_type='$type'";
            }else{
                
                $where = "and cp.is_del='0'";
            }
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT cp.id,cp.name,nc.name as cm_name,cp.phone,cp.cname,cp.phone2,cp.brand_image,cp.status FROM gp_pl_channel_partner cp   left join gp_login_table lt on cp.club_mem_id=lt.id left join gp_normal_customer nc on lt.user_id=nc.id WHERE lt.type='club_member'".$where." group by cp.id ORDER BY cp.id DESC".$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
    }
    //channel partner via executive
    function get_exe_channelpartners_count($search)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " AND (cp.status LIKE '%$keyword%' OR cp.name LIKE '%$keyword%' OR st.name LIKE '%$keyword%' OR cp.cname LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%')";
        }else{
            $where = "and cp.is_del='0'";
        }

        $query="SELECT cp.id,cp.name,st.name as cm_name,cp.phone,cp.cname,cp.phone2,cp.brand_image,cp.status FROM gp_pl_channel_partner cp   left join gp_login_table lt on cp.created_by=lt.id left join gp_pl_sales_team_members st on lt.user_id=st.id WHERE lt.type='executive'".$where."  group by cp.id ORDER BY cp.id DESC";
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }
        else
        {
            return false;
        }
    }
    function  get_exe_channelpartners($search,$limit=NULL,$start=NULL)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " AND (cp.status LIKE '%$keyword%' OR cp.name LIKE '%$keyword%' OR st.name LIKE '%$keyword%' OR cp.cname LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%')";
            
        }else{
            $where = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT cp.id,cp.name,st.name as cm_name,cp.phone,cp.cname,cp.phone2,cp.brand_image,cp.status FROM gp_pl_channel_partner cp   left join gp_login_table lt on cp.created_by=lt.id left join gp_pl_sales_team_members st on lt.user_id=st.id WHERE lt.type='executive'".$where." group by cp.id ORDER BY cp.id DESC".$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
    }
    //channel partner via admin
    function get_admin_channelpartners_count($search)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " AND (cp.status LIKE '%$keyword%' OR cp.name LIKE '%$keyword%' OR nc.name LIKE '%$keyword%' OR cp.cname LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%')";
        }else{
            $where = '';
        }

        $query="SELECT cp.id,cp.name,nc.name as cm_name,cp.phone,cp.cname,cp.phone2,cp.brand_image,cp.status FROM gp_pl_channel_partner cp   left join gp_login_table lt on cp.created_by=lt.id left join gp_normal_customer nc on lt.user_id=nc.id WHERE lt.type='super_admin'".$where."  group by cp.id ORDER BY cp.id DESC";
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }
        else
        {
            return false;
        }
    }
    function  get_admin_channelpartners($search,$limit=NULL,$start=NULL)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " AND (cp.status LIKE '%$keyword%' OR cp.name LIKE '%$keyword%' OR nc.name LIKE '%$keyword%' OR cp.cname LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%')";
            
        }else{
            $where = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT cp.id,cp.name,nc.name as cm_name,cp.phone,cp.cname,cp.phone2,cp.brand_image,cp.status FROM gp_pl_channel_partner cp   left join gp_login_table lt on cp.created_by=lt.id left join gp_normal_customer nc on lt.user_id=nc.id WHERE lt.type='super_admin'".$where." group by cp.id ORDER BY cp.id DESC".$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
    }
    //Typewise club member
    function get_club_members_by_type_count($search,$type=NULL)
    {

        if(!empty($search)){
            $keyword =$search;
            if(!empty($type)){
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' 
                OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' 
                OR nc.status LIKE '%$keyword%' 
                OR (CASE WHEN nc.club_type_id>0 THEN (SELECT title FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) LIKE '%$keyword%' 
                OR (CASE WHEN nc.fixed_club_type_id>0 THEN (SELECT title FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) LIKE '%$keyword%' 
                OR (CASE WHEN nc.investor_type_id>0 THEN (SELECT title FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END) LIKE '%$keyword%' )";
                if($type=='UNLIMITED'){
                    $where .= " AND (CASE WHEN nc.club_type_id>0 THEN (SELECT type FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) ='$type'";
                }else if($type=='FIXED'){
                    $where .= "AND (CASE WHEN nc.fixed_club_type_id>0 THEN (SELECT type FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) ='$type'";
                }else{
                    $where .= "AND (CASE WHEN nc.investor_type_id>0 THEN (SELECT type FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END)  ='$type'";
                }
            }else{
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' 
                OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' 
                OR nc.status LIKE '%$keyword%' 
                OR (CASE WHEN nc.club_type_id>0 THEN (SELECT title FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) LIKE '%$keyword%' 
                OR (CASE WHEN nc.fixed_club_type_id>0 THEN (SELECT title FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) LIKE '%$keyword%' 
                OR (CASE WHEN nc.investor_type_id>0 THEN (SELECT title FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END) LIKE '%$keyword%' )";
            }
            /*if(!empty($type)){
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' OR nc.status LIKE '%$keyword%')AND ((CASE WHEN nc.club_type_id>0 THEN (SELECT title FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) LIKE '%$keyword%' OR (CASE WHEN nc.fixed_club_type_id THEN (SELECT type FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) LIKE '%$keyword%' OR (CASE WHEN nc.investor_type_id>0 THEN (SELECT title FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END LIKE '%$keyword%') AND (t.type ='%$type%' OR t1.type ='%$type%' OR t2.type ='%$type%')";
            }else{
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' OR nc.status LIKE '%$keyword%' OR (CASE WHEN nc.club_type_id THEN (SELECT type FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) LIKE '%$keyword%' OR (CASE WHEN nc.fixed_club_type_id THEN (SELECT type FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) LIKE '%$keyword%' OR (CASE WHEN nc.investor_type_id>0 THEN (SELECT title FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END) LIKE '%$keyword%')";
            }*/
            
        }else{
            $where = "";
            if(!empty($type)){
                if($type=='UNLIMITED'){
                    $where .= " AND (CASE WHEN nc.club_type_id>0 THEN (SELECT type FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) ='$type'";
                }else if($type=='FIXED'){
                    $where .= "AND (CASE WHEN nc.fixed_club_type_id>0 THEN (SELECT type FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) ='$type'";
                }else{
                    $where .= "AND (CASE WHEN nc.investor_type_id>0 THEN (SELECT type FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END)  ='$type'";
                }
            }else{
                
                $where = '';
            }
        }

         $query="SELECT nc.name, nc.email,nc.phone,(CASE WHEN nc.club_type_id>0 THEN (SELECT title FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) as plan_1,(CASE WHEN nc.fixed_club_type_id>0 THEN (SELECT title FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) as plan_2,(CASE WHEN nc.investor_type_id>0 THEN (SELECT title FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END) as plan_3,
            DATE_FORMAT(nc.created_on,'%d-%b-%Y') as created_on,nc.status
            FROM gp_login_table log,gp_normal_customer AS nc, club_member_type AS t, club_member_type AS t1, club_member_type AS t2
            WHERE (((log.user_id=nc.id)AND((nc.club_type_id = t1.id) 
            OR (nc.fixed_club_type_id = t.id)
            OR (nc.investor_type_id = t2.id))
            AND log.type='club_member') )".$where." GROUP BY nc.id";
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }
        else
        {
            return false;
        }
    }
    function  get_club_members_by_type($search,$type=NULL,$limit=NULL,$start=NULL)
    {
        if(!empty($search)){
            $keyword =$search;
            if(!empty($type)){
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' 
                OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' 
                OR nc.status LIKE '%$keyword%' 
                OR (CASE WHEN nc.club_type_id>0 THEN (SELECT title FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) LIKE '%$keyword%' 
                OR (CASE WHEN nc.fixed_club_type_id>0 THEN (SELECT title FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) LIKE '%$keyword%' 
                OR (CASE WHEN nc.investor_type_id>0 THEN (SELECT title FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END) LIKE '%$keyword%' )";
                if($type=='UNLIMITED'){
                    $where .= " AND (CASE WHEN nc.club_type_id>0 THEN (SELECT type FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) ='$type'";
                }else if($type=='FIXED'){
                    $where .= "AND (CASE WHEN nc.fixed_club_type_id>0 THEN (SELECT type FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) ='$type'";
                }else{
                    $where .= "AND (CASE WHEN nc.investor_type_id>0 THEN (SELECT type FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END)  ='$type'";
                }
            }else{
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' 
                OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' 
                OR nc.status LIKE '%$keyword%' 
                OR (CASE WHEN nc.club_type_id>0 THEN (SELECT title FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) LIKE '%$keyword%' 
                OR (CASE WHEN nc.fixed_club_type_id>0 THEN (SELECT title FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) LIKE '%$keyword%' 
                OR (CASE WHEN nc.investor_type_id>0 THEN (SELECT title FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END) LIKE '%$keyword%' )";
            }
            /*if(!empty($type)){
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' OR nc.status LIKE '%$keyword%')AND ((CASE WHEN nc.club_type_id>0 THEN (SELECT title FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) LIKE '%$keyword%' OR (CASE WHEN nc.fixed_club_type_id THEN (SELECT type FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) LIKE '%$keyword%' OR (CASE WHEN nc.investor_type_id>0 THEN (SELECT title FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END LIKE '%$keyword%') AND (t.type ='%$type%' OR t1.type ='%$type%' OR t2.type ='%$type%')";
            }else{
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' OR nc.status LIKE '%$keyword%' OR (CASE WHEN nc.club_type_id THEN (SELECT type FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) LIKE '%$keyword%' OR (CASE WHEN nc.fixed_club_type_id THEN (SELECT type FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) LIKE '%$keyword%' OR (CASE WHEN nc.investor_type_id>0 THEN (SELECT title FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END) LIKE '%$keyword%')";
            }*/
            
        }else{
            $where = "";
            if(!empty($type)){
                if($type=='UNLIMITED'){
                    $where .= " AND (CASE WHEN nc.club_type_id>0 THEN (SELECT type FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) ='$type'";
                }else if($type=='FIXED'){
                    $where .= "AND (CASE WHEN nc.fixed_club_type_id>0 THEN (SELECT type FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) ='$type'";
                }else{
                    $where .= "AND (CASE WHEN nc.investor_type_id>0 THEN (SELECT type FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END)  ='$type'";
                }
            }else{
                
                $where = '';
            }
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT nc.name, nc.email,nc.phone,(CASE WHEN nc.club_type_id>0 THEN (SELECT title FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) as plan_1,(CASE WHEN nc.fixed_club_type_id>0 THEN (SELECT title FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) as plan_2,(CASE WHEN nc.investor_type_id>0 THEN (SELECT title FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END) as plan_3,
            DATE_FORMAT(nc.created_on,'%d-%b-%Y') as created_on,nc.status
            FROM gp_login_table log,gp_normal_customer AS nc, club_member_type AS t, club_member_type AS t1, club_member_type AS t2
            WHERE (((log.user_id=nc.id)AND((nc.club_type_id = t1.id) 
            OR (nc.fixed_club_type_id = t.id)
            OR (nc.investor_type_id = t2.id))
            AND log.type='club_member') )".$where." GROUP BY nc.id".$pg;
        $result=$this->db->query($query);
       //echo $this->db->last_query();
        if($result->num_rows()>0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
    }
    //Club Member BY
    function get_club_members_by_count($search,$type=NULL)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            if(!empty($type)){
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' OR nc.status LIKE '%$keyword%' OR (CASE WHEN nc.club_type_id>0 THEN (SELECT title FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) LIKE '%$keyword%' 
                OR (CASE WHEN nc.fixed_club_type_id>0 THEN (SELECT title FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) LIKE '%$keyword%' 
                OR (CASE WHEN nc.investor_type_id>0 THEN (SELECT title FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END) LIKE '%$keyword%' )AND (nc.register_via = '$type')";
            }else{
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' OR nc.status LIKE '%$keyword%' OR nc.register_via  LIKE '%$keyword%' OR (CASE WHEN nc.club_type_id>0 THEN (SELECT title FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) LIKE '%$keyword%' 
                OR (CASE WHEN nc.fixed_club_type_id>0 THEN (SELECT title FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) LIKE '%$keyword%' 
                OR (CASE WHEN nc.investor_type_id>0 THEN (SELECT title FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END) LIKE '%$keyword%' )";
            }
            
        }else{
            if(!empty($type)){
                $where = " AND (nc.register_via ='$type')";
            }else{
                
                $where = '';
            }
        }
        $query="SELECT nc.name, nc.email,nc.phone,(CASE WHEN nc.club_type_id>0 THEN (SELECT title FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) as plan_1,(CASE WHEN nc.fixed_club_type_id>0 THEN (SELECT title FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) as plan_2,(CASE WHEN nc.investor_type_id>0 THEN (SELECT title FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END) as plan_3,(CASE WHEN (nc.register_via = 'admin') 
            THEN 'Admin'
            ELSE 
            (CASE WHEN (nc.register_via = 'executive') 
            THEN (SELECT CONCAT(tm.name,' (Executive)' )FROM gp_pl_sales_team_members as tm left join gp_login_table log on log.user_id = tm.id where nc.type='club_member' and nc.register_via='executive' and nc.parent_id=log.id)
            ELSE 'Individual' END)
            END) as created_by,
            DATE_FORMAT(nc.created_on,'%d-%b-%Y') as created_on,nc.status
            FROM gp_login_table log,gp_normal_customer AS nc, club_member_type AS t, club_member_type AS t1, club_member_type AS t2
            WHERE (((log.user_id=nc.id)AND((nc.club_type_id = t1.id) 
            OR (nc.fixed_club_type_id = t.id)
            OR (nc.investor_type_id = t2.id))
            AND log.type='club_member') )".$where." GROUP BY nc.id";
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }
        else
        {
            return false;
        }
    }
    function  get_club_members_by($search,$type=NULL,$limit=NULL,$start=NULL)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            if(!empty($type)){
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' OR nc.status LIKE '%$keyword%' OR (CASE WHEN nc.club_type_id>0 THEN (SELECT title FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) LIKE '%$keyword%' 
                OR (CASE WHEN nc.fixed_club_type_id>0 THEN (SELECT title FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) LIKE '%$keyword%' 
                OR (CASE WHEN nc.investor_type_id>0 THEN (SELECT title FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END) LIKE '%$keyword%' )AND (nc.register_via = '$type')";
            }else{
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' OR nc.status LIKE '%$keyword%' OR nc.register_via  LIKE '%$keyword%' OR (CASE WHEN nc.club_type_id>0 THEN (SELECT title FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) LIKE '%$keyword%' 
                OR (CASE WHEN nc.fixed_club_type_id>0 THEN (SELECT title FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) LIKE '%$keyword%' 
                OR (CASE WHEN nc.investor_type_id>0 THEN (SELECT title FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END) LIKE '%$keyword%' )";
            }
            
        }else{
            if(!empty($type)){
                $where = " AND (nc.register_via ='$type')";
            }else{
                
                $where = '';
            }
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT nc.name, nc.email,nc.phone,(CASE WHEN nc.club_type_id>0 THEN (SELECT title FROM club_member_type as t1 WHERE nc.club_type_id = t1.id)ELSE 0 END) as plan_1,(CASE WHEN nc.fixed_club_type_id>0 THEN (SELECT title FROM club_member_type as t WHERE nc.fixed_club_type_id = t.id)ELSE 0 END) as plan_2,(CASE WHEN nc.investor_type_id>0 THEN (SELECT title FROM club_member_type as t2 WHERE nc.investor_type_id = t2.id)ELSE 0 END) as plan_3,(CASE WHEN (nc.register_via = 'admin') 
            THEN 'Admin'
            ELSE 
            (CASE WHEN (nc.register_via = 'executive') 
            THEN (SELECT CONCAT(tm.name,' (Executive)' )FROM gp_pl_sales_team_members as tm left join gp_login_table log on log.user_id = tm.id where nc.type='club_member' and nc.register_via='executive' and nc.parent_id=log.id)
            ELSE 'Individual' END)
            END) as created_by,
            DATE_FORMAT(nc.created_on,'%d-%b-%Y') as created_on,nc.status
            FROM gp_login_table log,gp_normal_customer AS nc, club_member_type AS t, club_member_type AS t1, club_member_type AS t2
            WHERE (((log.user_id=nc.id)AND((nc.club_type_id = t1.id) 
            OR (nc.fixed_club_type_id = t.id)
            OR (nc.investor_type_id = t2.id))
            AND log.type='club_member') )".$where." GROUP BY nc.id".$pg;
        $result=$this->db->query($query);
      // echo $this->db->last_query();
        if($result->num_rows()>0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
    }
    //Normal Customers
    function get_customers_by_count($search,$type=NULL)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            if(!empty($type)){
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' OR nc.status LIKE '%$keyword%')AND (nc.register_via LIKE '%$type%')";
            }else{
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' OR nc.status LIKE '%$keyword%' OR nc.register_via LIKE '%$keyword%')";
            }
        }else{
            if(!empty($type)){
                $where = " AND (nc.register_via LIKE '%$type%')";
            }else{
                
                $where = '';
            }
        }
        $query="SELECT nc.name, nc.email,nc.phone,DATE_FORMAT(nc.created_on,'%d-%b-%Y') as created_on 
            FROM gp_login_table log LEFT JOIN gp_normal_customer  nc
            ON log.user_id=nc.id
            WHERE log.type='normal_customer'".$where." GROUP BY nc.id";
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }
        else
        {
            return false;
        }
    }
    function get_customers($search,$type=NULL,$limit=NULL,$start=NULL)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            if(!empty($type)){
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' OR nc.status LIKE '%$keyword%')AND (nc.register_via = '$type')";
            }else{
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' OR nc.status LIKE '%$keyword%' OR nc.register_via  LIKE '%$keyword%' )";
            }
            
        }else{
            if(!empty($type)){
                $where = " AND (nc.register_via  LIKE '%$type%')";
            }else{
                
                $where = '';
            }
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT nc.name, nc.email,nc.phone,DATE_FORMAT(nc.created_on,'%d-%b-%Y') as created_on 
            FROM gp_login_table log LEFT JOIN gp_normal_customer  nc
            ON log.user_id=nc.id
            WHERE log.type='normal_customer'".$where." GROUP BY nc.id".$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
    }
    //Club agents
    function get_clubagents_by_count($search,$type=NULL)
    {
        $data = array();
        if(!empty($search)){
            $keyword = "%{$search}%";
            if(!empty($type)){
                $where = " AND (nc.name LIKE '%$keyword%' OR log.email LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%')AND (nc.register_via LIKE '%$type%')";
            }else{
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' OR nc.register_via LIKE '%$keyword%')";
            }
        }else{
            if(!empty($type)){
                $where = " AND (nc.register_via LIKE '%$type%')";
            }else{
                
                $where = '';
            }
        }

        $query="SELECT log.id,nc.name,log.email,nc.phone,log.parent_login_id,nc.created_by,nc.register_via,DATE_FORMAT(nc.created_on,'%d-%b-%Y') as created_on FROM gp_login_table log  
            LEFT JOIN gp_normal_customer nc ON log.user_id=nc.id
            WHERE (log.type='club_agent') ".$where." GROUP BY nc.id";
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            $res1 = $result->result_array();
            foreach ($res1 as $key => $value) {
                $parent_id = $value['parent_login_id'];
                $created_by = $value['created_by']; 
                $register_via = $value['register_via'];
                if(!empty($search)){
                    $keyword = "%{$search}%";
                    if(!empty($type)){
                        $where2 = " AND (log.type LIKE '%$keyword%')AND (log.type LIKE '%$type%')";
                    }else{
                        $where2 = " AND (log.type LIKE '%$keyword%')";
                    }
                }else{
                    if(!empty($type)){
                        $where2 = " AND (log.type LIKE '%$type%')";
                    }else{
                        
                        $where2 = '';
                    }
                }
                $sq ='';
                $sql = "SELECT nc.name as created_by,log.type FROM gp_login_table log";
                    
                if($type=='executive' || $register_via =='executive'){
                   $sq .= " LEFT JOIN gp_pl_sales_team_members nc  ON log.user_id=nc.id WHERE log.id='$created_by'".$where2;
                }else if($type=='club_member'){
                   $sq .= " LEFT JOIN gp_normal_customer nc  ON log.user_id=nc.id WHERE log.id='$parent_id' OR log.id='$created_by' or nc.register_via='$type'".$where2;
                }else{
                    $sq .= " LEFT JOIN gp_normal_customer nc  ON log.user_id=nc.id WHERE log.id='$created_by' or nc.register_via='$type'".$where2;
                }
                //echo $sql.$sq;
                $sql=$this->db->query($sql.$sq);

                if($sql->num_rows()>0)
                {
                    $res2 = $sql->row_array();
                    $value['created_by']=$res2['created_by']." &nbsp;(".str_replace("_"," ",$res2['type']).")";
                    array_push($data,$value);
                }else{
                    array_push($data,$value);
                }
            }
        }
        return sizeof($data);
    }
    function get_clubagents($search,$type=NULL,$limit=NULL,$start=NULL)
    {
        $data = array();
        if(!empty($search)){
            $keyword = "%{$search}%";
            if(!empty($type)){
                $where = " AND (nc.name LIKE '%$keyword%' OR log.email LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%')AND (nc.register_via LIKE '%$type%')";
            }else{
                $where = " AND (nc.name LIKE '%$keyword%' OR nc.email LIKE '%$keyword%' OR nc.phone LIKE '%$keyword%' OR nc.created_on LIKE '%$keyword%' OR nc.register_via LIKE '%$keyword%')";
            }
        }else{
            if(!empty($type)){
                $where = " AND (nc.register_via LIKE '%$type%')";
            }else{
                
                $where = '';
            }
        }

        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT log.id,nc.name,log.email,nc.phone,log.parent_login_id,nc.created_by,nc.register_via,DATE_FORMAT(nc.created_on,'%d-%b-%Y') as created_on FROM gp_login_table log  
            LEFT JOIN gp_normal_customer nc ON log.user_id=nc.id
            WHERE (log.type='club_agent') ".$where." GROUP BY nc.id".$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            $res1 = $result->result_array();
            foreach ($res1 as $key => $value) {
                $parent_id = $value['parent_login_id'];
                $created_by = $value['created_by']; 
                $register_via = $value['register_via'];
                if(!empty($search)){
                    $keyword = "%{$search}%";
                    if(!empty($type)){
                        $where2 = " AND (log.type LIKE '%$keyword%')AND (log.type LIKE '%$type%')";
                    }else{
                        $where2 = " AND (log.type LIKE '%$keyword%')";
                    }
                }else{
                    if(!empty($type)){
                        $where2 = " AND (log.type LIKE '%$type%')";
                    }else{
                        
                        $where2 = '';
                    }
                }
                $sq ='';
                $sql = "SELECT nc.name as created_by,log.type FROM gp_login_table log";
                    
                if($type=='executive' || $register_via =='executive'){
                   $sq .= " LEFT JOIN gp_pl_sales_team_members nc  ON log.user_id=nc.id WHERE log.id='$created_by'".$where2;
                }else if($type=='club_member'){
                   $sq .= " LEFT JOIN gp_normal_customer nc  ON log.user_id=nc.id WHERE log.id='$parent_id' OR log.id='$created_by' or nc.register_via='$type'".$where2;
                }else{
                    $sq .= " LEFT JOIN gp_normal_customer nc  ON log.user_id=nc.id WHERE log.id='$created_by' or nc.register_via='$type'".$where2;
                }
                //echo $sql.$sq;
                $sql=$this->db->query($sql.$sq);

                if($sql->num_rows()>0)
                {
                    $res2 = $sql->row_array();
                    $value['created_by']=$res2['created_by']." &nbsp;(".str_replace("_"," ",$res2['type']).")";
                    array_push($data,$value);
                }else{
                    array_push($data,$value);
                }
            }
        }
        return $data;
    }
    //Pooling Report
    function get_pooling_count($search)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (ps.title LIKE '%$keyword%' OR ps.no_of_levels LIKE '%$keyword%' OR ps.percentage LIKE '%$keyword%')";
        }else{
            $where = '';
        }

        $query="SELECT title,no_of_levels,percentage FROM gp_pl_pool_settings ps".$where."  group by ps.id ORDER BY ps.id DESC";
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }
        else
        {
            return false;
        }
    }
    function get_poolings($search,$limit=NULL,$start=NULL){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "  WHERE (ps.title LIKE '%$keyword%' OR ps.no_of_levels LIKE '%$keyword%' OR ps.percentage LIKE '%$keyword%')";
            
        }else{
            $where = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT title,no_of_levels,percentage FROM gp_pl_pool_settings ps".$where." ORDER BY ps.id DESC".$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
    }
    //Purchase Report - Customers
    /*function get_purchase_by_customers_count($search,$from,$to)
    {
        $data=array();
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (nc.name LIKE '%$keyword%' OR bn.wallet_total LIKE '%$keyword%' OR DATE_FORMAT(bn.purchased_on,'%d-%b-%Y') LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        if(empty($from)&&!empty($to)){
            $where2 = "AND bn.purchased_on=".$to;
        }elseif(empty($to)&&!empty($from)){
            $where2 = "AND bn.purchased_on=".$from;
        }elseif(!empty($from)&&!empty($to)){
            $where2 = "AND bn.purchased_on between ".$from." and ".$to;
        }else{
            $where2 ="";
        }
        $query="SELECT bn.id,nc.name,bn.wallet_total,bn.bill_total, DATE_FORMAT(bn.purchased_on,'%d-%b-%Y')as purchsed_on,bn.channel_partner_id FROM gp_purchase_bill_notification bn LEFT JOIN gp_login_table log ON log.id=bn.login_id 
            LEFT JOIN gp_normal_customer nc ON log.user_id=nc.id WHERE log.type='normal_customer'".$where. $where2." GROUP BY bn.id";
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            $res1 = $result->result_array();
            foreach ($res1 as $key => $value) {
                $channel_partner_id = $value['channel_partner_id'];
                if(!empty($search)){
                    $where2 = " WHERE cp.name LIKE '%$search%'";
                }else{
                    $where2 = '';
                }
                $sq ='';
                $sql = "SELECT cp.name FROM gp_pl_channel_partner cp".$where2;
                $sql=$this->db->query($sql);

                if($sql->num_rows()>0)
                {
                    $res2 = $sql->row_array();
                    $value['channel']=$res2['name'];
                    array_push($data,$value);
                }else{
                    array_push($data,$value);
                }
            }
            return sizeof($data);
        }
        else
        {
            return false;
        }  
    }
    function get_purchase_by_customers($search,$from,$to,$limit=NULL,$start=NULL)
    {

        $data=array();
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (nc.name LIKE '%$keyword%' OR bn.wallet_total LIKE '%$keyword%' OR DATE_FORMAT(bn.purchased_on,'%d-%b-%Y') LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        if(empty($from)&&!empty($to)){
            $where2 = "AND bn.purchased_on=".$to;
        }elseif(empty($to)&&!empty($from)){
            $where2 = "AND bn.purchased_on=".$from;
        }elseif(!empty($from)&&!empty($to)){
            $where2 = "AND bn.purchased_on between ".$from." and ".$to;
        }else{
            $where2 ="";
        }
        $query="SELECT bn.id,bn.login_id,nc.name,bn.wallet_total,bn.bill_total,bn.purchased_on as purchase_date, DATE_FORMAT(bn.purchased_on,'%d-%b-%Y')as purchsed_on,bn.channel_partner_id FROM gp_purchase_bill_notification bn LEFT JOIN gp_login_table log ON log.id=bn.login_id 
            LEFT JOIN gp_normal_customer nc ON log.user_id=nc.id WHERE log.type='normal_customer'".$where. $where2." GROUP BY bn.id";
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            $res1 = $result->result_array();
            foreach ($res1 as $key => $value) {
                $channel_partner_id = $value['channel_partner_id'];
                $purchase_date = $value['purchase_date'];
                $login_id = $value['login_id'];
                $noty_id = $value['id'];
                if(!empty($search)){
                    $where2 = " WHERE cp.name LIKE '%$search%'";
                }else{
                    $where2 = '';
                }
                $sql = "SELECT cp.name FROM gp_pl_channel_partner cp".$where2;
                $sql=$this->db->query($sql);

                if($sql->num_rows()>0)
                {
                    $res2 = $sql->row_array();
                    $value['channel']=$res2['name'];
                }
                $sql3 = "SELECT change_value FROM `gp_wallet_activity`  
                        WHERE user_id='$login_id' and purchase_bill_notification_id='$noty_id' and type='GAIN'
                         ORDER BY `id` DESC";
                $sql3=$this->db->query($sql3);

                if($sql3->num_rows()>0)
                {
                    $res3 = $sql3->row_array();
                    $value['reward']=$res3['change_value'];
                }
                array_push($data,$value);
            }
            return $data;
        }
        else
        {
            return false;
        }  
    }*/
    function get_cp_name($id,$search)
    {
        if(!empty($search)){
            $where= " AND cp.name LIKE '%{$search}%'";
        }else{
            $where = '';
        }

        
        $sql = "SELECT cp.name FROM gp_pl_channel_partner cp WHERE cp.id='$id'".$where;
        $sql=$this->db->query($sql);

        if($sql->num_rows()>0)
        {
            $res2 = $sql->row_array();
            return $res2['name'];
        }
    }
    function get_customer_name($id,$search)
    {
        if(!empty($search)){
            $where= " AND nc.name LIKE '%{$search}%'";
        }else{
            $where = '';
        }

        
        $sql = "SELECT nc.name FROM gp_normal_customer nc LEFT JOIN gp_login_table log
        ON log.user_id=nc.id WHERE log.id='$id' and log.type='normal_customer'".$where;
        $sql=$this->db->query($sql);

        if($sql->num_rows()>0)
        {
            $res2 = $sql->row_array();
            return $res2['name'];
        }
    }
    function get_rewards($login_id,$id,$search)
    {
        if(!empty($search)){
            $where = " AND change_value LIKE '%{$search}%'";
        }else{
            $where = '';
        }
        $sql3 = "SELECT change_value FROM `gp_wallet_activity`  
                WHERE user_id='$login_id' and  `gp_wallet_activity`.`wallet_type_id`='2' and purchase_bill_notification_id='$id' and type='GAIN' ".$where."
                 ORDER BY `id` DESC";
        $sql3=$this->db->query($sql3);

        if($sql3->num_rows()>0)
        {
            $res3 = $sql3->row_array();
            return $res3['change_value'];
        }
    }
    function get_purchase_by_customers_count($search,$from,$to)
    {
        $data=array();
        $details=array();
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " AND (nc.name LIKE '$keyword' OR bn.wallet_total LIKE '$keyword' OR bn.bill_total LIKE '$keyword' OR DATE_FORMAT(bn.purchased_on,'%d-%b-%Y') LIKE '$keyword')";
        }else{
            $where = '';
        }
        if(empty($from)&&!empty($to)){
            $to = $to." 00:00:00";
            $where2 = "AND bn.purchased_on='".$to."'";
        }elseif(empty($to)&&!empty($from)){
            $from =$from." 00:00:00";
            $where2 = "AND bn.purchased_on='".$from."'";
        }elseif(!empty($from)&&!empty($to)){
            $from =$from." 00:00:00";$to = $to." 23:59:59";
            $where2 = "AND bn.purchased_on between '".$from."' and '".$to."'";
        }else{
            $where2 ="";
        }


        $query="SELECT bn.id,bn.login_id,nc.name,bn.wallet_total,bn.bill_total,bn.purchased_on as purchase_date, DATE_FORMAT(bn.purchased_on,'%d-%b-%Y')as purchsed_on,bn.channel_partner_id FROM gp_purchase_bill_notification bn LEFT JOIN gp_login_table log ON log.id=bn.login_id 
            LEFT JOIN gp_normal_customer nc ON log.user_id=nc.id WHERE log.type='normal_customer'".$where. $where2." GROUP BY bn.id";
        $result=$this->db->query($query);
       
        if($result->num_rows()>0)
        {
            $res1 = $result->result_array();
            foreach ($res1 as $key => $value) {
                $channel_partner_id = $value['channel_partner_id'];
                $purchase_date = $value['purchase_date'];
                $login_id = $value['login_id'];
                $noty_id = $value['id'];
                $value['channel'] = $this->get_cp_name($channel_partner_id,$search);
                $value['reward']=$this->get_rewards($login_id,$noty_id,$search);
                array_push($data,$value);
            }
        }
        else
        {
            unset($data); // $data is gone
            $data = array();
            $query2="SELECT bn.id,bn.login_id,nc.name,bn.wallet_total,bn.bill_total,bn.purchased_on as purchase_date, DATE_FORMAT(bn.purchased_on,'%d-%b-%Y')as purchsed_on,bn.channel_partner_id FROM gp_purchase_bill_notification bn LEFT JOIN gp_login_table log ON log.id=bn.login_id 
            LEFT JOIN gp_normal_customer nc ON log.user_id=nc.id WHERE log.type='normal_customer'". $where2." GROUP BY bn.id";
            $result2=$this->db->query($query2);
            $res1 = $result2->result_array();
            foreach ($res1 as $key => $value2) {
                $channel_partner_id = $value2['channel_partner_id'];
                $purchase_date = $value2['purchase_date'];
                $login_id = $value2['login_id'];
                $noty_id = $value2['id'];
                $value['channel'] = $this->get_cp_name($channel_partner_id,$search);
                if(!empty($search)){
                    $where4 = " AND change_value LIKE '%{$search}%'";
                }else{
                    $where4 = '';
                }
                $sql3 = "SELECT change_value FROM `gp_wallet_activity`  
                        WHERE user_id='$login_id' and  `gp_wallet_activity`.`wallet_type_id`='2' and purchase_bill_notification_id='$noty_id' and type='GAIN' ".$where4."
                         ORDER BY `id` DESC";
                $sql3=$this->db->query($sql3);

                if($sql3->num_rows()>0)
                {
                    $res3 = $sql3->row_array();
                    $details['reward']=$res3['change_value'];
                    $details['name']=$value2['name'];
                    $details['id']=$value2['id'];
                    $details['wallet_total']=$value2['wallet_total'];
                    $details['bill_total']=$value2['bill_total'];
                    $details['purchsed_on']=$value2['purchsed_on'];
                    array_push($data,$details);

                }   
            }
        }  
        return sizeof($data);
    }
    function get_purchase_by_customers($search,$from,$to,$limit=NULL,$start=NULL)
    {
        $data=array();
        $details=array();
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " AND (nc.name LIKE '$keyword' OR bn.wallet_total LIKE '$keyword' OR bn.bill_total LIKE '$keyword' OR DATE_FORMAT(bn.purchased_on,'%d-%b-%Y') LIKE '$keyword')";
        }else{
            $where = '';
        }
        if(empty($from)&&!empty($to)){
            $to = $to." 00:00:00";
            $where2 = "AND bn.purchased_on='".$to."'";
        }elseif(empty($to)&&!empty($from)){
            $from =$from." 00:00:00";
            $where2 = "AND bn.purchased_on='".$from."'";
        }elseif(!empty($from)&&!empty($to)){
            $from =$from." 00:00:00";$to = $to." 23:59:59";
            $where2 = "AND bn.purchased_on between '".$from."' and '".$to."'";
        }else{
            $where2 ="";
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }


        $query="SELECT bn.id,bn.login_id,nc.name,bn.wallet_total,bn.bill_total,bn.purchased_on as purchase_date, DATE_FORMAT(bn.purchased_on,'%d-%b-%Y')as purchsed_on,bn.channel_partner_id FROM gp_purchase_bill_notification bn LEFT JOIN gp_login_table log ON log.id=bn.login_id 
            LEFT JOIN gp_normal_customer nc ON log.user_id=nc.id WHERE log.type='normal_customer'".$where. $where2." GROUP BY bn.id".$pg;
        $result=$this->db->query($query);
       
        if($result->num_rows()>0)
        {
            $res1 = $result->result_array();
            foreach ($res1 as $key => $value) {
                $channel_partner_id = $value['channel_partner_id'];
                $purchase_date = $value['purchase_date'];
                $login_id = $value['login_id'];
                $noty_id = $value['id'];
                
                $value['channel'] = $this->get_cp_name($channel_partner_id,$search);
                $value['reward']=$this->get_rewards($login_id,$noty_id,$search);
                array_push($data,$value);
            }
        }
        else
        {
            unset($data); // $data is gone
            $data = array();
            $query2="SELECT bn.id,bn.login_id,nc.name,bn.wallet_total,bn.bill_total,bn.purchased_on as purchase_date, DATE_FORMAT(bn.purchased_on,'%d-%b-%Y')as purchsed_on,bn.channel_partner_id FROM gp_purchase_bill_notification bn LEFT JOIN gp_login_table log ON log.id=bn.login_id 
            LEFT JOIN gp_normal_customer nc ON log.user_id=nc.id WHERE log.type='normal_customer'". $where2." GROUP BY bn.id".$pg;
            $result2=$this->db->query($query2);
            $res1 = $result2->result_array();
            foreach ($res1 as $key => $value2) {
                $channel_partner_id = $value2['channel_partner_id'];
                $purchase_date = $value2['purchase_date'];
                $login_id = $value2['login_id'];
                $noty_id = $value2['id'];
                $value['channel'] = $this->get_cp_name($channel_partner_id,$search);
                if(!empty($search)){
                    $where4 = " AND change_value LIKE '%{$search}%'";
                }else{
                    $where4 = '';
                }
                $sql3 = "SELECT change_value FROM `gp_wallet_activity`  
                        WHERE user_id='$login_id' and  `gp_wallet_activity`.`wallet_type_id`='2' and purchase_bill_notification_id='$noty_id' and type='GAIN' ".$where4."
                         ORDER BY `id` DESC";
                $sql3=$this->db->query($sql3);

                if($sql3->num_rows()>0)
                {
                    $res3 = $sql3->row_array();
                    $details['reward']=$res3['change_value'];
                    $details['name']=$value2['name'];
                    $details['id']=$value2['id'];
                    $details['wallet_total']=$value2['wallet_total'];
                    $details['bill_total']=$value2['bill_total'];
                    $details['purchsed_on']=$value2['purchsed_on'];
                    array_push($data,$details);

                }   
            }
        }  
        return $data;
    }
    function get_purchase_by_cp($search,$by,$from,$to,$limit=NULL,$start=NULL,$type)
    {

        $data=array();
        $details=array();
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " AND (cp.name LIKE '$keyword' OR bn.wallet_total LIKE '$keyword' OR bn.bill_total LIKE '$keyword' OR DATE_FORMAT(bn.purchased_on,'%d-%b-%Y') LIKE '$keyword')";
        }else{
            $where = '';
        }
        if(empty($from)&&!empty($to)){
            $to = $to." 00:00:00";
            $where2 = "AND bn.purchased_on='".$to."'";
        }elseif(empty($to)&&!empty($from)){
            $from =$from." 00:00:00";
            $where2 = "AND bn.purchased_on='".$from."'";
        }elseif(!empty($from)&&!empty($to)){
            $from =$from." 00:00:00";$to = $to." 23:59:59";
            $where2 = "AND bn.purchased_on between '".$from."' and '".$to."'";
        }else{
            $where2 ="";
        }

        if(!empty($by)){
            $where3 = " AND cp.id='".$by."'";
        }else{
            $where3 = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        
        $query="SELECT bn.id,bn.login_id,cp.name,bn.wallet_total,bn.bill_total,bn.purchased_on as purchase_date, DATE_FORMAT(bn.purchased_on,'%d-%b-%Y')as purchsed_on,bn.channel_partner_id FROM gp_purchase_bill_notification bn LEFT JOIN  gp_pl_channel_partner cp ON cp.id=bn.channel_partner_id 
            LEFT JOIN gp_login_table log ON log.user_id=cp.id WHERE log.type='Channel_partner'".$where.$where2.$where3." GROUP BY bn.id".$pg;
        $result=$this->db->query($query);
       
        if($result->num_rows()>0)
        {
            $res1 = $result->result_array();
            foreach ($res1 as $key => $value) {
                $login_id = $value['login_id'];
                $value['purchase_by'] = $this->get_customer_name($login_id,$search);
                array_push($data,$value);
            }
        }
        else
        {
            unset($data); // $data is gone
            $data = array();
            $query="SELECT bn.id,bn.login_id,cp.name,bn.wallet_total,bn.bill_total,bn.purchased_on as purchase_date, DATE_FORMAT(bn.purchased_on,'%d-%b-%Y')as purchsed_on,bn.channel_partner_id FROM gp_purchase_bill_notification bn LEFT JOIN  gp_pl_channel_partner cp ON cp.id=bn.channel_partner_id  LEFT JOIN gp_login_table log ON log.user_id=cp.id WHERE log.type='Channel_partner'".$where2.$where3." GROUP BY bn.id".$pg;
            $result2=$this->db->query($query);
            $res1 = $result2->result_array();
            foreach ($res1 as $key => $value) {
                $login_id = $value['login_id'];
                $value['purchase_by'] = $this->get_customer_name($login_id,$search);
                if($value['purchase_by']){
                    array_push($data,$value);
                }
            }
        } 
        if($type=='count') 
        {
            return sizeof($data);
        }else{
            return $data;
        }
    }
    function get_all_executives($search,$by,$limit=NULL,$start=NULL,$type)
    {

        $data=array();
        $details=array();
        if(!empty($search)){
            $keyword = "%{$search}%";
            if(!empty($by)){
                $where = " WHERE (st.name LIKE '$keyword' OR dtype.designation LIKE '$keyword' OR st.created_on LIKE '$keyword' OR nc.name LIKE '$keyword') AND log.type='$by'";
            }else{

                $where = " WHERE (st.name LIKE '$keyword' OR dtype.designation LIKE '$keyword' OR st.created_on LIKE '$keyword' OR nc.name LIKE '$keyword')";
            }
        }else{
            if(!empty($by)){
                $where = " WHERE log.type='$by'";
            }else{
                $where = "";
            }
        }
        
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        
        $query="SELECT st.name,st.created_on,dtype.designation,st.created_by,nc.name as cby,log.type FROM `gp_pl_sales_team_members` st INNER JOIN gp_pl_sales_designation_type dtype ON st.sales_desig_type_id=dtype.id 
            LEFT JOIN gp_login_table log ON st.created_by=log.id
            LEFT JOIN gp_normal_customer nc ON log.user_id=nc.id".$where."
            ORDER BY st.created_by DESC".$pg;
        $result=$this->db->query($query);
       
        if($result->num_rows()>0)
        {
            $res1 = $result->result_array();
            foreach ($res1 as $key => $value) {
                if($value['type']=='executive'){
                    $iid = $value['created_by'];
                    $value['creator'] = $this->getDesignation($iid);//'Team Leader';
                    array_push($data,$value);
                }else{
                    $cby = ($value['type']=='club_member')?($value['cby'].' (Club Member)'):('Jaazzo (Admin)');
                    $value['creator'] = $cby;
                    array_push($data,$value);
                }
            }
        }
        if($type=='count') 
        {
            return sizeof($data);
        }else{
            return $data;
        }
    }
    function getDesignation($id)
    {
        $desg = '';//array();
        $qry = "SELECT * FROM gp_login_table WHERE id='$id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $result = $qry->row_array();
            if($result['type']=='executive'){
                $userid = $result['user_id'];
                if(!empty($search)){
                    $keyword = "%{$search}%";
                    $where = " AND (st.name LIKE '$keyword' OR dtype.designation LIKE '$keyword' )";
                }else{
                        $where = '';
                }
                $qry2 = "SELECT st.*,dtype.designation FROM `gp_pl_sales_team_members` st LEFT JOIN gp_pl_sales_designation_type dtype ON st.sales_desig_type_id=dtype.id 
                    WHERE st.id='$userid'".$where;
                $qry2 = $this->db->query($qry2);
                if($qry2->num_rows()>0)
                {
                    $result2 = $qry2->row_array();
                    $desg = $result2['name']."(".$result2['designation'].")";
                }
            }
            /*if($result['type']=='club_member'){
                $userid = $result['user_id'];
                if(!empty($search)){
                    $keyword = "%{$search}%";
                    if(!empty($by)){
                        $where = " AND (nc.name LIKE '$keyword')AND nc.type='$by'";
                    }else{
                        $where = " AND (nc.name LIKE '$keyword')";
                    }
                }else{
                    if(!empty($by)){
                        $where = "AND nc.type='$by'";
                    }else{
                        $where = '';
                    }
                }
                $qry2 = "SELECT name FROM `gp_normal_customer` nc 
                    WHERE nc.id='$userid'".$where;
                $qry2 = $this->db->query($qry2);
                if($qry2->num_rows()>0)
                {
                    $result2 = $qry2->row_array();
                    $desg['name'] = $result2['name']."(Club Member)";
                    $desg['desg'] ="club_member";
                }
            }*/
            return $desg;
        }   
    }
    function get_all_ba($search,$by,$limit=NULL,$start=NULL,$type)
    {

        $data=array();
        $details=array();
        if(!empty($search)){
            $keyword = "%{$search}%";
            if(!empty($by)){
                $where = " WHERE (ba.name LIKE '$keyword' OR ba.mobil_no LIKE '$keyword' OR ba.company_name LIKE '$keyword' OR ba.office_phno LIKE '$keyword' OR nc.name LIKE '$keyword' OR ba.created_on LIKE '$keyword') AND log.type='$by'";
            }else{

                $where = " WHERE (ba.name LIKE '$keyword' OR ba.mobil_no LIKE '$keyword' OR ba.company_name LIKE '$keyword' OR ba.office_phno LIKE '$keyword' OR nc.name LIKE '$keyword' OR ba.created_on LIKE '$keyword') ";
            }
        }else{
            if(!empty($by)){
                $where = " WHERE log.type='$by'";
            }else{
                $where = "";
            }
        }
        
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        
        $query="SELECT ba.name,ba.mobil_no,ba.company_name,ba.created_on,ba.office_phno,ba.created_by,nc.name as cretor, log.type  FROM pl_ba_registration ba
            LEFT JOIN gp_login_table log ON ba.created_by=log.id
            LEFT JOIN gp_normal_customer nc ON log.user_id=nc.id".$where."
            ORDER BY ba.id DESC".$pg;
        $result=$this->db->query($query);
       
        if($result->num_rows()>0)
        {
            $res1 = $result->result_array();
            foreach ($res1 as $key => $value) {
                if($value['type']=='executive'){
                    $iid = $value['created_by'];
                    $value['creator'] = $this->getDesignation($iid);//'Team Leader';
                    array_push($data,$value);
                }else{
                    $cby = ($value['type']=='club_member')?($value['cretor'].' (Club Member)'):('Jaazzo (Admin)');
                    $value['creator'] = $cby;
                    array_push($data,$value);
                }
            }
        }
        if($type=='count') 
        {
            return sizeof($data);
        }else{
            return $data;
        }
    }
    function get_module_reports()
    {
        $qry = "SELECT id, module_name, description,privillage_group,email,image, DATE_FORMAT(gp_permission_module.created_on,'%d-%b-%Y') as date_time  FROM gp_permission_module";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else
        {
            return array();
        }
    }
    function get_all_transactions($search,$by,$from,$to,$limit=NULL,$start=NULL,$type)
    {
        $data=array();
        $details=array();
        if(!empty($search)){
            $keyword = "%{$search}%";
            if(!empty($by)){
                $where1 = " (transaction_amount LIKE '$keyword' OR narration LIKE '$keyword' OR DATE_FORMAT(transaction_date,'%d-%m-%Y %H:%i') LIKE '$keyword' OR mode LIKE '$keyword' OR trans.cheque_number LIKE '$keyword' OR trans.bank_name LIKE '$keyword' OR DATE_FORMAT(trans.cheque_date,'%d-%m-%Y') LIKE '$keyword') AND (trans.type='$by')";
            }else{

                $where1 = " (transaction_amount LIKE '$keyword' OR narration LIKE '$keyword' OR DATE_FORMAT(transaction_date,'%d-%m-%Y %H:%i') LIKE '$keyword' OR mode LIKE '$keyword' OR trans.cheque_number LIKE '$keyword' OR trans.bank_name LIKE '$keyword' OR DATE_FORMAT(trans.cheque_date,'%d-%m-%Y') LIKE '$keyword') ";
            }
            $where2 = " (nc.name LIKE '$keyword')";
        }else{
            if(!empty($by)){
                $where1 = "  trans.type='$by'";
            }else{
                $where1 = "";
            }
            $where2 = "";
        }
        if(empty($from)&&!empty($to)){
            $to = $to.':00';
            $where3 = " AND transaction_date='".$to."'";
        }elseif(empty($to)&&!empty($from)){
            $from = $from.':00';
            $where3 = " AND transaction_date='".$from."'";
        }elseif(!empty($from)&&!empty($to)){
            $from = $from.':00';
            $to = $to.':00';
            $where3 = " AND transaction_date between '".$from."' and '".$to."'";
        }else{
            $where3 ="";
        }
        // echo $where3;
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        
        $query="select trans.id,trans.type,trans.from,transaction_amount,narration,DATE_FORMAT(transaction_date,'%d-%m-%Y %h:%i %p')as transaction_date,_to,
        mode,trans.cheque_number,trans.bank_name,DATE_FORMAT(trans.cheque_date,'%d-%m-%Y')AS cdate,nc.name as tr_to,log.type as typ
          FROM gp_cp_transaction trans INNER JOIN gp_login_table log ON log.id=trans._to 
                   INNER join gp_normal_customer nc  ON log.user_id=nc.id";
        if($where1){
            $query .=" WHERE ".$where1;
        }   
        if($where2){
            $query .=" OR ".$where2;
        }   
        if($where3){
            $query .= $where3;
        }
        $query .=" ORDER BY trans.id desc".$pg;     
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            $res1 = $result->result_array();
        }else{
            $query2="select trans.id,trans.type,trans.from,transaction_amount,narration,DATE_FORMAT(transaction_date,'%d-%m-%Y %h:%i %p')as transaction_date,_to,
            mode,trans.cheque_number,trans.bank_name,DATE_FORMAT(trans.cheque_date,'%d-%m-%Y')AS cdate,nc.name as tr_to,log.type as typ
                  FROM gp_cp_transaction trans INNER JOIN gp_login_table log ON log.id=trans._to 
                   INNER join gp_normal_customer nc  ON log.user_id=nc.id";
            if($where1){
                $query2 .=" WHERE ".$where1;
            }   
            if($where2){
                $query2 .=" OR ".$where2;
            }   
            if($where3){
                $query2 .= $where3;
            }
            $query2 .=" ORDER BY trans.id desc".$pg; 
            $result2=$this->db->query($query2);
            $res1 = $result2->result_array();
        }
        // echo $this->db->last_query();
            foreach ($res1 as $key => $value) {
                if($value['type']=='channel_partner'){
                    $iid = $value['from'];
                    $value['creator'] = get_cp_name($iid,$search);
                }else{
                    $cby = 'Jaazzo (Admin)';
                    $value['creator'] = $cby;
                }
                array_push($data,$value);
            }
           // echo json_encode($data);
        if($type=='count') 
        {
            return sizeof($data);
        }else{
            return $data;
        }
    }
    function get_all_feedback($search,$limit=NULL,$start=NULL,$type)
    {

        $data=array();
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (name LIKE '$keyword' OR phone LIKE '$keyword' OR type LIKE '$keyword' OR message LIKE '$keyword') ";
        }else{
            $where = "";
        }
        
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        
        $query="SELECT id,name,email,phone,type,message FROM contact ".$where."
            ORDER BY id DESC".$pg;
        $result=$this->db->query($query);
       
        if($result->num_rows()>0)
        {
            $data = $result->result_array();
        }
        if($type=='count') 
        {
            return sizeof($data);
        }else{
            return $data;
        }
    }
    function delete_feedback($datas)
    {
        $this->db->trans_begin();
        $ids = $datas['chck_item_id'];
        foreach ($ids as $key => $id) {
            $this->db->where('id', $id);
            $qry = $this->db->delete('contact');
        }
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
}










