<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 */

Class Executives extends CI_Controller
{

    function __Construct()
    {
        parent:: __construct();
        $this->load->library(array('session','form_validation'));
        $this->load->model(array('admin/Executives_model','admin/Profile_model','admin/Channelpartner_model'));
        $this->load->helper(array('url','form', 'custom','my_common_helper'));

        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array)){
            redirect('admin/Login');
        }

    }
    function set_menu(){
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $loginsession = $this->session->userdata('logged_in_admin');
        if($loginsession['type'] == 'executive'){
        $data['sidebar'] = $this->load->view('admin/templates/ex_sidebar',$data,  true);
        }
        else{
            $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
            }
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        return $data;
    }
    //arya starts

    function set_ba_menu()
    {
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $loginsession = $this->session->userdata('logged_in_admin');
        //var_dump($loginsession);exit;
        if($loginsession['type'] == 'super_admin'){
            $data['sidebar'] = $this->load->view('admin/templates/admin_sidebar', '', true);
        }else{
            $data['sidebar'] = $this->load->view('admin/templates/cp_sidebar', '', true);
        }
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        return $data;
    }
    function exec_dashboard()
    {
        $loginsession = $this->session->userdata('logged_in_admin');

        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
       
        $data['user']=$this->Profile_model->get_exicutives($userid);
        $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $exe_details = get_execuitive_details();
        if($exe_details['sales_desig_type_id'] == 5){
            $data['sidebar'] = $this->load->view('admin/templates/bch_sidebar',$data, true);
        }else{
            $data['sidebar'] = $this->load->view('admin/templates/ex_sidebar',$data, true);
        }
        
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        // print_r($data); exit();
        // $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        // $data['sidebar'] = $this->load->view('admin/templates/ex_sidebar',$data, true);
        // $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        // print_r($data); exit();
        $data['my_wallet_value']=$this->Executives_model->get_mywallet_value();
        $this->load->view('admin/exec-dashboard',$data);
    }
    function exec_add(){
        $loginsession = $this->session->userdata('logged_in_admin');
        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
        $data=$this->set_menu();
        $this->load->library('googlemaps');
        $config['center'] = '10.804305026919454, 76.11534118652344';
        $config['zoom'] = '8';
        $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $data['user']=$this->Profile_model->get_exicutives($userid);
        $data['countries'] = $this->Channelpartner_model->get_countries();
        //echo json_encode($data['user']); exit();
        $data['designations']=$this->Executives_model->get_desigsviewall();
        $this->load->view('admin/exec-add',$data);
    }
    function exec_addins(){
        $session_array = $this->session->userdata('logged_in_admin');
        $sid = $session_array['id'];
        $a  = '1';
        $a1 = $this->input->post('ename');
        $a2 = $this->input->post('dsig');
        $a3 = $this->input->post('email');
        $a4 = $this->input->post('mob');
        $a5 = $this->input->post('address');
        $a6 = $this->input->post('fax');
        $a7 = $this->input->post('country');
        $a8 = $this->input->post('state');
        
        $date = date('Y-m-d');
        $data = array(  'sales_desig_type_id' => $a2,
                        'name' => $a1,
                        'parent_id' => $sid,
                        'created_by' => $sid,
                        'created_on' => $date );
        $data1 = array( 'name' => $a1,
                        'phone' => $a4,
                        'address' => $a5,
                        'fax' => $a6,
                        'status' => '1');
        $data3 = array( 'password' => 'pwd',
                        'email' => $a3,
                        'type' => 'executive');
        $result=$this->Executives_model->insert_execbasics($data,$data1,$data3);
        if($result){
                    echo "<script>alert('success')</script>";
                    $data=$this->set_menu();
                    $data['designations']=$this->Executives_model->get_desigsview();
                    $this->load->view('admin/exec-add',$data);
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }
    }
    function exec_clubmsins1(){
        $session_array = $this->session->userdata('logged_in_admin');
        $sid = $session_array['id'];
        $a1 = $this->input->post('club1');
        $a2 = $this->input->post('name1');
        $date = date('Y-m-d');
        $data1 = array( 'club_type_id' => $a1,
                        'updated_on' => $date,
                        'updated_by' => $sid );
        $result=$this->Executives_model->insert_execclub1($data1,$a2);
        if($result){
                    echo "<script>alert('success')</script>";
                    $data=$this->set_menu(); 
                    $data['users']=$this->Executives_model->get_users();
                    $data['clubs']=$this->Executives_model->get_clubtypes();
                    $this->load->view('admin/exec-clubmsadd',$data);
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }
    }
    function exec_clubmsins2(){
        $session_array = $this->session->userdata('logged_in_admin');
        $sid = $session_array['id'];
        $a1 = $this->input->post('club2');
        $a2 = $this->input->post('name2'); 
        $a3 = $this->input->post('email2');  
        $a4 = $this->input->post('fax2');    
        $a5 = $this->input->post('pincode2');
        $a6 = $this->input->post('phone2');  
        $a7 = $this->input->post('address2');
        $date = date('Y-m-d');
        $data2 = array( 'club_type_id' => $a1,
                        'parent_id' => $sid,
                        'name' => $a2,
                        'phone' => $a6,
                        'fax' => $a4,
                        'email' => $a3,
                        'pincode' => $a5,
                        'address' => $a7,
                        'created_on' => $date,
                        'created_by' => $sid );
        $result=$this->Executives_model->insert_execclub2($data2);
        if($result){
                    echo "<script>alert('success')</script>";
                    $data=$this->set_menu(); 
                    $data['users']=$this->Executives_model->get_users();
                    $data['clubs']=$this->Executives_model->get_clubtypes();
                    $this->load->view('admin/exec-clubmsadd',$data);
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }
    }
    function exec_view(){
        $data=$this->set_menu();
        $data['designations']=$this->Executives_model->get_desigsviewall();
        $data['executives']=$this->Executives_model->get_executives();
        // $data['exedetails']=$this->Executives_model->get_exedetails();
        // $data['designation']=$this->Executives_model->get_exedesignation();
        // $data['login']=$this->Executives_model->get_exelogin();
        $this->load->view('admin/exec-view',$data);
    }
    function exec_cpw(){
         $loginsession = $this->session->userdata('logged_in_admin');

        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
       
        $data['user']=$this->Profile_model->get_exicutives($userid);
         $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/ex_sidebar',$data, true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['designations']=$this->Executives_model->get_desigsview();
        $this->load->view('admin/exec-changepw',$data);
    }
    function exec_sel(){
        $data=$this->set_menu();
        $data['designations']=$this->Executives_model->get_desigsview();
        $this->load->view('admin/exec-promo-settings-select',$data);
    }
    function exec_setadd(){
        $data=$this->set_menu();
        $data['designations']=$this->Executives_model->get_desigsadd();
        $data['modules']=$this->Executives_model->get_modules();
        $this->load->view('admin/exec-promo-settings-add',$data);
    }
    function exec_setaddins(){
        $a=1;
        $a2 = $this->input->post('dsig');
        $a3 = $this->input->post('md');
        $a4 = $this->input->post('co');
        $a5 = $this->input->post('am');
        $a6 = $this->input->post('todsig');
        $a7 = $this->input->post('pd');

        $date = date('Y-m-d');
        foreach($a3 as $key => $each)
        {        $data = array(
            'designation_id' => $a2,
            'sysmodule_id' => $a3[$key],
            'promotion_count' => $a4[$key],
            'promotion_amount' => $a5[$key],
            'promotion_designation'=>$a6,
            'promotion_period' => $a7[$key],
            'date' => $date);
            if($a4[$key]!=null){ $result=$this->Executives_model->insert_setexec($data); }
        }
        if($result){
            echo "<script>alert('success')</script>";
            $data=$this->set_menu();
            $data['designations']=$this->Executives_model->get_desigsview();
            $this->load->view('admin/exec-promo-settings-select',$data);
        }else{
            exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
        }
    }
    function exec_seteditins(){
        $a=1;
//        $did = $this->input->post('did');
//        echo json_encode($did);exit;
//        $this->Executives_model->exec_setdelete($did);
        // echo "string"; exit();
        $a2 = $this->input->post('did');

        $a3 = $this->input->post('md');
        $a4 = $this->input->post('co');
        $a5 = $this->input->post('am');
        $a6 = $this->input->post('pid');
        $a7 = $this->input->post('pd');
        $date = date('Y-m-d');
        foreach($a3 as $key => $each)
        {        $data = array(
            'designation_id' => $a2,
            'sysmodule_id' => $a3[$key],
            'promotion_count' => $a4[$key],
            'promotion_amount' => $a5[$key],
            'promotion_period' => $a7[$key],
            'date' => $date);
            // if($a4[$key]!=null){ $result=$this->Executives_model->edit_setexec($data); }
            if($a4[$key]!=null){ $result=$this->Executives_model->insert_setexec($data); }
        }
        

        if($result){
            echo "<script>alert('success')</script>";
            $data=$this->set_menu();
            $data['designations']=$this->Executives_model->get_desigsview();
            $this->load->view('admin/exec-promo-settings-select',$data);
        }else{
            exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
        }
    }
    function exec_setview(){
        $a2 = $this->input->post('dsig');
        $a6 = $this->input->post('todsig');



        $data=$this->set_menu();
        // $data['modules']=$this->Executives_model->get_modulesid($a2);
        $data['designation']=$this->Executives_model->get_desigid($a2);
        $data['modules']=$this->Executives_model->get_modules();
        $data['settings']=$this->Executives_model->get_settings($a2);
        $data['todesig']=$this->Executives_model->get_protion_settings_id($a2);
        /// echo json_encode($data['todesig']);


        $this->load->view('admin/exec-promo-settings-view',$data);
    }
    function exec_clubmsadd(){
       $loginsession = $this->session->userdata('logged_in_admin');

        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
       
        $data['user']=$this->Profile_model->get_exicutives($userid);
         $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/ex_sidebar',$data, true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['users']=$this->Executives_model->get_users();
        $data['clubs']=$this->Executives_model->get_clubtypes();
        $this->load->view('admin/exec-clubmsadd',$data);
    }
    function exec_clubmsview(){
        $loginsession = $this->session->userdata('logged_in_admin');

        $userid=$loginsession['user_id'];
        $lgid=$loginsession['id'];
       
        $data['user']=$this->Profile_model->get_exicutives($userid);
         $data['default_assets'] = $this->load->view('admin/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('admin/templates/ex_sidebar',$data, true);
        $data['footer'] = $this->load->view('admin/templates/admin_footer', '', true);
        $data['clubs']=$this->Executives_model->get_clubs();
        $this->load->view('admin/exec-clubmsview',$data);
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

    //Add ba form

    //Add ba form

    function add_ba()
    {
        $data=$this->set_ba_menu();
        $this->load->library('googlemaps');

        $config['center'] = '10.054192, 76.634654';
        $config['zoom'] = '7';
        //  $config['onclick'] = 'alert(\'You just clicked at: \' + event.latLng.lat() + \', \' + event.latLng.lng());';
        $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();

        //  $data['designations']=$this->Executives_model->get_desigsviewall();
        $data['countries'] = $this->Executives_model->get_countries();
        $this->load->view('admin/edit_add-ba-settings',$data);
    }

    function get_state_by_id($id)
    {

        $data = $this->Executives_model->get_state_by_country($id);
        if($data)
        {
            exit(json_encode(array('status'=>true,'data'=>$data)));
        }
        else
        {
            exit(json_encode(array('status'=>false, 'reason'=>'invalid selection')));
        }
    }

    function new_ba(){

        if($this->input->is_ajax_request()){


            $this->form_validation->set_rules("ba_name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("ba_mobile", "Mobile", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("ba_email", "Email", "valid_email|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("ba_company_Name", "Company Name","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("office_phone", "Office Phone", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("lat", "lat","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("long", "long", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("office_email_id", "valid_email", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("company_location", "Company Location","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("city", "City", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("sel_country", "Select Country","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("sel_state", "Select State","trim|required|htmlspecialchars");

            if( $this->form_validation->run() == TRUE )
            {
                $result=$this->Executives_model->add_New_ba();


                if($result){

                    $mail_from = 'greenindia@gmail.com';
                    $mail_head = 'Green India';
                    $subject = 'BA Request';
                    $email = $result['email'];
                    $email_message = $this->load->view('admin/edit_ba_email_template_otp', $result,TRUE);

                    $mail= send_custom_email($mail_from, $mail_head, $email, $subject, $email_message);


                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }

            }else{
                exit(json_encode(array("status"=>FALSE,"reason"=>validation_errors())));
            }

        }
        else{
            show_error("We are unable to process this request on this way!");
        }
    }

    function ba_view()
    {
        $data=$this->set_ba_menu();
        $data['viewba']=$this->Executives_model->get_baview();
        // $data['exedetails']=$this->Executives_model->get_exedetails();
        // $data['designation']=$this->Executives_model->get_exedesignation();
        // $data['login']=$this->Executives_model->get_exelogin();
        $this->load->view('admin/edit-view-ba',$data);
    }
    function delete_ba_by_id($id)
    {
        $result=$this->Executives_model->delete_ba_by_id($id);

        if($result){
            exit(json_encode(array("status"=>TRUE)));
        }
        else{
            exit(json_encode(array("status"=>FALSE,"reason"=>"Database Error")));
        }
    }
    function get_ba_view_byid($id)
    {


        $data=$this->set_ba_menu();
        $data=$this->set_ba_menu();
        $this->load->library('googlemaps');

        $config['center'] = '10.054192, 76.634654';
        $config['zoom'] = '7';
        //  $config['onclick'] = 'alert(\'You just clicked at: \' + event.latLng.lat() + \', \' + event.latLng.lng());';
        $config['onclick'] ='getPosition(event.latLng.lat(), event.latLng.lng());';
        $this->googlemaps->initialize($config);
        $data['map'] = $this->googlemaps->create_map();
        $data['countries'] = $this->Executives_model->get_countries();
        $data['viewba']=$this->Executives_model->get_ba_view_byid($id);



        $this->load->view('admin/edit-ba-edit',$data);
    }










    function edit_ba(){

        if($this->input->is_ajax_request()){

            $this->form_validation->set_rules("ba_name", "Name", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("ba_mobile", "Mobile", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("ba_email", "Email", "valid_email|trim|required|htmlspecialchars");
            $this->form_validation->set_rules("ba_company_Name", "Company Name","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("office_phone", "Office Phone", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("office_email_id", "valid_email", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("company_location", "Company Location","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("city", "City", "trim|required|htmlspecialchars");
            $this->form_validation->set_rules("sel_country", "Select Country","trim|required|htmlspecialchars");
            $this->form_validation->set_rules("sel_state", "Select State","trim|required|htmlspecialchars");
            if($this->form_validation->run()== TRUE){
                $result=$this->Executives_model->edit_ba_by_id();

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




}
?>