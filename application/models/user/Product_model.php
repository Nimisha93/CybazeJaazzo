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


    function get_menus(){


        $sql = "SELECT * FROM `gp_pl_channel_partner_types` WHERE parent=0
                ";
        $sql = $this->db->query($sql);

        if($sql->num_rows()>0){

            $data['main_category']=$sql->result_array();

            foreach($data['main_category'] as $key => $main_category){

                $cat_id = $main_category['id'];

                $qry = "SELECT
                    ct.id as cat_id, ct.parent as cat_parent_id,
                    ct.title as cat_name, ct.description as cat_desc
                    FROM gp_pl_channel_partner_types ct
                    WHERE ct.parent = ? ";

                $qry = $this->db->query($qry, $cat_id);


                if($qry->num_rows()>0){


                    $data['main_category'][$key]['category']=$qry->result_array();

                    foreach($data['main_category'][$key]['category'] as $ky=> $sub_category){

                        $sub_cat_id = $sub_category['cat_id'];

                        $qry_sub = "SELECT
                                    sct.id as sub_cat_id, sct.parent as sub_cat_parent_id,
                                    sct.title as sub_cat_name
                                    FROM gp_pl_channel_partner_types sct
                                    WHERE sct.parent = ? ";

                        $qry_sub = $this->db->query($qry_sub, $sub_cat_id);

                        if($qry->num_rows()>0){

                            $data['main_category'][$key]['category'][$ky]['sub_cat'] = $qry_sub->result_array();

                        }else{
                            $data['main_category'][$key]['category'][$ky]['sub_cat'] = array();
                        }

                    }
                }

                else{

                    $data['main_category'][$key]['category'] = array();
                }


            }


        }

        else{
            $data['main_category'] = array();
        }


        return $data;
    }
