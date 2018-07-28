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
        $this->load->model(array('user/user_model','user/refer_model','user/product_model','admin/Channelpartner_model','register_model','admin/Executives_model'));
        //$this->load->helper('url');
        $this->load->library(array('form_validation'));

        $this->load->helper(array('form', 'date','string'));
    }
    function index()
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
        
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['products'] = $this->product_model->get_Product();
        $data['deal'] = $this->product_model->get_deal_product();
        $data['submenu'] = $this->product_model->get_submenu();
        $data['product'] = $this->product_model->get_product_view();
        $data['left_adv'] = $this->user_model->get_ads();
        $data['centre_adv'] = $this->user_model->get_ads_center();
        $data['right_adv'] = $this->user_model->get_ads_right();
        $data['bottom_adv'] = $this->user_model->get_ads_bottom();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_landing_page",$data);
    }
    function login_mobile()
    {
        $session_array = $this->session->userdata('logged_in_user');

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/page1",$data);
    }
    function cp_signup($otp,$id)
    {
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_ca_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $id = $id;
        $data['details'] = $this->Channelpartner_model->get_cp_details($id);
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        
        $this->load->view("public/edit_cp_signup",$data);
    }
    function create_an_account_mob()
    {
        $session_array = $this->session->userdata('logged_in_user');

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/page2",$data);
    }
    function become_ba_mob()
    {
        $session_array = $this->session->userdata('logged_in_user');

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/page3",$data);
    }
    function add_agent()
    {
        $session_array = $this->session->userdata('logged_in_user');
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/add-agent",$data);
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
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $data['products'] = $this->product_model->get_product_details_by_id($id);
        $data['subcptype']=$this->product_model->get_subcptype();
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        // echo json_encode($data['products']);exit;
        //  $data['p_image'] = $this->product_model->get_product_image($id);
        $this->load->view("public/edit_show_product_details",$data);
        //  $this->load->view("public/edit_landing_page1",$data);
    }
    function module_single($id)
    {
        //var_dump($id);exit;
        $session_array = $this->session->userdata('logged_in_user');
        if(isset($session_array)){
            $login_id = $session_array['id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['vallet_type'] = $this->product_model->get_wallet();
        }
//      $data['category']=$this->product_model->get_cpcategory_module_wise($id);
//       $data['subcategory']=$this->product_model->get_cpscategory_module_wise($id);
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['products'] = $this->product_model->get_Product();
        $data['deal'] = $this->product_model->get_deal_product_module_wise($id);
        $data['submenu'] = $this->product_model->get_submenu();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['product'] = $this->product_model->get_product_view_module_wise($id);


       // echo json_encode($data['deal']);
        // $data['prod'] = $this->product_model->get_product_view();
        $data['left_adv'] = $this->user_model->get_ads();
        $data['centre_adv'] = $this->user_model->get_ads_center();
        $data['right_adv'] = $this->user_model->get_ads_right();
        // $data['user']=$this->user_model->get_normal_customer($userid);

        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/edit_show_individual_module_details",$data);
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
        $data['subcptype']=$this->product_model->get_subcptype();
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
            $data['countries'] = $this->Channelpartner_model->get_countries();
            $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
            $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
            $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
            if($loginsession['type'] == 'normal_customer' || $loginsession['type'] == 'club_member'|| $loginsession['type'] == 'club_agent' )
            {
                $data['user']=$this->user_model->get_normal_customer($userid);
                if($data['user']['country'])
                {
                    $country = $data['user']['country'];
                    $data['state'] = $this->register_model->get_state_by_country($country);
                }
                $data['user_image']=$this->user_model->get_image($userid);
                $this->load->view('public/edit_profile',$data);
            }
        }
    }
        function edit_normal_byid($id){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            //$this->form_validation->set_rules("address", "Address ", "trim|required|htmlspecialchars");
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

    //$config['max_size']   = '100';
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
                   $sql = "select email from gp_login_table where type = 'super_admin'";
                    $sql = $this->db->query($sql);
                    $qr = $sql->row_array();
                    $email = $qr['email'];

                    $mail_from = 'greenindia@gmail.com';
                    $mail_head = 'Green India';
                    $mail_to = $email;
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
        $session_array = $this->session->userdata('logged_in_user');
        if(isset($session_array)){
            $login_id = $session_array['id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['vallet_type'] = $this->product_model->get_wallet();
        }

        $data['get_category']=$this->product_model->get_all_category();
       //echo json_encode($data['get_category']);exit;
        $data['get_brand']=$this->product_model->get_all_brands();
       $this->load->library('pagination');

      $brand = $this->input->post('brand');
      $catgery = $this->input->post('catgery');
      //var_dump($catgery);
       //var_dump($brand);exit;
        $brand =  $brand=="0"? "" : "and dt.brand_id = '$brand' ";
     // var_dump($brand);exit;
        if($brand == "")
        {
          $catgery =  $catgery=="0"? "" : "and dt.category_id = '$catgery'";
        }else{
           $catgery =  $catgery=="0"? "" : "or dt.category_id = '$catgery'";
        }



        $where = $brand.$catgery;
     // var_dump($where);exit;
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
     //echo json_encode($data["data"]);exit;
        //check if ajax is called
      //  echo json_encode( $data["data"]["status"]);exit;

        if($this->input->post('ajax') == true)
        {       exit(json_encode(array(
            'data' => $data["data"],
            'status' => $data["data"]["status"],
            'pagination' => $this->pagination->create_links()
        )));
        }

//echo json_encode( $data);
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);

        $this->load->view("public/edit_show_all_product",$data);
    }
    function get_all_products_by_id($id)
    {
        $session_array = $this->session->userdata('logged_in_user');
        if(isset($session_array)){
            $login_id = $session_array['id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
            $data['vallet_type'] = $this->product_model->get_wallet();
        }

        $data['get_category']=$this->product_model->get_all_category();
        //echo json_encode($data['get_category']);exit;
        $data['get_brand']=$this->product_model->get_all_brands();
        $this->load->library('pagination');

        $brand = $this->input->post('brand');
        $catgery = $this->input->post('catgery');
        //var_dump($catgery);
        //var_dump($brand);exit;
        $brand =  $brand=="0"? "" : "and dt.brand_id = '$brand' ";
        // var_dump($brand);exit;
        if($brand == "")
        {
            $catgery =  $catgery=="0"? "" : "and dt.category_id = '$catgery'";
        }else{
            $catgery =  $catgery=="0"? "" : "or dt.category_id = '$catgery'";
        }



        $where = $brand.$catgery;
        // var_dump($where);exit;
        $config["base_url"] = base_url().'home/get_all_products/';
        $config["total_rows"] = $this->product_model->getAllProductCountById($where,$id);
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

        $data["data"] = $this->product_model->getAllProductById($where, $config["per_page"],$page,$id);
        //echo json_encode($data["data"]);exit;
        //check if ajax is called
        //  echo json_encode( $data["data"]["status"]);exit;

        if($this->input->post('ajax') == true)
        {       exit(json_encode(array(
            'data' => $data["data"],
            'status' => $data["data"]["status"],
            'pagination' => $this->pagination->create_links()
        )));
        }

//echo json_encode( $data);
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
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
    function exec_sett_signup($id)
    {
       
       
        $data['details'] =$this->Executives_model->get_executives_userid($id);
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_ca_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/exec_signup",$data);
    }
 function signup_executive()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('email', 'Email', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_message('password_check', '%s must contain both numbers and alphabets');
           
            if($this->form_validation->run() == TRUE)
            {
                $mail = $this->input->post('email');
                $id = $this->input->post('id');
                /*$validate_email = $this->register_model->validate_mail($mail,$id);
                
                if($validate_email['status'] === TRUE)
                {*/
                    $password = $this->input->post('password');
                    $validate_password = $this->Executives_model->validate_password(encrypt_decrypt('encrypt',$this->input->post('password')));
                    if($validate_password['status'] === TRUE)
                    {
                        $cpassword =$this->input->post('cpassword');
                        
                        if($password==$cpassword){
                            $password =encrypt_decrypt('encrypt',$this->input->post('password'));
                            
                            $data_input = array('password'=>$password,'otp_status'=>1,'email'=>$mail);
                            $where = array('id'=>$id);
                            $res = update_tbl('gp_login_table',$data_input,$where);
                            
                            if($res)
                            {
                               /* $where = 'gp_login_table.user_id=gp_normal_customer.id';
                                $result = select_all_by_id('gp_login_table',$id,'gp_normal_customer',$where);*/
                                /*$session_array = array();
                                $session_array = array(
                                        'id' => $result->id,
                                        'type' => $result->type,
                                        'email' => $result->email,
                                        'mobile' => $result->mobile,
                                        'user_id' => $result->user_id,
                                        'club_type_id'=>$result->club_type_id,
                                        'login' =>true);
                                $this->session->set_userdata('logged_in_user', $session_array);*/
                                exit(json_encode(array('status'=>true)));
                            }else{
                                exit(json_encode(array('status'=>false)));
                            }
                        }else{
                            exit(json_encode(array('status'=>false, 'reason'=>'Password and Confirm should be same')));
                        }
                    }else{
                        exit(json_encode(array('status'=>false, 'reason'=>'Password already exist')));
                    }
                /*}else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Email already exist')));
                }*/
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        }  
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
            $this->form_validation->set_rules('confirm_pass', 'Confirm Password', 'required|trim');
           
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


    // Club Agent
    function add_club_agent()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('name', 'Name', 'required|trim');
            $this->form_validation->set_rules('mail', 'Email', 'required|trim');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|trim');
            /*if (empty($_FILES['ufile']['name']))
            {
              $this->form_validation->set_rules('ufile', 'File', 'required');
            }*/
            if($this->form_validation->run() == TRUE)
            {
                $name = $this->input->post('name');
                $mail = $this->input->post('mail');
                $validate_email = $this->register_model->validate_email($mail);
                
                if($validate_email['status'] === TRUE)
                {
                    $mobile = $this->input->post('mobile');
                    $validate_phone = $this->register_model->validate_phone($mobile);
                    if($validate_phone['status'] === TRUE)
                    {
                        $files = $_FILES;
                        $config['upload_path'] =  './uploads/ca_docs';
                        $config['allowed_types'] = 'doc|docx|pdf|jpg|jpeg|png';
                        $config['max_size'] = '2000000';
                        $config['remove_spaces'] = true;
                        $config['overwrite'] = false;
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        if (!$this->upload->do_upload('ufile'))
                        {
                          exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
                        }else{
                            $_FILES['ufile']['name']= time().str_replace(' ', '_', $files['ufile']['name']);
                            $_FILES['ufile']['type']= $files['ufile']['type'];
                            $_FILES['ufile']['tmp_name']= $files['ufile']['tmp_name'];
                            $_FILES['ufile']['error']= $files['ufile']['error'];
                            $_FILES['ufile']['size']= $files['ufile']['size'];
                            $this->upload->do_upload('ufile');
                            $fileName = time().str_replace(' ', '_', $files['ufile']['name']);
                            $upload_data = $this->upload->data();
                            $data=array('mobile' => $mobile,
                            'name' => $name,
                            'email' => $mail,
                            'file'=>'uploads/ca_docs/'.$fileName
                            );
                            $result = $this->register_model->add_club_agent($data);
                            //var_dump($result);exit();
                            if($result)
                            {
                                $data['id'] = $result['info']['user_id'];
                                $data['otp'] = $result['info']['otp'];
                                $email = "maneeshakk16@gmail.com";
                                $mail_head = 'Message From Jaazzo';
                                $status = send_custom_email($email, $mail_head, $mail, 'Sign Up - Club Agent', $this->load->view('templates/public/mail/ca_sign_up', $data,TRUE));
                                if($status)
                                {
                                    exit(json_encode(array('status'=>true)));
                                }else{
                                    exit(json_encode(array("status"=>TRUE)));
                                }
                            }else{
                                exit(json_encode(array('status'=>false, 'reason'=>'Database Error')));
                            }

                        }
                    }else{
                        exit(json_encode(array('status'=>false, 'reason'=>'Mobile already exist')));
                    }
                }else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Email already exist')));
                }
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        }  
    } 
    function ca_signup($otp,$id)
    {
        $otp =  encrypt_decrypt('decrypt',$otp);
        $id = $id;
        $data['details'] = $this->register_model->get_ca_details($id);
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_ca_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/edit_memberagent_signup",$data);
    }
    public function password_check($str)
    {
        if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
          return TRUE;
        }
       return FALSE;
    }
    function signup_clubagent()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('email', 'Email', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_message('password_check', '%s must contain both numbers and alphabets');
           
            if($this->form_validation->run() == TRUE)
            {
                $mail = $this->input->post('email');
                $id = $this->input->post('id');
                /*$validate_email = $this->register_model->validate_mail($mail,$id);
                
                if($validate_email['status'] === TRUE)
                {*/
                    $password = $this->input->post('password');
                    $validate_password = $this->register_model->validate_password(encrypt_decrypt('encrypt',$this->input->post('password')));
                    if($validate_password['status'] === TRUE)
                    {
                        $cpassword =$this->input->post('cpassword');
                        if($password==$cpassword){
                            $password =encrypt_decrypt('encrypt',$this->input->post('password'));
                            $data_input = array('password'=>$password,'otp_status'=>1,'email'=>$mail);
                            $where = array('id'=>$id);
                            $res = update_tbl('gp_login_table',$data_input,$where);
                            if($res)
                            {
                                $where = 'gp_login_table.user_id=gp_normal_customer.id';
                                $result = select_all_by_id('gp_login_table',$id,'gp_normal_customer',$where);
                                /*$session_array = array();
                                $session_array = array(
                                        'id' => $result->id,
                                        'type' => $result->type,
                                        'email' => $result->email,
                                        'mobile' => $result->mobile,
                                        'user_id' => $result->user_id,
                                        'club_type_id'=>$result->club_type_id,
                                        'login' =>true);
                                $this->session->set_userdata('logged_in_user', $session_array);*/
                                exit(json_encode(array('status'=>true)));
                            }else{
                                exit(json_encode(array('status'=>false)));
                            }
                        }else{
                            exit(json_encode(array('status'=>false, 'reason'=>'Password and Confirm should be same')));
                        }
                    }else{
                        exit(json_encode(array('status'=>false, 'reason'=>'Password already exist')));
                    }
                /*}else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Email already exist')));
                }*/
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        }  
    }
    function change_password()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('opassword', 'Old Password', 'required|trim');
            $this->form_validation->set_rules('npassword', 'Password', 'required|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[npassword]|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_message('password_check', '%s must contain both numbers and alphabets');

            if($this->form_validation->run() == TRUE)
            {
                $old_pass = $this->input->post('opassword');
                $new_pass = $this->input->post('npassword');
                $confirm_pass = $this->input->post('cpassword');

                $session_array = $this->session->userdata('logged_in_user');
                $log_id = $session_array['id'];
                $current_pass_status = $this->register_model->check_current_pwd($log_id,$old_pass);
                if($current_pass_status['status']==true)
                {
                    if($new_pass == $confirm_pass){
                        $update_pass = $this->register_model->update_password($new_pass,$log_id);
                        if($update_pass)
                        {
                            exit(json_encode(array('status'=>true)));
                        } else{
                            exit(json_encode(array('status'=>false, 'reason'=>'Database Error')));
                        }
                    } else{
                        exit(json_encode(array('status'=>false, 'reason'=>'New password and Confirm Password Does not Matchs')));
                    }
                } else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Current Password is incorrect')));
                }
                
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        }
    }
    function add_member()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("email","Email","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("mobile","Mobile No","required|htmlspecialchars");
            $this->form_validation->set_rules("name","Name","trim|required|htmlspecialchars");
            if( $this->form_validation->run() == TRUE )
            {
                // $reg_email = $this->input->post('email');
                // $validate_email = $this->register_model->validate_email($reg_email);
                
                // if($validate_email['status'] === TRUE)
                // {
                        // $reg_phone =  $this->input->post('phone');
                        // $validate_phone = $this->register_model->validate_phone($reg_phone);
                        // if($validate_phone['status'] === TRUE)
                        // {
                            $name = $this->input->post('name');
                            $mobile = $this->input->post('mobile');
                            $email = $this->input->post('email');
                            $results=$this->register_model->add_normal_customer();
                            if($results['status'] == TRUE){
                                $otp = $results['info']['otp'];
                                $username = "pranavpk.pk1@gmail.com";
                                $hash = "4ec424c177ff9fdebcb835599d38a546ff2238cd";
                                $test = "0";
                                $sender = "TXTLCL"; // This is who the message appears to be from.
                                $numbers = $mobile; // A single number or a comma-seperated list of numbers
                                $url = base_url().'Register/signup/'.encrypt_decrypt('encrypt',$otp);
                                $message = "Hi, This is from Jaazzo.If you are interested to join with us.Please follow the link below.".$url;
                                $message = urlencode($message);
                                $data = "username=" . $username . "&hash=" . $hash . "&message=" . $message . "&sender=" . $sender . "&numbers=" . $numbers . "&test=" . $test;
                                $ch = curl_init('http://api.textlocal.in/send/?');
                                curl_setopt($ch, CURLOPT_POST, true);
                                curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
                                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                                $result = curl_exec($ch); // This is the result from the API
                                curl_close($ch);
                                if($result){
                                    exit(json_encode(array("status"=>TRUE)));
                                }
                            }else{
                                exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                            }
                        // }else{
                        //     exit(json_encode(array("status"=>FALSE,"reason"=>$validate_phone['reason'])));
                        // }
                    // }else{
                    //     exit(json_encode(array("status"=>FALSE,"reason"=>$validate_email['reason'])));
                    // }
            }else{  
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }   
        }else{
            show_error("We are unable to process this request on this way!");   
        }
    }
    function customer_signup()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("email","Email","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("mobile","Mobile No","required|htmlspecialchars");
            $this->form_validation->set_rules("name","Name","trim|required|htmlspecialchars");
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_message('password_check', '%s must contain both numbers and alphabets');
            if( $this->form_validation->run() == TRUE )
            {
                $data = array('email'=>$this->input->post('email'),
                    'name'=>$this->input->post('name'),
                    'mobile'=>$this->input->post('mobile'),
                    'password'=>$this->input->post('password'),
                    'id'=>$this->input->post('id'),
                    'created_by'=>$this->input->post('created_by')
                    );
                $result = $this->register_model->customer_signup($data);
                if($result['status']){
                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }
            }else{  
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }   
        }else{
            show_error("We are unable to process this request on this way!");   
        }
    }
    function exec_sett_signup($id)
    {
       
       
        $data['details'] =$this->Executives_model->get_executives_userid($id);
        $data['category']=$this->product_model->get_cpcategory();
        $data['subcategory']=$this->product_model->get_cpscategory();
        $data['subcptype']=$this->product_model->get_subcptype();
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_ca_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $this->load->view("public/exec_signup",$data);
    }
 function signup_executive()
    {
        if ($this->input->is_ajax_request()) 
        {
            $this->form_validation->set_rules('email', 'Email', 'required|trim');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]|min_length[6]|alpha_numeric|callback_password_check');
            $this->form_validation->set_message('password_check', '%s must contain both numbers and alphabets');
           
            if($this->form_validation->run() == TRUE)
            {
                $mail = $this->input->post('email');
                $id = $this->input->post('id');
                /*$validate_email = $this->register_model->validate_mail($mail,$id);
                
                if($validate_email['status'] === TRUE)
                {*/
                    $password = $this->input->post('password');
                    $validate_password = $this->Executives_model->validate_password(encrypt_decrypt('encrypt',$this->input->post('password')));
                    if($validate_password['status'] === TRUE)
                    {
                        $cpassword =$this->input->post('cpassword');
                        
                        if($password==$cpassword){
                            $password =encrypt_decrypt('encrypt',$this->input->post('password'));
                            
                            $data_input = array('password'=>$password,'otp_status'=>1,'email'=>$mail);
                            $where = array('id'=>$id);
                            $res = update_tbl('gp_login_table',$data_input,$where);
                            
                            if($res)
                            {
                               /* $where = 'gp_login_table.user_id=gp_normal_customer.id';
                                $result = select_all_by_id('gp_login_table',$id,'gp_normal_customer',$where);*/
                                /*$session_array = array();
                                $session_array = array(
                                        'id' => $result->id,
                                        'type' => $result->type,
                                        'email' => $result->email,
                                        'mobile' => $result->mobile,
                                        'user_id' => $result->user_id,
                                        'club_type_id'=>$result->club_type_id,
                                        'login' =>true);
                                $this->session->set_userdata('logged_in_user', $session_array);*/
                                exit(json_encode(array('status'=>true)));
                            }else{
                                exit(json_encode(array('status'=>false)));
                            }
                        }else{
                            exit(json_encode(array('status'=>false, 'reason'=>'Password and Confirm should be same')));
                        }
                    }else{
                        exit(json_encode(array('status'=>false, 'reason'=>'Password already exist')));
                    }
                /*}else{
                    exit(json_encode(array('status'=>false, 'reason'=>'Email already exist')));
                }*/
            } else
            {
                exit(json_encode(array('status'=>false, 'reason'=>validation_errors())));
            }
        } else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'No direct script access allowed')));
        }  
    }
}


?>
