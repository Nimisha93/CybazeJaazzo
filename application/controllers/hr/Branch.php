<?php
/**
 * User: kavyasree
 * Date: 7/11/17
 * Time: 4:10 PM
 */

class Branch extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
       

        $this->load->library(array('session','form_validation','pagination'));
     $this->load->model('hr/Mdl_branch');

        $this->load->helper(array('url','form','my_common_helper','string'));
        $session_array = $this->session->userdata('logged_in_admin');
        if(!isset($session_array))
        {
            redirect('admin/login');
        }
    }
     function company(){
            $data['header'] = $this->load->view('templates/hr/edit_header','', true);
            $data['sidebar'] = $this->load->view('templates/hr/edit_sidebar','', true);
            $data['footer'] =  $this->load->view('templates/hr/edit_footer','', true);
            $data['company'] = $this->Mdl_branch->get_company();
           
        $this->load->view('hr/edit_list_company',$data);
    }

    function set_menu()
    {
         $data['header'] = $this->load->view('hr/templates/default_assets', '', true);
        $data['sidebar'] = $this->load->view('hr/templates/hr_sidebar', '', true);
        $data['footer'] = $this->load->view('hr/templates/hr_footer', '', true);
        return $data;
    }
    function get_company_details($id){
        $data['header'] = $this->load->view('templates/hr/edit_header','', true);
        $data['sidebar'] = $this->load->view('templates/hr/edit_sidebar','', true);
        $data['footer'] =  $this->load->view('templates/hr/edit_footer','', true);
        $data['company'] = $this->Mdl_branch->get_company();
        $id = intval($id);
        $country = $data['company']['name'];
        $state = $data['company']['state_name'];
        $stateData = getStatebyName($state);
        $countryData = getCountry_byName($country);
        $country_id = $countryData['id'];
        $state_id = $stateData['id'];
        $data['countries'] = get_countries();
        $data['states'] = get_states_by_country($country_id);
        $data['cities'] = get_city_by_state($state_id);
        $this->load->view('hr/update_company_details', $data);
    }

    function branch()
    {
        if(has_role('add_branch')){
        $data=$this->set_menu();
        $data['station_type']=$this->Mdl_branch-> get_stationtype();

        $data['countries']= get_countries();
        $this->load->view('hr/edit_add_branch', $data);
         }
    }

     function new_branch()
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('branch_type', 'Branch Type', 'required|trim');
            $this->form_validation->set_rules('name', 'Name ', 'required|trim');
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|min_length[7]|max_length[12]|trim|numeric|is_unique[hr_branch.contact]');
            $this->form_validation->set_rules('email', 'Email ', 'required|trim|valid_email');
            $this->form_validation->set_rules('address', 'Address ', 'trim');
            $this->form_validation->set_rules('country', 'Country', 'trim');
            $this->form_validation->set_rules('state', 'State ', 'trim');
            $this->form_validation->set_rules('city', 'City', 'trim');
         
            if($this->form_validation->run()==TRUE)
            {
                $countrydata = get_countryName_by_id($this->input->post('country'));

                $countryName = $countrydata['name'];
                $statedata = get_stateName_by_id($this->input->post('state'));
                $stateName = $statedata['name'];
                $citydata = get_cityName_by_id($this->input->post('city'));
                $cityName = $citydata['name'];
                $session_array = $this->session->userdata('logged_in_admin');
                $created_by = $session_array['id'];
                $created_on = date('Y-m-d H:i:s');

                $vendorData = array(
                    'branch_type' => $this->input->post('branch_type'),
                    'branch' => $this->input->post('name'),
                    'contact' => $this->input->post('mobile'),
                    'email' => $this->input->post('email'),
                    'address' => $this->input->post('address'),
                    'country' => $countryName,
                    'state' => $stateName,
                    'city' => $cityName,
                    'is_del' => 0,
                    'created_by' => $created_by,
                    'created_on' => $created_on
                    );
               
                $result = $this->Mdl_branch->creatBranch($vendorData, $this->input->post(),$created_by);
                if($result)
                {
                    exit(json_encode(array('status' => true)));
                }else{
                    exit(json_encode(array('status' => false, 'reason' => 'Please try again later')));
                }

            }else{
                exit(json_encode(array('status'=>FALSE,'reason'=>validation_errors())));
            }

        }else{
            show_error("Unable To Process The Request In This Way");
        }

    }
    function  get_branch(){
             if(has_role('view_branch')){
            $data=$this->set_menu();
            $data['branch']=$this->Mdl_branch->get_all_branch();
            $this->load->view('hr/edit_list_branch',$data);
             }
    }         
 function updatebranch($id)
    {
        if(has_role('update_branch')){
       $data=$this->set_menu();
        $data['station_type']=$this->Mdl_branch-> get_stationtype();
        $id = intval($id);
        $data['branchs'] = $this->Mdl_branch->getbranch($id);
        $country = $data['branchs']['result']['country'];
        $state = $data['branchs']['result']['state'];

        $stateData = getStatebyName($state);
        $countryData = getCountry_byName($country);
        $country_id = $countryData['id'];
        $state_id = $stateData['id'];
        $data['countries'] = get_countries();
        $data['states'] = get_states_by_country($country_id);
        $data['cities'] = get_city_by_state($state_id);
        $this->load->view('hr/edit_update_branch',$data);
        }
    }
    function update_branch($branchId)
    {
        if($this->input->is_ajax_request())
        {
            $this->form_validation->set_rules('branch_type', 'Branch Type', 'required|trim');
            $this->form_validation->set_rules('name', 'Name ', 'required|trim');
            $test_no=$this->input->post('check_mobile');
            $mobile=$this->input->post('mobile');
            if($mobile!=$test_no){
            $this->form_validation->set_rules('mobile', 'Mobile', 'required|min_length[7]|max_length[12]|trim|numeric|is_unique[hr_branch.contact]');
            }
            $this->form_validation->set_rules('email', 'Email ', 'required|trim|valid_email');
            $this->form_validation->set_rules('address', 'Address ', 'trim');
            $this->form_validation->set_rules('country', 'Country', 'trim');
            $this->form_validation->set_rules('state', 'State ', 'trim');
            $this->form_validation->set_rules('city', 'City', 'trim');
         
            if($this->form_validation->run()==TRUE)
            {
                $countrydata = get_countryName_by_id($this->input->post('country'));

                $countryName = $countrydata['name'];
                $statedata = get_stateName_by_id($this->input->post('state'));
                $stateName = $statedata['name'];
                $citydata = get_cityName_by_id($this->input->post('city'));
                $cityName = $citydata['name'];
                $session_array = $this->session->userdata('logged_in_admin');
                $created_by = $session_array['id'];
                $created_on = date('Y-m-d H:i:s');

                $vendorData = array(
                    'branch_type' => $this->input->post('branch_type'),
                    'branch' => $this->input->post('name'),
                    'contact' => $this->input->post('mobile'),
                    'email' => $this->input->post('email'),
                    'address' => $this->input->post('address'),
                    'country' => $countryName,
                    'state' => $stateName,
                    'city' => $cityName,
                    'is_del' => 0,
                    'updated_by' => $created_by,
                    'updated_on' => $created_on);
               
                $result = $this->Mdl_branch->updateBranch($branchId,$vendorData);
                if($result)
                {
                    exit(json_encode(array('status' => true)));
                }else{
                    exit(json_encode(array('status' => false, 'reason' => 'Please try again later')));
                }

            }else{
                exit(json_encode(array('status'=>FALSE,'reason'=>validation_errors())));
            }

        }else{
            show_error("Unable To Process The Request In This Way");
        }

    }
    function deletebranch()
    {
        if($this->input->is_ajax_request())
        {
            $qry = $this->Mdl_branch->deletebranch($this->input->post());
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


}