<!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Admin Panel Login</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url();?>assets/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo base_url();?>assets/css/font-awesome.min.css" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?php echo base_url();?>assets/css/custom.min.css" rel="stylesheet">
  </head>

  <body class="login">
	<div>
		<a class="hiddenanchor" id="signup"></a>
		<a class="hiddenanchor" id="signin"></a>
      <div class="login_wrapper">
        <div class="animate form login_form">
		<?php 
                //echo '<pre>';
             //   print_r($this->session->flashdata); exit;
                echo $this->session->flashdata('logout_msg');
                echo $this->session->flashdata('dispMessage');?>
          <section class="login_content">
			<?php
				echo form_open(base_url().'Adminpanel');
			?>
              <h1>Login Here</h1>
              <div class="form-group">
                <input type="text" placeholder="Email" name="email" required value="<?php echo set_value('email'); ?>" class="form-control"/>
              </div>
              <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="txt_password" required value="<?php echo set_value('txt_password'); ?>"/>
              </div>
              <div class="form-group">
                <input type="submit" class="btn btn-default" value="Log in">	
              </div>
              </div>
            <?php echo form_close();?>
          </section>
        </div>
      </div>
  </body>
</html>
	<script src="<?php echo base_url();?>assets/js/jquery.min.js"></script>
  <script src="<?php echo base_url();?>assets/js/common.js"></script>