<?php

/**
 *

 */

class Mdl_complaints extends CI_Model

{


    function __construct()

    {

        parent::__construct();

        $this->load->database();

    }

    function get_complaints_by_id()

    {

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];

        $data = array();

        $qry = "select ec.id,ec.title,ec.added_on,ec.description,ec.`status`,ec.added_on,emp.name,emp.status as emp_stat,
                emp.employee_code,st.`status` as stat,emp1.id againstid,emp1.name as againstname,emp1.status as e_stat,
                emp1.employee_code againstcode from hr_empl_complaints ec

                Left join hr_employee emp on emp.id=ec.complaint_to

                Left join hr_employee emp1 on emp1.id=ec.complaint_against

                Left join employee_status st on st.id=ec.`status`

                where ec.is_del!='1' and ec.added_by='$created_by' ORDER BY id DESC ";


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

    function get_req_employee()

    {

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];


        $data = array();

        $qry = "select he.id,he.name,he.employee_code from hr_employee he where he.is_del!='1'
        and he.status='Active' and he.created_by='$created_by'";

        $qry = $this->db->query($qry);

        ///  echo $this->db->last_query();exit;

        if ($qry->num_rows() > 0) {

            $data['status'] = true;

            $data['reqemp'] = $qry->result_array();

        } else {

            $data['status'] = false;

            $data['reqemp'] = array();

        }

        return $data;

    }




    function addcomplaint()

    {

//        $this->db->trans_begin();

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];



        $created_on = date('Y-m-d H:i:s');

        $complaint_from = $this->input->post('from');
        $data = array(

            'complaint_to' => $this->input->post('from'),

            'complaint_from' => $this->input->post('from'),

            'title' => $this->input->post('title'),

            'description' => $this->input->post('descrip'),

            'status' => "1",

            'added_on' => $created_on,

            'complaint_against' => $this->input->post('against'),

            'added_by' => $created_by

        );

        $qry = $this->db->insert('hr_empl_complaints', $data);
        $qry45 = "select * from erp_hr_employee l where l.id='$complaint_from'";
        $query = $this->db->query($qry45);


        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            $name = $data['name'];
            $code = $data['employee_code'];

        }


        return $qry;

    }


}

?>

