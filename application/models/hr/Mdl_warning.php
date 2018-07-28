<?php

/**

 *

 */

class Mdl_warning extends CI_Model

{



    function __construct()

    {

        parent::__construct();

        $this->load->database();

    }
    function get_requesition_by_id()

    {



        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];



        $data = array();

        //$qry = "select * from hr_emp_warning";



                $qry = "select hr.id,hr.warning_to,hr.forward_application,hr.warning_by,

                        DATE_FORMAT(hr.date, '%d-%b-%Y')date,hr.subject,hr.description,emp.name,

                        emp.status ,emp.employee_code,emp1.name wnby ,emp1.status as em_status,

                        emp1.employee_code wanby,emp1.id wanid ,emp2.name fwby ,emp2.employee_code fwdby

                        from hr_emp_warning hr

                        left join hr_employee emp on emp.id=hr.warning_to

                        Left join hr_employee emp1 on emp1.id=hr.warning_by

                        Left join hr_employee emp2 on

                        emp2.id=hr.forward_application

                        where hr.is_del!='1' and hr.added_by='$created_by'";



        $qry = $this->db->query($qry);//echo $this->db->last_query();exit();

        if($qry->num_rows()>0)

        {

            $data['status'] = true;

            $data['request'] = $qry->result_array();



        } else{

            $data['status'] = false;

            $data['request'] = array();

        }



        return $data;



    }

    function get_req_employee(){

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];


        $data = array();

        $qry = "select he.id,he.name,he.employee_code 
        from hr_employee he where he.is_del!='1' and he.status='Active' and he.created_by='$created_by' ORDER BY id DESC ";

        $qry = $this->db->query($qry);

       // echo $this->db->last_query();exit;

        if($qry->num_rows()>0)

        {

            $data['status'] = true;

            $data['reqemp'] = $qry->result_array();



        } else{

            $data['status'] = false;

            $data['reqemp'] = array();

        }



        return $data;

    }



    function addcomplaint()

    {

        $this->db->trans_begin();

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];



        $created_on = date('Y-m-d H:i:s');

        $dat=$this->input->post('date');

        $date1=date('Y-m-d',strtotime($dat));




        $warning_by = $this->input->post('forwardd');


        $data = array(

            'warning_to' => $this->input->post('forward'),



            'warning_by' => $this->input->post('forwardd'),

           // 'date'=>$this->input->post('date'),

            'date'=> $date1,

            'subject'=>$this->input->post('title'),

            'description'=>$this->input->post('descrip'),

            'added_by' => $created_by,



            'added_on' => $created_on

             //'status' => "1",

        );

        $this->db->insert('hr_emp_warning', $data);
        $qry45="select * from hr_employee l where l.id='$warning_by'";
         $query=$this->db->query($qry45);


               if($query->num_rows()>0)
        {
        $data = $query->row_array();
        $name=$data['name'];
        $code=$data['employee_code'];

        }


        $action = "Added warning by ".$name."($code)";

        $session_array = $this->session->userdata('logged_in_admin');



        $userid=$session_array['id'];

        $status = 0;

        $type=$session_array['type'];

        $date=date('Y-m-d H:i:s');




        if($this->db->trans_status=false){

            $this->db->trans_roll_back();

            return false;

        }

        else{

            $this->db->trans_commit();

            return true;



        }

    }


     function edit_warning_by_id($id)

    {

        $data = array();

        $qry = "select *from hr_emp_warning where id='$id'";

        //echo $qry;

        $qry = $this->db->query($qry);

        if($qry->num_rows()>0)

        {

            $data['status'] = true;

            $data['request'] = $qry->row_array();



        } else{

            $data['status'] = false;

            $data['request'] = array();

        }



        return $data;

    }


 function get_employee_status(){

        $data = array();

        $qry = "select status,id from employee_status order by id desc";

        $qry = $this->db->query($qry);

        if($qry->num_rows()>0)

        {

            $data['status'] = true;

            $data['emp_stat'] = $qry->result_array();



        } else{

            $data['status'] = false;

            $data['emp_stat'] = array();

        }



        return $data;

    }
    
 function get_priority_req()

    {

        $data = array();


        $qry = "select r.type,r.id  from requesition_priority r order by r.id asc";

        $qry = $this->db->query($qry);



        if ($qry->num_rows() > 0) {

            $data['status'] = true;

            $data['prior'] = $qry->result_array();

        } else {

            $data['status'] = false;

            $data['prior'] = array();

        }

        return $data;

    }
function get_req_employee11(){

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];



        $data = array();

        $qry = "select he.id,he.name,he.employee_code,he.status 
        from hr_employee he where he.is_del!='1' and he.status='Active'
        OR (he.is_del!='1' and he.status='Terminated') OR (he.is_del!='1' and he.status='Exit')
         OR (he.is_del!='1' and he.status='Resigned') and he.created_by='$created_by'
         ORDER BY id DESC ";

        $qry = $this->db->query($qry);

        // echo $this->db->last_query();exit;

        if($qry->num_rows()>0)

        {

            $data['status'] = true;

            $data['reqemp'] = $qry->result_array();



        } else{

            $data['status'] = false;

            $data['reqemp'] = array();

        }



        return $data;

    }

function editrequest()

    {

        $hiddenid=$this->input->post('hiddenid');

        $updated_on = date('Y-m-d H:i:s');

        $daten=$this->input->post('daten');

        $da=convert_to_mysql($daten);

        $data = array(

            'warning_to' => $this->input->post('forward'),

            'warning_by' => $this->input->post('warning_by'),

            'date' => $da,

            'subject' => $this->input->post('title'),

            'description' => $this->input->post('descrip'),

            //'updated_on' => $updated_on

        );

        $this->db->where('id', $hiddenid);

        $this->db->update('hr_emp_warning', $data);
        $qry45="select * from hr_emp_warning l where l.id='$hiddenid'";
        $query=$this->db->query($qry45);


               if($query->num_rows()>0)
        {
        $data = $query->row_array();
        $na=$data['warning_by'];

        }


        $qry4="select * from hr_employee l where l.id='$na'";
         $query=$this->db->query($qry4);


               if($query->num_rows()>0)
        {
        $data = $query->row_array();
        $name=$data['name'];
        $code=$data['employee_code'];

        }

        $action = "Updated employee warning by ".$name."($code)";

        $session_array = $this->session->userdata('logged_in_admin');



        $userid=$session_array['id'];

        $status = 0;

        $type=$session_array['type'];

        $date=date('Y-m-d H:i:s');




        
        if($this->db->trans_status=false){

            $this->db->trans_roll_back();

            return false;

        }

        else{

            $this->db->trans_commit();

            return true;



        }

    }


  function delete_warning($data)

    {


        $deleted_on = date('Y-m-d H:i:s');
        $warid = $data['warn_id'];
        $info = array('is_del' => 1,'del_on'=>$deleted_on);
        $this->db->where_in('id', $warid);
        $qry = $this->db->update('hr_emp_warning', $info);
        return $qry;

    }




}
    ?>

