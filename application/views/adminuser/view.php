<?php
  $rightsArray = explode(',', $result[0]->rights);
  $this->load->view('include/leftsidemenu');
	$this->load->view('include/header');
	defined('BASEPATH') OR exit('No direct script access allowed');
	error_reporting(0);
?>

<!-- page content -->
        <!-- <div class="right_col" role="main">
		<div class="row">
            <div class="page-title">
              <div class="title_left">
					<a href="<?php echo base_url($this->controller);?>"class="btn btn-info">Back</a>
              </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $this->msgName;?></h2>
                    <div class="clearfix"></div>
                  </div>
                <div class="x_content">
                    <br />
                    <form action="<?php echo base_url().$this->controller.'/'.$action;?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="first_name">First Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                         <?php echo $result[0]->first_name;?>
                        </div>
                      </div>
                                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="last_name">Last Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->last_name;?>
                        </div>
                      </div>
                                         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->email;?>
                        </div>
                      </div>
                    
					  <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Mobile">Mobile No <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->mobile_no;?>
                        </div>
					  </div>
                                          <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="age_group">Client Rights
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                             <?php if (in_array(3, $rightsArray)) { ?>
                            <input type="checkbox" name="user" id="user" value="3" checked="" disabled="">
                            <?php } else { ?>
                            <input type="checkbox" name="user" id="user" value="3" disabled="">
                            <?php } ?>
                        </div>
					  </div>
                                        <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="age_group">Category Rights
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php if (in_array(4, $rightsArray)) { ?>
                            <input type="checkbox" name="category" id="category" value="4" checked="" disabled="">
                            <?php } else { ?>
                            <input type="checkbox" name="category" id="category" value="4" disabled="">
                            <?php } ?>
                        </div>
					  </div>
                          <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="product">Product Rights
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php if (in_array(5, $rightsArray)) { ?>
                            <input type="checkbox" name="product" id="product" value="5" checked="" disabled="">
                            <?php } else { ?>
                            <input type="checkbox" name="product" id="product" value="5" disabled="">
                            <?php } ?>
                        </div>
					  </div>
                          <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="order">Order Rights
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php if (in_array(6, $rightsArray)) { ?>
                            <input type="checkbox" name="order" id="order" value="6" checked="" disabled="">
                            <?php } else { ?>
                            <input type="checkbox" name="order" id="order" value="6" disabled="">
                            <?php } ?>
                        </div>
					  </div>
		
                    </form>
                  </div>
                </div>
              </div>
            </div>
            </div>
            </div> -->
        <!-- /page content -->

<!-- -------------------------------new design------------------------------- -->
<!-- Main Container start-->
<div class="content-wrapper">

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <a href="<?php echo base_url($this->controller);?>"class="btn btn-info">Back</a>
    <!-- <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i>Home</a></li>
      <li class="active">Users</li>
    </ol> -->
  </section>

  <!-- Main content section start-->
  <section class="content">
    <div class="row">
      <div class="col-md-9 col-sm-12 col-xs-12">

        <div class="box box-primary">
          <div class="box-header">
            <h3 class="box-title"><?php echo $this->msgName;?></h3>
          </div>

          <div class="box-body">
            <form action="<?php echo base_url().$this->controller.'/'.$action;?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="first_name">
                  First Name : 
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->first_name;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="last_name">
                  Last Name :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->last_name;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="email">
                  Email :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->email;?>
                </div>
              </div>
                    
              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="Mobile">
                  Mobile No :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php echo $result[0]->mobile_no;?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="age_group">
                  Client Rights :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php 
                    if (in_array(3, $rightsArray)) { 
                  ?>
                      <input type="checkbox" name="user" id="user" value="3" checked="" disabled="">
                  <?php 
                    } else { 
                  ?>
                      <input type="checkbox" name="user" id="user" value="3" disabled="">
                  <?php 
                    } 
                  ?>
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="age_group">
                  Category Rights :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php 
                    if (in_array(4, $rightsArray)) { 
                  ?>
                      <input type="checkbox" name="category" id="category" value="4" checked="" disabled="">
                  <?php 
                    } else { 
                  ?>
                      <input type="checkbox" name="category" id="category" value="4" disabled="">
                  <?php 
                    } 
                  ?>
                </div>
              </div>

              <div class="form-group">
						    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="product">
                  Product Rights :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php 
                    if (in_array(5, $rightsArray)) { 
                  ?>
                      <input type="checkbox" name="product" id="product" value="5" checked="" disabled="">
                  <?php 
                    } else { 
                  ?>
                    <input type="checkbox" name="product" id="product" value="5" disabled="">
                  <?php 
                    } 
                  ?>
                </div>
					    </div>

              <div class="form-group">
						    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="order">
                  Order Rights :
                </label>
                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php 
                    if (in_array(6, $rightsArray)) { 
                  ?>
                      <input type="checkbox" name="order" id="order" value="6" checked="" disabled="">
                  <?php 
                    } else { 
                  ?>
                    <input type="checkbox" name="order" id="order" value="6" disabled="">
                  <?php
                    } 
                  ?>
                </div>
              </div>           
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>

<?php
	$this->load->view('include/footer');
?>
	<script>
		$(document).ready(function (){
			var id = $('input[name = "id"]').val();
			var action = $('input[name = "action"]').val();
			$('#demo-form2').validate({
				rules:{
                                                first_name: "required",
                                                last_name: "required",
                                                password: "required",
                                                email:{
							required: true,
							remote:{
								url:"<?php echo base_url().$controller."/checkemail";?>",
								type:"post",
								data:{
									id:id,
									action: action,
									number: function(){
										return $('input[name = "email"]').val();
									},
								},
							}
						},
						number:{
							required: true,
							minlength: 10,
							maxlength: 10,
							remote:{
								url:"<?php echo base_url().$controller."/checknumber";?>",
								type:"post",
								data:{
									id:id,
									action: action,
									number: function(){
										return $('input[name = "number"]').val();
									},
								},
							}
						}
					
					},
					messages: {
                                                email: {
							required: "Please Enter Email",
							remote: "Email Exist"
						},
						number: {
							required: "Please Enter Mobile Number",
							minlength: "Please Minimun enter 10 Charecter",
							maxlength: "Please Maximun enter 10 Charecter",
							remote: "Contact Number Exist"
						}
						
					},
					submitHandler: function(form){
                                                var businessuser = $('#business_user:checkbox:checked').length;
                                                var user = $('#user:checkbox:checked').length;
                                                var category = $('#category:checkbox:checked').length;
                                                if (businessuser == 0 && user == 0 && category == 0) {
                                                 alert('Please select atleast one module for access');
                                                 return false;
                                                }
						form.submit();
					}
		});
	});
	</script>
