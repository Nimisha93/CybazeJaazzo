<?php


Class Delear_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_all_delears()
    {
        $sql="SELECT * FROM `gp_pl_channel_partner` ";
        $query=$this->db->query($sql);
        if($query->num_rows()>0)
        {
            $result=$query->result_array();

        }
        else
        {
            $result=array();
        }

        return $result;

    }
}



