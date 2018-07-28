<?php
/**
 * User: kavyasree
 * Date: 7/11/17
 * Time: 11:50 PM
 */

class Mdl_department extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
     function add_department($id)
    {
        $this->db->trans_begin();
        $created_on = date('Y-m-d');
        $title = ucfirst($this->input->post('title'));
        $description = $this->input->post('description');
        $data = array('tittle' => $title , 'description' => $description , 'created_by' => $id,'created_on' => $created_on);
        $qry = $this->db->insert('hr_department', $data);
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
    function get_all_departments()
    {
        $qry = "SELECT * FROM `hr_department` WHERE is_del='0' ORDER BY id DESC";
        $qry = $this->db->query($qry);
        if ($qry && $qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }
    function update_department($id,$cid)
    {
        
        $this->db->trans_begin();
        $title = ucfirst($this->input->post('title'));
        $description = $this->input->post('description');
        $data = array('tittle' => $title , 'description' => $description, 'created_by' => $cid);
        $this->db->where('id', $id);
        $qry = $this->db->update('hr_department', $data);
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
    
    function deleteDepartment($data)
    {
        $itemgrp = $data['itemgrps'];
        $info = array('is_del' => 1);
        $this->db->where_in('id', $itemgrp);
        $qry = $this->db->update('hr_department', $info);
        return $qry;
    }
    function get_all_designations()
    {
        $qry = "SELECT desg.*,dept.tittle as department ,dept.id as department_id,br.id as branch_id, br.branch FROM hr_designation desg 
        LEFT JOIN hr_department dept ON desg.dept_id=dept.id
         LEFT JOIN hr_branch br ON br.id=desg.branch_id
        WHERE desg.is_del=0 ORDER BY desg.id DESC";
        $qry = $this->db->query($qry);
        if ($qry && $qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }
    function get_all_branchs(){
       
        $qry = "SELECT * FROM `hr_branch` WHERE is_del='0' ORDER BY id DESC";
        $qry = $this->db->query($qry);
        if ($qry && $qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }

    }
 function add_designation()
    {
        $this->db->trans_begin();
        $curdate =date('Y-m-d H:i:s');

        $session_array = $this->session->userdata('logged_in_admin');
        $by = $session_array['id'];
        $data=array
        (
          "branch_id"=>$this->input->post('branch'),
          "dept_id"=>$this->input->post('dept'),
          "title"=>ucfirst($this->input->post('desig')),
          "is_del"=>0,
          "created_by"=>$by,
          "created_on"=>$curdate
        );
        $result= $this->db->insert('hr_designation',$data);
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
function update_designation($id)
    {
        $this->db->trans_begin();
        $curdate =date('Y-m-d H:i:s');
        $session_array = $this->session->userdata('logged_in_admin');
        $by = $session_array['id'];
       
        $data=array
        (
          "branch_id"=>$this->input->post('branch'),
          "dept_id"=>$this->input->post('dept'),
          "title"=>ucfirst($this->input->post('desig')),
          "updated_by"=>$by,
          "updated_on"=>$curdate
        );
        $this->db->where('id', $id);
        $result= $this->db->update('hr_designation',$data);
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
function deletedesignation($data)
    {
        $itemgrp = $data['itemgrps'];
        $info = array('is_del' => 1);
        $this->db->where_in('id', $itemgrp);
        $qry = $this->db->update('hr_designation', $info);
        return $qry;
    }

}