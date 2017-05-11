<?php

Class Report_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    //get_desigination_reports report hridya
function  get_desigination_reports()
    {


        $query="SELECT id, designation,description, sort_order, status,DATE_FORMAT(gp_pl_sales_designation_type.created_on,'%d-%b-%Y') as date_time   FROM  gp_pl_sales_designation_type
";
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

function get_channelpartner_reports()
    {
        $qry = "SELECT id, name, phone, phone2, email, fax, address,DATE_FORMAT(gp_pl_channel_partner.created_on,'%d-%b-%Y') as date_time  FROM gp_pl_channel_partner";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else
        {
            return array();
        }
    }



 

        function get_club_type_reports()
    {
        $qry = "SELECT id, title, description, amount, cash_limit, pooling_commision, DATE_FORMAT(club_member_type.created_on,'%d-%b-%Y') as date_time FROM club_member_type";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else
        {
            return array();
        }
    }

  function get_customer_reports()
    {
        $qry = "SELECT id,name,phone,phone2,email,address,DATE_FORMAT(gp_normal_customer.created_on,'%d-%b-%Y') as date_time FROM gp_normal_customer";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else
        {
            return array();
        }
    }




function get_club_members_reports()
    {
        $qry = "select
                club_member_type.id,
                gp_normal_customer.name,
                gp_normal_customer.phone,
                gp_normal_customer.phone2,
                gp_normal_customer.pincode,
                gp_normal_customer.address,
                 DATE_FORMAT(gp_normal_customer.created_on,'%d-%b-%Y') as date_time, 
                club_member_type.title,
                club_member_type.description,
                club_member_type.amount,
                club_member_type.cash_limit,
                club_member_type.pooling_commision
                
                from 
                club_member_type
                left join gp_normal_customer  on club_member_type.id = gp_normal_customer.club_type_id
                where gp_normal_customer.club_type_id != 0";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        } else{
            return array();
        }       
    }


function get_executives_reports()
    {
        $qry = "select
                gp_pl_sales_team_members.id,
                gp_pl_sales_team_members.sales_desig_type_id,
                gp_pl_sales_team_members.name,
                DATE_FORMAT(gp_pl_sales_team_members.created_on,'%d-%b-%Y') as date_time, 
                 
                gp_pl_sales_team_members.last_promotion_date,
                gp_pl_sales_designation_type.id,
                 gp_pl_sales_designation_type.description,
                  gp_pl_sales_designation_type.designation
               
                from 
                gp_pl_sales_team_members
                left join gp_pl_sales_designation_type  on gp_pl_sales_designation_type.id =gp_pl_sales_team_members.sales_desig_type_id";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        } else{
            return array();
        }       
    }





 function get_module_reports()
    {
        $qry = "SELECT id, module_name, description,privillage_group,email,image, DATE_FORMAT(gp_permission_module.created_on,'%d-%b-%Y') as date_time  FROM gp_permission_module";
        $qry = $this->db->query($qry);
        if($qry->num_rows()>0)
        {
            return $qry->result_array();
        }   else
        {
            return array();
        }
    }



}










