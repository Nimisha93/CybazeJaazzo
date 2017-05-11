ds<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 */

Class Product extends CI_Controller
{

    function __Construct(){

        parent:: __construct();
        $this->load->library(array('session','form_validation'));
        $this->load->model(array('admin/Product_model','admin/Channelpartner_model','admin/Profile_model'));
        $this->load->helper(array('url','form','my_common_helper'));
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array)){
            redirect('admin/Login');
        }
    }

    function set_menu(){
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/cp_sidebar', '', true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        return $data;
    }

    function set_admin_menu(){
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        return $data;
    }
    function new_product(){
        $data=$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
       
        $data['user']=$this->Profile_model->get_all_partnertype($userid);
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        if($loginsession['type'] == 'super_admin'){
             $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar',$data, true);
        }else if($loginsession['type'] == 'Channel_partner'){
             $data['sidebar'] = $this->load->view('admin/templates/cp_sidebar',$data, true);
        }
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['product_cate']=$this->Product_model->get_category();
         $this->Channelpartner_model->get_cp_promotion_count();
        $this->load->view('admin/edit_add_product',$data);
    }

    function new_product_add(){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("pro_category", "Channel Partner Type ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_name", "Product", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_description", "description ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_quantity", "Quantity", "numeric|trim|required|htmlspecialchars|greater_than[0]");
            $this->form_validation->set_rules("pro_model", "Product Model", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_actualcost", "Actual Cost", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_cost", "Cost", "numeric|trim|required|htmlspecialchars");

            if($this->form_validation->run()== TRUE){
                $config['upload_path']   = './assets/admin/products';
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
                    $uploading_file = $this->upload->data();
                    $image_file = $uploading_file['file_name'];
                    $result = $this->Product_model->add_new_product($image_file);

                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{

                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                    }
                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
    }

    function get_product(){
        $data=$this->set_menu();
         $loginsession = $this->session->userdata('logged_in_admin');
         $userid=$loginsession['user_id'];
         $lgid=$loginsession['id'];
         $data['user']=$this->Profile_model->get_all_partnertype($userid);
         $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/cp_sidebar',$data, true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['products']=$this->Product_model->get_all_product();
        $this->load->view('admin/edit_view_product',$data);
    }

    function get_product_byid($id){
        $data=$this->set_menu();
        $data['product_cate']=$this->Product_model->get_category();
        $data['products']=$this->Product_model->get_product_byid($id);
        $this->load->view('admin/edit_product_edit',$data);
    }

    function edit_product_byid($id){
        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("pro_category", "Channel Partner Type ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_name", "Product", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_description", "description ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_quantity", "Quantity", "numeric|trim|required|htmlspecialchars|greater_than[0]");
            $this->form_validation->set_rules("pro_model", "Product Model", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_actualcost", "Actual Cost", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_cost", "Cost", "numeric|trim|required|htmlspecialchars");

            if($this->form_validation->run()== TRUE){





                $data['products']=$this->Product_model->get_product_byid($id);

                if(isset($_FILES['pro_image']['name']))
                {

                    $config['upload_path']   = './assets/admin/products';
                    $config['allowed_types'] = 'gif|jpg|png|flv|f4v';
                    $config['max_size']      = 2048;
                    $config['max_width']     = 2048;
                    $config['max_height']    = 2048;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if(!$this->upload->do_upload('pro_image'))
                    {
                        exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));

                    }
                    else
                    {
                        $uploading_file = $this->upload->data();
                        $image_file = $uploading_file['file_name'];
                        $this->upload->do_upload($image_file);
                        unlink("assets/admin/products/".$data['products']['produ']['image']);

                    }
                }
                else{
                    $image_file=$data['products']['produ']['image'];
                }

                    $result = $this->Product_model->edit_product_byid($image_file,$id);

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




            $config['upload_path']   = './assets/admin/module ';
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

}
?>