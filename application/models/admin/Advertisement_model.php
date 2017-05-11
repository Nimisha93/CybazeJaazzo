<?php

Class Advertisement_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
   


public  function ads_add($data){
        if($this->input->post('add')) {

            $this->db->insert('advertisement',$data);


                $date = date("Y-m-d h:i:sa") ;


                $action = "added Advertisement ";
                $loginsession = $this->session->userdata('logged_in_admin');

                $userid=$loginsession['user_id'];
                $status = 0;

               activity_log($action,$userid,$status,$date);
            ?>
        <script language="javascript" type="text/javascript">
            alert('ads has been added successfully.');
            window.location = "<?php echo site_url().'/admin/Advertisement/' ?>";
        </script>
        <?php

        }
    }

   function get_ads(){
        $this->db->select("*");
        $this->db->from('advertisement');
         $this->db->where('is_del', 0);
        $query=$this->db->get();
       // echo $this->db->last_query();
        return $query->result();
        
    }
    function get_ads_by_id($id)
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
        }
        else{
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
 function delete_advertisementbyid($id){


        $this->db->trans_begin();
        $data = array('is_del' => 1);
        $this->db->where('id', $id);
        $qry = $this->db->update('advertisement', $data);

               $date = date("Y-m-d h:i:sa") ;

               $action = "delete Advertisement ";
               $loginsession = $this->session->userdata('logged_in_admin');

               $userid=$loginsession['user_id'];
               $status = 0;

               activity_log($action,$userid,$status,$date);

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
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


}















