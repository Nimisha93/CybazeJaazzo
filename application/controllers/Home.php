<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Home extends CI_controller
{
	
	function __construct()
	{
		parent::__construct();
		$this->load->model(array('user/user_model','user/refer_model','user/product_model'));
		//$this->load->helper('url');
		$this->load->library(array('form_validation'));

		$this->load->helper(array('form', 'date'));
	}
	function index()
	{
	//	$this->load->library('session');
		$session_array = $this->session->userdata('logged_in_user');
		if(isset($session_array)){
			$login_id = $session_array['id'];
			$data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
			$data['channel_partner'] = $this->user_model->get_channel_partner();	
			$data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);	
			$data['vallet_type'] = $this->product_model->get_wallet();
		}
        
		$data['category']=$this->product_model->get_cpcategory();
		$data['subcategory']=$this->product_model->get_cpscategory();
		$data['products'] = $this->product_model->get_Product();
        $data['deal'] = $this->product_model->get_deal_product();
        $data['submenu'] = $this->product_model->get_submenu();

        $data['product'] = $this->product_model->get_product_view();


//echo json_encode($data['product']);
       // $data['prod'] = $this->product_model->get_product_view();
                $data['left_adv'] = $this->user_model->get_ads();
                $data['centre_adv'] = $this->user_model->get_ads_center();
                $data['right_adv'] = $this->user_model->get_ads_right();
                  // $data['user']=$this->user_model->get_normal_customer($userid);

		$data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
		$data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
		$data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

		$this->load->view("public/edit_landing_page",$data);
	}
	function show_deals()
	{
		$session_array = $this->session->userdata('logged_in_user');
		if(isset($session_array)){
			$login_id = $session_array['id'];
			$data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
			$data['channel_partner'] = $this->user_model->get_channel_partner();	
			$data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);	
			$data['vallet_type'] = $this->product_model->get_wallet();
		}

		$data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
		$data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
		$data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
		$this->load->view("public/edit_show_deals",$data);
	}
	function product_details($id)
	{
		$session_array = $this->session->userdata('logged_in_user');
		if(isset($session_array)){
			$login_id = $session_array['id'];
			$data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
			$data['channel_partner'] = $this->user_model->get_channel_partner();
			$data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);	
		}
		$data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
		$data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
    $data['products'] = $this->product_model->get_product_details_by_id($id);
    $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
//  $data['p_image'] = $this->product_model->get_product_image($id);
		$this->load->view("public/edit_show_product_details",$data);
	}
	function club_membership()
	{
		$session_array = $this->session->userdata('logged_in_user');
		if(isset($session_array)){
			$login_id = $session_array['id'];
			$data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
			$data['channel_partner'] = $this->user_model->get_channel_partner();	
			$data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
			$data['vallet_type'] = $this->product_model->get_wallet();	
		}
		
		$data['category']=$this->product_model->get_cpcategory();
		$data['subcategory']=$this->product_model->get_cpscategory();
    $data['club_types'] = $this->user_model->get_all_club_types();
		$data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
		$data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
		$data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
		$this->load->view("public/edit_club_member_details",$data);
	}

	function product_deal($id)
    {


		$session_array = $this->session->userdata('logged_in_user');
		if(isset($session_array)){
			$login_id = $session_array['id'];
			$data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
			$data['channel_partner'] = $this->user_model->get_channel_partner();	
			$data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);	
				$data['vallet_type'] = $this->product_model->get_wallet();
		}


        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $data['deals'] = $this->product_model->get_product_details_by_id($id);


