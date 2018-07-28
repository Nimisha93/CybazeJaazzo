<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 */

Class Pooling extends CI_Controller
{

    function __Construct(){

        parent:: __construct();
        $this->load->library(array('session','form_validation','pagination'));
        $this->load->model(array('admin/Pooling_model','admin/Channelpartner_model', 'admin/privillage_model','admin/Profile_model','admin/Executives_model'));
        $this->load->helper(array('url','form','my_common_helper'));
        $session_array = $this->session->userdata('logged_in_admin');

        if(!isset($session_array)){
            redirect('admin/Login');
        }
    }

    function set_menu(){
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $loginsession = $this->session->userdata('logged_in_admin');
        //var_dump($loginsession);exit;
        if($loginsession['type'] == 'super_admin'){
             $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        }
        else if($loginsession['type'] == 'Employee'){
             $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        }
        else{
             $data['sidebar'] = $this->load->view('admin/templates/cp_sidebar', '', true);
        }
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        return $data;
    }
    
    //add new designation  form
    function new_designation()
    {
if (has_priv('add_designation')) {

        $data =$this->set_menu();
        $data['group']=$this->privillage_model->get_groupname();
        // $data['designation']=$this->Pooling_model->get_all_desiginations();
        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $config = array();
        $config["base_url"] = base_url() . "all_club_members/";
        $result_count = $this->Pooling_model->get_all_desiginations_count($param);
        $config["total_rows"] =  $result_count;
        $config["per_page"] = 5;
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

        $data["data"] = $this->Pooling_model->get_all_desiginations($param,$config["per_page"], $page);
        
        if ($this->input->post('ajax', FALSE)) {

            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => 1,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('admin/edit_add_designation',$data);
    }
    }
    //add new designation
    function  add_designation()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("designation", "Designation ", "trim|required|htmlspecialchars");

            $this->form_validation->set_rules("sortorder", "Sort order", "numeric|trim|required|htmlspecialchars");
            
            if($this->form_validation->run()== TRUE){
                $result=$this->Pooling_model->add_designation();           
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
    }
    //update designation
    function  update_designation($id)
    {
        if($this->input->is_ajax_request())
        {
            
            $this->form_validation->set_rules("designation", "Designation ", "trim|required|htmlspecialchars");
           
            $this->form_validation->set_rules("sortorder", "Sort order", "numeric|trim|required|htmlspecialchars");

            if($this->form_validation->run()== TRUE){
                $designation = $this->input->post('designation');
                $type = $this->input->post('type');
                $decription = $this->input->post('description');
                $Sortorder = $this->input->post('sortorder');
                $priv_group = $this->input->post('priv_group');
                $bde_count=$this->input->post('bde_count');
                $add=$this->input->post('add_exec1');

                if($add !='' ){
                $add1 ='1';
                }
                else{                
                    $add1='0';
                }
                if($bde_count!=''){
                    $bde =$bde_count;
                }
                else{
                    $bde ='0';
                }
                $data2 = array( 
                    'designation' => $designation,
                    'type' => $type,
                    'description' => $decription,
                    'sort_order' => $Sortorder+3,
                    'add_exec'=>$add1,
                    'type'=>'executive',
                    //'group_id' => $priv_group,
                    'bde_count'=>$bde
                );
               
                $result=$this->Pooling_model->update_designation($data2,$id);
              
                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
    }
    //delete designation
    function delete_designaton()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->Pooling_model->delete_designaton($this->input->post());
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
    // pooling add form
    function new_pool_landing()
    {

        if (has_priv('new_pool')) {
        $data = $this->set_menu();
        $data['designations']= get_all_desigination();
        $data['stages']= $this->Pooling_model->get_all_stages();
        $data['total_persantage']=$this->Pooling_model->get_total_pool_persantage();
        $this->load->view('admin/edit_pool_landing',$data);
    }
     }
    //add  pool settings
    function add_new_pool_data()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("pool_name", "Pool Group Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("allow_persantage", "Group Allow percentage", "trim|required|htmlspecialchars|numeric");
            $this->form_validation->set_rules("no_of_levels", "No of Levels ", "trim|required|htmlspecialchars|numeric");
            if($this->form_validation->run()== TRUE){
                $result=$this->Pooling_model->add_new_pool_data();
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }
            } else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        } else{
            show_error("We are unable to process this request on this way!");
        }
    }
    //view edit pool  data form
    function  view_pool_settings()
    {
        if (has_priv('view_pool')) {
            $data =$this->set_menu();
            $data['poolings']= $this->Pooling_model->get_all_pooings();
            $this->load->view('admin/edit_view_pool_settings',$data);
        }
     }
    //delete  pool settings
    function delete_pool_settings($id)
    {
        if(has_priv('delete_pool')){
            $result=$this->Pooling_model->delete_pool_settings($id);
            if($result)
            {
                exit(json_encode(array("status"=>TRUE)));
            } else{
                exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
            }
        }
    }
    //view pool members
    function view_pool_members($id)
    {
        if (has_priv('view_pool')||has_priv('update_pool')) {
            $data =$this->set_menu();
            $data['total_persantage']=$this->Pooling_model->get_total_pool_persantage();
            $data['id']=$id;
            $data['pooling_details']= $this->Pooling_model->get_all_members_by_id($id);
            $data['designations']= get_all_desigination();
            // echo json_encode($data['pooling_details']);exit;
            $this->load->view('admin/edit_view_full_pool_setting',$data);
        }
    }
    function delete_pooling_member($id)
    {
        $result=$this->Pooling_model->delete_pooling_member($id);
        if($result)
        {
            exit(json_encode(array("status"=>TRUE)));
        }
        else
        {
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    //update pooling data
    function  update_pool_data()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("pool_name", "Pool Group Name", "trim|required|htmlspecialchars");
            $new_designation_persantage = $this->input->post('new_designation_persantage');
            $this->form_validation->set_rules("allow_persantage", "Group Allow Percentage", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("no_of_levels", "No of Levels ", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("design_allwed_persantage[]", "Designation allowed percentage  ", "numeric|trim|required|htmlspecialchars|callback_percentagecheck1[new_designation_persantage]");
        
            if($this->form_validation->run()==TRUE)
            {
                $result=$this->Pooling_model->update_pool_data();
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }
                else
                {
                    exit(json_encode(array("status"=>FALSE)));
                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
    }
    public function percentagecheck1($str,$str1)
    {
        $percentage =$this->input->post('design_allwed_persantage');
        $percentage1 =$this->input->post('new_designation_persantage');
        $sum = 0;
        foreach ($percentage as $key => $value) {
            $sum = $value + $sum;
        }
        if (!empty($percentage1))
        {
            foreach ($percentage1 as $key => $value) {
                $sum = $value + $sum;
            } 
        }
        if ($sum=="100")
        {
            return TRUE;
        }
        else
        {
            $this->form_validation->set_message('percentagecheck1', 'Sum of Designation allowed percentage should be hundred');
            return FALSE;
        }
    }
    function new_commision(){
        $data =$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['user']=$this->Profile_model->get_all_partnertype($userid);
        $data['partner_type']=$this->Pooling_model->get_partner_type();
        $this->load->view('admin/edit_add_commmission',$data);
    }
    function set_commission(){

if (has_priv('add_commision')) { 

        $data =$this->set_menu();
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['user']=$this->Profile_model->get_all_partnertype($userid);
        $data['commission'] = $this->Pooling_model->get_commission();   
        $this->load->view('admin/edit_add_set_commmission',$data);

     }   
    }
    function set_new_commission(){

        if($this->input->is_ajax_request()){
          
          $this->form_validation->set_rules("company_commission", "Company Commission ", "trim|required|htmlspecialchars");
          $this->form_validation->set_rules("customer_commission", "Customer Commission ", "trim|required|htmlspecialchars");
           
            if($this->form_validation->run()== TRUE){  

            $result = $this->Pooling_model->set_new_commission();
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
    function update_commission(){

        if($this->input->is_ajax_request()){
          
          $this->form_validation->set_rules("company_commission", "Company Commission ", "trim|required|htmlspecialchars");
          $this->form_validation->set_rules("customer_commission", "Customer Commission ", "trim|required|htmlspecialchars");
           
            if($this->form_validation->run()== TRUE){  

            $result = $this->Pooling_model->update_commission();
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
    /*// system Ba pooling add form
    function new_ba_pool_landing()
    {

        $data['default_assets']=$this->load->view('admin/templates/default_assets','',true);
        $data['sidebar']=$this->load->view('admin/templates/admin_sidebar','',true);
        $data['footer']=$this->load->view('admin/templates/admin_footer','',true);
        $data['designations']= get_all_desigination();
        $data['total_group_persantage']=$this->Pooling_model->get_total_ba_group_persantage();
//        $data['bal_group_persantage']=100-$data['total_group_persantage'];
        //echo json_encode($data['total_group_persantage']);
        if($data['total_group_persantage']['total_persantage']==100)
        {
            $data['pesantage_limit']='over_flow';

            $this->load->view('admin/edit_ba_system_pool_landing',$data);
        }
        else
        {
            $data['pesantage_limit']='succes';
            $this->load->view('admin/edit_ba_system_pool_landing',$data);
//            $this->load->view('admin/edit_add_system_pool',$data);
        }


    }
    // system Bch pooling add form
    function new_bch_pool_landing()
    {
        $data['default_assets']=$this->load->view('admin/templates/default_assets','',true);
        $data['sidebar']=$this->load->view('admin/templates/admin_sidebar','',true);
        $data['footer']=$this->load->view('admin/templates/admin_footer','',true);
        $data['designations']= get_all_desigination();
        $data['total_group_persantage']=$this->Pooling_model->get_total_bch_group_persantage();
        // $data['bal_group_persantage']=100-$data['total_group_persantage'];
        // echo json_encode($data['total_group_persantage']);
        if($data['total_group_persantage']['total_persantage']==100)
        {
            $data['pesantage_limit']='over_flow';

            $this->load->view('admin/edit_bch_system_pool_landing',$data);
        }
        else
        {
            $data['pesantage_limit']='succes';
            $this->load->view('admin/edit_bch_system_pool_landing',$data);
            // $this->load->view('admin/edit_add_system_pool',$data);
        }


    }
    //add new group  pool form
    function new_pool()
    {
        $data = $this->set_menu();
        $data['designations']= get_all_desigination();
        $data['total_group_persantage']=$this->Pooling_model->get_total_group_persantage();
        // $data['bal_group_persantage']=100-$data['total_group_persantage'];
        // echo json_encode($data['total_group_persantage']);
        if($data['total_group_persantage']['total_persantage']==100)
        {
            $data['pesantage_limit']='over_flow';

            $this->load->view('admin/edit_add_system_pool',$data);
        }
        else
        {
            $data['pesantage_limit']='succes';
            // $this->load->view('admin/edit_system_pool_landing',$data);
            $this->load->view('admin/edit_add_system_pool',$data);
        }


    }
    // add new ba pool
    function  new_ba_pool()
    {
        $data['default_assets']=$this->load->view('admin/templates/default_assets','',true);
        $data['sidebar']=$this->load->view('admin/templates/admin_sidebar','',true);
        $data['footer']=$this->load->view('admin/templates/admin_footer','',true);
        $data['designations']= get_all_desigination();
        $data['total_group_persantage']=$this->Pooling_model->get_total_ba_group_persantage();
        // $data['bal_group_persantage']=100-$data['total_group_persantage'];
        // echo json_encode($data['total_group_persantage']);
        if($data['total_group_persantage']['total_persantage']==100)
        {
            $data['pesantage_limit']='over_flow';

            $this->load->view('admin/edit_add_ba_system_pool',$data);
        }
        else
        {
            $data['pesantage_limit']='succes';
            // $this->load->view('admin/edit_system_pool_landing',$data);
            $this->load->view('admin/edit_add_ba_system_pool',$data);
        }
    }
    // add new bch pool
    function  new_bch_pool()
    {
        $data['default_assets']=$this->load->view('admin/templates/default_assets','',true);
        $data['sidebar']=$this->load->view('admin/templates/admin_sidebar','',true);
        $data['footer']=$this->load->view('admin/templates/admin_footer','',true);
        $data['designations']= get_all_desigination();
        $data['total_group_persantage']=$this->Pooling_model->get_total_bch_group_persantage();
//        $data['bal_group_new_stage_pool$data['total_group_persantage']);
        if($data['total_group_persantage']['total_persantage']==100)
        {
            $data['pesantage_limit']='over_flow';

            $this->load->view('admin/edit_add_bch_system_pool',$data);
        }
        else
        {
            $data['pesantage_limit']='succes';
            // $this->load->view('admin/edit_system_pool_landing',$data);
            $this->load->view('admin/edit_add_bch_system_pool',$data);
        }
    }
    //add new stage  pool form
    function new_stage_pool()
    {
        $data['default_assets']=$this->load->view('admin/templates/default_assets','',true);
        $data['sidebar']=$this->load->view('admin/templates/admin_sidebar','',true);
        $data['footer']=$this->load->view('admin/templates/admin_footer','',true);
        $data['stages']= $this->Pooling_model->get_all_stages();
        $data['total_group_persantage']=$this->Pooling_model->get_total_group_persantage();

        // $data['bal_group_persantage']=100-$data['total_group_persantage'];
        // echo json_encode($data['total_group_persantage']);
        if($data['total_group_persantage']['total_persantage']==100)
        {
            $data['pesantage_limit']='over_flow';
             // $this->load->view('admin/edit_system_pool_landing',$data);
            $this->load->view('admin/edit_add_system_stage_pool',$data);
        
            //$this->load->view('admin/edit_add_system_pool',$data);
        }
        else
        {
            $data['pesantage_limit']='succes';
            // $this->load->view('admin/edit_system_pool_landing',$data);
            $this->load->view('admin/edit_add_system_stage_pool',$data);
        }


    }
    //add new ba stage  pool form
    function new_ba_stage_pool()
    {
        $data['default_assets']=$this->load->view('admin/templates/default_assets','',true);
        $data['sidebar']=$this->load->view('admin/templates/admin_sidebar','',true);
        $data['footer']=$this->load->view('admin/templates/admin_footer','',true);
        $data['stages']= $this->Pooling_model->get_all_stages();
        $data['total_group_persantage']=$this->Pooling_model->get_total_ba_group_persantage();

//        $data['bal_group_persantage']=100-$data['total_group_persantage'];
        //echo json_encode($data['total_group_persantage']);
        if($data['total_group_persantage']['total_persantage']==100)
        {
            $data['pesantage_limit']='over_flow';

            $this->load->view('admin/edit_add_ba_system_pool',$data);
        }
        else
        {
            $data['pesantage_limit']='succes';
            // $this->load->view('admin/edit_system_pool_landing',$data);
            $this->load->view('admin/edit_add_ba_system_stage_pool',$data);
        }


    }
    //add new bch stage  pool form
    function new_bch_stage_pool()
    {
        $data['default_assets']=$this->load->view('admin/templates/default_assets','',true);
        $data['sidebar']=$this->load->view('admin/templates/admin_sidebar','',true);
        $data['footer']=$this->load->view('admin/templates/admin_footer','',true);
        $data['stages']= $this->Pooling_model->get_all_stages();
        $data['total_group_persantage']=$this->Pooling_model->get_total_bch_group_persantage();

//        $data['bal_group_persantage']=100-$data['total_group_persantage'];
        //echo json_encode($data['total_group_persantage']);
        if($data['total_group_persantage']['total_persantage']==100)
        {
            $data['pesantage_limit']='over_flow';

            $this->load->view('admin/edit_add_bch_system_pool',$data);
        }
        else
        {
            $data['pesantage_limit']='succes';
            // $this->load->view('admin/edit_system_pool_landing',$data);
            $this->load->view('admin/edit_add_bch_system_stage_pool',$data);
        }


    }
    //add new pool data
     

    function  add_new_pool_data()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("pool_name", "Pool Group Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("allow_persantage", "Group Allowed Percentage", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("no_of_levels", "No of Levels ", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("design_allwed_persantage[]", "Designation allowed percentage  ", "trim|required|htmlspecialchars|callback_percentagecheck");

            if($this->form_validation->run()== TRUE){
                $result=$this->Pooling_model->add_new_pool_data();
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }



            }
            else
            {
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
        else
        {

            show_error("We are unable to process this request on this way!");
        }
    }
    //add new ba pool data
    function  add_new_ba_pool_data()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("pool_name", "Pool Group Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("allow_persantage", "Group Allow Persantage", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("no_of_levels", "No of Levels ", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("design_allwed_persantage[]", "Designation allowed persantage  ", "numeric|trim|required|htmlspecialchars|callback_percentagecheck");

            if($this->form_validation->run()== TRUE){
                $result=$this->Pooling_model->add_new_ba_pool_data();
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }



            }
            else
            {
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
        else
        {

            show_error("We are unable to process this request on this way!");
        }
    }
    //add new bch  pool data
    function  add_new_bch_pool_data()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("pool_name", "Pool Group Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("allow_persantage", "Group Allow Persantage", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("no_of_levels", "No of Levels ", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("design_allwed_persantage[]", "Designation allowed percentage  ", "numeric|trim|required|htmlspecialchars|callback_percentagecheck");

            if($this->form_validation->run()== TRUE){
                $result=$this->Pooling_model->add_new_bch_pool_data();
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }



            }
            else
            {
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
        else
        {

            show_error("We are unable to process this request on this way!");
        }
    }
    //add new stage  pool data
     public function percentagecheck($str)
            {
                 $percentage =$this->input->post('design_allwed_persantage');
               //  var_dump($percentage);exit();
                 $sum = 0;
                 foreach ($percentage as $key => $value) {
                     $sum = $value + $sum;
                 }
                
                if ($sum=="100")
                {
                    //var_dump("success");
                    return TRUE;
                }
                else
                {
                   // var_dump("failure");
                     $this->form_validation->set_message('percentagecheck', 'Sum of Designation allowed percentage should be hundred');
                    return FALSE;
                   
                }
            }
             public function percentagecheck1($str,$str1)
            {
                 $percentage =$this->input->post('design_allwed_persantage');
                 $percentage1 =$this->input->post('new_designation_persantage');
                //var_dump($percentage1);
                 //exit();
                 $sum = 0;
                 foreach ($percentage as $key => $value) {
                     $sum = $value + $sum;
                 }
                if (!empty($percentage1))
                    {
                        foreach ($percentage1 as $key => $value) {
                             $sum = $value + $sum;
                         } 
                    }
                   // var_dump($sum);
                if ($sum=="100")
                {
                  //  var_dump("success");
                    return TRUE;
                }
                else
                {
                   // var_dump("failure");
                     $this->form_validation->set_message('percentagecheck1', 'Sum of Designation allowed percentage should be hundred');
                    return FALSE;
                   
                }
            }
    function add_new_stage_pool_data()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("pool_name", "Pool Group Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("allow_persantage", "Group Allow percentage", "trim|required|htmlspecialchars|numeric");
            $this->form_validation->set_rules("no_of_levels", "No of Levels ", "trim|required|htmlspecialchars|numeric");
            $this->form_validation->set_rules("design_allwed_persantage[]", "Designation allowed percentage  ", "trim|required|numeric|htmlspecialchars|numeric|callback_percentagecheck");

            if($this->form_validation->run()== TRUE){
                $result=$this->Pooling_model->add_new_stage_pool_data();
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }



            }
            else
            {
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
        else
        {

            show_error("We are unable to process this request on this way!");
        }
    }
    //add new ba  stage  pool data
    function add_new_ba_stage_pool_data()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("pool_name", "Pool Group Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("allow_persantage", "Group Allow Persantage", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("no_of_levels", "No of Levels ", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("design_allwed_persantage[]", "Designation allowed persantage  ", "numeric|trim|required|htmlspecialchars|callback_percentagecheck");

            if($this->form_validation->run()== TRUE){
                $result=$this->Pooling_model->add_new_ba_stage_pool_data();
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }



            }
            else
            {
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
        else
        {

            show_error("We are unable to process this request on this way!");
        }
    }
    //add new ba  stage  pool data
    function add_new_bch_stage_pool_data()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("pool_name", "Pool Group Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("allow_persantage", "Group Allow Persantage", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("no_of_levels", "No of Levels ", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("design_allwed_persantage[]", "Designation allowed persantage  ", "numeric|trim|required|htmlspecialchars|callback_percentagecheck");

            if($this->form_validation->run()== TRUE){
                $result=$this->Pooling_model->add_new_bch_stage_pool_data();
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }
            }
            else
            {
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
        else
        {

            show_error("We are unable to process this request on this way!");
        }
    }
    //view edit pool group data form
    function  view_pool_group_settings()
    {
        $data['default_assets']=$this->load->view('admin/templates/default_assets','',true);
        $data['sidebar']=$this->load->view('admin/templates/admin_sidebar','',true);
        $data['footer']=$this->load->view('admin/templates/admin_footer','',true);
        $data['pooling_groups']= $this->Pooling_model->get_all_group_pooing();
        $data['pooling_stages']= $this->Pooling_model->get_all_stage_pooing();
        $this->load->view('admin/edit_view_group_pooling',$data);
    }
    //view edit ba  pool group data form
    function  view_pool_ba_group_settings()
    {
        $data['default_assets']=$this->load->view('admin/templates/default_assets','',true);
        $data['sidebar']=$this->load->view('admin/templates/admin_sidebar','',true);
        $data['footer']=$this->load->view('admin/templates/admin_footer','',true);
        $data['pooling_groups']= $this->Pooling_model->get_all_ba_group_pooing();
        $data['pooling_stages']= $this->Pooling_model->get_all_ba_stage_pooing();

        $this->load->view('admin/edit_view_ba_group_pooling',$data);
    }
    //view edit bch  pool group data form
    function  view_pool_bch_group_settings()
    {
        $data['default_assets']=$this->load->view('admin/templates/default_assets','',true);
        $data['sidebar']=$this->load->view('admin/templates/admin_sidebar','',true);
        $data['footer']=$this->load->view('admin/templates/admin_footer','',true);
        $data['pooling_groups']= $this->Pooling_model->get_all_bch_group_pooing();
        $data['pooling_stages']= $this->Pooling_model->get_all_bch_stage_pooing();
        // echo json_encode($data['pooling_stages']);
        //  exit();
        $this->load->view('admin/edit_view_bch_group_pooling',$data);
       // $this->load->view('admin/edit_view_full_pool_bch',$data);
    }
    //view full pooling settings form
    function full_system_pool_settings($id,$type)
    {
        $data['default_assets']=$this->load->view('admin/templates/default_assets','',true);
        $data['sidebar']=$this->load->view('admin/templates/admin_sidebar','',true);
        $data['footer']=$this->load->view('admin/templates/admin_footer','',true);
        $data['total_group_persantage']=$this->Pooling_model->get_total_group_persantage();
        $data['id']=$id;
        if($type=='group')
        {
            $data['type']=$type;
            $data['pooling_details']= $this->Pooling_model->get_all_system_pooing_by_id($id);
            $data['designations']= get_all_desigination();
        }
        else if($type=='stage')
        {

            $data['pooling_details']= $this->Pooling_model->get_all_system_stage_pooing_by_id($id);

            //echo json_encode($data['pooling_details']);
            $data['type']=$type;

            $data['designations']= $this->Pooling_model->get_all_stages_custom();


        }
       
            $this->load->view('admin/edit_view_full_pool_settings',$data);
    }



    //delete system pooling group
    function delete_system_pool_group($id)
    {
        $result=$this->Pooling_model->delete_system_pool_group($id);
        if($result)
        {
            exit(json_encode(array("status"=>TRUE)));
        }
        else
        {
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    //pranav 3/27/2017/
    //delete system stage pooling group
    function delete_system_stage_pool_group($id)
    {
        $result=$this->Pooling_model->delete_system_stage_pool_group($id);
        if($result)
        {
            exit(json_encode(array("status"=>TRUE)));
        }
        else
        {
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    //pranav 3/27/2017/ end
    //delete ba pool group
    function  delete_system_ba_pool_group($id)
    {
        $result=$this->Pooling_model->delete_system_ba_pool_group($id);
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    //delete bch pool group
    function  delete_system_bch_pool_group($id)
    {
        $result=$this->Pooling_model->delete_system_bch_pool_group($id);
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    // view form of add pool stages
    function pool_stage()
    {
        $data=$this->set_menu();
        $this->load->view('admin/edit_add_new_pool_stage',$data);
    }
    // add new pool stage
    function  add_new_pool_stage()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("stage_name", "Stage Name ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("discription", "Discription", "trim|required|htmlspecialchars");

            if($this->form_validation->run()== TRUE)
            {
                $result=$this->Pooling_model->add_new_pool_stage();

                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }
                else
                {

                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }
            else
            {
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }
    }
    //view all pool stages
    function  view_all_pool_stages()
    {
        $data=$this->set_menu();
        $data['all_stages']=$this->Pooling_model->get_all_stages();
        // echo json_encode($data['all_stages']);

        $this->load->view('admin/edit_view_pool_stages',$data);
    }
    // add ba commision
    function add_ba_commision()
    {
        $value=$this->input->post('comission');
        $result=$this->Pooling_model->add_ba_commision($value);
        if($result)
        {
            exit(json_encode(array("status"=>TRUE)));
        }
        else
        {
            exit(json_encode(array("status"=>FALSE)));
        }

    }

    // add bch commision
    // add ba commision
    function add_bch_commision()
    {
        $value=$this->input->post('comission');
        $result=$this->Pooling_model->add_bch_commision($value);
        if($result)
        {
            exit(json_encode(array("status"=>TRUE)));
        }
        else
        {
            exit(json_encode(array("status"=>FALSE)));
        }

    }
    //get ba commision
    function get_ba_commision()
    {
        $result=$this->Pooling_model->get_ba_commision();
        if($result)
        {
            exit(json_encode(array("status"=>TRUE,"vals"=>$result['percentage'])));
        }
    }
    //get bch commision
    function get_bch_commision()
    {
        $result=$this->Pooling_model->get_bch_commision();
        if($result)
        {
            exit(json_encode(array("status"=>TRUE,"vals"=>$result['percentage'])));
        }
    }
    //pranav ends



    //check sort order of desiginations
    function  check_sort_order()
    {
        if($this->input->is_ajax_request())
        {


            $result=$this->Pooling_model->check_sort_order();

            if($result){
                exit(json_encode(array("status"=>TRUE)));
            }
            else{

                exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
            }

        }
    }
    //view  all  designation
    function get_all_desiginations()
    {
        $result=get_all_desigination();

    }

    function new_commision(){
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data['user']=$this->Profile_model->get_all_partnertype($userid);

        $data['default_assets']=$this->load->view('admin/templates/default_assets','',true);
        $data['sidebar']=$this->load->view('admin/templates/admin_sidebar','',true);
        $data['footer']=$this->load->view('admin/templates/admin_footer','',true);
        $data['partner_type']=$this->Pooling_model->get_partner_type();
       // echo json_encode($data['partner_type']);exit();
        $this->load->view('admin/edit_add_commmission',$data);
    }
    function new_commision_add(){

        if($this->input->is_ajax_request()){
            //exit();
            //$this->form_validation->set_rules("main_commission", "Main Commision ", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("channel_type", "Partner Bussiness Type ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("company_commission", "Company Commission ", "numeric|trim|required|htmlspecialchars|greater_than[4]");
            $this->form_validation->set_rules("category_name[]", "Category Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("category_percent[]", "Category Percentage", "numeric|trim|required|htmlspecialchars|greater_than[4]");
            //var_dump($this->input->post());exit;
            if($this->form_validation->run()== TRUE){
                $cat_id = $this->input->post('prod_cat_old_id');
                // var_dump($cat_id); exit;
              //  var_dump(is_array($cat_id));exit;
                if(empty($cat_id)){
                //  echo 'dd'; exit;
                //    var_dump($cat_id); exit;
                    $result = $this->Pooling_model->add_new_commission();
                }else{
                 //   var_dump($cat_id); exit;
                    $result = $this->Pooling_model->edit_commision_by_con();
                }
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
    function edit_commission_by_con()
    {
         if($this->input->is_ajax_request()){
            $this->form_validation->set_rules("company_comm_id", "Commission Id", "trim|htmlspecialchars");
            $this->form_validation->set_rules("channel_type", "Partner Bussiness Type ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("company_commission", "Company Commission ", "numeric|trim|required|htmlspecialchars|greater_than[4]");
            $this->form_validation->set_rules("category_name[]", "Category Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("category_percent[]", "Category Percentage", "numeric|trim|required|htmlspecialchars|greater_than[4]");
            var_dump($this->input->post());exit;
            if($this->form_validation->run()== TRUE){
                
                $result=$this->Pooling_model->edit_commision_by_con();

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


    function get_commision_all(){

        $data=$this->set_menu();
         $loginsession = $this->session->userdata('logged_in_admin');
         $userid=$loginsession['user_id'];
         $lgid=$loginsession['id'];
         $data['user']=$this->Profile_model->get_all_partnertype($userid);
         $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['partner_type']=$this->Pooling_model->get_partner_type();
        $data['commission']=$this->Pooling_model->get_all_commision();
        $this->load->view('admin/edit_view_pooling',$data);
    }

    function delete_commissionbyid($id)
    {
        $result=$this->Pooling_model->delete_commission($id);
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }   
    }

   function edit_pooling_stage(){
        if($this->input->is_ajax_request()){
          // var_dump($this->input->post('stage_name'));

            $this->form_validation->set_rules("stage_name", "Stage Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("description", "Description", "trim|required|htmlspecialchars");
        
           // exit();
            if($this->form_validation->run()== TRUE){
                $result=$this->Pooling_model->edit_pooling_stage();

                if($result){
                   // var_dump("back to controller");
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{

                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>"Validation Error")));
            }
        }

    }
    function edit_pooling_byid(){
        if($this->input->is_ajax_request()){
           // exit;
            $this->form_validation->set_rules("channel_type", "Channel Partner Type ", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("direct_commi", "Direct Commission", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("company_commi", "Pooling Commission ", "trim|required|htmlspecialchars");

            if($this->form_validation->run()== TRUE){
                $result=$this->Pooling_model->edit_commission_byid();

                if($result){
                    exit(json_encode(array("status"=>TRUE)));
                }
                else{

                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>"Validation Error")));
            }
        }

    }
function effect_customer($purch_id)
{
    $result = $this->pooling_model->effect_cutomer($purch_id);
    if($result)
    {
        $noty_id = $result['noty_id'];
        $total_commision = $result['channel_partner_main_commision'];
        $channe_con_id = $result['channel_partner_conn_id'];
        $customer_id = $result['customer_id'];
        $wallet_total = $result['wallet_total'];
        $bill_total = $result['bill_total'];
        $commision = ($bill_total * $total_commision)/100;

        $divide_commision = $this->pooling_model->divide_commision($commision);


    }
    
}

 function pooling_designs()
    {
       
     //   var_dump("expression");exit;
       
//            $this->load->view('admin/edit_add_system_pool',$data);
        $data['default_assets']=$this->load->view('admin/templates/default_assets','',true);
        $data['sidebar']=$this->load->view('admin/templates/admin_sidebar','',true);
        $data['footer']=$this->load->view('admin/templates/admin_footer','',true);
        $data['designations']= get_all_desigination();
        $data['total_group_persantage']=$this->Pooling_model->get_total_ba_group_persantage();
//        $data['bal_group_persantage']=100-$data['total_group_persantage'];
        $this->load->view('admin/pooling_design',$data);
       


    }

    //pranav

    //delete bch pool stage group
    function  delete_system_stage_bch_pool_group($id)
    {
        $result=$this->Pooling_model->delete_system_stage_bch_pool_group($id);
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }

    function  delete_system_stage_ba_pool_group($id)
    {
        $result=$this->Pooling_model->delete_system_stage_ba_pool_group($id);
        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }



    function  update_pool_data()
    {
       
        if($this->input->is_ajax_request())
        {
            $this->load->library(array('session','form_validation'));
            $this->load->helper(array('form', 'url'));
            $this->form_validation->set_rules("pool_name", "Pool Group Name", "trim|required|htmlspecialchars");
            $new_designation_persantage = $this->input->post('new_designation_persantage');
            $this->form_validation->set_rules("allow_persantage", "Group Allow Percentage", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("no_of_levels", "No of Levels ", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("design_allwed_persantage[]", "Designation allowed percentage  ", "numeric|trim|required|htmlspecialchars|callback_percentagecheck1[new_designation_persantage]");
        
            if($this->form_validation->run()==TRUE)
            {
                $result=$this->Pooling_model->update_pool_data();
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }
                else
                {
                    exit(json_encode(array("status"=>FALSE)));
                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }

        // echo json_encode($this->input->post());
    }


    //hridya
 //view full pooling bch form
    function full_system_pool_bch_settings($id,$type)
    {
        $data['default_assets']=$this->load->view('admin/templates/default_assets','',true);
        $data['sidebar']=$this->load->view('admin/templates/admin_sidebar','',true);
        $data['footer']=$this->load->view('admin/templates/admin_footer','',true);
        $data['total_group_persantage']=$this->Pooling_model->get_total_bch_group_persantage();
        $data['id']=$id;
        if($type=='group')
        {

            $data['type']=$type;
            $data['pooling_details']= $this->Pooling_model->get_all_system_bch_pooing_by_id($id);

            $data['designations']= get_all_desigination();
        }
        elseif($type=='stage')
        {

            $data['pooling_details']= $this->Pooling_model->get_all_system_bch_stage_pooing_by_id($id);
            //var_dump($data['pooling_details']);exit;
            $data['type']=$type;
            $data['designations']= $this->Pooling_model->get_all_stages_custom();
        }
        if($data['total_group_persantage']['total_persantage']==100)
        {
            $data['pesantage_limit']='over_flow';

            $this->load->view('admin/edit_view_full_pool_bch',$data);
        }
        else
        {
            $data['pesantage_limit']='succes';
            // $this->load->view('admin/edit_system_pool_landing',$data);
            $this->load->view('admin/edit_view_full_pool_bch',$data);
        }


    }


//update pool bch
    function  update_pool_bch_data()
    {
       //var_dump("dd");exit;
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("pool_name", "Pool Group Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("allow_persantage", "Group Allow Persantage", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("no_of_levels", "No of Levels ", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("design_allwed_persantage[]", "Designation allowed persantage  ", "numeric|trim|required|htmlspecialchars");

            if($this->form_validation->run()==TRUE)
            {
                $result=$this->Pooling_model->update_pool_bch_data();
                if($result)
                {
                    exit(json_encode(array("status"=>TRUE)));
                }
                else
                {
                    exit(json_encode(array("status"=>FALSE)));
                }
            }
            else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }

        echo json_encode($this->input->post());
    }





    //view full pooling ba form
    function full_system_pool_ba_settings($id,$type)
    {
        $data['default_assets']=$this->load->view('admin/templates/default_assets','',true);
        $data['sidebar']=$this->load->view('admin/templates/admin_sidebar','',true);
        $data['footer']=$this->load->view('admin/templates/admin_footer','',true);
        $data['total_group_persantage']=$this->Pooling_model->get_total_ba_group_persantage();
        $data['id']=$id;
        if($type=='group')
        {
            $data['type']=$type;
            $data['pooling_details']= $this->Pooling_model->get_all_system_ba_pooing_by_id($id);

            $data['designations']= get_all_desigination();
        }
        elseif($type=='stage')
        {
            $data['pooling_details']= $this->Pooling_model->get_all_system_ba_stage_pooing_by_id($id);
            $data['type']=$type;
            $data['designations']= $this->Pooling_model->get_all_stages_custom();

        }
        if($data['total_group_persantage']['total_persantage']==100)
        {
            $data['pesantage_limit']='over_flow';

            $this->load->view('admin/edit_view_full_pool_ba',$data);
        }
        else
        {
            $data['pesantage_limit']='succes';
            // $this->load->view('admin/edit_system_pool_landing',$data);
            $this->load->view('admin/edit_view_full_pool_ba',$data);
        }
        // echo json_encode($data['pooling_details']);

    }



    //update pool ba
    function  update_pool_ba_data()
    {

        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules("pool_name", "Pool Group Name", "trim|required|htmlspecialchars");
            $new_designation_persantage = $this->input->post('new_designation_persantage');
            $this->form_validation->set_rules("allow_persantage", "Group Allow Persantage", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("no_of_levels", "No of Levels ", "numeric|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("design_allwed_persantage[]", "Designation allowed percentage  ", "numeric|trim|required|htmlspecialchars|callback_percentagecheck1[new_designation_persantage]");

            if($this->form_validation->run()==TRUE)
            {
                $result=$this->Pooling_model->update_pool_ba_data();
                if($result)
                {
                     exit(json_encode(array("status"=>TRUE)));
                }
                else
                {
                    exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
                }
            }
             else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }
        }

        show_error("We are unable to process this request on this way!");
    }



    function delete_system_stage_pooling_group($id)
    {
        $result=$this->Pooling_model->delete_system_stage_pooling_group($id);
        if($result)
        {
            exit(json_encode(array("status"=>TRUE)));
        }
        else
        {
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }


    function delete_system_stage_bch_pooling_group($id)
    {
        $result=$this->Pooling_model->delete_system_stage_bch_pooling_group($id);
        if($result)
        {
            exit(json_encode(array("status"=>TRUE)));
        }
        else
        {
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    function delete_system_stage_ba_pooling_group($id)
    {
        $result=$this->Pooling_model->delete_system_stage_ba_pooling_group($id);
        if($result)
        {
            exit(json_encode(array("status"=>TRUE)));
        }
        else
        {
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }*/



}
?>