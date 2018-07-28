<?php



class Mdl_report extends CI_Model

{

	

	function __construct()

	{

		parent::__construct();

		$this->load->database();

	}

    function hrsummary()

	{	

		// not used now

		$qry = "SELECT * FROM `erp_hr_departments`";

		$qry = $this->db->query($qry);

		if($qry->num_rows()>0){

			return $qry->result_array();

		} else{

			return array();

		}	 		

	}

    function paysummary()

    {



        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];
  $qry = "SELECT emp.name,emp.id as emp_id,esp.to_date,esp.total_workingdays,
            esp.net_paid,esp.id FROM hr_salary_payroll esp
            left JOIN hr_employee emp on esp.emp_id = emp.id
            where esp.is_paid = '0' and esp.is_del = '0'";
//
//        $qry = "select e.employee_code,e.name,e.status as e_stat, p.* from hr_salary_payroll p
//left join hr_employee e on e.id = p.emp_id
// where p.is_del!='1'  and p.addby='$created_by'  order by p.pm_id DESC
// ";

        $qry = $this->db->query($qry);

        if($qry->num_rows()>0){

            return $qry->result_array();

        } else{

            return array();

        }

    }

	function hrtimeline()

	{	

		$qry = "SELECT ts_attendance.*, erp_hr_employee.name FROM `ts_attendance` join `erp_hr_employee` on ts_attendance.ep_id = erp_hr_employee.id order by date ASC";

		$qry = $this->db->query($qry);

		if($qry->num_rows()>0){

			return $qry->result_array();

		} else{

			return array();

		}			

	}

	function stationslist()

	{	

		// not used now

		$qry = "SELECT ts_attendance.*, erp_hr_employee.name FROM `ts_attendance` join `erp_hr_employee` on ts_attendance.ep_id = erp_hr_employee.id order by date ASC";

		$qry = $this->db->query($qry);

		if($qry->num_rows()>0){

			return $qry->result_array();

		} else{

			return array();

		}	 		

	}

    function departmentslist()

    {


        $session_array = $this->session->userdata('logged_in_admin');
        $added_by = $session_array['id'];
        $added_type = $session_array['type'];
        $typee = $session_array['type'];
//        if($typee == '3'){
//            $where = '';
//        }
//
//        else if($added_type=='employee'){
//
//            $where = '';
//        }
//        else{
//            $where = "and hr_department.added_by='$added_by' and hr_department.added_by_type='$added_type'";
//        }

        $qry = "SELECT *

		

	    from `hr_department` where is_del!=1

	  
            and hr_department.created_by='$added_by' 
	  

	    order by id ASC";

        $qry = $this->db->query($qry);

        if($qry->num_rows()>0){

            return $qry->result_array();

        } else{

            return array();

        }

    }

    function designationslist()

    {

        $qry = "SELECT * FROM `erp_hr_designation` ";

        // join `erp_hr_departments` on erp_hr_designation.dep_head = erp_hr_departments.id

        // join `hr_station` on erp_hr_designation.branch_id = hr_station.id

        $qry = $this->db->query($qry);

        if($qry->num_rows()>0){

            return $qry->result_array();

        } else{

            return array();

        }

    }

	function employeeslist()

	{	

	    $qry = "SELECT erp_hr_employee.*,hr_station.station,erp_hr_departments.title,

	    erp_hr_designation.title as dtitle from `erp_hr_employee`

	    join `hr_station` on erp_hr_employee.station_id = hr_station.id

	    join `erp_hr_departments` on erp_hr_employee.department = erp_hr_departments.id

	    join `erp_hr_designation` on erp_hr_employee.designation = erp_hr_designation.id

	    order by name ASC";

		$qry = $this->db->query($qry);

		if($qry->num_rows()>0){

			return $qry->result_array();

		} else{

			return array();

		}

	}

	function holidayscalendar()

	{	

	    $qry = "SELECT * from `ts_holidays` where status ='0' order by start ASC";

		$qry = $this->db->query($qry);

		if($qry->num_rows()>0){

			return $qry->result_array();

		} else{

			return array();

		}

	}   

	function birthdayscalendar()

	{
        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];

   	    $qry = "SELECT ehe.* from `hr_employee` ehe
	    left join hr_salary sal on sal.employee_id = ehe.id
	    where ehe.status='Active' and sal.active=1 and ehe.is_del!=1
	    and ehe.created_by='$created_by' 
	    group by ehe.id
	    
	    order by dob ASC";

		$qry = $this->db->query($qry);

		if($qry->num_rows()>0){

			return $qry->result_array();

		} else{

			return array();

		}

	}

    function leavescalendar()

    {


        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];

        $qry = "SELECT ts_leaverequest.*,hr_employee.name,ts_leavetypes.leavename from `ts_leaverequest`

		join `hr_employee` on ts_leaverequest.ep_id = hr_employee.id

		join `ts_leavetypes` on ts_leaverequest.lt_id = ts_leavetypes.lt_id

		WHERE ts_leaverequest.status='1'

		 and ts_leaverequest.addby='$created_by'
		 order by levfrom ASC";

        $qry = $this->db->query($qry);

        if($qry->num_rows()>0){

            return $qry->result_array();

        } else{

            return array();

        }

    }



}

?>