// get all product
    function get_Product()
    {
        $qry= "select p.id as pr_id, cp.id , cp.name as cp_name, cp.brand_image, p.name, p.description, p.full_specification, p.quantity, p.model, p.actual_cost, p.special_prize, pi.p_image as image,(select cc.percentage from gp_channel_con_cat_commision cc where cc.id = p.reward_cat_id) as reward_percentage  from gp_product_details p LEFT JOIN gp_pl_channel_partner cp on cp.id = p.channel_partner_id LEFT JOIN gp_product_image pi on pi.product_id = p.id where type = '0' and p.is_del = '0'  GROUP by p.id order by p.id desc";


        $query=$this->db->query($qry);


        if($query->num_rows()>0)
        {
            return $query->result_array();
        } else{
            return array();
        }
    }


    function get_cpcategory(){
        $qry="SELECT * FROM `gp_pl_channel_partner_types` WHERE parent=0 ORDER BY id desc LIMIT 0,10";
        $qry=$this->db->query($qry);
        if($qry){
            $data['type']=$qry->result_array();
        }
        else{
            $data['type']=array();
        }
        return $data;

    }

    function get_cpcategory_module_wise($id){
      //var_dump($id);exit();
        $qry="SELECT cpt.id, cpt.title FROM `gp_pl_channel_partner_type_connection` con inner join gp_pl_channel_partner_types cpt   on  con.channel_partner_type_id = cpt.id WHERE con.module_id = '$id' and  cpt.parent=0";
        $qry=$this->db->query($qry);
       // echo $this->db->last_query();
        if($qry){
            $data['type']=$qry->result_array();

        }
        else{
            $data['type']=array();
        }
       // var_dump($data);exit();
        return $data;

    }
    function get_subcptype(){
        $qry="SELECT * FROM `gp_cp_sub_category`";
        $qry=$this->db->query($qry);
        if($qry){
            $data['stype']=$qry->result_array();
        }
        else{
            $data['stype']=array();
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
     function get_cpscategory_module_wise($id){
      //var_dump($id);exit();
        $qry="SELECT cpt.id, cpt.title,cpt.parent FROM `gp_pl_channel_partner_type_connection` con inner join gp_pl_channel_partner_types cpt   on  con.channel_partner_type_id = cpt.id WHERE con.module_id = '$id' and  cpt.parent!=0";
        $qry=$this->db->query($qry);
       // echo $this->db->last_query();
        if($qry){
            $data['type']=$qry->result_array();

        }
        else{
            $data['type']=array();
        }
       // var_dump($data);exit();
        return $data;

    }
    function  get_product_details_by_id($id,$type)
    {
    
      $qry = "select p.id as pr_id,pr_img.p_image as product_image, par.id as ch_id , par.name as cp_name, par.brand_image, p.cp_connection_id, p.name , p.description, p.full_specification, p.quantity, p.model, p.actual_cost, p.special_prize, pr_img.p_image as image,p.special_prize,par.lattitude,par.longitude,par.address,par.phone,par.email,ct.name as country, s.name as state, c.name as city,(select cc.percentage from gp_channel_con_cat_commision cc where cc.id = p.reward_cat_id) as reward_percentage from gp_product_details p left join gp_pl_channel_partner par on par.id = p.channel_partner_id LEFT join countries ct on ct.id = par.country left join states s on s.id = par.state LEFT join cities c on c.id = par.town LEFT JOIN gp_product_image pr_img on pr_img.product_id = p.id left join gp_product_brands b on p.brand_id = b.id where p.is_del = 0 and $type and p.id = '$id' group by p.id";


        $result=$this->db->query($qry);
     
        if($result->num_rows()>0)
        {
            $data['details'] = $result->row_array();
            $qry_img = "select img.p_image FROM gp_product_details p LEFT JOIN gp_product_image img on p.id = img.product_id WHERE p.is_del = '0' and p.id = '$id'";
            $qry_imgz = $this->db->query($qry_img);
            if($qry_imgz->num_rows()>0)
            {
              $data['images'] = $qry_imgz->result_array();
            }else{
              $data['images'] = array();
            }   

        }
        else
        {
            $data['details'] = array();
        }
         return $data;
    }
    function  get_deal_details_by_id($id)
    {
   
      $qry = "select p.id as pr_id,pr_img.p_image as product_image, par.id as ch_id , par.name as cp_name, par.brand_image, p.cp_connection_id, p.name , p.description, p.full_specification, p.quantity, p.model, p.actual_cost, p.special_prize,c.coupon_percentage,c.coupon_validity,c.id as deal_id,c.end_date, pr_img.p_image as image,par.lattitude,par.longitude,par.address,par.phone,par.email,ct.name as country, s.name as state, cs.name as city 
      from gp_product_details p 
      left join gp_pl_channel_partner par on par.id = p.channel_partner_id  
      LEFT join countries ct on ct.id = par.country 
      left join states s on s.id = par.state 
      LEFT join cities cs on cs.id = par.town 
      LEFT JOIN gp_product_image pr_img on pr_img.product_id = p.id 
      left join gp_product_brands b on p.brand_id = b.id 
      left join gp_deal_channel_partner_con c on p.id = c.product_id where p.is_del = 0 and p.`type` != '0' and p.id = '$id' group by p.id";


        $result=$this->db->query($qry);
       
        if($result->num_rows()>0)
        {
            $data['details'] = $result->row_array();
            $qry_img = "select img.p_image FROM gp_product_details p LEFT JOIN gp_product_image img on p.id = img.product_id WHERE p.is_del = '0' and p.id = '$id'";
            $qry_imgz = $this->db->query($qry_img);
            if($qry_imgz->num_rows()>0)
            {
              $data['images'] = $qry_imgz->result_array();
            }else{
              $data['images'] = array();
            }   

        }
        else
        {
            $data['details'] = array();
        }
         return $data;
    }
    function get_deal_product()
    {
         $sql = $this->db->query("select c.id,c.product_id,c.purchased_on,s.duration,c.channel_partner_id, c.end_date from gp_deal_channel_partner_con c LEFT JOIN gp_deal_settings s on s.id = c.deal_id WHERE c.status = '1'");
         
          $res1 = $sql->result_array();
          
          $pr_id = array();
          $ids = array();
          $pr_id1 = array();
          $today = date("Y-m-d H:i:s");
          foreach ( $res1  as $key => $value) {
              
               if($value['end_date']>= $today)
               {
                array_push($pr_id, $value['product_id']);
                
               }else{
                  array_push($ids, $value['id']); 
                  array_push($pr_id1, $value['product_id']); 
               } 
           }
           //var_dump($pr_id);var_dump($ids);var_dump($prds);exit();
           $prds = implode("','",$pr_id);
           $ids = implode("','",$ids);
           $prds1 = implode("','",$pr_id1);
            $qry= "select p.id as pr_id, par.id , par.name as cp_name, par.brand_image, p.cp_connection_id, p.name, p.description, p.full_specification, p.quantity, p.model, p.actual_cost, p.special_prize, pi.p_image as image,DATE_FORMAT(con.end_date, '%M %d, %Y %H:%i:%s') as end_date,p.quantity,con.coupon_percentage from gp_product_details p LEFT JOIN gp_product_image pi on pi.product_id = p.id LEFT JOIN gp_pl_channel_partner par ON par.id = p.channel_partner_id LEFT JOIN gp_deal_channel_partner_con con on con.id = p.type LEFT JOIN gp_deal_settings d on d.id = con.deal_id where p.id in ('$prds') and type!='0' and p.is_del = '0' and p.quantity >'0' GROUP by p.id order by p.id desc";
            $query=$this->db->query($qry);
          
            $data = $query->result_array();

          //deactivate inactivate deals

           $qry_del_deal = $this->db->query("update gp_deal_channel_partner_con c set c.status = '0' where c.id in ('$ids')");
           $qry_del_deal_pro = $this->db->query("update gp_product_details p set p.is_del = '1' where p.id in ('$prds1')");

         return $data;


    }

    
    function get_deal_product1()
    {

          $sql = "select count(id) as c,channel_partner_id from gp_deal_channel_partner_con group by channel_partner_id";
          $ids = $this->db->query($sql);
          $data['cps'] = $ids->result_array();
          //var_dump($data['cps']);exit;
          foreach ( $data['cps']  as $key => $value) {
          
            $id = $value['channel_partner_id'];
           
             $limit = $value['c'];
           // var_dump($c['c']);
            
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
              p.special_prize,

              pi.p_image as image
               from gp_pl_channel_partner_type_connection con
                        left join gp_pl_channel_partner par on par.id = con.channel_partner_id
                         left join gp_product_details p on p.cp_connection_id = con.id  
                         LEFT JOIN gp_product_image pi on pi.product_id = p.id
                         where  type!='0' and par.id = $id  and p.is_del = '0' order by p.id desc limit $limit";
            $query=$this->db->query($qry);
            $data['cps'][$key]['deal'] = $query->result_array();
            
          }
        
         return $data;


    }
    function get_deal_product_module_wise($id,$lcid)
    {

      $loc_query = ($lcid=="0"||$lcid=="all") ? '' : " and p.town='$lcid' ";
      $newqry = "select dt.id, dt.brand_id, dt.category_id, dt.cp_connection_id, IFNULL(dt.name, '') as name, dt.description, dt.full_specification, dt.quantity, gpi.p_image as image, dt.model,d.end_date, dt.actual_cost,dt.special_prize, IFNULL(p.name, '') as partner, p.brand_image as partner_img, dt.sub_cp_type_id from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id LEFT JOIN gp_deal_channel_partner_con d on d.product_id = dt.id where dt.is_del = 0 and dt.`type` != '0' and p.id = '$id' and d.end_date >= CURDATE() and p.is_del=0 $loc_query GROUP by dt.id order by dt.id desc";
        $newqry=$this->db->query($newqry);
        if($newqry->num_rows()>0){
          $data = $newqry->result_array();
        }
        else{
          $data = array();
        }
           
        return $data;
    }
    
    function get_deal_product_cp_wise($id)
    {

        
        $newqry = "select dt.id, dt.brand_id, dt.category_id, dt.cp_connection_id, IFNULL(dt.name, '') as name, dt.description, dt.full_specification, dt.quantity, gpi.p_image as image, dt.model,d.end_date, dt.actual_cost,dt.special_prize, IFNULL(p.name, '') as partner, p.brand_image as partner_img, dt.sub_cp_type_id from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id LEFT JOIN gp_deal_channel_partner_con d on d.product_id = dt.id where dt.is_del = 0 and dt.`type` != '0' and p.module = '$id' and d.end_date >= CURDATE() GROUP by dt.id order by dt.id desc";
        $newqry=$this->db->query($newqry);
        if($newqry->num_rows()>0){
          $data = $newqry->result_array();
        }
        else{
          $data = array();
        }
       // echo $this->db->last_query();exit();
      
            
        return $data;
    }
function get_submenu()
{
 $qry= "select * FROM gp_permission_module where  header_module='1' and is_del = '0'";
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
    $data = array();
    $qry = "SELECT * FROM gp_permission_module where is_del = '0'";
    $qry=$this->db->query($qry);
    if($qry->num_rows()>0)
    {
      $data['module']=$qry->result_array();
    
      foreach ($data['module'] as $key => $module) 
      {
        $module_id = $module['id'];
      
        if(empty($module['module_image']))
        {
          $sql = "select image from advertisement where type = 'default'";
          $sql = $this->db->query($sql);
          $sql = $sql->row_array();
          $data['module'][$key]['module_image'] = $sql['image'];
         
        }
        $newqry = "select p.id p_id, pi.p_image as image, p.name, par.brand_image as par_img, par.name partner_name, p.actual_cost, p.quantity,p.special_prize,(select cc.percentage from gp_channel_con_cat_commision cc where cc.id = p.reward_cat_id) as reward_percentage from gp_product_details p LEFT JOIN gp_product_image pi on pi.product_id = p.id LEFT JOIN gp_pl_channel_partner par on par.id = p.channel_partner_id where par.module = '$module_id' and type ='0' and p.is_del = '0' GROUP by p.id order by p.id desc";
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
function get_cp_searchlist($key,$lcid)
    {
        $data = array();
       $loc_query = ($lcid==0||$lcid=="all") ? '' : " and c.town='$lcid' ";
        $query=$this->db->query("SELECT c.id,c.address,c.town,c.phone,c.email,(select ct.name as city from cities ct where ct.id = c.town) as city,(select s.name from states s where s.id = c.state) as state,(select cr.name from countries cr where cr.id = c.country) as country, c.name,IFNULL(c.profile_image,'assets/images/shop_dummy.jpg') AS profile_image,IFNULL(c.brand_image,'assets/images/dummy_logo.png') AS brand_image from gp_pl_channel_partner c left join cities ct on c.town = ct.id where c.status = 'JOINED' and c.is_del = 0 and c.name like '%$key%' $loc_query and c.is_del=0  group by c.id order by c.name asc  ");
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
function get_product_searchlist($key,$lcid)
{
  $data = array();
      $loc_query = ($lcid=="0"||$lcid=="all") ? '' : " and p.town='$lcid' ";
          $newqry = "select dt.id, dt.brand_id, dt.category_id, dt.cp_connection_id, IFNULL(dt.name, '') as name, dt.description, dt.full_specification, dt.quantity, gpi.p_image as image, dt.model, dt.actual_cost,dt.special_prize, IFNULL(p.name, '') as partner, p.brand_image as partner_img, dt.sub_cp_type_id,(select cc.percentage from gp_channel_con_cat_commision cc where cc.id = dt.reward_cat_id) as reward_percentage  from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id where dt.is_del = 0 and dt.`type` = '0' and p.is_del=0 and dt.name like '%$key%' $loc_query GROUP by dt.id order by dt.id desc";
          $newqry=$this->db->query($newqry);
          //echo $this->db->last_query();exit();
            if($newqry->num_rows()>0)
            {
              $data['product'] = $newqry->result_array();
            }else{
              $data['product'] = array();
            }            
 
    return $data;
}
function get_deals_searchlist($key,$lcid)
  {

     $loc_query = ($lcid==0||$lcid=="all") ? '' : " and p.town='$lcid' ";
      $newqry = "select dt.id, dt.brand_id, dt.category_id, dt.cp_connection_id, IFNULL(dt.name, '') as name, dt.description, dt.full_specification, dt.quantity, gpi.p_image as image, dt.model,d.end_date, dt.actual_cost,dt.special_prize, IFNULL(p.name, '') as partner, p.brand_image as partner_img, dt.sub_cp_type_id from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id LEFT JOIN gp_deal_channel_partner_con d on d.product_id = dt.id where dt.is_del = 0 and dt.`type` != '0' and d.end_date >= CURDATE() and dt.name like '%$key%' and p.is_del=0 $loc_query GROUP by dt.id order by dt.id desc";
      $newqry=$this->db->query($newqry);
      if($newqry->num_rows()>0){
        $data = $newqry->result_array();
      }
      else{
        $data = array();
      }
         
      return $data;
  }
function get_product_view_module_wise($id,$lcid)
{
  $data = array();
      $loc_query = ($lcid=="0"||$lcid=="all") ? '' : " and p.town='$lcid' ";
          $newqry = "select dt.id, dt.brand_id, dt.category_id, dt.cp_connection_id, IFNULL(dt.name, '') as name, dt.description, dt.full_specification, dt.quantity, gpi.p_image as image, dt.model, dt.actual_cost,dt.special_prize, IFNULL(p.name, '') as partner, p.brand_image as partner_img, dt.sub_cp_type_id,(select cc.percentage from gp_channel_con_cat_commision cc where cc.id = dt.reward_cat_id) as reward_percentage  from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id where dt.is_del = 0 and dt.`type` = '0' and p.module = '$id' and p.is_del=0 $loc_query GROUP by dt.id order by dt.id desc";
          $newqry=$this->db->query($newqry);
            //echo $this->db->last_query();exit();
            if($newqry->num_rows()>0)
            {
              $data['product'] = $newqry->result_array();
            }else{
              $data['product'] = array();
            }            
 
    return $data;
}
function get_product_cp_wise($id)
{
  $data = array();
   
          $newqry = "select dt.id, dt.brand_id, dt.category_id, dt.cp_connection_id, IFNULL(dt.name, '') as name, dt.description, dt.full_specification, dt.quantity, gpi.p_image as image, dt.model, dt.actual_cost,dt.special_prize, IFNULL(p.name, '') as partner, p.brand_image as partner_img, dt.sub_cp_type_id,(select cc.percentage from gp_channel_con_cat_commision cc where cc.id = dt.reward_cat_id) as reward_percentage  from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id where dt.is_del = 0 and dt.`type` = '0' and p.id = '$id' GROUP by dt.id order by dt.id desc";
          $newqry=$this->db->query($newqry);
            //echo $this->db->last_query();exit();
            if($newqry->num_rows()>0)
            {
              $data['product'] = $newqry->result_array();
            }else{
              $data['product'] = array();
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

        $qry= "select ROUND(walv.total_value,2)AS total_value FROM gp_login_table logg
  LEFT JOIN gp_wallet_values walv on walv.user_id=logg.id 
  where logg.id='$login_id' and walv.wallet_type_id='$id'";

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
              ca.description 
              from
              gp_pl_channel_partner_types ca
              where ca.parent != 0
              ";
      $qry=$this->db->query($qry);
      if($qry->num_rows()>0)
        {
            $data['category'] = $qry->result_array();
          foreach ($data['category'] as $key => $cate) {
            $cat_id = $cate['id'];
            $sub_qry = "select
                          gsc.id,
                          gsc.title

                          from
                          gp_pl_channel_partner_types cat inner join gp_cp_sub_category gsc on
                          gsc.parent = cat.id
                          where cat.id = '$cat_id'";
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
    function getAllDeal($where, $limit, $start, $sort_order)
    {
        if($sort_order == 'whatsnew|desc'){
              $order_by = 'dt.id desc';
            }else if($sort_order == 'price|desc'){
              $order_by = 'dt.special_prize desc';
            }else if($sort_order == 'price|asc'){
              $order_by = 'dt.special_prize asc';
            }else if($sort_order == 'popular|desc'){
              $order_by = 'dt.viewed desc';
            }else{
              $order_by = 'dt.id desc';
          }
        $data = array();
    
        $qry= "select dt.id, dt.brand_id, dt.category_id, dt.cp_connection_id, IFNULL(dt.name, '') as name, dt.description, dt.full_specification, dt.quantity, gpi.p_image as image, dt.model, dt.actual_cost,dt.special_prize,ROUND((((dt.actual_cost - dt.special_prize)/dt.actual_cost)*100),2) as percentage, IFNULL(p.name, '') as partner, p.brand_image as partner_img, dt.sub_cp_type_id,DATE_FORMAT(d.end_date, '%M %d, %Y %h:%i:%s') as end_date  from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id LEFT JOIN gp_deal_channel_partner_con d on d.product_id = dt.id where dt.is_del = 0 and dt.`type` != '0' and d.end_date >= CURDATE() and dt.quantity > 0 $where GROUP by dt.id order by $order_by limit $start,$limit";

        $query=$this->db->query($qry);
       //echo $this->db->last_query();exit;
        if($query->num_rows()>0)
        {
          $data["status"] = TRUE;
          $data['data'] = $query->result_array();
          $category = array();
          $brands = array();
          foreach ($data['data'] as $key => $value) {
            $sid = $value['sub_cp_type_id'];
            array_push($category, $sid);
            $bid = $value['brand_id'];
            array_push($brands, $bid);
          }
          $cat_array = implode("','", $category);
          $brand_array = implode("','", $brands);
          //var_dump($cat_array);exit();
          $qry_cat = $this->db->query("select * from gp_cp_sub_category s where s.id IN ('$cat_array')");
          if($qry_cat->num_rows()>0){
           $data['category'] = $qry_cat->result_array();
          }else{
           $data['category'] = array();
          }
          $qry_brand = $this->db->query("select * from gp_product_brands b where b.id IN ('$brand_array')");
          if($qry_brand->num_rows()>0){
           $data['brands'] = $qry_brand->result_array();
          }else{
           $data['brands'] = array();
          }
        }
        else
        {
          $data["status"] = FALSE;
          $data['data'] = array();
        }
        return $data;

    }
    function get_all_categories_from_parent($cat_id){


         $cat_array = array();
       
         $qry_cat = "select
                            ct.id as cat_id, ct.title
                            from gp_pl_channel_partner_types ct
                            where ct.parent = '$cat_id' ";

         $qry_cat = $this->db->query($qry_cat);

         if($qry_cat && $qry_cat->num_rows()>0)
         {
             $details['sub_cat'] = $qry_cat->result_array();

             foreach ($details['sub_cat'] as $ky => $sub_cat ){

                 $sub_cat_id = $sub_cat['cat_id'];
                 array_push($cat_array, $sub_cat_id);
                 $sub_cat_qry = "select
                            ct.id as cat_id, ct.title
                            from gp_pl_channel_partner_types ct
                            where ct.parent = '$sub_cat_id' ";

                 $sub_cat_qry = $this->db->query($sub_cat_qry);
                 if($sub_cat_qry && $sub_cat_qry->num_rows()>0)
                 {
                     $data_det['sub_cat'] = $sub_cat_qry->result_array();
                     foreach ($data_det['sub_cat'] as $det){
                         $sub_sub_id = $det['cat_id'];
                         array_push($cat_array, $sub_sub_id);
                     }
                 }else{
                     $data_det = array();
                 }
             }
            $result = array_unique($cat_array);
             $res = implode("','",$result);
         }
         else
         {
           // $result = array();
            $res = '';
         }

         return $res;

     }
    function getAllProduct($where, $limit, $start, $sort_order,$lcid)
    {
        $loc_query = ($lcid=="0"||$lcid=="all") ? '' : " and p.town='$lcid' ";
        if($sort_order == 'whatsnew|desc'){
              $order_by = 'dt.id desc';
            }else if($sort_order == 'price|desc'){
              $order_by = 'dt.special_prize desc';
            }else if($sort_order == 'price|asc'){
              $order_by = 'dt.special_prize asc';
            }else if($sort_order == 'popular|desc'){
              $order_by = 'dt.viewed desc';
            }else{
              $order_by = 'dt.id desc';
          }
        
        $data = array();
      //  $where =  $where=="0"? "" : "and dt.brand_id = '$where'";
         $qry= "select dt.id, dt.brand_id, dt.category_id, dt.cp_connection_id, IFNULL(dt.name, '') as name, dt.description, dt.full_specification, dt.quantity, gpi.p_image as image, dt.model, dt.actual_cost,dt.special_prize, IFNULL(p.name, '') as partner, p.brand_image as partner_img, dt.sub_cp_type_id,(select cc.percentage from gp_channel_con_cat_commision cc where cc.id = dt.reward_cat_id) as reward_percentage,p.town from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id where $where  dt.is_del = 0 and dt.`type` = '0' and p.is_del=0 $loc_query GROUP by dt.id order by $order_by limit $start,$limit";

        $query=$this->db->query($qry);
       //echo $this->db->last_query();exit;
        if($query->num_rows()>0)
        {
          $data["status"] = TRUE;
          $data['data'] = $query->result_array();
          $category = array();
          $brands = array();
          foreach ($data['data'] as $key => $value) {
            $sid = $value['sub_cp_type_id'];
            array_push($category, $sid);
            $bid = $value['brand_id'];
            array_push($brands, $bid);
          }
          $cat_array = implode("','", $category);
          $brand_array = implode("','", $brands);
          //var_dump($cat_array);exit();
          $qry_cat = $this->db->query("select * from gp_pl_channel_partner_types s where s.id IN ('$cat_array')");
          if($qry_cat->num_rows()>0){
           $data['category'] = $qry_cat->result_array();
          }else{
           $data['category'] = array();
          }
          $qry_brand = $this->db->query("select * from gp_product_brands b where b.id IN ('$brand_array')");
          if($qry_brand->num_rows()>0){
           $data['brands'] = $qry_brand->result_array();
          }else{
           $data['brands'] = array();
          }
        }
        else
        {
          $data["status"] = FALSE;
          $data['data'] = array();
        }
        return $data;

    }
    function getAllProduct1($where, $limit, $start, $sort_order,$lcid)
    {
      $loc_query = ($lcid=="0"||$lcid=="all") ? '' : " and p.town='$lcid' ";
        if($sort_order == 'whatsnew|desc'){
              $order_by = 'dt.id desc';
            }else if($sort_order == 'price|desc'){
              $order_by = 'dt.special_prize desc';
            }else if($sort_order == 'price|asc'){
              $order_by = 'dt.special_prize asc';
            }else if($sort_order == 'popular|desc'){
              $order_by = 'dt.viewed desc';
            }else{
              $order_by = 'dt.id desc';
          }
        
        $data = array();
      //  $where =  $where=="0"? "" : "and dt.brand_id = '$where'";
         $qry= "select dt.id, dt.brand_id, dt.category_id, dt.cp_connection_id, IFNULL(dt.name, '') as name, dt.description, dt.full_specification, dt.quantity, gpi.p_image as image, dt.model, dt.actual_cost,dt.special_prize, IFNULL(p.name, '') as partner, p.brand_image as partner_img, dt.sub_cp_type_id,(select cc.percentage from gp_channel_con_cat_commision cc where cc.id = dt.reward_cat_id) as reward_percentage,p.town from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id where $where  dt.is_del = 0 and dt.`type` = '0' and p.is_del=0 $loc_query GROUP by dt.id order by $order_by limit $start,$limit";

        $query=$this->db->query($qry);
       //echo $this->db->last_query();exit;
        if($query->num_rows()>0)
        {
          $data["status"] = TRUE;
          $data['data'] = $query->result_array();
          $category = array();
          $brands = array();
          foreach ($data['data'] as $key => $value) {
            $sid = $value['sub_cp_type_id'];
            array_push($category, $sid);
            $bid = $value['brand_id'];
            array_push($brands, $bid);
          }
          $cat_array = implode("','", $category);
          $brand_array = implode("','", $brands);
          //var_dump($cat_array);exit();
          $qry_cat = $this->db->query("select * from gp_pl_channel_partner_types s where s.id IN ('$cat_array')");
          if($qry_cat->num_rows()>0){
           $data['category'] = $qry_cat->result_array();
          }else{
           $data['category'] = array();
          }
          $qry_brand = $this->db->query("select * from gp_product_brands b where b.id IN ('$brand_array')");
          if($qry_brand->num_rows()>0){
           $data['brands'] = $qry_brand->result_array();
          }else{
           $data['brands'] = array();
          }
        }
        else
        {
          $data["status"] = FALSE;
          $data['data'] = array();
        }
        return $data;

    }
    function getAllDealCountModulewise($where,$mod_id)
    {  
      $qry= "select dt.id from gp_product_details dt
              left join gp_pl_channel_partner p on dt.channel_partner_id = p.id 
              LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id
              where $where dt.is_del = 0 and dt.`type` != '0' and p.module = '$mod_id' and p.is_del=0  group by dt.id";
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
    function getAllDealCountCpwise($where,$id)
    {  
      $qry= "select
              dt.id
              from
              gp_product_details dt
              left join gp_pl_channel_partner_type_connection con on con.id = dt.cp_connection_id
              left join gp_pl_channel_partner p on p.id = con.channel_partner_id
              LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id
              where $where dt.is_del = 0 and dt.`type` != '0' and p.id = '$id' group by dt.id";
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
     function getAllProductCountModulewise($where,$mod_id,$lcid)
    {
     $loc_query = ($lcid=="0"||$lcid=="all") ? '' : " and p.town='$lcid' ";
      $qry= "select dt.id from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id
              where $where dt.is_del = 0 and dt.`type` = '0' and p.module = '$mod_id' and p.is_del=0 $loc_query group by dt.id"; 
        $query=$this->db->query($qry);
        //echo $this->db->last_query();exit();
        if($query->num_rows()>0)
        {
            return $query->num_rows();
        }
        else
        {
            return false;
        }
    }
    function getAllProductCountCpwise($where,$id)
     {
       $qry= "select dt.id from
              gp_product_details dt
              left join gp_pl_channel_partner_type_connection con on con.id = dt.cp_connection_id
              left join gp_pl_channel_partner p on p.id = con.channel_partner_id
              LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id
              where $where dt.is_del = 0 and dt.`type` = '0' and p.id = '$id' group by dt.id";

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
    function getAllProductModulewise($where, $limit, $start, $sort_order,$mod_id,$lcid)
    {
        $loc_query = ($lcid=="0"||$lcid=="all") ? '' : " and p.town='$lcid' ";
        if($sort_order == 'whatsnew|desc'){
              $order_by = 'dt.id desc';
            }else if($sort_order == 'price|desc'){
              $order_by = 'dt.special_prize desc';
            }else if($sort_order == 'price|asc'){
              $order_by = 'dt.special_prize asc';
            }else if($sort_order == 'popular|desc'){
              $order_by = 'dt.viewed desc';
            }else{
              $order_by = 'dt.id desc';
          }
        
        $data = array();
      //  $where =  $where=="0"? "" : "and dt.brand_id = '$where'";
        $qry= "select dt.id, dt.brand_id, dt.category_id, dt.cp_connection_id, IFNULL(dt.name, '') as name, dt.description, dt.full_specification, dt.quantity, gpi.p_image as image, dt.model, dt.actual_cost,dt.special_prize, IFNULL(p.name, '') as partner, p.brand_image as partner_img, dt.sub_cp_type_id,(select cc.percentage from gp_channel_con_cat_commision cc where cc.id = dt.reward_cat_id) as reward_percentage from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id where $where  dt.is_del = 0 and dt.`type` = '0' and p.module = '$mod_id' $loc_query and p.is_del=0 GROUP by dt.id order by $order_by limit $start,$limit";

        $query=$this->db->query($qry);
       //echo $this->db->last_query();exit;
        if($query->num_rows()>0)
        {
          $data["status"] = TRUE;
          $data['data'] = $query->result_array();
          $category = array();
          $brands = array();
          foreach ($data['data'] as $key => $value) {
            $sid = $value['sub_cp_type_id'];
            array_push($category, $sid);
            $bid = $value['brand_id'];
            array_push($brands, $bid);
          }
          $cat_array = implode("','", $category);
          $brand_array = implode("','", $brands);
          //var_dump($cat_array);exit();
          $qry_cat = $this->db->query("select * from gp_pl_channel_partner_types s where s.id IN ('$cat_array')");
          if($qry_cat->num_rows()>0){
           $data['category'] = $qry_cat->result_array();
          }else{
           $data['category'] = array();
          }
          $qry_brand = $this->db->query("select * from gp_product_brands b where b.id IN ('$brand_array')");
          if($qry_brand->num_rows()>0){
           $data['brands'] = $qry_brand->result_array();
          }else{
           $data['brands'] = array();
          }
        }
        else
        {
          $data["status"] = FALSE;
          $data['data'] = array();
        }
        return $data;

    }
    function getAllProductCpwise($where, $limit, $start, $sort_order,$id)
    {
        if($sort_order == 'whatsnew|desc'){
              $order_by = 'dt.id desc';
            }else if($sort_order == 'price|desc'){
              $order_by = 'dt.special_prize desc';
            }else if($sort_order == 'price|asc'){
              $order_by = 'dt.special_prize asc';
            }else if($sort_order == 'popular|desc'){
              $order_by = 'dt.viewed desc';
            }else{
              $order_by = 'dt.id desc';
          }
        
        $data = array();
        $qry= "select dt.id, dt.brand_id, dt.category_id, dt.cp_connection_id, IFNULL(dt.name, '') as name, dt.description, dt.full_specification, dt.quantity, gpi.p_image as image, dt.model, dt.actual_cost,dt.special_prize, IFNULL(p.name, '') as partner, p.brand_image as partner_img, dt.sub_cp_type_id,(select cc.percentage from gp_channel_con_cat_commision cc where cc.id = dt.reward_cat_id) as reward_percentage from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id where $where  dt.is_del = 0 and dt.`type` = '0' and p.id = '$id' GROUP by dt.id order by $order_by limit $start,$limit";

        $query=$this->db->query($qry);
       //echo $this->db->last_query();exit;
        if($query->num_rows()>0)
        {
          $data["status"] = TRUE;
          $data['data'] = $query->result_array();
          $category = array();
          $brands = array();
          foreach ($data['data'] as $key => $value) {
            $sid = $value['sub_cp_type_id'];
            array_push($category, $sid);
            $bid = $value['brand_id'];
            array_push($brands, $bid);
          }
          $cat_array = implode("','", $category);
          $brand_array = implode("','", $brands);
          //var_dump($cat_array);exit();
          $qry_cat = $this->db->query("select * from gp_pl_channel_partner_types s where s.id IN ('$cat_array')");
          if($qry_cat->num_rows()>0){
           $data['category'] = $qry_cat->result_array();
          }else{
           $data['category'] = array();
          }
          $qry_brand = $this->db->query("select * from gp_product_brands b where b.id IN ('$brand_array')");
          if($qry_brand->num_rows()>0){
           $data['brands'] = $qry_brand->result_array();
          }else{
           $data['brands'] = array();
          }
        }
        else
        {
          $data["status"] = FALSE;
          $data['data'] = array();
        }
        return $data;
    }
    function getAllcpsCount($id)
     {
        $loc_query = ($id=="0"||$id=="all") ? '' : " and c.town='$id' ";
        $query=$this->db->query("SELECT c.id from gp_pl_channel_partner c left join cities ct on c.town = ct.id where  c.status = 'JOINED' $loc_query and c.is_del = 0 group by c.id ");
      
        if($query->num_rows()>0)
        {
            return $query->num_rows();
        }
        else
        {
            return false;
        }
    }
    function getAllcps($limit, $start,$id)
    {
        $data = array();
        $loc_query = ($id=="0" || $id=="all") ? '' : " and c.town='$id' ";
       /* $query=$this->db->query("SELECT c.name,IFNULL(c.profile_image,'assets/images/shop_dummy.jpg') AS profile_image,IFNULL(c.brand_image,'assets/images/dummy_logo.png.png') AS brand_image ,c.id,c.phone,c.address,c.town,c.email,(select ct.name as city from cities ct where ct.id = c.town) as city,(select s.name from states s where s.id = c.state) as state,(select cr.name from countries cr where cr.id = c.country) as country  from gp_pl_channel_partner c left join cities ct on c.town = ct.id where c.status = 'JOINED' $loc_query and c.is_del = 0 group by c.id order by c.name asc limit $start,$limit");*/





        $query=$this->db->query("SELECT c.name,IFNULL(c.profile_image,'assets/images/shop_dummy.jpg') AS profile_image,IFNULL(c.brand_image,'assets/images/dummy_logo.png.png') AS brand_image ,c.id,c.phone,c.address,c.town,c.email,c.area  from gp_pl_channel_partner c left join cities ct on c.town = ct.id where c.status = 'JOINED' $loc_query and c.is_del = 0 group by c.id order by c.name asc limit $start,$limit");






       //echo $this->db->last_query();exit;
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
    function getAllDealModulewise($where, $limit, $start, $sort_order,$mod_id)
    {
        if($sort_order == 'whatsnew|desc'){
              $order_by = 'dt.id desc';
            }else if($sort_order == 'price|desc'){
              $order_by = 'dt.special_prize desc';
            }else if($sort_order == 'price|asc'){
              $order_by = 'dt.special_prize asc';
            }else if($sort_order == 'popular|desc'){
              $order_by = 'dt.viewed desc';
            }else{
              $order_by = 'dt.id desc';
          }
        
        $data = array();
      //  $where =  $where=="0"? "" : "and dt.brand_id = '$where'";
        $qry= "select dt.id, dt.brand_id, dt.category_id, dt.cp_connection_id, IFNULL(dt.name, '') as name, dt.description, dt.full_specification, dt.quantity, gpi.p_image as image, dt.model, dt.actual_cost,dt.special_prize, IFNULL(p.name, '') as partner, p.brand_image as partner_img, dt.sub_cp_type_id,d.end_date 
        from gp_product_details dt 
        left join gp_pl_channel_partner p on p.id = dt.channel_partner_id 
        LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id 
        left join gp_product_brands b on dt.brand_id = b.id 
        LEFT JOIN gp_deal_channel_partner_con d on d.product_id = dt.id
        where $where  dt.is_del = 0 and dt.`type` != '0' and p.module = '$mod_id' and p.is_del=0  GROUP by dt.id order by $order_by limit $start,$limit";

        $query=$this->db->query($qry);
       //echo $this->db->last_query();exit;
        if($query->num_rows()>0)
        {
          $data["status"] = TRUE;
          $data['data'] = $query->result_array();
          $category = array();
          $brands = array();
          foreach ($data['data'] as $key => $value) {
            $sid = $value['sub_cp_type_id'];
            array_push($category, $sid);
            $bid = $value['brand_id'];
            array_push($brands, $bid);
          }
          $cat_array = implode("','", $category);
          $brand_array = implode("','", $brands);
          //var_dump($cat_array);exit();
          $qry_cat = $this->db->query("select * from gp_pl_channel_partner_types s where s.id IN ('$cat_array')");
          if($qry_cat->num_rows()>0){
           $data['category'] = $qry_cat->result_array();
          }else{
           $data['category'] = array();
          }
          $qry_brand = $this->db->query("select * from gp_product_brands b where b.id IN ('$brand_array')");
          if($qry_brand->num_rows()>0){
           $data['brands'] = $qry_brand->result_array();
          }else{
           $data['brands'] = array();
          }
        }
        else
        {
          $data["status"] = FALSE;
          $data['data'] = array();
        }
        return $data;

    }
    function getAllDealCpwise($where, $limit, $start, $sort_order,$id)
    {
        if($sort_order == 'whatsnew|desc'){
              $order_by = 'dt.id desc';
            }else if($sort_order == 'price|desc'){
              $order_by = 'dt.special_prize desc';
            }else if($sort_order == 'price|asc'){
              $order_by = 'dt.special_prize asc';
            }else if($sort_order == 'popular|desc'){
              $order_by = 'dt.viewed desc';
            }else{
              $order_by = 'dt.id desc';
          }
        
        $data = array();
      //  $where =  $where=="0"? "" : "and dt.brand_id = '$where'";
        $qry= "select dt.id, dt.brand_id, dt.category_id, dt.cp_connection_id, IFNULL(dt.name, '') as name, dt.description, dt.full_specification, dt.quantity, gpi.p_image as image, dt.model, dt.actual_cost,dt.special_prize, IFNULL(p.name, '') as partner, p.brand_image as partner_img, dt.sub_cp_type_id,d.end_date 
        from gp_product_details dt 
        left join gp_pl_channel_partner p on p.id = dt.channel_partner_id 
        LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id 
        left join gp_product_brands b on dt.brand_id = b.id 
LEFT JOIN gp_deal_channel_partner_con d on d.product_id = dt.id

        where $where  dt.is_del = 0 and dt.`type` != '0' and p.id = '$id' GROUP by dt.id order by $order_by limit $start,$limit";

        $query=$this->db->query($qry);
       //echo $this->db->last_query();exit;
        if($query->num_rows()>0)
        {
          $data["status"] = TRUE;
          $data['data'] = $query->result_array();
          $category = array();
          $brands = array();
          foreach ($data['data'] as $key => $value) {
            $sid = $value['sub_cp_type_id'];
            array_push($category, $sid);
            $bid = $value['brand_id'];
            array_push($brands, $bid);
          }
          $cat_array = implode("','", $category);
          $brand_array = implode("','", $brands);
          //var_dump($cat_array);exit();
          $qry_cat = $this->db->query("select * from gp_pl_channel_partner_types s where s.id IN ('$cat_array')");
          if($qry_cat->num_rows()>0){
           $data['category'] = $qry_cat->result_array();
          }else{
           $data['category'] = array();
          }
          $qry_brand = $this->db->query("select * from gp_product_brands b where b.id IN ('$brand_array')");
          if($qry_brand->num_rows()>0){
           $data['brands'] = $qry_brand->result_array();
          }else{
           $data['brands'] = array();
          }
        }
        else
        {
          $data["status"] = FALSE;
          $data['data'] = array();
        }
        return $data;

    }
    function getAllProductById($where, $limit, $start,$id)
    {
        //var_dump($where);exit;
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
              
              IFNULL(p.name, '') as partner,
              p.brand_image as partner_img
              from
              gp_product_details dt
              left join gp_pl_channel_partner_type_connection con on con.id = dt.cp_connection_id
              left join gp_pl_channel_partner p on p.id = con.channel_partner_id

              where dt.is_del = 0 and dt.`type` = '0' $where and con.channel_partner_type_id = '$id'
              order by dt.id desc
              limit $start,$limit";



        $query=$this->db->query($qry);
        // echo $this->db->last_query();exit;
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
     function getAllDealsCount($where)
    {
    
      $qry= "select dt.id from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id LEFT JOIN gp_deal_channel_partner_con d on d.product_id = dt.id where dt.is_del = 0 and dt.`type` != '0' and d.end_date >= CURDATE() GROUP by dt.id order by dt.id desc";

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
    function getAllProductCount($where,$lcid)
    {
    
      $loc_query = ($lcid=="0"||$lcid=="all") ? '' : " and p.town='$lcid' ";

        $query=$this->db->query("select dt.id from gp_product_details dt left join gp_pl_channel_partner p on dt.channel_partner_id = p.id LEFT JOIN gp_product_image gpi on dt.id= gpi.product_id where $where dt.is_del = 0 and dt.`type` = '0' and p.is_del=0 $loc_query group by dt.id");

        if($query->num_rows()>0)
        {
            return $query->num_rows();
        }
        else
        {
            return false;
        }
    }
    function getAllProductCountById($where,$id)
    {
        // var_dump($where);
        //  $where =  $where=="0"? "" : "and dt.brand_id = '$where'";

        $qry= "select
              dt.id
              from
              gp_product_details dt
              left join gp_pl_channel_partner_type_connection con on con.id = dt.cp_connection_id
              left join gp_pl_channel_partner p on p.id = con.channel_partner_id

              where dt.is_del = 0 and dt.`type` = '0' $where  and con.channel_partner_type_id = '$id' ";



        $query=$this->db->query($qry);
        // echo $this->db->last_query();exit;
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