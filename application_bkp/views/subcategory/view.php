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
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Sub Category Name<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->name;?>
                        </div>
                      </div>
                                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="categories">Select Category<span class="required">*</span>
                        </label>
                                          <div class="col-md-6 col-sm-6 col-xs-12">
                                              <select class="js-example-basic-multiple" name="categories" disabled="">
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
                           <?php echo $result[0]->description;?>
                        </div>
                      </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="height">Height
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->height;?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="width">Width
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->width;?>
                        </div>
                      </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="unit">Unit
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->unit;?>
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
	