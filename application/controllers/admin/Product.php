<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 */

Class Product extends CI_Controller
{

    function __Construct(){

        parent:: __construct();
        $this->load->library(array('session','form_validation','pagination'));
        $this->load->model(array('admin/Product_model','admin/Channelpartner_model','admin/Profile_model'));
        $this->load->helper(array('url','form','my_common_helper'));
        $session_array1 = $this->session->userdata('logged_in_admin');
        $session_array2 = $this->session->userdata('logged_in_cp');
        if(!isset($session_array1) and !isset($session_array2)){
            redirect('admin/Login');
        }
    }

    function set_menu(){
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
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
    
    function get_product(){

        if (has_priv('view_products')) {
        
            $data=$this->set_menu();
            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $result_count = $this->Product_model->get_all_products_count($param);
            $base_url = base_url() . "all_products/";
            $count =  $result_count;
            $per_page = 10;
            $this->load_paging($base_url,$count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data['page'] = $page;
            $data["data"] = $this->Product_model->get_all_products($param,$per_page, $page);
           // echo json_encode($data["data"]);exit();
            if ($this->input->post('ajax', FALSE)) {
                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'pagination' => $this->pagination->create_links()
                )));
            }
            $this->load->view('admin/edit_view_product',$data);

       }       
    }
    function new_product(){

        if (has_priv('add_products')) 
        {
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_admin');
        $data['product_cate']=$this->Product_model->get_category();
        $data['brands']=$this->Product_model->get_brands();
        $data['channel_partner'] = $this->Product_model->get_channel_partners();
      
        $this->load->view('admin/edit_add_product',$data);
       }
     }
    function get_product_byid($id){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $data['products']=$this->Product_model->get_product_byid($id);
        $data['brands']=$this->Product_model->get_brands();
        $data['channel_partner'] = $this->Product_model->get_channel_partners();
        $data['subtype'] = $this->Product_model->get_cp_sub_types_all();
        $cp_id = $data['products']['produ']['channel_partner_id'];
        $data['type'] = $this->Channelpartner_model->get_cp_type($cp_id);
        $this->load->view('admin/edit_product_edit',$data);
    }
    function check_default($element)
    {
        if($element == '0')
        { 
          return FALSE;
        }
        return TRUE;
    }
    function new_product_add(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("channel_partner", "Channel Partner", "trim|required|htmlspecialchars|callback_check_default");
             $this->form_validation->set_rules("pro_category", "Channel Partner Type ", "trim|required|htmlspecialchars|callback_check_default");
              $this->form_validation->set_rules("sub_type", "Channel Partner Sub Type ", "trim|required|htmlspecialchars|callback_check_default");
            $this->form_validation->set_rules("pro_name", "Product", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_description", "description ", "trim|required|htmlspecialchars");
           
            $this->form_validation->set_rules("pro_actualcost", "Actual Cost", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("special_prize", "Special Price",'less_than_equal_to['.$this->input->post('pro_actualcost').']' ,"numeric|trim|required|htmlspecialchars");
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

                   // echo json_encode($images);exit();
                  
                    $result = $this->Product_model->add_new_product($images);

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




    private function set_upload_options()
    {
        //var_dump("sd");exit();
        //upload an image options
        $config = array();
        $config['upload_path']   = './assets/admin/products';
        // $config['allowed_types'] = 'gif|jpg|png|flv|f4v';
        // $config['max_size']      = 2048;
        // $config['max_width']     = 2048;
        // $config['max_height']    = 2048;
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['max_size']      = '2400';
        $config['encrypt_name'] = TRUE;
        $config['overwrite']     = FALSE;
        return $config;
    }
    function edit_product_byid($id){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("pro_category", "Channel Partner Type ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_name", "Product", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_description", "description ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_model", "Product Model", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_actualcost", "Actual Cost", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("special_prize", "Specila Price", "numeric|trim|required|htmlspecialchars");
            
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
              // var_dump($images);exit();
                    $result = $this->Product_model->edit_product_byid($images,$id);

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
    function delete_product_image($id)
    {
        $result=$this->Product_model->delete_product_image($id);
        if($result)
        {
            exit(json_encode(array("status"=>TRUE)));
        }
        else
        {
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    function get_cp_type()
    {
        $id = $this->input->post('id');
       
        $data = $this->Channelpartner_model->get_cp_type($id);
     
        if($data){
            exit(json_encode(array('status'=>true,'data'=>$data)));
        } else{
            exit(json_encode(array('status'=>false, 'reason'=>'invalid selection')));
        }
    }

    function get_cp_sub_types()
    {
        $id = $this->input->post('id');
        $data = $this->Channelpartner_model->get_cp_sub_types($id);
        if($data)
        {
            exit(json_encode(array('status' => TRUE, 'data'=> $data)));
        } else{
            exit(json_encode(array('status' => FALSE, 'reason'=> 'No Data Found')));
        }
    }
    function add_module_ads(){
        $data=$this->set_menu();
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
            if ( ! $this->upload->do_upload('ad_image'))
            {
                exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
            }else{
                $id=$this->input->post('ad_type');
                $uploading_file = $this->upload->data();
                $image_file = 'assets/admin/module-ads/'.$uploading_file['file_name'];
                $result = $this->Product_model->add_new_module_ads($image_file,$id);
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }
        }else{
            show_error("Unable to process the request in this way");
        }
    }

    function view_module_ads(){
        if (has_priv('view_servce_adv')) {
        $data=$this->set_menu();
        $data['ads']=$this->Product_model->get_ads();
       // echo  json_encode($data['ads']);exit;
        $this->load->view('admin/edit_view_ads_module',$data);
         }
    }

    function view_module_ads_by_id($id){
        $data=$this->set_admin_menu();
        $data['select']=$this->Product_model->get_select();
        $data['adss']=$this->Product_model->view_module_ads_by_id($id);
        $this->load->view('admin/edit_module_ads_edit',$data);
    }
    function edit_ads_byid($id){
        if($this->input->is_ajax_request()){
            $data['advertisement']=$this->Product_model->get_ads_by_id($id);

            if(isset($_FILES['ad_image']['name']))
            {

                $config['upload_path']   = './assets/admin/module-ads';
                $config['allowed_types'] = 'gif|jpg|png|jpeg';
                $config['max_size']      = 2048;
                $config['max_width']     = 2048;
                $config['max_height']    = 2048;
                $this->load->library('upload', $config);
                $this->upload->initialize($config);
                if(!$this->upload->do_upload('ad_image'))
                {
                    exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));

                }
                else
                {
                    $uploading_file = $this->upload->data();
                    $image_file = $uploading_file['file_name'];
                    $this->upload->do_upload($image_file);
                    //unlink($data['advertisement']['module_image']);
                    $image_file = 'assets/admin/module-ads/'.$uploading_file['file_name'];
                }
            }else{
                $image_file=$data['advertisement']['module_image'];
            }
            $update_ad = array(
                'module_image'=>$image_file,
            );
            $result = $this->Product_model->update_ads_byid($update_ad,$id);
            if($result)
            {
                exit(json_encode(array("status"=>TRUE)));
            }else
            {
                exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
            }
        }
    }
    function get_ads_byid($id){
        $data=$this->set_menu();
        $data['adss']=$this->Product_model->get_ads_by_id($id);
        // $data['ad']=$this->Advertisement_model->get_ads_byid($id);
        $this->load->view('admin/edit_model_ad_edit',$data);
    }
    function delete_productbyid(){
        $result=$this->Product_model->delete_productbyid($this->input->post());
        if($result){
            exit(json_encode(array("status"=>TRUE)));     
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    function delete_module_ads(){
        if($this->input->is_ajax_request())
        {
            $qry = $this->Product_model->delete_module_ads_by_id($this->input->post());
            if($qry)
            {
                exit(json_encode(array('status'=>TRUE)));
            }else{
                exit(json_encode(array('status'=>FALSE, 'reason'=>'Database Error')));
            }
        }else{
            show_error("Unable to process the request in this way");
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
//                $config['upload_path']   = './uploads/category';
//                $config['allowed_types'] = 'gif|jpg|JPG|jpeg|JPEG|png|PNG|flv|f4v';
//                $config['max_size']      = 2048;
//                $config['max_width']     = 2048;
//                $config['max_height']    = 2048;
//                $this->load->library('upload', $config);
//                $this->upload->initialize($config);
//                if ( ! $this->upload->do_upload('userfile'))
//                {
//                    exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));
//
//                }
//                else
//                {
//                    $uploading_file = $this->upload->data();
//                    $image_file = $uploading_file['file_name'];
//                    $result = $this->Product_model->add_category($image_file);
//
//                    if($result){
//                        exit(json_encode(array("status"=>TRUE)));
//                    }
//                    else{
//
//                        exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
//                    }
//         else{
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



    // function brands()
    // {
    //     $data=$this->set_admin_menu();
    //     $data['brands'] = $this->Product_model->get_all_brand();
    //     $this->load->view('admin/edit_list_brands',$data);
    // }


      function brands(){


      if (has_priv('view_brands')) {
        $data=$this->set_menu();
        // $data['designations']=$this->Home_model->get_desigsviewall();
        //$data['executives']=$this->Executives_model->get_executives();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $config = array();
        $config["base_url"] = base_url() . "view_brands/";
        $result_count = $this->Product_model->get_all_brand_count($param);
        $config["total_rows"] =  $result_count;
        $config["per_page"] = 10;
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


        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data['page'] = $page;

        $data["data"] = $this->Product_model->get_all_brand($param,$config["per_page"], $page);
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
      // echo json_encode($data['page']);exit();
        $this->load->view('admin/edit_list_brands',$data);
        }
    }


function add_brand()
{
if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("brand","Brand Name","trim|required");
            if($this->form_validation->run()== TRUE)
            {
                //var_dump($this->input->post('sd'));exit;
                $qry = $this->Product_model->add_brand();
                if($qry)
                {
                    exit(json_encode(array('status'=>TRUE,'result'=>'add')));
                }else{
                    exit(json_encode(array('status'=>FALSE, 'reason'=>'Database Error..!')));
                }
            }else{
                exit(json_encode(array('status'=>FALSE,'reason'=>validation_errors())));
            }
        }else{
            show_error("Unable To Process The Request In This Way");
        }

}

function update_brand($id)
{
if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("brand","Brand Name","trim|required");
            if($this->form_validation->run()== TRUE)
            {
                //var_dump($this->input->post('sd'));exit;
                $qry = $this->Product_model->update_brand($id);
                if($qry)
                {
                    exit(json_encode(array('status'=>TRUE,'result'=>'update')));
                }else{
                    exit(json_encode(array('status'=>FALSE, 'reason'=>'Database Error..!')));
                }
            }else{
                exit(json_encode(array('status'=>FALSE,'reason'=>validation_errors())));
            }
        }else{
            show_error("Unable To Process The Request In This Way");
        }
}

function delete_brand()
{
    if($this->input->is_ajax_request())
        {
                $qry = $this->Product_model->delete_brand($this->input->post());
                if($qry)
                {
                    exit(json_encode(array('status'=>TRUE)));
                }else{
                    exit(json_encode(array('status'=>FALSE, 'reason'=>'Database Error..!')));
                }
        }else{
            show_error("Unable To Process The Request In This Way");
        }
}



}
?>