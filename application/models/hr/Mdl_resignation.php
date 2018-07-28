<?php

class Mdl_resignation extends CI_Model

{


    function __construct()

    {

        parent::__construct();

        $this->load->database();

    }

    public function get_employee()

    {

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];
        $data = array();

        $qry = "select he.id,he.name,he.employee_code from hr_employee he 
        left join hr_salary sal on sal.employee_id = he.id
        where he.is_del!='1' and he.status='Active' and sal.active = 1
        
        
        and he.created_by='$created_by' group by he.id";

        $qry = $this->db->query($qry);


        if ($qry->num_rows() > 0) {

            $data['status'] = true;

            $data['reqemp'] = $qry->result_array();


        } else {

            $data['status'] = false;

            $data['reqemp'] = array();

        }

        return $data;


    }





    public function r_emp_id($res_emp)

    {

        $res1 = $this->db->query("select employee_code from erp_hr_employee where name='$res_emp'");

        if ($res1->num_rows() > 0) {


            return $res1->result_array();


        } else {


            return false;


        }

    }

    public function f_emp_id($fwd_emp)

    {


        $res2 = $this->db->query("select id from erp_hr_employee where name='$fwd_emp'");

        return $res2->result_array();

    }

    public function add_new_res()

    {

        $this->db->trans_begin();

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];


        $created_on = date('Y-m-d H:i:s');

        $dat = $this->input->post('n_date');

        $date1 = convert_to_mysql($dat);


        $date = $this->input->post('r_date');

        $date12 = convert_to_mysql($date);

        $employee_id = $this->input->post('res_emp');


        $data = array(


            'employee_id' => $this->input->post('res_emp'),


            // 'notice_date' => $this->input->post('n_date'),

            'notice_date' => $date1,


            'resignation_date' => $date12,

            'reason' => $this->input->post('reason'),

            'additional_info' => $this->input->post('add_info'),

            'added_by' => $created_by,

            'added_on' => $created_on,
            'status' => 1,

            'is_delete' => '0'

        );

        $this->db->insert('hr_resignation', $data);


        $qry45 = "select * from hr_employee l where l.employee_code='$employee_id'";
        $query = $this->db->query($qry45);


        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            $name = $data['name'];
            $code = $data['employee_code'];

        }


        if ($this->db->trans_status = false) {

            $this->db->trans_roll_back();

            return false;

        } else {

            $this->db->trans_commit();

            return true;


        }


    }

    function get_employee_status()
    {

        $data = array();

        $qry = "select status,id from employee_status order by id desc";

        $qry = $this->db->query($qry);

        if ($qry->num_rows() > 0) {

            $data['status'] = true;

            $data['emp_stat'] = $qry->result_array();


        } else {

            $data['status'] = false;

            $data['emp_stat'] = array();

        }


        return $data;

    }


    function get_list()

    {

        $this->db->trans_begin();

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];




        $data = array();


        $qry = "select hr.*,emp.name,emp.employee_code,emp.id as eid,emp1.id forward_id,emp1.name forward_name,emp1.employee_code forward_code,st.`status` as stat from hr_resignation hr

                Left join hr_employee emp on emp.employee_code=hr.employee_id

                Left join hr_employee emp1 on emp1.id=hr.forward_applicant
                                Left join employee_status st on st.id=hr.`status`


                where hr.is_delete='0'  and hr.added_by='$created_by'   order by hr.id DESC";

        $qry = $this->db->query($qry);


        return $data['res'] = $qry->result_array();


    }

    function get_resignation_by_id($id)

    {

        $session_array = $this->session->userdata('logged_in_admin');

        $data = array();

        $qry = "select hr.*,emp.name,emp.employee_code,emp.id as eid,emp1.id forward_id,emp1.name forward_name,

                emp1.employee_code forward_code from hr_resignation hr

                Left join hr_employee emp on emp.employee_code=hr.employee_id

                Left join hr_employee emp1 on emp1.id=hr.forward_applicant

                where hr.is_delete='0' and hr.id='$id'";

        $qry = $this->db->query($qry);

        return $data['res'] = $qry->result_array();


    }


    public function get_names()

    {

        $session_array = $this->session->userdata('logged_in_admin');


        $d = $this->db->query("select he.id,he.name,he.employee_code from erp_hr_employee he 
    
    left join erp_hr_salary sal on sal.employee_id = he.id
        where he.is_del!='1' and he.status='Active' and sal.active = 1
      group by he.id ");

        return $d->result_array();


    }


    public function get_names_emp()

    {

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];

        $d = $this->db->query("select he.id,he.name,he.employee_code from hr_employee he

         left join hr_salary sal on sal.employee_id = he.id
         where he.is_del!='1' and he.status='Active'  OR (he.is_del!='1' and he.status='Resigned') and sal.active = 1
         and he.created_by='$created_by' group by he.id ");

        return $d->result_array();


    }

//  public function get_emp_names()

//  {

//    $d=$this->db->query("select name,employee_code,id from erp_hr_employee where employee_code=''");

//         return $d->result_array();

//

//  }


    function editresignation($id)

    {


        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];

        $created_on = date('Y-m-d H:i:s');

        $n_date = $this->input->post('n_date');

        $daten = convert_to_mysql($n_date);

        $r_date = $this->input->post('r_date');
        $status = $this->input->post('status');

        $dater = convert_to_mysql($r_date);
        $employee_id = $this->input->post('r_name');
        $data1 = array(

            'employee_id' => $this->input->post('r_name'),


            // 'notice_date' => $this->input->post('n_date'),

            'notice_date' => $daten,

            // 'resignation_date' => $this->input->post('r_date'),

            'resignation_date' => $dater,

            'reason' => $this->input->post('reason'),

            'additional_info' => $this->input->post('add_info'),
            'status' => $status,

            'added_by' => $created_by,

            'added_on' => $created_on,


        );

        $result = $this->db->where('id', $id);

        $result = $this->db->update('hr_resignation', $data1);


        if ($status == '2') {

            $employee_id = $this->input->post('r_name');

            $data = array(


                'status' => "Resigned"


            );

            $this->db->where('employee_code', $employee_id);

            $this->db->update('hr_employee', $data);


        }


        $qry45 = "select * from hr_employee l where l.employee_code='$employee_id'";
        $query = $this->db->query($qry45);


        if ($query->num_rows() > 0) {
            $data = $query->row_array();
            $name = $data['name'];
            $code = $data['employee_code'];

        }
        return $result;


    }

    function delete_resignation_by_id($id)

    {


        $session_array = $this->session->userdata('logged_in_admin');

        $deleted_on = date('Y-m-d H:i:s');

        $data = array(

            'is_delete' => "1",


        );


        $this->db->where('id', $id);

        $qry = $this->db->update('hr_resignation', $data);

        return $qry;

    }
    function delete_resignations($data)
    {
        $itemgrp = $data['itemgrps'];
        $info = array('is_delete' => 1);
        $this->db->where_in('id', $itemgrp);
        $qry = $this->db->update('hr_resignation', $info);

        return $qry;
    }


}

?>