<?php
Class Executives_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();
    }
    function get_mywallet_value()
    {
        $qry="SELECT total_value FROM `gp_wallet_values` WHERE `user_id` = '13'";

        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            return $result->row_array();
        }
        else
        {
            return array();
        }

    }
    function get_desigsadd(){
        $qry="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id
        FROM `gp_pl_sales_designation_type` LEFT JOIN `gp_executive_promotion_settings`
        ON gp_pl_sales_designation_type.id = gp_executive_promotion_settings.designation_id
        WHERE gp_executive_promotion_settings.designation_id IS NULL";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_desigsview(){
        $qry="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id
        FROM `gp_pl_sales_designation_type` LEFT JOIN `gp_executive_promotion_settings`
        ON gp_pl_sales_designation_type.id = gp_executive_promotion_settings.designation_id
        WHERE gp_executive_promotion_settings.designation_id IS NOT NULL
    GROUP BY gp_pl_sales_designation_type.designation";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_desigsviewall(){
    $qry="SELECT gp_pl_sales_designation_type.designation,gp_pl_sales_designation_type.id
        FROM `gp_pl_sales_designation_type` LEFT JOIN `gp_executive_promotion_settings`
        ON gp_pl_sales_designation_type.id = gp_executive_promotion_settings.designation_id
        GROUP BY gp_pl_sales_designation_type.designation";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_modules(){
        $qry="select * from gp_systemmodule";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_modulesid($id){
        $qry="select * from gp_systemmodule where id=$id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_settings($id){
        $qry="select * from gp_executive_promotion_settings where designation_id=$id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_protion_settings_id($id)
    {
        $qry="SELECT  DISTINCT(promotion_designation)  from gp_executive_promotion_settings where designation_id='$id'";

        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            $promotion_desigf_id=$result->row_array();
            // echo json_encode($promotion_desigf_id['promotion_designation']);
            $id=$promotion_desigf_id['promotion_designation'];
            $query=" SELECT designation  FROM `gp_pl_sales_designation_type` WHERE id='$id'";
            $results=$this->db->query($query);
            if($results->num_rows()>0)
            {
                return $results->row_array();
            }
            else
            {
                return array();
            }
        }

    }

    function exec_setdelete($did){
        $qry = "DELETE FROM gp_executive_promotion_settings WHERE designation_id = $did" ;
        $qry = $this->db->query($qry);
        // return $data;
    }
    function get_desigid($id){
        $qry="select * from gp_pl_sales_designation_type where id=$id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function insert_setexec($data)
    {
        $qry = $this->db->insert('gp_executive_promotion_settings', $data);

           
        return $qry;
    }
    function insert_execclub1($data1,$a1)
    {
        $qry = $this->db->where('id', $a1);
        $qry = $this->db->update('gp_normal_customer', $data1);
        return $qry;
    }
    function insert_execclub2($data2)
    {
        $qry = $this->db->insert('gp_normal_customer', $data2);
        return $qry;
    }
    function insert_execbasics($data,$data1,$data3)
    {
        $qry = $this->db->insert('gp_pl_sales_team_members', $data);
        $lid=$this->db->insert_id();
        $data2 = array( 'sales_team_member_id' => $lid );
        $appended1 = array_merge($data1,$data2);
        $data4 = array( 'user_id' => $lid );
        $appended2 = array_merge($data3,$data4);
        $qry1 = $this->db->insert('gp_pl_sales_team_member_details', $appended1);
        $qry2 = $this->db->insert('gp_login_table', $appended2);


            $action = "added Executives ";
            $date = date("Y-m-d h:i:sa") ;
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
        return $qry;

    }
    function get_executives(){
        $qry="select gp_pl_sales_team_members.*,gp_pl_sales_team_member_details.*,gp_login_table.*,gp_pl_sales_designation_type.designation from gp_pl_sales_team_members
        join gp_pl_sales_team_member_details on gp_pl_sales_team_members.id = gp_pl_sales_team_member_details.sales_team_member_id
        join gp_pl_sales_designation_type on gp_pl_sales_team_members.sales_desig_type_id = gp_pl_sales_designation_type.id
        join gp_login_table on gp_pl_sales_team_members.id = gp_login_table.user_id
        ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_users(){
        $qry="select * from gp_normal_customer where club_type_id = '0' ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_clubtypes(){
        $qry="select * from club_member_type where is_del = '0' ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function get_clubs(){
        $qry="select gp_normal_customer.*,club_member_type.title from gp_normal_customer
        join club_member_type on gp_normal_customer.club_type_id = club_member_type.id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }
    function add_new_product($image_file){
        $this->db->trans_begin();
        $data=array(
            'category_id'=>$this->input->post('pro_category'),
            'name'=>$this->input->post('pro_name'),
            'quantity'=>$this->input->post('pro_quantity'),
            'description'=>$this->input->post('pro_description'),
            'model'=>$this->input->post('pro_model'),
            'actual_cost'=>$this->input->post('pro_actualcost'),
            'image'=>$image_file,
            'cost'=>$this->input->post('pro_cost'),
        );
        $this->db->insert('gp_product_details',$data);
          $action = "added new product";
            $date = date("Y-m-d h:i:sa") ;
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
    function get_all_product(){
        $qry="select p.*,pc.title from gp_product_details p
              left join gp_product_category pc on pc.id=p.category_id
              where p.is_del='0'";
        $qry=$this->db->query($qry);
        if($qry){
            $data['produ']=$qry->result_array();
        }
        else{
            $data['produ']=array();
        }
        return $data;
    }
    function get_product_byid($id){
        $qry="select p.*,pc.title from gp_product_details p
              left join gp_product_category pc on pc.id=p.category_id
              where p.id='$id'";
        $qry=$this->db->query($qry);
        if($qry){
            $data['produ']=$qry->row_array();
        }
        else{
            $data['produ']=array();
        }
        return $data;
    }
    function edit_product_byid($image_file,$id){
        $this->db->trans_begin();
        $data=array(
            'category_id'=>$this->input->post('pro_category'),
            'name'=>$this->input->post('pro_name'),
            'quantity'=>$this->input->post('pro_quantity'),
            'description'=>$this->input->post('pro_description'),
            'model'=>$this->input->post('pro_model'),
            'actual_cost'=>$this->input->post('pro_actualcost'),
            'image'=>$image_file,
            'cost'=>$this->input->post('pro_cost'),
        );
        $this->db->where('id',$id);
        $this->db->update('gp_product_details',$data);
         $action = "updated new product";
            $date = date("Y-m-d h:i:sa") ;
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);


        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }
    //Arya ba  module start

    function get_countries()
    {
        $qry = "select
				c.*
				from
				countries c";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }	else{
            return array();
        }
    }
    function get_states()
    {
        $qry = "select
				s.*
				from
				states s";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }	else{
            return array();
        }
    }
    function get_cities()
    {
        $qry = "select
				c.*
				from
				cities c";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }	else{
            return array();
        }
    }
    function get_state_by_country($id)
    {
        $qry = "select
				s.id,s.name,s.country_id
				from
				states s
				where s.country_id = '$id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }	else{
            return array();
        }
    }

    function random_password( $length = 8 ) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr( str_shuffle( $chars ), 0, $length );
        return $password;
    }
    function add_New_ba()
    {
        $this->db->trans_begin();
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $created_on = date('Y-m-d H:i:s');
        $password = $this->random_password(8);
        $username = $password."@green.com";
        $user_psw = $password;
        $name=$this->input->post('ba_name');
        $mobile=$this->input->post('ba_mobile');
        $lat=$this->input->post('lat');
        $long=$this->input->post('long');

        $email=$this->input->post('ba_email');
        $company_name=$this->input->post('ba_company_Name');
        $office_phone=$this->input->post('office_phone');
        $office_emailid=$this->input->post('office_email_id');
        $company_location=$this->input->post('company_location');
        $city=$this->input->post('city');
        $country=$this->input->post('sel_country');
        $state=$this->input->post('sel_state');


        $data = array(
            'name' => $name,
            'mobil_no' =>$mobile,
            'email' =>$email,
            'company_name' =>$company_name,
            'lat' =>$lat,
            'lon' =>$long,

            'office_phno' =>$office_phone,
            'office_email' =>$office_emailid,

            'company_location' =>$company_location,
            'city' =>$city,
            'contry' =>$country,
            'state' =>$state,
            'created_on' => $created_on,
            'created_by' => 'admin',


        );
        $this->db->insert('pl_ba_registration', $data);

        $last_inser_id=$this->db->insert_id();
        $login_data = array(
            'email' => $email,
            'mobile'=> $mobile,
            'type' => " business_associate",
            'user_id' => $last_inser_id,
            'password' => $user_psw,

        );
        $qry=$this->db->insert('gp_login_table', $login_data);



             $date = date('Y-m-d H:i:s');
            $action = "added ba ";
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);

        if($qry) {


//            $to = 'shabasppm123@gmail.com';
//
//            $ci = get_instance();
//            $ci->load->library('email');
//            $config['protocol'] = "smtp";
//            $config['smtp_host'] = "ssl://smtp.gmail.com";
//            $config['smtp_port'] = "465";
//            $config['smtp_user'] = 'pranavpk.pk1@gmail.com';
//            $config['smtp_pass'] = '9544146763';
//            $config['charset'] = "utf-8";
//            $config['mailtype'] = "html";
//            $config['newline'] = "\r\n";
//
//            $ci->email->initialize($config);
//
//            $ci->email->from('kavyap1993nov@gmail.com', 'kavya');
//
//            $ci->email->to('shabasppm123@gmail.com');
//            $this->email->reply_to('no-replay@gmail.com', 'Explendid Videos');
//            $ci->email->subject('New Password from green admin');
//            $ci->email->message('Your username is '.$username.' and  password is  '.$user_psw .' .Use this username and password for login');
//            $ci->email->send();

        }

        if($this->db->trans_status=false){
            $this->db->trans_roll_back();
            return false;
        }
        else{
            $this->db->trans_commit();
            return $login_data;
        }
    }




    function get_baview(){
        $qry="select ba.id ,c.id as country_id,c.name as county_name,
              s.id as state_id,s.name as state_name,ba.name,
              ba.mobil_no,ba.email,
              ba.company_name,
              ba.office_phno,
              ba.office_email,
              ba.company_location,
               ba.lat,
              ba.lon,
              ba.city
              FROM pl_ba_registration ba
              left join  countries c ON c.id= ba.contry
              left join  states s ON s.id=ba.state where is_del='0'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
        return $data;
    }

    function delete_ba_by_id($id){

        $data=array(
            'is_del'=>"1",

        );

        $qry = $this->db->where('id', $id);
        $qry = $this->db->update('pl_ba_registration', $data);

             $date = date("Y-m-d h:i:sa") ;
            $action = "deleted ba ";
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
        return $qry;

    }
    function get_ba_view_byid($id)
    {

        $qry="select ba.id ,c.id as country_id,c.name as county_name,
              s.id as state_id,s.name as state_name,ba.name,
              ba.mobil_no,ba.email,
              ba.company_name,
              ba.office_phno,
              ba.office_email,
              ba.company_location,
              ba.lat,
              ba.lon,
              ba.city
              FROM pl_ba_registration ba
              left join  countries c ON c.id= ba.contry
              left join  states s ON s.id=ba.state where is_del='0' and ba.id='$id'" ;

        $qry = $this->db->query($qry);
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
        return $data;
    }

    function  edit_ba_by_id()
    {



        $hiddenid=$this->input->post('hiddenid');




        $created_on = date('Y-m-d H:i:s');

        $name=$this->input->post('ba_name');
        $mobile=$this->input->post('ba_mobile');
        $email=$this->input->post('ba_email');
        $company_name=$this->input->post('ba_company_Name');
        $office_phone=$this->input->post('office_phone');
        $office_emailid=$this->input->post('office_email_id');
        $company_location=$this->input->post('company_location');
        $lat=$this->input->post('lat');
        $long=$this->input->post('long');
        $city=$this->input->post('city');
        $country=$this->input->post('sel_country');
        $state=$this->input->post('sel_state');


        $data = array(
            'name' => $name,
            'mobil_no' =>$mobile,
            'email' =>$email,
            'company_name' =>$company_name,
            'office_phno' =>$office_phone,
            'office_email' =>$office_emailid,
            'company_location' =>$company_location,
            'lat' =>$lat,
            'lon' =>$long,
            'city' =>$city,
            'contry' =>$country,
            'state' =>$state,
            'created_on' => $created_on,
            'created_by' => 'admin',


        );
        $this->db->where('id',$hiddenid);
        $query=  $this->db->update('pl_ba_registration',$data);



           $date = date("Y-m-d h:i:sa") ;
            $action = "updated ba ";
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
        return $query;
    }


}
?>