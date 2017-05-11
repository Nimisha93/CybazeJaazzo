
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
                $qry="SELECT title FROM gp_product_category WHERE (title LIKE '%$key%' OR description LIKE '%$key%') order by id desc";
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

    function get_search_recent($key){

                // $qry="SELECT * FROM gp_pl_search_recent order by date desc";
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
                $qry="SELECT id,name,image,description,quantity,cost FROM gp_product_details order by view_count desc limit 6";
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
                $qry="SELECT id,name,image,description,quantity,cost FROM gp_product_details WHERE (name LIKE '%$key%' OR description LIKE '%$key%' OR full_specification LIKE '%$key%'
                OR cost LIKE '%$key%' OR model LIKE '%$key%') order by view_count desc";
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
            $qry="SELECT name FROM gp_product_details order by view_count desc limit 6";
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

        function get_search_products1($key){
                    $qry="SELECT name FROM gp_product_details WHERE (name LIKE '%$key%' OR description LIKE '%$key%' OR full_specification LIKE '%$key%'
                    OR cost LIKE '%$key%' OR model LIKE '%$key%') order by view_count desc";
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

    function get_search_chanelpartner($key){
        $qry="SELECT name , phone , brand_image  FROM `gp_pl_channel_partner` WHERE (name LIKE '%$key%') ORDER BY id DESC LIMIT 4 ";
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
