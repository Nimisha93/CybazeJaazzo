<?php

/**
 *

 */

class Resignation extends CI_Controller

{

    function __construct()

    {

        parent::__construct();

        $this->load->helper('form');

        $this->load->helper(array('url', 'string'));

        $this->load->model(array('hr/Mdl_resignation'));

        $this->load->library(array('session', 'form_validation'));

        $session_array = $this->session->userdata('logged_in_admin');

        if (!isset($session_array)) {

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

    public function index()

    {


        if (has_role('add_resignation')) {
            $data = $this->set_menu();


            $data['employees'] = $this->Mdl_resignation->get_employee();

            //  $data['forward']=$this->Mdl_resignation->get_forward();


            $this->load->view('hr/hr_employee_resign', $data);

        }


    }

    public function add_new_resignation()

    {
       // var_dump($this->input->post());exit;

        $this->form_validation->set_rules('res_emp', 'Employee', 'required|trim');
        $this->form_validation->set_rules('n_date', 'Notice Date', 'required|trim');
        $this->form_validation->set_rules('r_date', 'Resign Date', 'required|trim');
        $this->form_validation->set_rules('reason', 'Reason', 'required|trim');
        $this->form_validation->set_rules('add_info', 'Additional Info', 'trim');
        if ($this->form_validation->run() == TRUE) {
            $result = $this->Mdl_resignation->add_new_res();

            if ($result) {


                exit(json_encode(array("status" => TRUE)));

            } else {

                exit(json_encode(array("status" => FALSE, "reason" => 'Database Error')));

            }


        } else {
            exit(json_encode(array("status" => FALSE, 'reason' => validation_errors())));

        }


    }

    function res_emp_list()

    {
        if (has_role('view_resignation')) {
            $data = $this->set_menu();

            $data['res'] = $this->Mdl_resignation->get_list();


            $this->load->view('hr/hr_view_res_list', $data);
        }

    }

    function get_resignation($id)

    {

        if (has_role('edit_resignation')) {

            $data = $this->set_menu();

            $data['res'] = $this->Mdl_resignation->get_resignation_by_id($id);
            $data['d'] = $this->Mdl_resignation->get_names_emp();
            $data['status'] = $this->Mdl_resignation->get_employee_status();

            // $data['forward'] = $this->Mdl_resignation->get_forward();


            $this->load->view('hr/hr_edit_resignation', $data);

        }


    }

    function edit_resignation($id)

    {

        if ($this->input->is_ajax_request()) {


            $result = $this->Mdl_resignation->editresignation($id);

            if ($result) {

                exit(json_encode(array("status" => TRUE)));

            } else {

                exit(json_encode(array("status" => FALSE, "reason" => 'Database Error')));

            }


        } else {

            show_error("We are unable to process this request on this way!");

        }


    }

    function delete_resignation($id)

    {

        $data = $this->Mdl_resignation->delete_resignation_by_id($id);

        if ($data) {


            ?>

            <script>alert('Successfully Deleted  Resignation');

                window.location = '<?php echo base_url();?>hr/resignation/res_emp_list'</script>;

            <?php


            exit(json_encode(array('status' => TRUE)));

        } else {

            exit(json_encode(array('status' => FALSE, 'reason' => 'Databse Error')));

        }

    }
    function delete_resignations()
    {
        $data = $this->Mdl_resignation->delete_resignations($this->input->post());
        if($data){
            exit(json_encode(array('status'=>TRUE)));
        } else{
            exit(json_encode(array('status'=>FALSE, 'reason'=> 'Databse Error')));
        }
    }

}

?>	