<?php //echo $this->userhelper->current('is_logged'); exit; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Panel</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-timepicker/0.5.2/css/bootstrap-timepicker.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/mycss.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet">
    <!-- bootstrap-progressbar -->
    <link href="<?php echo base_url();?>assets/css/bootstrap-progressbar-3.3.4.min.css" rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href="<?php echo base_url();?>assets/css/daterangepicker.css" rel="stylesheet">
	<!-- bootstrap-datetimepicker -->
	<link rel="stylesheet" href="<?php echo base_url();?>assets/css/bootstrap-datepicker3.css"/>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
    <link href="<?php echo base_url();?>assets/css/bootstrap-datetimepicker.css" rel="stylesheet">
	
	<!-- sweetalert CSS -->
	<link href="<?php echo base_url();?>assets/css/sweetalert.min.css" rel="stylesheet">
	
	<!-- Datatable -->
	<link href="<?php echo base_url();?>assets/css/dataTables.bootstrap.min.css" rel="stylesheet">
	
	<!--Select Style -->
	<link href="<?php echo base_url();?>assets/css/select2.min.css" rel="stylesheet">
	
	<!--Copy Data-->
	<link href="<?php echo base_url();?>assets/css/buttons.bootstrap.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>assets/css/custom.min.css" rel="stylesheet">
	
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0; text-align: center">
                <a  href="" class="site_title"></a>
            </div>

            <div class="clearfix"></div>

            <!-- sidebar menu -->
            <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
              <div class="menu_section">
                <ul class="nav side-menu">
                    <?php if ($this->userhelper->current('role_id') == 1) { ?>
                        <li><a href="<?php echo base_url();?>Adminuser"><i class="fa fa-user-plus"></i>Admin Users</a></li>
                        <?php }  if (in_array('3',$this->userhelper->current('rights'))) { ?>
                        <li><a href="<?php echo base_url();?>User"><i class="fa fa-user"></i>Contacts</a></li>
                        <?php } if (in_array('4',$this->userhelper->current('rights'))) { ?>
                        <li><a href="<?php echo base_url();?>Category"><i class="fa fa-tag"></i>Item Group</a></li>
                        
                        <?php } if (in_array('5',$this->userhelper->current('rights'))) { ?>
                        <li><a href="<?php echo base_url();?>Product"><i class="fa fa-tag"></i>Items</a></li>
                        <?php } if (in_array('6',$this->userhelper->current('rights'))) { ?>
                        <li><a href="<?php echo base_url();?>Order"><i class="fa fa-tag"></i>Sales Order</a></li>
                        <?php } if (in_array('6',$this->userhelper->current('rights'))) { ?>
                        <li><a href="<?php echo base_url();?>Customer_report"><i class="fa fa-tag"></i>Customer Reports</a></li>
                        <li><a href="<?php echo base_url();?>Sales_report"><i class="fa fa-tag"></i>Sales Reports</a></li>
                        <li><a href="<?php echo base_url();?>Expense_report"><i class="fa fa-tag"></i>Expense Reports</a></li>
                        <?php } ?>
                </ul>
              </div>
            </div>
            <!-- /sidebar menu -->
          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
          <div class="nav_menu">
            <nav>
              <div class="nav toggle testing">
                <a id="menu_toggle"><i class="fa fa-bars"></i></a>
              </div>

              <ul class="nav navbar-nav navbar-right">
                <li class="">
                  <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <?php 
					echo $this->userhelper->current('first_name').' '.$this->userhelper->current('last_name');?>
                    <span class=" fa fa-angle-down"></span>
                  </a>
                  <ul class="dropdown-menu dropdown-usermenu pull-right">
                        <li><a href="<?php echo base_url();?>Change_password">Change Password</a></li>
                        <li><a href="<?php echo base_url();?>Logout"><i class="fa fa-sign-out pull-right"></i> Log Out</a></li>
                    </ul>
                </li>
              </ul>
            </nav>
          </div>
        </div>
        <!-- /top navigation -->
		