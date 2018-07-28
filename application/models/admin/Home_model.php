<?php
Class Home_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();
        $session_array = $this->session->userdata('logged_in_admin');
    }
    function get_user_type($type){
        $qry="select l.email from gp_login_table l where l.type = '$type'";
        $qry=$this->db->query($qry);
     
        if($qry){
            
            $data=$qry->result_array();
        }
        else{
            
            $data=array();
        }
        
        return $data;
    }
    function transaction_history1(){
        $qry="SELECT t.*,DATE_FORMAT(t.transaction_date, '%d-%b-%Y') as trans_date,DATE_FORMAT(t.cheque_date, '%d-%b-%Y') as cheque_date FROM `gp_cp_transaction` t left join gp_login_table l on (l.id = t.from or l.id = t._to) where t.is_del='0' and l.type='Channel_partner' ORDER BY t.`transaction_date` DESC";
        $qry=$this->db->query($qry);
        //echo $this->db->last_query();exit();
        if($qry->num_rows()>0){
            $data=$qry->result_array();
            //echo json_encode($data);exit();
            foreach ($data as $key => $value) {
                $type = $value['type'];$from = $value['from'];$to = $value['_to'];
                $id = ($type=='admin') ? $to: $from;
                //var_dump($id);
                   $qry1=$this->db->query("SELECT cp.name FROM `gp_login_table` l left join gp_pl_channel_partner cp on l.user_id = cp.id where cp.is_del='0' and cp.status = 'joined' and l.id = $id");
                   if($qry1->num_rows()>0){
                    $cp = $qry1->row();
                    $name = $cp->name;
                    if($type=='admin'){
                        $data[$key]['from'] = "Admin";
                        $data[$key]['to'] = $name;
                     }else{
                         $data[$key]['from'] = $name;
                         $data[$key]['to'] = "Admin";
                     }   
                   }
                   else{
                         $data[$key]['from'] = "";
                         $data[$key]['to'] = "";
                   }              
            }
            //exit();
        }
        else{
            $data=array();
        }
        
        return $data;
    }
    
       function get_cp_transaction_history_count($search,$from,$to)
        {
            if(!empty($search)){
                $keyword = "%{$search}%";
                $where = "and (t.transaction_amount LIKE '%$keyword%' OR t.narration LIKE '%$keyword%' OR DATE_FORMAT(t.transaction_date, '%d-%b-%Y') LIKE '%$keyword%' OR t.mode LIKE '%$keyword%' OR t.cheque_number LIKE '%$keyword%' OR t.bank_name LIKE '%$keyword%' OR DATE_FORMAT(t.cheque_date,'%d-%b-%Y') LIKE '%$keyword%')";
            }else{
                $where = '';
            }
            if(empty($from)&&!empty($to)){
                $to = $to." 00:00:00";
                $where2 = "AND t.transaction_date <= '".$to."'";
            }elseif(empty($to)&&!empty($from)){
                $from =$from." 00:00:00";
                $where2 = "AND t.transaction_date >='".$from."'";
            }elseif(!empty($from)&&!empty($to)){
                $from =$from." 00:00:00";$to = $to." 23:59:59";
                $where2 = "AND t.transaction_date between '".$from."' and '".$to."'";
            }else{
                $where2 ="";
            }
            $qry="SELECT t.id FROM `gp_cp_transaction` t left join gp_login_table l on (l.id = t.from or l.id = t._to) where t.is_del='0' and l.type='Channel_partner'".$where.$where2 ;
            $result=$this->db->query($qry);
            if($result->num_rows()>0)
            {
                return $result->num_rows();
            }else {
                return false;
            }
        }
        function get_cp_transaction_history($search,$limit, $start,$from,$to)
        {
            if(!empty($search)){
                $keyword = "%{$search}%";
                $where = "and (t.transaction_amount LIKE '%$keyword%' OR t.narration LIKE '%$keyword%' OR DATE_FORMAT(t.transaction_date, '%d-%b-%Y') LIKE '%$keyword%' OR t.mode LIKE '%$keyword%' OR t.cheque_number LIKE '%$keyword%' OR t.bank_name LIKE '%$keyword%' OR DATE_FORMAT(t.cheque_date,'%d-%b-%Y') LIKE '%$keyword%')";
            }else{
                $where = '';
            }
            if(empty($from)&&!empty($to)){
                $to = $to;
                $where2 = "AND t.transaction_date <= '".$to."'";
            }elseif(empty($to)&&!empty($from)){
                $from =$from;
                $where2 = "AND t.transaction_date >='".$from."'";
            }elseif(!empty($from)&&!empty($to)){
                $from =$from;$to = $to;
                $where2 = "AND t.transaction_date between '".$from."' and '".$to."'";
            }else{
                $where2 ="";
            }
            $qry="SELECT t.*,DATE_FORMAT(t.transaction_date, '%d-%b-%Y %h:%p') as trans_date,DATE_FORMAT(t.cheque_date, '%d-%b-%Y') as cheque_date FROM `gp_cp_transaction` t left join gp_login_table l on (l.id = t.from or l.id = t._to) where t.is_del='0' and l.type='Channel_partner' ".$where.$where2 ." ORDER BY t.`transaction_date` DESC LIMIT $start, $limit";
            $qry=$this->db->query($qry);
            //echo $this->db->last_query();exit;
            if($qry->num_rows()>0){
            $data=$qry->result_array();

            foreach ($data as $key => $value) {
                $type = $value['type'];$from = $value['from'];$to = $value['_to'];
                $id = ($type=='admin') ? $to: $from;
                   $qry1=$this->db->query("SELECT cp.name FROM `gp_login_table` l left join gp_pl_channel_partner cp on l.user_id = cp.id where cp.is_del='0' and cp.status = 'joined' and l.id = $id");
                   if($qry1->num_rows()>0){
                    $cp = $qry1->row();
                    $name = $cp->name;
                    if($type=='admin'){
                        $data[$key]['from'] = "Admin";
                        $data[$key]['to'] = $name;
                     }else{
                         $data[$key]['from'] = $name;
                         $data[$key]['to'] = "Admin";
                     }   
                   }
                   else{
                         $data[$key]['from'] = "";
                         $data[$key]['to'] = "";
                   }              
                }
            }
            else{
                $data=array();
            }
            return $data;
    }

    function exec_transaction_history(){
          $qry=$this->db->query("SELECT exe.name,trans.*,trans.transaction_date as transaction_date FROM `gp_cp_transaction` trans
                left join  gp_login_table l on l.id=trans._to 
                left join gp_pl_sales_team_members exe on l.user_id = exe.id and l.type='executive'
                where exe.is_del='0'");
          if($qry->num_rows()>0){
            $data=$qry->result_array();
        }
        else{
            $data=array();
        }
        
        return $data;

    }
    function exec_transaction_history_all($search,$limit=NULL,$start=NULL){
        if(!empty($search)){
            $keyword = "%{$search}%";
           $where = "and (exe.name LIKE '%$keyword%' OR trans.transaction_date  LIKE '%$keyword%' )";
        }else{
            $where = '';
        }
           if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
          $qry = "SELECT exe.name,trans.*,trans.transaction_date as transaction_date FROM `gp_cp_transaction` trans
                left join  gp_login_table l on l.id=trans._to 
                left join gp_pl_sales_team_members exe on l.user_id = exe.id and l.type='executive'
                where exe.is_del='0'".$where."".$pg;

        $query=$this->db->query($qry);
        if($query){
            $data['member']=$query->result_array();
        }
        else{
            $data['member']=array();
        }
        return $data;

}
    function exec_transaction_history_count($search){
            if(!empty($search)){
                $keyword = "%{$search}%";
                $where = "and (exe.name LIKE '%$keyword%' OR trans.transaction_date  LIKE '%$keyword%' )";
            }else{
                $where = '';
            }
          $qry="SELECT exe.name,trans.*,trans.transaction_date as transaction_date FROM `gp_cp_transaction` trans
                left join  gp_login_table l on l.id=trans._to 
                left join gp_pl_sales_team_members exe on l.user_id = exe.id and l.type='executive'
                where exe.is_del='0'".$where."";
            $result=$this->db->query($qry);
            //echo $this->db->last_query();exit();
            if($result->num_rows()>0)
            {
                return $result->num_rows();
            }else {
                return false;
            }

    }

     function get_all_deal_purchase_count($search)
        {
            if(!empty($search)){
                $keyword = "%{$search}%";
                $where = "and (d.amount LIKE '%$keyword%' OR d.name LIKE '%$keyword%' OR d.description LIKE '%$keyword%' OR d.duration LIKE '%$keyword%' OR cp.name LIKE '%$keyword%' OR DATE_FORMAT(c.purchased_on,'%d-%b-%Y') LIKE '%$keyword%' OR c.payment_mode LIKE '%$keyword%' OR c.cheque_number LIKE '%$keyword%' OR c.bank_name LIKE '%$keyword%' OR DATE_FORMAT(c.cheque_date,'%d-%b-%Y') LIKE '%$keyword%')";
            }else{
                $where = '';
            }
            $qry="SELECT d.id FROM `gp_deal_settings` `d` JOIN `gp_deal_channel_partner_con` `c` ON `d`.`id` = `c`.`deal_id` left join gp_pl_channel_partner cp on cp.id = c.channel_partner_id WHERE `c`.`product_id` = '0' and `c`.`status` = '0' and `c`.`is_paid` = '0' ".$where;
            $result=$this->db->query($qry);
            //echo $this->db->last_query();exit();
            if($result->num_rows()>0)
            {
                return $result->num_rows();
            }else {
                return false;
            }
        }
        function get_all_deal_purchase($search,$limit, $start)
        {
            if(!empty($search)){      
                $keyword = "%{$search}%";
            $where = "and (d.amount LIKE '%$keyword%' OR d.name LIKE '%$keyword%' OR d.description LIKE '%$keyword%' OR d.duration LIKE '%$keyword%' OR cp.name LIKE '%$keyword%' OR DATE_FORMAT(c.purchased_on,'%d-%b-%Y') LIKE '%$keyword%' OR c.payment_mode LIKE '%$keyword%' OR c.cheque_number LIKE '%$keyword%' OR c.bank_name LIKE '%$keyword%' OR DATE_FORMAT(c.cheque_date,'%d-%b-%Y') LIKE '%$keyword%')";
            }else{
                $where = '';
            }
            $qry="SELECT d.amount,d.name,d.description, DATE_FORMAT(c.purchased_on,'%d-%b-%Y') as purchased_on,d.duration,c.id,cp.name as cpname,c.payment_mode,c.cheque_number ,c.bank_name ,DATE_FORMAT(c.cheque_date,'%d-%b-%Y') as cheque_date FROM `gp_deal_settings` `d` JOIN `gp_deal_channel_partner_con` `c` ON `d`.`id` = `c`.`deal_id` left join gp_pl_channel_partner cp on cp.id = c.channel_partner_id WHERE `c`.`product_id` = '0' and `c`.`status` = '0' and `c`.`is_paid` = '0' ".$where."  ORDER BY c.id DESC LIMIT $start, $limit";
            $result=$this->db->query($qry);
           // echo $this->db->last_query();exit();
            if($result->num_rows()>0)
            {
                return $result->result_array();

            }else {
                return array();
            }
        }

    function get_permanent_deactivated_cp_count($search)
        {
            if(!empty($search)){
                $keyword = "%{$search}%";
                $where = "and (p.name LIKE '%$keyword%')";
            }else{
                $where = '';
            }
            $qry="SELECT p.id, `p`.`name`
             FROM `gp_pl_channel_partner` `p` WHERE `p`.`is_del` =1 ".$where;
            $result=$this->db->query($qry);
            //echo $this->db->last_query();exit();
            if($result->num_rows()>0)
            {
                return $result->num_rows();
            }else {
                return false;
            }
        }
        function get_permanent_deactivated_cp($search,$limit, $start)
        {
            if(!empty($search)){      
                $keyword = "%{$search}%";
            $where = "and (p.name LIKE '%$keyword%' )";
            }else{
                $where = '';
            }
            $qry="SELECT p.id, `p`.`name` FROM `gp_pl_channel_partner` `p` WHERE `p`.`is_del` =1 ".$where."  ORDER BY p.id DESC LIMIT $start, $limit";
            $result=$this->db->query($qry);
           // echo $this->db->last_query();exit();
            if($result->num_rows()>0)
            {
                return $result->result_array();

            }else {
                return array();
            }
        }
     function get_temporary_deactivated_cp_count($search)
        {
            if(!empty($search)){
                $keyword = "%{$search}%";
                $where = "and (p.name LIKE '%$keyword%')";
            }else{
                $where = '';
            }
            $qry="SELECT `p`.`id` 
             FROM `gp_pl_channel_partner` `p` left join gp_login_table l on p.id = l.user_id WHERE `p`.`is_del` =0 and `p`.`status` = 'joined' and p.is_active =0  and l.type='Channel_partner' ".$where;
            $result=$this->db->query($qry);
            if($result->num_rows()>0)
            {
                return $result->num_rows();
            }else {
                return false;
            }
        }
        function get_temporary_deactivated_cp($search,$limit, $start)
        {
            if(!empty($search)){      
                $keyword = "%{$search}%";
            $where = "and (p.name LIKE '%$keyword%' )";
            }else{
                $where = '';
            }
            $qry="SELECT `p`.`name`, `p`.`id`, `p`.`is_active`
             FROM `gp_pl_channel_partner` `p` left join gp_login_table l on p.id = l.user_id WHERE `p`.`is_del` =0 and `p`.`status` = 'joined' and p.is_active =0 and l.type='Channel_partner' ".$where."  ORDER BY p.id DESC LIMIT $start, $limit";
            $result=$this->db->query($qry);
           // echo $this->db->last_query();exit();
            if($result->num_rows()>0)
            {
                return $result->result_array();

            }else {
                return array();
            }
        }         
    function get_na_deals(){
        $qry="SELECT d.amount,d.name,d.description,d.duration,c.id,cp.name,c.purchased_on FROM `gp_deal_settings` `d` JOIN `gp_deal_channel_partner_con` `c` ON `d`.`id` = `c`.`deal_id` left join gp_pl_channel_partner cp on cp.id = c.channel_partner_id WHERE `c`.`product_id` = '0' and `c`.`status` = '0' and `c`.`is_paid` = '0'";
        $qry=$this->db->query($qry);
        if($qry->num_rows()>0){
            $data=$qry->result_array();
        }
        else{
            $data=array();
        }
        
        return $data;
    }
    function category_level_settings(){
        $qry = "select * from gp_preference where slug = 'category_level'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->row_array();
        }   else{
            return array();
        }
    }
     function update_category_level(){

            $this->db->trans_begin();
            $hidden_id = $this->input->post('hidden_id');
            $cat_level = $this->input->post('cat_level');
            $date = date("Y-m-d h:i:sa") ;
                $data=array(
                    'value' => $cat_level,
                    'updated_on' => $date
                );
            $this->db->where('id',$hidden_id);
            $this->db->update('gp_preference',$data);
            $action = "updated new category level";
           
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
            
            $this->db->trans_complete();
            if($this->db->trans_status() == false){
                $this->db->trans_rollback();
                return false;
            }
            else{
                $this->db->trans_commit();
                return true;
            }
    }

    function validate_psw($pass,$id)
    {
        
        $password = $this->input->post('current_password');
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
     function change_password($password,$id)
    {
        $data = array();
        $this->db->trans_begin();
        //$password = $this->input->post('new_password');
        $pass = encrypt_decrypt('encrypt',$password);
        $datas = array('password' => $pass);
        $this->db->where('id',$id);
        $this->db->update('gp_login_table',$datas);
       //echo $this->db->last_query();exit;
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data['status'] = FALSE;
        } else {
            $this->db->trans_commit();
            $data['status'] = TRUE;
        }
        return $data;
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
    function new_transaction_byid(){

        $this->db->trans_begin();
        $payed_amt=$this->input->post('pay_amt');
        $ex_id=$this->input->post('cp_hiddenid');
        $walletid=$this->input->post('wallet_hiddenid');
        $total_amount=$this->input->post('total_amtvalue');
         //svar_dump($total_amount); var_dump($payed_amt); exit();
        $pending_amt=$total_amount-$payed_amt;

        $data=array(
            'total_value'=>$pending_amt
        );
        $this->db->where('id',$walletid);
        $this->db->update('gp_wallet_values',$data);
        $cur_date=date('Y-m-d H:i:s');

        $transdata=array(
            'cp_id'=>$cpid,
            'total_amount'=>$total_amount,
            'transaction_amount'=>$payed_amt,
            'transaction_date'=>$this->input->post('transaction_date'),
            'narration'=>$this->input->post('narration'),
            'status'=>"1",
            'created_on'=>$cur_date
        );

        $this->db->insert('gp_cp_transaction',$transdata);
        $insert_id = $this->db->insert_id();
        //entry creation
        $fy_year = get_current_financial_year();
        $fy_id = $fy_year['id'];
        $no =get_number();
        $ac_data = array(
            'entrytype_id'=>4,
            '_type'=>'TRANSACTION',
            'type_id'=>$insert_id,
            'number'=>$no,
            'fy_id' =>$fy_id,
            'date'=>date('Y-m-d'),
            'dr_total'=>$payed_amt,
        );
        $this->db->insert('erp_ac_entries',$ac_data);
      
        $entry_id = $this->db->insert_id();
        $type = 'CHANNEL_PARTNER';
        $ledger_payment_dr = getLedgerId($lgid,$type);
        if($mode=='cash')
            $ledger_payment_cr = 32;
        else if($mode=='cheque')
            $ledger_payment_cr = 50;
        else
            $ledger_payment_cr = 49;
        $entry_items_cr = array(
            'entry_id' => $entry_id,
            'ledger_id' => $ledger_payment_cr,
            'amount' => $payed_amt,
            'dc' => 'Cr',
            'fy_id' =>$fy_id,
            'created_date' => date('Y-m-d')
        );
         
        $entry_items_dr = array(
            'entry_id' => $entry_id,
            'ledger_id' => $ledger_payment_dr,
            'amount' => $payed_amt,
            'dc' => 'Dr',
            'fy_id' =>$fy_id,
            'created_date' => date('Y-m-d')
        );

           $date = date("Y-m-d h:i:sa") ;
           $action = "added new transaction ";
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
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
        function new_exec_transaction_byid(){

        $this->db->trans_begin();
        $payed_amt=$this->input->post('pay_amt');
        $ex_id=$this->input->post('cp_hiddenid');
        $walletid=$this->input->post('wallet_hiddenid');
        $total_amount=$this->input->post('total_amtvalue');
       // var_dump($ex_id); var_dump($payed_amt); exit();
        $pending_amt=$total_amount-$payed_amt;

        $data=array(
            'total_value'=>$pending_amt
        );
        $this->db->where('id',$walletid);
        $this->db->update('gp_wallet_values',$data);
        $cur_date=date('Y-m-d H:i:s');


            $transdata=array(
            'from' =>'1',
            '_to' =>$ex_id,
            'total_amount'=>$total_amount,
            'transaction_amount'=>$payed_amt,

            'transaction_date'=>date('Y-m-d H:i:s',strtotime($this->input->post('transaction_date'))),
            'narration'=>$this->input->post('narration'),
            'status'=>"1",
            'mode' =>$this->input->post('payment_mode'),
            'cheque_number' =>$this->input->post('cheque_number'),
            'bank_name' =>$this->input->post('bank'),
            'cheque_date' =>date('Y-m-d',strtotime($this->input->post('cheque_date'))),
            'created_on'=>$cur_date
        );
           // print_r( $transdata);
        $this->db->insert('gp_cp_transaction',$transdata);
        $insert_id = $this->db->insert_id();
        //entry creation
        $fy_year = get_current_financial_year();
        $fy_id = $fy_year['id'];
        $no =get_number();
        $ac_data = array(
            'entrytype_id'=>4,
            '_type'=>'TRANSACTION',
            'type_id'=>$insert_id,
            'number'=>$no,
            'fy_id' =>$fy_id,
            'date'=>date('Y-m-d'),
            'dr_total'=>$payed_amt,
            'cr_total'=>$payed_amt
        );
      
        $this->db->insert('erp_ac_entries',$ac_data);
      
        $entry_id = $this->db->insert_id();
        $type = 'EXECUTIVE';
        $ledger_payment_dr = getLedgerId($ex_id,$type);
        if($this->input->post('payment_mode')=='cash')
            $ledger_payment_cr = 32;
        else
            $ledger_payment_cr = 35;
        $entry_items_cr = array(
            'entry_id' => $entry_id,
            'ledger_id' => $ledger_payment_cr,
            'amount' => $payed_amt,
            'dc' => 'Cr',
            'fy_id' =>$fy_id,
            'created_date' => date('Y-m-d')
        );
         
        $entry_items_dr = array(
            'entry_id' => $entry_id,
            'ledger_id' => $ledger_payment_dr,
            'amount' => $payed_amt,
            'dc' => 'Dr',
            'fy_id' =>$fy_id,
            'created_date' => date('Y-m-d')
        );

        $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);
        $entry_dr = $this->db->insert('erp_ac_entryitems', $entry_items_dr);
           $date = date("Y-m-d h:i:sa") ;
           $action = "added new transaction ";
           $loginsession = $this->session->userdata('logged_in_admin');
           $userid=$loginsession['user_id'];
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
    function get_town_by_id($id){
        $qry = "select
                s.id,s.name
                from
                cities s
                where s.state_id = '$id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
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
    function mobile_exists($mob){
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
    function get_all_cptypes(){
         $cat = $this->input->post('obj');
         
         $cat_group = array();
          foreach ($cat as $key => $value) {
              array_push($cat_group, $value);
          }
          $res = implode("','",$cat_group);
        $qry="SELECT title, id FROM  gp_pl_channel_partner_types where id in ('$res')";
        $qry=$this->db->query($qry);
        if($qry){
            $data=$qry->result_array();
        }
        else{
            $data=array();
        }
        return $data;
    }
    function add_partner($otp,$qr_no,$creg,$license)
    {
       $email=$this->input->post('email');
       $created_on = date("Y-m-d h:i:sa") ;
       
       $module = $this->input->post('module');
       $name = $this->input->post('name');
       $string = str_replace(' ','',$name);
       $myStr = substr($string, 0, 3);  
       $qrcode = strtoupper($myStr).$qr_no;
       $this->db->trans_begin();
      
        $session_data=$this->session->userdata('logged_in_admin');
        $userid = $session_data['user_id'];
        $data=array(
            'name'=>$name,
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
            'created_by'=>$userid,
            'status'=>'APPROVED',
            'lattitude'=>$this->input->post('latt'),
            'longitude'=>$this->input->post('long'),
            'module'=>$module,
            'otp'=>$otp,
            'qr_code' =>$qrcode,
           
        );
        $this->db->insert('gp_pl_channel_partner',$data);
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
    function get_active_cp(){
       
        $qry = "select cp.id as cp_id,cp.name from
                gp_pl_channel_partner cp where cp.is_del = 0 and cp.status='JOINED'";
        $query=$this->db->query($qry);
        if($query){
            $data=$query->result_array();
        }
        else{
            $data=array();
        }
        return $data;
    }
    function get_active_cp_temp(){
       
        $qry = "select cp.id as cp_id,cp.name from
                gp_pl_channel_partner cp where cp.is_del = 0 and cp.status='JOINED' and cp.is_active=1";
        $query=$this->db->query($qry);
        if($query){
            $data=$query->result_array();
        }
        else{
            $data=array();
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
    function get_edit_partnertypebyid(){
        $this->db->trans_begin();
        $id=$this->input->post('hiddentype');
        $data=array(
            'title'=>$this->input->post('title'),
            'description'=>$this->input->post('descriptext'),
             'parent'=>$this->input->post('channel_type')     
        );
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
    function deactivate_permanently($id){
        $this->db->trans_begin();
        $data=array(
            'is_del'=>1    
        );
        $this->db->where('id',$id);
        $this->db->update('gp_pl_channel_partner',$data);
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
    function deactivate_temporarily($id){
        $this->db->trans_begin();
        $data=array(
            'is_active'=>0    
        );
        $this->db->where('id',$id);
        $this->db->update('gp_pl_channel_partner',$data);
        if($this->db->trans_status=false){
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
    function edit_partnerbyid($image_file1,$image_file2,$creg,$license){
        $datas = getLoginDetails();
        if($datas){
            $userid=$datas['user_id'];
        }
        $updated_on = date("Y-m-d h:i:sa");
        $this->db->trans_begin();
        $hiddenid=$this->input->post('hiddenid');
        $module = $this->input->post('module');
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
            
            
            
            
            'area'=>$this->input->post('area'),
            
            
            
            
            'address'=>$this->input->post('address'),
            'bank_name'=>$this->input->post('bank_name'),
            'account_no'=>$this->input->post('ac_number'),
            'account_holder_name'=>$this->input->post('ac_holder_name'),
            'ifsc'=>$this->input->post('ifsc'),
            'branch_name'=>$this->input->post('branch'),
            'updated_on'=>$updated_on,
            'updated_by'=>$userid,
            'pan'=>$this->input->post('pan'),
            'gst'=>$this->input->post('gst'),
            'company_registration'=>$creg,
            'license'=>$license,
            'lattitude'=>$this->input->post('latt'),
            'longitude'=>$this->input->post('long'),
            'module'=> $module, 
            'profile_image'=> $image_file1,
            'brand_image'=> $image_file2
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
    function activate_cp($datas){
        $data=array(
            'is_del'=>0,

        );  
       $this->db->trans_begin();
        $ca_ids = $datas['chck_item_id'];
        foreach ($ca_ids as $key => $ca_id) {
           
            $this->db->where('id', $ca_id);
            $qry = $this->db->update('gp_pl_channel_partner',$data);
        }
        $date = date("Y-m-d h:i:sa") ;
        $action = "Activate channelpartner again";
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
    function activate_cp_temp($datas){
        $data=array(
            'is_active'=>1,
        );  
       $this->db->trans_begin();
        $ca_ids = $datas['chck_item_id'];
        foreach ($ca_ids as $key => $ca_id) {
           
            $this->db->where('id', $ca_id);
            $qry = $this->db->update('gp_pl_channel_partner',$data);
        }
        $date = date("Y-m-d h:i:sa") ;
        $action = "Activate channelpartner again";
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
        function get_city(){
        $qry = "select
                s.*
                from
                cities s";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
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
    function get_dashboard_details($userid)
    {
        $qry = "select *
                from gp_purchase_bill_notification n where n.channel_partner_id = '124' and status = '1' group by n.login_id";
        $qry = $this->db->query($qry);
        $data['customers'] = $qry->num_rows();
        $qry2 = $this->db->query("select sum(n.bill_total) as bill_total, sum(n.wallet_total) as wallet_total from gp_purchase_bill_notification n where n.channel_partner_id = '$userid' and status = '1'");
        if($qry2->num_rows()>0)
        {
            $data['details'] =  $qry2->row();
        } else{
            $data['details'] = array();
        }
        return $data;  
    }
    function get_all_categories()
      {
        $sql="SELECT g.id,g.title,g.description,
              main.title as main_cat, main.id as main_id
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
      function get_all_partner_type_count($search)
        {
            if(!empty($search)){
                $keyword = "%{$search}%";
                $where = "(g.title LIKE '%$keyword%' OR g.description LIKE '%$keyword%' OR main.title LIKE '%$keyword%')";
            }else{
                $where = '';
            }
            $qry="SELECT g.id 
              FROM gp_pl_channel_partner_types g
              LEFT JOIN gp_pl_channel_partner_types main ON main.id = g.parent
               ".$where." group by g.id order by g.id desc";
            $result=$this->db->query($qry);
            //echo $this->db->last_query();exit();
            if($result->num_rows()>0)
            {
                return $result->num_rows();
            }else {
                return false;
            }
        }
        function get_all_partner_type($search,$limit, $start)
        {
            if(!empty($search)){
                $keyword = "%{$search}%";
                $where = "(g.title LIKE '%$keyword%' OR g.description LIKE '%$keyword%' OR main.title LIKE '%$keyword%')";
            }else{
                $where = '';
            }
            $qry="SELECT g.id,g.title,g.description,
              main.title as main_cat, main.id as main_id
              FROM gp_pl_channel_partner_types g
              LEFT JOIN gp_pl_channel_partner_types main ON main.id = g.parent ".$where."  group by g.id ORDER BY g.id DESC LIMIT $start, $limit";
            $result=$this->db->query($qry);

            if($result->num_rows()>0)
            {
                return $result->result_array();

            }else {
                return array();
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
    function get_deal_details(){
        $qry="select * from gp_deal_settings d order by d.id desc";
        $qry=$this->db->query($qry);
      
        if($qry){
            $data=$qry->result_array();
        }
        else{
            $data=array();
        }
       
        return $data;

    }
     function add_new_deal()
        {
            $this->db->trans_begin();

            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];

            $data=array(
                'name'=>$this->input->post('pro_name'),
                'description'=>$this->input->post('pro_description'),
                'amount'=>$this->input->post('amount'),
                'duration'=>$this->input->post('duration'),
                'created_by' =>$userid
            );
            $this->db->insert('gp_deal_settings',$data);

            $action = "New deal settings has been added";
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
        function update_deal_by_id()
        {
            $this->db->trans_begin();

            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $id = $this->input->post('hiddentype');
            $data=array(
                'name'=>$this->input->post('title'),
                'description'=>$this->input->post('description'),
                'amount'=>$this->input->post('amount'),
                'duration'=>$this->input->post('duration'),
                'created_by' =>$userid
            );
            $this->db->where('id',$id);
            $this->db->update('gp_deal_settings',$data);
            //echo $this->db->last_query();exit();
            $action = "Deal has been updated";
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
        function delete_deal($datas){
       
            $this->db->trans_begin();
            $ca_ids = $datas['chck_item_id'];
            foreach ($ca_ids as $key => $ca_id) {
               
                $this->db->where('id', $ca_id);
                $qry = $this->db->delete('gp_deal_settings');
                
            }
            $date = date("Y-m-d h:i:sa") ;
            $action = "deleted deal";
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
        function commission_approval1(){
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
        function get_commission_approval_request_count($search)
        {
            if(!empty($search)){
                $keyword = "%{$search}%";
                $where = "and (p.name LIKE '%$keyword%' OR c.category_title LIKE '%$keyword%' OR c.percentage LIKE '%$keyword%' OR u.new_percentage LIKE '%$keyword%')";
            }else{
                $where = '';
            }
            $qry="SELECT u.id  FROM `cp_commission_updations` u LEFT join gp_channel_con_cat_commision c on u.com_id = c.id LEFT JOIN gp_pl_channel_partner p on c.cp_id = p.id where u.status = 1".$where;
            $result=$this->db->query($qry);
            //echo $this->db->last_query();exit();
            if($result->num_rows()>0)
            {
                return $result->num_rows();
            }else {
                return false;
            }
        }
        function get_commission_approval_requests($search,$limit, $start)
        {
            if(!empty($search)){
                $keyword = "%{$search}%";
                $where = "and (p.name LIKE '%$keyword%' OR c.category_title LIKE '%$keyword%' OR c.percentage LIKE '%$keyword%' OR u.new_percentage LIKE '%$keyword%')";
            }else{
                $where = '';
            }
            $qry="SELECT p.name,c.id, c.category_title , c.percentage as old_commission, u.new_percentage as new_commission,u.id as uid  FROM `cp_commission_updations` u LEFT join gp_channel_con_cat_commision c on u.com_id = c.id LEFT JOIN gp_pl_channel_partner p on c.cp_id = p.id where u.status = 1 ".$where." ORDER BY u.id DESC LIMIT $start, $limit";
            $result=$this->db->query($qry);

            if($result->num_rows()>0)
            {
                return $result->result_array();

            }else {
                return array();
            }
        }
          function get_cp_login_id(){
            $sql = $this->db->query("SELECT `p`.`name`, `l`.`id`, `p`.`is_active`
             FROM `gp_pl_channel_partner` `p` left join gp_login_table l on p.id = l.user_id WHERE `p`.`is_del` =0 and `p`.`status` = 'joined'");
            if($sql->num_rows()>0){
                $data=$sql->result_array();
            }
            else{
                $data=array();
            }

            return $data;
        }
        function get_all_cp_status_count($search)
        {
            if(!empty($search)){
                $keyword = "%{$search}%";
                $where = "and (p.name LIKE '%$keyword%')";
            }else{
                $where = '';
            }
            $qry="SELECT `p`.`name`, `l`.`id`, `p`.`is_active`
             FROM `gp_pl_channel_partner` `p` left join gp_login_table l on p.id = l.user_id WHERE `p`.`is_del` =0 and `p`.`status` = 'joined'".$where;
             $result=$this->db->query($qry);
            if($result->num_rows()>0)
            {
                return $result->num_rows();
            }else {
                return false;
            }
        }
        function get_all_cp_status($search,$limit, $start)
        {
            if(!empty($search)){
                $keyword = "%{$search}%";
                $where = "and (p.name LIKE '%$keyword%')";
            }else{
                $where = '';
            }
            $qry="SELECT `p`.`name`, `l`.`id`, `p`.`is_active`
             FROM `gp_pl_channel_partner` `p` left join gp_login_table l on p.id = l.user_id WHERE `p`.`is_del` =0 and `p`.`status` = 'joined'".$where." ORDER BY p.id DESC LIMIT $start, $limit";
            $result=$this->db->query($qry);

            if($result->num_rows()>0)
            {
                return $result->result_array();

            }else {
                return array();
            }
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
        


//admin add ba
    function add_New_ba($countryName,$stateName,$cityName)
    {
        $this->db->trans_begin();
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $created_on = date('Y-m-d H:i:s');
        $name=$this->input->post('ba_name');
        $mobile=$this->input->post('ba_mobile');
        $email=$this->input->post('ba_email');
        $company_name=$this->input->post('ba_company_Name');
        $office_phone=$this->input->post('office_phone');
        $office_emailid=$this->input->post('office_email_id');
        $city=$this->input->post('city');

        $country=$this->input->post('country');
        $otp = random_string('numeric', 5);
        $state=$this->input->post('state');
        $cty = $this->input->post('city');
        $api=apikey_generate();
        $data = array(
            'name' => $name,
            'mobil_no' =>$mobile,
            'email' =>$email,
            'company_name' =>$company_name,
            'office_phno' =>$office_phone,
            'office_email' =>$office_emailid,
            'city' =>$cty,//$cityName,
            'country' =>$country,//$countryName,
            'state' =>$state,//$stateName,
            'otp' => $otp,
            'created_on' => $created_on,
            'created_by' => $lgid,
        );
        

        $this->db->insert('pl_ba_registration', $data);
        $insert_id = $this->db->insert_id();
            $data3 = array(
            'email' => $email,
            'mobile' => $mobile,
            'user_id' =>$insert_id,
            'type' => 'ba',
            'otp_status' => 0,
            'api_key'=>$api
            // 'parent_login_id'=>$log_id
        );
        $qry3 = $this->db->insert('gp_login_table', $data3);
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

          $date = date('Y-m-d H:i:s');
          $financial_year = get_financial_year();
        $qry3 = $this->db->insert_batch('gp_wallet_values', $wallete);
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
          
            $action = "added Jaazzo Store ";
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
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



    function get_baview(){
        $qry="select ba.id ,c.id as country_id,c.name as county_name,
              s.id as state_id,s.name as state_name,ba.name,
              ba.mobil_no,ba.email,
              ba.company_name,
              ba.office_phno,
              ba.office_email,
              ba.city
              FROM pl_ba_registration ba
              left join  countries c ON c.id= ba.country
              left join  states s ON s.id=ba.state where is_del='0'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }



    function get_ba_view_byid($id)
    {

        $qry="select ba.id ,ba.country,ba.state ,
              ba.name,
              ba.mobil_no,ba.email,
              ba.company_name,
              ba.office_phno,
              ba.office_email,
              ba.city
              FROM pl_ba_registration ba
             
              where is_del='0' and ba.id='$id'" ;

        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
        return $data;
    }

    function  edit_ba_by_id($countryName,$stateName,$cityName)
    {



        $hiddenid=$this->input->post('hiddenid');




        $created_on = date('Y-m-d H:i:s');

        $name=$this->input->post('ba_name');
        $mobile=$this->input->post('ba_mobile');
        $email=$this->input->post('ba_email');
        $company_name=$this->input->post('ba_company_Name');
        $office_phone=$this->input->post('office_phone');
        $office_emailid=$this->input->post('office_email_id');
   

        $data = array(
            'name' => $name,
            'mobil_no' =>$mobile,
            'email' =>$email,
            'company_name' =>$company_name,
            'office_phno' =>$office_phone,
            'office_email' =>$office_emailid,
            'city' =>$cityName,
            'country' =>$countryName,
            'state' =>$stateName,
            'created_on' => $created_on,
            'created_by' => 'admin',


        );
       
        $this->db->where('id',$hiddenid);
        $query=  $this->db->update('pl_ba_registration',$data);



           $date = date("Y-m-d h:i:sa") ;
            $action = "updated ba ";
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
        return $query;
    }

    function delete_ba($data)
    {
        $itemgrp = $data['itemgrps'];
        $info = array('is_del' => 1);
        $this->db->where_in('id', $itemgrp);
        $qry = $this->db->update('pl_ba_registration', $info);
        return $qry;
    }

//Admin add executive

    function insert_execbasics($data,$data1,$data3)
    {
        
        $api=apikey_generate();
        $qry = $this->db->insert('gp_pl_sales_team_members', $data);
        $lid=$this->db->insert_id();
        $a1 = $this->input->post('ename');
        $date = date('Y-m-d');
        $data2 = array('sales_team_member_id' => $lid );
        $appended1 = array_merge($data1,$data2);
        $data4 = array( 'user_id' => $lid,'api_key' => $api );
        $appended2 = array_merge($data3,$data4);
        $qry1 = $this->db->insert('gp_pl_sales_team_member_details', $appended1);
        $qry2 = $this->db->insert('gp_login_table', $appended2);
        $u_id=$this->db->insert_id();
        $financial_year = get_financial_year();
      
       
            $data6 = array('wallet_type_id'=>'3',
            'user_id' => $u_id);
        
        $qry3 = $this->db->insert('gp_wallet_values', $data6);
             $hr_ldg = array(
                                    'type_id' => $u_id,
                                    '_type' => 'EXECUTIVE',
                                    'group_id' => 25,
                                    'name' => $u_id ."_".$a1.'_ledger'
                                );
            $acc_qry = $this->db->insert('erp_ac_ledgers', $hr_ldg);
            $leg_id=$this->db->insert_id();


                         $opening = array(
                                    'ledger_id' => $leg_id,
                                    'fy_id' => $financial_year,
                                    'opening_date' =>$date
                                    );
            $open_qry = $this->db->insert('erp_ac_opening_balance', $opening);
        



        //echo $this->db->last_query();exit();

            $action = "Added Executives ";
            $date = date("Y-m-d h:i:sa") ;
            $loginsession = $this->session->userdata('logged_in_admin');
            $userid=$loginsession['user_id'];
            $status = 0;
        activity_log($action,$userid,$status,$date);

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

        function get_executives_count($search)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (gp_member_det.phone LIKE '%$keyword%' OR gp_member_det.email LIKE '%$keyword%' OR gp_desig.designation LIKE '%$keyword%' OR gp_desig.designation LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="select gp_team_mem.*,gp_member_det.name,gp_member_det.phone,gp_member_det.email,gp_member_det.address,gp_desig.designation
        from gp_pl_sales_team_members gp_team_mem
        join gp_pl_sales_team_member_details gp_member_det on gp_team_mem.id = gp_member_det.sales_team_member_id
        join gp_pl_sales_designation_type gp_desig on gp_team_mem.sales_desig_type_id = gp_desig.id
        join gp_login_table on gp_team_mem.id = gp_login_table.user_id where 
        gp_team_mem.is_del ='0'
        and gp_login_table.is_del ='0' and  gp_member_det.is_del ='0' and gp_team_mem.status='ACTIVE'".$where." group by gp_team_mem.id order by gp_team_mem.id desc";
        $qry = $this->db->query($qry);
        //echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            return $qry->num_rows();
        } else{
            return false;
        }

    }
    function get_executives($search,$limit,$start){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (gp_member_det.phone LIKE '%$keyword%' OR gp_member_det.email LIKE '%$keyword%' OR gp_desig.designation LIKE '%$keyword%' OR gp_desig.designation LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="select gp_team_mem.*,gp_member_det.name,gp_member_det.phone,gp_member_det.email,gp_member_det.address,gp_desig.designation
        from gp_pl_sales_team_members gp_team_mem
        join gp_pl_sales_team_member_details gp_member_det on gp_team_mem.id = gp_member_det.sales_team_member_id
        join gp_pl_sales_designation_type gp_desig on gp_team_mem.sales_desig_type_id = gp_desig.id
        join gp_login_table on gp_team_mem.id = gp_login_table.user_id where 
        gp_team_mem.is_del ='0'
        and gp_login_table.is_del ='0' and  gp_member_det.is_del ='0' and gp_team_mem.status='ACTIVE'".$where." group by gp_team_mem.id order by gp_team_mem.id desc  LIMIT $start, $limit";
        $qry = $this->db->query($qry);
       // echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_desigsviewall(){
    $qry="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id
        FROM `gp_pl_sales_designation_type` LEFT JOIN `gp_executive_promotion_settings`
        ON gp_pl_sales_designation_type.id = gp_executive_promotion_settings.designation_id 
        where gp_pl_sales_designation_type.is_del='0' and gp_pl_sales_designation_type.type='executive'
        GROUP BY gp_pl_sales_designation_type.designation  ";
       // echo $qry;
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_executives_id($id){
        $qry="select gp_team_mem.*,gp_member_det.name,gp_member_det.phone,gp_member_det.email,gp_member_det.address,gp_member_det.image,gp_desig.designation,gp_member_det.country,gp_member_det.state,gp_member_det.city from gp_pl_sales_team_members gp_team_mem join gp_pl_sales_team_member_details gp_member_det on gp_team_mem.id = gp_member_det.sales_team_member_id join gp_pl_sales_designation_type gp_desig on gp_team_mem.sales_desig_type_id = gp_desig.id join gp_login_table on gp_team_mem.id = gp_login_table.user_id where gp_team_mem.is_del ='0' and gp_login_table.is_del ='0' and gp_member_det.is_del ='0' and gp_team_mem.id='$id' group by gp_team_mem.id";
        $qry = $this->db->query($qry);
       //echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
        return $data;
    }
        function edit_execbasics($data,$data1)
    {
        $this->db->trans_begin();
        $id = $this->input->post('id');
        $this->db->where('id',$id);
        $qry = $this->db->update('gp_pl_sales_team_members', $data);
     
        $this->db->where('sales_team_member_id',$id);
        $qry1 = $this->db->update('gp_pl_sales_team_member_details', $data1);

        $action = "Edited Executives ";
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

    function delete_exectives($data)
    {
        $itemgrp = $data['itemgrps'];
        $info = array('is_del' => 1);
        $this->db->where_in('id', $itemgrp);
        $qry = $this->db->update('gp_pl_sales_team_members', $info);
        if($qry){
          $this->db->where_in('sales_team_member_id', $itemgrp);
        $qry1 = $this->db->update('gp_pl_sales_team_member_details', $info);  
        }
        return $qry;
    }
    //admin promotion setting

    function get_desigsadd(){
    $qry="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id,gp_pl_sales_designation_type.sort_order FROM `gp_pl_sales_designation_type`  where gp_pl_sales_designation_type.is_del='0' and gp_pl_sales_designation_type.type='executive' and gp_pl_sales_designation_type.slug='team_leader'"; 
        $qry = $this->db->query($qry);
        $result['res'] =  $qry->row_array();
        $sort=$result['res']['sort_order'];
     
       $qry1="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id FROM `gp_pl_sales_designation_type`  where   gp_pl_sales_designation_type.is_del='0' and gp_pl_sales_designation_type.type='executive' and gp_pl_sales_designation_type.sort_order< $sort";
        
        $qry1 = $this->db->query($qry1);
        if($qry1->num_rows()>0){
        
            return $qry1->result_array();
        } else{
            return array();
        }
       // return $data;
    }
    function get_team_leader(){
    $qry="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id,gp_pl_sales_designation_type.sort_order FROM `gp_pl_sales_designation_type`  where gp_pl_sales_designation_type.is_del='0' and gp_pl_sales_designation_type.type='executive' and gp_pl_sales_designation_type.slug='team_leader'";
        $qry = $this->db->query($qry);
        $result['res'] =  $qry->row_array();
        $sort=$result['res']['sort_order'];
     
    $qry1="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id FROM `gp_pl_sales_designation_type`  where id NOT IN(
            SELECT designation_id     FROM gp_executive_promotion_settings) and gp_pl_sales_designation_type.is_del='0' and gp_pl_sales_designation_type.type='executive' and gp_pl_sales_designation_type.sort_order>= $sort";
        //echo $qry1;exit();
        $qry1 = $this->db->query($qry1);
        if($qry1->num_rows()>0){
        
            return $qry1->result_array();
        } else{
            return array();
        }
       // return $data;
    }

    function get_team_leader_sortorder(){
    $qry="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id,gp_pl_sales_designation_type.sort_order FROM `gp_pl_sales_designation_type`  where gp_pl_sales_designation_type.is_del='0' and gp_pl_sales_designation_type.type='executive' and gp_pl_sales_designation_type.slug='team_leader'";
   //secho $qry;exit();
        $qry = $this->db->query($qry);

        //echo $qry1;exit();
       
        if($qry->num_rows()>0){
        
            return $qry->row_array();
        } else{
            return array();
        }
       // return $data;
    }





    function get_team_leader_desig(){
    $qry="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id,gp_pl_sales_designation_type.sort_order FROM `gp_pl_sales_designation_type`  where  gp_pl_sales_designation_type.is_del='0' and gp_pl_sales_designation_type.type='executive' and gp_pl_sales_designation_type.slug='team_leader'";
        $qry = $this->db->query($qry);
        $result['res'] =  $qry->row_array();
        $sort=$result['res']['sort_order'];
     
    $qry1="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id FROM `gp_pl_sales_designation_type`  where id NOT IN(
            SELECT from_desig FROM promotion_gifts where is_del=0 ) and gp_pl_sales_designation_type.is_del='0' and gp_pl_sales_designation_type.type='executive' and gp_pl_sales_designation_type.sort_order>= $sort";
        //echo $qry1;exit();
        $qry1 = $this->db->query($qry1);
        if($qry1->num_rows()>0){
        
            return $qry1->result_array();
        } else{
            return array();
        }
       // return $data;
    }
    function get_team_leader_edit(){
    $qry="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id,gp_pl_sales_designation_type.sort_order FROM `gp_pl_sales_designation_type`  where  gp_pl_sales_designation_type.is_del='0' and gp_pl_sales_designation_type.type='executive' and gp_pl_sales_designation_type.slug='team_leader'";
        $qry = $this->db->query($qry);
        $result['res'] =  $qry->row_array();
        $sort=$result['res']['sort_order'];
     
    $qry1="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id FROM `gp_pl_sales_designation_type`  where gp_pl_sales_designation_type.is_del='0' and gp_pl_sales_designation_type.type='executive' and gp_pl_sales_designation_type.sort_order>= $sort";
        //echo $qry1;exit();
        $qry1 = $this->db->query($qry1);
        if($qry1->num_rows()>0){
        
            return $qry1->result_array();
        } else{
            return array();
        }
       // return $data;
    }
    function get_gift_package(){
        $qry="select g.*,d.designation,sd.designation to_des from promotion_gifts g
        left join gp_pl_sales_designation_type d on d.id=g.from_desig
        left join gp_pl_sales_designation_type sd on sd.id=g.to_desig
         where g.is_del='0'";

        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
    }
    function get_modules1(){
        $qry="select * from gp_systemmodule";

        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_module(){
    $qry="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id,gp_pl_sales_designation_type.sort_order FROM `gp_pl_sales_designation_type`  where gp_pl_sales_designation_type.is_del='0' and gp_pl_sales_designation_type.type='executive' and gp_pl_sales_designation_type.slug='team_leader'";
        $qry = $this->db->query($qry);
        $result['res'] =  $qry->row_array();
        $sort=$result['res']['sort_order'];
     
    $qry1="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id FROM `gp_pl_sales_designation_type`  where gp_pl_sales_designation_type.is_del='0' and gp_pl_sales_designation_type.type='executive' and gp_pl_sales_designation_type.sort_order< $sort";
        
        $qry1 = $this->db->query($qry1);
        if($qry1->num_rows()>0){
        
            return $qry1->result_array();
        } else{
            return array();
        }
       // return $data;
    }

    function get_exec_to_data(){

        $from = $this->input->post('from');
        $qry="select id,designation ,sort_order from gp_pl_sales_designation_type where id ='$from'";
        $qry = $this->db->query($qry);
        $result['res'] =  $qry->row_array();
        $sort=$result['res']['sort_order'];
        $so=$sort+1;

        $qry1="select id,designation ,sort_order from gp_pl_sales_designation_type where sort_order > '$sort' and is_del='0'  and type='executive' order by sort_order asc limit 1 ";
        //echo $qry1;exit();
        $qry1 = $this->db->query($qry1);
        if($qry1->num_rows()>0){
            $data['res'] =  $qry1->result_array();
            //print_r($data['res']);exit();
        } else{
            $data['res'] =  array();
        }
        return $data;
    }
    function insert_setexec($data)
    {


        $qry = $this->db->insert('gp_executive_promotion_settings', $data);
        $promo_id=$this->db->insert_id();
        $count = $this->input->post('co');
        $amount = $this->input->post('am');
        $period  = $this->input->post('pd');
        foreach($count as $key => $co)
        {
            if($co!='0' && $period[$key]!='0'){
                $data1 = array(
                'promo_id'=>$promo_id,
                'count'=>$co,
                //'amount'=>$amount[$key],
                'period'=>$period[$key]
            );
            $qry1 = $this->db->insert('gp_executive_promotion_details', $data1);
            return $qry1;
            } 

        }
       
    }


    function get_desigsview(){
        $qry="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id
        FROM `gp_pl_sales_designation_type` LEFT JOIN `gp_executive_promotion_settings`
        ON gp_pl_sales_designation_type.id = gp_executive_promotion_settings.designation_id
        WHERE gp_executive_promotion_settings.designation_id IS NOT NULL
        GROUP BY gp_pl_sales_designation_type.designation order by gp_pl_sales_designation_type.sort_order";
        //echo $qry;exit();
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }

    function get_desigid($id){
        $qry="select * from gp_pl_sales_designation_type where id=$id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_settings($id){

        $qry="select * from gp_executive_promotion_settings where designation_id=$id";
       
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }

        function get_exec_to(){

        $from = $this->input->post('from');

        $qry="select gs.id,gs.designation from gp_executive_promotion_settings gps inner join gp_pl_sales_designation_type gs
    on    gps.promotion_designation = gs.id   where gps.designation_id ='$from' and gs.is_del='0'";
    //echo $qry;exit();
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            $data['res'] =  $qry->result_array();
        } else{
            $data['res'] =  array();
        }
    }
    
    function get_promotion_view(){
      
        $from= $this->input->post('from');
        $to= $this->input->post('to');
        $qry="select pr.*,type.designation desg,type1.designation promo ,details.amount,details.count,details.period,details.id as det_id from gp_executive_promotion_settings pr
        left join gp_pl_sales_designation_type type on type.id=pr.designation_id
        left join gp_pl_sales_designation_type type1 on type1.id=pr.promotion_designation
        left join gp_executive_promotion_details details on details.promo_id=pr.id
        where pr.designation_id=$from and pr.promotion_designation=$to ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        
    }

    function get_promoted_employee_count($search)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " where (gs.name LIKE '%$keyword%' OR gd.designation LIKE '%$keyword%' OR pn.date LIKE '%$keyword%' )";
        }else{
            $where = '';
        }

         $qry="SELECT pn.*,gs.name,gd.designation from promotion_notification pn
            LEFT JOIN gp_login_table  gp on gp.id=pn.user_id
            LEFT JOIN gp_pl_sales_team_member_details gs on gs.id=gp.user_id
            LEFT JOIN gp_pl_sales_designation_type gd on gd.id=pn.designation  ".$where." ";

            $qry = $this->db->query($qry);
        //echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            return $qry->num_rows();
        } else{
            return false;
        }



    }
        function promoted_employee($search,$limit,$start){


             if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " where (gs.name LIKE '%$keyword%' OR gd.designation LIKE '%$keyword%' OR pn.date LIKE '%$keyword%' )";
        }else{
            $where = '';
        }

        $qry="SELECT pn.*,gs.name,gd.designation from promotion_notification pn
            LEFT JOIN gp_login_table  gp on gp.id=pn.user_id
            LEFT JOIN gp_pl_sales_team_member_details gs on gs.id=gp.user_id
            LEFT JOIN gp_pl_sales_designation_type gd on gd.id=pn.designation  ".$where." LIMIT $start, $limit ";
        //echo $qry;exit();
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function add_gift($images)
    {
        $name = $this->input->post('name');
        $from = $this->input->post('dsig');
        $to  = $this->input->post('desigto');
        $description  = $this->input->post('details');
        $image  = $images;
        $data1 = array(
                'package_name'=>$name, 
                'from_desig'=>$from,
                'to_desig'=>$to,
                'description'=>$description,
                'image'=>$image
            );
        $qry1 = $this->db->insert('promotion_gifts', $data1);
  

        return $qry1;
    }
    function update_gift($images)
    {
        $id = $this->input->post('id');
        $name = $this->input->post('name');
        $from = $this->input->post('dsig');
        $to  = $this->input->post('desigto');
        $description  = $this->input->post('details');
        $image  = $images;
        if($image!=''){
        $data1 = array(
                'package_name'=>$name, 
                'from_desig'=>$from,
                'to_desig'=>$to,
                'description'=>$description,
                'image'=>$image
            );
            $this->db->where('id',$id);
            $this->db->update('promotion_gifts',$data1);
        }
        else{
                $data1 = array(
                'package_name'=>$name, 
                'from_desig'=>$from,
                'to_desig'=>$to,
                'description'=>$description
               
            );
            $this->db->where('id',$id);
            $this->db->update('promotion_gifts',$data1); 
        }
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
    function delete_gift($data)
    {
        $itemgrp = $data['itemgrps'];
        $info = array('is_del' => 1);
        $this->db->where_in('id', $itemgrp);
        $qry = $this->db->update('promotion_gifts', $info);
        return $qry;
    }
    function exec_transaction_details(){
       $qry="SELECT sm.name,gw.total_value,gw.id as waletid ,login.id as exe_id FROM `gp_pl_sales_team_members` sm
           left join gp_login_table login on login.user_id=sm.id
           left join gp_wallet_values gw on gw.user_id=login.id
           where gw.total_value !=0 and gw.wallet_type_id=3";
        $qry=$this->db->query($qry);
        //echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            $data['details']=$qry->result_array();
        }
        else{
            $data['details']=array();
        }

        return $data;
    }
        function exec_transaction_details_count($search){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (sm.name LIKE '%$keyword%' OR gw.total_value  LIKE '%$keyword%' OR gw.id LIKE '%$keyword%' OR login.id LIKE '%$keyword%' ) AND sm.id IS NOT NULL ";
        }else{
            $where = '';
        }
       $qry="SELECT sm.name,gw.total_value,gw.id as waletid ,login.id as exe_id FROM `gp_pl_sales_team_members` sm
           left join gp_login_table login on login.user_id=sm.id
           left join gp_wallet_values gw on gw.user_id=login.id
           where gw.total_value !=0 and gw.wallet_type_id=3";
        
        $query=$this->db->query($qry);
        if($query){
            return $query->num_rows();
        }
        else{
             return false;
        }
        return $data;
    }
    function exec_transaction_details_all($search,$limit=NULL,$start=NULL){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (sm.name LIKE '%$keyword%' OR gw.total_value  LIKE '%$keyword%' OR gw.id LIKE '%$keyword%'  ) AND gw.id IS NOT NULL ";
        }else{
            $where = '';
        }
           if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
       $qry="SELECT sm.name,gw.total_value,gw.id as waletid ,login.id as exe_id FROM `gp_pl_sales_team_members` sm
           left join gp_login_table login on login.user_id=sm.id
           left join gp_wallet_values gw on gw.user_id=login.id
           where gw.total_value !=0 and gw.wallet_type_id='3'".$where."".$pg;
        
        $query=$this->db->query($qry);
        if($query){
            $data['details']=$query->result_array();
        }
        else{
            $data['details']=array();
        }
        return $data;
    }
    function exec_trans_details($id){
        $qry="select trans.*,DATE_FORMAT(trans.transaction_date,'%d-%m-%Y %H:%i')as transaction_date FROM gp_cp_transaction trans 
              where trans._to=$id ";
         
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function exec_trans_details_count($id,$search){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (trans.mode LIKE '%$keyword%' OR trans.narration  LIKE '%$keyword%' OR trans.mode LIKE '%$keyword%' OR trans.mode LIKE '%$keyword%' ) AND trans.id IS NOT NULL ";
        }else{
            $where = '';
        }
           $qry="select trans.*,DATE_FORMAT(trans.transaction_date,'%d-%m-%Y %H:%i')as transaction_date FROM gp_cp_transaction trans 
              where trans._to='$id'".$where."";


        $query=$this->db->query($qry);
        if($query){
            return $query->num_rows();
        }
        else{
             return false;
        }
        return $data;

}
function exec_trans_details_all($search,$limit=NULL,$start=NULL,$id){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (trans.mode LIKE '%$keyword%' OR trans.narration  LIKE '%$keyword%' OR trans.mode LIKE '%$keyword%' OR trans.mode LIKE '%$keyword%' ) AND trans.id IS NOT NULL ";
        }else{
            $where = '';
        }
           if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
          $qry = "select trans.*,DATE_FORMAT(trans.transaction_date,'%d-%m-%Y %H:%i')as transaction_date FROM gp_cp_transaction trans 
              where trans._to='$id'".$where."".$pg;

        $query=$this->db->query($qry);
        if($query){
            $data['member']=$query->result_array();
        }
        else{
            $data['member']=array();
        }
        return $data;

}

    function new_transaction($userid,$lgid){
        $cur_date=date('Y-m-d H:i:s');
        $mode= $this->input->post('payment_mode');     
        
        $transaction_date = date('Y-m-d H:i',strtotime($this->input->post('transaction_date')));
       // var_dump($transaction_date);exit();
        $cheque_date = date('Y-m-d',strtotime($this->input->post('cheque_date')));
        $p_for= $this->input->post('payment_for');
        $this->db->trans_begin();
        if(in_array("wallet", $p_for))
        {

            $payed_amt=$this->input->post('pay_amount');
            $total_amount=$this->input->post('pending_amount');
            $pending_amt=$total_amount-$payed_amt;
           
                $walletid = $this->db->select('id')->where('user_id',$lgid)->get('gp_wallet_values')->row('id');
                if($walletid)
                    {$data=array(
                                'total_value'=>$pending_amt
                            );
                            $this->db->where('id',$walletid);
                            $this->db->update('gp_wallet_values',$data);
                   
                            $transdata=array(
                                'from'=>'1',
                                '_to'=>$lgid,
                                'total_amount'=>$total_amount,
                                'transaction_amount'=>$payed_amt,
                                'transaction_date'=>$transaction_date,
                                'narration'=>$this->input->post('narration'),
                                'cheque_number'=>$this->input->post('cheque_number'),
                                'bank_name'=>$this->input->post('bank'),
                                'cheque_date'=>$cheque_date,
                                'status'=>1,
                                'mode'=>$mode,
                                'created_on'=>$cur_date
                            );
                            $this->db->insert('gp_cp_transaction',$transdata);
                            
                            $insert_id = $this->db->insert_id();
                            //entry creation
                            $no =get_number();
                            $fy_year = get_current_financial_year();
                             $fy_id = $fy_year['id'];
                            $ac_data = array(
                                'entrytype_id'=>4,
                                '_type'=>'TRANSACTION',
                                'type_id'=>$insert_id,
                                'number'=>$no,
                                'fy_id' =>$fy_id,
                                'date'=>date('Y-m-d'),
                                'dr_total'=>$payed_amt,
                                'cr_total'=>$payed_amt
                            );
                            $this->db->insert('erp_ac_entries',$ac_data);
                          
                            $entry_id = $this->db->insert_id();
                            $type = 'CHANNEL_PARTNER';
                            $ledger_payment_dr = getLedgerId($lgid,$type);
                            if($mode=='cash')
                                $ledger_payment_cr = 32;
                            else
                                $ledger_payment_cr = 35;
                            $entry_items_cr = array(
                                'entry_id' => $entry_id,
                                'ledger_id' => $ledger_payment_cr,
                                'amount' => $payed_amt,
                                'fy_id' =>$fy_id,
                                'dc' => 'Cr',
                                'created_date' => date('Y-m-d')
                            );
                             
                            $entry_items_dr = array(
                                'entry_id' => $entry_id,
                                'ledger_id' => $ledger_payment_dr,
                                'amount' => $payed_amt,
                                'fy_id' =>$fy_id,
                                'dc' => 'Dr',
                                'created_date' => date('Y-m-d')
                            );

                            $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);
                            $entry_dr = $this->db->insert('erp_ac_entryitems', $entry_items_dr);
                            $date = date("Y-m-d h:i:sa") ;
                            $action = "wallet amount transfferd to channel partner";
                            $status = 0;

                            activity_log($action,$userid,$status,$date);

                    }
       
          }
        if(in_array("coupon", $p_for))
        {
          $cp_amount= $this->input->post('pay_coupon'); 
          //var_dump($cp_amount);exit();
          if(!empty($cp_amount)){
          
            $cpid = $this->input->post('hidden_id');
            $cp_lg_id = $this->db->select('user_id')->where('id',$cpid)->get('gp_login_table')->row('user_id');
           
            $cpn_total = $this->db->query("SELECT c.amount,c.id FROM `coupon` c left join gp_deal_channel_partner_con d on d.id = c.deal_con where c.is_del = '0' and c.is_paid = '0' and d.channel_partner_id = '$cp_lg_id'");
            if($cpn_total->num_rows()>0){
              
                $cpn_total = $cpn_total->result_array();
                $cp_amount1 = (int)$cp_amount;
                foreach ($cpn_total as $keyc => $cpn) {
                    $c_id = $cpn['id'];
                    $c_amt = $cpn['amount'];
                    $c_amt1 = (int)$c_amt;
                    //$paid = $this->db->select('sum(paid)')->where('coupon_id',$c_id)->get('coupon_receipt')->row('paid');
                    $pquery = $this->db->query("select sum(r.paid) as tot from coupon_receipt r where r.coupon_id = '$c_id' group by r.coupon_id");
                    if($pquery->num_rows()>0){

                      $pq = $pquery->row();
                      $paid = $pq->tot;
                     //. var_dump($paid);exit();
                   // $this->balance_amount($c_id);    
                   $paid1 = (int)$paid;
                    

                        if($c_amt1>$paid1)
                        {
                          //var_dump($c_amt1);var_dump($paid1);
                          $bal = $c_amt1 - $paid1;
                          if($cp_amount1>=$bal){
                           // var_dump("expression1");
                            //update
                            $up = array('is_paid' => '1');
                            $this->db->where('id',$c_id);
                            $this->db->update('coupon',$up);  
                                //insert
                            
                            $ins = array('amount' => $c_amt1,'paid' => $bal, 'coupon_id'=> $c_id);
                               $this->db->insert('coupon_receipt',$ins);
                               $insert_id = $this->db->insert_id();
                              $cp_amount1 = $cp_amount1 - $bal;

                            }else{
                               // var_dump("expression13");
                                  $ins = array('amount' => $c_amt1,'paid' => $cp_amount1, 'coupon_id'=> $c_id);
                                  $this->db->insert('coupon_receipt',$ins);
                                  $insert_id = $this->db->insert_id();
                                  $cp_amount1 = $cp_amount1 - $cp_amount1; 
                            }  
                        }
                                    else{
                                    if($cp_amount1>=$c_amt1){
                                      //  var_dump("expression2");
                                    //update
                                    $up = array('is_paid' => '1');
                                    $this->db->where('id',$c_id);
                                    $this->db->update('coupon',$up);  
                                        //insert
                                    $ins = array('amount' => $c_amt1,'paid' => $c_amt1, 'coupon_id'=> $c_id);
                                       $this->db->insert('coupon_receipt',$ins);
                                       $insert_id = $this->db->insert_id();
                                      $cp_amount1 = $cp_amount1 - $c_amt1; 
                                    }else{
                                        //var_dump("expression3");
                                         //insert
                                       $ins = array('amount' => $c_amt1,'paid' => $cp_amount1, 'coupon_id'=> $c_id);
                                       $this->db->insert('coupon_receipt',$ins);
                                       $insert_id = $this->db->insert_id();
                                       $cp_amount1 = $cp_amount1 - $cp_amount1;
                                    }
                                }
                     }   
                    else{
                        if($cp_amount1>=$c_amt1){
                           // var_dump("expression4");
                        //update
                        $up = array('is_paid' => '1');
                        $this->db->where('id',$c_id);
                        $this->db->update('coupon',$up);  
                            //insert
                        $ins = array('amount' => $c_amt1,'paid' => $c_amt1, 'coupon_id'=> $c_id);
                           $this->db->insert('coupon_receipt',$ins);
                         $insert_id = $this->db->insert_id();
                          $cp_amount1 = $cp_amount1 - $c_amt1; 
                        }else{
                            //var_dump("expression5");
                             //insert
                           $ins = array('amount' => $c_amt1,'paid' => $cp_amount1, 'coupon_id'=> $c_id);
                           $this->db->insert('coupon_receipt',$ins);
                           $insert_id = $this->db->insert_id();
                           $cp_amount1 = $cp_amount1 - $cp_amount1;
                        }
                    }
                    
                  if($cp_amount1<=0){
                    break;
                  }           
                }
                $fy_year = get_current_financial_year();
              $fy_id = $fy_year['id'];
              $no =get_number();
                $ac_data = array(
                    'entrytype_id'=>4,
                    '_type'=>'DEAL_TRANSACTION',
                    'type_id'=>$insert_id,
                    'number'=>$no,
                    'fy_id' =>$fy_id,
                    'date'=>date('Y-m-d'),
                    'dr_total'=>$cp_amount,
                    'cr_total'=>$cp_amount
                );
                $this->db->insert('erp_ac_entries',$ac_data);
                $entry_id = $this->db->insert_id();
                $type = 'CHANNEL_PARTNER';
                $ledger_payment_dr = getLedgerId($cpid,$type);
                if($mode=='cash')
                    $ledger_payment_cr = 32;
                else
                    $ledger_payment_cr = 35;
                           
                $entry_items_cr = array(
                    'entry_id' => $entry_id,
                    'ledger_id' => $ledger_payment_cr,
                    'amount' => $cp_amount,
                    'dc' => 'Cr',
                    'fy_id' =>$fy_id,
                    'created_date' => date('Y-m-d')
                );
                $entry_items_dr = array(
                    'entry_id' => $entry_id,
                    'ledger_id' => $ledger_payment_dr,
                    'amount' => $cp_amount,
                    'dc' => 'Dr',
                    'fy_id' =>$fy_id,
                    'created_date' => date('Y-m-d')
                );
                $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);
                $entry_dr = $this->db->insert('erp_ac_entryitems', $entry_items_dr);

            }
            else{
                 //var_dump("expression9");
            }
          }else{
            // var_dump("expression10");
          }  
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
    // public function balance_amount($c_id)
    // {
        
    // }
    function last_transaction_details($from,$to){
        $qry=$this->db->query("SELECT * from gp_cp_transaction t where t.from = '$from' and t._to = '$to' and t.status = '0'");
        if($qry->num_rows()>0){
            $data=$qry->result_array();
        }
        else{
            $data=array();
        }

        return $data;
    }
    function get_pending_transaction_count($search){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (cp.name LIKE '%$keyword%')";
        }else{
            $where = '';
        }
       $qry="SELECT l.id,cp.name from gp_purchase_bill_notification pb LEFT JOIN gp_login_table l ON pb.channel_partner_id = l.user_id left join gp_pl_channel_partner cp on cp.id = pb.channel_partner_id where l.type = 'Channel_partner' ".$where." GROUP by pb.channel_partner_id";


        $query=$this->db->query($qry);
        if($query){
            return $query->num_rows();
        }
        else{
             return false;
        }
        return $data;

    }
    function get_pending_transaction($search,$limit, $start){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (cp.name LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $data = array();
        $id_array = array();
        $qry_cp = $this->db->query("SELECT l.id,cp.name from gp_purchase_bill_notification pb LEFT JOIN gp_login_table l ON pb.channel_partner_id = l.user_id left join gp_pl_channel_partner cp on cp.id = pb.channel_partner_id  where l.type = 'Channel_partner' ".$where." GROUP by pb.channel_partner_id LIMIT $start, $limit");
        if($qry_cp->num_rows()>0){
            $cps = $qry_cp->result();

            $cp_details = array();
            
            foreach ($cps as $key => $value) {
             
                $login_id = $value->id;
                $qry_to_admin = $this->db->query("SELECT round(sum(cp.transaction_amount),2) as amount FROM `gp_cp_transaction` cp WHERE cp.from = '$login_id' and cp._to = '1'");
              
                $qry_to_admin = $qry_to_admin->row();
                $to_admin = $qry_to_admin->amount;
                //var_dump($to_admin);
                $qry_to_cp = $this->db->query("SELECT round(sum(cp.transaction_amount),2) as amount FROM `gp_cp_transaction` cp WHERE cp.from = '1' and cp._to = '$login_id'");
                $qry_to_cp = $qry_to_cp->row();
                $to_cp = $qry_to_cp->amount;
               // var_dump($to_cp);
                $qry_amt = $this->db->query("SELECT round(sum(pb.wallet_total), 2) as wallet_total ,round(sum(pb.total_commission),2) as total_commission FROM `gp_purchase_bill_notification` pb LEFT JOIN gp_login_table l on pb.channel_partner_id = l.user_id WHERE pb.status='1' and l.id = '$login_id'");
                $qry_amt = $qry_amt->row();
                $wallet_total = $qry_amt->wallet_total;
                $total_commission = $qry_amt->total_commission;
                //var_dump($wallet_total);
                //var_dump($total_commission);
                $pending = round(($total_commission - $wallet_total + $to_cp - $to_admin),2);
                 //var_dump($pending);exit();

                if($pending<0)
                 {array_push($data, array('id' => $login_id,'name' => $value->name, 'amount' => $pending, 'coupon'=>'0' ));
                   array_push($id_array, $login_id);
                  }
            }
        }
        $coupon_query = $this->db->query("SELECT cp.name,l.id,SUM(c.amount) as total,c.id as coupon_id from coupon c LEFT JOIN gp_deal_channel_partner_con d on c.deal_con = d.id LEFT JOIN gp_pl_channel_partner cp on cp.id = d.channel_partner_id LEFT join gp_login_table l on l.user_id = cp.id WHERE c.is_paid = '0' and c.is_del = '0' ".$where." GROUP by cp.id");
        if($coupon_query->num_rows()>0){
            $coupon = $coupon_query->result_array();
            foreach ($coupon as $key1 => $val) {
                 $coupon_id = $val['coupon_id'];
                 $cid = $val['id'];
                 $total = $val['total'];
                 $c_query = $this->db->query("SELECT sum(r.paid) as paid FROM coupon_receipt r WHERE r.coupon_id = '$coupon_id'");
                 $c_query = $c_query->row();
                 $paid = $c_query->paid;
                 $paid = (empty($paid)) ? 0 : $paid;
                 $bal = $total - $paid;
                 if(in_array($cid, $id_array)){
                       foreach($data as &$va){
                            if($va['id'] == $cid){
                                if(!empty($bal)){
                                 $va['coupon'] = $bal;
                                 } 
                                break; // Stop the loop after we've found the item
                            }
                        }
                 }else{
                   if(!empty($bal)){ 
                     array_push($data, array('id' => $cid,'name' => $val['name'], 'amount' => '0', 'coupon'=>$bal ));
                    }
                 }
            }
            

        }else{
             $data = array();
        }
        return $data;    
    }
    function get_transaction_details(){
        
        $data = array();
        $id_array = array();
        $qry_cp = $this->db->query("SELECT l.id,cp.name from gp_purchase_bill_notification pb LEFT JOIN gp_login_table l ON pb.channel_partner_id = l.user_id left join gp_pl_channel_partner cp on cp.id = pb.channel_partner_id  where l.type = 'Channel_partner' GROUP by pb.channel_partner_id");
        if($qry_cp->num_rows()>0){
            $cps = $qry_cp->result();

            $cp_details = array();
            
            foreach ($cps as $key => $value) {
             
                $login_id = $value->id;
                $qry_to_admin = $this->db->query("SELECT round(sum(cp.transaction_amount),2) as amount FROM `gp_cp_transaction` cp WHERE cp.from = '$login_id' and cp._to = '1'");
              
                $qry_to_admin = $qry_to_admin->row();
                $to_admin = $qry_to_admin->amount;
                //var_dump($to_admin);
                $qry_to_cp = $this->db->query("SELECT round(sum(cp.transaction_amount),2) as amount FROM `gp_cp_transaction` cp WHERE cp.from = '1' and cp._to = '$login_id'");
                $qry_to_cp = $qry_to_cp->row();
                $to_cp = $qry_to_cp->amount;
               // var_dump($to_cp);
                $qry_amt = $this->db->query("SELECT round(sum(pb.wallet_total), 2) as wallet_total ,round(sum(pb.total_commission),2) as total_commission FROM `gp_purchase_bill_notification` pb LEFT JOIN gp_login_table l on pb.channel_partner_id = l.user_id WHERE pb.status='1' and l.id = '$login_id'");
                $qry_amt = $qry_amt->row();
                $wallet_total = $qry_amt->wallet_total;
                $total_commission = $qry_amt->total_commission;
                //var_dump($wallet_total);
                //var_dump($total_commission);
                $pending = round(($total_commission - $wallet_total + $to_cp - $to_admin),2);
                 //var_dump($pending);exit();

                if($pending<0)
                 {array_push($data, array('id' => $login_id,'name' => $value->name, 'amount' => $pending, 'coupon'=>'0' ));
                   array_push($id_array, $login_id);
                  }
            }
        }
        $coupon_query = $this->db->query("SELECT cp.name,l.id,SUM(c.amount) as total,c.id as coupon_id from coupon c LEFT JOIN gp_deal_channel_partner_con d on c.deal_con = d.id LEFT JOIN gp_pl_channel_partner cp on cp.id = d.channel_partner_id LEFT join gp_login_table l on l.user_id = cp.id WHERE c.is_paid = '0' and c.is_del = '0' GROUP by cp.id");
        if($coupon_query->num_rows()>0){
            $coupon = $coupon_query->result_array();
            foreach ($coupon as $key1 => $val) {
                 $coupon_id = $val['coupon_id'];
                 $cid = $val['id'];
                 $total = $val['total'];
                 $c_query = $this->db->query("SELECT sum(r.paid) as paid FROM coupon_receipt r WHERE r.coupon_id = '$coupon_id'");
                 $c_query = $c_query->row();
                 $paid = $c_query->paid;
                 $paid = (empty($paid)) ? 0 : $paid;
                 $bal = $total - $paid;
                 if(in_array($cid, $id_array)){
                       foreach($data as &$va){
                            if($va['id'] == $cid){
                                if(!empty($bal)){
                                 $va['coupon'] = $bal;
                                 } 
                                break; // Stop the loop after we've found the item
                            }
                        }
                 }else{
                   if(!empty($bal)){ 
                     array_push($data, array('id' => $cid,'name' => $val['name'], 'amount' => '0', 'coupon'=>$bal ));
                    }
                 }
            }
            

        }else{
             $data = array();
        }
        return $data;    
    }
    function get_transaction_details2(){
        $qry_cp = $this->db->query("SELECT l.id,cp.name,cp.is_active from gp_purchase_bill_notification pb LEFT JOIN gp_login_table l ON pb.channel_partner_id = l.user_id left join gp_pl_channel_partner cp on cp.id = pb.channel_partner_id  where l.type = 'Channel_partner' GROUP by pb.channel_partner_id");
        if($qry_cp->num_rows()>0){
            $cps = $qry_cp->result();

            $cp_details = array();
            $data = array();
            foreach ($cps as $key => $value) {
                $active = $value->is_active;
                $login_id = $value->id;
                $qry_to_admin = $this->db->query("SELECT round(sum(cp.transaction_amount),2) as amount FROM `gp_cp_transaction` cp WHERE cp.from = '$login_id' and cp._to = '1' ");
              
                $qry_to_admin = $qry_to_admin->row();
                $to_admin = $qry_to_admin->amount;
               // var_dump($to_admin);
                $qry_to_cp = $this->db->query("SELECT round(sum(cp.transaction_amount),2) as amount FROM `gp_cp_transaction` cp WHERE cp.from = '1' and cp._to = '$login_id' ");
                $qry_to_cp = $qry_to_cp->row();
                $to_cp = $qry_to_cp->amount;
                //var_dump($to_cp);
                $qry_amt = $this->db->query("SELECT round(sum(pb.wallet_total), 2) as wallet_total ,round(sum(pb.total_commission),2) as total_commission FROM `gp_purchase_bill_notification` pb LEFT JOIN gp_login_table l on pb.channel_partner_id = l.user_id WHERE pb.status='1' and l.id = '$login_id'");
                $qry_amt = $qry_amt->row();
                $wallet_total = $qry_amt->wallet_total;
                $total_commission = $qry_amt->total_commission;
               // var_dump($wallet_total);var_dump($total_commission);exit;
                $pending = $total_commission - $wallet_total + $to_cp - $to_admin;
               
                if($pending>0)
                 {array_push($data, array('id' => $login_id,'name' => $value->name, 'amount' => $pending, 'active' => $active));}
            }
        }else{
            $data = array();
        }
        return $data;
        
    }
    function get_cp_pending_transaction_count($search){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (cp.name LIKE '%$keyword%')";
        }else{
            $where = '';
        }
       $qry="SELECT l.id,cp.name,cp.is_active from gp_purchase_bill_notification pb LEFT JOIN gp_login_table l ON pb.channel_partner_id = l.user_id left join gp_pl_channel_partner cp on cp.id = pb.channel_partner_id  where l.type = 'Channel_partner'  ".$where." GROUP by pb.channel_partner_id";


        $query=$this->db->query($qry);
        if($query){
            return $query->num_rows();
        }
        else{
             return false;
        }
        return $data;

    }
    function get_cp_pending_transaction($search,$limit, $start){

        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (cp.name LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry_cp = $this->db->query("SELECT l.id,cp.name,cp.is_active from gp_purchase_bill_notification pb LEFT JOIN gp_login_table l ON pb.channel_partner_id = l.user_id left join gp_pl_channel_partner cp on cp.id = pb.channel_partner_id  where l.type = 'Channel_partner'  ".$where." GROUP by pb.channel_partner_id LIMIT $start, $limit");
        if($qry_cp->num_rows()>0){
            $cps = $qry_cp->result();

            $cp_details = array();
            $data = array();
            foreach ($cps as $key => $value) {
                $active = $value->is_active;
                $login_id = $value->id;
                $qry_to_admin = $this->db->query("SELECT round(sum(cp.transaction_amount),2) as amount FROM `gp_cp_transaction` cp WHERE cp.from = '$login_id' and cp._to = '1' ");
              
                $qry_to_admin = $qry_to_admin->row();
                $to_admin = $qry_to_admin->amount;
               // var_dump($to_admin);
                $qry_to_cp = $this->db->query("SELECT round(sum(cp.transaction_amount),2) as amount FROM `gp_cp_transaction` cp WHERE cp.from = '1' and cp._to = '$login_id' ");
                $qry_to_cp = $qry_to_cp->row();
                $to_cp = $qry_to_cp->amount;
                //var_dump($to_cp);
                $qry_amt = $this->db->query("SELECT round(sum(pb.wallet_total), 2) as wallet_total ,round(sum(pb.total_commission),2) as total_commission FROM `gp_purchase_bill_notification` pb LEFT JOIN gp_login_table l on pb.channel_partner_id = l.user_id WHERE pb.status='1' and l.id = '$login_id'");
                $qry_amt = $qry_amt->row();
                $wallet_total = $qry_amt->wallet_total;
                $total_commission = $qry_amt->total_commission;
               // var_dump($wallet_total);var_dump($total_commission);exit;
                $pending = $total_commission - $wallet_total + $to_cp - $to_admin;
               
                if($pending>0)
                 {array_push($data, array('id' => $login_id,'name' => $value->name, 'amount' => $pending, 'active' => $active));}
            }
        }else{
            $data = array();
        }
        return $data;
        
    }

   function cp_change_active_status($status){

             $id = $this->input->post('id');
            
             $active = ($status=='1')? '0' : '1';
        
             
             $sql = $this->db->query("select l.email,l.mobile,cp.name,cp.id from gp_login_table l left join gp_pl_channel_partner cp on l.user_id = cp.id where l.id = '$id' and cp.is_del = '0' and cp.status = 'joined'");
             if($sql->num_rows()>0){
                $this->db->trans_begin();
                $res = $sql->row();
                $u_id = $res->id;
                $data=array(
                       'is_active'=> $active
                    );   
                    $this->db->where('id', $u_id);
                    $this->db->update('gp_pl_channel_partner',$data);
                    $info = array('name' =>$res->name ,'email' =>$res->email ,'mobile' =>$res->mobile );
                    $date = date("Y-m-d h:i:sa");
                     $title = ($status==0)? "Account Activation" :"Account Deactivation";
                     $des = ($status==0)? "Your account has been activated again, enjoy jaazzo fecilities." :"Your account has been frozen due to not paying the agreed reward amount. Please clear all the dues quickly and enjoy jaazzo fecilities.";
                      $noty = array('title'=>$title,'description'=>$des,'from'=> $u_id,'_to'=>'1' ,'des_type_id'=>'2' ,'login_id'=>$id,'type' => 'user', 'created_on' => $date);
                      $this->db->insert('admin_notifications',$noty);
                    $action = ($status==0)? "activated channel partner" : "deactivated channel partner";
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
                        return $info;
                    }
             
             }else{
                return false;
             }
            
        }
   function get_na_cp_transaction(){
        $qry_to_admin = $this->db->query("SELECT cp.id, p.name, cp.transaction_amount as amount FROM `gp_cp_transaction` cp left join gp_login_table l on cp.from = l.id LEFT join gp_pl_channel_partner p on l.user_id = p.id WHERE cp._to = '1' and cp.status = '0' and l.type='Channel_partner' "); 
        if($qry_to_admin->num_rows()>0) 
         {$data = $qry_to_admin->result();}
        else{
            $data = array();
        }    
        return $data;
    }
    function get_all_na_cp_transaction_count($search)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (p.name LIKE '%$keyword%' OR cp.transaction_amount LIKE '%$keyword%' OR cp.mode LIKE '%$keyword%' OR cp.cheque_number LIKE '%$keyword%' OR cp.bank_name LIKE '%$keyword%' OR DATE_FORMAT(cp.cheque_date ,'%d-%b-%Y') LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="SELECT cp.id, p.name, cp.transaction_amount as amount FROM `gp_cp_transaction` cp left join gp_login_table l on cp.from = l.id LEFT join gp_pl_channel_partner p on l.user_id = p.id WHERE cp._to = '1' and cp.status = '0' and l.type='Channel_partner'".$where;
        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else {
            return false;
        }
    }      
     function get_all_na_cp_transaction($search,$limit,$start)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (p.name LIKE '%$keyword%' OR cp.transaction_amount LIKE '%$keyword%' OR cp.mode LIKE '%$keyword%' OR cp.cheque_number LIKE '%$keyword%' OR cp.bank_name LIKE '%$keyword%' OR DATE_FORMAT(cp.cheque_date ,'%d-%b-%Y') LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="SELECT cp.id, p.name, cp.transaction_amount as amount,cp.mode,cp.cheque_number,cp.bank_name, DATE_FORMAT(cp.cheque_date ,'%d-%b-%Y') as cheque_date FROM `gp_cp_transaction` cp left join gp_login_table l on cp.from = l.id LEFT join gp_pl_channel_partner p on l.user_id = p.id WHERE cp._to = '1' and cp.status = '0' and l.type='Channel_partner' ".$where." ORDER BY cp.id DESC LIMIT $start, $limit";
        $result=$this->db->query($qry);
       
        if($result->num_rows()>0)
        {
            return $result->result_array();
        }else {
            return false;
        }
    }
    function approve_cp_transaction(){

            $this->db->trans_begin();
            $data=array(
                 'status'=> 1
            );
            $id = $this->input->post('id');
            $this->db->where('id', $id);
            $this->db->update('gp_cp_transaction',$data);
           // echo $this->db->last_query();exit();
            $date = date("Y-m-d h:i:sa") ;
            $action = "approved a transaction Commission";
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
     function reject_cp_transaction(){

        $this->db->trans_begin();
        $id = $this->input->post('id');
        $this->db->where('id', $id);
        $this->db->select('*');
        $res = $this->db->get('gp_cp_transaction');
        $res = $res->row();
        $this->db->where('id',$id);
        $this->db->delete('gp_cp_transaction');
        $res2 = $this->db->where('type_id',$id)->where('_type','TRANSACTION')->select('id')->get('erp_ac_entries');
        $entry_id = $res2->row('id');
        $this->db->where('id',$entry_id);
        $this->db->delete('erp_ac_entries');
        $this->db->where('entry_id',$entry_id);
        $this->db->delete('erp_ac_entryitems');
        $date = date("Y-m-d h:i:sa") ;
        $action = "Rejected channel partner commission";
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
            return $res;
        }
    }
    function validate_email($email)
    {
        $data = array();
       $qry = "select * from gp_login_table where email = '$email'  ";
        $qry = $this->db->query($qry);
        
        if($qry->num_rows()>0)
        {
            $data['reason'] = "Email id already Exists";
            $data['status'] = FALSE;
        } else{
            $data['status'] =  TRUE;
        }
        return $data;
    } 
    function validate_phone($phone)
    {
        $data = array();
        $qry2 = "select * from gp_login_table where mobile = '$phone' ";
            $qry2 = $this->db->query($qry2);
            if($qry2->num_rows()>0)
            {
               
                $data['reason'] = "Phone no already Exists";
                $data['status'] = FALSE;
            } else{
                $data['status'] =  TRUE;
            }
            
        
        return $data;
    } 
    function edit_promotion_by_id($id){
        $data = array();
        $this->db->trans_begin();
       // echo $id;exit();
        $count = $this->input->post('count');
        $amount = $this->input->post('amount');
        $period = $this->input->post('period');
        $datas = array('amount' => $amount,
            'count' => $count,
            'period' => $period

            );
        $this->db->where('id',$id);
        $this->db->update('gp_executive_promotion_details',$datas);
       //echo $this->db->last_query();exit;
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data['status'] = FALSE;
        } else {
            $this->db->trans_commit();
            $data['status'] = TRUE;
        }
        return $data;

    }  
    function edit_add_promotion_by_id(){
        $data = array();
        $this->db->trans_begin();
       // echo $id;exit();
        $count = $this->input->post('count');
        $amount = $this->input->post('amount');
        $period = $this->input->post('period');
        $promo_id = $this->input->post('promo_id');
        $datas = array(
            'count' => $count,
            'period' => $period,
            'amount' => $amount,
            'promo_id' => $promo_id

            );
        $this->db->insert('gp_executive_promotion_details',$datas);
       //echo $this->db->last_query();exit;
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $data['status'] = FALSE;
        } else {
            $this->db->trans_commit();
            $data['status'] = TRUE;
        }
        return $data;

    }  
     function get_cp_payments_count($search)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (cp.amount LIKE '%$keyword%' OR ch.name LIKE '%$keyword%' OR ch.phone LIKE '%$keyword%' OR clubmember.name LIKE '%$keyword%' OR con.coupon_code LIKE '%$keyword%' )";
        }else{
            $where = '';
        }

         $qry="select cp.amount , ch.name, ch.phone,clubmember.name club_name,con.coupon_code,con.is_paid  
        from gp_deal_channel_partner_con cp
            left join coupon con on con.deal_con = cp.id
            left join gp_pl_channel_partner ch on ch.id =cp.channel_partner_id
            left join gp_normal_customer clubmember on clubmember.id =con.user_id

            where con.is_del='0'  ".$where." ORDER BY cp.id DESC ";
        $result=$this->db->query($qry);

       if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else {
            return false;
        }
         
    }

  
    function get_cp_payments($search,$limit, $start)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (cp.amount LIKE '%$keyword%' OR ch.name LIKE '%$keyword%' OR ch.phone LIKE '%$keyword%' OR clubmember.name LIKE '%$keyword%' OR con.coupon_code LIKE '%$keyword%')";
        }else{
            $where = '';
        }

         $qry="select con.amount , ch.name, ch.phone,clubmember.name club_name,con.coupon_code,con.is_paid  
        from gp_deal_channel_partner_con cp
            left join coupon con on con.deal_con = cp.id
            left join gp_pl_channel_partner ch on ch.id =cp.channel_partner_id
            left join gp_normal_customer clubmember on clubmember.id =con.user_id

            where con.is_del='0'  ".$where." ORDER BY cp.id DESC LIMIT $start, $limit";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->result_array();

        }else {
            return array();
        }
         
    }
   
    function get_cps_by_status_count($search,$status)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (cp.name LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%' OR cp.email LIKE '%$keyword%' OR cp.cname LIKE '%$keyword%' OR cp.c_email LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.c_mobile LIKE '%$keyword%' OR cp.address LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="select cp.id as cp_id, cp.name, cp.phone, cp.phone2, cp.email,log.user_id,clubmember.name club_name ,cp.cname,cp.c_email,cp.phone,cp.c_mobile,cp.address from gp_pl_channel_partner cp
            left join gp_login_table log on cp.club_mem_id = log.id
            left join gp_normal_customer clubmember on clubmember.id =log.user_id
            where cp.is_del='0' and cp.status='$status' ".$where;
        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else {
            return false;
        }
    }
     function get_cps_spec_by_status_count($search,$status)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (cp.name LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%' OR cp.email LIKE '%$keyword%' OR cp.owner_name LIKE '%$keyword%' OR cp.c_email LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.owner_mobile LIKE '%$keyword%'  OR cp.pan LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="select
                cp.id as cp_id
                from
                gp_pl_channel_partner_type_connection con
                left join gp_pl_channel_partner cp on cp.id = con.channel_partner_id
                left join gp_pl_channel_partner_types typ on typ.id = con.channel_partner_type_id
                where cp.is_del='0' and cp.status = '$status'
                group by cp.id ".$where;
        $result=$this->db->query($qry);
        //echo $this->db->last_query();exit();
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else {
            return false;
        }
    }
    function get_cps_spec_by_status($search,$status,$limit, $start)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (cp.name LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%' OR cp.email LIKE '%$keyword%' OR cp.owner_name LIKE '%$keyword%' OR cp.c_email LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.owner_mobile LIKE '%$keyword%'  OR cp.pan LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="select
                cp.id as cp_id,cp.name, cp.phone,cp.owner_mobile,
                cp.email,cp.owner_name,cp.otp,cp.pan,
                GROUP_CONCAT(typ.title) as cp_type, 
                typ.description,cp.status,otp,cp.pan
                from
                gp_pl_channel_partner_type_connection con
                left join gp_pl_channel_partner cp on cp.id = con.channel_partner_id
                left join gp_pl_channel_partner_types typ on typ.id = con.channel_partner_type_id
                where cp.is_del='0' and cp.status = '$status'
                group by cp.id ".$where." ORDER BY cp.id DESC LIMIT $start, $limit";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->result_array();

        }else {
            return array();
        }
    }
    function get_all_cps_by_status($search,$status,$limit, $start)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (cp.name LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%' OR cp.email LIKE '%$keyword%' OR cp.owner_name LIKE '%$keyword%' OR cp.c_email LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.owner_mobile LIKE '%$keyword%' OR cp.address LIKE '%$keyword%'  OR cp.pan LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="select cp.id as cp_id, cp.name, cp.phone, cp.phone2, cp.email,log.user_id,clubmember.name club_name ,cp.owner_name,cp.c_email,cp.phone,cp.owner_mobile,cp.address,cp.pan,cp.club_type from gp_pl_channel_partner cp
            left join gp_login_table log on cp.club_mem_id = log.id
            left join gp_normal_customer clubmember on clubmember.id =log.user_id
            where cp.is_del='0' and cp.status='$status' ".$where." ORDER BY cp.id DESC LIMIT $start, $limit";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->result_array();

        }else {
            return array();
        }
    }
    function add_refered_partner($otp,$qr_no){
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        
        $id=$this->input->post('id');
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
        $image_file1 = "upload/".$p1;
        $image_file2 = "assets/admin/brand/".$p2;
        if(($extension1=="jpg")||($extension1=="JPG")||($extension1=="png")||($extension1=="PNG")||($extension1=="JPEG")||($extension1=="jpeg")||($extension1=="gif")||($extension1=="GIF"))
        {
           move_uploaded_file($_FILES['pro']['tmp_name'],"upload/".$p1);
        }
       
        if(($extension2=="jpg")||($extension2=="JPG")||($extension2=="png")||($extension2=="PNG")||($extension2=="JPEG")||($extension2=="jpeg")||($extension2=="gif")||($extension2=="GIF"))
        {
           move_uploaded_file($_FILES['bri']['tmp_name'],"assets/admin/brand/".$p2);
        }
        $module = $this->input->post('module');
        $name = $this->input->post('name');
        $string = str_replace(' ','',$name);
        $myStr = substr($string, 0, 3);  
        $qrcode = strtoupper($myStr).$qr_no;
        $this->db->trans_begin();
      
        $data=array(
            'name'=>$name,
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
            'created_by'=>$lgid,
            'status'=>'APPROVED',
            'lattitude'=>$this->input->post('latt'),
            'longitude'=>$this->input->post('long'),
            'module'=>$module,
            'otp'=>$otp,
            'qr_code' =>$qrcode,
            'profile_image'=> $image_file1,
            'brand_image'=> $image_file2
        );
        $this->db->where('id', $id);
        $this->db->update('gp_pl_channel_partner',$data);

        $channel_type=$this->input->post('channel_type');
        foreach($channel_type as $key => $type){
            $data=array(
                'channel_partner_type_id'=>$type,
                'channel_partner_id'=>$id,
                'module_id' => $module
            );
            $this->db->insert('gp_pl_channel_partner_type_connection',$data);
        }
        $logindata=array(
            'email'=>$this->input->post('email'),
            'mobile'=>$this->input->post('phone'),
            'otp_status' => 0,
            'user_id'=>$id,
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
            return $id;
        }
    }


    function get_sales_type()
    {
        $qry="select * from gp_pl_sales_designation_type where is_del!='1' and id != 4 ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }

    function get_sales_member_by_id($type_id)
    {

        //echo $type_id;exit();
        if($type_id=='1'){

                  $qry = "select
                        s.id,s.name,l.id as log_id
                        from
                        gp_normal_customer s left join gp_login_table l on s.id = l.user_id
                        where s.type = 'club_member' and l.type = 'club_member'";
                $qry = $this->db->query($qry);
                if($qry->num_rows()>0)
                {
                    return $qry->result_array();
                }   else{
                    return array();
                }
        }


        else if($type_id=='2')
        {
            $qry = "select
                        c.id,c.name,l.id as log_id
                        from
                        gp_pl_channel_partner c left join gp_login_table l on c.id = l.user_id
                        where l.type='Channel_partner'
                        ";
                $qry = $this->db->query($qry);
                if($qry->num_rows()>0)
                {
                    return $qry->result_array();
                }   else{
                    return array();
                }
        }

        else if($type_id=='3')
        {
             $qry = "select
                        s1.id,s1.name,l.id as log_id
                        from
                        gp_normal_customer s1
                        left join gp_login_table l on s1.id = l.user_id
                        where s1.type = 'club_agent' and l.type='club_agent'";
                $qry = $this->db->query($qry);
                if($qry->num_rows()>0)
                {
                    return $qry->result_array();
                }   else{
                    return array();
                }
        }
        else if($type_id=='normal_customer')
        {
             $qry = "select
                        s.id,s.name,l.id as log_id 
                        from
                        gp_normal_customer s left join gp_login_table l on s.id = l.user_id
                        where s.type = 'normal_customer' and l.type = 'normal_customer'";
                $qry = $this->db->query($qry);
                if($qry->num_rows()>0)
                {
                    return $qry->result_array();
                }   else{
                    return array();
                }
        }
        else if($type_id=='investor')
        {
             $qry = "select
                        s.id,s.name,l.id as log_id 
                        from
                        gp_normal_customer s left join gp_login_table l on s.id = l.user_id
                        where s.type = 'club_member' and l.type = 'club_member' and s.investor_type_id >0 and s.club_type_id =0 and s.fixed_club_type_id =0";
                $qry = $this->db->query($qry);
                if($qry->num_rows()>0)
                {
                    return $qry->result_array();
                }   else{
                    return array();
                }
        }
        else if($type_id=='unlimited')
        {
             $qry = "select
                        s.id,s.name,l.id as log_id 
                        from
                        gp_normal_customer s left join gp_login_table l on s.id = l.user_id
                        where s.type = 'club_member' and l.type = 'club_member' and s.club_type_id >0";
                $qry = $this->db->query($qry);
                if($qry->num_rows()>0)
                {
                    return $qry->result_array();
                }   else{
                    return array();
                }
        }
        else if($type_id=='fixed')
        {
             $qry = "select
                        s.id,s.name,l.id as log_id 
                        from
                        gp_normal_customer s left join gp_login_table l on s.id = l.user_id
                        where s.type = 'club_member' and l.type = 'club_member' and s.fixed_club_type_id >0";
                $qry = $this->db->query($qry);
                if($qry->num_rows()>0)
                {
                    return $qry->result_array();
                }   else{
                    return array();
                }
        }
        else{

             $qry = "select
                        st.id,st.name,l.id as log_id
                        from
                        gp_pl_sales_team_members st
                        left join gp_login_table l on st.id = l.user_id
                        where st.sales_desig_type_id = '$type_id' and l.type='executive'"; 
                $qry = $this->db->query($qry);
                if($qry->num_rows()>0)
                {
                    return $qry->result_array();
                }   else{
                    return array();
                }

              }

      }

    function add_new_notification()
    {

        $type = $this->input->post('type');
        $log_id = $this->input->post('log_id');
        $member = $this->input->post('members');
        $title  = $this->input->post('title');
        $description  = $this->input->post('description');
       
        $data1 = array(
                'des_type_id'=>$type,
                'from'=>'1', 
                '_to'=>$member,
                'title'=>$title,
                'description'=>$description,
                'login_id'=>$log_id,
                'created_on'=>date('Y-m-d'),
                'is_del' => '0'
                
            );
        $qry1 = $this->db->insert('admin_notifications', $data1);
  

        return $qry1;
    }


    function get_all_notification_count($search)
    {

       if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (name LIKE '%$keyword%' OR designation LIKE '%$keyword%' OR title LIKE '%$keyword%' OR description LIKE '%$keyword%') AND id IS NOT NULL ";
        }else{
            $where = '';
        }

$qry1="SELECT name,designation,title,description,id  FROM (SELECT cs.name as name,des.designation as designation,n.title as title,n.description,n.id,n.type
FROM admin_notifications n
LEFT JOIN gp_normal_customer cs ON cs.id = n._to
left join gp_pl_sales_designation_type  des on n.des_type_id=des.id

where  n.is_del!='1' and (n.des_type_id='1'  or n.des_type_id='3')


UNION


SELECT ch.name as name,des1.designation as designation,n1.title as title,n1.description ,n1.id,n1.type
FROM admin_notifications n1
LEFT JOIN gp_pl_channel_partner ch ON ch.id = n1._to
left join gp_pl_sales_designation_type  des1 on n1.des_type_id=des1.id

where n1.des_type_id='2'  and n1.is_del!='1'

UNION
SELECT sm.name as name,des2.designation as designation,n2.title as title,n2.description,n2.id,n2.type
FROM admin_notifications n2
LEFT JOIN gp_pl_sales_team_members sm ON sm.id = n2._to
left join gp_pl_sales_designation_type  des2 on n2.des_type_id=des2.id

where n2.des_type_id NOT IN (1,2,3)  and n2.is_del!='1' 

 ) as mergedTable  ".$where."";


$result=$this->db->query($qry1);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else{
            return false;
        }

    }

    function get_all_notification($search,$limit=NULL,$start=NULL)
    {

if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (name LIKE '%$keyword%' OR designation LIKE '%$keyword%' OR title LIKE '%$keyword%' OR description LIKE '%$keyword%') AND id IS NOT NULL  order by id DESC";
        }else{
            $where = ' order by id DESC';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }



  $qry1="SELECT name,name2,designation,title,description,id,type  FROM (SELECT cs.name as name,cs22.name as name2,des.designation as designation,n.title as title,n.description,n.id,n.type
FROM admin_notifications n
LEFT JOIN gp_normal_customer cs ON cs.id = n._to and n.type='admin'
LEFT JOIN gp_normal_customer cs22 ON cs22.id = n.from and n.type!='admin'

left join gp_pl_sales_designation_type  des on n.des_type_id=des.id

where  n.is_del!='1' and (n.des_type_id='1'  or n.des_type_id='3')


UNION


SELECT ch.name as name,ch22.name as name2,des1.designation as designation,n1.title as title,n1.description ,n1.id,n1.type
FROM admin_notifications n1
LEFT JOIN gp_pl_channel_partner ch ON ch.id = n1._to and n1.type='admin'
LEFT JOIN gp_pl_channel_partner ch22 ON ch22.id = n1.from and n1.type!='admin'

left join gp_pl_sales_designation_type  des1 on n1.des_type_id=des1.id

where n1.des_type_id='2'  and n1.is_del!='1'

UNION


SELECT sm.name as name,sm1.name as name2,des2.designation as designation,n2.title as title,n2.description ,n2.id,n2.type
FROM admin_notifications n2
LEFT JOIN gp_pl_sales_team_members sm ON sm.id = n2._to and n2.type='admin'
LEFT JOIN gp_pl_sales_team_members sm1 ON sm1.id = n2.from and n2.type!='admin'

left join gp_pl_sales_designation_type  des2 on n2.des_type_id=des2.id

where n2.des_type_id NOT IN (1,2,3)  and n2.is_del!='1' 




 ) as mergedTable ".$where." ".$pg;  


 $qry = $this->db->query($qry1);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }

    }

    function delete_notification($datas)
    {
           $this->db->trans_begin();
        $ca_ids = $datas['chck_item_id'];

 $info = array('is_del' => 1);
        $this->db->where_in('id', $ca_ids);
        $qry = $this->db->update('admin_notifications', $info);

        $date = date("Y-m-d h:i:sa") ;
        $action = "deleted notification ";
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

    function get_user_type_mobile($type)
    {

if($type=='club_member'||$type=='club_agent'||$type=='normal_customer')
{

          $qry = "select
                s.id,s.name,s.phone
                from
                gp_normal_customer s
                where s.type = '$type' ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else
        {
            return array();
        }
}


else if($type=='Channel_partner')
{
    $qry = "select
                c.id,c.name,c.phone2 as phone
                from
                gp_pl_channel_partner c
                ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }
}




else{

     $qry = "select
                st.id,st.name,smd.phone
                from
                gp_pl_sales_team_members st

                left join gp_pl_sales_team_member_details smd on smd.sales_team_member_id=st.id
                "; 
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else{
            return array();
        }

}
    }

    function get_cm_transaction_count($search){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where1 = " AND (gw.total_value LIKE '%$keyword%' OR 
            nc.name LIKE '%$keyword%')";
        }else{
            $where1 = '';
        }
        $query="SELECT gw.id as waletid ,gw.total_value,nc.name,login.id as mem_id FROM gp_login_table login left join gp_normal_customer nc on login.user_id=nc.id left join club_member_type typ on nc.investor_type_id=typ.id left join gp_wallet_values gw on gw.user_id=login.id where nc.investor_type_id>0 and nc.investor_type_id>0 and gw.wallet_type_id=3 and gw.total_value>0 ".$where1;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
            
        }else{
            return false;
        }
    }
    function get_all_cm_transaction($search,$limit=NULL,$start=NULL){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where1 = " AND (gw.total_value LIKE '%$keyword%' OR 
            nc.name LIKE '%$keyword%')";
        }else{
            $where1 = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT gw.total_value,nc.name,login.id as mem_id,gw.id as waletid  FROM gp_login_table login left join gp_normal_customer nc on login.user_id=nc.id left join club_member_type typ on nc.investor_type_id=typ.id left join gp_wallet_values gw on gw.user_id=login.id where nc.investor_type_id>0 and nc.investor_type_id>0 and gw.wallet_type_id=3 and gw.total_value>0 ".$where1.$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->result_array();
            
        }else{
            return false;
        }
    }
    function add_cm_transaction(){

        $this->db->trans_begin();
        $payed_amt=$this->input->post('pay_amt');
        $id=$this->input->post('cp_hiddenid');
        $walletid=$this->input->post('wallet_hiddenid');
        $total_amount=$this->input->post('total_amtvalue');
        $pending_amt=$total_amount-$payed_amt;
        $tdate = date('Y-m-d H:i',strtotime($this->input->post('transaction_date')));
        
        $data=array(
            'total_value'=>$pending_amt
        );
        $this->db->where('id',$walletid);
        $this->db->update('gp_wallet_values',$data);
        $cur_date=date('Y-m-d H:i:s');
        $payment_mode =$this->input->post('payment_mode');
        $transdata=array(
            'from' =>'1',
            '_to' =>$id,
            'total_amount'=>$total_amount,
            'transaction_amount'=>$payed_amt,
            'transaction_date'=>$tdate,
            'narration'=>$this->input->post('narration'),
            'status'=>"1",
            'mode' =>$this->input->post('payment_mode'),
            'created_on'=>$cur_date
        );
        if($payment_mode=='cheque'){
            $transdata['cheque_number']=$this->input->post('cheque_number');
            $transdata['bank_name']=$this->input->post('bank');
            $transdata['cheque_date']=convert_to_mysql($this->input->post('cheque_date'));
        }
        $this->db->insert('gp_cp_transaction',$transdata);

           $date = date("Y-m-d h:i:sa") ;
           $action = "added new transaction ";
           $loginsession = $this->session->userdata('logged_in_admin');
           $userid=$loginsession['user_id'];
           $status = 0;
           activity_log($action,$userid,$status,$date);
        //Entry Start
            $fy_year = get_current_financial_year();
            $fy_id = $fy_year['id'];
           
            $no =get_number();
            $ent_data = array(
                'entrytype_id'=>2,
                '_type'=>'TRANSACTION',
                'type_id'=>$id,
                'number'=>$no,
                'fy_id' =>$fy_id,
                'date'=>date('Y-m-d'),
                'dr_total'=>$payed_amt,
                'cr_total'=>$payed_amt,
            );
            $this->db->insert('erp_ac_entries',$ent_data);
            $entry_id = $this->db->insert_id();
           
            //$ledger_payment_cr = 72;
            $type = 'CUSTOMER';
            $ledger_payment_dr = getLedgerId($id,$type);
            if($payment_mode=='cash'){
                $ledger_payment_cr = 32;
            }
            else if($payment_mode=='cheque'){
                $ledger_payment_cr = 35;
            }else {
                $ledger_payment_cr = 35;
            }
            $entry_items_cr = array(
                'entry_id' => $entry_id,
                'ledger_id' => $ledger_payment_cr,
                'amount' => $payed_amt,
                'dc' => 'Cr',
                'fy_id' =>$fy_id,
                'created_date' => date('Y-m-d')
            );
            $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);

            $entry_items_dr = array(
                'entry_id' => $entry_id,
                'ledger_id' => $ledger_payment_dr,
                'amount' => $payed_amt ,
                'dc' => 'Dr',
                'fy_id' =>$fy_id,
                'created_date' => date('Y-m-d')
            );
            $entry_dr = $this->db->insert('erp_ac_entryitems', $entry_items_dr);
            //Entry End
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
    function get_cm_transaction_byid_count($search,$id){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where1 = " AND (transaction_amount LIKE '%$keyword%' OR 
            narration LIKE '%$keyword%' OR 
            DATE_FORMAT(transaction_date,'%d-%m-%Y %H:%i') LIKE '%$keyword%' OR
            mode LIKE '%$keyword%' OR bank_name LIKE '%$keyword%' OR 
            cheque_number LIKE '%$keyword%' OR 
            DATE_FORMAT(cheque_date,'%d-%m-%Y') LIKE '%$keyword%')";
        }else{
            $where1 = '';
        }
        $query="select transaction_amount,narration,DATE_FORMAT(transaction_date,'%d-%m-%Y %H:%i')as transaction_date,
        mode,cheque_number,bank_name,DATE_FORMAT(cheque_date,'%d-%m-%Y')AS cdate
              FROM gp_cp_transaction trans
              where trans._to=$id ".$where1.' ORDER BY id DESC ';
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
            
        }else{
            return false;
        }
    }
    function get_all_cm_transaction_byid($search,$id,$limit=NULL,$start=NULL){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where1 = " AND (transaction_amount LIKE '%$keyword%' OR 
            narration LIKE '%$keyword%' OR 
            DATE_FORMAT(transaction_date,'%d-%m-%Y %H:%i') LIKE '%$keyword%' OR 
            mode LIKE '%$keyword%' OR bank_name LIKE '%$keyword%' OR 
            cheque_number LIKE '%$keyword%' OR 
            DATE_FORMAT(cheque_date,'%d-%m-%Y') LIKE '%$keyword%')";
        }else{
            $where1 = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="select id,transaction_amount,narration,DATE_FORMAT(transaction_date,'%d-%m-%Y %H:%i')as transaction_date,
        mode,cheque_number,bank_name,DATE_FORMAT(cheque_date,'%d-%m-%Y')AS cdate
              FROM gp_cp_transaction trans
              where trans._to=$id ".$where1.' ORDER BY id DESC '.$pg;
        $result=$this->db->query($query);//echo $this->db->last_query();
        if($result->num_rows()>0)
        {
            return $result->result_array();
            
        }else{
            return false;
        }
    }
    function update_preference($id)
    {
        $value = $this->input->post('value');
        $data = array('value' => $value);
        $this->db->where('id', $id);
        $qry = $this->db->update('gp_preference', $data);
        return $qry;
    }
    function get_ca_transaction_count($search){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where1 = " AND (gw.total_value LIKE '%$keyword%' OR 
            nc.name LIKE '%$keyword%')";
        }else{
            $where1 = '';
        }
        $query="SELECT gw.id as waletid ,gw.total_value,nc.name,login.id as mem_id FROM gp_login_table login left join gp_normal_customer nc on login.user_id=nc.id left join gp_wallet_values gw on gw.user_id=login.id where nc.investor_type_id=0 and gw.wallet_type_id=3 and gw.total_value>0 ".$where1;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
            
        }else{
            return false;
        }
    }
    function get_all_ca_transaction($search,$limit=NULL,$start=NULL){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where1 = " AND (gw.total_value LIKE '%$keyword%' OR 
            nc.name LIKE '%$keyword%')";
        }else{
            $where1 = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT gw.total_value,nc.name,login.id as mem_id,gw.id as waletid  FROM gp_login_table login left join gp_normal_customer nc on login.user_id=nc.id left join gp_wallet_values gw on gw.user_id=login.id where nc.investor_type_id=0 and gw.wallet_type_id=3 and gw.total_value>0 ".$where1.$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->result_array();
            
        }else{
            return false;
        }
    }
    function add_ca_transaction(){

        $this->db->trans_begin();
        $payed_amt=$this->input->post('pay_amt');
        $id=$this->input->post('cp_hiddenid');
        $walletid=$this->input->post('wallet_hiddenid');
        $total_amount=$this->input->post('total_amtvalue');
        $pending_amt=$total_amount-$payed_amt;
        $tdate = date('Y-m-d H:i',strtotime($this->input->post('transaction_date')));
        $data=array(
            'total_value'=>$pending_amt
        );
        $this->db->where('id',$walletid);
        $this->db->update('gp_wallet_values',$data);
        $cur_date=date('Y-m-d H:i:s');
        $payment_mode =$this->input->post('payment_mode');
        $transdata=array(
            'from' =>'1',
            '_to' =>$id,
            'total_amount'=>$total_amount,
            'transaction_amount'=>$payed_amt,
            'transaction_date'=>$tdate,
            'narration'=>$this->input->post('narration'),
            'status'=>"1",
            'mode' =>$this->input->post('payment_mode'),
            'created_on'=>$cur_date
        );
        if($payment_mode=='cheque'){
            $transdata['cheque_number']=$this->input->post('cheque_number');
            $transdata['bank_name']=$this->input->post('bank');
            $transdata['cheque_date']=convert_to_mysql($this->input->post('cheque_date'));
        }
        $this->db->insert('gp_cp_transaction',$transdata);

           $date = date("Y-m-d h:i:sa") ;
           $action = "added new transaction ";
           $loginsession = $this->session->userdata('logged_in_admin');
           $userid=$loginsession['user_id'];
           $status = 0;
           activity_log($action,$userid,$status,$date);
        //Entry Start
            $fy_year = get_current_financial_year();
            $fy_id = $fy_year['id'];
           
            $no =get_number();
            $ent_data = array(
                'entrytype_id'=>2,
                '_type'=>'TRANSACTION',
                'type_id'=>$id,
                'number'=>$no,
                'fy_id' =>$fy_id,
                'date'=>date('Y-m-d'),
                'dr_total'=>$payed_amt,
                'cr_total'=>$payed_amt,
            );
            $this->db->insert('erp_ac_entries',$ent_data);
            $entry_id = $this->db->insert_id();
           
            $ledger_payment_cr = 72;
            if($payment_mode=='cash'){
                $ledger_payment_dr = 32;
            }
            else {
                $ledger_payment_dr = 35;
            }
            $entry_items_cr = array(
                'entry_id' => $entry_id,
                'ledger_id' => $ledger_payment_cr,
                'amount' => $payed_amt,
                'dc' => 'Cr',
                'fy_id' =>$fy_id,
                'created_date' => date('Y-m-d')
            );
            $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);

            $entry_items_dr = array(
                'entry_id' => $entry_id,
                'ledger_id' => $ledger_payment_dr,
                'amount' => $payed_amt ,
                'dc' => 'Dr',
                'fy_id' =>$fy_id,
                'created_date' => date('Y-m-d')
            );
            $entry_dr = $this->db->insert('erp_ac_entryitems', $entry_items_dr);
            //Entry End
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
    function get_ref_cps_by_status_count($search,$status)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (cp.name LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%' OR cp.email LIKE '%$keyword%' OR cp.cname LIKE '%$keyword%' OR cp.c_email LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.c_mobile LIKE '%$keyword%' OR cp.address LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="select cp.id as cp_id, cp.name, cp.phone, cp.phone2, cp.email,log.user_id,clubmember.name club_name ,cp.cname,cp.c_email,cp.phone,cp.c_mobile,cp.address from gp_pl_channel_partner cp
            left join gp_login_table log on cp.club_mem_id = log.id
            left join gp_normal_customer clubmember on clubmember.id =log.user_id
            where cp.is_del='0' and cp.status='$status' and cp.club_type!='INVESTOR' ".$where;
        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else {
            return false;
        }
    }
    function get_all_ref_cps_by_status($search,$status,$limit, $start)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (cp.name LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%' OR cp.email LIKE '%$keyword%' OR cp.owner_name LIKE '%$keyword%' OR cp.c_email LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.owner_mobile LIKE '%$keyword%' OR cp.address LIKE '%$keyword%'  OR cp.pan LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="select cp.id as cp_id, cp.name, cp.phone, cp.phone2, cp.email,log.user_id,clubmember.name club_name ,cp.owner_name,cp.c_email,cp.phone,cp.owner_mobile,cp.address,cp.pan,cp.club_type from gp_pl_channel_partner cp
            left join gp_login_table log on cp.club_mem_id = log.id
            left join gp_normal_customer clubmember on clubmember.id =log.user_id
            where cp.is_del='0' and cp.status='$status' and cp.club_type!='INVESTOR' ".$where." ORDER BY cp.id DESC LIMIT $start, $limit";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->result_array();

        }else {
            return array();
        }
    }
    function get_tl_ref_cps_by_status_count($search,$status)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (cp.name LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%' OR cp.email LIKE '%$keyword%' OR cp.cname LIKE '%$keyword%' OR cp.c_email LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.c_mobile LIKE '%$keyword%' OR cp.address LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="select cp.id as cp_id, cp.name, cp.phone, cp.phone2, cp.email,log.user_id,clubmember.name club_name ,cp.cname,cp.c_email,cp.phone,cp.c_mobile,cp.address from gp_pl_channel_partner cp
            left join gp_login_table log on cp.club_mem_id = log.id
            left join gp_normal_customer clubmember on clubmember.id =log.user_id
            where cp.is_del='0' and cp.status='$status' and cp.club_type='INVESTOR' ".$where;
        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else {
            return false;
        }
    }
    function get_all_tl_ref_cps_by_status($search,$status,$limit, $start)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "and (cp.name LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.phone2 LIKE '%$keyword%' OR cp.email LIKE '%$keyword%' OR cp.owner_name LIKE '%$keyword%' OR cp.c_email LIKE '%$keyword%' OR cp.phone LIKE '%$keyword%' OR cp.owner_mobile LIKE '%$keyword%' OR cp.address LIKE '%$keyword%'  OR cp.pan LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="select cp.id as cp_id, cp.name, cp.phone, cp.phone2, cp.email,log.user_id,clubmember.name club_name ,cp.owner_name,cp.c_email,cp.phone,cp.owner_mobile,cp.address,cp.pan,cp.club_type from gp_pl_channel_partner cp
            left join gp_login_table log on cp.club_mem_id = log.id
            left join gp_normal_customer clubmember on clubmember.id =log.user_id
            where cp.is_del='0' and cp.status='$status' and cp.club_type='INVESTOR' ".$where." ORDER BY cp.id DESC LIMIT $start, $limit";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->result_array();

        }else {
            return array();
        }
    }
    function approve_deal_purchase(){
        $this->db->trans_begin();
        $id = $this->input->post('id');
        $qry = $this->db->query("select * from gp_deal_channel_partner_con c where id='$id'");
        if($qry->num_rows()>0){
            $up=array(
                'is_paid'=>'1'   
            );
            $this->db->where('id',$id);
            $this->db->update('gp_deal_channel_partner_con',$up);
            $qry = $qry->row();
            $amount = $qry->amount;
            $mode = $qry->payment_mode;
            $cpid = $qry->channel_partner_id;
            $det = random_select("user_id='$cpid'","id","gp_login_table","row");
            $lgid = $det->id;
            
            if(!empty($amount)){
                $fy_year = get_current_financial_year();
                $fy_id = $fy_year['id'];  
                $no =get_number();
                $data = array(
                    'entrytype_id'=>4,
                    '_type'=>'DEAL_PURCHASE',
                    'type_id'=>$id,
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
                if($mode=='CASH')
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
        }else{
            return false;
        }    
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    } 
    function get_deals_count($search)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "WHERE (d.name LIKE '%$keyword%' OR d.amount LIKE '%$keyword%' OR d.duration LIKE '%$keyword%' OR d.description LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="SELECT d.id 
          FROM gp_deal_settings d  
           ".$where." group by d.id order by d.id desc";
        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else {
            return false;
        }
    }

    function get_all_deal_details($search,$limit, $start){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = "WHERE (d.name LIKE '%$keyword%' OR d.amount LIKE '%$keyword%' OR d.duration LIKE '%$keyword%' OR d.description LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $data = array();
        $id_array = array();
        $qry = $this->db->query("SELECT d.id,d.name,d.duration,d.description,d.amount from gp_deal_settings d ".$where." ORDER BY d.id DESC LIMIT $start, $limit");
        if($qry->num_rows()>0){
            return $qry->result_array();
        }else{
            return array();
        }
    }

    function get_all_ba_count($search){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (ba.name LIKE '%$keyword%' OR ba.mobil_no LIKE '%$keyword%' OR ba.email LIKE '%$keyword%' OR ba.company_name LIKE '%$keyword%' OR ba.office_phno LIKE '%$keyword%' OR ba.office_email LIKE '%$keyword%' OR ci.name  LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $qry="SELECT ba.id FROM `pl_ba_registration` ba
              left join  countries c ON c.id= ba.country
              left join  states s ON s.id=ba.state 
              left join  cities ci ON ci.state_id=s.id
              where is_del='0' ".$where;
    
        $query=$this->db->query($qry);
        if($query){
            return $query->num_rows();
        }
        else{
             return false;
        }
        return $data;
    }
    function get_all_ba($search,$limit, $start){
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " and (ba.name LIKE '%$keyword%' OR ba.mobil_no LIKE '%$keyword%' OR ba.email LIKE '%$keyword%' OR ba.company_name LIKE '%$keyword%' OR ba.office_phno LIKE '%$keyword%' OR ba.office_email LIKE '%$keyword%' OR ci.name LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        $data = array();
        $id_array = array();
        $qry="SELECT ba.id ,ba.name,
              ba.mobil_no,ba.email,
              ba.company_name,
              ba.office_phno,
              ba.office_email,
              ci.name as city FROM `pl_ba_registration` ba
              left join  countries c ON c.id= ba.country
              left join  states s ON s.id=ba.state
              left join cities ci ON ci.state_id=s.id 
              where is_del='0' ".$where." ORDER BY ba.id DESC LIMIT $start, $limit";
        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            return $query->result_array();
        }else{
            return array();
        }
    }
}
?>