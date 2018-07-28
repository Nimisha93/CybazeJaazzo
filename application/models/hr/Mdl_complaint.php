<?php
/**
 * User: kavyasree
 * Date: 13/11/17
 * Time: 10:15 AM
 */

class Mdl_complaint extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_all_complaints()
    {
        $qry = "SELECT com.*,es.status as emp_status,emp.name as employee FROM `hr_complaints` com
        left join employee_status es on es.id=com.status
        left join hr_employee emp on emp.id=com.complaint_against
        WHERE com.is_del='0' ORDER BY id DESC";

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
        $type = $session_array['type'];
        $data = array(
            'complaint_against' => $this->input->post('com_against'),
            'title' => $this->input->post('tittle'),

            'description' => $this->input->post('descrp'),
            'status' => "1",
            'created_on' => $created_on,
            'created_by' => $created_by,
            'created_type' => $type,
        );
        $this->db->insert('hr_complaints', $data);


        if ($this->db->trans_status = false) {
            $this->db->trans_roll_back();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function deletecomplaint($data)
    {
        $itemgrp = $data['itemgrps'];
        $info = array('is_del' => 1);
        $this->db->where_in('id', $itemgrp);
        $qry = $this->db->update('hr_complaints', $info);
        return $qry;
    }

    function get_all_complaint_id($id)
    {
        $qry = "SELECT com.* ,es.status as emp_status FROM `hr_complaints` com
        left join employee_status es on es.id=com.status
       
         WHERE is_del='0' and com.id=$id";

        $qry = $this->db->query($qry);
        if ($qry && $qry->num_rows() > 0) {
            return $qry->row_array();
        } else {
            return array();
        }
    }


        function get_complaints_by_id()

    {

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];

        $data = array();

        $qry = "select ec.id,ec.title,DATE_FORMAT(ec.created_on, '%d-%m-%Y') as created_on,ec.description,ec.`status`,st.`status` as stat,emp1.id againstid,emp1.name as againstname,emp1.status as e_stat,
                emp1.employee_code againstcode from hr_complaints ec


                Left join hr_employee emp1 on emp1.id=ec.complaint_against

                Left join employee_status st on st.id=ec.`status`

                where ec.is_del!='1' and ec.created_by='$created_by' ORDER BY id DESC ";


        $qry = $this->db->query($qry);

        if ($qry->num_rows() > 0) {

            $data['status'] = true;

            $data['compl'] = $qry->result_array();


        } else {

            $data['status'] = false;

            $data['compl'] = array();

        }


        return $data;

    }

    function edit_request($id)
    {
        $this->db->trans_begin();
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $created_on = date('Y-m-d H:i:s');
        $type = $session_array['type'];
        $data = array(
            'complaint_against' => $this->input->post('com_against'),
            'title' => $this->input->post('tittle'),
            'description' => $this->input->post('descrp'),
            'status' => $this->input->post('status'),
            'updated_on' => $created_on,
            'updated_by' => $created_by,
            'created_type' => $type,
        );
        $this->db->where('id', $id);
        $this->db->update('hr_complaints', $data);

        if ($this->db->trans_status = false) {
            $this->db->trans_roll_back();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
}