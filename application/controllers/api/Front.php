<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Front extends CI_controller
{
    
    function __construct()
    {
        parent::__construct();

        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('api/Front_model');
        $this->load->helper(array('string','date','form'));
        header("Access-Control-Request-Headers:*");
        header('Access-Control-Allow-Origin: *');
        header("Access-Control-Allow-Headers: content-type, origin, accept, Authorization-key");
        header('Cache-control: no-cache');
        header("Connection: Keep-alive");

    }
    function index(){
            $api_key = $this->input->get_request_header('Authorization');
            $data = $this->Front_model->get_home_page_data($api_key);
    		if(!empty($data))
    		{
		        echo json_encode(array("error"=>false, 'message' => "Success", 'data' => $data));
		    }else{
		        echo json_encode(array("error"=>true, 'message' => "Invalid Customer"));
		    }	
    }
    function get_product(){
            $this->form_validation->set_rules('product_id', 'Product Id', 'required|trim|htmlspecialchars');
            if( $this->form_validation->run() === true )
             {
                $api_key = $this->input->get_request_header('Authorization');

                $product_id = $this->input->post('product_id');
                $data = $this->Front_model->get_product($api_key,$product_id);
                if(!empty($data))
                {
                    echo json_encode(array("error"=>false, 'message' => "Success", 'data' => $data));
                }else{
                    echo json_encode(array("error"=>true, 'message' => "Invalid Customer"));
                }
             }else{
            echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
        }        
    }
    function get_deal(){
            $this->form_validation->set_rules('product_id', 'Product Id', 'required|trim|htmlspecialchars');
            if( $this->form_validation->run() === true )
             {
                $api_key = $this->input->get_request_header('Authorization');
                if(!empty($api_key)){
                      $product_id = $this->input->post('product_id');
                      $check = $this->Front_model->check_quantity($product_id);
                      //var_dump($check);exit;
                      if($check)
                        {
                            $coupon_code = generate_coupon();

                            $user = user_details_by_apikey($api_key);
                            $user_id = $user['user_id'];
                            $login_id = $user['id'];
                            $data = $this->Front_model->get_deal($user_id,$login_id,$product_id,$coupon_code,$check);
                            if(!empty($data))
                            {
                                  $email = $user['email'];
                                  $price =(($check['special_prize'] * $check['coupon_percentage']) / ($check['special_prize'] )) * 100; 
                                  $email_details['coupon_code'] = $coupon_code;
                                  $email_details['name'] = $check['name'];
                                  $email_details['address'] = $check['address'];
                                  $email_details['city'] = $check['city'];
                                  $email_details['state'] = $check['state'];
                                  $email_details['country'] = $check['country'];
                                  $email_details['coupon_validity'] = $check['coupon_validity'];
                                  $email_details['price'] = $price;
                                  $mail = "maneeshakk16@gmail.com";
                                  $mail_head = 'Message From Jaazzo';
                                  $status = send_custom_email($mail, $mail_head, $email, 'Purchased deal coupon', $this->load->view('email_templates/coupon_purchase_confirmation', $email_details,TRUE));
                            echo json_encode(array("error"=>false, 'message' => "Ok", 'data' => $data));
                            }else{
                                echo json_encode(array("error"=>true, 'message' => "Invalid Customer"));
                            }
                        }else{
                            exit(json_encode(array("status"=>FALSE,"reason"=>'Sorry, Something went wrong!')));
                        }       
                    }else{
                       echo json_encode(array("error"=>true, 'message' => "Invalid Customer"));
                    }    
             }else{
            echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
        }   
        
    }

    function get_shops(){
        $this->form_validation->set_rules('key', 'Key', 'required|trim|htmlspecialchars');
            if( $this->form_validation->run() === true )
             {
                $key = $this->input->post('key');
                $base_url = base_url();
                $where = "c.status = 'JOINED' and c.is_del = '0' and c.is_active = '1' and c.name LIKE '%$key%'";
                $sel = " CONCAT('$base_url', c.profile_image)  as image,ct.name as city,c.address as location , c.id, c.name as shop_name";
                $on = "c.town = ct.id";
                $data['shops'] = raw_select("gp_pl_channel_partner c","cities ct",$on,$where,$sel);
                if(!empty($data['shops']))
                {
                    echo json_encode(array("error"=>false, 'message' => "Ok", 'data' => $data));
                }else{
                     $data['shops'] = array();
                    echo json_encode(array("error"=>true, 'message' => "No Shops available" ,'data' => $data));
                }
              }else{
           echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
        }            
    }
    function get_shop_suggestions(){
       
        $base_url = base_url();
        $where = "c.status = 'JOINED' and c.is_del = '0' and c.is_active = '1'";
        $sel = " CONCAT('$base_url', c.profile_image)  as image,ct.name as city,c.address as location , c.id, c.name as shop_name";
       
        $on = "c.town = ct.id";
        $data['shops'] = raw_select("gp_pl_channel_partner c","cities ct",$on,$where,$sel);
        if(!empty($data))
        {
            echo json_encode(array("error"=>false, 'message' => "Ok", 'data' => $data));
        }else{
            echo json_encode(array("error"=>true, 'message' => "No Shops available"));
        }               
    }
    function get_modules(){
        $where = "m.is_del = '0'";
        $select = "m.id as key ,m.module_name as value";
        $table = "gp_permission_module m";
        $type = "result_array";
        $data['modules'] = random_select($where,$select,$table,$type);
        
        if(!empty($data))
        {
            echo json_encode(array("error"=>false, 'message' => "Available modules", 'data' => $data));
        }else{
            echo json_encode(array("error"=>true, 'message' => "No modules available"));
        }       
    }

    function category_list(){
        
            $this->form_validation->set_rules('cat_id', 'Category', 'required');
            $this->form_validation->set_rules('page', 'Page', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('sort_id', 'Sort Id', 'required|trim|htmlspecialchars');
            $this->form_validation->set_rules('filter_options', 'Filter Options', 'required');
            if( $this->form_validation->run() === true )
            {
                
                $api_key = $this->input->get_request_header('Authorization');
                $cat_id = $this->input->post('cat_id');
                $page = $this->input->post('page');
                $sort_id = $this->input->post('sort_id');
                $filter_options = $this->input->post('filter_options');
               
                $page = empty($page) ? 1 : $page;
                $per_page =  20;
                $data = $this->Front_model->category_list($api_key,$cat_id,$page,$sort_id,$filter_options,$per_page);
                if(!empty($data))
                {
                    echo json_encode(array("error"=>false, 'message' => "Ok", 'data' => $data));
                }else{
                    echo json_encode(array("error"=>true, 'message' => "Invalid Customer"));
                }
            }else{
            echo json_encode(array("error"=>true,"message"=>strip_tags(validation_errors())));
       }        
    }

    function get_notifications(){
       
                $api_key = $this->input->get_request_header('Authorization');

                if(!empty($api_key)){
                  $user = user_details_by_apikey($api_key);
                  
                    if(!empty($user)){
                      $login_id = $user['id'];  
                          
                            $data['notifications'] =  $this->Front_model->get_notifications($login_id);
                            
                            if(!empty($data))
                            {
                                echo json_encode(array("error"=>false, 'message' => "Ok", 'data' => $data));
                            }else{
                                echo json_encode(array("error"=>true, 'message' => "No notifications"));
                            } 
                    }else{
                       echo json_encode(array("error"=>true, 'message' => "Invalid Customer"));
                    }        
                }else{
                    echo json_encode(array("error"=>true, 'message' => "Invalid Customer"));
                } 
                          
    }
    function delete_notification(){
        $api_key = $this->input->get_request_header('Authorization');

        if(!empty($api_key)){
          $user = user_details_by_apikey($api_key);
          
            if(!empty($user)){
              $login_id = $user['id'];  
                    $id = $this->input->post('id');
                    $data =  $this->Front_model->delete_notification($login_id,$id);
                    
                    if($data)
                    {
                        echo json_encode(array("error"=>false, 'message' => "Ok"));
                    }else{
                        echo json_encode(array("error"=>true, 'message' => "Database error occured!"));
                    } 
            }else{
               echo json_encode(array("error"=>true, 'message' => "Invalid Customer"));
            }        
        }else{
            echo json_encode(array("error"=>true, 'message' => "Invalid Customer"));
        }          
    }

    
    

    function get_notification_detail(){
       $this->form_validation->set_rules('id', 'Id', 'required|trim|htmlspecialchars'); 
       if( $this->form_validation->run() === true )
          {
                $api_key = $this->input->get_request_header('Authorization');

                if(!empty($api_key)){
                  $user = user_details_by_apikey($api_key);
                  
                    if(!empty($user)){
                      $login_id = $user['id'];  
                      $id = $this->input->post('id');    
                            
                            $where = "n.is_del = '0' and n.id = '$id' ";
                            $select = "n.id,n.title,n.description as notification,n.created_on as date";
                            $table = "admin_notifications n";
                            $type = "row";
                            $data = random_select($where,$select,$table,$type);
                            $tbl1 = "admin_notifications n";;
                            $set = array('is_read'=>'1');
                            $where1 = "n.id = '$id'";;
                            $up = update_tbl($tbl1,$set,$where1);
                            if(!empty($data))
                            {
                                echo json_encode(array("error"=>false, 'message' => "Ok", 'data' => $data));
                            }else{
                                echo json_encode(array("error"=>true, 'message' => "No notifications"));
                            } 
                    }else{
                       echo json_encode(array("error"=>true, 'message' => "Invalid Customer"));
                    }        
                }else{
                    echo json_encode(array("error"=>true, 'message' => "Invalid Customer"));
                } 
          }else{
            echo json_encode(array("error"=>true, 'message' => validation_errors()));
        }                   
    }

    function scan(){
       $this->form_validation->set_rules('id', 'Id', 'required|trim|htmlspecialchars');
       $this->form_validation->set_rules('qrcode', 'QR Code', 'required|trim|htmlspecialchars');  
       if( $this->form_validation->run() === true )
          {
                 
                $id = $this->input->post('id');
                $qrcode = $this->input->post('qrcode');      
                
                $where = "c.is_del = '0' and c.id = '$id' and c.qr_code = '$qrcode'";
                $select = "c.id as shop_id, c.name as shop_name";
                $table = "gp_pl_channel_partner c";
                $type = "row_array";
                $data = random_select($where,$select,$table,$type);
                if(!empty($data))
                {
                    echo json_encode(array("error"=>false, 'message' => "Success", 'data' => $data));
                }else{
                    echo json_encode(array("error"=>true, 'message' => "No shop found"));
                } 

          }else{
            echo json_encode(array("error"=>true, 'message' => validation_errors()));
        }                   
    }
    function get_billing_details(){
       $this->form_validation->set_rules('id', 'Id', 'required|trim|htmlspecialchars');
       if( $this->form_validation->run() === true )
          {                
                $id = $this->input->post('id');
               
                $data =  $this->Front_model->get_billing_details($id);
                if(!empty($data))
                {
                    echo json_encode(array("error"=>false, 'message' => "Success", 'data' => $data));
                }else{
                    echo json_encode(array("error"=>true, 'message' => "Database error occured!"));
                } 

          }else{
            echo json_encode(array("error"=>true, 'message' => validation_errors()));
        }                   
    }
   function get_shop_from_code(){
       $this->form_validation->set_rules('code', 'Code', 'required|trim|htmlspecialchars');  
       if( $this->form_validation->run() === true )
          {
                $qrcode = $this->input->post('code');      
                $base_url = base_url();
                $where = "c.is_del = '0' and c.qr_code = '$qrcode'";
                $select = "c.id, c.name as shop_name, c.town as city, c.address as location,
                 CONCAT('$base_url', c.profile_image)  as image";
                $table = "gp_pl_channel_partner c";
                $type = "row_array";
                $data = random_select($where,$select,$table,$type);
                if(!empty($data))
                {
                    echo json_encode(array("error"=>false, 'message' => "Shop for the code", 'data' => $data));
                }else{
                    echo json_encode(array("error"=>true, 'message' => "No shop found"));
                } 

          }else{
            echo json_encode(array("error"=>true, 'message' => validation_errors()));
        }                   
    }
    function get_channel_partner_type(){
     
        $data =  $this->Front_model->get_channel_partner_type();
        if(!empty($data))
        {
            echo json_encode(array("error"=>false, 'message' => "All Channel partner types", 'data' => $data));
        }else{
            echo json_encode(array("error"=>true, 'message' => "Database error occured!"));
        } 
               
    }
    function get_filter_options(){
       $this->form_validation->set_rules('cat_id', 'Category', 'required|trim|htmlspecialchars');  
       if( $this->form_validation->run() === true )
          {
                $cat_id = $this->input->post('cat_id');         
                $data =  $this->Front_model->get_filter_options($cat_id);
                if(!empty($data))
                {
                    echo json_encode(array("error"=>false, 'message' => "Ok", 'data' => $data));
                }else{
                    echo json_encode(array("error"=>true, 'message' => "No shop found"));
                } 

          }else{
            echo json_encode(array("error"=>true, 'message' => validation_errors()));
        }                   
    }
    function side_bar_data(){
        $api_key = $this->input->get_request_header('Authorization');    
        $data =  $this->Front_model->side_bar_data($api_key);
        if(!empty($data))
        {
            echo json_encode(array("error"=>false, 'message' => "Success", 'data' => $data));
        }else{
            echo json_encode(array("error"=>true, 'message' => "Database error occured!"));
        }            
    }

    function search(){
       $this->form_validation->set_rules('key', 'Key', 'required|trim|htmlspecialchars');  
       $this->form_validation->set_rules('location_id', 'Location id', 'required|trim|htmlspecialchars');  

       if( $this->form_validation->run() === true )
          {
                $key = $this->input->post('key'); 
                $location_id = $this->input->post('location_id'); 
                // $page = $this->input->post('page');
                // $limit = 5;
                // $where = "p.is_del = '0' and p.type = '0' and p.name like '%$key%'";
                // $select = "p.id, p.name";
                // $table = "gp_product_details p";
                // $type = "result_array";
                // $data['searchList'] = random_search($where,$select,$table,$type,$limit,$page);
                //$data['searchList'] = random_select($where,$select,$table,$type);
                $data = random_search($key,$location_id);
                if(!empty($data))
                {
                    echo json_encode(array("error"=>false, 'message' => "Ok", 'data' => $data));
                }else{
                    echo json_encode(array("error"=>true, 'message' => "No search results found"));
                } 

          }else{
            echo json_encode(array("error"=>true, 'message' => validation_errors()));
        }                   
    }


    function complete_billing(){
            $this->form_validation->set_rules('shop_id', 'Shop Id', 'required|trim|htmlspecialchars');
            if( $this->form_validation->run() === true )
             {
                $api_key = $this->input->get_request_header('Authorization');

                if(!empty($api_key)){
                  $user = user_details_by_apikey($api_key);
                     if(!empty($user)){
                        $login_id = $user['id'];
                               
                                $shop_id = $this->input->post('shop_id');
                                $my_wallet_amount = $this->input->post('my_wallet_amount');
                                $reward_wallet_amount = $this->input->post('reward_wallet_amount');
                                $incentive_wallet_amount = $this->input->post('incentive_wallet');
                                $club_wallet_amount = $this->input->post('club_wallet');
                                $wal_amount = $this->Front_model->get_total_wallet_amount_customer($login_id);
                                $sum_enterd = intval($my_wallet_amount) + intval($reward_wallet_amount) +
                                intval($incentive_wallet_amount) + intval($club_wallet_amount);
                                $in_wallet = $wal_amount['as_total'];
                                $in_wallet = intval($in_wallet);
                               // var_dump($in_wallet );var_dump($sum_enterd);exit();
                                if($in_wallet >= $sum_enterd){
                                  $mywallet =  check_bal_in_wallet($my_wallet_amount, $login_id,4);
                                  $rewardwallet =  check_bal_in_wallet($reward_wallet_amount, $login_id,2);
                                  $incentive_wallet =  check_bal_in_wallet($incentive_wallet_amount, $login_id,5);
                                  $club_wallet =  check_bal_in_wallet($club_wallet_amount, $login_id,1);
                                  if($mywallet && $rewardwallet && $incentive_wallet && $club_wallet) {  
                                    $data = $this->Front_model->complete_billing($login_id,$shop_id,$my_wallet_amount,$reward_wallet_amount,$incentive_wallet_amount,$club_wallet_amount);
                                        if(!empty($data))
                                        {
                                            echo json_encode(array("error"=>false, 'message' => "Success", 'data' => $data));
                                        }else{
                                            echo json_encode(array("error"=>true, 'message' => "Invalid Customer"));
                                        }
                                   } else{
                                        echo json_encode(array("status"=>FALSE,"reason"=>'Not Enough Money'));
                                   } 

                                } 
                                else{
                                        echo json_encode(array("status"=>FALSE,"reason"=>'Not Enough Money'));
                                }
                        }else{
                           echo json_encode(array("error"=>true, 'message' => "Invalid Customer"));
                    }        
                }else{
                    echo json_encode(array("error"=>true, 'message' => "Invalid Customer"));
                }           
             }else{
            echo json_encode(array("error"=>true, 'message' => validation_errors()));
        }        
    }
    function get_products_from_cp(){
        $this->form_validation->set_rules('channel_id', 'Channel id', 'required|trim|htmlspecialchars');  

          if( $this->form_validation->run() === true )
          {
                $channel_id = $this->input->post('channel_id');
                $data = $this->Front_model->get_products_from_cp($channel_id);
                if(!empty($data))
                {
                    echo json_encode(array("error"=>false, 'message' => "Ok", 'data' => $data));
                }else{
                    echo json_encode(array("error"=>true, 'message' => "No search results found"));
                } 

          }else{
            echo json_encode(array('error'=>true,'message'=>strip_tags(validation_errors())));  
        }                   
    }

}