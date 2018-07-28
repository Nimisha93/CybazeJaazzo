<?php


class Timesheet extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('hr/Mdl_timesheet'));
        $session_array = $this->session->userdata('logged_in_admin');

          $this->load->library(array('session','form_validation','pagination'));

        $this->load->helper(array('url','form','my_common_helper','string'));
        if(!isset($session_array))
        {
            redirect('admin/login');
        }
    }

    function set_menu()
    {
        $data['header'] = $this->load->view('hr/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('hr/templates/hr_sidebar', '', true);
        $data['footer'] = $this->load->view('hr/templates/hr_footer', '', true);
        return $data;
    }
   function leavetype()
	{
        if(has_role('view_levetype')){
		$data=$this->set_menu();
		$data['leaves'] = $this->Mdl_timesheet->gettotleaves();
		$this->load->view('hr/leave_type_report', $data);
        }
	}
    function leaves_addview()
	{
        if(has_role('add_levetype')){
		$data=$this->set_menu();
		$this->load->view('hr/ts_leavesadd', $data);
        }
	}
   function leaves_add()
	{

            if($this->input->is_ajax_request()){
			$this->form_validation->set_rules("title","Leave Type","trim|required|htmlspecialchars");
			
			if( $this->form_validation->run() == TRUE )
			{

				// $get_supplierId = $this->vendor_model->generateSupplierId();
				$result=$this->Mdl_timesheet->leaves_add();
				if($result){

				
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
        function leaves_edit($id)
	{
            if(has_role('edit_levetype')){
		$data=$this->set_menu();
		$data['leaves'] = $this->Mdl_timesheet->gettleave($id);
		$this->load->view('hr/ts_leavesedit', $data);
            }
	}
        function leaves_editins()
	{
		if($this->input->is_ajax_request()){
			$this->form_validation->set_rules("title","Leave Type","trim|required|htmlspecialchars");
			
			if( $this->form_validation->run() == TRUE )
			{
				// $get_supplierId = $this->vendor_model->generateSupplierId();
				$result=$this->Mdl_timesheet->leaves_editins();
				if($result){
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
/*	function leaves_delete($id)
	{

        $data = $this->Mdl_timesheet->leavesdelete($id);
        if($data){
            exit(json_encode(array('status'=>TRUE)));
        } else{
            exit(json_encode(array('status'=>FALSE, 'reason'=> 'Databse Error')));
        }
	}*/
	   function leaves_delete()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->Mdl_timesheet->leavesdelete($this->input->post());
            if($qry)
            {
                exit(json_encode(array('status'=>TRUE)));
            }else{
                exit(json_encode(array('status'=>FALSE, 'reason'=>'Please try again later..!')));
            }
        }else{
            show_error("Unable to process the request in this way");
        }
    }
//        function leaves()
//	{
//		$data=$this->set_menu();
//		$data['leaves'] = $this->Mdl_timesheet->getleaves();
//		//$data['days'] = $this->timesheet_model->getleavedays();
//		$this->load->view('hr/ts_leaves', $data);
//	}
       function leaves()

	{
             if(has_role('view_leaves')){

		$data=$this->set_menu();

		$data['leaves'] = $this->Mdl_timesheet->getleaves();

		$data['emp'] = $this->Mdl_timesheet->getemployees();

		$this->load->view('hr/ts_leaves', $data);
             }

	}
        function leaves_applyview()
	{
             if(has_role('add_leave')){
		$session_array = $this->session->userdata('logged_in_admin');
		$id = $session_array['id'];
		$data=$this->set_menu();
                $data['leaves_type'] = $this->Mdl_timesheet->gettotleaves();
                $data['employees'] = $this->Mdl_timesheet->employees();
		$data['leaves'] = $this->Mdl_timesheet->getleavesbyid($id);
		$data['reqemp'] = $this->Mdl_timesheet->get_req_employee();
            //    $data['forward'] = $this->Mdl_timesheet->get_forward() ;


        $this->load->view('hr/ts_leaves_apply', $data);
             }
	}
        function leaves_apply()
    {

                $result=$this->Mdl_timesheet->leaves_apply();
                if($result){

               
                    exit(json_encode(array("status"=>TRUE)));
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }




    }
    function leavesbyid($id, $lr_id)
	{
         if(has_role('edit_leave')){
		$data=$this->set_menu();
		//$data['leaves'] = $this->timesheet_model->getleavesbyid($id);
        $data['leaves'] = $this->Mdl_timesheet->getleavesbyreq_id($lr_id);
        $data['assigned_leaves'] = $this->Mdl_timesheet->getassigned_leav($id);
        $data['leaves_type'] = $this->Mdl_timesheet->gettotleaves();
      //  $data['forward'] = $this->Mdl_timesheet->get_forward() ;
		$this->load->view('hr/ts_leavesbyid', $data);
         }
	}
        function leaves_approve($id)
	{
		
		$result=$this->Mdl_timesheet->leaves_approve($id);
				if($result){
					exit(json_encode(array("status"=>TRUE)));
				}else{
					exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
				}

	}
        function leaves_assignview()
	{
             if(has_role('view_leave_assign')){
		$data=$this->set_menu();
		$data['employees'] = $this->Mdl_timesheet->employees();
		$data['leaves'] = $this->Mdl_timesheet->gettotleaves();
		$this->load->view('hr/ts_leavesassign', $data);
             }
	}
        function edit_leaves_applyins($id)
	{
		if($this->input->is_ajax_request()){
			$this->form_validation->set_rules("ltype","Leave Type","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("rson","Leave Reason","trim|required|htmlspecialchars");
			$this->form_validation->set_rules("lfrom","Leave From","trim|required|htmlspecialchars");

			if( $this->form_validation->run() == TRUE )
			{
				$result=$this->Mdl_timesheet->edit_leaves_applyins($id);
				if($result){
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
        function leave_assignins()
	{


				$result=$this->Mdl_timesheet->leaves_assignins();
				if($result){
	 
					exit(json_encode(array("status"=>TRUE)));
				}else{
					exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
				}



	}
/*        function apply_leave_delete($id){



	$data = $this->Mdl_timesheet->apply_leavesdelete($id);
        if($data){
            exit(json_encode(array('status'=>TRUE)));
        } else{
            exit(json_encode(array('status'=>FALSE, 'reason'=> 'Databse Error')));
        }

	}*/
	   function apply_leave_delete()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->Mdl_timesheet->apply_leavesdelete($this->input->post());
            if($qry)
            {
                exit(json_encode(array('status'=>TRUE)));
            }else{
                exit(json_encode(array('status'=>FALSE, 'reason'=>'Please try again later..!')));
            }
        }else{
            show_error("Unable to process the request in this way");
        }
    }

         function view_leaves_emp(){
        if($this->input->is_ajax_request()){

                // $get_supplierId = $this->vendor_model->generateSupplierId();
                $result=$this->Mdl_timesheet->view_leaves_emp1();
                if($result){
                    exit(json_encode(array("status"=>TRUE,'data'=>$result)));
                }else{
                    exit(json_encode(array("status"=>FALSE,"reason"=>'Database Error')));
                }


        }
        else{
            show_error("We are unable to process this request on this way!");
        }

    }
        
}
?>