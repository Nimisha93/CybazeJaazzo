<?php
/**
 * User: kavyasree
 * Date: 7/11/17
 * Time: 11:50 PM
 */

class Mdl_payroll extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_salary_payment_employee()
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];


        $data = array();
        $qry = "select he.id,he.name,he.employee_code,he.ta,he.da,he.hra
                from hr_employee he
                where he.is_del!='1' and he.status='Active' and he.created_by='$created_by' 
                and he.id NOT IN(select py.emp_id  from hr_payment py where py.tdate = LAST_DAY(now() - interval 1 month ))";


        $qry = $this->db->query($qry);
        // echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            $data['status'] = true;
            $data['reqemp'] = $qry->result_array();
        } else {
            $data['status'] = false;
            $data['reqemp'] = array();
        }
        return $data;
    }

    function get_first_last_day()
    {
        $qry = "SELECT LAST_DAY(now() - interval 1 month ) as last_days,
        concat(date_format(LAST_DAY(now() - interval 1 month),'%Y-%m-'),'01') as first_day";
        $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            return $qry->row_array();
        } else {
            return array();
        }

    }
//dec 7
    function get_employee_det_id($id)
    {


        $qry = "select
                    ehe.id,
                    ehe.name,
                    ehe.mobile,ehe.ta,ehe.da,ehe.hra,
                    ehe.email,
                    ehds.title as desig,
                    ehdp.tittle as dept,
                    ehe.designation,
                    ehe.department,
                    ehe.bank_name,
                    ehe.bank_ac_no,
                    ehe.bank_ifsc,
                    sal.salary,
                    sal.id as salry_id,
                    DATE_FORMAT(ehe.date_of_join,'%d-%m-%Y') as date_of_join,
                    sal.active
                    from
                    hr_employee ehe
                    left join hr_designation  ehds on ehds.id = ehe.designation
                    left join hr_department ehdp on ehdp.id = ehe.department
                    left join hr_salary sal on sal.employee_id = ehe.id
                    where ehe.id = '$id' and sal.active = 1 and ehe.is_del != 1 and sal.active = 1";
        $qry = $this->db->query($qry);
        // echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            $data['emp'] = $qry->row_array();
            $qry1 = $this->db->query("SELECT DATE_FORMAT(DATE(DATE_ADD(esp.to_date, INTERVAL +1 DAY)),'%d-%m-%Y') as from_date                   

            FROM hr_employee emp left JOIN hr_salary_payroll esp on esp.emp_id = emp.id  where emp.id = '$id' and emp.is_del != 1 and esp.is_del != 1 order by esp.id desc LIMIT 1");
          
            $data['date'] = $qry1->row_array();

           // echo $this->db->last_query();exit;
             if(empty($data['date']['from_date'])){      
              $qry2 = $this->db->query("SELECT concat('01',DATE_FORMAT(emp.date_of_join,'-%m-%Y')) as from_date FROM hr_employee emp where emp.id = '$id' and emp.is_del != 1");
                $data['date'] = $qry2->row_array();
                 // echo $this->db->last_query();exit;
             }
             
        } else {
            $data['emp'] = array();
        }
       
        $qry_esi = "select * from preference where title='ESI'";
        $qry_esi = $this->db->query($qry_esi);
        if ($qry_esi->num_rows() > 0) {
            $data['esi'] = $qry_esi->row_array();
        } else {
            $data['esi'] = array();
        }
        $qqrys = "select * from preference where title='company PF'";
        $res1 = $this->db->query($qqrys);
        if ($res1->num_rows() > 0) {
            $data['cmp_pf'] = $res1->row_array();
        } else {
            $data['cmp_pf'] = array();
        }

        $qqry = "select * from preference where title='Employee PF'";
        $res = $this->db->query($qqry);
        if ($res->num_rows() > 0) {
            $data['emp_pf'] = $res->row_array();
        } else {
            $data['emp_pf'] = array();
        }


        return $data;
    }

    function get_esi_perc()
    {

        $qry_esi = "select * from preference where title='ESI'";
        $qry_esi = $this->db->query($qry_esi);
        if ($qry_esi->num_rows() > 0) {
            $data['esi'] = $qry_esi->row_array();
        } else {
            $data['esi'] = array();
        }


        return $data;
    }

    function get_pf_perc()
    {
        $qqry = "select * from preference where title='company PF'";
        $res = $this->db->query($qqry);
        if ($res->num_rows() > 0) {
            $data['cmp_pf'] = $res->row_array();
        } else {
            $data['cmp_pf'] = array();
        }

        $qqry = "select * from preference where title='Employee PF'";
        $res = $this->db->query($qqry);
        if ($res->num_rows() > 0) {
            $data['emp_pf'] = $res->row_array();
        } else {
            $data['emp_pf'] = array();
        }
        return $data;
    }

    function get_bonus_perc()
    {
        $qqry = "select * from preference where title='Bonus'";
        $res = $this->db->query($qqry);
        if ($res->num_rows() > 0) {
            $data['bonus'] = $res->row_array();
        } else {
            $data['bonus'] = array();
        }
        return $data;
    }

    function insert_payment()
    {
        $add_on = date('Y-m-d H:i:s');
        $session_array = $this->session->userdata('logged_in_admin');
        $add_by = $session_array['id'];
        $emp_id = $this->input->post('empl_id');
        $to = $this->input->post('too');
        $adv_date = date('Y-m-d', strtotime($to . ' +1 day'));
         // echo $this->input->post('bonus');exit;
        $status = '1';
        $data = array(
            'emp_id' => $this->input->post('empl_id'),
            'from_date' => date('Y-m-d', strtotime($this->input->post('frm'))),
            'to_date' => date('Y-m-d', strtotime($this->input->post('too'))),
            'total_workingdays' => $this->input->post('wds'),
            'total_leaves' => $this->input->post('lvt'),
            'allowed_leaves' => $this->input->post('lvr'),
            'paid_by' => $this->input->post('mode'),
            'net_paid' => $this->input->post('net'),
            'created_on' => $add_on,
            'created_by' => $add_by,

        );
       $qry = $this->db->insert('hr_salary_payroll', $data);
        $insert_id = $this->db->insert_id();

        $ta = $this->input->post('ta');
        $da = $this->input->post('da');
        $incentive = $this->input->post('inc_amount');
        $bonus = $this->input->post('bonus');

        $hra = $this->input->post('hra');
        $add_ta = $this->input->post('add_ta');
        $hq_allowance = $this->input->post('hq_allowance');

        $ex_hq_allowance = $this->input->post('ex_hq_allowance');
        $outdoor = $this->input->post('outdoor_allowance');
        $othe_allowance = $this->input->post('othe_allowance');
        $ads = $this->input->post('ads');
        $othe_allowance = $this->input->post('othe_allowance');
        $lop = $this->input->post('lop');
        $emp_pf_amount = $this->input->post('emp_pf_amount');
        $cmp_pf_amount = $this->input->post('cmp_pf_amount');

        $esi_amount = $this->input->post('esi_amount');

        $ots = $this->input->post('ots');
        $insurance = $this->input->post('insurance');


        if (!empty($bonus)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'BONUS',
                'amount_value' => $bonus));
        }
        if (!empty($ta)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'TA',
                'amount_value' => $ta));
        }
        if (!empty($da)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'DA',
                'amount_value' => $da));
        }
        if (!empty($incentive)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'INCENTIVE',
                'amount_value' => $incentive));
        }
        if (!empty($hra)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'HRA',
                'amount_value' => $hra));
        }
        if (!empty($add_ta)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'ADDITIONAL_TA',
                'amount_value' => $add_ta));
        }
        if (!empty($hq_allowance)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'HEADQAURTER_ALLOWANCE',
                'amount_value' => $hq_allowance));
        }
        if (!empty($ex_hq_allowance)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'EX_HEADQAURTER_ALLOWANCE',
                'amount_value' => $ex_hq_allowance));
        }
        if (!empty($outdoor)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'OUTDOOR_ALLOWANCE',
                'amount_value' => $outdoor));
        }
        if (!empty($othe_allowance)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'OTHER_ALLOWANCE',
                'amount_value' => $othe_allowance));
        }
        if (!empty($ads)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'DEDUCTION', 'title' => 'ADVANCE_SALARY',
                'amount_value' => $ads));
        }
        if (!empty($lop)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'DEDUCTION', 'title' => 'LOP',
                'amount_value' => $lop));
        }
        if (!empty($ots)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'DEDUCTION', 'title' => 'OTHER',
                'amount_value' => $ots));
        }
        if (!empty($insurance)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'DEDUCTION', 'title' => 'INSURANCE',
                'amount_value' => $insurance));
        }
        if ($emp_pf_amount != 0) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'DEDUCTION',
                'title' => 'PF_EMPLOYEE', 'amount_value' => $emp_pf_amount, 'amount_percentage' => $this->input->post('emp_pf_perc')));
        }
        if ($cmp_pf_amount != 0) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'DEDUCTION',
                'title' => 'PF_COMPANY', 'amount_value' => $cmp_pf_amount, 'amount_percentage' => $this->input->post('cmp_pf_perc')));
        }
        if ($esi_amount != 0) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'DEDUCTION',
                'title' => 'ESI', 'amount_value' => $esi_amount, 'amount_percentage' => $this->input->post('esi_perc')));
        }


        $advance_salary_old = $this->input->post('advance_old');
        $date = date('Y-m-d H:i:s');

       // echo $advance_salary_old;exit();
        if(!empty($ads)){
            if ($ads == $advance_salary_old) {
                $array = array('emp_id' => $emp_id, 'is_paid' => '1');
                $this->db->where($array);
                $this->db->update('hr_advancesalary', array('is_paid' => '0'));
            } else {
                $array = array('emp_id' => $emp_id);
                $this->db->where($array);
                $this->db->update('hr_advancesalary', array('is_paid' => '0'));
                $amount = $advance_salary_old - $ads;
                $this->db->insert('hr_advancesalary', array('emp_id' => $emp_id, 'amount' => $amount, 'salary_date' => $adv_date, 'is_paid' => '1'));

            }
        }

        return $qry;
    }

    function get_advance_salary()
    {
      
        $data = array();
        $qry = "select emp.name empname,emp.employee_code code,femp.name forward,femp.employee_code fcode,emp.id emp_id,
                ad.title,ad.amount,
                DATE_FORMAT(ad.salary_date, '%d-%b-%Y') as salary_date,
                ad.description,ad.id
                from hr_advancesalary ad
                Left join hr_employee emp on emp.id=ad.emp_id
                Left join hr_employee femp on femp.id=ad.forward_id
                where ad.is_del!='1' and ad.is_paid='1'";
       
        $qry = $this->db->query($qry);
       
       
        if ($qry->num_rows() > 0) {
             $data['cu']=$qry->num_rows();
            $data['advance'] = $qry->result_array();

        } else {
            $data['advance'] = array();
        }
        return $data;
    }

