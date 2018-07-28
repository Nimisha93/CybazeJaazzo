<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 */

Class Deal extends CI_Controller
{

    function __Construct(){

        parent:: __construct();
        $this->load->library(array('session','form_validation','pagination'));
        $this->load->model(array('admin/Product_model','admin/Channelpartner_model','admin/Deal_model','admin/Profile_model'));
        $this->load->helper(array('url','form','my_common_helper','query_builder_helper'));
        $session_array = $this->session->userdata('logged_in_cp');
        if(!isset($session_array) ){
            redirect('admin/Login');
        }
    }

    function set_menu(){
        $data['header'] = $this->load->view('channel_partner/templates/header', '', true);
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        $data['notification'] = get_new_purchase_count();
        $data['user']=$this->Profile_model->get_all_partnertype($userid);
        $data['commission_settings']=$this->Channelpartner_model->get_cp_commission_status($userid);
        $data['sidebar'] = $this->load->view('channel_partner/templates/sidebar',$data, true);
        $data['footer'] = $this->load->view('channel_partner/templates/footer', '', true);
        return $data;
    }


           public function load_paging($base_url,$count,$per_page)
    {
        $config = array();
        $config["base_url"] = $base_url;
        $config["total_rows"] =  $count;
        $config["per_page"] = $per_page;
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
    }

    function notification(){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        $data['notification']=$this->Channelpartner_model->get_all_purchasenotification($userid);
        $sel = random_select("p.is_del = 0 and p.status = 'joined' and p.id='$userid'","p.is_active","gp_pl_channel_partner p ","row");
        $data['status'] = $sel->is_active;




if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "view_deal/";
        $result_count = $this->Channelpartner_model->get_all_purchasenotification_count($param,$userid);


        $per_page = 10;

    $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Channelpartner_model->get_all_purchasenotification_page($param,$per_page,$page,$userid);
       // echo "vb b";exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }
    $this->load->view('channel_partner/transaction',$data);
    }
    
    function new_deal(){
        $data=$this->set_menu();
        
        $data['deal_info'] = $this->Channelpartner_model->get_deal_info();
        $this->load->view('channel_partner/new_deal',$data);
    }
    function view_purchased_deal(){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $on = "d.id = c.deal_id";
        $tbl = 'gp_deal_settings d';
        $tbl2 = 'gp_deal_channel_partner_con c';
        $where = "c.channel_partner_id = '$userid' and c.product_id = '0' and c.status = '0' and c.is_paid = '1'";
        $data['deal']=select_all_by_id_result($tbl,$where,$tbl2,$on);
       // update_tbl($tbl,$data,$where);
        $this->load->view('channel_partner/edit_list_purchased_deals',$data);
       
    }
    function coupon()
    {       
        $data=$this->set_menu();
        $data['coupon'] = $this->Deal_model->get_coupon();
        $this->load->view('channel_partner/edit_view_coupon',$data);
    }
    
    
    
    
    function add_new_deal_settings(){
        if($this->input->is_ajax_request()){
            $amount = $this->input->post('amount');
            if(!empty($amount)){
               $this->form_validation->set_rules("payment_mode", "Payment Mode", "trim|required|htmlspecialchars");
                if($this->input->post('payment_mode')=='cheque'){
                    $this->form_validation->set_rules("cheque_number", "Cheque Number", "trim|required|htmlspecialchars");
                    $this->form_validation->set_rules("bank", "Bank", "trim|required|htmlspecialchars");
                    $this->form_validation->set_rules("cheque_date", "Cheque Date", "trim|required|htmlspecialchars");
                } 
                if($this->form_validation->run()== TRUE){
                    $result = $this->Deal_model->add_new_deal_settings();

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
            }else{
                $result = $this->Deal_model->add_new_deal_settings();

                    if($result){
                        exit(json_encode(array("status"=>TRUE)));
                    }
                    else{

                        exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                    }
            }         
    }else{
        exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
    }
}
    function add_deal($id,$duration){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['product_cate']=$this->Product_model->get_category();
        $data['cp'] = $this->Channelpartner_model->get_cp_type($userid);
        $data['brands']=$this->Product_model->get_brands();
        $data['deal_id'] = $id;
        $data['duration'] = $duration;   
        $this->load->view('channel_partner/edit_add_deal',$data);
    }
    function new_deal_settings(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("pro_name", "Product", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_description", "description ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("amount", "Amount", "numeric|trim|required|htmlspecialchars|greater_than[0]");


            if($this->form_validation->run()== TRUE){


                $result = $this->Deal_model->update_deal_settings();

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
    }
    function more_deal(){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['user']=$this->Profile_model->get_all_partnertype($userid);
        $data['product_cate']=$this->Product_model->get_category();
        $this->Channelpartner_model->get_cp_promotion_count();
        $data['cp'] = $this->Channelpartner_model->get_cp_type($userid);
        $data['deal_status'] = $this->Channelpartner_model->get_deal_status($userid);
        $data['deal_info'] = $this->Channelpartner_model->get_deal_info();
        $this->load->view('channel_partner/new_deal',$data);

    }

    function get_deal_byid($id){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_cp');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['product_cate']=$this->Channelpartner_model->get_cp_type($userid);
        $data['brands']=$this->Product_model->get_brands();
        $data['products']=$this->Deal_model->get_deal_byid($id);
        $this->load->view('channel_partner/edit_deal_edit',$data);
    }
    function check_default($element)
    {
        if($element == '0')
        { 
          return FALSE;
        }
        return TRUE;
    }
     function new_deal_add(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("pro_category", "Channel Partner Type ", "trim|required|htmlspecialchars|callback_check_default");
            $this->form_validation->set_rules("pro_name", "Deal Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_description", "description ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_quantity", "Quantity", "numeric|trim|required|htmlspecialchars|greater_than[0]");
            $this->form_validation->set_rules("pro_model", "Product Model", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_actualcost", "Actual Cost", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("special_prize", "Special Prize", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("coupon", "Coupon %", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("sub_type", "Channel Partner Sub Type ", "trim|required|htmlspecialchars|callback_check_default");
            $this->form_validation->set_rules("brand", "Brand Name", "trim|required|htmlspecialchars|callback_check_default");
            $this->form_validation->set_message('check_default', 'You need to select something other than the default values');

             if (empty($_FILES['userfile']['name']))
            {
                $this->form_validation->set_rules('userfile', 'Image', 'required');
            }
            if($this->form_validation->run()== TRUE){

                $files = $_FILES;
              $count = count($_FILES['userfile']['name']);
                // if($count>1){
                    for($i=0; $i<$count; $i++)
                    {
                        $_FILES['userfile']['name']= time().$files['userfile']['name'][$i];
                        $_FILES['userfile']['type']= $files['userfile']['type'][$i];
                        $_FILES['userfile']['tmp_name']= $files['userfile']['tmp_name'][$i];
                        $_FILES['userfile']['error']= $files['userfile']['error'][$i];
                        $_FILES['userfile']['size']= $files['userfile']['size'][$i];
                        $config['upload_path'] =  './assets/admin/products';
                        $config['allowed_types'] = 'gif|jpg|png|jpeg';
                        $config['max_size'] = '2000000';
                        $config['remove_spaces'] = true;
                        $config['overwrite'] = false;
                        $config['max_width'] = '';
                        $config['max_height'] = '';
                        $this->load->library('upload', $config);
                        $this->upload->initialize($config);
                        $this->upload->do_upload();
                        
                        $image_data = $this->upload->data();
                        $fileName = $image_data['raw_name'].$image_data['file_ext'];
                        $images[] = $fileName;

                    }
                  
                    $result = $this->Deal_model->add_new_deal($images);

                    if($result){
                        exit(json_encode(array("status"=>TRUE)));
                    }
                    else{

                        exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                    }
                // }else{
                //     exit(json_encode(array("status"=>FALSE,"reason"=>"You have to choose multiple images")));
                // }            
            }
           
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
    }

    function get_deal(){


         $data=$this->set_menu();
         $loginsession = $this->session->userdata('logged_in_cp');
         $userid=$loginsession['user_id'];
         $data['products']=$this->Deal_model->get_all_deal_by_cp_id($userid);





if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "view_deal/";
        $result_count = $this->Deal_model->get_all_deal_by_cp_id_count($param,$userid);


        $per_page = 10;




 $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Deal_model->get_all_deal_by_cp_id_page($param,$per_page,$page,$userid);
       // echo "vb b";exit();
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }









         $this->load->view('channel_partner/edit_view_deal_product',$data); 
    }

    

function edit_deal_byid($id){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("pro_category", "Channel Partner Type ", "trim|required|htmlspecialchars|callback_check_default");
            $this->form_validation->set_rules("pro_name", "Deal Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_description", "description ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_quantity", "Quantity", "numeric|trim|required|htmlspecialchars|greater_than[0]");
            $this->form_validation->set_rules("pro_model", "Product Model", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_actualcost", "Actual Cost", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("special_prize", "Special Prize", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("coupon", "Coupon %", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("sub_type", "Channel Partner Sub Type ", "trim|required|htmlspecialchars|callback_check_default");
            $this->form_validation->set_rules("brand", "Brand Name", "trim|required|htmlspecialchars|callback_check_default");
            $this->form_validation->set_message('check_default', 'You need to select something other than the default values');
            if($this->form_validation->run()== TRUE){

                $data['products']=$this->Product_model->get_product_byid($id);
                $this->load->library('upload');
                if(isset($_FILES['pro_image']['name']))
                {
                     $files = $_FILES;
                     $cpt = count($_FILES['pro_image']['name']);
                     for($i=0; $i<$cpt; $i++)
                        {
                            
                            $_FILES['pro_image']['name']= time().$files['pro_image']['name'][$i];
                            $_FILES['pro_image']['type']= $files['pro_image']['type'][$i];
                            $_FILES['pro_image']['tmp_name']= $files['pro_image']['tmp_name'][$i];
                            $_FILES['pro_image']['error']= $files['pro_image']['error'][$i];
                            $_FILES['pro_image']['size']= $files['pro_image']['size'][$i];
                            $config['upload_path'] =  './assets/admin/products';
                            $config['allowed_types'] = 'gif|jpg|png|jpeg';
                            $config['max_size'] = '2000000';
                            $config['remove_spaces'] = true;
                            $config['overwrite'] = false;
                            $config['max_width'] = '';
                            $config['max_height'] = '';
                            $this->load->library('upload', $config);
                            $this->upload->initialize($config);
                            //$this->upload->display_errors()
                            $upload_img = $this->upload->do_upload('pro_image');
                            if(!$upload_img){
                                    exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
                                }
                            else
                            {
                                $uploading_file = $this->upload->data();
                                $image_file = $uploading_file['file_name'];
                                $images[] = $image_file;
                            }
                        }    
                }
                else{
                    $images[] = array('0' =>"Empty");
                }
                //var_dump($images);exit();
                    $result = $this->Deal_model->edit_deal_byid($images,$id);

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
    }


    function add_module_ads(){
        $data=$this->set_admin_menu();
        $data['select']=$this->Product_model->get_select();
        $this->load->view('admin/edit_add_module_ads',$data);
    }
    function new_module_ads(){
        if($this->input->is_ajax_request()){

            $config['upload_path']   = './assets/admin/module-ads';
            $config['allowed_types'] = 'gif|jpg|JPG|jpeg|JPEG|png|PNG|flv|f4v';
            $config['max_size']      = 2048;
            $config['max_width']     = 2048;
            $config['max_height']    = 2048;
            $this->load->library('upload', $config);
            $this->upload->initialize($config);
            if ( ! $this->upload->do_upload('pro_image'))
            {
                exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));

            }
            else
            {
                $id=$this->input->post('add_type');
                $uploading_file = $this->upload->data();
                $image_file = $uploading_file['file_name'];
                $result = $this->Product_model->add_new_module_ads($image_file,$id);




                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{

                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }


        }
    }


    function view_module_ads(){
        $data=$this->set_admin_menu();
        $data['ads']=$this->Product_model->get_ads();

        $this->load->view('admin/edit_view_ads_module',$data);
    }


    function view_module_ads_by_id($id){
        $data=$this->set_admin_menu();
        $data['select']=$this->Product_model->get_select();
        $data['adss']=$this->Product_model->view_module_ads_by_id($id);



        $this->load->view('admin/edit_module_ads_edit',$data);
    }



    function delete_dealbyid($id){
        $result=$this->Deal_model->delete_dealbyid($id);
        if($result){
            exit(json_encode(array("status"=>TRUE)));

            exit;
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    function delete_module_ads($id){
        $result=$this->Product_model->delete_module_ads_by_id($id);
        if($result){
            exit(json_encode(array("status"=>TRUE)));

            exit;
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }

    function category_type(){
        $data=$this->set_admin_menu();
        $data['category']=$this->Product_model->get_cpcategory();
        $this->load->view('admin/edit_add_category',$data);
    }
    function new_category(){

        if($this->input->is_ajax_request())
        {

            //echo json_encode($this->input->post());
            $this->form_validation->set_rules("category", "Category", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("title", "Title", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("description", "Description", "trim|required|htmlspecialchars");



            if($this->form_validation->run()== TRUE){

                $result=$this->Product_model->add_category();
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }

                exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
            }



        }
        else
        {
            exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
        }
    }
    function view_category(){
        $data=$this->set_admin_menu();
        $data['category']=$this->Product_model->get_cpcategory();
        $data['subcategory']=$this->Product_model->get_cpscategory();
        $this->load->view('admin/edit_view_category',$data);
    }
   
    function delete_category()
    {
        $result=$this->Product_model->delete_categoryypebyid();

        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }

}
?>