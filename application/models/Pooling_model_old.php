<?php
Class Pooling_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();
    }

    //add desigination
    public function add_designation()
    {
        $datestring = date("Y-m-d h:i:sa");

      
         $data=array
        (
            'designation'=>$this->input->post('Desigination'),
            'description'=>$this->input->post('discription'),
            'sort_order'=>$this->input->post('Sortorder'),
            'group_id'=>$this->input->post('priv_group'),
            'created_on'=>$datestring

        );
       
        $result=$this->db->insert('gp_pl_sales_designation_type',$data);
        $insert_id=$this->db->insert_id();
            $date = date("Y-m-d h:i:sa") ;
            $action = "added designation ";
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);

        return $insert_id;
    }
    // check sort oder of desigination exist or not

    function check_sort_order()
    {
        $id=$this->input->post('Sortorder');
        $qry="select *  from gp_pl_sales_designation_type where sort_order='$id'";
        $result= $this->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->result_array();

        }
        else
        {
            return array();
        }
    }

    function  get_all_desiginations()
    {
        $qry="select gp_des.id,gp_des.designation,gp_des.description,gp_des.sort_order,gp_gpname.group from gp_pl_sales_designation_type gp_des 
             left join gp_privillage_groupname gp_gpname on gp_des.group_id=gp_gpname.id where gp_des.is_del !='1'";
        $result= $this->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->result_array();

        }
        else
        {
            return array();
        }
    }

    function edit_pooling_stage(){

        $this->db->trans_begin();
        $id=$this->input->post('hiddentype');

        // var_dump("hi");
        $datestring = date('d-m-Y h:i:sa');
        $data=array
        (
            'stage_name'=>$this->input->post('stage_name'),
            'description'=>$this->input->post('description'),
            'updated_on'=>$datestring,
        );
        $this->db->where('id',$id);
        $this->db->update('gp_system_pool_stage',$data);


            $action = "update stage";
            $date = date("Y-m-d h:i:sa") ;
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);


        if($this->db->trans_status() == false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }

    }
    //pranav starts

    //add new pool data
    function  add_new_pool_data()
    {
        $this->db->trans_begin();

        $pool_group_name=$this->input->post('pool_name');
        $group_persantage=$this->input->post('allow_persantage');
        $no_of_levels=$this->input->post('no_of_levels');
        $designation=$this->input->post('designation');
        $designation_persantage=$this->input->post('design_allwed_persantage');
        $date= date("Y-m-d h:i:sa");
        $data = array(
            'title' => $pool_group_name,
            'group_persentage' => $group_persantage,
            'no_of_levels' => $no_of_levels,
            'created_on' => $date,
            'created_by' => 'admin',

        );
        $qry = $this->db->insert('gp_pl_pool_group_settings', $data);
        if($qry)
        {
            $insert_id = $this->db->insert_id();
        }

        foreach ($designation as $key => $design) {

            $designation_persantages[] = array(
                'group_id' => $insert_id,
                'designation_type_id' => $design,
                'persentage' => $designation_persantage[$key],

            );
        }

        $ins_qry = $this->db->insert_batch('gp_pl_pool_group_members_settings', $designation_persantages);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }



    }
    //add new pool data
    function  add_new_ba_pool_data()
    {
        $this->db->trans_begin();

        $pool_group_name=$this->input->post('pool_name');
        $group_persantage=$this->input->post('allow_persantage');
        $no_of_levels=$this->input->post('no_of_levels');
        $designation=$this->input->post('designation');
        $designation_persantage=$this->input->post('design_allwed_persantage');
        $date= date("Y-m-d h:i:sa");
        $data = array(
            'title' => $pool_group_name,
            'percentage' => $group_persantage,
            'no_of_levels' => $no_of_levels,
            'created_on' => $date,
            'created_by' => 'admin',

        );
        $qry = $this->db->insert('gp_pl_pool_ba_group_settings', $data);
        if($qry)
        {
            $insert_id = $this->db->insert_id();
        }

        foreach ($designation as $key => $design) {

            $designation_persantages[] = array(
                'bch_grp_id' => $insert_id,
                'designation_type_id' => $design,
                'percentage' => $designation_persantage[$key],

            );
        }

        $ins_qry = $this->db->insert_batch('gp_pl_pool_ba_group_members', $designation_persantages);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }



    }
    //add new pool data
    function  add_new_bch_pool_data()
    {
        $this->db->trans_begin();

        $pool_group_name=$this->input->post('pool_name');
        $group_persantage=$this->input->post('allow_persantage');
        $no_of_levels=$this->input->post('no_of_levels');
        $designation=$this->input->post('designation');
        $designation_persantage=$this->input->post('design_allwed_persantage');
        $date= date("Y-m-d h:i:sa");
        $data = array(
            'title' => $pool_group_name,
            'percentage' => $group_persantage,
            'no_of_levels' => $no_of_levels,
            'created_on' => $date,
            'created_by' => 'admin',
        );
        $qry = $this->db->insert('gp_pl_pool_bch_group_settings', $data);

        if($qry)
        {
            $insert_id = $this->db->insert_id();
        }

        foreach ($designation as $key => $design) {

            $designation_persantages[] = array(
                'bch_grp_id' => $insert_id,
                'designation_type_id' => $design,
                'percentage' => $designation_persantage[$key],

            );
        }

        $ins_qry = $this->db->insert_batch('gp_pl_pool_bch_group_members', $designation_persantages);

        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }



    }
    //add new pool stage data
    function add_new_stage_pool_data()
    {
        $this->db->trans_begin();

        $pool_group_name=$this->input->post('pool_name');
        $group_persantage=$this->input->post('allow_persantage');
        $no_of_levels=$this->input->post('no_of_levels');
        $designation=$this->input->post('designation');
        $designation_persantage=$this->input->post('design_allwed_persantage');
        $date= date("Y-m-d h:i:sa");
        $data = array(
            'title' => $pool_group_name,
            'stage_group_persentage' => $group_persantage,
            'no_of_levels' => $no_of_levels,
            'created_on' => $date,
            'created_by' => 'admin',

        );
        //var_dump($data);
        $qry = $this->db->insert('gp_pl_pool_stage_group_settings', $data);
        if($qry)
        {
            $insert_id = $this->db->insert_id();
        }


        foreach ($designation as $key => $design)
        {

            $designation_persantages[] = array(
                'group_id' => $insert_id,
                'system_pool_stage_id' => $design,
                'persentage' => $designation_persantage[$key],

            );

        }

        $ins_qry = $this->db->insert_batch('gp_pl_pool_stage_members_settings', $designation_persantages);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }



    }
    //add new ba pool stage data
    function add_new_ba_stage_pool_data()
    {
        $this->db->trans_begin();

        $pool_group_name=$this->input->post('pool_name');
        $group_persantage=$this->input->post('allow_persantage');
        $no_of_levels=$this->input->post('no_of_levels');
        $designation=$this->input->post('designation');
        $designation_persantage=$this->input->post('design_allwed_persantage');
        $date= date("Y-m-d h:i:sa");
        $data = array(
            'title' => $pool_group_name,
            'percentage' => $group_persantage,
            'no_of_levels' => $no_of_levels,
            'created_on' => $date,
            'created_by' => 'admin',

        );
        $qry = $this->db->insert('gp_pl_pool_ba_stage_settings', $data);
        if($qry)
        {
            $insert_id = $this->db->insert_id();
        }

        foreach ($designation as $key => $design) {

            $designation_persantages[] = array(
                'bch_stg_id' => $insert_id,
                'designation_type_id' => $design,
                'percentage' => $designation_persantage[$key],

            );
        }

        $ins_qry = $this->db->insert_batch('gp_pl_pool_ba_stage_members', $designation_persantages);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }



    }
    //add new bch pool stage data
    function add_new_bch_stage_pool_data()
    {
        $this->db->trans_begin();

        $pool_group_name=$this->input->post('pool_name');
        $group_persantage=$this->input->post('allow_persantage');
        $no_of_levels=$this->input->post('no_of_levels');
        $designation=$this->input->post('designation');
        $designation_persantage=$this->input->post('design_allwed_persantage');
        $date= date("Y-m-d h:i:sa");
        $data = array(
            'title' => $pool_group_name,
            'percentage' => $group_persantage,
            'no_of_levels' => $no_of_levels,
            'created_on' => $date,
            'created_by' => 'admin',

        );
        $qry = $this->db->insert('gp_pl_pool_bch_stage_settings', $data);
        if($qry)
        {
            $insert_id = $this->db->insert_id();
        }

        foreach ($designation as $key => $design) {

            $designation_persantages[] = array(
                'bch_stg_id' => $insert_id,
                'designation_type_id' => $design,
                'percentage' => $designation_persantage[$key],

            );
        }

        $ins_qry = $this->db->insert_batch('gp_pl_pool_bch_stage_members', $designation_persantages);
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }



    }
    //get the sum of pool group persantage
    function  get_total_group_persantage()
    {
        $qry="SELECT (SELECT COALESCE(SUM(group_persentage),0) FROM gp_pl_pool_group_settings) + (SELECT COALESCE(SUM(stage_group_persentage),0) FROM gp_pl_pool_stage_group_settings) as total_persantage";
        $result=$this->db->query($qry);
        // echo $this->db->last_query();
       //exit;
        if($result->num_rows()>0)
        {
            return  $result->row_array();
        }
        else
        {
            return array();
        }
    }
    //get total ba persantage
    function  get_total_ba_group_persantage()
    {
        $qry="SELECT ((SELECT COALESCE(SUM(percentage),0) FROM gp_pl_pool_ba_group_settings) + (SELECT COALESCE(SUM(percentage),0) FROM gp_pl_pool_ba_stage_settings)+ (select COALESCE(SUM(percentage),0) FROM gp_pl_pool_extra_benefit WHERE id='2')) as total_persantage";
        $result=$this->db->query($qry);
        // echo $this->db->last_query();
        if($result->num_rows()>0)
        {
            return  $result->row_array();
        }
        else
        {
            return array();
        }
    }
    //get total ba persantage
    function  get_total_bch_group_persantage()
    {

        $qry="SELECT ((SELECT COALESCE(SUM(percentage),0) FROM gp_pl_pool_bch_group_settings) + (SELECT COALESCE(SUM(percentage),0) FROM gp_pl_pool_bch_stage_settings)+ (select COALESCE(SUM(percentage),0) FROM gp_pl_pool_extra_benefit WHERE id='1')) as total_persantage";

        $result=$this->db->query($qry);
        // echo $this->db->last_query();
        if($result->num_rows()>0)
        {
            return  $result->row_array();
        }
        else
        {
            return array();
        }
    }
   //system pool group
    function delete_system_pool_group($id)
    {
        $this->db->trans_begin();


        $sql="DELETE FROM `gp_pl_pool_group_settings` WHERE id='$id'";

        $this->db->query($sql);


        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $sql="DELETE FROM `gp_pl_pool_group_members_settings` WHERE `group_id`='$id'";

            $this->db->query($sql);
            $this->db->trans_commit();
            return true;
        }
    }
    //detete system pool group
    function delete_system_ba_pool_group($id)
    {
        $this->db->trans_begin();


        $sql="DELETE FROM `gp_pl_pool_ba_group_settings` WHERE id='$id'";

        $this->db->query($sql);


        if($this->db->trans_status=false)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $sql="DELETE FROM `gp_pl_pool_ba_group_members` WHERE `bch_grp_id`='$id'";

            $this->db->query($sql);
            $this->db->trans_commit();
            return true;
        }
    }
    //detete system pool group
    function delete_system_bch_pool_group($id)
    {
        $this->db->trans_begin();


        $sql="DELETE FROM `gp_pl_pool_bch_group_settings` WHERE id='$id'";

        $this->db->query($sql);


        if($this->db->trans_status=false)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $sql="DELETE FROM `gp_pl_pool_bch_group_members` WHERE `bch_grp_id`='$id'";

            $this->db->query($sql);
            $this->db->trans_commit();
            return true;
        }
    }
    //get all system group pooling data by id
    function  get_all_system_pooing_by_id($id)
    {
        $qry="SELECT gp_pl_pool_group_settings.id as group_id,
        gp_pl_pool_group_settings.title,
        gp_pl_pool_group_settings.group_persentage,
        gp_pl_pool_group_settings.no_of_levels,
        gp_pl_pool_group_members_settings.persentage ,
        gp_pl_sales_designation_type.designation,
        gp_pl_sales_designation_type.sort_order,
        gp_pl_pool_group_members_settings.persentage as member_persantage,
        gp_pl_pool_group_members_settings.id
        FROM gp_pl_pool_group_settings LEFT JOIN
        gp_pl_pool_group_members_settings on
        gp_pl_pool_group_settings.id=gp_pl_pool_group_members_settings.group_id
        LEFT JOIN gp_pl_sales_designation_type
        on gp_pl_pool_group_members_settings.designation_type_id= gp_pl_sales_designation_type.id
        WHERE gp_pl_pool_group_settings.id='$id'";
        $result= $this->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->result_array();

        }
        else
        {
            return array();
        }
    }
    //get all system stage pooling by id
    function  get_all_system_stage_pooing_by_id($id)
    {
        $qry="SELECT gp_pl_pool_stage_group_settings.id as group_id,
        gp_pl_pool_stage_group_settings.title,
        gp_pl_pool_stage_group_settings.stage_group_persentage as group_persentage,
        gp_pl_pool_stage_group_settings.no_of_levels,
        gp_pl_pool_stage_members_settings.persentage ,
        gp_system_pool_stage.stage_name as designation,

        gp_pl_pool_stage_members_settings.persentage as member_persantage,
        gp_pl_pool_stage_members_settings.id
        FROM gp_pl_pool_stage_group_settings LEFT JOIN
        gp_pl_pool_stage_members_settings on
        gp_pl_pool_stage_group_settings.id=gp_pl_pool_stage_members_settings.group_id
        LEFT JOIN gp_system_pool_stage
        on gp_pl_pool_stage_members_settings.system_pool_stage_id= gp_system_pool_stage.id
        WHERE gp_pl_pool_stage_group_settings.id='$id'";
        $result= $this->db->query($qry);
//echo $this->db->last_query();
        if($result->num_rows()>0)
        {
            return $result->result_array();

        }
        else
        {
            return array();
        }
    }
    // get all group pooling data
    function  get_all_group_pooing()
    {
        $qry="select * from gp_pl_pool_group_settings";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return  $result->result_array();
        }
        else
        {
            return array();
        }
    }
    // get all bch group pooling data
    function  get_all_bch_group_pooing()
    {
        $qry="select id,title,percentage as group_persentage,no_of_levels from gp_pl_pool_bch_group_settings";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return  $result->result_array();
        }
        else
        {
            return array();
        }
    }
    // get all ba group pooling data
    function  get_all_ba_group_pooing()
    {
        $qry="select id,title,percentage as group_persentage,no_of_levels from gp_pl_pool_ba_group_settings";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return  $result->result_array();
        }
        else
        {
            return array();
        }
    }
    // get all stage pooling data
    function  get_all_stage_pooing()
    {
        $qry="select id,title,stage_group_persentage as group_persentage,no_of_levels from gp_pl_pool_stage_group_settings";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return  $result->result_array();
        }
        else
        {
            return array();
        }
    }
    // get all stage pooling data
    function  get_all_bch_stage_pooing()
    {
        $qry="select id,title,percentage as group_persentage,no_of_levels from gp_pl_pool_bch_stage_settings";
        $result=$this->db->query($qry);
        //echo $this->db->last_query();
        if($result->num_rows()>0)
        {
            return  $result->result_array();
        }
        else
        {
            return array();
        }
    }
    // get all stage pooling data
    function  get_all_ba_stage_pooing()
    {
        $qry="select id,title,percentage as group_persentage,no_of_levels from gp_pl_pool_ba_stage_settings";
        $result=$this->db->query($qry);

        if($result->num_rows()>0)
        {
            return  $result->result_array();
        }
        else
        {
            return array();
        }
    }
    //add new pool stage
    function add_new_pool_stage()
    {

        $datestring = date('d-m-Y h:i:sa');
        $data=array
        (
            'stage_name'=>$this->input->post('stage_name'),
            'description'=>$this->input->post('discription'),
            'created_on'=>$datestring,
        );

        $this->db->insert('gp_system_pool_stage',$data);
        $insert_id=$this->db->insert_id();

        return $insert_id;

    }
    //get all pooling stages
    function get_all_stages()
    {
        $qry="select * from gp_system_pool_stage";

        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            return $result->result_array();

        }
        else
        {
            return $result->row_array();

        }
    }

    //get all pooling stages custom
    function get_all_stages_custom()
    {
        $qry="select id,stage_name as designation  from gp_system_pool_stage";

        $result=$this->db->query($qry);
        if($result->num_rows()>0)
        {
            return $result->result_array();

        }
        else
        {
            return $result->row_array();

        }
    }
    // add ba main commision
    function  add_ba_commision($val)
    {
        $data=array
        (
            'percentage'=>$val
        );

        $this->db->where('id','2');
        $result= $this->db->update('gp_pl_pool_extra_benefit',$data);
        return $result;

    }

    // add bch main commision
    function  add_bch_commision($val)
    {
        $data=array
        (
            'percentage'=>$val
        );

        $this->db->where('id','1');
        $result= $this->db->update('gp_pl_pool_extra_benefit',$data);
        return $result;

    }
    // get  ba main commision
    function  get_ba_commision()
    {
        $qry="select percentage from gp_pl_pool_extra_benefit where id='2'";
        $result= $this->db->query($qry);
        if($result->num_rows()>0)
        {
            $results=$result->row_array();
        }
        else
        {
            $results=array();
        }

        return $results;
    }

    // get  bch main commision
    function  get_bch_commision()
    {
        $qry="select percentage from gp_pl_pool_extra_benefit where id='1'";
        $result= $this->db->query($qry);
        if($result->num_rows()>0)
        {
            $results=$result->row_array();
        }
        else
        {
            $results=array();
        }

        return $results;
    }

    //pranav ends
    function add_partnertype(){

        $this->db->trans_begin();
        $data=array(
            'title'=>$this->input->post('title'),
            'description'=>$this->input->post('description')
        );
        $this->db->insert('gp_pl_channel_partner_types',$data);


         $action = "added partner type";
            $date = date("Y-m-d h:i:sa") ;
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
        if($this->db->trans_status()==false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }

    function get_partner_type(){
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['user_id'];
        //$qry="select ct.id,ct.title from gp_pl_channel_partner_types ct where ct.is_del='0' order by ct.id desc";
        $qry="select
                typ.title ,typ.id,con.`id` conid,
                typ.`status`
                from
                gp_pl_channel_partner_type_connection con
                left join gp_pl_channel_partner cp on cp.id = con.channel_partner_id
                left join gp_pl_channel_partner_types typ on typ.id = con.channel_partner_type_id ";
               // where con.channel_partner_id='$loginuser'";
        $qry=$this->db->query($qry);
        if($qry){
            $data['type']=$qry->result_array();
        }
        else{
            $data['type']=array();
        }
        return $data;

    }

    function add_new_commission(){

            $this->db->trans_begin();
            $session_data=$this->session->userdata('logged_in_admin');
            $loginuser=$session_data['user_id'];
            $cat_name = $this->input->post('category_name');
            $cat_perc = $this->input->post('category_percent');
            $con_id = $this->input->post('channel_type');
            $sql = "select channel_partner_type_id from gp_pl_channel_partner_type_connection where id = '$con_id'";
            $sql = $this->db->query($sql);
            //echo $this->db->last_query();
            $ct = $sql->row_array();
            $ct = $ct['channel_partner_type_id'];
                $data=array(
                    'channel_partner_type_id' => $ct,
                    'channel_partner_id'=> $loginuser,
                    'channel_partner_con_id'=>$con_id,
                    'pooling_commission'=>$this->input->post('company_commission')
                   
                );
    //  var_dump($data);exit;   
                $this->db->insert('gp_pl_system_commission_settings',$data);
                 //echo $this->db->last_query();
                // $up_commision = array(
                //     'channel_partner_main_commision' => $this->input->post('main_commission')
                //     );
                // $this->db->where('id', $this->input->post('channel_type'));
                // $up_qry = $this->db->update('gp_pl_channel_partner_type_connection', $up_commision);
                
                foreach ($cat_name as $key => $cat) {
                 $product_cat[] = array(
                    'cp_con_id' => $this->input->post('channel_type'),
                    'category_title' => $cat, 
                    'percentage' => $cat_perc[$key] 
                    );
                }
                $this->db->insert_batch('gp_channel_con_cat_commision', $product_cat);
       // echo $this->db->last_query();
                 $action = "added new commision";
            $date = date("Y-m-d h:i:sa") ;
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
            
            $this->db->trans_complete();
            if($this->db->trans_status() == false){
                $this->db->trans_rollback();
                return false;
            }
            else{
                $this->db->trans_commit();
                return true;
            }


    }
    function edit_commision_by_con(){

            $this->db->trans_begin();
            $session_data=$this->session->userdata('logged_in_admin');
            $loginuser=$session_data['id'];
            $cat_name = $this->input->post('category_name');
            $cat_id = $this->input->post('prod_cat_old_id'); 
            $cat_perc = $this->input->post('category_percent');
            $comm_settgs_id = $this->input->post('company_comm_id');
                $data=array(
                    'channel_partner_con_id'=>$this->input->post('channel_type'),
                    'pooling_commission'=>$this->input->post('company_commission')
                   
                );
           // var_dump($this->input->post());exit;    
                $this->db->where('id', $comm_settgs_id);
                $this->db->update('gp_pl_system_commission_settings',$data);
               // echo $this->db->last_query();
                //exit;
                foreach ($cat_name as $key => $cat) {
                 $product_cat = array(
                    'cp_con_id' => $this->input->post('channel_type'),
                    'category_title' => $cat, 
                    'percentage' => $cat_perc[$key] 
                    );

                 $this->db->where('id', $cat_id[$key]);
                 $this->db->update('gp_channel_con_cat_commision', $product_cat);


                  $action = "updated commision ";
            $date = date("Y-m-d h:i:sa") ;
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
                }
                
            
            $this->db->trans_complete();
            if($this->db->trans_status() == false){
                $this->db->trans_rollback();
                return false;
            }
            else{
                $this->db->trans_commit();
                return true;
            }
    }
    function get_all_commision(){
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['user_id'];
        $qry="select types.title title,commi.id,commi.pooling_commission,commi.direct_commission,par.name from gp_pl_system_commission_settings commi
                left join gp_pl_channel_partner_types types on types.id=commi.channel_partner_type_id
                left join gp_pl_channel_partner par on par.id=commi.channel_partner_id
                where commi.channel_partner_id='$loginuser'";

        $query=$this->db->query($qry);
       // echo $this->db->last_query();
       // exit;
        if($query){
            $data['commission']=$query->result_array();
        }
        else{
            $data['commission']=array();
        }
        return $data;
    }

    function delete_commission($id){

    $data=array(
        'is_del'=>"1",

    );

    $qry = $this->db->where('id', $id);
    $qry = $this->db->update('gp_pl_system_commission_settings', $data);


     $action = "delete commission";
            $date = date("Y-m-d h:i:sa") ;
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);
    /// $qury;
    return $qry;

    }

    function edit_commission_byid(){

        $this->db->trans_begin();
        $id=$this->input->post('hiddentype');
        $con_id = $this->input->post('channel_type');
        $sql = "select channel_partner_type_id from gp_pl_channel_partner_type_connection where id = '$con_id'";
        $sql = $this->db->query($sql);
        //echo $this->db->last_query();
        $ct = $sql->row_array();
        $ct = $ct['channel_partner_type_id'];

        $data=array(
            'channel_partner_type_id'=>$ct,
            'pooling_commission'=>$this->input->post('company_commi'),
            'direct_commission'=>$this->input->post('direct_commi'),
        );
        $this->db->where('id',$id);
        $this->db->update('gp_pl_system_commission_settings',$data);
        //echo $this->db->last_query();exit;

         $action = "update commission";
            $date = date("Y-m-d h:i:sa") ;
            $loginsession = $this->session->userdata('logged_in_admin');

            $userid=$loginsession['user_id'];
            $status = 0;

            activity_log($action,$userid,$status,$date);


        if($this->db->trans_status() == false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $this->db->trans_commit();
            return true;
        }

    }

    function effect_cutomer($purch_id)
    {
        $qry = "select
                    noty.id noty_id,
                    noty.channel_partner_conn_id,
                    con.channel_partner_main_commision
                    from
                    gp_purchase_bill_notification noty
                    left join gp_pl_channel_partner_type_connection con on con.id = noty.channel_partner_conn_id
                    where noty.id = '$purch_id'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()> 0)
        {
            return $qry->row_array();
            
        }  else{
          return array();
        }          
    }

      //pranav starts

    //detete system stage  pool group
    function delete_system_stage_pool_group($id)
    {
        $this->db->trans_begin();


        $sql="DELETE FROM `gp_pl_pool_stage_group_settings` WHERE id='$id'";

        $this->db->query($sql);


        if($this->db->trans_status=false){
            $this->db->trans_rollback();
            return false;
        }
        else{
            $sql="DELETE FROM `gp_pl_pool_stage_members_settings` WHERE `group_id`='$id'";

            $this->db->query($sql);
            $this->db->trans_commit();
            return true;
        }
    }

    //detete system stage bch pool group
    function delete_system_stage_bch_pool_group($id)
    {
        $this->db->trans_begin();


        $sql="DELETE FROM `gp_pl_pool_bch_stage_settings` WHERE id='$id'";

        $this->db->query($sql);
       // echo $this->db->last_query();

        if($this->db->trans_status=false)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $sql="DELETE FROM `gp_pl_pool_bch_stage_members` WHERE `bch_stg_id`='$id'";

            $this->db->query($sql);
           // echo $this->db->last_query();
            $this->db->trans_commit();
            return true;
        }
    }

    //detete system pool group
    function delete_system_stage_ba_pool_group($id)
    {
        $this->db->trans_begin();


        $sql="DELETE FROM `gp_pl_pool_ba_stage_settings` WHERE id='$id'";

        $this->db->query($sql);


        if($this->db->trans_status=false)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $sql="DELETE FROM `gp_pl_pool_ba_stage_members` WHERE `bch_stg_id`='$id'";

            $this->db->query($sql);
            $this->db->trans_commit();
            return true;
        }
    }

    //update system poolingg
    function  update_pool_data()
    {
        $this->db->trans_begin();

        $type=$this->input->post('type');
        
        $pool_group_name=$this->input->post('pool_name');
        $id=$this->input->post('id');
        $main_id=$this->input->post('main_id');
       // var_dump($main_id);exit();
        $group_persantage=$this->input->post('allow_persantage');
        $no_of_levels=$this->input->post('no_of_levels');
        $designation=$this->input->post('designation');
        $new_designation=$this->input->post('designation_new');
        $new_designation_persantage=$this->input->post('new_designation_persantage');

        $designation_persantage=$this->input->post('design_allwed_persantage');
        // var_dump($designation);
        //var_dump($designation_persantage);
        //var_dump($new_designation);
        //var_dump($new_designation_persantage);
         $update_id=$this->input->post('allowed_persantage_id');

        $date= date("Y-m-d h:i:sa");
        if($type=='group')
        {

        $data = array
        (
            'title' => $pool_group_name,
            'group_persentage' => $group_persantage,
            'no_of_levels' => $no_of_levels,
            'created_on' => $date,
            'created_by' => 'admin',

        );
        $this->db->where('id',$main_id);

        $qry = $this->db->update('gp_pl_pool_group_settings', $data);
       
        if($qry)
        {
            $insert_id = $main_id;
        }

        foreach ($designation as $key => $design)
        {

             $designation_persantages = array
             (
                'group_id' => $insert_id,
                'designation_type_id' => $design,
                'persentage' => $designation_persantage[$key]
//                'id' => $update_id[$key],

             );
            $this->db->where('id',$update_id[$key]);
            $upd_qry = $this->db->update('gp_pl_pool_group_members_settings', $designation_persantages);
        }
 if($new_designation)
 {

        foreach($new_designation as $key =>  $new_desigination)
        {
            $new_designation_persantages[] = array
            (
                'group_id' => $insert_id,
                'designation_type_id' => $new_desigination,
                'persentage' => $new_designation_persantage[$key]
//                'id' => $update_id[$key],
            );
        }
        $ins_qry = $this->db->insert_batch('gp_pl_pool_group_members_settings', $new_designation_persantages);
    // echo $this->db->last_query();
 }
        else
        {
            
        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
        }
        else if($type=='stage')
        {

            $data = array
            (
                'title' => $pool_group_name,
                'stage_group_persentage' => $group_persantage,
                'no_of_levels' => $no_of_levels,
                'created_on' => $date,
                'created_by' => 'admin',

            );
            $this->db->where('id',$main_id);

            $qry = $this->db->update('gp_pl_pool_stage_group_settings', $data);
            //echo $this->db->last_query();
            if($qry)
            {
                $insert_id = $main_id;
            }

            foreach ($designation as $key => $design)
            {
                //var_dump("update");
                $designation_persantages = array
                (
                    'group_id' => $insert_id,
                    'system_pool_stage_id' => $design,
                    'persentage' => $designation_persantage[$key]

                );
                $this->db->where('id',$update_id[$key]);
                $upd_qry = $this->db->update('gp_pl_pool_stage_members_settings', $designation_persantages);

            }
            if(!empty($new_designation))
            {
              // var_dump("insert");
                foreach($new_designation as $key => $new_desigination)
                {
                    $new_designation_persantages[] = array
                    (
                        'group_id' => $insert_id,
                        'system_pool_stage_id' => $new_desigination,
                        'persentage' => $new_designation_persantage[$key]
//                'id' => $update_id[$key],
                    );
                }
                $ins_qry = $this->db->insert_batch('gp_pl_pool_stage_members_settings', $new_designation_persantages);
                // echo $this->db->last_query();
            }
            else
            {

            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
            else
            {


                $this->db->trans_commit();
                return true;
            }
        }


    }
    //update system poolingg
    function  update_pool_stage_data()
    {
        $this->db->trans_begin();

        $pool_group_name=$this->input->post('pool_name');
        $id=$this->input->post('id');
        $main_id=$this->input->post('main_id');
        $group_persantage=$this->input->post('allow_persantage');
        $no_of_levels=$this->input->post('no_of_levels');
        $designation=$this->input->post('designation');
        $new_designation=$this->input->post('designation_new');
        $new_designation_persantage=$this->input->post('design_allwed_persantage');
        $designation_persantage=$this->input->post('design_allwed_persantage');
        $update_id=$this->input->post('allowed_persantage_id');

        $date= date("Y-m-d h:i:sa");
        $data = array
        (
            'title' => $pool_group_name,
            'group_persentage' => $group_persantage,
            'no_of_levels' => $no_of_levels,
            'created_on' => $date,
            'created_by' => 'admin',

        );
        $this->db->where('id',$main_id);

        $qry = $this->db->update('gp_pl_pool_group_settings', $data);

        if($qry)
        {
            $insert_id = $main_id;
        }

        foreach ($designation as $key => $design)
        {

            $designation_persantages = array
            (
                'group_id' => $insert_id,
                'designation_type_id' => $design,
                'persentage' => $designation_persantage[$key]
//                'id' => $update_id[$key],

            );
            $this->db->where('id',$update_id[$key]);
            $upd_qry = $this->db->update('gp_pl_pool_group_members_settings', $designation_persantages);
        }
        if($new_designation)
        {

            foreach($new_designation as $new_desigination)
            {
                $new_designation_persantages[] = array
                (
                    'group_id' => $insert_id,
                    'designation_type_id' => $new_desigination,
                    'persentage' => $new_designation_persantage[$key]
//                'id' => $update_id[$key],
                );
            }
            $ins_qry = $this->db->insert_batch('gp_pl_pool_group_members_settings', $new_designation_persantages);
            // echo $this->db->last_query();
        }
        else
        {

        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }



    }

    //hridya
    //get all system bch group pooling data by id
    function  get_all_system_bch_pooing_by_id($id)
    {
        $qry="SELECT gp_pl_pool_bch_group_settings.id,
        gp_pl_pool_bch_group_settings.title,
        gp_pl_pool_bch_group_settings.no_of_levels,
        gp_pl_pool_bch_group_settings.percentage as group_persentage,
        gp_pl_sales_designation_type.designation,
        gp_pl_sales_designation_type.sort_order,
        gp_pl_pool_bch_group_members.id,
        gp_pl_pool_bch_group_members.bch_grp_id,
        gp_pl_pool_bch_group_members.designation_type_id,
        gp_pl_pool_bch_group_members.percentage
        FROM gp_pl_pool_bch_group_settings LEFT JOIN
        gp_pl_pool_bch_group_members on
        gp_pl_pool_bch_group_settings.id=gp_pl_pool_bch_group_members.bch_grp_id
        LEFT JOIN gp_pl_sales_designation_type
        on gp_pl_pool_bch_group_members.designation_type_id= gp_pl_sales_designation_type.id
        WHERE gp_pl_pool_bch_group_settings.id='$id'";
        $result= $this->db->query($qry);
       //echo $this->db->last_query();

        if($result->num_rows()>0)
        {
            return $result->result_array();

        }
        else
        {
            return array();
        }
    }

    //update bch  pooling
    function  update_pool_bch_data()
    {
        $this->db->trans_begin();
        $type=$this->input->post('type');



        $pool_group_name=$this->input->post('pool_name');
        $id=$this->input->post('id');
        $main_id=$this->input->post('main_id');
        $group_persantage=$this->input->post('allow_persantage');
        $no_of_levels=$this->input->post('no_of_levels');
        $designation=$this->input->post('designation');
        $new_designation=$this->input->post('designation_new');
        $new_designation_persantage=$this->input->post('design_allwed_persantage_new');
        $designation_persantage=$this->input->post('design_allwed_persantage');
        $update_id=$this->input->post('allowed_persantage_id');

        $date= date("Y-m-d h:i:sa");
        if($type=='group')
        {
        $data = array
        (
            'title' => $pool_group_name,
            'percentage' => $group_persantage,
            'no_of_levels' => $no_of_levels,
            'created_on' => $date,
            'created_by' => 'admin',

        );
        $this->db->where('id',$main_id);

        $qry = $this->db->update('gp_pl_pool_bch_group_settings', $data);

        if($qry)
        {
            $insert_id = $main_id;
        }

        foreach ($designation as $key => $design)
        {

            $designation_persantages = array
            (
                'bch_grp_id' => $insert_id,
                'designation_type_id' => $design,
                'percentage' => $designation_persantage[$key]
//                'id' => $update_id[$key],


            );
            $this->db->where('id',$update_id[$key]);
            $upd_qry = $this->db->update(' gp_pl_pool_bch_group_members', $designation_persantages);
        }
        if($new_designation)
        {
            foreach($new_designation as $new_desigination)
            {
                $new_designation_persantages[] = array
                (
                    'id' => $insert_id,
                    'designation_type_id' => $new_desigination,
                    'percentage' => $new_designation_persantage[$key]
//                'id' => $update_id[$key],
                );
            }
            $ins_qry = $this->db->insert_batch(' gp_pl_pool_bch_group_members', $new_designation_persantages);
        }
        else
        {

        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }

        }
        elseif($type=='stage')
        {
            $data = array
            (
                'title' => $pool_group_name,
                'percentage' => $group_persantage,
                'no_of_levels' => $no_of_levels,
                'created_on' => $date,
                'created_by' => 'admin',

            );
            $this->db->where('id',$main_id);

            $qry = $this->db->update('gp_pl_pool_bch_stage_settings', $data);

            if($qry)
            {
                $insert_id = $main_id;
            }

            foreach ($designation as $key => $design)
            {

                $designation_persantages = array
                (
                    'bch_stg_id' => $insert_id,
                    'designation_type_id' => $design,
                    'percentage' => $designation_persantage[$key]
//                'id' => $update_id[$key],

                );
                $this->db->where('id',$update_id[$key]);
                $upd_qry = $this->db->update('gp_pl_pool_bch_stage_members', $designation_persantages);
            }
            if($new_designation)
            {

                foreach($new_designation as $key => $new_desigination)
                {
                    $new_designation_persantages[] = array
                    (
                        'bch_stg_id' => $insert_id,
                        'designation_type_id' => $new_desigination,
                        'percentage' => $new_designation_persantage[$key]
//                'id' => $update_id[$key],
                    );
                }
                $ins_qry = $this->db->insert_batch('gp_pl_pool_bch_stage_members', $new_designation_persantages);
                // echo $this->db->last_query();
            }
            else
            {

            }

            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE)
            {

                $this->db->trans_rollback();
                return FALSE;
            }
            else
            {

                $this->db->trans_commit();
                return true;
            }
        }


    }



    //get all system ba group pooling data by id
    function  get_all_system_ba_pooing_by_id($id)
    {
        $qry="SELECT gp_pl_pool_ba_group_settings.id,
        gp_pl_pool_ba_group_settings.title,
        gp_pl_pool_ba_group_settings.no_of_levels,
        gp_pl_pool_ba_group_settings.percentage as group_persentage,
        gp_pl_sales_designation_type.designation,
        gp_pl_sales_designation_type.sort_order,
        gp_pl_pool_ba_group_members.id,
        gp_pl_pool_ba_group_members.bch_grp_id,
        gp_pl_pool_ba_group_members.designation_type_id,
        gp_pl_pool_ba_group_members.percentage
        FROM gp_pl_pool_ba_group_settings LEFT JOIN
        gp_pl_pool_ba_group_members on
        gp_pl_pool_ba_group_settings.id=gp_pl_pool_ba_group_members.bch_grp_id
        LEFT JOIN gp_pl_sales_designation_type
        on gp_pl_pool_ba_group_members.designation_type_id= gp_pl_sales_designation_type.id
        WHERE gp_pl_pool_ba_group_settings.id='$id'";
        $result= $this->db->query($qry);
        //echo $this->db->last_query();

        if($result->num_rows()>0)
        {
            return $result->result_array();

        }
        else
        {
            return array();
        }
    }
    //update ba  pooling
    function  update_pool_ba_data()
    {
        $this->db->trans_begin();
        $type=$this->input->post('type');
       // var_dump($type);
        $pool_group_name=$this->input->post('pool_name');
        $id=$this->input->post('id');
        $main_id=$this->input->post('main_id');
        $group_persantage=$this->input->post('allow_persantage');
        $no_of_levels=$this->input->post('no_of_levels');
        $designation=$this->input->post('designation');
        $new_designation=$this->input->post('designation_new');
        $new_designation_persantage=$this->input->post('new_designation_persantage');
        $designation_persantage=$this->input->post('design_allwed_persantage');
        $update_id=$this->input->post('allowed_persantage_id');

        $date= date("Y-m-d h:i:sa");
        if($type=='group')
        {
        $data = array
        (
            'title' => $pool_group_name,
            'percentage' => $group_persantage,
            'no_of_levels' => $no_of_levels,
            'created_on' => $date,
            'created_by' => 'admin',

        );
        $this->db->where('id',$main_id);

        $qry = $this->db->update('gp_pl_pool_ba_group_settings', $data);


        if($qry)
        {
            $insert_id = $main_id;
        }

        foreach ($designation as $key => $design)
        {

            $designation_persantages = array
            (
                'bch_grp_id' => $insert_id,
                'designation_type_id' => $design,
                'percentage' => $designation_persantage[$key]
//                'id' => $update_id[$key],


            );
            $this->db->where('id',$update_id[$key]);
            $upd_qry = $this->db->update(' gp_pl_pool_ba_group_members', $designation_persantages);
        }
        if($new_designation)
        {
            foreach($new_designation as $key => $new_desigination)
            {
                $new_designation_persantages[] = array
                (
                    'bch_grp_id' => $insert_id,
                    'designation_type_id' => $new_desigination,
                    'percentage' => $new_designation_persantage[$key]
//                'id' => $update_id[$key],
                );
            }
            $ins_qry = $this->db->insert_batch(' gp_pl_pool_ba_group_members', $new_designation_persantages);
        }
        else
        {

        }
        $this->db->trans_complete();
        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return FALSE;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }


        }
        elseif($type=='stage')
        {
            $data = array
            (
                'title' => $pool_group_name,
                'percentage' => $group_persantage,
                'no_of_levels' => $no_of_levels,
                'created_on' => $date,
                'created_by' => 'admin',

            );
            $this->db->where('id',$main_id);

            $qry = $this->db->update('gp_pl_pool_ba_stage_settings', $data);

            if($qry)
            {
                $insert_id = $main_id;
            }

            foreach ($designation as $key => $design)
            {

                $designation_persantages = array
                (
                    'bch_stg_id' => $insert_id,
                    'designation_type_id' => $design,
                    'percentage' => $designation_persantage[$key]
//                'id' => $update_id[$key],

                );
                $this->db->where('id',$update_id[$key]);
                $upd_qry = $this->db->update('gp_pl_pool_ba_stage_members', $designation_persantages);
            }
            if($new_designation)
            {

                foreach($new_designation as $key => $new_desigination)
                {
                    $new_designation_persantages[] = array
                    (
                        'bch_stg_id' => $insert_id,
                        'designation_type_id' => $new_desigination,
                        'percentage' => $new_designation_persantage[$key]
//                'id' => $update_id[$key],
                    );
                }
                $ins_qry = $this->db->insert_batch('gp_pl_pool_ba_stage_members', $new_designation_persantages);
                // echo $this->db->last_query();
            }
            else
            {

            }
            $this->db->trans_complete();
            if ($this->db->trans_status() === FALSE)
            {
                $this->db->trans_rollback();
                return FALSE;
            }
            else
            {
                $this->db->trans_commit();
                return true;
            }
        }


    }
    //get all system  bch stage pooling by id
    function  get_all_system_bch_stage_pooing_by_id($id)
    {

        $qry="SELECT gp_pl_pool_bch_stage_settings.id as group_id,
        gp_pl_pool_bch_stage_settings.title,
        gp_pl_pool_bch_stage_settings.percentage as group_persentage,
        gp_pl_pool_bch_stage_settings.no_of_levels,
        gp_pl_pool_bch_stage_members.percentage ,
        gp_system_pool_stage.stage_name as designation,

        gp_pl_pool_bch_stage_members.percentage as member_persantage,
        gp_pl_pool_bch_stage_members.id
        FROM gp_pl_pool_bch_stage_settings LEFT JOIN
        gp_pl_pool_bch_stage_members on
        gp_pl_pool_bch_stage_settings.id=gp_pl_pool_bch_stage_members.bch_stg_id
        LEFT JOIN gp_system_pool_stage
        on gp_pl_pool_bch_stage_members.bch_stg_id= gp_system_pool_stage.id
        WHERE gp_pl_pool_bch_stage_settings.id='$id'";
        $result= $this->db->query($qry);

       // echo $this->db->last_query();

        if($result->num_rows()>0)
        {
            return $result->result_array();

        }
        else
        {
            return array();
        }
    }
    //get all system  bch stage pooling by id
    function  get_all_system_ba_stage_pooing_by_id($id)
    {

        $qry="SELECT gp_pl_pool_ba_stage_settings.id as group_id,
        gp_pl_pool_ba_stage_settings.title,
        gp_pl_pool_ba_stage_settings.percentage as group_persentage,
        gp_pl_pool_ba_stage_settings.no_of_levels,
        gp_pl_pool_ba_stage_members.percentage ,
        gp_system_pool_stage.stage_name as designation,

        gp_pl_pool_ba_stage_members.percentage as member_persantage,
        gp_pl_pool_ba_stage_members.id
        FROM gp_pl_pool_ba_stage_settings LEFT JOIN
        gp_pl_pool_ba_stage_members on
        gp_pl_pool_ba_stage_settings.id=gp_pl_pool_ba_stage_members.bch_stg_id
        LEFT JOIN gp_system_pool_stage
        on gp_pl_pool_ba_stage_members.bch_stg_id= gp_system_pool_stage.id
        WHERE gp_pl_pool_ba_stage_settings.id='$id'";
        $result= $this->db->query($qry);

        //echo $this->db->last_query();

        if($result->num_rows()>0)
        {
            return $result->result_array();

        }
        else
        {
            return array();
        }
    }


    function delete_system_stage_pooling_group($id)
    {
        $type=$this->input->post('type');

       if($type=='stage')

       {
           $sql="DELETE FROM `gp_pl_pool_stage_members_settings` WHERE id='$id'";

           $result= $this->db->query($sql);

           return $result;
       }

         elseif($type=='group')
        {
            $sql1="DELETE FROM `gp_pl_pool_group_members_settings` WHERE id='$id'";

            $result= $this->db->query($sql1);

            return $result;
        }


    }
    function delete_system_stage_bch_pooling_group($id)
    {



        $type=$this->input->post('type');

        if($type=='stage')

        {
        $sql="DELETE FROM `gp_pl_pool_bch_stage_members` WHERE id='$id'";
            $result= $this->db->query($sql);

            return $result;
        }
        elseif($type=='group')
        {
            $sql1="DELETE FROM `gp_pl_pool_bch_group_members` WHERE id='$id'";

            $result= $this->db->query($sql1);

            return $result;
        }


    }
    function delete_system_stage_ba_pooling_group($id)
    {



        $type=$this->input->post('type');

        if($type=='stage')

        {
            $sql="DELETE FROM `gp_pl_pool_ba_stage_members` WHERE id='$id'";
            $result= $this->db->query($sql);

            return $result;
        }
        elseif($type=='group')
        {
            $sql1="DELETE FROM `gp_pl_pool_ba_group_members` WHERE id='$id'";

            $result= $this->db->query($sql1);

            return $result;
        }


    }




}
?>