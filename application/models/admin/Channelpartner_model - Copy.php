<?php
Class Channelpartner_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();
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
    function get_partner_type(){
        $qry="select ct.id,ct.title from gp_pl_channel_partner_types ct where ct.is_del='0' order by ct.id desc";
        $qry=$this->db->query($qry);
        if($qry){
            $data['type']=$qry->result_array();
        }
        else{
            $data['type']=array();
        }
        return $data;
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
    $qry="SELECT p.id, p.title, p.description, p.parent, e.title AS ptitle
    FROM gp_pl_channel_partner_types e
    INNER JOIN gp_pl_channel_partner_types p 
    ON p.parent = e.id WHERE p.parent!=0";
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
    function add_partner($password){
        $p1='s';
        $p2='a';
        $email=$this->input->post('email');
        
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
            move_uploaded_file($_FILES['bri']['tmp_name'],"upload/".$p2);
        }
        $this->db->trans_begin();
        $data=array(
            'name'=>$this->input->post('name'),
            'phone'=>$this->input->post('phone'),
            'email'=>$this->input->post('email'),
            'address'=>$this->input->post('address'),
            'module'=>$this->input->post('module'),
            'cname'=>$this->input->post('cname'),
            'lattitude'=>$this->input->post('latt'),
            'longitude'=>$this->input->post('long'),
            'profile_image'=> $p1,
            'brand_image'=> $p2
        );
        $this->db->insert('gp_pl_channel_partner',$data);
        $last_channelid=$this->db->insert_id();


               // $action = "added Channelpartner  ";
               // $loginsession = $this->session->userdata('logged_in_admin');

               // $userid=$loginsession['user_id'];
               // $status = 0;

               // activity_log($action,$userid,$status);





        $channel_type=$this->input->post('channel_type');
        foreach($channel_type as $type){
            $data=array(
                'channel_partner_type_id'=>$type,
                'channel_partner_id'=>$last_channelid
            );
            $this->db->insert('gp_pl_channel_partner_type_connection',$data);
        }
        $this->load->helper('string');
        $logindata=array(
            'email'=>$this->input->post('email'),
            'mobile'=>$this->input->post('phone'),
            'password'=>$password,
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
         $channelpsw['psw']= $password;
         
        $qry3 = $this->db->insert_batch('gp_wallet_values', $wallete);
        $session_data=$this->session->userdata('logged_in_admin');
        $typ = $session_data['type'];
        if($typ = 'executive')
        {
             $qry_a = $this->get_cp_promotion_count();
        }
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
    function add_partner1($password){
        $email=$this->input->post('email');

        $this->db->trans_begin();
        $data=array(
            'name'=>$this->input->post('name'),
            'phone'=>$this->input->post('phone'),
            'email'=>$this->input->post('email'),
            'fax'=>$this->input->post('fax'),
            'address'=>$this->input->post('address')
        );
        $b[0]=$data;
        $this->db->insert('gp_pl_channel_partner',$data);
        $last_channelid=$this->db->insert_id();
        $channel_type=$this->input->post('channel_type');
        // print_r($channel_type);
        // echo $last_channelid; exit();
        $a=1;
        foreach($channel_type as $type){
            $data=array(
                'channel_partner_type_id'=>$type,
                'channel_partner_id'=>$last_channelid
            );
            $b[$a]=$data;
            $a=$a+1;
            // $this->db->insert('gp_pl_channel_partner_type_connection',$data);
        }
        print_r($b[0]);
        $c=$a;
        while(0<$a){
        print_r($b[$a-1]); 
        $a=$a-1;}
        echo $c,$last_channelid; exit();
        $this->load->helper('string');
        
        $logindata=array(
            'email'=>$this->input->post('email'),
            'mobile'=>$this->input->post('phone'),
            'password'=>$password,
            'user_id'=>$last_channelid,
            'type'=>"Channel_partner"
        );
        print_r($logindata); exit();
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
         $channelpsw['psw']= $password;

        $qry3 = $this->db->insert_batch('gp_wallet_values', $wallete);
        $session_data=$this->session->userdata('logged_in_admin');
        $typ = $session_data['type'];
        if($typ = 'executive')
        {
             $qry_a = $this->get_cp_promotion_count();
        }
       


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
    function get_all_partnertype(){
        $qry="select * from gp_pl_channel_partner_types ct where ct.is_del='0' order by ct.id desc";
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
                   
         if($desig_qry->num_rows()>0)
        {
            $current_desig_arr = $desig_qry->row_array();
            $current_desig = $current_desig_arr['sales_desig_type_id'];

        } else{
            $current_desig_arr = array();
        }  
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
    function get_edit_partnertypebyid(){
        $this->db->trans_begin();
        $id=$this->input->post('hiddentype');
        $data=array(
            'title'=>$this->input->post('title'),
            // 'email'=>$this->input->post('email'),
            'description'=>$this->input->post('descriptext')
            // 'name'=>$this->input->post('name'),
            // 'parent_id'=>$this->input->post('parent'),
            // 'last_promotion_date'=>$this->input->post('lpd'),
            // 'phone'=>$this->input->post('phone'),
            // 'address'=>$this->input->post('add'),
            // 'fax'=>$this->input->post('fax'),
            // 'status'=>$this->input->post('stat')
        );
        print_r($data); echo $id; exit();
        $this->db->where('id',$id);
        $this->db->update('gp_pl_channel_partner_types',$data);
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
    function delete_partnertypebyid(){
        $id=$this->input->post('hiddentype');

        $data=array(
            'is_del'=>"1",

        );

        $qry = $this->db->where('id', $id);
        $qry = $this->db->update('gp_pl_channel_partner_types', $data);
        /// $qury;

            $date = date("Y-m-d h:i:sa") ;
            $action = "delete parntertype ";
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);

        return $qry;
    }
    function get_channerpartner(){
        // $qry="select chp.id,chp.name,chp.phone,chp.phone2,chp.email,chp.fax,chp.address,GROUP_CONCAT(ctype.title) from gp_pl_channel_partner chp
        //         left join gp_pl_channel_partner_type_connection typid on typid.channel_partner_id=chp.id
        //         left join gp_pl_channel_partner_types ctype on ctype.id=typid.channel_partner_type_id and ctype.is_del='0'
        //         where chp.is_del='0'
        //         order by chp.id desc";
        $qry = "select
                cp.id as cp_id,
                cp.name, cp.phone,
                cp.phone2,
                cp.email,
                cp.fax,
                cp.address,
                GROUP_CONCAT(typ.title) as cp_type, 
                typ.description
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
    function get_channerpartner_byid($id){
        $qry="select chp.id,chp.name,chp.phone,chp.phone2,chp.email,chp.fax,chp.address,GROUP_CONCAT(ctype.title) from gp_pl_channel_partner chp
                left join gp_pl_channel_partner_type_connection typid on typid.channel_partner_id=chp.id
                left join gp_pl_channel_partner_types ctype on ctype.id=typid.channel_partner_type_id and ctype.is_del='0'
                where chp.is_del='0' and chp.id='$id'";
        $query=$this->db->query($qry);
        if($query){
            $data['partner']=$query->row_array();
        }
        else{
            $data['partner']=array();
        }
        return $data;
    }
    function edit_partnerbyid(){
        $this->db->trans_begin();
        $hiddenid=$this->input->post('hiddenid');
        $data=array(
            'name'=>$this->input->post('name'),
            'phone'=>$this->input->post('phone'),
            'phone2'=>$this->input->post('phone2'),
            'email'=>$this->input->post('email'),
            'fax'=>$this->input->post('fax'),
            'address'=>$this->input->post('address')
        );
        $this->db->where('id',$hiddenid);
        $this->db->update('gp_pl_channel_partner',$data);

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
    function delete_partnerbyid($id){

        $data=array(
            'is_del'=>"1",

        );

        $qry = $this->db->where('id', $id);
        $qry = $this->db->update('gp_pl_channel_partner', $data);

            $date = date("Y-m-d h:i:sa") ;
            $action = "delete parnter ";
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
            
        return $qry;
    }
    function mail_exisits($mail){

        $qry = "select * from gp_login_table where email = '$mail'";
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

        // $qry = "select logid.mobile,logid.email,noti.wallet_total,noti.id notiid from gp_purchase_bill_notification noti
        //         left join gp_pl_channel_partner_type_connection conid on conid.id=noti.channel_partner_conn_id
        //         left join gp_pl_channel_partner cp on cp.id=conid.channel_partner_id
        //         left join gp_login_table logid on logid.id=noti.customer_id
        //         where logid.id='$loginuser' and noti.status='0'";
        $qry = "select
                noty.id as noty_id,noty.wallet_total,noty.bill_total,
                noty.channel_partner_conn_id,
                noty.wallet_total,
                noty.bill_total,
                DATE_FORMAT(noty.purchased_on, '%Y-%m-%d') as purchased,
                cus.name,
                cus.phone,
                cus.email
                from
                gp_purchase_bill_notification noty
                left join gp_pl_channel_partner_type_connection con on con.id = noty.channel_partner_conn_id
                left join gp_normal_customer cus on cus.id = noty.login_id
                where con.channel_partner_id = '$loginuser' and noty.`status` = 0";
        $qry = $this->db->query($qry);
       // echo $this->db->last_query(); exit;
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
    function updatewallet($noty_id, $discount, $data){
        $this->db->trans_begin();
        //update  logged in  customer reward wallete
        $qry = "select * from gp_purchase_bill_notification where id ='$noty_id'";
        $qry = $this->db->query($qry);
        //   echo $this->db->last_query();
        if($qry->num_rows()>0)
        {
            $purchase = $qry->row_array();
            $cus_login_id = $purchase['login_id'];
            $cp_con_id = $purchase['channel_partner_conn_id'];
            $wallet_transfered = $purchase['wallet_total'];
            $this->db->where('id', $noty_id);
            $upqry = $this->db->update('gp_purchase_bill_notification', $data);
          // echo $this->db->last_query();
            $this->db->set('total_value', 'total_value + ' . (float) $discount, FALSE);
            $this->db->where('user_id', $cus_login_id);
            $this->db->where('wallet_type_id', 2);
            $this->db->update('gp_wallet_values'); 

            $wal_activityss = array(
                'wallet_type_id' => 2,
                'user_id' => $cus_login_id,
                'change_value' => $discount,
                'date_modified' => date('Y-m-d h:i:s'),
                'description' => 'Reward when item purchased'
                );
            $this->db->insert('gp_wallet_activity', $wal_activityss);
        //end update  logged in  customer reward wallete

            // Insert money into channel partner wallet 
                $getcp_qry = "select
                                cp.id cp_id,
                                l.id as lg_id
                                from
                                gp_pl_channel_partner_type_connection co
                left join gp_pl_channel_partner cp on cp.id = co.channel_partner_id
                left join gp_login_table l  on l.user_id = cp.id and l.`type` = 'Channel_partner'
                                where co.id = '$cp_con_id'";
                $getcp_qry = $this->db->query($getcp_qry);
                if($getcp_qry->num_rows()>0)
                {
                    $cpdetails = $getcp_qry->row_array();
                    $cplg_id = $cpdetails['lg_id'];

                    $this->db->set('total_value', 'total_value - ' . (float) $wallet_transfered, FALSE);
                    $this->db->where('user_id', $cplg_id);
                    $this->db->where('wallet_type_id', 4);
                    $this->db->update('gp_wallet_values'); 
                    //echo $this->db->last_query();
                   $wal_activitys = array(
                        'wallet_type_id' => 4,
                        'user_id' => $cplg_id,
                        'change_value' => $wallet_transfered,
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

                $this->db->set('total_value', 'total_value - ' . (float) $wal_val, FALSE);
                $this->db->where('id', $wal_id);
                $this->db->update('gp_wallet_values'); 
                //echo $this->db->last_query();
                $wal_activitysss = array(
                'wallet_val_id' => $wal_id,
                'change_value' => $wal_val,
                'date_modified' => date('Y-m-d h:i:s'),
                'description' => 'Reduced when item purchased'
                );
                $this->db->insert('gp_wallet_activity', $wal_activitysss);

                }
               
            }else{
                $result = array();
            }     
            //end update reduce  logged in  customer  walletes when using purchases

            // effect pooling parents walletes when using purchases
            $get_pool_comm = "select * from gp_pl_system_commission_settings stg where stg.channel_partner_con_id = '$cp_con_id'";
            $get_pool_comm = $this->db->query($get_pool_comm);
            if($get_pool_comm->num_rows()>0)
            {
                $pool_result = $get_pool_comm->row_array();
                $pooling_commision_perc = $pool_result['pooling_commission'];
                $bill_amount = $data['bill_total'];
                $pooling_commision = ($bill_amount * $pooling_commision_perc)/100;

                // group Pooling
                $grp_sttgs = $this->get_pooling_group_settings();

                foreach ($grp_sttgs as $key => $sttgs)
                {
                   
                    $grp_id = $sttgs['id'];
                    $perc_each_grp = ($pooling_commision * $sttgs['group_persentage'])/100;
                    $sel_gp_memb = "select * from gp_pl_pool_group_members_settings gp_stg where gp_stg.group_id = '$grp_id'";
                    $sel_gp_memb = $this->db->query($sel_gp_memb);
                    if($sel_gp_memb && $sel_gp_memb->num_rows()> 0)
                    {
                        $pool_eff_membs = $sel_gp_memb->result_array();
                        $new_id = 0;
                        foreach ($pool_eff_membs as $key => $pool_eff_memb)
                        {
                            if($key == 0){
                               $old_id = $cus_login_id;
                            }else{
                                $old_id = $new_id;
                            }
                            $desig_type = $pool_eff_memb['designation_type_id'];
                       


                                $pool_perc = $pool_eff_memb['persentage'];
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
                                                $exe_qry =  "select * from gp_pl_sales_team_members mem where mem.id = '$lg_user_id'";
                                                $exe_qry = $this->db->query($exe_qry);
                                                if($exe_qry && $exe_qry->num_rows()>0)
                                                {
                                                    $res_exe = $exe_qry->row_array();
                                                    $exe_desig_id = $res_exe['sales_desig_type_id'];
                                                    if($exe_desig_id == $desig_type)
                                                    {
                                                        $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                        $this->db->where('user_id', $new_id);
                                                        $this->db->where('wallet_type_id', 2);
                                                        $this->db->update('gp_wallet_values');
                                                        //echo $this->db->last_query();
                                                        $wal_activity = array(
                                                            'wallet_type_id' => 2,
                                                            'user_id' => $new_id,
                                                            'change_value' => $parent_reward_rs,
                                                            'date_modified' => date('Y-m-d h:i:s'),
                                                            'description' => 'Reward when chiled purchased'
                                                            );
                                                        $this->db->insert('gp_wallet_activity', $wal_activity); 
                                                        
                                                    } else
                                                    {
                                                        $get_new_id = $this->get_parent_from_login($lg_id, $desig_type,$parent_reward_rs);
                                                       // var_dump($get_new_id);
                                                        $this->db->set('total_value', 'total_value + ' . (float) $parent_reward_rs, FALSE);
                                                        $this->db->where('user_id', $get_new_id);
                                                        $this->db->where('wallet_type_id', 2);
                                                        $this->db->update('gp_wallet_values');
                                                        //echo $this->db->last_query();
                                                        $wal_activity = array(
                                                            'wallet_type_id' => 2,
                                                            'user_id' => $get_new_id,
                                                            'change_value' => $parent_reward_rs,
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
               //  var_dump($perc_each_grp);exit;
               // Stage Pooling
                $stage_sttgs = $this->get_pooling_stage__settings();
                foreach ($stage_sttgs as $key => $stg_sttgs)
                {
                    $stag_id = $stg_sttgs['id'];
                    $stag_percentage = ($pooling_commision * $stg_sttgs['stage_group_persentage'])/100;
                    $sel_stage_memb = "select * from gp_pl_pool_stage_members_settings stg_mem where stg_mem.system_pool_stage_id = '$stag_id'";
                    $sel_stage_memb = $this->db->query($sel_stage_memb);
                    if($sel_stage_memb && $sel_stage_memb->num_rows()> 0)
                    {
                        $stag_pool_effec = $sel_stage_memb->result_array();
                        $stg_new_id = 0;
                        foreach ($stag_pool_effec as $key => $stg_pool_eff_memb)
                        {
                            if($key == 0){
                               $stg_old_id = $cus_login_id;
                            }else{
                                $stg_old_id = $stg_new_id;
                            }
                            //$desig_type = $stg_pool_eff_memb['designation_type_id'];
                            $stg_pool_perc = $stg_pool_eff_memb['persentage'];
                            $parent_stg_reward_rs = ($stg_pool_perc * $stag_percentage)/100;
                            $stg_old_id = $stg_old_id + $stg_new_id - $stg_new_id;
                            $get_stg_parent_id_qry = "select * from gp_login_table where id = '$stg_old_id'";
                            $get_stg_parent_id_qry = $this->db->query($get_stg_parent_id_qry);
                            if($get_stg_parent_id_qry && $get_stg_parent_id_qry->num_rows() >0)
                            {   
                                $get_stg_login_details = $get_stg_parent_id_qry->row_array();
                                    $stg_new_id = $get_stg_login_details['parent_login_id'];
                                    if($stg_new_id == 0)
                                    {
                                         // update admin wallet
                                            $this->db->set('total_value', 'total_value + ' . (float) $parent_stg_reward_rs, FALSE);
                                            $this->db->where('user_id', 13);
                                            $this->db->where('wallet_type_id', 4);
                                            $this->db->update('gp_wallet_values');
                                            //echo $this->db->last_query();
                                            $wal_stg_activitys = array(
                                                'wallet_type_id' => 4,
                                                'user_id' => 13,
                                                'change_value' => $parent_stg_reward_rs,
                                                'date_modified' => date('Y-m-d h:i:s'),
                                                'description' => 'Reward when Parent is zero Stage Pooling'
                                            );
                                            $this->db->insert('gp_wallet_activity', $wal_stg_activitys);
                                    } else{
                                        $lg_stag_qry = "select * from gp_login_table lg where lg.id = '$stg_new_id'";
                                            $lg_stag_qry = $this->db->query($lg_stag_qry);
                                            if($lg_stag_qry && $lg_stag_qry->num_rows()>0)
                                            {
                                                $lg_stg_result = $lg_stag_qry->row_array();
                                                $log_stag_id = $lg_stg_result['id'];
                                                $lg_stg_user_id = $lg_stg_result['user_id'];

                                                $this->db->set('total_value', 'total_value + ' . (float) $parent_stg_reward_rs, FALSE);
                                                $this->db->where('user_id', $stg_new_id);
                                                $this->db->where('wallet_type_id', 2);
                                                $this->db->update('gp_wallet_values');
                                               // echo $this->db->last_query();
                                                $wal_stg_activitysss = array(
                                                        'wallet_type_id' => 2,
                                                        'user_id' => $stg_new_id,
                                                        'change_value' => $parent_stg_reward_rs,
                                                        'date_modified' => date('Y-m-d h:i:s'),
                                                        'description' => 'Reward when chiled purchased'
                                                        );
                                                $this->db->insert('gp_wallet_activity', $wal_stg_activitysss);

                                                
                                            }else{
                                                   // update admin wallet
                                                $this->db->set('total_value', 'total_value + ' . (float) $parent_stg_reward_rs, FALSE);
                                                $this->db->where('user_id', 13);
                                                $this->db->where('wallet_type_id', 4);
                                                $this->db->update('gp_wallet_values');
                                                //echo $this->db->last_query();
                                                $wal_stg_activityss = array(
                                                    'wallet_type_id' => 4,
                                                    'user_id' => 13,
                                                    'change_value' => $parent_stg_reward_rs,
                                                    'date_modified' => date('Y-m-d h:i:s'),
                                                    'description' => 'Reward when Parent is zero Stage Pooling'
                                                );
                                                $this->db->insert('gp_wallet_activity', $wal_stg_activityss); 

                                            }
                                    }
                            } else{
                                // update admin wallet
                                $this->db->set('total_value', 'total_value + ' . (float) $parent_stg_reward_rs, FALSE);
                                $this->db->where('user_id', 13);
                                $this->db->where('wallet_type_id', 4);
                                $this->db->update('gp_wallet_values');
                                //echo $this->db->last_query();
                                $waal_stg_activitys = array(
                                    'wallet_type_id' => 4,
                                    'user_id' => 13,
                                    'change_value' => $parent_stg_reward_rs,
                                    'date_modified' => date('Y-m-d h:i:s'),
                                    'description' => 'Reward when Parent is zero Stage Pooling'
                                );
                                $this->db->insert('gp_wallet_activity', $waal_stg_activitys);
                            }                
                        }    

                    }else {
                        $stag_poop_effec = array();
                    }

                }


            }else{

            }
         //end  effect pooling parents walletes when using purchases
        }else{
           $purchase = array();
        } 
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
    function get_pooling_group_settings(){
        $qry_pool_set = "select pl_stg.id, pl_stg.title, pl_stg.group_persentage, pl_stg.no_of_levels from gp_pl_pool_group_settings pl_stg";
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
    function get_parent_from_login($login_id, $desig_type_id,$parent_reward_rs){      
        $qry = "select * from gp_login_table lg where lg.id = '$login_id'";       
        $lg_qry = $this->db->query($qry);
        if($lg_qry && $lg_qry->num_rows()>0)
        {

            $lg_result = $lg_qry->row_array();
            $parent_id = $lg_result['parent_login_id'];
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
                    'date_modified' => date('Y-m-d h:i:s'),
                    'description' => 'Reward when chiled purchased'
                );
                $this->db->insert('gp_wallet_activity', $wal_activitys);
                return true;
            }else{
                $lg_user_id = $lg_result['user_id'];
                $exe_qry =  "select * from gp_pl_sales_team_members mem where mem.id = '$lg_user_id'";
                $exe_qry = $this->db->query($exe_qry);
                // echo '2'.$this->db->last_query();
                if($exe_qry && $exe_qry->num_rows()>0)
                {
                    $result_sales = $exe_qry->row_array();
                    $desig_id = $result_sales['sales_desig_type_id'];
                    $des_type = $desig_type_id;
                    if($des_type == $desig_id)
                    {
                        return $login_id;

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
        if($lg_qry && $lg_qry->num_rows()>0)
        {
            $lg_result = $lg_qry->row_array();
            $lg_id = $lg_result['id'];
           return $this->get_parent_from_login($lg_id,$desig_type_id,$parent_reward_rs);
        }else{
           return $this->get_parent_from_login($parent_id,$desig_type_id,$parent_reward_rs);
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