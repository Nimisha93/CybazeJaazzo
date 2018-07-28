<?php

/**
 *

 */

class Mdl_termination extends CI_Model

{


    function __construct()

    {

        parent::__construct();

        $this->load->database();

    }


    function get__employee()
    {


        $data = array();

        $qry = "select he.id,he.name,he.employee_code from hr_employee he where he.is_del!='1' and he.status='Active'";

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

    function get_req_employee1()

    {

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];


        $data = array();

        $qry = "select he.id,he.name,he.employee_code 
            from hr_employee he where he.is_del!='1' and he.created_by='$created_by'  and
            he.status='Active' OR  (he.is_del!='1' and he.status='Terminated')  ";


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


    function get_termina_type()
    {


        $data = array();

        $qry = "select id,type from hr_termination_type ";

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

    function addterminations()

    {

        $this->db->trans_begin();

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];

        $created_on = date('Y-m-d H:i:s');

        $dat = $this->input->post('termina_date');

        $date1 = convert_to_mysql($dat);


        $dat2 = $this->input->post('notice_dat');

        $date12 = convert_to_mysql($dat2);


        $terrm = $this->input->post('emp_terminatedd');


        $data = array(

            'emp_terminatedd' => $terrm,

            'termina_type' => $this->input->post('termina_type'),

            'termina_date' => $date1,

            'notice_dat' => $date12,

            'description' => $this->input->post('descrip'),

            'status' => "1",

            'added_on' => $created_on,


            'added_by' => $created_by
        );

        $this->db->insert('hr_termination', $data);


        $qry45 = "select * from hr_employee l where l.id='$terrm'";
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


    function get_terminations_by_id()

    {

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];



        $data = array();

       $qry = "select et.id,

                       DATE_FORMAT(et.termina_date, '%d-%b-%Y')termina_date,

                       DATE_FORMAT(et.notice_dat, '%d-%b-%Y')notice_dat,

                       et.description,et.added_on,emp.name,emp.employee_code,tt.type,st.`status`,emp1.id forwardapplicaid,emp1.name forwardapplica,emp1.employee_code forwardapplicacode from hr_termination et

                Left join hr_employee emp on emp.id=et.emp_terminatedd

                Left join hr_employee emp1 on emp1.id=et.forward_applica

                Left join hr_termination_type tt on tt.id=et.termina_type

                Left join employee_status st on st.id=et.`status`

                where et.is_del!='1' and et.added_by='$created_by' order by et.id DESC";


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


    function delete_terminations($data)

    {



        $deleted_on = date('Y-m-d H:i:s');
        $terid = $data['termin_ids'];
        $info = array('is_del' => 1,'del_on'=>$deleted_on);
        $this->db->where_in('id', $terid);
        $qry = $this->db->update('hr_termination', $info);
        return $qry;

    }


    function edit_terminations_by_id($id)

    {

        $data = array();


        /*$qry = "select ec.id,ec.title,ec.added_on,ec.description,ec.`status`,ec.added_on,emp.name,emp.employee_code,st.`status`,emp1.id againstid,emp1.name againstname,emp1.employee_code againstcode from hr_empl_complaints ec

                Left join erp_hr_employee emp on emp.id=ec.complaint_to

                Left join erp_hr_employee emp1 on emp.id=ec.complaint_against

                Left join employee_status st on st.id=emp.`status`

                where ec.id='$id'";

*/

        $qry = "select et.id,et.emp_terminatedd,et.forward_applica as forward, et.termina_date,

                et.notice_dat,et.description,et.added_on,et.status as emp_stat,
        
                emp.name,emp.employee_code,tt.type,st.`status`,emp1.id forwardapplicaid,

                emp1.name forwardapplica,emp1.employee_code forwardapplicacode from hr_termination et

                Left join hr_employee emp on emp.id=et.emp_terminatedd

                Left join hr_employee emp1 on emp1.id=et.forward_applica

                Left join hr_termination_type tt on tt.id=et.termina_type

                Left join employee_status st on st.id=et.`status`

                where et.id = '$id'";

        $qry = $this->db->query($qry);

        if ($qry->num_rows() > 0) {

            $data['status'] = true;

            $data['terminations'] = $qry->row_array();


        } else {

            $data['status'] = false;

            $data['terminations'] = array();

        }


        return $data;

    }


    function editterminations()

    {

        $hiddenid = $this->input->post('termination_hidden');

        $updated_on = date('Y-m-d H:i:s');


        $termina = $this->input->post('termina_date');

        $termina1 = convert_to_mysql($termina);


        $noti = $this->input->post('notice_dat');

        $notice = convert_to_mysql($noti);
        $status = $this->input->post('status');
        //echo $status;exit(); 
        $employee = $this->input->post('emp_terminatedd');


        $data = array(

            'emp_terminatedd' => $employee,

//            'forward_applica' =>$this->input->post('forward_applica'),

            'termina_type' => $this->input->post('termina_type'),

            // 'termina_date' => $this->input->post('termina_date'),

            'notice_dat' => $notice,

            'termina_date' => $termina1,

            'status' => $status,

            'description' => $this->input->post('descrip'),

            'updated_on' => $updated_on,

        );


        $this->db->where('id', $hiddenid);

        $this->db->update('hr_termination', $data);

        if ($status == 2) {

            $data1 = array(

                'status' => "Terminated"

            );

            $this->db->where('id', $employee);

            $this->db->update('hr_employee', $data1);

        }
        $qry45 = "select * from hr_employee l where l.id=' $employee'";
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

    function get_req_employee()

    {

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];



        $data = array();

        $qry = "select he.id,he.name,he.employee_code 
        from hr_employee he where he.is_del!='1' and he.status='Active' and he.created_by='$created_by'";


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

    function get_priority_req()

    {

        $data = array();

        $qry = "select r.type,r.id  from requesition_priority r order by r.id asc";

        $qry = "select r.type,r.id  from requesition_priority r order by r.id asc";

        $qry = $this->db->query($qry);


        if ($qry->num_rows() > 0) {

            $data['status'] = true;

            $data['prior'] = $qry->result_array();

        } else {

            $data['status'] = false;

            $data['prior'] = array();

        }

        return $data;

    }

}

?>