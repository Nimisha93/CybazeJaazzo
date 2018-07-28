<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

     function has_role($role){

         $ci =& get_instance();

         //load databse library
         $ci->load->database();
         $ci->load->library('session');
         $sesson_array=  $ci->session->userdata('logged_in_admin');
         $userid = $sesson_array['id'];
         $module_userid = $sesson_array['user_id'];
         $az=$userid;
         //$a='+'; echo $userid,$a,$module_userid; exit();

        //To check whether the user is super admin
        $qry =  $ci->db->select('type')
                ->where('id' , $userid)
                ->get('gp_login_table');
        if($qry && $qry->num_rows()>0){

            $res = $qry->row_array();
            if($res['type'] == 'super_admin'){

//            $querys = "select  priv.id,priv.privilege,priv.slug from gp_privileges priv order by priv.id desc";
//            $query=$ci->db->query($querys);

           return true;
            }
            if($res['type'] == 'module'){
            
            

        $querys =   "SELECT priv.id,priv.privilege,priv.slug FROM gp_login_table logg
                    LEFT JOIN gp_permission_module modu on modu.id=logg.user_id
                    LEFT JOIN gp_user_privileges up on up.group_id=modu.privillage_group
                    LEFT JOIN gp_privileges priv on priv.id=up.privilege_id
                    where logg.id='$userid' and priv.slug='$role'";

                    $query=$ci->db->query($querys);
            //print_r($querys); exit();
        if($query && $query->num_rows()>0)
                {
                // echo "aaaa"; exit();
                return true;
                }
        else{
            // echo "bbbb"; exit();
                return false;
                // echo "false"; exit();
            }
        }
             if($res['type'] == 'executive'){

                    $querys = "select priv.id,priv.privilege,priv.slug 
                    from gp_login_table logg 
                    left join gp_pl_sales_team_members mem on mem.id=logg.user_id 
                    left join gp_pl_sales_designation_type types on types.id=mem.sales_desig_type_id 
                    left join gp_user_privileges users on users.id=types.group_id 
                    left join gp_privileges priv on priv.id=users.privilege_id where logg.id='$userid' and priv.slug='$role'";
                $query=$ci->db->query($querys);
                // echo $ci->db->last_query();exit();
                if($query && $query->num_rows()>0){
                    return true;
                }
                else{
                    return false;
                    // echo "false"; exit();
                }
            }
                            // select priv.id,priv.privilege,priv.slug from gp_login_table logg
                            // left join gp_pl_sales_team_members mem on mem.id=logg.id
                            // left join gp_pl_sales_designation_type types on types.id=mem.sales_desig_type_id
                            // LEFT JOIN gp_user_privileges users on users.id=types.group_id
                            // left join gp_privileges priv on priv.id=users.privilege_id
                            // where mem.id='$module_userid' and priv.slug='$role'

    // select priv.id,priv.privilege,priv.slug 
    // from gp_login_table logg left join gp_pl_sales_team_members mem on mem.id=logg.user_id 
    // left join gp_pl_sales_designation_type types on types.id=mem.sales_desig_type_id 
    // left join gp_user_privileges users on users.id=types.group_id 
    // left join gp_privileges priv on priv.id=users.privilege_id where logg.id='104' 

    }
    }


    function has_priv($role){

         $ci =& get_instance();

         //load databse library
         $ci->load->database();
         $ci->load->library('session');


         $datas=getLoginDetails();
      //  echo json_encode($datas);exit();
           if($datas){
            $type = $datas['type'];


             $userid = $datas['id'];
         $module_userid = $datas['user_id'];

         // if($datas['desig'])
         // {
                  $module_type_id = $datas['desig'];
          // }

         $az=$userid;
        } 
        // else{
        //     $module_type_id=0;
        // }

         // $sesson_array=  $ci->session->userdata('logged_in_admin');
         // $userid = $sesson_array['id'];
         // $module_userid = $sesson_array['user_id'];
         //          $module_type_id = $sesson_array['desig'];

         // $az=$userid;
         //$a='+'; echo $userid,$a,$module_userid; exit();

        //To check whether the user is super admin
        $qry =  $ci->db->select('type')
                ->where('id' , $userid)
                ->get('gp_login_table');
        if($qry && $qry->num_rows()>0){

            $res = $qry->row_array();
            if($res['type'] == 'super_admin'){

//            $querys = "select  priv.id,priv.privilege,priv.slug from gp_privileges priv order by priv.id desc";
//            $query=$ci->db->query($querys);

           return true;
            }
            else if($res['type'] == 'Employee'){
            
            

         $querys =   "SELECT priv.id,priv.privilege,priv.slug FROM gp_login_table logg
                    -- LEFT JOIN hr_employee emp on emp.id=logg.user_id
                    LEFT JOIN gp_privilege_user up on up.user_id=logg.user_id
                    LEFT JOIN gp_privilege_group_con gc on gc.group_id=up.group_id
                    LEFT JOIN gp_privileges priv on priv.id=gc.privilege_id
                    where logg.id='$userid' and priv.slug='$role'";

                    $query=$ci->db->query($querys);
            //print_r($querys); exit();
        if($query && $query->num_rows()>0)
                {
                // echo "aaaa"; exit();
                return true;
                }
        else{
            // echo "bbbb"; exit();
                return false;
                // echo "false"; exit();
            }
        }
             else{

                    $querys = "select priv.id,priv.privilege,priv.slug 
                    from gp_privilege_design_user gp 
                    left join gp_privilege_group_con mem on mem.group_id=gp.group_id 
                 
                    left join gp_privileges priv on priv.id=mem.privilege_id 
                    where gp.desig_type_id='$module_type_id' and priv.slug='$role'";
                $query=$ci->db->query($querys);
                // echo $ci->db->last_query();exit();
                if($query && $query->num_rows()>0){
                    return true;
                }
                else{
                    return false;
                    // echo "false"; exit();
                }
            }
                            // select priv.id,priv.privilege,priv.slug from gp_login_table logg
                            // left join gp_pl_sales_team_members mem on mem.id=logg.id
                            // left join gp_pl_sales_designation_type types on types.id=mem.sales_desig_type_id
                            // LEFT JOIN gp_user_privileges users on users.id=types.group_id
                            // left join gp_privileges priv on priv.id=users.privilege_id
                            // where mem.id='$module_userid' and priv.slug='$role'

    // select priv.id,priv.privilege,priv.slug 
    // from gp_login_table logg left join gp_pl_sales_team_members mem on mem.id=logg.user_id 
    // left join gp_pl_sales_designation_type types on types.id=mem.sales_desig_type_id 
    // left join gp_user_privileges users on users.id=types.group_id 
    // left join gp_privileges priv on priv.id=users.privilege_id where logg.id='104' 

    }
    }
    function check_privilage($slug,$id){
        $ci =& get_instance();
        $ci->load->database();
        $qry="SELECT grp.slug FROM gp_login_table logg
                    LEFT JOIN gp_privilege_user up on up.user_id=logg.user_id
                    LEFT JOIN gp_privilege_group_con gc on gc.group_id=up.group_id
                    LEFT JOIN gp_privilege_group grp on gc.group_id=grp.id
                    where logg.id='$id' and grp.slug='$slug'  group by  grp.id";
        $result= $ci->db->query($qry);

        if($result->num_rows()>0)
        {
            return true;
        }else{
            return false;
        }
    }
    function get_emp_det_by_id($id){
        $ci =& get_instance();
        $ci->load->database();
        $qry="select e.id, e.name, e.address, e.email, e.join_date,e.dob,e.basic_salary, e.designation,ds.title as desig,br.branch, sal.salary from hr_employee e 
                left join hr_department d on d.id = e.department 
                left join hr_designation ds on ds.id = e.designation 
                left join hr_branch br on br.id=ds.branch_id
                left join hr_salary sal on sal.employee_id = e.id and sal.active = 1
                where e.id = '$id'";
        $result= $ci->db->query($qry);

        if($result->num_rows()>0)
        {
            return $result->row_array();
        }else{
            return array();
        }
    }