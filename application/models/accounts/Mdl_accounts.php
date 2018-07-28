<?php
/**
 * Created by PhpStorm.
 * User: faisal
 * Date: 1/11/17
 * Time: 5:24 PM
 */

class Mdl_accounts extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_acc_type_groups()
    {
        $data = array();
        $qry = "select * from erp_ac_account_type";
        $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            $data['type'] = $qry->result_array();

            foreach ($data['type'] as $key => $type) {
                $type_id = $type['id'];
                $qry_grp = "select * from erp_ac_groups where acc_type_id = '$type_id'";
                $qry_grp = $this->db->query($qry_grp);
                if ($qry_grp->num_rows() > 0) {
                    $data['type'][$key]['group'] = $qry_grp->result_array();
                } else {
                    $data['type'][$key]['group'] = array();
                }

            }

        } else {
            $data['type'] = array();
        }
        return $data;
    }

    function add_new_ledegr($data)
    {

        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $created_on = date('Y-m-d');

        $name = $data['ledger'];
        $group_name = $data['group_name'];
        $opening = $data['openigbal'];
        $opdc = $data['ledgerOpBalanceDc'];
        $NOTE = $data['description'];
        $type_id = '';
        $open_date = $data['opening_date'];

        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];


        $acc_ins = array(
            'group_id' => $group_name,
            'name' => $name,
            '_type' => "ACCOUNT",
            'type_id' => $type_id,
            'note' => $NOTE

        );
        $acc_qry = $this->db->insert('erp_ac_ledgers', $acc_ins);
        $ld_id = $this->db->insert_id();
        $opening_arr = array(
            'opening_balance' =>$opening,
            'op_balance_dc' => $opdc,
            'ledger_id' => $ld_id,
            'opening_date' => $open_date,
            'fy_id' => $fy_id
         );
        $open_qry = $this->db->insert('erp_ac_opening_balance', $opening_arr);

        return $acc_qry;


    }

    function addGroup($data)
    {
        $sel_typee = $data['sel_typee'];
        $group_name = $data['groupname'];
        $data = array(
            'acc_type_id' => $sel_typee,
            'name' => $group_name
        );
        $qry = $this->db->insert('erp_ac_groups', $data);
        return $qry;


    }

    function get_groups()
    {

        $qry = "select ec.*,ect.name as account,ect.id as ac_id  from erp_ac_groups ec
        left join erp_ac_account_type ect on ect.id=ec.acc_type_id  order by acc_type_id";
        $qry1 = $this->db->query($qry);

        if ($qry1->num_rows() > 0) {

            return $qry1->result_array();


        }

    }

    function get_acc_types()
    {


    }


    function get_ledger_count($search)
    {

                  if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (gp.id LIKE '%$keyword%' OR gp.name LIKE '%$keyword%' OR ld.id LIKE '%$keyword%'  OR ld.name LIKE '%$keyword%') AND ld.id IS NOT NULL AND ld.is_del!=1 ";
        }else{
            $where = 'WHERE  ld.id IS NOT NULL AND ld.is_del!=1';
        }


   $qry = "select
                gp.id,
                gp.acc_type_id,
                gp.name,
                ld.id as ld_id,
                ld.name as ld_name,
                ld._type,
                concat(op.op_balance_dc, ' ', op.opening_balance) opening_balance
                from
                erp_ac_ledgers ld
                LEFT JOIN erp_ac_opening_balance op ON op.ledger_id = ld.id
                LEFT JOIN erp_ac_groups gp on gp.id = ld.group_id
                 ".$where."  order by ld.id  desc";       

        $result=$this->db->query($qry);

                     if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else{
            return false;
        } 

    }


    function get_ledgers_page($search,$limit=NULL,$start=NULL)
    {

 $finacial = get_current_financial_year();
      //  echo json_encode($finacial);exit();
        $fy_id = $finacial['id'];
        $fy_start = $finacial['start_year'];
        $fy_end = $finacial["end_year"];



       if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (gp.id LIKE '%$keyword%' OR gp.name LIKE '%$keyword%' OR ld.id LIKE '%$keyword%'  OR ld.name LIKE '%$keyword%') AND ld.id IS NOT NULL AND ld.is_del!=1";
        }else{
            $where = ' WHERE  ld.id IS NOT NULL AND ld.is_del!=1';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }


        $data = array();
       
           $qry = "select
                gp.id,
                gp.acc_type_id,
                gp.name,
                ld.id as ld_id,
                ld.name as ld_name,
                ld._type,
                concat(op.op_balance_dc, ' ', op.opening_balance) opening_balance
                from
                erp_ac_ledgers ld
                LEFT JOIN erp_ac_opening_balance op ON op.ledger_id = ld.id  and op.fy_id='$fy_id'
                LEFT JOIN erp_ac_groups gp on gp.id = ld.group_id
                 ".$where."  order by ld.id  desc".$pg;  

        $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            $data['ledger'] = $qry->result_array();
            foreach ($data['ledger'] as $key => $ledger) {
                $ld_id = $ledger['ld_id'];
                $closing = $this->get_new_ledger_balance($ld_id);
                $data['ledger'][$key]['closing'] = $closing['current_balance'];
                //echo $closing['current_balance'];exit();
            }
        } else {
            $data['ledger'] = array();
        }
        return $data;

    }


    function get_ledgers()
    {

        $data = array();
        /*$qry = "select
                gp.id,
                gp.acc_type_id,
                gp.name,
                ld.id as ld_id,
                ld.name as ld_name,
                ld._type ,
                concat(ld.op_balance_dc, ' ', ld.opening_balance) opening_balance
                from
                erp_ac_ledgers ld
                left join erp_ac_groups gp on gp.id = ld.group_id
                order by ld.id  desc";*/
        $qry = "select
                gp.id,
                gp.acc_type_id,
                gp.name,
                ld.id as ld_id,
                ld.name as ld_name,
                ld._type,
                concat(op.op_balance_dc, ' ', op.opening_balance) opening_balance
                from
                erp_ac_ledgers ld
                LEFT JOIN erp_ac_opening_balance op ON op.ledger_id = ld.id
                LEFT JOIN erp_ac_groups gp on gp.id = ld.group_id
                order by ld.id  desc";       

        $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            $data['ledger'] = $qry->result_array();
            foreach ($data['ledger'] as $key => $ledger) {
                $ld_id = $ledger['ld_id'];
                $closing = $this->get_new_ledger_balance($ld_id);
                $data['ledger'][$key]['closing'] = $closing['current_balance'];
            }
        } else {
            $data['ledger'] = array();
        }
        return $data;

    }

    function get_ledger_balance($ledger_id)
    {

        list($op_bal, $op_bal_type) = $this->get_op_balance($ledger_id);
        if ($op_bal_type == "Cr")
            $op_bal = $op_bal;

        $dr_total = $this->get_dr_total($ledger_id);
        $cr_total = $this->get_cr_total($ledger_id);

        $total = $this->float_ops($op_bal, $this->float_ops($dr_total, $cr_total, '-'), '+');
        return $total;
    }
    function get_new_ledger_balance($ledger_id)
    {

        $finacial = get_current_financial_year();
      //  echo json_encode($finacial);exit();
        $fy_id = $finacial['id'];
        $fy_start = $finacial['start_year'];
        $fy_end = $finacial["end_year"];

          $qry = "SELECT  SUM(open_data.open_bal) as open_bal, 
                SUM(IFNULL(dr_data.dr_amount,0)) as dr_amount, 
                SUM(IFNULL(cr_data.cr_amount,0)) as cr_amount,
                IFNULL(((IFNULL(open_bal,0)+IFNULL(dr_amount,0))-IFNULL(cr_amount,0)),0) as current_balance
                FROM
                (SELECT lds.id AS id, lds.group_id, lds.name AS ld_name FROM erp_ac_ledgers lds WHERE lds.id = $ledger_id
                ) AS ledger_data
                LEFT JOIN 
                (SELECT CASE WHEN op.op_balance_dc = 'Dr' THEN op.opening_balance ELSE op.opening_balance END as open_bal,  op.ledger_id FROM erp_ac_opening_balance op WHERE op.fy_id = '$fy_id' AND op.ledger_id = $ledger_id) as open_data
                ON ledger_data.id = open_data.ledger_id
                LEFT JOIN
                (SELECT ei.ledger_id, SUM(ei.amount) as dr_amount FROM erp_ac_entryitems ei 
                LEFT JOIN erp_ac_entries en ON en.id = ei.entry_id
                WHERE ei.dc = 'Dr' AND ei.fy_id = '$fy_id' AND ei.is_del = 0 AND ei.ledger_id = $ledger_id) AS dr_data ON dr_data.ledger_id = ledger_data.id
                LEFT JOIN
                (SELECT ei.ledger_id, SUM(ei.amount) as cr_amount FROM erp_ac_entryitems ei 
                 LEFT JOIN erp_ac_entries en ON en.id = ei.entry_id
                WHERE ei.dc = 'Cr' AND ei.fy_id = '$fy_id' AND ei.is_del = 0 AND ei.ledger_id = $ledger_id) AS cr_data ON cr_data.ledger_id = ledger_data.id"; 
        $qry = $this->db->query($qry);   
         
         if ($qry->num_rows() > 0) {
            $result = $qry->row_array();
         }  else{
            $result = array();
         }
         return $result;
    }

    function get_new_ledger_balance_date($ledger_id,$from_date, $to_date)
    {
 $finacial = get_current_financial_year();
      //  echo json_encode($finacial);exit();
        $fy_id = $finacial['id'];
        $fy_start = $finacial['start_year'];
        $fy_end = $finacial["end_year"];

        $qry = "SELECT  SUM(open_data.open_bal) as open_bal, 
                SUM(IFNULL(dr_data.dr_amount,0)) as dr_amount, 
                SUM(IFNULL(cr_data.cr_amount,0)) as cr_amount,
                IFNULL(open_bal+dr_amount-cr_amount,0) as current_balance
                FROM
                (SELECT lds.id AS id, lds.group_id, lds.name AS ld_name FROM erp_ac_ledgers lds WHERE lds.id = $ledger_id
                ) AS ledger_data
                LEFT JOIN 
                (SELECT CASE WHEN op.op_balance_dc = 'Dr' THEN op.opening_balance ELSE -op.opening_balance END as open_bal,  op.ledger_id FROM erp_ac_opening_balance op WHERE op.fy_id = '$fy_id' AND op.ledger_id = $ledger_id) as open_data
                ON ledger_data.id = open_data.ledger_id
                LEFT JOIN
                (SELECT ei.ledger_id, SUM(ei.amount) as dr_amount FROM erp_ac_entryitems ei 
                LEFT JOIN erp_ac_entries en ON en.id = ei.entry_id
                WHERE ei.dc = 'Dr' AND ei.fy_id = '$fy_id' AND ei.is_del = 0 AND en.date BETWEEN '$from_date' AND '$to_date' AND ei.ledger_id = $ledger_id) AS dr_data ON dr_data.ledger_id = ledger_data.id
                LEFT JOIN
                (SELECT ei.ledger_id, SUM(ei.amount) as cr_amount FROM erp_ac_entryitems ei 
                 LEFT JOIN erp_ac_entries en ON en.id = ei.entry_id
                WHERE ei.dc = 'Cr' AND ei.fy_id = '$fy_id' AND ei.is_del = 0 AND en.date BETWEEN '$from_date' AND '$to_date' AND ei.ledger_id = $ledger_id) AS cr_data ON cr_data.ledger_id = ledger_data.id";
        $qry = $this->db->query($qry);   
         
         if ($qry->num_rows() > 0) {
            $result = $qry->row_array();
         }  else{
            $result = array();
         }
         return $result;
    }

    function get_op_balance($ledger_id)
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $created_on = date('Y-m-d H:i:s');



