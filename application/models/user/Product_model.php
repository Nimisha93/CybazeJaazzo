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
        $qry= "select p.id as pr_id,
         par.id ,
         par.name as cp_name,
         par.brand_image,

         p.cp_connection_id,
         p.name,
         p.description,
         p.full_specification,
         p.quantity,
         p.model,
          p.actual_cost,
          p.cost,

          p.image
           from gp_pl_channel_partner_type_connection con
                    left join gp_pl_channel_partner par on par.id = con.channel_partner_id
                     left join gp_product_details p on p.cp_connection_id = con.id
       where  type!='deal'";








// select p.id as pr_id,
//          con.id ,


//          p.cp_connection_id,
//          p.name as productname ,
//          p.description productdes,
//          p.full_specification productspec,
//          p.quantity,
//          p.model,
//           p.actual_cost,
//           p.cost,

//           p.image

//            FROM gp_product_details p left join gp_pl_channel_partner_type_connection con on p.cp_connection_id=con.id
//            LEFT JOIN gp_pl_channel_partner conp on conp.id=con.channel_partner_id WHERE p.type!='deal'












        $query=$this->db->query($qry);


        if($query->num_rows()>0)
        {
            return $query->result_array();
        } else{
            return array();
        }
    }


    function get_cpcategory(){
        $qry="SELECT * FROM `gp_pl_channel_partner_types` WHERE parent=0";
        $qry=$this->db->query($qry);
        if($qry){
            $data['type']=$qry->result_array();
        }
        else{
            $data['type']=array();
        }
        return $data;

    }

    function get_cpscategory(){
        $qry="SELECT * FROM `gp_pl_channel_partner_types` WHERE parent!=0";
        $qry=$this->db->query($qry);
        if($qry){
            $data['type']=$qry->result_array();
        }
        else{
            $data['type']=array();
        }
        return $data;

    }

    function  get_product_details_by_id($id)
    {
        $qry= "select p.id as pr_id,pr_img.p_image as product_image,
     par.id as ch_id , par.name as cp_name, par.brand_image,
      p.cp_connection_id, p.name , p.description,
      p.full_specification, p.quantity, p.model, p.actual_cost,
       p.cost, p.image
    from gp_pl_channel_partner_type_connection con
    left join gp_pl_channel_partner par on par.id = con.channel_partner_id
    left join gp_product_details p on p.cp_connection_id = con.id
    LEFT JOIN gp_product_image pr_img on pr_img.id=p.id where p.id='$id'";



        $result=$this->db->query($qry);
//        echo $this->db->last_query();
//

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

        $qry= "select p.id as pr_id,
         par.id ,
         par.name as cp_name,
         par.brand_image,

         p.cp_connection_id,
         p.name,
         p.description,
         p.full_specification,
         p.quantity,
         p.model,
          p.actual_cost,
          p.cost,

          p.image
           from gp_pl_channel_partner_type_connection con
                    left join gp_pl_channel_partner par on par.id = con.channel_partner_id
                     left join gp_product_details p on p.cp_connection_id = con.id  where  type='deal'";
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

// function get_product_view()
// {
//     $qry="SELECT * FROM gp_permission_module ";
//     $query=$this->db->query($qry);
//     if($query->num_rows()>0)
//     {
//         $data['module']=$query->result_array();

//     foreach($data['module'] as $key=> $modules )
//     {
//      $moduleid= $modules['id'];
//      $qry1="select * FROM  gp_pl_channel_partner_type_connection  where module_id='$moduleid'";

//      $query1=$this->db->query($qry1);
//     if($query1->num_rows()>0)
//     {
//         $result= $query1->result_array();
//         $ch_id=$result['id'];

//         $qry3="select* from gp_product_details where cp_connection_id='$ch_id'";

//         $results=$this->db->query($qry3);
//         if($results->num_rows()>0){

//         $data['module'][$key]['product']=$results->result_array();

//         }
//         else{
//              $data['module'][$key]['product']=array();
//         }
//         }
//    else{
//        $data['module'][$key]['product']=array();
//      }
//         }
//         }

// else{
//     $data['module']= array();
// }
//     return $data;
// }
function get_product_view()
{
  $data = array();
    $qry = "SELECT * FROM gp_permission_module ";
    $qry=$this->db->query($qry);
    if($qry->num_rows()>0)
    {
      $data['module']=$qry->result_array();
      foreach ($data['module'] as $key => $module) {
        $module_id = $module['id'];
        $newqry = "select con.id con_id,
                    p.id p_id,
                    p.image,
                    p.name,
                    p.cost,
                    par.image as par_img,
                    par.name partner_name,
                    p.actual_cost,
                    p.quantity
                    from gp_pl_channel_partner_type_connection con 
                    left join gp_pl_channel_partner par on par.id = con.channel_partner_id 
                    left join gp_product_details p on p.cp_connection_id = con.id 
                    where con.module_id = $module_id";
            $newqry=$this->db->query($newqry);
            if($newqry->num_rows()>0)
            {
              $data['module'][$key]['product'] = $newqry->result_array();
            }else{
              $data['module'][$key]['product'] = array();
            }            
      }
    } else{
      $data['module']=array();
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
    function get_all_category()
    {
      $qry = "select
              ca.id,
              ca.title,
              ca.description,
              ca.`status` 
              from
              gp_product_category ca 
              where ca.parent_id = 0
              and ca.is_del = 0";
      $qry=$this->db->query($qry);
      if($qry->num_rows()>0)
        {
            $data['category'] = $qry->result_array();
          foreach ($data['category'] as $key => $cate) {
            $cat_id = $cate['id'];
            $sub_qry = "select
                          cat.id,
                          cat.title,
                          cat.description,
                          cat.`status`

                          from
                          gp_product_category cat
                          where cat.parent_id = '$cat_id'";
                           $sub_qry=$this->db->query($sub_qry);
                         //  echo $this->db->last_query();exit;
            if($sub_qry->num_rows()>0)
            {
              $data['category'][$key]['subcat'] = $sub_qry->result_array();
            }else{
              $data['category'][$key]['subcat'] = array();
            }

          }

        }
        else
        {
            $data['category'] = array();
        }
    
        return $data;
    }
    function getAllProduct($where, $limit, $start)
    {
     // var_dump($where);
        $data = array();
      //  $where =  $where=="0"? "" : "and dt.brand_id = '$where'";
        $qry= "select
              dt.id,
              dt.brand_id,
              dt.category_id,
              dt.cp_connection_id,
              IFNULL(dt.name, '') as name,
              dt.description,
              dt.full_specification,
              dt.quantity,
              dt.image,
              dt.model,
              dt.actual_cost,
              dt.cost,
              IFNULL(p.name, '') as partner,
              p.image as partner_img
              from
              gp_product_details dt
              left join gp_pl_channel_partner_type_connection con on con.id = dt.cp_connection_id
              left join gp_pl_channel_partner p on p.id = con.channel_partner_id

              where dt.is_del = 0 and dt.`type` != 'deal' $where
              order by dt.id desc
              limit $start,$limit";

     

        $query=$this->db->query($qry);
        //echo $this->db->last_query();
        if($query->num_rows()>0)
        {
          $data["status"] = TRUE;
          $data['data'] = $query->result_array();
        }
        else
        {
            $data["status"] = FALSE;
          $data['data'] = array();
        }
        return $data;

    }
    function getAllProductCount($where)
    {
    // var_dump($where);
    //  $where =  $where=="0"? "" : "and dt.brand_id = '$where'";

      $qry= "select
              dt.id,
              dt.brand_id,
              dt.category_id,
              dt.cp_connection_id,
              dt.name,
              dt.description,
              dt.full_specification,
              dt.quantity,
              dt.image,
              dt.model,
              dt.actual_cost,
              dt.cost,
              p.name
              from
              gp_product_details dt
              left join gp_pl_channel_partner_type_connection con on con.id = dt.cp_connection_id
              left join gp_pl_channel_partner p on p.id = con.channel_partner_id

              where dt.is_del = 0 and dt.`type` != 'deal'";

        

        $query=$this->db->query($qry);

        if($query->num_rows()>0)
        {
            return $query->num_rows();
        }
        else
        {
            return false;
        }
    }
    function get_all_brands()
    {
      $qry= "select
              b.id,
              b.name,
              b.image,
              b.description
              from
              gp_product_brands b";
        $query=$this->db->query($qry);
     //   echo $this->db->last_query();exit();
        if($query->num_rows()>0)
        {
            return $query->result_array();
        }
        else
        {
            return array();
        }
    }




}