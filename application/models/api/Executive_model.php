<?php
Class Executive_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();
    
    }
    function add_executive($api_key){

    	$usr_data=user_details_by_apikey($api_key);
    	$id = $usr_data['id'];
        $name = $this->input->post('name');
        $email = $this->input->post('email');
        $mobile = $this->input->post('mobile');
        $executive_type = $this->input->post('executive_type');
        $country = $this->input->post('country');
        $state = $this->input->post('state');
        $city = $this->input->post('city');
        $address = $this->input->post('address');
        $api=apikey_generate();
        $date = date('Y-m-d');
                $data = array('sales_desig_type_id' => $executive_type,
                        'name' => $name,
                        'parent_id' => $id,
                        'created_by' => $id,
                        'created_on' => $date ,
                        'last_promotion_date' => $date 
                );
                $qry = $this->db->insert('gp_pl_sales_team_members', $data);
                $lid=$this->db->insert_id();
                        $data1 = array( 'name' => $name,
                        'phone' => $mobile,
                        'address' => $address,
                        'email' =>$email,
                        'country' =>$country,
                        'state' => $state,
                        'city' => $city,
                        'image' =>'default-avatar.png',
                        'status' => '1',
                        'sales_team_member_id' => $lid
                        );
                $qry1 = $this->db->insert('gp_pl_sales_team_member_details', $data1);
                        $data2 = array( 'parent_login_id' =>$id,
                        'email' => $email,
                        'type' => 'executive',
                        'user_id' => $lid ,
                        'api_key'=>$api,
                        'mobile'=>$mobile,
                        );
                $qry2 = $this->db->insert('gp_login_table', $data2);
                $u_id=$this->db->insert_id();
                                    $hr_ldg = array(
                                    'type_id' => $u_id,
                                    '_type' => 'EXECUTIVE',
                                    'group_id' => 25,
                                    'name' => $u_id ."_".$name.'_ledger'
                                );
                $acc_qry = $this->db->insert('erp_ac_ledgers', $hr_ldg);
                $leg_id=$this->db->insert_id();


                         $opening = array(
                                    'ledger_id' => $leg_id,
                                    'fy_id' => '1',
                                    'opening_date' =>$date
                                    );
            $open_qry = $this->db->insert('erp_ac_opening_balance', $opening);

        $data6 = array('wallet_type_id'=>'3',
            'user_id' => $u_id);
        
        $qry3 = $this->db->insert('gp_wallet_values', $data6);

        $data3 = array('wallet_type_id'=>'3',
                        'user_id' => $u_id);
                $qry3 = $this->db->insert('gp_wallet_values', $data3);

            $action = "Added Executives ";
            $date = date("Y-m-d h:i:sa") ;
            $status = 0;
        activity_log($action,$id,$status,$date);

        if ($this->db->trans_status() === TRUE)
        {
            $this->db->trans_commit();
            return $u_id;
        }else
        {
            $this->db->trans_rollback();
            return false;
        }

    } 
    function ba_validation($email,$mobile)
    {
        $data = array();
        $qry2 = "select * from pl_ba_registration where mobil_no = '$mobile' OR email ='$email'";
        $qry2 = $this->db->query($qry2);
        if($qry2->num_rows()>0)
        {
            $data['reason'] = "already Exists";
            $data['status'] = FALSE;
        } else{
            $data['status'] =  TRUE;
        }
        return $data;
    }
    function add_jaazzo_store($api_key){

    	$usr_data=user_details_by_apikey($api_key);
    	$id = $usr_data['id'];
        $created_on = date('Y-m-d H:i:s');
        $club_member=$this->input->post('club_member');
        $name=$this->input->post('name');
        $mobile=$this->input->post('mobile');
        $email=$this->input->post('email');
        $company_name=$this->input->post('company_name');
        $office_phone=$this->input->post('phone_office');
        $office_emailid=$this->input->post('email_office');
        $state=$this->input->post('state');
        $city=$this->input->post('city');
        $country=$this->input->post('country');
        $address=$this->input->post('address');
        $otp = random_string('numeric', 5);
        if($club_member ==null){
        	$parent=$id;
            $club_member=$id;
        }
        else{
        	$parent=$club_member;
        }
        $api=apikey_generate();
        $data = array(
        	'club_mem_id'=>$club_member,
            'name' => $name,
            'mobil_no' =>$mobile,
            'email' =>$email,
            'company_name' =>$company_name,
            'office_phno' =>$office_phone,
            'office_email' =>$office_emailid,
            'city' =>$city,
            'country' =>$country,
            'state' =>$state,
            'address'=>$address,
            'otp' => $otp,
            'created_on' => $created_on,
            'created_by' => $id,
        );
        

        $this->db->insert('pl_ba_registration', $data);
        $insert_id = $this->db->insert_id();
            $data3 = array(
            'email' => $email,
            'mobile' => $mobile,
            'user_id' =>$insert_id,
            'type' => 'ba',
            'otp_status' => 0,
            'api_key'=>$api,
            'parent_login_id'=>$parent
        );
        $qry3 = $this->db->insert('gp_login_table', $data3);
        $last_userid=$this->db->insert_id();
        $date = date('Y-m-d H:i:s');
        $financial_year = get_financial_year();
 
                     $hr_ldg = array(
                                    'type_id' => $last_userid,
                                    '_type' => 'JAAZZO_STORE',
                                    'group_id' => 25,
                                    'name' => $last_userid ."_".$name.'_ledger'
                                );
            $acc_qry = $this->db->insert('erp_ac_ledgers', $hr_ldg);
            $leg_id=$this->db->insert_id();


                         $opening = array(
                                    'ledger_id' => $leg_id,
                                    'fy_id' => $financial_year,
                                    'opening_date' =>$date
                                    );
            $open_qry = $this->db->insert('erp_ac_opening_balance', $opening);
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


        $qry3 = $this->db->insert_batch('gp_wallet_values', $wallete);
            $date = date('Y-m-d H:i:s');
            $action = "added ba ";
            $userid=$id;
            $status = 0;

            activity_log($action,$userid,$status,$date);


        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data['status'] = FALSE;
        } else {
            $this->db->trans_commit();
            $data['status'] = TRUE;
            $info = array('user_id' => $insert_id, 'otp' => $otp);
            $data['info'] = $info;
        }
        return $data;

    } 
    function mail_exist($mail){

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
    function mobile_exist($mob){
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
    function add_channel_partner($otp,$api_key,$qr_no,$creg,$license){

        $usr_data=user_details_by_apikey($api_key);
        $id = $usr_data['id'];

        $created_on = date('Y-m-d H:i:s');
        $api=apikey_generate();
        $channel_name = $this->input->post('channel_name');
        $string = str_replace(' ','',$channel_name);
        $myStr = substr($string, 0, 3);  
        $qrcode = strtoupper($myStr).$qr_no;

        $module = $this->input->post('module_id');
        if($usr_data['type']=='executive'){
            $parent_id=$this->input->post('selected_club_member_id');
            $club_mem_id = $this->input->post('selected_club_member_id');
        }else{
            $parent_id=$id;
            $club_mem_id = $id;
        }
      
        $data=array(
            'club_mem_id'=>$club_mem_id,
            'name'=>$channel_name,
            'club_type' => $this->input->post('club_type'),
            'email'=>$this->input->post('channel_email'),
            'phone'=>$this->input->post('contact_number'),  
            'country'=>$this->input->post('country_id'),
            'state'=>$this->input->post('state_id'),
            'lattitude'=>$this->input->post('lattitude'),
            'longitude'=>$this->input->post('longitude'),
            'town'=>$this->input->post('city_id'), 
            'area'=>$this->input->post('area'),      
            'owner_name'=>$this->input->post('owner_name'),
            'owner_email'=>$this->input->post('owner_email'),
            'owner_mobile'=>$this->input->post('owner_number'),
            'pan'=>$this->input->post('pan_number'),
            'gst'=>$this->input->post('gst_number'),
            'company_registration'=>$creg,
            'license'=>$license,
            'qr_code' =>$qrcode,
            'created_on'=>$created_on,
            'created_by'=>$id,
            'module'=>$module,
            'status'=>'NOT_APPROVED',
            'otp'=>$otp,
            'parent_id' =>$parent_id
        );
        $this->db->insert('gp_pl_channel_partner',$data);
        //echo $this->db->last_query();exit();
        $last_channelid=$this->db->insert_id();
        $channel_type=$this->input->post('channel_partner_type');
        //$channel_type=["32","12"];
        $ctype = json_decode($channel_type,true);
        //echo json_encode($ctype);exit();
        
        foreach($ctype as $key => $type){
            $data=array(
                'channel_partner_type_id'=>$type,
                'channel_partner_id'=>$last_channelid,
                'module_id' => $module
            );
            $this->db->insert('gp_pl_channel_partner_type_connection',$data);
        }
        $logindata=array(
            'email'=>$this->input->post('channel_email'),
            'mobile'=>$this->input->post('contact_number'),
            'otp_status' => 0,
            'user_id'=>$last_channelid,
            'type'=>"Channel_partner",
            'api_key'=>$api
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
        $channelpsw['email'] = $this->input->post('channel_email');
        $channelpsw['mobile'] = $this->input->post('contact_number');
        //$channelpsw['psw']= $password;

        $qry3 = $this->db->insert_batch('gp_wallet_values', $wallete);
        // $session_data=$this->session->userdata('logged_in_admin');
        // $typ = $session_data['type'];
        // if($typ = 'executive')
        // {
        //     $qry_a = $this->get_cp_promotion_count();
        // }
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

    function validate_pswd($api_key){
    $usr_data=user_details_by_apikey($api_key);
    $user_id = $usr_data['user_id'];
    $id = $usr_data['id'];
    $type = $usr_data['type'];  
    $password=$this->input->post('password');
    $psd = encrypt_decrypt('encrypt',$password);
    $query = "select * from gp_login_table u where u.password ='$psd' and u.id = $id";
        $query = $this->db->query($query);
      
        if($query->num_rows()>0)
        {
            return true;
        } else
        {
            return false;
        }

    }

    function deactivate_account($api_key){
    $usr_data=user_details_by_apikey($api_key);
    $user_id = $usr_data['user_id'];
    $id = $usr_data['id'];
    $type = $usr_data['type'];
    $comment = $this->input->post('explenation');
    $reason = $this->input->post('reason');
    $password=$this->input->post('password');
    $mail_status = isset($_POST['opt_out_promotions'])?1:0;
    
    $data=array(
            'comments'=>$comment,
            'reason'=>$reason,
            'mail_status'=>$mail_status,
            'login_id' => $id,
            'type' => $type
        );
    $this->db->insert('gp_deactivate_account',$data);

    $this->db->where('id',$id);
    $this->db->update('gp_login_table',array('is_del'=>1));
    if($type=='normal'){
           $this->db->where('id',$user_id);
    $this->db->update('gp_normal_customer',array('is_del'=>1)); 
    }
    elseif($type=='club_member'){
           $this->db->where('id',$user_id);
    $this->db->update('gp_normal_customer',array('is_del'=>1)); 
    }
    elseif($type=='Channel_partner'){
                   $this->db->where('id',$user_id);
       $this->db->update('gp_pl_channel_partner',array('is_del'=>1));
    }
    else{
    $this->db->where('id',$user_id);
    $this->db->update('gp_pl_sales_team_members',array('is_del'=>1));    
    }
    if ($this->db->trans_status() === TRUE) {
      $this->db->trans_commit();
      return true;
    } else {
      $this->db->trans_rollback();
      return false;
    }
  }
    function get_wallet_transactions($usr_data){
    
    $user_id = $usr_data['user_id'];
    $id = $usr_data['id'];
    $type = $usr_data['type'];  

    /*$main_wallet_type = $this->input->post('main_wallet_type');*/
    $wallet = $this->input->post('main_wallet_type');
    $transaction_type = $this->input->post('transaction_type');
    
    /*if($main_wallet_type == 'REWARD_WALLET'){
            $wallet='2';
    }
    if($main_wallet_type == 'CLUB_WALLET'){
               $wallet='1';
    }
    if($main_wallet_type == 'MY_WALLET'){
         $wallet='4';
    }
    if($main_wallet_type == 'INCENTIVE_WALLET'){
         $wallet='3';
    }*/
    
    $page=$this->input->post('page');
    if($transaction_type=='all'){
         $query = "select w.change_value amount ,w.date_modified as date,w.type,w.description from gp_wallet_activity w where w.user_id ='$id' and w.change_value!='0' and w.wallet_type_id='$wallet'";
        $query = $this->db->query($query);   
    }
    else{
    //$transaction_type = ($transaction_type=='paid')? 'LOSS':'GAIN';     
    $query = "select w.change_value amount ,w.date_modified as date, w.type,w.description  from gp_wallet_activity w where w.user_id ='$id' and w.type='$transaction_type' and w.wallet_type_id='$wallet' and w.change_value!='0'";
        $query = $this->db->query($query);
    }

      
    if($query->num_rows()>0)
    {
        $data['transactions']= $query->result_array();
       // $data_details11=$qry->result_array();
        $des=array();
            foreach ($data['transactions'] as $key => $value11) 
            {
             
              $value11['name']='';
              $value11['order_id']='';
              $val=$value11['type'];
              $value11['channel_partner']='';
              if($val=='LOSS'){
                $value11['type']='true';
              }
              else{
                $value11['type']='false';
              }
              $value11['ispaid']=$value11['type'];


              array_push($des, $value11);


            }
            $data['transactions']=$des;

    } else
    {
        $data['transactions']= array();
    }
    return $data;
    
    }
   function get_executive_data($api_key){
        $usr_data=user_details_by_apikey($api_key);
        
        $user_id = $usr_data['user_id'];
        $lgid = $usr_data['id'];
        //echo $user_id;exit();
        $id = $usr_data['id'];
        $type = $usr_data['type'];
  
        if($type=='executive'){
            $qry1 = $this->db->query("SELECT m.last_promotion_date,s.id,s.promotion_designation ,s.sysmodule_id FROM gp_pl_sales_team_members m left join gp_executive_promotion_settings s on m.sales_desig_type_id = s.designation_id where m.id = '$user_id'");
              
                if($qry1->num_rows()>0)
                {
                  $res1 =  $qry1->row();
                  $last_promo_date = $res1->last_promotion_date;
                  $promo_id = $res1->id;
                  $next_designation = $res1->promotion_designation;
                  $sysmodule_id= $res1->sysmodule_id;
                  $qry2 = $this->db->query("select CONCAT('Rs. ',s.amount) as target_value_1,s.amount as am ,CONCAT(s.period,' months') target_period,CONCAT(s.count,' person') target_value_2 ,s.count cou from gp_executive_promotion_details s where s.promo_id = '$promo_id' order by s.period ASC");
                  // echo  $this->db->last_query();exit();
                 
                  if($qry2->num_rows()>0){
                    $res2 =  $qry2->result_array();
                     $qry3=$this->db->query("SELECT PERIOD_DIFF(DATE_FORMAT(DATE_ADD((CASE WHEN DAY(NOW()) >= DAY(gp_pl_sales_team_members.created_on) THEN NOW() ELSE DATE_ADD(NOW(), INTERVAL -1 MONTH) END), INTERVAL -(FLOOR(PERIOD_DIFF(DATE_FORMAT(NOW(), '%Y%m'), DATE_FORMAT(gp_pl_sales_team_members.created_on, '%Y%m')) / 12)) YEAR), '%Y%m'), DATE_FORMAT(gp_pl_sales_team_members.created_on, '%Y%m')) as time_elapsed,DATEDIFF(NOW(), gp_pl_sales_team_members.created_on) - DATEDIFF(DATE_ADD(CONVERT(CONCAT(DATE_FORMAT((CASE WHEN DAY(NOW()) >= DAY(gp_pl_sales_team_members.created_on) THEN NOW() ELSE DATE_ADD(NOW(), INTERVAL -1 MONTH) END), '%Y-%m-'), RIGHT('0' + DAY(gp_pl_sales_team_members.created_on), 2)), DATE), INTERVAL -1 DAY),gp_pl_sales_team_members. created_on) as days_employed ,count(gp_customer.id) current_value_2,wallet.total_value as current_value_1
                        FROM  gp_pl_sales_team_members 
                        left join gp_login_table login on login.user_id=gp_pl_sales_team_members.id
                        left join gp_normal_customer gp_customer on gp_customer.created_by=login.id
                        left join gp_wallet_values wallet on wallet.user_id=login.id
                        where gp_pl_sales_team_members.id=$user_id and gp_customer.type='club_member'  and gp_customer.status='approved' and wallet.wallet_type_id='3'");
                        $cur =  $qry3->row_array();
                        $time_elapsed=$cur['time_elapsed'];
                        $current_value_1=$cur['current_value_1'];
                        $current_value_2=$cur['current_value_2'];
                        //echo  $this->db->last_query();exit();
                     // echo $current_value_2; exit();
                     $sub=array();
                        foreach ($res2 as $key => $value) {
                             $value['time_elapsed']=$time_elapsed;
                             $value['current_value_1']=$current_value_1;
                             $value['current_value_2']=$current_value_2;

                             if($current_value_1!='0'){
                                if( $value['am']!=0){
                                $tot=$current_value_1 / $value['am'];
                               
                               $per=$tot*100;
                                }
                                else{
                                $per='0';
                                }
                             
                             }
                             else{
                                $per='0';
                             }
                            
                            if($current_value_2!='0'){
                               $tot1=$current_value_2 / $value['cou'];
                               
                               $per1=$tot1*100;
                             }
                             else{
                                $per1='0';
                             }
                             if($per>=100){
                               $per=100;
                             }
                            if($per1>=100){
                               $per1=100;
                             }
                             $value['chart_data']=array(array("name" => "amount","value" => $per),array("name" => "count","value" =>$per1));
                             array_push($sub,$value);
                        }

                     $data['category'] = $sub;

                    
                    }else{
                      $data = array();  
                    }
                }else{
                    $data = array();
                }
                $base=base_url();
                $qryuser = $this->db->query("SELECT sd.id, sd.name firstName,CONCAT('$base','upload/exec_profile/',sd.image) as profile_image, w.total_value as my_wallet, count(gp_customer.id) as club_agents,count(gp_customer1.id) as club_members ,(select count(cp.id) from  gp_pl_channel_partner cp where cp.created_by = login.id  and cp.is_del='0' and cp.status='joined') as channel_partners ,(select  count(ba.id) from  pl_ba_registration ba where ba.created_by=login.id and ba.status='ACTIVE' and ba.is_del='0') as ba_count,
                    (select  count(gp_customer.id) from   `gp_normal_customer` gp_customer where gp_customer.created_by=login.id and gp_customer.status='approved' and gp_customer.is_del='0' and gp_customer.type='club_agent') as club_agents,(select  count(exe.id) from   `gp_pl_sales_team_members` exe where exe.created_by=login.id and exe.status='approved' and exe.is_del='0' ) as executives,dt.designation,
                    dt.add_exec
                   FROM `gp_pl_sales_team_members` m 
                    left join gp_pl_sales_team_member_details sd on m.id=sd.sales_team_member_id
                    left join gp_pl_sales_designation_type dt on m.sales_desig_type_id=dt.id
                    LEFT join gp_login_table login on login.user_id=m.id and login.type='executive'
                    left join `gp_normal_customer` gp_customer on gp_customer.created_by=login.id  and login.type='club_agent' and                  gp_customer.status='approved' and gp_customer.is_del='0' 
                    left join `gp_normal_customer` gp_customer1 on gp_customer1.created_by=login.id   and gp_customer1.status='approved' and gp_customer1.type='club_member' and gp_customer1.is_del='0' 
                     left join gp_wallet_values w on w.user_id=login.id 
                where m.id= '$user_id'");
                //echo  $this->db->last_query();exit();
                $noti = get_notification_count($lgid);

                            if($noti){
                               $noti_count= $noti->noti_count;
                            }
                            else{
                                 $noti_count = '';
                            }  
                $data1 =  $qryuser->row_array();
                $add_exe = ($data1['add_exec']==1)?true:false;
                $data1['last_name']='';
                $data1['member_type']='';
                $data1['active_friends']='';
                $data1['reffered_friends']='';
                $data1['notification_count']= $noti_count;
                $data['user']=$data1;
                $data['package']=array();
                $data['previliages']= array(
                        'add_club_member'=>true,
                        'add_executive'=>$add_exe,
                        'add_channel_partner'=>true,
                        'refer_channel_partner'=>false,
                        'add_club_agent'=>true,
                        'add_friend'=>false,
                        'add_jaazzo_store'=>true,
                        'my_reffered_channel_partners'=>true,
                        'register_channel_partner'=>true
                    );
                return $data;
        }
        elseif($type=='club_member')
        {
           
            $count=get_cmfacility_by_id($id);
            $channel_partner=$count['fixed_cp_count'];
            $club_agents=$count['ca_count'];
            $active_friends=$count['frnd_count'];
            $ba_count=$count['ba_count'];
           // echo $channel_partner;exit();
            $base=base_url();
             $qrycl = $this->db->query("SELECT cus.name firstName,cus.id,CONCAT('$base','uploads/',cus.profile_image) profile_image,wa.total_value my_wallet,login.id,cus.club_type_id ,cus.fixed_club_type_id ,cus.investor_type_id,cus.created_on,cus.fixed_join_date  FROM `gp_normal_customer` cus  
                left join gp_login_table login on login.user_id=cus.id and login.type='club_member'
                left join gp_wallet_values wa on wa.user_id=login.id and wa.wallet_type_id='4'
                where cus.id='$user_id'");
                if($qrycl->num_rows()>0){
                        $data1 =  $qrycl->row_array();
                        $cm_typez = array();

                        if($data1['fixed_club_type_id']>0){
                            $data1['member_type'] = 'fixed';
                            array_push($cm_typez, 'FIXED');
                            $fxdamt = getClubtypeById($data1['fixed_club_type_id']);
                            $fxdamount = $fxdamt['amount'];

                            $reward_per_refer_cp = $fxdamt['ref_reward_per_cp'];
                            $reward_per_cp = $fxdamt['reward_per_cp'];

                            $fixed_joind=$data1['fixed_join_date'];
                            $fix_years = round((time()-strtotime($fixed_joind))/(3600*24*365));
                            $fixed_year_limit =  $fxdamt['cash_limit'];
                            $fix_year_exceed = date('Y-m-d H:i:s',strtotime('+1 year',strtotime($fixed_joind)));
                            $fixed_wallet_used = get_wallet_used_by_member($lgid,5);
                            $fixed_wallet_details = get_fixed_wallet_details($lgid);

                            $expected_total1 = $fixed_wallet_details +$reward_per_refer_cp + $fixed_wallet_used;
                            $expected_total2 = $fixed_wallet_details +$reward_per_cp + $fixed_wallet_used;
                            $exp1 = $fixed_wallet_details+$fixed_wallet_used;
                            $allow1 = '';

                            if($exp1<$fxdamount){
                              $allow1 = 1 ;
                            }
                            if((date('Y-m-d H:i:s')<=$fix_year_exceed)&&(($expected_total1<=$fixed_amnt)|| ($allow1==1))){
                                $refer_cp = true;
                                $my_ref_cp = true;
                            }else{
                                $refer_cp = false;
                                $my_ref_cp = false;
                            }
                            if((date('Y-m-d H:i:s')<=$fix_year_exceed)&&($fixed_year_limit>=$fix_years)&& (($expected_total2<=$fixed_amnt)|| ($allow1==1))){
                                $add_cp=true;
                            }else{
                                $add_cp=false;
                            }
                            $add_exe=false;
                            // $add_cp=($fxdamt['cp_status']==1)?true:false;
                            // $refer_cp =($fxdamt['ref_cp_status']==1)?true:false;
                            // $my_ref_cp =($fxdamt['ref_cp_status']==1)?true:false;
                            $add_ca = false;
                            $add_frnd = false;
                            $add_js = false;
                        }                       
                        if($data1['club_type_id']>0){
                            $dateString=$data1['created_on'];
                            $years = round((time()-strtotime($dateString))/(3600*24*365));
                            $data1['member_type'] = 'unlimited';
                            array_push($cm_typez, 'UNLIMITED');
                            $unamt = getClubtypeById($data1['club_type_id']);
                            $umamount = $unamt['amount'];
                            $year_limit =  $unamt['cash_limit'];
                            if($year_limit>=$years){
                                $add_cp = true;
                                $refer_cp = true;
                            }else{
                                $add_cp=false;
                                $refer_cp = false;
                            }
                            // $add_cp=($unamt['cp_status']==1)?true:false;
                            $add_exe=false;
                            $add_ca = ($unamt['club_agent_status']==1)?true:false;
                            // $refer_cp = true;
                            $add_js = false;
                            $my_ref_cp = ($unamt['cp_status']==1)?true:false;
                            $add_frnd = ($unamt['user_status']==1)?true:false;
                        }
                        if($data1['investor_type_id']>0){
                            $dateString=$data1['created_on'];
                            $years = round((time()-strtotime($dateString))/(3600*24*365));
                            
                            $data1['member_type'] = 'tl_clubmember';
                            array_push($cm_typez, 'INVESTOR');
                            $insamt = getClubtypeById($data1['investor_type_id']);
                            $insamount = $insamt['amount'];
                            $year_limit =  $insamt['cash_limit'];
                            if($year_limit>=$years){
                                $add_cp = true;
                                $refer_cp = true;
                                $my_ref_cp = true;
                            }else{
                                $add_cp=false;
                                $refer_cp = false;
                                $my_ref_cp = false;
                            }
                            $add_exe=true;
                            // $add_cp=($insamt['cp_status']==1)?true:false;
                            // $refer_cp =true;$my_ref_cp =false;
                            $add_ca = ($insamt['club_agent_status']==1)?true:false;
                            $add_frnd =($insamt['user_status']==1)?true:false; 
                            $add_js =($insamt['ba_status']==1)?true:false;  
                        }
                            

                        $cmTypes = implode("','", $cm_typez);
                        $data1['last_name']='';
                        $data1['active_friends']=$active_friends;
                        $data1['reffered_friends']='';
                        $data1['notification_count']='';
                        $data1['channel_partner']=$channel_partner;
                        $data1['club_agents']=$club_agents;
                        $data1['ba_count']=$ba_count;
                        $data1['executives']=0;
                        $data1['designation']='Club Member';

                        $data['previliages']= array(
                            'add_club_member'=>false,
                            'add_executive'=>$add_exe,
                            'add_channel_partner'=>$add_cp,
                            'refer_channel_partner'=>$refer_cp,
                            'add_club_agent'=>$add_ca,
                            'add_friend'=>$add_frnd,
                            'add_jaazzo_store'=>$add_js,
                            'my_reffered_channel_partners'=>$my_ref_cp,
                            'register_channel_partner'=>false
                        );
                        $data['user']=$data1;
                        $data['category']=array();
                        $qrypac = $this->db->query("SELECT ty.id,ty.title package_name ,ty.amount amount_upper_limit,ty.type FROM `club_member_type`  ty where ty.type in ('$cmTypes') and is_del = 0");
                        if($qrypac->num_rows()>0){
                            $resp =  $qrypac->result_array();
                            $sub1=array();
                            foreach ($resp as $key => $value) {
                                $id=$value['id'];
                                if($value['type']=='UNLIMITED'){
                                    if($id==$data1['club_type_id'])
                                      $value['is_current_package']=true;
                                    else
                                      $value['is_current_package']=false;  
                                    if($value['amount_upper_limit']>$umamount)
                                     $value['is_upgradable']=true;
                                    else
                                      $value['is_upgradable']=false;  
                                }if($value['type']=='FIXED'){
                                     if($id==$data1['fixed_club_type_id'])
                                        $value['is_current_package']=true;
                                     else
                                       $value['is_current_package']=false;
                                     if($value['amount_upper_limit']>$fxdamount)
                                         $value['is_upgradable']=false;
                                     else
                                         $value['is_upgradable']=false; 
                                    
                                }if($value['type']=='INVESTOR'){
                                      if($id==$data1['investor_type_id'])
                                         $value['is_current_package']=true;
                                      else
                                         $value['is_current_package']=false;
                                      if($value['amount_upper_limit']>$insamount)
                                         $value['is_upgradable']=false;
                                      else
                                         $value['is_upgradable']=false; 
                                }    
                           

                            $value['amount_lower_limit']='0';

                            $con1="can add ";
                            $con2="friends";
                            $qrybnfit = $this->db->query("SELECT CONCAT('can add ',ty.user_limit,' friends') ,CONCAT('can add ',ty.cp_limit, ' Channel partners') channel ,CONCAT('can add ',ty.ca_limit,' Club agents') FROM `club_member_type` ty where ty.id=$id");
                             
                               if($qrybnfit->num_rows()>0)
                               {

                                $ttt=$qrybnfit->row_array();
                                $rr=array();

                                foreach ($ttt as $key => $ttt11) {
                                    
                                   $rr[]=$ttt11;
                                 }

                                 $value['benefits']=$rr;

                               }

                               else
                               {
                                $value['benefits']=array();
                               }

                              array_push($sub1,$value);
                            }
                        $data['package'] = $sub1;
                        }else{
                            $data = array();
                        }
                }else{
                    $data = array();
                }
                return $data;
              
            //print_r($data1);
        }
        elseif($type=='club_agent')
        {
           
            $count=get_ca_facility_by_id($id);
            $channel_partner=0;
            $club_agents=0;
            $active_friends=$count['frnd_count'];
            $ba_count=0;
           // echo $channel_partner;exit();
            $base=base_url();
             $qrycl = $this->db->query("SELECT cus.name firstName,cus.id,CONCAT('$base','uploads/',cus.profile_image) profile_image,wa.total_value my_wallet,login.id,cus.club_type_id ,cus.fixed_club_type_id ,cus.investor_type_id  FROM `gp_normal_customer` cus  
                left join gp_login_table login on login.user_id=cus.id and login.type='club_agent'
                left join gp_wallet_values wa on wa.user_id=login.id and wa.wallet_type_id='4'
                where cus.id='$user_id'");
                if($qrycl->num_rows()>0){
                        $data1 =  $qrycl->row_array();
                        
                        $data1['last_name']='';
                        $data1['active_friends']=$active_friends;
                        $data1['reffered_friends']='';
                        $data1['notification_count']='';
                        $data1['channel_partner']=$channel_partner;
                        $data1['club_agents']=$club_agents;
                        $data1['ba_count']=$ba_count;
                        $data1['executives']=0;
                        $data1['designation']='Club Agent';

                        $data['previliages']= array(
                            'add_club_member'=>false,
                            'add_executive'=>false,
                            'add_channel_partner'=>false,
                            'refer_channel_partner'=>false,
                            'add_club_agent'=>false,
                            'add_friend'=>true,
                            'add_jaazzo_store'=>false,
                            'my_reffered_channel_partners'=>false,
                            'register_channel_partner'=>false
                        );
                        $data['user']=$data1;
                        $data['category']=array();
                        $data['package'] = array();
                        $qry2 = $this->db->query("SELECT cus.name firstName,cus.id,CONCAT('$base','uploads/',cus.profile_image) profile_image,cus.phone as mobile  
                        FROM `gp_normal_customer` cus  
                        left join gp_login_table login on login.user_id=cus.id and login.type='normal_customer'
                        where cus.created_by='$lgid'");
                        if($qry2->num_rows()>0){
                            $data['friends'] =  $qry2->result_array();
                        }else{
                            $data['friends'] = array();
                        }
                }else{
                    $data = array();
                }
                return $data;
              
            //print_r($data1);
        }
    
    }
    function chk_mail_exist($mail,$id){

        $qry = "select * from  gp_login_table where email = '$mail' and type!='Channel_partner' and is_del = '0' and user_id='$id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return FALSE;
        } else
        {
            return TRUE;
        }
    }
    function chk_mobile_exist($mob,$id){
        $qry = "select * from gp_login_table where mobile = '$mob' and type!='Channel_partner' and user_id='$id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return FALSE;
        } else
        {
            return TRUE;
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
    function add_refer_partner($api_key,$otp,$qr_no,$creg,$license){
        $usr_data=user_details_by_apikey($api_key);
        $lgid = $usr_data['id'];

        $email=$this->input->post('email');
        $created_on = date("Y-m-d h:i:sa") ;
        $created_by=$lgid;
        $module = $this->input->post('module_id');
        $this->db->trans_begin();
        $channel_id=$this->input->post('channel_id');
        $name = $this->input->post('channel_name');
        $string = str_replace(' ','',$name);
        $myStr = substr($string, 0, 3);  
        $qrcode = strtoupper($myStr).$qr_no;
        if( $usr_data['type']=='executive'){
            $parent_id=$this->input->post('selected_club_member_id');
            $club_mem_id = $this->input->post('selected_club_member_id');
            $club_type = $this->input->post('club_type');
        }else{
            $parent_id=$lgid;
            $club_mem_id = $lgid;
            $club_type = $this->input->post('club_type');
        }
        $data=array(
            'club_mem_id'=>$club_mem_id,
            'parent_id' =>$parent_id,
            'club_type' => $club_type,
            'name'=>$this->input->post('channel_name'),
            'phone'=>$this->input->post('contact_number'),
            'email'=>$this->input->post('channel_email'),
            'pan'=>$this->input->post('pan_number'),
            'gst'=>$this->input->post('gst_number'),
            'company_registration'=>$creg,
            'license'=>$license,
            'owner_name'=>$this->input->post('owner_name'),
            'owner_email'=>$this->input->post('owner_email'),
            'owner_mobile'=>$this->input->post('owner_number'),
            'country'=>$this->input->post('country_id'),
            'state'=>$this->input->post('state_id'),
            'town'=>$this->input->post('city_id'),
            'area'=>$this->input->post('area'),
            'is_reffered'=>1,
            'created_on'=>$created_on,
            'created_by'=>$created_by,
            'lattitude'=>$this->input->post('lattitude'),
            'longitude'=>$this->input->post('longitude'),
            'module'=>$module,
            'otp'=>$otp,
            'qr_code' =>$qrcode,
            'status'=>'NOT_APPROVED',
        );
          
        $this->db->where('id', $channel_id);
        $qrs = $this->db->update('gp_pl_channel_partner', $data);
        $channel_type=$this->input->post('channel_partner_type');
        $ctype = json_decode($channel_type,true);
       // var_dump($channel_type);exit;
        foreach($ctype as $key => $type){
            $data=array(
                'channel_partner_type_id'=>$type,
                'channel_partner_id'=>$channel_id,
                'module_id' => $module
            );
            $this->db->insert('gp_pl_channel_partner_type_connection',$data);
        }
        $logindata=array(
            'email'=>$this->input->post('channel_email'),
            'mobile'=>$this->input->post('contact_number'),
            'otp_status' => 0,
            'user_id'=>$channel_id,
            'parent_login_id'=>$parent_id,
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
        $qry3 = $this->db->insert_batch('gp_wallet_values', $wallete);
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
    function edit_channel_partner($api_key,$creg,$license){
        $usr_data=user_details_by_apikey($api_key);
        $lgid = $usr_data['id'];

        $email=$this->input->post('channel_email');
        $created_on = date("Y-m-d h:i:sa") ;
        $created_by=$lgid;
        $module = $this->input->post('module_id');
        $this->db->trans_begin();
        $channel_id=$this->input->post('channel_id');
        $name = $this->input->post('channel_name');
        if( $usr_data['type']=='executive'){
            $parent_id=$this->input->post('selected_club_member_id');
            $club_mem_id = $this->input->post('selected_club_member_id');
            $club_type = $this->input->post('club_type');
        }else{
            $parent_id=$lgid;
            $club_mem_id = $lgid;
            $club_type = $this->input->post('club_type');
        }
        $data=array(
            'club_mem_id'=>$club_mem_id,
            'parent_id' =>$parent_id,
            'club_type' => $club_type,
            'name'=>$this->input->post('channel_name'),
            'phone'=>$this->input->post('contact_number'),
            'email'=>$this->input->post('channel_email'),
            'pan'=>$this->input->post('pan_number'),
            'gst'=>$this->input->post('gst_number'),
            'company_registration'=>$creg,
            'license'=>$license,
            'owner_name'=>$this->input->post('owner_name'),
            'owner_email'=>$this->input->post('owner_email'),
            'owner_mobile'=>$this->input->post('owner_number'),
            'country'=>$this->input->post('country_id'),
            'state'=>$this->input->post('state_id'),
            'town'=>$this->input->post('city_id'),
            'area'=>$this->input->post('area'),
            'lattitude'=>$this->input->post('lattitude'),
            'longitude'=>$this->input->post('longitude'),
            'module'=>$module,
        );
          
        $this->db->where('id', $channel_id);
        $qrs = $this->db->update('gp_pl_channel_partner', $data);
        $channel_type=$this->input->post('channel_partner_type');
        $ctype = json_decode($channel_type,true);
        $qrs3 = "select c.channel_partner_type_id from gp_pl_channel_partner_type_connection c where c.channel_partner_id = $channel_id";
        $qrs3 = $this->db->query($qrs3);

        $channel = array();
        if($qrs3->num_rows()>0){
            $ppt = $qrs3->result_array();
            foreach ($ppt as $prt){
                array_push($channel,$prt['channel_partner_type_id']);
            }
        }
        foreach ($ctype as $ch){
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
            if (in_array($pr, $ctype))
            {
            }else{
                $qry32 = "delete from gp_pl_channel_partner_type_connection where channel_partner_id = $id and channel_partner_type_id = '$pr'";
                $qry32 = $this->db->query($qry32);
                $this->delete_product_by_cptype($pr,$id);
            }
        }


        $date = date("Y-m-d h:i:sa") ;
        $userid=$lgid;
        $action = "updated parnter ";
        $status = 0;

        activity_log($action,$userid,$status,$date);
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
    function get_all_channel_partners($api_key){
        $usr_data=user_details_by_apikey($api_key);
        $user_id = $usr_data['user_id'];
        $id = $usr_data['id'];

        $qry1="select
                cp.id,cp.name,cp.phone,cp.email,
                cp.owner_name,cp.owner_email,
                cp.owner_mobile as owner_number,
                IFNULL(cp.area,c.name) AS address,
                CASE
                    WHEN cp.status ='JOINED' THEN 'active'
                END AS status,
                CASE
                    WHEN cp.is_reffered =1 THEN 'refered'
                    ELSE 'not_refered'
                END AS is_referred
                from gp_pl_channel_partner cp
                LEFT JOIN cities c ON cp.town=c.id
                where cp.is_del='0' and cp.status = 'JOINED' and cp.created_by='$id'
                group by cp.id ORDER BY cp.id DESC";
        $result1=$this->db->query($qry1);

        if($result1->num_rows()>0)
        {
            $data['active_channels'] = $result1->result_array();

        }else {
            $data['active_channels'] = array();
        }

        ///////////////////////////////////////
        $qry2="select
                 cp.id,cp.name,cp.phone,cp.email,
                cp.owner_name,cp.owner_email,
                cp.owner_mobile as owner_number,
                IFNULL(cp.area,'') AS address,
                CASE
                    WHEN cp.status ='REFERED' THEN 'referred'
                    WHEN cp.status ='NOT_APPROVED' THEN 'not_approved'
                END AS status,
                CASE
                    WHEN cp.is_reffered =1 THEN 'refered'
                    ELSE 'not_refered'
                END AS is_referred
                from gp_pl_channel_partner cp
                where cp.is_del='0' and cp.status in('REFERED','NOT_APPROVED') and cp.created_by='$id'
                group by cp.id ORDER BY cp.id DESC";
        $result2=$this->db->query($qry2);

        if($result2->num_rows()>0)
        {
            $data['referred_channels'] = $result2->result_array();

        }else {
            $data['referred_channels'] = array();
        }

        return $data;
    }
    function chk_valida_cp($id,$channel_id){
        $qry = "select * from gp_pl_channel_partner where id = '$channel_id' and created_by='$id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return TRUE;
        } else
        {
            return FALSE;
        }
    }
    function edit_refer_channel_partner($api_key){
        $usr_data=user_details_by_apikey($api_key);
        $lgid = $usr_data['id'];

        $email=$this->input->post('email');
        $updated_on = date("Y-m-d h:i:sa") ;
        $updated_by=$lgid;
        $this->db->trans_begin();
        $channel_id=$this->input->post('channel_id');
        $name = $this->input->post('name');
        $club_type = $this->input->post('club_type');
        $data=array(
            'club_type' => $club_type,
            'name'=>$name,
            'phone'=>$this->input->post('phone'),
            'email'=>$email,
            'owner_name'=>$this->input->post('owner_name'),
            'owner_email'=>$this->input->post('owner_email'),
            'owner_mobile'=>$this->input->post('owner_mobile'),
            'area'=>$this->input->post('area'),
            'updated_on'=>$updated_on,
            'updated_by'=>$updated_by
        );
          
        $this->db->where('id', $channel_id);
        $qrs = $this->db->update('gp_pl_channel_partner', $data);
        
        $date = date("Y-m-d h:i:sa") ;
        $userid=$lgid;
        $action = "updated refered parnter ";
        $status = 0;

        activity_log($action,$userid,$status,$date);
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
    function get_club_member_by_executive($api_key){
        $usr_data=user_details_by_apikey($api_key);
        $user_id = $usr_data['user_id'];
        $id = $usr_data['id'];
        $search = $this->input->post('search_text');
        if(!empty($search)){
            $where= " AND (gp_customer.name LIKE '%{$search}%')";
            $order =" order by gp_customer.name LIKE '$search%' desc,gp_login.id desc";
        }else{
            $where= "";
            $order =" order by gp_login.id desc";
        }

        $qry1="SELECT gp_customer.name ,gp_login.id  FROM gp_login_table gp_login LEFT JOIN `gp_normal_customer` gp_customer ON gp_customer.id=gp_login.user_id WHERE gp_customer.created_by='$id' AND gp_customer.is_del ='0' AND gp_customer.status='approved' ".$where.$order;
        $result1=$this->db->query($qry1);

        if($result1->num_rows()>0)
        {
            $data['club_members'] = $result1->result_array();

        }else {
            $data['club_members'] = array();
        }

        return $data;
    }
    function get_members_by_type($api_key){
        $usr_data=user_details_by_apikey($api_key);
        $user_id = $usr_data['user_id'];
        $id = $usr_data['id'];
        $type = $this->input->post('type');
        $base = base_url();
        if(!empty($type)){
            
            if($type=='channel_partner'){
                $qry1="SELECT cp.name ,gp_login.id,gp_login.mobile,IFNULL(CONCAT('$base',cp.profile_image),'') as image  FROM gp_login_table gp_login LEFT JOIN `gp_pl_channel_partner` cp ON cp.id=gp_login.user_id WHERE gp_login.type='Channel_partner' AND cp.created_by='$id' AND cp.is_del ='0' AND cp.status='approved' order by gp_login.id desc";
            }else if($type=='club_member'||$type=='club_agents') {
                $qry1="SELECT gp_customer.name ,gp_login.id,gp_login.mobile,IFNULL(CONCAT('$base','uploads/',gp_customer.profile_image),'') as image  FROM gp_login_table gp_login LEFT JOIN `gp_normal_customer` gp_customer ON gp_customer.id=gp_login.user_id WHERE gp_login.type IN('club_member','club_agent') AND gp_customer.created_by='$id' AND gp_customer.is_del ='0' AND gp_customer.status='approved' order by gp_login.id desc";
            }else if($type=='jaazzo_store') {
                $qry1="select log.id,ba.name,ba.mobil_no as mobile,IFNULL(ba.image,'') as image
                    from pl_ba_registration ba
                    left join gp_login_table log on ba.id = log.user_id
                    where ba.is_del='0' and log.type='ba' 
                    and ba.created_by = $id";
            }else if($type=='executives') {
                $qry1="select log.id,exe.name,log.mobile,IFNULL(CONCAT('$base','upload/exec_profile/',details.image),'') as image
                    from gp_pl_sales_team_members exe
                    left join gp_login_table log on exe.id = log.user_id
                    left join gp_pl_sales_designation_type typ on exe.sales_desig_type_id=typ.id
                    left join gp_pl_sales_team_member_details details on details.sales_team_member_id=exe.id
                    where exe.is_del='0' and log.type='executive' and typ.type='executive' and typ.slug!='team_leader' and typ.add_exec=0
                    and exe.created_by = $id";
                   
            }else if($type=='team_lead') {
                $qry1="select log.id,exe.name,log.mobile,IFNULL(CONCAT('$base','upload/exec_profile/',details.image),'') as image
                    from gp_pl_sales_team_members exe
                    left join gp_login_table log on exe.id = log.user_id
                    left join gp_pl_sales_designation_type typ on exe.sales_desig_type_id=typ.id
                    left join gp_pl_sales_team_member_details details on details.sales_team_member_id=exe.id
                    where exe.is_del='0' and log.type='executive' and typ.type='executive' and typ.slug='team_leader' and typ.add_exec=1
                    and exe.created_by = $id";
                   
            }
            
            $result1=$this->db->query($qry1);

            if($result1->num_rows()>0)
            {
                $data['member_list'] = $result1->result_array();

            }else {
                $data['member_list'] = array();
            }
        }

        return $data;
    }
    function check_fixed_usage($id,$type){
        $qry="SELECT t.type,t.id as login_id,n.id as user_id,n.club_type_id,n.fixed_club_type_id,n.investor_type_id,t.type,t.email FROM gp_login_table t left join gp_normal_customer n on t.user_id = n.id WHERE t.id = '$id' and t.type not in ('super_admin','channel_partner','executive') and t.is_del = '0' and n.status = 'approved'";
        $result=$this->db->query($qry); 
        if($result->num_rows()>0)
        {
            $datas =  $result->row_array();
            if($datas){
                $lid = $datas['login_id'];
                $userid = $datas['user_id'];
                $udetail = get_details_by_userid($userid);
                $dateString=$udetail['created_on'];
                $fixed_joind=$udetail['fixed_join_date'];
                $det = get_cmfacility_by_id($lid);
                if($type=='FIXED'){
                    $fix_years = round((time()-strtotime($fixed_joind))/(3600*24*365));
                    $fix_year_exceed = date('Y-m-d H:i:s',strtotime('+1 year',strtotime($fixed_joind)));
                    $fixed_plan = $udetail['fixed_club_type_id'];
                    $fixed_details = getClubtypeById($fixed_plan);
                    $fixed_amnt = $fixed_details['amount'];
                    $reward_per_refer_cp = $fixed_details['ref_reward_per_cp'];
                    $reward_per_cp = $fixed_details['reward_per_cp'];

                    $fixed_wallet_used = get_wallet_used_by_member($lid,5);
                    $fixed_wallet_details = get_fixed_wallet_details($lid);

                    $expected_total1 = $fixed_wallet_details +$reward_per_refer_cp + $fixed_wallet_used;
                    $expected_total2 = $fixed_wallet_details +$reward_per_cp + $fixed_wallet_used;
                    $exp1 = $fixed_wallet_details+$fixed_wallet_used;
                    $allow1 = '';
                    if($exp1<$fixed_amnt){
                      $allow1 = 1 ;
                    }
                    if($datas['fixed_club_type_id']>0){
                        $fixed_year_limit =  $det['fixed_year_limit'];
                    }else{
                        $fixed_year_limit =0;
                    }
                    if((date('Y-m-d H:i:s')<=$fix_year_exceed)&& (($expected_total2<=$fixed_amnt)|| ($allow1==1))){
                        $data['status'] = true;
                        $data['msg'] = 'Success';
                        return $data;
                    }else{
                        $data['status'] = false;
                        $data['msg'] = 'Sorry!!...Channel Partner Limit crossed by this club member';
                        return $data;
                    }
                }else{
                    $years = round((time()-strtotime($dateString))/(3600*24*365));
                    $club_type_id = $datas['club_type_id'];

                    $year_limit =  $det['year_limit'];
                    if(($year_limit>=$years)&&($club_type_id>0)){
                        $data['status'] = true;
                        $data['msg'] = 'Success';
                        return $data;
                    }else{
                        $data['status'] = false;
                        $data['msg'] = 'Sorry!!...Channel Partner Limit crossed by this club member';
                        return $data;
                    }
                }
            }else {
                $data['status'] = false;
                $data['msg'] = 'Sorry!!...Club member not found';
                return $data;
            }
        }
    }
}