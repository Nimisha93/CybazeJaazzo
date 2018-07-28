<?php
Class Report_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function get_rewards_by_members_count($search)
    {
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
        $resultt =array();
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where1 = " AND nc.name LIKE '%$keyword%'";
        }else{
            $where1 = '';
        }
        $query="SELECT log.id,nc.name FROM gp_login_table log JOIN gp_normal_customer nc  ON log.user_id = nc.id
        WHERE log.parent_login_id = '$login_id' AND log.is_del = 0 AND log.type='normal_customer' ".$where1;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            $res = $result->result_array();
            if(!empty($search)){
                $keyword = "%{$search}%";
                $where2 = " AND DATE_FORMAT('d-m-Y',bn.purchased_on) LIKE '%$keyword%' OR wa.change_value LIKE '%$keyword%'";
            }else{
                $where2 = '';
            }
            foreach ($res as $key => $value) {
                $lg_id = $value['id'];
                $name = $value['name'];
                $query="SELECT wa.change_value,DATE_FORMAT('d-m-Y',bn.purchased_on)as purchase_date FROM gp_purchase_bill_notification bn left join gp_wallet_activity wa on bn.id=wa.purchase_bill_notification_id
                where bn.login_id='$lg_id' and (wa.user_id='$login_id' and wa.type='GAIN') ".$where2." group by bn.id ";
                $result=$this->db->query($query);
                if($result->num_rows()>0)
                {
                    $det2 = $result->result_array();
                    foreach ($det2 as $key2 => $value2) {
                        $amount = $value2['change_value'];
                        $purchase_date = $value2['purchase_date'];
                         array_push($resultt,array('name'=>$name,'rewards'=>$amount,'purchase_date'=>$purchase_date));
                    }
                } 
            }
            return sizeof($resultt);
        }
        else
        {
            return false;
        }
    }
    function get_rewards_by_members_reports($search,$limit=NULL,$start=NULL)
    {
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
        $resultt =array();
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where1 = " AND nc.name LIKE '$keyword'";
        }else{
            $where1 = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT log.id,nc.name FROM gp_login_table log JOIN gp_normal_customer nc  ON log.user_id = nc.id
        WHERE (log.parent_login_id = '$login_id' AND log.is_del = 0 AND log.type='normal_customer')".$where1 .$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            $res = $result->result_array();
        }else{
            $query="SELECT log.id,nc.name FROM gp_login_table log JOIN gp_normal_customer nc  ON log.user_id = nc.id WHERE (log.parent_login_id = '$login_id' AND log.is_del = 0 AND log.type='normal_customer') ".$pg;
            $result=$this->db->query($query);
        
            $res = $result->result_array();
        }
            if(!empty($search)){
                $keyword = "%{$search}%";
                $where2 = " AND DATE_FORMAT('d-m-Y',bn.purchased_on) LIKE '%$keyword%' OR wa.change_value LIKE '$keyword'";
            }else{
                $where2 = '';
            }
            foreach ($res as $key => $value) {
                $lg_id = $value['id'];
                $name = $value['name'];
                $query="SELECT wa.change_value,DATE_FORMAT('d-m-Y',bn.purchased_on)as purchase_date FROM gp_purchase_bill_notification bn left join gp_wallet_activity wa on bn.id=wa.purchase_bill_notification_id
                where bn.login_id='$lg_id' and (wa.user_id='$login_id' and wa.type='GAIN') ".$where2." group by bn.id ";
                $result=$this->db->query($query);
                // echo $this->db->last_query();
                if($result->num_rows()>0)
                {
                    $det2 = $result->result_array();
                    foreach ($det2 as $key2 => $value2) {
                        $amount = $value2['change_value'];
                        $purchase_date = $value2['purchase_date'];
                         array_push($resultt,array('name'=>$name,'rewards'=>$amount,'purchase_date'=>$purchase_date));
                    }
                    
                } 
            }
            return $resultt;
    }
    function get_rewards_by_cp_count($search)
    {
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
        $resultt =array();
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " AND nc.name LIKE '$keyword'";
        }else{
            $where = '';
        }
        $query="SELECT nc.id,nc.name FROM gp_login_table log 
        LEFT JOIN gp_pl_channel_partner nc  ON log.user_id = nc.id
        WHERE log.parent_login_id = '$login_id' AND log.is_del = 0 
        AND log.type='Channel_partner'".$where;
        $result =$this->db->query($query);
        if($result->num_rows()>0)
        {
            $res = $result->result_array();
        }else{
            $query="SELECT nc.id,nc.name FROM gp_login_table log 
            LEFT JOIN gp_pl_channel_partner nc  ON log.user_id = nc.id
            WHERE log.parent_login_id = '$login_id' AND log.is_del = 0 
            AND log.type='Channel_partner'";
            $result =$this->db->query($query);
            $res = $result->result_array();
        }

            foreach ($res as $key => $value) {
                $u_id = $value['id'];
                $name = $value['name'];
                $query2="SELECT wa.change_value FROM gp_purchase_bill_notification bn 
                left join gp_wallet_activity wa on bn.id=wa.purchase_bill_notification_id
                where bn.channel_partner_id='$u_id' and (wa.user_id='$login_id' and wa.type='GAIN') group by bn.id";
                $result2=$this->db->query($query2);
                if($result2->num_rows()>0)
                {
                    $det2 = $result2->result_array();
                    foreach ($det2 as $key2 => $value2) {
                        $amount = $value2['change_value'];
                        array_push($resultt,array('name'=>$name,'amount'=>$amount));
                    }
                } 
            }
            return sizeof($resultt);     
    }
    function get_rewards_by_cp_reports($search,$limit=NULL,$start=NULL)
    {
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
        $resultt =array();
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " AND nc.name LIKE '$keyword' ";
        }else{
            $where = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT nc.id,nc.name FROM gp_login_table log 
        LEFT JOIN gp_pl_channel_partner nc  ON log.user_id = nc.id
        WHERE log.parent_login_id = '$login_id' AND log.is_del = 0 
        AND log.type='Channel_partner'".$where.$pg;
        $result =$this->db->query($query);
        if($result->num_rows()>0)
        {
            $res = $result->result_array();
        }else{
            $query="SELECT nc.id,nc.name FROM gp_login_table log 
            LEFT JOIN gp_pl_channel_partner nc  ON log.user_id = nc.id
            WHERE log.parent_login_id = '$login_id' AND log.is_del = 0 
            AND log.type='Channel_partner' ".$pg;
            $result =$this->db->query($query);
            $res = $result->result_array();
        }
        
            foreach ($res as $key => $value) {
                $u_id = $value['id'];
                $name = $value['name'];
                $query2="SELECT wa.change_value FROM gp_purchase_bill_notification bn 
                left join gp_wallet_activity wa on bn.id=wa.purchase_bill_notification_id
                where bn.channel_partner_id='$u_id' and (wa.user_id='$login_id' and wa.type='GAIN') group by bn.id";
                $result2=$this->db->query($query2);
                if($result2->num_rows()>0)
                {
                    $det2 = $result2->result_array(); 
                    foreach ($det2 as $key2 => $value2) {
                        $amount = $value2['change_value'];
                        array_push($resultt,array('name'=>$name,'amount'=>$amount));
                    }
                } 
            }
            return $resultt;
    } 
    function get_rewards_by_clubagents_count($search,$from,$to)
    {
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
        $resultt =array();
        if(!empty($search)){
           $where = " AND log.id = '$search'";
        }else{
            $where = '';
        }
        $query="SELECT log.id as clubagent_id FROM gp_login_table log JOIN gp_normal_customer nc  ON log.user_id = nc.id
        WHERE log.parent_login_id in(SELECT log2.id as ca_id FROM gp_login_table log2 JOIN gp_normal_customer nc2  ON log2.user_id = nc2.id
        WHERE log2.id = '$login_id' AND log2.is_del = 0 AND log2.type='club_member') AND log.is_del = 0 AND log.type='club_agent' ".$where;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            $res = $result->result_array();
            foreach ($res as $key => $value) {
                $clubagent_id =$value['clubagent_id'];
                $name = $this->get_ca_name($clubagent_id);
                if(empty($from)&&!empty($to)){
                    $where2 = "AND (date(bn.purchased_on)='".$to."')";
                }elseif(empty($to)&&!empty($from)){
                    $where2 = "AND (date(bn.purchased_on)='".$from."')";
                }elseif(!empty($from)&&!empty($to)){
                    $where2 = "AND (date(bn.purchased_on) between '".$from."' and '".$to."')";
                }else{
                    $where2 ="";
                }
                $query2="SELECT round(sum(wa.change_value),2)as amnt,DATE_FORMAT( bn.purchased_on,'%d-%m-%Y') as purchase_date FROM gp_purchase_bill_notification bn 
                left join gp_wallet_activity wa on bn.id=wa.purchase_bill_notification_id
                where bn.login_id='$clubagent_id' and (wa.user_id='$login_id' and wa.type='GAIN') ".$where2."
                group by bn.id";
                $result2=$this->db->query($query2);
                //echo $this->db->last_query();
                if($result2->num_rows()>0)
                {
                    $det2 = $result2->result_array();
                    foreach ($det2 as $key2 => $value2) {
                        $amount = $value2['amnt'];
                        $purchase_date= $value2['purchase_date'];
                        array_push($resultt,array('name'=>$name,'amount'=>$amount,'purchase_date'=>$purchase_date,'by'=>'Club Member/Normal Customer'));
                    }
                } 
                if(empty($search)){
                    $query3="SELECT log.id as id FROM gp_login_table log JOIN gp_normal_customer nc  ON log.user_id = nc.id
                    WHERE log.parent_login_id in(SELECT log2.id as ca_id FROM gp_login_table log2 JOIN gp_normal_customer nc2  ON log2.user_id = nc2.id
                    WHERE log2.id = '$clubagent_id' AND log2.is_del = 0 AND log2.type='club_agent') AND log.is_del = 0 AND (log.type='normal_customer' OR log.type='club_member') ";
                    $result3=$this->db->query($query3);//echo $this->db->last_query();
                    if($result3->num_rows()>0)
                    {
                        $res3 = $result3->result_array();
                        foreach ($res3 as $key3 => $value3) {
                            $id =$value3['id'];
                            $name = $this->get_ca_name($id);
                            if(empty($from)&&!empty($to)){
                                $where2 = "AND (date(bn.purchased_on)='".$to."')";
                            }elseif(empty($to)&&!empty($from)){
                                $where2 = "AND (date(bn.purchased_on)='".$from."')";
                            }elseif(!empty($from)&&!empty($to)){
                                $where2 = "AND (date(bn.purchased_on) between '".$from."' and '".$to."')";
                            }else{
                                $where2 ="";
                            }
                            $log_id = $datas['login_id'];
                            $query2="SELECT round(sum(wa.change_value),2)as amnt, DATE_FORMAT( bn.purchased_on,'%d-%m-%Y') as purchase_date FROM gp_purchase_bill_notification bn 
                            left join gp_wallet_activity wa on bn.id=wa.purchase_bill_notification_id
                            where bn.login_id='$id' and (wa.user_id='$login_id' and wa.type='GAIN') ".$where2."group by bn.id";
                            $result2=$this->db->query($query2);
                            if($result2->num_rows()>0)
                            {
                                $det2 = $result2->result_array();
                                foreach ($det2 as $key2 => $value2) {
                                    $amount = $value2['amnt'];
                                    $purchase_date= $value2['purchase_date'];
                                    array_push($resultt,array('name'=>$name,'amount'=>$amount,'purchase_date'=>$purchase_date,'by'=>'Club Member/Normal Customer'));
                                }
                            }
                        }
                    }
                }
            }
            return sizeof($resultt);
        }
        else
        {
            return false;
        }
    }
    function get_ca_name($id){
        $qry1 = "SELECT nc.name FROM gp_login_table log left join gp_normal_customer nc on log.user_id=nc.id where log.id='$id' and (log.type='club_agent' OR log.type='normal_customer')";
        $qry1 = $this->db->query($qry1);
        if($qry1->num_rows()>0)
        {
            $det = $qry1->row_array();
            $name = $det['name'];
        }else{
            $name ="";  
        }
        return $name;
    }
    function get_rewards_by_clubagents_reports($search,$from,$to,$limit=NULL,$start=NULL)
    {
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
            // $log_id = $datas['login_id'];
        }
        $resultt =array();
        if(!empty($search)){
           $where = " AND log.id = '$search'";
        }else{
            $where = '';
        }

        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT log.id as clubagent_id FROM gp_login_table log JOIN gp_normal_customer nc  ON log.user_id = nc.id
        WHERE log.parent_login_id in(SELECT log2.id as ca_id FROM gp_login_table log2 JOIN gp_normal_customer nc2  ON log2.user_id = nc2.id
        WHERE log2.id = '$login_id' AND log2.is_del = 0 AND log2.type='club_member') AND log.is_del = 0 AND log.type='club_agent' ".$where.$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            $res = $result->result_array();
            foreach ($res as $key => $value) {
                $clubagent_id =$value['clubagent_id'];
                $name = $this->get_ca_name($clubagent_id);
                if(empty($from)&&!empty($to)){
                    $where2 = "AND (date(bn.purchased_on)='".$to."')";
                }elseif(empty($to)&&!empty($from)){
                    $where2 = "AND (date(bn.purchased_on)='".$from."')";
                }elseif(!empty($from)&&!empty($to)){
                    $where2 = "AND (date(bn.purchased_on) between '".$from."' and '".$to."')";
                }else{
                    $where2 ="";
                }
                $log_id = $datas['login_id'];
                $query2="SELECT round(sum(wa.change_value),2)as amnt,DATE_FORMAT( bn.purchased_on,'%d-%m-%Y') as purchase_date FROM gp_purchase_bill_notification bn 
                left join gp_wallet_activity wa on bn.id=wa.purchase_bill_notification_id
                where bn.login_id='$clubagent_id' and (wa.user_id='$log_id' and wa.type='GAIN') ".$where2."group by bn.id";
                $result2=$this->db->query($query2);
                //echo $this->db->last_query();
        
                if($result2->num_rows()>0)
                {
                    $det2 = $result2->result_array();
                    foreach ($det2 as $key2 => $value2) {
                        $amount = $value2['amnt'];
                        $purchase_date= $value2['purchase_date'];
                        array_push($resultt,array('name'=>$name,'amount'=>$amount,'purchase_date'=>$purchase_date,'by'=>'Self'));
                    }
                } 
                if(empty($search)){
                    $query3="SELECT log.id as id FROM gp_login_table log JOIN gp_normal_customer nc  ON log.user_id = nc.id
                    WHERE log.parent_login_id in(SELECT log2.id as ca_id FROM gp_login_table log2 JOIN gp_normal_customer nc2  ON log2.user_id = nc2.id
                    WHERE log2.id = '$clubagent_id' AND log2.is_del = 0 AND log2.type='club_agent') AND log.is_del = 0 AND (log.type='normal_customer' OR log.type='club_member') ".$pg;
                    $result3=$this->db->query($query3);//echo $this->db->last_query();
                    if($result3->num_rows()>0)
                    {
                        $res3 = $result3->result_array();
                        foreach ($res3 as $key3 => $value3) {
                            $id =$value3['id'];
                            $name = $this->get_ca_name($id);
                            if(empty($from)&&!empty($to)){
                                $where2 = "AND (date(bn.purchased_on)='".$to."')";
                            }elseif(empty($to)&&!empty($from)){
                                $where2 = "AND (date(bn.purchased_on)='".$from."')";
                            }elseif(!empty($from)&&!empty($to)){
                                $where2 = "AND (date(bn.purchased_on) between '".$from."' and '".$to."')";
                            }else{
                                $where2 ="";
                            }
                            $log_id = $datas['login_id'];
                            $query2="SELECT round(sum(wa.change_value),2)as amnt,DATE_FORMAT( bn.purchased_on,'%d-%m-%Y') as purchase_date FROM gp_purchase_bill_notification bn 
                            left join gp_wallet_activity wa on bn.id=wa.purchase_bill_notification_id
                            where bn.login_id='$id' and (wa.user_id='$log_id' and wa.type='GAIN') ".$where2."group by bn.id";
                            $result2=$this->db->query($query2);
                            if($result2->num_rows()>0)
                            {
                                $det2 = $result2->result_array();
                                foreach ($det2 as $key2 => $value2) {
                                    $amount = $value2['amnt'];
                                    $purchase_date= $value2['purchase_date'];
                                    array_push($resultt,array('name'=>$name,'amount'=>$amount,'purchase_date'=>$purchase_date,'by'=>'Club Member/Normal Customer'));
                                }
                            }
                        }
                    }
                }

            }
            return $resultt;
        }
        else
        {
            return false;
        }
    }
    function get_cm_transaction_byid_count($search)
    {
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
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
        $query="select id,transaction_amount,narration,DATE_FORMAT(transaction_date,'%d-%m-%Y %H:%i')as transaction_date,
        mode,cheque_number,bank_name,DATE_FORMAT(cheque_date,'%d-%m-%Y')AS cdate
              FROM gp_cp_transaction trans
              where trans._to=$login_id ".$where1;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
            
        }else{
            return false;
        }    
    }
    function get_cm_transaction_byid($search,$limit=NULL,$start=NULL){
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
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
              where trans._to=$login_id ".$where1.$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->result_array();
            
        }else{
            return false;
        }
    }
    function get_notitfications_count($search)
    {
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where1 = " AND (n.title LIKE '%$keyword%' OR 
            n.description LIKE '%$keyword%' OR 
            n.is_read LIKE '%$keyword%' OR 
            n.created_on LIKE '%$keyword%')";
        }else{
            $where1 = '';
        }
        $query="select n.id,n.title,n.description as notification, (CASE WHEN n.is_read = 1 THEN 'true' ELSE 'false' END) as is_read,created_on from admin_notifications n where n.is_del = '0' and n.login_id = '$login_id '".$where1;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
            
        }else{
            return false;
        }    
    }
    function get_notitfications($search,$limit=NULL,$start=NULL){
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where1 = " AND (n.title LIKE '%$keyword%' OR 
            n.description LIKE '%$keyword%' OR 
            n.is_read LIKE '%$keyword%' OR 
            DATE_FORMAT(created_on,'%d %m %Y') LIKE '%$keyword%')";
        }else{
            $where1 = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="select n.id,n.title,n.description as notification, (CASE WHEN n.is_read = 1 THEN 'true' ELSE 'false' END) as is_read, DATE_FORMAT(created_on,'%d-%m-%Y') as createdon from admin_notifications n where n.is_del = '0' and n.login_id = '$login_id '".$where1.$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->result_array();
            
        }else{
            return false;
        }
    }
    function get_money_transfer_count($search,$from,$to)
    {
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
        $resultt =array();
        if(!empty($search)){
           $keyword = "%{$search}%";
           $where = " AND ( pt.amount LIKE '%$keyword%' OR DATE_FORMAT(pt.created_on_date,'%d-%m-%Y') LIKE '%$keyword%' OR typ.title LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        if(empty($from)&&!empty($to)){
            $where2 = " AND (date(pt.created_on_date)='".$to."')";
        }elseif(empty($to)&&!empty($from)){
            $where2 = " AND (date(pt.created_on_date)='".$from."')";
        }elseif(!empty($from)&&!empty($to)){
            $where2 = " AND (date(pt.created_on_date) between '".$from."' and '".$to."')";
        }else{
            $where2 ="";
        }
        $query="SELECT pt.to_id,pt.amount,DATE_FORMAT(pt.created_on_date,'%d-%m-%Y')AS tr_date,typ.title as wallet FROM `gp_payment_transfer` pt left join gp_login_table log
            ON pt.form_id=log.id left join gp_wallet_types typ ON pt.wallet=typ.id where pt.form_id='$login_id'".$where.$where2;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            $res = $result->result_array();
            return sizeof($res);
        }
        else
        {
            return false;
        }
    }
    function get_money_transfer($search,$from,$to,$limit=NULL,$start=NULL)
    {
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
        $resultt =array();
        if(!empty($search)){
           $keyword = "%{$search}%";
           $where = " AND ( pt.amount LIKE '%$keyword%' OR DATE_FORMAT(pt.created_on_date,'%d-%m-%Y') LIKE '%$keyword%' OR typ.title LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        if(empty($from)&&!empty($to)){
            $where2 = " AND (date(pt.created_on_date)='".$to."')";
        }elseif(empty($to)&&!empty($from)){
            $where2 = " AND (date(pt.created_on_date)='".$from."')";
        }elseif(!empty($from)&&!empty($to)){
            $where2 = " AND (date(pt.created_on_date) between '".$from."' and '".$to."')";
        }else{
            $where2 =" ";
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT pt.to_id,pt.amount,DATE_FORMAT(pt.created_on_date,'%d-%m-%Y')AS tr_date,typ.title  as wallet FROM `gp_payment_transfer` pt left join gp_login_table log
            ON pt.form_id=log.id left join gp_wallet_types typ ON pt.wallet=typ.id where pt.form_id='$login_id'".$where.$where2.$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            $res = $result->result_array();
            foreach ($res as $key => $value) {
                $to = $value['to_id'];
                $where = 'gp_login_table.user_id=gp_normal_customer.id';
                $details = select_all_by_id('gp_login_table',$to,'gp_normal_customer',$where);
                $value['to'] =  $details->name;
                array_push($resultt,$value);
            }
            return $resultt;
        }
        else
        {
            return array();
        }
    }
    function get_to_money_transfer_count($search,$from,$to)
    {
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
        $resultt =array();
        if(!empty($search)){
           $keyword = "%{$search}%";
           $where = " AND ( pt.amount LIKE '%$keyword%' OR DATE_FORMAT(pt.created_on_date,'%d-%m-%Y') LIKE '%$keyword%' OR typ.title LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        if(empty($from)&&!empty($to)){
            $where2 = " AND (date(pt.created_on_date)='".$to."')";
        }elseif(empty($to)&&!empty($from)){
            $where2 = " AND (date(pt.created_on_date)='".$from."')";
        }elseif(!empty($from)&&!empty($to)){
            $where2 = " AND (date(pt.created_on_date) between '".$from."' and '".$to."')";
        }else{
            $where2 ="";
        }
        $query="SELECT pt.form_id,pt.amount,DATE_FORMAT(pt.created_on_date,'%d-%m-%Y')AS tr_date,typ.title as wallet FROM `gp_payment_transfer` pt left join gp_login_table log
            ON pt.to_id=log.id left join gp_wallet_types typ ON pt.wallet=typ.id where pt.form_id='$login_id'".$where.$where2;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            $res = $result->result_array();
            return sizeof($res);
        }
        else
        {
            return false;
        }
    }
    function get_to_money_transfer($search,$from,$to,$limit=NULL,$start=NULL)
    {
        $datas = getLoginId(); 
        if ($datas) {
            $login_id = $datas['login_id'];
        }
        $resultt =array();
        if(!empty($search)){
           $keyword = "%{$search}%";
           $where = " AND ( pt.amount LIKE '%$keyword%' OR DATE_FORMAT(pt.created_on_date,'%d-%m-%Y') LIKE '%$keyword%' OR typ.title LIKE '%$keyword%')";
        }else{
            $where = '';
        }
        if(empty($from)&&!empty($to)){
            $where2 = " AND (date(pt.created_on_date)='".$to."')";
        }elseif(empty($to)&&!empty($from)){
            $where2 = " AND (date(pt.created_on_date)='".$from."')";
        }elseif(!empty($from)&&!empty($to)){
            $where2 = " AND (date(pt.created_on_date) between '".$from."' and '".$to."')";
        }else{
            $where2 =" ";
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT pt.form_id,pt.amount,DATE_FORMAT(pt.created_on_date,'%d-%m-%Y')AS tr_date,typ.title  as wallet FROM `gp_payment_transfer` pt left join gp_login_table log
            ON pt.form_id=log.id left join gp_wallet_types typ ON pt.wallet=typ.id where pt.to_id='$login_id'".$where.$where2.$pg;
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            $res = $result->result_array();
            foreach ($res as $key => $value) {
                $form_id = $value['form_id'];
                $where = 'gp_login_table.user_id=gp_normal_customer.id';
                $details = select_all_by_id('gp_login_table',$form_id,'gp_normal_customer',$where);
                $value['from'] =  $details->name;
                array_push($resultt,$value);
            }
            return $resultt;
        }
        else
        {
            return array();
        }
    }
}



