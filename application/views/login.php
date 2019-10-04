<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Panel Login</title>

    <link rel="icon" href="<?php echo base_url().'./assets/webTitleIcon.png';?>" type="image/gif" sizes="16x16">

    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="<?php echo $this->config->item("base_url").'/assets/bootstrap/css/bootstrap.min.css'; ?>">

    <link rel="stylesheet" href="<?php echo $this->config->item("base_url").'/assets/dist/css/AdminLTE.min.css'; ?>">

    <link rel="stylesheet" href="<?php echo $this->config->item("base_url").'/assets/plugins/iCheck/square/blue.css'; ?>">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">

    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
  </head>

  <style type="text/css">

    .customLink:link {
        font-size: 16px;
        padding-top: 10px;
        color: #337ab7;
        float: right;
    }

    /* mouse over link */
    .customLink:hover {
        color: red;
        text-decoration: underline;
    }

    .custom_button {
      border-radius: 0;
      -webkit-box-shadow: none;
      -moz-box-shadow: none;
      box-shadow: none;
      border-width: 1px;
    }

    span.required{
      color: red;
    }

    #error_message{
        background: #F3A6A6;
    }

    #success_message{
        background: #10c710;
    }

    .ajax_response {
      padding: 10px 20px;
      border: 0;
      display: inline-block;
      margin-top: 20px;
      margin-bottom: 20px;
      margin-left: 50px;
      cursor: pointer;
      display:none;
      color:#555;
    }

    .erroralert {
      margin-top: 20px;
      margin-left: 0px;
      width: 100%;
      padding: 10px;
      background-color: #f44336;
      color: white;
      margin-bottom: 0px;
      border-radius: 5px;
    }

    .successalert{
      margin-top: 20px;
      margin-left: 0px;
      width: 100%;
      padding: 10px;
      background-color: #4CAF50;
      color: white;
      margin-bottom: 0px;
      border-radius: 5px;
    }

    .warningalert{
      margin-top: 20px;
      margin-left: 0px;
      width: 100%;
      padding: 10px;
      background-color: #ff9800;;
      color: white;
      margin-bottom: 0px;
      border-radius: 5px;
    }

    .closebtn {

        margin-left: 15px;
        color: white;
        font-weight: bold;
        float: right;
        font-size: 22px;
        line-height: 20px;
        cursor: pointer;
        transition: 0.3s;
    }

    .closebtn:hover {
        color: black;
    }
  </style>

  <body class="hold-transition login-page">
    <div class="login-box" style="margin-top: 0%;">

      <div class="login-logo" style="margin-bottom:0px;">
        <img src="<?php echo base_url().'./assets/loginLogo.png';?>" alt="PNP Tiles" width="250px;">
      </div>
      
      <div class="login-box-body">
        <?php        
          echo $this->session->flashdata('logout_msg');
          echo $this->session->flashdata('dispMessage');
        ?>
        <p class="login-box-msg">Sign in to start your session</p>

        <?php
          echo form_open(base_url().'Adminpanel');
        ?>
          <div class="form-group has-feedback">
            <input type="text" placeholder="Email" name="email" required value="<?php echo set_value('email'); ?>" class="form-control"/>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>

          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="Password" name="txt_password" required value="<?php echo set_value('txt_password'); ?>"/>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>

          <div class="row">
            <div class="col-xs-6">
              <input type="submit" name="submit" value="Sign In" class="btn btn-primary btn-block btn-flat"> 
            </div>
          </div>
        <?php
          echo form_close();
        ?> 
      </div>
    </div>
    <!-- /.login-box -->

    <!-- jQuery 2.2.3 -->
    <script type = 'text/javascript' src = "<?php echo $this->config->item("base_url").'/assets/plugins/jQuery/jquery-2.2.3.min.js'?>"></script>
    <script type = 'text/javascript' src = "<?php echo $this->config->item("base_url").'/assets/bootstrap/js/bootstrap.min.js'?>"></script>
    <script type = 'text/javascript' src = "<?php echo $this->config->item("base_url").'/assets/plugins/iCheck/icheck.min.js'?>"></script>

    <script type="text/javascript">  
      function valid(){  

        var email=document.form.email.value;
        var password=document.form.txt_password.value;
      

        var status=false; 
        var status=true;
      
        if(email==''){
          alert("Email is empty");
          return false;
        }
        if(password==''){
          alert("password is empty");
          return false;
        }
      
        return status;  
      }

      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>