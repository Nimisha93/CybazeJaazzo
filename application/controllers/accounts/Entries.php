<?php
defined('BASEPATH') OR EXIT ('No direct script access allowed ');

class Entries extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('accounts/mdl_entries', 'accounts/mdl_accounts'));

                 $this->load->library(array('session','form_validation','pagination'));
        $this->load->helper(array('url','form','my_common_helper','string'));

        $session_array = $this->session->userdata('logged_in_admin');
        if (!isset($session_array)) {
            redirect('admin/login');
        }
    }
    public function load_paging($base_url,$count,$per_page)
    {
        $config = array();
        $config["base_url"] = $base_url;
        $config["total_rows"] =  $count;
        $config["per_page"] = $per_page;
        //pagination customization using bootstrap styles
        $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test  pagination">'; // I added class name 'page_test' to used later for jQuery
        $config['full_tag_close'] = '</ul></div><!--pagination-->';
        $config['first_link'] = '&laquo; First';
        $config['first_tag_open'] = '<li class="prev page">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Last &raquo;';
        $config['last_tag_open'] = '<li class="next page">';
        $config['last_tag_close'] = '</li>';
        $config['next_link'] = 'Next &rarr;';
        $config['next_tag_open'] = '<li class="next page">';
        $config['next_tag_close'] = '</li>';
        $config['prev_link'] = '&larr; Previous';
        $config['prev_tag_open'] = '<li class="prev page">';
        $config['prev_tag_close'] = '</li>';
        $config['cur_tag_open'] = "<li class='disabled'><li class='active'><a href='#'>";
        $config['cur_tag_close'] = "<span class='sr-only'></span></a></li>";
        $config['num_tag_open'] = '<li class="page">';
        $config['num_tag_close'] = '</li>';
        $this->pagination->initialize($config);
    }

    function set_menu()
    {
        $data['default_assets'] = $this->load->view('accounts/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('accounts/templates/acc_sidebar', '', true);
        $data['footer'] = $this->load->view('accounts/templates/acc_footer', '', true);
        return $data;
    }
    public function add_entries()
    {

        if (has_priv('manage_accounts')) {
        //if (has_role('manage_entries')) {
           $data=$this->set_menu();
            $data['entries'] = $this->mdl_entries->get_entry_type();
            $data['en_number'] = $this->mdl_entries->create_entry_no();
            $data['groups'] = $this->mdl_entries->get_acc_type_group_ledger();
            // $data['countries'] =get_countries();

            $this->load->view('accounts/edit_add_entries', $data);
        }
    }


    function add_new_entry()
    {

        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules("en_type", "Entry Type", "trim|required");
            $this->form_validation->set_rules("ledger_opening_type[]", "Ledger Opening Type", "trim|required");
            $this->form_validation->set_rules("number", "Entry Number", "trim|required");
            $this->form_validation->set_rules("ledger_name[]", "Ledger Name", "trim|required");


//            $this->form_validation->set_rules("description","Note","trim|required");
            if ($this->form_validation->run() == TRUE) {
                $qry = $this->mdl_entries->add_new_entry();
                if ($qry) {
                    exit(json_encode(array('status' => TRUE)));
                } else {
                    exit(json_encode(array('status' => FALSE, 'reason' => 'Please try again later..!')));
                }
            } else {
                exit(json_encode(array('status' => FALSE, 'reason' => validation_errors())));
            }
        } else {
            show_error("Unable to process the request in this way");
        }

    }


    




    function get_entries()
    {
        // if (has_role('manage_entries')) {

        //   $data=$this->set_menu();
        //     $data['entries'] = $this->mdl_entries->get_entries();
        //     // $data['en_number'] = $this->mdl_entries->create_entry_no();
        //     // $data['groups'] = $this->mdl_entries->get_acc_type_group_ledger();
        //     // $data['countries'] =get_countries();

        //     $this->load->view('accounts/edit_list_entries', $data);
        // }

        if (has_priv('manage_accounts')) {
        // if (has_priv('manage_entries')) {
            $data = $this->set_menu();
          // echo json_encode($data);exit();

            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $base_url = base_url() . "entries/";
            $result_count = $this->mdl_entries->get_entries_count($param);
            $per_page = 10;
            $this->load_paging($base_url,$result_count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data["data"] = $this->mdl_entries->get_entries($param,$per_page,$page);
            if ($this->input->post('ajax', FALSE)) {
                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'status' => !empty($data["data"])?1:0,
                    'pagination' => $this->pagination->create_links()
                )));
            }
          
            $this->load->view('accounts/edit_list_entries',$data);
        }

    }


    function get_cur_bal_ledger_by_id($id)
    {

        $data = $this->mdl_accounts->get_ledger_balance($id);
        if ($data) {
            exit(json_encode(array('status' => TRUE, 'data' => $data)));
        } else {
            exit(json_encode(array('status' => FALSE, 'data' => 0)));
        }

    }

    function get_entry_by_id($id)
    {
        if (has_priv('manage_accounts')) {
        // if (has_role('manage_entries')) {

            $data=$this->set_menu();
            $data['entry'] = $this->mdl_entries->get_entries_by_id($id);

            $data['entries'] = $this->mdl_entries->get_entry_type();
            $data['en_number'] = $this->mdl_entries->create_entry_no();
            $data['groups'] = $this->mdl_entries->get_acc_type_group_ledger();
            $data['entry_items'] = $this->mdl_entries->get_entry_items_by_id($id);
            // $data['en_number'] = $this->mdl_entries->create_entry_no();
            // $data['groups'] = $this->mdl_entries->get_acc_type_group_ledger();
            // $data['countries'] =get_countries();

            $this->load->view('accounts/edit_entries_edit', $data);
        }

    }

    function edit_entry_by_id($id)
    {


        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules("en_type", "Entry Type", "trim|required");
            $this->form_validation->set_rules("ledger_opening_type[]", "Ledger Opening Type", "trim|required");
            $this->form_validation->set_rules("number", "Entry Number", "trim|required");
            $this->form_validation->set_rules("ledger_name[]", "Ledger Name", "trim|required");
            if ($this->form_validation->run() == TRUE) {
                $qry = $this->mdl_entries->update_entry_items($id);
                if ($qry) {
                    exit(json_encode(array('status' => TRUE)));
                } else {
                    exit(json_encode(array('status' => FALSE, 'reason' => 'Please try again later..!')));
                }
            } else {
                exit(json_encode(array('status' => FALSE, 'reason' => validation_errors())));
            }
        } else {
            show_error("Unable to process the request in this way");
        }

    }

    function delete_entry_items()
    {

        if ($this->input->is_ajax_request()) {
            $qry = $this->mdl_entries->delete_entry_items($this->input->post());
            if ($qry) {
                exit(json_encode(array('status' => TRUE)));
            } else {
                exit(json_encode(array('status' => FALSE, 'reason' => 'Please try again later..!')));
            }
        } else {
            show_error("Unable to process the request in this way");
        }
    }

    function delete_entry()
    {

        if ($this->input->is_ajax_request()) {
            $qry = $this->mdl_entries->delete_entry($this->input->post());
            if ($qry) {
                exit(json_encode(array('status' => TRUE)));
            } else {
                exit(json_encode(array('status' => FALSE, 'reason' => 'Please try again later..!')));
            }
        } else {
            show_error("Unable to process the request in this way");
        }
    }

    function view_entry_by_id($id)
    {

        if (has_priv('manage_accounts')) {
        // if (has_role('manage_entries')) {
            $data['header'] = $this->load->view('templates/admin/edit_header', '', true);
            $data['sidebar'] = $this->load->view('templates/admin/edit_sidebar', '', true);
            $data['footer'] = $this->load->view('templates/admin/edit_footer', '', true);
            $data['entry'] = $this->mdl_entries->get_entries_by_id($id);

            $data['entries'] = $this->mdl_entries->get_entry_type();
            $data['en_number'] = $this->mdl_entries->create_entry_no();
            $data['groups'] = $this->mdl_entries->get_acc_type_group_ledger();
            $data['entry_items'] = $this->mdl_entries->get_entry_items_by_id($id);

            // $data['en_number'] = $this->mdl_entries->create_entry_no();
            // $data['groups'] = $this->mdl_entries->get_acc_type_group_ledger();
            // $data['countries'] =get_countries();

            $this->load->view('accounts/edit_view_entry', $data);
        }
    }

    function add_new_ledegr()
    {

        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules("group_name", "Group", "trim|required");
//            $this->form_validation->set_rules("tax_types[]","Tax Type","trim|required");
            $this->form_validation->set_rules("ledger", "Ledger Name", "trim|required");
//            $this->form_validation->set_rules("ledgerOpBalanceDc","Ledger Opening Balance Dc","trim|required");
//            $this->form_validation->set_rules("openigbal","Opening Balance","trim|required");

//            $this->form_validation->set_rules("description","Note","trim|required");
            if ($this->form_validation->run() == TRUE) {
                $qry = $this->mdl_accounts->add_new_ledegr($this->input->post());
                if ($qry) {
                    exit(json_encode(array('status' => TRUE)));
                } else {
                    exit(json_encode(array('status' => FALSE, 'reason' => 'Please try again later..!')));
                }
            } else {
                exit(json_encode(array('status' => FALSE, 'reason' => validation_errors())));
            }
        } else {
            show_error("Unable to process the request in this way");
        }

    }

    function addGroup()
    {

        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules("groupname", "Group Name", "trim|required");
            $this->form_validation->set_rules("sel_typee", "Account Type", "trim|required");
            if ($this->form_validation->run() == TRUE) {
                $qry = $this->mdl_accounts->addGroup($this->input->post());
                $result = $this->mdl_accounts->get_acc_type_groups();
                if ($qry) {
                    exit(json_encode(array('status' => TRUE, 'result' => $result)));
                } else {
                    exit(json_encode(array('status' => FALSE, 'reason' => 'Please try again later..!')));
                }
            } else {
                exit(json_encode(array('status' => FALSE, 'reason' => validation_errors())));
            }
        } else {
            show_error("Unable to process the request in this way");
        }

    }

    function get_ledgers()
    {

        $data['header'] = $this->load->view('templates/admin/edit_header', '', true);
        $data['sidebar'] = $this->load->view('templates/admin/edit_sidebar', '', true);
        $data['footer'] = $this->load->view('templates/admin/edit_footer', '', true);
        $data['ledgers'] = $this->mdl_accounts->get_ledgers();
        $data['groups'] = $this->mdl_accounts->get_acc_type_groups();

        $this->load->view('accounts/edit_list_ledgers', $data);
    }

    function editgroup($id)
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules("groupname", "Group Name", "trim|required");
            $this->form_validation->set_rules("sel_typee", "Account Type", "trim|required");
            if ($this->form_validation->run() == TRUE) {
                $qry = $this->mdl_accounts->editgroup($id, $this->input->post());
                if ($qry) {
                    exit(json_encode(array('status' => TRUE)));
                } else {
                    exit(json_encode(array('status' => FALSE, 'reason' => 'Please try again later..!')));
                }
            } else {
                exit(json_encode(array('status' => FALSE, 'reason' => validation_errors())));
            }
        } else {
            show_error("Unable to process the request in this way");
        }

    }

    public function edit_ledger($id)
    {


        $data['header'] = $this->load->view('templates/admin/edit_header', '', true);
        $data['sidebar'] = $this->load->view('templates/admin/edit_sidebar', '', true);
        $data['footer'] = $this->load->view('templates/admin/edit_footer', '', true);
        $data['groups'] = $this->mdl_accounts->get_acc_type_groups();
        $data['ledgers'] = $this->mdl_accounts->get_ledegr_by_id($id);

        $this->load->view('accounts/edit_ledger_edit', $data);
    }


    function edit_ledegr_by_id($id)
    {

        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules("group_name", "Group Name", "trim|required");
            $this->form_validation->set_rules("ledger", "Ledger Name", "trim|required");
//            $this->form_validation->set_rules("ledger","Ledger Name","trim|required");
            if ($this->form_validation->run() == TRUE) {
                $qry = $this->mdl_accounts->edit_ledegr_by_id($id, $this->input->post());
                if ($qry) {
                    exit(json_encode(array('status' => TRUE)));
                } else {
                    exit(json_encode(array('status' => FALSE, 'reason' => 'Please try again later..!')));
                }
            } else {
                exit(json_encode(array('status' => FALSE, 'reason' => validation_errors())));
            }
        } else {
            show_error("Unable to process the request in this way");
        }

    }


}


?>
