<?php
Class Front_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();

    }
 
    function get_home_page_data($api_key)
    {
       $base_url = base_url();
       $user = user_details_by_apikey($api_key);

        //OFFERS
       
       $qry5 = $this->db->query("SELECT CONCAT('$base_url','upload/', a.image) as image,a.title as name, a.id FROM `advertisement` a WHERE a.type = 'bottom' and a.is_del = '0'"); 
       if($qry5->num_rows()>0){
           $data['offers']['offer_ads']=$qry5->result_array();
        }
        else{
            $data['offers']['offer_ads']=array();
        } 
        $data['offers']['offer_array']=array();

        //deals
       $data['deals']['name'] = "Crazy Deals";
       $data['deals']['id'] = 1;
       $qry2 = $this->db->query("SELECT p.actual_cost as old_price, p.special_prize as offer_price,p.id, p.name as product_name, CONCAT('$base_url', i.p_image) as image, ROUND((((p.actual_cost - p.special_prize)/p.actual_cost)*100),2) as offer_percent FROM gp_product_details p LEFT JOIN gp_product_image i on p.id = i.product_id LEFT JOIN gp_deal_channel_partner_con d on d.product_id = p.id WHERE p.is_del = '0' and p.type != '0' and p.quantity > 0 and d.end_date >= CURDATE() group by p.id order by p.id desc"); 
       if($qry2->num_rows()>0){
           $data['deals']['crazy_deals']=$qry2->result_array();
        }
        else{
            $data['deals']['crazy_deals']=array();
        } 

         //BANNERS
       
       $qry3 = $this->db->query("SELECT a.image FROM `advertisement` a WHERE a.type in ('left','center','right') and a.is_del = '0'"); 
       if($qry3->num_rows()>0){
           $adv=$qry3->result_array();
           foreach ($adv as $key2 => $value2) {
               $data['banner'][$key2]['key'] = $base_url."/upload/".$value2['image'];
               $data['banner'][$key2]['value'] = null;
            }
        }
        else{
            $data['banner']=array();
        } 

       //products
            $data['product_list']['name'] = "Products";
       $data['product_list']['id'] = "2";
       $qry1 = $this->db->query("SELECT p.actual_cost as old_price, p.special_prize as offer_price,p.id, p.name as product_name,CONCAT('$base_url', c.brand_image)  as brand_logo,CONCAT('$base_url', i.p_image)  as image, ROUND((((p.actual_cost - p.special_prize)/p.actual_cost)*100),2) as offer_percent FROM gp_product_details p LEFT JOIN gp_pl_channel_partner c on p.channel_partner_id = c.id LEFT JOIN gp_product_image i on p.id = i.product_id WHERE p.is_del = '0' and p.type = '0' group by p.id order by p.id desc"); 
       if($qry1->num_rows()>0){
           $data['product_list']['products']=$qry1->result_array();
            foreach ($data['product_list']['products'] as $key1 => $value1) {
               $data['product_list']['products'][$key1]['isProduct'] = true;
            }
        }
        else{
            $data['product_list']['products']=array();
        } 

        if(!empty($api_key))
           {
              $user = user_details_by_apikey($api_key);
              if(!empty($user)){
                $login_id = $user['id'];
                $noti = get_notification_count($login_id);
                if($noti){
                   $data['notification_count'] = $noti->noti_count;
                }
                else{
                    $data['notification_count'] = '0';
                }

                $data['user_type'] = $user['type'];
              }else{
                  $data['notification_count'] = '0';
                  $data['user_type'] = null;
              }
          }else{
                  $data['notification_count'] = '0';
                  $data['user_type'] = null;
          }  

        //premium ads
        $qry6=$this->db->query("SELECT * FROM gp_permission_module where is_del = '0'");
        if($qry6->num_rows()>0)
        {
          $modules=$qry6->result_array();
        
          foreach ($modules as $key3 => $module) 
          {
            $data['premium_ads'][$key3]['add_name'] = $module['module_name'];
            $module_id = $module['id'];
            $data['premium_ads'][$key3]['id'] = $module_id;
            $newqry = $this->db->query("select CONCAT('$base_url', pi.p_image) as image, p.actual_cost as old_price, p.id , p.name as product_name,p.special_prize as offer_price from gp_product_details p LEFT JOIN gp_product_image pi on pi.product_id = p.id LEFT JOIN gp_pl_channel_partner par on par.id = p.channel_partner_id where par.module = '$module_id' and type ='0' and p.is_del = '0' GROUP by p.id order by p.id desc");
                if($newqry->num_rows()>0)
                {
                  $data['premium_ads'][$key3]['products'] = $newqry->result_array();
                }else{
                  $data['premium_ads'][$key3]['products'] = array();
                }            
          }
        } else{
           $data['premium_ads']=array();
        }
        //book_green_india
        $data['book_green_india']=array();
        
     
        return $data;       
    } 
    function  get_product($api_key,$product_id)
    {
       
        //basic_specs
        $base_url = base_url();
        $date = date('Y-m-d h:i:s');
        $data['basic_specs']=array();
        $com = get_commission();
        $customer_per = $com['customer_commission'];
        //basic_details
        $qry = "select ROUND((((p.actual_cost - p.special_prize)/p.actual_cost)*100),2) as offer_percent, ROUND(((p.special_prize * c.coupon_percentage)/ 100),2) as voucher_price ,p.actual_cost as actual_price, p.special_prize as offer_price, p.name, p.model,(CASE WHEN p.type = 0 THEN 'true' ELSE 'false' END) as is_product,c.end_date as deal_end_time,p.description,p.channel_partner_id,IFNULL(ROUND((((select cc.percentage from gp_channel_con_cat_commision cc where cc.id = p.reward_cat_id)*p.special_prize)/100)* ($customer_per / 100),2),0)AS jaazzo_rewards from gp_product_details p left join gp_deal_channel_partner_con c on c.id = p.type where p.is_del = 0 and p.id = '$product_id'";

        $result=$this->db->query($qry);
       
        if($result->num_rows()>0)
        {
            $data['basic_details'] = $result->row_array();
            $cp_id = $data['basic_details']['channel_partner_id'];
            $data['basic_details']['current_time'] = $date;
            $qry_img = "select CONCAT('$base_url', img.p_image) as image FROM gp_product_details p LEFT JOIN gp_product_image img on p.id = img.product_id WHERE p.is_del = '0' and p.id = '$product_id'";
            $qry_imgz = $this->db->query($qry_img);
            if($qry_imgz->num_rows()>0)
            {
              $data['imageList'] = $qry_imgz->result_array();
            }else{
              $data['imageList'] = array();
            }   
            $data['specifications'] = array();
            //cp
            $qry_cp = $this->db->query("select cp.name,cp.id,cp.address,cp.lattitude,cp.longitude,cp.phone,cp.email, concat('$base_url', cp.brand_image) as logo_image, (select c.name from countries c WHERE c.id = cp.country) as country,(select ct.name from cities ct WHERE ct.id = cp.town) as City,(select s.name from states s WHERE s.id = cp.state) as state from gp_pl_channel_partner cp WHERE cp.id = '$cp_id'");
           
            if($qry_cp->num_rows()>0)
            {
              $data['basic_details']['channel_partner'] = $qry_cp->row_array();
            }else{
              $data['basic_details']['channel_partner'] = new stdClass();
            }   
            //notification count

            if(!empty($api_key))
             {
                $user = user_details_by_apikey($api_key);
                if(!empty($user)){
                    $login_id = $user['id'];
                    $noti = get_notification_count($login_id);
                    if($noti){
                       $data['basic_details']['notification_count'] = $noti->noti_count;
                    }
                    else{
                        $data['basic_details']['notification_count'] = '0';
                    }
                }else{
                        $data['basic_details']['notification_count'] = '0';
                }    
            }else{
                    $data['basic_details']['notification_count'] = '0';
            }     
        }
        else
        {
            $data['basic_details'] = array();
        }
        

        return $data;
    }
    function check_quantity($id){

      $qry = $this->db->query("SELECT p.quantity,cp.name, cp.address,p.special_prize,c.coupon_percentage,l.id,ctr.name as country, st.name as state,ct.name as city,DATE_FORMAT(c.coupon_validity,'%d-%b-%Y') as coupon_validity FROM gp_product_details p LEFT join gp_pl_channel_partner cp on p.channel_partner_id = cp.id left join gp_deal_channel_partner_con c on p.id = c.product_id left join gp_login_table l on cp.id = l.user_id left join countries ctr on ctr.id = cp.country LEFT join states st on st.id = cp.state LEFT join cities ct on ct.id = cp.town WHERE p.quantity > 0 and p.id = '$id'");
      //echo $this->db->last_query();exit;
      if($qry->num_rows()>0)
      {
        return $qry->row_array();
      } else{
        return false;
      }
    }
     function get_deal($user_id,$login_id,$id,$coupon_code,$check)
    {
      $this->db->trans_begin();

      $price =(($check['special_prize'] * $check['coupon_percentage']) / ($check['special_prize'] )) * 100;
     // var_dump($price);exit();
      $cp_id =$check['id'];
      $qry1 = $this->db->query("select p.type from gp_product_details p where p.id = '$id' and p.is_del='0'");
      if($qry1->num_rows()>0){
        $qry1 = $qry1->row();
        $deal_id = $qry1->type;

        $data = array(
                      'user_id'=>$user_id,
                      'coupon_code' =>$coupon_code,
                      'deal_con' =>$deal_id,
                      'amount' => $price 
            );
        $qry = $this->db->insert('coupon', $data);
        $insert_id = $this->db->insert_id();
        $qry_up = $this->db->query("UPDATE gp_product_details p set p.quantity = p.quantity-1 WHERE p.id = '$id'");

        //entry creation
      $fy_year = get_current_financial_year();
      $fy_id = $fy_year['id'];
      $no =get_number();
        $ac_data = array(
            'entrytype_id'=>4,
            '_type'=>'DEAL',
            'type_id'=>$insert_id,
            'number'=>$no,
            'fy_id' =>$fy_id,
            'date'=>date('Y-m-d'),
            'dr_total'=>$price,
            'cr_total'=>$price
        );
        $this->db->insert('erp_ac_entries',$ac_data);
        $entry_id = $this->db->insert_id();
        $type = 'CUSTOMER';
        $ledger_payment_cr = getLedgerId($login_id,$type);

        $entry_items_cr = array(
            'entry_id' => $entry_id,
            'ledger_id' => $ledger_payment_cr,
            'amount' => $price,
            'dc' => 'Cr',
            'fy_id' =>$fy_id,
            'created_date' => date('Y-m-d')
        );
        $ledger_payment_dr = '35';
        $entry_items_dr = array(
            'entry_id' => $entry_id,
            'ledger_id' => $ledger_payment_dr,
            'amount' => $price,
            'dc' => 'Dr',
            'fy_id' =>$fy_id,
            'created_date' => date('Y-m-d')
        );
        $entry_cr = $this->db->insert('erp_ac_entryitems', $entry_items_cr);
        $entry_dr = $this->db->insert('erp_ac_entryitems', $entry_items_dr);
        
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
     function get_all_categoris_from_parent($cat_id){


         $cat_array = array();
       
         $qry_cat = "select
                            ct.id as cat_id, ct.title
                            from gp_pl_channel_partner_types ct
                            where ct.parent = '$cat_id' ";

         $qry_cat = $this->db->query($qry_cat);

         if($qry_cat && $qry_cat->num_rows()>0)
         {
             $details['sub_cat'] = $qry_cat->result_array();

             foreach ($details['sub_cat'] as $ky => $sub_cat ){

                 $sub_cat_id = $sub_cat['cat_id'];
                 array_push($cat_array, $sub_cat_id);
                 $sub_cat_qry = "select
                            ct.id as cat_id, ct.title
                            from gp_pl_channel_partner_types ct
                            where ct.parent = '$sub_cat_id' ";

                 $sub_cat_qry = $this->db->query($sub_cat_qry);
                 if($sub_cat_qry && $sub_cat_qry->num_rows()>0)
                 {
                     $data_det['sub_cat'] = $sub_cat_qry->result_array();
                     foreach ($data_det['sub_cat'] as $det){
                         $sub_sub_id = $det['cat_id'];
                         array_push($cat_array, $sub_sub_id);
                     }
                 }else{
                     $data_det = array();
                 }
             }
            $result = array_unique($cat_array);
             $res = implode("','",$result);
         }
         else
         {
          
            $res = '';
         }

         return $res;

     }
    function category_list($api_key,$cat_id,$page,$sort_id,$filter_options,$per_page){  
       $base_url = base_url();
       $start = ($page * $per_page) - $per_page;
       $limit = $per_page; 
       
        //sort order
        if($sort_id == '1'){
              $order_by = 'dt.id desc';
            }else if($sort_id == '2'){
              $order_by = 'dt.special_prize desc';
            }else if($sort_id == '3'){
              $order_by = 'dt.special_prize asc';
            }
            else if($sort_id == '4'){
              $order_by = 'dt.viewed desc';
            }else{
              $order_by = 'dt.id desc';
          }
       
         $js = json_decode($filter_options,true);
         $shop =array();
         $brand =array();$city =array();
          foreach ($js as  $value) {
           //echo $value['id']. " ";
           foreach ($value['sub_ids'] as $key => $val) {
            if($value['id']=='1'){
              array_push($shop, $val);
            }else if($value['id']=='2'){
            array_push($brand, $val);
           }
           else if($value['id']=='3'){
            array_push($city, $val);
           }
          }
        }
    
        if($shop=='')
         {
             $shop_query='';
         }
         else
         {
             $shops = implode("','",$shop);

             $shop_query ="dt.channel_partner_id IN ('$shops') or ";         
         }
        if($brand=='')
         {
             $brand_query='';
         }
         else
         {
             $brands = implode("','",$brand);

             $brand_query ="dt.brand_id IN ('$brands') or ";         
         } 
         if($city=='')
         {
             $city_query='';
         }
         else
         {
             $cities = implode("','",$city);

             $city_query ="p.town IN ('$cities') or ";         
         } 
         if($cat_id == 1){
              $type_query = "dt.type != 0";
         }else if($cat_id == 2){
              $type_query = "dt.type = 0";
         }else{
              $type_query = "dt.type = 0 and p.module ='$cat_id'";
         }
      if($cat_id == 1){   
         $qry= $this->db->query("select CONCAT(ROUND((((dt.actual_cost - dt.special_prize)/dt.actual_cost)*100),2), '%' ) as offer_percent, 
          CONCAT('$base_url', gpi.p_image) as image,dt.actual_cost as old_price,dt.id, CONCAT('$base_url',p.brand_image) as brand_logo,
          IFNULL(dt.name, '') as product_name, dt.special_prize as offer_price,dt.description as spec  
          from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id
            LEFT JOIN gp_deal_channel_partner_con d on d.product_id = dt.id where $shop_query $brand_query $city_query dt.is_del = 0 and $type_query  and dt.quantity > 0 and d.end_date >= CURDATE() GROUP by dt.id order by $order_by limit $start,$limit");
      }else{
        $qry= $this->db->query("select CONCAT(ROUND((((dt.actual_cost - dt.special_prize)/dt.actual_cost)*100),2), '%' ) as offer_percent, 
          CONCAT('$base_url', gpi.p_image) as image,dt.actual_cost as old_price,dt.id, CONCAT('$base_url',p.brand_image) as brand_logo,
          IFNULL(dt.name, '') as product_name, dt.special_prize as offer_price, dt.description as spec  
          from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id where $shop_query $brand_query $city_query dt.is_del = 0 and $type_query GROUP by dt.id order by $order_by limit $start,$limit"); 
      }
      // echo $this->db->last_query();exit();
      if($qry){     
         $data['products'] = $qry->result_array();
         foreach ($data['products'] as $key => $value) {
           $data['products'][$key]['isProduct'] = true;
           $data['products'][$key]['rating'] = '0';
         }
      }else{
        $data['products'] = array();
      }
      //for getting count
      if($cat_id == 1){   
         $qry_count= $this->db->query("select dt.id 
          from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id
            LEFT JOIN gp_deal_channel_partner_con d on d.product_id = dt.id where $shop_query $brand_query $city_query dt.is_del = 0 and $type_query  and dt.quantity > 0 and d.end_date >= CURDATE() GROUP by dt.id");
      }else{
        $qry_count = $this->db->query("select dt.id 
          from gp_product_details dt left join gp_pl_channel_partner p on p.id = dt.channel_partner_id LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id left join gp_product_brands b on dt.brand_id = b.id where $shop_query $brand_query $city_query dt.is_del = 0 and $type_query GROUP by dt.id"); 
      }
      if($qry_count){
        $count = $qry_count->num_rows();
        $data['result_count'] = $count;
      }else{
        $data['result_count'] = 0;
      }
      
    
      if(!empty($api_key))
         {
            $user = user_details_by_apikey($api_key);
            if(!empty($user)){
                $login_id = $user['id'];
                $noti = get_notification_count($login_id);
                if($noti){
                   $data['notification_count'] = $noti->noti_count;
                }
                else{
                    $data['notification_count'] = '0';
                }
             }else{
                   $data['notification_count'] = '0';
             }   
        }else{
                $data['notification_count'] = '0';
        }

        return $data;

    }


   function get_notifications($login_id)
      {
        
     $qry = "select n.id,n.title,n.description as notification, (CASE WHEN n.is_read = 1 THEN 'true' ELSE 'false' END) as is_read from admin_notifications n where n.is_del = '0' and n.login_id = '$login_id' ";

          $qry = $this->db->query($qry);
          //echo $this->db->last_query();exit();
          if($qry->num_rows()>0)
          {
              return $qry->result_array();
          }   else{
              return array();
          }
      }
     function delete_notification($login_id,$id)
      {
         $this->db->trans_begin();
         $this->db->delete('admin_notifications', array('id' => $id));
         $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
              return FALSE;
            } else {
                $this->db->trans_commit();
                return TRUE;
        }
      }
      function get_billing_details($id)
      {

            $data['mywallet_balance'] = get_wallet_val_id($id,4);
            $data['reward_wallet_balance'] = get_wallet_val_id($id,2);
            $noti = get_notification_count($id);
            if($noti){
               $data['notification_count'] = $noti->noti_count;
            }
            else{
                $data['notification_count'] = '0';
            }
            return $data;
        }
        function get_channel_partner_type()
        {
              $data['types'] = $this->db->select('t.id,t.title as name')->where("t.parent='0'")->get('gp_pl_channel_partner_types t')->result_array();
              if($data['types']){
                foreach ($data['types'] as $key => $value) {
                      $id = $value['id'];
                      $data['types'][$key]['subItems'] = $this->db->select('t.id,t.title as name,parent as parent_id')->where("t.parent='$id'")->get('gp_pl_channel_partner_types t')->result();
                }
              }else{
                $data = array();
              }  
             return $data;
        }
        function get_filter_options($cat_id)
        {
           if($cat_id == 1){
              $type_query = "p.type != 0";
           }else if($cat_id == 2){
                $type_query = "p.type = 0";
           }else{
                $type_query = "p.type = 0 and c.module ='$cat_id'";
           }
           if($cat_id == 1){ 
              //channel partners
               $data['filter_options'][0]['name'] = 'Chanel partner';
               $data['filter_options'][0]['id'] = '1';
               $qry1 = $this->db->query("SELECT c.name,c.id FROM gp_product_details p LEFT JOIN gp_pl_channel_partner c on p.channel_partner_id = c.id LEFT JOIN gp_deal_channel_partner_con d on d.product_id = p.id where p.is_del = 0 and p.quantity > 0 and d.end_date >= CURDATE() and $type_query group by c.id");
               if($qry1->num_rows()>0){
                $data['filter_options'][0]['sub_item_list'] = $qry1->result_array();
               }else{
                $data['filter_options'][0]['sub_item_list'] = array();
               }
               //Brand
               $data['filter_options'][1]['name'] = 'Brand';
               $data['filter_options'][1]['id'] = '2';
               $qry2 = $this->db->query("SELECT b.name,b.id FROM gp_product_details p LEFT JOIN gp_product_brands b on p.brand_id = b.id LEFT JOIN gp_deal_channel_partner_con d on d.product_id = p.id where p.is_del = 0 and b.is_del = '0' and p.quantity > 0 and d.end_date >= CURDATE() and $type_query group by b.id");
               if($qry2->num_rows()>0){
                $data['filter_options'][1]['sub_item_list'] = $qry2->result_array();
               }else{
                $data['filter_options'][1]['sub_item_list'] = array();
               }

              //cities
               $data['filter_options'][2]['name'] = 'City';
               $data['filter_options'][2]['id'] = '3';
               $qry3 = $this->db->query("SELECT ct.name,ct.id FROM gp_product_details p LEFT JOIN gp_pl_channel_partner c on p.channel_partner_id = c.id left join cities ct on c.town = ct.id
               LEFT JOIN gp_deal_channel_partner_con d on d.product_id = p.id where p.is_del = 0 and p.quantity > 0 and d.end_date >= CURDATE() and $type_query  group by c.id");
               if($qry3->num_rows()>0){
                $data['filter_options'][2]['sub_item_list'] = $qry3->result_array();
               }else{
                $data['filter_options'][2]['sub_item_list'] = array();
               }
            }else{
                 //channel partners
                 $data['filter_options'][0]['name'] = 'Chanel partner';
                 $data['filter_options'][0]['id'] = '1';
                 $qry1 = $this->db->query("SELECT c.name,c.id FROM gp_product_details p LEFT JOIN gp_pl_channel_partner c on p.channel_partner_id = c.id where p.is_del = 0 and $type_query  group by c.id");
                 if($qry1->num_rows()>0){
                  $data['filter_options'][0]['sub_item_list'] = $qry1->result_array();
                 }else{
                  $data['filter_options'][0]['sub_item_list'] = array();
                 }
                 //Brand
                 $data['filter_options'][1]['name'] = 'Brand';
                 $data['filter_options'][1]['id'] = '2';
                 $qry2 = $this->db->query("SELECT b.name,b.id FROM gp_product_details p LEFT JOIN gp_product_brands b on p.brand_id = b.id LEFT JOIN gp_pl_channel_partner c on p.channel_partner_id = c.id where p.is_del = 0 and $type_query and b.is_del = '0' group by b.id");
                 if($qry2->num_rows()>0){
                  $data['filter_options'][1]['sub_item_list'] = $qry2->result_array();
                 }else{
                  $data['filter_options'][1]['sub_item_list'] = array();
                 }

                //cities
                 $data['filter_options'][2]['name'] = 'City';
                 $data['filter_options'][2]['id'] = '3';
                 $qry3 = $this->db->query("SELECT ct.name,ct.id FROM gp_product_details p LEFT JOIN gp_pl_channel_partner c on p.channel_partner_id = c.id left join cities ct on c.town = ct.id where p.is_del = 0 and $type_query group by c.id");
                 if($qry3->num_rows()>0){
                  $data['filter_options'][2]['sub_item_list'] = $qry3->result_array();
                 }else{
                  $data['filter_options'][2]['sub_item_list'] = array();
                 }
            } 
           //offer
           $data['filter_options'][3]['name'] = 'Offer';
           $data['filter_options'][3]['id'] = '4';
           $data['filter_options'][3]['sub_item_list'] = array();

           //color
           $data['filter_options'][4]['name'] = 'Color';
           $data['filter_options'][4]['id'] = '5';
           $data['filter_options'][4]['sub_item_list'] = array();
           return $data;
        }
       function side_bar_data($api_key)
        {
             $base_url = base_url();

              $data['category'] = $this->db->select('t.id as cat_id,t.title as cat_name')->where("t.parent='0'")->get('gp_pl_channel_partner_types t')->result_array();
              if($data['category']){ 
                foreach ($data['category'] as $key => $value) {
                      $id = $value['cat_id'];
                      $data['category'][$key]['sub_cat_List'] = $this->db->select('t.id as sub_cat_id,t.title as sub_cat_name')->where("t.parent='$id'")->get('gp_pl_channel_partner_types t')->result();
                }
              }else{
                $data['category'] = array();
              }
              if($api_key){
              $user = user_details_by_apikey($api_key);
              if($user){
              $lgid = $user['id']; 
              if($lgid){
              $qry = $this->db->select('l.type,l.user_id')->where("l.id = '$lgid'")->get('gp_login_table l')->row();
          
              if($qry){
                $type = $qry->type;
                $user_id = $qry->user_id;
                   if($type=='executive')
                      {
                          $exe_qry =  $this->db->query("SELECT m.name,m.id,CONCAT('$base_url','upload/exec_profile/', md.image) as image FROM gp_pl_sales_team_members m LEFT join gp_pl_sales_team_member_details md on m.id = md.sales_team_member_id where m.id = '$user_id'");
                      }
                      else{
                            $exe_qry =  $this->db->query("select mem.id,mem.name,CONCAT('$base_url','upload/', mem.profile_image) as image from gp_normal_customer mem where mem.id = '$user_id'");
                      }
                      if($exe_qry->num_rows()>0)
                        {
                            $res_exe = $exe_qry->row();
                            $uid = $res_exe->id ;
                            $data['user']['firstName'] = $res_exe->name ;
                            $data['user']['profile_image'] = $res_exe->image ;
                            $data['user']['last_name'] = "";
                            $data['user']['id'] = $res_exe->id ;
                            $club = get_wallet_val($lgid,1);
                            $reward = get_wallet_val($lgid,2);
                            $my = get_wallet_val($lgid,4);
                            $incentive = get_wallet_val($lgid,3);
                            $cw = (!empty($club))?$club:"0";
                            $rw = (!empty($reward))?$reward:"0";
                            $mw = (!empty($my))?$my:"0";
                            $iw = (!empty($incentive))?$incentive:"0";
                            $data['user']['club_wallet'] = $cw;
                            $data['user']['reward_wallet'] = $rw;
                            $data['user']['my_wallet'] = $mw;
                            $data['user']['incentive_wallet'] = $iw;  
                            $noti = get_notification_count($lgid);
                            if($noti){
                               $data['user']['notification_count'] = $noti->noti_count;
                            }
                            else{
                                $data['user']['notification_count'] = '0';
                            }                        
                       }else{
                         $data['user'] = array();  
                       }
              
              }else{
                $data['user'] = new stdClass(); 
              } 
              }
              else{
                $data['user'] = new stdClass();
              } }else{
                $data['user'] = new stdClass();
              }}else{
                $data['user'] = new stdClass(); 
              }        
             return $data;
      }
      function get_total_wallet_amount_customer($login_id)
        {
                $qry = "select sum(wl.total_value) as_total
                        from gp_wallet_values wl
                        where wl.user_id = '$login_id'";
                $qry = $this->db->query($qry);
               // echo $this->db->last_query();exit();
                if($qry->num_rows()>0)
                {
                    return $qry->row_array();
                }else
                {
                    return array();
                }
            
        }

       function  complete_billing($id,$shop_id,$my_wallet_amount,$reward_wallet_amount,$incentive_wallet_amount,$club_wallet_amount)
        {        
          $this->db->trans_begin();
          $date = date('Y-m-d h:i:s');
          $sum = intval($my_wallet_amount) + intval($reward_wallet_amount)+intval($incentive_wallet_amount) + intval($club_wallet_amount);
          $data = array(
              'channel_partner_id' =>$shop_id,
              'login_id' =>$id,
              'wallet_total' => $sum,
              'status' => 0,
              'purchased_on'=>$date
              );
          $qry_otp = $this->db->insert('gp_purchase_bill_notification', $data);
          $ins = $this->db->insert_id();
          $reward_id = get_wallet_id($id,4);
          $my_id = get_wallet_id($id,2);
          $club_id = get_wallet_id($id,1);
          $inc_id = get_wallet_id($id,5);

          $noty = array( array(

                    'wal_id' => $my_id,
                    'wal_value' => $my_wallet_amount
                    ), array(
                    
                    'wal_id' => $reward_id,
                    'wal_value' => $reward_wallet_amount
                    ), array(
                   
                    'wal_id' => $club_id,
                    'wal_value' => $club_wallet_amount
                    ), array(
                   
                    'wal_id' => $inc_id,
                    'wal_value' => $incentive_wallet_amount
                    )
                    
                    );
          foreach ($noty as $key => $value) {
            if(!empty($value['wal_id'])){
            $wal_data[] =  array(
                    'bill_notification_id' => $ins,
                    'wallet_id' => $value['wal_id'],
                    'wallet_value' => $value['wal_value']
                    );
           } }
          //echo json_encode($noty);exit();
          $qry_ins = $this->db->insert_batch('gp_purchase_bill_noty_wallet_items', $wal_data);
          $this->db->trans_complete();
          if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            return FALSE;
          } else {
            $this->db->trans_commit();  
            return TRUE; 
          }
        }
        function get_products_from_cp($id){
          $base= base_url();

          $qry = "select CONCAT(ROUND((((dt.actual_cost - dt.special_prize)/dt.actual_cost)*100),2), '%' ) as offer_percent, 
            CASE WHEN gpi.p_image ='' THEN '' 
                      ELSE CONCAT('$base',gpi.p_image)
                  END AS  image,
            dt.actual_cost as old_price,dt.id,
            CASE WHEN p.brand_image ='' THEN '' 
                      ELSE CONCAT('$base',p.brand_image)
                  END AS brand_logo,
            IFNULL(dt.name, '') as product_name, dt.special_prize as offer_price
            from gp_product_details dt 
            left join gp_pl_channel_partner p on p.id = dt.channel_partner_id 
            LEFT JOIN gp_product_image gpi on gpi.product_id = dt.id 
            left join gp_product_brands b on dt.brand_id = b.id 
            where  dt.is_del = 0 AND dt.channel_partner_id='$id' AND dt.is_del = '0' 
                  AND  dt.type = '0' GROUP BY dt.id  ORDER BY dt.id desc";
          $qry=$this->db->query($qry);
      
          if ($qry->num_rows() > 0) {
              $data['products'] = $qry->result_array();
              foreach ($data['products'] as $key => $value) {
                 $data['products'][$key]['isProduct'] = true;
                 $data['products'][$key]['rating'] = '0';
              }
          } else {
              $data['products'] =  array();
          }
          return $data;
        }
}
?>