$finacial = get_current_financial_year();
        $fy_id = $finacial['id'];

$array=array('ledger_id'=>$ledger_id,'fy_id'=>$fy_id);

        $this->db->from('erp_ac_opening_balance')->where($array)->limit(1);
        $op_bal_q = $this->db->get();

        if ($op_bal = $op_bal_q->row())
            return array($op_bal->opening_balance, $op_bal->op_balance_dc);
        else
            return array(0, "Dr");
    }

    function get_dr_total($ledger_id)
    {
          $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $from11 = $finacial['start_year'];


         $qry = "select SUM(amount) AS dr_total  from  erp_ac_entryitems
        left join erp_ac_entries on erp_ac_entries.id=erp_ac_entryitems.entry_id and erp_ac_entries.is_del =0
        where erp_ac_entryitems.dc= 'Dr' and erp_ac_entryitems.ledger_id='$ledger_id' and erp_ac_entryitems.fy_id = '$fy_id' and erp_ac_entryitems.is_del=0";


        $qry = $this->db->query($qry);


        if ($dr_total = $qry->row_array()) {

            return $dr_total['dr_total'];
        } else {
            return 0;
        }



        


    }

    /* Return credit total as positive value */
    function get_cr_total($ledger_id)
    {
        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $from11 = $finacial['start_year'];

        $qry = "select SUM(amount) AS cr_total  from  erp_ac_entryitems
        left join erp_ac_entries on erp_ac_entries.id=erp_ac_entryitems.entry_id and erp_ac_entries.is_del =0
        where erp_ac_entryitems.dc= 'Cr' and erp_ac_entryitems.ledger_id='$ledger_id' and erp_ac_entryitems.fy_id = '$fy_id' and erp_ac_entryitems.is_del=0";
        $qry = $this->db->query($qry);

        if ($cr_total = $qry->row_array())
            return $cr_total['cr_total'];
        else
            return 0;
    }


    function editgroup($id, $data)
    {

//        $name = $data['name'];


        $acc_type = $data['sel_typee'];
        $group = $data['groupname'];

        $info = array('name' => $group,
            'acc_type_id' => $acc_type,

        );
//        $qry = $this->db->insert('customers', $info);
        $this->db->where('id', $id);
        $qry = $this->db->update('erp_ac_groups', $info);

        return $qry;
    }

    function get_ledegr_by_id($id)
    {






 $qry = "select
                ld.*,

                op.opening_balance as opening_balance_amount,
                op.op_balance_dc
                
                from erp_ac_ledgers ld
                LEFT JOIN erp_ac_opening_balance op ON op.ledger_id = ld.id
                  


                  where ld.id='$id' order by ld.id  desc";






       $qry=$this->db->query($qry);

        if ($qry->num_rows() > 0) {
            return $qry->row_array();
        } else {
            return array();
        }

    }



