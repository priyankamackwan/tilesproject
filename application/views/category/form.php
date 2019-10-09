<?php
	$this->load->view('include/leftsidemenu');
	$this->load->view('include/header');
	defined('BASEPATH') OR exit('No direct script access allowed');
	error_reporting(0);
?>
<?php
	if($action == 'insert')
	{
		$btn = "Save";
	}
	else if($action == 'update')
	{
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
                    <form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/'.$action;?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					<input type="hidden" id="id" name="id" value="<?php echo $result[0]->id;?>">
                                       <input type="hidden" id="action" name="action" value="<?php echo $action?>">
					  
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Category Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="name" value="<?php echo $result[0]->name;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Your Category Name">
                        </div>
                      </div>
                                                 <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="editor">Description
                        </label>
                                          
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea name="description" id="answer"><?php echo $result[0]->description;?></textarea>
                        </div>
                      </div>
                            <?php if($action == "insert"){ ?>
                                         <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_image">Category Image<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" name="image" class="form-control numberonly col-md-7 col-xs-12">
                        </div>
					  </div>
                                       <?php } ?>
                                                 <?php if($action == "update"){ ?>
                                         <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_image">Category Image<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" name="updated_image" class="form-control numberonly col-md-7 col-xs-12">
                        </div>
					  </div>
					  <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_image">Uploaded Image
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<img width="50px" height="50px" src="<?php echo base_url().'./assets/uploads/'.$result[0]->image;?>" style="background-color:navy;" >
						</div>
					  </div>
					  <?php } ?>
                                        

					  <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-primary"><?php echo $btn;?></button>
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

						<form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/'.$action;?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

							<input type="hidden" id="id" name="id" value="<?php echo $result[0]->id;?>">
							<input type="hidden" id="action" name="action" value="<?php echo $action?>">

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_name">
									Category Name<font color="red"><span class="required">*</span></font> :
								</label>

								<div class="col-md-9 col-sm-12 col-xs-12">
									<input type="text" name="name" value="<?php echo $result[0]->name;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Your Category Name">
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-12 col-xs-12" for="description">
									Description :
								</label>
												
								<div class="col-md-9 col-sm-12 col-xs-12">
									<textarea class="form-control" rows="3" placeholder="Description" name="description" id="answer"><?php echo $result[0]->description;?></textarea>
								</div>
							</div>

							<?php 
								if($action == "insert"){ 
							?>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_image">
											Category Image<font color="red"><span class="required">*</span></font> :
										</label>
										<div class="col-md-9 col-sm-12 col-xs-12">
											<input type="file" name="image" class="form-control numberonly col-md-7 col-xs-12">
										</div>
									</div>
							<?php 
								} 
							?>
							<?php 
								if($action == "update"){ 
							?>
									<div class="form-group">
										<label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_image">
											Category Image<font color="red"><span class="required">*</span></font> :
										</label>

										<div class="col-md-9 col-sm-12 col-xs-12">
											<input type="file" name="updated_image" class="form-control numberonly">
										</div>
									</div>

									<div class="form-group">
										<label class="control-label col-md-3 col-sm-12 col-xs-12" for="category_image">
											Uploaded Image :
										</label>

										<div class="col-md-9 col-sm-12 col-xs-12">
											<?php
												if (!empty($result[0]->image) && file_exists(FCPATH.'assets/uploads/'.$result[0]->image)) {
													$image = base_url().'./assets/uploads/'.$result[0]->image;
												}else{
													$image =  base_url().'./assets/default.png';
												}
											?>
											
											<img width="50px" height="50px" src="<?php echo $image;?>" style="background-color:navy;" >
										</div>
									</div>
							<?php
								} 
							?>
							<div class="box-footer">
								<input type="submit" class="btn btn-primary" value="<?php echo $btn;?>">
							</div>
							<!-- <div class="form-group">
								<div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
								<button type="submit" class="btn btn-primary"><?php //echo $btn;?></button>
								</div>
							</div> -->
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
			var action = $('input[name = "action"]').val();
			$('#demo-form2').validate({
				errorClass:"text-danger",
				rules:{
                                     image:{
							required: true,
                                                    },
						name:{
							required: true,
                                                        noSpace: true,
							remote:{
								url:"<?php echo base_url().$controller."/checkname";?>",
								type:"post",
								data:{
									id:id,
									action: action,
									name: function(){
										return $('input[name = "name"]').val();
									},
								},
							}
						},
                                                 description:{noSpace: true,},   
					},
					messages: {
                                                
						name: {
							required: "Please Enter Category",
							remote: "Category Name Exist"
						}
						
					},
					submitHandler: function(form){
						form.submit();
					}
		});
	});
	</script>