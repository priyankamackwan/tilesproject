<?php
	$this->load->view('include/header');
	defined('BASEPATH') OR exit('No direct script access allowed');
	error_reporting(0);
?>

<!-- page content -->
        <div class="right_col" role="main">
		<div class="row">
            <div class="page-title">
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
					  <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="Mobile">Mobile No <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" maxlength="10" name="number" value="<?php echo $result[0]->mobile_no;?>" class="form-control col-md-7 col-xs-12" placeholder="Mobile No">
                        </div>
					  </div>
                                       
					  <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" id="submit1" class="btn btn-primary">Update</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
            </div>
            </div>
        <!-- /page content -->
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
                                              
						form.submit();
					}
		});
	});
	</script>
