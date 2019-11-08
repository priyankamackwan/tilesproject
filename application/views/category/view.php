<?php
	$this->load->view('include/header');
	$this->load->view('include/leftsidemenu');
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
                    <h2><?php echo $btn.' '.$this->msgName;?></h2>
                    <div class="clearfix"></div>
                  </div>
                <div class="x_content">
                    <br />
                    <form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/'.$action;?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
	
					  
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Category Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->name;?>
                        </div>
                      </div>
                         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="editor">Description
                        </label>
                                          
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php echo $result[0]->description;?>
                        </div>
                      </div>
                          <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_image">Uploaded Image
						</label>
						<div class="col-md-6 col-sm-6 col-xs-12">
							<img width="50px" height="50px" src="<?php echo base_url().'./assets/uploads/'.$result[0]->image;?>" style="background-color:navy;" >
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
						<h3 class="box-title"><?php echo $btn.' '.$this->msgName;?></h3>
					</div>

					<div class="box-body">
						<form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/'.$action;?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_name">
									Item Group Name :
								</label>
								<div class="col-md-9 col-sm-6 col-xs-6 mt_5">
									<?php echo $result[0]->name;?>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-6 col-xs-6" for="editor">
									Description :
								</label>
												
								<div class="col-md-9 col-sm-6 col-xs-6 mt_5">
									<?php echo $result[0]->description;?>
								</div>
							</div>

							<div class="form-group">
								<label class="control-label col-md-3 col-sm-6 col-xs-6" for="category_image">
									Item Group Image :
								</label>

								<div class="col-md-9 col-sm-6 col-xs-6 mt_5">
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
						name:{
							required: true,
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
						}
					
					},
					messages: {
						name: {
							required: "Please Enter Item Group",
							remote: "Item Group Name Exist"
						}
						
					},
					submitHandler: function(form){
						form.submit();
					}
		});
	});
	</script>