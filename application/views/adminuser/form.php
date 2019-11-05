<?php
  $this->load->view('include/header');
  $this->load->view('include/leftsidemenu');
  
	defined('BASEPATH') OR exit('No direct script access allowed');
	error_reporting(0);
?>
<?php
	if($action == 'insert')
	{
		$btn = "Add";
	}
	else if($action == 'update')
	{
            $rightsArray = explode(',', $result[0]->rights);
		$btn = "Update";
	}
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
                    <h2><?php echo $btn.' '.$this->msgName;?></h2>
                    <div class="clearfix"></div>
                  </div>
                <div class="x_content">
                    <br />
                    <form action="<?php echo base_url().$this->controller.'/'.$action;?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					<input type="hidden" id="id" name="id" value="<?php echo $result[0]->id;?>">
					<input type="hidden" id="action" name="action" value="<?php echo $action?>">

					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="first_name">First Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="first_name" value="<?php echo $result[0]->first_name;?>" class="form-control col-md-7 col-xs-12" placeholder="First Name">
                        </div>
                      </div>
                                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="last_name">Last Name <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="last_name" value="<?php echo $result[0]->last_name;?>" class="form-control col-md-7 col-xs-12" placeholder="Last Name">
                        </div>
                      </div>
                                         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="email">Email <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="email" value="<?php echo $result[0]->email;?>" class="form-control col-md-7 col-xs-12 email" placeholder="Email">
                        </div>
                      </div>
                                        <?php if($action == 'insert') { ?>
                                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="email">Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" name="password" value="" class="form-control col-md-7 col-xs-12" placeholder="Password">
                        </div>
                      </div>
                                        <?php } else { ?>
                                                             <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="email">Password
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" name="new_password" value="" class="form-control col-md-7 col-xs-12" placeholder="Password">
                        </div>
                      </div>
                                        <?php } ?>
					  <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Mobile">Mobile No <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" maxlength="10" name="number" value="<?php echo $result[0]->mobile_no;?>" class="form-control col-md-7 col-xs-12" placeholder="Mobile No">
                        </div>
					  </div>
   
                                          <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="age_group">Client Rights
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                             <?php if (in_array(3, $rightsArray)) { ?>
                            <input type="checkbox" name="user" id="user" value="3" checked="">
                            <?php } else { ?>
                            <input type="checkbox" name="user" id="user" value="3">
                            <?php } ?>
                        </div>
					  </div>
                                        <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="age_group">Category Rights
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php if (in_array(4, $rightsArray)) { ?>
                            <input type="checkbox" name="category" id="category" value="4" checked="">
                            <?php } else { ?>
                            <input type="checkbox" name="category" id="category" value="4">
                            <?php } ?>
                        </div>
					  </div>
                                        
                                           <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="age_group">Product Rights
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php if (in_array(5, $rightsArray)) { ?>
                            <input type="checkbox" name="product" id="product" value="5" checked="">
                            <?php } else { ?>
                            <input type="checkbox" name="product" id="product" value="5">
                            <?php } ?>
                        </div>
					  </div>
                                        
                                           <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="age_group">Order Rights
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                              <?php if (in_array(6, $rightsArray)) { ?>
                            <input type="checkbox" name="order" id="order" value="6" checked="">
                            <?php } else { ?>
                            <input type="checkbox" name="order" id="order" value="6">
                            <?php } ?>
                        </div>
					  </div>
    
					  <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" id="submit1" class="btn btn-primary"><?php echo $btn;?></button>
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
    
    <?php
      echo $this->session->flashdata('edit_profile');
      echo $this->session->flashdata('Change_msg');
      echo $this->session->flashdata($this->msgDisplay);
    ?>
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
            <h3 class="box-title"><?php echo $btn.' '.$this->msgName;?></h3>
          </div>

          <div class="box-body">

            <form action="<?php echo base_url().$this->controller.'/'.$action;?>" method="post" id="demo-form2" onsubmit="return formvalidate();" data-parsley-validate class="form-horizontal form-label-left">

              <input type="hidden" id="id" name="id" value="<?php echo $result[0]->id;?>">
              <input type="hidden" id="action" name="action" value="<?php echo $action?>">

              <div class="form-group">
                  <label class="control-label col-md-3 col-sm-12 col-xs-12" for="first_name">
                    First Name <font color="red"><span class="required">*</span></font> :
                  </label>

                  <div class="col-md-9 col-sm-12 col-xs-12">
                    <input type="text" name="first_name" value="<?php echo $result[0]->first_name;?>" class="form-control" placeholder="First Name">
                  </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="last_name">
                  Last Name <font color="red">*</font> :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <input type="text" name="last_name" value="<?php echo $result[0]->last_name;?>" class="form-control" placeholder="Last Name">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="email">
                  Email <font color="red">*</font> :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <input type="text" name="email" value="<?php echo $result[0]->email;?>" class="form-control email" placeholder="Email">
                </div>
              </div>

              <?php
                if($action == 'insert') { 
              ?>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="password">
                      Password <font color="red">*</font> :
                    </label>

                    <div class="col-md-9 col-sm-12 col-xs-12">
                      <input type="password" name="password" value="" class="form-control" placeholder="Password">
                    </div>
                  </div>
              <?php 
                } else { 
              ?>
                  <div class="form-group">
                    <label class="control-label col-md-3 col-sm-12 col-xs-12" for="password">
                      Password <font color="red">*</font> :
                    </label>

                    <div class="col-md-9 col-sm-12 col-xs-12">
                      <input type="password" name="new_password" value="" class="form-control" placeholder="Password">
                    </div>
                  </div>
              <?php 
                } 
              ?>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="Mobile">
                  Mobile No <font color="red">*</font> :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <input type="text" maxlength="10" name="number" value="<?php echo $result[0]->mobile_no;?>" class="form-control" placeholder="Mobile No">
                </div>
              </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-12 col-xs-12" for="age_group">
                  Client Rights :
                </label>

                <div class="col-md-9 col-sm-12 col-xs-12">
                  <?php 
                    if (in_array(3, $rightsArray)) 
                    { 
                  ?>
                      <input type="checkbox" name="user" id="user" value="3" checked="">
                  <?php 
                    } else { 
                  ?>
                      <input type="checkbox" name="user" id="user" value="3">
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
                      <input type="checkbox" name="category" id="category" value="4" checked="">
                  <?php 
                    } else { 
                  ?>
                      <input type="checkbox" name="category" id="category" value="4">
                  <?php
                    } 
                  ?>
                </div>
					    </div>

              <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="age_group">
                    Product Rights :
                </label>

                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?php 
                    if (in_array(5, $rightsArray)) { 
                  ?>
                      <input type="checkbox" name="product" id="product" value="5" checked="">
                  <?php 
                    } else { 
                  ?>
                      <input type="checkbox" name="product" id="product" value="5">
                  <?php 
                    } 
                  ?>
                </div>
              </div>
                                        
              <div class="form-group">
						    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="age_group">
                  Order Rights :
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                  <?php 
                    if (in_array(6, $rightsArray)) {
                  ?>
                      <input type="checkbox" name="order" id="order" value="6" checked="">
                  <?php 
                    } else { 
                  ?>
                      <input type="checkbox" name="order" id="order" value="6">
                  <?php 
                    } 
                  ?>
                </div>
					    </div>
              <div class="box-footer">
                <input type="submit" id="submit1" name="submit" class="btn btn-primary" value="<?php echo $btn;?>">
              </div>
            </form>

          </div>
        </div>
        
      </div>
    </div>
  </section>
  <!-- Main content section end-->
