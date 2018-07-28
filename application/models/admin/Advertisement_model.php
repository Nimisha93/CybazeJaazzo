<?php

Class Advertisement_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    public  function ads_add($data)
    {
      $this->db->trans_begin();
      $this->db->insert('advertisement',$data);
      $date = date("Y-m-d h:i:sa") ;
      $action = "added Advertisement ";
      $loginsession = $this->session->userdata('logged_in_admin');
      $userid=$loginsession['user_id'];
      $status = 0;
      activity_log($action,$userid,$status,$date);
      if ($this->db->trans_status() === TRUE) {
        $this->db->trans_commit();
        return true;
      } else {
        $this->db->trans_rollback();
        return false;
      }
    }
    public  function ads_add_default($p){
      $this->db->trans_begin();
        $title=$this->input->post('title');
        $discription=$this->input->post('dis');
        if(!empty($p))
        {
          $data=array('title'=>$title,'image'=>$p,'type' => 'default');
        }
        else{
          $data=array('title'=>$title,'type' => 'default');
        }
        //'discription'=>$discription,
        $sql = "select id from advertisement where type = 'default' and is_del!='1'";
        $sql = $this->db->query($sql);
        if($sql->num_rows()>0)
        {
       $array = array('is_del'=>'0', 'type' => 'default');

          $this->db->where($array);
          $this->db->update('advertisement',$data);
        }else {
          
          $this->db->insert('advertisement',$data);
        }


        $date = date("Y-m-d h:i:sa") ;
        $action = "added Advertisement ";
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $status = 0;
        activity_log($action,$userid,$status,$date);     
      if($this->db->trans_status=false){
        $this->db->trans_rollback();
        return false;
      }else{
        $this->db->trans_commit();
        return true;
      } 
    }
    function get_ads(){
       $array = array('is_del'=>'0', 'type !=' => 'default');
        $this->db->select("*");
        $this->db->from('advertisement');
         $this->db->where($array);
        $query=$this->db->get();
       // echo $this->db->last_query();
        return $query->result();    
    }

    function get_default_ads()
    {
     
         $qry = "select * from advertisement where type = 'default'";
      $qry = $this->db->query($qry);
      if($qry->num_rows()>0)
      {
        return $qry->row_array();
      } else{
        return array();
      } 
    }
    function edit_ads_byid($id)
    {     
      $qry = "select * from advertisement where id = '$id'";
      $qry = $this->db->query($qry);
      if($qry->num_rows()>0)
      {
        return $qry->row_array();
      } else{
        return array();
      } 
    }
    function edit_product_byid($image_file,$id){
      $this->db->trans_begin();
      $data=array(
            'title'=>$this->input->post('title'),
            'type'=>$this->input->post('type'),
            'sort_order'=>$this->input->post('sort'),
            'image'=>$image_file,
            'discription'=>$this->input->post('dis')
            );
      $this->db->where('id',$id);
      $this->db->update('advertisement',$data);
      $date = date("Y-m-d h:i:sa") ;
      $action = "Updated Advertisement ";
      $loginsession = $this->session->userdata('logged_in_admin');
      $userid=$loginsession['user_id'];
      $status = 0;
      activity_log($action,$userid,$status,$date);
      if($this->db->trans_status=false){
        $this->db->trans_rollback();
        return false;
      }else{
        $this->db->trans_commit();
        return true;
      }
    }
    function update_ads_byid($data, $id)
    {
      $this->db->where('id',$id);
      $qry =  $this->db->update('advertisement',$data);
      $date = date("Y-m-d h:i:sa") ;
      $action = "Updated Advertisement ";
      $loginsession = $this->session->userdata('logged_in_admin');
      $userid=$loginsession['user_id'];
      $status = 0;
      activity_log($action,$userid,$status,$date);
      return $qry;
    }
    function delete_advertisementbyid($datas){
      $this->db->trans_begin();
      $ids = $datas['chck_item_id'];
      foreach ($ids as $key => $id) {
        $info = array('is_del' => 1);
        $this->db->where('id', $id);
        $qry = $this->db->update('advertisement', $info);
        $date = date("Y-m-d h:i:sa") ;

        $action = "delete Advertisement ";
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $status = 0;
        activity_log($action,$userid,$status,$date);
      }
      if ($this->db->trans_status() === TRUE) {
          $this->db->trans_commit();
          return true;
      } else {
          $this->db->trans_rollback();
          return false;
      }
    }






    
    function get_activity()
    {
        $qry = "select * from 
                gp_activity_log
                left join gp_login_table  on gp_activity_log.id = gp_login_table.id
                where gp_activity_log.id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        } else{
            return array();
        }       
    }
    function get_activities_count($search)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (nc.name LIKE '%$keyword%' OR act.action LIKE '%$keyword%' OR act.status_ LIKE '%$keyword%' OR act.date LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $query="select act.*,nc.name FROM gp_activity_log act
                LEFT JOIN gp_login_table  log on act.id = log.id
                LEFT JOIN gp_normal_customer  nc on log.user_id = nc.id".$where." ORDER BY act.id DESC";
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
          return $result->num_rows();
        } else{
          return false;
        }
    }
    function get_activities($search,$limit=NULL,$start=NULL)
    {        
      if(!empty($search)){
          $keyword = "%{$search}%";
          $where = " WHERE (nc.name LIKE '%$keyword%' OR act.action LIKE '%$keyword%' OR act.status_ LIKE '%$keyword%' OR act.date LIKE '%$keyword%')";
      }else{
          $where = '';
      }
      if(!is_null($start)&&!is_null($limit)){
          $pg = " LIMIT $start, $limit";
      }else{
          $pg = "";
      }
      $query="select act.*,nc.name, DATE_FORMAT(act.date, '%d-%m-%Y') AS datee,DATE_FORMAT(act.date,'%H:%i:%s') AS time FROM gp_activity_log act
                LEFT JOIN gp_login_table  log on act.id = log.id
                LEFT JOIN gp_normal_customer  nc on log.user_id = nc.id".$where." ORDER BY act.id DESC".$pg;
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
}