function get_ledegr_view_count($id,$search)
    {


$finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $fy_start = $finacial['start_year'];
        $fy_end = $finacial["end_year"];





 if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (gp.id LIKE '%$keyword%' OR gp.name LIKE '%$keyword%' OR ld.id LIKE '%$keyword%'  OR ld.name LIKE '%$keyword%' OR en.number LIKE '%$keyword%' OR en.date LIKE '%$keyword%' OR et.name LIKE '%$keyword%') AND ld.id IS NOT NULL AND  ld.id = '$id'";
        }else{
            $where = "WHERE  ld.id IS NOT NULL AND  ld.id = '$id'";
        }

 $qry = "select
                ld.id,
                gp.name gp_name,
                ld.group_id,
                ld.name ld_name,
                ld.note,
                en.number,
                DATE_FORMAT(en.date,'%d-%m-%Y') as ld_date,
                en.date,
                et.name as en_type,

                if(ei.dc = 'Dr', CONCAT(ei.dc , ' ', ei.amount), '-')as dr_balance,
                if(ei.dc = 'Cr', CONCAT(ei.dc , ' ', ei.amount), '-')as cr_balance,
                if(ei.dc = 'Dr', ei.amount, 0) as dr_amount,
                if(ei.dc = 'Cr', ei.amount, 0) as cr_amount,
                op.opening_balance as opening_balance_amount,
                op.op_balance_dc,
                CONCAT(op.op_balance_dc , '-', op.opening_balance) as opening_balance
                from erp_ac_ledgers ld
                left join erp_ac_groups gp on gp.id = ld.group_id
                LEFT JOIN erp_ac_opening_balance op ON op.ledger_id = ld.id and op.fy_id='$fy_id'
                left join erp_ac_entryitems ei on ei.ledger_id = ld.id and ei.is_del!=1 and ei.fy_id='$fy_id'
                left join erp_ac_entries en on en.id = ei.entry_id  and en.is_del!=1 and en.fy_id='$fy_id'
                left join erp_ac_entry_types et on et.id = en.entrytype_id
                ".$where."   order by ld.id  desc";




  $result=$this->db->query($qry);

                     if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else{
            return false;
        } 






    }

    function get_ledegr_view_page($id,$search,$limit=NULL,$start=NULL)
    {
$finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $fy_start = $finacial['start_year'];
        $fy_end = $finacial["end_year"];


         if(!empty($search)){
            $keyword = "%{$search}%";
           $where = " WHERE (gp.id LIKE '%$keyword%' OR gp.name LIKE '%$keyword%' OR ld.id LIKE '%$keyword%'  OR ld.name LIKE '%$keyword%' OR en.number LIKE '%$keyword%' OR en.date LIKE '%$keyword%' OR et.name LIKE '%$keyword%') AND ld.id IS NOT NULL AND  ld.id = '$id'";
        }else{
            $where = "WHERE  ld.id IS NOT NULL AND  ld.id = '$id'";
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }


              $qry = "select
                ld.id,
                gp.name gp_name,
                ld.group_id,
                ld.name ld_name,
                ld.note,
                en.number,
                DATE_FORMAT(en.date,'%d-%m-%Y') as ld_date,
                en.date,
                et.name as en_type,

                if(ei.dc = 'Dr', CONCAT(ei.dc , ' ', ei.amount), '-')as dr_balance,
                if(ei.dc = 'Cr', CONCAT(ei.dc , ' ', ei.amount), '-')as cr_balance,
                if(ei.dc = 'Dr', ei.amount, 0) as dr_amount,
                if(ei.dc = 'Cr', ei.amount, 0) as cr_amount,
                op.opening_balance as opening_balance_amount,
                op.op_balance_dc,
                CONCAT(op.op_balance_dc , ' ', op.opening_balance) as opening_balance
                from erp_ac_ledgers ld
                left join erp_ac_groups gp on gp.id = ld.group_id
                LEFT JOIN erp_ac_opening_balance op ON op.ledger_id = ld.id and op.fy_id='$fy_id'
                left join erp_ac_entryitems ei on ei.ledger_id = ld.id and ei.is_del!=1 and ei.fy_id='$fy_id'
                left join erp_ac_entries en on en.id = ei.entry_id  and en.is_del!=1 and en.fy_id='$fy_id'
                left join erp_ac_entry_types et on et.id = en.entrytype_id
                ".$where."   order by ld.id  desc".$pg; 







        $qry = $this->db->query($qry);
            if ($qry->num_rows() > 0) {

           
            $data['ledger'] = $qry->result_array();

         // echo json_encode($data['ledger']);exit();
            foreach ($data['ledger'] as $key => $ledger) {
                $led_id = $ledger['id'];
                $closing = $this->get_new_ledger_balance($led_id);
                $data['closing_bal'] = $closing['current_balance'];
//                if(!$data['ledger']['closing_bal']){
//                   $data['ledger']['closing_bal']= array();
//                }
            }
        } else {
            $data['ledger'] = array();
        }
        // echo json_encode($data);exit();
        return $data;
    }

    function get_ledegr_view($id)
    {

$finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $fy_start = $finacial['start_year'];
        $fy_end = $finacial["end_year"];


                 $qry11 = "select
                ld.id,
                gp.name gp_name,
                ld.group_id,
                ld.name ld_name,
                ld.note,
                en.number,
                DATE_FORMAT(en.date,'%d-%m-%Y') as ld_date,
                en.date,
                et.name as en_type,

                if(ei.dc = 'Dr', CONCAT(ei.dc , ' ', ei.amount), '-')as dr_balance,
                if(ei.dc = 'Cr', CONCAT(ei.dc , ' ', ei.amount), '-')as cr_balance,
                if(ei.dc = 'Dr', ei.amount, 0) as dr_amount,
                if(ei.dc = 'Cr', ei.amount, 0) as cr_amount,
                op.opening_balance as opening_balance_amount,
                op.op_balance_dc,
                CONCAT(op.op_balance_dc , '', op.opening_balance) as opening_balance
                from erp_ac_ledgers ld
                left join erp_ac_groups gp on gp.id = ld.group_id
                LEFT JOIN erp_ac_opening_balance op ON op.ledger_id = ld.id and op.fy_id='$fy_id'
                left join erp_ac_entryitems ei on ei.ledger_id = ld.id and ei.is_del!=1 and ei.fy_id='$fy_id'
                left join erp_ac_entries en on en.id = ei.entry_id  and en.is_del!=1 and en.fy_id='$fy_id'
                left join erp_ac_entry_types et on et.id = en.entrytype_id
                where ld.id = '$id'";  
        $qry = $this->db->query($qry11);
      //  echo $this->db->last_query();exit();
        // var_dump($qry->row_array()) ;exit();
        if ($qry->num_rows() > 0) {

           
            $data['ledger'] = $qry->result_array();

         // echo json_encode($data['ledger']);exit();
            foreach ($data['ledger'] as $key => $ledger) {
                $led_id = $ledger['id'];
                $closing = $this->get_new_ledger_balance($led_id);
                $data['closing_bal'] = $closing['current_balance'];
//                if(!$data['ledger']['closing_bal']){
//                   $data['ledger']['closing_bal']= array();
//                }
            }
        } else {
            $data['ledger'] = array();
        }
        // echo json_encode($data);exit();
        return $data;

    }

    function edit_ledegr_by_id($id, $data)
    {

        $group = $data['group_name'];
        $ledger = $data['ledger'];
        $ledgerOpBalanceDc = $data['ledgerOpBalanceDc'];
        $openigbal = $data['openigbal'];
        $description = $data['description'];


        $info = array('name' => $ledger,
            'group_id' => $group,
            '_type' => "ACCOUNT",
            'type_id' => '',
            'opening_balance' => $openigbal,
            'op_balance_dc' => $ledgerOpBalanceDc,
            'note' => $description


        );
//        $qry = $this->db->insert('customers', $info);
        $this->db->where('id', $id);
        $qry = $this->db->update('erp_ac_ledgers', $info);







        //    $opening_arr = array(
        //     'opening_balance' =>$opening,
        //     'op_balance_dc' => $opdc,
        //     'ledger_id' => $ld_id,
        //     'opening_date' => $open_date,
        //     'fy_id' => $fy_id
        //  );
        // $open_qry = $this->db->insert('erp_ac_opening_balance', $opening_arr);

        return $qry;

    }

    function delete_ledgers($data)
    {

        $itemgrp = $data['itemgrps'];
        $info = array('is_del' => 1);
        $this->db->where_in('id', $itemgrp);
        $qry = $this->db->update('erp_ac_ledgers', $info);
        return $qry;


    }

    function get_group_ledger()
    {


$finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $fy_start = $finacial['start_year'];
        $fy_end = $finacial["end_year"];

        $data = array();
        $qry = "select * from erp_ac_groups ORDER BY name asc";
        $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            $data['group'] = $qry->result_array();

            foreach ($data['group'] as $key => $group) {
                $group_id = $group['id'];
                $qry_grp = "select 
                            ld.id as ld_id,
                            ld.name as ld_name,
                            concat(op.op_balance_dc, ' ', op.opening_balance) as opening_balance
                            from erp_ac_ledgers ld
                            LEFT JOIN erp_ac_opening_balance op ON op.ledger_id = ld.id  and op.fy_id='$fy_id'
                            where group_id = '$group_id'
                            order by ld.id desc";

                $qry_grp = $this->db->query($qry_grp);
                if ($qry_grp->num_rows() > 0) {
                    $data['group'][$key]['ledger'] = $qry_grp->result_array();
                } else {
                    $data['group'][$key]['ledger'] = array();
                }
            }
        } else {
            $data['group'] = array();
        }


        return $data;
    }

    function get_acc_settings()
    {
        $qry = "select
                st.id,
                st.name,
                st.address,
                st.email,
                st.fy_start,
                st.fy_end
                from 
                    company_details st ";
        $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            return $qry->row_array();
        } else {
            return array();
        }
    }



        function get_ledger_statement_by_id_count($led_id,$search)
    {







        $date_from1 = $this->input->post('from_date');

        $date_from = convert_to_mysql($date_from1);

        $date_to1 = $this->input->post('to_date');
        $date_to = convert_to_mysql($date_to1);

       // $stettings = $this->get_acc_settings();
       // $fy_start = $stettings["fy_start"];

        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $fy_start = $finacial['start_year'];
        $fy_end = $finacial["end_year"];

        if ($date_from == '' && $date_to != '') {
            $between = "and en.date between '$fy_start' and '$date_to'";
        } else if ($date_from != '' && $date_to == '') {
            $cur_date = date('Y-m-d');
            $between = "and en.date between '$date_from' and '$fy_end'";
        } else if ($date_from != '' && $date_to != '') {
            $between = "and en.date between '$date_from' and '$date_to'";
        }






         if(!empty($search))
         {
            $keyword = "%{$search}%";
            $where = " WHERE (gp.id LIKE '%$keyword%' OR gp.name LIKE '%$keyword%' OR ld.id LIKE '%$keyword%'  OR ld.name LIKE '%$keyword%' OR en.number LIKE '%$keyword%' OR en.date LIKE '%$keyword%' OR et.name LIKE '%$keyword%') AND ld.id = '$led_id' $between";
        }else
        {
            $where = "WHERE  ld.id = '$led_id' $between";
        }



        $qry = "select 
                ld.id,
                gp.name gp_name,
                ld.group_id,
                ld.name ld_name,
                ld.note,
                en.number,
                DATE_FORMAT(en.date,'%d-%b-%Y') as ld_date,
                en.date,
                et.name as en_type,
                
                if(ei.dc = 'Dr', CONCAT(ei.dc , ' ', ei.amount), '-')as dr_balance, 
                if(ei.dc = 'Cr', CONCAT(ei.dc , ' ', ei.amount), '-')as cr_balance, 
                if(ei.dc = 'Dr', ei.amount, 0) as dr_amount,
                if(ei.dc = 'Cr', ei.amount, 0) as cr_amount,
                op.opening_balance as opening_balance_amount,
                op.op_balance_dc,
                CONCAT(op.op_balance_dc , ' ', op.opening_balance) as opening_balance
                from erp_ac_ledgers ld
                LEFT JOIN erp_ac_opening_balance op ON op.ledger_id = ld.id
                left join erp_ac_groups gp on gp.id = ld.group_id
                left join erp_ac_entryitems ei on ei.ledger_id = ld.id and ei.is_del=0
                left join erp_ac_entries en on en.id = ei.entry_id  and en.is_del=0
                left join erp_ac_entry_types et on et.id = en.entrytype_id
               ".$where."";
        //echo $this->db->last_query();

  $result=$this->db->query($qry);

                     if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else{
            return false;
        } 

    }







    function get_ledger_statement_by_id_page($led_id,$search,$limit=NULL,$start=NULL)
    {





        $date_from1 = $this->input->post('from_date');

        $date_from = convert_to_mysql($date_from1);

        $date_to1 = $this->input->post('to_date');
        $date_to = convert_to_mysql($date_to1);

      

        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $fy_start = $finacial['start_year'];
        $fy_end = $finacial["end_year"];

        if ($date_from == '' && $date_to != '') {
            $between = "and en.date between '$fy_start' and '$date_to'";
        } else if ($date_from != '' && $date_to == '') {
            $cur_date = date('Y-m-d');
            $between = "and en.date between '$date_from' and '$fy_end'";
        } else if ($date_from != '' && $date_to != '') {
            $between = "and en.date between '$date_from' and '$date_to'";
        }


          if(!empty($search)){
            $keyword = "%{$search}%";
           $where = " WHERE (gp.id LIKE '%$keyword%' OR gp.name LIKE '%$keyword%' OR ld.id LIKE '%$keyword%'  OR ld.name LIKE '%$keyword%' OR en.number LIKE '%$keyword%' OR en.date LIKE '%$keyword%' OR et.name LIKE '%$keyword%') AND ld.id = '$led_id' $between";
        }else{
            $where = "WHERE  ld.id = '$led_id' $between";
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }

         $qry = "select 
                ld.id,
                gp.name gp_name,
                ld.group_id,
                ld.name ld_name,
                ld.note,
                en.number,
                DATE_FORMAT(en.date,'%d-%b-%Y') as ld_date,
                en.date,
                et.name as en_type,
                
                if(ei.dc = 'Dr', CONCAT(ei.dc , ' ', ei.amount), '-')as dr_balance, 
                if(ei.dc = 'Cr', CONCAT(ei.dc , ' ', ei.amount), '-')as cr_balance, 
                if(ei.dc = 'Dr', ei.amount, 0) as dr_amount,
                if(ei.dc = 'Cr', ei.amount, 0) as cr_amount,
                op.opening_balance as opening_balance_amount,
                op.op_balance_dc,
                CONCAT(op.op_balance_dc , ' ', op.opening_balance) as opening_balance
                from erp_ac_ledgers ld
                LEFT JOIN erp_ac_opening_balance op ON op.ledger_id = ld.id
                left join erp_ac_groups gp on gp.id = ld.group_id
                left join erp_ac_entryitems ei on ei.ledger_id = ld.id and ei.is_del=0
                left join erp_ac_entries en on en.id = ei.entry_id  and en.is_del=0
                left join erp_ac_entry_types et on et.id = en.entrytype_id
                ".$where."".$pg; 
        $qry = $this->db->query($qry);
        //echo $this->db->last_query();
        if ($qry->num_rows() > 0) {
            $data['ledger'] = $qry->result_array();
            foreach ($data['ledger'] as $key => $ledger) {
                $led_id = $ledger['id'];
                //$data['closing_bal'] = $this->get_ledger_balance_date($led_id,$date_from,$date_to);
                $data['closing_bal'] = $this->get_new_ledger_balance_date($led_id,$date_from,$date_to);

                $data['open_bal'] = $this->get_opening_balanceof_ledger($led_id);
            }
        } else {
            $data['ledger'] = array();
        }

        return $data;
    }





    function get_ledger_statement_by_id($led_id)
    {
        $date_from1 = $this->input->post('from_date');

        $date_from = convert_to_mysql($date_from1);

        $date_to1 = $this->input->post('to_date');
        $date_to = convert_to_mysql($date_to1);

       // $stettings = $this->get_acc_settings();
       // $fy_start = $stettings["fy_start"];

        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $fy_start = $finacial['start_year'];
        $fy_end = $finacial["end_year"];

        if ($date_from == '' && $date_to != '') {
            $between = "and en.date between '$fy_start' and '$date_to'";
        } else if ($date_from != '' && $date_to == '') {
            $cur_date = date('Y-m-d');
            $between = "and en.date between '$date_from' and '$fy_end'";
        } else if ($date_from != '' && $date_to != '') {
            $between = "and en.date between '$date_from' and '$date_to'";
        }

        $qry = "select 
                ld.id,
                gp.name gp_name,
                ld.group_id,
                ld.name ld_name,
                ld.note,
                en.number,
                DATE_FORMAT(en.date,'%d-%b-%Y') as ld_date,
                en.date,
                et.name as en_type,
                
                if(ei.dc = 'Dr', CONCAT(ei.dc , ' ', ei.amount), '-')as dr_balance, 
                if(ei.dc = 'Cr', CONCAT(ei.dc , ' ', ei.amount), '-')as cr_balance, 
                if(ei.dc = 'Dr', ei.amount, 0) as dr_amount,
                if(ei.dc = 'Cr', ei.amount, 0) as cr_amount,
                op.opening_balance as opening_balance_amount,
                op.op_balance_dc,
                CONCAT(op.op_balance_dc , ' ', op.opening_balance) as opening_balance
                from erp_ac_ledgers ld
                LEFT JOIN erp_ac_opening_balance op ON op.ledger_id = ld.id
                left join erp_ac_groups gp on gp.id = ld.group_id
                left join erp_ac_entryitems ei on ei.ledger_id = ld.id and ei.is_del=0
                left join erp_ac_entries en on en.id = ei.entry_id  and en.is_del=0
                left join erp_ac_entry_types et on et.id = en.entrytype_id
                where ld.id = '$led_id' $between";
        $qry = $this->db->query($qry);
        //echo $this->db->last_query();
        if ($qry->num_rows() > 0) {
            $data['ledger'] = $qry->result_array();
            foreach ($data['ledger'] as $key => $ledger) {
                $led_id = $ledger['id'];
                //$data['closing_bal'] = $this->get_ledger_balance_date($led_id,$date_from,$date_to);
                $data['closing_bal'] = $this->get_new_ledger_balance_date($led_id,$date_from,$date_to);

                $data['open_bal'] = $this->get_opening_balanceof_ledger($led_id);
            }
        } else {
            $data['ledger'] = array();
        }

        return $data;
    }

    function get_opening_balanceof_ledger($ledger_id)
    {
        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $from11 = $finacial['start_year'];

         $qry = "select 
                concat(op.op_balance_dc, ' ', op.opening_balance) as open_bal
                from
                erp_ac_ledgers ld 
                LEFT JOIN erp_ac_opening_balance op ON op.ledger_id = ld.id
                where ld.id ='$ledger_id' and op.fy_id='$fy_id'";

        $qry = $this->db->query($qry);


        if ($qry->num_rows() > 0) {
            $data = $qry->row_array();
            return $data['open_bal'];

        } else {
            return array();
        }

    }
    function get_profitloss_income_date($from, $to)
    {
        $data = array();
        $qry = "select
                distinct(ld.id),
                ld.group_id,
                ld.name
                from
                erp_ac_ledgers ld
                left join erp_ac_entryitems ei on ei.ledger_id =  ld.id  and ei.is_del=0
                left join erp_ac_entries en on en.id = ei.entry_id  and en.is_del=0
                left join erp_ac_groups gp on gp.id = ld.group_id
                left join erp_ac_account_type typ on typ.id = gp.acc_type_id
                where typ.id = 3
                order by ld.name asc";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data['ledger'] = $qry->result_array();
            foreach ($data['ledger'] as $key => $ledger) {
                $led_id = $ledger['id'];
                $data['ledger'][$key]['ld_open_bal'] = $this->get_opening_balanceof_ledger($led_id);
                $data['ledger'][$key]['ld_close_bal'] =  $this->get_ledger_balance_date($led_id, $from,$to);
                $data['ledger'][$key]['ld_dr_total'] =  $this->get_dr_total_date($led_id, $from,$to);
                $data['ledger'][$key]['ld_cr_total'] =  $this->get_cr_total_date($led_id, $from,$to);
                # code...
            }
        }   else{
            $data['ledger'] = array();
        }
        return $data;
    }

    function get_profitloss_new_income_date($from, $to_date)
    {


         $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $from11 = $finacial['start_year'];

        $data = array();
         $_where = "";
        //date filter
        if(($from != "" && $from != NULL) && ($to_date != "" && $to_date != NULL))
        {
            $_where = " and en.date between'".date('Y-m-d',strtotime($from))."' and '".date('Y-m-d',strtotime( $to_date ))."' ";
        }
        elseif($from != "" && $from != NULL)
        {
            $_where = " and en.date = '".date('Y-m-d',strtotime( $from ))."' ";
        }
        elseif($to_date != "" && $to_date != NULL)
        {
            $_where = " and en.date = '".date('Y-m-d',strtotime( $to_date ))."' ";
        }




         $qry = "SELECT  ledger_data.group_id, ledger_data.gp_name, SUM(IFNULL(open_data.open_bal,0)) as open_bal, 
                SUM(IFNULL(dr_data.dr_amount,0)) as dr_amount,
                SUM(IFNULL(cr_data.cr_amount,0)) as cr_amount,
                (SUM(IFNULL(open_data.open_bal,0))+SUM(IFNULL(dr_data.dr_amount,0))-SUM(IFNULL(cr_data.cr_amount,0))) as balance, 
                ledger_data.acc_type_id
                FROM
                (SELECT lds.id AS id, lds.group_id, grp.name as gp_name, lds.name AS ld_name, grp.acc_type_id FROM erp_ac_ledgers lds
                    LEFT JOIN erp_ac_groups grp ON grp.id = lds.group_id
                ) AS ledger_data
                LEFT JOIN 
                (SELECT CASE WHEN op.op_balance_dc = 'Dr' THEN op.opening_balance ELSE -op.opening_balance END as open_bal,  op.ledger_id FROM erp_ac_opening_balance op WHERE op.fy_id = '$fy_id') as open_data
                ON ledger_data.id = open_data.ledger_id
                LEFT JOIN
                (SELECT ei.ledger_id, SUM(ei.amount) as dr_amount FROM erp_ac_entryitems ei 
                LEFT JOIN erp_ac_entries en ON en.id = ei.entry_id
                WHERE ei.dc = 'Dr' AND ei.fy_id = '$fy_id' AND ei.is_del = 0 $_where GROUP BY ei.ledger_id) AS dr_data ON dr_data.ledger_id = ledger_data.id
                LEFT JOIN
                (SELECT ei.ledger_id, SUM(ei.amount) as cr_amount FROM erp_ac_entryitems ei 
                 LEFT JOIN erp_ac_entries en ON en.id = ei.entry_id
                WHERE ei.dc = 'Cr' AND ei.fy_id = '$fy_id' AND ei.is_del = 0 $_where GROUP BY ei.ledger_id) AS cr_data ON cr_data.ledger_id = ledger_data.id
                WHERE ledger_data.acc_type_id = 3
                GROUP BY ledger_data.group_id";
        $qry = $this->db->query($qry);
       // echo $this->db->last_query();exit;
        if($qry->num_rows()>0)
        {
            $data = $qry->result_array();
            
        }   else{
            $data = array();
        }
        return $data;
    }



     function get_monthly_expenceReport()
    {
        $from = date('Y-m-d',strtotime($this->input->post('date1')));
        $to = date('Y-m-d',strtotime($this->input->post('date2')));
        $data = array();
        $qry = "select
                distinct(ld.id),
                ld.group_id,
                ld.name
                from
                erp_ac_ledgers ld
                left join erp_ac_entryitems ei on ei.ledger_id =  ld.id  and ei.is_del=0
                left join erp_ac_entries en on en.id = ei.entry_id  and en.is_del=0
                left join erp_ac_groups gp on gp.id = ld.group_id
                left join erp_ac_account_type typ on typ.id = gp.acc_type_id
                where typ.id = 4
                order by ld.name asc";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data['ledger'] = $qry->result_array();
            foreach ($data['ledger'] as $key => $ledger) {
                $led_id = $ledger['id'];
                $data['ledger'][$key]['ld_open_bal'] = $this->get_opening_balanceof_ledger($led_id);
                $data['ledger'][$key]['ld_close_bal'] =  $this->get_ledger_balance_date($led_id, $from,$to);
                $data['ledger'][$key]['ld_dr_total'] =  $this->get_dr_total_date($led_id, $from,$to);
                $data['ledger'][$key]['ld_cr_total'] =  $this->get_cr_total_date($led_id, $from,$to);
                # code...
            }
        }   else{
            $data['ledger'] = array();
        }
        return $data;
    }
    function get_profitloss_expence_new_date($from, $to_date)
    {


         $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $from11 = $finacial['start_year'];

        $data = array();
         $_where = "";
        //date filter
        if(($from != "" && $from != NULL) && ($to_date != "" && $to_date != NULL))
        {
            $_where = " and en.date between'".date('Y-m-d',strtotime($from))."' and '".date('Y-m-d',strtotime( $to_date ))."' ";
        }
        elseif($from != "" && $from != NULL)
        {
            $_where = " and en.date = '".date('Y-m-d',strtotime( $from ))."' ";
        }
        elseif($to_date != "" && $to_date != NULL)
        {
            $_where = " and en.date = '".date('Y-m-d',strtotime( $to_date ))."' ";
        }




        $qry = "SELECT  ledger_data.group_id, ledger_data.gp_name,  SUM(IFNULL(open_data.open_bal,0)) as open_bal, 
                SUM(IFNULL(dr_data.dr_amount,0)) as dr_amount, 
                SUM(IFNULL(cr_data.cr_amount,0)) as cr_amount,
                (SUM(IFNULL(open_data.open_bal,0))+SUM(IFNULL(dr_data.dr_amount,0))-SUM(IFNULL(cr_data.cr_amount,0))) as balance, 
                ledger_data.acc_type_id
                FROM
                (SELECT lds.id AS id, lds.group_id, grp.name as gp_name, lds.name AS ld_name, grp.acc_type_id FROM erp_ac_ledgers lds
                    LEFT JOIN erp_ac_groups grp ON grp.id = lds.group_id
                ) AS ledger_data
                LEFT JOIN 
                (SELECT CASE WHEN op.op_balance_dc = 'Dr' THEN op.opening_balance ELSE op.opening_balance END as open_bal,  op.ledger_id FROM erp_ac_opening_balance op WHERE op.fy_id = '$fy_id') as open_data
                ON ledger_data.id = open_data.ledger_id
                LEFT JOIN
                (SELECT ei.ledger_id, SUM(ei.amount) as dr_amount FROM erp_ac_entryitems ei 
                LEFT JOIN erp_ac_entries en ON en.id = ei.entry_id
                WHERE ei.dc = 'Dr' AND ei.fy_id = '$fy_id' AND ei.is_del = 0 $_where GROUP BY ei.ledger_id) AS dr_data ON dr_data.ledger_id = ledger_data.id
                LEFT JOIN
                (SELECT ei.ledger_id, SUM(ei.amount) as cr_amount FROM erp_ac_entryitems ei 
                 LEFT JOIN erp_ac_entries en ON en.id = ei.entry_id
                WHERE ei.dc = 'Cr' AND ei.fy_id = '$fy_id' AND ei.is_del = 0 $_where GROUP BY ei.ledger_id) AS cr_data ON cr_data.ledger_id = ledger_data.id
                WHERE ledger_data.acc_type_id = 4
                GROUP BY ledger_data.group_id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data = $qry->result_array();
            
        }   else{
            $data = array();
        }
        return $data;
    }
    function get_profitloss_expence_date($from, $to)
    {
        $data = array();
        $qry = "select
                distinct(ld.id),
                ld.group_id,
                ld.name
                from
                erp_ac_ledgers ld
                left join erp_ac_entryitems ei on ei.ledger_id =  ld.id and ei.is_del=0
                left join erp_ac_entries en on en.id = ei.entry_id and en.is_del=0 
                left join erp_ac_groups gp on gp.id = ld.group_id
                left join erp_ac_account_type typ on typ.id = gp.acc_type_id
                where typ.id = 4
                order by ld.name asc";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data['ledger'] = $qry->result_array();
            foreach ($data['ledger'] as $key => $ledger) {
                $led_id = $ledger['id'];
                $data['ledger'][$key]['ld_open_bal'] = $this->get_opening_balanceof_ledger($led_id);
                $data['ledger'][$key]['ld_close_bal'] =  $this->get_ledger_balance_date($led_id,$from, $to);
                $data['ledger'][$key]['ld_dr_total'] =  $this->get_dr_total_date($led_id,$from, $to);
                $data['ledger'][$key]['ld_cr_total'] =  $this->get_cr_total_date($led_id,$from, $to);
                # code...
            }
        }
        else{
            $data['ledger'] = array();
        }
        return $data;
    }
    function get_balancesheet_new_assetes($from, $to_date)
    {


 $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $from11 = $finacial['start_year'];



        $data = array();
         $_where = "";
        //date filter
        if(($from != "" && $from != NULL) && ($to_date != "" && $to_date != NULL))
        {
            $_where = " and en.date between'".date('Y-m-d',strtotime($from))."' and '".date('Y-m-d',strtotime( $to_date ))."' ";
        }
        elseif($from != "" && $from != NULL)
        {
            $_where = " and en.date = '".date('Y-m-d',strtotime( $from ))."' ";
        }
        elseif($to_date != "" && $to_date != NULL)
        {
            $_where = " and en.date = '".date('Y-m-d',strtotime( $to_date ))."' ";
        }




         $qry = "SELECT  ledger_data.group_id, ledger_data.gp_name, SUM(IFNULL(open_data.open_bal,0)) as open_bal, 
                SUM(IFNULL(dr_data.dr_amount,0)) as dr_amount, 
                SUM(IFNULL(cr_data.cr_amount,0)) as cr_amount,
                (SUM(IFNULL(open_data.open_bal,0))+SUM(IFNULL(dr_data.dr_amount,0))-SUM(IFNULL(cr_data.cr_amount,0))) as balance, 
                ledger_data.acc_type_id
                FROM
                (SELECT lds.id AS id, lds.group_id, grp.name as gp_name, lds.name AS ld_name, grp.acc_type_id FROM erp_ac_ledgers lds
                    LEFT JOIN erp_ac_groups grp ON grp.id = lds.group_id
                ) AS ledger_data
                LEFT JOIN 
                (SELECT CASE WHEN op.op_balance_dc = 'Dr' THEN op.opening_balance ELSE op.opening_balance END as open_bal,  op.ledger_id FROM erp_ac_opening_balance op WHERE op.fy_id = '$fy_id') as open_data
                ON ledger_data.id = open_data.ledger_id
                LEFT JOIN
                (SELECT ei.ledger_id, SUM(ei.amount) as dr_amount FROM erp_ac_entryitems ei 
                LEFT JOIN erp_ac_entries en ON en.id = ei.entry_id
                WHERE ei.dc = 'Dr' AND ei.fy_id = '$fy_id' AND ei.is_del = 0 $_where GROUP BY ei.ledger_id) AS dr_data ON dr_data.ledger_id = ledger_data.id
                LEFT JOIN
                (SELECT ei.ledger_id, SUM(ei.amount) as cr_amount FROM erp_ac_entryitems ei 
                 LEFT JOIN erp_ac_entries en ON en.id = ei.entry_id
                WHERE ei.dc = 'Cr' AND ei.fy_id = '$fy_id' AND ei.is_del = 0 $_where GROUP BY ei.ledger_id) AS cr_data ON cr_data.ledger_id = ledger_data.id
                WHERE ledger_data.acc_type_id = 1
                GROUP BY ledger_data.group_id"; 
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data = $qry->result_array();
            
        }   else{
            $data = array();
        }
        return $data;
    }

    function get_balancesheet_assetes()
    {
        $data = array();
        $qry = "select
                distinct(ld.id),
                ld.group_id,
                ld.name
                from
                erp_ac_ledgers ld
                left join erp_ac_entryitems ei on ei.ledger_id =  ld.id  and ei.is_del=0
                left join erp_ac_entries en on en.id = ei.entry_id  and en.is_del=0
                left join erp_ac_groups gp on gp.id = ld.group_id
                left join erp_ac_account_type typ on typ.id = gp.acc_type_id
                where typ.id =1
                order by ld.name asc";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data['ledger'] = $qry->result_array();
            foreach ($data['ledger'] as $key => $ledger) {
                $led_id = $ledger['id'];
                $data['ledger'][$key]['ld_open_bal'] = $this->get_opening_balanceof_ledger($led_id);
                $data['ledger'][$key]['ld_close_bal'] =  $this->get_ledger_balance($led_id);
                $data['ledger'][$key]['ld_dr_total'] =  $this->get_dr_total($led_id);
                $data['ledger'][$key]['ld_cr_total'] =  $this->get_cr_total($led_id);
                # code...
            }
        }   else{
            $data['ledger'] = array();
        }
        return $data;
    }
    function get_balancesheet_new_liabilities($from, $to_date)
    {
 $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $from11 = $finacial['start_year'];


        $data = array();
         $_where = "";
        //date filter
        if(($from != "" && $from != NULL) && ($to_date != "" && $to_date != NULL))
        {
            $_where = " and en.date between'".date('Y-m-d',strtotime($from))."' and '".date('Y-m-d',strtotime( $to_date ))."' ";
        }
        elseif($from != "" && $from != NULL)
        {
            $_where = " and en.date = '".date('Y-m-d',strtotime( $from ))."' ";
        }
        elseif($to_date != "" && $to_date != NULL)
        {
            $_where = " and en.date = '".date('Y-m-d',strtotime( $to_date ))."' ";
        }
        $qry = "SELECT  ledger_data.group_id, ledger_data.gp_name, SUM(IFNULL(open_data.open_bal,0)) as open_bal, 
                SUM(IFNULL(dr_data.dr_amount,0)) as dr_amount, 
                SUM(IFNULL(cr_data.cr_amount,0)) as cr_amount,
                (SUM(IFNULL(open_data.open_bal,0))+SUM(IFNULL(dr_data.dr_amount,0))-SUM(IFNULL(cr_data.cr_amount,0))) as balance, 
                ledger_data.acc_type_id
                FROM
                (SELECT lds.id AS id, lds.group_id, grp.name as gp_name, lds.name AS ld_name, grp.acc_type_id FROM erp_ac_ledgers lds
                    LEFT JOIN erp_ac_groups grp ON grp.id = lds.group_id
                ) AS ledger_data
                LEFT JOIN 
                (SELECT CASE WHEN op.op_balance_dc = 'Dr' THEN op.opening_balance ELSE -op.opening_balance END as open_bal,  op.ledger_id FROM erp_ac_opening_balance op WHERE op.fy_id = '$fy_id') as open_data
                ON ledger_data.id = open_data.ledger_id
                LEFT JOIN
                (SELECT ei.ledger_id, SUM(ei.amount) as dr_amount FROM erp_ac_entryitems ei 
                LEFT JOIN erp_ac_entries en ON en.id = ei.entry_id
                WHERE ei.dc = 'Dr' AND ei.fy_id = '$fy_id' AND ei.is_del = 0 $_where GROUP BY ei.ledger_id) AS dr_data ON dr_data.ledger_id = ledger_data.id
                LEFT JOIN
                (SELECT ei.ledger_id, SUM(ei.amount) as cr_amount FROM erp_ac_entryitems ei 
                 LEFT JOIN erp_ac_entries en ON en.id = ei.entry_id
                WHERE ei.dc = 'Cr' AND ei.fy_id = '$fy_id' AND ei.is_del = 0 $_where GROUP BY ei.ledger_id) AS cr_data ON cr_data.ledger_id = ledger_data.id
                WHERE ledger_data.acc_type_id = 2
                GROUP BY ledger_data.group_id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data = $qry->result_array();
            
        }   else{
            $data = array();
        }
        return $data;
    }
    function get_balancesheet_liabilities()
    {
        $data = array();
        $qry = "select
                distinct(ld.id),
                ld.group_id,
                ld.name
                from
                erp_ac_ledgers ld
                left join erp_ac_entryitems ei on ei.ledger_id =  ld.id  and ei.is_del=0
                left join erp_ac_entries en on en.id = ei.entry_id  and en.is_del=0
                left join erp_ac_groups gp on gp.id = ld.group_id
                left join erp_ac_account_type typ on typ.id = gp.acc_type_id
                where typ.id = 2
                order by ld.name asc";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data['ledger'] = $qry->result_array();
            foreach ($data['ledger'] as $key => $ledger) {
                $led_id = $ledger['id'];
                $data['ledger'][$key]['ld_open_bal'] = $this->get_opening_balanceof_ledger($led_id);
                $data['ledger'][$key]['ld_close_bal'] =  $this->get_ledger_balance($led_id);
                $data['ledger'][$key]['ld_dr_total'] =  $this->get_dr_total($led_id);
                $data['ledger'][$key]['ld_cr_total'] =  $this->get_cr_total($led_id);
                # code...
            }
        }   else{
            $data['ledger'] = array();
        }
        return $data;
    }

       function get_trial_balance_count($search)
    {


         if(!empty($search))
         {
            $keyword = "%{$search}%";
            $where = " WHERE (  ld.id LIKE '%$keyword%'  OR ld.name LIKE '%$keyword%' OR en.number LIKE '%$keyword%') ";
        }else
        {
            $where = "";
        }


        $data = array();
        $qry = "select
                distinct(ld.id),
                ld.group_id,
                ld.name
                from
                erp_ac_ledgers ld
                left join erp_ac_entryitems ei on ei.ledger_id =  ld.id  and ei.is_del=0
                left join erp_ac_entries en on en.id = ei.entry_id  and en.is_del=0
                left join erp_ac_groups gp on gp.id = ld.group_id
                left join erp_ac_account_type typ on typ.id = gp.acc_type_id ".$where."
                order by ld.id asc";


        $result=$this->db->query($qry);

                     if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else{
            return false;
        } 

    }


           function get_trial_balance_page($search,$limit=NULL,$start=NULL)
    {


       if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (  ld.id LIKE '%$keyword%'  OR ld.name LIKE '%$keyword%' OR en.number LIKE '%$keyword%') ";
        }else{
            $where = "";
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }








        


        $data = array();
          $qry = "select
                distinct(ld.id),
                ld.group_id,
                ld.name
                from
                erp_ac_ledgers ld
                left join erp_ac_entryitems ei on ei.ledger_id =  ld.id  and ei.is_del=0
                left join erp_ac_entries en on en.id = ei.entry_id  and en.is_del=0
                left join erp_ac_groups gp on gp.id = ld.group_id
                left join erp_ac_account_type typ on typ.id = gp.acc_type_id ".$where."
                order by ld.id asc".$pg; 


      $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            $data['ledger'] = $qry->result_array();
            foreach ($data['ledger'] as $key => $ledger) {
                $led_id = $ledger['id'];

                $data['ledger'][$key]['ld_open_bal'] = $this->get_opening_balanceof_ledger($led_id);
                $data['ledger'][$key]['ld_close_bal'] = $this->get_ledger_balance($led_id);
                $data['ledger'][$key]['ld_dr_total'] = $this->get_dr_total($led_id);
                $data['ledger'][$key]['ld_cr_total'] = $this->get_cr_total($led_id);

            }
        } else {
            $data['ledger'] = array();
        }

     //   echo json_encode($data['ledger'][$key]['ld_close_bal']);exit();
        return $data;

    }
    function get_trial_balance()
    {

        $data = array();
        $qry = "select
                distinct(ld.id),
                ld.group_id,
                ld.name
                from
                erp_ac_ledgers ld
                left join erp_ac_entryitems ei on ei.ledger_id =  ld.id  and ei.is_del=0
                left join erp_ac_entries en on en.id = ei.entry_id  and en.is_del=0
                left join erp_ac_groups gp on gp.id = ld.group_id
                left join erp_ac_account_type typ on typ.id = gp.acc_type_id
                order by ld.id asc";


        $qry = $this->db->query($qry);
        if ($qry->num_rows() > 0) {
            $data['ledger'] = $qry->result_array();
            foreach ($data['ledger'] as $key => $ledger) {
                $led_id = $ledger['id'];

                $data['ledger'][$key]['ld_open_bal'] = $this->get_opening_balanceof_ledger($led_id);
                $data['ledger'][$key]['ld_close_bal'] = $this->get_ledger_balance($led_id);
                $data['ledger'][$key]['ld_dr_total'] = $this->get_dr_total($led_id);
                $data['ledger'][$key]['ld_cr_total'] = $this->get_cr_total($led_id);

            }
        } else {
            $data['ledger'] = array();
        }
        return $data;

    }


 function get_balancesheet_new_income($from, $to_date)
    {
        $data = array();
         $_where = "";
        //date filter
        if(($from != "" && $from != NULL) && ($to_date != "" && $to_date != NULL))
        {
            $_where = " and en.date between'".date('Y-m-d',strtotime($from))."' and '".date('Y-m-d',strtotime( $to_date ))."' ";
        }
        elseif($from != "" && $from != NULL)
        {
            $_where = " and en.date = '".date('Y-m-d',strtotime( $from ))."' ";
        }
        elseif($to_date != "" && $to_date != NULL)
        {
            $_where = " and en.date = '".date('Y-m-d',strtotime( $to_date ))."' ";
        }
        $qry = "SELECT  ledger_data.group_id, ledger_data.gp_name, SUM(IFNULL(open_data.open_bal,0)) as open_bal, 
                SUM(IFNULL(dr_data.dr_amount,0)) as dr_amount, 
                SUM(IFNULL(cr_data.cr_amount,0)) as cr_amount,
                (SUM(IFNULL(open_data.open_bal,0))+SUM(IFNULL(dr_data.dr_amount,0))-SUM(IFNULL(cr_data.cr_amount,0))) as balance, 
                ledger_data.acc_type_id
                FROM
                (SELECT lds.id AS id, lds.group_id, grp.name as gp_name, lds.name AS ld_name, grp.acc_type_id FROM erp_ac_ledgers lds
                    LEFT JOIN erp_ac_groups grp ON grp.id = lds.group_id
                ) AS ledger_data
                LEFT JOIN 
                (SELECT CASE WHEN op.op_balance_dc = 'Dr' THEN op.opening_balance ELSE op.opening_balance END as open_bal,  op.ledger_id FROM erp_ac_opening_balance op WHERE op.fy_id = 1) as open_data
                ON ledger_data.id = open_data.ledger_id
                LEFT JOIN
                (SELECT ei.ledger_id, SUM(ei.amount) as dr_amount FROM erp_ac_entryitems ei 
                LEFT JOIN erp_ac_entries en ON en.id = ei.entry_id
                WHERE ei.dc = 'Dr' AND ei.fy_id = 1 AND ei.is_del = 0 $_where GROUP BY ei.ledger_id) AS dr_data ON dr_data.ledger_id = ledger_data.id
                LEFT JOIN
                (SELECT ei.ledger_id, SUM(ei.amount) as cr_amount FROM erp_ac_entryitems ei 
                 LEFT JOIN erp_ac_entries en ON en.id = ei.entry_id
                WHERE ei.dc = 'Cr' AND ei.fy_id = 1 AND ei.is_del = 0 $_where GROUP BY ei.ledger_id) AS cr_data ON cr_data.ledger_id = ledger_data.id
                WHERE ledger_data.acc_type_id = 3
                GROUP BY ledger_data.group_id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data = $qry->result_array();
            
        }   else{
            $data = array();
        }
        return $data;
    }

    function get_balancesheet_income()
    {
        $data = array();
        $qry = "select
                distinct(ld.id),
                ld.group_id,
                ld.name
                from
                erp_ac_ledgers ld
                left join erp_ac_entryitems ei on ei.ledger_id =  ld.id  and ei.is_del=0
                left join erp_ac_entries en on en.id = ei.entry_id  and en.is_del=0
                left join erp_ac_groups gp on gp.id = ld.group_id
                left join erp_ac_account_type typ on typ.id = gp.acc_type_id
                where typ.id = 3
                order by ld.name asc";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data['ledger'] = $qry->result_array();
            foreach ($data['ledger'] as $key => $ledger) {
                $led_id = $ledger['id'];
                $data['ledger'][$key]['ld_open_bal'] = $this->get_opening_balanceof_ledger($led_id);
                $data['ledger'][$key]['ld_close_bal'] =  $this->get_ledger_balance($led_id);
                $data['ledger'][$key]['ld_dr_total'] =  $this->get_dr_total($led_id);
                $data['ledger'][$key]['ld_cr_total'] =  $this->get_cr_total($led_id);
                # code...
            }
        }   else{
            $data['ledger'] = array();
        }
        return $data;
    }
    function get_balancesheet_expence()
    {
        $data = array();
        $qry = "select
                distinct(ld.id),
                ld.group_id,
                ld.name
                from
                erp_ac_ledgers ld
                left join erp_ac_entryitems ei on ei.ledger_id =  ld.id and ei.is_del=0
                left join erp_ac_entries en on en.id = ei.entry_id and en.is_del=0 
                left join erp_ac_groups gp on gp.id = ld.group_id
                left join erp_ac_account_type typ on typ.id = gp.acc_type_id
                where typ.id = 4
                order by ld.name asc";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data['ledger'] = $qry->result_array();
            foreach ($data['ledger'] as $key => $ledger) {
                $led_id = $ledger['id'];
                $data['ledger'][$key]['ld_open_bal'] = $this->get_opening_balanceof_ledger($led_id);
                $data['ledger'][$key]['ld_close_bal'] =  $this->get_ledger_balance($led_id);
                $data['ledger'][$key]['ld_dr_total'] =  $this->get_dr_total($led_id);
                $data['ledger'][$key]['ld_cr_total'] =  $this->get_cr_total($led_id);
                # code...
            }
        }
        else{
            $data['ledger'] = array();
        }
        return $data;
    }


