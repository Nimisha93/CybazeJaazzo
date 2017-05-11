<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Greeenindia </title>
    <link href="<?php echo base_url(); ?>assets/admin/images/fav.png" rel="shortcut icon">

    <!-- Bootstrap -->
    <link href="<?php echo base_url(); ?>assets/admin/css/bootstrap/bootstrap.min.css" rel="stylesheet">


    <!-- Font Awesome -->
    <link href="<?php echo base_url(); ?>assets/admin/css/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo base_url(); ?>assets/admin/css/tab-in-tab.css" rel="stylesheet">


    <!-- Custom styling plus plugins -->
    <link href="<?php echo base_url(); ?>assets/admin/css/custom.min.css" rel="stylesheet">

    <script src="<?php echo base_url(); ?>assets/admin/js/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo base_url(); ?>assets/admin/js/bootstrap/bootstrap.min.js"></script>

    <link rel="stylesheet" href="<?php echo base_url();?>assets/public/validation/css/validationEngine.jquery.css" type="text/css"/>

    <link rel="stylesheet" href="<?php echo base_url();?>assets/public/validation/css/template.css" type="text/css"/>


    <style>
        .body_blur {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 99999;
            background-color: rgba(0,0,0,0.4);
            background-image: url("<?php echo base_url(); ?>assets/admin/images/ajax-loader.gif");
            background-position: center;
            background-repeat: no-repeat;
            background-size: 30px 30px;
            display: none;
        }
    </style>



</head>
<div class="body_blur" style="display: none"></div>
