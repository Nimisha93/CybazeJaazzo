<?php
/**
* 
*/
class Clubagent_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
	/* Club Agent */
    function add_club_agent($data)
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $id = $session_array['user_id'];
        $log_id = $session_array['id'];
        $parent_login_id = isset($data['mem_id'])?$data['mem_id']:$log_id;      
        $this->db->trans_begin();
        $otp = random_string('numeric', 4);
        $datas = array(
            'name' => $data['name'],
            'phone' => $data['mobile'],
            'email' => $data['email'],
            'otp' => $otp,
            'profile_image' =>'',
            'ca_docs'=>isset($data['file'])?$data['file']:'',
            'reg_otp_status' => 0,
            'created_by'=>$log_id,
            'register_via'=>$data['register_via'],
            'mem_id'=>$data['mem_id'],
            'type'=>'club_agent'
            );
        $qry = $this->db->insert('gp_normal_customer', $datas);
        $insert_id = $this->db->insert_id();
        $data2 = array(
            'customer_id' => $insert_id,
            'lastname' => $data['name']
        );
        $qry2 = $this->db->insert('gp_customer_additional_info', $data2);
        $data3 = array(
            'email' => $data['email'],
            'mobile' => $data['mobile'],
            'user_id' =>$insert_id,
            'type' => 'club_agent',
            'otp_status' => 0,
            'parent_login_id'=>$parent_login_id
        );
        $qry3 = $this->db->insert('gp_login_table', $data3);


        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data['status'] = FALSE;
        } else {
            $this->db->trans_commit();
            $data['status'] = TRUE;
            $info = array('user_id' => $insert_id, 'otp' => $otp);
            $data['info'] = $info;
        }
        return $data;
    }
    function get_all_club_agents_count($search)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (nc.phone LIKE '%$keyword%' OR nc.email LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="SELECT nc.* FROM gp_normal_customer nc LEFT JOIN gp_login_table lt ON lt.user_id=nc.id WHERE lt.type='club_agent' AND nc.is_del=0".$where."  ORDER BY nc.id DESC";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->num_rows();

        }else{
            return false;
        }
    }
    //get all club agents
    function get_all_club_agents($search,$limit,$start)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (nc.phone LIKE '%$keyword%' OR nc.email LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="SELECT nc.* FROM gp_normal_customer nc LEFT JOIN gp_login_table lt ON lt.user_id=nc.id WHERE lt.type='club_agent' AND nc.is_del=0".$where."  ORDER BY nc.id DESC LIMIT $start, $limit";
        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
           return $result->result_array();
        }else{
            return array();
        }
    }
    //delete club agents
    function delete_club_agent($datas)
    {
        $this->db->trans_begin();
        $ca_ids = $datas['chck_item_id'];
        foreach ($ca_ids as $key => $ca_id) {
            $results = array();
            $this->db->select('ca_docs')
                    ->from('gp_normal_customer')
                    ->where('id',$ca_id);

            $results['ca_docs'] = $this->db->get()->row()->ca_docs;
            if(!empty($results['ca_docs'])){
                unlink($results['ca_docs']);
            }

            $info = array('is_del' => 1);
            $this->db->where('id', $ca_id);
            $qry = $this->db->update('gp_normal_customer', $info);
            $infos = array('is_del' => 1);
            $this->db->where('user_id', $ca_id);
            $qrs = $this->db->update('gp_login_table', $infos);
        }
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
    //get  club agent details
    function get_clubagent_byid($id)
    {
        $qry="SELECT nc.* FROM gp_normal_customer nc LEFT JOIN gp_login_table lt ON lt.user_id=nc.id WHERE nc.id='$id' AND lt.type='club_agent' AND nc.is_del=0";
        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
           return $result->row_array();
        }else{
            return array();
        }
    }
    //remove club agent docs
    function delete_club_agent_docs($id)
    {
        $this->db->trans_begin();
        $ca_id = $id;
        $this->db->select('ca_docs')
                ->from('gp_normal_customer')
                ->where('id',$ca_id);

        $ca_docs = $this->db->get()->row()->ca_docs;
        isset($ca_docs)?unlink($ca_docs):'';

        $info = array('ca_docs' => '');
        $this->db->where('id', $ca_id);
        $qry = $this->db->update('gp_normal_customer', $info);

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
    function update_club_agent($data,$id)
    {
        $this->db->trans_begin();
        if(isset($data['ca_docs'])){
            $this->db->select('ca_docs')
                    ->from('gp_normal_customer')
                    ->where('id',$id);

            $ca_docs = $this->db->get()->row()->ca_docs;
            if($ca_docs!=''){unlink($ca_docs);}
        }

        $this->db->where('id', $id);
        $qry = $this->db->update('gp_normal_customer', $data);

        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
}
 ?>