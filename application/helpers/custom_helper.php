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
                    from gp_login_table logg left join gp_pl_sales_team_members mem on mem.id=logg.user_id 
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