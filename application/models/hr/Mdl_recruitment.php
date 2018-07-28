<?php
/**
 * User: kavyasree
 * Date: 7/11/17
 * Time: 11:50 PM
 */

class Mdl_recruitment extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function random_password($length = 8)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
        $password = substr(str_shuffle($chars), 0, $length);
        return $password;
    }
    function get_company_profile()
    {
        return "MCKENILY";
    }
    function getrequisitions()
    {
        $qry = "SELECT hr.rq_id, he.name as forward, hr.company, hr.branch, d.tittle as dep, hr.title,
                    hr.`type`, hr.posts, hr.location, hr.age_st, hr.age_en,
                    hr.salary_st, hr.salary_en, hr.qual, hr.exp, hr.desp, hr.notes,
                    hr.`status`, hr.addby, hr.addon,hst.branch as st_name
                    ,hrq.qualification as qualificationss
                    FROM hr_requisitions hr
                    left join hr_employee he on he.id = hr.forward
                    left join hr_department d on d.id = hr.dep
                    left join hr_branch hst on hst.id = hr.branch
                    left join hr_qualification hrq on hrq.id = hr.qual
                     where hr.is_del = '0'
                    order by hr.rq_id DESC";
        $qry = $this->db->query($qry);
        //echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

    function getemployees()
    {
        $qry = "SELECT * FROM `hr_employee` order by id ASC";
        $qry = $this->db->query($qry);
        // echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }



    function getcompany()
    {
        $qry = "SELECT * FROM `company_details` order by id ASC";
        $qry = $this->db->query($qry);
        // echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

    function getstations()
    {
        $qry = "select * from hr_branch s where s.is_del = 0 order by id ASC";
        $qry = $this->db->query($qry);
        // echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

    function getqualification()
    {

        $qry = "SELECT * FROM `hr_qualification`  order by id ASC";
        $qry = $this->db->query($qry);
        // echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

    function getdepartment()
    {
        $qry = "SELECT * FROM `hr_department`  where is_del = 0 order by id ASC";
        $qry = $this->db->query($qry);
        // echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

    function add_qualification()
    {

        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $created_on = date('Y-m-d H:i:s');
        $stat = 0;
        $data = array(
            'qualification' => $this->input->post('qualifc'),


        );
        $qry = $this->db->insert('hr_qualification', $data);

        return $qry;
    }


    function new_requisition()
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $created_on = date('Y-m-d H:i:s');

        $stat = 0;
        $data = array(

            'branch' => $this->input->post('branch'),
            'dep' => $this->input->post('dep'),
            'title' => $this->input->post('title'),
            'type' => $this->input->post('type'),
            'posts' => $this->input->post('posts'),
            'location' => $this->input->post('location'),
            'age_st' => $this->input->post('age_st'),
            'age_en' => $this->input->post('age_en'),
            'salary_st' => $this->input->post('salary_st'),
            'salary_en' => $this->input->post('salary_en'),
            'qual' => $this->input->post('qual'),
            'exp' => $this->input->post('exp'),
            'desp' => $this->input->post('desp'),

            'status' => $stat,
            'addby' => $created_by,
            'addon' => $created_on
        );
        $qry = $this->db->insert('hr_requisitions', $data);


        return $qry;
    }

    function get_requisitions_by_id($id)
    {
        $qry = "SELECT * FROM `hr_requisitions`  where rq_id='$id' ";
        $qry = $this->db->query($qry);
        // echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            return $qry->row_array();
        } else {
            return array();
        }


    }

    function update_requisition()
    {

        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $created_on = date('Y-m-d H:i:s');

        $stat = 0;
        $id = $this->input->post('id');

        $data = array(

            'branch' => $this->input->post('branch'),
            'dep' => $this->input->post('dep'),
            'title' => $this->input->post('title'),
            'type' => $this->input->post('type'),
            'posts' => $this->input->post('posts'),
            'location' => $this->input->post('location'),
            'age_st' => $this->input->post('age_st'),
            'age_en' => $this->input->post('age_en'),
            'salary_st' => $this->input->post('salary_st'),
            'salary_en' => $this->input->post('salary_en'),
            'qual' => $this->input->post('qual'),
            'exp' => $this->input->post('exp'),
            'desp' => $this->input->post('desp'),

            'status' => $stat,

        );
        $this->db->where('rq_id', $id);
        $qry = $this->db->update('hr_requisitions', $data);


        return $qry;
    }

    function getreqbyid($id)
    {
        $qry = "SELECT * FROM `hr_requisitions` where rq_id = $id ";
        $qry = $this->db->query($qry);
        // echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

    function new_post()
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $created_on = date('Y-m-d H:i:s');
        $stat = 'open';
        $data = array(
            'title' => $this->input->post('title'),
            'type' => $this->input->post('type'),
            'posts' => $this->input->post('posts'),
            'closing' => $this->input->post('closing'),
            'branch' => $this->input->post('branch'),
            'dep' => $this->input->post('dep'),
            'age_st' => $this->input->post('age_st'),
            'age_en' => $this->input->post('age_en'),
            'salary_st' => $this->input->post('salary_st'),
            'salary_en' => $this->input->post('salary_en'),
            'qual' => $this->input->post('qual'),
            'exp' => $this->input->post('exp'),
            'desp' => $this->input->post('desp'),
            'status' => $stat,
            'addby' => $created_by,
            'addon' => $created_on
        );
        $qry = $this->db->insert('hr_posts', $data);
        $req_id=$this->input->post('id');
         if($qry && (!empty($req_id))){

            
            $this->db->where('rq_id', $req_id);
            $qry = $this->db->delete('hr_requisitions');
         }

        if ($qry) {
            return true;
        } else {
            return false;
        }
    }

    function getposts()
    {
        $qry = "SELECT hp.po_id, hp.title, hp.`type`, hp.posts, hp.closing,hp.qual,
                hp.company, hp.branch, d.tittle as dep, hp.age_st, hp.age_en,hq.qualification,
                hp.salary_st, hp.salary_en, hp.qual, hp.exp, hp.desp,
                hp.notes, hp.`status`, hp.addby, hp.addon,hst.branch as st_name FROM `hr_posts` hp
                left join hr_department d on d.id = hp.dep
                left join hr_qualification hq on hq.id=hp.qual
                left join hr_branch hst on hst.id = hp.branch
                where hp.is_del != '1' order by po_id DESC";
        $qry = $this->db->query($qry);
        // echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

    function getpostbyid($id)
    {
        $qry = "SELECT * FROM `hr_posts` where po_id = $id ";
        $qry = $this->db->query($qry);
        // echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

    function statuspostbyid($id, $stat)
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $updated_by = $session_array['id'];
        $updated_on = date('Y-m-d H:i:s');
        if ($stat == 'open') {
            $status = 'closed';
        } else {
            $status = 'open';
        }
        $data = array(
            'status' => $status
        );
        $qry = $this->db->where('po_id', $id);
        $qry = $this->db->update('hr_posts', $data);
        //echo $this->db->last_query();exit();
        if($qry){
            return true;
        }else
        {
            return false;
        }
        
    }

    function edit_post($id)
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $updated_by = $session_array['id'];
        $updated_on = date('Y-m-d H:i:s');

        // $id = $this->input->post('title');

        $data = array(
            'title' => $this->input->post('title'),
            'type' => $this->input->post('type'),
            'posts' => $this->input->post('posts'),
            'closing' => $this->input->post('closing'),
            'branch' => $this->input->post('branch'),
            'dep' => $this->input->post('dep'),
            'age_st' => $this->input->post('age_st'),
            'age_en' => $this->input->post('age_en'),
            'salary_st' => $this->input->post('salary_st'),
            'salary_en' => $this->input->post('salary_en'),
            'qual' => $this->input->post('qual'),
            'exp' => $this->input->post('exp'),
            'desp' => $this->input->post('desp'),
            'notes' => $this->input->post('notes')

        );
        $qry = $this->db->where('po_id', $id);
        $qry = $this->db->update('hr_posts', $data);


        return $qry;
    }

    function deletepostbyid($data)
    {
        $itemgrp = $data['itemgrps'];  

        $session_array = $this->session->userdata('logged_in_admin');
        $updated_by = $session_array['id'];
        $updated_on = date('Y-m-d H:i:s');
        $data = array(
            'is_del' => '1'
        );
        $qry = $this->db->where_in('po_id', $itemgrp);
        $qry = $this->db->update('hr_posts', $data);


        return $qry;
    }

    function getcandidates()
    {
        $qry = "SELECT hc.*,hq.qualification,DATE_FORMAT(hc.dob,'%d-%b-%Y') as dob FROM `hr_candids` hc
        left join hr_qualification hq on hq.id=hc.qual

        where hc.is_del != '1' order by cd_id ASC";
        $qry = $this->db->query($qry);
        // echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

    function getjob()
    {
        $qry = "SELECT * FROM `hr_posts` where is_del != '1' ";
        $qry = $this->db->query($qry);
        // echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }
       function get_candid_emp($id){
        $qry = "SELECT * FROM `hr_candids` where shortlists_status = '4' and cd_id='$id' order by cd_id ASC";
        $qry = $this->db->query($qry);
        // echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
    }

    function new_candid()
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $created_on = date('Y-m-d H:i:s');
        $stat = 0;
        $dob = $this->input->post('dob');
        $dob = date('Y-m-d', strtotime($dob));


        $resume = 1;

        $data = array(
            'po_id' => $this->input->post('title'),
            'name' => $this->input->post('name'),
            'dob' => $dob,
            'gender' => $this->input->post('gender'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'resume' => $resume,
            'address' => $this->input->post('address'),
            'pin' => $this->input->post('pin'),
            'qual' => $this->input->post('qual'),
            'exp' => $this->input->post('exp'),
            'shortlists_status' => $stat,
            'ts_id' => $stat,
            'tests_status' => $stat,
            'it_id' => $stat,
            'interviews_status' => $stat,
            'addby' => $created_by,
            'addon' => $created_on
        );
        $qry = $this->db->insert('hr_candids', $data);


        return true;
    }

    function candid_shortlist($id)
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $updated_by = $session_array['id'];
        $updated_on = date('Y-m-d H:i:s');
        $data = array(
            'shortlists_status' => '1'
        );
        $qry = $this->db->where('cd_id', $id);
        $qry = $this->db->update('hr_candids', $data);
        if($qry)
        {
          return true;
        }else
        {
         return false;
        }      
    }
    function update_candid_Status($id){
        $status=$this->input->post('status');
    
        $this->db->where('cd_id', $id);
        $arr = array('shortlists_status' => $status,
            
            );
        $qry = $this->db->update('hr_candids', $arr);
        return $qry;    
    
    }
    function edit_candidate($id)
    {
        $qry = "SELECT * FROM `hr_candids` where cd_id = '$id'";
        $qry = $this->db->query($qry);
        // echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            return $qry->row_array();
        } else {
            return array();
        }
    }

    function edit_candid_by_id($id)
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];
        $created_on = date('Y-m-d H:i:s');
        $dob = $this->input->post('dob');
        $dob = date('Y-m-d', strtotime($dob));
        $stat = 0;
        $resume = 1;

        $data = array(
            'po_id' => $this->input->post('title'),
            'name' => $this->input->post('name'),
            'dob' => $dob,
            'gender' => $this->input->post('gender'),
            'email' => $this->input->post('email'),
            'phone' => $this->input->post('phone'),
            'address' => $this->input->post('address'),
            'pin' => $this->input->post('pin'),
            'qual' => $this->input->post('qual'),
            'exp' => $this->input->post('exp'),

        );
        $this->db->where('cd_id', $id);
        $qry = $this->db->update('hr_candids', $data);


        return $qry;
    }

    function candid_delete($data)
    {
        $itemgrp = $data['itemgrps'];
        //var_dump($itemgrp);exit();
        $session_array = $this->session->userdata('logged_in_admin');
        $updated_by = $session_array['id'];
        $updated_on = date('Y-m-d H:i:s');
        $data = array(
            'is_del' => '1',
            'shortlists_status' => '0'
        );
        $qry = $this->db->where_in('cd_id', $itemgrp);
        $qry = $this->db->update('hr_candids', $data);


        return $qry;
    }

    function getshortlists()
    {


        $qry = "SELECT hc.*,ho.*,DATE_FORMAT(hc.addon, '%d-%b-%y') as added_on FROM `hr_candids` hc join `hr_posts` ho on ho.po_id=hc.po_id
        where hc.shortlists_status = '1' or hc.shortlists_status = '4' order by cd_id ASC";
        $qry = $this->db->query($qry);

        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

    function candids_change_status($id, $po_id, $shortlists, $posts)
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $updated_by = $session_array['id'];
        $updated_on = date('Y-m-d H:i:s');
        //var_dump($shortlists);exit();
        // $data = array(
        //     'shortlists_status' => '4'
        // );
        if($shortlists=='4')
        {
             $data = array(
             'shortlists_status' => '1'
             );
        }else if($shortlists=='1')
        {
            $data = array(
             'shortlists_status' => '4'
             );
        }
        $qry = $this->db->where('cd_id', $id);
        $qry = $this->db->update('hr_candids', $data);
        //echo $this->db->last_query();exit;

        if($shortlists=='1'){
            $post = $posts - 1;
            $data1 = array(
                'posts' => $post
            );
            $qry1 = $this->db->where('po_id', $po_id);
            $qry1 = $this->db->update('hr_posts', $data1);
        }
        if($qry){return true;}
        else{return false;}
        
    }
    function candid_select($id, $po_id, $posts)
    {
        $session_array = $this->session->userdata('logged_in_admin');
        $updated_by = $session_array['id'];
        $updated_on = date('Y-m-d H:i:s');
        $data = array(
            'shortlists_status' => '4'
        );
        $qry = $this->db->where('cd_id', $id);
        $qry = $this->db->update('hr_candids', $data);
        //echo $this->db->last_query();exit;


        $post = $posts - 1;
        $data1 = array(
            'posts' => $post
        );
        $qry = $this->db->where('po_id', $po_id);
        $qry = $this->db->update('hr_posts', $data1);

        return true;
    }

    function getselected()
    {
        $qry = "SELECT * FROM `hr_candids` join `hr_posts` on hr_candids.po_id=hr_posts.po_id where shortlists_status = '4' order by cd_id ASC";

        $qry = $this->db->query($qry);

        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }

    function getrequisitionss()
    {


        $session_array = $this->session->userdata('logged_in_admin');
        $added_by = $session_array['id'];


        $qry = "SELECT hr.rq_id, he.name as forward, hr.company, hr.branch, d.tittle as dep, hr.title, hr.`type`,
hr.posts, hr.location, hr.age_st, hr.age_en, hr.salary_st, hr.salary_en, hr.qual, hr.exp, hr.desp, hr.notes,
 hr.`status`, hr.addby, hr.addon,hb.branch as st_name,hrq.qualification as qualificationss
FROM hr_requisitions hr
left join hr_employee he on he.id = hr.forward
left join hr_department d on d.id = hr.dep
left join hr_branch hb on hb.id = hr.branch
left join hr_qualification hrq on hrq.id = hr.qual
 where hr.addby='$added_by' order by hr.rq_id DESC";
        $qry = $this->db->query($qry);
        // echo $this->db->last_query();exit;
        if ($qry->num_rows() > 0) {
            return $qry->result_array();
        } else {
            return array();
        }
    }
    function deleterequisition($data)
    {
        $itemgrp = $data['itemgrps'];
        $info = array('is_del' => 1);
        $this->db->where_in('rq_id', $itemgrp);
        $qry = $this->db->update('hr_requisitions', $info);
        return $qry;
    }
function getcandids()
    {

        $session_array = $this->session->userdata('logged_in_admin');
        $added_by = $session_array['id'];




        $qry = "SELECT hc.*,hq.qualification,hp.title as posts  FROM `hr_candids` hc
        left join hr_qualification hq on hq.id=hc.qual
        left join hr_posts hp on hp.po_id=hc.po_id

        where hc.is_del != '1'     order by cd_id DESC";
        $qry = $this->db->query($qry);
        //echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }           
    }
    function get_new_selected()
    {   

        $qry = "SELECT * FROM `hr_candids` join `hr_posts` on hr_candids.po_id=hr_posts.po_id where shortlists_status = '4' and    join_status!='1' order by cd_id ASC";
      
        $qry = $this->db->query($qry);
      
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
    }
    function add_candidates(){
        $this->db->trans_begin();
        $id=$this->input->post('id');
        $created_on = date('Y-m-d H:i:s');
        $password = $this->random_password(8);
        $email = $this->input->post('work_email');
        $username = $email;
        $user_psw = $password;
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];

        $company_name = $this->get_company_profile();

        $cname = explode(' ', trim($company_name));

        $first_letter = '';
        foreach ($cname as $key => $value) {

            $first_letter .= substr($value, 0, 1);
        }
//var_dump($first_letter);exit();


        // var_dump($id);

        $this->db->trans_begin();
         $date_of_birth = $this->input->post('date_of_birth');
         
         $date_of_birth = convert_to_mysql($date_of_birth);
         $doj = $this->input->post('date_of_join');
         $doj = convert_to_mysql($doj);
        $name = $this->input->post('name');
        $phone = $this->input->post('phone');


        $blood_group = $this->input->post('blood_group');
        $email = $this->input->post('email');
        $p_phone = $this->input->post('p_phone');
        $gender = $this->input->post('gender');
        $bank_name = $this->input->post('bank_name');
        $bank_ac_no = $this->input->post('bank_ac_no');
        $ifsc_code = $this->input->post('ifsc_code');
        $address = $this->input->post('address');
        $probation = $this->input->post('probation');
        $dept = $this->input->post('department');
        $designation = $this->input->post('designation');
        $salary = $this->input->post('basic_salary');
        $branch = $this->input->post('branch');

        $work_phone = $this->input->post('work_phone');
        $work_email = $this->input->post('work_email');
        $ta = $this->input->post('ta');
        $td = $this->input->post('da');
        $hra = $this->input->post('hra');


        $data = array('name' => $name, 'mobile' => $phone,
            'blood_group' => $blood_group, 'department' => $dept, 'designation' => $designation,
            'email' => $email, 'gender' => $gender, 'dob' => $date_of_birth, 'basic_salary' => $salary,
            'bank_name' => $bank_name, 'bank_ac_no' => $bank_ac_no, 'bank_ifsc' => $ifsc_code,
            'address' => $address, 'parent_contact' => $p_phone, 'probation' => $probation,
            'work_phone' => $work_phone, 'work_email' => $work_email, 'date_of_join' => $doj, 'branch_id' => $branch,
            'ta'=>$ta,'da'=>$td,'hra'=>$hra,
            'created_by' => $id,
            'created_on' => $created_on,
            'created_by' => $created_by
        );
        $qry = $this->db->insert('hr_employee', $data);
        $ins_id = $this->db->insert_id();
        $hr_ldg = array(
            'type_id' => $ins_id,
            '_type' => 'EMPLOYEE',
            'group_id' => 24,
            'name' => $ins_id . "_" . $this->input->post('name') . '_ledger'
        );
        $acc_qry = $this->db->insert('erp_ac_ledgers', $hr_ldg);
        $hr_led_id = $this->db->insert_id();


        $emp_code = $first_letter . '-' . '1000' . $ins_id;
        $ins = array('employee_code' => $emp_code, 'ledger_id' => $hr_led_id);
        $this->db->where('id', $ins_id);
        $qry1 = $this->db->update('hr_employee', $ins);


        $salry_det = array('employee_id' => $ins_id,
            'salary' => $salary,
            'from' => date('Y-m-d'),
            'active' => 1);
        $qry2 = $this->db->insert('hr_salary', $salry_det);


        $cand=array(
           'join_status'=>"1",
           
       );
        $qry45 = $this->db->where('cd_id', $id);
        $qry45 = $this->db->update('hr_candids', $cand);

        $this->db->trans_complete();
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }

    
    }
    function get_birthday(){
        $date1=date('m-d');
        
        $qry = "SELECT ehe.* from `hr_employee` ehe
        left join hr_salary sal on sal.employee_id = ehe.id
        where ehe.status='Active' and DATE_FORMAT(ehe.dob,'%m-%d')='$date1' and sal.active=1 and ehe.is_del!=1 
        ";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            $data= $qry->row_array();


           
            $content['name']=$data['name'];

            $email_id=$data['work_email'];
          

            $date=date('Y-m-d H:i:s');



            $message=$this->load->view('hr/birthdaymail',$content,TRUE);
            
            $ci = get_instance();
            $ci->load->library('email');
            $config['protocol'] = "smtp";
            $config['smtp_host'] = "ssl://smtp.gmail.com";
            $config['smtp_port'] = "465";
            $config['smtp_user'] = 'techcybaze@gmail.com';
            $config['smtp_pass'] = 'cyb@ze-7';
            $config['charset'] = "utf-8";
            $config['mailtype'] = "html";
            $config['newline'] = "\r\n";
            $ci->email->initialize($config);

            $ci->email->from('kavyababu19@gmail.com', 'mckinley');

            $ci->email->to($email_id);
           

            $ci->email->subject('Birthday Wish');
            $ci->email->message($message);
            $rs =$ci->email->send();

    }
}

} ?>