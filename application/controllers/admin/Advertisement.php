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
        $this->load->library(array('session','form_validation'));
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


    //  function type()
    // {
    //     $data=$this->set_menu();
    //     $this->load->view('admin/add-ads-type',$data);
    // }
   
    
    // view all club members
    // function  get_all_club_members()
    // {
    //     $data=$this->set_menu();
    //     $data['club_members']= $this->Club_member_model->get_all_club_members();
    //     $this->load->view('admin/edit_view_all_club_members',$data);
    // }
    // // club member pooling  commision settings
    // function  club_member_pooling()
    // {
    //     $data=$this->set_menu();
    //     $this->load->view('edit_club_member_pooling',$data);
    // }
    // // get all club member types
    // function get_all_club_types()
    // {
    //     $data=$this->set_menu();
    //     $data['club_types']=$this->Club_member_model->get_all_club_types();
    //     $this->load->view('admin/edit_view_all_club_types',$data   );

    // }



 // add ads hridya
    public function add_ads() {



//          if($this->input->is_ajax_request()){

           
//             $this->form_validation->set_rules("title", "title", "trim|required|htmlspecialchars");
//             $this->form_validation->set_rules("type", "Type ", "trim|required|htmlspecialchars");
//             $this->form_validation->set_rules("Sort", "Sort Order", "numeric|trim|required|htmlspecialchars|greater_than[0]");
//             $this->form_validation->set_rules("dis", "Description", "trim|required|htmlspecialchars");
//             $this->form_validation->set_rules("images", "image", "trim|required|htmlspecialchars");
           
// //var_dump($this->input->post());exit;
//             if($this->form_validation->run()== TRUE){
        $data=$this->set_menu();

       $photo=date("YmDHms");
       $tmp=explode(".",$_FILES['images']['name']);
       $extension=end($tmp);
       $p=$photo.".".$extension;
       if(($extension=="jpg")||($extension=="JPG")||($extension=="png")||($extension=="PNG")||($extension=="JPEG")||($extension=="jpeg")||($extension=="gif")||($extension=="GIF"))
       {
           move_uploaded_file($_FILES['images']['tmp_name'],"upload/".$p);
       }



        
$title=$this->input->post('title');
$type=$this->input->post('type');
$sort_order=$this->input->post('sort');
$discription=$this->input->post('dis');

        $data=array('title'=>$title,'type'=>$type,'sort_order'=>$sort_order,'image'=>$p,'discription'=>$discription);
        $query=$this->Advertisement_model->ads_add($data);
        if($query){
            redirect('admin/Advertisement/');
        }


// }}

    }
     public function view_ads()
    {
 $data=$this->set_menu();
$query=$this->Advertisement_model->get_ads();

        $data['ads']=$query;



    $this->load->view('admin/edit_view_ads',$data);



    }








  function get_ads_byid($id){
        $data=$this->set_menu();
        $data['adss']=$this->Advertisement_model->get_ads_by_id($id);
       // $data['ad']=$this->Advertisement_model->get_ads_byid($id);
        $this->load->view('admin/edit_ads_edit',$data);
    }

    function edit_ads_byid($id){
        if($this->input->is_ajax_request()){

           
            $this->form_validation->set_rules("pro_name", "Product", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_type", "Type ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("pro_Sort", "Sort Order", "numeric|trim|required|htmlspecialchars|greater_than[0]");
            $this->form_validation->set_rules("pro_description", "Description", "trim|required|htmlspecialchars");
           
//var_dump($this->input->post());exit;
            if($this->form_validation->run()== TRUE){



                $data['advertisement']=$this->Advertisement_model->get_ads_by_id($id);

                if(isset($_FILES['pro_image']['name']))
                {

                    $config['upload_path']   = 'upload';
                    $config['allowed_types'] = 'gif|jpg|png|jpeg';
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
                        unlink("upload/".$data['advertisement']['image']);

                    }
                }
                else{
                    $image_file=$data['advertisement']['image'];
                }
                         $update_ad = array(
                            'title'=>$this->input->post('pro_name'),
                            'type'=>$this->input->post('pro_type'),
                            'sort_order'=>$this->input->post('pro_Sort'),
                            'image'=>$image_file,
                            'discription'=>$this->input->post('pro_description'),
                            );
                    $result = $this->Advertisement_model->update_ads_byid($update_ad,$id);

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

 function delete_advertisement($id){
        $result=$this->Advertisement_model->delete_advertisementbyid($id);
        if($result){
            exit(json_encode(array("status"=>TRUE)));
            
            exit;
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }

public function view_activity()
    {
       $data=$this->set_menu();
       $query=$this->Advertisement_model->get_activity();

        $data['activity']=$query;



          $this->load->view('admin/edit_view_activitylog',$data);



    }

    public function view_recent_activity()
    {
       $data=$this->set_menu();
       $query=$this->Advertisement_model->get_recent_activity();

        $data['activity']=$query;



          $this->load->view('admin/edit_view_activitylog',$data);



    }



}
