<?php
defined('BASEPATH') OR EXIT ('No direct script access allowed ');

class Accounts extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('accounts/mdl_accounts'));
         $this->load->library(array('session','form_validation','pagination'));
        $this->load->helper(array('url','form','my_common_helper','string'));
        $session_array = $this->session->userdata('logged_in_admin');
        if (!isset($session_array)) 
        {
            redirect('admin/login');
        }
    }

    function set_menu()
    {
        $data['default_assets'] = $this->load->view('accounts/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('accounts/templates/acc_sidebar', '', true);
        $data['footer'] = $this->load->view('accounts/templates/acc_footer', '', true);
        return $data;
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
    public function load_paging_new($base_url,$count,$per_page)
    {
        $config = array();
        $config["base_url"] = $base_url;
        $config["total_rows"] =  $count;
        $config["per_page"] = $per_page;
        //pagination customization using bootstrap styles
        $config['full_tag_open'] = '<div class="pagination pagination-centered"><ul class="page_test11  pagination">'; // I added class name 'page_test' to used later for jQuery
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

    public function index()
    {


    }

    public function add_ledger()
    {


        if (has_priv('manage_accounts')) {
        //if (has_role('manage_ledger')) {
            $data=$this->set_menu();
            $data['groups'] = $this->mdl_accounts->get_acc_type_groups();
            // $data['countries'] =get_countries();

            $this->load->view('accounts/edit_add_ledger', $data);
        }
    }

    function add_new_ledegr()
    {

        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules("group_name", "Group", "trim|required");

            $this->form_validation->set_rules("ledger", "Ledger Name", "trim|required");
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
        if (has_priv('manage_accounts')) {
        // if (has_priv('manage_ledger')) {
            $data = $this->set_menu();
            // echo json_encode($data);exit();
            $data['groups'] = $this->mdl_accounts->get_acc_type_groups();
            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $base_url = base_url() . "ledgers/";
            $result_count = $this->mdl_accounts->get_ledger_count($param);
            $per_page = 10;
            $this->load_paging($base_url,$result_count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data["data"] = $this->mdl_accounts->get_ledgers_page($param,$per_page,$page);
            if ($this->input->post('ajax', FALSE)) {
                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'status' => !empty($data["data"])?1:0,
                    'pagination' => $this->pagination->create_links()
                )));
            }
          
            $this->load->view('accounts/edit_list_ledgers',$data);
        }
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

        if (has_priv('manage_accounts')) {
        // if (has_role('manage_ledger')) {
           $data=$this->set_menu();
            $data['groups'] = $this->mdl_accounts->get_acc_type_groups();
            $data['ledgers'] = $this->mdl_accounts->get_ledegr_by_id($id);

            $this->load->view('accounts/edit_ledger_edit', $data);
        }
    }


    function edit_ledegr_by_id($id)
    {

        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules("group_name", "Group Name", "trim|required");
            $this->form_validation->set_rules("ledger", "Ledger Name", "trim|required");
            
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

    function delete_ledgers()
    {
        if ($this->input->is_ajax_request()) {
            $qry = $this->mdl_accounts->delete_ledgers($this->input->post());

            if ($qry) {
                exit(json_encode(array('status' => TRUE)));
            } else {
                exit(json_encode(array('status' => FALSE, 'reason' => 'Please try again later..!')));
            }
        } else {
            show_error("Unable to process the request in this way");
        }

    }

    function view_ledger_entry($id)
    {
        if (has_priv('manage_accounts')) {
        // if (has_role('manage_ledger')) {
            $data=$this->set_menu();
            $data['groups'] = $this->mdl_accounts->get_acc_type_groups();

            $data['ledgers'] = $this->mdl_accounts->get_ledegr_view($id);
 //echo json_encode($data['ledgers']);exit();

            $data['led_bal'] = $this->mdl_accounts->get_ledger_balance($id);


        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "accounts/accounts/view_ledger_entry/$id/";
        $result_count = $this->mdl_accounts->get_ledegr_view_count($id,$param);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(5)) ? $this->uri->segment(5) : 0;

        $data["data"] = $this->mdl_accounts->get_ledegr_view_page($id,$param,$per_page,$page);

        

         $data['led_id'] = $id;
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }
      

      // echo json_encode($data);exit();
            $this->load->view('accounts/edit_view_ledger', $data);












           
        }
    }

    function add_entries()
    {
        if (has_priv('manage_accounts')) {
        // if (has_role('manage_entries')) {
            $data['header'] = $this->load->view('templates/admin/edit_header', '', true);
            $data['sidebar'] = $this->load->view('templates/admin/edit_sidebar', '', true);
            $data['footer'] = $this->load->view('templates/admin/edit_footer', '', true);
            $data['groups'] = $this->mdl_accounts->get_acc_type_groups();
            $this->load->view('accounts/edit_add_ledger', $data);
        }
    }

    function ledgerstatement()
    {
        if (has_priv('manage_accounts')) {
        // if (has_role('view_ledger_statment')) {
           $data=$this->set_menu();
            $data['ledegrs'] = $this->mdl_accounts->get_group_ledger();
            $this->load->view('accounts/edit_ledger_statement', $data);
        }
    }


    function get_ledger_statement_by_id()
    {

        if ($this->input->is_ajax_request()) {
            $led_id = $this->input->post('ld_name');

           // echo $led_id;exit();
            $result = $this->mdl_accounts->get_ledger_statement_by_id($led_id);

            if ($this->input->post('search')) {
                $param = $this->input->post('search');
            }else{
                $param = '';
            }
            $base_url = base_url() . "ledger_statement_by_id/";
            $result_count = $this->mdl_accounts->get_ledger_statement_by_id_count($led_id,$param);
            $per_page = 10;
            $this->load_paging($base_url,$result_count,$per_page);
            $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
            $data["data"] = $this->mdl_accounts->get_ledger_statement_by_id_page($led_id,$param,$per_page,$page);
            if ($this->input->post('ajax', FALSE)) {
                exit(json_encode(array(
                    'data' => $data["data"],
                    'search'=>$param,
                    'status' => !empty($data["data"])?1:0,
                    'pagination' => $this->pagination->create_links()
                )));
            }
            if ($result) {
                exit(json_encode(array("status" => TRUE, 'data' => $data)));
            } else {
                exit(json_encode(array("status" => FALSE, "reason" => 'Database Error')));
            }
        } else {
            show_error("We are unable to process this request on this way!");
        }
    }
    function trialbalance()
    {

        if (has_priv('manage_accounts')) {
        // if (has_role('view_trial_balance')) {
           $data=$this->set_menu();
            $data['ledger_details'] = $this->mdl_accounts->get_trial_balance();


        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "trial_balance/";
        $result_count = $this->mdl_accounts->get_trial_balance_count($param);
        //echo $result_count;exit();
        $per_page = 10;
        $this->load_paging_new($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->mdl_accounts->get_trial_balance_page($param,$per_page,$page);
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'grand_tot' =>$data['ledger_details'],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }
        $this->load->view('accounts/edit_trailbalance', $data);
        }

    }
    function profitandLoss()
    {
        if (has_priv('manage_accounts')) {
        //if (has_role('view_profit_and_loss')) {
            $data['header'] = $this->load->view('templates/admin/edit_header', '', true);
            $data['sidebar'] = $this->load->view('templates/admin/edit_sidebar', '', true);
            $data['footer'] = $this->load->view('templates/admin/edit_footer', '', true);
            $data['income'] = $this->mdl_accounts->get_balancesheet_income();
            $data['expence'] = $this->mdl_accounts->get_balancesheet_expence();
            $this->load->view('accounts/edit_profit_loss_vertical', $data);
        }
    }
    function get_profitandLoss()
    {
        if (has_priv('manage_accounts')) {
        //if (has_role('view_profit_and_loss')) {
            $from = $this->input->post('from_date');
            $to = $this->input->post('todate');
            $data=$this->set_menu();
            $data['income'] = $this->mdl_accounts->get_profitloss_new_income_date($from, $to);
            $data['expence'] = $this->mdl_accounts->get_profitloss_expence_new_date($from, $to);
            // $data['opening'] = $this->mdl_accounts->opening_stock_report_rate();
            // $data['closing'] = $this->mdl_accounts->closing_stock_report_rate();
            // $closing_balance = 0;
            // $open_balnce = 0;
            // foreach ($data['opening'] as $key => $opening) {
            //     $open_qty = $opening['opening']+$opening['total_in']-$opening['total_out']-$opening['shortage_qty']+$opening['normal_ret']-$opening['exp_qty'];
            //     $open_balnce += $open_qty*$opening['selling_price'];

            // }
            // foreach ($data['closing'] as $key => $closing) {
            //     $close_qty = $closing['opening']+$closing['total_in']-$closing['total_out']-$closing['shortage_qty']+$closing['normal_ret']-$closing['exp_qty'];
            //     $closing_balance += $close_qty*$closing['selling_price'];

            // }
             if ($this->input->post('ajax', FALSE)) {

                exit(json_encode(array(
                    'income' => $data['income'],
                    // 'open_balnce' => $open_balnce,
                    // 'closing_balnce' => $closing_balance,
                    'expence' => $data['expence'],
                    'status' =>true
                )));
            }


            $this->load->view('accounts/edit_profit_loss_result', $data);
        }
    }
    function get_balanceSheet()
    {
        if (has_priv('manage_accounts')) {
        //if (has_role('view_profit_and_loss')) {
            $from = $this->input->post('from_date');
            $to = $this->input->post('todate');
           $data=$this->set_menu();
            $data['assets'] = $this->mdl_accounts->get_balancesheet_new_assetes($from, $to);
            $data['liabilities'] = $this->mdl_accounts->get_balancesheet_new_liabilities($from, $to);

             $data['income'] = $this->mdl_accounts->get_profitloss_new_income_date($from, $to);
            $data['expence'] = $this->mdl_accounts->get_profitloss_expence_new_date($from, $to);

             if ($this->input->post('ajax', FALSE)) {

                exit(json_encode(array(
                    'assets' => $data['assets'],
                    'liabilities' => $data['liabilities'],

                    'income'=>$data['income'],
                    'expence'=>$data['expence'],
                    'status' =>true
                )));
            }


            $this->load->view('accounts/edit_balancesheet_result', $data);
        }
    }
    function get_profit_loss_by_date()
    {
        if (has_priv('manage_accounts')) {
        //if (has_role('view_profit_and_loss')) {
            $data['header'] = $this->load->view('templates/admin/edit_header', '', true);
            $data['sidebar'] = $this->load->view('templates/admin/edit_sidebar', '', true);
            $data['footer'] = $this->load->view('templates/admin/edit_footer', '', true);
            $from = $this->input->get('mindate');
            $date_from = date_php_to_mysql($from);
            $to = $this->input->get('maxdate');
            $date_to = date_php_to_mysql($to);
            $data['date_from'] = $from;
            $data['date_to'] = $to;
            $data['income'] = $this->mdl_accounts->get_profitloss_income_date($date_from, $date_to);
            $data['expence'] = $this->mdl_accounts->get_profitloss_expence_date($date_from, $date_to);
            $this->load->view('accounts/edit_profit_loss_date', $data);
        }
    }
    function balanceSheet()
    {
        if (has_priv('manage_accounts')) {
        //if (has_role('view_balance_sheet')) {
            $data['header'] = $this->load->view('templates/admin/edit_header', '', true);
            $data['sidebar'] = $this->load->view('templates/admin/edit_sidebar', '', true);
            $data['footer'] = $this->load->view('templates/admin/edit_footer', '', true);
            $data['income'] = $this->mdl_accounts->get_balancesheet_income();
            $data['expence'] = $this->mdl_accounts->get_balancesheet_expence();
            $data['assets'] = $this->mdl_accounts->get_balancesheet_assetes();
            $data['liabilities'] = $this->mdl_accounts->get_balancesheet_liabilities();
            $this->load->view('accounts/edit_balancesheet_vertical', $data);
        }
    }
    function get_trialbalance_by_date()
    {

        if ($this->input->is_ajax_request()) {
            
            $result = $this->mdl_accounts->get_trial_balance_bydate();


        if ($this->input->post('search')) {
            $param = $this->input->post('search');
        }else{
            $param = '';
        }
        $base_url = base_url() . "get_trialbalance_by_date/";
        $result_count = $this->mdl_accounts->get_trial_balance_by_date_count($param);
        $per_page = 10;
        $this->load_paging($base_url,$result_count,$per_page);
        $page = ($this->uri->segment(2)) ? $this->uri->segment(2) : 0;
        $data["data"] = $this->mdl_accounts->get_trial_balance_by_date_page($param,$per_page,$page);
        if ($this->input->post('ajax', FALSE)) {
            exit(json_encode(array(
                'data' => $data["data"],
                'search'=>$param,
                'status' => !empty($data["data"])?1:0,
                'pagination' => $this->pagination->create_links()
            )));
        }






            if ($result) {
                exit(json_encode(array("status" => TRUE, 'data' => $data)));
            } else {
                exit(json_encode(array("status" => FALSE, "reason" => 'Database Error')));
            }
        } else {
            show_error("We are unable to process this request on this way!");
        }
    }

         public function add_financial_year()
    {


            $data=$this->set_menu();
           $data['fin_year'] = get_current_financial_year();
            // $data['countries'] =get_countries();

            $this->load->view('accounts/add_financial_year', $data);
        
    }

    function update_financial_year()
    {
               if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules("f_start", "Start Year", "trim|required");
            $this->form_validation->set_rules("f_end", "End Year", "trim|required");
//            $this->form_validation->set_rules("ledger","Ledger Name","trim|required");
            if ($this->form_validation->run() == TRUE) {
                $qry = $this->mdl_accounts->update_financial_year($this->input->post());
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
