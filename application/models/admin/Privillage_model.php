
<?php
Class Privillage_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();
    }
    /* module3*/
    function get_privillage(){
        $qry="select * from gp_privileges order by id asc";
        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['privi']=$query->result_array();
        }
        else{
            $data['privi']=array();
        }
        return $data;
    }

//    function add_privillage(){
//
//        $access_perm=$this->input->post('access_perm');
//        $allow_perm=$this->input->post('allow_perm');
//        $cur_date=date('Y-m-d H:i:s');
//        $groupdata=array(
//            'group'=>$this->input->post('group_name'),
//            'created_on'=>$cur_date
//        );
//        $this->db->insert('gp_privillage_groupname',$groupdata);
//        $insert_gid=$this->db->insert_id();
//
//        foreach($access_perm  as $access){
//            $data=array(
//                'privilege_id'=>$access,
//                'group_id'=>$insert_gid,
//                'created_on'=>$cur_date
//            );
//            $this->db->insert('gp_user_privileges',$data);
//            $insert_accessid=$this->db->insert_id();
//
//            foreach($allow_perm as $allow){
//                if($allow==$access){
//                    $allowdata=array(
//                        'access_per_id'=>"1",
//                        'updated_on'=>$cur_date
//                    );
//                    $this->db->where('id',$insert_accessid);
//                    $this->db->update('gp_user_privileges',$allowdata);
//                }
//
//
//        }
//
//        }
//
//        return true;
//    }



    function add_privillage(){

        $this->db->trans_begin();

        $access_perm=$this->input->post('access_perm');
        $allow_perm=$this->input->post('allow_perm');
        $cur_date=date('Y-m-d H:i:s');
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['id'];

        $groupdata=array(
            'group'=>$this->input->post('group_name'),
            'created_by'=>$loginuser,
            'created_on'=>$cur_date
        );
        $this->db->insert('gp_privillage_groupname',$groupdata);
        $insert_gid=$this->db->insert_id();

        foreach($access_perm  as $access){
            $data=array(
                'privilege_id'=>$access,
                'group_id'=>$insert_gid,
                'created_on'=>$cur_date
            );
            $this->db->insert('gp_user_privileges',$data);

        }
            foreach($allow_perm as $allow){
                    $allowdata=array(
                        'group_id'=>$insert_gid,
                        'privilege_id'=>$allow,
                        'created_on'=>$cur_date
                    );
                $this->db->insert('gp_allow_permission',$allowdata);


                  $action = "added privillage ";
                  $loginsession = $this->session->userdata('logged_in_admin');

                  $userid=$loginsession['id'];
                  $status = 0;
                  $date = date('Y-m-d H:i:s');
               activity_log($action,$userid,$status,$date);

            }
            $this->db->trans_complete();
                if($this->db->trans_status()===false){
                    $this->db->trans_rollback();
                }
                else{
                    $this->db->trans_commit();
                    return true;
                }

    }

    function get_groupname(){
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['id'];
        $qry="select grop.id,grop.group from gp_privillage_groupname grop where grop.created_by='$loginuser' and is_del!='1'order by grop.id asc";
        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['name']=$query->result_array();
        }
        else{
            $data['name']=array();
        }
        return $data;
    }

    function get_user_groupname(){
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['user_id'];
        $qry="select grp.id,grp.`group` from gp_permission_module pmod

                left join gp_login_table logg on logg.user_id=pmod.id

                left join gp_privillage_groupname grp on grp.id=pmod.privillage_group

                where logg.user_id='$loginuser'

                 order by grp.id asc";

        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['name']=$query->result_array();
        }
        else{
            $data['name']=array();
        }
        return $data;
    }

    function set_modulle_privillage(){
        $this->db->trans_begin();
        $this->load->helper('string');
        $autopass= random_string('alnum',5);
        $cur_date=date('Y-m-d H:i:s');
        $email=$this->input->post('email');
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['id'];
        $header_module=$this->input->post('header_module') == '' ? 0:1;
        $module_content=$this->input->post('module_content') == '' ? 0:1;
        $data=array(
            'module_name'=>$this->input->post('module'),
            'description'=>$this->input->post('module_descp'),
            'header_module'=>$header_module,
            'module_content_div'=>$module_content,
            'privillage_group'=>$this->input->post('group_name'),
            'image'=>$this->input->post('images'),
            'email'=>$this->input->post('email'),
            'created_on'=>$cur_date,
            'created_by'=>$loginuser
        );
        $this->db->insert('gp_permission_module',$data);
        $insert_id=$this->db->insert_id();
        $logindata=array(
            'password'=>$autopass,
            'email'=>$this->input->post('email'),
            'type'=>"module",
            'user_id'=>$insert_id
        );
        $this->db->insert('gp_login_table',$logindata);
        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
        }
        else{
            $this->db->trans_commit();
            $loggn = array('username' => $email,
                'password' => $autopass
            );
            $data['log_data'] = $loggn;
        }
        return $data;

    }

    function get_user_privillage(){
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['user_id'];
        $qry="select priv.privilege,priv.id,priv.slug from gp_permission_module pmod

                    left join gp_login_table logg on logg.user_id=pmod.id

                    left join gp_privillage_groupname grp on grp.id=pmod.privillage_group

                    left join gp_user_privileges alow on alow.group_id=pmod.privillage_group

                    left join gp_privileges priv on priv.id=alow.privilege_id

                    where logg.user_id='$loginuser'
                        ";

        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['privi']=$query->result_array();
        }
        else{
            $data['privi']=array();
        }
        return $data;
    }

    function get_user_allow_privillage(){
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['user_id'];
                $qry="select priv.privilege,priv.id,priv.slug from gp_permission_module pmod

                    left join gp_login_table logg on logg.user_id=pmod.id

                    left join gp_privillage_groupname grp on grp.id=pmod.privillage_group

                    left join gp_allow_permission alow on alow.group_id=pmod.privillage_group

                    left join gp_privileges priv on priv.id=alow.privilege_id

                    where logg.user_id='$loginuser'

                        ";

        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['privi']=$query->result_array();
        }
        else{
            $data['privi']=array();
        }
        return $data;
    }


    function set_module_userprivillage(){
        $this->db->trans_begin();
        $access_perm=$this->input->post('access_perm');
        $allow_perm=$this->input->post('allow_perm');
        $cur_date=date('Y-m-d H:i:s');
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['id'];
        $groupdata=array(
            'group'=>$this->input->post('user_name'),
            'created_by'=>$loginuser,
            'created_on'=>$cur_date
        );
        $this->db->insert('gp_privillage_groupname',$groupdata);
        $insert_gid=$this->db->insert_id();

        foreach($access_perm  as $access){
            $data=array(
                'privilege_id'=>$access,
                'group_id'=>$insert_gid,
                'created_on'=>$cur_date
            );
            $this->db->insert('gp_user_privileges',$data);

        }
        foreach($allow_perm as $allow){
            $allowdata=array(
                'group_id'=>$insert_gid,
                'privilege_id'=>$allow,
                'created_on'=>$cur_date
            );
            $this->db->insert('gp_allow_permission',$allowdata);

        }
        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }

    function set_usermodulle_privillage(){
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['id'];
        $this->db->trans_begin();
        $this->load->helper('string');
        $autopass= random_string('alnum',5);
        $cur_date=date('Y-m-d H:i:s');
        $email=$this->input->post('email');
        $data=array(
            'module_name'=>$this->input->post('module'),
            'description'=>$this->input->post('module_descp'),
            'privillage_group'=>$this->input->post('group_name'),
            'email'=>$this->input->post('email'),
            'created_by'=>$loginuser,
            'created_on'=>$cur_date
        );
        $this->db->insert('gp_permission_module',$data);
        $insert_id=$this->db->insert_id();
        $logindata=array(
            'password'=>$autopass,
            'email'=>$this->input->post('email'),
            'type'=>"module",
            'user_id'=>$insert_id
        );
        $this->db->insert('gp_login_table',$logindata);
        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
        }
        else{
            $this->db->trans_commit();
            $loggn = array('username' => $email,
                'password' => $autopass
            );
            $data['log_data'] = $loggn;
        }
        return $data;
    }


    function get_group_list(){
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['id'];

        $qry="select * from gp_privillage_groupname grop where grop.created_by='$loginuser' and is_del!='1'";
        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['grp']=$query->result_array();
        }
        else{
            $data['grp']=array();
        }
        return $data;
    }

    function delete_groupbyid($grpid){
        $data=array(
            'is_del'=>"1"

        );
        $this->db->where ('id',$grpid);
        $this->db->update('gp_privillage_groupname',$data);

                    $date = date("Y-m-d h:i:sa") ;

                  $action = "deleted group ";
                  $loginsession = $this->session->userdata('logged_in_admin');

                  $userid=$loginsession['user_id'];
                  $status = 0;

               activity_log($action,$userid,$status,$date);

        return true;

    }



    function get_all_privillege(){
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['user_id'];
        $type=$session_data['type'];
        if($type=='super_admin'){
            $qry="select * from gp_privileges priv order by priv.id asc";
        }
        else{
        $qry="select priv.id,priv.privilege,priv.slug from gp_permission_module modu

                left join gp_user_privileges users on users.group_id=modu.privillage_group

                left join gp_privileges priv on priv.id=users.privilege_id

                where modu.id='$loginuser'";
        }
        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['priv']=$query->result_array();
        }
        else{
            $data['priv']=array();
        }
        $alowqry="select priv.id,priv.privilege,priv.slug from gp_permission_module modu

                    left join gp_allow_permission users on users.group_id=modu.privillage_group

                    left join gp_privileges priv on priv.id=users.privilege_id

                    where modu.id='$loginuser'";
        $alow_query=$this->db->query($alowqry);
        if($alow_query->num_rows()>0){
            $data['alowpriv']=$alow_query->result_array();
        }
        else{
            $data['alowpriv']=array();
        }

        return $data;

    }


    function get_privillege_by_group($id){
        $qry="select grp.id,grp.`group` from gp_privillage_groupname grp where grp.id='$id' ";

        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['grp']=$query->row_array();
        }
        else{
            $data['grp']=array();
        }

            $alowqry="select

            priv.id,priv.privilege,priv.slug

            from gp_allow_permission perm

            left join gp_privileges priv on priv.id=perm.privilege_id

            where perm.group_id='$id'";

            $alowquery=$this->db->query($alowqry);

            if($alowquery->num_rows()>0){
                $data['alow']=$alowquery->result_array();
            }
            else{
                $data['alow']=array();
            }

            $accesqry="
             select

            priv.id,priv.privilege,priv.slug

            from gp_user_privileges perm

            left join gp_privileges priv on priv.id=perm.privilege_id

            where perm.group_id='$id'";
            $accessquery=$this->db->query($accesqry);

            if($accessquery->num_rows()>0){
                $data['access']=$accessquery->result_array();
            }
            else{
                $data['access']=array();
            }



        return $data;
    }

    function edit_privillages_by_group($id){

        $this->db->trans_begin();
        $access_perm=$this->input->post('access_perm_edit');
        $cur_date=date('Y-m-d H:i:s');

        $all_priv="select * from gp_user_privileges user where user.group_id='$id'";
        $res=$this->db->query($all_priv);
        $res_array=$res->result_array();
        $ary['not_sel']=array();
        foreach($access_perm  as $access){
            if (in_array($access, $res_array))
            {
                echo "Match found";
            }
            else
            {
                array_push($ary['not_sel'], $access);
//                print_r($ary);
            }

        }

        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
        }
        else{
            $this->db->trans_commit();
            return $ary;
        }

    }

    function edit_add_privillages($id){

        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['id'];
        $this->db->trans_begin();
        $this->load->helper('string');
        $autopass= random_string('alnum',5);
        $cur_date=date('Y-m-d H:i:s');
        $access_perm=$this->input->post('access_perm');
        $allow_perm=$this->input->post('allow_perm');
        foreach($access_perm  as $access){
        $access_data=array(
            'group_id'=>$id,
            'privilege_id'=>$access,
            'created_by'=>$loginuser,
            'created_on'=>$cur_date
        );
        $this->db->insert('gp_user_privileges',$access_data);
        }

        foreach($allow_perm  as $allow){
            $allow_data=array(
                'group_id'=>$id,
                'privilege_id'=>$allow,
                'created_by'=>$loginuser,
                'created_on'=>$cur_date
            );
            $this->db->insert('gp_allow_permission',$allow_data);

                   $date = date("Y-m-d h:i:sa") ;
                   $action = "update privillage ";
                   $loginsession = $this->session->userdata('logged_in_admin');

                  $userid=$loginsession['user_id'];
                  $status = 0;

               activity_log($action,$userid,$status,$date);

        }



        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
        }
        else{
            $this->db->trans_commit();
            return true;
        }
    }

    function get_module_by_admin(){
        $session_data=$this->session->userdata('logged_in_admin');
        $loginuser=$session_data['id'];
        $type=$session_data['type'];

            $qry="select modu.*,modu.id modid,grp.id grpid,grp.`group` grpname from  gp_permission_module modu

                 left join gp_privillage_groupname  grp on grp.id=modu.privillage_group

                 where modu.created_by='$loginuser' and modu.is_del='0'";

        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['mod']=$query->result_array();
        }
        else{
            $data['mod']=array();
        }
        return $data;
    }

    function get_moduleview_byid($id){

        $qry="select modu.*,modu.id modid,grp.id grpid,grp.`group` grpname from  gp_permission_module modu

                 left join gp_privillage_groupname  grp on grp.id=modu.privillage_group

                 where modu.id='$id'";


        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['mod']=$query->row_array();
        }
        else{
            $data['mod']=array();
        }
        return $data;
    }
    function edit_module_byid($id){
        $cur_date=date('Y-m-d H:i:s');
        $data=array(
            'module_name'=>$this->input->post('module'),
            'description'=>$this->input->post('module_descp'),
            'header_module'=>$this->input->post('header_module'),
            'module_content_div'=>$this->input->post('module_content'),
            'privillage_group'=>$this->input->post('group_name'),
            'email'=>$this->input->post('email'),
            'image'=>$this->input->post('images'),
            'updated_on'=>$cur_date
        );
        $this->db->where('id',$id);
        $this->db->update('gp_permission_module',$data);
        $date = date("Y-m-d h:i:sa") ;
                   $action = "update module ";
                   $loginsession = $this->session->userdata('logged_in_admin');

                  $userid=$loginsession['user_id'];
                  $status = 0;

               activity_log($action,$userid,$status,$date);

       
        return true;
 }
 

    function delete_modulebyid($modid){
        $data=array(
            'is_del'=>"1"

        );
        $this->db->where ('id',$modid);
        $this->db->update('gp_permission_module',$data);
                 $date = date("Y-m-d h:i:sa") ;
                   $action = "delete module ";
                   $loginsession = $this->session->userdata('logged_in_admin');

                  $userid=$loginsession['user_id'];
                  $status = 0;

               activity_log($action,$userid,$status,$date);

        
        return true;

    }
    function check_group_exisits($group)
    {

        $qry = "select * from gp_privillage_groupname grp where grp.`group` = '$group'";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return FALSE;
        } else
        {
            return TRUE;
        }
    }

    /*end*/
}
?>
