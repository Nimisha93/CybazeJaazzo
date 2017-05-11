<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
* 
*/
class Profile extends CI_Controller
{
    
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('session','form_validation'));
        $this->load->helper(array('url','form','string','my_common_helper'));
        $this->load->model('admin/Profile_model');
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array)){
            redirect('admin/Login');
        }
    }


   function set_menu(){
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/ex_sidebar',$data, true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        return $data;
    }
    
   function change_profile()

   {

                     $loginsession = $this->session->userdata('logged_in_admin');

                     $userid=$loginsession['user_id'];
                     $lgid=$loginsession['id'];

                    
                     if($loginsession['type'] == 'Channel_partner')
                       {
                         $data['user']=$this->Profile_model->get_all_partnertype($userid);
                         $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
                         $data['sidebar'] = $this->load->view('admin/templates/cp_sidebar',$data, true);
                         $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
                         

                         $this->load->view('admin/edit_profile',$data);
                       
                     }


                     else if($loginsession['type']=='super_admin')
                       {
                           $data['user']=$this->Profile_model->get_super_admin($lgid);
                             $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
                              $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar',$data, true);
                            $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
                            $this->load->view('admin/edit_admin_profile',$data);
                      }
                         
                    else if($loginsession['type']=='executive')
                      {
                          $data['user']=$this->Profile_model->get_exicutives($userid);
                       //echo json_encode($data['user']);
                        // exit();

                           $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
                           $data['sidebar'] = $this->load->view('admin/templates/ex_sidebar',$data, true);
                           $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
                           $this->load->view('admin/edit_executive_profile',$data);
                      }
               
              
      }



     function edit_admin_byid($id){



        if($this->input->is_ajax_request()){


            // $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Mobile", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email ", "trim|required|htmlspecialchars");
             
           if($this->form_validation->run()== TRUE)
           {
           


              $result = $this->Profile_model->update_admin_byid($id);
  
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




//edit channel partner



function edit_channel_byid($id){



        if($this->input->is_ajax_request()){


            $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Mobile", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone2", "Mobile2", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email ", "trim|required|htmlspecialchars");
             $this->form_validation->set_rules("address", "Address ", "trim|required|htmlspecialchars");
           if($this->form_validation->run()== TRUE)
           {
       
   $detais=$this->Profile_model->get_all_partnertype($id);

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

                    }
                    else
                    {
                        $uploading_file = $this->upload->data();
                        $image_file = $uploading_file['file_name'];
                        $this->upload->do_upload($image_file);
                        // unlink("upload/".$detais['image']);

                    }
                }
                else{
                    $image_file=$detais['image'];
                }
           

                 
                       
                   
              $result = $this->Profile_model->update_channel_byid($id,$image_file);
  
  
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
function edit_executive_byid($id){
  if($this->input->is_ajax_request()){

    $this->form_validation->set_rules("name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone", "Mobile", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("phone2", "Mobile2", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("email", "Email ", "trim|required|htmlspecialchars");
             $this->form_validation->set_rules("address", "Address ", "trim|required|htmlspecialchars");
           if($this->form_validation->run()== TRUE)
           {



$datas=$this->Profile_model->get_exicutives($id);

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

                    }
                    else
                    {
                        $uploading_file = $this->upload->data();
                        $image_file = $uploading_file['file_name'];
                        $this->upload->do_upload($image_file);
                        // unlink("upload/".$detais['image']);

                    }
                }
                else{
                    $image_file=$datas['image'];
                }
           


            $result = $this->Profile_model->update_executive_byid($id,$image_file);
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
}

?>