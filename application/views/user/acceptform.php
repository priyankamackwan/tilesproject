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
                    Please provide client type
                <div class="x_content">
                    <br />
                    <form action="<?php echo base_url().$this->controller.'/accept';?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
					<input type="hidden" id="id" name="id" value="<?php echo $id;?>">
  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="client_type">Client Type<span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="js-example-basic-multiple" name="client_type" id="client_type">
                         <?php if ($client_type == 1) { ?>
                                <option value="1" selected="">Cash</option>
                         <?php } else { ?>
                                <option value="1">Cash</option>
                         <?php } ?>
                        <?php if ($client_type == 2) { ?>
                                <option value="2" selected="">Credit</option>
                         <?php } else { ?>
                               <option value="2">Credit</option>
                         <?php } ?>
                                
                        <?php if ($client_type == 3) { ?>
                               <option value="3"selected="">Walkin</option>
                        <?php } else { ?>
                                 <option value="3">Walkin</option>
                        <?php } ?>
                             
                        <?php if ($client_type == 4 && $this->userhelper->current('role_id') == 1)  { ?>
                               <option value="4"selected="">Flexible Rate</option>
                        <?php } else { ?>
                                 <option value="4">Flexible Rate</option>
                        <?php } ?>
                             
                             
</select>
                        </div>
                      </div>
					
                           
					  <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" id="submit1" class="btn btn-primary">Submit</button>
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
	
