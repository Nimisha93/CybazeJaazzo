<?php
/**
 * User: kavyasree
 * Date: 10/11/17
 * Time: 11:10 PM
 */

class Mdl_requisition extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_all_requisitions()
    {
        $qry = "SELECT com.* ,emp.name,es.status as emp_status,rp.type as priority_name FROM `hr_requisition` com left join employee_status es on es.id=com.status left join hr_employee emp on emp.id=com.request_by 
        left join requesition_priority rp on rp.id=com.priority
        WHERE com.is_del='0' ORDER BY id DESC";
        
        $qry = $this->db->query($qry);
        if ($qry && $qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }
    function get_all_status()
    {
        $qry = "SELECT com.*  FROM `employee_status` com
                 ORDER BY id DESC";
       
        $qry = $this->db->query($qry);
        if ($qry && $qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }
    function get_all_priority()
    {
        $qry = "SELECT com.*  FROM `requesition_priority` com
       
          ORDER BY id DESC";
       
        $qry = $this->db->query($qry);
        if ($qry && $qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }
    function get_all_employee()
    {
        $qry = "SELECT com.*  FROM `hr_employee` com
               where status='active' and is_del='0'
          ORDER BY id DESC";
       
        $qry = $this->db->query($qry);
        if ($qry && $qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }


     function add_request()
    {
        $this->db->trans_begin();
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $created_on = date('Y-m-d H:i:s');
        $data = array(
            'request_by' => $this->input->post('req_by'),
            'title' => $this->input->post('tittle'),
            'priority' => $this->input->post('priority'),
            'description' => $this->input->post('descrp'),
            'status' => "1",
            'added_on' => $created_on,
            'added_by' => $created_by,
        );
        $this->db->insert('hr_requisition', $data);

       

        if ($this->db->trans_status = false) {
            $this->db->trans_roll_back();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    function get_all_requisitions_id($id){
        $qry = "SELECT com.* ,es.status as emp_status FROM `hr_requisition` com
        left join employee_status es on es.id=com.status
       
         WHERE is_del='0' and com.id=$id";
       
        $qry = $this->db->query($qry);
        if ($qry && $qry->num_rows() > 0) {
            return $qry->row_array();
        } else {
            return array();
        }
    }
    function edit_request($id)
    {
        $this->db->trans_begin();
        $session_array = $this->session->userdata('logged_in_admin');
        $updated_by = $session_array['id'];
        $hiddenid = $this->input->post('hiddenid');
        $updated_on = date('Y-m-d H:i:s');
        $data = array(
            'request_by' => $this->input->post('req_by'),
            'title' => $this->input->post('tittle'),
            'priority' => $this->input->post('priority'),
            'description' => $this->input->post('descrp'),
            'status' => $this->input->post('status'),
            'updated_on' => $updated_on
            // 'updated_by' =>$updated_by
        );
        $this->db->where('id', $id);
        $this->db->update('hr_requisition', $data);
        if ($this->db->trans_status = false) {
            $this->db->trans_roll_back();
            return false;
        } else {
            $this->db->trans_commit();
            return true;

        }
    }
function deleterequisition($data)
    {
        $itemgrp = $data['itemgrps'];
        $info = array('is_del' => 1);
        $this->db->where_in('id', $itemgrp);
        $qry = $this->db->update('hr_requisition', $info);
        return $qry;
    }

}