function get_advsal_details_by_id()
    {
      $emp_id = $this->input->post('emp_id');
      $date_from = DATE('Y-m-d',strtotime($this->input->post('from_date')));
      $to=$this->input->post('to_date');
      $date_to = DATE('Y-m-d',strtotime($to));
      $qry1= $this->db->query("select eas.amount,id from hr_advancesalary eas WHERE eas.emp_id = '$emp_id' and eas.salary_date between '$date_from' and '$date_to' and eas.is_paid = '1'  and eas.is_del!='1'");
      //echo $this->db->last_query();exit();
      $qry1 =  $qry1->row_array();
      if($qry1['amount']){
        $data['advance_salary_org'] = $qry1['amount'];
        $data['advance_id'] = $qry1['id'];
      }else{
        return false;
      }
      return $data;
    }
    
    function get_req_employee()
    {

        $data = array();
        $qry = "select he.id,he.name,he.employee_code from hr_employee he where he.is_del!='1' and he.status='Active'";


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
    function get_adv_lastdate_by_id($id)
    {
   
       $qry = "SELECT DATE_FORMAT(DATE(DATE_ADD(esp.to_date, INTERVAL +1 DAY)),'%d-%m%-%Y') as to_date FROM hr_salary_payroll esp where esp.emp_id = '$id' and esp.is_del = '0' order by esp.id desc LIMIT 1";
        $qry = $this->db->query($qry);
        //echo $this->db->last_query();exit;

        if($qry->num_rows()>0){     
          $data = $qry->row_array();
        } else{
          $data = array();
        }
        return $data;
    }


    function addadvancesalary()
    {
        $this->db->trans_begin();
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];

        $date = $this->input->post('advance_date');
        $date = date('Y-m-d', strtotime($date));

        $created_on = date('Y-m-d H:i:s');


        $id = $this->input->post('emp_name');
//echo $this->getadvancesalary($id);exit();

        $amnt = $this->getadvancesalary($id) + $this->input->post('advance_amount');

        $qrs = "UPDATE hr_advancesalary SET is_paid='0'
                WHERE emp_id = '$id' and is_paid='1' ";
        $qrs = $this->db->query($qrs);

        $data = array(
            'emp_id' => $id,
            'salary_date' => $date,
            'amount' => $amnt,
            'status' => "1",
//            'title' => $this->input->post('advance_title'),
//            'description' => $this->input->post('additional'),
            'added_on' => $created_on,
            'added_by' => $created_by

        );
        $this->db->insert('hr_advancesalary', $data);


        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }


    }

    function getadvancesalary($id)
    {
        $qry = "select amount from hr_advancesalary where emp_id='$id' and is_paid='1' and is_del!='1'";
        $res = $this->db->query($qry);

        if ($res->num_rows() > 0) {
            $result = $res->row();
            $res = $result->amount;
        } else {
            $res = 0;
        }
        //var_dump($res);exit();
        return $res;

    }

    function get_advance_salary_by_id($id)
    {
        $data = array();
        $qry = "select emp.name empname,emp.employee_code code,femp.name forward,femp.employee_code fcode,
                ad.title,ad.amount,ad.salary_date,ad.description,ad.id,ad.forward_id,ad.emp_id
                from hr_advancesalary ad
                Left join hr_employee emp on emp.id=ad.emp_id
                Left join hr_employee femp on femp.id=ad.forward_id
                where ad.id='$id' and ad.is_del!='1'";
      
        $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            $data['status'] = true;
            $data['advance'] = $qry->row_array();

        } else {
            $data['status'] = false;
            $data['advance'] = array();
        }

        return $data;
    }


    function get_advance_salary_by_emp($id)
    {
        $data1 = array();
        $qry = "select emp.name empname,emp.employee_code code,femp.name forward,femp.employee_code fcode,
                ad.title,ad.amount,
                DATE_FORMAT(ad.salary_date, '%d-%b-%Y') as salary_date,
                ad.description,ad.id
                from hr_advancesalary ad
                Left join hr_employee emp on emp.id=ad.emp_id
                Left join hr_employee femp on femp.id=ad.forward_id
                where ad.is_del!='1' and ad.is_paid='1'";
     
        $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            $data1['emp_count']=$qry->num_rows();
            $data1['status'] = true;
            $data1['advance'] = $qry->row_array();

        } else {
            $data1['emp_count']=0;
            $data1['status'] = false;
            $data1['advance'] = array();
        }

        return $data1;
    }
    function editadvancesalary()
    {
        $hiddenid = $this->input->post('advance_hidden');
        $updated_on = date('Y-m-d H:i:s');
        $date = $this->input->post('advance_date');
        $date = date('Y-m-d', strtotime($date));
        $data = array(
            'emp_id' => $this->input->post('emp_name'),
//            'forward_id' => $this->input->post('forward_to'),
            'amount' => $this->input->post('advance_amount'),
            'salary_date' => $date,
            'status' => "1",
            'updated_on' => $updated_on,
        );
        $this->db->where('id', $hiddenid);
        $this->db->update('hr_advancesalary', $data);


        if ($this->db->trans_status = false) {

            $this->db->trans_roll_back();
            return false;
        } else {
            $this->db->trans_commit();
            return true;

        }
    }

    function delete_advancesal($data)
    {
        $itemgrp = $data['itemgrps'];
        $deleted_on = date('Y-m-d H:i:s');
        $data = array(
            'is_del' => "1",
            'del_on' => $deleted_on

        );

        $qry = $this->db->where_in('id', $itemgrp);
        $qry = $this->db->update('hr_advancesalary', $data);
        return $qry;
    }


   function salary_details()
    {


        $qry = "SELECT emp.name,emp.id as emp_id,DATE_FORMAT(esp.to_date, '%d-%b-%Y') as to_date,esp.total_workingdays, esp.net_paid,esp.id ,
        esp.paid_by FROM hr_salary_payroll esp left JOIN hr_employee emp on esp.emp_id = emp.id where esp.is_paid = '0' and esp.is_del = '0' order by esp.to_date DESC";
        $qry = $this->db->query($qry);//echo $this->db->last_query();exit();
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }


    }
    function getEmpLedgerId($emp_id)
    {
        $id = $this->db->select('id')
            ->where('_type','EMPLOYEE')
            ->where('type_id',$emp_id)
            ->limit(1)
            ->get('erp_ac_ledgers')
            ->row('id');
        if($id) {
           return $id;
        }else{
            return false;
        }
    }

   function pay_salary($id,$datas)
    {

        $this->db->trans_start();
        $payDate = $datas['p_date'];

        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];

        $payDate = convert_to_mysql($payDate);
        $this->db->where('id', $id);
        $this->db->update('hr_salary_payroll', array('is_paid' => 1, 'paid_date' => $payDate));
        $no =get_number();
        $tot = $datas['net_paid'];
        $data = array(
            'entrytype_id'=>2,
            '_type'=>'SALARY',
            'fy_id' => $fy_id,
            'type_id'=>$id,
            'number'=>$no,
            'date'=>$payDate,
            'dr_total'=>$tot,
        );
        $this->db->insert('erp_ac_entries',$data);
        $entry_id = $this->db->insert_id();

        $ledger_payment_dr = $this->getEmpLedgerId($datas['emp_id']);
        if($datas['paid_by']=='CASH')
            $ledger_payment_cr = 32;
        else
            $ledger_payment_cr = 35;
        

        $entry_items_cr = array(
            'entry_id' => $entry_id,
            'ledger_id' => $ledger_payment_cr,
            'fy_id' => $fy_id,
            'amount' => $tot,
            'dc' => 'Cr',
            'created_date' => date('Y-m-d')
        );
         
        $entry_items_dr = array(
            'entry_id' => $entry_id,
            'ledger_id' => $ledger_payment_dr,
            'fy_id' => $fy_id,
            'amount' => $tot,
            'dc' => 'Dr',
            'created_date' => date('Y-m-d')
        );
        $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);
        $entry_dr = $this->db->insert('erp_ac_entryitems', $entry_items_dr);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    function get_paid_salary_details()
    {

        $qry = "SELECT emp.name,DATE_FORMAT(esp.to_date, '%d-%b-%Y') as to_date,esp.total_workingdays,esp.net_paid,esp.id,DATE_FORMAT(esp.paid_date, '%d-%b-%Y') as paid_date 
            FROM hr_salary_payroll esp
            left JOIN hr_employee emp on esp.emp_id = emp.id where esp.is_paid = '1' order by esp.id DESC";
        $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }

    }

    function get_all_employee()
    {
        $qry = "SELECT emp.id, emp.name,emp.id FROM hr_employee emp where emp.status='Active' order by emp.name asc
        ";
        $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

    function get_salary_details_by_id($id, $sid)
    {

        //DATE(DATE_ADD(esp.to_date, INTERVAL +1 DAY)) as to_date,
        $qry = "SELECT esi.salary,esp.id as esp_id,DATE_FORMAT(esp.from_date,'%d-%m-%Y') as from_date, DATE_FORMAT(esp.to_date,'%d-%m-%Y') as todate,esp.total_workingdays, esp.total_leaves,esp.paid_by,esp.allowed_leaves, emp.* ,DATE_FORMAT(emp.date_of_join,'%d-%m-%Y') as dateofjoin,ehds.title,ehdp.tittle, (select eas.amount from hr_advancesalary eas WHERE eas.emp_id = emp.id and eas.is_paid = '1'  and eas.is_del!='1') as advance_salary, (select value from preference WHERE title = 'Bonus') as bonus, (select value from preference WHERE title = 'Incentive') as incentive, (select value from preference WHERE title = 'ESI') as esi, (select value from preference WHERE title = 'Employee PF') as pf_employee, (select value from preference WHERE title = 'company PF') as pf_company FROM hr_employee emp left JOIN hr_salary_payroll esp on esp.emp_id = emp.id LEFT JOIN hr_salary esi on esi.employee_id = emp.id left join hr_designation ehds on ehds.id = emp.designation left join hr_department ehdp on ehdp.id = emp.department where esp.id = '$sid' and emp.status='Active' and esi.active = '1'";


        $qry = $this->db->query($qry);
//echo $this->db->last_query();exit();
        if ($qry->num_rows() > 0) {
            $data['basic'] = $qry->result_array();
            $emp_id = $data['basic'][0]['id'];
//var_dump($emp_id);exit();
            $qry3 = $this->db->query("select eas.amount,id from hr_advancesalary eas WHERE eas.emp_id = '$id' and eas.is_paid = '1'  and eas.is_del!='1'");
            $qry3 = $qry3->row_array();//echo $this->db->last_query();exit();
            $data['advance_salary_org'] = $qry3['amount'];
            $data['advance_id'] = $qry3['id'];
            $qry2 = "SELECT esu.* FROM `hr_salary_payroll` esp LEFT JOIN hr_salary_updations esu on esu.salary_id = esp.id WHERE esp.id = '$sid'";
            $qry2 = $this->db->query($qry2);//echo $this->db->last_query();exit();
            if ($qry2->num_rows() > 0) {
                $data['other'] = $qry2->result_array();
            }


        } else {
            $data['salary'] = array();
        }
        return $data;
    }


    function update_salary($id, $cid)
    {

        $this->db->trans_begin();

        $add_on = date('Y-m-d H:i:s');
        $session_array = $this->session->userdata('logged_in_admin');
        $add_by = $session_array['id'];
        $emp_id = $this->input->post('empl_id');
        //  echo json_encode($this->input->post());exit;
        $status = '1';
        $data = array(
            'emp_id' => $this->input->post('empl_id'),
            'from_date' => date('Y-m-d', strtotime($this->input->post('frm'))),
            'to_date' => date('Y-m-d', strtotime($this->input->post('too'))),
            'total_workingdays' => $this->input->post('wds'),
            'total_leaves' => $this->input->post('lvt'),
            'allowed_leaves' => $this->input->post('lvr'),
            'paid_by' => $this->input->post('mode'),
            'net_paid' => $this->input->post('net'),
            'created_on' => $add_on,
            'created_by' => $add_by,

        );


        $this->db->where('id', $id);
        $qry = $this->db->update('hr_salary_payroll', $data);


        $this->db->delete('hr_salary_updations', array('salary_id' => $id));


        $ta = $this->input->post('ta');
        $da = $this->input->post('da');
        $incentive = $this->input->post('inc_amount');
        $bonus = $this->input->post('bonus');

        $hra = $this->input->post('hra');
        $add_ta = $this->input->post('add_ta');
        $hq_allowance = $this->input->post('hq_allowance');

        $ex_hq_allowance = $this->input->post('ex_hq_allowance');
        $outdoor = $this->input->post('outdoor_allowance');
        $othe_allowance = $this->input->post('othe_allowance');
        $ads = $this->input->post('ads');
        $othe_allowance = $this->input->post('othe_allowance');
        $lop = $this->input->post('lop');
        $emp_pf_amount = $this->input->post('emp_pf_amount');
        $cmp_pf_amount = $this->input->post('cmp_pf_amount');

        $esi_amount = $this->input->post('esi_amount');

        $ots = $this->input->post('ots');
        $insurance = $this->input->post('insurance');

        $insert_id = $id;

        if (!empty($bonus)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'BONUS',
                'amount_value' => $bonus ));
        }
        if (!empty($ta)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'TA',
                'amount_value' => $ta));
        }
        if (!empty($da)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'DA',
                'amount_value' => $da));
        }
        if (!empty($incentive)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'INCENTIVE',
                'amount_value' => $incentive));
        }
        if (!empty($hra)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'HRA',
                'amount_value' => $hra));
        }
        if (!empty($add_ta)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'ADDITIONAL_TA',
                'amount_value' => $add_ta));
        }
        if (!empty($hq_allowance)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'HEADQAURTER_ALLOWANCE',
                'amount_value' => $hq_allowance));
        }
        if (!empty($ex_hq_allowance)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'EX_HEADQAURTER_ALLOWANCE',
                'amount_value' => $ex_hq_allowance));
        }
        if (!empty($outdoor)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'OUTDOOR_ALLOWANCE',
                'amount_value' => $outdoor));
        }
        if (!empty($othe_allowance)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'EARNING', 'title' => 'OTHER_ALLOWANCE',
                'amount_value' => $othe_allowance));
        }
        if (!empty($ads)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'DEDUCTION', 'title' => 'ADVANCE_SALARY',
                'amount_value' => $ads));
        }
        if (!empty($lop)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'DEDUCTION', 'title' => 'LOP',
                'amount_value' => $lop));
        }
        if (!empty($ots)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'DEDUCTION', 'title' => 'OTHER',
                'amount_value' => $ots));
        }
        if (!empty($insurance)) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'DEDUCTION', 'title' => 'INSURANCE',
                'amount_value' => $insurance));
        }
        if ($emp_pf_amount != 0) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'DEDUCTION',
                'title' => 'PF_EMPLOYEE', 'amount_value' => $emp_pf_amount, 'amount_percentage' => $this->input->post('emp_pf_perc')));
        }
        if ($cmp_pf_amount != 0) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'DEDUCTION',
                'title' => 'PF_COMPANY', 'amount_value' => $cmp_pf_amount, 'amount_percentage' => $this->input->post('cmp_pf_perc')));
        }
        if ($esi_amount != 0) {
            $this->db->insert('hr_salary_updations', array('salary_id' => $insert_id, 'type' => 'DEDUCTION',
                'title' => 'ESI', 'amount_value' => $esi_amount, 'amount_percentage' => $this->input->post('esi_perc')));
        }


        $advance_salary_old = $this->input->post('advance_old');
        $advance_salary = $this->input->post('ads');
        $advance_id = $this->input->post('advance_id');
        $am = $advance_salary_old - $advance_salary;
        //if(!empty($advance_salary)){
            if ($advance_salary == $advance_salary_old) {
                $data1 = array('amount' => $advance_salary, 'is_paid' => '0');
            } else {
                $data1 = array('amount' => $am, 'is_paid' => '1');
            }
       // }   
        $array = array('id' => $advance_id);
        $this->db->where($array);
        $this->db->update('hr_advancesalary', $data1);
        $this->db->trans_complete();
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    function delete_salary($data)
    {
        $itemgrp = $data['itemgrps'];
        //exit;
        $this->db->trans_start();
        $this->db->where_in('id', $itemgrp);
        $this->db->update('hr_salary_payroll', array('is_del' => 1));
        $this->db->where_in('salary_id', $itemgrp);
        $this->db->delete('hr_salary_updations');
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
        } else {
            $this->db->trans_commit();
            return TRUE;
        }
    }

    function get_bill_data_by_id($id)
    {

        $qry = "SELECT emp.*,esp.to_date,esp.allowed_leaves,esp.total_leaves,esp.from_date,esp.net_paid,
         esp.total_workingdays,esp.net_paid,esp.id as salary_id,(select esi.salary as amount from hr_salary esi
         WHERE esi.employee_id = emp.id and esi.active = '1') as basic_pay,ed.tittle as department,
         eds.title as designation, esp.paid_date FROM hr_salary_payroll esp
         left JOIN hr_employee emp on esp.emp_id = emp.id
         LEFT JOIN hr_department ed on ed.id = emp.department
         LEFT JOIN hr_designation eds on eds.id = emp.designation
         where esp.is_paid = '1' and esp.id = '$id'";
        $qry = $this->db->query($qry);

        if ($qry->num_rows() > 0) {
            $data['basic'] = $qry->result_array();//echo $this->db->last_query();exit();

            $qry2 = "SELECT esu.* FROM `hr_salary_payroll` esp LEFT JOIN hr_salary_updations esu on esu.salary_id = esp.id WHERE esp.id = '$id'";
            $qry2 = $this->db->query($qry2);
            if ($qry2->num_rows() > 0) {
                $data['other'] = $qry2->result_array();
            }

        } else {
            $data['salary'] = array();
        }
        return $data;
    }


    function get_salary_paid_report()
    {
        $dets=array();
        $qry1 = "SELECT emp.* FROM hr_employee emp 
        WHERE  status='Active'  ORDER BY emp.id DESC";
        $qry1 = $this->db->query($qry1);
        if ($qry1 && $qry1->num_rows() > 0) {
            $data['emp'] = $qry1->result_array();
            foreach ($data['emp'] as $key=>$emp){
                $id = $emp['id'];
                $qry="SELECT e.name,DATE_FORMAT(p.from_date, '%d-%b-%Y') AS from_date,DATE_FORMAT(p.to_date, '%d-%b-%Y') AS 
                      to_date,p.total_workingdays,p.total_leaves,p.allowed_leaves,p.net_paid,si.salary as basicsalary,p.id,e.name
                      FROM `hr_salary_payroll` p LEFT JOIN hr_employee e on e.id=p.emp_id
                      LEFT JOIN hr_salary si on si.employee_id=e.id
                      WHERE si.active='1' and p.is_paid='1' and e.id='$id'";
                  $qry = $this->db->query($qry);
                if($qry->num_rows()>0)
                {
                    $data['employees']= $qry->result_array();
                    foreach ($data['employees'] as $key1=>$details){
                        $salid=$details['id'];
                        array_push($dets,$details);
                 }

                } 
               else{

                }
            } 
        } else {
            return array();
        }
        return $dets;

    }

    

    function get_deduct()
    {

        $session_array = $this->session->userdata('logged_in_admin');

        $added_by = $session_array['id'];

        $added_type = $session_array['type'];

        $typee = $session_array['type'];

        $data = array();

        $qry = "select ded.title title,ded.id,ded.description,ded.amount,ded.deduct_date,emp.name name,emp.status  em_stat,emp.employee_code,emp1.name applicant

                 from hr_deduction ded

                 LEFT JOIN hr_employee emp ON emp.id=ded.emp_id

                 LEFT JOIN hr_employee emp1 ON emp1.id=ded.forward_id

                 where  ded.is_del!='1' and ded.added_by='$added_by' and ded.added_by_type='$added_type' order by ded.id desc";

        $qry = $this->db->query($qry);

        if ($qry) {

            $data['deduct'] = $qry->result_array();

        } else {

            $data['deduct'] = array();

        }

        return $data;

    }

    function get_bonus()
    {

        $session_array = $this->session->userdata('logged_in_admin');

        $added_by = $session_array['id'];

        $added_type = $session_array['type'];

        $typee = $session_array['type'];

        $data = array();

        $qry = "select b.*,emp.name,emp.employee_code,emp.status em_stat,emp1.name forname,emp1.employee_code forcode from hr_employee_bonus b

                 LEFT JOIN hr_employee emp ON emp.id=b.emp_id

                 left join hr_employee emp1 on emp1.id=b.forward_applic

                where  b.del_status!='1' and b.added_by='$added_by' and b.added_by_type='$added_type' order by b.id desc";


        ///echo $qry;exit();

        $qry = $this->db->query($qry);


        if ($qry) {

            $data['bonus'] = $qry->result_array();

        } else {

            $data['bonus'] = array();

        }

        return $data;

    }

