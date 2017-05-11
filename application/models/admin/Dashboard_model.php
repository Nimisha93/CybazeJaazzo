<?php
Class Dashboard_model extends  CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    function get_mywallet_value()
    {
        $qry="SELECT total_value FROM `gp_wallet_values` WHERE `user_id` = '13'";

        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            return $result->row_array();
        }
        else
        {
            return array();
        }

    }

    function get_cpwallet_value(){
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['id'];
        $qry="select    wval.id,
                wval.wallet_type_id,
                typ.title,
                wval.user_id,
                wval.total_value from gp_wallet_values wval
                left join gp_wallet_types typ on typ.id=wval.wallet_type_id
                where wval.user_id='$loginuser'
                order by typ.title asc
                ";
        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['wallet']=$query->result_array();
        }
        else{
            $data['wallet']=array();
        }
        return $data;

    }

     function get_logined_wallet(){
         $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['id'];
    }



    function get_graph_datas()
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $logid = $session_array['id'];
        $qry = "select
				a.wallet_type_id,
				t.title title_a,
				v.wallet_type_id,
				tt.title title_b,
				a.wallet_val_id,
				TRUNCATE(a.change_value,2) as sums,
				a.description,
				a.user_id,
				DATE_FORMAT(a.date_modified, '%b') as month
				from
				gp_wallet_activity a
				left join gp_wallet_types t on t.id = a.wallet_type_id
				left join gp_wallet_values v on v.id = a.wallet_val_id
				left join gp_wallet_types tt on tt.id = v.wallet_type_id
				where v.user_id = $logid or a.user_id = $logid and DATE_FORMAT(a.date_modified, '%Y') = YEAR(CURDATE())

			group by DATE_FORMAT(a.date_modified, '%b')	order by a.date_modified desc ";
        $qry = $this->db->query($qry);

        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }	else{
            return array();
        }
    }
}