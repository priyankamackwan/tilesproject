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
                    <form enctype="multipart/form-data" action="<?php echo base_url().$this->controller.'/Update'?>" method="post" id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
	<input type="hidden" id="id" name="id" value="<?php echo $result[0]->id;?>">
					  
					  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Product Name
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $Product['name'];?>
                        </div>
                      </div>
                        	  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">User Name
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $User[0]['company_name'];?>
                        </div>
                      </div>
                        	  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Price
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->price;?>
                        </div>
                      </div>
                        	  <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Quantity
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $Product['quantity'];?>
                        </div>
                      </div>
        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Tax
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->tax;?>
                        </div>
                      </div>
         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Total Price
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->total_price;?>
                        </div>
                      </div>
         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">LPO No
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->lpo_no;?>
                        </div>
                      </div>
        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Do No
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->do_no;?>
                        </div>
                      </div>
        
         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Invoice No
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->invoice_no;?>
                        </div>
                      </div>
        
         <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Cargo
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->cargo;?>
                        </div>
                      </div>
        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Cargo Number
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->cargo_number;?>
                        </div>
                      </div>
        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Location
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->location;?>
                        </div>
                      </div>
        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="category_name">Mark
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <?php echo $result[0]->mark;?>
                        </div>
                      </div>
                        
                          <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="sales_expense">Sales Expense
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" name="sales_expense" value="<?php echo $result[0]->sales_expense;?>" class="form-control col-md-7 col-xs-12" placeholder="Enter Sales Expense">
                        </div>
                      </div>
        
        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-6 col-xs-12" for="order_status">Order Status
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select name="status">
                                <?php 
                                
                                if ($result[0]->status == 0) { ?>
                                <option value="0" selected="selected">Pending</option>
                                } else { ?>
                                <option value="0">Pending</option>
                                <?php } ?>
                                  <?php if ($result[0]->status == 1) { ?>
                                <option value="1" selected="selected">In Progress</option>
                                } else { ?>
                                <option value="1">In Progress</option>
                                <?php } ?>
                                  <?php if ($result[0]->status == 2) { ?>
                                <option value="2" selected="selected">Completed</option>
                                } else { ?>
                               <option value="2">Completed</option>
                                <?php } ?>
                                
                                
                            </select>
                        </div>
                      </div>
                        		  <div class="ln_solid"></div>
                      <div class="form-group">
                        <div class="col-md-9 col-sm-6 col-xs-12 col-md-offset-3">
                          <button type="submit" class="btn btn-primary">Submit</button>
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