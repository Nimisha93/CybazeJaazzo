<?php
Class Channelpartner_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();
    }
    function get_refer_cp($id){
        $qry="SELECT cp.*,cus.name clubname from gp_pl_channel_partner cp
        left join gp_login_table login on login.id = cp.club_mem_id
        left join gp_normal_customer cus on login.user_id = cus.id
        where cp.id='$id'";
        $qry=$this->db->query($qry);
     
        if($qry){
            
            $data=$qry->row_array();
        }
        else{
            
            $data=array();
        }
        
        return $data;
    }
    public function get_transaction_amount($login_id)
    {
        $sql1 = $this->db->query("select sum(t.transaction_amount) as total from gp_cp_transaction t WHERE t.status = 1 and t.is_del = 0 and t._to = '$login_id'");
        if($sql1->num_rows()>0){
             $sql_res1 = $sql1->row();
             $data['toCp'] = $sql_res1->total;
        }else{
             $data['toCp'] = 0;
        }
        $sql2 = $this->db->query("select sum(t.transaction_amount) as total from gp_cp_transaction t WHERE t.status = 1 and t.is_del = 0 and t.from = '$login_id'");
        if($sql2->num_rows()>0){
             $sql_res2 = $sql2->row();
             $data['toAdmin'] = $sql_res2->total;
        }else{
             $data['toAdmin'] = 0;
        }
        return $data;
    }
    function get_dashboard_details($userid)
    {
        $qry = "select *
                from gp_purchase_bill_notification n where n.channel_partner_id = '$userid' and status = '1' group by n.login_id";
        $qry = $this->db->query($qry);
        $data['customers'] = $qry->num_rows();
        $qry2 = $this->db->query("select round(sum(n.bill_total),2) as bill_total,round(sum(n.wallet_total),2) as wallet_total from gp_purchase_bill_notification n where n.channel_partner_id = '$userid' and status = '1'");
        if($qry2->num_rows()>0)
        {
            $data['details'] =  $qry2->row();
        } else{
            $data['details'] = array();
        }


        return $data;  
    }
    function get_all_purchasenotification($loginuser){
       
        $qry = "select noty.id as noty_id,noty.wallet_total,noty.bill_total,noty.channel_partner_id, noty.wallet_total, noty.bill_total, DATE_FORMAT(noty.purchased_on, '%Y-%m-%d') as purchased, cus.email, n.name, n.phone from gp_purchase_bill_notification noty left join gp_pl_channel_partner con on con.id = noty.channel_partner_id left join gp_login_table cus on cus.id = noty.login_id LEFT JOIN gp_normal_customer n on n.id = cus.user_id where con.id = '$loginuser' and noty.`status` = 0 and noty.type = 'indirect' order by noty.id desc";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data = $qry->result_array();
        } else
        {
            $data =array();
        }

        return $data;
    }


  function get_all_purchasenotification_count($search,$loginuser){



    if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (noty.wallet_total LIKE '%$keyword%' OR noty.bill_total LIKE '%$keyword%' OR noty.purchased_on LIKE '%$keyword%'  OR cus.email LIKE '%$keyword%' OR n.name LIKE '%$keyword%' OR n.phone LIKE '%$keyword%') AND noty.id IS NOT NULL ";
        }else{
            $where = '';
        }
       
        $qry = "select noty.id as noty_id,noty.wallet_total,noty.bill_total,noty.channel_partner_id, noty.wallet_total, noty.bill_total, DATE_FORMAT(noty.purchased_on, '%Y-%m-%d') as purchased, cus.email, n.name, n.phone from gp_purchase_bill_notification noty left join gp_pl_channel_partner con on con.id = noty.channel_partner_id left join gp_login_table cus on cus.id = noty.login_id LEFT JOIN gp_normal_customer n on n.id = cus.user_id where con.id = '$loginuser' and noty.`status` = 0 and noty.type = 'indirect' ".$where." ";
        $qry = $this->db->query($qry);
          if($qry->num_rows()>0)
        {
            return $qry->num_rows();
        }else{
            return false;
        }

    }


    function get_all_purchasenotification_page($search,$limit=NULL,$start=NULL,$loginuser)
    {


 if(!empty($search))
 {
            $keyword = "%{$search}%";
           $where = " and (noty.wallet_total LIKE '%$keyword%' OR noty.bill_total LIKE '%$keyword%' OR noty.purchased_on LIKE '%$keyword%'  OR cus.email LIKE '%$keyword%' OR n.name LIKE '%$keyword%' OR n.phone LIKE '%$keyword%') AND noty.id IS NOT NULL ";
        }else
        {
            $where = '';
        }
           if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else
        {
            $pg = "";
        }


        $qry = "select noty.id as noty_id,noty.wallet_total,noty.bill_total,noty.channel_partner_id, noty.wallet_total, noty.bill_total, DATE_FORMAT(noty.purchased_on, '%Y-%m-%d') as purchased, cus.email, n.name, n.phone 
        from gp_purchase_bill_notification noty 
        left join gp_pl_channel_partner con on con.id = noty.channel_partner_id 
        left join gp_login_table cus on cus.id = noty.login_id 
        LEFT JOIN gp_normal_customer n on n.id = cus.user_id where con.id = '$loginuser' and noty.`status` = 0 and noty.type = 'indirect' ".$where." order by noty.id desc ".$pg;
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data = $qry->result_array();
        } else
        {
            $data =array();
        }

        return $data;
    }

     function get_reward_categories($id){
        $qry="SELECT gpc.category_title,gpc.id,gpc.percentage from gp_channel_con_cat_commision gpc WHERE gpc.cp_id = '$id'";
        $qry=$this->db->query($qry);
     
        if($qry){
            
            $data=$qry->result_array();
        }
        else{
            
            $data=array();
        }
        
        return $data;
    }
    function get_cp_commission_status($id){
        $qry="SELECT gpc.id from gp_channel_con_cat_commision gpc WHERE gpc.cp_id = '$id'";
        $qry=$this->db->query($qry);
        if($qry->num_rows()>0){
            $data=false;
        }
        else{   
            $data=true;
        }
        return $data;
    }
    function get_cp_commission($id){
        $qry="SELECT gpc.category_title, gpc.cp_id,gpc.percentage,gpc.id,(select u.new_percentage from cp_commission_updations u WHERE u.com_id = gpc.id and u.status = 1) as requested_commission from gp_channel_con_cat_commision gpc WHERE gpc.cp_id = '$id'";
        $qry=$this->db->query($qry);
        if($qry){
            $data=$qry->result_array();
        }
        else{   
            $data=array();
        }
        return $data;
    }

     function get_cp_commission_count($id,$search){

        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (gpc.category_title LIKE '%$keyword%' OR gpc.cp_id LIKE '%$keyword%' OR gpc.percentage LIKE '%$keyword%' ) AND id IS NOT NULL ";
        }else{
            $where = '';
        }


        $qry="SELECT gpc.category_title, gpc.cp_id,gpc.percentage,gpc.id,(select u.new_percentage from cp_commission_updations u WHERE u.com_id = gpc.id and u.status = 1) as requested_commission from gp_channel_con_cat_commision gpc WHERE gpc.cp_id = '$id' ".$where."";
        $qry=$this->db->query($qry);
     
        if($qry->num_rows()>0)
        {
            return $qry->num_rows();
        }else{
            return false;
        }
    }

    function get_cp_commission_all($search,$limit=NULL,$start=NULL,$id)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (gpc.category_title LIKE '%$keyword%' OR gpc.cp_id LIKE '%$keyword%' OR gpc.percentage LIKE '%$keyword%' ) AND id IS NOT NULL ";
        }else{
            $where = '';
        }
           if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }


        $qry="SELECT gpc.category_title, gpc.cp_id,gpc.percentage,gpc.id,(select u.new_percentage from cp_commission_updations u WHERE u.com_id = gpc.id and u.status = 1) as requested_commission from gp_channel_con_cat_commision gpc WHERE gpc.cp_id = '$id' ".$where."".$pg;
        $qry=$this->db->query($qry);
     
        if($qry){
            
            $data=$qry->result_array();
        }
        else{
            
            $data=array();
        }
        
        return $data;
    }
    function new_commission(){
        $id = $this->input->post('hidden_id');
        $new_commission = $this->input->post('new_commission');
        $this->db->trans_begin();
        if(!empty($new_commission))
        { 

            $data = array(
                'com_id' => $id,
                'new_percentage' => $new_commission,
                'status' => 1
            );   
            $this->db->query("UPDATE `cp_commission_updations` SET `status`= '0' WHERE com_id = '$id'");
            $this->db->insert('cp_commission_updations',$data);
        }
        $up = array(
            'category_title' => $this->input->post('new_title')
        );
        $this->db->where('id',$id);
        $this->db->update('gp_channel_con_cat_commision',$up);
        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
    function set_new_cp_commission(){
    
        $this->db->trans_begin();
        $category = $this->input->post('category');
        $commission = $this->input->post('commission');
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        foreach($category as $key => $type){
            if(!empty($commission[$key])){
                $data[]=array(  
                    'cp_id'=>$userid,
                    'category_title'=>$category[$key],
                    'percentage' => $commission[$key]
                );
            }
        }
        $this->db->insert_batch('gp_channel_con_cat_commision',$data);
        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
    function get_cp_type($id){
   
        $qry="SELECT gt.title, gt.id,gtc.id con_id FROM `gp_pl_channel_partner_type_connection` gtc LEFT JOIN gp_pl_channel_partner_types gt ON
         gtc.channel_partner_type_id = gt.id WHERE gtc.channel_partner_id = '$id' and gt.parent!='0'";
        $qry=$this->db->query($qry);
     
        if($qry){
            $data['c_type']=$qry->result_array();
            $cat_array = array();
            foreach ($data['c_type'] as $key1 => $val) {
                 $idz = $val['id'];
                 array_push($cat_array, $idz);
              
            }
            $res = implode("','",$cat_array);
        
            if($res){
               $qry_main="SELECT gt.parent,gts.title,gts.id FROM gp_pl_channel_partner_types gt INNER JOIN gp_pl_channel_partner_types gts on gts.id = gt.parent WHERE gt.id in('$res') and  gt.parent!='0' GROUP by gt.parent";
               $qry_main=$this->db->query($qry_main); 
               
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
        $qryz="SELECT gpc.category_title,gpc.id,gpc.percentage from gp_channel_con_cat_commision gpc WHERE gpc.cp_id = '$id'";
        $qryz=$this->db->query($qryz);
     
        if($qryz){
            
            $data['reward']=$qryz->result_array();
        }
        else{
            
            $data['reward']=array();
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
    function add_new_product($image_file)
    {
        $this->db->trans_begin();
        
        $loginsession = $this->session->userdata('logged_in_cp');
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
            'reward_cat_id' =>$this->input->post('reward_category'),
            'channel_partner_id' => $userid
        );
        $this->db->insert('gp_product_details',$data);
        $insert_id = $this->db->insert_id();
        $images = array();
        // if(!empty($image_file))
        // {
        foreach($image_file as $key=> $img)
        {
            
                $images[] = array(
                    'product_id' => $insert_id,
                    'p_image' => 'assets/admin/products/'.$img
                );
           
        }

            $qry = $this->db->insert_batch('gp_product_image',$images);
            // }
        
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
        $loginsession = $this->session->userdata('logged_in_cp');

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
    function get_deal_info(){

        $qry = "select * from gp_deal_settings order by id DESC";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $child = $qry->result_array();

        } else{
            $child = array();
        }
        return $child;
    }
     function get_cpWallet($id){
        $data=array();
        $query="SELECT bn.id,bn.login_id,nc.name,truncate(bn.wallet_total,2) as wallet_total,truncate(bn.bill_total,2) as bill_total,bn.purchased_on as purchase_date, DATE_FORMAT(bn.purchased_on,'%d-%b-%Y')as purchsed_on,bn.channel_partner_id
         ,truncate(bn.total_commission,2) as total_commission FROM gp_purchase_bill_notification bn LEFT JOIN gp_login_table log ON log.id=bn.login_id 
            LEFT JOIN gp_normal_customer nc ON log.user_id=nc.id WHERE bn.channel_partner_id = '$id' and bn.status = '1' order by bn.id desc";
        $result=$this->db->query($query);
        //echo $this->db->last_query();exit;
        if($result->num_rows()>0)
        {
            $res1 = $result->result_array();
            foreach ($res1 as $key => $value) {
               
                $purchase_date = $value['purchase_date'];
                $login_id = $value['login_id'];
                $noty_id = $value['id'];
  
                $value['reward']=$this->get_rewards($login_id,$noty_id);
                array_push($data,$value);
            }
        }
    
        else{
            
            $data=array();
        }
        
        return $data;
    }
    function get_rewards($login_id,$id)
    {
       
        $sql3 = "SELECT change_value FROM `gp_wallet_activity`  
                WHERE user_id='$login_id' and  `gp_wallet_activity`.`wallet_type_id`='2' and purchase_bill_notification_id='$id' and type='GAIN' 
                 ORDER BY `id` DESC";
        $sql3=$this->db->query($sql3);

        if($sql3->num_rows()>0)
        {
            $res3 = $sql3->row_array();
            return $res3['change_value'];
        }
    }
    function get_purchase_otp($otp){
        $purcid=$this->input->post('hiddentype_id');
        $mobile=$this->input->post('mobile');

        $data=array(
            'otp'=>$otp
        );
        $this->db->where('id',$purcid);
        $this->db->update('gp_purchase_bill_notification',$data);
        // echo $this->db->last_query();exit;
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return $purcid;
        }
    }
    function purchase_approval_by_otp(){
        $purcid=$this->input->post('hiddenotp');
        $otp=$this->input->post('purchase_otp');
        $qry="select * from gp_purchase_bill_notification where otp='$otp' and id='$purcid'";
        $res=$this->db->query($qry);
       
        if($res->num_rows()>0){
           // $update = $this->purchase_otp_confirmation($purcid);
           // if($update)
           // {
           //      return $res->row_array();
           // } else{
           //      return false;
           // }
            return $res->row_array();
            
        }
        else{
            return false;
        }
    }

    function purchase_otp_confirmation($purcid){
        $data=array(
            'status'=>"1",
        );
        $this->db->where('id',$purcid);
        $query=$this->db->update('gp_purchase_bill_notification',$data);
        return $query;
    }
    function updatewallet($noty_id, $total_discount, $total_amount){
        $this->db->trans_begin();
        $com = get_commission();
        $company_per =  $com['company_commission']; $customer_per = $com['customer_commission'];
        $discount = ($total_discount * $customer_per) / 100;
        $company = ($total_discount * $company_per) / 100;
        $have_coupon = $this->input->post('have_coupon');
        if($have_coupon=='Yes'){
            $coupon_id = $this->input->post('coupon_id');
            $this->db->set('status', 'USED');
            $this->db->where('id', $coupon_id);
            $this->db->update('coupon');
        }else{
            $coupon_id = ""; 
        }
        $data = array(
                    'bill_total' => $total_amount,
                    'total_commission' => $total_discount,
                    'status' => '1',
                    'coupon_id' => $coupon_id
                    );
        $qry = "select * from gp_purchase_bill_notification where id ='$noty_id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $purchase = $qry->row_array();
            $cus_login_id = $purchase['login_id'];
            $wallet_transfered = $purchase['wallet_total'];
            $this->db->where('id', $noty_id);
            $upqry = $this->db->update('gp_purchase_bill_notification', $data);
            $this->db->set('total_value', 'total_value + ' . (float) $discount, FALSE);
            $this->db->where('user_id', $cus_login_id);
            $this->db->where('wallet_type_id', 2);
            $this->db->update('gp_wallet_values');
            if($this->db->affected_rows() > 0){
                $this->db->where('user_id', $cus_login_id);
                $this->db->where('wallet_type_id', 2);
                $wal_id =  $this->db->get('gp_wallet_values')->row()->id;
            }else{
                $wal_id ='';
            } 
            // /*customer reward entry (user(Dr)-jaazzo(Cr))*/
            // $entry_id1 = add_acc_entry($noty_id,$discount);
            // if($entry_id1){
            //     $ledger_payment_cr1 = 26;
            //     $ledger_payment_dr1 = getLedgerId($cus_login_id,'CUSTOMER');
                
            //     add_acc_entry_item($entry_id1,$ledger_payment_cr1,'Cr',$discount);
            //     add_acc_entry_item($entry_id1,$ledger_payment_dr1,'Dr',$discount);
            // }
           // echo $this->db->last_query();exit;
            $wal_activityss = array(
                'wallet_type_id' => 2,
                'wallet_val_id' => $wal_id,
                'user_id' => $cus_login_id,
                'purchase_bill_notification_id'=>$noty_id,
                'change_value' => $discount,
                'type'=>'GAIN',
                'date_modified' => date('Y-m-d h:i:s'),
                'description' => 'Reward when item purchased'
                );
            $this->db->insert('gp_wallet_activity', $wal_activityss);
            //    echo $this->db->last_query();exit;
           
            /*customer wallet entry */
            //$entry_id2 = add_acc_entry($noty_id,$wallet_transfered);
            
                $cp_id = $purchase['channel_partner_id'];
                $getcp_qry = "select
                                l.id as lg_id
                                from
                                 gp_login_table l 
                                where l.user_id = '$cp_id' AND l.type='Channel_partner'";
                $getcp_qry = $this->db->query($getcp_qry);
                if($getcp_qry->num_rows()>0)
                {
                    $cpdetails = $getcp_qry->row_array();
                    $cplg_id = $cpdetails['lg_id'];

                    $this->db->set('total_value', 'total_value + ' . (float) $wallet_transfered, FALSE);
                    $this->db->where('user_id', $cplg_id);
                    $this->db->where('wallet_type_id', 4);
                    $this->db->update('gp_wallet_values'); 
                    //echo $this->db->last_query();
                    $wal_val_id1=get_wallet_val_id($cplg_id,4);
                    $wal_activitys = array(
                        'wallet_type_id' => 4,
                        'wallet_val_id' => $wal_val_id1,
                        'user_id' => $cplg_id,
                        'purchase_bill_notification_id'=>$noty_id,
                        'change_value' => $wallet_transfered,
                        'type'=>'GAIN',
                        'date_modified' => date('Y-m-d h:i:s'),
                        'description' => 'One user transfered wallet Amount for a purchase'
                      );
                    $this->db->insert('gp_wallet_activity', $wal_activitys);
                    //Entry item - jaazzo Dr
                    // if($entry_id2){
                    //     $ledger_payment_dr2 = 32;  
                    //     add_acc_entry_item($entry_id2,$ledger_payment_dr2,'Dr',$wallet_transfered);
                    // }
                }else{
                    $cpdetails = array();
                }
                     
            // End insert money into channel partner wallet 


            //update reduce  logged in  customer  walletes when using purchases
            $reduce_qry = "select * from gp_purchase_bill_noty_wallet_items itm where itm.bill_notification_id ='$noty_id'";
            $reduce_qry = $this->db->query($reduce_qry);
            if($reduce_qry->num_rows()>0)
            {

                $result = $reduce_qry->result_array();
                foreach ($result as $key => $res) {
                    $wal_val = $res['wallet_value'];
                    if($wal_val){
                  $wal_id = $res['wallet_id'];
                  $wal_type_id =  get_wallettype_by_id($wal_id);
                $this->db->set('total_value', 'total_value - ' . (float) $wal_val, FALSE);
                $this->db->where('id', $wal_id);
                $this->db->update('gp_wallet_values'); 
                //echo $this->db->last_query();
                $wal_activitysss = array(
                'wallet_val_id' => $wal_id,
                'wallet_type_id' =>$wal_type_id,
                'change_value' => $wal_val,
                'user_id' => $cus_login_id,
                'purchase_bill_notification_id'=>$noty_id,
                'type'=>'LOSS',
                'date_modified' => date('Y-m-d h:i:s'),
                'description' => 'Reduced when item purchased'
                );
                $this->db->insert('gp_wallet_activity', $wal_activitysss);
                    }
                }
                //Entry Item - Customer Cr
                // if($entry_id2){
                //     $ledger_payment_cr2 = getLedgerId($cus_login_id,'CUSTOMER'); 
                //     add_acc_entry_item($entry_id2,$ledger_payment_cr2,'Cr',$wallet_transfered);
                // }
            }else{
                $result = array();
            }  
                $pooling_commision = $company; 
                // Pooling
                $grp_sttgs = $this->get_pooling_settings();
//var_dump($grp_sttgs);exit;
                $tot_percentage =0;$discnt =0;
                foreach ($grp_sttgs as $key => $sttgs)
                {
                        $perc_each_grp=0;
                   //if($key==1){
                        //$flag = false;
                        $grp_id = $sttgs['id'];
                        $related_to = $sttgs['related_to'];
                        $llogin_id = ($related_to=='CHANNEL_PARTNER')?$cplg_id:$cus_login_id;
                        //var_dump($cus_login_id);//exit();
                        $tot_percentage +=$sttgs['percentage'];
                        $perc_each_grp = ($pooling_commision * $sttgs['percentage'])/100;
                        $sel_gp_memb = "select * from gp_pl_pool_members_settings gp_stg left join gp_pl_sales_designation_type sdt ON gp_stg.designation_type_id=sdt.id where gp_stg.pool_settings_id = '$grp_id'  order by sdt.sort_order ASC";
                        $sel_gp_memb = $this->db->query($sel_gp_memb);
                        if($sel_gp_memb && $sel_gp_memb->num_rows()> 0)
                        {
                            $pool_eff_membs = $sel_gp_memb->result_array();
                            $new_id = 1;
                            $paid_amount =0 ;
                            $balance1 =0 ;
                            $balance2 =0 ;
                            $stype='';
                            $typee='';
                           // var_dump($pool_eff_membs);exit;
                            foreach ($pool_eff_membs as $key1 => $pool_eff_memb)
                            {
                                //if($key1 == 0){
                                   $old_id = $llogin_id;
                               // }else{
                                    //$old_id = $new_id;
                              //  }
                                    $desig_type = $pool_eff_memb['designation_type_id'];//exit;

                                    $pool_perc = $pool_eff_memb['percentage'];
                                    $parent_reward_rs = ($pool_perc * $perc_each_grp)/100;
                                    $paid_amount +=$parent_reward_rs;
                                    //$old_id = $old_id + $new_id - $new_id;
                                    // echo $llogin_id;
                                    $get_parent_id_qry = "select * from gp_login_table where id = '$old_id'";
                                    $get_parent_id_qry = $this->db->query($get_parent_id_qry);
                                    // echo $this->db->last_query();
                                    if($get_parent_id_qry && $get_parent_id_qry->num_rows() >0)
                                    {
                                        $get_login_details = $get_parent_id_qry->row_array();
                                        $new_id = $get_login_details['parent_login_id'];

                                            if($new_id == 1)
                                            {
                                                // update admin wallet
                                                $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                $this->db->where('user_id', 1);
                                                $this->db->where('wallet_type_id', 4);
                                                $this->db->update('gp_wallet_values');
                                                //echo $this->db->last_query();
                                                $wal_val_id2 =get_wallet_val_id(1,4);
                                                $wal_activitys1 = array(
                                                    'wallet_type_id' => 4,
                                                    'wallet_val_id' => $wal_val_id2,
                                                    'user_id' => 1,
                                                    'purchase_bill_notification_id'=>$noty_id,
                                                    'change_value' => $parent_reward_rs,
                                                    'type'=>'GAIN',
                                                    'date_modified' => date('Y-m-d h:i:s'),
                                                    'description' => 'Reward when parent is admin'
                                                );
                                                $this->db->insert('gp_wallet_activity', $wal_activitys1);
                                                /*Entry items jaazo member reward*/
                                                // if($entry_id1){
                                                //     $ledger_payment_cr3 = 32;
                                                //     $ledger_payment_dr3 = 32;
                                                    
                                                //     add_acc_entry_item($entry_id1,$ledger_payment_cr3,'Cr',$parent_reward_rs);
                                                //     add_acc_entry_item($entry_id1,$ledger_payment_dr3,'Dr',$parent_reward_rs);
                                                // }
                                            } else
                                            {
                                                $lg_qry = "select * from gp_login_table lg where lg.id = '$new_id'";

                                                $lg_qry = $this->db->query($lg_qry);
                                                if($lg_qry && $lg_qry->num_rows()>0)
                                                {
                                                    $lg_result = $lg_qry->row_array();
                                                    $lg_id = $lg_result['id'];
                                                    $lg_user_id = $lg_result['user_id'];
                                                    $lg_parent_id = $lg_result['parent_login_id'];
                                                   
                                                    $type = $lg_result['type'];

                                                   
                                                    //var_dump($type);exit;
                                                    if($type=='executive')
                                                    {
                                                        $exe_qry =  "select t.id as sales_desig_type_id, t.type from gp_pl_sales_team_members mem LEFT JOIN gp_pl_sales_designation_type t on mem.sales_desig_type_id= t.id where mem.id = '$lg_user_id'";

                                                    }
                                                    else{
                                                          $exe_qry =  "select t.id as sales_desig_type_id, mem.type,mem.investor_type_id as investor from gp_normal_customer mem LEFT JOIN gp_pl_sales_designation_type t on mem.type = t.slug  where mem.id = '$lg_user_id'";
                                                    }
                                                    $exe_qry = $this->db->query($exe_qry);
                                                    //echo $this->db->last_query();//exit;
                                                    if($exe_qry && $exe_qry->num_rows()>0)
                                                    {
                                                        $res_exe = $exe_qry->row_array();
                                                        $exe_desig_id = $res_exe['sales_desig_type_id'];
                                                         $stype = $res_exe['type'];
                                                         if($stype=='executive'){
                                                            $wallet_type =  3;
                                                         }else if($stype=='club_member'){
                                                            $cm_type =$res_exe['investor'];
                                                            if($cm_type>0)
                                                            {
                                                                $wallet_type =  3;
                                                                $slug = 'team_lead_club_member';
                                                                $exe_desig_id= get_designation_by_slug($slug);
                                                            }else{
                                                                $wallet_type =  2;
                                                            }
                                                         }else if($stype=='club_agent'){
                                                            $wallet_type =  3;
                                                         }else if($stype=='Channel_partner'){
                                                            $wallet_type =  4;
                                                         }
                                                         else{
                                                            $wallet_type =  2;
                                                         }
                                                      
                                                        if($exe_desig_id == $desig_type)
                                                        {
                                                           
                                                            if($stype=='club_member'){
                                                                if($related_to=='CHANNEL_PARTNER'){
                                                                    $cp_id =$cplg_id;
                                                                    $res11=$this->get_cm_type($lg_id,$cp_id);
                                                                
                                                                }else{
                                                                    $cp_id='';
                                                                    $res11=false;
                                                                
                                                                    
                                                                }
                                                               
                                                                if($res11){
                                                                   
                                                                    $balance1 = ($perc_each_grp-$paid_amount)+$parent_reward_rs;
                                                                    $this->db->set('total_value', 'total_value + ' . (float) $balance1, FALSE);
                                                                    $this->db->where('user_id', 1);
                                                                    $this->db->where('wallet_type_id', 4);
                                                                    $this->db->update('gp_wallet_values');
                                                                    $wal_val_id9=get_wallet_val_id(1,4);
                                                                    
                                                                    $wall_activitys2 = array(
                                                                        'wallet_type_id' => 4,
                                                                        'wallet_val_id' => $wal_val_id9,
                                                                        'user_id' => 1,
                                                                        'purchase_bill_notification_id'=>$noty_id,
                                                                        'change_value' => $balance1,
                                                                        'type'=>'GAIN',
                                                                        'date_modified' => date('Y-m-d h:i:s'),
                                                                        'description' => 'Reward when parent is admin'
                                                                    );
                                                                    $this->db->insert('gp_wallet_activity', $wall_activitys2);
                                                                    /*Entry items jaazo member reward*/
                                                                    // if($entry_id1){
                                                                    //     $ledger_payment_cr10 = 32;
                                                                    //     $ledger_payment_dr10 = 32;
                                                                        
                                                                    //     add_acc_entry_item($entry_id1,$ledger_payment_cr10,'Cr',$balance1);
                                                                    //     add_acc_entry_item($entry_id1,$ledger_payment_dr10,'Dr',$balance1);
                                                                    // }  
                                                                    break;
                                                                }else{
                                                                    goto a;
                                                                   // $flag=false;
                                                                }
                                                                            //var_dump($res11);
                                                            }
                                                        }
                                                        //var_dump($stype);var_dump($desig_type);exit;
                                                        a: if($exe_desig_id == $desig_type)
                                                        {
                                                            $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                            $this->db->where('user_id', $new_id);
                                                            $this->db->where('wallet_type_id', $wallet_type);
                                                            $this->db->update('gp_wallet_values');
                                                            //echo $this->db->last_query();
                                                            $wal_val_id3 =get_wallet_val_id($new_id,$wallet_type);
                                                            $wal_activity3 = array(
                                                                'wallet_type_id' => $wallet_type,
                                                                'wallet_val_id' => $wal_val_id3,
                                                                'user_id' => $new_id,
                                                                'purchase_bill_notification_id'=>$noty_id,
                                                                'change_value' => $parent_reward_rs,
                                                                'type'=>'GAIN',
                                                                'date_modified' => date('Y-m-d h:i:s'),
                                                                'description' => 'Reward when child purchased'
                                                                );
                                                            $this->db->insert('gp_wallet_activity', $wal_activity3); 
                                                            /*Entry items jaazo member reward*/
                                                            // if($entry_id1){
                                                            //     $ledger_payment_cr4 = 32;
                                                            //     $ledger_payment_dr4 = getLedgerById($new_id);
                                                                
                                                            //     add_acc_entry_item($entry_id1,$ledger_payment_cr4,'Cr',$parent_reward_rs);
                                                            //     add_acc_entry_item($entry_id1,$ledger_payment_dr4,'Dr',$parent_reward_rs);
                                                            // }  
                                                        } else
                                                        {
                                                            $get_new_id = $this->get_parent_from_login($noty_id,$lg_id, $desig_type,$parent_reward_rs);
                                                            if(!empty($get_new_id)){
                                                                $get_parent_id_qry1 = "select * from gp_login_table where id = '$get_new_id'";
                                                                $get_parent_id_qry1 = $this->db->query($get_parent_id_qry1);
                                                                if($get_parent_id_qry1->num_rows() >0)
                                                                {
                                                                    $get_login_details1 = $get_parent_id_qry1->row_array();

                                                                    $mem_id= $get_login_details1['user_id'];
                                                                    $typee = $get_login_details1['type'];
                                                                     
                                                                    if($typee=='executive'){
                                                                            $wallet_type =  3;
                                                                    }else if($typee=='club_member'){

                                                                        $eqry =  "select  mem.type,mem.investor_type_id as investor from gp_normal_customer mem LEFT JOIN gp_pl_sales_designation_type t on mem.type = t.slug  where mem.id = '$mem_id'";
                                                        
                                                                        $eqry = $this->db->query($eqry);
                                                                        //echo $this->db->last_query();//exit;
                                                                        if($eqry && $eqry->num_rows()>0)
                                                                        {
                                                                            $e_res = $eqry->row_array();
                                                                        }
                                                                        $cm_type =$e_res['investor'];
                                                                        if($cm_type>0)
                                                                        {
                                                                            $wallet_type =  3;
                                                                        }else{
                                                                            $wallet_type =  2;
                                                                        }
                                                                    }else if($typee=='club_agent'){
                                                                        $wallet_type =  3;
                                                                    }else if($typee=='Channel_partner'){
                                                                        $wallet_type =  4;
                                                                     }else{
                                                                        $wallet_type =  2;
                                                                    }
                                                                    // $wallet_type = ($typee=='executive') ? 3 : (($typee=='club_agent') ? 3: 2 );
                                                                }
                                                                // echo $typee;echo $key;
                                                                if($typee=='club_member'){
                                                                    if($related_to=='CHANNEL_PARTNER'){
                                                                        $cp_id =$cplg_id;
                                                                        $res12=$this->get_cm_type($get_new_id,$cp_id);
                                                                    }else{
                                                                        $cp_id='';
                                                                        $res12=false;
                                                                        // $llogin_id=$lg_parent_id;
                                                                    }
                                                                    // $res12=$this->get_cm_type($get_new_id,$cp_id);
                                                                    // var_dump($res12);exit;
                                                                    if($res12){
                                                                        //$flag =true;
                                                                        // update admin wallet
                                                                        $balance2 = ($perc_each_grp-$paid_amount)+$parent_reward_rs;
                                                                        $this->db->set('total_value', 'total_value + ' . (float) $balance2, FALSE);
                                                                        $this->db->where('user_id', 1);
                                                                        $this->db->where('wallet_type_id', 4);
                                                                        $this->db->update('gp_wallet_values');
                                                                        $wal_val_id10=get_wallet_val_id(1,4);
                                                                        //echo $this->db->last_query();
                                                                        $wall_activitys4 = array(
                                                                            'wallet_type_id' => 4,
                                                                            'wallet_val_id' => $wal_val_id10,
                                                                            'user_id' => 1,
                                                                            'purchase_bill_notification_id'=>$noty_id,
                                                                            'change_value' => $balance2,
                                                                            'type'=>'GAIN',
                                                                            'date_modified' => date('Y-m-d h:i:s'),
                                                                            'description' => 'Reward when parent is admin'
                                                                        );
                                                                        $this->db->insert('gp_wallet_activity', $wall_activitys4);
                                                                        /*Entry items jaazo member reward*/
                                                                        // if($entry_id1){
                                                                        //     $ledger_payment_cr11 = 32;
                                                                        //     $ledger_payment_dr11 = 32;
                                                                            
                                                                        //     add_acc_entry_item($entry_id1,$ledger_payment_cr11,'Cr',$balance2);
                                                                        //     add_acc_entry_item($entry_id1,$ledger_payment_dr11,'Dr',$balance2);
                                                                        // }  
                                                                        break;
                                                                    }else{
                                                                        $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                                        $this->db->where('user_id', $get_new_id);
                                                                        $this->db->where('wallet_type_id', $wallet_type);
                                                                        $this->db->update('gp_wallet_values');
                                                                        //echo $this->db->last_query();
                                                                         $wal_val_id4 =get_wallet_val_id($get_new_id, $wallet_type);
                                                                        $wal_activity5 = array(
                                                                            'wallet_type_id' => $wallet_type,
                                                                            'wallet_val_id' => $wal_val_id4,
                                                                            'user_id' => $get_new_id,
                                                                            'purchase_bill_notification_id'=>$noty_id,
                                                                            'change_value' => $parent_reward_rs,
                                                                            'type'=>'GAIN',
                                                                            'date_modified' => date('Y-m-d h:i:s'),
                                                                            'description' => 'Reward when child purchased'
                                                                            );
                                                                        $this->db->insert('gp_wallet_activity', $wal_activity5);
                                                                        /*Entry items jaazo member reward*/
                                                                        // if($entry_id1){
                                                                        //     $ledger_payment_cr5 = 32;
                                                                        //     $ledger_payment_dr5 = getLedgerById($get_new_id);
                                                                            
                                                                        //     add_acc_entry_item($entry_id1,$ledger_payment_cr5,'Cr',$parent_reward_rs);
                                                                        //     add_acc_entry_item($entry_id1,$ledger_payment_dr5,'Dr',$parent_reward_rs);
                                                                        // }  
                                                                    }
                                                                }else{
                                                                    $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                                        $this->db->where('user_id', $get_new_id);
                                                                        $this->db->where('wallet_type_id', $wallet_type);
                                                                        $this->db->update('gp_wallet_values');
                                                                        //echo $this->db->last_query();
                                                                         $wal_val_id4 =get_wallet_val_id($get_new_id, $wallet_type);
                                                                        $wal_activity6= array(
                                                                            'wallet_type_id' => $wallet_type,
                                                                            'wallet_val_id' => $wal_val_id4,
                                                                            'user_id' => $get_new_id,
                                                                            'purchase_bill_notification_id'=>$noty_id,
                                                                            'change_value' => $parent_reward_rs,
                                                                            'type'=>'GAIN',
                                                                            'date_modified' => date('Y-m-d h:i:s'),
                                                                            'description' => 'Reward when child purchased'
                                                                            );
                                                                        $this->db->insert('gp_wallet_activity', $wal_activity6);
                                                                        /*Entry items jaazo member reward*/
                                                                        // if($entry_id1){
                                                                        //     $ledger_payment_cr5 = 32;
                                                                        //     $ledger_payment_dr5 = getLedgerById($get_new_id);
                                                                            
                                                                        //     add_acc_entry_item($entry_id1,$ledger_payment_cr5,'Cr',$parent_reward_rs);
                                                                        //     add_acc_entry_item($entry_id1,$ledger_payment_dr5,'Dr',$parent_reward_rs);
                                                                        // }  
                                                                }
                                                            }
                                                        }

                                                    }else{
                                                        $res_exe = array();

                                                        //get reward to admin when no sales members

                                                        // update admin wallet
                                                        $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                        $this->db->where('user_id', 1);
                                                        $this->db->where('wallet_type_id', 4);
                                                        $this->db->update('gp_wallet_values');
                                                        $wal_val_id5 =get_wallet_val_id(1,4);
                                                        //echo $this->db->last_query();
                                                        $wall_activitys7 = array(
                                                            'wallet_type_id' => 4,
                                                            'wallet_val_id' => $wal_val_id5,
                                                            'user_id' => 1,
                                                            'purchase_bill_notification_id'=>$noty_id,
                                                            'change_value' => $parent_reward_rs,
                                                            'type'=>'GAIN',
                                                            'date_modified' => date('Y-m-d h:i:s'),
                                                            'description' => 'Reward when parent is admin'
                                                        );
                                                        $this->db->insert('gp_wallet_activity', $wall_activitys7);
                                                        /*Entry items jaazo member reward*/
                                                        // if($entry_id1){
                                                        //     $ledger_payment_cr6 = 32;
                                                        //     $ledger_payment_dr6 = 32;
                                                            
                                                        //     add_acc_entry_item($entry_id1,$ledger_payment_cr6,'Cr',$parent_reward_rs);
                                                        //     add_acc_entry_item($entry_id1,$ledger_payment_dr6,'Dr',$parent_reward_rs);
                                                        // }  
                                                    }

                                                    
                                                } else{
                                                    $lg_result = array();
                                                    // get reward to admin when no user
                                                    // update admin wallet
                                                    $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                    $this->db->where('user_id', 1);
                                                    $this->db->where('wallet_type_id', 4);
                                                    $this->db->update('gp_wallet_values');
                                                     $wal_val_id6 =get_wallet_val_id(1,4);
                                                    //echo $this->db->last_query();
                                                    $wall_activitys8 = array(
                                                        'wallet_type_id' => 4,
                                                        'wallet_val_id' => $wal_val_id6,
                                                        'user_id' => 1,
                                                        'purchase_bill_notification_id'=>$noty_id,
                                                        'change_value' => $parent_reward_rs,
                                                        'type'=>'GAIN',
                                                        'date_modified' => date('Y-m-d h:i:s'),
                                                        'description' => 'Reward when parent is admin'
                                                    );
                                                    $this->db->insert('gp_wallet_activity', $wall_activitys8);
                                                    /*Entry items jaazo member reward*/
                                                        // if($entry_id1){
                                                        //     $ledger_payment_cr7 = 32;
                                                        //     $ledger_payment_dr7 = 32;
                                                            
                                                        //     add_acc_entry_item($entry_id1,$ledger_payment_cr7,'Cr',$parent_reward_rs);
                                                        //     add_acc_entry_item($entry_id1,$ledger_payment_dr7,'Dr',$parent_reward_rs);
                                                        // } 
                                                }
                                            }
                                    }else{
                                        // get reward to admin when no parent
                                        // update admin wallet
                                        $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                        $this->db->where('user_id', 1);
                                        $this->db->where('wallet_type_id', 4);
                                        $this->db->update('gp_wallet_values');
                                        //echo $this->db->last_query();
                                         $wal_val_id7 =get_wallet_val_id(1,4);
                                        $wall_activitys9 = array(
                                            'wallet_val_id' => $wal_val_id7,
                                            'wallet_type_id' => 4,
                                            'user_id' => 1,
                                            'purchase_bill_notification_id'=>$noty_id,
                                            'change_value' => $parent_reward_rs,
                                            'type'=>'GAIN',
                                            'date_modified' => date('Y-m-d h:i:s'),
                                            'description' => 'Reward when parent is admin'
                                        );
                                        $this->db->insert('gp_wallet_activity', $wall_activitys9);
                                        /*Entry items jaazo member reward*/
                                        // if($entry_id1){
                                        //     $ledger_payment_cr8 = 32;
                                        //     $ledger_payment_dr8 = 32;
                                            
                                        //     add_acc_entry_item($entry_id1,$ledger_payment_cr8,'Cr',$parent_reward_rs);
                                        //     add_acc_entry_item($entry_id1,$ledger_payment_dr8,'Dr',$parent_reward_rs);
                                        // }
                                    }                                                       

                            }
                           // var_dump($flag);exit;
                           /* if($flag==true){
                                //break;
                            }else{
                                $flag=false;
                            }*/

                        }else{
                            $pool_eff_membs = array();
                        }
                    
                   //}
                }
                if($tot_percentage<100){
                    $discnt = 100-$tot_percentage;
                    $bal_amnt = ($pooling_commision * $discnt)/100;
                    // update admin wallet
                    $this->db->set('total_value', 'total_value + ' . (float) $bal_amnt, FALSE);
                    $this->db->where('user_id', 1);
                    $this->db->where('wallet_type_id', 4);
                    $this->db->update('gp_wallet_values');
                    //echo $this->db->last_query();
                    $wal_val_id11 =get_wallet_val_id(1,4);
                    $wal_activitys2 = array(
                        'wallet_type_id' => 4,
                        'wallet_val_id' => $wal_val_id11,
                        'user_id' => 1,
                        'purchase_bill_notification_id'=>$noty_id,
                        'change_value' => $bal_amnt,
                        'type'=>'GAIN',
                        'date_modified' => date('Y-m-d h:i:s'),
                        'description' => 'Reward when parent is admin'
                    );
                    $this->db->insert('gp_wallet_activity', $wal_activitys2);
                    /*Entry items jaazo member reward*/
                    // if($entry_id1){
                    //     $ledger_payment_cr12 = 32;
                    //     $ledger_payment_dr12 = 32;
                        
                    //     add_acc_entry_item($entry_id1,$ledger_payment_cr12,'Cr',$bal_amnt);
                    //     add_acc_entry_item($entry_id1,$ledger_payment_dr12,'Dr',$bal_amnt);
                    // }    
                }
         //end  effect pooling parents walletes when using purchases
        }else{
           $purchase = array();
        } 
         //exit;
         //return true;
        $this->db->trans_complete();
         if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            $info = array('login' => $cus_login_id, 'reward' =>$discount);
            return $info;
        }
    }
    function get_cm_type($lid,$cplg_id=NULL){
        if($cplg_id){
            $qry2 = "select cp.club_mem_id,cp.club_type from gp_pl_channel_partner cp left join gp_login_table log on log.user_id=cp.id where log.id = '$cplg_id' AND cp.club_mem_id='$lid'"; 
        }else{
            $qry2 = "select nc.fixed_club_type_id from gp_login_table log left join gp_normal_customer nc on log.user_id=nc.id where log.id = '$lid'"; 

        }    
        $cp_qry = $this->db->query($qry2);
        // echo $this->db->last_query();exit;
        if($cp_qry && $cp_qry->num_rows()>0)
        {
            $cp_result = $cp_qry->row_array();
            if((isset($cp_result['club_type'])&&$cp_result['club_type']=='FIXED') ||(isset($cp_result['fixed_club_type_id'])&& $cp_result['fixed_club_type_id']>0))
            {
                return true;
            }else{
                return false;
            }
        }else{
            return false;
        }
    }
    function get_parent_from_login($noty_id,$login_id, $desig_type_id,$parent_reward_rs){      
        $qry = "select * from gp_login_table lg where lg.id = '$login_id'";       
        $lg_qry = $this->db->query($qry);
        if($lg_qry && $lg_qry->num_rows()>0)
        {

            $lg_result = $lg_qry->row_array();
            $parent_id = $lg_result['parent_login_id'];
            // var_dump($parent_id);exit();
            if($parent_id == 1){
               // var_dump($parent_id);exit();
                // update admin wallet
                $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                $this->db->where('user_id', 1);
                $this->db->where('wallet_type_id', 4);
                $this->db->update('gp_wallet_values');
                 $wal_val_id8 =get_wallet_val_id(1,4);
                $wal_activitys = array(
                    'wallet_type_id' => 4,
                    'wallet_val_id' => $wal_val_id8,
                    'user_id' => 1,
                    'purchase_bill_notification_id'=>$noty_id,
                    'change_value' => $parent_reward_rs,
                    'type'=>'GAIN',
                    'date_modified' => date('Y-m-d h:i:s'),
                    'description' => 'Reward when parent is admin'
                );
                $this->db->insert('gp_wallet_activity', $wal_activitys);
                /*Entry items jaazo member reward*/
                // if($entry_id1){
                //     $ledger_payment_cr9 = 32;
                //     $ledger_payment_dr9 = 32;
                    
                //     add_acc_entry_item($entry_id1,$ledger_payment_cr9,'Cr',$parent_reward_rs);
                //     add_acc_entry_item($entry_id1,$ledger_payment_dr9,'Dr',$parent_reward_rs);
                // }
                return array();//return true;
            }else{
                $get_parent_id_qry1 = "select * from gp_login_table where id = '$parent_id'";
                $get_parent_id_qry1 = $this->db->query($get_parent_id_qry1);
                if($get_parent_id_qry1->num_rows() >0)
                {
                    $get_login_details1 = $get_parent_id_qry1->row_array();
                    $type = $get_login_details1['type'];
                    if($type=='executive')
                        {
                            $exe_qry =  "select t.id as sales_desig_type_id, t.type, l.id as login_id from gp_login_table l left join gp_pl_sales_team_members mem on l.user_id = mem.id LEFT JOIN gp_pl_sales_designation_type t on mem.sales_desig_type_id= t.id where l.id = '$parent_id' and l.type = 'executive'";

                        }
                        else{
                              $exe_qry =  "select t.id as sales_desig_type_id, mem.type, l.id as login_id,mem.investor_type_id from gp_normal_customer mem LEFT JOIN gp_pl_sales_designation_type t on mem.type = t.slug left join gp_login_table l on l.user_id = mem.id where l.id = '$parent_id' and l.type not in ('executive','super_admin')";
                        }
                        $exe_qry = $this->db->query($exe_qry);
                        //echo $this->db->last_query();exit();
                        if($exe_qry && $exe_qry->num_rows()>0)
                        {
                            $result_sales = $exe_qry->row_array();
                            $desig_id = $result_sales['sales_desig_type_id'];
                            $investor = isset($result_sales['investor_type_id'])?$result_sales['investor_type_id']:'';
                            if(!empty($investor)||($investor>0)){
                                $slug = 'team_lead_club_member';
                                $desig_id= get_designation_by_slug($slug);
                                //var_dump($desig_id);var_dump($desig_type_id);exit();
                            }else{
                                $desig_id = $desig_id;
                            }
                            //var_dump($desig_id);var_dump($des_type);exit();
                            if($desig_type_id == $desig_id)
                            {
                                return $parent_id;

                            } else{
                                return  $this->get_parents_login($noty_id,$parent_id, $desig_type_id,$parent_reward_rs);
                            }
                        }else{
                            return array();
                        }
                }else{
                            return array();
                        }
                    // $lg_user_id = $lg_result['user_id'];
                    // $parent_id = $lg_result['parent_login_id'];
                    //$type = $lg_result['type'];
                
                        
                       
            }


        } else{
            $lg_result = array();
        }   
    }
    function get_parents_login($noty_id,$parent_id, $desig_type_id,$parent_reward_rs){
        $qry = "select * from gp_login_table lg where lg.id = '$parent_id'";
        $lg_qry = $this->db->query($qry);
        //echo $this->db->last_query();exit();
        if($lg_qry && $lg_qry->num_rows()>0)
        {
            $lg_result = $lg_qry->row_array();
            $lg_id = $lg_result['id'];
           return $this->get_parent_from_login($noty_id,$lg_id,$desig_type_id,$parent_reward_rs);
        }else{
           return $this->get_parent_from_login($noty_id,$parent_id,$desig_type_id,$parent_reward_rs);
        }
    }
    function get_pooling_settings(){
        $qry_pool_set = "select pl_stg.id, pl_stg.related_to,pl_stg.title, pl_stg.percentage, pl_stg.no_of_levels from gp_pl_pool_settings pl_stg";
        $qry_pool_set = $this->db->query($qry_pool_set);
        if($qry_pool_set->num_rows()>0)
        {
            return $qry_pool_set->result_array();
        }else{
            return array();
        }
    }
     function resend_otp($otp)
        {
           $pur_id = $this->input->post('pur_id');

            $data = array(
                'otp' => $otp
                );
            $this->db->trans_begin();
            $this->db->where('id',$pur_id);
            $qry_otp = $this->db->update('gp_purchase_bill_notification', $data);
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $data['status'] = FALSE;
            } else {
                $this->db->trans_commit();
                $data['status'] = TRUE;
                $data['data'] = $otp;
            }

           return $data;

        }
        function verify_user($mobile,$userid)
        {
            
            
            $qry = $this->db->query("SELECT t.* FROM gp_login_table t left join gp_normal_customer n on t.user_id = n.id WHERE t.mobile = '$mobile' and t.type not in ('super_admin','channel_partner','executive') and t.is_del = '0' and n.status = 'approved'");
            //echo $this->db->last_query();exit;
            if($qry->num_rows()>0)
            {
                $this->load->helper('string');
                $otp = random_string('numeric', 4);
                $res1 = $qry->row();
                $lg_id = $res1->id;
                $data = array(
                    'channel_partner_id' =>$userid,
                    'login_id' =>$lg_id,
                    'purchased_on' => date('Y-m-d H:i:s'),
                    'otp' => $otp,
                    'type' =>'direct',
                    'status' => 0
                    );
                $this->db->trans_begin();
                $qry_otp = $this->db->insert('gp_purchase_bill_notification', $data);
                $insert_id = $this->db->insert_id();
                $this->db->trans_complete();
                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $data['status'] = FALSE;
                } else {
                    $this->db->trans_commit();
                    $data['status'] = TRUE;
                    $info = array('purchase_id' => $insert_id,
                                'otp' => $otp
                                    );
                    $data['data'] = $info;
                }

            }else{
                $data['status'] = false;
            }
            
            
            return $data;

        }
       function verify_otp()
        {
            $pur_id = $this->input->post('pur_id');
            $otp = $this->input->post('otp');
            $qry = $this->db->query("SELECT * FROM gp_purchase_bill_notification p WHERE p.otp = '$otp' and p.id = '$pur_id'");
            
            if($qry->num_rows()>0)
            {
                 $res = $qry->row();
                 $data = array('login_id' => $res->login_id, 'purchase_id' => $pur_id);  
            }else{
                $data = false;
            }                
            return $data;
        }
        function get_wallet($login_id)
        {
            
            $qry = "select
                    wal.id,
                    wal.wallet_type_id,
                    typ.title,
                    wal.user_id,
            round(wal.total_value,2) as total_value
                    from
                    gp_wallet_values wal
                    
                    left join gp_wallet_types typ on  typ.id = wal.wallet_type_id
                    where wal.user_id = ?
                    order by typ.title asc";
            $qry = $this->db->query($qry, $login_id);
            //echo $this->db->last_query();exit();
            if($qry->num_rows()>0)
            {
                return $qry->result_array();
            } else{
                return array();
            }       
        }
        function get_total_wallet_amount_customer()
        {

                $login_id = $this->input->post('login_id');
                $qry = "select sum(wl.total_value) as_total
                        from gp_wallet_values wl
                        where wl.user_id = '$login_id'";
                $qry = $this->db->query($qry);
                if($qry->num_rows()>0)
                {
                    return $qry->row_array();
                }else
                {
                    return array();
                }
            
        }
        function check_bal_in_wallet()
        {
            $data = array();
            $wallet_price = $this->input->post('price');
            $wallet_id =  $this->input->post('wallet_id');
            foreach ($wallet_id as $key => $walt) {
                $price = $wallet_price[$key];
                $wal_qry = "select * from gp_wallet_values where id = '$walt' and total_value >= '$price'";
                $wal_qry = $this->db->query($wal_qry);
                if($wal_qry->num_rows()>0)
                {
                    $data['status'] = TRUE;
                } else{
                    $data['status'] = FALSE;
                }
            }
            return $data;
        }
        function give_notification()
        {
            $this->db->trans_begin();
            $wallet_price = $this->input->post('price');
            $wallet_id =  $this->input->post('wallet_id');
            $customer = $this->input->post('login_id');
            $purchase_id = $this->input->post('purchase_id');
            $sum = 0;
            foreach ($wallet_price as $key => $price) {
                $price = ($price=='')? 0 : $price;
                $sum += $price;
            }
            $data = array(
                'wallet_total' => $sum,
                'purchased_on' => date('Y-m-d H:i:s')
                
                );
            $this->db->where('id',$purchase_id);
            $qry = $this->db->update('gp_purchase_bill_notification', $data);
            $noty = array();
            foreach ($wallet_price as $key => $wallet_amt) {
                if(!empty($wallet_amt)){
                    $noty[] = array(
                        'bill_notification_id' => $purchase_id,
                        'wallet_id' => $wallet_id[$key],
                        'wallet_value' => $wallet_amt
                        );
                }
            }
            if(!empty($noty)){
              $this->db->insert_batch('gp_purchase_bill_noty_wallet_items', $noty);
            }  
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                return FALSE;
            } else {
                $this->db->trans_commit();
                return TRUE;
            }
            
        }
        function get_profile_details($userid)
        {
                $qry = "select par.*,ct.name as country1, s.name as state1, c.name as city1 from gp_pl_channel_partner par LEFT join countries ct on ct.id = par.country left join states s on s.id = par.state LEFT join cities c on c.id = par.town where par.id = '$userid'";
                $qry = $this->db->query($qry);
                if($qry->num_rows()>0)
                {
                    $data = $qry->row();
                } else{
                    $data = FALSE;
                }

            return $data;
        }

    function get_cp_details($id)
    {
       $qry_res = "SELECT tb.*,nc.otp from gp_login_table tb left join gp_pl_channel_partner nc on tb.user_id=nc.id where tb.user_id = '$id' and tb.type = 'Channel_partner'";
        $qry_res = $this->db->query($qry_res);
        //echo $this->db->last_query();exit();
        if($qry_res->num_rows()>0)
        {
             $login_details = $qry_res->row_array();
        }else{
            $login_details = false;
        }
       
        return $login_details;
    }
    function update_profile($image_file1,$image_file2,$creg,$license){
       $loginsession = $this->session->userdata('logged_in_cp');

        $userid=$loginsession['user_id'];
        $updated_on = date("Y-m-d h:i:sa");
        $this->db->trans_begin();
        $hiddenid=$this->input->post('hiddenid');

        $data=array(
            'name'=>$this->input->post('name'),
            'phone'=>$this->input->post('phone'),
            'phone2'=>$this->input->post('phone2'),  
            
            'cname'=>$this->input->post('cname'),
            'c_email'=>$this->input->post('c_email'),
            'c_mobile'=>$this->input->post('c_mobile'),
            'alt_c_name'=>$this->input->post('acname'),
            'alt_c_email'=>$this->input->post('ac_email'),
            'alt_c_mobile'=>$this->input->post('ac_mobile'),
            'owner_name'=>$this->input->post('ocname'),
            'owner_email'=>$this->input->post('oc_email'),
            'owner_mobile'=>$this->input->post('oc_mobile'),
            'country'=>$this->input->post('country'),
            'state'=>$this->input->post('state'),
            'town'=>$this->input->post('town'),
            
            
            
            'area'=>$this->input->post('area'),
            
            
            
            
            
            'address'=>$this->input->post('address'),
            'bank_name'=>$this->input->post('bank_name'),
            'account_no'=>$this->input->post('ac_number'),
            'account_holder_name'=>$this->input->post('ac_holder_name'),
            'ifsc'=>$this->input->post('ifsc'),
            
            'updated_on'=>$updated_on,
            'updated_by'=>$userid,
            'pan'=>$this->input->post('pan'),
            'gst'=>$this->input->post('gst'),
            'company_registration'=>$creg,
            'license'=>$license,
            'lattitude'=>$this->input->post('latt'),
            'longitude'=>$this->input->post('long'),
           
            'profile_image'=> $image_file1,
            'brand_image'=> $image_file2
        );
        $id = $this->input->post('hiddenid');
        $this->db->where('id',$id);
        $this->db->update('gp_pl_channel_partner',$data);
        //echo $this->db->last_query();exit();
     
        $date = date("Y-m-d h:i:sa") ;
        $action = "updated parnter ";
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
        $qry="SELECT * FROM `gp_pl_channel_partner_types` WHERE  parent = '0'";
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
        $qry="SELECT p.id, p.title, p.description, p.parent, e.title AS ptitle
        FROM gp_pl_channel_partner_types e
        INNER JOIN gp_pl_channel_partner_types p 
        ON p.parent = e.id WHERE p.parent!=0 ";
        $qry=$this->db->query($qry);
        if($qry){
            $data['type']=$qry->result_array();
        }
        else{
            $data['type']=array();
        }
        return $data;
    }
    function check_coupon_code()
        {
            $session_data=$this->session->userdata('logged_in_cp');
            $id=$session_data['user_id'];
            $coupon_code = $this->input->post('coupon_code');
            $qry = "select c.status,c.amount,c.id from coupon c LEFT JOIN gp_deal_channel_partner_con d on c.deal_con = d.id where c.coupon_code= '$coupon_code' and d.channel_partner_id = '$id'";
            $qry = $this->db->query($qry);
            if($qry->num_rows()>0)
            {
                $row = $qry->row();
                $data = array("status" =>$row->status,"amount"=>$row->amount,"id" => $row->id);
            } else{
                $data = FALSE;
            }

            return $data;
        }
    function delete_billing($id){
        $this->db->trans_begin();
        $qry = "select * from gp_purchase_bill_noty_wallet_items item where item.bill_notification_id = $id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
          $items =  $qry->result_array();
            foreach ($items as $key => $item) {
                $item_id = $item['id'];
                $this->db->where('id', $item_id);
                $qry = $this->db->delete('gp_purchase_bill_noty_wallet_items');
            }
        } 
        $this->db->where('id', $id);
        $qry = $this->db->delete('gp_purchase_bill_notification');
      
        if($this->db->trans_status()===false)
        {
            $this->db->trans_rollback();
            return false;
        }else{
            $this->db->trans_commit();
            return true;
        }
    }

}

?>