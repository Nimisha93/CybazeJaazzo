<?php
Class Privillages_model extends CI_Model{

    function __construct(){
        parent:: __construct();
        $this->load->database();
    }
    function get_all_privillages_count($search)
    {
       


                  if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (gu.id LIKE '%$keyword%' OR gp.title LIKE '%$keyword%' OR emp.name LIKE '%$keyword%' ) AND gu.id IS NOT NULL ";
        }else{
            $where = '';
        }
       
        $query="select gu.*,emp.name as employee,gp.title as group_name
         from gp_privilege_user gu
        left join gp_privilege_group gp on gp.id=gu.group_id
        left join hr_employee emp on emp.id=gu.user_id


        ".$where." GROUP BY gu.group_id ORDER BY gu.id DESC";
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else{
            return false;
        }
    }

    function get_all_member_count($search)
    {

                  if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (gu.id LIKE '%$keyword%' OR gp.title LIKE '%$keyword%' OR emp.name LIKE '%$keyword%' ) AND gu.id IS NOT NULL ";
        }else{
            $where = '';
        }
       
        $query="select gu.*,emp.name as employee,gp.title as group_name
         from gp_privilege_user gu
        left join gp_privilege_group gp on gp.id=gu.group_id
        left join hr_employee emp on emp.id=gu.user_id


        ".$where." GROUP BY gu.group_id ORDER BY gu.id DESC";
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else{
            return false;
        }
    }

    function get_all_desg_member_count($search)
    {

       
                  if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (gu.id LIKE '%$keyword%' OR gp.title LIKE '%$keyword%' OR emp.designation LIKE '%$keyword%' ) AND gu.id IS NOT NULL ";
        }else{
            $where = '';
        }
       
        $query="select gu.*,emp.designation as employee,gp.title as group_name
         from gp_privilege_design_user gu
        left join gp_privilege_group gp on gp.id=gu.group_id
        left join gp_pl_sales_designation_type emp on emp.id=gu.desig_type_id


        ".$where." GROUP BY gu.group_id ORDER BY gu.id DESC";
        $result=$this->db->query($query);
        if($result->num_rows()>0)
        {
            return $result->num_rows();
        }else{
            return false;
        } 
    }
    function get_all_privillages($search,$limit=NULL,$start=NULL)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (pg.id LIKE '%$keyword%' OR pg.slug LIKE '%$keyword%' OR pg.title LIKE '%$keyword%' OR ep.title LIKE '%$keyword%') AND ep.id IS NOT NULL ";
        }else{
            $where = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="SELECT pg.*, GROUP_CONCAT(ep.privilege) as privileges from gp_privilege_group_con epgc 
                INNER join gp_privileges ep on epgc.privilege_id = ep.id 
                INNER join gp_privilege_group pg on pg.id= epgc.group_id".$where." GROUP BY epgc.group_id ORDER BY epgc.id DESC".$pg;
        $result=$this->db->query($query);

        if($result->num_rows()>0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
    }

        function get_all_member_privillages($search,$limit=NULL,$start=NULL)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (gu.id LIKE '%$keyword%' OR gp.title LIKE '%$keyword%' OR emp.name LIKE '%$keyword%' ) AND gu.id IS NOT NULL ";
        }else{
            $where = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="select gu.*,GROUP_CONCAT(emp.name) as employee,gp.title as group_name
         from gp_privilege_user gu
        left join gp_privilege_group gp on gp.id=gu.group_id
        left join hr_employee emp on emp.id=gu.user_id


        ".$where." GROUP BY gu.group_id ORDER BY gu.id DESC".$pg;
        $result=$this->db->query($query);
//echo $this->db->last_query();exit();
        if($result->num_rows()>0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
    }


    function get_all_desg_member_privillages($search,$limit=NULL,$start=NULL)
    {
        if(!empty($search)){
            $keyword = "%{$search}%";
            $where = " WHERE (gu.id LIKE '%$keyword%' OR gp.title LIKE '%$keyword%' OR emp.designation LIKE '%$keyword%' ) AND gu.id IS NOT NULL ";
        }else{
            $where = '';
        }
        if(!is_null($start)&&!is_null($limit)){
            $pg = " LIMIT $start, $limit";
        }else{
            $pg = "";
        }
        $query="select gu.*,GROUP_CONCAT(emp.designation) as employee,gp.title as group_name
         from gp_privilege_design_user gu
        left join gp_privilege_group gp on gp.id=gu.group_id
        left join gp_pl_sales_designation_type emp on emp.id=gu.desig_type_id


        ".$where." GROUP BY gu.group_id ORDER BY gu.id DESC".$pg;
        $result=$this->db->query($query);
//echo $this->db->last_query();exit();
        if($result->num_rows()>0)
        {
            return $result->result_array();
        }
        else
        {
            return array();
        }
    }
    function get_privillage()
    {
        $qry="select * from gp_privileges where type ='normal' order by id asc";
        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['privilege']=$query->result_array();
        }
        else{
            $data['privilege']=array();
        }
        return $data;
    }
    function get_privillage_desg()
    {
        $qry="select * from gp_privileges where type ='desig' order by id asc";
        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['des']=$query->result_array();
        }
        else{
            $data['des']=array();
        }
        return $data;
    }


      function get_privillage_groups()
    {
        $qry="select * from gp_privilege_group where type='normal' order by id asc";
        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['privilege_group']=$query->result_array();
        }
        else{
            $data['privilege_group']=array();
        }
        return $data;
    }

          function get_privillage_groups_desig()
    {
        $qry="select * from gp_privilege_group where type='design' order by id asc";
        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['privilege_group']=$query->result_array();
        }
        else{
            $data['privilege_group']=array();
        }
        return $data;
    }


    function get_privillage_members()
    {
        $qry="select gu.* from gp_privilege_user gu
        left join gp_privilege_group gp on gp.id=gu.group_id
        left join hr_employee emp on emp.id=gu.user_id


        order by gu.id asc";
        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['users']=$query->result_array();
        }
        else{
            $data['users']=array();
        }
        return $data;
    }


    function get_member_by_id($id)
    {
         $qry="select gu.* ,gp.title as group_name
         from gp_privilege_user gu
        left join gp_privilege_group gp on gp.id=gu.group_id
        left join hr_employee emp on emp.id=gu.user_id
        where gu.id='$id'


        order by gu.id asc";
        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['users']=$query->row_array();
            $g_id=$data['users']['group_id'];
        }
        else{
            $data['users']=array();
        }



            $qry2 ="select gu.* 
         from gp_privilege_user gu
        left join hr_employee emp on emp.id=gu.user_id

                where gu.group_id = '$g_id' "; 
        $qry2=$this->db->query($qry2);

        if($qry2->num_rows()>0){
            $res = $qry2->result_array();
            $array = array();
            foreach ($res as $key => $value) {
                $id = $value['user_id'];
                array_push($array, $id);
            }
            $data['grp_sel'] = $array;
        }
        else{
            $data['grp_sel']=array();
        }
        return $data;
    }

    function get_desg_member_by_id($id)
    {
        $qry="select gu.* ,gp.title as group_name
         from gp_privilege_design_user  gu
        left join gp_privilege_group gp on gp.id=gu.group_id
        left join gp_pl_sales_designation_type emp on emp.id=gu.desig_type_id
        where gu.id='$id'


        order by gu.id asc";
        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['users']=$query->row_array();
            $g_id=$data['users']['group_id'];
        }
        else{
            $data['users']=array();
        }



            $qry2 ="select gu.* 
         from gp_privilege_design_user  gu
        left join gp_pl_sales_designation_type emp on emp.id=gu.desig_type_id

                where gu.group_id = '$g_id' "; 
        $qry2=$this->db->query($qry2);

        if($qry2->num_rows()>0){
            $res = $qry2->result_array();
            $array = array();
            foreach ($res as $key => $value) {
                $id = $value['desig_type_id'];
                array_push($array, $id);
            }
            $data['grp_sel'] = $array;
        }
        else{
            $data['grp_sel']=array();
        }
        return $data;
    }

    function get_employees()
    {
        $qry="select * from hr_employee  where is_del!='1' and id not in (SELECT user_id FROM `gp_privilege_user`) order by id asc";
        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['employee']=$query->result_array();
        }
        else{
            $data['employee']=array();
        }
        return $data;
    }

    function   get_designation_type()
    {
        $qry="select * from gp_pl_sales_designation_type  where is_del!='1' order by id asc";
        $query=$this->db->query($qry);
        if($query->num_rows()>0)
        {
            $data['employee']=$query->result_array();
        }
        else
        {
            $data['employee']=array();
        }
        return $data;
    }
    function add_privillage()
    {
        $this->db->trans_begin();

        $access_perm=$this->input->post('access_perm');
        $group = $this->input->post('group_name');
                $type = $this->input->post('yesno');

        $slug = slugify($group);
        $groupdata=array(
            'title'=> $group,
            'slug' => $slug,
            'type'=>$type
        );
        $this->db->insert('gp_privilege_group',$groupdata);
        $insert_gid=$this->db->insert_id();

        foreach($access_perm  as $access){
            $data=array(
                'privilege_id'=>$access,
                'group_id'=>$insert_gid,
                
            );
            $this->db->insert('gp_privilege_group_con',$data);
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


    function add_privillage_members()
    {
        $this->db->trans_begin();

        $prv_memb=$this->input->post('prv_memb');
        $group_id = $this->input->post('prv_grp');

        foreach ($prv_memb as $key => $prv_membs) {
            
                    $groupdata=array(
            'group_id'=> $group_id,
            'user_id' => $prv_membs
        );
        $this->db->insert('gp_privilege_user',$groupdata);
        }






        // $slug = slugify($group);


        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
        }
        else{
            $this->db->trans_commit();
            return true;
        }
        // $insert_gid=$this->db->insert_id();
    }

    function add_design_prv_members()
    {
         $this->db->trans_begin();

        $prv_memb=$this->input->post('prv_memb');
        $group_id = $this->input->post('prv_grp');

        foreach ($prv_memb as $key => $prv_membs) {
            


  // $qry="select * from gp_pl_sales_designation_type where id='$prv_membs' ";
  //       $query=$this->db->query($qry);
  //       if($query->num_rows()>0){
  //           $desg=$query->row_array();
  //           $de_name=$desg['designation'];
  //       }
  //       else{
  //           $desg=array();
  //       }




                    $groupdata=array(
            'group_id'=> $group_id,
            'desig_type_id' => $prv_membs

        );

        $this->db->insert('gp_privilege_design_user',$groupdata);

        }
        // $slug = slugify($group);


        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
        }
        else{
            $this->db->trans_commit();
            return true;
        }

    }

    function edit_privillage_members()
    {
        $this->db->trans_begin();
        $id=$this->input->post('pr_id');
        $group_id = $this->input->post('pr_id');
        $access_perm = $this->input->post('prv_members');

        // $slug = slugify($group);
        // $groupdata=array(
        //     'group_id'=> $group_id,
        //     // 'user_id' => $prv_memb
        // );
        // $this->db->where('id',$id);
        // $qry = $this->db->update('gp_privilege_user',$groupdata);
        $qrs3 = "select * from gp_privilege_user where group_id = '$group_id'";
        $qrs3 = $this->db->query($qrs3);

        $prpty = array();
        if($qrs3->num_rows()>0){
            $ppt = $qrs3->result_array();
            foreach ($ppt as $prt){
                array_push($prpty,$prt['user_id']);
            }
        }
        foreach ($access_perm as $property){
            if (in_array($property, $prpty))
            {

            }else{
                $ins = array(
                    'group_id' => $group_id,
                    'user_id' => $property
                );
                $qrs2 = $this->db->insert('gp_privilege_user', $ins);
                $qry="select * from hr_employee where id='$property' ";
                $query=$this->db->query($qry);
                if($query->num_rows()>0){
                    $emp=$query->row_array();
                    $emp_email=$emp['email'];
                    $mobile=$emp['mobile'];
                }
                else{
                    $emp=array();
                }

                if($mobile)
                {
                    $qry="select * from gp_login_table where email='$emp_email' and  mobile='$mobile' and type ='Employee'";
                    $query=$this->db->query($qry);
                    if($query->num_rows()>0){

                    }else{
                        $logindata=array(
                            'email'=>$emp_email,
                            'mobile'=>$mobile,
                            'otp_status' => 0,
                            'user_id'=>$property,
                            'type'=>"Employee"
                        );
                        $user=$this->db->insert('gp_login_table',$logindata);
                        $insert_id=$this->db->insert_id();
                        $data['id'] =  $insert_id;
                        $email = $emp_email;
                        $mail_head = 'Message From Jaazzo';
                        //echo $mail_head;exit();
                        $status = send_custom_email($email, $mail_head, $emp_email, 'Set Your Password', $this->load->view('templates/public/mail/privilege_login', $data,TRUE));
                    }
                }
            }
        }
        foreach ($prpty as $pr){
            if (in_array($pr, $access_perm))
            {
            }else{
                $qry32 = "delete from gp_privilege_user where group_id = $group_id and user_id =$pr";
                $qry32 = $this->db->query($qry32);
            }
        }

        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
            return true;
        }
    }


    function edit_desig_privillage_members()
    {
           $this->db->trans_begin();

        $id=$this->input->post('prv_id');
        $group_id = $this->input->post('pr_id');
                $access_perm = $this->input->post('prv_members');

        // $slug = slugify($group);
        // $groupdata=array(
        //     'group_id'=> $group_id,
        //     // 'user_id' => $prv_memb
        // );

        // $this->db->where('id',$id);
        // $qry = $this->db->update('gp_privilege_user',$groupdata);







         $qrs3 = "select * from gp_privilege_design_user where group_id = '$group_id'";
        $qrs3 = $this->db->query($qrs3);

        $prpty = array();
        if($qrs3->num_rows()>0){
            $ppt = $qrs3->result_array();
            foreach ($ppt as $prt){
                array_push($prpty,$prt['desig_type_id']);
            }
        }
        foreach ($access_perm as $property){
            if (in_array($property, $prpty))
            {

            }else{
                $ins = array(
                    'group_id' => $group_id,
                    'desig_type_id' => $property
                );
                $qrs2 = $this->db->insert('gp_privilege_design_user', $ins);

            }
        }
        foreach ($prpty as $pr){
            if (in_array($pr, $access_perm))
            {
            }else{
                $qry32 = "delete from gp_privilege_design_user where group_id = $group_id and desig_type_id =$pr";
                $qry32 = $this->db->query($qry32);
            }
        }

        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
            return true;
        }
    }
    function delete_privilages($datas)
    {
        $this->db->trans_begin();
        $ids = $datas['chck_item_id'];
        foreach ($ids as $key => $id) {
            $this->db->where('id', $id);
            $qry = $this->db->delete('gp_privilege_group');
            $this->db->where('group_id', $id);
            $qrs = $this->db->delete('gp_privilege_group_con');
            $this->db->where('group_id', $id);
            $qru = $this->db->delete('gp_privilege_user');
        }
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }
    }

  
    function get_privillege_by_group($id)
    {
        $qry="select epg.id,epg.title,epg.type from gp_privilege_group epg left join gp_privilege_group_con epgc on epgc.group_id=epg.id where epg.id='$id'";

        $query=$this->db->query($qry);
        if($query->num_rows()>0){
            $data['grp']=$query->row_array();
        }
        else{
            $data['grp']=array();
        }

        $qry2 ="select ep.* from gp_privileges ep 
                right join gp_privilege_group_con epgc  on epgc.privilege_id = ep.id 
                where epgc.group_id = '$id' group by epgc.privilege_id";
        $qry2=$this->db->query($qry2);
        if($qry2->num_rows()>0){
            $res = $qry2->result_array();
            $array = array();
            foreach ($res as $key => $value) {
                $id = $value['id'];
                array_push($array, $id);
            }
            $data['grp_sel'] = $array;
        }
        else{
            $data['grp_sel']=array();
        }
        return $data;
    }


      function delete_privilage_user($datas)
    {
        $this->db->trans_begin();
        $ids = $datas['chck_item_id'];
        foreach ($ids as $key => $id) {
            $this->db->where('id', $id);
            $qry = $this->db->delete('gp_privilege_user');
            
        if ($this->db->trans_status() === TRUE) {
            $this->db->trans_commit();
            return true;
        } else {
            $this->db->trans_rollback();
            return false;
        }

    }
}
    function update_privilege()
    {
        $this->db->trans_begin();

        $access_perm=$this->input->post('access_perm');
        $gr_id = $this->input->post('group_id');
                $type = $this->input->post('yesno');

        $groupdata=array(
            'title'=>$this->input->post('group_name'),
            'type'=>$type
        );
        $this->db->where('id',$gr_id);
        $this->db->update('gp_privilege_group',$groupdata);


        $qrs3 = "select * from gp_privilege_group_con where group_id = $gr_id";
        $qrs3 = $this->db->query($qrs3);

        $prpty = array();
        if($qrs3->num_rows()>0){
            $ppt = $qrs3->result_array();
            foreach ($ppt as $prt){
                array_push($prpty,$prt['privilege_id']);
            }
        }
        foreach ($access_perm as $property){
            if (in_array($property, $prpty))
            {

            }else{
                $ins = array(
                    'group_id' => $gr_id,
                    'privilege_id' => $property
                );
                $qrs2 = $this->db->insert('gp_privilege_group_con', $ins);

            }
        }
        foreach ($prpty as $pr){
            if (in_array($pr, $access_perm))
            {
            }else{
                $qry32 = "delete from gp_privilege_group_con where group_id = $gr_id and privilege_id =$pr";
                $qry32 = $this->db->query($qry32);
            }
        }

        $this->db->trans_complete();
        if($this->db->trans_status()===false){
            $this->db->trans_rollback();
        }else{
            $this->db->trans_commit();
            return true;
        }
    }
}
?>
