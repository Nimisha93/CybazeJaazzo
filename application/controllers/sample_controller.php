<?php
Class Product_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();
    }

    function get_category(){
        $qry="select pc.title,pc.description,pc.image,pc.parent_id,pc.id from gp_product_category pc where pc.is_del='0'";
        $qry=$this->db->query($qry);
        if($qry){
            $data['category']=$qry->result_array();
        }
        else{
            $data['category']=array();
        }
        return $data;

    }
    function get_brands(){
        $qry="select b.id,b.name from gp_product_brands b where b.is_del='0'";
        $qry=$this->db->query($qry);
        if($qry){
            $data=$qry->result_array();
        }
        else{
            $data=array();
        }
        return $data;

    }
    function get_channel_partners(){
       
        $qry = "select cp.id,cp.name from gp_pl_channel_partner cp where cp.is_del='0' and cp.status = 'JOINED'";
        $query=$this->db->query($qry);
        if($query){
            $data=$query->result_array();
        }
        else{
            $data=array();
        }
        return $data;
    }
    function get_cp_types($id){
        $qry="select pc.title,pc.description,pc.id from gp_pl_channel_partner_types pc inner join gp_pl_channel_partner_type_connection gpc on  gpc.channel_partner_type_id=pc.id
             where pc.is_del='0' and gpc.channel_partner_id = '$id'";
        $qry=$this->db->query($qry);
        //echo $this->db->last_query();
        if($qry){
            $data['category']=$qry->result_array();
        }
        else{
            $data['category']=array();
        }
        return $data;

    }
    function get_cp_type($id){
       // $id = 124;
        $qry="SELECT gt.title, gt.id,gtc.id con_id FROM `gp_pl_channel_partner_type_connection` gtc LEFT JOIN gp_pl_channel_partner_types gt ON
         gtc.channel_partner_type_id = gt.id WHERE gtc.channel_partner_id = '$id' and gt.parent!='0'";
        $qry=$this->db->query($qry);
       // echo $this->db->last_query();exit();
        if($qry){
            $data['c_type']=$qry->result_array();
            $cat_array = array();
            foreach ($data['c_type'] as $key1 => $val) {
                 $idz = $val['id'];
                 array_push($cat_array, $idz);
              
            }
            $res = implode("','",$cat_array);
           // var_dump($res);exit();
            if($res){
               $qry_main="SELECT gt.parent,gts.title,gts.id FROM gp_pl_channel_partner_types gt INNER JOIN gp_pl_channel_partner_types gts on gts.id = gt.parent WHERE gt.id in('$res') and  gt.parent!='0' GROUP by gt.parent";
               $qry_main=$this->db->query($qry_main); 
               //echo $this->db->last_query();exit();
               if($qry_main){
                 $data['type']=$qry_main->result_array();
                
                 foreach ($data['type'] as $key => $value) {
                    $cp_id = $value['parent'];
                    $qry_sub="SELECT gt.title, gt.id,gtc.id con_id FROM `gp_pl_channel_partner_type_connection` gtc LEFT JOIN gp_pl_channel_partner_types gt ON
                    gtc.channel_partner_type_id = gt.id WHERE gtc.channel_partner_id = '$id' and gt.parent = '$cp_id'";
                    $qry_sub=$this->db->query($qry_sub);
                    
                    if($qry_sub){
                       $data['type'][$key]['sub']=$qry_sub->result_array();
                       
                    }  
                 }
               }
            }
           
        }
        else{
            $data['type']=array();
        }
       // echo json_encode($data);exit(); 
        return $data;
      }
    function add_new_product($image_file)
    {
        $this->db->trans_begin();
        
         $loginsession = $this->session->userdata('logged_in_admin');
         $userid=$loginsession['user_id'];
       
        $id = $this->input->post('pro_category');
        $sub_type = $this->input->post('sub_type');
        $data=array(
            'category_id'=>$id,
            'name'=>$this->input->post('pro_name'),
            'sub_cp_type_id' => $sub_type,
            'brand_id'=>$this->input->post('brands'),
            'description'=>$this->input->post('pro_description'),
            'model'=>$this->input->post('pro_model'),
            'actual_cost'=>$this->input->post('pro_actualcost'),
            'special_prize'=>$this->input->post('special_prize'),
            
            'channel_partner_id' => $userid
        );
        $this->db->insert('gp_product_details',$data);
        $insert_id = $this->db->insert_id();
        $images = array();
        foreach($image_file as $key=> $img)
        {
            
                $images[] = array(
                    'product_id' => $insert_id,
                    'p_image' => 'assets/admin/products/'.$img
                );
           
        }

            $qry = $this->db->insert_batch('gp_product_image',$images);
        
            $action = "added new product";
            $date = date("Y-m-d h:i:sa") ;
            
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
    function delete_product_image($id)
    {
        $this->db->trans_begin();
        
        $qry = "select * from gp_product_image pi where pi.id = $id";
        $qry = $this->db->query($qry);
        //echo $this->db->last_query();exit;
        if($qry->num_rows()>0)
        {
          $images =  $qry->result_array();
          foreach ($images as $key => $value) {
             unlink($value['p_image']);
            //unlink('assets/admin/products/'.$value['p_image']);
          }
        } 

        $this->db->where('id', $id);
        $qry = $this->db->delete('gp_product_image');
      
        if($this->db->trans_status()===false)
        {
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }
    }


    function get_all_product(){
        $qry="select p.*,pc.title from gp_product_details p
              left join gp_pl_channel_partner_types pc on pc.id=p.category_id
              where p.is_del='0' and type !='deal'";
        $qry=$this->db->query($qry);
        if($qry){
            $data['produ']=$qry->result_array();
        }
        else{
            $data['produ']=array();
        }
        return $data;

    }
    function get_all_product_by_id($id){
        $qry="select p.*,pc.title from gp_product_details p
              left join gp_pl_channel_partner_types pc on pc.id=p.category_id
              where p.is_del='0' and p.channel_partner_id='$id' and type !='deal'";
        $qry=$this->db->query($qry);
        //echo $this->db->last_query();exit();
        if($qry){
            $data['produ']=$qry->result_array();
        }
        else{
            $data['produ']=array();
        }
        return $data;

    }
    function get_product_byid($id){
        $qry="select p.* from gp_product_details p
              where p.id='$id'";
        $qry=$this->db->query($qry);
        if($qry){
            $data['produ']=$qry->row_array();
                $id = $data['produ']['id'];
                $qry_img = "select * from gp_product_image where product_id = ?";
                $qry_img = $this->db->query($qry_img,$id);
                 
                if($qry_img->num_rows()>0)
                {
                $data['produ']['images'] = $qry_img->result_array();
                } else{
                $data['produ']['images'] = array();
                }

                $cp_id = $data['produ']['channel_partner_id'];
                var_dump($cp_id);exit();
                $qry_cp="SELECT gcs.title, gcs.id FROM gp_cp_sub_category gcs 
                WHERE gcs.parent = '$cp_id' and gcs.is_del = '0'";
                $qry_cp=$this->db->query($qry_cp);
                if($qry_cp){
                    $data['produ']['types']=$qry_cp->result_array();
                }
                else{
                    $data['produ']['types']=array();
                }
        }
        else{
            $data['produ']=array();
        }
        return $data;

    }
    

    function edit_product_byid($image_file,$id){
        $this->db->trans_begin();
        $sub_type = $this->input->post('sub_type');
        $data=array(
            'category_id'=>$this->input->post('pro_category'),
            'name'=>$this->input->post('pro_name'),
            'sub_cp_type_id' => $sub_type,
            'quantity'=>$this->input->post('pro_quantity'),
            'description'=>$this->input->post('pro_description'),
            'model'=>$this->input->post('pro_model'),
            'actual_cost'=>$this->input->post('pro_actualcost'),
            'special_prize'=>$this->input->post('special_prize'),
           
            'cost'=>$this->input->post('pro_cost'),
        );
        $this->db->where('id',$id);
        $this->db->update('gp_product_details',$data);
         
        if($image_file[0][0] != 'Empty'){
          foreach($image_file as $img)
          {
              
              $imgs[]=array
              (
                  'product_id'=>$id,
                  'p_image'=>'assets/admin/products/'.$img,

              );
          }
          $this->db->insert_batch('gp_product_image',$imgs);
        }

         $action = "update product";
            $date = date("Y-m-d h:i:sa") ;
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


    function  get_select()
    {
        $qry="SELECT * FROM `gp_permission_module` WHERE module_content_div='1'";

        $qry=$this->db->query($qry);
        if($qry){
            $data['type']=$qry->result_array();
        }
        else{
            $data['type']=array();
        }
        return $data;
    }
    function add_new_module_ads($image_file,$id)
    {
        $this->db->trans_begin();
            $data=array('module_image'=>$image_file);
            $this->db->where('id', $id);
            $result=$this->db->update('gp_permission_module',$data) ;

            $action = "added new module ads ";
            $loginsession = $this->session->userdata('logged_in_admin');
            $userid=$loginsession['user_id'];
            $status = 0;
            $date = date("Y-m-d h:i:sa") ;
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


    function get_ads(){
        $qry="SELECT id, module_image,module_name FROM `gp_permission_module` WHERE module_content_div='1' and is_del='0'";

        $qry=$this->db->query($qry);
        if($qry){
            $data['ads']=$qry->result_array();
        }
        else{
            $data['ads']=array();
        }
        return $data;

    }
    function update_ads_byid($data, $id)
    {
        $this->db->trans_begin();
        $this->db->where('id',$id);
        $qry =  $this->db->update('gp_permission_module',$data);

        $date = date("Y-m-d h:i:sa") ;
        $action = "Updated Module Ads";
        $loginsession = $this->session->userdata('logged_in_admin');

        $userid=$loginsession['user_id'];
        $status = 0;

        activity_log($action,$userid,$status,$date);
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return $qry;
        }
    }
    function get_ads_by_id($id)
    {

        $qry = "select * from gp_permission_module where id = '$id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->row_array();
        } else{
            return array();
        }
    }

    function view_module_ads_by_id($id)
    {

        $qry = "SELECT id, module_image FROM `gp_permission_module` WHERE module_content_div='1' and id='$id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->row_array();
        } else{
            return array();
        }
    }

    function delete_module_ads_by_id($datas)
    {
        $this->db->trans_begin();
        $ids = $datas['chck_item_id'];
        foreach ($ids as $key => $id) {
            $results = array();
            $this->db->select('module_image')
                    ->from('gp_permission_module')
                    ->where('id',$id);

            $results['module_image'] = $this->db->get()->row()->module_image;
            if(isset($results['module_image'])){
                unlink($results['module_image']);
            }

            $data = array("module_image" => '','is_del'=>1);
            $this->db->where('id', $id);
            $qry = $this->db->update('gp_permission_module', $data);
        }

        $date = date("Y-m-d h:i:sa") ;
        $action = "delete module ads  ";
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
    function add_category(){
        $created_on = date('Y-m-d H:i:s');
        $this->db->trans_begin();
        $data=array(
            'parent_id'=>$this->input->post('category'),
            'title'=>$this->input->post('title'),
            'description'=>$this->input->post('description'),

            'created_on' => $created_on,
            'created_by' => 'admin',

        );
        $this->db->insert('gp_product_category',$data);


            $date = date("Y-m-d h:i:sa") ;
            $action = "add category ";
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



    function get_cpcategory(){
        $qry="SELECT * FROM `gp_product_category` WHERE parent_id='0' and is_del='0'";
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
        $qry="SELECT * FROM `gp_product_category` WHERE parent_id!='0' and is_del='0'";

        $qry=$this->db->query($qry);
        if($qry){
            $data['type']=$qry->result_array();
        }
        else{
            $data['type']=array();
        }
        return $data;

    }
    function delete_productbyid($id)
    {

        $this->db->trans_begin();
        $data = array('is_del' => 1);
        $this->db->where('id', $id);
        $qry = $this->db->update('gp_product_details', $data);
        $date = date("Y-m-d h:i:sa");

        $qry_img = "select * from gp_product_image pi where pi.product_id = '$id'";
        $qry_img = $this->db->query($qry_img);
        
        if($qry_img->num_rows()>0)
        {
          $images =  $qry_img->result_array();
          foreach ($images as $key => $value) {
             unlink($value['p_image']);
          }
        } 

        $this->db->where('product_id', $id);
        $this->db->delete('gp_product_image');

        $action = "Product has been deleted";
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
    
    function delete_categoryypebyid(){
        $id=$this->input->post('hiddentype');

        $data=array(
            'is_del'=>"1",

        );

        $qry = $this->db->where('id', $id);
        $qry = $this->db->update('gp_product_category', $data);

           $date = date("Y-m-d h:i:sa") ;
         $action = "delete category ";
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
        /// $qury;
        return $qry;
    }
    
    function get_product_view()
    {
       //  exit();
        $qry="SELECT * FROM gp_permission_module ";
        $query=$this->db->query($qry);
         //echo $this->db->last_query();
        
        if($query->num_rows()>0)
        {
            $data['module']=$query->result_array();

            foreach($data['module'] as $key=> $modules )
            {
                $moduleid= $modules['id'];
                $qry1="select * FROM  gp_pl_channel_partner_type_connection  where module_id='$moduleid'";

                $query1=$this->db->query($qry1);
               // echo $this->db->last_query();
                if($query1->num_rows()>0)
                {
                    $result= $query1->result_array();
                    $ch_id=$result[$key]['id'];

                    $qry3="select* from gp_product_details where cp_connection_id='$ch_id'";

                    $results=$this->db->query($qry3);
                    //echo $this->db->last_query();
                    if($results->num_rows()>0){

                        $data['module'][$key]['product']=$results->result_array();
                       // var_dump($data['module'][$key]['product']);exit();

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

}
?>