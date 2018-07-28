<?php
Class Transaction_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();
    }
    function get_cptransaction_details($login_id){
        
        $qry_to_admin = $this->db->query("SELECT round(sum(cp.transaction_amount),2) as amount FROM `gp_cp_transaction` cp WHERE cp.from = '$login_id' and cp._to = '1' ");
        $qry_to_admin = $qry_to_admin->row();
        $to_admin = $qry_to_admin->amount;
        //var_dump($to_admin);
        $qry_to_cp = $this->db->query("SELECT round(sum(cp.transaction_amount),2) as amount FROM `gp_cp_transaction` cp WHERE cp.from = '1' and cp._to = '$login_id' ");
        $qry_to_cp = $qry_to_cp->row();
        $to_cp = $qry_to_cp->amount;
        //var_dump($to_cp);
        $qry_amt = $this->db->query("SELECT round(sum(pb.wallet_total), 2) as wallet_total ,round(sum(pb.total_commission),2) as total_commission FROM `gp_purchase_bill_notification` pb LEFT JOIN gp_login_table l on pb.channel_partner_id = l.user_id WHERE pb.status='1' and l.id = '$login_id'");
        $qry_amt = $qry_amt->row();
        $wallet_total = $qry_amt->wallet_total;
        $total_commission = $qry_amt->total_commission;
        //var_dump($wallet_total);var_dump($total_commission);exit;
        $pending = round(($total_commission - $wallet_total + $to_cp - $to_admin),2);
       // var_dump($pending);exit();
        return $pending;
    }
    
    function new_transaction_byid($userid,$lgid){
        $cur_date=date('Y-m-d H:i:s');
        $mode= $this->input->post('payment_mode');
        $status = ($mode=='online') ? '1' : '0';
        
        $payed_amt=$this->input->post('pay_amount');
        $total_amount=$this->input->post('pending_amount');
        $pending_amt=$total_amount-$payed_amt;
        $transaction_date = date('Y-m-d H:i',strtotime($this->input->post('transaction_date')));
        $cheque_date = date('Y-m-d H:i',strtotime($this->input->post('cheque_date')));
        
        $walletid = $this->db->select('id')->where('user_id',$lgid)->get('gp_wallet_values')->row('id');
        if($walletid)
            {
                    $this->db->trans_begin();
                    $data=array(
                        'total_value'=>$pending_amt
                    );
                    $this->db->where('id',$walletid);
                    $this->db->update('gp_wallet_values',$data);
           
                    $transdata=array(
                        'from'=>$lgid,
                        '_to'=>'1',
                        'total_amount'=>$total_amount,
                        'transaction_amount'=>$payed_amt,
                        'transaction_date'=>$transaction_date,
                        'narration'=>$this->input->post('narration'),
                        'cheque_number'=>$this->input->post('cheque_number'),
                        'bank_name'=>$this->input->post('bank'),
                        'cheque_date'=>$cheque_date,
                        'status'=>$status,
                        'mode'=>$mode,
                        'type' => "channel_partner",
                        'created_on'=>$cur_date
                    );
                    $this->db->insert('gp_cp_transaction',$transdata);
                    $insert_id = $this->db->insert_id();
                    //entry creation
                    $fy_year = get_current_financial_year();
                    $fy_id = $fy_year['id'];
                    $no =get_number();
                    $ac_data = array(
                        'entrytype_id'=>4,
                        '_type'=>'TRANSACTION',
                        'type_id'=>$insert_id,
                        'number'=>$no,
                        'fy_id' =>$fy_id,
                        'date'=>date('Y-m-d'),
                        'dr_total'=>$payed_amt,
                        'cr_total'=>$payed_amt
                    );
                    $this->db->insert('erp_ac_entries',$ac_data);
                  
                    $entry_id = $this->db->insert_id();
                    $type = 'CHANNEL_PARTNER';
                    $ledger_payment_cr = getLedgerId($lgid,$type);
                    if($mode=='cash')
                        $ledger_payment_dr = 32;
                    else
                        $ledger_payment_dr = 35;
                    $entry_items_cr = array(
                        'entry_id' => $entry_id,
                        'ledger_id' => $ledger_payment_cr,
                        'amount' => $payed_amt,
                        'dc' => 'Cr',
                        'fy_id' =>$fy_id,
                        'created_date' => date('Y-m-d')
                    );
                     
                    $entry_items_dr = array(
                        'entry_id' => $entry_id,
                        'ledger_id' => $ledger_payment_dr,
                        'amount' => $payed_amt,
                        'dc' => 'Dr',
                        'fy_id' =>$fy_id,
                        'created_date' => date('Y-m-d')
                    );

                    $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);
                    $entry_dr = $this->db->insert('erp_ac_entryitems', $entry_items_dr);
                    $date = date("Y-m-d h:i:sa") ;
                    $action = "added new transaction ";
                    $status = 0;
                    activity_log($action,$userid,$status,$date);
                    $this->db->trans_complete();
                    if($this->db->trans_status()===false){
                        $this->db->trans_rollback();
                        return false;
                    }
                    else{
                        $this->db->trans_commit();
                        return true;
                    }
                }
                else{
                     return false;
                }   
    }
    
    function cp_last_transaction_details($from,$to){
        $qry=$this->db->query("SELECT * from gp_cp_transaction t where t.from = '$from' and t._to = '$to'");
        if($qry->num_rows()>0){
            $data=$qry->result_array();
        }
        else{
            $data=array();
        }

        return $data;
    }

    function get_transaction_details_cp(){
        $qry="SELECT cp.name, t.transaction_amount,t.id, w.total_value, w.id as wallet_id FROM `gp_cp_transaction` t LEFT JOIN `gp_pl_channel_partner` cp on t.cp_id = cp.id LEFT JOIN gp_login_table l on l.user_id = cp.id LEFT JOIN gp_wallet_values w on w.user_id = l.id WHERE t.status = 0 and t.is_del = 0 and w.wallet_type_id = '4'";
        $qry=$this->db->query($qry);
        if($qry->num_rows()>0){
            $data=$qry->result_array();
        }
        else{
            $data=array();
        }

        return $data;
    }

    function approve_transaction_request(){

        $this->db->trans_begin();
        $id=$this->input->post('id');
        $amount=$this->input->post('amount');
        $walletid=$this->input->post('wid');
        $total_amount=$this->input->post('total_value');
     
        $pending_amt=$total_amount-$amount;

        $data=array(
            'total_value'=>$pending_amt
        );
        $this->db->where('id',$walletid);
        $this->db->update('gp_wallet_values',$data);
        $cur_date=date('Y-m-d H:i:s');

        $transdata=array(
           
            'total_amount'=>$total_amount,
            
            'transaction_date'=>$this->input->post('transaction_date'),
           
            'status'=>"1",
            'created_on'=>$cur_date
        );
        $this->db->where('id',$id);
        $this->db->update('gp_cp_transaction',$transdata);


           $date = date("Y-m-d h:i:sa") ;
           $action = "added new transaction ";
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
    
     function transaction_request($userid){

        $this->db->trans_begin();
        $payed_amt=$this->input->post('amount');
        
        $cur_date=date('Y-m-d H:i:s');

        $transdata=array(
            'cp_id'=>$userid,
           
            'transaction_amount'=>$payed_amt,
          
            'narration'=>$this->input->post('narration'),
            'status'=>"0",
            'created_on'=>$cur_date
        );

        $this->db->insert('gp_cp_transaction',$transdata);


           $date = date("Y-m-d h:i:sa") ;
           $action = "requested new transaction ";
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
   
    


    /* end */
}
?>