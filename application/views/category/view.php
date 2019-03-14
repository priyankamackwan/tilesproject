<?php
	$this->load->view('include/header');
	defined('BASEPATH') OR exit('No direct script access allowed');
	error_reporting(0);
?>

<!-- page content -->
        <div class="right_col" role="main">
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