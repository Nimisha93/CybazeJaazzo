<?php


class Mdl_exit extends CI_Model

{


    function __construct()

    {

        parent::__construct();

        $this->load->database();

    }


    function get_req_employee()
    {

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];



        $data = array();

        $qry = "select he.id,he.name,he.employee_code from hr_employee he 
        
        left join hr_salary sal on sal.employee_id = he.id
        
        where he.is_del!='1' and he.status='Active' and sal.active=1 and he.is_del!=1 
        and he.created_by='$created_by' 
        group by he.id";


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

        $qry = "select he.id,he.name,he.employee_code from hr_employee he 
        
        left join hr_salary sal on sal.employee_id = he.id
        
        where he.is_del!='1' and he.status='Active' or he.status='Exit'  and sal.active=1 and he.is_del!=1
        and he.created_by='$created_by'
        group by he.id";


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

    function get_req_interview()
    {

        $session_array = $this->session->userdata('logged_in_admin');


        $data = array();

        $qry = "select * from conduct_exit_interview";

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


    function get_req_type()
    {

        $session_array = $this->session->userdata('logged_in_admin');


        $data = array();

        $qry = "select * from employee_exit_type ";


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


    function addexit()

    {

        $this->db->trans_begin();

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];



        $created_on = date('Y-m-d H:i:s');


        $dat = $this->input->post('date');

        $date1 = convert_to_mysql($dat);

        $emp = $this->input->post('forward');

        $data = array(

            'employee' => $emp,

            //'exit_date' => $this->input->post('date'),

            'exit_date' => $date1,

            'type' => $this->input->post('type'),

            ///'date'=>$this->input->post('date'),

            'exit_interview' => $this->input->post('interview'),

            'exit_reason' => $this->input->post('descrip'),

            'added_by' => $created_by,

            'added_on' => $created_on,

            //'status' => "1",

        );


        $this->db->insert('hr_emp_exit', $data);


        $emp = $this->input->post('forward');

        $data = array(


            'status' => "Exit"


        );

        $this->db->where('id', $emp);

        $this->db->update('hr_employee', $data);
        $qry45 = "select * from hr_employee l where l.id='$emp'";
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


    function get_exit_by_id()

    {


        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];



        $data = array();


        $qry = "select ex.id,ex.employee,DATE_FORMAT(ex.exit_date, '%d-%b-%Y')exit_date,

                        ex.type,ex.exit_interview,ex.exit_reason, emp.name,emp.employee_code,

                        ty.type,inv.exit_interview from hr_emp_exit ex

                        Left join hr_employee emp on emp.id=ex.employee

                        Left join employee_exit_type ty on ty.id=ex.type

                        Left join conduct_exit_interview inv on inv.id=ex.exit_interview

                        where ex.is_del!='1' and ex.added_by='$created_by' 

                        order by ex.id DESC";


        $qry = $this->db->query($qry);

        if ($qry->num_rows() > 0) {

            $data['status'] = true;

            $data['request'] = $qry->result_array();


        } else {

            $data['status'] = false;

            $data['request'] = array();

        }


        //print_r($data['request']); die();

        //echo $data['name'];

        return $data;


    }



    function delete_exiting($datas)

    {

        $deleted_on = date('Y-m-d H:i:s');
        $terid = $datas['itemgrps'];
        $info = array('is_del' => 1,'delete_on'=>$deleted_on);
        $this->db->where_in('id', $terid);
        $qry = $this->db->update('hr_emp_exit', $info);
        return $qry;


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


    function edit_exit_by_id($id)

    {

        $data = array();

        $qry = "select exh.*,he.name,he.employee_code from hr_emp_exit exh
        left join hr_employee he on he.id=exh.employee
        where exh.id='$id'";


        $qry = $this->db->query($qry);

        if ($qry->num_rows() > 0) {

            $data['status'] = true;

            $data['request'] = $qry->row_array();


        } else {

            $data['status'] = false;

            $data['request'] = array();

        }


        return $data;

    }


    function editexit()

    {

        $hiddenid = $this->input->post('hiddenid');


        $updated_on = date('Y-m-d H:i:s');

        $dat = $this->input->post('date');

        $date1 = convert_to_mysql($dat);
        $req = $this->input->post('req_by1');


        $data = array(

            'employee' => $req,

            'exit_date' => $date1,

            // 'exit_date' => $this->input->post('date'),

            'type' => $this->input->post('type'),

            ///'date'=>$this->input->post('date'),

            'exit_interview' => $this->input->post('interview'),

            'exit_reason' => $this->input->post('descrip'),

            //'updated_on' => $updated_on

        );


        $this->db->where('id', $hiddenid);

        $this->db->update('hr_emp_exit', $data);

        $qry45 = "select * from hr_employee l where l.id='$req'";
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


}

?>