<?php
/**
 * User: kavyasree
 * Date: 7/11/17
 * Time: 5:10 PM
 */

class Mdl_branch extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
     function get_company()
    {
        $qry = "SELECT com.* ,ec.name,es.name state_name,eci.name city_name FROM `hr_company` com
        left join erp_countries ec on ec.id=com.country
        left join erp_states es on es.id=com.state
        left join erp_cities eci on eci.id =com.city
         WHERE is_del='0' ORDER BY id DESC";
       
        $qry = $this->db->query($qry);
        if ($qry && $qry->num_rows() > 0) {
            return $qry->row_array();
        } else {
            return array();
        }
    }
    function get_stationtype(){
        $qry="select * from hr_station_type s order by s.id desc";
        $qry=$this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        }
        else{
            return array();
        }
    }
        function get_station()
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $added_by = $session_array['id'];
        $added_type = $session_array['user_type'];
        $data = array();
        $qry = "select s.id,s.station,s.parent_station,s.contact,s.email,s.adress,s.city,s.state,s.postal_code,s.country,s.added_on,hc.name as country_name,hs.name as state_name,hct.name as city_name from hr_branch s
                 left join hr_countries hc on hc.id=s.country
                 left join hr_states hs on hs.id=s.state
                 left join hr_cities hct on hct.id=s.city
                where s.is_del!='1' order by s.id desc";

        $qry = $this->db->query($qry);
        //echo $this->db->last_query();exit;
        if($qry->num_rows()>0)
        {
            $data['station']=$qry->result_array();

        }
        else{
            $data['station'] =array();
        }
        return $data;

    }
    function creatBranch($vendorData, $data,$created_by)
    {

    $qry = $this->db->insert('hr_branch',$vendorData);
       
        if ($this->db->trans_status() === TRUE)
        {
            $this->db->trans_commit();
            return TRUE;
        }else
        {
            $this->db->trans_rollback();
            return false;
        }
    }
        function get_all_branch()
    {
        $sql = "SELECT v.branch,s.type_name,v.branch_type, v.contact, v.email, v.id, (CASE WHEN LENGTH(IFNULL(v.address,'')) >= 14 THEN CONCAT(SUBSTRING(IFNULL(v.address,''),1,14),'...') ELSE IFNULL(v.address,'') END) AS adds, v.city, v.state,v.country FROM `hr_branch` v LEFT JOIN hr_station_type s on s.id=v.branch_type
               
                WHERE v.is_del = 0 GROUP BY v.id order by v.id desc";
        $sql = $this->db->query($sql);
        if($sql->num_rows()>0){
            return $sql->result_array();
        }else{
            return array();
        }       
    }
     function getbranch($id)
    {
        $qry = "SELECT v.id,v.branch_type, v.branch, v.contact, v.email, v.address, v.city, v.state, v.country FROM hr_branch v WHERE v.id = ? AND v.is_del = 0";
        $qry = $this->db->query($qry, $id);
        if($qry->num_rows()>0)
        {
            $data['status'] = true;
            $data['result'] = $qry->row_array();
            
        }else{
            $data['status'] = false;
            $data['result'] = array();
        }
        return $data;
    }
    function updateBranch($branchId, $vendata)
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $this->db->trans_begin();
        $this->db->where('id', $branchId);
        $qry = $this->db->update('hr_branch', $vendata);
          if ($this->db->trans_status() === TRUE)
        {
            $this->db->trans_commit();
            return TRUE;
        }else
        {
            $this->db->trans_rollback();
            return false;
        }
    }
    function deletebranch($data)
    {
        $itemgrp = $data['itemgrps'];
        $info = array('is_del' => 1);
        $this->db->where_in('id', $itemgrp);
        $qry = $this->db->update('hr_branch', $info);
        return $qry;
    }

}