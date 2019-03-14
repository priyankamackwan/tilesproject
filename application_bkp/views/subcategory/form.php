<?php

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
					<input type="hidden" id="id" name="id" value="<?php echo $result[0]->id;?>">
                                       <input type="hidden" id="action" name="action" value="<?php echo $action?>">
					  
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Sub Category Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="name" value="<?php echo $result[0]->name;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Sub Category Name">
                        </div>
                      </div>
                                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="categories">Select Category<span class="required">*</span>
                        </label>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                          <select class="js-example-basic-multiple" name="categories">
                              <?php for($i=0;$i<count($categories);$i++) { 
                              if ($categories[$i]['id'] == $result[0]->category_id) { ?>
                              <option value="<?php echo $categories[$i]['id'];?>" selected=""><?php echo $categories[$i]['name'];?></option>
                              <?php } else { ?>
                               <option value="<?php echo $categories[$i]['id'];?>"><?php echo $categories[$i]['name'];?></option>
                              <?php } }?>
</select>
                                              <div class="error-message-category">
                                                  
                                              </div>
                        </div>
                                       </div>
                                                 <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="editor">Description
                        </label>
                                          
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <textarea name="description" id="answer" placeholder="Enter Description"><?php echo $result[0]->description;?></textarea>
                        </div>
                      </div>
                                       
                                                    <?php if($action == "insert"){ ?>
                                         <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_image">Sub Category Image<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="file" name="image" class="form-control numberonly col-md-7 col-xs-12">
                        </div>
					  </div>
                                       <?php } ?>
                                                 <?php if($action == "update"){ ?>
                                         <div class="form-group">
						<label class="control-label col-md-3 col-sm-3 col-xs-12" for="category_image">Sub Category Image<span class="required">*</span>
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
                                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="height">Height
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="height" value="<?php echo $result[0]->height;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Height">
                        </div>
                      </div>
                                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="width">Width
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="width" value="<?php echo $result[0]->width;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Width">
                        </div>
                      </div>
                                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="unit">Unit
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="unit" value="<?php echo $result[0]->unit;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Unit">
                        </div>
                      </div>

                                        

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
            </div>
        <!-- /page content -->
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
				rules:{
                                     image:{
							required: true,
                                                    },
						name:{
							required: true,
                                                        noSpace: true,
						},
                                                categories:{
							required: true,
						},
                                                description:{
							 noSpace: true,
						},
                                                size:{
							 noSpace: true,
						}
                                                
					
					},
					messages: {
                                                
						name: {
							required: "Please Enter Sub Category",
						},
                                                categories: {
							required: "Please Enter Category",
						}
						
					},
                                        errorPlacement: function (error, element) {
                if (element.attr("name") == "categories")
                {
                    // error.insertAfter(".icheckbox_flat-blue");
                    error.appendTo(".error-message-category");

                }  else {
                    error.insertAfter(element);
                }

            },
					submitHandler: function(form){
						form.submit();
					}
		});
	});
	</script>