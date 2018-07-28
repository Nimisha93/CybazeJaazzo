<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 *
 */

Class Advertisement extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->library(array('session','form_validation','pagination'));
        $this->load->helper(array('url','form','string','my_common_helper'));
        $this->load->model('admin/Advertisement_model');
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array)){
            redirect('admin/Login');
        }
    }
    function set_menu()
    {
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '$data', true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        return $data;
    }
    // view the club member type form
    function index()
    {
        $data=$this->set_menu();
        $this->load->view('admin/edit_add_ads',$data);
    }
    function default_ads()
    {
        $data=$this->set_menu();

        $data['ads']=$this->Advertisement_model->get_default_ads();

        $this->load->view('admin/edit_add_ads_default',$data);
    }
    public function add_default_ads() 
    {
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("title", "Title", "trim|required|htmlspecialchars");
            // $this->form_validation->set_rules("dis", "Description ", "trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){


                if(!empty($_FILES['images']['name']))
                {

                    $photo=date("YmDHms");
                $tmp=explode(".",$_FILES['images']['name']);
                $extension=end($tmp);
                $p=$photo.".".$extension;
                if(($extension=="jpg")||($extension=="JPG")||($extension=="png")||($extension=="PNG")||($extension=="JPEG")||($extension=="jpeg")||($extension=="gif")||($extension=="GIF"))
                {
                   move_uploaded_file($_FILES['images']['tmp_name'],"assets/admin/module-ads/".$p);
                }
                $img = 'assets/admin/module-ads/'.$p;

                }
                else{
                  $img=''; 
                }

                
                $query=$this->Advertisement_model->ads_add_default($img);
                if($query){
                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }else{
           show_error("Unable to process the request in this way");
        }
    }
    public function add_ads() {
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("name", "Title", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("type", "Type ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("sort", "Sort Order", "numeric|trim|required|htmlspecialchars|greater_than[0]");
            if (empty($_FILES['images']['name']))
            {
              $this->form_validation->set_rules('images', 'Image', 'required');
            }
            if($this->form_validation->run()== TRUE){
                //$data=$this->set_menu();
                $photo=date("YmDHms");
                $tmp=explode(".",$_FILES['images']['name']);
                $extension=end($tmp);
                $p=$photo.".".$extension;
                if(($extension=="jpg")||($extension=="JPG")||($extension=="png")||($extension=="PNG")||($extension=="JPEG")||($extension=="jpeg")||($extension=="gif")||($extension=="GIF"))
                {
                   move_uploaded_file($_FILES['images']['tmp_name'],"upload/".$p);
                }
                $title=$this->input->post('name');
                $type=$this->input->post('type');
                $sort_order=$this->input->post('sort');
                $data=array('title'=>$title,'type'=>$type,'sort_order'=>$sort_order,'image'=>$p);
                $query=$this->Advertisement_model->ads_add($data);
                if($query){
                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }else{
           show_error("Unable to process the request in this way");
        }
    }
    public function view_ads()
    {
        if (has_priv('view_banr_adv')) {
        $data=$this->set_menu();
        $query=$this->Advertisement_model->get_ads();
        $data['ads']=$query;
        $this->load->view('admin/edit_view_ads',$data);
    }
     }
    function get_ads_byid($id){
        $data=$this->set_menu();
        $data['adss']=$this->Advertisement_model->edit_ads_byid($id);
        $this->load->view('admin/edit_ads_edit',$data);
    }
    function edit_ads_byid($id){
        if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("name", "Product", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("type", "Type ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("sort", "Priority", "numeric|trim|required|htmlspecialchars|greater_than[0]");
            if($this->form_validation->run()== TRUE){
                $data['advertisement']=$this->Advertisement_model->edit_ads_byid($id);
                if(isset($_FILES['image']['name']))
                {
                    $config['upload_path']   = 'upload';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
                    $config['max_size']      = 2048;
                    $config['max_width']     = 2048;
                    $config['max_height']    = 2048;
                    $this->load->library('upload', $config);
                    $this->upload->initialize($config);
                    if(!$this->upload->do_upload('image'))
                    {
                        exit(json_encode(array('status'=>FALSE, 'reason'=>$this->upload->display_errors())));

                    }else {
                        $uploading_file = $this->upload->data();
                        $image_file = $uploading_file['file_name'];
                        $this->upload->do_upload($image_file);
                        unlink("upload/".$data['advertisement']['image']);
                    }
                }else{
                    $image_file=$data['advertisement']['image'];
                }
                $update_ad = array(
                        'title'=>$this->input->post('name'),
                        'type'=>$this->input->post('type'),
                        'sort_order'=>$this->input->post('sort'),
                        'image'=>$image_file,

                        );
                $result = $this->Advertisement_model->update_ads_byid($update_ad,$id);

                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }else{
           show_error("Unable to process the request in this way");
        }
    }
    function delete_advertisement(){
        if($this->input->is_ajax_request())
        {
            $qry = $this->Advertisement_model->delete_advertisementbyid($this->input->post());
            if($qry)
            {
                exit(json_encode(array('status'=>TRUE)));
            }else{
                exit(json_encode(array('status'=>FALSE, 'reason'=>'Please try again later..!')));
            }
        }else{
            show_error("Unable to process the request in this way");
        }
    }
    public function view_activity()
    {
        $data=$this->set_menu();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "activity/";
        $result_count = $this->Advertisement_model->get_activities_count($param);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->Advertisement_model->get_activities($param,$per_page,$page);
        //var_dump($data["data"]);exit;
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        /*$query=$this->Advertisement_model->get_activity();
        $data['activity']=$query;*/
        $this->load->view('admin/edit_view_activitylog',$data);
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
    public function view_recent_activity()
    {
        $data=$this->set_menu();
        $query=$this->Advertisement_model->get_recent_activity();
        $data['activity']=$query;
        $this->load->view('admin/edit_view_activitylog',$data);
    }



}