//        $data['p_image'] = $this->product_model->get_product_image($id);
        $this->load->view("public/edit_show_deal_details",$data);

    }
     function type_wallet()
    {
        $session_array = $this->session->userdata('logged_in_user');
        if(isset($session_array))
        {
            $login_id = $session_array['id'];

            $id =  $this->input->post('id');

        	$result=$this->product_model->get_wallet_amout($id,$login_id);
      //  $this->user_model->get_channel_partner();
        	if($result)
        	{
        		$res = round_number($result['total_value']);
            //exit(json_encode(array("status"=>TRUE)));
            	exit(json_encode(array("status"=>TRUE,"value"=>$res)));

        	}
        	else
        	{
        		exit(json_encode(array("status"=>FALSE,"value"=>$result)));
        	}
        }
	}

  function profile()
	{
		$session_array = $this->session->userdata('logged_in_user');
		if(isset($session_array)){
			$login_id = $session_array['id'];
			$loginsession = $this->session->userdata('logged_in_user');
			$userid=$loginsession['user_id'];

			$data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
			$data['channel_partner'] = $this->user_model->get_channel_partner();
			$data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
      $data['refer'] = $this->refer_model->get_refer($login_id);
      $data['child'] = $this->refer_model->get_child($login_id);
      // print_r($data['child']); exit();

    $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
		$data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
		$data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

             if($loginsession['type'] == 'normal_customer' || $loginsession['type'] == 'club_member' )
                     {
                     		$data['user']=$this->user_model->get_normal_customer($userid);

                          $data['user_image']=$this->user_model->get_image($userid);


                         $this->load->view('public/edit_profile',$data);

                     }

		}

		}
        function edit_normal_byid($id){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("address", "Address ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Mobile", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone2", "Mobile2", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email ", "trim|required|htmlspecialchars");

           if($this->form_validation->run()== TRUE)
           {



              $result = $this->user_model->update_normal_customer_byid($id);

                    if($result){
                        exit(json_encode(array("status"=>TRUE)));
                    }
                    else{

                        exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                    }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
        else
        {
            show_error("We are unable to process this request on this way!");
        }

}
 function do_upload()
{

    $this->load->library('upload');
    $images=array();
    $data=array();
    $files = $_FILES;
    $cpt = count($_FILES['userfile']['name']);
    for($i=0; $i<$cpt; $i++)
    {
        $_FILES['userfile']['name']= $files['userfile']['name'][$i];
        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
        $_FILES['userfile']['size']= $files['userfile']['size'][$i];

        $this->upload->initialize($this->set_upload_options());
         $upload_img= $this->upload->do_upload();
         if(!$upload_img){
		        	exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
		        } else{
		        	$fileName = $_FILES['userfile']['name'];
			    	$images[] = $fileName;
		        }
		        $session_array = $this->session->userdata('logged_in_user');
		        $loginsession = $this->session->userdata('logged_in_user');
		        $userid=$loginsession['user_id'];



    }
     foreach ($images as $key => $img) {
		        	 $data[] = array('user_id'=>$userid,'profile'=>$img);

       //  echo json_encode($data);
		        }


        $query=$this->user_model->image_add($data);
        if($query){
            redirect('Home/profile/');
        }
}

private function set_upload_options()
{
    //upload an image options
    $config = array();
    $config['upload_path'] = './uploads/';
    $config['allowed_types'] = 'gif|jpg|png';

    //$config['max_size']	= '100';
   // $config['max_width']  = '1024';
	//$config['max_height']  = '768';
    $config['overwrite']     = FALSE;

    return $config;
}


 function view_image()
    {
              //$session_array = $this->session->userdata('logged_in_user');
		        $loginsession = $this->session->userdata('logged_in_user');
		        $userid=$loginsession['user_id'];
            $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
		        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
		        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

// var_dump( $data['user']);
    $this->load->view('edit_profile',$data);

    }


public function edit_image(){

                          $id = $this->input->post('userfile');

                          if(($_FILES['userfile']['name']) != NULL)
                                {


                        $config['upload_path']   = './uploads';
                        $config['allowed_types'] = 'gif|jpg|png|flv|f4v';
                        $config['max_size']      = 2048;
                        $config['max_width']     = 2048;
                        $config['max_height']    = 2048;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);


                            if ( ! $this->upload->do_upload('userfile'))
                            {
                                exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));

                            }
                            else
                            {
                                $uploading_file = $this->upload->data();
                                $image_file = $uploading_file['file_name'];

                            }

                        } else {
                            $current_image = $this->Baner_model->get_cur_client_img($id);

                            $image_file = $current_image['image'];

                        }

                            $update = $this->Baner_model->edit_profile($image_file,$id);
                           if($update)
                           {
                         redirect('Home/profile');
                           }else{
                            exit(json_encode(array('status'=>FALSE, 'reason'=>"Database Error")));
                           }
                       }



    //Arya
    function ba_mail()
    {

        //echo "kjhfkj";
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("email", "Email", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Mobile", "trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){

                $mail_from = 'greenindia@gmail.com';
                $mail_head = 'Green India';
                $subject = 'BA Request';
                $email=$this->input->post('email');
                $phone=$this->input->post('phone');

                $email_message = "Thank you for your recent request submission!  Your request has been received and added . We will contact you very soon!  ";
                $mail= send_custom_email($mail_from, $mail_head, $email, $subject, $email_message);

                if($mail)
                {

                    $mail_from = 'greenindia@gmail.com';
                    $mail_head = 'Green India';
                    $mail_to = 'arya@cybaze.com';
                    $subject = 'BA Request';
                    $email=$this->input->post('email');
                    $phone=$this->input->post('phone');
                    // $email_message = $this->load->view('public/edit_email_template_otp', '',TRUE);
                    $email_message = "request for business associates name:$email , phone: $phone";
                    $mail= send_custom_email($mail_from, $mail_head, $mail_to, $subject, $email_message);

                    exit(json_encode(array("status"=>TRUE)));

                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }

        else
        {
            echo "unable to process in this way";
        }
    }
    function get_all_products()
    {
    //  $this->load->library('session');
        $session_array = $this->session->userdata('logged_in_user');
        if(isset($session_array)){
            $login_id = $session_array['id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['vallet_type'] = $this->product_model->get_wallet();
        }

        $data['get_category']=$this->product_model->get_all_category();
        $data['get_brand']=$this->product_model->get_all_brands();
       // $data['allproduct']=$this->product_model->getAllProduct();
       $this->load->library('pagination');

      $brand = $this->input->post('brand');
      $catgery = $this->input->post('catgery');
      //var_dump($where);
        $brand =  $brand=="0"? "" : "and dt.brand_id = '$brand' ";
      //  var_dump($brand);
        if($brand == "")
        {
          $catgery =  $catgery=="0"? "" : "and dt.category_id = '$catgery'";
        }else{
           $catgery =  $catgery=="0"? "" : "or dt.category_id = '$catgery'";
        }



        $where = $brand.$catgery;
    //   var_dump($where);
      $config["base_url"] = base_url().'home/get_all_products/';
      $config["total_rows"] = $this->product_model->getAllProductCount($where);
      //var_dump($config["total_rows"]); exit();

      $config["per_page"] = 8;

      //pagination customization using bootstrap styles
      $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
      $config['full_tag_close'] = '</ul></div><!--pagination-->';

      $config['first_link'] = '&laquo; First';
      $config['first_tag_open'] = '<li class="prev page">';
      $config['first_tag_close'] = '</li>';

      $config['last_link'] = 'Last &raquo;';
      $config['last_tag_open'] = '<li class="next page">';
      $config['last_tag_close'] = '</li>';

      $config['next_link'] = 'Next &rarr;';
      $config['next_tag_open'] = '<li class="next page">';
      $config['next_tag_close'] = '</li>';

      $config['prev_link'] = '&larr; Previous';
      $config['prev_tag_open'] = '<li class="prev page">';
      $config['prev_tag_close'] = '</li>';



      $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
      $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";

      $config['num_tag_open'] = '<li class="page">';
      $config['num_tag_close'] = '</li>';

      $this->pagination->initialize($config);
      $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
      $data['page'] = $page;

      $data["data"] = $this->product_model->getAllProduct($where, $config["per_page"],$page);

        //check if ajax is called
        if($this->input->post('ajax', FALSE))
        {       exit(json_encode(array(
               'data' => $data["data"],
               'status' => $data["data"]["status"],
               'pagination' => $this->pagination->create_links()
            )));
        }




        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_show_all_product",$data);
    }

    function map_search()
    {
    $session_array = $this->session->userdata('logged_in_user');
    if(isset($session_array)){
        $login_id = $session_array['id'];
        $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
        $data['channel_partner'] = $this->user_model->get_channel_partner();
        $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
        $data['vallet_type'] = $this->product_model->get_wallet();
    }

    $data['category']=$this->product_model->get_cpcategory();
    $data['subcategory']=$this->product_model->get_cpscategory();
    $data['products'] = $this->product_model->get_Product();
    $data['deal'] = $this->product_model->get_deal_product();
    $data['submenu'] = $this->product_model->get_submenu();
    $data['premiyam'] = $this->product_model->get_premiyam();
    $data['prod'] = $this->product_model->get_product_view();

    $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
    $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
    $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

    $this->load->view("public/edit_map_search_page",$data);
}

    function module_inner()
    {
        $session_array = $this->session->userdata('logged_in_user');
        if(isset($session_array)){
            $login_id = $session_array['id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['vallet_type'] = $this->product_model->get_wallet();
        }

        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['products'] = $this->product_model->get_Product();
        $data['deal'] = $this->product_model->get_deal_product();
        $data['submenu'] = $this->product_model->get_submenu();
        $data['premiyam'] = $this->product_model->get_premiyam();
        $data['prod'] = $this->product_model->get_product_view();

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_module_inner_page",$data);
    }


//hridya 10-04-2017
     function change_current_pass()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('old', 'Username', 'required|trim');
            $this->form_validation->set_rules('new_pass', 'Password', 'required|trim');
            $this->form_validation->set_rules('confirm_pass', 'Username', 'required|trim');
           
            if($this->form_validation->run() == TRUE)
            {
                $old_pass = $this->input->post('old');

                $new_pass = $this->input->post('new_pass');
                $confirm_pass = $this->input->post('confirm_pass');
                $session_array = $this->session->userdata('logged_in_user');
                
                $user_id = $session_array['id'];

                $current_pass = $this->user_model->get_current_pass($user_id);
                $current_pass = $current_pass['password'];
                
                if($current_pass == $old_pass)
                {
                    if($new_pass == $confirm_pass){
                        $update_pass = $this->user_model->update_pass($new_pass, $user_id);
                        if($update_pass)
                        {
                            exit(json_encode(array('status'=>true)));
                        } else
                        {
                            exit(json_encode(array('status'=>false, 'reason'=>'Database Error')));
                        }
                    } else
                    {
                        exit(json_encode(array('status'=>false, 'reason'=>'New password and Confirm Password Does not Matchs')));
                    }
                } else
                {
                    exit(json_encode(array('status'=>false, 'reason'=>'This is not your old password :(')));
                }
                
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } 
        else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        }
        
    
    }
         

}


?>
