<?php
/**
* 
*/
class Product_model extends CI_Model
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->database();
	}
// get all product
    function get_Product()
     {
        $qry= "select * FROM gp_product_details where  type!='deal'";
		$query=$this->db->query($qry);
		if($query->num_rows()>0)
		{
			return $query->result_array();
		} else{
			return array();
		}	



    }

    function  get_product_details_by_id($id)
    {
          $qry="SELECT
         dt.id as pr_id,
         cat.title,
         dt.name,
         dt.description,
         dt.full_specification,
         dt.quantity,
         dt.model,
          dt.actual_cost,
          dt.cost,
          img.p_image,
          dt.image
         FROM
         gp_product_details dt
        left join gp_product_image img on img.product_id = dt.id
          left JOIN gp_product_category cat on cat.id = dt.category_id
       where dt.is_del = 0 and dt.id ='$id'
        group by img.id";
        $result=$this->db->query($qry);
     //   echo $this->db->last_query();
       // var_dump($result); exit;
        if($result->num_rows()>0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
    }

//    function  get_product_image($id)
//    {
//        $qry="select * FROM gp_product_image where id='$id'";
//        $result=$this->db->query($qry);
//        if($result->num_rows()>0)
//        {
//            return $result->row_array();
//        }
//        else
//        {
//            return array();
//        }
//    }

    function get_deal_product()
    {

        $qry= "select * FROM gp_product_details where  type='deal'";
        $query=$this->db->query($qry);
        if($query->num_rows()>0)
        {
            return $query->result_array();
        }
        else
        {
            return array();
        }



    }
function get_submenu()
{
 $qry= "select * FROM gp_permission_module where  header_module='1'";
        $query=$this->db->query($qry);
        if($query->num_rows()>0)
        {
            return $query->result_array();
        }
        else
        {
            return array();
        }

    
}
function get_premiyam()

{
    $qry= "select * FROM gp_permission_module where  module_content_div='1'";
    $query=$this->db->query($qry);
    if($query->num_rows()>0)
    {
        return $query->result_array();
    }
    else
    {
        return array();
    }


}

function get_product_view()
{


    $qry="SELECT * FROM gp_permission_module ";
    $query=$this->db->query($qry);
    if($query->num_rows()>0)
    {
        $data['module']=$query->result_array();

        foreach($data['module'] as $key=> $modules )
        {
            $moduleid= $modules['id'];
            $qry1="select * FROM  gp_pl_channel_partner_type_connection  where module_id='$moduleid'";

            $query1=$this->db->query($qry1);
            if($query1->num_rows()>0)
            {
                $result= $query1->result_array();
                $ch_id=$result[$key]['id'];

                $qry3="select* from gp_product_details where cp_connection_id='$ch_id'";

                $results=$this->db->query($qry3);
                if($results->num_rows()>0){

                    $data['module'][$key]['product']=$results->result_array();

                }
                else{
                    $data['module'][$key]['product']=array();
                }
            }
           else{
               $data['module'][$key]['product']=array();
            }
        }
    }

    else{
        $data['module']= array();
    }
    return $data;
}
function get_wallet()

    {
        $qry= "select a.id as reward_id,
       b.id as mywallt_id,
       a.title as reward_name,
       b.title as mywallet_name
       from gp_wallet_types a
       join gp_wallet_types b
       where a.id = 2
       and b.id = 4";
        $query=$this->db->query($qry);
     //   echo $this->db->last_query();exit();
        if($query->num_rows()>0)
        {
            return $query->row_array();
        }
        else
        {
            return array();
        }



    }

    function get_wallet_amout($id,$login_id)
    {

        $qry= "select walv.total_value FROM gp_login_table logg
    LEFT JOIN gp_wallet_values walv on walv.user_id=logg.id and walv.wallet_type_id='$id'
    where logg.id='$login_id'";

       // echo $this->db->last_query();

        $query=$this->db->query($qry);
        if($query->num_rows()>0)
        {
            return $query->row_array();
        }
        else
        {
            return array();
        }


    }






}
