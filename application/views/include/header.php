<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Admin Panel </title>

  <link rel="icon" href="<?php echo base_url().'assets/favicon-32x32.png';?>" type="image/gif" sizes="16x16">

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="<?php echo base_url().'assets/bootstrap/css/bootstrap.min.css'?>"/>

  <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/select2/select2.min.css'?>"/>

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

  <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/timepicker/bootstrap-timepicker.min.css'?>"/>
 
  <link rel="stylesheet" href="<?php echo base_url().'assets/plugins/daterangepicker/daterangepicker.css' ?>">

  <link rel="stylesheet" href="<?php echo base_url().'assets/dist/css/AdminLTE.min.css'?>"/>
<!-- Fro Two icons show commnet below css -->
  <!-- <link rel="stylesheet" type="text/css"  href ="<?php //echo base_url();?>assets/plugins/datatables/dataTables.bootstrap.min.css"> -->

<!-- Use For export button -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url();?>assets/plugins/datatables/buttons.dataTables.min.css">
  <link rel="stylesheet" href="<?php echo base_url().'assets/dist/css/skins/_all-skins.min.css'?>"/>

  <!-- sweetalert CSS -->
  <link href="<?php echo base_url();?>assets/css/sweetalert.min.css" rel="stylesheet">
  
  <link href="<?php echo base_url();?>assets/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet">
  
  <style>
    #dataTables {
        font-size: 14px;
    }
    .dt-buttons{
      margin-left: 10px;
    }
  </style>
 
</head>

<body class="hold-transition skin-blue sidebar-mini">

  <!--  -->
  <div class="wrapper">

    <header class="main-header">
      <!-- Logo -->
      <a href="<?php  echo $this->config->item("base_url").'/dashboard'; ?>" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>PNP</b></span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>PNP Tiles</b></span>
      </a>

      <!-- Header Navbar: style can be found in header.less -->
      <nav class="navbar navbar-static-top">
      
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
          <!-- <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span> -->
        </a>

        <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          <!-- User Account: style can be found in dropdown.less -->
          <li class="dropdown user user-menu">
            <a href="javascript:void();" id="profile" class="dropdown-toggle user-profile" data-toggle="dropdown">
              <?php 
                echo ucfirst($this->userhelper->current('first_name').' '.$this->userhelper->current('last_name'));
              ?>
              <span class=" fa fa-angle-down"></span>
            </a>
            <ul class="dropdown-menu">
              <!-- Menu Footer-->
              <li class="user-footer">
                <a href="<?php echo base_url();?>Change_password" class="btn btn-default btn-flat">Change Password</a>
              
                <a href="<?php echo base_url();?>Logout"class="btn btn-default btn-flat">Log Out  <i class="fa fa-sign-out"></i></a>
              </li>
            </ul>
          </li>
          
        </ul>
      </div>
      </nav>
    </header>