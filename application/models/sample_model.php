<?php
Class Channelpartner_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();
        $session_array = $this->session->userdata('logged_in_admin');
    }
    function get_refer_cp($id){
        $qry="SELECT cp.*,cus.name clubname from gp_pl_channel_partner cp
        left join gp_login_table login on login.id = cp.club_mem_id
        left join gp_normal_customer cus on login.user_id = cus.id
        where cp.id=$id ";
        $qry=$this->db->query($qry);
     
        if($qry){
            
            $data=$qry->row_array();
        }
        else{
            
            $data=array();
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
    function pending_approval(){
        $qry="SELECT p.name,c.id, c.category_title , c.percentage as old_commission, u.new_percentage as new_commission,u.id as uid  FROM `cp_commission_updations` u LEFT join gp_channel_con_cat_commision c on u.com_id = c.id LEFT JOIN gp_pl_channel_partner p on c.cp_id = p.id where u.status = '1'";
        $qry=$this->db->query($qry);
     
        if($qry){
            
            $data=$qry->result_array();
        }
        else{
            
            $data=array();
        }
        
        return $data;
    }
    function get_cp_cat($id){
        $qry_one =$this->db->query("SELECT c.category_level,c.id,c.main_commission,c.cp_type_id,t.title from gp_pl_channel_partner c LEFT JOIN gp_pl_channel_partner_types t on t.id = c.cp_type_id where c.id = '$id'");
       // echo $this->db->last_query();exit();

        if($qry_one){
            $channel = $qry_one->row();
            //var_dump($channel);exit();
            $cat = $channel->category_level;
            $data = array();
            //var_dump($cat);exit();
            if($cat == 0){
                $zero_data = array(
                    'title' => $channel->title,
                    'percentage' => $channel->main_commission,
                    'cp_id' => $channel->id,
                    'cp_type_id' => $channel->cp_type_id
                );
                $data['type'][0] = $zero_data;
            }
            else{
                $qry_two="SELECT gp.title, gpc.cp_type_id,gpc.percentage,gpc.cp_id from gp_channel_con_cat_commision gpc LEFT JOIN gp_pl_channel_partner_types gp on gp.id = gpc.cp_type_id WHERE gpc.cp_id = '$id'";
                    $qry_two=$this->db->query($qry_two);
                    
                    if($qry_two){
                        $data['type']=$qry_two->result_array();
                    }
                    else{
                        $data['type']=array();
                    }
            }
            //echo json_encode($data['type']);exit(); 
        }
        else{
            $data['type'] = array();
        }
        // $qry="SELECT gp.title, gpc.cp_type_id,gpc.percentage,gpc.cp_id from gp_channel_con_cat_commision gpc LEFT JOIN gp_pl_channel_partner_types gp on gp.id = gpc.cp_type_id WHERE gpc.cp_id = '$id' and gp.is_del = '0'";
        // $qry=$this->db->query($qry);
        
        // if($qry){
        //     $data['type']=$qry->result_array();
        // }
        // else{
        //     $data['type']=array();
        // }
        return $data;
    }
    function approve_cp_new_commission(){

        $this->db->trans_begin();
        $data=array(
            'percentage'=> $this->input->post('new_commission')
        );
        $up=array(
            'status'=> 0
        );
        $u_id = $this->input->post('u_id');
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->update('gp_channel_con_cat_commision',$data);
        $this->db->where('id', $u_id);
        $this->db->update('cp_commission_updations',$up);
               $date = date("Y-m-d h:i:sa") ;
               $action = "Updated Channelpartner Commission";
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
    function add_partnertype(){

        $this->db->trans_begin();
        $data=array(
            'parent'=>$this->input->post('category'),
            'title'=>$this->input->post('title'),
            'description'=>$this->input->post('description')
        );
        $this->db->insert('gp_pl_channel_partner_types',$data);

               $date = date("Y-m-d h:i:sa") ;
               $action = "added Channelpartner type ";
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
    function get_state_by_country($id){
        $qry = "select
                s.id,s.name,s.country_id
                from
                states s
                where s.country_id = '$id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
    function add_partnertype_sub(){

        $this->db->trans_begin();
        $data=array(
            'parent'=>$this->input->post('category'),
            'title'=>$this->input->post('title'),

        );
        $this->db->insert('gp_cp_sub_category',$data);

        $date = date("Y-m-d h:i:sa") ;
        $action = "added Channelpartner sub type ";
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
    function get_partner_type(){
        $qry="select ct.id,ct.title from gp_pl_channel_partner_types ct order by ct.id desc";
        $qry=$this->db->query($qry);
        if($qry){
            $data['type']=$qry->result_array();
        }
        else{
            $data['type']=array();
        }
        return $data;
    }
     
     function get_cp_sub_types(){
         $id = $this->input->post('id');
        // $qry="SELECT gcs.title, gcs.id FROM  gp_pl_channel_partner_types gt inner join gp_cp_sub_category gcs ON
        //  gcs.parent = gt.id WHERE gcs.parent = '$id' and gt.is_del = '0' and gcs.is_del = '0'";
         $qry = "SELECT gt.title, gt.id FROM gp_pl_channel_partner_types gt WHERE gt.parent = '$id' ";
        $qry=$this->db->query($qry);
        //echo $this->db->last_query();exit();
        if($qry){
            $data['type']=$qry->result_array();
        }
        else{
            $data['type']=array();
        }
        return $data;
    }
    function get_categories_having_sub()
      {
          $qry = "SELECT ct.id, ct.title, ct.parent FROM gp_pl_channel_partner_types ct WHERE ct.parent = 0";
          $qry = $this->db->query($qry);
          if($qry->num_rows()>0)
          {
            $categories = $qry->result_array();
            foreach ($categories as $key => $category) {
                $category_id =  $category['id'];
                $qrs = "SELECT ct.id, ct.title, ct.parent FROM gp_pl_channel_partner_types ct WHERE ct.parent = $category_id";
                $qrs = $this->db->query($qrs);
                if($qrs->num_rows()>0)
                {
                    $subcategories = $qrs->result_array();
                    
                    $data['main'][$key] = array('id' => $category['id'], 'name' => $category['title'], 'has_sub' => true);
                    foreach ($subcategories as $ke => $sub_cat) {
                        $sub_cat_id = $sub_cat['id'];
                        $qrss = "SELECT ct.id, ct.title, ct.parent FROM gp_pl_channel_partner_types ct WHERE ct.parent = $sub_cat_id";
                        $qrss = $this->db->query($qrss);  
                        if($qrss->num_rows()>0)
                        {
                          $subsubcategories = $qrss->result_array();
                          $data['main'][$key]['sub_category'][$ke] = array('id' => $sub_cat['id'], 'name' => $sub_cat['title'],'has_sub'=> true);
                          foreach ($subsubcategories as $k => $subsub_cat) {
                            $data['main'][$key]['sub_category'][$ke]['subsub'][$k] = array('id' => $subsub_cat['id'], 'name' => $subsub_cat['title'],'has_sub'=> false);
                          }


                        }else{
                          $data['main'][$key]['sub_category'][$ke] = array('id' => $sub_cat['id'], 'title' => $sub_cat['title'],'has_sub'=> false);
                        }
                    }
                    


                }else{
                    $data['main'][$key] = array('id' => $category['id'], 'name' => $category['title'], 'has_sub' => false);
                }

            }



          }else{
            $data['main'] = array();
          }
        //  echo json_encode($data);
          return $data;
      }
    function get_all_cptypes(){
         $cat = $this->input->post('obj');
         
         $cat_group = array();
          foreach ($cat as $key => $value) {
              array_push($cat_group, $value);
          }
          $res = implode("','",$cat_group);
         // var_dump($res);exit;
        $qry="SELECT title, id FROM  gp_pl_channel_partner_types where id in ('$res')";
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
       function get_cp_type_test($id){
        $qry="SELECT gt.title, gt.id,gt.parent FROM `gp_pl_channel_partner` gtc LEFT JOIN gp_pl_channel_partner_types gt ON
         gtc.cp_type_id = gt.id WHERE gtc.id = '$id'";
        $qry=$this->db->query($qry);
        if($qry){
            $data['type']=$qry->result_array();
            
            foreach ($data['type'] as $key => $value) {
                    $cp_id = $value['id'];
                    $qry_sub="SELECT gt.title, gt.id,gtc.id con_id FROM `gp_channel_con_cat_commision` gtc LEFT JOIN gp_pl_channel_partner_types gt ON
                    gtc.cp_type_id = gt.id WHERE gtc.cp_id = '$id' and gt.parent = '$cp_id' ";

                    $qry_sub=$this->db->query($qry_sub);
                    // echo $this->db->last_query();exit();
                    if($qry_sub){
                       $data['type'][$key]['sub']=$qry_sub->result_array();
                    }  
                    else{
                         $data['type'][$key]['sub']= array();
                    }
                 }
         }
         else{
            $data['type'] = array();
         }
        return $data;
      }
      function get_all_categories()
      {
        $sql="SELECT g.id,g.title,g.description,
              main.title as main_cat
              FROM gp_pl_channel_partner_types g
              LEFT JOIN gp_pl_channel_partner_types main ON main.id = g.parent
              group by g.id order by g.id desc";

        $result=$this->db->query($sql);
        if($result->num_rows()>0)
        {
          return $result->result_array();
        }else{
          return false;
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
     function get_catNsubCategory()
  {
      $qry = "SELECT ct.id, ct.title, ct.parent FROM gp_pl_channel_partner_types ct WHERE ct.parent = 0 ";
      $qry = $this->db->query($qry);
      if($qry->num_rows()>0)
      {
        $data['main'] = $qry->result_array();
        foreach ($data['main'] as $key => $main) {
          $id = $main['id'];
          $qrs = "SELECT ct.id, ct.title, ct.parent FROM gp_pl_channel_partner_types ct WHERE ct.parent = $id";
          $qrs = $this->db->query($qrs);
          if($qrs->num_rows()>0)
          {
            $data['main'][$key]['sub'] = $qrs->result_array();
              foreach ($data['main'][$key]['sub'] as $ky => $subsub) {
                  $par_id = $subsub['id'];
                    $qrss = "SELECT ct.id, ct.title, ct.parent FROM gp_pl_channel_partner_types ct WHERE ct.parent = $par_id ";
                    $qrss = $this->db->query($qrss);
                    if($qrss->num_rows()>0)
                    {
                      $data['main'][$key]['sub'][$ky]['subsub'] = $qrss->result_array();
                    }else{
                       $data['main'][$key]['sub'][$ky]['subsub'] = array();
                    }
              }
          } else{
            $data['main'][$key]['sub'] = array();
          }
        }
      } else{
        $data['main'] = array();
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

    function get_category(){
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
    function get_category_sub(){
        $qry="SELECT * FROM `gp_pl_channel_partner_types` WHERE parent!=0 ";
        $qry=$this->db->query($qry);
        if($qry){
            $data['type']=$qry->result_array();
        }
        else{
            $data['type']=array();
        }
        return $data;
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

    function get_cpwallet_value(){
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['id'];
        $qry="select    wval.id,
                wval.wallet_type_id,
                typ.title,
                wval.user_id,
                wval.total_value from gp_wallet_values wval
                left join gp_wallet_types typ on typ.id=wval.wallet_type_id
                where wval.user_id='$loginuser'
                order by typ.title asc
                ";
        $query=$this->db->query($qry);
        //echo $this->db->last_query();exit;
        if($query->num_rows()>0){
            $data['wallet']=$query->result_array();
        }
        else{
            $data['wallet']=array();
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

   
    function get_city_by_state($id){
        $qry = "select
                c.id,c.name,c.state_id
                from
                cities c
                where c.state_id = '$id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
    }
    function get_item_byid($id){
       
        $qry = "select
                cp.brand_image,
                cp.profile_image
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
    function new_commission(){
        $id = $this->input->post('hidden_id');
        $data = array(
            'com_id' => $id,
            'new_percentage' => $this->input->post('new_commission'),
            'status' => 1
        );
        $this->db->trans_begin();
        $this->db->query("UPDATE `cp_commission_updations` SET `status`= '0' WHERE com_id = '$id'");
        $this->db->insert('cp_commission_updations',$data);
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
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        foreach($category as $key => $type){
            $data[]=array(
               
                'cp_id'=>$userid,
                'category_title'=>$category[$key],
                'percentage' => $commission[$key]
            );
          
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
    function add_partner($otp){
    
       $email=$this->input->post('email');
       $created_on = date("Y-m-d h:i:sa") ;
       $photo=date("YmHms");
       $photo1=$photo+1;
       $photo2=$photo+2;
       $tmp1=explode(".",$_FILES['pro']['name']);
       $tmp2=explode(".",$_FILES['bri']['name']);
       $extension1=end($tmp1);
       $extension2=end($tmp2);
       $p1=$photo1.".".$extension1;
       $p2=$photo2.".".$extension2;
       if(($extension1=="jpg")||($extension1=="JPG")||($extension1=="png")||($extension1=="PNG")||($extension1=="JPEG")||($extension1=="jpeg")||($extension1=="gif")||($extension1=="GIF"))
       {
           move_uploaded_file($_FILES['pro']['tmp_name'],"upload/".$p1);
       }
       
       if(($extension2=="jpg")||($extension2=="JPG")||($extension2=="png")||($extension2=="PNG")||($extension2=="JPEG")||($extension2=="jpeg")||($extension2=="gif")||($extension2=="GIF"))
       {
           move_uploaded_file($_FILES['bri']['tmp_name'],"assets/admin/brand/".$p2);
       }
       $module = $this->input->post('module');
      // var_dump($this->input->post('category'));var_dump($this->input->post('commission'));exit();
        $this->db->trans_begin();
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $data=array(
            'name'=>$this->input->post('name'),
            'phone'=>$this->input->post('phone'),
            'phone2'=>$this->input->post('phone2'),  
            'email'=>$this->input->post('email'),
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
            'address'=>$this->input->post('address'),
            'bank_name'=>$this->input->post('bank_name'),
            'account_no'=>$this->input->post('ac_number'),
            'account_holder_name'=>$this->input->post('ac_holder_name'),
            'ifsc'=>$this->input->post('ifsc'),
            'branch_name'=>$this->input->post('branch'),
            'created_on'=>$created_on,
            'created_by'=>$userid,
            'status'=>'APPROVED',
            'lattitude'=>$this->input->post('latt'),
            'longitude'=>$this->input->post('long'),
            'module'=>$module,
            'otp'=>$otp,
            'profile_image'=> $p1,
            'brand_image'=> $p2
        );
        $this->db->insert('gp_pl_channel_partner',$data);
        //echo $this->db->last_query();exit();
        $last_channelid=$this->db->insert_id();
        $channel_type=$this->input->post('channel_type');
        foreach($channel_type as $key => $type){
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
            'type'=>"Channel_partner"
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
    function validate_password($password)
    {
        $qry_res = "SELECT tb.* from gp_login_table tb where tb.password = '$password'";
        $qry_res = $this->db->query($qry_res);
        if($qry_res->num_rows()>0)
        {
            $data['status'] = FALSE;
        }else{
            $data['status'] = TRUE;
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
    function get_cp_commission_main($id)
    {
       $qry_res = "SELECT cp.id,cp.cp_type_id , ct.title, cp.main_commission,cp.category_level FROM gp_pl_channel_partner cp LEFT JOIN gp_pl_channel_partner_types ct on ct.id = cp.cp_type_id WHERE cp.status = 'APPROVED' and cp.is_del = '0' and cp.id = '$id'";
        $qry_res = $this->db->query($qry_res);
        echo $this->db->last_query();exit();
        if($qry_res->num_rows()>0)
        {
             $data['data'] = $qry_res->row_array();
             $type = $data['data']['cp_type_id'];
             $qry_cat = "SELECT ct.id, ct.title FROM  gp_pl_channel_partner_types ct WHERE ct.parent = '$type'";
             $qry_cat = $this->db->query($qry_cat);
             //echo $this->db->last_query();exit();
             if($qry_cat->num_rows()>0)
                {
                     $data['cat'] = $qry_cat->result_array();
                }
                else{
                      $data['cat'] = array();
                }     
             
        }else{
            $data['data'] = array();
        }
      
        return $data;
    }
  
    function get_all_partnertype(){
        $qry="select * from gp_pl_channel_partner_types ct  order by ct.id desc";
        $qry=$this->db->query($qry);
        if($qry){
            $data['type']=$qry->result_array();
        }
        else{
            $data['type']=array();
        }
        return $data;
    }
    function get_cp_promotion_count(){
        $get_desig = $this->get_cur_desig_id();
        if(!empty($get_desig)){
                $get_desig = $get_desig['sales_desig_type_id'];
                $sale_mem_id = $get_desig['id'];
                $qry = "select
                        *
                        from
                        gp_executive_promotion_settings ep
                        where ep.sysmodule_id = 13 and ep.designation_id = '$get_desig'";
                $qry = $this->db->query($qry);
                if($qry->num_rows()>0){
                    $tot_promo_count = $qry->row_array();
                    $promo_desig = $tot_promo_count['promotion_designation'];
                    $promo_count = $tot_promo_count['promotion_count'];
                    $total_chiled = $this->get_total_cp_chiled_add_by();
                    $total_chiled = $total_chiled["total"];
                    
                    if($promo_count >= $total_chiled)
                    {
                        $up_arr = array('sales_desig_type_id' => $promo_desig);
                        $this->db->where('id', $sale_mem_id);
                        $this->db->update('gp_pl_sales_team_members', $up_arr);
                    }

                   } else {
                    array();
                   }  
        }
        else{
            array();
        }                 
    }
    function get_cur_desig_id()   {
        $session_data=$this->session->userdata('logged_in_admin');
        $login_id = $session_data['id'];
        $type = $session_data['type'];
        $desig_qry = "select
                        m.id,
                        m.sales_desig_type_id
                        from
                        gp_login_table l
                        left join gp_pl_sales_team_members m on m.id = l.user_id
                        where l.id = '$login_id'";
         $desig_qry = $this->db->query($desig_qry);   
         //echo $this->db->last_query();exit();          
         if($desig_qry->num_rows()>0)
        {
            $current_desig_arr = $desig_qry->row_array();
            //var_dump("hh");exit();
            $current_desig_arr = $current_desig_arr['sales_desig_type_id'];

        } else{
            $current_desig_arr = array();
        } 
        //echo json_encode($current_desig_arr);exit(); 
        return $current_desig_arr;
    }
    function get_total_cp_chiled_add_by(){
        $session_data=$this->session->userdata('logged_in_admin');
        $login_id = $session_data['id'];
        $qry = "select
                count(cp.id) as total
                from
                gp_pl_channel_partner cp
                where cp.parent_id = '$login_id'";
        $qry = $this->db->query($qry);
        //echo $this->db->last_query();
        if($qry->num_rows()>0)
        {
            $child = $qry->row_array();

        } else{
            $child = array();
        }   
        return $child;    
    }
    function get_deal_info(){

        $qry = "select * from gp_deal_settings";
        $qry = $this->db->query($qry);
        // echo $this->db->last_query();
        if($qry->num_rows()>0)
        {
            $child = $qry->result_array();

        } else{
            $child = array();
        }
        //var_dump($child);exit;
        return $child;
    }
    function get_deal_status($userid){

        $qry = "select
                count
                from
                gp_pl_channel_partner cp
                where cp.id = '$userid'";
        $qry = $this->db->query($qry);
        //echo $this->db->last_query();exit();
        if($qry->num_rows()>0)
        {
            $child = $qry->row_array();

        } else{
            $child = array();
        }
        //var_dump($child);exit;
        return $child;
    }
    function get_edit_partnertypebyid(){
       // exit;
        $this->db->trans_begin();
        $id=$this->input->post('hiddentype');
        $data=array(
            'title'=>$this->input->post('title'),
            'description'=>$this->input->post('descriptext'),
             'parent'=>$this->input->post('channel_type')     
        );
       //print_r($data); echo $id; exit();
        $this->db->where('id',$id);
       // $this->db->update('gp_product_category',$data);
        $this->db->update('gp_pl_channel_partner_types',$data);
        //echo $this->db->last_query();exit();
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }

    function delete_partnertypebyid($datas){
       
        $this->db->trans_begin();
        $ca_ids = $datas['chck_item_id'];
        foreach ($ca_ids as $key => $ca_id) {
           
            $this->db->where('id', $ca_id);
            $qry = $this->db->delete('gp_pl_channel_partner_types');
            
        }
        $date = date("Y-m-d h:i:sa") ;
        $action = "deleted channel parnter type ";
        $loginsession = $this->session->userdata('logged_in_admin');

        $userid=$loginsession['user_id'];
        $status = 0;

        activity_log($action,$userid,$status,$date);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
    function get_channerpartner(){
       
        $qry = "select
                cp.id as cp_id,
                cp.name, cp.phone,
                cp.phone2,
                cp.email,
                cp.fax,
                cp.address,
                GROUP_CONCAT(typ.title) as cp_type, 
                typ.description,cp.status
                from
                gp_pl_channel_partner_type_connection con
                left join gp_pl_channel_partner cp on cp.id = con.channel_partner_id
                left join gp_pl_channel_partner_types typ on typ.id = con.channel_partner_type_id
                where cp.is_del='0' 
                group by cp.id";
        $query=$this->db->query($qry);
        if($query){
            $data['partner']=$query->result_array();
        }
        else{
            $data['partner']=array();
        }
        return $data;
    }
    function get_cps_by_status($status){
       
        $qry = "select
                cp.id as cp_id,
                cp.name, cp.phone,
                cp.phone2,
                cp.email,
                cp.fax,
                cp.address,cp.otp,
                GROUP_CONCAT(typ.title) as cp_type, 
                typ.description,cp.status
                from
                gp_pl_channel_partner_type_connection con
                left join gp_pl_channel_partner cp on cp.id = con.channel_partner_id
                left join gp_pl_channel_partner_types typ on typ.id = con.channel_partner_type_id
                where cp.is_del='0' and cp.status = '$status'
                group by cp.id";
        $query=$this->db->query($qry);
        if($query){
            $data['partner']=$query->result_array();
        }
        else{
            $data['partner']=array();
        }
        return $data;
    }
    function get_channel_partners(){
       
        $qry = "select cp.id,cp.name from gp_pl_channel_partner cp where cp.is_del='0' ";
        $query=$this->db->query($qry);
        if($query){
            $data=$query->result_array();
        }
        else{
            $data=array();
        }
        return $data;
    }
    function get_channerpartner_byid($id){
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
                  # code...
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
    function edit_partnerbyid($image_file1,$image_file2){
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $updated_on = date("Y-m-d h:i:sa") ;
        $this->db->trans_begin();
        $hiddenid=$this->input->post('hiddenid');
        $data=array(
            'name'=>$this->input->post('name'),
            'phone'=>$this->input->post('phone'),
            'phone2'=>$this->input->post('phone2'),  
            'email'=>$this->input->post('email'),
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
            'address'=>$this->input->post('address'),
            'bank_name'=>$this->input->post('bank_name'),
            'account_no'=>$this->input->post('ac_number'),
            'account_holder_name'=>$this->input->post('ac_holder_name'),
            'ifsc'=>$this->input->post('ifsc'),
            'branch_name'=>$this->input->post('branch'),
            'updated_on'=>$updated_on,
            'updated_by'=>$userid,
            'status'=>'APPROVED',
            'lattitude'=>$this->input->post('latt'),
            'longitude'=>$this->input->post('long'),
            'module'=>$this->input->post('module'), 
            'profile_image'=> $image_file1,
            'brand_image'=> $image_file2
        );
        $id = $this->input->post('hiddenid');
        $this->db->where('id',$id);
        $this->db->update('gp_pl_channel_partner',$data);

        $qrs3 = "select * from erp_privilege_group_con where group_id = $gr_id";
        $qrs3 = $this->db->query($qrs3);

        $prpty = array();
        if($qrs3->num_rows()>0){
            $ppt = $qrs3->result_array();
            foreach ($ppt as $prt){
                array_push($prpty,$prt['privilege_id']);
            }
        }
        foreach ($access_perm as $property){
            if (in_array($property, $prpty))
            {

            }else{
                $ins = array(
                    'group_id' => $gr_id,
                    'privilege_id' => $property
                );
                $qrs2 = $this->db->insert('erp_privilege_group_con', $ins);

            }
        }
        foreach ($prpty as $pr){
            if (in_array($pr, $access_perm))
            {
            }else{
                $qry32 = "delete from erp_privilege_group_con where group_id = $gr_id and privilege_id =$pr";
                $qry32 = $this->db->query($qry32);
            }
        }
        

        $date = date("Y-m-d h:i:sa") ;
        $action = "updated parnter ";
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
    function delete_partnerbyid($datas){

        $data=array(
            'is_del'=>"1",

        );

       
       $this->db->trans_begin();
        $ca_ids = $datas['chck_item_id'];
        foreach ($ca_ids as $key => $ca_id) {
           
            $this->db->where('id', $ca_id);
            $qry = $this->db->update('gp_pl_channel_partner',$data);
            $this->db->where('channel_partner_id', $ca_id);
            $qry = $this->db->update('gp_pl_channel_partner_type_connection',$data);
            
        }
        $date = date("Y-m-d h:i:sa") ;
        $action = "deleted channel partner ";
        $loginsession = $this->session->userdata('logged_in_admin');

        $userid=$loginsession['user_id'];
        $status = 0;

        activity_log($action,$userid,$status,$date);
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }
    function mail_exisits($mail){

        $qry = "select * from  gp_pl_channel_partner where email = '$mail' and is_del = '0'";
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
    function get_all_purchasenotification(){
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['user_id'];

        $qry = "select noty.id as noty_id,noty.wallet_total,noty.bill_total,noty.channel_partner_id, noty.wallet_total, noty.bill_total, DATE_FORMAT(noty.purchased_on, '%Y-%m-%d') as purchased, cus.email, n.name, n.phone from gp_purchase_bill_notification noty left join gp_pl_channel_partner con on con.id = noty.channel_partner_id left join gp_login_table cus on cus.id = noty.login_id LEFT JOIN gp_normal_customer n on n.id = cus.user_id where con.id = '$loginuser' and noty.`status` = 0";
        $qry = $this->db->query($qry);
       //echo $this->db->last_query(); exit;
        if($qry->num_rows()>0)
        {
           // $data['noti']= $qry->result_array();
            $data = $qry->result_array();
        } else
        {
          //  $data['noti']=array();
            $data =array();
        }

        return $data;
    }
    function purchase_otp_confirmation($purcid){
        $data=array(
            'status'=>"1",
        );
        $this->db->where('id',$purcid);
        $query=$this->db->update('gp_purchase_bill_notification',$data);
        return $query;
    }
    function purchase_approval_by_otp(){
        $purcid=$this->input->post('hiddenotp');
        $otp=$this->input->post('purchase_otp');
        $qry="select * from gp_purchase_bill_notification where otp='$otp' and id='$purcid'";
        $res=$this->db->query($qry);
       // echo $this->db->last_query();exit();
        if($res->num_rows()>0){
           $update = $this->purchase_otp_confirmation($purcid);
           if($update)
           {
                return $res->row_array();
           } else{
                return false;
           }
            
        }
        else{
            return false;
        }
    }
    /*
    function get_saled_cat($cp_con_id){
        $get_cat = "select
                *
                from
                gp_pl_channel_partner_type_connection con
                where con.id ='$cp_con_id'";
        $get_cat = $this->db->query($get_cat);
        if($get_cat->num_rows()>0)
        {
            $no_cat = $get_cat->row_array();
            $cat_level = $no_cat['category_level'];
            if($cat_level == 0){
            }else{
                $qry = "select
                *
                from
                gp_channel_con_cat_commision com
                where com.cp_con_id = '$cp_con_id'";
                $qry = $this->db->query($qry);
                if($qry->num_rows()>0)
                {
                    return $qry->result_array();
                }   else{
                    return array();
                }  
            } 
        }   else{
             return array();
        }        
    }
    */
    function get_saled_cat($cp_con_id){   
        $qry = "select
                *
                from
                gp_channel_con_cat_commision com
                where com.cp_con_id = '$cp_con_id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
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
    function get_cat_level($con_id){
        $qry = "select
                con.id,
                con.category_level,
                cat.id as cat_id,
                cat.category_title,
                cat.percentage,
                sttgs.pooling_commission,
                sttgs.id as sttgs_id
                from
                gp_pl_channel_partner_type_connection con
                left join gp_channel_con_cat_commision cat on cat.cp_con_id = con.id
                left join gp_pl_system_commission_settings sttgs on sttgs.channel_partner_con_id = con.id
                where con.id = '$con_id'
                group by cat.id";
         $qry = $this->db->query($qry);
        // echo $this->db->last_query();
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
    }
    function get_only_one_cat($con_id){
        $qry = "select
                *
                from
                gp_pl_channel_partner_type_connection con
                where con.id ='$con_id'";
        $qry = $this->db->query($qry);
         if($qry->num_rows()>0)
        {
            return $qry->row_array();
        }else{
            return array();
        } 
    }
    function get_cpcustomer_mailid(){
        $session_data=$this->session->userdata('logged_in_admin');
        $loginid=$session_data['id'];
        $qry="select

            cus.name,cus.email

            from

            gp_pl_channel_partner_type_connection con

            left join gp_purchase_bill_notification noti on noti.channel_partner_conn_id=con.id


            left join gp_login_table logg on logg.id=noti.login_id

            left join gp_normal_customer cus on cus.id=logg.user_id

             where con.channel_partner_id='$loginid' and logg.is_del='0'

             ";
        $res=$this->db->query($qry);
        if($res->num_rows()>0){
            $data['cus']=$res->result_array();
        }
        else{
            $data['cus'] = array();
        }
        return $data;
    }
    function get_cpcustomer_connid(){
        $session_data=$this->session->userdata('logged_in_admin');
        $loginid=$session_data['id'];
        $qry="select

            cus.name,cus.email,logg.id logid,con.id conid

            from

            gp_pl_channel_partner_type_connection con

            left join gp_purchase_bill_notification noti on noti.channel_partner_conn_id=con.id

            left join gp_login_table logg on logg.id=noti.login_id

            left join gp_normal_customer cus on cus.id=logg.user_id

             where con.channel_partner_id='$loginid' and logg.is_del='0'

             ";
        $res=$this->db->query($qry);
        if($res->num_rows()>0){
            $data['cus']=$res->result_array();
        }
        else{
            $data['cus'] = array();
        }
        return $data;
    }
    function send_notification_customer(){

        $customers=$this->input->post('customer');
        $connid=$this->input->post('connctid');
        $cur_date=date('Y-m-d H:i:s');

        foreach($customers as $key => $cusid){
            $data[]=array(
                'channel_partner_conn_id'=>$connid[$key],
                'login_id'=>$cusid,
                'notification'=>$this->input->post('notification'),
                'notification_date'=>$cur_date,
                'status'=>"0",
                'created_on'=>$cur_date
            );

        }
        $this->db->insert_batch('g_customer_notificaion',$data);
        return true;
    }
    function get_cpcustomer_notidetails(){
        $session_data=$this->session->userdata('logged_in_admin');
        $login_user=$session_data['id'];
        $qry="select users.name,users.email,noti.notification,noti.notification_date from g_customer_notificaion noti
                left join gp_login_table logg on logg.id=noti.login_id
                left join gp_normal_customer users on users.id=logg.user_id
                left join gp_pl_channel_partner_type_connection conn on conn.id=noti.channel_partner_conn_id
                where conn.channel_partner_id='$login_user' order by noti.id desc";
        $res=$this->db->query($qry);
        if($res->num_rows()>0){
            $data['cus']=$res->result_array();
        }
        else{
            $data['cus'] = array();
        }
        return $data;
    }
    function updatewallet($noty_id, $total_discount, $data){
        $this->db->trans_begin();
        $com = get_commission();
        $company_per =  $com['company_commission']; $customer_per = $com['customer_commission'];
        $discount = ($total_discount * $customer_per) / 100;
        $company = ($total_discount * $company_per) / 100;
        //echo $discount;echo $company;exit();
        //update  logged in  customer reward wallete
        $qry = "select * from gp_purchase_bill_notification where id ='$noty_id'";
        $qry = $this->db->query($qry);
        //echo $this->db->last_query();
        if($qry->num_rows()>0)
        {
            $purchase = $qry->row_array();
            $cus_login_id = $purchase['login_id'];
           // $cp_con_id = $purchase['channel_partner_conn_id'];
            $wallet_transfered = $purchase['wallet_total'];
            $this->db->where('id', $noty_id);
            $upqry = $this->db->update('gp_purchase_bill_notification', $data);
          //  echo $this->db->last_query();exit();
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
            
           // echo $this->db->last_query();exit;
            $wal_activityss = array(
                'wallet_type_id' => 2,
                'wallet_val_id' => $wal_id,
                'user_id' => $cus_login_id,
                'change_value' => $discount,
                'type'=>'GAIN',
                'date_modified' => date('Y-m-d h:i:s'),
                'description' => 'Reward when item purchased'
                );
            $this->db->insert('gp_wallet_activity', $wal_activityss);
        //    echo $this->db->last_query();exit;
                $cp_id = $purchase['channel_partner_id'];
                $getcp_qry = "select
                                l.id as lg_id
                                from
                                 gp_login_table l 
                                where l.user_id = '$cp_id'";
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
                   $wal_activitys = array(
                        'wallet_type_id' => 4,
                        'user_id' => $cplg_id,
                        'change_value' => $wallet_transfered,
                        'type'=>'GAIN',
                        'date_modified' => date('Y-m-d h:i:s'),
                        'description' => 'One user transfered wallet Amount for a purchase'
                      );
                 $this->db->insert('gp_wallet_activity', $wal_activitys);
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
                  $wal_id = $res['wallet_id'];
                  $wal_val = $res['wallet_value'];
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
                'type'=>'LOSS',
                'date_modified' => date('Y-m-d h:i:s'),
                'description' => 'Reduced when item purchased'
                );
                $this->db->insert('gp_wallet_activity', $wal_activitysss);

                }
               
            }else{
                $result = array();
            }  
                $pooling_commision = $company; 
                // Pooling
                $grp_sttgs = $this->get_pooling_settings();
//var_dump($grp_sttgs);exit;
                foreach ($grp_sttgs as $key => $sttgs)
                {
                   
                    $grp_id = $sttgs['id'];
                    $related_to = $sttgs['related_to'];
                    $llogin_id = ($related_to=='CHANNEL_PARTNER')?$cplg_id:$cus_login_id;
                    //var_dump($cus_login_id);//exit();
                    $perc_each_grp = ($pooling_commision * $sttgs['percentage'])/100;
                    $sel_gp_memb = "select * from gp_pl_pool_members_settings gp_stg left join gp_pl_sales_designation_type sdt ON gp_stg.designation_type_id=sdt.id where gp_stg.pool_settings_id = '$grp_id'  order by sdt.sort_order ASC";
                    $sel_gp_memb = $this->db->query($sel_gp_memb);
                    if($sel_gp_memb && $sel_gp_memb->num_rows()> 0)
                    {
                        $pool_eff_membs = $sel_gp_memb->result_array();
                        $new_id = 0;
                       // var_dump($pool_eff_membs);exit;
                        foreach ($pool_eff_membs as $key => $pool_eff_memb)
                        {
                            if($key == 0){
                               $old_id = $llogin_id;
                            }else{
                                $old_id = $new_id;
                            }
                            $desig_type = $pool_eff_memb['designation_type_id'];//exit;
                       


                                $pool_perc = $pool_eff_memb['percentage'];
                                $parent_reward_rs = ($pool_perc * $perc_each_grp)/100;
                                $old_id = $old_id + $new_id - $new_id;
                                $get_parent_id_qry = "select * from gp_login_table where id = '$old_id'";
                                $get_parent_id_qry = $this->db->query($get_parent_id_qry);
                                if($get_parent_id_qry && $get_parent_id_qry->num_rows() >0)
                                {
                                    $get_login_details = $get_parent_id_qry->row_array();
                                    $new_id = $get_login_details['parent_login_id'];

                                       if($new_id == 0)
                                        {
                                            // update admin wallet
                                            $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                            $this->db->where('user_id', 13);
                                            $this->db->where('wallet_type_id', 4);
                                            $this->db->update('gp_wallet_values');
                                            //echo $this->db->last_query();
                                            $wal_activitys = array(
                                                'wallet_type_id' => 4,
                                                'user_id' => 13,
                                                'change_value' => $parent_reward_rs,
                                                'type'=>'GAIN',
                                                'date_modified' => date('Y-m-d h:i:s'),
                                                'description' => 'Reward when Parent is zero group Pooling'
                                            );
                                        $this->db->insert('gp_wallet_activity', $wal_activitys);
                                        } else
                                        {
                                            $lg_qry = "select * from gp_login_table lg where lg.id = '$new_id'";

                                            $lg_qry = $this->db->query($lg_qry);
                                            if($lg_qry && $lg_qry->num_rows()>0)
                                            {
                                                $lg_result = $lg_qry->row_array();
                                                $lg_id = $lg_result['id'];
                                                $lg_user_id = $lg_result['user_id'];
                                               
                                                $type = $lg_result['type'];

                                               
                                                //var_dump($type);exit;
                                                if($type=='executive')
                                                {
                                                    $exe_qry =  "select t.id as sales_desig_type_id, t.type from gp_pl_sales_team_members mem LEFT JOIN gp_pl_sales_designation_type t on mem.sales_desig_type_id= t.id where mem.id = '$lg_user_id'";

                                                }
                                                else{
                                                      $exe_qry =  "select t.id as sales_desig_type_id, mem.type from gp_normal_customer mem LEFT JOIN gp_pl_sales_designation_type t on mem.type = t.slug  where mem.id = '$lg_user_id'";
                                                }
                                                $exe_qry = $this->db->query($exe_qry);
                                                //echo $this->db->last_query();//exit;
                                                if($exe_qry && $exe_qry->num_rows()>0)
                                                {
                                                    $res_exe = $exe_qry->row_array();
                                                    $exe_desig_id = $res_exe['sales_desig_type_id'];
                                                     $stype = $res_exe['type'];
                                                     $wallet_type = ($stype=='executive') ? 3 : 2;
                                                    // var_dump($stype);var_dump($wallet_type);
                                                    if($exe_desig_id == $desig_type)
                                                    {
                                                             
                                                                $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                                $this->db->where('user_id', $new_id);
                                                                $this->db->where('wallet_type_id', $wallet_type);
                                                                $this->db->update('gp_wallet_values');
                                                                //echo $this->db->last_query();
                                                                $wal_activity = array(
                                                                    'wallet_type_id' => $wallet_type,
                                                                    'user_id' => $new_id,
                                                                    'change_value' => $parent_reward_rs,
                                                                    'type'=>'GAIN',
                                                                    'date_modified' => date('Y-m-d h:i:s'),
                                                                    'description' => 'Reward when chiled purchased'
                                                                    );
                                                                $this->db->insert('gp_wallet_activity', $wal_activity); 

                                                        
                                                    } else
                                                    {
                                                        $get_new_id = $this->get_parent_from_login($lg_id, $desig_type,$parent_reward_rs);
                                                        //var_dump($get_new_id);exit;
                                                        $get_parent_id_qry1 = "select * from gp_login_table where id = '$get_new_id'";
                                                        $get_parent_id_qry1 = $this->db->query($get_parent_id_qry1);
                                                        if($get_parent_id_qry1->num_rows() >0)
                                                        {
                                                            $get_login_details1 = $get_parent_id_qry1->row_array();
                                                            $typee = $get_login_details1['type'];
                                                            $wallet_type = ($typee=='executive') ? 3 : 2;
                                                        }
                                                       // var_dump($get_new_id);
                                                        $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                        $this->db->where('user_id', $get_new_id);
                                                        $this->db->where('wallet_type_id', $wallet_type);
                                                        $this->db->update('gp_wallet_values');
                                                        //echo $this->db->last_query();
                                                        $wal_activity = array(
                                                            'wallet_type_id' => $wallet_type,
                                                            'user_id' => $get_new_id,
                                                            'change_value' => $parent_reward_rs,
                                                            'type'=>'GAIN',
                                                            'date_modified' => date('Y-m-d h:i:s'),
                                                            'description' => 'Reward when chiled purchased'
                                                            );
                                                        $this->db->insert('gp_wallet_activity', $wal_activity);
                                                        
                                                    }

                                                }else{
                                                    $res_exe = array();

                                                    //get reward to admin when no sales members

                                                    // update admin wallet
                                                    $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                    $this->db->where('user_id', 13);
                                                    $this->db->where('wallet_type_id', 4);
                                                    $this->db->update('gp_wallet_values');
                                                    //echo $this->db->last_query();
                                                    $wall_activitys = array(
                                                        'wallet_type_id' => 4,
                                                        'user_id' => 13,
                                                        'change_value' => $parent_reward_rs,
                                                        'type'=>'GAIN',
                                                        'date_modified' => date('Y-m-d h:i:s'),
                                                        'description' => 'get reward to admin when no sales members'
                                                    );
                                                    $this->db->insert('gp_wallet_activity', $wall_activitys);

                                                }

                                                
                                            } else{
                                                $lg_result = array();
                                                // get reward to admin when no user
                                                // update admin wallet
                                                $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                $this->db->where('user_id', 13);
                                                $this->db->where('wallet_type_id', 4);
                                                $this->db->update('gp_wallet_values');
                                                //echo $this->db->last_query();
                                                $wall_activitys = array(
                                                    'wallet_type_id' => 4,
                                                    'user_id' => 13,
                                                    'change_value' => $parent_reward_rs,
                                                    'type'=>'GAIN',
                                                    'date_modified' => date('Y-m-d h:i:s'),
                                                    'description' => 'get reward to admin when no sales members'
                                                );
                                                $this->db->insert('gp_wallet_activity', $wall_activitys);
                                            }
                                        }
                                        
                                                                      
                                }else{
                                    // get reward to admin when no parent
                                    // update admin wallet
                                    $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                    $this->db->where('user_id', 13);
                                    $this->db->where('wallet_type_id', 4);
                                    $this->db->update('gp_wallet_values');
                                    //echo $this->db->last_query();
                                    $wall_activitys = array(
                                        'wallet_type_id' => 4,
                                        'user_id' => 13,
                                        'change_value' => $parent_reward_rs,
                                        'type'=>'GAIN',
                                        'date_modified' => date('Y-m-d h:i:s'),
                                        'description' => 'get reward to admin when no parent'
                                    );
                                    $this->db->insert('gp_wallet_activity', $wall_activitys);
                                }                                                       

                        }
                   
                    }else{
                        $pool_eff_membs = array();
                    }
                    

                }
              
         //end  effect pooling parents walletes when using purchases
        }else{
           $purchase = array();
        } 
         //return true;
        $this->db->trans_complete();
         if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
    
    function get_parent_from_login($login_id, $desig_type_id,$parent_reward_rs){      
        $qry = "select * from gp_login_table lg where lg.id = '$login_id'";       
        $lg_qry = $this->db->query($qry);
        if($lg_qry && $lg_qry->num_rows()>0)
        {

            $lg_result = $lg_qry->row_array();
            $parent_id = $lg_result['parent_login_id'];
            //var_dump($parent_id);exit();
            if($parent_id == 0){
                // update admin wallet
                $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                $this->db->where('user_id', 13);
                $this->db->where('wallet_type_id', 4);
                $this->db->update('gp_wallet_values');
                
                $wal_activitys = array(
                    'wallet_type_id' => 4,
                    'user_id' => 13,
                    'change_value' => $parent_reward_rs,
                    'type'=>'GAIN',
                    'date_modified' => date('Y-m-d h:i:s'),
                    'description' => 'Reward when chiled purchased'
                );
                $this->db->insert('gp_wallet_activity', $wal_activitys);
                return true;
            }else{
                $get_parent_id_qry1 = "select * from gp_login_table where id = '$parent_id'";
                $get_parent_id_qry1 = $this->db->query($get_parent_id_qry1);
                if($get_parent_id_qry1->num_rows() >0)
                {
                    $get_login_details1 = $get_parent_id_qry1->row_array();
                    $type = $get_login_details1['type'];
                }
                    // $lg_user_id = $lg_result['user_id'];
                    // $parent_id = $lg_result['parent_login_id'];
                    //$type = $lg_result['type'];
                
                        if($type=='executive')
                        {
                            $exe_qry =  "select t.id as sales_desig_type_id, t.type, l.id as login_id from gp_login_table l left join gp_pl_sales_team_members mem on l.user_id = mem.id LEFT JOIN gp_pl_sales_designation_type t on mem.sales_desig_type_id= t.id where l.id = '$parent_id' and l.type = 'executive'";

                        }
                        else{
                              $exe_qry =  "select t.id as sales_desig_type_id, mem.type, l.id as login_id from gp_normal_customer mem LEFT JOIN gp_pl_sales_designation_type t on mem.type = t.slug left join gp_login_table l on l.user_id = mem.id where l.id = '$parent_id' and l.type not in ('executive','super_admin')";
                        }
                        $exe_qry = $this->db->query($exe_qry);
                        //echo $this->db->last_query();exit();
                        if($exe_qry && $exe_qry->num_rows()>0)
                        {
                            $result_sales = $exe_qry->row_array();
                            $desig_id = $result_sales['sales_desig_type_id'];
                            $des_type = $desig_type_id;
                            //var_dump($desig_id);var_dump($des_type);exit();
                            if($des_type == $desig_id)
                            {
                                return $parent_id;

                            } else{
                                return  $this->get_parents_login($parent_id, $desig_type_id,$parent_reward_rs);
                            }
                        }else{
                            return array();
                        }
                       
            }


        } else{
            $lg_result = array();
        }   
    }
    function get_parents_login($parent_id, $desig_type_id,$parent_reward_rs){
        $qry = "select * from gp_login_table lg where lg.id = '$parent_id'";
        $lg_qry = $this->db->query($qry);
        //echo $this->db->last_query();exit();
        if($lg_qry && $lg_qry->num_rows()>0)
        {
            $lg_result = $lg_qry->row_array();
            $lg_id = $lg_result['id'];
           return $this->get_parent_from_login($lg_id,$desig_type_id,$parent_reward_rs);
        }else{
           return $this->get_parent_from_login($parent_id,$desig_type_id,$parent_reward_rs);
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
    function get_pooling_stage__settings(){
        $qry_stg_pool_set = "select stg.id, stg.title, stg.stage_group_persentage,stg.no_of_levels from gp_pl_pool_stage_group_settings stg";
        $qry_stg_pool_set = $this->db->query($qry_stg_pool_set);
        if($qry_stg_pool_set->num_rows()>0)
        {
            return $qry_stg_pool_set->result_array();
        }else{
            return array();
        }
    }


function get_recent_activity()
    {
        $qry = "select * from 
                gp_activity_log
                left join gp_login_table  on gp_activity_log.id = gp_login_table.id
                where gp_activity_log.id  order by  gp_activity_log.id  desc limit 5";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        } else{
            return array();
        }       
    }

    //chanel partner incentive wallet graph
function  get_graph_data()
{

}












}
?>