function get_trial_balance_by_date_count($search)
    {

   



        $date_from = date('Y-m-d',strtotime($this->input->post('from_date')));

        $date_to = date('Y-m-d',strtotime($this->input->post('to_date')));


         if(!empty($search))
         {
            $keyword = "%{$search}%";
            $where = " WHERE ( ld.id LIKE '%$keyword%'  OR ld.name LIKE '%$keyword%' OR en.number LIKE '%$keyword%' ) AND en.date between '$date_from' and '$date_to'";
        }else
        {
            $where = "WHERE  en.date between '$date_from' and '$date_to'";
        }


        $data = array();
        $qry = "select
                distinct(ld.id),
                ld.group_id,
                ld.name
                from
                erp_ac_ledgers ld
                left join erp_ac_entryitems ei on ei.ledger_id =  ld.id and ei.is_del=0
                left join erp_ac_entries en on en.id = ei.entry_id and en.is_del=0
                left join erp_ac_groups gp on gp.id = ld.group_id 
                left join erp_ac_account_type typ on typ.id = gp.acc_type_id
               ".$where."
                order by ld.id asc";




        $result=$this->db->query($qry);

                     if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else{
            return false;
        } 

    }


function get_trial_balance_by_date_page($search,$limit=NULL,$start=NULL)
    {

     



        $date_from = date('Y-m-d',strtotime($this->input->post('from_date')));

        $date_to = date('Y-m-d',strtotime($this->input->post('to_date')));

         if(!empty($search)){
            $keyword = "%{$search}%";
           $where = " WHERE (gp.id LIKE '%$keyword%' OR gp.name LIKE '%$keyword%' OR ld.id LIKE '%$keyword%'  OR ld.name LIKE '%$keyword%' OR en.number LIKE '%$keyword%' OR en.date LIKE '%$keyword%' OR et.name LIKE '%$keyword%') AND en.date between '$date_from' and '$date_to'";
        }else{
            $where = "WHERE  en.date between '$date_from' and '$date_to'";
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }

        $data = array();
        $qry = "select
                distinct(ld.id),
                ld.group_id,
                ld.name
                from
                erp_ac_ledgers ld
                left join erp_ac_entryitems ei on ei.ledger_id =  ld.id and ei.is_del=0
                left join erp_ac_entries en on en.id = ei.entry_id and en.is_del=0
                left join erp_ac_groups gp on gp.id = ld.group_id 
                left join erp_ac_account_type typ on typ.id = gp.acc_type_id
                ".$where." 
                order by ld.id asc".$pg;




        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data['ledger'] = $qry->result_array();
            foreach ($data['ledger'] as $key => $ledger) {

                $led_id = $ledger['id'];

                $data['ledger'][$key]['ld_open_bal'] = $this->get_opening_balanceof_ledger($led_id);
                $data['ledger'][$key]['ld_close_bal'] =  $this->get_ledger_balance($led_id);
                $data['ledger'][$key]['ld_dr_total'] =  $this->get_dr_total_date($led_id,$date_from,$date_to);
                $data['ledger'][$key]['ld_cr_total'] =  $this->get_cr_total_date($led_id,$date_from,$date_to);
            }
        }   else{
            $data['ledger'] = array();
        }

        return $data;

    }