function get_all_pf()
    {
    	$qry ="SELECT ehsp.id,ehsp.from_date, ehsp.to_date,ehsp.net_paid,ehe.name,ehe.id as emp_id ,ehe.employee_code from hr_salary_payroll ehsp 
LEFT JOIN hr_employee ehe ON ehsp.emp_id = ehe.id WHERE ehsp.is_paid = '1' GROUP BY ehsp.id ORDER BY ehsp.id DESC";
		$qry = $this->db->query($qry);
        if ($qry && $qry->num_rows() > 0) {
            $data['emp'] = $qry->result_array();
            foreach ($data['emp'] as $key => $value) {
                  $id = $value['id'];
                  $qry1 = "SELECT ehsu.amount_value FROM hr_salary_updations ehsu where ehsu.salary_id = '$id'and ehsu.type = 'DEDUCTION' AND ehsu.title = 'PF_COMPANY'";

                  $qry1 = $this->db->query($qry1);
                  $qry1 = $qry1->row();
 if($qry1)
{
                  $cpf = $qry1->amount_value;
  
 $data['emp'][$key]['cpf'] = $cpf;
}

                 
                  $qry2 = "SELECT ehsu.amount_value FROM hr_salary_updations ehsu where ehsu.salary_id = '$id' and ehsu.type = 'DEDUCTION' AND ehsu.title = 'PF_EMPLOYEE'";
                  $qry2 = $this->db->query($qry2);
                  $qry2 = $qry2->row();
if($qry2)
{
                  $epf = $qry2->amount_value;
  
$data['emp'][$key]['epf'] = $epf;
}

                  
            }
            return $data;
        }else{
        	return array();
        }
    }
     function get_all_esi()
    {

        $session_array = $this->session->userdata('logged_in_admin');

        $added_by = $session_array['id'];

        $added_type = $session_array['type'];

        $typee = $session_array['type'];

        $data = array();

         $qry = "SELECT emp.name , emp.employee_code, emp.id AS emp_id, esp.to_date, esp.from_date, esp.total_workingdays, esu . * , esp.net_paid, esp.id
FROM hr_salary_payroll esp 
LEFT JOIN hr_employee emp ON esp.emp_id = emp.id 
LEFT JOIN hr_salary_updations esu ON esp.id = esu.salary_id  WHERE esp.is_paid = '1' AND esp.is_del = '0' AND esu.type = 'DEDUCTION' AND esu.title = 'ESI'";

        ///echo $qry;exit();

        $qry = $this->db->query($qry);


        if ($qry) {

            $data['pf'] = $qry->result_array();

        } else {

            $data['pf'] = array();

        }

        return $data;

    }
    function advance_salary_by_emp_id($id)
    {
        $qry = "SELECT DATE_FORMAT(ehas.salary_date, '%a, %d-%b-%Y') AS fdate,amount,is_paid,emp.id,emp.name FROM hr_advancesalary ehas
        LEFT JOIN hr_employee emp ON ehas.emp_id=emp.id
        WHERE ehas.emp_id='$id'
        ORDER BY ehas.id DESC";
        $qry = $this->db->query($qry);
        if ($qry && $qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }
    function get_total_allowance($salid)
    {
        $qry = "SELECT sum(u.amount_value) as ttlamount 
                FROM `hr_salary_updations` u
                where u.salary_id='$salid' and u.type='EARNING' group by u.salary_id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            $data = $qry->row_array();
            return $data['ttlamount'];
        } else{
            return false;
        }
    }
    function get_total_deductions($salid)
    {
        $qry = "SELECT sum(u.amount_value) as ttlamount 
                FROM `hr_salary_updations` u
                where u.salary_id='$salid' and u.type='DEDUCTION' group by u.salary_id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            $data = $qry->row_array();
            return $data['ttlamount'];
        } else{
            return false;
        }
    }


} ?>