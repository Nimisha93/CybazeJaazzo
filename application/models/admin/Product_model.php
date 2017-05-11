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

    function add_new_product($image_file)
    {
        $this->db->trans_begin();



        $data=array(
            'category_id'=>$this->input->post('pro_category'),
            'name'=>$this->input->post('pro_name'),
            'quantity'=>$this->input->post('pro_quantity'),
            'description'=>$this->input->post('pro_description'),
            'model'=>$this->input->post('pro_model'),
            'actual_cost'=>$this->input->post('pro_actualcost'),
            'image'=>$image_file[0],
            'cost'=>$this->input->post('pro_cost')
        );
        $this->db->insert('gp_product_details',$data);



        $insert_id = $this->db->insert_id();
        $images = array();
        foreach($image_file as $key=> $img)
        {
            if($key != 0){
                $images[] = array(
                    'product_id' => $insert_id,
                    'p_image' => $img
                );
            }
        }

        $qry = $this->db->insert_batch('gp_product_image',$images);
         $action = "added new product";
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


    function get_all_product(){
        $qry="select p.*,pc.title from gp_product_details p
              left join gp_product_category pc on pc.id=p.category_id
              where p.is_del='0'";
        $qry=$this->db->query($qry);
        if($qry){
            $data['produ']=$qry->result_array();
        }
        else{
            $data['produ']=array();
        }
        return $data;

    }

    function get_product_byid($id){
        $qry="select p.*,pc.title from gp_product_details p
              left join gp_product_category pc on pc.id=p.category_id
              where p.id='$id'";
        $qry=$this->db->query($qry);
        if($qry){
            $data['produ']=$qry->row_array();
        }
        else{
            $data['produ']=array();
        }
        return $data;

    }

    function edit_product_byid($image_file,$id){
        $this->db->trans_begin();



        $data=array(
            'category_id'=>$this->input->post('pro_category'),
            'name'=>$this->input->post('pro_name'),
            'quantity'=>$this->input->post('pro_quantity'),
            'description'=>$this->input->post('pro_description'),
            'model'=>$this->input->post('pro_model'),
            'actual_cost'=>$this->input->post('pro_actualcost'),
            'image'=>$image_file,
            'cost'=>$this->input->post('pro_cost'),
        );
        $this->db->where('id',$id);
        $this->db->update('gp_product_details',$data);

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

        $data=array
        (
            'module_image'=>$image_file
        );
//        $data = array(
//            'title' => $title,
//            'name' => $name,
//            'date' => $date
//        );

        $this->db->where('id', $id);
        /// $this->db->update('mytable', $data);

        $result=$this->db->update('gp_permission_module',$data) ;

            $action = "added new module ads ";
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status);
        if($result)
        {
            return true;
        }
        else
        {
            return false;
        }
    }


    function get_ads(){
        $qry="SELECT id, module_image FROM `gp_permission_module` WHERE module_content_div='1' and is_del='0'";

        $qry=$this->db->query($qry);
        if($qry){
            $data['ads']=$qry->result_array();
        }
        else{
            $data['ads']=array();
        }
        return $data;

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

    function delete_module_ads_by_id($id)
    {


        $this->db->trans_begin();
        $data = array('is_del' => 1);
        $this->db->where('id', $id);
        $qry = $this->db->update('gp_permission_module', $data);
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

}
?>