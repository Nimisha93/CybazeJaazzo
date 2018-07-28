
<?php
Class Search_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();
    }

    public function get_search_product($search_data)
    {
//        $qry="select cat.title, cat.description from gp_product_category cat where cat.title like '$search_data'";
//        $querys=$this->db->query($qry);
         echo   $this->db->last_query();

//            return $querys->result_array();


        $this->db->select('title, id');
        $this->db->like('title', $search_data);

        return $this->db->get('gp_product_category', 10)->result();
    }

    function get_search_category($key){
      // echo $key; exit();
                $qry="SELECT title FROM gp_product_category WHERE title LIKE '%$key%' order by id desc";
                // $qry="SELECT * FROM gp_product_category
                // WHERE title or description LIKE '$key' order by id desc";
        $querys=$this->db->query($qry);
        if($querys->num_rows()>0)
        {
           return $querys->result_array();
        }
     else{
          return array();
         }
    }
    function get_search_category1($key){
        $locationsession = $this->session->userdata('selected_location');
        $lcid=($locationsession['id']) ? $locationsession['id'] : 0;
        $loc_query = ($lcid==0) ? '' : " and cp.town='$lcid' ";
        $qry="SELECT t.id,t.title FROM gp_pl_channel_partner_types t left join gp_pl_channel_partner_type_connection tc on t.id = tc.channel_partner_type_id left join gp_pl_channel_partner cp on tc.channel_partner_id = cp.id WHERE  t.title LIKE '%$key%' $loc_query group by t.id order by t.title LIKE '$key%' desc,t.id desc ";
                
        $querys=$this->db->query($qry);
        if($querys->num_rows()>0)
        {
           return $querys->result_array();
        }
     else{
          return array();
         }
    }

    function search_cp($key){
        $locationsession = $this->session->userdata('selected_location');
        $lcid=($locationsession['id']) ? $locationsession['id'] : 0;
        $loc_query = ($lcid==0) ? '' : " and town='$lcid' ";
        $qry="SELECT id,name FROM gp_pl_channel_partner WHERE name LIKE '%$key%' and is_del = 0 and status = 'JOINED' $loc_query order by name LIKE '$key%' desc,id desc";
                
        $querys=$this->db->query($qry);
        if($querys->num_rows()>0)
        {
           return $querys->result_array();
        }
         else{
          return array();
         }
    }
    function search_location_by_keyword($key){
     
        $qry = "SELECT c.id,c.name from cities c LEFT join states s on c.state_id = s.id left join countries ctr on ctr.id = s.country_id where ctr.id = 101 and c.name LIKE '%$key%' order by c.name LIKE '$key%' desc,id desc";
        $querys=$this->db->query($qry);
        if($querys->num_rows()>0)
        {
           return $querys->result_array();
        }
     else{
          return array();
         }
    }

    function get_search_recent($key){

      
      $qry="SELECT tb.search_id,tb.search_type,pd.name,ct.title
            from gp_pl_search_recent tb
            join gp_product_details pd on tb.search_id=pd.id
            join gp_product_category ct on tb.search_id=ct.id";

                // $qry="select * from gp_pl_search_recent
                // where login_id = '$key' order by date desc";

        $querys=$this->db->query($qry);
        if($querys->num_rows()>0)
        {
           return $querys->result_array();
       }
     else{
          return array();
        }
    }

    function get_search_popular($key){
        $qry="SELECT p.id,p.name,pi.p_image as image,p.description,p.quantity,p.special_prize as cost FROM gp_product_details p

          left join gp_product_image pi on p.id = pi.product_id 

          order by p.view_count desc limit 6";
                // $qry="select name from gp_product_details
                // order by view_count desc limit 10";
        $querys=$this->db->query($qry);
        if($querys->num_rows()>0)
        {
           return $querys->result_array();
        }
     else{
          return array();
        }
    }

    function search_popular_deals()
    {
        $qry="SELECT gp.id,gp.name FROM gp_product_details gp

                  left join gp_product_brands b on gp.brand_id = b.id 
                  LEFT JOIN gp_deal_channel_partner_con d on d.id = gp.type
                  WHERE  gp.type != '0'  and gp.is_del = '0'   and d.end_date >= CURDATE()  and gp.quantity > '0' order by gp.view_count desc limit 6";
                    // $qry="select name from gp_product_details
                    // order by view_count desc limit 10";
            $querys=$this->db->query($qry);
            if($querys->num_rows()>0)
            {
               return $querys->result_array();
           }
         else{
              return array();
            }
    }

    function get_search_products($key){
                // $qry="SELECT id,name,image,description,quantity,cost FROM gp_product_details WHERE (name LIKE '%$key%' OR description LIKE '%$key%' OR full_specification LIKE '%$key%'
                // OR cost LIKE '%$key%' OR model LIKE '%$key%') order by view_count desc";


                $qry="SELECT p.id,p.name,pi.p_image as image,p.description,p.quantity,p.special_prize as cost FROM gp_product_details p
                left join gp_product_image pi on p.id = pi.product_id 
                WHERE (p.name LIKE '%$key%' OR p.description LIKE '%$key%' OR p.full_specification LIKE '%$key%'
                OR p.special_prize LIKE '%$key%' OR p.model LIKE '%$key%') group by pi.product_id order by p.view_count desc";

                // $qry="select name from gp_product_details
                // where name or description or full_specification or cost or model
                // like '$key' order by view_count desc";
        $querys=$this->db->query($qry);
        if($querys->num_rows()>0)
        {
           return $querys->result_array();
        }
        else{
             return array();
        }
        }

        function get_search_popular1($key)
        {
            $qry="SELECT name,id FROM gp_product_details  where `type` = '0' and is_del!='1' order by view_count desc limit 6";
                    // $qry="select name from gp_product_details
                    // order by view_count desc limit 10";
            $querys=$this->db->query($qry);
            if($querys->num_rows()>0)
            {
               return $querys->result_array();
           }
         else{
              return array();
            }
        }


        function get_search_deals($key)
        {
                $locationsession = $this->session->userdata('selected_location');
                $lcid=($locationsession['id']) ? $locationsession['id'] : 0;
                $loc_query = ($lcid==0) ? '' : " and cp.town='$lcid' ";
                 $qry="SELECT gp.id,gp.name FROM gp_product_details gp

                  left join gp_product_brands b on gp.brand_id = b.id 
                  LEFT JOIN gp_deal_channel_partner_con d on d.id = gp.type
                  left join gp_pl_channel_partner cp on cp.id = d.channel_partner_id
                  WHERE gp.name LIKE '%$key%' and gp.type != '0'  and gp.is_del = '0' and d.end_date >= CURDATE()  and gp.quantity > '0' and cp.is_del=0 order by gp.id desc";


            $querys=$this->db->query($qry);

            if($querys->num_rows()>0)
            {
               return $querys->result_array();
            }
            else{
                 return array();
            }    
        }

        function get_search_products1($key){
          $locationsession = $this->session->userdata('selected_location');
          $lcid=($locationsession['id']) ? $locationsession['id'] : 0;
          $loc_query = ($lcid==0) ? '' : " and cp.town='$lcid' ";
          $qry="SELECT p.id,p.name FROM gp_product_details p left join gp_pl_channel_partner cp on p.channel_partner_id = cp.id WHERE p.name LIKE '%$key%' and cp.is_del=0 and p.type = '0' and p.is_del!='1'  $loc_query order by p.id desc";

            $querys=$this->db->query($qry);
            if($querys->num_rows()>0)
            {
               return $querys->result_array();
            }
            else{
                 return array();
            }
            }

    function get_search_chanelpartner($key){
        $qry="SELECT name , phone , brand_image  FROM `gp_pl_channel_partner` WHERE (name LIKE '%$key%' OR phone LIKE '%$key%') ORDER BY id DESC LIMIT 4 ";
        // $qry="select name from gp_product_details
        // where name or description or full_specification or cost or model
        // like '$key' order by view_count desc";
        $querys=$this->db->query($qry);
        if($querys->num_rows()>0)
        {
            return $querys->result_array();
        }
        else{
            return array();
        }
    }

        function get_search_by_key($key){
        $qry="select * from gp_product_details detai
                left join gp_product_category cat on cat.id=detai.category_id
                where cat.title  or cat.description or detai.name  or
                 detai.full_specification  or detai.quantity or detai.model
                  like '$key'";
        $querys=$this->db->query($qry);
        //       echo $this->db->last_query();exit();
        if($querys->num_rows()>0)
        {
           return $querys->result_array();
        }
        else{
            return array();
        }
//        $this->db->select('title, id');
//        $this->db->like('title', $key);
//        return $this->db->get('gp_product_category', 10)->result();
        }

    function get_search_by_product($pid){

        $qry="select pcat.title category,par.name partner,img.p_image,detai.name product,detai.description description,

                detai.full_specification specifi,detai.quantity,detai.image,detai.model pmodel,detai.actual_cost act_cost,detai.cost procost

                from gp_product_details detai

                left join gp_product_image img on img.product_id=detai.id

                left join gp_pl_channel_partner_type_connection conn on conn.id=detai.cp_connection_id

                left join gp_pl_channel_partner par on par.id=conn.channel_partner_id

                left join gp_product_category pcat on pcat.id=detai.category_id

                where detai.id='$pid'";

        $querys=$this->db->query($qry);
//        echo $this->db->last_query();exit();
        if($querys->num_rows()>0)
        {

            return $querys->row_array();
        }
        else{

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
}
?>
