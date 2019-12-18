<?php
  $logged = $this->userhelper->current();
  $this->load->view('include/header');
  $this->load->view('include/leftsidemenu');        
?>
<?php
/*
<!-- page content -->
        <!-- <div class="right_col" role="main">
          <div class="row">
            <div class="page-title"> -->
              <!--<div class="title_left">
					<a href="<?php echo base_url();?>"class="btn btn-info">Back</a>
              </div>-->
            <!-- </div>
            <div class="clearfix"></div>
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $msgName;?></h2>
                    <div class="clearfix"></div>
                  </div>
                <div class="x_content">
                    <br />
                    <form action="<?php echo base_url($controller.'/'.$action);?>" method="post" id="changeform" data-parsley-validate class="form-horizontal form-label-left">
                        <input type="hidden" id="id" name="id" value="<?php echo $logged['id'];?>">
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="Old Password">Old Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" name="oldpassword" class="form-control col-md-7 col-xs-12" placeholder="Enter Your Old Password">
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="New Password">New Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" name="newpassword" id="password" class="form-control col-md-7 col-xs-12" placeholder="Enter Your New Password">
                        </div>
                      </div>
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="Confirm Password">Confirm Password <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="password" name="confirmpassword" class="form-control col-md-7 col-xs-12" placeholder="Enter Your Confirm Password">
                        </div>
                      </div>
					  <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" id="submit" class="btn btn-primary"><?php echo $btn;?></button>
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
*/
?>
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
              <h3 class="box-title"><?php echo $msgName;?></h3>
            </div>

            <div class="box-body">

              <form action="<?php echo base_url($controller.'/'.$action);?>" method="post" id="changeform" data-parsley-validate class="form-horizontal form-label-left">

                <input type="hidden" id="id" name="id" value="<?php echo $logged['id'];?>">

                <div class="form-group">
                  <label class="control-label col-md-3 col-sm-12 col-xs-12" for="Old Password">
                    Old Password <font color="red"><span class="required">*</span></font>
                  </label>

                  <div class="col-md-9 col-sm-12 col-xs-12">
                    <input type="password" name="oldpassword" class="form-control col-md-7 col-xs-12" placeholder="Enter Your Old Password">
                  </div>
                </div>
					      <div class="form-group">

                  <label class="control-label col-md-3 col-sm-12 col-xs-12" for="New Password">
                    New Password <font color="red"><span class="required">*</span></font>
                  </label>

                  <div class="col-md-9 col-sm-12 col-xs-12">
                    <input type="password" name="newpassword" id="password" class="form-control" placeholder="Enter Your New Password">
                  </div>
                </div>
					      <div class="form-group">
                  <label class="control-label col-md-3 col-sm-12 col-xs-12" for="Confirm Password">
                    Confirm Password  <font color="red"><span class="required">*</span></font>
                  </label>

                  <div class="col-md-9 col-sm-12 col-xs-12">
                    <input type="password" name="confirmpassword" class="form-control" placeholder="Enter Your Confirm Password">
                  </div>
                </div>

                <div class="box-footer">
                  <input type="submit" id="submit" class="btn btn-primary" value="<?php echo $btn;?>">
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
                jQuery.validator.addMethod("noSpace", function(value, element) {
return value == '' || value.trim().length != 0;  
    }, "No space please and don't leave it empty");
		var id = $('input[name = "id"]').val();
		//alert(id);
		$('#changeform').validate({
      errorClass:'text-danger',
			rules: {
				oldpassword: {
					required: true,
                                        noSpace: true,
					remote:{
					url:"<?php echo base_url().$controller."/checkpassword";?>",
						type:"post",
						data:{
							id: id,
							oldpassword: function()
							{
								return $('input[name = "oldpassword"]').val();
							},
						},
					},
				},
				newpassword: {
					required: true,
                                noSpace: true,
					minlength: 6
				},
				confirmpassword: {
					required: true,
                                noSpace: true,
					equalTo: "#password"
				}
			},
			messages: {
				oldpassword:{
					required: "Please Enter Old Password",
					remote: "Please Enter Your Correct Password"
					
				},
				newpassword: {
					required: "Please Enter New Password",
					minlength: "Please Minimum Enter 6 Charecter"
				},
				confirmpassword: {
					required: "Please Enter Confirm Password",
					equalTo: "Don't Match Password"
				}
			},
			submithandler: function(form){
				form.submit(); 
			}
		});
	});
</script>