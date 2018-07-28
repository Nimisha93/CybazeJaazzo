<?php
/**
 * Created by PhpStorm.
 * User: faisal
 * Date: 1/11/17
 * Time: 5:24 PM
 */

class Mdl_entries extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_acc_type_group_ledger()
    {
        $data = array();
        $qry = "select * from erp_ac_account_type";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data['type'] = $qry->result_array();

            foreach ($data['type'] as $key => $type) {
                $type_id = $type['id'];
                $qry_grp = "select * from erp_ac_groups where acc_type_id = '$type_id'";
                $qry_grp = $this->db->query($qry_grp);
                if($qry_grp->num_rows()>0){
                    $data['type'][$key]['group'] = $qry_grp->result_array();
                    foreach ($data['type'][$key]['group'] as $keys => $group) {
                        $grp_id = $group['id'];
                        $qry_ledger = "select * from erp_ac_ledgers  where group_id = '$grp_id'";
                        $qry_ledger = $this->db->query($qry_ledger);
                        if($qry_ledger->num_rows()>0){
                            $data['type'][$key]['group'][$keys]['ledger'] = $qry_ledger->result_array();
                        }else{
                            $data['type'][$key]['group'][$keys]['ledger'] = array();
                        }

                    }
                } else{
                    $data['type'][$key]['group'] = array();
                }
            }
        } else{
            $data['type'] = array();
        }
        return $data;
    }

    function create_entry_no()
    {
        $qry = "select
				en.number
				from
				erp_ac_entries en order by en.id desc limit 0,1";
        $qry = $this->db->query($qry);
        //echo $this->db->last_query(); exit;
        if($qry->num_rows()>0)
        {
            $ret = $qry->row_array();
            $numb = $ret['number'] + 1;
            return $numb;
        }	else{
            return 1;
        }
    }

    function get_entry_type()
    {
        $qry = "select * from erp_ac_entry_types";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        } else{
            return array();
        }
    }

    function add_new_entry(){

        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $created_on=   date('Y-m-d');


        $this->db->trans_begin();


       $date=$this->input->post('entry_date');
        $date1=convert_to_mysql($date);
        
        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];

        $entry_id=$this->input->post('en_type');

        $total_dr = $this->input->post('amount_dr');

        //echo json_encode($total_dr);exit();
        $dr_sum = 0;
        foreach ($total_dr as $key => $dr_value1) {
if($dr_value1!="")
{
     $dr_sum += $dr_value1;
}
           
        }
                 //echo json_encode($dr_sum);exit();

        $total_cr = $this->input->post('amount_cr');
        $cr_sum = 0;
        foreach ($total_cr as $key => $cr_value) {

            if($cr_value!="")
{
            $cr_sum += $cr_value;
        }

        }
        $data = array(
            'entrytype_id' => $entry_id,
            'number' =>$this->input->post('number'),
            'date' => $date1,
            'fy_id' => $fy_id,
            'dr_total' => $dr_sum,
            'cr_total' => $cr_sum,
            '_type'=>"ACCOUNT",
            'type_id'=>'',

            'narration' => $this->input->post('narration'),
//            'branch_id'=>$created_by
        );
        $qry = $this->db->insert('erp_ac_entries', $data);



        if($qry)
        {
            $insert_id = $this->db->insert_id();
        } else{

        }
        $ledger_id = $this->input->post('ledger_name');
        $amount_dr =$this->input->post('amount_dr');
        $amount_cr = $this->input->post('amount_cr');
      //  $property=$this->input->post('property_name');
        $cr_dr = $this->input->post('ledger_opening_type');
        foreach ($ledger_id as $key => $ledger) {
            if($amount_dr[$key] == ''){
                $amnt = $amount_cr[$key];
            }if($amount_cr[$key] == ''){
                $amnt = $amount_dr[$key];
            }
            $entry_item[] = array(
                'entry_id' => $insert_id,
                'ledger_id' => $ledger,
                'amount' => $amnt,
                'fy_id' => $fy_id,
                'dc' => $cr_dr[$key],
                'created_date' => date('Y-m-d')
            );
        }
        $ins_qry = $this->db->insert_batch('erp_ac_entryitems', $entry_item);


     //   return $ins_qry;


        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return $ins_qry;;
        }


    }



     function get_all_privillages($search,$limit=NULL,$start=NULL)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (pg.id LIKE '%$keyword%' OR pg.slug LIKE '%$keyword%' OR pg.title LIKE '%$keyword%' OR ep.title LIKE '%$keyword%') AND ep.id IS NOT NULL ";
        }else{
            $where = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT pg.*, GROUP_CONCAT(ep.privilege) as privileges from gp_privilege_group_con epgc 
                INNER join gp_privileges ep on epgc.privilege_id = ep.id 
                INNER join gp_privilege_group pg on pg.id= epgc.group_id".$where." GROUP BY epgc.group_id ORDER BY epgc.id DESC".$pg;
        $result=$this->db->query($query);

        if($result->num_rows()>0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
    }



    function get_entries_count($search)
    {
                 if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (en.date LIKE '%$keyword%' OR en.number LIKE '%$keyword%' OR et.name LIKE '%$keyword%' ) AND en.id IS NOT NULL ";
        }else{
            $where = '';
        }


 $qry = "select
                    en.id,
                    DATE_FORMAT(en.date, '%d-%m-%Y') as en_date,
                    en.number,
                    et.name as en_type,

                    CONCAT('Dr ', en.dr_total) as dr_total,
                    CONCAT('Cr ', en.cr_total) as cr_total
                    from
                    erp_ac_entries en
                    left join erp_ac_entry_types et on et.id = en.entrytype_id
                    left join erp_ac_entryitems ei on ei.entry_id = en.id
                    left join erp_ac_ledgers ld on ld.id = ei.ledger_id
                     
        ".$where." AND en.is_del!=1 
                    group by en.id
                    order by en.id desc";

                    $result=$this->db->query($qry);

                     if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else{
            return false;
        } 



    }

    function get_entries($search,$limit=NULL,$start=NULL)
    {


        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (en.date LIKE '%$keyword%' OR en.number LIKE '%$keyword%' OR et.name LIKE '%$keyword%' OR en.dr_total LIKE '%$keyword%' OR en.cr_total LIKE '%$keyword%') AND en.id IS NOT NULL ";
        }else{
            $where = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }

        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $created_on = date('Y-m-d H:i:s');




        $qry = "select
					en.id,
					DATE_FORMAT(en.date, '%d-%m-%Y') as en_date,
					en.number,
					et.name as en_type,

					CONCAT('Dr ', en.dr_total) as dr_total,
					CONCAT('Cr ', en.cr_total) as cr_total
					from
					erp_ac_entries en
					left join erp_ac_entry_types et on et.id = en.entrytype_id
					left join erp_ac_entryitems ei on ei.entry_id = en.id
					left join erp_ac_ledgers ld on ld.id = ei.ledger_id
					 ".$where." and en.is_del!=1
					group by en.id
					order by en.id desc".$pg;

        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }	else{
            return array();
        }
    }

    function get_entries_by_id($id){



        $qry = "select
				en.id as en_id,
				en.entrytype_id,
				ety.name,
				en.number,
				DATE_FORMAT(en.date, '%d-%m-%Y') en_date,
				ld.id ld_id,
				ld.name ld_name,
				ei.id ei_id,
				ei.dc,
				ei.amount,
				if(ei.dc = 'Cr', (ei.amount), '') as cr_cur_amount,
				if(ei.dc = 'Dr', (ei.amount), '')as dr_cur_amount,
				if(ei.dc = 'Cr', concat(ei.dc, ' ', ei.amount), '-') as cr_amount,
				if(ei.dc = 'Dr', CONCAT(ei.dc , ' ', ei.amount), '-')as dr_amount,
				en.dr_total,
				en.cr_total,
				en.narration
				from
				erp_ac_entries en
				left join erp_ac_entryitems ei on ei.entry_id = en.id
				left join erp_ac_ledgers ld on ld.id = ei.ledger_id
				left join erp_ac_entry_types ety on ety.id = en.entrytype_id
				where en.id = '$id' and ei.is_del!='1' and en.is_del!='1'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }	else{
            return array();
        }

    }

    function get_entry_items_by_id($ent_id){

        $qry="select ei.id,ei.ledger_id,ei.dc,ei.amount, ec.entrytype_id, DATE_FORMAT(ec.date,'%d-%m-%Y') as en_date,
          if(ei.dc = 'Cr', (ei.amount), '') as cr_cur_amount,
                if(ei.dc = 'Dr', (ei.amount), '')as dr_cur_amount,

                ld.name as ld_name,ec.id as en_id  from   erp_ac_entryitems ei
              left join erp_ac_entries ec on ec.id =ei.entry_id
              left join erp_ac_ledgers  ld on ld.id = ei.ledger_id
              where ei.entry_id = '$ent_id' and ei.is_del!=1";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }	else{
            return array();
        }

    }
    function update_entry_items($entry_id)
    {
        $this->db->trans_begin();
        $total_dr = $this->input->post('amount_dr');
        $dr_sum =0;
        foreach ($total_dr as $key => $dr_value) {
            if($dr_value!="")
{
            $dr_sum += $dr_value;
        }
        }
        $total_cr = $this->input->post('amount_cr');
        $cr_sum = 0;
        foreach ($total_cr as $key => $cr_value) {

                        if($cr_value!="")
{
            $cr_sum += $cr_value;
        }
        }

        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];


        $ledger_id = $this->input->post('ledger_name');
        $amount_dr = $this->input->post('amount_dr');
        $amount_cr = $this->input->post('amount_cr');
        $cr_dr = $this->input->post('ledger_opening_type');
        $entry_item_id = $this->input->post('entry_item_id');
        foreach ($entry_item_id as $key => $entry_item) {
            if($amount_dr[$key] == ''){
                $amnt = $amount_cr[$key];
            }if($amount_cr[$key] == ''){
                $amnt = $amount_dr[$key];
            }
            $entry_item_up= array(
                'entry_id' => $entry_id,
                'ledger_id' => $ledger_id[$key],
                'fy_id' => $fy_id,
                'amount' => $amnt,
                'dc' => $cr_dr[$key],
                'updated_date' => date('Y-m-d H:i:s')
            );
            $this->db->where('id', $entry_item);
            $qrys = $this->db->update('erp_ac_entryitems', $entry_item_up);
        }
        if(($this->input->post('ledger_opening_type_new')) != NULL){

            $totals_dr = $this->input->post('amount_dr_new');

            foreach ($totals_dr as $key => $dr_value) {
                $dr_sum += $dr_value;
            }

            $totals_cr = $this->input->post('amount_cr_new');

            foreach ($totals_cr as $key => $cr_value) {
                $cr_sum += $cr_value;
            }

            $new_ledger_id = $this->input->post('ledger_name_new');
            $new_amount_dr = $this->input->post('amount_dr_new');
            $new_amount_cr = $this->input->post('amount_cr_new');
            $new_cr_dr = $this->input->post('ledger_opening_type_new');
            $entry_item = array();
            foreach ($new_ledger_id as $key => $ledger_new) {
                if($new_amount_dr[$key] == ''){
                    $amnts = $new_amount_cr[$key];
                }if($new_amount_cr[$key] == ''){
                    $amnts = $new_amount_dr[$key];
                }
                $entry_item[] = array(
                    'entry_id' => $entry_id,
                    'ledger_id' => $ledger_new,
                    'fy_id' => $fy_id,
                    'amount' => $amnts,
                    'dc' => $new_cr_dr[$key],
                    'created_date' => date('Y-m-d H:i:s')
                );
            }
            $ins_qry = $this->db->insert_batch('erp_ac_entryitems', $entry_item);
        }
        $entry_date = $this->input->post('entry_date');
        $entry_date = convert_to_mysql($entry_date);
        $data = array(
            'entrytype_id' => $this->input->post('en_type'),
            'number' => $this->input->post('number'),
            'date' => $entry_date,
            'fy_id' => $fy_id,
            'dr_total' => $dr_sum,
            'cr_total' => $cr_sum,
            'narration' => $this->input->post('narration')
        );
        $this->db->where('id', $entry_id);
        $qry = $this->db->update('erp_ac_entries', $data);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    function edit_entry_by_id($id){

        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $created_on=   date('Y-m-d');


        $this->db->trans_begin();

        // $date=$this->input->post('entry_date');
        $date=$this->input->post('entry_date');
        $date1=convert_to_mysql($date);
        $finacial = get_current_financial_year();
        $fy_id = $finacial['id'];

        $entry_id=$this->input->post('en_type');

        $total_dr = $this->input->post('amount_dr');
        $dr_sum = '';
        foreach ($total_dr as $key => $dr_value) {
            $dr_sum += $dr_value;
        }
        $total_cr = $this->input->post('amount_cr');
        $cr_sum = '';
        foreach ($total_cr as $key => $cr_value) {
            $cr_sum += $cr_value;
        }
        $data = array(
            'entrytype_id' => $entry_id,
            'number' =>$this->input->post('number'),
            'date' => $date1,
            'fy_id' => $fy_id,
            'dr_total' => $dr_sum,
            'cr_total' => $cr_sum,
            'type'=>"ACCOUNT",
            'type_id'=>'',

            'narration' => $this->input->post('narration'),
//            'branch_id'=>$created_by
        );
//        $qry = $this->db->insert('erp_ac_entries', $data);
        $this->db->where('id', $id);
        $qry = $this->db->update('erp_ac_entries', $data);


        $ledger_id = $this->input->post('ledger_name');
        $amount_dr =$this->input->post('amount_dr');
        $amount_cr = $this->input->post('amount_cr');
        //  $property=$this->input->post('property_name');
        $cr_dr = $this->input->post('ledger_opening_type');
        foreach ($ledger_id as $key => $ledger) {
            if($amount_dr[$key] == ''){
                $amnt = $amount_cr[$key];
            }if($amount_cr[$key] == ''){
                $amnt = $amount_dr[$key];
            }



            $entry_item= array(
                'entry_id' => $id,
                'ledger_id' => $ledger,
                'amount' => $amnt,
                'fy_id' => $fy_id,
                'dc' => $cr_dr[$key],
                'created_date' => date('Y-m-d')
            );
        }
      //  $ins_qry = $this->db->insert_batch('erp_ac_entryitems', $entry_item);
        $this->db->where('id', $ledger);
        $qrys = $this->db->update('erp_ac_entryitems', $entry_item);


        //   return $ins_qry;


        if(($this->input->post('ledger_opening_type_new')) != NULL){





            $totals_dr = $this->input->post('amount_dr_new');

            foreach ($totals_dr as $key => $dr_value) {
                $dr_sum += $dr_value;
            }

            $totals_cr = $this->input->post('amount_cr_new');

            foreach ($totals_cr as $key => $cr_value) {
                $cr_sum += $cr_value;
            }


            $data44 = array(
                'dr_total' => $dr_sum,
                'cr_total' => $cr_sum,
                'fy_id' => $fy_id
            );
//        $qry = $this->db->insert('erp_ac_entries', $data);
            $this->db->where('id', $id);
            $qry = $this->db->update('erp_ac_entries', $data44);



            $new_ledger_id = $this->input->post('ledger_name_new');
            $new_amount_dr = $this->input->post('amount_dr_new');
            $new_amount_cr = $this->input->post('amount_cr_new');
            $new_cr_dr = $this->input->post('ledger_opening_type_new');
            $entry_item = array();
            foreach ($new_ledger_id as $key => $ledger_new) {
                if($new_amount_dr[$key] == ''){
                    $amnts = $new_amount_cr[$key];
                }if($new_amount_cr[$key] == ''){
                    $amnts = $new_amount_dr[$key];
                }
                $entry_item[] = array(
                    'entry_id' => $id,
                    'ledger_id' => $ledger_new,
                    'amount' => $amnts,
                    'fy_id' => $fy_id,
                    'dc' => $new_cr_dr[$key],
                    'created_date' => date('Y-m-d H:i:s')
                );
            }
            $ins_qry = $this->db->insert_batch('erp_ac_entryitems', $entry_item);
        }


        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return $qrys;;
        }

    }

    function delete_entry_items($data){


        $itemgrp = $data['itemgrps'];
      //  $en_id = $data['itemgrps'];
        $info = array('is_del' => 1);
        $this->db->where_in('id', $itemgrp);
        $qry = $this->db->update('erp_ac_entryitems', $info);
        return $qry;


    }

    function delete_entry($data){

        $itemgrp = $data['itemgrps'];
        //  $en_id = $data['itemgrps'];
        $info = array('is_del' => 1);
        $this->db->where_in('id', $itemgrp);
        $qry = $this->db->update('erp_ac_entries', $info);

        $info = array('is_del' => 1);
        $this->db->where_in('entry_id', $itemgrp);
        $qry = $this->db->update('erp_ac_entryitems', $info);

//        $this->db->where('entry_id', $en_id);
//        $qry = $this->db->delete('erp_ac_entryitems');
        return $qry;
    }


    function addGroup($data){
        $sel_typee = $data['sel_typee'];
        $group_name = $data['groupname'];
        $data = array(
            'acc_type_id' => $sel_typee,
            'name' => $group_name
        );
        $qry = $this->db->insert('erp_ac_groups', $data);
        return $qry;


    }

    function get_groups(){

        $qry = "select ec.*,ect.name as account,ect.id as ac_id  from erp_ac_groups ec
        left join erp_ac_account_type ect on ect.id=ec.acc_type_id  order by acc_type_id";
        $qry1 = $this->db->query($qry);

        if($qry1->num_rows()>0){

            return $qry1->result_array();



        }

    }

    function get_acc_types(){





    }



    function get_ledgers(){

        $data = array();
        $qry = "select
				gp.id,
				gp.acc_type_id,
				gp.name,
				ld.id as ld_id,
				ld.name as ld_name,
				concat(ld.op_balance_dc, ' ', ld.opening_balance) opening_balance
				from
				erp_ac_ledgers ld
				left join erp_ac_groups gp on gp.id = ld.group_id
				order by ld.id  desc";
//        if($type=='branch'){
//
//            $qry = "select
//				gp.id,
//				gp.acc_type_id,
//				gp.name,
//				ld.id as ld_id,
//				ld.name as ld_name,
//				concat(ld.op_balance_dc, ' ', ld.opening_balance) opening_balance
//				from
//				erp_ac_ledger ld
//				left join erp_ac_groups gp on gp.id = ld.group_id where ld.branch_id='$created_by'
//				order by gp.name asc";
//        }
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data['ledger'] = $qry->result_array();
            foreach ($data['ledger'] as $key => $ledger) {
                $ld_id = $ledger['ld_id'];
                $closing = $this->get_ledger_balance($ld_id);
                $data['ledger'][$key]['closing'] = $closing;
            }
        } else{
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

    function get_op_balance($ledger_id)
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $created_on = date('Y-m-d H:i:s');


        $this->db->from('erp_ac_ledgers')->where('id', $ledger_id)->limit(1);
        $op_bal_q = $this->db->get();

        if ($op_bal = $op_bal_q->row())
            return array($op_bal->opening_balance, $op_bal->op_balance_dc);
        else
            return array(0, "Dr");
    }

    function get_dr_total($ledger_id)
    {

        $qry="select SUM(amount) AS dr_total  from  erp_ac_entryitems
        left join erp_ac_entries on erp_ac_entries.id=erp_ac_entryitems.entry_id
        where erp_ac_entryitems.dc= 'Dr' and erp_ac_entryitems.ledger_id='$ledger_id'";



        $qry = $this->db->query($qry);


        if ($dr_total = $qry->row_array())


            return $dr_total['dr_total'];

        else
            return 0;
    }
    /* Return credit total as positive value */
    function get_cr_total($ledger_id)
    {

        $qry="select SUM(amount) AS cr_total  from  erp_ac_entryitems
        left join erp_ac_entries on erp_ac_entries.id=erp_ac_entryitems.entry_id
        where erp_ac_entryitems.dc= 'Cr' and erp_ac_entryitems.ledger_id='$ledger_id'";
        $qry = $this->db->query($qry);

        if ($cr_total = $qry->row_array())
            return $cr_total['cr_total'];
        else
            return 0;
    }


    function editgroup($id,$data){

        $acc_type = $data['sel_typee'];
        $group = $data['groupname'];

        $info = array('name' => $group,
            'acc_type_id' =>$acc_type,

        );

        $this->db->where('id', $id);
        $qry = $this->db->update('erp_ac_groups', $info);

        return $qry;
    }

    function get_ledegr_by_id($id){

        $this->db->where('id', $id);
        $qry = $this->db->get('erp_ac_ledgers');
        if($qry->num_rows()>0)
        {
            return $qry->row_array();
        }else{
            return array();
        }

    }

    function edit_ledegr_by_id($id,$data){

        $group = $data['group_name'];
        $ledger = $data['ledger'];
        $ledgerOpBalanceDc = $data['ledgerOpBalanceDc'];
        $openigbal = $data['openigbal'];
        $description = $data['description'];


        $info = array('name' => $ledger,
            'group_id' =>$group,
            '_type' =>"ACCOUNT",
            'type_id' =>'',
            'opening_balance'=>$openigbal,
            'op_balance_dc'=>$ledgerOpBalanceDc,
            'note'=>$description



        );
//        $qry = $this->db->insert('customers', $info);
        $this->db->where('id', $id);
        $qry = $this->db->update('erp_ac_ledgers', $info);

        return $qry;

    }


    ////////////////////////////////////////////////


    function float_ops($param1 = 0, $param2 = 0, $op = '')
    {
        $result = 0;
        $param1 = $param1 * 100;
        $param2 = $param2 * 100;
        $param1 = (int)$param1;
        $param2 = (int)$param2;
        switch ($op)
        {
            case '+':
                $result = $param1 + $param2;
                break;
            case '-':
                $result = $param1-$param2;
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
        $result = $result/100;
        return $result;
    }





}