</div>
<!-- Main Container end-->
<?php
	$this->load->view('include/footer');
?>
	<script>

		$(document).ready(function (){
                    jQuery.validator.addMethod("greaterThanZero", function(value, element) {
    var numericReg = /^(?:(?:\+|0{0,2})91(\s*[\-]\s*)?|[0]?)?[6789]\d{9}$/;
    if(!numericReg.test(value)) {
        return false;
    } else {
        return true;
    }
    
}, "Phone Number is invalid");

  // Add coustom code for validation email and number exist or not
  jQuery.validator.addMethod("synchronousRemote", function (value, element, param) {
    if (this.optional(element)) {
        return "dependency-mismatch";
    }

    var previous = this.previousValue(element);
    if (!this.settings.messages[element.name]) {
        this.settings.messages[element.name] = {};
    }
    previous.originalMessage = this.settings.messages[element.name].remote;
    this.settings.messages[element.name].remote = previous.message;

    param = typeof param === "string" && { url: param } || param;

    if (previous.old === value) {
        return previous.valid;
    }

    previous.old = value;
    var validator = this;
    this.startRequest(element);
    var data = {};
    data[element.name] = value;
    var valid = "pending";
    $.ajax($.extend(true, {
        url: param,
        async: false,
        mode: "abort",
        port: "validate" + element.name,
        dataType: "json",
        data: data,
        success: function (response) {
            validator.settings.messages[element.name].remote = previous.originalMessage;
            valid = response === true || response === "true";
            if (valid) {
                var submitted = validator.formSubmitted;
                validator.prepareElement(element);
                validator.formSubmitted = submitted;
                validator.successList.push(element);
                delete validator.invalid[element.name];
                validator.showErrors();
            } else {
                var errors = {};
                var message = response || validator.defaultMessage(element, "remote");
                errors[element.name] = previous.message = $.isFunction(message) ? message(value) : message;
                validator.invalid[element.name] = true;
                validator.showErrors(errors);
            }
            previous.valid = valid;
            validator.stopRequest(element, valid);
        }
    }, param));
    return valid;
}, "Please fix this field.");

           
    //for number
    jQuery.validator.addMethod("synchronousRemote_number", function (value, element, param) {
    if (this.optional(element)) {
        return "dependency-mismatch";
    }

    var previous = this.previousValue(element);
    if (!this.settings.messages[element.name]) {
        this.settings.messages[element.name] = {};
    }
    previous.originalMessage = this.settings.messages[element.name].remote;
    this.settings.messages[element.name].remote = previous.message;

    param = typeof param === "string" && { url: param } || param;

    if (previous.old === value) {
        return previous.valid;
    }

    previous.old = value;
    var validator = this;
    this.startRequest(element);
    var data = {};
    data[element.name] = value;
    var valid = "pending";
    $.ajax($.extend(true, {
        url: param,
        async: false,
        mode: "abort",
        port: "validate" + element.name,
        dataType: "json",
        data: data,
        success: function (response) {
            validator.settings.messages[element.name].remote = previous.originalMessage;
            valid = response === true || response === "true";
            if (valid) {
                var submitted = validator.formSubmitted;
                validator.prepareElement(element);
                validator.formSubmitted = submitted;
                validator.successList.push(element);
                delete validator.invalid[element.name];
                validator.showErrors();
            } else {
                var errors = {};
                var message = response || validator.defaultMessage(element, "remote");
                errors[element.name] = previous.message = $.isFunction(message) ? message(value) : message;
                validator.invalid[element.name] = true;
                validator.showErrors(errors);
            }
            previous.valid = valid;
            validator.stopRequest(element, valid);
        }
    }, param));
    return valid;
}, "Please fix this field.");

           jQuery.validator.addMethod("noSpace", function(value, element) {
return value == '' || value.trim().length != 0;  
    }, "No space please and don't leave it empty");
			
			
	});

  function formvalidate() {
    var id = $('input[name = "id"]').val();
    var action = $('input[name = "action"]').val();
  
  $('#demo-form2').validate({
        errorClass:"text-danger",
				rules:{
                                                first_name: {required: true,noSpace: true,},
                                                last_name: {required: true,noSpace: true,},
                                                password: {required: true,noSpace: true,},
                                                email:{
							required: true,
                                                        noSpace: true,
							synchronousRemote:{
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
                                                        noSpace: true,
							maxlength: 10,
                                                        greaterThanZero : true,
							synchronousRemote_number:{
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
							synchronousRemote: "Email Exist"
						},
						number: {
							required: "Please Enter Mobile Number",
							minlength: "Please Minimun enter 10 Charecter",
							maxlength: "Please Maximun enter 10 Charecter",
							synchronousRemote_number: "Contact Number Exist"
						}
						
					},
          submitHandler: function(form){
           form.submit();
         }
					// submitHandler: function(form){
                                            
          //   var user = $('#user:checkbox:checked').length;
          //   var category = $('#category:checkbox:checked').length;
          //   var product = $('#product:checkbox:checked').length;
          //   var order = $('#order:checkbox:checked').length;
          //   if (user == 0 && category == 0 && category == 0 && order == 0) {
          //     alert('Please select atleast one module for access');
          //     return false;
          //   }
					// 	form.submit();
					// }
		});

    if(!$('#demo-form2').valid())
    {
      return false;
    }else{
        var user = $('#user:checkbox:checked').length;
        var category = $('#category:checkbox:checked').length;
        var product = $('#product:checkbox:checked').length;
        var order = $('#order:checkbox:checked').length;
        if (user == 0 && category == 0 && product == 0 && order == 0) {
          alert('Please select atleast one module for access');
          return false;
        }
      return true;
    }
  }

	</script>