function get_trial_balance_bydate()
    {
        $date_from = date('Y-m-d',strtotime($this->input->post('from_date')));

        $date_to = date('Y-m-d',strtotime($this->input->post('to_date')));

        $data = array();
        $qry = "select
                distinct(ld.id),
                ld.group_id,
                ld.name
                from
                erp_ac_ledgers ld
                left join erp_ac_entryitems ei on ei.ledger_id =  ld.id and ei.is_del=0
                left join erp_ac_entries en on en.id = ei.entry_id and en.is_del=0
                left join erp_ac_groups gp on gp.id = ld.group_id 
                left join erp_ac_account_type typ on typ.id = gp.acc_type_id
                where en.date between '$date_from' and '$date_to' 
                order by ld.id asc";




        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data['ledger'] = $qry->result_array();
            foreach ($data['ledger'] as $key => $ledger) {

                $led_id = $ledger['id'];

                $data['ledger'][$key]['ld_open_bal'] = $this->get_opening_balanceof_ledger($led_id);
                $data['ledger'][$key]['ld_close_bal'] =  $this->get_ledger_balance($led_id);
                $data['ledger'][$key]['ld_dr_total'] =  $this->get_dr_total_date($led_id,$date_from,$date_to);
                $data['ledger'][$key]['ld_cr_total'] =  $this->get_cr_total_date($led_id,$date_from,$date_to);
            }
        }   else{
            $data['ledger'] = array();
        }

        return $data;

    }
    function get_dr_total_date($ledger_id,$date_from,$date_to)
    {

        $qry = "select SUM(amount) AS dr_total  from  erp_ac_entryitems
        left join erp_ac_entries on erp_ac_entries.id=erp_ac_entryitems.entry_id and erp_ac_entries.is_del =0
        where erp_ac_entryitems.dc= 'Dr' and erp_ac_entryitems.ledger_id='$ledger_id' and erp_ac_entryitems.is_del=0
        and erp_ac_entries.date between '$date_from' and '$date_to'";


        $qry = $this->db->query($qry);


        if ($dr_total = $qry->row_array()) {

            return $dr_total['dr_total'];
        } else {
            return 0;
        }
    }
    function get_cr_total_date($ledger_id,$date_from,$date_to)
    {

        $qry = "select SUM(amount) AS cr_total  from  erp_ac_entryitems
        left join erp_ac_entries on erp_ac_entries.id=erp_ac_entryitems.entry_id and erp_ac_entries.is_del =0
        where erp_ac_entryitems.dc= 'Cr' and erp_ac_entryitems.ledger_id='$ledger_id' and erp_ac_entryitems.is_del=0
        and erp_ac_entries.date between '$date_from' and '$date_to'";
        $qry = $this->db->query($qry);

        if ($cr_total = $qry->row_array())
            return $cr_total['cr_total'];
        else
            return 0;
    }
      function get_ledger_balance_date($ledger_id,$date_from,$date_to)
    {

        list($op_bal, $op_bal_type) = $this->get_op_balance($ledger_id);
        if ($op_bal_type == "Cr")
            $op_bal = $op_bal;

        $dr_total = $this->get_dr_total_date($ledger_id,$date_from,$date_to);
        $cr_total = $this->get_cr_total_date($ledger_id,$date_from,$date_to);

        $total = $this->float_ops($op_bal, $this->float_ops($dr_total, $cr_total, '-'), '+');
        return $total;
    }






    function opening_stock_report_rate()
    {
        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $from = $finacial['start_year'];

        $qry = "SELECT A.itemid,A.title,IFNULL(B.total_in,0) total_in, IFNULL(C.total_out,0) total_out, 

            (IFNULL(D.total_inn,0) ) as opening,IFNULL(F.normal_ret,0) + IFNULL(G.normal_rets,0) normal_ret,
             IFNULL(I.shortages,0) shortage_qty, IFNULL(J.exp_stock,0) exp_qty, A.selling_price
                FROM 
                (SELECT its.id itemid, its.title AS title,its.selling_price FROM items its WHERE its.is_del = 0) AS A
                LEFT JOIN
                (SELECT it.id as itemids, 
                SUM(ir.received_qty) as total_in FROM item_received ir
                INNER JOIN purchase_item pi ON pi.id = ir.purchase_item_id AND pi.is_del = 0
                LEFT JOIN items it ON it.id = pi.item_id AND it.is_del = 0
                WHERE ir.is_del = 0 and ir.received_date < $from GROUP BY pi.item_id) AS B 
                ON A.itemid = B.itemids
                LEFT JOIN
                (SELECT itt.id as it_id, si.item_id as itemidd, SUM(si.qty) as total_out FROM sales_items si
                LEFT JOIN sales s ON s.id = si.sales_id AND s.is_del = 0
                LEFT JOIN items itt ON itt.id = si.item_id AND itt.is_del = 0
                WHERE si.is_del = 0 AND s.sale_date < $from GROUP BY si.item_id) AS C
                ON A.itemid = C.it_id
                
               
                LEFT JOIN
                (SELECT itss.id itemid, SUM(irr.received_qty) as total_inn FROM item_received irr
                INNER JOIN purchase_item pi ON pi.id = irr.purchase_item_id AND pi.is_del = 0
                LEFT JOIN items itss ON itss.id = pi.item_id AND itss.is_del = 0
                WHERE irr.is_del = 0  and irr.received_date < '$from' GROUP BY pi.item_id) AS D 
                ON A.itemid = D.itemid
                
                 LEFT JOIN
                (SELECT itt.id as it_id, SUM(si.qty) as total_outs FROM sales_items si
                LEFT JOIN sales s ON s.id = si.sales_id AND s.is_del = 0
                LEFT JOIN items itt ON itt.id = si.item_id AND itt.is_del = 0
                WHERE si.is_del = 0   and s.sale_date < '$from' GROUP BY si.item_id) AS E
                ON A.itemid = E.it_id

                LEFT JOIN(SELECT sri.item_id, sum(sri.ret_qty) as normal_ret FROM sales_return_items sri 
                LEFT JOIN sales_return sr ON sr.id = sri.sales_ret_id AND sr.is_del = 0
                LEFT JOIN items itt ON itt.id = sri.item_id AND itt.is_del = 0
                WHERE sri.reason_type = 'NORMAL' AND sri.is_del = 0 and sr.return_date < $from GROUP BY sri.item_id) as F
                    ON A.itemid = F.item_id
                
                LEFT JOIN(SELECT sri.item_id, sum(sri.ret_qty) as normal_rets FROM sales_return_items sri 
                LEFT JOIN sales_return sr ON sr.id = sri.sales_ret_id AND sr.is_del = 0
                    LEFT JOIN items itt ON itt.id = sri.item_id AND itt.is_del = 0
                    WHERE sri.reason_type = 'NORMAL' AND sri.is_del = 0 AND sr.return_date < '$from' GROUP BY sri.item_id) as G
                    ON A.itemid = G.item_id
                    
                     LEFT JOIN(SELECT sri.item_id, sum(sri.ret_qty) as shortage FROM sales_return_items sri 
                LEFT JOIN sales_return sr ON sr.id = sri.sales_ret_id AND sr.is_del = 0
                LEFT JOIN items itt ON itt.id = sri.item_id AND itt.is_del = 0
                WHERE sri.reason_type = 'SHORTAGE' AND sri.is_del = 0 and sr.return_date <$from GROUP BY sri.item_id) as H
                    ON A.itemid = H.item_id
                
                LEFT JOIN(SELECT sri.item_id, sum(sri.ret_qty) as shortages FROM sales_return_items sri 
                LEFT JOIN sales_return sr ON sr.id = sri.sales_ret_id AND sr.is_del = 0
                    LEFT JOIN items itt ON itt.id = sri.item_id AND itt.is_del = 0
                    WHERE sri.reason_type = 'SHORTAGE' AND sri.is_del = 0 AND sr.return_date < '$from' GROUP BY sri.item_id) as I
                    ON A.itemid = I.item_id
                    
                    
                 LEFT JOIN(SELECT sum(stk.qty) exp_stock, stk.item_id FROM expired_stock stk 
                        LEFT JOIN items itt ON itt.id = stk.item_id AND itt.is_del = 0
                        WHERE stk.is_del=0 AND  stk.sales_ret_id= 0 GROUP BY stk.item_id) as J
                        ON A.itemid = J.item_id    
                    
                LEFT JOIN(SELECT sum(stk.qty) exp_stock, stk.item_id FROM expired_stock stk 
                        LEFT JOIN items itt ON itt.id = stk.item_id AND itt.is_del = 0
                        WHERE stk.is_del=0 AND stk.sales_ret_id= 0 AND stk.exp_date < '$from' GROUP BY stk.item_id) as K
                        ON A.itemid = K.item_id";

        $qry = $this->db->query($qry);
//echo $this->db->last_query();exit;
        if($qry->num_rows()){
            return $qry->result_array();
        }   else{
            return array();
        } 
    }

    function closing_stock_report_rate()
    {
        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];
        $from = $finacial['start_year'];
        $toDate = $finacial['end_year'];
        $qry = "SELECT A.itemid,A.title,IFNULL(B.total_in,0) total_in, IFNULL(C.total_out,0) total_out, 

            (IFNULL(D.total_inn,0) - IFNULL(E.total_outs,0)-IFNULL(I.shortages,0)+IFNULL(G.normal_rets,0)) as opening,IFNULL(F.normal_ret,0) + IFNULL(G.normal_rets,0) normal_ret,
             IFNULL(I.shortages,0) shortage_qty, IFNULL(J.exp_stock,0) exp_qty, A.selling_price
                FROM 
                (SELECT its.id itemid, its.title AS title,its.selling_price FROM items its WHERE its.is_del = 0) AS A
                LEFT JOIN
                (SELECT it.id as itemids, 
                SUM(ir.received_qty) as total_in FROM item_received ir
                INNER JOIN purchase_item pi ON pi.id = ir.purchase_item_id AND pi.is_del = 0
                LEFT JOIN items it ON it.id = pi.item_id AND it.is_del = 0
                WHERE ir.is_del = 0 and ir.received_date < $toDate GROUP BY pi.item_id) AS B 
                ON A.itemid = B.itemids
                LEFT JOIN
                (SELECT itt.id as it_id, si.item_id as itemidd, SUM(si.qty) as total_out FROM sales_items si
                LEFT JOIN sales s ON s.id = si.sales_id AND s.is_del = 0
                LEFT JOIN items itt ON itt.id = si.item_id AND itt.is_del = 0
                WHERE si.is_del = 0 AND s.sale_date < $toDate GROUP BY si.item_id) AS C
                ON A.itemid = C.it_id
                
               
                LEFT JOIN
                (SELECT itss.id itemid, SUM(irr.received_qty) as total_inn FROM item_received irr
                INNER JOIN purchase_item pi ON pi.id = irr.purchase_item_id AND pi.is_del = 0
                LEFT JOIN items itss ON itss.id = pi.item_id AND itss.is_del = 0
                WHERE irr.is_del = 0  and irr.received_date < '$toDate' GROUP BY pi.item_id) AS D 
                ON A.itemid = D.itemid
                
                 LEFT JOIN
                (SELECT itt.id as it_id, SUM(si.qty) as total_outs FROM sales_items si
                LEFT JOIN sales s ON s.id = si.sales_id AND s.is_del = 0
                LEFT JOIN items itt ON itt.id = si.item_id AND itt.is_del = 0
                WHERE si.is_del = 0   and s.sale_date < '$toDate' GROUP BY si.item_id) AS E
                ON A.itemid = E.it_id

                LEFT JOIN(SELECT sri.item_id, sum(sri.ret_qty) as normal_ret FROM sales_return_items sri 
                LEFT JOIN sales_return sr ON sr.id = sri.sales_ret_id AND sr.is_del = 0
                LEFT JOIN items itt ON itt.id = sri.item_id AND itt.is_del = 0
                WHERE sri.reason_type = 'NORMAL' AND sri.is_del = 0 and sr.return_date < $toDate GROUP BY sri.item_id) as F
                    ON A.itemid = F.item_id
                
                LEFT JOIN(SELECT sri.item_id, sum(sri.ret_qty) as normal_rets FROM sales_return_items sri 
                LEFT JOIN sales_return sr ON sr.id = sri.sales_ret_id AND sr.is_del = 0
                    LEFT JOIN items itt ON itt.id = sri.item_id AND itt.is_del = 0
                    WHERE sri.reason_type = 'NORMAL' AND sri.is_del = 0 AND sr.return_date < '$toDate' GROUP BY sri.item_id) as G
                    ON A.itemid = G.item_id
                    
                     LEFT JOIN(SELECT sri.item_id, sum(sri.ret_qty) as shortage FROM sales_return_items sri 
                LEFT JOIN sales_return sr ON sr.id = sri.sales_ret_id AND sr.is_del = 0
                LEFT JOIN items itt ON itt.id = sri.item_id AND itt.is_del = 0
                WHERE sri.reason_type = 'SHORTAGE' AND sri.is_del = 0 and sr.return_date <$toDate GROUP BY sri.item_id) as H
                    ON A.itemid = H.item_id
                
                LEFT JOIN(SELECT sri.item_id, sum(sri.ret_qty) as shortages FROM sales_return_items sri 
                LEFT JOIN sales_return sr ON sr.id = sri.sales_ret_id AND sr.is_del = 0
                    LEFT JOIN items itt ON itt.id = sri.item_id AND itt.is_del = 0
                    WHERE sri.reason_type = 'SHORTAGE' AND sri.is_del = 0 AND sr.return_date < '$toDate' GROUP BY sri.item_id) as I
                    ON A.itemid = I.item_id
                    
                    
                 LEFT JOIN(SELECT sum(stk.qty) exp_stock, stk.item_id FROM expired_stock stk 
                        LEFT JOIN items itt ON itt.id = stk.item_id AND itt.is_del = 0
                        WHERE stk.is_del=0 AND  stk.sales_ret_id= 0 GROUP BY stk.item_id) as J
                        ON A.itemid = J.item_id    
                    
                LEFT JOIN(SELECT sum(stk.qty) exp_stock, stk.item_id FROM expired_stock stk 
                        LEFT JOIN items itt ON itt.id = stk.item_id AND itt.is_del = 0
                        WHERE stk.is_del=0 AND stk.sales_ret_id= 0 AND stk.exp_date < '$toDate' GROUP BY stk.item_id) as K
                        ON A.itemid = K.item_id";

        $qry = $this->db->query($qry);

        if($qry->num_rows()){
            return $qry->result_array();
        }   else{
            return array();
        } 
    }




