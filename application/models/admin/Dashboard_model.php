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
        $qry="SELECT total_value FROM `gp_wallet_values` WHERE `user_id` = '1' and wallet_type_id='4'";

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
    function get_dashboard_data()
    {
        $qry="SELECT total_value FROM `gp_wallet_values` WHERE `user_id` = '1' and wallet_type_id='4'";

        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            $data['nc_count'] = empty($sql_nc)? 0 :$sql_nc->nc_count ;
            return $result->row_array();
        }
        else
        {
            return array();
        }

    }
    public function getDashboardData()
    {
        //channel partner
        $sql_cp = $this->db->query("SELECT count(id) as cp_count FROM gp_pl_channel_partner cp WHERE cp.is_del = 0 and cp.status = 'JOINED'");
        $sql_cp = $sql_cp->row();
        $data['cp_count'] = empty($sql_cp)? 0 :$sql_cp->cp_count ;

        //normal customer
        $sql_nc = $this->db->query("SELECT count(nc.id) as nc_count FROM gp_normal_customer nc WHERE nc.is_del = 0 and nc.status = 'approved' and nc.type = 'normal_customer'");
        $sql_nc = $sql_nc->row();
        $data['nc_count'] = empty($sql_nc)? 0 :$sql_nc->nc_count ;

        //club member
        $sql_cm = $this->db->query("SELECT count(nc.id) as nc_count FROM gp_normal_customer nc WHERE nc.is_del = 0 and nc.status = 'approved' and nc.type = 'club_member'");
        $sql_cm = $sql_cm->row();
        $data['cm_count'] = empty($sql_cm)? 0 :$sql_cm->nc_count ;

        //club agent
        $sql_ca = $this->db->query("SELECT count(nc.id) as nc_count FROM gp_normal_customer nc WHERE nc.is_del = 0 and nc.status = 'approved' and nc.type = 'club_agent'");
        $sql_ca = $sql_ca->row();
        $data['ca_count'] = empty($sql_ca)? 0 :$sql_ca->nc_count ;

        //jaazzo store
        $sql_jz = $this->db->query("SELECT count(nc.id) as nc_count FROM pl_ba_registration nc WHERE nc.is_del = 0 and nc.status = 'ACTIVE'");
        $sql_jz = $sql_jz->row();
        $data['jz_count'] = empty($sql_jz)? 0 :$sql_jz->nc_count ;

        //executive
        $sql_exc = $this->db->query("SELECT count(nc.id) as nc_count FROM gp_pl_sales_team_members nc WHERE nc.is_del = 0 and nc.status = 'ACTIVE' ");
        $sql_exc = $sql_exc->row();
        $data['exc_count'] = empty($sql_exc)? 0 :$sql_exc->nc_count ;

        return $data;

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



    function get_graph_datas($lgid)
    {
       
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
				where v.user_id = $lgid or a.user_id = $lgid and DATE_FORMAT(a.date_modified, '%Y') = YEAR(CURDATE())

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