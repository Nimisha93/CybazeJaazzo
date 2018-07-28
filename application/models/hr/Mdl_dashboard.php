<?php

class Mdl_dashboard extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function getdashborad_data()
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $qry = "SELECT COUNT(b.id) as total_branch FROM hr_branch b WHERE b.is_del = 0 AND b.created_by = '$created_by'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $result = $qry->row_array();
            $data['branch'] = $result['total_branch'];
        }else{
            $data['branch'] = 0;
        }
        $qry = "SELECT COUNT(d.id) as total_dept FROM hr_department d WHERE d.is_del = 0 AND d.created_by = '$created_by'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $result = $qry->row_array();
            $data['dept'] = $result['total_dept'];
        }else{
            $data['dept'] = 0;
        }
        $qry = "SELECT COUNT(d.id) as total_active FROM hr_employee d WHERE d.is_del = 0 AND d.status='ACTIVE' AND d.created_by = '$created_by'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $result = $qry->row_array();
            $data['active'] = $result['total_active'];
        }else{
            $data['active'] = 0;
        }
        
        $qry = "SELECT COUNT(d.po_id) as total_post FROM hr_posts d WHERE d.addby = '$created_by' and d.is_del=0";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $result = $qry->row_array();
            $data['post'] = $result['total_post'];
        }else{
            $data['post'] = 0;
        }
       
        
        return $data;
    }

}?>