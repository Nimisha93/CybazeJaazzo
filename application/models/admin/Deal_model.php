<?php
Class Deal_model extends CI_Model{

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
   
    function get_coupon(){
        $session_array = $this->session->userdata('logged_in_cp');
        $uid = $session_array['user_id'];
        $qry="SELECT nc.name, p.name deal_name, p.special_prize, p.actual_cost, c.amount,c.coupon_code,c.is_paid FROM `coupon` c LEFT JOIN gp_normal_customer nc on c.user_id = nc.id left join gp_deal_channel_partner_con pc on c.deal_con = pc.id left join gp_product_details p on pc.product_id = p.id WHERE pc.channel_partner_id = '$uid'";
        $qry=$this->db->query($qry);
        //echo $this->db->last_query();exit();
        if($qry){
            
            $data=$qry->result_array();
        }
        else{
            
            $data=array();
        }
        
        return $data;
    }
    
    function add_new_deal_settings()
    {
        $this->db->trans_begin();

        $loginsession = $this->session->userdata('logged_in_cp');

        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $cheque_date = date('Y-m-d H:i',strtotime($this->input->post('cheque_date')));
        $mode= $this->input->post('payment_mode');
        $is_paid = ($mode=='online'||empty($mode)) ? '1' : '0';
        $cr = date("Y-m-d h:i:sa");
        $amount = $this->input->post('amount');
        $data2 = array(
            'channel_partner_id' => $userid,
            'deal_id' => $this->input->post('hidden_id'),
            'amount'=>$amount,
            'cheque_number'=>$this->input->post('cheque_number'),
            'bank_name'=>$this->input->post('bank'),
            'cheque_date'=>$cheque_date,
            'payment_mode'=>$mode,
            'is_paid' => $is_paid,
            'purchased_on' => $cr
        );
        $this->db->insert('gp_deal_channel_partner_con',$data2);
        $insert_id = $this->db->insert_id();
        $action = "New deal has been purchased";
        $date = date("Y-m-d h:i:sa") ;
        $status = 0;
        if(!empty($amount)&&($is_paid==1)){
            $fy_year = get_current_financial_year();
            $fy_id = $fy_year['id'];  
            $no =get_number();
            $data = array(
                'entrytype_id'=>4,
                '_type'=>'DEAL_PURCHASE',
                'type_id'=>$insert_id,
                'number'=>$no,
                'fy_id' =>$fy_id,
                'date'=>date('Y-m-d'),
                'dr_total'=>$amount,
                'cr_total'=>$amount,
            );
            $this->db->insert('erp_ac_entries',$data);
            $entry_id = $this->db->insert_id();
            $type = 'CHANNEL_PARTNER';
            $ledger_payment_cr = getLedgerId($lgid,$type);
            if($mode=='cash')
                $ledger_payment_dr = 32;
            else
                $ledger_payment_dr = 35;
            $entry_items_cr = array(
                'entry_id' => $entry_id,
                'ledger_id' => $ledger_payment_cr,
                'amount' => $amount,
                'dc' => 'Cr',
                'fy_id' =>$fy_id,
                'created_date' => date('Y-m-d')
            );
             
            $entry_items_dr = array(
                'entry_id' => $entry_id,
                'ledger_id' => $ledger_payment_dr,
                'amount' => $amount,
                'dc' => 'Dr',
                'fy_id' =>$fy_id,
                'created_date' => date('Y-m-d')
            );
            $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);
            $entry_dr = $this->db->insert('erp_ac_entryitems', $entry_items_dr);
        }
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
    function get_cp_types($id){
        $qry="select pc.title,pc.description,pc.id from gp_pl_channel_partner_types pc inner join gp_pl_channel_partner_type_connection gpc on gpc.channel_partner_type_id=pc.id
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
   
    function new_deal_settings()
    {
        $this->db->trans_begin();

        $loginsession = $this->session->userdata('logged_in_admin');

        $userid=$loginsession['user_id'];

        $data=array(
            'name'=>$this->input->post('pro_name'),
            'description'=>$this->input->post('pro_description'),
            'amount'=>$this->input->post('amount'),
            'duration' => $this->input->post('duration')
        );
        $this->db->insert('gp_deal_settings',$data);

        $action = "added new deal";
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
    function get_all_deal_by_cp_id($id){
        $qry="select p.*,pc.title from gp_product_details p left join gp_deal_channel_partner_con d on p.id = d.product_id LEFT JOIN gp_pl_channel_partner_types pc on pc.id=p.category_id where p.is_del='0' and p.channel_partner_id='$id' and type !='0' and d.status = '1' order by p.id DESC";
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


        function get_all_deal_by_cp_id_count($search,$id){



         if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (p.name LIKE '%$keyword%' OR p.description LIKE '%$keyword%' OR p.model LIKE '%$keyword%' OR p.actual_cost LIKE '%$keyword%' OR p.special_prize LIKE '%$keyword%') AND p.id IS NOT NULL ";
        }else{
            $where = '';
        }

            
        $qry="select p.*,pc.title from gp_product_details p left join gp_deal_channel_partner_con d on p.id = d.product_id LEFT JOIN gp_pl_channel_partner_types pc on pc.id=p.category_id where p.is_del='0' and p.channel_partner_id='$id' and type !='0' and d.status = '1' ".$where."order by p.id DESC";
        $qry=$this->db->query($qry);
       //echo $this->db->last_query();exit();
              if($qry->num_rows()>0)
        {
            return $qry->num_rows();
        }else{
            return false;
        }

    }

        function get_all_deal_by_cp_id_page($search,$limit=NULL,$start=NULL,$id){



 if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (p.name LIKE '%$keyword%' OR p.description LIKE '%$keyword%' OR p.model LIKE '%$keyword%' OR p.actual_cost LIKE '%$keyword%' OR p.special_prize LIKE '%$keyword%') AND p.id IS NOT NULL ";
        }else{
            $where = '';
        }

if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }




        $qry="select p.*,pc.title from gp_product_details p left join gp_deal_channel_partner_con d on p.id = d.product_id LEFT JOIN gp_pl_channel_partner_types pc on pc.id=p.category_id where p.is_del='0' and p.channel_partner_id='$id' and type !='0' and d.status = '1' ".$where." order by p.id DESC".$pg;
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
    
//'type' => 'deal'
    function add_new_deal($image_file)
    {
        $this->db->trans_begin();
        
        $loginsession = $this->session->userdata('logged_in_cp');

        $userid=$loginsession['user_id'];
        $pro_category = $this->input->post('pro_category');
        list($id, $con_id) = explode("-",$pro_category,2);
        $sub_type = $this->input->post('sub_type');
        $date = date("Y-m-d h:i:sa") ;
       // var_dump($sub_type);exit;
        $data=array(
            'category_id'=>$id,
            'cp_connection_id' => $con_id,
            'name'=>$this->input->post('pro_name'),
            'brand_id'=>$this->input->post('brand'),
            'sub_cp_type_id' => $sub_type,
            'quantity'=>$this->input->post('pro_quantity'),
            'description'=>$this->input->post('pro_description'),
            'model'=>$this->input->post('pro_model'),
            'actual_cost'=>$this->input->post('pro_actualcost'),
            'special_prize'=>$this->input->post('special_prize'),
            'type' => $this->input->post('deal_id'),
            
            'channel_partner_id' => $userid
        );
        $this->db->insert('gp_product_details',$data);
        $insert_id = $this->db->insert_id();
        $duration = $this->input->post('duration');
        $date1 = new DateTime();
        //var_dump($date1);
        $date1->modify("+$duration hours");
        $date2 = $date1->format("Y-m-d H:i:s");
        $c_date = date('Y-m-d',strtotime($this->input->post('coupon_validity')));
        //var_dump($date2);exit();
        $deal=array(
            'product_id'=>$insert_id,
            'coupon_percentage' => $this->input->post('coupon'),
            'status' => '1',
            'end_date' => $date2,
            'coupon_validity' => $c_date
        );
        //var_dump($deal);exit();
        $array = array('id' => $this->input->post('deal_id'));
        $this->db->where($array);
        $this->db->update('gp_deal_channel_partner_con',$deal);
      // echo $this->db->last_query();exit();
        $images = array();
        foreach($image_file as $key=> $img)
        {
            
                $images[] = array(
                    'product_id' => $insert_id,
                    'p_image' => 'assets/admin/products/'.$img
                );
           
        }

        $qry = $this->db->insert_batch('gp_product_image',$images);
    
        $action = "added new deal";
        
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
    function get_all_deal_by_id($id){
        $sql = "select count(id) as c from gp_deal_channel_partner_con where channel_partner_id = '$id'";
        $ids = $this->db->query($sql);
        $ids = $ids->row_array();
        $limit = $ids['c'];
        $qry="select p.*,pc.title from gp_product_details p
              left join gp_pl_channel_partner_types pc on pc.id=p.category_id
              where p.is_del='0' and p.channel_partner_id='$id' and type!='0' order by p.id desc limit $limit";
        $qry=$this->db->query($qry);
        $qry1="select count(p.id) as c from gp_product_details p
              left join gp_pl_channel_partner_types pc on pc.id=p.category_id
              where p.is_del='0' and p.channel_partner_id='$id' and type!='0' order by p.id desc limit $limit";
        $qry1=$this->db->query($qry1);
        $qry1=$qry1->row_array();
        $l = $qry1['c']-$limit;
        //var_dump($l);exit;
        $qry2="select p.*,pc.title from gp_product_details p
              left join gp_pl_channel_partner_types pc on pc.id=p.category_id
              where p.is_del='0' and p.channel_partner_id='$id' and type!='0' order by p.id asc limit $l";
        $qry2=$this->db->query($qry2);
       // echo $this->db->last_query();
        if($qry){
            $data['produ']=$qry->result_array();
            $data['na_deal']=$qry2->result_array();
        }
        else{
            $data['produ']=array();
            $data['na_deal']=array();
        }
        return $data;

    }
    function get_deal_byid($id){
        $qry="select p.*,c.coupon_percentage,date_format(c.coupon_validity,'%d-%b-Y') as coupon_validity from gp_product_details p left join gp_deal_channel_partner_con c on p.type = c.id 
              where p.id='$id' and type != '0'";
        $qry=$this->db->query($qry);
        //echo $this->db->last_query();
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

                $cp_type_id = $data['produ']['category_id'];
                $tp = $this->get_cp_sub_types($cp_type_id);
                //echo json_encode($tp);exit();
                if($tp){
                    $data['produ']['types']=$tp['type'];
                    //echo json_encode($data['produ']['types']);exit();
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
    function get_cp_sub_types($id){
       
        
        $qry = "SELECT gt.title, gt.id FROM gp_pl_channel_partner_types gt WHERE gt.parent = '$id' ";
        $qry=$this->db->query($qry);
       
        if($qry){
            $data['type']=$qry->result_array();
        }
        else{
            $data['type']=array();
        }
        return $data;
    }

     function edit_deal_byid($image_file,$id){
        $this->db->trans_begin();
        $sub_type = $this->input->post('sub_type');
        $data=array(
            'category_id'=>$this->input->post('pro_category'),
            'name'=>$this->input->post('pro_name'),
            'sub_cp_type_id' => $sub_type,
            'quantity'=>$this->input->post('pro_quantity'),
            'brand_id'=>$this->input->post('brand'),
            'description'=>$this->input->post('pro_description'),
            'model'=>$this->input->post('pro_model'),
            'actual_cost'=>$this->input->post('pro_actualcost'),
            'special_prize'=>$this->input->post('special_prize'),  
           
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
        $c_date = date('Y-m-d',strtotime($this->input->post('coupon_validity')));
        $deal=array(
            'coupon_percentage' => $this->input->post('coupon'),
            'coupon_validity' => $c_date
        );
        $array = array('id' => $this->input->post('deal_id'));
        $this->db->where($array);
        $this->db->update('gp_deal_channel_partner_con',$deal);

            $action = "update product";
            $date = date("Y-m-d h:i:sa") ;
            $loginsession = $this->session->userdata('logged_in_cp');

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

        $this->db->where('id', $id);

        $result=$this->db->update('gp_permission_module',$data) ;

        $action = "added new module ads ";
        $loginsession = $this->session->userdata('logged_in_admin');

        $userid=$loginsession['user_id'];
        $status = 0;
        $date = date("Y-m-d h:i:sa") ;
        activity_log($action,$userid,$status,$date);
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

    function delete_dealbyid($id)
    {


        $this->db->trans_begin();
        $data = array('is_del' => 1);
        $this->db->where('id', $id);
        $qry = $this->db->update('gp_product_details', $data);
        $date = date("Y-m-d h:i:sa") ;

        $action = "Deal has been deleted";
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
?><?php
/**
 * Created by JetBrains PhpStorm.
 * User: Android Developer
 * Date: 5/26/17
 * Time: 10:10 AM
 * To change this template use File | Settings | File Templates.
 */