function update_financial_year($data)
{
 $id = $data['id'];
        $f_start = $data['f_start'];
        $f_start1=convert_to_mysql($f_start);
        $f_end = $data['f_end'];
        $f_end1=convert_to_mysql($f_end);

        $info = array('id_current' => 0,

        );
//        $qry = $this->db->insert('customers', $info);
        $this->db->where('id', $id);
        $qry = $this->db->update('financial_year', $info);


        if($qry)
        {


            $info_new = array(
                'start_year' => $f_start1,
                'end_year' => $f_end1,
                'id_current'=>1


        );
        $qry11 = $this->db->insert('financial_year', $info_new);


 $f_id = $this->db->insert_id();


$qry_cls = "select
                gp.id,
                gp.acc_type_id,
                gp.name,
                ld.id as ld_id,
                ld.name as ld_name,
                ld._type,
                op.op_balance_dc as op_dc,
                concat(op.op_balance_dc, ' ', op.opening_balance) opening_balance
                from
                erp_ac_ledgers ld
                LEFT JOIN erp_ac_opening_balance op ON op.ledger_id = ld.id
                LEFT JOIN erp_ac_groups gp on gp.id = ld.group_id
                   order by ld.id  asc";  

        $qry_cls = $this->db->query($qry_cls);
        if ($qry_cls->num_rows() > 0) {
            $data['ledger'] = $qry_cls->result_array();
            foreach ($data['ledger'] as $key => $ledger) {
                $ld_id = $ledger['ld_id'];
                // $opdc=
                $closing = $this->get_new_ledger_balance_financial($ld_id,$id);
               // $data['ledger'][$key]['closing'] = $closing['current_balance'];



if($closing['current_balance']>0)
{
    $opdc='Dr'; 
}
else
{
$opdc='Cr'; 
}


       $opening_arr = array(
            'opening_balance' =>$closing['current_balance'],
            'op_balance_dc' => $opdc,
            'ledger_id' => $ld_id,
            'opening_date' => $f_start1,
            'fy_id' => $f_id
         );
        $open_qry = $this->db->insert('erp_ac_opening_balance', $opening_arr);







            }


        } 








        }












        return  $qry11 ;
}


