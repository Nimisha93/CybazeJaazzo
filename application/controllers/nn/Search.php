<?php
defined('BASEPATH') OR exit('No direct script access allowed');

Class Search extends CI_Controller{

    function __construct(){

        parent ::__construct();
        $this->load->library(array('session','form_validation'));
        $this->load->model(array('search_model','user/user_model','user/product_model','user/Delear_model'));
        $this->load->helper(array('url','form'));
    }

    public function search_category()
    {
        // load model
        $search_data = $this->input->post('search_data');

        $result = $this->search_model->get_search_category($search_data);
        // print_r($result);
        // exit();
        if (!empty($result))
        {
            $base_link="search/get_search_result/";
            echo "<h4 style='color: #042f6d;'>Search Categories</h4>";
            echo "<div class='options'>";
            foreach ($result as $row):
                $key=$row['title'];
                //    echo $key; exit();
                //    $term = mysqli_real_escape_string($link, $_REQUEST['term']);
                //    <a href="http://localhost/green/<li"></a>
                echo "<li class='search_cls'><a href=".base_url().$base_link.$key.">".$row['title']."</a></li>";
            endforeach;
            echo "<div>";
        }
        else
        {
            echo "<h4 style='color: #042f6d;'>Search Categories</h4>";
            echo "<li> <em> Not found ... </em> </li>";
        }

    }

    public function search_recent()
    {
        // load model
        $login_id=0;
        $session_array = $this->session->userdata('logged_in_user');
        if(isset($session_array)){
            $login_id = $session_array['id'];
        }
    if($login_id!=0)
    {
        $search_data = $this->input->post('search_data');
        $result = $this->search_model->get_search_recent($search_data);
        if (!empty($result))
        {
          $base_link2="search/get_search_recentcat/";
          $base_link1="home/product_details/";
          echo "<h4 style='color: #042f6d;'>Recent Searches</h4>";
          echo "<div class='options'>";
            foreach ($result as $row):
            $key=$row['search_id'];
            $key1=$row['search_type'];
            $key2=$row['name'];
            $key3=$row['title'];
            //    $term = mysqli_real_escape_string($link, $_REQUEST['term']);
            //    <a href="http://localhost/green/<li"></a>
            if($key1==1){
                echo "<li class='search_cls'><a href=".base_url().$base_link1.$key.">".$key2."..</a></li>";
                }
                elseif($key1==2){
                    echo "<li class='search_cls'><a href=".base_url().$base_link2.$key.">".$key3.".</a></li>";
                    }
            endforeach;
            echo "<div>";
        }
        else
        {
          echo "<h4 style='color: #042f6d;'>Recent Searches</h4>";
          echo "<li> <em> Not found ... </em> </li>";
        }
    }
    else
        {
            echo "<li> <em> No data ... </em> </li>";
        }
    }

    public function search_popular()
    {
        // load model
        $base_link1="home/product_details/";
        $search_data = $this->input->post('search_data');
        $result = $this->search_model->get_search_popular($search_data);
        // echo "pop"; print_r($result); exit();
        if (!empty($result))
        {
            $base_link="assets/admin/products/";
            echo "<h4 style='color: #042f6d;'>Popular Searches</h4>";
            foreach ($result as $row):
                $kid=$row['id'];
                $key=$row['name'];
                $img=$row['image'];
                $dsp=$row['description'];
                $qty=$row['quantity'];
                $cost=$row['cost'];
                // echo "<li class='search_cls'><a href=".base_url().$base_link.$key.">".$row['name']."</a></li>";
                echo "<div class='col-lg-6 cart-entry'> <div class='col-lg-4'> <div class='vnm'> <a class='image'>
                      <img style='height:60px; width:60px;' src=".base_url().$base_link.$img."> </a> </div> </div> <div class='col-lg-8 content'>
                      <a class='title' href=".base_url().$base_link1.$kid.">".$key."</a> <div class='quantity'>
                      ".$qty." qty</div> <div class='price'> ₹ ".$cost."</div> </div> </div>";
            endforeach;
        }
        else
        {
            echo "<h4 style='color: #042f6d;'>Popular Searches</h4>";
            echo "<li> <em> Not found ... </em> </li>";
        }
    }
    public function search_products()
    {
        // load model
        $base_link1="home/product_details/";
        $search_data = $this->input->post('search_data');
        $result = $this->search_model->get_search_products($search_data);
        // echo "prod"; print_r($result); exit();
         if (!empty($result))
         {
            $base_link="assets/admin/products/";
            echo "<h4 style='color: #042f6d;'>Products</h4>";
            foreach ($result as $row):
                $kid=$row['id'];
                $key=$row['name'];
                $img=$row['image'];
                $dsp=$row['description'];
                $qty=$row['quantity'];
                $cost=$row['cost'];
                // echo "<li class='search_cls'><a href=".base_url().$base_link.$key.">".$row['name']."</a></li>";
                echo "<div class='col-lg-6 cart-entry'> <div class='col-lg-4'> <div class='vnm'> <a class='image'>
                      <img style='height:60px; width:60px;' src=".base_url().$base_link.$img."> </a> </div> </div> <div class='col-lg-8 content'>
                      <a class='title' href=".base_url().$base_link1.$kid.">".$key."</a> <div class='quantity'>
                      ".$qty." qty</div> <div class='price'> ₹ ".$cost."</div> </div> </div>";
            endforeach;
        }
        else
        {
            echo "<h4 style='color: #042f6d;'>Products</h4>";
            echo "<li> <em> Not found ... </em> </li>";
        }
    }
    public function search_popular1()
    {
        // load model
        $search_data = $this->input->post('search_data');
        $result = $this->search_model->get_search_popular1($search_data);
        // print_r($result);
        // exit();
        if (!empty($result))
        {
            $base_link="search/get_search_result/";
            echo "<h4 style='color: #042f6d;'>Popular Searches</h4>";
            echo "<div class='options'>";
            foreach ($result as $row):
                $key=$row['name'];
                //    echo $key; exit();
                //    $term = mysqli_real_escape_string($link, $_REQUEST['term']);
                //    <a href="http://localhost/green/<li"></a>
                echo "<li class='search_cls'><a href=".base_url().$base_link.$key.">".$key."</a></li>";
            endforeach;
            echo "</div>";
        }
        else
        {
            echo "<h4 style='color: #042f6d;'>Popular Searches</h4>";
            echo "<li> <em> Not found ... </em> </li>";
        }
    }
    public function search_chanelpartner()
    {
        // load model
        $search_data = $this->input->post('search_data');
        $result = $this->search_model->get_search_chanelpartner($search_data);
        // print_r($result);
        // exit();
        if (!empty($result))
        {
            $base_link="assets/admin/brand/";
            echo "<h4 style='color: #042f6d;'>Popular Dealers</h4>";
            echo "<div class='options'>";
            foreach ($result as $row):
                $key=$row['name'];
                $img=$row['brand_image'];
                $phone=$row['phone'];

                //    echo $key; exit();
                //    $term = mysqli_real_escape_string($link, $_REQUEST['term']);
                //    <a href="http://localhost/green/<li"></a>
                echo "<div class='col-lg-6 cart-entry'> <div class='col-lg-4'> <div class='vnm'> <a class='image'>
                      <img style='height:60px; width:60px;' src=".base_url().$base_link.$img."> </a> </div> </div> <div class='col-lg-8 content'>
                      <a class='title' href=".base_url().$key.">".$key."</a> <div class='quantity'>
                      </div> <div class='price'> call: ".$phone."</div> </div> </div>";
            endforeach;
            echo "</div>";
        }
        else
        {
            echo "<h4 style='color: #042f6d;'>Popular Dealers</h4>";
            echo "<li> <em> Not found ... </em> </li>";
        }
    }
    public function search_products1()
    {
        // load model
        $search_data = $this->input->post('search_data');
        $result = $this->search_model->get_search_products1($search_data);
        // print_r($result);
        // exit();
        if (!empty($result))
        {
            $base_link="search/get_search_result/";
            echo "<h4 style='color: #042f6d;'>Search Products</h4>";
            echo "<div class='options'>";
            foreach ($result as $row):
                $key=$row['name'];
                //    echo $key; exit();
                //    $term = mysqli_real_escape_string($link, $_REQUEST['term']);
                //    <a href="http://localhost/green/<li"></a>
                echo "<li class='search_cls'><a href=".base_url().$base_link.$key.">".$key."</a></li>";
            endforeach;
            echo "</div>";
        }
        else
        {   
            echo "<h4 style='color: #042f6d;'>Search Products</h4>";
            echo "<li> <em> Not found ... </em> </li>";
        }
    }

    function get_search_result($key){
            $session_array = $this->session->userdata('logged_in_user');
            $login_id = $session_array['id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            // echo json_encode($data['wallet']); exit();
            $data['channel_partner'] = $this->user_model->get_channel_partner();
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
             $data['product'] = $this->product_model->get_product_view();
    //     $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
    
           $data['category']=$this->search_model->get_cpcategory();
           $data['subcategory']=$this->search_model->get_cpscategory();
           $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
           $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
           $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
            
    //     $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
    //     $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
    
           $data['results']=$this->search_model->get_search_by_key($key);
           $this->load->view('public/edit_search_product',$data,$key);
    }

    function  get_all_delears()
    {
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $data['delears']= $this->Delear_model->get_all_delears();

        //  echo json_encode($data['delears']);


        $this->load->view('public/edit_show_dealers',$data);
    }

    function get_search_recent($key){
            $session_array = $this->session->userdata('logged_in_user');
            $login_id = $session_array['id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
           $data['category']=$this->search_model->get_cpcategory();
           $data['subcategory']=$this->search_model->get_cpscategory();
           $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
           $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
           $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
           $data['results']=$this->search_model->get_search_by_key($key);
           $this->load->view('public/edit_search_product',$data,$key);
    }
    function get_search_recentpro($key){
            $session_array = $this->session->userdata('logged_in_user');
            $login_id = $session_array['id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
           $data['category']=$this->search_model->get_cpcategory();
           $data['subcategory']=$this->search_model->get_cpscategory();
           $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
           $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
           $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
           $data['results']=$this->search_model->get_search_by_key($key);
           $this->load->view('public/edit_search_product',$data,$key);
    }
    function get_search_recentcat($key){
            $session_array = $this->session->userdata('logged_in_user');
            $login_id = $session_array['id'];
            $data['wallet'] = $this->user_model->get_wallete_values_user($login_id);
            $data['channel_partner'] = $this->user_model->get_channel_partner();
            $data['wallet1'] = $this->user_model->get_totel_wallete_amount($login_id);
           $data['category']=$this->search_model->get_cpcategory();
           $data['subcategory']=$this->search_model->get_cpscategory();
           $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
           $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
           $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
           $data['results']=$this->search_model->get_search_by_key($key);
           $this->load->view('public/edit_search_product',$data,$key);
    }

            

    function get_product_details($pid){
        $data['default_assets'] = $this->load->view('templates/public/default_assets','',TRUE);
        $data['category']=$this->search_model->get_cpcategory();
        $data['subcategory']=$this->search_model->get_cpscategory();
        $data["header"] = $this->load->view("templates/public/public_header",$data,TRUE);
        $data['footer'] = $this->load->view('templates/public/public_footer','',TRUE);
        $data['results']=$this->search_model->get_search_by_product($pid);
        $this->load->view('public/edit_search_single_page',$data);
    }



}
