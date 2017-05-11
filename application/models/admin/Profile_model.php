<?php
/**
* 
*/
class Profile_model extends CI_Model
{
    
    function __construct()
    {
        $this->load->database();
    }




 

     function get_all_partnertype($id)
     {
        $qry="select * from gp_pl_channel_partner where id='$id'";
        $qry=$this->db->query($qry);
       // echo $this->db->last_query();
        if($qry->num_rows()>0){
            $data=$qry->row_array();

           // echo json_encode($data);
        }
        else{
            $data=array();
        }
        return $data;


    }
    function update_channel_byid($id,$img){
        $this->db->trans_begin();
       
        $data=array(
            'name'=>$this->input->post('name'),
            'phone'=>$this->input->post('phone'),
            'phone2'=>$this->input->post('phone2'),
             'email'=>$this->input->post('email'),
              'address'=>$this->input->post('address'),
              'image'=>$img
        );

        $this->db->where('id',$id);
        $this->db->update('gp_pl_channel_partner',$data);

                  $date = date("Y-m-d h:i:sa") ;
                  $action = "update channel_partner ";
                  $loginsession = $this->session->userdata('logged_in_admin');

                  $userid=$loginsession['user_id'];
                  $status = 0;

               activity_log($action,$userid,$status,$date);
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }



     function get_super_admin($id)
     {
        $qry="select * from gp_login_table where id='$id'";
        $qry=$this->db->query($qry);
        if($qry->num_rows()>0){
            $data=$qry->row_array();
        }
        else{
            $data=array();
        }
        return $data;
}

function update_admin_byid($id){
        $this->db->trans_begin();
       
        $data=array(
           
            'mobile'=>$this->input->post('phone'),
             'email'=>$this->input->post('email')
        );
        $this->db->where('id',$id);
        $this->db->update('gp_login_table',$data);
        $date = date("Y-m-d h:i:sa") ;
                  $action = "update admin ";
                  $loginsession = $this->session->userdata('logged_in_admin');

                  $userid=$loginsession['user_id'];
                  $status = 0;

               activity_log($action,$userid,$status,$date);
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }




function get_exicutives($id)
    {

        $qry = "SELECT 
m.id,
m.name,

d.phone,
d.phone2,
d.email,
d.address,
d.status,
d.image
FROM gp_pl_sales_team_members m 
LEFT JOIN gp_pl_sales_team_member_details d on m.id = d.sales_team_member_id
WHERE m.id = '$id'";

        $qry = $this->db->query($qry);
     // echo $this->db->last_query();
        if($qry->num_rows()>0)
        {
            return $qry->row_array();
        } else{
            return array();
        }       
    }




 function update_executive_byid($id,$image){
  //  var_dump($image);
        $this->db->trans_begin();
       
        $data=array(
            'name'=>$this->input->post('name'),
            'phone'=>$this->input->post('phone'),
            'phone2'=>$this->input->post('phone2'),
            'email'=>$this->input->post('email'),
            'address'=>$this->input->post('address'),
             'image'=>$image
        );
        $this->db->where('sales_team_member_id',$id);
        $this->db->update('gp_pl_sales_team_member_details',$data);
$datass=array(
            'name'=>$this->input->post('name'),
           
            );
         $this->db->where('id',$id);
        $this->db->update('gp_pl_sales_team_members',$datass);
               $date = date("Y-m-d h:i:sa") ;
                  $action = "update executive profile ";
                  $loginsession = $this->session->userdata('logged_in_admin');

                  $userid=$loginsession['user_id'];
                  $status = 0;

               activity_log($action,$userid,$status,$date);

      // echo $this->db->last_query();
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }









}



 
    

?>