function  get_new_ledger_balance_financial($ledger_id,$fy_id)
{
     // $finacial = get_current_financial_year();
     //  //  echo json_encode($finacial);exit();
     //    $fy_id = $finacial['id'];
     //    $fy_start = $finacial['start_year'];
     //    $fy_end = $finacial["end_year"];

          $qry = "SELECT  SUM(open_data.open_bal) as open_bal, 
                SUM(IFNULL(dr_data.dr_amount,0)) as dr_amount, 
                SUM(IFNULL(cr_data.cr_amount,0)) as cr_amount,
                IFNULL(((IFNULL(open_bal,0)+IFNULL(dr_amount,0))-IFNULL(cr_amount,0)),0) as current_balance
                FROM
                (SELECT lds.id AS id, lds.group_id, lds.name AS ld_name FROM erp_ac_ledgers lds WHERE lds.id = $ledger_id
                ) AS ledger_data
                LEFT JOIN 
                (SELECT CASE WHEN op.op_balance_dc = 'Dr' THEN op.opening_balance ELSE op.opening_balance END as open_bal,  op.ledger_id FROM erp_ac_opening_balance op WHERE op.fy_id = '$fy_id' AND op.ledger_id = $ledger_id) as open_data
                ON ledger_data.id = open_data.ledger_id
                LEFT JOIN
                (SELECT ei.ledger_id, SUM(ei.amount) as dr_amount FROM erp_ac_entryitems ei 
                LEFT JOIN erp_ac_entries en ON en.id = ei.entry_id
                WHERE ei.dc = 'Dr' AND ei.fy_id = '$fy_id' AND ei.is_del = 0 AND ei.ledger_id = $ledger_id) AS dr_data ON dr_data.ledger_id = ledger_data.id
                LEFT JOIN
                (SELECT ei.ledger_id, SUM(ei.amount) as cr_amount FROM erp_ac_entryitems ei 
                 LEFT JOIN erp_ac_entries en ON en.id = ei.entry_id
                WHERE ei.dc = 'Cr' AND ei.fy_id = '$fy_id' AND ei.is_del = 0 AND ei.ledger_id = $ledger_id) AS cr_data ON cr_data.ledger_id = ledger_data.id"; 
        $qry = $this->db->query($qry);   
         
         if ($qry->num_rows() > 0) {
            $result = $qry->row_array();
         }  else{
            $result = array();
         }
         return $result;
}




    ////////////////////////////////////////////////


    function float_ops($param1 = 0, $param2 = 0, $op = '')
    {
        $result = 0;
        $param1 = $param1 * 100;
        $param2 = $param2 * 100;
        $param1 = (int)$param1;
        $param2 = (int)$param2;
        switch ($op) {
            case '+':
                $result = $param1 + $param2;
                break;
            case '-':
                $result = $param1 - $param2;
                break;
            case '==':
                if ($param1 == $param2)
                    return TRUE;
                else
                    return FALSE;
                break;
            case '!=':
                if ($param1 != $param2)
                    return TRUE;
                else
                    return FALSE;
                break;
            case '<':
                if ($param1 < $param2)
                    return TRUE;
                else
                    return FALSE;
                break;
            case '>':
                if ($param1 > $param2)
                    return TRUE;
                else
                    return FALSE;
                break;

        }
        $result = $result / 100;
        return $result;
    }


}