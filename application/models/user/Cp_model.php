<?php


Class Cp_model extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
     function add_partner($otp,$qr_no,$creg,$license){
      $this->db->trans_begin();
        $session_array2 = $this->session->userdata('logged_in_club_member');
        if(isset($session_array2)){
            $login_id = $session_array2['id'];
            $userid=$session_array2['user_id'];
          
        }

       $email=$this->input->post('email');
       $created_on = date("Y-m-d h:i:sa") ;
       
        $module = $this->input->post('module');
        $name = $this->input->post('name');
        $string = str_replace(' ','',$name);
        $myStr = substr($string, 0, 3);  
        $qrcode = strtoupper($myStr).$qr_no;
        
        $data=array(
            'name'=>$this->input->post('name'),
            'club_mem_id'=>$login_id ,
            'club_type'=>$this->input->post('club_type'),
            'phone'=>$this->input->post('phone'),
           
            'email'=>$this->input->post('email'),
            
            'owner_name'=>$this->input->post('ocname'),
            'owner_email'=>$this->input->post('oc_email'),
            'owner_mobile'=>$this->input->post('oc_mobile'),
            'country'=>$this->input->post('country'),
            'state'=>$this->input->post('state'),
            'town'=>$this->input->post('town'),




            'area'=>$this->input->post('area'),




            'pan'=>$this->input->post('pan'),
            'gst'=>$this->input->post('gst'),
            'company_registration'=>$creg,
            'license'=>$license,
            'created_on'=>$created_on,
            'created_by'=>$login_id,
            'status'=>'NOT_APPROVED',
            'lattitude'=>$this->input->post('latt'),
            'longitude'=>$this->input->post('long'),
            'module'=>$module,
            'otp'=>$otp,
            'qr_code' =>$qrcode
            
        );
        $this->db->insert('gp_pl_channel_partner',$data);
        $last_channelid=$this->db->insert_id();
        $channel_type=$this->input->post('channel_type');
        foreach($channel_type as $type){
            $data=array(
                'channel_partner_type_id'=>$type,
                'channel_partner_id'=>$last_channelid,
                'module_id' => $module
            );
            $this->db->insert('gp_pl_channel_partner_type_connection',$data);
        }
        
        $logindata=array(
            'email'=>$this->input->post('email'),
            'mobile'=>$this->input->post('phone'),
            'otp_status' => 0,
            'user_id'=>$last_channelid,
            'type'=>"Channel_partner",
            'parent_login_id'=>$login_id 
        );
        $user=$this->db->insert('gp_login_table',$logindata);
        $last_userid=$this->db->insert_id();
        $wallete = array(
            array('wallet_type_id' => 2,
                'user_id' => $last_userid,
                'total_value' => 0
            ),
            array('wallet_type_id' => 4,
                'user_id' => $last_userid,
                'total_value' => 0
            )
        );
        $channelpsw['email'] = $this->input->post('email');
        $channelpsw['mobile'] = $this->input->post('phone');
    
        $qry3 = $this->db->insert_batch('gp_wallet_values', $wallete);
        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return $last_channelid;
        }
    }
    function get_my_channel_partner($lid)
    {
      $qry = "select
        cp.id,
        cp.name,cp.cname,
        cp.phone,cp.brand_image,cp.profile_image,
        typ.title as plan,
        typ.status,pm.module_name,gp_log.otp_status
        from
        gp_pl_channel_partner_type_connection con
        left join gp_pl_channel_partner cp on cp.id = con.channel_partner_id
        left join gp_pl_channel_partner_types typ on typ.id = con.channel_partner_type_id
        left join gp_permission_module pm on cp.module=pm.id
        left join gp_login_table gp_log on gp_log.id=cp.created_by
        where cp.created_by='$lid'";
      $qry = $this->db->query($qry);
      if($qry->num_rows()>0)
      {
        return $qry->result_array();
      } else{
        return array();
      } 
    }
    function delete_cp($id)
    {
      $this->db->trans_begin();
        $sql = "select * from gp_pl_channel_partner where id = '$id'";
        $sql = $this->db->query($sql);
        if($sql->num_rows()>0)
        {
            $data=$sql->row_array();
            $status = $data['status'];
            (!empty($data['profile_image']))?unlink("upload/".$data['profile_image']):'';
            (!empty($data['brand_image']))?unlink("assets/admin/brand/".$data['brand_image']):'';
        }
        if($status=='REFERED'){
            $qry_res = "DELETE cp from  gp_pl_channel_partner cp 
            where cp.id = '$id'";
        }else{
            $qry_res = "DELETE lt,cp,cptc from gp_login_table lt 
            INNER JOIN gp_pl_channel_partner cp ON lt.user_id=cp.id
            INNER JOIN gp_pl_channel_partner_type_connection  cptc ON cptc.channel_partner_id=cp.id
            where cp.id = '$id'";
        }
      $qry_res = $this->db->query($qry_res);
    

        $date = date("Y-m-d h:i:s a") ;
        $action = "Channel Partner has been deleted";
        $datas = getLoginId();
        if($datas){
          $user_id = $datas['user_id'];
        }
        $status = 0;

        activity_log($action,$user_id,$status,$date);

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
    function refer_partner()
    {

      $this->db->trans_begin();
        $session_array2 = $this->session->userdata('logged_in_club_member');
        if(isset($session_array2)){
            $login_id = $session_array2['id'];
            $userid=$session_array2['user_id'];
        }

       $email=$this->input->post('email');
       $created_on = date("Y-m-d h:i:sa") ;
        
        $data=array(
            'name'=>$this->input->post('name'),
            'club_mem_id'=>$login_id ,
            'club_type'=>$this->input->post('club_type'),
            'phone'=>$this->input->post('phone'),
            'email'=>$this->input->post('email'),
            'owner_name'=>$this->input->post('oc_name'),
            'created_on'=>$created_on,
            'owner_email'=>$this->input->post('oc_email'),
            'owner_mobile'=>$this->input->post('oc_mobile'),
            'address'=>$this->input->post('address'),
            'area'=>$this->input->post('area'),
            'created_by'=>$login_id,
            'status'=>'REFERED'  ,
            'is_reffered'=>1
        );
        $this->db->insert('gp_pl_channel_partner',$data);
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
    function get_countries(){
        $qry = "select
                c.*
                from
                countries c";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }   
    }
    function get_states(){
        $qry = "select
                s.*
                from
                states s";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
    function get_modules(){
        $qry="SELECT * FROM `gp_permission_module` WHERE is_del=0";
        $qry=$this->db->query($qry);
        if($qry){
            $data['type']=$qry->result_array();
        }
        else{
            $data['type']=array();
        }
        return $data;
    }
    function mail_exisits($mail){

        $qry = "select * from  gp_login_table where email = '$mail' and is_del = '0'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return FALSE;
        } else
        {
            return TRUE;
        }
    }
    function mobile_exisits($mob){
        $qry = "select * from gp_login_table where mobile = '$mob'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return FALSE;
        } else
        {
            return TRUE;
        }
    }
    function get_cp_details($id){
        $qry="select chp.* from gp_pl_channel_partner chp
                where chp.is_del='0' and chp.id='$id'";
        $query=$this->db->query($qry);
        if($query){
            $data['partner']=$query->row_array();
              $qry2 ="select c.channel_partner_type_id from gp_pl_channel_partner_type_connection c 
               where c.channel_partner_id = '$id' and c.is_del='0'";
          $qry2=$this->db->query($qry2);
          if($qry2->num_rows()>0){
              $res = $qry2->result_array();
              $array = array();
              foreach ($res as $key => $value) {
                  $id = $value['channel_partner_type_id'];
                  array_push($array, $id);
              }
              $data['grp_sel'] = $array;
          }
          else{
              $data['grp_sel']=array();
          }
       
        }
        else{
            $data['partner']=array();
        }
        return $data;
    }
    function update_refer_partner() {

      $this->db->trans_begin();
        $session_array2 = $this->session->userdata('logged_in_club_member');
        if(isset($session_array2)){
            $login_id = $session_array2['id'];
            $userid=$session_array2['user_id'];
        }

       $email=$this->input->post('email');
       $updated_on = date("Y-m-d h:i:sa") ;
        
        $data=array(
            'name'=>$this->input->post('name'),
            'club_mem_id'=>$login_id ,
            'club_type'=>$this->input->post('club_type'),
            'phone'=>$this->input->post('phone'),
            'email'=>$this->input->post('email'),
            'owner_name'=>$this->input->post('oc_name'),
            'updated_on'=>$updated_on,
            'owner_email'=>$this->input->post('oc_email'),
            'owner_mobile'=>$this->input->post('oc_mobile'),
            'address'=>$this->input->post('address'),
            'updated_by'=>$login_id,
            'status'=>'REFERED' 
        );
        $id = $this->input->post('hiddenid');
        $this->db->where('id',$id);
        $this->db->update('gp_pl_channel_partner',$data);
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
    function get_item_byid($id){
       
        $qry = "select
                cp.brand_image,
                cp.profile_image,cp.company_registration,cp.license
                from
                gp_pl_channel_partner cp 
                where cp.id='$id'";
        $query=$this->db->query($qry);
        if($query){
            $data=$query->row_array();
        }
        else{
            $data=array();
        }
        return $data;
    }
    function edit_partnerbyid($creg,$license){
        $session_array2 = $this->session->userdata('logged_in_club_member');
        if(isset($session_array2)){
            $login_id = $session_array2['id'];
            $userid=$session_array2['user_id'];
        }
        $updated_on = date("Y-m-d h:i:sa");
        $this->db->trans_begin();
        $hiddenid=$this->input->post('hiddenid');
        $module = $this->input->post('module');
        $data=array(
            'name'=>$this->input->post('name'),
            'phone'=>$this->input->post('phone'),
            // 'phone2'=>$this->input->post('phone2'),  
            'email'=>$this->input->post('email'),
            /*'cname'=>$this->input->post('cname'),
            'c_email'=>$this->input->post('c_email'),
            'c_mobile'=>$this->input->post('c_mobile'),
            'alt_c_name'=>$this->input->post('acname'),
            'alt_c_email'=>$this->input->post('ac_email'),
            'alt_c_mobile'=>$this->input->post('ac_mobile'),*/
            'owner_name'=>$this->input->post('ocname'),
            'owner_email'=>$this->input->post('oc_email'),
            'owner_mobile'=>$this->input->post('oc_mobile'),
            'country'=>$this->input->post('country'),
            'state'=>$this->input->post('state'),
            'town'=>$this->input->post('town'),






            'area'=>$this->input->post('area'),







            /*'address'=>$this->input->post('address'),
            'bank_name'=>$this->input->post('bank_name'),
            'account_no'=>$this->input->post('ac_number'),
            'account_holder_name'=>$this->input->post('ac_holder_name'),
            'ifsc'=>$this->input->post('ifsc'),
            'branch_name'=>$this->input->post('branch'),*/
            'updated_on'=>$updated_on,
            'updated_by'=>$userid,
            'pan'=>$this->input->post('pan'),
            'gst'=>$this->input->post('gst'),
            'company_registration'=>$creg,
            'license'=>$license,
            'lattitude'=>$this->input->post('latt'),
            'longitude'=>$this->input->post('long'),
            'module'=> $module
            /*'profile_image'=> $image_file1,
            'brand_image'=> $image_file2*/
        );
        $id = $this->input->post('hiddenid');
        $this->db->where('id',$id);
        $this->db->update('gp_pl_channel_partner',$data);

        $qrs3 = "select c.channel_partner_type_id from gp_pl_channel_partner_type_connection c where c.channel_partner_id = $id";
        $qrs3 = $this->db->query($qrs3);

        $channel = array();
        if($qrs3->num_rows()>0){
            $ppt = $qrs3->result_array();
            foreach ($ppt as $prt){
                array_push($channel,$prt['channel_partner_type_id']);
            }
        }
        $channel_type=$this->input->post('channel_type');
        foreach ($channel_type as $ch){
            if (in_array($ch, $channel))
            {

            }else{
                $ins = array(
                    'channel_partner_type_id'=>$ch,
                    'channel_partner_id'=>$id,
                    'module_id' => $module
                );
                $qrs2 = $this->db->insert('gp_pl_channel_partner_type_connection', $ins);

            }
           }
            foreach ($channel as $pr){
            if (in_array($pr, $channel_type))
            {
            }else{
                $qry32 = "delete from gp_pl_channel_partner_type_connection where channel_partner_id = $id and channel_partner_type_id = '$pr'";
                $qry32 = $this->db->query($qry32);
                $this->delete_product_by_cptype($pr,$id);
            }
            }


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
    function delete_product_by_cptype($cptype,$id)
    {
        $this->db->trans_begin();
        $qry_pr = "select p.id from gp_product_details p where p.channel_partner_id = '$id' and p.category_id = '$cptype' and p.is_del = '0'";
        $qry_pr = $this->db->query($qry_pr);
        
        if($qry_pr->num_rows()>0)
        {
              $pr_ids =  $qry_pr->result_array();

              $pr_array = array();
              foreach ($pr_ids as $key => $value) {
                array_push($pr_array, $value['id']);
              }
        
            $pr = implode("','", $pr_array);
            $data = array('is_del' => 1);
            $this->db->where_in('id', $pr);
            $qry = $this->db->update('gp_product_details', $data);
            
            $date = date("Y-m-d h:i:sa");

            $qry_img = "select * from gp_product_image pi where pi.product_id in ('$pr')";
            $qry_img = $this->db->query($qry_img);
            
            if($qry_img->num_rows()>0)
            {
              $images =  $qry_img->result_array();
              foreach ($images as $key => $val) {
                 unlink($val['p_image']);
              }
            } 

            $this->db->where_in('product_id', $pr);
            $this->db->delete('gp_product_image');

            $action = "Product has been deleted";
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
        }
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
}



