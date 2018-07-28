<?php
Class Ba_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();
    }
    function get_ba($id){
        $qry = "SELECT m.id,
                m.name,
                m.mobil_no,
                m.email,
               
                m.image
                FROM pl_ba_registration m 
                WHERE m.id = '$id'";

        $qry = $this->db->query($qry);


        if($qry->num_rows()>0)
        {
            return $qry->row_array();
        } else{
            return array();
        }       
    }
    

}


