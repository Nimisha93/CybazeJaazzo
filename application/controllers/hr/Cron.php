<?php


class Cron extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('hr/Mdl_recruitment','hr/Mdl_employee'));


    }
    function cron()
    {
         $this->Mdl_recruitment->get_birthday();
    }
}
?>