<?php
Class Transaction_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();
    }


    function get_transaction_details(){
       $qry="select cp.name,wv.total_value,cp.id,wv.id waletid,cp.id cpid from gp_pl_channel_partner cp
	        left join gp_login_table loguser on loguser.user_id=cp.id
	        left join gp_wallet_values wv on  loguser.id=wv.user_id and wv.wallet_type_id='2'
	        order by cp.id desc";
        $qry=$this->db->query($qry);
        if($qry->num_rows()>0){
            $data['details']=$qry->result_array();
        }
        else{
            $data['details']=array();
        }

        return $data;
    }

    function new_transaction_byid(){

        $this->db->trans_begin();
        $payed_amt=$this->input->post('pay_amt');
        $cpid=$this->input->post('cp_hiddenid');
        $walletid=$this->input->post('wallet_hiddenid');
        $total_amount=$this->input->post('total_amtvalue');
        $pending_amt=$total_amount-$payed_amt;
        $data=array(
            'total_value'=>$pending_amt
        );
        $this->db->where('id',$walletid);
        $this->db->update('gp_wallet_values',$data);
        $cur_date=date('Y-m-d H:i:s');

        $transdata=array(
            'cp_id'=>$cpid,
            'total_amount'=>$total_amount,
            'transaction_amount'=>$pending_amt,
            'transaction_date'=>$this->input->post('transaction_date'),
            'narration'=>$this->input->post('narration'),
            'status'=>"0",
            'created_on'=>$cur_date
        );

        $this->db->insert('gp_cp_transaction',$transdata);


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

    /* module2 */

    function cuspur_cp_details($id){
        $qry="select cus.name customer,pnot.wallet_total walletamt,(pnot.bill_total - pnot.wallet_total) as cusamount,cp.name cp,pnot.purchased_on purdate from gp_purchase_bill_notification pnot
                left join gp_pl_channel_partner_type_connection cpcon on cpcon.id=pnot.channel_partner_conn_id
                left join gp_normal_customer cus on cus.id=pnot.login_id
                left join gp_pl_channel_partner cp on cp.id=cpcon.channel_partner_id
                where cpcon.channel_partner_id='$id'";
        $qry=$this->db->query($qry);
        if($qry->num_rows()>0){
            $data['details']=$qry->result_array();
        }
        else{
            $data['details']=array();
        }

        return $data;
    }

    function get_cptransaction_details(){
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['user_id'];
        $qry="select cp.name,wv.total_value,cp.id,wv.id waletid,cp.id cpid,tr.transaction_date,(tr.total_amount - tr.transaction_amount) pendamt
            from gp_pl_channel_partner cp
	        left join gp_login_table loguser on loguser.user_id=cp.id
	        left join gp_cp_transaction tr on tr.cp_id=cp.id
	        left join gp_wallet_values wv on  loguser.id=wv.user_id and wv.wallet_type_id='2'
	        where cp.id='$loginuser' order by cp.id desc";
        $qry=$this->db->query($qry);
        if($qry->num_rows()>0){
            $data['details']=$qry->row_array();
        }
        else{
            $data['details']=array();
        }

        return $data;
    }


    /* end */
}