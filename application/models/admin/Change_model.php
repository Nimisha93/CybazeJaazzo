<?php
/**
* 
*/
class Change_model extends CI_Model
{
	
	function __construct()
	{
		$this->load->database();
	}


	 function get_current_pass($id)
    {
        $qry = $this->db->query("SELECT password from gp_login_table where id = '$id'");
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
    }
    function update_pass($pass, $id)
    {
        $qry = $this->db->query("update gp_login_table set password = '$pass' where id ='$id'");
        return $qry;
    }


}



 
    

?>