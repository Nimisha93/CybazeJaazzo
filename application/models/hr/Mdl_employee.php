<?php


class Mdl_employee extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

     function add_employee($id)
    {
        $this->db->trans_begin();
        $created_on = date('Y-m-d H:i:s');
        $password = $this->random_password(8);
        $email = $this->input->post('work_email');
        $username = $email;
        $user_psw = $password;
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];

        $company_name = $this->get_company_profile();

        $cname = explode(' ', trim($company_name));

        $first_letter = '';
        foreach ($cname as $key => $value) {

            // $first_letter .= substr($value, 0, 1);

            $first_letter .='JZ';
        }
//var_dump($first_letter);exit();


        // var_dump($id);

        $this->db->trans_begin();
         $date_of_birth = $this->input->post('date_of_birth');
         $date_of_birth = convert_to_mysql($date_of_birth);
         $doj = $this->input->post('date_of_join');

        $doj = convert_to_mysql($doj);
        $name = $this->input->post('name');
        $phone = $this->input->post('phone');
        $blood_group = $this->input->post('blood_group');
        $email = $this->input->post('email');
        $p_phone = $this->input->post('p_phone');
        $gender = $this->input->post('gender');
        $bank_name = $this->input->post('bank_name');
        $bank_ac_no = $this->input->post('bank_ac_no');
        $ifsc_code = $this->input->post('ifsc_code');
        $address = $this->input->post('address');
        $probation = $this->input->post('probation');
        $dept = $this->input->post('department');
        $designation = $this->input->post('designation');
        $salary = $this->input->post('basic_salary');
        $branch = $this->input->post('branch');

        $work_phone = $this->input->post('work_phone');
        $work_email = $this->input->post('work_email');
        $ta = $this->input->post('ta');
        $td = $this->input->post('da');
        $hra = $this->input->post('hra');


        $data = array('name' => $name, 'mobile' => $phone,
            'blood_group' => $blood_group, 'department' => $dept, 'designation' => $designation,
            'email' => $email, 'gender' => $gender, 'dob' => $date_of_birth, 'basic_salary' => $salary,
            'bank_name' => $bank_name, 'bank_ac_no' => $bank_ac_no, 'bank_ifsc' => $ifsc_code,
            'address' => $address, 'parent_contact' => $p_phone, 'probation' => $probation,
            'work_phone' => $work_phone, 'work_email' => $work_email, 'date_of_join' => $doj, 'branch_id' => $branch,
            'ta'=>$ta,'da'=>$td,'hra'=>$hra,
            'created_by' => $id,
            'created_on' => $created_on,
            'created_by' => $created_by
        );
      $qry = $this->db->insert('hr_employee', $data);
       $ins_id = $this->db->insert_id();
       // $ins_id=40;
        $hr_ldg = array(
            'type_id' => $ins_id,
            '_type' => 'EMPLOYEE',
            'group_id' => 24,
            'name' => $ins_id . "_" . $this->input->post('name') . '_ledger'
        );
        $acc_qry = $this->db->insert('erp_ac_ledgers', $hr_ldg);

        //echo $this->db->last_query();exit();
        $hr_led_id = $this->db->insert_id();
        $financial_year = get_financial_year();
                                 $opening = array(
                                    'ledger_id' => $hr_led_id,
                                    'fy_id' => $financial_year ,
                                    'opening_date' =>$created_on
                                    );
        $open_qry = $this->db->insert('erp_ac_opening_balance', $opening);
        $emp_cd=1000+$ins_id;
        $emp_code = $first_letter . '-' . $emp_cd;
        $ins = array('employee_code' => $emp_code, 'ledger_id' => $hr_led_id);
        $this->db->where('id', $ins_id);
        $qry1 = $this->db->update('hr_employee', $ins);


        $salry_det = array('employee_id' => $ins_id,
            'salary' => $salary,
            'from' => $doj,
            'active' => 1);
        $qry2 = $this->db->insert('hr_salary', $salry_det);

        $this->db->trans_complete();
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }

    }

    function get_company_profile()
    {
        return "JAZZO";
    }

    function random_password($length = 8)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }

    function get_all_employee()
    {

        $qry = "select
	ehe.id,	ehe.name,ehe.mobile,ehe.email,ehe.address,ehe.probation,br.branch,
	ehe.gender,ehe.blood_group,ehe.parent_contact,ehds.title as desig,
        ehe.bank_name,ehe.bank_ac_no,bank_ifsc,ehe.work_phone,ehe.work_email,
	ehdp.tittle as dept,sal.salary,sal.id as cur_sal_id,ehe.status,
	ehe.comments,ehe.employee_code,	DATE_FORMAT(ehe.date_of_join, '%d-%b-%Y') date_of_join,
	sal.active
	from hr_employee ehe
        left join hr_branch br on br.id  = ehe.branch_id
        left join hr_designation  ehds on ehds.id = ehe.designation
	left join hr_department ehdp on ehdp.id = ehe.department
	left join hr_salary sal on sal.employee_id = ehe.id
	where sal.active = 1 and ehe.is_del != 1 group by ehe.id
	order by ehe.date_of_join desc";
        $qry = $this->db->query($qry);
//echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }


    function get_all_departments()
    {
        $qry = "select * from hr_department where is_del='0' ORDER BY id DESC";
        $qry = $this->db->query($qry);//echo $this->db->last_query();exit();
        if ($qry && $qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

    function get_all_branch()
    {
        $qry = "select * from hr_branch where is_del='0' ORDER BY id DESC";
        $qry = $this->db->query($qry);//echo $this->db->last_query();exit();
        if ($qry && $qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

    function get_designation_by_dep($dep)
    {
        $qry = "select
				ehd.id,
				ehd.title
				from
				hr_designation ehd
				where ehd.dept_id = '$dep'";
        $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

     function get_employee_by_id($id)
    {
        $qry = "select
	ehe.id,	ehe.name,ehe.mobile,ehe.email,ehe.address,ehe.probation,ehe.branch_id,ehe.ta,ehe.da,ehe.hra,
	ehe.gender,ehe.blood_group,ehe.parent_contact,ehds.title as desig,ehe.department,
        ehe.bank_name,ehe.bank_ac_no,bank_ifsc,ehe.work_phone,ehe.work_email,ehe.designation,ehe.dob,
	ehdp.tittle as dept,sal.salary,sal.id as cur_sal_id,ehe.status,
	ehe.comments,ehe.employee_code,	DATE_FORMAT(ehe.date_of_join, '%d-%b-%Y') date_of_join,
	sal.active
	from hr_employee ehe
        left join hr_branch br on br.id  = ehe.branch_id
        left join hr_designation  ehds on ehds.id = ehe.designation
	left join hr_department ehdp on ehdp.id = ehe.department
	left join hr_salary sal on sal.employee_id = ehe.id
	where ehe.id = '$id' and sal.active = 1 and ehe.is_del != 1 ";
        $qry = $this->db->query($qry);
      //echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            $data = $qry->result_array();
            return $data;
        } else {
            return array();
        }
    }

         function updateEmployee($id)
    {
        $this->db->trans_begin();
        $updated_on = date('Y-m-d H:i:s');
        $session_array = $this->session->userdata('logged_in_admin');
        $updated_by = $session_array['id'];
        $company_name = $this->get_company_profile();
        $name = explode(' ', trim($company_name));
        $date_of_join = $this->input->post('date_of_join');
        // echo $date_of_join;exit();
        $date_of_join = date('Y-m-d', strtotime($date_of_join));
        $dob = $this->input->post('date_of_birth');
        $dob = date('Y-m-d', strtotime($dob));
        $this->db->where('id', $id);

        $data = array(
            'name' => $this->input->post('name'),
            'mobile' => $this->input->post('phone'),
            'email' => $this->input->post('email'),
            'address' => $this->input->post('address'),
            'gender' => $this->input->post('gender'),
            'blood_group' => $this->input->post('blood_group'),
            'parent_contact' => $this->input->post('p_phone'),
            'department' => $this->input->post('department'),
            'designation' => $this->input->post('designation'),
            'bank_name' => $this->input->post('bank_name'),
            'bank_ac_no' => $this->input->post('bank_ac_no'),
            'bank_ifsc' => $this->input->post('ifsc_code'),
            'branch_id' => $this->input->post('branch'),
            'probation' => $this->input->post('probation'),
            'basic_salary' => $this->input->post('basic_salary'),
            'ta'=>$this->input->post('ta'),
            'da'=>$this->input->post('da'),
            'hra'=>$this->input->post('hra'),
            'date_of_join' => $date_of_join,
            'dob' => $dob,
            'work_phone' => $this->input->post('work_phone'),
            'work_email' => $this->input->post('work_email'),
            'updated_on' => $updated_on,
            'updated_by' => $updated_by
        );
        $qry = $this->db->update('hr_employee', $data);

//		$this->db->where('id', $this->input->post('cur_sal_id'));
//		$old_sal = array('to' => date('Y-m-d'),
//						'active' =>0
//						);
//		$up_old_sal = $this->db->update('hr_salary', $old_sal);


        $salry_det = array(
            'salary' => $this->input->post('basic_salary'),


        );
        $this->db->where('employee_id', $id);
        $qry2 = $this->db->update('hr_salary', $salry_det);


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }


    function delete_staff($data)
    {


        $empid = $data['itemgrps'];
//var_dump($empid);exit(); 
       $info = array('is_del' => 1);
        $this->db->where_in('id', $empid);
        $qry = $this->db->update('hr_employee', $info);
        return $qry;
    }

    function join_employee($id)
    {
        $this->db->trans_begin();
        $join_on = date('Y-m-d H:i:s');

        $this->db->where('id', $id);
        $dat_array = array('status' => "Active",
            'join_date' => $join_on
        );
        $query = $this->db->update('hr_employee', $dat_array);
        if ($query) {
            $this->db->where('employee_id', $id);

            $dat_array1 = array('active' => "1",
                // 'from' => $join_on
            );
            $this->db->update('hr_salary', $dat_array1);
        }


        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

     function get_emp_det_by_id($id)
    {
        $qry =  "select e.id, e.name, e.address, e.email, e.join_date,e.dob,e.basic_salary, e.designation,ds.title as desig,br.branch, sal.salary from hr_employee e 
                left join hr_department d on d.id = e.department 
                left join hr_designation ds on ds.id = e.designation 
                left join hr_branch br on br.id=ds.branch_id
                left join hr_salary sal on sal.employee_id = e.id and sal.active = 1
                where e.id = '$id'";
               // echo  $qry; exit();
        $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            return $qry->row_array();
        } else {
            return array();
        }
    }
    function updateStatus($id)
    {
        $this->db->where('id', $id);
        $arr = array('status' => $this->input->post('status'),
            'comments' => ''
        );
        $qry = $this->db->update('hr_employee', $arr);
        return $qry;
    }

    function updateTerminated()
    {
        $this->db->where('id', $this->input->post('employee_id'));
        $arr = array('status' => $this->input->post('ter_status'),
            'comments' => $this->input->post('reason_comment')
        );
        $qry = $this->db->update('hr_employee', $arr);


        return $qry;
    }

    function get_active_employee()
    {

        $qry = "select
	ehe.id,	ehe.name,ehe.mobile,ehe.email,ehe.address,ehe.probation,br.branch,ehe.dob,
	ehe.gender,ehe.blood_group,ehe.parent_contact,ehds.title as desig,ehe.status,
        ehe.bank_name,ehe.bank_ac_no,bank_ifsc,ehe.work_phone,ehe.work_email,
	ehdp.tittle as dept,sal.salary,sal.id as cur_sal_id,ehe.status,
	ehe.comments,ehe.employee_code,	DATE_FORMAT(ehe.date_of_join, '%d-%b-%Y') date_of_join,
	sal.active
	from hr_employee ehe
        left join hr_branch br on br.id  = ehe.branch_id
        left join hr_designation  ehds on ehds.id = ehe.designation
	left join hr_department ehdp on ehdp.id = ehe.department
	left join hr_salary sal on sal.employee_id = ehe.id
	where ehe.status='Active' and sal.active = 1 and ehe.is_del != 1 group by ehe.id
	order by ehe.id desc";
        $qry = $this->db->query($qry);
//echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

    function get_salaryId($id)
    {
        $qry = "select
				*
				from
				hr_salary sal
				where sal.employee_id = $id
				order by sal.id desc";
        $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }


    function hikeSalaryById()
    {
        // $this->db->trans_begin();
       // echo($this->input->post('current_salry_id'));exit();
        $this->db->where('id', $this->input->post('current_salry_id'));


        $from_sal = $this->input->post('from_sal');
        $from_sal = date('Y-m-d', strtotime($from_sal));
        $dat_array = array('to' => $from_sal,
            'active' => 0);
        $qry = $this->db->update('hr_salary', $dat_array);
        //echo $this->db->last_query();exit;
        $ins_array = array('salary' => $this->input->post('cur_sal'),
            'from' => $from_sal,
            'employee_id' => $this->input->post('hike_emp_id'),
            'active' => 1
        );
        $qry = $this->db->insert('hr_salary', $ins_array);

        if($qry)
        {
           return true; 
        }
        else{
            return FALSE;
        }
        // if ($this->db->trans_status() === FALSE) {
        //     $this->db->trans_rollback();
        //     return FALSE;
        // } else {
        //     $this->db->trans_commit();
        //     return true;
        // }
    }

    function get_preference()
    {
        $qry = "select * from preference";
        $res = $this->db->query($qry);
        $res = $res->result();
        return $res;
    }

    function edit_preference($id)
    {
        $qry = "select * from preference where id='$id'";
        $res = $this->db->query($qry);
        $res = $res->row_array();
        $data['arr'] = $res;
        return $data;
    }

    function update_preference()
    {
        $id = $this->input->post('id');
        $title = $this->input->post('title');
        $value = $this->input->post('value');//var_dump($title);var_dump($value);
        $arr = array(
            'title' => $title,
            'value' => $value
        );
        $this->db->where('id', $id);
        $this->db->update('preference', $arr);
        return true;
    }

    function get_employee()
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $added_by = $session_array['id'];
        $added_type = $session_array['type'];
        $typee = $session_array['type'];

        $qry = "select
					ehe.id,
					ehe.name,
					ehe.mobile,
					ehe.email,
					ehe.address,
					ehe.gender,
					ehe.dob,
					ehe.blood_group,
					ehe.parent_contact,
					ehds.title as desig,
					ehdp.tittle as dept,
					sal.salary,
					sal.id as cur_sal_id,
					ehe.status,
					ehe.comments,
					ehe.employee_code,
					DATE_FORMAT(ehe.date_of_join, '%d-%b-%Y') date_of_join,
					sal.active
					from
                                        hr_employee ehe

					left join hr_designation  ehds on ehds.id = ehe.designation
					left join hr_department ehdp on ehdp.id = ehe.department
					left join hr_salary sal on sal.employee_id = ehe.id
					where ehe.status != 'Active' and ehe.status != 'Exit' and ehe.status != 'Resigned' and ehe.status != 'Terminated'
					and sal.active != '0' and ehe.is_del != 1 
                                        and ehe.created_by='$added_by' 
					GROUP BY sal.employee_id
					order by ehe.id desc";
        $qry = $this->db->query($qry);
       
        //echo $this->db->last_query();exit();
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }

    }

    function get_salary_paid()
    {

        $data = array();

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];




        $qry = "select * ,

                        emp.name,emp.status as em_stat,

                        emp.employee_code emp from hr_payment hr

                        left join hr_employee emp on emp.id=hr.emp_id
        
                        where hr.is_del!='1' and hr.pa_status='paid' and hr.addby='$created_by'  order by hr.pm_id DESC ";

        //echo $qry; exit();

        $qry = $this->db->query($qry);


//echo $this->db->last_query();exit;

        if ($qry->num_rows() > 0) {

            $data['status'] = true;

            $data['request'] = $qry->result_array();


        } else {

            $data['status'] = false;

            $data['request'] = array();

        }


        return $data;

    }

    function get_requesition_by_id()

    {

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];


        $data = array();

        $qry = "select hr.id,hr.title,hr.description,hr.added_on,hr.`status`,emp.name,emp.employee_code,emp.status as em_stat,pr.`type`,es.status
                from hr_requisition hr

                Left join hr_employee emp on emp.id=hr.request_by

                Left join requesition_priority pr on pr.id=hr.priority

                Left join employee_status es on es.id=hr.status

                where hr.is_del!='1' and hr.added_by='$created_by'

                order by hr.id DESC";


        $qry = $this->db->query($qry);

        //     echo $this->db->last_query();exit;

        if ($qry->num_rows() > 0) {

            $data['status'] = true;

            $data['request'] = $qry->result_array();


        } else {

            $data['status'] = false;

            $data['request'] = array();

        }


        return $data;

    }

    function get_all_stations()
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
//        $qry = "select st.id,st.station from hr_station st where st.added_by='$created_by' order by st.id desc";
        $qry = "select st.id,st.branch from hr_branch st where st.is_del!='1' order by st.id desc";
        $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }
    function get_designation()
    {

        $session_array = $this->session->userdata('logged_in_admin');
        $added_by = $session_array['id'];
        $added_type = $session_array['type'];
        $typee = $session_array['type'];



        $qry = "SELECT edes . * ,dep.tittle AS dept, hst.id AS sid, hst.branch
                FROM hr_designation edes
                LEFT JOIN hr_department dep ON dep.id = edes.dept_id
                LEFT JOIN hr_branch hst ON hst.id = edes.branch_id
                where  edes.created_by='$added_by' and edes.is_del!='1' 
                ORDER BY edes.id DESC ";
        $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

}