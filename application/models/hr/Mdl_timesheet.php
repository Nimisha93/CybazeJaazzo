<?php


class Mdl_timesheet extends CI_Model
{

    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    function gettotleaves()
	{
		$qry = "SELECT * FROM `ts_leavetypes` where is_del = '0'" ;
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0){
			return $qry->result_array();
		} else{
			return array();
		}
	}
        function leaves_add()
	{
		$session_array = $this->session->userdata('logged_in_admin');
		$created_by = $session_array['id'];
		$created_on = date('Y-m-d H:i:s');
		$stat = '0';
		$data = array(
			'leavename' => $this->input->post('title'),
			'description' => $this->input->post('desp'),
			
			'status' => $stat,
			'addby' => $created_by,
			'addon' => $created_on
			);
		$qry = $this->db->insert('ts_leavetypes', $data);


		return $qry;
	}


     function getleaves()

    {



        $session_array = $this->session->userdata('logged_in_admin');

        $added_by = $session_array['id'];

        $added_type = $session_array['type'];

        $typee = $session_array['type'];

        if($typee == '3'){

            $where = '';

        }
        else if($added_type=='employee'){

            $where = '';
        }

        else{

            $where = "and ts.addby='$added_by' ";

        }


        $qry = "SELECT ts.lr_id,ts.ep_id ,ts.reason,ts.levfrom,ts.levto,ts.status,ts.addon,ts.updon,tsep.name forward,

                tsep1.employee_code emp_code,tsep1.name empname ,tsep2.name addby,

		tsep3.name updby,lvtype.leavename

		FROM `ts_leaverequest` ts

		 left join `hr_employee` tsep on tsep.id=ts.forward

		 left join `hr_employee` tsep1 on tsep1.id=ts.ep_id

		 left join `ts_leavetypes` lvtype on lvtype.lt_id=ts.lt_id



		 left join `hr_employee` tsep2 on tsep2.id=ts.addby



		 left join `hr_employee` tsep3 on tsep3.id=ts.updby
		 where ts.is_del!='1'  $where order by lr_id DESC


		 " ;

        $qry = $this->db->query($qry);

        //echo $this->db->last_query();exit;

        if($qry->num_rows()>0){

            return $qry->result_array();

        } else{

            return array();

        }

    }
        function getemployees()

    {

        $qry = "SELECT * FROM `hr_employee` where status='Active' and is_del!='1' order by id ASC";

        $qry = $this->db->query($qry);



        if($qry->num_rows()>0){

            return $qry->result_array();

        } else{

            return array();

        }

    }

        function gettleave($id)
	{
		$qry = "SELECT * FROM `ts_leavetypes` where lt_id = $id" ;
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0){
			return $qry->result_array();
		} else{
			return array();
		}
	}
        function leaves_editins()
	{
		$id = $this->input->post('lid');
		$data = array(
			'leavename' => $this->input->post('title'),
			'description' => $this->input->post('desp'),
			'money' => $this->input->post('money')
			 );
	$qry = $this->db->where('lt_id', $id);
        $qry = $this->db->update('ts_leavetypes', $data);
		if($qry)
                {
                    return true;
                }
                else
                {
                    return false;
                }
	}
    /*    function leavesdelete($id)
	{
		$data = array(
			'is_del' => '1');
		$qry = $this->db->where('lt_id', $id);
                $qry = $this->db->update('ts_leavetypes', $data);
		return $qry;
	}*/
        function leavesdelete($data)
    {
        $itemgrp = $data['itemgrps'];
        $info = array('is_del' => 1);
        $this->db->where_in('lt_id', $itemgrp);
        $qry = $this->db->update('ts_leavetypes', $info);
        return $qry;
    }

        function employees()
	{
		$qry = "SELECT * FROM `hr_employee` where status='Active' and is_del!='1' order by id ASC";
		$qry = $this->db->query($qry);
		if($qry->num_rows()>0){
			return $qry->result_array();
		} else{
			return array();
		}
	}
        function getleavesbyid($id)
	{
		$qry="SELECT * FROM ts_leaverequest r
                left join ts_leavetypes t  on t.lt_id = r.lt_id
                where r.ep_id = '$id' order by r.lr_id ASC";
		$qry = $this->db->query($qry);

	//	echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
			return $qry->result_array();
		} else{
			return array();
		}
	}

        function get_req_employee(){
        $session_array = $this->session->userdata('logged_in_admin');
        $created_by = $session_array['id'];

        $data = array();
        $qry ="select he.id,he.name,he.employee_code from hr_employee he 
        where he.is_del!='1' and he.status='Active' and he.created_by='$created_by'";
        $qry = $this->db->query($qry);
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


    function leaves_apply()

    {

        $session_array = $this->session->userdata('logged_in_admin');

        $created_by = $session_array['id'];

        $id = $session_array['id'];

        $created_on = date('Y-m-d ');

         $lfrom=$this->input->post('lfrom');
         $lfrom1=date('Y-m-d',strtotime($lfrom));
        

          $lto=$this->input->post('lto');
          $lto1=date('Y-m-d',strtotime($lto));
       


        $date3=date_create($lfrom1);
        $date4=date_create($lto1);

        $diff=date_diff($date3,$date4); $sss = $diff->format("%R%a days"); $fff = abs($sss);
        if($fff==0){
            $fff=$fff+1;

        }
        else{ $fff=$fff+1; }




        $stat = '0';

//		$forw = '1';

        // $forw=$this->input->post('forward');
    $ep_id = $this->input->post('emp_name');
        $data = array(

            //	'forward' => $forw,

            'ep_id' => $this->input->post('emp_name'),

            'lt_id' => $this->input->post('ltype'),

            'reason' => $this->input->post('rson'),

            'levfrom' => $lfrom1,

            'levto' => $lto1,
            'days'=>$fff,

            'status' => $stat,

            'addby' => $id,

            'addon' => $created_on

        );

        $qry = $this->db->insert('ts_leaverequest', $data);
        $qry45="select * from hr_employee l where l.id='$ep_id'";
        $query=$this->db->query($qry45);


               if($query->num_rows()>0)
        {
        $data = $query->row_array();
        $name=$data['name'];
            $code=$data['employee_code'];

        }



        return $qry;



    }

         function getleavesbyreq_id($byid)
    {
        $qry="SELECT * FROM ts_leaverequest r
            left join ts_leavetypes t  on t.lt_id = r.lt_id
            where r.lr_id = '$byid' order by r.lr_id ASC";
        $qry = $this->db->query($qry);

        //	echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
    }
    function getassigned_leav($byid)
    {
        $qry="SELECT * FROM ts_leaveassign a
            left join ts_leavetypes t on t.lt_id = a.leavetype
            where a.ep_id = '$byid' order by a.la_id DESC";
        $qry = $this->db->query($qry);

        //	echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            return $qry->result_array();
        } else{
            return array();
        }
    }
    function leaves_approve($id)
	{
		$session_array = $this->session->userdata('logged_in_admin');
		$updated_by = $session_array['id'];
		$updated_on = date('Y-m-d H:i:s');
		$data = array(
			'status' => '1',
			'updby' => $updated_by,
			'updon' => $updated_on
			);
		$qry = $this->db->where('lr_id', $id);
        $qry = $this->db->update('ts_leaverequest', $data);
       // echo $this->db->last_query();exit();

		return $qry;
	}

        function edit_leaves_applyins($id)
    {
                $lfrom=$this->input->post('lfrom');
                $lfrom=date('Y-m-d',strtotime($lfrom));
                $lto=$this->input->post('lto');
                $lto=date('Y-m-d',strtotime($lto));
    
        $data = array(
      
            'lt_id' => $this->input->post('ltype'),
            'reason' => $this->input->post('rson'),
            'levfrom' => $lfrom,
            'levto' => $lto
        );
        $this->db->where('lr_id', $id);
        $qry = $this->db->update('ts_leaverequest', $data);


        return $qry;

    }

    function leaves_assignins()
	{
		$session_array = $this->session->userdata('logged_in_admin');
		$created_by = $session_array['id'];
		$created_on = date('d-m-Y');
		$ep_id = 2;
		$stat = '0';
          $emp = $this->input->post('check_list[]');
          $contract_start=$this->input->post('fdate');
          $contract_start=date('Y-m-d',strtotime($contract_start));
          $tdate=date('Y-m-d',strtotime($this->input->post('tdate')));


        foreach ($emp as $key => $ep)
        {
		$data = array(
			'ep_id' => $ep,
			'leavetype' => $this->input->post('leave'),
			'datefrom' =>$contract_start,
			'dateto' => $tdate,
			'days' => $this->input->post('days'),
            'reason' => $this->input->post('rson'),
			'status' => $stat,
			'addby' => $created_by,
			'addon' => $created_on
			);
		$qry = $this->db->insert('ts_leaveassign', $data);


                $data1 = array(
		//	'forward' => $forw,
			'ep_id' => $ep,
			'lt_id' => $this->input->post('leave'),
			'reason' => $this->input->post('rson'),
			'levfrom' =>$contract_start,
			'levto' => $tdate,
            'days' => $this->input->post('days'),
			'status' => $stat,
			'addby' => $created_by,
			'addon' => $created_on
			);
		$qry = $this->db->insert('ts_leaverequest', $data1);


        }


		if($qry)
                {
                    return true;
                }
                else
                {
                    return false;
                }
	}
/*        function apply_leavesdelete($id){
//var_dump($id);exit();
	$data = array(
			'is_del' => '1');
		$qry = $this->db->where('lr_id', $id);
                $qry = $this->db->update('ts_leaverequest', $data);
		return $qry;
	}*/
    function apply_leavesdelete($data)
    {
        $itemgrp = $data['itemgrps'];
        $info = array('is_del' => 1);
        $this->db->where_in('lr_id', $itemgrp);
        $qry = $this->db->update('ts_leaverequest', $info);
        return $qry;
    }

        function view_leaves_emp1(){

        $emp=$this->input->post('emp');
        $month=$this->input->post('month');
        $date1=date('m');


        $qry="SELECT r.*, sum(r.days) as leaves FROM ts_leaverequest r
            
            where r.ep_id = '$emp' and (month(r.levfrom)='$month' or month(r.levto)='$month')  and r.is_del!='1' and r.status='1' order by r.lr_id ASC";
        $qry = $this->db->query($qry);

        //echo $this->db->last_query();exit;
        if($qry->num_rows()>0){
            return $qry->row_array();
        } else{
            return array();
        }
    }


}
?>